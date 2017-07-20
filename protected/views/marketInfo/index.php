<?php
$buildingDetails = Building::model()->findAll();
$addressArray = array();


foreach($regionList as $region){
	$prep = explode(',',$region['prefectures']);
	foreach($prep as $pre){
		$preName = Prefecture::model()->findByPk($pre);
		$r[$preName['prefecture_name']] = $region['region_id'];
	}
}



$finalRegionArray = array();
$finalRegionIdArray = array();
$rMapper = array();
foreach($regionList as $region){
	$rMapper[$region['region_id']] = $region['region_name'];
}
foreach($buildingDetails as $building){
	$regId = $r[$building['prefecture']];
	$finalRegionArray[] = $rMapper[$regId];
	$finalRegionIdArray[] = $regId;
	
}

/*echo "<pre>";
print_r($finalRegionArray);
print_r($finalRegionIdArray);*/

$finalRegion = array_unique($finalRegionArray);
$finalRegion = array_values($finalRegion);

$finalRegionId = array_unique($finalRegionIdArray);
$finalRegionId = array_values($finalRegionId);

$regionList = array();
$i = 0;
foreach($finalRegion as $region){
	$regionList[] = array('region_id'=>$finalRegionId[$i],'region_name'=>$region);
	$i++;
}

/*echo "<pre>";
print_r($regionList);
die;*/
?>
<div id="main" class="full-width market_info_main">
  <div class="postbox">
    <header class="m-title btnright">
      <h1 class="main-title">エリア情報</h1>
    </header>
    <div class="select-area">
      <ul class="tabs-region">
        <?php
		if(isset($regionList) && count($regionList) > 0){
			$i = 0;
			foreach($regionList as $region){
				$act = '';
				if($i == 0){
					$act = 'active';
				}
		?>
        	<li data-trigger="tabs-region-1" data-value="<?php echo $region['region_id']; ?>"  class="<?php echo $act; ?>"><a href="#" class="tabRegion"><?php echo $region['region_name']; ?></a></li>
        <?php
			$i++;
			}
		}
		?>
      </ul>
      <div class="clear"></div>
      <div class="loadPrefectureLoader" style="display:none;">
      	<img src="<?php echo Yii::app()->baseUrl; ?>/images/ins.gif" class="imgMarketLoader"/>
      </div>
      <div class="loadDistrictLoader" style="display:none;">
      	<img src="<?php echo Yii::app()->baseUrl; ?>/images/ins.gif" class="imgMarketLoader"/>
      </div>
      <div class="tabs_content market_info">
          <div class="divPrefectureWithContent" style="display:none;"></div>
      </div>
      <!--/tabs-content--> 
    </div>
    <!--/select area--> 
  </div>
  <!--/postbox--> 
</div>
