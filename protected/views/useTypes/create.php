<?php
/* @var $this UseTypesController */
/* @var $model UseTypes */

$this->breadcrumbs=array(
	'Use Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UseTypes', 'url'=>array('index')),
	array('label'=>'Manage UseTypes', 'url'=>array('admin')),
);
?>

<h1>Create UseTypes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>