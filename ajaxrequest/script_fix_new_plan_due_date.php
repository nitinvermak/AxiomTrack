<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 

 
 
 
$sql = "SELECT *
FROM `tbl_gps_vehicle_payment_master`
WHERE `next_due_date` <> '0000-00-00'
AND `PlanactiveFlag` = 'N'
 ";
 
$counter_date = 0;

echo $sql;
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	echo 'inside loop';
	// echo "<pre>";
	// print_r($row);
	$lastDueDate = $row['next_due_date'];
	$vehicleId =   $row['Vehicle_id'];
    $custid  =     $row['cust_id'];
	$sql1 = "SELECT *
		FROM `tbl_gps_vehicle_payment_master`
		WHERE `next_due_date` = '0000-00-00'
		AND `PlanactiveFlag` = 'Y'
		AND  `Vehicle_id` = $vehicleId
		and  `cust_id` = $custid
		";
		
		
	echo $sql1;
	echo "<br>";
	$result1 = mysql_query($sql1);
	echo mysql_num_rows($result1);
	if (mysql_num_rows($result1) ==1){	
		
			$sql2 = "UPDATE `tbl_gps_vehicle_payment_master` SET `next_due_date` = '$lastDueDate' 
			 WHERE `Vehicle_id`= '$vehicleId'  and `cust_id` = $custid AND `PlanactiveFlag` = 'Y'";
	        echo "<br>";
			echo $sql2;
			echo "<br>";
			$result2 = mysql_query($sql2);
	}
	
	$counter_date = $counter_date + mysql_num_rows($result1);
	
	
}
 
echo 'REquired counter = '. $counter_date;
?>