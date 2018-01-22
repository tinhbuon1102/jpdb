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
	
	
	public static function translateBuildingValue($field, $building = array(), $floor = array()){

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
		
			case "roomname":
				if(isset($floor['roomname']) && $floor['roomname'] != ""){
					return $floor['roomname'];
				}
				else {
					return '';
				}
				break;
			case "rent_unit_price_opt":
				return $floor[$field] == FLOOR_UNIT_OPTION_UNDECIDED ? Yii::app()->controller->__trans('Undecided') : Yii::app()->controller->__trans('Ask');
				break;
				
			case "air_conditioning_facility_type":
				if ($floor[$field])
				{
					return $floor[$field] == 'unknown' ? Yii::app()->controller->__trans($floor[$field]) : $floor[$field];
				}
				else {
					return FIELD_MISSING_VALUE;
				}
		
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
						
						$floor[$field] = self::convertDateFormat($floor[$field]);
					}
					return Yii::app()->controller->__trans($floor[$field], 'ja');
		
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
					return $trafficDetails['time']. ' min on foot from '.str_replace('station', '', $trafficDetails['name_en']).' station('.($trafficDetails['line_en'] ? $trafficDetails['line_en'] : $trafficDetails['line']).' line)';
				}
				else {
					return $trafficDetails['name'].Yii::app()->controller->__trans('駅', 'ja').$trafficDetails['line'].Yii::app()->controller->__trans('徒歩', 'ja').$trafficDetails['time'].Yii::app()->controller->__trans('分', 'ja');
				}
				
				break;
			
			case 'renewal_data' :
				if ($current_lang == 'en')
				{
					$return = $building['renewal_data_en'] ? $building['renewal_data_en'] : FIELD_MISSING_VALUE;
				}
				else {
					$return = $building['renewal_data'] ? $building['renewal_data'] : FIELD_MISSING_VALUE;
				}
				break;
				
			default :
		
				break;
		}
		
	}
	
	public static function showFixedFloorText($floor)
	{
		$floor = (object)$floor;
		return $floor->fixed_floor ? '<div class="fixed_floor">常に表示</div>' : '';
	}
	
	public static function generateTableNegotiation($rentNegotiationDetails, $params = array())
	{
		if ( isset($rentNegotiationDetails) && count($rentNegotiationDetails) > 0 )
		{
			$resp = '<table class="tblFreeRent">
						<tbody>';
			$days = array(
				'月' => 'Mon',
				'火' => 'Tue',
				'水' => 'Wed',
				'木' => 'Thu',
				'金' => 'Fri',
				'土' => 'Sat',
				'日' => 'Sun'
			);
			foreach ( $rentNegotiationDetails as $negotiationList )
			{
				$allocateFloorDetails = Floor::model()->findAllByAttributes(array(
					'floor_id' => explode(',', $negotiationList['allocate_floor_id'])
				));
				if ( isset($allocateFloorDetails) && count($allocateFloorDetails) > 0 )
				{
					$floorName = '';
					foreach ( $allocateFloorDetails as $floor )
					{
						$negUnitB = '';
						$negUnit = '';
						$negVal = '';
						if ( $negotiationList['negotiation_type'] == 1 )
						{
							$negUnit = '(共益費込み)';
							$negUnitB = '¥';
							$negVal = number_format($negotiationList['negotiation']);
						}
						elseif ( $negotiationList['negotiation_type'] == 5 )
						{
							$negUnit = '';
							$negUnitB = '¥';
							$negVal = number_format($negotiationList['negotiation']);
						}
						elseif ( $negotiationList['negotiation_type'] == 2 || $negotiationList['negotiation_type'] == 3 )
						{
							$negUnit = 'ヶ月';
							$negVal = $negotiationList['negotiation'];
						}
						else
						{
							$negVal = $negotiationList['negotiation'];
						}
						
						if ( strpos($floor['floor_down'], '-') !== false )
						{
							$floorDown = Yii::app()->controller->__trans("地下") . ' ' . str_replace("-", "", $floor['floor_down']);
						}
						else
						{
							$floorDown = $floor['floor_down'];
						}
						if ( $floor['floor_up'] != "" )
						{
							$floorName .= $floorDown . " ~ " . $floor['floor_up'];
						}
						else
						{
							$floorName .= $floorDown . ' ' . Yii::app()->controller->__trans("階");
						}
						
						$floorName .= " / " . $floor['area_ping'] . ' ' . Yii::app()->controller->__trans("tsubo") . ' | ' . $negUnitB . ' ' . $negVal . ' ' . $negUnit . ' ' . $negotiationList['negotiation_range'] . ' ' . $negotiationList['negotiation_note'];
					}
				}
				else
				{
					$floorName = '';
				}
				$day = array_search((date('D', strtotime($negotiationList['added_on']))), $days);
				$resp .= '<tr>';
				
				if (!isset($params['no_button']))
				{
					$resp .= '<td class="tdRent_check_wraper"><input type="checkbox" name="tdRentCheck[' . $negotiationList['rent_negotiation_id'] . ']" class="tdRentCheck" value="' . $negotiationList['rent_negotiation_id'] . '"/></td>';
				}
				
				$resp .= '<td>' . date('Y.m.d', strtotime($negotiationList['added_on'])) . '(' . $day . ')</td>';
				
				$personIncharge = AdminDetails::model()->find('user_id = ' . $negotiationList['person_incharge']);
				$resp .= '<td>' . $personIncharge['full_name'] . '</td>';
				$resp .= '<td>';
				if ( $negotiationList['negotiation_type'] == 1 )
				{
					$resp .= '底値： ';
				}
				elseif ( $negotiationList['negotiation_type'] == 2 )
				{
					$resp .= '敷金交渉値： ';
				}
				elseif ( $negotiationList['negotiation_type'] == 3 )
				{
					$resp .= Yii::app()->controller->__trans("Key money negotiation value");
				}
				else if ( $negotiationList['negotiation_type'] == 5 )
				{
					$resp .= '目安値： ';
				}
				else
				{
					$resp .= Yii::app()->controller->__trans("Other negotiations information");
				}
				$resp .= '' . $floorName . '</td>
								</tr>';
			}
			
			if (!isset($params['no_button']))
			{
				$resp .= '<tr>
							<td class="tdTrans">
								<button type="button" name="btnDeleteRentHistory" id="btnDeleteRentHistory" class="btnDeleteRentHistory">一括削除</button>
							</td>
						</tr>';
			}
			
			$resp .= '</tbody>
					</table>';
		}
		return $resp;
	}
	
	
	public static function arranging_array_values($multi_trader){
		$prv_floors=array();
		$multi_trader_array=array();
		foreach ($multi_trader as $multi_traders) {
			if(in_array($multi_traders['floor_id'], $prv_floors)){
				if(($multi_traders['owner_company_name']=="")||($multi_traders['owner_company_name']==" ")){
					$multi_traders['owner_company_name'] ="blank";
				}
				if($multi_traders['is_current'] == 1){
					if(!empty($multi_trader_array[$multi_traders['floor_id']]['windows'])){
						$multi_trader_array[$multi_traders['floor_id']]['windows'] .= ' / '.$multi_traders['owner_company_name'];
						$multi_trader_array[$multi_traders['floor_id']]['windows_array'][] = $multi_traders['owner_company_name'];
					}
					else{
						$multi_trader_array[$multi_traders['floor_id']]['windows'] .= $multi_traders['owner_company_name'];
						$multi_trader_array[$multi_traders['floor_id']]['windows_array'][] = $multi_traders['owner_company_name'];
	
					}
	
				}
				if($multi_traders['is_current'] == 0){
					if(!empty($multi_trader_array[$multi_traders['floor_id']]['owners'])){
						$multi_trader_array[$multi_traders['floor_id']]['owners'] .= ' / '.$multi_traders['owner_company_name'];
						$multi_trader_array[$multi_traders['floor_id']]['owners_array'][] = $multi_traders['owner_company_name'];
					}
					else{
						$multi_trader_array[$multi_traders['floor_id']]['owners'] .= $multi_traders['owner_company_name'];
						$multi_trader_array[$multi_traders['floor_id']]['owners_array'][] = $multi_traders['owner_company_name'];
					}
				}
			}
			else{
				$multi_trader_array[$multi_traders['floor_id']]['owners_array']=array();
				$multi_trader_array[$multi_traders['floor_id']]['windows_array']=array();
				if(($multi_traders['owner_company_name']=="")||($multi_traders['owner_company_name']==" ")){
					$multi_traders['owner_company_name'] ="blank";
				}
				$prv_floors[]=$multi_traders['floor_id'];
				$multi_trader_array[$multi_traders['floor_id']]['windows']="";
				$multi_trader_array[$multi_traders['floor_id']]['owners']="";
				$multi_trader_array[$multi_traders['floor_id']]['info']=$multi_traders;
				if($multi_traders['is_current'] == 1){
					$multi_trader_array[$multi_traders['floor_id']]['windows'] = $multi_traders['owner_company_name'];
					$multi_trader_array[$multi_traders['floor_id']]['windows_trader_id']=$multi_traders['trader_id'];
					$multi_trader_array[$multi_traders['floor_id']]['windows_array'][] = $multi_traders['owner_company_name'];
				}
				if($multi_traders['is_current'] == 0){
					$multi_trader_array[$multi_traders['floor_id']]['owners'] = $multi_traders['owner_company_name'];
					$multi_trader_array[$multi_traders['floor_id']]['owner_trader_id']=$multi_traders['trader_id'];
					$multi_trader_array[$multi_traders['floor_id']]['owners_array'][] = $multi_traders['owner_company_name'];
				}
			}
		}
		//echo "<pre>";
		//print_r($multi_trader_array);
		return $multi_trader_array;
	
	}
	
	public static function arranging_array_values_same_owners($multi_trader){
		$prv_window_trader=array();
		$multi_trader_array=array();
		//print_r($multi_trader);
		foreach ($multi_trader as $multi_traders) {
			$new_window_trader=$multi_traders['owners'].'_'.$multi_traders['windows'];
			if(in_array($new_window_trader, $prv_window_trader)){
				$multi_trader_array[$new_window_trader]['info'][]=$multi_traders['info'];
			}
			else{
				$prv_window_trader[]=$multi_traders['owners'].'_'.$multi_traders['windows'];
				$multi_trader_array[$new_window_trader]['owners']=$multi_traders['owners'];
				$multi_trader_array[$new_window_trader]['windows']=$multi_traders['windows'];
				$multi_trader_array[$new_window_trader]['info'][]=$multi_traders['info'];
			}
		}
		return $multi_trader_array;
	}
	
	public static function arranging_array_values_same_multi_owners($multi_trader){
		$prv_window_trader_array=array();
		$multi_trader_array=array();
		foreach ($multi_trader as $multi_traders) {
			$check_array_win =$multi_traders['windows_array'];
			$check_array_own =$multi_traders['owners_array'];
			sort($check_array_win);
			sort($check_array_own);
			$check_array_win=implode('_', $check_array_win);
			$check_array_own=implode('_', $check_array_own);
			$new_name=$check_array_win.'_'.$check_array_own;
			if(in_array($new_name, $prv_window_trader_array)){
				$multi_trader_array[$new_name]['info'][]=$multi_traders['info'];
			}
			else{
				$prv_window_trader_array[]=$new_name;
				$multi_trader_array[$new_name]['owners']=$multi_traders['owners'];
				$multi_trader_array[$new_name]['windows']=$multi_traders['windows'];
				$multi_trader_array[$new_name]['info'][]=$multi_traders['info'];
			}
	
		}
		return $multi_trader_array;
	}
	
	public static function buildQuery($type, $pid = 0)
	{
		if ($type == 'proposed')
		{
			$aFloor = self::getFloorInProposed($pid);
		}
		else {
			$aFloor = self::cartedFloor();
		}
		$floorQuery = ' 1=1 ';
		if(is_array($aFloor) && count($aFloor) > 0) {
			$allFloorsStr = implode(',',$aFloor);
			$floorQuery .= ' AND floor_id IN ('.$allFloorsStr.')';
		}
		return $floorQuery;
	}
	
	public static function getFloorInProposed($pid)
	{
		$articleData = ProposedArticle::model()->findByPk($pid);
		$buildngIds = explode(',',$articleData['building_id']);
		$floorIds = explode(',',$articleData['floor_id']);
		$aSearchParams['where'] = (array('t.building_id' => $buildingIds));
		//$resultData = Building::model()->getBuildingList($aSearchParams);
		$resultData = Building::model()->findAllByAttributes(array('building_id'=>$buildngIds));
		$aFloor = array();
		foreach($buildngIds as $bId){
			$checkAvailBuild = Building::model()->findByPk($bId);
			if(count($checkAvailBuild) > 0){
				$getFloor = Floor::model()->findAll('building_id = '.$bId);
				foreach($getFloor as $availFloor){
					if(in_array($availFloor['floor_id'],$floorIds)){
						$aFloor[] = $availFloor['floor_id'];
					}
				}
			}
		}
		return $aFloor;
	}
	
	public static function cartedFloor(){
		$users=Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$loguser_id = $users->user_id;
		$floorIds = array();
		$cartDetails = Cart::model()->findAll(array('order'=>'`order`', 'condition'=>'user_id=:x', 'params'=>array(':x'=>$loguser_id)));
		if(isset($cartDetails) && count($cartDetails) > 0){
			$floorIds = $buildingIds = array();
			foreach($cartDetails as $cart){
				$floorIds[] = $cart['floor_id'];
			}
		}
		return $floorIds;
	}
	
	public static function floor_array($floorQuery, $building_id){
		$floors= Floor::model()->findAll($floorQuery.' AND building_id = '.$building_id . ' ORDER BY cast(floor_down as SIGNED) ASC, cast(floor_up as SIGNED) ASC');
		$floor_id=array();
		foreach ($floors as $floor) {
			$floor_id[]= $floor['floor_id'];
		}
		$floor_id=implode(',', $floor_id);
		//echo $floor_id;
		$floors=self::trader_owner_find($floor_id, $building_id);
		//echo "<pre>";
		//print_r($floors);
		// die();
		return $floors;
	
			
	}
	public static function trader_owner_find($floor_id, $building_id){
		$multi_trader= 'SELECT own.* , f.* from floor as f RIGHT JOIN ownership_management as own on f.floor_id = own.floor_id WHERE f.building_id='.$building_id.' AND own.is_multiple_window=1 AND own.is_compart =0 AND f.floor_id IN ('.$floor_id.')';
		$multi_trader = Yii::app()->db->createCommand($multi_trader)->queryAll();
		$multi_window_array=self::arranging_array_values($multi_trader);
		$multi_window_array=self::arranging_array_values_same_multi_owners($multi_window_array);
	
	
		$multi_owner= 'SELECT own.* , f.* from floor as f  JOIN ownership_management as own on f.floor_id = own.floor_id WHERE  f.building_id='.$building_id.' AND own.is_shared = 1  AND own.is_compart =0 AND own.is_multiple_window=0 AND f.floor_id IN ('.$floor_id.')';
		$multi_owner = Yii::app()->db->createCommand($multi_owner)->queryAll();
		$multi_owner_array=self::arranging_array_values($multi_owner);
		$multi_owner_array=self::arranging_array_values_same_multi_owners($multi_owner_array);
		//print_r($multi_owner_array);
	
		$single_owner_window= 'SELECT own.* , f.* from floor as f  JOIN ownership_management as own on f.floor_id = own.floor_id WHERE f.building_id='.$building_id.' AND own.is_shared = 0 AND own.is_multiple_window = 0 AND own.is_compart =0 AND f.floor_id IN ('.$floor_id.')';
		$single_owner_window = Yii::app()->db->createCommand($single_owner_window)->queryAll();
		$single_owner_window_array=self::arranging_array_values($single_owner_window);
		$single_owner_window_array=self:: arranging_array_values_same_owners($single_owner_window_array);
	
	
		$comparted= 'SELECT own.* , f.* from floor as f RIGHT JOIN ownership_management as own on f.floor_id = own.floor_id WHERE f.building_id='.$building_id.'  AND own.is_compart =1 AND f.floor_id IN ('.$floor_id.')';
		$comparted = Yii::app()->db->createCommand($comparted)->queryAll();
		$comparted_array=self::arranging_array_values($comparted);
		$comparted_array=self::arranging_array_values_same_multi_owners($comparted_array);
	
		$no_owner_window= 'SELECT f.* FROM floor as f LEFT JOIN ownership_management as own ON own.floor_id = f.floor_id WHERE own.floor_id IS NULL and f.building_id='.$building_id.' AND f.floor_id IN ('.$floor_id.')';
		$no_owner_window = Yii::app()->db->createCommand($no_owner_window)->queryAll();
	
		$floors=array(
			'multi_window_array'=>$multi_window_array,
			'multi_owner_array'=>$multi_owner_array,
			'single_owner_window_array'=>$single_owner_window_array,
			'comparted_array'=>$comparted_array,
			'no_owner_window'=>$no_owner_window
		);
		return $floors;
	}
}