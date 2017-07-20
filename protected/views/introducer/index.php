<?php
/* @var $this IntroducerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Introducers',
);

$this->menu=array(
	array('label'=>'Create Introducer', 'url'=>array('create')),
	array('label'=>'Manage Introducer', 'url'=>array('admin')),
);
?>

<h1>Introducers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
