<?php
if(isset($_SESSION[Yii::app()->user->getStateKeyPrefix() .'conditionCriteria'])){
	$conditionCriteria =  Yii::app()->user->getState("conditionCriteria");
	$conditionCriteria =  json_encode($conditionCriteria);
}
$floorQuery = ' 1=1 ';
$pFloorIds = array();
//if(is_array($floorIds) && count($floorIds) > 0 && $floorIds[0]) {
if(is_array($floorIds) && count($floorIds) > 0) {
	$allFloorCounting = count($floorIds);
	$pFloorIds = $floorIds;
	$allFloorsStr = implode(',',$floorIds);
	$floorQuery .= ' AND floor_id IN ('.$allFloorsStr.')';
}else{
	$allFloorCounting = count($floorIds);
}

$allBuildingsStr = implode(',',$buildingIds);
if(isset($topPage) && $topPage == 1){
	//$this->render('searchedBuidingResult',array('resultData'=>$resultData,'fIds'=>$fIds,'topPage'=>1));
	$conditionCriteria =  Yii::app()->user->getState("conditionCriteria");
	$conditionCriteria =  json_encode($conditionCriteria);
}

/* condition critaria only for office alerts */
if(isset($customCondition)){
	$conditionCriteria = json_encode($customCondition);
}

?>
<input type="hidden" value='<?php echo $conditionCriteria; ?>' name="hdnSearchCriteria" id="hdnSearchCriteria" class="hdnSearchCriteria">
<div id="main" class="full-width search_result">
	<div class="postbox">
    	<header class="m-title btnright">
        	<h1 class="main-title"> <?php echo Yii::app()->controller->__trans('Search Result'); ?></h1>
            <div class="add-action">
            	<a href="<?php echo Yii::app()->createUrl('building/create'); ?>"><?php echo Yii::app()->controller->__trans('Add Building'); ?></a>
            </div>
			<?php
            if(isset($isCartList) && $isCartList != ""){
				if(isset($resultData) && count($resultData) > 0){
					$cartBuildingId = '';
					$i = 0;
					$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
					$loguser_id = $user->user_id;
					$cartFIds = array();
					foreach($resultData as $buildingList){
						if(!isset($buildingList['building_id'])) continue;
						if($i == count($resultData)-1){
							$cartBuildingId .= $buildingList['building_id'];
						}else{
							$cartBuildingId .= $buildingList['building_id'].',';
						}
						$i++;
						$floorDetails = Cart::model()->findAll('building_id = '.$buildingList['building_id'].' AND user_id = '.$loguser_id);
						foreach($floorDetails as $flr){
							$cartFIds[] = $flr['floor_id'];
							$cartCondArray[] = json_decode($flr['search_condition'],true);
						}
					}
					
					//$finalCartFloorIds = implode(',',$cartFIds);
					$cartCondArray = array_unique($cartCondArray);
					$cartCondArray = array_values($cartCondArray);
					$cartCondArray = json_encode($cartCondArray);
					
					if(isset($floorIds)){
						$allFloorCounting = count($floorIds);
						$finalCartFloorIds = $cartFIds;
						
						//$finalCartFloorIds = json_encode(array_values($finalCartFloorIds));
						$finalCartFloorIds = array_values($finalCartFloorIds);
						$finalCartFloorIds = implode(',',$finalCartFloorIds);
					}
				}
			?>
            <div class="add-action">
            	<input type="hidden" name="hdnCartBuildId" id="hdnCartBuildId" value="<?php echo $cartBuildingId; ?>" />
                <input type="hidden" name="hdnCartFlrId" id="hdnCartFlrId" value="<?php echo $finalCartFloorIds; ?>" />
                <input type="hidden" name="hdnCartCondition" id="hdnCartCondition" value='<?php echo $cartCondArray; ?>' />
                <a href="#" class="btnSaveProposedArticle" id="btnSaveProposedArticle"><?php echo Yii::app()->controller->__trans('Save the cart contents in the proposed article'); ?></a>
            </div>
			<?php
            }
			?>
        </header>
        <?php
		if(isset($topPage) && $topPage == 1){
			$conditionCriteria =  json_decode($conditionCriteria,true);
		?>
        <div class="divConditionForTopPage">
        	<div class="condition_title">検索条件</div>
            <ul>
            	<?php if(isset($conditionCriteria['propertyValuation']) && $conditionCriteria['propertyValuation'] != ""){	?>
            	<li><i class="fa fa-circle-o"></i> <?php echo $conditionCriteria['propertyValuation']; ?></li>
                <?php }if(isset($conditionCriteria['floor_id_specification']) && $conditionCriteria['floor_id_specification'] != ""){ ?>
                <li><i class="fa fa-circle-o"></i> <?php echo $conditionCriteria['floor_id_specification']; ?></li>
                <?php }if(isset($conditionCriteria['rent_unit_include']) && $conditionCriteria['rent_unit_include'] != ""){ ?>
                <li><i class="fa fa-circle-o"></i> <?php echo $conditionCriteria['rent_unit_include']; ?></li>
                <?php }	?>
            </ul>
        </div>
        <?php
		}
		?>
		<!--<div class="bd_num"><span class="number"><?php //echo count($resultData)?></span><span class="txt_num_a">棟</span><span class="txt_num_b">（<?php //echo (int)$allFloorCounting?>フロア）</span></div>-->
		
		<div class="list-item">
            <div class="main-info clearfix">
                <div class="b-name" style="width:100%;">
                	<h2 class="condition_title" style="float:left">検索条件</h2>
                    <form method="post" name="frmChangeCondition" id="frmChangeCondition" class="frmChangeCondition" action="<?php echo Yii::app()->createUrl('building/searchBuilding'); ?>">
                    	<input type="hidden" value='1' name="changeCondition" id="changeCondition" class="changeCondition">
                        <input type="hidden" value='<?php echo $conditionCriteria; ?>' name="hdnSearchCriteriaToChange" id="hdnSearchCriteriaToChange" class="hdnSearchCriteriaToChange">
                    	<button type="submit" style="width:230px; float:right;">検索条件を変更</button>
                    </form>
                </div>
            </div>
            <form method="get" name="mainSearchCondition" id="mainSearchCondition" action="<?php echo Yii::app()->createUrl('building/searchBuildingResult'); ?>">
            	<div id="dynamic_hidden_fields"></div>
                <div class="room-data clearfix condition_results">
                	<ul class="searchTab clearfix" data-tabname="area">
					<?php
                    	$condReq = $_REQUEST;
						//echo '<pre>'; print_r($condReq);die;
						if(isset($customCondition)) $condReq = $customCondition;
						echo Yii::app()->controller->__getCondition($condReq);
						if(isset($_REQUEST['final_redi'])){
							$finalRediEx = explode('~',$_REQUEST['final_redi']);
							if(isset($finalRediEx[0]) && isset($finalRediEx[1])){
								if(isset($finalRediEx[2]) && $finalRediEx[2] != ''){
									if($finalRediEx[2] == 'drop'){
										echo '<li><span class="condition_name condition_name_list">'.$finalRediEx[0].'の値下がり物件（'.$finalRediEx[1].'）<span></li>';
									}else{
										echo '<li><span class="condition_name condition_name_list">'.$finalRediEx[0].'の値上がり物件（'.$finalRediEx[1].'）<span></li>';
									}
								}else{
									echo '<li><span class="condition_name condition_name_list">'.$finalRediEx[0].'の新着・更新空き物件（'.$finalRediEx[1].'）<span></li>';
								}
							}
						}
          $distrincts = Yii::app()->controller->__getConditionsForView($condReq);

          foreach ($distrincts as $distrinct) {
            echo "<li>" . $distrinct . "</li>";
          }
                    ?>
                    <!-- <div class="selectedSearchCriteria"> -->
                        <!-- <div class="divSelArea"> -->
                            <?php echo $cityCondition; ?>
                        <!-- </div> -->
                    <!-- </div> -->
                    </ul>
                    
                    <div id="hidden_search_fields" style="clear: both; display: none;">
						<?php $aFormMapper = Yii::app()->controller->getBuildingFormMapper(); ?>
                        <div class="more-filter">
                        	<div class="second_part">
                            	<div class="TextField">
                                	<div class="searchform-param">
                                    	<label class="searchform-label date-update"><?php echo Yii::app()->controller->__trans('Facilities'); ?></label>
                                        <div class="fac-check-wrapper">
											<?php foreach($aFormMapper['facilities'] as $value => $field){ ?>
                                            	<input type="checkbox" class="checkbox-one" value="<?php echo $value?>" name="facilities[]" <?php echo in_array($value, (array)$_REQUEST['facilities']) ? 'checked' : ''; ?>/><?php echo $field['name']?>
											<?php } ?>
                                        </div>
                                    </div>
                                </div>
                           	</div>
                            <div class="second_part">
                            	<div class="TextField">
                                	<div class="searchform-param">
                                    	<label class="searchform-label date-update Floor-title"><?php echo Yii::app()->controller->__trans('Type of Floor'); ?></label>
                                        <span class="searchform-input-wrapper select-numbers search-floor">
											<?php foreach($aFormMapper['floorType'] as $value => $field){ ?>
                                            	<input type="checkbox" class="checkbox-one" value="<?php echo $value?>" name="floorType[]" <?php echo in_array($value, (array)$_REQUEST['floorType']) ? 'checked' : ''; ?>/><?php echo $field['name']?>
											<?php } ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col_two clearfix">
                            	<div class="second_part">
                                	<div class="TextField">
                                    	<div class="searchform-param">
                                        	<label class="searchform-label date-update passible-title"><?php echo Yii::app()->controller->__trans('Form of Transaction'); ?></label>
                                            <span class="searchform-input-wrapper select-numbers search-floor">
												<?php foreach($aFormMapper['formTypeList'] as $value => $field){ ?>
                                                	<input type="checkbox" class="checkbox-one" value="<?php echo $value?>" name="formTypeList[]" <?php echo in_array($value, (array)$_REQUEST['formTypeList']) ? 'checked' : ''; ?>/><?php echo $field['name']?>
                                                <?php } ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="second_part">
                                	<div class="TextField">
                                    	<div class="searchform-param">
                                        	<label class="searchform-label date-update type-title"><?php echo Yii::app()->controller->__trans('Type of Lender'); ?></label>
                                            <span class="searchform-input-wrapper select-numbers search-floor">
												<?php foreach($aFormMapper['lenderType'] as $value => $field){ ?>
                                                	<input type="checkbox" class="checkbox-one" value="<?php echo $value?>" name="lenderType[]" <?php echo in_array($value, (array)$_REQUEST['lenderType']) ? 'checked' : ''; ?>/><?php echo $field['name']?>
												<?php } ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col_two clearfix">
                            	<div class="second_part">
                                	<div class="TextField">
                                    	<div class="searchform-param">
                                        	<label class="searchform-label date-update passible-title"><?php echo Yii::app()->controller->__trans('Walk from a Station'); ?></label>
                                            <div class="fac-check-wrapper">
												<?php foreach($aFormMapper['walkFromStation'] as $value => $field){ ?>
                                                	<input type="radio" class="checkbox-one walkFromStation" value="<?php echo $value?>" name="walkFromStation" <?php echo in_array($value, (array)$_REQUEST['walkFromStation']) ? 'checked' : ''; ?>/><?php echo $field['name']?>
												<?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="second_part">
                                	<div class="TextField">
                                    	<div class="searchform-param">
                                        	<label class="searchform-label date-update"><?php echo Yii::app()->controller->__trans('Short Rent'); ?></label>
                                            <span class="searchform-input-wrapper select-numbers search-floor">
												<?php foreach($aFormMapper['shortRent'] as $value => $field){ ?>
                                                	<input type="checkbox" value="<?php echo $value?>" name="shortRent" <?php echo in_array($value, (array)$_REQUEST['shortRent']) ? 'checked' : ''; ?>/><?php echo $field['name']?>
												<?php } ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="searchform-controls clearfix">
                    	<div class="bt-refine">
                        	<input type="button" name="search" id="search_hidden_submit"  value="検索">
                       	</div>
                        <div class="refine-more">
                        	<input type="button" class="result_hidden_button"  value="さらに絞り込む">
                            <input type="button" class="result_hidden_button"  value="絞り込み条件を隠す" style="display: none;">
                       	</div>
                    </div>
                </div>
            </form>
        </div>    
    </div>
    <?php
	if(isset($resultData) && count($resultData) > 0){
		$ci = 0;
		foreach($resultData as $buildingList){
			if(!isset($buildingList['building_id'])) continue;
	?>
    	<div class="search-result-tool clearfix">
        	<?php if($ci == 0){ ?>
            <div class="bd_num">
            	<span class="number">
					<?php echo count($resultData)?>
                </span>
                <span class="txt_num_a">棟</span>
                <span class="txt_num_b">（<?php echo (int)$allFloorCounting?>フロア）</span>
            </div>
            <div class="bt_all">
            	<input type="hidden" name="hdnAllFloorIds" id="hdnAllFloorIds" class="hdnAllFloorIds" value="<?php echo $allFloorsStr; ?>"/>
            	<input type="hidden" name="hdnBuildingId" id="hdnBuildingId" class="hdnBuildingId" value="<?php echo $allBuildingsStr; ?>" />
            	<a href="#" class="btn add_all_list">一覧を全てカートに追加</a>
            </div>
            
            
            <dl class="viewmode">
                <dt>並び替え：</dt>
                <dd class="sortlist">
                    <select class="sortbox-parts" id="building_sortby">
                    	<option value="0">Select Order</option>
                        <option value="1" <?php if ($_REQUEST['sortby'] == 1) echo 'selected="selected"'?>>築年浅順</option><!--from built newly-->
                        <option value="2" <?php if ($_REQUEST['sortby'] == 2) echo 'selected="selected"'?>>駅近</option><!--closer from station-->
                        <option value="3" <?php if ($_REQUEST['sortby'] == 3) echo 'selected="selected"'?>>坪数</option><!--from larger area-->
                        <option value="4" <?php if ($_REQUEST['sortby'] == 4) echo 'selected="selected"'?>>基準階面積</option><!--from larger average area-->
                        <option value="5" <?php if ($_REQUEST['sortby'] == 5) echo 'selected="selected"'?>>賃料</option><!--from cheaper rent fee-->
                        <option value="6" <?php if ($_REQUEST['sortby'] == 6) echo 'selected="selected"'?>>保証金</option><!--from cheaper security money-->
                        <option value="7" <?php if ($_REQUEST['sortby'] == 7) echo 'selected="selected"'?>>フリーレント期間</option><!--from longer free rent time-->
                        <option value="8" <?php if ($_REQUEST['sortby'] == 8) echo 'selected="selected"'?>>手数料</option><!--from cheaper commission fee-->
                        <option value="9" <?php if ($_REQUEST['sortby'] == 9) echo 'selected="selected"'?>>更新日</option><!--from latest updated info-->
                    </select>
                </dd>
            </dl>
            <?PHP } $ci++; ?>
        </div><!--/search-result-tool-->
        
        <div class="list-item">
        	<div class="main-info clearfix">
            	<div class="b-name">
                	<h2><?php echo $buildingList['name']; 
                    //if($buildingList['bill_check']!=1) echo "ビル";?>
                    <small> ( ID : <?php echo $buildingList['buildingId']; ?> )</small></h2>
                </div>
                
                <div class="sb-info">
					<?php echo $buildingList['address']; ?> /
					<?PHP
						$nearestSt = BuildingStation::model()->getNearestStation($buildingList['building_id']);
						if(isset($nearestSt['name']) && isset($nearestSt['time'])){
							echo $nearestSt['name'].' 駅 '.$nearestSt['time'].' 分';
						}
                    ?>
                    <br>
					<?php
                        $extractYear = explode('-',$buildingList['built_year']);
                        $year = $extractYear[0];
                        $month = $extractYear[1];
                        echo $year.' 年'.$month.' 月';
                    	echo Yii::app()->controller->__trans('築'); ?>/フロア最終更新：<?php echo date('Y-m-d',strtotime($buildingList['modified_on']));
					?>
                </div>
                
                <div class="bulk">
 <!--              	<a href="<?php echo Yii::app()->createUrl('building/update',array('id'=>$buildingList['building_id'])); ?>"> -->
 					
                	<a target="_blank" href="<?php echo Yii::app()->createUrl('floor/viewFloorMass',array('id'=>$buildingList['building_id'], 'update_management'=>0)); ?>" 
                	onclick="window.open('<?php echo Yii::app()->createUrl('floor/viewFloorMass',array('id'=>$buildingList['building_id'])); ?>', 'newwindow', 'height=' + (screen.height-120) + ',width=' + screen.width); return false;">
                    	<button type="button" class="btn btn-primary"><?php echo Yii::app()->controller->__trans('BULK UPDATE'); ?></button>
                    </a>
                </div>
                
                <div class="bulk">
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
							<?php echo date('Y.m.d',strtotime($finalComission[0]['modified_on'])); ?>
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
                            <button type="button" name="btnUpdateFreeRent" class="btnUpdateFreeRent"><?php echo Yii::app()->controller->__trans('Update'); ?></button>
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
						$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingList['building_id'].'  AND `is_compart` != 1  AND `is_shared` != 1 GROUP BY ownership_management.ownership_type';
						$commonOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
						
						if(isset($commonOwnerDetails) && count($commonOwnerDetails) > 0){
							foreach($commonOwnerDetails as $common){
						?>
						<div class="propri">
                        	<span>
							<?php
							$managementArray = array(1 => Yii::app()->controller->__trans('owner'),6 => 'サブリース',7 => '貸主代理',	8 => 'AM',10 => '業者',4 => Yii::app()->controller->__trans('intermediary agent'),2 => Yii::app()->controller->__trans('management company'),9 => Yii::app()->controller->__trans('PM'),3 => Yii::app()->controller->__trans('general contractor'),-1 => Yii::app()->controller->__trans('unknown'));
							
							if(array_key_exists($common['ownership_type'],$managementArray)){
								echo $managementArray[$common['ownership_type']];
							}													
							?>
							</span>
							<?php echo $common['owner_company_name'];?>
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
                                        /*if(isset($fIds) && count($fIds) > 0){
											$floorDetails = Floor::model()->findAll('building_id = '.$buildingList['building_id'].' AND vacancy_info = 1');
											foreach($floorDetails as $floor){
												if(in_array($floor['floor_id'],$fIds)){
													$flootList[] = Floor::model()->findByPk($floor['floor_id']);
												}
											}
										}else{*/
										//$floorList = Floor::model()->findAllByAttributes(array('floor_id'=>$floorIds));
										$flootList = Floor::model()->findAll($floorQuery.' AND building_id = '.$buildingList['building_id'] . ' ORDER BY cast(floor_down as SIGNED) ASC, cast(floor_up as SIGNED) ASC');
										//}
										$floorIds = array();
                                        if(isset($flootList) && count($flootList)){
                                            foreach($flootList as $floors){
                                                $floorIds[] = $floors['floor_id'];
                                            }
                                            $allFloorIds = implode(',',$floorIds);
                                        }

										if(isset($_REQUEST['fIds'])){
											$NallFloorIds = explode(',',$_REQUEST['fIds']);
											$NallFloorIds = array_unique($NallFloorIds);
											$allFloorIds = array_intersect($floorIds,$NallFloorIds);
											$allFloorIds = implode(',',$allFloorIds);

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
							
							//compart floor details
							$compartOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingList['building_id'].' and is_compart = 1');
							$cFloorIds = array();
							if(count($compartOwnerFloor) > 0){
								foreach($compartOwnerFloor as $cFloor){
									$cFloorIds[] = $cFloor['floor_id'];
								}
							}
							
							//shared floor details
							$sharedOwnerFloor = OwnershipManagement::model()->findAll('building_id = '.$buildingList['building_id'].' and is_shared = 1');
							$sFloorIds = array();
							if(count($sharedOwnerFloor) > 0){
								foreach($sharedOwnerFloor as $sFloor){
									$sFloorIds[] = $sFloor['floor_id'];
								}
							}
							
							
							if(isset($flootList) && count($flootList) > 0){
								foreach($flootList as $list){
									if(isset($fIds) && count($fIds) > 0){
										if(!(in_array($list->floor_id,$fIds))){
											continue;
										}
									}
									if(isset($cartFIds) && count($cartFIds) > 0){
										if(!(in_array($list->floor_id,$cartFIds))){
											continue;
										}
									}
									if(isset($pFloorIds) && count($pFloorIds) > 0){
										if(!(in_array($list->floor_id,$pFloorIds))){
											continue;
										}
									}
									if(in_array($list->floor_id,$cFloorIds)){
										continue;
									}
									if(in_array($list->floor_id,$sFloorIds)){
										continue;
									}
									
									
						?>
                        	<tr class="trFloor <?php $this->changeColor($list->floor_id); ?>"  data-href='<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$list->floor_id)); ?>'>
                            	<td>
                                	<input type="hidden" name="hdnBuildingId" id="hdnBuildingId" class="hdnBuildingId" value="<?php echo $buildingList['building_id']; ?>" />
                                    <input type="hidden" name="hdnFloorId" id="hdnFloorId" class="hdnFloorId" value="<?php echo $list->floor_id; ?>" />
                                    <?php
									$cartDetails = Cart::model()->findAll('user_id = '.$logged_user_id.' AND floor_id = '.$list->floor_id.' AND building_id = '.$buildingList['building_id']);
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
										if(strpos($list->floor_down, '-') !== false){
											$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $list->floor_down);
										}else{
											$floorDown = $list->floor_down;
										}
										$stairs = $floorDown;
										$stairs .= '階'.$list->floor_up;
										echo $stairs.'  '.$list->roomname;
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
                                        if(isset($list->total_rent_price) && $list->total_rent_price != ""){
                                            echo Yii::app()->controller->renderPrice($list->total_rent_price).'円';
                                        }else{
                                            if($list->rent_unit_price_opt != ''){
                                                if($list->rent_unit_price_opt == -1){
                                                    echo Yii::app()->controller->__trans('undecided');
                                                }else if($list->rent_unit_price_opt == -2){
                                                    echo Yii::app()->controller->__trans('ask');
                                                }
                                            }else{
                                                echo '';
                                            }
                                        }
                                    ?>
                                    <br>
                                    <?php
										if(isset($list->rent_unit_price) && $list->rent_unit_price != "" && $list->rent_unit_price != 0){
											echo '('.Yii::app()->controller->renderPrice($list->rent_unit_price).Yii::app()->controller->__trans('yen / tsubo').')';
										}else{
											echo '';
										}
									?>
                                </td>
                                <td>
									<?php
                                        if(isset($list->total_condo_fee) && $list->total_condo_fee != ""){
                                            echo ''.Yii::app()->controller->renderPrice($list->total_condo_fee).Yii::app()->controller->__trans('yen').'';
                                        }else{
                                            if($list->unit_condo_fee_opt != ''){
                                                if($list->unit_condo_fee_opt == 0){
                                                    echo Yii::app()->controller->__trans('none');
                                                }else if($list->unit_condo_fee_opt == -1){
                                                    echo Yii::app()->controller->__trans('undecided');
                                                }else if($list->unit_condo_fee_opt == -2){
                                                    echo Yii::app()->controller->__trans('ask');
                                                }else if($list->unit_condo_fee_opt == -3){
                                                    echo Yii::app()->controller->__trans('include');
                                                }
                                            }else{
                                                echo '';
                                            }
                                        }
                                    ?>
                                    <br>
									<?php
                                        if(isset($list->unit_condo_fee) && $list->unit_condo_fee != ""){
                                            echo '('.Yii::app()->controller->renderPrice($list->unit_condo_fee).Yii::app()->controller->__trans('yen / tsubo').')';
                                        }else{
                                            echo '';
                                        }
                                    ?>
                                </td>
                                <td>
									<?php
                                        if(isset($list->total_deposit) && $list->total_deposit != "0" && $list->total_deposit != ""){
                                            echo Yii::app()->controller->renderPrice($list->total_deposit).' 円';
                                        }
                                        if($list->deposit_opt != ''){
                                            echo '<br/>';
                                            if($list->deposit_opt == -1){
                                                echo Yii::app()->controller->__trans('undecided');
                                            }else if($list->deposit_opt == -3){
                                                echo Yii::app()->controller->__trans('none');
                                            }else if($list->deposit_opt == -2){
                                                echo Yii::app()->controller->__trans('undecided･ask');
                                            }
                                        }
                                        if(isset($list->deposit_month) &&  $list->deposit_month != ''){
                                            echo '<br/>'.$list->deposit_month.' ヶ月';
                                        }
                                    ?>
                                    <br>
									<?php
                                        if(isset($list->deposit) && $list->deposit != ""){
                                            echo '('.$list->deposit.Yii::app()->controller->__trans('yen / tsubo').')';
                                        }else{
                                            echo '';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
										if(isset($list->key_money_opt) && $list->key_money_opt != ""){
											if($list->key_money_opt == 2){
												echo Yii::app()->controller->__trans('None');
											}elseif($list->key_money_opt == -1){
												echo Yii::app()->controller->__trans('Unknown');
											}elseif($list->key_money_opt == -2){
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
										if(isset($list->renewal_fee_opt) && $list->renewal_fee_opt != ""){
											if($list->renewal_fee_opt == 2){
												echo Yii::app()->controller->__trans('None');
											}elseif($list->renewal_fee_opt == -1){
												echo Yii::app()->controller->__trans('Unknown');
											}elseif($list->renewal_fee_opt == -2){
												echo Yii::app()->controller->__trans('Undecided･ask');
											}else{
												echo '';
											}
										}

										if(isset($list->renewal_fee_reason) && $list->renewal_fee_reason != ""){
											if($list->renewal_fee_reason == 1){
												echo Yii::app()->controller->__trans('現賃料の');
											}elseif($list->renewal_fee_reason == 2){
												echo Yii::app()->controller->__trans('新賃料の');
											}else{
												echo '';
											}
										}

										if(isset($list->renewal_fee_recent) && $list->renewal_fee_recent != ""){
											echo $list->renewal_fee_recent.Yii::app()->controller->__trans('month');
										}
									?>
                                </td>
                                <td>
                                    <?php
										if(isset($list->repayment_opt) && $list->repayment_opt != ""){
											if($list->repayment_opt == -3){
												echo Yii::app()->controller->__trans('None')."<br>";
											}elseif($list->repayment_opt == -4){
												echo Yii::app()->controller->__trans('Unknown')."<br>";
											}elseif($list->repayment_opt == -1){
												echo Yii::app()->controller->__trans('Undecided')."<br>";
											}elseif($list->repayment_opt == -2){
												echo Yii::app()->controller->__trans('Ask')."<br>";
											}elseif($list->repayment_opt == -5){
												echo Yii::app()->controller->__trans('Sliding')."<br>";
											}else{
												echo '';
											}
										}
	
										if(isset($list->repayment_reason) && $list->repayment_reason != ""){
											if($list->repayment_reason == 1){
												echo Yii::app()->controller->__trans('現賃料の')."<br>";
											}elseif($list->repayment_reason == 2){
												echo Yii::app()->controller->__trans('解約時賃料の')."<br>";
											}else{
												echo '';
											}
										}
	
										if(isset($list->repayment_amt) && $list->repayment_amt != ""){
											echo $list->repayment_amt;
										}
	
										if(isset($list->repayment_amt_opt) && $list->repayment_amt_opt != ""){
											if($list->repayment_amt_opt == 1){
												echo Yii::app()->controller->__trans('ヶ月');
											}elseif($list->repayment_amt_opt == 2){
												echo Yii::app()->controller->__trans('%')."<br>";
											}else{
												echo '';
											}
										}
									?>
                                </td>
                                <td>
                                	<?php
										if(isset($list->move_in_date) && $list->move_in_date != "" && (string)$list->move_in_date != '0'){
											echo $list->move_in_date;
										}else{
											echo '-';
										}
									?>
                                </td>
                                <td>
                                	<ul class="icon-facilities">
                                    <?php if($list->separate_toilet_by_gender == 2){ ?>
                                    	<li> <span class="icon-jpdb-facilities-icons-wc"></span></li>
                                    <?php } ?>
                                    <?php if($list->air_conditioning_facility_type == '個別'){ ?>
                                    	<li><span class="icon-jpdb-facilities-icons-ac"></span></li>
                                    <?php } ?>
                                    <?php
                                    $buildDetails = Building::model()->find('building_id  = '.$list->building_id);
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
                       	<?php
								}
						?>
                        <?php                                
                                $query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingList['building_id'].' AND `is_compart` = 1 GROUP BY ownership_type';
								$allCompartOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
								
                                $cFloorIDs = array();
                                $ownerNames = array();
                                foreach($allCompartOwnerDetails as $aFloor){
									$fVacntDetails = Floor::model()->findByPk($aFloor['floor_id']);
									if($fVacntDetails->vacancy_info == 1){
                                    	$cFloorIDs[] = $aFloor['floor_id'];
                                    	$ownerNames[$aFloor['ownership_type']] = $aFloor['owner_company_name'];
									}
                                }
                                
                                $cFloorIDs = array_unique($cFloorIDs);
                                if(count($cFloorIDs) > 0){
                                    foreach($flootList as $fId){
										if(!(in_array($fId->floor_id,$cFloorIDs))){
											continue;
										}
                                        $oDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingList['building_id'].' and floor_id ='.$fId->floor_id.' AND is_compart = 1');
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
                                	$floorDetails = Floor::model()->find('floor_id = '.$fId->floor_id.' AND vacancy_info = 1');
									if(!empty($floorDetails)){                                        
                                ?>
                                    <tr class="trFloor <?php $this->changeColor($floorDetails['floor_id']); ?>" data-href='<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$floorDetails['floor_id']))?>'>
                                        <td>
                                            <?php
                                                $cartDetails = Cart::model()->findAll('user_id = '.$logged_user_id.' AND floor_id = '.$floorDetails['floor_id'].' AND building_id = '.$buildingList['building_id']);
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
                                }
                            }
                            ?>
                            
                            <?php
								$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$buildingList['building_id'].' AND `is_shared` = 1';
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
									foreach($flootList as $fId){
										if(!(in_array($fId->floor_id,$sFloorIDs))){
											continue;
										}
										$oDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingList['building_id'].' and floor_id ='.$fId->floor_id.' AND is_shared = 1');
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
                                        $floorDetails = Floor::model()->find('floor_id = '.$fId->floor_id.' AND vacancy_info = 1');
                                        if(!empty($floorDetails)){
                                        
                                ?>
                                    <tr class="trFloor <?php $this->changeColor($floorDetails['floor_id']); ?>" data-href='<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$floorDetails['floor_id']))?>'>
                                        <td>
                                            <?php
                                                $cartDetails = Cart::model()->findAll('user_id = '.$logged_user_id.' AND floor_id = '.$floorDetails['floor_id'].' AND building_id = '.$buildingList['building_id']);
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
												<?php
													$days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
													$day = array_search((date('D',strtotime($list['added_on']))), $days);
												?>
												<?php echo date('Y.m.d',strtotime($list['added_on'])); ?>(<?php echo $day; ?>)
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
                        	<dt>
                            	賃料交渉履歴
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
									$days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
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
													$floorName .= " / ".$floor['area_ping']." ".Yii::app()->controller->__trans('tsubo').' '.$negotiation['negotiation_note'];;
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
		}else{
		?>
        <h4><?php echo Yii::app()->controller->__trans('No Records available for given condition'); ?> .</h4>
        <?php
		}
		?>
    </div>
</div>

<!--Modal Popup for Add New Type-->
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
        	<h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Free Rent'); ?></h2>
            <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>
        <div class="box-content">
        	<form name="frmAddFreeRent" id="frmAddFreeRent" class="frmAddFreeRent" data-action="<?php echo Yii::app()->createUrl('building/saveFreeRent'); ?>">
            	<table>
                	<tr>
                    	<td><?php echo Yii::app()->controller->__trans('Free Rent'); ?></td>
                        <td>
                        	<input type="hidden" name="rentBuildId" id="rentBuildId" class="rentBuildId" value="0" />
                        	<input type="text" name="freeRentMonth" id="freeRentMonth" class="freeRentMonth" style="width:50% !important;"/>&nbsp;&nbsp;<?php echo Yii::app()->controller->__trans('Months'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo Yii::app()->controller->__trans('Expiration date of the information'); ?> (<?php echo Yii::app()->controller->__trans('optional'); ?>)</td>
                        <td>
                        	<input type="text" name="expirationDate" id="expirationDate" class="expirationDate" style="width:50% !important;"/>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo Yii::app()->controller->__trans('Target floor'); ?> (<?php echo Yii::app()->controller->__trans('optional'); ?>)</td>
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
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Rent Negotiation'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
	<form name="frmAddRentNegotiation" id="frmAddRentNegotiation" class="frmAddRentNegotiation" data-action="<?php echo Yii::app()->createUrl('building/saveRentNegotiation'); ?>"  onkeypress="return event.keyCode != 13;">
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
            <td>
				<div class="floorListForRentNegotiation"></div>
            </td>
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

<!--Modal Popup for Add cart to proposed article-->
<div class="modal-box hide" id="modalProposedArticle">
	<div class="content transmissionContent">
    	<div class="box-header">
        	<h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Proposed Article'); ?></h2>
            <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>
        <div class="box-content">
        	<form name="frmAddBuildToProposedList" id="frmAddBuildToProposedList" class="frmAddBuildToProposedList" data-action="<?php echo Yii::app()->createUrl('proposedArticle/addProposedArticle'); ?>">
            	<input type="hidden" name="hdnCartBuildingId" id="hdnCartBuildingId" class="hdnCartBuildingId" value="0"/>
                <input type="hidden" name="hdnCartFloorId" id="hdnCartFloorId" class="hdnCartFloorId" value="0"/>
                <input type="hidden" name="hdnCartCond" id="hdnCartCond" class="hdnCartCond" value=""/>
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
                        	<select name="proposedCustomerName" id="proposedCustomerName" class="proposedCustomerName js-example-basic-single">
                            	<option value="0">-</option>
                                <?php
								$customerList = Customer::model()->findAll();
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