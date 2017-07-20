<?php
/* @var $this QuakeResistanceStandardsController */
/* @var $model QuakeResistanceStandards */

$this->breadcrumbs=array(
	'Quake Resistance Standards'=>array('index'),
	$model->quake_resistance_standard_id=>array('view','id'=>$model->quake_resistance_standard_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List QuakeResistanceStandards', 'url'=>array('index')),
	array('label'=>'Create QuakeResistanceStandards', 'url'=>array('create')),
	array('label'=>'View QuakeResistanceStandards', 'url'=>array('view', 'id'=>$model->quake_resistance_standard_id)),
	array('label'=>'Manage QuakeResistanceStandards', 'url'=>array('admin')),
);
?>

<h1>Update QuakeResistanceStandards <?php echo $model->quake_resistance_standard_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>