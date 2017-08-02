<?php
/* @var $this BuildingController */
/* @var $model Building */
/* @var $form CActiveForm */
?>

<div class="wide form">
<?php 
$searchOptions = HelperFunctions::searchSearchOptions();
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('site/frontSearch'),
	'method'=>'get',
)); ?>

   <div class="list-item filter-front-properties">
   	<div class="main-info clearfix">
   		<div class="b-name"><h2 class="condition_title">物件絞り込み</h2></div>
   	</div>
   	<div class="room-data clearfix condition_results front_results">
   	<div class="header-bg">
     	<div class="filter-keywords">
      	<div class="searchform-param">
			<?php echo CHtml::label('Keywords', 'keyword', array('class' => 'searchform-label date-update Floor-title') ); ?>
      		<span class="searchform-input-wrapper select-numbers search-floor">
      			<?php echo CHtml::textField('keyword', @$_REQUEST['keyword'], array('id' => 'keyword', 'class' => 'form-control Typeahead-input', 'placeholder' => 'キーワードで検索')); ?>
      		</span>
      	</div>
      	</div>
      	<div class="filter-location">
      	<div class="searchform-param">
      		<label class="searchform-label date-update Floor-title">Location</label>
      		<span class="searchform-input-wrapper select-numbers search-floor">
      			<ul class="location_list">
      			<?php foreach ($searchOptions['location'] as $location_key => $location) {?>
      			<li>
      				<?php echo CHtml::checkBox('location['.$location_key.']', $_REQUEST['location'][$location_key] == $location, array('class' => 'checkbox-formtype chck_space', 'id' => 'location_' . $location_key, 'value' => $location) ); ?>
      				<label for="location_<?php echo $location_key?>"><?php echo $location?></label>
      			</li>
      			<?php }?>
      			</ul>
      		</span>
      	</div>
      	</div>
      	<!--show more options-->
       	<div class="row basic-filter" id="advanced_options" style="display: none;">
        	<div class="form_part col_1">
            	<div class="col_wrap">
                	<div class="col-right-one">
                    	<div class="divMinMax">
                        	<div class="area searchform-label"><?php echo Yii::app()->controller->__trans('Area'); ?></div>
                            <div class="float-left">
                            	<label><?php echo Yii::app()->controller->__trans('下限'); ?>(坪)</label>
                            	<?php echo CHtml::dropDownList('area_ping_min', $_REQUEST['area_ping_min'], $searchOptions['area'],   array('class' => 'select-one', 'id' => 'minVal') ); ?>
                            </div>
                            <div class="float-left maxside">
                            	<label><?php echo Yii::app()->controller->__trans('上限'); ?>(坪)</label>
                            	<?php echo CHtml::dropDownList('area_ping_max', $_REQUEST['area_ping_max'], $searchOptions['area'],   array('class' => 'select-one', 'id' => 'maxVal') ); ?>
                            </div>
                        </div>
                        <div id="slider-range" class="slider-one slider-range ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" step="50" min="<?php echo $_REQUEST['area_ping_min']?>" max="<?php echo $_REQUEST['area_ping_max']?>"><div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 0%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 0%;"></span><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 0%;"></span></div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update">フロア</label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                	<?php echo CHtml::dropDownList('floor_down', $_REQUEST['floor_down'], $searchOptions['floor'],   array('class' => 'floor-drop', 'id' => 'floorMin', 'data-role'=> 'none') ); ?>
                                	～
                                    <?php echo CHtml::dropDownList('floor_up', $_REQUEST['floor_up'], $searchOptions['floor'],   array('class' => 'floor-drop', 'id' => 'floorMax', 'data-role'=> 'none') ); ?>
                                    <span class="floor-text-min"> 階</span>
                               	</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_part col_2">
            	<div class="col_wrap">
                	<div class="col-right-one">
                    	<div class="divMinMax">
                        	<div class="unit searchform-label">
								単価                            </div>
                            <div class="float-left">
                            	<label>下限(万円)</label>
                            	<?php echo CHtml::dropDownList('rent_unit_min', $_REQUEST['rent_unit_min'], $searchOptions['rent_unit'],   array('class' => 'select-one', 'id' => 'minVal-1') ); ?>
                            </div>
                            <div class="float-left maxside">
                            	<label>上限(万円)</label>
                            	<?php echo CHtml::dropDownList('rent_unit_max', $_REQUEST['rent_unit_max'], $searchOptions['rent_unit'],   array('class' => 'select-one', 'id' => 'maxVal-1') ); ?>
                            </div>
                        </div>
                        <div id="slider-range" min="" max="" class="slider-one slider-range-1 ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 0%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 0%;"></span><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 0%;"></span></div>
                    </div>
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update">築年 </label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                <?php echo CHtml::dropDownList('built_year', $_REQUEST['built_year'], $searchOptions['built_year'],   array('class' => 'select-one', 'id' => 'buildingAge') ); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_part col_3">
            	<div class="col_wrap">
                	<div class="col-right-one no-pad-right">
                    	<div class="divMinMax costMinAmount">
                        	<div class="cost searchform-label">総額</div>
                            	<div class="float-left">
                                	<label>下限</label>
                                	<?php echo CHtml::dropDownList('total_rent_price_min', $_REQUEST['total_rent_price_min'], $searchOptions['total_rent'],   array('class' => 'select-one', 'id' => 'costMinAmount') ); ?>
                                    <span>円</span>
                                </div>
                                <div class="float-left between">~</div>
                                <div class="float-left maxside">
                                	<label>上限</label>
                                    <?php echo CHtml::dropDownList('total_rent_price_max', $_REQUEST['total_rent_price_max'], $searchOptions['total_rent'],   array('class' => 'select-one', 'id' => 'costMaxAmount') ); ?>
                                    <span>円</span>
                                </div>
                            </div>
                        <div id="slider-range" class="slider-one"></div>
                    </div>
                    
                    <div class="second_part">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label date-update passible-title">入居可能日</label>
                                <span class="searchform-input-wrapper select-numbers search-floor">
                                <?php echo CHtml::dropDownList('move_in_date_min', $_REQUEST['move_in_date_min'], $searchOptions['move_in_date'],   array('class' => 'select-one', 'id' => 'move_in_date_min') ); ?>
								～
								<?php echo CHtml::dropDownList('move_in_date_max', $_REQUEST['move_in_date_max'], $searchOptions['move_in_date'],   array('class' => 'select-one', 'id' => 'move_in_date_max') ); ?>
								</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
         </div>
         <!--/show more options-->
        </div>
   		
   		<div class="searchform-controls clearfix">
   			<div class="orderby_wraper">
   				<label>Order By</label>
   				<?php echo CHtml::dropDownList('order_by', $_REQUEST['order_by'], $searchOptions['orderby'],   array('class' => 'select-one', 'id' => 'order_by') ); ?>
   			</div>
   			<div class="bt-refine">
   			<?php echo CHtml::submitButton('Filter', array('id' => 'search_hidden_submit', 'name' => 'search')); ?>
   			</div>
   			<div class="refine-more">
   				<?php echo CHtml::htmlButton('Show more options', array('id' => 'button_show_option', 'style' => 'display: inline-block;')); ?>
   				<?php echo CHtml::htmlButton('Hide options', array('id' => 'button_hidden_option', 'style' => 'display: none;')); ?>
			</div>
   		</div>
   	</div>
   </div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->