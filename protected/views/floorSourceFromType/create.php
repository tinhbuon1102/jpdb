<?php
/* @var $this FloorSourceFromTypeController */
/* @var $model FloorSourceFromType */

$this->breadcrumbs=array(
	'Floor Source From Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FloorSourceFromType', 'url'=>array('index')),
	array('label'=>'Manage FloorSourceFromType', 'url'=>array('admin')),
);
?>

<h1>Create FloorSourceFromType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>