<div id="main" class="single-customer">
<?php
/* @var $this CustomerController */
/* @var $model Customer */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#customer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Add Customer <a href="<?php echo Yii::app()->createUrl("customer/create"); ?>"><i class="fa fa-plus"></i></a></h3>
<div class="modal-box hide">
  <div class="content">
    <div class="box-header">
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label">Add New Business Type</h2>
    </div>
    <div class="box-content">
    	<form name="frmConstructionType" id="frmConstructionType" method="post" class="text-center" action="">
      		<input type="hidden" name="id" id="id" value="0" />
            <input type="text" name="typeName" id="typeName" class="typeName form-input" placeholder="Construction Type Name" value="" required/>
            <div class="divResponse"><span class="form-reponse"></span></div>
            <button type="button" class="btn-default btnSubmit">Add Type</button>
            
      	</form>
    </div>
  </div>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'customer-grid',
	'htmlOptions' => array('class' => 'tbl'),
	'dataProvider'=>$model->search(),
	'columns'=>array(
		array(
			'header'=>'Company',
			'name'=>'company_name',
			'filter'=>false,
			),
		//array(
			//'name'=>'company_name_kana',
			//'filter'=>false,
		//),
		array(
			'header'=>'President',
			'name'=>'president_name',
			'filter'=>false,
		),
		array(
			'header'=>'Postal',
			'name'=>'postal_code',
			'filter'=>false,
		),
		array(
			'name'=>'address',
			'filter'=>false,
		),
		array(
			'header'=>'Phone',
			'name'=>'phone_no',
			'filter'=>false,
		),
		array(
			'header'=>'URL',
			'name'=>'url',
			'filter'=>false,
		),
		array(
			'header'=>'Person Incharge',
			'name'=>'person_incharge_name',
			'filter'=>false,
		),
		array(
			'header'=>'Person Phone',
			'name'=>'person_phone_no',
			'filter'=>false,
		),
		array(
			'name'=>'email',
			'filter'=>false,
		),
		array(
			'name'=>'sales_staff_id',
			'filter'=>false,
			'value'=>function($data,$row){
				$customerDetails = Customer::model()->findByPk($data->customer_id);
				$userDetails = AdminDetails::model()->findByAttributes(array('user_id'=>$customerDetails->sales_staff_id));
				if(isset($userDetails->full_name) && $userDetails->full_name != ""){
					$fullName = $userDetails->full_name;
				}else{
					$fullName = '';
				}
				echo '<span>'.$fullName.'</span>';
			},
			'type'=>'raw',
		),
		/*
		'phone_no',
		'fax_no',
		'url',
		'business_type_id',
		'number_of_emp',
		'customer_source_id',
		'introducer_id',
		'inquiry_id',
		'note',
		'person_incharge_name',
		'person_incharge_name_kana',
		'position',
		'branch_name',
		'person_phone_no',
		'person_fax_no',
		'cellphone_no',
		'email',
		'department',
		'sales_staff_id',
		'added_by',
		'added_on',
		'modified_by',
		'modified_on',
		*/
		array(
			'header'=>'Action',					
			'class'=>'CButtonColumn',
			'template' => '{view}{update}{delete}',
			'buttons' => array(
				'update'=>array(
						'label'=>'<i class="fa fa-pencil"></i>',
						'options'=>array('title'=>'Update','style'=>'margin-right:15%;'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("customer/update", array("id"=>$data->customer_id))',
						'imageUrl'=>false,
						'options' => array('class'=>'UserUpdate ajax-link'),
						/*'click'=>"function($data){
							updateType($data->construction_type_id);
						  }
						",*/
				),
				'view'=>array(
						'label'=>'<i class="fa fa-eye"></i>',
						'options'=>array('title'=>'Update','style'=>'margin-right:15%;'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("customer/fullDetail", array("id"=>$data->customer_id))',
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
						'url'=>'Yii::app()->createUrl("customer/delete", array("id"=>$data->customer_id))',
						'imageUrl'=>false,
				),
			),
		),
	),
)); ?>
</div>