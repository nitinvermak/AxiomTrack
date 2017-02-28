<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$mobile = mysql_real_escape_string($_POST['mobile']);
$sql = mysql_query("SELECT `Company_Name` FROM `tblcallingdata` WHERE `Mobile`='$mobile'");
if(mysql_num_rows($sql)<=0){
	echo "<span style='color:green; font-weight:bold;'>
			<i class='fa fa-check-circle' aria-hidden='true'></i> Mobile No. available
		  </span>";
}
else{
	echo "<span style='color:red; font-weight:bold;'>
			<i class='fa fa-exclamation-circle' aria-hidden='true'></i>
			Mobile No. already exits
		 </span>";
}
?>