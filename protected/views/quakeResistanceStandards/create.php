<?php
/* @var $this QuakeResistanceStandardsController */
/* @var $model QuakeResistanceStandards */

$this->breadcrumbs=array(
	'Quake Resistance Standards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List QuakeResistanceStandards', 'url'=>array('index')),
	array('label'=>'Manage QuakeResistanceStandards', 'url'=>array('admin')),
);
?>

<h1>Create QuakeResistanceStandards</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>