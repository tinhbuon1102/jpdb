<?php
/* @var $this BusinessTypeController */
/* @var $model BusinessType */

$this->breadcrumbs=array(
	'Business Types'=>array('index'),
	$model->business_type_id,
);

$this->menu=array(
	array('label'=>'List BusinessType', 'url'=>array('index')),
	array('label'=>'Create BusinessType', 'url'=>array('create')),
	array('label'=>'Update BusinessType', 'url'=>array('update', 'id'=>$model->business_type_id)),
	array('label'=>'Delete BusinessType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->business_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BusinessType', 'url'=>array('admin')),
);
?>

<h1>View BusinessType #<?php echo $model->business_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'business_type_id',
		'business_name',
		'is_active',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
	),
)); ?>
