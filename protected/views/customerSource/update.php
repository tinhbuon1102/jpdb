<?php
/* @var $this CustomerSourceController */
/* @var $model CustomerSource */

$this->breadcrumbs=array(
	'Customer Sources'=>array('index'),
	$model->customer_source_id=>array('view','id'=>$model->customer_source_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CustomerSource', 'url'=>array('index')),
	array('label'=>'Create CustomerSource', 'url'=>array('create')),
	array('label'=>'View CustomerSource', 'url'=>array('view', 'id'=>$model->customer_source_id)),
	array('label'=>'Manage CustomerSource', 'url'=>array('admin')),
);
?>

<h1>Update CustomerSource <?php echo $model->customer_source_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>