<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$deviceId = mysql_real_escape_string($_POST['deviceId']);
$activeStatus = 'Y';
$sql = "UPDATE tbl_gps_vehicle_master SET activeStatus = '$activeStatus' WHERE id = '$deviceId'";
$result = mysql_query($sql);
if($result){
	echo "<h3 class='red'>Vehicle Active Successfully</h3>";
}
error_reporting(0);
?>	