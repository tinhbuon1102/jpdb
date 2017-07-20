<?php
$userDetails = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
$userRole = '';
if(isset($userDetails) && count($userDetails)){
	$userRole = $userDetails->user_role;
}
?>
<div id="main" class="single-customer">
	<div class="content-label">
    	<?php echo Yii::app()->controller->__trans('Setting'); ?>
    </div>
    <div class="content-setting">
    	<!--<div class="content-notes">
        	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
        </div>-->
        <ul>
			<?php if($userRole == 's'){ ?>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('users/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Users'); ?>
                </a>
            </li>
            <?php } ?>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('businessType/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Business Type'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('constructionType/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Construction Type'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('customerSource/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Customer Source'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('propertyType/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Property Type'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('quakeResistanceStandards/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Quake Resistance Standards'); ?>
                </a>
            </li>
            <!--<li>
            	<a href="<?php //echo Yii::app()->createUrl('inquiryType/admin');?>">
                	<?php //echo Yii::app()->controller->__trans('Manage Inquiry Type'); ?>
                </a>
            </li>-->
            <li>
            	<a href="<?php echo Yii::app()->createUrl('introducer/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Introducer'); ?>
                </a>
            </li>
            <!--<li>
            	<a href="<?php //echo Yii::app()->createUrl('facedStreet/admin');?>">
                	<?php //echo Yii::app()->controller->__trans('Manage Faced Streets'); ?>
                </a>
            </li>-->
            <li>
            	<a href="<?php echo Yii::app()->createUrl('security/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Security'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('formType/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Form Type'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('useTypes/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Uses Type'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('floorSourceFromType/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Floor Source From Type'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('traders/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Traders'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('region/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Region'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('wordTranslation/admin');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Translation'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('site/mapKey');?>">
                	<?php echo Yii::app()->controller->__trans('Manage Google Map Key'); ?>
                </a>
            </li>
            <li>
            	<a href="<?php echo Yii::app()->createUrl('company/admin');?>">
                	<?php echo Yii::app()->controller->__trans('management company'); ?>
                </a>
            </li>            
        </ul>
    </div>
</div>