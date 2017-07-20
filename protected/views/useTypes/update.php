<?php
/* @var $this UseTypesController */
/* @var $model UseTypes */

$this->breadcrumbs=array(
	'Use Types'=>array('index'),
	$model->user_type_id=>array('view','id'=>$model->user_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UseTypes', 'url'=>array('index')),
	array('label'=>'Create UseTypes', 'url'=>array('create')),
	array('label'=>'View UseTypes', 'url'=>array('view', 'id'=>$model->user_type_id)),
	array('label'=>'Manage UseTypes', 'url'=>array('admin')),
);
?>

<h1>Update UseTypes <?php echo $model->user_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>