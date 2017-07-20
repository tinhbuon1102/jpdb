<?php
$specificDistrict = array('港区','千代田区','中央区','渋谷区','新宿区','品川区','江東区'); 

/************************* calc avarage for less 50 ******************/
$vacancyRateLess50 = array();
$building50 = array();
foreach($specificDistrict as $specific){
	$vacancyRateLess50 = Building::model()->findAll('address Like "%'.$specific.'%" AND std_floor_space <= 50');
	foreach($vacancyRateLess50 as $buildingDetails){
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
	$flootAvarageRent50[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
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
$building50to100 = array();
$vacancyRate50to100 = array();
foreach($specificDistrict as $specific){
	//$vacancyRate50to100 = Building::model()->findAll('address Like "%'.$specific.'%"');
	$vacancyRate50to100 = Building::model()->findAll('address Like "%'.$specific.'%" AND (std_floor_space BETWEEN 50 AND 100 OR std_floor_space = "")');
	
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
		//$building50to100[] = $buildingDetails['building_id'];
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
$building100to300 = array();
$vacancyRate100to300 = array();
foreach($specificDistrict as $specific){
	//$vacancyRate100to300 = Building::model()->findAll('address Like "%'.$specific.'%"');
	$vacancyRate100to300 = Building::model()->findAll('address Like "%'.$specific.'%" AND (std_floor_space BETWEEN 100 AND 300 OR std_floor_space = "")');
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
		//$building100to300[] = $buildingDetails['building_id'];
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
$buildingGreater300 = array();
$vacancyRateGreater300 = array();
foreach($specificDistrict as $specific){
	//$vacancyRateGreater300 = Building::model()->findAll('address Like "%'.$specific.'%"');
	$vacancyRateGreater300 = Building::model()->findAll('address Like "%'.$specific.'%" AND (std_floor_space >= 300 OR std_floor_space = "")');
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
		//$buildingGreater300[] = $buildingDetails['building_id'];
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
		$totalFloorsgrt300 += $floor['area_ping'];
	}
}
$flootAvarageRentGreater300 = array();
$flootRentGreater300 = array();
foreach($floorGreater300 as $floor){
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
            <a class="printout" href="#">
               	<i class="fa fa-print" aria-hidden="true"></i><?php echo Yii::app()->controller->__trans('PRINT OUT'); ?>
            </a>
        </header>
        <div class="area-info">
        	<h3>主要7区 の賃貸オフィス（貸事務所）空室相場</h3>
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
                        	<div class="graph" style="width:<?php echo round($avgRateGraph); ?>%">&nbsp;</div>

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
									echo number_format($totalOfVacantFloor/$totalFloors,2,'.','')*(100)." %"; 
								}else{
									echo "0 %";
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
								$avgRateGraph = ($avarageSum50to100*100)/$maxRate;
								$avarageSum50to100 = $avarageSum50to100/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $avgRateGraph; ?>%">&nbsp;</div>
                            <span><?php echo number_format($avarageSum50to100,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td>
                        	<?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
								$highest50to100 = $highest50to100/10000;
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
								$graphForRate = ($lowest50to100*100)/$maxRateVal;
								$lowest50to100 = $lowest50to100/10000;
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
								$avgRateGraph = ($avarageSum100to300*100)/$maxRate;
								$avarageSum100to300 = $avarageSum100to300/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $avgRateGraph; ?>%">&nbsp;</div>
                            <span><?php echo number_format($avarageSum100to300,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td>
                        	<?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
								$highest100to300 = $highest100to300/10000;
							}else{
								$graphForRate = ($highest100to300*100)/$maxRateVal;
								$highest100to300 = $highest100to300/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($highest100to300,2,'.',''); ?>万円/坪</span>
                            <?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$graphForRate = ($lowest100to300*100)/$maxRateVal;
								$lowest100to300 = $lowest100to300/10000;
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
								$avgRateGraph = ($avarageSumGreater300*100)/$maxRate;
								$avarageSumGreater300 = $avarageSumGreater300/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $avgRateGraph; ?>%">&nbsp;</div>
                            <span><?php echo number_format($avarageSumGreater300,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td>
                        	<?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
								$highestGreater300 = $highestGreater300/10000;
							}else{
								$graphForRate = ($highestGreater300*100)/$maxRateVal;
								$highestGreater300 = $highestGreater300/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($highestGreater300,2,'.',''); ?>万円/坪</span>
                            <?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$graphForRate = ($lowestGreater300*100)/$maxRateVal;
								$lowestGreater300 = $lowestGreater300/10000;
							}
							?>
                            <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($lowestGreater300,2,'.',''); ?>万円/坪</span>
                        </td>
                        <td><?php echo count($wantedFloorGreater300); ?></td>
                        <td><?php
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
       <div class="clear"></div>
    </div>
</div>