<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = $_REQUEST['cust_id']; 

// get Rent Amount
$sql = mysql_query("SELECT B.plan_rate as amt 
					FROM tbl_gps_vehicle_payment_master as A 
					INNER JOIN tblplan as B 
					WHERE A.cust_id = '$cust_id' AND A.Vehicle_id =");
$start_date = next_due_date($cust_id);
$end_date =  date("Y-m-d");

$date1 = date_create($start_date);
$date2 = date_create($end_date);

$diff=date_diff($date1, $date2);
$days =  $diff->format("%a");

?>