<?php
/* @var $this InquiryTypeController */
/* @var $model InquiryType */

$this->breadcrumbs=array(
	'Inquiry Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InquiryType', 'url'=>array('index')),
	array('label'=>'Manage InquiryType', 'url'=>array('admin')),
);
?>

<h1>Create InquiryType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>