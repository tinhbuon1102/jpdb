<?php
/* @var $this BusinessTypeController */
/* @var $model BusinessType */

$this->breadcrumbs=array(
	'Business Types'=>array('index'),
	$model->business_type_id=>array('view','id'=>$model->business_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BusinessType', 'url'=>array('index')),
	array('label'=>'Create BusinessType', 'url'=>array('create')),
	array('label'=>'View BusinessType', 'url'=>array('view', 'id'=>$model->business_type_id)),
	array('label'=>'Manage BusinessType', 'url'=>array('admin')),
);
?>

<h1>Update BusinessType <?php echo $model->business_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>