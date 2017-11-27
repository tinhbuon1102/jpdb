<?php

class CompanyController extends Controller
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
				'actions'=>array('create','update', 'getCompanyData', 'createOrUpdate'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
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
	
	public function actionGetCompanyData(){	
		$id = $_REQUEST['id'];	
		$companyDetails = Company::model()->findByPk($id);
		$newArray = $companyDetails->attributes;	
		echo json_encode($newArray,true);	
		die;	
	}
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Company;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->company_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionCreateOrUpdate(){	
		if(isset($_POST['formdata'])){
			$getString = $_POST['formdata'];	
			parse_str($getString, $getArray);
			 $id = $getArray['id'];	
			 $name = $getArray['name'];
			 $address = $getArray['address'];
			 $address_en = $getArray['address_en'];
			 $phone = $getArray['phone'];	
			 $email = $getArray['email'];
			 $company_logo = $getArray['company_logo'];
		}
		else{
			extract($_POST);	
		}

		/*$uploadedFile=CUploadedFile::getInstance($model,'image');
		$fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
		$uploadedFile->saveAs(Yii::app()->basePath.'/../company_logo/'.$fileName);  // image will uplode to rootDirectory/company_logo/
		*/

		

		if($id != 0){	
			$companyDetails = Company::model()->findByPk($id);
			$companyDetails->name = $name;	
			$companyDetails->address = $address;	
			$companyDetails->address_en = $address_en;	
			$companyDetails->phone = $phone;	
			$companyDetails->email = $email;
			if(isset($_FILES['company_logo']['name']) && $_FILES['company_logo']['name']){
				$ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
	        	$fileName = md5(time().rand(1,1000)).".".$ext; 
	                    

				$sourcePath = $_FILES['company_logo']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = getcwd().DIRECTORY_SEPARATOR.'company_logo/'.$fileName; // Target path where file is to be stored
				// echo $targetPath; die;
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				$companyDetails->company_logo = 'company_logo/'.$fileName;
			
			}
			
			if($companyDetails->save(false)){	
				$resp = array('status'=>1,'msg'=>'Your data is successfully updated.','company_logo'=>$getString);	
			}else{	
				$resp = array('status'=>0,'msg'=>'Sorry, might be some error occurs. Try again !','company_logo'=>$getString);	
			}	
		}else{	
			$company = new Company;	
			$company->name = $name;	
			$company->address = $address;	
			$company->address_en = $address_en;	
			$company->phone = $phone;	
			$company->email = $email;
			if(isset($_FILES['company_logo']['name']) && $_FILES['company_logo']['name']){
				$ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
	        	$fileName = md5(time().rand(1,1000)).".".$ext; 
	                    

				$sourcePath = $_FILES['company_logo']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = getcwd().DIRECTORY_SEPARATOR.'company_logo/'.$fileName; // Target path where file is to be stored
				// echo $targetPath; die;
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				$company->company_logo = 'company_logo/'.$fileName;
			
			}
			
			// $company->company_logo = $company_logo;
			if($company->save(false)){	
				$resp = array('status'=>1,'msg'=>'Your data is successfully added.');
			}else{	
				$resp = array('status'=>0,'msg'=>'Sorry, might be some error occurs. Try again !');	
			}	
		}	
		echo json_encode($resp);
		die;	
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

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->company_id));
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
		$dataProvider=new CActiveDataProvider('Company');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$a = Company::model()->findByPk(610);
		// print_r($a); die;
		$model=new Company('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Company']))
			$model->attributes=$_GET['Company'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Company the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Company::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Company $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='company-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
