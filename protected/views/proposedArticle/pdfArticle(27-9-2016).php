<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
/********** get google map api key **********/
$criteria=new CDbCriteria;
$criteria->order='google_map_api_key_id DESC';

$getGoogleMapKeyDetails = GoogleMapApiKey::model()->find($criteria);
$gApiKey = '';
if(count($getGoogleMapKeyDetails) > 0){
	$gApiKey = $getGoogleMapKeyDetails['api_key'];
}
/***************** end ****************/
?>
<!--Template Type 2-->
<?php
$prosalData = ProposedArticle::model()->findByPK($requestData['hdnProArticleId']);
if($requestData['print_type'] == 10){
	if(isset($requestData['add_cover']) && $requestData['add_cover'] == 1){
?>
	<section class="sheet cover" style="width: 297mm; height: 189mm; page-break-after: always; position: relative;">
    	<div class="client" style="font-size: 11pt; font-weight: bold; padding-left: 5mm; position: relative; padding-bottom: 2mm;">
			<?php
            	$prosalData = ProposedArticle::model()->findByPK($requestData['hdnProArticleId']);
				$companyName = Customer::model()->findByPk($prosalData['customer_id']);
				echo $companyName['company_name'];
			?>
        </div>
		<h1 style="font-size: 30px; padding-top: 50mm; margin-top: 0;"><?php echo $requestData['header_name']; ?></h1>
		<h4 class="subtitle" style=" margin-bottom: 1mm; margin-top: 0; ">オフィスビルご紹介資料</h4>
		<h4 class="subtitle en" style="font-family: HelveticaNeue-UltraLight; font-weight: 100;">
			<?php echo Yii::app()->controller->__trans('office building information'); ?>
        </h4>
		<div class="author" style="background: #e11b30; padding: 8mm 5mm; position: relative; bottom: 0mm; width: 267mm; margin-bottom: 2mm; line-height: 1.2;">
        	<p class="company_name" style="font-size: 16pt; margin-bottom: 3mm; font-weight: bold;" >株式会社 <?php echo Yii::app()->controller->__trans('Japan Properties'); ?></p>
			<p class="address" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm;">〒106-0032 東京都港区六本木5-9-20　六本木イグノポール5階</p>
			<p class="tel" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm;">03-5411-7500</p>
			<p class="email" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm;">info@properties.co.jp</p>
			<p class="date" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm; margin-top: 5mm;">
				<?php echo  date('Y.m.d'); ?>
            </p>
		</div>
	</section>
<?php
	}
	if(isset($requestData['print_route']) && $requestData['print_route'] == 1) {
?>
	<div class="client" style="font-size: 11pt; font-weight: bold; padding-left: 5mm; position: relative; padding-bottom: 2mm;"></div>
    <section class="sheet" style="width: 297mm; height: 189mm; page-break-after: always; position: relative;">
    	<img src="images/route-map-sample.jpg" class="route-map" style="max-width: 277mm; height:auto;">
        <div class="notice clearfix" style="padding-top: 5mm; width: 277mm;">
        	<div class="half left" style="width: 50%; float: left;">
            	<p style="font-size: 6pt; margin: 0;">※契約面積・金額が㎡表示の物件は坪に換算しています。(坪換算値=3.3058)。</p>
				<p style="font-size: 6pt; margin: 0;">※賃貸条件や建物設備は変更する可能性があります。正式な内容につきましては重要事項説明書をもってご説明致します。</p>
				<p style="font-size: 6pt; margin: 0;">※ご紹介致しました物件が既に商談又は決定済みの節はご了承の程お願い申し上げます。</p>
				<p style="font-size: 6pt; margin: 0;">※賃料等課税対象となる金額には別途消費税が加算されます。</p>
			</div>
			<div class="half right" style="width: 50%; float: left;">
				<p style="font-size: 6pt; margin: 0;">※共用率はワンフロア当りです。</p>
				<p style="font-size: 6pt; margin: 0;">※(案)の表示階は、分割例とします。</p>
				<p style="font-size: 6pt; margin: 0;">※★マークは想定価格を表しています。</p>
				<p style="font-size: 6pt; margin: 0;">※契約が成立した場合仲介手数料として賃料の１カ月分を申し受けます。</p>
			</div>
		</div>
	</section>
<?php
	}
?>
	<section class="sheet" style="width: 297mm; height: 189mm; page-break-after: always; position: relative;">
    	<table class="building-list" style="border-collapse: collapse; width: 100%; border-bottom: 2px solid #CCC; border-left: 1px solid #CCC;">
        	<tr class="tr-th" style=" border: none;">
            	<th class="label_1" style="width: 8mm; font-size: 8pt; line-height: 1.1; background: #e11b30; padding: 2mm 0;">
					<?php echo Yii::app()->controller->__trans('Map'); ?><br/>No.
				</th>
                <th class="label_2" style="width: 65mm; font-size: 8pt;  background: #e11b30; padding: 2mm 0;">ビル概要</th>
				<th class="label_3" style="width: 11mm; font-size: 8pt;  background: #e11b30; padding: 2mm 0;">募集階</th>
                <th class="label_4" style="width: 22mm font-size: 7pt;  background: #e11b30; padding: 2mm 0;;">面積(坪)<br/>(<?php echo Yii::app()->controller->__trans('m'); ?>&sup2;)</th>
				<th class="label_5" style="width: 22mm; font-size: 8pt;  background: #e11b30; padding: 2mm 0;">賃料(坪単価)<br/>総額</th>
                <th class="label_6" style="width: 22mm; font-size: 8pt;  background: #e11b30; padding: 2mm 0;">共益費(坪単価)<br/>総額</th>
                <th class="label_7" style="width: 22mm; font-size: 8pt;  background: #e11b30; padding: 2mm 0;">預託金<br/>総額</th>
                <th class="label_8" style=" font-size: 6pt;  background: #e11b30; padding: 2mm 0;">入居可能日</th>
                <th class="label_9" style=" font-size: 6pt;  background: #e11b30; padding: 2mm 0;">設備概要</th>
                <th class="label_10" style=" width: 30mm; font-size: 8pt; line-height: 1.1; background: #e11b30; padding: 2mm 0;">ビル外観</th>
            </tr>
			<?php
			if(isset($buildCartDetails) && count($buildCartDetails) > 0){
				$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
				$logged_user_id = $user->user_id;
				$buildingNumber = 1;
				$indexFloor = 0;
				foreach($buildCartDetails as $buildCart){
			?>
			<tr>
				<td class="center" style=" text-align: center; font-size: 8pt; border-right: 1px solid #CCC; line-height: 1.2;">No.<?php echo $buildingNumber; ?></td>
				<?php include('_print_summary.php'); ?>
				<td colspan="6" class="list_floor var-top" style="vertical-align: top; font-size: 8pt; border-right: 1px solid #CCC; line-height: 1.2;">
                	<table class="lists" style="border-collapse: collapse; width: 100%;">
						<?php
                        	$floorDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id'].' And vacancy_info = 1' );
							foreach($floorDetails as $floor){
								$indexFloor ++;
								$floorId = Floor::model()->findByPk($floor['floor_id']);
								if($indexFloor && ($indexFloor % 18 == 0)){
									echo '</table></td>';
									include('_print_facility_summary.php');
									echo '</tr></table></section>
										<section class="sheet">
											<table class="building-list" style="border-collapse: collapse; width: 100%; border-bottom: 2px solid #CCC; border-left: 1px solid #CCC; font-size: 8pt; border-right: 1px solid #CCC; line-height: 1.2;">
												<tr class="tr-th" style=" border: none;">
													<th class="label_1" style="width: 8mm;">'. Yii::app()->controller->__trans("Map") .'<br/>No.</th>
													<th class="label_2" style="width: 65mm;">ビル概要</th>
													<th class="label_3" style="width: 11mm;">募集階</th>
													<th class="label_4" style="width: 22mm;">面積(坪)<br/>('. Yii::app()->controller->__trans("m") .'&sup2;)</th>
													<th class="label_5" style="width: 22mm;">賃料(坪単価)<br/>総額</th>
													<th class="label_6" style="width: 22mm;">共益費(坪単価)<br/>総額</th>
													<th class="label_7" style="width: 22mm;">預託金<br/>総額</th
													<th class="label_8">入居可能日</th>
													<th class="label_9">設備概要</th>
													<th class="label_10" style=" width: 30mm;">ビル外観</th>
												</tr>
												<tr><td class="center" style=" text-align: center;">No.'. $buildingNumber .'</td>';
									include('_print_summary.php');
									echo '<td colspan="6" class="list_floor var-top" style="vertical-align: top;">
										<table class="lists" style="border-collapse: collapse;">';
								}
						?>
						<tr class="row_fst">
							<td rowspan="2" class="center label_3" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2; padding: 0 1mm; font-size: 8pt; border-right:1px solid #ccc;">
								<?php
								if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
									if(strpos($floorId['floor_down'], '-') !== false){
										$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										echo $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
									}else{
										echo $floorDown.' '.Yii::app()->controller->__trans('階');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									echo '&nbsp;'.$floorId['roomname'];
								}
								?>
							</td>
							<td class="label_4" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm;  font-size: 8pt; border-right:1px solid #ccc;">
								<?php
								if(isset($floorId['area_ping']) && $floorId['area_ping'] != ""){
									echo $floorId['area_ping']/*." ".Yii::app()->controller->__trans('Ping')*/;
								}else{
									echo '-';
								}
								?>
								<?php
								if(isset($floorId['payment_by_installments']) && $floorId['payment_by_installments'] == 1){
									echo '分割例 :';
								}else if(isset($floorId['payment_by_installments']) && $floorId['payment_by_installments'] == 2){
									echo '分割可 :';
								}
								?>
								<?php
                                if(isset($floorId['floor_partition']) && $floorId['floor_partition'] != ""){
									$expFloorParts = explode(',',$floorId['floor_partition']);
									if(!empty($expFloorParts)){
										foreach($expFloorParts as $part){
											echo $part/*.'坪'*/.',<br/>';
										}
									}
								}
								?>
								<?php
								if(isset($floorId['area_net']) && $floorId['area_net'] != ""){
									echo "ネット: ".$floorId['area_net']/*." 坪"*/;
								}else{
									echo '';
								}
								?>
							</td>
							<td class="label_5" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm; font-size: 8pt; border-right:1px solid #ccc;">
								<?php
                                if($floorId['rent_unit_price_opt'] != ''){
									if($floorId['rent_unit_price_opt'] == -1){
										echo Yii::app()->controller->__trans('undecided');
									}else if($floorId['rent_unit_price_opt'] == -2){
										echo Yii::app()->controller->__trans('ask');
									}
								}else{
									echo '-';
								}
								?>
                                <?php
								if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
									echo Yii::app()->controller->renderPrice($floorId['rent_unit_price'])/*.Yii::app()->controller->__trans('yen / tsubo')*/;
								}else{
									echo '';
								}
								?>
							</td>
							<td class="label_6" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm;  font-size: 8pt; border-right:1px solid #ccc;">
								<?php
								if($floorId['unit_condo_fee'] == ""){
									if($floorId['unit_condo_fee_opt'] != ''){
										if($floorId['unit_condo_fee_opt'] == 0){
											echo Yii::app()->controller->__trans('none');
										}else if($floorId['unit_condo_fee_opt'] == -1){
											echo Yii::app()->controller->__trans('undecided');
										}else if($floorId['unit_condo_fee_opt'] == -2){
											echo Yii::app()->controller->__trans('ask');
										}else if($floorId['unit_condo_fee_opt'] == -3){
											echo '賃料に込み (含む)';
										}
									}else{
										echo '-';
									}
								}
								?>
                                <?php
								if(isset($floorId['unit_condo_fee']) && $floorId['unit_condo_fee'] != ""){
									echo Yii::app()->controller->renderPrice($floorId['unit_condo_fee'])/*.Yii::app()->controller->__trans('yen / tsubo')*/;
								}else{
									echo '';
								}
								?>
							</td>
							<td class="label_7" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm;  font-size: 8pt; border-right:1px solid #ccc;">
								<?php
								if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
									if($floorId['deposit_opt'] != ''){
										echo '<br/>';
										if($floorId['deposit_opt'] == -1){
											echo Yii::app()->controller->__trans('undecided');
										}else if($floorId['deposit_opt'] == -3){
											echo Yii::app()->controller->__trans('none');
										}else if($floorId['deposit_opt'] == -2){
											echo Yii::app()->controller->__trans('undecided･ask');
										}
									}
									if(isset($floorId['deposit_month']) &&  $floorId['deposit_month'] != ''){
										//echo '<br/>'.$floorId['deposit_month'].' ヶ月';
									}
								?><br>
                                <?php
									if(isset($floorId['deposit']) && $floorId['deposit'] != ""){
										echo Yii::app()->controller->renderPrice($floorId['deposit'])/*.Yii::app()->controller->__trans('yen / tsubo')*/;
									}
								}
								?>
							</td>
							<td class="label_8 center" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm;  font-size: 8pt; border-right:1px solid #ccc;">即入居</td>
						</tr>
						<tr class="row_second">
							<td class="label_4" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm;  font-size: 8pt; border-right:1px solid #ccc;"><?php echo $floorId['area_m'] != "" && $floorId['area_m'] != 0 ? $floorId['area_m']/*.'m&sup2;'*/ : '-'; ?></td><!--area of space by meter-->
							<td class="label_5" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm;  font-size: 8pt; border-right:1px solid #ccc;"><?php echo $floorId['total_rent_price'] != "" && $floorId['total_rent_price'] != 0 ? Yii::app()->controller->renderPrice($floorId['total_rent_price'])/*.'円'*/ : '-'; ?></td><!--total rent fee-->
							<td class="label_6" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm;  font-size: 8pt; border-right:1px solid #ccc;"><?php echo $floorId['total_condo_fee'] != "" && $floorId['total_condo_fee'] != 0 ? Yii::app()->controller->renderPrice($floorId['total_condo_fee'])/*.'円'*/ : '-'; ?></td><!--total condo fee-->
							<td class="label_7" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm;  font-size: 8pt; border-right:1px solid #ccc;"><?php echo $floorId['total_deposit'] != "" && $floorId['total_deposit'] != 0 ? Yii::app()->controller->renderPrice($floorId['total_deposit'])/*.'円'*/ : '-'; ?></td><!--total deposit-->
							<td class="label_8 center" style=" text-align: center; height: 5mm; padding: 0 1mm; height: 5mm; line-height: 1.2;  padding: 0 1mm;  font-size: 8pt; border-right:1px solid #ccc;"></td><!--always blank-->
						</tr>
						<?php
							}
						?>
					</table>
				</td><!--list of the floor-->
				<?php include('_print_facility_summary.php');?>
			</tr>
			<?php
				$buildingNumber++;
				$array[] = $buildCart['map_lat'].','.$buildCart['map_long'];
				$buildNameArray[] = $buildCart['name'];
				}
			}
			?>
		</table>
	</section>
<?php
	if(isset($requestData['print_each_building']) && $requestData['print_each_building'] == 1){
		if(isset($buildCartDetails) && count($buildCartDetails) > 0){
			foreach($buildCartDetails as $buildCart){
				$address = $buildCart['address'];
				$lat = $buildCart['map_lat'];
				$long = $buildCart['map_long'];
?>
			<section class="sheet" style="width: 297mm; height: 189mm; page-break-after: always; position: relative;">
            	<?php
                echo '<span class="build_title" style="margin-top: 10px; margin-bottom: 10px; font-size: 20px;">'.$buildCart['name']."<span>";
                $images_path = realpath(Yii::app()->basePath . '/../pdfMaps');
                if(file_exists($images_path.'/build_'.$buildCart['building_id'].'.jpg')){
                    $imageFile = $images_path.'/build_'.$buildCart['building_id'].'.jpg';
                }else{							
                    $image = file_get_contents('http://maps.google.com/maps/api/staticmap?size=512x512&center='.$lat.','.$long.'&zoom=15&sensor=false&amp;key='.$gApiKey); 
                    $fp  = fopen($images_path.'/build_'.$buildCart['building_id'].'.jpg', 'w+'); 
                    
                    fputs($fp, $image); 
                    fclose($fp); 
                    unset($image);
                    
                    $imageFile = $images_path.'/build_'.$buildCart['building_id'].'.jpg';
                }
                ?>
                <img alt="<?php echo $buildCart['name']; ?>" src="<?php echo $imageFile; ?>" style="width: 100%;">
            </section>
<?php
			}
		}
	}
	if(isset($requestData['print_map']) && $requestData['print_map'] == 1){
?>
	<div id="map" class="sheet" style="width: 297mm;height: 189mm;"></div>
	<script src="http://maps.google.com/maps/api/js?key=<?php echo $gApiKey; ?>&v=3" type="text/javascript"></script>    
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/markerwithlabel.js"></script>
	<style>
    .labels {
        background: #fff;
        width: auto;
        height: auto;
        padding: 5px;
        text-align: center;
        line-height: 1em;
        font-size: 14px;
        color: #000;
        border: 5px solid red;
        font-weight: bold;
    }
    </style>
	<script type="text/javascript">
        var locations = <?php echo json_encode($array); ?>;
        var buildName = <?php echo json_encode($buildNameArray); ?>
        
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: new google.maps.LatLng(36.6733301,135.2284552),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        var image = '<?php echo Yii::app()->baseUrl.'/images/icon.png';?>';			
        
        var latlngbounds = new google.maps.LatLngBounds();
        for (i = 0; i < locations.length; i++) {
            var splitLatLong = locations[i].split(',');
            var lat = splitLatLong[0];
            var long = splitLatLong[1];
            /*var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat,long),
                map: map,
                label: { text: buildName[i] },
                labelContent: buildName[i],
                labelAnchor: new google.maps.Point(15, 65),
                labelClass: "labels", // the CSS class for the label
                labelInBackground: false,
                //label: buildName[i],
                icon: pinSymbol('red'),
                //icon: 'http://chart.apis.google.com/chart?chst='+buildName[i]+'&chld=' + k + '|FF0000|000000',
                //animation: google.maps.Animation.BOUNCE,
                //icon : image,
                visible: true
            });*/
            var marker = new MarkerWithLabel({
                position: new google.maps.LatLng(lat,long),
                map: map,
                labelContent: (i+1)+'. '+buildName[i],
                //labelAnchor: new google.maps.Point(lat,long),
                labelClass: "labels",
                //labelInBackground: false,
                //icon: image,
                icon: {},
                //animation: google.maps.Animation.BOUNCE,
                visible: true
            });
            
            /*marker.info = new google.maps.InfoWindow({
              content: buildName[i],
            });
            
            google.maps.event.addListener(marker, 'click', function() {
              marker.info.open(map, marker);
            });*/
            
            var iw = new google.maps.InfoWindow({
                content: buildName[i],
            });
            google.maps.event.addListener(marker, "click", function(e) {
                iw.open(map, this);
            });
            
            latlngbounds.extend(marker.position);
        }
        //Get the boundaries of the Map.
        var bounds = new google.maps.LatLngBounds();
        //Center map and adjust Zoom based on the position of all markers.
        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);
        
        marker.setMap(map);
    </script>
<?php
	}
}
?>

<!--Template Type 3-->
<?php
if($requestData['print_type'] ==8){
	if(isset($buildCartDetails) && count($buildCartDetails) > 0){
		$proposedFloors = array();
		$proposedDetails = ProposedArticle::model()->findByPk($requestData['hdnProArticleId']);
		$proposedFloors = explode(',',$proposedDetails['floor_id']);
		
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		if(isset($requestData['add_cover']) && $requestData['add_cover'] == 1) {
?>
		<section class="sheet cover">
        	<div class="client">
				<?php
				$prosalData = ProposedArticle::model()->findByPK($requestData['hdnProArticleId']);
				$companyName = Customer::model()->findByPk($prosalData['customer_id']);
				echo $companyName['company_name'];
                ?>
            </div>
            <h1 style="font-size: 30px; padding-top: 50mm; margin-top: 0;"><?php echo $requestData['header_name']; ?></h1>
            <h4 class="subtitle" style="background: #e11b30; padding: 8mm 5mm; position: absolute; bottom: 5mm; width: 267mm; margin-bottom: 2mm; line-height: 1.2;">オフィスビルご紹介資料</h4>
            <h4 class="subtitle en" style="font-family: HelveticaNeue-UltraLight; font-weight: 100;"><?php echo Yii::app()->controller->__trans('office building information'); ?></h4>
            <div class="author"  style="background: #e11b30; padding: 8mm 5mm; position:relative; bottom: 5mm; width: 267mm; margin-bottom: 2mm; line-height: 1.2;">
            	<p class="company_name" style="margin-top: 0; font-size: 16pt; margin-bottom: 3mm; font-weight: bold;">株式会社 <?php echo Yii::app()->controller->__trans('Japan Properties'); ?></p>
                <p class="address" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm;">〒106-0032 東京都港区六本木5-9-20　六本木イグノポール5階</p>
                <p class="tel" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm;">03-5411-7500</p>
                <p class="email" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm;">info@properties.co.jp</p>
                <p class="date" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm; margin-top: 5mm;">
					<?php  echo  date('Y.m.d'); ?>
                </p>
            </div>
        </section>
<?php
		}
		if(isset($requestData['print_route']) && $requestData['print_route'] == 1) {
?>
		<section class="sheet" style="width: 297mm; height: 189mm; page-break-after: always; position: relative;">
        	<img src="images/route-map-sample.jpg" class="route-map"  style="max-width: 277mm; height:auto;">
            <div class="notice clearfix" style="padding-top: 5mm; width: 277mm;">
            	<div class="half left" style="width: 50%; float: left;">
                    <p style="font-size: 4pt; margin: 0;">※契約面積・金額が㎡表示の物件は坪に換算しています。(坪換算値=3.3058)。</p>
                    <p style="font-size: 4pt; margin: 0;">※賃貸条件や建物設備は変更する可能性があります。正式な内容につきましては重要事項説明書をもってご説明致します。</p>
                    <p style="font-size: 4pt; margin: 0;">※ご紹介致しました物件が既に商談又は決定済みの節はご了承の程お願い申し上げます。</p>
                    <p style="font-size: 4pt; margin: 0;">※賃料等課税対象となる金額には別途消費税が加算されます。</p>
                </div>
                <div class="half right" style="width: 50%; float: left;">
                	<p style="font-size: 4pt; margin: 0;">※共用率はワンフロア当りです。</p>
                    <p style="font-size: 4pt; margin: 0;">※(案)の表示階は、分割例とします。</p>
                    <p style="font-size: 4pt; margin: 0;">※★マークは想定価格を表しています。</p>
                    <p style="font-size: 4pt; margin: 0;">※契約が成立した場合仲介手数料として賃料の１カ月分を申し受けます。</p>
               	</div>
            </div>
        </section>
<?php
		}
		$buildingNumber = 1;
		foreach($buildCartDetails as $buildCart){
?>
		<section class="sheet commercial" style="page-break-after: avoid;">
        	<table class="bd_data" style="border-collapse: collapse; width: 100%;">
            	<tbody>
                	<tr>
                    	<td class="b_no" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;">
                        	<span style=""><?php echo $buildCart['buildingId']; ?></span>
                        </td>
                        <td class="b_nm" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;">
							<?php echo $buildingNumber.'.'.$buildCart['name']; ?>
                        </td>
                        <td class="b_address" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;">
							<?php echo $buildCart['address']; ?>
                        </td>
                    </tr>
               	</tbody>
           	</table>
            
            <table class="b_info br" style="border-collapse: collapse; width: 100%;">
            	<tbody>
                	<tr>
                    	<td class="b_build_str" style="font-size: 8pt;border: none;text-align:left;padding: 0;width: 21mm;">
							<?php echo date('Y年 m月',strtotime($buildCart['built_year'])); ?>
                        </td>
                        <td class="st_data" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;">
                        	表参道駅 9分
                        </td>
                        <td class="b_scale_str" style="font-size: 8pt;border: none;text-align:left;padding: 0;width: 21mm;">
							<?php
							$typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
							echo $typeDetails['construction_type_name'];
                            ?>
                        </td>
                        <td class="f_oa" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;"></td>
                        <td class="f_lightline_str" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;">
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
                        <td class="f_air" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;">
                        	<?php
							$typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
							echo $typeDetails['construction_type_name'];
							?>
                        </td>
                        <td class="b_usetime" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;">
                        	24H
                        </td>
                        <td class="b_ev_num" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;">
							<?php
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
                                }else if($elevatorExp[0] == -2){
                                    echo Yii::app()->controller->__trans('unknown');
                                }else if($elevatorExp[0] == 2){
                                    echo Yii::app()->controller->__trans('noexist');
                                }else{
                                    echo '-';
                                }
                            ?>
                     	</td>
                        <td class="b_parking_num" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;">
                        	<?php
                            	$parkingUnitNo = explode('-',$buildCart['parking_unit_no']);
								if($parkingUnitNo[0] == 1){
									echo Yii::app()->controller->__trans('exist').($parkingUnitNo[1] != "" ? '('.$parkingUnitNo[1].' '.Yii::app()->controller->__trans('台').')' : "");
								}else if($parkingUnitNo[0] == 2){
									echo Yii::app()->controller->__trans('noexist');
								}else if($parkingUnitNo[0] == 3){
									echo Yii::app()->controller->__trans('exist but unknown unit number');
								}
							?>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <table class="b_data" style="border-collapse: collapse;">
            	<tbody>
                <?php
                	$count2RowAbove = 0;
					$managementArray = array('1'=>'オーナー','6'=>'サブリース','7'=>'貸主代理','8'=>Yii::app()->controller->__trans('AM'),'10'=>'業者','4'=>'仲介業者','2'=>'管理会社','9'=>Yii::app()->controller->__trans('PM'),													'3'=>'ゼネコン','-1'=>'不明',);
                	$ownerDetails = OwnershipManagement::model()->findAllByAttributes(array('building_id' => (array)$buildCart['building_id']), array('order' => 'modified_on DESC', 'limit' => 10, 'group' => 'owner_company_name'));
					foreach($ownerDetails as $owner){
						$count2RowAbove++;
				?>
                	<tr>
                    	<th class="bo_name" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;border-right: 1px solid #CCC;">
                        	<span class="owner_type ">
								<?php
                                	if($owner['ownership_type'] != 0){
										echo $managementArray[$owner['ownership_type']];
									}
								?>
                            </span>
							<?php echo $owner['owner_company_name']; ?>
                        </th>
                        <th class="bo_tel1" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;border-right: 1px solid #CCC;">
							<?php echo $owner['company_tel']; ?>
                        </th>
                        <th class="bo_fee" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;border-right: 1px solid #CCC;">
							<?php
                            if(isset($owner['charge']) && $owner['charge'] != ""){
								if (is_numeric($owner['charge'])){
									echo number_format($owner['charge'],1,'.','');
								}else{
									echo $owner['charge'];
								}
							}else{
								echo '-';
							}
							?>
                        </th>
                        <th class="bo_upd" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;border-right: 1px solid #CCC;">更新
							<?php  echo date('y-m-d',strtotime($owner['modified_on'])); ?>
                        </th>
                    </tr>
				<?php
                	}
				?><!--/loop of owner if owners are multiple-->
               	</tbody>
            </table>
            <p class="last_update" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;border-right: 1px solid #CCC;">ビル情報最終更新：
				<?php echo $buildCart['modified_on']; ?><!--latest updated date of building info-->
            </p><!--history of updated things-->
            <?php
			$addedOnArray = array();
			$transmissionMattersDetails = TransmissionMatters::model()->findAll('building_id = '.$buildCart['building_id']);
			$negotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildCart['building_id'].' order by rent_negotiation_id desc');
			$mergeArray = array_merge_recursive($transmissionMattersDetails,$negotiationDetails);
			foreach($mergeArray as $merge){
				$addedOnArray[] = date('Y.m.d',strtotime($merge['added_on']));
			}
			array_multisort($addedOnArray,SORT_DESC,$mergeArray);
			?>
			<?php
				foreach($mergeArray as $indexLog => $log){
				if ($indexLog >= 18) {
					if ($indexLog == 18) {
						echo '</section>';
						echo '<section class="sheet commercial">';
					}
					continue;
				}
				$count2RowAbove ++;
			?>
            <table class="camp_info" style="border-collapse: collapse; width: 100%;">
            	<tbody>
                	<tr>
                    	<td class="cam_date" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;border-right: 1px solid #CCC;">
							<?php echo date('y-m-d',strtotime($log['added_on'])); ?>
                        </td><!--date of updated-->
                        <td colspan="10" style="font-size: 8pt;border: none;text-align: left;padding: 0;width: 21mm;border-right: 1px solid #CCC;">
							<?php
								if(isset($log['note'])){
									if($log['note'] != ""){
										echo $log['note'];
									}else{
										echo '-';
									}
								}
								if(isset($log['negotiation_type'])){
									$allocateFloorDetails = Floor::model()->findAllByAttributes(array('floor_id'=>explode(',',$log['allocate_floor_id'])));
									if(isset($allocateFloorDetails) && count($allocateFloorDetails) > 0){
										$floorName = '';
										foreach($allocateFloorDetails as $floor){
											if(strpos($floor['floor_down'], '-') !== false){
												$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
											}else{
												$floorDown = $floor['floor_down'];
											}
											if($floor['floor_up'] != ""){
												$floorName .= $floorDown." ~ ".$floor['floor_up'].' '.Yii::app()->controller->__trans('階');
											}else{
												$floorName .= $floorDown.' '.Yii::app()->controller->__trans('階');
											}
											$negUnitB = '';
											$negUnit = '';
											if($log['negotiation_type'] == 1){
												$negUnit = '(共益費込み)';
												$negUnitB = ' | ¥';
											}elseif($log['negotiation_type'] == 5){
												$negUnit = '(共益費込み)';
												$negUnitB = ' | ¥';
											}elseif($log['negotiation_type'] == 2 || $log['negotiation_type'] == 3){
												$negUnit = 'ヶ月';
											}
											$floorName .= " / ".$floor['area_ping'].Yii::app()->controller->__trans('tsubo').''.$negUnitB.$negUnit;
										}									
									}else{
										$floorName = '';
									}
									
									if($log['negotiation_type'] == 1){
										echo '坪単価(底値)';
									}elseif($log['negotiation_type'] == 2){									
										echo Yii::app()->controller->__trans('Deposit negotiation value');
									}elseif($log['negotiation_type'] == 3){
										echo Yii::app()->controller->__trans('Key money negotiation value');
									}elseif($log['negotiation_type'] == 5){
										echo '坪単価(目安値)';
									}									
									else{
										echo Yii::app()->controller->__trans('Other negotiations information');
									}
									echo " ".$log['negotiation'].'<br/>'.$floorName;
								}
							?>
                       	</td><!--updated thing-->
                    </tr>
                </tbody>
            </table>
			<?php
            	}
			?><!--floor info-->
            <table class="f_info" style="width:100% background: #f4f4f4; border-top: 1px solid #CCC; margin-bottom: 5mm;">
            	<tbody>
				<?php
				$floorDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id']);				
				$countFloor = 0;
				foreach($floorDetails as $floor){
					if(!in_array($floor['floor_id'],$proposedFloors)){
						continue;
					}
					$countFloor++;
					$floorId = Floor::model()->findByPk($floor['floor_id']);
					if($countFloor % 12 == 0 || ($countFloor < 12 && $count2RowAbove < 28 && $countFloor == ceil(28 - $count2RowAbove)/3)) {
						$countFloor = 12;
						echo '</tbody></table></section>';
						echo '<section class="sheet commercial"><table class="f_info"><tbody>';
					}
				?><!--if multiple floors,loop-->
                	<tr style="border-bottom:1px solid #fff;">
                    	<td class="f_emp" style="width:45px;" style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
                        	<span style="width:45px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;"><?php echo $floorId['floorId']; ?></span>
                        </td><!--floor ID-->
                        <td class="f_floor_str" style="width:30px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
							<?php
                        	if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
								if(strpos($floorId['floor_down'], '-') !== false){
									$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
								}else{
									$floorDown = $floorId['floor_down'];
								}
								if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
									echo $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
								}else{
									echo $floorDown.' '.Yii::app()->controller->__trans('階');
								}
							}
							if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
								echo '&nbsp;'.$floorId['roomname'];
							}
							?>
                        </td><!--stair of the floor-->
                        <td class="f_acreg_str" style="width:42px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
							<?php
                            	if(isset($floorId['area_ping']) && $floorId['area_ping'] != ""){
									echo $floorId['area_ping']." ".Yii::app()->controller->__trans('Ping');
								}else{
									echo '-';
								}
							?>
                        </td><!--area space of the floor-->
                        <td class="f_rentstart" style="width:50px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
                        	<?php
							if(isset($floorId['move_in_date']) && $floorId['move_in_date'] != "" && (string)$floorId['move_in_date'] != '0'){
								echo $floorId['move_in_date'];
							}else{
								echo '-';
							}
							?>
                        </td><!--date to rent start for the floor-->
                        <td class="f_price_m_shiki" style="width:25px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">償 
							<?php
                            if(isset($floorId['total_deposit']) && $floorId['total_deposit'] != "0" && $floorId['total_deposit'] != ""){
								echo Yii::app()->controller->renderPrice($floorId['total_deposit']).' 円';
							}
							if($floorId['deposit_opt'] != ''){
								echo '<br/>';
								if($floorId['deposit_opt'] == -1){
									echo Yii::app()->controller->__trans('undecided');
								}else if($floorId['deposit_opt'] == -3){
									echo Yii::app()->controller->__trans('none');
								}else if($floorId['deposit_opt'] == -2){
									echo Yii::app()->controller->__trans('undecided･ask');
								}
							}
							if(isset($floorId['deposit_month']) &&  $floorId['deposit_month'] != ''){
								echo '<br/>'.$floorId['deposit_month'].' ヶ月';
							}
							?><br>
							<?php
                            if(isset($floorId['deposit']) && $floorId['deposit'] != "" && $floorId['deposit'] != 0){
								echo Yii::app()->controller->renderPrice($floorId['deposit']).Yii::app()->controller->__trans('yen / tsubo');
							}else{
								echo '';
							}
							?>
                        </td><!--deposit fee of the floor-->
                        <td class="f_price_t_rent" style="width:50px; height: 16mm;  font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
							<?php
							if($floorId['rent_unit_price_opt'] != ''){
								if($floorId['rent_unit_price_opt'] == -1){
									echo Yii::app()->controller->__trans('undecided');
								}else if($floorId['rent_unit_price_opt'] == -2){
									echo Yii::app()->controller->__trans('ask');
								}
							}else{
								echo '-';
							}
							?>
							<?php
                            if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
								echo Yii::app()->controller->renderPrice($floorId['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo');
							}else{
								echo '';
							}
							?>
                        </td><!--rent fee per 1 tsubo of the floor-->
                        <td class="f_price_a_rent" style="width:60px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
							<?php echo $floorId['total_rent_price'] ? Yii::app()->controller->renderPrice($floorId['total_rent_price']).'円' : ''; ?>
                        </td><!--total rent fee of the floor-->
                        <td class="f_price_rerent" style="width:45px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">更 
							<?php 
                            if(isset($floorId['renewal_fee_opt']) && $floorId['renewal_fee_opt'] != ""){
								if($floorId['renewal_fee_opt'] == 2){
									echo Yii::app()->controller->__trans('None');
								}elseif($floorId['renewal_fee_opt'] == -1){
									echo Yii::app()->controller->__trans('Unknown');
								}elseif($floorId['renewal_fee_opt'] == -2){
									echo Yii::app()->controller->__trans('Undecided･ask');
								}else{
									echo '';
								}
							}
							
							if(isset($floorId['renewal_fee_reason']) && $floorId['renewal_fee_reason'] != ""){
								if($floorId['renewal_fee_reason'] == 1){
									echo Yii::app()->controller->__trans('現賃料の');
								}elseif($floorId['renewal_fee_reason'] == 2){
									echo Yii::app()->controller->__trans('新賃料の');
								}else{
									echo '';
								}
							}
							
							if(isset($floorId['renewal_fee_recent']) && $floorId['renewal_fee_recent'] != ""){
								echo $floorId['renewal_fee_recent'].Yii::app()->controller->__trans('month');
							}
							?>
                        </td><!--renewal fee-->
                        <td class="f_price_amo_str" style="width:50px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">償 
                        	<?php
							if(isset($floorId['repayment_opt']) && $floorId['repayment_opt'] != ""){
								if($floorId['repayment_opt'] == -3){
									echo Yii::app()->controller->__trans('None');
								}elseif($floorId['repayment_opt'] == -4){
									echo Yii::app()->controller->__trans('Unknown');
								}elseif($floorId['repayment_opt'] == -1){
									echo Yii::app()->controller->__trans('Undecided');
								}elseif($floorId['repayment_opt'] == -2){
									echo Yii::app()->controller->__trans('Ask');
								}elseif($floorId['repayment_opt'] == -5){
									echo Yii::app()->controller->__trans('Sliding');
								}else{
									echo '';
								}
							}
							
							if(isset($floorId['repayment_reason']) && $floorId['repayment_reason'] != ""){
								if($floorId['repayment_reason'] == 1){
									echo Yii::app()->controller->__trans('現賃料の');
								}elseif($floorId['repayment_reason'] == 2){
									echo Yii::app()->controller->__trans('解約時賃料の');
								}else{
									echo '';
								}
							}
							
							if(isset($floorId['repayment_amt']) && $floorId['repayment_amt'] != ""){
								echo Yii::app()->controller->renderPrice($floorId['repayment_amt']);
							}
							
							if(isset($floorId['repayment_amt_opt']) && $floorId['repayment_amt_opt'] != ""){
								if($floorId['repayment_amt_opt'] == 1){
									echo Yii::app()->controller->__trans('ヶ月');
								}elseif($floorId['repayment_amt_opt'] == 2){
									echo Yii::app()->controller->__trans('%');
								}else{
									echo '';
								}
							}
							?>
                        </td><!--repayment-->
                        <td class="f_price_keymoney_str" style="width:30px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">礼 
                        	<?php
							if(isset($floorId['key_money_opt']) && $floorId['key_money_opt'] != ""){
								if($floorId['key_money_opt'] == 2){
									echo Yii::app()->controller->__trans('None');
								}elseif($floorId['key_money_opt'] == -1){
									echo Yii::app()->controller->__trans('Unknown');
								}elseif($floorId['key_money_opt'] == -2){
									echo Yii::app()->controller->__trans('undecided･ask');
								}else{
									echo '';
								}
							}else{
								echo '';
							}
							
							if(isset($floorId['key_money_month']) && $floorId['key_money_month'] != ""){
								echo $floorId['key_money_month'].Yii::app()->controller->__trans('month');
							}
							?>
                        </td><!--key money-->
                        <td class="f_oa" style="width:30px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
                        	<?php
							if($floorId['oa_type'] == '非対応'){
								echo 'OA 非対応';
							}else if($floorId['oa_type'] == 'フリーアクセス'){
								echo 'フリーアクセス';
							}else if($floorId['oa_type'] == '1WAY'){
								echo 'OA '.Yii::app()->controller->__trans('1WAY');
							}else if($floorId['oa_type'] == '2WAY'){
								echo 'OA '.Yii::app()->controller->__trans('2WAY');
							}else if($floorId['oa_type'] == '3WAY'){
								echo 'OA '.Yii::app()->controller->__trans('3WAY');
							}else if($floorId['oa_type'] == '引き込み可'){
								echo 'OA 引き込み可';
							}else{
								echo '-';
							}
							?>
                        </td><!--OA-->
                        <td class="f_height" style="width:45px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
                        	<?php
                            if(isset($floorId['contract_period_opt']) && $floorId['contract_period_opt'] != ""){
								if($floorId['contract_period_opt'] == 1){
									echo '通常';
								}elseif($floorId['contract_period_opt'] == 2){
									echo '定借';
								}elseif($floorId['contract_period_opt'] == 3){
									echo '定借希望';
								}else{
									echo '-';
								}
							}else{
								echo '-';
							}
							
							if(isset($floorId['contract_period_optchk']) && $floorId['contract_period_optchk'] == 1){
								echo '<br>年数相談';
							}
							
							if(isset($floorId['contract_period_duration']) && $floorId['contract_period_duration'] != ''){
								echo '<br>'.$floorId['contract_period_duration'].' 年';
							}
							?>
                  			</font></font>
                        </td><!--type of contract-->
                        <?php
						$floorTypeUseArray = array();
						$floorTypeUse = $floorId['type_of_use'];
						$floorTypeUseArray = explode(',',$floorTypeUse);
						?>
                        <td class="f_purpose1" style="width:20px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
                        	<?php
							$opt1Val = '×事';
							if(in_array('1',$floorTypeUseArray)){
								$opt1Val = '○事';
							}
							echo $opt1Val;
							?>
                        </td><!--use for office-->
                        <td class="f_purpose2" style="width:20px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
                            <?php
							$opt1Val = '×店';
							if(in_array('2',$floorTypeUseArray)){
								$opt1Val = '○店';
							}
							echo $opt1Val;
							?>
                        </td><!--use for shop-->
                        <td class="f_purpose4" style="width:20px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
                            <?php
							$opt2Val = '×倉';
							if(in_array('5',$floorTypeUseArray)){
								$opt2Val = '○倉';
							}
							echo $opt2Val;
							?>
                        </td><!--use for warehouse-->
                        <td class="f_purpose8" style="width:20px; font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; border-right: 1px solid #CCC;">
                            <?php
							$opt3Val = '×他';
							$otherArray = array();
							$useOfType = UseTypes::model()->findAll('is_active = 1');
							foreach($useOfType as $uType){
								if($uType['user_type_id'] == '1' || $uType['user_type_id'] == '2' || $uType['user_type_id'] == '5'){
									continue;
								}else{
									$otherArray[] = $uType['user_type_id'];
								}
							}
							$intersect = array_intersect($floorTypeUseArray,$otherArray);
							
							if(!empty($intersect)){
								$opt3Val = '○他';
							}
							echo $opt3Val;
							?>
                        </td><!--use for other-->
                    </tr>
				<?php
                	}
				?>
                </tbody>
            </table>
        </section>
<?php
			$buildingNumber++;
        	$array[] = $buildCart['map_lat'].','.$buildCart['map_long'];
			$buildNameArray[] = $buildCart['name'];
		}
		if(isset($requestData['print_each_building']) && $requestData['print_each_building'] == 1){
			if(isset($buildCartDetails) && count($buildCartDetails) > 0){
				foreach($buildCartDetails as $buildCart){
					$address = $buildCart['address'];
					$lat = $buildCart['map_lat'];
					$long = $buildCart['map_long'];
?>
				 <section class="sheet" style="width: 297mm; height: 189mm; /* 1mm余裕をもたせる */ page-break-after: always; position: relative;">
                 	<?php
                    echo '<span class="build_title" style="margin-top: 10px; margin-bottom: 10px; font-size: 20px;">'.$buildCart['name']."<span>";
					$images_path = realpath(Yii::app()->basePath . '/../pdfMaps');
					if(file_exists($images_path.'/build_'.$buildCart['building_id'].'.jpg')){
						$imageFile = $images_path.'/build_'.$buildCart['building_id'].'.jpg';
					}else{							
						$image = file_get_contents('http://maps.google.com/maps/api/staticmap?size=512x512&center='.$lat.','.$long.'&zoom=15&sensor=false&amp;key='.$gApiKey); 
						$fp  = fopen($images_path.'/build_'.$buildCart['building_id'].'.jpg', 'w+'); 
						
						fputs($fp, $image); 
						fclose($fp); 
						unset($image);
						
						$imageFile = $images_path.'/build_'.$buildCart['building_id'].'.jpg';
					}
					?>
					<img alt="<?php echo $buildCart['name']; ?>" src="<?php echo $imageFile; ?>" style="width: 100%;">
                 </section>
<?php
				}
			}
		}
		if(isset($requestData['print_map']) && $requestData['print_map'] == 1) {
?>
		<div id="map" class="sheet" style="width: 297mm; height: 1000px;"></div>
		<script src="http://maps.google.com/maps/api/js?key=<?php echo $gApiKey; ?>&v=3" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/markerwithlabel.js"></script>
        <style>
		.labels {
		    background: #fff;
			width: auto;
			height: auto;
			padding: 5px;
			text-align: center;
			line-height: 1em;
			font-size: 14px;
			color: #000;
			border: 5px solid red;
			font-weight: bold;
		}
		</style>
        <script type="text/javascript">
			var locations = <?php echo json_encode($array); ?>;
			var buildName = <?php echo json_encode($buildNameArray); ?>
			
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 10,
				center: new google.maps.LatLng(36.6733301,135.2284552),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			
			var infowindow = new google.maps.InfoWindow();
			var marker, i;
			var image = '<?php echo Yii::app()->baseUrl.'/images/icon.png';?>';			
			
			var latlngbounds = new google.maps.LatLngBounds();
			for (i = 0; i < locations.length; i++) {
				var splitLatLong = locations[i].split(',');
				var lat = splitLatLong[0];
				var long = splitLatLong[1];
				/*var marker = new google.maps.Marker({
					position: new google.maps.LatLng(lat,long),
					map: map,
					label: { text: buildName[i] },
					labelContent: buildName[i],
					labelAnchor: new google.maps.Point(15, 65),
					labelClass: "labels", // the CSS class for the label
					labelInBackground: false,
					//label: buildName[i],
					icon: pinSymbol('red'),
					//icon: 'http://chart.apis.google.com/chart?chst='+buildName[i]+'&chld=' + k + '|FF0000|000000',
					//animation: google.maps.Animation.BOUNCE,
					//icon : image,
					visible: true
				});*/
				var marker = new MarkerWithLabel({
					position: new google.maps.LatLng(lat,long),
					map: map,
					labelContent: (i+1)+'. '+buildName[i],
					//labelAnchor: new google.maps.Point(lat,long),
					labelClass: "labels",
					//labelInBackground: false,
					//icon: image,
					icon: {},
					//animation: google.maps.Animation.BOUNCE,
					visible: true
				});
				
				/*marker.info = new google.maps.InfoWindow({
				  content: buildName[i],
				});
				
				google.maps.event.addListener(marker, 'click', function() {
				  marker.info.open(map, marker);
				});*/
				
				/*var iw = new google.maps.InfoWindow({
					content: buildName[i],
				});
				google.maps.event.addListener(marker, "click", function(e) {
					iw.open(map, this);
				});*/
				
				latlngbounds.extend(marker.position);
			}
			//Get the boundaries of the Map.
			var bounds = new google.maps.LatLngBounds();
			//Center map and adjust Zoom based on the position of all markers.
			map.setCenter(latlngbounds.getCenter());
			map.fitBounds(latlngbounds);
			
			marker.setMap(map);
		</script>
<?php
		}
	}
}
?>

<!--Template Type 1-->

<?php
if($requestData['print_type'] == 11){
	if(isset($requestData['add_cover']) && $requestData['add_cover'] == 1) {
?>
	<section class="sheet cover">
    	<div class="client" style="font-size: 11pt; font-weight: bold; padding-left: 5mm; position: relative; padding-bottom: 2mm;">
        	<?php
                $prosalData = ProposedArticle::model()->findByPK($requestData['hdnProArticleId']);
                $companyName = Customer::model()->findByPk($prosalData['customer_id']);
                echo $companyName['company_name'];
            ?>
       	</div>
        <h1 style="font-size: 30px; padding-top: 50mm; margin-top: 0;"><?php echo $requestData['header_name']; ?></h1>
        <h4 class="subtitle" style=" margin-bottom: 1mm; margin-top: 0; ">オフィスビルご紹介資料</h4>
        <h4 class="subtitle en" style="font-family: HelveticaNeue-UltraLight; font-weight: 100;"><?php echo Yii::app()->controller->__trans('office building information'); ?></h4>
        <div class="author" style="background: #e11b30; padding: 8mm 5mm; position: absolute; bottom: 5mm; width: 267mm; margin-bottom: 2mm; line-height: 1.2;">
            <p class="company_name" style="font-size: 16pt; margin-bottom: 3mm; font-weight: bold;">株式会社 <?php echo Yii::app()->controller->__trans('Japan Properties'); ?></p>
            <p class="address" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm;">〒106-0032 東京都港区六本木5-9-20　六本木イグノポール5階</p>
            <p class="tel" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm;">03-5411-7500</p>
            <p class="email" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm;">info@properties.co.jp</p>
            <p class="date" style="margin-top: 0; font-size: 10pt; margin-bottom: 2mm; margin-top: 5mm;">
                <?php  echo  date('Y.m.d'); ?>
            </p>
        </div>
    </section>
<?php
	}
	if(isset($requestData['print_route']) && $requestData['print_route'] == 1){
?>
	<section class="sheet" style="width: 297mm; height: 189mm; page-break-after: always; position: relative;">
    	<img src="images/route-map-sample.jpg" class="route-map"  style="max-width: 277mm; height:auto;">
        <div class="notice clearfix" style="padding-top: 5mm; width: 277mm;">
            <div class="half left" style="width: 50%; float: left;">
                <p style="font-size: 4pt; margin: 0;">※契約面積・金額が㎡表示の物件は坪に換算しています。(坪換算値=3.3058)。</p>
                <p style="font-size: 4pt; margin: 0;">※賃貸条件や建物設備は変更する可能性があります。正式な内容につきましては重要事項説明書をもってご説明致します。</p>
                <p style="font-size: 4pt; margin: 0;">※ご紹介致しました物件が既に商談又は決定済みの節はご了承の程お願い申し上げます。</p>
                <p style="font-size: 4pt; margin: 0;">※賃料等課税対象となる金額には別途消費税が加算されます。</p>
            </div>
            <div class="half right" style="width: 50%; float: left;">
                <p style="font-size: 4pt; margin: 0;">※共用率はワンフロア当りです。</p>
                <p style="font-size: 4pt; margin: 0;">※(案)の表示階は、分割例とします。</p>
                <p style="font-size: 4pt; margin: 0;">※★マークは想定価格を表しています。</p>
                <p style="font-size: 4pt; margin: 0;">※契約が成立した場合仲介手数料として賃料の１カ月分を申し受けます。</p>
            </div>
        </div>
    </section>
<?php
	}
?>
	<section class="sheet" style="width: 297mm; height: 189mm; page-break-after: always; position: relative;">
    	<table class="building-profile" style="border-collapse: collapse; width: 277mm;">
        	<caption style="background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold;">
				<?php echo Yii::app()->controller->__trans('office building profile'); ?>
            </caption>
            <tr>
            	<th class="center" style=" text-align: center; border-bottom: 1px solid #000; font-size: 10pt; font-weight: normal; padding-top: 8mm;">No</th>
                <th class="building-name" style=" width: 110mm; border-bottom: 1px solid #000; font-size: 10pt; font-weight: normal; padding-top: 8mm;">ビル名</th>
                <th class="building-addr" style="width: 80mm; border-bottom: 1px solid #000; font-size: 8pt; font-weight: normal; padding-top: 8mm; ">所在地</th>
                <th class="est-date" style="border-bottom: 1px solid #000; font-size: 10pt; font-weight: normal; padding-top: 8mm;">竣工</th>
                <th class="floor-space" style="border-bottom: 1px solid #000; font-size: 10pt; font-weight: normal; padding-top: 8mm;">延床面積</th>
                <th class="floor-construction" style="border-bottom: 1px solid #000; font-size: 10pt; font-weight: normal; padding-top: 8mm;">構造</th>
            </tr>
            <tr>
            	<?php
				if(isset($buildCartDetails) && count($buildCartDetails) > 0){
					$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
					$logged_user_id = $user->user_id;
					$buildingNumber = 1;
					foreach($buildCartDetails as $buildCart){
                ?>
                <td class="center" style=" text-align: center; font-size: 10pt; border-bottom: 1px solid #c9c9c9; line-height: 7mm; height: 7mm;"><?php echo $buildingNumber; ?></td>
                <td class="center" style=" text-align: center; font-size: 10pt; border-bottom: 1px solid #c9c9c9; line-height: 7mm; height: 7mm;"><?php echo $buildCart['name']; ?></td>
                <td class="center" style=" text-align: center; font-size: 10pt; border-bottom: 1px solid #c9c9c9; line-height: 7mm; height: 7mm;"><?php echo $buildCart['address']; ?></td>
                <td class="center" style=" text-align: center; font-size: 10pt; border-bottom: 1px solid #c9c9c9; line-height: 7mm; height: 7mm;"><?php echo date('Y年 m月',strtotime($buildCart['built_year'])); ?></td>
                <td class="center" style=" text-align: center; font-size: 10pt; border-bottom: 1px solid #c9c9c9; line-height: 7mm; height: 7mm;"><?php echo $buildCart['total_floor_space'] != "" ? $buildCart['total_floor_space'].'m&sup2;' : "-"; ?></td>
                <?php /*?><td class="center"><?php echo $buildCart['total_floor_space'] != "" ? $buildCart['total_floor_space'].'坪' : "-"; ?></td><?php */?>
                <td class="center" style=" text-align: center; font-size: 10pt; border-bottom: 1px solid #c9c9c9; line-height: 7mm; height: 7mm;"">
					<?php
                        $typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
                        echo $typeDetails['construction_type_name'];
                    ?>
                </td>
            </tr>
			<?php
                    $array[] = $buildCart['map_lat'].','.$buildCart['map_long'];
                    $buildNameArray[] = $buildCart['name'];
                    $buildingNumber++;
                    }
                }
            ?>
       	</table>
    </section>
<?php
	if(isset($buildCartDetails) && count($buildCartDetails) > 0){
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		$buildingNumber = 1;
		foreach($buildCartDetails as $buildCart){
			if(isset($requestData['print_each_building']) && $requestData['print_each_building'] == 1){
				if(isset($buildCartDetails) && count($buildCartDetails) > 0){
					$address = $buildCart['address'];
					$lat = $buildCart['map_lat'];
					$long = $buildCart['map_long'];
?>
				<section class="sheet" style="width: 297mm; height: 189mm; page-break-after: always; position: relative;">
					<?php echo '<span class="build_title" style="margin-top: 10px; margin-bottom: 10px; font-size: 20px;">'.$buildCart['name']."<span>"; ?>
                    <?php
                    $images_path = realpath(Yii::app()->basePath . '/../pdfMaps');
                    if(file_exists($images_path.'/build_'.$buildCart['building_id'].'.jpg')){
                        $imageFile = $images_path.'/build_'.$buildCart['building_id'].'.jpg';
                    }else{							
                        $image = file_get_contents('http://maps.google.com/maps/api/staticmap?size=512x512&center='.$lat.','.$long.'&zoom=15&sensor=false&amp;key='.$gApiKey); 
                        $fp  = fopen($images_path.'/build_'.$buildCart['building_id'].'.jpg', 'w+'); 
                        
                        fputs($fp, $image); 
                        fclose($fp); 
                        unset($image);
                        
                        $imageFile = $images_path.'/build_'.$buildCart['building_id'].'.jpg';
                    }
                    ?>
                    <img alt="<?php echo $buildCart['name']; ?>" src="<?php echo $imageFile; ?>" style="width: 100%;">
                </section>
<?php
				}
			}
			$floorDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id'].' And vacancy_info = 1' );
			$sum_arem = 0;
			$sum_are_net = 0;
			if(count($floorDetails) <= 9 || true){
?>
			<section class="sheet" style="width: 297mm; height: 189mm; page-break-after: always; position: relative;">
            	<table class="building-profile single-info" style="border-collapse: collapse; width: 277mm;">
                	<tr>
                    	<td colspan="2" class="title" style="border-top: 5px solid #e11b30; font-size: 24pt; height: auto; line-height: 1.6; border: none; font-size: 8pt; line-height: 1; height: 4mm; padding: 0;"><?php echo $buildingNumber.'-'.$buildCart['name']; ?></td>
                    </tr>
                    <tr>
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
                        <td class="td_col1_3" style=" width: 25%; vertical-align: top;">
                        	<img src="<?php echo Yii::app()->baseUrl.'/buildingPictures/'.$buildPics; ?>" style="width: 100%;"/>
                        </td>
                        <td class="td_col2_3" style="width: 75%; padding: 0 0 0 10mm; vertical-align: top;">
                        	<table class="current_status" style="border-collapse: collapse; width: 100%;">
                            	<caption style="background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold;">
                                	募集状況
                                </caption>
                                <tr>
                                	<th style=" border-color: #c9c9c9; font-size:14px  padding: 2mm 0 1mm;">階数</th>
                                    <th colspan="2" style=" border-color: #c9c9c9; font-size:14px; padding: 2mm 0 1mm;">面積(<?php echo Yii::app()->controller->__trans('NET'); ?>)</th>
                                    <th style=" border-color: #c9c9c9; font-size:14px ;padding: 2mm 0 1mm;">預託金</th>
                                    <th style=" border-color: #c9c9c9; font-size:14px ;padding: 2mm 0 1mm;">賃料</th>
                                    <th style=" border-color: #c9c9c9; font-size:14px; padding: 2mm 0 1mm;">共益費</th>
                                    <th style=" border-color: #c9c9c9; font-size:14px; padding: 2mm 0 1mm;">入居予定日/備考</th>
                                </tr>
                                <?php
								$pFloors = explode(',',$prosalData['floor_id']);
								foreach($floorDetails as $indexFloor => $floor){
									if(!in_array($floor['floor_id'],$pFloors)){
										continue;
									}
									$floorId = Floor::model()->findByPk($floor['floor_id']);
									if($indexFloor && $indexFloor<=20 && ($indexFloor % 19 == 0 || ($indexFloor > 20 && $indexFloor % 20 == 11))) {
										echo '</table></td></tr></table></section>
											<section class="sheet">
												<table class="building-profile single-info" style="border-top: 5px solid #e11b30; border-collapse: collapse; width: 277mm;">
													<tr>
														<td colspan="2" class="title" style="font-size: 24pt; height: auto; line-height: 1.6; border: none;"></td>
							                        </tr>
													<tr>
														<td class="td_col1_3" style="width: 24%; vertical-align: top; style="width: 100%;"">
							                            </td>
							                            <td class="td_col2_3" style="width: 76%; padding: 0 0 0 10mm; vertical-align: top;">
							                                <table class="current_status" style="margin-top: 10px width: 100%;">
																<caption style="background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold;">
						                                            募集状況
						                                        </caption>
						                                        <tr>
						                                            <th>階数</th>
						                                            <th colspan="2">面積('. Yii::app()->controller->__trans("NET").')</th>
						                                            <th>預託金</th>
						                                            <th>賃料</th>
						                                            <th>共益費</th>
						                                            <th>入居予定日/備考</th>
						                                        </tr>';
                                            }
                                        ?>
                                        <tr>
                                            <td class="stairs center" style="text-align: center; font-size:12px"> 
                                                <?php
                                                if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
                                                    if(strpos($floorId['floor_down'], '-') !== false){
                                                        $floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
                                                    }else{
                                                        $floorDown = $floorId['floor_down'];
                                                    }
                                                    if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
                                                        echo $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
                                                    }else{
                                                        echo $floorDown.' '.Yii::app()->controller->__trans('階');
                                                    }
                                                }
												if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
													echo '&nbsp;'.$floorId['roomname'];
												}
                                                ?>
                                            </td>
                                            <td class="space center" style="text-align: center;font-size:12px">
												<?php
                                                if(isset($floorId['area_ping']) && $floorId['area_ping'] != ""){
                                                    echo $floorId['area_ping']." ".Yii::app()->controller->__trans('Ping');
                                                }else{
                                                    echo '-';
                                                }echo "<br/>";
                                                ?>
												<?php
                                                    if(isset($floorId['payment_by_installments']) && $floorId['payment_by_installments'] == 1){
                                                        echo '分割例 :';
                                                    }else if(isset($floorId['payment_by_installments']) && $floorDetails['payment_by_installments'] == 2){
                                                        echo '分割可 :';
                                                    }
                                                ?>
												<?php if(isset($floorId['floor_partition']) && $floorId['floor_partition'] != ""){
                                                      $expFloorParts = explode(',',$floorId['floor_partition']);
                                                        if(!empty($expFloorParts)){
                                                            foreach($expFloorParts as $part){
                                                                echo $part.'坪,'.'<br/>';
                                                            }
                                                        }
                                                        
                                                }
                                                ?>
                                          </td>
                                          	<td class="space center" style="text-align: center; font-size:12px">
												<?php
                                                if(isset($floorId['area_m']) && $floorId['area_m'] != ""){
                                                    echo $floorId['area_m']." ".Yii::app()->controller->__trans('m&sup2;');
                                                }else{
                                                    echo '-';
                                                }
                                                ?>
                                                
                                                <?php
                                                if(isset($floorId['area_net']) && $floorId['area_net'] != ""){
                                                    echo "ネット: ".$floorId['area_net']." 坪";
                                                }else{
                                                    echo '';
                                                }
                                                ?>                                                    
                                            </td>
                                            <td class="deposit right-align" style="text-align: right;font-size:12px">
												<?php
                                                	if(isset($floorId['deposit']) && $floorId['deposit'] != "" && $floorId['deposit'] != 0){
														echo Yii::app()->controller->renderPrice($floorId['deposit']).Yii::app()->controller->__trans('yen / tsubo');
													}
													
													if($floorId['deposit_opt'] != ''){
														if($floorId['deposit_opt'] == -1){
															echo Yii::app()->controller->__trans('undecided');
														}else if($floorId['deposit_opt'] == -3){
															echo Yii::app()->controller->__trans('none');
														}else if($floorId['deposit_opt'] == -2){
															echo Yii::app()->controller->__trans('undecided･ask');
														}
													}
													/*if(isset($floorId['deposit_month']) &&  $floorId['deposit_month'] != ''){
														echo '<br/>'.$floorId['deposit_month'].' ヶ月';
													}*/
												?>
                                            </td>
                                            <td class="rent-fee right-align" style="text-align: right;font-size:12px">
                                            	<?php
												if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
													echo Yii::app()->controller->renderPrice($floorId['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo');
												}else{
													echo '';
												}
												
												if($floorId['rent_unit_price_opt'] != ''){
													if($floorId['rent_unit_price_opt'] == -1){
														echo Yii::app()->controller->__trans('undecided');
													}else if($floorId['rent_unit_price_opt'] == -2){
														echo Yii::app()->controller->__trans('ask');
													}
												}else{
													echo '';
												}
												?>
                                            </td>
                                            <td class="condo-fee right-align" style="text-align: right; font-size:12px">
                                            	<?php
												if(isset($floorId['unit_condo_fee']) && $floorId['unit_condo_fee'] != ""){
													echo Yii::app()->controller->renderPrice($floorId['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo');
												}else{
													if($floorId['unit_condo_fee_opt'] != ''){
														if($floorId['unit_condo_fee_opt'] == 0){
															echo Yii::app()->controller->__trans('none');
														}else if($floorId['unit_condo_fee_opt'] == -1){
															echo Yii::app()->controller->__trans('undecided');
														}else if($floorId['unit_condo_fee_opt'] == -2){
															echo Yii::app()->controller->__trans('ask');
														}else if($floorId['unit_condo_fee_opt'] == -3){
															echo '賃料に込み (含む)';
														}
													}else{
														echo '-';
													}
												}
												?>
                                            </td>
                                            <td class="date-move center" style=" text-align: center; font-size:12px">
                                                <?php
                                                    if(isset($floorId['move_in_date']) && $floorId['move_in_date'] != "" && (string)$floorId['move_in_date'] != '0'){
                                                        echo $floorId['move_in_date'];
                                                    }else{
                                                        echo '-';
                                                    }
                                                ?>
                                            </td>
                                            <?php $sum_arem += $floorId['area_ping']; ?>
                                            <?php $sum_are_net += $floorId['area_m']; ?>
                                        </tr>
                                        <tr>
                                            <td class="stairs center" style="text-align: center;"></td>
                                            <td class="space center" style="text-align: center;"></td>
                                            <td class="space center" style="text-align: center;"></td>
                                            <td class="deposit right-align" style="text-align: right;">
												<?php
                                                    if(isset($floorId['total_deposit']) && $floorId['total_deposit'] != "0" && $floorId['total_deposit'] != ""){
                                                        echo Yii::app()->controller->renderPrice($floorId['total_deposit']).' 円';
                                                    }else{
                                                        echo '';
                                                    }
                                                ?>
                                            </td>
                                            <td class="rent-fee right-align" style="text-align: right; font-size:12px;">
												<?php
                                                    if(isset($floorId['total_rent_price']) && $floorId['total_rent_price'] != ""){
                                                        echo Yii::app()->controller->renderPrice($floorId['total_rent_price']).'円';
                                                    }else{
                                                        echo '-';
                                                    }
                                                ?>
                                            </td>
                                            <td class="condo-fee right-align" style="text-align: right; font-size:12px;">
												<?php
                                                    if(isset($floorId['total_condo_fee']) && $floorId['total_condo_fee'] != ""){
                                                        echo Yii::app()->controller->renderPrice($floorId['total_condo_fee']).Yii::app()->controller->__trans('yen');
                                                    }else{
                                                        
                                                    }
                                                ?>
                                            </td>
                                            <td class="date-move center" style=" text-align: center; font-size:12px"></td>
                                        </tr>
                                        <?php
                                        }
                                        ?><!--blank cell *if there are 3 floors that you choose-->
                                        <?php for($i=0; $i< 15 - (count($floorDetails) * 2) - 1; $i++) {?>
                                        <tr>
                                            <td class="stairs center" style=" text-align: center;font-size:12px"></td>
                                            <td class="space center" style=" text-align: center;font-size:12px"></td>
                                            <td class="space center" style=" text-align: center;font-size:12px"></td>
                                            <td class="deposit right-align" style="text-align: right;font-size:12px "></td>
                                            <td class="rent-fee right-align" style="text-align: right;font-size:12px "></td>
                                            <td class="condo-fee right-align" style="text-align: right;font-size:12px "></td>
                                            <td class="date-move center" style=" text-align: center;font-size:12px"></td>
                                        </tr>
                                        <?php }?>
                                        <tr>
                                            <td class="total" style="padding-left: 3mm;">計</td>
                                            <td class="space center" style=" text-align: center; font-size:12px"><?php echo $sum_arem; ?>坪</td>
                                            <td class="space center" style=" text-align: center; font-size:12px"><?php echo $sum_are_net; ?><?php echo Yii::app()->controller->__trans('m'); ?>&sup2;</td>
                                            <td class="deposit right-align" style="text-align: right;font-size:12px "></td>
                                            <td class="rent-fee right-align" style="text-align: right;font-size:12px "></td>
                                            <td class="condo-fee right-align" style="text-align: right;font-size:12px "></td>
                                            <td class="date-move center" style=" text-align: center;font-size:12px"></td>
                                        </tr>
                                        <tr>
                                            <td class="right-align notes" colspan="7" style="text-align: right; font-size:14px;line-height: 1.4; ">上段：坪単価 下段：総額<br/>賃料等課税対象となる金額には別途消費税が加算されます</td>
                                        </tr>
                                    </table>
                            </td>
                        </tr>
                        
                        <?php 
                        if (count($floorDetails) > 13 && count($floorDetails) <= 19) {
                        	echo '</table></section>
									<section class="sheet">
									<table class="building-profile single-info" style="border-top: 5px solid #e11b30; border-collapse: collapse; width: 277mm; height: auto; line-height: 1.6; border: none;">
									';
                        }?>
                        <tr>
                            <td class="space-empty" style="height: 5mm;"></td>
                            <td rowspan="2" class="var-top td_col2_3 details" style="width: 76%; padding: 0 0 0 10mm; vertical-align: top; vertical-align: top;">
                                <table class="building-details" style="border-collapse: collapse;  margin-top: 3mm;">
                                    <tr>
                                        <td class="var-top" style="vertical-align: top; width:100%">
                                            <table class="summary building-summary" style="border-collapse: collapse; width: 100%;  margin-bottom: 4mm; ">
                                                <caption style="background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold; margin-bottom: 1mm;">ビル概要</caption>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; ">所在地</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; "><?php echo $buildCart['address']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">交通</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
                                                        <?php
                                                            $trafficDetails = BuildingStation::model()->find('building_id = '.$buildCart['building_id'].' order by time');
                                                            echo $trafficDetails['name'].' 駅'.$trafficDetails['line'].' 徒歩'.$trafficDetails['time'].'分';
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; height:180px;">竣工年月</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; height:180px;"><?php echo date('Y年 m月',strtotime($buildCart['added_on'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; height:180px;">規模</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm; height:180px;">
														<?php
                                                        	if(isset($buildCart['floor_scale']) && $buildCart['floor_scale'] != ""){
																$scaleExp = explode('-',$buildCart['floor_scale']);
																$floorGround = $scaleExp[0];
																$floorUnderGround = $scaleExp[1];
																if($floorGround != "" && $floorUnderGround != ""){
																	echo $floorGround.'F/B'.$floorUnderGround;
																}else{
																	if($floorGround != ""){
																		echo $floorGround.'F';	
																	}elseif($floorUnderGround != ""){
																		echo 'B'.$floorUnderGround;
																	}else{
																		echo '';
																	}
																}
															}else{
																echo '-';
															}
														?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">ﾘﾆｭｰｱﾙ</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;"><?php echo $buildCart['renewal_data'] != "" ? $buildCart['renewal_data'] : "-"; ?></td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">構造</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
                                                        <?php
                                                            $typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
                                                            echo $typeDetails['construction_type_name'];
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">延床面積</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;"><?php echo $buildCart['total_floor_space'] != "" ? $buildCart['total_floor_space'].' m&sup2;' : "-"; ?></td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">基準階面積</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;"><?php echo $buildCart['std_floor_space'] != "" ? $buildCart['std_floor_space'].' 坪' : "-"; ?></td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">共用率</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;"><?php echo $buildCart['shared_rate'] != "" ? $buildCart['shared_rate'].'%' : "-"; ?></td>
                                                </tr>
                                            </table>
                                            
                                            <table class="summary facility-summary" style="border-collapse: collapse;">
                                                <caption style="background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold; margin-bottom: 1mm; ">設備概要</caption>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">空調制御</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
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
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">天井高</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;"><?php echo '基準階：'.($buildCart['ceiling_height'] != "" ? $buildCart['ceiling_height'].'mm' : "-"); ?></td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">OAフロア</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
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
                                                            /*if(isset( $buildCart['oa_floor']) &&  $buildCart['oa_floor'] != ''){
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
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">セキュリティ</th>
                                                    <td>
                                                        <?php
                                                            $securityDetails = Security::model()->findByPk($buildCart['security_id']);
                                                            echo $securityDetails['security_name'];
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">光ケーブル</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
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
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">エレベーター</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
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
                                                    <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">駐車場</th>
                                                    <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
                                                        <?php
                                                            if(isset($buildCart['parking_unit_no']) && count($buildCart['parking_unit_no']) > 0){
                                                                $parkingUnitNo = explode('-',$buildCart['parking_unit_no']);
                                                                if($parkingUnitNo[0] == 1){
                                                                   echo Yii::app()->controller->__trans('exist').($parkingUnitNo[1] != "" ? '('.$parkingUnitNo[1].' '.Yii::app()->controller->__trans('台').')' : "");
                                                                }else if($parkingUnitNo[0] == 2){
                                                                    echo Yii::app()->controller->__trans('noexist');
                                                                }else if($parkingUnitNo[0] == 3){
                                                                    echo Yii::app()->controller->__trans('exist but unknown unit number');
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="pad-left var-top" style="vertical-align: top; padding-left:70mm">
                                            <table class="summary contract-info" style="border-collapse: collapse;">
                                            <?php
                                                $contractArray = $renewalArray = $renewalFeeMonthArray = $keymoneyArray = $keyMoneyMonthArray = $amortizationArray = $repaymentMonthArray = array();
												$fName = $renewalDetails = $renewalOpt = $keyMoneyDetails =  $keyMoneyOpt = $amortizationDetails = $repaymentOpt = '';
												foreach($floorDetails as $floor){
													if($floorId['renewal_fee_opt'] != 0){
														$renewalArray[$floor['floor_id']] = $floorId['renewal_fee_opt'];
													}
													$renewalFeeMonthArray[$floor['floor_id']] = $floorId['renewal_fee_recent'];
													if($floorId['key_money_opt'] != 0){
														$keymoneyArray[$floor['floor_id']] = $floorId['key_money_opt'];
													}
													$keyMoneyMonthArray[$floor['floor_id']] = $floorId['key_money_month'];
													if($floorId['repayment_opt'] != 0){
														$amortizationArray[$floor['floor_id']] = $floorId['repayment_opt'];
													}
													$repaymentMonthArray[$floor['floor_id']] = $floorId['repayment_amt'];
												}
												$renewalArray = array_unique($renewalArray);
												$keymoneyArray = array_unique($keymoneyArray);
												$amortizationArray = array_unique($amortizationArray);
												
												$renewalFeeMonthArray = array_unique($renewalFeeMonthArray);
												$keyMoneyMonthArray = array_unique($keyMoneyMonthArray);
												$repaymentMonthArray = array_unique($repaymentMonthArray);
												
												$k = 0;
												if(count($renewalArray) > 0){
													foreach($renewalArray as $key=>$val){
														if($k == count($renewalArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														if($val != 0 && $val != ""){
															if($val == 2){
																$renewalOpt = Yii::app()->controller->__trans('None');
															}else if($val == -1){
																$renewalOpt = Yii::app()->controller->__trans('unknown');
															}else if($val == -2){
																$renewalOpt = Yii::app()->controller->__trans('Undecided');
															}
															$renewalDetails .= $renewalOpt.(count($renewalArray) > 2 ? '('.$fName.')'.$slsh : '');
														}
														$k++;
													}
												}else{
													foreach($renewalFeeMonthArray as $key=>$val){
														if($k == count($renewalFeeMonthArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														
														$renewalDetails .= $val.'ヶ月'.(count($renewalFeeMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
														$k++;
													}
												}
												
												$j = 0;
												if(count($keymoneyArray) > 0){
													foreach($keymoneyArray as $key=>$val){
														if($j == count($keymoneyArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														if($val != 0 && $val != ""){
															if($val == 2){
																$keyMoneyOpt = Yii::app()->controller->__trans('None');
															}else if($val == -1){
																$keyMoneyOpt = Yii::app()->controller->__trans('unknown');
															}else if($val == -2){
																$keyMoneyOpt = Yii::app()->controller->__trans('Undecided');
															}
															$keyMoneyDetails .= $keyMoneyOpt.(count($keymoneyArray) > 2 ? '('.$fName.')'.$slsh : '');
														}
														$j++;
													}
												}else{
													foreach($keyMoneyMonthArray as $key=>$val){
														if($j == count($keyMoneyMonthArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														$keyMoneyDetails .= $val.'ヶ月'.(count($keyMoneyMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
														$j++;
													}
												}
												
												$z = 0;
												if(count($amortizationArray) > 0){
													foreach($amortizationArray as $key=>$val){
														if($z == count($amortizationArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														if($val != 0 && $val != ""){
															if($val == -3){
																$repaymentOpt = Yii::app()->controller->__trans('None');
															}else if($val == -4){
																$repaymentOpt = Yii::app()->controller->__trans('unknown');
															}else if($val == -1){
																$repaymentOpt = Yii::app()->controller->__trans('Undecided');
															}else if($val == -2){
																$repaymentOpt = Yii::app()->controller->__trans('Consultation');
															}else if($val == -5){
																$repaymentOpt = Yii::app()->controller->__trans('Sliding');
															}
															$amortizationDetails .= $repaymentOpt.(count($amortizationArray) > 2 ? '('.$fName.')'.$slsh : '');
														}
														$z++;
													}
												}else{
													foreach($repaymentMonthArray as $key=>$val){
														if($z == count($repaymentMonthArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														$amortizationDetails .= ($val != "" ? $val.'ヶ月' : "").(count($repaymentMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
														$z++;
													}
												}
												$contractOptArray = array();
                                                foreach($floorDetails as $floor){
                                                    $floorId = Floor::model()->findByPk($floor['floor_id']);
                                                    if(isset( $floorId['contract_period_duration']) &&  $floorId['contract_period_duration'] != ''){
                                                        $contractArray[] = $floorId['contract_period_duration'];
														$contractOptArray[] =  $floorId['contract_period_opt'];
                                                    }
                                                }
												
												
                                                $contractdiff= array_diff_assoc($contractArray, array_unique($contractArray));
                                            ?>
                                                <caption style="background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold; width:230px"><font><font><?php echo Yii::app()->controller->__trans('Contractual coverage'); ?></font></font></caption>
                                                <tbody>
                                                    <tr>
                                                        <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;"><font><font><?php echo Yii::app()->controller->__trans('Contractual life'); ?></font></font></th><!--fixed texts-->
                                                        <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
                                                            <font><font>
                                                            <?php
                                                            if(count($contractdiff) > 0){
                                                                echo min($contractArray).(min($contractArray) != max($contractArray) ? ' ~ '.max($contractArray).' 年' : ' 年');
                                                            }else{
                                                                $contactVar = array_values($contractArray);
                                                                if($contactVar[0] != ""){
                                                                    echo $contactVar[0].' 年';
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                            ?>
                                                            </font></font>
                                                            <?php
																$contractDefaultArray = array('1'=>'普通借家','2'=>'定借','3'=>'定借希望');
																foreach($contractDefaultArray as $key=>$val){
																	if(in_array($key,$contractOptArray)){
																		echo ' - '.$val;
																		break;
																	}
																}
															?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
                                                            <font><font>更新費</font></font>
                                                        </th>
                                                        <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
                                                        	<?php
                                                            	echo $renewalDetails;
															?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
                                                            <font><font>礼金</font></font>
                                                        </th>
                                                        <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
															<?php
                                                            	echo $keyMoneyDetails;
															?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
                                                            <font><font>償却費</font></font>
                                                        </th>
                                                        <td style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">
                                                        	<?php
                                                            	echo $amortizationDetails;
															?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="summary time-to-use" style="border-collapse: collapse;  margin-bottom: 10mm;">
                                                <?php
                                                if(isset($requestData['print_time_floor']) || isset($requestData['print_time_entrance'])){
                                                ?>
                                                <caption style="background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold; margin-bottom: 1mm;">使用時間</caption>
                                                <?php
                                                }
                                                if(isset($requestData['print_time_floor']) == 1){
                                                    $limit_of_usage_time =  array();
                                                    if(isset($buildCart['limit_of_usage_time']) && $buildCart['limit_of_usage_time'] != ''){
                                                ?>
                                                <tr>
                                                    <th rowspan="3" style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">使用時間</th>
                                                    <td style="font-size: 8pt; line-height: 1;">
                                                        <?php
                                                            $limit_of_usage_time = explode(',',$buildCart['limit_of_usage_time']);
                                                            $limitTimeExplode = explode('-',$limit_of_usage_time[0]);
                                                            if($limitTimeExplode[0] == 1){
                                                                echo '平日 : '.Yii::app()->controller->__trans('Nothing');
                                                            }else if($limitTimeExplode[0] == 2){
                                                                echo '平日： 制限有り('.$limitTimeExplode[1].')';
                                                            }else if($limitTimeExplode[0] == 3){
                                                                echo ' 平日 : '.Yii::app()->controller->__trans('unknown');
                                                            }else{
                                                                echo '-';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 8pt; line-height: 1;">
                                                        <?php
                                                            if(isset($limit_of_usage_time[1]) && count($limit_of_usage_time[1]) > 0){
                                                                $limitTimeExplode2 = explode('-',$limit_of_usage_time[1]);
                                                                if($limitTimeExplode2[0] == 1){
                                                                    echo '土曜 : '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($limitTimeExplode2[0] == 2){
                                                                    echo '土曜： 制限有り('.$limitTimeExplode2[1].')';
                                                                }else if($limitTimeExplode2[0] == 3){
                                                                    echo '土曜 : '.Yii::app()->controller->__trans('unknown');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 8pt; line-height: 1;">
                                                        <?php
                                                            if(isset($limit_of_usage_time[2]) && count($limit_of_usage_time[2]) > 0){
                                                                $limitTimeExplode3 = explode('-',$limit_of_usage_time[2]);
                                                                if($limitTimeExplode3[0] == 1){
                                                                    echo '休日： '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($limitTimeExplode3[0] == 2){
                                                                    echo '休日： 制限有り('.$limitTimeExplode3[1].')';
                                                                }else if($limitTimeExplode3[0] == 3){
                                                                    echo '休日： '.Yii::app()->controller->__trans('unknown');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <br/>
                                                <?php
                                                    }
                                                }
                                                if(isset($requestData['print_time_entrance'] ) == 1){
                                                ?>
                                                <tr>
                                                    <th rowspan="3" style=" font-size: 8pt; border: none; text-align: left; padding: 0;  width: 21mm;">正面玄関</th>
                                                    <td style="font-size: 6pt; line-height: 1;">
                                                        <?php
                                                            $opTimeExp = $opTimeExplode = array();
                                                            if(isset($buildCart['ent_op_cl_time']) && $buildCart['ent_op_cl_time'] != ''){
                                                                $opTimeExp = explode(',',$buildCart['ent_op_cl_time']);
                                                                $opTimeExplode = explode('-',$opTimeExp[0]);
                                                                if($opTimeExplode[0] == 1){
                                                                    echo '平日： '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($opTimeExplode[0] == 2){
                                                                    echo '平日： 制限有り('.$opTimeExplode[1].')';
                                                                }else if($opTimeExplode[0] == 3){
                                                                    echo '平日：'.Yii::app()->controller->__trans('unknown');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 8pt; line-height: 1;">
                                                        <?php
                                                            if(isset($opTimeExp[1]) && count($opTimeExp[1]) > 0){
                                                                $opTimeExplode2= explode('-',$opTimeExp[1]);
                                                                if($opTimeExplode2[0] == 1){
                                                                    echo '土曜 : '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($opTimeExplode2[0] == 2){
                                                                    echo '土曜： 制限有り('.$opTimeExplode2[1].')';
                                                                }else if($opTimeExplode2[0] == 3){
                                                                    echo '土曜 : '.Yii::app()->controller->__trans('unknown');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 8pt; line-height: 1;">
                                                        <?php
                                                            if(isset($opTimeExp[2]) && count($opTimeExp[2])>0){
                                                                $opTimeExplode3= explode('-',$opTimeExp[2]);
                                                                if($opTimeExplode3[0] == 1){
                                                                    echo '休日： '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($opTimeExplode3[0] == 2){
                                                                    echo '休日： 制限有り('.$opTimeExplode3[1].')';
                                                                }else if($opTimeExplode3[0] == 3){
                                                                    echo '休日：'.Yii::app()->controller->__trans('unknown');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                        <?php
                                                            }
                                                    }
                                                    ?>
                                                </tr><br/>
                                            </table>
                                            <?php
                                            if($buildCart['exp_rent_disabled'] != 1){
                                                $expRent = array();
                                                if(isset($buildCart['exp_rent']) && $buildCart['exp_rent'] != ''){
                                                    $expRent = explode('-',$buildCart['exp_rent']);
                                                    if($expRent[0] != ""){
                                                        $expVal = explode('~',$expRent[0]);
                                                        if($expVal[0] != "" || $expVal[1] != ""){
                                            ?>
                                            <table class="summary memo" style="border-collapse: collapse;">
                                                <caption style="background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold; margin-bottom: 1mm;">
                                                    備考
                                                </caption>
                                                <tr>
                                                    <th>見込賃料</th>
                                                    <td>
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
                                                            echo isset($expRent[1]) && $expRent[1] == 1 ? Yii::app()->controller->__trans('(共益費含む)') : Yii::app()->controller->__trans('(共益費含まない)');
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <?php														
                                                            if($buildCart['notes'] != ""){
																echo $buildCart['notes'];
															}
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="plan-img">
                                <?php
                                    $planPictureDetails = PlanPicture::model()->findAll('building_id = '.$buildCart['building_id'].' order by plan_picture_id desc');
									
                                    if(isset($planPictureDetails) && count($planPictureDetails) > 0){
										$latesPlan = array();
                                        foreach($planPictureDetails as $plan){
                                            $latesPlan[] = $plan->name;
                                        }
                                        //$latesPlan = end($latesPlan);
										
										$latesPlan = reset($latesPlan);
										
									}else{
                                        $latesPlan = 'no_plan.jpg';
                                    }
                                ?>
                                <img src="<?php echo Yii::app()->baseUrl.'/planPictures/'.$latesPlan; ?>" style=" width: 100%;" />
                            </td>
                        </tr>
               	</table>
           	</section>
<?php
			}
			elseif(count($floorDetails) > 9  && count($floorDetails)  <= 22 ) {}
			elseif(count($floorDetails)  > 22 ) {}
			$buildingNumber++;
		}
	}
	if(isset($requestData['print_map']) && $requestData['print_map'] == 1) {
?>
	<div id="map" class="sheet" style="width: 297mm; height: 1000px;"></div>
    <script src="http://maps.google.com/maps/api/js?key=<?php echo $gApiKey; ?>&v=3" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/markerwithlabel.js"></script>
    <style>
	.labels {
	    background: #fff;
		width: auto;
		height: auto;
		padding: 5px;
		text-align: center;
		line-height: 1em;
		font-size: 14px;
		color: #000;
		border: 5px solid red;
		font-weight: bold;
	}
	</style>
    <script type="text/javascript">
		var locations = <?php echo json_encode($array); ?>;
		var buildName = <?php echo json_encode($buildNameArray); ?>
		
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 10,
			center: new google.maps.LatLng(36.6733301,135.2284552),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		
		var infowindow = new google.maps.InfoWindow();
		var marker, i;
		var image = '<?php echo Yii::app()->baseUrl.'/images/icon.png';?>';			
		
		var latlngbounds = new google.maps.LatLngBounds();
		for (i = 0; i < locations.length; i++) { 
			console.log(buildName[i]);
			var splitLatLong = locations[i].split(',');
			var lat = splitLatLong[0];
			var long = splitLatLong[1];
			/*var marker = new google.maps.Marker({
				position: new google.maps.LatLng(lat,long),
				map: map,
				label: { text: buildName[i] },
				labelContent: buildName[i],
				labelAnchor: new google.maps.Point(15, 65),
				labelClass: "labels", // the CSS class for the label
				labelInBackground: false,
				//label: buildName[i],
				icon: pinSymbol('red'),
				//icon: 'http://chart.apis.google.com/chart?chst='+buildName[i]+'&chld=' + k + '|FF0000|000000',
				//animation: google.maps.Animation.BOUNCE,
				//icon : image,
				visible: true
			});*/
			var marker = new MarkerWithLabel({
				position: new google.maps.LatLng(lat,long),
				map: map,
				labelContent: (i+1)+'. '+buildName[i],
				//labelAnchor: new google.maps.Point(lat,long),
				labelClass: "labels",
				//labelInBackground: false,
				//icon: image,
				icon: {},
				//animation: google.maps.Animation.BOUNCE,
				visible: true
			});
			
			/*marker.info = new google.maps.InfoWindow({
			  content: buildName[i],
			});
			
			google.maps.event.addListener(marker, 'click', function() {
			  marker.info.open(map, marker);
			});*/
			
			/*var iw = new google.maps.InfoWindow({
				content: buildName[i],
			});
			google.maps.event.addListener(marker, "click", function(e) {
				iw.open(map, this);
			});*/
			
			latlngbounds.extend(marker.position);
		}
		//Get the boundaries of the Map.
		var bounds = new google.maps.LatLngBounds();
		//Center map and adjust Zoom based on the position of all markers.
		map.setCenter(latlngbounds.getCenter());
		map.fitBounds(latlngbounds);
		
		marker.setMap(map);
	</script>
<?php
	}
}
?>