<?php 
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
$service_branch = mysql_real_escape_string($_POST['service_branch']);
$service_area_mgr = mysql_real_escape_string($_POST['service_area_mgr']);
$service_exe = mysql_real_escape_string($_POST['service_exe']);

if($service_branch !="" && $service_area_mgr != "" && $service_exe != "")
{

	$sql = "UPDATE tbl_assign_customer_branch SET cust_id = '$cust_id', service_branchId = '$service_branch', service_area_manager = '$service_area_mgr', service_executive = '$service_exe' WHERE cust_id = '$cust_id'";
	$query = mysql_query($sql);
		if($query)
			{
				echo "<p style='color:green; font-weight:bold;'>Branch Updated Successfully</p>";
			}
}
else
{
	echo "<p style='color:red; font-weight:bold;'>Please Select All Fields</p>";
}
?>
