<div id="main" class="full-width">
<div id="login-box" class="needs_edit">
<h1 id="logo"><img src="http://heart-hunger.net/properties-db/wp-content/themes/hearthunger/images/logo.png"></h1>
<div class="form login">
<div class="login-inner">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array('class'=>'login-form'),
	
)); ?>
  		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>

  		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
  
  <?php echo CHtml::submitButton('Login', array('value' => Yii::t('admin', 'Log In'),'class'=>'submit')); ?>
		<div class="keep-login"><input type="checkbox" name="save_value" value="1" checked=""><span>Save username and password</span></div>
      <p class="message"><a href="#">Lost your password?</a></p>
<?php $this->endWidget(); ?>
</div><!--/login-inner-->
</div><!--/formbox-->
</div><!--/logine-box-->
 </div><!--/main-->