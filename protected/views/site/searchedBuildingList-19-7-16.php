<div id="main" class="full-width search_result">
	<div class="postbox">
    	<header class="m-title btnright">
        	<h1 class="main-title">
				<?php echo Yii::app()->controller->__trans('Search Result'); ?>
            </h1>
        </header>
		<?php
        if(isset($resultData) && count($resultData) > 0){
			foreach($resultData as $buildingList){
		?>
        <div class="list-item">
        	<div class="main-info clearfix">
            	<div class="b-name">
                	<h2><?php echo $buildingList['name']; ?></h2>
                </div>
                <div class="sb-info">
					<?php echo $buildingList['address']; ?><br>
					<?php
					if($buildingList['built_year'] != '' && $buildingList['built_year'] != '-'){
                        $extractYear = explode('-',$buildingList['built_year']);
                        $year = $extractYear[0];
                        $month = date("F", mktime(0, 0, 0, ($extractYear[1])));
                        echo $year.' '.$month;
					}else{
					echo '-';
					}
                    ?> <?php echo Yii::app()->controller->__trans('built'); ?>/最後の更新：<?php echo date('Y-m-d',strtotime($buildingList['modified_on'])) ?>
                </div>
                <div class="bulk">
                	<a href="<?php echo Yii::app()->createUrl('building/update',array('id'=>$buildingList['building_id'])); ?>">
                    	<button type="button" class="btn btn-primary"><?php echo Yii::app()->controller->__trans('BULK UPDATE'); ?></button>
                    </a>
                </div>
           	</div>
            <dl class="room-data">
            	<dd class="thum">
                	<dl class="fee-box">
                    	<dt>手数料</dt>
						<?php
                        	$finalComission = OwnershipManagement::model()->findAll('building_id = '.$buildingList['building_id'].' ORDER BY `ownership_management_id` DESC LIMIT 1');
						?>
                        <dd class="charge-fee">
                        <?php
                        if(isset($finalComission[0]['charge']) && $finalComission[0]['charge'] != ""){
                            if(preg_match('/[^A-Za-z]/', $finalComission[0]['charge'])){
                                $charge = '<span class="charge_a">△</span>'.number_format($finalComission[0]['charge'],1,'.','');
                            }else{
                                $charge = $finalComission[0]['charge'];
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
						$pictureDetails = explode(',',$buildingPicDetails['front_images']);
					?>
                    <img width="375" height="500" src="<?php echo Yii::app()->baseUrl.'/buildingPictures/front/'.$pictureDetails[0]; ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="r_a-0" srcset="" sizes="(max-width: 375px) 100vw, 375px">
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
                    	<div class="propri"><span>管理会社</span>(有)ハウジング・ノア(0) 　2010.6.25</div>
                        <div class="intermi"><span>仲介業者</span>(有)ハウジング・ノア(0) 2015.12.18</div>
                    </div>
                    <table class="room-table">
                    	<thead>
                        	<tr>
                            	<th>
								<?php
                                	$allFloorIds = '';
									$flootList = Floor::model()->findAll('building_id = '.$buildingList['building_id']);
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
                        	<tr class="trFloor" data-href='<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$list['floor_id'])); ?>'>
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
                                	$vacInfo = $list['vacancy_info'];
									if($vacInfo == 1){
										$vacInfo = '空';
									}elseif($vacInfo == 0){
										$vacInfo = '満';
									}else{
										$vacInfo = '';
									}
									echo $vacInfo;
								?>
                                </td>
                                <td>
								<?php
                                	if(isset($list['floor_up']) && $list['floor_up'] != ''){
										echo $list['floor_down'].' - '.$list['floor_up'];
									}else{
										echo $list['floor_down'];
									}
								?>
                                </td>
                                <td>
								<?php
                                	$area = $list['area_ping'];
									if($area != ""){
										echo $area;
									}else{
										echo '-';
									}
								?>
                                </td>
                                <td>
                                <?php
									$rentPrice = $list['total_rent_price'];
									if($rentPrice != ""){
										echo $rentPrice;
									}else{
										echo '-';
									}
								?>
                                </td>
                                <td>
                                <?php
									$condoPrice = $list['total_condo_fee'];
									if($condoPrice != ""){
										echo $condoPrice;
									}else{
										echo '-';
									}
								?>
                                </td>
                                <td>
                                <?php
									$deposite = $list['deposit_month'];
									if($deposite != ""){
										echo $deposite;
									}else{
										echo '-';
									}
								?>
                               	</td>
                                <td>
                                <?php
									$keyMoney = $list['key_money_opt'];
									if($keyMoney == 2){
										$keyMoney = '無';
									}elseif($keyMoney == -1){
										$keyMoney = '不明';
									}elseif($keyMoney == -2){
										$keyMoney = '未定･相談';
									}else{
										$keyMoney = '';
									}
									echo $keyMoney;
								?>
                               	</td>
                                <td>
                                <?php
									$renewalFee = $list['renewal_fee_opt'];
									if($renewalFee == 2){
										$renewalFee = '無';
									}elseif($renewalFee == -1){
										$renewalFee = '不明';
									}elseif($renewalFee == -2){
										$renewalFee = '未定･相談';
									}else{
										$renewalFee = '';
									}
									echo $renewalFee;
								?>
                               	</td>
                                <td>
                                <?php
									$repaymentOpt = $list['repayment_opt'];
									if($repaymentOpt == -3){
										$repaymentOpt = '無';
									}elseif($repaymentOpt == -4){
										$repaymentOpt = '不明';
									}elseif($repaymentOpt == -1){
										$repaymentOpt = '未定';
									}elseif($repaymentOpt == -2){
										$repaymentOpt = '相談';
									}elseif($repaymentOpt == -5){
										$repaymentOpt = 'スライド式';
									}else{
										$repaymentOpt = '';
									}
									echo $repaymentOpt;
								?>
                                </td>
                                <td>
                                <?php
									$moveInDate = $list['move_in_date'];
									if($moveInDate != ""){
										echo $moveInDate;
									}else{
										echo '';
									}
								?>
                                </td>
                                <td>
                                	<ul class="icon-facilities">
                                    	<li>
                                        	<img src="http://heart-hunger.net/properties-db/wp-content/uploads/2016/01/ico_ac.gif">
                                        </li>
                                        <li>
                                        	<img src="http://heart-hunger.net/properties-db/wp-content/uploads/2016/01/ico_ac.gif">
                                        </li>
                                        <li>
                                        	<img src="http://heart-hunger.net/properties-db/wp-content/uploads/2016/01/ico_ac.gif">
                                        </li>
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
									$negotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildingList['building_id']);
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
                                    $days = array('month'=>'Mon','fire'=>'Tue','water'=>'Wed','wood'=>'Thu','gold'=>'Fri','soil'=>'Sat','day'=>'Sun');
									if(isset($negotiationDetails) && count($negotiationDetails) > 0){
										foreach($negotiationDetails as $negotiation){
											$day = array_search((date('D',strtotime($negotiation['added_on']))), $days);
											$allocateFloorDetails = Floor::model()->findAllByAttributes(array('floor_id'=>explode(',',$negotiation['allocate_floor_id'])));
											if(isset($allocateFloorDetails) && count($allocateFloorDetails) > 0){
												$floorName = '';
												foreach($allocateFloorDetails as $floor){
													$floorName .= $floor['floor_down'];
													if($floor['floor_up'] != ""){
														$floorName .= " ~ ".$floor['floor_up'];
													}
													$floorName .= " / ".$floor['area_m']." square meters";
												}
											}else{
												$floorName = '';
											}
									?>
                                    <tr>
                                    	<th scope="row">
											<?php echo date('Y.m.d',strtotime($negotiation['added_on'])); ?>(<?php echo $day; ?>)
                                        </th>
                                       	<td>
										<?php
                                        	if($negotiation['negotiation_type'] == 1){
												echo Yii::app()->controller->__trans('Tsubo unit price negotiation value (common expenses included)');
											}elseif($negotiation['negotiation_type'] == 2){
												echo Yii::app()->controller->__trans('Deposit negotiation value');
											}elseif($negotiation['negotiation_type'] == 3){												
												echo Yii::app()->controller->__trans('Key money negotiation value');
											}else{
												echo Yii::app()->controller->__trans('Other negotiations information');
											}
											echo " ".$floorName;
										?>
                                        </td>
                                    </tr>
									<?php
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
                                    <input type="radio" name="negotiationType" id="negotiationType" class="negotiationType" value="1"/><?php echo Yii::app()->controller->__trans('Tsubo unit price negotiation value'); ?> (<?php echo Yii::app()->controller->__trans('common expenses included'); ?>)
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