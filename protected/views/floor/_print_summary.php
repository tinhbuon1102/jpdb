<td class="summary_td">
	<table>
		<tr>
			<td class="build_name" colspan="2">
				<?php echo $buildCart['name']; if($buildCart['bill_check']==0) echo "";?><span class="build_no">No.<?php echo $buildCart['buildingId']; ?></span>
			</td>
		</tr>
		<tr>
			<td>所在地</td>
			<td><?php echo $buildCart['address']; ?></td>
						</tr>
						<tr>
							<td>利用可能駅</td>
							<td>
                            <?PHP
			$nearestSt = BuildingStation::model()->getNearestStations($buildCart['building_id']);
			if(isset($nearestSt) && count($nearestSt) > 0){
				$i = 0;
				foreach($nearestSt as $nStation){
					if($i == count($nearestSt)-1){
						$break = '';
					}else{
						$break = '<br/>';
					}
					if(isset($nStation['name']) && isset($nStation['time'])){
						echo $nStation['name'].' 駅 '.$nStation['time'].' 分'.$break;
					}
					$i++;
				}
			}
			?>
			</td>
		</tr>
		<tr>
			<td>竣工年月</td>
			<td><?php echo date('Y年 m月',strtotime($buildCart['built_year'])); ?></td>
						</tr>
                        <tr>
                            <td>規模</td>
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
							<td>基準階面積</td>
							<td><?php echo $buildCart['std_floor_space'] != "" ? $buildCart['std_floor_space'].' 坪' : "-"; ?></td>
		</tr>
	</table>
</td>