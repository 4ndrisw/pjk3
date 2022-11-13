<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-heading section-pjk3">
  <div class="panel-body">
    <h4 class="no-margin section-text"><?php echo _l('pjk3'); ?></h4>
  </div>
</div>
<div class="panel_s">
  <div class="panel-body">
    <table class="table dt-table table-pjk3" data-order-col="3" data-order-type="desc">
      <thead>
        <tr>
          <th class="th-pjk3-userid"><?php echo _l('pjk3') . ' #'; ?></th>
          <th class="th-pjk3-company"><?php echo _l('pjk3_company'); ?></th>
          <th class="th-pjk3-contact-name"><?php echo _l('pjk3_contact_name'); ?></th>
          <th class="th-pjk3-contact-email"><?php echo _l('pjk3_contact_email'); ?></th>
          <th class="th-pjk3-contact-phonenumber"><?php echo _l('pjk3_contact_phonenumber'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($daftar_pjk3 as $pjk3){ ?>
          <tr>
            <td>
              <a href="<?php echo site_url('pjk3/'.$pjk3['userid']); ?>" class="td-pjk3-url">
                <?php //echo format_pjk3_userid($pjk3['id']); ?>
                <?php echo $pjk3['userid']; ?>
              </a>
            </td>
              <td>
                <a href="<?php echo site_url('pjk3/'.$pjk3['userid']); ?>" class="td-pjk3-url-company">
                  <?php echo $pjk3['company']; ?>
                </a>
              </td>
              <td data-order="<?php echo $pjk3['contact']['firstname']; ?>">
                  <?php echo $pjk3['contact']['firstname'] .' '. $pjk3['contact']['lastname']; ?>
             </td>
             <td data-order="<?php echo $pjk3['contact']['email']; ?>"><?php echo $pjk3['contact']['email']; ?></td>
             <td data-order="<?php echo $pjk3['contact']['phonenumber']; ?>"><?php echo $pjk3['contact']['phonenumber']; ?></td>
           </tr>
         <?php } ?>
       </tbody>
     </table>
   </div>
 </div>
