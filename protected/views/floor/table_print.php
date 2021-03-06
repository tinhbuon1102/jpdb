  

   <table class="b_data b_data_new">
   	         <?php
                 $managementArray = array('1'=>'オーナー','6'=>'サブリース','7'=>'貸主代理','8'=>Yii::app()->controller->__trans('AM'),'10'=>'業者','4'=>'仲介業者','2'=>'管理会社','9'=>Yii::app()->controller->__trans('PM'),													'3'=>'ゼネコン','-1'=>'不明',);

   	         ?>
		  <tbody>
			  <tr>
				  <td class="trader_type window_type" colspan="4"><?php echo Yii::app()->controller->__trans('Window'); ?></td>
			  </tr>
			  <?php
			    $floor_id = 0;
			    if(!empty($floorDetails_allfloor['windows_trader_id'] )){
			    	foreach ($floorDetails_allfloor['windows_trader_id'] as $trader) {
			    	 $owner = OwnershipManagement::model()->find('ownership_management_id='.$trader);
			    	   $floor_id = $owner['floor_id'];
			    		?>
                            <tr>
							  <td class="bo_name"><span class="owner_type"><?=  $managementArray[$owner['ownership_type']] ?></span><?=  $owner['owner_company_name'] ?></td>
							  <td class="bo_tel1"><?=  $owner['company_tel'] ?></td>
							  <td class="bo_fee"><?=  $owner['charge'] ?></td>
							  <td class="bo_upd">更新日：<?=  date('y-m-d', strtotime($owner['modified_on'])) ?></td>
						  	</tr>

			    		<?php
			    	}
			    }
			  ?>
			  
			  <tr>
				  <td class="trader_type owner_type" colspan="4"><?php echo Yii::app()->controller->__trans('Owner'); ?></td>
			  </tr>
			    <?php
			    if(!empty($floorDetails_allfloor['owner_trader_id'] )){
			    	foreach ($floorDetails_allfloor['owner_trader_id'] as $trader) {
			    	 $owner = OwnershipManagement::model()->find('ownership_management_id='.$trader);
			    	  $floor_id = $owner['floor_id'];
			    		?>
                            <tr>
							  <td class="bo_name"><span class="owner_type"><?=  $managementArray[$owner['ownership_type']] ?></span><?=  $owner['owner_company_name'] ?></td>
							  <td class="bo_tel1"><?=  $owner['company_tel'] ?></td>
							  <td class="bo_fee"><?=  $owner['charge'] ?></td>
							  <td class="bo_upd">更新日：<?=  date('y-m-d', strtotime($owner['modified_on'])) ?></td>
						  	</tr>

			    		<?php
			    	}
			    }
			  ?>
		  </tbody>
	  </table>
	  <!--/20171129 added-->

	   <!--start to show window history-->
	   <?php 
	   if($floor_id != 0){
	   	$win_his = OwnershipManagementHis::model()->findAll('floor_id='.$floor_id.' AND is_current = 1');
	   }
	   if(!empty($win_his)){
	   ?>
	  <table class="b_data b_data_history window_history">
		  <tbody>
			  <tr>
				  <th class="bdata_title" colspan="4"><?php echo Yii::app()->controller->__trans('窓口履歴'); ?></th>
			  </tr>
			  <!--show latest 5 histories-->
			  <?php
                  	$count=1;
                  	$trader_id=array();
                  	foreach ($win_his as $owner) {
                  		if($count > 5){
                           break;
                  		}
                  		if(in_array($owner['trader_id'], $trader_id)){
                  			continue;
                  		}
                  		$trader_id[]=$owner['trader_id'];
                     ?>
                         <tr>
							  <th class="bo_name"><span class="owner_type "><?=  $managementArray[$owner['ownership_type']] ?></span><!--owner type--><?=  $owner['owner_company_name'] ?></th>
							  <th class="bo_tel1"><?= $owner['company_tel'] ?></th>
							  <th class="bo_fee"<?=  $owner['charge'] ?></th>
							  <th class="bo_upd"><?=  date('y-m-d', strtotime($owner['modified_on'])) ?></th>
						  </tr>

                     <?php
                     $count++;
                  	}
			 	 ?>
		  </tbody>
	  </table>
	  <?php }?>
	  <!--end of showing window history-->
	  <!--start to show owner history-->
	  <?php 
	  if($floor_id != 0){
	  	$owner_his = OwnershipManagementHis::model()->findAll('floor_id='.$floor_id.' AND is_current = 0 limit 1');
	  }
	  
	  if(!empty($owner_his)){
	  ?>
	  <table class="b_data b_data_history owner_history">
		  <tbody>
			  <tr>
				  <th class="bdata_title" colspan="4"><?php echo Yii::app()->controller->__trans('オーナー履歴'); ?></th>
			  </tr>
			    <?php
                  if($floor_id != 0){
                    $owner_his = OwnershipManagementHis::model()->findAll('floor_id='.$floor_id.' AND is_current = 0 limit 1');
                  }
                  	foreach ($owner_his as $owner) {
                     ?>
                         <tr>
							  <th class="bo_name"><span class="owner_type "><?=  $managementArray[$owner['ownership_type']] ?></span><!--owner type--><?=  $owner['owner_company_name'] ?></th>
							  <th class="bo_tel1"><?= $owner['company_tel'] ?></th>
							  <th class="bo_fee"<?=  $owner['charge'] ?></th>
							  <th class="bo_upd"><?=  date('y-m-d', strtotime($owner['modified_on'])) ?></th>
						  </tr>

                     <?php
                     
                  	}
			    ?>
		  </tbody>
	  </table>
	  <?php }?>
	  <!--end of showing owner history-->


    <!--floor info-->
    <table class="f_info">
      <tbody>
        <?php
			$floorDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id']. $glob_where );
			$floorDetailsTmp = $floorDetails;
			foreach($floorDetailsTmp as $floorKey => $floor){
				if(!in_array($floor['floor_id'],$proposedFloors)){
					unset($floorDetails[$floorKey]);
				}
			}
// 							for ($i=0; $i<20; $i++) {
// 								$floorDetails[] = $floorDetails[0];
// 							}
				
			$countFloor = 0;
			foreach($floorDetails_allfloor['info'] as $floor){
				//echo $floor['floor_id'];
				
				$floorId = Floor::model()->findByPk($floor['floor_id']);
//				if($countFloor % 12 == 0 || ($countFloor < 12 && $count2RowAbove < 28 && $countFloor == ceil(28 - $count2RowAbove)/3)) {
//					$countFloor = 12;
//					echo '</tbody></table></section></div>';
//					echo '<div class="sheet_wrapper"><section class="sheet commercial"><table class="f_info"><tbody>';
//				}
		?>
        <!--if multiple floors,loop-->
        <tr style="border-bottom:1px solid #fff;">
          <td class="f_emp" style="width:45px;"><span><?php echo !$floorId['vacancy_info'] ? '*' : '' ?></span><span style=""><?php echo $floorId['floorId']; ?></span></td>
          <!--floor ID-->
          <td class="f_floor_str" style="width:30px;"><?php
            if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
				if(strpos($floorId['floor_down'], '-') !== false){
					$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
				}else{
					$floorDown = $floorId['floor_down'];
				}
				if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
					echo $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
				}else{
					echo $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
				}
			}
			if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
				echo ''.$floorId['roomname'];
			}
		?></td>
          <!--stair of the floor-->
          <td class="f_acreg_str" style="width:42px;">
          <?php
			if(isset($floorId['area_ping']) && $floorId['area_ping'] != ""){
				echo $floorId['area_ping']." ".Yii::app()->controller->__trans('坪', 'ja');
			}else{
				echo '-';
			}
		 ?></td>
          <!--area space of the floor-->
          <td class="f_rentstart" style="width:50px;">
          
          <?php
			
          	echo HelperFunctions::translateBuildingValue('move_in_date', $buildCart, $floorId);
          
			if(isset($floorId['preceding_user']) && $floorId['preceding_user'] != 0){
			echo '<span>('.Yii::app()->controller->__trans('先行有', 'ja').')</span>';
			}
			?></td>
          <!--date to rent start for the floor-->
          <td class="f_price_m_shiki" style="width:45px;"><?php echo Yii::app()->controller->__trans('敷', 'ja'); ?>
            <?php
				/*if(isset($floorId['total_deposit']) && $floorId['total_deposit'] != "0" && $floorId['total_deposit'] != ""){
					echo Yii::app()->controller->renderPrice($floorId['total_deposit']).' 円';
				}*/
				if($floorId['deposit_opt'] != ''){
					echo '';
					if($floorId['deposit_opt'] == -1){
						echo Yii::app()->controller->__trans('未定', 'ja');
					}else if($floorId['deposit_opt'] == -3){
						echo Yii::app()->controller->__trans('無', 'ja');
					}else if($floorId['deposit_opt'] == -2){
						echo Yii::app()->controller->__trans('相談', 'ja');
					}
				}
				if(isset($floorId['deposit_month']) &&  $floorId['deposit_month'] != ''){
					echo ''.$floorId['deposit_month'].Yii::app()->controller->__trans('ヶ月', 'ja');
				}
			?>
            
            <?php
// 				if(isset($floorId['deposit']) && $floorId['deposit'] != "" && $floorId['deposit'] != 0){
// 					echo Yii::app()->controller->renderPrice($floorId['deposit']).Yii::app()->controller->__trans('yen / tsubo');
// 				}else{
// 					echo '';
// 				}
			?></td>
          <!--deposit fee of the floor-->
          <td class="f_price_t_rent" style="width:50px;">
          <?php
				if($floorId['rent_unit_price_opt'] != ''){
					if($floorId['rent_unit_price_opt'] == -1){
						echo Yii::app()->controller->__trans('未定', 'ja');
					}else if($floorId['rent_unit_price_opt'] == -2){
						echo Yii::app()->controller->__trans('相談', 'ja');
					}
				}else{
					echo '-';
				}
			?>
            <?php
				if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
					echo Yii::app()->controller->renderPrice($floorId['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo');
				}else{
					echo '';
				}
			?></td>
          <!--rent fee per 1 tsubo of the floor-->
          <td class="f_price_a_rent" style="width:60px;"><?php echo $floorId['total_rent_price'] ? Yii::app()->controller->renderPrice($floorId['total_rent_price']).'円' : ''; ?></td>
          <!--total rent fee of the floor-->
          <td class="f_price_rerent" style="width:55px;"><?php echo Yii::app()->controller->__trans('更', 'ja');?>
            <?php 
            if(isset($floorId['renewal_fee_opt']) && $floorId['renewal_fee_opt'] != ""){
            	if($floorId['renewal_fee_opt'] == 2){
            		echo Yii::app()->controller->__trans('無', 'ja');
            	}elseif($floorId['renewal_fee_opt'] == -1){
            		echo Yii::app()->controller->__trans('不明', 'ja');
            	}elseif($floorId['renewal_fee_opt'] == -2){
            		echo Yii::app()->controller->__trans('未定･相談', 'ja');
            	}else{
            		echo '';
            	}
            }
            
            if(isset($floorId['renewal_fee_reason']) && $floorId['renewal_fee_reason'] != ""){
            	if($floorId['renewal_fee_reason'] == 1){
            		echo Yii::app()->controller->__trans('現賃料の', 'ja');
            	}elseif($floorId['renewal_fee_reason'] == 2){
            		echo Yii::app()->controller->__trans('新賃料の', 'ja');
            	}else{
            		echo '';
            	}
            }
            
            if(isset($floorId['renewal_fee_recent']) && $floorId['renewal_fee_recent'] != ""){
            	echo $floorId['renewal_fee_recent'].Yii::app()->controller->__trans('ヶ月', 'ja');
            }
            ?></td>
          <!--renewal fee-->
          <td class="f_price_amo_str" style="width:50px;"><?php echo Yii::app()->controller->__trans('償', 'ja');?>
            <?php
				if(isset($floorId['repayment_opt']) && $floorId['repayment_opt'] != ""){
					if($floorId['repayment_opt'] == -3){
						echo Yii::app()->controller->__trans('無', 'ja');
					}elseif($floorId['repayment_opt'] == -4){
						echo Yii::app()->controller->__trans('不明', 'ja');
					}elseif($floorId['repayment_opt'] == -1){
						echo Yii::app()->controller->__trans('未定', 'ja');
					}elseif($floorId['repayment_opt'] == -2){
						echo Yii::app()->controller->__trans('相談', 'ja');
					}elseif($floorId['repayment_opt'] == -5){
						echo Yii::app()->controller->__trans('Sliding');
					}else{
						echo '';
					}
				}
				
				if(isset($floorId['repayment_reason']) && $floorId['repayment_reason'] != ""){
					if($floorId['repayment_reason'] == 1){
						echo Yii::app()->controller->__trans('現賃料の', 'ja');
					}elseif($floorId['repayment_reason'] == 2){
						echo Yii::app()->controller->__trans('解約時賃料の', 'ja');
					}else{
						echo '';
					}
				}
				
				if(isset($floorId['repayment_amt']) && $floorId['repayment_amt'] != ""){
					echo Yii::app()->controller->renderPrice($floorId['repayment_amt']);
				}
				if(isset($floorId['repayment_amt_opt']) && $floorId['repayment_amt_opt'] != ""){
					if($floorId['repayment_amt_opt'] == 1){
						echo Yii::app()->controller->__trans('ヶ月', 'ja');
					}elseif($floorId['repayment_amt_opt'] == 2){
						echo Yii::app()->controller->__trans('%');
					}else{
						echo '';
					}
				}
				?></td>
          <!--repayment-->
          <td class="f_price_keymoney_str" style="width:40px;">礼
            <?php
				if(isset($floorId['key_money_opt']) && $floorId['key_money_opt'] != ""){
					if($floorId['key_money_opt'] == 2){
						echo Yii::app()->controller->__trans('無', 'ja');
					}elseif($floorId['key_money_opt'] == -1){
						echo Yii::app()->controller->__trans('不明', 'ja');
					}elseif($floorId['key_money_opt'] == -2){
						echo Yii::app()->controller->__trans('未定･相談', 'ja');
					}else{
						echo '';
					}
				}else{
					echo '';
				}
				
				if(isset($floorId['key_money_month']) && $floorId['key_money_month'] != ""){
					echo $floorId['key_money_month'].Yii::app()->controller->__trans('ヶ月', 'ja');
				}
				?></td>
          <!--key money-->
          <td class="f_oa" style="width:30px;">
          <?php
				if($floorId['oa_type'] == '非対応'){
					echo 'OA '.Yii::app()->controller->__trans('無', 'ja');
				}else if($floorId['oa_type'] == 'フリーアクセス'){
					echo 'OA '.Yii::app()->controller->__trans('有', 'ja');
				}else if($floorId['oa_type'] == '1WAY'){
					echo 'OA '.Yii::app()->controller->__trans('無', 'ja');
				}else if($floorId['oa_type'] == '2WAY'){
					echo 'OA '.Yii::app()->controller->__trans('無', 'ja');
				}else if($floorId['oa_type'] == '3WAY'){
					echo 'OA '.Yii::app()->controller->__trans('無', 'ja');
				}else if($floorId['oa_type'] == '引き込み可'){
					echo 'OA '.Yii::app()->controller->__trans('無', 'ja');
				}else{
					echo '-';
				}
		 ?></td>
          <!--OA-->
          <td class="f_height" style="width:45px;">
          <?php
          if(isset($floorId['contract_period_opt']) && $floorId['contract_period_opt'] != ""){
          	if($floorId['contract_period_opt'] == 1){
          		echo Yii::app()->controller->__trans('普通借家', 'ja');
          	}elseif($floorId['contract_period_opt'] == 2){
          		echo Yii::app()->controller->__trans('定借', 'ja');
          	}elseif($floorId['contract_period_opt'] == 3){
          		echo Yii::app()->controller->__trans('定借希望', 'ja');
          	}else{
          		echo Yii::app()->controller->__trans('', 'ja');
          	}
          }else{
          	echo '-';
          }
          
          if(isset($floorId['contract_period_optchk']) && $floorId['contract_period_optchk'] == 1){
          	echo '：'.Yii::app()->controller->__trans('年数相談', 'ja');
          }
          
          if(isset($floorId['contract_period_duration']) && $floorId['contract_period_duration'] != ''){
          	echo '：'.$floorId['contract_period_duration'].Yii::app()->controller->__trans('年', 'ja');
          }
          ?>
          </td>
          <!--type of contract-->
          <?php
			$floorTypeUseArray = array();
			$floorTypeUse = $floorId['type_of_use'];
			$floorTypeUseArray = explode(',',$floorTypeUse);
		  ?>
          <td class="f_purpose1" style="width:20px;"><?php
							$opt1Val = '×事';
							if(in_array('1',$floorTypeUseArray)){
								$opt1Val = '○事';
							}
							echo $opt1Val;
							?></td>
          <!--use for office-->
          <td class="f_purpose2" style="width:20px;"><?php
							$opt1Val = '×店';
							if(in_array('2',$floorTypeUseArray)){
								$opt1Val = '○店';
							}
							echo $opt1Val;
							?></td>
          <!--use for shop-->
          <td class="f_purpose4" style="width:20px;"><?php
							$opt2Val = '×倉';
							if(in_array('5',$floorTypeUseArray)){
								$opt2Val = '○倉';
							}
							echo $opt2Val;
							?></td>
          <!--use for warehouse-->
          <td class="f_purpose8" style="width:20px;"><?php
							$opt3Val = '×他';
							$otherArray = array();
							$useOfType = UseTypes::model()->findAll('is_active = 1');
							foreach($useOfType as $uType){
								if($uType['user_type_id'] == '1' || $uType['user_type_id'] == '2' || $uType['user_type_id'] == '5'){
									continue;
								}else{
									$otherArray[] = $uType['user_type_id'];
								}
							}
							$intersect = array_intersect($floorTypeUseArray,$otherArray);
							
							if(!empty($intersect)){
								$opt3Val = '○他';
							}
							echo $opt3Val;
							?></td>
          <!--use for other--> 
        </tr>
        <?php
           $countFloor++;
			}
		?>
      </tbody>
    </table>