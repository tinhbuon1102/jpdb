<?php
/* @var $this FloorSourceFromTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Floor Source From Types',
);

$this->menu=array(
	array('label'=>'Create FloorSourceFromType', 'url'=>array('create')),
	array('label'=>'Manage FloorSourceFromType', 'url'=>array('admin')),
);
?>

<h1>Floor Source From Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
