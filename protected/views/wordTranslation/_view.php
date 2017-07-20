<?php
/* @var $this WordTranslationController */
/* @var $data WordTranslation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('word_translation_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->word_translation_id), array('view', 'id'=>$data->word_translation_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('language')); ?>:</b>
	<?php echo CHtml::encode($data->language); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('word')); ?>:</b>
	<?php echo CHtml::encode($data->word); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('translation')); ?>:</b>
	<?php echo CHtml::encode($data->translation); ?>
	<br />


</div>