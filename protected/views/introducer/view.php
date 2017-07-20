<?php
/* @var $this IntroducerController */
/* @var $model Introducer */

$this->breadcrumbs=array(
	'Introducers'=>array('index'),
	$model->introducer_id,
);

$this->menu=array(
	array('label'=>'List Introducer', 'url'=>array('index')),
	array('label'=>'Create Introducer', 'url'=>array('create')),
	array('label'=>'Update Introducer', 'url'=>array('update', 'id'=>$model->introducer_id)),
	array('label'=>'Delete Introducer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->introducer_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Introducer', 'url'=>array('admin')),
);
?>

<h1>View Introducer #<?php echo $model->introducer_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'introducer_id',
		'introducer_name',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
		'is_active',
	),
)); ?>
