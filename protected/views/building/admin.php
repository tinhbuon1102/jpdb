<div id="main" class="single-customer">
<?php
/* @var $this BuildingController */
/* @var $model Building */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

$('.search-form form').submit(function(){
	$('#building-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h3 class="common-title">
	<?php echo Yii::app()->controller->__trans('Building List'); ?>
    <a href="<?php echo Yii::app()->createUrl('building/create'); ?>">
    	<i class="fa fa-plus"></i>
    </a>
</h3>
<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array('model'=>$model,)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'building-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'rowHtmlOptionsExpression' => '[ "id" => "item".$data->building_id,"order-id"=>$data->sortOrder]',
	'htmlOptions' => array('class' => 'tbl'),
	'columns'=>array(
		'buildingId',
		array(
			'name'=>'name',
		),
		array(
			'name'=>'old_name',
		),
		//'name_kana',
		//'address',
		//'faced_street_id',
		//'construction_type_id',
		//'floor_scale',
		//'earth_quake_res_std',
		//'earth_quake_res_std_note',
		//'emr_power_gen',
		array(
			'name'=>'built_year',
		),
		//'renewal_data',
		//'std_floor_space',
		//'total_floor_space',
		//'name'=>'elevator',
		//'elevator_non_stop',
		//'elevator_hall',
		//'entrance_with_attention',
		//'ent_op_cl_time',
		//'ent_auto_lock',
		//'parking_unit_no',
		//'limit_of_usage_time',
		//'wholesale_lease',
		//'security_id',
		//'form_type_id',
		//'condominium_ownership',
		array(
			'header'=>'Action',
			'class'=>'CButtonColumn',
			'template' => '{view} {update} {delete}',
			'buttons' => array(
				'view'=>array(
					'label'=>'<i class="fa fa-building-o"></i>',
					'options'=>array('title'=>'Add','style'=>'margin-right:15%;'),
					'icon'=>true,
					'url'=>'Yii::app()->createUrl("floor/create", array("bid"=>$data->building_id))',
					'imageUrl'=>false,
					'options' => array('class'=>'UserUpdate ajax-link'),
				),
				'update'=>array(
					'label'=>'<i class="fa fa-pencil"></i>',
					'options'=>array('title'=>'Update','style'=>'margin-right:15%;'),
					'icon'=>true,
					'url'=>'Yii::app()->createUrl("building/update", array("id"=>$data->building_id))',
					'imageUrl'=>false,
					'options' => array('class'=>'UserUpdate ajax-link'),
				),
				'delete'=>array(
					'label'=>'<i class="fa fa-trash-o"></i>',
					'options'=>array('title'=>'Delete'),
					'icon'=>true,
					'url'=>'Yii::app()->createUrl("building/delete", array("id"=>$data->building_id))',
					'imageUrl'=>false,
				),
			),
		),
	),
));
?>
</div>

<?php
    $str_js = "
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
 
        $('#building-grid table.items tbody').sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update : function () {
                serial = $('#building-grid table.items tbody').sortable( 'toArray' );
				console.log(serial);
				
                $.ajax({
                    'url': '" . $this->createUrl('building/sort') . "',
                    'type': 'post',
                    'data': {data:serial},
                    'success': function(data){
                    },
                    'error': function(request, status, error){
                        alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    ";
 
    Yii::app()->clientScript->registerScript('sortable-project', $str_js);
?>