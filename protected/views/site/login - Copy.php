<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array('class'=>'login'),
	
)); ?>
<fieldset>
  <legend class="legend">Login</legend>
  <div class="input">
  		<?php echo $form->textField($model,'username'); ?>
        <span><i class="fa fa-envelope-o"></i></span>
		<?php echo $form->error($model,'username'); ?>
  </div>
  <div class="input">
  		<?php echo $form->passwordField($model,'password'); ?>
        <span><i class="fa fa-lock"></i></span>
		<?php echo $form->error($model,'password'); ?>
  </div>
  
  <?php  echo CHtml::submitButton('Login', array('value' => Yii::t('admin', 'Log In'),'class'=>'submit')); ?>
</fieldset>
<?php $this->endWidget(); ?>
