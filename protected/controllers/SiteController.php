<?php
use yii\data\Pagination;

class SiteController extends Controller{
	/**
	 * Declares class-based actions.
	 */
	public function actions(){
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex(){
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->pageTitle='Dashboard';
		if (Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->createUrl('site/login'));
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError(){
		if($error=Yii::app()->errorHandler->error){
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	/**
	 * Displays the contact page
	 */
	public function actionContact(){
		$model=new ContactForm;
		if(isset($_POST['ContactForm'])){
			$model->attributes=$_POST['ContactForm'];
			if($model->validate()){
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";
				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin(){
		$this->layout = 'login_layout';
		$model=new LoginForm;	

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm'])){
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				$this->redirect(array('index'));
				//$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect(array('login'));
	}	

	public function actionSettings(){
		$this->render('settings');
	}
	
	public function actionGlobalSearch(){
		$keyword = $_REQUEST['searchGlobal'];
		
		//$query = "SELECT `building_id` FROM `building` WHERE `name` LIKE '%".$keyword."%' UNION SELECT `customer_id` FROM `customer` WHERE `company_name` LIKE '%".$keyword."%'";		
		//$result = Yii::app()->db->createCommand($query)->queryAll();
		$buildingDetails = array();
		$customerDetails  = array();
		$buildingDetails = Building::model()->findAll('name LIKE "%'.$keyword.'%"');
		$customerDetails = Customer::model()->findAll('company_name LIKE "%'.$keyword.'%"');
		if(isset($buildingDetails) && count($buildingDetails) > 0 && !empty($buildingDetails)){
			$this->render('searchedBuildingList',array('resultData'=>$buildingDetails));
		}else if(isset($customerDetails) && count($customerDetails) > 0 && !empty($customerDetails)){
			$this->render('searchedBuildingList',array('customerDetails'=>$customerDetails));
		}else if(empty($buildingDetails) && empty($customerDetails)){
			$this->render('searchedBuildingList',array('customerDetails'=>$customerDetails));
		}
	}
	
	public function actionFrontSearch(){
		$offset = (int)$_REQUEST['offset'];
		$limit = 20;
		
		$criteria = new CDbCriteria;
		$criteria->select = 't.*';
		$criteria->join ='INNER JOIN `floor` f ON t.building_id = f.building_id';
		$criteria->condition = 'f.show_frontend = :value';
		$criteria->params = array(":value" => "1");
		$criteria->group = 't.building_id';
		$criteria->order = 'f.modified_on DESC';
		
		$count= Building::model()->count($criteria);
		
		$pages = new CPagination($count);
		$pages->pageSize = $limit;
		$pages->applyLimit($criteria);
		
		$buildingDetails = Building::model()->findAll($criteria);
		
// 		echo '<pre>'; print_r($pages);die;
		$this->render('searchedBuildingList',array(
			'resultData'=>$buildingDetails, 
			'front_only' => true, 
			'item_count'=>$count,
			'page_size'=>$limit,
			'pages' => $pages
			
		));
	}
	
	public function actionMapKey(){
		$getAllKeys = GoogleMapApiKey::model()->findAll();
		$this->render('apiKeyList',array('allKeys'=>$getAllKeys));
	}
	
	public function actionSaveApiKey(){
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		
		$aKey = $_POST['key'];
		
		$model = new GoogleMapApiKey;
		$model->api_key = $aKey;
		$model->added_by = $logged_user_id;
		$model->added_on = date('Y-m-d H:i:s');
		$model->modified_by = $logged_user_id;
		$model->modified_on = date('Y-m-d H:i:s');
		
		$resp = array();
		if($model->save(false)){
			$resp = array('status'=>1,'msg'=>'キーが正常に変更されます。');
		}else{
			$resp = array('status'=>0);
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionRemoveApiKey(){
		$id = $_GET['id'];
		
		GoogleMapApiKey::model()->deleteByPk($id);
		$checkDetails = GoogleMapApiKey::model()->findByPk($id);
		if(count($checkDetails) == 0){
			$resp = array('status'=>1,'msg'=>'キーが正常に削除されました。');
		}else{
			$resp = array('status'=>0);
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionCheckOfficeAlert(){
		$officeAlertList = OfficeAlert::model()->findAll();
		foreach($officeAlertList as $officeAlert){
			echo "Alert ID = ".$officeAlert->office_alert_id."<br>";
			$getConditions = SearchSettings::model()->findByPk($officeAlert->cond_id);
			$cond = json_decode($getConditions->ss_json,true);
			print_r($cond);
		}
		
		$condBuildArray = array(			
			'buildingAge', //b
			'deadlineCheck', //b
			'walkFromStation', //b
			'hdnRRouteId', //b
			'buildingSearchAddressTxt', //b
			'buildingSearchAddress', //b
			'buildingSearchName', //b
			'buildingSearchId', //b
		);
		
		$condFloorArray = array(
			'areaMinValue', //f
			'areaMaxValue', //f
			'floorMin', //f
			'floorMax', //f
			'updateDateDrop', //f
			'brokerageFree', //f
			'unitMinValue', //f
			'unitMaxValue', //f
			'possibleDataMin', //f
			'possibleDataMax', //f
			'specifyCustomerName', //f
			'costMinAmount', //f
			'costMaxAmount', //f
			'statusRequirement', //f
			'requirementOfBuilding', //f
			'facilities', //f
			'floorType', //f
			'formTypeList', //f
			'lenderType', //f
			'shortRent', //f
			'floorSearchId', //f
			'floorSearchOwnerName' //f
		);
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
			echo "cartColor";
		}
		echo '';
	}
}