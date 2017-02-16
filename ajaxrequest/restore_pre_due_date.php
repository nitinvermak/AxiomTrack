<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 

 
 
$intervalId   = $_POST['interval_Id'];
$custid       = $_POST['customer_id'];
 
$sql = "SELECT * FROM `tblvehicleprevduedate` 
		WHERE `interval_id` = '$intervalId' 
		And `customer_id`= '$custid'";
echo $sql;
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	// echo "<pre>";
	// print_r($row);
	$lastDueDate = $row['last_due_date'];
	$vehicleId = $row['vehicle_id'];

	$sql1 = "UPDATE `tbl_gps_vehicle_payment_master` SET `next_due_date` = '$lastDueDate' 
			 WHERE `Vehicle_id`= '$vehicleId'  and `cust_id` = '$custid' AND `PlanactiveFlag` = 'Y'";
	echo $sql1;
	// echo "<br>";
	$result1 = mysql_query($sql1);
}
	echo '<div class="alert alert-success alert-dismissible small-alert" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong>Due Date Restore Successfully</strong> 
		</div>';
?>