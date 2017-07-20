<?php
/* @var $this WordTranslationController */
/* @var $model WordTranslation */

$this->breadcrumbs=array(
	'Word Translations'=>array('index'),
	$model->word_translation_id,
);

$this->menu=array(
	array('label'=>'List WordTranslation', 'url'=>array('index')),
	array('label'=>'Create WordTranslation', 'url'=>array('create')),
	array('label'=>'Update WordTranslation', 'url'=>array('update', 'id'=>$model->word_translation_id)),
	array('label'=>'Delete WordTranslation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->word_translation_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WordTranslation', 'url'=>array('admin')),
);
?>

<h1>View WordTranslation #<?php echo $model->word_translation_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'word_translation_id',
		'language',
		'word',
		'translation',
	),
)); ?>
