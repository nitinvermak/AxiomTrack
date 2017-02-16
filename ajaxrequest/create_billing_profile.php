<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
$cust_id = mysql_real_escape_string($_POST['cust_id']);
$paymentModeB = mysql_real_escape_string($_POST['paymentModeB']);
$billDeliveryModeB = mysql_real_escape_string($_POST['billDeliveryModeB']);
$paymentPeriodB = mysql_real_escape_string($_POST['paymentPeriodB']);
$pickupModeB = mysql_real_escape_string($_POST['pickupModeB']);
$customerTypeB = mysql_real_escape_string($_POST['customerTypeB']);


	$checkUsers = mysql_query("SELECT `custId` FROM `billingprofile` WHERE `custId`= '$cust_id'");
	if(mysql_num_rows($checkUsers)<=0)
	{
		$query = mysql_query("INSERT INTO `billingprofile` SET `custId` = '$cust_id', `paymentMode` = '$paymentModeB', `billDeliveryMode` = '$billDeliveryModeB', `paymentPeriod` = '$paymentPeriodB', `paymentPickupMode` = '$pickupModeB', `customerType` = '$customerTypeB'");		
		echo "<span style='color:green; font-weight:bold'>Billing Profile added Successfully</span>";
	}
	else
	{
		echo "<span style='color:red; font-weight:bold'>Billing Profile already exists</span>";
	}

?>
