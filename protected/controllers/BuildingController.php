<?php
class BuildingController extends Controller{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $Ccart=false;

	/**
	 * @return array action filters
	 */
	public function filters(){
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules(){
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('importCSV','create','update','searchBuilding','searchBuildingResult','singleBuilding','changeBuildingInfo',
						'saveBuildingInfo','afterChangeInfoBuilding','uploadBuildingPdf','getUploadedFileList','deleteUploadedPdf',
						'getListOfTransmissionMatters','saveTransmissionDetails','getListOfFreeRents','saveFreeRent','getListOfRentsNegotiation',
						'saveRentNegotiation','getMapAccessDetails','searchbuildingFloorId','checkListForCart','listOfCartItem','searchBuildingByName',
						'searchFloorOwnerName','seachOwnerDropdown','saveMapAccessDetails','saveStaionReachTime','searchBuildingByAddress',
						'printBuildingDetails','route','getNearestStation','getCorporationList','getLineList','getStationList','getBuildingList',
						'getDisctrictList','getDisctrictListTest','getTownList','getTownListTest','buildingFilterByAddress','getCustomerDrop','sort',
						'deleteBulkTrans','deleteOfficeAlert','cloneOfficeAlert','removeFreeRent', 'deleteBulkNego', 'isExist', 'migrateOfficeWordpress', 'sendEmailFollowed'),
				'users'=>array('@'),
			),

			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */

	public function actionView($id){
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionIsExist() {
		$name = $_REQUEST['name'];
		$resultData = Building::model()->findAll('name = "'.$name.'"');
		if(count($resultData)>0)
			echo json_encode("false");
		else 
			echo json_encode("true");
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionImportCSV() {
		
		$BUILDING_INDEX = 88;
		$HEADER = 5;
		
		$getRandomNum = mt_rand(100000, 999999);
		$explodeFileName = explode('.',$_FILES['file']['name']);
		$csv_path = realpath(Yii::app()->basePath . '/../csv');
		$file = $csv_path.'/'.$getRandomNum.'.'.end($explodeFileName);
// 		$file = $csv_path.'/695169.csv';
		$resp = Array();
		if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){			
			$result = Array();
			ini_set('auto_detect_line_endings',TRUE);
			setlocale(LC_CTYPE, 'en_US.UTF-8');
			$row = 0;
			if (($handle = fopen($file, "r")) !== FALSE) {
			    while (($data = fgetcsv($handle)) !== FALSE) {
			        $num = count($data);
			        $row++;
			        if($row < $HEADER) continue;			        
			        $result[] = $data;
			    }
			    fclose($handle);
			}
			ini_set('auto_detect_line_endings',FALSE);	
			
			for($i=0;$i<count($result);$i++) {
				$item = $result[$i];
				if(trim($item[0])=="") continue;
				
				$building = Array();
				$floor = Array();				
				for($c=0;$c<count($item);$c++) {
					if($c<$BUILDING_INDEX)
						$building[] =  trim($item[$c]);
					else
						$floor[] = trim($item[$c]);
				}
	
				$building_id = $this->insertBuilding($building);				
				$this->insertFloor($building_id, $floor);
			}			
			$resp = array('status'=>1,'msg'=>'CSV file Successfully Imported.');
		} else {
			$resp = array('status'=>0,'msg'=>'Something went wrong.');
		}
		
		echo json_encode($resp);
	}
	
	public function generateBuildingId() {
		$ret = 'JPB'.mt_rand(1000,9999);
		$resultData = Building::model()->findAll('buildingId = "'.$ret.'"');
		while(count($resultData)>0) {
			$ret = 'JPB'.mt_rand(1000,9999);
			$resultData = Building::model()->findAll('buildingId = "'.$ret.'"');
		}
		return $ret;
	}
	
	public function actionCreate(){
		$facedStreetList = FacedStreet::model()->findAll('is_active = 1');
		$constructionTypeList = ConstructionType::model()->findAll('is_active = 1');
		$quakeResistanceList = QuakeResistanceStandards::model()->findAll('is_active = 1');
		$securityList = Security::model()->findAll('is_active = 1');
		$formTypeList = FormType::model()->findAll('is_active = 1');
		$model=new Building;		

		if(isset($_POST['Building'])){
			$model->attributes=$_POST['Building'];
			$model->name = $_POST['Building']['name'];
			$model->name_en = $_POST['Building']['name_en'];
			$model->search_keywords_ja = $_POST['Building']['search_keywords_ja'];
			$model->search_keywords_en = $_POST['Building']['search_keywords_en'];
			$model->is_featured = $_POST['Building']['is_featured'];
			$model->description_ja = $_POST['Building']['description_ja'];
			$model->description_en = $_POST['Building']['description_en'];
			$model->avg_neighbor_fee_min = $_POST['Building']['avg_neighbor_fee_min'];
			$model->avg_neighbor_fee_max = $_POST['Building']['avg_neighbor_fee_max'];
			$model->video_type = $_POST['Building']['video_type'];
			$model->video_id = $_POST['Building']['video_id'];
			
			if(isset($_POST['Building']['build_check'])){
				$model->bill_check = $_POST['Building']['build_check'];				
			}
			$model->old_name = $_POST['Building']['old_name'];
			$model->name_kana = $_POST['Building']['name_kana'];
			$model->address = $_POST['Building']['address'];
			$model->faced_street_id = $_POST['Building']['faced_street_id'];
			$model->construction_type_id = $_POST['Building']['construction_type_id'];
			$model->construction_type_name = $_POST['Building']['construction_type_name'];
			$model->construction_type_name_en = $_POST['Building']['construction_type_name_en'];
			/************** floor scale *******************/

			if($_POST['Building']['floor_scale_down'] != ""){
				$model->floor_scale = $_POST['Building']['floor_scale_up'].'-'.$_POST['Building']['floor_scale_down'];
			}else{
				$model->floor_scale = $_POST['Building']['floor_scale_up'];
			}
			/******************* end ***********************/

			$model->exp_rent = $_POST['Building']['exp_rent'].($_POST['Building']['exp_rent2'] != "" ? '~'.$_POST['Building']['exp_rent2'] : "").'-'.$_POST['Building']['exp_rent_opt'];
			
			if(isset($_POST['Building']['exp_rent_disabled'])){
				$model->exp_rent_disabled = $_POST['Building']['exp_rent_disabled'];
			}
			
			$model->earth_quake_res_std = $_POST['Building']['earth_quake_res_std'];
			$model->earth_quake_res_std_note = $_POST['Building']['earth_quake_res_std_note'];
			$model->emr_power_gen = $_POST['Building']['emr_power_gen'];
			$model->built_year = $_POST['Building']['build_year'].'-'.$_POST['Building']['build_month'];
			$model->renewal_data = $_POST['Building']['renewal_data'];
			$model->renewal_data_en = $_POST['Building']['renewal_data_en'];
			$model->std_floor_space = $_POST['Building']['std_floor_space'];
			$model->total_floor_space = $_POST['Building']['total_floor_space'];
			$model->total_rent_space_unit = $_POST['Building']['total_rent_space_unit'];
			$model->shared_rate = $_POST['Building']['shared_rate'];
			/****************** elevator ******************/

			if(isset($_POST['Building']['elevator'])){
				if( $_POST['Building']['elevator'] == 1){
					$model->elevator = $_POST['Building']['elevator'].'-'.$_POST['Building']['b_ev_group'].'-'.$_POST['Building']['b_ev_group2'].'-'.$_POST['Building']['b_ev_group3'].'-'.$_POST['Building']['b_ev_group4'].'-'.$_POST['Building']['b_ev_group5'];
				}else{
					$model->elevator = $_POST['Building']['elevator'];
				}
			}
			/******************** end ************************/

			$model->elevator_non_stop = $_POST['Building']['elevator_non_stop'];
			$model->elevator_hall = $_POST['Building']['elevator_hall'];
			$model->entrance_with_attention = $_POST['Building']['entrance_with_attention'];
			/********************** entrance open/close time ***********/

			$entVal = "";
			if(isset($_POST['Building']['ent_week_opt'])){
				if($_POST['Building']['ent_week_opt'] == 2){
					$entVal .= $_POST['Building']['ent_week_opt'].'-'.$_POST['Building']['ent_op_week_start'].'~'.$_POST['Building']['ent_op_week_finish'].",";
				}else{
					$entVal .= $_POST['Building']['ent_week_opt'].",";
				}
			}

			if(isset($_POST['Building']['ent_sat_opt'])){
				if($_POST['Building']['ent_sat_opt'] == 2){
					$entVal .= $_POST['Building']['ent_sat_opt'].'-'.$_POST['Building']['ent_op_sat_start'].'~'.$_POST['Building']['ent_op_sat_finish'].",";
				}else{
					$entVal .= $_POST['Building']['ent_sat_opt'].",";
				}
			}

			if(isset($_POST['Building']['ent_sun_opt'])){
				if($_POST['Building']['ent_sun_opt'] == 2){
					$entVal .= $_POST['Building']['ent_sun_opt'].'-'.$_POST['Building']['ent_op_sun_start'].'~'.$_POST['Building']['ent_op_sun_finish'].",";
				}else{
					$entVal .= $_POST['Building']['ent_sun_opt'];
				}
			}
			$model->ent_op_cl_time = $entVal;
			/********************* end ******************/

			$model->ent_auto_lock = $_POST['Building']['ent_auto_lock'];

			/******************* parking unit ***************/
			if($_POST['Building']['parking_unit_no'] == 1){
				$model->parking_unit_no = $_POST['Building']['parking_unit_no'].'-'.$_POST['Building']['b_parking_num'];
			}else{
				$model->parking_unit_no = $_POST['Building']['parking_unit_no'];
			}
			/******************* end *********************/

			/******************* limit time usage ************/
			$limitVal = "";
			if(isset($_POST['Building']['limit_time_week'])){
				if($_POST['Building']['limit_time_week'] == 2){
					$limitVal .= $_POST['Building']['limit_time_week'].'-'.$_POST['Building']['limit_time_week_start'].'~'.$_POST['Building']['limit_time_week_finish'].",";
				}else{
					$limitVal .= $_POST['Building']['limit_time_week'].",";
				}
			}

			if(isset($_POST['Building']['limit_time_sat'])){
				if($_POST['Building']['limit_time_sat'] == 2){
					$limitVal .= $_POST['Building']['limit_time_sat'].'-'.$_POST['Building']['limit_time_sat_start'].'~'.$_POST['Building']['limit_time_sat_finish'].",";
				}else{
					$limitVal .= $_POST['Building']['limit_time_sat'].",";
				}
			}
			
			if(isset($_POST['Building']['limit_time_sun'])){
				if($_POST['Building']['limit_time_sun'] == 2){
					$limitVal .= $_POST['Building']['limit_time_sun'].'-'.$_POST['Building']['limit_time_sun_start'].'~'.$_POST['Building']['limit_time_sun_finish'].",";
				}else{
					$limitVal .= $_POST['Building']['limit_time_sun'];
				}
			}
			$model->limit_of_usage_time = $limitVal;
			/******************* end *************************/

			/******************* air conditioning time limit ************/
			$airVal = "";
			if(isset($_POST['Building']['air_condition_week'])){
				if($_POST['Building']['air_condition_week'] == 2){
					$airVal .= $_POST['Building']['air_condition_week'].'-'.$_POST['Building']['air_condition_week_start'].'~'.$_POST['Building']['air_condition_week_finish'].",";
				}else{
					$airVal .= $_POST['Building']['air_condition_week'].",";
				}
			}
			
			if(isset($_POST['Building']['air_condition_sat'])){
				if($_POST['Building']['air_condition_sat'] == 2){
					$airVal .= $_POST['Building']['air_condition_sat'].'-'.$_POST['Building']['air_condition_sat_start'].'~'.$_POST['Building']['air_condition_sat_finish'].",";
				}else{
					$airVal .= $_POST['Building']['air_condition_sat'].",";
				}
			}

			if(isset($_POST['Building']['air_condition_sun'])){
				if($_POST['Building']['air_condition_sun'] == 2){
					$airVal .= $_POST['Building']['air_condition_sun'].'-'.$_POST['Building']['air_condition_sun_start'].'~'.$_POST['Building']['air_condition_sun_finish'].",";
				}else{
					$airVal .= $_POST['Building']['air_condition_sun'];
				}
			}
			$model->air_condition_time = $airVal;
			/******************* end *************************/

			/******************* parking use time limit ************/
			$parkingVal = "";
			if(isset($_POST['Building']['park_time_week'])){
				if($_POST['Building']['park_time_week'] == 2){
					$parkingVal .= $_POST['Building']['park_time_week'].'-'.$_POST['Building']['park_time_week_start'].'~'.$_POST['Building']['park_time_week_finish'].",";
				}else{
					$parkingVal .= $_POST['Building']['park_time_week'].",";
				}
			}

			if(isset($_POST['Building']['park_time_sat'])){
				if($_POST['Building']['park_time_sat'] == 2){
					$parkingVal .= $_POST['Building']['park_time_sat'].'-'.$_POST['Building']['park_time_sat_start'].'~'.$_POST['Building']['park_time_sat_finish'].",";
				}else{
					$parkingVal .= $_POST['Building']['park_time_sat'].",";
				}
			}

			if(isset($_POST['Building']['park_time_sun'])){
				if($_POST['Building']['park_time_sun'] == 2){
					$parkingVal .= $_POST['Building']['park_time_sun'].'-'.$_POST['Building']['park_time_sun_start'].'~'.$_POST['Building']['park_time_sun_finish'].",";
				}else{
					$parkingVal .= $_POST['Building']['park_time_sun'];
				}
			}
			$model->parking_time = $parkingVal;
			/******************* end *************************/
			if(isset($_POST['Building']['building_with_deadline'])){
				$model->building_with_deadline = $_POST['Building']['building_with_deadline'].'-'.$_POST['Building']['building_with_deadline_date'];
			}

			$model->lend_house = $_POST['Building']['lend_house'];
			$model->ceiling_height = $_POST['Building']['ceiling_height'];
			$model->air_control_type = $_POST['Building']['air_control_type'];
			$model->notes = $_POST['Building']['notes'];			

			if(isset($_POST['Building']['oa_floor'])){
				if($_POST['Building']['oa_floor'] == 2){
					$model->oa_floor = $_POST['Building']['oa_floor'].'-'.$_POST['Building']['oa_floor_txt'];
				}else{
					$model->oa_floor = $_POST['Building']['oa_floor'];
				}
			}

			$model->opticle_cable = $_POST['Building']['opticle_cable'];
			$model->wholesale_lease = $_POST['Building']['wholesale_lease'];
			$model->security_id = $_POST['Building']['security_id'];
			$model->form_type_id = $_POST['Building']['form_type_id'];
// 			$model->buildingId = 'JPB'.mt_rand(1000,9999);
			$model->buildingId = $this->generateBuildingId();
			
			/******************* condominium oqnership ************/
			if(isset($_POST['Building']['condominium_ownership'])){
				$model->condominium_ownership = $_POST['Building']['condominium_ownership'];
			}
			/******************* end *************************/			

			$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
			$logged_user_id = $user->user_id;
			$model->added_by = $logged_user_id;
			$model->added_on = date('Y-m-d H:i:s');
			$model->modified_by = $logged_user_id;
			$model->modified_on = date('Y-m-d H:i:s');
			if($_POST['Building']['address'] != ''){
				$address = explode(',',$_POST['Building']['address']);
				$address = end($address);
				
				$aAddress = $this->getAddressByGoogleMap($address);
				
				$lat = $aAddress['lat'];
				$long = $aAddress['long'];
				$prefecture = $aAddress['prefecture'];
				$district = $aAddress['district'];
				$town = $aAddress['town'];
				$postalCode = $aAddress['postalCode'];
				$postalCodeOrder = $aAddress['postalCodeOrder'];
				
				$aAddress = $this->getAddressByGoogleMap($address, 'en');
				$prefecture_en = $aAddress['prefecture'];
				$district_en = $aAddress['district'];
				$town_en = $aAddress['town'];
				
				$model->prefecture_en = $prefecture_en;
				$model->district_en = $district_en;
				$model->town_en = $town_en;
				
			}else{
				$lat = '';
				$long = '';
				$prefecture = '';
				$district = '';
				$postalCode = '';
				$postalCodeOrder = '';
				$town = '';
			}
// 			$model->address_en = isset($aAddress) ? $aAddress['address_en'] : '';
			$model->address_en = $_POST['Building']['address_en'];
			$model->map_lat = $lat;
			$model->map_long = $long;
			$model->prefecture = $prefecture;
			$model->district = $district;
			$model->town = $town;
			$model->postal_code = $postalCode;
			$model->postal_code_order = $postalCodeOrder;
			if($model->save(false)){
				Yii::app()->closetown->calculateMarketCloseTown($town);
				
				$listOfStation = $this->actionGetNearestStation($long, $lat);
				foreach($listOfStation as $station){
					$stationModel = new BuildingStation;
					$stationModel->building_id = $model->building_id;
					$stationModel->prefecture = $prefecture;
					$stationModel->corporate = $station['corporate'];
					$stationModel->name = $station['name'];
					$stationModel->name_en = $station['name_en'];
					$stationModel->line = $station['line'];
					$stationModel->distance = $station['distance'];
					$stationModel->time = ceil($station['distance']/80);
					$stationModel->save(false);
				}
				
				//check for office alert
				$cBuildingId = $model->building_id;
				$currentBuilding = Building::model()->findByPk($cBuildingId);
				
				$buildingStationTime = BuildingStation::model()->findAll('building_id = '.$cBuildingId);
				$arrayTime = array();
				$arrayRoute = array();
				foreach($buildingStationTime as $nTime){
					$arrayTime[] = $nTime->time;
					$arrayRoute[] = $nTime->name;
				}
				
				$criteria=new CDbCriteria();
				$criteria->order='office_alert_id DESC';					
				$officeAlertList = OfficeAlert::model()->findAll($criteria);
				
				$i = 1;
				foreach($officeAlertList as $officeAlert){
					$getConditions = SearchSettings::model()->findByPk($officeAlert->cond_id);
					$cond = json_decode($getConditions->ss_json,true);
					$buildingId = explode(',',$officeAlert->building_id);
					
					$oAlert = OfficeAlert::model()->findByPk($officeAlert->office_alert_id);
					$pass = true;
					
					if(isset($cond['buildingAge']) && $cond['buildingAge'] != 0){
						$bAge = $currentBuilding->built_year;
						$bAge = explode('-',$bAge);
						$bAge = $bAge[0];
						if($cond['buildingAge'] != $bAge){
							$pass = false;
						}
					}
					
					if(isset($cond['deadlineCheck'])){
						if($cond['deadlineCheck'] != $currentBuilding->building_with_deadline){
							$pass = false;
						}
					}
					
					if(isset($cond['buildingSearchName'])){
						if($cond['buildingSearchName'] != $currentBuilding->name){
							$pass = false;
						}
					}
					
					if(isset($cond['buildingSearchAddress'])){
						$pos = strpos($cond['buildingSearchAddress'],  $currentBuilding->address);
						if($pos === false){
							$pass = false;
						}
					}
					
					if(isset($cond['pre-list']) && $cond['pre-list'] != ""){
						$prefecture = Prefecture::model()->find("prefecture_name LIKE '%".$currentBuilding->prefecture."%'");
						$prefectureId = $prefecture->code;
						if($prefectureId != $cond['pre-list']){
							$pass = false;
						}
					}
					
					/*if(isset($cond['prefectureDistrictlist']) && $cond['prefectureDistrictlist'] != ""){
						$district = District::model()->find('district_name LIKE "%'.$currentBuilding->district.'%"');
						$districtId = $district->code;
						if($districtId != $cond['prefectureDistrictlist']){
							$pass = false;
							echo "-------------------- condition 6--------<br/>";
							echo "R = ".$pass."<br/>";
						}
					}*/
					
					if(isset($cond['districtTownList']) && !empty($cond['districtTownList'])){
						$town = Town::model()->find('town_name LIKE "%'.$currentBuilding->town.'%"');
						$townId = $town->code;
						if(!in_array($townId,$cond['districtTownList'])){
							$pass = false;
						}
					}
					
					if(isset($cond['hdnRPrefId']) && $cond['hdnRPrefId'] != 0){
						$prefecture = Prefecture::model()->find("prefecture_name LIKE '%".$currentBuilding->prefecture."%'");
						$prefectureId = $prefecture->code;
						$prefecture = Prefecture::model()->find("code = '".$cond['hdnRPrefId']."'");
						if($prefectureId != $cond['hdnRPrefId']){
							$pass = false;
						}
					}
					
					if(isset($cond['hdnRailId']) && $cond['hdnRailId'] != 0){
						$rail = BuildingStation::model()->findAll("building_id = ".$cBuildingId);
						$corpArray = array();
						foreach($rail as $r){
							$corpArray[] = $r->corporate;
						}
						if(!in_array($cond['hdnRailId'],$corpArray)){
							$pass = false;
						}
					}
					
					if(isset($cond['hdnLineId']) && $cond['hdnLineId'] != 0){
						$line = BuildingStation::model()->findAll("building_id = ".$cBuildingId);
						$lineArray = array();
						foreach($line as $l){
							$lineArray[] = $l->line;
						}
						if(!in_array($cond['hdnLineId'],$lineArray)){
							$pass = false;
						}
					}
					
					if(isset($cond['hdnRRouteId']) && $cond['hdnRRouteId'] != ""){
						$route = explode(',',$cond['hdnRRouteId']);
						$routeDetail = BuildingStation::model()->findAll("building_id = ".$cBuildingId);
						$rArray = array();
						foreach($routeDetail as $rt){
							$rArray[] = $rt->line;
						}
						foreach($route as $rLoop){
							if(!in_array($rLoop,$rArray)){
								$pass = false;
							}
						}
					}
					
					if(isset($cond['floorSearchOwnerName']) && $cond['floorSearchOwnerName'] != ""){
						$oNew = preg_split('/\r\n|[\r\n]/', $cond['floorSearchOwnerName']);
						$buildingOwner = OwnershipManagement::model()->findAll('building_id = '.$cBuildingId);
						$bOwnerList = array();
						
						foreach($buildingOwner as $owner){
							$bOwnerList[] = $owner->owner_company_name;
						}
						
						foreach($oNew as $o){
							if(!in_array($o,$bOwnerList)){
								$pass = false;
							}
						}
					}
					
					if(isset($cond['hdnAddressBuildingId']) && $cond['hdnAddressBuildingId'] != 0){
						$sBuildingId = explode(',',$cond['hdnAddressBuildingId']);
						if(!in_array($cBuildingId,$sBuildingId)){
							$pass = false;
						}
					}
					
					if(in_array($cBuildingId,$buildingId)){
						$bIds = $buildingId;
						$bIds = array_diff($buildingId, array($cBuildingId));
					}
					
					if($pass == true){
						$bIds = array_push($bIds,$cBuildingId);
						$bIds = implode(',',$bIds);
						$oAlert->building_id = $bIds;
						$oAlert->save(false);
					}
					
					$i++;
				}
				
				// BEGIN - Create wordpress building reference
				$wordpress = new Wordpress();
				$wordpress->processIntergrateWordpress($model->building_id, Wordpress::BUILDING_TYPE, 'create');
				$wordpress->reGenerateLocations();
				// End - processing with wordpress
				
				$this->redirect(array('floor/create','bid'=>$model->building_id));
			}
		}

		$this->render('create',array('model'=>$model,'facedStreetList'=>$facedStreetList,'constructionTypeList'=>$constructionTypeList,'quakeResistanceList'=>$quakeResistanceList,'securityList'=>$securityList,'formTypeList'=>$formTypeList));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id){
		$facedStreetList = FacedStreet::model()->findAll('is_active = 1');
		$constructionTypeList = ConstructionType::model()->findAll('is_active = 1');
		$quakeResistanceList = QuakeResistanceStandards::model()->findAll('is_active = 1');
		$securityList = Security::model()->findAll('is_active = 1');
		$formTypeList = FormType::model()->findAll('is_active = 1');
		$model=$this->loadModel($id);

		if(isset($_POST['Building'])){
			$model->name = $_POST['Building']['name'];
			$model->name_en = $_POST['Building']['name_en'];
			$model->search_keywords_ja = $_POST['Building']['search_keywords_ja'];
			$model->search_keywords_en = $_POST['Building']['search_keywords_en'];
			$model->is_featured = $_POST['Building']['is_featured'];
			$model->description_ja = $_POST['Building']['description_ja'];
			$model->description_en = $_POST['Building']['description_en'];
			$model->avg_neighbor_fee_min = $_POST['Building']['avg_neighbor_fee_min'];
			$model->avg_neighbor_fee_max = $_POST['Building']['avg_neighbor_fee_max'];
			$model->video_type = $_POST['Building']['video_type'];
			$model->video_id = $_POST['Building']['video_id'];
			
			if(isset($_POST['Building']['build_check'])){
				$model->bill_check = $_POST['Building']['build_check'];
			}
			$model->old_name = $_POST['Building']['old_name'];
			$model->name_kana = $_POST['Building']['name_kana'];
			$model->address = $_POST['Building']['address'];
			$model->faced_street_id = $_POST['Building']['faced_street_id'];
			$model->construction_type_id = $_POST['Building']['construction_type_id'];
			$model->construction_type_name = $_POST['Building']['construction_type_name'];
			$model->construction_type_name_en = $_POST['Building']['construction_type_name_en'];
			/************** floor scale *******************/
			if($_POST['Building']['floor_scale_down'] != ""){
				$model->floor_scale = $_POST['Building']['floor_scale_up'].'-'.$_POST['Building']['floor_scale_down'];
			}else{
				$model->floor_scale = $_POST['Building']['floor_scale_up'];
			}
			/******************* end ***********************/

			$model->exp_rent = $_POST['Building']['exp_rent'].($_POST['Building']['exp_rent2'] != "" ? '~'.$_POST['Building']['exp_rent2'] : "").'-'.$_POST['Building']['exp_rent_opt'];
			if(isset($_POST['Building']['exp_rent_disabled'])){
				$model->exp_rent_disabled = $_POST['Building']['exp_rent_disabled'];
			}
			$model->earth_quake_res_std = $_POST['Building']['earth_quake_res_std'];
			$model->earth_quake_res_std_note = $_POST['Building']['earth_quake_res_std_note'];
			$model->emr_power_gen = $_POST['Building']['emr_power_gen'];
			$model->built_year = $_POST['Building']['build_year'].'-'.$_POST['Building']['build_month'];
			$model->renewal_data = $_POST['Building']['renewal_data'];
			$model->renewal_data_en = $_POST['Building']['renewal_data_en'];
			$model->std_floor_space = $_POST['Building']['std_floor_space'];
			$model->total_floor_space = $_POST['Building']['total_floor_space'];
			$model->total_rent_space_unit = $_POST['Building']['total_rent_space_unit'];
			$model->shared_rate = $_POST['Building']['shared_rate'];
			if(isset($_POST['Building']['building_with_deadline'])){
				$model->building_with_deadline = $_POST['Building']['building_with_deadline'].'-'.$_POST['Building']['building_with_deadline_date'];
			}
			/****************** elevator ******************/
			if(isset($_POST['Building']['elevator'])){
				if( $_POST['Building']['elevator'] == 1){
					$model->elevator = $_POST['Building']['elevator'].'-'.$_POST['Building']['b_ev_group'].'-'.$_POST['Building']['b_ev_group2'].'-'.$_POST['Building']['b_ev_group3'].'-'.$_POST['Building']['b_ev_group4'].'-'.$_POST['Building']['b_ev_group5'];
				}else{
					$model->elevator = $_POST['Building']['elevator'];
				}
			}
			$model->elevator_non_stop = $_POST['Building']['elevator_non_stop'];
			$model->elevator_hall = $_POST['Building']['elevator_hall'];
			$model->entrance_with_attention = $_POST['Building']['entrance_with_attention'];
			/********************** entrance open/close time ***********/
			$entVal = "";
			if(isset($_POST['Building']['ent_week_opt'])){
				if($_POST['Building']['ent_week_opt'] == 2){
					$entVal .= $_POST['Building']['ent_week_opt'].'-'.$_POST['Building']['ent_op_week_start'].'~'.$_POST['Building']['ent_op_week_finish'].",";
				}else{
					$entVal .= $_POST['Building']['ent_week_opt'].",";
				}
			}
			if(isset($_POST['Building']['ent_sat_opt'])){
				if($_POST['Building']['ent_sat_opt'] == 2){
					$entVal .= $_POST['Building']['ent_sat_opt'].'-'.$_POST['Building']['ent_op_sat_start'].'~'.$_POST['Building']['ent_op_sat_finish'].",";
				}else{
					$entVal .= $_POST['Building']['ent_sat_opt'].",";
				}
			}

			if(isset($_POST['Building']['ent_sun_opt'])){
				if($_POST['Building']['ent_sun_opt'] == 2){
					$entVal .= $_POST['Building']['ent_sun_opt'].'-'.$_POST['Building']['ent_op_sun_start'].'~'.$_POST['Building']['ent_op_sun_finish'].",";
				}else{
					$entVal .= $_POST['Building']['ent_sun_opt'];
				}
			}
			$model->ent_op_cl_time = $entVal;
			/********************* end ******************/
			$model->ent_auto_lock = $_POST['Building']['ent_auto_lock'];
			/******************* parking unit ***************/
			if($_POST['Building']['parking_unit_no'] == 1){
				$model->parking_unit_no = $_POST['Building']['parking_unit_no'].'-'.$_POST['Building']['b_parking_num'];
			}else{
				$model->parking_unit_no = $_POST['Building']['parking_unit_no'];
			}
			/******************* end *********************/
			
			/******************* limit time usage ************/
			$limitVal = "";
			if(isset($_POST['Building']['limit_time_week'])){
				if($_POST['Building']['limit_time_week'] == 2){
					$limitVal .= $_POST['Building']['limit_time_week'].'-'.$_POST['Building']['limit_time_week_start'].'~'.$_POST['Building']['limit_time_week_finish'].",";
				}else{
					$limitVal .= $_POST['Building']['limit_time_week'].",";
				}
			}

			if(isset($_POST['Building']['limit_time_sat'])){
				if($_POST['Building']['limit_time_sat'] == 2){
					$limitVal .= $_POST['Building']['limit_time_sat'].'-'.$_POST['Building']['limit_time_sat_start'].'~'.$_POST['Building']['limit_time_sat_finish'].",";
				}else{
					$limitVal .= $_POST['Building']['limit_time_sat'].",";
				}
			}

			if(isset($_POST['Building']['limit_time_sun'])){
				if($_POST['Building']['limit_time_sun'] == 2){
					$limitVal .= $_POST['Building']['limit_time_sun'].'-'.$_POST['Building']['limit_time_sun_start'].'~'.$_POST['Building']['limit_time_sun_finish'].",";
				}else{
					$limitVal .= $_POST['Building']['limit_time_sun'];
				}
			}
			$model->limit_of_usage_time = $limitVal;
			/******************* end *************************/
			
			/******************* air conditioning time limit ************/
			$airVal = "";
			if(isset($_POST['Building']['air_condition_week'])){
				if($_POST['Building']['air_condition_week'] == 2){
					$airVal .= $_POST['Building']['air_condition_week'].'-'.$_POST['Building']['air_condition_week_start'].'~'.$_POST['Building']['air_condition_week_finish'].",";
				}else{
					$airVal .= $_POST['Building']['air_condition_week'].",";
				}
			}

			if(isset($_POST['Building']['air_condition_sat'])){
				if($_POST['Building']['air_condition_sat'] == 2){
					$airVal .= $_POST['Building']['air_condition_sat'].'-'.$_POST['Building']['air_condition_sat_start'].'~'.$_POST['Building']['air_condition_sat_finish'].",";
				}else{
					$airVal .= $_POST['Building']['air_condition_sat'].",";
				}
			}

			if(isset($_POST['Building']['air_condition_sun'])){
				if($_POST['Building']['air_condition_sun'] == 2){
					$airVal .= $_POST['Building']['air_condition_sun'].'-'.$_POST['Building']['air_condition_sun_start'].'~'.$_POST['Building']['air_condition_sun_finish'].",";
				}else{
					$airVal .= $_POST['Building']['air_condition_sun'];
				}
			}
			$model->air_condition_time = $airVal;
			/******************* end *************************/

			/******************* parking use time limit ************/
			$parkingVal = "";
			if(isset($_POST['Building']['park_time_week'])){
				if($_POST['Building']['park_time_week'] == 2){
					$parkingVal .= $_POST['Building']['park_time_week'].'-'.$_POST['Building']['park_time_week_start'].'~'.$_POST['Building']['park_time_week_finish'].",";
				}else{
					$parkingVal .= $_POST['Building']['park_time_week'].",";
				}
			}

			if(isset($_POST['Building']['park_time_sat'])){
				if($_POST['Building']['park_time_sat'] == 2){
					$parkingVal .= $_POST['Building']['park_time_sat'].'-'.$_POST['Building']['park_time_sat_start'].'~'.$_POST['Building']['park_time_sat_finish'].",";
				}else{
					$parkingVal .= $_POST['Building']['park_time_sat'].",";
				}
			}

			if(isset($_POST['Building']['park_time_sun'])){
				if($_POST['Building']['park_time_sun'] == 2){
					$parkingVal .= $_POST['Building']['park_time_sun'].'-'.$_POST['Building']['park_time_sun_start'].'~'.$_POST['Building']['park_time_sun_finish'].",";
				}else{
					$parkingVal .= $_POST['Building']['park_time_sun'];
				}
			}
			$model->parking_time = $parkingVal;
			/******************* end *************************/

			$model->lend_house = $_POST['Building']['lend_house'];
			$model->ceiling_height = $_POST['Building']['ceiling_height'];
			$model->air_control_type = $_POST['Building']['air_control_type'];
			$model->oa_floor = $_POST['Building']['oa_floor'];
			$model->notes = $_POST['Building']['notes'];
			$model->opticle_cable = $_POST['Building']['opticle_cable'];
			$model->wholesale_lease = $_POST['Building']['wholesale_lease'];
			$model->security_id = $_POST['Building']['security_id'];
			$model->form_type_id = $_POST['Building']['form_type_id'];			

			$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
			$logged_user_id = $user->user_id;
			$model->modified_by = $logged_user_id;
			$model->modified_on = date('Y-m-d H:i:s');			

			if(isset($_POST['Building']['condominium_ownership'])){
				$model->condominium_ownership = $_POST['Building']['condominium_ownership'];
			}			
			if($_POST['Building']['address'] != ''){
				$address = explode(',',$_POST['Building']['address']);
				$address = end($address);
				
				$aAddress = $this->getAddressByGoogleMap($address);
				$lat = $aAddress['lat'];
				$long = $aAddress['long'];
				$prefecture = $aAddress['prefecture'];
				$district = $aAddress['district'];
				$town = $aAddress['town'];
				$postalCode = $aAddress['postalCode'];
				$postalCodeOrder = $aAddress['postalCodeOrder'];
				
				$aAddress = $this->getAddressByGoogleMap($address, 'en');
				$model->prefecture_en = $aAddress['prefecture'];
				$model->district_en = $aAddress['district'];
				$model->town_en = $aAddress['town'];
				
				
			}else{
				$lat = '';
				$long = '';
				$prefecture = '';
				$district = '';
				$postalCode = '';
				$postalCodeOrder = '';
				$town = '';
			}
			
// 			$model->address_en = isset($aAddress) ? $aAddress['address_en'] : '';
			$model->address_en = $_POST['Building']['address_en'];
			$model->map_lat = $lat;
			$model->map_long = $long;
			$model->prefecture = $prefecture;
			$model->district = $district;
			$model->town = $town;
			$model->postal_code = $postalCode;
			$model->postal_code_order = $postalCodeOrder;
			if($model->save(false)){
				
				// BEGIN - Create wordpress building reference
				$wordpress = new Wordpress();
				$wordpress->processIntergrateWordpress($model->building_id, Wordpress::BUILDING_TYPE, 'update');
				$wordpress->reGenerateLocations();
				// End - processing with wordpress
				
				Yii::app()->closetown->calculateMarketCloseTown($town);
				
				$buildingRouteStationDetails = BuildingStation::model()->findAll('building_id = '.$id);
				if(isset($buildingRouteStationDetails) && count($buildingRouteStationDetails) > 0){
					BuildingStation::model()->deleteAll('building_id = '.$id);
				}
				$listOfStation = $this->actionGetNearestStation($long, $lat);
				foreach($listOfStation as $station){
					$stationModel = new BuildingStation;
					$stationModel->building_id = $id;
					$stationModel->prefecture = $prefecture;
					$stationModel->corporate = $station['corporate'];
					$stationModel->name = $station['name'];
					$stationModel->name_en = $station['name_en'];
					$stationModel->line = $station['line'];
					$stationModel->distance = $station['distance'];
					$stationModel->time = ceil($station['distance']/80);
					$stationModel->save(false);
				}
				$changeLogModel = new BuildingUpdateLog;
				$changeLogModel->building_id = $id;
				$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/searchBuildingResult',array('id'=>$id)).'">'.Yii::app()->controller->__trans('Building basic info').' ('.$prefecture.')</a> '.Yii::app()->controller->__trans('has been updated');
				
				$changeLogModel->added_by = $logged_user_id;
				$changeLogModel->added_on = date('Y-m-d H:i:s');
				if($changeLogModel->save(false)){
					//check for office alert
					$currentBuilding = Building::model()->findByPk($id);
					
					$buildingStationTime = BuildingStation::model()->findAll('building_id = '.$id);
					$arrayTime = array();
					$arrayRoute = array();
					foreach($buildingStationTime as $nTime){
						$arrayTime[] = $nTime->time;
						$arrayRoute[] = $nTime->name;
					}
					
					$criteria=new CDbCriteria();
					$criteria->order='office_alert_id DESC';					
					$officeAlertList = OfficeAlert::model()->findAll($criteria);
					
					$i = 1;
					foreach($officeAlertList as $officeAlert){
						$getConditions = SearchSettings::model()->findByPk($officeAlert->cond_id);
						$cond = json_decode($getConditions->ss_json,true);
						$buildingId = explode(',',$officeAlert->building_id);
						
						$oAlert = OfficeAlert::model()->findByPk($officeAlert->office_alert_id);
						$pass = true;
						
						if(isset($cond['buildingAge']) && $cond['buildingAge'] != 0){
							$bAge = $currentBuilding->built_year;
							$bAge = explode('-',$bAge);
							$bAge = $bAge[0];
							if($cond['buildingAge'] != $bAge){
								$pass = false;
							}
						}
						
						if(isset($cond['deadlineCheck'])){
							if($cond['deadlineCheck'] != $currentBuilding->building_with_deadline){
								$pass = false;
							}
						}
						
						if(isset($cond['buildingSearchName'])){
							if($cond['buildingSearchName'] != $currentBuilding->name){
								$pass = false;
							}
						}
						
						if(isset($cond['buildingSearchAddress'])){
							$pos = strpos($cond['buildingSearchAddress'],  $currentBuilding->address);
							if($pos === false){
								$pass = false;
							}
						}
						
						if(isset($cond['pre-list']) && $cond['pre-list'] != ""){
							$prefecture = Prefecture::model()->find("prefecture_name LIKE '%".$currentBuilding->prefecture."%'");
							$prefectureId = $prefecture->code;
							if($prefectureId != $cond['pre-list']){
								$pass = false;
							}
						}
						
						/*if(isset($cond['prefectureDistrictlist']) && $cond['prefectureDistrictlist'] != ""){
							$district = District::model()->find('district_name LIKE "%'.$currentBuilding->district.'%"');
							$districtId = $district->code;
							if($districtId != $cond['prefectureDistrictlist']){
								$pass = false;
								echo "-------------------- condition 6--------<br/>";
								echo "R = ".$pass."<br/>";
							}
						}*/
						
						if(isset($cond['districtTownList']) && !empty($cond['districtTownList'])){
							$town = Town::model()->find('town_name LIKE "%'.$currentBuilding->town.'%"');
							$townId = $town->code;
							if(!in_array($townId,$cond['districtTownList'])){
								$pass = false;
							}
						}
						
						if(isset($cond['hdnRPrefId']) && $cond['hdnRPrefId'] != 0){
							$prefecture = Prefecture::model()->find("prefecture_name LIKE '%".$currentBuilding->prefecture."%'");
							$prefectureId = $prefecture->code;
							$prefecture = Prefecture::model()->find("code = '".$cond['hdnRPrefId']."'");
							if($prefectureId != $cond['hdnRPrefId']){
								$pass = false;
							}
						}
						
						if(isset($cond['hdnRailId']) && $cond['hdnRailId'] != 0){
							$rail = BuildingStation::model()->findAll("building_id = ".$id);
							$corpArray = array();
							foreach($rail as $r){
								$corpArray[] = $r->corporate;
							}
							if(!in_array($cond['hdnRailId'],$corpArray)){
								$pass = false;
							}
						}
						
						if(isset($cond['hdnLineId']) && $cond['hdnLineId'] != 0){
							$line = BuildingStation::model()->findAll("building_id = ".$id);
							$lineArray = array();
							foreach($line as $l){
								$lineArray[] = $l->line;
							}
							if(!in_array($cond['hdnLineId'],$lineArray)){
								$pass = false;
							}
						}
						
						if(isset($cond['hdnRRouteId']) && $cond['hdnRRouteId'] != ""){
							$route = explode(',',$cond['hdnRRouteId']);
							$routeDetail = BuildingStation::model()->findAll("building_id = ".$id);
							$rArray = array();
							foreach($routeDetail as $rt){
								$rArray[] = $rt->line;
							}
							foreach($route as $rLoop){
								if(!in_array($rLoop,$rArray)){
									$pass = false;
								}
							}
						}
						
						if(isset($cond['floorSearchOwnerName']) && $cond['floorSearchOwnerName'] != ""){
							$oNew = preg_split('/\r\n|[\r\n]/', $cond['floorSearchOwnerName']);
							$buildingOwner = OwnershipManagement::model()->findAll('building_id = '.$id);
							$bOwnerList = array();
							
							foreach($buildingOwner as $owner){
								$bOwnerList[] = $owner->owner_company_name;
							}
							
							foreach($oNew as $o){
								if(!in_array($o,$bOwnerList)){
									$pass = false;
								}
							}
						}
						
						if(isset($cond['hdnAddressBuildingId']) && $cond['hdnAddressBuildingId'] != 0){
							$sBuildingId = explode(',',$cond['hdnAddressBuildingId']);
							if(!in_array($id,$sBuildingId)){
								$pass = false;
							}
						}
						
						if(in_array($id,$buildingId)){
							$bIds = $buildingId;
							$bIds = array_diff($buildingId, array($id));
						}
						
						if($pass == true){
							$bIds = array_push($bIds,$id);
							$bIds = implode(',',$bIds);
							$oAlert->building_id = $bIds;
							$oAlert->save(false);
						}
						
						$i++;
					}
					/*if(isset($areaMin) && isset($areaMax) && $areaMax != 0){
						 $flag = 1; $fFlag = 1;
						 $searchCriteria['areaMin'] = $areaMin;
						 $searchCriteria['areaMax'] = $areaMax;
						 $queryString .=" AND area_ping  >  ".$areaMin." AND area_ping <= ".$areaMax."";
					}*/
					$this->redirect(array('admin'));
					//$this->redirect(array('building/searchBuildingResult','id'=>$id));
					//$this->redirect(array('floor/create','bid'=>$id));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,'facedStreetList'=>$facedStreetList,'constructionTypeList'=>$constructionTypeList,'quakeResistanceList'=>$quakeResistanceList,'securityList'=>$securityList,'formTypeList'=>$formTypeList));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id){
		$id = (int)$id;
		
		// BEGIN - Create wordpress building reference
		$allBuildingFloors = Floor::model()->findAll('building_id=' .(int)$id);
		$buildingFloors = array();
		if (!empty($allBuildingFloors))
		{
			foreach ($allBuildingFloors as $allBuildingFloor)
			{
				$buildingFloors[] = $allBuildingFloor->floor_id;
			}
		}
		
		$params['floorIds'] = $buildingFloors;
		$wordpress = new Wordpress();
		$wordpress->processIntergrateWordpress($id, Wordpress::BUILDING_TYPE, 'delete', $params);
		$wordpress->reGenerateLocations();
		// End - processing with wordpress
		
		// Delete images related this building
		$this->loadModel($id)->deleteBuildingImages($id);
		
		// Delete floor images
		$allFloors = Floor::model()->findAll('building_id='.(int)$id);
		foreach ($allFloors as $floor)
		{
			$floor->deleteFloorImages($floor->floor_id);
		}
		
		$this->loadModel($id)->deleteBuildingImages($id);
		
		
		// Delete related floors
		Floor::model()->deleteAllByAttributes(array('building_id'=>(int)$id));
		
		// Delete building
		$this->loadModel($id)->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex(){
		$dataProvider=new CActiveDataProvider('Building');
		$this->render('index',array('dataProvider'=>$dataProvider,));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin(){
		$model=new Building('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Building']))
			$model->attributes=$_GET['Building'];
		$this->render('admin',array('model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Building the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id){
		$model=Building::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Building $model the model to be validated
	 */
	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']==='building-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSearchBuilding(){
		$arr = array();
		if(isset($_POST['changeCondition']) && $_POST['changeCondition']==1)
		{
			if(isset($_POST['hdnSearchCriteriaToChange'])&& $_POST['hdnSearchCriteriaToChange'])
			$arr = json_decode($_POST['hdnSearchCriteriaToChange'],true);
		}
		else{
			if(isset($_REQUEST['samecond'])){

				$ar = ProposedArticle::model()->findByPk($_REQUEST['samecond']);

				if($ar && $ar->search_cond)
					$a = $ar->search_cond;
				else
					$a = Yii::app()->user->getState("searchconditionsession");


				if($a)
					$arr = json_decode($a,true);

				if(isset($arr[0]))
					$arr = $arr[0];
			}
			// Yii::app()->user->setState("searchconditionsession","");
		 	// print_r($arr); die;
		}
		// print_r($arr); die;

		$sameSearchCondition = '';
		if(isset($_GET['same']) && $_GET['same'] != "" && $_GET['same'] != 0){
			$sameSearchCondition = $_GET['same'];
		}
		$customerId = '';
		if(isset($_GET['id']) && $_GET['id'] != "" && $_GET['id'] != 0){
			$customerId = $_GET['id'];
		}
		
		$type = '';
		if(isset($_GET['type']) && $_GET['type'] != "" && $_GET['type'] == "office"){
			$type = $_GET['type'];
		}
		
		$tenDayAgo = date("Y-m-d", strtotime("10 days ago"));
		$todayDate = date("Y-m-d");
		$formTypeList = FormType::model()->findAll('is_active = 1');
		$useTypesDetails = UseTypes::model()->findAll('is_active = 1');
		$queryString = 'select  * from floor_update_history where DATE_FORMAT(modified_on,"%Y-%m-%d") >= "'.$tenDayAgo.'" and DATE_FORMAT(modified_on,"%Y-%m-%d") <= "'.$todayDate.'" ORDER BY modified_on DESC';
		
		$queryString2 = 'select  * from building_update_log where DATE_FORMAT(added_on,"%Y-%m-%d") >= "'.$tenDayAgo.'" and DATE_FORMAT(added_on,"%Y-%m-%d") <= "'.$todayDate.'" ORDER BY added_on DESC';
		
		$queryString3 = 'select  * from building where DATE_FORMAT(added_on,"%Y-%m-%d") >= "'.$tenDayAgo.'" and DATE_FORMAT(added_on,"%Y-%m-%d") <= "'.$todayDate.'"';
		
		$queryString4 = 'select  * from floor where DATE_FORMAT(added_on,"%Y-%m-%d") >= "'.$tenDayAgo.'" and DATE_FORMAT(added_on,"%Y-%m-%d") <= "'.$todayDate.'"';
		
		$queryString5 = 'select  * from floor where vacancy_info = 1 and DATE_FORMAT(added_on,"%Y-%m-%d") >= "'.$tenDayAgo.'" and DATE_FORMAT(added_on,"%Y-%m-%d") <= "'.$todayDate.'"';
		
		$updateProperties = Yii::app()->db->createCommand($queryString)->queryAll();
		$updateProperties2 = Yii::app()->db->createCommand($queryString2)->queryAll();
		$updateProperties3 = Yii::app()->db->createCommand($queryString3)->queryAll();
		$updateProperties4 = Yii::app()->db->createCommand($queryString4)->queryAll();
		$updateProperties5 = Yii::app()->db->createCommand($queryString5)->queryAll();
		$this->render('searchBuiding',array('formTypeList'=>$formTypeList,'useTypesDetails'=>$useTypesDetails,'updateProperties'=>$updateProperties,'updateProperties2'=>$updateProperties2,'updateProperties3'=>$updateProperties3,'updateProperties4'=>$updateProperties4,'updateProperties5'=>$updateProperties5,'sameSearchCondition'=>$sameSearchCondition,'customerId'=>$customerId,'type'=>$type,'returnarr'=>$arr));
	}	

	public function actionSearchBuildingResult($return = false,$returnStation = false){
		if(count($_POST) == 0) $_POST = $_GET;
		$rJsonDecode = $_REQUEST;
		if(isset($_REQUEST['form_json'])){
			$rJsonDecode = json_decode($_REQUEST['form_json'],true);
			$reqPossible = array('hdnRPrefId','hdnRailId','hdnLineId','hdnRRouteId');
			foreach($reqPossible as $rp){
				if(isset($_REQUEST[$rp])){
					$rJsonDecode[$rp] = $_REQUEST[$rp];
				}
			}
		}
		Yii::app()->user->setState("searchconditionsession", json_encode($rJsonDecode));

		//print_r($_POST); die;
		$cityCondition = '';
		if(isset($rJsonDecode['districtTownList']) && $rJsonDecode['districtTownList'])
		{
			//print_r($rJsonDecode['districtTownList']); die;
			$str = implode(',', $rJsonDecode['districtTownList']);
			$t = Town::model()->findAllByAttributes(array('code'=>$rJsonDecode['districtTownList']), array('group'=>'town_name'));
			$a = array();
			//$t = Town::model()->findAll(array('condition'=>'code IN('.$str.')','group'=>'code'));
			foreach ($t as $key => $value) {
				if(!in_array($value->town_name, $a)){
					$cityCondition .= '
					<li><span class="condition_name condition_name_list">
					'.$value->town_name.'</li>';
					$a[] = $value->town_name;
				}
			}
			$cityCondition = '';
		}
		  // print_r($cityCondition); die;
		
		$aSearchParams = array();
		$aSearchParams['order'] = ' postal_code ASC, address ASC ';
		if ($_REQUEST['sortby'])
		{
			switch ($_REQUEST['sortby'])
			{
				case 1:
					// 築年浅順:from yougest established year
					$aSearchParams['order'] = ' built_year DESC ';
					break;
				case 2:
					// 駅近:from nearest station
					$aSearchParams['select'] = 't.*';
					$aSearchParams['order'] = ' cast(bs.distance as unsigned) ASC ';
					$aSearchParams['joins'][] = ' LEFT JOIN building_station bs ON t.building_id = bs.building_id';
					$aSearchParams['group'] = ' t.building_id ';
					break;
				case 3:
					// 坪数:from largest area by tsubo
					$aSearchParams['select'] = 't.*, MAX(f.area_ping) as areaPing';
					$aSearchParams['order'] = ' areaPing DESC ';
					$aSearchParams['joins'][] = ' LEFT JOIN floor f ON t.building_id = f.building_id';
					$aSearchParams['group'] = ' t.building_id ';
					break;
				case 4:
					// 基準階面積:from largest average floor area
					$aSearchParams['order'] = ' std_floor_space DESC ';
					
					break;
				case 5:
					// 賃料:from cheapest rent price 
					$aSearchParams['select'] = 't.*, AVG(f.total_rent_price) as TotalRentPrice';
					$aSearchParams['order'] = ' TotalRentPrice ASC ';
					$aSearchParams['joins'][] = ' LEFT JOIN floor f ON t.building_id = f.building_id';
					$aSearchParams['group'] = ' t.building_id ';
					
					break;
				case 6:
					// 保証金: from chepeat deposit price
					$aSearchParams['select'] = 't.*, AVG(f.total_deposit) as TotalDeposit';
					$aSearchParams['order'] = ' TotalDeposit ASC ';
					$aSearchParams['joins'][] = ' LEFT JOIN floor f ON t.building_id = f.building_id';
					$aSearchParams['group'] = ' t.building_id ';
					break;
				case 7:
					// フリーレント期間: from longest free rent term
					$aSearchParams['select'] = 't.*, MAX(f.free_rent_month) as FreeRentMonth';
					$aSearchParams['order'] = ' FreeRentMonth DESC ';
					$aSearchParams['joins'][] = ' LEFT JOIN free_rent f ON t.building_id = f.building_id';
					$aSearchParams['group'] = ' t.building_id ';
					break;
				case 8:
					// 手数料:from cheapest commision fee
					$aSearchParams['select'] = 't.*, MIN(f.charge) as CommisionFee';
					$aSearchParams['order'] = ' CommisionFee ASC ';
					$aSearchParams['joins'][] = ' LEFT JOIN ownership_management f ON t.building_id = f.building_id';
					$aSearchParams['group'] = ' t.building_id ';
					break;
				case 9:
					// 更新日: from latest updated building/floor
					$aSearchParams['select'] = 't.*, AVG(f.modified_on) as Modified';
					$aSearchParams['order'] = ' Modified DESC ';
					$aSearchParams['joins'][] = ' LEFT JOIN floor f ON t.building_id = f.building_id';
					$aSearchParams['group'] = ' t.building_id ';
					break;
				default: 
					$aSearchParams['order'] = ' postal_code_order ASC  ';
					break;
			}
		}
		
		Yii::app()->user->setState("conditionCriteria", $rJsonDecode);
		// print_r($rJsonDecode); die;
		if(!$return || !$returnStation){
			if(isset($_REQUEST['viewBuilding']) && $_REQUEST['viewBuilding'] != 0){
				$resultData = Building::model()->findAll('building_id = '.$_REQUEST['viewBuilding']);
				if(isset($resultData) && count($resultData) > 0){ $floorIds = array();
					$buildingIds = array($_REQUEST['viewBuilding']);
					$floorAry= Floor::model()->findByAll("building_id = ".$_REQUEST['viewBuilding']);
					foreach($floorAry as $fv) $floorIds[] = $fv['floor_id'];
					$this->render('searchedBuidingResult',array('resultData'=>$resultData,'floorIds'=>$floorIds,'buildingIds'=>$buildingIds));
				}else{
					$this->redirect(array('searchBuilding'));
				}
				die;
			}
			if(isset($_REQUEST['hdnRouteBuildingId']) && $_REQUEST['hdnRouteBuildingId'] != 0){
				$buildingIds = explode(',',$_REQUEST['hdnRouteBuildingId']);
				if(isset($_REQUEST['hdnRouteFloorId']) && $_REQUEST['hdnRouteFloorId'] != ''){
					$floorIds = explode(',',$_REQUEST['hdnRouteFloorId']);
				}else{
					$floorIds = array();
				}
				
				$aSearchParams['where'] = (array('t.building_id' => $buildingIds));
				$resultData = Building::model()->getBuildingList($aSearchParams);				
				if(isset($_REQUEST['hdnUId'])){
					$this->setCustomAlert($resultData,$floorIds);
				}
				$floorIds = array_unique($floorIds);
				$this->render('searchedBuidingResult',array('resultData'=>$resultData,'floorIds'=>$floorIds,'buildingIds'=>$buildingIds,'cityCondition'=>$cityCondition));
				die;
				
			}

			if(isset($_POST['hdnAddressBuildingId']) && $_POST['hdnAddressBuildingId'] != 0){
				$buildingIds = explode(',',$_POST['hdnAddressBuildingId']);
				$floorIds = explode(',',$_POST['hdnAddressFloorId']);
				$aSearchParams['where'] = (array('t.building_id' => $buildingIds));
				$resultData = Building::model()->getBuildingList($aSearchParams);
				if(isset($_REQUEST['hdnUId'])){
					$this->setCustomAlert($resultData,$floorIds);
				}
				
				$floorIds = array_unique($floorIds);
				$this->render('searchedBuidingResult',array('resultData'=>$resultData,'floorIds'=>$floorIds,'buildingIds'=>$buildingIds,'cityCondition'=>$cityCondition));
				die;
			}

			if(isset($_GET['pid']) && $_GET['pid'] != '' && $_GET['pid'] != 0){
				$articleData = ProposedArticle::model()->findByPk($_GET['pid']);
				$buildngIds = explode(',',$articleData['building_id']);
				$floorIds = explode(',',$articleData['floor_id']);
				$aSearchParams['where'] = (array('t.building_id' => $buildingIds));
				//$resultData = Building::model()->getBuildingList($aSearchParams);
				$resultData = Building::model()->findAllByAttributes(array('building_id'=>$buildngIds));
				$aFloor = array();
				foreach($buildngIds as $bId){
					$checkAvailBuild = Building::model()->findByPk($bId);
					if(count($checkAvailBuild) > 0){
						$getFloor = Floor::model()->findAll('building_id = '.$bId);
						foreach($getFloor as $availFloor){
							if(in_array($availFloor['floor_id'],$floorIds)){
								$aFloor[] = $availFloor['floor_id'];
							}
						}
					}
				}
				
				$searchallCond = json_decode($articleData['search_cond'],true);
				if(isset($searchallCond[0])) $searchallCond = $searchallCond[0];
				if(count($resultData) > 0){ 
					$this->render('searchedBuidingResult',array('resultData'=>$resultData,'floorIds'=>$aFloor,'buildingIds'=>$buildngIds,'customCondition'=>$searchallCond,'cityCondition'=>$cityCondition));
				}
				die;
			}
			
			if(isset($_GET['oid']) && $_GET['oid'] != '' && $_GET['oid'] != 0){
				$alertData = OfficeAlert::model()->findByPk($_GET['oid']);
				$result_cond = SearchSettings::model()->findByPk($alertData['cond_id']);
				$searchallCond = json_decode($result_cond['ss_json']);
				if(isset($searchallCond->conditionFormData)){
					$searchallCond = Yii::app()->controller->getParamsfromString($searchallCond->conditionFormData);
				}
						//$buildingFormMapper = Yii::app()->controller->__getCondition($searchallCond);
				$buildngIds = explode(',',$alertData['building_id']);
				$flooId = explode(',',$alertData['floor_id']);
				$aSearchParams['where'] = (array('t.building_id' => $buildingIds));
				//$resultData = Building::model()->getBuildingList($aSearchParams);
				$resultData = Building::model()->findAllByAttributes(array('building_id'=>$buildngIds));
				
				$floorIds = array();
				$floorAry= Floor::model()->findAll("floor_id IN (".$alertData['floor_id'].") AND building_id IN (".implode(',',$buildngIds).")");
				foreach($floorAry as $fv) $floorIds[] = $fv['floor_id'];
				
				$this->render('searchedBuidingResult',array('resultData'=>$resultData,'alertFloorIds'=>$flooId,'floorIds'=>$flooId,'buildingIds'=>$buildngIds,'customCondition'=>$searchallCond,'cityCondition'=>$cityCondition));
				die;
			}
	
			if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] != 0){
				$resultData[] = Building::model()->findByPk($_GET['id']);
				if(count($resultData) > 0){ $floorIds = array();
					
					$floorAry= Floor::model()->findAll("vacancy_info = 1 AND building_id = ".$_GET['id']);
					foreach($floorAry as $fv) $floorIds[] = $fv['floor_id'];
					
					$this->render('searchedBuidingResult',array('resultData'=>$resultData,'floorIds'=>$floorIds,'buildingIds'=>array($_GET['id']),'cityCondition'=>$cityCondition));
				}
				die;
			}
			
			if(isset($_GET['fIds']) && $_GET['fIds'] != '' && $_GET['fIds'] != 0){
				$fIds = $_GET['fIds'];
				$buildingIds = array();
				$fIds = explode(',',$fIds);
				$resultData = array();
				
				$otherParam = explode('~',$_GET['final_redi']);
				$district = $otherParam[0];
				$date = $otherParam[1];
				if(isset($otherParam[2])){
					$propertyValuation = $otherParam[2];
					$searchCriteria['propertyValuation'] = $propertyValuation.' '.Yii::app()->controller->__trans('property in ').$district.'('.$date.')';
				}else{
					$searchCriteria['propertyValuation'] = $district.'新着・更新空き物件'.'('.$date.')';
				}
				
				$searchCriteria['floor_id_specification'] = 'フロアID指定';
				$searchCriteria['rent_unit_include'] = '賃料未定フロアも含む';
				
				foreach($fIds as $floor){
					$floorDetails = Floor::model()->findByPk($floor);
					$buildingIds[] = $floorDetails['building_id'];
				}
				
				$finalBuildingIds = array_unique($buildingIds);
				$finalBuildingIds = array_values($finalBuildingIds);
				
				foreach($finalBuildingIds as $building){
					$resultData[] = Building::model()->findByPk($building);
				}
				$this->render('searchedBuidingResult',array('resultData'=>$resultData,'fIds'=>$fIds,'topPage'=>1,'floorIds'=>$fIds,'buildingIds'=>$finalBuildingIds,'cityCondition'=>$cityCondition));
				die;
			}
		}
		
		
		if($return || $returnStation || isset($_POST['areaMinValue'])){
			$resi = 0; $floor_id = array(); $vacantType = 0; $vacantQr = '';
			$floorType = '';
			/********************** floor  **********************/
			$areaMin = $_POST['areaMinValue'];
			$areaMax = $_POST['areaMaxValue'];
			$floorMin = $_POST['floorMin'];
			$floorMax = $_POST['floorMax'];
			$unitMin = $_POST['unitMinValue']*10000;
			$unitMax = $_POST['unitMaxValue']*10000;
			$brokerageFree = isset($_POST['brokerageFree']) ? $_POST['brokerageFree'] : '';	
			$facilities = isset($_POST['facilities']) ? $_POST['facilities'] : '';	
			
			$possibleDataMin = $_POST['possibleDataMin'];
			$possibleDataMax = $_POST['possibleDataMax'];
			if(isset($_POST['customerName']) && $_POST['customerName']!= ''){
				$specifyCustomerName = $_POST['customerName'];
			}
			$costMin = $_POST['costMinAmount'];
			$costMax = $_POST['costMaxAmount'];
			$floorType = isset($_POST['floorType']) ? $_POST['floorType'] : array();

			/*************** Building ***************************/
			$updateDateDrop = $_POST['updateDateDrop'];
			$shortRent = isset($_POST['shortRent']) ? $_POST['shortRent'] : '';
			$deadlineCheck = isset($_POST['deadlineCheck']) ? $_POST['deadlineCheck'] : '';
			$buildingAge = $_POST['buildingAge'];
			$formTypeList = isset($_POST['formTypeList']) ? $_POST['formTypeList'] : '';
			$walkFromStation = isset($_POST['walkFromStation']) ? $_POST['walkFromStation'] : '';
			$statusRequirement = isset($_POST['statusRequirement']) ? $_POST['statusRequirement'] : '';
			$requirementOfBuilding = isset($_POST['requirementOfBuilding']) ? $_POST['requirementOfBuilding'] : '';
			$lenderType = isset($_POST['lenderType']) ? $_POST['lenderType'] : '';
			/*********** Search Building ****************/
			$searchCriteria = array();
			$flag = 0; $mFlag = 0; $fFlag = 0;
			$queryString5 = '';
			$queryString = "SELECT  building_id,floor_id FROM floor WHERE 1 = 1 ";
			if(isset($statusRequirement) && !empty($statusRequirement)){
				
				if(in_array("1", $statusRequirement) && in_array("3", $statusRequirement)){
				 	$searchCriteria['statusRequirement'] = 'Wanted';
					$searchCriteria['statusRequirement'] = 'No vacancy';
					$vacantType = 0;
				 }else if (in_array("1", $statusRequirement)){
					 $searchCriteria['statusRequirement'] = 'Wanted';
					 $queryFloorString[] = "vacancy_info = 1";
					 $vacantType = 1;
					 $vacantQr = 'vacancy_info = 1';
				 }else if (in_array("3", $statusRequirement)){
					 $searchCriteria['statusRequirement'] = 'No vacancy';
					 $queryFloorString[] = "vacancy_info = 0";
					 $vacantType = 3; 
					 $vacantQr = 'vacancy_info = 0';
				 }
			 }
			
			if(isset($areaMin) && isset($areaMax) && $areaMax != 0){
				 $flag = 1; $fFlag = 1;
				 $searchCriteria['areaMin'] = $areaMin;
				 $searchCriteria['areaMax'] = $areaMax;
				 $queryString .=" AND area_ping  >  ".$areaMin." AND area_ping <= ".$areaMax."";
			}
			// print_r($searchCriteria);die;

			if(isset($unitMin) && isset($unitMax) && $unitMax != 0 ){
				 $flag = 1;  $fFlag = 1;
				 $searchCriteria['unitMin'] = $unitMin;
				 $searchCriteria['unitMax'] = $unitMax;
				 $queryString .=" AND rent_unit_price  >  ".$unitMin." AND rent_unit_price <= ".$unitMax."";
			}
			
			if(isset($costMin) && isset($costMax) && $costMax != 0){
				 $flag = 1;  $fFlag = 1;
				 $searchCriteria['costMin'] = $costMin;
				 $searchCriteria['costMax'] = $costMax;
				 $queryString .=" AND unit_condo_fee  > ".$costMin." AND unit_condo_fee <= ".$costMax."";
			}

			if(isset($floorMin) && isset($floorMax) && $floorMax  != 0 ){
				 $flag = 1;  $fFlag = 1;
				 $searchCriteria['floorMin'] = $costMin;
				 $searchCriteria['floorMax'] = $costMax;
				 $queryString .=" AND floor_down  > ".$floorMin." AND floor_up <= ".$floorMax."";
			}

			if(isset($possibleDataMin) && isset($possibleDataMax) && ($possibleDataMin != 0 || $possibleDataMax != 0)){
				 $flag = 1;  $fFlag = 1;
				 if($possibleDataMin != 0){
				 	$searchCriteria['possibleDataMin'] = $possibleDataMin;
					$queryString .=" AND SUBSTR(move_in_date,1,7)  >=  '".$possibleDataMin."'";
				 }
				 if($possibleDataMax != 0){
				 	$searchCriteria['possibleDataMax'] = $possibleDataMax;
					$queryString .=" AND SUBSTR(move_in_date,1,7)  <=  '".$possibleDataMax."'";
				 }
			 }

			 if(isset($shortRent) && $shortRent == 1){
				 $flag = 1;  $fFlag = 1;
				 $searchCriteria['shortRent'] = 'Short rent available';
				 $queryString .=" AND short_term_rent = 1 ";
			 }
			 /*************** buiding query *************/

			 $queryString1 = 'select building_id from building where 1 = 1';
			 $flag1 = 0;
			 if(isset($buildingAge) && $buildingAge != 0){
				 $flag1 = 1; 
				 $searchCriteria['buildingAge'] = $buildingAge;
			     $queryString1 .= ' And SUBSTR(built_year,1,4) >= "'.$buildingAge.'"';
			 }

			 $queryString6 = '';
			 $flagUpdate = 0;
			 if(isset($updateDateDrop) && $updateDateDrop != 0){
				 $todayDate = date("Y-m-d");  $fFlag = 1;
				 if(in_array($updateDateDrop,array(1,2,3))){
					 $flagUpdate = 1; $ldays = 60;
					 $daysAgo = date("Y-m-d", strtotime("7 days ago"));
					 if($updateDateDrop == 1){ $ldays = 7; $daysAgo = date("Y-m-d", strtotime("30 days ago"));  }
					 if($updateDateDrop == 2){ $ldays = 30; $daysAgo = date("Y-m-d", strtotime("60 days ago"));  }
					 $searchCriteria['updateDateDrop'] = Yii::app()->controller->__trans('Last '.$ldays.' day updated');
					 $queryString6 = 'select  building_id,floor_id from floor_update_history where DATE_FORMAT(modified_on,"%Y-%m-%d") >= "'.$daysAgo.'" 
					  and DATE_FORMAT(modified_on,"%Y-%m-%d") <= "'.$todayDate.'" ORDER BY floor_update_history_id DESC';
				 }else{
					$expDropdown = explode('~',$updateDateDrop); $flagUpdate = 1;
					$utypetxt = 'Recruitment  Floors';
					if($expDropdown[1] == 'u'){	$utypetxt = 'Updated Properties';
					  $queryString6 = 'select  building_id,floor_id from floor_update_history where DATE_FORMAT(modified_on,"%Y-%m-%d") = "'.$expDropdown[0].'" group by floor_id';
					}else if($expDropdown[1] == 'a'){	$utypetxt = 'Added new properties';
						$queryString6 = 'select  building_id,floor_id from floor where DATE_FORMAT(added_on,"%Y-%m-%d") = "'.$expDropdown[0].'" ';
					}else if($expDropdown[1] == 'r'){
						
						 $queryString6 = 'select  building_id,floor_id from floor where '.($vacantQr != '' ? $vacantQr.' and ' : '').' DATE_FORMAT(added_on,"%Y-%m-%d") = "'.$expDropdown[0].'"';
					}
					$searchCriteria['updateDateDrop'] = $expDropdown[0].' '.Yii::app()->controller->__trans($utypetxt);
				 }
			 }
			 
			 if(isset($facilities) && !empty($facilities)){
				 $searchCriteria['facilities'] = $facilities;
				 foreach($facilities as $fac){
				 	if(in_array($fac,array('1','3'))){ $flag = 1;  $fFlag = 1;
						if($fac == '1') $queryString .=" AND separate_toilet_by_gender = 2";
						else $queryString .= ' AND air_conditioning_facility_type = "個別・セントラル"';
					}else{ $flag1 = 1;
						if($fac == '2') $queryString1 .= ' AND SUBSTR(oa_floor,1,1) = 2';
						if($fac == '4'){ $queryString .= ' AND floor_partition != ""';  $fFlag = 1; }
						if($fac == '5') $queryString1 .= ' AND earth_quake_res_std = "Seismic strengthening"';
						if($fac == '6') $queryString1 .= ' AND wholesale_lease = 1';
						if($fac == '7') $queryString1 .= ' AND emr_power_gen = 2';
					}
				 }
			 }

			 /************************ customer query *************/
			 $queryString3 = '';
			 if(isset($specifyCustomerName) && $specifyCustomerName != ''){ $mFlag = 1;
				$searchCriteria['specifyCustomerName'] = $specifyCustomerName;
				$queryString3 = 'SELECT proposed_article.building_id  FROM proposed_article JOIN customer ON proposed_article.customer_id=customer.customer_id  WHERE company_name ="'.$specifyCustomerName.'"';
			 }		 

			 $queryString4 = 'select building_id,floor_id from ownership_management where 1 = 1';
			 $flag2 = 0;
			 if(isset($formTypeList) && !empty($formTypeList)){   $fFlag = 1;
				 $flag2 = 1;
				 $searchCriteria['formTypeList'] = $formTypeList;
				 $formTypeExp = implode(',',$formTypeList);
				 $queryString4 .= ' And management_type IN ("'.$formTypeExp.'") group by building_id';
			 }
			 

			 $queryString7 = array();
			 if(isset($brokerageFree) && ($brokerageFree) == 1){ $qEx = 1;  $mFlag = 1;  $fFlag = 1;
				 $searchCriteria['brokerageFree'] = 'Brokerage free included';
				 $getOwnerAllData = 'select building_id,floor_id from ownership_management where 1 = 1';
				 $ownerAllData = Yii::app()->db->createCommand($getOwnerAllData)->queryAll();
					foreach($ownerAllData as $result){
						 if(is_numeric($result['charge'])){
							 $queryString7[] = $result['building_id'];
						 }
						 $queryString7 = array_unique($queryString7);
						 $queryString7 = array_values($queryString7);
					}
			 }

			 $onwerData = array();
			 $finalData = array();
			 if(isset($lenderType) &&  !empty($lenderType)){ $qEx = 1;  $mFlag = 1;  $fFlag = 1;
				 $searchCriteria['lenderType'] = $lenderType;
				 if(isset($lenderType) && !empty($lenderType)){ 
					 foreach($lenderType as $lender){
						 $queryString8 = 'select building_id,floor_id from ownership_management where ownership_type = '.$lender.'';
						 $onwerData  = Yii::app()->db->createCommand($queryString8)->queryAll();
						 foreach($onwerData as $data){
						 	$finalData[] = $data;
						 }
					 }
				 }
			 }
			 /***************************end *************************/			 
			 
			 if(isset($statusRequirement) && !empty($statusRequirement)){ $flag = 1;  $fFlag = 1;
				 if (in_array("2", $statusRequirement)){
					 $searchCriteria['statusRequirement'] = 'Free due within one year';
					 $todayDate = date("Y/m");
					 $oneYearOn = date('Y/m', strtotime("+ 365 day"));
					 $queryFloorString[] = "SUBSTR(vacant_schedule,1,7) >='". $todayDate."' AND SUBSTR(vacant_schedule,1,7) <= '".$oneYearOn."'";
				 }
				 $queryString .= $floorCondition = ' AND (' . implode(' OR ', $queryFloorString) . ') ';
			 }
			 /************* get Property with deadline ***************/ 
			 $queryString9 = '';
			 if(isset($deadlineCheck) && $deadlineCheck == 1){  $mFlag = 1;
				$searchCriteria['deadlineCheck'] = 'Deadline Check';
				$queryString9 = 'select building_id from building where `building_with_deadline` like "1-%" Group by building_id';
			 }
			 /***********************end **********************/
			 /*****************Get station query ****************/
			 if(isset($walkFromStation) && ($walkFromStation) != ''){ $mFlag = 1;
				 $searchCriteria['walkFromStation'] = $walkFromStation;
				 $queryString5 = 'select building_id from building_station where time <='.$walkFromStation.' And time != ""'.''.'  group by building_id order by time desc';
			 }
			 /***********************end **********************/
			 
			 /******************** final queries run all********************/
			 $resultData = array();
			 if($flag == 1){
				 $resultData[$resi++][] = Yii::app()->db->createCommand($queryString)->queryAll();
			 }
			 
			 if($flag1 == 1){
				 $resultData[$resi++][] = Yii::app()->db->createCommand($queryString1)->queryAll();
			 }
			 
			 if($queryString3 != ''){
				 $resultData[$resi++][] = Yii::app()->db->createCommand($queryString3)->queryAll();
			 }
			 
			 if($flag2 == 1){
			 	$resultData[$resi++][] = Yii::app()->db->createCommand($queryString4)->queryAll();
			 }
			 
			 if($queryString5 != ''){
			 	$resultData[$resi++][] = Yii::app()->db->createCommand($queryString5)->queryAll();
			 }
			 
			 if($queryString6 != ''){
				 $resultData[$resi++][] = Yii::app()->db->createCommand($queryString6)->queryAll();
			 }
			 if($queryString9 != ''){
				 $resultData[$resi++][] = Yii::app()->db->createCommand($queryString9)->queryAll();
				 //print_r(Yii::app()->db->createCommand($queryString9)->queryAll());
				 //exit;
			 }
			 if(isset($finalData) && !empty($finalData)){
				 $resultData[$resi++][] = $finalData;
			 }
			 
			 if(isset($queryString7) && !empty($queryString7)){
			 	   $resultData[$resi++][] = $queryString7;
			 }
			 $buildinId = array();
			 $floor_id = array();
			 $aboveFlag = true;
			if($flagUpdate == 0 && $flag == 0 && $flag1 == 0 && $flag2 == 0 && $mFlag == 0){
				$aboveFlag = false;
			}

			
			$mi = 0;
			
			 if(isset($resultData) && !empty($resultData)){
				foreach($resultData as $res){
					foreach($res as $r){
						foreach($r as $rin){
							if(isset($rin['building_id'])) $buildinId[$mi][] = $rin['building_id'];
							if(isset($rin['floor_id'])) $floor_id[$mi][] = $rin['floor_id'];
						}
					}
					$mi++;
				 }
				 
				 foreach($buildinId as $k=>$val){
						$buildinId[$k] = (array_unique($buildinId[$k]));
						$buildinId[$k] = array_values($buildinId[$k]);
				 }
				 foreach($floor_id as $k=>$val){
						$floor_id[$k] = (array_unique($floor_id[$k]));
						$floor_id[$k] = array_values($floor_id[$k]);
				 }
				 
				
				
				 if(count($buildinId) > 0) $buildinId = $this->custom_intersect($buildinId);
				 else $buildinId = array();
				 
				 if(count($floor_id) > 0) $floor_id = $this->custom_intersect($floor_id);
				 else $floor_id = array();
				 
				 
				 if($fFlag == 0) $floor_id = false;
			 }elseif($aboveFlag == false){
					$bArray = Yii::app()->db->createCommand('select building_id from building')->queryAll();
					foreach($bArray as $bid){
						$buildinId[] = $bid['building_id'];
					}
					$fArray = Yii::app()->db->createCommand('select floor_id from floor')->queryAll();
					foreach($fArray as $fid){
						$floor_id[] = $fid['floor_id'];
					}
			}
			
			
			
			if($fFlag == 0){
				$fArray = Yii::app()->db->createCommand('select floor_id from floor')->queryAll();
				foreach($fArray as $fid){
					$floor_id[] = $fid['floor_id'];
				}
			}
			
			 /* Adding floor details */
			 
			if(isset($requirementOfBuilding) && $requirementOfBuilding == 1){
				if(isset($buildinId) && !empty($buildinId)){
					$floor_id = array();
					$getAllData = array();
					$floorDetailsAll = array();
					$getAllData = Floor::model()->findAll('building_id IN ('.implode(',',$buildinId).')');
					foreach($getAllData as $allFloor){
						$floor_id[] = $allFloor->floor_id;
						$floorDetailsAll[] =  $allFloor;
					}
				}
			}else{
				 $floorDetails = array();
				 if(isset($floorType) && !empty($floorType)){ 
					$searchCriteria['floorType'] = $floorType;
					foreach((array)$floor_id as $fkey=>$id){
						$floor_details = Floor::model()->findByPk($id);
						$floor_type = explode(',',$floor_details['type_of_use']);
						if(count(array_intersect($floor_type,$floorType)) == 0){
							unset($floor_id[$fkey]);
						}
					 }
				 }
				
			}
			 
			
			 
			 /* return false if no query fired above */
			
			if($return == true || $returnStation == true){
				return array($buildinId,$floor_id);
			}
			 
			/************ building get by name **************/
			if((isset($_POST['buildingSearchAddressTxt']) && $_POST['buildingSearchAddressTxt'] != '') || (isset($_POST['buildingSearchName']) && $_POST['buildingSearchName'] != '')){
				$cond = '';
				if($_POST['buildingSearchAddressTxt'] != ''){
					$searchCriteria['buildingSearchAddressTxt'] = $_POST['buildingSearchAddressTxt'];
					$cond .= 'address like "%'.$_REQUEST['buildingSearchAddressTxt'].'%" ';
				}
				if($_POST['buildingSearchName'] != ''){
					$searchCriteria['buildingSearchName'] = $_POST['buildingSearchName'];
					if($_POST['buildingSearchAddressTxt'] != '') $cond .= ' AND (';
					else $cond .= '(';
					$buildingMultipleName = preg_split('/\r\n|[\r\n]/', $_POST['buildingSearchName']);
					$mi = 0;
					foreach($buildingMultipleName as $buildname){ 
						if($buildname == '') continue;
						if($mi != 0) $cond .= ' OR '; 
						$mi = 1;
						$cond .= ' name like "%'.$buildname.'%"';
					}
					$cond .= ')';
				}
				
				if(!$resultData) $resultData = array();
				$bIds = CHtml::listData(Building::model()->findAll($cond." AND building_id IN (".implode(',',$buildinId).")"), 'building_id','building_id');
				$buildinId = array_intersect($bIds,$buildinId);
				
			}else if($_REQUEST['buildingSearchAddress'] != '' && $_REQUEST['cityName'] == 'searchByFullAdd'){
				$searchCriteria['buildingSearchAddress'] = $_POST['buildingSearchAddress'];
				if(!$resultData) $resultData = array();			
				  
				$arrSearchAddress = preg_split('/[\n\r]+/', $_REQUEST['buildingSearchAddress']);
				$arrSearchAddress = implode("|", $arrSearchAddress);
				$bIds = CHtml::listData(Building::model()->findAll('address regexp "'.$arrSearchAddress.'" AND building_id IN ('.implode(',',$buildinId).')'),'building_id','building_id');
				//$bIds = CHtml::listData(Building::model()->findAll('address LIKE "%'.$_REQUEST['buildingSearchAddress'].'%" AND building_id IN ('.implode(',',$buildinId).')'),'building_id','building_id');
				$buildinId = array_intersect($bIds,$buildinId);
			}else if($_REQUEST['buildingSearchAddress'] != ''  && $_REQUEST['cityName'] == 'searchByNearAdd'){
				if(!$resultData) $resultData = array(); $bArray = array();
				if(isset($_REQUEST['radiusValue'])){
					$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$_REQUEST['buildingSearchAddress'].'&sensor=false');
					$output = json_decode($geocode);
					$latitude = $output->results[0]->geometry->location->lat;
					$longitude = $output->results[0]->geometry->location->lng;
		
					$dist = $_REQUEST['radiusValue'];
					$str='building_id DESC';
					$tblName = 'building';
					//$b = Building::model()->find(array('condition'=>'address LIKE :match','params'=>array(':match'=> '%'.$_REQUEST['buildingSearchAddress'].'%')));
					
					//if(count($b) > 0){
						//$bArray = Yii::app()->db->createCommand('SELECT *, 3956 * 2 * ASIN(SQRT( POWER(SIN(('.$latitude.' - abs(map_lat))*pi()/180/2),2)+COS('.$latitude.'*pi()/180 )*COS(abs(map_lat)*pi()/180)*POWER(SIN(('.$longitude.'-map_long)*pi()/180/2),2))) as distance FROM building WHERE building_id IN ('.implode(',',$buildinId).') AND map_long between ('.$longitude.'-'.$dist.'/abs(cos(radians('.$latitude.'))*69)) and ('.$longitude.'+'.$dist.'/abs(cos(radians('.$latitude.'))*69)) and map_lat between ('.$latitude.'-('.$dist.'/69)) and ('.$latitude.'+('.$dist.'/69)) having distance < '.$dist.';')->queryAll();
						$bArray = Yii::app()->db->createCommand('SELECT *, 111.045*DEGREES(ACOS(COS(RADIANS('.$latitude.'))*COS(RADIANS(map_lat))*COS(RADIANS('.$longitude.')-RADIANS(map_long))+SIN(RADIANS('.$latitude.'))*SIN(RADIANS(map_lat)))) AS distance FROM building WHERE building_id IN ('.implode(',',$buildinId).') HAVING distance < '.$dist)->queryAll();
					/*}else{
						$bArray = array();
					}*/
				}else{
					$bArray = Building::model()->findAll(array('condition'=>'address LIKE :match AND building_id IN ('.implode(',',$buildinId).')','params'=>array(':match'=> '%'.$_REQUEST['buildingSearchAddress'].'%')));
				}
				$bIds = CHtml::listData($bArray,'building_id','building_id');
				$buildinId = array_intersect($bIds,$buildinId);
				/************************** end ******************/
					/*****search build and floor by id *********/
			}else if($_REQUEST['buildingSearchId'] != '' || $_REQUEST['floorSearchId'] != ''){	
				if(!$resultData) $resultData = array();
				$tmpFlrBids = array();
				if($_REQUEST['floorSearchId'] != ''){
					//echo "Floor Id = ".$_REQUEST['floorSearchId'];
					$floorMultipleId = preg_split('/\r\n|[\r\n]/', $_POST['floorSearchId']);
						
					foreach($floorMultipleId as $bkmid=>$bmid) $floorMultipleId[$bkmid] = '"'.$bmid.'"';
					$fArray = Floor::model()->findAll('floorId IN ('.implode(',',$floorMultipleId).') AND floor_id IN ('.implode(',',$floor_id).')');
					//echo "<br/>Count = ".count($fArray);
					
					$tmpFlrBids = CHtml::listData($fArray,'building_id','building_id');
					$fIds = CHtml::listData($fArray,'floor_id','floor_id');
					$floor_id = array_intersect($fIds,$floor_id);
					//echo "<pre>";
					//print_r($floor_id);
					//die;
				}
				
				if($_REQUEST['buildingSearchId'] != ''){
					$searchCriteria['buildingSearchId'] = $_POST['buildingSearchId'];	
					$buildingMultipleId = preg_split('/\r\n|[\r\n]/', $_POST['buildingSearchId']);
					foreach($buildingMultipleId as $bkmid=>$bmid) $buildingMultipleId[$bkmid] = '"'.$bmid.'"';
					$bArray = Building::model()->findAll('buildingId IN ('.implode(',',$buildingMultipleId).') AND building_id IN ('.implode(',',$buildinId).')');
					$bIds = CHtml::listData($bArray,'building_id','building_id');
					if(count($tmpFlrBids) > 0){
						$bIds = array_merge($bIds,$tmpFlrBids);
					}
					$buildinId = array_intersect($bIds,$buildinId);
				}else{
					if(count($tmpFlrBids) > 0){
						$buildinId = array_intersect($buildinId,$tmpFlrBids);
					}
				}
			}else if(isset($_POST['floorSearchOwnerName']) && $_POST['floorSearchOwnerName'] != ''){
				$floorSearchOwnerName = preg_split('/\r\n|[\r\n]/', $_POST['floorSearchOwnerName']);
				$cond = ''; $tmBid = array();
				foreach($floorSearchOwnerName as $floorownername){
					if($cond != '') $cond .= ' OR ';
					$cond .= 'owner_company_name like "%'.$floorownername.'%"';
				}
				if(!$resultData) $resultData = array();
				$floorOwnerDetails = OwnershipManagement::model()->findAll($cond);
				foreach((array)$floorOwnerDetails as $floorown){
					foreach((array)$buildinId as $key => $val){
						if($val == $floorown['building_id']){
							$tmBid[] = $val;
						}
					}
				}
				$buildinId = array_intersect($tmBid,$buildinId);
			}else{
				
				if(!$resultData) $resultData = array();
				if(!empty($finalBuildingAddressIds)){
					foreach($finalBuildingAddressIds as $building){
						$resultData[] = Building::model()->findByPk($building);
					}
				}else{
					$floorDetail = Floor::model()->findAll();
					foreach($floorDetail as $fl){
						$getTypes[$fl['floor_id']] = explode(',',$fl['type_of_use']);
					}
					$newIds = array();
					$i = 0;
					foreach($getTypes as $key=>$val){
						if(count(array_intersect($val,$floorType)) >= 1){
							$newIds[] = $key;
						}
						$i++;  
					}
					foreach($newIds as $floor){
						$floorData = Floor::model()->findByPk($floor);
						$buildingIds[] = $floorData['building_id'];
					}
					if(!empty($buildingIds)){
						$buildingIds = array_unique($buildingIds);
						foreach($buildingIds as $build){
							$buildDetails = Building::model()->findByPk($build);
							$resultData[] = $buildDetails;
						}
					}
				}
			}
			
			
			
			/************************* end *********************************/
			if(!empty($buildinId)){
				$buildinId = array_values(array_unique($buildinId));
				$filteredBuild = Building::model()->findAll('building_id IN ('.implode(',',$buildinId).')');
				$buildinId = CHtml::listData($filteredBuild,'building_id','building_id');
				$buildinId = array_values(array_unique($buildinId));
				$fArray = Floor::model()->findAll('building_id IN ('.implode(',',$buildinId).') '.($vacantQr != '' ? ' and '.$vacantQr : ''));
				$fIds = CHtml::listData($fArray,'floor_id','floor_id');
				$floor_id = array_intersect($fIds,$floor_id);
				$buildinId = array_unique($buildinId);
				$floor_id = array_unique($floor_id);
				
				$aSearchParams['where'] = (array('t.building_id' => $buildinId));
				$resultData = Building::model()->getBuildingList($aSearchParams);
				
			}else{
				$floor_id = array();
				$resultData = array();
			}
			
			$allFloorCounting = count($floor_id);
			if(isset($_REQUEST['hdnUId'])){
				if(isset($floorIds) && !empty($floorIds)){
					$floorIds = $floorIds;
				}else{
					if(isset($floor_id) && !empty($floor_id)){
						$floorIds = $floor_id;
					}else{
						$floorIds = array();
					}
				}	
				$this->setCustomAlert($resultData,$floorIds,$searchCriteria);
			}
			
			
			/* Last time filtering for unique buildings */
			$alreadyAdded = array();
			foreach($resultData as $ebk=>$eachBuild){
				if(in_array($eachBuild->building_id,$alreadyAdded)){
					unset($resultData[$ebk]);
				}else{
					$alreadyAdded[] = $eachBuild->building_id;
				}
			}
			
			
			if($return == true){
				return $resultData;
			}
			if($returnStation == true){
				return $resultData;
			}
			$this->render('searchedBuidingResult',array('resultData'=>$resultData, 'floorIds'=>$floor_id,'buildingIds'=>$buildinId,'cityCondition'=>$cityCondition));
		}else{
			$this->redirect(array('searchBuilding'));
		}
	}
	
	public function setCustomAlert($resultData,$floorIds,$seachC = null){
		/*echo "<pre>";
		print_r($searchCriteria);
		die;*/
		$buildids = array();
		foreach($resultData as $r){
			$buildids[] = $r->building_id;
		}
		if(isset($floorIds) && !empty($floorIds)){
			$floorIds = $floorIds;
		}else{
			$floorIds = array();
		}
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		$loguser_id = $users->user_id;
		$coid = 0;
		$rJsonDecode = $_REQUEST;
		if(isset($_REQUEST['form_json'])){
			$rJsonDecode = json_decode($_REQUEST['form_json'],true);
			$reqPossible = array('hdnRPrefId','hdnRailId','hdnLineId','hdnRRouteId');
			foreach($reqPossible as $rp){
				if(isset($_REQUEST[$rp])){
					$rJsonDecode[$rp] = $_REQUEST[$rp];
				}
			}
		}else{
			$rJsonDecode = $_REQUEST;
		}
		
		$ss = new SearchSettings();
		$ss->ss_json = json_encode($rJsonDecode);
		$sssave = $ss->save(false);
		$coid = $ss->primaryKey;
		
		if(!isset($_REQUEST['keepold'])){
			Yii::app()->db->createCommand()->delete('office_alert', 'customer_id=:id', array(':id'=>$_REQUEST['hdnUId']));
		}
		$user=Yii::app()->db->createCommand()->insert('office_alert',array('proposed_article_name'=>'Propose article','building_id'=>implode(',',$buildids),'floor_id'=>implode(',',$floorIds),'user_id'=>$loguser_id,'cond_id'=>$coid,'customer_id' => $_REQUEST['hdnUId'],'office_alert_rand_id' => mt_rand(100000,9999999),'added_by' => $loguser_id,'added_on' => date('Y-m-d H:i:s')));	
		$this->redirect(array('customer/fullDetail&show=3&id='.$_REQUEST['hdnUId']));
		die;
	}

	public function actionSingleBuilding(){
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" && $_REQUEST['id'] != 0){
			$floorDetails = Floor::model()->findByPk($_REQUEST['id']);
			$buildingDetails = Building::model()->findByPk($floorDetails['building_id']);			

			$this->pageTitle = $buildingDetails['name'].' | Japan Properties DB';
			$this->render('singleBuildingDetails',array('floorDetails'=>$floorDetails,'buildingDetails'=>$buildingDetails));
		}else{
			$this->redirect(array('searchBuilding'));
		}
	}	

	public function actionChangeBuildingInfo(){
		$facedStreetList = FacedStreet::model()->findAll('is_active = 1');
		$constructionTypeList = ConstructionType::model()->findAll('is_active = 1');
		$quakeResistanceList = QuakeResistanceStandards::model()->findAll('is_active = 1');
		$securityList = Security::model()->findAll('is_active = 1');
		$formTypeList = FormType::model()->findAll('is_active = 1');		

		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" && $_REQUEST['id'] != 0){
			$buildingDetails = Building::model()->findByPk($_REQUEST['id']);
			$result = array();
			$result = $this->renderPartial('changeBuildingInfo',array('buildingDetails'=>$buildingDetails,'constructionTypeList'=>$constructionTypeList,'quakeResistanceList'=>$quakeResistanceList,'securityList'=>$securityList),true);
			echo json_encode($result);
			die;
		}
	}	

	public function getAddressByGoogleMap($address, $lang = 'ja'){
		$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&language=" . $lang);
		$json = json_decode($json);
	
		$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	
		// retrieve data with lat/long to get full data
		$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&language=".$lang);
		$json = json_decode($json);
	
		foreach($json->results[0]->address_components as $comp){
			if(in_array('administrative_area_level_1',$comp->types)){
				$prefecture = $comp->long_name;
			}
		}
	
		foreach($json->results[0]->address_components as $comp){
			if(in_array('locality',$comp->types)){
				$district = $comp->long_name;
			}
		}

		$break_parent = false;
		foreach($json->results as $results){
			if ($break_parent) break;
			foreach($results->address_components as $comp){
				if(in_array('postal_code',$comp->types)){
					$postalCode_origin = $comp->long_name;
					$postalCode = str_replace('-', '', $postalCode_origin);
					$addressData = Yii::app()->controller->getAddressDataCSVFromPostalCode($postalCode);
					$postalCodeOrder = $addressData[3];
					
					$break_parent = true;
					break;
				}
			}
		}
		
	
		foreach($json->results[0]->address_components as $comp){
			if(in_array('sublocality_level_1',$comp->types)){
				$town = $comp->long_name;
			}
		}
	
		
		$address_en = str_replace('Japan, ', '', $json->results[0]->formatted_address);
		$address_en = str_replace(', Japan', '', $json->results[0]->formatted_address);
		$address_en = str_replace(@$postalCode_origin, '', $address_en);
		$address_en = trim(str_replace('〒', '', $address_en));
		
		return array(
			'lat' => $lat,
			'long' => $long,
			'address_en' => $address_en,
			'prefecture' => @$prefecture,
			'district' => @$district,
			'town' => @$town,
			'postalCode' => @$postalCode,
			'postalCodeOrder' => @$postalCodeOrder
		);
			
	}
	
	public function actionSaveBuildingInfo(){
		$getString = $_REQUEST['formdata'];
		parse_str($getString, $getArray);	
		
		if(isset($getArray) && count($getArray) > 0){
			$buildingDetails = Building::model()->findByPk($getArray['id']);
			$buildingDetails->name = $getArray['name'];
			$buildingDetails->name_en = $getArray['name_en'];
			$buildingDetails->search_keywords_ja = $getArray['search_keywords_ja'];
			$buildingDetails->search_keywords_en = $getArray['search_keywords_en'];
			$buildingDetails->is_featured = $getArray['is_featured'];
			$buildingDetails->description_ja = $getArray['description_ja'];
			$buildingDetails->description_en = $getArray['description_en'];
			$buildingDetails->avg_neighbor_fee_min = $getArray['avg_neighbor_fee_min'];
			$buildingDetails->avg_neighbor_fee_max = $getArray['avg_neighbor_fee_max'];
			$buildingDetails->video_type = $getArray['video_type'];
			$buildingDetails->video_id = $getArray['video_id'];
			
			if(isset($getArray['build_check'])){
				$buildingDetails->bill_check = $getArray['build_check'];
			}else{
				$buildingDetails->bill_check = 0;
			}
			$buildingDetails->old_name = $getArray['old_name'];
			$buildingDetails->name_kana = $getArray['name_kana'];			
			$buildingDetails->address = $getArray['address'];
			$buildingDetails->construction_type_id = $getArray['constructionType'];
			$buildingDetails->construction_type_name = $getArray['constructionTypename'];
			$buildingDetails->construction_type_name_en = $getArray['constructionTypenameEn'];
			$buildingDetails->floor_scale = $getArray['floor_scale_up'].'-'.$getArray['floor_scale_down'];
			$buildingDetails->exp_rent = $getArray['exp_rent'].($getArray['exp_rent2'] != "" ? '~'.$getArray['exp_rent2'] : "").'-'.$getArray['exp_rent_opt'];
			if(isset($getArray['exp_rent_disabled'])){
				$buildingDetails->exp_rent_disabled = $getArray['exp_rent_disabled'];
			}
			$buildingDetails->earth_quake_res_std = $getArray['earth_quake_res_std'];
			$buildingDetails->earth_quake_res_std_note = $getArray['earth_quake_res_std_note'];
			$buildingDetails->emr_power_gen = $getArray['emr_power_gen'];			
			$buildingDetails->built_year = $getArray['build_year'].'-'.$getArray['build_month'];
			$buildingDetails->renewal_data = $getArray['renewal_data'];
			$buildingDetails->renewal_data_en = $getArray['renewal_data_en'];
			$buildingDetails->std_floor_space = $getArray['std_floor_space'];
			$buildingDetails->total_floor_space = $getArray['total_floor_space'];
			$buildingDetails->total_rent_space_unit = $getArray['total_rent_space_unit'];
			$buildingDetails->shared_rate = $getArray['shared_rate'];
			if(isset($getArray['building_with_deadline'])){
				$buildingDetails->building_with_deadline = $getArray['building_with_deadline'].'-'.$getArray['building_with_deadline_date'];
			}
			/****************** elevator ******************/
			if(isset($getArray['elevator'])){
				if( $getArray['elevator'] == 1){
					$buildingDetails->elevator = $getArray['elevator'].'-'.$getArray['b_ev_group'].'-'.$getArray['b_ev_group2'].'-'.$getArray['b_ev_group3'].'-'.$getArray['b_ev_group4'].'-'.$getArray['b_ev_group5'];
				}else{
					$buildingDetails->elevator = $getArray['elevator'];
				}
			}
			$buildingDetails->elevator_non_stop = $getArray['elevator_non_stop'];
			$buildingDetails->elevator_hall = $getArray['elevator_hall'];
			$buildingDetails->entrance_with_attention = $getArray['entrance_with_attention'];
			/********************** entrance open/close time ***********/
			
			
			$entVal = "";
			if(isset($getArray['ent_week_opt'])){
				if($getArray['ent_week_opt'] == 2){
					$entVal .= $getArray['ent_week_opt'].'-'.$getArray['ent_op_week_start'].'~'.$getArray['ent_op_week_finish'].",";
				}else{
					$entVal .= $getArray['ent_week_opt'].",";
				}
			}

			if(isset($getArray['ent_sat_opt'])){
				if($getArray['ent_sat_opt'] == 2){
					$entVal .= $getArray['ent_sat_opt'].'-'.$getArray['ent_op_sat_start'].'~'.$getArray['ent_op_sat_finish'].",";
				}else{
					$entVal .= $getArray['ent_sat_opt'].",";
				}
			}

			if(isset($getArray['ent_sun_opt'])){
				if($getArray['ent_sun_opt'] == 2){
					$entVal .= $getArray['ent_sun_opt'].'-'.$getArray['ent_op_sun_start'].'~'.$getArray['ent_op_sun_finish'].",";
				}else{
					$entVal .= $getArray['ent_sun_opt'];
				}
			}
			$buildingDetails->ent_op_cl_time = $entVal;

			/********************* end ******************/
			$buildingDetails->ent_auto_lock = $getArray['ent_auto_lock'];
			/******************* parking unit ***************/
			if($getArray['parking_unit_no'] == 1){
				$buildingDetails->parking_unit_no = $getArray['parking_unit_no'].'-'.$getArray['b_parking_num'];
			}else{
				$buildingDetails->parking_unit_no = $getArray['parking_unit_no'];
			}
			/******************* end *********************/
			/******************* limit time usage ************/
			$limitVal = "";
			if(isset($getArray['limit_time_week'])){
				if($getArray['limit_time_week'] == 2){
					$limitVal .= $getArray['limit_time_week'].'-'.$getArray['limit_time_week_start'].'~'.$getArray['limit_time_week_finish'].",";
				}else{
					$limitVal .= $getArray['limit_time_week'].",";
				}
			}

			if(isset($getArray['limit_time_sat'])){
				if($getArray['limit_time_sat'] == 2){
					$limitVal .= $getArray['limit_time_sat'].'-'.$getArray['limit_time_sat_start'].'~'.$getArray['limit_time_sat_finish'].",";
				}else{
					$limitVal .= $getArray['limit_time_sat'].",";
				}
			}

			if(isset($getArray['limit_time_sun'])){
				if($getArray['limit_time_sun'] == 2){
					$limitVal .= $getArray['limit_time_sun'].'-'.$getArray['limit_time_sun_start'].'~'.$getArray['limit_time_sun_finish'].",";
				}else{
					$limitVal .= $getArray['limit_time_sun'];
				}
			}
			$buildingDetails->limit_of_usage_time = $limitVal;
			/******************* end *************************/
			
			/******************* air conditioning time limit ************/
			$airVal = "";
			if(isset($getArray['air_condition_week'])){
				if($getArray['air_condition_week'] == 2){
					$airVal .= $getArray['air_condition_week'].'-'.$getArray['air_condition_week_start'].'~'.$getArray['air_condition_week_finish'].",";
				}else{
					$airVal .= $getArray['air_condition_week'].",";
				}
			}

			if(isset($getArray['air_condition_sat'])){
				if($getArray['air_condition_sat'] == 2){
					$airVal .= $getArray['air_condition_sat'].'-'.$getArray['air_condition_sat_start'].'~'.$getArray['air_condition_sat_finish'].",";
				}else{
					$airVal .= $getArray['air_condition_sat'].",";
				}
			}

			if(isset($getArray['air_condition_sun'])){
				if($getArray['air_condition_sun'] == 2){
					$airVal .= $getArray['air_condition_sun'].'-'.$getArray['air_condition_sun_start'].'~'.$getArray['air_condition_sun_finish'].",";
				}else{
					$airVal .= $getArray['air_condition_sun'];
				}
			}
			$buildingDetails->air_condition_time = $airVal;
			/******************* end *************************/
			/******************* parking use time limit ************/
			$parkingVal = "";
			if(isset($getArray['park_time_week'])){
				if($getArray['park_time_week'] == 2){
					$parkingVal .= $getArray['park_time_week'].'-'.$getArray['park_time_week_start'].'~'.$getArray['park_time_week_finish'].",";
				}else{
					$parkingVal .= $getArray['park_time_week'].",";
				}
			}

			if(isset($getArray['park_time_sat'])){
				if($getArray['park_time_sat'] == 2){
					$parkingVal .= $getArray['park_time_sat'].'-'.$getArray['park_time_sat_start'].'~'.$getArray['park_time_sat_finish'].",";
				}else{
					$parkingVal .= $getArray['park_time_sat'].",";
				}
			}

			if(isset($getArray['park_time_sun'])){
				if($getArray['park_time_sun'] == 2){
					$parkingVal .= $getArray['park_time_sun'].'-'.$getArray['park_time_sun_start'].'~'.$getArray['park_time_sun_finish'].",";
				}else{
					$parkingVal .= $getArray['park_time_sun'];
				}
			}
			$buildingDetails->parking_time = $parkingVal;
			/******************* end *************************/
			$buildingDetails->ceiling_height = $getArray['ceiling_height'];
			$buildingDetails->air_control_type = $getArray['air_control_type'];
			$buildingDetails->oa_floor = $getArray['oa_floor'];
			$buildingDetails->notes = $getArray['notes'];
			$buildingDetails->opticle_cable = $getArray['opticle_cable'];
			$buildingDetails->wholesale_lease = $getArray['wholesale_lease'];
			$buildingDetails->security_id = $getArray['security_id'];
			$buildingDetails->form_type_id = $_POST['form_type_id'];
			
			if($getArray['address'] != ''){
				$address = explode(',',$getArray['address']);
				$address = end($address);
				
				$aAddress = $this->getAddressByGoogleMap($address);
				
				$lat = $aAddress['lat'];
				$long = $aAddress['long'];
				$prefecture = $aAddress['prefecture'];
				$district = $aAddress['district'];
				$town = $aAddress['town'];
				$postalCode = $aAddress['postalCode'];
				$postalCodeOrder = $aAddress['postalCodeOrder'];
				
				$aAddress = $this->getAddressByGoogleMap($address, 'en');
				$prefecture_en = $aAddress['prefecture'];
				$district_en = $aAddress['district'];
				$town_en = $aAddress['town'];
				
				$buildingDetails->prefecture_en = $prefecture_en;
				$buildingDetails->district_en = $district_en;
				$buildingDetails->town_en = $town_en;

				
			}else{
				$lat = '';
				$long = '';
				$prefecture = '';
				$district = '';
				$postalCode = '';
				$postalCodeOrder = '';
				$town = '';
			}
			
// 			$buildingDetails->address_en = isset($aAddress) ? $aAddress['address_en'] : '';
			$buildingDetails->address_en = $getArray['address_en'];
			
			$buildingDetails->map_lat = $lat;
			$buildingDetails->map_long = $long;
			$buildingDetails->prefecture = $prefecture;
			$buildingDetails->district = $district;
			$buildingDetails->town = $town;
			$buildingDetails->postal_code = $postalCode;
			$buildingDetails->postal_code_order = $postalCodeOrder;
			
			if($buildingDetails->save(false)){
				Yii::app()->closetown->calculateMarketCloseTown($town);
				
				$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
				$logged_user_id = $user->user_id;
				
				$buildingRouteStationDetails = BuildingStation::model()->findAll('building_id = '.$getArray['id']);
				if(isset($buildingRouteStationDetails) && count($buildingRouteStationDetails) > 0){
					BuildingStation::model()->deleteAll('building_id = '.$getArray['id']);
				}
				$listOfStation = $this->actionGetNearestStation($long, $lat);
				foreach($listOfStation as $station){
					$stationModel = new BuildingStation;
					$stationModel->building_id = $getArray['id'];
					$stationModel->prefecture = $prefecture;
					$stationModel->corporate = $station['corporate'];
					$stationModel->name = $station['name'];
					$stationModel->name_en = $station['name_en'];
					$stationModel->line = $station['line'];
					$stationModel->distance = $station['distance'];
					$stationModel->time = ceil($station['distance']/80);
					$stationModel->save(false);
				}
				
				//echo $addrBuild;die;
				$changeLogModel = new BuildingUpdateLog;
				$changeLogModel->building_id = $getArray['id'];
				$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/searchBuildingResult',array('id'=>$getArray['id'])).'">'.Yii::app()->controller->__trans('Building basic info').' ('.$prefecture.')</a> '.Yii::app()->controller->__trans('has been updated');
				$changeLogModel->added_by = $logged_user_id;
				$changeLogModel->added_on = date('Y-m-d H:i:s');
				
				
				
				if($changeLogModel->save(false)){
					
					//check for office alert
					$cBuildingId = $getArray['id'];
					$currentBuilding = Building::model()->findByPk($cBuildingId);
					
					$buildingStationTime = BuildingStation::model()->findAll('building_id = '.$cBuildingId);
					$arrayTime = array();
					$arrayRoute = array();
					foreach($buildingStationTime as $nTime){
						$arrayTime[] = $nTime->time;
						$arrayRoute[] = $nTime->name;
					}
					
					$criteria=new CDbCriteria();
					$criteria->order='office_alert_id DESC';					
					$officeAlertList = OfficeAlert::model()->findAll($criteria);
					
					$i = 1;
					foreach($officeAlertList as $officeAlert){
						$getConditions = SearchSettings::model()->findByPk($officeAlert->cond_id);
						$cond = json_decode($getConditions->ss_json,true);
						$buildingId = explode(',',$officeAlert->building_id);
						
						$oAlert = OfficeAlert::model()->findByPk($officeAlert->office_alert_id);
						$pass = true;
						
						if(isset($cond['buildingAge']) && $cond['buildingAge'] != 0){
							$bAge = $currentBuilding->built_year;
							$bAge = explode('-',$bAge);
							$bAge = $bAge[0];
							if($cond['buildingAge'] != $bAge){
								$pass = false;
							}
						}
						
						if(isset($cond['deadlineCheck'])){
							if($cond['deadlineCheck'] != $currentBuilding->building_with_deadline){
								$pass = false;
							}
						}
						
						if(isset($cond['buildingSearchName'])){
							if($cond['buildingSearchName'] != $currentBuilding->name){
								$pass = false;
							}
						}
						
						if(isset($cond['buildingSearchAddress'])){
							$pos = strpos($cond['buildingSearchAddress'],  $currentBuilding->address);
							if($pos === false){
								$pass = false;
							}
						}
						
						if(isset($cond['pre-list']) && $cond['pre-list'] != ""){
							$prefecture = Prefecture::model()->find("prefecture_name LIKE '%".$currentBuilding->prefecture."%'");
							$prefectureId = $prefecture->code;
							if($prefectureId != $cond['pre-list']){
								$pass = false;
							}
						}
						
						/*if(isset($cond['prefectureDistrictlist']) && $cond['prefectureDistrictlist'] != ""){
							$district = District::model()->find('district_name LIKE "%'.$currentBuilding->district.'%"');
							$districtId = $district->code;
							if($districtId != $cond['prefectureDistrictlist']){
								$pass = false;
								echo "-------------------- condition 6--------<br/>";
								echo "R = ".$pass."<br/>";
							}
						}*/
						
						if(isset($cond['districtTownList']) && !empty($cond['districtTownList'])){
							$town = Town::model()->find('town_name LIKE "%'.$currentBuilding->town.'%"');
							$townId = $town->code;
							if(!in_array($townId,$cond['districtTownList'])){
								$pass = false;
							}
						}
						
						if(isset($cond['hdnRPrefId']) && $cond['hdnRPrefId'] != 0){
							$prefecture = Prefecture::model()->find("prefecture_name LIKE '%".$currentBuilding->prefecture."%'");
							$prefectureId = $prefecture->code;
							$prefecture = Prefecture::model()->find("code = '".$cond['hdnRPrefId']."'");
							if($prefectureId != $cond['hdnRPrefId']){
								$pass = false;
							}
						}
						
						if(isset($cond['hdnRailId']) && $cond['hdnRailId'] != 0){
							$rail = BuildingStation::model()->findAll("building_id = ".$cBuildingId);
							$corpArray = array();
							foreach($rail as $r){
								$corpArray[] = $r->corporate;
							}
							if(!in_array($cond['hdnRailId'],$corpArray)){
								$pass = false;
							}
						}
						
						if(isset($cond['hdnLineId']) && $cond['hdnLineId'] != 0){
							$line = BuildingStation::model()->findAll("building_id = ".$cBuildingId);
							$lineArray = array();
							foreach($line as $l){
								$lineArray[] = $l->line;
							}
							if(!in_array($cond['hdnLineId'],$lineArray)){
								$pass = false;
							}
						}
						
						if(isset($cond['hdnRRouteId']) && $cond['hdnRRouteId'] != ""){
							$route = explode(',',$cond['hdnRRouteId']);
							$routeDetail = BuildingStation::model()->findAll("building_id = ".$cBuildingId);
							$rArray = array();
							foreach($routeDetail as $rt){
								$rArray[] = $rt->line;
							}
							foreach($route as $rLoop){
								if(!in_array($rLoop,$rArray)){
									$pass = false;
								}
							}
						}
						
						if(isset($cond['floorSearchOwnerName']) && $cond['floorSearchOwnerName'] != ""){
							$oNew = preg_split('/\r\n|[\r\n]/', $cond['floorSearchOwnerName']);
							$buildingOwner = OwnershipManagement::model()->findAll('building_id = '.$cBuildingId);
							$bOwnerList = array();
							
							foreach($buildingOwner as $owner){
								$bOwnerList[] = $owner->owner_company_name;
							}
							
							foreach($oNew as $o){
								if(!in_array($o,$bOwnerList)){
									$pass = false;
								}
							}
						}
						
						if(isset($cond['hdnAddressBuildingId']) && $cond['hdnAddressBuildingId'] != 0){
							$sBuildingId = explode(',',$cond['hdnAddressBuildingId']);
							if(!in_array($cBuildingId,$sBuildingId)){
								$pass = false;
							}
						}
						
						if(in_array($cBuildingId,$buildingId)){
							$bIds = $buildingId;
							$bIds = array_diff($buildingId, array($cBuildingId));
						}
						
						if($pass == true){
							array_push($bIds,$cBuildingId);
							$bIds = implode(',',$bIds);
							$oAlert->building_id = $bIds;
							$oAlert->save(false);
						}
						
						$i++;
					}					
					
					// BEGIN - Create wordpress building reference
					$wordpress = new Wordpress();
					$wordpress->processIntergrateWordpress($buildingDetails->building_id, Wordpress::BUILDING_TYPE, 'update');
					$wordpress->reGenerateLocations();
					// End - processing with wordpress
					
					$url = Yii::app()->createUrl('building/afterChangeInfoBuilding');
					$resp = array('status'=>1,'msg'=>'Building Info Successfully Changed.','id'=>$getArray['id'],'url'=>$url);
				}
			}else{
				$resp = array('status'=>0,'msg'=>'Something went wrong.');
			}			

			echo json_encode($resp);
		}
	}	

	public function actionAfterChangeInfoBuilding(){
		$id = $_POST['id'];
		$buildingDetails = Building::model()->findByPk($id);
		$response = '<div class="col-3">
						<table class="bd_info">
							<tbody>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans("Address").'</th>
									<td><font><font>'.$buildingDetails["address"].'</font></font></td>
								</tr>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans("construction").'</th>
									<td>';
									$constructionTypeDetails = ConstructionType::model()->findByPk($buildingDetails['construction_type_id']);
									$constructionType = $constructionTypeDetails->construction_type_name;
									$response .= '<font><font>'.$constructionType != "" ? Yii::app()->controller->__trans($constructionType) : ''.'</font></font>
									</td>
								</tr>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans("scale").'</th>
									<td>';
									$extractFloorScale = explode('-',$buildingDetails['floor_scale']);
									$floorUp = $extractFloorScale[0];
									$floorDown = $extractFloorScale[1];
									$response .= '<font><font>Above ground '.$floorUp.' floor'.$floorUp > 1 ? 's' : ''.$floorDown.'underground level'.$floorDown > 1 ? 's' : ''.'</font></font>
									</td>
								</tr>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans("Year and month Built in").'</th>
									<td>';
									$extractBuiltYear = explode('-',$buildingDetails['built_year']);
									$year = $extractBuiltYear[0];
									$month = date("F", mktime(0, 0, 0, ($extractBuiltYear[1])));
									$response .= '<font><font>'.$year.' '.$month.'</font></font>
									</td>
								</tr>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans("emergency power generating").'</th>
									<td>';
									$emrPowerGen = $buildingDetails['emr_power_gen'];
									if($emrPowerGen == 0){
										$emrPowerGenOpt = Yii::app()->controller->__trans("Unknown");
									}else if($emrPowerGen == 2){
										$emrPowerGenOpt = Yii::app()->controller->__trans("Correspondence");
									}else if($emrPowerGen == 1){
										$emrPowerGenOpt = Yii::app()->controller->__trans("Incompatible");
									}else{
										$emrPowerGenOpt = '-';
									}
									$response .= '<font><font>'.Yii::app()->controller->__trans($emrPowerGenOpt).'</font></font>
									</td>
								</tr>
								<tr>
									<th scope="row"><font><font>'.Yii::app()->controller->__trans("elevator does not stop").' </th>
									<td>';
									$elevatorNonStop = $buildingDetails['elevator_non_stop'];
									if($elevatorNonStop == 0){
										$elevatorNonStopOpt = Yii::app()->controller->__trans("Unknown");
									}else if($elevatorNonStop == 1){
										$elevatorNonStopOpt = Yii::app()->controller->__trans("Noexist");
									}else if($elevatorNonStop == 2){
										$elevatorNonStopOpt = Yii::app()->controller->__trans("Exist");
									}else{
										$elevatorNonStopOpt = '-';
									}
									$response .= '<font><font>'.Yii::app()->controller->__trans($elevatorNonStopOpt).'</font></font>
									</td>
								</tr>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans("entrance open and close hours").'</th>
									<td>';
									$extractEntOpClTime = explode('-',$buildingDetails['ent_op_cl_time']);
									$weekDay = $extractEntOpClTime[0];
									$sat = $extractEntOpClTime[1];
									$sun = $extractEntOpClTime[2];
									$response .= '<p>'.Yii::app()->controller->__trans("weekday").'：'.($weekDay != "" ? $weekDay : 	'-').Yii::app()->controller->__trans("Sat").'：'.($sat != "" ? $sat : '-').Yii::app()->controller->__trans("Sun").'：'.($sun != "" ? $sun : '-').'</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>';
		$response .= '<div class="col-3">
						<table class="bd_info">
							<tbody>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans("total floor space").'</th>
									<td><font><font>'.($buildingDetails['total_floor_space'] != "" ? $buildingDetails['total_floor_space']." m<sup>2</sup>" : "-").'</font></font></td>
							  	</tr>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans("average floor area").'</th>
									<td><font><font>'.($buildingDetails['std_floor_space'] != "" ? $buildingDetails['std_floor_space'].Yii::app()->controller->__trans("tsubo")."" : "-").'</font></font></td>
								</tr>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans("parking").'</th>
									<td>';
										$extractParkingUnitNo = explode('-',$buildingDetails['parking_unit_no']);
										if($extractParkingUnitNo[0] == 1){
											$parkingUnit = $extractParkingUnitNo[1].Yii::app()->controller->__trans("台");
										}else if($extractParkingUnitNo[0] == 2){
											$parkingUnit = Yii::app()->controller->__trans("noexist");
										}else if($extractParkingUnitNo[0] == 3){
											$parkingUnit = Yii::app()->controller->__trans("exist but unknown unit number");
										}else{
											$parkingUnit = '-';
										}
									$response .= '<font><font>'.$parkingUnit.'</font></font>
									</td>
							  	</tr>
							  	<tr>
									<th scope="row">'.Yii::app()->controller->__trans("time limit").'</th>
									<td>';
										$extractLimitOfUsageTime = explode('-',$buildingDetails['limit_of_usage_time']);
										if($extractLimitOfUsageTime[0] == 1){
											$limitOfUsageTime = Yii::app()->controller->__trans('noexist');
										}else if($extractLimitOfUsageTime[0] == 2){
											$limitOfUsageTime = Yii::app()->controller->__trans($extractLimitOfUsageTime[1]);
										}else if($extractLimitOfUsageTime[0] == 0){
											$limitOfUsageTime = Yii::app()->controller->__trans('unknown before').':';
										}else{
											$limitOfUsageTime = '-';
										}
									$response .= '<font><font>'.$limitOfUsageTime.'</font></font>
									</td>
							  	</tr>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans('elevator').'</th>
									<td>';
										$extractElevator = explode('-',$buildingDetails['elevator']);
										if($extractElevator[0] == -2){
											$elevator = Yii::app()->controller->__trans('unknown');
										}else if($extractElevator[0] == 1){
											$elevator = $extractElevator[1].' '.Yii::app()->controller->__trans('base');
										}else if($extractElevator[0] == 2){
											$elevator = Yii::app()->controller->__trans('noexist');
										}else{
											$elevator = '-';
										}
									$response .= '<font><font>'.$elevator.'</font></font>
									</td>
								</tr>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans('caretaker in entrance').'</th>
									<td>';
										$entranceWithAttention = $buildingDetails['entrance_with_attention'];
										if($entranceWithAttention == 0){
											$attention = Yii::app()->controller->__trans('unknown');
										}else if($entranceWithAttention == 2){
											$attention = Yii::app()->controller->__trans('exist');
										}else if($entranceWithAttention == 1){
											$attention = Yii::app()->controller->__trans('noexist');
										}else{
											$attention = '-';
										}
									$response .= '<font><font>'.$attention.'</font></font>
									</td>
							  	</tr>
							</tbody>
						 </table>
					</div>';
		$response .= '<div class="col-3">
						<table class="bd_info">
							<tbody>
								<tr>
									<th scope="row">'.Yii::app()->controller->__trans('wholesale lease').'</th>
									<td>';
										$wholesaleLease = $buildingDetails['wholesale_lease'];
										if($wholesaleLease == 0){
											$lease = Yii::app()->controller->__trans('No');
										}else if($wholesaleLease == 2){
											$lease = Yii::app()->controller->__trans('Ask');
										}else if($wholesaleLease == 1){
											$lease = Yii::app()->controller->__trans('Yes');
										}else{
											$lease = '-';
										}
                        $response .= '<font><font>'.$lease.'</font></font>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">'.Yii::app()->controller->__trans('guard').'</th>
                    <td>';
							$securityDetails = Security::model()->findByPk($buildingDetails['security_id']);
							$security = $securityDetails['security_name'];
                        $response .= '<font><font>';($security != "" ? Yii::app()->controller->__trans($security) : '-').'</font></font>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">'.Yii::app()->controller->__trans('earthquake resistant').'</th>
                    <td>';
							$quakeResistanceStandardsDetails = QuakeResistanceStandards::model()->findByPk($buildingDetails['earth_quake_res_std']);
							$quakeResistance = $quakeResistanceStandardsDetails['quake_resistance_standard_name'];
                        $response .= '<font><font>'.($quakeResistance != "" ? Yii::app()->controller->__trans($quakeResistance): '-').'</font></font>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">'.Yii::app()->controller->__trans('renewal').'</th>
                    <td><font><font>'.($buildingDetails['renewal_data'] != "" ? $buildingDetails['renewal_data'] : '-').'</font></font>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">'.Yii::app()->controller->__trans("elevator hall").'</th>
                    <td>';
							$elevatorHall = $buildingDetails['elevator_hall'];
							if($elevatorHall == 0){
								$hall = Yii::app()->controller->__trans('Unknown');
							}else if($elevatorHall == 2){
								$hall = Yii::app()->controller->__trans('Exist');
							}else if($elevatorHall == 1){
								$hall = Yii::app()->controller->__trans('Noexist');
							}else{
								$hall = '-';
							}
                        $response .= '<font><font>'.$hall.'</font></font>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">'.Yii::app()->controller->__trans("entrance auto lock").'</th>
                    <td>';
							$entAutoLock = $buildingDetails['ent_auto_lock'];
							if($entAutoLock == 0){
								$autoLock = Yii::app()->controller->__trans('Unknown');
							}else if($entAutoLock == 2){
								$autoLock = Yii::app()->controller->__trans('Exist');
							}else if($entAutoLock == 1){
								$autoLock = Yii::app()->controller->__trans('Noexist');
							}else{
								$autoLock = '-';
							}
                        $response .= '<font><font>'.$autoLock.'</font></font>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="bt_bd_info"><div class="bt_update"><a href="'.Yii::app()->createUrl("building/changeBuildingInfo",array("id"=>$buildingDetails["building_id"])).'" class="btnUpdateBuildingInfo">edit・update</a></div></td>
                  </tr>
                </tbody>
              </table>
					</div>';			

		echo json_encode($response);
	}

	public function actionUploadBuildingPdf(){
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
     	$loguser_id = $users->user_id;

		$model = new BuildingPdfUpload;
		$model->building_id = $_POST['buildingId'];
		$model->title = $_POST['pdftitle'];
		$model->file_size = $_POST['pdfSize'];
		$model->note = $_POST['memo'];
		$model->added_by = $loguser_id;
		$model->added_on = date('Y-m-d H:i:s');		

		$uploadedFile=CUploadedFile::getInstance($model,'file_name');
		$model->file_name = uniqid('pdf_') . '_' . $_FILES['file']['name'];
		/*$model->file_name = CUploadedFile::getInstance($model,'pdf_file');*/

		if($model->save(false)){
			$images_path = realpath(Yii::app()->basePath . '/../buildingPdfUploads');
			if(move_uploaded_file($_FILES['file']['tmp_name'],$images_path . '/' . $model->file_name)){
				$changeLogModel = new BuildingUpdateLog;
				$changeLogModel->building_id = $_POST['buildingId'];
				$changeLogModel->change_content = $model->file_name.Yii::app()->controller->__trans('pdf has been uploaded');
				$changeLogModel->added_by = $logged_user_id;
				$changeLogModel->added_on = date('Y-m-d H:i:s');
				if($changeLogModel->save(false)){
					$url = Yii::app()->createUrl('building/getUploadedFileList');
					$resp = array('status'=>1,'msg'=>'File Successfully Uploaded.','url'=>$url,'id'=>$_POST['buildingId']);
				}
			}else{
				$resp = array('status'=>0,'msg'=>'Something went wrong. File not upload.');
			}
			echo json_encode($resp); die;
		}
	}	

	public function actionGetUploadedFileList(){
		$id = $_POST['formdata'];
		$uploadedFilList = BuildingPdfUpload::model()->findAll('building_id = '.$id);
		$result = '<table class="pdf_list">
					<tbody>
						<tr>
							<th scope="col" class="ttl_pdf"><font><font>'.Yii::app()->controller->__trans('Title').'</font></font></th>
							<th scope="col" class="date">'.Yii::app()->controller->__trans('Updated Date').'</th>
							<th scope="col" class="udn">'.Yii::app()->controller->__trans('Updated by').'</th>
							<th scope="col" class="fs">'.Yii::app()->controller->__trans('Size').'</th>
							<th scope="col" class="memo">'.Yii::app()->controller->__trans('Memo').'</th>
							<th scope="col" class="bt_d">&nbsp;</th>
						</tr>';
		foreach($uploadedFilList as $list){
			$uploadedUser = AdminDetails::model()->findByAttributes(array('user_id'=>$list['added_by']));
			$result .= '<tr id="pdf_28202587">
							<td class="ttl_pdf">
								<p><a href="'.Yii::app()->baseUrl.'/buildingPdfUploads/'.$list['file_name'].'" target="_blank"><font><font>'.Yii::app()->controller->__trans($list['title']).'</font></font></a></p>
							</td>
							<td class="date">'.date('Y-m-d',strtotime($list['added_on'])).'</td>
							<td class="udn">'.$uploadedUser->full_name.'</td>
							<td class="fs">'.$list['file_size'].' KB</td>
							<td class="memo">'.$list['note'].'</td>
							<td class="bt_d">
								<a href="'.Yii::app()->createUrl('building/deleteUploadedPdf',array('id'=>$list['upload_id'])).'"  class="deletePdf"><i class="fa fa-times"></i><font><font>you work</font></font></a>
							</td>
						</tr>';
		}
		$result .= '</tbody>
				</table>';
		echo json_encode($result);
		die;
	}	

	public function actionDeleteUploadedPdf(){
		$id = $_REQUEST['id'];
		$uploadedFileDetails = BuildingPdfUpload::model()->findByPk($id);
		BuildingPdfUpload::model()->deleteByPk(array('upload_id'=>$id));
		$images_path = realpath(Yii::app()->basePath . '/../buildingPdfUploads').'/'.$uploadedFileDetails['file_name'];
		if(file_exists($images_path)){
			unlink($images_path);
			$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
			$loguser_id = $users->user_id;	

			$changeLogModel = new BuildingUpdateLog;
			$changeLogModel->building_id = $uploadedFileDetails['building_id'];
			$changeLogModel->change_content = $uploadedFileDetails['file_name'].Yii::app()->controller->__trans("pdf has been deleted");
			$changeLogModel->added_by = $logged_user_id;
			$changeLogModel->added_on = date('Y-m-d H:i:s');
			if($changeLogModel->save(false)){
				$url = Yii::app()->createUrl('building/getUploadedFileList');
				$resp = array('status'=>1,'id'=>$id,'url'=>$url);
			}
		}else{
			$resp = array('status'=>0);
		}
		echo json_encode($resp);
		die;
	}	

	public function actionGetListOfTransmissionMatters(){
		$buildingId = $_REQUEST['buildingId'];
		$transmissionMattersDetails = TransmissionMatters::model()->findAll('building_id = '.$buildingId);
		if(isset($transmissionMattersDetails) && count($transmissionMattersDetails) > 0){
			$resp = '<table class="tblTransmission">
						<tbody>';
							foreach($transmissionMattersDetails as $transList){
								$userFullDetails = AdminDetails::model()->find('user_id = '.$transList['added_by']);
								if(isset($userFullDetails) && count($userFullDetails) > 0){
									$currentUser = $userFullDetails['full_name'];
								}
								$days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
								$day = array_search((date('D',strtotime($transList['added_on']))), $days);
						$resp .= '<tr>
									<td class="tdTrans"><input type="checkbox" name="transCheck" class="transCheck" id="transCheck" value="'.$transList['transmission_matters_id'].'"/></td>
									<td class="tdTrans">'.$transList['added_on'].'('.$day.')</td>
									<td class="tdTrans">'.$currentUser.'</td>
									<td class="tdTrans">'.$transList['note'].'</td>
								</tr>';
							}
						$resp .= '<tr>
									<td class="tdTrans">
										<input type="hidden" name="hdnBulkTrans" id="hdnBulkTrans" class="hdnBulkTrans" value=""/>
										<button type="button" name="btnDeleteTransmission" id="btnDeleteTransmission" class="btnDeleteTransmission">'.Yii::app()->controller->__trans("bulk your work").'</button>
									</td>
								</tr>';
				$resp .= '</tbody>
					</table>';
		}else{
			$resp = Yii::app()->controller->__trans("No Matters Available");
		}
		echo json_encode($resp);
	}	

	public function actionSaveTransmissionDetails(){
		$buildingId = $_REQUEST['buildingId'];
		$inputText = $_REQUEST['inputText'];		

		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
     	$loguser_id = $users->user_id;
		
		$transmissionMatters = new TransmissionMatters();
		$transmissionMatters->building_id = $buildingId;
		$transmissionMatters->note = $inputText;
		$transmissionMatters->added_on = date('Y-m-d');
		$transmissionMatters->added_by = $loguser_id;	

		if($transmissionMatters->save(false)){
			$transmissionMattersDetails = TransmissionMatters::model()->findAll(array("condition" => "building_id = '".$buildingId."'","order" => "transmission_matters_id DESC"));
			if(isset($transmissionMattersDetails) && count($transmissionMattersDetails) > 0){
			$html = '<table class="ah_msg">
						<tbody>';
							$i = 0;
							foreach($transmissionMattersDetails as $transList){
								if($i == 4){														
									break;
								}
								$days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
								$day = array_search((date('D',strtotime($transList['added_on']))), $days);
						$html .= '<tr>
									<th scope="row">'.date('Y.m.d',strtotime($transList['added_on'])).'('.$day.')</th>
									<td>'.(strlen($transList['note']) > 28 ? mb_substr($transList['note'], 0, 28,'UTF-8').' ...' : $transList['note']).'</td>
								</tr>';
								$i++;
							}
				$html .= '</tbody>
					</table>';
			}
			$transmissionMattersRows = TransmissionMatters::model()->findAll('building_id = '.$buildingId);
			$totalCount = count($transmissionMattersRows);
			$resp = array('status'=>1,'count'=>$totalCount,'divHtml'=>$html);
		}else{
			$resp = array('status'=>0);
		}
		echo json_encode($resp);
	}	
	
	public function actionRemoveFreeRent(){
		$frId = $_REQUEST['id'];
		$freeRentDetails = FreeRent::model()->deleteByPk($frId);
		echo json_encode(array('success'=>true));
		exit;
	}
	
	public function actionGetListOfFreeRents(){
		$buildingId = $_REQUEST['buildingId'];
		$freeRentDetails = FreeRent::model()->findAll('building_id = '.$buildingId);
		$getFoorList = Floor::model()->findAll('building_id = '.$buildingId);
		if(isset($getFoorList) && count($getFoorList) > 0){
			$floorRander = '';
			foreach($getFoorList as $floor){
				if($floor['floor_down'] == "" && $floor['area_m'] == ""){
				$floorRander .= '<input type="checkbox" name="rentFloorId[]" id="rentFloorId" class="rentFloorId" value="'.$floor['floor_id'].'"/> -';
				}else{
					if(strpos($floor['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
					}else{
						$floorDown = $floor['floor_down'];
					}
				$floorRander .= '<input type="checkbox" name="rentFloorId[]" id="rentFloorId" class="rentFloorId" value="'.$floor['floor_id'].'"/>'.$floorDown.(isset($floor['floor_up']) && $floor['floor_up'] != "" ? " ~ ".$floor['floor_up'] : "").(isset($floor['area_ping']) && $floor['area_ping'] != "" ? "/".$floor['area_ping']." ".Yii::app()->controller->__trans("tsubo") : "");
				}
			}
		}
		if(isset($freeRentDetails) && count($freeRentDetails) > 0){
			$resp = '<table class="tblFreeRent">
						<tbody>';
						//$days = array('month'=>'Mon','fire'=>'Tue','water'=>'Wed','wood'=>'Thu','gold'=>'Fri','soil'=>'Sat','day'=>'Sun');
						$days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
							foreach($freeRentDetails as $rentList){
								$allocateFloorDetails = Floor::model()->findAllByAttributes(array('floor_id'=>explode(',',$rentList['allocate_floor_id'])));
								if(isset($allocateFloorDetails) && count($allocateFloorDetails) > 0){
									$floorName = '';
									foreach($allocateFloorDetails as $floor){
										if(strpos($floor['floor_down'], '-') !== false){
											$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
										}else{
											$floorDown = $floor['floor_down'];
										}
										if($floor['floor_up'] != ""){
											$floorName .= $floorDown." ~ ".$floor['floor_up'].' '.Yii::app()->controller->__trans("階");
										}else{
											$floorName .= $floorDown.' '.Yii::app()->controller->__trans("階");
										}
										$floorName .= " / ".$floor['area_ping']." tsubo";
									}
								}else{
									$floorName = '';
								}
								$day = $rentList['expiration_date'] != '0000-00-00' ? array_search((date('D',strtotime($rentList['expiration_date']))), $days) : '';
								$expDate = $rentList['expiration_date'] != '0000-00-00' ? $rentList['expiration_date'] : '';
								$upday = array_search((date('D',strtotime($rentList['added_on']))), $days);
						$resp .= '<tr>
									<td>'.date('Y.m.d',strtotime($rentList['added_on'])).'('.$upday.')</td>
									<td>'.Yii::app()->controller->__trans("Free Rent ").' '.$rentList['free_rent_month'].' '.Yii::app()->controller->__trans("months").' <br/>※'.$floorName.'<br/>期限：'.$expDate.'('.$day.')</td>
									<td><button data-id="'.$rentList['free_rent_id'].'" class="btn-primary remove-free-rent">削除</button>
									</td>
								</tr>';
							}
				$resp .= '</tbody>
					</table>';
		}else{
			$resp =  Yii::app()->controller->__trans("履歴がまだありません");
		}
		$result = array('list'=>$resp,'floors'=>$floorRander);
		echo json_encode($result);
		die;
	}	

	public function actionSaveFreeRent(){
		$formData = $_REQUEST['formdata'];
		parse_str($formData, $getArray);		
		
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
     	$loguser_id = $users->user_id;		
		
		if(count($getArray['rentFloorId']) > 0){
			foreach($getArray['rentFloorId'] as $floor){
				$model = new FreeRent;
				$model->building_id = $getArray['rentBuildId'];
				$model->free_rent_month = $getArray['freeRentMonth'];
				$model->expiration_date = ($getArray['expirationDate'] != "" ? date('Y-m-d',strtotime($getArray['expirationDate'])) : '');
				$model->allocate_floor_id = $floor;
				$model->added_by = $loguser_id;
				$model->added_on = date('Y-m-d H:i:s');
				$model->save(false);
			}
			$resp = array('status'=>1,'msg'=>'賃料交渉履歴が追加されました。');
		}else{
			$resp = array('status'=>0,'msg'=>'何かが間違っていました。');
		}
		echo json_encode($resp);
		die;
	}
	
	/***** old *****/
	/*public function actionSaveFreeRent(){
		$formData = $_REQUEST['formdata'];
		parse_str($formData, $getArray);		
		
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
     	$loguser_id = $users->user_id;		

		$model = new FreeRent;
		$model->building_id = $getArray['rentBuildId'];
		$model->free_rent_month = $getArray['freeRentMonth'];
		$model->expiration_date = date('Y-m-d',strtotime($getArray['expirationDate']));
		$model->allocate_floor_id = implode(',',$getArray['rentFloorId']);
		$model->added_by = $loguser_id;
		$model->added_on = date('Y-m-d H:i:s');		

		if($model->save(false)){
			$resp = array('status'=>1,'msg'=>'Free rent Successfully added.');
		}else{
			$resp = array('status'=>0,'msg'=>'Something went wrong.');
		}
		echo json_encode($resp);
		die;
	}*/	
	public function cartedFloor(){
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $users->user_id;
		$floorIds = array();
		$cartDetails = Cart::model()->findAll(array('order'=>'`order`', 'condition'=>'user_id=:x', 'params'=>array(':x'=>$loguser_id)));
		if(isset($cartDetails) && count($cartDetails) > 0){
			$floorIds = $buildingIds = array();
			foreach($cartDetails as $cart){
				$floorIds[] = $cart['floor_id'];
			}
		}
		return $floorIds;
	}
	public function changeColor($fid){		
		if (in_array($fid, $this->cartedFloor())) {
			echo " cartColor ";
		}
		
		$floor = Floor::model()->findByPk($fid);
		if ($floor->show_frontend) {
			echo " show_frontend ";
		}
		
		echo '';									
	}
	public function actionGetListOfRentsNegotiation(){
		$buildingId = $_REQUEST['buildingId'];
		$rentNegotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildingId.' order by rent_negotiation_id desc');
		$getFoorList = Floor::model()->findAll('building_id = '.$buildingId);
		if(isset($getFoorList) && count($getFoorList) > 0){
			$floorRander = '';
			foreach($getFoorList as $floor){
				if($floor['floor_down'] == "" && $floor['area_m'] == ""){
				$floorRander .= '<input type="checkbox" name="negFloorId[]" id="negFloorId" class="negFloorId" value="'.$floor['floor_id'].'"/> -';
				}else{
					if(strpos($floor['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
					}else{
						$floorDown = $floor['floor_down'];
					}
				$floorRander .= '<input type="checkbox" name="negFloorId[]" id="negFloorId" class="negFloorId" value="'.$floor['floor_id'].'"/>'.$floorDown.(isset($floor['floor_up']) && $floor['floor_up'] != "" ? " ~ ".$floor['floor_up'] : "").(isset($floor['area_ping']) && $floor['area_ping'] != "" ? "/".$floor['area_ping']." ".Yii::app()->controller->__trans("tsubo") : "");
				}
			}
		}		

		if(isset($rentNegotiationDetails) && count($rentNegotiationDetails) > 0){
			$resp = '<table class="tblFreeRent">
						<tbody>';
						//$days = array('month'=>'Mon','fire'=>'Tue','water'=>'Wed','wood'=>'Thu','gold'=>'Fri','soil'=>'Sat','day'=>'Sun');
						$days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
							foreach($rentNegotiationDetails as $negotiationList){
								$allocateFloorDetails = Floor::model()->findAllByAttributes(array('floor_id'=>explode(',',$negotiationList['allocate_floor_id'])));
								if(isset($allocateFloorDetails) && count($allocateFloorDetails) > 0){
									$floorName = '';
									foreach($allocateFloorDetails as $floor){
										if(strpos($floor['floor_down'], '-') !== false){
											$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
										}else{
											$floorDown = $floor['floor_down'];
										}
										if($floor['floor_up'] != ""){
											$floorName .= $floorDown." ~ ".$floor['floor_up'];
										}else{
											$floorName .= $floorDown.' '.Yii::app()->controller->__trans("階");
										}
										$negUnitB = '';
										$negUnit = '';
										$negVal = '';
										if($negotiationList['negotiation_type'] == 1){
											$negUnit = '(共益費込み)';
											$negUnitB = '¥';
											$negVal = number_format($negotiationList['negotiation']);
										}elseif($negotiationList['negotiation_type'] == 5){
											$negUnit = '(共益費込み)';
											$negUnitB = '¥';
											$negVal = number_format($negotiationList['negotiation']);
										}elseif($negotiationList['negotiation_type'] == 2 || 
											$negotiationList['negotiation_type'] == 3){
											$negUnit = 'ヶ月';
											$negVal = $negotiationList['negotiation'];
										}else{
											$negVal = $negotiationList['negotiation'];
										}
																
										
										$floorName .= " / ".$floor['area_ping'].' '.Yii::app()->controller->__trans("tsubo").' | '.$negUnitB .' '. $negVal.' '.$negUnit.' '.$negotiationList['negotiation_note'];
									}
								}else{
									$floorName = '';
								}
								$day = array_search((date('D',strtotime($negotiationList['added_on']))), $days);
						$resp .= '<tr>
									<td class="tdRent_check_wraper"><input type="checkbox" name="tdRentCheck['. $negotiationList['rent_negotiation_id'] .']" class="tdRentCheck" value="'. $negotiationList['rent_negotiation_id'] .'"/></td>
									<td>'.date('Y.m.d',strtotime($negotiationList['added_on'])).'('.$day.')</td>';
								$personIncharge = AdminDetails::model()->find('user_id = '.$negotiationList['person_incharge']);
						$resp .= '<td>'.$personIncharge['full_name'].'</td>';
						$resp .= '<td>';
									/*if($negotiationList['negotiation_type'] == 1){
										$resp .= Yii::app()->controller->__trans('Tsubo unit price').' ( '.Yii::app()->controller->__trans('floor').' ) ';
									}elseif($negotiationList['negotiation_type'] == 2){
										$resp .= Yii::app()->controller->__trans("Deposit negotiation value");
									}elseif($negotiationList['negotiation_type'] == 3){
										$resp .= Yii::app()->controller->__trans("Key money negotiation value");
									}else if($negotiationList['negotiation_type'] == 5){
										$resp .= Yii::app()->controller->__trans('Tsubo').' ( '.Yii::app()->controller->__trans('reference value').' ) ';
									}else{
										$resp .= Yii::app()->controller->__trans("Other negotiations information");
									}*/
									if($negotiationList['negotiation_type'] == 1){
										$resp .= '底値： ';
									}elseif($negotiationList['negotiation_type'] == 2){
										$resp .= '敷金交渉値： ';
									}elseif($negotiationList['negotiation_type'] == 3){
										$resp .= Yii::app()->controller->__trans("Key money negotiation value");
									}else if($negotiationList['negotiation_type'] == 5){
										$resp .= '目安値： ';
									}else{
										$resp .= Yii::app()->controller->__trans("Other negotiations information");
									}
							$resp .= '<br/>'.$floorName.'</td>
								</tr>';
							}
				$resp .= '<tr>
							<td class="tdTrans">
								<button type="button" name="btnDeleteRentHistory" id="btnDeleteRentHistory" class="btnDeleteRentHistory">一括削除</button>
							</td>
						</tr></tbody>
					</table>';
		}else{
			$resp = Yii::app()->controller->__trans("No Rent Negotiation Available");
		}		

		$result = array('list'=>$resp,'floors'=>$floorRander);
		echo json_encode($result);
		die;
	}	

	public function actionSaveRentNegotiation(){
		$formData = $_REQUEST['formdata'];
		parse_str($formData, $getArray);		

		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
     	$loguser_id = $users->user_id;		
		try{
		foreach($getArray['negFloorId'] as $flr){
			$model = new RentNegotiation;
			$model->building_id = $getArray['negBuildId'];
			$model->negotiation_type = $getArray['negotiationType'];
			if((int)$getArray['negotiationType']==1 || (int)$getArray['negotiationType']==5)
				$model->negotiation_note = $getArray['negotiationNote'];
			else 
				$model->negotiation_note = "";
			$model->negotiation = $getArray['negotiationAmt'];
			$model->allocate_floor_id = $flr;
			/*
			comment added by krunal as change no #47 by client
			$model->allocate_floor_id = implode(',',$getArray['negFloorId']);*/
			$model->person_incharge = $getArray['personIncharge'];		
			$model->added_by = $loguser_id;
			$model->added_on = date('Y-m-d H:i:s');		
			$model->save(false);
		}
			$resp = array('status'=>1,'msg'=>'賃料交渉履歴が追加されました。');
		
		}catch(Exception $e){
			$resp = array('status'=>0,'msg'=>$e->getMessage());
		}		

		echo json_encode($resp);
		die;
	}	

	public function actionGetMapAccessDetails(){
		$building_id = $_REQUEST['buildingId'];
	}

	public function actionSeachOwnerDropdown(){
		if(isset($_REQUEST['name']) && $_REQUEST['name'] != ''){
			$ownerList = OwnershipManagement::model()->findAll(array('group' => 'owner_company_name', 'condition'=>'owner_company_name LIKE :match','params'=>array(':match'=> '%'.$_REQUEST['name'].'%')));
			if(count($ownerList)>0){
				$resp = '<select class="selectDrop" name="srchownerdrpdwn[]"  multiple="multiple" id="selectDrop">';
				foreach($ownerList as $ownList){
                	$resp .= '<option value="'.$ownList->owner_company_name.'">'.$ownList->owner_company_name.'</option>';
				}
           $resp .=  '</select>';
			}else{
				$resp = '<select class="selectDrop" name="srchownerdrpdwn">
				<option value="">'.Yii::app()->controller->__trans("No Owner Available").'</option></select>';
			}
			echo json_encode($resp);
			exit;
		}
	}

	public function actionCheckListForCart(){
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		$loguser_id = $users->user_id;
		$cartDetails = Cart::model()->findAll(array('order'=>'`order`', 'condition'=>'user_id=:x', 'params'=>array(':x'=>$loguser_id)));
		if(isset($cartDetails) && count($cartDetails) > 0){
			$url = Yii::app()->createUrl('building/listOfCartItem');
			$resp = array('status'=>1,'url'=>$url);
		}else{
			$url = Yii::app()->createUrl('building/searchBuilding');
			$resp = array('status'=>0,'url'=>$url);
		}
		echo json_encode($resp);
		die;
	}

	public function actionListOfCartItem(){ $searchCondition;
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $users->user_id;		

		$cartDetails = Cart::model()->findAll(array('order'=>'`order`', 'condition'=>'user_id=:x', 'params'=>array(':x'=>$loguser_id)));
		if(isset($cartDetails) && count($cartDetails) > 0){
			$floorIds = $buildingIds = array();
			foreach($cartDetails as $cart){
				$searchCondition = json_decode($cart['search_condition']);
				$resultData[] = Building::model()->findByPk($cart['building_id']);
				$floorIds[] = $cart['floor_id'];
				$buildingIds[] = $cart['building_id'];
			}
			$resultData = array_unique($resultData,SORT_REGULAR);
			$floorIds = array_values(array_unique($floorIds));
			$buildingIds = array_values(array_unique($buildingIds));
			if($resultData > 0){
				$this->render('searchedBuidingResult',array('resultData'=>$resultData,'isCartList'=>1,'floorIds'=>$floorIds,'buildingIds'=>$buildingIds,'customCondition'=>$searchCondition));
			}else{
				$resultData = array();
				$this->render('searchedBuidingResult',array('resultData'=>$resultData,'floorIds'=>$floorIds,'buildingIds'=>$buildingIds));
			}
		}
	}

	public function actionSaveMapAccessDetails(){
		$formData = $_REQUEST['formdata'];
		parse_str($formData,$getArray);
		$buildingDetails = Building::model()->findByPk($getArray['mapBuildId']);
		$buildingDetails->map_lat = $getArray['mapLat'];
		$buildingDetails->map_long = $getArray['mapLong'];
		if($buildingDetails->save(false)){
			$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
			$logged_user_id = $user->user_id;
			
			$buildingDetails = Building::model()->findByPk($getArray['mapBuildId']);
			$buildAddress = $buildingDetails['address'];
			$buildAddress = explode(',',$buildAddress);
			$addrBuild = $buildAddress[2];

			$changeLogModel = new BuildingUpdateLog;
			$changeLogModel->building_id = $getArray['mapBuildId'];
			$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/searchBuildingResult',array('id'=>$getArray['mapBuildId'])).'">'.Yii::app()->controller->__trans("Building basic info").'('.$addrBuild.')</a>'.Yii::app()->controller->__trans("has been updated");
			$changeLogModel->added_by = $logged_user_id;
			$changeLogModel->added_on = date('Y-m-d H:i:s');
			if($changeLogModel->save(false)){
				$resp = array('status'=>1);
			}else{
				$resp = array('status'=>0);
			}
		}
		echo json_encode($resp);
		die;
	}	

	public function actionSaveStaionReachTime(){
		$formData = $_REQUEST['formdata'];
		parse_str($formData,$getArray);	

		$buildingStationId = $getArray['hdnBuildingStationId'];
		$stationReachTime = $getArray['stationReachTime'];
		$stationNameEn = $getArray['stationNameEn'];
		
		$i = 0;
		foreach($buildingStationId as $ids){
			$buildingStationDetails = BuildingStation::model()->find('building_id = '.$getArray['mapBuildId'].' AND building_station_id = '.$ids);
			$buildingStationDetails->time = $stationReachTime[$i];
			$buildingStationDetails->name_en = $stationNameEn[$i];
			$buildingStationDetails->save(false);
			$i++;
		}
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;	
		
		$buildingDetails = Building::model()->findByPk($getArray['mapBuildId']);
		$buildAddress = $buildingDetails['address'];
		$buildAddress = explode(',',$buildAddress);
		$addrBuild = $buildAddress[2];

		$changeLogModel = new BuildingUpdateLog;
		$changeLogModel->building_id = $getArray['mapBuildId'];
		$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/searchBuildingResult',array('id'=>$getArray['mapBuildId'])).'">'.Yii::app()->controller->__trans("Building basic info").'('.$addrBuild.')</a>'.Yii::app()->controller->__trans("has been updated");
		$changeLogModel->added_by = $logged_user_id;
		$changeLogModel->added_on = date('Y-m-d H:i:s');
		if($changeLogModel->save(false)){
			$resp = array('status'=>1);
		}else{
			$resp = array('status'=>0);
		}
		
		// BEGIN - Create wordpress building reference
		$wordpress = new Wordpress();
		$wordpress->processIntergrateWordpress($getArray['mapBuildId'], Wordpress::BUILDING_TYPE, 'update');
		$wordpress->reGenerateLocations();
		// End - processing with wordpress
		
		echo json_encode($resp);
		die;
	}	

	public function actionPrintBuildingDetails(){
		$requestData = $_REQUEST;
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		$cartDetails = Cart::model()->findAllByAttributes(array('user_id'=>$logged_user_id),array('order'=>'`order`'));
		$buildCartDetails = array();
		foreach($cartDetails as $cart){
			$buildCartDetails[] = Building::model()->findByPk($cart['building_id']);
		}
		$buildCartDetails = array_unique($buildCartDetails,SORT_REGULAR);
		$this->renderPartial('printDetails',array('buildCartDetails'=>$buildCartDetails,'requestData'=> $requestData));
	}	

	public function actionRoute(){
		$this->render('route');
	}

	public function actionGetNearestStation($long, $lat){
		if (!$long || !$lat) return array();
		
		$json = file_get_contents('http://express.heartrails.com/api/json?method=getStations&x='.$long.'&y='.$lat);
		$aStations = json_decode($json,TRUE);		
		$aLines = Yii::app()->controller->getTokyoLinesCorporate();
		
		if (count($aStations['response']['station']))
		{
			$criteria=new CDbCriteria;
			$criteria->order='google_map_api_key_id DESC';
			$getGoogleMapKeyDetails = GoogleMapApiKey::model()->find($criteria);
			$gApiKey = '';
			if(count($getGoogleMapKeyDetails) > 0){
				$gApiKey = $getGoogleMapKeyDetails['api_key'];
			}
			
			// Get english station name
			$json_en = file_get_contents("https://maps.googleapis.com/maps/api/place/search/json?key=".$gApiKey."&location=$lat,$long&rankby=distance&sensor=false&language=en&types=train_station");
			$aStationsEn = json_decode($json_en,TRUE);
			$aStationEnName = array();
			
			foreach ($aStationsEn['results'] as $station)
			{
				$aStationEnName[] = $station['name'];
			}
			$stationTrans = array();
			foreach ($aStations['response']['station'] as $station_key => &$station)
			{
				if (!isset($stationTrans[$station['name']])){
					$stationTrans[$station['name']] = $aStationEnName[0];
					$station['name_en'] = $aStationEnName[0];
					
					// Unset and rebuilt station english
					unset($aStationEnName[0]);
					$aStationEnName = array_values($aStationEnName);
				}
				else {
					$station['name_en'] = $stationTrans[$station['name']];
				}
				$station['corporate'] = $aLines[$station['line']];
			}
		}
		
		return $aStations['response']['station'];
	}

	public function actionGetCorporationList($code = '', $prefecture = '',$act = ''){
		if($code == '')$code = trim($_REQUEST['code']);
		if($prefecture == '')$prefecture = trim($_REQUEST['name']);
		
		$aTmpStations = BuildingStation::model()->getStationCorporateByPrefecture($prefecture);
		$aStations = array();
		// redo sort order
		$aLines = Yii::app()->controller->getTokyoCorporateLines();
		foreach ($aTmpStations as $station)
		{
			$aStations[$station['corporate']] = $station;
		}
		$aCoprates = array_merge(array_flip(array_keys($aLines)), $aStations);
		
		if(isset($aCoprates) && count($aCoprates) > 0){
			$result = "<ul>";
			foreach($aCoprates as $company){
				if ($company['corporate'])
				{
					$result .= "<li class='corporates ".($company['corporate'] == $act ? 'activeCorporate' : '')."' data-prefec='".$prefecture."' data-value='".$company['corporate']."'>" . $company['corporate']."</li>";
				}
			}
			$result .= "</ul>";
			if(!isset($_REQUEST['code'])) return $result;
			echo json_encode($result);
		}
		die;
	}	

	public function actionGetLineList($corporate = '',$prefecCode = '',$prefecName = '',$act = ''){
		if($corporate == '') $corporate = trim($_REQUEST['corporate']);
		if($prefecName == '') $prefecName = trim($_REQUEST['prefecName']);
		
		$aLines = BuildingStation::model()->getStationLinesByCoprateAndPrefecture($corporate, $prefecName);
		$result = "<ul>";
		$actLname = '';
		if(!empty($aLines)){
			foreach($aLines as $line){
				if($line['line'] == $act)$actLname = $line['line'];
				$result .= "<li class='lines ".($line['line'] == $act ? 'activeLine' : '' )."' data-value='".$line['line']."'>".($line['line'] == $act ? '<i class="fa fa-check-square item-check" aria-hidden="true"></i> ' : '' ) .$line['line']."</li>";
			}
		}
		$result .= "</ul>";
		if(!isset($_REQUEST['corporate'])) return array('html'=>$result,'actLname'=>$actLname);
		echo json_encode($result);
		die;
	}	

	public function actionGetStationList($code = '',$lineName = '',$prefecName = '',$act = array()){
		if($code == '') $code = trim($_REQUEST['code']);
		if($lineName == '') $lineName = trim($_REQUEST['name']);
		if($prefecName == '') $prefecName = trim($_REQUEST['prefecName']);
		
		if(isset($_REQUEST['actStat'])){
			$act = explode(',',$_REQUEST['actStat']);
		}
		
		//if(is_string($lineName)) $lineName = array($lineName);
		$aStation = BuildingStation::model()->getStationByLinesAndPrefecture(array($lineName), $prefecName);
		if(isset($aStation) && count($aStation) > 0){
			$result = "<ul>";
			foreach($aStation as $station){
					$result .= "<li class='stations ".(in_array($station['name'],$act) ? 'activeStation' : '' )."' data-value='".$station['name']."'>".(in_array($station['name'],$act) ? '<i class="fa fa-check-square item-check" aria-hidden="true"></i> ' : '' ).$station['name']."</li>";
			}
			$result .= "</ul>";
			if(!isset($_REQUEST['code'])) return $result;
		}
		echo json_encode($result);
		die;
	}	

	public function actionGetBuildingList(){
		$formdata = $_REQUEST['conditionFormData'];
		foreach($formdata as $key=>$fdata){
			if(strpos($fdata['name'],'[]') !== false){
				if(!isset($_REQUEST[$fdata['name']])) $_REQUEST[$fdata['name']] = array();
				if(!isset($_POST[$fdata['name']])) $_POST[$fdata['name']] = array();
				$name = str_replace('[]','',$fdata['name']);;
				$_REQUEST[$name][] = $fdata['value'];
				$_POST[$name][] = $fdata['value'];
			}else{
				$_REQUEST[$fdata['name']] = $fdata['value'];
				$_POST[$fdata['name']] = $fdata['value'];
			}
		}

		$bIds = $fIds = '';
		$res = $this->actionSearchBuildingResult(true);
		
		if($res != false && isset($res[0])) $bIds = implode(',',$res[0]);
		if($res != false && isset($res[1]) && $res[1] != false){ 
			$fIds = "floor_id in (".implode(',',$res[1]).') AND ';
		}
		
		
		$aTmpStationName = explode(',',$_REQUEST['stationName']);
		$aStationName = array();
		$stationName = '';
		if (!empty($aTmpStationName))
		{
			foreach ($aTmpStationName as $szStationName)
			{
				$aStationName[] = ' name LIKE "%'. trim($szStationName) .'%"';
			}
			$stationName = ' AND (' . implode(' OR ', $aStationName) . ')';
		}
		
		if($res != false && count($res[0]) == 0){
			$searchResult = array();
		}else{
			$searchResult = Yii::app()->db->createCommand('SELECT * FROM building_station as bs where  EXISTS (
   SELECT * FROM building as b
   WHERE b.building_id = bs.building_id ) '. $stationName . ($res != false && $bIds != '' ? 'AND building_id IN ('.$bIds.')' : ''))->queryAll();
		}
		
		$arrayBuildings = array();
		foreach((array)$searchResult as $buildingId){
			$arrayBuildings[] = $buildingId['building_id'];
		}
		
		
		$arrayBuildingsUnique = array_unique($arrayBuildings);
		$arrayBuildings = array_values($arrayBuildingsUnique);
		
		$floorIds = array();
		
		/*$statusReq = isset($_REQUEST['statusRequirement']) && !empty($_REQUEST['statusRequirement']) != "" ? $_REQUEST['statusRequirement'] : array(1);*/
		$vacType = $this->getStatusType($_REQUEST['statusRequirement']);
			
		$tmpBuildingArray = $arrayBuildings;
		foreach($tmpBuildingArray as $buildingIndex => $building){
			$floorList = Floor::model()->findAll($fIds.'building_id = '.$building.($vacType[1] != '' ? ' AND '.$vacType[1] : ''));
			if (!empty($floorList))
			{
				foreach($floorList as $floor){
					$floorIds[] = $floor['floor_id'];
				}
			}
			else {
				unset($arrayBuildings[$buildingIndex]);
			}
		}
		
		
		$totalBuildings = count($arrayBuildings) > 1 ? count($arrayBuildings) : count($arrayBuildings);
		$totalFloors = count($floorIds) > 1 ? count($floorIds) : count($floorIds);
		
		// Fix floor building relation
		if (!$totalBuildings || !$totalFloors)
		{
			$totalBuildings = $totalFloors = 0;
			$arrayBuildings = $floorIds = array();
		}
		
		$resp = array('totalBuilding'=>$totalBuildings,'totalFloor'=>$totalFloors,'buildingIds'=>array_values($arrayBuildings),'floorIds'=>$floorIds,'form_json'=>$_REQUEST);
		echo json_encode($resp);
		die;
	}	

		public function actionGetDisctrictListTest(){
			$code = $_REQUEST['code'];
		if(strlen($code) == 1){
			$code = '0'.$code;
		}		

		$getPrefectureDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=2e&ar=eq&ac='.$code.'&output=json&results=100');
		$prefecture = Prefecture::model()->find('code = '.$code);
		echo $prefecture->prefecture_name;
		$districtArray = json_decode($getPrefectureDistrict,true);
			echo "<pre>";
			print_r( $districtArray);
		}
/*	
	public function actionGetDisctrictList(){
		$code = $_REQUEST['code'];
		$getPrefectureDistrict = file_get_contents('http://geoapi.heartrails.com/api/json?method=getCities&prefecture='.$code);
		$districtArray = json_decode($getPrefectureDistrict,true);
		$finalArray = array();
		$resp ='<select class="prefectureDistrictlist" id="prefectureDistrictlist" name="prefectureDistrictlist">
					<option value="">-</option>';
					foreach($districtArray['response']['location'] as $dist){
			$resp .= '<option value="'.$dist['city'].'">'.$dist['city'].'</option>'; 	
					}
		$resp .= '</select>';
		echo json_encode($resp);
		die;
	}	
	*/
	 public static function actionGetDisctrictList($code = '', $return = false){
		//$code = $_REQUEST['code'];
		if($code == '') $code = $_REQUEST['code'];
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
		
		/*if(strlen($code) == 1){
			$code = '0'.$code;
		}		
		$prefecture = Prefecture::model()->find('code = '.$code);
		$prefecture_name= $prefecture->prefecture_name;
		
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
						//$finalArray[] = array('id'=>$district['Id'],'name'=>$district['Name']);
						$finalArray[] = array('id'=>$district['Id'],'name'=>str_replace($prefecture_name,"",$district['Name']));
						
					}
				}else{
					continue;
				}
			}
		}else{
			foreach($districtArray['Feature'] as $district){
				$finalArray[] = array('id'=>$district['Id'],'name'=>$district['Name']);
			}
		}*/
		
		$code = isset($_REQUEST['code'])?$_REQUEST['code']:0;
		$post=Prefecture::model()->find(array(
				'select'=>'prefecture_name',
				'condition'=>'code=:code',
				'params'=>array(':code'=>$code),
		));
		
		if(!isset($_REQUEST['code']) || $return){
			return $districtList;
		}
		$resp = '<select class="prefectureDistrictlist" id="prefectureDistrictlist" name="prefectureDistrictlist">
					<option value="">-</option>';
					foreach($districtList as $dist){
						$distname = str_replace($post['prefecture_name'], "", $dist['name']);
						$resp .= '<option value="'.$dist['id'].'">'.$distname.'</option>'; 	
					}
		$resp .= '</select>';
		
		$resp1 = '';
		foreach($districtList as $dist){
			$isAct = false;
			if(isset($_REQUEST['district']) && in_array($dist['id'],$_REQUEST['district'])){
				$isAct = true;
			}
			
			$distname = str_replace($post['prefecture_name'], "", $dist['name']);
			$resp1 .= '<div class="listli_new '.($isAct ? 'activelistli' : '').'" data-value="'.$dist['id'].'">';
			$resp1 .= '<i class="fa '.($isAct?'fa-check-square':'fa-square').'" aria-hidden="true"></i>';
			$resp1 .= '<input name="mydistrictList[]" type="checkbox"'. ($isAct ? 'checked' : '').' value="'.$dist['id'].'" data-name="'.$distname.'"><span data-name="'.$dist['id'].'">'.$distname.'</span>';
			$resp1 .= '</div>';
		}
		
		echo json_encode($resp1);
		die;
	}	

	public function actionGetTownList($code = '', $return = false){
		if($code == '') $code = $_REQUEST['code'];
		if(strlen($code) == 1){
			$code = '0'.$code;
		}
		
		$checkTownAvailble = Town::model()->findAll('district_id = '.$code);
		if(isset($checkTownAvailble) && count($checkTownAvailble) > 0 && !empty($checkTownAvailble)){
			foreach($checkTownAvailble as $town){
				$finalArray[] = array('id'=>$town['code'],'name'=>$town['town_name']);
			}
		}else{
			$getDistrictTown = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=3e&ar=eq&ac='.$code.'&output=json&results=100');
			$townArray = json_decode($getDistrictTown,true);
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
					$getDistrictTown = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=3e&ar=eq&ac='.$code.'&output=json&results=100&start='.$start);
					$twnArray = json_decode($getDistrictTown,true);
					
					if(is_array($twnArray) && isset($twnArray['Feature'])){
						$resultCount = count($twnArray['Feature']);
						$start = ($resultCount*$i)+1;
						foreach($twnArray['Feature'] as $twn){
							$finalArray[] = array('id'=>$twn['Id'],'name'=>$twn['Name']);
							$modelTown = new Town;
							$modelTown->district_id = $code;
							$modelTown->town_name = $twn['Name'];
							$modelTown->code = $twn['Id'];
							$modelTown->save(false);
						}
					}else{
						continue;
					}
				}
			}else{
				foreach($townArray['Feature'] as $twn){
					$finalArray[] = array('id'=>$twn['Id'],'name'=>$twn['Name']);
					$modelTown = new Town;
					$modelTown->district_id = $code;
					$modelTown->town_name = $twn['Name'];
					$modelTown->code = $twn['Id'];
					$modelTown->save(false);
				}
			}
		}
		
		$buildingDetails = Building::model()->findAll();
		$addressArray = array();
		foreach($buildingDetails as $building){
			$addressArray[] = $building['address'];
		}
		
		$finalTownArray = array();
		$finalTownIdArray = array();
		foreach($finalArray as $final){
			foreach($addressArray as $addr){
				if(strpos($addr,$final['name']) !== false){
					$finalTownArray[] = $final['name'];
					$finalTownIdArray[] = $final['id'];
				}
			}
		}
		
		$finalTown = array_unique($finalTownArray);
		$finalTown = array_values($finalTown);
		
		$finalTownId = array_unique($finalTownIdArray);
		$finalTownId = array_values($finalTownId);
		
		$townList = array();
		$i = 0;
		foreach($finalTown as $tw){
			$townList[] = array('id'=>$finalTownId[$i],'name'=>$tw);
			$i++;
		}
		
		
		/*$getDistrictTown = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=3e&ar=eq&ac='.$code.'&output=json&results=100');
		$townArray = json_decode($getDistrictTown,true);
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
				$getPrefectureDistrict = file_get_contents('http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-&al=2&ar=eq&ac='.$code.'&output=json&results=100&start='.$start);
				$districtArray = json_decode($getPrefectureDistrict,true);				

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
		}*/
		
		$code = isset($_REQUEST['code'])?$_REQUEST['code']:0;
		$post=District::model()->find(array(
				'select'=>'district_name',
				'condition'=>'code=:code',
				'params'=>array(':code'=>$code),
		));
		
		$resp1 = Array();
		if(!isset($_REQUEST['code']) || $return) return $townList; 
			foreach($townList as $town){
				$isAct = false;
				if(isset($_REQUEST['added']) && in_array($town['name'],$_REQUEST['added'])){
					$isAct = true;
				}
				$townname = str_replace($post['district_name'], "", $town['name']);
				$resp .= '<div class="listli '.($isAct ? 'activelistli' : '').'">'.($isAct ? '<i class="fa fa-check-square item-check" aria-hidden="true"></i> ' : '').'<input '.($isAct ? 'checked' : '').' type="checkbox" value="'.$town['id'].'" data-name="'.$town['name'].'">'.$townname.'</div>';
				$resp1[] = Array($town['id'], $town['name']);				
			}

		echo json_encode(array('html'=>$resp, 'data'=>$resp1));
		die;
	}	

	function actionBuildingFilterByAddress(){
		$formdata = $_REQUEST['conditionFormData'];
		
		
		foreach($formdata as $key=>$fdata){
			if(strpos($fdata['name'],'[]') !== false){
				if(!isset($_REQUEST[$fdata['name']])) $_REQUEST[$fdata['name']] = array();
				if(!isset($_POST[$fdata['name']])) $_POST[$fdata['name']] = array();
				$name = str_replace('[]','',$fdata['name']);;
				$_REQUEST[$name][] = $fdata['value'];
				$_POST[$name][] = $fdata['value'];
			}else{
				$_REQUEST[$fdata['name']] = $fdata['value'];
				$_POST[$fdata['name']] = $fdata['value'];
			}
		}
		
		$bIds = $fIds = '';
		$res = $this->actionSearchBuildingResult(true);
		
		if($res != false && isset($res[0])) $bIds = implode(',',$res[0]);
		if($res != false && isset($res[1]) && $res[1] != false){ 
			$fIds = "floor_id in (".implode(',',$res[1]).') AND ';
		}
		
		if ($_REQUEST['districtTownList'] && !empty($_REQUEST['districtTownList']))
		{
			$_REQUEST['name'] = array();
			$aTown = Town::model()->findAllByAttributes(array('code'=>$_REQUEST['districtTownList']), array('group'=>'town_name'));
			if (!empty($aTown))
			{
				foreach ($aTown as $town)
				{
					$_REQUEST['name'][$town['town_name']] = $town['town_name'];
				}
			}
		}
		
		$address = array();
		if(isset($_REQUEST['name'])){
			$address = $_REQUEST['name'];
		}
		$multiadr = '';
		foreach($address as $ads){
			$multiadr .=  ($multiadr == '' ? '' : ' or ').' address LIKE "%'.$ads.'%" ';
		}
		
		$buildingArray = array();
		if($res != false && count($res[0]) == 0){
			$buildingArray = array();
		}else{
			$searchResult = Yii::app()->db->createCommand('SELECT * FROM building where '.'('.$multiadr.')'.($multiadr != '' && $bIds != '' ? ' AND ' : '').($res != false && $bIds != '' ? 'building_id IN ('.$bIds.')' : ''))->queryAll();
			foreach($searchResult as $result){
				$buildingArray[] = $result['building_id'];
			}
		}

		$vacType = $this->getStatusType($_REQUEST['statusRequirement']);		
		
		$floorIds = array();
		$tmpBuildingArray = $buildingArray;
		foreach($tmpBuildingArray as $buildingIndex => $building){
			$floorList = Floor::model()->findAll($fIds.' building_id = '.$building.($vacType[1] != '' ? ' AND '.$vacType[1] : ''));
			if (!empty($floorList))
			{
				foreach($floorList as $floor){
					$floorIds[] = $floor['floor_id'];
				}
			}
			else {
				unset($buildingArray[$buildingIndex]);
			}
		}
		$totalBuildings = count($buildingArray) > 1 ? count($buildingArray) : count($buildingArray);
		$totalFloors = count($floorIds) > 1 ? count($floorIds) : count($floorIds);
		
		// Fix floor building relation
		if (!$totalBuildings || !$totalFloors)
		{
			$totalBuildings = $totalFloors = 0;
			$buildingArray = $floorIds = array();
		}
		//echo "<pre>";
		//print_r($buildingArray);
		$buildingArray = array_values($buildingArray);
		
		$resp = array('totalBuilding'=>$totalBuildings,'totalFloor'=>$totalFloors,'buildingIds'=>$buildingArray,'floorIds'=>$floorIds,'form_json'=>json_encode($_REQUEST));
		echo json_encode($resp);
		die;
	}

	public function actionGetCustomerDrop(){
		//$customerName = $_POST['customerName'];
		$customerDetails = Customer::model()->findAll(array('condition'=>'company_name LIKE :match','params'=>array(':match'=> '%'.$_REQUEST['customerName'].'%')));
		$customerNameArray = array();
		foreach($customerDetails as $cname){
			$customerNameArray[] = $cname['company_name'];
		}
		//print_r($customerNameArray);die;
		$resp = '<select class="customerName" id="customerName" name="customerName" multiple>
					<option value="">-</option>';
					if(isset($customerNameArray) && count($customerNameArray) > 0){
						foreach($customerNameArray as $name){
							$resp .= '<option value="'.$name.'">'.$name.'</option>';
						}
					}else{
						$resp .= '<option>No Customer Found</option>';
					}
		$resp .= '</select>';
		echo json_encode($resp);
		die;
	}
	
	public function actionSort(){
		if(isset($_POST['data']) && is_array($_POST['data'])){
			$sortIDs = array();
			foreach($_POST['data'] as $item){
				$itemid = str_replace('item','',$item);
				$sortIDs[] = $itemid;
			}
			$i = 0;
			sort($sortIDs);
			foreach($_POST['data'] as $item){
				$itemid = str_replace('item','',$item);
				$building = Building::model()->findByPk($itemid);
				$temp = $building->attributes;
		
				$building->sortOrder = (int)$sortIDs[$i];
				if($building->save(false)){
				}
				$i++;
			}
		}
	}
	
	public function actionDeleteBulkTrans(){
		$transIds = $_REQUEST['transIds'];
		
		if(isset($transIds) && $transIds != ""){
			$criteria = new CDbCriteria;
			$criteria->condition = 'transmission_matters_id IN ('.$transIds.')';
			
			TransmissionMatters::model()->deleteAll($criteria);
			$transDetails = TransmissionMatters::model()->findAllByAttributes(array('transmission_matters_id'=>$transIds));
			if(count($transDetails)<= 0 && empty($transDetails)){
				$resp = array('status'=>1,'msg'=>Yii::app()->controller->__trans('Successfully deleted'));
			}else{
				$resp = array('status'=>0,'msg'=>Yii::app()->controller->__trans('Something went wrong'));
			}
		}else{
			$resp = array('status'=>0,'msg'=>Yii::app()->controller->__trans('Something went wrong'));
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionDeleteBulkNego(){
		$removeIds = $_REQUEST['removeIds'];
	
		if(isset($removeIds) && $removeIds != ""){
			$criteria = new CDbCriteria;
			$criteria->condition = 'rent_negotiation_id IN ('.$removeIds.')';
				
			RentNegotiation::model()->deleteAll($criteria);
			$transDetails = RentNegotiation::model()->findAllByAttributes(array('rent_negotiation_id'=>$removeIds));
			if(count($transDetails)<= 0 && empty($transDetails)){
				$resp = array('status'=>1,'msg'=>Yii::app()->controller->__trans('Successfully deleted'));
			}else{
				$resp = array('status'=>0,'msg'=>Yii::app()->controller->__trans('Something went wrong'));
			}
		}else{
			$resp = array('status'=>0,'msg'=>Yii::app()->controller->__trans('Something went wrong'));
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionDeleteOfficeAlert(){
		$officeAlertId = $_POST['officeAlertId'];
		OfficeAlert::model()->deleteAll('office_alert_id = '.$officeAlertId);
		$officeAlertList = OfficeAlert::model()->findByPk($officeAlertId);
		if(isset($officeAlertList) && count($officeAlertList) > 0){
			$resp = array('status'=>0);
		}else{
			$resp = array('status'=>1);
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionCloneOfficeAlert(){
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata,$getArray);
		$officeAlertDetails = OfficeAlert::model()->findByPk($getArray['hdnOffAlertId']);
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		$loguser_id = $users->user_id;
		
		$model = new OfficeAlert;
		$model->proposed_article_name = $getArray['proposedArticleName'];
		$model->building_id = $officeAlertDetails['building_id'];
		$model->floor_id = $officeAlertDetails['floor_id'];
		$model->user_id = $loguser_id;
		$model->customer_id = $getArray['proposedCustomerName'];
		$model->office_alert_rand_id = mt_rand(100000,9999999);
		$model->added_by = $loguser_id;
		$model->added_on = date('Y-m-d H:i:s');
		
		if($model->save(false)){
			if(isset($getArray['fromCustomer']) && $getArray['fromCustomer'] == 1){
				$url = Yii::app()->createUrl('customer/fullDetail',array('show'=>3,'id'=>$getArray['proposedCustomerName']));
			}else{
				$url = Yii::app()->createUrl('proposedArticle/myProposedArticleList');
			}
			$resp = array('status'=>1,'url'=>$url);
		}else{
			$resp = array('status'=>0);
		}
		echo json_encode($resp);
		die;
	}
	
	
	public function custom_intersect($arrays) {
		$comp = array_shift($arrays);
		$values = array();
	
		// The other arrays are compared to the first array:
		// Get all the values from the first array for comparison
		foreach($comp as $k => $v) {
			$values[$v] = 1;
		}
	
		// Loop through the other arrays
		foreach($arrays as $array) {
			// Loop through every value in array
			foreach($array as $k => $v) {
				// If the current ID exists in the compare array
				if(isset($values[$v])) {
					// Increase the amount of matches
					$values[$v]++;
				}
			}
		}
	
		$result = array();
	
		// The amount of matches for certain value must be
		// equal to the number of arrays passed, that's how
		// we know the value is present in all arrays.
		$n = count($arrays) + 1;
		foreach($values as $k => $v) {
			if($v == $n) {
				// The value was found in all arrays,
				// thus it's in the intersection
				$result[] = $k;
			}
		}
		return $result;
	}
	
	public function getStatusType($statusRequirement){
		$vacantType = 0; $vacantQr = '';
		if(isset($statusRequirement) && !empty($statusRequirement)){	
			if(in_array("1", $statusRequirement) && in_array("3", $statusRequirement)){
				$vacantType = 0;
			 }else if (in_array("1", $statusRequirement)){
				 $vacantType = 1;
				 $vacantQr = 'vacancy_info = 1';
			 }else if (in_array("3", $statusRequirement)){
				 $vacantType = 3; 
				 $vacantQr = 'vacancy_info = 0';
			 }
		 }
		 return array($vacantType,$vacantQr);
	}
	
	public function insertBuilding($building) {
		$bid = 0;
		$facedStreetList = FacedStreet::model()->findAll('is_active = 1');
		$constructionTypeList = ConstructionType::model()->findAll('is_active = 1');
		$quakeResistanceList = QuakeResistanceStandards::model()->findAll('is_active = 1');
		$securityList = Security::model()->findAll('is_active = 1');
		$formTypeList = FormType::model()->findAll('is_active = 1');
		$model=new Building;
		
		if(isset($building)){
// 			$model->attributes=$building;
			$model->name = $building[0];//$building['name'];
			if(isset($building[1])){ //'build_check'
				$model->bill_check = $building[1];
			}
			$model->old_name = $building[2];//'old_name'
			$model->name_kana = $building[3];//'name_kana'
			$model->address = $building[4]; //'address'
			$model->faced_street_id = $building[5]; //'faced_street_id'
			$model->construction_type_id = $building[6]; //'construction_type_id'
			$model->construction_type_name = $building[7]; //'construction_type_name'
			/************** floor scale *******************/
		
			if($building[9] != ""){ //'floor_scale_down'
				$model->floor_scale = $building[8].'-'.$building[9]; //''floor_scale_up'
			}else{
				$model->floor_scale = $building[8];
			}
			/******************* end ***********************/
		
			$model->exp_rent = $building[10].($building[11] != "" ? '~'.$building[11] : "").'-'.$building[12];
				
			if(isset($building[13])){
				$model->exp_rent_disabled = $building[13];
			}
				
			$model->earth_quake_res_std = $building[14];
			$model->earth_quake_res_std_note = $building[15];
			$model->emr_power_gen = $building[16];
			$model->built_year = $building[17].'-'.$building[18];
			$model->renewal_data = $building[19];
			$model->std_floor_space = $building[20];
			$model->total_floor_space = $building[21];
			$model->total_rent_space_unit = $building[22];
			$model->shared_rate = $building[23];
			
			if(isset($building[24])){
				$model->building_with_deadline = $building[24].'-'.$building[25];
			}
			/****************** elevator ******************/
		
			if(isset($building[26])){
				if( $building[26] == 1){
					$model->elevator = $building[26].'-'.$building[27].'-'.$building[28].'-'.$building[29].'-'.$building[30].'-'.$building[31];
				}else{
					$model->elevator = $building[26];
				}
			}
			/******************** end ************************/
		
			$model->elevator_non_stop = $building[32];
			$model->elevator_hall = $building[33];
			$model->entrance_with_attention = $building[34];
			/********************** entrance open/close time ***********/
		
			$entVal = "";
			if(isset($building[35])){
				if($building[35] == 2){
					$entVal .= $building[35].'-'.$building[36].'~'.$building[37].",";
				}else{
					$entVal .= $building[35].",";
				}
			}
		
			if(isset($building[38])){
				if($building[38] == 2){
					$entVal .= $building[38].'-'.$building[39].'~'.$building[40].",";
				}else{
					$entVal .= $building[38].",";
				}
			}
		
			if(isset($building[41])){
				if($building[41] == 2){
					$entVal .= $building[41].'-'.$building[42].'~'.$building[43].",";
				}else{
					$entVal .= $building[41];
				}
			}
			$model->ent_op_cl_time = $entVal;
			/********************* end ******************/
		
			$model->ent_auto_lock = $building[44];
		
			/******************* parking unit ***************/
			if($building[45] == 1){
				$model->parking_unit_no = $building[45].'-'.$building[46];
			}else{
				$model->parking_unit_no = $building[45];
			}
			/******************* end *********************/
		
			/******************* limit time usage ************/
			$limitVal = "";
			if(isset($building[47])){
				if($building[47] == 2){
					$limitVal .= $building[47].'-'.$building[48].'~'.$building[49].",";
				}else{
					$limitVal .= $building[47].",";
				}
			}
		
			if(isset($building[50])){
				if($building[50] == 2){
					$limitVal .= $building[50].'-'.$building[51].'~'.$building[52].",";
				}else{
					$limitVal .= $building[50].",";
				}
			}
				
			if(isset($building[53])){
				if($building[53] == 2){
					$limitVal .= $building[53].'-'.$building[54].'~'.$building[55].",";
				}else{
					$limitVal .= $building[53];
				}
			}
			$model->limit_of_usage_time = $limitVal;
			/******************* end *************************/
		
			/******************* air conditioning time limit ************/
			$airVal = "";
			if(isset($building[56])){
				if($building[56] == 2){
					$airVal .= $building[56].'-'.$building[57].'~'.$building[58].",";
				}else{
					$airVal .= $building[56].",";
				}
			}
				
			if(isset($building[59])){
				if($building[59] == 2){
					$airVal .= $building[59].'-'.$building[60].'~'.$building[61].",";
				}else{
					$airVal .= $building[59].",";
				}
			}
		
			if(isset($building[62])){
				if($building[62] == 2){
					$airVal .= $building[62].'-'.$building[63].'~'.$building[64].",";
				}else{
					$airVal .= $building[62];
				}
			}
			$model->air_condition_time = $airVal;
			/******************* end *************************/
		
			/******************* parking use time limit ************/
			$parkingVal = "";
			if(isset($building[65])){
				if($building[65] == 2){
					$parkingVal .= $building[65].'-'.$building[66].'~'.$building[67].",";
				}else{
					$parkingVal .= $building[65].",";
				}
			}
		
			if(isset($building[68])){
				if($building[68] == 2){
					$parkingVal .= $building[68].'-'.$building[69].'~'.$building[70].",";
				}else{
					$parkingVal .= $building[68].",";
				}
			}
		
			if(isset($building[71])){
				if($building[71] == 2){
					$parkingVal .= $building[71].'-'.$building[72].'~'.$building[73].",";
				}else{
					$parkingVal .= $building[71];
				}
			}
			$model->parking_time = $parkingVal;
			/******************* end *************************/
	
			$model->lend_house = $building[74];
			$model->ceiling_height = $building[75];
			$model->air_control_type = $building[76];
			$model->notes = $building[77];
		
			$model->oa_floor = '';
// 			if(isset($building[78])){
// 				if($building[78] == 2){
// 					$model->oa_floor = $building[78].'-'.$building['oa_floor_txt'];
// 				}else{
// 					$model->oa_floor = $building['oa_floor'];
// 				}
// 			}
		
			$model->opticle_cable = $building[79];
			$model->wholesale_lease = $building[80];
			$model->security_id = $building[81];
			$model->form_type_id = $building[82];
// 			$model->buildingId = 'JPB'.mt_rand(1000,9999);
			$model->buildingId = $this->generateBuildingId();
				
			/******************* condominium oqnership ************/
			if(isset($building[83])){
				$model->condominium_ownership = $building[83];
			}
			/******************* end *************************/
		
			$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
			$logged_user_id = $user->user_id;
			$model->added_by = $logged_user_id;
			$model->added_on = date('Y-m-d H:i:s');
			$model->modified_by = $logged_user_id;
			$model->modified_on = date('Y-m-d H:i:s');
			if($building[4] != ''){
				$address = explode(',',$building[4]);
				$address = end($address);
				
				$aAddress = $this->getAddressByGoogleMap($address);
				
				$lat = $aAddress['lat'];
				$long = $aAddress['long'];
				$prefecture = $aAddress['prefecture'];
				$district = $aAddress['district'];
				$town = $aAddress['town'];
				$postalCode = $aAddress['postalCode'];
				$postalCodeOrder = $aAddress['postalCodeOrder'];
				
				$aAddress = $this->getAddressByGoogleMap($address, 'en');
				$prefecture_en = $aAddress['prefecture'];
				$district_en = $aAddress['district'];
				$town_en = $aAddress['town'];
				
				$model->prefecture_en = $prefecture_en;
				$model->district_en = $district_en;
				$model->town_en = $town_en;
		
			}else{
				$lat = '';
				$long = '';
				$prefecture = '';
				$district = '';
				$postalCode = '';
				$postalCodeOrder = '';
				$town = '';
			}
			
			$model->address_en = isset($aAddress) ? $aAddress['address_en'] : '';
			$model->map_lat = $lat;
			$model->map_long = $long;
			$model->prefecture = $prefecture;
			$model->district = $district;
			$model->town = $town;
			$model->postal_code = $postalCode;
			$model->postal_code_order = $postalCodeOrder;
			
			$model->name_en = $building[88];
			$model->description_ja = $building[89];
			$model->description_en = $building[90];
			$model->avg_neighbor_fee_min = $building[91];
			$model->avg_neighbor_fee_max = $building[92];
			$model->video_type = $building[93];
			$model->video_id = $building[94];
			
			if($model->save(false)){
				//--------------save image-----------------
				$path = realpath(Yii::app()->basePath.'/../buildingPictures/front');				
				$frontimg = "";
				$mainimg = "";
				$arr_image = Array();
				$arr = explode(",", $building[85]);
				foreach($arr AS $pic) {
					$img = trim($pic);
 					$img_name = $this->saveimage($path, $img);
 					if($img_name!="") {
 						$arr_image[] = $img_name;
 						if($mainimg == "")
 							$mainimg = $img_name;
 					}
				}
				$frontimg = implode(",", $arr_image); 
				
				//------
				$path = realpath(Yii::app()->basePath.'/../buildingPictures/entrance');
				$entranceimg = "";
				$arr_image = Array();
				$arr = explode(",", $building[86]);
				foreach($arr AS $pic) {
					$img = trim($pic);
					$img_name = $this->saveimage($path, $img);
					if($img_name!="")
						$arr_image[] = $img_name;
				}
				$entranceimg = implode(",", $arr_image);
				//------
				$path = realpath(Yii::app()->basePath.'/../buildingPictures/inFront');
				$infrontimg = "";
				$arr_image = Array();
				$arr = explode(",", $building[87]);
				foreach($arr AS $pic) {
					$img = trim($pic);
					$img_name = $this->saveimage($path, $img);
					if($img_name!="")
						$arr_image[] = $img_name;
				}
				$infrontimg = implode(",", $arr_image);
				//------
				
				$model_picture = new BuildingPictures();
				$model_picture->building_id = $model->building_id;
				$model_picture->main_image = $mainimg;
				$model_picture->front_images = $frontimg;
				$model_picture->entrance_images = $entranceimg;
				$model_picture->in_front_building_images = $infrontimg;
				$model_picture->added_by = $logged_user_id;
				$model_picture->added_on = date('Y-m-d H:i:s');
				
				$buildingDetails = Building::model()->findByPk($buildingId);
				if($model_picture->save(false)){
// 					$changeLogModel = new BuildingUpdateLog;
// 					$changeLogModel->building_id = $buildingId;
// 					$changeLogModel->change_content = Yii::app()->controller->__trans('Building Picture info').' ('.$buildingDetails['prefecture'].')'.Yii::app()->controller->__trans('has been updated');
// 					$changeLogModel->added_by = $logged_user_id;
// 					$changeLogModel->added_on = date('Y-m-d H:i:s');
// 					if($changeLogModel->save(false)){
// 						$resp = array('status'=>1);
// 					}
				}
				//--------------end------------------------
				
				Yii::app()->closetown->calculateMarketCloseTown($town);
		
				$listOfStation = $this->actionGetNearestStation($long, $lat);
				foreach($listOfStation as $station){
					$stationModel = new BuildingStation;
					$stationModel->building_id = $model->building_id;
					$stationModel->prefecture = $prefecture;
					$stationModel->corporate = $station['corporate'];
					$stationModel->name = $station['name'];
					$stationModel->name_en = $station['name_en'];
					$stationModel->line = $station['line'];
					$stationModel->distance = $station['distance'];
					$stationModel->time = ceil($station['distance']/80);
					$stationModel->save(false);
				}
		
				//check for office alert
				$cBuildingId = $model->building_id;
				$currentBuilding = Building::model()->findByPk($cBuildingId);
		
				$buildingStationTime = BuildingStation::model()->findAll('building_id = '.$cBuildingId);
				$arrayTime = array();
				$arrayRoute = array();
				foreach($buildingStationTime as $nTime){
					$arrayTime[] = $nTime->time;
					$arrayRoute[] = $nTime->name;
				}
		
				$criteria=new CDbCriteria();
				$criteria->order='office_alert_id DESC';
				$officeAlertList = OfficeAlert::model()->findAll($criteria);
		
				$i = 1;
				foreach($officeAlertList as $officeAlert){
					$getConditions = SearchSettings::model()->findByPk($officeAlert->cond_id);
					$cond = json_decode($getConditions->ss_json,true);
					$buildingId = explode(',',$officeAlert->building_id);
						
					$oAlert = OfficeAlert::model()->findByPk($officeAlert->office_alert_id);
					$pass = true;
						
					if(isset($cond['buildingAge']) && $cond['buildingAge'] != 0){
						$bAge = $currentBuilding->built_year;
						$bAge = explode('-',$bAge);
						$bAge = $bAge[0];
						if($cond['buildingAge'] != $bAge){
							$pass = false;
						}
					}
						
					if(isset($cond['deadlineCheck'])){
						if($cond['deadlineCheck'] != $currentBuilding->building_with_deadline){
							$pass = false;
						}
					}
						
					if(isset($cond['buildingSearchName'])){
						if($cond['buildingSearchName'] != $currentBuilding->name){
							$pass = false;
						}
					}
						
					if(isset($cond['buildingSearchAddress'])){
						$pos = strpos($cond['buildingSearchAddress'],  $currentBuilding->address);
						if($pos === false){
							$pass = false;
						}
					}
						
					if(isset($cond['pre-list']) && $cond['pre-list'] != ""){
						$prefecture = Prefecture::model()->find("prefecture_name LIKE '%".$currentBuilding->prefecture."%'");
						$prefectureId = $prefecture->code;
						if($prefectureId != $cond['pre-list']){
							$pass = false;
						}
					}
						
					/*if(isset($cond['prefectureDistrictlist']) && $cond['prefectureDistrictlist'] != ""){
					 $district = District::model()->find('district_name LIKE "%'.$currentBuilding->district.'%"');
					 $districtId = $district->code;
					 if($districtId != $cond['prefectureDistrictlist']){
					 $pass = false;
					 echo "-------------------- condition 6--------<br/>";
					 echo "R = ".$pass."<br/>";
					 }
					 }*/
						
					if(isset($cond['districtTownList']) && !empty($cond['districtTownList'])){
						$town = Town::model()->find('town_name LIKE "%'.$currentBuilding->town.'%"');
						$townId = $town->code;
						if(!in_array($townId,$cond['districtTownList'])){
							$pass = false;
						}
					}
						
					if(isset($cond['hdnRPrefId']) && $cond['hdnRPrefId'] != 0){
						$prefecture = Prefecture::model()->find("prefecture_name LIKE '%".$currentBuilding->prefecture."%'");
						$prefectureId = $prefecture->code;
						$prefecture = Prefecture::model()->find("code = '".$cond['hdnRPrefId']."'");
						if($prefectureId != $cond['hdnRPrefId']){
							$pass = false;
						}
					}
						
					if(isset($cond['hdnRailId']) && $cond['hdnRailId'] != 0){
						$rail = BuildingStation::model()->findAll("building_id = ".$cBuildingId);
						$corpArray = array();
						foreach($rail as $r){
							$corpArray[] = $r->corporate;
						}
						if(!in_array($cond['hdnRailId'],$corpArray)){
							$pass = false;
						}
					}
						
					if(isset($cond['hdnLineId']) && $cond['hdnLineId'] != 0){
						$line = BuildingStation::model()->findAll("building_id = ".$cBuildingId);
						$lineArray = array();
						foreach($line as $l){
							$lineArray[] = $l->line;
						}
						if(!in_array($cond['hdnLineId'],$lineArray)){
							$pass = false;
						}
					}
						
					if(isset($cond['hdnRRouteId']) && $cond['hdnRRouteId'] != ""){
						$route = explode(',',$cond['hdnRRouteId']);
						$routeDetail = BuildingStation::model()->findAll("building_id = ".$cBuildingId);
						$rArray = array();
						foreach($routeDetail as $rt){
							$rArray[] = $rt->line;
						}
						foreach($route as $rLoop){
							if(!in_array($rLoop,$rArray)){
								$pass = false;
							}
						}
					}
						
					if(isset($cond['floorSearchOwnerName']) && $cond['floorSearchOwnerName'] != ""){
						$oNew = preg_split('/\r\n|[\r\n]/', $cond['floorSearchOwnerName']);
						$buildingOwner = OwnershipManagement::model()->findAll('building_id = '.$cBuildingId);
						$bOwnerList = array();
		
						foreach($buildingOwner as $owner){
							$bOwnerList[] = $owner->owner_company_name;
						}
		
						foreach($oNew as $o){
							if(!in_array($o,$bOwnerList)){
								$pass = false;
							}
						}
					}
						
					if(isset($cond['hdnAddressBuildingId']) && $cond['hdnAddressBuildingId'] != 0){
						$sBuildingId = explode(',',$cond['hdnAddressBuildingId']);
						if(!in_array($cBuildingId,$sBuildingId)){
							$pass = false;
						}
					}
						
					if(in_array($cBuildingId,$buildingId)){
						$bIds = $buildingId;
						$bIds = array_diff($buildingId, array($cBuildingId));
					}
						
					if($pass == true){
						$bIds = array_push($bIds,$cBuildingId);
						$bIds = implode(',',$bIds);
						$oAlert->building_id = $bIds;
						$oAlert->save(false);
					}
						
					$i++;
				}		
				
				// BEGIN - Create wordpress building reference
				$wordpress = new Wordpress();
				$wordpress->processIntergrateWordpress($model->building_id, Wordpress::BUILDING_TYPE, 'create');
				$wordpress->reGenerateLocations();
				// End - processing with wordpress
			}
		}
		
		$bid = $model->building_id;
		return $bid;
	}
	
	public function saveimage($path, $url) {
		$randName = mt_rand(100000, 999999).".jpg";
		$ret = copy($url, $path.'/'.$randName);
		if($ret) {
			return $randName;
		}
		echo "";
	}
	
	public function insertFloor($building_id, $floor) {
		$model=new Floor;
		
		$useTypesDetails = UseTypes::model()->findAll('is_active = 1');
		$floorSourceDetails = FloorSourceFromType::model()->findAll('is_active = 1');
		$userList = Users::model()->findAll('is_active = 1');

		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $user->user_id;
		
		if(isset($floor)){
			//-------plan image upload-------
			$path = realpath(Yii::app()->basePath.'/../planPictures');
			$img = trim($floor[106]);
			$plan_image = $this->saveimage($path, $img);
			$rand_name = explode(".",$plan_image);
			
			$plan_model = new PlanPicture;
			$plan_model->building_id = $building_id;
			$getRandomNum = $rand_name[0];
			$plan_model->plan_rand_number = $getRandomNum;
			$plan_model->added_by = $loguser_id;
			$plan_model->added_on = date('Y-m-d H:i:s');
			$plan_model->name = $plan_image;
			
			if($plan_model->save(false)){
				$model->plan_picture_id = $plan_model->plan_picture_id;
			} else {
				$model->plan_picture_id = '';
			}
				
			//-------------end
			$model->building_id = $building_id;

			$model->vacancy_info = $floor[1];
			$model->preceding_user = $floor[3];
			$model->preceding_details = $floor[4];
			$model->preceding_check_datetime = $floor[5];
			$model->move_in_date = $floor[7];
			$model->vacant_schedule = $floor[9];
			$model->floor_down = $floor[10];
			$model->floor_up = $floor[11];
			$model->roomname = $floor[12];
			if(isset($floor[14]) && $floor[14] != ''){
				$model->maisonette_type = $floor[14];
			}else{
				$model->maisonette_type = '';
			}
			$model->short_term_rent = $floor[16];
			$model->type_of_use = $floor[18];
			$model->area_ping = $floor[20];
			$model->area_m = $floor[21];
			$model->area_net = $floor[22];
			if(isset($floor[24]) && $floor[24] != ''){
				$model->calculation_method = $floor[24];
			}else{
				$model->calculation_method = '';
			}
			if(isset($floor[26]) && $floor[26] != ''){
				$model->payment_by_installments = $floor[26];
			}else{
				$model->payment_by_installments = '';
			}
			$model->payment_by_installments_note = $floor[27];
			if(isset($floor[29]) && $floor[29] != ''){
				$model->floor_partition = $floor[29];
			}else{
				$model->floor_partition = '';
			}
			$model->rent_unit_price_opt = $floor[31];
			$model->rent_unit_price = $floor[32];
			$model->total_rent_price = $floor[34];
			$model->unit_condo_fee_opt = $floor[36];
			$model->unit_condo_fee = $floor[37];
			$model->total_condo_fee = $floor[39];
			$model->deposit_opt = $floor[41];
			$model->deposit_month = $floor[42];
			$model->deposit = $floor[43];
			$model->total_deposit = $floor[45];
			$model->key_money_opt = $floor[47];
			$model->key_money_month = $floor[48];
			$model->repayment_opt = $floor[50];
			$model->repayment_reason = $floor[51];
			$model->repayment_amt = $floor[52];
			if(isset($floor[53]) && $floor[53] != ''){
				$model->repayment_amt_opt = $floor[53];
			}else{
				$model->repayment_amt_opt = '';
			}
			$model->floorId = 'JPF'.mt_rand(1000,999999);
			$model->renewal_fee_opt	 = $floor[55];
			$model->renewal_fee_reason	 = $floor[57];
			$model->renewal_fee_recent	 = $floor[58];
			$model->repayment_notes	 = $floor[60];
			$model->notice_of_cancellation	 = $floor[62];
			if(isset($floor[64]) && $floor[64] != ''){
				$model->contract_period_opt	 = $floor[64];
			}else{
				$model->contract_period_opt = '';
			}
			if(isset($floor[66]) && $floor[66] != ''){
				$model->contract_period_optchk	 = 1;
			}
			$model->contract_period_duration	 = $floor[65];
			$model->air_conditioning_facility_type	 = $floor[68];
			$model->air_conditioning_details	 = $floor[69];
			if(isset($floor[71]) && $floor[71] == 2){
				$model->air_conditioning_time_used	 = $floor[71].'-'.$floor[72].'~'.$floor[73].'-'.$floor[74].'~'.$floor[75].'-'.$floor[76].'~'.$floor[77];
			}else{
				$model->air_conditioning_time_used	 = $floor[71];
			}
			$model->number_of_air_conditioning	 = $floor[79];
			
			$model->optical_cable	 = '';//$floor['optical_cable'];
			
			$model->oa_type = $floor[81];
			$model->oa_height = $floor[82];
			$model->ceiling_height = $floor[86];
			$model->floor_material = $floor[84];
			$model->electric_capacity = $floor[88];
			$model->separate_toilet_by_gender = $floor[90];
			if(isset($floor[92]) && $floor[92] != ''){
				$model->toilet_location = $floor[92];
			}else{
				$model->toilet_location = '';
			}
			
			$model->washlet = '';
// 			if(isset($floor['washlet']) && $floor['washlet'] != ''){
// 				$model->washlet = $floor['washlet'];
// 			}else{
// 				$model->washlet = '';
// 			}

			$model->toilet_cleaning = '';
// 			if(isset($floor['toilet_cleaning']) && $floor['toilet_cleaning']!= ''){
// 				$model->toilet_cleaning = $floor['toilet_cleaning'];
// 			}else{
// 				$model->toilet_cleaning = '';
// 			}
			$model->notes = $floor[93];
			$model->floor_source_id = $floor[95];
				
			if(isset($floor[96])){
				$model->web_publishing = $floor[96];
				if($floor[97] != ""){
					$model->web_publishing_note = $floor[97];
				}
			}
				
			$model->update_person_in_charge = $floor[98];
			$model->property_confirmation_person = $floor[99];
		
			//$model->plan_picture_id = '';
			
			$model->added_by = $loguser_id;
			$model->added_on = date('Y-m-d H:i:s');
			$model->modified_by = $loguser_id;
			$model->modified_on = date('Y-m-d H:i:s');
		
			if($model->save(false)){
				
				// BEGIN - Create wordpress building reference
				$params['building_id'] = $model->building_id;
				$wordpress = new Wordpress();
				$wordpress->processIntergrateWordpress($model->floor_id, Wordpress::FLOOR_TYPE, 'create', $params);
				$wordpress->reGenerateLocations();
				// End - processing with wordpress
				
				//--------------save image-----------------
				$path = realpath(Yii::app()->basePath.'/../floorPictures/indoor');
				$indoorimg = "";
				$arr_image = Array();
				$arr = explode(",", $floor[100]);
				foreach($arr AS $pic) {
					$img = trim($pic);
					$img_name = $this->saveimage($path, $img);
					if($img_name!="") {
						$arr_image[] = $img_name;
					}
				}
				$indoorimg = implode(",", $arr_image);
				
				//------
				$path = realpath(Yii::app()->basePath.'/../floorPictures/kitchen');
				$kitchenimg = "";
				$arr_image = Array();
				$arr = explode(",", $floor[101]);
				foreach($arr AS $pic) {
					$img = trim($pic);
					$img_name = $this->saveimage($path, $img);
					if($img_name!="") {
						$arr_image[] = $img_name;
					}
				}
				$kitchenimg = implode(",", $arr_image);
				//------
				$path = realpath(Yii::app()->basePath.'/../floorPictures/bathroom');
				$bathroomimg = "";
				$arr_image = Array();
				$arr = explode(",", $floor[102]);
				foreach($arr AS $pic) {
					$img = trim($pic);
					$img_name = $this->saveimage($path, $img);
					if($img_name!="") {
						$arr_image[] = $img_name;
					}
				}
				$bathroomimg = implode(",", $arr_image);
				//------
				$path = realpath(Yii::app()->basePath.'/../floorPictures/prospect');
				$prospectimg = "";
				$arr_image = Array();
				$arr = explode(",", $floor[103]);
				foreach($arr AS $pic) {
					$img = trim($pic);
					$img_name = $this->saveimage($path, $img);
					if($img_name!="") {
						$arr_image[] = $img_name;
					}
				}
				$prospectimg = implode(",", $arr_image);
				//------
				$path = realpath(Yii::app()->basePath.'/../floorPictures/other');
				$otherimg = "";
				$arr_image = Array();
				$arr = explode(",", $floor[104]);
				foreach($arr AS $pic) {
					$img = trim($pic);
					$img_name = $this->saveimage($path, $img);
					if($img_name!="") {
						$arr_image[] = $img_name;
					}
				}
				$otherimg = implode(",", $arr_image);					
				//------
				$path = realpath(Yii::app()->basePath.'/../floorPictures/tenant');
				$tenantimg = "";
				$arr_image = Array();
				$arr = explode(",", $floor[105]);
				foreach($arr AS $pic) {
					$img = trim($pic);
					$img_name = $this->saveimage($path, $img);
					if($img_name!="") {
						$arr_image[] = $img_name;
					}
				}
				$tenantimg = implode(",", $arr_image);
				//------
				$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
				$logged_user_id = $user->user_id;
				
				$model_picture = new FloorPictures();
				$model_picture->building_id = $building_id;
				$model_picture->floor_id = $model->floor_id;
				$model_picture->indoor_image = $indoorimg;
				$model_picture->kitchen_image = $kitchenimg;
				$model_picture->bathroom_image = $bathroomimg;
				$model_picture->prospect_image = $prospectimg;
				$model_picture->other_image = $otherimg;
				$model_picture->tenant_list_image = $tenantimg;
				$model_picture->added_by = $logged_user_id;
				$model_picture->added_on = date('Y-m-d H:i:s');				

				if($model_picture->save(false)){
				}
				//==========end==============
				
				$buildingDetails = Building::model()->findByPk($building_id);
				$town = $buildingDetails->town;
				Yii::app()->closetown->calculateMarketCloseTown($town);
		
				$managementDetails = OwnershipManagement::model()->findAll('building_id = '.$building_id.' AND floor_id = -1');
				foreach($managementDetails as $management){
					$management->floor_id = $model->floor_id;
					$management->save(false);
				}
		
				$TraderDetails = Traders::model()->findAll('building_id = '.$building_id.' AND floor_id = -1');
				foreach($TraderDetails as $trader){
					$trader->floor_id = $model->floor_id;
					$trader->save(false);
				}
		
				$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
				$loguser_id = $users->user_id;
				$buildingDetails = Building::model()->findByPk($building_id);
		
				$changeLogModel = new BuildingUpdateLog;
				$changeLogModel->building_id = $building_id;
				$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/singleBuilding',array('id'=>$model->floor_id)).'">'.Yii::app()->controller->__trans('New floor').' ID:'.$model->floor_id.' ('.$buildingDetails['prefecture'].')</a> '.Yii::app()->controller->__trans('has been added');
				$changeLogModel->added_by = $loguser_id;
				$changeLogModel->added_on = date('Y-m-d H:i:s');
				if($changeLogModel->save(false)){
						
					//check for office alert
					$cFloorId = $model->floor_id;
					$currentFloor = Floor::model()->findByPk($cFloorId);
		
					$criteria=new CDbCriteria();
					$criteria->order='office_alert_id DESC';
					$officeAlertList = OfficeAlert::model()->findAll($criteria);
						
					$i = 1;
					foreach($officeAlertList as $officeAlert){
						$getConditions = SearchSettings::model()->findByPk($officeAlert->cond_id);
						$cond = json_decode($getConditions->ss_json,true);
						$floorId = explode(',',$officeAlert->floor_id);
		
						$oAlert = OfficeAlert::model()->findByPk($officeAlert->office_alert_id);
						$pass = true;
		
						if((isset($cond['areaMinValue']) && $cond['areaMinValue'] != 0) || (isset($cond['areaMaxValue']) && $cond['areaMaxValue'] != 0)){
							$fArea = $currentFloor->area_ping;
							if(!($fArea > $cond['areaMinValue']) && !($fArea < $cond['areaMaxValue'])){
								$pass = false;
							}
						}
		
						if((isset($cond['floorMin']) && $cond['floorMin'] != 0) || (isset($cond['floorMax']) && $cond['floorMax'] != 0)){
							$fMin = $currentFloor->floor_down;
							$fMax = $currentFloor->floor_up;
							if(!($fMin > $cond['floorMin']) && !($fMax <= $cond['floorMax'])){
								$pass = false;
							}
						}
		
						if((isset($cond['unitMinValue']) && $cond['unitMinValue'] != 0) || (isset($cond['unitMaxValue']) && $cond['unitMaxValue'] != 0)){
							$fUnit = $currentFloor->rent_unit_price;
							if(!($fUnit > $cond['unitMinValue']) && !($fUnit <= $cond['unitMaxValue'])){
								$pass = false;
							}
						}
		
						if((isset($cond['costMinAmount']) && $cond['costMinAmount'] != 0) || (isset($cond['costMaxAmount']) && $cond['costMaxAmount'] != 0)){
							$fCost = $currentFloor->unit_condo_fee;
							if(!($fCost > $cond['costMinAmount']) && !($fCost <= $cond['costMaxAmount'])){
								$pass = false;
							}
						}
		
						if((isset($cond['possibleDataMin']) && $cond['possibleDataMin'] != 0) || (isset($cond['possibleDataMax']) && $cond['possibleDataMax'] != 0)){
							$fMoveDate = $currentFloor->move_in_date;
							$expDate = explode('/',$fMoveDate);
							if(!(is_int($expDate[2]))){
								unset($expDate[2]);
								array_push($expDate,1);
							}
							$expDate = implode('/',$expDate);
							$convertTime = strtotime($expDate);
							$minDate = strtotime($cond['possibleDataMin']);
							$maxDate = strtotime($cond['possibleDataMax']);
							if(!($convertTime > $minDate) && !($convertTime < $maxDate)){
								$pass = false;
							}
						}
		
						if(isset($cond['statusRequirement']) && !empty($cond['statusRequirement'])){
							if(in_array("2", $cond['statusRequirement'])){
								$fVacantSchedule = $currentFloor->vacant_schedule;
								$expDate = explode('/',$fVacantSchedule);
								if(!(is_int($expDate[2]))){
									unset($expDate[2]);
									array_push($expDate,1);
								}
		
								$convertTime = strtotime($expDate);
								$todayDate = strtotime('today');
								$oneYearOn = strtotime("+ 365 day");
								if(!($convertTime >= $todayDate) && !($convertTime <= $oneYearOn)){
									$pass = false;
								}
							}
								
							if(in_array("1", $cond['statusRequirement'])){
								if($currentFloor->vacancy_info != 1){
									$pass = false;
								}
							}
								
							if(in_array("3", $cond['statusRequirement'])){
								if($currentFloor->vacancy_info != 0){
									$pass = false;
								}
							}
						}
		
						if(isset($cond['facilities']) && !empty($cond['facilities'])){
							$facilities = $cond['facilities'];
							foreach($facilities as $fac){
								if(in_array($fac,array('1','3'))){
									if($fac == 1){
										if($currentFloor->separate_toilet_by_gender != 2){
											$pass = false;
										}
									}else{
										if($currentFloor->air_conditioning_facility_type != "個別・セントラル"){
											$pass = false;
										}
									}
								}else{
									if($fac == '2'){
										if($currentFloor->oa_type != 2){
											$pass = false;
										}
									}
									if($fac == '4'){
										if($currentFloor->floor_partition == ""){
											$pass = false;
										}
									}
								}
							}
						}
		
						if(isset($cond['floorType']) && !empty($cond['floorType'])){
							$floorType = $currentFloor->type_of_use;
							$fType = explode(',',$floorType);
								
							foreach($cond['floorType'] as $type){
								if(!(in_array($type,$fType))){
									$pass = false;
								}
							}
						}
		
						if(isset($cond['formTypeList']) && !empty($cond['formTypeList'])){
							$formTypeList = OwnershipManagement::model()->findAll('floor_id = '.$cFloorId);
							$fManagementType = array();
							foreach($formTypeList as $fType){
								$fManagementType[] = $fType->management_type;
							}
							foreach($cond['formTypeList'] as $formType){
								if(!(in_array($formType,$fManagementType))){
									$pass = false;
								}
							}
						}
		
						if(isset($cond['lenderType']) && !empty($cond['lenderType'])){
							$lenderTypeList = OwnershipManagement::model()->findAll('floor_id = '.$cFloorId);
							$fOwnerType = array();
							foreach($lenderTypeList as $fLType){
								$fOwnerType[] = $fLType->ownership_type;
							}
							foreach($cond['lenderType'] as $lenderType){
								if(!(in_array($lenderType,$fOwnerType))){
									$pass = false;
								}
							}
						}
		
						if(isset($cond['hdnAddressFloorId']) && $cond['hdnAddressFloorId'] != 0){
							$sFloorId = explode(',',$cond['hdnAddressFloorId']);
							if(!in_array($cFloorId,$sFloorId)){
								$pass = false;
							}
						}
		
						if(in_array($cFloorId,$floorId)){
							$afterDiffFloorId = array_diff($floorId, array($cFloorId));
						}else{
							$afterDiffFloorId = $floorId;
						}
		
						if($pass == true){
							array_push($afterDiffFloorId,$cFloorId);
							$fIds = implode(',',$afterDiffFloorId);
							$oAlert->floor_id = $fIds;
							$oAlert->save(false);
						}
						$i++;
					}
				}
			}
		}
	}
	
	public function actionMigrateOfficeWordpress() {
		$wordpress = new Wordpress();
		$buildings = Building::model()->findAll();
		$floors = new Floor();
		$stations = new BuildingStation();
		$buildingPic = new BuildingPictures();
	
		// @TODO remove below
		spl_autoload_unregister(array(
			'YiiBase',
			'autoload'
		));
	
		// Include wordpress class
		include Yii::getPathOfAlias('webroot') . '/wp/wp-blog-header.php';
		include Yii::getPathOfAlias('webroot') . '/wp/wp-content/plugins/polylang-pro/polylang.php';
	
		foreach ($buildings as $building)
		{
			if($building->name)
			{
// 				$wordpress->processIntergrateWordpress($building->building_id, Wordpress::BUILDING_TYPE, 'update');
	
				// Floor
				$floors = Floor::model()->findAll("building_id=$building->building_id AND show_frontend=1");
				foreach ($floors as $floor)
				{
					$params['building_id'] = $floor->building_id;
					$wordpress->processIntergrateWordpress($floor->floor_id, Wordpress::FLOOR_TYPE, 'update', $params);
				}
			}
		}
		$wordpress->reGenerateLocations();
	
		// Register again yii autoload
		spl_autoload_register(array(
			'YiiBase',
			'autoload'
		));
	
		echo '<pre>'; print_r(count($buildings));
		die;
	}
	
	
	private function setCurl($url) {
		// create curl resource
		$ch = curl_init();
		// set url
		curl_setopt($ch, CURLOPT_URL, $url);
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $output contains the output string
		$output = curl_exec($ch);
		// close curl resource to free up system resources
		curl_close($ch);
		return $output;
	}
	
	public function actionSendEmailFollowed()
	{
		// @TODO remove below
		spl_autoload_unregister(array(
			'YiiBase',
			'autoload'
		));
			
		// Include wordpress class
		include Yii::getPathOfAlias('webroot') . '/wp/wp-blog-header.php';
		
		$floor_id = $_POST['floor_id'];
		
		// Send as english
		$url = get_option('siteurl') . '/?lang=en&api_send_follow_email='.$floor_id;
		$output = $this->setCurl($url);
		print_r($output);
		// Send as japanese
		$url = get_option('siteurl') . '/?lang=ja&api_send_follow_email='.$floor_id;
		$output = $this->setCurl($url);
		print_r($output);die;
		// Register again yii autoload
		spl_autoload_register(array(
			'YiiBase',
			'autoload'
		));
		
		echo json_encode(array('success' => $output ? 1 : 0)); die;
	}
}