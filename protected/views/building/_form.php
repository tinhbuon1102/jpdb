<?php
/* @var $this BuildingController */
/* @var $model Building */
/* @var $form CActiveForm */
?>
<div class="form">
	<div id="table-box">
		<?php $form=$this->beginWidget('CActiveForm', array('id'=>'building-form','enableAjaxValidation'=>false,)); ?>
		<?php echo $form->errorSummary($model); ?>
        <div class="formbox f-full">
        	<div class="table-inner">
            	<table class="edit_input mline b-line">
                	<tbody>
                		<tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Building Featured'); ?>
                            </th>
                            <td>
                            	<input type="checkbox" name="Building[is_featured]" value="1" <?php echo isset($model->is_featured) && $model->is_featured == '1' ? 'checked' :''; ?> class="ip">
                            </td>
                       	</tr>
                    	<tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Building Name'); ?>
                            </th>
                            <td>
								<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>'ty9 mb1')); ?><br/>
                                <label>
                                	<!-- <input type="checkbox" name="Building[build_check]" value="1" class="ip" id="buildCheck" <?php echo ($model->bill_check != 0) ? 'checked' : ''; ?>> -->
									<?php //echo Yii::app()->controller->__trans('Unnecessary "building" at end of building name'); ?>
                                </label>
                                
								<?php echo $form->error($model,'name'); ?>
								<span class="errorName" style="color:red;"></span>
                            </td>
                       	</tr>
                       	
                       	<tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Building Name English'); ?>
                            </th>
                            <td>
								<?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>255,'class'=>'ty9 mb1')); ?><br/>
								<?php echo $form->error($model,'name'); ?>
                            </td>
                       	</tr>
                       	
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Building Old Name'); ?>
                            </th>
                            <td>
								<?php echo $form->textField($model,'old_name',array('size'=>60,'maxlength'=>255,'class'=>'ty9')); ?>
								<?php echo $form->error($model,'old_name'); ?>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Building Name Kana'); ?>
                            </th>
                            <td>
								<?php echo $form->textField($model,'name_kana',array('size'=>60,'maxlength'=>255,'class'=>'ty9 mb1')); ?>
								<?php echo $form->error($model,'name_kana'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="edit_input mline b-line">
                	<tbody>
                    	<tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Address'); ?>
                            </th>
                            <td>
								<?php echo $form->textField($model,'address',array('class'=>'ty9 Building_address')); ?>
                                <p class="note">
									<?php echo Yii::app()->controller->__trans('Please enter from Prefecture.Please enter street number like "○-○-○"'); ?>
                                </p>
								<?php echo $form->error($model,'address'); ?>
                                <span class="errorAddress" style="color:red;"></span>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Address English'); ?>
                            </th>
                            <td>
								<?php echo $form->textField($model,'address_en',array('class'=>'ty9 Building_address')); ?>
                                <p class="note">
									<?php echo Yii::app()->controller->__trans('Please enter from Prefecture.Please enter street number like "○-○-○"'); ?>
                                </p>
								<?php echo $form->error($model,'address_en'); ?>
                                <span class="errorAddress" style="color:red;"></span>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Description'); ?>(<?php echo Yii::app()->controller->__trans('Japanese'); ?>)
                            </th>
                            <td>
								<textarea name="Building[description_ja]" class="txta2"><?php echo $model->description_ja?></textarea>
                                <p class="note">
									<?php echo Yii::app()->controller->__trans('Please enter description for premium office website.'); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Description'); ?>(<?php echo Yii::app()->controller->__trans('English'); ?>)
                            </th>
                            <td>
								<textarea name="Building[description_en]" class="txta2"><?php echo $model->description_en?></textarea>
                                <p class="note">
									<?php echo Yii::app()->controller->__trans('Please enter description for premium office website.'); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Movie Provider'); ?>
                            </th>
                            <td>
								<select name="Building[video_type]" class="movie-type">
		                    		<option value="youtube" <?php echo $model->video_type == 'youtube' ? 'selected' : ''?>><?php echo Yii::app()->controller->__trans('Youtube'); ?></option>
		                    		<option value="vimeo" <?php echo $model->video_type == 'vimeo' ? 'selected' : ''?>><?php echo Yii::app()->controller->__trans('Vimeo'); ?></option>
                    			</select>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Movie ID'); ?>
                            </th>
                            <td>
								<input type="text" style="width: 100%" name="Building[video_id]" value="<?php echo $model->video_id?>" class="movie-id" placeholder="<?php echo Yii::app()->controller->__trans('input ID here'); ?>">
								<br />
                    			<i><?php echo Yii::app()->controller->__trans('Example : <br/> Youtube URL: https://www.youtube.com/watch?v=btlRMrlaCQk <br/> ID = btlRMrlaCQk'); ?></i>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Average rent of neighbor'); ?>
                            </th>
                            <td>
								<input type="text" name="Building[avg_neighbor_fee_min]" value="<?php echo $model->avg_neighbor_fee_min?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('円'); ?> &nbsp;~
                            <input type="text" name="Building[avg_neighbor_fee_max]" value="<?php echo $model->avg_neighbor_fee_max?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('円'); ?>
                                <p class="note">
									<?php echo Yii::app()->controller->__trans('Please enter neighbor avg fee for premium office website.'); ?>
                                </p>
                            </td>
                        </tr>
                        <?php /*?><tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Faced Street'); ?>
                            </th>
                            <td>
                            	<select name="Building[faced_street_id]" id="Building_faced_street_id" class="ty9">
                                	<option value="">-</option>
									<?php
                                    	foreach($facedStreetList as $parent){
											if($parent->is_parent == 1){
									?>
                                    <optgroup style="background-color:#333; color:#EEE;" label="<?php echo $parent->label; ?>">
									<?php
                                    	$childList = FacedStreet::model()->findAll(array("condition"=>"parent_id = $parent->faced_street_id"));
										if(count($childList) > 0){
											foreach($childList as $child){
												$selected ="";
												if($model->faced_street_id == $child->faced_street_id){
													$selected = 'selected';
												}
									?>
                                    <option style="background-color:#EEE; color:#333; padding-left:10px;" value="<?php echo $child->faced_street_id; ?>" <?php echo $selected; ?>><?php echo $child->label; ?></option>
									<?php
                                    		}
										}
									?>
                                    </optgroup>
									<?php
                                    		}
										}
									?>
                                </select>
								<?php echo $form->error($model,'faced_street_id'); ?>
                            </td>
                        </tr><?php */?>
                    </tbody>
                </table>
                <table class="edit_input b-line">
                	<tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Structure'); ?>
                        </th>
                        <td>
                        	<select name="Building[construction_type_id]" id="Building_construction_type_id" data-role="none">
                            	<option value="">-</option>
								<?php
                                	foreach($constructionTypeList as $typeList){
										$selected ="";
										if($model->construction_type_id == $typeList->construction_type_id){
											$selected = 'selected';
										}
								?>
                                <option value="<?php echo $typeList->construction_type_id; ?>" <?php echo $selected; ?>><?php echo $typeList->construction_type_name; ?></option>
								<?php
                                	}
								?>
                            </select>
							<?php echo $form->error($model,'construction_type_id'); ?>
                        </td>
                    </tr>
                    <script>
                    $('#Building_construction_type_id').change(function(){
                        var v=$('#Building_construction_type_id option:selected').text();
                        var ctn = $("#Building_construction_type_name"); 
                        if(v=='-') {
                    		ctn.attr("readonly",false);
                    		$('#construction_type_name_en_wraper').fadeIn();
                    		v = '';
                        } else {
                        	ctn.attr("readonly",true);
                        	$('#construction_type_name_en_wraper').fadeOut();
                        }                        
                        ctn.val(v);                        
                    });
                    </script>
					<tr>
                    	<th scope="row">							
						</th>
                       	<td>
							<?php echo $form->textField($model,'construction_type_name',array('size'=>60,'maxlength'=>255,'class'=>'ty9 construction_type_name', 'placeholder' => '特別な構造名（日本語）')); ?>
							<?php echo $form->error($model,'construction_type_name'); ?>
                        </td>
                    </tr>
                    <tr id="construction_type_name_en_wraper">
                    	<th scope="row">							
						</th>
                       	<td>
                       		<label>Construction Name Eng</label>
							<?php echo $form->textField($model,'construction_type_name_en',array('size'=>60,'maxlength'=>255,'class'=>'ty9 construction_type_name_en', 'placeholder' => '特別な構造名（英語）')); ?>
							<?php echo $form->error($model,'construction_type_name_en'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Floor Scale'); ?>
                        </th>
                        <td>
							<?php
                            	if(isset($model->floor_scale) && $model->floor_scale != ''){
									$floor_scale = $model->floor_scale;
									$extraxtFloorScale = explode('-',$floor_scale);
									$floor_scale_up = $extraxtFloorScale[0];
									$floor_scale_down = $extraxtFloorScale[1];
								}
					?>
							<?php echo Yii::app()->controller->__trans('地上'); ?> &nbsp;
                            <input type="text" name="Building[floor_scale_up]" id="Building_floor_scale_up" value="<?php echo isset($floor_scale_up) && $floor_scale_up != '' ? $floor_scale_up : ''; ?>" class="ty8">
                            &nbsp;<?php echo Yii::app()->controller->__trans('階'); ?>&nbsp;&nbsp;
							<?php echo Yii::app()->controller->__trans('地下'); ?>&nbsp;
                            <input type="text" name="Building[floor_scale_down]" id="Building_floor_scale_down" value="<?php echo isset($floor_scale_down) && $floor_scale_down != '' ? $floor_scale_down : ''; ?>" class="ty8">
                            &nbsp;<?php echo Yii::app()->controller->__trans('階'); ?> <?php echo $form->error($model,'floor_scale'); ?>
                       	</td>
                    </tr>
                    <tr>
                    	<th scope="row">見込み賃料</th>
						<?php
						    $expRent_exp1 = $expRent_exp = array();
                        	if(isset($model->exp_rent) && $model->exp_rent != ''){
								$expRent_exp = explode('-',$model->exp_rent);
								if(isset($expRent_exp) && !empty($expRent_exp)){
									$expRent_exp1 = explode('~',$expRent_exp[0]);
								}
								//print_r($expRent_exp1);die;
							}
						?>
                        <td>
                        	<input type="text" name="Building[exp_rent]" value="<?php echo isset($expRent_exp1[0]) && $expRent_exp1[0] != '' ? $expRent_exp1[0] :''; ?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('円'); ?> &nbsp;~
                            <input type="text" name="Building[exp_rent2]" value="<?php echo isset($expRent_exp1[1]) && $expRent_exp1[1] != '' ? $expRent_exp1[1] :''; ?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('円'); ?> &nbsp;(&nbsp;
                            <label>
								<?php $expRentCheck = 'checked'; ?>
                                <input type="radio" name="Building[exp_rent_opt]" value="1" <?php echo isset($expRent_exp[1]) && $expRent_exp[1] == '1' ? $expRentCheck :''; ?> checked="" class="ip">
								<?php echo Yii::app()->controller->__trans('共益費含む'); ?>
                           	</label>
                            <label>
                            	<input type="radio" name="Building[exp_rent_opt]" value="2" <?php echo isset($expRent_exp[1]) && $expRent_exp[1] == '2' ? $expRentCheck :''; ?> class="ip">
								<?php echo Yii::app()->controller->__trans('共益費含まない'); ?>
                            </label>&nbsp;)
                            <label>
                            	<input type="checkbox" name="Building[exp_rent_disabled]" value="1" <?php echo isset($model->exp_rent_disabled) && $model->exp_rent_disabled == '1' ? 'checked' :''; ?> class="ip">
								<?php echo Yii::app()->controller->__trans('資料に表示しない'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Earthquake resistance standards'); ?>
                        </th>
                        <td>
							<?php $quakeResistanceList = QuakeResistanceStandards::model()->findAll('is_active = 1'); ?>
                            <select name="Building[earth_quake_res_std]" id="Building_earth_quake_res_std">
                            	<option value="">-</option>
								<?php
                                foreach($quakeResistanceList as $quake){
									$selected ="";
									if($model->earth_quake_res_std == $quake->quake_resistance_standard_id){
										$selected = 'selected';
									}
								?>
                                <option value="<?php echo $quake->quake_resistance_standard_id; ?>" <?php echo $selected; ?>><?php echo $quake->quake_resistance_standard_name; ?></option>
								<?php
                                }
								?>
                            </select>
							<?php echo $form->error($model,'earth_quake_res_std');?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Earthquake resistance standards note'); ?>
                        </th>
                        <td>
							<?php echo $form->textField($model,'earth_quake_res_std_note',array('size'=>60,'maxlength'=>255)); ?>
							<?php echo $form->error($model,'earth_quake_res_std_note'); ?>
                        </td>
                    </tr>
                    <tr>
						<?php $checked ="checked"; ?>
                        <th scope="row">
							<?php echo Yii::app()->controller->__trans('Emergency power generators'); ?>
                        </th>
                        <td>
                        	<label>
                                <input type="radio" name="Building[emr_power_gen]" id="Building_emr_power_gen" value="0" checked="" class="ip" <?php echo isset($model->emr_power_gen) && $model->emr_power_gen == '0' ? $checked :''; ?>>
                                <font>
                                    <font>
                                        <?php echo Yii::app()->controller->__trans('unknown'); ?>
                                    </font>
                                </font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[emr_power_gen]" id="Building_emr_power_gen" value="2" <?php echo isset($model->emr_power_gen) && $model->emr_power_gen == '2' ? $checked :''; ?>>
                                <font>
                                	<font>
										<?php echo Yii::app()->controller->__trans('Correspondence'); ?>
                                    </font>
                                </font>
                           	</label>
                            <label class="rd4">
                            	<input type="radio" name="Building[emr_power_gen]" id="Building_emr_power_gen" value="1" <?php echo isset($model->emr_power_gen) && $model->emr_power_gen == '1' ? $checked :''; ?>>
                                <font>
                                	<font>
										<?php echo Yii::app()->controller->__trans('incompatible'); ?>
                                    </font>
                                </font>
                            </label>
							<?php echo $form->error($model,'emr_power_gen'); ?>
                        </td>
                    </tr>
                    <tr>
						<?php
                        $built_month = $built_year = '';
						if(isset($model->built_year) && $model->built_year!= ''){
							$builtDate = $model->built_year;
							$built_month_ex = explode('-',$builtDate);
							$built_month = $built_month_ex[0];
							$built_year = $built_month_ex[1];
						}
						?>
                        <th scope="row">
							<?php echo Yii::app()->controller->__trans('Year Built-Month'); ?>
                        </th>
                        <td>
                        	<input type="text" name="Building[build_year]" id="Building_built_year" value="<?php echo $built_month; ?>" class="ty8">&nbsp;<?php echo Yii::app()->controller->__trans('年'); ?>&nbsp;
                            <input type="text" name="Building[build_month]" id="Building_built_month" value="<?php echo $built_year; ?>" class="ty8">&nbsp;<?php echo Yii::app()->controller->__trans('月'); ?>
							<?php echo $form->error($model,'built_year'); ?>
                            <span class="errorYear" style="color:red;"></span>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Renewal Data'); ?>
                        </th>
                        <td>
							<?php echo $form->textField($model,'renewal_data',array('class'=>'ty9')); ?> <?php echo $form->error($model,'renewal_data'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Renewal Data English'); ?>
                        </th>
                        <td>
							<?php echo $form->textField($model,'renewal_data_en',array('class'=>'ty9')); ?> <?php echo $form->error($model,'renewal_data_en'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Standard Floor Space'); ?>
                        </th>
                        <td>
							<?php echo $form->textField($model,'std_floor_space',array('size'=>30,'maxlength'=>30,'class'=>'ty5')); ?>
                            <font>
                            	<font>
                                	&nbsp;<?php echo Yii::app()->controller->__trans('坪'); ?>
                                </font>
                            </font>
							<?php echo $form->error($model,'std_floor_space'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Total Floor Space'); ?>
                        </th>
                        <td>
							<?php echo $form->textField($model,'total_floor_space',array('size'=>20,'maxlength'=>20,'class'=>'ty5')); ?>&nbsp;m<sup>2</sup>
							<?php echo $form->error($model,'total_floor_space'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('total rent space unit'); ?>
                        </th>
                        <td>
							<?php echo $form->textField($model,'total_rent_space_unit',array('size'=>20,'maxlength'=>20,'class'=>'ty5')); ?>
							<?php echo $form->error($model,'total_rent_space_unit'); ?>&nbsp;m<sup>2</sup>
                        </td>
                    </tr>
                  	<tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Shared rate'); ?>
                        </th>
                        <td>
                        	<input type="text" name="Building[shared_rate]" value="<?php echo isset($model->shared_rate) && $model->shared_rate != '' ? $model->shared_rate :''; ?>" class="ty5">&nbsp;%
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Building with deadline'); ?>
                        </th>
                        <td>
                        <?php if(isset($model->building_with_deadline) && !empty($model->building_with_deadline)){
								$expBuildingDeadLine = explode('-',$model->building_with_deadline); 
								$chk = 'checked';
							}
						 ?>
                        <input type="checkbox" name="Building[building_with_deadline]" value="1" <?php echo isset($expBuildingDeadLine[0]) && $expBuildingDeadLine[0] == 1 ? $chk:''; ?> class="ip building_with_deadline">
                        <?php echo Yii::app()->controller->__trans('Time-limited property'); ?>&nbsp;&nbsp;
                        <?php
							$curr_month = date("m");
							$month = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
							$month = array_slice($month, $curr_month-1);
							$monthAll = array (1=>"January", "February", "March", "April", "May", "June", "July",   "August", "September", "October", "November", "December");
							$currYear = date("Y");
							$fullyear = date("Y");
							$setLoopForYear = $currYear+10;
							$select = "<select name=\"Building[building_with_deadline_date]\" class=\"deadline_date\" disabled>\n <option value='0'>-</option>";
							for($i=$currYear; $i <= $setLoopForYear; $i++){
								if($i == $currYear){
									$month = $month;
								}else{
									$month = $monthAll;
								}
								foreach($month as $key => $val){
									$convertedMonth = date('m',strtotime($val));
									$select .= "\t<optgroup val=\"".$key."\" label=\"".$fullyear."年".$convertedMonth."月\">";
									if($key == 0 && $currYear == $fullyear){
										$months = date('m',strtotime($val));
										$number = cal_days_in_month(CAL_GREGORIAN, $months, $fullyear);
										for($j=1;$j<=$number;$j++){
											if($expBuildingDeadLine[1] == $fullyear."/".$months."/".$j){
												$selected ='selected';
											}else{
												$selected ='';
											}
											$select .= "\t<option val=\"".$fullyear."/".$months."/".$j."\"".$selected.">".$fullyear."/".$months."/".$j."</option>\n";
										}
										$select .= "</optgroup>\n";
									}else{
										$months = date('m',strtotime($val));
										$number = cal_days_in_month(CAL_GREGORIAN, $months, $fullyear);
										if($expBuildingDeadLine[1] ==$fullyear."/".$months."/月内"){
											$select_1 = 'selected';
										}
										for($j=1;$j<=$number;$j++){
											if($expBuildingDeadLine[1] == $fullyear."/".$months."/".$j){
												$selected ='selected';
											}else{
												$selected ='';
											}
											$select .= "\t<option val=\"".$fullyear."/".$months."/".$j."\"".$selected.">".$fullyear."/".$months."/".$j."</option>\n";
										}
										$select .= "</optgroup>\n";
									}
								}
								$fullyear++;
							}
							$select .= "</select>";
							echo $select;
						?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Elevator'); ?>
                        </th>
                        <td>
							<?php
                            $elevator_exp = array();
                            if(isset($model->elevator) && $model->elevator != ''){
                                $elevator_exp = explode('-',$model->elevator);
                            }
                            ?>
                            <?php $checked ="checked"; ?>
                            <label>
                                <input type="radio" name="Building[elevator]" class="ele_unkonwn" value="-2" checked <?php echo isset($elevator_exp[0]) && $elevator_exp[0] == '-2' ? $checked :''; ?>>
                                <?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label>
                            <label class="rd4">
                                <input type="radio" name="Building[elevator]" value="1" <?php echo isset($elevator_exp[0]) && $elevator_exp[0] == '1' ? $checked :''; ?> class="elevator_radio">
                                <?php echo Yii::app()->controller->__trans('Exist'); ?>
                            </label>（
                            <select name="Building[b_ev_group]" id="b_ev_num" class="elevator_group">
                                <option value=""><font><font>-</font></font></option>
                                <option value=""><?php echo Yii::app()->controller->__trans('unknown'); ?></option>
                                <?php
                                for($i=1;$i<=100;$i++){
                                    $selected ="";
                                    if(isset($elevator_exp[1]) && $elevator_exp[1] != ''){
                                        if($i == $elevator_exp[1]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $i; ?>" <?php  echo $selected; ?>><?php echo $i; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <font><?php echo Yii::app()->controller->__trans('基) 内'); ?>,</font>
                            <select name="Building[b_ev_group2]" id="b_ev_num" class="elevator_group">
                                <option value=""><font><font>-</font></font></option>
                                <option value=""><?php echo Yii::app()->controller->__trans('unknown'); ?></option>
                                <?php
                                for($i=1;$i<=100;$i++){
                                    $selected ="";
                                    if(isset($elevator_exp[2]) && $elevator_exp[2] != ''){
                                        if($i == $elevator_exp[2]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $i; ?>"<?php echo $selected; ?>><?php echo $i; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <font><?php echo Yii::app()->controller->__trans('人乗り'); ?>,</font>
                            <select  name="Building[b_ev_group3]" id="b_ev_num" class="elevator_group">
                                <option value=""><font><font>-</font></font></option>
                                <option value=""><?php echo Yii::app()->controller->__trans('unknown'); ?></option>
                                <?php
                                for($i=1;$i<=100;$i++){
                                    $selected ="";
                                    if(isset($elevator_exp[3]) && $elevator_exp[3] != ''){
                                        if($i == $elevator_exp[3]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $i; ?>"<?php echo $selected; ?>><?php echo $i; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <font><?php echo Yii::app()->controller->__trans('基 +人荷用'); ?></font>
                            <select name="Building[b_ev_group4]" id="b_ev_num" class="elevator_group">
                                <option value=""><font><font>-</font></font></option>
                                <option value=""><?php echo Yii::app()->controller->__trans('unknown'); ?></option>
                                <?php
                                for($i=1;$i<=100;$i++){
                                    $selected ="";
                                    if(isset($elevator_exp[4]) && $elevator_exp[4] != ''){
                                        if($i == $elevator_exp[4]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $i; ?>"<?php echo $selected; ?>><?php echo $i; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <font><?php echo Yii::app()->controller->__trans('人乗り'); ?></font>
                            <select name="Building[b_ev_group5]" id="b_ev_num" class='elevator_group'>
                                <option value=""><font><font>-</font></font></option>
                                <option value=""><?php echo Yii::app()->controller->__trans('unknown'); ?></option>
                                <?php
                                for($i=1;$i<=100;$i++){
                                    $selected ="";
                                    if(isset($elevator_exp[5]) && $elevator_exp[5] != ''){
                                        if($i == $elevator_exp[5]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $i; ?>"<?php echo $selected; ?>><?php echo $i; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <font><?php echo Yii::app()->controller->__trans('基 '); ?></font>
                            <label class="rd4">
                                <input type="radio" name="Building[elevator]" class="ele_noexist" value="2"  <?php echo isset($elevator_exp[0]) && $elevator_exp[0] == '2' ? $checked :''; ?>>
                                <font><font><?php echo Yii::app()->controller->__trans('noexist'); ?> </font></font>
                            </label>
                            <?php echo $form->error($model,'elevator'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Elevator Non-stop'); ?>
                        </th>
                        <td>
                        	<label>
                            	<input type="radio" name="Building[elevator_non_stop]" value="0" checked <?php echo isset($model->elevator_non_stop) && $model->elevator_non_stop == '0' ? $checked :''; ?> class="ip">
                                <font><font><?php echo Yii::app()->controller->__trans('unknown'); ?> </font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[elevator_non_stop]" <?php echo isset($model->elevator_non_stop) && $model->elevator_non_stop == '2' ? $checked :''; ?> value="2">
                                <?php echo Yii::app()->controller->__trans('exist'); ?>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[elevator_non_stop]" <?php echo isset($model->elevator_non_stop) && $model->elevator_non_stop == '1' ? $checked :''; ?> value="1">
                                <font><font><?php echo Yii::app()->controller->__trans('noexist'); ?> </font></font>
                            </label>
                            <?php echo $form->error($model,'elevator_non_stop'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Elevator Hall'); ?>
                        </th>
                        <td>
                        	<label>
                            	<input type="radio" name="Building[elevator_hall]" checked value="0" <?php echo isset($model->elevator_hall) && $model->elevator_hall == '0' ? $checked :''; ?> class="ip">
                                <font><font> <?php echo Yii::app()->controller->__trans('unknown'); ?></font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[elevator_hall]" value="2" <?php echo isset($model->elevator_hall) && $model->elevator_hall == '2' ? $checked :''; ?>>
                                <font><font><?php echo Yii::app()->controller->__trans('exist'); ?> </font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[elevator_hall]" value="1" <?php echo isset($model->elevator_hall) && $model->elevator_hall == '1' ? $checked :''; ?>>
                                <font><font><?php echo Yii::app()->controller->__trans('noexist'); ?>  </font></font>
                            </label>
                            <?php echo $form->error($model,'elevator_hall'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row"><?php echo Yii::app()->controller->__trans('Entrance with attention'); ?></th>
                        <td>
                        	<label>
                            	<input type="radio" name="Building[entrance_with_attention]" checked value="0" <?php echo isset($model->entrance_with_attention) && $model->entrance_with_attention == '0' ? $checked :''; ?>  class="ip">
                                <font><font> <?php echo Yii::app()->controller->__trans('unknown'); ?></font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[entrance_with_attention]" value="2" <?php echo isset($model->entrance_with_attention) && $model->entrance_with_attention == '2' ? $checked :''; ?>>
                                <font><font><?php echo Yii::app()->controller->__trans('exist'); ?> </font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[entrance_with_attention]" value="1" <?php echo isset($model->entrance_with_attention) && $model->entrance_with_attention == '1' ? $checked :''; ?>>
                                <font><font><?php echo Yii::app()->controller->__trans('noexist'); ?> </font></font>
                            </label>
                            <?php echo $form->error($model,'entrance_with_attention'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Entrance OPEN/CLOSE TIME'); ?>
                        </th>
                        <td>
							<?php
                            if(isset($model->ent_op_cl_time) && $model->ent_op_cl_time != ''){
                                $entOpclTime = $model->ent_op_cl_time;
                                $entOpclTime_exp = explode(',',$entOpclTime);
                                $weekTime = array();
                                $satTime = array();
                                $sunTime = array();
                                $week = explode('-',$entOpclTime_exp[0]);
                                if($week[0] == 2){
                                    if(count($week) > 0){
                                        $weekTime= explode('~',$week[1]);
                                    }
                                }
                                $sat = explode('-',$entOpclTime_exp[1]);
                                if($sat[0] == 2){
                                    if(count($sat) > 0){
                                        $satTime= explode('~',$sat[1]);
                                    }
                                }
                                $sun = explode('-',$entOpclTime_exp[2]);
                                if($sun[0] == 2){
                                    if(count($sun) > 0){
                                        $sunTime= explode('~',$sun[1]);
                                    }
                                }
                            }
                            ?>
                            <span><?php echo Yii::app()->controller->__trans('weekday'); ?></span>
                            <?php $select_ent_week = 'checked'; ?>
                            <label>
                                <input type="radio" name="Building[ent_week_opt]" value="1" <?php echo isset($week[0]) && $week[0] == 1 ?$select_ent_week:''; ?> class="ip ent1"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                                <input type="radio" name="Building[ent_week_opt]" value="2" <?php echo isset($week[0]) && $week[0] == 2 ?$select_ent_week:''; ?> class="ip ent2"><?php echo Yii::app()->controller->__trans('exist'); ?>
                            </label>
                            <select id="b_entrance_open_time_week_start" class="b_entrance" name="Building[ent_op_week_start]">
                                <option value=""><font><font>-</font></font></option>
                                <?php
                                $h = 0;
                                $m = 0;
                                while($h < 24){	
                                    $selected ="";
                                    if(isset($weekTime[0]) && $weekTime[0] != ''){
                                        if($h.':'.sprintf("%02d", $m) == $weekTime[0]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
                                    $m += 5;
                                    if($m == 60){
                                        $m = 00;
                                        $h++;
                                    }
                                }
                                ?>
                            </select>～
                            <select id="b_entrance_open_time_week_finish" class="b_entrance" name="Building[ent_op_week_finish]">
                                <option value=""><font><font>-</font></font></option>
                                <?php
                                $h = 0;
                                $m = 0;
                                while($h < 24){	
                                    $selected ="";
                                    if(isset($weekTime[1]) && $weekTime[1] != ''){
                                        if($h.':'.sprintf("%02d", $m) == $weekTime[1]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected;  ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
                                    $m += 5;
                                    if($m == 60){
                                        $m = 00;
                                        $h++;
                                    }
                                }
                                ?>
                            </select>
                            <label>
                                <input type="radio" name="Building[ent_week_opt]" value="3" <?php echo isset($week[0]) && $week[0] == 3 ?$select_ent_week:''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                            <span class=""><?php echo Yii::app()->controller->__trans('Saturday'); ?> </span>
                            <label>
                                <input type="radio" name="Building[ent_sat_opt]" value="1" <?php echo isset($sat[0]) && $sat[0] == 1 ?$select_ent_week:''; ?> class="ip ent3"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                                <input type="radio" name="Building[ent_sat_opt]" value="2" <?php echo isset($sat[0]) && $sat[0] == 2 ?$select_ent_week:''; ?> class="ip ent4"><?php echo Yii::app()->controller->__trans('exist'); ?>  
                            </label>
                            <select id="b_entrance_open_time_sat_start" class="b_entrance" name="Building[ent_op_sat_start]">
                                <option value=""><font><font>-</font></font></option>
                                <?php
                                $h = 0;
                                $m = 0;
                                while($h < 24){	
                                    $selected ="";
                                    if(isset($satTime[0]) && $satTime[0] != ''){
                                        if( $h.':'.sprintf("%02d", $m) == $satTime[0]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
                                    $m += 5;
                                    if($m == 60){
                                        $m = 00;
                                        $h++;
                                    }
                                }
                                ?>
                            </select>
                            ～
                            <select id="b_entrance_open_time_sat_finish" class="b_entrance" name="Building[ent_op_sat_finish]">
                                <option value=""><font><font>-</font></font></option>
                                <?php
                                $h = 0;
                                $m = 0;
                                while($h < 24){	
                                    $selected ="";
                                    if(isset($satTime[1]) && $satTime[1] != ''){
                                        if( $h.':'.sprintf("%02d", $m)== $satTime[1]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
                                    $m += 5;
                                    if($m == 60){
                                        $m = 0;
                                        $h++;
                                    }
                                }
                                ?>
                            </select>
                            <label>
                                <input type="radio" name="Building[ent_sat_opt]" value="3" <?php echo isset($sat[0]) && $sat[0] == 3 ?$select_ent_week:''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                            <span class=""><?php echo Yii::app()->controller->__trans('Sunday・Holiday'); ?> </span>
                            <label>
                                <input type="radio" name="Building[ent_sun_opt]" value="1" <?php echo isset($sun[0]) && $sun[0] == 1 ?$select_ent_week:''; ?> class="ip ent5"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                                <input type="radio" name="Building[ent_sun_opt]" value="2" <?php echo isset($sun[0]) && $sun[0] == 2 ?$select_ent_week:''; ?> class="ip ent6"><?php echo Yii::app()->controller->__trans('exist'); ?> 
                            </label>
                            <select id="b_entrance_open_time_sun_start" class="b_entrance" name="Building[ent_op_sun_start]">
                                <option value=""><font><font>-</font></font></option>
                                <?php
                                $h = 0;
                                $m = 0;
                                while($h < 24){
                                    $selected ="";
                                    if(isset($sunTime[0]) && $sunTime[0] != ''){
                                        if( $h.':'.sprintf("%02d", $m) == $sunTime[0]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
                                    $m += 5;
                                    if($m == 60){
                                        $m = 0;
                                        $h++;
                                    }
                                }
                                ?>
                            </select>
                            ～
                            <select id="b_entrance_open_time_sun_finish" class="b_entrance" name="Building[ent_op_sun_finish]">
                                <option value=""><font><font>-</font></font></option>
                                <?php
                                $h = 0;
                                $m = 0;
                                while($h < 24){
                                    $selected ="";
                                    if(isset($sunTime[1]) && $sunTime[1] != ''){
                                        if( $h.':'.sprintf("%02d", $m)== $sunTime[1]){
                                            $selected = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>"<?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
                                    $m += 5;
                                    if($m == 60){
                                        $m = 0;
                                        $h++;
                                    }
                                }
                                ?>
                            </select>
                            <label>
                                <input type="radio" name="Building[ent_sun_opt]" value="3" <?php echo isset($entOpclTime_exp[2]) && $entOpclTime_exp[2] == 3 ?$select_ent_week:''; ?> class="ip"> <?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                            <?php echo $form->error($model,'ent_op_cl_time'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Entrance Auto Lock'); ?>
                        </th>
                        <td>
                        	<label>
                            	<input type="radio" name="Building[ent_auto_lock]" checked value="0" <?php echo isset($model->ent_auto_lock) && $model->ent_auto_lock == '0' ? $checked :''; ?> class="ip">
                                <font><font><?php echo Yii::app()->controller->__trans('unknown'); ?> </font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[ent_auto_lock]" value="2" <?php echo isset($model->ent_auto_lock) && $model->ent_auto_lock == '2' ? $checked :''; ?>>
                                <font><font><?php echo Yii::app()->controller->__trans('exist'); ?></font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[ent_auto_lock]" value="1" <?php echo isset($model->ent_auto_lock) && $model->ent_auto_lock == '1' ? $checked :''; ?>>
                                <font><font><?php echo Yii::app()->controller->__trans('noexist'); ?> </font></font>
                            </label>
                            <?php echo $form->error($model,'ent_auto_lock'); ?>
                        </td>
                    </tr>
                    <tr>
						<?php 
                        $buildingunitNo = $model->parking_unit_no;
                        $unitNo = explode('-',$buildingunitNo );
                        ?>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Parking Unit Number'); ?>
                        </th>
                        <td>
                        	<label>
                            	<input type="radio" name="Building[parking_unit_no]" value="1" id="parking_unit_no_radio"  class="parking_unit_radio" <?php echo isset($unitNo[0]) && $unitNo[0] == '1' ? $checked :''; ?>>
                                <?php echo Yii::app()->controller->__trans('exist'); ?>
                            </label>（
                            <input type="text" name="Building[b_parking_num]" id="parking_unit_no_text" value="<?php if(isset($unitNo[1]) && $unitNo[1] != ''){echo $unitNo[1];}else{echo '';} ?>" class="ty11">
                            <font><font> <?php echo Yii::app()->controller->__trans('台'); ?>) </font></font>
                            <label class="rd4">
                            	<input type="radio" name="Building[parking_unit_no]" value="2" <?php echo isset($unitNo[0]) && $unitNo[0] == '2' ? $checked :''; ?> class="parking_radio_2">
                                <font><font> <?php echo Yii::app()->controller->__trans('noexist'); ?></font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[parking_unit_no]" value="3" <?php echo isset($unitNo[0]) && $unitNo[0] == '3' ? $checked :''; ?> class="parking_radio_3">
                                <?php echo Yii::app()->controller->__trans('exist but unknown unit number'); ?>
                            </label>
                            <?php echo $form->error($model,'parking_unit_no'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<?php 
						if(isset($model->limit_of_usage_time) && $model->limit_of_usage_time != ''){
							$limitUsageTime = $model->limit_of_usage_time;
							$limitUsageTime_exp = explode(',',$limitUsageTime);
							$weekLimitTime = array();
							$satLimitTime = array();
							$sunLimitTime = array();
							$limitWeek = explode('-',$limitUsageTime_exp[0]);
							if($limitWeek[0] == 2){
								if(count($limitWeek) > 0){
									$weekLimitTime= explode('~',$limitWeek[1]);
								}
							}
							$limitSat = explode('-',$limitUsageTime_exp[1]);
							if($limitSat[0] == 2){
								if(count($limitSat) > 0){
									$satLimitTime= explode('~',$limitSat[1]);
								}
							}
							$limitSun = explode('-',$limitUsageTime_exp[2]);
							if($limitSun[0] == 2){
								if(count($limitSun) > 0){
									$sunLimitTime= explode('~',$limitSun[1]);
								}
							}
						}
						?>
                        <th scope="row">
							<?php echo Yii::app()->controller->__trans('limit of usage time'); ?>
                       	</th>
                        <td>
                        	<span><?php echo Yii::app()->controller->__trans('weekday'); ?></span>
                            <?php $limitCheck = 'checked'; ?>
                            <label>
                            	<input type="radio" name="Building[limit_time_week]" value="1" <?php echo isset($limitWeek[0]) && $limitWeek[0] == '1' ? $limitCheck :''; ?> class="ip limit1"> <?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                            	<input type="radio" name="Building[limit_time_week]" value="2" <?php echo isset($limitWeek[0]) && $limitWeek[0] == '2' ? $limitCheck :''; ?>  class="ip limit2"> <?php echo Yii::app()->controller->__trans('有'); ?>
                            </label>
                            <select id="b_limit_open_time_week_start" class="b_entrance" name="Building[limit_time_week_start]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($weekLimitTime[0]) && $weekLimitTime[0] != ''){
										if($h.':'.sprintf("%02d", $m) == $weekLimitTime[0]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 00;
										$h++;
									}
								}
								?>
                            </select>
                            ～
                            <select id="b_limit_open_time_week_finish" class="b_entrance" name="Building[limit_time_week_finish]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($weekLimitTime[1]) && $weekLimitTime[1] != ''){
										if($h.':'.sprintf("%02d", $m) == $weekLimitTime[1]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected;  ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 00;
										$h++;
									}
								}
								?>
                            </select>
                            <label>
                            	<input type="radio" name="Building[limit_time_week]" value="3" <?php echo isset($limitWeek[0]) && $limitWeek[0] == '3' ? $limitCheck :''; ?>  class="ip"> <?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                            <span class=""><?php echo Yii::app()->controller->__trans('Saturday'); ?></span>
                            <label>
                            	<input type="radio" name="Building[limit_time_sat]" value="1" <?php echo isset($limitSat[0]) && $limitSat[0] == '1' ? $limitCheck :''; ?>  class="ip limit3"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                            	<input type="radio" name="Building[limit_time_sat]" value="2" <?php echo isset($limitSat[0]) && $limitSat[0] == '2' ? $limitCheck :''; ?> class="ip limit4"> <?php echo Yii::app()->controller->__trans('有'); ?>
                            </label>
                            <select id="b_limit_open_time_sat_start" class="b_entrance" name="Building[limit_time_sat_start]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($satLimitTime[0]) && $satLimitTime[0] != ''){
										if($h.':'.sprintf("%02d", $m) == $satLimitTime[0]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 00;
										$h++;
									}
								}
								?>
                            </select>
                            ～
                            <select id="b_limit_open_time_sat_finish" class="b_entrance" name="Building[limit_time_sat_finish]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($satLimitTime[1]) && $satLimitTime[1] != ''){
										if($h.':'.sprintf("%02d", $m) == $satLimitTime[1]){
											$selected = 'selected';
										}
									}	
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 0;
										$h++;
									}
								}
								?>
                           	</select>
                            <label>
                            	<input type="radio" name="Building[limit_time_sat]" value="3" <?php echo isset($limitSat[0]) && $limitSat[0] == '3' ? $limitCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                            <span class=""><?php echo Yii::app()->controller->__trans('Sunday・Holiday'); ?></span>
                            <label>
                            	<input type="radio" name="Building[limit_time_sun]" value="1" <?php echo isset($limitSun[0]) && $limitSun[0] == '1' ? $limitCheck :''; ?> class="ip limit5"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                            	<input type="radio" name="Building[limit_time_sun]" value="2" <?php echo isset($limitSun[0]) && $limitSun[0] == '2' ? $limitCheck :''; ?> class="ip limit6"><?php echo Yii::app()->controller->__trans('有'); ?>
                            </label>
                            <select id="b_limit_open_time_sun_start" class="b_entrance" name="Building[limit_time_sun_start]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){
									$selected ="";
									if(isset($sunLimitTime[0]) && $sunLimitTime[0] != ''){
										if($h.':'.sprintf("%02d", $m) == $sunLimitTime[0]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 0;
										$h++;
									}
								}
								?>
                            </select>
                            ～
                            <select id="b_limit_open_time_sun_finish" class="b_entrance" name="Building[limit_time_sun_finish]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($sunLimitTime[1]) && $sunLimitTime[1] != ''){
										if($h.':'.sprintf("%02d", $m) == $sunLimitTime[1]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>"<?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 0;
										$h++;
									}
								}
								?>
                            </select>
                            <label>
                            	<input type="radio" name="Building[limit_time_sun]" value="3" <?php echo isset($limitSun[0]) && $limitSun[0] == '3' ? $limitCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                        </td>
                     </tr>
                    <tr>
						<?php
                        	if(isset($model->air_condition_time) && $model->air_condition_time != ''){
								$airCondTime = $model->air_condition_time;
								$airCondTime_exp = explode(',',$airCondTime);
								$weekAircondTime = array();
								$satAircondTime = array();
								$sunAircondTime = array();
								$airWeek = explode('-',$airCondTime_exp[0]);
								if($airWeek[0] == 2){
									if(count($airWeek) > 0){
										$weekAircondTime= explode('~',$airWeek[1]);
									}
								}
								$airSat = explode('-',$airCondTime_exp[1]);
								if($airSat[0] == 2){
									if(count($airSat) > 0){
										$satAircondTime= explode('~',$airSat[1]);
									}
								}
								$airSun = explode('-',$airCondTime_exp[2]);
								if($airSun[0] == 2){
									if(count($airSun) > 0){
										$sunAircondTime= explode('~',$airSun[1]);
									}
								}
							}
						?>
                        <th scope="row">
                        	<?php echo Yii::app()->controller->__trans('Air conditioning use time limit'); ?>
                        </th>
                        <td>
                        	<span><?php echo Yii::app()->controller->__trans('weekday'); ?></span>
                            <?php $airCheck = 'checked'; ?>
                            <label>
                            	<input type="radio" name="Building[air_condition_week]" value="1" <?php echo isset($airWeek[0]) && $airWeek[0] == '1' ? $airCheck :''; ?> class="ip airCondition1"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                            	<input type="radio" name="Building[air_condition_week]" value="2" <?php echo isset($airWeek[0]) && $airWeek[0] == '2' ? $airCheck :''; ?> class="ip airCondition2"><?php echo Yii::app()->controller->__trans('有'); ?>
                           	</label>
                            <select id="b_condition_open_time_week_start" class="b_entrance" name="Building[air_condition_week_start]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($weekAircondTime[0]) && $weekAircondTime[0] != ''){
										if($h.':'.sprintf("%02d", $m) == $weekAircondTime[0]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 00;
										$h++;
									}
								}
								?>
                            </select>
                            ～
                            <select id="b_condition_open_time_week_finish" class="b_entrance" name="Building[air_condition_week_finish]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($weekAircondTime[1]) && $weekAircondTime[1] != ''){
										if($h.':'.sprintf("%02d", $m) == $weekAircondTime[1]){
											$selected = 'selected';
										}
									}	
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected;  ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 00;
										$h++;
									}
								}
								?>
                            </select>
                            <label>
                            	<input type="radio" name="Building[air_condition_week]" value="3" <?php echo isset($airWeek[0]) && $airWeek[0] == '3' ? $airCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                            <span class=""><?php echo Yii::app()->controller->__trans('Saturday'); ?></span>
                            <label>
                            	<input type="radio" name="Building[air_condition_sat]" value="1" <?php echo isset($airSat[0]) && $airSat[0] == '1' ? $airCheck :''; ?> class="ip airCondition3"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                            	<input type="radio" name="Building[air_condition_sat]" value="2" <?php echo isset($airSat[0]) && $airSat[0] == '2' ? $airCheck :''; ?> class="ip airCondition4"> <?php echo Yii::app()->controller->__trans('有'); ?>
                            </label>
                            <select id="b_condition_open_time_sat_start" class="b_entrance" name="Building[air_condition_sat_start]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($satAircondTime[0]) && $satAircondTime[0] != ''){
										if($h.':'.sprintf("%02d", $m) == $satAircondTime[0]){
											$selected = 'selected';
										}
									}	
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 00;
										$h++;
									}
								}
								?>
                            </select>
                            ～
                            <select id="b_condition_open_time_sat_finish" class="b_entrance" name="Building[air_condition_sat_finish]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($satAircondTime[1]) && $satAircondTime[1] != ''){
										if($h.':'.sprintf("%02d", $m) == $satAircondTime[1]){
											$selected = 'selected';
										}
									}	
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 0;
										$h++;
									}
								}
								?>
                            </select>
                            <label>
                            	<input type="radio" name="Building[air_condition_sat]" value="3" <?php echo isset($airSat[0]) && $airSat[0] == '3' ? $airCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                            <span class=""><?php echo Yii::app()->controller->__trans('Sunday・Holiday'); ?></span>
                            <label>
                            	<input type="radio" name="Building[air_condition_sun]" value="1" <?php echo isset($airSun[0]) && $airSun[0] == '1' ? $airCheck :''; ?> class="ip airCondition5"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                            	<input type="radio" name="Building[air_condition_sun]" value="2" <?php echo isset($airSun[0]) && $airSun[0] == '2' ? $airCheck :''; ?> class="ip airCondition6"><?php echo Yii::app()->controller->__trans('有'); ?>
                            </label>
                            <select id="b_condition_open_time_sun_start" class="b_entrance" name="Building[air_condition_sun_start]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){
									$selected ="";
									if(isset($sunAircondTime[0]) && $sunAircondTime[0] != ''){
										if($h.':'.sprintf("%02d", $m) == $sunAircondTime[0]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 0;
										$h++;
									}
								}
								?>
                            </select>
                            ～
                            <select id="b_condition_open_time_sun_finish" class="b_entrance" name="Building[air_condition_sun_finish]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($sunAircondTime[1]) && $sunAircondTime[1] != ''){
										if($h.':'.sprintf("%02d", $m) == $sunAircondTime[1]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>"<?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 0;
										$h++;
									}
								}
								?>
                           	</select>
                            <label>
                            	<input type="radio" name="Building[air_condition_sun]" value="3" <?php echo isset($airSun[0]) && $airSun[0] == '3' ? $airCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                        </td>
                    </tr>
                    <tr>
                    	<?php
						if(isset($model->parking_time) && $model->parking_time != ''){
							$parkTime = $model->parking_time;
							$parkTime_exp = explode(',',$parkTime);
							$weekParkTime = array();
							$satParkTime = array();
							$sunParkTime = array();
							$parkWeek = explode('-',$parkTime_exp[0]);
							if($parkWeek[0] == 2){
								if(count($parkWeek) > 0){
									$weekParkTime= explode('~',$parkWeek[1]);
								}
							}
							$parkSat = explode('-',$parkTime_exp[1]);
							if($parkSat[0] == 2){
								if(count($parkSat) > 0){
									$satParkTime= explode('~',$parkSat[1]);
								}
							}
							$parkSun = explode('-',$parkTime_exp[2]);
							if($parkSun[0] == 2){
								if(count($parkSun) > 0){
									$sunParkTime= explode('~',$parkSun[1]);
								}
							}	
						}
						?>
                        <th scope="row">
                        	<font><?php echo Yii::app()->controller->__trans('Parking use time limit'); ?></font>
                        </th>
                        <td>
                        	<span><?php echo Yii::app()->controller->__trans('weekday'); ?></span>
                            <?php $parkCheck = 'checked'; ?>
                            <label>
                            	<input type="radio" name="Building[park_time_week]" value="1" class="ip" <?php echo isset($parkWeek[0]) && $parkWeek[0] == '1' ? $parkCheck :''; ?>><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                            	<input type="radio" name="Building[park_time_week]" value="2"  <?php echo isset($parkWeek[0]) && $parkWeek[0] == '2' ? $parkCheck :''; ?> class="ip"> <?php echo Yii::app()->controller->__trans('有'); ?>
                            </label>
                            <select id="b_park_open_time_week_start" class="b_entrance" name="Building[park_time_week_start]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($weekParkTime[0]) && $weekParkTime[0] != ''){
										if($h.':'.sprintf("%02d", $m) == $weekParkTime[0]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected; ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 00;
										$h++;
									}
								}
								?>
                            </select>
                            ～
                            <select id="b_park_open_time_week_finish" class="b_entrance" name="Building[park_time_week_finish]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($weekParkTime[1]) && $weekParkTime[1] != ''){
										if($h.':'.sprintf("%02d", $m) == $weekParkTime[1]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected;  ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 00;
										$h++;
									}
								}
								?>
                            </select>
                            <label>
                            	<input type="radio" name="Building[park_time_week]" value="3" <?php echo isset($parkWeek[0]) && $parkWeek[0] == '3' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                            <span class=""><?php echo Yii::app()->controller->__trans('Saturday'); ?></span>
                            <label>
                            	<input type="radio" name="Building[park_time_sat]" value="1" <?php echo isset($parkSat[0]) && $parkSat[0] == '1' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                            	<input type="radio" name="Building[park_time_sat]" value="2" <?php echo isset($parkSat[0]) && $parkSat[0] == '2' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('有'); ?>
                            </label>
                            <select id="b_park_open_time_sat_start" class="b_entrance" name="Building[park_time_sat_start]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($satParkTime[0]) && $satParkTime[0] != ''){
										if($h.':'.sprintf("%02d", $m) == $satParkTime[0]){
											$selected = 'selected';
										}
									}	
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 00;
										$h++;
									}
								}
								?>
                            </select>
                            ～
                            <select id="b_park_open_time_sat_finish" class="b_entrance" name="Building[park_time_sat_finish]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($satParkTime[1]) && $satParkTime[1] != ''){
										if($h.':'.sprintf("%02d", $m) == $satParkTime[1]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 0;
										$h++;
									}
								}
								?>
                            </select>
                            <label>
                            	<input type="radio" name="Building[park_time_sat]" value="3" <?php echo isset($parkSat[0]) && $parkSat[0] == '3' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                            <span class=""><?php echo Yii::app()->controller->__trans('Sunday・Holiday'); ?></span>
                            <label>
                            	<input type="radio" name="Building[park_time_sun]" value="1" <?php echo isset($parkSun[0]) && $parkSun[0] == '1' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                            </label>
                            <label>
                            	<input type="radio" name="Building[park_time_sun]" value="2" <?php echo isset($parkSun[0]) && $parkSun[0] == '2' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('有'); ?>
                            </label>
                            <select id="b_park_open_time_sun_start" class="b_entrance" name="Building[park_time_sun_start]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){
									$selected ="";
									if(isset($sunParkTime[0]) && $sunParkTime[0] != ''){
										if($h.':'.sprintf("%02d", $m) == $sunParkTime[0]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>" <?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 0;
										$h++;
									}
								}
								?>
                            </select>
                            ～
                            <select id="b_park_open_time_sun_finish" class="b_entrance" name="Building[park_time_sun_finish]">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								$h = 0;
								$m = 0;
								while($h < 24){	
									$selected ="";
									if(isset($sunParkTime[1]) && $sunParkTime[1] != ''){
										if($h.':'.sprintf("%02d", $m) == $sunParkTime[1]){
											$selected = 'selected';
										}
									}
								?>
                                <option value="<?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?>"<?php echo $selected ?>><font><font><?php echo $h; ?>:<?php echo sprintf("%02d", $m); ?></font></font></option>
                                <?php
									$m += 5;
									if($m == 60){
										$m = 0;
										$h++;
									}
								}
								?>
                            </select>
                            <label>
                            	<input type="radio" name="Building[park_time_sun]" value="3" <?php echo isset($parkSun[0]) && $parkSun[0] == '3' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                            </label><br/>
                        </td>
                    </tr>
                    <?php /*?><tr>
                    	<th scope="row">
                        	<font><font><?php echo Yii::app()->controller->__trans('Lend one house'); ?> </font></font>
                        </th>
                        <td>
							<?php $lendCheck ='selected'; ?>
                            <select name="Building[lend_house]" id="b_allrent" data-role="none">
                                <option value="" <?php echo isset($model->lend_house) && $model->lend_house == '' ? $lendCheck :''; ?>><font><font>-</font></font></option>
                                <option value="1"  <?php echo isset($model->lend_house) && $model->lend_house == '1' ? $lendCheck :''; ?>><font><font><?php echo Yii::app()->controller->__trans('Yes'); ?></font></font></option>
                                <option value="2" <?php echo isset($model->lend_house) && $model->lend_house == '2' ? $lendCheck :''; ?>><font><font><?php echo Yii::app()->controller->__trans('Consultation'); ?></font></font></option>
                                <option value="0" <?php echo isset($model->lend_house) && $model->lend_house == '0' ? $lendCheck :''; ?>><font><font><?php// echo Yii::app()->controller->__trans('Improper'); ?></font></font></option>
                            </select>
                        </td>
                    </tr><?php */?>
                    <tr>
                        <th scope="row">
                            <font><font class="goog-text-highlight"><?php echo Yii::app()->controller->__trans('Ceiling height'); ?></font></font>
                        </th>
                        <td>
                        	<font><font><?php echo Yii::app()->controller->__trans('Standard floor'); ?>:</font></font>
                            <input type="text" name="Building[ceiling_height]" value="<?php echo isset($model->ceiling_height) && $model->ceiling_height != '' ? $model->ceiling_height :''; ?>" class="ty5"><font><font>&nbsp;mm</font></font>
                       	</td>
                    </tr>
                    <tr>
                    	<th scope="row">
                        	<font><font><?php echo Yii::app()->controller->__trans('Air-conditioning control'); ?></font></font>
                        </th>
                        <td>
							<?php $airControlCheck = 'checked'; ?>
                            <label>
                                <input type="radio" name="Building[air_control_type]" value="0"  <?php echo isset($model->air_control_type) && $model->air_control_type == '0' ? $airControlCheck :''; ?> checked class="ip"><font><font> <?php echo Yii::app()->controller->__trans('unknown'); ?></font></font>
                            </label>
                            <label class="rd4">
                                <input type="radio" name="Building[air_control_type]" <?php echo isset($model->air_control_type) && $model->air_control_type == '2' ? $airControlCheck :''; ?> value="2"><font><font><?php echo Yii::app()->controller->__trans('個別'); ?> </font></font>
                            </label>
                            <label class="rd4">
                                <input type="radio" name="Building[air_control_type]" <?php echo isset($model->air_control_type) && $model->air_control_type == '1' ? $airControlCheck :''; ?> value="1"><font><font> <?php echo Yii::app()->controller->__trans('セントラル'); ?></font></font>
                            </label>
                            <label class="rd4">
                                <input type="radio" name="Building[air_control_type]" <?php echo isset($model->air_control_type) && $model->air_control_type == '3' ? $airControlCheck :''; ?> value="1"><font><font> <?php echo Yii::app()->controller->__trans('個別・セントラル'); ?></font></font>
                            </label>
                        </td>
                    </tr>
                    
                    <?php /*?><tr>
                        <th scope="row">
                                <font><font><?php echo Yii::app()->controller->__trans('OA floor'); ?></font></font>
                        </th>
                        <td>
                            <?php $oaChecked = 'checked'; ?>
                            <label>
                                <input type="radio" name="Building[oa_floor]" value="0" class="ip oa_radio_1"  <?php echo isset($model->oa_floor) && $model->oa_floor == '0' ? $oaChecked : 'checked'; ?> >
                                <font><font><?php echo Yii::app()->controller->__trans('unknown'); ?> </font></font>
                            </label>
                            <label class="rd4">
                                <input type="radio" name="Building[oa_floor]" class="oa_radio_2" value="2" <?php echo isset($model->oa_floor) && $model->oa_floor == '2' ? $oaChecked :''; ?>>
                            </label>
                            <font><?php echo Yii::app()->controller->__trans('Yes'); ?>  (</font>
                            <input type="text" name="Building[oa_floor_txt]" class="ty5 oa_txt"><font><font>&nbsp;mm)</font></font>
                            <label class="rd4">
                                <input type="radio" name="Building[oa_floor]" class="oa_radio_3" value="1" <?php echo isset($model->oa_floor) && $model->oa_floor == '1' ? $oaChecked :''; ?>><font><font> <?php echo Yii::app()->controller->__trans('Nothing'); ?></font></font>
                            </label>
                        </td>
                    </tr><?php */?>
                    <tr>
                    	<th scope="row">
                        	<font><font><?php echo Yii::app()->controller->__trans('Optical cable'); ?></font></font>
                        </th>
                        <td>
                        	<?php $opCableCheck = 'checked'; ?>
                            <label>
                            	<input type="radio" name="Building[opticle_cable]" value="0"  <?php echo isset($model->opticle_cable) && $model->opticle_cable == '0' ? $opCableCheck :''; ?> checked=""  class="ip"><font><font><?php echo Yii::app()->controller->__trans('unknown'); ?> </font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[opticle_cable]" <?php echo isset($model->opticle_cable) && $model->opticle_cable == '2' ? $opCableCheck :''; ?> value="2"><font><font><?php echo Yii::app()->controller->__trans('Pull Yes'); ?> </font></font>
                            </label>
                            <label class="rd4">
                            	<input type="radio" name="Building[opticle_cable]"  <?php echo isset($model->opticle_cable) && $model->opticle_cable == '1' ? $opCableCheck :''; ?> value="1"><font><font><?php echo Yii::app()->controller->__trans('Nothing'); ?> </font></font>
                            </label>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('wholesale lease'); ?>
                        </th>
                        <td>
							<?php $selected ="selected"; ?>
                            <select name="Building[wholesale_lease]" id="Building_wholesale_lease" data-role="none">
                            	<option value=""><font><font>-</font></font></option>
                                <option value="1" <?php echo isset($model->wholesale_lease) && $model->wholesale_lease == '1' ? $selected :''; ?>><?php echo Yii::app()->controller->__trans('可能'); ?></option>
                                <option value="2" <?php echo isset($model->wholesale_lease) && $model->wholesale_lease == '2' ? $selected :''; ?>><?php echo Yii::app()->controller->__trans('Ask'); ?></option>
                                <option value="0" <?php echo isset($model->wholesale_lease) && $model->wholesale_lease == '0' ? $selected :''; ?>><?php echo Yii::app()->controller->__trans('不可'); ?></option>
                            </select>
                            <?php echo $form->error($model,'wholesale_lease'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Security'); ?>
                        </th>
                        <td>
                        	<select name="Building[security_id]" id="Building_security_id" data-role="none">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								foreach($securityList as $security){
									$select = '';
									if($model->security_id == $security->security_id){
										$select='selected';
									}
								?>
                                <option value="<?php echo $security->security_id; ?>"<?php if(isset($model->security_id) && $model->security_id != ''){echo $select;} ?>><?php echo $security->security_name; ?></option>
                                <?php
                                }
								?>
                            </select>
                            <?php echo $form->error($model,'security_id'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th>
							<?php echo Yii::app()->controller->__trans('notes');?>
                        </th>
                        <td>
                        	<textarea name="Building[notes]" class="txta2"><?php echo isset($model->notes) && $model->notes != '0' ? $model->notes :'';?></textarea>
                       	</td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('Our Manage Form'); ?>
                        </th>
                        <td>
                        	<select name="Building[form_type_id]" id="Building_form_type_id" data-role="none">
                            	<option value=""><font><font>-</font></font></option>
                                <?php
								foreach($formTypeList as $formType){
									$select = '';
									if($model->form_type_id == $formType->form_type_id){
										$select='selected';
									}
								?>
                                <option value="<?php echo $formType->form_type_id; ?>" <?php if(isset($model->form_type_id) && $model->form_type_id != ''){echo $select;} ?>><?php echo $formType->form_type_name; ?></option>
                                <?php
                                }
								?>
                            </select>
                            <?php echo $form->error($model,'form_type_id'); ?>
                        </td>
                    </tr>
                    <tr>
                    	<th scope="row">
							<?php echo Yii::app()->controller->__trans('condominium ownership'); ?>
                        </th>
                        <td>
							<?php  $check='checked';?>
                            <input type="checkbox" name="Building[condominium_ownership]" id="Building_condominium_ownership" value="1" <?php echo isset($model->condominium_ownership) && $model->condominium_ownership == '1' ? $check :''; ?>>
                            <font><font><?php echo Yii::app()->controller->__trans('Some in the building, including the division of ownership'); ?> </font></font> <?php echo $form->error($model,'condominium_ownership'); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="bt_input_box">
        	<div class="bt_input">
            	<input class="bt_entry btnSaveBuilding" type="submit" name="yt0" value="<?php echo Yii::app()->controller->__trans('SUBMIT'); ?>">
                <?php //echo CHtml::submitButton($model->isNewRecord ? 'SUBMIT' : 'Save',array('class'=>'bt_entry')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!-- form --> 

<!--Modal Popup for Add Transmission matters-->
<div class="modal-box hide" id="modalCreateBuilding">
  <div class="content">
    <div class="box-header">
      <h2 class="popup-label"><?php echo Yii::app()->controller->__trans('Create Building'); ?></h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content">
      <table>
        <tr>
          <td colspan='3'>同じ名前の建物がすでに追加されています。 この建物を追加してもよろしいですか？</td>
        </tr>
        <tr>
          <td>
          	<button type="button" class="btnCancel" id="btnCancel"><?php echo キャンセル; ?></button>
          </td>
          <td>
          	<button type="button" class="btnView" id="btnView"><?php echo 同じ名前の建物を見る; ?></button>
          </td>
          <td>	
			<button type="button" class="btnContinue" id="btnContinue"><?php echo 持続する; ?></button>
		  </td>
        </tr>
      </table>
    </div>
  </div>
</div>

<script>
$(document).ready(function(e) {
	$(document).on('blur','#Building_name',function(){
		/*var _tVal = $(this).val();
		if(_tVal != ""){
			$(this).val(_tVal+" ビル");
		}*/
	});
	
	
	$(document).on('change','#buildCheck',function(){
		/*var name = $('#Building_name').val();
		
		if (name.toLowerCase().indexOf("ビル") >= 0){
			var res = name.split(" ");
			res.pop();
			if(res.length >= 1){
				res = res.join();
				$('#Building_name').val(res);
			}else{
				$('#Building_name').val(name+" ビル");
			}
		}else{
			$('#Building_name').val(name+" ビル");
		}*/
		
		//if ($("#buildCheck").is(':checked')){
			/*if (name.toLowerCase().indexOf("ビル") >= 0){
				var res = name.replace("ビル", "");
				$('#Building_name').val(res);
			}else{
				$('#Building_name').val(name+"ビル");
			}*/
		//}else{
			//$('#Building_name').val(name+" ビル");
		//}
	});
	
	function containsAny(str, substrings) {
        for (var i = 0; i != substrings.length; i++) {
           var substring = substrings[i];
           if (str.indexOf(substring) != - 1) {
             return substring;
           }
        }
        return null; 
    }
    var addr = ['北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県'];
    
	$(document).on('click','.btnSaveBuilding',function(e){
		e.preventDefault();
		name = $('#Building_name').val();
// 		if ($("#buildCheck").is(':checked')){
// 			$('#Building_name').val(name);
// 		}else{
// 			$('#Building_name').val(name+" ビル");
// 		}
        var ey = 0 ; 
        var em = 0;
        if($('#Building_built_year').val() != "")
        {
            var s = $('#Building_built_year').val(); 
            if(/^[0-9]{1,10}$/.test(+s))
            {
                //return true;
                 ey = 0 ; 
            }
            else
            {
                ey = 1;
                //$('.errorYear').html('Invalid Year');
                //$('#Building_built_year').focus();
                // return false;
            }
        }
        if($('#Building_built_month').val() != "")
        {
            var s = $('#Building_built_month').val(); 
            if(/^[0-9]{1,10}$/.test(+s))
            {
                // return true;
                em = 0;
            }
            else
            {
                em =  1;
                //$('.errorYear').html('Invalid Month');
                //$('#Building_built_month').focus();
                // return false;
            }
        }

        if(em > 0 || ey > 0)
        {
            if(em>0 && ey>0)
            {
                $('.errorYear').html('半角数字で入力して下さい');
                $('#Building_built_year').focus();
                        return false;
            }
            else if(em > 0){
                $('.errorYear').html('半角数字で入力して下さい');
                $('#Building_built_month').focus();
                return false;
            }
            else{
                $('.errorYear').html('半角数字で入力して下さい');
                $('#Building_built_year').focus();
                        return false;
            }

        }
        else{
            $('.errorYear').html('');
        }


        if($('#Building_name').val() == ''){
			$('#Building_name').css('border-color','red');
			$('.errorName').html('この項目は必須です');
			$('#Building_name').focus();
			return false;
		}
		
		if($('.Building_address').val() == ''){
			$('.Building_address').css('border-color','red');
			$('.errorAddress').html('この項目は必須です');
			$('.Building_address').focus();
			return false;
		}else if(containsAny($('.Building_address').val(), addr)==null) {
			$('.Building_address').css('border-color','red');
			$('.errorAddress').html('都道府県から入力してください。');
			$('.Building_address').focus();
			return false;
		}
		else{
			var url = baseUrl+'/index.php?r=building/isExist';
			
			call({url:url,params:{name:name},type:'POST',dataType : 'json'},function(resp){
				if(resp=='true') {
					$('#building-form').submit();
				} else {
					$('#modalCreateBuilding').show();
				}
			});
		}
	});

	$(document).on('click','.btnCancel',function(e){
		$('#modalCreateBuilding').hide();
	});

	$(document).on('click','.btnView',function(e){
		$('#modalCreateBuilding').hide();
		var name = $('#Building_name').val();
		location.href = baseUrl+"/index.php?r=building%2FsearchBuildingResult&areaMinValue=0&buildingSearchName="+name;
	});

	$(document).on('click','.btnContinue',function(e){
		$('#building-form').submit();
	});
	
	$(document).on('keyup','.Building_address',function(e){
		if($('.Building_address').val() == ''){
			$('.Building_address').css('border-color','red');
			$('.errorAddress').html('この項目は必須です');
		}else{
			$('.Building_address').css('border-color','#dbe2e8');
			$('.errorAddress').html('');
		}
	});

	$(document).on('keyup','#Building_name',function(e){
		if($('#Building_name').val() == ''){
			$('#Building_name').css('border-color','red');
			$('.errorName').html('この項目は必須です');
		}else{
			$('#Building_name').css('border-color','#dbe2e8');
			$('.errorName').html('');
		}
	});
});
</script>