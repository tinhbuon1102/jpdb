<?php
/* @var $this BuildingController */
/* @var $data Building */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('building_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->building_id), array('view', 'id'=>$data->building_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('old_name')); ?>:</b>
	<?php echo CHtml::encode($data->old_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_kana')); ?>:</b>
	<?php echo CHtml::encode($data->name_kana); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faced_street_id')); ?>:</b>
	<?php echo CHtml::encode($data->faced_street_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('construction_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->construction_type_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_scale')); ?>:</b>
	<?php echo CHtml::encode($data->floor_scale); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('earth_quake_res_std')); ?>:</b>
	<?php echo CHtml::encode($data->earth_quake_res_std); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('earth_quake_res_std_note')); ?>:</b>
	<?php echo CHtml::encode($data->earth_quake_res_std_note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emr_power_gen')); ?>:</b>
	<?php echo CHtml::encode($data->emr_power_gen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('built_year')); ?>:</b>
	<?php echo CHtml::encode($data->built_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('renewal_date')); ?>:</b>
	<?php echo CHtml::encode($data->renewal_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('std_floor_space')); ?>:</b>
	<?php echo CHtml::encode($data->std_floor_space); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_floor_space')); ?>:</b>
	<?php echo CHtml::encode($data->total_floor_space); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('elevator')); ?>:</b>
	<?php echo CHtml::encode($data->elevator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('elevator_non_stop')); ?>:</b>
	<?php echo CHtml::encode($data->elevator_non_stop); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('elevator_hall')); ?>:</b>
	<?php echo CHtml::encode($data->elevator_hall); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entrance_with_attention')); ?>:</b>
	<?php echo CHtml::encode($data->entrance_with_attention); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ent_op_cl_time')); ?>:</b>
	<?php echo CHtml::encode($data->ent_op_cl_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ent_auto_lock')); ?>:</b>
	<?php echo CHtml::encode($data->ent_auto_lock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parking_unit_no')); ?>:</b>
	<?php echo CHtml::encode($data->parking_unit_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('limit_of_usage_time')); ?>:</b>
	<?php echo CHtml::encode($data->limit_of_usage_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wholesale_lease')); ?>:</b>
	<?php echo CHtml::encode($data->wholesale_lease); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('security_id')); ?>:</b>
	<?php echo CHtml::encode($data->security_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('form_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->form_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('condominium_ownership')); ?>:</b>
	<?php echo CHtml::encode($data->condominium_ownership); ?>
	<br />

	*/ ?>

</div>