<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 

$returnCode= 0;
$invoiceId = mysql_real_escape_string($_POST['hiddenInvoiceID']);
/*Cash payment*/
$cashAmount = mysql_real_escape_string($_POST['cashAmount']);
/*Cheque*/
$chequeNo = mysql_real_escape_string($_POST['chequeNo']);
$chequeDate = mysql_real_escape_string($_POST['chequeDate']);  
$bankname = mysql_real_escape_string($_POST['bank']); 
$amountCheque = mysql_real_escape_string($_POST['amountCheque']);
$depositDate = mysql_real_escape_string($_POST['depositDate']);
/*Online Tranfer*/
$onlineTransferAmount = mysql_real_escape_string($_POST['onlineTransferAmount']);
$refNo = mysql_real_escape_string($_POST['refNo']);
/*Other Details*/
$revievingDate = mysql_real_escape_string($_POST['revievingDate']);
$remarks = mysql_real_escape_string($_POST['remarks']);
$recievedby = mysql_real_escape_string($_POST['recievedby']);
$confirmby = mysql_real_escape_string($_POST['confirmby']);
$invoice_payable_amount = mysql_real_escape_string($_POST['invoice_payable_amount']);
$invoice_partial_paid_amount = mysql_real_escape_string($_POST['invoice_partial_paid_amount']);

$total_pay_amt = $cashAmount + $amountCheque + $onlineTransferAmount;

if(isset($_POST['cash']) == False && ($_POST['cheque']) == False && ($_POST['onlineTransfer'])== True){
    $returnCode = 1;        
}
if(isset($_POST['cash']) == False && ($_POST['cheque']) == True && ($_POST['onlineTransfer'])== False){
    $returnCode = 2;        
}
if(isset($_POST['cash']) == False && ($_POST['cheque']) == True && ($_POST['onlineTransfer'])== True){
    $returnCode = 3;        
}
if(isset($_POST['cash']) == True && ($_POST['cheque']) == False && ($_POST['onlineTransfer'])== False){
    $returnCode = 4;        
}
if(isset($_POST['cash']) == True && ($_POST['cheque']) == False && ($_POST['onlineTransfer'])== True){
    $returnCode = 5;        
}
if(isset($_POST['cash']) == True && ($_POST['cheque']) == True && ($_POST['onlineTransfer'])== False){
    $returnCode = 6;        
}
if(isset($_POST['cash']) == True && ($_POST['cheque']) == True && ($_POST['onlineTransfer'])== True){
    $returnCode = 7;        
}
if(isset($_POST['cash']) == False && ($_POST['cheque']) == False && ($_POST['onlineTransfer'])== False){
    $returnCode = 8;        
}
switch ($returnCode) {
    case 1:
        $sql = "Insert into paymentonlinetransfer Set RefNo = '$refNo', Amount = '$onlineTransferAmount'";
		/*echo $sql;*/
        //$result = mysql_query($sql);
        $OnlineTransferId = mysql_insert_id();
        break;
    case 2:
        $sql = "Insert into PaymentCheque Set ChequeNo = '$chequeNo', ChequeDate = '$chequeDate', 
				Bank = '$bankname', DepositDate = '$depositDate', Amount = '$amountCheque'";
		echo $sql;
		exit();
        $result = mysql_query($sql);
        $ChequeID = mysql_insert_id(); 
        break;
    case 3:
        // Cheque Payment
        $sql = "Insert into PaymentCheque Set ChequeNo = '$chequeNo', ChequeDate = '$chequeDate', 
                Bank = '$bankname', DepositDate = '$depositDate', Amount = '$amountCheque'";
		/*echo $sql;*/
        $result = mysql_query($sql);
        $ChequeID = mysql_insert_id();
        //Online Payment
        // do nothing
        break;
    case 4:
        // Cash Payment
        // do nothing
        break;
    case 5:
        // Cash Payment
        // do nothing
        // Online Payment
        $sql = "Insert into paymentonlinetransfer Set RefNo = '$refNo', Amount = '$onlineTransferAmount'";
		/*echo $sql;*/
        $result = mysql_query($sql);
        $OnlineTransferId = mysql_insert_id();
    case 6:
        //Cash Payment
        // do nothing
        //Cheque Payment
        $sql = "Insert into PaymentCheque Set ChequeNo = '$chequeNo', ChequeDate = '$chequeDate', 
				Bank = '$bankname', DepositDate = '$depositDate', Amount = '$amountCheque'";
		/*echo $sql;*/
        $result = mysql_query($sql);
        $ChequeID = mysql_insert_id();
        // cash amount
        // do nothing
        break;
    case 7:
        // cash payment
        // do nothing
        //Cheque Payment
        $sql = "Insert into PaymentCheque Set ChequeNo = '$chequeNo', ChequeDate = '$chequeDate', 
                Bank = '$bankname', DepositDate = '$depositDate', Amount = '$amountCheque'";
		/*echo $sql;*/
        $result = mysql_query($sql);
        $ChequeID = mysql_insert_id();
        // Online Payment
        $sql = "Insert into paymentonlinetransfer Set RefNo = '$refNo', Amount = '$onlineTransferAmount'";
		/*echo $sql;*/
        $result = mysql_query($sql);
        $OnlineTransferId = mysql_insert_id();
        default:
        # code...
        break;
}
        $sql = "Insert into paymentmethoddetailsmaster Set ChequeID = '$ChequeID', CashAmount = '$cashAmount', OnlineTransferId = '$OnlineTransferId', 
                RecivedDate = '$revievingDate', Remarks = '$remarks' , RecievedBy = '$recievedby'";
							 
                $result = mysql_query($sql);
                $paymentId = mysql_insert_id();
				
		echo 'invoice_payable_amount='.$invoice_payable_amount;	
		echo 'invoice_partial_paid_amount='.$invoice_partial_paid_amount;
		$total_recieved_amount = $invoice_partial_paid_amount + $total_pay_amt;
		
		if(($invoice_payable_amount - $invoice_partial_paid_amount) > $total_pay_amt){
			$flagStatus ="Update tbl_invoice_master Set paymentStatusFlag = 'P', invoiceFlag = 'Y', 
						  paidAmount='$total_recieved_amount' Where invoiceId = '$invoiceId'";
		}
		else{
			$flagStatus ="Update tbl_invoice_master Set paymentStatusFlag = 'B', invoiceFlag = 'Y' 
			           ,paidAmount='$total_recieved_amount'
                      Where invoiceId = '$invoiceId'";
		}
        
		echo $flagStatus;
        $resultSql = mysql_query($flagStatus);

        $invoicePaymentMap = "Insert into tblpaymentinvoicemap Set invoiceId = '$invoiceId', 
                               paymentId = '$paymentId'";
		/*echo $invoicePaymentMap;*/
       	$resultMap = mysql_query($invoicePaymentMap);
		echo "Payment Added Successfully!";
?>	
