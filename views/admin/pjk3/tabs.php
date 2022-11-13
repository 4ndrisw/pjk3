<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked customer-tabs" role="tablist">
  <?php

 if(isset($client) && $client->is_pjk3 == 1 ){$mypjk3 = 6;}else{$mypjk3 = 20;}

 $countpjk3 = 1;

 
  foreach(pjk3_filtered_visible_tabs($customer_tabs) as $key => $tab){
    if($countpjk3 <= $mypjk3){
    ?>
    <li class="<?php if($key == 'profile'){echo 'active ';} ?>customer_tab_<?php echo $key; ?>">
      <a data-group="<?php echo $key; ?>" href="<?php echo admin_url('pjk3/client/'.$client->userid.'?group='.$key); ?>">
        <?php if(!empty($tab['icon'])){ ?>
            <i class="<?php echo $tab['icon']; ?> menu-icon" aria-hidden="true"></i>
        <?php } ?>
        <?php echo $tab['name'] ; ?>
      </a>
    </li>
    <?php 

    }
    
    $countpjk3++;
} ?>

</ul>
