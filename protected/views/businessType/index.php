<?php
/* @var $this BusinessTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Business Types',
);

$this->menu=array(
	array('label'=>'Create BusinessType', 'url'=>array('create')),
	array('label'=>'Manage BusinessType', 'url'=>array('admin')),
);
?>

<h1>Business Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	 'htmlOptions' => array('class' => 'example')
)); ?>
