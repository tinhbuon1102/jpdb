<?php
/* @var $this BusinessTypeController */
/* @var $model BusinessType */

$this->breadcrumbs=array(
	'Business Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BusinessType', 'url'=>array('index')),
	array('label'=>'Manage BusinessType', 'url'=>array('admin')),
);
?>

<h1>Create BusinessType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>