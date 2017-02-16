<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$deviceId = mysql_real_escape_string($_POST['deviceId']);
$branch = mysql_real_escape_string($_POST['branch']);
$technician = mysql_real_escape_string($_POST['technician']);
// echo "Mobile:".$deviceId."<br>branch:".$branch."<br>".$technician;
// exit();
$UpdateDevice = "Update tbl_device_master set status='0' 
                 where id ='$deviceId'";
$result = mysql_query($UpdateDevice);

$updateBranch = "Update tbl_device_assign_branch set branch_id = '$branch'  
                 where device_id ='$deviceId'";
$result = mysql_query($updateBranch);


$updateAssignTechnician = "Update tbl_device_assign_technician set technician_id = '$technician' 
                           where device_id = '$deviceId'";
$result = mysql_query($updateAssignTechnician);

$removeMobile = "UPDATE `tbl_gps_vehicle_master` SET device_id='0', imei_no = '0'  
                 WHERE device_id='$deviceId'";
$result = mysql_query($removeMobile);

if($result){
  echo '<div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Device Change Successfully !
        </div>';
}
else{
  echo '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Device Change Failed !
        </div>';
}
?>
