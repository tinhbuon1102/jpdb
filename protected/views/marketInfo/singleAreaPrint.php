<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
<script>
$(document).on('click','.printButton',function(e){
	e.preventDefault();
	window.print();
});
</script>
<style>
#main{
	width: 700px;
    margin: 0 auto;
}
header.btnright {
    background: rgb(41,87,134);
    background: rgba(41,87,134,1);
    color: #FFF;
    padding: 10px 20px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    line-height: 5px;
}
header.m-title.btnright h1 {
    display: inline-block;
}
div.area-box, .area-info {
    margin-bottom: 40px;
    font-size: 12px;
    position: relative;
}
div.area-box, .area-info {
    margin-bottom: 40px;
    font-size: 12px;
    position: relative;
}
.single-district h3 {
    font-size: 14px;
    padding-bottom: 5px;
    border-bottom: 1px solid #CCC;
    position: relative;
}
.area-info table {
    width: 100%;
    font-size: 12px;
    text-align: left !important;
    line-height: 1.2;
}
.area-info table td {
    broder: 0 1px 1px 0;
    border-style: solid;
    border-color: #e9e9e9;
    border-width: 1px;
    text-align: left !important;
    font-size: 12px !important;
}
info table td {
    padding: 5px 10px;
}

.printButton {
    color: #4676c2;
    background-image: url(/properties/images/ico_print.gif);
}
.printButton:hover {
    color: #4676c2;
    border: 1px solid #bcd0ec;
    background-color: #d3e5fd;
}
.printButton{
	display: inline;
   padding: 10px 10px 10px 27px;
    border: 1px solid #ccc;
    background-color: #f5f5f5;
    background-repeat: no-repeat;
    background-position: 6px center;
    font-size: 0.8em;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
	float: right;
    margin: 10px 0px 10px 10px;
}
div.graph {
    height: 9px;
    margin: 3px 0;
    background: rgb(206,220,232);
    background: -moz-linear-gradient(left, rgba(206,220,232,1) 0%, rgba(117,151,178,1) 100%);
    background: -webkit-linear-gradient(left, rgba(206,220,232,1) 0%,rgba(117,151,178,1) 100%);
    background: linear-gradient(to right, rgba(206,220,232,1) 0%,rgba(117,151,178,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedce8', endColorstr='#7597b2',GradientType=1 );
}
@media print{
    /*styles here*/
	.printButton{display:none;}
}
</style>
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
$vacancyRateLess50 = Building::model()->findAll('address Like "%'.$areaName.'%" AND (total_floor_space <= 50 OR total_floor_space = "")');
$building50 = array();
foreach($vacancyRateLess50 as $buildingDetails){
	if($buildingDetails['total_floor_space'] == ""){
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
$vacancyRate50to100 = Building::model()->findAll('address Like "%'.$areaName.'%" AND (total_floor_space BETWEEN 50 AND 100 OR total_floor_space = "")');

$building50to100 = array();
foreach($vacancyRate50to100 as $buildingDetails){
	if($buildingDetails['total_floor_space'] == ""){
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

$vacancyRate100to300 = Building::model()->findAll('address Like "%'.$areaName.'%" AND (total_floor_space BETWEEN 100 AND 300 OR total_floor_space = "")');
$building100to300 = array();
foreach($vacancyRate100to300 as $buildingDetails){	
	if($buildingDetails['total_floor_space'] == ""){
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

$vacancyRateGreater300 = Building::model()->findAll('address Like "%'.$areaName.'%" AND (total_floor_space >= 300 OR total_floor_space = "")');

$buildingGreater300 = array();
foreach($vacancyRateGreater300 as $buildingDetails){
	if($buildingDetails['total_floor_space'] == ""){
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
            <a class="printButton" href="">
               	<i class="fa fa-print" aria-hidden="true"></i><?php echo Yii::app()->controller->__trans('PRINT OUT'); ?>
            </a>
        </header>
        <div class="area-box">
        	<h3><?php echo $districtName; ?> のエリア</h3>
            
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