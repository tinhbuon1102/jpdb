<?php
class MarketInfoController extends Controller{
	public function actionIndex(){
		$this->pageTitle = Yii::app()->controller->__trans('Market Info').' | '.Yii::app()->params['name'];
		$regionList = Region::model()->findAll();
		$this->render('index',array('regionList'=>$regionList));
	}
	
	public function actionGetRegionPrefecture(){
		$region = $_REQUEST['region'];
		$getRegionDetails = Region::model()->findByPk($region);
		$prefectures = explode(',',$getRegionDetails['prefectures']);
		$prefectureList = Prefecture::model()->findAllByAttributes(array('prefecture_id'=>$prefectures));
		$buildingDetails = Building::model()->findAll();
		$addressArray = array();
		foreach($buildingDetails as $building){
			$addressArray[] = $building['address'];
		}
		
		$finalPrefectureArray = array();
		$finalPrefectureIdArray = array();
		foreach($prefectureList as $prefec){
			foreach($addressArray as $addr){
				if(strpos($addr,$prefec['prefecture_name']) !== false){
					$finalPrefectureArray[] = $prefec['prefecture_name'];
					$finalPrefectureIdArray[] = $prefec['prefecture_id'];
				}
			}
		}
		
		$finalPrefectuer = array_unique($finalPrefectureArray);
		$finalPrefectuer = array_values($finalPrefectuer);
		
		$finalPrefectuerId = array_unique($finalPrefectureIdArray);
		$finalPrefectuerId = array_values($finalPrefectuerId);
		
		$prefectureList = array();
		$i = 0;
		foreach($finalPrefectuer as $prefecture){
			$prefectureList[] = array('prefecture_id'=>$finalPrefectuerId[$i],'prefecture_name'=>$prefecture);
			$i++;
		}
		$resp = '<div class="tab_con">
					<ul class="tabs-city">';
						$i = 0;
						foreach($prefectureList as $prefec){
							$actPref = '';
							if($i == 0){
								$actPref = 'active';
							}
						$resp .= '<li class="'.$actPref.'"><a href="#" data-value="'.$prefec['prefecture_id'].'" class="tabPrefecture">'.$prefec['prefecture_name'].'</a></li>';
							$i++;
						}
						$code = $prefectureList[0]['prefecture_id'];
						if(strlen($code) == 1){
							$code = '0'.$code;
						}
						
						$checkDistrictAvailble = District::model()->findAll('prefecture_id = '.$code);						
						if(isset($checkDistrictAvailble) && count($checkDistrictAvailble) > 0 && !empty($checkDistrictAvailble)){
							foreach($checkDistrictAvailble as $district){
								$finalArray[] = array('id'=>$district['code'],'name'=>$district['district_name']);
							}
						}else{
							$getPrefectureDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=2e&ar=eq&ac='.$code.'&output=json&results=100');
							
							$districtArray = json_decode($getPrefectureDistrict,true);						
							$finalArray = array();
							if($districtArray['ResultInfo']['Total'] > $districtArray['ResultInfo']['Count']){
								$page = $districtArray['ResultInfo']['Total']/$districtArray['ResultInfo']['Count'];
								$pageRound = round($page);
								$pageSummation = $page-$pageRound;
								if($pageSummation > 0){
									$pageRound = $pageRound+1;
								}
								$start = $districtArray['ResultInfo']['Start'];
								for($i=1;$i<=$pageRound;$i++){
									$getPrefectureDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=2&ar=eq&ac='.$code.'&output=json&results=100&start='.$start);
									$districtArray = json_decode($getPrefectureDistrict,true);
									
									if(is_array($districtArray) && isset($districtArray['Feature'])){
										$resultCount = count($districtArray['Feature']);
										$start = ($resultCount*$i)+1;
										foreach($districtArray['Feature'] as $district){
											$finalArray[] = array('id'=>$district['Id'],'name'=>$district['Name']);
											$modelDistrict = new District;
											$modelDistrict->prefecture_id = $code;
											$modelDistrict->district_name = $district['Name'];
											$modelDistrict->code = $district['Id'];
											$modelDistrict->save(false);
										}
									}else{
										continue;
									}
								}
							}else{
								foreach($districtArray['Feature'] as $district){
									$finalArray[] = array('id'=>$district['Id'],'name'=>$district['Name']);
									$modelDistrict = new District;
									$modelDistrict->prefecture_id = $code;
									$modelDistrict->district_name = $district['Name'];
									$modelDistrict->code = $district['Id'];
									$modelDistrict->save(false);
								}
							}
						}
						
						$finalDistrictArray = array();
						$finalDistrictIdArray = array();
						foreach($finalArray as $final){
							foreach($addressArray as $addr){
								if(strpos($addr,$final['name']) !== false){
									$finalDistrictArray[] = $final['name'];
									$finalDistrictIdArray[] = $final['id'];
								}
							}
						}
						
						$finalDistrict = array_unique($finalDistrictArray);
						$finalDistrict = array_values($finalDistrict);
						
						$finalDistrictId = array_unique($finalDistrictIdArray);
						$finalDistrictId = array_values($finalDistrictId);
						
						$districtList = array();
						$i = 0;
						foreach($finalDistrict as $dist){
							$districtList[] = array('id'=>$finalDistrictId[$i],'name'=>$dist);
							$i++;
						}
		$resp .= '</ul>
					<div class="tabs_content2">
						<div class="tabDistrict">
							<ul class="prefecture">';
								if($region == 3){
									$resp .= '<li><a href="'.Yii::app()->createUrl('marketInfo/specificDistrictView').'">主要7区</a></li>';
								}
								foreach($districtList as $district){									
									$resp .= '<li><a href="'.Yii::app()->createUrl('marketInfo/districtView',array('district'=>$district['id'],'name'=>$district['name'])).'">'.$district['name'].'</a></li>';
								}
					$resp .= '</ul>
						</div>
					</div>
				</div>';
		echo json_encode($resp);
		die;
	}
	
	public function actionGetPrefectureDistrict(){
		$code = $_REQUEST['prefecture'];
		if(strlen($code) == 1){
			$code = '0'.$code;
		}
		
		$checkDistrictAvailble = District::model()->findAll('prefecture_id = '.$code);
		if(isset($checkDistrictAvailble) && count($checkDistrictAvailble) > 0 && !empty($checkDistrictAvailble)){
			foreach($checkDistrictAvailble as $district){
				$finalArray[] = array('id'=>$district['code'],'name'=>$district['district_name']);
			}
		}else{
			$getPrefectureDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=2e&ar=eq&ac='.$code.'&output=json&results=100');
			$districtArray = json_decode($getPrefectureDistrict,true);						
			$finalArray = array();
			if($districtArray['ResultInfo']['Total'] > $districtArray['ResultInfo']['Count']){
				$page = $districtArray['ResultInfo']['Total']/$districtArray['ResultInfo']['Count'];
				$pageRound = round($page);
				$pageSummation = $page-$pageRound;
				if($pageSummation > 0){
					$pageRound = $pageRound+1;
				}
				$start = $districtArray['ResultInfo']['Start'];
				for($i=1;$i<=$pageRound;$i++){
					$getPrefectureDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=2&ar=eq&ac='.$code.'&output=json&results=100&start='.$start);
					$districtArray = json_decode($getPrefectureDistrict,true);
					
					if(is_array($districtArray) && isset($districtArray['Feature'])){
						$resultCount = count($districtArray['Feature']);
						$start = ($resultCount*$i)+1;
						foreach($districtArray['Feature'] as $district){
							$finalArray[] = array('id'=>$district['Id'],'name'=>$district['Name']);
							$modelDistrict = new District;
							$modelDistrict->prefecture_id = $code;
							$modelDistrict->district_name = $district['Name'];
							$modelDistrict->code = $district['Id'];
							$modelDistrict->save(false);
						}
					}else{
						continue;
					}
				}
			}else{
				foreach($districtArray['Feature'] as $district){
					$finalArray[] = array('id'=>$district['Id'],'name'=>$district['Name']);
					$modelDistrict = new District;
					$modelDistrict->prefecture_id = $code;
					$modelDistrict->district_name = $district['Name'];
					$modelDistrict->code = $district['Id'];
					$modelDistrict->save(false);
				}
			}
		}
		
		$buildingDetails = Building::model()->findAll();
		$addressArray = array();
		foreach($buildingDetails as $building){
			$addressArray[] = $building['address'];
		}
		
		$finalDistrictArray = array();
		$finalDistrictIdArray = array();
		foreach($finalArray as $final){
			foreach($addressArray as $addr){
				if(strpos($addr,$final['name']) !== false){
					$finalDistrictArray[] = $final['name'];
					$finalDistrictIdArray[] = $final['id'];
				}
			}
		}
		
		$finalDistrict = array_unique($finalDistrictArray);
		$finalDistrict = array_values($finalDistrict);
		
		$finalDistrictId = array_unique($finalDistrictIdArray);
		$finalDistrictId = array_values($finalDistrictId);
		
		$districtList = array();
		$i = 0;
		foreach($finalDistrict as $dist){
			$districtList[] = array('id'=>$finalDistrictId[$i],'name'=>$dist);
			$i++;
		}
		
		$resp = '<ul class="prefecture1232">';
					foreach($districtList as $district){
						$resp .= '<li><a href="'.Yii::app()->createUrl('marketInfo/districtView',array('district'=>$district['id'],'name'=>$district['name'])).'">'.$district['name'].'</a></li>';
					}
		$resp .= '</ul>';
		echo json_encode($resp);
		die;
	}
	
	public function actionDistrictView(){
		$code = $_REQUEST['district'];
		$districtName = $_REQUEST['name'];
		$checkTownAvailble = District::model()->findAll('district_id = '.$code);
		
		if(isset($checkTownAvailble) && count($checkTownAvailble) > 0 && !empty($checkTownAvailble)){
			foreach($checkTownAvailble as $town){
				$finalArray[] = array('id'=>$town['code'],'name'=>$town['town_name']);
			}
		}else{
			$getDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=3&ar=eq&ac='.$code.'&output=json&results=100');
			$townArray = json_decode($getDistrict,true);
			$finalArray = array();
			if($townArray['ResultInfo']['Total'] > $townArray['ResultInfo']['Count']){
				$page = $townArray['ResultInfo']['Total']/$townArray['ResultInfo']['Count'];
				$pageRound = round($page);
				$pageSummation = $page-$pageRound;
				if($pageSummation > 0){
					$pageRound = $pageRound+1;
				}
				$start = $townArray['ResultInfo']['Start'];
				for($i=1;$i<=$pageRound;$i++){
					$getDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=3&ar=eq&ac='.$code.'&output=json&results=100&start='.$start);
					$townArray = json_decode($getDistrict,true);
					
					if(is_array($townArray) && isset($townArray['Feature'])){
						$resultCount = count($townArray['Feature']);
						$start = ($resultCount*$i)+1;
						foreach($townArray['Feature'] as $town){
							$finalArray[] = array('id'=>$town['Id'],'name'=>$town['Name']);
							$modelTown = new Town;
							$modelTown->district_id = $code;
							$modelTown->town_name = $town['Name'];
							$modelTown->code = $town['Id'];
							$modelTown->save(false);
						}
					}else{
						continue;
					}
				}
			}else{
				foreach($townArray['Feature'] as $town){
					$finalArray[] = array('id'=>$town['Id'],'name'=>$town['Name']);
				}
			}
		}
		
		$this->pageTitle = $districtName.' | '.Yii::app()->params['name'];
		$this->render('singleDistrict',array('townArray'=>$finalArray,'districtId'=>$code,'districtName'=>$districtName));
	}
	
	public function actionSaveSummary(){
		$content = $_REQUEST['content'];
		$district = $_REQUEST['district'];
		$summaryDetails = MarketInfo::model()->find('district_id = '.$district);
		if(isset($summaryDetails) && count($summaryDetails) > 0 && !empty($summaryDetails)){
			$summaryDetails->market_summary = $content;
			if($summaryDetails->save(false)){
				$resp = array('status'=>1,'content'=>$summaryDetails['market_summary']);
			}
		}else{
			$model = new MarketInfo;
			$model->district_id = $district;
			$model->market_summary = $content;
			if($model->save(false)){
				$resp = array('status'=>1,'content'=>$model['market_summary']);
			}
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionSaveAreaCommentary(){
		$content = $_REQUEST['content'];
		$district = $_REQUEST['district'];
		$areaCommentaryDetails = MarketInfo::model()->find('district_id = '.$district);
		if(isset($areaCommentaryDetails) && count($areaCommentaryDetails) > 0 && !empty($areaCommentaryDetails)){
			$areaCommentaryDetails->area_commentary = $content;
			if($areaCommentaryDetails->save(false)){
				$resp = array('status'=>1,'content'=>$areaCommentaryDetails['area_commentary']);
			}
		}else{
			$model = new MarketInfo;
			$model->district_id = $district;
			$model->area_commentary = $content;
			if($model->save(false)){
				$resp = array('status'=>1,'content'=>$model['area_commentary']);
			}
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionSaveMarketTrends(){
		$content = $_REQUEST['content'];
		$district = $_REQUEST['district'];
		$marketTrendsDetails = MarketInfo::model()->find('district_id = '.$district);
		if(isset($marketTrendsDetails) && count($marketTrendsDetails) > 0 && !empty($marketTrendsDetails)){
			$marketTrendsDetails->office_market_trends = $content;
			if($marketTrendsDetails->save(false)){
				$resp = array('status'=>1,'content'=>$marketTrendsDetails['office_market_trends']);
			}
		}else{
			$model = new MarketInfo;
			$model->district_id = $district;
			$model->office_market_trends = $content;
			if($model->save(false)){
				$resp = array('status'=>1,'content'=>$model['office_market_trends']);
			}
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionSaveNewlyAdd(){
		$content = $_REQUEST['content'];
		if(isset($content) && is_array($content)){
			$content = implode(',',$content);
		}
		$district = $_REQUEST['district'];
		$newlyAddDetails = MarketInfo::model()->find('district_id = '.$district);
		if(isset($newlyAddDetails) && count($newlyAddDetails) > 0 && !empty($newlyAddDetails)){
			if(isset($_REQUEST['remove']) && $_REQUEST['remove'] == 1){
				$newlyAddDetails->newly_developed = $content;
			}else{
				if($newlyAddDetails['newly_developed'] != ""){
					$newlyAddDetails->newly_developed = $newlyAddDetails['newly_developed'].','.$content;
				}else{
					$newlyAddDetails->newly_developed = $content;
				}
			}
			if($newlyAddDetails->save(false)){
				$newDeveloped = explode(',',$newlyAddDetails['newly_developed']);
				if(isset($newDeveloped) && count($newDeveloped) > 0 && !empty($newDeveloped)){
					$i = 0;
					foreach($newDeveloped as $newly){
						if($i == 0){
							$result = '<li data-value="'.$newly.'">'.$newly.' <i class="fa fa-trash-o removeNewlyAdd"></i></li>';
							
						}else{
							$result .= '<li data-value="'.$newly.'">'.$newly.' <i class="fa fa-trash-o removeNewlyAdd"></i></li>';
						}
						$i++;
					}
				}
				$resp = array('status'=>1,'content'=>$result);
			}
		}else{
			$model = new MarketInfo;
			$model->district_id = $district;
			$model->newly_developed = $content;
			if($model->save(false)){
				$newDeveloped = explode(',',$newlyAddDetails['newly_developed']);
				if(isset($newDeveloped) && count($newDeveloped) > 0 && !empty($newDeveloped)){
					$i = 0;
					foreach($newDeveloped as $newly){
						if($i == 0){
							$result = '<li data-value="'.$newly.'">'.$newly.' <i class="fa fa-trash-o removeNewlyAdd"></i></li>';
						}else{
							$result .= '<li data-value="'.$newly.'">'.$newly.' <i class="fa fa-trash-o removeNewlyAdd"></i></li>';
						}
						$i++;
					}
				}
				$resp = array('status'=>1,'content'=>$result);
			}
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionUploadAreaPicture(){		
		$extractFile = explode('.',$_FILES['areaPicture']['name']);
		$images_path = realpath(Yii::app()->basePath . '/../marketAreaPicture');
		$randName = mt_rand(100000, 999999).".".end($extractFile);
		
		if(move_uploaded_file($_FILES['areaPicture']['tmp_name'],$images_path . '/' . $randName)){
				$resp = array('name'=>$randName,'size'=>$_FILES['areaPicture']['size']);
		}else{
			$resp = array('msg'=>'Something went wrong. File not upload.');
		}
		
		echo json_encode($resp);
	}
	
	public function actionSaveUploadedAreaPicture(){
		$pictureFile = $_REQUEST['areaPicture'];
		if(is_array($pictureFile)){
			$pictureFile = implode(',',$pictureFile);
		}
		$district = $_REQUEST['district'];
		$areaPictureDetails = MarketInfo::model()->find('district_id = '.$district);
		if(isset($areaPictureDetails) && count($areaPictureDetails) && !empty($areaPictureDetails)){
			if(isset($_REQUEST['remove']) && $_REQUEST['remove'] == 1){
				$areaPictureDetails->market_area_picture = $pictureFile;
			}else{
				if($areaPictureDetails->market_area_picture != ""){
					$areaPictureDetails->market_area_picture = $areaPictureDetails->market_area_picture.",".$pictureFile;
				}else{
					$areaPictureDetails->market_area_picture = $pictureFile;
				}
			}
			
			if($areaPictureDetails->save(false)){
				$areaLandscape = $areaPictureDetails->market_area_picture;
				$areaLandscape = explode(',',$areaLandscape);
				
				$images_path = Yii::app()->baseUrl . '/marketAreaPicture/';
				$i = 0;
				foreach($areaLandscape as $landscape){
					if($i == 0){
						$result = '<li><a class="lightbox"><img src="'.$images_path.$landscape.'" /></a></li>';
					}else{
						$result .= '<li><a class="lightbox"><img src="'.$images_path.$landscape.'" /></a></li>';
					}
					$i++;
				}
				$resp = array('status'=>1,'content'=>$result);
			}else{
				$resp = array('status'=>0);
			}
		}else{
			$model = new MarketInfo;
			$model->market_area_picture = $pictureFile;
			if($model->save(false)){
				$areaLandscape = $model->market_area_picture;
				$areaLandscape = explode(',',$areaLandscape);
				$images_path = Yii::app()->baseUrl . '/marketAreaPicture/';
				$i = 0;
				foreach($areaLandscape as $landscape){
					if($i == 0){
						$result = '<li>
										<a class="lightbox">
											<img src="'.$images_path.$landscape.'"/>
										</a>
									</li>';
					}else{
						$result .= '<li>
										<a class="lightbox">
											<img src="'.$images_path.$landscape.'"/>
										</a>
									</li>';
					}
					$i++;
				}
				$resp = array('status'=>1,'content'=>$result);
			}else{
				$resp = array('status'=>0);
			}
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionAreaView(){
		$districtName = $_REQUEST['name'];
		$district = $_REQUEST['district'];
		$area = $_REQUEST['area'];
		
		
		$getDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=3&ar=eq&ac='.$district.'&output=json&results=100');
		$townArray = json_decode($getDistrict,true);
		$finalArray = array();
		if($townArray['ResultInfo']['Total'] > $townArray['ResultInfo']['Count']){
			$page = $townArray['ResultInfo']['Total']/$townArray['ResultInfo']['Count'];
			$pageRound = round($page);
			$pageSummation = $page-$pageRound;
			if($pageSummation > 0){
				$pageRound = $pageRound+1;
			}
			$start = $townArray['ResultInfo']['Start'];
			for($i=1;$i<=$pageRound;$i++){
				$getDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=3&ar=eq&ac='.$district.'&output=json&results=100&start='.$start);
				$townArray = json_decode($getDistrict,true);
				
				if(is_array($townArray) && isset($townArray['Feature'])){
					$resultCount = count($townArray['Feature']);
					$start = ($resultCount*$i)+1;
					foreach($townArray['Feature'] as $town){
						$finalArray[] = array('id'=>$town['Id'],'name'=>$town['Name']);
					}
				}else{
					continue;
				}
			}
		}else{
			foreach($townArray['Feature'] as $town){
				$finalArray[] = array('id'=>$town['Id'],'name'=>$town['Name']);
			}
		}
		$areaName = '';
		foreach($finalArray as $final){
			if(str_replace('.','',$area) == str_replace('.','',$final['id'])){
				$areaName = $final['name'];
			}
		}
		$this->pageTitle = $areaName.' | '.Yii::app()->params['name'];
		$this->render('singleDistrictArea',array('townArray'=>$finalArray,'districtId'=>$district,'areaId'=>$area,'districtName'=>$districtName,'areaName'=>$areaName));
	}
	
	public function actionSaveAreaDisc(){
		$content = $_REQUEST['content'];
		$district = $_REQUEST['district'];
		$town = $_REQUEST['town'];
		$areaDescriptionDetails = MarketAreaInfo::model()->find('town_id = '.$town);
		if(isset($areaDescriptionDetails) && count($areaDescriptionDetails) > 0 && !empty($areaDescriptionDetails)){
			$areaDescriptionDetails->area_discription = $content;
			if($areaDescriptionDetails->save(false)){
				$resp = array('status'=>1,'content'=>$areaDescriptionDetails['area_discription']);
			}
		}else{
			$model = new MarketAreaInfo;
			$model->district_id = $district;
			$model->town_id = $town;
			$model->area_discription = $content;
			if($model->save(false)){
				$resp = array('status'=>1,'content'=>$model['area_discription']);
			}
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionSaveAreaSummary(){
		$content = $_REQUEST['content'];
		$district = $_REQUEST['district'];
		$town = $_REQUEST['town'];
		$areaSummaryDetails = MarketAreaInfo::model()->find('town_id = '.$town);
		if(isset($areaSummaryDetails) && count($areaSummaryDetails) > 0 && !empty($areaSummaryDetails)){
			$areaSummaryDetails->area_summary = $content;
			if($areaSummaryDetails->save(false)){
				$resp = array('status'=>1,'content'=>$areaSummaryDetails['area_summary']);
			}
		}else{
			$model = new MarketAreaInfo;
			$model->district_id = $district;
			$model->town_id = $town;
			$model->area_summary = $content;
			if($model->save(false)){
				$resp = array('status'=>1,'content'=>$model['area_summary']);
			}
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionUploadAreaLandscape(){		
		$extractFile = explode('.',$_FILES['areaLandscape']['name']);
		$images_path = realpath(Yii::app()->basePath . '/../areaLandscape');
		$randName = mt_rand(100000, 999999).".".end($extractFile);
		
		if(move_uploaded_file($_FILES['areaLandscape']['tmp_name'],$images_path . '/' . $randName)){
				$resp = array('name'=>$randName,'size'=>$_FILES['areaLandscape']['size']);
		}else{
			$resp = array('msg'=>'Something went wrong. File not upload.');
		}
		
		echo json_encode($resp);
	}
	
	public function actionSaveUploadedAreaLandscape(){
		$landscapeFile = $_REQUEST['landscapeFile'];
		$district = $_REQUEST['district'];
		$town = $_REQUEST['town'];
		$areaLandscapeDetails = MarketAreaInfo::model()->find('town_id = '.$town);
		if(isset($areaLandscapeDetails) && count($areaLandscapeDetails) && !empty($areaLandscapeDetails)){
			if($areaLandscapeDetails->area_landscape != ""){
				$areaLandscapeDetails->area_landscape = $areaLandscapeDetails->area_landscape.",".$landscapeFile;
			}else{
				$areaLandscapeDetails->area_landscape = $landscapeFile;
			}
			if($areaLandscapeDetails->save(false)){
				$areaLandscape = $areaLandscapeDetails->area_landscape;
				$areaLandscape = explode(',',$areaLandscape);
				
				$images_path = Yii::app()->baseUrl . '/areaLandscape/';
				$i = 0;
				foreach($areaLandscape as $landscape){
					if($i == 0){
						$result = '<li><a class="lightbox"><img src="'.$images_path.$landscape.'" /></a></li>';
					}else{
						$result .= '<li><a class="lightbox"><img src="'.$images_path.$landscape.'" /></a></li>';
					}
					$i++;
				}
				$resp = array('status'=>1,'content'=>$result);
			}else{
				$resp = array('status'=>0);
			}
		}else{
			$model = new MarketAreaInfo;
			$model->area_landscape = $landscapeFile;
			if($model->save(false)){
				$areaLandscape = $model->area_landscape;
				$areaLandscape = explode(',',$areaLandscape);
				$images_path = Yii::app()->baseUrl . '/areaLandscape/';
				$i = 0;
				foreach($areaLandscape as $landscape){
					if($i == 0){
						$result = '<li>
										<a class="lightbox">
											<img src="'.$images_path.$landscape.'"/>
										</a>
									</li>';
					}else{
						$result .= '<li>
										<a class="lightbox">
											<img src="'.$images_path.$landscape.'"/>
										</a>
									</li>';
					}
					$i++;
				}
				$resp = array('status'=>1,'content'=>$result);
			}else{
				$resp = array('status'=>0);
			}
		}
		echo json_encode($resp);
		die;
	}
	public function actionspecificDistrictView(){
		$this->render('specificDistrictView');
	}
	public function actionspecificDistrictPrintView(){
		$this->renderPartial('marketPrint');
	}
	public function actionsingleDistrictPrintView(){
		$districtId = $_POST['hdnDisctrictId'];
		$districtName = $_POST['hdnDisctrictName'];
		$this->renderPartial('marketPrint2',array('districtId'=>$districtId,'districtName'=>$districtName));
	}
	
	public function actionSingleAreaPrint(){
		$district = $_POST['hdnDisctrict'];
		$area = $_POST['hdnTown'];
		$areaName = $_POST['hdnTownName'];
		$districtName = $_POST['hdnDistrictName'];
		$this->renderPartial('singleAreaPrint',array('districtId'=>$district,'areaId'=>$area,'districtName'=>$districtName,'areaName'=>$areaName));
	}
}