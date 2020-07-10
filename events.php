<h3>Filter events by <i>employee</i>, <i>event name</i> and <i>date</i></h2>

<form  method="POST" >
	Employee: <input name="employee"      value="<?= isset($_POST['employee']) ? $_POST['employee'] : '' ?>" >
	Event name: <input name="event"       value="<?= isset($_POST['event']) ? $_POST['event'] : '' ?>" >
	Date: <input name="date"  type='date' value="<?= isset($_POST['date']) ? $_POST['date'] : '' ?>" >
	<input name="submit" value="Search" type="submit" >
</form> 
*Leave the fields empty if you want to view all the events and all employees.<br />
<?php
include 'versioncomparison.php';
$vc = new VersionComparison(); 

if (isset($_POST) and sizeof($_POST) !== 0){
	require_once 'db_config.php';
	include 'db.php';
	$db = new db(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$query = "SELECT emp.name as empl_name, event.name, fee, version, date FROM employee as emp
    LEFT JOIN participation ON emp.id = participation.employee_id 	
	 JOIN event ON event.id = participation.event_id 
	WHERE 1 "; 
	$parameters_number = 0;
	if($_POST['employee']){
		$employee = htmlentities( $_POST['employee'], ENT_QUOTES);
		$query .= " AND emp.name LIKE '%$employee%' "; 
	} 
	if($_POST['event']){
		$event = htmlentities( $_POST['event'], ENT_QUOTES);
		$query .= " AND event.name LIKE '%$event%' ";	
	} 
	if( $_POST['date']){
		$date = htmlentities( $_POST['date'], ENT_QUOTES);
		$query .= " AND (event.date BETWEEN '$date 00:00:00' AND '$date 23:59:59')";	
	}  
	$res = $db->query($query)->fetchAll();     
	if ($res) {
		$total=0;
		echo '<hr /><h3>RESULTS: ', count($res) ,'</h3/>';
		echo '<table border=1><tr><th>Event</th><th>Date & time in UTC</th><th>Employee</th><th>Event fee</th></tr>';
		echo '<tbody>';
		foreach($res as $i){
			$total += floatval($i['fee']); 
			if ($vc::compare($i['version']) === 'lower'){
				$date = DateTime::createFromFormat('Y-m-d H:i:s', $i['date']);
				$date->sub(new DateInterval('PT2H'));
				$i['date'] = $date->format('Y-m-d H:i:s');
			} 
			echo '<tr><td>' , $i['name'] , '</td><td>' , $i['date'] ,'</td><td>' , $i['empl_name'] ,  '</td><td>' , $i['fee'] ,  '</td></tr>';
		}
		echo '<tr> <td colspan=3><b>Total fee</b>:</td><td ><b>' , $total , '</b></td></tr></tbody>';
		echo '</table>';
	} else {
		echo '<hr /><h3>No RESULTS for the search:</h3/>';
		echo 'employee: ', htmlentities( $_POST['employee'], ENT_QUOTES)  ;
		echo '<br />event name: ', htmlentities( $_POST['event'], ENT_QUOTES) ;
		echo '<br />date: ', htmlentities( $_POST['date'], ENT_QUOTES);
	}
} 
?>
