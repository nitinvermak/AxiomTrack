<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$deviceId = mysql_real_escape_string($_POST['deviceId']);
$devicestatus = mysql_real_escape_string($_POST['devicestatus']);
$sql = "Update tbl_device_master set status = '$devicestatus' Where id = '$deviceId'";
$result = mysql_query($sql);
if($result){
  echo '<div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Device Status Changed !
        </div>';
}
else{
  echo '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Device Status Change Failed !
        </div>';
}
?>
