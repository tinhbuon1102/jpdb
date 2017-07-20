<div id="main" class="single-customer">
  <hr/>
  <ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->createUrl('site/settings'); ?>">Setting</a></li>
    <li class="bActive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Translation List</li>
  </ul>
  <hr/>
  <?php

/* @var $this WordTranslationController */

/* @var $model WordTranslation */

Yii::app()->clientScript->registerScript('search', "

$('.search-button').click(function(){

	$('.search-form').toggle();

	return false;

});

$('.search-form form').submit(function(){

	$('#word-translation-grid').yiiGridView('update', {

		data: $(this).serialize()

	});

	return false;

});

");

?>
  <h3>Translation List <i class="fa fa-plus btnAddTranslation" style="cursor:pointer;"></i></h3>
  <div class="modal-box hide" id="modelTranslation">
    <div class="content">
      <div class="box-header">
        <button type="button" class="btnModalClose" id="btnModalClose">X</button>
        <h2 class="popup-label">Add New Translation</h2>
      </div>
      <div class="box-content">
        <form name="frmTranslation" id="frmTranslation" method="post" class="text-center" data-action="<?php echo Yii::app()->createUrl('wordTranslation/createOrUpdate'); ?>">
          <input type="hidden" name="id" id="id" value="0" style="margin-top:5px;" />
          <input type="text" name="word" id="word" class="word form-input" placeholder="Word" value="" autocomplete="off" required style="margin-top:5px;"/>
          <input type="text" name="translatedWord" id="translatedWord" class="translatedWord form-input" autocomplete="off" placeholder="Transaled Word" value="" required style="margin-top:5px;"/>
          <div class="div_error" style="margin-top:5px;"><span class="form-error"></span></div>
          <button type="button" class="btn-default btnSubmit" style="margin-top:5px;">Add Word</button>
        </form>
      </div>
    </div>
  </div>
  <?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
  <div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(

	'model'=>$model,

)); ?>
  </div>
  <!-- search-form -->
  
  <?php $this->widget('zii.widgets.grid.CGridView', array(

	'id'=>'word-translation-grid',

	'dataProvider'=>$model->search(),

	'filter'=>$model,

	'htmlOptions' => array('class' => 'tbl'),

	'columns'=>array(

		//'word_translation_id',

		array(

			'name'=>'word',

			'header'=>'Original Word',


		),

		array(

			'name'=>'translation',

			'header'=>'Translated Word',


		),

		array(

			'header'=>'Action',					

			'class'=>'CButtonColumn',

			'template' => '{update} {delete}',

			'buttons' => array(

				'update'=>array(

						'label'=>'<i class="fa fa-pencil"></i>',

						'options'=>array('title'=>'Update','style'=>'margin-right:15%;'),

						'icon'=>true,

						'url'=>'Yii::app()->createUrl("wordTranslation/getTranslationData", array("id"=>$data->word_translation_id))',

						'imageUrl'=>false,

						'options' => array('class'=>'UserUpdate ajax-links'),

				),

				'delete'=>array(

						'label'=>'<i class="fa fa-trash-o"></i>',

						'options'=>array('title'=>'Delete'),

						'icon'=>true,

						'url'=>'Yii::app()->createUrl("wordTranslation/delete", array("id"=>$data->word_translation_id))',

						'imageUrl'=>false,

				),

			),

		),

	),

)); ?>
</div>
<script>

$(document).ready(function(e) {

    $(document).on('click','.btnAddTranslation',function(){

		$('#modelTranslation').removeClass('hide');

		$('#modelTranslation').addClass('show');

		$('#modelTranslation').fadeIn(1000);

	});

		//while submit modal-box

		$('.btnSubmit').click(function(e) {

			var url = $('#frmTranslation').data('action');

			addUpdateWord(url);

		});

		$(document).keypress(function(e) {

			if(e.which == 13) {

				var url = $('#frmTranslation').data('action');

				addUpdateWord(url);

			}

		});

		//while close modal-box

		$(document).on('click','.btnModalClose',function(e){

			$('#frmTranslation')[0].reset();

			$('#id').val(0);

			$('.form-error').html('');

			$('.popup-label').html('Add New Translation');

			$('.btnSubmit').html('Add Word');

		});

		

		//while edit particular row

		$(document).on('click','.ajax-links',function(e){

			e.preventDefault();

			var url = $(this).attr('href');

			call({url:url,params:{},type:'GET'},function(resp){

				console.log(resp.id);

				$('#id').val(resp.id);

				$('#word').val(resp.word);

				$('#translatedWord').val(resp.translation);

				$('.popup-label').html('Update Translation');

				$('.btnSubmit').html('Update Word');

				$('.modal-box').removeClass('hide');

				$('.modal-box').addClass('show');

				$('.modal-box').fadeIn(1000);

			});

		});

	});



function addUpdateWord(url){

	var word = $('#word').val();

	var translatedWord = $('#translatedWord').val();

		if(word != '' && translatedWord != ""){

		var id = $('#id').val();

		var url = url

		call({url:url,params:{word:word,translatedWord:translatedWord,id:id},type:'POST'},function(resp){

			//while insert data

			if(resp.status == 1){

				alert('Successfully Data Added');

				$('#typeName').val('');

				$('#id').val(0);

				$('.modal-box').removeClass('show');

				$('.modal-box').addClass('hide');

				$('.modal-box').fadeOut(1000);

				$('.popup-label').html('Add New Translation');

				$('.btnSubmit').html('Add Word');

				location.reload();

				//$.fn.yiiGridView.update('word-translation-grid');

			}

			//while update data

			if(resp.status == 2){

				alert('Successfully Data Updated');

				$('#typeName').val('');

				$('#id').val(0);

				$('.modal-box').removeClass('show');

				$('.modal-box').addClass('hide');

				$('.modal-box').fadeOut(1000);

				$('.popup-label').html('Update Translation');

				$('.btnSubmit').html('Update Word');

				location.reload();

				//$.fn.yiiGridView.update('word-translation-grid');

			}

		});

		}else{

			$('.form-error').html("Field can't be empty");

			$('.div_error').css({'width':'100%', "text-align": "left"});

			$('.form-error').css({"color": "red"});

		}

}

</script>