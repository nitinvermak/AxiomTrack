<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$customerId = mysql_real_escape_string($_POST['customerId']);
$vehicleNo = mysql_real_escape_string($_POST['vehicleNo']);
$technician = mysql_real_escape_string($_POST['technician']);
$mobileNo = mysql_real_escape_string($_POST['mobileNo']);
$imeiNo = mysql_real_escape_string($_POST['imeiNo']);
$deviceId = mysql_real_escape_string($_POST['deviceId']);
$model = mysql_real_escape_string($_POST['model']);
$server = mysql_real_escape_string($_POST['server']);
$insatallationDate = mysql_real_escape_string($_POST['insatallationDate']);

$queryArr = mysql_query("SELECT `device_id`, `mobile_no` FROM `tbl_gps_vehicle_master` 
						 WHERE `device_id`= '$deviceId' 
						 AND `mobile_no`='$mobileNo'");
if(mysql_num_rows($queryArr)<=0){
	$query = mysql_query("insert into tbl_gps_vehicle_master set customer_Id='$customerId',				            	   			  vehicle_no='$vehicleNo', techinician_name='$technician', 
						  mobile_no='$mobileNo', device_id='$deviceId', imei_no='$imeiNo', 
						  model_name='$model', server_details='$server', 
						  installation_date='$insatallationDate', paymentActiveFlag='N'");	

	$update_sim = "update tblsim set status_id='1' where id='$mobileNo'";
	$querysim = mysql_query($update_sim);	

	$update_Device = "update tbl_device_master set status = '1' where id='$deviceId'";
	$queryex = mysql_query($update_Device);
	
	if($query){
		echo 	'<div class="alert alert-success small-alert alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> 
				  Vehicle Added Successfully !
				</div>';
	}
}
else{
	echo 	'<div class="alert alert-danger small-alert alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> 
			  Vehicle already exist !
			</div>';
}

?>                
