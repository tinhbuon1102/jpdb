<?php
/* @var $this TradersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Traders',
);

$this->menu=array(
	array('label'=>'Create Traders', 'url'=>array('create')),
	array('label'=>'Manage Traders', 'url'=>array('admin')),
);
?>

<h1>Traders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
