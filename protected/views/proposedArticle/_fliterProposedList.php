<?php
$useTypesDetails = UseTypes::model()->findAll('is_active = 1');
if(isset($model) && count($model) > 0){
	foreach($model as $proposedArticle){
		if(isset($proposedArticle->proposed_article_id) && $proposedArticle->proposed_article_id != ''){
			$proposedList = ProposedArticle::model()->findByPk($proposedArticle->proposed_article_id);
			$searchallCond = json_decode($proposedArticle->search_cond);
			$searchallCond = $searchallCond[0];
			if(isset($searchallCond->conditionFormData)){
				$searchCondAry = $searchallCond->conditionFormData;
				$searchCond = new stdClass();
				foreach($searchCondAry as $ska){
					if(strpos($ska->name,'[]')){
						$name = str_replace('[]','',$ska->name);
						$value = $ska->value;
						if(!isset($searchCond->{$name})) $searchCond->{$name} = array();
						$searchCond->{$name}[] = $value;
					}else{
						$name = $ska->name;
						$value = $ska->value;
						$searchCond->{$name} = $value;
					}
				}
			}else{
				$searchCond = $searchallCond;
			}
			$searchedCondition = '';
			/*********************** facilities *************************/
			if(isset($searchCond->facilities) && !empty($searchCond->facilities)){
				$arrayFacilities = array('1'=>'男女別トイレ','2'=>'OAフロア','3'=>'個別空調','4'=>'フロア分割可','5'=>'耐震補強','6'=>'一棟貸し可','7'=>'緊急発電装置対応');
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$i = 0;
				foreach($searchCond->facilities as $fac){
					if($i == count($searchCond->facilities)-1){
						$comma = '';
					}else{
						$comma = ',';
					}
					if(array_key_exists($fac,$arrayFacilities)){
						$searchedCondition .= $arrayFacilities[$fac].$comma;
					}
					$i++;
				}
				$searchedCondition .= '</li>';
			}
			/************************* lender type ************************/
			if(isset($searchCond->lenderType) && !empty($searchCond->lenderType)){
				$arrayLenderType = array('1'=>'貸主 ','2'=>'業者','3'=>'不明');
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$i = 0;
				foreach($searchCond->lenderType as $lender){
					if($i == count($searchCond->lenderType)-1){
						$comma = '';
					}else{
						$comma = ',';
					}
					if(array_key_exists($lender,$arrayLenderType)){
						$searchedCondition .= $arrayLenderType[$lender].$comma;
					}
					$i++;
				}
				$searchedCondition .= '</li>';
			}
			/************************* station minutes ************************/
			if(isset($searchCond->walkFromStation) && !empty($searchCond->walkFromStation)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->walkFromStation." ".Yii::app()->controller->__trans('分以内')." ".Yii::app()->controller->__trans('from station');
				$searchedCondition .= '</li>';
			}
			/************************* area min ************************/
			if(isset($searchCond->areaMinValue) && !empty($searchCond->areaMinValue)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->areaMinValue." ".Yii::app()->controller->__trans('坪 以上');
				$searchedCondition .= '</li>';
			}
			/************************* area max ************************/
			if(isset($searchCond->areaMaxValue) && !empty($searchCond->areaMaxValue)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->areaMaxValue." ".Yii::app()->controller->__trans('坪 以下');
				$searchedCondition .= '</li>';
			}
			/************************* unit min ************************/
			if(isset($searchCond->unitMinValue) && !empty($searchCond->unitMinValue)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->unitMinValue." ".Yii::app()->controller->__trans('万円 以上');
				$searchedCondition .= '</li>';
			}
			/************************* unit max ************************/
			if(isset($searchCond->unitMaxValue) && !empty($searchCond->unitMaxValue)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->unitMaxValue." ".Yii::app()->controller->__trans('万円 以下');
				$searchedCondition .= '</li>';
			}
			/************************* cost min ************************/
			if(isset($searchCond->costMinAmount) && !empty($searchCond->costMinAmount)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->costMinAmount." ".Yii::app()->controller->__trans('円 以上');
				$searchedCondition .= '</li>';
			}
			/************************* cost max ************************/
			if(isset($searchCond->costMaxAmount) && !empty($searchCond->costMaxAmount)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->costMaxAmount." ".Yii::app()->controller->__trans('円 以下');
				$searchedCondition .= '</li>';
			}
			/************************* floor min ************************/
			if(isset($searchCond->floorMin) && !empty($searchCond->floorMin)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->floorMin." ".Yii::app()->controller->__trans('階 以上');
				$searchedCondition .= '</li>';
			}
			/************************* floor max ************************/
			if(isset($searchCond->floorMax) && !empty($searchCond->floorMax)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->floorMax." ".Yii::app()->controller->__trans('階 以下');
				$searchedCondition .= '</li>';
			}
			/************************* possible move date ************************/
			if(isset($searchCond->possibleDataMin) && !empty($searchCond->possibleDataMin)){
				if(isset($searchCond->possibleDataMax) && !empty($searchCond->possibleDataMax)){
					$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
					$searchedCondition .= Yii::app()->controller->__trans('move in from')." ".$searchCond->possibleDataMin." ".Yii::app()->controller->__trans('to')." ".$searchCond->possibleDataMax;
					$searchedCondition .= '</li>';
				}else{
					$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
					$searchedCondition .= Yii::app()->controller->__trans('move in from')." ".$searchCond->possibleDataMin;
					$searchedCondition .= '</li>';
				}
			}
			/************************* short rent include ************************/
			if(isset($searchCond->shortRent) && !empty($searchCond->shortRent)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= Yii::app()->controller->__trans($searchCond->shortRent);
				$searchedCondition .= '</li>';
			}
			/************************* building age ************************/
			if(isset($searchCond->buildingAge) && !empty($searchCond->buildingAge)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->buildingAge." ".Yii::app()->controller->__trans('年以降に竣工');
				$searchedCondition .= '</li>';
			}
			/************************* update date dropdown ************************/
			if(isset($searchCond->updateDateDrop) && !empty($searchCond->updateDateDrop)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= $searchCond->updateDateDrop;
				$searchedCondition .= '</li>';
			}
			/************************* specific customer name ************************/
			if(isset($searchCond->specifyCustomerName) && !empty($searchCond->specifyCustomerName)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= Yii::app()->controller->__trans('reference from').' '.$searchCond->specifyCustomerName;
				$searchedCondition .= '</li>';
			}
			/************************* brokerage free include ************************/
			if(isset($searchCond->brokerageFree) && !empty($searchCond->brokerageFree)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= Yii::app()->controller->__trans($searchCond->brokerageFree);
				$searchedCondition .= '</li>';
			}
			/************************* status of requirement ************************/
			if(isset($searchCond->statusRequirement) && !empty($searchCond->statusRequirement)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= Yii::app()->controller->__trans('Listing of ').Yii::app()->controller->__trans($searchCond->statusRequirement);
				$searchedCondition .= '</li>';
			}
			/************************* dead line check ************************/
			if(isset($searchCond->deadlineCheck) && !empty($searchCond->deadlineCheck)){
				$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
				$searchedCondition .= Yii::app()->controller->__trans($searchCond->deadlineCheck);
				$searchedCondition .= '</li>';
			}
			/************************* floor type ************************/
			if(isset($searchCond->floorType) && !empty($searchCond->floorType)){
				if(count($useTypesDetails) > 0){
					$searchedCondition .= '<li><i class="fa fa-check-square"></i>';
					$i = 0;
					foreach($useTypesDetails as $uses){
						if(in_array($uses['user_type_id'],$searchCond->floorType)){
							if($i == count($searchCond->floorType) - 1){
								$comm = '';
							}else{
								$comm = ',';
							}
							$searchedCondition .= Yii::app()->controller->__trans($uses['user_type_name']).$comm;
						}
						$i++;
					}
				}
				$searchedCondition .= '</li>';
			}
			/************************* prefectue ************************/
		}
		
		$buildings = array();
		$aFloor = array();
		$aBuildings = explode(',',$proposedArticle['building_id']);
		foreach($aBuildings as $bId){
			$buildDetail = Building::model()->findByPk($bId);
			if(count($buildDetail) > 0){
				$buildings[] = $bId;
				$getFloor = Floor::model()->findAll('building_id = '.$bId);
				$floorIds = explode(',',$proposedArticle['floor_id']);
				foreach($getFloor as $availFloor){
					if(in_array($availFloor['floor_id'],$floorIds)){
						$aFloor[] = $availFloor['floor_id'];
					}
				}
			}
		}
		if(count($buildings) == 0){
			continue;
		}
?>
<div class="ttl_approach">
	<table class="ttl_aplist">
    	<tbody>
        	<tr>
            	<td class="ap_id bold">
                	<?php echo Yii::app()->controller->__trans('ID'); ?>: <?php echo $proposedArticle['proposed_article_rand_id']; ?>
                </td>
                <td class="ap_cus bold">
                	<p><?php echo $proposedArticle['proposed_article_name']; ?></p>
                </td>
                <td class="ap_date t-right">
                    <?php
						$days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
						$day = array_search((date('D',strtotime($proposedArticle['added_on']))), $days);
						echo date('Y年m月d日 ( '.$day.' )',strtotime($proposedArticle['added_on'])); ?> <?php echo Yii::app()->controller->__trans('Updated');
					?>
                </td>
                <td class="ap_sales t-right">
                	<?php echo Yii::app()->controller->__trans('Author'); ?>:
					<?php
                    $userDetails = AdminDetails::model()->find('user_id = '.$proposedArticle['user_id']);
                    echo $userDetails['full_name'];
                    ?>
                </td>
            </tr>
        </tbody>
   	</table>
</div>
<div class="article-list">
	<div class="action-list propertyActionList">
    	<input type="hidden" name="hdnProposedArticleId" id="hdnProposedArticleId" class="hdnProposedArticleId" value="<?php echo $proposedArticle['proposed_article_id']; ?>" />
        <a href="#" class="btnShowProposedArticleList">
            <i class="fa fa-eye"></i><?php echo Yii::app()->controller->__trans('show properties list'); ?>
        </a>
        <a href="#" class="btnAddArticleToCart">
            <i class="fa fa-arrow-circle-right"></i><?php echo Yii::app()->controller->__trans('add to cart'); ?>
        </a>
        <a href="<?php echo Yii::app()->createUrl('building/searchBuilding'); ?>">
            <i class="fa fa-search"></i><?php echo Yii::app()->controller->__trans('Search as same condition'); ?>
        </a>
        <a href="#" class="btnDuplicateProposedArticle">
            <i class="fa fa-files-o"></i><?php echo Yii::app()->controller->__trans('duplicate'); ?>
        </a>
        <a href="#" id="printArticle">
            <i class="fa fa-print"></i><?php echo Yii::app()->controller->__trans('print'); ?>
        </a>
        <a href="#" class="btnDownloadExcel">
            <!--<form name="frmDownloadAsExcel" id="frmDownloadAsExcel" class="frmDownloadAsExcel" action="<?php //echo Yii::app()->createUrl('proposedArticle/downloadAsExcel'); ?>" method="post">-->
            <form name="frmDownloadAsExcel" id="frmDownloadAsExcel" class="frmDownloadAsExcel" action="<?php echo Yii::app()->createUrl('proposedArticle/testExcel'); ?>" method="post">
                <input type="hidden" name="dwnExcelId" id="dwnExcelId" class="dwnExcelId" value="0" />
            </form>
            <i class="fa fa-download"></i><?php echo Yii::app()->controller->__trans('download as excel'); ?>
        </a>
        <a href="#" id="pdfArticle">
            <i class="fa fa-file"></i><?php echo Yii::app()->controller->__trans('pdf'); ?>
        </a>
        <a href="#" class="delate btnDeleteProposedArticle">
            <i class="fa fa-trash"></i><?php echo Yii::app()->controller->__trans('delete'); ?>
        </a>
    </div>
    <table class="saved-list table-style4">
        <tr>
            <th>
                <span>
                <?php
                    echo count($buildings);
                ?>
                </span> <?php echo Yii::app()->controller->__trans(' building'); ?> (
                <?php
					echo count($aFloor);
                   /* if($proposedArticle['floor_id'] != ""){
                        $proFloors = explode(',',$proposedArticle['floor_id']);
                        echo count($proFloors);
                    }else{
                        echo '0';
                    }*/
                ?>
                <?php echo Yii::app()->controller->__trans(' floor'); ?>)
            </th>
            <td>
                <ul class="ap_condition">
                    <?php
                        echo $searchedCondition;
                    ?>
                    <!--<li><i class="fa fa-check-square"></i>120坪 以上</li>
                    <li><i class="fa fa-check-square"></i>150坪 以下</li>
                    <li><i class="fa fa-check-square"></i>賃料未定フロアも含む</li>
                    <li><i class="fa fa-check-square"></i>現状空室の物件のみ</li>
                    <li><i class="fa fa-check-square"></i>情報更新日が2016.2.14(日)以降のフロア</li>
                    <li><i class="fa fa-check-square"></i>ビル内の募集中フロアを全て表示</li>
                    <li><i class="fa fa-check-square"></i>広尾駅</li>                                <li><i class="fa fa-check-square"></i>恵比寿駅</li>
                    <li><i class="fa fa-check-square"></i>中目黒駅</li>-->
                </ul>
            </td>
        </tr>
    </table>
</div>
<?php
	}
}else{
?>
<div class="msgProposedArticle">
	<?php echo Yii::app()->controller->__trans('No Proposed Articles.'); ?>
</div>
<?php
}
?>