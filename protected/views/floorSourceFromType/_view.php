<?php
/* @var $this FloorSourceFromTypeController */
/* @var $data FloorSourceFromType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_source_from_type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->floor_source_from_type_id), array('view', 'id'=>$data->floor_source_from_type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_source_from_type_name')); ?>:</b>
	<?php echo CHtml::encode($data->floor_source_from_type_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
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


</div>