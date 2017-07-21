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
}