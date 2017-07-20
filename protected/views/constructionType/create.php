<?php
/* @var $this ConstructionTypeController */
/* @var $model ConstructionType */

$this->breadcrumbs=array(
	'Construction Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConstructionType', 'url'=>array('index')),
	array('label'=>'Manage ConstructionType', 'url'=>array('admin')),
);
?>

<h1>Create ConstructionType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>