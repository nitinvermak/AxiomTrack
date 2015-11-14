<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$deviceId = mysql_real_escape_string($_POST['deviceId']);
$activeStatus = 'N';
$sql = "UPDATE tbl_gps_vehicle_master SET activeStatus = '$activeStatus' WHERE device_id = '$deviceId' and mobile_no = 0";
/*echo $sql;*/
$result = mysql_query($sql);
$num_rows = mysql_affected_rows($result);
echo 'afasfd'.$num_rows;
if($num_rows == 1)
	{
		echo "<span style ='color:green'>Vehicle Status Inactive</span>";
	}
else
	{
		echo "<span style ='color:red'>Please Update Sim Status</span>";
	}
error_reporting(0);
?>	