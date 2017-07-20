<?php
/* @var $this ConstructionTypeController */
/* @var $model ConstructionType */

$this->breadcrumbs=array(
	'Construction Types'=>array('index'),
	$model->construction_type_id,
);

$this->menu=array(
	array('label'=>'List ConstructionType', 'url'=>array('index')),
	array('label'=>'Create ConstructionType', 'url'=>array('create')),
	array('label'=>'Update ConstructionType', 'url'=>array('update', 'id'=>$model->construction_type_id)),
	array('label'=>'Delete ConstructionType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->construction_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConstructionType', 'url'=>array('admin')),
);
?>

<h1>View ConstructionType #<?php echo $model->construction_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'construction_type_id',
		'construction_type_name',
		'is_active',
		'added_on',
		'added_by',
		'modified_on',
		'modified_by',
	),
)); ?>
