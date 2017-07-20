<!--<iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=東京都港区六本木7-14-3&output=embed"></iframe>-->
<!--<iframe width="450" height="400" frameborder="0" style="border:0"
  src="http://maps.google.com/?key=AIzaSyDVPva_WTX0Te_Z-ri4KCgDOgpcdK8l_JI&q=" allowfullscreen> </iframe>-->
<?php
$formTypeListAr = $formTypeList; /* Taking form type list */
$requirementOfBuilding = $unitMin = $unitMax = $areaMax = $areaMin = $costMin = $costMax = $floorMin = $floorMax = $possibleDataMin = $possibleDataMax = $shortRent = $buildingAge = $specifyCustomerName = $brokerageFree = $requirementOfBuilding = $deadCheck = $walkFromStation1 = $walkFromStation2 = $walkFromStation3 = $walkFromStation4 = '';
$statusRequirement = $lenderType = $statusRequirement =$floorType = $formTypeList = array();

if($sameSearchCondition != "" && $sameSearchCondition != 0){
	$finalArray = array();
	$buildingIds = ProposedArticle::model()->findByPk($sameSearchCondition);
	$buildId = explode(',',$buildingIds['building_id']);
	$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
	$userId = $user->user_id;
	$conditionsDetails = Cart::model()->findAllByAttributes(array('building_id'=>$buildId,'user_id'=>$userId));
	foreach($conditionsDetails as $cond){
		$finalArray[] = json_decode($cond['search_condition']);
	}
	$finalArray = array_unique($finalArray);
	$finalArray = array_values($finalArray);
	
	foreach($finalArray as $searchCond){
		/*********************** facilities *************************/
		if(isset($searchCond->facilities) && !empty($searchCond->facilities)){
			$facCheck1 = $facCheck2 = $facCheck3 = $facCheck4 = $facCheck5 = $facCheck6 = $facCheack7 = '';
			if(in_array(1,$searchCond->facilities)){
				$facCheck1 = 'checked';
			}
			if(in_array(2,$searchCond->facilities)){
				$facCheck2 = 'checked';
			}
			if(in_array(3,$searchCond->facilities)){
				$facCheck3 = 'checked';
			}
			if(in_array(4,$searchCond->facilities)){
				$facCheck4 = 'checked';
			}
			if(in_array(5,$searchCond->facilities)){
				$facCheck5 = 'checked';
			}
			if(in_array(6,$searchCond->facilities)){
				$facCheck6 = 'checked';
			}
			if(in_array(7,$searchCond->facilities)){
				$facCheack7 = 'checked';
			}
		}
		/************************* lender type ************************/
		if(isset($searchCond->lenderType) && !empty($searchCond->lenderType)){
			$lenderType = $searchCond->lenderType;
		}
		
		/************************* station minutes ************************/
		$walkFromStation1 = $walkFromStation2 = $walkFromStation3 = $walkFromStation4 = '';
		if(isset($searchCond->walkFromStation) && !empty($searchCond->walkFromStation)){
			if($searchCond->walkFromStation == 3){
				$walkFromStation1 = 'checked';
			}
			if($searchCond->walkFromStation == 5){
				$walkFromStation2 = 'checked';
			}
			if($searchCond->walkFromStation == 10){
				$walkFromStation3 = 'checked';
			}
			if($searchCond->walkFromStation == 15){
				$walkFromStation4 = 'checked';
			}
		}
		/************************* area min ************************/
		$areaMin = '';
		if(isset($searchCond->areaMin) && !empty($searchCond->areaMin)){
			$areaMin = $searchCond->areaMin;
		}
		/************************* area max ************************/
		$areaMax = '';
		if(isset($searchCond->areaMax) && !empty($searchCond->areaMax)){
			$areaMax = $searchCond->areaMax;
		}
		
		$floorType = array();
		if(isset($searchCond->floorType) && !empty($searchCond->floorType)){
			$floorType = $searchCond->floorType;
		}
		
		
		
		/************************* unit min ************************/
		$unitMin = '';
		if(isset($searchCond->unitMin) && !empty($searchCond->unitMin)){
			$unitMin = $searchCond->unitMin;
		}
		/************************* unit max ************************/
		$unitMax = '';
		if(isset($searchCond->unitMax) && !empty($searchCond->unitMax)){
			$unitMax = $searchCond->unitMax;
		}
		/************************* cost min ************************/
		$costMin = '';
		if(isset($searchCond->costMin) && !empty($searchCond->costMin)){
			$costMin = $searchCond->costMin;
		}
		/************************* cost max ************************/
		$costMax = '';
		if(isset($searchCond->costMax) && !empty($searchCond->costMax)){
			$costMax = $searchCond->costMax;
		}							
		/************************* floor min ************************/
		$floorMin = '';
		if(isset($searchCond->floorMin) && !empty($searchCond->floorMin)){
			$floorMin = $searchCond->floorMin;
		}
		/************************* floor max ************************/
		$floorMax = '';
		if(isset($searchCond->floorMax) && !empty($searchCond->floorMax)){
			$floorMax = $searchCond->floorMax;
		}
		
		/************************* possible move date ************************/
		$possibleDataMin = '';
		if(isset($searchCond->possibleDataMin) && !empty($searchCond->possibleDataMin)){
			$possibleDataMin = $searchCond->possibleDataMin;
		}
		
		$possibleDataMax = '';
		if(isset($searchCond->possibleDataMax) && !empty($searchCond->possibleDataMax)){
			$possibleDataMax = $searchCond->possibleDataMax;
		}
		
		/************************* short rent include ************************/
		$shortRent = '';
		if(isset($searchCond->shortRent) && !empty($searchCond->shortRent)){
			$shortRent = 'checked';
		}
		
		/************************* building age ************************/
		$buildingAge = '';
		if(isset($searchCond->buildingAge) && !empty($searchCond->buildingAge)){
			$buildingAge = $searchCond->buildingAge;
		}
		
		/************************* update date dropdown ************************/
		if(isset($searchCond->updateDateDrop) && !empty($searchCond->updateDateDrop)){
			
		}
		
		/************************* specific customer name ************************/
		$specifyCustomerName = '';
		if(isset($searchCond->specifyCustomerName) && !empty($searchCond->specifyCustomerName)){
			$specifyCustomerName = $searchCond->specifyCustomerName;
		}
		
		/************************* brokerage free include ************************/
		$brokerageFree = '';
		if(isset($searchCond->brokerageFree) && !empty($searchCond->brokerageFree)){
			$brokerageFree = 'checked';
		}
		
		/************************* status of requirement ************************/
		$statusRequirement = array();
		if(isset($searchCond->statusRequirement) && !empty($searchCond->statusRequirement)){
			$statusRequirement = $searchCond->statusRequirement;
		}
		
		$requirementOfBuilding = '';
		if(isset($searchCond->requirementOfBuilding) && !empty($searchCond->requirementOfBuilding)){
			$requirementOfBuilding = $searchCond->requirementOfBuilding;
		}
		
		/************************* dead line check ************************/
		$deadCheck = '';
		if(isset($searchCond->deadlineCheck) && !empty($searchCond->deadlineCheck)){
			$deadCheck = 'checked';
		}
	}
}
if(isset($_GET['samecond'])){
	
	if(isset($_GET['type']) && $_GET['type'] == 'pa'){
		$proposedList = ProposedArticle::model()->findByPk($_GET['samecond']);				
		$searchallCond = json_decode($proposedList->search_cond);
		$searchallCond = $searchallCond[0];
	}else{
		$result_cond = SearchSettings::model()->findByPk($_GET['samecond']);
		$searchallCond = json_decode($result_cond['ss_json']);
	}
	
	if(isset($searchallCond->conditionFormData)){
		$searchCondAry = $searchallCond->conditionFormData;
		$searchCond = new stdClass();
		foreach($searchCondAry as $ska){
			if(strpos($ska->name,'[]')){
				$name = str_replace('[]','',$ska->name);
				$value = $ska->value;
				if(!isset($searchCond->{$name})) $searchCond->{$name} = array();
				$searchCond->{$name}[] = $value;
			}else{
				$name = $ska->name;
				$value = $ska->value;
				$searchCond->{$name} = $value;
			}
		}
	}else{
		$searchCond = $searchallCond;
	}
	/*print_r($searchCond);
	exit;*/
	
	if(isset($searchCond->facilities) && !empty($searchCond->facilities)){
		$facCheck1 = $facCheck2 = $facCheck3 = $facCheck4 = $facCheck5 = $facCheck6 = $facCheack7 = '';
		if(in_array(1,$searchCond->facilities)){
			$facCheck1 = 'checked';
		}
		if(in_array(2,$searchCond->facilities)){
			$facCheck2 = 'checked';
		}
		if(in_array(3,$searchCond->facilities)){
			$facCheck3 = 'checked';
		}
		if(in_array(4,$searchCond->facilities)){
			$facCheck4 = 'checked';
		}
		if(in_array(5,$searchCond->facilities)){
			$facCheck5 = 'checked';
		}
		if(in_array(6,$searchCond->facilities)){
			$facCheck6 = 'checked';
		}
		if(in_array(7,$searchCond->facilities)){
			$facCheack7 = 'checked';
		}
	}
	/************************* lender type ************************/
	if(isset($searchCond->lenderType) && !empty($searchCond->lenderType)){
		$lenderType = $searchCond->lenderType;
	}
	/************************* station minutes ************************/
	
	if(isset($searchCond->walkFromStation) && !empty($searchCond->walkFromStation)){
		if($searchCond->walkFromStation == 3){
			$walkFromStation1 = 'checked';
		}
		if($searchCond->walkFromStation == 5){
			$walkFromStation2 = 'checked';
		}
		if($searchCond->walkFromStation == 10){
			$walkFromStation3 = 'checked';
		}
		if($searchCond->walkFromStation == 15){
			$walkFromStation4 = 'checked';
		}
	}
	if(isset($searchCond->floorType) && !empty($searchCond->floorType)){
		$floorType = $searchCond->floorType;
	}
	if(isset($searchCond->formTypeList) && !empty($searchCond->formTypeList)){
		$formTypeList = $searchCond->formTypeList;
	}	
	/************************* area min ************************/
	if(isset($searchCond->areaMinValue) && !empty($searchCond->areaMinValue)){
		$areaMin = $searchCond->areaMinValue;
	}
	/************************* area max ************************/
	if(isset($searchCond->areaMaxValue) && !empty($searchCond->areaMaxValue)){
		$areaMax = $searchCond->areaMaxValue;
	}
	/************************* unit min ************************/
	if(isset($searchCond->unitMinValue) && !empty($searchCond->unitMinValue)){
		$unitMin = $searchCond->unitMinValue;
	}
	/************************* unit max ************************/
	if(isset($searchCond->unitMaxValue) && !empty($searchCond->unitMaxValue)){
		$unitMax = $searchCond->unitMaxValue;
	}
	/************************* cost min ************************/	
	if(isset($searchCond->costMinAmount) && !empty($searchCond->costMinAmount)){
		$costMin = $searchCond->costMinAmount;
	}
	/************************* cost max ************************/
	if(isset($searchCond->costMaxAmount) && !empty($searchCond->costMaxAmount)){
		$costMax = $searchCond->costMaxAmount;
	}							
	/************************* floor min ************************/	
	if(isset($searchCond->floorMin) && !empty($searchCond->floorMin)){
		$floorMin = $searchCond->floorMin;
	}
	/************************* floor max ************************/
	if(isset($searchCond->floorMax) && !empty($searchCond->floorMax)){
		$floorMax = $searchCond->floorMax;
	}
	
	/************************* possible move date ************************/
	if(isset($searchCond->possibleDataMin) && !empty($searchCond->possibleDataMin)){
		$possibleDataMin = $searchCond->possibleDataMin;
	}
	if(isset($searchCond->possibleDataMax) && !empty($searchCond->possibleDataMax)){
		$possibleDataMax = $searchCond->possibleDataMax;
	}
	
	/************************* short rent include ************************/
	if(isset($searchCond->shortRent) && !empty($searchCond->shortRent)){
		$shortRent = 'checked';
	}
	
	/************************* building age ************************/
	if(isset($searchCond->buildingAge) && !empty($searchCond->buildingAge)){
		$buildingAge = $searchCond->buildingAge;
	}
	
	/************************* specific customer name ************************/
	if(isset($searchCond->specifyCustomerName) && !empty($searchCond->specifyCustomerName)){
		$specifyCustomerName = $searchCond->specifyCustomerName;
	}
	
	/************************* brokerage free include ************************/
	
	if(isset($searchCond->brokerageFree) && !empty($searchCond->brokerageFree)){
		$brokerageFree = 'checked';
	}
	
	/************************* status of requirement ************************/
	if(isset($searchCond->requirementOfBuilding) && !empty($searchCond->requirementOfBuilding)){
		$requirementOfBuilding = $searchCond->requirementOfBuilding;
	}
	
	if(isset($searchCond->statusRequirement) && !empty($searchCond->statusRequirement)){
		$statusRequirement = $searchCond->statusRequirement;
	}
	/************************* dead line check ************************/
	if(isset($searchCond->deadlineCheck) && !empty($searchCond->deadlineCheck)){
		$deadCheck = 'checked';
	}
}

if(isset($_POST['changeCondition'])){	
	
	if(isset($_POST['hdnSearchCriteriaToChange'])){			
		$searchallCond = json_decode($_POST['hdnSearchCriteriaToChange']);
		//$searchallCond = $searchallCond[0];
	}
	
	$searchCond = $searchallCond;
	/*print_r($searchCond);
	exit;*/
	
	if(isset($searchCond->facilities) && !empty($searchCond->facilities)){
		$facCheck1 = $facCheck2 = $facCheck3 = $facCheck4 = $facCheck5 = $facCheck6 = $facCheack7 = '';
		if(in_array(1,$searchCond->facilities)){
			$facCheck1 = 'checked';
		}
		if(in_array(2,$searchCond->facilities)){
			$facCheck2 = 'checked';
		}
		if(in_array(3,$searchCond->facilities)){
			$facCheck3 = 'checked';
		}
		if(in_array(4,$searchCond->facilities)){
			$facCheck4 = 'checked';
		}
		if(in_array(5,$searchCond->facilities)){
			$facCheck5 = 'checked';
		}
		if(in_array(6,$searchCond->facilities)){
			$facCheck6 = 'checked';
		}
		if(in_array(7,$searchCond->facilities)){
			$facCheack7 = 'checked';
		}
	}
	/************************* lender type ************************/
	if(isset($searchCond->lenderType) && !empty($searchCond->lenderType)){
		$lenderType = $searchCond->lenderType;
	}
	/************************* station minutes ************************/
	
	if(isset($searchCond->walkFromStation) && !empty($searchCond->walkFromStation)){
		if($searchCond->walkFromStation == 3){
			$walkFromStation1 = 'checked';
		}
		if($searchCond->walkFromStation == 5){
			$walkFromStation2 = 'checked';
		}
		if($searchCond->walkFromStation == 10){
			$walkFromStation3 = 'checked';
		}
		if($searchCond->walkFromStation == 15){
			$walkFromStation4 = 'checked';
		}
	}
	if(isset($searchCond->floorType) && !empty($searchCond->floorType)){
		$floorType = $searchCond->floorType;
	}
	if(isset($searchCond->formTypeList) && !empty($searchCond->formTypeList)){
		$formTypeList = $searchCond->formTypeList;
	}	
	/************************* area min ************************/
	if(isset($searchCond->areaMinValue) && !empty($searchCond->areaMinValue)){
		$areaMin = $searchCond->areaMinValue;
	}
	/************************* area max ************************/
	if(isset($searchCond->areaMaxValue) && !empty($searchCond->areaMaxValue)){
		$areaMax = $searchCond->areaMaxValue;
	}
	/************************* unit min ************************/
	if(isset($searchCond->unitMinValue) && !empty($searchCond->unitMinValue)){
		$unitMin = $searchCond->unitMinValue;
	}
	/************************* unit max ************************/
	if(isset($searchCond->unitMaxValue) && !empty($searchCond->unitMaxValue)){
		$unitMax = $searchCond->unitMaxValue;
	}
	/************************* cost min ************************/	
	if(isset($searchCond->costMinAmount) && !empty($searchCond->costMinAmount)){
		$costMin = $searchCond->costMinAmount;
	}
	/************************* cost max ************************/
	if(isset($searchCond->costMaxAmount) && !empty($searchCond->costMaxAmount)){
		$costMax = $searchCond->costMaxAmount;
	}							
	/************************* floor min ************************/	
	if(isset($searchCond->floorMin) && !empty($searchCond->floorMin)){
		$floorMin = $searchCond->floorMin;
	}
	/************************* floor max ************************/
	if(isset($searchCond->floorMax) && !empty($searchCond->floorMax)){
		$floorMax = $searchCond->floorMax;
	}
	
	/************************* possible move date ************************/
	if(isset($searchCond->possibleDataMin) && !empty($searchCond->possibleDataMin)){
		$possibleDataMin = $searchCond->possibleDataMin;
	}
	if(isset($searchCond->possibleDataMax) && !empty($searchCond->possibleDataMax)){
		$possibleDataMax = $searchCond->possibleDataMax;
	}
	
	/************************* short rent include ************************/
	if(isset($searchCond->shortRent) && !empty($searchCond->shortRent)){
		$shortRent = 'checked';
	}
	
	/************************* building age ************************/
	if(isset($searchCond->buildingAge) && !empty($searchCond->buildingAge)){
		$buildingAge = $searchCond->buildingAge;
	}
	
	/************************* specific customer name ************************/
	if(isset($searchCond->specifyCustomerName) && !empty($searchCond->specifyCustomerName)){
		$specifyCustomerName = $searchCond->specifyCustomerName;
	}
	
	/************************* brokerage free include ************************/
	
	if(isset($searchCond->brokerageFree) && !empty($searchCond->brokerageFree)){
		$brokerageFree = 'checked';
	}
	
	/************************* status of requirement ************************/
	if(isset($searchCond->requirementOfBuilding) && !empty($searchCond->requirementOfBuilding)){
		$requirementOfBuilding = $searchCond->requirementOfBuilding;
	}
	
	if(isset($searchCond->statusRequirement) && !empty($searchCond->statusRequirement)){
		$statusRequirement = $searchCond->statusRequirement;
	}
	/************************* dead line check ************************/
	if(isset($searchCond->deadlineCheck) && !empty($searchCond->deadlineCheck)){
		$deadCheck = 'checked';
	}
}

/* Tab active find code */
$actTab = 1;
if(isset($searchallCond->hdnRPrefId)){
	$actTab = 2;
}else if((isset($searchallCond->buildingSearchName) && $searchallCond->buildingSearchName != '') ||
(isset($searchallCond->buildingSearchAddressTxt) && $searchallCond->buildingSearchAddressTxt != '')){
	$actTab = 3;
}else if(isset($searchallCond->buildingSearchAddress) && $searchallCond->buildingSearchAddress != ''){
	$actTab = 4;
}else if((isset($searchallCond->buildingSearchId) && $searchallCond->buildingSearchId != '') ||
(isset($searchallCond->floorSearchId) && $searchallCond->floorSearchId != '')){
	$actTab = 5;
}else if(isset($searchallCond->floorSearchOwnerName) && $searchallCond->floorSearchOwnerName != ''){
	$actTab = 6;
}



?>            
<div id="main" class="single-customer" style="margin:0 auto !important;margin-top:25px !important;">
	<div class="Content-header">
    	<div class="page-title">
        	<h2 style="margin-top: 4px;"><?php echo Yii::app()->controller->__trans('Search Criteria'); ?></h2>
        </div>
        <div class="add_build">
        	<a href="<?php  echo Yii::app()->createUrl('building/create'); ?>">
            	<button type="button"><?php echo Yii::app()->controller->__trans('建物を新規追加'); ?></button>
            </a>
        </div>
        <div class="add_build">
        	<a href="<?php  echo Yii::app()->createUrl('building/admin'); ?>">
            	<button type="button"><?php echo Yii::app()->controller->__trans('Add Floor'); ?></button>
            </a>
        </div>
        <div class="add_build">
        	<a href="#">
            	<button type="button" class="btnCSVImport"><?php echo Yii::app()->controller->__trans('CSV Import'); ?></button>
            </a>
        </div>
    </div>
    <div class="clear"></div>
    <form method="get" action="<?php echo Yii::app()->createUrl('building/searchBuildingResult'); ?>" id="mainSearchCondition" class="mainSearchCondition" name="mainSearchCondition" autocomplete="off">
    <input type="hidden" name="r" value="building/searchBuildingResult"/>
    <?php if(isset($type) && $type == 'office'){ ?>
    <input type="hidden" name="hdnUId" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="keepold" value="1">
    <?php } ?>
    	<div class="header-bg divSearchCondition">
        	<div class="form_part col_1">
            	<div class="col_wrap">
                	<div class="col-right-one">
                    	<div class="divMinMax">
                        	<div class="area searchform-label">
								<?php echo Yii::app()->controller->__trans('Area'); ?>
                            </div>
                            <div class="float-left">
                            	<label><?php echo Yii::app()->controller->__trans('下限'); ?>(坪)</label>
                                <select class="select-one" id="minVal" name="areaMinValue">
                                	<option value="0">-</option>
									<?php
                                    for($i=1;$i<=500;$i++){
										$selected = '';
                                        if($areaMin == $i){
                                            $selected = 'selected';
                                        }
									?>
                                    <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                                    <?php
									}
									?>
                                </select>
                            </div>
                            <div class="float-left maxside">
                            	<label><?php echo Yii::app()->controller->__trans('上限'); ?>(坪)</label>
                                <select  class="select-one" id="maxVal" name="areaMaxValue">
                                	<option value="0">-</option>
									<?php
                                    for($i=1;$i<=500;$i++){
										$selected = '';
										if($areaMax == $i){
                                            $selected = 'selected';
										}
									?>
                                    <option value="<?php echo $i; ?>"<?php echo $selected; ?>><?php echo $i; ?></option>
									<?php
                                    }
									?>
                                </select>
                            </div>
                        </div>
                        <div id="slider-range" class="slider-one slider-range" <?PHP echo isset($areaMin) ? 'min="'.$areaMin.'"' : ''; ?> <?PHP 
						if(isset($areaMax)){ echo 'max="'.$areaMax.'"';
						
						}
						 ?>></div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update"><?php echo Yii::app()->controller->__trans('floor'); ?></label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                	<select name="floorMin" id="floorMin" data-role="none" class="floor-drop">
                                    	<option value="-">-</option>
                                        <option value="-1">B1</option>
                                        <option value="-2">B2</option>
										<?php
                                        for($i=1;$i<=100;$i++){
											$selected = '';
											if($floorMin == $i){
												$selected = 'selected';
											}
										?>
                                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
										<?php
                                        }
										?>
                                    </select>～
                                    <select name="floorMax" id="floorMax" data-role="none" class="floor-drop">
                                    	<option value="-">-</option>
                                        <option value="-1">B1</option>
                                        <option value="-2">B2</option>
										<?php
                                        for($i=1;$i<=100;$i++){
											$selected = '';
											if($floorMax == $i){
												$selected = 'selected';
											}
										?>
                                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
										<?php
                                        }
										?>
                                    </select>
                                    <span class="floor-text-min"> 階</span>
                               	</span>
                            </div>
                        </div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update"><?php echo Yii::app()->controller->__trans('Updated date'); ?></label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
								<?php
                                	$allDate =  $allDate2 = $allDate3 = array();
									foreach($updateProperties as $update){
										$allDate[] = date('Y-m-d',strtotime($update['modified_on']));
									}
									foreach($updateProperties2 as $update2){
										$allDate[] = date('Y-m-d',strtotime($update2['added_on']));
									}
									foreach($updateProperties3 as $update3){
										$allDate2[] = date('Y-m-d',strtotime($update3['added_on']));
									}
									foreach($updateProperties4 as $update4){
										$allDate2[] = date('Y-m-d',strtotime($update4['added_on']));
									}
									foreach($updateProperties5 as $update5){
										$allDate3[] = date('Y-m-d',strtotime($update5['added_on']));
									}
									$vals = array_count_values($allDate);
									$vals2 = array_count_values($allDate2);
									$vals3 = array_count_values($allDate3);
								?>
                                	<select name="updateDateDrop" id="updateDateDrop" data-role="none" class="date-drop">
                                    	<option value="0">-</option>
										<?php
                                        foreach($vals as $k=>$v){
										?>
                                        <option value="<?php echo $k.'~u'; ?>">
										<?php
                                        	echo date('Y.m.d',strtotime($k)).' 更新物件'.'('.$v.')';
										}
										?>
                                        </option>
										<?php
                                        foreach($vals2 as $k=>$v){
										?>
                                        <option value="<?php echo $k.'~a'; ?>">
										<?php
                                        	echo date('Y.m.d',strtotime($k)).' 新着物件'.'('.$v.')';
										}
										?>
                                        </option>
										<?php
                                        foreach($vals3 as $k=>$v){
										?>
                                        <option value="<?php echo $k.'~r'; ?>">
											<?php echo date('Y.m.d',strtotime($k)).' 非募集になった物件'.'('.$v.')';
										}
										?>
                                        </option>
                                        <option value="">-</option>
                                        <option value="1">過去7日間の更新全て</option>
                                        <option value="2">過去30日間の更新全て</option>
                                        <option value="3">過去60日間の更新全て</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update"><?php echo Yii::app()->controller->__trans('Brokerage free'); ?></label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                	<input type="checkbox" value="1" id="slideThree" name="brokerageFree" <?php echo $brokerageFree; ?>/>手数料有りの物件のみ
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_part col_2">
            	<div class="col_wrap">
                	<div class="col-right-one">
                    	<div class="divMinMax">
                        	<div class="unit searchform-label">
								<?php echo Yii::app()->controller->__trans('Price per unit of area'); ?>
                            </div>
                            <div class="float-left">
                            	<label><?php echo Yii::app()->controller->__trans('下限'); ?>(万円)</label>
                                <select class="select-one" id="minVal-1" name="unitMinValue">
                                    <option value="0">-</option>
                                    <?php
                                    for($i=0.5;$i<=5;$i += 0.5){
                                        $selected = '';
                                        if($unitMin == $i){
                                            $selected = 'selected';
                                        }
                                    ?>
                                    <option value="<?php echo $i; ?>" <?php echo $selected;?>><?php echo $i; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="float-left maxside">
                            	<label><?php echo Yii::app()->controller->__trans('上限'); ?>(万円)</label>
                                <select  class="select-one" id="maxVal-1" name="unitMaxValue">
                                	<option value="0">-</option>
									<?php
                                    for($i=0.5;$i<=5;$i += 0.5){
										$selected = '';
										if($unitMax == $i){
											$selected = 'selected';
										}
									?>
                                    <option value="<?php echo $i; ?>" <?php echo $selected;?>><?php echo $i; ?></option>
									<?php
                                    }
									?>
                                </select>
                            </div>
                        </div>
                        <div id="slider-range" <?PHP echo isset($unitMin) ? 'min="'.$unitMin.'"' : ''; ?> <?PHP 
						if(isset($unitMax)){ echo 'max="'.$unitMax.'"';
						
						}
						 ?> class="slider-one slider-range-1"></div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update"><?php echo Yii::app()->controller->__trans('Age of Building'); ?> </label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                	<select name="buildingAge" id="buildingAge" data-role="none" class="floor-drop">
                                        <option value="0">-</option>
                                        <?php
                                        for($i=36; $i>=0; $i--){
                                            $selected = '';
                                            if($buildingAge == date("Y", strtotime("-$i year"))){
                                                $selected = 'selected';
                                            }
                                        ?>
                                        <option value="<?php echo date("Y", strtotime("-$i year")); ?>" <?php echo $selected; ?>><?php echo date("Y", strtotime("-$i year"));; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>年以降に竣工
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update passible-title"><?php echo Yii::app()->controller->__trans('Possible date to moving'); ?></label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
								<?php
                                	$curr_month = date("m");
									$month = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
									$month = array_slice($month, $curr_month-1);
									$monthAll = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
									$currYear = date("Y");
									$fullyear = date("Y");
									$select = "<select name=\"possibleDataMin\">\n <option value='0'>-</option>";
									for($i=0; $i <= 2; $i++){
										if($i == 0){
											$month = $month;
										}else{
											$month = $monthAll;
										}
										foreach($month as $key => $val){
											$selected = '';
											if($possibleDataMin == $fullyear.'/'.date('m',strtotime($val))){
												$selected = 'selected';
											}
											$select .= "\t<option value=\"".$fullyear.'/'.date('m',strtotime($val))."\"".$selected;
											if($key == 0 &&  $currYear == $fullyear){
												$select .= ">".' '.$fullyear.'年'.date('m',strtotime($val)).'月'."</option>\n";
											}else{
												$select .= ">".' '.$fullyear.'年'.date('m',strtotime($val)).'月'."</option>\n";
											}
										}
										$fullyear++;
									}
									$select .= "</select>";
									echo $select;
								?>～
								<?php
                                	$curr_month = date("m");
									$month = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
									$month = array_slice($month, $curr_month-1);
									$monthAll = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
									$currYear = date("Y");
									$fullyear = date("Y");
									$select = "<select name=\"possibleDataMax\">\n <option value='0'>-</option>";
									for($i=0; $i <= 2; $i++){
										if($i == 0){
											$month = $month;
										}else{
											$month = $monthAll;
										}
										foreach($month as $key => $val){
											$selected = '';
											if($possibleDataMax == $fullyear.'/'.date('m',strtotime($val))){
												$selected = 'selected';
											}
											$select .= "\t<option value=\"".$fullyear.'/'.date('m',strtotime($val))."\"".$selected;
											if($key == 0 && $currYear == $fullyear){
												$select .= ">".' '.$fullyear.'年'.date('m',strtotime($val)).'月'."</option>\n";
											}else{
												$select .= ">".' '.$fullyear.'年'.date('m',strtotime($val)).'月'."</option>\n";
											}
										}
										$fullyear++;
									}
									$select .= "</select>";
									echo $select;
								?>
                            	</span>
                            </div>
                        </div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update passible-title"><?php echo Yii::app()->controller->__trans('Specify Customer Name'); ?></label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                	<input type="text" name="specifyCustomerName" id="specifyCustomerName" class="input-part specifyCustomerName" autocomplete="off" <?php echo $specifyCustomerName; ?>>
                                    <div class="respName"></div>
                                </span>
                                <span class="tip">※指定した場合、この顧客にひも付いているフロアに色が付いて表示されます</span>
                            </div>
                        </div>
          			</div>
                </div>
            </div>
            <div class="form_part col_3">
            	<div class="col_wrap">
                	<div class="col-right-one no-pad-right">
                    	<div class="divMinMax costMinAmount">
                        	<div class="cost searchform-label"><?php echo Yii::app()->controller->__trans('Total Cost'); ?></div>
                            	<div class="float-left">
                                	<label>下限</label>
                                    <select class="select-one" id="costMinAmount" name="costMinAmount">
                                        <option value="0">-</option>
                                        <?php
                                        for($i=10000;$i<=10000000;$i += 10000){
											$selected = '';
											if($costMin == $i){
												$selected = 'selected';
											}
                                        ?>
                                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span >円</span>
                                </div>
                                <div class="float-left between">~</div>
                                <div class="float-left maxside">
                                	<label>上限</label>
                                    <select  class="select-one" id="costMaxAmount" name="costMaxAmount">
                                       	<option value="0">-</option>
										<?php
                                        for($i=10000;$i<=10000000;$i += 10000){
											$selected = '';
											if($costMax == $i){
												$selected = 'selected';
											}
										?>
                                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
										<?php
                                        }
										?>
                                    </select>
                                    <span>円</span>
                                </div>
                            </div>
                        <div id="slider-range" class="slider-one"></div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update status-title "><?php echo Yii::app()->controller->__trans('Status of Recruitment'); ?></label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                	<input type="checkbox" value="1" <?PHP echo in_array(1,$statusRequirement) ? 'checked' : '' ?> id="slideThree" name="statusRequirement[]" <?php echo $statusRequirementCheck_1; ?> />募集中
                                    <input type="checkbox" <?PHP echo in_array(2,$statusRequirement) ? 'checked' : '' ?> value="2" id="slideThree" name="statusRequirement[]" class="checkbox-one" <?php echo $statusRequirementCheck_2; ?> />1年以内に空き予定
                                    <input type="checkbox" <?PHP echo in_array(3,$statusRequirement) ? 'checked' : '' ?> value="3" id="slideThree" name="statusRequirement[]" class="checkbox-one" <?php echo $statusRequirementCheck_3; ?> />満室
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update Requirement-title"><?php echo Yii::app()->controller->__trans('Recruitment in Building'); ?></label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                	<input type="checkbox" value="1" id="slideThree" <?PHP echo isset($requirementOfBuilding) && $requirementOfBuilding == 1 ? 'checked' : '' ?>  name="requirementOfBuilding"/>ビルに募集中フロアが有る場合は全て表示する
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label deadline-title">
                                	<input type="checkbox" name="deadlineCheck" value="1" <?php echo $deadCheck; ?>> <?php echo Yii::app()->controller->__trans('Property with deadline'); ?>
                                </label>
                                <span class="searchform-input-wrapper select-numbers text-one"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="more-filter">
            	<div class="second_part">
                	<div class="TextField">
                    	<div class="searchform-param">
                        	<label class="searchform-label date-update"><?php echo Yii::app()->controller->__trans('Facilities'); ?></label>
                            <div class="fac-check-wrapper">
                            	<input type="checkbox" value="1" id="slideThree" name="facilities[]" <?php echo $facCheck1; ?>/>男女別トイレ
                                <input type="checkbox" value="2" id="slideThree" name="facilities[]" class="checkbox-one" <?php echo $facCheck2; ?>/>OAフロア
                                <input type="checkbox" value="3" id="slideThree" name="facilities[]" class="checkbox-one" <?php echo $facCheck3; ?>/>個別空調
                                <input type="checkbox" value="4" id="slideThree" name="facilities[]" class="checkbox-one" <?php echo $facCheck4; ?>/>フロア分割可
                                <input type="checkbox" value="5" id="slideThree" name="facilities[]" class="checkbox" <?php echo $facCheck5; ?>/>耐震補強
                                <input type="checkbox" value="6" id="slideThree" name="facilities[]" class="checkbox" <?php echo $facCheck6; ?>/>一棟貸し可
                                <input type="checkbox" value="7" id="slideThree" name="facilities[]" class="checkbox-one" <?php echo $facCheack7; ?>/>緊急発電装置対応
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second_part">
                	<div class="TextField">
                    	<div class="searchform-param">
                        	<label class="searchform-label date-update Floor-title"><?php echo Yii::app()->controller->__trans('Type of Floor'); ?></label>
                            <span class="searchform-input-wrapper select-numbers search-floor">
							<?php
                            if(isset($useTypesDetails) && $useTypesDetails != ''){
								foreach($useTypesDetails as $use){
									$check ='';
									if(isset($floorType) && in_array($use['user_type_id'],$floorType)){
										$check ='checked';
									}
							?>
                            	<input type="checkbox" value="<?php echo $use['user_type_id']; ?>"  <?php echo $check; ?> id="slideThree" name="floorType[]" class="checkbox-formtype chck_space"/><?php echo Yii::app()->controller->__trans($use['user_type_name']); ?>
							<?php
                            	}
							}
							?>
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
								<?php
								foreach($formTypeListAr as $form){
									
									$checked = '';
									
									if(isset($formTypeList) && in_array($form->form_type_id,$formTypeList)){
										$checked = 'checked="checked"';
									}
									
									if(($i % 3 == 0 )){
										echo '<input type="checkbox" name="formTypeList[]" value="'.$form->form_type_id.'"  class="checkbox-formtype chck_space" '.$checked.'>';echo $form->form_type_name;
									}else{
										echo '<input type="checkbox" name="formTypeList[]" value="'.$form->form_type_id.'"  class="checkbox-formtype chck_space" '.$checked.'>';echo $form->form_type_name;
									}
									$i++;
								
								}
								?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update type-title"><?php echo Yii::app()->controller->__trans('Type of Lender'); ?></label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                	<input type="checkbox" value="7" <?PHP echo in_array(7,$lenderType) ? 'checked' : ''; ?> id="slideThree" name="lenderType[]" <?php echo $lendCheck1; ?>/>貸主
                                    <input type="checkbox" value="10" <?PHP echo in_array(10,$lenderType) ? 'checked' : ''; ?> id="slideThree" name="lenderType[]" class="checkbox-one" <?php echo $lendCheck2; ?>/>業者
                                    <input type="checkbox" value="-1" <?PHP echo in_array(-1,$lenderType) ? 'checked' : ''; ?> id="slideThree" name="lenderType[]" class="checkbox-one" <?php echo $lendCheck3; ?>/>不明
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
                                	<input type="radio" value="3" id="slideThree" name="walkFromStation" <?php echo $walkFromStation1; ?>/>3分以内
                                    <input type="radio" value="5" id="slideThree" name="walkFromStation" class="checkbox-two" <?php echo $walkFromStation2; ?>/>5分以内
                                    <input type="radio" value="10" id="slideThree" name="walkFromStation" class="checkbox-two" <?php echo $walkFromStation3; ?>/>10分以内
                                    <input type="radio" value="15" id="slideThree" name="walkFromStation" class="checkbox-two" <?php echo $walkFromStation4; ?>/>15分以内
                               	</div>
                            </div>
                        </div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update"><?php echo Yii::app()->controller->__trans('Short Rent'); ?></label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                	<input type="checkbox" value="1" id="slideThree" name="shortRent" <?php echo $shortRent; ?>/>短期貸し対応
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-part">
        	<ul class="tabs float-left">
            	<li class="<?PHP echo $actTab == 1 ? 'active' : '' ?>" title="1"><a href="#"><?php echo Yii::app()->controller->__trans('CITY OF AREA'); ?></a></li>
                <li title="2" class="<?PHP echo $actTab == 2 ? 'active' : '' ?>"><a href="#"><?php echo Yii::app()->controller->__trans('ROUTE'); ?></a></li>
                <li title="3" class="<?PHP echo $actTab == 3 ? 'active' : '' ?>"><a href="#"><?php echo Yii::app()->controller->__trans('BLD NAME'); ?></a></li>
                <li title="4" class="<?PHP echo $actTab == 4 ? 'active' : '' ?>"><a href="#"><?php echo Yii::app()->controller->__trans('ADDRESS'); ?></a></li>
                <li title="5" class="<?PHP echo $actTab == 5 ? 'active' : '' ?>"><a href="#"><?php echo Yii::app()->controller->__trans('BLD ID/FLOOR ID'); ?></a></li>
                <li title="6" class="<?PHP echo $actTab == 6 ? 'active' : '' ?>"><a href="#"><?php echo Yii::app()->controller->__trans('OWNER NAME'); ?></a></li>
            </ul>
        </div>
        <div class="tabs_content mang-tab">
        	<div class="searchTab" style="display: <?PHP echo $actTab == 1 ? 'block' : 'none' ?>;" data-tabname="area">
            	<div class="searchTabInner clearfix">
                	<table class="tblSearchAddress">
                    	<tr>
                        	<td>
                            	<div class="text-drop-title">
                                	<h2 class="pre-title"> <?php echo Yii::app()->controller->__trans('Prefecture'); ?></h2>
                                    <select class="pre-list" id="pre-list" name="pre-list">
                                    	<option value="">-</option>
										<?php
										if(isset($_GET['type']) && $_GET['type'] == 'office'){
											$prefectureList = Prefecture::model()->findAll();
										}else{
											$prefectureList = Prefecture::model()->getAvailablePrefecture();
										}
                                       	$selected_pre = 0;
										if(isset($prefectureList) && count($prefectureList) > 0){
											foreach($prefectureList as $prefecture){
												$sel = '';
												if(isset($returnarr['pre-list']) && $returnarr['pre-list'] == $prefecture['code']){
													
													$sel = 'selected';
													$selected_pre = $prefecture['code'];
												}
												
										?>
                                        <option <?PHP echo $sel; ?> value="<?php echo $prefecture['code']; ?>"><?php echo $prefecture['prefecture_name']; ?></option><?php /* <option value="<?php echo $prefecture['prefecture_name']; ?>"><?php echo $prefecture['prefecture_name']; ?></option>	*/ ?>
										<?php
                                        	}
										}

										
										?>
                                    </select>
                                    
                                </div>
                                <div class="text-drop-title" style="position:relative;display:none;">
                                	<h2 class="pre-title"><?php echo Yii::app()->controller->__trans('District'); ?></h2>
                                    <div class="gifLoader districtGif" style="display:none;"><img src="<?php echo Yii::app()->baseUrl; ?>/images/ins.gif"/></div>
                                    <select class="prefectureDistrictlist" id="prefectureDistrictlist" name="prefectureDistrictlist" <?PHP if(!isset($searchCond->prefectureDistrictlist)){ echo 'disabled'; } ?>>
                                    	<option value="">-</option>
                                        <?PHP
										if($selected_pre){
											$distAry = $this->actionGetDisctrictList($selected_pre);
											
											foreach($distAry as $dist){
												$sel = '';
												if($dist['id'] == $searchCond->prefectureDistrictlist){
													$sel = 'selected';
												}
												echo '<option '.$sel.' value="'.$dist['id'].'">'.$dist['name'].'</option>'; 	
											}
											
													
												}
										
										 ?>
                                    </select>
                                    
                                </div>
                                
                            	<div class="text-drop-title" style="position:relative;">
                                	<h2 class="pre-title"><?php echo Yii::app()->controller->__trans('District'); ?></h2>
                                    <div class="gifLoader townGif" style="display:none;"> <img src="<?php echo Yii::app()->baseUrl; ?>/images/ins.gif"/></div>
                                    <div class="gray-title prefectureDistrictlist_new" style="height: 210px;overflow-y: scroll;">


                                    	
                                        <?PHP
										$hiddenTwn = '';
										if($selected_pre){
											
											//print_r($returnarr); 
											$twnAry = $this->actionGetDisctrictList($selected_pre,true);
											//print_r($twnAry); die;
											$t='';
											foreach($twnAry as $twn){
												// $sel = '';
												// if(in_array($twn['id'],$returnarr['districtTownList'])){
												// 	$sel = 'checked';
												// }
												//print_r($returnarr);
												$isAct = false;
												if(isset($returnarr['mydistrictList']) && in_array($twn['id'],$returnarr['mydistrictList'])){
													$isAct = true;
													if($t==''){
														$t = "changeclass ";
														// $isAct = false;
													}

										
												}
												
												// echo '<div class="listli '.($sel != '' ? 'activelistli' : '').'">
												// '.($sel != '' ? '<i class="fa fa-check-square item-check" aria-hidden="true"></i>' : '').'
												
												// <input class="districtTownList" type="checkbox" '.$sel.' data-name="'.$twn['name'].'" value="'.$twn['id'].'">'.$twn['name'].'</div>'; 


												echo  '<div class="listli_new  '.($isAct ? 'activelistli' : '').'" data-value="'.$twn['id'].'">';
											echo  '<i class="fa '.($isAct?'fa-check-square':'fa-square').'" aria-hidden="true"></i>';
											echo  '<input  name="mydistrictList[]" type="checkbox"'. ($isAct ? 'checked' : '').' value="'.$twn['id'].'" data-name="'.$twn['name'].'"><span data-name="'.$twn['id'].'">'.$twn['name'].'</span>';
											echo  '</div>';	

											if($t=='changeclass ')
												$t = 'c ';
											}
											
													
												}
										
										 ?>
                                        
                                        
                                    </div>
                                </div>
                                                                
                            </td>
                        	<td>
                            	<div class="text-drop-title" style="position:relative;">
                                	<h2 class="pre-title"><?php echo Yii::app()->controller->__trans('Town'); ?></h2>
                                    <div class="gifLoader townGif" style="display:none;"> <img src="<?php echo Yii::app()->baseUrl; ?>/images/ins.gif"/></div>
                                    <div class="gray-title districtTownList">
                                    	
                                        <?PHP
										$hiddenTwn = '';
										 //print_r($returnarr);
										if(isset($selected_pre) && isset($returnarr['districtTownList'] )){
											
											$twnAry = $this->actionGetTownList(floor($returnarr['districtTownList'][0]));

											// print "<>"
											 // print_r($twnAry);
											
											foreach($twnAry as $twn){

												$isAct = false;
												if(isset($returnarr['districtTownList']) && in_array($twn['id'],$returnarr['districtTownList'],true)){
													$isAct = true;

													if($t==''){
														$t = "changeclasstown ";
														// $isAct = false;
													}

												}
												//$townname = str_replace($post['district_name'], "", $town['name']);
												echo  '<div class="listli '.($isAct ? 'activelistli' : '').'">'.($isAct ? '<i class="fa  fa-check-square item-check" aria-hidden="true"></i> ' : '').'<input '.($isAct ? 'checked' : '').'  type="checkbox" value="'.$twn['id'].'" data-name="'.$twn['name'].'">'.$twn['name'].'</div>';

												if($t=='changeclasstown ')
													$t = 'c ';
												// $sel = '';
												// if(in_array($twn['id'],$returnarr['districtTownList'])){
												// 	$sel = 'checked';
												// }
												
												// echo '<div class="listli '.($sel != '' ? 'activelistli' : '').'">
												// '.($sel != '' ? '<i class="fa fa-check-square item-check" aria-hidden="true"></i>' : '').'
												
												// <input class="districtTownList" type="checkbox" '.$sel.' data-name="'.$twn['name'].'" value="'.$twn['id'].'">'.$twn['name'].'</div>'; 	
											}
											
													
												}
										
										 ?>
                                        
                                        
                                    </div>
                                </div>
                                <div class="hiddenTwnvals">
                                <?PHP 
								if(isset($returnarr['districtTownList']) && count($returnarr['districtTownList']) > 0){
									$criteria = new CDbCriteria();
									$criteria->addInCondition("code", $returnarr['districtTownList']);
									$result = Town::model()->findAll($criteria);
									foreach($result as $tSingle){
										echo '<input type="hidden" name="districtTownList[]" data-tname="'.$tSingle['town_name'].'" value="'.$tSingle['code'].'" />';
									}								
								}
								?>
                               
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                    <table class="tblSearchAddressResult">
                    	<tr>
                        	<td>
                            	<div class="addressBeforeResult">
                                	<div class="divResultOfRouteBefore">
                                    	<div class="divRouteTitle">
                                        	<span><?php echo Yii::app()->controller->__trans('Added Area'); ?></span>
                                        </div>
                                        <span class="noStation"><?php echo Yii::app()->controller->__trans('エリアを追加して下さい'); ?></span>
                                    </div>
                                </div>
                                <div class="addressResult hide">
                                	<div class="divResultOfRoute">
                                    	<div class="divRouteTitle">
                                        	<span><?php echo Yii::app()->controller->__trans('Added Area'); ?></span>
                                        </div>
                                        <div class="searchInnerContent" style="font-size:14px;">
											<?php echo Yii::app()->controller->__trans('The number of properties that match the conditions'); ?>
                                            <div class="searchContent">
                                            	<span class="totalFloorForAddress">
                                                	<span class="number"></span>
                                                    <span class="text-name">フロア</span>
                                                </span>/
                                                <span class="totalBuildingForAddress">
                                                	<span class="number"></span>
                                                    <span class="text-name">棟</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="selectedSearchCriteria">
                                        	<div class="divSelArea">
                                            	<span class="selectedArea"></span>
                                                <span class="removeSelectedStation"><i class="fa fa-times-circle"></i></span>
                                            </div>
                                        </div>
										<?php
                                        if(isset($type) && $type == 'office'){
										?>
                                        	<button type="button" class="btnSearchPropertiesAddress searchPropertiesBtn" id="btnSearchPropertiesAddress" name="btnSearchPropertiesAddress" style="width: 311px;font-size: 16px;background: rgba(18,170,235,1);"><?php echo Yii::app()->controller->__trans('Set as Office alert'); ?></button>
										<?php
                                        }else{
										?>
                                        	<button type="button" class="btnSearchPropertiesAddress searchPropertiesBtn" id="btnSearchPropertiesAddress" name="btnSearchPropertiesAddress" style="width: 311px;font-size: 16px;background: rgba(18,170,235,1);"><?php echo Yii::app()->controller->__trans('Search Properties'); ?></button>
										<?php
                                        }
										?>
                                    </div>
                                </div>
                           	</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="searchTab" style="display: <?PHP echo $actTab == 2 ? 'block' : 'none' ?>;" data-tabname="route">
            	<div class="searchTabInner clearfix">
                	<div class="routeSearchCriteria">
                    	<div class="divPrefectureList prefecture-route">
                        	<ul class="prefectureList">
							<?php
								if(isset($_GET['type']) && $_GET['type'] == 'office'){
									$prefectureList = Prefecture::model()->findAll();
								}else{
									$prefectureList = Prefecture::model()->getAvailablePrefecture();
								}
								$actPref = 13;
								if(isset($searchallCond->hdnRPrefId)) $actPref = $searchallCond->hdnRPrefId;
								if(isset($prefectureList) && count($prefectureList) > 0){
									foreach($prefectureList as $prefecture){
							?>
                            	<li class="singlePrefecture <?php echo ($actPref == $prefecture['code']) ? 'activePrefecture' : ''?>" data-value="<?php echo $prefecture['code']; ?>">
								<?php 
								if($actPref == $prefecture['code'] && isset($searchallCond->hdnRPrefId)){ $searchallCond->hdnRPrefName = $prefecture['prefecture_name'];
									echo '<i class="fa fa-check-square item-check" aria-hidden="true"></i>';
								}
								echo $prefecture['prefecture_name'];
								 ?>
                              	</li>
							<?php
                            		}
								}
							?>
                            </ul>
                        </div>
                        <div class="route-option first">
                        	<div class="divPrefectureList">
                            	<h2 class="pre-title"><?php echo Yii::app()->controller->__trans('鉄道会社'); ?></h2>
                                <div class="corporateList">
                                <?PHP 
								if(isset($searchallCond->hdnRPrefId) && isset($searchallCond->hdnRPrefName)){
									
									echo $this->actionGetCorporationList($searchallCond->hdnRPrefId,$searchallCond->hdnRPrefName,$searchallCond->hdnRailId);
								}
								?>
                                
                                </div>
                            </div>
                            <div class="divPrefectureList routeLine">
                            	<h2 class="pre-title"><?php echo Yii::app()->controller->__trans('路線'); ?></h2>
                                <div class="lineList">
                                <?PHP 
								if(isset($searchallCond->hdnRPrefId) && isset($searchallCond->hdnRPrefName) && isset($searchallCond->hdnLineId)){
									$lineAry = $this->actionGetLineList($searchallCond->hdnRailId,$searchallCond->hdnRPrefId,$searchallCond->hdnRPrefName,$searchallCond->hdnLineId);
									echo $lineAry['html'];
									$actLineName = $lineAry['actLname'];
									/*echo $this->actionGetCorporationList($searchallCond->hdnRPrefId,$searchallCond->hdnRPrefName,$searchallCond->hdnRailId);*/
								}
								?>
								<?PHP 
								//;
								?>
                                
                                </div>
                            </div>
                        </div>
                        <div class="route-option">
                        	<div class="divPrefectureList routeStation">
                            	<h2 class="pre-title line-text">路線が未選択です</h2>
                                <div class="stationList">
                                <?PHP 
								if(isset($searchallCond->hdnRPrefId) && isset($searchallCond->hdnRPrefName) && isset($searchallCond->hdnLineId) && isset($searchallCond->hdnRRouteId) && $actLineName != ''){
									$actRoute = explode(',',$searchallCond->hdnRRouteId);
									echo $this->actionGetStationList($searchallCond->hdnLineId,$actLineName,$searchallCond->hdnRPrefName,$actRoute);
								}
								?>
                                </div>
                                <div class="hiddenActionStations">
                                <?PHP 
								if(isset($searchallCond->hdnRPrefId) && isset($searchallCond->hdnRPrefName) && isset($searchallCond->hdnLineId) && isset($searchallCond->hdnRRouteId) && $actLineName != ''){
									$actRoute = explode(',',$searchallCond->hdnRRouteId);
									foreach($actRoute as $rK=>$rSingle){
										echo '<input type="hidden" class="actStationEle" data-value="'.$rSingle.'">';
									}
								}
								?>
                                </div>
                            </div>
                        </div>
                   	</div>
                    <div class="routeBeforeResult">
                    	<div class="divResultOfRouteBefore">
                        	<div class="divRouteTitle">
                            	<span>
									<?php echo Yii::app()->controller->__trans('Added Area'); ?>
                                </span>
                            </div>
                            <span class="noStation">
								<?php echo Yii::app()->controller->__trans('駅を追加してください'); ?>.
                            </span>
                        </div>
                   	</div>
                    <div class="routeResult hide">
                    	<div class="divResultOfRoute">
                        	<div class="divRouteTitle">
                            	<span>
									<?php echo Yii::app()->controller->__trans('Added Area'); ?>
                                </span>
                            </div>
                            <div class="searchInnerContent">
								<?php echo Yii::app()->controller->__trans('The number of properties that match the conditions'); ?>
                                <div class="searchContent">
                                	<span class="totalFloor">
                                    	<span class="number"></span>
                                        <span class="text-name">フロア</span>
                                    </span>/
                                    <span class="totalBuilding">
                                    	<span class="number"></span>
                                        <span class="text-name">棟</span>
                                    </span>
                                </div>
                            </div>
                            <div class="selectedSearchCriteria">
                            	<div>
                            		<span class="selectedStation"></span>
                            		<span class="removeSelectedStation"><i class="fa fa-times-circle"></i></span>
                        		</div>
            				</div>
							<?php
                            if(isset($type) && $type == 'office'){
							?>
                            	<button type="button" class="btnSearchProperties searchPropertiesBtn" id="btnSearchProperties" name="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Set as Office alert'); ?></button>
							<?php
                            }else{
							?>
                            	<button type="button" class="btnSearchProperties searchPropertiesBtn" id="btnSearchProperties" name="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Search Properties'); ?></button>
							<?php
                            }
							?>
                        </div>
                    </div>
                </div>
            </div>
	  <div class="searchTab" style="display: <?PHP echo $actTab == 3 ? 'block' : 'none' ?>;">
      <div class="searchTabInner clearfix">
        <h2 class="owner-name"> <?php echo Yii::app()->controller->__trans('please input Buiding name'); ?></h2>
          <textarea name="buildingSearchName" class="text-box-company" style="resize:none"><?PHP if((isset($searchallCond->buildingSearchName) && $searchallCond->buildingSearchName != '')){
		  	echo $searchallCond->buildingSearchName;
		  }?></textarea>
          <h2 class="youcan-name"> *<?php echo Yii::app()->controller->__trans('you can input multiple ny making a line break'); ?></h2>
          
            <h2 class="option"><?php echo Yii::app()->controller->__trans('option:search buildings by address'); ?></h2>
            <input type="text" name="buildingSearchAddressTxt" class="tok-text" value="<?PHP if((isset($searchallCond->buildingSearchAddressTxt) && $searchallCond->buildingSearchAddressTxt != '')){
		  	echo $searchallCond->buildingSearchAddressTxt;
		  }?>">
            <h2 class="how-one">*<?php echo Yii::app()->controller->__trans('if you input :"tokyo", buildings which including "tokyo" in name and address'); ?></h2>
            <div class="search_prpt_btn">
              <?php
              if(isset($type) && $type == 'office'){
				?>
				<button type="submit" class="btnSetAsOffice searchPropertiesBtn" id="btnSetAsOffice" name="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Set as Office alert'); ?></button>
				<?php
				}else{
				?>
              <button type="submit" name="btnSearchBuilding" id="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Search'); ?></button>
              <?php
				}
			  ?>
  
            
          </div>
      </div>
    </div>
	  <div class="searchTab" style="display: <?PHP echo $actTab == 4 ? 'block' : 'none' ?>;">
      <div class="searchTabInner clearfix">
        <h2 class="owner-name"><?php echo Yii::app()->controller->__trans('Please input address'); ?></h2>
          <textarea name="buildingSearchAddress" class="text-box-company" style="resize:none"><?PHP if((isset($searchallCond->buildingSearchAddress) && $searchallCond->buildingSearchAddress != '')){ echo $searchallCond->buildingSearchAddress; }?></textarea>
          <div class="check-wrapper-bdad">
          <input type="radio" value="searchByFullAdd" name="cityName" class="searchby" <?PHP if((isset($searchallCond->cityName) && $searchallCond->cityName == 'searchByFullAdd')){ echo 'checked'; }  if(!isset($searchallCond->cityName)){ echo 'checked'; } ?>>
          <?php echo Yii::app()->controller->__trans('Search by matched full address'); ?>
          <input type="radio"  value="searchByNearAdd" name="cityName" class="searchby checkbox-two" <?PHP if((isset($searchallCond->cityName) && $searchallCond->cityName == 'searchByNearAdd')){ echo 'checked'; }?>>
          <?php echo Yii::app()->controller->__trans('Search surrounding area near matched address with a radius of'); ?>
          <input type="text" class= "txtAddressSearch" name="radiusValue" value="400" value="<?PHP if((isset($searchallCond->radiusValue) && $searchallCond->radiusValue != '')){ echo $searchallCond->radiusValue; }?>">
          <?php echo Yii::app()->controller->__trans('meters'); ?>
          </div>
    
        <div class="search_prpt_btn btn-five-foot">
           <?php
              if(isset($type) && $type == 'office'){
				?>
				<button type="submit" class="btnSetAsOffice searchPropertiesBtn" id="btnSetAsOffice" name="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Set as Office alert'); ?></button>
				<?php
				}else{
				?>
           <button type="submit" name="btnSearchBuilding" id="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Search'); ?></button> 
           <?php
				}
		   ?>
        </div>
      </div>
    </div>
	  <div class="searchTab searchbdid" style="display: <?PHP echo $actTab == 5 ? 'block' : 'none' ?>;">
      <div class="searchTabInner clearfix">
        <h2 class="owner-name"><?php echo Yii::app()->controller->__trans('Please input Buillding ID or Floor ID'); ?></h2>
        <h2 class="owner-name build"><?php echo Yii::app()->controller->__trans('Buillding ID'); ?></h2>
          <textarea name="buildingSearchId" class="text-box-company" style="resize:none"><?PHP if((isset($searchallCond->buildingSearchId) && $searchallCond->buildingSearchId != '')){ echo $searchallCond->buildingSearchId; }?></textarea>
          <h2 class="owner-name  build"> <?php echo Yii::app()->controller->__trans('Floor ID'); ?></h2>
          <textarea name="floorSearchId" class="text-box-company" style="resize:none"><?PHP if((isset($searchallCond->floorSearchId) && $searchallCond->floorSearchId != '')){ echo $searchallCond->floorSearchId; }?></textarea>
          <h2 class="youcan-name"> *<?php echo Yii::app()->controller->__trans('you can input multiple ny making a line break'); ?></h2>
          <div class="search_prpt_btn btn-five-foot">
         <?php
              if(isset($type) && $type == 'office'){
				?>
				<button type="submit" class="btnSetAsOffice searchPropertiesBtn" id="btnSetAsOffice" name="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Set as Office alert'); ?></button>
				<?php
				}else{
				?>
          <button type="submit" name="btnSearchBuilding" id="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Search'); ?></button> 
          <?php
				}
		  ?>
        </div>
      </div>
    </div>
      <div class="searchTab" style="display: <?PHP echo $actTab == 6 ? 'block' : 'none' ?>;">
      <div class="searchTabInner clearfix">
        <h2 class="owner-name"> <?php echo Yii::app()->controller->__trans('please input owner name'); ?></h2>
          <textarea name="floorSearchOwnerName" class="text-box-company respOwnerName" style="resize:none"><?PHP if((isset($searchallCond->floorSearchOwnerName) && $searchallCond->floorSearchOwnerName != '')){ echo $searchallCond->floorSearchOwnerName; }?></textarea>
          <h2 class="youcan-name"> *<?php echo Yii::app()->controller->__trans('you can input multiple ny making a line break'); ?></h2>
          <div class="gray-box">
          <div class="input-search-owner clearfix">
          <div class="opt-box">
            <h2 class="option"><?php echo Yii::app()->controller->__trans('option search matched full name'); ?></h2>
            <label class="part"><?php echo Yii::app()->controller->__trans('input part of name'); ?></label>
            <input type="text" class="tok inptOwnerName"/>
            <a data-href="<?php echo Yii::app()->createUrl('building/seachOwnerDropdown'); ?>" class="button-one" id="searchOwnerName"> <?php echo Yii::app()->controller->__trans('Search'); ?></a>
            </div>
            <div class="wht-box" style="display:none;"></div>
            </div>
            <div class="howto-box">
            <p class="how">< <?php echo Yii::app()->controller->__trans('How to use'); ?> ></p>
            <p><?php echo Yii::app()->controller->__trans('input part of name on the field ex : mitsui'); ?></p>
            <p><?php echo Yii::app()->controller->__trans('Matched names will be shown on list'); ?></p>
            <p><?php echo Yii::app()->controller->__trans('After you click a name the list,the name will be input on above input thext area'); ?></p>
            </div>
            <div class="search_prpt_btn">
               <?php
              if(isset($type) && $type == 'office'){
				?>
                
				<button type="submit" class="btnSetAsOffice btnSearchBuilding" id="btnSetAsOffice" name="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Set as Office alert'); ?></button></form> 
				<?php
				}else{
				?>
               <button type="submit" name="btnSearchBuilding" id="btnSearchBuilding"><?php echo Yii::app()->controller->__trans('Search'); ?></button></form> 
               <?php
				}
			   ?>
            </div>
          </div>
       
      </div>
    </div>	
</div>
</div>

<form name="frmSearchAddressBuilding" id="frmSearchAddressBuilding" class="frmSearchAddressBuilding" action="<?php echo Yii::app()->createUrl('building/searchBuildingResult'); ?>" method="get">
<input type="hidden" name="r" value="building/searchBuildingResult"/>
	<input type="hidden" name="hdnAddressBuildingId" id="hdnAddressBuildingId" class="hdnAddressBuildingId" value="0"/>
    <input type="hidden" name="hdnAddressFloorId" id="hdnAddressFloorId" class="hdnAddressFloorId" value="0"/>
    <input type="hidden" name="form_json" id="frmSearchAddressBuildingJson" />
    <?php if(isset($type) && $type == 'office'){ ?>
    <input type="hidden" name="hdnUId" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="keepold" value="1">
    <?php } ?>
    
</form>

<form name="frmSearchRouteBuilding" id="frmSearchRouteBuilding" class="frmSearchRouteBuilding" action="<?php echo Yii::app()->createUrl('building/searchBuildingResult'); ?>" method="get">
<input type="hidden" name="r" value="building/searchBuildingResult"/>
	<input type="hidden" name="hdnRPrefId" id="hdnRPrefId" class="hdnRPrefId" value="0"/>
    <input type="hidden" name="hdnRailId" id="hdnRailId" class="hdnRailId" value="0"/>
    <input type="hidden" name="hdnLineId" id="hdnLineId" class="hdnLineId" value="0"/>
	<input type="hidden" name="hdnRRouteId" id="hdnRRouteId" class="hdnRRouteId" value="0"/>
    <input type="hidden" name="hdnRouteBuildingId" id="hdnRouteBuildingId" class="hdnRouteBuildingId" value="0"/>
    <input type="hidden" name="hdnRouteFloorId" id="hdnRouteFloorId" class="hdnRouteFloorId" value="0"/>
    <input type="hidden" name="form_json" id="frmSearchRouteBuildingJson" />
    <?php if(isset($type) && $type == 'office'){ ?>
    <input type="hidden" name="hdnUId" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="keepold" value="1">
    <?php } ?>
</form>
<script>
var _dont_Change = true;
var _dont_load_tokyo = false;
<?PHP if(isset($searchCond->prefectureDistrictlist)){ ?>
jQuery(window).load(function(e) { 
$('.hiddenTwnvals input').each(function(index, element) {
		address.push($(this).data('tname'));
		addressArray[$(this).data('tname')] = $(this).val();
});
addStationhtml();


change_call(); });
<?PHP }else if($actTab == 2){ ?>
_dont_load_tokyo = true;
jQuery(window).load(function(e){
	 change_call(); 
});
<?PHP } ?>



</script>


<?php if($t=='c ') :?>
<script type="text/javascript">
$(document).ready(function(){
	$('.hiddenTwnvals input').each(function(index, element) {
			address.push($(this).data('tname'));
			addressArray[$(this).data('tname')] = $(this).val();
	});

	var conditionFormData = $('#mainSearchCondition').serializeArray();
			var url = baseUrl+'/index.php?r=building/buildingFilterByAddress';		
			call({url:url,params:{name:address,conditionFormData:conditionFormData},type:'POST',dataType : 'json'},function(resp){	
				$('#frmSearchAddressBuildingJson').val(resp.form_json);	
				$('.totalFloorForAddress .number').html(resp.totalFloor);		
				$('.totalBuildingForAddress .number').html(resp.totalBuilding);		
				$('.hdnAddressBuildingId').val(resp.buildingIds);
				$('.hdnAddressFloorId').val(resp.floorIds);		
				$('.addressBeforeResult').addClass('hide');		
				$('.addressResult').removeClass('hide');		
				$('.divSelArea').html(addStationhtml());				
				if(resp.totalFloor == '0' && resp.totalBuilding == '0'){
					$('.btnSearchPropertiesAddress').attr('disabled','true');
					$('.btnSearchPropertiesAddress').css('cursor','no-drop');
				}else{
					$('.btnSearchPropertiesAddress').removeAttr('disabled');
					$('.btnSearchPropertiesAddress').css('cursor','pointer');
				}
			});
});
</script>
<?php endif; ?>



<!--Popup Box Start-->
<div class="modal-box hide modal-importCSV">
  <div class="content content-print-art">
    <div class="box-header">
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Upload CSV'); ?></h2>
    </div>
    <div class="box-content" style="margin:10px;">
    <div id="imgLoad" style="position:fixed;padding:0;margin:0;top:0;left:0;width:100%;height: 100%;background:rgba(255,255,255,0.5);z-index:1003;display:none;">
    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" width="50" height="50"
    		style="position: absolute;left: 50%;top: 50%;-webkit-transform: translate(-50%, -50%);transform: translate(-50%, -50%);"/>
    </div>
	<div class="file_div_clean">
    	<table class="file_table_clean">
        <tbody>
        <tr>
        	<td class="file_td_clean" style="padding: 0 4px 0 0">
        	<div id="wordpress_file_upload_textbox_1" class="file_div_clean divFakePath">
        		<input type="text" id="fileName_1" class="file_input_textbox" disabled="">
        		<div class="file_space_clean"></div>
        	</div>
            <form class="file_input_uploadform" id="uploadform_1" name="uploadform_1" method="post" enctype="multipart/form-data">
            	<input type="file" class="file_input_hidden uploadPlanClass" name="csvFloor" id="csvFloor" tabindex="1">
            </form>
            </td>
            <td><button type="button" class="btnTrigglerFile">ファイルを選択</button></td>
            <td class="file_td_clean">
	            <div id="wordpress_file_upload_submit_1" class="file_div_clean">
	            	<input align="center" type="button" id="btnUploadCSV" name="btnUploadCSV" value="アップロード" class="btnUploadCSV">
            	</div>
            </td>
         </tr>
         </tbody>
                        </table>
                      </div>
    </div>
  </div>
</div>
<!--Popup Box End--> 