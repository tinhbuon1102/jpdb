<?php
/* @var $this FloorController */
/* @var $model Floor */
/* @var $form CActiveForm */
?>
<div class="form">	
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
    <div id="main" class="full-width">
    	<div class="postbox">
        	<header class="m-title btnright">
            	<h1 class="main-title">
					<?php echo Yii::app()->controller->__trans('Add New Floor');?>
                </h1>
                <div class="ttl_fl">
                	<span class="fl_id">
						<?php echo $buildingRandId; ?>
                    </span>
                    <span class="rm-status empty">
						<?php echo Yii::app()->controller->__trans('空');?> 
                    </span>
                    <span class="f_data"> 
                    	<?php if(isset($_GET['id']) && $_GET['id'] != 0 && $_GET['id'] != ""){ ?>
						<?php
							$managementCompartOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$_GET['id'].' AND is_compart = 1 ORDER BY ownership_management_id DESC LIMIT 1');
							if(count($managementCompartOwnerDetails) > 0){
								$isCompart = '区分所有フロア';
						?>
						<span class="labelCompartInSingle">区分所有フロア</span>
						<?
							}
						?>
						<?php
							$managementSharedOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$_GET['id'].' AND is_shared = 1 ORDER BY ownership_management_id DESC LIMIT 1');
							if(count($managementSharedOwnerDetails) > 0){
								$isShared = '共用オーナーフロア';
						?>
						<span class="labelSharedInSingle">共用オーナーフロア</span>
						<?
							}
						?>
                        <?php } ?>
						<?php echo $buildingName; ?>
                    </span>
                </div>
            </header>
            <?php 
			if(isset($_GET['msg']) && $_GET['msg'] == 1){
			?>
            	<div class="message">フロア情報の更新が完了しました</div>
			<?php 
			}
			?>
            <div class="messageManagement hide"></div>
            <div class="tabs">
            	<ul class="tabs__menu">
                	<li><a href="#"><?php echo Yii::app()->controller->__trans('Floor Info');?></a></li>
                    <li><a href="#"><?php echo Yii::app()->controller->__trans('Condominium ownership Info');?></a></li>
                    <li><a href="#"><?php echo Yii::app()->controller->__trans('Update History');?></a></li>
                    <li><a href="#"><?php echo Yii::app()->controller->__trans('共用オーナー');?></a></li>
                </ul>
                <div class="tabs__content">
                	<div class="tabs-item">
                    	<?php $form=$this->beginWidget('CActiveForm', array('id'=>'floor-form','enableAjaxValidation'=>false,));?>
                        <?php echo $form->errorSummary($model); ?>
                        <input type="hidden" name="Floor[buildingId]" id="buildingId" value="<?php echo $buildingId; ?>" />
                        <div id="table-box">
                        	<div class="formbox f-full">
                            	<div class="table-inner">
                                	<table class="edit_input mline tb-floor">
                                    	<tbody>
                                        	<?php $check = 'checked'; ?>
                                            <tr>
                                            	<th class="border-btm-none">
                                                	<input type="checkbox" name="checked[vac_info]" value="1"  style="margin-right:2px;"><?php echo Yii::app()->controller->__trans('vacancy info');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[vac_info]" value="1" <?php echo isset($model->vacancy_info) && $model->vacancy_info == '1' ? $check :''; ?> checked="">
														<?php echo Yii::app()->controller->__trans('空室');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" <?php echo isset($model->vacancy_info) && $model->vacancy_info == '0' ? $check :''; ?> name="Floor[vac_info]" value="0">
														<?php echo Yii::app()->controller->__trans('満室');?>
                                                    </label>
                                                </td>
                                                <th class="border-btm-none">
                                                	<input type="checkbox" name="checked[pre_user]" value="1" style="margin-right:2px;">
                                                    <?php echo Yii::app()->controller->__trans('preceding user');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[pre_user]" value="0" <?php echo isset($model->preceding_user) && $model->preceding_user == '0' ? $check :''; ?> checked="">
                                                        <?php echo Yii::app()->controller->__trans('none');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[pre_user]" <?php echo isset($model->preceding_user) && $model->preceding_user == '1' ? $check :''; ?> value="1">
                                                        <?php echo Yii::app()->controller->__trans('有り');?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th class="border-btm-none"></th>
                                                <td></td>
                                                <th class="border-btm-none"></th>
                                                <td>
                                                	<span class="pre-label">
														<?php echo Yii::app()->controller->__trans('preceding details');?>
                                                    </span>
                                                    <input type="text" id="f_senko_detail" name="Floor[pre_details]" value="<?php echo isset($model->preceding_details) && $model->preceding_details != '' ?  $model->preceding_details:''; ?>" style="width: 150px">
                                                </td>
                                            </tr>
                                            <tr class="last">
                                            	<th></th>
                                                <td></td>
                                                <th></th>
                                                <td>
                                                	<span class="pre-label">
														<?php echo Yii::app()->controller->__trans('preceding confirmation date');?>
                                                    </span>
                                                    <input type="text" id="f_senko_check_datetime" name="Floor[pre_check_datetime]" value="<?php echo isset($model->preceding_check_datetime) && $model->preceding_check_datetime != '' ? $model->preceding_check_datetime : ''; ?>" style="width: 100px">
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[move_date]" value="1" style="margin-right:2px;">
                                                    <?php echo Yii::app()->controller->__trans('move in date');?>
                                                </th>
                                                <td>
													<?php
                                                    $curr_month = date("m");
													$month = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
													$month = array_slice($month, $curr_month-1);
													$monthAll = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
													$currYear = date("Y");
													$fullyear = date("Y");
													$setLoopForYear = $currYear+5;
													$select = "<select name=\"Floor[move_date]\" class=\"f_rentstart\" id=\"moving_date\">\n <option value='0'>-</option>";
													$selectOpt1 = $selectOpt2 = $selectOpt3 = '';
													if($model->move_in_date == '即'){
														$selectOpt1 = 'selected';
													}
													if($model->move_in_date == Yii::app()->controller->__trans('ask')){
														$selectOpt2 = 'selected';
													}
													if($model->move_in_date == Yii::app()->controller->__trans('undecided')){
														$selectOpt3 = 'selected';
													}
													$select .= "\t<option val='即' ".$selectOpt1.">".Yii::app()->controller->__trans('即')."</option>\n";
													$select .= "\t<option val='".Yii::app()->controller->__trans('ask')."' ".$selectOpt2.">".Yii::app()->controller->__trans('ask')."</option>\n";
													$select .= "\t<option val='".Yii::app()->controller->__trans('undecided')."' ".$selectOpt3.">".Yii::app()->controller->__trans('undecided')."</option>\n";
													for($i=$currYear; $i <= $setLoopForYear; $i++){
														if($i == $currYear){
															$month = $month;
														}else{
															$month = $monthAll;
														}
														foreach($month as $key => $val){
															$convertedMonth = date('m',strtotime($val));
															$select .= "\t<optgroup val=\"".$key."\" label=\"".$fullyear."年".$convertedMonth."月\">";
															if($key == 0 && $currYear == $fullyear){
																$months = date('m',strtotime($val));
																$number = cal_days_in_month(CAL_GREGORIAN, $months, $fullyear);
																$select_1 = '';
																if($model->move_in_date ==$fullyear."/".$months."/月内"){
																	$select_1 = 'selected';
																}
																$select .= "\t<option val='".$fullyear."/".$months."/月内'".$select_1.">".$fullyear."/".$months."/月内</option>\n";
																$select_2 = '';
																if($model->move_in_date ==$fullyear."/".$months."/上旬"){
																	$select_2 = 'selected';
																}
																$select .= "\t<option val='".$fullyear."/".$months."/上旬'".$select_2.">".$fullyear."/".$months."/上旬</option>\n";
																$select_3 = '';
																if($model->move_in_date ==$fullyear."/".$months."/中旬"){
																	$select_3 = 'selected';
																}
																$select .= "\t<option val='".$fullyear."/".$months."/中旬'".$select_3.">".$fullyear."/".$months."/中旬</option>\n";
																$select_4 = '';
																if($model->move_in_date ==$fullyear."/".$months."/下旬"){
																	$select_4 = 'selected';
																}
																$select .= "\t<option val='".$fullyear."/".$months."/下旬'".$select_4.">".$fullyear."/".$months."/下旬</option>\n";
																for($j=1;$j<=$number;$j++){
																	if($model->move_in_date == $fullyear."/".$months."/".$j){
																		$selected ='selected';
																	}else{
																		$selected ='';
																	}
																	$select .= "\t<option val=\"".$fullyear."/".$months."/".$j."\"".$selected.">".$fullyear."/".$months."/".$j."</option>\n";
																}
																$select .= "</optgroup>\n";
															}else{
																$months = date('m',strtotime($val));
																$number = cal_days_in_month(CAL_GREGORIAN, $months, $fullyear);
																$select_1 = '';
																if($model->move_in_date ==$fullyear."/".$months."/月内"){
																	$select_1 = 'selected';
																}
																$select .= "\t<option val='".$fullyear."/".$months."/月内'".$select_1.">".$fullyear."/".$months."/月内</option>\n";
																$select_2 = '';
																if($model->move_in_date ==$fullyear."/".$months."/上旬"){
																	$select_2 = 'selected';
																}
																$select .= "\t<option val='".$fullyear."/".$months."/上旬'".$select_2.">".$fullyear."/".$months."/上旬</option>\n";
																$select_3 = '';
																if($model->move_in_date ==$fullyear."/".$months."/中旬"){
																	$select_3 = 'selected';
																}
																$select .= "\t<option val='".$fullyear."/".$months."/中旬'".$select_3.">".$fullyear."/".$months."/中旬</option>\n";
																$select_4 = '';
																if($model->move_in_date ==$fullyear."/".$months."/下旬"){
																	$select_4 = 'selected';
																}
																$select .= "\t<option val='".$fullyear."/".$months."/下旬'".$select_4.">".$fullyear."/".$months."/下旬</option>\n";
																for($j=1;$j<=$number;$j++){
																	if($model->move_in_date == $fullyear."/".$months."/".$j){
																		$selected ='selected';
																	}else{
																		$selected ='';
																	}
																	$select .= "\t<option val=\"".$fullyear."/".$months."/".$j."\"".$selected.">".$fullyear."/".$months."/".$j."</option>\n";
																}
																$select .= "</optgroup>\n";
															}
														}
														$fullyear++;
													}
													$select .= "</select>";
													echo $select;
													?><br>
                                                    <?php if(!isset($_GET['bid'])){ ?>
                                                    <span class="last_data">
														<?php
                                                        	$fDetails = Floor::model()->findByPK($_GET['id']);
															echo Yii::app()->controller->__trans('前回');
														?>：<?php echo date('Y/m/d',strtotime($fDetails['modified_on'])); ?>
                                                    </span>
                                                    <?php } ?>
                                                </td>
                                                <th>
                                                	<input type="checkbox" name="checked[vac_sche]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('vacant schedule');?>
                                                </th>
                                                <td>
													<?php
                                                    $curr_month = date("m");
													$month = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
													$month = array_slice($month, $curr_month-1);
                                                    $monthAll = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
                                                    $currYear = date("Y");
                                                    $fullyear = date("Y");
                                                    $setLoopForYear = $currYear+17;
                                                    $select = "<select name=\"Floor[vac_sche]\" class=\"f_rentstart\" id=\"vac_schedule\">\n <option value='0'>-</option>";
                                                    for($i=$currYear; $i <= $setLoopForYear; $i++){
														if($i == $currYear){
															$month = $month;
														}else{
															$month = $monthAll;
														}
                                                        //$month = $monthAll;
                                                        foreach($month as $key => $val){
                                                            $convertedMonth = date('m',strtotime($val));
                                                            $select .= "\t<optgroup val=\"".$key."\" label=\"".$fullyear."年".$convertedMonth."月\">";
                                                            if($key == 0 &&  $currYear == $fullyear){
                                                                $months = date('m',strtotime($val));
                                                                $number = cal_days_in_month(CAL_GREGORIAN, $months, $fullyear);
																$select_1 = $select_2 = $select_3 = $select_4 = '';
                                                                if($model->vacant_schedule == $fullyear."/".$months."/月内"){
                                                                    $select_1 = 'selected';
                                                                }elseif($model->vacant_schedule == $fullyear."/".$months."/上旬"){
                                                                    $select_2 = 'selected';
                                                                }elseif($model->vacant_schedule == $fullyear."/".$months."/中旬"){
                                                                    $select_3 = 'selected';
                                                                }elseif($model->vacant_schedule == $fullyear."/".$months."/下旬"){
                                                                    $select_4 = 'selected';
                                                                }
																
                                                                $select .= "\t<option val='".$fullyear."/".$months."/月内'".$select_1.">".$fullyear."/".$months."/月内</option>\n";
                                                                
                                                                $select .= "\t<option val='".$fullyear."/".$months."/上旬'".$select_2.">".$fullyear."/".$months."/上旬</option>\n";
                                                                
                                                                $select .= "\t<option val='".$fullyear."/".$months."/中旬'".$select_3.">".$fullyear."/".$months."/中旬</option>\n";
                                                                
                                                                $select .= "\t<option val='".$fullyear."/".$months."/下旬'".$select_4.">".$fullyear."/".$months."/下旬</option>\n";
                                                                for($j=1;$j<=$number;$j++){
                                                                    if($model->vacant_schedule == $fullyear."/".$months."/".$j){
                                                                        $selected ='selected';
                                                                    }else{
                                                                        $selected ='';
                                                                    }
                                                                    $select .= "\t<option val=\"".$fullyear."/".$months."/".$j."\"".$selected.">".$fullyear."/".$months."/".$j."</option>\n";
                                                                }
                                                                $select .= "</optgroup>\n";
                                                            }else{
                                                                $months = date('m',strtotime($val));
                                                                $number = cal_days_in_month(CAL_GREGORIAN, $months, $fullyear);
																$select_1 = '';
                                                                if($model->vacant_schedule ==$fullyear."/".$months."/月内"){
                                                                    $select_1 = 'selected';
                                                                }
                                                                $select .= "\t<option val='".$fullyear."/".$months."/月内'".$select_1.">".$fullyear."/".$months."/月内</option>\n";
                                                                $select_2 = '';
                                                                if($model->vacant_schedule ==$fullyear."/".$months."/上旬"){
                                                                    $select_2 = 'selected';
                                                                }
                                                                $select .= "\t<option val='".$fullyear."/".$months."/上旬'".$select_2.">".$fullyear."/".$months."/上旬</option>\n";
                                                                $select_3 = '';
                                                                if($model->vacant_schedule ==$fullyear."/".$months."/中旬"){
                                                                    $select_3 = 'selected';
                                                                }
                                                                $select .= "\t<option val='".$fullyear."/".$months."/中旬'".$select_3.">".$fullyear."/".$months."/中旬</option>\n";
                                                                $select_4 = '';
                                                                if($model->vacant_schedule ==$fullyear."/".$months."/下旬"){
                                                                    $select_4 = 'selected';
                                                                }
                                                                $select .= "\t<option val='".$fullyear."/".$months."/下旬'".$select_4.">".$fullyear."/".$months."/下旬</option>\n";
                                                                for($j=1;$j<=$number;$j++){
                                                                    if($model->vacant_schedule == $fullyear."/".$months."/".$j){
                                                                        $selected ='selected';
                                                                    }else{
                                                                        $selected ='';
                                                                    }
                                                                    $select .= "\t<option val=\"".$fullyear."/".$months."/".$j."\"".$selected.">".$fullyear."/".$months."/".$j."</option>\n";
                                                                }
                                                                $select .= "</optgroup>\n";
                                                            }
                                                        }
                                                        $fullyear++;
                                                    }
                                                    $select .= "</select>";
                                                    echo $select;
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="dotted-border"></div>
									<script type="text/javascript">
									$(function(){
										$("#f_senko_check_datetime").datepicker();
										$("#f_senko_check_datetime").datepicker("option", $.datepicker.regional["ja"]);
									});
                                    </script>
                                    <table class="edit_input f_info_b mline tb-floor one-col">
                                    	<tbody>
                                        	<tr>
                                            	<th>
													<?php echo Yii::app()->controller->__trans('number of stairs');?>
                                                </th>
                                                <td>
                                                	<input type="text" name="Floor[floor_down]" id="floor_down" value ="<?php echo isset($model->floor_down) && $model->floor_down != '' ?  $model->floor_down:''; ?>" class="ty8">
                                                    <?php echo Yii::app()->controller->__trans('F');?> ～
                                                    <input type="text" name="Floor[floor_up]" id="floor_up" value ="<?php echo isset($model->floor_up) && $model->floor_up != '' ?  $model->floor_up:''; ?>" class="ty8">
                                                    <?php echo Yii::app()->controller->__trans('F');?>
                                                    <ul class="att">
                                                    	<li>※<?php echo Yii::app()->controller->__trans('If the floor is basement floor,type "-" before number ex：-2');?></li>
                                                        <li>※<?php echo Yii::app()->controller->__trans('If the floor is on multiple floors, input second field too. ex:2F~4F');?></li>
                                                        <li>※<?php echo Yii::app()->controller->__trans('If the floor is middle of floor,input with 0.5 ex：If the floor is M3,it gonna be 3.5F');?></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
													<?php echo Yii::app()->controller->__trans('room no');?>
                                                </th>
                                                <td>
                                                	<input type="text" name="Floor[roomname]" value ="<?php echo isset($model->roomname) && $model->roomname != '' ?  $model->roomname:''; ?>" class="ty1 room_no"> &nbsp;&nbsp;<span class="resperror" style="display:none"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[maisonette_type]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('maisonette type');?>
                                                </th>
												<?php $check = 'checked'; ?>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[maisonette_type]" value="0" <?php echo isset($model->maisonette_type) && $model->maisonette_type == '0' ? $check :''; ?> checked="">
														<?php echo Yii::app()->controller->__trans('NO');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[maisonette_type]" <?php echo isset($model->maisonette_type) && $model->maisonette_type == '1' ? $check :''; ?> value="1">
														<?php echo Yii::app()->controller->__trans('YES');?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[short_term_rent]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('short term rent');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[short_term_rent]" <?php echo isset($model->short_term_rent) && $model->short_term_rent == '0' ? $check :''; ?> value="0" checked="">
														<?php echo Yii::app()->controller->__trans('NO');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[short_term_rent]"  <?php echo isset($model->short_term_rent) && $model->short_term_rent == '1' ? $check :''; ?> value="1">
														<?php echo Yii::app()->controller->__trans('YES');?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[type_of_use]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('type of use');?> 
                                                </th>
                                                <td>
													<?php
                                                    if(isset($model->type_of_use) && $model->type_of_use !=''){
														$typeOfUses = explode(',',$model->type_of_use);
													}else{
														$typeOfUses = array();
													}
													$i = 0;
													if(isset($useTypesDetails) && $useTypesDetails != ''){
														$url =  Yii::app()->controller->action->id;
														foreach($useTypesDetails as $useTypeList){
															$checked = '';
															if($url == 'update'){
																if(in_array($useTypeList['user_type_id'],$typeOfUses)){
																	$checked = 'checked';
																}
															}else{
																if($i == 0){
																	$checked = 'checked';
																}
															}
													?>
                                                    <label class="rd2 2">
                                                    	<input type="checkbox" name="Floor[type_of_use][]" value="<?php echo $useTypeList['user_type_id']; ?>" <?php echo $checked; ?>>
														<?php echo Yii::app()->controller->__trans($useTypeList['user_type_name']);?>
                                                    </label>
													<?php
                                                    	$i++;
														}
													}
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[area_ping]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('area');?>
                                                </th>
                                                <td>
                                                	<input type="text" <?php echo $model->area_ping; ?> name="Floor[area_ping]" id="area-tsubo" value="<?php echo isset($model->area_ping) && $model->area_ping != '' ? $model->area_ping :''; ?>" class="ty1">
													<?php echo Yii::app()->controller->__trans('坪');?>
                                                    <input type="button" class="ty-ex" id='area-con-btn_reverse' value="←">
                                                    <input type="button" class="ty-ex" id='area-con-btn' value="→">
                                                    <input type="text" name="Floor[area_m]" id="area-m2" value="<?php echo isset($model->area_m) && $model->area_m != '' ? $model->area_m :''; ?>"  class="ty1">
													<?php echo Yii::app()->controller->__trans('m');?><sup>2</sup> <?php echo Yii::app()->controller->__trans('Net');?>：
                                                    <input type="text" name="Floor[area_net]" id="f_acreg_net" value="<?php echo isset($model->area_net) && $model->area_net != '' ? $model->area_net :''; ?>" class="ty1">
													<?php echo Yii::app()->controller->__trans('坪');?>
                                                </td>
                                            </tr>
                                            <tr>
												<?php $check = 'checked'; ?>
                                                <th>
                                                	<input type="checkbox" name="checked[calculation_method]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('calculation method');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[calculation_method]" value="1" <?php echo isset($model->calculation_method) && $model->calculation_method == '1' ?  $check :''; ?>>
														<?php echo Yii::app()->controller->__trans('Net');?>
                                                 	</label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[calculation_method]" value="2" <?php echo isset($model->calculation_method) && $model->calculation_method == '2' ?  $check :''; ?>>
														<?php echo Yii::app()->controller->__trans('Gross');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[calculation_method]" value="0" <?php echo isset($model->calculation_method) && $model->calculation_method == '0' ?  $check :''; ?>>
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
													<?php echo Yii::app()->controller->__trans('Core section');?>
                                                </th>
                                                <td>
                                                	<input type="checkbox" name="Floor[core_section]" value="1" <?php echo isset($model->core_section) && $model->core_section == '1' ?  $check :''; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
													<?php echo Yii::app()->controller->__trans('High Grade Building');?>
                                                </th>
                                                <td>
                                                	<input type="checkbox" name="Floor[high_grade_building]" value="1" <?php echo isset($model->high_grade_building) && $model->high_grade_building == '1' ?  $check :''; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[payment_by_installments]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('payment by installments');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[payment_by_installments]" value="1" <?php echo isset($model->payment_by_installments) && $model->payment_by_installments == '1' ?  $check :''; ?>>
														<?php echo Yii::app()->controller->__trans('installments example');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[payment_by_installments]" value="2" <?php echo isset($model->payment_by_installments) && $model->payment_by_installments == '2' ?  $check :''; ?>>
														<?php echo Yii::app()->controller->__trans('possible to installments');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[payment_by_installments]" value="0" <?php echo isset($model->payment_by_installments) && $model->payment_by_installments == '0' ?  $check :''; ?>>
														<?php echo Yii::app()->controller->__trans('NO');?>
                                                    </label> | 
													<?php echo Yii::app()->controller->__trans('installments notes');?>：
                                                    <input type="text" name="Floor[payment_by_installments_detail]" class="ty7" value="<?php echo isset($model->payment_by_installments_note) && $model->payment_by_installments_note != '' ? $model->payment_by_installments_note :''; ?>" size="40">
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[floor_partition]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('devided area');?>
                                                </th>
                                                <td>
                                                	<input type="text" id="dividedArea"  class="ty1">
													<?php echo Yii::app()->controller->__trans('坪');?>
                                                    <input type="button" class="sm-btn" id='addTxtDevided' value="<?php echo Yii::app()->controller->__trans('ADD');?>"><br/>
													<?php
                                                    if(isset($model->floor_partition) && $model->floor_partition != ''){
														$dvdTxt = explode(',',$model->floor_partition);
														foreach($dvdTxt as $txt){
															echo '<div class="divDivided">
																<input type="text"  name="Floor[floor_partition][]" value ='.$txt.' class="ty1 divideTxt">'.Yii::app()->controller->__trans('坪').'
																<input type="button" class="sm-btn btnDelete" id="btnDelete" value="'.Yii::app()->controller->__trans('Delete').'">
															</div>';
														}
													}
													?>
                                                    <div id="acreg_partition_list"></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="dotted-border"></div>
                                    <table class="edit_input f_info mline tb-floor col-two">
                                    	<tbody>
                                        	<tr class="last">
                                            	<th>
                                                	<input type="checkbox" name="checked[rent_unit_price_opt]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('rent unit price');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" class="price_rent" name="Floor[rent_unit_price_opt]" <?php echo isset($model->rent_unit_price_opt) && $model->rent_unit_price_opt == '-1' ?  $check :''; ?> value="-1" id="rent_radio1">
														<?php echo Yii::app()->controller->__trans('undecided');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" class="price_rent" name="Floor[rent_unit_price_opt]" <?php echo isset($model->rent_unit_price_opt) && $model->rent_unit_price_opt == '-2' ?  $check :''; ?> value="-2"  id="rent_radio2">
														<?php echo Yii::app()->controller->__trans('ask');?>
                                                    </label><br>
                                                    <input type="text" name="Floor[rent_unit_price]" value="<?php echo isset($model->rent_unit_price) && $model->rent_unit_price != '' && $model->rent_unit_price != 0 ? HelperFunctions::formatNumber(str_replace(',','',$model->rent_unit_price)) :''; ?>" id="rent_unit_price" class="ty1 mt price_rent rent_unit_price">
													<?php echo Yii::app()->controller->__trans('yen/坪');?>
                                                </td>
                                                <th>
                                                	<input type="checkbox" name="checked[total_rent_price]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('total rent price');?>
                                                </th>
                                                <td>
                                                	<input type="text"  name="Floor[total_rent_price]" id="total_rent_price" value="<?php echo isset($model->total_rent_price) && $model->total_rent_price != '' ?  HelperFunctions::formatNumber(str_replace(',','',$model->total_rent_price)) :''; ?>" class="ty1 price_rent">
                                                   
													<?php echo Yii::app()->controller->__trans('yen');?>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[unit_condo_fee_opt]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('unit condo fee');?>
                                                </th>
                                                <td>
                                                	<?php
													if(isset($model->unit_condo_fee) && $model->unit_condo_fee != ""){
														$model->unit_condo_fee_opt = '';
													}
													?>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[unit_condo_fee_opt]" class="price_mente" <?php echo isset($model->unit_condo_fee_opt) && $model->unit_condo_fee_opt == '0' ?  $check :''; ?> value="0">
														<?php echo Yii::app()->controller->__trans('none');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[unit_condo_fee_opt]" class="price_mente" <?php echo isset($model->unit_condo_fee_opt) && $model->unit_condo_fee_opt == '-1' ?  $check :''; ?>  value="-1">
														<?php echo Yii::app()->controller->__trans('undecided');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[unit_condo_fee_opt]" class="price_mente" <?php echo isset($model->unit_condo_fee_opt) && $model->unit_condo_fee_opt == '-2' ?  $check :''; ?> value="-2">
														<?php echo Yii::app()->controller->__trans('ask');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[unit_condo_fee_opt]" class="price_mente" <?php echo isset($model->unit_condo_fee_opt) && $model->unit_condo_fee_opt == '-3' ?  $check :''; ?> value="-3">
														<?php echo Yii::app()->controller->__trans('include');?>
                                                    </label><br>
                                                    <input type="text" name="Floor[unit_condo_fee]" id="unit_condo_fee" value="<?php echo isset($model->unit_condo_fee) && $model->unit_condo_fee != '' ? HelperFunctions::formatNumber($model->unit_condo_fee) :''; ?>" class="ty1 mt price_mente unit_condo_fee">
													<?php echo Yii::app()->controller->__trans('yen/坪');?>
                                                </td>
                                                <th class="m">
                                                	<input type="checkbox" name="checked[total_condo_fee]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('total condo fee');?>
                                                </th>
                                                <td>
                                                	<input type="text" name="Floor[total_condo_fee]" id="total_condo_fee" value="<?php echo isset($model->total_condo_fee) && $model->total_condo_fee != '' ? ($model->total_condo_fee) :''; ?>" class="ty1 price_mente">
													<?php echo Yii::app()->controller->__trans('yen');?>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="4">
                                                	<div class="ch_tax">
                                                    	<input type="button" class="sm-btn barrow" value=" <?php echo Yii::app()->controller->__trans('change price to price without tax');?>" id= "change_price_without_tax">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="dotted-border"></div>
                                    <table class="edit_input f_info mline tb-floor col-two">
                                    	<tbody>
                                        	<tr>
                                            	<th class="m"><input type="checkbox" name="checked[deposit_opt]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('deposit');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" class="price_shiki clearinput" data-input="deposit_opt_i" name="Floor[deposit_opt]" <?php echo isset($model->deposit_opt) && $model->deposit_opt == '-1' ?  $check :''; ?> value="-1">
														<?php echo Yii::app()->controller->__trans('undecided');?>
                                                   	</label>
                                                    <label class="rd2">
                                                    	<input type="radio" class="price_shiki clearinput" data-input="deposit_opt_i" name="Floor[deposit_opt]" <?php echo isset($model->deposit_opt) && $model->deposit_opt == '-3' ?  $check :''; ?> value="-3">
                                                        <?php echo Yii::app()->controller->__trans('none');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" class="price_shiki clearinput" data-input="deposit_opt_i" name="Floor[deposit_opt]" <?php echo isset($model->deposit_opt) && $model->deposit_opt == '-2' ?  $check :''; ?> value="-2">
                                                        <?php echo Yii::app()->controller->__trans('undecided･ask');?>
                                                    </label>
                                                    <p>--</p>
                                                    <label class="rd2">
                                                    	<span class="double-input">
                                                        	<input type="text" name="Floor[deposit_month]" id="f_price_m_shiki" value="<?php echo isset($model->deposit_month) && $model->deposit_month != '' ? $model->deposit_month :''; ?>" class="ty8 mt price_shiki deposit_month deposit_opt_i" maxlength="2">
																<?php echo Yii::app()->controller->__trans('months分');?>
                                                        </span>
                                                        <span class="double-input">
                                                        	<input type="text" name="Floor[deposit]" id="f_price_t_shiki" value="<?php echo isset($model->deposit) && $model->deposit != '' ? HelperFunctions::formatNumber($model->deposit) :''; ?>" class="ty1 mt price_shiki deposit_opt_i">
															<?php echo Yii::app()->controller->__trans('yen/坪');?>
                                                        </span>
                                                    </label>
                                                </td>
                                                <th class="m">
                                                	<input type="checkbox" name="checked[total_deposit]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('total deposit');?>
                                                </th>
                                                <td>
                                                	<input type="text" name="Floor[total_deposit]" id="f_price_a_shiki" value="<?php echo isset($model->total_deposit) && $model->total_deposit != '' ? HelperFunctions::formatNumber($model->total_deposit) :''; ?>" class="ty1 price_shiki deposit_opt_i">
													<?php echo Yii::app()->controller->__trans('yen');?>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th class="m">
                                                	<input type="checkbox" name="checked[key_money_opt]" value="1"  style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('key money');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" class="price_keymoney clearinput" data-input="key_input" name="Floor[key_money_opt]" <?php echo isset($model->key_money_opt) && $model->key_money_opt == '2' ?  $check :''; ?> value="2">
														<?php echo Yii::app()->controller->__trans('none');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" class="price_keymoney clearinput" data-input="key_input" name="Floor[key_money_opt]" <?php echo isset($model->key_money_opt) && $model->key_money_opt == '-1' ?  $check :''; ?> value="-1">
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" class="price_keymoney clearinput" data-input="key_input" name="Floor[key_money_opt]"  <?php echo isset($model->key_money_opt) && $model->key_money_opt == '-2' ?  $check :''; ?> value="-2">
														<?php echo Yii::app()->controller->__trans('undecided･ask');?>
                                                    </label>
                                                    <p>--</p>
                                                    <input type="text" name="Floor[key_money_month]" value="<?php echo isset($model->key_money_month) && $model->key_money_month != '' ? $model->key_money_month :''; ?>" class="ty8 price_keymoney key_money_month key_input">
													<?php echo Yii::app()->controller->__trans('months');?>
                                                </td>
                                                <th>
                                                	<input type="checkbox" name="checked[repayment_opt]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('repayment');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[repayment_opt]" class="price_amo price_amo_opt clearinput" data-input="repayment_opt_input" <?php echo isset($model->repayment_opt) && $model->repayment_opt == '-3' ?  $check :''; ?> value="-3">
														<?php echo Yii::app()->controller->__trans('none');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[repayment_opt]" class="price_amo price_amo_opt clearinput" data-input="repayment_opt_input" <?php echo isset($model->repayment_opt) && $model->repayment_opt == '-4' ?  $check :''; ?> value="-4">
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[repayment_opt]" class="price_amo price_amo_opt clearinput" data-input="repayment_opt_input" <?php echo isset($model->repayment_opt) && $model->repayment_opt == '-1' ?  $check :''; ?> value="-1">
														<?php echo Yii::app()->controller->__trans('undecided');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[repayment_opt]" class="price_amo price_amo_opt clearinput" data-input="repayment_opt_input" <?php echo isset($model->repayment_opt) && $model->repayment_opt == '-2' ?  $check :''; ?> value="-2">
														<?php echo Yii::app()->controller->__trans('ask');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[repayment_opt]" class="price_amo price_amo_opt clearinput" data-input="repayment_opt_input" <?php echo isset($model->repayment_opt) && $model->repayment_opt == '-5' ?  $check :''; ?> value="-5">
														<?php echo Yii::app()->controller->__trans('スライド式');?>
                                                    </label>
                                                    <p>--</p>
													<?php $sel = 'selected'; ?>
                                                    <select name="Floor[repayment_reason]" id="f_price_amo_timeflag" data-role="none" class="repaymentReasonDrop repayment_opt_input">
                                                    	<option value="" selected=""></option>
                                                        <option value="1" <?php echo isset($model->repayment_reason) && $model->repayment_reason == '1' ?  $sel :''; ?>><?php echo Yii::app()->controller->__trans('現賃料の');?></option>
                                                        <option value="2" <?php echo isset($model->repayment_reason) && $model->repayment_reason == '2' ?  $sel :''; ?>><?php echo Yii::app()->controller->__trans('解約時賃料の');?></option>
                                                    </select>
                                                    <input type="text" name="Floor[repayment_amt]" value="<?php echo isset($model->repayment_amt) && $model->repayment_amt != '' ? $model->repayment_amt :''; ?>" class="ty8 mt price_amo repayment_amt repayment_opt_input">
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[repayment_amt_opt]" class="repayment_opt_input repaymentAmtOpt" <?php echo isset($model->repayment_amt_opt) && $model->repayment_amt_opt == '1' ?  $check :''; ?> value="1">
														<?php echo Yii::app()->controller->__trans('months');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[repayment_amt_opt]" class="repayment_opt_input repaymentAmtOpt" <?php echo isset($model->repayment_amt_opt) && $model->repayment_amt_opt == '2' ?  $check :''; ?> value="2">
														<?php echo Yii::app()->controller->__trans('%');?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th class="m"><input type="checkbox" name="checked[renewal_fee_opt]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('renewal fee');?>
                                            	</th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[renewal_fee_opt]"  <?php echo isset($model->renewal_fee_opt) && $model->renewal_fee_opt == '2' ?  $check :''; ?> class="price_rerent clearinput" data-input="price_rerent_input" value="2">
														<?php echo Yii::app()->controller->__trans('none');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[renewal_fee_opt]" <?php echo isset($model->renewal_fee_opt) && $model->renewal_fee_opt == '-1' ?  $check :''; ?> class="price_rerent clearinput" data-input="price_rerent_input" value="-1">
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[renewal_fee_opt]" <?php echo isset($model->renewal_fee_opt) && $model->renewal_fee_opt == '-2' ?  $check :''; ?> class="price_rerent clearinput" data-input="price_rerent_input" value="-2">
														<?php echo Yii::app()->controller->__trans('undecided･ask');?>
                                                    </label>
                                                    <p>--</p>
													<?php $sele_ren = 'selected'; ?>
                                                    <select name="Floor[renewal_fee_reason]" id="f_price_rerent_timeflag" data-role="none" class="auto  price_rerent_input clearinput">
                                                    	<option value="">--- </option>
                                                        <option value="1"  <?php echo isset($model->renewal_fee_reason) && $model->renewal_fee_reason == '1' ?  $sele_ren :''; ?>><?php echo Yii::app()->controller->__trans('現賃料の');?></option>
                                                        <option value="2" <?php echo isset($model->renewal_fee_reason) && $model->renewal_fee_reason == '2' ?  $sele_ren :''; ?>><?php echo Yii::app()->controller->__trans('新賃料の');?></option>
                                                    </select>
                                                    <input type="text" id="frenfr" name="Floor[renewal_fee_recent]" value="<?php echo isset($model->renewal_fee_recent) && $model->renewal_fee_recent != '' ? $model->renewal_fee_recent :''; ?>"  class="ty8 mt price_rerent renewal_fee_recent price_rerent_input clearinput">
													<?php echo Yii::app()->controller->__trans('months');?>
                                                </td>
                                                <th>
                                                	<input type="checkbox" name="checked[repayment_notes]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('repayment notes');?>
                                                </th>
                                                <td>
                                                	<input type="text" name="Floor[repayment_notes]" value="<?php echo isset($model->repayment_notes) && $model->repayment_notes != '' ? $model->repayment_notes :''; ?>" class="ty2 price_amo">
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[notice_of_cancellation]"  value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('notice of cancellation');?>
                                                </th>
                                                <td>
                                                	<input type="text" name="Floor[notice_of_cancellation]" value="<?php echo isset($model->notice_of_cancellation) && $model->notice_of_cancellation != '' ? $model->notice_of_cancellation :''; ?>" class="ty8">
													<?php echo Yii::app()->controller->__trans('months');?>
                                                </td>
                                                <th>
                                                	<input type="checkbox" name="checked[contract_period_opt]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('contract period');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[contract_period_opt]" value="1" <?php echo isset($model->contract_period_opt) && $model->contract_period_opt == '1' ?  $check :''; ?>>                            <?php echo Yii::app()->controller->__trans('普通借家');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[contract_period_opt]" value="2" <?php echo isset($model->contract_period_opt) && $model->contract_period_opt == '2' ?  $check :''; ?>>
														<?php echo Yii::app()->controller->__trans('定借');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[contract_period_opt]" value="3" <?php echo isset($model->contract_period_opt) && $model->contract_period_opt == '3' ?  $check :''; ?>>
														<?php echo Yii::app()->controller->__trans('定借希望');?>
                                                    </label><br>
                                                    <input type="text" size="3" name="Floor[contract_period_duration]" value="<?php echo isset($model->contract_period_duration) && $model->contract_period_duration != '' ? $model->contract_period_duration :''; ?>" class="ty8 mt contractDuration">
													<?php echo Yii::app()->controller->__trans('年');?>
                                                    <br>
                                                    <label class="rd2">
                                                    	<input type="checkbox" name="Floor[contract_period_optchk]" value="1" class="contractDurationOptNew" <?php echo isset($model->contract_period_optchk) && $model->contract_period_optchk == '1' ?  $check :''; ?>>
														<?php echo Yii::app()->controller->__trans('年数相談');?>
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="dotted-border"></div>
                                    <table class="edit_input f_info_b mline tb-floor one-col">
                                    	<tbody>
                                        	<tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[air_conditioning_facility_type]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('air conditioning');?>
                                                </th>
                                                <td>
													<?php echo Yii::app()->controller->__trans('facility type');?>
													<?php $select1='selected'; ?>
                                                    <select name="Floor[air_conditioning_facility_type]" class="auto">
                                                    	<option value="unknown" <?php echo isset($model->air_conditioning_facility_type) && $model->air_conditioning_facility_type == 'unknown' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                                        <option value="個別" <?php echo isset($model->air_conditioning_facility_type) && $model->air_conditioning_facility_type == '個別' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('個別');?></option>
                                                        <option value="セントラル"<?php echo isset($model->air_conditioning_facility_type) && $model->air_conditioning_facility_type == 'セントラル' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('セントラル');?></option>
                                                        <option value="個別・セントラル"<?php echo isset($model->air_conditioning_facility_type) && $model->air_conditioning_facility_type == '個別・セントラル' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('個別・セントラル');?></option>
                                                        <option value="なし"<?php echo isset($model->air_conditioning_facility_type) && $model->air_conditioning_facility_type == 'なし' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('なし');?></option>
                                                   	</select>
													<?php echo Yii::app()->controller->__trans('details');?>
                                                    <input type="text" name="Floor[air_conditioning_details]" value="<?php echo isset($model->air_conditioning_details) && $model->air_conditioning_details != '' ? $model->air_conditioning_details :''; ?>" class="ty6">
                                                </td>
                                            </tr>
                                            <tr>
												<?php
                                                	$week_start = $week_finish = $sat_start = $sat_finish = $sun_start = $sun_finish ='';
													//print_r($model->air_conditioning_time_used);die;
													if(isset($model->air_conditioning_time_used) && $model->air_conditioning_time_used != ''){
														$entOpclTime = explode('-',$model->air_conditioning_time_used);
														if(isset($entOpclTime) && count ($entOpclTime ) > 0 ){
															if(isset($entOpclTime[1]) && $entOpclTime[1] != ''){
																$week_start_finish = explode('~',$entOpclTime[1]);
																$week_start = $week_start_finish[0];
																$week_finish = $week_start_finish[1];
															}
															if(isset($entOpclTime[2]) && $entOpclTime[2] != ''){
																$sat_start_finish = explode('~',$entOpclTime[2]);
																$sat_start = $sat_start_finish[0];
																$sat_finish = $sat_start_finish[1];
															}
															if(isset($entOpclTime[3]) && $entOpclTime[3] != ''){
																$sun_start_finish = explode('~',$entOpclTime[3]);
																$sun_start = $sun_start_finish[0];
																$sun_finish = $sun_start_finish[1];
															}
														}
													}
												?>
                                                <th>
                                                	<input type="checkbox" name="checked[air_conditioning_time_used]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('time to use air conditioning');?>
                                                </th>
                                                <td class="time-range">
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[air_conditioning_time_used]" <?php echo isset($entOpclTime[0]) && $entOpclTime[0] == '0' ?  $check :''; ?> value="0" checked="">
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[air_conditioning_time_used]" <?php echo isset($entOpclTime[0]) && $entOpclTime[0] ?  $check :''; ?> value="1">
														<?php echo Yii::app()->controller->__trans('No limited time to use（24hours）');?>
                                                    </label><br>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[air_conditioning_time_used]" <?php echo isset($entOpclTime[0]) && $entOpclTime[0] == '2' ?  $check :''; ?> value="2">
														<?php echo Yii::app()->controller->__trans('limited time to use');?>
                                                    </label>
													<?php echo Yii::app()->controller->__trans('weekday');?>：
                                                    <select id="f_air_usetime_detail_week_start" name="Floor[f_air_usetime_detail_week_start]" class="auto">
                                                    	<option value="">-</option>
														<?php
                                                        	$h = 0;
															$m = 0;
															while($h < 24){
																$selected ="";
																echo $h;
																if($h.':'.sprintf("%02d", $m) == $week_start){
																	$selected = 'selected';
																}
														?>
                                                        <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
														<?php
                                                        	$m += 5;
															if($m == 60){
																$m = 00;
																$h++;
															}
														}
														?>
                                                   	</select>-
                                                    <select id="f_air_usetime_detail_week_finish" name="Floor[f_air_usetime_detail_week_finish]" class="auto">
                                                    	<option value="">-</option>
														<?php
                                                        	$h = 0;
															$m = 0;
															while($h < 24){
																$selected ="";
																if($h.':'.sprintf("%02d", $m) == $week_finish){
																	$selected = 'selected';
																}
														?>
                                                        <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
														<?php
                                                        	$m += 5;
															if($m == 60){
																$m = 00;
																$h++;
															}
														}
														?>
                                                    </select>
													<?php echo Yii::app()->controller->__trans('Sat');?>：
                                                    <select id="f_air_usetime_detail_sat_start" name="Floor[f_air_usetime_detail_sat_start]" class="auto">
                                                    	<option value="">-</option>
														<?php
                                                        	$h = 0;
															$m = 0;
															while($h < 24){
																$selected ="";
																if($h.':'.sprintf("%02d", $m) == $sat_start){
																	$selected = 'selected';
																}
														?>
                                                        <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
														<?php
                                                        		$m += 5;
																if($m == 60){
																	$m = 00;
																	$h++;
																}
															}
														?>
                                                    </select>-
                                                    <select id="f_air_usetime_detail_sat_finish" name="Floor[f_air_usetime_detail_sat_finish]" class="auto">
                                                    	<option value="">-</option>
														<?php
                                                        	$h = 0;
															$m = 0;
															while($h < 24){
																$selected ="";
																if($h.':'.sprintf("%02d", $m) == $sat_finish){
																	$selected = 'selected';
																}
														?>
                                                        <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
														<?php
                                                        		$m += 5;
																if($m == 60){
																	$m = 00;
																	$h++;
																}
															}
														?>
                                                    </select>
													<?php echo Yii::app()->controller->__trans('Sun/Holiday');?>：
                                                    <select id="f_air_usetime_detail_sun_start" name="Floor[f_air_usetime_detail_sun_start]" class="auto">
                                                    	<option value="">-</option>
														<?php
                                                        	$h = 0;
															$m = 0;
															while($h < 24){
																$selected ="";
																if($h.':'.sprintf("%02d", $m) == $sun_start){
																	$selected = 'selected';
																}
														?>
                                                        <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
														<?php
                                                        		$m += 5;
																if($m == 60){
																	$m = 00;
																	$h++;
																}
															}
														?>
                                                    </select>-
                                                    <select id="f_air_usetime_detail_sun_finish" name="Floor[f_air_usetime_detail_sun_finish]" class="auto">
                                                    	<option value="">-</option>
														<?php
                                                        	$h = 0;
															$m = 0;
															while($h < 24){
																$selected ="";
																if($h.':'.sprintf("%02d", $m) == $sun_finish){
																	$selected = 'selected';
																}
														?>
                                                        <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
														<?php
                                                        		$m += 5;
																if($m == 60){
																	$m = 00;
																	$h++;
																}
															}
														?>
                                                   	</select>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[number_of_air_conditioning]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('number of air conditioning');?>
                                                </th>
                                                <td>
                                                	<input type="text" size="5" name="Floor[number_of_air_conditioning]" value="<?php echo isset($model->number_of_air_conditioning) && $model->number_of_air_conditioning != '' ?  $model->number_of_air_conditioning :''; ?>" class="ty8">
													<?php echo Yii::app()->controller->__trans('基');?>
                                                </td>
                                            </tr>
                                            <?php /*?><tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[optical_cable]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('optical cable');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[optical_cable]"  <?php echo isset($model->optical_cable) && $model->optical_cable == '0' ?  $check :''; ?> value="0" checked="">
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[optical_cable]"  <?php echo isset($model->optical_cable) && $model->optical_cable == '1' ?  $check :''; ?> value="1">
														<?php echo Yii::app()->controller->__trans('unsupported');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[optical_cable]"  <?php echo isset($model->optical_cable) && $model->optical_cable == '2' ?  $check :''; ?> value="2">
														<?php echo Yii::app()->controller->__trans('supported');?>
                                                    </label>
                                                </td>
                                            </tr><?php */?>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[oa_type]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('OA');?>
                                                </th>
                                                <td>
													<?php echo Yii::app()->controller->__trans('type');?>：
                                                    <select name="Floor[oa_type]" id="f_oa" data-role="none" class="auto">
                                                    	<option value="">-</option>
                                                        <option value="非対応" <?php echo isset($model->oa_type) && $model->oa_type == '非対応' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('非対応');?></option>
                                                        <option value="フリーアクセス" <?php echo isset($model->oa_type) && $model->oa_type == 'フリーアクセス' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('フリーアクセス');?></option>
                                                        <option value="1WAY" <?php echo isset($model->oa_type) && $model->oa_type == '1WAY' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('1WAY');?></option>
                                                        <option value="2WAY" <?php echo isset($model->oa_type) && $model->oa_type == '2WAY' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('2WAY');?></option>
                                                        <option value="3WAY" <?php echo isset($model->oa_type) && $model->oa_type == '3WAY' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('3WAY');?></option>
                                                        <option value="引き込み可" <?php echo isset($model->oa_type) && $model->oa_type == '引き込み可' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('引き込み可');?></option>
                                                   	</select>
													<?php echo Yii::app()->controller->__trans('フリアク高');?>：
                                                    <input type="text" name="Floor[oa_height]" value="<?php echo isset($model->oa_height   )&& $model->oa_height != ''? $model->oa_height :''; ?>"  class="ty1">
													<?php echo Yii::app()->controller->__trans('mm');?>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[floor_material]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('floor material');?>
                                                </th>
                                                <td>
                                                	<select name="Floor[floor_material]" id="f_floormate" data-role="none" class="auto">
                                                    	<option value="unknown" selected="" <?php echo isset($model->floor_material) && $model->floor_material == 'unknown' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                                        <option value="カーペット" <?php echo isset($model->floor_material) && $model->floor_material == 'カーペット' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('カーペット');?></option>
                                                        <option value="Pタイル" <?php echo isset($model->floor_material) && $model->floor_material == 'Pタイル' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('Pタイル');?></option>
                                                        <option value="フローリング" <?php echo isset($model->floor_material) && $model->floor_material == 'フローリング' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('フローリング');?></option>
                                                        <option value="コンクリート"  <?php echo isset($model->floor_material) && $model->floor_material == 'コンクリート' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('コンクリート');?></option>
                                                        <option value="たたみ" <?php echo isset($model->floor_material) && $model->floor_material == 'たたみ' ?  $select1 :''; ?>><?php echo Yii::app()->controller->__trans('たたみ');?></option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                            		<input type="checkbox" name="checked[ceiling_height]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('ceiling height');?>
                                                </th>
                                                <td>
                                                	<input type="text" size="5" name="Floor[ceiling_height]" value="<?php echo isset($model->ceiling_height) && $model->ceiling_height != '' ? $model->ceiling_height :'';?>" class="ty8">
													<?php echo Yii::app()->controller->__trans('mm');?>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[electric_capacity]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('electric capacity');?>
                                                </th>
                                                <td>
                                                	<input type="text" size="25" name="Floor[electric_capacity]" value="<?php echo isset($model->electric_capacity) && $model->electric_capacity != '' ? $model->electric_capacity :'';?>" class="ty3"> <?php echo Yii::app()->controller->__trans('VA/m&sup2;');?> 
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[separate_toilet_by_gender]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('separate toilet by gender');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[separate_toilet_by_gender]" <?php echo isset($model->separate_toilet_by_gender) && $model->separate_toilet_by_gender == '0' ? $check:'';?> value="0" checked="">
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[separate_toilet_by_gender]" <?php echo isset($model->separate_toilet_by_gender) && $model->separate_toilet_by_gender == '1' ? $check :'';?> value="1">
														<?php echo Yii::app()->controller->__trans('NO');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[separate_toilet_by_gender]" <?php echo isset($model->separate_toilet_by_gender) && $model->separate_toilet_by_gender == '2' ? $check :'';?> value="2">
														<?php echo Yii::app()->controller->__trans('YES');?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[toilet_location]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('toilet location');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[toilet_location]" value="1" <?php echo isset($model->toilet_location) && $model->toilet_location == '1' ? $check :'';?>>
														<?php echo Yii::app()->controller->__trans('inside of floor');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[toilet_location]" <?php echo isset($model->toilet_location) && $model->toilet_location == '2' ? $check :'';?> value="2">
														<?php echo Yii::app()->controller->__trans('outside of floor(common use)');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[toilet_location]" value="0"  <?php echo isset($model->toilet_location) && $model->toilet_location == '0' ? $check :'';?>>
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <?php /*?><tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[washlet]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('washlet');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[washlet]" value="1" <?php echo isset($model->washlet) && $model->washlet == '1' ? $check :'';?>>
														<?php echo Yii::app()->controller->__trans('none');?>
                                                 	</label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[washlet]" value="2" <?php echo isset($model->washlet) && $model->washlet == '2' ? $check :'';?>>
														<?php echo Yii::app()->controller->__trans('equipped');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[washlet]" value="0" <?php echo isset($model->washlet) && $model->washlet == '0' ? $check :'';?>>
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>&nbsp;<br>
                                                </td>
                                            </tr><?php */?>
                                            <?php /*?><tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[toilet_cleaning]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('toilet cleaning');?>
                                                </th>
                                                <td>
                                                	<label class="rd2">
                                                    	<input type="radio" name="Floor[toilet_cleaning]" value="1"<?php echo isset($model->toilet_cleaning) && $model->toilet_cleaning == '1' ? $check :'';?>>
														<?php echo Yii::app()->controller->__trans('ビル');?>
                                                    </label>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[toilet_cleaning]" value="2"<?php echo isset($model->toilet_cleaning) && $model->toilet_cleaning == '2' ? $check :'';?>>
														<?php echo Yii::app()->controller->__trans('テナント');?>
                                                    </label>
                                                    <label>
                                                    	<input type="radio" name="Floor[toilet_cleaning]" value="0" <?php echo isset($model->toilet_cleaning) && $model->toilet_cleaning == '0' ? $check :'';?>>
														<?php echo Yii::app()->controller->__trans('unknown');?>
                                                    </label>&nbsp;<br>
                                                </td>
                                            </tr><?php */?>
                                            <tr>
                                            	<th>
													<?php echo Yii::app()->controller->__trans('notes');?>
                                                </th>
                                                <td>
                                                	<textarea name="Floor[notes]" class="txta2" style="resize:none;"><?php echo isset($model->notes) && $model->notes != '0' ? $model->notes :'';?></textarea>
                                                </td>
                                            </tr>
                                       	</tbody>
                                    </table>
                                    <div class="dotted-border"></div>
                                    <table class="edit_input tb-floor one-col">
                                    	<tbody>
                                        	<tr>
                                            	<th>
                                                	<input type="checkbox" name="checked[floor_source_id]" value="1" style="margin-right:2px;">
													<?php echo Yii::app()->controller->__trans('Source from');?>
                                                </th>
                                                <td>
													<?php
                                                    if(isset($floorSourceDetails) && $floorSourceDetails !=''){
														$i = 0;
														foreach($floorSourceDetails as $sourceList){
															$checked = "";
															if(isset($model->floor_source_id) && $model->floor_source_id !=''){
																if($sourceList['floor_source_from_type_id'] == $model->floor_source_id){
																	$checked = "checked";
																}
															}else{
																if($i == 0){
																	$checked = "checked";
																}
															}
													?>
                                                    <label class="rd2">
                                                    	<input type="radio" name="Floor[floor_source_id]" value="<?php echo $sourceList['floor_source_from_type_id']; ?>" <?php echo $checked; ?> />
														<?php echo $sourceList['floor_source_from_type_name']; ?>
                                                    </label>
													<?php
                                                    	$i++;
														}
													}
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
													<?php echo Yii::app()->controller->__trans('Web非公開');?>
                                                </th>
                                                <td>
                                                    <label class="rd2" style="width:100%">
                                                    	<?php
														$isChecked = '';
														if(isset($model->web_publishing) && $model->web_publishing != 0){
															$isChecked = 'checked';
														}
														?>
                                                    	<input type="checkbox" name="Floor[web_publishing]" value="1" <?php echo $isChecked; ?> />
                                                        <input type="text" name="Floor[web_publishing_note]" value="<?php echo isset($model->web_publishing_note) && $model->web_publishing_note != "" ? $model->web_publishing_note : ''; ?>" style="width:97%;" />
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
													<?php echo Yii::app()->controller->__trans('update person in charge');?>
                                                </th>
                                                <td>
                                                	<select name="Floor[update_person_in_charge]" id="fh_update_rep" data-role="none" class="auto">
                                                    	<option value="">-</option>
														<?php
                                                        	if(isset($userList) && count($userList)){
																foreach($userList as $user){
																	$userFull = AdminDetails::model()->find('user_id = '.$user['user_id']);
																	$select_user = '';
																	if(isset($model->update_person_in_charge) && $model->update_person_in_charge != ""){
																		if($user['user_id'] == $model->update_person_in_charge){
																			$select_user = 'selected';
																		}
																	}else{
																		$loggecUser = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
																		$loguser_id = $loggecUser->user_id;
																		if($user['user_id'] == $loguser_id){
																			$select_user = 'selected';
																		}
																	}
														?>
                                                        <option value="<?php echo $user['user_id']; ?>"<?php echo $select_user; ?>><?php echo $userFull['full_name']; ?></option>
														<?php
                                                        		}
															}
														?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>
													<?php echo Yii::app()->controller->__trans('Property confirmation person in charge');?>
                                                </th>
                                                <td>
                                                	<select name="Floor[property_confirmation_person]" id="fh_source_rep" data-role="none" class="auto">
                                                    	<option value="">-</option>
														<?php
                                                        if(isset($userList) && count($userList)){
															foreach($userList as $user){
																$userFull = AdminDetails::model()->find('user_id = '.$user['user_id']);
																$select_user = '';
																if($user['user_id'] == $model->property_confirmation_person){
																	$select_user = 'selected';
																}
														?>
                                                        <option value="<?php echo $user['user_id']; ?>"<?php echo $select_user; ?>><?php echo $userFull['full_name']; ?></option>
														<?php
                                                        	}
														}
														?>
                                                  	</select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bt_input_box">
                            	<div class="bt_input">
                                	<input type="submit" onclick="submit_edit_building_info();" class="bt_entry" value="<?php echo Yii::app()->controller->__trans('フロア情報を更新');?>">
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                            <div class="txt_f">
                            	※<?php echo Yii::app()->controller->__trans('Copy above checked item to below checked floors.');?>
                            </div>
                            <div class="formbox f-full">
                            	<div class="table-inner">
                                    <?php
									$otherFloors = array();
									if(isset($buildingId)){
										//compart floor details
										$compartOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' and is_compart = 1');
										$cFloorIds = array();
										if(count($compartOwnerFloor) > 0){
											foreach($compartOwnerFloor as $cFloor){
												$cFloorIds[] = $cFloor['floor_id'];
											}
										}
										//shared floor details
										$sharedOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' and is_shared = 1');
										$sFloorIds = array();
										if(count($sharedOwnerFloor) > 0){
											foreach($sharedOwnerFloor as $sFloor){
												$sFloorIds[] = $sFloor['floor_id'];
											}
										}
										//all floor details
										$otherFloors = Floor::model()->findAll('building_id = '.$buildingId);
									?>
                                    	<table class="f_update floors_list">
                                            <thead>
                                                <tr class="none">
                                                	<th scope="col" class="bt"><input type="checkbox" class="check_all_floors" id="copy_all_floor"></th>
                                                    <th scope="col" class="code"><?php echo Yii::app()->controller->__trans('code'); ?></th>
                                                    <th scope="col" class="no"><?php echo Yii::app()->controller->__trans('number of stairs・room number'); ?></th>
                                                    <th scope="col" class="spot"><font><font><?php echo Yii::app()->controller->__trans('number of Tsubo'); ?></font></font></th>
                                                    <th scope="col" class="prm"><font><font><?php echo Yii::app()->controller->__trans('rent'); ?></font></font></th>
                                                    <th scope="col" class="csc"><font><font><?php echo Yii::app()->controller->__trans('condo fees'); ?></font></font></th>
                                                    <th scope="col" class="dps"><font><font><?php echo Yii::app()->controller->__trans('deposit'); ?></font></font></th>
                                                    <th scope="col" class="money"><font><font><?php echo Yii::app()->controller->__trans('key money'); ?></font></font></th>
                                                    <th scope="col" class="am"><font><font><?php echo Yii::app()->controller->__trans('repayment'); ?></font></font></th>
                                                    <th scope="col" class="period"><?php echo Yii::app()->controller->__trans('contract years'); ?></th>
                                                    <th scope="col" class="sc"><font><font><?php echo Yii::app()->controller->__trans('date move in'); ?></font></font></th>
                                                    <th scope="col" class="update"><?php echo Yii::app()->controller->__trans('last modified'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($otherFloors) && count($otherFloors) > 0){
                                                    foreach($otherFloors as $oFloor){
														if(in_array($oFloor['floor_id'],$cFloorIds)){
															continue;
														}
														if(in_array($oFloor['floor_id'],$sFloorIds)){
															continue;
														}
                                                ?>
                                                <tr class="">
                                                    <td class="bt">
                                                        <?php
                                                        if($oFloor['floor_id'] != $_GET['id']){
                                                        ?>
                                                            <input type="checkbox" class="copy_floor_target" data-floor="<?php echo $oFloor['floor_id']; ?>" name="clone[<?php echo $oFloor['floor_id']; ?>]" value="1">
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="ico">
                                                        <?php
                                                        if($oFloor['vacancy_info'] == 0){
                                                            $vac = 'full';
                                                            $lbl = '満';
                                                        }else{
                                                            $vac = 'empty';
                                                            $lbl = '空';
                                                        }
                                                        ?>
                                                        <span class="rm-status <?php echo $vac; ?>">
                                                            <?php echo $lbl; ?>
                                                        </span>
                                                        <?php echo $oFloor['floor_id']; ?>
                                                    </td>
                                                    <td class="fl_num">
                                                        <?php
															if(strpos($oFloor['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $oFloor['floor_down']);
															}else{
																$floorDown = $oFloor['floor_down'];
															}
															$stairs = $floorDown;
															$stairs .= '階'.$oFloor['floor_up'];
															echo $stairs.'  '.$oFloor['roomname'];
														?>
                                                    </td>
                                                    <td class="fl_area">
                                                        <?php
															if($oFloor['area_ping'] != ""){
																echo $oFloor['area_ping'].Yii::app()->controller->__trans('tsubo');
															}else{
																echo '-';
															}
														?>
                                                    </td>
                                                    <td class="prm">
														<?php
                                                            if(isset($oFloor['rent_unit_price']) && $oFloor['rent_unit_price'] != "" && $oFloor['rent_unit_price'] != 0){
                                                                echo ''.Yii::app()->controller->renderPrice($oFloor['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                            }else{
                                                                if($oFloor['rent_unit_price_opt'] != ''){
                                                                    if($oFloor['rent_unit_price_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('undecided');
                                                                    }else if($oFloor['rent_unit_price_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('ask');
                                                                    }
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="csc">
                                                        <?php
                                                            if(isset($oFloor['unit_condo_fee']) && $oFloor['unit_condo_fee'] != "" && $oFloor['unit_condo_fee'] != 0){
                                                                    echo ''.Yii::app()->controller->renderPrice($oFloor['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                }else{
                                                                if($oFloor['unit_condo_fee_opt'] != ''){
                                                                    if($oFloor['unit_condo_fee_opt'] == 0){
                                                                        echo Yii::app()->controller->__trans('none');
                                                                    }else if($oFloor['unit_condo_fee_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('undecided');
                                                                    }else if($oFloor['unit_condo_fee_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('ask');
                                                                    }else if($oFloor['unit_condo_fee_opt'] == -3){
                                                                        echo '賃料に込み';
                                                                    }
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="dps">
														<?php
                                                            /*if(isset($oFloor['total_deposit']) && $oFloor['total_deposit'] != "0" && $oFloor['total_deposit'] != ""){
                                                                echo Yii::app()->controller->renderPrice($oFloor['total_deposit']).' 円';
                                                            }
                                                            if($oFloor['deposit_opt'] != ''){
                                                                echo '<br/>';
                                                                if($oFloor['deposit_opt'] == -1){
                                                                    echo Yii::app()->controller->__trans('undecided');
                                                                }else if($oFloor['deposit_opt'] == -3){
                                                                    echo Yii::app()->controller->__trans('none');
                                                                }else if($oFloor['deposit_opt'] == -2){
                                                                    echo Yii::app()->controller->__trans('undecided･ask');
                                                                }
                                                            }*/
                                                            if(isset($oFloor['deposit_month']) &&  $oFloor['deposit_month'] != ''){
                                                                echo $oFloor['deposit_month'].' ヶ月';
                                                            }else{
                                                                echo '-';
                                                            }
                                                        ?><br>
                                                        <?php
                                                            /*if(isset($oFloor['deposit']) && $oFloor['deposit'] != ""){
                                                                echo '('.$oFloor['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                            }else{
                                                                echo '';
                                                            }*/
                                                        ?>
                                                    </td>
                                                    <td class="money">
                                                        <?php  
                                                            if(isset($oFloor['key_money_opt']) && $oFloor['key_money_opt'] != ""){
                                                                if($oFloor['key_money_opt'] == 2){
                                                                    echo Yii::app()->controller->__trans('None');
                                                                }elseif($oFloor['key_money_opt'] == -1){
                                                                    echo Yii::app()->controller->__trans('Unknown');
                                                                }elseif($oFloor['key_money_opt'] == -2){
                                                                    echo Yii::app()->controller->__trans('undecided･ask');
                                                                }else{
                                                                    echo '';
                                                                }
                                                            }else{
                                                                echo '';
                                                            }
                                                            
                                                            if(isset($oFloor['key_money_month']) && $oFloor['key_money_month'] != ""){
                                                                echo $oFloor['key_money_month'].Yii::app()->controller->__trans('month');
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="am">
														<?php
                                                            if(isset($oFloor['repayment_opt']) && $oFloor['repayment_opt'] != ""){
                                                                if($oFloor['repayment_opt'] == -3){
                                                                    echo Yii::app()->controller->__trans('None')."<br>"; 
                                                                }elseif($oFloor['repayment_opt'] == -4){
                                                                    echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                                }elseif($oFloor['repayment_opt'] == -1){
                                                                    echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                                }elseif($oFloor['repayment_opt'] == -2){
                                                                    echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                                }elseif($oFloor['repayment_opt'] == -5){
                                                                    echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                                }else{
                                                                    echo '';
                                                                }
                                                            }
                                                            
                                                            if(isset($oFloor['repayment_reason']) && $oFloor['repayment_reason'] != ""){
                                                                if($oFloor['repayment_reason'] == 1){
                                                                    echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                                }elseif($oFloor['repayment_reason'] == 2){
                                                                    echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                                }else{
                                                                    echo '';
                                                                }
                                                            }
                                                            
                                                            if(isset($oFloor['repayment_amt']) && $oFloor['repayment_amt'] != ""){
                                                                echo $oFloor['repayment_amt'];
                                                            }
                                                            
                                                            if(isset($oFloor['repayment_amt_opt']) && $oFloor['repayment_amt_opt'] != ""){
                                                                if($oFloor['repayment_amt_opt'] == 1){
                                                                    echo Yii::app()->controller->__trans('ヶ月'); 
                                                                }elseif($oFloor['repayment_amt_opt'] == 2){
                                                                    echo Yii::app()->controller->__trans('%')."<br>"; 
                                                                }else{
                                                                    echo '';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="period">
                                                        <?php
                                                        if(isset($oFloor['contract_period_duration']) && $oFloor['contract_period_duration'] != ""){
                                                            echo $oFloor['contract_period_duration'];
                                                            echo $oFloor['contract_period_duration'] > 1 && $oFloor['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
                                                        }else{
                                                            echo '-';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="sc">
                                                        <?php
                                                        if(isset($oFloor['move_in_date']) && $oFloor['move_in_date'] != "" && (string)$oFloor['move_in_date'] != "0"){
                                                            echo $oFloor['move_in_date'];
                                                        }else{
                                                            echo '-';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="update">
                                                        <?php
														if(isset($oFloor['modified_on']) && $oFloor['modified_on'] != ""){
															if($oFloor['modified_on'] != "0000-00-00 00:00:00"){
																echo date('Y.m.d',strtotime($oFloor['modified_on']));
															}else{
																echo date('Y.m.d',strtotime($oFloor['added_on']));
															}
														}else{
															echo '-';
														}
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                
                                                
												<?php
												$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingId.' AND `is_compart` = 1 GROUP BY ownership_type';
												$allCompartOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
												
												$cFloorIDs = array();
												$ownerNames = array();
												foreach($allCompartOwnerDetails as $aFloor){
													$cFloorIDs[] = $aFloor['floor_id'];
													$ownerNames[$aFloor['ownership_type']] = $aFloor['owner_company_name'];
												}
												
												$cFloorIDs = array_unique($cFloorIDs);
												if(count($cFloorIDs) > 0){
													foreach($cFloorIDs as $fId){
														$oDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' and floor_id ='.$fId.' AND is_compart = 1');
                                                ?>
                                                <tr>
                                                    <td colspan="12" style="text-align:left;">
                                                        <span class="labelCompartInSingle">区分所有フロア</span></br>
                                                        <?php foreach($ownerNames as $key=>$val){?>
                                                        <span class="vendor-label">
                                                            <?php
                                                            $managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
                                                            if(array_key_exists($key,$managementArray)){
                                                                echo $managementArray[$key];
                                                            }													
                                                            ?>
                                                        </span>
                                                        <?php echo $val;?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
														//foreach($oDetails as $compDetails){
															$floorDetails = Floor::model()->find('floor_id = '.$fId);
												?>
                                                		<tr class="">
                                                        	<td class="bt">
                                                            <?php
															if($floorDetails['floor_id'] != $_GET['id']){
															?>
                                                            	<input type="checkbox" class="copy_floor_target" data-floor="<?php echo $floorDetails['floor_id']; ?>" name="clone[<?php echo $floorDetails['floor_id']; ?>]" value="1">
                                                            <?php
                                                            }
                                                            ?>
                                                            </td>
                                                            <td class="ico">
                                                            <?php
															if($floorDetails['vacancy_info'] == 0){
																$vac = 'full';
																$lbl = '満';
															}else{
																$vac = 'empty';
																$lbl = '空';
															}
															?>
                                                            <span class="rm-status <?php echo $vac; ?>">
                                                            	<?php echo $lbl; ?>
                                                            </span>
                                                            <?php echo $floorDetails['floor_id']; ?>
                                                            </td>
                                                            <td class="fl_num">
                                                            	<?php
																	if(strpos($floorDetails['floor_down'], '-') !== false){
																		$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
																	}else{
																		$floorDown = $floorDetails['floor_down'];
																	}
																	$stairs = $floorDown;
																	$stairs .= '階'.$floorDetails['floor_up'];
																	echo $stairs.'  '.$floorDetails['roomname'];
																?>
                                                            </td>
                                                            <td class="fl_area">
                                                            	<?php
																	if($floorDetails['area_ping'] != ""){
																		echo $floorDetails['area_ping'].Yii::app()->controller->__trans('tsubo');
																	}else{
																		echo '-';
																	}
																?>
                                                            </td>
                                                            <td class="prm">
																<?php
                                                                    if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != "" && $floorDetails['rent_unit_price'] != 0){
                                                                        echo ''.Yii::app()->controller->renderPrice($floorDetails['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                    }else{
                                                                        if($floorDetails['rent_unit_price_opt'] != ''){
                                                                            if($floorDetails['rent_unit_price_opt'] == -1){
                                                                                echo Yii::app()->controller->__trans('undecided');
                                                                            }else if($floorDetails['rent_unit_price_opt'] == -2){
                                                                                echo Yii::app()->controller->__trans('ask');
                                                                            }
                                                                        }else{
                                                                            echo '-';
                                                                        }
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="csc">
                                                                <?php
                                                                    if(isset($floorDetails['unit_condo_fee']) && $floorDetails['unit_condo_fee'] != "" && $floorDetails['unit_condo_fee'] != 0){
                                                                            echo ''.Yii::app()->controller->renderPrice($floorDetails['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                        }else{
                                                                        if($floorDetails['unit_condo_fee_opt'] != ''){
                                                                            if($floorDetails['unit_condo_fee_opt'] == 0){
                                                                                echo Yii::app()->controller->__trans('none');
                                                                            }else if($floorDetails['unit_condo_fee_opt'] == -1){
                                                                                echo Yii::app()->controller->__trans('undecided');
                                                                            }else if($floorDetails['unit_condo_fee_opt'] == -2){
                                                                                echo Yii::app()->controller->__trans('ask');
                                                                            }else if($floorDetails['unit_condo_fee_opt'] == -3){
                                                                                echo '賃料に込み';
                                                                            }
                                                                        }else{
                                                                            echo '-';
                                                                        }
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="dps">
																<?php
                                                                    /*if(isset($floorDetails['total_deposit']) && $floorDetails['total_deposit'] != "0" && $floorDetails['total_deposit'] != ""){
                                                                        echo Yii::app()->controller->renderPrice($floorDetails['total_deposit']).' 円';
                                                                    }
                                                                    if($floorDetails['deposit_opt'] != ''){
                                                                        echo '<br/>';
                                                                        if($floorDetails['deposit_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');
                                                                        }else if($floorDetails['deposit_opt'] == -3){
                                                                            echo Yii::app()->controller->__trans('none');
                                                                        }else if($floorDetails['deposit_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('undecided･ask');
                                                                        }
                                                                    }*/
                                                                    if(isset($floorDetails['deposit_month']) &&  $floorDetails['deposit_month'] != ''){
                                                                        echo $floorDetails['deposit_month'].' ヶ月';
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                ?><br>
                                                                <?php
                                                                    /*if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != ""){
                                                                        echo '('.$floorDetails['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                                    }else{
                                                                        echo '';
                                                                    }*/
                                                                ?>
                                                            </td>
                                                            <td class="money">
                                                                <?php  
                                                                    if(isset($floorDetails['key_money_opt']) && $floorDetails['key_money_opt'] != ""){
                                                                        if($floorDetails['key_money_opt'] == 2){
                                                                            echo Yii::app()->controller->__trans('None');
                                                                        }elseif($floorDetails['key_money_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('Unknown');
                                                                        }elseif($floorDetails['key_money_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('undecided･ask');
                                                                        }else{
                                                                            echo '';
                                                                        }
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                    
                                                                    if(isset($floorDetails['key_money_month']) && $floorDetails['key_money_month'] != ""){
                                                                        echo $floorDetails['key_money_month'].Yii::app()->controller->__trans('month');
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="am">
																<?php
                                                                    if(isset($floorDetails['repayment_opt']) && $floorDetails['repayment_opt'] != ""){
                                                                        if($floorDetails['repayment_opt'] == -3){
                                                                            echo Yii::app()->controller->__trans('None')."<br>"; 
                                                                        }elseif($floorDetails['repayment_opt'] == -4){
                                                                            echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                                        }elseif($floorDetails['repayment_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                                        }elseif($floorDetails['repayment_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                                        }elseif($floorDetails['repayment_opt'] == -5){
                                                                            echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                                        }else{
                                                                            echo '';
                                                                        }
                                                                    }
                                                                    
                                                                    if(isset($floorDetails['repayment_reason']) && $floorDetails['repayment_reason'] != ""){
                                                                        if($floorDetails['repayment_reason'] == 1){
                                                                            echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                                        }elseif($floorDetails['repayment_reason'] == 2){
                                                                            echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                                        }else{
                                                                            echo '';
                                                                        }
                                                                    }
                                                                    
                                                                    if(isset($floorDetails['repayment_amt']) && $floorDetails['repayment_amt'] != ""){
                                                                        echo $floorDetails['repayment_amt'];
                                                                    }
                                                                    
                                                                    if(isset($floorDetails['repayment_amt_opt']) && $floorDetails['repayment_amt_opt'] != ""){
                                                                        if($floorDetails['repayment_amt_opt'] == 1){
                                                                            echo Yii::app()->controller->__trans('ヶ月'); 
                                                                        }elseif($floorDetails['repayment_amt_opt'] == 2){
                                                                            echo Yii::app()->controller->__trans('%')."<br>"; 
                                                                        }else{
                                                                            echo '';
                                                                        }
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="period">
                                                                <?php
                                                                if(isset($floorDetails['contract_period_duration']) && $floorDetails['contract_period_duration'] != ""){
                                                                    echo $floorDetails['contract_period_duration'];
                                                                    echo $floorDetails['contract_period_duration'] > 1 && $floorDetails['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="sc">
                                                                <?php
                                                                if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != "0"){
                                                                    echo $floorDetails['move_in_date'];
                                                                }else{
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="update">
                                                                <?php
																if(isset($floorDetails['modified_on']) && $floorDetails['modified_on'] != ""){
																	if($floorDetails['modified_on'] != "0000-00-00 00:00:00"){
																		echo date('Y.m.d',strtotime($floorDetails['modified_on']));
																	}else{
																		echo date('Y.m.d',strtotime($floorDetails['added_on']));
																	}
																}else{
																	echo '-';
																}
                                                                ?>
                                                            </td>
                                                        </tr>
												<?php
														//}
													}
												}
												?>
                                                <?php
												//$allSharedOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' AND is_shared = 1');
												$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingId.' AND `is_shared` = 1 GROUP BY ownership_type';
												$allSharedOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
												$sFloorIDs = array();
												$ownerNames = array();
												foreach($allSharedOwnerDetails as $aFloor){
													$sFloorIDs[] = $aFloor['floor_id'];
													$ownerNames[$aFloor['ownership_type']] = $aFloor['owner_company_name'];
												}
												$sFloorIDs = array_unique($sFloorIDs);
												if(count($sFloorIDs) > 0){
													foreach($sFloorIDs as $fId){
													$oDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' and floor_id ='.$fId.' AND is_shared = 1');
                                                ?>
                                                <tr>
                                                	<td colspan="12" style="text-align:left;">
                                                    	<span class="labelSharedInSingle">共用オーナーフロア</span></br>
                                                    	<?php foreach($ownerNames as $key=>$val){?>
                                                        <span class="vendor-label">
                                                            <?php
                                                            $managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
                                                            if(array_key_exists($key,$managementArray)){
                                                                echo $managementArray[$key];
                                                            }													
                                                            ?>
                                                        </span>
                                                        <?php echo $val;?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
														//foreach($oDetails as $sharedDetails){
															$floorDetails = Floor::model()->findByPk($fId);
												?>
                                                		<tr class="">
                                                        	<td class="bt">
                                                            <?php
															if($floorDetails['floor_id'] != $_GET['id']){
															?>
                                                            	<input type="checkbox" class="copy_floor_target" data-floor="<?php echo $floorDetails['floor_id']; ?>" name="clone[<?php echo $floorDetails['floor_id']; ?>]" value="1">
                                                            <?php
                                                            }
                                                            ?>
                                                            </td>
                                                            <td class="ico">
																<?php
                                                                if($floorDetails['vacancy_info'] == 0){
                                                                    $vac = 'full';
                                                                    $lbl = '満';
                                                                }else{
                                                                    $vac = 'empty';
                                                                    $lbl = '空';
                                                                }
                                                                ?>
                                                                <span class="rm-status <?php echo $vac; ?>">
                                                                    <?php echo $lbl; ?>
                                                                </span>
                                                                <?php echo $floorDetails['floor_id']; ?>
                                                            </td>
                                                            <td class="fl_num">
                                                            	<?php
																if(strpos($floorDetails['floor_down'], '-') !== false){
																	$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
																}else{
																	$floorDown = $floorDetails['floor_down'];
																}
																$stairs = $floorDown;
																$stairs .= '階'.$floorDetails['floor_up'];
																echo $stairs.'  '.$floorDetails['roomname'];
																?>
                                                            </td>
                                                            <td class="fl_area">
                                                            	<?php
																	if($floorDetails['area_ping'] != ""){
																		echo $floorDetails['area_ping'].Yii::app()->controller->__trans('tsubo');
																	}else{
																		echo '-';
																	}
																?>
                                                            </td>
                                                            <td class="prm">
																<?php
                                                                    if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != "" && $floorDetails['rent_unit_price'] != 0){
                                                                        echo ''.Yii::app()->controller->renderPrice($floorDetails['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                    }else{
                                                                        if($floorDetails['rent_unit_price_opt'] != ''){
                                                                            if($floorDetails['rent_unit_price_opt'] == -1){
                                                                                echo Yii::app()->controller->__trans('undecided');
                                                                            }else if($floorDetails['rent_unit_price_opt'] == -2){
                                                                                echo Yii::app()->controller->__trans('ask');
                                                                            }
                                                                        }else{
                                                                            echo '-';
                                                                        }
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="csc">
                                                                <?php
                                                                    if(isset($floorDetails['unit_condo_fee']) && $floorDetails['unit_condo_fee'] != "" && $floorDetails['unit_condo_fee'] != 0){
                                                                            echo ''.Yii::app()->controller->renderPrice($floorDetails['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                        }else{
                                                                        if($floorDetails['unit_condo_fee_opt'] != ''){
                                                                            if($floorDetails['unit_condo_fee_opt'] == 0){
                                                                                echo Yii::app()->controller->__trans('none');
                                                                            }else if($floorDetails['unit_condo_fee_opt'] == -1){
                                                                                echo Yii::app()->controller->__trans('undecided');
                                                                            }else if($floorDetails['unit_condo_fee_opt'] == -2){
                                                                                echo Yii::app()->controller->__trans('ask');
                                                                            }else if($floorDetails['unit_condo_fee_opt'] == -3){
                                                                                echo '賃料に込み';
                                                                            }
                                                                        }else{
                                                                            echo '-';
                                                                        }
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="dps">
																<?php
                                                                    /*if(isset($floorDetails['total_deposit']) && $floorDetails['total_deposit'] != "0" && $floorDetails['total_deposit'] != ""){
                                                                        echo Yii::app()->controller->renderPrice($floorDetails['total_deposit']).' 円';
                                                                    }
                                                                    if($floorDetails['deposit_opt'] != ''){
                                                                        echo '<br/>';
                                                                        if($floorDetails['deposit_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');
                                                                        }else if($floorDetails['deposit_opt'] == -3){
                                                                            echo Yii::app()->controller->__trans('none');
                                                                        }else if($floorDetails['deposit_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('undecided･ask');
                                                                        }
                                                                    }*/
                                                                    if(isset($floorDetails['deposit_month']) &&  $floorDetails['deposit_month'] != ''){
                                                                        echo $floorDetails['deposit_month'].' ヶ月';
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                ?><br>
                                                                <?php
                                                                    /*if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != ""){
                                                                        echo '('.$floorDetails['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                                    }else{
                                                                        echo '';
                                                                    }*/
                                                                ?>
                                                            </td>
                                                            <td class="money">
                                                                <?php  
                                                                    if(isset($floorDetails['key_money_opt']) && $floorDetails['key_money_opt'] != ""){
                                                                        if($floorDetails['key_money_opt'] == 2){
                                                                            echo Yii::app()->controller->__trans('None');
                                                                        }elseif($floorDetails['key_money_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('Unknown');
                                                                        }elseif($floorDetails['key_money_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('undecided･ask');
                                                                        }else{
                                                                            echo '';
                                                                        }
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                    
                                                                    if(isset($floorDetails['key_money_month']) && $floorDetails['key_money_month'] != ""){
                                                                        echo $floorDetails['key_money_month'].Yii::app()->controller->__trans('month');
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="am">
																<?php
                                                                    if(isset($floorDetails['repayment_opt']) && $floorDetails['repayment_opt'] != ""){
                                                                        if($floorDetails['repayment_opt'] == -3){
                                                                            echo Yii::app()->controller->__trans('None')."<br>"; 
                                                                        }elseif($floorDetails['repayment_opt'] == -4){
                                                                            echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                                        }elseif($floorDetails['repayment_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                                        }elseif($floorDetails['repayment_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                                        }elseif($floorDetails['repayment_opt'] == -5){
                                                                            echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                                        }else{
                                                                            echo '';
                                                                        }
                                                                    }
                                                                    
                                                                    if(isset($floorDetails['repayment_reason']) && $floorDetails['repayment_reason'] != ""){
                                                                        if($floorDetails['repayment_reason'] == 1){
                                                                            echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                                        }elseif($floorDetails['repayment_reason'] == 2){
                                                                            echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                                        }else{
                                                                            echo '';
                                                                        }
                                                                    }
                                                                    
                                                                    if(isset($floorDetails['repayment_amt']) && $floorDetails['repayment_amt'] != ""){
                                                                        echo $floorDetails['repayment_amt'];
                                                                    }
                                                                    
                                                                    if(isset($floorDetails['repayment_amt_opt']) && $floorDetails['repayment_amt_opt'] != ""){
                                                                        if($floorDetails['repayment_amt_opt'] == 1){
                                                                            echo Yii::app()->controller->__trans('ヶ月'); 
                                                                        }elseif($floorDetails['repayment_amt_opt'] == 2){
                                                                            echo Yii::app()->controller->__trans('%')."<br>"; 
                                                                        }else{
                                                                            echo '';
                                                                        }
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="period">
                                                                <?php
																	if(isset($floorDetails['contract_period_duration']) && $floorDetails['contract_period_duration'] != ""){
																		echo $floorDetails['contract_period_duration'];
																		echo $floorDetails['contract_period_duration'] > 1 && $floorDetails['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
																	}else{
																		echo '-';
																	}
                                                                ?>
                                                            </td>
                                                            <td class="sc">
                                                                <?php
																	if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != "0"){
																		echo $floorDetails['move_in_date'];
																	}else{
																		echo '-';
																	}
                                                                ?>
                                                            </td>
                                                            <td class="update">
                                                                <?php
																	if(isset($floorDetails['modified_on']) && $floorDetails['modified_on'] != ""){
																		if($floorDetails['modified_on'] != "0000-00-00 00:00:00"){
																			echo date('Y.m.d',strtotime($floorDetails['modified_on']));
																		}else{
																			echo date('Y.m.d',strtotime($floorDetails['added_on']));
																		}
																	}else{
																		echo '-';
																	}
                                                                ?>
                                                            </td>
                                                        </tr>
												<?php
														//}
													}
												}
												?>
                                                
                                            </tbody>
                                        </table>
                                  <?php
									}
									?>
                                </div>
                            </div>
                            <div class="bt_input_box">
                            	<div class="bt_input">
                                	<input type="button"  class="bt_entry clone-floor-settings" value="<?php echo Yii::app()->controller->__trans('フロア情報を更新');?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabs-item">
                    	<form name="frmAddManagementHistory" id="frmAddManagementHistory" class="frmAddManagementHistory" action="<?php echo Yii::app()->createUrl('floor/addNewManagementHistory'); ?>" method="post">
                        <input type="hidden" name="hdnBillId" id="hdnBillId" class="hdnBillId" value="<?php echo $buildingId; ?>" />
                        <input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo isset($model->floor_id) && $model->floor_id != '' ?  $model->floor_id:''; ?>" />
                        <input type="hidden" name="hdnOtherCFloorId" id="hdnOtherCFloorId" class="hdnOtherCFloorId" value="0" />
                        <input type="hidden" name="inUpdate" id="inUpdate" class="inUpdate" value="<?php echo isset($model->floor_id) && $model->floor_id != '' ? 1 : 0; ?>" />
                        
                        <div class="formbox f-full owner-info">
                        	<div class="table-inner">
                            	<?php
									if(isset($model->floor_id) && $model->floor_id != ""){
										$managementCompartDetails = OwnershipManagement::model()->findAll('building_id = '.$model->building_id.' AND floor_id = '.$model->floor_id.' and is_compart = 1');
									}else{
										$managementCompartDetails = array();
									}
									$isCompartOpt = '0';
									$trader = '';
									$ownerType = '';
									$managementType = '';
									$isWindow = '';
									if(count($managementCompartDetails) > 0){
										$isCompartOpt = $managementCompartDetails[0]->is_compart;
										$trader = $managementCompartDetails[0]->trader_id;
										$ownerType = $managementCompartDetails[0]->ownership_type;
										$managementType = $managementCompartDetails[0]->management_type;
										$isWindow = $managementCompartDetails[0]->is_current;
									}
								?>
                                <table class="edit_input f_info_b mline tb-floor one-col mix-col">
                                	<tbody>
                                    	<tr>
                                        	<th class="minsize">
												<?php echo Yii::app()->controller->__trans('this floor is condominium ownership');?>
                                            </th>
                                            <td>
                                            	<label class="rd2">
													<?php $owner_checked = 'checked';?>
                                                    <input type="radio" value="1" name="is_compart"<?php echo isset($isCompartOpt) && $isCompartOpt == '1' ? $owner_checked : '';?>>
													<?php echo Yii::app()->controller->__trans('YES');?>
                                                </label>
                                                <label class="rd2">
                                                	<input type="radio" value="0" name="is_compart" <?php echo isset($isCompartOpt) && $isCompartOpt == '0' ? $owner_checked : '';?>>
													<?php echo Yii::app()->controller->__trans('NO');?>
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="edit_input f_info mt tb-floor one-col mix-col">
                                	<tbody>
                                    	<tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('業者ID');?>
                                            </th>
                                            <?php /*?><td colspan="3">
                                            	<input type="text" name="searchTraderText" class="ty3 searchTraderText" id="searchTraderText" style="float:left;">
                                                <input type="button" name="btnSearchTrader" id="btnSearchTrader" class="btnSearchTrader bt_entry autoWidth" value="<?php echo Yii::app()->controller->__trans('Search Trader');?>"><br/>
                                                <div class="traderResp">
                                                	<span id="owner_id_select">
                                                		<select id="tradersList"  class="auto tradersList" name="Floor[trader_id]">
                                                            <option value="0"><?php echo Yii::app()->controller->__trans('saved traders');?>↓</option>
                                                            <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
                                                            <?php
                                                            if(isset($tradersDetails) && count($tradersDetails) > 0){
                                                                foreach($tradersDetails as $tradersList){
                                                            ?>
                                                            <option value="<?php echo $tradersList['trader_id']; ?>" ><?php echo $tradersList['trader_name']; ?></option>
                                                            <?php
                                                                }
                                                            }else{
                                                            ?>
                                                            <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                   	</span> &nbsp;
                                                </div>←
                                                <input type="text" name="newTrader" id="newTrader" class="ty1 newTrader">
                                                <input type="button" name="add-trader" id="btnAddTrader" class="btnAddTrader bt_entry autoWidth" value="<?php echo Yii::app()->controller->__trans('Add Traders');?>">
                                            </td><?php */?>
                                            <td colspan="3">
                                            	<div class="traderResp">
                                                	<span id="owner_id_select">
                                                    	<select id="tradersList"  class="auto tradersList" name="trader_id">
                                                        	<option value="0"><?php echo Yii::app()->controller->__trans('saved traders');?>↓</option>
                                                            <?php
															if($model->floor_id != "" && $model->floor_id != 0){
																//$tradersDetails = Traders::model()->findAll('is_active = 1 AND building_id = '.$buildingId.' AND floor_id = '.$model->floor_id);
																$tradersDetails = Traders::model()->findAll('is_active = 1 AND building_id = '.$buildingId);
															}else{
																$tradersDetails = Traders::model()->findAll('is_active = 1 AND building_id = '.$buildingId);
															}
                                                            if(isset($tradersDetails) && count($tradersDetails) > 0){
                                                                foreach($tradersDetails as $tradersList){
																	$selected = '';
																	if($trader == $tradersList['trader_id']){
																		$selected = 'selected';
																	}
                                                            ?>
                                                            <option value="<?php echo $tradersList['trader_id']; ?>"  <?php echo $selected; ?>><?php echo $tradersList['traderId'].' '.$tradersList['trader_name']; ?></option>
                                                            <?php
                                                                }
                                                            }else{
                                                            ?>
                                                            <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                   	</span> &nbsp;
                                                </div>
                                                <div class="loadTraders" style="display:none;">
                                                    <div class="spinner">
                                                        <div class="rect1"></div>
                                                        <div class="rect2"></div>
                                                        <div class="rect3"></div>
                                                        <div class="rect4"></div>
                                                        <div class="rect5"></div>
                                                    </div>
                                                </div>
                                                <!--←-->
                                                <?php /*?><input type="text" name="newTrader" id="newTrader" class="ty1 newTrader">
                                                <input type="button" name="add-trader" id="btnAddTrader" class="btnAddTrader bt_entry autoWidth" value="<?php echo Yii::app()->controller->__trans('Add Traders');?>"><?php */?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('ownership type');?>
                                            </th>
                                            <td>
                                            	<?php
												$oSelect0 = $oSelect2 = $oSelect3 = $oSelect4 = $oSelect5 = $oSelect6 = $oSelect7 = $oSelect8 = $oSelect9 = $oSelect10 = '';
												if($ownerType == "-1") {
													$oSelect0 = 'selected';
												}elseif($ownerType == "1"){
													$oSelect2 = 'selected';
												}elseif($ownerType == "6"){
													$oSelect3 = 'selected';
												}elseif($ownerType == "7"){
													$oSelect4 = 'selected';
												}elseif($ownerType == "8"){
													$oSelect5 = 'selected';
												}elseif($ownerType == "10"){
													$oSelect6 = 'selected';
												}elseif($ownerType == "4"){
													$oSelect7 = 'selected';
												}elseif($ownerType == "2"){
													$oSelect8 = 'selected';
												}elseif($ownerType == "9"){
													$oSelect9 = 'selected';
												}elseif($ownerType == "3"){
													$oSelect10 = 'selected';
												}
												?>
                                            	<select name="ownership_type" id="ownership_type" data-role="none" class="ownership_type">
                                                	<option value="">-</option>
                                                    <option value="1" <?php echo $oSelect2; ?>><?php echo Yii::app()->controller->__trans('owner');?></option>
                                                    <option value="6" <?php echo $oSelect3; ?>><?php echo Yii::app()->controller->__trans('サブリース');?></option>
                                                    <option value="7" <?php echo $oSelect4; ?>><?php echo Yii::app()->controller->__trans('貸主代理');?></option>
                                                    <option value="8" <?php echo $oSelect5; ?>><?php echo Yii::app()->controller->__trans('AM');?></option>
                                                    <option value="10" <?php echo $oSelect6; ?>><?php echo Yii::app()->controller->__trans('業者');?></option>
                                                    <option value="4" <?php echo $oSelect7; ?>><?php echo Yii::app()->controller->__trans('intermediary agent');?></option>
                                                    <option value="2" <?php echo $oSelect8; ?>><?php echo Yii::app()->controller->__trans('management company');?></option>
                                                    <option value="9" <?php echo $oSelect9; ?>><?php echo Yii::app()->controller->__trans('PM');?></option>
                                                    <option value="3" <?php echo $oSelect10; ?>><?php echo Yii::app()->controller->__trans('general contractor');?></option>
                                                    <option value="-1" <?php echo $oSelect0; ?>><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                                </select>
                                            </td>
                                            <th>
												<?php echo Yii::app()->controller->__trans('management type');?>
                                            </th>
                                            <td>
                                            	<?php
												$mSelect1 = $mSelect2 = $mSelect3 = $mSelect4 = $mSelect5 = '';
												switch ($managementType) {
													case "-1":
														$mSelect1 = 'selected';
														break;
													case "1":
														$mSelect2 = 'selected';
														break;
													case "2":
														$mSelect3 = 'selected';
														break;
													case "3":
														$mSelect4 = 'selected';
														break;
													case "4":
														$mSelect5 = 'selected';
														break;
												}
												?>
                                            	<select name="management_type" id="management_type" data-role="none" class="management_type">
                                                    <option value="">-</option>
                                                    <option value="-1" <?php echo $mSelect1; ?>><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                                    <option value="1" <?php echo $mSelect2; ?>><?php echo Yii::app()->controller->__trans('専任媒介');?></option>
                                                    <option value="2" <?php echo $mSelect3; ?>><?php echo Yii::app()->controller->__trans('一般媒介');?></option>
                                                    <option value="3" <?php echo $mSelect4; ?>><?php echo Yii::app()->controller->__trans('代理');?></option>
                                                    <option value="4" <?php echo $mSelect5; ?>><?php echo Yii::app()->controller->__trans('貸主');?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('Window');?>
                                            </th>
                                            <td colspan="3">
                                            	<label for="is_current">
                                                	<input type="checkbox" name="is_current" id="is_current" class="is_current" value="1" <?php echo ($isWindow != 0 ? 'checked' : ""); ?>/> <?php echo Yii::app()->controller->__trans('Setting this trader owner properties window');?>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('company name');?>
                                            </th>
                                            <td colspan="3">
                                            	<input type="text" name="owner_company_name" id="bo_name" value="<?php echo (isset($managementCompartDetails[0]->owner_company_name) && $managementCompartDetails[0]->owner_company_name != "" ? $managementCompartDetails[0]->owner_company_name : ""); ?>" class="ty6 owner_company_name">
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('place to contact');?>
                                            </th>
                                            <td colspan="3">
                                            	<input type="text" name="company_tel" id="bo_tel1" value="<?php echo (isset($managementCompartDetails[0]->company_tel) && $managementCompartDetails[0]->company_tel != "" ? $managementCompartDetails[0]->company_tel : ""); ?>" class="ty6 company_tel">
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('person in charge1');?>
                                            </th>
                                            <td>
                                            	<input type="text" name="person_in_charge1" id="bo_rep1" value="<?php echo (isset($managementCompartDetails[0]->person_in_charge1) && $managementCompartDetails[0]->person_in_charge1 != "" ? $managementCompartDetails[0]->person_in_charge1 : ""); ?>" class="ty3 person_in_charge1">
                                            </td>
                                            <th>
												<?php echo Yii::app()->controller->__trans('person in charge2');?>
                                            </th>
                                            <td>
                                            	<input type="text" name="person_in_charge2" id="bo_rep2" value="<?php echo (isset($managementCompartDetails[0]->person_in_charge2) && $managementCompartDetails[0]->person_in_charge2 != "" ? $managementCompartDetails[0]->person_in_charge2 : ""); ?>" class="ty3 person_in_charge2">
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('commission fee');?>
                                            </th>
                                            <td colspan="3">
                                            	<?php
												$cValue = isset($managementCompartDetails[0]->charge) && $managementCompartDetails[0]->charge != "" ? $managementCompartDetails[0]->charge : "";
												$cCheck1 = $cCheck2 = $cCheck3 = $cCheck4 = $cText = '';
												switch ($cValue) {
													case '"'.Yii::app()->controller->__trans('unknown').'"':
														$cCheck1 = 'checked';
														break;
													case '"'.Yii::app()->controller->__trans('ask').'"':
														$cCheck2 = 'checked';
														break;
													case '"'.Yii::app()->controller->__trans('undecided').'"':
														$cCheck3 = 'checked';
														break;
													case '"'.Yii::app()->controller->__trans('none').'"':
														$cCheck4 = 'checked';
														break;
													default:
														$cText = $cValue;
														break;
												}
												?>
                                                <label class="rd2">
                                                    <input type="radio" name="charge" value="<?php echo Yii::app()->controller->__trans('unknown');?>" <?php echo $cCheck1; ?>>
                                                    <?php echo Yii::app()->controller->__trans('unknown');?>
                                                </label>
                                                <label class="rd2">
                                                	<input type="radio" name="charge" value="<?php echo Yii::app()->controller->__trans('ask');?>" <?php echo $cCheck2; ?>>
													<?php echo Yii::app()->controller->__trans('ask');?>
                                                </label>
                                                <label class="rd2">
                                                	<input type="radio" name="charge" value="<?php echo Yii::app()->controller->__trans('undecided');?>" <?php echo $cCheck3; ?>>
													<?php echo Yii::app()->controller->__trans('undecided');?>
                                                </label>
                                                <label class="rd2">
                                                	<input type="radio" name="charge" value="<?php echo Yii::app()->controller->__trans('none');?>" <?php echo $cCheck4; ?>>
													<?php echo Yii::app()->controller->__trans('none');?>
                                                </label>|
                                                <input type="text" name="change_txt" id="bo_fee" size="5" value="<?php echo $cText; ?>" class="ty8 change_txt">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </form>
                        <div class="bt_input_box">
                        	<div class="bt_input">
                            	<button type="button" name="btnAddManagementDetails" id="btnAddManagementDetails" class="btnAddManagementDetails"><?php echo Yii::app()->controller->__trans('Update Management Information'); ?></button>
                             </div>
                        </div>
                        
                        <div class="formbox f-full">
                            <div class="table-inner">
                                <?php
                                $otherFloors = array();
                                if(isset($buildingId)){
                                    //compart floor details
                                    $compartOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' and is_compart = 1');
                                    $cFloorIds = array();
                                    if(count($compartOwnerFloor) > 0){
                                        foreach($compartOwnerFloor as $cFloor){
                                            $cFloorIds[] = $cFloor['floor_id'];
                                        }
                                    }
                                    //shared floor details
                                    $sharedOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' and is_shared = 1');
                                    $sFloorIds = array();
                                    if(count($sharedOwnerFloor) > 0){
                                        foreach($sharedOwnerFloor as $sFloor){
                                            $sFloorIds[] = $sFloor['floor_id'];
                                        }
                                    }
                                    //all floor details
                                    $otherFloors = Floor::model()->findAll('building_id = '.$buildingId);
                                ?>
                                    <table class="f_update floors_list tblComp">
                                        <thead>
                                            <tr class="none">
                                                <th scope="col" class="bt">
                                                	<input type="checkbox" class="checkAllComp" id="checkAllComp">
                                                </th>
                                                <th scope="col" class="code"><?php echo Yii::app()->controller->__trans('code'); ?></th>
                                                <th scope="col" class="no"><?php echo Yii::app()->controller->__trans('number of stairs・room number'); ?></th>
                                                <th scope="col" class="spot"><font><font><?php echo Yii::app()->controller->__trans('number of Tsubo'); ?></font></font></th>
                                                <th scope="col" class="prm"><font><font><?php echo Yii::app()->controller->__trans('rent'); ?></font></font></th>
                                                <th scope="col" class="csc"><font><font><?php echo Yii::app()->controller->__trans('condo fees'); ?></font></font></th>
                                                <th scope="col" class="dps"><font><font><?php echo Yii::app()->controller->__trans('deposit'); ?></font></font></th>
                                                <th scope="col" class="money"><font><font><?php echo Yii::app()->controller->__trans('key money'); ?></font></font></th>
                                                <th scope="col" class="am"><font><font><?php echo Yii::app()->controller->__trans('repayment'); ?></font></font></th>
                                                <th scope="col" class="period"><?php echo Yii::app()->controller->__trans('contract years'); ?></th>
                                                <th scope="col" class="sc"><font><font><?php echo Yii::app()->controller->__trans('date move in'); ?></font></font></th>
                                                <th scope="col" class="update"><?php echo Yii::app()->controller->__trans('last modified'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($otherFloors) && count($otherFloors) > 0){
                                                foreach($otherFloors as $oFloor){
                                                    if(in_array($oFloor['floor_id'],$cFloorIds)){
                                                        continue;
                                                    }
                                                    if(in_array($oFloor['floor_id'],$sFloorIds)){
                                                        continue;
                                                    }
                                            ?>
                                            <tr class="">
                                                <td class="bt">
                                                    <?php
                                                    if($oFloor['floor_id'] != $_GET['id']){
                                                    ?>
                                                        <input type="checkbox" class="compFloor" data-floor="<?php echo $oFloor['floor_id']; ?>" name="compFloor" value="<?php echo $oFloor['floor_id']; ?>">
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="ico">
                                                    <?php
                                                    if($oFloor['vacancy_info'] == 0){
                                                        $vac = 'full';
                                                        $lbl = '満';
                                                    }else{
                                                        $vac = 'empty';
                                                        $lbl = '空';
                                                    }
                                                    ?>
                                                    <span class="rm-status <?php echo $vac; ?>">
                                                        <?php echo $lbl; ?>
                                                    </span>
                                                    <?php echo $oFloor['floor_id']; ?>
                                                </td>
                                                <td class="fl_num">
                                                    <?php
                                                        if(strpos($oFloor['floor_down'], '-') !== false){
                                                            $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $oFloor['floor_down']);
                                                        }else{
                                                            $floorDown = $oFloor['floor_down'];
                                                        }
                                                        $stairs = $floorDown;
                                                        $stairs .= '階'.$oFloor['floor_up'];
                                                        echo $stairs.'  '.$oFloor['roomname'];
                                                    ?>
                                                </td>
                                                <td class="fl_area">
                                                    <?php
                                                        if($oFloor['area_ping'] != ""){
                                                            echo $oFloor['area_ping'].Yii::app()->controller->__trans('tsubo');
                                                        }else{
                                                            echo '-';
                                                        }
                                                    ?>
                                                </td>
                                                <td class="prm">
                                                    <?php
                                                        if(isset($oFloor['rent_unit_price']) && $oFloor['rent_unit_price'] != "" && $oFloor['rent_unit_price'] != 0){
                                                            echo ''.Yii::app()->controller->renderPrice($oFloor['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                        }else{
                                                            if($oFloor['rent_unit_price_opt'] != ''){
                                                                if($oFloor['rent_unit_price_opt'] == -1){
                                                                    echo Yii::app()->controller->__trans('undecided');
                                                                }else if($oFloor['rent_unit_price_opt'] == -2){
                                                                    echo Yii::app()->controller->__trans('ask');
                                                                }
                                                            }else{
                                                                echo '-';
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td class="csc">
                                                    <?php
                                                        if(isset($oFloor['unit_condo_fee']) && $oFloor['unit_condo_fee'] != "" && $oFloor['unit_condo_fee'] != 0){
                                                                echo ''.Yii::app()->controller->renderPrice($oFloor['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                            }else{
                                                            if($oFloor['unit_condo_fee_opt'] != ''){
                                                                if($oFloor['unit_condo_fee_opt'] == 0){
                                                                    echo Yii::app()->controller->__trans('none');
                                                                }else if($oFloor['unit_condo_fee_opt'] == -1){
                                                                    echo Yii::app()->controller->__trans('undecided');
                                                                }else if($oFloor['unit_condo_fee_opt'] == -2){
                                                                    echo Yii::app()->controller->__trans('ask');
                                                                }else if($oFloor['unit_condo_fee_opt'] == -3){
                                                                    echo '賃料に込み';
                                                                }
                                                            }else{
                                                                echo '-';
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td class="dps">
                                                    <?php
                                                        /*if(isset($oFloor['total_deposit']) && $oFloor['total_deposit'] != "0" && $oFloor['total_deposit'] != ""){
                                                            echo Yii::app()->controller->renderPrice($oFloor['total_deposit']).' 円';
                                                        }
                                                        if($oFloor['deposit_opt'] != ''){
                                                            echo '<br/>';
                                                            if($oFloor['deposit_opt'] == -1){
                                                                echo Yii::app()->controller->__trans('undecided');
                                                            }else if($oFloor['deposit_opt'] == -3){
                                                                echo Yii::app()->controller->__trans('none');
                                                            }else if($oFloor['deposit_opt'] == -2){
                                                                echo Yii::app()->controller->__trans('undecided･ask');
                                                            }
                                                        }*/
                                                        if(isset($oFloor['deposit_month']) &&  $oFloor['deposit_month'] != ''){
                                                            echo $oFloor['deposit_month'].' ヶ月';
                                                        }else{
                                                            echo '-';
                                                        }
                                                    ?><br>
                                                    <?php
                                                        /*if(isset($oFloor['deposit']) && $oFloor['deposit'] != ""){
                                                            echo '('.$oFloor['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                        }else{
                                                            echo '';
                                                        }*/
                                                    ?>
                                                </td>
                                                <td class="money">
                                                    <?php  
                                                        if(isset($oFloor['key_money_opt']) && $oFloor['key_money_opt'] != ""){
                                                            if($oFloor['key_money_opt'] == 2){
                                                                echo Yii::app()->controller->__trans('None');
                                                            }elseif($oFloor['key_money_opt'] == -1){
                                                                echo Yii::app()->controller->__trans('Unknown');
                                                            }elseif($oFloor['key_money_opt'] == -2){
                                                                echo Yii::app()->controller->__trans('undecided･ask');
                                                            }else{
                                                                echo '';
                                                            }
                                                        }else{
                                                            echo '';
                                                        }
                                                        
                                                        if(isset($oFloor['key_money_month']) && $oFloor['key_money_month'] != ""){
                                                            echo $oFloor['key_money_month'].Yii::app()->controller->__trans('month');
                                                        }
                                                    ?>
                                                </td>
                                                <td class="am">
                                                    <?php
                                                        if(isset($oFloor['repayment_opt']) && $oFloor['repayment_opt'] != ""){
                                                            if($oFloor['repayment_opt'] == -3){
                                                                echo Yii::app()->controller->__trans('None')."<br>"; 
                                                            }elseif($oFloor['repayment_opt'] == -4){
                                                                echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                            }elseif($oFloor['repayment_opt'] == -1){
                                                                echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                            }elseif($oFloor['repayment_opt'] == -2){
                                                                echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                            }elseif($oFloor['repayment_opt'] == -5){
                                                                echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                            }else{
                                                                echo '';
                                                            }
                                                        }
                                                        
                                                        if(isset($oFloor['repayment_reason']) && $oFloor['repayment_reason'] != ""){
                                                            if($oFloor['repayment_reason'] == 1){
                                                                echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                            }elseif($oFloor['repayment_reason'] == 2){
                                                                echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                            }else{
                                                                echo '';
                                                            }
                                                        }
                                                        
                                                        if(isset($oFloor['repayment_amt']) && $oFloor['repayment_amt'] != ""){
                                                            echo $oFloor['repayment_amt'];
                                                        }
                                                        
                                                        if(isset($oFloor['repayment_amt_opt']) && $oFloor['repayment_amt_opt'] != ""){
                                                            if($oFloor['repayment_amt_opt'] == 1){
                                                                echo Yii::app()->controller->__trans('ヶ月'); 
                                                            }elseif($oFloor['repayment_amt_opt'] == 2){
                                                                echo Yii::app()->controller->__trans('%')."<br>"; 
                                                            }else{
                                                                echo '';
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td class="period">
                                                    <?php
                                                    if(isset($oFloor['contract_period_duration']) && $oFloor['contract_period_duration'] != ""){
                                                        echo $oFloor['contract_period_duration'];
                                                        echo $oFloor['contract_period_duration'] > 1 && $oFloor['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
                                                    }else{
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="sc">
                                                    <?php
                                                    if(isset($oFloor['move_in_date']) && $oFloor['move_in_date'] != "" && (string)$oFloor['move_in_date'] != "0"){
                                                        echo $oFloor['move_in_date'];
                                                    }else{
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="update">
                                                    <?php
                                                    if(isset($oFloor['modified_on']) && $oFloor['modified_on'] != ""){
                                                        if($oFloor['modified_on'] != "0000-00-00 00:00:00"){
                                                            echo date('Y.m.d',strtotime($oFloor['modified_on']));
                                                        }else{
                                                            echo date('Y.m.d',strtotime($oFloor['added_on']));
                                                        }
                                                    }else{
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            
                                            <?php
                                            $query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingId.' AND `is_compart` = 1 GROUP BY ownership_type';
                                            $allCompartOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
                                            
                                            $cFloorIDs = array();
                                            $ownerNames = array();
                                            foreach($allCompartOwnerDetails as $aFloor){
                                                $cFloorIDs[] = $aFloor['floor_id'];
                                                $ownerNames[$aFloor['ownership_type']] = $aFloor['owner_company_name'];
                                            }
                                            
                                            $cFloorIDs = array_unique($cFloorIDs);
                                            if(count($cFloorIDs) > 0){
                                                foreach($cFloorIDs as $fId){
                                                    $oDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' and floor_id ='.$fId.' AND is_compart = 1');
                                            ?>
                                            <tr>
                                                <td colspan="12" style="text-align:left;">
                                                    <span class="labelCompartInSingle">区分所有フロア</span></br>
                                                    <?php foreach($ownerNames as $key=>$val){?>
                                                    <span class="vendor-label">
                                                        <?php
                                                        $managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
                                                        if(array_key_exists($key,$managementArray)){
                                                            echo $managementArray[$key];
                                                        }													
                                                        ?>
                                                    </span>
                                                    <?php echo $val;?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                                    //foreach($oDetails as $compDetails){
                                                        $floorDetails = Floor::model()->find('floor_id = '.$fId);
                                            ?>
                                                    <tr class="">
                                                        <td class="bt">
                                                        <?php
                                                        if($floorDetails['floor_id'] != $_GET['id']){
                                                        ?>
                                                            <input type="checkbox" class="compFloor" data-floor="<?php echo $floorDetails['floor_id']; ?>" name="compFloor" value="<?php echo $floorDetails['floor_id']; ?>">
                                                        <?php
                                                        }
                                                        ?>
                                                        </td>
                                                        <td class="ico">
                                                        <?php
                                                        if($floorDetails['vacancy_info'] == 0){
                                                            $vac = 'full';
                                                            $lbl = '満';
                                                        }else{
                                                            $vac = 'empty';
                                                            $lbl = '空';
                                                        }
                                                        ?>
                                                        <span class="rm-status <?php echo $vac; ?>">
                                                            <?php echo $lbl; ?>
                                                        </span>
                                                        <?php echo $floorDetails['floor_id']; ?>
                                                        </td>
                                                        <td class="fl_num">
                                                            <?php
                                                                if(strpos($floorDetails['floor_down'], '-') !== false){
                                                                    $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
                                                                }else{
                                                                    $floorDown = $floorDetails['floor_down'];
                                                                }
                                                                $stairs = $floorDown;
                                                                $stairs .= '階'.$floorDetails['floor_up'];
                                                                echo $stairs.'  '.$floorDetails['roomname'];
                                                            ?>
                                                        </td>
                                                        <td class="fl_area">
                                                            <?php
                                                                if($floorDetails['area_ping'] != ""){
                                                                    echo $floorDetails['area_ping'].Yii::app()->controller->__trans('tsubo');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="prm">
                                                            <?php
                                                                if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != "" && $floorDetails['rent_unit_price'] != 0){
                                                                    echo ''.Yii::app()->controller->renderPrice($floorDetails['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                }else{
                                                                    if($floorDetails['rent_unit_price_opt'] != ''){
                                                                        if($floorDetails['rent_unit_price_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');
                                                                        }else if($floorDetails['rent_unit_price_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('ask');
                                                                        }
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="csc">
                                                            <?php
                                                                if(isset($floorDetails['unit_condo_fee']) && $floorDetails['unit_condo_fee'] != "" && $floorDetails['unit_condo_fee'] != 0){
                                                                        echo ''.Yii::app()->controller->renderPrice($floorDetails['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                    }else{
                                                                    if($floorDetails['unit_condo_fee_opt'] != ''){
                                                                        if($floorDetails['unit_condo_fee_opt'] == 0){
                                                                            echo Yii::app()->controller->__trans('none');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('ask');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -3){
                                                                            echo '賃料に込み';
                                                                        }
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="dps">
                                                            <?php
                                                                /*if(isset($floorDetails['total_deposit']) && $floorDetails['total_deposit'] != "0" && $floorDetails['total_deposit'] != ""){
                                                                    echo Yii::app()->controller->renderPrice($floorDetails['total_deposit']).' 円';
                                                                }
                                                                if($floorDetails['deposit_opt'] != ''){
                                                                    echo '<br/>';
                                                                    if($floorDetails['deposit_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('undecided');
                                                                    }else if($floorDetails['deposit_opt'] == -3){
                                                                        echo Yii::app()->controller->__trans('none');
                                                                    }else if($floorDetails['deposit_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                                    }
                                                                }*/
                                                                if(isset($floorDetails['deposit_month']) &&  $floorDetails['deposit_month'] != ''){
                                                                    echo $floorDetails['deposit_month'].' ヶ月';
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?><br>
                                                            <?php
                                                                /*if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != ""){
                                                                    echo '('.$floorDetails['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                                }else{
                                                                    echo '';
                                                                }*/
                                                            ?>
                                                        </td>
                                                        <td class="money">
                                                            <?php  
                                                                if(isset($floorDetails['key_money_opt']) && $floorDetails['key_money_opt'] != ""){
                                                                    if($floorDetails['key_money_opt'] == 2){
                                                                        echo Yii::app()->controller->__trans('None');
                                                                    }elseif($floorDetails['key_money_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('Unknown');
                                                                    }elseif($floorDetails['key_money_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }else{
                                                                    echo '';
                                                                }
                                                                
                                                                if(isset($floorDetails['key_money_month']) && $floorDetails['key_money_month'] != ""){
                                                                    echo $floorDetails['key_money_month'].Yii::app()->controller->__trans('month');
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="am">
                                                            <?php
                                                                if(isset($floorDetails['repayment_opt']) && $floorDetails['repayment_opt'] != ""){
                                                                    if($floorDetails['repayment_opt'] == -3){
                                                                        echo Yii::app()->controller->__trans('None')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -4){
                                                                        echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -5){
                                                                        echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_reason']) && $floorDetails['repayment_reason'] != ""){
                                                                    if($floorDetails['repayment_reason'] == 1){
                                                                        echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                                    }elseif($floorDetails['repayment_reason'] == 2){
                                                                        echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_amt']) && $floorDetails['repayment_amt'] != ""){
                                                                    echo $floorDetails['repayment_amt'];
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_amt_opt']) && $floorDetails['repayment_amt_opt'] != ""){
                                                                    if($floorDetails['repayment_amt_opt'] == 1){
                                                                        echo Yii::app()->controller->__trans('ヶ月'); 
                                                                    }elseif($floorDetails['repayment_amt_opt'] == 2){
                                                                        echo Yii::app()->controller->__trans('%')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="period">
                                                            <?php
                                                            if(isset($floorDetails['contract_period_duration']) && $floorDetails['contract_period_duration'] != ""){
                                                                echo $floorDetails['contract_period_duration'];
                                                                echo $floorDetails['contract_period_duration'] > 1 && $floorDetails['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
                                                            }else{
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="sc">
                                                            <?php
                                                            if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != "0"){
                                                                echo $floorDetails['move_in_date'];
                                                            }else{
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="update">
                                                            <?php
                                                            if(isset($floorDetails['modified_on']) && $floorDetails['modified_on'] != ""){
                                                                if($floorDetails['modified_on'] != "0000-00-00 00:00:00"){
                                                                    echo date('Y.m.d',strtotime($floorDetails['modified_on']));
                                                                }else{
                                                                    echo date('Y.m.d',strtotime($floorDetails['added_on']));
                                                                }
                                                            }else{
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    //}
                                                }
                                            }
                                            ?>
                                            <?php
                                            //$allSharedOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' AND is_shared = 1');
                                            $query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingId.' AND `is_shared` = 1 GROUP BY ownership_type';
                                            $allSharedOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
                                            $sFloorIDs = array();
                                            $ownerNames = array();
                                            foreach($allSharedOwnerDetails as $aFloor){
                                                $sFloorIDs[] = $aFloor['floor_id'];
                                                $ownerNames[$aFloor['ownership_type']] = $aFloor['owner_company_name'];
                                            }
                                            $sFloorIDs = array_unique($sFloorIDs);
                                            if(count($sFloorIDs) > 0){
                                                foreach($sFloorIDs as $fId){
                                                $oDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' and floor_id ='.$fId.' AND is_shared = 1');
                                            ?>
                                            <tr>
                                                <td colspan="12" style="text-align:left;">
                                                    <span class="labelSharedInSingle">共用オーナーフロア</span></br>
                                                    <?php foreach($ownerNames as $key=>$val){?>
                                                    <span class="vendor-label">
                                                        <?php
                                                        $managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
                                                        if(array_key_exists($key,$managementArray)){
                                                            echo $managementArray[$key];
                                                        }													
                                                        ?>
                                                    </span>
                                                    <?php echo $val;?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                                    //foreach($oDetails as $sharedDetails){
                                                        $floorDetails = Floor::model()->findByPk($fId);
                                            ?>
                                                    <tr class="">
                                                        <td class="bt">
                                                        <?php
                                                        if($floorDetails['floor_id'] != $_GET['id']){
                                                        ?>
                                                            <input type="checkbox" class="compFloor" data-floor="<?php echo $floorDetails['floor_id']; ?>" name="compFloor" value="<?php echo $floorDetails['floor_id']; ?>">
                                                        <?php
                                                        }
                                                        ?>
                                                        </td>
                                                        <td class="ico">
                                                            <?php
                                                            if($floorDetails['vacancy_info'] == 0){
                                                                $vac = 'full';
                                                                $lbl = '満';
                                                            }else{
                                                                $vac = 'empty';
                                                                $lbl = '空';
                                                            }
                                                            ?>
                                                            <span class="rm-status <?php echo $vac; ?>">
                                                                <?php echo $lbl; ?>
                                                            </span>
                                                            <?php echo $floorDetails['floor_id']; ?>
                                                        </td>
                                                        <td class="fl_num">
                                                            <?php
                                                            if(strpos($floorDetails['floor_down'], '-') !== false){
                                                                $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
                                                            }else{
                                                                $floorDown = $floorDetails['floor_down'];
                                                            }
                                                            $stairs = $floorDown;
                                                            $stairs .= '階'.$floorDetails['floor_up'];
                                                            echo $stairs.'  '.$floorDetails['roomname'];
                                                            ?>
                                                        </td>
                                                        <td class="fl_area">
                                                            <?php
                                                                if($floorDetails['area_ping'] != ""){
                                                                    echo $floorDetails['area_ping'].Yii::app()->controller->__trans('tsubo');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="prm">
                                                            <?php
                                                                if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != "" && $floorDetails['rent_unit_price'] != 0){
                                                                    echo ''.Yii::app()->controller->renderPrice($floorDetails['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                }else{
                                                                    if($floorDetails['rent_unit_price_opt'] != ''){
                                                                        if($floorDetails['rent_unit_price_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');
                                                                        }else if($floorDetails['rent_unit_price_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('ask');
                                                                        }
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="csc">
                                                            <?php
                                                                if(isset($floorDetails['unit_condo_fee']) && $floorDetails['unit_condo_fee'] != "" && $floorDetails['unit_condo_fee'] != 0){
                                                                        echo ''.Yii::app()->controller->renderPrice($floorDetails['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                    }else{
                                                                    if($floorDetails['unit_condo_fee_opt'] != ''){
                                                                        if($floorDetails['unit_condo_fee_opt'] == 0){
                                                                            echo Yii::app()->controller->__trans('none');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('ask');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -3){
                                                                            echo '賃料に込み';
                                                                        }
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="dps">
                                                            <?php
                                                                /*if(isset($floorDetails['total_deposit']) && $floorDetails['total_deposit'] != "0" && $floorDetails['total_deposit'] != ""){
                                                                    echo Yii::app()->controller->renderPrice($floorDetails['total_deposit']).' 円';
                                                                }
                                                                if($floorDetails['deposit_opt'] != ''){
                                                                    echo '<br/>';
                                                                    if($floorDetails['deposit_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('undecided');
                                                                    }else if($floorDetails['deposit_opt'] == -3){
                                                                        echo Yii::app()->controller->__trans('none');
                                                                    }else if($floorDetails['deposit_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                                    }
                                                                }*/
                                                                if(isset($floorDetails['deposit_month']) &&  $floorDetails['deposit_month'] != ''){
                                                                    echo $floorDetails['deposit_month'].' ヶ月';
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?><br>
                                                            <?php
                                                                /*if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != ""){
                                                                    echo '('.$floorDetails['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                                }else{
                                                                    echo '';
                                                                }*/
                                                            ?>
                                                        </td>
                                                        <td class="money">
                                                            <?php  
                                                                if(isset($floorDetails['key_money_opt']) && $floorDetails['key_money_opt'] != ""){
                                                                    if($floorDetails['key_money_opt'] == 2){
                                                                        echo Yii::app()->controller->__trans('None');
                                                                    }elseif($floorDetails['key_money_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('Unknown');
                                                                    }elseif($floorDetails['key_money_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }else{
                                                                    echo '';
                                                                }
                                                                
                                                                if(isset($floorDetails['key_money_month']) && $floorDetails['key_money_month'] != ""){
                                                                    echo $floorDetails['key_money_month'].Yii::app()->controller->__trans('month');
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="am">
                                                            <?php
                                                                if(isset($floorDetails['repayment_opt']) && $floorDetails['repayment_opt'] != ""){
                                                                    if($floorDetails['repayment_opt'] == -3){
                                                                        echo Yii::app()->controller->__trans('None')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -4){
                                                                        echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -5){
                                                                        echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_reason']) && $floorDetails['repayment_reason'] != ""){
                                                                    if($floorDetails['repayment_reason'] == 1){
                                                                        echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                                    }elseif($floorDetails['repayment_reason'] == 2){
                                                                        echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_amt']) && $floorDetails['repayment_amt'] != ""){
                                                                    echo $floorDetails['repayment_amt'];
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_amt_opt']) && $floorDetails['repayment_amt_opt'] != ""){
                                                                    if($floorDetails['repayment_amt_opt'] == 1){
                                                                        echo Yii::app()->controller->__trans('ヶ月'); 
                                                                    }elseif($floorDetails['repayment_amt_opt'] == 2){
                                                                        echo Yii::app()->controller->__trans('%')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="period">
                                                            <?php
                                                                if(isset($floorDetails['contract_period_duration']) && $floorDetails['contract_period_duration'] != ""){
                                                                    echo $floorDetails['contract_period_duration'];
                                                                    echo $floorDetails['contract_period_duration'] > 1 && $floorDetails['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="sc">
                                                            <?php
                                                                if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != "0"){
                                                                    echo $floorDetails['move_in_date'];
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="update">
                                                            <?php
                                                                if(isset($floorDetails['modified_on']) && $floorDetails['modified_on'] != ""){
                                                                    if($floorDetails['modified_on'] != "0000-00-00 00:00:00"){
                                                                        echo date('Y.m.d',strtotime($floorDetails['modified_on']));
                                                                    }else{
                                                                        echo date('Y.m.d',strtotime($floorDetails['added_on']));
                                                                    }
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    //}
                                                }
                                            }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                              <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php /*?><div class="bt_input_box">
                            <div class="bt_input">
                                <input type="button"  class="bt_entry clone-floor-settings" value="<?php echo Yii::app()->controller->__trans('フロア情報を更新');?>">
                            </div>
                        </div><?php */?>
                        
                    </div>
                    <div class="tabs-item">
                    	<div class="formbox f-full">
                        	<div class="table-inner">
                            	<table class="update_ahv tb-floor">
                                	<tbody>
                                    	<tr>
                                        	<th class="dt">-</th>
                                            <th class="fl"><?php echo Yii::app()->controller->__trans('vacant or not');?></th>
                                            <th class="ty1"><?php echo Yii::app()->controller->__trans('rent fee');?></th>
                                            <th class="ty1"><?php echo Yii::app()->controller->__trans('condo fee');?></th>
                                            <th class="ty2"><?php echo Yii::app()->controller->__trans('deposit');?></th>
                                            <th class="ty2"><?php echo Yii::app()->controller->__trans('key money');?></th>
                                            <th class="ty3"><?php echo Yii::app()->controller->__trans('source of info');?></th>
                                            <th class="ty4"><?php echo Yii::app()->controller->__trans('confirmation of contents');?></th>
                                            <th class="ty4"><?php echo Yii::app()->controller->__trans('update person');?></th>
                                            <th class="ty4"><?php echo Yii::app()->controller->__trans('Property confirmation person in charge');?></th>
                                       </tr>
                                       <?php
                                       if(isset($updateHistory) && count($updateHistory) > 0){
										   foreach($updateHistory as $update){
										?>
                                        <tr>
                                        	<th class="date">
												<?php
												if(isset($update['modified_on'])){
													if(date('Y-m-d',strtotime($update['modified_on'])) != '0000-00-00'){
														echo date('Y-m-d',strtotime($update['modified_on']));
													}else{
														echo '-';
													} 
												}
                                                ?>
                                            </th>
                                            <?php
											if(isset($update['vacancy_info']) && $update['vacancy_info'] == 1){
												echo '<td style="color:blue;" class="fl">空室</td>';
											}else{
												echo '<td style="color:red;" class="fl">満室</td>';
											}
											?>
                                            <td class="ty1">
												<?php
													if(isset($update['rent_unit_price']) && $update['rent_unit_price'] != ""){
														echo $update['rent_unit_price'].' 円/坪';
													}else{
														if($update['rent_unit_price_opt'] != ''){
															if($update['rent_unit_price_opt'] == -1){
																echo Yii::app()->controller->__trans('undecided');
															}else if($update['rent_unit_price_opt'] == -2){
																echo Yii::app()->controller->__trans('ask');
															}
														}else{
															echo '-';
														}
													}
												?>
                                            </td>
                                            <td class="ty1">
												<?php
												if(isset($update['unit_condo_fee']) && $update['unit_condo_fee'] != ""){
													echo ''.$update['unit_condo_fee'].' 円/坪';
												}else{
													if($update['unit_condo_fee_opt'] != ''){
														if($update['unit_condo_fee_opt'] == 0){
															echo Yii::app()->controller->__trans('none');
														}else if($update['unit_condo_fee_opt'] == -1){
															echo Yii::app()->controller->__trans('undecided');
														}else if($update['unit_condo_fee_opt'] == -2){
															echo Yii::app()->controller->__trans('ask');
														}else if($update['unit_condo_fee_opt'] == -3){
															echo Yii::app()->controller->__trans('賃料に込み<br/>(含む)');
														}
													}else{
														echo '-';
													}
												}
												?>
                                            </td>
                                            <td class="ty2">
						                   <?php
                                                if(isset($update['deposit_opt']) && $update['deposit_opt'] != ""){
                                                    if($update['deposit_opt'] == -1 ){
                                                        echo Yii::app()->controller->__trans('未定');
                                                    }else if($update['deposit_opt'] == -3){
                                                        echo Yii::app()->controller->__trans('無し');
                                                    }else if($update['deposit_opt'] == -2){
                                                        echo Yii::app()->controller->__trans('未定･相談');
                                                    }else{
                                                        echo '';
                                                    }
                                                }
												if(isset($update['deposit_month']) && $update['deposit_month'] != ''){
													echo $update['deposit_month'].' '.Yii::app()->controller->__trans('month');
												}else{
													echo '';
												}
												
												if(isset($update['deposit']) && $update['deposit'] != ""){
													echo '('.$update['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
												}else{
													echo '';
												}
                                                ?>
                                            </td>
                                            <td class="ty2">
                                            	<?php
													if(isset($update['key_money_opt']) && $update['key_money_opt'] != ""){
														if($update['key_money_opt'] == 2){
															echo Yii::app()->controller->__trans('None');
														}elseif($update['key_money_opt'] == -1){
															echo Yii::app()->controller->__trans('Unknown');
														}elseif($update['key_money_opt'] == -2){
															echo Yii::app()->controller->__trans('undecided･ask');
														}else{
															echo '';
														}
													}else{
														echo '';
													}
													
													if(isset($update['key_money_month']) && $update['key_money_month'] != ""){
														echo $update['key_money_month'].Yii::app()->controller->__trans('month');
													}
												?>
                                            </td>
                                            <td class="ty3">
												<?php
                                                if(isset($update['floor_source_id'])){
													if(isset($floorSourceDetails) && count($floorSourceDetails) > 0){
														foreach($floorSourceDetails as $floors){
															if($floors['floor_source_from_type_id'] == $update['floor_source_id']){
																echo $floors['floor_source_from_type_name'];
															}
														}
													}
												}
                                                ?>
                                            </td>
                                            <td class="ty4">
                                            	<?php
                                                if(isset($update['what_to_check'])){
													echo $update['what_to_check'];
												}
                                                ?>
                                            </td>
                                            <td class="ty4">
												<?php
                                                if(isset($update['update_person_in_charge'])){
													if(isset($userList) && count($userList) > 0){
														foreach($userList as $u){
															if($u['user_id'] == $update['update_person_in_charge']){
																$uName = AdminDetails::model()->find('user_id = '.$u['user_id']);
																echo $uName->full_name;
															}
														}
													}
												}
                                                ?>
                                            </td>
                                            <td class="ty4">
												<?php
                                                if(isset($update['property_confirmation_person'])){
													if(isset($userList) && count($userList) > 0){
														foreach($userList as $u){
															if($u['user_id'] == $update['property_confirmation_person']){
																$uName = AdminDetails::model()->find('user_id = '.$u['user_id']);
																echo $uName->full_name;
															}
														}
													}
												}
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
											<?php
                                                }
                                            }else{
                                                echo '<td colspan="11" class="no_result">'.Yii::app()->controller->__trans('No History Available') .'</td>';
                                            }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tabs-item">
                    	<form name="frmAddSharedManagementHistory" id="frmAddSharedManagementHistory" class="frmAddSharedManagementHistory" action="<?php echo Yii::app()->createUrl('floor/addNewManagementHistory'); ?>" method="post">
                        <input type="hidden" name="hdnBillId" id="hdnBillId" class="hdnBillId" value="<?php echo $buildingId; ?>" />
                        <input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo isset($model->floor_id) && $model->floor_id != '' ?  $model->floor_id:''; ?>" />
                        <input type="hidden" name="hdnOtherCFloorId" id="hdnOtherCFloorId" class="hdnOtherCFloorId" value="0" />
                        <input type="hidden" name="inUpdate" id="inUpdate" class="inUpdate" value="<?php echo isset($model->floor_id) && $model->floor_id != '' ? 1 : 0; ?>" />
                        
                        <div class="formbox f-full owner-info">
                        	<div class="table-inner">
                            	<?php
									if(isset($model->floor_id) && $model->floor_id != ""){
										$managementSharedDetails = OwnershipManagement::model()->findAll('building_id = '.$model->building_id.' AND floor_id = '.$model->floor_id.' and is_shared = 1 ORDER BY ownership_management_id DESC LIMIT 1');
									}else{
										$managementSharedDetails = array();
									}
									$isSharedOpt = '0';
									$trader = '';
									$ownerType = '';
									$managementType = '';
									$isWindow = '';
									if(count($managementSharedDetails) > 0){
										$isSharedOpt = $managementSharedDetails[0]->is_shared;
										$trader = $managementSharedDetails[0]->trader_id;
										$ownerType = $managementSharedDetails[0]->ownership_type;
										$managementType = $managementSharedDetails[0]->management_type;
										$isWindow = $managementSharedDetails[0]->is_current;
									}
								?>
                                <table class="edit_input f_info_b mline tb-floor one-col mix-col">
                                	<tbody>
                                    	<tr>
                                        	<th class="minsize">
												<?php echo Yii::app()->controller->__trans('共用オーナー');?>
                                            </th>
                                            <td>
                                            	<label class="rd2">
													<?php $owner_checked = 'checked';?>
                                                    <input type="radio" value="1" name="is_shared"<?php echo isset($isSharedOpt) && $isSharedOpt == '1' ? $owner_checked : '';?>>
													<?php echo Yii::app()->controller->__trans('YES');?>
                                                </label>
                                                <label class="rd2">
                                                	<input type="radio" value="0" name="is_shared" <?php echo isset($isSharedOpt) && $isSharedOpt == '0' ? $owner_checked : '';?>>
													<?php echo Yii::app()->controller->__trans('NO');?>
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="edit_input f_info mt tb-floor one-col mix-col">
                                	<tbody>
                                    	<tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('業者ID');?>
                                            </th>
                                            <?php /*?><td colspan="3">
                                            	<input type="text" name="searchTraderText" class="ty3 searchTraderText" id="searchTraderText" style="float:left;">
                                                <input type="button" name="btnSearchTrader" id="btnSearchTrader" class="btnSearchTrader bt_entry autoWidth" value="<?php echo Yii::app()->controller->__trans('Search Trader');?>"><br/>
                                                <div class="traderResp">
                                                	<span id="owner_id_select">
                                                		<select id="tradersList"  class="auto tradersList" name="Floor[trader_id]">
                                                            <option value="0"><?php echo Yii::app()->controller->__trans('saved traders');?>↓</option>
                                                            <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
                                                            <?php
                                                            if(isset($tradersDetails) && count($tradersDetails) > 0){
                                                                foreach($tradersDetails as $tradersList){
                                                            ?>
                                                            <option value="<?php echo $tradersList['trader_id']; ?>" ><?php echo $tradersList['trader_name']; ?></option>
                                                            <?php
                                                                }
                                                            }else{
                                                            ?>
                                                            <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                   	</span> &nbsp;
                                                </div>←
                                                <input type="text" name="newTrader" id="newTrader" class="ty1 newTrader">
                                                <input type="button" name="add-trader" id="btnAddTrader" class="btnAddTrader bt_entry autoWidth" value="<?php echo Yii::app()->controller->__trans('Add Traders');?>">
                                            </td><?php */?>
                                            <td colspan="3">
                                            	<div class="traderResp">
                                                	<span id="owner_id_select">
                                                    	<select id="tradersList"  class="auto tradersList" name="trader_id">
                                                        	<option value="0"><?php echo Yii::app()->controller->__trans('saved traders');?>↓</option>
                                                            <?php
															if($model->floor_id != "" && $model->floor_id != 0){
																//$tradersDetails = Traders::model()->findAll('is_active = 1 AND building_id = '.$buildingId.' AND floor_id = '.$model->floor_id);
																$tradersDetails = Traders::model()->findAll('is_active = 1 AND building_id = '.$buildingId);
															}else{
																$tradersDetails = Traders::model()->findAll('is_active = 1 AND building_id = '.$buildingId);
															}
                                                            if(isset($tradersDetails) && count($tradersDetails) > 0){
                                                                foreach($tradersDetails as $tradersList){
                                                            ?>
                                                            <option value="<?php echo $tradersList['trader_id']; ?>"><?php echo $tradersList['traderId'].' '.$tradersList['trader_name']; ?></option>
                                                            <?php
                                                                }
                                                            }else{
                                                            ?>
                                                            <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                   	</span> &nbsp;
                                                </div>
                                                <div class="loadTraders" style="display:none;">
                                                    <div class="spinner">
                                                        <div class="rect1"></div>
                                                        <div class="rect2"></div>
                                                        <div class="rect3"></div>
                                                        <div class="rect4"></div>
                                                        <div class="rect5"></div>
                                                    </div>
                                                </div>
                                                <!--←-->
                                                <?php /*?><input type="text" name="newTrader" id="newTrader" class="ty1 newTrader">
                                                <input type="button" name="add-trader" id="btnAddTrader" class="btnAddTrader bt_entry autoWidth" value="<?php echo Yii::app()->controller->__trans('Add Traders');?>"><?php */?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('ownership type');?>
                                            </th>
                                            <td>
                                            	<select name="ownership_type" id="ownership_type" data-role="none" class="ownership_type">
                                                	<option value="">-</option>
                                                    <option value="1"><?php echo Yii::app()->controller->__trans('owner');?></option>
                                                    <option value="6"><?php echo Yii::app()->controller->__trans('サブリース');?></option>
                                                    <option value="7"><?php echo Yii::app()->controller->__trans('貸主代理');?></option>
                                                    <option value="8"><?php echo Yii::app()->controller->__trans('AM');?></option>
                                                    <option value="10"><?php echo Yii::app()->controller->__trans('業者');?></option>
                                                    <option value="4"><?php echo Yii::app()->controller->__trans('intermediary agent');?></option>
                                                    <option value="2"><?php echo Yii::app()->controller->__trans('management company');?></option>
                                                    <option value="9"><?php echo Yii::app()->controller->__trans('PM');?></option>
                                                    <option value="3"><?php echo Yii::app()->controller->__trans('general contractor');?></option>
                                                    <option value="-1"><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                                </select>
                                            </td>
                                            <th>
												<?php echo Yii::app()->controller->__trans('management type');?>
                                            </th>
                                            <td>
                                            	<select name="management_type" id="management_type" data-role="none" class="management_type">
                                                    <option value="">-</option>
                                                    <option value="-1"><?php echo Yii::app()->controller->__trans('unknown');?></option>
                                                    <option value="1"><?php echo Yii::app()->controller->__trans('専任媒介');?></option>
                                                    <option value="2"><?php echo Yii::app()->controller->__trans('一般媒介');?></option>
                                                    <option value="3"><?php echo Yii::app()->controller->__trans('代理');?></option>
                                                    <option value="4"><?php echo Yii::app()->controller->__trans('貸主');?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('Window');?>
                                            </th>
                                            <td colspan="3">
                                            	<label for="is_current">
                                                	<input type="checkbox" name="is_current" id="is_current" class="is_current" value="1"/> <?php echo Yii::app()->controller->__trans('Setting this trader owner properties window');?>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('company name');?>
                                            </th>
                                            <td colspan="3">
                                            	<input type="text" name="owner_company_name" id="bo_name" value="" class="ty6 owner_company_name">
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('place to contact');?>
                                            </th>
                                            <td colspan="3">
                                            	<input type="text" name="company_tel" id="bo_tel1" value="" class="ty6 company_tel">
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('person in charge1');?>
                                            </th>
                                            <td>
                                            	<input type="text" name="person_in_charge1" id="bo_rep1" value="" class="ty3 person_in_charge1">
                                            </td>
                                            <th>
												<?php echo Yii::app()->controller->__trans('person in charge2');?>
                                            </th>
                                            <td>
                                            	<input type="text" name="person_in_charge2" id="bo_rep2" value="" class="ty3 person_in_charge2">
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>
												<?php echo Yii::app()->controller->__trans('commission fee');?>
                                            </th>
                                            <td colspan="3">
                                                <label class="rd2">
                                                    <input type="radio" name="charge" value="<?php echo Yii::app()->controller->__trans('unknown');?>">
                                                    <?php echo Yii::app()->controller->__trans('unknown');?>
                                                </label>
                                                <label class="rd2">
                                                	<input type="radio" name="charge" value="<?php echo Yii::app()->controller->__trans('ask');?>">
													<?php echo Yii::app()->controller->__trans('ask');?>
                                                </label>
                                                <label class="rd2">
                                                	<input type="radio" name="charge" value="<?php echo Yii::app()->controller->__trans('undecided');?>">
													<?php echo Yii::app()->controller->__trans('undecided');?>
                                                </label>
                                                <label class="rd2">
                                                	<input type="radio" name="charge" value="<?php echo Yii::app()->controller->__trans('none');?>">
													<?php echo Yii::app()->controller->__trans('none');?>
                                                </label>|
                                                <input type="text" name="change_txt" id="bo_fee" size="5" value="" class="ty8 change_txt">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </form>
                        <div class="bt_input_box">
                        	<div class="bt_input">
                            	<button type="button" name="btnAddSharedManagementDetails" id="btnAddSharedManagementDetails" class="btnAddSharedManagementDetails"><?php echo Yii::app()->controller->__trans('Update Management Information'); ?></button>
                             </div>
                        </div>
                        
                        <div class="formbox f-full">
                            <div class="table-inner">
                                <?php
                                $otherFloors = array();
                                if(isset($buildingId)){
                                    //compart floor details
                                    $compartOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' and is_compart = 1');
                                    $cFloorIds = array();
                                    if(count($compartOwnerFloor) > 0){
                                        foreach($compartOwnerFloor as $cFloor){
                                            $cFloorIds[] = $cFloor['floor_id'];
                                        }
                                    }
                                    //shared floor details
                                    $sharedOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' and is_shared = 1');
                                    $sFloorIds = array();
                                    if(count($sharedOwnerFloor) > 0){
                                        foreach($sharedOwnerFloor as $sFloor){
                                            $sFloorIds[] = $sFloor['floor_id'];
                                        }
                                    }
                                    //all floor details
                                    $otherFloors = Floor::model()->findAll('building_id = '.$buildingId);
                                ?>
                                    <table class="f_update floors_list tblComp">
                                        <thead>
                                            <tr class="none">
                                                <th scope="col" class="bt">
                                                	<input type="checkbox" class="checkAllShared" id="checkAllShared">
                                                </th>
                                                <th scope="col" class="code"><?php echo Yii::app()->controller->__trans('code'); ?></th>
                                                <th scope="col" class="no"><?php echo Yii::app()->controller->__trans('number of stairs・room number'); ?></th>
                                                <th scope="col" class="spot"><font><font><?php echo Yii::app()->controller->__trans('number of Tsubo'); ?></font></font></th>
                                                <th scope="col" class="prm"><font><font><?php echo Yii::app()->controller->__trans('rent'); ?></font></font></th>
                                                <th scope="col" class="csc"><font><font><?php echo Yii::app()->controller->__trans('condo fees'); ?></font></font></th>
                                                <th scope="col" class="dps"><font><font><?php echo Yii::app()->controller->__trans('deposit'); ?></font></font></th>
                                                <th scope="col" class="money"><font><font><?php echo Yii::app()->controller->__trans('key money'); ?></font></font></th>
                                                <th scope="col" class="am"><font><font><?php echo Yii::app()->controller->__trans('repayment'); ?></font></font></th>
                                                <th scope="col" class="period"><?php echo Yii::app()->controller->__trans('contract years'); ?></th>
                                                <th scope="col" class="sc"><font><font><?php echo Yii::app()->controller->__trans('date move in'); ?></font></font></th>
                                                <th scope="col" class="update"><?php echo Yii::app()->controller->__trans('last modified'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($otherFloors) && count($otherFloors) > 0){
                                                foreach($otherFloors as $oFloor){
                                                    if(in_array($oFloor['floor_id'],$cFloorIds)){
                                                        continue;
                                                    }
                                                    if(in_array($oFloor['floor_id'],$sFloorIds)){
                                                        continue;
                                                    }
                                            ?>
                                            <tr class="">
                                                <td class="bt">
                                                    <?php
                                                    if($oFloor['floor_id'] != $_GET['id']){
                                                    ?>
                                                        <input type="checkbox" class="sharedFloor" data-floor="<?php echo $oFloor['floor_id']; ?>" name="sharedFloor" value="<?php echo $oFloor['floor_id']; ?>">
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="ico">
                                                    <?php
                                                    if($oFloor['vacancy_info'] == 0){
                                                        $vac = 'full';
                                                        $lbl = '満';
                                                    }else{
                                                        $vac = 'empty';
                                                        $lbl = '空';
                                                    }
                                                    ?>
                                                    <span class="rm-status <?php echo $vac; ?>">
                                                        <?php echo $lbl; ?>
                                                    </span>
                                                    <?php echo $oFloor['floor_id']; ?>
                                                </td>
                                                <td class="fl_num">
                                                    <?php
                                                        if(strpos($oFloor['floor_down'], '-') !== false){
                                                            $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $oFloor['floor_down']);
                                                        }else{
                                                            $floorDown = $oFloor['floor_down'];
                                                        }
                                                        $stairs = $floorDown;
                                                        $stairs .= '階'.$oFloor['floor_up'];
                                                        echo $stairs.'  '.$oFloor['roomname'];
                                                    ?>
                                                </td>
                                                <td class="fl_area">
                                                    <?php
                                                        if($oFloor['area_ping'] != ""){
                                                            echo $oFloor['area_ping'].Yii::app()->controller->__trans('tsubo');
                                                        }else{
                                                            echo '-';
                                                        }
                                                    ?>
                                                </td>
                                                <td class="prm">
                                                    <?php
                                                        if(isset($oFloor['rent_unit_price']) && $oFloor['rent_unit_price'] != "" && $oFloor['rent_unit_price'] != 0){
                                                            echo ''.Yii::app()->controller->renderPrice($oFloor['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                        }else{
                                                            if($oFloor['rent_unit_price_opt'] != ''){
                                                                if($oFloor['rent_unit_price_opt'] == -1){
                                                                    echo Yii::app()->controller->__trans('undecided');
                                                                }else if($oFloor['rent_unit_price_opt'] == -2){
                                                                    echo Yii::app()->controller->__trans('ask');
                                                                }
                                                            }else{
                                                                echo '-';
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td class="csc">
                                                    <?php
                                                        if(isset($oFloor['unit_condo_fee']) && $oFloor['unit_condo_fee'] != "" && $oFloor['unit_condo_fee'] != 0){
                                                                echo ''.Yii::app()->controller->renderPrice($oFloor['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                            }else{
                                                            if($oFloor['unit_condo_fee_opt'] != ''){
                                                                if($oFloor['unit_condo_fee_opt'] == 0){
                                                                    echo Yii::app()->controller->__trans('none');
                                                                }else if($oFloor['unit_condo_fee_opt'] == -1){
                                                                    echo Yii::app()->controller->__trans('undecided');
                                                                }else if($oFloor['unit_condo_fee_opt'] == -2){
                                                                    echo Yii::app()->controller->__trans('ask');
                                                                }else if($oFloor['unit_condo_fee_opt'] == -3){
                                                                    echo '賃料に込み';
                                                                }
                                                            }else{
                                                                echo '-';
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td class="dps">
                                                    <?php
                                                        /*if(isset($oFloor['total_deposit']) && $oFloor['total_deposit'] != "0" && $oFloor['total_deposit'] != ""){
                                                            echo Yii::app()->controller->renderPrice($oFloor['total_deposit']).' 円';
                                                        }
                                                        if($oFloor['deposit_opt'] != ''){
                                                            echo '<br/>';
                                                            if($oFloor['deposit_opt'] == -1){
                                                                echo Yii::app()->controller->__trans('undecided');
                                                            }else if($oFloor['deposit_opt'] == -3){
                                                                echo Yii::app()->controller->__trans('none');
                                                            }else if($oFloor['deposit_opt'] == -2){
                                                                echo Yii::app()->controller->__trans('undecided･ask');
                                                            }
                                                        }*/
                                                        if(isset($oFloor['deposit_month']) &&  $oFloor['deposit_month'] != ''){
                                                            echo $oFloor['deposit_month'].' ヶ月';
                                                        }else{
                                                            echo '-';
                                                        }
                                                    ?><br>
                                                    <?php
                                                        /*if(isset($oFloor['deposit']) && $oFloor['deposit'] != ""){
                                                            echo '('.$oFloor['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                        }else{
                                                            echo '';
                                                        }*/
                                                    ?>
                                                </td>
                                                <td class="money">
                                                    <?php  
                                                        if(isset($oFloor['key_money_opt']) && $oFloor['key_money_opt'] != ""){
                                                            if($oFloor['key_money_opt'] == 2){
                                                                echo Yii::app()->controller->__trans('None');
                                                            }elseif($oFloor['key_money_opt'] == -1){
                                                                echo Yii::app()->controller->__trans('Unknown');
                                                            }elseif($oFloor['key_money_opt'] == -2){
                                                                echo Yii::app()->controller->__trans('undecided･ask');
                                                            }else{
                                                                echo '';
                                                            }
                                                        }else{
                                                            echo '';
                                                        }
                                                        
                                                        if(isset($oFloor['key_money_month']) && $oFloor['key_money_month'] != ""){
                                                            echo $oFloor['key_money_month'].Yii::app()->controller->__trans('month');
                                                        }
                                                    ?>
                                                </td>
                                                <td class="am">
                                                    <?php
                                                        if(isset($oFloor['repayment_opt']) && $oFloor['repayment_opt'] != ""){
                                                            if($oFloor['repayment_opt'] == -3){
                                                                echo Yii::app()->controller->__trans('None')."<br>"; 
                                                            }elseif($oFloor['repayment_opt'] == -4){
                                                                echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                            }elseif($oFloor['repayment_opt'] == -1){
                                                                echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                            }elseif($oFloor['repayment_opt'] == -2){
                                                                echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                            }elseif($oFloor['repayment_opt'] == -5){
                                                                echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                            }else{
                                                                echo '';
                                                            }
                                                        }
                                                        
                                                        if(isset($oFloor['repayment_reason']) && $oFloor['repayment_reason'] != ""){
                                                            if($oFloor['repayment_reason'] == 1){
                                                                echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                            }elseif($oFloor['repayment_reason'] == 2){
                                                                echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                            }else{
                                                                echo '';
                                                            }
                                                        }
                                                        
                                                        if(isset($oFloor['repayment_amt']) && $oFloor['repayment_amt'] != ""){
                                                            echo $oFloor['repayment_amt'];
                                                        }
                                                        
                                                        if(isset($oFloor['repayment_amt_opt']) && $oFloor['repayment_amt_opt'] != ""){
                                                            if($oFloor['repayment_amt_opt'] == 1){
                                                                echo Yii::app()->controller->__trans('ヶ月'); 
                                                            }elseif($oFloor['repayment_amt_opt'] == 2){
                                                                echo Yii::app()->controller->__trans('%')."<br>"; 
                                                            }else{
                                                                echo '';
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td class="period">
                                                    <?php
                                                    if(isset($oFloor['contract_period_duration']) && $oFloor['contract_period_duration'] != ""){
                                                        echo $oFloor['contract_period_duration'];
                                                        echo $oFloor['contract_period_duration'] > 1 && $oFloor['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
                                                    }else{
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="sc">
                                                    <?php
                                                    if(isset($oFloor['move_in_date']) && $oFloor['move_in_date'] != "" && (string)$oFloor['move_in_date'] != "0"){
                                                        echo $oFloor['move_in_date'];
                                                    }else{
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="update">
                                                    <?php
                                                    if(isset($oFloor['modified_on']) && $oFloor['modified_on'] != ""){
                                                        if($oFloor['modified_on'] != "0000-00-00 00:00:00"){
                                                            echo date('Y.m.d',strtotime($oFloor['modified_on']));
                                                        }else{
                                                            echo date('Y.m.d',strtotime($oFloor['added_on']));
                                                        }
                                                    }else{
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            
                                            <?php
                                            $query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingId.' AND `is_compart` = 1 GROUP BY ownership_type';
                                            $allCompartOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
                                            
                                            $cFloorIDs = array();
                                            $ownerNames = array();
                                            foreach($allCompartOwnerDetails as $aFloor){
                                                $cFloorIDs[] = $aFloor['floor_id'];
                                                $ownerNames[$aFloor['ownership_type']] = $aFloor['owner_company_name'];
                                            }
                                            
                                            $cFloorIDs = array_unique($cFloorIDs);
                                            if(count($cFloorIDs) > 0){
                                                foreach($cFloorIDs as $fId){
                                                    $oDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' and floor_id ='.$fId.' AND is_compart = 1');
                                            ?>
                                            <tr>
                                                <td colspan="12" style="text-align:left;">
                                                    <span class="labelCompartInSingle">区分所有フロア</span></br>
                                                    <?php foreach($ownerNames as $key=>$val){?>
                                                    <span class="vendor-label">
                                                        <?php
                                                        $managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
                                                        if(array_key_exists($key,$managementArray)){
                                                            echo $managementArray[$key];
                                                        }													
                                                        ?>
                                                    </span>
                                                    <?php echo $val;?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                                    //foreach($oDetails as $compDetails){
                                                        $floorDetails = Floor::model()->find('floor_id = '.$fId);
                                            ?>
                                                    <tr class="">
                                                        <td class="bt">
                                                        <?php
                                                        if($floorDetails['floor_id'] != $_GET['id']){
                                                        ?>
                                                            <input type="checkbox" class="sharedFloor" data-floor="<?php echo $floorDetails['floor_id']; ?>" name="sharedFloor" value="<?php echo $floorDetails['floor_id']; ?>">
                                                        <?php
                                                        }
                                                        ?>
                                                        </td>
                                                        <td class="ico">
                                                        <?php
                                                        if($floorDetails['vacancy_info'] == 0){
                                                            $vac = 'full';
                                                            $lbl = '満';
                                                        }else{
                                                            $vac = 'empty';
                                                            $lbl = '空';
                                                        }
                                                        ?>
                                                        <span class="rm-status <?php echo $vac; ?>">
                                                            <?php echo $lbl; ?>
                                                        </span>
                                                        <?php echo $floorDetails['floor_id']; ?>
                                                        </td>
                                                        <td class="fl_num">
                                                            <?php
                                                                if(strpos($floorDetails['floor_down'], '-') !== false){
                                                                    $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
                                                                }else{
                                                                    $floorDown = $floorDetails['floor_down'];
                                                                }
                                                                $stairs = $floorDown;
                                                                $stairs .= '階'.$floorDetails['floor_up'];
                                                                echo $stairs.'  '.$floorDetails['roomname'];
                                                            ?>
                                                        </td>
                                                        <td class="fl_area">
                                                            <?php
                                                                if($floorDetails['area_ping'] != ""){
                                                                    echo $floorDetails['area_ping'].Yii::app()->controller->__trans('tsubo');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="prm">
                                                            <?php
                                                                if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != "" && $floorDetails['rent_unit_price'] != 0){
                                                                    echo ''.Yii::app()->controller->renderPrice($floorDetails['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                }else{
                                                                    if($floorDetails['rent_unit_price_opt'] != ''){
                                                                        if($floorDetails['rent_unit_price_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');
                                                                        }else if($floorDetails['rent_unit_price_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('ask');
                                                                        }
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="csc">
                                                            <?php
                                                                if(isset($floorDetails['unit_condo_fee']) && $floorDetails['unit_condo_fee'] != "" && $floorDetails['unit_condo_fee'] != 0){
                                                                        echo ''.Yii::app()->controller->renderPrice($floorDetails['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                    }else{
                                                                    if($floorDetails['unit_condo_fee_opt'] != ''){
                                                                        if($floorDetails['unit_condo_fee_opt'] == 0){
                                                                            echo Yii::app()->controller->__trans('none');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');

                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('ask');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -3){
                                                                            echo '賃料に込み';
                                                                        }
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="dps">
                                                            <?php
                                                                /*if(isset($floorDetails['total_deposit']) && $floorDetails['total_deposit'] != "0" && $floorDetails['total_deposit'] != ""){
                                                                    echo Yii::app()->controller->renderPrice($floorDetails['total_deposit']).' 円';
                                                                }
                                                                if($floorDetails['deposit_opt'] != ''){
                                                                    echo '<br/>';
                                                                    if($floorDetails['deposit_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('undecided');
                                                                    }else if($floorDetails['deposit_opt'] == -3){
                                                                        echo Yii::app()->controller->__trans('none');
                                                                    }else if($floorDetails['deposit_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                                    }
                                                                }*/
                                                                if(isset($floorDetails['deposit_month']) &&  $floorDetails['deposit_month'] != ''){
                                                                    echo $floorDetails['deposit_month'].' ヶ月';
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?><br>
                                                            <?php
                                                                /*if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != ""){
                                                                    echo '('.$floorDetails['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                                }else{
                                                                    echo '';
                                                                }*/
                                                            ?>
                                                        </td>
                                                        <td class="money">
                                                            <?php  
                                                                if(isset($floorDetails['key_money_opt']) && $floorDetails['key_money_opt'] != ""){
                                                                    if($floorDetails['key_money_opt'] == 2){
                                                                        echo Yii::app()->controller->__trans('None');
                                                                    }elseif($floorDetails['key_money_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('Unknown');
                                                                    }elseif($floorDetails['key_money_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }else{
                                                                    echo '';
                                                                }
                                                                
                                                                if(isset($floorDetails['key_money_month']) && $floorDetails['key_money_month'] != ""){
                                                                    echo $floorDetails['key_money_month'].Yii::app()->controller->__trans('month');
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="am">
                                                            <?php
                                                                if(isset($floorDetails['repayment_opt']) && $floorDetails['repayment_opt'] != ""){
                                                                    if($floorDetails['repayment_opt'] == -3){
                                                                        echo Yii::app()->controller->__trans('None')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -4){
                                                                        echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -5){
                                                                        echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_reason']) && $floorDetails['repayment_reason'] != ""){
                                                                    if($floorDetails['repayment_reason'] == 1){
                                                                        echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                                    }elseif($floorDetails['repayment_reason'] == 2){
                                                                        echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_amt']) && $floorDetails['repayment_amt'] != ""){
                                                                    echo $floorDetails['repayment_amt'];
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_amt_opt']) && $floorDetails['repayment_amt_opt'] != ""){
                                                                    if($floorDetails['repayment_amt_opt'] == 1){
                                                                        echo Yii::app()->controller->__trans('ヶ月'); 
                                                                    }elseif($floorDetails['repayment_amt_opt'] == 2){
                                                                        echo Yii::app()->controller->__trans('%')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="period">
                                                            <?php
                                                            if(isset($floorDetails['contract_period_duration']) && $floorDetails['contract_period_duration'] != ""){
                                                                echo $floorDetails['contract_period_duration'];
                                                                echo $floorDetails['contract_period_duration'] > 1 && $floorDetails['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
                                                            }else{
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="sc">
                                                            <?php
                                                            if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != "0"){
                                                                echo $floorDetails['move_in_date'];
                                                            }else{
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="update">
                                                            <?php
                                                            if(isset($floorDetails['modified_on']) && $floorDetails['modified_on'] != ""){
                                                                if($floorDetails['modified_on'] != "0000-00-00 00:00:00"){
                                                                    echo date('Y.m.d',strtotime($floorDetails['modified_on']));
                                                                }else{
                                                                    echo date('Y.m.d',strtotime($floorDetails['added_on']));
                                                                }
                                                            }else{
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    //}
                                                }
                                            }
                                            ?>
                                            <?php
                                            //$allSharedOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' AND is_shared = 1');
                                            $query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingId.' AND `is_shared` = 1 GROUP BY ownership_type';
                                            $allSharedOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
                                            $sFloorIDs = array();
                                            $ownerNames = array();
                                            foreach($allSharedOwnerDetails as $aFloor){
                                                $sFloorIDs[] = $aFloor['floor_id'];
                                                $ownerNames[$aFloor['ownership_type']] = $aFloor['owner_company_name'];
                                            }
                                            $sFloorIDs = array_unique($sFloorIDs);
                                            if(count($sFloorIDs) > 0){
                                                foreach($sFloorIDs as $fId){
                                                $oDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' and floor_id ='.$fId.' AND is_shared = 1');
                                            ?>
                                            <tr>
                                                <td colspan="12" style="text-align:left;">
                                                    <span class="labelSharedInSingle">共用オーナーフロア</span></br>
                                                    <?php foreach($ownerNames as $key=>$val){?>
                                                    <span class="vendor-label">
                                                        <?php
                                                        $managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
                                                        if(array_key_exists($key,$managementArray)){
                                                            echo $managementArray[$key];
                                                        }													
                                                        ?>
                                                    </span>
                                                    <?php echo $val;?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                                    //foreach($oDetails as $sharedDetails){
                                                        $floorDetails = Floor::model()->findByPk($fId);
                                            ?>
                                                    <tr class="">
                                                        <td class="bt">
                                                        <?php
                                                        if($floorDetails['floor_id'] != $_GET['id']){
                                                        ?>
                                                            <input type="checkbox" class="sharedFloor" data-floor="<?php echo $floorDetails['floor_id']; ?>" name="sharedFloor" value="<?php echo $floorDetails['floor_id']; ?>">
                                                        <?php
                                                        }
                                                        ?>
                                                        </td>
                                                        <td class="ico">
                                                            <?php
                                                            if($floorDetails['vacancy_info'] == 0){
                                                                $vac = 'full';
                                                                $lbl = '満';
                                                            }else{
                                                                $vac = 'empty';
                                                                $lbl = '空';
                                                            }
                                                            ?>
                                                            <span class="rm-status <?php echo $vac; ?>">
                                                                <?php echo $lbl; ?>
                                                            </span>
                                                            <?php echo $floorDetails['floor_id']; ?>
                                                        </td>
                                                        <td class="fl_num">
                                                            <?php
                                                            if(strpos($floorDetails['floor_down'], '-') !== false){
                                                                $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
                                                            }else{
                                                                $floorDown = $floorDetails['floor_down'];
                                                            }
                                                            $stairs = $floorDown;
                                                            $stairs .= '階'.$floorDetails['floor_up'];
                                                            echo $stairs.'  '.$floorDetails['roomname'];
                                                            ?>
                                                        </td>
                                                        <td class="fl_area">
                                                            <?php
                                                                if($floorDetails['area_ping'] != ""){
                                                                    echo $floorDetails['area_ping'].Yii::app()->controller->__trans('tsubo');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="prm">
                                                            <?php
                                                                if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != "" && $floorDetails['rent_unit_price'] != 0){
                                                                    echo ''.Yii::app()->controller->renderPrice($floorDetails['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                }else{
                                                                    if($floorDetails['rent_unit_price_opt'] != ''){
                                                                        if($floorDetails['rent_unit_price_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');
                                                                        }else if($floorDetails['rent_unit_price_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('ask');
                                                                        }
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="csc">
                                                            <?php
                                                                if(isset($floorDetails['unit_condo_fee']) && $floorDetails['unit_condo_fee'] != "" && $floorDetails['unit_condo_fee'] != 0){
                                                                        echo ''.Yii::app()->controller->renderPrice($floorDetails['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
                                                                    }else{
                                                                    if($floorDetails['unit_condo_fee_opt'] != ''){
                                                                        if($floorDetails['unit_condo_fee_opt'] == 0){
                                                                            echo Yii::app()->controller->__trans('none');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -1){
                                                                            echo Yii::app()->controller->__trans('undecided');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -2){
                                                                            echo Yii::app()->controller->__trans('ask');
                                                                        }else if($floorDetails['unit_condo_fee_opt'] == -3){
                                                                            echo '賃料に込み';
                                                                        }
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="dps">
                                                            <?php
                                                                /*if(isset($floorDetails['total_deposit']) && $floorDetails['total_deposit'] != "0" && $floorDetails['total_deposit'] != ""){
                                                                    echo Yii::app()->controller->renderPrice($floorDetails['total_deposit']).' 円';
                                                                }
                                                                if($floorDetails['deposit_opt'] != ''){
                                                                    echo '<br/>';
                                                                    if($floorDetails['deposit_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('undecided');
                                                                    }else if($floorDetails['deposit_opt'] == -3){
                                                                        echo Yii::app()->controller->__trans('none');
                                                                    }else if($floorDetails['deposit_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                                    }
                                                                }*/
                                                                if(isset($floorDetails['deposit_month']) &&  $floorDetails['deposit_month'] != ''){
                                                                    echo $floorDetails['deposit_month'].' ヶ月';
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?><br>
                                                            <?php
                                                                /*if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != ""){
                                                                    echo '('.$floorDetails['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                                }else{
                                                                    echo '';
                                                                }*/
                                                            ?>
                                                        </td>
                                                        <td class="money">
                                                            <?php  
                                                                if(isset($floorDetails['key_money_opt']) && $floorDetails['key_money_opt'] != ""){
                                                                    if($floorDetails['key_money_opt'] == 2){
                                                                        echo Yii::app()->controller->__trans('None');
                                                                    }elseif($floorDetails['key_money_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('Unknown');
                                                                    }elseif($floorDetails['key_money_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }else{
                                                                    echo '';
                                                                }
                                                                
                                                                if(isset($floorDetails['key_money_month']) && $floorDetails['key_money_month'] != ""){
                                                                    echo $floorDetails['key_money_month'].Yii::app()->controller->__trans('month');
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="am">
                                                            <?php
                                                                if(isset($floorDetails['repayment_opt']) && $floorDetails['repayment_opt'] != ""){
                                                                    if($floorDetails['repayment_opt'] == -3){
                                                                        echo Yii::app()->controller->__trans('None')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -4){
                                                                        echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -1){
                                                                        echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -2){
                                                                        echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                                    }elseif($floorDetails['repayment_opt'] == -5){
                                                                        echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_reason']) && $floorDetails['repayment_reason'] != ""){
                                                                    if($floorDetails['repayment_reason'] == 1){
                                                                        echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                                    }elseif($floorDetails['repayment_reason'] == 2){
                                                                        echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_amt']) && $floorDetails['repayment_amt'] != ""){
                                                                    echo $floorDetails['repayment_amt'];
                                                                }
                                                                
                                                                if(isset($floorDetails['repayment_amt_opt']) && $floorDetails['repayment_amt_opt'] != ""){
                                                                    if($floorDetails['repayment_amt_opt'] == 1){
                                                                        echo Yii::app()->controller->__trans('ヶ月'); 
                                                                    }elseif($floorDetails['repayment_amt_opt'] == 2){
                                                                        echo Yii::app()->controller->__trans('%')."<br>"; 
                                                                    }else{
                                                                        echo '';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="period">
                                                            <?php
                                                                if(isset($floorDetails['contract_period_duration']) && $floorDetails['contract_period_duration'] != ""){
                                                                    echo $floorDetails['contract_period_duration'];
                                                                    echo $floorDetails['contract_period_duration'] > 1 && $floorDetails['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="sc">
                                                            <?php
                                                                if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != "0"){
                                                                    echo $floorDetails['move_in_date'];
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="update">
                                                            <?php
                                                                if(isset($floorDetails['modified_on']) && $floorDetails['modified_on'] != ""){
                                                                    if($floorDetails['modified_on'] != "0000-00-00 00:00:00"){
                                                                        echo date('Y.m.d',strtotime($floorDetails['modified_on']));
                                                                    }else{
                                                                        echo date('Y.m.d',strtotime($floorDetails['added_on']));
                                                                    }
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    //}
                                                }
                                            }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                              <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php /*?><div class="bt_input_box">
                            <div class="bt_input">
                                <input type="button"  class="bt_entry clone-floor-settings" value="<?php echo Yii::app()->controller->__trans('フロア情報を更新');?>">
                            </div>
                        </div><?php */?>
                        
                        <div class="formbox f-full">
                         	<div class="table-inner">
                            	<?php
									$manageDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' AND is_shared = 1 order by ownership_management_id DESC');
									$oArray = array();
									$vArray = array();
									foreach($manageDetails as $mDetails){
										//$oArray[] = array('id'=>$mDetails['ownership_management_id'],'name'=>$mDetails['owner_company_name']);
										$oArray[$mDetails['ownership_management_id']] = $mDetails['owner_company_name'];
										$traderDetails = Traders::model()->findByPk($mDetails['trader_id']);
										$vArray[$mDetails['trader_id']] = $traderDetails->trader_name;
									}
									//$oArray = array_unique($oArray);
									$vArray = array_unique($vArray);
									
									$aVendorType = Yii::app()->controller->getBuildingVendorType();
								?>
                                <form class="frmBulkDelete" id="frmBulkDelete" class="frmBulkDelete" action="<?php echo Yii::app()->createUrl('floor/bulkDelete'); ?>" method="post">                                	
                                    <table class="edit_input f_info mt tb-floor one-col mix-col">
                                        <?php
										//$aVendorType
										foreach($aVendorType as $aKey=>$aVal){
											$checkAvailType = OwnershipManagement::model()->findAll('building_id = '.$buildingId.' AND ownership_type = "'.$aKey.'" AND is_shared = 1');
											if(count($checkAvailType) == 0){
												continue;
											}
										?>
                                        <tr>
                                            <td><?php echo $aVal;?></td>
                                            <td>
                                            	<?php
												foreach($oArray as $k=>$v){
													$getOwner = OwnershipManagement::model()->findByPk($k);
													if($getOwner->ownership_type == $aKey){	
												?>
                                                		<input type="checkbox" name="checkOwner[]" id="checkOwner" class="checkOwner" value="<?php echo $k; ?>" /> <?php echo $getOwner->owner_company_name; ?>
                                                <?php
													}
												}
												?>                                                    
                                            </td>
                                        </tr>
                                        <?php
										}
										?>
                                        <tr>
                                            <td><?php echo Yii::app()->controller->__trans('trader');?></td>
                                            <td>
                                                <?php
                                                    foreach($vArray as $key=>$val){
                                                ?>
                                                    <input type="checkbox" name="checkVendor[]" id="checkVendor" class="checkVendor" value="<?php echo $key; ?>" /> <?php echo $val; ?>
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align:center">
                                                <button type="button" name="btnBulkDelete" id="btnBulkDelete" class="btnBulkDelete" style="width:200px;"><?php echo Yii::app()->controller->__trans('Bulk Delete');?></button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
               	</div>
            </div>
       	</div>
    </div>
</div>
<script>
<?php if(isset($_GET['msg']) && $_GET['msg'] == 1){ ?>
//window.opener.location.reload(false);
window.opener.location.href = "<?php echo Yii::app()->createUrl('building/singleBuilding&id=').$_GET['id'];?>"; 
<?php } ?>
</script>
<input type="hidden" name="hdnOwnersResp" id="hdnOwnersResp" class="hdnOwnersResp" value="<?php echo Yii::app()->createUrl('building/singleBuilding&id=').$_GET['id'];?>"/>
