<?php
/* @var $this QuakeResistanceStandardsController */
/* @var $data QuakeResistanceStandards */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('quake_resistance_standard_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->quake_resistance_standard_id), array('view', 'id'=>$data->quake_resistance_standard_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quake_resistance_standard_name')); ?>:</b>
	<?php echo CHtml::encode($data->quake_resistance_standard_name); ?>
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