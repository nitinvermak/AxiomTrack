<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$ticket = mysql_real_escape_string($_POST['ticket']);
$description = mysql_real_escape_string($_POST['description']);
$kmTravel = mysql_real_escape_string($_POST['kmTravel']);
$fare = mysql_real_escape_string($_POST['fare']);
$amount = mysql_real_escape_string($_POST['amount']);
$users = mysql_real_escape_string($_POST['users']);

error_reporting(0);
if($ticket != '' && $kmTravel != '' && $fare != '' && $amount != '')
{
	$sql = "INSERT INTO `tblconveyance` SET `ticketId` = '$ticket', `executiveId`= '$users', `kmTravelled` = '$kmTravel', 
			`fare` = '$fare', `totalAmt` = '$amount'";
	$result = mysql_query($sql);
	
	$sqlUpdate = "UPDATE `tbl_ticket_assign_technician` SET `conveyenceStatus` = 'Y' WHERE `ticket_id` = '$ticket'";
	$resultUpdate = mysql_query($sqlUpdate);
	
	echo "<p style='color:green; font-weight:bold;'>Conveyance Added!</p>";
}
else
{
	echo "<p style='color:red; font-weight:bold;'>Please Fill all Fields !</p>";
}

?>
