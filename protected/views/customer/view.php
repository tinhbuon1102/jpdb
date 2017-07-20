<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->breadcrumbs=array(
	'Customers'=>array('index'),
	$model->customer_id,
);

$this->menu=array(
	array('label'=>'List Customer', 'url'=>array('index')),
	array('label'=>'Create Customer', 'url'=>array('create')),
	array('label'=>'Update Customer', 'url'=>array('update', 'id'=>$model->customer_id)),
	array('label'=>'Delete Customer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->customer_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Customer', 'url'=>array('admin')),
);
?>

<h1>View Customer #<?php echo $model->customer_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'customer_id',
		'company_name',
		'company_name_kana',
		'president_name',
		'postal_code',
		'address',
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
	),
)); ?>
