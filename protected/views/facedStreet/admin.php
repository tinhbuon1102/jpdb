<div id="main" class="single-customer">
<hr/>
<ul class="breadcrumb">
	<li><a href="<?php echo Yii::app()->createUrl('site/settings'); ?>">Setting</a></li>
    <li class="bActive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Faced Street List</li>
</ul>
<hr/>
<?php
/* @var $this IntroducerController */
/* @var $model Introducer */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#introducer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3> Faced Street List <i class="fa fa-plus btnAddNew" title="Add New Type"></i></h3>
<!--Modal Popup for Add New Type-->
<div class="modal-box hide">
  <div class="content">
    <div class="box-header">
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Add New Faced Street'); ?></h2>
    </div>
    <div class="box-content">
    	<form name="frmFacedStreet" id="frmFacedStreet" method="post" class="text-center" action="">
      		<input type="hidden" name="id" id="id" value="0" />
            <input type="text" name="label" id="label" class="introducersName form-input" placeholder="Add Faced Street Name" value="" required/><div class="div_error"><span class="form-error"></span></div>
                <?php
					$options=CHtml::listData(FacedStreet::model()->findAll('is_parent=1'),'faced_street_id','label');
					
			     ?>
                 <div class="parentList">
                    <select class="text-center" id="parentId" name="parent">
                          <option value="0">--Please select main area--</option>
                        <?php
                        	if(count($options)>0){
								foreach($options as $k=>$option){
									echo'<option value="'.$k.'">'.$option.'</option>';
								}
							}
						?>              
                    </select>
            <?php  ?>
            	</div>
            <button type="button" class="btn-default btnSubmit" style="margin-top: 16px;">Add</button>
            
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
	'id'=>'face-street-grid',
	'dataProvider'=>$model->search(),
	'htmlOptions' => array('class' => 'tbl'),
	'columns'=>array(
		//'introducer_id',
		array(
			'name'=>'label',
			'filter'=>true
		),
		array(
			'header'=>'Status',
			'name'=>'is_active',
			'filter'=>false,
			'value'=>function($data,$row){
				if($data->is_active==1){
					return '<a href="'.Yii::app()->createUrl('facedStreet/changestatus',array('id'=>$data->faced_street_id,'is_active'=>'0')).'" class="btn btn-danger btn-sm ajax-status"><i class="fa fa-check"></i></a>';
				}
				if($data->is_active==0){
					return '<a href="'.Yii::app()->createUrl('facedStreet/changestatus',array('id'=>$data->faced_street_id,'is_active'=>'1')).'" class="btn btn-success btn-sm ajax-status"><i class="fa fa-times"></i></a>';
				}
			},
			'type'=>'raw'
		),
		array(
			'name'=>'parent_id',
			'filter'=>false,
			'value'=>function($data,$row){
			 	$faceStreet=FacedStreet::model()->findByPk($data->parent_id);
				if(count($faceStreet)>0){
					return $faceStreet['label'];
				}else{
					return '-';
				}
			 },
			 'type'=>'raw'
		),
		array(
			'name'=>'add_on',
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
						'url'=>'Yii::app()->createUrl("facedStreet/getTypeData", array("id"=>$data->faced_street_id))',
						'imageUrl'=>false,
						'options' => array('class'=>'UserUpdate ajax-link'),
				),
				'delete'=>array(
						'label'=>'<i class="fa fa-trash-o"></i>',
						'options'=>array('title'=>'Delete'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("facedStreet/delete", array("id"=>$data->faced_street_id))',
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
		$('#frmFacedStreet')[0].reset();
		$('.id').val(0);
		$('.form-error').html('');
		$('.popup-label').html('Add New Introducer');
		$('.btnSubmit').html('Add');
	});	
	//while edit particular row
	$(document).on('click','.ajax-link',function(e){
        e.preventDefault();
		var url = $(this).attr('href');
		//alert(url);
		call({url:url,params:{},type:'GET'},function(resp){
			//alert('Successfully Data Added');
			
			$('#id').val(resp.id);
			$('#parentId').val(resp.parent_id);
			$('#label').val(resp.label);
			$('.popup-label').html('Update Faced Street');
			$('.btnSubmit').html('Update');
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
				$.fn.yiiGridView.update('face-street-grid');
			}else{
				alert('Something went wrong.');
			}
		});
    });
});

function addUpdateType(){
		var label = $('#label').val();
		if(label != ''){
			
		var id = $('#id').val();
		var parentId=$('#parentId').val();	
		var url = '<?php echo Yii::app()->createUrl('facedStreet/createOrUpdate'); ?>';
		call({url:url,params:{'label':label,'id':id,'parentId':parentId},type:'POST'},function(resp){
			//while insert data
			if(resp.status == 1){
				alert('Successfully Data Added');				
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$.fn.yiiGridView.update('face-street-grid');
				$('#frmFacedStreet')[0].reset();
				
			}
			//while update data
			if(resp.status == 2){
				alert('Successfully Data Updated');
				$('#introducersName').val('');
				$('.modal-box').removeClass('show');
				$('.modal-box').addClass('hide');
				$('.modal-box').fadeOut(1000);
				$.fn.yiiGridView.update('face-street-grid');
				$('#frmFacedStreet')[0].reset();
				changeList();
			}
		});
		}else{
			$('.form-error').html("Field can't be empty");
			$('.div_error').css({'width':'100%', "text-align": "left"});
			$('.form-error').css({"color": "red"});
		}
}
function changeList(){
	var url = '<?php echo Yii::app()->createUrl('facedStreet/updateList'); ?>';
	call({url:url,params:{},type:'POST',dataType:'HTML'},function(resp){
		$('.parentList').html(resp);
	});
}
</script>