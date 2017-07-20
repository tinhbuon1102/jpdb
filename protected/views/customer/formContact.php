<div id="main" class="single-customer">
	<header class="m-title btnright">
    	<h1 class="main-title"><?php echo Yii::app()->controller->__trans('UPDATE CONTACT'); ?></h1>
    </header>
    <div class="form container">
    	<?php $form=$this->beginWidget('CActiveForm', array('id'=>'customer-form','enableAjaxValidation'=>false,)); ?>
        	<input type="hidden" name="updateCustomerInfo" id="updateCustomerInfo" value="<?php echo Yii::app()->createUrl('customer/saveCustomerUpdateInfo'); ?>" />
            <input type="hidden" name="updateCustomerId" id="updateCustomerId" value="<?php echo $model->customer_id; ?>" />
            <input type="hidden" name="is_update" id="is_update" value="1">
            <input type="hidden" name="type" id="type" value="2">
            <div class="nsales_box">
                <div class="formbox f-r" style="width:100%;">
                    <div class="ttl_h3b">担当者情報</div>
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
								$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
								$logged_user_id = $user->user_id;								
                                foreach($userAdmin as $uadmin){
									$salesDetails = AdminDetails::model()->find('user_id = '.$uadmin['user_id']);
									$selected = '';
									if(isset($model->sales_staff_id) && $model->sales_staff_id != 0){
										if($model->sales_staff_id == $salesDetails['user_id']){
											$selected = 'selected = "selected"';
										}
									}else{
										if($logged_user_id == $salesDetails['user_id']){
											$selected = 'selected = "selected"';
										}
									}
								?>
                                <option value="<?php  echo $salesDetails['user_id'];?>" <?php echo $selected; ?>><?php echo $salesDetails['full_name'];?></option>
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
                    <input class="btnUpdateCust" type="submit" name="yt0" value="登録">
                </div>
            </div>
        <?php $this->endWidget(); ?>
   	</div>
</div>