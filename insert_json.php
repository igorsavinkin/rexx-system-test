<?php
require_once 'db_config.php';
include 'db.php';
$db = new db(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//echo '<pre>';
$array = json_decode(file_get_contents("events.json"), true);
foreach ($array as $p) { //print_r( $p ); 
	// insert employee
	$empl_id = $db->query("SELECT id FROM employee WHERE mail = ?",  $p['employee_mail']  )->fetchArray();
	if (!$empl_id){ 
		$empl_id = $db->query("INSERT INTO employee (`name`, `mail`) VALUES (?, ?)", $p['employee_name'], $p['employee_mail']);		 
		echo 'employee is inserted with id: ' , $empl_id, '<br />' ;
	} 
	// insert participations with newly acquired employee id : empl_id
    $db->query("INSERT INTO participation VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE employee_id = ?", $p['participation_id'], $empl_id, $p['event_id'], $p['participation_fee'], $p['version'],  $empl_id);  		
	// insert event
	$db->query("INSERT IGNORE INTO event VALUES (?, ?, ?)", $p['event_id'], $p['event_name'], $p['event_date']);  		
}
echo 'Inserted '. count($array) . ' participation items';