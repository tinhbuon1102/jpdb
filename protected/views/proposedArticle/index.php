<!-- <div style=" max-width: 1050px;width: 100%;margin: 20px auto;clear: both;" class="full-width search_result">
    <div class="postbox">
    <div class="list-item">
            <header class="m-title btnright" style="margin-bottom: 0px; ">
                <h1 class="main-title">検索条件</h1>
            </header>
            <div class="post">
            
            <form method="get" name="mainSearchCondition" id="mainSearchCondition" action="<?php echo Yii::app()->createUrl('building/searchBuildingResult'); ?>">
                <div class="room-data clearfix condition_results">
                    <ul class="searchTab clearfix" data-tabname="area">
                    <?php
                        if(isset($customCondition)) $condReq = $customCondition;
                        echo Yii::app()->controller->__getCondition($condReq);
                        if(isset($_REQUEST['final_redi'])){
                            $finalRediEx = explode('~',$_REQUEST['final_redi']);
                            if(isset($finalRediEx[0]) && isset($finalRediEx[1])){
                                if(isset($finalRediEx[2]) && $finalRediEx[2] != ''){
                                    if($finalRediEx[2] == 'drop'){
                                        echo '<li><span class="condition_name condition_name_list">'.$finalRediEx[0].'の値下がり物件（'.$finalRediEx[1].'）<span></li>';
                                    }else{
                                        echo '<li><span class="condition_name condition_name_list">'.$finalRediEx[0].'の値上がり物件（'.$finalRediEx[1].'）<span></li>';
                                    }
                                }else{
                                    echo '<li><span class="condition_name condition_name_list">'.$finalRediEx[0].'の新着・更新空き物件（'.$finalRediEx[1].'）<span></li>';
                                }
                            }
                        }
          $distrincts = Yii::app()->controller->__getConditionsForView($condReq);

          foreach ($distrincts as $distrinct) {
            echo "<li>" . $distrinct . "</li>";
          }
                    ?>
                    </ul>
                    
                    </div>
                    </div>
            </form>
        </div>  
    </div>  
    
</div> -->
<div id="main">
	<div class="postbox particle-list">
    	<header class="m-title btnright">
        	<h1 class="main-title"><?php echo Yii::app()->controller->__trans('PROPOSED ARTICLE'); ?></h1>
        </header>
        <?php
            // Yii::app()->controller->actionSearchBuildingResult();
        ?>
        <div class="post">
        	<div class="search_approach clearfix">
            	<div class="bd_num">
                	<span class="number articleNumber">
					<?php echo $item_count; ?>
                    </span>
                    <span class="txt_num_a">件</span>
                </div>
                <div class="pagination js-category-pagination" data-current-page="1">
                    <?php
                    	$this->widget('CLinkPager', array(
						'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
						'nextPageLabel'=>'<i class="fa fa-chevron-right"></i>',
						'selectedPageCssClass' => 'active',
                        'htmlOptions'=>array('class'=>'pagination'),
						'header'=>'',
						'pages'=>$pages,
						)); ?>
                </div>
            </div>
            
            <div class="navtop clearfix">
            	<div class="alignleft actions bulkactions">
                	<form method="post" name="frmFilterProposedArticleByCustomer" id="frmFilterProposedArticleByCustomer" class="frmFilterProposedArticleByCustomer" data-action="<?php echo Yii::app()->createUrl('proposedArticle/filterArticles'); ?>">
                    	<input type="search" id="customerName" name="customerName" class="customerName" value="" placeholder="顧客名で絞込" />
                        <input type="submit" id="search-submit" class="button btnFilterByName" value="絞込" />
                   	</form>
                </div>
                <form id="customer-filter" method="post" name="frmFilterProposedArticle" id="frmFilterProposedArticle" class="frmFilterProposedArticle" data-action="<?php echo Yii::app()->createUrl('proposedArticle/filterArticles'); ?>">
                	<div class="alignright actions" style="display: inline-block;">
                    	<label for="filter-by-date" class="screen-reader-text"><?php echo Yii::app()->controller->__trans('Filter by date'); ?></label>
                        <select name="filterByDate" id="filterByDate" class="filterByDate" style="display: inline-block;width: 150px;">
                            <option selected="selected" value="0"><?php echo Yii::app()->controller->__trans('All dates'); ?></option>
                            <?php
                            $users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->id));
                            $loguser_id = $users->user_id;
                            $proposedArticleListByDate = ProposedArticle::model()->findAll('user_id = '.$loguser_id);
                            $dates = array();
                            $listDates = array();
                            if(isset($proposedArticleListByDate) && count($proposedArticleListByDate) > 0){
                                foreach($proposedArticleListByDate as $proposedArticle){
                                    $tYear = date('Y',strtotime($proposedArticle['added_on']));
                                    $tMonth = date('F',strtotime($proposedArticle['added_on']));
                                    if(!isset($dates[$tYear])){
                                        $dates[$tYear] = array();
                                    }
                                    if(!isset($dates[$tYear][$tMonth])){
                                        $dates[$tYear][$tMonth] = $tYear." ".$tMonth;
                                        $listDates[] = $tMonth." ".$tYear;
                                    }
                                }
                            }
                            unset($dates);
                            if(isset($listDates) && count($listDates) > 0){
                                foreach($listDates as $date){
                            ?>
                            <option value="<?php echo $date; ?>"><?php echo date('Y年m月',strtotime($date)); ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <label class="screen-reader-text" for="cat"><?php echo Yii::app()->controller->__trans('Filter by category'); ?></label>
                        <select  name="proposedUsername" id="proposedUsername" class="proposedUsername" style="display: inline-block;width: 150px;">
                            <option value="0"><?php echo Yii::app()->controller->__trans('All managers'); ?></option>
                            <?php
                            $userList = Users::model()->findAll('user_role = "a"');
                            if(isset($userList) && count($userList) > 0){
                                foreach($userList as $user){
									$selected = '';
									if($loguser_id == $user['user_id']){
										$selected = 'selected';
									}
									$userFullDetails = AdminDetails::model()->find('user_id = '.$user['user_id']);
                            ?>
                            <option class="level-0 proposedUsername" value="<?php echo $userFullDetails['user_id']; ?>" <?php echo $selected; ?>><?php echo $userFullDetails['full_name']; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <input type="submit" name="filterAction" id="filterAction" class="filterAction" value="<?php echo Yii::app()->controller->__trans('Filter'); ?>"/>
                        <div style="width: 35px;height: 32px;float: right;display:none;" class="dispLoader">
                        	<div class="loadTraders" style="position: relative; top:-3px;left:0;">
                            	<div class="spinner">
                                	<div class="rect1"></div>
                                    <div class="rect2"></div>
                                    <div class="rect3"></div>
                                    <div class="rect4"></div>
                                    <div class="rect5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="filterResponse">
            <?php
			$useTypesDetails = UseTypes::model()->findAll('is_active = 1');
			if(isset($model) && count($model) > 0){
				foreach($model as $proposedArticle){
					if(isset($proposedArticle->proposed_article_id) && $proposedArticle->proposed_article_id != ''){
						$proposedList = ProposedArticle::model()->findByPk($proposedArticle->proposed_article_id);
						
						$searchallCond = json_decode($proposedArticle->search_cond);
						$searchallCond = $searchallCond[0];
						$searchedCondition = Yii::app()->controller->__getCondition($searchallCond);
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
                    <a href="<?php echo Yii::app()->createUrl('building/searchBuilding',array('samecond'=>$proposedArticle['proposed_article_id'],'type'=>'pa')); ?>">
                    	<i class="fa fa-search"></i><?php echo Yii::app()->controller->__trans('Search as same condition'); ?>
                    </a>
                    <a href="#" class="btnDuplicateProposedArticle" data-value='<?php echo $searchedCondition;?>'>
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
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i><?php echo Yii::app()->controller->__trans('download as excel'); ?>
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
							//echo $item_count;
							?>
                            </span> <?php echo Yii::app()->controller->__trans('棟'); ?> (
                            <?php
								echo count($aFloor);
								/*if($proposedArticle['floor_id'] != ""){
									$proFloors = explode(',',$proposedArticle['floor_id']);
									echo count($proFloors);
								}else{
									echo '0';
								}*/
							?>
                            <?php echo Yii::app()->controller->__trans('フロア'); ?>)
                        </th>
                        <td>
                        	<ul class="ap_condition">
                            	<?php
									echo $searchedCondition;
                              $search = json_decode($proposedArticle->search_cond, true);
                              if (isset($search[0])) {
                                $search = $search[0];
                              }

                              $distrincts = Yii::app()->controller->__getConditionsForView($search);

                              foreach ($distrincts as $distrinct) {
                                echo "<li>" . $distrinct . "</li>";
                              }
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
			}
			?>
            </div>
        </div>
    ​</div>
</div>

<div class="modal-box modal-box-pdf hide">
	<div class="content content-print-art">
    	<div class="box-header">
        	<h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Proposed Article PDF'); ?></h2>
            <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>
        <div class="box-content">
        	<form name="frmPdfPropose" id="frmPdfPropose" class="frmPdfPropose" action="<?php echo Yii::app()->createUrl('proposedArticle/testPdf'); ?>" method="post">
            	<input type="hidden" name="hdnProArticlePdfId" id="hdnProArticlePdfId" class="hdnProArticlePdfId" value="0"/>
                <div class="radio1">
                	<input type="radio" value="11"  name="print_type"  id="check1" checked="">ビル情報を個別に表示<br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_route" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('Show route map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_map" id="print_type" class="print_term" value="1"> <?php echo Yii::app()->controller->__trans('Show whole map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_each_building" class="print_term" value="1"> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="add_cover" id="add_cover" class="print_term add_cover" value="1"> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_time_floor" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('showing use of time for floor'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_time_entrance" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('showing use of time for entrance'); ?><br/>
                    <input type="text"  name="header_name" id="header_name" placeholder="<?php echo Yii::app()->controller->__trans('Enter header name'); ?>" class="hide header_name" disabled/>
               	</div>
                <div class="radio2">
                	<input type="radio" value="10"  name="print_type" >ビル情報をリストで表示<br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_route" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show route map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_map" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show whole map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="add_cover" id="add_cover" class="print_term add_cover" value="1" disabled> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/><br/>
                    <input type="text"  name="header_name" id="header_name" placeholder="<?php echo Yii::app()->controller->__trans('Enter header name'); ?>" class="hide header_name" disabled/>
                </div>
                <div class="radio3">
                	<input type="radio" value="8"  name="print_type">営業用資料<br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="add_cover" id="add_cover" class="print_term add_cover" value="1" disabled> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/>
                    <input type="text"  name="header_name" id="header_name" placeholder="<?php echo Yii::app()->controller->__trans('Enter header name'); ?>" class="hide header_name" disabled/>
                </div>
                <div class="bt_input">
                	<input type="submit" class="bt_carry btnProposedPdf" value="<?php echo Yii::app()->controller->__trans('Run'); ?>">
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal-box modal-box-print-art hide">
	<div class="content content-print-art">
    	<div class="box-header">
        	<h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Proposed Article Print'); ?></h2>
            <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>
        <div class="box-content">
        	<form method="get" name="frmPrintPropose" id="frmPrintPropose" class="frmPrintPropose" data-action="<?php echo Yii::app()->createUrl('proposedArticle/cloneArticles'); ?>">
        		<select id="print_language" name="print_language">
        			<option value="ja"><?php echo Yii::app()->controller->__trans('Japanese'); ?></option>
        			<option value="en"><?php echo Yii::app()->controller->__trans('English'); ?></option>
        		</select>
        		
            	<input type="hidden" name="hdnProArticleId" id="hdnProArticleId" class="hdnProArticleId" value="0"/>
                <div class="radio1">
                	<input type="radio" value="11"  name="print_type"  id="check1" checked="">ビル情報を個別に表示<br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_route" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('Show route map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_map" id="print_type" class="print_term" value="1"> <?php echo Yii::app()->controller->__trans('Show whole map'); ?><br/>
					&nbsp; &nbsp;<input type="checkbox" name="show_numbering" id="print_type" class="print_term" value="1"> <?php echo Yii::app()->controller->__trans('Show numbering instead of text label for whole map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_each_building" class="print_term" value="1"> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="add_cover" id="add_cover" class="print_term add_cover" value="1"> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_time_floor" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('showing use of time for floor'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_time_entrance" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('showing use of time for entrance'); ?><br/>
                    <input type="text"  name="header_name" id="header_name" placeholder="<?php echo Yii::app()->controller->__trans('Enter header name'); ?>" class="print_term hide header_name" disabled/>
					<select  name="proposedUsername" id="proposedUsername" class="print_term proposedUsername hide" style="width: 150px;border:1px solid #ddd;;margin-top: 10px;" disabled>
					<?php
	                	$userList = Users::model()->findAll('user_role = "a"');
	                    if(isset($userList) && count($userList) > 0){
	                    	foreach($userList as $user){
								$userFullDetails = AdminDetails::model()->find('user_id = '.$user['user_id']);
					?>
					<option class="proposedUsername" value="<?php echo $userFullDetails['user_id']; ?>" ><?php echo $userFullDetails['full_name']; ?></option>
					<?php
	                        }
	                    }
	                ?>
	                </select>
               	</div>
                <div class="radio2">
                	<input type="radio" value="10"  name="print_type" >ビル情報をリストで表示<br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_route" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show route map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_map" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show whole map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="show_numbering" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show numbering instead of text label for whole map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="add_cover" id="add_cover" class="print_term add_cover" value="1" disabled> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/>
                    <input type="text"  name="header_name" id="header_name" placeholder="<?php echo Yii::app()->controller->__trans('Enter header name'); ?>" class="print_term hide header_name" disabled/>
					<select  name="proposedUsername" id="proposedUsername" class="print_term hide proposedUsername" style="width: 150px;border:1px solid #ddd;;margin-top: 10px;" disabled>
					<?php
	                	$userList = Users::model()->findAll('user_role = "a"');
	                    if(isset($userList) && count($userList) > 0){
	                    	foreach($userList as $user){
								$userFullDetails = AdminDetails::model()->find('user_id = '.$user['user_id']);
					?>
					<option class="proposedUsername" value="<?php echo $userFullDetails['user_id']; ?>" ><?php echo $userFullDetails['full_name']; ?></option>
					<?php
	                        }
	                    }
	                ?>
	                </select>
                </div>
                <div class="radio3">
                	<input type="radio" value="8"  name="print_type">営業用資料<br/>
                	&nbsp; &nbsp;<input type="checkbox" name="print_map" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show whole map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="show_numbering" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show numbering instead of text label for whole map'); ?><br/>
<!--                     
                    &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="add_cover" id="add_cover" class="print_term add_cover" value="1" disabled> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/>
                    <input type="text"  name="header_name" id="header_name" placeholder="<?php echo Yii::app()->controller->__trans('Enter header name'); ?>" class="print_term hide header_name" disabled/>
					<select  name="proposedUsername" id="proposedUsername" class="print_term hide proposedUsername" style="width: 150px;border:1px solid #ddd;margin-top: 10px;" disabled>
					<?php
	                	$userList = Users::model()->findAll('user_role = "a"');
	                    if(isset($userList) && count($userList) > 0){
	                    	foreach($userList as $user){
								$userFullDetails = AdminDetails::model()->find('user_id = '.$user['user_id']);
					?>
					<option class="proposedUsername" value="<?php echo $userFullDetails['user_id']; ?>" ><?php echo $userFullDetails['full_name']; ?></option>
					<?php
	                        }
	                    }
	                ?>
	                </select>  -->                    
                </div>
                <br/>
                <div class="bt_input">
                	<input type="hidden" name="r" value="floor/addProposedToCart"/>
                	<a target="_blank" href="" class="bt_carry btnProposedPrint" >
                		<input type="button" value="<?php echo Yii::app()->controller->__trans('Run'); ?>">
                	</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Popup for clone of proposed article-->
<div class="modal-box hide" id="modalCloneProposedArticle">
	<div class="content transmissionContent">
    	<div class="box-header">
        	<h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Proposed Article'); ?></h2>
            <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        </div>
        <div class="box-content">
        	<form name="frmCloneProposedArticle" id="frmCloneProposedArticle" class="frmCloneProposedArticle" data-action="<?php echo Yii::app()->createUrl('proposedArticle/cloneArticles'); ?>">
            	<input type="hidden" name="hdnProArticleId" id="hdnProArticleId" class="hdnProArticleId" value="0"/>
                <table>
                	<tr>
                    	<td><?php echo Yii::app()->controller->__trans('list name'); ?></td>
                        <td style="text-align:left;">
                        	<input type="text" name="proposedArticleName" id="proposedArticleName" class="proposedArticleName" style="width:50% !important;" />
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo Yii::app()->controller->__trans('Customer Name'); ?></td>
                        <td style="text-align:left;">
                        	<select name="proposedCustomerName" id="proposedCustomerName"  class="proposedCustomerName" style='display:inline-block;width:150px;'>
                            	<option value="0">-</option>
                                <?php
								$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
								$customerList = Customer::model()->findAll();
								if(isset($customerList) && count($customerList) > 0){
									foreach($customerList as $customer){
								?>
                                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['company_name']; ?></option>
                                <?php
									}
								}else{
								?>
                                <option value="-"><?php echo Yii::app()->controller->__trans('You not have customer'); ?></option>
                                <?php
								}
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo Yii::app()->controller->__trans('Search Condition'); ?></td>
                        <td>
                        	<ul class="ap_condition">
                            	<span class="conditionDuplicate"></span>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                        	<button type="button" class="btnSaveDuplicateArticle"><?php echo Yii::app()->controller->__trans('Add'); ?></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
