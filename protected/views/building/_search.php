<?php
/* @var $this BuildingController */
/* @var $model Building */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'building_id'); ?>
		<?php echo $form->textField($model,'building_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'old_name'); ?>
		<?php echo $form->textField($model,'old_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name_kana'); ?>
		<?php echo $form->textField($model,'name_kana',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'faced_street_id'); ?>
		<?php echo $form->textField($model,'faced_street_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'construction_type_id'); ?>
		<?php echo $form->textField($model,'construction_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'floor_scale'); ?>
		<?php echo $form->textField($model,'floor_scale',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'earth_quake_res_std'); ?>
		<?php echo $form->textField($model,'earth_quake_res_std'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'earth_quake_res_std_note'); ?>
		<?php echo $form->textField($model,'earth_quake_res_std_note',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emr_power_gen'); ?>
		<?php echo $form->textField($model,'emr_power_gen',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'built_year'); ?>
		<?php echo $form->textField($model,'built_year',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'renewal_data'); ?>
		<?php echo $form->textField($model,'renewal_data'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'std_floor_space'); ?>
		<?php echo $form->textField($model,'std_floor_space',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_floor_space'); ?>
		<?php echo $form->textField($model,'total_floor_space',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'elevator'); ?>
		<?php echo $form->textField($model,'elevator',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'elevator_non_stop'); ?>
		<?php echo $form->textField($model,'elevator_non_stop',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'elevator_hall'); ?>
		<?php echo $form->textField($model,'elevator_hall',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entrance_with_attention'); ?>
		<?php echo $form->textField($model,'entrance_with_attention',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ent_op_cl_time'); ?>
		<?php echo $form->textField($model,'ent_op_cl_time',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ent_auto_lock'); ?>
		<?php echo $form->textField($model,'ent_auto_lock',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parking_unit_no'); ?>
		<?php echo $form->textField($model,'parking_unit_no',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'limit_of_usage_time'); ?>
		<?php echo $form->textField($model,'limit_of_usage_time',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wholesale_lease'); ?>
		<?php echo $form->textField($model,'wholesale_lease',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'security_id'); ?>
		<?php echo $form->textField($model,'security_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'form_type_id'); ?>
		<?php echo $form->textField($model,'form_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'condominium_ownership'); ?>
		<?php echo $form->textField($model,'condominium_ownership'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->