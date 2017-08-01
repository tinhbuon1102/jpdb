<?php
class BuildingPicturesController extends Controller{
	public function accessRules(){
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('uploadBuildingPicture','saveUploadedBuildPicture'),
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
	
	public function actionIndex(){
		$this->render('index');
	}

	public function actionUploadBuildingPicture(){
		if($_REQUEST['hdnUploadSection'] == 1){
			$images_path = realpath(Yii::app()->basePath . '/../buildingPictures/front');
		}elseif($_REQUEST['hdnUploadSection'] == 2){
			$images_path = realpath(Yii::app()->basePath . '/../buildingPictures/entrance');
		}elseif($_REQUEST['hdnUploadSection'] == 3){
			$images_path = realpath(Yii::app()->basePath . '/../buildingPictures/inFront');
		}else{
			$images_path = '';
		}
		$extractFile = explode('.',$_FILES['upl']['name']);	

		$randName = uniqid().".".end($extractFile);
		if(move_uploaded_file($_FILES['upl']['tmp_name'],$images_path . '/' . $randName)){
			$resp = array('name'=>$randName,'size'=>$_FILES['upl']['size']);
		}else{
			$resp = array('msg'=>'Something went wrong. File not upload.');
		}
		echo json_encode($resp);
	}	

	public function actionSaveUploadedBuildPicture(){
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata,$getArray);
		
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;	

		$buildingId = $getArray['hdnUpBuildId'];
		$totalPicture = $getArray['hdnFileNames'];
		$uploadSection = $getArray['hdnUploadSection'];		

		$pictureDetails = BuildingPictures::model()->find('building_id = '.$buildingId);
		if(isset($pictureDetails) && count($pictureDetails) > 0){
			if($uploadSection == 1){
				if($pictureDetails['front_images'] != ""){
					$pictureDetails->front_images = $pictureDetails['front_images'].','.$totalPicture;
				}else{
					$pictureDetails->front_images = $totalPicture;
				}
			}
			if($uploadSection == 2){
				if($pictureDetails['entrance_images'] != ""){
					$pictureDetails->entrance_images = $pictureDetails['entrance_images'].','.$totalPicture;
				}else{
					$pictureDetails->entrance_images = $totalPicture;
				}
			}
			if($uploadSection == 3){
				if($pictureDetails['in_front_building_images'] != ""){
					$pictureDetails->in_front_building_images = $pictureDetails['in_front_building_images'].','.$totalPicture;
				}else{
					$pictureDetails->in_front_building_images = $totalPicture;
				}
			}
			$pictureDetails->added_by = $logged_user_id;
			$pictureDetails->added_on = date('Y-m-d H:i:s');
			$buildingDetails = Building::model()->findByPk($buildingId);
			
			if($pictureDetails->save(false)){
				$changeLogModel = new BuildingUpdateLog;
				$changeLogModel->building_id = $buildingId;
				$changeLogModel->change_content = Yii::app()->controller->__trans('Building Picture info').' ('.$buildingDetails['prefecture'].')'.Yii::app()->controller->__trans('has been updated');
				$changeLogModel->added_by = $logged_user_id;
				$changeLogModel->added_on = date('Y-m-d H:i:s');
				if($changeLogModel->save(false)){
					$resp = array('status'=>1);
				}
			}
		}else{
			$model = new BuildingPictures();
			$model->building_id = $buildingId;
			if($uploadSection == 1){
				$model->front_images = $totalPicture;
			}
			if($uploadSection == 2){
				$model->entrance_images = $totalPicture;
			}
			if($uploadSection == 3){
				$model->in_front_building_images = $totalPicture;
			}
			$model->added_by = $logged_user_id;
			$model->added_on = date('Y-m-d H:i:s');			
			$buildingDetails = Building::model()->findByPk($buildingId);
			if($model->save(false)){
				$changeLogModel = new BuildingUpdateLog;
				$changeLogModel->building_id = $buildingId;				
				$changeLogModel->change_content = Yii::app()->controller->__trans('Building Picture info').' ('.$buildingDetails['prefecture'].')'.Yii::app()->controller->__trans('has been updated');
				$changeLogModel->added_by = $logged_user_id;
				$changeLogModel->added_on = date('Y-m-d H:i:s');
				if($changeLogModel->save(false)){
					$resp = array('status'=>1);
				}
			}
		}
		
		if ($resp['status'])
		{
			$floorID = $getArray['hdnFloorId'];
			$_REQUEST['id'] = $_GET['id'] = $floorID;
			
			$floorDetails = Floor::model()->findByPk($_REQUEST['id']);
			$buildingDetails = Building::model()->findByPk($floorDetails['building_id']);
			
			$this->pageTitle = $buildingDetails['name'].' | Japan Properties DB';
			$resp['html'] = $this->render('/building/singleBuildingDetails',array('floorDetails'=>$floorDetails,'buildingDetails'=>$buildingDetails), true);
		}
		
		echo json_encode($resp);
		die;
	}
	
	public function actionRemovePicture(){
		$buildingId = $_REQUEST['b_id'];
		$bImg = $_REQUEST['b_img'];
		$bType = $_REQUEST['b_type'];
		
		$buildingDetails = BuildingPictures::model()->find('building_id = '.$buildingId);
		if(isset($buildingDetails->{$bType}) && $buildingDetails->{$bType} != ''){
			$cImgs = explode(',',$buildingDetails->{$bType});
			
			if($bImg == $buildingDetails['main_image']){
				$buildingDetails->main_image = '';
			}
			
			if(($key = array_search($bImg, $cImgs)) !== false) {
				unset($cImgs[$key]);
			}
			$buildingDetails->{$bType} = implode(',',$cImgs);
			$buildingDetails->save(false);
		}
		echo json_encode(array('status'=>1));
	}
	
	public function actionSetMain(){
		$bID = $_REQUEST['b_id'];
		$mbId = $_REQUEST['b_mid'];
		$imgId = $_REQUEST['main_set'];
			
		$buildingDetails = BuildingPictures::model()->find('building_id = '.$bID);
		$cImgs = explode(',',$buildingDetails->front_images);

		$buildingDetails->main_image = $cImgs[$imgId];
		$buildingDetails->save(false);
		
// 		echo '<pre>'; 
// 		print_r($_POST);
// 		var_dump($imgId);
// 		print_r($cImgs);
// 		print_r($cImgs[$imgId]);
// 		print_r($buildingDetails);die;
		// BEGIN - Create wordpress building reference
		$wordpress = new Wordpress();
		$wordpress->processIntergrateWordpress($buildingDetails->building_id, Wordpress::BUILDING_TYPE, 'update');
		$wordpress->reGenerateLocations();
		// End - processing with wordpress
		
		$this->redirect(array('building/singleBuilding','id'=>$mbId));
		die;
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
?>