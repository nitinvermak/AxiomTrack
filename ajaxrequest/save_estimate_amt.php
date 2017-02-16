<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$paymentId = mysql_real_escape_string($_POST['paymentId']);
$enter_payble_amt = mysql_real_escape_string($_POST['enter_payble_amt']);
$hiddenInvoiceID = mysql_real_escape_string($_POST['hiddenInvoiceID']);
$total_amt = mysql_real_escape_string($_POST['total_amt']);
$remaining_amt1 = mysql_real_escape_string($_POST['adjestmentAmt']);
$pending_payable_amt = mysql_real_escape_string($_POST['pending_payable_amt']);
$remaining_amt = $remaining_amt1 - $enter_payble_amt;

// echo "string".$remaining_amt;
// exit();
// echo "pid".$paymentId."<br>user provoid amt".$enter_payble_amt."<br>invoice id".$hiddenInvoiceID."<br>total amt".$total_amt."<br>adustment amt".$remaining_amt."<br>pending amt".$pending_payable_amt;

// Calculate Previous Received Amount
$sql = "SELECT SUM(`amount`) as previousamt FROM `paymentestimateadadjustment` 
		WHERE `estimateId`=".$hiddenInvoiceID;
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
$total_previous_received_amt = $row['previousamt'];

$calulate_total = $total_previous_received_amt + $enter_payble_amt;
// echo $calulate_total;
// echo "<br>";
// echo $total_amt;
// exit();

// if payment is partial execute this query
if(($pending_payable_amt > $enter_payble_amt || $remaining_amt > $enter_payble_amt) && $total_amt != $calulate_total){
	$sql = "INSERT INTO `paymentestimateadadjustment` SET `paymentId`= '$paymentId', 
		    `estimateId` = '$hiddenInvoiceID', `amount` = '$enter_payble_amt'";
	$result = mysql_query($sql);
	// echo $sql;
	// echo "<br>";

	$sql_remainging = "UPDATE `quickbookpaymentmethoddetailsmaster` 
					   SET `adjustmentAmt`='$remaining_amt' 
					   WHERE `PaymentID` = '$paymentId'";
	// echo $sql_remainging;
	// echo "<br>";
	$result_remainging = mysql_query($sql_remainging);
 
    // change invoiceFlag when payment partial receive
	$sql_invoice_master = "UPDATE `tbl_invoice_master` SET `invoiceFlag`='P' 
						   WHERE `invoiceId`=".$hiddenInvoiceID;
	// echo "<br>".$sql_invoice_master;					   
	$result_invoice_master = mysql_query($sql_invoice_master );

	echo "<div class='alert alert-success alert-dismissible' role='alert'>
		  	<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		  	<strong><i class='fa fa-check' aria-hidden='true'></i> Partial Payment Received</strong> 
		  </div>  ";
}
else if(($pending_payable_amt == $enter_payble_amt || $remaining_amt == $enter_payble_amt) && $total_amt == $calulate_total){
	$sql = "INSERT INTO `paymentestimateadadjustment` SET `paymentId`= '$paymentId ', 
		    `estimateId` = '$hiddenInvoiceID', `amount` = '$enter_payble_amt'";
	$result = mysql_query($sql);
	// echo $sql;
	// echo "<br>";

	$sql_remainging = "UPDATE `quickbookpaymentmethoddetailsmaster` 
					   SET `adjustmentAmt`='$remaining_amt' 
					   WHERE `PaymentID` = '$paymentId'";
	// echo  $sql_remainging;
	// echo "<br>";
	$result_remainging = mysql_query($sql_remainging);

	// change invoiceFlag when payment full receive
	 $sql_invoice_master = "UPDATE `tbl_invoice_master` SET `invoiceFlag`='Y' 
						   		WHERE `invoiceId`=".$hiddenInvoiceID;
	$result_invoice_master = mysql_query($sql_invoice_master );

	echo "<div class='alert alert-success alert-dismissible' role='alert'>
		  	<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		  	<strong><i class='fa fa-check' aria-hidden='true'></i> Full Payment Received</strong> 
		  </div>  ";
}
else{
	echo "<div class='alert alert-danger alert-dismissible' role='alert'>
		  	<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		  	<strong>
		  		<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> 
		  		Invalid Amount
		  	</strong> 
		  </div>  ";
}
?>  
            
