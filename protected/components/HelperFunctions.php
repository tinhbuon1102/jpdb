<?php
// Custom helper 
if (!defined('FIELD_MISSING_VALUE'))
{
	define('FIELD_MISSING_VALUE', '-');
	define('LANGUAGE_EN', 'en');
	define('LANGUAGE_JA', 'ja');
}

class HelperFunctions extends CApplicationComponent {
	public static function pr($data)
	{
		echo '<pre>'; print_r($data); echo '</pre>';
	}
	public static function formatNumber($number)
	{
		if ( strpos($number, ',') !== false && strpos($number, '.') !== false )
		{
			$number = str_replace(',', '', $number);
		}
		elseif ( strpos($number, ',') !== false )
		{
			$number = str_replace(',', '', $number);
		}
		
		$aNumber = explode('.', $number);
		if ( isset($aNumber[1]) ) $decimal = strlen($aNumber[1]) >= 2 ? 2 : strlen($aNumber[1]);
		else $decimal = 0;
		
		$number = $number ? $number : 0;
		
		return number_format($number, $decimal);
	}
	
	public static function convertDateFormat($date)
	{
		$date = str_replace('Sep', 'Sept', $date);
		$date = str_replace('Jun', 'June', $date);
		$date = str_replace('Jul', 'July', $date);
		return $date;
	}
	public static function getAreaArray()
	{
		$totalNumber = 2000;
		$aReturn = array();
		$aReturn[] = '-';
		for ( $i = 50; $i <= $totalNumber; $i = $i + 50 )
		{
			$aReturn[$i] = $i;
		}
		return $aReturn;
	}
	
	public static function getDownUpFloorArray()
	{
		$downFloors = 2;
		$upFloors = 100;
		$aReturn = array();
		$aReturn[] = '-';
		for ( $i = 1; $i <= $downFloors; $i ++ )
		{
			$aReturn[-$i] = 'B' . $i;
		}
		
		for ( $i = 1; $i <= $upFloors; $i ++ )
		{
			$aReturn[$i] = $i;
		}
		return $aReturn;
	}
	
	public static function getRentUnitArray() {
		$totalNumber = 5;
		$aReturn = array();
		$aReturn[] = '-';
		for ( $i = 0.5; $i <= $totalNumber; $i = $i + 0.5 )
		{
			$aReturn["$i"] = $i;
		}
		
		return $aReturn;
	}
	
	public static function getAmountArray() {
		$totalNumber = 10000000;
		$aReturn = array();
		$aReturn[] = '-';
		for ( $i = 10000; $i <= $totalNumber; $i = $i + 10000 )
		{
			$aReturn["$i"] = self::formatNumber($i);
		}
	
		return $aReturn;
	}
	
	public static function getBuildYearArray() {
		$totalNumber = 37;
		$currentYear = date('Y');
		$aReturn = array();
		$aReturn[] = '-';
		for ( $i = $currentYear - 37; $i <= $currentYear; $i++ )
		{
			$aReturn["$i"] = $i;
		}
	
		return $aReturn;
	}
	
	public static function getMoveDateArray() {
		$totalYearNumber = 2;
		$monthBefore = 1;
		$currentYear = date('Y');
		$currentMonth = date('m');
		$aReturn = array();
		$aReturn[] = '-';
		for ( $i = $currentYear; $i <= $currentYear + $totalYearNumber; $i++ )
		{
			for ( $j = 1; $j <= 12; $j++ )
			{
				if ($i == $currentYear && $j < $currentMonth - $monthBefore)
				{
					continue;
				}
				
				$move_date = $i. '-' . (strlen($j) == 1 ? "0$j" : $j); 
				$aReturn[$move_date] = date('Y年m月', strtotime($move_date));
			}
		}
	
		return $aReturn;
	}
	public static function getLocationArray() {
		$query = 'SELECT district FROM building INNER JOIN floor ON building.building_id = floor.building_id WHERE floor.show_frontend=1 GROUP by district';
		$districts = Yii::app()->db->createCommand($query)->queryAll();
		$aReturn = array();
		foreach ($districts as $district)
		{
			$aReturn[] = $district['district'];
		}
		
		return $aReturn;
	}
	
	public static function getOrderByArray() {
		$aReturn[''] = '-';
		
		$aReturn['name_asc'] = Yii::app()->controller->__trans('Name Ascending');
		$aReturn['name_desc'] = Yii::app()->controller->__trans('Name Descending');

		$aReturn['location_asc'] = Yii::app()->controller->__trans('Location Ascending');
		$aReturn['location_desc'] = Yii::app()->controller->__trans('Location Descending');
		
		$aReturn['size_asc'] = Yii::app()->controller->__trans('Size Ascending');
		$aReturn['size_desc'] = Yii::app()->controller->__trans('Size Descending');
		
		return $aReturn;
	}
	
	public static function searchSearchOptions(){
		$aSearchOptions = array();
		$aSearchOptions['area'] = self::getAreaArray();
		$aSearchOptions['floor'] = self::getDownUpFloorArray();
		$aSearchOptions['rent_unit'] = self::getRentUnitArray();
		$aSearchOptions['total_rent'] = self::getAmountArray();
		$aSearchOptions['built_year'] = self::getBuildYearArray();
		$aSearchOptions['move_in_date'] = self::getMoveDateArray();
		$aSearchOptions['location'] = self::getLocationArray();
		$aSearchOptions['orderby'] = self::getOrderByArray();
		return $aSearchOptions;
	}
	
	
	public static function translateBuildingValue($field, $building, $floor = array()){

		global $wpdb;
		$field = trim($field);
		$current_lang = isset($_REQUEST['print_language']) ? $_REQUEST['print_language'] : 'ja';
		switch ($field)
		{
			case "area_ping":
				if (!$floor['area_m']) return FIELD_MISSING_VALUE;
				if($current_lang == 'en')
					return self::formatNumber($floor['area_m']).AREA_M2 . ' | ' . self::formatNumber($floor[$field]).Yii::app()->controller->__trans('tsubo');
					else
						return self::formatNumber($floor[$field]).Yii::app()->controller->__trans('tsubo');
						break;
		
			case 'floor_up_down' :
				$floor['floor_down'] = str_replace(' ', '', $floor['floor_down']);
				$floor['floor_up'] = str_replace(' ', '', $floor['floor_up']);
		
				if (!$floor['floor_down'] && !$floor['floor_up']){
					return FIELD_MISSING_VALUE;
				}
				else{
					if ($floor['floor_down'] != '')
					{
						$floor_down = str_replace('-', '', $floor['floor_down']);
						if (strpos($floor['floor_down'], '-') !== false)
						{
							// underground
							$floor_down = $current_lang == LANGUAGE_EN ? 'B' . $floor_down : '地下'.$floor_down.'階';
						}
						else {
							$floor_down = $current_lang == LANGUAGE_EN ? $floor_down . 'F' : $floor_down.'階';
						}
						$floorLevel[] = $floor_down;
					}
					if ($floor['floor_up'] != '')
					{
						$floor_up = str_replace('-', '', $floor['floor_up']);
						if (strpos($floor['floor_up'], '-') !== false)
						{
							// underground
							$floor_up = $current_lang == LANGUAGE_EN ? 'B' . $floor_up : '地下'.$floor_up.'階';
						}
						else {
							$floor_up = $current_lang == LANGUAGE_EN ? $floor_up . 'F' : $floor_up.'階';
						}
						$floorLevel[] = $floor_up;
					}
		
					return implode(FIELD_MISSING_VALUE, $floorLevel);
				}
				break;
		
			case "rent_unit_price_opt":
				return $floor[$field] == FLOOR_UNIT_OPTION_UNDECIDED ? Yii::app()->controller->__trans('Undecided') : Yii::app()->controller->__trans('Ask');
				break;
		
			case "unit_condo_fee" :
				if (!$floor['unit_condo_fee'])
				{
					return translateBuildingValue('unit_condo_fee_opt', $building, $floor, $property_id);
				}
				if (false && $current_lang == 'en')
				{
					$price = renderPrice(self::formatNumber(str_replace(',', '', $floor['unit_condo_fee'])) / OFFICE_DB_FEE_RATE);
					return $price . '/' . AREA_M2;
				}
				else {
					return renderPrice(self::formatNumber(str_replace(',', '', $floor['unit_condo_fee']))). '/' . Yii::app()->controller->__trans('tsubo');
				}
					
				break;
					
			case "unit_condo_fee_opt":
				switch ($floor[$field])
				{
					case FLOOR_UNIT_CONDO_FEE_NONE:
						return Yii::app()->controller->__trans('None');
						break;
					case FLOOR_UNIT_CONDO_FEE_UNDECIDED:
						return Yii::app()->controller->__trans('Undecided');
						break;
					case FLOOR_UNIT_CONDO_FEE_ASK:
						return Yii::app()->controller->__trans('Ask');
						break;
					case FLOOR_UNIT_CONDO_FEE_INCLUDED:
						return Yii::app()->controller->__trans('Included');
						break;
					default:
						return FIELD_MISSING_VALUE;
						break;
				}
				break;
		
			case 'move_in_date' :
				if ($floor[$field])
				{
					if ($current_lang == LANGUAGE_EN)
					{
						$aExplodeDate = explode('/', $floor[$field]);
						$szDate = isset($aExplodeDate[2]) ? $aExplodeDate[2] : '';
						unset($aExplodeDate[2]);
						$move_date = strtotime(implode('-', $aExplodeDate));
						$dateFormatWithoutDate = 'M.Y';
						$dateFormatWithDate = 'M.d,Y';
		
						if (strpos($szDate, '月内') !== false)
						{
							$floor[$field] = date($dateFormatWithoutDate, $move_date);
						}
						elseif (strpos($szDate, '上旬') !== false)
						{
							$floor[$field] = 'Early ' . date($dateFormatWithoutDate, $move_date);
						}
						elseif (strpos($szDate, '中旬') !== false)
						{
							$floor[$field] = 'Mid ' . date($dateFormatWithoutDate, $move_date);
						}
						elseif (strpos($szDate, '下旬') !== false)
						{
							$floor[$field] = 'End ' . date($dateFormatWithoutDate, $move_date);
						}
						elseif (is_numeric($szDate))
						{
							$floor[$field] = date($dateFormatWithDate, $move_date);
						}
					}
		
					$floor[$field] = self::convertDateFormat($floor[$field]);
					return Yii::app()->controller->__trans($floor[$field]);
				}
				else {
					return FIELD_MISSING_VALUE;
				}
		
				break;
			case 'built_year' :
				$aExplodeDate = explode('-', $building[$field]);
		
				if (trim($building[$field]) == '-')
				{
					$building[$field] = FIELD_MISSING_VALUE;
				}
				else {
					if ((count($aExplodeDate) == 2 && !$aExplodeDate[1]) || count($aExplodeDate)  == 1)
					{
						$aExplodeDate[1] = 1;
						$dateFormat = 'Y';
					}
					else{
						$dateFormat = 'M.Y';
					}
		
					if ($current_lang == 'en')
					{
						$building[$field] = date($dateFormat, strtotime(implode('-', $aExplodeDate)));
					}else {
						$building[$field] = date('Y年m月', strtotime(implode('-', $aExplodeDate)));
					}
				}
		
				$building[$field] = self::convertDateFormat($building[$field]);
				return $building[$field];
				break;
		
			case 'total_floor_space':
				return $building[$field] ? explodeRangeValue($building[$field], AREA_M2) : FIELD_MISSING_VALUE;
				break;
		
			case 'total_rent_space_unit':
				return $building[$field] ? explodeRangeValue($building[$field], AREA_M2) : FIELD_MISSING_VALUE;
				break;
		
			case 'earth_quake_res_std' :
				switch ($building[$field])
				{
					case EARTH_QUAKE_OLD_STANDARD:
						return Yii::app()->controller->__trans('old-seismic building code');
						break;
					case EARTH_QUAKE_REINFOCED:
						return Yii::app()->controller->__trans('Reinforced for Seismic Resistance');
						break;
					case EARTH_QUAKE_NEW_STANDARD:
						return Yii::app()->controller->__trans('new-seismic building code');
						break;
					case EARTH_QUAKE_ISOLATION_STRUCTURE:
						return Yii::app()->controller->__trans('quake-absorbing structure');
						break;
					case EARTH_QUAKE_UNKNOW:
						return Yii::app()->controller->__trans('Unknown');
						break;
					case EARTH_QUAKE_DAMPING_STRUCTURE:
						return Yii::app()->controller->__trans('Vibration Control Structure');
						break;
					default:
						return FIELD_MISSING_VALUE;
						break;
				}
				break;
		
			case 'elevator' :
				$elevatorExp = explode('-',$building['elevator']);
				$return = '';
				if($elevatorExp[0] == 1){
					if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "")
						// 					$return .= '(';
						$return .= isset($elevatorExp[1]) && $elevatorExp[1] != "" ? $elevatorExp[1].Yii::app()->controller->__trans('ELV(s)') : Yii::app()->controller->__trans('Exists');
						// 					$return .= isset($elevatorExp[2]) && $elevatorExp[2] != "" ? '/'.$elevatorExp[2].Yii::app()->controller->__trans('Human power') : "";
						// 					$return .= isset($elevatorExp[3]) && $elevatorExp[3] != "" ? $elevatorExp[3].Yii::app()->controller->__trans('For basic loading') : "";
						// 					$return .= isset($elevatorExp[4]) && $elevatorExp[4] != "" ? $elevatorExp[4].Yii::app()->controller->__trans('Human power') : "";
						// 					$return .= isset($elevatorExp[5]) && $elevatorExp[5] != "" ? $elevatorExp[5]. Yii::app()->controller->__trans('Group') : "";
						// 					if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") $return .= ')';
				}else if($elevatorExp[0] == -2){
					$return .= Yii::app()->controller->__trans('Unknown');
				}else if($elevatorExp[0] == 2){
					$return .= Yii::app()->controller->__trans('Not exists');
				}else{
					$return .= FIELD_MISSING_VALUE;
				}
				return $return;
				break;
		
			case 'parking_unit_no' :
				$parkingUnitNo = explode('-', $building['parking_unit_no']);
				if($parkingUnitNo[0] == 1){
					return ($parkingUnitNo[1] != "" ? $parkingUnitNo[1] . (!$current_lang == 'en' ? '台' : '') : Yii::app()->controller->__trans('Exists'));
				}else if($parkingUnitNo[0] == 2){
					return Yii::app()->controller->__trans('No exists');
				}else if($parkingUnitNo[0] == 3){
					return Yii::app()->controller->__trans('Exist but unknown unit number');
				}
				break;
		
			case 'opticle_cable' :
				if($building['opticle_cable'] == 0){
					return Yii::app()->controller->__trans('Unknown');
				}else if($building['opticle_cable'] == 1){
					return Yii::app()->controller->__trans('Pull Yes');
				}else if($building['opticle_cable'] == 2){
					return Yii::app()->controller->__trans('Nothing');
				}else{
					return FIELD_MISSING_VALUE;
				}
				break;
		
			case 'std_floor_space' :
				if ($current_lang == 'en')
				{
					return $building['std_floor_space'] != "" ?
					((self::formatNumber(str_replace(',', '', $building['std_floor_space']) * OFFICE_DB_FEE_RATE).' ' . AREA_M2) . '<br/>' .
							self::formatNumber(str_replace(',', '', $building['std_floor_space'])) .' ' . Yii::app()->controller->__trans('tsubo'))
							: FIELD_MISSING_VALUE;
				}
				else {
					return $building['std_floor_space'] != "" ? self::formatNumber(str_replace(',', '', $building['std_floor_space'])) .' ' . Yii::app()->controller->__trans('tsubo') : FIELD_MISSING_VALUE;
				}
				break;
		
			case 'security_id':
				$securityDetails = $wpdb->get_row("SELECT * FROM `security` WHERE security_id=" . (int)$building['security_id']);
				return $securityDetails ? Yii::app()->controller->__trans($securityDetails->security_name) : FIELD_MISSING_VALUE;
				break;
		
			case 'renewal_data':
				return $building[$field] ? ($current_lang == 'en' ? Yii::app()->controller->__trans($building['renewal_data_en']) : Yii::app()->controller->__trans($building[$field])) : FIELD_MISSING_VALUE;
				break;
		
			case 'avg_neighbor_fee':
				if (!$building['avg_neighbor_fee_min'] && !$building['avg_neighbor_fee_max']){
					$return = FIELD_MISSING_VALUE;
				}
				else{
					if ($current_lang == 'en')
					{
						$return = $building['avg_neighbor_fee_min'] ? renderPrice(str_replace(',', '', $building['avg_neighbor_fee_min']) / OFFICE_DB_FEE_RATE) : FIELD_MISSING_VALUE;
						$return .= $building['avg_neighbor_fee_max'] ? FIELD_MISSING_VALUE . renderPrice(str_replace(',', '', $building['avg_neighbor_fee_max']) / OFFICE_DB_FEE_RATE) : FIELD_MISSING_VALUE;
					}
					else {
						$return = $building['avg_neighbor_fee_min'] ? renderPrice($building['avg_neighbor_fee_min']) : FIELD_MISSING_VALUE;
						$return .= $building['avg_neighbor_fee_max'] ? FIELD_MISSING_VALUE . renderPrice($building['avg_neighbor_fee_max']) : FIELD_MISSING_VALUE;
					}
				}
				return $return;
				break;
			case 'type_of_use' :
				$userTypesList = $wpdb->get_results("SELECT * FROM `use_types` WHERE user_type_id IN(". (string)$floor['type_of_use'] .")");
				$typeOfUse = array();
				foreach($userTypesList as $useList){
					$typeOfUse[] = Yii::app()->controller->__trans($useList->user_type_name);
				}
				return implode(',', $typeOfUse);
				break;
		
			case 'contract_period_duration' :
				return $floor[$field] ? Yii::app()->controller->__trans($floor[$field]) . Yii::app()->controller->__trans('年') : FIELD_MISSING_VALUE;
				break;
		
			case 'contract_period':
				$return = '';
				if(isset($floor['contract_period_opt']) && $floor['contract_period_opt'] != ""){
					if($floor['contract_period_opt'] == 1){
						$return .=  Yii::app()->controller->__trans('普通借家');
					}elseif($floor['contract_period_opt'] == 2){
						$return .=  Yii::app()->controller->__trans('定借');
					}elseif($floor['contract_period_opt'] == 3){
						$return .=  Yii::app()->controller->__trans('定借希望');
					}else{
						$return .=  FIELD_MISSING_VALUE;
					}
				}else{
					$return .=  FIELD_MISSING_VALUE;
				}
		
				if(isset($floor['contract_period_optchk']) && $floor['contract_period_optchk'] == 1){
					$return .=  Yii::app()->controller->__trans('<br>年数相談');
				}
		
				return $return;
				break;
		
			case 'floor_material':
				return $floor[$field] ? Yii::app()->controller->__trans($floor[$field]) : FIELD_MISSING_VALUE;
				break;
		
			case 'oa_type':
				return $floor[$field] ? Yii::app()->controller->__trans($floor[$field]) : FIELD_MISSING_VALUE;
				break;
		
			case 'oa_height':
				return $floor[$field] ? Yii::app()->controller->__trans(self::formatNumber($floor[$field])) . 'mm' : FIELD_MISSING_VALUE;
				break;
		
			case 'ceiling_height':
				return $floor[$field] ? Yii::app()->controller->__trans(self::formatNumber($floor[$field])) . 'mm' : FIELD_MISSING_VALUE;
				break;
		
			case 'construction_type_name':
				if (!$building['construction_type_name_en'])
				{
					$construction = Yii::app()->controller->__trans(($building[$field]));
				}
				else {
					if ($current_lang == 'en')
					{
						$construction = $building['construction_type_name_en'];
					}else {
						$construction = $building[$field];
					}
				}
				return $construction ? $construction . '' : '';
				break;
		
			case 'vacancy_info':
				return $floor[$field] ? Yii::app()->controller->__trans('Avaiable') : Yii::app()->controller->__trans('Not Available');
				break;
				
			case 'address':
				return $current_lang == LANGUAGE_EN ? $building['address_en'] : $building['address'];
				break;
				
			case 'station_access':
				$trafficDetails = BuildingStation::model()->find('building_id = '.$building['building_id'].' order by time ASC');
				if ($current_lang == LANGUAGE_EN)
				{
					return $trafficDetails['time']. ' min on foot from '.$trafficDetails['name_en'].' station('.($trafficDetails['line_en'] ? $trafficDetails['line_en'] : $trafficDetails['line']).' line)';
				}
				else {
					return $trafficDetails['name'].Yii::app()->controller->__trans('駅', 'ja').$trafficDetails['line'].Yii::app()->controller->__trans('徒歩', 'ja').$trafficDetails['time'].Yii::app()->controller->__trans('分', 'ja');
				}
				
				break;
				
			default :
		
				break;
		}
		
	}
}