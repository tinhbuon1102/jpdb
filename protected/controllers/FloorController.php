<?php
class FloorController extends Controller{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	public $layout='//layouts/column2';
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
				'actions'=>array('index','view','addProposedToCart'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','getSearchedTraderList','getSeletectedTraderDetails','addFloorToCart','removeFloorFromCart','appendNewManagementHistory','addNewManagementHistory','deleteFloor','addFastFloor','addNewPlanPicture','allocatePlanToFloor','removeSelectedPlanPicture','addAllFromToCart','addProposedToCart','addSingleBuildToCart','removeAllItemCart','Clonesettings','deleteManagement','removeFloorToCart','checkRoomNumber','sortCart','bulkDelete', 'viewFloorMass', 'updateFloorMass', 'copyFloorMass', 'deleteFloorMass', 'insertFloorMass','appendNewManagementHistoryMass','updateShowFrontend'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate(){
		//if(isset($_REQUEST['add_floor'])){
		//}
		//echo 1;die;
		$this->layout = 'main';
		$model=new Floor;		

		$useTypesDetails = UseTypes::model()->findAll('is_active = 1');
		$floorSourceDetails = FloorSourceFromType::model()->findAll('is_active = 1');
		$userList = Users::model()->findAll('is_active = 1');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Floor'])){
			if(isset($_POST['Floor']['buildingId']) && $_POST['Floor']['buildingId'] != ''){
				$model->building_id = $_POST['Floor']['buildingId'];
			}else{
				$model->building_id = '';
			}
			$model->vacancy_info = $_POST['Floor']['vac_info'];
			$model->preceding_user = $_POST['Floor']['pre_user'];
			$model->preceding_details = $_POST['Floor']['pre_details'];
			$model->preceding_check_datetime = $_POST['Floor']['pre_check_datetime'];
			$model->move_in_date = $_POST['Floor']['move_date'];
			$model->vacant_schedule = $_POST['Floor']['vac_sche'];
			$model->floor_down = $_POST['Floor']['floor_down'];
			$model->floor_up = $_POST['Floor']['floor_up'];
			$model->roomname = $_POST['Floor']['roomname'];
			if(isset($_POST['Floor']['maisonette_type']) && $_POST['Floor']['maisonette_type'] != ''){
				$model->maisonette_type = $_POST['Floor']['maisonette_type'];
			}else{
				$model->maisonette_type = '';
			}
			$model->short_term_rent = $_POST['Floor']['short_term_rent'];
			$model->type_of_use = implode(',',$_POST['Floor']['type_of_use']);
			$model->area_ping = $_POST['Floor']['area_ping'];
			$model->area_m = $_POST['Floor']['area_m'];
			$model->area_net = $_POST['Floor']['area_net'];
			if(isset($_POST['Floor']['calculation_method']) && $_POST['Floor']['calculation_method'] != ''){
				$model->calculation_method = $_POST['Floor']['calculation_method'];
			}else{
				$model->calculation_method = '';
			}
			if(isset($_POST['Floor']['payment_by_installments']) && $_POST['Floor']['payment_by_installments'] != ''){
				$model->payment_by_installments = $_POST['Floor']['payment_by_installments'];
			}else{
				$model->payment_by_installments = '';
			}
			
			$model->core_section = isset($_POST['Floor']['core_section']) ? (int)$_POST['Floor']['core_section'] : 0;
			$model->high_grade_building = isset($_POST['Floor']['high_grade_building']) ? (int)$_POST['Floor']['high_grade_building'] : 0;
			
			$model->payment_by_installments_note = $_POST['Floor']['payment_by_installments_detail'];
			if(isset($_POST['Floor']['floor_partition']) && $_POST['Floor']['floor_partition'] != ''){
				$model->floor_partition = implode(',',$_POST['Floor']['floor_partition']);
			}else{
				$model->floor_partition = '';
			}
			$model->rent_unit_price_opt = $_POST['Floor']['rent_unit_price_opt'];
			$model->rent_unit_price = $_POST['Floor']['rent_unit_price'];
			$model->total_rent_price = $_POST['Floor']['total_rent_price'];
			$model->unit_condo_fee_opt = $_POST['Floor']['unit_condo_fee_opt'];
			$model->unit_condo_fee = $_POST['Floor']['unit_condo_fee'];
			$model->total_condo_fee = $_POST['Floor']['total_condo_fee'];
			$model->deposit_opt = $_POST['Floor']['deposit_opt'];
			$model->deposit_month = $_POST['Floor']['deposit_month'];
			$model->deposit = $_POST['Floor']['deposit'];
			$model->total_deposit = $_POST['Floor']['total_deposit'];
			$model->key_money_opt = $_POST['Floor']['key_money_opt'];
			$model->key_money_month = $_POST['Floor']['key_money_month'];
			$model->repayment_opt = $_POST['Floor']['repayment_opt'];
			$model->repayment_reason = $_POST['Floor']['repayment_reason'];
			$model->repayment_amt = $_POST['Floor']['repayment_amt'];
			if(isset($_POST['Floor']['repayment_amt_opt']) && $_POST['Floor']['repayment_amt_opt'] != ''){
				$model->repayment_amt_opt = $_POST['Floor']['repayment_amt_opt'];
			}else{
				$model->repayment_amt_opt = '';
			}
			$model->floorId = 'JPF'.mt_rand(1000,999999);
			$model->renewal_fee_opt	 = $_POST['Floor']['renewal_fee_opt'];
			$model->renewal_fee_reason	 = $_POST['Floor']['renewal_fee_reason'];
			$model->renewal_fee_recent	 = $_POST['Floor']['renewal_fee_recent'];
			$model->repayment_notes	 = $_POST['Floor']['repayment_notes'];
			$model->notice_of_cancellation	 = $_POST['Floor']['notice_of_cancellation'];
			if(isset($_POST['Floor']['contract_period_opt']) && $_POST['Floor']['contract_period_opt'] != ''){
				$model->contract_period_opt	 = $_POST['Floor']['contract_period_opt'];
			}else{
				$model->contract_period_opt = '';
			}
			if(isset($_POST['Floor']['contract_period_optchk']) && $_POST['Floor']['contract_period_optchk'] != ''){
				$model->contract_period_optchk	 = 1;
			}
			$model->contract_period_duration	 = $_POST['Floor']['contract_period_duration'];
			$model->air_conditioning_facility_type	 = $_POST['Floor']['air_conditioning_facility_type'];
			$model->air_conditioning_details	 = $_POST['Floor']['air_conditioning_details'];
			if(isset($_POST['Floor']['air_conditioning_time_used']) && $_POST['Floor']['air_conditioning_time_used'] == 2){
				$model->air_conditioning_time_used	 = $_POST['Floor']['air_conditioning_time_used'].'-'.$_POST['Floor']['f_air_usetime_detail_week_start'].'~'.$_POST['Floor']['f_air_usetime_detail_week_finish'].'-'.$_POST['Floor']['f_air_usetime_detail_sat_start'].'~'.$_POST['Floor']['f_air_usetime_detail_sat_finish'].'-'.$_POST['Floor']['f_air_usetime_detail_sun_start'].'~'.$_POST['Floor']['f_air_usetime_detail_sun_finish'];
			}else{
				$model->air_conditioning_time_used	 = $_POST['Floor']['air_conditioning_time_used'];
			}
			$model->number_of_air_conditioning	 = $_POST['Floor']['number_of_air_conditioning'];
			$model->optical_cable	 = $_POST['Floor']['optical_cable'];
			$model->oa_type = $_POST['Floor']['oa_type'];
			$model->oa_height = $_POST['Floor']['oa_height'];
			$model->ceiling_height = $_POST['Floor']['ceiling_height'];
			$model->floor_material = $_POST['Floor']['floor_material'];
			$model->electric_capacity = $_POST['Floor']['electric_capacity'];
			$model->separate_toilet_by_gender = $_POST['Floor']['separate_toilet_by_gender'];
			if(isset($_POST['Floor']['toilet_location']) && $_POST['Floor']['toilet_location'] != ''){
				$model->toilet_location = $_POST['Floor']['toilet_location'];
			}else{
				$model->toilet_location = '';
			}
			if(isset($_POST['Floor']['washlet']) && $_POST['Floor']['washlet'] != ''){
				$model->washlet = $_POST['Floor']['washlet'];
			}else{
				$model->washlet = '';
			}
			if(isset($_POST['Floor']['toilet_cleaning']) && $_POST['Floor']['toilet_cleaning']!= ''){
				$model->toilet_cleaning = $_POST['Floor']['toilet_cleaning'];
			}else{
				$model->toilet_cleaning = '';
			}
			$model->notes = $_POST['Floor']['notes'];
			$model->floor_source_id = $_POST['Floor']['floor_source_id'];
			
			if(isset($_POST['Floor']['web_publishing'])){
				$model->web_publishing = $_POST['Floor']['web_publishing'];
				if($_POST['Floor']['web_publishing_note'] != ""){
					$model->web_publishing_note = $_POST['Floor']['web_publishing_note'];
				}
			}
			
			$model->update_person_in_charge = $_POST['Floor']['update_person_in_charge'];
			$model->property_confirmation_person = $_POST['Floor']['property_confirmation_person'];			

			$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
			$loguser_id = $user->user_id;
			$model->added_by = $loguser_id;
			$model->added_on = date('Y-m-d H:i:s');
			$model->modified_by = $loguser_id;
			$model->modified_on = date('Y-m-d H:i:s');			

			if($model->save(false)){
				$buildingDetails = Building::model()->findByPk($_POST['Floor']['buildingId']);
				$town = $buildingDetails->town;
				Yii::app()->closetown->calculateMarketCloseTown($town);
				
				$managementDetails = OwnershipManagement::model()->findAll('building_id = '.$_POST['Floor']['buildingId'].' AND floor_id = -1');
				foreach($managementDetails as $management){
					$management->floor_id = $model->floor_id;
					$management->save(false);
				}
				
				$TraderDetails = Traders::model()->findAll('building_id = '.$_POST['Floor']['buildingId'].' AND floor_id = -1');
				foreach($TraderDetails as $trader){
					$trader->floor_id = $model->floor_id;
					$trader->save(false);
				}
				
				$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
				$loguser_id = $users->user_id;					
				$buildingDetails = Building::model()->findByPk($_POST['Floor']['buildingId']);	

				$changeLogModel = new BuildingUpdateLog;
				$changeLogModel->building_id = $_POST['Floor']['buildingId'];
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
					
							
					// BEGIN - Create wordpress building reference
					$params['building_id'] = $model->building_id;
					$wordpress = new Wordpress();
					$wordpress->processIntergrateWordpress($model->floor_id, Wordpress::FLOOR_TYPE, 'create', $params);
					$wordpress->reGenerateLocations();
					// End - processing with wordpress
					
					
					//$this->redirect(array('view','id'=>$model->floor_id));
					$this->redirect(array('building/singleBuilding','id'=>$model->floor_id));
					die;
				}
			}
		}	

		$this->pageTitle = Yii::app()->controller->__trans('Add Floor').' | '.Yii::app()->params['name'];
		$this->render('create',array('model'=>$model,'useTypesDetails'=>$useTypesDetails,'floorSourceDetails'=>$floorSourceDetails,'userList'=>$userList));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id){
		$model=$this->loadModel($id);
		$tradersDetails = Traders::model()->findAll('is_active = 1');
		$useTypesDetails = UseTypes::model()->findAll('is_active = 1');
		$floorSourceDetails = FloorSourceFromType::model()->findAll('is_active = 1');
		$userList = Users::model()->findAll('is_active = 1 AND user_role = "a"');
		$updateHistory = FloorUpdateHistory::model()->findAll('floor_id = '.$id.' ORDER BY floor_update_history_id DESC');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$getFlooOldDetails = Floor::model()->findByPk($id);
		if(isset($_POST['Floor'])){		

			if(isset($_GET['type']) && $_GET['type'] == 'duplicate' && $_GET['type'] != ""){
				$model = new Floor;
				$model->floorId = 'JPF'.mt_rand(1000,999999);
			}else{
				$model=$this->loadModel($id);
			}
			
			$oldRentPrice = $model->rent_unit_price;
			$newRentPrice = $_POST['Floor']['rent_unit_price'];
			
			if(isset($_POST['Floor']['buildingId']) && $_POST['Floor']['buildingId'] != ''){
				$model->building_id = $_POST['Floor']['buildingId'];
			}else{
				$model->building_id = '';
			}
			$model->vacancy_info = $_POST['Floor']['vac_info'];
			$model->preceding_user = $_POST['Floor']['pre_user'];
			$model->preceding_details = $_POST['Floor']['pre_details'];
			$model->preceding_check_datetime = $_POST['Floor']['pre_check_datetime'];
			$model->move_in_date = $_POST['Floor']['move_date'];
			$model->vacant_schedule = $_POST['Floor']['vac_sche'];
			$model->floor_down = $_POST['Floor']['floor_down'];
			$model->floor_up = $_POST['Floor']['floor_up'];
			$model->roomname = $_POST['Floor']['roomname'];
			if(isset($_POST['Floor']['maisonette_type']) && $_POST['Floor']['maisonette_type'] != ''){
				$model->maisonette_type = $_POST['Floor']['maisonette_type'];
			}else{
				$model->maisonette_type = '';
			}
			$model->short_term_rent = $_POST['Floor']['short_term_rent'];
			if(isset($_POST['Floor']['type_of_use']) && $_POST['Floor']['type_of_use'] != ''){
				$model->type_of_use = implode(',',$_POST['Floor']['type_of_use']);
			}
			$model->area_ping = $_POST['Floor']['area_ping'];
			$model->area_m = $_POST['Floor']['area_m'];
			$model->area_net = $_POST['Floor']['area_net'];
			if(isset($_POST['Floor']['calculation_method']) && $_POST['Floor']['calculation_method'] != ''){
				$model->calculation_method = $_POST['Floor']['calculation_method'];
			}else{
				$model->calculation_method = '';
			}
			if(isset($_POST['Floor']['payment_by_installments']) && $_POST['Floor']['payment_by_installments'] != ''){
				$model->payment_by_installments = $_POST['Floor']['payment_by_installments'];
			}else{
				$model->payment_by_installments = '';
			}
			
			$model->core_section = isset($_POST['Floor']['core_section']) ? (int)$_POST['Floor']['core_section'] : 0;
			$model->high_grade_building = isset($_POST['Floor']['high_grade_building']) ? (int)$_POST['Floor']['high_grade_building'] : 0;
			
			$model->payment_by_installments_note = $_POST['Floor']['payment_by_installments_detail'];
			if(isset($_POST['Floor']['floor_partition']) && $_POST['Floor']['floor_partition'] != ''){
				$model->floor_partition = implode(',',$_POST['Floor']['floor_partition']);
			}else{
				$model->floor_partition = '';
			}
			$model->rent_unit_price_opt = (int)$_POST['Floor']['rent_unit_price_opt'];
			$model->rent_unit_price = $_POST['Floor']['rent_unit_price'];
			$model->total_rent_price = $_POST['Floor']['total_rent_price'];
			$model->unit_condo_fee_opt = (int)$_POST['Floor']['unit_condo_fee_opt'];
			$model->unit_condo_fee = $_POST['Floor']['unit_condo_fee'];
			$model->total_condo_fee = $_POST['Floor']['total_condo_fee'];
			$model->deposit_opt = $_POST['Floor']['deposit_opt'];
			$model->deposit_month = $_POST['Floor']['deposit_month'];
			$model->deposit = $_POST['Floor']['deposit'];
			$model->total_deposit = $_POST['Floor']['total_deposit'];
			$model->key_money_opt = $_POST['Floor']['key_money_opt'];
			$model->key_money_month = $_POST['Floor']['key_money_month'];
			$model->repayment_opt = (int)$_POST['Floor']['repayment_opt'];
			$model->repayment_reason = $_POST['Floor']['repayment_reason'];
			$model->repayment_amt = $_POST['Floor']['repayment_amt'];
			if(isset($_POST['Floor']['repayment_amt_opt']) && $_POST['Floor']['repayment_amt_opt'] != ''){
				$model->repayment_amt_opt = $_POST['Floor']['repayment_amt_opt'];
			}else{
				$model->repayment_amt_opt = '';
			}
			$model->renewal_fee_opt	 = (int)$_POST['Floor']['renewal_fee_opt'];
			$model->renewal_fee_reason	 = $_POST['Floor']['renewal_fee_reason'];
			$model->renewal_fee_recent	 = $_POST['Floor']['renewal_fee_recent'];
			$model->repayment_notes	 = $_POST['Floor']['repayment_notes'];
			$model->notice_of_cancellation	 = $_POST['Floor']['notice_of_cancellation'];
			if(isset($_POST['Floor']['contract_period_opt']) && $_POST['Floor']['contract_period_opt'] != ''){
				$model->contract_period_opt	 = $_POST['Floor']['contract_period_opt'];
			}else{
				$model->contract_period_opt = '';
			}
			if(isset($_POST['Floor']['contract_period_optchk']) && $_POST['Floor']['contract_period_optchk'] != ''){
				$model->contract_period_optchk	 = 1;
			}
			$model->contract_period_duration	 = $_POST['Floor']['contract_period_duration'];
			$model->air_conditioning_facility_type	 = $_POST['Floor']['air_conditioning_facility_type'];
			$model->air_conditioning_details	 = $_POST['Floor']['air_conditioning_details'];			

			if(isset($_POST['Floor']['air_conditioning_time_used']) && $_POST['Floor']['air_conditioning_time_used'] == 2){
				$model->air_conditioning_time_used	 = $_POST['Floor']['air_conditioning_time_used'].'-'.$_POST['Floor']['f_air_usetime_detail_week_start'].'~'.$_POST['Floor']['f_air_usetime_detail_week_finish'].'-'.$_POST['Floor']['f_air_usetime_detail_sat_start'].'~'.$_POST['Floor']['f_air_usetime_detail_sat_finish'].'-'.$_POST['Floor']['f_air_usetime_detail_sun_start'].'~'.$_POST['Floor']['f_air_usetime_detail_sun_finish'];
			}else{
				$model->air_conditioning_time_used	 = $_POST['Floor']['air_conditioning_time_used'];
			}
			$model->number_of_air_conditioning	 = $_POST['Floor']['number_of_air_conditioning'];
			$model->optical_cable	 = (int)$_POST['Floor']['optical_cable'];
			$model->oa_type = $_POST['Floor']['oa_type'];
			$model->oa_height = $_POST['Floor']['oa_height'];
			$model->ceiling_height = $_POST['Floor']['ceiling_height'];
			$model->floor_material = $_POST['Floor']['floor_material'];
			$model->electric_capacity = $_POST['Floor']['electric_capacity'];
			$model->separate_toilet_by_gender = $_POST['Floor']['separate_toilet_by_gender'];
			if(isset($_POST['Floor']['toilet_location']) && $_POST['Floor']['toilet_location'] != ''){
				$model->toilet_location = $_POST['Floor']['toilet_location'];
			}else{
				$model->toilet_location = '';
			}
			if(isset($_POST['Floor']['washlet']) && $_POST['Floor']['washlet'] != ''){
				$model->washlet = $_POST['Floor']['washlet'];
			}else{
				$model->washlet = '';
			}
			if(isset($_POST['Floor']['toilet_cleaning']) && $_POST['Floor']['toilet_cleaning']!= ''){
				$model->toilet_cleaning = $_POST['Floor']['toilet_cleaning'];
			}else{
				$model->toilet_cleaning = '';
			}
			$model->notes = $_POST['Floor']['notes'];
			if(isset($_POST['Floor']['floor_source_id']) && $_POST['Floor']['floor_source_id'] != ''){
				$model->floor_source_id = $_POST['Floor']['floor_source_id'];
			}
			
			if(isset($_POST['Floor']['web_publishing'])){
				$model->web_publishing = $_POST['Floor']['web_publishing'];
				if($_POST['Floor']['web_publishing_note'] != ""){
					$model->web_publishing_note = $_POST['Floor']['web_publishing_note'];
				}
			}
			
			$model->update_person_in_charge = $_POST['Floor']['update_person_in_charge'];
			$model->property_confirmation_person = $_POST['Floor']['property_confirmation_person'];

			$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
			$loguser_id = $user->user_id;
			$model->modified_by = $loguser_id;
			$model->modified_on = date('Y-m-d H:i:s');
// 			print_r($model);
// 			exit;
			if($model->save(false)){
				
				// BEGIN - Create wordpress building reference
				$params['building_id'] = $model->building_id;
				$wordpress = new Wordpress();
				$wordpress->processIntergrateWordpress($model->floor_id, Wordpress::FLOOR_TYPE, 'update', $params);
				$wordpress->reGenerateLocations();
				// End - processing with wordpress
				
				$buildingDetails = Building::model()->findByPk($_POST['Floor']['buildingId']);
				$town = $buildingDetails->town;
				Yii::app()->closetown->calculateMarketCloseTown($town);
				
				$updateHistory = new FloorUpdateHistory();
				$updateHistory->floor_id = $model->floor_id;
				$updateHistory->building_id = $_POST['Floor']['buildingId'];
				$updateHistory->vacancy_info = $_POST['Floor']['vac_info'];
				$updateHistory->rent_unit_price = $_POST['Floor']['rent_unit_price'];
				$updateHistory->rent_unit_price_opt = (int)$_POST['Floor']['rent_unit_price_opt'];
				$updateHistory->unit_condo_fee = $_POST['Floor']['unit_condo_fee'];
				$updateHistory->unit_condo_fee_opt = (int)$_POST['Floor']['unit_condo_fee_opt'];
				$updateHistory->deposit_month = $_POST['Floor']['deposit_month'];
				$updateHistory->key_money_opt = $_POST['Floor']['key_money_opt'];
				$updateHistory->key_money_month = $_POST['Floor']['key_money_month'];
				$updateHistory->deposit = $_POST['Floor']['deposit'];
				$updateHistory->deposit_opt = $_POST['Floor']['deposit_opt'];

				if(isset($_POST['Floor']['floor_source_id']) && $_POST['Floor']['floor_source_id'] != ''){
					$updateHistory->floor_source_id = $_POST['Floor']['floor_source_id'];
				}
				$updateHistory->confirmation = '';
				$updateHistory->update_person_in_charge = $_POST['Floor']['update_person_in_charge'];
				$updateHistory->property_confirmation_person = $_POST['Floor']['property_confirmation_person'];
				$updateHistory->modified_on = date('Y-m-d H:i:s');
				$updateHistory->price_rise = 0;
				if($oldRentPrice != $newRentPrice){
					$priceDifference = $newRentPrice - $oldRentPrice;
					if($priceDifference > 0){
						$updateHistory->price_rise = 1;
					}else{
						$updateHistory->price_rise = 0;
					}
				}
				$getAvailableFloor = Floor::model()->findAll('building_id = '.$_POST['Floor']['buildingId'].' AND vacancy_info = 1');	
				$updateHistory->available_floor = count($getAvailableFloor);
				
				$getFloorForRent = Floor::model()->findAll('building_id = '.$_POST['Floor']['buildingId'].' AND rent_unit_price_opt = 0');
				$totalRentSum = 0;
				$finalRentAvg = 0;
				if(count($getFloorForRent) > 0 && !empty($getFloorForRent)){
					foreach($getFloorForRent as $fLoop){
						$totalRentSum += $fLoop['rent_unit_price'];
					}
					$finalRentAvg = $totalRentSum/count($getFloorForRent);
				}
				$updateHistory->current_average_rent = $finalRentAvg;
				
				$oldPrecedingUser = $getFlooOldDetails->preceding_user;
				$updateHistory->what_to_check = '';
				if($_POST['Floor']['pre_user'] != $oldPrecedingUser){
					$updateHistory->what_to_check = '先行有りの解除/先行有り';
				}
						
				if($updateHistory->save(false)){
					$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
					$loguser_id = $users->user_id;
					
					$buildingDetails = Building::model()->findByPk($model->building_id);

					$changeLogModel = new BuildingUpdateLog;
					$changeLogModel->building_id = $_POST['Floor']['buildingId'];
					if(isset($_GET['type']) && $_GET['type'] == 'duplicate' && $_GET['type'] != ""){
						$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl("building/singleBuilding",array("id"=>$model->floor_id)).'">'.Yii::app()->controller->__trans('New floor').' ID:'.$id.' ('.$buildingDetails['prefecture'].')</a>'.Yii::app()->controller->__trans('has been added');
					}else{
						$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl("building/singleBuilding",array("id"=>$model->floor_id)).'">'.Yii::app()->controller->__trans('Floor info').' ID:'.$id.' ('.$buildingDetails['prefecture'].')</a>'.Yii::app()->controller->__trans('has been updated');
					}
					$changeLogModel->added_by = $loguser_id;
					$changeLogModel->added_on = date('Y-m-d H:i:s');
					if($changeLogModel->save(false)){
						
						//check for office alert
						$cFloorId = $id;
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
						if(isset($_GET['window']) && $_GET['window'] == 1){
							//Yii::app()->user->setFlash('success', "フロア情報の更新が完了しました");
							$this->redirect(array('floor/update','id'=>$model->floor_id,'msg'=>1));
						}elseif(isset($_GET['msg']) && $_GET['msg'] == 1){
							$this->redirect(array('floor/update','id'=>$model->floor_id,'msg'=>1));
						}else{
							$this->redirect(array('building/singleBuilding','id'=>$model->floor_id));
						}
						die;
					}
				}
			}
		}
		$this->renderPartial('update',array('model'=>$model,'tradersDetails'=>$tradersDetails,'useTypesDetails'=>$useTypesDetails,'floorSourceDetails'=>$floorSourceDetails,'userList'=>$userList,'updateHistory'=>$updateHistory));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id){
		$floor = $this->loadModel($id);
		$building_id = $floor->building_id;
		
		// BEGIN - Create wordpress building reference
		$params['building_id'] = $building_id;
		$wordpress = new Wordpress();
		$wordpress->processIntergrateWordpress($id, Wordpress::FLOOR_TYPE, 'delete', $params);
		$wordpress->reGenerateLocations();
		// End - processing with wordpress
		
		// Delete images
		$floor->deleteFloorImages($id);
		
		// Delete floor
		$floor->delete();
		
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex(){
		$dataProvider=new CActiveDataProvider('Floor');
		$this->render('index',array('dataProvider'=>$dataProvider,));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin(){
		$model=new Floor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Floor']))
			$model->attributes=$_GET['Floor'];
			$this->render('admin',array('model'=>$model,));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Floor the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id){
		$model=Floor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Floor $model the model to be validated
	 */
	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']==='floor-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}	

	public function actionGetSearchedTraderList(){
		$query = $_POST['query'];
		$buildingId = $_POST['bId'];
		$floorId = $_POST['fId'];
		
		$searchQuery = 'select * from traders where building_id = '.$buildingId.' AND floor_id IN ('.$floorId.') AND (company_tel LIKE "%'.$query.'%" OR trader_name LIKE "%'.$query.'%")';		
		$traderList = $command = Yii::app()->db->createCommand($searchQuery)->queryAll();
		
		/*echo "<pre>";
		print_r($traderList);
		die;*/
		/*$traderDetails = OwnershipManagement::model()->findAll(array('condition'=>'company_tel LIKE :match','params'=>array(':match'=> '%'.$query.'%')));
		$tids = array();
		foreach($traderDetails as $tr){
			$tids[] = $tr->trader_id;
		}		
		
		$tradersList = Traders::model()->findAll(array('condition'=>'`trader_id` in ('.implode(',',$tids).')'));*/
		if(count($traderList) > 0){
			$resp = '<select name="Floor[trader_id]" id="tradersList" class="tradersList auto"><option value="0">業者を選択</option>';
			foreach($traderList as $tList){
				$resp .= '<option value="'.$tList['trader_id'].'">'.$tList['traderId'].' : '.$tList['trader_name'].'</option>';
			}
			$resp .=  '</select>';
		}else{
			$resp = '<select name="Floor[trader_id]" id="tradersList" class="auto tradersList">
			<option value="">No Traders Available</option></select>';
		}
		echo json_encode($resp);
		exit;
	}
	
	public function actionGetSeletectedTraderDetails(){
		$traderId = $_REQUEST['trader'];
		//$traderDetails = OwnershipManagement::model()->find('trader_id = '.$traderId);
		$traderDetails = Traders::model()->findByPk($traderId);
		//echo "<pre>";
		//print_r($traderDetails);
		if($traderId != "" && $traderId != 0){
			if(isset($traderDetails) && count($traderDetails)>0 && !empty($traderDetails)){
				$resp = array('ownership_type'=>$traderDetails['ownership_type'],'management_type'=>$traderDetails['management_type'],'owner_company_name'=>$traderDetails['owner_company_name'],'company_tel'=>$traderDetails['company_tel'],'person_in_charge1'=>$traderDetails['person_in_charge1'],'person_in_charge2'=>$traderDetails['person_in_charge2'],'charge'=>$traderDetails['charge']);
				//print_r($resp);
			}else{
				$resp = array('ownership_type'=>'','management_type'=>'','owner_company_name'=>'','company_tel'=>'','person_in_charge1'=>'','person_in_charge2'=>'','charge'=>'');
			}
		}else{
			$resp = array('ownership_type'=>'','management_type'=>'','owner_company_name'=>'','company_tel'=>'','person_in_charge1'=>'','person_in_charge2'=>'','charge'=>'');
		}
		echo json_encode($resp);
		die;
	}

	public function actionAddFloorToCart(){
		$floorId = $_POST['floorId'];
		$buildingId = $_POST['buildingId'];		
		$searchData = $_POST['searchData'];
		$searchCriteria = $_POST['searchCriteria'];

		$cartModel = new Cart();
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $user->user_id;
		$cartModel->floor_id = $floorId;
		$cartModel->building_id = $buildingId;
		$cartModel->user_id = $loguser_id;
		$cartModel->search_condition = $searchCriteria;
		
		if($cartModel->save(false)){
			$cartDetails = Cart::model()->findAll('user_id = '.$loguser_id);
			$itemCount = " (".count($cartDetails).")";
			$i = 0;
			foreach($cartDetails as $cartList){
				$floorDetails = Floor::model()->findByPk($cartList['floor_id']);
				$buildingDetails = Building::model()->findByPk($cartList['building_id']);
				$buildingPictureDetails = BuildingPictures::model()->find("building_id = ".$cartList['building_id']);
				if(isset($buildingPictureDetails['front_images']) && $buildingPictureDetails['front_images'] != ""){
					$picture = explode(",",$buildingPictureDetails['front_images']);
					$picture = reset($picture);
					$pic = $images_path = Yii::app()->baseUrl . '/buildingPictures/front'.'/'.$picture;
				}else{
					$pic = $images_path = Yii::app()->baseUrl . '/images/noimg.jpg';
				}
				if($i == 0){
					$resp = "<div class='min-white-box'>";
					$resp .= "<input type='hidden' name='cartId' class='cartId' id='cartId' value='".$cartList['cart_id']."'/>";
					$resp .= "<div class='btnRemoveFromCart'><i class='fa fa-times'></i></div>";
					$resp .= "<img src='".$pic."' class='head-img'/>";
					$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name'];
					
					if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
						if(strpos($floorDetails['floor_down'], '-') !== false){
							$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
						}else{
							$floorDown = $floorDetails['floor_down'];
						}
						if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
							$resp .= $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
						}else{
							$resp .= $floorDown.' '.Yii::app()->controller->__trans('階');
						}
						if($floorDetails['roomname'] != ""){
							$resp .= "( ".$floorDetails['roomname']." )";
						}
					}
					$resp .= "<span class='building-text-brk'>";
					if($floorDetails['area_ping'] != ""){
						$resp .= $floorDetails['area_ping'].' 坪 &nbsp;';
					}else{
						$resp .= '-坪 &nbsp;';
					}
					
					if($floorDetails['rent_unit_price'] == "" && $floorDetails['rent_unit_price_opt'] == 0){
						$resp .= '未定/相談';
					}else{
// 						if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != ""){
// 							$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
// 						}else
						{
							if($floorDetails['rent_unit_price_opt'] != ''){
								if($floorDetails['rent_unit_price_opt'] == -1){
									$resp .= Yii::app()->controller->__trans('undecided');
								}else if($floorDetails['rent_unit_price_opt'] == -2){
									$resp .= Yii::app()->controller->__trans('ask');
								}else {
									$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
								}
							}else{
								$resp .= '-';
							}
						}
					}					
					$resp .= "</span></span></a>";
					$resp .= "</div>";
				}else{
					$resp .= "<div class='min-white-box'>";
					$resp .= "<input type='hidden' name='cartId' class='cartId' id='cartId' value='".$cartList['cart_id']."'/>";
					$resp .= "<div class='btnRemoveFromCart'><i class='fa fa-times'></i></div>";
					$resp .= "<img src='".$pic."' class='head-img'/>";
					$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name'];
					
					if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
						if(strpos($floorDetails['floor_down'], '-') !== false){
							$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
						}else{
							$floorDown = $floorDetails['floor_down'];
						}
						if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
							$resp .= $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
						}else{
							$resp .= $floorDown.' '.Yii::app()->controller->__trans('階');
						}
						if($floorDetails['roomname'] != ""){
							$resp .= "( ".$floorDetails['roomname']." )";
						}
					}
					$resp .= "<span class='building-text-brk'>";
					if($floorDetails['area_ping'] != ""){
						$resp .= $floorDetails['area_ping'].' 坪 &nbsp;';
					}else{
						$resp .= '-坪 &nbsp;';
					}
					
					if($floorDetails['rent_unit_price'] == "" && $floorDetails['rent_unit_price_opt'] == 0){
						$resp .= '未定/相談';
					}else{
// 						if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != ""){
// 							$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
// 						}else
						{
							if($floorDetails['rent_unit_price_opt'] != ''){
								if($floorDetails['rent_unit_price_opt'] == -1){
									$resp .= Yii::app()->controller->__trans('undecided');
								}else if($floorDetails['rent_unit_price_opt'] == -2){
									$resp .= Yii::app()->controller->__trans('ask');
								}else {
									$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
								}
							}else{
								$resp .= '-';
							}
						}
					}					
					$resp .= "</span></span></a>";
					$resp .= "</div>";
				}
				$i++;
			}
			$result = array('count'=>$itemCount,'respData'=>$resp);
			echo json_encode($result);
			die;
		}
	}	
	
	public function actionSortCart(){
		if(isset($_POST['data']) && is_array($_POST['data'])){
			$sortIDs = array();
			foreach($_POST['data'] as $item){
				$itemid = str_replace('cart_','',$item);
				$sortIDs[] = $itemid;
			}
			$i = 0;
			sort($sortIDs);
			foreach($_POST['data'] as $item){
				$itemid = str_replace('cart_','',$item);
				$cartModel = Cart::model()->findByPk($itemid);
				$temp = $cartModel->attributes;
		
				$cartModel->order = (int)$sortIDs[$i];
				if($cartModel->save(false)){
				}
				$i++;
			}
		}
	}
	
	public function actionAddAllFromToCart(){
		$floorIds = $_REQUEST['floorId'];
		$buildingId = $_REQUEST['buildingId'];
		$allBuildId = explode(',',$buildingId);
		$searchcrietaria = $_REQUEST['searchcrietaria'];
		$allFloorId = explode(',',$floorIds);
		
		foreach($allFloorId as $floor){
			if($floor == '') continue;
			$cartModel = new Cart();
			$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
			$loguser_id = $user->user_id;
			$checkAvailable = Cart::model()->find('floor_id = '.$floor.' AND user_id = '.$loguser_id);
			if(count($checkAvailable) > 0){
				continue;
			}else{
				$floorDetails = Floor::model()->findByPk($floor);
				if(in_array($floorDetails['building_id'],$allBuildId)){
					$buildingId = $floorDetails['building_id'];
				}
				$cartModel->floor_id = $floor;
				$cartModel->building_id = $buildingId;
				$cartModel->user_id = $loguser_id;
				$cartModel->search_condition = $searchcrietaria;
				$cartModel->save(false);
			}
		}	

		$cartDetails = Cart::model()->findAll('user_id = '.$loguser_id);
		$itemCount = " (".count($cartDetails).")";
		$i = 0;
		foreach($cartDetails as $cartList){
			$floorDetails = Floor::model()->findByPk($cartList['floor_id']);
			$buildingDetails = Building::model()->findByPk($cartList['building_id']);
			$buildingPictureDetails = BuildingPictures::model()->find("building_id = ".$cartList['building_id']);
			if(isset($buildingPictureDetails['front_images']) && $buildingPictureDetails['front_images'] != ""){
				$picture = explode(",",$buildingPictureDetails['front_images']);
				$picture = reset($picture);
				$pic = $images_path = Yii::app()->baseUrl . '/buildingPictures/front'.'/'.$picture;
			}else{
				$pic = $images_path = Yii::app()->baseUrl . '/images/noimg.jpg';
			}
			if($i == 0){
				$resp = "<div class='min-white-box'>";
				$resp .= "<input type='hidden' name='cartId' class='cartId' id='cartId' value='".$cartList['cart_id']."'/>";
				$resp .= "<div class='btnRemoveFromCart'><i class='fa fa-times'></i></div>";
				$resp .= "<img src='".$pic."' class='head-img'/>";
				$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name'];
				
				if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
					if(strpos($floorDetails['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
					}else{
						$floorDown = $floorDetails['floor_down'];
					}
					if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
						$resp .= $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
					}else{
						$resp .= $floorDown.' '.Yii::app()->controller->__trans('階');
					}
					if($floorDetails['roomname'] != ""){
						$resp .= "( ".$floorDetails['roomname']." )";
					}
				}
				$resp .= "<span class='building-text-brk'>";
				if($floorDetails['area_ping'] != ""){
					$resp .= $floorDetails['area_ping'].' 坪 &nbsp;';
				}else{
					$resp .= '-坪 &nbsp;';
				}
				
				if($floorDetails['rent_unit_price'] == "" && $floorDetails['rent_unit_price_opt'] == 0){
					$resp .= '未定/相談';
				}else{
					if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != ""){
						$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
					}else{
						if($floorDetails['rent_unit_price_opt'] != ''){
							if($floorDetails['rent_unit_price_opt'] == -1){
								$resp .= Yii::app()->controller->__trans('undecided');
							}else if($floorDetails['rent_unit_price_opt'] == -2){
								$resp .= Yii::app()->controller->__trans('ask');
							}
						}else{
							$resp .= '-';
						}
					}
				}					
				$resp .= "</span></span></a>";
				$resp .= "</div>";
			}else{
				$resp .= "<div class='min-white-box'>";
				$resp .= "<input type='hidden' name='cartId' class='cartId' id='cartId' value='".$cartList['cart_id']."'/>";
				$resp .= "<div class='btnRemoveFromCart'><i class='fa fa-times'></i></div>";
				$resp .= "<img src='".$pic."' class='head-img'/>";
				$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name'];
				
				if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
					if(strpos($floorDetails['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
					}else{
						$floorDown = $floorDetails['floor_down'];
					}
					if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
						$resp .= $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
					}else{
						$resp .= $floorDown.' '.Yii::app()->controller->__trans('階');
					}
					if($floorDetails['roomname'] != ""){
						$resp .= "( ".$floorDetails['roomname']." )";
					}
				}
				$resp .= "<span class='building-text-brk'>";
				if($floorDetails['area_ping'] != ""){
					$resp .= $floorDetails['area_ping'].' 坪 &nbsp;';
				}else{
					$resp .= '-坪 &nbsp;';
				}
				
				if($floorDetails['rent_unit_price'] == "" && $floorDetails['rent_unit_price_opt'] == 0){
					$resp .= '未定/相談';
				}else{
					if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != ""){
						$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
					}else{
						if($floorDetails['rent_unit_price_opt'] != ''){
							if($floorDetails['rent_unit_price_opt'] == -1){
								$resp .= Yii::app()->controller->__trans('undecided');
							}else if($floorDetails['rent_unit_price_opt'] == -2){
								$resp .= Yii::app()->controller->__trans('ask');
							}
						}else{
							$resp .= '-';
						}
					}
				}					
				$resp .= "</span></span></a>";
				$resp .= "</div>";
			}
			$i++;
		}
		$result = array('count'=>$itemCount,'respData'=>$resp);
		echo json_encode($result);
		die;
	}	

	public function actionAddProposedToCart(){
	
		$requestData = $_REQUEST;
		
		if(!isset($_REQUEST['printCart'])) {
			$propsedArticleId = $_REQUEST['hdnProArticleId'];
			$buildingDetails = ProposedArticle::model()->findByPk($propsedArticleId);
		    $buildingId = $buildingDetails['building_id'];
			$allBuildId = explode(',',$buildingId);
			
			$floorIds = $buildingDetails['floor_id'];
			$allFloorIds = array();
			$fIds = explode(',',$floorIds);
			foreach($fIds as $fId){
				$fDetails = Floor::model()->findBypk($fId);
				if(count($fDetails) > 0){
					$allFloorIds[] = $fId;
				}
			}
			foreach($allBuildId as $id){
				$bDetails = Building::model()->findByPk($id);
				if(count($bDetails) > 0){
					$buildCartDetails[] = $bDetails;
				}
			}
		} else {			
			$user = Users::model()->findByAttributes(array('username'=>$_REQUEST['user']));
			$logged_user_id = $user->user_id;
			$cartDetails = Cart::model()->findAllByAttributes(array('user_id'=>$logged_user_id),array('order'=>'`order`'));
			
			$buildCartDetails = array();
			foreach($cartDetails as $cart){
				$bDetails = Building::model()->findByPk($cart['building_id']);
				if(count($bDetails) > 0){
					$buildCartDetails[] = $bDetails;
				}
				
				$fId = $cart['floor_id'];
				$fDetails = Floor::model()->findBypk($fId);
				if(count($fDetails) > 0){
					$allFloorIds[] = $fId;
				} 
			}
			$buildCartDetails = array_unique($buildCartDetails,SORT_REGULAR);
			$allFloorIds = array_unique($allFloorIds,SORT_REGULAR);
		}
		
		$this->renderPartial('printDetails',array('buildCartDetails'=>$buildCartDetails,'requestData'=> $requestData,'proposedFloors'=>$allFloorIds));
	}	

	public function actionAddSingleBuildToCart(){
		$singleBuildId = $_REQUEST['buildId'];
		$singleFloorId = $_REQUEST['floorId'];
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $user->user_id;
		$checkAvailable = Cart::model()->find('building_id = '.$singleBuildId.' AND floor_id = '.$singleFloorId.' And user_id = '.$loguser_id);
		if(count($checkAvailable) == 0){
			$cartModel = new Cart();
			$cartModel->floor_id = $singleFloorId;
			$cartModel->building_id = $singleBuildId;
			$cartModel->user_id = $loguser_id;
			$cartModel->save(false);
		}
		$cartDetails = Cart::model()->findAll('user_id = '.$loguser_id);
		$itemCount = " (".count($cartDetails).")";
		$i = 0;
		$resp = '';
		foreach($cartDetails as $cartList){
			$floorDetails = Floor::model()->findByPk($cartList['floor_id']);
			$buildingDetails = Building::model()->findByPk($cartList['building_id']);
			$buildingPictureDetails = BuildingPictures::model()->find("building_id = ".$cartList['building_id']);
			if(isset($buildingPictureDetails['front_images']) && $buildingPictureDetails['front_images'] != ""){
				$picture = explode(",",$buildingPictureDetails['front_images']);
				$picture = reset($picture);
				$pic = $images_path = Yii::app()->baseUrl . '/buildingPictures/front'.'/'.$picture;
			}else{
				$pic = $images_path = Yii::app()->baseUrl . '/images/default.png';
			}
			if($i == 0){
				$resp = "<div class='min-white-box'>";
				$resp .= "<input type='hidden' name='cartId' class='cartId' id='cartId' value='".$cartList['cart_id']."'/>";
				$resp .= "<div class='btnRemoveFromCart'><i class='fa fa-times'></i></div>";
				$resp .= "<img src='".$pic."' class='head-img'/>";
				$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name'];
				
				if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
					if(strpos($floorDetails['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
					}else{
						$floorDown = $floorDetails['floor_down'];
					}
					if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
						$resp .= $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
					}else{
						$resp .= $floorDown.' '.Yii::app()->controller->__trans('階');
					}
					if($floorDetails['roomname'] != ""){
						$resp .= "( ".$floorDetails['roomname']." )";
					}
				}
				$resp .= "<span class='building-text-brk'>";
				if($floorDetails['area_ping'] != ""){
					$resp .= $floorDetails['area_ping'].' 坪 &nbsp;';
				}else{
					$resp .= '-坪 &nbsp;';
				}
				
				if($floorDetails['rent_unit_price'] == "" && $floorDetails['rent_unit_price_opt'] == 0){
					$resp .= '未定/相談';
				}else{
					if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != ""){
						$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
					}else{
						if($floorDetails['rent_unit_price_opt'] != ''){
							if($floorDetails['rent_unit_price_opt'] == -1){
								$resp .= Yii::app()->controller->__trans('undecided');
							}else if($floorDetails['rent_unit_price_opt'] == -2){
								$resp .= Yii::app()->controller->__trans('ask');
							}
						}else{
							$resp .= '-';
						}
					}
				}					
				$resp .= "</span></span></a>";
				$resp .= "</div>";
			}else{
				$resp .= "<div class='min-white-box'>";
				$resp .= "<input type='hidden' name='cartId' class='cartId' id='cartId' value='".$cartList['cart_id']."'/>";
				$resp .= "<div class='btnRemoveFromCart'><i class='fa fa-times'></i></div>";
				$resp .= "<img src='".$pic."' class='head-img'/>";
				$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name'];
				
				if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
					if(strpos($floorDetails['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
					}else{
						$floorDown = $floorDetails['floor_down'];
					}
					if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
						$resp .= $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
					}else{
						$resp .= $floorDown.' '.Yii::app()->controller->__trans('階');
					}
					if($floorDetails['roomname'] != ""){
						$resp .= "( ".$floorDetails['roomname']." )";
					}
				}
				$resp .= "<span class='building-text-brk'>";
				if($floorDetails['area_ping'] != ""){
					$resp .= $floorDetails['area_ping'].' 坪 &nbsp;';
				}else{
					$resp .= '-坪 &nbsp;';
				}
				
				if($floorDetails['rent_unit_price'] == "" && $floorDetails['rent_unit_price_opt'] == 0){
					$resp .= '未定/相談';
				}else{
					if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != ""){
						$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
					}else{
						if($floorDetails['rent_unit_price_opt'] != ''){
							if($floorDetails['rent_unit_price_opt'] == -1){
								$resp .= Yii::app()->controller->__trans('undecided');
							}else if($floorDetails['rent_unit_price_opt'] == -2){
								$resp .= Yii::app()->controller->__trans('ask');
							}
						}else{
							$resp .= '-';
						}
					}
				}					
				$resp .= "</span></span></a>";
				$resp .= "</div>";
			}
			$i++;
		}
		$result = array('count'=>$itemCount,'respData'=>$resp,'status'=>1);
		echo json_encode($result);
		die;
	}

	public function actionRemoveAllItemCart(){
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $user->user_id;
		$cartDetails = Cart::model()->deleteAll('user_id = '.$loguser_id);
		if(count($cartDetails) == 0){
			$result = array('status'=>1);
		}
	}	

	public function actionRemoveFloorFromCart(){
		$cartId = $_POST['cartId'];
		$cartDetails = Cart::model()->findByPk($cartId);
		if(isset($cartDetails) && count($cartDetails)){
			$cartDetails = Cart::model()->deleteAll('cart_id = '.$cartId);
		}
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $user->user_id;
		$cartDetails = Cart::model()->findAll('user_id = '.$loguser_id);
		$itemCount = " (".count($cartDetails).")";
		$result = array('count'=>$itemCount);	

		echo json_encode($result);
		die;
	}	

	public function actionAppendNewManagementHistory(){
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
			
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata, $getArray);
		$getManagementAvailable = OwnershipManagement::model()->find('building_id = '.$getArray['hdnBillId'].' and floor_id = "'.$getArray['hdnHistFloorId'].'" AND (is_compart = 1 OR is_shared = 1) ORDER BY ownership_management_id DESC');
		/*if(count($getManagementAvailable) > 0){
			$resp = array('status'=>2);
			echo json_encode($resp);
			die;
		}*/
		
		$aVendorType = Yii::app()->controller->getBuildingVendorType();	
		
		if($getArray['trader_id'] != 0 && $getArray['trader_id'] != ""){
			
			//get trader details
			$tDetails = Traders::model()->findByPk($getArray['trader_id']);
			
			$tDetails->trader_name = $getArray['owner_company_name'];
			$tDetails->ownership_type = $getArray['ownership_type'];
			$tDetails->management_type = $getArray['management_type'];
			$tDetails->owner_company_name = $getArray['owner_company_name'];
			$tDetails->company_tel = $getArray['company_tel'];
			$tDetails->person_in_charge1 = $getArray['person_in_charge1'];
			$tDetails->person_in_charge2 = $getArray['person_in_charge2'];
			$tDetails->charge = $getArray['charge'];
			$tDetails->modified_by = $logged_user_id;
			$tDetails->modified_on = date('Y-m-d H:i:s');
			
			$tDetails->save(false);
			
			$ownershipManagement=new OwnershipManagement;
			$ownershipManagement->floor_id  = $getArray['hdnHistFloorId'];
			$ownershipManagement->building_id  = $getArray['hdnBillId'];
			
			$ownershipManagement->trader_id = $getArray['Floor']['trader_id'];
			$ownershipManagement->ownership_type = $getArray['ownership_type'];
			$ownershipManagement->management_type = $getArray['management_type'];
			if(isset($getArray['is_current'])){
				$ownershipManagement->is_current = $getArray['is_current'];
			}
			$ownershipManagement->owner_company_name = $getArray['owner_company_name'];
			$ownershipManagement->company_tel = $getArray['company_tel'];
			$ownershipManagement->person_in_charge1 = $getArray['person_in_charge1'];
			$ownershipManagement->person_in_charge2 = $getArray['person_in_charge2'];
			if(isset($getArray['charge']) && $getArray['charge'] != ''){
				$ownershipManagement->charge = $getArray['charge'];
			}else{
				if($getArray['change_txt'] != ''){
					$ownershipManagement->charge = $getArray['change_txt'];
				}else{
					$ownershipManagement->charge = '';
				}
			}
			$ownershipManagement->modified_on = date('Y-m-d H:i:s');
			if($ownershipManagement->save(false)){
				$result = '<h4 class="ontable">'.Yii::app()->controller->__trans("Window・Owner").'</h4>
							<table class="admin_info admin_mb ad_list">
								<tbody>
									<tr>
										<th>種別<th>
										<th>'.Yii::app()->controller->__trans("Owner").'</th>
										<th>'.Yii::app()->controller->__trans("Person in charge").'</th>
										<th>'.Yii::app()->controller->__trans("TEL / FAX").'</th>
										<th>'.Yii::app()->controller->__trans("Type of mediation").'</th>
										<th>'.Yii::app()->controller->__trans("Comission").'</th>
										<th>'.Yii::app()->controller->__trans("Updated date").'</th>
									</tr>';
							//$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$getArray['hdnFloorId'].' AND is_current = 1');
							$query = 'SELECT * FROM (SELECT * FROM ownership_management ORDER BY ownership_management_id DESC) AS ownership_management where `building_id` = '.$getArray['hdnBillId'].'  AND `is_current` = 1 GROUP BY ownership_management.ownership_type LIMIT 1';
							$managementOwnerDetails = Yii::app()->db->createCommand($query)->queryAll();
							if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
								foreach($managementOwnerDetails as $ownerList){
									if($ownerList['ownership_type'] == 1){
										$ownerClass = "ico_corptype_4";
									}else{
										$ownerClass = "";
									}
						$result .= '<tr>
										<td>'.$aVendorType[$ownerList['ownership_type']].'</td>
										<td class='.$ownerClass.'>
										<font><font>'.(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != "" ? $ownerList['owner_company_name'] : "").'</font></font>
									</td>
									<td class="ad_name">
										<font><font>'.(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != "" ? $ownerList['person_in_charge1'] : "").'</font></font>
									</td>
									<td class="ad_contact">'.(isset($ownerList['company_tel']) && $ownerList['company_tel'] != "" ? $ownerList['company_tel'] : "").'
									</td>
									<td class="ad_type">
										<font><font>';
										if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
											if($ownerList['management_type'] == -1){
												$result .= Yii::app()->controller->__trans('unknown');
											}elseif($ownerList['management_type'] == 1){
												$result .= '専任媒介';
											}elseif($ownerList['management_type'] == 2){
												$result .= '一般媒介';
											}elseif($ownerList['management_type'] == 3){
												$result .= '代理';
											}elseif($ownerList['management_type'] == 4){
												$result .= '貸主';
											}else{
												$result .= '-';
											}
										}else{
											$result .= '-';
										}
							$result .= '</font></font>
									</td>
									<td class="ad_charge">';
									if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
										if (is_numeric($ownerList['charge'])){
											$result .= number_format($ownerList['charge'],1,'.','');
										}else{
											$result .= $ownerList['charge'];
										}
									}else{
										$result .= '-';
									}
						$result .= '</td>
									<td class="ad_update">'.(isset($ownerList['modified_on']) && $ownerList['modified_on'] != "" ? date('Y.m.d',strtotime($ownerList['modified_on'])) : "").'
									</td>
								</tr>';
								}
							}
					$result .= '</tbody>
							</table>
						<h4 class="ontable">'.Yii::app()->controller->__trans('property management history（Latest）').'</h4>
						<table class="admin_info admin_mb ad_list">
							<tbody>';
							$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$getArray['hdnHistFloorId'].' ORDER BY ownership_management_id DESC LIMIT 2');
							if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
								foreach($managementOwnerDetails as $ownerList){
						$result .= '<tr>';
										if($ownerList['ownership_type'] == 1){
											$ownerClass = "ico_corptype_4";
										}else{
											$ownerClass = "";
										}
							$result .= '<td>'.$aVendorType[$ownerList['ownership_type']].'</td>
										<td class="'.$ownerClass.'">
											<font><font>'.(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != "" ? $ownerList['owner_company_name'] : "").'</font></font>
										</td>
										<td class="ad_name">
											<font><font>'.(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != "" ? $ownerList['person_in_charge1'] : "").'</font></font>
										</td>
										<td class="ad_contact">'.(isset($ownerList['company_tel']) && $ownerList['company_tel'] != "" ? $ownerList['company_tel'] : "").'
										</td>
										<td class="ad_type">
											<font><font>';
											if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
												if($ownerList['management_type'] == -1){
													$result .= Yii::app()->controller->__trans('unknown');
												}elseif($ownerList['management_type'] == 1){
													$result .= '専任媒介';
												}elseif($ownerList['management_type'] == 2){
													$result .= '一般媒介';
												}elseif($ownerList['management_type'] == 3){
													$result .= '代理';
												}elseif($ownerList['management_type'] == 4){
													$result .= '貸主';
												}else{
													$result .= '-';
												}
											}else{
												$result .= '-';
											}
								$result .= '</font></font>
										</td>
										<td class="ad_charge">';
										if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
											if (is_numeric($ownerList['charge'])){
												$result .=  number_format($ownerList['charge'],1,'.','');
											}else{
												$result .=  $ownerList['charge'];
											}
										}else{
											$$result .= '-';
										}
							$result .= '</td>
										<td class="ad_update">'.(isset($ownerList['modified_on']) && $ownerList['modified_on'] != "" ? date('Y.m.d',strtotime($ownerList['modified_on'])) : "").'
										</td>
									</tr>';
									}
								}
						
						$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = "'.$floorDetails['floor_id'].'" AND (is_compart = 1 OR is_shared = 1) ORDER BY ownership_management_id DESC LIMIT 2');
						//$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = "'.$floorDetails['floor_id'].'" AND (is_compart = 1 OR is_shared = 1) ORDER BY ownership_management_id DESC LIMIT 2');
						
						//$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$floorDetails['floor_id'].' && is_condominium_ownership = 1 ORDER BY ownership_management_id DESC LIMIT 2');
						
						//$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = 154 && is_current = 0 ORDER BY ownership_management_id DESC LIMIT 2');
					
						
						//$managementOwnerDetails= Yii::app()->db->createCommand('SELECT * FROM `ownership_management`  WHERE floor_id = '.$floorDetails['floor_id'].' AND is_condominium_ownership = 1 ORDER BY ownership_management_id DESC LIMIT 2')->queryAll();
							if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
								foreach($managementOwnerDetails as $ownerList){
						$result .= '<tr>';
										if($ownerList['ownership_type'] == 1){
											$ownerClass = "ico_corptype_4";
										}else{
											$ownerClass = "";
										}
							$result .= '<td>'.$aVendorType[$ownerList['ownership_type']].'<span class="lblSingleCompartType">区分所有</span></td>
										<td class="'.$ownerClass.'">
											<font><font>'.(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != "" ? $ownerList['owner_company_name'] : "").'</font></font>
										</td>
										<td class="ad_name">
											<font><font>'.(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != "" ? $ownerList['person_in_charge1'] : "").'</font></font>
										</td>
										<td class="ad_contact">'.(isset($ownerList['company_tel']) && $ownerList['company_tel'] != "" ? $ownerList['company_tel'] : "").'
										</td>
										<td class="ad_type">
											<font><font>';
											if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
												if($ownerList['management_type'] == -1){
													$result .= Yii::app()->controller->__trans('unknown');
												}elseif($ownerList['management_type'] == 1){
													$result .= '専任媒介';
												}elseif($ownerList['management_type'] == 2){
													$result .= '一般媒介';
												}elseif($ownerList['management_type'] == 3){
													$result .= '代理';
												}elseif($ownerList['management_type'] == 4){
													$result .= '貸主';
												}else{
													$result .= '-';
												}
											}else{
												$result .= '-';
											}
								$result .= '</font></font>
										</td>
										<td class="ad_charge">';
										if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
											if (is_numeric($ownerList['charge'])){
												$result .=  number_format($ownerList['charge'],1,'.','');
											}else{
												$result .=  $ownerList['charge'];
											}
										}else{
											$result .= '-';
										}
							$result .= '</td>
										<td class="ad_update">'.(isset($ownerList['modified_on']) && $ownerList['modified_on'] != "" ? date('Y.m.d',strtotime($ownerList['modified_on'])) : "").'
										</td>
									</tr>';
									}
								}
					$result .= '</tbody>
							</table>';
				$resp = array('status'=>1,'result'=>$result);
			}else{
				$resp = array('status'=>2);
			}
		}else{
		
			$model = new Traders();
			$model->trader_name = $getArray['owner_company_name'];
			
			$model->ownership_type = $getArray['ownership_type'];
			$model->management_type = $getArray['management_type'];
			$model->owner_company_name = $getArray['owner_company_name'];
			$model->company_tel = $getArray['company_tel'];
			$model->person_in_charge1 = $getArray['person_in_charge1'];
			$model->person_in_charge2 = $getArray['person_in_charge2'];
			if(isset($getArray['charge']) && $getArray['charge'] != ''){
				$model->charge = $getArray['charge'];
			}else{
				if($getArray['change_txt'] != ''){
					$model->charge = $getArray['change_txt'];
				}else{
					$model->charge = '';
				}
			}
			
			$model->building_id = $getArray['hdnBillId'];
			$model->floor_id  = $getArray['hdnHistFloorId'];
			$model->added_by = $logged_user_id;
			$model->added_on = date('Y-m-d H:i:s');
			$model->modified_by = $logged_user_id;
			$model->modified_on = date('Y-m-d H:i:s');
			$model->traderId = mt_rand(1000,99999);		

			if($model->save(false)){
				$insert_id = Yii::app()->db->getLastInsertID();
				$ownershipManagement=new OwnershipManagement;
				$ownershipManagement->floor_id  = $getArray['hdnHistFloorId'];
				$ownershipManagement->building_id  = $getArray['hdnBillId'];
				
				$ownershipManagement->trader_id = $insert_id;
				$ownershipManagement->ownership_type = $getArray['ownership_type'];
				$ownershipManagement->management_type = $getArray['management_type'];
				if(isset($getArray['is_current'])){
					$ownershipManagement->is_current = $getArray['is_current'];
				}
				$ownershipManagement->owner_company_name = $getArray['owner_company_name'];
				$ownershipManagement->company_tel = $getArray['company_tel'];
				$ownershipManagement->person_in_charge1 = $getArray['person_in_charge1'];
				$ownershipManagement->person_in_charge2 = $getArray['person_in_charge2'];
				if(isset($getArray['charge']) && $getArray['charge'] != ''){
					$ownershipManagement->charge = $getArray['charge'];
				}else{
					if($getArray['change_txt'] != ''){
						$ownershipManagement->charge = $getArray['change_txt'];
					}else{
						$ownershipManagement->charge = '';
					}
				}
				$ownershipManagement->modified_on = date('Y-m-d H:i:s');
				if($ownershipManagement->save(false)){
			$result = '<h4 class="ontable">'.Yii::app()->controller->__trans("Window・Owner").'</h4>
							<table class="admin_info admin_mb ad_list">
								<tbody>
									<tr>
										<th>種別<th>
										<th>'.Yii::app()->controller->__trans("Owner").'</th>
										<th>'.Yii::app()->controller->__trans("Person in charge").'</th>
										<th>'.Yii::app()->controller->__trans("TEL / FAX").'</th>
										<th>'.Yii::app()->controller->__trans("Type of mediation").'</th>
										<th>'.Yii::app()->controller->__trans("Comission").'</th>
										<th>'.Yii::app()->controller->__trans("Updated date").'</th>
									</tr>';
			$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$getArray['hdnHistFloorId'].' AND is_current = 1');
			if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
				foreach($managementOwnerDetails as $ownerList){
					if($ownerList['ownership_type'] == 1){
						$ownerClass = "ico_corptype_4";
					}else{
						$ownerClass = "";
					}
					$result .= '<tr>
									<td>'.$aVendorType[$ownerList['ownership_type']].'</td>
									<td class='.$ownerClass.'>
										<font><font>'.(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != "" ? $ownerList['owner_company_name'] : "").'</font></font>
									</td>
									<td class="ad_name">
										<font><font>'.(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != "" ? $ownerList['person_in_charge1'] : "").'</font></font>
									</td>
									<td class="ad_contact">'.(isset($ownerList['company_tel']) && $ownerList['company_tel'] != "" ? $ownerList['company_tel'] : "").'
									</td>
									<td class="ad_type">
										<font><font>';
										if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
											if($ownerList['management_type'] == -1){
												$result .= Yii::app()->controller->__trans('unknown');
											}elseif($ownerList['management_type'] == 1){
												$result .= '専任媒介';
											}elseif($ownerList['management_type'] == 2){
												$result .= '一般媒介';
											}elseif($ownerList['management_type'] == 3){
												$result .= '代理';
											}elseif($ownerList['management_type'] == 4){
												$result .= '貸主';
											}else{
												$result .= '-';
											}
										}else{
											$result .= '-';
										}
							$result .= '</font></font>
									</td>
									<td class="ad_charge">';
									if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
										if (is_numeric($ownerList['charge'])){
											$result .= number_format($ownerList['charge'],1,'.','');
										}else{
											$result .= $ownerList['charge'];
										}
									}else{
										$result .= '-';
									}
						$result .= '</td>
									<td class="ad_update">'.(isset($ownerList['modified_on']) && $ownerList['modified_on'] != "" ? date('Y.m.d',strtotime($ownerList['modified_on'])) : "").'
									</td>
								</tr>';
								}
							}
					$result .= '</tbody>
							</table>
							<h4 class="ontable">'.Yii::app()->controller->__trans('property management history（Latest）').'</h4>
							<table class="admin_info admin_mb ad_list">
								<tbody>';
								$managementOwnerDetails = OwnershipManagement::model()->findAll('floor_id = '.$getArray['hdnHistFloorId'].' ORDER BY ownership_management_id DESC LIMIT 2');
								if(isset($managementOwnerDetails) && count($managementOwnerDetails) > 0){
									foreach($managementOwnerDetails as $ownerList){
						$result .= '<tr>';
										if($ownerList['ownership_type'] == 1){
											$ownerClass = "ico_corptype_4";
										}else{
											$ownerClass = "";
										}
							$result .= '<td>'.$aVendorType[$ownerList['ownership_type']].'</td>
										<td class="'.$ownerClass.'">
											<font><font>'.(isset($ownerList['owner_company_name']) && $ownerList['owner_company_name'] != "" ? $ownerList['owner_company_name'] : "").'</font></font>
										</td>
										<td class="ad_name">
											<font><font>'.(isset($ownerList['person_in_charge1']) && $ownerList['person_in_charge1'] != "" ? $ownerList['person_in_charge1'] : "").'</font></font>
										</td>
										<td class="ad_contact">'.(isset($ownerList['company_tel']) && $ownerList['company_tel'] != "" ? $ownerList['company_tel'] : "").'
										</td>
										<td class="ad_type">
											<font><font>';
											if(isset($ownerList['management_type']) && $ownerList['management_type'] != ""){
												if($ownerList['management_type'] == -1){
													$result .= Yii::app()->controller->__trans('unknown');
												}elseif($ownerList['management_type'] == 1){
													$result .= '専任媒介';
												}elseif($ownerList['management_type'] == 2){
													$result .= '一般媒介';
												}elseif($ownerList['management_type'] == 3){
													$result .= '代理';
												}elseif($ownerList['management_type'] == 4){
													$result .= '貸主';
												}else{
													$result .= '-';
												}
											}else{
												$result .= '-';
											}
								$result .= '</font></font>
										</td>
										<td class="ad_charge">';
										if(isset($ownerList['charge']) && $ownerList['charge'] != ""){
											if (is_numeric($ownerList['charge'])){
												$result .= number_format($ownerList['charge'],1,'.','');
											}else{
												$result .= $ownerList['charge'];
											}
										}else{
											echo '-';
										}
							$result .= '</td>
										<td class="ad_update">'.(isset($ownerList['modified_on']) && $ownerList['modified_on'] != "" ? date('Y.m.d',strtotime($ownerList['modified_on'])) : "").'
										</td>
									</tr>';
									}
								}
					$result .= '</tbody>
							</table>';
					$resp = array('status'=>1,'result'=>$result);
				}
			}
		}
			echo json_encode($resp);
			die;
	}
	
	public function actionAddNewManagementHistory(){
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
				
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata, $getArray);
		
		if($getArray['hdnOtherCFloorId'] != 0){
			$oFloors = explode(',',$getArray['hdnOtherCFloorId']);
			array_push($oFloors,$getArray['hdnFloorId']);
		}else{
			$oFloors = array($getArray['hdnFloorId']);
		}
		
		$buildingId = $getArray['hdnBillId'];
		$floorId = $getArray['hdnFloorId'];
		$otherCFloorId = $getArray['hdnOtherCFloorId'];
		$inUpdate = $getArray['inUpdate'];
		
		if($inUpdate != 0){
			//while update
			//$getManagementAvailable = OwnershipManagement::model()->find('building_id = '.$buildingId.' and floor_id = "'.$floorId.'" AND is_shared = 0 AND is_common = 0');
			
			//if(count($getManagementAvailable) == 0){
				$getManagementAvailable = new OwnershipManagement;
			//}
			if($getArray['trader_id'] != 0 && $getArray['trader_id'] != ""){
				//while trader available
				//update management details
				
				//get trader details
				$tDetails = Traders::model()->findByPk($getArray['trader_id']);
				
				$tDetails->trader_name = $getArray['owner_company_name'];
				$tDetails->ownership_type = $getArray['ownership_type'];
				$tDetails->management_type = $getArray['management_type'];
				$tDetails->owner_company_name = $getArray['owner_company_name'];
				$tDetails->company_tel = $getArray['company_tel'];
				$tDetails->person_in_charge1 = $getArray['person_in_charge1'];
				$tDetails->person_in_charge2 = $getArray['person_in_charge2'];
				$tDetails->charge = $getArray['charge'];
				$tDetails->modified_by = $logged_user_id;
				$tDetails->modified_on = date('Y-m-d H:i:s');
				
				$tDetails->save(false);
				
				foreach($oFloors as $floor){
					//for comport owner
					//only update comport owner details
					if(isset($getArray['is_compart'])){
						$getManagementAvailable->floor_id  = $floor;
						$getManagementAvailable->building_id  = $buildingId;
						$getManagementAvailable->is_compart = $getArray['is_compart'];
						$getManagementAvailable->trader_id = $getArray['trader_id'];
						$getManagementAvailable->ownership_type = $getArray['ownership_type'];
						$getManagementAvailable->management_type = $getArray['management_type'];
						if(isset($getArray['is_current'])){
							$getManagementAvailable->is_current = $getArray['is_current'];
						}
						$getManagementAvailable->owner_company_name = $getArray['owner_company_name'];
						$getManagementAvailable->company_tel = $getArray['company_tel'];
						$getManagementAvailable->person_in_charge1 = $getArray['person_in_charge1'];
						$getManagementAvailable->person_in_charge2 = $getArray['person_in_charge2'];
						if(isset($getArray['charge']) && $getArray['charge'] != ''){
							$getManagementAvailable->charge = $getArray['charge'];
						}else{
							if($getArray['change_txt'] != ''){
								$getManagementAvailable->charge = $getArray['change_txt'];
							}else{
								$getManagementAvailable->charge = '';
							}
						}
						$getManagementAvailable->modified_on = date('Y-m-d H:i:s');
						if($getManagementAvailable->save(false)){
							
							$lastUpdateDetails = FloorUpdateHistory::model()->find('floor_id = '.$floor.' order by floor_update_history_id');
							$updateHistory = new FloorUpdateHistory();
							$updateHistory->building_id = $lastUpdateDetails->building_id;
							$updateHistory->floor_id = $lastUpdateDetails->floor_id;
							$updateHistory->vacancy_info = $lastUpdateDetails->vacancy_info;
							$updateHistory->rent_unit_price = $lastUpdateDetails->rent_unit_price;
							$updateHistory->rent_unit_price_opt = $lastUpdateDetails->rent_unit_price_opt;
							$updateHistory->unit_condo_fee = $lastUpdateDetails->unit_condo_fee;
							$updateHistory->unit_condo_fee_opt = $lastUpdateDetails->unit_condo_fee_opt;
							$updateHistory->deposit_month = $lastUpdateDetails->deposit_month;
							$updateHistory->deposit_opt = $lastUpdateDetails->deposit_opt;
							$updateHistory->deposit = $lastUpdateDetails->deposit;
							$updateHistory->key_money_opt = $lastUpdateDetails->key_money_opt;
							$updateHistory->key_money_month = $lastUpdateDetails->key_money_month;
							$updateHistory->floor_source_id = $lastUpdateDetails->floor_source_id;
							$updateHistory->confirmation = $lastUpdateDetails->confirmation;
							$updateHistory->update_person_in_charge = $lastUpdateDetails->update_person_in_charge;
							$updateHistory->property_confirmation_person = $lastUpdateDetails->property_confirmation_person;
							$updateHistory->price_rise = $lastUpdateDetails->price_rise;
							$updateHistory->available_floor = $lastUpdateDetails->available_floor;
							$updateHistory->current_average_rent = $lastUpdateDetails->current_average_rent;
							$updateHistory->what_to_check = '区分所有情報';
							$updateHistory->save(false);
							
							$resp = array('status'=>1,'update'=>$inUpdate);
						}else{
							$resp = array('status'=>0);
						}
					}
					
					//for shared owner
					//every time shared owner details newly added
					if(isset($getArray['is_shared'])){
						$ownershipManagement=new OwnershipManagement;
					
						$ownershipManagement->floor_id  = $floor;
						$ownershipManagement->building_id  = $buildingId;
						$ownershipManagement->is_shared = $getArray['is_shared'];
						$ownershipManagement->trader_id = $getArray['trader_id'];
						$ownershipManagement->ownership_type = $getArray['ownership_type'];
						$ownershipManagement->management_type = $getArray['management_type'];
						if(isset($getArray['is_current'])){
							$ownershipManagement->is_current = $getArray['is_current'];
						}
						$ownershipManagement->owner_company_name = $getArray['owner_company_name'];
						$ownershipManagement->company_tel = $getArray['company_tel'];
						$ownershipManagement->person_in_charge1 = $getArray['person_in_charge1'];
						$ownershipManagement->person_in_charge2 = $getArray['person_in_charge2'];
						if(isset($getArray['charge']) && $getArray['charge'] != ''){
							$ownershipManagement->charge = $getArray['charge'];
						}else{
							if($getArray['change_txt'] != ''){
								$ownershipManagement->charge = $getArray['change_txt'];
							}else{
								$ownershipManagement->charge = '';
							}
						}
						$ownershipManagement->modified_on = date('Y-m-d H:i:s');
						if($ownershipManagement->save(false)){
							$resp = array('status'=>1,'update'=>$inUpdate);
						}else{
							$resp = array('status'=>0);
						}
					}
				}
			}else{
				//while trader not available
				foreach($oFloors as $floor){
					//add trader
					$model = new Traders();
					$model->trader_name = $getArray['owner_company_name'];
					
					$model->ownership_type = $getArray['ownership_type'];
					$model->management_type = $getArray['management_type'];
					$model->owner_company_name = $getArray['owner_company_name'];
					$model->company_tel = $getArray['company_tel'];
					$model->person_in_charge1 = $getArray['person_in_charge1'];
					$model->person_in_charge2 = $getArray['person_in_charge2'];
					if(isset($getArray['charge']) && $getArray['charge'] != ''){
						$model->charge = $getArray['charge'];
					}else{
						if($getArray['change_txt'] != ''){
							$model->charge = $getArray['change_txt'];
						}else{
							$model->charge = '';
						}
					}
					
					$model->building_id = $buildingId;
					
					$model->floor_id  = $floor;
					
					$model->added_by = $logged_user_id;
					$model->added_on = date('Y-m-d H:i:s');
					$model->modified_by = $logged_user_id;
					$model->modified_on = date('Y-m-d H:i:s');
					$model->traderId = mt_rand(1000,999999);
					
					if($model->save(false)){
						//update management details
						$insert_id = Yii::app()->db->getLastInsertID();
						//for comport owner
						//only update comport owner details
						if(isset($getArray['is_compart'])){
							$getManagementAvailable->floor_id  = $floor;
							$getManagementAvailable->building_id  = $buildingId;
							$getManagementAvailable->is_compart = $getArray['is_compart'];
							$getManagementAvailable->trader_id = $insert_id;
							$getManagementAvailable->ownership_type = $getArray['ownership_type'];
							$getManagementAvailable->management_type = $getArray['management_type'];
							if(isset($getArray['is_current'])){
								$getManagementAvailable->is_current = $getArray['is_current'];
							}
							$getManagementAvailable->owner_company_name = $getArray['owner_company_name'];
							$getManagementAvailable->company_tel = $getArray['company_tel'];
							$getManagementAvailable->person_in_charge1 = $getArray['person_in_charge1'];
							$getManagementAvailable->person_in_charge2 = $getArray['person_in_charge2'];
							if(isset($getArray['charge']) && $getArray['charge'] != ''){
								$getManagementAvailable->charge = $getArray['charge'];
							}else{
								if($getArray['change_txt'] != ''){
									$getManagementAvailable->charge = $getArray['change_txt'];
								}else{
									$getManagementAvailable->charge = '';
								}
							}
							$getManagementAvailable->modified_on = date('Y-m-d H:i:s');
							if($getManagementAvailable->save(false)){
								$lastUpdateDetails = FloorUpdateHistory::model()->find('floor_id = '.$floor.' order by floor_update_history_id');
								$updateHistory = new FloorUpdateHistory();
								$updateHistory->building_id = $lastUpdateDetails->building_id;
								$updateHistory->floor_id = $lastUpdateDetails->floor_id;
								$updateHistory->vacancy_info = $lastUpdateDetails->vacancy_info;
								$updateHistory->rent_unit_price = $lastUpdateDetails->rent_unit_price;
								$updateHistory->rent_unit_price_opt = $lastUpdateDetails->rent_unit_price_opt;
								$updateHistory->unit_condo_fee = $lastUpdateDetails->unit_condo_fee;
								$updateHistory->unit_condo_fee_opt = $lastUpdateDetails->unit_condo_fee_opt;
								$updateHistory->deposit_month = $lastUpdateDetails->deposit_month;
								$updateHistory->deposit_opt = $lastUpdateDetails->deposit_opt;
								$updateHistory->deposit = $lastUpdateDetails->deposit;
								$updateHistory->key_money_opt = $lastUpdateDetails->key_money_opt;
								$updateHistory->key_money_month = $lastUpdateDetails->key_money_month;
								$updateHistory->floor_source_id = $lastUpdateDetails->floor_source_id;
								$updateHistory->confirmation = $lastUpdateDetails->confirmation;
								$updateHistory->update_person_in_charge = $lastUpdateDetails->update_person_in_charge;
								$updateHistory->property_confirmation_person = $lastUpdateDetails->property_confirmation_person;
								$updateHistory->price_rise = $lastUpdateDetails->price_rise;
								$updateHistory->available_floor = $lastUpdateDetails->available_floor;
								$updateHistory->current_average_rent = $lastUpdateDetails->current_average_rent;
								$updateHistory->what_to_check = '区分所有情報';
								$updateHistory->save(false);
								
								$resp = array('status'=>1,'update'=>$inUpdate);
							}else{
								$resp = array('status'=>0);
							}
						}
						
						//for shared owner
						//every time shared owner details newly added
						if(isset($getArray['is_shared'])){
							$ownershipManagement=new OwnershipManagement;
						
							$ownershipManagement->floor_id  = $floor;
							$ownershipManagement->building_id  = $buildingId;
							$ownershipManagement->is_shared = $getArray['is_shared'];
							$ownershipManagement->trader_id = $insert_id;
							$ownershipManagement->ownership_type = $getArray['ownership_type'];
							$ownershipManagement->management_type = $getArray['management_type'];
							if(isset($getArray['is_current'])){
								$ownershipManagement->is_current = $getArray['is_current'];
							}
							$ownershipManagement->owner_company_name = $getArray['owner_company_name'];
							$ownershipManagement->company_tel = $getArray['company_tel'];
							$ownershipManagement->person_in_charge1 = $getArray['person_in_charge1'];
							$ownershipManagement->person_in_charge2 = $getArray['person_in_charge2'];
							if(isset($getArray['charge']) && $getArray['charge'] != ''){
								$ownershipManagement->charge = $getArray['charge'];
							}else{
								if($getArray['change_txt'] != ''){
									$ownershipManagement->charge = $getArray['change_txt'];
								}else{
									$ownershipManagement->charge = '';
								}
							}
							$ownershipManagement->modified_on = date('Y-m-d H:i:s');
							if($ownershipManagement->save(false)){
								$resp = array('status'=>1,'update'=>$inUpdate);
							}else{
								$resp = array('status'=>0);
							}
						}
					}
				}
			}
		}else{
			//while insert
			if($getArray['trader_id'] != 0 && $getArray['trader_id'] != ""){
				//while trader available
				
				//get trader details
				$tDetails = Traders::model()->findByPk($getArray['trader_id']);
				
				$tDetails->trader_name = $getArray['owner_company_name'];
				$tDetails->ownership_type = $getArray['ownership_type'];
				$tDetails->management_type = $getArray['management_type'];
				$tDetails->owner_company_name = $getArray['owner_company_name'];
				$tDetails->company_tel = $getArray['company_tel'];
				$tDetails->person_in_charge1 = $getArray['person_in_charge1'];
				$tDetails->person_in_charge2 = $getArray['person_in_charge2'];
				$tDetails->charge = $getArray['charge'];
				$tDetails->modified_by = $logged_user_id;
				$tDetails->modified_on = date('Y-m-d H:i:s');
				
				$tDetails->save(false);
				
				//add management details
				$ownershipManagement=new OwnershipManagement;
				
				$ownershipManagement->floor_id  = '-1';
				$ownershipManagement->building_id  = $buildingId;
				if(isset($getArray['is_compart'])){
					$ownershipManagement->is_compart = $getArray['is_compart'];
				}
				
				if(isset($getArray['is_shared'])){
					$ownershipManagement->is_shared = $getArray['is_shared'];
				}
				$ownershipManagement->trader_id = $getArray['trader_id'];
				$ownershipManagement->ownership_type = $getArray['ownership_type'];
				$ownershipManagement->management_type = $getArray['management_type'];
				if(isset($getArray['is_current'])){
					$ownershipManagement->is_current = $getArray['is_current'];
				}
				$ownershipManagement->owner_company_name = $getArray['owner_company_name'];
				$ownershipManagement->company_tel = $getArray['company_tel'];
				$ownershipManagement->person_in_charge1 = $getArray['person_in_charge1'];
				$ownershipManagement->person_in_charge2 = $getArray['person_in_charge2'];
				if(isset($getArray['charge']) && $getArray['charge'] != ''){
					$ownershipManagement->charge = $getArray['charge'];
				}else{
					if($getArray['change_txt'] != ''){
						$ownershipManagement->charge = $getArray['change_txt'];
					}else{
						$ownershipManagement->charge = '';
					}
				}
				$ownershipManagement->modified_on = date('Y-m-d H:i:s');
				if($ownershipManagement->save(false)){
					$resp = array('status'=>1,'update'=>$inUpdate);
				}else{
					$resp = array('status'=>0);
				}
			}else{
				//while trader not available
				$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
				$logged_user_id = $user->user_id;
				
				//add trader
				$model = new Traders();
				$model->trader_name = $getArray['owner_company_name'];
				
				$model->ownership_type = $getArray['ownership_type'];
				$model->management_type = $getArray['management_type'];
				$model->owner_company_name = $getArray['owner_company_name'];
				$model->company_tel = $getArray['company_tel'];
				$model->person_in_charge1 = $getArray['person_in_charge1'];
				$model->person_in_charge2 = $getArray['person_in_charge2'];
				if(isset($getArray['charge']) && $getArray['charge'] != ''){
					$model->charge = $getArray['charge'];
				}else{
					if($getArray['change_txt'] != ''){
						$model->charge = $getArray['change_txt'];
					}else{
						$model->charge = '';
					}
				}
				
				$model->building_id = $buildingId;
				
				$model->floor_id  = '-1';
				
				$model->added_by = $logged_user_id;
				$model->added_on = date('Y-m-d H:i:s');
				$model->modified_by = $logged_user_id;
				$model->modified_on = date('Y-m-d H:i:s');
				$model->traderId = mt_rand(1000,999999);
				
				if($model->save(false)){
					//add management details
					$insert_id = Yii::app()->db->getLastInsertID();
					
					$ownershipManagement=new OwnershipManagement;
					$ownershipManagement->floor_id  = '-1';
					$ownershipManagement->building_id  = $buildingId;
					if(isset($getArray['is_compart'])){
						$ownershipManagement->is_compart = $getArray['is_compart'];
					}
					
					if(isset($getArray['is_shared'])){
						$ownershipManagement->is_shared = $getArray['is_shared'];
					}
					$ownershipManagement->trader_id = $insert_id;
					$ownershipManagement->ownership_type = $getArray['ownership_type'];
					$ownershipManagement->management_type = $getArray['management_type'];
					if(isset($getArray['is_current'])){
						$ownershipManagement->is_current = $getArray['is_current'];
					}
					$ownershipManagement->owner_company_name = $getArray['owner_company_name'];
					$ownershipManagement->company_tel = $getArray['company_tel'];
					$ownershipManagement->person_in_charge1 = $getArray['person_in_charge1'];
					$ownershipManagement->person_in_charge2 = $getArray['person_in_charge2'];
					if(isset($getArray['charge']) && $getArray['charge'] != ''){
						$ownershipManagement->charge = $getArray['charge'];
					}else{
						if($getArray['change_txt'] != ''){
							$ownershipManagement->charge = $getArray['change_txt'];
						}else{
							$ownershipManagement->charge = '';
						}
					}
					$ownershipManagement->modified_on = date('Y-m-d H:i:s');
					if($ownershipManagement->save(false)){
						$resp = array('status'=>1,'update'=>$inUpdate);
					}else{
						$resp = array('status'=>0);
					}
				}
			}
		}
		echo json_encode($resp);
		die;		
	}

	public function actionDeleteFloor(){
		$id = $_REQUEST['id'];
		$currentFloorId = $_REQUEST['currentFloorId'];
		$floorDetails = Floor::model()->findByPk($id);
		Floor::model()->deleteAll('floor_id = '.$id);
		
		// BEGIN - Create wordpress building reference
		$wordpress = new Wordpress();
		$wordpress->processIntergrateWordpress($id, Wordpress::FLOOR_TYPE, 'delete');
		$wordpress->reGenerateLocations();
		// End - processing with wordpress
		
		FloorUpdateHistory::model()->deleteAll('floor_id = '.$id);
		Cart::model()->deleteAll('floor_id = '.$id);
		
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		$loguser_id = $users->user_id;
		$buildingDetails = Building::model()->findByPk($floorDetails['building_id']);

		$changeLogModel = new BuildingUpdateLog;
		$changeLogModel->building_id = $floorDetails['building_id'];
		$changeLogModel->change_content = Yii::app()->controller->__trans('Floor ID').' : '.$id.' ('.$buildingDetails['prefecture'].') '.Yii::app()->controller->__trans('has been deleted');
		$changeLogModel->added_by = $loguser_id;
		$changeLogModel->added_on = date('Y-m-d H:i:s');
		if($changeLogModel->save(false)){
			if($id != $currentFloorId){
				$resp = array('available'=>0,'url'=>'/index.php?r=building/singleBuilding&id='.$currentFloorId);
			}else{
				$resp = array('available'=>1,'url'=>'/index.php?r=building/searchBuilding');
			}
		}
		echo json_encode($resp);
		die;
	}	

	public function actionAddFastFloor(){
		$numberOfFloor = $_REQUEST['numberOfFloor'];
		$currentBuildingId = $_REQUEST['currentBuildingId'];
		$currentFloorId = $_REQUEST['currentFloorId'];
		
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $user->user_id;
		for($i=1;$i<=$numberOfFloor;$i++){
			$floorModel = new Floor;
			$floorModel->building_id = $currentBuildingId;
			$floorModel->vacancy_info = 0;
			$floorModel->added_by = $loguser_id;
			$floorModel->added_on = date('Y-m-d H:i:s');
			$floorModel->modified_by = $loguser_id;
			$floorModel->modified_on = date('Y-m-d H:i:s');
			$floorModel->floorId = 'JPF'.mt_rand(1000,999999);
			$floorModel->save(false);
			
			//check for office alert
			$cFloorId = $floorModel->floor_id;
			$currentFloor = Floor::model()->findByPk($cFloorId);
						
			$criteria=new CDbCriteria();
			$criteria->order='office_alert_id DESC';					
			$officeAlertList = OfficeAlert::model()->findAll($criteria);
			
			$j = 1;
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
				$j++;
			}
			
			
		}

		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		$loguser_id = $users->user_id;	
		$buildingDetails = Building::model()->findByPk($_POST['Floor']['buildingId']);	

		$changeLogModel = new BuildingUpdateLog;

		$changeLogModel->building_id = $currentBuildingId;

		$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/singleBuilding',array('id'=>$id)).'">'.$numberOfFloor.Yii::app()->controller->__trans('New floor').' ('.$buildingDetails['prefecture'].')</a>'.Yii::app()->controller->__trans('has been added');
		$changeLogModel->added_by = $loguser_id;
		$changeLogModel->added_on = date('Y-m-d H:i:s');
		if($changeLogModel->save(false)){
			$resp = array('status'=>1,'url'=>'/index.php?r=building/singleBuilding&id='.$currentFloorId);
		}
		echo json_encode($resp);
		die;
	}	

	public function actionAddNewPlanPicture(){
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
     	$loguser_id = $users->user_id;		
		$currentFloorId = $_POST['floorId'];
		$model = new PlanPicture;
		$model->building_id = $_POST['buildingId'];
		$getRandomNum = mt_rand(100000, 999999);
		$model->plan_rand_number = $getRandomNum;
		$model->added_by = $loguser_id;
		$model->added_on = date('Y-m-d H:i:s');		

		$uploadedFile=CUploadedFile::getInstance($model,'name');
		$explodeFileName = explode('.',$_FILES['file']['name']);
		$model->name = $getRandomNum.'.'.end($explodeFileName);		

		if($model->save(false)){
			$floorDetails = Floor::model()->findByPk($currentFloorId);
			$floorDetails->plan_picture_id = $model->plan_picture_id;
			$floorDetails->save(false);
			
			$images_path = realpath(Yii::app()->basePath . '/../planPictures');
			if(move_uploaded_file($_FILES['file']['tmp_name'],$images_path . '/' . $getRandomNum.'.'.end($explodeFileName))){
				$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
				$loguser_id = $users->user_id;
				$buildingDetails = Building::model()->findByPk($_POST['buildingId']);	
				
				$changeLogModel = new BuildingUpdateLog;
				$changeLogModel->building_id = $_POST['buildingId'];				
				$changeLogModel->change_content = '('.$buildingDetails['prefecture'].')'.Yii::app()->controller->__trans('New Plan Picture has been added');
				$changeLogModel->added_by = $loguser_id;
				$changeLogModel->added_on = date('Y-m-d H:i:s');
				if($changeLogModel->save(false)){
					$lastUpdateDetails = FloorUpdateHistory::model()->find('floor_id = '.$_POST['floorId'].' order by floor_update_history_id');
					$updateHistory = new FloorUpdateHistory();
					$updateHistory->building_id = $lastUpdateDetails->building_id;
					$updateHistory->floor_id = $lastUpdateDetails->floor_id;
					$updateHistory->vacancy_info = $lastUpdateDetails->vacancy_info;
					$updateHistory->rent_unit_price = $lastUpdateDetails->rent_unit_price;
					$updateHistory->rent_unit_price_opt = $lastUpdateDetails->rent_unit_price_opt;
					$updateHistory->unit_condo_fee = $lastUpdateDetails->unit_condo_fee;
					$updateHistory->unit_condo_fee_opt = $lastUpdateDetails->unit_condo_fee_opt;
					$updateHistory->deposit_month = $lastUpdateDetails->deposit_month;
					$updateHistory->deposit_opt = $lastUpdateDetails->deposit_opt;
					$updateHistory->deposit = $lastUpdateDetails->deposit;
					$updateHistory->key_money_opt = $lastUpdateDetails->key_money_opt;
					$updateHistory->key_money_month = $lastUpdateDetails->key_money_month;
					$updateHistory->floor_source_id = $lastUpdateDetails->floor_source_id;
					$updateHistory->confirmation = $lastUpdateDetails->confirmation;
					$updateHistory->update_person_in_charge = $lastUpdateDetails->update_person_in_charge;
					$updateHistory->property_confirmation_person = $lastUpdateDetails->property_confirmation_person;
					$updateHistory->price_rise = $lastUpdateDetails->price_rise;
					$updateHistory->available_floor = $lastUpdateDetails->available_floor;
					$updateHistory->current_average_rent = $lastUpdateDetails->current_average_rent;
					$updateHistory->what_to_check = '図面の更新';
					$updateHistory->save(false);
					
					$resp = array('status'=>1,'msg'=>Yii::app()->controller->__trans('File Successfully Uploaded'));
				}
			}else{
				$resp = array('status'=>0,'msg'=>Yii::app()->controller->__trans('Something went wrong. File not upload'));
			}
			if ($resp['status'])
			{
				$_REQUEST['id'] = $_GET['id'] = $_POST['floorId'];
				$this->pageTitle = $buildingDetails['name'].' | Japan Properties DB';
				$resp['html'] = $this->render('/building/singleBuildingDetails',array('floorDetails'=>$floorDetails,'buildingDetails'=>$buildingDetails), true);
			}
			echo json_encode($resp);
			die;
			//$uploadedFile->saveAs($images_path . '/' . $_FILES['file']['name']);
		}
	}	

	public function actionAllocatePlanToFloor(){
		$formData = $_REQUEST['formData'];
		parse_str($formData, $getArray);
		$i = 0;
		
 		$standard_plan = 0;		
 		foreach($getArray['allocateFloorId'] as $floorId){
 			if($floorId==0) {
 				$standard_plan = $getArray['planPictureId'][$i];
 				break;
 			}
 			$i++;
 		}
 		
 		$buildingDetails = Building::model()->findByPk($getArray['bid']);
 		$buildingDetails->plan_standard_id=$standard_plan;
 		$buildingDetails->save(false);
		
// 		$i=0;
// 		foreach($getArray['allocateFloorId'] as $floorId){
// 			if($floorId==0) continue;
// 			$floorDetails = Floor::model()->findByPk($floorId);
// 			$floorDetails->plan_picture_id = $getArray['planPictureId'][$i]!=0?$getArray['planPictureId'][$i]:$standard_plan;
// 			$floorDetails->save(false);
// 			$i++;
// 		}
// 		$resp = array('status'=>1);
// 		echo json_encode($resp);
// 		die;
		$i=0;
		foreach($getArray['allocateFloorId'] as $floorId){
			if($floorId==0) continue;
			$floorDetails = Floor::model()->findByPk($floorId);
			$floorDetails->plan_picture_id = $getArray['planPictureId'][$i];
			$floorDetails->save(false);
			$i++;
		}
		
		
		$resp = array('status'=>1);
		echo json_encode($resp);
		die;
	}	

	public function actionRemoveSelectedPlanPicture(){
		$formData = $_REQUEST['formData'];
		parse_str($formData, $getArray);
		
		foreach($getArray['deletePlanPicture'] as $planId){
			$floorDetails = Floor::model()->find('plan_picture_id = '.$planId);
			if(isset($floorDetails) && count($floorDetails) > 0 && !empty($floorDetails)){
				$floorDetails->plan_picture_id = 0;
				$floorDetails->save(false);
			}
			$planPictureDetails = PlanPicture::model()->findByPk($planId);
			PlanPicture::model()->deleteAll('plan_picture_id = '.$planId);

			$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
			$loguser_id = $users->user_id;	
			$buildingDetails = Building::model()->findByPk($planPictureDetails['building_id']);		

			$changeLogModel = new BuildingUpdateLog;
			$changeLogModel->building_id = $floorDetails['building_id'];
			$changeLogModel->change_content = '('.$buildingDetails['prefecture'].') '.$planPictureDetails['plan_rand_number'].Yii::app()->controller->__trans('Plan Picture has been deleted');
			$changeLogModel->added_by = $loguser_id;
			$changeLogModel->added_on = date('Y-m-d H:i:s');
			$changeLogModel->save(false);
		}
		$resp = array('status'=>1);
		echo json_encode($resp);
		die;
	}
	
	function actionClonesettings(){	
		foreach($_REQUEST['form'] as $key=>$val){
			if(strpos($val['name'],'][]') !== false){
				$name = str_replace('Floor[','',$val['name']);
				$name = str_replace('][]','',$name);
				$_POST['Floor'][$name][] = $val['value'];
			}elseif(strpos($val['name'],'Floor') !== false){
				$name = str_replace('Floor[','',$val['name']);
				$name = str_replace(']','',$name);
				$_POST['Floor'][$name] = $val['value'];
			}elseif(strpos($val['name'],'checked') !== false){
				$name = str_replace('checked[','',$val['name']);
				$name = str_replace(']','',$name);
				$_POST['checked'][$name] = 1;
			}
		}
		
		foreach($_REQUEST['fids'] as $fkey=>$fval){
			$floor_id = $id = $fval;
			$model=$this->loadModel($floor_id);
			$oldRentPrice = $model->rent_unit_price;
			$colnames = array(
				'buildingId' => 'building_id','vac_info'=>'vacancy_info','pre_user'=>'preceding_user','pre_details'=>'preceding_details','pre_check_datetime'=>'preceding_check_datetime','move_date'=>'move_in_date','vac_sche'=>'vacant_schedule','payment_by_installments_detail'=>'payment_by_installments_note',
			);
			
			$newRentPrice = $oldRentPrice;
			foreach($_POST['checked'] as $fkchecked=>$fkvalue){
				if($fkchecked == 'rent_unit_price'){
					$oldRentPrice = $model->rent_unit_price;
					$newRentPrice = $_POST['Floor']['rent_unit_price'];
				}
				
				if($fkchecked == 'air_conditioning_time_used'){
					$model->air_conditioning_time_used	 = $_POST['Floor']['air_conditioning_time_used'].'-'.$_POST['Floor']['f_air_usetime_detail_week_start'].'~'.$_POST['Floor']['f_air_usetime_detail_week_finish'].'-'.$_POST['Floor']['f_air_usetime_detail_sat_start'].'~'.$_POST['Floor']['f_air_usetime_detail_sat_finish'].'-'.$_POST['Floor']['f_air_usetime_detail_sun_start'].'~'.$_POST['Floor']['f_air_usetime_detail_sun_finish'];
				}elseif($fkchecked == 'type_of_use'){
					$model->type_of_use = implode(',',$_POST['Floor']['type_of_use']);
				}elseif($fkchecked == 'maisonette_type'){
					$model->maisonette_type = $_POST['Floor']['maisonette_type'];
				}elseif($fkchecked == 'short_term_rent'){
					$model->short_term_rent = $_POST['Floor']['short_term_rent'];
				}elseif($fkchecked == 'area_ping'){
					$model->area_ping = $_POST['Floor']['area_ping'];
					$area_m = number_format(3.305785 * ($_POST['Floor']['area_ping']),2,".","");
					$model->area_m = $area_m;
					if($_POST['Floor']['area_net'] != ""){
						$model->area_net = $_POST['Floor']['area_net'];
					}
				}elseif($fkchecked == 'calculation_method'){
					$model->calculation_method = $_POST['Floor']['calculation_method'];
				}elseif($fkchecked == 'payment_by_installments'){
					$model->payment_by_installments = $_POST['Floor']['payment_by_installments'];
					if($_POST['Floor']['payment_by_installments_detail'] != ""){
						$model->payment_by_installments_note = $_POST['Floor']['payment_by_installments_detail'];
					}
				}elseif($fkchecked == 'floor_partition'){
					if(isset($_POST['Floor']['floor_partition']) && count($_POST['Floor']['floor_partition']) > 0){
						$model->floor_partition = implode(',',$_POST['Floor']['floor_partition']);
					
					}
				}elseif($fkchecked == 'rent_unit_price_opt'){					
					$model->rent_unit_price_opt = $_POST['Floor']['rent_unit_price_opt'];
					if($_POST['Floor']['rent_unit_price'] != ""){
						$model->rent_unit_price = $_POST['Floor']['rent_unit_price'];
					}
				}elseif($fkchecked == 'total_rent_price'){					
					$model->total_rent_price = $_POST['Floor']['total_rent_price'];
				}elseif($fkchecked == 'unit_condo_fee_opt'){					
					$model->unit_condo_fee_opt = $_POST['Floor']['unit_condo_fee_opt'];
					if($_POST['Floor']['unit_condo_fee'] != ""){
						$model->rent_unit_price = $_POST['Floor']['unit_condo_fee'];
					}
				}elseif($fkchecked == 'total_condo_fee'){					
					$model->total_condo_fee = $_POST['Floor']['total_condo_fee'];
				}elseif($fkchecked == 'deposit_opt'){					
					$model->deposit_opt = $_POST['Floor']['deposit_opt'];
					if($_POST['Floor']['deposit_month'] != ""){
						$model->deposit_month = $_POST['Floor']['deposit_month'];
					}
					if($_POST['Floor']['deposit'] != ""){
						$model->deposit_month = $_POST['Floor']['deposit'];
					}
				}elseif($fkchecked == 'total_deposit'){					
					$model->total_deposit = $_POST['Floor']['total_deposit'];
				}elseif($fkchecked == 'key_money_opt'){					
					$model->key_money_opt = $_POST['Floor']['key_money_opt'];
					if($_POST['Floor']['key_money_month'] != ""){
						$model->key_money_month = $_POST['Floor']['key_money_month'];
					}
				}elseif($fkchecked == 'repayment_opt'){					
					$model->repayment_opt = $_POST['Floor']['repayment_opt'];
					if($_POST['Floor']['repayment_reason'] != ""){
						$model->repayment_reason = $_POST['Floor']['repayment_reason'];
					}
					if($_POST['Floor']['repayment_amt'] != ""){
						$model->repayment_amt = $_POST['Floor']['repayment_amt'];
					}
				}elseif($fkchecked == 'renewal_fee_opt'){					
					$model->renewal_fee_opt = $_POST['Floor']['renewal_fee_opt'];
					if($_POST['Floor']['renewal_fee_recent'] != ""){
						$model->renewal_fee_recent = $_POST['Floor']['renewal_fee_recent'];
					}
					if($_POST['Floor']['renewal_fee_recent'] != ""){
						$model->renewal_fee_recent = $_POST['Floor']['renewal_fee_recent'];
					}
				}elseif($fkchecked == 'repayment_notes'){					
					$model->repayment_notes = $_POST['Floor']['repayment_notes'];
				}elseif($fkchecked == 'notice_of_cancellation'){					
					$model->notice_of_cancellation = $_POST['Floor']['notice_of_cancellation'];
				}elseif($fkchecked == 'contract_period_opt'){					
					$model->contract_period_opt = $_POST['Floor']['contract_period_opt'];
					if($_POST['Floor']['contract_period_duration'] != ""){
						$model->contract_period_duration = $_POST['Floor']['contract_period_duration'];
					}
					
					if(isset($_POST['Floor']['contract_period_optchk']) && $_POST['Floor']['contract_period_optchk'] != ''){
						$model->contract_period_optchk	 = 1;
					}
					
				}
				elseif($fkchecked == 'air_conditioning_facility_type'){					
					$model->air_conditioning_facility_type = $_POST['Floor']['air_conditioning_facility_type'];
					if($_POST['Floor']['air_conditioning_details'] != ""){
						$model->air_conditioning_details = $_POST['Floor']['air_conditioning_details'];
					}
				}elseif($fkchecked == 'number_of_air_conditioning'){					
					$model->number_of_air_conditioning = $_POST['Floor']['number_of_air_conditioning'];
				}elseif($fkchecked == 'optical_cable'){					
					$model->optical_cable = $_POST['Floor']['optical_cable'];
				}elseif($fkchecked == 'oa_type'){					
					$model->oa_type = $_POST['Floor']['oa_type'];
					if($_POST['Floor']['oa_height'] != ""){
						$model->oa_height = $_POST['Floor']['oa_height'];
					}
				}elseif($fkchecked == 'floor_material'){					
					$model->floor_material = $_POST['Floor']['floor_material'];
				}elseif($fkchecked == 'ceiling_height'){					
					$model->ceiling_height = $_POST['Floor']['ceiling_height'];
				}elseif($fkchecked == 'electric_capacity'){					
					$model->electric_capacity = $_POST['Floor']['electric_capacity'];
				}elseif($fkchecked == 'separate_toilet_by_gender'){					
					$model->separate_toilet_by_gender = $_POST['Floor']['separate_toilet_by_gender'];
				}elseif($fkchecked == 'toilet_location'){					
					$model->toilet_location = $_POST['Floor']['toilet_location'];
				}elseif($fkchecked == 'floor_source_id'){					
					$model->floor_source_id = $_POST['Floor']['floor_source_id'];
				}else{
					$model->{$colnames[$fkchecked]} = $_POST['Floor'][$fkchecked];
				}
				
				
				$model->core_section = isset($_POST['Floor']['core_section']) ? (int)$_POST['Floor']['core_section'] : 0;
				$model->high_grade_building = isset($_POST['Floor']['high_grade_building']) ? (int)$_POST['Floor']['high_grade_building'] : 0;
				
				$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
				$loguser_id = $user->user_id;
				$model->modified_by = $loguser_id;
				$model->modified_on = date('Y-m-d H:i:s');
				$model->save(false);
			}
			
			$updateHistory = new FloorUpdateHistory();
			$updateHistory->floor_id = $model->floor_id;
			$updateHistory->building_id = $model->building_id;
			$updateHistory->vacancy_info = $model->vacancy_info;
			$updateHistory->rent_unit_price = $model->rent_unit_price;
			$updateHistory->rent_unit_price_opt = $model->rent_unit_price_opt;
			$updateHistory->unit_condo_fee_opt = $model->unit_condo_fee_opt;
			$updateHistory->unit_condo_fee = $model->unit_condo_fee;
			$updateHistory->deposit_month = $model->deposit_month;
			$updateHistory->key_money_opt = $model->key_money_opt;
			$updateHistory->deposit = $model->deposit;

			if(isset($model->floor_source_id) && $model->floor_source_id != ''){
				$updateHistory->floor_source_id = $model->floor_source_id;
			}
			$updateHistory->confirmation = '';
			$updateHistory->update_person_in_charge = $model->update_person_in_charge;
			$updateHistory->property_confirmation_person = $model->property_confirmation_person;
			$updateHistory->modified_on = date('Y-m-d H:i:s');
			if($oldRentPrice != $newRentPrice){
				$priceDifference = $newRentPrice - $oldRentPrice;
				if($priceDifference > 0){
					$updateHistory->price_rise = 1;
				}else{
					$updateHistory->price_rise = 0;
				}
			}
			
			$getAvailableFloor = Floor::model()->findAll('building_id = '.$model->building_id.' AND vacancy_info = 1');	
			$updateHistory->available_floor = count($getAvailableFloor);
			
			$getFloorForRent = Floor::model()->findAll('building_id = '.$model->building_id.' AND rent_unit_price_opt = 0');
			$totalRentSum = 0;
			$finalRentAvg = 0;
			if(count($getFloorForRent) > 0 && !empty($getFloorForRent)){
				foreach($getFloorForRent as $fLoop){
					$totalRentSum += $fLoop['rent_unit_price'];
				}
				$finalRentAvg = $totalRentSum/count($getFloorForRent);
			}
			$updateHistory->current_average_rent = $finalRentAvg;
			
			$updateHistory->save(false);			
		}
		echo json_encode(array('success'=>true));
		exit;
		
	}
	
	public function actionDeleteManagement(){
		$ids = $_REQUEST['companyIds'];
		//$ids = explode(',',$ids);
		//$resp = array('status'=>1,'msg'=>Yii::app()->controller->__trans('Successfully deleted'));
		if(isset($ids) && $ids != ""){
			$criteria = new CDbCriteria;
			$criteria->condition = 'ownership_management_id IN ('.$ids.')';

			OwnershipManagement::model()->deleteAll($criteria);
			$companyDetails = OwnershipManagement::model()->findAllByAttributes(array('ownership_management_id'=>$ids));
			if(count($companyDetails)<= 0 && empty($companyDetails)){
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
	public function actionRemoveFloorToCart(){
		$cartDetails = array();
 		$floor_id = $_POST['floorId'];
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $user->user_id;
		Cart::model()->deleteAll('floor_id = '.$floor_id .' And user_id = ' .$loguser_id);
		$cartDetails = Cart::model()->find('floor_id = '.$floor_id .' And user_id = ' .$loguser_id);
		$allCounts = Cart::model()->findAll('user_id = '.$loguser_id);
		$itemCount = " (".count($allCounts).")";
		$i = 0;
		foreach($allCounts as $cartList){
			$floorDetails = Floor::model()->findByPk($cartList['floor_id']);
			$buildingDetails = Building::model()->findByPk($cartList['building_id']);
			$buildingPictureDetails = BuildingPictures::model()->find("building_id = ".$cartList['building_id']);
			if(isset($buildingPictureDetails['front_images']) && $buildingPictureDetails['front_images'] != ""){
				$picture = explode(",",$buildingPictureDetails['front_images']);
				$picture = reset($picture);
				$pic = $images_path = Yii::app()->baseUrl . '/buildingPictures/front'.'/'.$picture;
			}else{
				$pic = $images_path = Yii::app()->baseUrl . '/images/noimg.jpg';
			}
			if(strpos($floorDetails['floor_down'], '-') !== false){
				$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
			}else{
				$floorDown = $floorDetails['floor_down'];
			}
			if($i == 0){
				$resp = "<div class='min-white-box'>";
				$resp .= "<input type='hidden' name='cartId' class='cartId' id='cartId' value='".$cartList['cart_id']."'/>";
				$resp .= "<div class='btnRemoveFromCart'><i class='fa fa-times'></i></div>";
				$resp .= "<img src='".$pic."' class='head-img'/>";
				$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name'];
				
				if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
					if(strpos($floorDetails['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
					}else{
						$floorDown = $floorDetails['floor_down'];
					}
					if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
						$resp .= $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
					}else{
						$resp .= $floorDown.' '.Yii::app()->controller->__trans('階');
					}
					if($floorDetails['roomname'] != ""){
						$resp .= "( ".$floorDetails['roomname']." )";
					}
				}
				$resp .= "<span class='building-text-brk'>";
				if($floorDetails['area_ping'] != ""){
					$resp .= $floorDetails['area_ping'].' 坪 &nbsp;';
				}else{
					$resp .= '-坪 &nbsp;';
				}
				
				if($floorDetails['rent_unit_price'] == "" && $floorDetails['rent_unit_price_opt'] == 0){
					$resp .= '未定/相談';
				}else{
// 						if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != ""){
// 							$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
// 						}else
					{
						if($floorDetails['rent_unit_price_opt'] != ''){
							if($floorDetails['rent_unit_price_opt'] == -1){
								$resp .= Yii::app()->controller->__trans('undecided');
							}else if($floorDetails['rent_unit_price_opt'] == -2){
								$resp .= Yii::app()->controller->__trans('ask');
							}else {
								$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
							}
						}else{
							$resp .= '-';
						}
					}
				}					
				$resp .= "</span></span></a>";
				$resp .= "</div>";
			}else{
				$resp .= "<div class='min-white-box'>";
				$resp .= "<input type='hidden' name='cartId' class='cartId' id='cartId' value='".$cartList['cart_id']."'/>";
				$resp .= "<div class='btnRemoveFromCart'><i class='fa fa-times'></i></div>";
				$resp .= "<img src='".$pic."' class='head-img'/>";
				$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name'];
				
				if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
					if(strpos($floorDetails['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
					}else{
						$floorDown = $floorDetails['floor_down'];
					}
					if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
						$resp .= $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
					}else{
						$resp .= $floorDown.' '.Yii::app()->controller->__trans('階');
					}
					if($floorDetails['roomname'] != ""){
						$resp .= "( ".$floorDetails['roomname']." )";
					}
				}
				$resp .= "<span class='building-text-brk'>";
				if($floorDetails['area_ping'] != ""){
					$resp .= $floorDetails['area_ping'].' 坪 &nbsp;';
				}else{
					$resp .= '-坪 &nbsp;';
				}
				
				if($floorDetails['rent_unit_price'] == "" && $floorDetails['rent_unit_price_opt'] == 0){
					$resp .= '未定/相談';
				}else{
// 						if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != ""){
// 							$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
// 						}else
					{
						if($floorDetails['rent_unit_price_opt'] != ''){
							if($floorDetails['rent_unit_price_opt'] == -1){
								$resp .= Yii::app()->controller->__trans('undecided');
							}else if($floorDetails['rent_unit_price_opt'] == -2){
								$resp .= Yii::app()->controller->__trans('ask');
							}else {
								$resp .= $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
							}
						}else{
							$resp .= '-';
						}
					}
				}					
				$resp .= "</span></span></a>";
				$resp .= "</div>";
			}
			$i++;
		}
		if(empty($cartDetails)){
			$result = array('status'=>1,'count'=>$itemCount,'respData'=>$resp);	
		}
		echo json_encode($result);
		die;
	}
	public function actionCheckRoomNumber(){
		$roomNumber = $_POST['room_no'];
		$buildingId = $_POST['buildingId'];
		$roomNoArray = array();
		$buildingDetails = Floor::model()->findAll(' building_id = '.$buildingId);
		foreach($buildingDetails as $bd){
			$roomNoArray[] = $bd['roomname'];
		}
		if(in_array($roomNumber,$roomNoArray)){
			$resp = array('status'=>1,'msg'=>'Dont allow to add same number');
		}else{
			$resp = array('status'=>0);
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionBulkDelete(){
		$formData = $_REQUEST['formdata'];
		parse_str($formData, $getArray);
		
		$oArray = array();
		if(isset($getArray['checkOwner'])){
			$oArray = $getArray['checkOwner'];
			foreach($oArray as $owner){
				OwnershipManagement::model()->deleteByPk($owner);
			}
		}
		
		$tArray = array();
		if(isset($getArray['checkVendor'])){
			$tArray = $getArray['checkVendor'];
			foreach($tArray as $trader){
				Traders::model()->deleteByPk($trader);
			}
		}
		
		$resp = array('status'=>1);
		echo json_encode($resp);
		die;
	}	
	
	public function actionViewFloorMass() {
		if(isset($_REQUEST['id'])) {
			$id = $_REQUEST['id'];
			$buildingDetails = Building::model()->findByPk($id);
			$userList = Users::model()->findAll('is_active = 1 AND user_role = "a"');
			$floorList = Floor::model()->findAll(" building_id = ".$id);
			$this->renderPartial('viewFloorMass',array('buildingDetails'=>$buildingDetails,'floorList'=> $floorList, 'users'=>$userList));
		}
		die();
	}
	
	public function actionUpdateFloorMass() {

 		if(isset($_REQUEST['f_id'])) {
 			$building_id = $_REQUEST['b_no'];
 			$fids = $_REQUEST['f_id'];
 			$fids = array_unique($fids);
  			
 			foreach($fids AS $fid) {
 				$model=$this->loadModel($fid);
 				
 				if(isset($_POST['f_floor_down'][$fid])){
 					$model->floor_down = $_POST['f_floor_down'][$fid];
 				}
 				if(isset($_POST['f_floor_up'][$fid])){
 					$model->floor_up = $_POST['f_floor_up'][$fid];
 				}
 				if(isset($_POST['f_roomname'][$fid])){
 					$model->roomname = $_POST['f_roomname'][$fid];
 				}
 				if(isset($_POST['f_emp'][$fid])){
 					$model->vacancy_info = $_POST['f_emp'][$fid];
 				}
 				if(isset($_POST['f_acreg'][$fid])){
 					$model->area_ping = $_POST['f_acreg'][$fid];
 				}
 				if(isset($_POST['f_m2'][$fid])){
 					$model->area_m = $_POST['f_m2'][$fid];
 				}
 				if(isset($_POST['f_bunkatsu'][$fid])){
 					$model->payment_by_installments = $_POST['f_bunkatsu'][$fid];
 				}
 				if(isset($_POST['f_bunkatsu_detail'][$fid])){
 					$model->payment_by_installments_note = $_POST['f_bunkatsu_detail'][$fid];
 				}
 				if(isset($_POST['f_senko_flag'][$fid])){
 					$model->preceding_user = $_POST['f_senko_flag'][$fid];
 				}
 				if(isset($_POST['f_senko_detail'][$fid])){
 					$model->preceding_details = $_POST['f_senko_detail'][$fid];
 				}
 				if(isset($_POST['f_senko_check_datetime'][$fid])){
 					$model->preceding_check_datetime = $_POST['f_senko_check_datetime'][$fid];
 				}
 				if(isset($_POST['f_rentstart'][$fid])){
 					$model->move_in_date = $_POST['f_rentstart'][$fid];
 				}
 				if(isset($_POST['f_akiyotei_date'][$fid])){
 					$model->vacant_schedule = $_POST['f_akiyotei_date'][$fid];
 				}
 				if(isset($_POST['f_purpose'][$fid])){
 					$model->type_of_use = $_POST['f_purpose'][$fid];
 				}
 				if(isset($_POST['f_maisonette_flag'][$fid])){
 					$model->maisonette_type = $_POST['f_maisonette_flag'][$fid];
 				}
 				if(isset($_POST['f_netgross'][$fid])){
 					$model->calculation_method = $_POST['f_netgross'][$fid];
 				}
 				if(isset($_POST['f_acreg_net'][$fid])){
 					$model->area_net = $_POST['f_acreg_net'][$fid];
 				}
 				if(isset($_POST['f_price_t_rent_opt'][$fid])){
 					$model->rent_unit_price_opt = $_POST['f_price_t_rent_opt'][$fid];
 				}
 				if(isset($_POST['f_price_t_rent'][$fid])){
 					$model->rent_unit_price = $_POST['f_price_t_rent'][$fid];
 				}
 				if(isset($_POST['f_price_a_rent'][$fid])){
 					$model->total_rent_price = $_POST['f_price_a_rent'][$fid];
 				}
 				if(isset($_POST['f_price_t_mente_opt'][$fid])){
 					$model->unit_condo_fee_opt = $_POST['f_price_t_mente_opt'][$fid];
 				}
 				if(isset($_POST['f_price_t_mente'][$fid])){
 					$model->unit_condo_fee = $_POST['f_price_t_mente'][$fid];
 				}
 				if(isset($_POST['f_price_a_mente'][$fid])){
 					$model->total_condo_fee = $_POST['f_price_a_mente'][$fid];
 				}
 				if(isset($_POST['f_price_m_shiki_opt'][$fid])){
 					$model->deposit_opt = $_POST['f_price_m_shiki_opt'][$fid];
 				}
 				if(isset($_POST['f_price_m_shiki'][$fid])){
 					$model->deposit_month = $_POST['f_price_m_shiki'][$fid];
 				}
 				if(isset($_POST['f_price_t_shiki'][$fid])){
 					$model->deposit = $_POST['f_price_t_shiki'][$fid];
 				}
 				if(isset($_POST['f_price_a_shiki'][$fid])){
 					$model->total_deposit = $_POST['f_price_a_shiki'][$fid];
 				}
 				if(isset($_POST['f_price_keymoney_opt'][$fid])){
 					$model->key_money_opt = $_POST['f_price_keymoney_opt'][$fid];
 				}
 				if(isset($_POST['f_price_keymoney'][$fid])){
 					$model->key_money_month = $_POST['f_price_keymoney'][$fid];
 				}
 				if(isset($_POST['f_price_rerent_opt'][$fid])){
 					$model->renewal_fee_opt = $_POST['f_price_rerent_opt'][$fid];
 				}
 				if(isset($_POST['f_price_rerent'][$fid])){
 					$model->renewal_fee_recent = $_POST['f_price_rerent'][$fid];
 				}
 				if(isset($_POST['f_price_rerent_timeflag'][$fid])){
 					$model->renewal_fee_reason = $_POST['f_price_rerent_timeflag'][$fid];
 				}
 				if(isset($_POST['f_price_amo_opt'][$fid])){
 					$model->repayment_opt = $_POST['f_price_amo_opt'][$fid];
 				}
 				if(isset($_POST['f_price_amo'][$fid])){
 					$model->repayment_amt = $_POST['f_price_amo'][$fid];
 				}
 				if(isset($_POST['f_price_amo_flag'][$fid])){
 					$model->repayment_amt_opt = $_POST['f_price_amo_flag'][$fid];
 				}
 				if(isset($_POST['f_amo_memo'][$fid])){
 					$model->repayment_notes = $_POST['f_amo_memo'][$fid];
 				}
 				if(isset($_POST['f_price_amo_timeflag'][$fid])){
 					$model->repayment_reason = $_POST['f_price_amo_timeflag'][$fid];
 				}
 				if(isset($_POST['f_leavenotice'][$fid])){
 					$model->notice_of_cancellation = $_POST['f_leavenotice'][$fid];
 				}
 				if(isset($_POST['f_floormate'][$fid])){
 					$model->floor_material = $_POST['f_floormate'][$fid];
 				}
 				if(isset($_POST['f_eleccapa'][$fid])){
 					$model->electric_capacity = $_POST['f_eleccapa'][$fid];
 				}
 				if(isset($_POST['f_air'][$fid])){
 					$model->air_conditioning_facility_type = $_POST['f_air'][$fid];
 				}
 				if(isset($_POST['f_air_detail'][$fid])){
 					$model->air_conditioning_details = $_POST['f_air_detail'][$fid];
 				}
 				if(isset($_POST['f_air_usetime'][$fid])){
 					$model->air_conditioning_time_used = $_POST['f_air_usetime'][$fid];
 				}
 				if(isset($_POST['f_oa'][$fid])){
 					$model->oa_type = $_POST['f_oa'][$fid];
 				}
 				if(isset($_POST['f_freac_height'][$fid])){
 					$model->oa_height = $_POST['f_freac_height'][$fid];
 				}
 				if(isset($_POST['f_height'][$fid])){
 					$model->ceiling_height = $_POST['f_height'][$fid];
 				}
 				if(isset($_POST['f_wc_flag'][$fid])){
 					$model->separate_toilet_by_gender = $_POST['f_wc_flag'][$fid];
 				}
 				if(isset($_POST['f_regloan_flag'][$fid])){
 					$model->contract_period_opt = $_POST['f_regloan_flag'][$fid];
 				}
 				if(isset($_POST['f_regloan_year'][$fid])){
 					$model->contract_period_duration = $_POST['f_regloan_year'][$fid];
 				}
 				if(isset($_POST['f_tankigashi_flag'][$fid])){
 					$model->short_term_rent = $_POST['f_tankigashi_flag'][$fid];
 				}
 				if(isset($_POST['f_web_publishing_note'][$fid])){
 					$model->web_publishing_note = $_POST['f_web_publishing_note'][$fid];
 				}
 				
 				if(isset($_POST['f_regloan_year_check'][$fid]) && $_POST['f_regloan_year_check'][$fid] == 1){
 					$model->contract_period_optchk = $_POST['f_regloan_year_check'][$fid];
 				}
 				
 				$model->floor_source_id = $_POST['fh_source'];
 				$model->update_person_in_charge = $_POST['fh_update_rep'];
 				$model->property_confirmation_person = $_POST['fh_source_rep'];
 				
 				$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
 				$loguser_id = $user->user_id;
 				$model->modified_by = $loguser_id;
 				$model->modified_on = date('Y-m-d H:i:s');
 				
 				$model->save(false);
 				
 				// BEGIN - Create wordpress building reference
 				$params['building_id'] = $model->building_id;
 				$wordpress = new Wordpress();
 				$wordpress->processIntergrateWordpress($model->floor_id, Wordpress::FLOOR_TYPE, 'update', $params);
 				$wordpress->reGenerateLocations();
 				// End - processing with wordpress
 			}
			echo "<script>
					location.href = '".Yii::app()->createUrl('floor/viewFloorMass',array('id'=>$building_id, 'update_management'=>1))."';</script>"; 			
 		}
 		die();
	}
	
	public function actionCopyFloorMass() {
		if(isset($_GET['copy_floor'])) {
			$fid = $_GET['copy_floor'];			

			$copymodel = $this->loadModel($fid);
			$model = new Floor;
			$model->building_id = $copymodel->building_id;
			$model->vacancy_info = $copymodel->vacancy_info;
			$model->preceding_user = $copymodel->preceding_user;
			$model->preceding_details = $copymodel->preceding_details;
			$model->preceding_check_datetime = $copymodel->preceding_check_datetime;
			$model->move_in_date = $copymodel->move_in_date;
			$model->vacant_schedule = $copymodel->vacant_schedule;
			$model->floor_down = $copymodel->floor_down;
			$model->floor_up = $copymodel->floor_up;
			$model->roomname = $copymodel->roomname;
			$model->maisonette_type = $copymodel->maisonette_type;
			$model->short_term_rent = $copymodel->short_term_rent;
			$model->type_of_use = $copymodel->type_of_use;
			$model->area_ping = $copymodel->area_ping;
			$model->area_m = $copymodel->area_m;
			$model->area_net = $copymodel->area_net;
			$model->calculation_method = $copymodel->calculation_method;
			$model->payment_by_installments = $copymodel->payment_by_installments;
			$model->core_section = $copymodel->core_section;
			$model->high_grade_building = $copymodel->high_grade_building;
			$model->payment_by_installments_note = $copymodel->payment_by_installments_note;
			$model->floor_partition = $copymodel->floor_partition;
			$model->rent_unit_price_opt = $copymodel->rent_unit_price_opt;
			$model->rent_unit_price = $copymodel->rent_unit_price;
			$model->total_rent_price = $copymodel->total_rent_price;
			$model->unit_condo_fee_opt = $copymodel->unit_condo_fee_opt;
			$model->unit_condo_fee = $copymodel->unit_condo_fee;
			$model->total_condo_fee = $copymodel->total_condo_fee;
			$model->deposit_opt = $copymodel->deposit_opt;
			$model->deposit_month = $copymodel->deposit_month;
			$model->deposit = $copymodel->deposit;
			$model->total_deposit = $copymodel->total_deposit;
			$model->key_money_opt = $copymodel->key_money_opt;
			$model->key_money_month = $copymodel->key_money_month;
			$model->repayment_opt = $copymodel->repayment_opt;
			$model->repayment_reason = $copymodel->repayment_reason;
			$model->repayment_amt = $copymodel->repayment_amt;
			$model->repayment_amt_opt = $copymodel->repayment_amt_opt;
			$model->floorId = $copymodel->floorId;
			$model->renewal_fee_opt = $copymodel->renewal_fee_opt;
			$model->renewal_fee_reason = $copymodel->renewal_fee_reason;
			$model->renewal_fee_recent = $copymodel->renewal_fee_recent;
			$model->repayment_notes = $copymodel->repayment_notes;
			$model->notice_of_cancellation = $copymodel->notice_of_cancellation;
			$model->contract_period_opt = $copymodel->contract_period_opt;
			$model->contract_period_optchk = $copymodel->contract_period_optchk;
			$model->contract_period_duration = $copymodel->contract_period_duration;
			$model->air_conditioning_facility_type = $copymodel->air_conditioning_facility_type;
			$model->air_conditioning_details = $copymodel->air_conditioning_details;
			$model->air_conditioning_time_used = $copymodel->air_conditioning_time_used;
			$model->number_of_air_conditioning = $copymodel->number_of_air_conditioning;
			$model->optical_cable = $copymodel->optical_cable;
			$model->oa_type = $copymodel->oa_type;
			$model->oa_height = $copymodel->oa_height;
			$model->ceiling_height = $copymodel->ceiling_height;
			$model->floor_material = $copymodel->floor_material;
			$model->electric_capacity = $copymodel->electric_capacity;
			$model->separate_toilet_by_gender = $copymodel->separate_toilet_by_gender;
			$model->toilet_location = $copymodel->toilet_location;
			$model->washlet = $copymodel->washlet;
			$model->toilet_cleaning = $copymodel->toilet_cleaning;
			$model->notes = $copymodel->notes;
			$model->floor_source_id = $copymodel->floor_source_id;
			$model->web_publishing = $copymodel->web_publishing;
			$model->update_person_in_charge = $copymodel->update_person_in_charge;
			$model->property_confirmation_person = $copymodel->property_confirmation_person;
			$model->added_by = $copymodel->added_by;
			$model->added_on = $copymodel->added_on;
			$model->modified_by = $copymodel->modified_by;
			$model->modified_on = $copymodel->modified_on;
			$model->save(false);			
			
			echo "success";
		}
	}
	
	public function actionDeleteFloorMass() {
		if(isset($_GET['delete_floor_list'])) {
			$fid = $_GET['delete_floor_list'];
			$arrfid = explode(",", $fid);
			$arrfid = array_unique($arrfid);
			foreach($arrfid AS $fid) {
				if((int)$fid!=0)
					$this->loadModel($fid)->delete();
			}
			echo "success";
		}
	}
	
	public function actionInsertFloorMass() {
		if(isset($_GET['b_no']) && isset($_GET['add_floor_num'])) {
			$bid = $_GET['b_no'];
			$num = $_GET['add_floor_num'];
			for($i=0;$i<$num;$i++) {
				$model = new Floor;
				$model->building_id = $bid;
				$model->modified_on = date('Y-m-d H:i:s');
				$model->save(false);
			}
			echo "success";
		}
	}

	public function actionAppendNewManagementHistoryMass(){
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
			
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata, $getArray);
		
		$arr_floor = explode(',', $getArray['hdnHistFloorId']);
		foreach($arr_floor As $floor_id) {
			$getManagementAvailable = OwnershipManagement::model()->find('building_id = '.$getArray['hdnBillId'].' and floor_id = "'.$floor_id.'" AND (is_compart = 1 OR is_shared = 1) ORDER BY ownership_management_id DESC');
			if(count($getManagementAvailable) > 0){
				continue;
			}
		
			$aVendorType = Yii::app()->controller->getBuildingVendorType();	
			if($getArray['trader_id'] != 0 && $getArray['trader_id'] != ""){
					
				//get trader details
				$tDetails = Traders::model()->findByPk($getArray['trader_id']);
					
				$tDetails->trader_name = $getArray['owner_company_name'];
				$tDetails->ownership_type = $getArray['ownership_type'];
				$tDetails->management_type = $getArray['management_type'];
				$tDetails->owner_company_name = $getArray['owner_company_name'];
				$tDetails->company_tel = $getArray['company_tel'];
				$tDetails->person_in_charge1 = $getArray['person_in_charge1'];
				$tDetails->person_in_charge2 = $getArray['person_in_charge2'];
				$tDetails->charge = $getArray['charge'];
				$tDetails->modified_by = $logged_user_id;
				$tDetails->modified_on = date('Y-m-d H:i:s');
					
				$tDetails->save(false);
					
				$ownershipManagement=new OwnershipManagement;
				$ownershipManagement->floor_id  = $floor_id;//$getArray['hdnHistFloorId'];
				$ownershipManagement->building_id  = $getArray['hdnBillId'];
					
				$ownershipManagement->trader_id = $getArray['Floor']['trader_id'];
				$ownershipManagement->ownership_type = $getArray['ownership_type'];
				$ownershipManagement->management_type = $getArray['management_type'];
				if(isset($getArray['is_current'])){
					$ownershipManagement->is_current = $getArray['is_current'];
				}
				$ownershipManagement->owner_company_name = $getArray['owner_company_name'];
				$ownershipManagement->company_tel = $getArray['company_tel'];
				$ownershipManagement->person_in_charge1 = $getArray['person_in_charge1'];
				$ownershipManagement->person_in_charge2 = $getArray['person_in_charge2'];
				if(isset($getArray['charge']) && $getArray['charge'] != ''){
					$ownershipManagement->charge = $getArray['charge'];
				}else{
					if($getArray['change_txt'] != ''){
						$ownershipManagement->charge = $getArray['change_txt'];
					}else{
						$ownershipManagement->charge = '';
					}
				}
				$ownershipManagement->modified_on = date('Y-m-d H:i:s');
				if($ownershipManagement->save(false)){
					$resp = array('status'=>1,'result'=>$result);
				}else{
					$resp = array('status'=>2);
				}
			}else{
		
				$model = new Traders();
				$model->trader_name = $getArray['owner_company_name'];
					
				$model->ownership_type = $getArray['ownership_type'];
				$model->management_type = $getArray['management_type'];
				$model->owner_company_name = $getArray['owner_company_name'];
				$model->company_tel = $getArray['company_tel'];
				$model->person_in_charge1 = $getArray['person_in_charge1'];
				$model->person_in_charge2 = $getArray['person_in_charge2'];
				if(isset($getArray['charge']) && $getArray['charge'] != ''){
					$model->charge = $getArray['charge'];
				}else{
					if($getArray['change_txt'] != ''){
						$model->charge = $getArray['change_txt'];
					}else{
						$model->charge = '';
					}
				}
					
				$model->building_id = $getArray['hdnBillId'];
				$model->floor_id  = $floor_id;//$getArray['hdnHistFloorId'];
				$model->added_by = $logged_user_id;
				$model->added_on = date('Y-m-d H:i:s');
				$model->modified_by = $logged_user_id;
				$model->modified_on = date('Y-m-d H:i:s');
				$model->traderId = mt_rand(1000,99999);
		
				if($model->save(false)){
					$insert_id = Yii::app()->db->getLastInsertID();
					$ownershipManagement=new OwnershipManagement;
					$ownershipManagement->floor_id  = $floor_id;//$getArray['hdnHistFloorId'];
					$ownershipManagement->building_id  = $getArray['hdnBillId'];
		
					$ownershipManagement->trader_id = $insert_id;
					$ownershipManagement->ownership_type = $getArray['ownership_type'];
					$ownershipManagement->management_type = $getArray['management_type'];
					if(isset($getArray['is_current'])){
						$ownershipManagement->is_current = $getArray['is_current'];
					}
					$ownershipManagement->owner_company_name = $getArray['owner_company_name'];
					$ownershipManagement->company_tel = $getArray['company_tel'];
					$ownershipManagement->person_in_charge1 = $getArray['person_in_charge1'];
					$ownershipManagement->person_in_charge2 = $getArray['person_in_charge2'];
					if(isset($getArray['charge']) && $getArray['charge'] != ''){
						$ownershipManagement->charge = $getArray['charge'];
					}else{
						if($getArray['change_txt'] != ''){
							$ownershipManagement->charge = $getArray['change_txt'];
						}else{
							$ownershipManagement->charge = '';
						}
					}
					$ownershipManagement->modified_on = date('Y-m-d H:i:s');
					if($ownershipManagement->save(false)){
						$resp = array('status'=>1,'result'=>$result);
					}
				}
			}
		}
		$resp = array('status'=>1,'result'=>$getArray);
		echo json_encode($resp);
		die;
	}
	
	public function actionUpdateShowFrontend(){
		if (isset($_POST['show_frontend']))
		{
			$wordpress = new Wordpress();
			foreach ($_POST['show_frontend'] as $floor_id => $show_frontend)
			{
				$floor = Floor::model()->findByPk($floor_id);
				if ($floor)
				{
					$floor->show_frontend = (int)$show_frontend;
					if ($floor->save(false))
					{
						// BEGIN - Create wordpress building reference
						$params['building_id'] = $floor->building_id;
						$wordpress->processIntergrateWordpress($floor->floor_id, Wordpress::FLOOR_TYPE, 'update', $params);
						// End - processing with wordpress
					}
				}
			}
			$wordpress->reGenerateLocations();
		}
		echo json_encode(array('error' => false));
	}
	
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
}
