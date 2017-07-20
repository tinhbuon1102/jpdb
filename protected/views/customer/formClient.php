<div id="main" class="single-customer">
	<header class="m-title btnright">
    	<h1 class="main-title"><?php echo Yii::app()->controller->__trans('UPDATE CLIENT'); ?></h1>
    </header>
    <div class="form container">
    	<?php $form=$this->beginWidget('CActiveForm', array('id'=>'customer-form','enableAjaxValidation'=>false,)); ?>
        	<input type="hidden" name="updateCustomerInfo" id="updateCustomerInfo" value="<?php echo Yii::app()->createUrl('customer/saveCustomerUpdateInfo'); ?>" />
            <input type="hidden" name="updateCustomerId" id="updateCustomerId" value="<?php echo $model->customer_id; ?>" />
            <input type="hidden" name="is_update" id="is_update" value="1">
            <input type="hidden" name="type" id="type" value="1">
            <div class="nsales_box">
            	<div class="formbox f-l" style="width:100%;">
                	<div class="ttl_h3b">顧客情報</div>
                    <div class="table-inner">
                    	<table class="edit_input mt">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_company_name">
                                    <?php echo Yii::app()->controller->__trans('Company Name'); ?>
                                    <span class="required">*</span>
                                </label>
                            </th>
                            <td>
                            	<input type="text" name="Customer[company_name]" id="company_name" class="ty3" value="<?php echo isset($model->company_name) && $model->company_name != "" ? $model->company_name : "";  ?>" required/>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_company_name_kana">
                                    <?php echo Yii::app()->controller->__trans('Company Name Kana'); ?>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textField($model,'company_name_kana',array('size'=>60,'maxlength'=>255,'class'=>'ty3')); ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label" for="Customer_company_reg_date">
                                    <?php echo Yii::app()->controller->__trans('Company Reg Date'); ?>
                                </label>
                            </th>
                            <td>
                                <div id="sandbox-container">
                                    <?php echo $form->textField($model,'company_reg_date',array('class'=>'date ty3','value'=>date('Y-m-d'),'readonly'=>'readonly')); ?>
                                </div>
                            </td>
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
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="tb_label required" for="Customer_address">
                                    <?php echo Yii::app()->controller->__trans('Address'); ?>
                                </label>
                            </th>
                            <td>
                                <?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50,'class'=>'ty3')); ?>
                            </td>
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
                            <option value="">-</option>
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
                            <?php } ?>
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
                                <option value="">-</option>
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
                                    <select name="Customer[introducer_id]" id="Customer_introducer_id" class="dropIntroducer" style="width:auto;float:left;">
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
                                    <input type="hidden" name="Customer[introducer_id]" class="hdnIntroducer" value="0" style="display:none;" />
                                    <?php
									if(isset($model->introducer_id) && $model->introducer_id != 0){
									?>
                                    <a href="#" class="btn-primary btnRemoveIntroducer" id="btnRemoveIntroducer" style="width:auto; padding: 5px 25px; line-height:30px;">削除</a>
                                    <?php
									}
									?>
                                </div>
                            </td>
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
                <div class="row buttons bt_input_box">
                	<input class="btnUpdateCust" type="submit" name="yt0" value="登録">
                </div>
            </div>
       	<?php $this->endWidget(); ?>
    </div>
</div>