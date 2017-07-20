<?php
/* @var $this SecurityController */
/* @var $model Security */

$this->breadcrumbs=array(
	'Securities'=>array('index'),
	$model->security_id,
);

$this->menu=array(
	array('label'=>'List Security', 'url'=>array('index')),
	array('label'=>'Create Security', 'url'=>array('create')),
	array('label'=>'Update Security', 'url'=>array('update', 'id'=>$model->security_id)),
	array('label'=>'Delete Security', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->security_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Security', 'url'=>array('admin')),
);
?>

<h1>View Security #<?php echo $model->security_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'security_id',
		'security_name',
		'is_active',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
	),
)); ?>
