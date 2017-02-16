<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$repairType = mysql_real_escape_string($_POST['repairType']);
$oldMobileNo = mysql_real_escape_string($_POST['oldMobileNo']);
$model = mysql_real_escape_string($_POST['model']);
$newMobile = mysql_real_escape_string($_POST['newMobile']);
/*echo $model;*/
error_reporting(0);
if($repairType == 1) // Sim Change
{
	sendConfigSms($model, $newMobile, '');
	echo '<p style="color:green; font-weight:bold; text-align:center;">Command Send Successfully !</p>';
}
else if($repairType == 2) // Device Change
{
	sendConfigSms($model, $oldMobileNo, '');
	echo '<p style="color:green; font-weight:bold; text-align:center;">Command Send Successfully !</p>';
}
else if($repairType == 3) // Both Change
{
	sendConfigSms($model, $newMobile, '');
	echo '<p style="color:green; font-weight:bold; text-align:center;">Command Send Successfully !</p>';
}
?>

    
    
