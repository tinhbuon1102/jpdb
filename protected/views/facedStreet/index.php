<?php
/* @var $this FacedStreetController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Faced Streets',
);

$this->menu=array(
	array('label'=>'Create FacedStreet', 'url'=>array('create')),
	array('label'=>'Manage FacedStreet', 'url'=>array('admin')),
);
?>

<h1>Faced Streets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
