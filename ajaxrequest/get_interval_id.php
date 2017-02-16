<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$generated_date = mysql_real_escape_string($_POST['generated_date']);
// echo $generated_date;
$array = explode("-", $generated_date);
// echo "<pre>";
// print_r($array);
$year = $array[0];
$month = $array[1];
$sql = mysql_query("SELECT `intervalId` FROM `tblesitmateperiod` WHERE `IntervelYear`='$year' 
					AND `intervalMonth`='$month'");
$row = mysql_fetch_assoc($sql);
$intervalId = $row['intervalId'];
?>                
<input type="hidden" name="interval_Id" id="interval_Id" value="<?= $intervalId; ?>">