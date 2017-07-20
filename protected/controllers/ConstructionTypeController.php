<?php

class ConstructionTypeController extends Controller
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
				'actions'=>array('create','update','changestatus','createOrUpdate','getTypeData'),
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
		
		$model=new ConstructionType;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ConstructionType']))
		{
			$model->attributes=$_POST['ConstructionType'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->construction_type_id));
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

		if(isset($_POST['ConstructionType']))
		{
			$model->attributes=$_POST['ConstructionType'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->construction_type_id));
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
		$dataProvider=new CActiveDataProvider('ConstructionType');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->pageTitle = 'Construction Type List';
		$model=new ConstructionType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ConstructionType']))
			$model->attributes=$_GET['ConstructionType'];

		
		$this->pageTitle = 'Construction Type List | '.Yii::app()->params['name'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ConstructionType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ConstructionType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ConstructionType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='construction-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionChangestatus(){
		$id = $_REQUEST['id'];
		$change_status = $_REQUEST['is_active'];
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
			
		$statusDetails = ConstructionType::model()->findByPk($id);
		
		$statusDetails->is_active = $change_status;
		$statusDetails->modified_on = date('Y-m-d H:i:s');
		$statusDetails->modified_by = $logged_user_id;
		
		if($statusDetails->save(false)){
			$resp = array('success'=>1);
			echo json_encode($resp);
			exit;
			//$this->redirect(array('admin'));
		}else{
			$resp = array('success'=>0);
			echo json_encode($resp);
			exit;
		}
	}
	
	public function actionGetTypeData(){
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$typeDetails = ConstructionType::model()->findByPk($id);
		$resp = array('id'=>$typeDetails->construction_type_id,'name'=>$typeDetails->construction_type_name);
		
		echo json_encode($resp);
		exit;
	}
	
	public function actionCreateOrUpdate(){
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$name = $_POST['name'];
		
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		
		if($id == '' || $id == 0){
			$model = new ConstructionType();
			$model->construction_type_name = $name;
			$model->added_by = $logged_user_id;
			//$model->modified_on = date('Y-m-d H:i:s');
			$model->added_on = date('Y-m-d H:i:s');
			if($model->save(false)){
				$resp = array('status'=>1);
			}			
		}else{
			$typeDetails = ConstructionType::model()->findByPk($id);
			$typeDetails->construction_type_name = $name;
			$typeDetails->modified_by = $logged_user_id;
			$typeDetails->modified_on = date('Y-m-d H:i:s');
			if($typeDetails->save(false)){
				$resp = array('status'=>2);
			}
		}
		
		echo json_encode($resp);
		exit;
	}
}
