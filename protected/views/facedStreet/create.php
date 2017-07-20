<?php
/* @var $this FacedStreetController */
/* @var $model FacedStreet */

$this->breadcrumbs=array(
	'Faced Streets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FacedStreet', 'url'=>array('index')),
	array('label'=>'Manage FacedStreet', 'url'=>array('admin')),
);
?>

<h1>Create FacedStreet</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>