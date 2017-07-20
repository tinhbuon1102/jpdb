<?php
/* @var $this InquiryTypeController */
/* @var $model InquiryType */

$this->breadcrumbs=array(
	'Inquiry Types'=>array('index'),
	$model->inquiry_id=>array('view','id'=>$model->inquiry_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InquiryType', 'url'=>array('index')),
	array('label'=>'Create InquiryType', 'url'=>array('create')),
	array('label'=>'View InquiryType', 'url'=>array('view', 'id'=>$model->inquiry_id)),
	array('label'=>'Manage InquiryType', 'url'=>array('admin')),
);
?>

<h1>Update InquiryType <?php echo $model->inquiry_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>