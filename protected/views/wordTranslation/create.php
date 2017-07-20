<?php
/* @var $this WordTranslationController */
/* @var $model WordTranslation */

$this->breadcrumbs=array(
	'Word Translations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WordTranslation', 'url'=>array('index')),
	array('label'=>'Manage WordTranslation', 'url'=>array('admin')),
);
?>

<h1>Create WordTranslation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>