<?php
$prefactureId = '';
$prefactureList = Prefecture::model()->findAll();
echo "-------- Prefeacture --------<br/>";
$i = 1;
foreach($prefactureList as $prefacture){
	$code = $prefacture->code;
	if($code != 13){
		continue;
	}
	if(strlen($code) == 1){
		$code = '0'.$code;
	}
	
	echo "Prefecture = ".$i.' - '.$prefacture->prefecture_name." and Code = ".$code."<br/>";
	
	$districtList = District::model()->findAll('prefecture_id = "'.$code.'"');
	if(count($districtList) > 0){
		echo "<<<<<<<<<<<<<<<<<<<<<<<----- District ----->>>>>>>>>>>>>>>>>>>>>>>><br/>";
		$j = 1;
		foreach($districtList as $district){
			$dCode = $district->code;
			echo "District = ".$j.' - '.$district->district_name." and Code = ".$dCode."<br/>";
			
			$townList = Town::model()->findAll('district_id = "'.$dCode.'"');
			if(count($townList) > 0){
				echo "<<<<<<<<<<<<<<<<<<<<<<<----- Town ----->>>>>>>>>>>>>>>>>>>>>>>><br/>";
				$k = 1;
				foreach($townList as $town){
					$tCode = $town->code;
					echo "Town = ".$k.' - '.$town->town_name." and Code = ".$tCode."<br/>";
					
					/******************** calc avarage between 50 to 100 ****************/
					$vacancyRate50to100 = Building::model()->findAll('address Like "%'.$town->town_name.'%" AND (std_floor_space BETWEEN 50 AND 100 OR std_floor_space = "")');
					
					$building50to100 = array();
					foreach($vacancyRate50to100 as $buildingDetails){
						if($buildingDetails['std_floor_space'] == ""){
							$checkEmptyBuildingSpace = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
							$arrayFloor50To100 = array();
							foreach($checkEmptyBuildingSpace as $floor){
								$arrayFloor50To100[] = $floor['area_ping'];
							}
							if(count($arrayFloor50To100) > 0){
								if(max($arrayFloor50To100) > 50 && max($arrayFloor50To100) < 100){
									$building50to100[] = $buildingDetails['building_id'];
								}
							}
						}else{
							$building50to100[] = $buildingDetails['building_id'];
						}
					}
					$floor50to100 = array();
					$wantedFloor50to100 = array();
					
					$totalOfVacantFloor50to100  = '';
					$totalFloors50to100  = '';
					foreach($building50to100 as $building){
						$floorDetails = Floor::model()->findAll('building_id = '.$building);
						foreach($floorDetails as $floor){
							if($floor['vacancy_info'] == 1 && $floor['move_in_date'] == '即'){
								$wantedFloor50to100[] = $floor['floor_id'];
								$totalOfVacantFloor50to100 += $floor['area_ping'];
							}
							$floor50to100[] = $floor;
							$totalFloors50to100 += $floor['area_ping'];
						}
					}
					
					$flootAvarageRent50to100 = array();
					$flootRent50to100 = array();
					foreach($floor50to100 as $floor){
						if($floor['rent_unit_price'] != "" && $floor['unit_condo_fee'] != ""){
							$flootAvarageRent50to100[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
						}elseif($floor['rent_unit_price'] != "" && $floor['unit_condo_fee_opt'] == "-3"){
							$flootAvarageRent50to100[] = $floor['rent_unit_price'];
						}
						if($floor['rent_unit_price'] != ""){
							$flootRent50to100[] = $floor['rent_unit_price'];
						}
					}
					
					if(count($flootAvarageRent50to100) > 0){
						$avarageSum50to100 = array_sum($flootAvarageRent50to100)/count($flootAvarageRent50to100);
						$lowest50to100 = count($flootRent50to100) > 0 ? min($flootRent50to100) : 0;
						$highest50to100 = count($flootRent50to100) > 0 ? max($flootRent50to100) : 0;
					}else{
						$avarageSum50to100 = 0;
						$lowest50to100 = 0;
						$highest50to100 = 0;
					}
					$avarageSum50to100 = $avarageSum50to100/10000;
					$avarageSum50to100 = number_format($avarageSum50to100,2,'.','');
					
					/************************* end ******************************/
					
					/******************** calc avarage between 100 to 300 ****************/
					$vacancyRate100to300 = Building::model()->findAll('address Like "%'.$town->town_name.'%" AND (std_floor_space BETWEEN 100 AND 300 OR std_floor_space = "")');
					$building100to300 = array();
					foreach($vacancyRate100to300 as $buildingDetails){	
						if($buildingDetails['std_floor_space'] == ""){
							$checkEmptyBuildingSpace = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
							$arrayFloor100To300 = array();
							foreach($checkEmptyBuildingSpace as $floor){
								$arrayFloor100To300[] = $floor['area_ping'];
							}
							if(count($arrayFloor100To300) > 0){
								if(max($arrayFloor100To300) > 100 && max($arrayFloor100To300) < 300){
									$building100to300[] = $buildingDetails['building_id'];
								}
							}
						}else{
							$building100to300[] = $buildingDetails['building_id'];
						}
					}
					$floor100to300 = array();
					$wantedFloor100to300 = array();
					
					$totalOfVacantFloor100to300  = '';
					$totalFloors100to300  = '';
					foreach($building100to300 as $building){
						$floorDetails = Floor::model()->findAll('building_id = '.$building);
						foreach($floorDetails as $floor){
							if($floor['vacancy_info'] == 1 && $floor['move_in_date'] == '即'){
								$wantedFloor100to300[] = $floor['floor_id'];
								$totalOfVacantFloor100to300 += $floor['area_ping'];
							}
							$floor100to300[] = $floor;
							$totalFloors100to300  += $floor['area_ping'];
						}
					}
					
					$flootAvarageRent100to300 = array();
					$flootRent100to300 = array();
					foreach($floor100to300 as $floor){
						if($floor['rent_unit_price'] != "" && $floor['unit_condo_fee'] != ""){
							$flootAvarageRent100to300[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
						}elseif($floor['rent_unit_price'] != "" && $floor['unit_condo_fee_opt'] == "-3"){
							$flootAvarageRent100to300[] = $floor['rent_unit_price'];
						}
						if($floor['rent_unit_price'] != ""){
							$flootRent100to300[] = $floor['rent_unit_price'];
						}
					}
					if(count($flootAvarageRent100to300) > 0){
						$avarageSum100to300 = array_sum($flootAvarageRent100to300)/count($flootAvarageRent100to300);
						$lowest100to300 = count($flootRent100to300) > 0 ? min($flootRent100to300) : 0;
						$highest100to300 = count($flootRent100to300) > 0 ? max($flootRent100to300) : 0;
					}else{
						$avarageSum100to300 = 0;
						$lowest100to300 = 0;
						$highest100to300 = 0;
					}
					$avarageSum100to300 = $avarageSum100to300/10000;
					$avarageSum100to300 = number_format($avarageSum100to300,2,'.','');
					
					/************************* end ******************************/
					
					/******************** calc avarage for greater 300 ****************/
					$vacancyRateGreater300 = Building::model()->findAll('address Like "%'.$town->town_name.'%" AND (std_floor_space >= 300 OR std_floor_space = "")');
					
					$buildingGreater300 = array();
					foreach($vacancyRateGreater300 as $buildingDetails){
						if($buildingDetails['std_floor_space'] == ""){
							$checkEmptyBuildingSpace = Floor::model()->findAll('building_id = '.$buildingDetails['building_id']);
							$arrayFloor300 = array();
							foreach($checkEmptyBuildingSpace as $floor){
								$arrayFloor300[] = $floor['area_ping'];
							}
							if(count($arrayFloor300) > 0){
								if(max($arrayFloor300) >= 300){
									$buildingGreater300[] = $buildingDetails['building_id'];
								}
							}
						}else{
							$buildingGreater300[] = $buildingDetails['building_id'];
						}
					}
					
					$floorGreater300 = array();
					$wantedFloorGreater300 = array();
					
					$totalOfVacantFloorgrt300  = '';
					$totalFloorsgrt300  = '';
					foreach($buildingGreater300 as $building){
						$floorDetails = Floor::model()->findAll('building_id = '.$building);
						foreach($floorDetails as $floor){
							if($floor['vacancy_info'] == 1 && $floor['move_in_date'] == '即'){
								$wantedFloorGreater300[] = $floor['floor_id'];
								$totalOfVacantFloorgrt300 += $floor['area_ping'];
							}
							$floorGreater300[] = $floor;
							$totalFloorsgrt300  += $floor['area_ping'];
						}
					}					
					
					$flootAvarageRentGreater300 = array();
					$flootRentGreater300 = array();
					foreach($floorGreater300 as $floor){
						if($floor['rent_unit_price'] != "" && $floor['unit_condo_fee'] != ""){
							$flootAvarageRentGreater300[] = $floor['rent_unit_price']+$floor['unit_condo_fee'];
						}elseif($floor['rent_unit_price'] != "" && $floor['unit_condo_fee_opt'] == "-3"){
							$flootAvarageRentGreater300[] = $floor['rent_unit_price'];
						}
						if($floor['rent_unit_price'] != ""){
							$flootRentGreater300[] = $floor['rent_unit_price'];
						}
					}
					
					if(count($flootAvarageRentGreater300) > 0){
						$avarageSumGreater300 = array_sum($flootAvarageRentGreater300)/count($flootAvarageRentGreater300);
						$lowestGreater300 =  count($flootRentGreater300) > 0 ? min($flootRentGreater300) : 0;
						$highestGreater300 = count($flootRentGreater300) > 0 ? max($flootRentGreater300) : 0;
					}else{
						$avarageSumGreater300 = 0;
						$lowestGreater300 = 0;
						$highestGreater300 = 0;
					}
					$avarageSumGreater300 = $avarageSumGreater300/10000;
					$avarageSumGreater300 = number_format($avarageSumGreater300,2,'.','');					
					/************************* end ******************************/
					
					
					$marketCloseTown = new MarketEquivalentTown;
					$marketCloseTown->town_name = $town->town_name;
					$marketCloseTown->district_name = $district->district_name;
					$marketCloseTown->prefecture_name = $prefacture->prefecture_name;
					$marketCloseTown->f_h_range = $avarageSum50to100;
					$marketCloseTown->h_t_range = $avarageSum100to300;
					$marketCloseTown->t_above_range = $avarageSumGreater300;
					$marketCloseTown->save(false);
										
					$k++;
				}
				echo "<<<<<<<<<<<<<<<<<<<<<<<----- END Town ----->>>>>>>>>>>>>>>>>>>>>>>><br/>";
			}
			$j++;
		}
		echo "<<<<<<<<<<<<<<<<<<<<<<<----- END District ----->>>>>>>>>>>>>>>>>>>>>>>><br/>";
	}
	$i++;
}
?>