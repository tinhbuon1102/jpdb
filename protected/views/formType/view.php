<?php
/* @var $this FormTypeController */
/* @var $model FormType */

$this->breadcrumbs=array(
	'Form Types'=>array('index'),
	$model->form_type_id,
);

$this->menu=array(
	array('label'=>'List FormType', 'url'=>array('index')),
	array('label'=>'Create FormType', 'url'=>array('create')),
	array('label'=>'Update FormType', 'url'=>array('update', 'id'=>$model->form_type_id)),
	array('label'=>'Delete FormType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->form_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FormType', 'url'=>array('admin')),
);
?>

<h1>View FormType #<?php echo $model->form_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'form_type_id',
		'form_type_name',
		'is_active',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
	),
)); ?>
