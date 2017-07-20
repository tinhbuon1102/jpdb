<?php
/* @var $this IntroducerController */
/* @var $model Introducer */

$this->breadcrumbs=array(
	'Introducers'=>array('index'),
	$model->introducer_id=>array('view','id'=>$model->introducer_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Introducer', 'url'=>array('index')),
	array('label'=>'Create Introducer', 'url'=>array('create')),
	array('label'=>'View Introducer', 'url'=>array('view', 'id'=>$model->introducer_id)),
	array('label'=>'Manage Introducer', 'url'=>array('admin')),
);
?>

<h1>Update Introducer <?php echo $model->introducer_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>