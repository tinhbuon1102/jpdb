<?php
/* @var $this FloorSourceFromTypeController */
/* @var $model FloorSourceFromType */

$this->breadcrumbs=array(
	'Floor Source From Types'=>array('index'),
	$model->floor_source_from_type_id,
);

$this->menu=array(
	array('label'=>'List FloorSourceFromType', 'url'=>array('index')),
	array('label'=>'Create FloorSourceFromType', 'url'=>array('create')),
	array('label'=>'Update FloorSourceFromType', 'url'=>array('update', 'id'=>$model->floor_source_from_type_id)),
	array('label'=>'Delete FloorSourceFromType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->floor_source_from_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FloorSourceFromType', 'url'=>array('admin')),
);
?>

<h1>View FloorSourceFromType #<?php echo $model->floor_source_from_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'floor_source_from_type_id',
		'floor_source_from_type_name',
		'is_active',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
	),
)); ?>
