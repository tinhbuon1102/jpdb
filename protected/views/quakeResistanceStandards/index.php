<?php
/* @var $this QuakeResistanceStandardsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Quake Resistance Standards',
);

$this->menu=array(
	array('label'=>'Create QuakeResistanceStandards', 'url'=>array('create')),
	array('label'=>'Manage QuakeResistanceStandards', 'url'=>array('admin')),
);
?>

<h1>Quake Resistance Standards</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
