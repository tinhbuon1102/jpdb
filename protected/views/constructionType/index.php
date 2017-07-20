<?php
/* @var $this ConstructionTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Construction Types',
);

$this->menu=array(
	array('label'=>'Create ConstructionType', 'url'=>array('create')),
	array('label'=>'Manage ConstructionType', 'url'=>array('admin')),
);
?>

<h1>Construction Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
