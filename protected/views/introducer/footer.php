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
                <div class="radio1">
                	<input type="radio" value="11"  name="print_type"  id="check1" checked="">ビル情報を個別に表示<br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_route" id="print_type" class="print_term" value="1" > <?php echo Yii::app()->controller->__trans('Show route map'); ?><br/>
                    &nbsp; &nbsp;<input type="checkbox" name="print_map" id="print_type" class="print_term" value="1"> <?php echo Yii::app()->controller->__trans('Show whole map'); ?><br/>
					&nbsp; &nbsp;<input type="checkbox" name="show_numbering" id="print_type" class="print_term" value="1"> <?php echo Yii::app()->controller->__trans('Show numbering instead of text label for whole map'); ?><br/>
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
                    &nbsp; &nbsp;<input type="checkbox" name="show_numbering" id="print_type" class="print_term" value="1" disabled> <?php echo Yii::app()->controller->__trans('Show numbering instead of text label for whole map'); ?><br/>
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

<!-- /footer -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-migrate-1.3.0.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.min.js"></script>


<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/groovy.js"></script> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/groovy2.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.knob.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.ui.widget.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.iframe-transport.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.fileupload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/utils/Draggable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/TweenMax.min.js"></script>

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