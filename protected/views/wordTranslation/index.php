<?php
/* @var $this WordTranslationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Word Translations',
);

$this->menu=array(
	array('label'=>'Create WordTranslation', 'url'=>array('create')),
	array('label'=>'Manage WordTranslation', 'url'=>array('admin')),
);
?>

<h1>Word Translations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
