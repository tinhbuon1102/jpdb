<div id="main" class="single-customer">
<hr/>
<ul class="breadcrumb">
	<li><a href="<?php echo Yii::app()->createUrl('site/settings'); ?>">Setting</a></li>
    <li class="bActive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Floor Source Type List</li>
</ul>
<hr/>
<?php
/* @var $this FloorSourceFromTypeController */
/* @var $model FloorSourceFromType */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#floor-source-from-type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Floor Source Types List <i class="fa fa-plus btnAddNew"></i></h3>
<div class="modal-box hide">
  <div class="content">
    <div class="box-header">
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label">Add New Floor Source Type</h2>
    </div>
    <div class="box-content">
    	<form name="frmFloorSourceType" id="frmFloorSourceType" method="post" class="text-center" action="">
      		<input type="hidden" name="id" id="id" value="0" />
            <input type="text" name="typeName" id="typeName" class="typeName form-input" placeholder="Floor Source Type Name" value="" required/>
            <div class="div_error"><span class="form-error"></span></div>
            <button type="button" class="btn-default btnSubmit">Add Type</button>
            
      	</form>
    </div>
  </div>
</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'floor-source-from-type-grid',
	'htmlOptions' => array('class' => 'tbl'),
	'dataProvider'=>$model->search(),
	'columns'=>array(
		array(
				'name'=>'floor_source_from_type_name',
				'filter'=>false,
			),
			array(
			'header'=>'Status',
			'name'=>'is_active',
			'filter'=>false,
			'value'=>function($data,$row){
				if($data->is_active == 1){
					return  '<a href="'.Yii::app()->createUrl('floorSourceFromType/changeStatus',array('id'=>$data->floor_source_from_type_id,'is_active'=>0)).'" class="ajax-status"><i class="fa fa-check"></i></a>';
				}
				if($data->is_active == 0){
					return  '<a href="'.Yii::app()->createUrl('floorSourceFromType/changeStatus',array('id'=>$data->floor_source_from_type_id,'is_active'=>1)).'" class="ajax-status"><i class="fa fa-times"></i></a>';
				}
			},
			'type'=>'raw',
		),
		array(
			'name'=>'added_on',
			'filter'=>false,
		),
		array(
			'name'=>'modified_on',
			'filter'=>false,
		),
		/*
		'modified_on',
		*/
		array(
			'header'=>'Action',					
			'class'=>'CButtonColumn',
			'template' => '{update} {delete}',
			'buttons' => array(
				'update'=>array(
						'label'=>'<i class="fa fa-pencil"></i>',
						'options'=>array('title'=>'Update','style'=>'margin-right:15%;'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("floorSourceFromType/getTypeData", array("id"=>$data->floor_source_from_type_id))',
						'imageUrl'=>false,
						'options' => array('class'=>'UserUpdate ajax-link'),
				),
				'delete'=>array(
						'label'=>'<i class="fa fa-trash-o"></i>',
						'options'=>array('title'=>'Delete'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("floorSourceFromType/delete", array("id"=>$data->floor_source_from_type_id))',
						'imageUrl'=>false,
				),
			),
		),
	),
)); ?>

</div>
<script>
$(document).ready(function(e) {
	//while submit modal-box
    $('.btnSubmit').click(function(e) {
        addUpdateType();
    });
	$(document).keypress(function(e) {
		if(e.which == 13) {
			addUpdateType();
		}
	});
	//while close modal-box
	$(document).on('click','.btnModalClose',function(e){
		$('#frmFloorSourceType')[0].reset();
		$('#id').val(0);
		$('.form-error').html('');
		$('.popup-label').html('Add New Floor Source Type');
		$('.btnSubmit').html('Add Type');
	});
	
	//while edit particular row
	$(document).on('click','.ajax-link',function(e){
        e.preventDefault();
		var url = $(this).attr('href');
		call({url:url,params:{},type:'GET'},function(resp){
			$('#id').val(resp.id);
			$('#typeName').val(resp.name);
			$('.popup-label').html('Update Floor Source Type');
			$('.btnSubmit').html('Update Type');
			$('.modal-box').removeClass('hide');
			$('.modal-box').addClass('show');
			$('.modal-box').fadeIn(1000);
		});
    });
	
	//while change the status
	$(document).on('click','.ajax-status',function(e){
        e.preventDefault();
		var url = $(this).attr('href');
		call({url:url,params:{},type:'GET'},function(resp){
			if(resp.success == 1){
				$.fn.yiiGridView.update('floor-source-from-type-grid');
			}else{
				alert('Something went wrong.');
			}
		});
    });
});

function addUpdateType(){
	var typeName = $('#typeName').val();
		if(typeName != ''){
		var id = $('#id').val();
		var url = '<?php echo Yii::app()->createUrl('floorSourceFromType/createOrUpdate'); ?>';
		call({url:url,params:{name:typeName,id:id},type:'POST'},function(resp){
			//while insert data
			if(resp.status == 1){
				alert('Successfully Data Added');
				$('#typeName').val('');
				$('#id').val(0);
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$('.popup-label').html('Add New Floor Source Type');
				$('.btnSubmit').html('Add Type');
				$.fn.yiiGridView.update('floor-source-from-type-grid');
			}
			//while update data
			if(resp.status == 2){
				alert('Successfully Data Updated');
				$('#typeName').val('');
				$('#id').val(0);
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$('.popup-label').html('Update Floor Source Type');
				$('.btnSubmit').html('Update Type');
				$.fn.yiiGridView.update('floor-source-from-type-grid');
			}
		});
		}else{
			$('.form-error').html("Field can't be empty");
			$('.div_error').css({'width':'100%', "text-align": "left"});
			$('.form-error').css({"color": "red"});
		}
}
</script>
