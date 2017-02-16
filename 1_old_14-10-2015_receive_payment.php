<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
	session_destroy();
	header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}
if(isset($_POST['submit']))
	{
		/*Cash payment*/
		$cashAmount = mysql_real_escape_string($_POST['cashAmount']);
		/*Cheque*/
		$chequeNo = mysql_real_escape_string($_POST['chequeNo']);
		$chequeDate = mysql_real_escape_string($_POST['chequeDate']);
		$bank = mysql_real_escape_string($_POST['bank']);
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
		if(isset($_POST['cash']) && ($_POST['cheque']) && ($_POST['onlineTransfer']))
			{
				//Save Data Online payement 
				$sql = "Insert into paymentonlinetransfer Set RefNo = '$refNo', Amount = '$onlineTransferAmount'";
				/*echo $sql;*/
				$result = mysql_query($sql);
				$OnlineTransferId = mysql_insert_id();
				//Save Data Cheque
				$sql = "Insert into PaymentCheque Set ChequeNo = '$chequeNo', ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', Amount = '$amountCheque'";
				/*echo $sql;*/
				$result = mysql_query($sql);
				$ChequeID = mysql_insert_id();
				//Save Data Cash Payment
				$sql = "Insert into paymentmethoddetailsmaster Set CashAmount = '$cashAmount', ChequeID = '$ChequeID', OnlineTransferId = '$OnlineTransferId', RecivedDate = '$revievingDate', Remarks = '$remarks' , RecievedBy = '$recievedby'";
				/*echo $sql;*/
				$result = mysql_query($sql);
			}
		else if (isset($_POST['cash']))
			{
				$sql = "Insert into paymentmethoddetailsmaster Set CashAmount = '$cashAmount', RecivedDate = '$revievingDate', Remarks = '$remarks' , RecievedBy = '$recievedby'";
				$result = mysql_query($sql);
				/*echo $sql;*/
			}
		else if(isset($_POST['cheque']))
			{
				$sql = "Insert into PaymentCheque Set ChequeNo = '$chequeNo', ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', Amount = '$amountCheque'";
				$result = mysql_query($sql);
				/*echo $sql;*/
				$ChequeID = mysql_insert_id(); 
				
				$sql = "Insert into paymentmethoddetailsmaster Set ChequeID = '$ChequeID', RecivedDate = '$revievingDate', Remarks = '$remarks', RecievedBy = '$recievedby'";
				/*echo $sql;*/
			}
		else if(isset($_POST['onlineTransfer']))
			{
				$sql = "Insert into paymentonlinetransfer Set RefNo = '$refNo', Amount = '$onlineTransferAmount'";
				$result = mysql_query($sql);
				/*echo $sql;*/
				$OnlineTransferId = mysql_insert_id();
				$sql = "Insert into paymentmethoddetailsmaster Set OnlineTransferId = '$OnlineTransferId', RecivedDate = '$revievingDate', Remarks = '$remarks' , RecievedBy = '$recievedby'";
				$result = mysql_query($sql);
				/*echo $sql;*/
			}
		
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/device_branch_confirmation.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/textboxEnabled.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
 $(function() {
    $( "#revievingDate" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
</script>

</head>
<body>
<!--open of the wraper-->
<div id="wraper">
	<!--include header-->
    <?php include_once('includes/header.php');?>
    <!--end-->
    <!--open of the content-->
<div class="row" id="content">
	<div class="col-md-12">
    	<h3> Payment Recieve</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post'>
    <div class="table-responsive">
    	<table class="formStyle" border="0">
        <tr>
        <th colspan="4">Cash <input type="checkbox" name="cash" id="cash"></th>
        </tr>
        <tr>
        <td class="col-md-2">Amount</td>
        <td class="col-md-4"><input type="text" name="cashAmount" id="cashAmount" class="form-control text_box" disabled></td>
        <td class="col-md-2"></td>
        <td class="col-md-4"></td>
        </tr>
        <tr>
        <th colspan="4">Cheque <input type="checkbox" name="cheque" id="cheque"></th>
        </tr>
        <tr>
        <td class="col-md-2">Cheque No.</td>
        <td class="col-md-4"><input type="text" name="chequeNo" id="chequeNo" class="form-control text_box" disabled></td>
        <td class="col-md-2">Cheque Date</td>
        <td class="col-md-4"><input type="text" name="chequeDate" id="chequeDate" class="form-control text_box" disabled></td>
        </tr>
        <tr>
        <td class="col-md-2">Bank</td>
        <td class="col-md-4"><input type="text" name="bank" id="bank" class="form-control text_box" disabled></td>
        <td class="col-md-2">Amount</td>
        <td class="col-md-4"><input type="text" name="amountCheque" id="amountCheque" class="form-control text_box" disabled></td>
        </tr>
        
        <tr>
        <td class="col-md-2">Bank Deposit Date</td>
        <td class="col-md-4"><input type="text" name="depositDate" id="depositDate" class="form-control text_box" disabled></td>
        <td class="col-md-2"></td>
        <td class="col-md-4"></td>
        </tr>
        <tr>
        <th colspan="4">Online Transfer <input type="checkbox" name="onlineTransfer" id="onlineTransfer"></th>
        </tr>
        <tr>
        <td class="col-md-2">Amount</td>
        <td class="col-md-4"><input type="text" name="onlineTransferAmount" id="onlineTransferAmount" class="form-control text_box" disabled></td>
        <td class="col-md-2">Reference No.</td>
        <td class="col-md-4"><input type="text" name="refNo" id="refNo" class="form-control text_box" disabled></td>
        </tr>
        <tr>
        <th colspan="4">Other Details</th>
        </tr>
        <tr>
        <td class="col-md-2">Date of Recieving</td>
        <td class="col-md-4"><input type="text" name="revievingDate" id="revievingDate" class="form-control text_box" ></td>
        <td class="col-md-2">Remarks</td>
        <td class="col-md-4"><input type="text" name="remarks" id="remarks" class="form-control text_box" ></td>
        </tr>
        <tr>
        <td class="col-md-2">Payment Revieved by</td>
        <td class="col-md-4"><input type="text" name="recievedby" id="recievedby" class="form-control text_box" ></td>
        <td class="col-md-2">Payment Confirm by</td>
        <td class="col-md-4"><input type="text" name="confirmby" id="confirmby" class="form-control text_box" ></td>
        </tr>
        <tr>
        <td class="col-md-2">&nbsp;</td>
        <td class="col-md-4">&nbsp;</td>
        <td class="col-md-2">&nbsp;</td>
        <td class="col-md-4">&nbsp;</td>
        </tr>
        <tr>
        <td class="col-md-2">&nbsp;</td>
        <td class="col-md-4"><input type="submit" name="submit" id="submit" class="btn btn-primary btn-sm" value="Submit"> <input type="reset" name="reset" id="reset" class="btn btn-primary btn-sm" value="Reset"></td>
        <td class="col-md-2">&nbsp;</td>
        <td class="col-md-4">&nbsp;</td>
        </tr>
        </table>
    </div>
    </form>
    </div>
</div>
<!--end of the content-->
<!--open of the footer-->
<div class="row" id="footer">
	<div class="col-md-12">
    <p>Copyright &copy; 2015 INDIAN TRUCKERS, All rights reserved.</p>
    </div>
</div>
<!--end footer-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/bootstrap.min.js"></script>
</body>
</html>