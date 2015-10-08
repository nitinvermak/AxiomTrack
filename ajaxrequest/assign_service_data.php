<?php 
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
$service_branch = mysql_real_escape_string($_POST['service_branch']);
$service_area_mgr = mysql_real_escape_string($_POST['service_area_mgr']);
$service_exe = mysql_real_escape_string($_POST['service_exe']);
/*echo $cust_id;*/
if($service_branch !="" && $service_area_mgr != "" && $service_exe != "")
{

	$sql = "Insert into tbl_assign_customer_branch set 	cust_id = '$cust_id', service_branchId = '$service_branch', service_area_manager = '$service_area_mgr', service_executive = '$service_exe'";
	$query = mysql_query($sql);
	$update = "UPDATE `tbl_customer_master` SET status = '1' Where cust_id=".$_REQUEST['cust_id'];
	/*echo $update;*/
	$change_status = mysql_query($update);
		if($query)
			{
				echo "<p style='color:green; font-weight:bold;'>Branch Assign Successfully</p>";
			}
}
else
{
	echo "<p style='color:red; font-weight:bold;'>Please Select All Fields</p>";
}
?>
