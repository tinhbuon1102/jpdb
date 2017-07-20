<?php
/* @var $this SecurityController */
/* @var $model Security */

$this->breadcrumbs=array(
	'Securities'=>array('index'),
	$model->security_id=>array('view','id'=>$model->security_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Security', 'url'=>array('index')),
	array('label'=>'Create Security', 'url'=>array('create')),
	array('label'=>'View Security', 'url'=>array('view', 'id'=>$model->security_id)),
	array('label'=>'Manage Security', 'url'=>array('admin')),
);
?>

<h1>Update Security <?php echo $model->security_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>