<div id="main" class="single-customer">
<hr/>
<ul class="breadcrumb">
	<li><a href="<?php echo Yii::app()->createUrl('site/settings'); ?>">Setting</a></li>
    <li class="bActive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Form List</li>
</ul>
<hr/>
<?php
/* @var $this FormTypeController */
/* @var $model FormType */



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#form-type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h3>Form Type <i class="fa fa-plus btnAddNew"></i></h3>
<!--Modal Popup for Add New Type-->
<div class="modal-box hide">
  <div class="content">
    <div class="box-header">
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label">Add New Form Type</h2>
    </div>
    <div class="box-content">
    	<form name="frmFormType" id="frmFormType" method="post" class="text-center" action="">
      		<input type="hidden" name="id" id="id" value="0" />
            <input type="text" name="typeName" id="typeName" class="typeName form-input" placeholder="Add Form Type" value="" required/>
            <div class="div_error"><span class="form-error"></span></div>
            <button type="button" class="btn-default btnSubmit">Add Type</button>
      	</form>
    </div>
  </div>
</div>	

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'form-type-grid',
	'htmlOptions' => array('class' => 'tbl'),	
	'dataProvider'=>$model->search(),
	'columns'=>array(
		array(
			'name'=>'form_type_name',
			'filter'=>false,
		),
		array(
			'header'=>'Status',
			'name'=>'is_active',
			'filter'=>false,
			'value'=>function($data,$row){
				if($data->is_active == 1){
					return  '<a href="'.Yii::app()->createUrl('formType/changeStatus',array('id'=>$data->form_type_id,'is_active'=>0)).'" class="btn btn-danger btn-sm ajax-status"><i class="fa fa-check"></i></a>';
				}
				if($data->is_active == 0){
					return  '<a href="'.Yii::app()->createUrl('formType/changeStatus',array('id'=>$data->form_type_id,'is_active'=>1)).'" class="btn btn-success btn-sm ajax-status"><i class="fa fa-times"></i></a>';
				}
			},
			'type'=>'raw'
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
						'url'=>'Yii::app()->createUrl("formType/getTypeData", array("id"=>$data->form_type_id))',
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
						'url'=>'Yii::app()->createUrl("formType/delete", array("id"=>$data->form_type_id))',
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
		$('#frmFormType')[0].reset();
		$('#id').val(0);
		$('.form-error').html('');
		$('.popup-label').html('Add New Form Type');
		$('.btnSubmit').html('Add Form');
	});
	
	//while edit particular row
	$(document).on('click','.ajax-link',function(e){
        e.preventDefault();
		var url = $(this).attr('href');
		call({url:url,params:{},type:'GET'},function(resp){
			//alert('Successfully Data Added');
			$('#id').val(resp.id);
			$('#typeName').val(resp.name);
			$('.popup-label').html('Update Form Type');
			$('.btnSubmit').html('Update Form Type');
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
				$.fn.yiiGridView.update('form-type-grid');
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
		var url = '<?php echo Yii::app()->createUrl('formType/createOrUpdate'); ?>';
		call({url:url,params:{name:typeName,id:id},type:'POST'},function(resp){
			//while insert data
			if(resp.status == 1){
				alert('Successfully Data Added');
				$('#typeName').val('');
				$('#id').val(0);
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$('.popup-label').html('Add New Form Type');
				$('.btnSubmit').html('Add Form Type');
				$.fn.yiiGridView.update('form-type-grid');
			}
			//while update data
			if(resp.status == 2){
				alert('Successfully Data Updated');
				$('#typeName').val('');
				$('#id').val(0);
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$('.popup-label').html('Add New Form Type');
				$('.btnSubmit').html('Add Form Type');
				$.fn.yiiGridView.update('form-type-grid');
			}
		});
		}else{
			$('.form-error').html("Field can't be empty");
			$('.div_error').css({'width':'100%', "text-align": "left"});
			$('.form-error').css({"color": "red"});
		}
}
</script>
