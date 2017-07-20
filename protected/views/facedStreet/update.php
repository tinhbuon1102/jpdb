<?php
/* @var $this FacedStreetController */
/* @var $model FacedStreet */

$this->breadcrumbs=array(
	'Faced Streets'=>array('index'),
	$model->faced_street_id=>array('view','id'=>$model->faced_street_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FacedStreet', 'url'=>array('index')),
	array('label'=>'Create FacedStreet', 'url'=>array('create')),
	array('label'=>'View FacedStreet', 'url'=>array('view', 'id'=>$model->faced_street_id)),
	array('label'=>'Manage FacedStreet', 'url'=>array('admin')),
);
?>

<h1>Update FacedStreet <?php echo $model->faced_street_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>