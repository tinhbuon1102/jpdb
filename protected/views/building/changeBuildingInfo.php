<input type="hidden" name="changeBuildingUrl" id="changeBuildingUrl" value="<?php echo Yii::app()->createUrl('building/saveBuildingInfo'); ?>" />
<form name="frmChangeBuildingInfo" id="frmChangeBuildingInfo" method="post" class="text-center" action="">
	<input type="hidden" name="id" id="id" value="<?php echo $buildingDetails['building_id'] ?>" />
    <table>
    	<tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Building Featured'); ?>
            </td>
            <td>
                <input type="checkbox" name="is_featured" value="1" <?php echo isset($buildingDetails['is_featured']) && $buildingDetails['is_featured'] == '1' ? 'checked' :''; ?> class="ip">
            </td>
        </tr>
    	<tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Building Name'); ?>
            </td>
            <td>
				<?php $name = $buildingDetails['name']; ?>
                <input type="text" name="name" class="name ty9 mb1" id="Building_name" value="<?php echo isset($name) && $name != "" ? $name : ''; ?>" style="width:350px;" />
            </td>
        </tr>
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Building Name English'); ?>
            </td>
            <td>
                <input type="text" name="name_en" class="name ty9 mb1" id="Building_name_en" value="<?php echo isset($buildingDetails['name_en']) && $buildingDetails['name_en'] != "" ? $buildingDetails['name_en'] : ''; ?>" style="width:350px;" />
            </td>
        </tr>
        
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Search Keyword Japanese'); ?>
            </td>
            <td>
                <input type="text" name="search_keywords_ja" class="name ty9 mb1" id="search_keywords_ja" value="<?php echo isset($buildingDetails['search_keywords_ja']) && $buildingDetails['search_keywords_ja'] != "" ? $buildingDetails['search_keywords_ja'] : ''; ?>" style="width:100%;" />
            </td>
        </tr>
        
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Search Keyword English'); ?>
            </td>
            <td>
                <input type="text" name="search_keywords_en" class="name ty9 mb1" id="search_keywords_en" value="<?php echo isset($buildingDetails['search_keywords_en']) && $buildingDetails['search_keywords_en'] != "" ? $buildingDetails['search_keywords_en'] : ''; ?>" style="width:100%;" />
            </td>
        </tr>
        
        <?php /* ?>
        <tr>
        	<td></td>
            <td>
            	<label>
                    <input type="checkbox" name="build_check" value="1" class="ip" id="buildCheck" <?php echo ($buildingDetails['bill_check'] != 0) ? 'checked' : ''; ?>>
                    <?php echo Yii::app()->controller->__trans('Unnecessary "building" at end of building name'); ?>
                </label>
                <p class="note">
					<?php echo Yii::app()->controller->__trans('If end of building name has "building",please dont enter name including "building".'); ?><br>
                    <?php echo Yii::app()->controller->__trans('If not,please check "Unnecessary "building" at end of building name".'); ?>
                </p>
            </td>
        </tr>
        <?php */ ?>
        
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Building Old Name'); ?>
           </td>
           <td>
           		<?php $old_name = $buildingDetails['old_name']; ?>
           		<input type="text" name="old_name" class="old_name ty9" id="old_name" value="<?php echo isset($old_name) && $old_name != "" ? $old_name : ''; ?>" />
           </td>
        </tr>
        <tr>
        	<td>
            	<?php echo Yii::app()->controller->__trans('Building Name Kana'); ?>
            </td>
            <td>
            	<?php $name_kana = $buildingDetails['name_kana']; ?>
            	<input type="text" name="name_kana" class="name_kana ty9" id="name_kana" value="<?php echo isset($name_kana) && $name_kana != "" ? $name_kana : ''; ?>" />
            </td>
        </tr>
        
        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Description'); ?>(<?php echo Yii::app()->controller->__trans('Japanese'); ?>)
                            </th>
                            <td>
								<textarea name="description_ja" class="txta2"><?php echo @$buildingDetails['description_ja']?></textarea>
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
								<textarea name="description_en" class="txta2"><?php echo @$buildingDetails['description_en']?></textarea>
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
								<select name="video_type" class="movie-type">
		                    		<option value="youtube" <?php echo @$buildingDetails['video_type'] == 'youtube' ? 'selected' : ''?>><?php echo Yii::app()->controller->__trans('Youtube'); ?></option>
		                    		<option value="vimeo" <?php echo @$buildingDetails['video_type'] == 'vimeo' ? 'selected' : ''?>><?php echo Yii::app()->controller->__trans('Vimeo'); ?></option>
                    			</select>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Movie ID'); ?>
                            </th>
                            <td>
								<input type="text" style="width: 100%"  name="video_id" class="movie-id" value="<?php echo @$buildingDetails['video_id']?>" placeholder="<?php echo Yii::app()->controller->__trans('input ID here'); ?>">
								<br />
                    			<i><?php echo Yii::app()->controller->__trans('Example : <br/> Youtube URL: https://www.youtube.com/watch?v=btlRMrlaCQk <br/> ID = btlRMrlaCQk'); ?></i>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Average rent of neighbor'); ?>
                            </th>
                            <td>
								<input type="text" id="avg_neighbor_fee_min" name="avg_neighbor_fee_min" value="<?php echo @$buildingDetails['avg_neighbor_fee_min']?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('yen'); ?> &nbsp;~
                           		<input type="text" id="avg_neighbor_fee_max" name="avg_neighbor_fee_max" value="<?php echo @$buildingDetails['avg_neighbor_fee_max']?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('yen'); ?>
                                <p class="note">
									<?php echo Yii::app()->controller->__trans('Please enter neighbor avg fee for premium office website.'); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                        	<th scope="row">
								<?php echo Yii::app()->controller->__trans('Average rent of neighbor Calculated'); ?>
                            </th>
                            <td>
								<input type="text" readonly="readonly" id="avg_neighbor_fee_min_sqm" name="avg_neighbor_fee_min_sqm" value="<?php echo isset($buildingDetails['avg_neighbor_fee_min_sqm']) ? $buildingDetails['avg_neighbor_fee_min_sqm'] : ''?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('yen'); ?> &nbsp;~
                            	<input type="text" readonly="readonly" id="avg_neighbor_fee_max_sqm" name="avg_neighbor_fee_max_sqm" value="<?php echo isset($buildingDetails['avg_neighbor_fee_min_sqm']) ? $buildingDetails['avg_neighbor_fee_min_sqm'] : ''?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('yen'); ?>
                            </td>
                        </tr>
                        
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Address'); ?>
            </td>
            <td>
				<?php
                	$address = $buildingDetails['address'];
				?>
                <input type="text" name="address" class="address" id="address" value="<?php echo isset($address) && $address != "" ? $address : ''; ?>" />
            </td>
        </tr>
        
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Address English'); ?>
            </td>
            <td>
				<?php
                	$address_en = $buildingDetails['address_en'];
				?>
                <input type="text" name="address_en" class="address_en" id="address_en" value="<?php echo isset($address_en) && $address_en != "" ? $address_en : ''; ?>" />
            </td>
        </tr>
        
        <tr>
        	<td rowspan="3">
				<?php echo Yii::app()->controller->__trans('Construction'); ?>
           	</td>
            <td>
            	<select name="constructionType" class="constructionType" id="constructionType">
            		<option value="">-</option>
				<?php
                	foreach($constructionTypeList as $constructionType){
						$selected = '';
						if($constructionType->construction_type_id == $buildingDetails['construction_type_id']){
							$selected = 'selected';
						}
				?>
                	<option value="<?php echo $constructionType->construction_type_id; ?>" <?php echo $selected; ?>><?php echo $constructionType->construction_type_name; ?></option>
				<?php
                	}
				?>
                </select>
            </td>
        </tr>
                    <script>
                    var v=$('#constructionType option:selected').text();
                    var ctn = $("#constructionTypename"); 
                    if(v=='-') {
                		ctn.attr("readonly",false);
                		$('#construction_type_name_en_wraper').css('opacity', 1);
                    } else {
                    	ctn.attr("readonly",true);
                    	$('#construction_type_name_en_wraper').css('opacity', 0);
                    }                        
                    $('#constructionType').change(function(){
                        var v=$('#constructionType option:selected').text();
                        var ctn = $("#constructionTypename"); 
                        if(v=='-') {
                        	v = '';
                    		ctn.attr("readonly",false);
                    		$('#construction_type_name_en_wraper').css('opacity', 1);
                        } else {
                        	ctn.attr("readonly",true);
                        	$('#construction_type_name_en_wraper').css('opacity', 0);
                        }                        
                        ctn.val(v);                        
                    });
                    </script>
        <tr>
            <td>
				<?php
                	$construction_type_name = $buildingDetails['construction_type_name'];
				?>
                <input type="text" name="constructionTypename" class="constructionTypename" id="constructionTypename" value="<?php echo isset($construction_type_name) && $construction_type_name != "" ? $construction_type_name : ''; ?>" style="width:350px;" placeholder="特別な構造名（日本語）"/>
            </td>
        </tr>
        <tr id="construction_type_name_en_wraper">
            <td>
				<?php
                	$construction_type_name_en = $buildingDetails['construction_type_name_en'];
				?>
                <input type="text" name="constructionTypenameEn" class="constructionTypenameEn" id="constructionTypenameEn" value="<?php echo isset($construction_type_name_en) && $construction_type_name_en != "" ? $construction_type_name_en : ''; ?>" style="width:350px;" placeholder="特別な構造名（英語）"/>
            </td>
        </tr>
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Scale'); ?>
           	</td>
            <td>
            	<?php
                	if(isset($buildingDetails['floor_scale']) && $buildingDetails['floor_scale'] != ''){
						$floor_scale = $buildingDetails['floor_scale'];
						$extraxtFloorScale = explode('-',$floor_scale);
						$floor_scale_up = $extraxtFloorScale[0];
						$floor_scale_down = $extraxtFloorScale[1];
					}
				?>
				<?php echo Yii::app()->controller->__trans('above ground'); ?>&nbsp;
                <input type="text" name="floor_scale_up" id="floor_scale_up" value="<?php echo isset($floor_scale_up) && $floor_scale_up != '' ? $floor_scale_up : ''; ?>" style="width:20%;">
                &nbsp;<?php echo Yii::app()->controller->__trans('F'); ?>&nbsp;&nbsp;
				<?php echo Yii::app()->controller->__trans('underground'); ?>&nbsp;
                <input type="text" name="floor_scale_down" id="floor_scale_down" value="<?php echo isset($floor_scale_down) && $floor_scale_down != '' ? $floor_scale_down : ''; ?>" style="width:20%;">
                &nbsp;<?php echo Yii::app()->controller->__trans('F'); ?>
           	</td>
        </tr>
        <tr>
        	<td>見込み賃料</td>
            <?php
				$expRent_exp1 = $expRent_exp = array();
				if(isset($buildingDetails['exp_rent']) && $buildingDetails['exp_rent'] != ''){
					$expRent_exp = explode('-',$buildingDetails['exp_rent']);
					if(isset($expRent_exp) && !empty($expRent_exp)){
						$expRent_exp1 = explode('~',$expRent_exp[0]);
					}
				}
			?>
            <td>
            	<input type="text" name="exp_rent" value="<?php echo isset($expRent_exp1[0]) && $expRent_exp1[0] != '' ? $expRent_exp1[0] :''; ?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('yen'); ?> &nbsp;~
                <input type="text" name="exp_rent2" value="<?php echo isset($expRent_exp1[1]) && $expRent_exp1[1] != '' ? $expRent_exp1[1] :''; ?>" class="ty5">&nbsp;<?php echo Yii::app()->controller->__trans('yen'); ?> &nbsp;(&nbsp;
                <label>
                	<?php $expRentCheck = 'checked'; ?>
                    <input type="radio" name="exp_rent_opt" value="1" <?php echo isset($expRent_exp[1]) && $expRent_exp[1] == '1' ? $expRentCheck :''; ?> checked="" class="ip">
                    <?php echo Yii::app()->controller->__trans('共益費含む'); ?>
                </label>
                <label>
                    <input type="radio" name="exp_rent_opt" value="2" <?php echo isset($expRent_exp[1]) && $expRent_exp[1] == '2' ? $expRentCheck :''; ?> class="ip">
                    <?php echo Yii::app()->controller->__trans('共益費含まない'); ?>
                </label>&nbsp;)
                <label>
                    <input type="checkbox" name="exp_rent_disabled" value="1" <?php echo isset($buildingDetails['exp_rent_disabled']) && $buildingDetails['exp_rent_disabled'] == '1' ? 'checked' :''; ?> class="ip">
                    <?php echo Yii::app()->controller->__trans('資料に表示しない'); ?>
                </label>
            </td>
        </tr>
        <tr>
        	<td>
            	<?php echo Yii::app()->controller->__trans('Earthquake resistance standards'); ?>
            </td>
            <td>
            	<?php $quakeResistanceList = QuakeResistanceStandards::model()->findAll('is_active = 1'); ?>
                <select name="earth_quake_res_std" id="Building_earth_quake_res_std">
                	<option value="">-</option>
                    <?php
					foreach($quakeResistanceList as $quake){
						$selected ="";
						if($buildingDetails['earth_quake_res_std'] == $quake->quake_resistance_standard_id){
							$selected = 'selected';
						}
					?>
                    <option value="<?php echo $quake->quake_resistance_standard_id; ?>" <?php echo $selected; ?>><?php echo $quake->quake_resistance_standard_name; ?></option>
                    <?php
					}
					?>
                </select>
            </td>
        </tr>
        <tr>
        	<td>
            	<?php echo Yii::app()->controller->__trans('Earthquake resistance standards note'); ?>
            </td>
            <td>
            	<?php $earth_quake_res_std_note = $buildingDetails['earth_quake_res_std_note'] ?>
            	<input type="text" name="earth_quake_res_std_note" id="earth_quake_res_std_note" class="earth_quake_res_std_note" value="<?php echo isset($earth_quake_res_std_note) && $earth_quake_res_std_note == '' ? $earth_quake_res_std_note :''; ?>">
            </td>
        </tr>
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('emergency power generating'); ?>
            </td>
            <td>
				<?php $checked ="checked"; ?>
                <label>
                	<input type="radio" name="emr_power_gen" id="emr_power_gen" value="0" checked="" class="ip"  <?php echo isset($buildingDetails['emr_power_gen']) && $buildingDetails['emr_power_gen'] == '0' ? $checked :''; ?> >
                    <font><font> <?php echo Yii::app()->controller->__trans('unknown'); ?></font></font>
                </label>
                <label class="rd4">
                	<input type="radio" name="emr_power_gen" id="emr_power_gen" value="2" <?php echo isset($buildingDetails['emr_power_gen']) && $buildingDetails['emr_power_gen'] == '2' ? $checked :''; ?>>
                    <font><font> <?php echo Yii::app()->controller->__trans('Correspondence'); ?></font></font>
                </label>
                <label class="rd4">
                	<input type="radio" name="emr_power_gen" id="emr_power_gen" value="1" <?php echo isset($buildingDetails['emr_power_gen']) && $buildingDetails['emr_power_gen'] == '1' ? $checked :''; ?>>
                    <font><font> <?php echo Yii::app()->controller->__trans('incompatible'); ?></font></font>
                </label>
            </td>
        </tr>        
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('Year and month Built in'); ?>
            </td>
            <td>
				<?php
                    $built_month = $built_year = '';
                    if(isset($buildingDetails['built_year']) && $buildingDetails['built_year']!= ''){
                        $builtDate = $buildingDetails['built_year'];
                        $built_month_ex = explode('-',$builtDate);
                        $built_year = $built_month_ex[0];
                        $built_month = $built_month_ex[1];
                    }
                ?>
                <input type="text" name="build_year" id="build_year" value="<?php echo $built_year; ?>" style="width:20%;">
                &nbsp;<?php echo Yii::app()->controller->__trans('years'); ?>&nbsp;
                <input type="text" name="build_month" id="build_month" value="<?php echo $built_month; ?>" style="width:20%;">
                &nbsp;<?php echo Yii::app()->controller->__trans('月'); ?>
         	</td>
        </tr>
        <tr>
        	<td>
            	<?php echo Yii::app()->controller->__trans('Renewal Data'); ?>
            </td>
            <td>
            	<?php $renewal_data = $buildingDetails['renewal_data'];
				 ?>
            	<input class="ty9 renewal_data" name="renewal_data" id="renewal_data" type="text" value="<?php echo isset($renewal_data) && $renewal_data != "" ? $renewal_data : ''; ?>">
            </td>
        </tr>
        <tr>
        	<td>
            	<?php echo Yii::app()->controller->__trans('Renewal Data English'); ?>
            </td>
            <td>
            	<?php $renewal_data_en = $buildingDetails['renewal_data_en'];
				 ?>
            	<input class="ty9 renewal_data_en" style="width: 100%" name="renewal_data_en" id="renewal_data_en" type="text" value="<?php echo isset($renewal_data_en) && $renewal_data_en != "" ? $renewal_data_en : ''; ?>">
            </td>
        </tr>
        <tr>
        	<td>
            	<?php echo Yii::app()->controller->__trans('Standard Floor Space'); ?>
            </td>
            <td>
            	<?php $std_floor_space = $buildingDetails['std_floor_space']; ?>
            	<input class="ty5 std_floor_space" name="std_floor_space" id="std_floor_space" type="text" value="<?php echo isset($std_floor_space) && $std_floor_space != "" ? $std_floor_space : ''; ?>">
                <font>
                	<font>
                    	&nbsp;<?php echo Yii::app()->controller->__trans('tsubo'); ?>
                    </font>
                </font>
			</td>
        </tr>
        <tr>
        	<td>
            	<?php echo Yii::app()->controller->__trans('std_floor_space Calculated'); ?>
            </td>
        	<td>
				<input readonly="readonly" class="ty5 std_floor_space_calculated" name="std_floor_space_calculated" id="std_floor_space_calculated" type="text" value="<?php echo isset($std_floor_space_calculated) && $std_floor_space_calculated != "" ? $std_floor_space_calculated : ''; ?>">m&sup2;
        	</td>
        </tr>
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('total floor space'); ?>
            </td>
            <td>
            	<input name="total_floor_space" id="total_floor_space" type="text" value="<?php echo isset($buildingDetails['total_floor_space']) && $buildingDetails['total_floor_space'] != "" ? $buildingDetails['total_floor_space'] : ''; ?>">
                &nbsp;<?php echo Yii::app()->controller->__trans('m'); ?><sup>2</sup>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::app()->controller->__trans('total rent space unit'); ?>
            </td>
            <td>
            	<input name="total_rent_space_unit" id="total_rent_space_unit" type="text" value="<?php echo isset($buildingDetails['total_rent_space_unit']) && $buildingDetails['total_rent_space_unit'] != "" ? $buildingDetails['total_rent_space_unit'] : ''; ?>">&nbsp;m<sup>2</sup>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::app()->controller->__trans('Shared rate'); ?>
            </td>
            <td>
                <input type="text" name="shared_rate" value="<?php echo isset($buildingDetails['shared_rate']) && $buildingDetails['shared_rate'] != '' ? $buildingDetails['shared_rate'] :''; ?>" class="ty5">&nbsp;%
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::app()->controller->__trans('Building with deadline'); ?>
            </td>
            <td>
            <?php if(isset($buildingDetails['building_with_deadline']) && !empty($buildingDetails['building_with_deadline'])){
                    $expBuildingDeadLine = explode('-',$buildingDetails['building_with_deadline']); 
                    $chk = 'checked';
                }
             ?>
            <input type="checkbox" name="building_with_deadline" value="1" <?php echo isset($expBuildingDeadLine[0]) && $expBuildingDeadLine[0] == 1 ? $chk:''; ?> class="ip building_with_deadline">
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
            <td>
                <?php echo Yii::app()->controller->__trans('Elevator'); ?>
            </td>
            <td>
                <?php
                $elevator_exp = array();
                if(isset($buildingDetails['elevator']) && $buildingDetails['elevator'] != ''){
                    $elevator_exp = explode('-',$buildingDetails['elevator']);
                }
				
                ?>
                <?php $checked ="checked"; ?>
                <label>
                    <input type="radio" name="elevator" class="ele_unkonwn" value="-2" <?php echo $buildingDetails['elevator'] == '' || substr( $buildingDetails['elevator'], 0, 2 ) == '-2' || (isset($elevator_exp[0]) && $elevator_exp[0] == '-2') ? $checked :''; ?>>
                    <?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label>
                <label class="rd4">
                    <input type="radio" name="elevator" value="1" <?php echo isset($elevator_exp[0]) && $elevator_exp[0] == '1' ? $checked :''; ?> class="elevator_radio">
                    <?php echo Yii::app()->controller->__trans('Exist'); ?>
                </label>（
                <select name="b_ev_group" id="b_ev_num" class="elevator_group">
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
                <select name="b_ev_group2" id="b_ev_num" class="elevator_group">
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
                <select  name="b_ev_group3" id="b_ev_num" class="elevator_group">
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
                <select name="b_ev_group4" id="b_ev_num" class="elevator_group">
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
                <select name="b_ev_group5" id="b_ev_num" class='elevator_group'>
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
                <font><?php echo Yii::app()->controller->__trans('base'); ?></font>
                <label class="rd4">
                    <input type="radio" name="elevator" class="ele_noexist" value="2"  <?php echo isset($elevator_exp[0]) && $elevator_exp[0] == '2' ? $checked :''; ?>>
                    <font><font><?php echo Yii::app()->controller->__trans('none'); ?> </font></font>
                </label>
            </td>
        </tr>
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('elevator does not stop'); ?>
            </td>
            <td>
            	<label>
                	<input type="radio" name="elevator_non_stop" value="0" <?php echo isset($buildingDetails['elevator_non_stop']) && $buildingDetails['elevator_non_stop'] == '0' ? $checked :''; ?> class="ip">
                    <font><font> <?php echo Yii::app()->controller->__trans('unknown'); ?></font></font>
               	</label>
                <label class="rd4">
                	<input type="radio" name="elevator_non_stop" <?php echo isset($buildingDetails['elevator_non_stop']) && $buildingDetails['elevator_non_stop'] == '2' ? $checked :''; ?> value="2">
                    <?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <label class="rd4">
                	<input type="radio" name="elevator_non_stop" <?php echo isset($buildingDetails['elevator_non_stop']) && $buildingDetails['elevator_non_stop'] == '1' ? $checked :''; ?> value="1">
                    <font><font> <?php echo Yii::app()->controller->__trans('none'); ?></font></font>
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::app()->controller->__trans('Elevator Hall'); ?>
            </td>
            <td>
                <label>
                    <input type="radio" name="elevator_hall" value="0" <?php echo isset($buildingDetails['elevator_hall']) && $model->elevator_hall == '0' ? $checked :''; ?> class="ip">
                    <font><font> <?php echo Yii::app()->controller->__trans('unknown'); ?></font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="elevator_hall" value="2" <?php echo isset($buildingDetails['elevator_hall']) && $buildingDetails['elevator_hall'] == '2' ? $checked :''; ?>>
                    <font><font><?php echo Yii::app()->controller->__trans('exist'); ?> </font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="elevator_hall" value="1" <?php echo isset($buildingDetails['elevator_hall']) && $buildingDetails['elevator_hall'] == '1' ? $checked :''; ?>>
                    <font><font><?php echo Yii::app()->controller->__trans('none'); ?>  </font></font>
                </label>
            </td>
        </tr>
        <tr>
            <td><?php echo Yii::app()->controller->__trans('Entrance with attention'); ?></td>
            <td>
                <label>
                    <input type="radio" name="entrance_with_attention" value="0" <?php echo isset($buildingDetails['entrance_with_attention']) && $buildingDetails['entrance_with_attention'] == '0' ? $checked :''; ?>  class="ip">
                    <font><font> <?php echo Yii::app()->controller->__trans('unknown'); ?></font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="entrance_with_attention" value="2" <?php echo isset($buildingDetails['entrance_with_attention']) && $buildingDetails['entrance_with_attention'] == '2' ? $checked :''; ?>>
                    <font><font><?php echo Yii::app()->controller->__trans('exist'); ?> </font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="entrance_with_attention" value="1" <?php echo isset($buildingDetails['entrance_with_attention']) && $buildingDetails['entrance_with_attention'] == '1' ? $checked :''; ?>>
                    <font><font><?php echo Yii::app()->controller->__trans('none'); ?> </font></font>
                </label>
            </td>
        </tr>
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('entrance open and close hours'); ?>
            </td>
            <td>
				<?php
                    $week_start = $week_finish = $sat_start = $sat_finish = $sun_start = $sun_finish ='';
                    if(isset($buildingDetails['ent_op_cl_time']) && $buildingDetails['ent_op_cl_time'] != ''){
						$entOpclTime = $buildingDetails['ent_op_cl_time'];
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
                    <input type="radio" name="ent_week_opt" value="1" <?php echo isset($week[0]) && $week[0] == 1 ?$select_ent_week:''; ?> class="ip ent1"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="ent_week_opt" value="2" <?php echo isset($week[0]) && $week[0] == 2 ?$select_ent_week:''; ?> class="ip ent2"><?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="entrance_open_time_week_start" class="b_entrance" name="entrance_open_time_week_start">
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
                <select id="entrance_open_time_week_finish" class="b_entrance" name="entrance_open_time_week_finish">
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
                    <input type="radio" name="ent_week_opt" value="3" <?php echo isset($week[0]) && $week[0] == 3 ?$select_ent_week:''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
                <span class=""><?php echo Yii::app()->controller->__trans('Saturday'); ?> </span>
                <label>
                    <input type="radio" name="ent_sat_opt" value="1" <?php echo isset($sat[0]) && $sat[0] == 1 ?$select_ent_week:''; ?> class="ip ent3"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="ent_sat_opt" value="2" <?php echo isset($sat[0]) && $sat[0] == 2 ?$select_ent_week:''; ?> class="ip ent4"><?php echo Yii::app()->controller->__trans('exist'); ?>  
                </label>
                <select id="entrance_open_time_sat_start" class="b_entrance" name="entrance_open_time_sat_start">
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
                <font><font> ～ </font></font>
                <select id="entrance_open_time_sat_finish" class="b_entrance" name="entrance_open_time_sat_finish">
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
                    <input type="radio" name="ent_sat_opt" value="3" <?php echo isset($sat[0]) && $sat[0] == 3 ?$select_ent_week:''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
                <span class=""><?php echo Yii::app()->controller->__trans('Sunday・Holiday'); ?> </span>
                <label>
                    <input type="radio" name="ent_sun_opt" value="1" <?php echo isset($sun[0]) && $sun[0] == 1 ?$select_ent_week:''; ?> class="ip ent5"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="ent_sun_opt" value="2" <?php echo isset($sun[0]) && $sun[0] == 2 ?$select_ent_week:''; ?> class="ip ent6"><?php echo Yii::app()->controller->__trans('exist'); ?> 
                </label>
                <select id="entrance_open_time_sun_start" class="b_entrance" name="entrance_open_time_sun_start">
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
                <font><font> ～ </font></font>
                <select id="entrance_open_time_sun_finish" class="b_entrance" name="entrance_open_time_sun_finish">
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
                    <input type="radio" name="ent_sun_opt" value="3" <?php echo isset($entOpclTime_exp[2]) && $entOpclTime_exp[2] == 3 ?$select_ent_week:''; ?> class="ip"> <?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::app()->controller->__trans('Entrance Auto Lock'); ?>
            </td>
            <td>
                <label>
                    <input type="radio" name="ent_auto_lock" value="0" <?php echo isset($buildingDetails['ent_auto_lock']) && $buildingDetails['ent_auto_lock'] == '0' ? $checked :''; ?> class="ip">
                    <font><font><?php echo Yii::app()->controller->__trans('unknown'); ?> </font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="ent_auto_lock" value="2" <?php echo isset($buildingDetails['ent_auto_lock']) && $buildingDetails['ent_auto_lock'] == '2' ? $checked :''; ?>>
                    <font><font><?php echo Yii::app()->controller->__trans('exist'); ?></font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="ent_auto_lock" value="1" <?php echo isset($buildingDetails['ent_auto_lock']) && $buildingDetails['ent_auto_lock'] == '1' ? $checked :''; ?>>
                    <font><font><?php echo Yii::app()->controller->__trans('none'); ?> </font></font>
                </label>
            </td>
        </tr>
        <tr>
        	<td>
				<?php echo Yii::app()->controller->__trans('parking'); ?>
            </td>
            <td>
				<?php
                    $buildingunitNo = $buildingDetails['parking_unit_no'];
                    $unitNo = explode('-',$buildingunitNo );
                ?>
                <label>
                    <input type="radio" name="parking_unit_no" value="1" id="parking_unit_no"  class="parking_unit_radio" <?php echo isset($unitNo[0]) && $unitNo[0] == '1' ? $checked :''; ?>>
                    <?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>（
                <input type="text" name="b_parking_num" id="parking_unit_no_text" value="<?php if(isset($unitNo[1]) && $unitNo[1] != ''){echo $unitNo[1];}else{echo '';} ?>" class="ty11" style="width: 10%;">
                <font><font> <?php echo Yii::app()->controller->__trans('spaces'); ?>) </font></font>
                <label class="rd4">
                    <input type="radio" name="parking_unit_no" value="2" <?php echo isset($unitNo[0]) && $unitNo[0] == '2' ? $checked :''; ?> class="parking_radio_2">
                    <font><font> <?php echo Yii::app()->controller->__trans('none'); ?></font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="parking_unit_no" value="3" <?php echo isset($unitNo[0]) && $unitNo[0] == '3' ? $checked :''; ?> class="parking_radio_3">
                    <?php echo Yii::app()->controller->__trans('exist but unknown unit number'); ?>
                </label>
            </td>
        </tr>
        <tr>
			<?php 
            if(isset($buildingDetails['limit_of_usage_time']) && $buildingDetails['limit_of_usage_time'] != ''){
                $limitUsageTime = $buildingDetails['limit_of_usage_time'];
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
            <td>
                <?php echo Yii::app()->controller->__trans('limit of usage time'); ?>
            </td>
            <td>
                <span><?php echo Yii::app()->controller->__trans('weekday'); ?></span>
                <?php $limitCheck = 'checked'; ?>
                <label>
                    <input type="radio" name="limit_time_week" value="1" <?php echo isset($limitWeek[0]) && $limitWeek[0] == '1' ? $limitCheck :''; ?> class="ip limit1"> <?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="limit_time_week" value="2" <?php echo isset($limitWeek[0]) && $limitWeek[0] == '2' ? $limitCheck :''; ?>  class="ip limit2"> <?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="b_limit_open_time_week_start" class="b_entrance" name="limit_time_week_start">
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
                <select id="b_limit_open_time_week_finish" class="b_entrance" name="limit_time_week_finish">
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
                    <input type="radio" name="limit_time_week" value="3" <?php echo isset($limitWeek[0]) && $limitWeek[0] == '3' ? $limitCheck :'checked'; ?>  class="ip"> <?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
                <span class=""><?php echo Yii::app()->controller->__trans('Saturday'); ?></span>
                <label>
                    <input type="radio" name="limit_time_sat" checked value="1" <?php echo isset($limitSat[0]) && $limitSat[0] == '1' ? $limitCheck :''; ?>  class="ip limit3"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="limit_time_sat" value="2" <?php echo isset($limitSat[0]) && $limitSat[0] == '2' ? $limitCheck :''; ?> class="ip limit4"> <?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="b_limit_open_time_sat_start" class="b_entrance" name="limit_time_sat_start">
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
                <select id="b_limit_open_time_sat_finish" class="b_entrance" name="limit_time_sat_finish">
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
                    <input type="radio" name="limit_time_sat" value="3" <?php echo isset($limitSat[0]) && $limitSat[0] == '3' ? $limitCheck :'checked'; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
                <span class=""><?php echo Yii::app()->controller->__trans('Sunday・Holiday'); ?></span>
                <label>
                    <input type="radio" name="limit_time_sun" checked value="1" <?php echo isset($limitSun[0]) && $limitSun[0] == '1' ? $limitCheck :''; ?> class="ip limit5"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="limit_time_sun" value="2" <?php echo isset($limitSun[0]) && $limitSun[0] == '2' ? $limitCheck :''; ?> class="ip limit6"><?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="b_limit_open_time_sun_start" class="b_entrance" name="limit_time_sun_start">
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
                <select id="b_limit_open_time_sun_finish" class="b_entrance" name="limit_time_sun_finish">
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
                    <input type="radio" name="limit_time_sun" value="3" <?php echo isset($limitSun[0]) && $limitSun[0] == '3' ? $limitCheck :'checked'; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
            </td>
         </tr>
        <tr>
			<?php
                if(isset($buildingDetails['air_condition_time']) && $buildingDetails['air_condition_time'] != ''){
                    $airCondTime = $buildingDetails['air_condition_time'];
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
            <td>
                <?php echo Yii::app()->controller->__trans('Air conditioning use time limit'); ?>
            </td>
            <td>
                <span><?php echo Yii::app()->controller->__trans('weekday'); ?></span>
                <?php $airCheck = 'checked'; ?>
                <label>
                    <input type="radio" name="air_condition_week" value="1" <?php echo isset($airWeek[0]) && $airWeek[0] == '1' ? $airCheck :''; ?> class="ip airCondition1"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="air_condition_week" value="2" <?php echo isset($airWeek[0]) && $airWeek[0] == '2' ? $airCheck :''; ?> class="ip airCondition2"><?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="b_condition_open_time_week_start" class="b_entrance" name="air_condition_week_start">
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
                <select id="b_condition_open_time_week_finish" class="b_entrance" name="air_condition_week_finish">
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
                    <input type="radio" name="air_condition_week" value="3" <?php echo isset($airWeek[0]) && $airWeek[0] == '3' ? $airCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
                <span class=""><?php echo Yii::app()->controller->__trans('Saturday'); ?></span>
                <label>
                    <input type="radio" name="air_condition_sat" value="1" <?php echo isset($airSat[0]) && $airSat[0] == '1' ? $airCheck :''; ?> class="ip airCondition3"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="air_condition_sat" value="2" <?php echo isset($airSat[0]) && $airSat[0] == '2' ? $airCheck :''; ?> class="ip airCondition4"> <?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="b_condition_open_time_sat_start" class="b_entrance" name="air_condition_sat_start">
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
                <select id="b_condition_open_time_sat_finish" class="b_entrance" name="air_condition_sat_finish">
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
                    <input type="radio" name="air_condition_sat" value="3" <?php echo isset($airSat[0]) && $airSat[0] == '3' ? $airCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
                <span class=""><?php echo Yii::app()->controller->__trans('Sunday・Holiday'); ?></span>
                <label>
                    <input type="radio" name="air_condition_sun" value="1" <?php echo isset($airSun[0]) && $airSun[0] == '1' ? $airCheck :''; ?> class="ip airCondition5"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="air_condition_sun" value="2" <?php echo isset($airSun[0]) && $airSun[0] == '2' ? $airCheck :''; ?> class="ip airCondition6"><?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="b_condition_open_time_sun_start" class="b_entrance" name="air_condition_sun_start">
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
                <select id="b_condition_open_time_sun_finish" class="b_entrance" name="air_condition_sun_finish">
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
                    <input type="radio" name="air_condition_sun" value="3" <?php echo isset($airSun[0]) && $airSun[0] == '3' ? $airCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
            </td>
        </tr>
        <tr>
			<?php
            if(isset($buildingDetails['parking_time']) && $buildingDetails['parking_time'] != ''){
                $parkTime = $buildingDetails['parking_time'];
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
            <td>
                <font><?php echo Yii::app()->controller->__trans('Parking use time limit'); ?></font>
            </td>
            <td>
                <span><?php echo Yii::app()->controller->__trans('weekday'); ?></span>
                <?php $parkCheck = 'checked'; ?>
                <label>
                    <input type="radio" name="park_time_week" value="1" class="ip" <?php echo isset($parkWeek[0]) && $parkWeek[0] == '1' ? $parkCheck :''; ?>><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="park_time_week" value="2"  <?php echo isset($parkWeek[0]) && $parkWeek[0] == '2' ? $parkCheck :''; ?> class="ip"> <?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="b_park_open_time_week_start" class="b_entrance" name="park_time_week_start">
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
                <select id="b_park_open_time_week_finish" class="b_entrance" name="park_time_week_finish">
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
                    <input type="radio" name="park_time_week" value="3" <?php echo isset($parkWeek[0]) && $parkWeek[0] == '3' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
                <span class=""><?php echo Yii::app()->controller->__trans('Saturday'); ?></span>
                <label>
                    <input type="radio" name="park_time_sat" value="1" <?php echo isset($parkSat[0]) && $parkSat[0] == '1' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="park_time_sat" value="2" <?php echo isset($parkSat[0]) && $parkSat[0] == '2' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="b_park_open_time_sat_start" class="b_entrance" name="park_time_sat_start">
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
                <select id="b_park_open_time_sat_finish" class="b_entrance" name="park_time_sat_finish">
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
                    <input type="radio" name="park_time_sat" value="3" <?php echo isset($parkSat[0]) && $parkSat[0] == '3' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
                <span class=""><?php echo Yii::app()->controller->__trans('Sunday・Holiday'); ?></span>
                <label>
                    <input type="radio" name="park_time_sun" value="1" <?php echo isset($parkSun[0]) && $parkSun[0] == '1' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('Nothing'); ?>
                </label>
                <label>
                    <input type="radio" name="park_time_sun" value="2" <?php echo isset($parkSun[0]) && $parkSun[0] == '2' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('exist'); ?>
                </label>
                <select id="b_park_open_time_sun_start" class="b_entrance" name="park_time_sun_start">
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
                <select id="b_park_open_time_sun_finish" class="b_entrance" name="park_time_sun_finish">
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
                    <input type="radio" name="park_time_sun" value="3" <?php echo isset($parkSun[0]) && $parkSun[0] == '3' ? $parkCheck :''; ?> class="ip"><?php echo Yii::app()->controller->__trans('unknown'); ?>
                </label><br/>
            </td>
        </tr>
        <tr>
            <td>
                <font><font class="goog-text-highlight"><?php echo Yii::app()->controller->__trans('Ceiling height'); ?></font></font>
            </td>
            <td>
                <font><font><?php echo Yii::app()->controller->__trans('Standard floor'); ?>:</font></font>
                <input type="text" name="ceiling_height" value="<?php echo isset($buildingDetails['ceiling_height']) && $buildingDetails['ceiling_height'] != '' ? $buildingDetails['ceiling_height'] :''; ?>" class="ty5"><font><font>&nbsp;mm</font></font>
            </td>
        </tr>
        <tr>
            <td>
                <font><font><?php echo Yii::app()->controller->__trans('Air-conditioning control'); ?></font></font>
            </td>
            <td>
                <?php $airControlCheck = 'checked'; ?>
                <label>
                    <input type="radio" name="air_control_type" value="0"  <?php echo isset($buildingDetails['air_control_type']) && $buildingDetails['air_control_type'] == '0' ? $airControlCheck :''; ?> class="ip"><font><font> <?php echo Yii::app()->controller->__trans('unknown'); ?></font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="air_control_type" <?php echo isset($buildingDetails['air_control_type']) && $buildingDetails['air_control_type'] == '2' ? $airControlCheck :''; ?> value="2"><font><font><?php echo '個別'; ?> </font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="air_control_type" <?php echo isset($buildingDetails['air_control_type']) && $buildingDetails['air_control_type'] == '1' ? $airControlCheck :''; ?> value="1"><font><font> <?php echo 'セントラル'; ?></font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="air_control_type" <?php echo isset($buildingDetails['air_control_type']) && $buildingDetails['air_control_type'] == '3' ? $airControlCheck :''; ?> value="1"><font><font> <?php echo '個別・セントラル'; ?></font></font>
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <font><font><?php echo Yii::app()->controller->__trans('Optical cable'); ?></font></font>
            </td>
            <td>
                <?php $opCableCheck = 'checked'; ?>
                <label>
                    <input type="radio" name="opticle_cable" value="0"  <?php echo isset($buildingDetails['opticle_cable']) && $buildingDetails['opticle_cable'] == '0' ? $opCableCheck :''; ?> checked=""  class="ip"><font><font><?php echo Yii::app()->controller->__trans('unknown'); ?> </font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="opticle_cable" <?php echo isset($buildingDetails['opticle_cable']) && $buildingDetails['opticle_cable'] == '2' ? $opCableCheck :''; ?> value="2"><font><font><?php echo Yii::app()->controller->__trans('installed'); ?> </font></font>
                </label>
                <label class="rd4">
                    <input type="radio" name="opticle_cable"  <?php echo isset($buildingDetails['opticle_cable']) && $buildingDetails['opticle_cable'] == '1' ? $opCableCheck :''; ?> value="1"><font><font><?php echo Yii::app()->controller->__trans('not installed'); ?> </font></font>
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::app()->controller->__trans('wholesale lease'); ?>
            </td>
            <td>
                <?php $selected ="selected"; ?>
                <select name="wholesale_lease" id="Building_wholesale_lease" data-role="none">
                    <option value=""><font><font>-</font></font></option>
                    <option value="1" <?php echo isset($buildingDetails['wholesale_lease']) && $buildingDetails['wholesale_lease'] == '1' ? $selected :''; ?>><?php echo Yii::app()->controller->__trans('可能'); ?></option>
                    <option value="2" <?php echo isset($buildingDetails['wholesale_lease']) && $buildingDetails['wholesale_lease'] == '2' ? $selected :''; ?>><?php echo Yii::app()->controller->__trans('Ask'); ?></option>
                    <option value="0" <?php echo isset($buildingDetails['wholesale_lease']) && $buildingDetails['wholesale_lease'] == '0' ? $selected :''; ?>><?php echo Yii::app()->controller->__trans('不可'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
        	<td><?php echo Yii::app()->controller->__trans('guard'); ?></td>
            <td>
            	<select name="security_id" id="security_id" data-role="none">
                	<option value=""><font><font>-</font></font></option>
					<?php
                    	foreach($securityList as $security){
							$select = '';
							if($buildingDetails['security_id'] == $security->security_id){
								$select='selected';
							}
					?>
                    <option value="<?php echo $security->security_id; ?>"<?php echo $select; ?>><?php echo $security->security_name; ?></option>
					<?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::app()->controller->__trans('notes');?>
            </td>
            <td>
                <textarea name="notes" class="txta2"><?php echo isset($buildingDetails['notes']) && $buildingDetails['notes'] != '0' ? $buildingDetails['notes'] :'';?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php echo Yii::app()->controller->__trans('Our Manage Form'); ?>
            </th>
            <td>
                <select name="form_type_id" id="form_type_id" data-role="none">
                    <option value=""><font><font>-</font></font></option>
                    <?php
					$formTypeList = FormType::model()->findAll('is_active = 1');
                    foreach($formTypeList as $formType){
                        $select = '';
                        if($buildingDetails['form_type_id']== $formType->form_type_id){
                            $select='selected';
                        }
                    ?>
                    <option value="<?php echo $formType->form_type_id; ?>" <?php if(isset($model->form_type_id) && $model->form_type_id != ''){echo $select;} ?>><?php echo $formType->form_type_name; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php echo Yii::app()->controller->__trans('condominium ownership'); ?>
            </th>
            <td>
                <?php  $check='checked';?>
                <input type="checkbox" name="condominium_ownership" id="condominium_ownership" value="1" <?php echo isset($buildingDetails['condominium_ownership']) && $buildingDetails['condominium_ownership'] == '1' ? $check :''; ?>>
                <font><font><?php echo Yii::app()->controller->__trans('Some in the building, including the division of ownership'); ?> </font></font>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<button type="button" class="btn-default btnChangeInfo">
					<?php echo Yii::app()->controller->__trans('Save Changes'); ?>
                </button>
            </td>
        </tr>
  </table>
</form>