<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$mobileNo = mysql_real_escape_string($_POST['mobileNo']);
$deviceModel = mysql_real_escape_string($_POST['deviceModel']);
error_reporting(0);
sendConfigSms($deviceModel, $mobileNo, '');
echo '<p style="color:green; font-weight:bold; text-align:center;">Command Send Successfully !</p>';
?>

    
    
