<?php
/* @var $this CustomerController */
/* @var $data Customer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->customer_id), array('view', 'id'=>$data->customer_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_name')); ?>:</b>
	<?php echo CHtml::encode($data->company_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_name_kana')); ?>:</b>
	<?php echo CHtml::encode($data->company_name_kana); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('president_name')); ?>:</b>
	<?php echo CHtml::encode($data->president_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('postal_code')); ?>:</b>
	<?php echo CHtml::encode($data->postal_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone_no')); ?>:</b>
	<?php echo CHtml::encode($data->phone_no); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fax_no')); ?>:</b>
	<?php echo CHtml::encode($data->fax_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->business_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_emp')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_emp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_source_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_source_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('introducer_id')); ?>:</b>
	<?php echo CHtml::encode($data->introducer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inquiry_id')); ?>:</b>
	<?php echo CHtml::encode($data->inquiry_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_incharge_name')); ?>:</b>
	<?php echo CHtml::encode($data->person_incharge_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_incharge_name_kana')); ?>:</b>
	<?php echo CHtml::encode($data->person_incharge_name_kana); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_name')); ?>:</b>
	<?php echo CHtml::encode($data->branch_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_phone_no')); ?>:</b>
	<?php echo CHtml::encode($data->person_phone_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_fax_no')); ?>:</b>
	<?php echo CHtml::encode($data->person_fax_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cellphone_no')); ?>:</b>
	<?php echo CHtml::encode($data->cellphone_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo CHtml::encode($data->department); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->sales_staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_by')); ?>:</b>
	<?php echo CHtml::encode($data->added_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_on')); ?>:</b>
	<?php echo CHtml::encode($data->added_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_on')); ?>:</b>
	<?php echo CHtml::encode($data->modified_on); ?>
	<br />

	*/ ?>

</div>