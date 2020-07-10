<?php 
require_once 'db_config.php';
include 'db.php';
$db = new db(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$db_file= file_get_contents('tables.sql');
//echo $db_file; 
$db_statements = array_filter(explode(';', $db_file)); // split SQL into single statements
foreach($db_statements as $st){
	echo 'Executing: <br />', $st, '<br /><br />';
	$db->query($st);
}