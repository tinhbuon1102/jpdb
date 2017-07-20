<div id="main" class="client-list">
	<div class="postbox">
    	<header class="m-title btnright">
        	<h1 class="main-title">
				<?php echo Yii::app()->controller->__trans('Customers List'); ?>
            </h1>
            <div class="add-action">
            	<a href="<?php echo Yii::app()->createUrl('customer/create'); ?>" class="addNewCustomer">
					<?php echo Yii::app()->controller->__trans('Add New Customer'); ?>
                </a>
            </div>
            <div class="add-action">
            	<a href="<?php echo Yii::app()->createUrl('customer/getCustomerCSV'); ?>" target="_blank">
					<?php echo Yii::app()->controller->__trans('CSV Export'); ?>
                </a>
            </div>
        </header>
        <div class="client-search-box">
        	<form method="post"  id="preview_form">
            	<div class="col-full">
                	<div class="RadioButton clearfix">
                    	<div class="searchform-param">
                        	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('Person in charge for customers'); ?></label>
                            <span class="searchform-input-wrapper">
                            	<div class="radio-button-wrapper">
								<?php
                                if(isset($saleStaffList) && $saleStaffList != ''){
									$i = 0;
									foreach($saleStaffList as $saleStaff){
										$check ='';
										if($i == 0 ){
											$check ='checked';
										}
								?>
                                	<input type="checkbox" name="personInChargeforCustomer[]" <?php echo $check; ?>  value="<?php echo $saleStaff['id']; ?>">
                                    <label ><?php echo $saleStaff['name']; ?></label>
								<?php
                                	$i++;
									}
								}
								?>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-left">
                	<div class="searchform-params">
                    	<div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('Company Name'); ?></label>
                                <span class="searchform-input-wrapper">
                                	<input name="companyName" value="">
                                </span>
                            </div>
                        </div>
                        <div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('Customer ID'); ?></label>
                                <span class="searchform-input-wrapper">
                                	<input name="customerId" value="">
                                </span>
                            </div>
                        </div>
                        <div class="TextField">
                        	<div class="searchform-param">
                            	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('Person In Charge'); ?></label>
                                <span class="searchform-input-wrapper">
                                	<input name="personInCharge" value="">
                                </span>
                            </div>
                        </div>
                        <div class="TextField">
                        	<div class="searchform-param branch">
                            	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('branch/department'); ?></label>
                                <span class="searchform-input-wrapper">
                                	<input name="departMent" value="">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-center">
                	<div class="TextField">
                    	<div class="searchform-param">
                        	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('TEL'); ?></label>
                            <span class="searchform-input-wrapper">
                            	<input name="tel" value="">
                            </span>
                        </div>
                    </div>
                    <div class="TextField">
                    	<div class="searchform-param">
                        	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('email'); ?></label>
                            <span class="searchform-input-wrapper">
                            	<input name="email" value="">
                            </span>
                        </div>
                    </div>
                    <div class="TextField">
                    	<div class="searchform-param">
                        	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('Register Date'); ?></label>
                            <span class="searchform-input-wrapper">
                            	<input type="text" name="registerDateFrom" id="registerDateFrom" class="registerDateFrom"/>〜 <input type="text" name="registerDateTo" id="registerDateTo" class="registerDateTo" />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-right">
                	<div class="TextField">
                    	<div class="searchform-param">
                        	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('required numbers of floor space'); ?></label>
                            <span class="searchform-input-wrapper select-numbers">
                            	<select name="floorSpaceMin" id="floorSpaceMin" data-role="none">
                                	<option value="">-</option>
									<?php
                                    for($i=1;$i<=3000;$i++){
									?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php
                                    }
									?>
                                </select>坪 ～
                                <select name="floorSpaceMax" id="floorSpaceMax" data-role="none">
                                	<option value="">-</option>
									<?php
                                    for($i=1;$i<=3000;$i++){
									?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php
                                    }
									?>
                                </select>坪
                            </span>
                        </div>
                    </div>
                    <div class="searchform-params">
                    	<div class="DropDownField">
                        	<div class="searchform-param">
                            	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('property sort'); ?></label>
                                <span class="searchform-input-wrapper">
                                	<select name="propertySort">
                                    	<option value="">-</option>
										<?php
                                        foreach($propertyType as $property){
										?>
                                        <option value="<?php echo $property['property_type_id']; ?>"><?php echo $property['property_type_name']; ?></option>
										<?php
                                        }
										?>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="DropDownField">
                        	<div class="searchform-param">
                            	<label class="searchform-label"><?php echo Yii::app()->controller->__trans('Customer Source'); ?></label>
                                <select name="customerSource">
                                	<option value="">-</option>
									<?php
                                    if(isset($customerSource) && $customerSource !=''){
										foreach($customerSource as $cst){
									?>
                                    <option value="<?php echo $cst['source_name']; ?>"><?php echo $cst['source_name']; ?></option>
									<?php
                                    	}
									}
									?>
                               	</select>
                                <span class="searchform-input-wrapper"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="searchform-controls">
                	<input type="button" name="search" value="検索" id="search-customer">
                    <div class="ajxLoader" style="display: none;">
                        <div class="loader1">
                            <?php echo Yii::app()->controller->__trans('Loading...'); ?>
                        </div>
                    </div>
                </div>
           	</form>
        </div>
        <div class="post customerList"></div>
    </div>
</div>

