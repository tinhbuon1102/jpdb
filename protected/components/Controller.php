<?php
//header('Content-Type: text/html; charset=utf-8');
/**

* Controller is the customized base controller class.

* All controller classes for this application should extend from this base class.

*/

class Controller extends CController {

	/**

	* @var string the default layout for the controller view. Defaults to '//layouts/column1',

	* meaning using a single column layout. See 'protected/views/layouts/column1.php'.

	*/

	public $layout='//layouts/column1';

	/**

	* @var array context menu items. This property will be assigned to {@link CMenu::items}.

	*/

	public $menu=array();

	/**

	* @var array the breadcrumbs of the current page. The value of this property will

	* be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}

	* for more details on how to specify this property.

	*/

	public $breadcrumbs=array();


	public static function renderPrice($price, $subfix = false) {
		if(is_numeric($price)){
			$price = number_format($price);
		}
		return ($subfix && $price) ? $price . Yii::app()->controller->__trans('yen / tsubo') : $price;
	}

	public static function getBuildingVendorType(){
		return array(
				1 => Yii::app()->controller->__trans('owner'),
				6 => 'サブリース',
				7 => '貸主代理',
				8 => 'AM',
				10 => '業者',
				4 => Yii::app()->controller->__trans('intermediary agent'),
				2 => Yii::app()->controller->__trans('management company'),
				9 => Yii::app()->controller->__trans('PM'),
				3 => Yii::app()->controller->__trans('general contractor'),
				-1 => Yii::app()->controller->__trans('unknown'),
		);
	}
	

	public static function getBuildingFormMapper()
	{
		$mapper = array(
				'areaMinValue' => array(
						'name' => '下限(坪)',
						'parent' => '面積'
				),
				'areaMaxValue' => array(
						'name' => '上限(坪)',
						'parent' => '面積'
				),
				'floorMin' => array(
						'name' => '階',
						'parent' => '面積'
				),
				'floorMax' => array(
						'name' => '階',
						'parent' => 'フロア'
				),
				'updateDateDrop' => array(
						'name' => '更新日',
				),
				'brokerageFree' => array(
						1 => array(
								'name' => '手数料有りの物件のみ',
								'parent' => '手数料'
						),
				),
				'unitMinValue' => array(
						'name' => '下限(万円) ',
						'parent' => '単価'
				),
				'unitMaxValue' => array(
						'name' => '上限(万円)',
						'parent' => '単価'
				),
				'buildingAge' => array(
						'name' => '年以降に竣工',
						'parent' => '築年'
				),
				'possibleDataMin' => array(
						'name' => '下限(坪)',
						'parent' => '面積'
				),
				'possibleDataMax' => array(
						'name' => '入居可能日',
				),
				'specifyCustomerName' => array(
						'name' => '顧客名を指定',
				),


				'costMinAmount' => array(
						'name' => '下限',
						'parent' => '総額',
						'append' => '円'
				),
				'costMaxAmount' => array(
						'name' => '上限',
						'parent' => '総額',
						'append' => '円'
				),
				'statusRequirement' => array(
						1 => array(
								'name' => '募集中',
								'parent' => '募集状況'
						),
						2 => array(
								'name' => '1年以内に空き予定',
								'parent' => '募集状況'
						),
						3 => array(
								'name' => '満室',
								'parent' => '募集状況'
						),

				),

				'requirementOfBuilding' => array(
						1 => array(
								'name' => 'ビルに募集中フロアが有る場合は全て表示する',
								'parent' => 'ビル内募集'
						),
				),
				'deadlineCheck' => array(
						1 => array(
								'name' => '期限付き建物',
						),
				),
				'facilities' => array(
						1 => array(
								'name' => '男女別トイレ',
								'parent' => '設備'
						),
						2 => array(
								'name' => 'OAフロア',
								'parent' => '設備'
						),
						3 => array(
								'name' => '個別空調',
								'parent' => '設備'
						),
						4 => array(
								'name' => 'フロア分割可',
								'parent' => '設備'
						),
						5 => array(
								'name' => '耐震補強',
								'parent' => '設備'
						),
						6 => array(
								'name' => '一棟貸し可',
								'parent' => '設備'
						),
						7 => array(
								'name' => '緊急発電装置対応',
								'parent' => '設備'
						),
				),

				'floorType' => array(
						1 => array(
								'name' => '事務所',
								'parent' => 'フロア種別'
						),
						2 => array(
								'name' => '店舗',
								'parent' => 'フロア種別'
						),
						3 => array(
								'name' => 'ショールーム',
								'parent' => 'フロア種別'
						),
						5 => array(
								'name' => '倉庫',
								'parent' => 'フロア種別'
						),
						6 => array(
								'name' => '住居',
								'parent' => 'フロア種別'
						),
						7 => array(
								'name' => '駐車場',
								'parent' => 'フロア種別'
						),
						8 => array(
								'name' => '軽飲食',
								'parent' => 'フロア種別'
						),
						9 => array(
								'name' => '重飲食',
								'parent' => 'フロア種別'
						),
						10 => array(
								'name' => '医院',
								'parent' => 'フロア種別'
						),
						11 => array(
								'name' => 'エステ',
								'parent' => 'フロア種別'
						),
						12 => array(
								'name' => '教室',
								'parent' => 'フロア種別'
						),
						13 => array(
								'name' => '物販',
								'parent' => 'フロア種別'
						),
						14 => array(
								'name' => 'レンタルオフィス',
								'parent' => '設備'
						),
				),

				'formTypeList' => array(
						1 => array(
								'name' => '貸主',
								'parent' => '取引形態'
						),
						2 => array(
								'name' => '代理',
								'parent' => '取引形態'
						),
						3 => array(
								'name' => '一般媒介',
								'parent' => '取引形態'
						),
						4 => array(
								'name' => '専任媒介',
								'parent' => '取引形態'
						),
						7 => array(
								'name' => '不明',
								'parent' => '取引形態'
						),
				),

				'lenderType' => array(
						1 => array(
								'name' => '貸主',
								'parent' => '貸主/業者 種別'
						),
						6 => array(
								'name' => '業者',
								'parent' => '貸主/業者 種別'
						),
						0 => array(
								'name' => '不明',
								'parent' => '貸主/業者 種別'
						),
				),

				'walkFromStation' => array(
						3 => array(
								'name' => '3分以内',
								'parent' => '駅からの徒歩'
						),
						5 => array(
								'name' => '5分以内',
								'parent' => '駅からの徒歩'
						),
						10 => array(
								'name' => '10分以内',
								'parent' => '駅からの徒歩'
						),
						15 => array(
								'name' => '15分以内',
								'parent' => '駅からの徒歩'
						),
				),

				'shortRent' => array(
						1 => array(
								'name' => '短期貸し対応',
								'parent' => '短期貸し対応'
						),
				),
				'hdnRRouteId' => array(
						'name' => '',
						'append' => '駅'

				),
				'buildingSearchAddressTxt' => array(
						'name' => 'ビルの住所に',
				),
				'buildingSearchAddress' => array(
						'name' => 'ビルの住所に',
				),
				'buildingSearchName' => array(
						'name' => 'ビル名',
				),
				'buildingSearchId' => array(
						'title' => 'ビルID指定',
				),
				'floorSearchId' => array(
						'title' => 'フロアID指定',
				),
				'floorSearchOwnerName' => array(
						'loop' => 1,
						'name' => 'オーナー・業者名',
				),



				// Do prefecter, district, town here
		);
		return $mapper;
	}

	public static function getTokyoCorporateLines()
	{
		$aTokyoLines = array();
		$aTokyoLines['JR'] = array(
				'JR中央線',
				'JR中央本線',
				'JR五日市線',
				'JR京浜東北線',
				'JR京葉線',
				'JR八高線',
				'JR南武線',
				'JR埼京線',
				'JR宇都宮線',
				'JR山手線',
				'JR常磐線各駅停車',
				'JR常磐線快速',
				'JR東海道本線',
				'JR横浜線',
				'JR横須賀線',
				'JR武蔵野線',
				'JR湘南新宿ライン',
				'JR総武線',
				'JR総武線快速',
				'JR青梅線',
				'JR高崎線',
				'上越新幹線',
				'東北新幹線',
				'北陸新幹線',
				'JR上野東京ライン',
		);
		$aTokyoLines['東京メトロ'] = array(
				'東京メトロ丸ノ内分岐線',
				'東京メトロ丸ノ内線',
				'東京メトロ千代田線',
				'東京メトロ半蔵門線',
				'東京メトロ南北線',
				'東京メトロ日比谷線',
				'東京メトロ有楽町線',
				'東京メトロ東西線',
				'東京メトロ銀座線',
				'東京メトロ副都心線',);

		$aTokyoLines['西武鉄道'] = array(
				'西武国分寺線',
				'西武多摩川線',
				'西武多摩湖線',
				'西武山口線',
				'西武拝島線',
				'西武新宿線',
				'西武有楽町線',
				'西武池袋線',
				'西武西武園線',
				'西武豊島線',);

		$aTokyoLines['東武鉄道'] = array(
				'東武亀戸線',
				'東武伊勢崎線',
				'東武大師線',
				'東武東上本線',
				'東海道新幹線',);


		$aTokyoLines['東急電鉄'] = array(
				'東急世田谷線',
				'東急多摩川線',
				'東急大井町線',
				'東急東横線',
				'東急池上線',
				'東急田園都市線',
				'東急目黒線',);

		$aTokyoLines['都営地下鉄'] = array(
				'都営三田線',
				'都営大江戸線',
				'都営新宿線',
				'都営浅草線',
				'都電荒川線',
				'日暮里・舎人ライナー',);

		$aTokyoLines['京王電鉄'] = array(
				'京王線',
				'京王新線',
				'京王井の頭線',
				'京王相模原線',
				'京王高尾線',
				'京王動物園線',
				'京王競馬場線',);

		$aTokyoLines['京成電鉄'] = array(
				'京成押上線',
				'京成本線',
				'京成金町線',
				'京成成田空港線',);

		$aTokyoLines['京浜急行電鉄'] = array(
				'京浜急行本線',
				'京浜急行空港線',);

		$aTokyoLines['小田急電鉄'] = array(
				'小田急多摩線',
				'小田急小田原線',);


		$aTokyoLines['多摩都市モノレール'] = array(
				'多摩モノレール',);

		$aTokyoLines['東京臨海高速鉄道'] = array(
				'東京りんかい線',);

		$aTokyoLines['北総鉄道'] = array(
				'北総鉄道',);

		$aTokyoLines['ゆりかもめ'] = array(
				'新交通ゆりかもめ',);

		$aTokyoLines['埼玉高速鉄道'] = array(
				'埼玉高速鉄道',);


		$aTokyoLines['つくばエクスプレス'] = array(
				'つくばエクスプレス線',);

		$aTokyoLines['その他'] = array(
				'東京モノレール羽田線',
				'上野モノレール',
				'御岳登山鉄道',
				'高尾登山電鉄線',);
		return $aTokyoLines;
	}
	
	public static function getTokyoLinesCorporate() {
		$aCorporate = self::getTokyoCorporateLines();
		$aLines = array();
		foreach ($aCorporate as $coporate => $lines)
		{
			foreach ($lines as $line)
			{
				$aLines[$line] = $coporate;
			}
		}
		return $aLines;
	}

	public static function __trans($word, $default_lang = 'en'){
		global $glob_language;
		$glob_language = $glob_language ? $glob_language : 'ja';
		
		if (($glob_language == 'ja' && $default_lang == 'ja') || ($glob_language == 'en' && $default_lang == 'en'))
		{
			return $word;
		}
		else {
			$transaltionDetails = WordTranslation::model()->find("word = '".$word."'");
			if(isset($transaltionDetails) && count($transaltionDetails) > 0 && !empty($transaltionDetails)){
				return $transaltionDetails['translation'];
			}else{
				return $word;
			}
		}
	}

  public static function __getConditionsForView($req)
  {
    $req = (array)$req;
    Yii::import('application.controllers.BuildingController');

    $return = array();
    if (isset($req['districtTownList']) && !empty($req['districtTownList'])) {
      // Get district
      $criteria = new CDbCriteria();
      $criteria->addInCondition('code', $req['districtTownList']);
      $townList = Town::model()->findAll($criteria);

      if (!empty($townList)) {
        foreach ($townList as $town) {
          $return[$town['code']] = $town['town_name'];
        }
      }
    }
    return $return;
  }

	public static function __getCondition($req){ $retData = ''; $req = (array)$req;
		Yii::import('application.controllers.BuildingController');
		
		if (is_string($req['districtTownList'])) {
			$req['districtTownList'] = explode(',', $req['districtTownList']);
		}
	
		$buildingFormMapper = Yii::app()->controller->getBuildingFormMapper();
		
		$prefecture_id = (isset($req['pre-list']) && $req['pre-list']) ? $req['pre-list'] : $req['hdnRPrefId'];
		if ($prefecture_id){
			$prefecture = Prefecture::model()->findByPk($prefecture_id);
			/*$buildingFormMapper['pre-list']['name'] = '都道府県';
			$buildingFormMapper['pre-list']['value'] = $prefecture['prefecture_name'];*/
			if (isset($req['prefectureDistrictlist']) && $req['prefectureDistrictlist']){
				// Get district
				$districtList = (BuildingController::actionGetDisctrictList($req['pre-list'], true));
				if (!empty($districtList)){
					foreach ($districtList as $district){
						if ($district['id'] == $req['prefectureDistrictlist']){
							/*$buildingFormMapper['prefectureDistrictlist']['name'] = '市町村区';
							$buildingFormMapper['prefectureDistrictlist']['value'] = $district['name'];*/
						// Get Town
						if (isset($req['districtTownList']) && !empty($req['districtTownList'])){
						// Get district
              $criteria = new CDbCriteria();
              $criteria->addInCondition('code', $req['districtTownList']);
              $townList = Town::model()->findAll($criteria);

						if (!empty($townList)){
							foreach ($townList as $town){
								$buildingFormMapper['districtTownList'][$town['code']] = array(
									'parent' => '町名',
									'name' => $town['town_name']
								);
							}
						}
						}
						}
					}
				}
			}
		}
		
		if (isset($req['hdnRailId']) && $req['hdnRailId']){
			if (isset($req['hdnLineId']) && $req['hdnLineId']){
				if (isset($req['hdnRRouteId']) && $req['hdnRRouteId']){
					$buildingFormMapper['hdnRRouteId']['name'] = '';
					$buildingFormMapper['hdnRRouteId']['value'] = $req['hdnRRouteId'];
				}
			}
		}

		foreach ($req as $form_key => $form_value){
			if (isset($buildingFormMapper[$form_key])){
				if ($form_value && is_array($form_value) && !empty($form_value)){
					$retData .= '<li>';	$countLoop = 0;
					foreach ($form_value as $value){	$countLoop++;
						if ($countLoop == 1){
							$retData .= '<span class="condition_name condition_name_list">'. $buildingFormMapper[$form_key][$value]['parent'] .': <span>';
						}
						$retData .= '<span class="condition_value condition_name_list">'. $buildingFormMapper[$form_key][$value]['name'] .'<span>';

						if ($countLoop != count($form_value)){
							$retData .= ', ';
						}
					}
					$retData .= '</li>';
				}elseif($form_value && isset($buildingFormMapper[$form_key]['loop']) && !empty($form_value)){
					$form_value = preg_split('/\r\n|[\r\n]/', $form_value);
					foreach($form_value as $fvals){
						$retData .= '<li><span class="condition_name condition_name_list">'. $buildingFormMapper[$form_key]['name'] .': <span>';
						$retData .= '<span class="condition_name condition_name_list">'. $fvals .'<span></li>';
					}
				}elseif ($form_value && isset($buildingFormMapper[$form_key]['title'])) {
					$retData .= '<li>';
					$retData .= '<span class="condition_name condition_name_list">'. $buildingFormMapper[$form_key]['title'] .'<span>';
					$retData .= '</li>';
				}elseif ($form_value && !isset($buildingFormMapper[$form_key]['name'])) {
					$retData .= '<li>';
					if ($buildingFormMapper[$form_key][$form_value]['parent']){
						$retData .= '<span class="condition_name condition_name_list">'. $buildingFormMapper[$form_key][$form_value]['parent'] .': <span>';
					}
					$retData .= '<span class="condition_name condition_name_list">'. $buildingFormMapper[$form_key][$form_value]['name'] .'<span>';
					$retData .= '</li>';
				}elseif ($form_value && $form_value != '-'){
					$retData .= '<li>';
					$retData .= '<span class="condition_name">'. $buildingFormMapper[$form_key]['name'] .($buildingFormMapper[$form_key]['name'] != '' ? ':' : '').' <span>';
					$retData .= '<span class="condition_name">'. (isset($buildingFormMapper[$form_key]['value']) ? $buildingFormMapper[$form_key]['value'] : $form_value) .'<span>';
				if (isset($buildingFormMapper[$form_key]['append'])){
					$retData .= '<span class="condition_append">'. $buildingFormMapper[$form_key]['append'] .'<span>';
				}
				$retData .= '</li>';
				}
			}
		}
		return $retData;
	}
	
	public static function getParamsfromString($data){ $return = array();
		foreach($data as $key=>$fdata){ $fdata = (array)$fdata;
			if(strpos($fdata['name'],'[]') !== false){
				if(!isset($return[$fdata['name']])) $return[$fdata['name']] = array();
				$name = str_replace('[]','',$fdata['name']);;
				$return[$name][] = $fdata['value'];
			}else{
				$return[$fdata['name']] = $fdata['value'];
			}
		}
		return $return;
	}
	
	public static function getAddressDataCSVFromPostalCode($zipcode)
	{
		$dir = YiiBase::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'dataAddress' . DIRECTORY_SEPARATOR . 'zipcode';
		
		$zipcode = mb_convert_kana($zipcode, 'a', 'utf-8');
		$zipcode = str_replace(array('-','ー'),'', $zipcode);
		
		$result = array();
		
		$file = $dir . DIRECTORY_SEPARATOR . substr($zipcode, 0, 1) . '.csv';
		if(file_exists($file)){
			$spl = new SplFileObject($file);
			while (!$spl->eof()) {
				$columns = $spl->fgetcsv();
				if(isset($columns[0]) && $columns[0] == $zipcode){
					$result = array($columns[1], $columns[2], $columns[3], $columns[4]);
					break;
				}
			}
		}
		return $result;
	}
}