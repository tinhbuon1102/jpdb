<div id="main" class="full-width search_result">
<?php if (isset($front_only) && $front_only) {
	include(dirname(dirname(__FILE__)) . '/building/_search_option.php');
} ?>
	<div class="postbox">
    	<header class="m-title btnright">
        	<h1 class="main-title">
				<?php echo Yii::app()->controller->__trans('Search Result'); ?>
            </h1>
        </header>
        
        <?php if (isset($pages) && !empty($pages)) {
			$pgWidget = '<div class="pagination search_building_pages" >';
			$pgWidget .= $this->widget('CLinkPager', array(
				'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
				'nextPageLabel'=>'<i class="fa fa-chevron-right"></i>',
				'selectedPageCssClass' => 'active',
				'htmlOptions'=>array('class'=>'pagination'),
				'header'=>'',
				'pages'=>$pages,
			),true);
			$pgWidget .= '</div>';
			echo $pgWidget;
		}
		?>
		<div class="list-item-wraper">
		<?php
        if(isset($resultData) && count($resultData) > 0){
			foreach($resultData as $buildingList){
		?>
        <div class="list-item">
        	<div class="main-info clearfix">
            	<div class="b-name">
                	<h2><?php echo $buildingList['name']; ?> <small> ( ID : <?php echo $buildingList['buildingId']; ?> )</small></h2>
                </div>
                <div class="sb-info">
					<?php echo $buildingList['address']; ?><br>
					<?php
					if($buildingList['built_year'] != '' && $buildingList['built_year'] != '-'){
                        $extractYear = explode('-',$buildingList['built_year']);
                        $year = $extractYear[0];
                        $month = $extractYear[1] ? date("F", mktime(0, 0, 0, ($extractYear[1]))) : '';
                        echo $year.' '.$month;
					}else{
					echo '-';
					}
                    ?> <?php echo Yii::app()->controller->__trans('built'); ?>/最後の更新：<?php echo date('Y-m-d',strtotime($buildingList['modified_on'])) ?>
                </div>
                <div class="bulk">
<!--              	<a href="<?php echo Yii::app()->createUrl('building/update',array('id'=>$buildingList['building_id'])); ?>"> -->
                	<a target="_blank" href="<?php echo Yii::app()->createUrl('floor/viewFloorMass',array('id'=>$buildingList['building_id'])); ?>" 
                	onclick="window.open('<?php echo Yii::app()->createUrl('floor/viewFloorMass',array('id'=>$buildingList['building_id'])); ?>', 'newwindow', 'height=' + (screen.height-120) + ',width=' + screen.width); return false;">
                    	<button type="button" class="btn btn-primary"><?php echo Yii::app()->controller->__trans('BULK UPDATE'); ?></button>
                    </a>
                </div>
                <div class="bulk" >
                	<a target="_blank" href="<?php echo Yii::app()->createUrl('floor/create',array('bid'=>$buildingList['building_id'])); ?>">
                    	<button type="button" class="btn btn-primary"><?php echo Yii::app()->controller->__trans('Add Floor'); ?></button>
                    </a>
                </div>
                
                <div class="bulk" style="margin-right:1%;">
                	<a target="_blank" href="<?php echo Yii::app()->createUrl('building/update',array('id'=>$buildingList['building_id'])); ?>">
                    	<button type="button" class="btn btn-primary"><?php echo Yii::app()->controller->__trans('Update Buildings'); ?></button>
                    </a>
                </div>
           	</div>
            <dl class="room-data clearfix">
            	<dd class="thum">
                	<dl class="fee-box">
                    	<dt>手数料</dt>
						<?php
                        	$finalComission = OwnershipManagement::model()->findAll('building_id = '.$buildingList['building_id'].' ORDER BY `ownership_management_id` DESC LIMIT 1');
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
                        <?php
                        if(isset($finalComission[0]['modified_on']) && $finalComission[0]['modified_on'] != ""){
                        ?>
                        <dd class="updated-date">
                            <?php echo date('Y.m.d',strtotime($finalComission[0]['modified_on']));?>
                        </dd>
                        <?php
                        }
                        ?>
                    </dl>
                    <dl class="fee-box free">
                    	<dt>フリーレント</dt>
                        <dd class="charge-fee">
						<?php
                        	$rentDetails = FreeRent::model()->findAll('building_id = '.$buildingList['building_id'].' ORDER BY free_rent_id DESC LIMIT 1');
							if(isset($rentDetails) && count($rentDetails) > 0){
								$freeRent = $rentDetails[0]['free_rent_month'];
							}else{
								$freeRent = '-';
							}
						?>
						<?php echo $freeRent; ?><?php echo Yii::app()->controller->__trans('Months'); ?>
                       	</dd>
                        <dd class="update-btn">
                        	<!--<span>2016.1.13</span>-->
                            <input type="hidden" name="hdnRentBillId" id="hdnRentBillId" value="<?php echo $buildingList['building_id']; ?>"/>
                            <button type="button" name="btnUpdateFreeRent" class="btnUpdateFreeRent">Update</button>
                        </dd>
                    </dl>
					<?php
                    $buildingPicDetails = BuildingPictures::model()->find('building_id = '.$buildingList['building_id']);
					if(isset($buildingPicDetails) && count($buildingPicDetails)){
						$main_img = $buildingPicDetails['main_image'];
						if($main_img != ""){
							$pictureDetails = $main_img;
						}else{
							$pictureDetails = explode(',',$buildingPicDetails['front_images']);
							$pictureDetails = $pictureDetails[0];
						}
					?>
                    <img width="375" height="500" src="<?php echo Yii::app()->baseUrl.'/buildingPictures/front/'.$pictureDetails; ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="r_a-0" srcset="" sizes="(max-width: 375px) 100vw, 375px">
					<?php
                    }else{
					?>
                    <img width="375" height="500" src="<?php echo Yii::app()->baseUrl.'/images/default.png'; ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="r_a-0" srcset="" sizes="(max-width: 375px) 100vw, 375px">
					<?php
                    }
					?>
               	</dd>
                <dd class="details">
                	<div class="owner-meta">
                    	<?php
							//$ownershipManagement = OwnershipManagement::model()->findAll('building_id = '.$buildingList['building_id'].' AND is_current = 1 GROUP BY ownership_type');
							$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingList['building_id'].' GROUP BY ownership_management.ownership_type';
							$ownershipManagement = Yii::app()->db->createCommand($query)->queryAll();
							if(isset($ownershipManagement) && count($ownershipManagement) > 0 && !empty($ownershipManagement)){
								foreach($ownershipManagement as $owner){
						?>
                        <div class="propri">
                        	<span>
                            <?php
								$managementArray = array('0'=>'-','1'=>'オーナー','2'=>'管理会社','3'=>'ゼネコン','4'=>'仲介業者','6'=>'サブリース','7'=>'貸主代理','8'=>Yii::app()->controller->__trans('AM'),'9'=>Yii::app()->controller->__trans('PM'),'10'=>'業者');
								if(array_key_exists($owner['ownership_type'],$managementArray)){
									echo $managementArray[$owner['ownership_type']];
								}
							?>
                            </span>
                            <?php echo $owner['owner_company_name']; ?> <?php echo date('Y.m.d',strtotime($owner['modified_on'])); ?>
                        </div>
                        <?php
								}
							}
						?>
                    </div>
                    <table class="room-table">
                    	<thead>
                        	<tr>
                            	<th>
								<?php
                                	$allFloorIds = '';
                                	
                                	if (isset($front_only) && $front_only) {
                                		$flootList = $buildingList->getFloors();
                                	}
                                	else {
                                		$floorListCriteria = new CDbCriteria();
                                		$floorListCriteria->addInCondition("building_id", array((int)$buildingList['building_id']));
                                		$floorListCriteria->order = 'cast(floor_down as SIGNED) ASC, cast(floor_up as SIGNED) ASC';
                                		$flootList = Floor::model()->findAll($floorListCriteria);
                                	}
									if(isset($flootList) && count($flootList)){
										foreach($flootList as $floors){
											$floorIds[] = $floors['floor_id'];
										}
										$allFloorIds = implode(',',$floorIds);
									}
								?>
                                <input type="hidden" name="hdnAllFloorIds" id="hdnAllFloorIds" class="hdnAllFloorIds" value="<?php echo $allFloorIds; ?>"/>
                                <input type="hidden" name="hdnBuildingId" id="hdnBuildingId" class="hdnBuildingId" value="<?php echo $buildingList['building_id']; ?>" />
                                <button type="button" class="btn btn-primary btnAddAll">全て追加</button>
                             	</th>
                                <th>空満</th>
                                <th>階数</th>
                                <th>面積</th>
                                <th>賃料/坪</th>
                                <th>共益費/坪</th>
                                <th>保証金</th>
                                <th>礼金</th>
                                <th>更新料</th>
                                <th>償却</th>
                                <th>入居時期</th>
                                <th>設備</th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
                        	$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
							$logged_user_id = $user->user_id;
							if(isset($flootList) && count($flootList) > 0){
								foreach($flootList as $list){
						?>
                        	<tr class="trFloor <?php $this->changeColor($list->floor_id); ?> <?php echo $floor->fixed_floor ? 'fixed_floor_mass' : ''?> test" data-href='<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$list['floor_id'])); ?>'>
                            	<td>
                                	<input type="hidden" name="hdnBuildingId" id="hdnBuildingId" class="hdnBuildingId" value="<?php echo $buildingList['building_id']; ?>" />
                                    <input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo $list['floor_id']; ?>" />
									<?php
                                    	$cartDetails = Cart::model()->findAll('user_id = '.$logged_user_id.' AND floor_id = '.$list['floor_id'].' AND building_id = '.$buildingList['building_id']);
										$disabled = '';
										$lbl = '追加';
										if(isset($cartDetails) && count($cartDetails) > 0){
											$disabled = 'disabled';
											$lbl = '削除';
										}
									?>
                                    <button type="button" class="btn btn-primary btnAddToCart" <?php echo $disabled; ?>><?php echo $lbl; ?></button>
                                </td>
                                <td>
                                	<?php
										$vacInfo = $list->vacancy_info;
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
                                if(isset($list['floor_down']) && $list['floor_down'] != ""){
									if(strpos($list['floor_down'], '-') !== false){
										$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $list['floor_down']);
									}else{
										$floorDown = $list['floor_down'];
									}
									if(isset($list['floor_up']) && $list['floor_up'] != ''){
										echo $floorDown.' - '.$list['floor_up'].' '.Yii::app()->controller->__trans('階');
									}else{
										echo $floorDown.' '.Yii::app()->controller->__trans('階');
									}
								}
								if(isset($list['roomname']) && $list['roomname'] != ""){
									echo '&nbsp;'.$list['roomname'];
								}
								
								echo HelperFunctions::showFixedFloorText($list);
								?>
                                </td>
                                <td>
									<font>
                                    	<font>
                                            <?php
											if(isset($list['area_ping']) && $list['area_ping'] != ""){
												echo $list['area_ping']." ".Yii::app()->controller->__trans('Ping');
											}else{
												echo '-';
											}echo "<br/>";
											?>
                                            <?php
												if(isset($list['payment_by_installments']) && $floorDetails['payment_by_installments'] == 1){
													echo '分割例 :';
												}else if(isset($list['payment_by_installments']) && $floorDetails['payment_by_installments'] == 2){
													echo '分割可 :';
												}
											?>
                                            <?php if(isset($list['floor_partition']) && $list['floor_partition'] != ""){
												  $expFloorParts = explode(',',$list['floor_partition']);
													if(!empty($expFloorParts)){
														foreach($expFloorParts as $part){
															echo $part.'坪,'.'<br/>';
														}
													}
													
											}
											?>
                                        </font>
                                    </font>
                                    <font>
                                    	<font>
                                        <?php
										if(isset($list['area_m']) && $list['area_m'] != ""){
											echo $list['area_m']." ".Yii::app()->controller->__trans('square meters');
										}else{
											echo '-';
										}
										?>

                                        </font>
                                    </font>
                                    <br>
                                    <font>
                                    	<font>
                                        <?php
										if(isset($list['area_net']) && $list['area_net'] != ""){
											echo "ネット: ".$list['area_net']." 坪";
										}else{
											echo '-';
										}
										?>
                                        </font>
                                    </font>
                                </td>
                                <td class="rent-unit">
                                   <font><font> 
                                    <?php
                                        if(isset($list['total_rent_price']) && $list['total_rent_price'] != ""){
                                            echo Yii::app()->controller->renderPrice($list['total_rent_price']).'円';
                                        }else{
                                            if($list['rent_unit_price_opt'] != ''){
                                                if($list['rent_unit_price_opt'] == -1){
                                                    echo Yii::app()->controller->__trans('undecided');
                                                }else if($list['rent_unit_price_opt'] == -2){
                                                    echo Yii::app()->controller->__trans('ask');
                                                }
                                            }else{
                                                echo '-';
                                            }
                                        }
                                    ?>
                                    </font></font><br>
                                    <font><font> 
                                    
                                        <?php
                                            if(isset($list['rent_unit_price']) && $list['rent_unit_price'] != "" && $list['rent_unit_price'] != 0){
                                                echo '('.Yii::app()->controller->renderPrice($list['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo').')';
                                            }else{
                                                echo '';
                                            }
                                        ?>
                                    </font></font>
                                </td>
                                <td>
                                <font><font> 
								<?php
                                    if(isset($list['total_condo_fee']) && $list['total_condo_fee'] != ""){
                                        echo ''.Yii::app()->controller->renderPrice($list['total_condo_fee']).Yii::app()->controller->__trans('yen').'';
                                    }else{
                                        if($list['unit_condo_fee_opt'] != ''){
                                            if($list['unit_condo_fee_opt'] == 0){
                                                echo Yii::app()->controller->__trans('none');
                                            }else if($list['unit_condo_fee_opt'] == -1){
                                                echo Yii::app()->controller->__trans('undecided');
                                            }else if($list['unit_condo_fee_opt'] == -2){
                                                echo Yii::app()->controller->__trans('ask');
                                            }else if($list['unit_condo_fee_opt'] == -3){
                                                echo '賃料に込み<br/>(含む)';
                                            }
                                        }else{
                                            echo '-';
                                        }
                                    }
                                ?>
                                </font></font><br>
                                <font><font> 
                                    <?php
                                        if(isset($list['unit_condo_fee']) && $list['unit_condo_fee'] != "" && $list['unit_condo_fee'] != 0){
                                            echo '('.Yii::app()->controller->renderPrice($list['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo').')';
                                        }else{
                                            echo '';
                                        }
                                    ?>
                                </font></font>
                                </td>
                                <td>
                                <font><font> 
									<?php
                                        if(isset($list['total_deposit']) && $list['total_deposit'] != "0" && $list['total_deposit'] != ""){
                                            echo Yii::app()->controller->renderPrice($list['total_deposit']).' 円';
                                        }
                                        if($list['deposit_opt'] != ''){
                                            echo '';
                                            if($list['deposit_opt'] == -1){
                                                echo Yii::app()->controller->__trans('undecided');
                                            }else if($list['deposit_opt'] == -3){
                                                echo Yii::app()->controller->__trans('none');
                                            }else if($list['deposit_opt'] == -2){
                                                echo Yii::app()->controller->__trans('ask');
                                            }
                                        }
                                        if(isset($list['deposit_month']) &&  $list['deposit_month'] != ''){
                                            echo '<br/>'.$list['deposit_month'].' ヶ月';
                                        }
                                    ?>
                                </font></font><br>
                                <font><font> 
                                    <?php
                                        if(isset($list['deposit']) && $list['deposit'] != ""){
                                            echo '('.$list['deposit'].Yii::app()->controller->__trans('yen / tsubo').')';
                                        }else{
                                            echo '';
                                        }
                                    ?>
                                </font></font>
                               	</td>
                                <td>
                                <?php
									if(isset($list['key_money_opt']) && $list['key_money_opt'] != ""){
										if($list['key_money_opt'] == 2){
											echo Yii::app()->controller->__trans('None');
										}elseif($list['key_money_opt'] == -1){
											echo Yii::app()->controller->__trans('Unknown');
										}elseif($list['key_money_opt'] == -2){
											echo Yii::app()->controller->__trans('undecided･ask');
										}else{
											echo '';
										}
									}else{
										echo '';
									}
									
									if(isset($list['key_money_month']) && $list['key_money_month'] != ""){
										echo $list['key_money_month'].Yii::app()->controller->__trans('month');
									}
								?>
                               	</td>
                                <td>
                                <?php
									if(isset($list['renewal_fee_opt']) && $list['renewal_fee_opt'] != ""){
										if($list['renewal_fee_opt'] == 2){
											echo Yii::app()->controller->__trans('None'); 
										}elseif($list['renewal_fee_opt'] == -1){
											echo Yii::app()->controller->__trans('Unknown'); 
										}elseif($list['renewal_fee_opt'] == -2){
											echo Yii::app()->controller->__trans('Undecided･ask'); 
										}else{
											echo '';
										}
									}
									
									if(isset($list['renewal_fee_reason']) && $list['renewal_fee_reason'] != ""){
										if($list['renewal_fee_reason'] == 1){
											echo Yii::app()->controller->__trans('現賃料の'); 
										}elseif($list['renewal_fee_reason'] == 2){
											echo Yii::app()->controller->__trans('新賃料の'); 
										}else{
											echo '';
										}
									}
									
									if(isset($list['renewal_fee_recent']) && $list['renewal_fee_recent'] != ""){
										echo $list['renewal_fee_recent'].Yii::app()->controller->__trans('month');
									}
								?>
                               	</td>
                                <td>
                                <font><font>
									<?php
                                        if(isset($list['repayment_opt']) && $list['repayment_opt'] != ""){
                                            if($list['repayment_opt'] == -3){
                                                echo Yii::app()->controller->__trans('None')."<br>"; 
                                            }elseif($list['repayment_opt'] == -4){
                                                echo Yii::app()->controller->__trans('Unknown')."<br>"; 
                                            }elseif($list['repayment_opt'] == -1){
                                                echo Yii::app()->controller->__trans('Undecided')."<br>"; 
                                            }elseif($list['repayment_opt'] == -2){
                                                echo Yii::app()->controller->__trans('Ask')."<br>"; 
                                            }elseif($list['repayment_opt'] == -5){
                                                echo Yii::app()->controller->__trans('Sliding')."<br>"; 
                                            }else{
                                                echo '';
                                            }
                                        }
                                        
                                        if(isset($list['repayment_reason']) && $list['repayment_reason'] != ""){
                                            if($list['repayment_reason'] == 1){
                                                echo Yii::app()->controller->__trans('現賃料の')."<br>"; 
                                            }elseif($list['repayment_reason'] == 2){
                                                echo Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
                                            }else{
                                                echo '';
                                            }
                                        }
                                        
                                        if(isset($list['repayment_amt']) && $list['repayment_amt'] != ""){
                                            echo $list['repayment_amt'];
                                        }
                                        
                                        if(isset($list['repayment_amt_opt']) && $list['repayment_amt_opt'] != ""){
                                            if($list['repayment_amt_opt'] == 1){
                                                echo Yii::app()->controller->__trans('ヶ月'); 
                                            }elseif($list['repayment_amt_opt'] == 2){
                                                echo Yii::app()->controller->__trans('%')."<br>"; 
                                            }else{
                                                echo '';
                                            }
                                        }
                                    ?>
                                </font></font>
                                </td>
                                <td>
                                <font><font>
									<?php
                                        if(isset($list['move_in_date']) && $list['move_in_date'] != "" && (string)$list['move_in_date'] != '0'){
                                            echo $list['move_in_date'];
                                        }else{
                                            echo '-';
                                        }
                                    ?>
                                </font></font>
                                </td>
                                <td>
                                	<ul class="icon-facilities">
										<?php if($list['separate_toilet_by_gender'] == 2){ ?>
                                            <li> <span class="icon-jpdb-facilities-icons-wc"></span></li>
                                        <?php } ?>
                                        <?php if($list['air_conditioning_facility_type'] == '個別'){ ?>
                                            <li><span class="icon-jpdb-facilities-icons-ac"></span></li>
                                        <?php } ?>
                                        <?php
                                        $buildDetails = Building::model()->find('building_id  = '.$list['building_id']);
                                        if($buildDetails['earth_quake_res_std'] == '耐震補強済' || $buildDetails['earth_quake_res_std'] == '新耐震基準'){
                                        ?>
                                            <li><span class="icon-jpdb-facilities-icons-earthquake"></span></li>
                                        <?php } ?>
                                        <?php if($list['oa_type'] == 'フリーアクセス'){ ?>
                                            <li> <span class="icon-jpdb-facilities-icons-oa"></span></li>
                                        <?php } ?>
                                        <?php if($list['payment_by_installments'] == 1 || $list['payment_by_installments'] == 2){ ?>
                                            <li> <span class="icon-jpdb-facilities-icons-split"></span></li>
                                        <?php } ?>
                                    </ul>
                                </td>
                           	</tr>
                        <?php
                        	}
						}
						?>
                        </tbody>
                    </table>
                    <div class="bd_business">
                    	<dl class="archive_box cmc">
                        	<dt>伝達事項
                            	<div class="bt_msg">
                                	<input type="hidden" name="buildingIdForTrans" id="buildingIdForTrans" class="buildingIdForTrans" value="<?php echo $buildingList['building_id']; ?>" />
									<?php
                                    	$transDetails = TransmissionMatters::model()->findAll(array("condition" => "building_id = '".$buildingList['building_id']."'","order" => "transmission_matters_id DESC"));
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
												if($i == 2){
													break;
												}
									?>
                                    	<tr>
                                        	<th scope="row">
												<?php echo date('Y.m.d',strtotime($list['added_on'])); ?>(<?php echo date('D',strtotime($list['added_on'])); ?>)
                                            </th>
                                            <td><?php echo $list['note']; ?> </td>
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
									$negotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildingList['building_id'] . ' LIMIT 3');
									$totalNegotiation = count($negotiationDetails);
								?>
                                <input type="hidden" name="hdnNegBilId" id="hdnNegBilId" value="<?php echo $buildingList['building_id']; ?>"/>
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
                                                            
                                                            $negUnitB = '';
                                                            $negUnit = '';
                                                            $negVal = '';
                                                            
                                                            if($negotiation['negotiation_type'] == 1){
                                                                $negUnit = '/坪';
                                                                $negUnitB = '¥';
                                                                $negVal = number_format($negotiation['negotiation']);
                                                            }elseif($negotiation['negotiation_type'] == 5){
                                                                $negUnit = '/坪';
                                                                $negUnitB = '¥';
                                                                $negVal = number_format($negotiation['negotiation']);
                                                            }elseif($negotiation['negotiation_type'] == 2 || $negotiation['negotiation_type'] == 3){
                                                                $negUnit = 'ヶ月';
                                                                $negVal = $negotiation['negotiation'];
                                                            }
                                                            elseif($negotiation['negotiation_type'] == 4){
                                                            	$negVal = $negotiation['negotiation'];
                                                            }
															if(strpos($floor['floor_down'], '-') !== false){
                                                                $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
                                                            }else{
                                                                $floorDown = $floor['floor_down'];
                                                            }
                                                            $floorName .= $negUnitB.$negVal.$negUnit . ' ';
                                                            
                                                            $floorName .= $floorDown;
                                                            if($floor['floor_up'] != ""){
                                                            	$floorName .= " ~ ".$floor['floor_up'];
                                                            }
                                                            
                                                            $floorName .= '階 ' . $floor['area_ping'].' '.Yii::app()->controller->__trans('tsubo'). ''.$negotiation['negotiation_note'];
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
                                                            echo '底値:';
                                                        }elseif($negotiation['negotiation_type'] == 2){
                                                            echo Yii::app()->controller->__trans('敷金:');
                                                        }elseif($negotiation['negotiation_type'] == 3){
                                                            echo Yii::app()->controller->__trans('礼金:');
                                                        }elseif($negotiation['negotiation_type'] == 5){
                                                            echo '目安値:';
                                                        }else{
                                                            echo Yii::app()->controller->__trans('その他:');
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
                </dd>
                <dd class="clearfix"></dd>
            </dl>
        </div>
		<?php
        }
		?>
		</div>
		
		<?php if (isset($pages) && !empty($pages)) {
			$pgWidget = '<div class="pagination search_building_pages" >';
			$pgWidget .= $this->widget('CLinkPager', array(
				'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
				'nextPageLabel'=>'<i class="fa fa-chevron-right"></i>',
				'selectedPageCssClass' => 'active',
				'htmlOptions'=>array('class'=>'pagination'),
				'header'=>'',
				'pages'=>$pages,
			),true);
			$pgWidget .= '</div>';
			echo $pgWidget;
		}
		?>
		
        <!--Modal Popup for Add New Type-->
        <div class="modal-box hide" id="modalTrans">
            <div class="content transmissionContent">
                <div class="box-header">
                    <h2 class="popup-label">
                        <?php echo Yii::app()->controller->__trans('Transmission Matters'); ?>
                    </h2>
                    <button type="button" class="btnModalClose" id="btnModalClose">X</button>
                </div>
                <div class="box-content">
                    <table>
                        <tr>
                            <td><?php echo Yii::app()->controller->__trans('Input'); ?></td>
                            <td>
                                <input type="hidden" name="buildId" id="buildId" class="buildId" value="0" />
                                <textarea class="inputText" id="inputText" name="inputText" style="resize:none;"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="button" class="btnAddTrans"><?php echo Yii::app()->controller->__trans('追加'); ?></button>
                            </td>
                        </tr>
                    </table>
                    <div class="buildingTransmissionMatters listScroll"></div>
                </div>
            </div>
        </div>
        <!--Modal Popup for Add Free Rent-->
        <div class="modal-box hide" id="modalFreeRent">
            <div class="content transmissionContent">
                <div class="box-header">
                    <h2 class="popup-label">
                        <?php echo Yii::app()->controller->__trans('Free Rent'); ?>
                    </h2>
                    <button type="button" class="btnModalClose" id="btnModalClose">X</button>
                </div>
                <div class="box-content">
                    <form name="frmAddFreeRent" id="frmAddFreeRent" class="frmAddFreeRent" data-action="<?php echo Yii::app()->createUrl('building/saveFreeRent'); ?>">
                        <table>
                            <tr>
                                <td><?php echo Yii::app()->controller->__trans('Free Rent'); ?>Free Rent</td>
                                <td>
                                    <input type="hidden" name="rentBuildId" id="rentBuildId" class="rentBuildId" value="0" />
                                    <input type="text" name="freeRentMonth" id="freeRentMonth" class="freeRentMonth" style="width:50% !important;"/>&nbsp;&nbsp;<?php echo Yii::app()->controller->__trans('Months'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo Yii::app()->controller->__trans('Expiration date of the information'); ?> (<?php echo Yii::app()->controller->__trans('optional'); ?>)
                                </td>
                                <td>
                                    <input type="text" name="expirationDate" id="expirationDate" class="expirationDate" style="width:50% !important;"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo Yii::app()->controller->__trans('Target floor'); ?> (<?php echo Yii::app()->controller->__trans('optional'); ?>)
                                </td>
                                <td>
                                    <div class="floorListForFreeRent"></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="button" class="btnAddFreeRent"><?php echo Yii::app()->controller->__trans('Add'); ?></button>
                                </td>
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
                    <h2 class="popup-label">
                        <?php echo Yii::app()->controller->__trans('Rent Negotiation'); ?>
                    </h2>
                    <button type="button" class="btnModalClose" id="btnModalClose">X</button>
                </div>
                <div class="box-content">
                    <form name="frmAddRentNegotiation" id="frmAddRentNegotiation" class="frmAddRentNegotiation" data-action="<?php echo Yii::app()->createUrl('building/saveRentNegotiation'); ?>">
                        <table>
                            <tr>
                                <td>
                                    <?php echo Yii::app()->controller->__trans('Negotiation Type'); ?>
                                </td>
                                <td style="text-align:left;">
                                    <input type="hidden" name="negBuildId" id="negBuildId" class="negBuildId" value="0" />
                                    ※ <?php echo Yii::app()->controller->__trans('When you enter the amount of money excepting such as the date, please choose "Other negotiation information"'); ?>.<br/>
                                    <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="1"/>
              <?php echo Yii::app()->controller->__trans('Tsubo unit price'); ?> (<?php echo Yii::app()->controller->__trans('floor'); ?>)
              
              <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="5"/>
              <?php echo Yii::app()->controller->__trans('Tsubo'); ?> (<?php echo Yii::app()->controller->__trans('reference value'); ?>)
                                    
                                    
                                    <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="2"/><?php echo Yii::app()->controller->__trans('Deposit negotiation value'); ?>
                                    <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="3"/><?php echo Yii::app()->controller->__trans('Key money negotiation value'); ?>
                                    <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="4"/><?php echo Yii::app()->controller->__trans('Other negotiations information'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo Yii::app()->controller->__trans('Negotiation'); ?>
                                </td>
                                <td>
                                    <input type="text" name="negotiationAmt" id="negotiationAmt" class="negotiationAmt" style="width:50% !important;"/>&nbsp;&nbsp;&nbsp;Yen / tsubo
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo Yii::app()->controller->__trans('Target floor'); ?> (<?php echo Yii::app()->controller->__trans('optional'); ?>)
                                </td>
                                <td>
                                    <div class="floorListForRentNegotiation"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo Yii::app()->controller->__trans('The person in charge / information source'); ?>
                                </td>
                                <td>
                                    <select name="personIncharge" id="personIncharge" class="personIncharge">
                                        <option value="0">-</option>
                                        <?php
                                            $userList = Users::model()->findAll('user_role = "a"');
                                            if(isset($userList) && count($userList) > 0){
                                                foreach($userList as $users){
                                        ?>
                                        <option value="<?php echo $users['user_id']; ?>"><?php echo $users['username']; ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="button" class="btnAddRentNegotiation"><?php echo Yii::app()->controller->__trans('Add'); ?></button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div class="buildingRentNegotiations listScroll"></div>
                </div>
            </div>
        </div>
        <!--Modal Popup for Add cart to proposed article-->
        <div class="modal-box hide" id="modalProposedArticle">
            <div class="content transmissionContent">
                <div class="box-header">
                    <h2 class="popup-label">
                        <?php echo Yii::app()->controller->__trans('Proposed Article'); ?>
                    </h2>
                    <button type="button" class="btnModalClose" id="btnModalClose">X</button>
                </div>
                <div class="box-content">
                    <form name="frmAddBuildToProposedList" id="frmAddBuildToProposedList" class="frmAddBuildToProposedList" data-action="<?php echo Yii::app()->createUrl('proposedArticle/addProposedArticle'); ?>">
                        <input type="hidden" name="hdnCartBuildingId" id="hdnCartBuildingId" class="hdnCartBuildingId" value="0"/>
                        <table>
                            <tr>
                                <td><?php echo Yii::app()->controller->__trans('Name'); ?></td>
                                <td style="text-align:left;">
                                    <input type="text" name="proposedArticleName" id="proposedArticleName" class="proposedArticleName" style="width:50% !important;"/>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::app()->controller->__trans('Customer Name'); ?></td>
                                <td style="text-align:left;">
                                    <select name="proposedCustomerName" id="proposedCustomerName" class="proposedCustomerName">
                                        <option value="0">-</option>
                                        <?php
                                            $user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
                                            $customerList = Customer::model()->findAll('sales_staff_id = '.$user->user_id);
                                            if(isset($customerList) && count($customerList) > 0){
                                                foreach($customerList as $customer){
                                        ?>
                                        <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['company_name']; ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="button" class="btnAddArticle"><?php echo Yii::app()->controller->__trans('Add'); ?></button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
		<?php
        }
        ?>
		<div class="cl-list">
		<?php
        if(isset($customerDetails) && count($customerDetails) > 0){
			foreach($customerDetails as $select) {
				$customerReqDetails = CustomerRequirement::model()->find('customer_id = '.$select['customer_id']);
				$buisnessTypeDetails = BusinessType::model()->find('business_type_id = '.$select['business_type_id']);
		?>
            <div class="list-item">
            	<div class="company_name clearfix">
                	<span onClick="viewFullDetails('<?php echo Yii::app()->createUrl('customer/fullDetail',array('id'=>$select['customer_id'])); ?>')" class="clickable client-name">
						<?php if(isset($select['company_name']) && $select['company_name'] != ''){ echo $select['company_name'];} ?></span><span class="name_pich"><?php echo Yii::app()->controller->__trans('Person in charge'); ?>:<?php if(isset($select['person_incharge_name']) && $select['person_incharge_name'] != ''){ echo $select['person_incharge_name'];} ?>
                    </span>
                </div>
                <table class="customer-result-table">
                	<tbody>
                    	<tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Sort of business'); ?>
                            </th>
                            <td>
								<?php echo $buisnessTypeDetails['business_name'];?>
                            </td>
                        </tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('ideal conditions'); ?>
                            </th>
                           	<td>
								<?php
                                if(isset($customerReqDetails['area_group']) && $customerReqDetails['area_group'] == 1){
									echo Yii::app()->controller->__trans('Area A（千代田／中央／港／新宿／渋谷）');
								}elseif(isset($customerReqDetails['area_group']) && $customerReqDetails['area_group'] == 2){
									echo Yii::app()->controller->__trans('Area B（品川／豊島／文京／台東／目黒）');
								}
								elseif(isset($customerReqDetails['area_group']) && $customerReqDetails['area_group'] == 3){
									echo Yii::app()->controller->__trans('Area C（中野／世田谷／江東）');
								}else{
									echo '-';
								}
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Sort of contact'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($select['reason_of_contact']) && $select['reason_of_contact'] != ''){
									echo $select['reason_of_contact'];
								}else{
									echo '-';
								}
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Person in charge'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($select['person_incharge_name']) && $select['person_incharge_name'] != ''){
									echo $select['person_incharge_name'];
								}?>
                            </td>
                        </tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Updated'); ?>
                            </th>
                            <td>
                            	<?php
									echo date('Y.m.d',strtotime($select['modified_on']));
								?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
		<?php
        	}
		}
		?>
        </div>
        <?php
		if((isset($resultData) && empty($resultData)) || (isset($customerDetails) && empty($customerDetails))){
			echo Yii::app()->controller->__trans('No Data Available');
		}
		?>
    </div>
</div>