<?php
/* @var $this BuildingController */
/* @var $model Building */

$this->breadcrumbs=array(
	'Buildings'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Building', 'url'=>array('index')),
	array('label'=>'Create Building', 'url'=>array('create')),
	array('label'=>'Update Building', 'url'=>array('update', 'id'=>$model->building_id)),
	array('label'=>'Delete Building', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->building_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Building', 'url'=>array('admin')),
);
?>

<h1>View Building #<?php echo $model->building_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'building_id',
		'name',
		'old_name',
		'name_kana',
		'address',
		'faced_street_id',
		'construction_type_id',
		'floor_scale',
		'earth_quake_res_std',
		'earth_quake_res_std_note',
		'emr_power_gen',
		'built_year',
		'renewal_date',
		'std_floor_space',
		'total_floor_space',
		'elevator',
		'elevator_non_stop',
		'elevator_hall',
		'entrance_with_attention',
		'ent_op_cl_time',
		'ent_auto_lock',
		'parking_unit_no',
		'limit_of_usage_time',
		'wholesale_lease',
		'security_id',
		'form_type_id',
		'condominium_ownership',
	),
)); ?>
