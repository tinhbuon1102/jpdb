<?php
/* @var $this FloorController */
/* @var $model Floor */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'floor_id'); ?>
		<?php echo $form->textField($model,'floor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'building_id'); ?>
		<?php echo $form->textField($model,'building_id'); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'vacancy_info'); ?>
		<?php echo $form->textField($model,'vacancy_info',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'move_in_date'); ?>
		<?php echo $form->textField($model,'move_in_date',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'preceding_user'); ?>
		<?php echo $form->textField($model,'preceding_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'preceding_details'); ?>
		<?php echo $form->textField($model,'preceding_details',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'preceding_check_datetime'); ?>
		<?php echo $form->textField($model,'preceding_check_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vacant_schedule'); ?>
		<?php echo $form->textField($model,'vacant_schedule',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'floor_down'); ?>
		<?php echo $form->textField($model,'floor_down',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'floor_up'); ?>
		<?php echo $form->textField($model,'floor_up',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'roomname'); ?>
		<?php echo $form->textField($model,'roomname',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'maisonette_type'); ?>
		<?php echo $form->textField($model,'maisonette_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'short_term_rent'); ?>
		<?php echo $form->textField($model,'short_term_rent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type_of_use'); ?>
		<?php echo $form->textField($model,'type_of_use'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'area_ping'); ?>
		<?php echo $form->textField($model,'area_ping',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'area_m'); ?>
		<?php echo $form->textField($model,'area_m',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'area_net'); ?>
		<?php echo $form->textField($model,'area_net',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'calculation_method'); ?>
		<?php echo $form->textField($model,'calculation_method'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_by_installments'); ?>
		<?php echo $form->textField($model,'payment_by_installments'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_by_installments_note'); ?>
		<?php echo $form->textField($model,'payment_by_installments_note',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'floor_partition'); ?>
		<?php echo $form->textField($model,'floor_partition',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rent_unit_price_opt'); ?>
		<?php echo $form->textField($model,'rent_unit_price_opt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rent_unit_price'); ?>
		<?php echo $form->textField($model,'rent_unit_price',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_rent_price'); ?>
		<?php echo $form->textField($model,'total_rent_price',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unit_condo_fee_opt'); ?>
		<?php echo $form->textField($model,'unit_condo_fee_opt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unit_condo_fee'); ?>
		<?php echo $form->textField($model,'unit_condo_fee',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_condo_fee'); ?>
		<?php echo $form->textField($model,'total_condo_fee',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deposit_opt'); ?>
		<?php echo $form->textField($model,'deposit_opt',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deposit_month'); ?>
		<?php echo $form->textField($model,'deposit_month',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deposit'); ?>
		<?php echo $form->textField($model,'deposit',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_deposit'); ?>
		<?php echo $form->textField($model,'total_deposit',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'key_money_opt'); ?>
		<?php echo $form->textField($model,'key_money_opt',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'key_money_month'); ?>
		<?php echo $form->textField($model,'key_money_month',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'repayment_opt'); ?>
		<?php echo $form->textField($model,'repayment_opt',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'repayment_reason'); ?>
		<?php echo $form->textField($model,'repayment_reason'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'repayment_amt'); ?>
		<?php echo $form->textField($model,'repayment_amt',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'repayment_amt_opt'); ?>
		<?php echo $form->textField($model,'repayment_amt_opt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'renewal_fee_opt'); ?>
		<?php echo $form->textField($model,'renewal_fee_opt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'renewal_fee_reason'); ?>
		<?php echo $form->textField($model,'renewal_fee_reason'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'renewal_fee_recent'); ?>
		<?php echo $form->textField($model,'renewal_fee_recent',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'repayment_notes'); ?>
		<?php echo $form->textField($model,'repayment_notes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'notice_of_cancellation'); ?>
		<?php echo $form->textField($model,'notice_of_cancellation',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contract_period_opt'); ?>
		<?php echo $form->textField($model,'contract_period_opt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contract_period_duration'); ?>
		<?php echo $form->textField($model,'contract_period_duration',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'air_conditioning_facility_type'); ?>
		<?php echo $form->textField($model,'air_conditioning_facility_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'air_conditioning_details'); ?>
		<?php echo $form->textField($model,'air_conditioning_details',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'air_conditioning_time_used'); ?>
		<?php echo $form->textField($model,'air_conditioning_time_used',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'number_of_air_conditioning'); ?>
		<?php echo $form->textField($model,'number_of_air_conditioning'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'optical_cable'); ?>
		<?php echo $form->textField($model,'optical_cable',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oa_type'); ?>
		<?php echo $form->textField($model,'oa_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oa_height'); ?>
		<?php echo $form->textField($model,'oa_height',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'floor_material'); ?>
		<?php echo $form->textField($model,'floor_material'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ceiling_height'); ?>
		<?php echo $form->textField($model,'ceiling_height',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'electric_capacity'); ?>
		<?php echo $form->textField($model,'electric_capacity',array('size'=>50,'maxlength'=>50)); ?> <?php echo Yii::app()->controller->__trans('VA/m&sup2;');?> 
	</div>

	<div class="row">
		<?php echo $form->label($model,'separate_toilet_by_gender'); ?>
		<?php echo $form->textField($model,'separate_toilet_by_gender',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'toilet_location'); ?>
		<?php echo $form->textField($model,'toilet_location',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'washlet'); ?>
		<?php echo $form->textField($model,'washlet',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'toilet_cleaning'); ?>
		<?php echo $form->textField($model,'toilet_cleaning',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'floor_source_id'); ?>
		<?php echo $form->textField($model,'floor_source_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_person_in_charge'); ?>
		<?php echo $form->textField($model,'update_person_in_charge'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'property_confirmation_person'); ?>
		<?php echo $form->textField($model,'property_confirmation_person'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_condominium_ownership'); ?>
		<?php echo $form->textField($model,'is_condominium_ownership'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ownership_type'); ?>
		<?php echo $form->textField($model,'ownership_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'management_type'); ?>
		<?php echo $form->textField($model,'management_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'owner_company_name'); ?>
		<?php echo $form->textField($model,'owner_company_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_tel'); ?>
		<?php echo $form->textField($model,'company_tel',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'person_in_charge1'); ?>
		<?php echo $form->textField($model,'person_in_charge1',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'person_in_charge2'); ?>
		<?php echo $form->textField($model,'person_in_charge2',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'charge'); ?>
		<?php echo $form->textField($model,'charge',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->