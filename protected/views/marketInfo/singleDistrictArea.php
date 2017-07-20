<form class="frmPrintSingleArea" id="frmPrintSingleArea" name="frmPrintSingleArea" action="<?php echo Yii::app()->createUrl('marketInfo/singleAreaPrint'); ?>" method="post">
    <input type="hidden" name="hdnDisctrict" id="hdnDisctrict" class="hdnDisctrict" value="<?php echo $districtId; ?>" />
    <input type="hidden" name="hdnTown" id="hdnTown" class="hdnTown" value="<?php echo $areaId; ?>" />
    <input type="hidden" name="hdnTownName" id="hdnTownName" class="hdnTownName" value="<?php echo $areaName; ?>" />
    <input type="hidden" name="hdnDistrictName" id="hdnDistrictName" class="hdnDistrictName" value="<?php echo $districtName; ?>" />
</form>

<?php
$areaDiscription = $areaSummary = $areaLandscape = '';
$areaMarketDetails = MarketAreaInfo::model()->find('town_id = '.$areaId);
if(isset($areaMarketDetails) && count($areaMarketDetails) > 0 && !empty($areaMarketDetails)){
	$areaDiscription = $areaMarketDetails['area_discription'];
	$areaSummary = $areaMarketDetails['area_summary'];
	$areaLandscape = $areaMarketDetails['area_landscape'];
	if($areaLandscape == ''){
		$areaLandscape = 'まだ画像は登録されていません。';
	}else{
		$areaLandscape = explode(',',$areaLandscape);
	}
}

/************************* calc avarage for less 50 ******************/
$vacancyRateLess50 = Building::model()->findAll('address Like "%'.$areaName.'%" AND (std_floor_space <= 50 OR std_floor_space = "")');
$building50 = array();
foreach($vacancyRateLess50 as $buildingDetails){
	if($buildingDetails['std_floor_space'] == ""){
		$checkEmptyBuildingSpace = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
		$arrayFloor50 = array();
		foreach($checkEmptyBuildingSpace as $floor){
			$arrayFloor50[] = $floor['area_ping'];
		}
		if(count($arrayFloor50) > 0){
			if(max($arrayFloor50) <= 50){
				$building50[] = $buildingDetails['building_id'];
			}
		}
	}else{
		$building50[] = $buildingDetails['building_id'];
	}
}
$floor50 = array();
$wantedFloor50 = array();

$totalOfVacantFloor  = '';
$totalFloors  = '';
foreach($building50 as $building){
	$floorDetails = Floor::model()->findAll('building_id = '.$building);
	foreach($floorDetails as $floor){
		if($floor['vacancy_info'] == 1 && $floor['move_in_date'] == '即'){
			$wantedFloor50[] = $floor['floor_id'];
			$totalOfVacantFloor += $floor['area_ping'];
		}
		$floor50[] = $floor;
		$totalFloors += $floor['area_ping'];
	}
}

$flootAvarageRent50 = array();
$flootRent50 = array();
foreach($floor50 as $floor){
	if($floor['rent_unit_price'] != "" && $floor['unit_condo_fee'] != ""){
		$flootAvarageRent50[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
	}	
	if($floor['rent_unit_price'] != ""){
		$flootRent50[] = $floor['rent_unit_price'];
	}
}
if(count($flootAvarageRent50) > 0){
	$avarageSum50 = array_sum($flootAvarageRent50)/count($flootAvarageRent50);
	$lowest50 = count($flootRent50) > 0 ? min($flootRent50) : 0;
	$highest50 = count($flootRent50) > 0 ? max($flootRent50) : 0;
}else{
	$avarageSum50 = 0;
	$lowest50 = 0;
	$highest50 = 0;
}

/*********************** end ***************************/

/******************** calc avarage between 50 to 100 ****************/
$vacancyRate50to100 = Building::model()->findAll('address Like "%'.$areaName.'%" AND (std_floor_space BETWEEN 50 AND 100 OR std_floor_space = "")');

$building50to100 = array();
foreach($vacancyRate50to100 as $buildingDetails){
	if($buildingDetails['std_floor_space'] == ""){
		$checkEmptyBuildingSpace = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
		$arrayFloor50To100 = array();
		foreach($checkEmptyBuildingSpace as $floor){
			$arrayFloor50To100[] = $floor['area_ping'];
		}
		if(count($arrayFloor50To100) > 0){
			if(max($arrayFloor50To100) > 50 && max($arrayFloor50To100) < 100){
				$building50to100[] = $buildingDetails['building_id'];
			}
		}
	}else{
		$building50to100[] = $buildingDetails['building_id'];
	}
}
$floor50to100 = array();
$wantedFloor50to100 = array();

$totalOfVacantFloor50to100  = '';
$totalFloors50to100  = '';
foreach($building50to100 as $building){
	$floorDetails = Floor::model()->findAll('building_id = '.$building);
	foreach($floorDetails as $floor){
		if($floor['vacancy_info'] == 1 && $floor['move_in_date'] == '即'){
			$wantedFloor50to100[] = $floor['floor_id'];
			$totalOfVacantFloor50to100 += $floor['area_ping'];
		}
		$floor50to100[] = $floor;
		$totalFloors50to100 += $floor['area_ping'];
	}
}

$flootAvarageRent50to100 = array();
$flootRent50to100 = array();
foreach($floor50to100 as $floor){
	if($floor['rent_unit_price'] != "" && $floor['unit_condo_fee'] != ""){
		$flootAvarageRent50to100[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
	}elseif($floor['rent_unit_price'] != "" && $floor['unit_condo_fee_opt'] == "-3"){
		$flootAvarageRent50to100[] = $floor['rent_unit_price'];
	}
	if($floor['rent_unit_price'] != ""){
		$flootRent50to100[] = $floor['rent_unit_price'];
	}
}

if(count($flootAvarageRent50to100) > 0){
	$avarageSum50to100 = array_sum($flootAvarageRent50to100)/count($flootAvarageRent50to100);
	$lowest50to100 = count($flootRent50to100) > 0 ? min($flootRent50to100) : 0;
	$highest50to100 = count($flootRent50to100) > 0 ? max($flootRent50to100) : 0;
}else{
	$avarageSum50to100 = 0;
	$lowest50to100 = 0;
	$highest50to100 = 0;
}
/************************* end ******************************/

/******************** calc avarage between 100 to 300 ****************/
$vacancyRate100to300 = Building::model()->findAll('address Like "%'.$areaName.'%" AND (std_floor_space BETWEEN 100 AND 300 OR std_floor_space = "")');
$building100to300 = array();
foreach($vacancyRate100to300 as $buildingDetails){	
	if($buildingDetails['std_floor_space'] == ""){
		$checkEmptyBuildingSpace = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
		$arrayFloor100To300 = array();
		foreach($checkEmptyBuildingSpace as $floor){
			$arrayFloor100To300[] = $floor['area_ping'];
		}
		if(count($arrayFloor100To300) > 0){
			if(max($arrayFloor100To300) > 100 && max($arrayFloor100To300) < 300){
				$building100to300[] = $buildingDetails['building_id'];
			}
		}
	}else{
		$building100to300[] = $buildingDetails['building_id'];
	}
}
$floor100to300 = array();
$wantedFloor100to300 = array();

$totalOfVacantFloor100to300  = '';
$totalFloors100to300  = '';
foreach($building100to300 as $building){
	$floorDetails = Floor::model()->findAll('building_id = '.$building);
	foreach($floorDetails as $floor){
		if($floor['vacancy_info'] == 1 && $floor['move_in_date'] == '即'){
			$wantedFloor100to300[] = $floor['floor_id'];
			$totalOfVacantFloor100to300 += $floor['area_ping'];
		}
		$floor100to300[] = $floor;
		$totalFloors100to300  += $floor['area_ping'];
	}
}

$flootAvarageRent100to300 = array();
$flootRent100to300 = array();
foreach($floor100to300 as $floor){
	if($floor['rent_unit_price'] != "" && $floor['unit_condo_fee'] != ""){
		$flootAvarageRent100to300[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
	}elseif($floor['rent_unit_price'] != "" && $floor['unit_condo_fee_opt'] == "-3"){
		$flootAvarageRent100to300[] = $floor['rent_unit_price'];
	}
	if($floor['rent_unit_price'] != ""){
		$flootRent100to300[] = $floor['rent_unit_price'];
	}
}
if(count($flootAvarageRent100to300) > 0){
	$avarageSum100to300 = array_sum($flootAvarageRent100to300)/count($flootAvarageRent100to300);
	$lowest100to300 = count($flootRent100to300) > 0 ? min($flootRent100to300) : 0;
	$highest100to300 = count($flootRent100to300) > 0 ? max($flootRent100to300) : 0;
}else{
	$avarageSum100to300 = 0;
	$lowest100to300 = 0;
	$highest100to300 = 0;
}

/************************* end ******************************/

/******************** calc avarage for greater 300 ****************/
$vacancyRateGreater300 = Building::model()->findAll('address Like "%'.$areaName.'%" AND (std_floor_space >= 300 OR std_floor_space = "")');

$buildingGreater300 = array();
foreach($vacancyRateGreater300 as $buildingDetails){
	if($buildingDetails['std_floor_space'] == ""){
		$checkEmptyBuildingSpace = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
		$arrayFloor300 = array();
		foreach($checkEmptyBuildingSpace as $floor){
			$arrayFloor300[] = $floor['area_ping'];
		}
		if(count($arrayFloor300) > 0){
			if(max($arrayFloor300) >= 300){
				$buildingGreater300[] = $buildingDetails['building_id'];
			}
		}
	}else{
		$buildingGreater300[] = $buildingDetails['building_id'];
	}
}

$floorGreater300 = array();
$wantedFloorGreater300 = array();

$totalOfVacantFloorgrt300  = '';
$totalFloorsgrt300  = '';
foreach($buildingGreater300 as $building){
	$floorDetails = Floor::model()->findAll('building_id = '.$building);
	foreach($floorDetails as $floor){
		if($floor['vacancy_info'] == 1 && $floor['move_in_date'] == '即'){
			$wantedFloorGreater300[] = $floor['floor_id'];
			$totalOfVacantFloorgrt300 += $floor['area_ping'];
		}
		$floorGreater300[] = $floor;
		$totalFloorsgrt300  += $floor['area_ping'];
	}
}

/*echo "<pre>";
print_r($totalOfVacantFloorgrt300);
print_r($wantedFloorGreater300);
die;*/

/*$totalOfVacantFloorgrt300  = '';
foreach($wantedFloorGreater300 as $wantg300){
	$floorDetails = Floor::model()->findAllbyPk($wantg300);
	foreach($floorDetails as $fd){
		$totalOfVacantFloorgrt300 = $totalOfVacantFloorgrt300  + $fd['area_ping'];
	}
}*/


$flootAvarageRentGreater300 = array();
$flootRentGreater300 = array();
//$totalFloorsgrt300  = '';
foreach($floorGreater300 as $floor){
	//$totalFloorsgrt300  = $totalFloorsgrt300 + $floor['area_ping'];
	if($floor['rent_unit_price'] != "" && $floor['unit_condo_fee'] != ""){
		$flootAvarageRentGreater300[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
	}elseif($floor['rent_unit_price'] != "" && $floor['unit_condo_fee_opt'] == "-3"){
		$flootAvarageRentGreater300[] = $floor['rent_unit_price'];
	}
	if($floor['rent_unit_price'] != ""){
		$flootRentGreater300[] = $floor['rent_unit_price'];
	}
}

if(count($flootAvarageRentGreater300) > 0){
	$avarageSumGreater300 = array_sum($flootAvarageRentGreater300)/count($flootAvarageRentGreater300);
	$lowestGreater300 =  count($flootRentGreater300) > 0 ? min($flootRentGreater300) : 0;
	$highestGreater300 = count($flootRentGreater300) > 0 ? max($flootRentGreater300) : 0;
}else{
	$avarageSumGreater300 = 0;
	$lowestGreater300 = 0;
	$highestGreater300 = 0;
}

/************************* end ******************************/
$avgGraph = array($avarageSum50,$avarageSum50to100,$avarageSum100to300,$avarageSumGreater300);
$maxRate = max($avgGraph);

$rateGraph = array($highest50,$highest50to100,$highest100to300,$highestGreater300);
$maxRateVal = max($rateGraph);
?>

<div id="main" class="full-width single-district">
	<div class="postbox">
    	<header class="m-title btnright">
        	<h1 class="main-title"><?php echo Yii::app()->controller->__trans('Area Info'); ?></h1>
            <a class="btnPrintOut printSingleArea" href="">
               	<i class="fa fa-print" aria-hidden="true"></i><?php echo Yii::app()->controller->__trans('PRINT OUT'); ?>
            </a>
        </header>
        <div class="area-box">
        	<h3><?php echo $districtName; ?> のエリア</h3>
            <ul class="area_list">
			<?php
			$buildingDetails = Building::model()->findAll();
			$addressArray = array();
			foreach($buildingDetails as $building){
				$addressArray[] = $building['address'];
			}

			$finalTownArray = array();
			$finalTownIdArray = array();
			foreach($townArray as $town){
				foreach($addressArray as $addr){
					if(strpos($addr,$town['name']) !== false){
						$finalTownArray[] = $town['name'];
						$finalTownIdArray[] = $town['id'];
					}
				}
			}

			$finalTown = array_unique($finalTownArray);
			$finalTown = array_values($finalTown);

			$finalTownId = array_unique($finalTownIdArray);
			$finalTownId = array_values($finalTownId);

			$townList = array();
			$i = 0;

			foreach($finalTown as $town){
				$townList[] = array('id'=>$finalTownId[$i],'name'=>$town);
				$i++;
			}

            if(isset($townList) && !empty($townList) && count($townList) > 0){
				foreach($townList as $town){
					if(str_replace('.','',$areaId) == str_replace('.','',$town['id'])){
			?>
            	<li>
                	<?php echo $town['name']; ?>
                </li>
			<?php
					}else{
			?>
            	<li>
                	<a href="<?php echo Yii::app()->createUrl('marketInfo/areaView',array('name'=>$districtName,'district'=>$districtId,'area'=>$town['id'])); ?>" title="<?php echo $town['name']; ?>"><?php echo $town['name']; ?></a>
                </li>
            <?php
					}
            	}
			}
			?>
           </ul>
        </div>
        <div class="area-info">
        	<h3><?php echo $areaName; ?> エリア
            	<a href="#" class="edit-links edit-links-areaDiscription"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            </h3>
            <p class="text dispAreaDiscription">
            	<?php echo $areaDiscription; ?>
            </p>
            <div class='editAreaDiscription' style="display:none;">
            	<textarea name="areaDiscription" id="areaDiscription" rows="3" style="resize:none;" class="areaDiscription"><?php echo $areaDiscription; ?></textarea>

                <button type="button" name="btnSaveAreaDiscription" id="btnSaveAreaDiscription" class="btnSaveAreaDiscription btnSaveMarketInfo">Save</button>
            </div>
        </div>
        <div class="area-info">
        	<h3><?php echo $areaName; ?>エリアの賃貸オフィス（貸事務所）空室相場</h3>
            <table>
            	<tbody>
                	<tr>
                    	<th rowspan="2">種別</th>
                        <th rowspan="2" width="200">平均賃料<br>（共益費管理費含む）</th>
                        <th width="200">最高賃料</th>
                        <th rowspan="2">募集件数</th>
                        <th rowspan="2">潜在空室率</th>
                    </tr>
                    <tr>
                    	<th>最低賃料</th>
                    </tr>
                    <?php /*?><tr>
                    	<td>50坪以下</td>
                        <td>
                        	<?php
							if($maxRate == "" || $maxRate == 0){
								$avgRateGraph = 0;
							}else{
								$avgRateGraph = ($avarageSum50*100)/$maxRate;
								$avarageSum50 = $avarageSum50/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $avgRateGraph; ?>%">&nbsp;</div>
                            <span><?php echo number_format($avarageSum50,2,'.',''); ?>万円</span>
                        </td>
                        <td>
                        	<?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$graphForRate = ($highest50*100)/$maxRateVal;
								$highest50 = $highest50/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($highest50,2,'.',''); ?>万円</span>
                            <?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$graphForRate = ($lowest50*100)/$maxRateVal;
								$lowest50 = $lowest50/10000;
							}
							?>
                            <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($lowest50,2,'.',''); ?>万円</span>
                        </td>
                        <td><?php echo count($wantedFloor50); ?></td>
                         <td><?php if($totalOfVacantFloor != '' && $totalFloors != ''){  
									echo number_format($totalOfVacantFloor/$totalFloors,2,'.',''); 
								}
							?>
                       </td>
                    </tr><?php */?>
                    <tr>
                    	<td>50～100坪</td>
                        <td>
                        	<?php
							if($maxRate == "" || $maxRate == 0){
								$avgRateGraph = 0;
							}else{
								$avarageSum50to100 = $avarageSum50to100/10000;
								$avgRateGraph = ($avarageSum50to100*10);
							}
							?>
                        	<div class="graph" style="width:<?php echo $avgRateGraph; ?>%">&nbsp;</div>
                            <span><?php echo number_format($avarageSum50to100,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td>
                        	<?php
							if($maxRateVa == "" || $maxRateVa == 0){
								$graphForRate = 0;
							}else{
								$graphForRate = ($highest50to100*100)/$maxRateVal;
								$highest50to100 = $highest50to100/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($highest50to100,2,'.',''); ?>万円/坪</span>
                            <?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$lowest50to100 = $lowest50to100/10000;
								$graphForRate = ($lowest50to100*10);
							}
							?>
                            <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($lowest50to100,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td><?php echo count($wantedFloor50to100); ?></td>
                        <td><?php
								if($totalOfVacantFloor50to100 != '' && $totalFloors50to100 != ''){ 
									echo number_format($totalOfVacantFloor50to100/$totalFloors50to100,2,'.','')*(100)." %";
								}else{
									echo "0 %";
								}
								?>
                        </td>
                    </tr>
                    <tr>
                    	<td>100～300坪</td>
                        <td>
                        	<?php
							if($maxRate == "" || $maxRate == 0){
								$avgRateGraph = 0;
							}else{
								$avarageSum100to300 = $avarageSum100to300/10000;
								$avgRateGraph = ($avarageSum100to300*10);
							}
							?>
                        	<div class="graph" style="width:<?php echo $avgRateGraph; ?>%">&nbsp;</div>
                            <span><?php echo number_format($avarageSum100to300,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td>
                        	<?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$highest100to300 = $highest100to300/10000;
								$graphForRate = ($highest100to300*10);
							}
							?>
                        	<div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($highest100to300,2,'.',''); ?>万円/坪</span>
                            <?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$lowest100to300 = $lowest100to300/10000;
								$graphForRate = ($lowest100to300*10);
							}
							?>
                            <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($lowest100to300,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td><?php echo count($wantedFloor100to300); ?></td>
                        <td><?php
								if($totalOfVacantFloor100to300 != '' && $totalFloors100to300 != ''){
							 		echo number_format($totalOfVacantFloor100to300/$totalFloors100to300,2,'.','')*(100)." %";
								}else{
									echo "0 %";
								}
								?>
                       </td>
                    </tr>
                    <tr>
                    	<td>300坪以上</td>
                        <td>
                        	<?php
							if($maxRate == "" || $maxRate == 0){
								$avgRateGraph = 0;
							}else{
								$avarageSumGreater300 = $avarageSumGreater300/10000;
								$avgRateGraph = ($avarageSumGreater300*10);
							}
							?>
                        	<div class="graph" style="width:<?php echo $avgRateGraph; ?>%">&nbsp;</div>
                            <span><?php echo number_format($avarageSumGreater300,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td>
                        	<?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$highestGreater300 = $highestGreater300/10000;
								$graphForRate = ($highestGreater300*10);
							}
							?>
                        	<div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($highestGreater300,2,'.',''); ?>万円/坪</span>
                            <?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$lowestGreater300 = $lowestGreater300/10000;
								$graphForRate = ($lowestGreater300*10);
							}
							?>
                            <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($lowestGreater300,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td><?php echo count($wantedFloorGreater300); ?></td>
                        <td>
						  <?php
								if($totalOfVacantFloorgrt300 != '' && $totalOfVacantFloorgrt300 != ''){
						 			echo number_format($totalOfVacantFloorgrt300/$totalFloorsgrt300,2,'.','')*(100)." %";
						  }else{
						  	echo "0 %";
						  }
						  ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="area-info">
        	<h3>オフィス相場概要
            	<a href="#" class="edit-links edit-links-areaSummary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            </h3>
            <p class="text dispAreaSummary">
            	<?php echo $areaSummary; ?>
            </p>
            <div class='editAreaSummary' style="display:none;">
            	<textarea name="areaSummary" id="areaSummary" rows="3" style="resize:none;" class="areaSummary"><?php echo $areaSummary; ?></textarea>

                <button type="button" name="btnSaveAreaSummary" id="btnSaveAreaSummary" class="btnSaveAreaSummary btnSaveMarketInfo">Save</button>
            </div>
            <p>&nbsp;</p>
        </div>

        <div class="area-info">
        	<h3>このエリアの風景
            	<a href="#" class="edit-links edit-links-areaLandscape">
                	<i class="fa fa-upload" aria-hidden="true"></i>
                </a>
            </h3><!--fixed title-->
            <!--images for sight of towns of the district CAN BE ADDED-->
            <!--if there is no images yet-->
            <p class="text landscapeText">
            	<?php
					if(!is_array($areaLandscape)){
						echo $areaLandscape;
					}
				?>
            </p>
            <ul class="sight-image">
			<?php
            if(isset($areaLandscape) && count($areaLandscape) > 0 && !empty($areaLandscape) && is_array($areaLandscape)){
                $images_path = Yii::app()->baseUrl . '/areaLandscape/';
                foreach($areaLandscape as $landscape){
            ?>
            <li>
                <a class="lightbox">
                    <img src="<?php echo $images_path.$landscape; ?>"/>
                </a>
            </li>
            <?php
                }
            }
            ?>
            </ul>
        </div><!--/area info-->

        <div class="area-info half">
        	<h3>同等相場エリア</h3><!--fixed title-->
            <!--show here 10 lists of towns which are closed to average price per 1 tsubo-->
            <ul class="related-list">
            	<?php
				$districtDetails = District::model()->find('code = "'.$districtId.'"');
				$prefectureCode = $districtDetails->prefecture_id;
				
				$prefectureDetails = Prefecture::model()->find('code = "'.$prefectureCode.'"');
				$pName = $prefectureDetails->prefecture_name;
				
				$plus = '+1000';
				$minus = '-1000';
				
				//50 to 100
				$plus50to100 = $avarageSum50to100.$plus;
				$plus50to100 = $plus50to100 / 10000;
				
				$minus50to100 = $avarageSum50to100.$minus;
				$minus50to100 = $minus50to100 / 10000;
				
				//100 to 300
				$plus100to300 = $avarageSum100to300.$plus;
				$plus100to300 = $plus100to300 / 10000;
				
				$minus100to300 = $avarageSum100to300.$minus;
				$minus100to300 = $minus100to300 / 10000;
				
				//above 300
				$plus300Above = $avarageSumGreater300.$plus;
				$plus300Above = $plus300Above / 10000;
				
				$minus300Above = $avarageSumGreater300.$minus;
				$minus300Above = $minus300Above / 10000;
				
				$query = 'select * from market_equivalent_town where prefecture_name LIKE "%'.$pName.'%" AND f_h_range BETWEEN '.$minus50to100.' AND '.$plus50to100.' AND h_t_range BETWEEN '.$minus100to300.' AND '.$plus100to300.' AND t_above_range BETWEEN '.$minus300Above.' AND '.$plus300Above.' ORDER BY market_equivalent_town_id DESC LIMIT 10';
				
				$marketCloseTownList = Yii::app()->db->createCommand($query)->queryAll();
				?>
                <?php
				if(isset($marketCloseTownList) && count($marketCloseTownList) > 0){
					foreach($marketCloseTownList as $mTown){
						$townDetails = Town::model()->find('town_name LIKE "%'.$mTown['town_name'].'%"');
						if(count($townDetails) > 0){
							$tName = $townDetails->town_name;
							$tCode = $townDetails->code;
							$dCode = $townDetails->district_id;
							$url = Yii::app()->createUrl('marketInfo/areaView',array('name'=>$tName,'district'=>$dCode,'area'=>$tCode));
						}else{
							$tName = '同等相場のエリアがありません';
							$url = '#';
						}
				?>
                		<li><a href="<?php echo $url; ?>"><?php echo $tName; ?></a></li>
                <?php
					}
				}else{
				?>
                		<li>同等相場のエリアがありません</li>
                <?php
				}
				?>
            </ul>
        </div>
        <div class="area-info half right">
        	<h3>近隣エリア</h3><!--fixed title-->
            <!--show here 10 lists of neighborhood towns-->
            <ul class="related-list">
            	<?php
				$townDetails = Town::model()->findAll('district_id = "'.$districtId.'" LIMIT 10');
				if(isset($townDetails) && count($townDetails) > 0){
					foreach($townDetails as $nTown){
						$tName = $nTown->town_name;
						$tCode = $nTown->code;
						$dCode = $nTown->district_id;
						$url = Yii::app()->createUrl('marketInfo/areaView',array('name'=>$tName,'district'=>$dCode,'area'=>$tCode));
				?>
                		<li><a href="<?php echo $url; ?>"><?php echo $tName; ?></a></li>
                <?php
					}
				}else{
				?>
                		<li><a href="#">利用可能な町いいえ</a></li>
                <?php
				}
				?>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>

<!--Modal Popup for area landscape Upload-->
<div class="modal-box hide" id="modalUploadAreaLandscape">
	<div class="content transmissionContent">
    	<div class="box-header">
        	<h2 class="popup-label">Upload Picture</h2>
            <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>

        <div class="box-content">
        	<form id="frmUpAreaLandscape" method="post" class="frmUpAreaLandscape uploadPictures" data-action="<?php echo Yii::app()->createUrl('marketInfo/uploadAreaLandscape'); ?>" enctype="multipart/form-data">
            	<div id="dropLandscape" class="drop">
                	Drop Here<a>Browse</a>
                    <input type="file" name="areaLandscape" multiple />
                </div>
                <ul><!-- The file uploads will be shown here --></ul>
                <table class="tblUploadPicture">
                	<tr>
                    	<td>
                        	<input type="hidden" name="hdnLandscapeFile" id="hdnLandscapeFile" class="hdnLandscapeFile" value="0"/>
                            <button type="button" class="btnUpAreaLandscape">Upload</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>