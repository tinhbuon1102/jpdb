<?php 
$aVendorType = Yii::app()->controller->getBuildingVendorType();
$isCompart = '';
$isShared = '';
$globalBuildingId = $buildingDetails['building_id'];
$globalFloorId = $floorDetails['floor_id'];

/********** get google map api key **********/
$criteria=new CDbCriteria;
$criteria->order='google_map_api_key_id DESC';

$getGoogleMapKeyDetails = GoogleMapApiKey::model()->find($criteria);
$gApiKey = '';
if(count($getGoogleMapKeyDetails) > 0){
	$gApiKey = $getGoogleMapKeyDetails['api_key'];
}
/***************** end ****************/
?>
<input type="hidden" name="hdnBid" class="hdnBid" value="<?php echo $globalBuildingId; ?>"/>
<input type="hidden" name="hdnFid" class="hdnFid" value="<?php echo $globalFloorId; ?>"/>
<style>
#myChart{ display: block;width: 494px;height: 250px !important;position: relative; }
.left-col .graph { margin-bottom: 307px !important; }
</style>
<div id="main" class="full-width">
	<div class="postbox">
    	<div id="post-31" class="post-31 post type-post status-publish format-standard has-post-thumbnail hentry category-search-result">
        <header class="m-title btnright clearfix">
        	<h1 class="main-title">
            	<span>
					<?php echo isset($buildingDetails['name']) ? $buildingDetails['name'] : ''; ?>
                    <?php 
                    //echo $buildingDetails['bill_check'] != 1 ? 'ビル' : ''; ?>
                </span>
                <span class="pad-lef05">
                <?php
                    if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
                        if(strpos($floorDetails['floor_down'], '-') !== false){
                            $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
                        }else{
                            $floorDown = $floorDetails['floor_down'];
                        }									
                        if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
                            echo $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
                        }else{
                            echo $floorDown.' '.Yii::app()->controller->__trans('階');
                        }
                    }
                    if(isset($floorDetails['roomname']) && $floorDetails['roomname'] != ""){
                        echo '&nbsp;'.$floorDetails['roomname'];
                    }
                ?>
                </span>
                 <span class="pad-lef05">
                    <?php echo isset($floorDetails['core_section']) && $floorDetails['core_section'] == 1 ? Yii::app()->controller->__trans('Core') : ""; ?>
                </span>
                <span class="pad-lef05">
                    <?php echo isset($floorDetails['area_ping']) && $floorDetails['area_ping'] != "" ? $floorDetails['area_ping'].Yii::app()->controller->__trans('tsubo') : ""; ?>
                </span>
                <span class="pad-lef05">
                    <?php echo isset($floorDetails['area_net']) && $floorDetails['area_net'] != "" ? 'ネット:'.$floorDetails['area_net'].Yii::app()->controller->__trans('坪') : ""; ?>
                </span>
                <?php
                    $managementCompartOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$globalFloorId.' AND is_compart = 1 ORDER BY ownership_management_id DESC LIMIT 1');
                    if(count($managementCompartOwnerDetails) > 0){
                        $isCompart = '区分所有フロア';
                ?><br/>
                <span class="labelCompartInSingle">区分所有フロア</span>
                <?
                    }
                ?>
                <?php
                    $managementSharedOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$globalFloorId.' AND is_shared = 1 ORDER BY ownership_management_id DESC LIMIT 1');
                    if(count($managementSharedOwnerDetails) > 0){
                        $isShared = '共用オーナーフロア';
                ?><br/>
                <span class="labelSharedInSingle">共用オーナーフロア</span>
                <?
                    }
                ?>
                <div class="bulk" style="float: right;">  					
            	<a href="<?php echo Yii::app()->createUrl('floor/viewFloorMass',array('id'=>$buildingDetails['building_id'], 'update_management'=>0)); ?>" 
                	onclick="window.open('<?php echo Yii::app()->createUrl('floor/viewFloorMass',array('id'=>$buildingDetails['building_id'])); ?>', 'newwindow', 'height=' + (screen.height-120) + ',width=' + screen.width); return false;">
                	<button type="button" class="btn btn-primary"><?php echo Yii::app()->controller->__trans('BULK UPDATE'); ?></button>
                </a>
            	</div>
            </h1>

            <div class="add-action">
            	<input type="hidden" name="hdbPrintBuildId" id="hdbPrintBuildId" class="hdbPrintBuildId" value="<?php echo $globalBuildingId; ?>"/>
                <input type="hidden" name="hdbPrintFloorId" id="hdbPrintFloorId" class="hdbPrintFloorId" value="<?php echo $globalFloorId; ?>"/>
                <div class="divDisplayBillFloor">
				<?php
					echo Yii::app()->controller->__trans('Bill ID').':'.$buildingDetails['buildingId']."<br/>".Yii::app()->controller->__trans('Floor ID').':'.$floorDetails['floorId'];
				?>
                </div>
                <div class="divPrintSingleFloor">
                	<a href="#" class="btnSinglePrint" id="btnSinglePrint"><?php echo Yii::app()->controller->__trans('PRINT ARTICLE');?></a>
                </div>
            </div>
        </header>
        <ul class="tabs">
        	<li class="active" title="1"><a href="#tab1"><?php echo Yii::app()->controller->__trans('Property Overview'); ?></a></li>
            <li title="2" class=""><a href="#tab2"><?php echo Yii::app()->controller->__trans('Management Info'); ?></a></li>
            <li title="3" class=""><a href="#tab3"><?php echo Yii::app()->controller->__trans('Active History'); ?></a></li>
            <li title="4" class=""><a href="#tab4"><?php echo Yii::app()->controller->__trans('Plan・Pictures'); ?></a></li>
            <li title="5" class=""><a href="#tab5"><?php echo Yii::app()->controller->__trans('Street View'); ?></a></li>
            <li title="6" class=""><a href="#tab6"><?php echo Yii::app()->controller->__trans('Time Line'); ?></a></li>
            <li title="7" class=""><a href="#tab7"><?php echo Yii::app()->controller->__trans('PDF'); ?></a></li>
            <li title="8" class=""><a href="#tab8"><?php echo Yii::app()->controller->__trans('Floor'); ?></a></li>
       	</ul>
        <div class="clear"></div>
        <div class="tabs_content">
        	<div class="tab_con" id="tab1" style="display: block;">
            	<ul class="list-img">
				<?php
                	$buildingPictureDetails = BuildingPictures::model()->find('building_id = '.$globalBuildingId);
					$images = explode(',',$buildingPictureDetails['front_images']);
					$images_path = Yii::app()->baseUrl . '/buildingPictures/front';
					if(isset($buildingPictureDetails) && count($buildingPictureDetails)){
						$i = 0;
						$main_img = $buildingPictureDetails['main_image'];
						if($main_img != ''){
						?>
                        <li>
                        	<a href="<?php echo $images_path.'/'.$main_img;?>" data-lightbox="mainimage"><img alt="" class="img-zoom" src="<?php echo $images_path.'/'.$main_img; ?>"></a>
                        </li>
						<?php
						$i = 1;
						}
						if($images != ""){
							foreach($images as $img){
								if($main_img == $img){
									continue;
								}
								if($i > 3){
									break;
								}
						?>
                        <li>
                        	<a href="<?php echo $images_path.'/'.$img;?>" data-lightbox="<?=$i?>"><img alt="" class="img-zoom" src="<?php echo $images_path.'/'.$img; ?>"></a>
                        </li>
						<?php
                        	$i++;
							}
						}
					}else{
				?>
                		<li>
                        	<img alt="" src="<?php echo Yii::app()->baseUrl . '/images/default.png'; ?>">
                       	</li>
				<?php
                	}
				?>
                <?php
				$currentFloorPlanDetails = PlanPicture::model()->findByPk($floorDetails['plan_picture_id']);
				if(isset($currentFloorPlanDetails) && count($currentFloorPlanDetails) > 0){
					$currentPlan = $currentFloorPlanDetails['name'];
				?>
                	<li>
                		<a href="<?php echo Yii::app()->baseUrl.'/planPictures/'.$currentPlan;;?>" data-lightbox="planpicture"><img alt="" src="<?php echo Yii::app()->baseUrl.'/planPictures/'.$currentPlan; ?>"></a>
                    </li>				
				<?php 
				}else{
					$currentFloorPlanDetails = PlanPicture::model()->findByPk($buildingDetails['plan_standard_id']);
					if(isset($currentFloorPlanDetails) && count($currentFloorPlanDetails) > 0){
						$currentPlan = $currentFloorPlanDetails['name'];
					} else {
						$currentPlan = 'no_plan.jpg';
					}
				?>
                	<li>
                		<a href="<?php echo Yii::app()->baseUrl.'/planPictures/'.$currentPlan;;?>" data-lightbox="planpicture"><img alt="" src="<?php echo Yii::app()->baseUrl.'/planPictures/'.$currentPlan; ?>"></a>
                		<!--  <img alt="" src="<?php echo Yii::app()->baseUrl.'/planPictures/'.$currentPlan; ?>">-->
                    </li>				
				<?php }	?>

                </ul>
                <div class="floor-basic-info table-box">
                	<div class="ttl_h3 clearfix">
                    	<h3><?php echo Yii::app()->controller->__trans('Floor Info'); ?></h3>
                        <div class="bt_list">
                        	<a class="detail_local_tab updateHistoryLink" id="timeline"><?php echo Yii::app()->controller->__trans('Update History'); ?></a>
                        </div>
                        <div class="r_date">
							<?php echo Yii::app()->controller->__trans('Last Update'); ?>：<?php echo date('Y-m-d',strtotime($floorDetails['modified_on'])) != '0000-00-00' ? date('Y-m-d',strtotime($floorDetails['modified_on'])) : '-'; ?>
                        </div>
                    </div>
                    <table class="room-info col_1">
                    	<thead>
                        	<tr>
                            	<th class="th01"><?php echo Yii::app()->controller->__trans('vacancy info'); ?></th>
                                <th class="th02"><?php echo Yii::app()->controller->__trans('number of stairs'); ?></th>
                                <th class="th03"><?php echo Yii::app()->controller->__trans('area'); ?></th>
                                <th class="th04"><?php echo Yii::app()->controller->__trans('type of use'); ?></th>
                                <th class="th05"><?php echo "算出基準"; ?></th>
                                <th class="th05"><?php echo Yii::app()->controller->__trans('rent'); ?></th>
                                <th class="th06"><?php echo Yii::app()->controller->__trans('condo fees'); ?></th>
                                <th class="th07"><?php echo Yii::app()->controller->__trans('deposit'); ?></th>
                                <th class="th08"><?php echo Yii::app()->controller->__trans('key money'); ?></th>
                                <th class="th09"><?php echo Yii::app()->controller->__trans('contract period'); ?></th>
                                <th class="th010"><?php echo Yii::app()->controller->__trans('move in date'); ?></th>
                           	</tr>
                        </thead>
                        <tbody>
                        	<tr>
                            	<td>
									<?php
                                    if(isset($floorDetails['vacancy_info']) && $floorDetails['vacancy_info'] != ""){
                                        if($floorDetails['vacancy_info'] == 1){
                                            echo "<span style='color:blue'>".Yii::app()->controller->__trans('空室')."</span>";
                                            if($floorDetails['preceding_user'] == 1){
                                                echo '</br><span class="senko" style="background-color:yellow">'.Yii::app()->controller->__trans('先行申込有り').'</span>';
                                            }
                                        }elseif($floorDetails['vacancy_info'] == 0){
                                            echo "<span style='color:red'>".Yii::app()->controller->__trans('満室')."</span>";
                                            if($floorDetails['preceding_user'] == 1){
                                                echo '</br><span class="senko" style="background-color:yellow">'.Yii::app()->controller->__trans('先行申込有り').'</span>';
                                            }
                                        }else{
                                            echo '-';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
									<?php
                                    if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
                                        if(strpos($floorDetails['floor_down'], '-') !== false){
                                            $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
                                        }else{
                                            $floorDown = $floorDetails['floor_down'];
                                        }
                                        if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
                                            echo $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
                                        }else{
                                            echo $floorDown.' '.Yii::app()->controller->__trans('階');
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
									<?php
                                    if(isset($floorDetails['area_ping']) && $floorDetails['area_ping'] != ""){
                                        echo $floorDetails['area_ping'].Yii::app()->controller->__trans('Ping');
                                    }else{
                                        echo '-';
                                    }echo "<br/>";
                                    ?>
                                    <?php
                                    if(isset($floorDetails['floor_partition']) && $floorDetails['floor_partition'] != ""){
										$expFloorParts = explode(',',$floorDetails['floor_partition']);
										if(!empty($expFloorParts)){
											echo '分割可: ';
											foreach($expFloorParts as &$part){
												$part .= '坪';
											}
											echo implode(', ', $expFloorParts);
										}
									}
                                    ?>
									<?php
                                    if(isset($floorDetails['area_m']) && $floorDetails['area_m'] != ""){
                                        echo $floorDetails['area_m'].Yii::app()->controller->__trans('square meters');
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                    <br>
									<?php
                                    if(isset($floorDetails['area_net']) && $floorDetails['area_net'] != ""){
                                        echo "ネット: ".$floorDetails['area_net']."坪";
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
									<?php
                                        $typeOfUse = $floorDetails['type_of_use'];
                                        $userTypesList = UseTypes::model()->findAllByAttributes(array('user_type_id' => explode(',',$typeOfUse)));						
                                        $i = 0;
                                        foreach($userTypesList as $useList){
                                            if($i == count($userTypesList)-1){
                                                $comma = '';
                                            }else{
                                                $comma = ',';
                                            }
                                            echo Yii::app()->controller->__trans($useList['user_type_name']).$comma;
                                            $i++;
                                        }
                                    ?>
                                </td>
                                <td>
									<?php
									if(isset($floorDetails['calculation_method'])):
									$crit = array('不明','ネット','グロス');
									echo $crit[$floorDetails['calculation_method']];
									endif;
									?>
								</td>
								<td>
									<?php
                                        if(isset($floorDetails['total_rent_price']) && $floorDetails['total_rent_price'] != ""){
                                            echo Yii::app()->controller->renderPrice($floorDetails['total_rent_price']).'円';
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
                                    ?><br>
                                    <?php
                                        if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != "" && $floorDetails['rent_unit_price'] != 0){
                                            echo '('.Yii::app()->controller->renderPrice($floorDetails['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').')';
                                        }else{
                                            echo '';
                                        }
										
										$RNHistory = RentNegotiation::model()->find('allocate_floor_id = :afId and negotiation_type = :ngt',array(':afId'=>$floorDetails['floor_id'],':ngt'=>1));
										if($RNHistory){
											echo "<br /><span class='option_1'> 底値: ".$RNHistory['negotiation']." 円</span>";
										}
										$RNHistory2 = RentNegotiation::model()->find('allocate_floor_id = :afId and negotiation_type = :ngt',array(':afId'=>$floorDetails['floor_id'],':ngt'=>5));
										if($RNHistory2){
											echo "<br /><span class='option_2'> 目安値: ".$RNHistory2['negotiation']." 円 </span>";
										}
                                    ?>
                                </td>
                                <td>
									<?php
									if(isset($floorDetails['total_condo_fee']) && $floorDetails['total_condo_fee'] != ""){
										echo ''.Yii::app()->controller->renderPrice($floorDetails['total_condo_fee']).Yii::app()->controller->__trans('yen').'';
									}else{
										if($floorDetails['unit_condo_fee_opt'] != ''){
											if($floorDetails['unit_condo_fee_opt'] == 0){
												echo Yii::app()->controller->__trans('none');
											}else if($floorDetails['unit_condo_fee_opt'] == -1){
												echo Yii::app()->controller->__trans('undecided');
											}else if($floorDetails['unit_condo_fee_opt'] == -2){
												echo Yii::app()->controller->__trans('ask');
											}else if($floorDetails['unit_condo_fee_opt'] == -3){
												echo '賃料に込み<br/>(含む)';
											}
										}else{
											echo '-';
										}
									}
                                    ?><br>
                                    <?php
									if(isset($floorDetails['unit_condo_fee']) && $floorDetails['unit_condo_fee'] != ""){
										echo '('.Yii::app()->controller->renderPrice($floorDetails['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').')';
									}else{
										echo '';
									}
									?>
                                </td>
                                <td class="total_deposit">
									<?php
//									if($floorDetails['rent_unit_price_opt'] != -1 && $floorDetails['rent_unit_price_opt'] != -2){
										if(isset($floorDetails['total_deposit']) && $floorDetails['total_deposit'] != "0" && $floorDetails['total_deposit'] != ""){
											echo Yii::app()->controller->renderPrice($floorDetails['total_deposit']).' 円'.'<br/>';
										}
										if($floorDetails['deposit_opt'] != ''){
											if($floorDetails['deposit_opt'] == -1){
												echo Yii::app()->controller->__trans('undecided').'<br/>';
											}else if($floorDetails['deposit_opt'] == -3){
												echo Yii::app()->controller->__trans('none').'<br/>';
											}else if($floorDetails['deposit_opt'] == -2){
												echo Yii::app()->controller->__trans('undecided･ask').'<br/>';
											}
										}
										if(isset($floorDetails['deposit_month']) &&  $floorDetails['deposit_month'] != ''){
											echo '('.number_format($floorDetails['deposit_month']).')'.'<br/>';
										}
										
										if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != ""){
											//echo '('.number_format($floorDetails['deposit']).Yii::app()->controller->__trans('yen / tsubo').')';
										}
																				
// 									}else{
// 										if(isset($floorDetails['deposit_month']) &&  $floorDetails['deposit_month'] != ''){
// 											echo $floorDetails['deposit_month'].' ヶ月';
// 										}else{
// 											echo '¥0';
// 										}
// 									}
                                    ?>
                                </td>
                                <td>
									<?php
                                    if(isset($floorDetails['key_money_opt']) && $floorDetails['key_money_opt'] != ""){
                                        //echo "<pre>"; print_r($floorDetails);
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
                                <td>
									<?php
                                    if(isset($floorDetails['contract_period_duration']) && $floorDetails['contract_period_duration'] != ""){
                                        echo $floorDetails['contract_period_duration'].' '.Yii::app()->controller->__trans('year');
                                    }else if(isset($floorDetails['contract_period_optchk']) && $floorDetails['contract_period_optchk'] != 0){
                                        echo '年数相談';
                                    }else{									
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
									<?php
                                    if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != '0'){
                                        echo $floorDetails['move_in_date'];
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="room-info col_2">
                    	<thead>
                        	<tr>
                            	<th class="th01"><?php echo Yii::app()->controller->__trans('type of contract'); ?></th>
                                <th class="th02"><?php echo Yii::app()->controller->__trans('renewal fee'); ?></th>
                                <th class="th03"><?php echo Yii::app()->controller->__trans('repayment'); ?></th>
                                <th class="th04"><?php echo Yii::app()->controller->__trans('notice of cancellation'); ?></th>
                                <th class="th05"><font><font><?php echo Yii::app()->controller->__trans('OA'); ?></font></font></th>
                                <?php /*?><th><?php echo Yii::app()->controller->__trans('optical cable'); ?></th><?php */?>
                                <th class="th06"><?php echo Yii::app()->controller->__trans('floor material'); ?></th>
                                <th class="th07">電気容量</th>
                                <th class="th08"><?php echo Yii::app()->controller->__trans('air conditioning'); ?></th>
                                <th class="th09" colspan="2"><?php echo Yii::app()->controller->__trans('time to use air conditioning'); ?></th>
                           	</tr>
                        </thead>
                        <tbody>
                        	<tr>
                            	<td>
									<?php
                                    if(isset($floorDetails['contract_period_opt']) && $floorDetails['contract_period_opt'] != ""){
                                        if($floorDetails['contract_period_opt'] == 1){
                                            echo '普通借家';
                                        }elseif($floorDetails['contract_period_opt'] == 2){
                                            echo '定借';
                                        }elseif($floorDetails['contract_period_opt'] == 3){
                                            echo '定借希望';
                                        }else{
                                            echo '-';
                                        }
                                    }else{
                                        echo '-';
                                    }							
                                    ?>
                                </td>
                                <td>
									<?php
                                    if(isset($floorDetails['renewal_fee_opt']) && $floorDetails['renewal_fee_opt'] != ""){
                                        if($floorDetails['renewal_fee_opt'] == 2){
                                            echo Yii::app()->controller->__trans('None'); 
                                        }elseif($floorDetails['renewal_fee_opt'] == -1){
                                            echo Yii::app()->controller->__trans('Unknown'); 
                                        }elseif($floorDetails['renewal_fee_opt'] == -2){
                                            echo Yii::app()->controller->__trans('Undecided･ask'); 
                                        }else{
                                            echo '';
                                        }
                                    }
                                    
                                    if(isset($floorDetails['renewal_fee_reason']) && $floorDetails['renewal_fee_reason'] != ""){
                                        if($floorDetails['renewal_fee_reason'] == 1){
                                            echo Yii::app()->controller->__trans('現賃料の'); 
                                        }elseif($floorDetails['renewal_fee_reason'] == 2){
                                            echo Yii::app()->controller->__trans('新賃料の'); 
                                        }else{
                                            echo '';
                                        }
                                    }
                                    
                                    if(isset($floorDetails['renewal_fee_recent']) && $floorDetails['renewal_fee_recent'] != ""){
                                        echo $floorDetails['renewal_fee_recent'].Yii::app()->controller->__trans('month');
                                    }
                                    ?>
                                </td>
                                <td>
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
                                            echo Yii::app()->controller->__trans('現賃料の'); 
                                        }elseif($floorDetails['repayment_reason'] == 2){
                                            echo Yii::app()->controller->__trans('解約時賃料の'); 
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
                                <td>
									<?php
                                    if(isset($floorDetails['notice_of_cancellation']) && $floorDetails['notice_of_cancellation'] != ""){
                                        echo $floorDetails['notice_of_cancellation'].' '.Yii::app()->controller->__trans('month');
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
									<?php
                                    if(isset($floorDetails['oa_type']) && $floorDetails['oa_type'] != ""){
                                        echo $floorDetails['oa_type'].'<br/>';
                                    }else{
                                        echo '';
                                    }
                                    
                                    if(isset($floorDetails['oa_height']) && $floorDetails['oa_height'] != ""){
                                        echo $floorDetails['oa_height'].' '.Yii::app()->controller->__trans('mm');
                                    }else{
                                        echo '';
                                    }
                                    ?>
                                </td>
                                <?php /*?><td>
                                    <?php
									if(isset($floorDetails['optical_cable']) && $floorDetails['optical_cable'] != ""){
										if($floorDetails['optical_cable'] == 0){
											echo Yii::app()->controller->__trans('Unknown');
										}elseif($floorDetails['optical_cable'] == 1){
											echo Yii::app()->controller->__trans('Unsupported');
										}elseif($floorDetails['optical_cable'] == 2){
											echo Yii::app()->controller->__trans('Supported');
										}else{
										}
									}else{
										echo '-';
									}
                                    ?>
                                </td><?php */?>
                                <td>
									<?php
                                    if(isset($floorDetails['floor_material']) && $floorDetails['floor_material'] != ""){
                                        echo Yii::app()->controller->__trans($floorDetails['floor_material']);
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
									<?php
                                    if(isset($floorDetails['electric_capacity']) && $floorDetails['electric_capacity'] != ""){
                                        echo $floorDetails['electric_capacity'].'VA/m²';
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
									<?php
                                    if(isset($floorDetails['air_conditioning_facility_type']) && $floorDetails['air_conditioning_facility_type'] != ""){
                                        echo Yii::app()->controller->__trans($floorDetails['air_conditioning_facility_type']);
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td colspan="2">
									<?php
                                    if(isset($floorDetails['air_conditioning_time_used']) && $floorDetails['air_conditioning_time_used'] != ""){
                                        $explodeString = explode('-',$floorDetails['air_conditioning_time_used']);
                                        if($explodeString[0] != 2){
                                            if($explodeString[0] == 0){
                                                echo Yii::app()->controller->__trans('不明');
                                            }
                                            if($explodeString[0] == 1){
                                                echo Yii::app()->controller->__trans('利用時間制限なし（24時間）');
                                            }
                                        }else{
                                            echo Yii::app()->controller->__trans('weekday').'：- '.($explodeString[1] != "~" ? $explodeString[1] : "").'<br/>'.Yii::app()->controller->__trans('Sat').'：- '.($explodeString[2] != "~" ? $explodeString[2] : "").'<br/>'.Yii::app()->controller->__trans('Sun').'：- '.($explodeString[3] != "~" ? $explodeString[3] : "");
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="room-info col-3">
                    	<thead>
                        	<tr>
                        		<th><?php echo  '先行ユーザ' ?></th>
                                <th><?php echo '先行詳細' ?></th>
                                <th><?php echo '先行確認日' ?></th>
								<th><?php echo '空調詳細' ?></th>
								<th><?php echo '分割備考' ?></th>
                            	<th>男女別トイレ</th>
                                <?php /*?><th class="washlet"><?php echo Yii::app()->controller->__trans('Toilet Washlet'); ?></th>
								<th><?php echo Yii::app()->controller->__trans('Toilet Cleaning'); ?></th><?php */?>
                                <th>トイレ場所</th>
                                <th>天井高</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<tr>
                        		<td><?php if ($floorDetails['preceding_user'] !== "") echo $floorDetails['preceding_user'] === "0" ? '無し' : '有り'?></td>
                                <td><?php echo $floorDetails['preceding_details'] !== "" ? $floorDetails['preceding_details'] : ''?></td>
                                <td><?php echo $floorDetails['preceding_check_datetime'] !== "" ? trim($floorDetails['preceding_check_datetime']) : ''?></td>
                            	<td><?php echo $floorDetails['air_conditioning_details'] !== "" ? $floorDetails['air_conditioning_details'] : ''?></td>
								<td><?php echo $floorDetails['payment_by_installments_note'] !== "" ? $floorDetails['payment_by_installments_note'] : ''?></td>
								<td>
									<?php
                                    if(isset($floorDetails['separate_toilet_by_gender']) && $floorDetails['separate_toilet_by_gender'] != ""){
                                        if($floorDetails['separate_toilet_by_gender'] == 0){
                                            echo Yii::app()->controller->__trans('Unknown'); 
                                        }elseif($floorDetails['separate_toilet_by_gender'] == 1){
                                            echo Yii::app()->controller->__trans('無し'); 
                                        }elseif($floorDetails['separate_toilet_by_gender'] == 2){
                                            echo Yii::app()->controller->__trans('有り'); 
                                        }else{
                                            echo '-';
                                        }
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
									<?php
                                    if(isset($floorDetails['toilet_location']) && $floorDetails['toilet_location'] != ""){
                                        if($floorDetails['toilet_location'] == 0){
                                            echo '不明'; 
                                        }elseif($floorDetails['toilet_location'] == 1){
                                            echo 'フロア内'; 
                                        }elseif($floorDetails['toilet_location'] == 2){
                                            echo 'フロア外(共用)'; 
                                        }
                                    }
                                    ?>
                                </td>
                                <?php /*?><td>
                                    <?php
									if(isset($floorDetails['washlet']) && $floorDetails['washlet'] != ""){
										if($floorDetails['washlet'] == 1){
											echo Yii::app()->controller->__trans('None'); 
										}elseif($floorDetails['washlet'] == 2){
											echo Yii::app()->controller->__trans('Yes');
										}elseif($floorDetails['washlet'] == 0){
											echo Yii::app()->controller->__trans('Unknown');
										}else{
											echo '-';
										}
									}else{
										echo '-';
									}
                                    ?>
                                </td>
                                <td>
									<?php
									if(isset($floorDetails['toilet_cleaning']) && $floorDetails['toilet_cleaning'] != ""){
										if($floorDetails['toilet_cleaning'] == 1){
											echo 'ビル';
										}elseif($floorDetails['toilet_cleaning'] == 2){
											echo 'テナント';
										}elseif($floorDetails['toilet_cleaning'] == 0){
											echo Yii::app()->controller->__trans('Unknown');
										}else{
											echo '-';
										}
									}else{
										echo '-';
									}
                                    ?>
                                </td><?php */?>
                                <td><?php echo $floorDetails['ceiling_height'] ? $floorDetails['ceiling_height'] . ' mm' : '-'?></td>
                                <td colspan="3"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="floor-edit-btn">
                    	<a href="<?php echo Yii::app()->createUrl('floor/update',array('id'=>$globalFloorId)); ?>" onclick="window.open('<?php echo Yii::app()->createUrl('floor/update',array('id'=>$globalFloorId,'window'=>1)); ?>', 'newwindow', 'width=1052, height=600'); return false;">
                        	<button type="button" class="btnSingleEditFloor"><?php echo Yii::app()->controller->__trans('edit・update'); ?></button>
                        </a>
                    </div>
                    
                    <?php if ($floorDetails['show_frontend']) {?>
                    <div class="send-update-btn"><a href="javascript:void(0)" class="sendupdate-button"><?php echo Yii::app()->controller->__trans('Send Update'); ?></a></div>
                    <?php }?>
                </div><!--/table-box-->
                
                <div class="other-info-col table-box">
                	<div class="other-info col-3 clearfix">
                    	<div class="col cl-3">
                        	<dl class="fee-box">
                            	<dt><?php echo Yii::app()->controller->__trans('comission'); ?></dt>
                                <?php
									$finalComission = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' ORDER BY `ownership_management_id` DESC LIMIT 1');
								?>
                                <dd class="charge-fee">
									<?php
                                    if(isset($finalComission[0]['charge']) && $finalComission[0]['charge'] != ""){
                                        if (is_numeric($finalComission[0]['charge'])){
                                            $charge = '<span class="charge_a">△</span>'.number_format($finalComission[0]['charge'],1,'.','');
                                        }else{
											$charge = Yii::app()->controller->__trans(ucfirst($finalComission[0]['charge']));;
                                        }
                                    }else{
                                        $charge = '-';
                                    }
                                    ?>
                                    <?php echo $charge; ?>
                                </dd>
                                <dd class="updated-date">
                                	<?php
                                    	if(isset($finalComission[0]['modified_on']) && $finalComission[0]['modified_on'] != "0000-00-00"){
											echo date('Y.m.d',strtotime($finalComission[0]['modified_on']));
										}else{
											echo '-';
										}
									?>
                                </dd>
                            </dl>
                            <dl class="fee-box free">
                            	<dt><?php echo Yii::app()->controller->__trans('free rent'); ?></dt>
                                <dd class="charge-fee">
									<?php
                                        $rentDetails = FreeRent::model()->findAll('building_id = '.$buildingDetails['building_id'].' ORDER BY free_rent_id DESC LIMIT 1');
                                        if(isset($rentDetails) && count($rentDetails) > 0){
                                            $freeRent = $rentDetails[0]['free_rent_month'];
                                        }else{
                                            $freeRent = '-';
                                        }
                                    ?>
                                    <?php echo $freeRent; ?><?php echo Yii::app()->controller->__trans('Month'); ?>
                                </dd>
                                <dd>
									<?php
                                    	if(isset($rentDetails[0]['expiration_date']) && $rentDetails[0]['expiration_date'] != "0000-00-00"){
											echo date('Y.m.d',strtotime($rentDetails[0]['expiration_date']));
										}else{
											echo '-';
										}
									?>
                                </dd>
                                <dd class="update-btn"> 
                                <!--<span>
                                        <font><font>2016.1.13</font></font>
                                    </span>-->
                                    <input type="hidden" name="hdnRentBillId" id="hdnRentBillId" value="<?php echo $globalBuildingId; ?>"/>
                                    <button type="button" name="btnUpdateFreeRent" class="btnUpdateFreeRent"><?php echo Yii::app()->controller->__trans('Update'); ?></button>
                                </dd>
                            </dl>
                        </div>
                        <div class="col cl-7">
                        	<div class="bd_business">
                            	<dl class="archive_box cmc pull-left">
                                	<dt>伝達事項
                                    	<div class="bt_msg">
                                        	<input type="hidden" name="buildingIdForTrans" id="buildingIdForTrans" class="buildingIdForTrans" value="<?php echo $globalBuildingId; ?>" />
                                            <?php
											$transDetails = TransmissionMatters::model()->findAll(array("condition" => "building_id = '".$buildingDetails['building_id']."'","order" => "transmission_matters_id DESC"));
											?>
                                            <a href="#" class="btnAddMatters"><?php echo isset($transDetails) && count($transDetails) > 0 ? count($transDetails) : 0 ?>件</a>
                                        </div>
                                    </dt>
                                    <dd class="afterTransResp">
                                    	<table class="ah_msg">
                                        	<tbody>
												<?php
                                                if(isset($transDetails) && count($transDetails) > 0){
                                                    $i = 0;
                                                    foreach($transDetails as $list){ 
                                                        if($i == 4){														
                                                            break;
                                                        }
                                                ?>
                                                <tr>
                                                    <th scope="row">
                                                        <?php
                                                        $days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
                                                        $day = array_search((date('D',strtotime($list['added_on']))), $days);
                                                        echo date('Y.m.d',strtotime($list['added_on']));
                                                        ?>
                                                        (<?php echo $day; ?>)
                                                    </th>
                                                    <td>
                                                        <?php
                                                        //echo $list['note'];
                                                        echo (strlen($list['note']) > 28 ? mb_substr($list['note'], 0, 28,'UTF-8').' ...' : $list['note']); ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                    $i++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </dd>
                                </dl>
                                <dl class="archive_box">
                                	<dt>賃料交渉履歴
                                    	<div class="bt_msg">
											<?php
                                            $totalNegotiation = 0;
                                            $negotiationDetails = RentNegotiation::model()->findAll('building_id = '.$globalBuildingId.' order by rent_negotiation_id desc');
                                            $totalNegotiation = count($negotiationDetails);
                                            ?>
                                            <input type="hidden" name="hdnNegBilId" id="hdnNegBilId" value="<?php echo $globalBuildingId; ?>"/>
                                            <a href="#" class="btnShowRentNegotiation"><?php echo $totalNegotiation; ?>件</a>
                                        </div>
                                    </dt>
                                    <dd>
                                        <table class="ah_msg">
                                            <tbody>
                                            <?php
                                            //$days = array('month'=>'Mon','fire'=>'Tue','water'=>'Wed','wood'=>'Thu','gold'=>'Fri','soil'=>'Sat','day'=>'Sun');
                                            $days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
                                            if(isset($negotiationDetails) && count($negotiationDetails) > 0){
                                                $i = 0;
                                                foreach($negotiationDetails as $negotiation){
                                                    if($i == 4){
                                                        break;
                                                    }
                                                    $day = array_search((date('D',strtotime($negotiation['added_on']))), $days);
                                                    $allocateFloorDetails = Floor::model()->findAllByAttributes(array('floor_id'=>explode(',',$negotiation['allocate_floor_id'])));
                                                    if(isset($allocateFloorDetails) && count($allocateFloorDetails) > 0){
                                                        $floorName = '';
                                                        foreach($allocateFloorDetails as $floor){
                                                            if(strpos($floor['floor_down'], '-') !== false){
                                                                $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
                                                            }else{
                                                                $floorDown = $floorDetails['floor_down'];
                                                            }
                                                            $floorName .= $floorDown;
                                                            if($floor['floor_up'] != ""){
                                                                $floorName .= " ~ ".$floor['floor_up'];
                                                            }
                                                            $negUnitB = '';
                                                            $negUnit = '';
                                                            $negVal = '';
                                                            
                                                            if($negotiation['negotiation_type'] == 1){
                                                                $negUnit = '(共益費込み)';
                                                                $negUnitB = '¥';
                                                                $negVal = number_format($negotiation['negotiation']);
                                                            }elseif($negotiation['negotiation_type'] == 5){
                                                                $negUnit = '(共益費込み)';
                                                                $negUnitB = '¥';
                                                                $negVal = number_format($negotiation['negotiation']);
                                                            }elseif($negotiation['negotiation_type'] == 2 || $negotiation['negotiation_type'] == 3){
                                                                $negUnit = 'ヶ月';
                                                                $negVal = $negotiation['negotiation'];
                                                            }	
                                                            
                                                            $floorName .= " 階 / ".$floor['area_ping'].' '.Yii::app()->controller->__trans('tsubo').' | '.$negUnitB.' '.$negVal.' '.$negUnit.' '.$negotiation['negotiation_note'];
                                                        }	
                                                    }else{
                                                        $floorName = '';
                                                    }
                                            ?>
                                                <tr>
                                                    <th scope="row">
                                                        <?php echo date('Y.m.d',strtotime($negotiation['added_on'])); ?>
                                                        (<?php echo $day; ?>)
                                                    </th>
                                                    <td>
                                                        <?php
                                                        if($negotiation['negotiation_type'] == 1){
                                                            echo '坪単価(底値)';
                                                        }elseif($negotiation['negotiation_type'] == 2){
                                                            echo Yii::app()->controller->__trans('Deposit negotiation value');
                                                        }elseif($negotiation['negotiation_type'] == 3){
                                                            echo Yii::app()->controller->__trans('Key money negotiation value');
                                                        }elseif($negotiation['negotiation_type'] == 5){
                                                            echo '坪単価(目安値)';
                                                        }else{
                                                            echo Yii::app()->controller->__trans('Other negotiations information');
                                                        }
                                                        echo ' '.$floorName;
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
													$i++;
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div><!--/table-box-->
                
                <div class="manage-info table-box">
                	<div class="ttl_h3 clearfix">
                    	<h3><?php echo Yii::app()->controller->__trans('Manage Info'); ?></h3>
                        <div class="bt_list">
                        	<a class="detail_local_tab appentHistory" id="timeline" href="#" data-id="<?php echo $globalFloorId; ?>"><?php echo Yii::app()->controller->__trans('Add History'); ?></a>
                        </div>
                    </div>
                    <div class="manageInfoResponse">
                    	<h4 class="ontable"><?php echo Yii::app()->controller->__trans('Window・Owner'); ?><span class="button-right"><a id="add_new_owner" href="javascript:void(0)">Add</a></span></h4>
                        <table class="admin_info admin_mb ad_list">
                        	<tbody>
                                <tr>
                                    <th><?php echo Yii::app()->controller->__trans('種別'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('management company name'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('Person in charge'); ?></th>
                                    <th><font><font><?php echo Yii::app()->controller->__trans('TEL / FAX'); ?></font></font></th>
                                    <th><?php echo Yii::app()->controller->__trans('Form of Transaction'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('Comission'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('Updated date'); ?></th>
                                </tr>
                                <?php
									$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$globalBuildingId.'  AND `is_current` = 1 AND (`is_compart` = 1 OR `is_shared` = 1) GROUP BY ownership_management.ownership_type LIMIT 1';
									$managementDiffOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
									if(isset($managementDiffOwnerDetails) && count($managementDiffOwnerDetails) > 0){
										foreach($managementDiffOwnerDetails as $ownerList){
											if($ownerList['ownership_type'] == 1){
												$ownerClass = "ico_corptype_4";
												$ownerClass = "";
											}else{
												$ownerClass = "";
											}
								?>
                                <tr>
                                	<td class="vendor_class">
                                    	<span class="vendor_type">
											<?php
                                            if(isset($ownerList['ownership_type']) && $ownerList['ownership_type'] != ""){
                                                echo $aVendorType[$ownerList['ownership_type']];
                                            }else{
                                                echo '-';
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td class="<?php echo $ownerClass; ?>">
                                    	<?php if($ownerList['is_compart'] != 0){ ?>
                                        	<span class="owner-ship compart">区分所有</span>
                                        <?php }else if($ownerList['is_shared'] != 0){ ?>
                                        <span class="owner-ship shared">共用オーナー</span>
                                        <?php } ?>
                                    	<span class="window-label">窓口</span>
                                        <?php
										if(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != ""){
											echo $ownerList['owner_company_name'];
										}else{
											echo '-';
										}
                                        ?>
                                    </td>
                                    <td class="ad_name">
										<?php
                                        if(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != ""){
                                            echo $ownerList['person_in_charge1'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_contact">
										<?php
                                        if(isset($ownerList['company_tel']) && $ownerList['company_tel'] != ""){
                                            echo $ownerList['company_tel'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_type">
										<?php
                                        if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
                                            if($ownerList['management_type'] == -1){
                                             echo Yii::app()->controller->__trans('Unknown'); 
                                            }elseif($ownerList['management_type'] == 1){
                                                echo '専任媒介';
                                            }elseif($ownerList['management_type'] == 2){
                                                echo '一般媒介';
                                            }elseif($ownerList['management_type'] == 3){
                                                echo '代理';
                                            }elseif($ownerList['management_type'] == 4){
                                                echo '貸主';
                                            }elseif($ownerList['management_type'] == 6){
                                                echo '業者';
                                            }else{
                                                echo '-';
                                            }
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_charge">
										<?php
                                        if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
                                            if (is_numeric($ownerList['charge'])){
                                                echo number_format($ownerList['charge'],1,'.','');
                                            }else{
                                                echo $ownerList['charge'];
                                            }
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_update">
										<?php
                                        if(isset($ownerList['modified_on']) && $ownerList['modified_on'] != ""){
                                            echo date('Y.m.d',strtotime($ownerList['modified_on']));
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
			  					//$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$globalFloorId.' AND is_current = 1 ORDER BY ownership_management_id DESC');
								//$query = 'SELECT *,max(ownership_management_id) as id FROM ownership_management where `floor_id` = '.$floorDetails['building_id'].'  AND `is_current` = 1 GROUP by ownership_type ORDER by id DESC';
								$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$globalBuildingId.'  AND `is_current` = 1 AND `is_compart` = 0 AND is_shared = 0 GROUP BY ownership_management.ownership_type LIMIT 1';
								$managementOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
								//$managementOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' AND is_current = 1 GROUP BY ownership_type ORDER BY ownership_management_id DESC');
								if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
				  					foreach($managementOwnerDetails as $ownerList){
										if($ownerList['ownership_type'] == 1){
											$ownerClass = "ico_corptype_4";
											$ownerClass = "";
										}else{
											$ownerClass = "";
										}
			  					?>
                                <tr>
                                	<td class="vendor_class">
                                        <span class="vendor_type">
                                            <?php
											if(isset($ownerList['ownership_type']) && $ownerList['ownership_type'] != ""){
												echo $aVendorType[$ownerList['ownership_type']];
											}else{
												echo '-';
											}
                                            ?>
                                        </span>
                                    </td>
                                    <td class="<?php echo $ownerClass; ?>">
                                		<span class="window-label">窓口</span>
                                        <?php
										if(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != ""){
											echo $ownerList['owner_company_name'];
										}else{
											echo '-';
										}
                                        ?>
                                    </td>
                                    <td class="ad_name">
										<?php
                                        if(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != ""){
                                            echo $ownerList['person_in_charge1'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_contact">
										<?php
                                        if(isset($ownerList['company_tel']) && $ownerList['company_tel'] != ""){
                                            echo $ownerList['company_tel'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_type">                                    
										<?php
										if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
											if($ownerList['management_type'] == -1){
											 echo Yii::app()->controller->__trans('Unknown'); 
											}elseif($ownerList['management_type'] == 1){
												echo '専任媒介';
											}elseif($ownerList['management_type'] == 2){
												echo '一般媒介';
											}elseif($ownerList['management_type'] == 3){
												echo '代理';
											}elseif($ownerList['management_type'] == 4){
												echo '貸主';
											}else{
												echo '-';
											}
										}else{
											echo '-';
										}
                                        ?>
                                    </td>
                                    <td class="ad_charge">
										<?php
                                        if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
                                            if (is_numeric($ownerList['charge'])){
                                                echo number_format($ownerList['charge'],1,'.','');
                                            }else{
                                                echo $ownerList['charge'];
                                            }
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_update">
										<?php
                                        if(isset($ownerList['modified_on']) && $ownerList['modified_on'] != ""){
                                            echo date('Y.m.d',strtotime($ownerList['modified_on']));
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
                            </tbody>
                        </table>
                        <h4 class="ontable">
							<?php echo Yii::app()->controller->__trans('property management history（Latest）'); ?>
                        </h4>
                        <table class="admin_info admin_mb ad_list">
                        	<tbody>
								<?php
                                $managementOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' ORDER BY ownership_management_id DESC LIMIT 2');
                                //$managementOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' GROUP BY ownership_type ORDER BY ownership_management_id DESC limit 2');
                                if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
                                    foreach($managementOwnerDetails as $ownerList){
                                        if($ownerList['ownership_type'] == 1){
                                            $ownerClass = "ico_corptype_4";
                                            $ownerClass = "";
                                        }else{
                                            $ownerClass = "";
                                        }
                                ?>
                                <tr>
                                    <td class="vendor_class">
                                        <span class="vendor_type">
                                            <?php
                                            if(isset($ownerList['ownership_type']) && $ownerList['ownership_type'] != ""){
                                                echo $aVendorType[$ownerList['ownership_type']];
                                            }else{
                                                echo '-';
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td class="<?php echo $ownerClass; ?>">
                                        <?php if($ownerList['is_compart'] != 0){?>
                                                <span class="owner-ship compart">区分所有</span>
                                        <?php }else if($ownerList['is_shared'] != 0){ ?>
                                                <span class="owner-ship shared">共用オーナー</span>
                                        <?php } ?>
                                        <?php if($ownerList['is_current'] == 1){ ?>
                                            <span class="window-label">窓口</span>
                                        <?php } ?>
                                        <?php
                                        if(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != ""){
                                            echo $ownerList['owner_company_name'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_name">
                                        <?php
                                        if(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != ""){
                                            echo $ownerList['person_in_charge1'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_contact">
                                        <?php
                                        if(isset($ownerList['company_tel']) && $ownerList['company_tel'] != ""){
                                            echo $ownerList['company_tel'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_type">
                                        <?php
                                        if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
                                            if($ownerList['management_type'] == -1){
                                                echo Yii::app()->controller->__trans('Unknown'); 
                                            }elseif($ownerList['management_type'] == 1){
                                                echo '専任媒介';
                                            }elseif($ownerList['management_type'] == 2){
                                                echo '一般媒介';
                                            }elseif($ownerList['management_type'] == 3){
                                                echo '代理';
                                            }elseif($ownerList['management_type'] == 4){
                                                echo '貸主';
                                            }else{
                                                echo '-';
                                            }
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_charge">
                                        <?php
                                        if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
                                            if(is_numeric($ownerList['charge'])){
                                                echo number_format($ownerList['charge'],1,'.','');
                                            }else{
                                                echo $ownerList['charge'];
                                            }
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_update">
                                        <?php
                                        if(isset($ownerList['modified_on']) && $ownerList['modified_on'] != ""){
                                            echo date('Y.m.d',strtotime($ownerList['modified_on']));
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
                                $managementOwnerDetails = array();
                                //$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$globalFloorId.' AND is_condominium_ownership = 1 ORDER BY ownership_management_id DESC LIMIT 2');
                                //$managementOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' GROUP BY ownership_type ORDER BY ownership_management_id DESC limit 2');
                                if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
                                    foreach($managementOwnerDetails as $ownerList){
                                        if($ownerList['ownership_type'] == 1){
                                            $ownerClass = "ico_corptype_4";
                                            $ownerClass = "";
                                        }else{
                                            $ownerClass = "";
                                        }
                                ?>
                                <tr>
                                    <td class="vendor_class">
                                        <span class="vendor_type">
                                            <?php
                                            if(isset($ownerList['ownership_type']) && $ownerList['ownership_type'] != ""){
                                                echo $aVendorType[$ownerList['ownership_type']];
                                            }else{
                                                echo '-';
                                            }
                                            ?>
                                        </span>
                                        <span style="background-color:#555; color:white; padding:1px;">
                                            <?php if($ownerList['is_compart'] != 0){ ?>
                                                区分所有
                                            <?php }else if($ownerList['is_shared'] != 0){ ?>
                                                共用オーナー
                                            <?php } ?>
                                        </span>
                                    </td>
                                    <td class="<?php echo $ownerClass; ?>">
                                        <?php
                                        if(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != ""){
                                            echo $ownerList['owner_company_name'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_name">
                                        <?php
                                        if(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != ""){
                                            echo $ownerList['person_in_charge1'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_contact">
                                        <?php
                                        if(isset($ownerList['company_tel']) && $ownerList['company_tel'] != ""){
                                            echo $ownerList['company_tel'];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_type">
                                        <?php
                                        if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
                                            if($ownerList['management_type'] == -1){
                                                echo Yii::app()->controller->__trans('Unknown'); 
                                            }elseif($ownerList['management_type'] == 1){
                                                echo '専任媒介';
                                            }elseif($ownerList['management_type'] == 2){
                                                echo '一般媒介';
                                            }elseif($ownerList['management_type'] == 3){
                                                echo '代理';
                                            }elseif($ownerList['management_type'] == 4){
                                                echo '貸主';
                                            }else{
                                                echo '-';
                                            }
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_charge">
                                        <?php
                                        if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
                                            if(is_numeric($ownerList['charge'])){
                                                echo number_format($ownerList['charge'],1,'.','');
                                            }else{
                                                echo $ownerList['charge'];
                                            }
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="ad_update">
                                        <?php
                                        if(isset($ownerList['modified_on']) && $ownerList['modified_on'] != ""){
                                            echo date('Y.m.d',strtotime($ownerList['modified_on']));
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
                            </tbody>
                        </table>
                    </div>
                    <div class="see-more">
                    	<a href="#" class="seeMoreManagement"><i class="fa fa-chevron-right"></i><?php echo Yii::app()->controller->__trans('see more');  ?></a>
                    </div>
                </div><!--/table-box-->
                
                <div class="building-info table-box">
                	<div class="ttl_h3 clearfix">
                    	<h3><?php echo Yii::app()->controller->__trans('Building Info'); ?></h3>
                    </div>
                    <div class="bd_info_wrap clearfix buildingInformation">
                    	<div class="col-3">
                        	<table class="bd_info">
                            	<tbody>
                                	<tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('Address'); ?></th>
                                        <td><?php echo $buildingDetails['address']; ?></td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('construction'); ?></th>
                                        <td>
											<?php
//                                            $constructionTypeDetails = ConstructionType::model()->findByPk($buildingDetails['construction_type_id']);
//                                            $constructionType = $constructionTypeDetails->construction_type_name;
                                            ?>
                                            <?php echo $buildingDetails['construction_type_name']//echo $constructionType != "" ? $constructionType : ''; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('scale'); ?></th>
                                        <td>
											<?php
                                            $extractFloorScale = explode('-',$buildingDetails['floor_scale']);
                                            $floorUp = $extractFloorScale[0];
                                            $floorDown = $extractFloorScale[1];
                                            
                                            if($floorUp == "" && $floorDown == ""){
                                                echo '-';
                                            }else{
                                                if($floorUp != ""){
                                                    echo Yii::app()->controller->__trans('地上');
                                                    echo $floorUp;
                                                    echo Yii::app()->controller->__trans('階');
                                                }
                                                if($floorDown != ""){
                                                    echo Yii::app()->controller->__trans('地下');
                                                    echo $floorDown;
                                                    echo Yii::app()->controller->__trans('階');
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('Year and month Built in'); ?></th>
                                        <td>
											<?php
                                            if($buildingDetails['built_year'] != '' && $buildingDetails['built_year'] != '-'){
                                                $extractBuiltYear = explode('-',$buildingDetails['built_year']);
                                                $year = $extractBuiltYear[0];
                                                $month = date("m", mktime(0, 0, 0, ($extractBuiltYear[1])));
                                            ?>
                                            <?php echo $year.'年'.$month.'月'; ?>
                                            <?PHP }else{ echo '-';} ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('emergency power generating'); ?></th>
                                        <td>
											<?php
                                            $emrPowerGen = $buildingDetails['emr_power_gen'];
                                            if($emrPowerGen == 0){
                                                $emrPowerGenOpt = Yii::app()->controller->__trans('Unknown');
                                            }else if($emrPowerGen == 2){
                                                $emrPowerGenOpt = Yii::app()->controller->__trans('Correspondence');
                                            }else if($emrPowerGen == 1){
                                                $emrPowerGenOpt = Yii::app()->controller->__trans('Incompatible');
                                            }else{
                                                $emrPowerGenOpt = '-';
                                            }
                                            ?>
                                            <?php echo $emrPowerGenOpt; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row">
											<?php echo Yii::app()->controller->__trans('elevator'); ?><br>
                                        	<?php echo Yii::app()->controller->__trans('does not stop'); ?>
                                        </th>
                                        <td>
											<?php
                                            $elevatorNonStop = $buildingDetails['elevator_non_stop'];
                                            if($elevatorNonStop == 0){
                                                $elevatorNonStopOpt = Yii::app()->controller->__trans('Unknown');
                                            }else if($elevatorNonStop == 1){
                                                $elevatorNonStopOpt = Yii::app()->controller->__trans('Noexist');
                                            }else if($elevatorNonStop == 2){
                                                $elevatorNonStopOpt = Yii::app()->controller->__trans('Exist');
                                            }else{
                                                $elevatorNonStopOpt = '-';
                                            }
                                            ?>
                                            <?php echo $elevatorNonStopOpt; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('entrance open and close hours'); ?></th>
                                        <td>
											<?php
                                            $entOpclTime_exp = explode(',',$buildingDetails['ent_op_cl_time']);
                                            $weekTime = $satTime = $sunTime = '';
                                            $week = explode('-',$entOpclTime_exp[0]);
                                            if($week[0] == 2){
                                                $weekTime = $week[1];
                                            }elseif($week[0] == 1){
                                                $weekTime = '無';
                                            }elseif($week[0] == 3){
                                                $weekTime = '-';
                                            }
                                            $sat = explode('-',$entOpclTime_exp[1]);
                                            if($sat[0] == 2){
                                                $satTime = $sat[1];
                                            }elseif($sat[0] == 1){
                                                $satTime = '無';
                                            }elseif($sat[0] == 3){
                                                $satTime = '-';
                                            }
                                            $sun = explode('-',$entOpclTime_exp[2]);
                                            if($sun[0] == 2){
                                                $sunTime = $sun[1];
                                            }elseif($sun[0] == 1){
                                                $sunTime = '無';
                                            }elseif($sun[0] == 3){
                                                $sunTime = '-';
                                            }
                                            ?>
                                            <p>
                                            <?php echo Yii::app()->controller->__trans('weekday'); ?>：
                                            <?php echo $weekTime != "" ? $weekTime : '-'; ?>
                                            <?php echo Yii::app()->controller->__trans('Sat'); ?>：
                                            <?php echo $satTime != "" ? $satTime : '-'; ?>
                                            <?php echo Yii::app()->controller->__trans('Sun'); ?>：
                                            <?php echo $sunTime != "" ? $sunTime : '-'; ?>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table><!--table.bd_info--> 
                        </div>
                        <div class="col-3">
                        	<table class="bd_info">
                            	<tbody>
                                	<tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('total floor space'); ?></th>
                                        <td>
											<?php $totalFloorSpace = $buildingDetails['total_floor_space'];	?>
                                            <?php echo $totalFloorSpace != "" ? $totalFloorSpace." m<sup>2</sup>" : "-"; ?>
                                        </td>
                                   	</tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('average floor area'); ?></th>
                                        <td>
											<?php $stdFloorSpace = $buildingDetails['std_floor_space'];	?>
                                            <?php echo $stdFloorSpace != "" ? $stdFloorSpace." ".Yii::app()->controller->__trans('tsubo') : "-" ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo Yii::app()->controller->__trans('Total space'); ?></th>
                                        <td>
											<?php echo $buildingDetails['total_rent_space_unit'] ? $buildingDetails['total_rent_space_unit'] . ' ' . Yii::app()->controller->__trans('m&sup2;') : "-" ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('parking'); ?></th>
                                        <td>
											<?php
                                            $extractParkingUnitNo = explode('-',$buildingDetails['parking_unit_no']);
                                            if($extractParkingUnitNo[0] == 1){
                                                $parkingUnit = $extractParkingUnitNo[1].Yii::app()->controller->__trans('台');
                                            }else if($extractParkingUnitNo[0] == 2){
                                                $parkingUnit = Yii::app()->controller->__trans('noexist');
                                            }else if($extractParkingUnitNo[0] == 3){
                                                $parkingUnit = Yii::app()->controller->__trans('exist but unknown unit number');
                                            }else{
                                                $parkingUnit = '-';
                                            }
                                            ?>
                                            <?php echo $parkingUnit; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('time limit'); ?></th>
                                        <td>
                                            <?php
                                            $extractLimitOfUsageTime = explode(',',$buildingDetails['limit_of_usage_time']);
                                            $weekTime = $satTime = $sunTime = '';
                                            $week = explode('-',$extractLimitOfUsageTime[0]);
                                            if($week[0] == 2){
                                                $weekTime = $week[1];
                                            }elseif($week[0] == 1){
                                                $weekTime = '無';
                                            }elseif($week[0] == 3){
                                                $weekTime = '-';
                                            }
                                            $sat = explode('-',$extractLimitOfUsageTime[1]);
                                            if($sat[0] == 2){
                                                $satTime = $sat[1];
                                            }elseif($sat[0] == 1){
                                                $satTime = '無';
                                            }elseif($sat[0] == 3){
                                                $satTime = '-';
                                            }
                                            $sun = explode('-',$extractLimitOfUsageTime[2]);
                                            if($sun[0] == 2){
                                                $sunTime = $sun[1];
                                            }elseif($sun[0] == 1){
                                                $sunTime = '無';
                                            }elseif($sun[0] == 3){
                                                $sunTime = '-';
                                            }
                                            ?>
                                            <p>
                                            <?php echo Yii::app()->controller->__trans('weekday'); ?>：
                                            <?php echo $weekTime != "" ? $weekTime : '-'; ?>
                                            <?php echo Yii::app()->controller->__trans('Sat'); ?>：
                                            <?php echo $satTime != "" ? $satTime : '-'; ?>
                                            <?php echo Yii::app()->controller->__trans('Sun'); ?>：
                                            <?php echo $sunTime != "" ? $sunTime : '-'; ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo Yii::app()->controller->__trans('elevator'); ?></th>
                                        <td>
                                            <?php
                                            $extractElevator = explode('-',$buildingDetails['elevator']);
                                    
                                            if($extractElevator[0] == -2 || substr( $buildingDetails['elevator'], 0, 2 ) == '-2'){
                                                $elevator = Yii::app()->controller->__trans('unknown');
                                            }else if($extractElevator[0] == 1){
                                                $elevator = $extractElevator[1].Yii::app()->controller->__trans('base');
                                            }else if($extractElevator[0] == 2){
                                                $elevator = Yii::app()->controller->__trans('noexist');
                                            }else{
                                                $elevator = '-';
                                            }
                                            ?>
                                            <?php echo $elevator; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('caretaker in entrance'); ?></th>
                                        <td>
											<?php
                                            $entranceWithAttention = $buildingDetails['entrance_with_attention'];
                                            if($entranceWithAttention == 0){
                                                $attention = Yii::app()->controller->__trans('unknown');
                                            }else if($entranceWithAttention == 2){
                                                $attention =  Yii::app()->controller->__trans('exist');
                                            }else if($entranceWithAttention == 1){
                                                $attention =  Yii::app()->controller->__trans('noexist');
                                            }else{
                                                $attention = '-';
                                            }
                                            ?>
                                            <?php echo $attention; ?>
                                        </td>
                                    </tr>
                                   
                                </tbody>
                            </table><!--table.bd_info-->
                       	</div>
                        <div class="col-3">
                        	<table class="bd_info">
                            	<tbody>
                               	 <tr>
                                        <th scope="row"><?php echo Yii::app()->controller->__trans('Expected rent'); ?></th>
                                        <td>
											<?php
                                            $expExpRent = explode('-',$buildingDetails['exp_rent']);
                                            $expExpRendAmt = explode('~',$expExpRent[0]);
                                            $exp1 = $expExpRendAmt[0];
                                            $exp2 = $expExpRendAmt[1];
                                            if($exp1 == '' && $exp2 == ''){
                                                echo '-';									
                                            }else{
                                                if($expExpRendAmt[0] != '' && $expExpRendAmt[1] != ''){
                                                    echo $expExpRendAmt[0].'円~'.$expExpRendAmt[1].'円/坪';
                                                }else if($expExpRendAmt[0] != ''){
                                                    echo $expExpRendAmt[0].'円~/坪';	
                                                }else if($expExpRendAmt[1] != ''){
                                                    echo '~'.$expExpRendAmt[1].'円/坪';	
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                	<tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('wholesale lease'); ?></th>
                                        <td>
											<?php
                                            $wholesaleLease = $buildingDetails['wholesale_lease'];
                                            if($wholesaleLease == 0){
                                                $lease = '-';//Yii::app()->controller->__trans('不可');
                                            }else if($wholesaleLease == 2){
                                                $lease = Yii::app()->controller->__trans('Ask');
                                            }else if($wholesaleLease == 1){
                                                $lease = Yii::app()->controller->__trans('可能');;
                                            }else{
                                                $lease = '-';
                                            }
                                            ?>
                                            <?php echo $lease; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('guard'); ?></th>
                                        <td>
											<?php
                                            $securityDetails = Security::model()->findByPk($buildingDetails['security_id']);
                                            $security = $securityDetails['security_name'];
                                            ?>
                                            <?php echo $security != "" ? $security : '-'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<th scope="row"><?php echo Yii::app()->controller->__trans('earthquake resistant'); ?></th>
                                        <td>
											<?php
                                            $quakeResistanceStandardsDetails = QuakeResistanceStandards::model()->findByPk($buildingDetails['earth_quake_res_std']);
                                            $quakeResistance = $quakeResistanceStandardsDetails['quake_resistance_standard_name'];
                                            ?>
                                            <?php echo $quakeResistance != "" ? $quakeResistance : '-'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo Yii::app()->controller->__trans('Renewal Data'); ?></th>
                                        <td>
                                            <?php $renewalData =$buildingDetails['renewal_data']; ?>
                                            <?php echo $renewalData != "" ? $renewalData : '-'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <?php echo Yii::app()->controller->__trans('elevator'); ?><br>
                                            <?php echo Yii::app()->controller->__trans('hall'); ?>
                                        </th>
                                        <td>
                                            <?php
                                            $elevatorHall = $buildingDetails['elevator_hall'];
                                            if($elevatorHall == 0){
                                                $hall = Yii::app()->controller->__trans('unknown');
                                            }else if($elevatorHall == 2){
                                                $hall = Yii::app()->controller->__trans('Exist');
                                            }else if($elevatorHall == 1){
                                                $hall = Yii::app()->controller->__trans('Noexist');
                                            }else{
                                                $hall = '-';
                                            }
                                            ?>
                                            <?php echo $hall; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"> <?php echo Yii::app()->controller->__trans('entrance auto lock'); ?> </th>
                                        <td>
                                            <?php
                                            $entAutoLock = $buildingDetails['ent_auto_lock'];
                                            if($entAutoLock == 0){
                                                $autoLock =  Yii::app()->controller->__trans('unknown');
                                            }else if($entAutoLock == 2){
                                                $autoLock = Yii::app()->controller->__trans('Exist');
                                            }else if($entAutoLock == 1){
                                                $autoLock = Yii::app()->controller->__trans('Noexist');
                                            }else{
                                                $autoLock = '-';
                                            }
                                            ?>
                                            <?php echo $autoLock; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2" class="bt_bd_info">
                                        	<div class="bt_update">
                                        		<a href="<?php echo Yii::app()->createUrl('building/changeBuildingInfo',array('id'=>$globalBuildingId)); ?>" class="btnUpdateBuildingInfo"><?php echo Yii::app()->controller->__trans('edit・update'); ?></a>
                                            </div>
                                       	</td>
                                    </tr>
                               	</tbody>
                            </table><!--table.bd_info-->
                        </div>
                    </div>
                </div><!--/table-box-->
                <div class="map-info table-box">
                	<div class="ttl_h3 clearfix">
                    	<h3><?php echo Yii::app()->controller->__trans('MAP・ACCESS'); ?></h3>
                    </div>
                    <div class="location_box clearfix">
                    	<div class="map_box pull-left">
							<?php 
                            $buildingMapDetails = Building::model()->findByPk($globalBuildingId);
                            if(isset($buildingMapDetails) && count($buildingMapDetails) > 0){
                                $address = $buildingMapDetails['address'];
                                $lat = $buildingMapDetails['map_lat'];
                                $long = $buildingMapDetails['map_long'];
                            ?>
                            <?php 
							$result1 = array('name' => $buildingDetails['name'], 'address' => $address, 'description' =>  $buildingDetails['description_ja']);
							$results = array($result1);
							?>
							<script>
							var gmap;
							jQuery(document).ready(function(){
							    gmap = initMap();
								    /* You put your dynamic json data replace the one below */
								    json_data = <?php echo json_encode($results, JSON_UNESCAPED_UNICODE)?>;
								    gmap.startRender(json_data);
								});
						    
						    </script>
                            <div id="map" style="width: 100%; height: 450px;"></div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="access_box">
                        	<dl class="access">
								<?php
                                $allStations = BuildingStation::model()->findAll('building_id=' . $globalBuildingId);
                                $getStations = BuildingStation::model()->getNearestStations($globalBuildingId);
                                $nearestRoutes = array();
                                $nearestStations = array();
                                foreach($allStations as $station){
                                    $nearestRoutes[$station['line']] = $station['line'];
                                }
                                foreach($getStations as $station){
                                    $nearestStations[] = array('station'=>$station['name'],'time'=>$station['time']);
                                }
                                //$beforeUniqueRoutes = array_unique($nearestRoutes);
                                //$finalRoutes = array_values($beforeUniqueRoutes);
                                $finalRoutes = $nearestRoutes;
                                
                                //$beforeUniqueStations = array_unique($nearestStations);
                                //$finalStations =  array_values($beforeUniqueStations);
                                $finalStations = $nearestStations
                                ?>
                                <dt><?php echo Yii::app()->controller->__trans('Nearest Stations'); ?></dt>
                                <dd class="nearStationRoute">
                                	<ul class="station">
									<?php
                                    if(isset($finalStations) && count($finalStations) > 0){
                                        foreach($finalStations as $station){
                                            if($station['time'] <= 15){
                                    ?>
                                    	<li>
											<?php echo $station['station']; ?><?php echo Yii::app()->controller->__trans('駅'); ?>
                                            <span>
												<?php
                                                if($station['time'] != ""){
                                                    $statonReachTiming = $station['time'];
                                                ?>
                                                <?php echo '徒歩'.$statonReachTiming.' 分' ?>
                                                <?php
                                                }else{
                                                    echo Yii::app()->controller->__trans('Unknown Time');
                                                }
                                                ?>
                                            </span>
                                        </li>
                                  	<?php
											}
										}
									}
									?>
                                    </ul><!--ul.station-->
                                </dd>
                                <dt><?php echo Yii::app()->controller->__trans('Available Line'); ?></dt>
                                <dd class="nearStationRoute">
                                	<ul class="route clearfix">
                                    <?php
									$randomClass = array('route_102m','route_103m','route_107m','route_302m','route_409m','route_410m');
									if(isset($finalRoutes) && count($finalRoutes) > 0){
										foreach($finalRoutes as $route){
											$randNumber = mt_rand(0,5);
									?>
                                    	<li>
                                        	<span class="<?php echo $randomClass[$randNumber];  ?>">
                                            	<?php echo $route; ?>
                                           	</span>
                                        </li>
                                    <?php
										}
									}
									?>
                                    </ul><!--ul.route-->
                                </dd>
                            </dl><!--dl.access-->
                            <div class="bt_update">
                            	<input type="hidden" name="hdnMapBillId" id="hdnMapBillId" value="<?php echo $globalBuildingId; ?>"/>
                                <a href="#" class="btnChangeMapDetails">
                                	<?php echo Yii::app()->controller->__trans('edit・update'); ?>
                                </a>
                            </div>
                        </div><!--div.access_box--> 
                    </div>
                </div><!--/table-box-->
                
                <div class="vacant-list table-box">
                	<div class="ttl_h3 clearfix">
                    	<h3><?php echo Yii::app()->controller->__trans('vacant floor list'); ?></h3>
                    </div>
                    <div class="empty-room">
						<?php
                        $user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
                        $logged_user_id = $user->user_id;
                        
                        $relatedFloors = Floor::model()->findAll('building_id = '.$globalBuildingId.' AND vacancy_info = 1 ORDER BY cast(floor_down as SIGNED) ASC, cast(floor_up as SIGNED) ASC');
                        //compart floor details
                        $compartOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' and is_compart = 1');
                        $cFloorIds = array();
                        if(count($compartOwnerFloor) > 0){
                            foreach($compartOwnerFloor as $cFloor){
                                $cFloorIds[] = $cFloor['floor_id'];
                            }
                        }
                        
                        //shared floor details
                        $sharedOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' and is_shared = 1');
                        $sFloorIds = array();
                        if(count($sharedOwnerFloor) > 0){
                            foreach($sharedOwnerFloor as $sFloor){
                                $sFloorIds[] = $sFloor['floor_id'];
                            }
                        }
                        ?>
                        <table class="room-table">
                        	<thead>
                                <tr>
                                    <th>
                                        <?php
                                        $flootList = Floor::model()->findAll('building_id = '.$globalBuildingId.' AND vacancy_info = 1 ORDER BY cast(floor_down as SIGNED) ASC, cast(floor_up as SIGNED) ASC');
                                        if(isset($flootList) && count($flootList)){
                                            foreach($flootList as $floors){
                                                $floorIds[] = $floors['floor_id'];
                                            }
                                            $allFloorIds = implode(',',$floorIds);
                                        }
                                        ?>
                                        <input type="hidden" name="hdnAllFloorIds" id="hdnAllFloorIds" class="hdnAllFloorIds" value="<?php echo $allFloorIds; ?>"/>
                                        <input type="hidden" name="hdnBuildingId" id="hdnBuildingId" class="hdnBuildingId" value="<?php echo $globalBuildingId; ?>" />
                                        <button type="button" class="btn btn-primary btnAddAll"><?php echo Yii::app()->controller->__trans('ADD ALL'); ?></button>
                                    </th>
                                    <th><?php echo Yii::app()->controller->__trans('空満'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('number of stairs'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('area'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('rent / Ping'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('condo fees'); ?>/坪</th>
                                    <th><?php echo Yii::app()->controller->__trans('deposit'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('key money'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('renewal fee'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('repayment'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('date move in'); ?></th>
                                    <th><?php echo Yii::app()->controller->__trans('facility'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--Common Ownership-->
                                <tr>
                                    <td colspan="12" style="text-align:left;">
                                        <?php
                                        //$commonOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' AND is_compart != 1 AND is_shared != 1 GROUP BY owner_company_name');
                                        
                                        $query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$globalBuildingId.'  AND `is_compart` != 1  AND `is_shared` != 1 GROUP BY ownership_management.ownership_type';
                                        $commonOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
                                        
                                        if(isset($commonOwnerDetails) && count($commonOwnerDetails) && count($relatedFloors) > 0){
                                            foreach($commonOwnerDetails as $common){
                                        ?>
                                        <span class="vendor-tags">
                                            <span class="vendor-label">
                                            <?php
                                            $managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
                                            
                                            if(array_key_exists($common['ownership_type'],$managementArray)){
                                                echo $managementArray[$common['ownership_type']];
                                            }													
                                            ?>
                                            </span>
                                            <?php echo $common['owner_company_name'];?>
                                            </span>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                
                                if(isset($relatedFloors) && count($relatedFloors) > 0){
                                    foreach($relatedFloors as $related){
                                        if(in_array($related['floor_id'],$cFloorIds)){
                                            continue;
                                        }
                                        if(in_array($related['floor_id'],$sFloorIds)){
                                            continue;
                                        }
                                        
                                        $related['floor_up'] = str_replace("'", '', $related['floor_up']);
                                        $related['floor_down'] = str_replace("'", '', $related['floor_down']);
                                        
                                        if($related['vacancy_info'] == '1'){
                                            $vacancyClass = 'empty';
                                            $vacLabel = Yii::app()->controller->__trans('空');
                                        }else{
                                            continue;
                                        }
                                ?>
                                <tr class="trFloor <?php $this->changeColor($related['floor_id']); ?>" data-href='<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$related['floor_id']))?>'>
                                    <td>
                                        <?php
                                            $cartDetails = Cart::model()->findAll('user_id = '.$logged_user_id.' AND floor_id = '.$related['floor_id'].' AND building_id = '.$globalBuildingId);
                                            $disabled = '';
                                            $addedcss = 'add';
                                            $lbl1 = '追加';
                                            $val = 0;
                                            if(isset($cartDetails) && count($cartDetails) > 0){
                                                $disabled = 'disabled';
                                                $lbl = '削除';
                                                $lbl1 = '削除';
                                                $val = 1;
                                            }
                                        ?>
                                        <input type="hidden" name="hdnBuildingId" id="hdnBuildingId" class="hdnBuildingId" value="<?php echo $globalBuildingId; ?>" />
                                        <input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo $related['floor_id']; ?>" />
                                        <button type="button" class="btn btn-primary btnAddToCart <?php echo $addedcss;?>" <?php //echo $disabled; ?>><?php echo Yii::app()->controller->__trans($lbl1); ?></button>
                                    </td>
                                    <td>
                                        <span style='color:blue'><?php echo Yii::app()->controller->__trans('空室'); ?></span>
										<? if($related['preceding_user'] == 1){
                                                echo '</br><span class="senko" style="background-color:yellow">'.Yii::app()->controller->__trans('先行申込有り').'</span>';
                                            }
											?>
                                    </td>
                                    <td>
                                        <?php
                                        if(strpos($related['floor_down'], '-') !== false){
                                            $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $related['floor_down']);
                                        }else{
                                            $floorDown = $related['floor_down'];
                                        }
                                        $stairs = $floorDown;
                                        $stairs .= '階'.$related['floor_up'];
                                        echo $stairs.'  '.$related['roomname'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($related['area_ping'] != ""){
                                            echo $related['area_ping']." ".Yii::app()->controller->__trans('tsubo');
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if(isset($related['rent_unit_price']) && $related['rent_unit_price'] != "" && $related['rent_unit_price'] != 0){
                                                echo Yii::app()->controller->renderPrice($related['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo');
                                            }else{
                                                if($related['rent_unit_price_opt'] != ''){
                                                    if($related['rent_unit_price_opt'] == -1){
                                                        echo Yii::app()->controller->__trans('undecided');
                                                    }else if($related['rent_unit_price_opt'] == -2){
                                                        echo Yii::app()->controller->__trans('ask');
                                                    }
                                                }else{
                                                    echo '';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if(isset($related['unit_condo_fee']) && $related['unit_condo_fee'] != "" && $related['unit_condo_fee'] != 0){
                                                echo Yii::app()->controller->renderPrice($related['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo');
                                            }else{
                                                if($related['unit_condo_fee_opt'] != ''){
                                                    if($related['unit_condo_fee_opt'] == 0){
                                                        echo Yii::app()->controller->__trans('none');
                                                    }else if($related['unit_condo_fee_opt'] == -1){
                                                        echo Yii::app()->controller->__trans('undecided');
                                                    }else if($related['unit_condo_fee_opt'] == -2){
                                                        echo Yii::app()->controller->__trans('ask');
                                                    }else if($related['unit_condo_fee_opt'] == -3){
                                                        echo Yii::app()->controller->__trans('include');
                                                    }
                                                }else{
                                                    echo '';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td class="total_deposit">
                                        <?php
                                            /*if(isset($related['total_deposit']) && $related['total_deposit'] != "0" && $related['total_deposit'] != ""){
                                                echo number_format($related['total_deposit']).' 円';
                                            }
                                            if($related['deposit_opt'] != ''){
                                                echo '<br/>';
                                                if($related['deposit_opt'] == -1){
                                                    echo Yii::app()->controller->__trans('undecided');
                                                }else if($related['deposit_opt'] == -3){
                                                    echo Yii::app()->controller->__trans('none');
                                                }else if($related['deposit_opt'] == -2){
                                                    echo Yii::app()->controller->__trans('undecided･ask');
                                                }
                                            }
                                            if(isset($related['deposit_month']) &&  $related['deposit_month'] != ''){
                                                echo '<br/>'.$related['deposit_month'].' '.Yii::app()->controller->__trans('ヶ月');
                                            }*/
                                        ?>
                                        <?php
                                            if(isset($related['deposit']) && $related['deposit'] != "" && $related['deposit'] != 0){
                                                echo number_format($related['deposit']).Yii::app()->controller->__trans('yen / tsubo');
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if(isset($related['key_money_opt']) && $related['key_money_opt'] != ""){
                                                if($related['key_money_opt'] == 2){
                                                    echo Yii::app()->controller->__trans('None');
                                                }elseif($related['key_money_opt'] == -1){
                                                    echo Yii::app()->controller->__trans('Unknown');
                                                }elseif($related['key_money_opt'] == -2){
                                                    echo Yii::app()->controller->__trans('Undecided･ask');
                                                }else{
                                                    echo "";
                                                }
                                            }
                                            if($related['key_money_month'] != ""){
                                                echo $related['key_money_month'].' '.Yii::app()->controller->__trans('ヶ月');
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if(isset($related['renewal_fee_opt']) && $related['renewal_fee_opt'] != ""){
                                                if($related['renewal_fee_opt'] == 2){
                                                    echo Yii::app()->controller->__trans('None'); 
                                                }elseif($related['renewal_fee_opt'] == -1){
                                                    echo Yii::app()->controller->__trans('Unknown'); 
                                                }elseif($related['renewal_fee_opt'] == -2){
                                                    echo Yii::app()->controller->__trans('Undecided･ask'); 
                                                }else{
                                                    echo '';
                                                }
                                            }
                                            
                                            if(isset($related['renewal_fee_reason']) && $related['renewal_fee_reason'] != ""){
                                                if($related['renewal_fee_reason'] == 1){
                                                    echo Yii::app()->controller->__trans('現賃料の'); 
                                                }elseif($related['renewal_fee_reason'] == 2){
                                                    echo Yii::app()->controller->__trans('新賃料の'); 
                                                }else{
                                                    echo '';
                                                }
                                            }
                                            
                                            if(isset($related['renewal_fee_recent']) && $related['renewal_fee_recent'] != ""){
                                                echo $related['renewal_fee_recent'].Yii::app()->controller->__trans('month');
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if(isset($related['repayment_opt']) && $related['repayment_opt'] != ""){
                                                if($related['repayment_opt'] == -3){
                                                    echo Yii::app()->controller->__trans('None')."<br>"; 
                                                }elseif($related['repayment_opt'] == -4){
                                                    echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                                }elseif($related['repayment_opt'] == -1){
                                                    echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                                }elseif($related['repayment_opt'] == -2){
                                                    echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                                }elseif($related['repayment_opt'] == -5){
                                                    echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                                }else{
                                                    echo '';
                                                }
                                            }
                                            
                                            if(isset($related['repayment_reason']) && $related['repayment_reason'] != ""){
                                                if($related['repayment_reason'] == 1){
                                                    echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                                }elseif($related['repayment_reason'] == 2){
                                                    echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                                }else{
                                                    echo '';
                                                }
                                            }
                                            
                                            if(isset($related['repayment_amt']) && $related['repayment_amt'] != ""){
                                                echo $related['repayment_amt'];
                                            }
                                            
                                            if(isset($related['repayment_amt_opt']) && $related['repayment_amt_opt'] != ""){
                                                if($related['repayment_amt_opt'] == 1){
                                                    echo Yii::app()->controller->__trans('ヶ月'); 
                                                }elseif($related['repayment_amt_opt'] == 2){
                                                    echo Yii::app()->controller->__trans('%')."<br>"; 
                                                }else{
                                                    echo '';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php									
                                            if(isset($related['move_in_date']) && $related['move_in_date'] != "" && (string)$related['move_in_date'] != '0'){
                                                echo $related['move_in_date'];
                                            }else{
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <ul class="icon-facilities">
                                            <?php if($related['separate_toilet_by_gender'] == 2){ ?>
                                            <li> <span class="icon-jpdb-facilities-icons-wc"></span></li>
                                            <?php }	?>
                                            <?php if($related['air_conditioning_facility_type'] == '個別'){ ?>
                                            <li><span class="icon-jpdb-facilities-icons-ac"></span></li>
                                            <?php } ?>
                                            <?php
                                            $buildDetails = Building::model()->find('building_id  = '.$related['building_id']);
                                            if($buildDetails['earth_quake_res_std'] == '耐震補強済' || $buildDetails['earth_quake_res_std'] == '新耐震基準'){
                                            ?>
                                            <li><span class="icon-jpdb-facilities-icons-earthquake"></span></li>
                                            <?php } ?>
                                            <?php if($related['oa_type'] == 'フリーアクセス'){ ?>
                                            <li> <span class="icon-jpdb-facilities-icons-oa"></span></li>
                                            <?php } ?>
                                            <?php if($related['payment_by_installments'] == 1 || $related['payment_by_installments'] == 2){ ?>
                                            <li> <span class="icon-jpdb-facilities-icons-split"></span></li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                </tr>
                                <?
                                    }
                                }
                                ?>
                                <?php                                
                                $query = 'SELECT om.*
									FROM ownership_management om
									INNER JOIN floor f ON om.floor_id = f.floor_id
									WHERE
										om.building_id = '.(int)$globalBuildingId.'
									AND om.is_compart = 1
									ORDER BY
										cast(f.floor_down AS SIGNED) ASC,
										cast(f.floor_up AS SIGNED) ASC,
										om.ownership_management_id DESC';
								$allCompartOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
								
                                $cFloorIDs = array();
                                $ownerNames = array();
                                foreach($allCompartOwnerDetails as $aFloor){
									$fVacntDetails = Floor::model()->findByPk($aFloor['floor_id']);
									if($fVacntDetails->vacancy_info == 1 && $aFloor['floor_id'] != $globalFloorId){
										$cFloorIDs[] = $aFloor['floor_id'];
										$ownerNames[$aFloor['ownership_type']] = $aFloor['owner_company_name'];
									}
                                }
                                
                                $cFloorIDs = array_unique($cFloorIDs);
                                if(count($cFloorIDs) > 0){
                                    foreach($cFloorIDs as $fId){
                                        $oDetails = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' and floor_id ='.$fId.' AND is_compart = 1');
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
                                    //foreach($oDetails as $sharedDetails){
                                        $floorDetails = Floor::model()->find('floor_id = '.$fId.' AND vacancy_info = 1');
                                        if(!empty($floorDetails)){
                                        
                                ?>
                                    <tr class="trFloor" data-href='<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$floorDetails['floor_id']))?>'>
                                        <td>
                                            <?php
                                                $cartDetails = Cart::model()->findAll('user_id = '.$logged_user_id.' AND floor_id = '.$floorDetails['floor_id'].' AND building_id = '.$buildingDetails['building_id']);
                                                $disabled = '';
                                                $addedcss = 'add';
                                                $lbl1 = '追加';
                                                $val = 0;
                                                if(isset($cartDetails) && count($cartDetails) > 0){
                                                    $disabled = 'disabled';
                                                    $lbl = '削除';
                                                    $lbl1 = '削除';
                                                    $val = 1;
                                                }
                                            ?>
                                            <input type="hidden" name="hdnBuildingId" id="hdnBuildingId" class="hdnBuildingId" value="<?php echo $buildingDetails['building_id']; ?>" />
                                            <input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo $floorDetails['floor_id']; ?>" />
                                            <button type="button" class="btn btn-primary btnAddToCart <?php echo $addedcss;?>" <?php //echo $disabled; ?>><?php echo Yii::app()->controller->__trans($lbl1); ?></button>
                                        </td>
                                        <td>
                                        <span style='color:blue'><?php echo Yii::app()->controller->__trans('空室'); ?></span>
                                        </td>
                                        <td>
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
                                        <td>
                                            <?php
                                            if($floorDetails['area_ping'] != ""){
                                                echo $floorDetails['area_ping']." ".Yii::app()->controller->__trans('tsubo');
                                            }else{
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($floorDetails['total_rent_price']) && $floorDetails['total_rent_price'] != ""){
                                                    echo Yii::app()->controller->renderPrice($floorDetails['total_rent_price']).'円';
                                                }else{
                                                    if($floorDetails['rent_unit_price_opt'] != ''){
                                                        if($floorDetails['rent_unit_price_opt'] == -1){
                                                            echo Yii::app()->controller->__trans('undecided');
                                                        }else if($floorDetails['rent_unit_price_opt'] == -2){
                                                            echo Yii::app()->controller->__trans('ask');
                                                        }
                                                    }else{
                                                        echo '';
                                                    }
                                                }
                                            ?><br>
                                            <?php
                                                if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != "" && $floorDetails['rent_unit_price'] != 0){
                                                    echo '('.Yii::app()->controller->renderPrice($floorDetails['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').')';
                                                }else{
                                                    echo '';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($floorDetails['total_condo_fee']) && $floorDetails['total_condo_fee'] != ""  && $floorDetails['total_condo_fee'] != 0){
                                                    echo ''.Yii::app()->controller->renderPrice($floorDetails['total_condo_fee']).Yii::app()->controller->__trans('yen').'';
                                                }else{
                                                    if($floorDetails['unit_condo_fee_opt'] != ''){
                                                        if($floorDetails['unit_condo_fee_opt'] == 0){
                                                            echo Yii::app()->controller->__trans('none');
                                                        }else if($floorDetails['unit_condo_fee_opt'] == -1){
                                                            echo Yii::app()->controller->__trans('undecided');
                                                        }else if($floorDetails['unit_condo_fee_opt'] == -2){
                                                            echo Yii::app()->controller->__trans('ask');
                                                        }else if($floorDetails['unit_condo_fee_opt'] == -3){
                                                            echo Yii::app()->controller->__trans('include');
                                                        }
                                                    }else{
                                                        echo '';
                                                    }
                                                }
                                            ?><br>
            
                                            <?php
                                                if(isset($floorDetails['unit_condo_fee']) && $floorDetails['unit_condo_fee'] != "" && $floorDetails['unit_condo_fee'] != 0){
                                                    echo '('.Yii::app()->controller->renderPrice($floorDetails['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').')';
                                                }else{
                                                    echo '';
                                                }
                                            ?>
                                        </td>
                                        <td class="total_deposit">
                                            <?php
                                                /*if(isset($related['total_deposit']) && $related['total_deposit'] != "0" && $related['total_deposit'] != ""){
                                                    echo number_format($related['total_deposit']).' 円';
                                                }
                                                if($related['deposit_opt'] != ''){
                                                    echo '<br/>';
                                                    if($related['deposit_opt'] == -1){
                                                        echo Yii::app()->controller->__trans('undecided');
                                                    }else if($related['deposit_opt'] == -3){
                                                        echo Yii::app()->controller->__trans('none');
                                                    }else if($related['deposit_opt'] == -2){
                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                    }
                                                }
                                                if(isset($related['deposit_month']) &&  $related['deposit_month'] != ''){
                                                    echo '<br/>'.$related['deposit_month'].' '.Yii::app()->controller->__trans('ヶ月');
                                                }*/
                                            ?>
                                            <?php
                                                if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != "" && $floorDetails['deposit'] != 0){
                                                    echo '('.number_format($floorDetails['deposit']).Yii::app()->controller->__trans('yen / tsubo').')';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($floorDetails['key_money_opt']) && $floorDetails['key_money_opt'] != ""){
                                                    if($floorDetails['key_money_opt'] == 2){
                                                        echo Yii::app()->controller->__trans('None');
                                                    }elseif($floorDetails['key_money_opt'] == -1){
                                                        echo Yii::app()->controller->__trans('Unknown');
                                                    }elseif($floorDetails['key_money_opt'] == -2){
                                                        echo Yii::app()->controller->__trans('Undecided･ask');
                                                    }else{
                                                        echo "";
                                                    }
                                                }
                                                if($floorDetails['key_money_month'] != ""){
                                                    echo "<br>";
                                                    echo $floorDetails['key_money_month'].' '.Yii::app()->controller->__trans('ヶ月');
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($floorDetails['renewal_fee_opt']) && $floorDetails['renewal_fee_opt'] != ""){
                                                    if($floorDetails['renewal_fee_opt'] == 2){
                                                        echo Yii::app()->controller->__trans('None'); 
                                                    }elseif($floorDetails['renewal_fee_opt'] == -1){
                                                        echo Yii::app()->controller->__trans('Unknown'); 
                                                    }elseif($floorDetails['renewal_fee_opt'] == -2){
                                                        echo Yii::app()->controller->__trans('Undecided･ask'); 
                                                    }else{
                                                        echo '';
                                                    }
                                                }
                                                
                                                if(isset($floorDetails['renewal_fee_reason']) && $floorDetails['renewal_fee_reason'] != ""){
                                                    if($floorDetails['renewal_fee_reason'] == 1){
                                                        echo Yii::app()->controller->__trans('現賃料の'); 
                                                    }elseif($floorDetails['renewal_fee_reason'] == 2){
                                                        echo Yii::app()->controller->__trans('新賃料の'); 
                                                    }else{
                                                        echo '';
                                                    }
                                                }
                                                
                                                if(isset($floorDetails['renewal_fee_recent']) && $floorDetails['renewal_fee_recent'] != ""){
                                                    echo $floorDetails['renewal_fee_recent'].Yii::app()->controller->__trans('month');
                                                }
                                            ?>
                                        </td>
                                        <td>
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
                                        <td>
                                            <?php									
                                                if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != '0'){
                                                    echo $floorDetails['move_in_date'];
                                                }else{
                                                    echo '-';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <ul class="icon-facilities">
                                                <?php if($floorDetails['separate_toilet_by_gender'] == 2){ ?>
                                                <li> <span class="icon-jpdb-facilities-icons-wc"></span></li>
                                                <?php }	?>
                                                <?php if($floorDetails['air_conditioning_facility_type'] == '個別'){ ?>
                                                <li><span class="icon-jpdb-facilities-icons-ac"></span></li>
                                                <?php } ?>
                                                <?php
                                                $buildDetails = Building::model()->find('building_id  = '.$floorDetails['building_id']);
                                                if($buildDetails['earth_quake_res_std'] == '耐震補強済' || $buildDetails['earth_quake_res_std'] == '新耐震基準'){
                                                ?>
                                                <li><span class="icon-jpdb-facilities-icons-earthquake"></span></li>
                                                <?php } ?>
                                                <?php if($floorDetails['oa_type'] == 'フリーアクセス'){ ?>
                                                <li> <span class="icon-jpdb-facilities-icons-oa"></span></li>
                                                <?php } ?>
                                                <?php if($floorDetails['payment_by_installments'] == 1 || $floorDetails['payment_by_installments'] == 2){ ?>
                                                <li> <span class="icon-jpdb-facilities-icons-split"></span></li>
                                                <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php
                                        }
                                    //}
                                }
                            }
                            ?>
                           
                                <?php
								//$allSharedOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' AND is_shared = 1');
								$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '. $globalBuildingId.' AND `is_shared` = 1';
								$allSharedOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
								$sFloorIDs = array();
								$ownerNames = array();
								foreach($allSharedOwnerDetails as $aFloor){
									$fVacntDetails = Floor::model()->findByPk($aFloor['floor_id']);
									if($fVacntDetails->vacancy_info == 1){
										$sFloorIDs[] = $aFloor['floor_id'];
										$ownerNames[$aFloor['ownership_type']] = $aFloor['owner_company_name'];
									}
								}
								$sFloorIDs = array_unique($sFloorIDs);
								if(count($sFloorIDs) > 0){
									foreach($sFloorIDs as $fId){
									$oDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' and floor_id ='.$fId.' AND is_shared = 1');
								?>
                                <tr>
                                    <td colspan="12" style="text-align:left;">
                                    	<span class="labelSharedInSingle">共用オーナーフロア</span><br/>
                                        <?php foreach($oDetails as $own){?>                                        
                                        <span class="vendor-label">
                                            <?php
                                            $managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
                                            if(array_key_exists($own['ownership_type'],$managementArray)){
                                                echo $managementArray[$own['ownership_type']];
                                            }
                                            ?>
                                        </span>
                                        <?php echo $own['owner_company_name'];?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                                    //foreach($oDetails as $sharedDetails){
                                        $floorDetails = Floor::model()->find('floor_id = '.$fId.' AND vacancy_info = 1');
                                        if(!empty($floorDetails)){
                                        
                                ?>
                                    <tr class="trFloor" data-href='<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$floorDetails['floor_id']))?>'>
                                        <td>
                                            <?php
                                                $cartDetails = Cart::model()->findAll('user_id = '.$logged_user_id.' AND floor_id = '.$floorDetails['floor_id'].' AND building_id = '.$buildingDetails['building_id']);
                                                $disabled = '';
                                                $addedcss = 'add';
                                                $lbl1 = '追加';
                                                $val = 0;
                                                if(isset($cartDetails) && count($cartDetails) > 0){
                                                    $disabled = 'disabled';
                                                    $lbl = '削除';
                                                    $lbl1 = '削除';
                                                    $val = 1;
                                                }
                                            ?>
                                            <input type="hidden" name="hdnBuildingId" id="hdnBuildingId" class="hdnBuildingId" value="<?php echo $buildingDetails['building_id']; ?>" />
                                            <input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo $floorDetails['floor_id']; ?>" />
                                            <button type="button" class="btn btn-primary btnAddToCart <?php echo $addedcss;?>" <?php //echo $disabled; ?>><?php echo Yii::app()->controller->__trans($lbl1); ?></button>
                                        </td>
                                        <td>
                                           <span style='color:blue'> <?php echo Yii::app()->controller->__trans('空室'); ?></span>
										   <? if($floorDetails['preceding_user'] == 1){
                                                echo '</br><span class="senko" style="background-color:yellow">'.Yii::app()->controller->__trans('先行申込有り').'</span>';
                                            }
											?>
                                        </td>
                                        <td>
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
                                        <td>
                                            <?php
                                            if($floorDetails['area_ping'] != ""){
                                                echo $floorDetails['area_ping']." ".Yii::app()->controller->__trans('tsubo');
                                            }else{
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($floorDetails['total_rent_price']) && $floorDetails['total_rent_price'] != ""){
                                                    echo Yii::app()->controller->renderPrice($floorDetails['total_rent_price']).'円';
                                                }else{
                                                    if($floorDetails['rent_unit_price_opt'] != ''){
                                                        if($floorDetails['rent_unit_price_opt'] == -1){
                                                            echo Yii::app()->controller->__trans('undecided');
                                                        }else if($floorDetails['rent_unit_price_opt'] == -2){
                                                            echo Yii::app()->controller->__trans('ask');
                                                        }
                                                    }else{
                                                        echo '';
                                                    }
                                                }
                                            ?><br>
                                            <?php
                                                if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != "" && $floorDetails['rent_unit_price'] != 0){
                                                    echo '('.Yii::app()->controller->renderPrice($floorDetails['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').')';
                                                }else{
                                                    echo '';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($floorDetails['total_condo_fee']) && $floorDetails['total_condo_fee'] != ""  && $floorDetails['total_condo_fee'] != 0){
                                                    echo ''.Yii::app()->controller->renderPrice($floorDetails['total_condo_fee']).Yii::app()->controller->__trans('yen').'';
                                                }else{
                                                    if($floorDetails['unit_condo_fee_opt'] != ''){
                                                        if($floorDetails['unit_condo_fee_opt'] == 0){
                                                            echo Yii::app()->controller->__trans('none');
                                                        }else if($floorDetails['unit_condo_fee_opt'] == -1){
                                                            echo Yii::app()->controller->__trans('undecided');
                                                        }else if($floorDetails['unit_condo_fee_opt'] == -2){
                                                            echo Yii::app()->controller->__trans('ask');
                                                        }else if($floorDetails['unit_condo_fee_opt'] == -3){
                                                            echo Yii::app()->controller->__trans('include');
                                                        }
                                                    }else{
                                                        echo '';
                                                    }
                                                }
                                            ?><br>
            
                                            <?php
                                                if(isset($floorDetails['unit_condo_fee']) && $floorDetails['unit_condo_fee'] != "" && $floorDetails['unit_condo_fee'] != 0){
                                                    echo '('.Yii::app()->controller->renderPrice($floorDetails['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').')';
                                                }else{
                                                    echo '';
                                                }
                                            ?>
                                        </td>
                                        <td class="total_deposit">
                                            <?php
                                                /*if(isset($related['total_deposit']) && $related['total_deposit'] != "0" && $related['total_deposit'] != ""){
                                                    echo number_format($related['total_deposit']).' 円';
                                                }
                                                if($related['deposit_opt'] != ''){
                                                    echo '<br/>';
                                                    if($related['deposit_opt'] == -1){
                                                        echo Yii::app()->controller->__trans('undecided');
                                                    }else if($related['deposit_opt'] == -3){
                                                        echo Yii::app()->controller->__trans('none');
                                                    }else if($related['deposit_opt'] == -2){
                                                        echo Yii::app()->controller->__trans('undecided･ask');
                                                    }
                                                }
                                                if(isset($related['deposit_month']) &&  $related['deposit_month'] != ''){
                                                    echo '<br/>'.$related['deposit_month'].' '.Yii::app()->controller->__trans('ヶ月');
                                                }*/
                                            ?>
                                            <?php
                                                if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != "" && $floorDetails['deposit'] != 0){
                                                    echo '('.number_format($floorDetails['deposit']).Yii::app()->controller->__trans('yen / tsubo').')';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($floorDetails['key_money_opt']) && $floorDetails['key_money_opt'] != ""){
                                                    if($floorDetails['key_money_opt'] == 2){
                                                        echo Yii::app()->controller->__trans('None');
                                                    }elseif($floorDetails['key_money_opt'] == -1){
                                                        echo Yii::app()->controller->__trans('Unknown');
                                                    }elseif($floorDetails['key_money_opt'] == -2){
                                                        echo Yii::app()->controller->__trans('Undecided･ask');
                                                    }else{
                                                        echo "";
                                                    }
                                                }
                                                if($floorDetails['key_money_month'] != ""){
                                                    echo "<br>";
                                                    echo $floorDetails['key_money_month'].' '.Yii::app()->controller->__trans('ヶ月');
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($floorDetails['renewal_fee_opt']) && $floorDetails['renewal_fee_opt'] != ""){
                                                    if($floorDetails['renewal_fee_opt'] == 2){
                                                        echo Yii::app()->controller->__trans('None'); 
                                                    }elseif($floorDetails['renewal_fee_opt'] == -1){
                                                        echo Yii::app()->controller->__trans('Unknown'); 
                                                    }elseif($floorDetails['renewal_fee_opt'] == -2){
                                                        echo Yii::app()->controller->__trans('Undecided･ask'); 
                                                    }else{
                                                        echo '';
                                                    }
                                                }
                                                
                                                if(isset($floorDetails['renewal_fee_reason']) && $floorDetails['renewal_fee_reason'] != ""){
                                                    if($floorDetails['renewal_fee_reason'] == 1){
                                                        echo Yii::app()->controller->__trans('現賃料の'); 
                                                    }elseif($floorDetails['renewal_fee_reason'] == 2){
                                                        echo Yii::app()->controller->__trans('新賃料の'); 
                                                    }else{
                                                        echo '';
                                                    }
                                                }
                                                
                                                if(isset($floorDetails['renewal_fee_recent']) && $floorDetails['renewal_fee_recent'] != ""){
                                                    echo $floorDetails['renewal_fee_recent'].Yii::app()->controller->__trans('month');
                                                }
                                            ?>
                                        </td>
                                        <td>
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
                                        <td>
                                            <?php									
                                                if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != '0'){
                                                    echo $floorDetails['move_in_date'];
                                                }else{
                                                    echo '-';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <ul class="icon-facilities">
                                                <?php if($floorDetails['separate_toilet_by_gender'] == 2){ ?>
                                                <li> <span class="icon-jpdb-facilities-icons-wc"></span></li>
                                                <?php }	?>
                                                <?php if($floorDetails['air_conditioning_facility_type'] == '個別'){ ?>
                                                <li><span class="icon-jpdb-facilities-icons-ac"></span></li>
                                                <?php } ?>
                                                <?php
                                                $buildDetails = Building::model()->find('building_id  = '.$floorDetails['building_id']);
                                                if($buildDetails['earth_quake_res_std'] == '耐震補強済' || $buildDetails['earth_quake_res_std'] == '新耐震基準'){
                                                ?>
                                                <li><span class="icon-jpdb-facilities-icons-earthquake"></span></li>
                                                <?php } ?>
                                                <?php if($floorDetails['oa_type'] == 'フリーアクセス'){ ?>
                                                <li> <span class="icon-jpdb-facilities-icons-oa"></span></li>
                                                <?php } ?>
                                                <?php if($floorDetails['payment_by_installments'] == 1 || $floorDetails['payment_by_installments'] == 2){ ?>
                                                <li> <span class="icon-jpdb-facilities-icons-split"></span></li>
                                                <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php
                                        }
                                    //}
                                }
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>
                </div><!--/table-box-->
           	</div>
            <div class="tab_con manage_info"  id="tab2" style="display: none;">
            	<div class="content-manage-info">
                	<h4 class="ontable">
                    	<?php echo Yii::app()->controller->__trans('Management Info'); ?>
                        <a class="detail_local_tab appentHistory" id="timeline" href="#" data-id="<?php echo $globalFloorId; ?>" style="float:right;"><?php echo Yii::app()->controller->__trans('Add History'); ?></a>
                    </h4>
                    <table class="admin_info current-owner">
                    	<tbody>
                            <tr>
                                <th class="check">&nbsp;</th>
                                <th>種別</th>
                                <th><?php echo Yii::app()->controller->__trans('window・owner'); ?></th>
                                <th><?php echo Yii::app()->controller->__trans('charge in person'); ?></th>
                                <th><?php echo Yii::app()->controller->__trans('TEL / FAX'); ?></th>
                                <th>取引形態</th>
                                <th><?php echo Yii::app()->controller->__trans('comission'); ?></th>
                                <th><?php echo Yii::app()->controller->__trans('updated date'); ?></th>
                            </tr>
                            <?php
								//$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$floorDetails['floor_id'].' AND is_current = 1');
                              	//$managementOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$floorDetails['building_id'].' AND is_current = 1');
                              	$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$globalBuildingId.'  AND `is_current` = 1 GROUP BY ownership_management.ownership_type LIMIT 1';
								
								$managementOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
								if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
									foreach($managementOwnerDetails as $ownerList){
										if($ownerList['ownership_type'] == 1){
											$ownerClass = "ico_corptype_4";
											$ownerClass = "";
										}else{
											$ownerClass = "";
										}
							?>
                            <tr>
                            	<th class="check">
                                	<input type="checkbox" name="delete_management_id" id="delete_management_id" class="delete_management_id" value="<?php echo $ownerList['ownership_management_id'] ?>">
                                </th>
                                <td class="vendor_class">
                                	<span class="vendor_type">
                                    	<?php
										if(isset($ownerList['ownership_type']) && $ownerList['ownership_type'] != ""){
											echo $aVendorType[$ownerList['ownership_type']];
										}else{
											echo '-';
										}
										?>
                                    </span>
                                </td>
                                <td class="<?php echo $ownerClass; ?>">
                                	<span class="window-label">窓口</span>
                                    <?php
									if(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != ""){
										echo $ownerList['owner_company_name'];
									}else{
										echo '-';
									}
									?>
                                </td>
                                <td class="ad_name">
									<?php
                                    if(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != ""){
                                        echo $ownerList['person_in_charge1'];
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="ad_contact">
									<?php
                                    if(isset($ownerList['company_tel']) && $ownerList['company_tel'] != ""){
                                        echo $ownerList['company_tel'];
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="ad_type">
									<?php
                                    if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
                                        if($ownerList['management_type'] == -1){
                                            echo Yii::app()->controller->__trans('unknown');
                                        }elseif($ownerList['management_type'] == 1){
                                            echo '専任媒介';
                                        }elseif($ownerList['management_type'] == 2){
                                            echo '一般媒介';
                                        }elseif($ownerList['management_type'] == 3){
                                            echo '代理';
                                        }elseif($ownerList['management_type'] == 4){
                                            echo '貸主';
                                        }else{
                                            echo '-';
                                        }
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="ad_charge">
									<?php
                                    if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
                                        if (is_numeric($ownerList['charge'])){
                                            echo number_format($ownerList['charge'],1,'.','');
                                        }else{
                                            echo $ownerList['charge'];
                                        }
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="ad_update">
									<?php
                                    if(isset($ownerList['modified_on']) && $ownerList['modified_on'] != ""){
                                        echo date('Y.m.d',strtotime($ownerList['modified_on']));
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
                       	</tbody>
                    </table>
                </div><!--/content-manage-info-->
                <div class="content-manage-info">
                	<h4 class="ontable"><?php echo Yii::app()->controller->__trans('past property manage history'); ?></h4>
                    <table class="admin_info past-owner">
                    	<tbody>
                        	<tr>
                                <th class="check">&nbsp;</th>
                                <th>種別</th>
                                <th><?php echo Yii::app()->controller->__trans('window・owner'); ?></th>
                                <th><?php echo Yii::app()->controller->__trans('charge in person'); ?></th>
                                <th><?php echo Yii::app()->controller->__trans('TEL / FAX'); ?></th>
                                <th>取引形態</th>
                                <th><?php echo Yii::app()->controller->__trans('comission'); ?></th>
                                <th><?php echo Yii::app()->controller->__trans('updated date'); ?></th>
                            </tr>
                            <?php
								//$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$globalBuildingId.' AND is_current = 0 ORDER BY ownership_management_id DESC');
								$managementOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' ORDER BY ownership_management_id DESC');
								if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
									foreach($managementOwnerDetails as $ownerList){
										if($ownerList['ownership_type'] == 1){
											$ownerClass = "ico_corptype_4";
											$ownerClass = "";
										}else{
											$ownerClass = "";
										}
							?>
                            <tr>
                                <th class="check">
                                    <input type="checkbox" name="delete_management_id" id="delete_management_id" class="delete_management_id" value="<?php echo $ownerList['ownership_management_id'] ?>">
                                </th>
                                <td class="vendor_class">
                                    <span class="vendor_type">
                                        <?php
                                        if(isset($ownerList['ownership_type']) && $ownerList['ownership_type'] != ""){
                                            echo $aVendorType[$ownerList['ownership_type']];
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td class="<?php echo $ownerClass; ?>">
                                    <?php if($ownerList['is_compart'] == 1){ ?>
                                    <span class="lblSingleCompartType">区分所有</span>
                                    <?php } ?>
                                    <?php if($ownerList['is_shared'] == 1){ ?>
                                    <span class="lblSingleSharedType">共用オーナー</span>
                                    <?php } ?>
                                    <?php if($ownerList['is_current'] == 1){ ?>
                                    <span class="window-label">窓口</span>
                                    <?php } ?>
                                    <?php
                                    if(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != ""){
                                        echo $ownerList['owner_company_name'];
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="ad_name">
                                    <?php
                                    if(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != ""){
                                        echo $ownerList['person_in_charge1'];
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="ad_contact">
                                    <?php
                                    if(isset($ownerList['company_tel']) && $ownerList['company_tel'] != ""){
                                        echo $ownerList['company_tel'];
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="ad_type">
                                    <?php
                                    if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
                                        if($ownerList['management_type'] == -1){
                                            echo Yii::app()->controller->__trans('unknown');
                                        }elseif($ownerList['management_type'] == 1){
                                            echo '専任媒介';
                                        }elseif($ownerList['management_type'] == 2){
                                            echo '一般媒介';
                                        }elseif($ownerList['management_type'] == 3){
                                            echo '代理';
                                        }elseif($ownerList['management_type'] == 4){
                                            echo '貸主';
                                        }else{
                                            echo '-';
                                        }
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="ad_charge">
                                    <?php
                                    if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
                                        if (is_numeric($ownerList['charge'])){
                                            echo number_format($ownerList['charge'],1,'.','');
                                        }else{
                                            echo $ownerList['charge'];
                                        }
                                    }else{
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td class="ad_update">
                                    <?php
                                    if(isset($ownerList['modified_on']) && $ownerList['modified_on'] != ""){
                                        echo date('Y.m.d',strtotime($ownerList['modified_on']));
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
                        </tbody>
                    </table>
                </div><!--/content-manage-info-->
                <div class="admin_check">
                	チェックした業者を&nbsp;
                    <input type="hidden" name="hdnCompnayIds" id="hdnCompnayIds" class="hdnCompnayIds" value=""/>
                    <button type="button" class="bulkDeleteCompanies" id="bulkDeleteCompanies">
                    	一括で削除
                    </button>
                </div>
            </div><!--/tab_con-->
        
        <div class="tab_con active_history"  id="tab3" style="display: none;">
        	<h4 class="ontable"><?php echo Yii::app()->controller->__trans('Activation History'); ?></h4>
            <ul class="tabs2">
            	<li class="active" title="1"><a href="#"><?php echo Yii::app()->controller->__trans('All'); ?></a></li>
                <li title="2"><a href="#"><?php echo Yii::app()->controller->__trans('General'); ?></a></li>
                <li title="3"><a href="#"><?php echo Yii::app()->controller->__trans('Free rent'); ?></a></li>
                <li title="4"><a href="#"><?php echo Yii::app()->controller->__trans('Negotiation history'); ?></a></li>
                <li title="5"><a href="#"><?php echo Yii::app()->controller->__trans('Updated info history'); ?></a></li>
                <li title="6"><a href="#"><?php echo Yii::app()->controller->__trans('Reason to unpublish on website'); ?></a></li>
           	</ul>
            <div class="clear"></div>
            <div class="tabs_content2">
            	<div style="">
					<?php
                    $addedOnArray = array();
                    $transmissionMattersDetails = TransmissionMatters::model()->findAll('building_id = '.$buildingDetails['building_id']);
                    $freeRentDetails = FreeRent::model()->findAll('building_id = '.$buildingDetails['building_id']);
                    $negotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildingDetails['building_id'].' order by rent_negotiation_id desc');
                    $updateHistoryLogDetails = BuildingUpdateLog::model()->findAll('building_id = '.$buildingDetails['building_id']);
                    $mergeArray = array_merge_recursive($transmissionMattersDetails, $freeRentDetails,$negotiationDetails,$updateHistoryLogDetails);
                    foreach($mergeArray as $merge){
                        $addedOnArray[] = date('Y.m.d',strtotime($merge['added_on']));
                    }
                    array_multisort($addedOnArray,SORT_DESC,$mergeArray);
                    ?>
                    <table class="admin_info past-owner">
                        <tbody>
                            <tr class="bg_b bg">
                                <th scope="col" class="date"><font><font><?php echo Yii::app()->controller->__trans('updated date'); ?></font></font></th>
                                <th scope="col" class="category"><?php echo Yii::app()->controller->__trans('category'); ?></th>
                                <th scope="col" class="category"><font><font><?php echo Yii::app()->controller->__trans('charge in person'); ?></font></font></th>
                                <th scope="col" class="info"><?php echo Yii::app()->controller->__trans('contents'); ?></th>
                            </tr>
                            <?php
                            if(isset($mergeArray) && count($mergeArray) > 0){
                                foreach($mergeArray as $merge){
                            ?>
                            <tr class="comment_list">
                                <td class="date"><?php echo date('Y.m.d',strtotime($merge['added_on'])); ?></td>
                                <td class="category">
                                <?php
                                if(isset($merge['free_rent_month'])){
                                    echo Yii::app()->controller->__trans('free rent');
                                }
                                if(isset($merge['note'])){
                                    echo Yii::app()->controller->__trans('general');
                                }
                                if(isset($merge['negotiation_type'])){
                                    echo Yii::app()->controller->__trans('rent negotiation info');
                                }
                                if(isset($merge['change_content'])){
                                    echo Yii::app()->controller->__trans('updated info');
                                }
                                ?>
                                </td>
                                <td class="category">
                                    <font><font>
                                    <?php
                                        $userDetails = AdminDetails::model()->find('user_id = '.$merge['added_by']);
                                        echo $userDetails['full_name'];
                                    ?>
                                    </font></font>
                                </td>
                                <td class="info">
                                    <?php
                                    if(isset($merge['note'])){
                                        if($merge['note'] != ""){
                                            echo $merge['note'];
                                        }else{
                                            echo '-';
                                        }
                                    }
                                    
                                    if(isset($merge['free_rent_month'])){
                                        if($merge['free_rent_month'] != ""){
                                            if($merge['expiration_date'] != "0000-00-00"){
                                                $expirationDate = $merge['expiration_date'];
                                                $freeRent = $merge['free_rent_month'];
                                                $newDate = date('Y-m-d', strtotime("+".$freeRent." month",strtotime($expirationDate)));
                                            }
                                    ?>
                                    <?php
                                            echo Yii::app()->controller->__trans(' free rent for');
                                            echo $freeRent; ?> <?php echo Yii::app()->controller->__trans(' month');
                                            echo Yii::app()->controller->__trans('from');
                                            echo date('M Y',strtotime($expirationDate));
                                            echo Yii::app()->controller->__trans('to');
                                            echo date('M Y',strtotime($newDate));
                                        }else{
                                            echo '-';
                                        }
                                    }
                                    
                                    if(isset($merge['negotiation_type'])){
                                        $allocateFloorDetails = Floor::model()->findAllByAttributes(array('floor_id'=>explode(',',$merge['allocate_floor_id'])));
                                        if(isset($allocateFloorDetails) && count($allocateFloorDetails) > 0){
                                            $floorName = '';
                                            foreach($allocateFloorDetails as $floor){
                                                if(strpos($floor['floor_down'], '-') !== false){
                                                    $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
                                                }else{
                                                    $floorDown = $floor['floor_down'];
                                                }
                                                if($floor['floor_up'] != ""){
                                                    $floorName .= $floorDown." ~ ".$floor['floor_up'].' '.Yii::app()->controller->__trans('階');
                                                }else{
                                                    $floorName .= $floorDown.' '.Yii::app()->controller->__trans('階');
                                                }
                                                if($merge['negotiation_type'] == 4){
                                                    $negUnitList = '円/坪';
                                                }else{
                                                    $negUnitList = '';
                                                }
                                                $floorName .= " / ".$floor['area_ping'].Yii::app()->controller->__trans('tsubo').' | '.$merge['negotiation'].' '.$negUnitList;
                                            }									
                                        }else{
                                            $floorName = '';
                                        }
                                        
                                        if($merge['negotiation_type'] == 1){
                                            echo '坪単価(底値)';
                                        }elseif($merge['negotiation_type'] == 2){									
                                            echo Yii::app()->controller->__trans('Deposit negotiation value');
                                        }elseif($merge['negotiation_type'] == 3){
                                            echo Yii::app()->controller->__trans('Key money negotiation value');
                                        }elseif($merge['negotiation_type'] == 5){
                                            echo '坪単価(目安値)';
                                        }
                                        
                                        else{
                                            echo Yii::app()->controller->__trans('Other negotiations information');
                                        }
                                        echo " ".$merge['negotiation'].'<br/>'.$floorName;
                                    }
                                    if(isset($merge['change_content'])){
                                        echo $merge['change_content'];
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div><!--/div-->
                
                <div style="display: none;">
                	<table class="admin_info past-owner">
                    	<tbody>
                  <tr class="bg_b bg">
                    <th scope="col" class="date"><font><font><?php echo Yii::app()->controller->__trans('updated date'); ?></font></font></th>
                    <th scope="col" class="category"><font><font><?php echo Yii::app()->controller->__trans('category'); ?></font></font></th>
                    <th scope="col" class="category"><font><font><?php echo Yii::app()->controller->__trans('charge in person'); ?></font></font></th>
                    <th scope="col" class="info"><font><font><?php echo Yii::app()->controller->__trans('contents'); ?></font></font></th>
                  </tr>
                  <?php
				  $transmissionMattersDetails = TransmissionMatters::model()->findAll('building_id = '.$buildingDetails['building_id'].' ORDER BY transmission_matters_id DESC');
				  if(isset($transmissionMattersDetails) && count($transmissionMattersDetails) > 0 ){
					  foreach($transmissionMattersDetails as $transList){
				  ?>
                  <tr class="comment_list">
                    <td class="date"><font><font><?php echo date('Y.m.d',strtotime($transList['added_on'])); ?></font></font></td>
                    <td class="category"><font><font><?php echo Yii::app()->controller->__trans('general'); ?></font></font></td>
                    <td class="category"><font><font>
                      <?php
                                	$userDetails = AdminDetails::model()->find('user_id = '.$transList['added_by']);
									echo $userDetails['full_name'];
								?>
                      </font></font></td>
                    <td class="info"><font><font><?php echo $transList['note']; ?></font></font></td>
                  </tr>
                  <?php
					  }
				  }
				  ?>
                </tbody>
              </table>
            </div>
            <!--/div-->
            
            <div style="display: none;">
              <table class="admin_info past-owner">
                <tbody>
                  <tr class="bg_b bg">
                    <th scope="col" class="date"><font><font><?php echo Yii::app()->controller->__trans('updated date'); ?></font></font></th>
                    <th scope="col" class="category"><font><font><?php echo Yii::app()->controller->__trans('category'); ?></font></font></th>
                    <th scope="col" class="category"><font><font><?php echo Yii::app()->controller->__trans('charge in person'); ?></font></font></th>
                    <th scope="col" class="info"><font><font><?php echo Yii::app()->controller->__trans('contents'); ?></font></font></th>
                  </tr>
                  <?php
				  $freeRentDetails = FreeRent::model()->findAll('building_id = '.$buildingDetails['building_id'].' ORDER BY free_rent_id DESC');
				  if(isset($freeRentDetails) && count($freeRentDetails) > 0 ){
					  foreach($freeRentDetails as $freeRent){
				  ?>
                  <tr class="comment_list">
                    <td class="date"><font><font> <?php echo date('Y.m.d',strtotime($freeRent['added_on'])); ?> </font></font></td>
                    <td class="category"><font><font><?php echo Yii::app()->controller->__trans('free rent'); ?></font></font></td>
                    <td class="category"><font><font>
                      <?php
								$userDetails = AdminDetails::model()->find('user_id = '.$freeRent['added_by']);
								echo $userDetails['full_name'];
							?>
                      </font></font></td>
                    <td class="info"><font><font>
                      <?php
							if(isset($freeRent['free_rent_month']) && $freeRent['free_rent_month'] != ""){
								$freeRentMonth = $freeRent['free_rent_month'];
								if($freeRent['expiration_date'] != "0000-00-00"){
									$expirationDate = $freeRent['expiration_date'];
									$newDate = date('Y-m-d', strtotime("+".$freeRentMonth." month",strtotime($expirationDate)));
								}
							?>
                     <?php echo Yii::app()->controller->__trans('free rent for'); ?>  
					 <?php echo $freeRentMonth; ?><?php echo Yii::app()->controller->__trans('month'); ?> 
					 <?php if($freeRent['expiration_date'] != "0000-00-00"){ ?>
					 <?php echo Yii::app()->controller->__trans('from'); ?> 
					 <?php echo date('M Y',strtotime($expirationDate)); ?> 
					 <?php echo Yii::app()->controller->__trans('to'); ?> 
					 <?php echo date('M Y',strtotime($newDate)); ?>
                     <?php } ?>
                      <?php
							}else{
								echo '-';
							}
							?>
                      </font></font></td>
                  </tr>
                  <?php
					  }
				  }
				  ?>
                </tbody>
              </table>
            </div>
            <!--/div-->
            
            <div style="display: none;">
              <table class="admin_info past-owner">
                <tbody>
                  <tr class="bg_b bg">
                    <th scope="col" class="date"><font><font> <?php echo Yii::app()->controller->__trans('updated date'); ?></font></font></th>
                    <th scope="col" class="category"><font><font><?php echo Yii::app()->controller->__trans('category'); ?></font></font></th>
                    <th scope="col" class="category"><font><font><?php echo Yii::app()->controller->__trans('charge in person'); ?></font></font></th>
                    <th scope="col" class="info"><font><font><?php echo Yii::app()->controller->__trans('contents'); ?></font></font></th>
                  </tr>
                  <?php
				  $negotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildingDetails['building_id'].' ORDER BY rent_negotiation_id DESC');
				  if(isset($negotiationDetails) && count($negotiationDetails) > 0){
					  foreach($negotiationDetails as $negotiation){
						  $allocateFloorDetails = Floor::model()->findAllByAttributes(array('floor_id'=>explode(',',$negotiation['allocate_floor_id'])));
						  if(isset($allocateFloorDetails) && count($allocateFloorDetails) > 0){
							  $floorName = '';
							  foreach($allocateFloorDetails as $floor){
								  if(strpos($floor['floor_down'], '-') !== false){
									  $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
								  }else{
									  $floorDown = $floor['floor_down'];
								  }
								  
								  if($floor['floor_up'] != ""){
									  $floorName .= $floorName." ~ ".$floor['floor_up'].' '.Yii::app()->controller->__trans("階");
								  }else{
									  $floorName .= $floorDown.' '.Yii::app()->controller->__trans("階");
								  }
								  if($negotiation['negotiation_type'] == 4){
									  $negUnitList = '';
								  }else{									  
									  $negUnitList = '円/坪';
								  }
								  $floorName .= " / ".$floor['area_ping'].' '.Yii::app()->controller->__trans('tsubo').' | '.$negotiation['negotiation'].' '.$negUnitList;
							  }
						  }else{
							  $floorName = '';
						  }
				  ?>
                  <tr class="comment_list">
                    <td class="date"><font><font><?php echo date('Y.m.d',strtotime($negotiation['added_on'])) ?></font></font></td>
                    <td class="category"><font><font><?php echo Yii::app()->controller->__trans('rent negotiation info'); ?></font></font></td>
                    <td class="category"><font><font>
                      <?php
								$userDetails = AdminDetails::model()->find('user_id = '.$negotiation['added_by']);
								echo $userDetails['full_name'];
							?>
                      </font></font></td>
                    <td class="info"><font><font>
                      <?php
					  if($negotiation['negotiation_type'] == 1){
						echo '坪単価(底値)';
					}elseif($negotiation['negotiation_type'] == 2){
						echo Yii::app()->controller->__trans('Deposit negotiation value');
					}elseif($negotiation['negotiation_type'] == 3){
						echo Yii::app()->controller->__trans('Key money negotiation value');
					}elseif($negotiation['negotiation_type'] == 5){
							echo '坪単価(目安値)';
					}else{
						echo Yii::app()->controller->__trans('Other negotiations information');
					}
					echo ' '.$floorName;
					?>
                      </font></font></td>
                  </tr>
                  <?php
					  }
				  }
				  ?>
                </tbody>
              </table>
            </div>
            <!--/div-->
            
            <div style="display: none;">
              <table class="admin_info past-owner">
                <tbody>
                  <tr class="bg_b bg">
                    <th scope="col" class="date"><font><font><?php echo Yii::app()->controller->__trans('updated date'); ?></font></font></th>
                    <th scope="col" class="category"><font><font><?php echo Yii::app()->controller->__trans('category'); ?></font></font></th>
                    <th scope="col" class="category"><font><font><?php echo Yii::app()->controller->__trans('charge in person'); ?></font></font></th>
                    <th scope="col" class="info"><font><font><?php echo Yii::app()->controller->__trans('contents'); ?></font></font></th>
                  </tr>
                  <?php
				  $updateHistoryLogDetails = BuildingUpdateLog::model()->findAll('building_id = '.$buildingDetails['building_id'].' ORDER BY building_update_log_id DESC');
				  if(isset($updateHistoryLogDetails) && count($updateHistoryLogDetails) > 0){
					  foreach($updateHistoryLogDetails as $updateHistoryLog){
				  ?>
                  <tr class="comment_list">
                    <td class="date"><font><font>
                      <?php
								echo date('Y.m.d',strtotime($updateHistoryLog['added_on']));
							?>
                      </font></font></td>
                    <td class="category"><font><font><?php echo Yii::app()->controller->__trans('updated info'); ?></font></font></td>
                    <td class="category"><font><font>
                      <?php
								$userDetails = AdminDetails::model()->find('user_id = '.$updateHistoryLog['added_by']);
								echo $userDetails['full_name'];
							?>
                      </font></font></td>
                    <td class="info"><font><font>
                      <?php
							if($updateHistoryLog['change_content'] != ""){
								echo $updateHistoryLog['change_content'];
							}
							?>
                      </font></font></td>
                  </tr>
                  <?php
					  }
				  }
				  ?>
                </tbody>
              </table>
            </div>
            <!--/div-->            
            <div style="display: none;">
            	<table class="admin_info past-owner">
                	<thead>
                    	<tr>
                        	<td><?php echo Yii::app()->controller->__trans('updated date'); ?></td>
                            <td><?php echo Yii::app()->controller->__trans('Floor'); ?></td>
                            <td><?php echo Yii::app()->controller->__trans('Note'); ?></td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
						$webFloorList = Floor::model()->findAll('web_publishing = 1 order by modified_on DESC');
						if(isset($webFloorList) && count($webFloorList) > 0 && !empty($webFloorList)){
							foreach($webFloorList as $webFloor){
						?>
                    	<tr>
                        	<td>
                            	<?php
								if($webFloor['modified_on'] != "0000-00-00 00:00:00"){
									echo date('Y.m.d',strtotime($webFloor['modified_on']));
								}else{
									echo '-';
								}
								?>
                            </td>
                        	<td>
								<?php
									echo $webFloor['floorId']." ";
									if(isset($webFloor['floor_down']) && $webFloor['floor_down'] != ""){
										if(strpos($webFloor['floor_down'], '-') !== false){
											$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $webFloor['floor_down']);
										}else{
											$floorDown = $webFloor['floor_down'];
										}									
										if(isset($webFloor['floor_up']) && $webFloor['floor_up'] != ''){
											echo $floorDown.' - '.$webFloor['floor_up'].' '.Yii::app()->controller->__trans('階');
										}else{
											echo $floorDown.' '.Yii::app()->controller->__trans('階');
										}
									}
								?>
                            </td>
                            <td>
								<?php
									echo $webFloor['web_publishing_note'];
								?>
                            </td>
                        </tr>
                        <?php
							}
						}
						?>
                    </tbody>
                </table>
            </div>
            <!--/div--> 
          </div>
          <!--/tabs_content--> 
        </div>
        <!--/tab_con-->
        
        <div class="tab_con"  id="tab4" style="display: none;">
          <ul class="tabs2">
            <li class="active" title="1">
            	<a href="#"><?php echo Yii::app()->controller->__trans('Plan'); ?></a>
            </li>
            <li title="2" class="">
            	<a href="#"><?php echo Yii::app()->controller->__trans('Pictures'); ?></a>
            </li>
          </ul>
          <div class="clear"></div>
          <div class="tabs_content2">
            <div class="plan-section" style="display:block;">
              <h4 class="ontable"><?php echo Yii::app()->controller->__trans('Plan'); ?></h4>
              <div class="zumen-col clearfix">
                <div class="zumen-image">
                  <?php
					$cFloorDetails = Floor::model()->findByPk($_GET['id']);
					$currentFloorPlanDetails = PlanPicture::model()->findByPk($cFloorDetails['plan_picture_id']);
					if(isset($currentFloorPlanDetails) && count($currentFloorPlanDetails) > 0){
						$currentPlan = $currentFloorPlanDetails['name'];
					}else{
						$currentFloorPlanDetails = PlanPicture::model()->findByPk($buildingDetails['plan_standard_id']);
						if(isset($currentFloorPlanDetails) && count($currentFloorPlanDetails) > 0){
							$currentPlan = $currentFloorPlanDetails['name'];
						} else {
							$currentPlan = 'no_plan.jpg';
						}						
					}
					?>
                  <img alt="" src="<?php echo Yii::app()->baseUrl.'/planPictures/'.$currentPlan; ?>"></div>
                <dl class="upload-file">
                  <dt><?php echo Yii::app()->controller->__trans('Upload Plan Image'); ?></dt>
                  <dd>
                    <div id="wordpress_file_upload_block_1" class="file_div_clean wfu_container">
                      <input type="hidden" id="wordpress_file_upload_1_widgetid" value="">
                      <div class="file_div_clean">
                        <table class="file_table_clean">
                          <tbody>
                            <tr>
                              <td class="file_td_clean"><div id="wordpress_file_upload_title_1" class="file_div_clean"> <span class="file_title_clean"><?php echo Yii::app()->controller->__trans('Upload files'); ?></span>
                                  <div class="file_space_clean"></div>
                                </div></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="file_div_clean">
                        <table class="file_table_clean">
                          <tbody>
                            <tr>
                              <td class="file_td_clean" style="padding: 10px 4px 0 0; vertical-align: top;"><div id="wordpress_file_upload_textbox_1" class="file_div_clean divFakePath">
                                  <input type="text" id="fileName_1" class="file_input_textbox" disabled />
                                  <div class="file_space_clean"></div>
                                </div>
                                <form class="file_input_uploadform" id="uploadform_1" name="uploadform_1" method="post" enctype="multipart/form-data">
                                  <input type="file" class="file_input_hidden uploadPlanClass" name="planPicture" id="planPicture" tabindex="1">
                                  <div class="standard_wraper">
                                  	<label>
	                                  	<?php echo Yii::app()->controller->__trans('基準階'); ?>
                                  	</label>
                                  	<input type="checkbox" name="planPictureStandard" id="planPictureStandard" />
                                  </div>
                                </form>
                                </td>
                              <td class="file_td_clean" style="vertical-align: top;"><button type="button" class="btnTrigglerFile"><?php echo Yii::app()->controller->__trans('ファイルを選択'); ?></button></td>
                              <td  style="vertical-align: top;"class="file_td_clean"><div id="wordpress_file_upload_submit_1" class="file_div_clean">
                              <input type="hidden" name="hdnSingleFloorPlanUp" id="hdnSingleFloorPlanUp" class="hdnSingleFloorPlanUp" value="<?php echo $globalFloorId;//$floorDetails['floor_id']; ?>"/>
                                  <input align="center" type="button" id="btnUploadPlanPicture" name="btnUploadPlanPicture" value="<?php echo Yii::app()->controller->__trans('アップロード'); ?>" class="btnUploadPlanPicture">
                                </div></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </dd>
                </dl>
              </div>
              <div class="clearfix">
                <h4 class="ontable"><?php echo Yii::app()->controller->__trans('Plan Management'); ?></h4>
                <div class="manage-plan">
                  <form name="frmAllocatePlanPicture" id="frmAllocatePlanPicture" data-action="<?php echo Yii::app()->createUrl('floor/allocatePlanToFloor'); ?>">
                  <input type="hidden" name="bid" id="bid" value="<?=$globalBuildingId?>" />
                  <input type="hidden" name="floorId" value="<?=$globalFloorId?>" />
                    <table class="dw_list">
                      <tbody>
                        <tr>
                          <th class="stt">&nbsp;</th>
                          <th class="code"><?php echo Yii::app()->controller->__trans('Floor ID'); ?></th>
                          <th class="nm"><?php echo Yii::app()->controller->__trans('階数・部屋番号'); ?></th>
                          <th class="spot"><?php echo Yii::app()->controller->__trans('Area'); ?></th>
                          <th class="dw_num"><font><font><?php echo Yii::app()->controller->__trans('図面番号'); ?>.</font></font></th>
                        </tr>
                        <?php
                      $floorList = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
                      $planPictureList = PlanPicture::model()->findAll('building_id = '.$buildingDetails['building_id']);
                      if(isset($floorList) && count($floorList) > 0){
                        foreach($floorList as $floor){
                            $flagClass = $lbl = '';
                            if($floor['vacancy_info'] == 1){
                                $flagClass = 'empty';
                                $lbl = Yii::app()->controller->__trans('空');
                            }else{
                                $flagClass = 'full';
                                $lbl = Yii::app()->controller->__trans('満');
                            }
                      ?>
                        <tr>
                          <td class="stt"><span class="rm-status <?php echo $flagClass; ?>"> <font><font> <?php echo $lbl; ?> </font></font> </span>
                            <input type="hidden" name="allocateFloorId[]" id="allocateFloorId" class="allocateFloorId" value="<?php echo $floor['floor_id']; ?>" /></td>
                          <td class="code"><?php
                            if(isset($floor['floor_id']) && $floor['floor_id'] != ""){
                                echo $floor['floor_id'];
                            }else{
                                echo '-';
                            }
                            ?></td>
                          <td class="nm"><?php
                            if(isset($floor['floor_down']) && $floor['floor_down'] != ""){
                                if(strpos($floor['floor_down'], '-') !== false){
									$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
								}else{
									$floorDown = $floor['floor_down'];
								}
								
                                if(isset($floor['floor_up']) && $floor['floor_up'] != ""){
                                    echo $floorDown." ~ ".$floor['floor_up'].Yii::app()->controller->__trans("階");
                                }else{
									echo $floorDown.Yii::app()->controller->__trans("階");
								}
                                if(isset($floor['roomname']) && $floor['roomname'] != ""){
                                    echo $floor['roomname'];
                                }
                            }else{
                                echo '-';
                            }
                            ?></td>
                          <td class="spot"><font><font>
                            <?php
                                if(isset($floor['area_ping']) && $floor['area_ping'] != ""){
                                    echo $floor['area_ping'].' '.Yii::app()->controller->__trans("tsubo");
                                }else{
                                    echo '-';
                                }
                                ?>
                            </font></font></td>
                          <td class="dw_num"><select name="planPictureId[]" id="planPictureId" class="planPictureId">
                              <option value="0">-</option>
                              <?php
                            if(isset($planPictureList) && count($planPictureList) > 0){
                                foreach($planPictureList as $planPicture){
									$selected = '';
									if($floor['plan_picture_id'] == $planPicture['plan_picture_id']){
										$selected = 'selected';
									}
                                    ?>
                              <option value="<?php echo $planPicture['plan_picture_id'] ?>" <?php echo $selected; ?>><?php echo $planPicture['plan_rand_number'] ?></option>
                              <?php
                                }
                            }
                            ?>
                            </select></td>
                        </tr>
                        <?php
                        }
                      }
                      ?>
                      <tr>
                      	<td>-
                      	<input type="hidden" name="allocateFloorId[]" id="allocateFloorId" class="allocateFloorId" value="0" />
                      	</td>
                      	<td><?php echo Yii::app()->controller->__trans('Standard floor'); ?></td>
                      	<td>-</td>
                      	<td>-</td>
                      	<td class="dw_num">
                      		<select name="planPictureId[]" id="planPictureId" class="planPictureId">
                        	<option value="0">-</option>
                            <?php
                            	if(isset($planPictureList) && count($planPictureList) > 0){
                                	foreach($planPictureList as $planPicture){
                                		$selected = '';
                                		if($buildingDetails['plan_standard_id'] == $planPicture['plan_picture_id']){
                                			$selected = 'selected';
                                		}
							?>
                            <option value="<?php echo $planPicture['plan_picture_id'] ?>" <?=$selected?>><?php echo $planPicture['plan_rand_number'] ?></option>
                            <?php
                            	    }
                            	}
                            ?>
                            </select>
                       	</td>
                      </tr>
                      <tr>
                      	<td>-
                      	</td>
                      	<td><?php echo Yii::app()->controller->__trans('Article floor'); ?></td>
                      	<td>-</td>
                      	<td>-</td>
                      	<td class="dw_num">
                      		<select name=article_plan_id id=article_plan_id class=article_plan_id>
                        	<option value="0">-</option>
                            <?php
                            	if(isset($planPictureList) && count($planPictureList) > 0){
                                	foreach($planPictureList as $planPicture){
                                		$selected = '';
                                		if($buildingDetails['article_plan_id'] == $planPicture['plan_picture_id']){
                                			$selected = 'selected';
                                		}
							?>
                            <option value="<?php echo $planPicture['plan_picture_id'] ?>" <?=$selected?>><?php echo $planPicture['plan_rand_number'] ?></option>
                            <?php
                            	    }
                            	}
                            ?>
                            </select>
                       	</td>
                      </tr>
                      </tbody>
                    </table>
                    <table>
                      <tr>
                        <td></td>
                        <td style="text-align: right;"><button type="button" style="width:auto;" class="btnAllocatePlanPicture"><?php echo Yii::app()->controller->__trans('更新'); ?></button></td>
                      </tr>
                    </table>
                  </form>
                </div>
                <!--/manage-plan-->
                <div class="plan-list">
                  <h5 class="sub-title"><?php echo Yii::app()->controller->__trans('登録済みの図面'); ?></h5>
                  <ul>
                    <?php
				if(isset($planPictureList) && count($planPictureList) > 0){
				?>
                    <form name="deleteSelectedPlanPicture" id="deleteSelectedPlanPicture" class="deleteSelectedPlanPicture" data-action="<?php echo Yii::app()->createUrl('floor/removeSelectedPlanPicture'); ?>">
                    <input type="hidden" name="floorId" value="<?=$globalFloorId?>" />
                    <?php
                    	$index = 0;
                        foreach($planPictureList as $planPicture){
                        	$index++;
                    ?>
                      <li>
                      <a href="<?php echo Yii::app()->baseUrl.'/planPictures/'.$planPicture['name']; ?>" data-lightbox="<?=$index?>">
                       <img alt="" src="<?php echo Yii::app()->baseUrl.'/planPictures/'.$planPicture['name']; ?>">
                      </a> 
                        <div class="dwe_b">
                          <p>PlanID：<?php echo $planPicture['plan_rand_number'] ?></p>
                          <input type="checkbox" name="deletePlanPicture[]" value="<?php echo $planPicture['plan_picture_id'] ?>">
                        </div>                        
                      </li>
                      <?php
                        }
                    ?>
                      <br/>
                      <li>
                        <button type="button" name="btnRemoveSelectedPlanPicture" id="btnRemoveSelectedPlanPicture" class="btnRemoveSelectedPlanPicture"><?php echo Yii::app()->controller->__trans('チェックされた図面を削除する'); ?></button>
                      </li>
                    </form>
                    <?php
				}
				?>
                  </ul>
                </div>
                <!--/plan-list--> 
              </div>
            </div>
            <div class="picture-section"  style="display: none;">
              <ul class="tabs3">
                <li class="active" title="1"><a href="#"><?php echo Yii::app()->controller->__trans('Building Picture'); ?></a></li>
                <li title="2"><a href="#"><?php echo Yii::app()->controller->__trans('Floor Picture'); ?></a></li>
              </ul>
              <div class="clear"></div>
              <div class="tabs_content3">
                <div class="build-pic" style="">
                <h5>
                    <font><font><?php echo Yii::app()->controller->__trans('Appearance image'); ?></font></font>
                    <span class="up-btn">
                    
                    <form method="post" action="<?php echo Yii::app()->createUrl('buildingPictures/setMain'); ?>" style="display: inline-block;">
                    <input type="hidden" name="b_id" value="<?PHP echo $buildingDetails['building_id']; ?>"/>
                    <input type="hidden" name="b_mid" value="<?PHP echo $_GET['id']; ?>"/>
                    <select name="main_set"  style="display: inline-block;width: 110px;">
                    <?PHP 
					$buildingPictureDetails = BuildingPictures::model()->find('building_id = '.$buildingDetails['building_id']);
                    $images = $buildingPictureDetails['front_images'] != "" ? explode(',',$buildingPictureDetails['front_images']) : "";
					$main_img = $buildingPictureDetails['main_image'];
					if(isset($buildingPictureDetails) && count($buildingPictureDetails) > 0){
						echo '<option value="0" selected>a-0</option>';
                        $ii = 0; $iii = 1;
						if($images != ""){
							foreach($images as $img){
								if($img == $main_img){ 
									$ii++;
									continue;
								}
								echo '<option value="'.$ii.'">a-'.$iii.'</option>';
								$ii++; $iii++;
							}
						}
					}
					?>
                    </select>
                     <button class="main-set-btn" style="display: inline-block;" type="submit" class="btn btn-primary"><?php echo Yii::app()->controller->__trans('メイン写真として設定'); ?></button>
                    </form>
                    
                        <button style="width:100px;" id="open_btn" class="btn btn-primary btnUpBuildFrontImages"><?php echo Yii::app()->controller->__trans('写真を追加'); ?></button>
                    </span>
                </h5>
                <ul class="photo_d_box clearfix">
                    <?php
                    $buildingPictureDetails = BuildingPictures::model()->find('building_id = '.$buildingDetails['building_id']);
                    $images = $buildingPictureDetails['front_images'] != "" ? explode(',',$buildingPictureDetails['front_images']) : "";
                    $images_path = Yii::app()->baseUrl . '/buildingPictures/front';
                    if(isset($buildingPictureDetails) && count($buildingPictureDetails) > 0){
                        $i = 0;
						
						$main_img = $buildingPictureDetails['main_image'];
						if($main_img != ''){
							?>
                            <li>
                        <a href="<?php echo $images_path.'/'.$main_img ; ?>" rel="prettyPhoto[gallery2]">
                            <img src="<?php echo $images_path.'/'.$main_img ; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                        </a><br>
                        <span style="font-size:11px">
                            <font><font>
                                <?php echo '[Main] a-0'; ?>
                            </font></font>
                       
                        </span>
                    </li>
                            
                            
                            <?PHP
						$i = 1;
						}
						
						
						if($images != ""){
							foreach($images as $img){
								if($main_img == $img){
									continue;
								}
								$imgTitle = '';
								if($i == 0){
									$imgTitle = '[Main] a-0';
								}else{
									$imgTitle = 'a-'.$i;
								}
                    ?>
                    <li>
                        <a href="<?php echo $images_path.'/'.$img; ?>" rel="prettyPhoto[gallery2]">
                            <img src="<?php echo $images_path.'/'.$img; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                        </a><br>
                        <span style="font-size:11px">
                            <font><font>
                                <?php echo $imgTitle; ?>
                            </font></font>
                            <a class="removeImg" href="#" data-bid="<?PHP echo $buildingDetails['building_id']; ?>" data-img="<?PHP echo $img; ?>" data-type="front_images"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </span>
                    </li>
                    <?php
							$i++;
							}
						}else{
							echo Yii::app()->controller->__trans('No Images Available').'';
						}
                    }else{
						echo Yii::app()->controller->__trans('No Images Available').'';
					}
                    ?>
                </ul>
                <h5>
                    <font><font><?php echo Yii::app()->controller->__trans('Entrance image'); ?></font></font>
                    <span class="up-btn">
                        <button id="open_btn" class="btn btn-primary btnUpBuildEntranceImages"><font><font><?php echo Yii::app()->controller->__trans('写真を追加'); ?></font></font></button>
                    </span>
                </h5>
                <ul class="photo_d_box clearfix">
                    <?php
                    $buildingPictureDetails = BuildingPictures::model()->find('building_id = '.$buildingDetails['building_id']);
                    $images = $buildingPictureDetails['entrance_images'] != "" ? explode(',',$buildingPictureDetails['entrance_images']) : "";
                    $images_path = Yii::app()->baseUrl . '/buildingPictures/entrance';
                    if(isset($buildingPictureDetails) && count($buildingPictureDetails) > 0){
                        $i = 1;
                        if($images != ""){
							foreach($images as $img){
								$imgTitle = 'b-'.$i;
                    ?>
                    <li>
                        <a href="<?php echo $images_path.'/'.$img; ?>" rel="prettyPhoto[gallery2]">
                            <img src="<?php echo $images_path.'/'.$img; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                        </a><br>
                        <span style="font-size:11px">
                            <?php echo $imgTitle; ?>
                            <a class="removeImg" href="#" data-bid="<?PHP echo $buildingDetails['building_id']; ?>" data-img="<?PHP echo $img; ?>" data-type="entrance_images"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </span>
                        
                    </li>
                    <?php
							$i++;
							}
						}else{
							echo Yii::app()->controller->__trans('No Images Available').'';
						}
                    }else{
						echo Yii::app()->controller->__trans('No Images Available').'';
					}
                    ?>
                </ul>
                <h5>
                    <font><font><?php echo Yii::app()->controller->__trans('Bill before image'); ?></font></font>
                    <span class="up-btn">
                        <button id="open_btn" class="btn btn-primary btnUpBuildInFrontImages"><font><font><?php echo Yii::app()->controller->__trans('写真を追加'); ?></font></font></button>
                    </span>
                </h5>
                <ul class="photo_d_box clearfix">
                    <?php
					$buildingPictureDetails = BuildingPictures::model()->find('building_id = '.$buildingDetails['building_id']);
                    $images = $buildingPictureDetails['in_front_building_images'] != "" ? explode(',',$buildingPictureDetails['in_front_building_images']) : "";
                    $images_path = Yii::app()->baseUrl . '/buildingPictures/inFront';
					if(isset($buildingPictureDetails) && count($buildingPictureDetails) > 0){
                        $i = 1;
                        if($images != ""){
							foreach($images as $img){
								$imgTitle = 'c-'.$i;
					?>
                    <li>
                        <a href="<?php echo $images_path.'/'.$img; ?>" rel="prettyPhoto[gallery2]">
                            <img src="<?php echo $images_path.'/'.$img; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                        </a><br>
                        <span style="font-size:11px">
                        	<?php echo $imgTitle; ?>
                            <a class="removeImg" href="#" data-bid="<?PHP echo $buildingDetails['building_id']; ?>" data-img="<?PHP echo $img; ?>" data-type="in_front_building_images"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </span>
                    </li>
                    <?php
							$i++;
							}
						}else{
							echo Yii::app()->controller->__trans('No Images Available').'';
						}
					}else{
						echo Yii::app()->controller->__trans('No Images Available').'';
					}
					?>
                </ul>
                </div>
                <!--/build-pic-->
                <div class="floor-pic" style="display: none;">
                  <div class="floor-pic-action">
                    <select name="photo_type" id="photo_type" class="photo_type">
                      <option value=""><?php echo Yii::app()->controller->__trans('select type of picture'); ?></option>
                      <option value="1"><font><font><?php echo Yii::app()->controller->__trans('Indoor image'); ?></font></font></option>
                      <option value="2"><font><font><?php echo Yii::app()->controller->__trans('Kitchen image'); ?></font></font></option>
                      <option value="3"><font><font><?php echo Yii::app()->controller->__trans('Toilet image'); ?></font></font></option>
                      <option value="4"><font><font><?php echo Yii::app()->controller->__trans('View image'); ?></font></font></option>
                      <option value="5"><font><font><?php echo Yii::app()->controller->__trans('Other Images'); ?></font></font></option>
                      <option value="5"><font><font><?php echo Yii::app()->controller->__trans('tenant list image'); ?></font></font></option>
                    </select>
                    <input type="button" id="btnAllocateUploadSection" class="button action btnAllocateUploadSection" value="チェックしたフロアに追加">
                    <input type="button" id="btnUploadSectionImage" class="button action btnUploadSectionImage" value="写真を追加">
                  </div>
                  <div class="floor-pic-action">
                  	<input type="checkbox" name="checkAll" id="checkAll" class="checkAll" /><?php echo Yii::app()->controller->__trans('Check All Floors'); ?>
                  </div>
                  <!--/floor-pic-action-->
                  <div class="accordion floorPicAccordion">
                    <ul>
                      <?php
					  $floorList = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
					  if(isset($floorList) && count($floorList) > 0){
						  foreach($floorList as $floorForPic){
					  ?>
                      <li>
                      	<input type="checkbox" name="copy_picture" class="copy_picture" value="<?php echo $floorForPic['floor_id']; ?>" style="margin-right:2px;">
                        <input type="hidden" name="hdnUpFloorId" id="hdnUpFloorId" class="hdnUpFloorId" value="<?php echo $floorForPic['floor_id']; ?>" />
                        <a class="toggle floor-tips">
                        	<span class="floor-level">
								<?php
									if(isset($floorForPic['floor_down']) && $floorForPic['floor_down'] != ""){
										if(strpos($floorForPic['floor_down'], '-') !== false){
											$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorForPic['floor_down']);
										}else{
											$floorDown = $floorForPic['floor_down'];
										}									
										if(isset($floorForPic['floor_up']) && $floorForPic['floor_up'] != ''){
											echo $floorDown.' - '.$floorForPic['floor_up'].' '.Yii::app()->controller->__trans('階');
										}else{
											echo $floorDown.' '.Yii::app()->controller->__trans('階');
										}
									}
								?>
                            </span>
                            <span class="room-no"><?php echo $floorForPic['roomname']; ?></span>
                            <span class="room-id">フロアID:<?php echo $floorForPic['floorId']; ?></span>
                        </a>
                        <div class="list-item">
                        	<h5>
                            	<font><font><?php echo Yii::app()->controller->__trans('Indoor image'); ?></font></font>
                                <span class="up-btn">
                                	<button id="open_btn" class="btn btn-primary btnUpFloorIndoorImages">
                                    	<font><font><?php echo Yii::app()->controller->__trans('写真を追加'); ?></font></font>
                                    </button>
                                </span>
                            </h5>
                            <ul class="photo_d_box clearfix">
                            	<?php
								$floorPictureDetails = FloorPictures::model()->find('floor_id = '.$floorForPic['floor_id']);
								$images = $floorPictureDetails['indoor_image'] != "" ? explode(',',$floorPictureDetails['indoor_image']) : "";
								$images_path = Yii::app()->baseUrl . '/floorPictures/indoor';
								if(isset($floorPictureDetails) && count($floorPictureDetails) > 0){
									$i = 1;
									if($images != ""){
										foreach($images as $img){
											$imgTitle = 'd-'.$i;
								?>
                                <li>
                                	<a href="<?php echo $images_path.'/'.$img; ?>" rel="prettyPhoto[gallery2]">
                                    	<img src="<?php echo $images_path.'/'.$img; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                                    </a><br>
                                    <span style="font-size:11px">
                                    	<?php echo $imgTitle; ?>
                                        <a class="removeImg" href="#" data-bid="<?PHP echo $buildingDetails['building_id']; ?>" data-img="<?PHP echo $img; ?>" data-type="indoor_image"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </span>
                                </li>
                                <?php
										$i++;
										}
									}else{
										echo Yii::app()->controller->__trans('No Images Available').'';
									}
								}else{
									echo Yii::app()->controller->__trans('No Images Available').'';
								}
								?>
                            </ul>
                            <h5>
                            	<font><font><?php echo Yii::app()->controller->__trans('Kitchen image'); ?></font></font>
                                <span class="up-btn">
                                	<button id="open_btn" class="btn btn-primary btnUpFloorKitchenImages">
                                    	<font><font><?php echo Yii::app()->controller->__trans('写真を追加'); ?></font></font>
                                    </button>
                                </span>
                            </h5>
                            <ul class="photo_d_box clearfix">
                            	<?php
								$floorPictureDetails = FloorPictures::model()->find('floor_id = '.$floorForPic['floor_id']);
								$images = $floorPictureDetails['kitchen_image'] != "" ? explode(',',$floorPictureDetails['kitchen_image']) : "";
								$images_path = Yii::app()->baseUrl . '/floorPictures/kitchen';
								if(isset($floorPictureDetails) && count($floorPictureDetails) > 0){
									$i = 1;
									if($images != ""){
										foreach($images as $img){
											$imgTitle = 'e-'.$i;
								?>
                                <li>
                                	<a href="<?php echo $images_path.'/'.$img; ?>" rel="prettyPhoto[gallery2]">
                                    	<img src="<?php echo $images_path.'/'.$img; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                                    </a><br>
                                    <span style="font-size:11px">
                                    	<?php echo $imgTitle; ?>
                                        <a class="removeImg" href="#" data-bid="<?PHP echo $buildingDetails['building_id']; ?>" data-img="<?PHP echo $img; ?>" data-type="kitchen_image"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </span>
                                </li>
                                <?php
										$i++;
										}
									}else{
										echo Yii::app()->controller->__trans('No Images Available').'';
									}
								}else{
									echo Yii::app()->controller->__trans('No Images Available').'';
								}
								?>
                            </ul>
                            <h5>
                            	<font><font><?php echo Yii::app()->controller->__trans('Toilet image'); ?></font></font>
                                <span class="up-btn">
                                    <button id="open_btn" class="btn btn-primary btnUpFloorBathroomImages">
                                        <font><font><?php echo Yii::app()->controller->__trans('写真を追加'); ?></font></font>
                                    </button>
                                </span>
                            </h5>
                            <ul class="photo_d_box clearfix">
                            	<?php
								$floorPictureDetails = FloorPictures::model()->find('floor_id = '.$floorForPic['floor_id']);
								$images = $floorPictureDetails['bathroom_image'] != "" ? explode(',',$floorPictureDetails['bathroom_image']) : "";
								$images_path = Yii::app()->baseUrl . '/floorPictures/bathroom';
								if(isset($floorPictureDetails) && count($floorPictureDetails) > 0){
									$i = 1;
									if($images != ""){
										foreach($images as $img){
											$imgTitle = 'f-'.$i;
								?>
                                <li>
                                	<a href="<?php echo $images_path.'/'.$img; ?>" rel="prettyPhoto[gallery2]">
                                    	<img src="<?php echo $images_path.'/'.$img; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                                    </a><br>
                                    <span style="font-size:11px">
                                    	<?php echo $imgTitle; ?>
                                        <a class="removeImg" href="#" data-bid="<?PHP echo $buildingDetails['building_id']; ?>" data-img="<?PHP echo $img; ?>" data-type="bathroom_image"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </span>
                                </li>
                                <?php
										$i++;
										}
									}else{
										echo Yii::app()->controller->__trans('No Images Available').'';
									}
								}else{
									echo Yii::app()->controller->__trans('No Images Available').'';
								}
								?>
                            </ul>
                            <h5>
                            	<font><font><?php echo Yii::app()->controller->__trans('View image'); ?></font></font>
                                <span class="up-btn">
                                	<button id="open_btn" class="btn btn-primary btnUpFloorProspectImages">
                                    	<font><font><?php echo Yii::app()->controller->__trans('写真を追加'); ?></font></font>
                                    </button>
                                </span>
                            </h5>
                            <ul class="photo_d_box clearfix">
                            	<?php
								$floorPictureDetails = FloorPictures::model()->find('floor_id = '.$floorForPic['floor_id']);
								$images = $floorPictureDetails['prospect_image'] != "" ? explode(',',$floorPictureDetails['prospect_image']) : "";
								$images_path = Yii::app()->baseUrl . '/floorPictures/prospect';
								if(isset($floorPictureDetails) && count($floorPictureDetails) > 0){
									$i = 1;
									if($images != ""){
										foreach($images as $img){
											$imgTitle = 'g-'.$i;
								?>
                                <li>
                                	<a href="<?php echo $images_path.'/'.$img; ?>" rel="prettyPhoto[gallery2]">
                                    	<img src="<?php echo $images_path.'/'.$img; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                                    </a><br>
                                    <span style="font-size:11px">
                                    	<?php echo $imgTitle; ?>
                                        <a class="removeImg" href="#" data-bid="<?PHP echo $buildingDetails['building_id']; ?>" data-img="<?PHP echo $img; ?>" data-type="prospect_image"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </span>
                                </li>
                                <?php
										$i++;
										}
									}else{
										echo Yii::app()->controller->__trans('No Images Available').'';
									}
								}else{
									echo Yii::app()->controller->__trans('No Images Available').'';
								}
								?>
                            </ul>
                            <h5>
                            	<font><font><?php echo Yii::app()->controller->__trans('Other Images'); ?></font></font>
                                <span class="up-btn">
                                	<button id="open_btn" class="btn btn-primary btnUpFloorOtherImages">
                                    	<font><font><?php echo Yii::app()->controller->__trans('写真を追加'); ?></font></font>
                                    </button>
                                </span>
                            </h5>
                            <ul class="photo_d_box clearfix">
                            	<?php
								$floorPictureDetails = FloorPictures::model()->find('floor_id = '.$floorForPic['floor_id']);
								$images = $floorPictureDetails['other_image'] != "" ? explode(',',$floorPictureDetails['other_image']) : "";
								$images_path = Yii::app()->baseUrl . '/floorPictures/other';
								if(isset($floorPictureDetails) && count($floorPictureDetails) > 0){
									$i = 1;
									if($images != ""){
										foreach($images as $img){
											$imgTitle = 'z-'.$i;
								?>
                                <li>
                                	<a href="<?php echo $images_path.'/'.$img; ?>" rel="prettyPhoto[gallery2]">
                                    	<img src="<?php echo $images_path.'/'.$img; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                                    </a><br>
                                    <span style="font-size:11px">
                                    	<?php echo $imgTitle; ?>
                                        <a class="removeImg" href="#" data-bid="<?PHP echo $buildingDetails['building_id']; ?>" data-img="<?PHP echo $img; ?>" data-type="other_image"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </span>
                                </li>
                                <?php
										$i++;
										}
									}else{
										echo Yii::app()->controller->__trans('No Images Available').'';
									}
								}else{
									echo Yii::app()->controller->__trans('No Images Available').'';
								}
								?>
                            </ul>
                            <h5>
                            	<font><font><?php echo Yii::app()->controller->__trans('tenant list image'); ?></font></font>
                                <span class="up-btn">
                                	<button id="open_btn" class="btn btn-primary btnUpFloorTenantListImages">
                                    	<font><font><?php echo Yii::app()->controller->__trans('写真を追加'); ?></font></font>
                                    </button>
                                </span>
                            </h5>
                            <ul class="photo_d_box clearfix">
                            	<?php
								$floorPictureDetails = FloorPictures::model()->find('floor_id = '.$floorForPic['floor_id']);
								$images = $floorPictureDetails['tenant_list_image'] != "" ? explode(',',$floorPictureDetails['tenant_list_image']) : "";
								$images_path = Yii::app()->baseUrl . '/floorPictures/tenant';
								if(isset($floorPictureDetails) && count($floorPictureDetails) > 0){
									$i = 1;
									if($images != ""){
										foreach($images as $img){
											$imgTitle = 'd-'.$i;
								?>
                                <li>
                                	<a href="<?php echo $images_path.'/'.$img; ?>" rel="prettyPhoto[gallery2]">
                                    	<img src="<?php echo $images_path.'/'.$img; ?>" alt="<?php echo $img; ?>" class="image_size_auto_fix" target_width="150" target_height="112" style="width: 84px; height: 112px;">
                                    </a><br>
                                    <span style="font-size:11px">
                                    	<?php echo $imgTitle; ?>
                                         <a class="removeImg" href="#" data-bid="<?PHP echo $buildingDetails['building_id']; ?>" data-img="<?PHP echo $img; ?>" data-type="tenant_list_image"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </span>
                                </li>
                                <?php
										$i++;
										}
									}else{
										echo Yii::app()->controller->__trans('No Images Available').'';
									}
								}else{
									echo Yii::app()->controller->__trans('No Images Available').'';
								}
								?>
                            </ul>
                        </div>
                        <!--/list-item--> 
                      </li>
                      <?php
						  }
					  }
					  ?>
                    </ul>
                  </div>
                  <!--/accordion--> 
                  
                </div>
                <!--/floor-pic--> 
              </div>
              <!--/tabs_content3--> 
            </div>
          </div>
        </div>
        <!--/tab_con-->
        <div class="tab_con street-view"  id="tab5" style="display: none;">
        	<div class="clearfix">
            	<div class="st-view">
				<?php
                $buildingMapDetails = Building::model()->findByPk($buildingDetails['building_id']);
				if(isset($buildingMapDetails) && count($buildingMapDetails) > 0){
					$address = $buildingMapDetails['address'];
					$lat = $buildingMapDetails['map_lat'];
					$long = $buildingMapDetails['map_long'];
				?>
                	<iframe width="450" height="400" frameborder="0" style="border:0"
  src="https://www.google.com/maps/embed/v1/streetview?key=<?php echo $gApiKey; ?>&location=<?php echo $lat.','.$long; ?>&heading=210&pitch=10&fov=35" allowfullscreen></iframe>
  				<?php
                }
				?>
                </div>
                <div class="mp-view">
				<?php
                $buildingMapDetails = Building::model()->findByPk($buildingDetails['building_id']);
				if(isset($buildingMapDetails) && count($buildingMapDetails) > 0){
					$address = $buildingMapDetails['address'];
					$lat = $buildingMapDetails['map_lat'];
					$long = $buildingMapDetails['map_long'];
				?>
                <iframe width="450" height="400" frameborder="0" style="border:0"
  src="https://www.google.com/maps/embed/v1/place?key=<?php echo $gApiKey; ?>&q=<?php echo $address ?>" allowfullscreen></iframe>
  				<?php
                }
				?>
                </div>
            </div><!--/clearfix--> 
        </div>
        <!--/tab_con-->
        <?php
			$rentUnitPrice = $addNeg = array();
			
			$sqlForGraphFisrt = 'SELECT * FROM (SELECT available_floor,modified_on FROM floor_update_history WHERE building_id = '.$buildingDetails['building_id'].' ORDER BY modified_on DESC) AS tmp_table GROUP BY available_floor';
			$commandForFirst = Yii::app()->db->createCommand($sqlForGraphFisrt)->queryAll();
			foreach($commandForFirst as $details){
				$floorId[] = $details['available_floor'];
				$mdateForFirst[] = date('Y/m',strtotime($details['modified_on']));
			}
			
			$sqlForGraphSecond = 'SELECT * FROM (SELECT current_average_rent,modified_on FROM floor_update_history WHERE building_id = '.$buildingDetails['building_id'].' ORDER BY modified_on DESC) AS tmp_table GROUP BY current_average_rent';
			$commandForSecond = Yii::app()->db->createCommand($sqlForGraphSecond)->queryAll();
			foreach($commandForSecond as $details){
				$rentUnitPrice[] = $details['current_average_rent'];
				$mdateForSecond[] = date('Y/m',strtotime($details['modified_on']));
			}
			//print_r($rentUnitPrice);
			//print_r($mdate);
			$floorId = json_encode($floorId);
			$mdateForFirst = json_encode($mdateForFirst);
			$rentUnitPrice = json_encode($rentUnitPrice);
			$mdateForSecond = json_encode($mdateForSecond);
		?>
        <div class="tab_con time-line clearfix"  id="tab6" style="display: none;">
        	<div class="left-col">
            	<h4 class="ontable"><?php echo Yii::app()->controller->__trans('Time Line Info'); ?></h4>
                <div class="gr-title"><?php echo Yii::app()->controller->__trans('Floor Number Transition'); ?></div>
                <div class="graph" style="margin-bottom: 10px !important;"></div>
                <canvas id="myChart1"></canvas>
                <div class="gr-title"><?php echo Yii::app()->controller->__trans('Rent Transition'); ?></div>
                <div class="graph" style="margin-bottom: 10px !important;"></div>
                <canvas id="myChart"></canvas>
				<script>
					var ctx = document.getElementById("myChart");
					var ctx1 = document.getElementById("myChart1");
					var myChart = new Chart(ctx, {
						type: 'line',
						data: {
							labels: <?php echo $mdateForSecond; ?>,
							datasets: [{
								label: '',
								data: <?php echo $rentUnitPrice; ?>,
								backgroundColor:'rgba(255, 99, 132, 0.2)',
								borderColor:'rgba(255,99,132,1)',
								borderWidth: 1,
								pointHoverRadius: 5,
							}],
						},
						options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero:true
									}
								}]
							},
							legend: { display: false,}
						}
					});
					var myChart = new Chart(ctx1, {
						type: 'line',
						data: {
							labels: <?php echo $mdateForFirst; ?>,
							datasets: [{
								data: <?php echo $floorId; ?>,
								backgroundColor:'rgba(255, 99, 132, 0.2)',
								borderColor:'rgba(255,99,132,1)',
								borderWidth: 0,
								pointHoverRadius: 5,
							}]
						},
						options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero:true
									}
								}]
							},
							legend: { display: false,}
						}
					});
                </script>
            </div>
            <div class="right-col">
			<?php
            	$titleHistory = Yii::app()->controller->__trans('Floor History') . ' (';
				if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
					if(strpos($floorDetails['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
					}else{
						$floorDown = $floorDetails['floor_down'];
					}
					if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
						$titleHistory .= $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
					}else{
						$titleHistory .= $floorDown.' '.Yii::app()->controller->__trans('階');
					}
				}
				$titleHistory .= '/';
			?>
			<?php
            	if(isset($floorDetails['area_ping']) && $floorDetails['area_ping'] != ""){
					$titleHistory .= $floorDetails['area_ping']." ".Yii::app()->controller->__trans('Ping');
				}else{
					$titleHistory .= '-';
				}
			?>
			<?php
            	if(isset($floorDetails['payment_by_installments']) && $floorDetails['payment_by_installments'] == 1){
        			$titleHistory .= '分割例 :';
        		}else if(isset($floorDetails['payment_by_installments']) && $floorDetails['payment_by_installments'] == 2){
        			$titleHistory .= '分割可 :';
        		}
        	?>
			<?php
            	if(isset($floorDetails['floor_partition']) && $floorDetails['floor_partition'] != ""){
					$expFloorParts = explode(',',$floorDetails['floor_partition']);
					if(!empty($expFloorParts)){
						foreach($expFloorParts as $part){
							$titleHistory .= $part.'坪';
						}
        			}
				}
			?>
            	<h4 class="ontable"><?php echo $titleHistory . ')'; ?></h4>
                <table class="archive_box">
                	<tbody>
                    	<tr class="archive_ttl">
                        	<th scope="col" class="date"></th>
                            <th scope="col" class="rm"><font><font><?php echo Yii::app()->controller->__trans('空満'); ?></font></font></th>
                            <th scope="col" class="prm"><font><font><?php echo Yii::app()->controller->__trans('rent'); ?></font></font></th>
                            <th scope="col" class="csc"><font><font><?php echo Yii::app()->controller->__trans('condo fees'); ?></font></font></th>
                            <th scope="col" class="dps"><font><font><?php echo Yii::app()->controller->__trans('deposit'); ?></font></font></th>
                            <th scope="col" class="money"><font><font><?php echo Yii::app()->controller->__trans('key money'); ?></font></font></th>
                        </tr>
                        <tr>
                        	<td colspan="6" class="archive_info"><div class="ahv">
                            	<table class="ahv_detail">
                                	<tbody>
									<?php
                                    	$floorHistoryList = FloorUpdateHistory::model()->findAll('floor_id = '.$_GET['id'].' ORDER BY floor_update_history_id DESC');
										if(isset($floorHistoryList) && count($floorHistoryList) > 0){
											foreach($floorHistoryList as $historyList){
												if($historyList['vacancy_info'] == 0){
													$vacantClass = 'full';
													$vacantLabel = "<span style='color:red'>".Yii::app()->controller->__trans('満室').'</span>';
												}else{
													$vacantClass = 'empty';
													$vacantLabel = "<span style='color:blue'>".Yii::app()->controller->__trans('空室').'</span>';
												}
									?>
                                    	<tr>
                                        	<th scope="row" class="date">
											<?php
                                            	$date = date('Y.m.d',strtotime($historyList['modified_on']));
												if($date != '0000-00-00'){
													echo $date;
												}else{
													echo '-';
												}
											?>
                                            </th>
                                            <td class="rm <?php echo $vacantClass; ?>">
                                            	<font> <?php echo $vacantLabel; ?> </font>
												<? /*if($floorDetails['preceding_user'] == 1){
                                                echo '</br><span class="senko" style="background-color:yellow">'.Yii::app()->controller->__trans('先行申込有り').'</span>';
                                            }*/
											?>
                                            </td>
                                            <td class="prm a">
                                            	<font><font> 
													<?php
                                                        if(isset($historyList['total_rent_price']) && $historyList['total_rent_price'] != ""){
                                                            echo Yii::app()->controller->renderPrice($historyList['total_rent_price']).'円';
                                                        }else{
                                                            if($historyList['rent_unit_price_opt'] != ''){
                                                                if($historyList['rent_unit_price_opt'] == -1){
                                                                    echo Yii::app()->controller->__trans('undecided').'<br>';
                                                                }else if($historyList['rent_unit_price_opt'] == -2){
                                                                    echo Yii::app()->controller->__trans('ask').'<br>';
                                                                }
                                                            }else{
                                                                echo '';
                                                            }
                                                        }
                                                    ?>
                                                </font></font>
                                                <font><font>                             
                                                    <?php
                                                        if(isset($historyList['rent_unit_price']) && $historyList['rent_unit_price'] != ""){
                                                            echo '('.Yii::app()->controller->renderPrice($historyList['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').')';
                                                        }else{
                                                            echo '';
                                                        }
                                                    ?>
                                                </font></font>
                                            </td>
                                            <td class="csc">
                                            	<font><font> 
													<?php
                                                        if(isset($historyList['total_condo_fee']) && $historyList['total_condo_fee'] != ""){
                                                            echo ''.Yii::app()->controller->renderPrice($historyList['total_condo_fee']).Yii::app()->controller->__trans('yen').'';
                                                        }else{
                                                            if($historyList['unit_condo_fee_opt'] != ''){
                                                                if($historyList['unit_condo_fee_opt'] == "0"){
                                                                    echo Yii::app()->controller->__trans('none').'<br>';
                                                                }else if($historyList['unit_condo_fee_opt'] == "-1"){
                                                                    echo Yii::app()->controller->__trans('undecided').'<br>';
                                                                }else if($historyList['unit_condo_fee_opt'] == "-2"){
                                                                    echo Yii::app()->controller->__trans('ask').'<br>';
                                                                }else if($historyList['unit_condo_fee_opt'] == "-3"){
                                                                    echo '賃料に込み<br/>(含む)'.'<br>';
                                                                }
                                                            }else{
                                                                echo '';
                                                            }
                                                        }
                                                    ?>
                                                    </font></font>
                                                    <font><font> 
                                                        <?php
                                                            if(isset($historyList['unit_condo_fee']) && $historyList['unit_condo_fee'] != ""){
                                                                echo '('.Yii::app()->controller->renderPrice($historyList['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').')';
                                                            }else{
                                                                echo '';
                                                            }
                                                        ?>
                                                    </font></font>
                                           	</td>
                                            <td class="dps">
												<font><font> 
													<?php
                                                        /*if(isset($historyList['total_deposit']) && $historyList['total_deposit'] != "0" && $historyList['total_deposit'] != ""){
                                                            echo Yii::app()->controller->renderPrice($historyList['total_deposit']).' 円';
                                                        }
                                                        if($historyList['deposit_opt'] != ''){
                                                            echo '<br/>';
                                                            if($historyList['deposit_opt'] == -1){
                                                                echo Yii::app()->controller->__trans('undecided');
                                                            }else if($historyList['deposit_opt'] == -3){
                                                                echo Yii::app()->controller->__trans('none');
                                                            }else if($historyList['deposit_opt'] == -2){
                                                                echo Yii::app()->controller->__trans('undecided･ask');
                                                            }
                                                        }*/
                                                        if(isset($historyList['deposit_month']) &&  $historyList['deposit_month'] != ''){
                                                            echo $historyList['deposit_month'].' ヶ月';
                                                        }
                                                    ?>
                                                </font></font>
                                                <font><font> 
                                                    <?php
                                                        /*if(isset($historyList['deposit']) && $historyList['deposit'] != ""){
                                                            echo '('.$historyList['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                                        }else{
                                                            echo '';
                                                        }*/
                                                    ?>
                                                </font></font>
                                            </td>
                                            <td class="money">
                                                <font><font>
													<?php
														if(isset($historyList['key_money_opt']) && $historyList['key_money_opt'] != ""){
															if($historyList['key_money_opt'] == 2){
																echo Yii::app()->controller->__trans('None');
															}elseif($historyList['key_money_opt'] == -1){
																echo Yii::app()->controller->__trans('Unknown');
															}elseif($historyList['key_money_opt'] == -2){
																echo Yii::app()->controller->__trans('undecided･ask');
															}else{
																echo '';
															}
														}else{
															echo '';
														}
														
														if(isset($historyList['key_money_month']) && $historyList['key_money_month'] != ""){
															echo $historyList['key_money_month'].Yii::app()->controller->__trans('month');
														}
													?>
                                                    </font></font>
                                            </td>
                                        </tr>
									<?php
                                    		}
										}else{
									?>
                                    <tr>
                            <td colspan="6" align="center"><?php echo Yii::app()->controller->__trans('No History Available'); ?>.</td>
                          </tr>
                          <?php
								}
								?>
                        </tbody>
                      </table>
                    </div></td>
                </tr>
              </tbody>
            </table>
            <h4 class="ontable"><?php echo Yii::app()->controller->__trans('Building Update History'); ?></h4>
            <table class="archive_box">
              <tbody>
                <tr class="archive_ttl">
                  <th scope="col" class="date_b"><?php echo Yii::app()->controller->__trans('Update Date'); ?></th>
                  <th scope="col" class="udi"><?php echo Yii::app()->controller->__trans('Updated Content'); ?></th>
                  <th scope="col" class="udn"><?php echo Yii::app()->controller->__trans('Updated By'); ?></th>
                </tr>
                <tr>
                  <td colspan="3" class="archive_info"><div class="ahv">
                      <table class="ahv_detail">
                        <tbody>
                          <?php
						  $updateHistoryLogDetails = BuildingUpdateLog::model()->findAll('building_id = '.$buildingDetails['building_id'].' ORDER BY building_update_log_id DESC');
						  if(isset($updateHistoryLogDetails) && count($updateHistoryLogDetails) > 0){
							  foreach($updateHistoryLogDetails as $updateHistoryLog){
						  ?>
                          <tr>
                            <th scope="row" class="date_b"> <?php
									echo date('Y.m.d',strtotime($updateHistoryLog['added_on']));
								?>
                            </th>
                            <td class="udi"><font><font>
                              <?php
									if($updateHistoryLog['change_content'] != ""){
										echo $updateHistoryLog['change_content'];
									}else{
										echo "-";
									}
									?>
                              </font></font></td>
                            <td class="udn"><?php
									$userDetails = AdminDetails::model()->find('user_id = '.$updateHistoryLog['added_by']);
									echo $userDetails['full_name'];
								?></td>
                          </tr>
                          <?php
							  }
						  }
						  ?>
                        </tbody>
                      </table>
                      <p><!--table.ahv_detail--> 
                      </p>
                    </div>
                    <p><!--div.ahv--> 
                    </p></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!--/tab_con-->
        
        <div class="tab_con pdfbox"  id="tab7" style="display: none;">
        	<h4 class="ontable"><font><font>PDF</font></font></h4>
            <form name="frmUploadBuildingPdf" id="frmUploadBuildingPdf" enctype="multipart/form-data" action="<?php echo Yii::app()->createUrl('building/uploadBuildingPdf'); ?>">
            	<input type="hidden" name="buildingId" id="buildingId" value="<?php echo $buildingDetails['building_id'] ?>" />
                <dl class="upload_pdf clearfix">
                	<dt class="up_h">タイトル</dt>
                    <dd class="ttl_fl">
                    	<input type="text" class="ttl_fl pdftitle" id="pdftitle" name="pdftitle" value="" required>
                    </dd>
                    <dt class="up_hb"><?php echo Yii::app()->controller->__trans('Note'); ?></dt>
                    <dd class="up_hb">
                    	<textarea name="pdfmemo" class="pdfmemo" id="memo"></textarea>
                    </dd>
                    <dt class="up_h none">アップロード</dt>
                    <dd class="up_h none">
                    	<div class="fileinputs">
                        	<input type="file" name="pdfFile" class="upfile">
                            <input type="hidden" name="fileSize" id="fileSize" value="0"/>
                        </div>
                        <table class="upinput">
                        	<tbody>
                            	<tr>
                                	<?php /*?><td class="upload-input">
                                    	<input type="text" id="targetInput">
                                    </td>
                                    <td class="up-btn">
                                    	<input type="submit" value="refer" class="bt_reffer">
                                    </td><?php */?>
                                    <td>
                                    	<input type="submit" value="upload" class="bt_upload btnUploadPdf">
                                        <button type="button" class="uploadAfter" style="display: none;background-color:rgba(18,170,235,1);font-size:14px;">
											<?php echo Yii::app()->controller->__trans('File Uploading'); ?>...
                                            <div class="ajxLoader" style="position:relative;">
                                                <div class="loader" style="top: -30px;right: 0;left: 120px;">
                                                    <?php echo Yii::app()->controller->__trans('Loading'); ?>...
                                                </div>
                                            </div>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                   	</dd>
                </dl>
            </form>
            <table class="pdf_list">
            	<tbody>
                	<tr>
                    	<th scope="col" class="ttl_pdf">
                        	<font><font><?php echo Yii::app()->controller->__trans('タイトル'); ?></font></font>
                        </th>
                        <th scope="col" class="date">
							<?php echo Yii::app()->controller->__trans('Updated Date'); ?>
                        </th>
                        <th scope="col" class="udn">
							<?php echo Yii::app()->controller->__trans('Updated by'); ?>
                        </th>
                        <th scope="col" class="fs">
							<?php echo Yii::app()->controller->__trans('サイズ'); ?>
                        </th>
                        <th scope="col" class="memo">
							<?php echo Yii::app()->controller->__trans('メモ'); ?>
                        </th>
                        <th scope="col" class="bt_d">&nbsp;</th>
                    </tr>
                    <?php
					$uploadedFilList = BuildingPdfUpload::model()->findAll('building_id = '.$buildingDetails['building_id']);
					foreach($uploadedFilList as $list){
						$uploadedUser = AdminDetails::model()->findByAttributes(array('user_id'=>$list['added_by']));
					?>
                    <tr id="pdf_28202587">
                    	<td class="ttl_pdf">
                        	<p>
                            	<a href="<?php echo Yii::app()->baseUrl.'/buildingPdfUploads/'.$list['file_name']; ?>" target="_blank">
                                	<font><font><?php echo $list['title']; ?></font></font>
                                </a>
                           	</p>
                        </td>
                        <td class="date">
							<?php echo date('Y-m-d',strtotime($list['added_on'])); ?>
                        </td>
                        <td class="udn">
							<?php echo $uploadedUser->full_name; ?>
                        </td>
                        <td class="fs">
							<?php echo $list['file_size']; ?><?php echo Yii::app()->controller->__trans('KB'); ?>
                        </td>
                        <td class="memo">
							<?php echo $list['note']; ?>
                        </td>
                        <td class="bt_d">
                        	<a href="<?php echo Yii::app()->createUrl('building/deleteUploadedPdf',array('id'=>$list['upload_id'])); ?>" class="deletePdf">
                            	<i class="fa fa-times"></i>
                                削除
                            </a>
                        </td>
                    </tr>
                    <?php
					}
					?>
               	</tbody>
            </table>
            <div class="clear"></div>
        </div>
        <!--/tab_con-->
        
        <div class="tab_con floor-info"  id="tab8" style="display: none;">
        	<h4 class="ontable"><?php echo Yii::app()->controller->__trans('Floor Management Info'); ?></h4>
            <?php
			$relatedFloors = Floor::model()->findAll('building_id = '.$buildingDetails['building_id'] . ' ORDER BY cast(floor_down as SIGNED) ASC, cast(floor_up as SIGNED) ASC');
			//compart floor details
			$compartOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' and is_compart = 1');
			$cFloorIds = array();
			if(count($compartOwnerFloor) > 0){
				foreach($compartOwnerFloor as $cFloor){
					$cFloorIds[] = $cFloor['floor_id'];
				}
			}
			//shared floor details
			$sharedOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' and is_shared = 1');
			$sFloorIds = array();
			if(count($sharedOwnerFloor) > 0){
				foreach($sharedOwnerFloor as $sFloor){
					$sFloorIds[] = $sFloor['floor_id'];
				}
			}
			?>
            <table class="floor_data splite">
            	<thead>
                	<tr class="none">
                   	<th scope="col" class="check">&nbsp;</th><!--added kyoko-->
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
                        <th scope="col" class="bt">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="13" style="text-align:left;">
                        <?php
						//$commonOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' AND is_compart != 1 AND is_shared != 1 GROUP BY owner_company_name');
						
						$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingDetails['building_id'].'  AND `is_compart` != 1  AND `is_shared` != 1 GROUP BY ownership_management.ownership_type';
						$commonOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
						
                        if(isset($commonOwnerDetails) && count($commonOwnerDetails) > 0){
                            foreach($commonOwnerDetails as $common){
                        ?>
                            <span class="vendor-label">
                                <?php
                                $managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
                                
                                if(array_key_exists($common['ownership_type'],$managementArray)){
                                    echo $managementArray[$common['ownership_type']];
                                }													
                                ?>
                            </span>
                            <?php echo $common['owner_company_name'];?>
                        <?php
                            }
                        }
                        ?>
                        </td>
                    </tr>
                    <?php
					if(isset($relatedFloors) && count($relatedFloors) > 0){
						foreach($relatedFloors as $related){
							if(in_array($related['floor_id'],$cFloorIds)){
								continue;
							}
							if(in_array($related['floor_id'],$sFloorIds)){
								continue;
							}
							
							$related['floor_up'] = str_replace("'", '', $related['floor_up']);
							$related['floor_down'] = str_replace("'", '', $related['floor_down']);
							
							if($related['vacancy_info'] == '1'){
								$vacancyClass = 'empty';
								$vacLabel = Yii::app()->controller->__trans('空');
							}else{
								$vacancyClass = 'full';
								$vacLabel = Yii::app()->controller->__trans('満');
							}
					?>
                    <tr class="bg_b bg <?php $this->changeColor($related['floor_id']); ?>">
                    <th class="check_th"><input type="checkbox" name="show_frontend[]" <?php echo $related['show_frontend'] ? 'checked' : '';?> value="<?php echo $related['floor_id']?>" class="show_frontend"></th><!--added kyoko-->
                    	<th scope="row" class="code_d">
                        	<span class="rm-status <?php echo $vacancyClass; ?>">
                            	<font><font><?php echo $vacLabel; ?></font></font>
                            </span>
                            <span class="no-id"> <?php echo $related['floor_id']; ?></span>
                        </th>
                        <td class="no">
                        	<font><font>
							<?php
                            if(strpos($related['floor_down'], '-') !== false){
								$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $related['floor_down']);
							}else{
								$floorDown = $related['floor_down'];
							}
							$stairs = $floorDown;
							$stairs .= '階'.$related['floor_up'];
							echo $stairs.'  '.$related['roomname'];
							?>
                            </font></font>
                        </td>
                        <td class="spot">
                        	<font><font>
							<?php
                            if($related['area_ping'] != ""){
								echo $related['area_ping'].Yii::app()->controller->__trans('tsubo');
							}else{
								echo '-';
							}
							?>
                            </font></font>
                        </td>
                        <td class="prm">
                            <font><font> 
                  				<?php
									if(isset($related['rent_unit_price']) && $related['rent_unit_price'] != "" && $related['rent_unit_price'] != 0){
										echo ''.Yii::app()->controller->renderPrice($related['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').'';
									}else{
										if($related['rent_unit_price_opt'] != ''){
											if($related['rent_unit_price_opt'] == -1){
												echo Yii::app()->controller->__trans('undecided');
											}else if($related['rent_unit_price_opt'] == -2){
												echo Yii::app()->controller->__trans('ask');
											}
										}else{
											echo '-';
										}
									}
								?>
                  			</font></font>
                        </td>
                        <td class="csc">
                            <font><font> 
                            <?php
								if(isset($related['unit_condo_fee']) && $related['unit_condo_fee'] != "" && $related['unit_condo_fee'] != 0){
										echo ''.Yii::app()->controller->renderPrice($related['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').'';
									}else{
									if($related['unit_condo_fee_opt'] != ''){
										if($related['unit_condo_fee_opt'] == 0){
											echo Yii::app()->controller->__trans('none');
										}else if($related['unit_condo_fee_opt'] == -1){
											echo Yii::app()->controller->__trans('undecided');
										}else if($related['unit_condo_fee_opt'] == -2){
											echo Yii::app()->controller->__trans('ask');
										}else if($related['unit_condo_fee_opt'] == -3){
											echo '賃料に込み';
										}
									}else{
										echo '-';
									}
								}
							?>
                  			</font></font>
                       	</td>
                        <td class="dps">
                            <font><font> 
                  				<?php
									/*if(isset($related['total_deposit']) && $related['total_deposit'] != "0" && $related['total_deposit'] != ""){
										echo Yii::app()->controller->renderPrice($related['total_deposit']).' 円';
									}
									if($related['deposit_opt'] != ''){
										echo '<br/>';
										if($related['deposit_opt'] == -1){
											echo Yii::app()->controller->__trans('undecided');
										}else if($related['deposit_opt'] == -3){
											echo Yii::app()->controller->__trans('none');
										}else if($related['deposit_opt'] == -2){
											echo Yii::app()->controller->__trans('undecided･ask');
										}
									}*/
									if(isset($related['deposit_month']) &&  $related['deposit_month'] != ''){
										echo $related['deposit_month'].' ヶ月';
									}else{
										echo '-';
									}
								?>
                  			</font></font><br>
                  			<font><font> 
                  				<?php
									/*if(isset($related['deposit']) && $related['deposit'] != ""){
										echo '('.$related['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
									}else{
										echo '';
									}*/
								?>
                            </font></font>
                        </td>
                        <td class="money">
                        	<font><font>
                            <?php  
								if(isset($related['key_money_opt']) && $related['key_money_opt'] != ""){
									if($related['key_money_opt'] == 2){
										echo Yii::app()->controller->__trans('None');
									}elseif($related['key_money_opt'] == -1){
										echo Yii::app()->controller->__trans('Unknown');
									}elseif($related['key_money_opt'] == -2){
										echo Yii::app()->controller->__trans('undecided･ask');
									}else{
										echo '';
									}
								}else{
									echo '';
								}
								
								if(isset($related['key_money_month']) && $related['key_money_month'] != ""){
									echo $related['key_money_month'].Yii::app()->controller->__trans('month');
								}
							?>
                            </font></font>
                        </td>
                        <td class="am">
                            <font><font>
                  				<?php
									if(isset($related['repayment_opt']) && $related['repayment_opt'] != ""){
										if($related['repayment_opt'] == -3){
											echo Yii::app()->controller->__trans('None')."<br>"; 
										}elseif($related['repayment_opt'] == -4){
											echo Yii::app()->controller->__trans('Unknown')."<br>"; 
										}elseif($related['repayment_opt'] == -1){
											echo Yii::app()->controller->__trans('Undecided')."<br>"; 
										}elseif($related['repayment_opt'] == -2){
											echo Yii::app()->controller->__trans('Ask')."<br>"; 
										}elseif($related['repayment_opt'] == -5){
											echo Yii::app()->controller->__trans('Sliding')."<br>"; 
										}else{
											echo '';
										}
									}
									
									if(isset($related['repayment_reason']) && $related['repayment_reason'] != ""){
										if($related['repayment_reason'] == 1){
											echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
										}elseif($related['repayment_reason'] == 2){
											echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
										}else{
											echo '';
										}
									}
									
									if(isset($related['repayment_amt']) && $related['repayment_amt'] != ""){
										echo $related['repayment_amt'];
									}
									
									if(isset($related['repayment_amt_opt']) && $related['repayment_amt_opt'] != ""){
										if($related['repayment_amt_opt'] == 1){
											echo Yii::app()->controller->__trans('ヶ月'); 
										}elseif($related['repayment_amt_opt'] == 2){
											echo Yii::app()->controller->__trans('%')."<br>"; 
										}else{
											echo '';
										}
									}
								?>
                  			</font></font>
                        </td>
                        <td class="period">
                        	<font><font>
							<?php
                            if(isset($related['contract_period_duration']) && $related['contract_period_duration'] != ""){
								echo $related['contract_period_duration'];
								echo $related['contract_period_duration'] > 1 && $related['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
							}else{
								echo '-';
							}
							?>
                            </font></font>
                       	</td>
                        <td class="sc">
                        	<font><font>
							<?php
                            if(isset($related['move_in_date']) && $related['move_in_date'] != "" && (string)$related['move_in_date'] != "0"){
								echo $related['move_in_date'];
							}else{
								echo '-';
							}
							?>
                            </font></font>
                        </td>
                        <td class="update">
                        	<font><font>
							<?php
                            if(isset($related['modified_on']) && $related['modified_on'] != ""){
								if($related['modified_on'] != "0000-00-00 00:00:00"){
									echo date('Y.m.d',strtotime($related['modified_on']));
								}else{
									echo date('Y.m.d',strtotime($related['added_on']));
								}
							}else{
								echo '-';
							}
							?>
                            </font></font>
                        </td>
                        <td class="bt">
                        	<div class="bt_update">
                            	<a href="<?php echo Yii::app()->createUrl('floor/update',array('id'=>$related['floor_id'])); ?>" onclick="window.open('<?php echo Yii::app()->createUrl('floor/update',array('id'=>$related['floor_id'],'window'=>1)); ?>', 'newwindow', 'width=1052, height=600'); return false;"><?php echo Yii::app()->controller->__trans('Edit'); ?></a>
                                <a href="<?php echo Yii::app()->createUrl('floor/update',array('id'=>$related['floor_id'],'type'=>'duplicate')); ?>" onclick="window.open('<?php echo Yii::app()->createUrl('floor/update',array('id'=>$related['floor_id'],'type'=>'duplicate','window'=>1)); ?>', 'newwindow', 'width=1052, height=600'); return false;"><?php echo Yii::app()->controller->__trans('複製'); ?></a>
                           	</div>
                        </td>
                    </tr>
                    <?
						}
					}
					?>
                    
                    <?php                                
                   				 $query = 'SELECT om.*
									FROM ownership_management om
									INNER JOIN floor f ON om.floor_id = f.floor_id
									WHERE
										om.building_id = '.(int)$globalBuildingId.'
									AND om.is_compart = 1
									ORDER BY
										cast(f.floor_down AS SIGNED) ASC,
										cast(f.floor_up AS SIGNED) ASC,
										om.ownership_management_id DESC';
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
                                        $oDetails = OwnershipManagement::model()->findAll('building_id = '.$globalBuildingId.' and floor_id ='.$fId.' AND is_compart = 1');
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
                                    //foreach($oDetails as $sharedDetails){
                                        $floorDetails = Floor::model()->find('floor_id = '.$fId);
                                        if(!empty($floorDetails)){
											if($floorDetails['vacancy_info'] == '1'){
												$vacancyClass = 'empty';
												$vacLabel = Yii::app()->controller->__trans('空');
											}else{
												$vacancyClass = 'full';
												$vacLabel = Yii::app()->controller->__trans('満');
											}
                                        
                                ?>
                                    <tr class="bg_b bg">
                                    <th class="check_th"><input type="checkbox" name="show_frontend[]" <?php echo $floorDetails['show_frontend'] ? 'checked' : '';?> value="<?php echo $floorDetails['floor_id']?>" class="show_frontend"></th><!--added kyoko-->
                    	<th scope="row" class="code_d">
                        	<span class="rm-status <?php echo $vacancyClass; ?>">
                            	<font><font><?php echo $vacLabel; ?></font></font>
                            </span>
                            <font><font> <?php echo $floorDetails['floor_id']; ?></font></font>
                        </th>
                        <td class="no">
                        	<font><font>
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
                            </font></font>
                        </td>
                        <td class="spot">
                        	<font><font>
							<?php
                            if($floorDetails['area_ping'] != ""){
								echo $floorDetails['area_ping'].Yii::app()->controller->__trans('tsubo');
							}else{
								echo '-';
							}
							?>
                            </font></font>
                        </td>
                        <td class="prm">
                            <font><font> 
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
                  			</font></font>
                        </td>
                        <td class="csc">
                            <font><font> 
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
											echo '賃料に込み<br/>(含む)';
										}
									}else{
										echo '-';
									}
								}
							?>
                  			</font></font>
                       	</td>
                        <td class="dps">
                            <font><font> 
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
										echo '<br/>'.$floorDetails['deposit_month'].' ヶ月';
									}else{
										echo '-';
									}
								?>
                  			</font></font><br>
                  			<font><font> 
                  				<?php
									/*if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != ""){
										echo '('.$floorDetails['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
									}else{
										echo '';
									}*/
								?>
                            </font></font>
                        </td>
                        <td class="money">
                        	<font><font>
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
                            </font></font>
                        </td>
                        <td class="am">
                            <font><font>
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
                  			</font></font>
                        </td>
                        <td class="period">
                        	<font><font>
							<?php
                            if(isset($floorDetails['contract_period_duration']) && $floorDetails['contract_period_duration'] != ""){
								echo $floorDetails['contract_period_duration'];
								echo $floorDetails['contract_period_duration'] > 1 && $floorDetails['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
							}else{
								echo '-';
							}
							?>
                            </font></font>
                       	</td>
                        <td class="sc">
                        	<font><font>
							<?php
                            if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != "0"){
								echo $floorDetails['move_in_date'];
							}else{
								echo '-';
							}
							?>
                            </font></font>
                        </td>
                        <td class="update">
                        	<font><font>
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
                            </font></font>
                        </td>
                        <td class="bt">
                        	<div class="bt_update">
                            	<a href="<?php echo Yii::app()->createUrl('floor/update',array('id'=>$floorDetails['floor_id'])); ?>" onclick="window.open('<?php echo Yii::app()->createUrl('floor/update',array('id'=>$floorDetails['floor_id'],'window'=>1)); ?>', 'newwindow', 'width=1052, height=600'); return false;"><?php echo Yii::app()->controller->__trans('Edit'); ?></a>
                                <a href="<?php echo Yii::app()->createUrl('floor/update',array('id'=>$floorDetails['floor_id'],'type'=>'duplicate')); ?>" onclick="window.open('<?php echo Yii::app()->createUrl('floor/update',array('id'=>$floorDetails['floor_id'],'type'=>'duplicate','window'=>1)); ?>', 'newwindow', 'width=1052, height=600'); return false;"><?php echo Yii::app()->controller->__trans('複製'); ?></a>
                           	</div>
                        </td>
                    </tr>
                                <?php
                                        }
                                    //}
                                }
                            }
                            ?>
                    <?php
					//$allSharedOwnerDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' AND is_shared = 1');
					$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$globalBuildingId.' AND `is_shared` = 1';
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
						<td colspan="13" style="text-align:left;">
                        	<span class="labelSharedInSingle">共用オーナーフロア</span><br/>
                        	<?php foreach($oDetails as $own){?>							
							<span class="vendor-label">
								<?php
								$managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
								if(array_key_exists($own['ownership_type'],$managementArray)){
									echo $managementArray[$own['ownership_type']];
								}
								?>
							</span>
							<?php echo $own['owner_company_name'];?>
                            <?php } ?>
						</td>
					</tr>
					<?php
							//foreach($oDetails as $sharedDetails){
								$floorDetails = Floor::model()->findByPk($fId);
								if($floorDetails['vacancy_info'] == '1'){
									$vacancyClass = 'empty';
									$vacLabel = Yii::app()->controller->__trans('空');
								}else{
									$vacancyClass = 'full';
									$vacLabel = Yii::app()->controller->__trans('満');
								}
					?>
					<tr class="bg_b bg">
                   	<th class="check_th"><input type="checkbox" name="show_frontend[]" <?php echo $floorDetails['show_frontend'] ? 'checked' : '';?> value="<?php echo $floorDetails['floor_id']?>" class="show_frontend"></th><!--added kyoko-->
                    	<th scope="row" class="code_d">
                        	<span class="rm-status <?php echo $vacancyClass; ?>">
                            	<font><font><?php echo $vacLabel; ?></font></font>
                            </span>
                            <font><font> <?php echo $floorDetails['floor_id']; ?></font></font>
                        </th>
                        <td class="no">
                        	<font><font>
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
                            </font></font>
                        </td>
                        <td class="spot">
                        	<font><font>
							<?php
                            if($floorDetails['area_ping'] != ""){
								echo $floorDetails['area_ping'].Yii::app()->controller->__trans('tsubo');
							}else{
								echo '-';
							}
							?>
                            </font></font>
                        </td>
                        <td class="prm">
                            <font><font> 
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
                  			</font></font>
                        </td>
                        <td class="csc">
                            <font><font> 
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
											echo '賃料に込み<br/>(含む)';
										}
									}else{
										echo '-';
									}
								}
							?>
                  			</font></font>
                       	</td>
                        <td class="dps">
                            <font><font> 
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
										echo ''.$floorDetails['deposit_month'].' ヶ月';
									}else{
										echo '-';
									}
								?>
                  			</font></font><!--<br>-->
                  			<font><font> 
                  				<?php
									/*if(isset($floorDetails['deposit']) && $floorDetails['deposit'] != ""){
										echo '('.$floorDetails['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
									}else{
										echo '';
									}*/
								?>
                            </font></font>
                        </td>
                        <td class="money">
                        	<font><font>
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
                            </font></font>
                        </td>
                        <td class="am">
                            <font><font>
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
                  			</font></font>
                        </td>
                        <td class="period">
                        	<font><font>
							<?php
                            if(isset($floorDetails['contract_period_duration']) && $floorDetails['contract_period_duration'] != ""){
								echo $floorDetails['contract_period_duration'];
								echo $floorDetails['contract_period_duration'] > 1 && $floorDetails['contract_period_duration'] != "" ? Yii::app()->controller->__trans('years') : Yii::app()->controller->__trans('year');
							}else{
								echo '-';
							}
							?>
                            </font></font>
                       	</td>
                        <td class="sc">
                        	<font><font>
							<?php
                            if(isset($floorDetails['move_in_date']) && $floorDetails['move_in_date'] != "" && (string)$floorDetails['move_in_date'] != "0"){
								echo $floorDetails['move_in_date'];
							}else{
								echo '-';
							}
							?>
                            </font></font>
                        </td>
                        <td class="update">
                        	<font><font>
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
                            </font></font>
                        </td>
                        <td class="bt">
                        	<div class="bt_update">
                            	<a href="<?php echo Yii::app()->createUrl('floor/update',array('id'=>$floorDetails['floor_id'])); ?>" onclick="window.open('<?php echo Yii::app()->createUrl('floor/update',array('id'=>$floorDetails['floor_id'],'window'=>1)); ?>', 'newwindow', 'width=1052, height=600'); return false;"><?php echo Yii::app()->controller->__trans('Edit'); ?></a>
                                <a href="<?php echo Yii::app()->createUrl('floor/update',array('id'=>$floorDetails['floor_id'],'type'=>'duplicate')); ?>" onclick="window.open('<?php echo Yii::app()->createUrl('floor/update',array('id'=>$floorDetails['floor_id'],'type'=>'duplicate','window'=>1)); ?>', 'newwindow', 'width=1052, height=600'); return false;"><?php echo Yii::app()->controller->__trans('複製'); ?></a>
                           	</div>
                        </td>
                    </tr>
					<?php
							//}
						}
					}
					?>
                </tbody>
            </table>
            <h4 class="ontable"><font><font>フロアの追加・削除</font></font></h4>
            <form method="post">
                <table class="floor_edit">
                    <tbody>
                      <!--added kyoko-->
                       <tr>
                       <th colspan="2"><?php echo Yii::app()->controller->__trans('show checked floor to premium office'); ?></th>
                       <td><input type="button" value="<?php echo Yii::app()->controller->__trans('Show'); ?>" class="bt_show" id="show_frontend"></td>
                       </tr>
                        <tr>
                            <th scope="row"><?php echo Yii::app()->controller->__trans('Add floor'); ?></th>
                            <td>
                                <input type="hidden" name="currentBuildingId" id="currentBuildingId" value="<?php echo $buildingDetails['building_id']; ?>"/>
                                <input type="text" name="add_floor_num" maxlength="1" class="addFastFloorNum" id="addFastFloorNum">
                                <font><font>個のフロアを追加する</font></font>
                            </td>
                            <td class="bt">
                                <input type="button" value="追加" class="bt_add btnAddFastFloor">
                                <!--<input type="button" value="Add" class="bt_add btnAddFastFloor">-->
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><font><font>フロアの削除</font></font></th>
                            <td>
                                <input type="hidden" name="currentFloorId" id="currentFloorId" value="<?php echo $floorDetails['floor_id']; ?>"/>
                                <select name="delete_floor_id" class="selectedFloorToDelete" id="selectedFloorToDelete">
                                    <option value=""><font><font>-</font></font></option>
                                    <?php
                                        $relatedAllFloorList = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
                                        if(isset($relatedAllFloorList) && count($relatedAllFloorList) > 0 ){
                                            foreach($relatedAllFloorList as $allFloor){
                                                if(strpos($allFloor['floor_down'], '-') !== false){
                                                    $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $allFloor['floor_down']);
                                                }else{
                                                    $floorDown = $allFloor['floor_down'];
                                                }
                                    ?>
                                    <option value="<?php echo $allFloor['floor_id']; ?>"> <font><font> <?php echo $allFloor['floor_id']; ?> <?php echo "(".$floorDown; ?> <?php echo $allFloor['floor_up'] != "" ? " ~ ".$allFloor['floor_up'] : ""; ?> <?php echo " ".Yii::app()->controller->__trans("階")." ".$allFloor['roomname'].")"; ?> </font></font> </option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <span class="att">警告：この操作は取り戻せません。細心の注意を払って実施して下さい</span>
                            </td>
                            <td class="bt">
                                <font><font>
                                    <input type="button" value="削除" class="bt_delete btnDeleteFloor">
                                    <!--<input type="button" value="you work" class="bt_delete btnDeleteFloor">-->
                                </font></font>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!--<input name="b_no" value="76389" type="hidden">
                <input type="hidden" name="postmode" value="floor_add_delete">-->
            </form>
            <div class="clear"></div>
        </div><!--/tab_con--> 
        
      </div>
      <!--/tabs_content--> 
    </div>    
    <!-- post navigation -->    
    <!-- /post navigation -->    
  </div>
  <!--end of postbox--> 
</div>

<!--Popup Box Start-->
<div class="modal-box hide updateBuildingInfo">
  <div class="content">
    <div class="changeLoaderOverly" style="display:none;"> <img src="<?php echo Yii::app()->baseUrl.'/images/ins.gif' ?>" class="loaderImage"/> </div>
    <div class="changeLoaderOverlyMsg" style="display:none;"> <span class="responseMsg"></span> </div>
    <div class="box-header">
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Update Building Info'); ?></h2>
    </div>
    <div class="box-content divChangeInfo">
      <?php /*?><form name="frmBusinessType" id="frmBusinessType" method="post" class="text-center" action="">
        <input type="hidden" name="id" id="id" value="0" />
        <input type="text" name="typeName" id="typeName" class="typeName form-input" placeholder="Business Type Name" value="" required/>
        <div class="div_error"><span class="form-error"></span></div>
        <button type="button" class="btn-default btnSubmit"><?php echo Yii::app()->controller->__trans('Save Changes'); ?></button>
      </form><?php */?>
    </div>
  </div>
</div>
<!--Popup Box End--> 

<!--Modal Popup for Add Transmission matters-->
<div class="modal-box hide" id="modalTrans">
  <div class="content transmissionContent">
    <div class="box-header">
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Transmission Matters'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
      <table>
        <tr>
          <td><?php echo Yii::app()->controller->__trans('Input'); ?></td>
          <td><input type="hidden" name="buildId" id="buildId" class="buildId" value="<?=$globalBuildingId?>" />
            <textarea class="inputText" id="inputText" name="inputText" style="resize:none;"></textarea>
		  </td>
        </tr>
        <tr>
          <td colspan="2">
			<button type="button" class="btnAddTrans"><?php echo Yii::app()->controller->__trans('Add'); ?></button>
		  </td>
        </tr>
      </table>
      <div class="buildingTransmissionMatters listScroll"></div>
    </div>
  </div>
</div>

<!--Modal Popup for append management history-->
<div class="modal-box hide" id="appendManagementModal">
  <div class="content managementHistoryContent">
    <div class="box-header">
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Building management edit・add'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
    	<div class="messageManagement hide"></div>
      <div class="formbox f-full owner-info">
        <div class="table-inner">
        	<?php
			$divcls = $divlbl = '';
			if($isCompart != ""){
				$divcls = 'color-blue';
				$divlbl = $isCompart;
			}
			
			if($isShared != ""){
				$divcls = 'color-orange';
				$divlbl = $isShared;
			}
			?>
        	<div class="differentOwner <?php echo $divcls; ?>"><?php echo $divlbl; ?></div>
			<form name="frmAddNewHistory" id="frmAddNewHistory" class="frmAddNewHistory" action="">
				<input type="hidden" name="hdnHistFloorId" id="hdnHistFloorId" value="<?php echo isset($_GET['id']) && $_GET['id'] != "" ? $_GET['id'] : 0; ?>"/>
				<input type="hidden" name="hdnBillId" id="hdnBillId" value="<?php echo $buildingDetails['building_id']; ?>"/>
				<?php /*?><table class="edit_input f_info_b mline tb-floor one-col mix-col">
				  <tbody>
					<tr>
					  <th class="minsize"><?php echo Yii::app()->controller->__trans('this floor is condominium ownership'); ?></th>
					  <td><label class="rd2">
						  <input type="radio" value="1" name="is_condominium_ownership">
						  <?php echo Yii::app()->controller->__trans('YES'); ?> </label>
						<label class="rd2">
						  <input type="radio" value="0" name="is_condominium_ownership">
						 <?php echo Yii::app()->controller->__trans('NO'); ?>  </label></td>
					</tr>
				  </tbody>
				</table><?php */?>
				<table class="edit_input f_info mt tb-floor one-col mix-col">
				  <tbody>
					<tr>
					  <th><?php echo Yii::app()->controller->__trans('trader ID'); ?></th>
					  <td colspan="3">
						<input type="text" name="searchTraderText" class="ty3 searchTraderText" id="searchTraderText" style="float:left;">
						<input type="button" name="btnSearchTrader" id="btnSearchTrader" class="btnSearchTrader bt_entry autoWidth" value="業者を検索">
						<br/>
						<div class="traderResp">
                        	<span id="owner_id_select">
                            	<select id="tradersList"  class="auto tradersList" name="trader_id">
                                	<option value="0"><?php echo Yii::app()->controller->__trans('saved traders'); ?>↓</option>
									<?php
                                    $tradersDetails = Traders::model()->findAll('is_active = 1 AND building_id = '.$buildingDetails['building_id'].' AND floor_id = '.$_GET['id']);
									if(isset($tradersDetails) && count($tradersDetails) > 0){
										foreach($tradersDetails as $tradersList){
									?>
                                    <option value="<?php echo $tradersList['trader_id']; ?>" ><?php echo $tradersList['traderId'].' '.$tradersList['trader_name']; ?></option>
									<?php
                                    	}
									}else{
									?>
                                    <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available'); ?></option>
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
					   <!-- ←
						<input type="text" name="newTrader" id="newTrader" class="ty1 newTrader">
						<input type="button" name="add-trader" id="btnAddTrader" class="btnAddTrader bt_entry autoWidth" value="Add Traders">--></td>
					</tr>
					<tr>
					  <th><?php echo Yii::app()->controller->__trans('ownership type'); ?></th>
					  <td><select name="ownership_type" id="bo_type" data-role="none" class="ownership_type" required>
						  <option value="">-</option>
						  <?php 
						  foreach ($aVendorType as $vendorValue => $vendorName)
						  {
							echo '<option value="'. $vendorValue .'" >'. $vendorName .'</option>';
						  }
						  ?>
						</select></td>
					  <th><?php echo Yii::app()->controller->__trans('Form of Transaction'); ?></th>
					  <td><select name="management_type" id="bo_contract" class="management_type" data-role="none">
						  <option value="">-</option>
						  <option value="-1"><?php echo Yii::app()->controller->__trans('unknown'); ?></option>
						  <option value="1">専任媒介</option>
						  <option value="2">一般媒介</option>
						  <option value="3">代理</option>
						  <option value="4">貸主</option>
						</select>
					  </td>
					</tr>
					<tr>
					  <th><?php echo Yii::app()->controller->__trans('Window'); ?></th>
					  <td colspan="3"><input type="checkbox" name="is_current" id="is_current" class="is_current" value="1" /><?php echo Yii::app()->controller->__trans('Setting this trader owner properties window');?></td>
					</tr>
					<tr>
					  <th><?php echo Yii::app()->controller->__trans('company name'); ?></th>
					  <td colspan="3"><input type="text" name="owner_company_name" id="bo_name" value="" class="ty6 owner_company_name" required></td>
					</tr>
					<tr>
					  <th><?php echo Yii::app()->controller->__trans('contact address'); ?></th>
					  <td colspan="3"><input type="text" name="company_tel" id="bo_tel1" value="" class="ty6 company_tel"></td>
					</tr>
					<tr>
					  <th><?php echo Yii::app()->controller->__trans('person in charge1'); ?></th>
					  <td><input type="text" name="person_in_charge1" id="bo_rep1" value="" class="ty3 person_in_charge1"></td>
					  <th><?php echo Yii::app()->controller->__trans('person in charge2'); ?></th>
					  <td><input type="text" name="person_in_charge2" id="bo_rep2" value="" class="ty3 person_in_charge2"></td>
					</tr>
					<tr>
					  <th><?php echo Yii::app()->controller->__trans('charge'); ?></th>
					  <td colspan="3">
						<label class="rd2">
							<input type="radio" name="charge" value="unknown" class="radiUnknown">
							<?php echo Yii::app()->controller->__trans('unknown'); ?>
						</label>
						<label class="rd2">
							<input type="radio" name="charge" value="ask" class="radiAsk">
							<?php echo Yii::app()->controller->__trans('ask'); ?>
						</label>
						<label class="rd2">
						  <input type="radio" name="charge" value="undecided" class="radiUndecided">
						  <?php echo Yii::app()->controller->__trans('undecided'); ?>  </label>
						<label class="rd2">
						  <input type="radio" name="charge" value="<?php echo Yii::app()->controller->__trans('none'); ?>" class="radiNone">
						  <?php echo Yii::app()->controller->__trans('none'); ?>  </label>
						|
						<input type="text" name="change_txt" id="bo_fee" size="5" value="" class="ty8 change_txt"></td>
					</tr>
				  </tbody>
				</table>
				<table class="edit_input f_info_b mline tb-floor one-col mix-col">
				  <tbody>
					<tr>
					  <td align="center"><button type="button" name="btnAddNewHistory" class="btnAddNewHistory" id="btnAddNewHistory"><?php echo Yii::app()->controller->__trans('Append History'); ?> </button></td>
					</tr>
				  </tbody>
				</table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Modal Popup for Add Free Rent-->
<div class="modal-box hide" id="modalFreeRent">
  <div class="content transmissionContent">
    <div class="box-header">
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Free Rent'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
      <form name="frmAddFreeRent" id="frmAddFreeRent" class="frmAddFreeRent" data-action="<?php echo Yii::app()->createUrl('building/saveFreeRent'); ?>">
        <table>
          <tr>
            <td><?php echo Yii::app()->controller->__trans('Free Rent'); ?></td>
            <td><input type="hidden" name="rentBuildId" id="rentBuildId" class="rentBuildId" value="<?=$globalBuildingId?>" />
              <input type="text" name="freeRentMonth" id="freeRentMonth" class="freeRentMonth" style="width:50% !important;"/>
              &nbsp;&nbsp;<?php echo Yii::app()->controller->__trans('Month'); ?> </td>
          </tr>
          <tr>
            <td><?php echo Yii::app()->controller->__trans('Expiration date of the information optional'); ?> </td>
            <td><input type="text" name="expirationDate" id="expirationDate" class="expirationDate" style="width:50% !important;"/></td>
          </tr>
          <tr>
            <td><?php echo Yii::app()->controller->__trans('対象フロア'); ?></td>
            <td><?php
                        $getFoorList = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
                        if(isset($getFoorList) && count($getFoorList) > 0){
                            foreach($getFoorList as $floor){
                                if($floor['floor_down'] == "" && $floor['area_m'] == ""){
                            ?>
              <input type="checkbox" name="rentFloorId[]" id="rentFloorId" class="rentFloorId" value="<?php echo $floor['floor_id']; ?>"/>
              -
              <?php
                                }else{
                            ?>
              <input type="checkbox" name="rentFloorId[]" id="rentFloorId" class="rentFloorId" value="<?php echo $floor['floor_id']; ?>"/>
              <?php
			  if(strpos($floor['floor_down'], '-') !== false){
				  $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
			  }else{
				  $floorDown = $floor['floor_down'];
			  }
			  ?>
              <?php echo $floorDown; ?><?php echo isset($floor['floor_up']) && $floor['floor_up'] != "" ? " ~ ".$floor['floor_up'] : ""; ?><?php echo isset($floor['area_ping']) && $floor['area_ping'] != "" ? "/".$floor['area_ping'].Yii::app()->controller->__trans('tsubo') : ""; ?>
              <?php
                                }
                            }
                        }
                        ?></td>
          </tr>
          <tr>
            <td colspan="2"><button type="button" class="btnAddFreeRent"><?php echo Yii::app()->controller->__trans('Add');  ?></button></td>
          </tr>
        </table>
      </form>
      <div class="buildingFreeRents listScroll"></div>
    </div>
  </div>
</div>

<!--Modal Popup for Add Rent Negitiation-->
<div class="modal-box hide" id="modalRentNegitiation">
  <div class="content transmissionContent">
    <div class="box-header">
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Rent Negotiation'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
      <form name="frmAddRentNegotiation" id="frmAddRentNegotiation" class="frmAddRentNegotiation" data-action="<?php echo Yii::app()->createUrl('building/saveRentNegotiation'); ?>" onkeypress="return event.keyCode != 13;">
        <table>
          <tr>
            <td><?php echo Yii::app()->controller->__trans('Negotiation Type'); ?></td>
            <td style="text-align:left;"><input type="hidden" name="negBuildId" id="negBuildId" class="negBuildId" value="<?=$globalBuildingId?>" />
              ※<?php echo Yii::app()->controller->__trans('日付など金額以外を入力する際は「その他交渉情報」を選択してください。'); ?><br/>
              <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="1" data-label="底値" data-pre="¥" data-post="(共益費込み)" checked />
              坪単価(底値)
              
              <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="5"  data-label="目安値" data-pre="¥" data-post="(共益費込み)" />
              坪単価(目安値)
              
              
              <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="2" data-label="" data-pre="" data-post="ヶ月"/>
            <?php echo Yii::app()->controller->__trans('Deposit negotiation value'); ?> 
            
              <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="3" data-label="" data-pre="" data-post="ヶ月"/>
             <?php echo Yii::app()->controller->__trans('礼金交渉値'); ?> 
             
              <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="4" data-label="" data-pre="" data-post=""/>
             <?php echo Yii::app()->controller->__trans('Other negotiations information'); ?>  
             
             </td>
          </tr>
          <tr>
            <td><span class="inputLab"><?php echo Yii::app()->controller->__trans('Input'); ?></span></td>
            <td><span class="inputPre"></span><input type="text" name="negotiationAmt" id="negotiationAmt" class="negotiationAmt" style="width:50% !important;"/>
              &nbsp;&nbsp;&nbsp;
			  <span class="inputPost"><?php echo Yii::app()->controller->__trans('Yen / tsubo'); ?></span> </td>
          </tr>
          <tr class="inputNote">
          	<td><span><?php echo Yii::app()->controller->__trans('Note'); ?></span></td>
          	<td>
          		<textarea class="negotiationNote" id="negotiationNote" name="negotiationNote" style="resize:none;"></textarea>
          	</td>
          </tr>
          <tr>
            <td>
				<?php echo Yii::app()->controller->__trans('対象フロア'); ?>
            	<span>
                	<input type="checkbox" name="dispEmptyOnly" id="dispEmptyOnly" class="dispEmptyOnly"/>
                    <?php echo Yii::app()->controller->__trans('空きのみ表示'); ?>
                </span>
            </td>
            <td><?php
                        $getFoorList = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
                        if(isset($getFoorList) && count($getFoorList) > 0){
                            foreach($getFoorList as $floor){
								$floorEmptStatus  = '';
								if($floor['vacancy_info'] == 1){
									$floorEmptStatus  = 'floorEmpt';
								}else{
									$floorEmptStatus  = 'floorNotEmpt';
								}
                                if($floor['floor_down'] == "" && $floor['area_ping'] == ""){
                            ?>
                            <span class="negFloor <?php echo $floorEmptStatus; ?>">
                            	<input type="checkbox" name="negFloorId[]" id="negFloorId" class="negFloorId" value="<?php echo $floor['floor_id']; ?>"/> -
                            </span>
              <?php
                                }else{
                            ?>
                            <span class="negFloor <?php echo $floorEmptStatus; ?>">
              <input type="checkbox" name="negFloorId[]" id="negFloorId" class="negFloorId" value="<?php echo $floor['floor_id']; ?>"/>
              <?php
			  if(strpos($floor['floor_down'], '-') !== false){
				  $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
			  }else{
				  $floorDown = $floor['floor_down'];
			  }
			  ?>
              <?php echo $floorDown; ?><?php echo isset($floor['floor_up']) && $floor['floor_up'] != "" ? " ~ ".$floor['floor_up'] : ""; ?><?php echo ' 階'; ?><?php echo isset($floor['area_ping']) && $floor['area_ping'] != "" ? "/".$floor['area_ping']." 坪" : ""; ?>
              </span>
              <?php
                                }
                            }
                        }
                        ?></td>
          </tr>
          <tr>
            <td><?php echo Yii::app()->controller->__trans('The person in charge / information source'); ?>  </td>
            <td><select name="personIncharge" id="personIncharge" class="personIncharge">
                <option value="0">-</option>
                <?php
                        	$userList = Users::model()->findAll();
							if(isset($userList) && count($userList) > 0){
								$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
								$logged_user_id = $user->user_id;
								foreach($userList as $users){
									$sele = '';
									$userDetails = AdminDetails::model()->find('user_id = '.$users['user_id']);									
									if($logged_user_id == $userDetails['user_id']){
										$sele = 'selected';
									}
							?>
                <option value="<?php echo $userDetails['user_id']; ?>" <?php echo $sele; ?>><?php echo $userDetails['full_name']; ?></option>
                <?php
								}
							}
						?>
              </select></td>
          </tr>
          <tr>
            <td colspan="2"><button type="button" class="btnAddRentNegotiation"><?php echo Yii::app()->controller->__trans('Add'); ?></button></td>
          </tr>
        </table>
      </form>
      <form method="post" id="buildingRentNegotiationsForm">
      	<div class="buildingRentNegotiations listScroll"></div>
      </form>
    </div>
  </div>
</div>

<!--Modal Popup for Change Map Access-->
<div class="modal-box hide" id="modalChangeMapAccess">
  <div class="content1 transmissionContent">
    <div class="box-header">
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Map Access'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
      <form name="frmChangeMapAccess" id="frmChangeMapAccess" class="frmChangeMapAccess" data-action="<?php echo Yii::app()->createUrl('building/saveStaionReachTime'); ?>">
        <input type="hidden" name="mapBuildId" id="mapBuildId" class="mapBuildId" value="<?=$globalBuildingId?>"/>
		<table>
        	<tr>
            	<td><?php echo Yii::app()->controller->__trans('Station Name'); ?></td>
            	<td><?php echo Yii::app()->controller->__trans('Station Name English'); ?></td>
                <td><?php echo Yii::app()->controller->__trans('Station walk fraction'); ?></td>
            </tr>
		<?php
		$buildingStationList = BuildingStation::model()->findAll('building_id = '.$buildingDetails['building_id']);
		if(isset($buildingStationList) && count($buildingStationList) > 0){
			foreach($buildingStationList as $stations){
			?>
            <tr>
            	<input type="hidden" name="hdnBuildingStationId[]" id="hdnBuildingStationId" class="hdnBuildingStationId" value="<?php echo $stations['building_station_id']; ?>"/>
            	<td><?php echo $stations['name']; ?></td>
            	<td>
                	<input type="text" name="stationNameEn[]" id="stationNameEn" class="stationNameEn" value="<?php echo $stations['name_en']; ?>"/>
                </td>
                <td>
                    <?php
					$timing = $stations['time'];
					?>
                	<input type="text" name="stationReachTime[]" id="stationReachTime" class="stationReachTime" value="<?php echo $timing; ?>" style="width:100px;"/> <?php echo Yii::app()->controller->__trans('Minute'); ?>
                </td>
            </tr>
            <?php
			}
		}
		?>
        	<tr>
            	<td colspan="2"><button type="button" class="btnChangeMapAccess"><?php echo Yii::app()->controller->__trans('Add'); ?></button></td>
          	</tr>
        </table>
      </form> 
    </div>
  </div>
</div>

<!--Modal Popup for Building Picture Upload-->
<div class="modal-box hide" id="modalUploadPicture">
  <div class="content transmissionContent">
    <div class="box-header">
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Upload Picture'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
    	<form id="frmUpBuildingPicture" method="post" class="frmUpBuildingPicture uploadPictures" data-action="<?php echo Yii::app()->createUrl('buildingPictures/uploadBuildingPicture'); ?>" enctype="multipart/form-data">
        	<div id="drop" class="drop">
            	<?php echo Yii::app()->controller->__trans('Drop Here'); ?>
                <a>	<?php echo Yii::app()->controller->__trans('Browse'); ?></a>
                <input type="file" name="upl" multiple />
            </div>
            <ul>
            	<!-- The file uploads will be shown here -->
            </ul>
            <table class="tblUploadPicture">
            	<tr>
                	<td>
                    	<input type="hidden" name="hdnUploadSection" id="hdnUploadSection" class="hdnUploadSection" value="0"/>
                    	<input type="hidden" name="hdnFileNames" id="hdnFileNames" class="hdnFileNames" value="0"/>
                    	<input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo $globalFloorId?>"/>
                        <input type="hidden" name="hdnUpBuildId" id="hdnUpBuildId" class="hdnUpBuildId" value="<?php echo $buildingDetails['building_id']; ?>"/>
                    	<button type="button" class="btnUpBuildingPicture"><?php echo Yii::app()->controller->__trans('Upload'); ?></button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
  </div>
</div>

<!--Modal Popup for Floor Picture Upload-->
<div class="modal-box hide" id="modalUploadFloorPicture">
  <div class="content transmissionContent">
    <div class="box-header">
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Upload Picture'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
    	<form id="frmUpFloorPicture" method="post" class="frmUpFloorPicture uploadPictures" data-action="<?php echo Yii::app()->createUrl('floorPictures/uploadFloorPicture'); ?>" enctype="multipart/form-data">
        	<div id="dropFloor" class="drop">
            	<?php echo Yii::app()->controller->__trans('Drop Here'); ?>
                <a>	<?php echo Yii::app()->controller->__trans('Browse'); ?></a>
                <input type="file" name="uplFloor" multiple />
            </div>
            <ul>
            	<!-- The file uploads will be shown here -->
            </ul>
            <table class="tblUploadPicture">
            	<tr>
                	<td>
                    	<input type="hidden" name="hdnUploadFloorSection" id="hdnUploadFloorSection" class="hdnUploadFloorSection" value="0"/>
                    	<input type="hidden" name="hdnFloorFileNames" id="hdnFloorFileNames" class="hdnFloorFileNames" value="0"/>
                        <input type="hidden" name="hdnSingleFloorId" id="hdnSingleFloorId" class="hdnSingleFloorId" value="0"/>
                        <input type="hidden" name="hdnMultiFloorId" id="hdnMultiFloorId" class="hdnMultiFloorId" value="0"/>
                        <input type="hidden" name="hdnUpBuildId" id="hdnUpBuildId" class="hdnUpBuildId" value="<?php echo $buildingDetails['building_id']; ?>"/>
                    	<button type="button" class="btnUpFloorPicture"><?php echo Yii::app()->controller->__trans('Upload'); ?></button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
  </div>
</div>
