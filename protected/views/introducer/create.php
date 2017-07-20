<?php
/* @var $this IntroducerController */
/* @var $model Introducer */

$this->breadcrumbs=array(
	'Introducers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Introducer', 'url'=>array('index')),
	array('label'=>'Manage Introducer', 'url'=>array('admin')),
);
?>

<h1>Create Introducer</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>