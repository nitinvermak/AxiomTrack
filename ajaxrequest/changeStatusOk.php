<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");

$customerId = mysql_real_escape_string($_POST['cust_id']);

$sql ="UPDATE `tbl_customer_master` SET `customerStatus`='Ok' WHERE `cust_id`=".$customerId;

	$result = mysql_query($sql);
	echo "<span style='color:green; font-weight:bold;'>Customer Status Changed</span>";
?>
