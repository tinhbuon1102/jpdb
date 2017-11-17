<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<!--default codes-->
<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" media="screen">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/groovy.css" media="screen">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css">
<link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosansjapanese.css">
<!--/default codes-->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/new_style.css" media="screen">
<style type="text/css">
  .bootom_pad{
    margin-bottom: 10px !important;
        padding-bottom: 22px !important;
  }
  .own_back{
    background-color: #76ade5 !important;
  }
  .error_val{
    border: 2px red !important;
    border-style: dotted !important;
  }
</style>
</head>

<body>
<div id="main" class="full-width">
<div class="tab_con">
<div class="manage-info table-box new_style_box">
<?php
      $buildingName = $buildingRandId = $buildingId = '';
    if(isset($_REQUEST['bid']) && $_REQUEST['bid'] != ''){
      $buildingDetails = Building::model()->findByPk($_REQUEST['bid']);
      if(isset($buildingDetails) && count($buildingDetails) > 0){
        $buildingName = $buildingDetails['name'];
        $buildingRandId = $buildingDetails['buildingId'];
        $buildingId = $buildingDetails['building_id'];
      }
    }else{
      $floorData = Floor::model()->find('floor_id = '.$_REQUEST['id']);
      $buildingDetails = Building::model()->findByPk($floorData['building_id']);
      if(isset($buildingDetails) && count($buildingDetails) > 0){
        $buildingName = $buildingDetails['name'];
        $buildingRandId = $buildingDetails['buildingId'];
        $buildingId = $buildingDetails['building_id'];
      }
    }
    //print_r($model);die('hello');
  ?>                   
              <div class="manageInfoResponse">
                    <div class="ttl_h3 clearfix">
                       <h3>Edit Window・Owner</h3>
                    </div>
               <form name="frmAddManagementHistoryNew" id="frmAddManagementHistoryNew" class="frmAddManagementHistory" action="<?php echo Yii::app()->createUrl('floor/UpdateManagement2'); ?>" method="post">   
                    <input type="hidden" name="hdnBillId" id="hdnBillId" class="hdnBillId" value="<?php echo $buildingId; ?>" />
                        <input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo isset($model->floor_id) && $model->floor_id != '' ?  $model->floor_id:''; ?>" />
                        <input type="hidden" name="hdnOtherCFloorId" id="hdnOtherCFloorId" class="hdnOtherCFloorId" value="0" />
                        <input type="hidden" name="inUpdate" id="inUpdate" class="inUpdate" value="<?php echo isset($model->floor_id) && $model->floor_id != '' ? 1 : 0; ?>" />
                    <div id="window_add">
                      <input type="hidden" name="total_window"  id="total_window" value="<?=+ count($floor_windows) ?>">
                       <?php
                       if(!empty($floor_windows)){
                       $count=1;
                        foreach ($floor_windows as $floor_window) {
                          ?>
                          <div id="window<?= $count ?>" count="<?= $count ?>">
                            <input type="hidden" name="update_window<?= $count ?>" value="1">
                            <input type="hidden" name="update_window_id<?= $count ?>" value="<?= $floor_window['ownership_management_id'] ?>">
                            <h4 class="ontable bg_lb">
                              <span id="count_window_<?= $count ?>"><?= $count ?>.&nbsp;</span>window
                              <span class="button-right">
                                <a id="add_another_window" class="bg_blue  side_button  add_another_window" href="javascript:void(0)">Add another window
                                </a>
                              </span>
                            </h4>
                            <table class="newform_info ad_list">
                              <tbody>
                                <tr>
                                  <th>Trader ID</th>
                                  <td>
                                    <input type="text" name="search_window<?= $count ?>" count="<?= $count ?>" class="search_by_tel mask_tel ty3 searchWindowText" id="search_window<?= $count ?>">
                                  </td>
                                  <th class="btn-cell">
                                    <a href="javascript:void(0)" id="search_telwindow<?= $count ?>" class="button style_navy search_tel" count="<?= $count ?>" tabtype="window">Search Trader
                                    </a>
                                  </th>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <td>
                                    <select id="trader_search_window<?= $count ?>" class="auto trader_search trader_search_window" name="trder_window<?= $count ?>" count="<?= $count ?>" tabtype="window">
                                         <option value="0"><?php echo Yii::app()->controller->__trans('saved traders');?>↓</option>
                                          <?php

                                          if(!empty($trans_all)){
                                              foreach($trans_all as $trans_alls){
                                          $selected = '';
                                          ?>
                                          <option value="<?php echo $trans_alls['trader_id']; ?>" <?php if($floor_window['trader_id']== $trans_alls['trader_id']) echo "selected";  ?>><?php echo $trans_alls['traderId'].' '.$trans_alls['trader_name']; ?></option>
                                          <?php
                                              }
                                          }else{
                                          ?>
                                          <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
                                          <?php
                                          }
                                          ?>
                    
                                    </select>
                                  </td>
                                  <th>&nbsp;</th>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <th>Sorts</th>
                                  <td>
                                    <select name="ownership_type_window<?= $count ?>" id="ownership_type_window<?= $count ?>" data-role="none" class="window_type" required="">
                                      <option value="">-</option>
                                      <option value="1" <?php if($floor_window['ownership_type']==1) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('owner');?></option>
                                      <option value="6" <?php if($floor_window['ownership_type']==6) echo "selected";  ?>  ><?php echo Yii::app()->controller->__trans('サブリース');?></option>
                                      <option value="7"  <?php if($floor_window['ownership_type']==7) echo "selected";  ?>><?php echo Yii::app()->controller->__trans('貸主代理');?></option>
                                      <option value="8"  <?php if($floor_window['ownership_type']==8) echo "selected";  ?>><?php echo Yii::app()->controller->__trans('AM');?></option>
                                      <option value="10"  <?php if($floor_window['ownership_type']==10) echo "selected";  ?> > <?php echo Yii::app()->controller->__trans('業者');?></option>
                                      <option value="4"  <?php if($floor_window['ownership_type']==4) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('intermediary agent');?></option>
                                      <option value="2"  <?php if($floor_window['ownership_type']==2) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('management company');?></option>
                                      <option value="9"  <?php if($floor_window['ownership_type']==9) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('PM');?></option>
                                      <option value="3"  <?php if($floor_window['ownership_type']==3) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('general contractor');?></option>
                                      <option value="-1"  <?php if($floor_window['ownership_type']==-1) echo "selected";  ?> ><?php echo $oSelect0; ?>><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                      
                                    </select>
                                  </td>
                                  <th>Transaction type</th>
                                  <td>
                                    <select name="management_type_window<?= $count ?>" id="management_type_window<?= $count ?>" class="management_type_window" data-role="none">
                                       <option value="">-</option>
                                        <option value="-1"  <?php if($floor_window['management_type']==-1) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                        <option value="1" <?php if($floor_window['management_type']==1) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('専任媒介');?></option>
                                        <option value="2" <?php if($floor_window['management_type']==2) echo "selected";  ?>><?php echo Yii::app()->controller->__trans('一般媒介');?></option>
                                        <option value="3" <?php if($floor_window['management_type']==3) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('代理');?></option>
                                        <option value="4" <?php if($floor_window['management_type']==4) echo "selected";  ?>><?php echo Yii::app()->controller->__trans('貸主');?></option>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Company Name</th>
                                  <td>
                                    <input type="text" name="company_name_window<?= $count ?>" id="company_name_window<?= $count ?>" value="<?= $floor_window['owner_company_name'] ?>" class="ty6 window_company_name" required="">
                                  </td>
                                  <th>&nbsp;</th>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <th>TEL</th>
                                  <td><input type="text" name="tel_window<?= $count ?>" id="tel_window<?= $count ?>" value="<?= $floor_window['company_tel'] ?>" class="mask_tel ty6 window_tel">
                                  </td>
                                  <th>FAX</th>
                                  <td>
                                    <input type="text" name="fax_window<?= $count ?>" id="fax_window<?= $count ?>" value="<?= $floor_window['company_fax'] ?>" class="mask_tel ty6 window_fax">
                                  </td>
                                </tr>
                                  <tr>
                                    <th>Person in charge1</th>
                                    <td>
                                      <input type="text" name="person_in_charge1_window<?= $count ?>" id="person_in_charge1_window<?= $count ?>" value="<?= $floor_window['person_in_charge1'] ?>" class="ty3 person_in_charge1">
                                    </td>
                                    <th>Person in charge2</th>
                                    <td>
                                      <input type="text" name="person_in_charge2_window<?= $count ?>" id="person_in_charge2_window<?= $count ?>" value="<?= $floor_window['person_in_charge2'] ?>" class="ty3 person_in_charge2">
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Fee</th>
                                    <td colspan="3">
                                      <label class="rd2">
                                        <input type="radio" name="charge_window<?= $count ?>"  value="不明" class="radiUnknown" <?php if($floor_window['charge']=='不明') echo "checked";  ?>>不明
                                      </label>
                                      <label class="rd2">
                                        <input type="radio" name="charge_window<?= $count ?>" value="相談" class="radiAsk" <?php if($floor_window['charge']=='相談') echo "checked";  ?>> 相談
                                      </label>
                                      <label class="rd2">
                                        <input type="radio" name="charge_window<?= $count ?>" value="未定" class="radiUndecided" <?php if($floor_window['charge']=='未定') echo "checked";  ?>> 未定</label>
                                      <label class="rd2" >
                                        <input type="radio" name="charge_window<?= $count ?>" value="無し" class="radiNone" <?php if($floor_window['charge']=='無し') echo "checked";  ?> >無し
                                      </label>
                                      <label class="rd2">
                                        <input type="text" name="change_txt_window<?= $count ?>" id="change_txt_window<?= $count ?>" size="5" value="<?= $floor_window['charge_text'] ?>" class="ty8 change_txt" >
                                      </label>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h4 class="ontable bg_lb bootom_pad">
                                <span class="button-right">
                                  <a id="remove_window<?= $count ?>" own_id="<?= $floor_window['ownership_management_id'] ?>" class="bg_blue side_button   remove_window" href="javascript:void(0)" div_id="window<?= $count ?>" style="display: <?= $count > 1 ?  "inline" : 'none'; ?>">Remove window</a></span>
                                </h4>
                        </div>


                          <?php
                          $count++;
                        }
                      }
                       ?>
                        
                    </div>
                      
                  <div id="add_owner">
                    <input type="hidden" name="total_owner"   id="total_owner" value="<?= count($floor_owners) ?>">
                    <?php
                    if(!empty($floor_owners)){
                       $count=1;
                        foreach ($floor_owners as $floor_window) {
                          ?>
                          <div id="owner<?= $count ?>" count="<?= $count ?>">
                            <input type="hidden" name="update_owner<?= $count ?>" value="1">
                            <h4 class="ontable bg_blue">
                              <span id="count_owner_<?= $count ?>"><?= $count ?>.&nbsp;</span>owner
                              <span class="button-right">
                                <a id="add_another_owner" class="bg_blue own_back side_button  add_another_owner" href="javascript:void(0)">Add another owner
                                </a>
                              </span>
                            </h4>
                            <table class="newform_info ad_list">
                              <tbody>
                                <?php if($count == 1) {?>
                                <tr class="no_border"><th colspan="4" class="bold_td col_3"><input name="sameinfo" id="sameinfo" value="sameinfo" type="checkbox"> Same as window</th></tr>
                                <?php } ?>
                                <tr>
                                  <th>Trader ID</th>
                                  <td>
                                    <input type="text" name="search_owner<?= $count ?>" count="<?= $count ?>" class="search_by_tel mask_tel ty3 searchownerText" id="search_owner<?= $count ?>">
                                  </td>
                                  <th class="btn-cell">
                                    <a href="javascript:void(0)" id="search_telowner<?= $count ?>" class="button style_navy search_tel" count="<?= $count ?>" tabtype="owner">Search Trader
                                    </a>
                                  </th>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <td>
                                    <select id="trader_search_owner<?= $count ?>" class="auto trader_search trader_search_owner" name="trder_owner<?= $count ?>" count="<?= $count ?>" tabtype="owner">
                                         <option value="0"><?php echo Yii::app()->controller->__trans('saved traders');?>↓</option>
                                          <?php

                                          if(!empty($trans_all)){
                                              foreach($trans_all as $trans_alls){
                                          $selected = '';
                                          ?>
                                          <option value="<?php echo $trans_alls['trader_id']; ?>" <?php if($floor_window['trader_id']== $trans_alls['trader_id']) echo "selected";  ?>><?php echo $trans_alls['traderId'].' '.$trans_alls['trader_name']; ?></option>
                                          <?php
                                              }
                                          }else{
                                          ?>
                                          <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
                                          <?php
                                          }
                                          ?>
                    
                                    </select>
                                  </td>
                                  <th>&nbsp;</th>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <th>Sorts</th>
                                  <td>
                                    <select name="ownership_type_owner<?= $count ?>" id="ownership_type_owner<?= $count ?>" data-role="none" class="owner_type" required="">
                                      <option value="">-</option>
                                      <option value="1" <?php if($floor_window['ownership_type']==1) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('owner');?></option>
                                      <option value="6" <?php if($floor_window['ownership_type']==6) echo "selected";  ?>  ><?php echo Yii::app()->controller->__trans('サブリース');?></option>
                                      <option value="7"  <?php if($floor_window['ownership_type']==7) echo "selected";  ?>><?php echo Yii::app()->controller->__trans('貸主代理');?></option>
                                      <option value="8"  <?php if($floor_window['ownership_type']==8) echo "selected";  ?>><?php echo Yii::app()->controller->__trans('AM');?></option>
                                      <option value="10"  <?php if($floor_window['ownership_type']==10) echo "selected";  ?> > <?php echo Yii::app()->controller->__trans('業者');?></option>
                                      <option value="4"  <?php if($floor_window['ownership_type']==4) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('intermediary agent');?></option>
                                      <option value="2"  <?php if($floor_window['ownership_type']==2) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('management company');?></option>
                                      <option value="9"  <?php if($floor_window['ownership_type']==9) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('PM');?></option>
                                      <option value="3"  <?php if($floor_window['ownership_type']==3) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('general contractor');?></option>
                                      <option value="-1"  <?php if($floor_window['ownership_type']==-1) echo "selected";  ?> ><?php echo $oSelect0; ?>><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                      
                                    </select>
                                  </td>
                                  <th>Transaction type</th>
                                  <td>
                                    <select name="management_type_owner<?= $count ?>" id="management_type_owner<?= $count ?>" class="management_type_owner" data-role="none">
                                       <option value="">-</option>
                                        <option value="-1"  <?php if($floor_window['management_type']==-1) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                        <option value="1" <?php if($floor_window['management_type']==1) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('専任媒介');?></option>
                                        <option value="2" <?php if($floor_window['management_type']==2) echo "selected";  ?>><?php echo Yii::app()->controller->__trans('一般媒介');?></option>
                                        <option value="3" <?php if($floor_window['management_type']==3) echo "selected";  ?> ><?php echo Yii::app()->controller->__trans('代理');?></option>
                                        <option value="4" <?php if($floor_window['management_type']==4) echo "selected";  ?>><?php echo Yii::app()->controller->__trans('貸主');?></option>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Company Name</th>
                                  <td>
                                    <input type="text" name="company_name_owner<?= $count ?>" id="company_name_owner<?= $count ?>" value="<?= $floor_window['owner_company_name'] ?>" class="ty6 owner_company_name" required="">
                                  </td>
                                  <th>&nbsp;</th>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <th>TEL</th>
                                  <td><input type="text" name="tel_owner<?= $count ?>" id="tel_owner<?= $count ?>" value="<?= $floor_window['company_tel'] ?>" class="mask_tel ty6 window_tel">
                                  </td>
                                  <th>FAX</th>
                                  <td>
                                    <input type="text" name="fax_owner<?= $count ?>" id="fax_owner<?= $count ?>" value="<?= $floor_window['company_fax'] ?>" class="mask_tel ty6 owner_fax">
                                  </td>
                                </tr>
                                  <tr>
                                    <th>Person in charge1</th>
                                    <td>
                                      <input type="text" name="person_in_charge1_owner<?= $count ?>" id="person_in_charge1_owner<?= $count ?>" value="<?= $floor_window['person_in_charge1'] ?>" class="ty3 person_in_charge1">
                                    </td>
                                    <th>Person in charge2</th>
                                    <td>
                                      <input type="text" name="person_in_charge2_owner<?= $count ?>" id="person_in_charge2_owner<?= $count ?>" value="<?= $floor_window['person_in_charge2'] ?>" class="ty3 person_in_charge2">
                                    </td>
                                  </tr>
                                  <tr>
                                   <th>Note</th><td colspan="3" class="col_3"><input name="note_owner<?= $count ?>" id="note_owner<?= $count ?>" value="<?= $floor_window['notes'] ?>" class="owner_note_ty" type="text"></td>
                                  </tr>
                                </tbody>
                              </table>
                              <h4 class="ontable bg_blue bootom_pad">
                                <span class="button-right">
                                  <a id="remove_owner<?= $count ?>" own_id="<?= $floor_window['ownership_management_id'] ?>" class="bg_blue side_button own_back  remove_owner" href="javascript:void(0)" div_id="owner<?= $count ?>" style="display: <?= $count > 1 ?  "inline" : 'none'; ?>">Remove owner</a></span>
                                </h4>
                        </div>


                          <?php
                          $count++;
                        }
                      }
                       ?>
                  </div>
              

                   <table class="newform_info traders_list">
                   <thead>
            <tr class="no_border">
              <td colspan="6" class="bold_td col_full"><input type="checkbox" name="check_all_floor"  id="check_all_floor" value=""> Check all floors</td>
              <td>
                <span class="button-right" style="width: 120px;margin-top: -9px;">
                  <a  class="bg_blue side_button own_back  " href="javascript:void(0)" id="upadte_floor">Updates
                  </a>
                </span>
                </td>
            </tr>
             <tr>
              <th class="check">&nbsp;</th>
              <th class="id_floor">Floor_ID</th>
              <th class="id_floor">Floor ID</th>
              <th class="level_floor">Level of floor</th>
              <th class="size_floor">Size</th>
              <th class="updated_floor">Updated on</th>
             </tr>
             </thead>
             <tbody>


              <?php 
                   if(!empty($comparted_array)){
                     foreach ($comparted_array as $comparted_arrays) {
 
              ?>
              <tr>
                <td colspan="6" class="trader_list">
                <span class="trader_item"><label class="trader_label owner_label bg_blue">Segment ownership</label></span>
                <span class="trader_item"><label class="trader_label window_label bg_lb">Window</label> <?= $comparted_arrays['windows'] ?></span>
                <span class="trader_item"><label class="trader_label owner_label bg_blue">Owner</label> <?= $comparted_arrays['owners'] ?></span></td>
              </tr>
                    <?php 
                      if($comparted_arrays['info']['vacant_schedule']==0){
                              $text="満";
                              $vac_class="no_vacant";
                            }
                            else{
                                 $text="空";
                                 $vac_class="vacant";     
                            }

                    ?>


                  <tr>
                    <td class="check"><input type="checkbox" class="bulk_upadte_floor" name="bulk_upadte_floor[]" value="<?= $comparted_arrays['info']['floor_id']?>"><label class="<?=$vac_class?>  vacant_status"> <?=$text?></label> </td>
                    <td class="id_floor"><?= $comparted_arrays['info']['floorId'] ?></td>
                    <td class="id_floor"><?= $comparted_arrays['info']['floor_id'] ?></td>
                    <td class="level_floor"><?= $comparted_arrays['info']['floor_down'] ?>th floor</td>
                    <td class="size_floor"><?= $comparted_arrays['info']['area_m'] ?>坪</td>
                    <td class="updated_floor"><?= date('Y-m-d', strtotime($comparted_arrays['info']['modified_on'])) ?></td>
                  </tr>
                 <?php
                   }
                  }
                // comparted windows end here

                // multipal windows start here
              if(!empty($multi_window_array)){
                     foreach ($multi_window_array as $comparted_arrays) {
              ?>
              <tr>
                <td colspan="6" class="trader_list">
                <span class="trader_item"><label class="trader_label window_label bg_lb">Window</label> <?= $comparted_arrays['windows'] ?></span>
                <span class="trader_item"><label class="trader_label owner_label bg_blue">Owner</label> <?= $comparted_arrays['owners'] ?></span></td>
              </tr>
                    <?php 
                      if($comparted_arrays['info']['vacant_schedule']==0){
                              $text="満";
                              $vac_class="no_vacant";
                            }
                            else{
                                 $text="空";
                                 $vac_class="vacant";     
                            }

                    ?>


                  <tr>
                    <td class="check"><input type="checkbox" class="bulk_upadte_floor" name="bulk_upadte_floor[]" value="<?= $comparted_arrays['info']['floor_id']?>"></label> </td>
                    <td class="id_floor"><?= $comparted_arrays['info']['floorId'] ?></td>
                    <td class="id_floor"><?= $comparted_arrays['info']['floor_id'] ?></td>
                    <td class="level_floor"><?= $comparted_arrays['info']['floor_down'] ?>th floor</td>
                    <td class="size_floor"><?= $comparted_arrays['info']['area_m'] ?>坪</td>
                    <td class="updated_floor"><?= date('Y-m-d', strtotime($comparted_arrays['info']['modified_on'])) ?></td>
                  </tr>
                 <?php
                   }
                  }
                // multi windows end here 





                //single window and owner started here
                  if(!empty($single_owner_window_array)){
                       foreach ($single_owner_window_array as $single_owner_window_arrays) {
                  ?>
                  <tr>
                    <td colspan="6" class="trader_list">
                    <span class="trader_item"><label class="trader_label window_label bg_lb">Window</label> <?= $single_owner_window_arrays['windows'] ?></span>
                    <span class="trader_item"><label class="trader_label owner_label bg_blue">Owner</label>  <?= $single_owner_window_arrays['owners'] ?></span></td>
                  </tr>
                    <?php  foreach($single_owner_window_arrays['info'] as $info){
                            if($info['vacant_schedule']==0){
                              $text="満";
                              $vac_class="no_vacant";
                            }
                            else{
                                 $text="空";
                                 $vac_class="vacant";     
                            }

                    ?>


                  <tr>
                    <td class="check"><input type="checkbox" class="bulk_upadte_floor" name="bulk_upadte_floor[]" value="<?= $info['floor_id']?>"><label class="<?=$vac_class?>  vacant_status"> <?=$text?></label> </td>
                    <td class="id_floor"><?= $info['floorId'] ?></td>
                    <td class="id_floor"><?= $info['floor_id'] ?></td>
                    <td class="level_floor"><?= $info['floor_down'] ?>th floor</td>
                    <td class="size_floor"><?= $info['area_m'] ?>坪</td>
                    <td class="updated_floor"><?= date('Y-m-d', strtotime($info['modified_on'])) ?></td>
                  </tr>
                 <?php
                    }
                   }
                  }

                  //single window and owner ends here 
                 
                // multipal oweners start here
              if(!empty($multi_owner_array)){
                     foreach ($multi_owner_array as $comparted_arrays) {
              ?>
              <tr>
                <td colspan="6" class="trader_list">
                <span class="trader_item"><label class="trader_label window_label bg_lb">Window</label> <?= $comparted_arrays['windows'] ?></span>
                <span class="trader_item"><label class="trader_label owner_label bg_blue">Owner</label> <?= $comparted_arrays['owners'] ?></span></td>
              </tr>
                    <?php 
                      if($comparted_arrays['info']['vacant_schedule']==0){
                              $text="満";
                              $vac_class="no_vacant";
                            }
                            else{
                                 $text="空";
                                 $vac_class="vacant";     
                            }

                    ?>


                  <tr>
                    <td class="check"><input type="checkbox" class="bulk_upadte_floor" name="bulk_upadte_floor[]" value="<?= $comparted_arrays['info']['floor_id']?>"></label> </td>
                    <td class="id_floor"><?= $comparted_arrays['info']['floorId'] ?></td>
                     <td class="id_floor"><?= $comparted_arrays['info']['floor_id'] ?></td>
                    <td class="level_floor"><?= $comparted_arrays['info']['floor_down'] ?>th floor</td>
                    <td class="size_floor"><?= $comparted_arrays['info']['area_m'] ?>坪</td>
                    <td class="updated_floor"><?= date('Y-m-d', strtotime($comparted_arrays['info']['modified_on'])) ?></td>
                  </tr>
                 <?php
                   }
                  }
                // multi Owners end here 


                  //no owners and windows

              if(!empty($no_owner_window)){
                    
              ?>
              <tr>
                <td colspan="6" class="trader_list">
                <span class="trader_item"><label class="trader_label window_label bg_lb">Window</label> NO Window</span>
                <span class="trader_item"><label class="trader_label owner_label bg_blue">Owner</label> NO Owners</span></td>
              </tr>
                    <?php 
                    foreach ($no_owner_window as $comparted_arrays) {
                      if($comparted_arrays['vacant_schedule']==0){
                              $text="満";
                              $vac_class="no_vacant";
                            }
                            else{
                                 $text="空";
                                 $vac_class="vacant";     
                            }

                    ?>


                  <tr>
                    <td class="check"><input type="checkbox" class="bulk_upadte_floor" name="bulk_upadte_floor[]" value="<?= $comparted_arrays['floor_id']?>"><label class="<?=$vac_class?>  vacant_status"> <?=$text?></label> </td>
                    <td class="id_floor"><?= $comparted_arrays['floorId'] ?></td>
                    <td class="id_floor"><?= $comparted_arrays['floor_id'] ?></td>
                    <td class="level_floor"><?= $comparted_arrays['floor_down'] ?>th floor</td>
                    <td class="size_floor"><?= $comparted_arrays['area_m'] ?>坪</td>
                    <td class="updated_floor"><?= date('Y-m-d', strtotime($comparted_arrays['modified_on'])) ?></td>
                  </tr>
                 <?php
                   }
                  }

              ?>
             
             <tr class="no_border">
                <td colspan="6" class="bold_td col_full" style="margin-top: 10px; position: absolute;">
                  <span class="" style="width: 120px;margin-right: 45px;">
                    <a  class="bg_blue side_button own_back  " href="javascript:void(0)" id="bulk_upadte_floor">
                       Bulk Update
                    </a>
                  </span>
                  <span class="" style="width: 120px;">
                    <a  class="bg_blue side_button own_back  " href="javascript:void(0)" id="bulk_del_floor" style="background-color: #ff0000 !important"> 
                      Bulk Delete
                    </a>
                  </span>
                  </td>
              </tr>
            
             </tbody>
            </table>
          </form>

                    </div>
                </div>
</div><!--/tab_con-->
</div><!--/main-->
<input type="hidden" name="base_url" id="base_url" value="<?php echo Yii::app()->request->baseUrl; ?>">
<input type="hidden" name="" id="unknown_radio" value="<?php echo Yii::app()->controller->__trans('unknown');?>">
<input type="hidden" name="" id="ask_radio" value="<?php echo Yii::app()->controller->__trans('ask');?>">
<input type="hidden" name="" id="undecided_radio" value="<?php echo Yii::app()->controller->__trans('undecided');?>">
<input type="hidden" name="" id="none_radio" value="<?php echo Yii::app()->controller->__trans('none');?>">




<select id="traders_option" style="display: none">
  <option value="0"><?php echo Yii::app()->controller->__trans('saved traders');?>↓</option>
        <?php

        if(!empty($trans_all)){
            foreach($trans_all as $trans_alls){
        $selected = '';
        ?>
        <option value="<?php echo $trans_alls['trader_id']; ?>"  <?php echo $selected; ?>><?php echo $trans_alls['traderId'].' '.$trans_alls['trader_name']; ?></option>
        <?php
            }
        }else{
        ?>
        <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
        <?php
        }
        ?>
</select>

<select name="ownership_type" id="ownership_type" data-role="none" class="ownership_type" style="display: none">
  <option value="">-</option>
    <option value="1" ><?php echo Yii::app()->controller->__trans('owner');?></option>
    <option value="6" ><?php echo Yii::app()->controller->__trans('サブリース');?></option>
    <option value="7" ><?php echo Yii::app()->controller->__trans('貸主代理');?></option>
    <option value="8" ><?php echo Yii::app()->controller->__trans('AM');?></option>
    <option value="10" ><?php echo Yii::app()->controller->__trans('業者');?></option>
    <option value="4" ><?php echo Yii::app()->controller->__trans('intermediary agent');?></option>
    <option value="2" ><?php echo Yii::app()->controller->__trans('management company');?></option>
    <option value="9" ><?php echo Yii::app()->controller->__trans('PM');?></option>
    <option value="3" ><?php echo Yii::app()->controller->__trans('general contractor');?></option>
    <option value="-1" ><?php echo $oSelect0; ?>><?php echo Yii::app()->controller->__trans('unknown');?></option>
</select>
<select name="management_type" id="management_type" data-role="none" class="management_type" style="display: none">
    <option value="">-</option>
    <option value="-1" <?php echo $mSelect1; ?>><?php echo Yii::app()->controller->__trans('unknown');?></option>
    <option value="1" <?php echo $mSelect2; ?>><?php echo Yii::app()->controller->__trans('専任媒介');?></option>
    <option value="2" <?php echo $mSelect3; ?>><?php echo Yii::app()->controller->__trans('一般媒介');?></option>
    <option value="3" <?php echo $mSelect4; ?>><?php echo Yii::app()->controller->__trans('代理');?></option>
    <option value="4" <?php echo $mSelect5; ?>><?php echo Yii::app()->controller->__trans('貸主');?></option>
</select>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.maskedinput.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/update2.js"></script>
</body>
</html>
