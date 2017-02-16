<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$mobileNo = mysql_real_escape_string($_POST['mobileNo']);
$branch = mysql_real_escape_string($_POST['branch']);
$technician = mysql_real_escape_string($_POST['technician']);
// echo "Mobile:".$mobileNo."<br>branch:".$branch."<br>".$technician;

$updateSimMaster = "Update tblsim set status_id='0' 
                    where id ='$mobileNo'";
$result = mysql_query($updateSimMaster);
    
/*echo $updateSimMaster;*/
$updateBranch = "Update tbl_sim_branch_assign set branch_id = '$branch'  
                 where sim_id ='$mobileNo'";
$result = mysql_query($updateBranch);

/*echo $updateBranch;*/
$updateAssignTechnician = "Update tbl_sim_technician_assign set technician_id = '$technician' 
                          where sim_id = '$mobileNo'";
$result = mysql_query($updateAssignTechnician);

/*echo $updateAssignTechnician;*/
$removeMobile = "UPDATE `tbl_gps_vehicle_master` SET mobile_no='0'  
                WHERE mobile_no='$mobileNo'";
$result = mysql_query($removeMobile);
if($result){
  echo '<div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Mobile No. Change Successfully !
        </div>';
}
else{
  echo '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Mobile No. Change Failed !
        </div>';
}
?>
