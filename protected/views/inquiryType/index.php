<?php
/* @var $this InquiryTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inquiry Types',
);

$this->menu=array(
	array('label'=>'Create InquiryType', 'url'=>array('create')),
	array('label'=>'Manage InquiryType', 'url'=>array('admin')),
);
?>

<h1>Inquiry Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
