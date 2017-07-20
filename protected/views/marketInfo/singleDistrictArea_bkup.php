<input type="hidden" name="hdnDisctrict" id="hdnDisctrict" class="hdnDisctrict" value="<?php echo $districtId; ?>" />
<input type="hidden" name="hdnTown" id="hdnTown" class="hdnTown" value="<?php echo $areaId; ?>" />
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
$vacancyRateLess50 = Building::model()->findAll('address Like "%'.$areaName.'%" AND total_floor_space <= 50');
$building50 = array();
foreach($vacancyRateLess50 as $buildingDetails){
	$building50[] = $buildingDetails['building_id'];
}
$floor50 = array();
$wantedFloor50 = array();
foreach($building50 as $building){
	$floorDetails = Floor::model()->findAll('building_id = '.$building);
	foreach($floorDetails as $floor){
		if($floor['vacancy_info'] == 1){
			$wantedFloor50[] = $floor['floor_id'];
		}
		$floor50[] = $floor;
	}
}

$totalOfVacantFloor  = '';
foreach($wantedFloor50 as $want50){
	$floorDetails = Floor::model()->findAllbyPk($want50);
	foreach($floorDetails as $fd){
		$totalOfVacantFloor = $totalOfVacantFloor  + $fd['area_ping'];
	}
}

$flootAvarageRent50 = array();
$flootRent50 = array();
$totalFloors  = '';
foreach($floor50 as $floor){
	$totalFloors = $totalVAcantFloor + $floor['area_ping'];
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
$vacancyRate50to100 = Building::model()->findAll('address Like "%'.$areaName.'%" AND total_floor_space BETWEEN 50 AND 100');
$building50to100 = array();
foreach($vacancyRate50to100 as $buildingDetails){
	$building50to100[] = $buildingDetails['building_id'];
}
$floor50to100 = array();
$wantedFloor50to100 = array();
foreach($building50to100 as $building){
	$floorDetails = Floor::model()->findAll('building_id = '.$building);
	foreach($floorDetails as $floor){
		if($floor['vacancy_info'] == 1){
			$wantedFloor50to100[] = $floor['floor_id'];
		}
		$floor50to100[] = $floor;
	}
}

$totalOfVacantFloor50to100  = '';
foreach($wantedFloor50to100 as $want50to100){
	$floorDetails = Floor::model()->findAllbyPk($want50to100);
	foreach($floorDetails as $fd){
		$totalOfVacantFloor50to100 = $totalOfVacantFloor50to100  + $fd['area_ping'];
	}
}

$flootAvarageRent50to100 = array();
$flootRent50to100 = array();
$totalFloors50to100  = '';
foreach($floor50to100 as $floor){
	$totalFloors50to100 = $totalFloors50to100 + $floor['area_ping'];
	$flootAvarageRent50to100[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
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

$vacancyRate100to300 = Building::model()->findAll('address Like "%'.$areaName.'%" AND total_floor_space BETWEEN 100 AND 300');
$building100to300 = array();
foreach($vacancyRate100to300 as $buildingDetails){
	$building100to300[] = $buildingDetails['building_id'];
}
$floor100to300 = array();
$wantedFloor100to300 = array();
foreach($building100to300 as $building){
	$floorDetails = Floor::model()->findAll('building_id = '.$building);
	foreach($floorDetails as $floor){
		if($floor['vacancy_info'] == 1){
			$wantedFloor100to300[] = $floor['floor_id'];
		}
		$floor100to300[] = $floor;
	}
}

$totalOfVacantFloor100to300  = '';
foreach($wantedFloor100to300 as $want100to300){
	$floorDetails = Floor::model()->findAllbyPk($want100to300);
	foreach($floorDetails as $fd){
		$totalOfVacantFloor100to300 = $totalOfVacantFloor100to300  + $fd['area_ping'];
	}
}

$flootAvarageRent100to300 = array();
$flootRent100to300 = array();
$totalFloors100to300  = '';
foreach($floor100to300 as $floor){
	$totalFloors100to300  = $totalFloors100to300 + $floor['area_ping'];
	$flootAvarageRent100to300[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
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

$vacancyRateGreater300 = Building::model()->findAll('address Like "%'.$areaName.'%" AND total_floor_space >= 300');
$buildingGreater300 = array();
foreach($vacancyRateGreater300 as $buildingDetails){
	$buildingGreater300[] = $buildingDetails['building_id'];
}
$floorGreater300 = array();
$wantedFloorGreater300 = array();
foreach($buildingGreater300 as $building){
	$floorDetails = Floor::model()->findAll('building_id = '.$building);
	foreach($floorDetails as $floor){
		if($floor['vacancy_info'] == 1){
			$wantedFloorGreater300[] = $floor['floor_id'];
		}
		$floorGreater300[] = $floor;
	}
}

$totalOfVacantFloorgrt300  = '';
foreach($wantedFloorGreater300 as $wantg300){
	$floorDetails = Floor::model()->findAllbyPk($wantg300);
	foreach($floorDetails as $fd){
		$totalOfVacantFloorgrt300 = $totalOfVacantFloorgrt300  + $fd['area_ping'];
	}
}

$flootAvarageRentGreater300 = array();
$flootRentGreater300 = array();
$totalFloorsgrt300  = '';
foreach($floorGreater300 as $floor){
	$totalFloorsgrt300  = $totalFloorsgrt300 + $floor['area_ping'];
	$flootAvarageRentGreater300[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
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
								$avgRateGraph = ($avarageSum50to100*100)/$maxRate;
								$avarageSum50to100 = $avarageSum50to100/10000;
							}
							?>
                        	<div class="graph" style="width:<?php echo $avgRateGraph; ?>%">&nbsp;</div>
                            <span><?php echo number_format($avarageSum50to100,2,'.',''); ?>万円</span>
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
                            <span><?php echo number_format($highest50to100,2,'.',''); ?>万円</span>
                            <?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$graphForRate = ($lowest50to100*100)/$maxRateVal;
								$lowest50to100 = $lowest50to100/10000;
							}
							?>
                            <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($lowest50to100,2,'.',''); ?>万円</span>
                        </td>
                        <td><?php echo count($wantedFloor50to100); ?></td>
                        <td><?php
								if($totalOfVacantFloor50to100 != '' && $totalFloors50to100 != ''){ 
									$finalVal = number_format($totalOfVacantFloor50to100/$totalFloors50to100,2,'.','');
									echo $finalVal*(100)." %";
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
                            <span><?php echo number_format($avarageSum100to300,2,'.',''); ?>万円</span>
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
                            <span><?php echo number_format($highest100to300,2,'.',''); ?>万円</span>
                            <?php
							if($maxRateVal == "" || $maxRateVal == 0){
								$graphForRate = 0;
							}else{
								$graphForRate = ($lowest100to300*100)/$maxRateVal;
								$lowest100to300 = $lowest100to300/10000;
							}
							?>
                            <div class="graph" style="width:<?php echo $graphForRate; ?>%">&nbsp;</div>
                            <span><?php echo number_format($lowest100to300,2,'.',''); ?>万円</span>
                        </td>
                        <td><?php echo count($wantedFloor100to300); ?></td>
                        <td><?php
								if($totalOfVacantFloor100to300 != '' && $totalFloors100to300 != ''){
							 		$finalVal = number_format($totalOfVacantFloor100to300/$totalFloors100to300,2,'.','');
									echo $finalVal*(100)." %";
								}?>
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
                            <span><?php echo number_format($avarageSumGreater300,2,'.',''); ?>万円</span>
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
                            <span><?php echo number_format($highestGreater300,2,'.',''); ?>万円</span>
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
                        <td>
						  <?php
								if($totalOfVacantFloorgrt300 != '' && $totalOfVacantFloorgrt300 != ''){
						 			$finalVal = number_format($totalOfVacantFloorgrt300/$totalFloorsgrt300,2,'.','');
									echo $finalVal*(100)." %";
						  }?>
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
            	<li><a href="#">千代田区 神田・秋葉原・岩本町エリア</a></li>
                <li><a href="#">千代田区 神保町・九段下・竹橋エリア</a></li>
                <li><a href="#">中央区 築地・勝どき・月島エリア</a></li>
                <li><a href="#">中央区 小伝馬町・人形町・水天宮前・浜町・東日本橋エリア</a></li>
                <li><a href="#">新宿区 四谷・市ヶ谷・神楽坂エリア</a></li>
                <li><a href="#">千代田区 神田・秋葉原・岩本町エリア</a></li>
                <li><a href="#">千代田区 神保町・九段下・竹橋エリア</a></li>
                <li><a href="#">中央区 築地・勝どき・月島エリア</a></li>
                <li><a href="#">中央区 小伝馬町・人形町・水天宮前・浜町・東日本橋エリア</a></li>
                <li><a href="#">新宿区 四谷・市ヶ谷・神楽坂エリア</a></li>
            </ul>
        </div>
        <div class="area-info half right">
        	<h3>近隣エリア</h3><!--fixed title-->
            <!--show here 10 lists of neighborhood towns-->
            <ul class="related-list">
            	<li><a href="#">千代田区 神田・秋葉原・岩本町エリア</a></li>
                <li><a href="#">千代田区 神保町・九段下・竹橋エリア</a></li>
                <li><a href="#">中央区 築地・勝どき・月島エリア</a></li>
                <li><a href="#">中央区 小伝馬町・人形町・水天宮前・浜町・東日本橋エリア</a></li>
                <li><a href="#">新宿区 四谷・市ヶ谷・神楽坂エリア</a></li>
                <li><a href="#">千代田区 神田・秋葉原・岩本町エリア</a></li>
                <li><a href="#">千代田区 神保町・九段下・竹橋エリア</a></li>
                <li><a href="#">中央区 築地・勝どき・月島エリア</a></li>
                <li><a href="#">中央区 小伝馬町・人形町・水天宮前・浜町・東日本橋エリア</a></li>
                <li><a href="#">新宿区 四谷・市ヶ谷・神楽坂エリア</a></li>
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