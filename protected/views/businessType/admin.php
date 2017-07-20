<div id="main" class="single-customer">
<hr/>
<ul class="breadcrumb">
	<li><a href="<?php echo Yii::app()->createUrl('site/settings'); ?>"><?php echo Yii::app()->controller->__trans('Setting'); ?></a></li>
    <li class="bActive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo Yii::app()->controller->__trans('Business Types List'); ?></li>
</ul>
<hr/>
<?php
/* @var $this BusinessTypeController */
/* @var $model BusinessType */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#business-type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h3><?php echo Yii::app()->controller->__trans('Business Types List'); ?> <i class="fa fa-plus btnAddNew"></i></h3>
<div class="modal-box hide">
  <div class="content">
    <div class="box-header">
     <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Business Types List'); ?></h2>
    </div>
    <div class="box-content">
    	<form name="frmBusinessType" id="frmBusinessType" method="post" class="text-center" action="">
      		<input type="hidden" name="id" id="id" value="0" />
            <input type="text" name="typeName" id="typeName" class="typeName form-input" placeholder="Business Type Name" value="" required/>
            <div class="div_error"><span class="form-error"></span></div>
            <button type="button" class="btn-default btnSubmit"><?php echo Yii::app()->controller->__trans('Add Type'); ?></button>
            
      	</form>
    </div>
  </div>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'business-type-grid',
	'htmlOptions' => array('class' => 'tbl'),
	'dataProvider'=>$model->search(),
	'columns'=>array(
		array(
			'name'=>'business_name',
			'filter'=>false,
		),
		array(
			'header'=>'Status',
			'name'=>'is_active',
			'filter'=>false,
			'value'=>function($data,$row){
				if($data->is_active == 1){
					return  '<a href="'.Yii::app()->createUrl('businessType/changeStatus',array('id'=>$data->business_type_id,'is_active'=>0)).'" class="ajax-status"><i class="fa fa-check"></i></a>';
				}
				if($data->is_active == 0){
					return  '<a href="'.Yii::app()->createUrl('businessType/changeStatus',array('id'=>$data->business_type_id,'is_active'=>1)).'" class="ajax-status"><i class="fa fa-times"></i></a>';
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
		array(
			'header'=>'Action',					
			'class'=>'CButtonColumn',
			'template' => '{update} {delete}',
			'buttons' => array(
				'update'=>array(
						'label'=>'<i class="fa fa-pencil"></i>',
						'options'=>array('title'=>'Update','style'=>'margin-right:15%;'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("businessType/getTypeData", array("id"=>$data->business_type_id))',
						'imageUrl'=>false,
						'options' => array('class'=>'UserUpdate ajax-link'),
				),
				'delete'=>array(
						'label'=>'<i class="fa fa-trash-o"></i>',
						'options'=>array('title'=>'Delete'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("businessType/delete", array("id"=>$data->business_type_id))',
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
		$('#frmBusinessType')[0].reset();
		$('#id').val(0);
		$('.form-error').html('');
		$('.popup-label').html('Add New Business Type');
		$('.btnSubmit').html('Add Type');
	});
	
	//while edit particular row
	$(document).on('click','.ajax-link',function(e){
        e.preventDefault();
		var url = $(this).attr('href');
		call({url:url,params:{},type:'GET'},function(resp){
			$('#id').val(resp.id);
			$('#typeName').val(resp.name);
			$('.popup-label').html('Update Business Type');
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
				$.fn.yiiGridView.update('business-type-grid');
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
		var url = '<?php echo Yii::app()->createUrl('businessType/createOrUpdate'); ?>';
		call({url:url,params:{name:typeName,id:id},type:'POST'},function(resp){
			//while insert data
			if(resp.status == 1){
				alert('Successfully Data Added');
				$('#typeName').val('');
				$('#id').val(0);
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$('.popup-label').html('Add New Business Type');
				$('.btnSubmit').html('Add Type');
				$.fn.yiiGridView.update('business-type-grid');
			}
			//while update data
			if(resp.status == 2){
				alert('Successfully Data Updated');
				$('#typeName').val('');
				$('#id').val(0);
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$('.popup-label').html('Update New Business Type');
				$('.btnSubmit').html('Add Type');
				$.fn.yiiGridView.update('business-type-grid');
			}
		});
		}else{
			$('.form-error').html("Field can't be empty");
			$('.div_error').css({'width':'100%', "text-align": "left"});
			$('.form-error').css({"color": "red"});
		}
}
</script>