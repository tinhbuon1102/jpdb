<?php
/* @var $this PropertyTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Property Types',
);

$this->menu=array(
	array('label'=>'Create PropertyType', 'url'=>array('create')),
	array('label'=>'Manage PropertyType', 'url'=>array('admin')),
);
?>

<h1>Property Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
