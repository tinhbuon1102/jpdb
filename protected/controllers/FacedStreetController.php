<?php

class FacedStreetController extends Controller
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
				'actions'=>array('create','update','createOrUpdate','changestatus','getTypeData','updateList'),
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
	public function actionGetTypeData(){
		
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$typeDetails = FacedStreet::model()->findByPk($id);
		$resp = array('id'=>$typeDetails->faced_street_id,'parent_id'=>$typeDetails->parent_id,'label'=>$typeDetails->label);
		
		echo json_encode($resp);
		exit;
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
		
		$model=new FacedStreet;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FacedStreet']))
		{
			$model->attributes=$_POST['FacedStreet'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->faced_street_id));
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

		if(isset($_POST['FacedStreet']))
		{
			$model->attributes=$_POST['FacedStreet'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->faced_street_id));
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
		$data=$this->loadModel($id);
		if(count($data)>0){
			if($data['is_parent']==1){
				FacedStreet::model()->deleteAll('parent_id='.$id);
					
			}
			$data->delete();
		}

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
		$dataProvider=new CActiveDataProvider('FacedStreet');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FacedStreet('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FacedStreet']))
			$model->attributes=$_GET['FacedStreet'];
		
		$this->pageTitle = 'Faced Street List | '.Yii::app()->params['name'];
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionChangestatus(){
		$id = $_REQUEST['id'];
		$change_status = $_REQUEST['is_active'];
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
			
		$statusDetails = FacedStreet::model()->findByPk($id);
		
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
	public function actionCreateOrUpdate(){
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$label = $_POST['label'];
		$parentId = $_POST['parentId'];
		$is_parent=0;
		
		if($parentId==0){
			$is_parent=1;
		}
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		
		if($id == '' || $id == 0){
			$model = new FacedStreet;
			$model->label = $label;			
			$model->is_parent = $is_parent;	
			$model->parent_id = $parentId;	
			$model->added_by = $logged_user_id;
			$model->add_on = date('Y-m-d H:i:s');		
			if($model->save(false)){
				$resp = array('status'=>1);
			}			
		}else{
			$typeDetails = FacedStreet::model()->findByPk($id);
			$typeDetails->label = $label;	
			$typeDetails->is_parent = $is_parent;	
			$typeDetails->parent_id = $parentId;	
			$typeDetails->modified_by = $logged_user_id;
			$typeDetails->modified_on = date('Y-m-d H:i:s');
			if($typeDetails->save(false)){
				$resp = array('status'=>2);
			}
		}
		
		echo json_encode($resp);
		exit;
	}
	public function actionUpdateList(){
		$statusDetails = FacedStreet::model()->findAll('is_parent = 1');
		$list = '<select class="text-center" id="parentId" name="parent">
					<option value="0">--Please select main area--</option>';
					if(count($statusDetails)>0){
						foreach($statusDetails as $opt){
							$list .= '<option value="'.$opt->faced_street_id.'">'.$opt->label.'</option>';
						}
					}          
		$list .= '</select>';
		
		echo json_encode($list);
		exit;
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FacedStreet the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FacedStreet::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FacedStreet $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='faced-street-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
