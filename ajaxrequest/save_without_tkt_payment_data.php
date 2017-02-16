<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$returnCode= 0;
$userId = $_SESSION['user_id'];
$customerId = mysql_real_escape_string($_POST['customerId']);
$quickBookRefNo = mysql_real_escape_string($_POST['quickBookRefNo']);
$cashAmount = mysql_real_escape_string($_POST['cashAmount']);
$chequeNo = mysql_real_escape_string($_POST['chequeNo']);
$chequeDate = mysql_real_escape_string($_POST['chequeDate']);
$bank = mysql_real_escape_string($_POST['bank']);
$amountCheque = mysql_real_escape_string($_POST['amountCheque']);
$depositDate = mysql_real_escape_string($_POST['depositDate']);
$onlineTransferAmount = mysql_real_escape_string($_POST['onlineTransferAmount']);
$refNo = mysql_real_escape_string($_POST['refNo']);
$remarks = mysql_real_escape_string($_POST['remarks']);

$totalAmount = $cashAmount + $amountCheque + $onlineTransferAmount;

if($cashAmount == "" && $amountCheque == "" && $onlineTransferAmount != ""){
    $returnCode = 1;   
    echo $returnCode;     
}
if($cashAmount == "" && $amountCheque != "" && $onlineTransferAmount == ""){
    $returnCode = 2;        
}
if($cashAmount == "" && $amountCheque != "" && $onlineTransferAmount != ""){
    $returnCode = 3;        
}
if($cashAmount != "" && $amountCheque == "" && $onlineTransferAmount == ""){
    $returnCode = 4;        
}
if($cashAmount != "" && $amountCheque == "" && $onlineTransferAmount != ""){
    $returnCode = 5;        
}
if($cashAmount != "" && $amountCheque != "" && $onlineTransferAmount == ""){
    $returnCode = 6;        
}
if($cashAmount != "" && $amountCheque != "" && $onlineTransferAmount != ""){
    $returnCode = 7;        
}
if($cashAmount == "" && $amountCheque == "" && $onlineTransferAmount == ""){
    $returnCode = 8;        
}

switch($returnCode) {
	case 1:	// if payment type online transfer when execute this query
            $sql = "Insert into quickbookpaymentonlinetransfer Set RefNo = '$refNo', 
					onlineAmount = '$onlineTransferAmount'";
			// echo $sql;
            $result = mysql_query($sql);
            $OnlineTransferId = mysql_insert_id();
            break;
		
	case 2:	// if payment type cheque when execute this query
                $queryArr=mysql_query("SELECT `ChequeNo`,`Bank`,`chequeAmount` 
                                       FROM `quickbookpaymentcheque` 
                                       WHERE `ChequeNo`='$chequeNo' 
                                       AND `chequeAmount` = '$amountCheque' 
                                       AND `Bank` = '$bank'");
                //$result=mysql_fetch_assoc($queryArr);
                if(mysql_num_rows($queryArr)<=0)
                {
                    $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
    						ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
    						chequeAmount = '$amountCheque'";
    				// echo $sql;
                    $result = mysql_query($sql);
                    $ChequeID = mysql_insert_id(); 
                }
                else{
                    echo '<div class="alert alert-danger small-alert alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Payment alreay exist !
                          </div>';
                }
                break;
	case 3:
            // if payment type cheque when execute this query
            $queryArr=mysql_query("SELECT `ChequeNo`,`Bank`,`chequeAmount` 
                                       FROM `quickbookpaymentcheque` 
                                       WHERE `ChequeNo`='$chequeNo' 
                                       AND `chequeAmount` = '$amountCheque' 
                                       AND `Bank` = '$bank'");
            if(mysql_num_rows($queryArr)<=0){
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
    					ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
    					chequeAmount = '$amountCheque'";
    				// echo $sql;
                $result = mysql_query($sql);
                $ChequeID = mysql_insert_id();
                //Online Payment
                // do nothing
            } 
            else{
                echo '<div class="alert alert-danger small-alert alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Payment alreay exist !
                          </div>';
            }
            break;
	case 4:
            // Cash Payment
            // do nothing
            break;
		
	case 6:
            //Cash Payment
            // do nothing
            //Cheque Payment
            $queryArr=mysql_query("SELECT `ChequeNo`,`Bank`,`chequeAmount` 
                                       FROM `quickbookpaymentcheque` 
                                       WHERE `ChequeNo`='$chequeNo' 
                                       AND `chequeAmount` = '$amountCheque' 
                                       AND `Bank` = '$bank'");
            if(mysql_num_rows($queryArr)<=0){
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
    					ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
    					chequeAmount = '$amountCheque'";
    				// echo $sql;
                $result = mysql_query($sql);
                $ChequeID = mysql_insert_id();
                // cash amount
                // do nothing
            }
            else{
                echo '<div class="alert alert-danger small-alert alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Payment alreay exist !
                          </div>';
            }
            break;
	case 7:
           	// cash payment
            // do nothing
            //Cheque Payment
            $queryArr=mysql_query("SELECT `ChequeNo`,`Bank`,`chequeAmount` 
                                       FROM `quickbookpaymentcheque` 
                                       WHERE `ChequeNo`='$chequeNo' 
                                       AND `chequeAmount` = '$amountCheque' 
                                       AND `Bank` = '$bank'");
            if(mysql_num_rows($queryArr)<=0){
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
    					ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
    					chequeAmount = '$amountCheque'";
    				// echo $sql;
                $result = mysql_query($sql);
                $ChequeID = mysql_insert_id();
                // Online Payment
                $sql = "Insert into quickbookpaymentonlinetransfer Set RefNo = '$refNo', 
                		onlineAmount = '$onlineTransferAmount'";
    				// echo $sql;
                $result = mysql_query($sql);
                $OnlineTransferId = mysql_insert_id();
                }
                else{
                    echo '<div class="alert alert-danger small-alert alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Payment alreay exist !
                          </div>';
                }
                default:
                # code...
                break;
		}
        if($cashAmount != "" || $amountCheque != "" || $onlineTransferAmount != ""){
    		$sql = "Insert into quickbookpaymentmethoddetailsmaster Set ticketId = '$ticketId', 
    				customerId = '$customerId', quickBookRefNo = '$quickBookRefNo', 
    				CashAmount = '$cashAmount', ChequeID = '$ChequeID', OnlineTransferId = '$OnlineTransferId', 
    				adjustmentAmt = '$totalAmount', userId = '$userId', RecivedDate = Now(), Remarks = '$remarks'";
                    $result = mysql_query($sql);
    				if($result)
    				{
    					echo '<div class="alert alert-success small-alert alert-dismissible" role="alert">
    						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    						  	<strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> Payment Added Successfully !
    						  </div>';
    				}
                    $paymentId = mysql_insert_id();
        }
?>                
