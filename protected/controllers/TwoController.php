<?php
class TwoController extends Controller{
	public $layout='//layouts/main';
	
	public function filters(){
		return array(
				'accessControl', // perform access control for CRUD operations
				//'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function accessRules(){
		return array(
				
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('addProposedArticle','myProposedArticleList','deleteProposedArticle','filterArticles','cloneArticles','addArticleToCart','downloadAsExcel','testExcel','testPdf'),
				'users'=>array('@'),
			),
			
			array('deny',  // deny all users
					'users'=>array('*'),
			),
		);
	}
	
	public function actionTestPdf(){
		error_reporting(E_ALL);
		ini_set('display_erorrs','on');
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		
		$requestData = $_REQUEST;
		$propsedArticleId = $_REQUEST['hdnProArticlePdfId'];
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
		/*echo "<pre>";
		print_r($buildCartDetails);
		print_r($requestData);
		print_r($allFloorIds);*/
		
		# mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();
 
        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('utf-8', 'A5');
		
		$mPDF1->autoScriptToLang = true;
		$mPDF1->autoLangToFont = true;
 
        # render (full page)
        $mPDF1->WriteHTML($this->renderPartial('testForPdf',array('buildCartDetails'=>$buildCartDetails,'requestData'=> $requestData,'proposedFloors'=>$allFloorIds),true));
 
        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/custPdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
 
        # renderPartial (only 'view' of current controller)
        //$mPDF1->WriteHTML($this->renderPartial('testForPdf', array(), true));
 
        # Renders image
        //$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
 
        # Outputs ready PDF
        $mPDF1->Output();
		//$mPDF1->Output('proposed_article.pdf','F');
	}
	
	public function actionIndex(){
		$this->render('index');
	}
	
	public function actionAddProposedArticle(){
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata,$getArray);
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		$loguser_id = $users->user_id;
	
		$model = new ProposedArticle;
		$model->proposed_article_name = $getArray['proposedArticleName'];
		$model->building_id = $getArray['hdnCartBuildingId'];
		$model->floor_id = $getArray['hdnCartFloorId'];
		$model->user_id = $loguser_id;
		$model->customer_id = $getArray['proposedCustomerName'];
		$model->proposed_article_rand_id = mt_rand(100000,9999999);
		$model->search_cond = $getArray['hdnCartCond'];
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

	public function actionMyProposedArticleList(){
		
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
		$loguser_id = $users->user_id;
		$criteria = new CDbCriteria();
		$criteria->order = 'proposed_article_id DESC';
		$criteria->condition = 'user_id ='.$loguser_id;
		
		$item_count = ProposedArticle::model()->count($criteria);
		//$item_count = count($criteria);
		$pages = new CPagination($item_count);
		$pages->setPageSize(30);
		$pages->applyLimit($criteria);
		
		$this->render('index',array(
			'model'=> ProposedArticle::model()->findAll($criteria),
			'item_count'=>$item_count,
			'page_size'=>Yii::app()->params['listPerPage'],
			'items_count'=>$item_count,
			'pages'=>$pages,
		));
	}

	public function actionDeleteProposedArticle(){
		$proposedId = $_REQUEST['proposedId'];
		ProposedArticle::model()->deleteAll('proposed_article_id = '.$proposedId);
		$proposedArticleList = ProposedArticle::model()->findByPk($proposedId);
		if(isset($proposedArticleList) && count($proposedArticleList) > 0){
			$resp = array('status'=>0);
		}else{
			$resp = array('status'=>1);
		}
		echo json_encode($resp);
		die;
	}
	
	public function actionCloneArticles(){
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
		$model->floor_id = $proposedArticleDetails['floor_id'];
		$model->search_cond = $proposedArticleDetails['search_cond'];
		$model->proposed_article_rand_id = mt_rand(100000,9999999);
		$model->added_by = $loguser_id;
		$model->added_on = date('Y-m-d H:i:s');
		
		if($model->save(false)){
			if(isset($getArray['fromCustomer']) && $getArray['fromCustomer'] == 1){
				$url = Yii::app()->createUrl('customer/fullDetail',array('show'=>3,'id'=>$getArray['proposedCustomerName']));
			}else{
				$url = Yii::app()->createUrl('proposedArticle/myProposedArticleList');
			}
			$resp = array('status'=>1,'url'=>$url);
		}else{
			$resp = array('status'=>0);
		}
		echo json_encode($resp);
		die;
	}

	public function actionAddArticleToCart(){
		$proposedId = $_REQUEST['proposedId'];
		$proposedArticleDetails = ProposedArticle::model()->findByPk($proposedId);
		$buildingIds = explode(',',$proposedArticleDetails['building_id']);
		$floorDetails = Floor::model()->findAllByAttributes(array('building_id'=>$buildingIds));
		$floorIds = array();
		foreach($floorDetails as $floor){
			$cartModel = new Cart();
			$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
			$loguser_id = $user->user_id;
			$checkAvailable = Cart::model()->find('floor_id = '.$floor['floor_id'].' AND user_id = '.$loguser_id);
			if(count($checkAvailable) > 0){
				continue;
			}else{
				$cartModel->floor_id = $floor['floor_id'];
				$cartModel->building_id = $floor['building_id'];
				$cartModel->user_id = $loguser_id;
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
				$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name']. $floorDown." ~".$floorDetails['floor_up']."<span class='building-text-brk'>". $floorDetails['area_ping']." ".Yii::app()->controller->__trans('yen').($floorDetails['total_rent_price']+$floorDetails['unit_condo_fee'])."/".Yii::app()->controller->__trans('tsubo')."</span></span></a>";
				$resp .= "</div>";
			}else{
				$resp .= "<div class='min-white-box'>";
				$resp .= "<input type='hidden' name='cartId' class='cartId' id='cartId' value='".$cartList['cart_id']."'/>";
				$resp .= "<div class='btnRemoveFromCart'><i class='fa fa-times'></i></div>";
				$resp .= "<img src='".$pic."' class='head-img'/>";
				$resp .= "<a href=".Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id']))."><span class='building-text'>".$buildingDetails['name']. $floorDown." ~".$floorDetails['floor_up']."<span class='building-text-brk'>".$floorDetails['area_ping']." ".Yii::app()->controller->__trans('yen').($floorDetails['total_rent_price']+$floorDetails['unit_condo_fee'])."/".Yii::app()->controller->__trans('tsubo')."</span></span></a>";
				$resp .= "</div>";
			}
			$i++;
		}
		$result = array('count'=>$itemCount,'respData'=>$resp);
		echo json_encode($result);
		die;
	}

	public function actionFilterArticles(){
		$formdata = $_REQUEST['formdata'];
		parse_str($formdata,$getArray);
		$proposedArticleList = array();
		if(isset($getArray['proposedUsername']) && isset($getArray['filterByDate'])){
			$monthOfDate = date('m',strtotime($getArray['filterByDate']));
			$filterUserId = $getArray['proposedUsername'];
			
			
			if($getArray['filterByDate'] != "" && $getArray['proposedUsername'] != ""){
				if($getArray['filterByDate'] != "" && $getArray['proposedUsername'] == 0){
					$proposedArticleList = ProposedArticle::model()->findAll('date_format(added_on, "%m")='.$monthOfDate);
				}elseif($getArray['proposedUsername'] != "" && $getArray['filterByDate'] == 0){
					$proposedArticleList = ProposedArticle::model()->findAll('user_id = '.$filterUserId);
				}else{
					$proposedArticleList = ProposedArticle::model()->findAll('user_id = '.$filterUserId.' AND date_format(added_on, "%m")='.$monthOfDate);
				}
			}
		}
		if(isset($getArray['customerName'])){
			$customerName = $getArray['customerName'];
			$query = 'SELECT * from proposed_article LEFT JOIN customer ON customer.customer_id=proposed_article.customer_id WHERE company_name LIKE "%'.$customerName.'%"';
			$proposedArticleList = Yii::app()->db->createCommand($query)->queryAll();
		}
		$result = array();

		$result = $this->renderPartial('_fliterProposedList',array('proposedArticleList'=>$proposedArticleList),true);
		$resp = array('result'=>$result,'count'=>count($proposedArticleList));
		echo json_encode($resp);
		die;
	}
	
	public function actionGetcustomers(){
		$customers = array();
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		if(isset($_REQUEST['q'])){
			$customerList = Customer::model()->findAll(array("condition"=>"company_name like '%".$_REQUEST['q']."%'"));
		}else{
			$customerList = Customer::model()->findAll();
		}
		if(isset($customerList) && count($customerList) > 0){
			foreach($customerList as $customer){
				$customers[] = array('id'=>$customer['customer_id'],'text'=>$customer['company_name']);
			}
		}
								
		echo json_encode($customers); exit;
	}
	
	public function actionDownloadAsExcel(){
		$this->layout = '';
		$id =58;
		$proposedArticleDetails = ProposedArticle::model()->findByPk($id);
		$cArray = array(
				0 => 'ビル名',
				1 => '住所',
				2 => '最寄り駅',
				3 => '竣工',
				4 => '募集階',
				5 => '契約面積',
				6 => '入居日',
				7 => '賃料　単価',
				8 => '共益費　単価',
				9 => '月額賃料',
				10 => '月額共益費',
				11 => '月総額',
				12 => '敷金・保証金',
				13 => '更新料',
				14 => 'その他費用　　　（礼金、償却）',
				15 => '契約形態　(年数）',
				16 => 'フリーレント',
				17 => '契約期間内総額',
				18 => '期間内実質坪単価',
				19 => '期間内実質月額',
				20 => '写真',
				21 => '平面図',
				22 => '床仕様',
				23 => '空調',
				24 => '天井高',
				25 => '駐車場',
				26 => 'その他'
				);
		
		if(isset($proposedArticleDetails) && count($proposedArticleDetails) > 0){
			$buildingIds = explode(',',$proposedArticleDetails['building_id']);
			$floorIds = explode(',',$proposedArticleDetails['floor_id']);
			
			/*echo "<pre>";
			print_r($buildingIds);*/
			
			$buildingDetails = array();
			$finalArray = array();
			if(isset($buildingIds) && count($buildingIds) > 0){
				foreach($buildingIds as $bId){
					$buildingDetails[] = Building::model()->findByPk($bId);
				}
				//print_r($buildingDetails);
				$i = 0;
				foreach($buildingDetails as $build){
					$buildingName = isset($build['name']) && $build['name'] != "" ? $build['name'] : "";
					$buildingAddress = isset($build['address']) && $build['address'] != "" ? $build['address'] : "";
					$nearestSt = BuildingStation::model()->getNearestStation($build['building_id']);
					if(isset($nearestSt['name']) && isset($nearestSt['time'])){
						$nearestStName = $nearestSt['name'].' 駅 '.$nearestSt['time'].' 分';
					}
					$buildingYear = isset($build['built_year']) && $build['built_year'] != "" ? $build['built_year'] : "";
					$buildingArea = isset($build['std_floor_space']) && $build['std_floor_space'] != "" ? $build['std_floor_space'].' 坪' : "";
					$allFloors = Floor::model()->findAll('vacancy_info = 1 AND building_id = '.$build['building_id']);
					$floorLevels = '';
					$i = 0;
					foreach($allFloors as $flooLevel){
						if($i == count($allFloors) - 1){
							$sls = '';
						}else{
							$sls = '/';
						}
						if(isset($flooLevel['floor_down']) && $flooLevel['floor_down'] != ""){
							if(strpos($flooLevel['floor_down'], '-') !== false){
								$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $flooLevel['floor_down']);
							}else{
								$floorDown = $flooLevel['floor_down'];
							}									
							if(isset($flooLevel['floor_up']) && $flooLevel['floor_up'] != ''){
								$floorLevels .= $floorDown.' - '.$flooLevel['floor_up'].' '.Yii::app()->controller->__trans('階').''.$sls;
							}else{
								$floorLevels .= $floorDown.' '.Yii::app()->controller->__trans('階').''.$sls;
							}
						}
						$i++;
					}
					
					// building free rent
					$freeRent = FreeRent::model()->findAll('building_id = '.$build['building_id'].' ORDER BY free_rent_id DESC');
					$buildingFreeRent = isset($freeRent->free_rent_month) && $freeRent->free_rent_month != "" ? $freeRent->free_rent_month : "";
					
					// building picture
					$buildPics = BuildingPictures::model()->find('building_id = '.$build['building_id']);
					$main_img = $buildPics['main_image'];
					if($main_img != ""){
						$buildPics = 'front/'.$main_img;
					}else{
						$buildPics = explode(',',$buildPics['front_images']);
						$buildPics = 'front/'.$buildPics[0];
					}
					
					if($buildPics == "front/"){
						$buildPics = 'noimg_building.png';
					}
					
					$buildingImage = '<img src="'.Yii::app()->baseUrl.'/buildingPictures/'.$buildPics.'" />';
					
					// building ceiling height
										
					$finalArray[] = array($buildingName,$buildingAddress,$nearestStName,$buildingYear,$floorLevels,$buildingArea,'','','','','','','','',$buildingFreeRent,'','','',$buildingImage,'','','','','','');
				}				
			}
		}
		/*print_r($finalArray);
		die;*/
		
		/*echo "<pre>";
		print_r($finalArray);
		die;*/
		
		
		//$cData = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26');
		//$tData = array('0'=>$cData,'1'=>$cData,'2'=>$cData,'3'=>$cData,'4'=>$cData,'5'=>$cData,'6'=>$cData,'7'=>$cData,'8'=>$cData,'9'=>$cData,'10'=>$cData,'11'=>$cData,'12'=>$cData,'13'=>$cData,'15'=>$cData);
		//Yii::import('application.components.PHPExcel');
		//$this->render('pTable',array('data'=>$finalArray));
		//die;
		/*$output = '';
		$output .= '<table>
						<tr>
							<th style="background:#ccc;color:#fff;">Name</th>
							<th style="background:#ccc;color:#fff;">Age</th>
						</tr>';
					for($i=1;$i<=20;$i++){
			$output .= '<tr>
							<td>丸の内ビル '.$i.'</td>
							<td>'.(20+$i).'</td>
						</tr>';
					}
		$output .= '</table>';
		header('Content-Type: application/xls');
		header('Content-Disposition: attachment; filename=test.xls');
		echo $output;*/
		
		$output = '';
		$output .= '<table border="1">';
						foreach($cArray as $k=>$v){
			$output .= '<tr>
							<td style="background:#003366;color:#fff;">'.$v.'</td>';
							foreach($finalArray as $key => $val){
				$output .= '<td style="background:#99ccff;">'.$val[$k].'</td>';
							}
			$output .= '</tr>';
						}
		$output .= '</table>';
			
			
		header('Content-Type: application/xls');
		header('Content-Disposition: attachment; filename=test.xls');
		echo $output;
	}
	
	public function actionTestExcel(){
		Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator("Japan Properties")
                             ->setLastModifiedBy("Japan Properties")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Japan Properties")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
	
		//Add some data
		$cArray = array(
					0 => 'ビル名',
				1 => '住所',
				2 => '最寄り駅',
				3 => '竣工',
				4 => '募集階',
				5 => '契約面積',
				6 => '入居日',
				7 => '賃料　単価',
				8 => '共益費　単価',
				9 => '月額賃料',
				10 => '月額共益費',
				11 => '月総額',
				12 => '敷金・保証金',
				13 => '更新料',
				14 => 'その他費用　　　（礼金、償却）',
				15 => '契約形態　(年数）',
				16 => 'フリーレント',
				17 => '契約期間内総額',
				18 => '期間内実質坪単価',
				19 => '期間内実質月額',
				20 => '写真',
				21 => '平面図',
				22 => '床仕様',
				23 => '空調',
				24 => '天井高',
				25 => '駐車場',
				26 => 'その他'
				);

		$id = 58;
		$proposedArticleDetails = ProposedArticle::model()->findByPk($id);		
		if(isset($proposedArticleDetails) && count($proposedArticleDetails) > 0){
			$buildingIds = explode(',',$proposedArticleDetails['building_id']);
			$floorIds = explode(',',$proposedArticleDetails['floor_id']);
			
			$floorDetails = array();
			$finalArray = array();
			if(isset($floorIds) && count($floorIds) > 0){
				foreach($floorIds as $fId){
					$floorDetails[] = Floor::model()->findByPk($fId);
				}
				$i = 0;
				foreach($floorDetails as $floor){
					$buildingDetails = Building::model()->findByPk($floor['building_id']);
					//building name
					$buildingName = isset($buildingDetails['name']) && $buildingDetails['name'] != "" ? $buildingDetails['name'] : "";
					
					//building address
					$buildingAddress = isset($buildingDetails['address']) && $buildingDetails['address'] != "" ? $buildingDetails['address'] : "";
					
					//nearest station
					$nearestSt = BuildingStation::model()->getNearestStation($floor['building_id']);
					if(isset($nearestSt['name']) && isset($nearestSt['time'])){
						$nearestStName = $nearestSt['name'].' 駅 '.$nearestSt['time'].' 分';
					}
					
					//building built year
					$buildingYear = isset($buildingDetails['built_year']) && $buildingDetails['built_year'] != "" ? $buildingDetails['built_year'] : "";
					
					//floor level
					$floorLevels  = '';
					if(isset($floor['floor_down']) && $floor['floor_down'] != ""){
						if(strpos($floor['floor_down'], '-') !== false){
							$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
						}else{
							$floorDown = $floor['floor_down'];
						}
						if(isset($floor['floor_up']) && $floor['floor_up'] != ''){
							$floorLevels = $floorDown.' - '.$floor['floor_up'].' '.Yii::app()->controller->__trans('階');
						}else{
							$floorLevels = $floorDown.' '.Yii::app()->controller->__trans('階');
						}
					}
					
					//area
					$buildingArea = isset($buildingDetails['std_floor_space']) && $buildingDetails['std_floor_space'] != "" ? $buildingDetails['std_floor_space'].'xxxxxxxx坪' : "";
					
					//floor date to move in
					$floorMoveInDate = isset($floor['move_in_date']) && $floor['move_in_date'] != "" ? $floor['move_in_date'] : "";
					
// 					echo '<pre>'; print_r($floor);die;
					//rent unit price
					$floorRentUnitPrice = '';
					if($floor['rent_unit_price_opt']){
						if($floor['rent_unit_price_opt'] == -1){
							$floorRentUnitPrice = Yii::app()->controller->__trans('undecided');
						}else if($floor['rent_unit_price_opt'] == -2){
							$floorRentUnitPrice = Yii::app()->controller->__trans('ask');
						}
					}else{
						if(isset($floor['rent_unit_price']) && $floor['rent_unit_price']){
							$floorRentUnitPrice = Yii::app()->controller->renderPrice($floor['rent_unit_price'], true);//.Yii::app()->controller->__trans('yen / tsubo');
						}else{
							$floorRentUnitPrice = '-';
						}
					}
					
					//unit condo price
					$floorUnitCondoPrice = '';
					if(!$floor['unit_condo_fee']){
						if($floor['unit_condo_fee_opt'] == 0){
							$floorUnitCondoPrice = Yii::app()->controller->__trans('none');
						}else if($floor['unit_condo_fee_opt'] == -1){
							$floorUnitCondoPrice = Yii::app()->controller->__trans('undecided');
						}else if($floor['unit_condo_fee_opt'] == -2){
							$floorUnitCondoPrice = Yii::app()->controller->__trans('ask');
						}else if($floor['unit_condo_fee_opt'] == -3){
							$floorUnitCondoPrice = '賃料に込み<br/>(含む)';
						}
					}else{
						if(isset($floor['unit_condo_fee']) && $floor['unit_condo_fee'] != ""){
							$floorUnitCondoPrice = Yii::app()->controller->renderPrice($floor['unit_condo_fee'], true);//.Yii::app()->controller->__trans('yen / tsubo').')';
						}else{
							$floorUnitCondoPrice = '-';
						}
					}
					
					//floor total rent price per month
					$floorRentPriceMonth = Yii::app()->controller->renderPrice($floor['total_rent_price'], true);
					
					//floor condo price per month
					$floorCondoPriceMonth = Yii::app()->controller->renderPrice($floor['total_condo_fee']);
					
					//floor total fee per month
					$floorTotalFeePerMonth = Yii::app()->controller->renderPrice($floor['total_condo_fee'] + $floor['total_rent_price']);
					
					//floor deposit
					$floorDeposit = '';
					if($floor['deposit_opt'] != ''){
						if($floor['deposit_opt'] == -1){
							$floorDeposit = Yii::app()->controller->__trans('undecided');
						}else if($floor['deposit_opt'] == -3){
							$floorDeposit = Yii::app()->controller->__trans('none');
						}else if($floor['deposit_opt'] == -2){
							$floorDeposit = Yii::app()->controller->__trans('undecided･ask');
						}
					}
					if(isset($floor['deposit_month']) &&  $floor['deposit_month'] != ''){
						$floorDeposit .= $floor['deposit_month'].' ヶ月';
					}
					if($floor['total_deposit']){
						$floorDeposit .= '-'.Yii::app()->controller->renderPrice($floor['total_deposit']);;
					}
					
					//floor other fees
					$floorOtherFees = '';
					$floorKeyMoney = '';
					if(isset($floor['key_money_opt']) && $floor['key_money_opt'] != ""){
						if($floor['key_money_opt'] == 2){
							$floorKeyMoney = Yii::app()->controller->__trans('None');
						}elseif($floor['key_money_opt'] == -1){
							$floorKeyMoney = Yii::app()->controller->__trans('Unknown');
						}elseif($floor['key_money_opt'] == -2){
							$floorKeyMoney = Yii::app()->controller->__trans('undecided･ask');
						}else{
							$floorKeyMoney = '';
						}
					}else{
						$floorKeyMoney = '';
					}
					
					if(isset($floor['key_money_month']) && $floor['key_money_month'] != ""){
						$floorKeyMoney .= '     '.$floor['key_money_month'].Yii::app()->controller->__trans('month');
					}
					
					$floorAmortization = '';
					if(isset($floor['repayment_opt']) && $floor['repayment_opt'] != ""){
						if($floor['repayment_opt'] == -3){
							$floorAmortization = Yii::app()->controller->__trans('None')."<br>"; 
						}elseif($floor['repayment_opt'] == -4){
							$floorAmortization = Yii::app()->controller->__trans('Unknown')."<br>"; 
						}elseif($floor['repayment_opt'] == -1){
							$floorAmortization = Yii::app()->controller->__trans('Undecided')."<br>"; 
						}elseif($floor['repayment_opt'] == -2){
							$floorAmortization = Yii::app()->controller->__trans('Ask')."<br>"; 
						}elseif($floor['repayment_opt'] == -5){
							$floorAmortization = Yii::app()->controller->__trans('Sliding')."<br>"; 
						}else{
							$floorAmortization = '';
						}
					}
					
					if(isset($floor['repayment_reason']) && $floor['repayment_reason'] != ""){
						if($floor['repayment_reason'] == 1){
							$floorAmortization .= '     '.Yii::app()->controller->__trans('現賃料の')."<br>"; 
						}elseif($floor['repayment_reason'] == 2){
							$floorAmortization .= '     '.Yii::app()->controller->__trans('解約時賃料の')."<br>"; 
						}else{
							$floorAmortization .= '';
						}
					}
					
					if(isset($floor['repayment_amt']) && $floor['repayment_amt'] != ""){
						$floorAmortization .= '     '.$floor['repayment_amt'];
					}
					
					if(isset($floor['repayment_amt_opt']) && $floor['repayment_amt_opt'] != ""){
						if($floor['repayment_amt_opt'] == 1){
							$floorAmortization .= '     '.Yii::app()->controller->__trans('ヶ月'); 
						}elseif($floor['repayment_amt_opt'] == 2){
							$floorAmortization .= Yii::app()->controller->__trans('%')."<br>"; 
						}else{
							$floorAmortization .= '     '.'';
						}
					}

					$floorOtherFees = $floorKeyMoney.'xxxxxxxx'.$floorAmortization;
						
					//floor renewal fee
					$floorRenewalFee = '';
					if(isset($floor['renewal_fee_opt']) && $floor['renewal_fee_opt'] != ""){
						if($floor['renewal_fee_opt'] == 2){
							$floorRenewalFee = Yii::app()->controller->__trans('None'); 
						}elseif($floor['renewal_fee_opt'] == -1){
							$floorRenewalFee = Yii::app()->controller->__trans('Unknown'); 
						}elseif($floor['renewal_fee_opt'] == -2){
							$floorRenewalFee = Yii::app()->controller->__trans('Undecided･ask'); 
						}else{
							$floorRenewalFee = '';
						}
					}
					
					if(isset($floor['renewal_fee_reason']) && $floor['renewal_fee_reason'] != ""){
						if($floor['renewal_fee_reason'] == 1){
							$floorRenewalFee .= '     '.Yii::app()->controller->__trans('現賃料の'); 
						}elseif($floor['renewal_fee_reason'] == 2){
							$floorRenewalFee .= '     '.Yii::app()->controller->__trans('新賃料の'); 
						}else{
							$floorRenewalFee .= '';
						}
					}
					
					if(isset($floor['renewal_fee_recent']) && $floor['renewal_fee_recent'] != ""){
						$floorRenewalFee .= '     '.$floor['renewal_fee_recent'].Yii::app()->controller->__trans('month');

					}

					
					//contractual life
					$floorContractualLife = '';
					if(isset($floor['contract_period_opt']) && $floor['contract_period_opt'] != ""){
						if($floor['contract_period_opt'] == 1){
							$floorContractualLife = '普通借家';
						}elseif($floor['contract_period_opt'] == 2){
							$floorContractualLife = '定借';
						}elseif($floor['contract_period_opt'] == 3){
							$floorContractualLife = '定借希望';
						}else{
							$floorContractualLife = '-';
						}
					}else{
						$floorContractualLife = '-';
					}
					if(isset($floor['contract_period_optchk']) && $floor['contract_period_optchk'] == 1){
						$floorContractualLife .= '     年数相談';
					}
					if(isset($floor['contract_period_duration']) && $floor['contract_period_duration'] != ''){
						$floorContractualLife = '普通借家'.$floor['contract_period_duration'].'年';
					}
				
					//floor free rent
					$freeRent = FreeRent::model()->find('allocate_floor_id = '.$floor['floor_id'].' ORDER BY free_rent_id DESC');
					$buildingFreeRent = isset($freeRent->free_rent_month) && $freeRent->free_rent_month != "" ? $freeRent->free_rent_month.'xxxxxxxx'.$freeRent->expiration_date : "";
					
					//floor total fee in contract
					$floorTotalFeeContract = '';
					
					//floor unit price in contract
					$floorUnitPriceContract = '';
					
					//floor fee per month in contract
					$floorFeePerMonthContract = '';
					
					// building picture
					$buildPics = BuildingPictures::model()->find('building_id = '.$floor['building_id']);
					$main_img = $buildPics['main_image'];
					if($main_img != ""){
						$buildPics = 'front/'.$main_img;
					}else{
						$buildPics = explode(',',$buildPics['front_images']);
						$buildPics = 'front/'.$buildPics[0];
					}
					
					if($buildPics == "front/"){
						$buildPics = 'noimg_building.png';
					}
					
					$buildingImage = Yii::getPathOfAlias('webroot').'/buildingPictures/'.$buildPics;
					
					//floor plan picture
					$floorPlanPictureDetails = PlanPicture::model()->findByPk($floor['plan_picture_id']);
					if(isset($floorPlanPictureDetails) && count($floorPlanPictureDetails) > 0){
						$floorPlanPicture = Yii::getPathOfAlias('webroot').'/planPictures/'.$floorPlanPictureDetails['name'];
					}else{
						$floorPlanPicture = Yii::getPathOfAlias('webroot').'/planPictures/no_plan.jpg';
					}
					
					//oa floor
					$oaFloor = '';
					if(isset($floor['oa_type']) && $floor['oa_type'] != ""){
						$oaFloor = $floor['oa_type'].'<br/>';
					}else{
						$oaFloor = '';
					}
					
					if(isset($floor['oa_height']) && $floor['oa_height'] != ""){
						$oaFloor .= 'xxxxxxxx'.$floor['oa_height'].' '.Yii::app()->controller->__trans('mm');

					}else{
						$oaFloor = '';
					}
					
					//building air conditioner
					$entOpclTime_exp = explode(',',$buildingDetails['air_condition_time']);
							
						$weekTime = $satTime = $sunTime = '';
						
						$week = explode('-',$entOpclTime_exp[0]);
						if($week[0] == 2){
							$weekTime = $week[1];
						}elseif($week[0] == 1){
							$weekTime = Yii::app()->controller->__trans('Nothing');
						}elseif($week[0] == 3){
							$weekTime = Yii::app()->controller->__trans('unknown');
						}
						$sat = explode('-',$entOpclTime_exp[1]);
						if($sat[0] == 2){
							$satTime = $sat[1];
						}elseif($sat[0] == 1){
							$satTime = Yii::app()->controller->__trans('Nothing');
						}elseif($sat[0] == 3){
							$satTime = Yii::app()->controller->__trans('unknown');
						}
						$sun = explode('-',$entOpclTime_exp[2]);
						if($sun[0] == 2){
							$sunTime = $sun[1];
						}elseif($sun[0] == 1){
							$sunTime = Yii::app()->controller->__trans('Nothing');
						}elseif($sun[0] == 3){
							$sunTime = Yii::app()->controller->__trans('unknown');
						}
					
					  	$buildingAirCondTime = Yii::app()->controller->__trans('平日').':'.($weekTime != "" ? $weekTime : '-').Yii::app()->controller->__trans('土曜').':'.($satTime != "" ? $satTime : '-').Yii::app()->controller->__trans('日曜').':'.($sunTime != "" ? $sunTime : '-');
					  	$buildingAirCond = $floor['air_conditioning_facility_type'];
					  	
					
					//building ceiling height
					$buildingCeilingHeight = isset($floor['ceiling_height']) && $floor['ceiling_height'] != "" ? $floor['ceiling_height'].'mm' : "";
					
					//building parking
					$extractParkingUnitNo = explode('-',$buildingDetails['parking_unit_no']);
					if($extractParkingUnitNo[0] == 1){
						$parkingNo = '有 '.$extractParkingUnitNo[1].Yii::app()->controller->__trans('台');
					}else if($extractParkingUnitNo[0] == 2){
						$parkingUnit = Yii::app()->controller->__trans('noexist');
					}else if($extractParkingUnitNo[0] == 3){
						$parkingUnit = Yii::app()->controller->__trans('exist but unknown unit number');
					}else{
						$parkingUnit = '-';
					}
					$buildingParking = $parkingNo;
					
					//building notes
					$buildingNotes = $floor['notes'];
					
					// print_r($buildingArea);
					// echo "<br>";
					$finalArray[] = array(
						0 => $buildingName,
						1 => $buildingAddress,
						2 => $nearestStName,
						3 => $buildingYear,
						4 => $floorLevels,
						5 => $buildingArea,
						6 => $floorMoveInDate,
						7 => $floorRentUnitPrice,
						8 => $floorUnitCondoPrice,
						9 => $floorRentPriceMonth,
						10 => $floorCondoPriceMonth,
						11 => $floorTotalFeePerMonth,
						12 => $floorDeposit,
						13 => $floorOtherFees,
						14 => $floorRenewalFee,
						// 13 => $floorRenewalFee,
						// 14 => $floorOtherFees,
						15 => $floorContractualLife,
						16 => $buildingFreeRent,
						17 => $floorTotalFeeContract,
						18 => $floorUnitPriceContract,
						19 => $floorFeePerMonthContract,
						20 => $buildingImage,
						21 => $floorPlanPicture,
						22 => $oaFloor,
						23 => $buildingAirCond,
						24 => $buildingCeilingHeight,
						25 => $parkingUnit,						
						26 => $buildingNotes
					);
				}
			}
		}
		
		define('SHEET_SEPARATE_COLUMNS',5);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
		$objPHPExcel = $this->createExcelSheet($objPHPExcel, $cArray, $finalArray);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
				$objPHPExcel->getSheetByName('Worksheet')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
		
		// Redirect output to a clientâ€™s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="01simple.xls"');
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
		
		die;
	}
	
	public function createExcelSheet($objPHPExcel, $columnNames, $columnsData, $sheetIndex = 0) {
		if (empty($columnsData)) return $objPHPExcel;		
		$startNewSheet = false;
		$row = 1; // 1-based index
		
		$objPHPExcel->createSheet($sheetIndex);
		$objPHPExcel->setActiveSheetIndex($sheetIndex);
		$objPHPExcel->getActiveSheet()->setTitle('Sheet ' . ($sheetIndex + 1));
		
		foreach($columnNames as $k=>$v){
			$col = 0;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '003366'))));
		
			$styleArray = array('font'  => array('color' => array('rgb' => 'FFFFFF'),'size'  => 13 , 'name'  => 'MS PGothic'));

			//$objPHPExcel->getActiveSheet()->getCell('A'.$row)->setValue('Some text');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleArray);
		
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(false);
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('30');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $v);
			
			if (in_array($v, array('buildingPictures', 'planPictures'))) {
				$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(100);
			}
			$row ++;
		}
		
		$column = "B";
		$column1="C";			
		$c=0;
		$col = 1;
		$col1= 0;
		$col2= 0;
		$col3= 0;
		$col4= 0;
		$col5 =0;
		$col6= 0;
		$col7= 0;
		$column = "B";
		$column1="C";
		foreach($columnsData as $key => $valData){			
			$row = 1; // 1-based index
			$count=0;
			foreach ($valData as $val){
			$rows = $row;
			if(!($rows== 14 || $rows== 6 || $rows== 17 || $rows == 23 ||  $rows == 13  || $rows == 8 || $rows == 9) ){
			 	$from_cell=$column.$rows;
				$to_cell=$column1.$rows;					
				$objPHPExcel->getActiveSheet()->mergeCells($from_cell.':'.$to_cell);				
			}		
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col).$row)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
			if($row == 1){
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col).'1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '003366'))));
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col).'1')->applyFromArray($styleArray);
			}
			$stylePicArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'aaaaaa')));
			if(strpos($val,'buildingPictures') !== false){
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$objDrawing->setPath($val);
				$objDrawing->setOffsetX(25);    // setOffsetX works properly
				$objDrawing->setOffsetY(0);  //setOffsetY has no effect
				$objDrawing->setCoordinates(PHPExcel_Cell::stringFromColumnIndex($col).$row);
				$objDrawing->setWidth(100); // logo height
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(100);					
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col).$row)->applyFromArray($stylePicArray);					
			}elseif(strpos($val,'planPictures') !== false){
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$objDrawing->setPath($val);
				$objDrawing->setOffsetX(25);    // setOffsetX works properly
				$objDrawing->setOffsetY(0);  //setOffsetY has no effect
				$objDrawing->setCoordinates(PHPExcel_Cell::stringFromColumnIndex($col).$row);
				$objDrawing->setWidth(100); // logo height
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(80);
				$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col).$row)->applyFromArray($stylePicArray);
			}else{
					if($row != 1){
		$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col).$row)->applyFromArray($styleInnerArray);
	}			
				$val = preg_replace("/<br\W*?\/?>/", "", $val);
				$val = str_replace("/n", "", $val);	
				if($row == 6){
				$col2++;
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col2)->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col2)->setWidth('40');
						//  echo "<pre>";
					 // print_r($val);
					$changeval = explode('xxxxxxxx', $val);
					 // echo "<pre>";
						// print_r($changeval[0]);echo"s";print_r($changeval[1]);

					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col2,$row, $changeval[0]);	
						++$col2;	
						//print_r($changeval[0]);die;				
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col2,$row, $changeval[1]);
					$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col2).$row)->applyFromArray($styleInnerArray);
								}
				if($row==9){
				$col7++;
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col7)->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col7)->setWidth('40');
					$changeval = explode('/', $val);
					if(isset($changeval[1])){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col7,$row, $changeval[0]);	
						++$col7;						
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col7,$row, $changeval[1]);
				}
				else{
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col7,$row,$changeval[0]);
					++$col7;
					}
					$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col7).$row)->applyFromArray($styleInnerArray);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col7).$row)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
				}
				if($row == 26){
				$c++;
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c)->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($c)->setWidth('40');
					$changeval = strrchr($val,'yes');				
						if(!empty($changeval)){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c,$row,"yes");		
						++$c;						
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c,$row, $changeval);		
							}
				else{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c,$row,$val);
					++$c;
					}
					$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($c).$row)->applyFromArray($styleInnerArray);
					//echo $col1;
				}	else if($row==14){
				$col1++;
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col1)->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col1)->setWidth('40');
					$changeval = explode('xxxxxxxx', $val);
				// 	echo "<pre>";	
				// print_r($changeval);					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row, $changeval[0]);	
					//echo $col1;					
						++$col1;						
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row, $changeval[1]);
					$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col1).$row)->applyFromArray($styleInnerArray);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col1).$row)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
					//echo $col1;
				}
				else if($row== 13){
				$col5++;
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col5)->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col5)->setWidth('40');
					$changeval = explode('-', $val);						
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col5,$row, $changeval[0]);	
					//echo $col1;					
						++$col5;						
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col5,$row, $changeval[1]);
					$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col5).$row)->applyFromArray($styleInnerArray);
					
				}
				else if($row== 8){
				$col4++;
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col4)->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col4)->setWidth('40');
					$changeval = explode('/', $val);
				$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col4).$row)->applyFromArray($styleInnerArray);			
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col4,$row, $changeval[0]);					
						++$col4;		
					$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col4).$row)->applyFromArray($styleInnerArray);				
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col4,$row, $changeval[1]);
					$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col4).$row)->applyFromArray($styleInnerArray);
				}
				else if($row== 17){
				$col3++;
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col3)->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col3)->setWidth('40');
					$changeval = explode('xxxxxxxx', $val);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row, $changeval[0]);	
					//echo $col1;					
						++$col3;						
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row, $changeval[1]);
					$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col3).$row)->applyFromArray($styleInnerArray);
					
				}
				else if($row==23){
				$col6++;
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col6)->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col6)->setWidth('40');
					$changeval = explode('xxxxxxxx', $val);					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col6,$row, $changeval[0]);
					// print_r($changeval);	
						++$col6;	
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col6,$row, $changeval[1]);
					$styleInnerArray = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '99ccff')));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col6).$row)->applyFromArray($styleInnerArray);
				}
				else{
					$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(false);
					$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('10');
					$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col1)->setAutoSize(false);
					$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col1)->setWidth('10');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $val);					
				}
			}
			$row ++;
		}
		// echo "<pre>";
		// print_r($objPHPExcel);
			if ($col == SHEET_SEPARATE_COLUMNS)
			{
				array_splice($columnsData, 0, 3);
				$startNewSheet = true;
				$objPHPExcel = $this->createExcelSheet($objPHPExcel, $columnNames, $columnsData, $sheetIndex + 1);			
				break;
			}
			$col++;
			$data= ++$column;
			$yes= ++$data;
			$data1= ++$column1;
			$yes1= ++$data1;
			$column1=$yes1;
			$column=$yes;	
		    $col++;			   
		}			
		return $objPHPExcel;
	}

}
