<?php

/*$getTrainCorporations = file_get_contents('http://api.ekispert.com/v1/json/line?&prefectureCode=3&key=LE_sPqb4mJja7QXp');
$corporationArray = json_decode($getTrainCorporations,true);
echo "<pre>";
print_r($corporationArray);*/

$getPrefectureDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=2&ar=eq&ac=13&output=json');
$districtArray = json_decode($getPrefectureDistrict,true);
echo "<pre>";
print_r($districtArray);
die;

?>



<!--<link class="css" rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->baseUrl; ?>/expGuiCondition/expCss/expGuiCondition.css">
<script type="text/javascript" src="<?php //echo Yii::app()->baseUrl; ?>/expGuiCondition/expGuiCondition.js?key=LE_sPqb4mJja7QXp" charset="UTF-8"></script>-->
<!--<script type="text/javascript" src="<?php //echo Yii::app()->baseUrl; ?>/expGuiCourseLight/expGuiCourseLight.js?key=LE_sPqb4mJja7QXp" charset="UTF-8"></script>-->
<?php
/*$trainRoutes = file_get_contents('http://api.ekispert.com/v1/json/corporation?key=LE_sPqb4mJja7QXp&type=train');
$routeWithNames = json_decode($trainRoutes,true);

$maxValue = $routeWithNames['ResultSet']['max'];
$pagesWithoutRound = $maxValue / 100;
$pages = round($maxValue / 100);
$pageSummation = $pages - $pagesWithoutRound;
if($pageSummation < 0){
	$pages = $pages+1;
}
$firstOffsetVal = $routeWithNames['ResultSet']['offset'];
$offsetVal = '';
$finalArray = array();
for($i=0;$i<$pages;$i++){
	$trainRouteList = file_get_contents('http://api.ekispert.com/v1/json/corporation?key=LE_sPqb4mJja7QXp&type=train&offset='.$firstOffsetVal);
	
	$trainRouteList = json_decode($trainRouteList,true);
	foreach($trainRouteList['ResultSet']['Corporation'] as $loop){
		$finalArray[] = $loop;
	}	
	$totalCounts = count($trainRouteList['ResultSet']['Corporation']);
	$firstOffsetVal = $totalCounts+1;
}

foreach($finalArray as $tRoute){
	$model = new TrainRoute;
	$model->code = $tRoute['code'];
	$model->name = $tRoute['Name'];
	$model->type = $tRoute['Type'];
	if($model->save(false)){
		echo "Success";
	}else{
		echo "Fail";
	}
}
die;*/

/*$trainStations = file_get_contents('http://api.ekispert.com/v1/json/station?key=LE_sPqb4mJja7QXp&name=%E6%9D%B1%E4%BA%AC&type=train&corporationBind=%EF%BC%AA%EF%BC%B2');
$stationWithNames = json_decode($trainStations,true);
echo "<pre>";
print_r($stationWithNames);
die;*/

?>
<script>
(function($){
	$(function(){
		//初期設定
		var pref = $('#pref'); //都道府県が入るselect
		var line = $('#line'); //路線が入るselect
		var station = $('#station'); //駅名が入るselect
		
		//最初に都道府県を読み込む
		$.getJSON('http://express.heartrails.com/api/json?method=getPrefectures&callback=?',function(json){
			$.each(json.response.prefecture,function(key,value){
				var txt = String(this); //都道府県名が配列で帰ってきてたので文字列に変換・・・
				pref.append('<option value="'+txt+'">'+txt+"</option>");
			});
		});
		
		//都道府県から路線を検索
		pref.on('change',function(){
			$.getJSON('http://express.heartrails.com/api/json?method=getLines&callback=?',
			{prefecture:pref.val()},
			function(json){
				line.children().not(':first').remove();//一つ目のoption(選択してください）のみ残して削除
				station.children().not(':first').remove();//都道府県が変わるときに駅選択も初期化する
				$.each(json.response.line,function(key,value){
					var txt = String(this);
					line.append('<option value="'+txt+'">'+txt+"</option>");
				});
			});
		});
		
		//路線から駅名を検索
		line.on('change',function(){
			$.getJSON('http://express.heartrails.com/api/json?method=getStations&callback=?',
			{line:line.val()},
			function(json){
				station.children().not(':first').remove();//一つ目のoption(選択してください）のみ残して削除
				$.each(json.response.station,function(key,value){
					if(this.prefecture == pref.val()){ //路線内の駅のうち選択された都道府県内のものだけを絞り込み
						var txt = String(this.name); //駅名の場合郵便番号や経度緯度などが配列として入っているので名称のみ絞り込み
						station.append('<option value="'+txt+'駅">'+txt+"駅</option>");//○○「駅」が入ってないので無理やり付ける
					}
				});
			});
		});
 
 
	});
})(jQuery);
</script>

<table>
  <tr>
    <th>都道府県名</th>
    <td><select id="pref">
        <option value="">都道府県を選択してください</option>
      </select></td>
  </tr>
  <tr>
    <th>路線名</th>
    <td><select id="line">
        <option value="">路線を選択してください</option>
      </select></td>
  </tr>
  <tr>
    <th>駅名</th>
    <td><select id="station">
        <option value="">駅を選択してください</option>
      </select></td>
  </tr>
</table>