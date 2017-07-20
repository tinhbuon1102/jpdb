<td class="facility_summary var-top">
	<table class="facility-info" style="border-collapse:collapse; height: 200px;">
    	<tr>
        	<td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC; border-bottom: 1px solid #CCC;">空調設備</td>
            <td>
				<?php
                	if($buildCart['air_control_type'] == 0){
						echo Yii::app()->controller->__trans('unknown');
					}else if($buildCart['air_control_type'] == 2){
						echo Yii::app()->controller->__trans('Individual control');
					}else if($buildCart['air_control_type'] == 1){
						echo Yii::app()->controller->__trans('Zone control');
					}
				?>
            </td>
        </tr>
        <tr>
        	<td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC; border-bottom: 1px solid #CCC;">OAフロア</td>
            <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC; border-bottom: 1px solid #CCC;">
				<?php
                	$floorOAList = Floor::model()->findAll('building_id = '.$buildCart['building_id'].' AND vacancy_info = 1');
					$oaDefaultArray = array('フリーアクセス','3WAY','2WAY','1WAY','引き込み可','非対応');
					foreach($floorOAList as $floorOA){
						$oaFloor[] = $floorOA['oa_type'];
					}
					
					foreach($oaDefaultArray as $oa){
						if(in_array($oa,$oaFloor)){
							echo $oa;
							break;
						}
					}
					/*if(isset($buildCart['oa_floor']) && $buildCart['oa_floor'] != ''){
						$oaExplode = explode('-',$buildCart['oa_floor']);
						if($oaExplode[0] == 0){
							echo Yii::app()->controller->__trans('unknown');
						}else if($oaExplode[0] == 2){
							echo $oaExplode[1] != "" ? $oaExplode[1].'mm' : "-";
						}else if($oaExplode[0] == 1){
							echo Yii::app()->controller->__trans('Nothing');
						}else {
							echo '-';
						}
					}*/
				?>
            </td>
        </tr>
        <tr>
        	<td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC; border-bottom: 1px solid #CCC;">天井高</td>
            <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC; border-bottom: 1px solid #CCC;"><?php echo $buildCart['ceiling_height'] != "" ? $buildCart['ceiling_height'].'mm' : "-"; ?></td>
        </tr>
        <tr>
        	<td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC; border-bottom: 1px solid #CCC;">光ケーブル</td>
            <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC; border-bottom: 1px solid #CCC;">
				<?php
					if($buildCart['opticle_cable'] == 0){
						echo Yii::app()->controller->__trans('unknown');
					}else if($buildCart['opticle_cable'] == 1){
						echo Yii::app()->controller->__trans('Pull Yes');
					}else if($buildCart['opticle_cable'] == 2){
						echo Yii::app()->controller->__trans('Nothing');
					}else{
						echo '-';
					}
				?>
            </td>
        </tr>
        <tr>
        	<td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">エレベーター</td>
            <td>
				<?php
                	if(isset($buildCart['elevator']) && $buildCart['elevator'] != ''){
						if(strlen($buildCart['elevator']) > 2){
							$elevatorExp = explode('-',$buildCart['elevator']);
							if($elevatorExp[0] == 1){
								echo Yii::app()->controller->__trans('Exist');
								if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo '(';
								
								echo isset($elevatorExp[1]) && $elevatorExp[1] != "" ? $elevatorExp[1].Yii::app()->controller->__trans('基') : "";
								echo isset($elevatorExp[2]) && $elevatorExp[2] != "" ? '/'.$elevatorExp[2].Yii::app()->controller->__trans('人乗') : "";
								echo isset($elevatorExp[3]) && $elevatorExp[3] != "" ? $elevatorExp[3].Yii::app()->controller->__trans('基・人荷用') : "";
								echo isset($elevatorExp[4]) && $elevatorExp[4] != "" ? $elevatorExp[4].Yii::app()->controller->__trans('人乗') : "";
								echo isset($elevatorExp[5]) && $elevatorExp[5] != "" ? $elevatorExp[5].'基' : "";
								if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo ')';
							}else{
								echo '-';
							}
						}else{
							if($buildCart['elevator'] == -2){
								echo Yii::app()->controller->__trans('unknown');
							}else if($buildCart['elevator'] == 2){
								echo Yii::app()->controller->__trans('noexist');
							}
						}
					}else{
						echo '-';
					}
				?>
            </td>
        </tr>
        <tr>
        	<td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">駐車場</td>
            <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
				<?php
                	$parkingUnitNo = explode('-',$buildCart['parking_unit_no']);
					if($parkingUnitNo[0] == 1){
						echo $parkingUnitNo[1] != "" ? $parkingUnitNo[1].'台' : "-";
					}else if($parkingUnitNo[0] == 2){
						echo Yii::app()->controller->__trans('noexist');
					}else if($parkingUnitNo[0] == 3){
						echo Yii::app()->controller->__trans('exist but unknown unit number');
					}
				?>
            </td>
        </tr>
        <tr>
        	<td class="no-border" style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">コメント</td>
            <td class="no-border">
				<?php
                	if($buildCart['notes'] != ""){
						echo $buildCart['notes'];
					}else{
						echo '-';
					}
				?>
            </td>
        </tr>
		<?php
		if($buildCart['exp_rent_disabled'] != 1){
			$expRent = array();
			if(isset($buildCart['exp_rent']) && $buildCart['exp_rent'] != ''){
				$expRent = explode('-',$buildCart['exp_rent']);
				if($expRent[0] != ""){
					$expVal = explode('~',$expRent[0]);
					if($expVal[0] != "" || $expVal[1] != ""){
		?>
        <tr>
        	<td colspan="2" class="no-border comment-texts" style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
				<?php
                	if($expVal[0] != ""){
						echo Yii::app()->controller->renderPrice($expVal[0]);
						if($expVal[1] != ""){
							echo " ~";
						}else{
							echo Yii::app()->controller->__trans('Yen');
						}
					}
					if($expVal[1] != ""){
						echo Yii::app()->controller->renderPrice($expVal[1]).Yii::app()->controller->__trans('Yen');
					}
					echo isset($expRent[1]) && $expRent[1] == 1 ? Yii::app()->controller->__trans('(Including common area charges)') : Yii::app()->controller->__trans('(Does not include common expenses)');
				?>
            </td>
        </tr>
		<?php
					}
				}
			}
		}
		?>
    </table>
</td>
<td class="build_img var-top" style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
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
    <img src="<?php echo Yii::app()->baseUrl.'/buildingPictures/'.$buildPics; ?>" style="width:20%;" />
</td>