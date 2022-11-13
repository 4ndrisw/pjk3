<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mypjk3 extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('pjk3_model');
        $this->load->model('clients_model');
    
    }

    /* Get all pjk3 in case user go on index page */
    public function list($id = '')
    {

        if (!has_contact_permission('pjk3')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url('clients'));
        }

        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('pjk3', 'admin/tables/table'));
        }
        $contact_id = get_contact_user_id();
        $user_id = get_user_id_by_contact_id($contact_id);
        $client = $this->clients_model->get($user_id);

        //$data['pjk3'] = $this->pjk3_model->get_client_pjk3($client);
        $daftar_pjk3 = $this->clients_model->get('', $where = ['is_pjk3'=>1]);

        foreach($daftar_pjk3 as $key => $pjk3 ){
            $primary_contact  = $this->clients_model->get_contacts($pjk3['userid'],$where = ['is_primary' => 1]);
            $daftar_pjk3[$key]['contact'] = $primary_contact[0];
        }
        $data['daftar_pjk3'] = $daftar_pjk3;
        $data['scheduleid']            = $id;
        $data['title']                 = _l('pjk3_tracking');

        $data['bodyclass'] = 'pjk3';
        $this->data($data);
        $this->view('themes/'. active_clients_theme() .'/views/pjk3/pjk3');
        $this->layout();
    }
    public function show($id, $hash)
    {
        check_pjk3_restrictions($id, $hash);
        $pjk3 = $this->pjk3_model->get($id);

        if ($pjk3->rel_type == 'customer' && !is_client_logged_in()) {
            load_client_language($pjk3->rel_id);
        } else if ($pjk3->rel_type == 'lead') {
            load_lead_language($pjk3->rel_id);
        }

        $identity_confirmation_enabled = get_option('pjk3_accept_identity_confirmation');
        if ($this->input->post()) {
            $action = $this->input->post('action');
            switch ($action) {
                case 'pjk3_comment':
                    // comment is blank
                    if (!$this->input->post('content')) {
                        redirect($this->uri->uri_string());
                    }
                    $data               = $this->input->post();
                    $data['pjk3_id'] = $id;
                    $this->pjk3_model->add_comment($data, true);
                    redirect($this->uri->uri_string() . '?tab=discussion');

                    break;
                case 'accept_pjk3':
                    $success = $this->pjk3_model->mark_action_status(3, $id, true);
                    if ($success) {
                        process_digital_signature_image($this->input->post('signature', false), PROPOSAL_ATTACHMENTS_FOLDER . $id);

                        $this->db->where('id', $id);
                        $this->db->update(db_prefix() . 'pjk3', get_acceptance_info_array());
                        redirect($this->uri->uri_string(), 'refresh');
                    }

                    break;
                case 'decline_pjk3':
                    $success = $this->pjk3_model->mark_action_status(2, $id, true);
                    if ($success) {
                        redirect($this->uri->uri_string(), 'refresh');
                    }

                    break;
            }
        }

        $number_word_lang_rel_id = 'unknown';
        if ($pjk3->rel_type == 'customer') {
            $number_word_lang_rel_id = $pjk3->rel_id;
        }
        $this->load->library('app_number_to_word', [
            'clientid' => $number_word_lang_rel_id,
        ], 'numberword');

        $this->disableNavigation();
        $this->disableSubMenu();

        $data['title']     = $pjk3->subject;
        $data['can_be_accepted']               = false;
        $data['pjk3']  = hooks()->apply_filters('pjk3_html_pdf_data', $pjk3);
        $data['bodyclass'] = 'pjk3 pjk3-view';

        $data['identity_confirmation_enabled'] = $identity_confirmation_enabled;
        if ($identity_confirmation_enabled == '1') {
            $data['bodyclass'] .= ' identity-confirmation';
        }

        $this->app_scripts->theme('sticky-js', 'assets/plugins/sticky/sticky.js');

        $data['comments'] = $this->pjk3_model->get_comments($id);
        add_views_tracking('pjk3', $id);
        hooks()->do_action('pjk3_html_viewed', $id);
        hooks()->add_action('app_admin_head', 'pjk3_head_component');

        $this->app_css->remove('reset-css', 'customers-area-default');

        $data                      = hooks()->apply_filters('pjk3_customers_area_view_data', $data);
        no_index_customers_area();
        $this->data($data);

        $this->view('themes/' . active_clients_theme() . '/views/pjk3/pjk3_html');

        $this->layout();
    }


    public function pdf($id)
    {
        if (!$id) {
            redirect(admin_url('pjk3'));
        }

        $canView = user_can_view_pjk3($id);
        if (!$canView) {
            access_denied('pjk3');
        } else {
            if (!has_permission('pjk3', '', 'view') && !has_permission('pjk3', '', 'view_own') && $canView == false) {
                access_denied('pjk3');
            }
        }

        $pjk3 = $this->pjk3_model->get($id);
        $pjk3_number = format_pjk3_number($id);
        /*
        echo '<pre>';
        var_dump($pjk3);
        echo '</pre>';
        die();
        */

        try {
            $pdf = pjk3_pdf($pjk3);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            if (strpos($message, 'Unable to get the size of the image') !== false) {
                show_pdf_unable_to_get_image_size_error();
            }
            die;
        }

        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output($pjk3_number . '.pdf', $type);
    }




    public function add()
    {
        if (!has_contact_permission('pjk3')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url('clients'));
        }

        if ($this->input->post()) {
            

            $pjk3_data = $this->input->post();
            var_dump($pjk3_data);
                $id = $this->pjk3_model->add($pjk3_data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('pjk3')));
                    if ($this->set_pjk3_pipeline_autoload($id)) {
                        redirect(site_url('pjk3/list'));
                    } else {
                        redirect(admin_url('pjk3/show/' . $id . '/' . $hash));
                    }
                }
        }

        $title = _l('add_new', _l('pjk3_lowercase'));

        $data['statuses']      = $this->pjk3_model->get_statuses();
        $data['staff']         = $this->staff_model->get('', ['active' => 1]);
        $data['currencies']    = $this->currencies_model->get();
        $data['base_currency'] = $this->currencies_model->get_base_currency();

        $data['title'] = $title;



        $this->data($data);
        $this->view('themes/' . active_clients_theme() . '/views/pjk3/add_pjk3');
        $this->layout();
    }

}
