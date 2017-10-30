<td class="facility_summary var-top">
	<table class="facility-info">
		<?php
                    	$contractArray = $renewalArray = $renewalFeeMonthArray = $keymoneyArray = $keyMoneyMonthArray = $amortizationArray = $repaymentMonthArray = array();
						$fName = $renewalDetails = $renewalOpt = $keyMoneyDetails =  $keyMoneyOpt = $amortizationDetails = $repaymentOpt = '';
						$contractPeriodOptChk = '';
						$repaymentAmtOptArray = $repaymentMonthArray = array();
						foreach($floorDetails as $floor){
							if($floorId['renewal_fee_opt'] != 0){
								$renewalArray[$floor['floor_id']] = $floorId['renewal_fee_opt'];
							}
							$renewalFeeMonthArray[$floor['floor_id']] = $floorId['renewal_fee_recent'];
							if($floorId['key_money_opt'] != 0){
								$keymoneyArray[$floor['floor_id']] = $floorId['key_money_opt'];
							}
							$keyMoneyMonthArray[$floor['floor_id']] = $floorId['key_money_month'];
							if($floorId['repayment_opt'] != 0){
								$amortizationArray[$floor['floor_id']] = $floorId['repayment_opt'];
							}
							$repaymentMonthArray[$floor['floor_id']] = $floorId['repayment_amt'] ? $floorId['repayment_amt'] : 0;
                            if((isset($floorId['repayment_amt_opt'])) && ($floorId['repayment_amt_opt'] != 0)){
                                $repaymentAmtOptArray[$floor['floor_id']]=$floorId['repayment_amt_opt'];
                            }
                            if(isset($floorId['contract_period_optchk']) && $floorId['contract_period_optchk'] == 1){
                            	$contractPeriodOptChk =  '年数相談';
                            }
						}
                        //print_r($amortizationArray); echo "<br/><br/>END";
						$renewalArray = array_unique($renewalArray);
						$keymoneyArray = array_unique($keymoneyArray);
						$amortizationArray = array_unique($amortizationArray);
						
						$renewalFeeMonthArray = array_unique($renewalFeeMonthArray);
						$keyMoneyMonthArray = array_unique($keyMoneyMonthArray);
                        //Emphes
                        $MaxOccAmt = (count($repaymentMonthArray)>0) ? array_search(max(array_count_values($repaymentMonthArray)), array_count_values($repaymentMonthArray)) : '';
                        $MaxOccUnit = (count($repaymentAmtOptArray)>0) ? array_search(max(array_count_values($repaymentAmtOptArray)), array_count_values($repaymentAmtOptArray)) : '';
                        if(isset($repaymentAmtOptArray[array_search($MaxOccAmt,$repaymentMonthArray)])){
                            $MaxOccUnit = $repaymentAmtOptArray[array_search($MaxOccAmt,$repaymentMonthArray)];
                        }
                        //print_r($repaymentMonthArray); echo "<br/><br/>----";
                        //print_r($repaymentAmtOptArray);
                        //echo "Count ".@array_count_values($repaymentAmtOptArray)."<br/>";
                        //Emphes
						$repaymentMonthArray = array_unique($repaymentMonthArray);
                        
                        //echo $MaxOccAmt.'-'.$MaxOccUnit.'</br>';
						
						$k = 0;
						if(count($renewalArray) > 0){
							foreach($renewalArray as $key=>$val){
								if($k == count($renewalArray)-1){
									$slsh = '';
								}else{
									$slsh = '/';
								}
								$floorId = Floor::model()->findByPk($key);
								if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
									if(strpos($floorId['floor_down'], '-') !== false){
										$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
									}else{
										$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									$fName .= '&nbsp;'.$floorId['roomname'];
								}
								if($val != 0 && $val != ""){
									if($val == 2){
										$renewalOpt = Yii::app()->controller->__trans('None');
									}else if($val == -1){
										$renewalOpt = Yii::app()->controller->__trans('unknown');
									}else if($val == -2){
										$renewalOpt = Yii::app()->controller->__trans('Undecided');
									}
									$renewalDetails .= $renewalOpt.(count($renewalArray) > 2 ? '('.$fName.')'.$slsh : '');
								}
								$k++;
							}
						}else{
							foreach($renewalFeeMonthArray as $key=>$val){
								if($k == count($renewalFeeMonthArray)-1){
									$slsh = '';
								}else{
									$slsh = '/';
								}
								$floorId = Floor::model()->findByPk($key);
								if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
									if(strpos($floorId['floor_down'], '-') !== false){
										$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
									}else{
										$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									$fName .= '&nbsp;'.$floorId['roomname'];
								}
								$renewalDetails .= $val.(count($renewalFeeMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
								$k++;
							}
							if($renewalDetails!="")
								$renewalDetails .= Yii::app()->controller->__trans('ヶ月', 'ja');;
						}
						$j = 0;
						if(count($keymoneyArray) > 0){
							foreach($keymoneyArray as $key=>$val){
								if($j == count($keymoneyArray)-1){
									$slsh = '';
								}else{
									$slsh = '/';
								}
								$floorId = Floor::model()->findByPk($key);
								if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
									if(strpos($floorId['floor_down'], '-') !== false){
										$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
									}else{
										$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									$fName .= '&nbsp;'.$floorId['roomname'];
								}
								if($val != 0 && $val != ""){
									if($val == 2){
										$keyMoneyOpt = Yii::app()->controller->__trans('無し', 'ja');
									}else if($val == -1){
										$keyMoneyOpt = Yii::app()->controller->__trans('不明', 'ja');
									}else if($val == -2){
										$keyMoneyOpt = Yii::app()->controller->__trans('未定', 'ja');
									}
									$keyMoneyDetails .= $keyMoneyOpt.(count($keymoneyArray) > 2 ? '('.$fName.')'.$slsh : '');
								}
								$j++;
							}
						}else{
							foreach($keyMoneyMonthArray as $key=>$val){
								if($j == count($keyMoneyMonthArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														$keyMoneyDetails .= ($val!=''?$val.'ヶ月':'').(count($keyMoneyMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
														$j++;
													}
												}
												
												$z = 0;
												if(count($amortizationArray) > 0){
													foreach($amortizationArray as $key=>$val){
														if($z == count($amortizationArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														if($val != 0 && $val != ""){
															if($val == -3){
																$repaymentOpt = Yii::app()->controller->__trans('無し', 'ja');
															}else if($val == -4){
																$repaymentOpt = Yii::app()->controller->__trans('不明', 'ja');
															}else if($val == -1){
																$repaymentOpt = Yii::app()->controller->__trans('未定', 'ja');
															}else if($val == -2){
																$repaymentOpt = Yii::app()->controller->__trans('相談', 'ja');
															}else if($val == -5){
																$repaymentOpt = Yii::app()->controller->__trans('スライド式', 'ja');
															}
															$amortizationDetails .= $repaymentOpt.(count($amortizationArray) > 2 ? '('.$fName.')'.$slsh : '');
														}
														$z++;
													}
												}else{
													foreach($repaymentMonthArray as $key=>$val){
														if($z == count($repaymentMonthArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														$amortizationDetails .= ($val != "" ? $val : "").(count($repaymentMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
														$z++;
													}
												}
												$contractOptArray = array();
                                                foreach($floorDetails as $floor){
                                                    $floorId = Floor::model()->findByPk($floor['floor_id']);
                                                    if(isset( $floorId['contract_period_duration']) &&  $floorId['contract_period_duration'] != ''){
                                                        $contractArray[] = $floorId['contract_period_duration'];
														$contractOptArray[] =  $floorId['contract_period_opt'];
                                                    }
                                                }
												
												
                                                $contractdiff= array_diff_assoc($contractArray, array_unique($contractArray));
                                            ?>
			<tr>
			<th><?php echo Yii::app()->controller->__trans('更新料', 'ja'); ?></th><!--label-->
			<td><?php
// 									echo count($floorDetails);
// 									if(substr($renewalDetails, -1)=="" || substr($renewalDetails, -1)==" ")
										echo $renewalDetails!=''?$renewalDetails:'-'; 
// 									else
// 										echo $renewalDetails.Yii::app()->controller->__trans('ヶ月', 'ja');
								?></td>
			</tr>
			<tr>
			<th><?php echo Yii::app()->controller->__trans('償却', 'ja'); ?></th><!--label-->
			<td>
				<?php 
								if($amortizationDetails!='') {
									echo $amortizationDetails.' '; 
	                                if($MaxOccUnit && $MaxOccAmt){
										if($MaxOccUnit == 1){
											echo Yii::app()->controller->__trans('ヶ月', 'ja');
										}elseif($MaxOccUnit == 2){
											echo Yii::app()->controller->__trans('%');
										}else{
											echo '';
										}
	                                }
								}  else echo '-';
                                ?>
			</td>
			</tr>
			<tr>
			<th><?php echo Yii::app()->controller->__trans('礼金', 'ja'); ?></th><!--label-->
			<td><?php echo $keyMoneyDetails!=''?$keyMoneyDetails:'-'; ?></td>
			</tr>
			<tr>
			<th><?php echo Yii::app()->controller->__trans('契約形態', 'ja'); ?></th><!--label-->
			<td>
				<?php
									$contractDefaultArray = array('1'=>'普通借家','2'=>'定借','3'=>'定借希望');
									foreach($contractDefaultArray as $key=>$val){
										if(in_array($key,$contractOptArray)){
											$temp .= ''.$val;
											break;
										}
									}
									
									if($temp=='-' && $contractPeriodOptChk!='')
										echo $contractPeriodOptChk;
									else if($contractPeriodOptChk=='')
										echo $temp;
									else 
										echo $temp.':'.$contractPeriodOptChk;
								?>
			</td>
			</tr>
		<tr>
			<th><?php echo Yii::app()->controller->__trans('空調設備', 'ja'); ?></th><!--label-->
			<td>
				<?php
//					if($buildCart['air_control_type'] == 0){
//						echo Yii::app()->controller->__trans('unknown');
//					}else if($buildCart['air_control_type'] == 2){
//						echo Yii::app()->controller->__trans('Individual control');
//					}else if($buildCart['air_control_type'] == 1){
//						echo Yii::app()->controller->__trans('Zone control');
//					}
					$fDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id'].' And vacancy_info = 1' );
					$pFloors = $proposedFloors;
					$fDetailsTmp = $floorDetails;
					foreach($fDetailsTmp as $floorKey => $floor){
						if(!in_array($floor['floor_id'],$pFloors)){
							unset($fDetails[$floorKey]);
						}
					}
					
					$res = Array(0=>'', 1=>'', 2=>'', 3=>'', 4=>'');
					foreach($fDetails as $floor){
						if($floor['air_conditioning_facility_type']=="個別・セントラル") $res[0]="個別・セントラル";
						if($floor['air_conditioning_facility_type']=="個別") $res[1]="個別";
						if($floor['air_conditioning_facility_type']=="セントラル") $res[2]="セントラル";
						if($floor['air_conditioning_facility_type']=="不明" || $floor['air_conditioning_facility_type']=="unknown") $res[3]="不明";
						if($floor['air_conditioning_facility_type']=="無し") $res[4]="無し";
					}
					
					$result = '-';
					foreach($res AS $row) {
						if($row!=''){
							$result=$row;
							break;
						}
					}
					
					echo $result;
				?>
			</td><!--air condition facility-->
		</tr>
		<tr>
			<th><?php echo Yii::app()->controller->__trans('OAフロア', 'ja'); ?></th><!--label-->
			<td>
				<?php
					$floorOAList = Floor::model()->findAll('building_id = '.$buildCart['building_id'].' AND vacancy_info = 1');
					$oaDefaultArray = array(Yii::app()->controller->__trans('フリーアクセス', 'ja'),'3WAY','2WAY','1WAY',Yii::app()->controller->__trans('引き込み可', 'ja'),Yii::app()->controller->__trans('非対応', 'ja'));
					$oaFloor = array();
					$oaHeight = array();
                    foreach($floorOAList as $floorOA){
                    	$oaFloor[] = $floorOA['oa_type'];
                        $oaHeight[] = $floorOA['oa_height'];
                    }
                    for($i=0;$i<count($oaFloor);$i++) {
                    	if(in_array($oaFloor[$i],$oaDefaultArray)){
                    		echo $oaFloor[$i];
                    		if($oaHeight[$i]!="" || (int)$oaHeight[$i]!=0) {
                    			echo Yii::app()->controller->__trans('フリアク高', 'ja').":".$oaHeight[$i]."mm";
                        	}
                        	break;
                        }
                    }
					/*foreach($oaDefaultArray as $oa){
						if(in_array($oa,$oaFloor)){
							echo $oa;
							break;
						}
					}*/
					/*if(isset($buildCart['oa_floor']) && $buildCart['oa_floor'] != ''){
						$oaExplode = explode('-',$buildCart['oa_floor']);
						if($oaExplode[0] == 0){
							echo Yii::app()->controller->__trans('unknown');
						}else if($oaExplode[0] == 2){
							echo $oaExplode[1] != "" ? $oaExplode[1].'mm' : "-";
						}else if($oaExplode[0] == 1){
							echo Yii::app()->controller->__trans('Nothing');
						}else {
							echo '-';
						}
					}*/
				?>
			</td><!--OA floor-->
		</tr>
		<tr>
			<th><?php echo Yii::app()->controller->__trans('天井高', 'ja'); ?></th><!--label-->
			<td>
				<?php 
//				echo $buildCart['ceiling_height'] != "" ? $buildCart['ceiling_height'].'mm' : "-"; 
                    $res = Array();
                    foreach($fDetails as $floor){
                    	$res[] = intval($floor['ceiling_height']);
                    }
                    rsort($res);
                    echo ($res[0] != 0? $res[0].'mm' : "-");
				
				?>
			</td><!--celling height-->
		</tr>
		<!--<tr>
			<th>光ケーブル</th>
			<td>
				<?php
					/*if($buildCart['opticle_cable'] == 0){
						echo Yii::app()->controller->__trans('unknown');
					}else if($buildCart['opticle_cable'] == 1){
						echo Yii::app()->controller->__trans('Pull Yes');
					}else if($buildCart['opticle_cable'] == 2){
						echo Yii::app()->controller->__trans('Nothing');
					}else{
						echo '-';
					}*/
				?>
			</td>
		</tr>
		<tr>
			<th>エレベーター</th>
							<td>
                                <?php
					/*if(isset($buildCart['elevator']) && $buildCart['elevator'] != ''){
						if(strlen($buildCart['elevator']) > 2){
							$elevatorExp = explode('-',$buildCart['elevator']);
							if($elevatorExp[0] == 1){
								echo Yii::app()->controller->__trans('Exist');
								if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo '(';
								
								echo isset($elevatorExp[1]) && $elevatorExp[1] != "" ? $elevatorExp[1].Yii::app()->controller->__trans('基') : "";
								echo isset($elevatorExp[2]) && $elevatorExp[2] != "" ? '/'.$elevatorExp[2].Yii::app()->controller->__trans('人乗') : "";
								echo isset($elevatorExp[3]) && $elevatorExp[3] != "" ? $elevatorExp[3].Yii::app()->controller->__trans('基・人荷用') : "";
								echo isset($elevatorExp[4]) && $elevatorExp[4] != "" ? $elevatorExp[4].Yii::app()->controller->__trans('人乗') : "";
								echo isset($elevatorExp[5]) && $elevatorExp[5] != "" ? $elevatorExp[5].'基' : "";
								if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo ')';
							}else{
								echo '-';
							}
						}else{
							if($buildCart['elevator'] == -2){
								echo Yii::app()->controller->__trans('unknown');
							}else if($buildCart['elevator'] == 2){
								echo Yii::app()->controller->__trans('noexist');
							}
						}
					}else{
						echo '-';
					}*/
				?>
			</td><!--elevetor-->
		<!--</tr>
		<tr>
			<th>駐車場</th>
			<td>
				<?php 
					/*$parkingUnitNo = explode('-',$buildCart['parking_unit_no']);
					if($parkingUnitNo[0] == 1){
						echo $parkingUnitNo[1] != "" ? $parkingUnitNo[1].'台' : "-";
					}else if($parkingUnitNo[0] == 2){
						echo Yii::app()->controller->__trans('noexist');
					}else if($parkingUnitNo[0] == 3){
						echo Yii::app()->controller->__trans('exist but unknown unit number');
					}*/
				?>
			</td><!--parking-->
		<!--</tr>-->
		<tr>
			<th class="no-border"><?php echo Yii::app()->controller->__trans('コメント', 'ja'); ?></th><!--label-->
                            <td class="no-border">
                            	<?php
				if($buildCart['notes'] != ""){
					echo $buildCart['notes'];
				}else{
					echo '-';
				}
				?>
                            </td>
						</tr>
						<?php
		if($buildCart['exp_rent_disabled'] != 1){
			$expRent = array();
			if(isset($buildCart['exp_rent']) && $buildCart['exp_rent'] != ''){
				$expRent = explode('-',$buildCart['exp_rent']);
				if($expRent[0] != ""){
					$expVal = explode('~',$expRent[0]);
					if($expVal[0] != "" || $expVal[1] != ""){
		?>
		<tr>
			<td colspan="2" class="no-border comment-texts">
				<?php														
					if($expVal[0] != ""){
						echo Yii::app()->controller->renderPrice($expVal[0]);
						if($expVal[1] != ""){
							echo " ~";
						}else{
							echo Yii::app()->controller->__trans('Yen');
						}
					}
					if($expVal[1] != ""){
						echo Yii::app()->controller->renderPrice($expVal[1]).Yii::app()->controller->__trans('Yen');
					}
					echo isset($expRent[1]) && $expRent[1] == 1 ? Yii::app()->controller->__trans('(Including common area charges)') : Yii::app()->controller->__trans('(Does not include common expenses)');
				?>
			</td>
		</tr>
		<?php
					}
				}
			}
		}
		?>
	</table>
</td><!--facility summary-->