<?php
/* @var $this WordTranslationController */
/* @var $model WordTranslation */

$this->breadcrumbs=array(
	'Word Translations'=>array('index'),
	$model->word_translation_id=>array('view','id'=>$model->word_translation_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WordTranslation', 'url'=>array('index')),
	array('label'=>'Create WordTranslation', 'url'=>array('create')),
	array('label'=>'View WordTranslation', 'url'=>array('view', 'id'=>$model->word_translation_id)),
	array('label'=>'Manage WordTranslation', 'url'=>array('admin')),
);
?>

<h1>Update WordTranslation <?php echo $model->word_translation_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>