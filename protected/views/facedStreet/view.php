<?php
/* @var $this FacedStreetController */
/* @var $model FacedStreet */

$this->breadcrumbs=array(
	'Faced Streets'=>array('index'),
	$model->faced_street_id,
);

$this->menu=array(
	array('label'=>'List FacedStreet', 'url'=>array('index')),
	array('label'=>'Create FacedStreet', 'url'=>array('create')),
	array('label'=>'Update FacedStreet', 'url'=>array('update', 'id'=>$model->faced_street_id)),
	array('label'=>'Delete FacedStreet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->faced_street_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FacedStreet', 'url'=>array('admin')),
);
?>

<h1>View FacedStreet #<?php echo $model->faced_street_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'faced_street_id',
		'label',
		'parent_id',
		'is_active',
		'added_by',
		'add_on',
		'modified_by',
		'modified_on',
	),
)); ?>
