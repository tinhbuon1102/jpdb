<?php
/* @var $this CustomerSourceController */
/* @var $model CustomerSource */

$this->breadcrumbs=array(
	'Customer Sources'=>array('index'),
	$model->customer_source_id,
);

$this->menu=array(
	array('label'=>'List CustomerSource', 'url'=>array('index')),
	array('label'=>'Create CustomerSource', 'url'=>array('create')),
	array('label'=>'Update CustomerSource', 'url'=>array('update', 'id'=>$model->customer_source_id)),
	array('label'=>'Delete CustomerSource', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->customer_source_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CustomerSource', 'url'=>array('admin')),
);
?>

<h1>View CustomerSource #<?php echo $model->customer_source_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'customer_source_id',
		'source_name',
		'is_active',
		'added_on',
		'added_by',
		'modified_on',
		'modified_by',
	),
)); ?>
