<?php
/* @var $this QuakeResistanceStandardsController */
/* @var $model QuakeResistanceStandards */

$this->breadcrumbs=array(
	'Quake Resistance Standards'=>array('index'),
	$model->quake_resistance_standard_id,
);

$this->menu=array(
	array('label'=>'List QuakeResistanceStandards', 'url'=>array('index')),
	array('label'=>'Create QuakeResistanceStandards', 'url'=>array('create')),
	array('label'=>'Update QuakeResistanceStandards', 'url'=>array('update', 'id'=>$model->quake_resistance_standard_id)),
	array('label'=>'Delete QuakeResistanceStandards', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->quake_resistance_standard_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage QuakeResistanceStandards', 'url'=>array('admin')),
);
?>

<h1>View QuakeResistanceStandards #<?php echo $model->quake_resistance_standard_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'quake_resistance_standard_id',
		'quake_resistance_standard_name',
		'is_active',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
	),
)); ?>
