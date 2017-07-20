<div id="main" class="single-customer">
<hr/>
<ul class="breadcrumb">
	<li><a href="<?php echo Yii::app()->createUrl('site/settings'); ?>">Setting</a></li>
    <li class="bActive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Region List</li>
</ul>
<hr/>
<?php
/* @var $this RegionController */
/* @var $model Region */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#region-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h3>Region List <i class="fa fa-plus btnAddRegion" title="Add New Region"></i></h3>

<!--Modal Popup for Add New Region-->
<div class="modal-box hide" id="addModal">
  <div class="content">
    <div class="box-header">
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label">Add New Region</h2>
    </div>
    <div class="box-content">
    	<form name="frmRegion" id="frmRegion"  method="post" class="text-center" data-action="<?php echo Yii::app()->createUrl('region/createOrUpdate'); ?>">
            tets
            <input type="hidden" name="id" id="id" value="0" />
            <input type="text" name="regionName" id="regionName" class="regionName form-input" placeholder="Region Name" value="" required/>
            <select name="regionPrefecture[]" id="regionPrefecture" class="regionPrefecture" multiple size="10">
                <option value="">- Select Prefecture -</option>
                <?php
                $prefectureList = Prefecture::model()->findAlL();
                if(isset($prefectureList) && count($prefectureList) > 0){
                    foreach($prefectureList as $prefecture){
                ?>
                <option value="<?php echo $prefecture['prefecture_id']; ?>"><?php echo $prefecture['prefecture_name']; ?></option>
                <?php
                    }
                }
                ?>
            </select>
            <div class="div_error"><span class="form-error"></span></div>
            <button type="button" class="btn-default btnSubmit">Add Region</button>
      	</form>
    </div>
  </div>
</div>

<!--Modal Popup for Update Region-->
<div class="modal-box hide" id="modalUpdate">
  <div class="content">
    <div class="box-header">
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label">Update Region</h2>
    </div>
    <div class="box-content">
    	<form name="frmUpdateRegion" id="frmUpdateRegion"  method="post" class="text-center" data-action="<?php echo Yii::app()->createUrl('region/createOrUpdate'); ?>">
      		<div class="divRegion"></div>
            <div class="div_error"><span class="form-error"></span></div>
            <button type="button" class="btn-default btnUpdateSubmit">Update Region</button>
      	</form>
    </div>
  </div>
</div>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'region-grid',
	'dataProvider'=>$model->search(),
	'htmlOptions' => array('class' => 'tbl'),
	'columns'=>array(
		//'region_id',
		array(
			'name'=>'region_name',
			'header'=>'Region',
			'filter'=>false
		),
		array(
			'name'=>'prefectures',
			'filter'=>false,
			'value'=>'$data->getRegionPrefecture($data->region_id)',
			'type'=>'raw',
		),
		array(
			'name'=>'added_on',
			'filter'=>false
		),
		array(
			'name'=>'modified_on',
			'filter'=>false
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
						'url'=>'Yii::app()->createUrl("region/getRegionData", array("id"=>$data->region_id))',
						'imageUrl'=>false,
						'options' => array('class'=>'UserUpdate ajax-link'),
				),
				'delete'=>array(
						'label'=>'<i class="fa fa-trash-o"></i>',
						'options'=>array('title'=>'Delete'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("region/delete", array("id"=>$data->region_id))',
						'imageUrl'=>false,
				),
			),
		),
	),
)); ?>
</div>

<script>
$(document).ready(function(e) {
	$(document).on('click','.btnAddRegion',function(){
		$('#addModal').removeClass('hide');
		$('#addModal').addClass('show');
		$('#addModal').fadeIn(1000);
	});
	//while submit modal-box
    $('.btnSubmit').click(function(e) {
        addRegion();
    });
	$(document).keypress(function(e) {
		if(e.which == 13) {
			addRegion();
		}
	});
	$(document).on('click','.btnUpdateSubmit',function(){
		var regionName = $(this).closest('.divRegion').find('.upRegionName').val();
		var regionPrefecture = $(this).closest('.divRegion').find('.upRegionName').val();
		if(regionName != '' && regionPrefecture != ""){
			updateRegion();
		}else{
			$('.form-error').html("Field can't be empty");
			$('.div_error').css({'width':'100%', "text-align": "left"});
			$('.form-error').css({"color": "red"});
		}
	});
	$(document).keypress(function(e) {
		if(e.which == 13) {
			var regionName = $(this).closest('.divRegion').find('.upRegionName').val();
			var regionPrefecture = $(this).closest('.divRegion').find('.upRegionName').val();
			if(regionName != '' && regionPrefecture != ""){
				updateRegion();
			}else{
				$('.form-error').html("Field can't be empty");
				$('.div_error').css({'width':'100%', "text-align": "left"});
				$('.form-error').css({"color": "red"});
			}
		}
	});
	//while close modal-box
	$(document).on('click','.btnModalClose',function(e){
		$('#frmRegion')[0].reset();
		$('.form-error').html('');
	});
	
	//while edit particular row
	$(document).on('click','.ajax-link',function(e){
        e.preventDefault();
		var url = $(this).attr('href');
		call({url:url,params:{},type:'GET'},function(resp){
			$('.divRegion').html(resp);
			$('#modalUpdate').removeClass('hide');
			$('#modalUpdate').addClass('show');
			$('#modalUpdate').fadeIn(1000);
		});
    });
});

function addRegion(){
	var regionName = $('.regionName').val();
	var regionPrefecture = $('.regionPrefecture').val();
		if(regionName != '' && regionPrefecture != ""){
		var id = $('#id').val();
		var formdata = $('#frmRegion').serialize();
		var url = $('#frmRegion').data('action');
		call({url:url,params:{formdata:formdata},type:'POST'},function(resp){
			//while insert data
			if(resp.status == 1){
				alert('Successfully Data Added');
				$.fn.yiiGridView.update('region-grid');
				$('#frmRegion')[0].reset();
				$('.btnModalClose').trigger('click');
				//location.reload();
			}
		});
		}else{
			$('.form-error').html("Field can't be empty");
			$('.div_error').css({'width':'100%', "text-align": "left"});
			$('.form-error').css({"color": "red"});
		}
}
function updateRegion(){
	var formdata = $('#frmUpdateRegion').serialize();
	var url = $('#frmUpdateRegion').data('action');
	call({url:url,params:{formdata:formdata},type:'POST'},function(resp){
		//while update data
		if(resp.status == 2){
			alert('Successfully Data Updated');
			$.fn.yiiGridView.update('region-grid');
			$('.btnModalClose').trigger('click');
			//location.reload();
		}
	});
}
</script>