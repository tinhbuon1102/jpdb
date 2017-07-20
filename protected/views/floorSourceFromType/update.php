<?php
/* @var $this FloorSourceFromTypeController */
/* @var $model FloorSourceFromType */

$this->breadcrumbs=array(
	'Floor Source From Types'=>array('index'),
	$model->floor_source_from_type_id=>array('view','id'=>$model->floor_source_from_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FloorSourceFromType', 'url'=>array('index')),
	array('label'=>'Create FloorSourceFromType', 'url'=>array('create')),
	array('label'=>'View FloorSourceFromType', 'url'=>array('view', 'id'=>$model->floor_source_from_type_id)),
	array('label'=>'Manage FloorSourceFromType', 'url'=>array('admin')),
);
?>

<h1>Update FloorSourceFromType <?php echo $model->floor_source_from_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>