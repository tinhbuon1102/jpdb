<?php
/* @var $this ConstructionTypeController */
/* @var $model ConstructionType */

$this->breadcrumbs=array(
	'Construction Types'=>array('index'),
	$model->construction_type_id=>array('view','id'=>$model->construction_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConstructionType', 'url'=>array('index')),
	array('label'=>'Create ConstructionType', 'url'=>array('create')),
	array('label'=>'View ConstructionType', 'url'=>array('view', 'id'=>$model->construction_type_id)),
	array('label'=>'Manage ConstructionType', 'url'=>array('admin')),
);
?>

<h1>Update ConstructionType <?php echo $model->construction_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>