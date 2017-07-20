<?php
/* @var $this TradersController */
/* @var $model Traders */

$this->breadcrumbs=array(
	'Traders'=>array('index'),
	$model->trader_id=>array('view','id'=>$model->trader_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Traders', 'url'=>array('index')),
	array('label'=>'Create Traders', 'url'=>array('create')),
	array('label'=>'View Traders', 'url'=>array('view', 'id'=>$model->trader_id)),
	array('label'=>'Manage Traders', 'url'=>array('admin')),
);
?>

<h1>Update Traders <?php echo $model->trader_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>