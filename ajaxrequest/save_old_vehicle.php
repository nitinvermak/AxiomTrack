<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$vehicleId = mysql_real_escape_string($_POST['vehicleId']);
$vehicle_no = mysql_real_escape_string($_POST['vehicle_no']); 
$technician = mysql_real_escape_string($_POST['technician']);
$mobile_no = mysql_real_escape_string($_POST['mobile_no']);
$device = mysql_real_escape_string($_POST['device']);
$imei = mysql_real_escape_string($_POST['imei']);
$dmodel = mysql_real_escape_string($_POST['dmodel']);
$server_details = mysql_real_escape_string($_POST['server_details']);
$insatallation_date = mysql_real_escape_string($_POST['insatallation_date']);

$sql = "update tbl_gps_vehicle_master set vehicle_no='$vehicle_no', 
		techinician_name='$technician', mobile_no='$mobile_no', 
		device_id='$device', imei_no='$imei', model_name='$dmodel', 
		server_details='$server_details', installation_date='$insatallation_date'  
		where id=" .$vehicleId;
// echo $sql;
$result = mysql_query($sql);

$update_sim = "update tblsim set status_id='1' where id='$mobile_no'";
$querysim = mysql_query($update_sim);
// echo $update_sim;
$update_Device = "update tbl_device_master set status = '1' where id='$device'";
// echo $update_Device;
$queryex = mysql_query($update_Device);

if($result && $querysim && $queryex){
	echo '<div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Vehicle Update Successfully !
        </div>';
}
else{
	echo '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Vehicle Update Failed !
        </div>';
}
?>                
