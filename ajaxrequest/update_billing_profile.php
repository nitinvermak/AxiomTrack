<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");

$billId = mysql_real_escape_string($_POST['billId']);
$cust_id = mysql_real_escape_string($_POST['cust_id']);
$paymentModeB = mysql_real_escape_string($_POST['paymentModeB']);
$billDeliveryModeB = mysql_real_escape_string($_POST['billDeliveryModeB']);
$paymentPeriodB = mysql_real_escape_string($_POST['paymentPeriodB']);
$pickupModeB = mysql_real_escape_string($_POST['pickupModeB']);
$customerTypeB = mysql_real_escape_string($_POST['customerTypeB']);

$query = mysql_query("UPDATE `billingprofile` SET `custId` = '$cust_id', `paymentMode` = '$paymentModeB', `billDeliveryMode` = '$billDeliveryModeB', `paymentPeriod` = '$paymentPeriodB', `paymentPickupMode` = '$pickupModeB', `customerType` = '$customerTypeB' WHERE `billId` = '$billId' ");		

echo "<span style='color:green; font-weight:bold'>Billing Profile Updated Successfully</span>";
	
?>
