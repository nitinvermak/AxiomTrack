<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$invId = mysql_real_escape_string($_POST['invId']);
$rupeeAmt = mysql_real_escape_string($_POST['rupeeAmt']);
$sql = "Update tbl_invoice_master Set discountedAmount = '$rupeeAmt' Where invoiceId ='$invId'";
$result = mysql_query($sql);
?>