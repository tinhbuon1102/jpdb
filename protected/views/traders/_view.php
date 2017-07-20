<?php
/* @var $this TradersController */
/* @var $data Traders */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('trader_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->trader_id), array('view', 'id'=>$data->trader_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trader_name')); ?>:</b>
	<?php echo CHtml::encode($data->trader_name); ?>
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