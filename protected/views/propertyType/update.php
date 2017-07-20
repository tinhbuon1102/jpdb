<?php
/* @var $this PropertyTypeController */
/* @var $model PropertyType */

$this->breadcrumbs=array(
	'Property Types'=>array('index'),
	$model->property_type_id=>array('view','id'=>$model->property_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PropertyType', 'url'=>array('index')),
	array('label'=>'Create PropertyType', 'url'=>array('create')),
	array('label'=>'View PropertyType', 'url'=>array('view', 'id'=>$model->property_type_id)),
	array('label'=>'Manage PropertyType', 'url'=>array('admin')),
);
?>

<h1>Update PropertyType <?php echo $model->property_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>