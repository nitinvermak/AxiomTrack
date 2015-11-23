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
		echo 'asfasfd';
		$organizationName = mysql_real_escape_string($_POST['organizationName']);
		$quickBookRefNo = mysql_real_escape_string($_POST['quickBookRefNo']);
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
				$sql = "Insert into quickBookPaymentonlinetransfer Set customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo', RefNo = '$refNo', 
						Amount = '$onlineTransferAmount'";
				echo $sql;
				$result = mysql_query($sql);
				$OnlineTransferId = mysql_insert_id();
				
				//Save Data Cheque
				$sql = "Insert into quickBookPaymentCheque Set ChequeNo = '$chequeNo', 
						ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
						Amount = '$amountCheque'";
				/*echo $sql;*/
				$result = mysql_query($sql);
				$ChequeID = mysql_insert_id();
				
				
				//Save Data Cash Payment
				$sql = "Insert into quickBookpaymentmethoddetailsmaster Set customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo', CashAmount = '$cashAmount', 
						ChequeID = '$ChequeID', OnlineTransferId = '$OnlineTransferId', 
						RecivedDate = '$revievingDate', Remarks = '$remarks', 
						RecievedBy = '$recievedby'";
				/*echo $sql;*/
				$result = mysql_query($sql);
			}
		else if (isset($_POST['cash']))
			{
				$sql = "Insert into quickBookpaymentmethoddetailsmaster Set customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo', CashAmount = '$cashAmount', 
						RecivedDate = '$revievingDate', Remarks = '$remarks', 
						RecievedBy = '$recievedby'";
				$result = mysql_query($sql);
				/*echo $sql;*/
			}
		else if(isset($_POST['cheque']))
			{
				$sql = "Insert into quickBookPaymentCheque Set ChequeNo = '$chequeNo', 
						ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
						Amount = '$amountCheque'";
				$result = mysql_query($sql);
				echo $sql;
				$ChequeID = mysql_insert_id(); 
				
				$sqlmaster = "Insert into quickBookpaymentmethoddetailsmaster Set customerId = '$organizationName', 
							  quickBookRefNo = '$quickBookRefNo', ChequeID = '$ChequeID', 
							  RecivedDate = '$revievingDate', Remarks = '$remarks', RecievedBy = '$recievedby'";
				$resultMaster = mysql_query($sqlmaster);
				echo $sqlmaster;
			}
		else if(isset($_POST['onlineTransfer']))
			{
				$sql = "Insert into quickBookpaymentonlinetransfer Set customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo',RefNo = '$refNo', Amount = '$onlineTransferAmount'";
				$result = mysql_query($sql);
				/*echo $sql;*/
				$OnlineTransferId = mysql_insert_id();
				$sql = "Insert into quickBookpaymentmethoddetailsmaster Set customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo', OnlineTransferId = '$OnlineTransferId', 
						RecivedDate = '$revievingDate', Remarks = '$remarks', 
						RecievedBy = '$recievedby'";
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
// Date 
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
// End Date
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
    	<h3> Quick Book Invoice</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return validate(this)">
    <div class="table-responsive">
    	<table class="formStyle" border="0">
        <tr>
          <td>Organization</td>
          <td><select name="organizationName" id="organizationName" class="form-control drop_down">
	<option value="">Select Organization</option>
    <?php $Country=mysql_query("select A.cust_id as customerId, B.Company_Name as CompanyName 
								from tbl_customer_master as A
								inner join tblcallingdata as B
								On A.callingdata_id = B.id order by B.Company_Name ASC");
		  while($resultCountry=mysql_fetch_assoc($Country)){
	?>
    <option value="<?php echo $resultCountry['customerId']; ?>"><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>             <?php } ?>
</select></td>
          <td>Quick Book Ref. No.</td>
          <td><input type="text" name="quickBookRefNo" id="quickBookRefNo" class="form-control text_box"> </td>
        </tr>
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
        <td class="col-md-4"><input type="text" name="chequeDate" id="chequeDate" class="date form-control text_box" disabled></td>
        </tr>
        <tr>
        <td class="col-md-2">Bank</td>
        <td class="col-md-4">
        <select name="bank" id="bank" class="form-control drop_down ddlCountry" disabled>
            <option value="">Select Plan Category</option>
            <?php $Country=mysql_query("select * from tblBank");
						   while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['bankId']; ?>" <?php if(isset($result['bankId']) && $resultCountry['bankId']==$result['bankId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['bankName'])); ?></option>
            <?php } ?>
        </select>
        </td>
        <td class="col-md-2">Amount</td>
        <td class="col-md-4"><input type="text" name="amountCheque" id="amountCheque" class="form-control text_box" disabled></td>
        </tr>
        
        <tr>
        <td class="col-md-2">Bank Deposit Date</td>
        <td class="col-md-4"><input type="text" name="depositDate" id="depositDate" class="date form-control text_box" disabled></td>
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
        <td class="col-md-4"><input type="text" name="revievingDate" id="revievingDate" class="date form-control text_box" ></td>
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