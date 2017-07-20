<?php
/* @var $this PropertyTypeController */
/* @var $model PropertyType */

$this->breadcrumbs=array(
	'Property Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PropertyType', 'url'=>array('index')),
	array('label'=>'Manage PropertyType', 'url'=>array('admin')),
);
?>

<h1>Create PropertyType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>