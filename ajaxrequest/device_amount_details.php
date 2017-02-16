<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$paymentId = mysql_real_escape_string($_POST['paymentId']); 
error_reporting(0);
$sql = "SELECT A.PaymentID as PaymentId, A.CashAmount as CashAmt, 
		B.chequeAmount as ChequeAmt, C.onlineAmount as onlineAmt,
		A.adjustmentAmt as adjustmentAmt
		FROM quickbookpaymentmethoddetailsmaster as A 
		Left OUTER JOIN quickbookpaymentcheque B 
		On A.ChequeID = B.Id 
		Left OUTER JOIN quickbookpaymentonlinetransfer as C 
		On A.OnlineTransferId = C.Id
		WHERE A.PaymentID = ".$paymentId;
$sqlresult = mysql_query($sql);
$result = mysql_fetch_assoc($sqlresult);
$cashAmt = $result['CashAmt'];
$chequeAmt = $result['ChequeAmt'];
$onlineAmt = $result['onlineAmt'];

$adjustmentamt = $result['adjustmentAmt'];
$totalamount = $cashAmt + $chequeAmt + $onlineAmt;
// echo $totalamount;
?>	
<strong>Total Amt:</strong> <input type='text' name='receiveAmt' id='receiveAmt' value='<?php echo $totalamount; ?>' readonly />

<strong>Remaining Amt:</strong> <input type='text' name='adjestmentAmt' value='<?= $adjustmentamt ?>' id='adjestmentAmt' readonly />	

<strong>Payable Amt:</strong> <input type='text' name='payble_amt' id='payble_amt' />	
               