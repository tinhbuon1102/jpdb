<div id="main" class="single-customer">

<hr/>

<ul class="breadcrumb">

	<li><a href="<?php echo Yii::app()->createUrl('site/settings'); ?>">Setting</a></li>

    <li class="bActive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Floor Types List</li>

</ul>

<hr/>

<?php

/* @var $this FloorController */

/* @var $model Floor */



Yii::app()->clientScript->registerScript('search', "

$('.search-button').click(function(){

	$('.search-form').toggle();

	return false;

});

$('.search-form form').submit(function(){

	$('#floor-grid').yiiGridView('update', {

		data: $(this).serialize()

	});

	return false;

});

");

?>

<?php $this->widget('zii.widgets.grid.CGridView', array(

	'id'=>'floor-grid',

	'htmlOptions' => array('class' => 'tbl'),

	'dataProvider'=>$model->search(),

	'enableSorting' => true,
	'columns'=>array(

		'floor_id',
		'building_id',
		'vacancy_info',
		'move_in_date',
		'floorId',
		'show_frontend',
		array(
			'class'=>'CLinkColumn',
			'header'=>'View Floor',
			'labelExpression'=>'View',
			'urlExpression' => 'Yii::app()->createUrl("building/singleBuilding", array("id"=> $data->floor_id))',
		),

		/*

		'preceding_details',

		'preceding_check_datetime',

		'vacant_schedule',

		'floor_down',

		'floor_up',

		'roomname',

		'maisonette_type',

		'short_term_rent',

		'type_of_use',

		'area_ping',

		'area_m',

		'area_net',

		'calculation_method',

		'payment_by_installments',

		'payment_by_installments_note',

		'floor_partition',

		'rent_unit_price_opt',

		'rent_unit_price',

		'total_rent_price',

		'unit_condo_fee_opt',

		'unit_condo_fee',

		'total_condo_fee',

		'deposit_opt',

		'deposit_month',

		'deposit',

		'total_deposit',

		'key_money_opt',

		'key_money_month',

		'repayment_opt',

		'repayment_reason',

		'repayment_amt',

		'repayment_amt_opt',

		'renewal_fee_opt',

		'renewal_fee_reason',

		'renewal_fee_recent',

		'repayment_notes',

		'notice_of_cancellation',

		'contract_period_opt',

		'contract_period_duration',

		'air_conditioning_facility_type',

		'air_conditioning_details',

		'air_conditioning_time_used',

		'number_of_air_conditioning',

		'optical_cable',

		'oa_type',

		'oa_height',

		'floor_material',

		'ceiling_height',

		'electric_capacity',

		'separate_toilet_by_gender',

		'toilet_location',

		'washlet',

		'toilet_cleaning',

		'notes',

		'floor_source_id',

		'update_person_in_charge',

		'property_confirmation_person',

		'is_condominium_ownership',

		'ownership_type',

		'management_type',

		'owner_company_name',

		'company_tel',

		'person_in_charge1',

		'person_in_charge2',

		'charge',

		*/

		array(

		'header'=>'Action',					

		'class'=>'CButtonColumn',

		'template' => ' {update} {delete}',

			'buttons' => array(

			    'update'=>array(
						'label'=>'<i class="fa fa-pencil"></i>',
						'options'=>array('title'=>'Update','style'=>'margin-right:15%;'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("floor/update", array("id"=>$data->floor_id))',
						'imageUrl'=>false,
						'options' => array('class'=>'UserUpdate ajax-link'),
				),

				'delete'=>array(
						'label'=>'<i class="fa fa-trash-o"></i>',
						'options'=>array('title'=>'Delete'),
						'icon'=>true,
						'url'=>'Yii::app()->createUrl("floor/delete", array("id"=>$data->floor_id))',
						'imageUrl'=>false,
				),
			),
		),
	),
)); ?>
</div>