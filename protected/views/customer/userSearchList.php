<?php
if(isset($newArray) && count($newArray) > 0 ){
	//$customerDetails = Customer::model()->findAllByAttributes(array('customer_id'=>$newArray));
}
?>
<div class="post">
	<div class="cl-list">
		<?php
        if(isset($newArray) && count($newArray) > 0 ){
			foreach($newArray as $nCustomer){
				$select = Customer::model()->findByPk($nCustomer);
				$customerReqDetails = CustomerRequirement::model()->find('customer_id = '.$select['customer_id']);
				$buisnessTypeDetails = BusinessType::model()->find('business_type_id = '.$select['business_type_id']);
		?>
        <div class="list-item">
        	<div class="company_name clearfix">
        		<span onClick="viewFullDetails('<?php echo Yii::app()->createUrl('customer/fullDetail',array('id'=>$select['customer_id'])); ?>')" class="clickable client-name">
					<?php
                    if(isset($select['company_name']) && $select['company_name'] != ''){
						echo $select['company_name'];
					}
					?>
                </span>
                <?php /*?><span class="name_pich">
					<?php echo Yii::app()->controller->__trans('Person in charge'); ?>:
					<?php
                    if(isset($select['person_incharge_name']) && $select['person_incharge_name'] != ''){ 
						echo $select['person_incharge_name'];
					}
					?>
                </span><?php */?>
                <span class="cus_saler">担当：<?php
                            if(isset($select['sales_staff_id']) && $select['sales_staff_id'] != ''){
								$userDetails = AdminDetails::model()->find('user_id = '.$select['sales_staff_id']);
								echo $userDetails['full_name'];
							}
							?></span>
            </div>
            <div class="customer-result-table clearfix">
            <div class="col_8">
            	<div class="customer-detail">
                <label><?php echo Yii::app()->controller->__trans('address'); ?></label>
                            <p>
								<?php
                                if(isset($select['postal_code']) && $select['postal_code'] != ""){
									echo '〒 '.$select['postal_code']." ".$select['address'];
								}else{
									echo $select['address'];
								}
								?>
                            </p>
                            </div>
                
                 <div class="customer-detail">
				<label><?php echo Yii::app()->controller->__trans('ideal conditions'); ?></label>
                   <p>
						<?php
                        if(isset($customerReqDetails['area_group']) && $customerReqDetails['area_group'] == 1){
							echo Yii::app()->controller->__trans('エリアA（千代田／中央／港／新宿／渋谷）');
						}elseif(isset($customerReqDetails['area_group']) && $customerReqDetails['area_group'] == 2){
							echo Yii::app()->controller->__trans('エリアB（品川／豊島／文京／台東／目黒）');
						}elseif(isset($customerReqDetails['area_group']) && $customerReqDetails['area_group'] == 3){
							echo Yii::app()->controller->__trans('エリアC（中野／世田谷／江東）');
						}else{
							echo '';
						}
						?>
                        <?php
						if(isset($customerReqDetails['floor_space_min']) && $customerReqDetails['floor_space_min'] != ""){
							echo ' | '.$customerReqDetails['floor_space_min']." 坪";
						}
						elseif(isset($customerReqDetails['floor_space_max']) && $customerReqDetails['floor_space_max'] != "" && $customerReqDetails['floor_space_max'] != 0){
							if($customerReqDetails['floor_space_min'] != ""){
								echo " ~ ".$customerReqDetails['floor_space_max']." 坪";
							}else{
								echo ' | '.$customerReqDetails['floor_space_max']." 坪";
							}
						}
						
						
						?>
                        </p>
                </div>
                   
                   <div class="customer-detail">
				<label><?php echo Yii::app()->controller->__trans('customer note'); ?></label>
               <p>
						<?php
                        if(isset($select['note']) && $select['note'] != ""){
							echo $select['note'];
						}else{
							echo '-';
						}
						?>
                         </p>
                </div>
                </div><!--/col_8-->
                <div class="col_2">
                <div class="customer-detail">
				<label><?php echo Yii::app()->controller->__trans('registered date'); ?></label>
                <p>
                        	<time pubdate="pubdate">
								<?php
                                if(isset($select['company_reg_date']) && $select['company_reg_date'] != ''){
									echo $select['company_reg_date'];
								}
								?>
                            </time>
                        </p>
                </div>
                <div class="customer-detail">
				<label><?php echo Yii::app()->controller->__trans('Sort of contact'); ?></label>
                <p>
						<?php
                        if(isset($select['reason_of_contact']) && $select['reason_of_contact'] != ''){
							echo $select['reason_of_contact'];
						}else{
							echo '-';
						}
						?>
                     </p>
                </div>
                <div class="customer-detail">
				<label><?php echo Yii::app()->controller->__trans('Sales expected amount'); ?></label>
                 <p>
						<?php
                        if(isset($customerReqDetails['estimated_sales_amount']) && $customerReqDetails['estimated_sales_amount'] != ""  && $customerReqDetails['estimated_sales_amount'] != 0){
							echo $customerReqDetails['estimated_sales_amount'].' 円';
						}else{
							echo '-';
						}
						?>
                        </p>
                </div>
                </div><!--/col_2-->
            </div>
        </div>
		<?php
        	}
		}
		if(empty($newArray)){
		?>
        <div class="no_result">
			<?php echo Yii::app()->controller->__trans('No Result Found.');?>
        </div>
		<?php
        }
		?>
    </div>
</div>