<td class="summary_td">
	<table>
		<tr>
			<td class="build_name" colspan="2">
				<?php echo ($language == 'ja' ? $buildCart['name'] : $buildCart['name_en']); if($buildCart['bill_check']==0) echo "";?><span class="build_no"><?php echo Yii::app()->controller->__trans('No.'); ?><?php echo $buildCart['buildingId']; ?></span>
			</td>
		</tr>
		<tr>
			<td><?php echo Yii::app()->controller->__trans('所在地', 'ja'); ?></td>
			<td><?php  echo HelperFunctions::translateBuildingValue('address', $buildCart); ?></td>
						</tr>
						<tr>
							<td><?php echo Yii::app()->controller->__trans('利用可能駅', 'ja'); ?></td>
							<td>
                            <?php  echo HelperFunctions::translateBuildingValue('station_access', $buildCart); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo Yii::app()->controller->__trans('竣工年月', 'ja'); ?></td>
			<td><?php  echo HelperFunctions::translateBuildingValue('built_year', $buildCart); ?></td>
						</tr>
                        <tr>
                            <td><?php echo Yii::app()->controller->__trans('規模', 'ja'); ?></td>
                            <td>
                                <?php
                                    if(isset($buildCart['floor_scale']) && $buildCart['floor_scale'] != ""){
                                        $scaleExp = explode('-',$buildCart['floor_scale']);
                                        $floorGround = $scaleExp[0];
                                        $floorUnderGround = $scaleExp[1];
                                        if($floorGround != "" && $floorUnderGround != ""){
                                            echo $floorGround.'F/B'.$floorUnderGround;
                                        }else{
                                            if($floorGround != ""){
                                                echo $floorGround.'F';	
                                            }elseif($floorUnderGround != ""){
                                                echo 'B'.$floorUnderGround;
                                            }else{
                                                echo '';
                                            }
                                        }
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                        </tr>
						<tr>
							<td><?php echo Yii::app()->controller->__trans('基準階面積', 'ja'); ?></td>
							<td><?php echo $buildCart['std_floor_space'] != "" ? $buildCart['std_floor_space'].Yii::app()->controller->__trans('坪', 'ja') : "-"; ?></td>
		</tr>
	</table>
</td>