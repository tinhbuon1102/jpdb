<?php
// Custom helper 
class HelperFunctions extends CApplicationComponent {
	public static function pr($data)
	{
		echo '<pre>'; print_r($data); echo '</pre>';
	}
	public static function formatNumber($number)
	{
		$number = str_replace(',', '', $number);
		
		$aNumber = explode('.', $number);
		if ( isset($aNumber[1]) ) $decimal = strlen($aNumber[1]) >= 2 ? 2 : strlen($aNumber[1]);
		else $decimal = 0;
		
		$number = $number ? $number : 0;
		
		return number_format($number, $decimal);
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
			$aReturn["$i"] = $i;
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
	
	public static function searchSearchOptions(){
		$aSearchOptions = array();
		$aSearchOptions['area'] = self::getAreaArray();
		$aSearchOptions['floor'] = self::getDownUpFloorArray();
		$aSearchOptions['rent_unit'] = self::getRentUnitArray();
		$aSearchOptions['condo_unit'] = self::getAmountArray();
		$aSearchOptions['built_year'] = self::getBuildYearArray();
		$aSearchOptions['move_in_date'] = self::getMoveDateArray();
		$aSearchOptions['location'] = self::getLocationArray();
		return $aSearchOptions;
	}
}