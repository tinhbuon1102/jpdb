<?php
/* @var $this PropertyTypeController */
/* @var $model PropertyType */

$this->breadcrumbs=array(
	'Property Types'=>array('index'),
	$model->property_type_id,
);

$this->menu=array(
	array('label'=>'List PropertyType', 'url'=>array('index')),
	array('label'=>'Create PropertyType', 'url'=>array('create')),
	array('label'=>'Update PropertyType', 'url'=>array('update', 'id'=>$model->property_type_id)),
	array('label'=>'Delete PropertyType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->property_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PropertyType', 'url'=>array('admin')),
);
?>

<h1>View PropertyType #<?php echo $model->property_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'property_type_id',
		'property_type_name',
		'is_active',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
	),
)); ?>
