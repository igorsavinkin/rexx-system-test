<?php
require_once 'db_config.php';
include 'db.php';
$db = new db(DB_HOST, DB_USER, DB_PASS, DB_NAME);
echo '<pre>';
foreach (json_decode(file_get_contents("events.json"), true) as $p) {
    //print_r( $p ); 
	$empl_id = $db->query("SELECT id FROM employee WHERE mail = ?",  $p['employee_mail']  )->fetchArray();
	if (!$empl_id){ 
		$empl_id = $db->query("INSERT INTO employee (`name`, `mail`) VALUES (?, ?)", $p['employee_name'], $p['employee_mail']);		 
		echo 'inserted with id: ' , $empl_id, '<br />' ;
	} 
    $part_id = $db->query("INSERT INTO participation VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE employee_id = ?", $p['participation_id'], $empl_id, $p['event_id'], $p['participation_fee'], $p['version'],  $empl_id);  		
	// check event
	$event_id = $db->query("SELECT id FROM event WHERE id = ?",  $p['event_id']  )->fetchArray();
	if (!$event_id){ 
		$event_id = $db->query("INSERT INTO event VALUES (?, ?, ?)", $p['event_id'], $p['event_name'], $p['event_date']);  		
	}
}