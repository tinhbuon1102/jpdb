<?php
/* @var $this SecurityController */
/* @var $data Security */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('security_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->security_id), array('view', 'id'=>$data->security_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('security_name')); ?>:</b>
	<?php echo CHtml::encode($data->security_name); ?>
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