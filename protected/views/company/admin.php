<div id="main" class="single-customer">
<hr/>
<ul class="breadcrumb">
	<li><a href="<?php echo Yii::app()->createUrl('site/settings'); ?>">Setting</a></li>
    <li class="bActive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Users List</li>
</ul>
<hr/>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#company-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Company List <i class="fa fa-plus btnAddNew"></i></h3>

<div class="modal-box hide">
  <div class="content">
    <div class="box-header">
     <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label">Add New Company</h2>
    </div>

    <div class="box-content">
    	<form name="frmCompanyData" id="frmCompanyData" class="text-center" action="" method="post" enctype="multipart/form-data">
      		<input type="hidden" name="id" id="id" value="0" />
            <div class="divSpace">
            	<input type="text" name="name" id="name" class="name form-input" placeholder="Company Name" value="" required/>
                <input type="text" name="address" id="address" placeholder="Address" class="address form-input" required >
                <input type="text" name="phone" id="phone" placeholder="Phone"  class="phone form-input" required/>
                <input type="email" name="email" id="email" placeholder="Email" class="email form-input" required>
				<input type="file" name="image" id="image" placeholder="logo" class="logo form-input" />
				<img src="" style="height:100px;width:100px;display: none;" id="logo-preview">
				
            </div>

            <div class="divResponse"><span class="form-reponse"></span></div>
            <button type="submit" class="btn-default btnSubmit">Add User</button>
      	</form>
    </div>
  </div>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'company-grid',
	'htmlOptions' => array('class' => 'tbl'),
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'company_id',
		'name',
		'address',
		'phone',
		'email',
		// 'compay_logo',
		array('name'=>'company_logo',
			'type'=>'raw',
			'value'=>'($data->company_logo) ? CHtml::image(Yii::app()->baseUrl.$data->company_logo,"",array(\'width\'=>\'50\', \'height\'=>\'50\')) : ""', 
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
							'url'=>'Yii::app()->createUrl("company/getCompanyData", array("id"=>$data->company_id))',					
							'imageUrl'=>false,
							'options' => array('class'=>'CompanyUpdate ajax-link'),					
					),
					
					'delete'=>array(					
							'label'=>'<i class="fa fa-trash-o"></i>',					
							'options'=>array('title'=>'Delete'),					
							'icon'=>true,					
							'url'=>'Yii::app()->createUrl("company/delete", array("id"=>$data->company_id))',					
							'imageUrl'=>false,					
					),
			),
		),
	),
)); ?>
</div>

<script>
$(document).ready(function(e) {
    $('.btnSubmit').click(function(e) {
		e.preventDefault();
		addUpdateCompany();
    });

	$(document).keypress(function(e) {
		if(e.which == 13) {
			addUpdateCompany();
		}
	});	
	
	$(document).on('click','.ajax-link',function(e){
		console.log("aaaa");
	    e.preventDefault();
		var url = $(this).attr('href');
		call({url:url,params:{},type:'GET'},function(resp){
			//alert('Successfully Data Added');
			console.log(resp);
			$('#id').val(resp.company_id);
			$('#name').val(resp.name);
			$('#address').val(resp.address);
			$('#phone').val(resp.phone);
			$('#email').val(resp.email);
			$('#image').val(resp.image);
			if(resp.company_logo != ""){
				$("#logo-preview").attr('src',resp.company_logo);
				$("#logo-preview").css('display','block');
			}
			else{
				$("#logo-preview").css('display','none');
			}
			
			$('.popup-label').html('Update Company');
			$('.btnSubmit').html('Update Company');
			$('.modal-box').removeClass('hide');
			$('.modal-box').addClass('show');
			$('.modal-box').fadeIn(1000);
		});
	});
	
	$(document).on('click','.btnModalClose',function(e){
		$('#frmCompanyData')[0].reset();
		$('.form-error').html('');
		$('.popup-label').html('Add New Company');
		$('.btnSubmit').html('Add Company');
		$('.form-reponse').html('');
		$('#id').val(0);
	});
});

function addUpdateCompany(){
	console.log("addUpdateCompany");
	var img=$('#image').val();
	var formdata = $('#frmCompanyData').serialize();
	formdata = formdata + '&company_logo='+encodeURIComponent(img)
	var name = $('#name').val();
	var result = $('#frmCompanyData').valid();

	var fd = new FormData();
   var file_data = $('#image')[0].files; // for multiple files
   fd.append("company_logo", file_data[0]);
   var other_data = $('#frmCompanyData').serializeArray();
   $.each(other_data,function(key,input){
       fd.append(input.name,input.value);
   });

	console.log(file_data);

	if(result != false){
		var url = '<?php echo Yii::app()->createUrl('company/createOrUpdate'); ?>';
		// call({url:url,params:{formdata:fd},type:'POST',

	$.ajax({
    url: url,
    type: 'POST',
    data: fd,
    cache: false,
    dataType: 'json',
    processData: false, // Don't process the files
    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
    success: function(resp, textStatus, jqXHR){
			console.log(resp);
			//while insert data
			if(resp.status == 1){
				$('.form-reponse').html(resp.msg);
				$('.divResponse').css({'width':'100%', "text-align": "left"});
				$('.form-reponse').css({"color": "green"});			
				setTimeout(function(){
					$('#frmCompanyData')[0].reset();
					$('.form-reponse').html('');
					$('.modal-box').removeClass('show');
					$('.modal-box').addClass('hide');
					$('.modal-box').fadeOut();
					$('#id').val(0);
				},3000);			
	
				$.fn.yiiGridView.update('company-grid');
			}
	
			//while update data
	
			if(resp.status == 2){
				$('.form-reponse').html(resp.msg);
				$('.divResponse').css({'width':'100%', "text-align": "left"});
				$('.form-reponse').css({"color": "green"});
				setTimeout(function(){
					$('#frmCompanyData')[0].reset();
					$('.form-reponse').html('');
					$('.modal-box').removeClass('show');
					$('.modal-box').addClass('hide');
					$('.modal-box').fadeOut();
					$('#id').val(0);
				},3000);
	
				$.fn.yiiGridView.update('users-grid');
			}
		}
		});

	}else{		

	}
}
</script>
