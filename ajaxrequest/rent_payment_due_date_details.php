<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$custId = mysql_real_escape_string($_POST['custId']);
$dueDate = mysql_real_escape_string($_POST['dueDate']);
error_reporting(0);
if($dueDate != "")
{
	$queryArr = mysql_query("select * from tblgeneratenextduedate where `custid`='$custId'");
	if(mysql_num_rows($queryArr)<=0)
	{
		$sql = "INSERT INTO `tblgeneratenextduedate` SET `custid`='$custId', `nextduedate` = '$dueDate'";
		$result = mysql_query($sql);
		echo "<span style='color:green; font-weight:bold;'>Due Date Generated</span>";
	}
	else
	{
		$sqlUpdate = "Update `tblgeneratenextduedate` SET `nextduedate` = '$dueDate' Where `custid`='$custId'";
		$resultUpdate = mysql_query($sqlUpdate);
		echo "<span style='color:green; font-weight:bold;'>Due Date Generated</span>";
	}
}
else
{
	echo "<span style='color:red; font-weight:bold;'>Please Provide Due Date</span>";
}
?>		
