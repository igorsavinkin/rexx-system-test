<?php
class VersionComparison { 
	static $threshold = [0 => 1, 1 => 0, 2 => 17 , 3 => 60]; // '1.0.17+60'
	static function compare($version){
		$arr = explode('.', $version);
		list($arr[2] , $arr[3]) = explode('+',$arr[2]); 
		for($i = 0; $i < count($arr); $i++){
			if ($arr[$i] < self::$threshold[$i]){
				return 'lower'; 
			}
		} 
		return 'equal or greater'; 
	}
}
?>