<?php
class CustomerController extends Controller{
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','fullDetail','searchCustomer','searchCustomerList','changeCustomerReqInfo','saveCustomerReqInfo','getCustomerCSV','customerCloneArticles','updateCustomerInfo','saveCustomerUpdateInfo','offOfficeAlert','toggleAlertDisplay'),
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
		$this->layout="main";
		$inquiryTypeDetails = InquiryType::Model()->findAll('is_active = 1');
		$businessTypeDetails = BusinessType::Model()->findAll('is_active = 1');
		$customerSource = CustomerSource::Model()->findAll('is_active = 1');
		$introducer = Introducer::Model()->findAll('is_active = 1');
		$userAdmin = Users::Model()->findAll();

		$model=new Customer;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Customer'])){
			
			$model = new Customer();
			$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
			$logged_user_id = $user->user_id;			
			$model->attributes=$_POST['Customer'];
			
			$model->address = $_POST['Customer']['address'];
			$model->added_by = $logged_user_id;
			$model->added_on = date('Y-m-d H:i:s');
			$model->modified_by = $logged_user_id;
			$model->modified_on = date('Y-m-d H:i:s');
			$model->customerId = 'JPC'.mt_rand(10,99999);
			$model->company_reg_date = date('Y-m-d',strtotime($_POST['Customer']['company_reg_date']));
			$model->reason_of_contact = $_POST['Customer']['reasonToContact'];
			
			if($model->save()){
				$introducer = new Introducer();
				$introducer->introducer_name = $_POST['Customer']['company_name'];
				$introducer->added_by = $logged_user_id;
				$introducer->added_on = date('Y-m-d H:i:s');
				if($introducer->save(false)){
					$this->redirect(array('fullDetail','id'=>$model->customer_id));
					die;
					//http://teamgroovy.in/properties/index.php?r=customer/fullDetail&id=13
				}
			}
		}
		$this->render('create',array('model'=>$model,'inquiry_type_details'=>$inquiryTypeDetails,'businessTypeDetails'=>$businessTypeDetails,'customerSource'=>$customerSource,'userAdmin'=>$userAdmin,'introducer'=>$introducer));
	}  

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id){
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		
		$inquiryTypeDetails = InquiryType::Model()->findAll('is_active = 1');
		$businessTypeDetails = BusinessType::Model()->findAll('is_active = 1');
		$customerSource = CustomerSource::Model()->findAll('is_active = 1');
		$introducer = Introducer::Model()->findAll('is_active = 1');
		$userAdmin = Users::Model()->findAll('user_role = "a"');

		$model=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Customer'])){
			$model->attributes=$_POST['Customer'];
			$model->address = $_POST['Customer']['address'];
			$model->modified_by = $logged_user_id;
			$model->modified_on = date('Y-m-d H:i:s');
			if($model->save(false))
				$this->redirect(array('fullDetail','id'=>$model->customer_id));
				die;
		}

		$this->render('update',array('model'=>$model,'inquiry_type_details'=>$inquiryTypeDetails,'businessTypeDetails'=>$businessTypeDetails,'customerSource'=>$customerSource,'userAdmin'=>$userAdmin,'introducer'=>$introducer));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id){
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('searchCustomer'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex(){
		$dataProvider=new CActiveDataProvider('Customer');
		$this->render('index',array('dataProvider'=>$dataProvider,));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin(){
		$model=new Customer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];
		$this->render('admin',array('model'=>$model,));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Customer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id){
		$model=Customer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Customer $model the model to be validated
	 */
	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionFullDetail(){
		if(isset($_GET['id']) && $_GET['id'] != ''){
			$customerDetails=Customer::model()->findByPk($_GET['id']);
			$businessType = BusinessType::model()->findByPk($customerDetails->business_type_id);
			$customerSource = CustomerSource::model()->findByPk($customerDetails->customer_source_id);
			$customerReqDetails = CustomerRequirement::model()->find('customer_id = '.$customerDetails['customer_id']);
			$propertyType = PropertyType::model()->findAll('is_active = 1');
		}

		$a = Yii::app()->user->getState("searchconditionsession");
		$condReq = array();
		if($a)
			$condReq = json_decode($a,true);

		// print_r($condReq); die;
		
		
		$this->render('fullDetail',array('customerDetails'=>$customerDetails,'businessType'=>$businessType,'customerSource'=>$customerSource,'customerReqDetails'=>$customerReqDetails,'propertyType'=>$propertyType,'condReq'=>$condReq,
			));
	}

	public function actionSearchCustomer(){
		$user = Users::model()->findAll('user_role = "a"');
		$saleStaffList = array();
		foreach($user as $u){
			$userDetails = AdminDetails::model()->find('user_id = '.$u['user_id']);
			$saleStaffList[] = array('id'=>$userDetails['user_id'],'name'=>$userDetails['full_name']);
		}
		$customerSource = CustomerSource::model()->findAll();
		$propertyType = PropertyType::model()->findAll('is_active = 1');
		
		$this->render('searchCustomer',array('saleStaffList'=>$saleStaffList,'customerSource'=>$customerSource,'propertyType'=>$propertyType));
	}

	public function actionSearchCustomerList(){
		if(isset($_REQUEST['formdata']) && $_REQUEST['formdata']!= ''){
			$getString = $_REQUEST['formdata'];
			parse_str($getString, $getArray);
			$personInchagreForCustomer = '';
			if(isset($getArray['personInChargeforCustomer']) && count($getArray['personInChargeforCustomer']) > 0 && !empty($getArray['personInChargeforCustomer'])){
				$personInchagreForCustomer = implode(',',$getArray['personInChargeforCustomer']);
			}
			
			$companyName = $getArray['companyName'];
			
			$tel = $getArray['tel'];
			$email = $getArray['email'];
		    $personInCharge = $getArray['personInCharge'];
			$customerSource = $getArray['customerSource'];
			$customerRandId = $getArray['customerId'];
			$floorSpaceMin = $getArray['floorSpaceMin'];
			$floorSpaceMax = $getArray['floorSpaceMax'];
			$propertyTypeId =  $getArray['propertySort'];
			$property=CustomerRequirement::model()->findByAttributes(array('type_of_property'=>$propertyTypeId));
			$registerDateFrom = $getArray['registerDateFrom'] != '' ? date('Y-m-d',strtotime($getArray['registerDateFrom'])) : '';
			$registerDateTo = $getArray['registerDateTo'] != '' ? date('Y-m-d',strtotime($getArray['registerDateTo'])) : '';
			$customerSourceId = CustomerSource::model()->findByAttributes(array('source_name'=>$customerSource));
			$selectedCid  = '';
			if(isset($customerSourceId->customer_source_id ) && $customerSourceId->customer_source_id !=''){
				$selectedCid = $customerSourceId->customer_source_id;
			 }
			 $departMent = $getArray['departMent'];	
			 $queryString = "SELECT * FROM customer WHERE 1=1 ";
			 if(isset($personInchagreForCustomer) && $personInchagreForCustomer != ''){
				  $queryString .= " AND sales_staff_id IN (".$personInchagreForCustomer.")".' ';
			 }
			 if(isset($companyName) && $companyName != ''){
				  $queryString .=" AND company_name LIKE '%".$companyName."%'";
			 }
			 if(isset($personInCharge) && $personInCharge != ''){
				  $queryString .=" AND person_incharge_name LIKE '%".$personInCharge."%'";
			 }
			 if(isset($tel) && $tel != ''){
				  $queryString .=" AND phone_no LIKE '%".$tel."%'";
			 }
			 if(isset($selectedCid) && $selectedCid != ''){
				   $queryString .= "AND customer_source_id = ".$selectedCid;
			 }
			 if(isset($departMent) && $departMent != ''){
					 $queryString .=" AND department LIKE '%".$departMent."%'";	 
			 }
			 if(isset($email) && $email != ''){
					 $queryString .=" AND email LIKE '%".$email."%'"; 
			 }
			 if(isset($customerRandId)  &&  $customerRandId != ''){
					$queryString .="  AND customerId LIKE '%".$customerRandId."%'"; 
			 }
			 if(isset($registerDateFrom) &&  $registerDateFrom != '' && $registerDateTo  == '' ){
				$queryString .=" AND company_reg_date >= '".$registerDateFrom."'";
			 }
			 if(isset($registerDateFrom) && isset($registerDateTo) && $registerDateFrom !='' && $registerDateTo != ''){
				$queryString .=" AND company_reg_date  >=  '".$registerDateFrom."' AND company_reg_date <= '".$registerDateTo."'";
			 }
			 $queryString .= " order by customer_id desc";
			 
			 $searchResult = Yii::app()->db->createCommand($queryString)->queryAll();
			 if(isset($propertyTypeId) && $propertyTypeId  > 0){
				 if(isset($searchResult) &&  count($searchResult)> 0){
					 $newArray_property = $afterFilter = array();
					 foreach($searchResult as $search){
						 $queryString1 = 'select customer_id from  customer_requirement where customer_id = '.$search['customer_id']. ' AND type_of_property LIKE "%'.$propertyTypeId.'%"';
						$afterFilter[] = Yii::app()->db->createCommand($queryString1)->queryAll();
						$afterFilter = array_filter($afterFilter);
						if(isset($afterFilter) && count($afterFilter) > 0){
							for($i=0;$i<count($afterFilter);$i++){
								$newArray_property[$i] = $afterFilter[$i][0]['customer_id'];
								$newArray = $newArray_property;
							}
						}else{
							$newArray = array();
						}
					}
				}
			}else{
				if(isset($searchResult) && count($searchResult) > 0){
					for($i=0;$i<count($searchResult);$i++){
						$newArray[$i] = $searchResult[$i]['customer_id'];
					}
				}
			}
			if(isset($floorSpaceMin) && $floorSpaceMin != '' && isset($floorSpaceMax) &&  $floorSpaceMax != ''){
				if(isset($searchResult) &&  count($searchResult)> 0){
					$newArray_floor_min_max = array();
					foreach($searchResult as $search){
						$queryString2='select customer_id from  customer_requirement where customer_id = '.$search['customer_id'].' And floor_space_min >='.$floorSpaceMin.' And floor_space_max <= '.$floorSpaceMax;
						$after[] = Yii::app()->db->createCommand($queryString2)->queryAll();
						$after = array_filter($after);
						if(isset($after) && count($after) > 0){
							for($i=0;$i<count($after[0]);$i++){
								$newArray_floor_min_max[$i] = $after[0][$i]['customer_id'];
							}
						}else{
							$newArray = array();
						}
					}
				}else{
					if(isset($searchResult) && count($searchResult) > 0){
						for($i=0;$i<count($searchResult);$i++){
							$newArray[$i] = $searchResult[$i]['customer_id'];
						}
					}
				}
			}else{
				if(isset($floorSpaceMin) && $floorSpaceMin != '' && $floorSpaceMax == ''){
					if(isset($searchResult) && count($searchResult) > 0){
						$newArray_floor_min = array();
						foreach($searchResult as $search){
							$queryString2='select customer_id from  customer_requirement where customer_id = '.$search['customer_id'].' And floor_space_min >='.$floorSpaceMin;
							$after_min[] = Yii::app()->db->createCommand($queryString2)->queryAll();
							$after_min = array_filter($after_min);
							if(isset($after_min) && count($after_min) > 0){
								for($i=0;$i<count($after_min);$i++){
									$newArray_floor_min[$i] = $after_min[$i][0]['customer_id'];
									if(isset($floorSpaceMin) && $floorSpaceMin != '' && $floorSpaceMax == ''){
										$newArray = $newArray_floor_min;
									}
								}
							}else{
								$newArray = array();
							}
						}
					}else{
						if(isset($searchResult) && count($searchResult) > 0){
							for($i=0;$i<count($searchResult);$i++){
								$newArray[$i] = $searchResult[$i]['customer_id'];
							}
						}
					}
				}elseif(isset($floorSpaceMax) && $floorSpaceMax != '' && $floorSpaceMin == ''){
					if(isset($searchResult) && count($searchResult) > 0){
						$newArray_floor_min = array();
						foreach($searchResult as $search){
							$queryString2='select customer_id from  customer_requirement where customer_id = '.$search['customer_id'].' And floor_space_max <='.$floorSpaceMax;
							$after_min[] = Yii::app()->db->createCommand($queryString2)->queryAll();
							$after_min = array_filter($after_min);
							if(isset($after_min) && count($after_min) > 0){
								for($i=0;$i<count($after_min);$i++){
									$newArray_floor_min[$i] = $after_min[$i][0]['customer_id'];
									if(isset($floorSpaceMax) && $floorSpaceMax != '' && $floorSpaceMin == ''){
										$newArray = $newArray_floor_min;
									}
								}
							}else{
								$newArray = array();
							}
						}
					}
				}
			}
			if(isset($newArray_floor_min_max) && count($newArray_floor_min_max)> 0 && isset($newArray_property) && count($newArray_property) > 0){
				$newArray = array_unique( array_merge($newArray_floor_min_max, $newArray_property));
			}
			if(isset($newArray_floor_min) && count($newArray_floor_min)> 0 && isset($newArray_property) && count($newArray_property) > 0){
				if(isset($newArray_floor_min) && count($newArray_floor_min)> 0){
					$newArray = array_unique( array_merge($newArray_floor_min, $newArray_property));
				}
			}
			if(count($searchResult) == 0){
				$newArray = $searchResult;
			}
		}
		
		$result = array();
		$result = $this->renderPartial('userSearchList',array('newArray'=>$newArray),true);
		echo json_encode($result);die;
	}

	public function actionChangeCustomerReqInfo(){
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" && $_REQUEST['id'] != 0){
			$customerRequirement = CustomerRequirement::model()->findAll('customer_id = '.$_REQUEST['id']);
			$propertyType = PropertyType::model()->findAll('is_active = 1');
			if(isset($customerRequirement) && count($customerRequirement)>0){
				$customerRequirement = $customerRequirement;
			}else{
				$customerRequirement = array('id'=>$_REQUEST['id']);
			}
			$result = array();
			$result = $this->renderPartial('changeCustomerReqInfo',array('customerRequirement'=>$customerRequirement,'propertyType'=>$propertyType),true);
			echo json_encode($result);
			die;
		}
	}

	public function actionSaveCustomerReqInfo(){
		$getString = $_REQUEST['formdata'];
		parse_str($getString, $getArray);

		if(isset($getArray) && count($getArray) > 0){
			if(isset($getArray['customerId']) && $getArray['customerId'] != ''){
				$customerRequirementDetails = CustomerRequirement::model()->find('customer_id = '.$getArray['customerId']);
				if(isset($customerRequirementDetails) && count($customerRequirementDetails) > 0){
					$customerRequirementDetails->type_of_property = implode(',',$getArray['property_type']);
					$customerRequirementDetails->area = $getArray['area'];
					$customerRequirementDetails->area_group = $getArray['areaGroup'];
					$customerRequirementDetails->reason_for_area = $getArray['reason_for_area'];
					$customerRequirementDetails->move_in_date = $getArray['date_to_move_in'].'-'.$getArray['day_to_move_in'];
					$customerRequirementDetails->reason_of_moving =  $getArray['reason_for_moving'];
					$customerRequirementDetails->current_rent_unit_price_per_tsubo = $getArray['crrnt_rent_unit_price'];
					$customerRequirementDetails->current_number_of_tsubo = $getArray['crrnt_no_of_tusbo'];
					//$customerRequirementDetails->number_of_tsubo = $getArray['number_f_tsubo_min'].'-'.$getArray['number_f_tsubo_max'];
					$customerRequirementDetails->rent_price = $getArray['rent_price_hi'].'-'.$getArray['rent_price_low'];
					if(isset($getArray['notice_of_cancellation']) && $getArray['notice_of_cancellation']!=''){
						$customerRequirementDetails->notice_of_cancellation = $getArray['notice_of_cancellation'];
					}
					$customerRequirementDetails->parking = $getArray['parking'];
					$customerRequirementDetails->number_of_floor = $getArray['number_of_floor'];
					$customerRequirementDetails->estimated_sales_amount = $getArray['est_sale_amt'];
					$customerRequirementDetails->estimated_sales_date = $getArray['est_sale_date'];
					$customerRequirementDetails->comments = $getArray['comments'];
					$customerRequirementDetails->floor_space_min = $getArray['floor_space_min'];
					$customerRequirementDetails->floor_space_max = $getArray['floor_space_max'];
					$customerRequirementDetails->modified_on = date('Y-m-d H:i:s');	
					if($customerRequirementDetails->save(false)){
						$url = Yii::app()->createUrl('building/afterChangeCustomerInfo');
						$resp = array('status'=>1,'msg'=>'Customer Info Successfully Changed.','id'=>$getArray['customerId'],'url'=>$url);
					}else{
						$resp = array('status'=>0,'msg'=>'Something went wrong.');
					}
				}else{
					$customerRequirement = new CustomerRequirement();
					$customerRequirement->customer_id =   $getArray['customerId'];
					$customerRequirement->type_of_property = implode(',',$getArray['property_type']);
					$customerRequirement->area = $getArray['area'];
					$customerRequirement->area_group = $getArray['areaGroup'];
					$customerRequirement->reason_for_area = $getArray['reason_for_area'];
					$customerRequirement->move_in_date = $getArray['date_to_move_in'].'-'.$getArray['day_to_move_in'];
					$customerRequirement->reason_of_moving =  $getArray['reason_for_moving'];
					$customerRequirement->current_rent_unit_price_per_tsubo = $getArray['crrnt_rent_unit_price'];
					//$customerRequirement->current_number_of_tsubo = $getArray['crrnt_no_of_tusbo'];
					//$customerRequirement->number_of_tsubo = $getArray['number_f_tsubo_min'].'-'.$getArray['number_f_tsubo_max'];
					$customerRequirement->rent_price = $getArray['rent_price_hi'].'-'.$getArray['rent_price_low'];
					if(isset($getArray['notice_of_cancellation']) && $getArray['notice_of_cancellation']!=''){
						$customerRequirement->notice_of_cancellation = $getArray['notice_of_cancellation'];
					}
					$customerRequirement->parking = $getArray['parking'];
					$customerRequirement->number_of_floor = $getArray['number_of_floor'];
					$customerRequirement->estimated_sales_amount = $getArray['est_sale_amt'];
					$customerRequirement->estimated_sales_date = $getArray['est_sale_date'];
					$customerRequirement->comments = $getArray['comments'];
					$customerRequirement->floor_space_min = $getArray['floor_space_min'];
					$customerRequirement->floor_space_max = $getArray['floor_space_max'];
					$customerRequirement->modified_on = date('Y-m-d H:i:s');

					if($customerRequirement->save(false)){
						$url = Yii::app()->createUrl('building/afterChangeCustomerInfo');
						$resp = array('status'=>1,'msg'=>'Customer Info Successfully Changed.','id'=>$getArray['customerId'],'url'=>$url);
					}else{
						$resp = array('status'=>0,'msg'=>'Something went wrong.');
					}
				}
				echo json_encode($resp);
			}
		}
	}
	
	public function actionCustomerCloneArticles(){
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata,$getArray);
		$proposedArticleDetails = ProposedArticle::model()->findByPk($getArray['hdnProArticleId']);
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		$loguser_id = $users->user_id;
		
		$model = new ProposedArticle;
		$model->proposed_article_name = $getArray['proposedArticleName'];
		$model->building_id = $proposedArticleDetails['building_id'];
		$model->user_id = $loguser_id;
		$model->customer_id = $getArray['proposedCustomerName'];
		$model->proposed_article_rand_id = mt_rand(100000,9999999);
		$model->added_by = $loguser_id;
		$model->added_on = date('Y-m-d H:i:s');		

		if($model->save(false)){
			$url = Yii::app()->createUrl('proposedArticle/myProposedArticleList');
			$resp = array('status'=>1,'url'=>$url);
		}else{
			$resp = array('status'=>0);
		}
		echo json_encode($resp);
		die;
	}	

	public function actionGetCustomerCSV_1(){
		Yii::import('application.extensions.ECSVExport.ECSVExport');
		$customerDetails = Yii::app()->db->createCommand()
            ->select('*')
            ->from('customer')
            ->join('business_type','customer.business_type_id = business_type.business_type_id')
            ->join('customer_source', 'customer.customer_source_id = customer_source.customer_source_id')
			->join('introducer', 'customer.introducer_id = introducer.introducer_id')
			->join('inquiry_type', 'customer.inquiry_id = inquiry_type.inquiry_id')
			->join('users', 'customer.sales_staff_id = users.user_id')
            ->queryAll();
			
			foreach($customerDetails as $details){
				$customerData[] = array(
						'company_name'=>$details['company_name'],
						'company_name_kana'=>$details['company_name_kana'],
						'company_reg_date'=>date('d/m/Y',strtotime($details['company_reg_date'])),
						'president_name'=>$details['president_name'],
						'postal_code'=>$details['postal_code'],
						'address'=>$details['address'],
						'phone_no'=>$details['phone_no'],
						'fax_no'=>$details['fax_no'],
						'url'=>$details['url'],
						'Business'=>$details['business_name'],
						'number_of_emp'=>$details['number_of_emp'],
						'Customer Source'=>$details['source_name'],
						'Introducer'=>$details['introducer_name'],
						'Inquiry'=>$details['inquiry_name'],
						'note'=>$details['note'],
						'reason_of_contact'=>$details['reason_of_contact'],
						'person_incharge_name'=>$details['person_incharge_name'],
						'person_incharge_name_kana'=>$details['person_incharge_name_kana'],
						'position'=>$details['position'],
						'branch_name'=>$details['branch_name'],
						'person_phone_no'=>$details['person_phone_no'],
						'person_fax_no'=>$details['person_fax_no'],
						'cellphone_no'=>$details['cellphone_no'],
						'email'=>$details['email'],
						'department'=>$details['department'],
						'Sale Staff'=>$details['username'],
						'customerId'=>$details['customerId'],
					);
		}

		$filename = "customer_".date('Ymd')."_".time().".csv";
		$csv = new ECSVExport($customerData);
		$headers = array(
				'company_name'=>'Company Name',
				'company_name_kana'=>'Company Name Kana',
				'company_reg_date'=>'Company Reg Date',
				'president_name'=>'President Name',
				'postal_code'=>'Postal Code',
				'address'=>'Address',
				'phone_no'=>'Phone',
				'fax_no'=>'Fax',
				'url'=>'Website',
				'business_type_id'=>'Business',
				'number_of_emp'=>'Total Employees',
				'customer_source_id'=>'Customer Source',
				'introducer_id'=>'Introducer',
				'inquiry_id'=>'Inquiry',
				'note'=>'Note',
				'reason_of_contact'=>'Reason of Contact',
				'person_incharge_name'=>'Person Incharge',
				'person_incharge_name_kana'=>'Person Incharge Kana',
				'position'=>'Position',
				'branch_name'=>'Branch',
				'person_phone_no'=>'Person Contact',
				'person_fax_no'=>'Person Fax',
				'cellphone_no'=>'Person Cellphone',
				'email'=>'Email',
				'department'=>'Department',
				'sales_staff_id'=>'Sales Staff'
			);
		$csv->setHeaders($headers);
		$content = $csv->toCSV();
		Yii::app()->getRequest()->sendFile($filename, $content, "text/csv", false);
		die;
	}
	
	public function actionGetCustomerCSV(){
		Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator("Japan Properties")
                             ->setLastModifiedBy("Japan Properties")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Japan Properties")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
		
		$headers = array(
			'ID',
			'Company Name',
			'Company Name Kana',
			'registered date',
			'representative name',
			'postal code',
			'address',
			'tel',
			'fax',
			'url',
			'category of business',
			'employee',
			'customer source',
			'introducer',
			'note',
			'contact type',
			'person in charge',
			'position',
			'branch name',
			'department name',
			'tel of person',
			'fax of person',
			'cellphone',
			'email',
		);
		
		$row = '1';
		for($column = 0; $column <= count($headers); $column++){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $headers[$column]);
		}
		
		$customerDetails = Yii::app()->db->createCommand()
            ->select('*')
            ->from('customer')
            ->leftjoin('business_type','customer.business_type_id = business_type.business_type_id')
            ->leftjoin('customer_source', 'customer.customer_source_id = customer_source.customer_source_id')
			->leftjoin('introducer', 'customer.introducer_id = introducer.introducer_id')
			->leftjoin('users', 'customer.sales_staff_id = users.user_id')
            ->queryAll();
	
		foreach($customerDetails as $details){
			$customerData[] = array(
				$details['customerId'],
				$details['company_name'],
				$details['company_name_kana'],
				date('d/m/Y',strtotime($details['company_reg_date'])),
				$details['president_name'],
				$details['postal_code'],
				$details['address'],
				$details['phone_no'],
				$details['fax_no'],
				$details['url'],
				$details['business_name'],
				$details['number_of_emp'],
				$details['source_name'],
				$details['introducer_name'],
				$details['note'],
				$details['reason_of_contact'],
				$details['person_incharge_name'],
				$details['position'],
				$details['branch_name'],
				$details['department'],
				$details['person_phone_no'],
				$details['person_fax_no'],
				$details['cellphone_no'],
				$details['email']
			);
		}
		
		for($row = 2; $row <= count($customerData); $row++){
			for($j = 0; $j <= count($headers); $j++){
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($j)->setAutoSize(false);
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($j)->setWidth('30');
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j, $row, $customerData[$row-2][$j]);
			}
		}
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a clientâ€™s web browser (Excel5)
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment;filename="customer_'.date('Ymd').'_'.time().'.csv"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		 
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
		Yii::app()->end();
	}
	
	public function actionUpdateCustomerInfo(){
		//error_reporting(E_ALL);
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" && $_REQUEST['id'] != 0){
			$model = Customer::model()->findByPk($_REQUEST['id']);
			$introducer = Introducer::Model()->findAll('is_active = 1');
			$businessTypeDetails = BusinessType::Model()->findAll('is_active = 1');
			$customerSource = CustomerSource::Model()->findAll('is_active = 1');
			$userAdmin = Users::Model()->findAll('user_role = "a"');
			//$propertyType = PropertyType::model()->findAll('is_active = 1');
			$result = array();
			
			if(isset($_GET['type']) && $_GET['type'] == 1){
				$result = $this->renderPartial('formClient',array('model'=>$model,'introducer'=>$introducer,'businessTypeDetails'=>$businessTypeDetails,'customerSource'=>$customerSource,'userAdmin'=>$userAdmin),true);
			}
			if(isset($_GET['type']) && $_GET['type'] == 2){
				$result = $this->renderPartial('formContact',array('model'=>$model,'introducer'=>$introducer,'businessTypeDetails'=>$businessTypeDetails,'customerSource'=>$customerSource,'userAdmin'=>$userAdmin),true);
			}
			echo json_encode($result);
			die;
		}
	}
	
	public function actionSaveCustomerUpdateInfo(){
		$formData = $_POST['formdata'];
		parse_str($formData, $getArray);
		//$updateCustomerId = $_POST['updateCustomerId'];
		if(isset($getArray['Customer']) && !empty($getArray['Customer'])){
			$customerDetails = Customer::model()->findByPk($getArray['updateCustomerId']);
			if($getArray['type'] == 1){
				$customerDetails->company_name = $getArray['Customer']['company_name'];
				$customerDetails->company_name_kana = $getArray['Customer']['company_name_kana'];
				$customerDetails->company_reg_date = $getArray['Customer']['company_reg_date'];
				$customerDetails->president_name = $getArray['Customer']['president_name'];
				$customerDetails->postal_code = $getArray['Customer']['postal_code'];
				$customerDetails->address = $getArray['Customer']['address'];
				$customerDetails->phone_no = $getArray['Customer']['phone_no'];
				$customerDetails->fax_no = $getArray['Customer']['fax_no'];
				$customerDetails->url = $getArray['Customer']['url'];
				$customerDetails->business_type_id = $getArray['Customer']['business_type_id'];
				$customerDetails->customer_source_id = $getArray['Customer']['customer_source_id'];
				$customerDetails->introducer_id = $getArray['Customer']['introducer_id'];
				$customerDetails->note = $getArray['Customer']['note'];
				$customerDetails->reason_of_contact = $getArray['Customer']['reasonToContact'];
			}
			if($getArray['type'] == 2){
				$customerDetails->person_incharge_name = $getArray['Customer']['person_incharge_name'];
				$customerDetails->person_incharge_name_kana = $getArray['Customer']['person_incharge_name_kana'];
				$customerDetails->position = $getArray['Customer']['position'];
				$customerDetails->branch_name = $getArray['Customer']['branch_name'];
				$customerDetails->person_phone_no = $getArray['Customer']['person_phone_no'];
				$customerDetails->person_fax_no = $getArray['Customer']['person_fax_no'];
				$customerDetails->cellphone_no = $getArray['Customer']['cellphone_no'];
				$customerDetails->email = $getArray['Customer']['email'];
				$customerDetails->department = $getArray['Customer']['department'];
				$customerDetails->sales_staff_id = $getArray['Customer']['sales_staff_id'];
			}
			if($customerDetails->save(false)){
				$resp = array('status'=>1,'msg'=>'Customer Info Successfully Changed.');
			}
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionOffOfficeAlert(){
		$id = $_POST['officeAlertId'];
		$officeAlertDetails = OfficeAlert::model()->findByPk($id);
		if(isset($officeAlertDetails) && count($officeAlertDetails) > 0 && !empty($officeAlertDetails)){
			if($officeAlertDetails['is_off'] == 0){
				$officeAlertDetails->is_off = 1;
				if($officeAlertDetails->save(false)){
					$resp = array('status'=>1,'msg'=>'アラートが正常にオフになっています');
				}else{
					$resp = array('status'=>0,'msg'=>'何かが間違っていました。');
				}
			}else{
				$resp = array('status'=>0,'msg'=>'アラートはすでにオフになっています。');
			}
		}
		
		echo json_encode($resp);
		die;
	}
	
	public function actionToggleAlertDisplay(){
		$type = $_POST['type'];
		$resp = '';
		if($type == 1){
			$resp .= '<table class="market_update">';
						$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
						$logged_user_id = $user->user_id;
                        $query = 'SELECT * FROM `office_alert` where is_off = 0 AND user_id = '.$logged_user_id.' ORDER BY office_alert_id DESC LIMIT 16';
                        $officeAlertDetails = Yii::app()->db->createCommand($query)->queryAll();
                        if(isset($officeAlertDetails) && count($officeAlertDetails) && !empty($officeAlertDetails)){
                            foreach($officeAlertDetails as $officeAlert){
                                $salesDetails = AdminDetails::model()->find('user_id = '.$officeAlert['user_id']);
				$resp .= '<tr>
                            <td class="update_date">';
                                $customerDetails = Customer::model()->findByPk($officeAlert['customer_id']);
                                $days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
								$updateDate = '';
                                $day = array_search((date('D',strtotime($officeAlert['added_on']))), $days);
                                $updateDate = date('Y.m.d',strtotime($officeAlert['added_on']))."(".$day.")";
                                
                                /*$customerDetails = Customer::model()->findByPk($officeAlert['customer_id']);
                                $days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
                                $day = array_search((date('D',strtotime($officeAlert['added_on']))), $days);
                               	date('Y.m.d',strtotime($officeAlert['added_on']))."(".$day.")";*/
                  $resp .= $updateDate.'</td>
                            <td class="update_info"><span class="market_in"><a href="'.Yii::app()->createUrl('customer/fullDetail',array('id'=>$officeAlert['customer_id'])).'">'.$customerDetails['company_name'].'</a></span></td>
                            <td>';
                            $buildings = explode(',',$officeAlert['building_id']);
                            $allBuildings = Floor::model()->findAllByAttributes(array('building_id'=>$buildings,'vacancy_info'=>1));
                            $resp .= '<a href="'.Yii::app()->createUrl('customer/fullDetail',array('id'=>$officeAlert['customer_id'])).'">'.(count($buildings) > 1 ? count($buildings).'buildings' : count($buildings).'building').'
                            ('.(count($allBuildings) > 1 ? count($allBuildings).'floors' : count($allBuildings).'floor').')</a>
                            </td>
                            <td class="update_staff"><span class="see">'.Yii::app()->controller->__trans('Sales Staff').' : '.$salesDetails['full_name'].'</span></td>
                            <td class="update_setting">
                                <a href="'.Yii::app()->createUrl('customer/fullDetail',array('id'=>$officeAlert['customer_id'])).'">
                                    <span class="see pull-right">
                                        <img src="images/1461688113_Streamline-75.png" class="setting_img"/>'.Yii::app()->controller->__trans('Setting').'
                                    </span>
                                </a>
                            </td>
                       </tr>';
                            }
                        }
                    $resp .= '</table>';
					$arrayResp = array('status'=>true,'content'=>$resp);
		}else{
			$resp .= '<table class="market_update">';
                        $query = 'SELECT * FROM `office_alert` where is_off = 0 ORDER BY office_alert_id DESC LIMIT 16';
                        $officeAlertDetails = Yii::app()->db->createCommand($query)->queryAll();
                        if(isset($officeAlertDetails) && count($officeAlertDetails) && !empty($officeAlertDetails)){
                            foreach($officeAlertDetails as $officeAlert){
                                $salesDetails = AdminDetails::model()->find('user_id = '.$officeAlert['user_id']);
				$resp .= '<tr>
                            <td class="update_date">';
                                $customerDetails = Customer::model()->findByPk($officeAlert['customer_id']);
                                $days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
								$updateDate = '';
                                $day = array_search((date('D',strtotime($officeAlert['added_on']))), $days);
                               	$updateDate = date('Y.m.d',strtotime($officeAlert['added_on']))."(".$day.")";
                  $resp .= $updateDate.'</td>
                            <td class="update_info"><span class="market_in"><a href="'.Yii::app()->createUrl('customer/fullDetail',array('id'=>$officeAlert['customer_id'])).'">'.$customerDetails['company_name'].'</a></span></td>
                            <td>';
                            $buildings = explode(',',$officeAlert['building_id']);
                            $allBuildings = Floor::model()->findAllByAttributes(array('building_id'=>$buildings,'vacancy_info'=>1));
                            $resp .= '<a href="'.Yii::app()->createUrl('customer/fullDetail',array('id'=>$officeAlert['customer_id'])).'">'.(count($buildings) > 1 ? count($buildings).'buildings' : count($buildings).'building').'
                            ('.(count($allBuildings) > 1 ? count($allBuildings).'floors' : count($allBuildings).'floor').')</a>
                            </td>
                            <td class="update_staff"><span class="see">'.Yii::app()->controller->__trans('Sales Staff').' : '.$salesDetails['full_name'].'</span></td>
                            <td class="update_setting">
                                <a href="'.Yii::app()->createUrl('customer/fullDetail',array('id'=>$officeAlert['customer_id'])).'">
                                    <span class="see pull-right">
                                        <img src="images/1461688113_Streamline-75.png" class="setting_img"/>'.Yii::app()->controller->__trans('Setting').'
                                    </span>
                                </a>
                            </td>
                       </tr>';
                            }
                        }
                    $resp .= '</table>';
					$arrayResp = array('status'=>true,'content'=>$resp);
		}
		echo json_encode($arrayResp);
		die;
	}
}