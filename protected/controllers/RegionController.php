<?php

class RegionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','changestatus','createOrUpdate','getRegionData'),
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->redirect(array('admin'));
		
		$model=new Region;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Region']))
		{
			$model->attributes=$_POST['Region'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->region_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Region']))
		{
			$model->attributes=$_POST['Region'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->region_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('admin'));
		
		$dataProvider=new CActiveDataProvider('Region');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Region('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Region']))
			$model->attributes=$_GET['Region'];
			
		$this->pageTitle = 'Region List | '.Yii::app()->params['name'];
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Region the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Region::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Region $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='region-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionCreateOrUpdate(){
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata,$getArray);
		
		$id = isset($getArray['id']) ? $getArray['id'] : '';		
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		
		if($id == '' || $id == 0){
			$regionName = $getArray['regionName'];
			$regionPrefecture = implode(',',$getArray['regionPrefecture']);
			
			$model = new Region;
			$model->region_name = $regionName;
			$model->prefectures = $regionPrefecture;
			$model->added_by = $logged_user_id;
			$model->added_on = date('Y-m-d H:i:s');
			$model->modified_by = $logged_user_id;
			$model->modified_on = date('Y-m-d H:i:s');
			if($model->save(false)){
				$resp = array('status'=>1);
			}			
		}else{
			$regionName = $getArray['upRegionName'];
			$regionPrefecture = implode(',',$getArray['regionUpPrefecture']);
			
			$regionDetails = Region::model()->findByPk($id);
			$regionDetails->region_name = $regionName;
			$regionDetails->prefectures = $regionPrefecture;
			$regionDetails->modified_by = $logged_user_id;
			$regionDetails->modified_on = date('Y-m-d H:i:s');
			if($regionDetails->save(false)){
				$resp = array('status'=>2);
			}
		}
		
		echo json_encode($resp);
		exit;
	}
	
	public function actionGetRegionData(){
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$regionDetails = Region::model()->findByPk($id);
		$resp = '<input type="hidden" name="id" id="id" value="'.$regionDetails['region_id'].'" />
				<input type="text" name="upRegionName" id="upRegionName" class="upRegionName form-input" placeholder="Region Name" value="'.$regionDetails['region_name'].'" required/>';
		$resp .= '<select name="regionUpPrefecture[]" id="regionUpPrefecture" class="regionUpPrefecture" multiple size="10">
					<option value="">- Select Prefecture -</option>';
                    $prefectureList = Prefecture::model()->findAlL();
					$prefectures = explode(',',$regionDetails['prefectures']);
                    if(isset($prefectureList) && count($prefectureList) > 0){
                        foreach($prefectureList as $prefecture){
							$selected = '';
							if(in_array($prefecture['prefecture_id'],$prefectures)){
								$selected = 'selected';
							}
            $resp .= '<option value="'.$prefecture["prefecture_id"].'"'.$selected.'>'.$prefecture["prefecture_name"].'</option>';
                    
                        }
                    }		
		echo json_encode($resp);
		exit;
	}
}
