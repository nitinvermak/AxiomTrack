<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$estimateId = mysql_real_escape_string($_POST['estimateId']);
// exit();
$sql = "UPDATE `tbl_invoice_master` SET `invoiceFlag` = 'D' WHERE `invoiceId` = ".$estimateId;
echo $sql;
$result = mysql_query($sql);
$sql1 = "UPDATE `tbl_payment_breakage` SET `status` = 'D' WHERE `invoiceId` =".$estimateId;
echo $sql1;
$result1 = mysql_query($sql1);
if ($result) {
  echo '<div class="alert alert-danger alert-dismissible small-alert" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Estimate Deleted !</strong> 
        </div>';
}
?>