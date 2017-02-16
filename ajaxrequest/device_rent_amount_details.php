<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$paymentId = mysql_real_escape_string($_POST['paymentId']);
$invoiceId = mysql_real_escape_string($_POST['invoiceId']);
$disAmt = mysql_real_escape_string($_POST['disAmt']);
$adjustmentAmt = mysql_real_escape_string($_POST['adjustmentAmt']);
$availableAdjustmentAmt = mysql_real_escape_string($_POST['adjestmentAmt']);
$total_amt = mysql_real_escape_string($_POST['total_amt']);
$prev_rcd_amt = mysql_real_escape_string($_POST['prev_rcd_amt']);
$calAmt = $prev_rcd_amt + $adjustmentAmt;
// echo $prev_rcd_amt;
// echo "<br>";
// echo $total_amt;
// echo "<br>";
// echo $calAmt;
if($calAmt != $total_amt){
	if($adjustmentAmt <= $availableAdjustmentAmt){
		$availableAdjustmentAmtTotal = ($availableAdjustmentAmt - $adjustmentAmt);
		$sql = "UPDATE `tbl_invoice_master` SET `discountedAmount` = '$disAmt', `paidAmount` = '$calAmt', 
				`paymentId` = '$paymentId' WHERE `invoiceId` =".$invoiceId;
		// echo "par".$sql;
		// exit();
		$result = mysql_query($sql);

		$sqlUpdate = "UPDATE `quickbookpaymentmethoddetailsmaster` 
					  SET `adjustmentAmt` = '$availableAdjustmentAmtTotal' 
					  WHERE `PaymentID` = '$paymentId'";
		$resultUpdate = mysql_query($sqlUpdate);
		if($resultUpdate){
			echo '<div class="alert alert-success small-alert alert-dismissible" role="alert">
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  	<strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Partial Amount Recieved !
				  </div>';
		}
	}
}
elseif ($calAmt == $total_amt) {
	if($adjustmentAmt <= $availableAdjustmentAmt){
		$availableAdjustmentAmtTotal = ($availableAdjustmentAmt - $adjustmentAmt);
		$sql = "UPDATE `tbl_invoice_master` SET `discountedAmount` = '$disAmt', `paidAmount` = '$calAmt', 
				`paymentId` = '$paymentId', `paymentStatusFlag`= 'Y' WHERE `invoiceId` =".$invoiceId;
				// echo $sql;
		// echo $sql;
		// exit();
		$result = mysql_query($sql);

		$sqlUpdate = "UPDATE `quickbookpaymentmethoddetailsmaster` SET `adjustmentAmt` = '$availableAdjustmentAmtTotal' 
					  WHERE `PaymentID` = '$paymentId'";
		$resultUpdate = mysql_query($sqlUpdate);
		if($resultUpdate){
			echo '<div class="alert alert-success small-alert alert-dismissible" role="alert">
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  	<strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Device Amount Recieved !
				  </div>';
		}
	}
}
?>		

