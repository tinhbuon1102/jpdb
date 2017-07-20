<?php
/* @var $this UseTypesController */
/* @var $model UseTypes */

$this->breadcrumbs=array(
	'Use Types'=>array('index'),
	$model->user_type_id,
);

$this->menu=array(
	array('label'=>'List UseTypes', 'url'=>array('index')),
	array('label'=>'Create UseTypes', 'url'=>array('create')),
	array('label'=>'Update UseTypes', 'url'=>array('update', 'id'=>$model->user_type_id)),
	array('label'=>'Delete UseTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UseTypes', 'url'=>array('admin')),
);
?>

<h1>View UseTypes #<?php echo $model->user_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_type_id',
		'user_type_name',
		'is_active',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
	),
)); ?>
