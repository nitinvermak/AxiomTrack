<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$mobile = $_REQUEST['mobile']; 
$sql = "SELECT `r_id` FROM `register` WHERE `r_phone`='$mobile'";
$result = mysql_query($sql);
if(mysql_num_rows($result)<=0){

}
else{
  $row = mysql_fetch_assoc($result);
  echo "<p style='font-weight:bold;color:red; '>Mobile No. alreay exists User Id is <span style='color:blue;'>".$row['r_id']."</span></p>";
}
?>