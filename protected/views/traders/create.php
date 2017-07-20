<?php
/* @var $this TradersController */
/* @var $model Traders */

$this->breadcrumbs=array(
	'Traders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Traders', 'url'=>array('index')),
	array('label'=>'Manage Traders', 'url'=>array('admin')),
);
?>

<h1>Create Traders</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>