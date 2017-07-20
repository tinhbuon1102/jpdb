<?php
/* @var $this CustomerSourceController */
/* @var $data CustomerSource */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_source_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->customer_source_id), array('view', 'id'=>$data->customer_source_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_name')); ?>:</b>
	<?php echo CHtml::encode($data->source_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_on')); ?>:</b>
	<?php echo CHtml::encode($data->added_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_by')); ?>:</b>
	<?php echo CHtml::encode($data->added_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_on')); ?>:</b>
	<?php echo CHtml::encode($data->modified_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />


</div>