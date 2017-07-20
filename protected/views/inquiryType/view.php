<?php
/* @var $this InquiryTypeController */
/* @var $model InquiryType */

$this->breadcrumbs=array(
	'Inquiry Types'=>array('index'),
	$model->inquiry_id,
);

$this->menu=array(
	array('label'=>'List InquiryType', 'url'=>array('index')),
	array('label'=>'Create InquiryType', 'url'=>array('create')),
	array('label'=>'Update InquiryType', 'url'=>array('update', 'id'=>$model->inquiry_id)),
	array('label'=>'Delete InquiryType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->inquiry_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InquiryType', 'url'=>array('admin')),
);
?>

<h1>View InquiryType #<?php echo $model->inquiry_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'inquiry_id',
		'inquiry_name',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
		'is_active',
	),
)); ?>
