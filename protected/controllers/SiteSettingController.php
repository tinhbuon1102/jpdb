<?php

class SiteSettingController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionChangeSiteDetails(){
		$companyNameId = $_REQUEST['companyNameId'];
		$companyName = $_REQUEST['companyName'];
		$companyDetails = SiteSetting::model()->findByPk($companyNameId);
		$companyDetails->value = $companyName;
		if($companyDetails->save(false)){
			$resp = array('status'=>1);
		}else{
			$resp = array('status'=>0);
		}
		echo json_encode($resp);
		die;
	}
}