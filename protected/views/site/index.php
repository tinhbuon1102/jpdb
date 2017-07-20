<div id="main" class="single-customer">
	<div class="postbox">
    	<header class="btnright">
        	<h1 class="main-title_dash"><?php echo Yii::app()->controller->__trans('DASHBOARD'); ?></h1>
        </header>
        <div class="clear"></div>
        <div class="onepart">
        	<div class="recent_info">
            	<h2 class="recent_text"><?php echo Yii::app()->controller->__trans('RECENT UPDATE FOR MARKET INFO'); ?></h2>
                <table class="market_update">
				<?php
                	$query = 'SELECT * FROM `building_update_log` ORDER BY building_update_log_id DESC LIMIT 3';
					$updateDetails = Yii::app()->db->createCommand($query)->queryAll();
					if(isset($updateDetails) && count($updateDetails) && !empty($updateDetails)){
						foreach($updateDetails as $update){
				?>
                	<tr>
                    	<td class="update_date"><?php echo date('Y.m.d',strtotime($update['added_on'])); ?></td>
                        <td class="update_info">
                        <?php echo $update['change_content']; ?></td>
                        <!--<td class="update_date"><span class="see pull-right">See details</span></td>-->
                    </tr>
				<?php
                		}
					}
				?>
                </table>
            </div>
            <div class="recent_alert">
            <div class="ttl_alert">
            	<h2 class="recent_text"><?php echo Yii::app()->controller->__trans('OFFICE ALERT'); ?></h2>
            	<ul class="user-switch">
                	<li>
                    	<span class="hyoji">表示:</span>
                        <label class="rd2"><input type="radio" name="toggleDisplayAlert" class="toggleDisplayAlert" data-value='1'><?php echo Yii::app()->controller->__trans('担当ユーザのみ');?></label>
                    </li>
                    <li>
                    	<label class="rd2">
                        	<input type="radio" name="toggleDisplayAlert" class="toggleDisplayAlert" data-value='0' checked="checked">
							<?php echo Yii::app()->controller->__trans('アラートに該当した全ユーザ');?>
                        </label>
                    </li>    
                </ul>
            </div>
                <div class="respDisplayAlert">
                    <table class="market_update">
                    <?php
                        $query = 'SELECT * FROM `office_alert` where is_off = 0  ORDER BY office_alert_id DESC LIMIT 16';
                        $officeAlertDetails = Yii::app()->db->createCommand($query)->queryAll();
                        if(isset($officeAlertDetails) && count($officeAlertDetails) && !empty($officeAlertDetails)){
                            foreach($officeAlertDetails as $officeAlert){
                                $salesDetails = AdminDetails::model()->find('user_id = '.$officeAlert['user_id']);
                    ?>
                        <tr>
                            <td class="update_date">
                                <?php
                                $customerDetails = Customer::model()->findByPk($officeAlert['customer_id']);
                                $days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
                                $day = array_search((date('D',strtotime($officeAlert['added_on']))), $days);
                                ?>
                                <?php echo date('Y.m.d',strtotime($officeAlert['added_on']))."(".$day.")";?>
                            </td>
                            <td class="update_info"><span class="market_in"><a href="<?php echo Yii::app()->createUrl('customer/fullDetail',array('id'=>$officeAlert['customer_id'],'show'=>3)); ?>"><?php echo $customerDetails['company_name']; ?></a></span></td>
                            <td>
                            <?php
                            $buildings = explode(',',$officeAlert['building_id']);
                            $allBuildings = explode(',',$officeAlert['floor_id']);
                            ?>
                            <a href="<?php echo Yii::app()->createUrl('customer/fullDetail',array('id'=>$officeAlert['customer_id'],'show'=>3)); ?>"><?php echo count($buildings) > 1 ? count($buildings).'棟' : count($buildings).'棟'; ?>
                            (<?php echo count($allBuildings) > 1 ? count($allBuildings).'フロア' : count($allBuildings).'フロア'; ?>)</a>
                            </td>
                            <td class="update_staff"><span class="see"><?php echo Yii::app()->controller->__trans('Sales Staff'); ?> : <?php echo $salesDetails['full_name']; ?></span></td>
                            <td class="update_setting">
                                <a href="<?php echo Yii::app()->createUrl('customer/fullDetail',array('id'=>$officeAlert['customer_id'],'show'=>3)); ?>">
                                    <span class="see pull-right">
                                        <img src="images/1461688113_Streamline-75.png" class="setting_img"/><?php echo Yii::app()->controller->__trans('Setting'); ?>
                                    </span>
                                </a>
                            </td>
                       </tr>
                    <?php
                            }
                        }
                    ?>
                    </table>
                </div>
          	</div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="recent-pro">
    <h2 class="recent_text">
		<?php echo Yii::app()->controller->__trans('PROPERTIES IN MAIN AREA UPDATE INFO'); ?>
    </h2>
    <p>
    <?php
		$dateFirst = date('Y-m-d');
		if(date('D',strtotime($dateFirst)) == 'Sat'){
			$dateFirst = date('Y-m-d',strtotime("-1 days",strtotime($dateFirst)));
		}elseif(date('D',strtotime($dateFirst)) == 'Sun'){
			$dateFirst = date('Y-m-d',strtotime("-2 days",strtotime($dateFirst)));
		}else{
			$dateFirst = date('Y-m-d');
		}
		
		$totalUpdatedFloor = FloorUpdateHistory::model()->getAvailableHistoryFloor('fh.vacancy_info = 1 AND DATE_FORMAT(fh.modified_on,"%Y-%m-%d") = "'.$dateFirst.'"');
		$totalAddedFloor = Floor::model()->getAvailableFloor('f.vacancy_info = 1 AND DATE_FORMAT(f.added_on,"%Y-%m-%d") = "'.$dateFirst.'"');
		$arraybuildingId = array();
		$newArray = array();
		$newArrays = array();
		$finalArray = array();
		$final = array();
		$totalFloors = 0;
		foreach($totalUpdatedFloor as $fl){
			$finalArray[] = $fl;
			if ($fl['floor_id'])
			{
				$arraybuildingId[] = $fl['building_id'];
				$totalFloors++;
			}
			
		}
		foreach($totalAddedFloor as $fa){
			$finalArray[] = $fa;
			if ($fa['floor_id'])
			{
				$arraybuildingId[] = $fa['building_id'];
				$totalFloors++;
			}
		}
		
		$arraybuildingId = array_unique($arraybuildingId);
		$totalBuildings = count($arraybuildingId);
		foreach($totalUpdatedFloor as $floor){
			$address = $floor['district_name'];
			if(!isset($newArray[$address])) $newArray[$address] = array(); 
			if($floor['price_rise'] == 0){
				$newArray[$address]['minus'] = !$floor['floor_id'] ? 0 :((isset($newArray[$address]['minus']) ? $newArray[$address]['minus'] : 0) + 1);
				$newArray[$address]['minusAry'][] = $floor['floor_id'];
			}
			if($floor['price_rise'] == 1){
				$newArray[$address]['plus'] = !$floor['floor_id'] ? 0 :((isset($newArray[$address]['plus']) ? $newArray[$address]['plus'] : 0) + 1);
				$newArray[$address]['plusAry'][] = $floor['floor_id'];
			}
			
			$newArray[$address]['total'] += !$floor['floor_id'] ? 0 : 1;
			$newArray[$address]['totalAry'][] = $floor['floor_id'];
		}
		$district = '';
		foreach($totalAddedFloor as $floor){
		   	$district = $floor['district_name'];
			$newArray[$district]['total'] += !$floor['floor_id'] ? 0 : 1;
			if ($floor['floor_id'])
				$newArray[$district]['totalAry'][] = $floor['floor_id'];
		}
	?>
    </p>
    <table class="tbl-1">
    	<tr>
        	<td class="title_date"><?php echo date('Y年m月d日',strtotime($dateFirst)); ?></td>
            <td></td>
            <td class="title_date"><?php echo $totalBuildings; ?><?php echo Yii::app()->controller->__trans('棟'); ?></td>
            <td class="title_date"><?php echo $totalFloors; ?><?php echo Yii::app()->controller->__trans('フロア'); ?></td>
       	</tr>
        <?php
		if(isset($newArray) && count($newArray) > 0){
			$i = 0; 
			foreach($newArray as $ko=>$array){
				if($i % 2 == 0){
					$class = 'even';
				}else{
					$class = 'odd';
				}
		?>
        <tr class="<?php echo $class; ?>">
            <td class="lineone_text"><?php echo $ko; ?></td>
            <td>
                <img src="images/down.png" class="red_arrow"/>
                <span class="lineone_text">
                    <?php
                    if(isset($array['minusAry']) && !empty($array['minusAry'])){
                        $minusFloorIds = implode(',',$array['minusAry']);
                    }else{
                        $minusFloorIds = '#';
                    }
                    ?>
                    <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('fIds'=>$minusFloorIds,'final_redi'=>$ko.'~'.$dateFirst.'~drop')); ?>">
                    <?php
                    if(!isset($array['minus']) ){
                        echo 0;
                    }else{
                        echo $array['minus'];
                    }
                    ?>件
                    </a>
                </span>
            </td>
            <td>
                <img src="images/up.png" class="blue_arrow">
                <span class="lineone_text">
                    <?php
                    if(isset($array['plusAry']) && !empty($array['plusAry'])){
                        $plusFloorIds = implode(',',$array['plusAry']);
                    }else{
                        $plusFloorIds = '#';
                    }
                    ?>
                    <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('fIds'=>$plusFloorIds,'final_redi'=>$ko.'~'.$dateFirst.'~rise')); ?>">
                    <?php
                    if(!isset($array['plus'])){
                        echo 0;
                    }else{
                        echo $array['plus'];
                    }
                    ?>件
                    </a>
                </span>
            </td>
            <td class="lineone_room">
                <?php
                if(isset($array['totalAry']) && !empty($array['totalAry'])){
                    $totalFloorIds = implode(',',$array['totalAry']);
                }else{
                    $totalFloorIds = '#';
                }
                ?>
                <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('fIds'=>$totalFloorIds,'final_redi'=>$ko.'~'.$dateFirst)); ?>">
                <?php
                if(!isset($array['total'])){
                    echo 0;
                }else{
                    echo $array['total'];
                }
                ?>
                <?php echo Yii::app()->controller->__trans('rooms'); ?>
                </a>
            </td>
        </tr>
        <?php
			$i++;
		}
		?>
        <?php
		}else{
		?>
	  	<tr>
        	<td colspan="3"><?php echo Yii::app()->controller->__trans('No data Availabe'); ?></td>
        </tr>	
        <?php
		}
		?>
    </table>
    
    <table class="tbl-2">
    <?php
		$dateSecond = date('Y-m-d',strtotime("-1 days",strtotime($dateFirst)));
		if(date('D',strtotime($dateSecond)) == 'Sat'){
			$dateSecond = date('Y-m-d',strtotime("-1 days",strtotime($dateSecond)));
		}elseif(date('D',strtotime($dateSecond)) == 'Sun'){
			$dateSecond = date('Y-m-d',strtotime("-2 days",strtotime($dateSecond)));
		}
		$totalUpdatedFloor = FloorUpdateHistory::model()->getAvailableHistoryFloor('fh.vacancy_info = 1 AND DATE_FORMAT(fh.modified_on,"%Y-%m-%d") = "'.$dateSecond.'"');
		$totalAddedFloor = Floor::model()->getAvailableFloor('f.vacancy_info = 1 AND DATE_FORMAT(f.added_on,"%Y-%m-%d") = "'.$dateSecond.'"');
		
		$arraybuildingId = array();
		$newArray = array();
		$newArrays = array();
		$finalArray = array();
		$final = array();
		$totalFloors = 0;
		foreach($totalUpdatedFloor as $fl){
			$finalArray[] = $fl;
			if ($fl['floor_id'])
			{
				$arraybuildingId[] = $fl['building_id'];
				$totalFloors++;
			}
		}
		foreach($totalAddedFloor as $fa){
			$finalArray[] = $fa;
			if ($fa['floor_id'])
			{
				$arraybuildingId[] = $fa['building_id'];
				$totalFloors++;
			}
		}
		$arraybuildingId = array_unique($arraybuildingId);
		$totalBuildings = count($arraybuildingId);
		foreach($totalUpdatedFloor as $floor){
			$address = $floor['district_name'];
			if(!isset($newArray[$address])) $newArray[$address] = array(); 
			if($floor['price_rise'] == 0){
				$newArray[$address]['minus'] = !$floor['floor_id'] ? 0 : ((isset($newArray[$address]['minus']) ? $newArray[$address]['minus'] : 0) + 1);
				$newArray[$address]['minusAry'][] = $floor['floor_id'];
			}
			if($floor['price_rise'] == 1){
				$newArray[$address]['plus'] = !$floor['floor_id'] ? 0 : ((isset($newArray[$address]['plus']) ? $newArray[$address]['plus'] : 0) + 1);
				$newArray[$address]['plusAry'][] = $floor['floor_id'];
			}
			$newArray[$address]['total'] += !$floor['floor_id'] ? 0 : 1;
			$newArray[$address]['totalAry'][] = $floor['floor_id'];
		}
		$district = '';
		foreach($totalAddedFloor as $floor){
			//$address = $buildingDetails['district_name'];
		   	$district = $floor['district_name'];
			$newArray[$district]['total'] += !$floor['floor_id'] ? 0 : 1;
			if ($floor['floor_id'])
				$newArray[$district]['totalAry'][] = $floor['floor_id'];
		}
	?>
    	<tr>
        	<td class="title_date"><?php echo date('Y年m月d日',strtotime($dateSecond)); ?></td>
            <td></td>
            <td class="title_date"><?php echo $totalBuildings; ?><?php echo Yii::app()->controller->__trans('棟'); ?></td>
            <td class="title_date"><?php echo $totalFloors; ?><?php echo Yii::app()->controller->__trans('フロア'); ?></td>
        </tr>
        <?php
		if(isset($newArray) && count($newArray) > 0){
			$i = 0;
			foreach($newArray as $ko=>$array){
				if($i % 2 == 0){
					$class = 'even';
				}else{
					$class = 'odd';
				}
		?>
        <tr class="<?php echo $class; ?>">
        	<td class="lineone_text"><?php echo $ko; ?></td>
            <td>
            	<img src="images/down.png" class="red_arrow"/>
                <span class="lineone_text">
                    <?php
                    if(isset($array['minusAry']) && !empty($array['minusAry'])){
                        $minusFloorIds = implode(',',$array['minusAry']);
                    }else{
                        $minusFloorIds = '#';
                    }
                    ?>
                    <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('fIds'=>$minusFloorIds,'final_redi'=>$ko.'~'.$dateSecond.'~drop')); ?>">
					<?php
                    if(!isset($array['minus'])){
                        echo 0;
                    }else{
                        echo $array['minus'];
                    }
                    ?>件
                    </a>
                </span>
           	</td>
            <td>
            	<img src="images/up.png" class="blue_arrow">
                <span class="lineone_text">
					<?php
                    if(isset($array['plusAry']) && !empty($array['plusAry'])){
                        $plusFloorIds = implode(',',$array['plusAry']);
                    }else{
                        $plusFloorIds = '#';
                    }
                    ?>
                    <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('fIds'=>$plusFloorIds,'final_redi'=>$ko.'~'.$dateSecond.'~rise')); ?>">
					<?php
                    if(!isset($array['plus'])){
                        echo 0;
                    }else{
                        echo $array['plus'];
                    }
                    ?>件
                    </a>
                </span>
            </td>
            <td class="lineone_room">
				<?php
                if(isset($array['totalAry']) && !empty($array['totalAry'])){
                    $totalFloorIds = implode(',',$array['totalAry']);
                }else{
                    $totalFloorIds = '#';
                }
                ?>
                <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('fIds'=>$totalFloorIds,'final_redi'=>$ko.'~'.$dateSecond));; ?>">
				<?php
                if(!isset($array['total'])){
                    echo 0;
                }else{
                    echo $array['total'];
                }
                ?>
                <?php echo Yii::app()->controller->__trans('フロア'); ?>
                </a>
            </td>
        </tr>
        <?php
			$i++;
			}
		?>
		<?php
        }else{
		?>
        <tr>
        	<td colspan="3"><?php echo Yii::app()->controller->__trans('No data Availabe'); ?></td>
        </tr>
        <?php
        }
		?>
    </table>
    
    <table class="tbl-3">
    <?php
    
		$dateThird = date('Y-m-d',strtotime("-1 day",strtotime($dateSecond)));
		if(date('D',strtotime($dateThird)) == 'Sat'){
			$dateThird = date('Y-m-d',strtotime("-1 days",strtotime($dateThird)));
		}elseif(date('D',strtotime($dateThird)) == 'Sun'){
			$dateThird = date('Y-m-d',strtotime("-2 days",strtotime($dateThird)));
		}		
		$totalUpdatedFloor = FloorUpdateHistory::model()->getAvailableHistoryFloor('fh.vacancy_info = 1 AND DATE_FORMAT(fh.modified_on,"%Y-%m-%d") = "'.$dateThird.'"');
		$totalAddedFloor = Floor::model()->getAvailableFloor('f.vacancy_info = 1 AND DATE_FORMAT(f.added_on,"%Y-%m-%d") = "'.$dateThird.'"');
		
		$arraybuildingId = array();
		$newArray = array();
		$newArrays = array();
		$finalArray = array();
		$final = array();
		$totalFloors = 0;
		foreach($totalUpdatedFloor as $fl){
			$finalArray[] = $fl;
			if ($fl['floor_id'])
			{
				$arraybuildingId[] = $fl['building_id'];
				$totalFloors++;
			}
		}
		foreach($totalAddedFloor as $fa){
			$finalArray[] = $fa;
			if ($fa['floor_id'])
			{
				$arraybuildingId[] = $fa['building_id'];
				$totalFloors++;
			}
		}
		$arraybuildingId = array_unique($arraybuildingId);
		$totalBuildings = count($arraybuildingId);
		foreach($totalUpdatedFloor as $floor){
			$address = $floor['district_name'];
			if(!isset($newArray[$address])) $newArray[$address] = array(); 
			if($floor['price_rise'] == 0){
				$newArray[$address]['minus'] = !$floor['floor_id'] ? 0 :((isset($newArray[$address]['minus']) ? $newArray[$address]['minus'] : 0) + 1);
				$newArray[$address]['minusAry'][] = $floor['floor_id'];
			}
			if($floor['price_rise'] == 1){
				$newArray[$address]['plus'] = !$floor['floor_id'] ? 0 :((isset($newArray[$address]['plus']) ? $newArray[$address]['plus'] : 0) + 1);
				$newArray[$address]['plusAry'][] = $floor['floor_id'];
			}
			$newArray[$address]['total'] += !$floor['floor_id'] ? 0 : 1;
			$newArray[$address]['totalAry'][] = $floor['floor_id'];
		}
		$district = '';
		foreach($totalAddedFloor as $floor){
			//$address = $buildingDetails['district_name'];
		   	$district = $floor['district_name'];
			$newArray[$district]['total'] += !$floor['floor_id'] ? 0 : 1;
			if ($floor['floor_id'])
				$newArray[$district]['totalAry'][] = $floor['floor_id'];
		}
	?>
    <tr>
    	<td class="title_date"><?php echo date('Y年m月d日',strtotime($dateThird)); ?></td>
        <td></td>
        <td class="title_date"><?php echo $totalBuildings; ?><?php echo Yii::app()->controller->__trans('棟'); ?></td>
        <td class="title_date"><?php echo $totalFloors; ?><?php echo Yii::app()->controller->__trans('フロア'); ?></td>
    </tr>
    <?php 
	if(isset($newArray) && count($newArray) > 0){
		$i = 0; 
		foreach($newArray as $ko=>$array){
			if($i % 2 == 0){
				$class = 'even';
			}else{
				$class = 'odd';
			}
	?>
    <tr class="<?php echo $class; ?>">
    	<td class="lineone_text"><?php echo $ko; ?></td>
        <td>
        	<img src="images/down.png" class="red_arrow"/>
            <span class="lineone_text">
				<?php
				if(isset($array['minusAry']) && !empty($array['minusAry'])){
					$minusFloorIds = implode(',',$array['minusAry']);
				}else{
					$minusFloorIds = '#';
				}
				?>
                <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('fIds'=>$minusFloorIds,'final_redi'=>$ko.'~'.$dateThird.'~drop')); ?>">
				<?php
                if(!isset($array['minus'])){
                    echo 0;
                }else{
                    echo $array['minus'];
                }
                ?>件
                </a>
            </span>
        </td>
        <td>
        	<img src="images/up.png" class="blue_arrow">
            <span class="lineone_text">
				<?php
				if(isset($array['plusAry']) && !empty($array['plusAry'])){
					$plusFloorIds = implode(',',$array['plusAry']);
				}else{
					$plusFloorIds = '#';
				}
				?>
                <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('fIds'=>$plusFloorIds,'final_redi'=>$ko.'~'.$dateThird.'~rise')); ?>">
				<?php
                if(!isset($array['plus'])){
                    echo 0;
                }else{
                    echo $array['plus'];
                }
                ?>件
                </a>
            </span>
        </td>
        <td class="lineone_room">
			<?php
			if(isset($array['totalAry']) && !empty($array['totalAry'])){
				$totalFloorIds = implode(',',$array['totalAry']);
			}else{
				$totalFloorIds = '#';
			}
			?>
            <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('fIds'=>$totalFloorIds,'final_redi'=>$ko.'~'.$dateThird)); ?>">
			<?php
            if(!isset($array['total'])){
                echo 0;
            }else{
                echo $array['total'];
            }
            ?>
            <?php echo Yii::app()->controller->__trans('フロア'); ?>
            </a>
        </td>
    </tr>
    <?php
    	$i++;
		}
	}else{
	?>
    <tr>
    	<td colspan="3"><?php echo Yii::app()->controller->__trans('No data Availabe'); ?></td>
    </tr>
    <?php
    }
	?>
    </table>
    
  </div>
  <div class="clear"></div>
	<div class="recent-pro">
		<?php
            $criteria=new CDbCriteria;
            $last3Year = date("Y",strtotime("-1 year"));
             $criteria->condition = "substring(built_year, 1, 4) >= :start";
             $criteria->params = array(':start' => $last3Year,);
            $criteria->order = 'SUBSTRING_INDEX(built_year, 1, 4) desc';
			//$criteria->order = "SUBSTRING_INDEX(SUBSTRING_INDEX(built_year, ' ', 1), ' ', -1)";
            $criteria->limit = '6';
            $buildingDetails = Building::model()->findAll($criteria);
            //echo "<pre>";print_r($buildingDetails);
        ?>
        <h2 class="recent_text">
			<?php echo Yii::app()->controller->__trans('新築ビル (築1年以内) 更新情報'); ?>
        </h2>
        <?php foreach($buildingDetails as $builds){
			 $last3Year = date("Y",strtotime("-1 year"));
			 $expBuilt1 = explode('-',$builds['built_year']); 
			 if($expBuilt1[0] == $last3Year) {


			

		?>
        <div class="images_part">
            <a href="<?php echo Yii::app()->createUrl('building/searchBuildingResult',array('id'=>$builds['building_id'])); ?>">
                <div class="images_one" style="background:url(<?php
                    $buildPics = BuildingPictures::model()->find('building_id = '.$builds['building_id']);
                    if(isset($buildPics) && count($buildPics) > 0){
                        $buildPics = explode(',',$buildPics['front_images']);
                    ?>
                        <?php echo Yii::app()->baseUrl.'/buildingPictures/front/'.$buildPics[0]; ?>
                    <?php }else{ ?>
                        <?php echo Yii::app()->baseUrl.'/images/default.png'; ?>
                    <?php } ?>);background-size:cover;background-position:center;">
                    
                </div>
                <div class="image_textpart">
                    <h2 class="timage_title_text">
                        <?php 
                        	echo $builds['name'];
                        	if($builds['bill_check']!=1) echo "ビル";
                        ?>
                    </h2>
                    <h2 class="timage_title_addtext">
                        <?php
                        $address_New = explode(',',$builds['address']);	
                        echo $address_New[3];
                        ?>
                    </h2>
                    <h2 class="timage_title_text_mnt"> 
                        <?php
                        $expBuilt = explode('-',$builds['built_year']); //date('Y年m月',strtotime($builds['buil']));
                        echo $expBuilt[0].'年'.$expBuilt[1].'月';
                        echo Yii::app()->controller->__trans('竣工');
                        ?>
                    </h2>
                </div>
            </a>
        </div>
			 <?php } } ?>
    </div>
</div>
