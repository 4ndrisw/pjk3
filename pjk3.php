<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: PJK3 
Description: Module for PJK3 
Version: 2.3.4
Requires at least: 2.3.*
*/


if (!defined('MODULE_PJK3')) {
    define('MODULE_PJK3', basename(__DIR__));
}

//filter_client_visible_tabs

//hooks()->add_action('after_custom_profile_tab_content', 'pjk3_content_tab_product_service',10,1);

hooks()->add_action('admin_init', 'pjk3_module_init_menu_items');
hooks()->add_action('admin_init', 'pjk3_permissions');
hooks()->add_action('admin_init', 'pjk3_settings_tab');
hooks()->add_filter('customers_table_sql_where', 'pjk3_client_sql_where',10,1);
hooks()->add_action('clients_init', 'pjk3_clients_area_menu_items');
hooks()->add_filter('get_contact_permissions', 'pjk3_contact_permission',10,1);
hooks()->add_filter('invoices_table_row_data', 'pjk3_invoices_table_row_data',10,2);
//hooks()->apply_filters('client_filtered_visible_tabs', $newTabs)
//hooks()->add_filter('client_filtered_visible_tabs', 'filter_client_visible_tabs');
//hooks()->add_filter('client_filtered_visible_tabs', 'pjk3_filtered_visible_tabs');

function pjk3_invoices_table_row_data( $row, $aRow){
    $client = get_client($aRow['clientid']);
   
    if(!empty($client)){
        if($client->is_pjk3 !=0){

            $row[5] =  '<a href="'.admin_url().'pjk3/client/'.$aRow['clientid'].'">'.$aRow['company'].'</a>';
        }
    }
    return $row;
}

function pjk3_contact_permission($permissions){
        $item = array(
            'id'         => 8,
            'name'       => _l('pjk3'),
            'short_name' => 'pjk3',
        );
        $permissions[] = $item;
      return $permissions;

}
function pjk3_client_sql_where($where){
    array_push($where, 'AND '.db_prefix().'clients.is_pjk3 =0');
    return $where;
}


function pjk3_permissions() {
    $capabilities = [];

    $capabilities['capabilities'] = [
            'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
            'view_by_instansi'   => _l('permission_view_by_instansi'),
            'view_by_unit'   => _l('permission_view_by_unit'),
            'view_by_penyedia'   => _l('permission_view_by_penyedia'),
            'create' => _l('permission_create'),
            'edit'   => _l('permission_edit'),
            'delete' => _l('permission_delete'),
    ];
    if (function_exists('register_staff_capabilities')) {
        register_staff_capabilities('pjk3', $capabilities, _l('pjk3'));
    }
}


/**
 * [perfex_dark_theme_settings_tab net menu item in setup->settings]
 * @return void
 */
function pjk3_settings_tab()
{
    $CI = &get_instance();
    $CI->app_tabs->add_settings_tab('pjk3', [
        'name'     => _l('settings_group_pjk3'),
        //'view'     => module_views_path(PERALATAN_MODULE_NAME, 'admin/settings/includes/pjk3'),
        'view'     => 'pjk3/pjk3_settings',
        'position' => 51,
        'icon'     => 'fa-solid fa-building-shield',
    ]);
}

function pjk3_clients_area_menu_items()
{   

    // Show menu item only if client is logged in
    if (is_client_logged_in()) {

        add_theme_menu_item('product-services-in-item-id', [
                    'name'     => _l('product_and_service'),
                    'href'     => site_url('pjk3/product_services/'),
                    'position' => 21,
        ]);
        add_theme_menu_item('product-services-in-item-id', [
                    'name'     => _l('pjk3'),
                    'href'     => site_url('pjk3/list'),
                    'position' => 15,
        ]);
    }
}
/**
* Register activation module hook
*/
register_activation_hook(MODULE_PJK3, 'pjk3_module_activation_hook');

function pjk3_module_activation_hook() {
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}
/**
* Load the module helper
*/
get_instance()->load->helper(MODULE_PJK3 . '/pjk3');

// print_r(MODULE_PJK3 );exit;
/**
* Register language files, must be registered if the module is using languages
*/

register_language_files(MODULE_PJK3, [MODULE_PJK3]);

/**
 * Init pjk3 module menu items in setup in admin_init hook
 * @return null
 */

function pjk3_module_init_menu_items() {
    $CI = &get_instance();

    $CI->app->add_quick_actions_link([
        'name'       => _l('pjk3'),
        'url'        => 'pjk3',
        'permission' => 'pjk3',
        'position'   => 57,
    ]);

    if (has_permission('pjk3', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('pjk3', [
            'slug'     => 'pjk3',
            'name'     => _l('pjk3'),
            'position' => 5,
            'icon'     => 'fa-solid fa-building-shield',
            'href'     => admin_url('pjk3')
        ]);
        /*
        $CI->app_tabs->add_customer_profile_tab('map', [
        'name'     => _l('customer_map'),
        'icon'     => 'fa fa-map-marker',
        'visible'  => TRUE,
        'view'     => 'admin/clients/groups/map',
        'position' => 95,
        ]);
        */

        $CI->app_tabs->add_customer_profile_tab('profile', [
            'name'     => _l('client_add_edit_profile'),
            'icon'     => 'fa fa-user-circle',
            'view'     => 'admin/pjk3/groups/profile',
            'position' => 5,
            'badge'    => [],
        ]);
    }

    // auto create custom js file
    if (!file_exists(APP_MODULES_PATH.MODULE_PJK3.'/assets/js')) {
        mkdir(APP_MODULES_PATH.MODULE_PJK3.'/assets/js',0755,true);
        file_put_contents(APP_MODULES_PATH.MODULE_PJK3.'/assets/js/'.MODULE_PJK3.'.js', '');
    }
    //  auto create custom css file
    if (!file_exists(APP_MODULES_PATH.MODULE_PJK3.'/assets/css')) {
        mkdir(APP_MODULES_PATH.MODULE_PJK3.'/assets/css',0755,true);
        file_put_contents(APP_MODULES_PATH.MODULE_PJK3.'/assets/css/'.MODULE_PJK3.'.css', '');
    }
    if(($CI->uri->segment(1)=='admin' && $CI->uri->segment(2)=='pjk3') || $CI->uri->segment(1)=='pjk3'){    
        $CI->app_css->add(MODULE_PJK3.'-css', base_url('modules/'.MODULE_PJK3.'/assets/css/'.MODULE_PJK3.'.css'));
        $CI->app_scripts->add(MODULE_PJK3.'-js', base_url('modules/'.MODULE_PJK3.'/assets/js/'.MODULE_PJK3.'.js'));
    }
}
