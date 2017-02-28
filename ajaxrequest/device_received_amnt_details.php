<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
$receivedAmt = mysql_real_escape_string($_POST['receivedAmt']);
$PrereceivedAmt = mysql_real_escape_string($_POST['PrereceivedAmt']);
$vehicleId = mysql_real_escape_string($_POST['vehicleId']);
$adjustmentAmt = mysql_real_escape_string($_POST['adjustmentAmt']);
$paymentId = mysql_real_escape_string($_POST['paymentId']);
$pendingAmt = mysql_real_escape_string($_POST['pending_Amt']);
$totalRecAmt = $receivedAmt + $PrereceivedAmt;
/*echo $adjustmentAmt.'asdfhgasjhdf';*/
if($paymentId != 0 && $receivedAmt != 0)
{
	if($pendingAmt != $receivedAmt){
		if($receivedAmt <= $adjustmentAmt){
			$adjustAmt = ($adjustmentAmt - $receivedAmt);

			// generate Estimate Id 
			$sql_est = "INSERT INTO `tbl_invoice_master` SET `customerId`='$cust_id', 
						`generatedAmount`='$pendingAmt', `paidAmount`='$receivedAmt',
						`invoiceType`='B',`invoiceFlag`='P',`paymentStatusFlag`='A', `generateDate`=Now(), 
						`dueDate`=Now()";
			$result_est = mysql_query($sql_est);
			$estimate_id = mysql_insert_id();

			$sql = "INSERT INTO `devicepayment` SET `vehicleId`='$vehicleId', `estimateId`='$estimate_id', 
					`deviceamt`='$receivedAmt', `paymentId`='$paymentId'";

			// $sql = "UPDATE `tbl_gps_vehicle_payment_master` SET 
			// 		`receivedAmt` = '$receivedAmt', `devicePaymentStatus` = 'P'
			// 	 	WHERE `Vehicle_id`='$vehicleId'";
			/*echo $sql;*/
			$result = mysql_query($sql);

			$sql1 = "UPDATE `tbl_gps_vehicle_master` SET `devicePaymentStatus`='P' 
					 WHERE `id`='$vehicleId'";
			$result1 = mysql_query($sql1);

			$sqlUpdate = "UPDATE `quickbookpaymentmethoddetailsmaster` SET `adjustmentAmt` = '$adjustAmt' 
						 WHERE `PaymentID` = '$paymentId'";
			$resultUpdate = mysql_query($sqlUpdate);
			
			echo '<div class="alert alert-success small-alert alert-dismissible" role="alert">
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  	<strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Device Partial Amount Recieved !
				   </div>';	
		}
		else{
			echo '<div class="alert alert-danger small-alert alert-dismissible" role="alert">
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  	<strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong>Please Provide Valid Amount !
				   </div>';
		}
	}
	elseif($pendingAmt == $receivedAmt){
		if($receivedAmt <= $adjustmentAmt){
			$adjustAmt = ($adjustmentAmt - $receivedAmt);
			// generate Estimate Id 
			$sql_est = "INSERT INTO `tbl_invoice_master` SET `customerId`='$cust_id', 
						`generatedAmount`='$pendingAmt', `paidAmount`='$receivedAmt',
						`invoiceType`='B',`invoiceFlag`='P',`paymentStatusFlag`='A', `generateDate`=Now(), 
						`dueDate`=Now()";
			$result_est = mysql_query($sql_est);
			$estimate_id_full = mysql_insert_id();

			$sql = "INSERT INTO `devicepayment` SET `vehicleId`='$vehicleId', `estimateId`='$estimate_id_full', `deviceamt`='$receivedAmt', 
					`paymentId`='$paymentId'";
			// $sql = "UPDATE `tbl_gps_vehicle_payment_master` SET `receivedAmt` = '$receivedAmt',
			// 		`devicePaymentStatus` = 'F'
			// 	 	WHERE `Vehicle_id`='$vehicleId'";
			/*echo $sql;*/
			$result = mysql_query($sql);
			
			$sql1 = "UPDATE `tbl_gps_vehicle_master` SET `devicePaymentStatus`='F' 
					 WHERE `id`='$vehicleId'";
			$result1 = mysql_query($sql1);

			$sqlUpdate = "UPDATE `quickbookpaymentmethoddetailsmaster` SET `adjustmentAmt` = '$adjustAmt' 
						 WHERE `PaymentID` = '$paymentId'";
			$resultUpdate = mysql_query($sqlUpdate);
			echo '<div class="alert alert-success small-alert alert-dismissible" role="alert">
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  	<strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Device Amount Recieved !
				   </div>';	
		}
		else{
			echo '<div class="alert alert-danger small-alert alert-dismissible" role="alert">
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  	<strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong>Please Provide Valid Amount !
				   </div>';	
		}
	}
}
else{
	// echo "<span style='color:red; font-weight:bold;'>Please Select Payment Id or Provide Received Amount !</span>";
	echo '<div class="alert alert-danger small-alert alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Please Select Payment Id or Provide Received Amount !
		  </div>';
}
?>		
