<?php
class FloorPicturesController extends Controller{
	public function accessRules(){
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
			'actions'=>array('index','view'),
			'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
			'actions'=>array('uploadFloorPicture','saveUploadedFloorPicture'),
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
	
	public function actionUploadFloorPicture(){
		if($_REQUEST['hdnUploadFloorSection'] == 1){
			$images_path = realpath(Yii::app()->basePath . '/../floorPictures/indoor');
		}elseif($_REQUEST['hdnUploadFloorSection'] == 2){
			$images_path = realpath(Yii::app()->basePath . '/../floorPictures/kitchen');
		}elseif($_REQUEST['hdnUploadFloorSection'] == 3){
			$images_path = realpath(Yii::app()->basePath . '/../floorPictures/bathroom');
		}elseif($_REQUEST['hdnUploadFloorSection'] == 4){
			$images_path = realpath(Yii::app()->basePath . '/../floorPictures/prospect');
		}elseif($_REQUEST['hdnUploadFloorSection'] == 5){
			$images_path = realpath(Yii::app()->basePath . '/../floorPictures/other');
		}elseif($_REQUEST['hdnUploadFloorSection'] == 6){
			$images_path = realpath(Yii::app()->basePath . '/../floorPictures/tenant');
		}else{
			$images_path = '';
		}

		$extractFile = explode('.',$_FILES['uplFloor']['name']);
		$randName = uniqid().".".end($extractFile);
		if(move_uploaded_file($_FILES['uplFloor']['tmp_name'],$images_path . '/' . $randName)){
			$resp = array('name'=>$randName,'size'=>$_FILES['uplFloor']['size']);
		}else{
			$resp = array('msg'=>'Something went wrong. File not upload.');
		}	

		echo json_encode($resp);
	}

	public function actionSaveUploadedFloorPicture(){
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata,$getArray);
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;	

		$buildingId = $getArray['hdnUpBuildId'];
		$totalPicture = $getArray['hdnFloorFileNames'];
		$uploadSection = $getArray['hdnUploadFloorSection'];
		$singleFloorId = $getArray['hdnSingleFloorId'];
		if($getArray['hdnMultiFloorId'] != 0 && $getArray['hdnMultiFloorId'] != ""){
			$multiFloorId = explode(',',$getArray['hdnMultiFloorId']);
		}else{
			$multiFloorId = array();
		}
		
		if(isset($multiFloorId) && count($multiFloorId) > 0 && !empty($multiFloorId)){
			foreach($multiFloorId as $singleFloorId){
				$pictureDetails = FloorPictures::model()->find('floor_id = '.$singleFloorId);
				if(isset($pictureDetails) && count($pictureDetails) > 0){
					if($uploadSection == 1){
						if($pictureDetails['indoor_image'] != ""){
							$pictureDetails->indoor_image = $pictureDetails['indoor_image'].','.$totalPicture;
						}else{
							$pictureDetails->indoor_image = $totalPicture;
						}
					}

					if($uploadSection == 2){
						if($pictureDetails['kitchen_image'] != ""){
							$pictureDetails->kitchen_image = $pictureDetails['kitchen_image'].','.$totalPicture;
						}else{
							$pictureDetails->kitchen_image = $totalPicture;
						}
					}

					if($uploadSection == 3){
						if($pictureDetails['bathroom_image'] != ""){
							$pictureDetails->bathroom_image = $pictureDetails['bathroom_image'].','.$totalPicture;
						}else{
							$pictureDetails->bathroom_image = $totalPicture;
						}
					}			

					if($uploadSection == 4){
						if($pictureDetails['prospect_image'] != ""){
							$pictureDetails->prospect_image = $pictureDetails['prospect_image'].','.$totalPicture;
						}else{
							$pictureDetails->prospect_image = $totalPicture;
						}
					}
					if($uploadSection == 5){
						if($pictureDetails['other_image'] != ""){
							$pictureDetails->other_image = $pictureDetails['other_image'].','.$totalPicture;
						}else{
							$pictureDetails->other_image = $totalPicture;
						}
					}
					
					if($uploadSection == 6){
						if($pictureDetails['tenant_list_image'] != ""){
							$pictureDetails->tenant_list_image = $pictureDetails['tenant_list_image'].','.$totalPicture;
						}else{
							$pictureDetails->tenant_list_image = $totalPicture;
						}
					}
					$pictureDetails->added_by = $logged_user_id;
					$pictureDetails->added_on = date('Y-m-d H:i:s');
										
					$buildingDetails = Building::model()->findByPk($buildingId);
					
					if($pictureDetails->save(false)){
						$changeLogModel = new BuildingUpdateLog;
						$changeLogModel->building_id = $buildingId;
						$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/singleBuilding',array('id'=>$id)).'">'.Yii::app()->controller->__trans('Floor info').' ('.$buildingDetails['prefecture'].')</a>'.Yii::app()->controller->__trans('has been updated');
						$changeLogModel->added_by = $logged_user_id;
						$changeLogModel->added_on = date('Y-m-d H:i:s');
						if($changeLogModel->save(false)){
							$resp = array('status'=>1);
						}
					}
				}else{
					$model = new FloorPictures();
					$model->building_id = $buildingId;
					$model->floor_id = $singleFloorId;
					if($uploadSection == 1){
						$model->indoor_image = $totalPicture;
					}
					if($uploadSection == 2){
						$model->kitchen_image = $totalPicture;
					}
					if($uploadSection == 3){
						$model->bathroom_image = $totalPicture;

					}
					if($uploadSection == 4){
						$model->prospect_image = $totalPicture;
					}
					if($uploadSection == 5){
						$model->other_image = $totalPicture;
					}
					if($uploadSection == 6){
						$model->tenant_list_image = $totalPicture;
					}
					$model->added_by = $logged_user_id;
					$model->added_on = date('Y-m-d H:i:s');					
					$buildingDetails = Building::model()->findByPk($buildingId);

					if($model->save(false)){
						$changeLogModel = new BuildingUpdateLog;
						$changeLogModel->building_id = $buildingId;
						$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/singleBuilding',array('id'=>$id)).'">'.Yii::app()->controller->__trans('Floor info').' ('.$buildingDetails['prefecture'].')</a>'.Yii::app()->controller->__trans('has been updated');
						$changeLogModel->added_by = $logged_user_id;
						$changeLogModel->added_on = date('Y-m-d H:i:s');
						if($changeLogModel->save(false)){
							$resp = array('status'=>1);
						}
					}
				}
			}
		}else{
			$pictureDetails = FloorPictures::model()->find('floor_id = '.$singleFloorId);
			if(isset($pictureDetails) && count($pictureDetails) > 0){
				if($uploadSection == 1){
					if($pictureDetails['indoor_image'] != ""){
						$pictureDetails->indoor_image = $pictureDetails['indoor_image'].','.$totalPicture;
					}else{
						$pictureDetails->indoor_image = $totalPicture;
					}
				}
				if($uploadSection == 2){
					if($pictureDetails['kitchen_image'] != ""){
						$pictureDetails->kitchen_image = $pictureDetails['kitchen_image'].','.$totalPicture;
					}else{
						$pictureDetails->kitchen_image = $totalPicture;
					}
				}
				if($uploadSection == 3){
					if($pictureDetails['bathroom_image'] != ""){
						$pictureDetails->bathroom_image = $pictureDetails['bathroom_image'].','.$totalPicture;
					}else{
						$pictureDetails->bathroom_image = $totalPicture;
					}
				}
				if($uploadSection == 4){
					if($pictureDetails['prospect_image'] != ""){
						$pictureDetails->prospect_image = $pictureDetails['prospect_image'].','.$totalPicture;
					}else{
						$pictureDetails->prospect_image = $totalPicture;
					}
				}
				if($uploadSection == 5){
					if($pictureDetails['other_image'] != ""){
						$pictureDetails->other_image = $pictureDetails['other_image'].','.$totalPicture;
					}else{
						$pictureDetails->other_image = $totalPicture;
					}
				}				
				if($uploadSection == 6){
					if($pictureDetails['tenant_list_image'] != ""){
						$pictureDetails->tenant_list_image = $pictureDetails['tenant_list_image'].','.$totalPicture;
					}else{
						$pictureDetails->tenant_list_image = $totalPicture;
					}
				}
				$pictureDetails->added_by = $logged_user_id;
				$pictureDetails->added_on = date('Y-m-d H:i:s');				
				$buildingDetails = Building::model()->findByPk($buildingId);

				if($pictureDetails->save(false)){
					$changeLogModel = new BuildingUpdateLog;
					$changeLogModel->building_id = $buildingId;
					$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/singleBuilding',array('id'=>$id)).'">'.Yii::app()->controller->__trans('Floor info').' ('.$buildingDetails['prefecture'].')</a>'.Yii::app()->controller->__trans('has been updated');
					$changeLogModel->added_by = $logged_user_id;
					$changeLogModel->added_on = date('Y-m-d H:i:s');
					if($changeLogModel->save(false)){
						$resp = array('status'=>1);
					}
				}
			}else{
				$model = new FloorPictures();
				$model->building_id = $buildingId;
				$model->floor_id = $singleFloorId;
				if($uploadSection == 1){
					$model->indoor_image = $totalPicture;
				}
				if($uploadSection == 2){
					$model->kitchen_image = $totalPicture;
				}
				if($uploadSection == 3){
					$model->bathroom_image = $totalPicture;
				}
				if($uploadSection == 4){
					$model->prospect_image = $totalPicture;
				}
				if($uploadSection == 5){
					$model->other_image = $totalPicture;
				}				
				if($uploadSection == 6){
					$model->tenant_list_image = $totalPicture;
				}
				$model->added_by = $logged_user_id;
				$model->added_on = date('Y-m-d H:i:s');				
				$buildingDetails = Building::model()->findByPk($buildingId);

				if($model->save(false)){
					$changeLogModel = new BuildingUpdateLog;
					$changeLogModel->building_id = $buildingId;
					$changeLogModel->change_content = '<a href="'.Yii::app()->createUrl('building/singleBuilding',array('id'=>$id)).'">'.Yii::app()->controller->__trans('Floor info').' ('.$buildingDetails['prefecture'].')</a>'.Yii::app()->controller->__trans('has been updated');
					$changeLogModel->added_by = $logged_user_id;
					$changeLogModel->added_on = date('Y-m-d H:i:s');
					if($changeLogModel->save(false)){
						$resp = array('status'=>1);
					}
				}
			}
		}
		echo json_encode($resp);
		die;
	}
}