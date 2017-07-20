<!-- <div style=" max-width: 1050px;width: 100%;margin: 20px auto;clear: both;" class="full-width search_result">
    <div class="postbox">
    <div class="list-item">
            <header class="m-title btnright" style="margin-bottom: 0px; ">
                <h1 class="main-title">検索条件</h1>
            </header>
            <div class="post">
            
            <form method="get" name="mainSearchCondition" id="mainSearchCondition" action="<?php echo Yii::app()->createUrl('building/searchBuildingResult'); ?>">
                <div class="room-data clearfix condition_results">
                    <ul class="searchTab clearfix" data-tabname="area">
                    <?php
                        if(isset($customCondition)) $condReq = $customCondition;
                        echo Yii::app()->controller->__getCondition($condReq);
                        
          $distrincts = Yii::app()->controller->__getConditionsForView($condReq);

          foreach ($distrincts as $distrinct) {
            echo "<li>" . $distrinct . "</li>";
          }
                    ?>
                    </ul>
                    
                    </div>
                    </div>
            </form>
        </div>  
    </div>  
    
</div> -->

<div id="main" class="single-customer">
	<div class="postbox">
    	<header class="m-title btnright clearfix">
        	<h1 class="main-title">
			<?php
            if(isset($customerDetails->company_name) && $customerDetails->company_name != ''){
				echo $customerDetails->company_name;
			}
			?>
            </h1>
            <div class="customer-meta"><span class="customer-id">ID:
			<?php  
			if(isset($customerDetails->customerId) && $customerDetails->customerId != ''){
				echo $customerDetails->customerId;
			}  
			?>
            </span><span class="custoemr-pic">担当:
            <?php  
			if(isset($customerDetails->sales_staff_id) && $customerDetails->sales_staff_id != ''){
				$userDetails = AdminDetails::model()->find('user_id = '.$customerDetails->sales_staff_id);
				echo $userDetails['full_name'];
			}  
			?>
            </span></div>
        </header>
        <span class="bt_update">
            <a href="<?php echo Yii::app()->createUrl('building/searchBuilding',array('id'=>$customerDetails->customer_id,'type'=>'office')) ?>">
                <?php echo Yii::app()->controller->__trans('Set Office Alert'); ?>
            </a>
        </span>
        <ul class="tabs">
        	<li class="<?PHP echo isset($_GET['show']) && $_GET['show'] != 1 ? '' : 'active'; ?>">
            	<a href="#"><?php echo Yii::app()->controller->__trans('Client Details'); ?></a>
            </li>
            <li class="<?PHP echo isset($_GET['show']) && $_GET['show'] == 2 ? 'active' : ''; ?>">
            	<a href="#"><?php echo Yii::app()->controller->__trans('Client Requirement'); ?></a>
            </li>
            <li class="<?PHP echo isset($_GET['show']) && $_GET['show'] == 3 ? 'active' : ''; ?>">
            	<a href="#"><?php echo Yii::app()->controller->__trans('Proposal Document List'); ?></a>
            </li>
        </ul>
        <div class="clear"></div>
        <div class="tabs_content">
        	<div class="tab_con" style="display: <?php echo isset($_GET['show']) && $_GET['show'] != 1 ? 'none' : 'block'; ?>">
            	
                <div class="client-info clearfix">
                <h4 class="ontable">
					<?php
            if(isset($customerDetails->company_name) && $customerDetails->company_name != ''){
				echo $customerDetails->company_name;
			}
			?>
            <span class="kana">
            <?php
            if(isset($customerDetails->company_name_kana) && $customerDetails->company_name_kana != ''){
				echo $customerDetails->company_name_kana;
			}
			?>
            </span>
            <span class="bt_update">
                	<a href="<?php echo Yii::app()->createUrl('customer/updateCustomerInfo',array('id'=>$customerDetails->customer_id,'type'=>1)); ?>" id="btnUpdateEditCustomer" class="btnUpdateEditCustomer"><?php echo Yii::app()->controller->__trans('Edit');?></a>
                </span>
                </h4>
                    <table class="customer-details table-style2">
                        <tbody>
                            <tr>
                                <th>
                                    <?php echo Yii::app()->controller->__trans('業種'); ?>
                                </th>
                                <td>
                                    <?php
                                    if(isset($businessType->business_name) && $businessType->business_name!= ''){
                                        echo $businessType->business_name;
                                    }
                                    ?>
                                </td>
                                <th>
                                    <?php echo Yii::app()->controller->__trans('URL');?>
                                </th>
                                <td>
                                    <?php
                                    if(isset($customerDetails->url) && $customerDetails->url != ''){
                                        echo $customerDetails->url;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <?php echo Yii::app()->controller->__trans('Representative'); ?>
                                </th>
                                <td>
                                    <?php
                                    if(isset($customerDetails->president_name) && $customerDetails->president_name!= ''){
                                        echo $customerDetails->president_name;
                                    }
                                    ?>
                                </td>
                                <th>
                                    <?php echo Yii::app()->controller->__trans('number of employee'); ?>
                                </th>
                                <td>
                                    <?php
                                    if(isset($customerDetails->number_of_emp) && $customerDetails->number_of_emp != ''){
                                        echo $customerDetails->number_of_emp;
                                    }
                                    ?>人
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <?php echo Yii::app()->controller->__trans('Address'); ?>
                                </th>
                                <td>
                                    <?php
                                    if(isset($customerDetails->address ) && $customerDetails->address != ''){
                                        echo '〒 '.$customerDetails->postal_code." ".$customerDetails->address;
                                    }
                                    ?>
                                </td>
                                <th>
                                    <?php echo Yii::app()->controller->__trans('Customer Source');?>
                                </th>
                                <td>
                                    <?php
                                    if(isset($customerSource->source_name) && $customerSource->source_name != ''){
                                        echo $customerSource->source_name;
                                    }
									if(isset($customerDetails->introducer_id) && $customerDetails->introducer_id != 0){
										$introDetails = Introducer::model()->findByPk($customerDetails->introducer_id);
										echo ' ('.$introDetails['introducer_name'].')';
									}
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <?php echo Yii::app()->controller->__trans('TEL'); ?>
                                </th>
                                <td>
                                    <?php
                                    if(isset($customerDetails->phone_no) && $customerDetails->phone_no != ''){
                                        echo $customerDetails->phone_no;
                                    }
                                    ?>
                                </td>
                                <th rowspan="2">
                                    <?php echo Yii::app()->controller->__trans('Note'); ?>
                                </th>
                                <td rowspan="2">
                                    <?php
                                    if(isset($customerDetails->note) && $customerDetails->note != ''){
                                        echo $customerDetails->note;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <?php echo Yii::app()->controller->__trans('FAX'); ?>
                                </th>
                                <td>
                                    <?php
                                    if(isset($customerDetails->fax_no) && $customerDetails->fax_no != ''){
                                        echo $customerDetails->fax_no;
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <h4 class="ontable">
					<?php echo Yii::app()->controller->__trans('Person in charge of the customer'); ?>
                    <span class="bt_update">
                	<a href="<?php echo Yii::app()->createUrl('customer/updateCustomerInfo',array('id'=>$customerDetails->customer_id,'type'=>2)); ?>" id="btnUpdateEditCustomer" class="btnUpdateEditCustomer"><?php echo Yii::app()->controller->__trans('Edit');?></a>
                </span>
                </h4>
                <table class="customer-manager table-style2">
                	<tbody>
                    	<tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('担当者氏名'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerDetails->person_incharge_name) && $customerDetails->person_incharge_name != ''){
									echo $customerDetails->person_incharge_name;
								}
								?>
                            </td>
                            <th>
								<?php echo Yii::app()->controller->__trans('TEL'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerDetails->person_phone_no) && $customerDetails->person_phone_no != ''){
									echo $customerDetails->person_phone_no;
								}
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Position'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerDetails->position) && $customerDetails->position != ''){
									echo $customerDetails->position;
								}
								?>
                            </td>
                            <th>
								<?php echo Yii::app()->controller->__trans('FAX'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerDetails->person_fax_no) && $customerDetails->person_fax_no != ''){
									echo $customerDetails->person_fax_no;
								}
								?>
                            </td>
                       	</tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Branch'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerDetails->branch_name) && $customerDetails->branch_name != ''){
									echo $customerDetails->branch_name;
								}
								?>
                            </td>
                            <th>
								<?php echo Yii::app()->controller->__trans('Cellphone'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerDetails->cellphone_no) && $customerDetails->cellphone_no != ''){
									echo $customerDetails->cellphone_no;
								}
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Department'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerDetails->department) && $customerDetails->department != ''){
									echo $customerDetails->department;
								}
								?>
                            </td>
                            <th>
								<?php echo Yii::app()->controller->__trans('email'); ?>
                            </th>
                            <td>
                            	<?php
                                if(isset($customerDetails->email) && $customerDetails->email != ''){
								?>
                                <a href="mailto:<?php echo $customerDetails->email;?>" title="<?php echo $customerDetails->email;?>"><?php echo $customerDetails->email;?></a>	
								<?php
								}
								?>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab_con" style="display: <?PHP echo isset($_GET['show']) && $_GET['show'] == 2 ? 'block' : 'none'; ?>;">
            	<h4 class="ontable">
					<?php echo Yii::app()->controller->__trans('Requirement of property'); ?>
                    <span class="bt_update">
                        <a href="<?php echo Yii::app()->createUrl('customer/changeCustomerReqInfo',array('id'=>$customerDetails->customer_id)); ?>" class="btnGetCustomerReqInfo">
							<?php echo Yii::app()->controller->__trans('edit'); ?>
                        </a>
                    </span>
                </h4>
                <table class="customer-manager table-style2">
                	<tbody>
                    	<tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Type of property'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerReqDetails['type_of_property'])){
									$typProperty = explode(',' , $customerReqDetails['type_of_property']);
									$propertyType1 = PropertyType::model()->findAllByAttributes(array('property_type_id' => $typProperty));
									if(isset($propertyType1) && count($propertyType1) > 0){
										$i = 0;
										foreach($propertyType1 as $prop){
											if($i == count($propertyType1)- 1){
												$comma = '';
											}else{
												$comma = ',';
											}
											echo $prop['property_type_name'].$comma;
											$i++;
										}
									}
								}else{
									echo '-';
								}
								?>
                           	</td>
                            <th>
								<?php echo Yii::app()->controller->__trans('Rent fee(incl condo fee)'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerReqDetails['rent_price']) && $customerReqDetails['rent_price'] != ''){
									$rent_price_ex = explode('-',$customerReqDetails['rent_price']);
									
									if($rent_price_ex[0] != '' && $rent_price_ex[0] != '-'){
										echo $rent_price_ex[0].'万';
									}
									if($rent_price_ex[1] != '' && $rent_price_ex[1] != '-'){
										if($rent_price_ex[0] != ""){
											echo ' - '.$rent_price_ex[1].'万';
										}else{
											echo $rent_price_ex[1].'万';
										}
									}									
								}else{
									echo '-';
								}
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Area of location'); ?>
                            </th>
                            <td>
								<?php
								if(isset($customerReqDetails['area']) && $customerReqDetails['area'] != ''){
									echo $customerReqDetails['area'];
								}
								
                                if(isset($customerReqDetails['area_group']) && $customerReqDetails['area_group'] != ''){
									if($customerReqDetails['area_group'] == 1){
										echo Yii::app()->controller->__trans('エリアA（千代田／中央／港／新宿／渋谷）');
									}elseif($customerReqDetails['area_group'] == 2){
										echo Yii::app()->controller->__trans('エリアB（品川／豊島／文京／台東／目黒）');
									}elseif($customerReqDetails['area_group'] == 3){
										echo Yii::app()->controller->__trans('エリアC（中野／世田谷／江東');
									}else{
										echo '';
									}
								}
								?>
                            </td>
                            <th>
								<?php echo Yii::app()->controller->__trans('Notice of cancellation'); ?>
                            </th>
                            <td>
								<?php
                                	if(isset($customerReqDetails['notice_of_cancellation'] ) && $customerReqDetails['notice_of_cancellation'] != ''){
										if($customerReqDetails['notice_of_cancellation'] == 1){
											echo Yii::app()->controller->__trans('済');
										}elseif($customerReqDetails['notice_of_cancellation'] == 2){
											echo Yii::app()->controller->__trans('未');
										}else{
											echo '-';
										}
									}else{
										echo '-';
									}
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Reason of area'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerReqDetails['reason_for_area']) && $customerReqDetails['reason_for_area'] != ''){
									echo $customerReqDetails['reason_for_area'];
								}
								?>
                            </td>
                            <th>
								<?php echo Yii::app()->controller->__trans('Parking'); ?>
                            </th>
                            <td>
								<?php  echo isset($customerReqDetails['parking'])&& $customerReqDetails['parking'] != ''? $customerReqDetails['parking'].Yii::app()->controller->__trans('台'):'-'; ?>
                            </td>
                        </tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Floor space'); ?>
                            </th>
                            <td>
								<?php echo isset($customerReqDetails['floor_space_min']) && isset($customerReqDetails['floor_space_max']) && $customerReqDetails['floor_space_min'] != '-' &&  $customerReqDetails['floor_space_max'] != '-'? $customerReqDetails['floor_space_min'].'-'.$customerReqDetails['floor_space_max'].'坪':'-'; ?>
                            </td>
                            <th>
								<?php echo Yii::app()->controller->__trans('Number of floor'); ?>
                            </th>
                            <td>
								<?php  echo isset($customerReqDetails['number_of_floor']) && $customerReqDetails['number_of_floor'] != '' ? $customerReqDetails['number_of_floor'] : '-' ; ?>
                            </td>
                       	</tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Date to move in'); ?>
                            </th>
                            <td>
								<?php
								if(isset($customerReqDetails['move_in_date']) && $customerReqDetails['move_in_date'] != ''){
									if(strpos($customerReqDetails['move_in_date'],'未定') !== false){
										echo '未定';
									}else{
										$moveDate = explode('-',$customerReqDetails['move_in_date']);
										echo $moveDate[0].'年'.$moveDate[1].'月'.$moveDate[2];
									}
								}else{
									echo '-';
								}
                                ?>
                            </td>
                            <th rowspan="2">
								<?php echo Yii::app()->controller->__trans('Comment'); ?>
                            </th>
                            <td rowspan="2">
								<?php echo isset($customerReqDetails['comments']) && $customerReqDetails['comments'] != ''? $customerReqDetails['comments'] : '-'; ?>
                            </td>
                       	</tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Reason of moving'); ?>
                            </th>
                            <td>
								<?php echo isset($customerReqDetails['reason_of_moving']) && $customerReqDetails['reason_of_moving'] != ''? $customerReqDetails['reason_of_moving'] : '-'; ?>
                            </td>
                       	</tr>
                        <tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Current rent unit price'); ?>
                           	</th>
                            <td>
								<?php echo isset($customerReqDetails['current_rent_unit_price_per_tsubo']) && $customerReqDetails['current_rent_unit_price_per_tsubo'] != '' ? $customerReqDetails['current_rent_unit_price_per_tsubo'].'万' : '-';  ?>
                            </td>
                            <th>
								<?php echo Yii::app()->controller->__trans('Current floor space'); ?>
                            </th>
                            <td>
								<?php echo isset($customerReqDetails['current_number_of_tsubo']) && $customerReqDetails['current_number_of_tsubo'] != ''? $customerReqDetails['current_number_of_tsubo'].' 坪' : '-'; ?>
                            </td>
                        </tr>
                        <tr class="ex-rev">
                        	<th>
								<?php echo Yii::app()->controller->__trans('Expected revenue'); ?>
                           	</th>
                            <td>
								<?php echo isset($customerReqDetails['estimated_sales_amount']) && $customerReqDetails['estimated_sales_amount'] != ''? number_format($customerReqDetails['estimated_sales_amount']).'円' : '-'; ?>
                            </td>
                            <th>
								<?php echo Yii::app()->controller->__trans('Expected revenue date'); ?>
                            </th>
                            <td>
								<?php
                                if(isset($customerReqDetails['estimated_sales_date'])){
									if($customerReqDetails['estimated_sales_date'] == '未定'){
										echo $customerReqDetails['estimated_sales_date'];
									}else{
										$exDate = explode('-',$customerReqDetails['estimated_sales_date']);
										echo $exDate[0].'年'.$exDate[1].'月';
									}
								}else{
									echo '-';
								}
								?>
                            </td>
                        </tr>
                   	</tbody>
                </table>
            </div>
            
            <div class="tab_con" style="display: <?PHP echo isset($_GET['show']) && $_GET['show'] == 3 ? 'block' : 'none'; ?>;">
            	<h2 class="tb-title"><?php echo Yii::app()->controller->__trans('Proposal Article List'); ?></h2>
				<?php
                if(isset($customerDetails->customer_id) && $customerDetails->customer_id != ''){
					$proposedList = Yii::app()->db->createCommand('SELECT * FROM office_alert where customer_id = '.$customerDetails->customer_id.' ORDER BY office_alert_id DESC')->queryAll();
					$proposedArticlesList = Yii::app()->db->createCommand('SELECT * FROM proposed_article where customer_id = '.$customerDetails->customer_id.' ORDER BY proposed_article_id DESC')->queryAll();
					$proposedList = array_merge($proposedList,$proposedArticlesList);
					foreach($proposedList as $proposedArticle){
						
						$type = 'office'; $condId; $tAry = array();
						/*error_reporting(E_ALL);
						ini_set('display_errors','on');*/
						
						$buildId = explode(',',$proposedArticle['building_id']);
						$userId = $proposedArticle['user_id'];
						if(isset($proposedArticle['cond_id'])){
							$condId = $proposedArticle['cond_id'];
							$result_cond = SearchSettings::model()->findByPk($proposedArticle['cond_id']);
							$searchallCond = json_decode($result_cond['ss_json']);
							$tAry = array('oid'=>$proposedArticle['office_alert_id']);
							if(isset($searchallCond->conditionFormData)){
								$searchallCond = Yii::app()->controller->getParamsfromString($searchallCond->conditionFormData);
							}
						}else{
							$condId = $proposedArticle['proposed_article_id'];
							$tAry = array('pid'=>$condId);
							$type = 'pa';
								$searchallCond = json_decode($proposedArticle['search_cond'],true);
								if(isset($searchallCond[0])) $searchallCond = $searchallCond[0];
						}
						$buildingFormMapper = Yii::app()->controller->__getCondition($searchallCond);
						
						
						 $distrincts = Yii::app()->controller->__getConditionsForView($searchallCond);

                              foreach ($distrincts as $distrinct) {
                                $buildingFormMapper .= "<li>" . $distrinct . "</li>";
                              }

						
				?>
                <div class="ttl_approach">
                	<table class="ttl_aplist">
                    	<tbody>
                        	<tr>
                            	<td class="ap_id bold" style="width:30%;">
									<?php echo Yii::app()->controller->__trans('ID'); ?>:
									<?php 
										if(isset($proposedArticle['office_alert_rand_id'])){
											echo $proposedArticle['office_alert_rand_id']; 
										}elseif(isset($proposedArticle['proposed_article_rand_id'])){
											echo $proposedArticle['proposed_article_rand_id']; 
										}
									?>
                                </td>
                                <td class="ap_cus bold">
                                	<p>
                                    	<?PHP if($type == 'office'){ ?>
                                    	&nbsp;&nbsp;オフィスアラート
                                    	<?php }else{ ?>
										<?php echo $proposedArticle['proposed_article_name']; ?>
                                        <?php } ?>
                                   </p>
                                </td>
								<?php
                                	$days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
									$day = array_search((date('D',strtotime($proposedArticle['added_on']))), $days);
								?>
                                <td class="ap_date t-right">
									<?php echo date('Y.m.d',strtotime($proposedArticle['added_on']))."(".$day.")"; ?> <?php echo Yii::app()->controller->__trans('Updated'); ?>
                                </td>
                                <td class="ap_sales t-right">
									<?php echo Yii::app()->controller->__trans('Author'); ?>:
									<?php
                                    	$userDetails = AdminDetails::model()->find('user_id = '.$proposedArticle['user_id']);
										echo $userDetails['full_name'];
									?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="article-list propertyActionList">
                	<div class="action-list">
                    	<?PHP if($type == 'office'){ ?>
                        <input type="hidden" name="hdnOfficeAlertId" id="hdnOfficeAlertId" class="hdnOfficeAlertId" value="<?php echo $proposedArticle['office_alert_id']; ?>" />
                        <?PHP }else{ ?>
                        <input type="hidden" name="hdnProposedArticleId" id="hdnProposedArticleId" class="hdnProposedArticleId" value="<?php echo $proposedArticle['proposed_article_id']; ?>">
                        <?PHP } ?>
                        <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',$tAry); ?>">
                        	<i class="fa fa-arrow-circle-right"></i>
							<?php echo Yii::app()->controller->__trans('show properties list'); ?>
                        </a>
                        <a href="<?php echo Yii::app()->createUrl('building/searchBuilding',array('type'=>$type, 'samecond'=>$condId)); ?>">
                        	<i class="fa fa-search"></i><?php echo Yii::app()->controller->__trans('Search as same condition'); ?>
                        </a>
                        <?PHP if($type == 'office'){ ?>
                        <a href="<?php echo Yii::app()->createUrl('building/searchBuilding',array('id'=>$proposedArticle['customer_id'],'type'=>$type,'samecond'=>$condId,'keepold'=>1)); ?>">
                        	<i class="fa fa-search"></i><?php echo Yii::app()->controller->__trans('同じ条件からオフィスアラートを設定'); ?>
                        </a>
                        <?PHP } ?>


                        <a href="#" data-value='<?PHP echo $buildingFormMapper; ?>' class="<?PHP echo $type == 'pa' ? 'btnDuplicateProposedArticle' : 'btnDuplicateOfficeAlert'; ?>">
                        	<i class="fa fa-arrow-circle-right"></i>
							<?php echo Yii::app()->controller->__trans('duplicate'); ?>
                        </a>
                        <?PHP if($type == 'office'){ ?>
                        <a href="<?php echo Yii::app()->createUrl('customer/offOfficeAlert'); ?>" class="btnOffAlert">
                            <i class="fa fa-volume-off"></i><?php echo Yii::app()->controller->__trans('アラートをオフにする'); ?>
                        </a>
                        <?PHP } ?>
                        <a href="#" class="delate <?PHP echo $type == 'pa' ? 'btnDeleteProposedArticle' : 'btnDeleteOfficeAlert'; ?>">                        
                        	<i class="fa fa-trash"></i>
							<?php echo Yii::app()->controller->__trans('delete'); ?>
                        </a>
                    </div>
                    <table class="saved-list table-style4">
                    	<tbody>
                        	<tr>
                            	<th>
									<?php
                                    	$buildings = explode(',',$proposedArticle['building_id']);
										$floors = $proposedArticle['floor_id'] != "" ? explode(',',$proposedArticle['floor_id']) : "0";
										$allBuildings = Floor::model()->findAllByAttributes(array('building_id'=>$buildings));
									?>
                                    <span>
									<?php
                                    	echo count($buildings);
									?>
                                    </span>
									<?php echo Yii::app()->controller->__trans('棟'); ?>(<?php echo count($floors);?>
                                    <?php echo Yii::app()->controller->__trans('floor'); ?>)
                                </th>
                                <td>
                                	<ul class="ap_condition">
                                    	<?php
											 echo $buildingFormMapper;

                                              // $twnAry = array();
                                            // foreach($twnAry as $twn){

                                            //         echo $twn['name'];

                                            //     }
                       
										?>

                                       
                                    </ul>

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
        </div>
        <div class="delate-box"><a href="<?php echo Yii::app()->createUrl('customer/delete',array('id'=>$customerDetails->customer_id)); ?>" class="delate-btn">顧客を削除</a><span class="warn">警告：この操作は取り戻せません。細心の注意を払って実施して下さい</span></div>
    </div>  
</div>

<div class="modal-box hide updateCusomerReqInfo">
	<div class="content contentCusomerReqInfo">
    	<div class="changeLoaderOverly" style="display:none;">
        	<img src="<?php echo Yii::app()->baseUrl.'/images/ins.gif' ?>" class="loaderImage"/>
        </div>
        <div class="changeLoaderOverlyMsg" style="display:none;">
        	<span class="responseMsg"></span>
        </div>
        <div class="box-header">
        	<button type="button" class="btnModalClose" id="btnModalClose">X</button>
            <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Update Customer Requirement Info'); ?></h2>
        </div>
        <div class="box-content divChangeInfo">
        	<div class="changeLoaderOverly">
                <img src="<?php echo Yii::app()->baseUrl.'/images/ins.gif' ?>" class="loaderImage"/>
            </div>
        </div>
    </div>
</div>

<div class="modal-box hide updateCustomerInfo">
	<div class="content contentCustomerInfo">
    	<div class="changeLoaderOverly1" style="display:none;">
        	<img src="<?php echo Yii::app()->baseUrl.'/images/ins.gif' ?>" class="loaderImage"/>
        </div>
        <div class="changeLoaderOverlyMsg1" style="display:none;">
        	<span class="responseMsg1"></span>
        </div>
        <div class="box-header">
        	<button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>
        <div class="box-content divChange">
        	<div class="changeLoaderOverly1">
                <img src="<?php echo Yii::app()->baseUrl.'/images/ins.gif' ?>" class="loaderImage"/>
            </div>
        </div>
    </div>
</div>

<!--Popup Box End-->
<div class="modal-box hide" id="modalCloneOfficeAlert">
	<div class="content transmissionContent">
    	<div class="box-header">
        	<h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Duplicate list'); ?></h2>
            <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>
        <div class="box-content">
        	<form name="frmCloneOfficeAlert" id="frmCloneOfficeAlert" class="frmCloneOfficeAlert" data-action="<?php echo Yii::app()->createUrl('building/cloneOfficeAlert'); ?>">
            	<input type="hidden" name="hdnOffAlertId" id="hdnOffAlertId" class="hdnOffAlertId" value="0"/>
                <input type="hidden" name="fromCustomer" id="fromCustomer" class="fromCustomer" value="1"/>
                <table>
                	<tr>
                    	<td><?php echo Yii::app()->controller->__trans('Name'); ?></td>
                        <td style="text-align:left;"><input type="text" name="proposedArticleName" id="proposedArticleName" class="proposedArticleName" style="width:50% !important;" /></td>
                    </tr>
                    <tr>
                    	<td><?php echo Yii::app()->controller->__trans('Customer Name');?></td>
                        <td style="text-align:left;">
							<?php /*?><?php echo $customerDetails->company_name; ?>
                            <input type="hidden" name="proposedCustomerName" id="proposedCustomerName" class="proposedCustomerName" value="<?php echo $customerDetails->customer_id; ?>"/><?php */?>
                            
                            <select name="proposedCustomerName" id="proposedCustomerName" class="proposedCustomerName js-example-basic-single">
                            	<option value="0">-</option>
								<?php
                                	$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
									$customerList = Customer::model()->findAll();
									if(isset($customerList) && count($customerList) > 0){
										foreach($customerList as $customer){
								?>
                                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['company_name']; ?></option>
								<?php
                                		}
									}else{
								?>
                                <option value="-"><?php echo Yii::app()->controller->__trans('You not have customer'); ?></option>
								<?php
                                	}
								?>
                            </select>
                        </td>
                  	</tr>
                    <tr>
                    	<td colspan="2">
                        	<button type="button" class="btnSaveDuplicateOfficeAlert"><?php echo Yii::app()->controller->__trans('duplicate of list');?></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
var _dont_Change = false;
<?PHP if(isset($_GET['show'])){ ?>
	_dont_Change = true;
<?PHP }?>
</script>

<!--Modal Popup for clone of proposed article-->
<div class="modal-box hide" id="modalCloneProposedArticle">
	<div class="content transmissionContent">
    	<div class="box-header">
        	<h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Proposed Article'); ?></h2>
            <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>
        <div class="box-content">
        	<form name="frmCloneProposedArticle" id="frmCloneProposedArticle" class="frmCloneProposedArticle" data-action="<?php echo Yii::app()->createUrl('proposedArticle/cloneArticles'); ?>">
            	<input type="hidden" name="hdnProArticleId" id="hdnProArticleId" class="hdnProArticleId" value="0"/>
                <input type="hidden" name="fromCustomer" value="1"/>
                <input type="hidden" name="proposedCustomerName" value="<?PHP echo $_GET['id']; ?>"/>
                <table>
                	<tr>
                    	<td><?php echo Yii::app()->controller->__trans('list name'); ?></td>
                        <td style="text-align:left;">
                        	<input type="text" name="proposedArticleName" id="proposedArticleName" class="proposedArticleName" style="width:50% !important;" />
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo Yii::app()->controller->__trans('Customer Name'); ?></td>
                        <td style="text-align:left;">
                        	<select name="proposedCustomerName" id="proposedCustomerName"  class="proposedCustomerName js-example-basic-single">
                            	<option value="0">-</option>
                                <?php
								$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
								$customerList = Customer::model()->findAll();
								if(isset($customerList) && count($customerList) > 0){
									foreach($customerList as $customer){
								?>
                                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['company_name']; ?></option>
                                <?php
									}
								}else{
								?>
                                <option value="-"><?php echo Yii::app()->controller->__trans('You not have customer'); ?></option>
                                <?php
								}
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo Yii::app()->controller->__trans('Search Condition'); ?></td>
                        <td>
                        	<ul class="ap_condition">
                            	<span class="conditionDuplicate"></span>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                        	<button type="button" class="btnSaveDuplicateArticle"><?php echo Yii::app()->controller->__trans('Add'); ?></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>