<input type="hidden" name="hdnDisctrict" id="hdnDisctrict" class="hdnDisctrict" value="<?php echo $districtId; ?>" />
<?php
$summary = $areaCommentary = $marketTrends = $newalyAdd = $finalList = $areaPicture = 'No Data Available';
$districtMarketDetails = MarketInfo::model()->find('district_id = '.$districtId);
if(isset($districtMarketDetails) && count($districtMarketDetails) > 0 && !empty($districtMarketDetails)){
	$summary = $districtMarketDetails['market_summary'];
	$areaCommentary = $districtMarketDetails['area_commentary'];
	$marketTrends = $districtMarketDetails['office_market_trends'];
	$newalyAdd = $districtMarketDetails['newly_developed'];
	$areaPicture = $districtMarketDetails['market_area_picture'];
	if($areaPicture != ""){
		$areaPicture = explode(',',$areaPicture);
	}else{
		$areaPicture = array();
	}
	$addedList = explode(',',$newalyAdd);
	$finalList = '';
	if(isset($addedList) && count($addedList) > 0 && !empty($addedList)){
		$i = 0;
		foreach($addedList as $list){
			if($i == 0){
				$finalList = '<li data-value="'.$list.'">'.$list.' <i class="fa fa-trash-o removeNewlyAdd"></i></li>';
			}else{
				$finalList .= '<li data-value="'.$list.'">'.$list.' <i class="fa fa-trash-o removeNewlyAdd"></i></li>';
			}
			$i++;
		}
	}
}

/************************* calc avarage for less 50 ******************/

$vacancyRateLess50 = Building::model()->findAll('address Like "%'.$districtName.'%" AND (std_floor_space <= 50 OR std_floor_space = "")');
$building50 = array();
foreach($vacancyRateLess50 as $buildingDetails){
	//$building50[] = $buildingDetails['building_id'];
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

$totalOfVacantFloor = '';
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

//$vacancyRate50to100 = Building::model()->findAll('address Like "%'.$districtName.'%"');
$vacancyRate50to100 = Building::model()->findAll('address Like "%'.$districtName.'%" AND (std_floor_space BETWEEN 50 AND 100 OR std_floor_space = "")');
$building50to100 = array();
//$i = 0;
foreach($vacancyRate50to100 as $buildingDetails){
	//$building50to100[] = $buildingDetails['building_id'];
	if($buildingDetails['std_floor_space'] == ""){
		$checkEmptyBuildingSpace = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);		
		$arrayFloor50To100 = array();
		//echo "Loop = ".$i."<br/>";
		foreach($checkEmptyBuildingSpace as $floor){			
			//echo "Area Ping = ".$floor['area_ping']."<br/>";
			$arrayFloor50To100[] = $floor['area_ping'];
		}
		//echo "Max = ".max($arrayFloor50To100)."<br/>";
		//echo "-------------------------- <br/>";
		if(count($arrayFloor50To100) > 0){
			if(max($arrayFloor50To100) > 50 && max($arrayFloor50To100) < 100){
				$building50to100[] = $buildingDetails['building_id'];
			}
		}
	}else{
		$building50to100[] = $buildingDetails['building_id'];
	}
	$i++;
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
//$vacancyRate100to300 = Building::model()->findAll('address Like "%'.$districtName.'%"');
$vacancyRate100to300 = Building::model()->findAll('address Like "%'.$districtName.'%" AND (std_floor_space BETWEEN 100 AND 300 OR std_floor_space = "")');
$building100to300 = array();
foreach($vacancyRate100to300 as $buildingDetails){
	//$building100to300[] = $buildingDetails['building_id'];
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
//$vacancyRateGreater300 = Building::model()->findAll('address Like "%'.$districtName.'%"');
$vacancyRateGreater300 = Building::model()->findAll('address Like "%'.$districtName.'%" AND (std_floor_space >= 300 OR std_floor_space = "")');

$buildingGreater300 = array();
foreach($vacancyRateGreater300 as $buildingDetails){
	//$buildingGreater300[] = $buildingDetails['building_id'];
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
	//$floorDetails = Floor::model()->findAll('building_id = '.$building.'  AND `area_ping` >= 300');
	$floorDetails = Floor::model()->findAll('building_id = '.$building);
	foreach($floorDetails as $floor){
		if($floor['vacancy_info'] == 1 && $floor['move_in_date'] == '即'){
			$wantedFloorGreater300[] = $floor['floor_id'];
			$totalOfVacantFloorgrt300 = $totalOfVacantFloorgrt300  + $floor['area_ping'];
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
            <form id="singleDistrict" class="singleDistrict">
            	<input type="hidden" name="hdnDisctrictId" id="hdnDisctrictId" class="hdnDisctrictId" value="<?php echo $districtId; ?>"/>
                <input type="hidden" name="hdnDisctrictName" id="hdnDisctrictName" class="hdnDisctrictName" value="<?php echo  $districtName; ?>"/>
                <a class="printoutsingle" href="#">
                	<i class="fa fa-print" aria-hidden="true"></i><?php echo Yii::app()->controller->__trans('PRINT OUT'); ?>
                </a>
			</form>
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
			?>
            	<li>
                	<a href="<?php echo Yii::app()->createUrl('marketInfo/areaView',array('name'=>$districtName,'district'=>$districtId,'area'=>$town['id'])); ?>" title="<?php echo $town['name']; ?>"><?php echo $town['name']; ?></a>
                </li>
			<?php
            		}
				}
			?>
            </ul>
        </div>
        <div class="area-info">
        	<h3><?php echo $districtName; ?> の賃貸オフィス（貸事務所）空室相場</h3>
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
                        <span><?php echo number_format($avarageSum50,1,'.',''); ?>万円</span>
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
                        <span><?php echo number_format($highest50,1,'.',''); ?>万円</span>
                        <?php
						if($maxRateVal == "" || $maxRateVal == 0){
							$graphForRate = 0;
						}else{
							$graphForRate = ($lowest50*100)/$maxRateVal;
							$lowest50 = $lowest50/10000;
						}
						?>
                        <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                        <span><?php echo number_format($lowest50,1,'.',''); ?>万円</span>
                        </td>
                        <td><?php echo count($wantedFloor50); ?></td>
                         <td>
						 	<?php
                         		if($totalOfVacantFloor != '' && $totalFloors != ''){
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
                            <span><?php echo number_format($avarageSum50to100,1,'.',''); ?>万円/坪</span>
                        </td>
                        <td>
							<?php
								if($maxRateVal == "" || $maxRateVal == 0){
									$graphForRate = 0;
								}else{
									$graphForRate = ($highest50to100*100)/$maxRateVal;
									$highest50to100 = $highest50to100/10000;
								}
                            ?>
                            <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($highest50to100,1,'.',''); ?>万円/坪</span>
                            <?php
								if($maxRateVal == "" || $maxRateVal == 0){
									$graphForRate = 0;
								}else{
									$graphForRate = ($lowest50to100*100)/$maxRateVal;
									$lowest50to100 = $lowest50to100/10000;
								}
                            ?>
                        <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                        <span><?php echo number_format($lowest50to100,1,'.',''); ?>万円/坪</span>
                        </td>
                        <td><?php echo count($wantedFloor50to100); ?></td>
                        <td><?php
								if($totalOfVacantFloor50to100 != '' && $totalFloors50to100 != ''){
									echo number_format($totalOfVacantFloor50to100/$totalFloors50to100,2,'.','')*(100)." %";
								}else{
									echo "0 %";
								}?>
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
                        <span><?php echo number_format($avarageSum100to300,1,'.',''); ?>万円/坪</span>
                        </td>
                        <td>
                        <?php
						if($maxRateVal == "" || $maxRateVal == 0){
							$graphForRate = 0;
						}else{
							$graphForRate = ($highest100to300*100)/$maxRateVal;
							$highest100to300 = $highest100to300/10000;
						}
						?>
                        <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                        <span><?php echo number_format($highest100to300,1,'.',''); ?>万円/坪</span>
                        <?php
						if($maxRateVal == "" || $maxRateVal == 0){
							$graphForRate = 0;
						}else{
							$graphForRate = ($lowest100to300*100)/$maxRateVal;
							$lowest100to300 = $lowest100to300/10000;
						}
						?>
                        <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                        <span><?php echo number_format($lowest100to300,1,'.',''); ?>万円/坪</span>
                        </td>
                        <td><?php echo count($wantedFloor100to300); ?></td>
                         <td><?php
								if($totalOfVacantFloor100to300 != '' && $totalFloors100to300 != ''){
							 		echo number_format($totalOfVacantFloor100to300/$totalFloors100to300,1,'.','')*(100)." %"; 
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
								
								//echo "Graph = ".$avgRateGraph;
								//echo "<br/> AVG = ".$avarageSumGreater300/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $avgRateGraph; ?>%">&nbsp;</div>
                            <?php /*?><span><?php echo number_format($avarageSumGreater300,1,'.',''); ?>万円/坪</span><?php */?>
                            <span><?php echo $avarageSumGreater300; ?>万円/坪</span>
                        </td>
                        <td>
                        	<?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$graphForRate = ($highestGreater300*100)/$maxRateVal;
								$highestGreater300 = $highestGreater300/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <?php /*?><span><?php echo number_format($highestGreater300,1,'.',''); ?>万円/坪</span><?php */?>
                            <span><?php echo $highestGreater300; ?>万円/坪</span>
                            <?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$graphForRate = ($lowestGreater300*100)/$maxRateVal;
								$lowestGreater300 = $lowestGreater300/10000;
							}
							?>
                            <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <?php /*?><span><?php echo number_format($lowestGreater300,1,'.',''); ?>万円/坪</span><?php */?>
                            <span><?php echo $lowestGreater300; ?>万円/坪</span>
                        </td>
                        <td><?php echo count($wantedFloorGreater300); ?></td>
                          <td>
						  <?php
								if($totalOfVacantFloorgrt300 != '' && $totalFloorsgrt300 != ''){
						 			echo number_format($totalOfVacantFloorgrt300/$totalFloorsgrt300,1,'.','')*(100)." %";;
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
            	<a href="#" class="edit-links edit-link-summary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            </h3>
            <p class="text dispSummary">
            	<?php echo $summary; ?>
            </p>
            <div class='editSummary' style="display:none;">
            	<textarea name="summary" id="summary" rows="3" style="resize:none;" class="summary"><?php echo $summary; ?></textarea>
                <button type="button" name="btnSaveSummary" id="btnSaveSummary" class="btnSaveSummary btnSaveMarketInfo">Save</button>
            </div>
        </div>
        <div class="area-info">
        	<h3>エリア解説
            	<a href="#" class="edit-links edit-links-areaCommentary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            </h3>
            <p class="text dispAreaCommentary">
            	<?php echo $areaCommentary; ?>
            </p>
            <div class='editAreaCommentary' style="display:none;">
            	<textarea name="areaCommentary" id="areaCommentary" rows="3" style="resize:none;" class="areaCommentary"><?php echo $areaCommentary; ?></textarea>
                <button type="button" name="btnSaveAreaCommentary" id="btnSaveAreaCommentary" class="btnSaveAreaCommentary btnSaveMarketInfo">Save</button>
            </div>
        </div>
        <div class="area-info half">
        	<h3>今後のオフィス相場動向
            	<a href="#" class="edit-links edit-links-marketTrends"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            </h3>
            <p class="text dispMarketTrends">
            	<?php echo $marketTrends; ?>
            </p>
            <div class='editMarketTrends' style="display:none;">
            	<textarea name="marketTrends" id="marketTrends" rows="3" style="resize:none;" class="marketTrends"><?php echo $marketTrends; ?></textarea>
                <button type="button" name="btnSaveMarketTrends" id="btnSaveMarketTrends" class="btnSaveMarketTrends btnSaveMarketInfo">Save</button>
            </div>
        </div>
        <div class="area-info half right">
        	<h3>新開発オフィスビル
            	<a href="#" class="edit-links edit-links-newlyAdded"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            </h3>
            <dl class="new_bild divNewlyAdd">
            	<?php echo $finalList; ?>
            </dl>
            <div class='editNewBild' style="display:none;">
            	<input type="text" name="newlyAdd" id="newlyAdd" class="newlyAdd" value="" autocomplete="off"/>
                <button type="button" name="btnSaveNewlyAdd" id="btnSaveNewlyAdd" class="btnSaveNewlyAdd btnSaveMarketInfo">Save</button>
            </div>
        </div>
        <div class="clear"></div>
        <div class="area-info">
        	<h3>このエリアの風景
            	<a href="#" class="edit-links edit-links-areaPicture">
                	<i class="fa fa-upload" aria-hidden="true"></i>
                </a>
            </h3><!--fixed title-->
            <!--images for sight of towns of the district CAN BE ADDED-->
            <!--if there is no images yet-->
            <p class="text landscapeText">
            	<?php
					if(!is_array($areaPicture)){
						echo $areaPicture;
					}
				?>
            </p>
            <?php
            if(isset($areaPicture) && count($areaPicture) > 0 && !empty($areaPicture) && is_array($areaPicture)){
                $images_path = Yii::app()->baseUrl . '/marketAreaPicture/';
            ?>
            <ul class="sight-image">	
            <?php
				foreach($areaPicture as $picture){
            ?>
            		
                <li style="position:relative;" data-value="<?php echo $picture; ?>" class="liImages">
                    <a class="lightbox">
                        <img src="<?php echo $images_path.$picture; ?>"/>
                        <div class="btnRemvImg">
                        	<i class="fa fa-times" style="font-size: 18px;"></i>
                       	</div>
                    </a>
                </li>            
            <?php
                }
			?>
            </ul>
            <?php
            }else{
			?>
            <p class="text landscapeText">No Data Available</p>
            <?php
			}
            ?>
        </div>
    </div>
</div>


<!--Modal Popup for area landscape Upload-->
<div class="modal-box hide" id="modalUploadAreaPicture">
	<div class="content transmissionContent">
    	<div class="box-header">
        	<h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Upload Picture'); ?></h2>
            <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>
        <div class="box-content">
        	<form id="frmUpAreaPicture" method="post" class="frmUpAreaPicture uploadPictures" data-action="<?php echo Yii::app()->createUrl('marketInfo/uploadAreaPicture'); ?>" enctype="multipart/form-data">
            	<div id="dropAreaPicture" class="drop">
                	<?php echo Yii::app()->controller->__trans('Drop Here'); ?><a><?php echo Yii::app()->controller->__trans('Browse'); ?></a>
                    <input type="file" name="areaPicture" multiple />
                </div>
                <ul><!-- The file uploads will be shown here --></ul>
                <table class="tblUploadPicture">
                	<tr>
                    	<td>
                        	<input type="hidden" name="hdnAreaPictureFile" id="hdnAreaPictureFile" class="hdnAreaPictureFile" value="0"/>
                            <button type="button" class="btnUpAreaPicture"><?php echo Yii::app()->controller->__trans('Upload'); ?></button>
                       	</td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>