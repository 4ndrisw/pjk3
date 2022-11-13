<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * get client details for a call log
 * @since  2.2.0
 * @param  mixed  $id call id
 * @return boolean
 */
// function get_call_log_for($id = null) {
//    if(!$id) return false;

// 	$CI = &get_instance();

// 	$CI->db->select('*');
// 	$CI->db->where('staffid', $id);
// 	$staff = $CI->db->get('tblstaff')->row();

// 	if (!$staff) {
// 		return false;
// 	}

// 	return array('fullname'=> $staff->firstname . ' ' . $staff->lastname, 'staffid' => $staff->staffid);
// }

// function get_driver_name_by_id($id) {
// 	$CI =& get_instance();
// 	$row = $CI->db->select('firstname,lastname')->where('staffid',$id)->get('tblstaff')->row();
// 	return $row->firstname.' '.$row->lastname;
// }
// function get_roles() {
// 	$CI = &get_instance();
// 	$query = $CI->db->get('tblroles');
// 	return $query->result();
// }
// function get_role_id_by_name($role_name) {
// 	$CI = &get_instance();
// 	return $CI->db->select('roleid')->where('name',$role_name)->get('tblroles')->row()->roleid;
// }



/**
 * Get predefined tabs array, used in customer profile
 * @return array
 */
function get_pjk3_profile_tabs()
{
    return get_instance()->app_tabs->get_customer_profile_tabs();
}

//client_filtered_visible_tabs

/**
 * Filter only visible tabs selected from the profile and add badge
 * @param  array $tabs available tabs
 * @param  int $id client
 * @return array
 */
function pjk3_filtered_visible_tabs($tabs, $id = '')
{
    $newTabs = [];
    $customerProfileBadges = null;

    $visible = get_option('visible_customer_profile_tabs');
    if ($visible != 'all') {
        $visible = unserialize($visible);
    }

    if ($id !== '') {
        $customerProfileBadges = new CustomerProfileBadges($id);
    }

    $appliedSettings = is_array($visible);
    foreach ($tabs as $key => $tab) {

        $tab['view'] = 'admin/pjk3/clients/groups/' . $key;

        // Check visibility from settings too
        if ($key != 'profile' && $key != 'contacts' && $appliedSettings) {
            if (array_key_exists($key, $visible) && $visible[$key] == false) {
                continue;
            }
        }

        if (!is_null($customerProfileBadges)) {
            $tab['badge'] = $customerProfileBadges->getBadge($tab['slug']);
        }

        $newTabs[$key] = $tab;
    }

    return hooks()->apply_filters('pjk3_filtered_visible_tabs', $newTabs);
}
