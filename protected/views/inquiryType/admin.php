<div id="main" class="single-customer">
<hr/>
<ul class="breadcrumb">
	<li><a href="<?php echo Yii::app()->createUrl('site/settings'); ?>"><?php echo Yii::app()->controller->__trans('Setting'); ?></a></li>
    <li class="bActive"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo Yii::app()->controller->__trans(' Inquiry Types List'); ?></li>
</ul>
<hr/>
<?php
/* @var $this InquiryTypeController */
/* @var $model InquiryType */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#inquiry-type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3><?php echo Yii::app()->controller->__trans('Inquiry Types List'); ?> <i class="fa fa-plus btnAddNew" title="Add New Type"></i></h3>

<!--Modal Popup for Add New Type-->
<div class="modal-box hide">
  <div class="content">
    <div class="box-header">
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Add New Inquiry Type'); ?></h2>
    </div>
    <div class="box-content">
    	<form name="frmInquiryType" id="frmInquiryType" method="post" class="text-center" action="">
      		<input type="hidden" name="id" id="id" value="0" />
            <input type="text" name="typeName" id="typeName" class="typeName form-input" placeholder="Inquiry Type Name" value="" required/>
            <div class="div_error"><span class="form-error"></span></div>
            <button type="button" class="btn-default btnSubmit"><?php echo Yii::app()->controller->__trans('Add Type'); ?></button>
            
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
	'id'=>'inquiry-type-grid',
	'dataProvider'=>$model->search(),
	'htmlOptions' => array('class' => 'tbl'),
	'columns'=>array(
		//'inquiry_id',
		array(
			'name'=>'inquiry_name',
			'filter'=>false
		),
		array(
			'header'=>'Status',
			'name'=>'is_active',
			'filter'=>false,
			'value'=>function($data,$row){
				if($data->is_active==1){
					return '<a href="'.Yii::app()->createUrl('inquiryType/changestatus',array('id'=>$data->inquiry_id,'is_active'=>'0')).'" class="btn btn-danger btn-sm ajax-status"><i class="fa fa-check"></i></a>';
				}
				if($data->is_active==0){
					return '<a href="'.Yii::app()->createUrl('inquiryType/changestatus',array('id'=>$data->inquiry_id,'is_active'=>'1')).'" class="btn btn-success btn-sm ajax-status"><i class="fa fa-times"></i></a>';
				}
			},
			'type'=>'raw'
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
						'url'=>'Yii::app()->createUrl("inquiryType/getTypeData", array("id"=>$data->inquiry_id))',
						'imageUrl'=>false,
						'options' => array('class'=>'UserUpdate ajax-link'),
						/*'click'=>"function($data){
							updateType($data->construction_type_id);
						  }
						",*/
				),
				'delete'=>array(
						'label'=>'<i class="fa fa-trash-o"></i>',
						'options'=>array('title'=>'Delete'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("inquiryType/delete", array("id"=>$data->inquiry_id))',
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
		$('#frmInquiryType')[0].reset();
		$('.id').val(0);
		$('.form-error').html('');
		$('.popup-label').html('Add New Inquiry Type');
		$('.btnSubmit').html('Add Type');
	});
	
	//while edit particular row
	$(document).on('click','.ajax-link',function(e){
        e.preventDefault();
		var url = $(this).attr('href');
		call({url:url,params:{},type:'GET'},function(resp){
			//alert('Successfully Data Added');
			$('#id').val(resp.id);
			$('#typeName').val(resp.name);
			$('.popup-label').html('Update Inquiry Type');
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
			//alert('Successfully Data Added');
			if(resp.success == 1){
				$.fn.yiiGridView.update('inquiry-type-grid');
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
		var url = '<?php echo Yii::app()->createUrl('inquiryType/createOrUpdate'); ?>';
		call({url:url,params:{name:typeName,id:id},type:'POST'},function(resp){
			//while insert data
			if(resp.status == 1){
				alert('Successfully Data Added');
				$('#typeName').val('');
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$.fn.yiiGridView.update('inquiry-type-grid');
				$('#frmInquiryType')[0].reset();
				$('#id').val(0);
				$('.form-error').html('');
				$('.popup-label').html('Add New Inquiry Type');
				$('.btnSubmit').html('Add Type');
			}
			//while update data
			if(resp.status == 2){
				alert('Successfully Data Updated');
				$('#typeName').val('');
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$.fn.yiiGridView.update('inquiry-type-grid');
				$('#frmInquiryType')[0].reset();
				$('#id').val(0);
				$('.form-error').html('');
				$('.popup-label').html('Add New Inquiry Type');
				$('.btnSubmit').html('Add Type');
			}
		});
		}else{
			$('.form-error').html("Field can't be empty");
			$('.div_error').css({'width':'100%', "text-align": "left"});
			$('.form-error').css({"color": "red"});
		}
}
</script>