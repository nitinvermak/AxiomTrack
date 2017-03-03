<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$invId = mysql_real_escape_string($_POST['invId']);
$rupeeAmt = mysql_real_escape_string($_POST['rupeeAmt']);
$sql = "Update tbl_invoice_master Set discountedAmount = '$rupeeAmt' Where invoiceId ='$invId'";
// exit();
$result = mysql_query($sql);
if($result){
	echo '<div class="alert alert-success small-alert alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Success!</strong> Discount Amount Saved
		  </div>';
}
else{
	echo '<div class="alert alert-danger small-alert alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Error!</strong> Discount Amount Save Failed
		  </div>';
}
?>