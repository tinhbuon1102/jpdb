<?php
/* @var $this RegionController */
/* @var $model Region */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'region-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'region_name'); ?>
		<?php echo $form->textField($model,'region_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'region_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prefectures'); ?>
		<?php echo $form->textField($model,'prefectures',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'prefectures'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'added_by'); ?>
		<?php echo $form->textField($model,'added_by'); ?>
		<?php echo $form->error($model,'added_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'added_on'); ?>
		<?php echo $form->textField($model,'added_on'); ?>
		<?php echo $form->error($model,'added_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_by'); ?>
		<?php echo $form->textField($model,'modified_by'); ?>
		<?php echo $form->error($model,'modified_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_on'); ?>
		<?php echo $form->textField($model,'modified_on'); ?>
		<?php echo $form->error($model,'modified_on'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->