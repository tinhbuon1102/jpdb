                                   <tr class="<?php echo ($list['info']['vacancy_info'] ? 'row-vacant' : 'row-novacant') ?>">
                                    <td colspan="6" style="text-align:left;">
                                        <span class="labelSharedInSingle" style="background-color: #12AAEB; margin-bottom: 5px">Windows</span><br/>
                                                                                
                                        <span class="vendor-label">
                                          <?= $list['windows'] ?>
                                        </span>
                                        
                                    </td>
                                    <td colspan="6" style="text-align:left;">
                                        <span class="labelSharedInSingle" style="background-color: #2773C0; margin-bottom: 5px">Owners</span><br/>
                                                                                
                                        <span class="vendor-label">
                                           
                                          <?= $list['owners'] ?>
                                        </span>
                                        
                                    </td>
                                    </tr>
 			<tr class="trFloor <?php echo ($list['info']['vacancy_info'] ? 'row-vacant' : 'row-novacant') ?> <?php $this->changeColor($list['info']['floor_id']); ?>"  data-href='<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$list['info']['floor_id'])); ?>'>
                            	<td>
                                	<input type="hidden" name="hdnBuildingId" id="hdnBuildingId" class="hdnBuildingId" value="<?php echo $buildingList['building_id']; ?>" />
                                    <input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo $list['info']['floor_id']; ?>" />
                                    <?php
									$cartDetails = Cart::model()->findAll('user_id = '.$logged_user_id.' AND floor_id = '.$list['info']['floor_id'].' AND building_id = '.$buildingList['building_id']);
									$disabled = '';
									$lbl = '追加';
									$lbl1 = '追加';
									$val = 0;
									$addedcss = 'add';
									if(isset($cartDetails) && count($cartDetails) > 0){
										$addedcss = 'remove';
										$disabled = 'disabled';
										$lbl = '削除';
										$lbl1 = '削除';
										$val = 1;
									}
									?>
                                    <button type="button" class="btn btn-primary btnAddToCart <?php echo $addedcss;?>" <?php //echo $disabled; ?> value="<?php echo $val; ?>"><?php echo $lbl1; ?></button>
                               	</td>
                                <td>
                                	<?php
										$vacInfo = $list['info']['vacancy_info'];
										if($vacInfo == 1){
											$vacInfo = "<span style='color:blue'>".'空'."</span>";
											
										}elseif($vacInfo == 0){
											$vacInfo = "<span style='color:red'>".'満'."</span>";
										}else{
											$vacInfo = '';
										}
										echo $vacInfo;
										if($list->preceding_user == 1){
												echo '</br><span class="senko" style="background-color:yellow">'.Yii::app()->controller->__trans('先行有').'</span>';
											}
									?>
                               	</td>
                                <td>
                                    <?php
										if(strpos($list['info']['floor_down'], '-') !== false){
											$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $list['info']['floor_down']);
										}else{
											$floorDown = $list['info']['floor_down'];
										}
										$stairs = $floorDown;
										$stairs .= '階'.$list['info']['floor_up'];
										echo $stairs.'  '.$list['info']['roomname'];
										
										echo HelperFunctions::showFixedFloorText($list['info']);
									?>
                                </td>
                                <td>
                                	<?php
										$area = $list->area_ping;
										if($area != ""){
											echo $area.' '.Yii::app()->controller->__trans('tsubo');
										}else{
											echo '-';
										}
									?>
                                </td>
                                <td class="rent-unit">
									<?php
                                        if(isset($list['info']['total_rent_price']) && $list['info']['total_rent_price'] != ""){
                                            echo Yii::app()->controller->renderPrice($list['info']['total_rent_price']).'円';
                                        }else{
                                            if($list['info']['rent_unit_price_opt'] != ''){
                                                if($list['info']['rent_unit_price_opt'] == -1){
                                                    echo Yii::app()->controller->__trans('undecided');
                                                }else if($list['info']['rent_unit_price_opt'] == -2){
                                                    echo Yii::app()->controller->__trans('ask');
                                                }
                                            }else{
                                                echo '';
                                            }
                                        }
                                    ?>
                                    <br>
                                    <?php
										if(isset($list['info']['rent_unit_price']) && $list['info']['rent_unit_price'] != "" && $list['info']['rent_unit_price'] != 0){
											echo '('.Yii::app()->controller->renderPrice($list['info']['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').')';
										}else{
											echo '';
										}
									?>
                                </td>
                                <td>
									<?php
                                        if(isset($list['info']['total_condo_fee']) && $list['info']['total_condo_fee'] != ""){
                                            echo ''.Yii::app()->controller->renderPrice($list['info']['total_condo_fee']).Yii::app()->controller->__trans('yen').'';
                                        }else{
                                            if($list['info']['unit_condo_fee_opt'] != ''){
                                                if($list['info']['unit_condo_fee_opt'] == 0){
                                                    echo Yii::app()->controller->__trans('none');
                                                }else if($list['info']['unit_condo_fee_opt'] == -1){
                                                    echo Yii::app()->controller->__trans('undecided');
                                                }else if($list['info']['unit_condo_fee_opt'] == -2){
                                                    echo Yii::app()->controller->__trans('ask');
                                                }else if($list['info']['unit_condo_fee_opt'] == -3){
                                                    echo Yii::app()->controller->__trans('include');
                                                }
                                            }else{
                                                echo '';
                                            }
                                        }
                                    ?>
                                    <br>
									<?php
                                        if(isset($list['info']['unit_condo_fee']) && $list['info']['unit_condo_fee'] != ""){
                                            echo '('.Yii::app()->controller->renderPrice($list['info']['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').')';
                                        }else{
                                            echo '';
                                        }
                                    ?>
                                </td>
                                <td>
									<?php
                                        if(isset($list['info']['total_deposit']) && $list['info']['total_deposit'] != "0" && $list['info']['total_deposit'] != ""){
                                            echo Yii::app()->controller->renderPrice($list['info']['total_deposit']).' 円';
                                        }
                                        if($list['info']['deposit_opt']!= ''){
                                            echo '';
                                            if($list['info']['deposit_opt']== -1){
                                                echo Yii::app()->controller->__trans('undecided');
                                            }else if($list['info']['deposit_opt']== -3){
                                                echo Yii::app()->controller->__trans('none');
                                            }else if($list['info']['deposit_opt']== -2){
                                                echo Yii::app()->controller->__trans('ask');
                                            }
                                        }
                                        if(isset($list['info']['deposit_month']) &&  $list['info']['deposit_month'] != ''){
                                            echo '<br/>'.$list['info']['deposit_month'].' ヶ月';
                                        }
                                    ?>
                                    <br>
									<?php
                                        if(isset($list['info']['deposit']) && $list['info']['deposit'] != ""){
                                            echo '('.$list['info']['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                        }else{
                                            echo '';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
										if(isset($list['info']['key_money_opt']) && $list['info']['key_money_opt'] != ""){
											if($list['info']['key_money_opt'] == 2){
												echo Yii::app()->controller->__trans('None');
											}elseif($list['info']['key_money_opt'] == -1){
												echo Yii::app()->controller->__trans('Unknown');
											}elseif($list['info']['key_money_opt'] == -2){
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
										if(isset($list['info']['renewal_fee_opt']) && $list['info']['renewal_fee_opt'] != ""){
											if($list['info']['renewal_fee_opt'] == 2){
												echo Yii::app()->controller->__trans('None');
											}elseif($list['info']['renewal_fee_opt'] == -1){
												echo Yii::app()->controller->__trans('Unknown');
											}elseif($list['info']['renewal_fee_opt'] == -2){
												echo Yii::app()->controller->__trans('Undecided･ask');
											}else{
												echo '';
											}
										}

										if(isset($list['info']['renewal_fee_reason']) && $list['info']['renewal_fee_reason'] != ""){
											if($list['info']['renewal_fee_reason'] == 1){
												echo Yii::app()->controller->__trans('現賃料の');
											}elseif($list['info']['renewal_fee_reason'] == 2){
												echo Yii::app()->controller->__trans('新賃料の');
											}else{
												echo '';
											}
										}

										if(isset($list['info']['renewal_fee_recent']) && $list['info']['renewal_fee_recent'] != ""){
											echo $list['info']['renewal_fee_recent'].Yii::app()->controller->__trans('month');
										}
									?>
                                </td>
                                <td>
                                    <?php
										if(isset($list['info']['repayment_opt']) && $list['info']['repayment_opt'] != ""){
											if($list['info']['repayment_opt'] == -3){
												echo Yii::app()->controller->__trans('None')."<br>";
											}elseif($list['info']['repayment_opt'] == -4){
												echo Yii::app()->controller->__trans('Unknown')."<br>";
											}elseif($list['info']['repayment_opt'] == -1){
												echo Yii::app()->controller->__trans('Undecided')."<br>";
											}elseif($list['info']['repayment_opt'] == -2){
												echo Yii::app()->controller->__trans('Ask')."<br>";
											}elseif($list['info']['repayment_opt'] == -5){
												echo Yii::app()->controller->__trans('Sliding')."<br>";
											}else{
												echo '';
											}
										}
	
										if(isset($list['info']['repayment_reason']) && $list['info']['repayment_reason'] != ""){
											if($list['info']['repayment_reason'] == 1){
												echo Yii::app()->controller->__trans('現賃料の')."<br>";
											}elseif($list['info']['repayment_reason'] == 2){
												echo Yii::app()->controller->__trans('解約時賃料の')."<br>";
											}else{
												echo '';
											}
										}
	
										if(isset($list['info']['repayment_amt']) && $list['info']['repayment_amt'] != ""){
											echo $list['info']['repayment_amt'];
										}
	
										if(isset($list['info']['repayment_amt_opt']) && $list['info']['repayment_amt_opt'] != ""){
											if($list['info']['repayment_amt_opt'] == 1){
												echo Yii::app()->controller->__trans('ヶ月');
											}elseif($list['info']['repayment_amt_opt'] == 2){
												echo Yii::app()->controller->__trans('%')."<br>";
											}else{
												echo '';
											}
										}
									?>
                                </td>
                                <td>
                                	<?php
										if(isset($list['info']['move_in_date']) && $list['info']['move_in_date'] != "" && (string)$list['info']['move_in_date'] != '0'){
											echo $list['info']['move_in_date'];
										}else{
											echo '-';
										}
									?>
                                </td>
                                <td>
                                	<ul class="icon-facilities">
                                    <?php if($list['info']['separate_toilet_by_gender'] == 2){ ?>
                                    	<li> <span class="icon-jpdb-facilities-icons-wc"></span></li>
                                    <?php } ?>
                                    <?php if($list['info']['air_conditioning_facility_type'] == '個別'){ ?>
                                    	<li><span class="icon-jpdb-facilities-icons-ac"></span></li>
                                    <?php } ?>
                                    <?php
                                    $buildDetails = Building::model()->find('building_id  = '.$list['info']['building_id']);
									if($buildDetails['earth_quake_res_std'] == '耐震補強済' || $buildDetails['earth_quake_res_std'] == '新耐震基準'){
									?>
                                    	<li><span class="icon-jpdb-facilities-icons-earthquake"></span></li>
                                    <?php } ?>
                                    <?php if($list->oa_type == 'フリーアクセス'){ ?>
                                    	<li> <span class="icon-jpdb-facilities-icons-oa"></span></li>
                                    <?php } ?>
									<?php if($list->payment_by_installments == 1 || $list->payment_by_installments == 2){ ?>
                                    	<li> <span class="icon-jpdb-facilities-icons-split"></span></li>
                                    <?php } ?>
                                    </ul>
                                </td>
                           	</tr>