<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper" class="customer_profile">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <?php if(isset($client) && $client->registration_confirmed == 0 && is_admin()){ ?>
               <div class="alert alert-warning">
                  <?php echo _l('customer_requires_registration_confirmation'); ?>
                  <br />
                  <a href="<?php echo admin_url('pjk3/confirm_registration/'.$client->userid); ?>"><?php echo _l('confirm_registration'); ?></a>
               </div>
            <?php } else if(isset($client) && $client->active == 0 && $client->registration_confirmed == 1){ ?>
            <div class="alert alert-warning">
               <?php echo _l('pjk3_inactive_message'); ?>
               <br />
               <a href="<?php echo admin_url('pjk3/mark_as_active/'.$client->userid); ?>"><?php echo _l('mark_as_active'); ?></a>
            </div>
            <?php } ?>
            <?php if(isset($client) && (!has_permission('customers','','view') && is_customer_admin($client->userid))){?>
            <div class="alert alert-info">
               <?php echo _l('pjk3_admin_login_as_client_message',get_staff_full_name(get_staff_user_id())); ?>
            </div>
            <?php } ?>
         </div>
         <?php if($group == 'profile'){ ?>
         <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
            <button class="btn btn-info only-save customer-form-submiter">
            <?php echo _l( 'submit'); ?>
            </button>
            <?php if(!isset($client)){ ?>
            <button class="btn btn-info save-and-add-contact customer-form-submiter">
            <?php echo _l( 'save_customer_and_add_contact'); ?>
            </button>
            <?php } ?>
         </div>
         <?php } ?>
         <?php if(isset($client)){ ?>
         <div class="col-md-12">
            <div class="panel_s mbot5">
               <div class="panel-body padding-10">
                  <h4 class="bold">
                     #<?php echo $client->userid . ' ' . $title; ?>
                     <?php if(has_permission('customers','','delete') || is_admin()){ ?>
                     <div class="btn-group">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                           <?php if(is_admin()){ ?>
                           <li>
                              <a href="<?php echo admin_url('pjk3/login_as_client/'.$client->userid); ?>" target="_blank">
                              <i class="fa fa-share-square-o"></i> <?php echo _l('login_as_pjk3'); ?>
                              </a>
                           </li>
                           <?php } ?>
                           <?php if(has_permission('customers','','delete')){ ?>
                           <li>
                              <a href="<?php echo admin_url('pjk3/delete/'.$client->userid); ?>" class="text-danger delete-text _delete"><i class="fa fa-remove"></i> <?php echo _l('delete'); ?>
                              </a>
                           </li>
                           <?php } ?>
                        </ul>
                     </div>
                     <?php } ?>
                  </h4>
               </div>
            </div>

         </div>

         <div class="col-md-3">
            <?php $this->load->view('admin/pjk3/tabs'); ?>
         </div>
         <?php } ?>
         <div class="col-md-<?php if(isset($client)){echo 9;} else {echo 12;} ?>">
            <div class="panel_s">
               <div class="panel-body">
                  <?php if(isset($client)){ ?>
                  <?php echo form_hidden('isedit'); ?>
                  <?php echo form_hidden('userid', $client->userid); ?>
                  <div class="clearfix"></div>
                  <?php } ?>
                  <div>
                     <div class="tab-content">
                        
                           <?php  $this->load->view((isset($tab) ? $tab['view'] : 'admin/pjk3/groups/profile')); ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php if($group == 'profile'){ ?>
         <div class="btn-bottom-pusher"></div>
      <?php } ?>
   </div>
</div>
<?php init_tail(); ?>

<?php if(isset($client)){ ?>
<script>
   $(function(){
      init_rel_tasks_table(<?php echo $client->userid; ?>,'customer');
   });
   if($('.customer-profile-tabs li:first a').attr('href') == '#contact_info'){
        $('.customer-profile-tabs li:first a').text('Pjk3 Details');
        $('.is_preffered').css('display','block');
    }
    $(document).on('click','.customer-profile-tabs li a', function(e) {
      console.log('sa');
      set_is_prefered(this);
    });
   
   
    function set_is_prefered(e){
      console.log('sas'+$(e).attr('href'));
       if($(e).attr('href') == '#contact_info'){
           $('.customer-profile-tabs li:first a').text('Pjk3 Details');
           $('.is_preffered').css('display','block');
       }else{
          console.log('sasss');
          $('.is_preffered').css('display','none');
       }
    }
</script>
<?php } ?>
<?php $this->load->view('admin/pjk3/client_js'); ?>
</body>
</html>
