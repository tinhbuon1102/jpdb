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
.area-info {
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
.area-info.half {
    float: left;
    width: 48%;
}
.area-info.half.right {
    float: right;
}
.area-info table {
    width: 100%;
    font-size: 12px;
    text-align: left !important;
    line-height: 1.2;
}
ul.sight-image {
    font-size: 0;
}
.sight-image li {
    width: 24%;
    display: inline-block;
}
.sight-image img {
    width: 100%;
    height: auto;
    padding: 5px;
}
.clear {
    clear: both;
}
@media print{
    /*styles here*/
	.printButton{display:none;}
}
</style>

<?php
$summary = $areaCommentary = $marketTrends = $newalyAdd = $finalList = $areaPicture = 'No Data Available';
$districtMarketDetails = MarketInfo::model()->find('district_id = '.$districtId);
if(isset($districtMarketDetails) && count($districtMarketDetails) > 0 && !empty($districtMarketDetails)){
	$summary = $districtMarketDetails['market_summary'];
	$areaCommentary = $districtMarketDetails['area_commentary'];
	$marketTrends = $districtMarketDetails['office_market_trends'];
	$areaPicture = $districtMarketDetails['market_area_picture'];
	$areaPicture = explode(',',$areaPicture);
	$newalyAdd = $districtMarketDetails['newly_developed'];
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

$vacancyRateLess50 = Building::model()->findAll('address Like "%'.$districtName.'%" AND total_floor_space <= 50');
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
	$lowest50 = min($flootRent50);
	$highest50 = max($flootRent50);
}else{
	$avarageSum50 = 0;
	$lowest50 = 0;
	$highest50 = 0;
}
/*********************** end ***************************/

/******************** calc avarage between 50 to 100 ****************/

$vacancyRate50to100 = Building::model()->findAll('address Like "%'.$districtName.'%" AND total_floor_space BETWEEN 50 AND 100');
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

	$lowest50to100 = min($flootRent50to100);

	$highest50to100 = max($flootRent50to100);

}else{

	$avarageSum50to100 = 0;

	$lowest50to100 = 0;

	$highest50to100 = 0;

}

/************************* end ******************************/



/******************** calc avarage between 100 to 300 ****************/

$vacancyRate100to300 = Building::model()->findAll('address Like "%'.$districtName.'%" AND total_floor_space BETWEEN 100 AND 300');

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

	$lowest100to300 = min($flootRent100to300);

	$highest100to300 = max($flootRent100to300);

}else{

	$avarageSum100to300 = 0;

	$lowest100to300 = 0;

	$highest100to300 = 0;

}

/************************* end ******************************/

/******************** calc avarage for greater 300 ****************/

$vacancyRateGreater300 = Building::model()->findAll('address Like "%'.$districtName.'%" AND total_floor_space >= 300');

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

$flootAvarageRentGreater300 = array();

$flootRentGreater300 = array();

foreach($floorGreater300 as $floor){

	$flootAvarageRentGreater300[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];

	if($floor['rent_unit_price'] != ""){

		$flootRentGreater300[] = $floor['rent_unit_price'];

	}

}

if(count($flootAvarageRentGreater300) > 0){

	$avarageSumGreater300 = array_sum($flootAvarageRentGreater300)/count($flootAvarageRentGreater300);

	$lowestGreater300 = min($flootRentGreater300);

	$highestGreater300 = max($flootRentGreater300);

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
        	<h1 class="main-title"><?php echo $districtName; ?> エリア情報</h1>
            <a class="printButton" href="#">
               	<i class="fa fa-print" aria-hidden="true"></i><?php echo Yii::app()->controller->__trans('PRINT OUT'); ?>
            </a>

        </header>

        <div class="area-box">
        	<h3><?php echo $districtName; ?> のエリア</h3>

            <ul class="area_list">

			<?php

			$buildingDetails = Building::model()->findAll();

			$addressArray = array();
			$townArray = array();
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
                    </tr>
                    <tr>
                    	<th>最低賃料</th>
                    </tr>
                    <tr>
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

                    </tr>

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

                            <span><?php echo $highest100to300; ?>万円</span>

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
                            <span><?php echo number_format($lowestGreater300,2,'.',''); ?>万円</span>
                        </td>
                        <td><?php echo count($wantedFloorGreater300); ?></td>
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
        </div>
        <div class="clear"></div>
        
        <div class="area-info">
        	<h3>このエリアの風景</h3>
            <p class="text landscapeText">
            	<?php
					if(!is_array($areaPicture)){
						echo $areaPicture;
					}
				?>
            </p>
            <ul class="sight-image" style="padding:0;">
			<?php
            if(isset($areaPicture) && count($areaPicture) > 0 && !empty($areaPicture) && is_array($areaPicture)){
                $images_path = Yii::app()->baseUrl . '/marketAreaPicture/';
                foreach($areaPicture as $picture){
            ?>
            <li style="position:relative; padding:5px;" data-value="<?php echo $picture; ?>" class="liImages">
                <a class="lightbox">
                    <img src="<?php echo $images_path.$picture; ?>"/>
                	<div class="btnRemvImg"><i class="fa fa-times" style="font-size: 18px;"></i></div>
                </a>
            </li>
            <?php
                }
            }
            ?>
            </ul>
        </div>
        
    </div>
</div>