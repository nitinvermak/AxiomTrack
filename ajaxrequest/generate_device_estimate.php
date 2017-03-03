<?php
include("../includes/config.inc.php"); 
$jsonData = $_POST['postData'];
// echo "<pre>";
// print_r($jsonData);
// exit();
$decode_Json_Data = $jsonData['PostData'];
// echo "<pre>";
// print_r($decode_Json_Data);
$total_device_amt = 0;
$today = date('Y-m-d H:i:s');
$due_date = date( "Y-m-d", strtotime( "$today +3 day" ) );
foreach ($decode_Json_Data as $array) {
   	// echo "<pre>";
   	// print_r($array);
	$device_amt =  $array['device_amt'];
	$customer_id =  $array['customer_id'];
	$vehicleId = $array['vehicleId'];

	$total_device_amt += $device_amt; 

	$sql_update_status = "UPDATE `tbl_gps_vehicle_payment_master` SET `device_status_gen_status` = 'Y' 
					  	  WHERE `cust_id`= '$customer_id'
					      AND `Vehicle_id`= '$vehicleId'";
	$result = mysql_query($sql_update_status);

}
// exit();
$sql_invoice_master = "INSERT INTO `tbl_invoice_master` SET `customerId`='$customer_id', 
                       `generatedAmount`='$total_device_amt', `paymentStatusFlag`='A',
                       `invoiceFlag`='N', `invoiceType` ='B', `generateDate`='$today',
                       `intervalId`='0', `dueDate`='$due_date'";
$result = mysql_query($sql_invoice_master);




echo "<div class='alert alert-warning alert-dismissible' role='alert' style='max-width:500px;'>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span></button>
      <strong>Estimate Generated Successfully !</strong> 
    </div>";
?>
    