<?php
/* @var $this CustomerController */
/* @var $model Customer */
/* @var $form CActiveForm */
?>

<form action="" method="post" name="frmUpdateCustomerData" id="frmUpdateCustomerData" class="frmUpdateCustomerData">
<input type="hidden" name="updateCustomerInfo" id="updateCustomerInfo" value="<?php echo Yii::app()->createUrl('customer/saveCustomerUpdateInfo'); ?>" />
	<div class="nsales_box">
    	<div class="formbox f-l">
        	<div class="ttl_h3b"><?php echo Yii::app()->controller->__trans('Customer Info'); ?></div>
            <div class="table-inner">
                <table class="edit_input mt">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_company_name">
                                    <?php echo Yii::app()->controller->__trans('Company Name'); ?>
                                </label>
                            </th>
                            <td>
                            	<input type="text" name="customer['company_name']" class="ty3">
                                <?php echo $form->textField($model,'company_name',array('size'=>60,'maxlength'=>255,'class'=>'ty3','required'=>'required')); ?>
                            </td>
                            <?php echo $form->error($model,'company_name'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_company_name_kana">
                                    <?php echo Yii::app()->controller->__trans('Company Name Kana'); ?>
                                    <span class="required">*</span>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textField($model,'company_name_kana',array('size'=>60,'maxlength'=>255,'class'=>'ty3','required'=>'required')); ?>
                            </td>
                            <?php echo $form->error($model,'company_name_kana'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label" for="Customer_company_reg_date">
                                    <?php echo Yii::app()->controller->__trans('Company Reg Date'); ?>
                                </label>
                            </th>
                            <td>
                                <div id="sandbox-container">
                                    <?php echo $form->textField($model,'company_reg_date',array('class'=>'date','value'=>date('Y-m-d'),'readonly'=>'readonly')); ?>
                                </div>
                            </td>
                            <?php echo $form->error($model,'company_reg_date'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_president_name">
                                    <?php echo Yii::app()->controller->__trans('President Name'); ?>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textField($model,'president_name',array('size'=>60,'maxlength'=>255,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'president_name');?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_postal_code">
                                    <?php echo Yii::app()->controller->__trans('Postal Code'); ?>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textField($model,'postal_code',array('size'=>20,'maxlength'=>20,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'postal_code'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_address">
                                    <?php echo Yii::app()->controller->__trans('Address'); ?>
                                </label>
                            </th>
                            <td><?php echo $model->address; ?>
                                <?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'address'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_phone_no">
                                    <?php echo Yii::app()->controller->__trans('Phone No'); ?>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textField($model,'phone_no',array('size'=>30,'maxlength'=>30,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'phone_no'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_fax_no">
                                    <?php echo Yii::app()->controller->__trans('Fax No'); ?>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textField($model,'fax_no',array('size'=>30,'maxlength'=>30,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'fax_no'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_url">
                                    <?php echo Yii::app()->controller->__trans('Url'); ?>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'url'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_business_type_id">
                                    <?php echo Yii::app()->controller->__trans('Business Type'); ?>
                                </label>
                            </th>
                            <td>
                            <?php
                                if(isset($businessTypeDetails)){
                            ?>
                            <select name="Customer[business_type_id]" id="Customer_business_type_id">
                            <?php
                                foreach($businessTypeDetails as $bui){
                                    $selected = '';
                                    if($model->business_type_id == $bui->business_type_id){
                                        $selected = 'selected = "selected"';
                                    }
                            ?>
                                <option value="<?php echo $bui->business_type_id;?>" <?php echo $selected; ?>><?php echo $bui->business_name;?></option>
                            <?php
                                }
                            ?>
                            </select>
                            </td>
                            <?php echo $form->error($model,'business_type_id');} ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_number_of_emp">
                                    <?php echo Yii::app()->controller->__trans('Number Of Emp'); ?>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textField($model,'number_of_emp',array('size'=>60,'maxlength'=>255,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'number_of_emp'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_customer_source_id">
                                    <?php echo Yii::app()->controller->__trans('Customer Source'); ?>
                                </label>
                            </th>
                            <td>
                                <?php
                                if(isset($customerSource)){
                                ?>
                                <select name="Customer[customer_source_id]" id="Customer_customer_source_id">
                                <?php
                                    foreach($customerSource as $cus){
                                        $selected = '';
                                        if($model->customer_source_id == $cus->customer_source_id){
                                            $selected = 'selected = "selected"';
                                        }
                                ?>
                                    <option value="<?php echo $cus->customer_source_id;?>"<?php echo $selected; ?>><?php echo $cus->source_name;?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </td>
                            <?php 
                                echo $form->error($model,'customer_source_id');
                            }
                            ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_introducer_id">
                                    <?php echo Yii::app()->controller->__trans('Introducer'); ?>
                                </label>
                            </th>
                            <td>
                                <div class="error_msg"></div>
                                <input type="text" name="int_id" id="int_id" />
                                <button type="button" class="btnAddNewIntroducerCust" style="display:none;">Add</button>
                                <div class="ajxLoader" style="display:none;">
                                    <div class="loader">
                                        <?php echo Yii::app()->controller->__trans('Loading...'); ?>
                                    </div>
                                </div>
                                <button type="button" name="int_btn" id ="int_btn" style="margin-top: 10px;">
                                    <?php echo Yii::app()->controller->__trans('Search the client'); ?>
                                </button>
                                <div class="introducerResp" style="margin-top: 10px;">
                                <?php
                                if(isset($model->introducer_id) && $model->introducer_id != 0){
                                ?>
                                    <select name="Customer[introducer_id]" id="Customer_introducer_id">
                                    <?php
                                        foreach($introducer as $int){
                                            $selected = '';
                                            if($model->introducer_id == $int->introducer_id){
                                                $selected = 'selected = "selected"';
                                            }
                                    ?>
                                        <option  value="<?php echo $int->introducer_id;?>" <?php echo $selected; ?>><?php  echo $int->introducer_name;?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </td>
                            <?php echo $form->error($model,'introducer_id');  ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_note">
                                    <?php echo Yii::app()->controller->__trans('Note'); ?>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textArea($model,'note',array('rows'=>5, 'cols'=>50,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'note'); ?>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label" for="Customer_Source_Of_Contact">
                                    <?php echo Yii::app()->controller->__trans('Source  Of  Contact'); ?>
                                </label>
                            </th>
                            <td>
                            <?php $selected = 'selected = "selected"'; ?>
                            <select name="Customer[reasonToContact]" id="reasonToContact" data-role="none">
                                <option value="">-</option>
                                <option value="内見希望" <?php if($model['reason_of_contact'] == '内見希望') {echo $selected;} ?>>内見希望</option>
                                <option value="空き確認" <?php if($model['reason_of_contact'] == '空き確認') {echo $selected;} ?>>空き確認</option>
                                <option value="賃料条件確認" <?php if($model['reason_of_contact'] == '賃料条件確認') {echo $selected;} ?>>賃料条件確認</option>
                                <option value="物件資料" <?php if($model['reason_of_contact'] == '物件資料') {echo $selected;} ?>>物件資料</option>
                                <option value="ピックアップ希望" <?php if($model['reason_of_contact'] == 'ピックアップ希望') {echo $selected;} ?>>ピックアップ希望</option>
                                <option value="詳細情報の確認" <?php if($model['reason_of_contact'] == '詳細情報の確認') {echo $selected;} ?>>詳細情報の確認</option>
                                <option value="その他"  <?php if($model['reason_of_contact'] == 'その他') {echo $selected;} ?>>その他</option>
                            </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="formbox f-r">
        	<div class="ttl_h3b">
				<?php echo Yii::app()->controller->__trans('Person in charge Info'); ?>
            </div>
            <div class="table-inner">
            	<table class="edit_input mline">
                	<tbody>
                    	<tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_person_incharge_name">
									<?php echo Yii::app()->controller->__trans('Person Incharge Name'); ?>
                                </label>
                            </th>
                            <td>
								<?php echo $form->textField($model,'person_incharge_name',array('size'=>60,'maxlength'=>255,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'person_incharge_name'); ?>
                        </tr>
                        <tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_person_incharge_name_kana">
									<?php echo Yii::app()->controller->__trans('Person Incharge Name Kana'); ?>
                                </label>
                            </th>
                            <td>
								<?php echo $form->textField($model,'person_incharge_name_kana',array('size'=>60,'maxlength'=>255,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'person_incharge_name_kana'); ?>
                        </tr>
                      	<tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_position">
									<?php echo Yii::app()->controller->__trans('Position'); ?>
                                </label>
                            </th>
                            <td>
								<?php echo $form->textField($model,'position',array('size'=>60,'maxlength'=>255,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'position'); ?>
                        </tr>
                        <tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_branch_name">
									<?php echo Yii::app()->controller->__trans('Branch Name'); ?>
                                </label>
                            </th>
                            <td>
								<?php echo $form->textField($model,'branch_name',array('size'=>60,'maxlength'=>255,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'branch_name'); ?>
                        </tr>
                        <tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_person_phone_no">
									<?php echo Yii::app()->controller->__trans('Person Phone No'); ?>
                                </label>
                            </th>
                            <td>
								<?php echo $form->textField($model,'person_phone_no',array('size'=>30,'maxlength'=>30,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'person_phone_no'); ?>
                        </tr>
                        <tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_person_fax_no">
									<?php echo Yii::app()->controller->__trans('Person Fax No'); ?>
                                </label>
                            </th>
                            <td>
								<?php echo $form->textField($model,'person_fax_no',array('size'=>30,'maxlength'=>30,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'person_fax_no'); ?>
                        </tr>
                       	<tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_cellphone_no">
									<?php echo Yii::app()->controller->__trans('Cellphone No'); ?>
                                </label>
                            </th>
                            <td>
								<?php echo $form->textField($model,'cellphone_no',array('size'=>20,'maxlength'=>20,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'cellphone_no'); ?>
                        </tr>
                        <tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_email">
									<?php echo Yii::app()->controller->__trans('Email'); ?>
                                </label>
                            </th>
                            <td>
								<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'email'); ?>
                        </tr>
                        <tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_department">
									<?php echo Yii::app()->controller->__trans('Department'); ?>
                                </label>
                            </th>
                            <td>
								<?php echo $form->textField($model,'department',array('size'=>60,'maxlength'=>255,'class'=>'ty3')); ?>
                            </td>
                            <?php echo $form->error($model,'department'); ?>
                        </tr>
                        <tr>
                        	<th scope="row">
                            	<label class="tb_label required" for="Customer_sales_staff_id">
									<?php echo Yii::app()->controller->__trans('Sales Staff'); ?>
                                </label>
                            </th>
                            <td>
                            	<select name="Customer[sales_staff_id]" id="Customer_sales_staff_id">
                                <?php
                                foreach($userAdmin as $uadmin){
									$selected = '';
									if($model->sales_staff_id == $uadmin->user_id){
										$selected = 'selected = "selected"';
									}
								?>
                                <option value="<?php  echo $uadmin->user_id;?>" <?php echo $selected; ?>><?php echo $uadmin->username;?></option>
                                <?php
                                }
								?>
                                </select>
                            </td>
                            <?php echo $form->error($model,'sales_staff_id'); ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row buttons bt_input_box">
        	<input class="bt_entry btnUpdateCust" type="submit" name="yt0" value="<?php echo Yii::app()->controller->__trans('Create'); ?>">
        </div> 
		</form>
    </div>
</div>