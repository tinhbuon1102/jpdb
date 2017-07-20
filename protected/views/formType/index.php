<?php
/* @var $this FormTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Form Types',
);

$this->menu=array(
	array('label'=>'Create FormType', 'url'=>array('create')),
	array('label'=>'Manage FormType', 'url'=>array('admin')),
);
?>

<h1>Form Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
