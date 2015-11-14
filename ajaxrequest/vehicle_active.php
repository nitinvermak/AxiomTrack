<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$deviceId = mysql_real_escape_string($_POST['deviceId']);
$activeStatus = 'Y';
$sql = "UPDATE tbl_gps_vehicle_master SET activeStatus = '$activeStatus' WHERE device_id = '$deviceId'";
$result = mysql_query($sql);
error_reporting(0);
?>	