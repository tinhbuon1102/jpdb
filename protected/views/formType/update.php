<?php
/* @var $this FormTypeController */
/* @var $model FormType */

$this->breadcrumbs=array(
	'Form Types'=>array('index'),
	$model->form_type_id=>array('view','id'=>$model->form_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FormType', 'url'=>array('index')),
	array('label'=>'Create FormType', 'url'=>array('create')),
	array('label'=>'View FormType', 'url'=>array('view', 'id'=>$model->form_type_id)),
	array('label'=>'Manage FormType', 'url'=>array('admin')),
);
?>

<h1>Update FormType <?php echo $model->form_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>