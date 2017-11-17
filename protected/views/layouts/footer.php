<div id="cart_content_wraper">
<div class="cart-content scroll" <?php echo $slideOpen; ?> id="main">
    <div class="header-title">
        <?php echo Yii::app()->controller->__trans('Properties that you added'); ?>
        <span class="respTotalItemCount">(<?php echo $totalCount; ?>)</span>
        <span class="cart_box_button">
	        <button type="button" class="btnPrintCartList"><?php echo Yii::app()->controller->__trans('Printing'); ?></button>
	        <?php
			$isReloadCurrent = 0;
			if($controller == 'building' && $action == 'searchBuildingResult'){
				$isReloadCurrent = 1;
			}
			?>
	        <button type="button" class="btnRemoveList" data-reload="<?php echo $isReloadCurrent; ?>"><?php echo Yii::app()->controller->__trans('Reset'); ?></button>
	        <button type="button" class="btnViewCartList"><?php echo Yii::app()->controller->__trans('View Cart in List'); ?></button>
        </span>
    </div>
    

    
    <div id="list_cart" class="header-white-bg cartResp horizontalScroll" <?php echo isset($_COOKIE['cart_visible']) && !$_COOKIE['cart_visible'] ? 'style="display:none"' : ''?>>
    <?php
    if(isset($cartDetails) && count($cartDetails) > 0){
        $i = 1;
        foreach($cartDetails as $cartList){
            $floorDetails = Floor::model()->findByPk($cartList['floor_id']);
            $buildingDetails = Building::model()->findByPk($cartList['building_id']);
            $buidPictureDetails = BuildingPictures::model()->find('building_id = '.$cartList['building_id']);
            $imageExplode = explode(',',$buidPictureDetails['front_images']);
            if(isset($imageExplode) && count($imageExplode) > 0){
				if(reset($imageExplode)!='')
					$buidImage = Yii::app()->baseUrl.'/buildingPictures/front/'.reset($imageExplode);
				else 
	                $buidImage = Yii::app()->baseUrl.'/images/default.png';
            }else{
                $buidImage = Yii::app()->baseUrl.'/images/default.png';
            }
			
    ?>
        <div class="min-white-box cart-item tile" id="cart_<?php echo $cartList['cart_id']; ?>">
            <input type="hidden" name="cartId" class="cartId" id="cartId" value="<?php echo $cartList['cart_id']; ?>"/>
            <div class="btnRemoveFromCart">
                <i class="fa fa-times"></i>
            </div>
            <div class="table-wrap">
            <div class="cart_img"><a href="<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id'])); ?>" target="_blank" style="background:url('<?php echo $buidImage; ?>');background-size:cover;background-position:center;"></a></div>
            
                <ul class="item_info">
                <li class="bld_name">
                <a href="<?php echo Yii::app()->createUrl('building/singleBuilding',array('id'=>$cartList['floor_id'])); ?>" target="_blank">
                    <?php //echo $i; ?>
					<?php
                    	echo mb_strlen($buildingDetails['name'])>20?mb_substr($buildingDetails['name'], 0, 20, "utf-8"):$buildingDetails['name']; 
                        //echo $buildingDetails['bill_check']==0?"ビル":"";
						if(isset($floorDetails['floor_down']) && $floorDetails['floor_down'] != ""){
							if(strpos($floorDetails['floor_down'], '-') !== false){
								$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorDetails['floor_down']);
							}else{
								$floorDown = $floorDetails['floor_down'];
							}
							if(isset($floorDetails['floor_up']) && $floorDetails['floor_up'] != ''){
								echo $floorDown.' - '.$floorDetails['floor_up'].' '.Yii::app()->controller->__trans('階');
							}else{
								echo $floorDown.' '.Yii::app()->controller->__trans('階');
							}
							
							if($floorDetails['roomname'] != ""){
								echo "( ".$floorDetails['roomname']." )";
							}
						}
					?></a></li>
                    <li>
                        <?php
                        	if($floorDetails['area_ping'] != ""){
								echo $floorDetails['area_ping'].' 坪 &nbsp;';
							}else{
								echo '-坪 &nbsp;';
							}
							
							if($floorDetails['rent_unit_price'] == "" && $floorDetails['rent_unit_price_opt'] == 0){
								echo '未定/相談';
							}else{
// 								if(isset($floorDetails['rent_unit_price']) && $floorDetails['rent_unit_price'] != ""){
// 									echo $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
// 								}else
								{
									if($floorDetails['rent_unit_price_opt'] != ''){
										if($floorDetails['rent_unit_price_opt'] == -1){
											echo Yii::app()->controller->__trans('undecided');
										}else if($floorDetails['rent_unit_price_opt'] == -2){
											echo Yii::app()->controller->__trans('ask');
										}
										else {
											echo $floorDetails['rent_unit_price'].' 円/'.Yii::app()->controller->__trans('tsubo');
										}
									}else{
										echo '-';
									}
								}
							}
						?>
                    </li>
                    </ul>
                    </div>
            
        </div>
    <?php
        $i++;
        }
    }
    ?>
    </div>
</div>

<!-- footer -->
<div id="footer">
	<p id="copyright" class="wrapper">© JAPAN PROPERTIES DB All Rights Reserved.</p>
</div>
<div class="modal-box-help hide">
	<div class="content content_help">
    	<div class="box-header">
        	<button type="button" class="btnModalClose btnModalClose_help" id="btnModalClose_print">X</button>
            <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Japan properties operation description'); ?></h2>
        </div>
        <div class="box-content">
        	<dd>
            	<ul class="m_list">
                	<li><a href="<?php echo Yii::app()->baseUrl.'/manuals/basic.pdf'; ?>" target="_blank"><?php echo Yii::app()->controller->__trans('Basic Usage'); ?></a></li>
                    <li><a href="<?php echo Yii::app()->baseUrl.'/manuals/basic.pdf'; ?>" target="_blank"><?php echo Yii::app()->controller->__trans('Property Management Manual'); ?></a></li>
                    <li><a href="<?php echo Yii::app()->baseUrl.'/manuals/basic.pdf'; ?>" target="_blank"><?php echo Yii::app()->controller->__trans('Customer management manual'); ?></a></li>
                    <li><a href="<?php echo Yii::app()->baseUrl.'/manuals/basic.pdf'; ?>" target="_blank"><?php echo Yii::app()->controller->__trans('Proposed documentation manual'); ?></a></li>
                </ul>
            </dd>
        </div>
    </div>
</div>

<div class="modal-box-print hide">
	<div class="content content_print">
    	<div class="box-header">
        	<button type="button" class="btnModalClose btnModalClose_print" id="btnModalClose_print">X</button>
            <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Print the property printed documentation'); ?></h2>
        </div>
        <div class="box-content">
        	<dd>
            	<form name="temp" action="<?php echo Yii::app()->createUrl('building/printBuildingDetails'); ?>" method="post" id="frmPrintDetails">
            		<select id="print_language" name="print_language">
	        			<option value="ja"><?php echo Yii::app()->controller->__trans('Japanese'); ?></option>
	        			<option value="en"><?php echo Yii::app()->controller->__trans('English'); ?></option>
	        		</select>
<!--               	<input type="hidden" name="html"/>
                    <div class="radio1">
                    	<input type="radio" value="11"  name="print_type"  id="check1" checked="">ビル情報を個別に表示<br/>
                        &nbsp; &nbsp;<input type="checkbox" name="print_route" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('Show route map'); ?><br/>
                        &nbsp; &nbsp;<input type="checkbox" name="print_map" id="print_type" class="print_term" value="1"> <?php echo Yii::app()->controller->__trans('Show whole map'); ?><br/>
                        &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_each_building" class="print_term" value="1"> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                        &nbsp; &nbsp;<input type="checkbox" name="add_cover_foot" id="add_cover_foot" class="print_term add_cover_foot" value="1"> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/>
                        &nbsp; &nbsp;<input type="checkbox" name="print_time_floor" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('showing use of time for floor'); ?><br/>
                        &nbsp; &nbsp;<input type="checkbox" name="print_time_entrance" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('showing use of time for entrance'); ?><br/>
                        <input type="text"  name="header_name_foot" id="header_name_foot" placeholder="Enter header name" class="header_name_foot" style="display:none"/>
                        
                   	</div>
                    <div class="radio2">
                    	<input type="radio" value="10"  name="print_type" >ビル情報をリストで表示<br/>
                        &nbsp; &nbsp;<input type="checkbox" name="print_route" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show route map'); ?><br/>
                        &nbsp; &nbsp;<input type="checkbox" name="print_map" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show whole map'); ?><br/>
                        &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                        &nbsp; &nbsp;<input type="checkbox" name="add_cover_foot" id="add_cover_foot" class="print_term add_cover_foot" value="1" disabled> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/>
                        <input type="text"  name="header_name_foot" id="header_name_foot" placeholder="Enter header name" class="header_name_foot" style="display:none"/>
                    </div>
                    <div class="radio3">
                    	<input type="radio" value="8"  name="print_type">営業用資料<br/>
                        &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                        &nbsp; &nbsp;<input type="checkbox" name="add_cover_foot" id="add_cover_foot" class="print_term add_cover_foot" value="1" disabled> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/>
                        <input type="text"  name="header_name_foot" id="header_name_foot" placeholder="Enter header name" class="header_name_foot" style="display:none"/>
                    </div>
                    <div class="bt_input_box">
                    	<div class="bt_input">
                        	<input type="button" class="bt_carry btnPrint" value="<?php echo Yii::app()->controller->__trans('Run'); ?>"/>
                        </div>
                    </div> -->
<!--             	<input type="hidden" name="hdnProArticleId" id="hdnProArticleId" class="hdnProArticleId" value="0"/> -->
            	<input type="hidden" name="printCart" id="printCart" value="1"/>
            	<input type="hidden" name="user" id="user" value="<?php echo Yii::app()->user->getId()?>"/>
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
                    &nbsp; &nbsp;<input type="checkbox" name="add_cover" id="add_cover" class="print_term add_cover" value="1" disabled> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/><br/>
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
                <div class="radio3">
                	<input type="radio" value="8"  name="print_type">営業用資料<br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_map" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show whole map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="show_numbering" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show numbering instead of text label for whole map'); ?><br/>                	
<!--                     &nbsp; &nbsp;<input type="checkbox" name="print_each_building" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show maps for each building'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="add_cover" id="add_cover" class="print_term add_cover" value="1" disabled> <?php echo Yii::app()->controller->__trans('Add cover'); ?><br/>
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
	                </select><br /> -->
                </div>
                <div class="bt_input">
                	<input type="hidden" name="r" value="floor/addProposedToCart"/>
                	<a target="_blank" href="" class="bt_carry btnPrint" >
                		<input type="button" value="<?php echo Yii::app()->controller->__trans('Run'); ?>">
                	</a>
                </div>
               	</form>
            </dd>
        </div>
    </div>
</div>

<div class="modal-box-change-password hide">
	<div class="content content_print">
    	<div class="box-header">
        	<button type="button" class="btnModalClose btnModalClosePassword" id="btnModalClosePassword">X</button>
            <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Change Your Password'); ?></h2>
        </div>
        <div class="box-content">
        	<dd>
            	<form name="frmChangePassword" data-action="<?php echo Yii::app()->createUrl('users/changePassword'); ?>" method="post" id="frmChangePassword" class="frmChangePassword">
                	<input type="hidden" name="hdnLoggedId" id="hdnLoggedId" class="hdnLoggedId" value="0"/>
                    <div class="bt_input_box">
                    	<div class="bt_input">
                        	<input type="password" class="bt_carry newPassword" value="" placeholder="New Password"/>
                        </div>
                    </div>
                    <div class="bt_input_box">
                    	<div class="bt_input">
                        	<input type="password" class="bt_carry newRePassword" value="" placeholder="Type New Password Again"/>
                        </div>
                    </div>
                    <div class="bt_input_box">
                    	<div class="bt_input">
                        	<input type="button" class="bt_carry btnSavePassword" value="<?php echo Yii::app()->controller->__trans('Change'); ?>"/>
                        </div>
                    </div>
               	</form>
            </dd>
        </div>
    </div>
</div>

<div class="modal-box-site-setting hide">
	<div class="content content_print">
    	<div class="box-header">
        	<button type="button" class="btnModalClose btnModalCloseSetting" id="btnModalCloseSetting">X</button>
            <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Change Site Setting'); ?></h2>
        </div>
        <div class="box-content">
        	<dd>
            	<form name="frmSiteSetting" data-action="<?php echo Yii::app()->createUrl('siteSetting/changeSiteDetails'); ?>" method="post" id="frmSiteSetting" class="frmSiteSetting">
                    <div class="bt_input_box">
                    	<div class="bt_input">
                        	<?php
							$siteSettingDetails = SiteSetting::model()->findByPk(1);
							?>
                        	<input type="hidden" name="companyNameId" id="companyNameId" class="companyNameId" value="1"/>
                        	<input type="text" class="bt_carry companyName" id="companyName" name="companyName" value="<?php echo $siteSettingDetails['value']; ?>" placeholder="Company Name"/>
                        </div>
                    </div>
                    <div class="bt_input_box">
                    	<div class="bt_input">
                        	<input type="button" class="bt_carry btnSaveSiteSetting" id="btnSaveSiteSetting" value="<?php echo Yii::app()->controller->__trans('Change'); ?>"/>
                        </div>
                    </div>
               	</form>
            </dd>
        </div>
    </div>
</div>
</div>

<!-- /footer -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-migrate-1.3.0.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.min.js"></script>


<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/groovy.js?t=<?php echo time()?>"></script> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/groovy2.js?t=<?php echo time()?>"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.knob.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.ui.widget.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.iframe-transport.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.fileupload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/utils/Draggable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/TweenMax.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.maskedinput.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/a2form.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/grid.js"></script>
<script>
$(document).ready(function(){
	$('.img-zoom').hover(function(){
		$(this).addClass('transition');
	},function(){
		$(this).removeClass('transition');
	});
});
</script>

<?php
if($controller == 'building' && $action == 'singleBuilding'){
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lightbox/js/lightbox.min.js"></script>
<?php } ?>
