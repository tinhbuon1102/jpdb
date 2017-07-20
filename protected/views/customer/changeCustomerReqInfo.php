<div id="main" class="full-width">
	<div class="postbox">
    	<div id="table-box" class="needs_edit">
        	<input type="hidden" name="changeCustomerReqInfo" id="changeCustomerReqInfo" value="<?php echo Yii::app()->createUrl('customer/saveCustomerReqInfo'); ?>" />
            <form id="frmCustomerReqInfo" class="frmCustomerReqInfo" method="post" name="form_customer_needs">
            	<div class="nsales_box">
                	<div class="table-wrapper">
                    	<div class="formbox f-l">
                        	<div class="table-inner">
                            	<table class="edit_input ei_tya mt">
                                	<tbody>
                                    	<tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Type of property'); ?></th>
                                           	<td>
												<?php
                                                	if(isset($propertyType) && count($propertyType) > 0){
														$i = 0;
														foreach($propertyType as $property){
															$checked = '';
															if(isset($customerRequirement[0]['type_of_property'])){
																$typePropert_ex = explode(',',$customerRequirement[0]['type_of_property']);
																$propertyType1 = PropertyType::model()->findAllByAttributes(array('property_type_id' => $typePropert_ex));
																foreach($propertyType1  as $prop){
																	if($prop['property_type_id'] == $property['property_type_id']){
																		$checked = 'checked';
																	}
																}
															}
															$i++;
												?>
                                                <label class="rd2">
                                                	<input type="checkbox" name="property_type[]" value="<?php echo $property['property_type_id'];  ?>" <?php echo $checked; ?>>
													<?php echo $property['property_type_name']; ?>
                                                </label>
												<?php
                                                		}
													}
												?>
                                           	</td>
                                        </tr>
                                        <input type="hidden" name="customerId" id="customerId" class="customerId" value="<?php  if(isset($customerRequirement['id']) && $customerRequirement['id'] != ''){echo $customerRequirement['id'];}else{if($customerRequirement[0]['customer_id'] && $customerRequirement[0]['customer_id'] != ''){echo $customerRequirement[0]['customer_id'];}} ?>">
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Area of location'); ?></th>
                                            <td>
                                            	<?php
													$cAddress = '';
													if(isset($customerRequirement[0]->area) && $customerRequirement[0]['area']!= ''){
														$cAddress = $customerRequirement[0]['area'];
													}
												?>
                                            	<textarea name="area" class="txta3"><?php echo $cAddress; ?></textarea>
                                                <div class="pad-top">
													<?php echo Yii::app()->controller->__trans('Group'); ?>：
                                                    <select name="areaGroup" id="u_n_area_type" data-role="none">
														<?php $selecte_are_grp = 'selected'; ?>
                                                        <option value="">-</option>
                                                        <option value="1" <?php if(isset($customerRequirement[0]['area_group']) && $customerRequirement[0]['area_group'] == 1){echo $selecte_are_grp;} ?>><?php echo Yii::app()->controller->__trans('エリアA（千代田／中央／港／新宿／渋谷）'); ?></option>
                                                        <option value="2" <?php if(isset($customerRequirement[0]->area_group) && $customerRequirement[0]['area_group'] == 2){echo $selecte_are_grp;} ?>><?php echo Yii::app()->controller->__trans('エリアB（品川／豊島／文京／台東／目黒）'); ?></option>
                                                        <option value="3" <?php if(isset($customerRequirement[0]->area_group) && $customerRequirement[0]['area_group'] == 3){echo $selecte_are_grp;} ?>><?php echo Yii::app()->controller->__trans('エリアC（中野／世田谷／江東）'); ?></option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Reason of area'); ?></th>
                                            <td>
                                            	<?php
													$cReasonForArea = '';
													if(isset($customerRequirement[0]->reason_for_area) && $customerRequirement[0]['reason_for_area'] != ''){
														$cReasonForArea = $customerRequirement[0]['reason_for_area'];
													}
												?>
                                            	<textarea name="reason_for_area" class="txta3"><?php echo $cReasonForArea; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Date to move in'); ?></th>
                                            <td>
                                            	<select name="date_to_move_in">
                                                	<option value="未定"><?php echo Yii::app()->controller->__trans('未定'); ?></option>
													<?php
                                                    	for($i = 120; $i >= 0; --$i){
															$time = strtotime(sprintf('-%d months', $i));
															$value = date('Y-m', strtotime("+24 month",$time));
															$label = date('Y年m月', strtotime("+24 month",$time));
															$select_dat = '';
															if(isset($customerRequirement[0]['move_in_date']) && $customerRequirement[0]['move_in_date']){
																$year_month= explode('-',$customerRequirement[0]['move_in_date']);
																if($value == $year_month[0].'-'.$year_month[1]){
																	$select_dat = 'selected';
																}
															}
															printf('<option value="%s" '.$select_dat.'>%s</option>', $value, $label);
														}
													?>
                                               	</select>
                                                <select name="day_to_move_in">
                                                	<option value="">-</option>
                                                    <?php
														for($i=1;$i<=31;$i++){
															$select = '';
															if(isset($customerRequirement[0]['move_in_date']) && $customerRequirement[0]['move_in_date']!= ''){
																$year_month= explode('-',$customerRequirement[0]['move_in_date']);
																if($i == $year_month[2].'日'){
																	$select = 'selected';
																}
															} 
													?>
                                                    <option value="<?php echo  $i.'日'; ?>"<?php echo $select; ?>><?php echo  $i.'日'; ?></option>
                                                   	<?php
                                                    	}
														$select_mov_date = 'selected';
													?>
                                                    <option value="上旬"<?php echo isset($customerRequirement[0]['move_in_date']) && $customerRequirement[0]['move_in_date'] == '上旬'? $select_mov_date : ''; ?>><?php echo Yii::app()->controller->__trans('上旬'); ?></option>
                                                    <option value="中旬" <?php echo isset($customerRequirement[0]['move_in_date']) && $customerRequirement[0]['move_in_date'] == '中旬'? $select_mov_date : ''; ?>><?php echo Yii::app()->controller->__trans('中旬'); ?></option>
                                                    <option value="下旬" <?php echo isset($customerRequirement[0]['move_in_date']) && $customerRequirement[0]['move_in_date'] == '下旬'? $select_mov_date : ''; ?>><?php echo Yii::app()->controller->__trans('下旬'); ?></option>
                                                    <option value="月内" <?php echo isset($customerRequirement[0]['move_in_date']) && $customerRequirement[0]['move_in_date'] == '月内'? $select_mov_date : ''; ?>><?php echo Yii::app()->controller->__trans('月内'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Reason of moving'); ?></th>
                                            <?php $select_rsn_mov = 'selected'; ?>
                                            <td>
                                            	<select name="reason_for_moving" id="u_n_reason" data-role="none">
                                                	<option value="">-</option>
                                                    <option value="新規" <?php echo isset($customerRequirement[0]['reason_of_moving']) &&  $customerRequirement[0]['reason_of_moving']  == '新規' ? $select_rsn_mov : ''; ?>><?php echo Yii::app()->controller->__trans('新規'); ?></option>
                                                    <option value="拡張" <?php echo isset($customerRequirement[0]['reason_of_moving']) &&  $customerRequirement[0]['reason_of_moving'] == '拡張' ? $select_rsn_mov : ''; ?>><?php echo Yii::app()->controller->__trans('拡張'); ?></option>
                                                    <option value="縮小" <?php echo isset($customerRequirement[0]['reason_of_moving']) &&  $customerRequirement[0]['reason_of_moving']  == '縮小' ? $select_rsn_mov : ''; ?>><?php echo Yii::app()->controller->__trans('縮小'); ?></option>
                                                    <option value="コスト削減" <?php echo isset($customerRequirement[0]['reason_of_moving']) &&  $customerRequirement[0]['reason_of_moving'] == 'コスト削減' ? $select_rsn_mov : ''; ?>><?php echo Yii::app()->controller->__trans('コスト削減'); ?></option>
                                                    <option value="事務所・フロア統合" <?php echo isset($customerRequirement[0]['reason_of_moving']) &&  $customerRequirement[0]['reason_of_moving'] == '事務所・フロア統合' ? $select_rsn_mov : ''; ?>><?php echo Yii::app()->controller->__trans('事務所・フロア統合'); ?></option>
                                                    <option value="支店展開" <?php echo isset($customerRequirement[0]['reason_of_moving']) &&  $customerRequirement[0]['reason_of_moving']  == '支店展開' ? $select_rsn_mov : ''; ?>><?php echo Yii::app()->controller->__trans('支店展開'); ?></option>
                                                    <option value="オーナーの都合" <?php echo isset($customerRequirement[0]['reason_of_moving']) &&  $customerRequirement[0]['reason_of_moving'] == 'オーナーの都合' ? $select_rsn_mov : ''; ?>><?php echo Yii::app()->controller->__trans('オーナーの都合'); ?></option>
                                                    <option value="設備面" <?php echo isset($customerRequirement[0]['reason_of_moving']) &&  $customerRequirement[0]['reason_of_moving']  == '設備面' ? $select_rsn_mov : ''; ?>><?php echo Yii::app()->controller->__trans('設備面'); ?></option>
                                                    <option value="その他" <?php echo isset($customerRequirement[0]['reason_of_moving']) &&  $customerRequirement[0]['reason_of_moving'] == 'その他' ? $select_rsn_mov : ''; ?>><?php echo Yii::app()->controller->__trans('その他'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"> <font><font><?php echo Yii::app()->controller->__trans('Floor Space'); ?></font></font> </th>
                                            <td>
                                            	<select name="floor_space_min" id="floor_space_min" data-role="none">
                                                	<option value="-">-</option>
													<?php
                                                    	for($i=1;$i<=3000;$i++){
															$select_space_min = '';
															if(isset($customerRequirement[0]['floor_space_min']) &&  $customerRequirement[0]['floor_space_min']!= ''){
																if($i == $customerRequirement[0]['floor_space_min']){
																	$select_space_min = 'selected';
																}
															}
													?>
                                                    <option value="<?php echo $i; ?>" <?php echo $select_space_min; ?>><?php echo $i; ?></option>
                                                    <?php
                                                    	}
													?>
                                                </select>
												<?php echo Yii::app()->controller->__trans('坪'); ?> ～
                                                <select name="floor_space_max" id="floor_space_max" data-role="none">
                                                	<option value="-">-</option>
													<?php
                                                    	for($i=1;$i<=3000;$i++){
															$select_space_max = '';
															if(isset($customerRequirement[0]['floor_space_max']) &&  $customerRequirement[0]['floor_space_max']!= ''){
																if($i == $customerRequirement[0]['floor_space_max']){
																	$select_space_max = 'selected';
																}
															}
													?>
                                                    <option value="<?php echo $i; ?>"<?php  echo $select_space_max; ?>><?php echo $i; ?></option>
													<?php
                                                    	}
													?>
                                                </select>
												<?php echo Yii::app()->controller->__trans('坪'); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="formbox f-r">
                        	<div class="table-inner">
                            	<table class="edit_input ei_tya mt">
                                	<tbody>
                                    	<?php /*?><tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Number of tsubo'); ?></th>
                                            <td>
                                            	<select name="number_f_tsubo_min" id="number_f_tsubo_min" data-role="none">
                                                	<option value="" selected="">-</option>
													<?php
                                                    	for($i=1;$i<=3000;$i++){
															$select_space_min = '';
															if(isset($customerRequirement[0]['number_of_tsubo']) &&  $customerRequirement[0]['number_of_tsubo']!= ''){
																$tsubo_min_ex = explode('-',$customerRequirement[0]['number_of_tsubo']);
																if($i ==  $tsubo_min_ex[0]){
																	$select_space_min = 'selected';
																}
															}
													?>
                                                    <option value="<?php echo $i; ?>" <?php echo $select_space_min; ?>><?php echo $i; ?></option>
                                                    <?php
                                                    	}
													?>
                                                </select>
                                                <?php echo Yii::app()->controller->__trans('坪'); ?>～
                                                <select name="number_f_tsubo_max" id="number_f_tsubo_max" data-role="none">
                                                	<option value="" selected="">-</option>
                                                    <?php
														for($i=1;$i<=3000;$i++){
															$select_space_max = '';
															if(isset($customerRequirement[0]['number_of_tsubo']) &&  $customerRequirement[0]['number_of_tsubo']!= ''){
																$tsubo_min_ex = explode('-',$customerRequirement[0]['number_of_tsubo']);
																if($i ==  $tsubo_min_ex [1]){
																	$select_space_max = 'selected';
																}
															}
													?>
                                                    <option value="<?php echo $i; ?>"<?php echo $select_space_max; ?>><?php echo $i; ?></option>
                                                   	<?php
                                                    	}
													?>
                                                </select>
                                                <?php echo Yii::app()->controller->__trans('坪'); ?>
                                            </td>
                                        </tr><?php */?>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Rent price（including condo fee）'); ?></th>
                                            <td>
                                            	<select name="rent_price_hi" id="rent_price_hi" data-role="none">
                                                	<option value="">-</option>
													<?php
                                                    	for($i=0.5;$i<5.0;$i=$i+0.1){
															$select_rent_hi = '';
															if(isset($customerRequirement[0]['rent_price']) &&  $customerRequirement[0]['rent_price']!= ''){
																$rent_min_ex = explode('-',$customerRequirement[0]['rent_price']);
																if(number_format($i,1,'.','') ==  $rent_min_ex[0]){
																	$select_rent_hi = 'selected';
																}
															}
													?>
                                                    <option value="<?php echo number_format($i,1,'.',''); ?>"<?php echo $select_rent_hi; ?>><?php echo number_format($i,1,'.',''); ?></option>
                                                    <?php
														}
													?>
                                                </select>
                                                <?php echo Yii::app()->controller->__trans('万'); ?>～
                                                <select name="rent_price_low" id="rent_price_low" data-role="none">
                                                	<option value="" selected="">-</option>
                                                    <?php
														for($i=0.5;$i<5.0;$i=$i+0.1){
															$select_rent_low = '';
															if(isset($customerRequirement[0]['rent_price']) &&  $customerRequirement[0]['rent_price']!= ''){
																$rent_min_ex = explode('-',$customerRequirement[0]['rent_price']);
																if(number_format($i,1,'.','') ==  $rent_min_ex[1]){
																	$select_rent_low = 'selected';
																}
															}
													?>
                                                    <option value="<?php echo number_format($i,1,'.',''); ?>" <?php echo $select_rent_low;  ?>><?php echo number_format($i,1,'.',''); ?></option>
                                                    <?php
														}
													?>
                                                </select>
                                                <?php echo Yii::app()->controller->__trans('万'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Notice of cancellation'); ?></th>
                                            <td>
                                            	<label class="rd">
													<?php $checked= 'checked'; ?>
                                                	<input type="radio" name="notice_of_cancellation" value="2"<?php if(isset($customerRequirement[0]['notice_of_cancellation']) && $customerRequirement[0]['notice_of_cancellation'] == '2'){echo $checked;}?>>
													<?php echo Yii::app()->controller->__trans('未'); ?>
                                                </label>
                                                <label class="rd">
                                                	<input type="radio" name="notice_of_cancellation" value="1" <?php if(isset($customerRequirement[0]['notice_of_cancellation']) && $customerRequirement[0]['notice_of_cancellation'] == '1'){echo $checked;}?>>
                                                    <?php echo Yii::app()->controller->__trans('済'); ?>
                                                </label>
                                           	</td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Parking'); ?></th>
                                            <td>
                                            	<select name="parking" id="parking" data-role="none">
                                                	<option value="">-</option>
                                                    <?php
														for($i=1;$i<=3000;$i++){
															$select_parking = '';
															if(isset($customerRequirement[0]['parking']) &&  $customerRequirement[0]['parking']!= ''){	
																if($i ==  $customerRequirement[0]['parking']){
																	$select_parking = 'selected';
																}
															}
													?>
                                                    <option value="<?php echo $i; ?>" <?php echo $select_parking; ?>><?php echo $i; ?></option>
                                                    <?php
														}
													?>
                                                </select>
                                                &nbsp;<?php echo Yii::app()->controller->__trans('台'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Number of floor'); ?></th>
                                            <td>
                                            	<select name="number_of_floor" id="number_of_floor" data-role="none">
													<?php $select_nu_floor = 'selected'; ?>
                                                    <option value="">-</option>
                                                    <option value="1フロア" <?php echo isset($customerRequirement[0]['number_of_floor']) &&  $customerRequirement[0]['number_of_floor']  == '1フロア' ? $select_nu_floor : ''; ?>>1<?php echo Yii::app()->controller->__trans('フロア'); ?></option>
                                                    <option value="2フロア以下" <?php echo isset($customerRequirement[0]['number_of_floor']) &&  $customerRequirement[0]['number_of_floor']  == '2フロア以下' ? $select_nu_floor : ''; ?>>2<?php echo Yii::app()->controller->__trans('フロア以下'); ?></option>
                                                    <option value="3フロア以下" <?php echo isset($customerRequirement[0]['number_of_floor']) &&  $customerRequirement[0]['number_of_floor']  == '3フロア以下' ? $select_nu_floor : ''; ?>>3<?php echo Yii::app()->controller->__trans('フロア以下'); ?></option>
                                                    <option value="4フロア以下" <?php echo isset($customerRequirement[0]['number_of_floor']) &&  $customerRequirement[0]['number_of_floor']  == '4フロア以下' ? $select_nu_floor : ''; ?>>4<?php echo Yii::app()->controller->__trans('フロア以下'); ?></option>
                                                    <option value="5フロア以下" <?php echo isset($customerRequirement[0]['number_of_floor']) &&  $customerRequirement[0]['number_of_floor'] == '5フロア以下' ? $select_nu_floor : ''; ?>>5<?php echo Yii::app()->controller->__trans('フロア以下'); ?></option>
                                                    <option value="6フロア以下" <?php echo isset($customerRequirement[0]['number_of_floor']) &&  $customerRequirement[0]['number_of_floor']  == '6フロア以下' ? $select_nu_floor : ''; ?>>6<?php echo Yii::app()->controller->__trans('フロア以下'); ?></option>
                                                    <option value="7フロア以下" <?php echo isset($customerRequirement[0]['number_of_floor']) &&  $customerRequirement[0]['number_of_floor']  == '7フロア以下' ? $select_nu_floor : ''; ?>>7<?php echo Yii::app()->controller->__trans('フロア以下'); ?></option>
                                                    <option value="8フロア以下" <?php echo isset($customerRequirement[0]['number_of_floor']) &&  $customerRequirement[0]['number_of_floor']  == '8フロア以下' ? $select_nu_floor : ''; ?>>8<?php echo Yii::app()->controller->__trans('フロア以下'); ?></option>
                                                    <option value="9フロア以下" <?php echo isset($customerRequirement[0]['number_of_floor']) &&  $customerRequirement[0]['number_of_floor']  == '9フロア以下' ? $select_nu_floor : ''; ?>>9<?php echo Yii::app()->controller->__trans('フロア以下'); ?></option>
                                                </select>
                                                &nbsp; <?php echo Yii::app()->controller->__trans('の構成'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Estimated sales amount'); ?></th>
                                            <td>
                                            	<input type="text" name="est_sale_amt" value="<?php if(isset($customerRequirement[0]['estimated_sales_amount']) && $customerRequirement[0]['estimated_sales_amount']!= ''){echo $customerRequirement[0]['estimated_sales_amount'] ;} ?>" class="ty1"><?php echo Yii::app()->controller->__trans('円'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Estimated sales date'); ?></th>
                                            <td>
                                            	<select name="est_sale_date">
                                                	<option value="未定"><?php echo Yii::app()->controller->__trans('未定'); ?></option>
                                                    <?php
														for($i = 120; $i >= 0; --$i){
															$time = strtotime(sprintf('-%d months', $i));
															$value = date('Y-m', strtotime("+24 month",$time));
															$label = date('Y年m月', strtotime("+24 month",$time));
															if(isset($customerRequirement[0]['estimated_sales_date']) && $customerRequirement[0]['estimated_sales_date']!= ''){
																$year_month= explode('-',$customerRequirement[0]['estimated_sales_date']);
																if($value == $year_month[0].'-'.$year_month[1]){
																	$select_dat = 'selected';
																}
															}
															printf('<option value="%s"'.$select_dat.'>%s</option>', $value, $label);
														}
													?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('comments'); ?></th>
                                            <td>
                                            	<?php
													$cComment = '';
                                                	if(isset($customerRequirement[0]['comments']) && $customerRequirement[0]['comments']!= ''){
														$cComment = $customerRequirement[0]['comments'];
													}
												?>
                                            	<textarea name="comments" class="txta3"><?php echo $cComment; ?></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-wrapper">
                    	<div class="formbox f-l">
                        	<div class="table-inner">
                            	<table class="edit_input ei_tyc">
                                	<tbody>
                                    	<tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Current rent unit price per tsubo'); ?></th>
                                            <td class="w">
                                            	<select name="crrnt_rent_unit_price" id="crrnt_rent_unit_price" data-role="none">
                                                	<option value="" selected="">-</option>
													<?php
                                                    	for($i=0.5;$i<5.0;$i=$i+0.1){
															$select_tsubo_low = '';
															if(isset($customerRequirement[0]['current_rent_unit_price_per_tsubo']) &&  $customerRequirement[0]['current_rent_unit_price_per_tsubo']!= ''){
																if(number_format($i,1,'.','') == $customerRequirement[0]['current_rent_unit_price_per_tsubo']){
																	$select_tsubo_low = 'selected';
																}
															}
													?>
                                                    <option value="<?php echo number_format($i,1,'.',''); ?>"<?php echo $select_tsubo_low; ?>><?php echo number_format($i,1,'.',''); ?></option>
													<?php
                                                    	}
													?>
                                                </select>
                                                &nbsp;<?php echo Yii::app()->controller->__trans('万'); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="formbox f-1">
                        	<div class="table-inner">
                            	<table class="edit_input ei_tyc">
                                	<tbody>
                                    	<tr>
                                        	<th scope="row"><?php echo Yii::app()->controller->__trans('Current number of tsubo'); ?></th>
                                            <td class="w">
                                            	<select name="crrnt_no_of_tusbo" id="crrnt_no_of_tusbo" data-role="none">
                                                	<option value="">-</option>
													<?php
                                                    	for($i=1;$i<=3000;$i++){
															$crrnt_no_of_tusbo = '';
															if(isset($customerRequirement[0]['current_number_of_tsubo']) &&  $customerRequirement[0]['current_number_of_tsubo']!= ''){
																if(number_format($i,1,'.','') == $customerRequirement[0]['current_number_of_tsubo']){
																	$crrnt_no_of_tusbo = 'selected';
																}
															}
													?>
                                                    <option value="<?php echo $i; ?>" <?php echo $crrnt_no_of_tusbo; ?>><?php echo $i; ?></option>
                                                    <?php
                                                    	}
													?>
                                                </select>
                                                &nbsp;<?php echo Yii::app()->controller->__trans('坪'); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="bt_input_box">
                    	<div class="bt_input">
                        	<input type="button" id="btnUpdateCustomerReqInfo" class="bt_entry" value="<?php echo Yii::app()->controller->__trans('更新'); ?>">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
