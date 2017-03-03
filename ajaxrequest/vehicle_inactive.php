<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$deviceId = mysql_real_escape_string($_POST['deviceId']);
$cust_id = mysql_real_escape_string($_POST['cust_id']);
$vehicle_id = mysql_real_escape_string($_POST['vehicle_id']);

/* ============= Generate Rent===========*/
// get Rent Amount
$sql =mysql_query("SELECT B.plan_rate as amt 
					FROM tbl_gps_vehicle_payment_master as A 
					INNER JOIN tblplan as B 
					ON A.device_rent_amt = B.id
					WHERE A.cust_id = '$cust_id' 
					AND A.Vehicle_id ='$vehicle_id'");

$result = mysql_fetch_assoc($sql);
$device_rent = $result['amt'];

$start_date = next_due_date($cust_id);
$end_date =  date("Y-m-d");

$due_date = date('Y-m-d', strtotime($end_date. ' + 15 days'));
// echo "duedate: ".$due_date ;
// exit();
$date1 = date_create($start_date);
$date2 = date_create($end_date);

$diff=date_diff($date1, $date2);
$days =  $diff->format("%a");

$calculate_rent = $device_rent/30 * $days;
// echo $calculate_rent;

// generate Invoice id
$sql_invoice_id = mysql_query("SELECT MAX(`invoiceId`) AS invoiceId FROM `tbl_invoice_master` ");
$row = mysql_fetch_assoc($sql_invoice_id);
$invoice_id = $row['invoiceId']+1;

$sql_breakage = "INSERT INTO `tbl_payment_breakage` SET `invoiceId`='$invoice_id',
                 `typeOfPaymentId` = 'A', `vehicleId`='$vehicle_id', `amount`='$calculate_rent', 
                 `start_date`='$start_date', `end_date`='$end_date',`status`='A'";
$result = mysql_query($sql_breakage);
echo "cmd".$sql_breakage;
echo "<br>";

$sql_invoice_master = "INSERT INTO `tbl_invoice_master` SET `customerId`='$cust_id', 
                       `generatedAmount`='$calculate_rent', `paymentStatusFlag`='A',
                       `invoiceFlag`='N', `invoiceType` ='A', `generateDate`='Now()',
                       `dueDate`='$due_date'";
$result = mysql_query($sql_invoice_master);

/*============ Inactive Vehicle ===========*/
$activeStatus = 'N';
$sql = "UPDATE tbl_gps_vehicle_master SET activeStatus = '$activeStatus' WHERE id = '$deviceId'";
// echo $sql;
$result = mysql_query($sql);
if($result){
	echo "<h3 class='red'>Vehicle Inactive Successfully !</h3>";
}
error_reporting(0);
?>	