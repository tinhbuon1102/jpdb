<?php
/* @var $this CustomerSourceController */
/* @var $model CustomerSource */

$this->breadcrumbs=array(
	'Customer Sources'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CustomerSource', 'url'=>array('index')),
	array('label'=>'Manage CustomerSource', 'url'=>array('admin')),
);
?>

<h1>Create CustomerSource</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>