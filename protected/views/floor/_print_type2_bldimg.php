<td class="build_img var-top">
	<?php
		$buildPics = BuildingPictures::model()->find('building_id = '.$buildCart['building_id']);
		$main_img = $buildPics['main_image'];
		if($main_img != ""){
			$buildPics = 'front/'.$main_img;
		}else{
			$buildPics = explode(',',$buildPics['front_images']);
			$buildPics = 'front/'.$buildPics[0];
		}
		
		if($buildPics == "front/"){
			$buildPics = 'noimg_building.png';
		}
	?>
	<img src="<?php echo Yii::app()->baseUrl.'/buildingPictures/'.$buildPics; ?>" />
</td><!--building main image-->		