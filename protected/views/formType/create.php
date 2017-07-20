<?php
/* @var $this FormTypeController */
/* @var $model FormType */

$this->breadcrumbs=array(
	'Form Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FormType', 'url'=>array('index')),
	array('label'=>'Manage FormType', 'url'=>array('admin')),
);
?>

<h1>Create FormType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>