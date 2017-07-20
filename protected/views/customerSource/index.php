<?php
/* @var $this CustomerSourceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Customer Sources',
);

$this->menu=array(
	array('label'=>'Create CustomerSource', 'url'=>array('create')),
	array('label'=>'Manage CustomerSource', 'url'=>array('admin')),
);
?>

<h1>Customer Sources</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
