<?php
/* @var $this UseTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Use Types',
);

$this->menu=array(
	array('label'=>'Create UseTypes', 'url'=>array('create')),
	array('label'=>'Manage UseTypes', 'url'=>array('admin')),
);
?>

<h1>Use Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
