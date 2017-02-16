<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$userId = mysql_real_escape_string($_POST['userId']);

$sql = "UPDATE `tbluser` SET `User_Status`='A' WHERE `id`=".$userId;
$result = mysql_query($sql);
if($result){
	echo '<div class="alert alert-success small-alert alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> User Active !
		 </div>';
}
?>