<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$simId = mysql_real_escape_string($_POST['simId']);
$status = mysql_real_escape_string($_POST['status']);

$sql = "Update tblsim set status_id = '$status' Where id ='$simId '";
$result = mysql_query($sql);
if($result){
  echo '<div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Sim Status Changed !
        </div>';
}
else{
  echo '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Sim Status Change Failed !
        </div>';
}
?>
