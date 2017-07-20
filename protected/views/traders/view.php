<?php
/* @var $this TradersController */
/* @var $model Traders */

$this->breadcrumbs=array(
	'Traders'=>array('index'),
	$model->trader_id,
);

$this->menu=array(
	array('label'=>'List Traders', 'url'=>array('index')),
	array('label'=>'Create Traders', 'url'=>array('create')),
	array('label'=>'Update Traders', 'url'=>array('update', 'id'=>$model->trader_id)),
	array('label'=>'Delete Traders', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->trader_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Traders', 'url'=>array('admin')),
);
?>

<h1>View Traders #<?php echo $model->trader_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'trader_id',
		'trader_name',
		'is_active',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
	),
)); ?>
