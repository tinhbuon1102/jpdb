<?php
/* @var $this FloorController */
/* @var $data Floor */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->floor_id), array('view', 'id'=>$data->floor_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('building_id')); ?>:</b>
	<?php echo CHtml::encode($data->building_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vacancy_info')); ?>:</b>
	<?php echo CHtml::encode($data->vacancy_info); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('move_in_date')); ?>:</b>
	<?php echo CHtml::encode($data->move_in_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('preceding_user')); ?>:</b>
	<?php echo CHtml::encode($data->preceding_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('preceding_details')); ?>:</b>
	<?php echo CHtml::encode($data->preceding_details); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('preceding_check_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->preceding_check_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vacant_schedule')); ?>:</b>
	<?php echo CHtml::encode($data->vacant_schedule); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_down')); ?>:</b>
	<?php echo CHtml::encode($data->floor_down); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_up')); ?>:</b>
	<?php echo CHtml::encode($data->floor_up); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('roomname')); ?>:</b>
	<?php echo CHtml::encode($data->roomname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('maisonette_type')); ?>:</b>
	<?php echo CHtml::encode($data->maisonette_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('short_term_rent')); ?>:</b>
	<?php echo CHtml::encode($data->short_term_rent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_of_use')); ?>:</b>
	<?php echo CHtml::encode($data->type_of_use); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('area_ping')); ?>:</b>
	<?php echo CHtml::encode($data->area_ping); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('area_m')); ?>:</b>
	<?php echo CHtml::encode($data->area_m); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('area_net')); ?>:</b>
	<?php echo CHtml::encode($data->area_net); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('calculation_method')); ?>:</b>
	<?php echo CHtml::encode($data->calculation_method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_by_installments')); ?>:</b>
	<?php echo CHtml::encode($data->payment_by_installments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_by_installments_note')); ?>:</b>
	<?php echo CHtml::encode($data->payment_by_installments_note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_partition')); ?>:</b>
	<?php echo CHtml::encode($data->floor_partition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rent_unit_price_opt')); ?>:</b>
	<?php echo CHtml::encode($data->rent_unit_price_opt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rent_unit_price')); ?>:</b>
	<?php echo CHtml::encode($data->rent_unit_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_rent_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_rent_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_condo_fee_opt')); ?>:</b>
	<?php echo CHtml::encode($data->unit_condo_fee_opt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_condo_fee')); ?>:</b>
	<?php echo CHtml::encode($data->unit_condo_fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_condo_fee')); ?>:</b>
	<?php echo CHtml::encode($data->total_condo_fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deposit_opt')); ?>:</b>
	<?php echo CHtml::encode($data->deposit_opt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deposit_month')); ?>:</b>
	<?php echo CHtml::encode($data->deposit_month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deposit')); ?>:</b>
	<?php echo CHtml::encode($data->deposit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_deposit')); ?>:</b>
	<?php echo CHtml::encode($data->total_deposit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('key_money_opt')); ?>:</b>
	<?php echo CHtml::encode($data->key_money_opt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('key_money_month')); ?>:</b>
	<?php echo CHtml::encode($data->key_money_month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('repayment_opt')); ?>:</b>
	<?php echo CHtml::encode($data->repayment_opt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('repayment_reason')); ?>:</b>
	<?php echo CHtml::encode($data->repayment_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('repayment_amt')); ?>:</b>
	<?php echo CHtml::encode($data->repayment_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('repayment_amt_opt')); ?>:</b>
	<?php echo CHtml::encode($data->repayment_amt_opt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('renewal_fee_opt')); ?>:</b>
	<?php echo CHtml::encode($data->renewal_fee_opt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('renewal_fee_reason')); ?>:</b>
	<?php echo CHtml::encode($data->renewal_fee_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('renewal_fee_recent')); ?>:</b>
	<?php echo CHtml::encode($data->renewal_fee_recent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('repayment_notes')); ?>:</b>
	<?php echo CHtml::encode($data->repayment_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notice_of_cancellation')); ?>:</b>
	<?php echo CHtml::encode($data->notice_of_cancellation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contract_period_opt')); ?>:</b>
	<?php echo CHtml::encode($data->contract_period_opt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contract_period_duration')); ?>:</b>
	<?php echo CHtml::encode($data->contract_period_duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('air_conditioning_facility_type')); ?>:</b>
	<?php echo CHtml::encode($data->air_conditioning_facility_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('air_conditioning_details')); ?>:</b>
	<?php echo CHtml::encode($data->air_conditioning_details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('air_conditioning_time_used')); ?>:</b>
	<?php echo CHtml::encode($data->air_conditioning_time_used); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_air_conditioning')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_air_conditioning); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('optical_cable')); ?>:</b>
	<?php echo CHtml::encode($data->optical_cable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oa_type')); ?>:</b>
	<?php echo CHtml::encode($data->oa_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oa_height')); ?>:</b>
	<?php echo CHtml::encode($data->oa_height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_material')); ?>:</b>
	<?php echo CHtml::encode($data->floor_material); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ceiling_height')); ?>:</b>
	<?php echo CHtml::encode($data->ceiling_height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('electric_capacity')); ?>:</b>
	<?php echo CHtml::encode($data->electric_capacity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('separate_toilet_by_gender')); ?>:</b>
	<?php echo CHtml::encode($data->separate_toilet_by_gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('toilet_location')); ?>:</b>
	<?php echo CHtml::encode($data->toilet_location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('washlet')); ?>:</b>
	<?php echo CHtml::encode($data->washlet); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('toilet_cleaning')); ?>:</b>
	<?php echo CHtml::encode($data->toilet_cleaning); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_source_id')); ?>:</b>
	<?php echo CHtml::encode($data->floor_source_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_person_in_charge')); ?>:</b>
	<?php echo CHtml::encode($data->update_person_in_charge); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('property_confirmation_person')); ?>:</b>
	<?php echo CHtml::encode($data->property_confirmation_person); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_condominium_ownership')); ?>:</b>
	<?php echo CHtml::encode($data->is_condominium_ownership); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ownership_type')); ?>:</b>
	<?php echo CHtml::encode($data->ownership_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('management_type')); ?>:</b>
	<?php echo CHtml::encode($data->management_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('owner_company_name')); ?>:</b>
	<?php echo CHtml::encode($data->owner_company_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_tel')); ?>:</b>
	<?php echo CHtml::encode($data->company_tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_in_charge1')); ?>:</b>
	<?php echo CHtml::encode($data->person_in_charge1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_in_charge2')); ?>:</b>
	<?php echo CHtml::encode($data->person_in_charge2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('charge')); ?>:</b>
	<?php echo CHtml::encode($data->charge); ?>
	<br />

	*/ ?>

</div>