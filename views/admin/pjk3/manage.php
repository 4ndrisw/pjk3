<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style type="text/css">


/*  Toggle Switch  */

.custom_toggle .toggleSwitch span span {
  display: none;
}

@media only screen {
  .custom_toggle .toggleSwitch {
    display: inline-block;
    height: 18px;
    position: relative;
    overflow: visible;
    padding: 0;
    margin-left: 50px;
    cursor: pointer;
    width: 40px
  }
  .custom_toggle .toggleSwitch * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .custom_toggle .toggleSwitch label,
  .custom_toggle .toggleSwitch > span {
    line-height: 20px;
    height: 20px;
    vertical-align: middle;
  }
  .custom_toggle .toggleSwitch input:focus ~ a,
  .custom_toggle .toggleSwitch input:focus + label {
    outline: none;
  }
  .custom_toggle .toggleSwitch label {
    position: relative;
    z-index: 3;
    display: block;
    width: 100%;
  }
  .custom_toggle .toggleSwitch input {
    position: absolute;
    opacity: 0;
    z-index: 5;
  }
  .custom_toggle .toggleSwitch > span {
    position: absolute;
    left: -50px;
    width: 100%;
    margin: 0;
    padding-right: 50px;
    text-align: left;
    white-space: nowrap;
  }
  .custom_toggle .toggleSwitch > span span {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 5;
    display: block;
    width: 50%;
    margin-left: 50px;
    text-align: left;
    font-size: 0.9em;
    width: 100%;
    left: 15%;
    top: -1px;
    opacity: 0;
  }
  .custom_toggle .toggleSwitch a {
    position: absolute;
    right: 50%;
    z-index: 4;
    display: block;
    height: 100%;
    padding: 0;
    left: 2px;
    width: 18px;
    background-color: #fff;
    border: 1px solid #CCC;
    border-radius: 100%;
    -webkit-transition: all 0.2s ease-out;
    -moz-transition: all 0.2s ease-out;
    transition: all 0.2s ease-out;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  }
  .custom_toggle .toggleSwitch > span span:first-of-type {
    color: #ccc;
    opacity: 1;
    left: 45%;
  }
  .custom_toggle .toggleSwitch > span:before {
    content: '';
    display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    left: 50px;
    top: -2px;
    background-color: #fafafa;
    border: 1px solid #ccc;
    border-radius: 30px;
    -webkit-transition: all 0.2s ease-out;
    -moz-transition: all 0.2s ease-out;
    transition: all 0.2s ease-out;
  }
  .custom_toggle .toggleSwitch input:checked ~ a {
    border-color: #fff;
    left: 100%;
    margin-left: -8px;
  }
  .custom_toggle .toggleSwitch input:checked ~ span:before {
    border-color: #84c529;
    box-shadow: inset 0 0 0 30px #84c529;
  }
  .custom_toggle .toggleSwitch input:checked ~ span span:first-of-type {
    opacity: 0;
  }
  .custom_toggle .toggleSwitch input:checked ~ span span:last-of-type {
    opacity: 1;
    color: #fff;
  }
  
}


/*  End Toggle Switch  */
</style>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="_filters _hidden_inputs hidden">
               <?php
                  echo form_hidden('my_customers');
                  echo form_hidden('requires_registration_confirmation');
                  

                  foreach($project_statuses as $status){
                  echo form_hidden('projects_'.$status['id']);
                  }

                  foreach($customer_admins as $cadmin){
                  echo form_hidden('responsible_admin_'.$cadmin['staff_id']);
                  }
                  foreach($countries as $country){
                  echo form_hidden('country_'.$country['country_id']);
                  }
                  ?>
            </div>
            <div class="panel_s">
               <div class="panel-body">
                  <div class="_buttons">
                     <?php if (has_permission('customers','','create')) { ?>
                     <a href="<?php echo admin_url('pjk3/client' ); ?>" class="btn btn-info mright5 test pull-left display-block">
                     <?php echo _l('new_pjk3'); ?></a>
                     <a href="<?php echo admin_url('pjk3/import'); ?>" class="btn btn-info pull-left display-block mright5 hidden-xs">
                     <?php echo _l('import_pjk3_'); ?></a>
                     <?php } ?>
                     <?php if (has_permission('items','','')) { ?>
                      <a href="<?php echo admin_url('invoice_items' ); ?>" class="btn btn-info mright5 test pull-left display-block">
                           <?php echo _l('items'); ?></a>
                     <?php }?>
                     <a href="<?php echo admin_url('pjk3/all_contacts'); ?>" class="btn btn-info pull-left display-block mright5">
                     <?php echo _l('customer_contacts'); ?></a>
                     <div class="visible-xs">
                        <div class="clearfix"></div>
                     </div>
                     <div class="btn-group pull-right btn-with-tooltip-group _filter_data" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-left" style="width:300px;">
                           <li class="active"><a href="#" data-cview="all" onclick="dt_custom_view('','.table-clients',''); return false;"><?php echo _l('customers_sort_all'); ?></a>
                           </li>
                           <?php if(get_option('customer_requires_registration_confirmation') == '1' || total_rows(db_prefix().'clients','registration_confirmed=0') > 0) { ?>
                           <li class="divider"></li>
                           <li>
                              <a href="#" data-cview="requires_registration_confirmation" onclick="dt_custom_view('requires_registration_confirmation','.table-clients','requires_registration_confirmation'); return false;">
                              <?php echo _l('customer_requires_registration_confirmation'); ?>
                              </a>
                           </li>
                           <?php } ?>
                           <li class="divider"></li>
                           <li>
                              <a href="#" data-cview="my_customers" onclick="dt_custom_view('my_customers','.table-clients','my_customers'); return false;">
                              <?php echo _l('pjk3_assigned_to_me'); ?>
                              </a>
                           </li>
                           <li class="divider"></li>
                           <?php if(count($groups) > 0){ ?>
                           <li class="dropdown-submenu pull-left groups">
                              <a href="#" tabindex="-1"><?php echo _l('customer_groups'); ?></a>
                              <ul class="dropdown-menu dropdown-menu-left">
                                 <?php foreach($groups as $group){ ?>
                                 <li><a href="#" data-cview="customer_group_<?php echo $group['id']; ?>" onclick="dt_custom_view('customer_group_<?php echo $group['id']; ?>','.table-clients','customer_group_<?php echo $group['id']; ?>'); return false;"><?php echo $group['name']; ?></a></li>
                                 <?php } ?>
                              </ul>
                           </li>
                           <div class="clearfix"></div>
                           <li class="divider"></li>
                           <?php } ?>
                           <?php if(count($countries) > 1){ ?>
                           <li class="dropdown-submenu pull-left countries">
                              <a href="#" tabindex="-1"><?php echo _l('clients_country'); ?></a>
                              <ul class="dropdown-menu dropdown-menu-left">
                                 <?php foreach($countries as $country){ ?>
                                 <li><a href="#" data-cview="country_<?php echo $country['country_id']; ?>" onclick="dt_custom_view('country_<?php echo $country['country_id']; ?>','.table-clients','country_<?php echo $country['country_id']; ?>'); return false;"><?php echo $country['short_name']; ?></a></li>
                                 <?php } ?>
                              </ul>
                           </li>
                           <div class="clearfix"></div>
                           <li class="divider"></li>
                           <?php } ?>
                           <div class="clearfix"></div>
                           <li class="divider"></li>
                           <li class="dropdown-submenu pull-left project">
                              <a href="#" tabindex="-1"><?php echo _l('projects'); ?></a>
                              <ul class="dropdown-menu dropdown-menu-left">
                                 <?php foreach($project_statuses as $status){ ?>
                                 <li>
                                    <a href="#" data-cview="projects_<?php echo $status['id']; ?>" onclick="dt_custom_view('projects_<?php echo $status['id']; ?>','.table-clients','projects_<?php echo $status['id']; ?>'); return false;">
                                    <?php echo _l('customer_have_projects_by',$status['name']); ?>
                                    </a>
                                 </li>
                                 <?php } ?>
                              </ul>
                           </li>
                           <div class="clearfix"></div>
                           <?php if(count($customer_admins) > 0 && (has_permission('customers','','create') || has_permission('customers','','edit'))){ ?>
                           <div class="clearfix"></div>
                           <li class="divider"></li>
                           <li class="dropdown-submenu pull-left responsible_admin">
                              <a href="#" tabindex="-1"><?php echo _l('responsible_admin'); ?></a>
                              <ul class="dropdown-menu dropdown-menu-left">
                                 <?php foreach($customer_admins as $cadmin){ ?>
                                 <li>
                                    <a href="#" data-cview="responsible_admin_<?php echo $cadmin['staff_id']; ?>" onclick="dt_custom_view('responsible_admin_<?php echo $cadmin['staff_id']; ?>','.table-clients','responsible_admin_<?php echo $cadmin['staff_id']; ?>'); return false;">
                                    <?php echo get_staff_full_name($cadmin['staff_id']); ?>
                                    </a>
                                 </li>
                                 <?php } ?>
                              </ul>
                           </li>
                           <?php } ?>
                        </ul>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php if(has_permission('customers','','view') || have_assigned_customers()) {
                     $where_summary = '';
                     if(!has_permission('customers','','view')){
                         $where_summary = ' AND userid IN (SELECT customer_id FROM '.db_prefix().'customer_admins WHERE staff_id='.get_staff_user_id().')';
                     }
                      $contact_tbl = db_prefix().'contacts';
                     $client_tbl = db_prefix().'clients';
                     $query_active = $this->db->query('SELECT COUNT(*) as count FROM '.$contact_tbl.' LEFT JOIN '.$client_tbl.' ON '.$contact_tbl.'.userid = '.$client_tbl.'.userid WHERE '.$contact_tbl.'.active=1 AND '.$client_tbl.'.is_pjk3= 1'. $where_summary);
                     $active = $query_active->row();
                     $query_inactive = $this->db->query('SELECT COUNT(*) as count FROM '.$contact_tbl.' LEFT JOIN '.$client_tbl.' ON '.$contact_tbl.'.userid = '.$client_tbl.'.userid WHERE '.$contact_tbl.'.active=0 AND '.$client_tbl.'.is_pjk3= 1'. $where_summary);
                     $inactive = $query_inactive->row();
                     $query_like = $this->db->query('SELECT COUNT(*) as count FROM '.$contact_tbl.' LEFT JOIN '.$client_tbl.' ON '.$contact_tbl.'.userid = '.$client_tbl.'.userid WHERE '.$contact_tbl.'.last_login LIKE "'.date('Y-m-d').'%" AND '.$client_tbl.'.is_pjk3= 1'. $where_summary);
                     $like = $query_like->row();

                     ?>
                  <hr class="hr-panel-heading" />
                  <div class="row mbot15">
                     <div class="col-md-12">
                        <h4 class="no-margin" id="changetitle"></h4>
                     </div>
                     <div class="col-md-2 col-xs-6 border-right">
                        <h3 class="bold"><?php echo total_rows(db_prefix().'clients','is_pjk3=1',($where_summary != '' ? substr($where_summary,5) : '')); ?></h3>
                        <span class="text-dark"><?php echo _l('pjk3_summary_total'); ?></span>
                     </div>
                     <div class="col-md-2 col-xs-6 border-right">
                        <h3 class="bold"><?php echo total_rows(db_prefix().'clients','is_pjk3=1 AND active=1'.$where_summary); ?></h3>
                        <span class="text-success"><?php echo _l('active_pjk3_'); ?></span>
                     </div>
                     <div class="col-md-2 col-xs-6 border-right">
                        <h3 class="bold"><?php echo total_rows(db_prefix().'clients','is_pjk3=1 AND active=0'.$where_summary); ?></h3>
                        <span class="text-danger"><?php echo _l('inactive_active_pjk3'); ?></span>
                     </div>
                     <div class="col-md-2 col-xs-6 border-right">
                        <h3 class="bold"><?php echo isset($active->count) ?  $active->count : ''; ?></h3>
                        <span class="text-info"><?php echo _l('customers_summary_active'); ?></span>
                     </div>
                     <div class="col-md-2  col-xs-6 border-right">
                        <h3 class="bold"><?php echo isset($inactive->count) ?  $inactive->count : ''; ?> </h3>
                        <span class="text-danger"><?php echo _l('customers_summary_inactive'); ?></span>
                     </div>
                     <div class="col-md-2 col-xs-6">
                        <h3 class="bold"><?php echo isset($like->count) ?  $like->count : ''; ?></h3>
                        <span class="text-muted">
                        <?php
                           $contactsTemplate = '';
                           if(count($contacts_logged_in_today)> 0){
                              foreach($contacts_logged_in_today as $contact){
                               $url = admin_url('pjk3/client/'.$contact['userid'].'?contactid='.$contact['id']);
                               $fullName = $contact['firstname'] . ' ' . $contact['lastname'];
                               $dateLoggedIn = _dt($contact['last_login']);
                               $html = "<a href='$url' target='_blank'>$fullName</a><br /><small>$dateLoggedIn</small><br />";
                               $contactsTemplate .= html_escape('<p class="mbot5">'.$html.'</p>');
                           }
                           ?>
                        <?php } ?>
                        <span<?php if($contactsTemplate != ''){ ?> class="pointer text-has-action" data-toggle="popover" data-title="<?php echo _l('customers_summary_logged_in_today'); ?>" data-html="true" data-content="<?php echo $contactsTemplate; ?>" data-placement="bottom" <?php } ?>><?php echo _l('customers_summary_logged_in_today'); ?></span>
                        </span>
                     </div>
                  </div>
                  <?php } ?>
                  <hr class="hr-panel-heading" />
                  <a href="#" data-toggle="modal" data-target="#customers_bulk_action" class="bulk-actions-btn table-btn hide" data-table=".table-clients"><?php echo _l('bulk_actions'); ?></a>
                  <div class="modal fade bulk_actions" id="customers_bulk_action" tabindex="-1" role="dialog">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
                           </div>
                           <div class="modal-body">
                              <?php if(has_permission('customers','','delete')){ ?>
                              <div class="checkbox checkbox-danger">
                                 <input type="checkbox" name="mass_delete" id="mass_delete">
                                 <label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
                              </div>
                              <hr class="mass_delete_separator" />
                              <?php } ?>
                              <div id="bulk_change">
                                 <?php echo render_select('move_to_groups_customers_bulk[]',$groups,array('id','name'),'customer_groups','', array('multiple'=>true),array(),'','',false); ?>
                                 <p class="text-danger"><?php echo _l('bulk_action_pjk3_groups_warning'); ?></p>
                              </div>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                              <a href="#" class="btn btn-info" onclick="customers_bulk_action(this); return false;"><?php echo _l('confirm'); ?></a>
                           </div>
                        </div>
                        <!-- /.modal-content -->
                     </div>
                     <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                  <div class="checkbox">
                     <input type="checkbox" checked id="exclude_inactive" name="exclude_inactive">
                     <label for="exclude_inactive"><?php echo _l('exclude_inactive'); ?> <?php echo _l('pjk3'); ?></label>
                  </div>
                  <div class="clearfix mtop20"></div>
                  <?php
                     $table_data = array();
                     $_table_data = array(
                      '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="clients"><label></label></div>',
                       array(
                         'name'=>_l('the_number_sign'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-number')
                        ),
                         array(
                         'name'=>_l('pjk3'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-company')
                        ),
                         array(
                         'name'=>_l('contact_primary'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-primary-contact')
                        ),
                         array(
                         'name'=>_l('company_primary_email'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-primary-contact-email')
                        ),
                         array(
                         'name'=>_l('company_no_peserta_bpjs'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-no-peserta-bpjs')
                        ),
                        array(
                         'name'=>_l('clients_list_phone'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-phone')
                        ),
                         array(
                         'name'=>_l('customer_active'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-active')
                        ),
                         array(
                         'name'=>_l('preffered_pjk3'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-active')
                        ),
                      );
                     foreach($_table_data as $_t){
                      array_push($table_data,$_t);
                     }

                     $custom_fields = get_custom_fields('customers',array('show_on_table'=>1));
                     foreach($custom_fields as $field){
                      array_push($table_data,$field['name']);
                     }

                     $table_data = hooks()->apply_filters('customers_table_columns', $table_data);

                     render_datatable($table_data,'clients',[],[
                           'data-last-order-identifier' => 'customers',
                           'data-default-order'         => get_table_last_order('customers'),
                     ]);
                     ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_tail(); ?>
<script>
   $(function(){
       var CustomersServerParams = {};
       $.each($('._hidden_inputs._filters input'),function(){
          CustomersServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
      });
       CustomersServerParams['exclude_inactive'] = '[name="exclude_inactive"]:checked';
      var is_pjk3 = "<?= $this->input->get('pjk3'); ?>";

         $('#changetitle').html('<?php echo _l('pjk3_summary'); ?>');

       var tAPI = initDataTable('.table-clients', admin_url+'pjk3/table', [0], [0], CustomersServerParams,<?php echo hooks()->apply_filters('customers_table_default_order', json_encode(array(2,'asc'))); ?>);
       $('input[name="exclude_inactive"]').on('change',function(){
           tAPI.ajax.reload();
       });

   });
   function customers_bulk_action(event) {
       var r = confirm(app.lang.confirm_action_prompt);
       if (r == false) {
           return false;
       } else {
           var mass_delete = $('#mass_delete').prop('checked');
           var ids = [];
           var data = {};
           if(mass_delete == false || typeof(mass_delete) == 'undefined'){
               data.groups = $('select[name="move_to_groups_customers_bulk[]"]').selectpicker('val');
               if (data.groups.length == 0) {
                   data.groups = 'remove_all';
               }
           } else {
               data.mass_delete = true;
           }
           var rows = $('.table-clients').find('tbody tr');
           $.each(rows, function() {
               var checkbox = $($(this).find('td').eq(0)).find('input');
               if (checkbox.prop('checked') == true) {
                   ids.push(checkbox.val());
               }
           });
           data.ids = ids;
           $(event).addClass('disabled');
           setTimeout(function(){
             $.post(admin_url + 'pjk3/bulk_action', data).done(function() {
              window.location.reload();
          });
         },50);
       }
   }
</script>
</body>
</html>
