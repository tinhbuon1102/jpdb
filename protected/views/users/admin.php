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

	$('#users-grid').yiiGridView('update', {

		data: $(this).serialize()

	});

	return false;

});

");

?>



<h3>Users List <i class="fa fa-plus btnAddNew"></i></h3>



<div class="modal-box hide">

  <div class="content">

    <div class="box-header">

     <button type="button" class="btnModalClose" id="btnModalClose">X</button>

      <h2 class="popup-label">Add New User</h2>

    </div>

    <div class="box-content">

    	<form name="frmUserData" id="frmUserData" method="post" class="text-center" action="">

      		<input type="hidden" name="id" id="id" value="0" />

            <div class="div2 divSpace">

            	 <input type="text" name="username" id="username" class="username form-input" placeholder="Username" value="" required/>

                 <input type="text" name="userFullname" id="userFullname" placeholder="Full name" class="userFullname form-input" required >

                <input type="password" name="userPassword" id="userPassword" placeholder="Password"  class="userPassword form-input" style="display:none;" required/>

                <input type="email" name="userEmail" placeholder="Email"  id="userEmail" class="userEmail form-input" required>
                
                <select name="company" id="company" class="company form-input">
                <option value="0">- <?php echo Yii::app()->controller->__trans('Select Company')?> -</option>
                <?php
                $companyList = Company::model()->findAlL();
                if(isset($companyList) && count($companyList) > 0){
                    foreach($companyList as $company){
                ?>
                <option value="<?php echo $company['company_id']; ?>"><?php echo $company['name']; ?></option>
                <?php
                    }
                }
                ?>
            </select>

            </div>

            <div class="div2 divSpace">

                <input type="text" name="contact_number" id="contact_number" placeholder="Contact No."  class="contact_number form-input" required>

                <select class="userRole form-input" name="userRole" id="userRole" required>

                    <option value="">-- Select Role --</option>

                    <option value="s">Super Admin</option>

                    <option value="a">Admin</option>

                </select>

                <textarea role="5" cols="5" placeholder="Address" name="address" id="address" class="address form-input"></textarea>

            </div>           

            <div class="divResponse"><span class="form-reponse"></span></div>

            <button type="submit" class="btn-default btnSubmit">Add User</button>

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

	'id'=>'users-grid',

	'htmlOptions' => array('class' => 'tbl'),

	'dataProvider'=>$model->search(),

	'columns'=>array(

		array(

			'name'=>'username',

			'filter'=>false,

		),

		array(

			'name'=>'user_role',

			'filter'=>false,

			'value'=>function($data,$row){

				if($data->user_role == 's'){

					return  '<span>Super Admin</span>';

				}

				if($data->user_role == 'a'){

					return  '<span>Admin</span>';

				}

			},

			'type'=>'raw',

		),

		array(

			'name'=>'added_on',

			'filter'=>false,

		),

		array(

			'name'=>'added_by',

			'filter'=>false,

			'value'=>'$data->addUserData($data->user_id)',

			'type'=>'raw',

		),

		array(

			'header'=>'Name',

			'name'=>'full_name',

			'filter'=>false,

			'value'=>'$data->getUserFullName($data->user_id)',

			'type'=>'raw',

		),

		array(

			'header'=>'Contact',

			'name'=>'contact_number',

			'filter'=>false,

			'value'=>'$data->getUserContact($data->user_id)',

			'type'=>'raw',

		),

		array(

			'header'=>'Status',

			'name'=>'is_active',

			'filter'=>false,

			'value'=>function($data,$row){

				if($data->is_active == 1){

					return  '<a href='.Yii::app()->createUrl("users/changeStatus",array('id'=>$data->user_id,'is_active'=>0)).'  class="status"><i class="fa fa-check"></i></a>';

				}

				if($data->is_active == 0){

					return  '<a href='.Yii::app()->createUrl("users/changeStatus",array('id'=>$data->user_id,'is_active'=>1)).' class="status"><i class="fa fa-times"></i></a>';

				}

			},

			'type'=>'raw',

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

					'url'=>'Yii::app()->createUrl("users/getUserData", array("id"=>$data->user_id))',

					'imageUrl'=>false,

					'options' => array('class'=>'UserUpdate ajax-link'),

				),

				'delete'=>array(

					'label'=>'<i class="fa fa-trash-o"></i>',

					'options'=>array('title'=>'Delete'),

					'icon'=>true,

					'url'=>'Yii::app()->createUrl("users/delete", array("id"=>$data->user_id))',

					'imageUrl'=>false,

				),

			),

		),

	),

)); ?>

</div>



<script>



$(document).on('click','.status',function(e){

    e.preventDefault();

	var url=$(this).attr('href');

	console.log(url);

	call({url:url,params:{},type:'GET'},function(resp){

		if(resp.status == 1){

			alert('Successfully updated')

			$.fn.yiiGridView.update('users-grid');

		}

		

		});

		});



$(document).ready(function(e) {

	//while submit modal-box

    $('.btnSubmit').click(function(e) {

		e.preventDefault();

        addUpdateUser();

    });

	$(document).keypress(function(e) {

		if(e.which == 13) {

			addUpdateUser();

		}

	});

	//while close modal-box

	$(document).on('click','.btnModalClose',function(e){

		$('#frmUserData')[0].reset();

		$('.form-error').html('');

		$('.popup-label').html('Add New User');

		$('.btnSubmit').html('Add User');

		$('.form-reponse').html('');

		$("#userPassword").css('display','none');

		$("#username").attr("readonly",false); 

		$('#id').val(0);

	});

	

	//while edit particular row

	$(document).on('click','.ajax-link',function(e){

		

        e.preventDefault();

		var url = $(this).attr('href');

		call({url:url,params:{},type:'GET'},function(resp){

			//alert('Successfully Data Added');

			console.log(resp);

			$('#id').val(resp.user_id);

			$('#username').val(resp.username);

			$('#userRole').val(resp.user_role);

			$('#userFullname').val(resp.full_name);

			

			$('#address').val(resp.address);

			$('#contact_number').val(resp.contact_number);

			$('#userEmail').val(resp.email);
			$('#company').val(resp.company);

			if($("#username").val() != ''){

				$("#username").attr("readonly",true); 

			}

			$('.popup-label').html('Update User');

			$('.btnSubmit').html('Update User');

			$('.modal-box').removeClass('hide');

			$('.modal-box').addClass('show');

			$('.modal-box').fadeIn(1000);

			$("#userPassword").css('display','none');

		});

    });

});



function addUpdateUser(){

	var formdata = $('#frmUserData').serialize();

	var username = $('#username').val();

	var result = $('#frmUserData').valid();

	

	if(result != false){

	var url = '<?php echo Yii::app()->createUrl('users/createOrUpdate'); ?>';

	call({url:url,params:{formdata:formdata},type:'POST'},function(resp){
		//while insert data
		console.log(resp);
		if(resp.status == 1){

			$('.form-reponse').html(resp.msg);

			$('.divResponse').css({'width':'100%', "text-align": "left"});

			$('.form-reponse').css({"color": "green"});			

			setTimeout(function(){

				$('#frmUserData')[0].reset();

				$('.form-reponse').html('');

				$('.modal-box').removeClass('show');

				$('.modal-box').addClass('hide');

				$('.modal-box').fadeOut();

				$("#userPassword").css('display','none');

				$("#username").attr("readonly",false); 

				$('#id').val(0);

			},3000);

			

			$.fn.yiiGridView.update('users-grid');

		}

		//while update data

		if(resp.status == 2){

			$('.form-reponse').html(resp.msg);

			$('.divResponse').css({'width':'100%', "text-align": "left"});

			$('.form-reponse').css({"color": "green"});

			setTimeout(function(){

				$('#frmUserData')[0].reset();

				$('.form-reponse').html('');

				$('.modal-box').removeClass('show');

				$('.modal-box').addClass('hide');

				$('.modal-box').fadeOut();

				$("#userPassword").css('display','none');

				$("#username").attr("readonly",false); 

				$('#id').val(0);

			},3000);

			$.fn.yiiGridView.update('users-grid');

		}

	});

	}else{

		

	}

}

</script>

