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
				$sql_online = "Insert into paymentonlinetransfer Set customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo', RefNo = '$refNo', Amount = '$onlineTransferAmount'";
				/*echo $sql;*/
				$result_online = mysql_query($sql_online);
				$OnlineTransferId = mysql_insert_id();
				//Save Data Cheque
				$sql_cheque = "Insert into PaymentCheque Set customerId = '$organizationName',
                        quickBookRefNo = '$quickBookRefNo', ChequeNo = '$chequeNo', 
                        ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate',
                        Amount = '$amountCheque'";
				/*echo $sql;*/
				$result_cheque = mysql_query($sql_cheque);
				$ChequeID = mysql_insert_id();
				//Save Data Cash Payment
				$sql = "Insert into paymentmethoddetailsmaster Set 
                        customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo',
                        CashAmount = '$cashAmount', ChequeID = '$ChequeID', 
                        OnlineTransferId = '$OnlineTransferId', 
                        RecivedDate = '$revievingDate', Remarks = '$remarks', 
                        RecievedBy = '$recievedby'";
				/*echo $sql;*/
				$result = mysql_query($sql);
                $msg= "Payment Added Successfully !";
			}
		else if (isset($_POST['cash']))
			{
				$sql_cash = "Insert into paymentmethoddetailsmaster Set 
                            customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo',
                            CashAmount = '$cashAmount', RecivedDate = '$revievingDate', 
                            Remarks = '$remarks' , RecievedBy = '$recievedby'";
                // echo $sql_cash;
				$result_cash = mysql_query($sql_cash);
                $msg= "Payment Added Successfully !";
			}
		else if(isset($_POST['cheque']))
			{
				$sql_cheque = "Insert into PaymentCheque Set customerId = '$organizationName',
                        quickBookRefNo = '$quickBookRefNo', ChequeNo = '$chequeNo', 
                        ChequeDate = '$chequeDate', Bank = '$bank', 
                        DepositDate = '$depositDate', Amount = '$amountCheque'";
				$result_cheque = mysql_query($sql_cheque);
				/*echo $sql;*/
				$ChequeID = mysql_insert_id(); 
				
				$sql = "Insert into paymentmethoddetailsmaster Set 
                        customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo', 
                        ChequeID = '$ChequeID', RecivedDate = '$revievingDate', 
                        Remarks = '$remarks', RecievedBy = '$recievedby'";
                $result = mysql_query($sql);
                $msg= "Payment Added Successfully !";
				/*echo $sql;*/
			}
		else if(isset($_POST['onlineTransfer']))
			{
				$sql_online = "Insert into paymentonlinetransfer Set 
                               customerId = '$organizationName',
                               quickBookRefNo = '$quickBookRefNo', 
                               RefNo = '$refNo', 
                               Amount = '$onlineTransferAmount'";
				$result_online = mysql_query($sql_online);
				/*echo $sql;*/
				$OnlineTransferId = mysql_insert_id();
				$sql = "Insert into paymentmethoddetailsmaster Set 
                        customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo',
                        OnlineTransferId = '$OnlineTransferId', RecivedDate = '$revievingDate',
                        Remarks = '$remarks' , RecievedBy = '$recievedby'";
				$result = mysql_query($sql);
                $msg= "Payment Added Successfully !";
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
    	<h3> Payment Recieve</h3>
        <hr>
    </div>
    <div class="col-md-12">
        <?php if(isset($msg)){?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?= $msg; ?></strong> 
            </div>
        <?php } ?>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return validate(this)">
        <div class="form-group form_custom"><!-- form_custom -->
            <divc class="row"> <!-- row -->
                <div class="col-md-6 col-sm-6 custom_field"> <!-- custom_field -->
                    <span><strong>Organization</strong> <i>*</i></span>
                    <select name="organizationName" id="organizationName" class="form-control">
                        <option value="">Select Organization</option>
                        <?php $Country=mysql_query("select A.cust_id as customerId, B.Company_Name as CompanyName 
                                                    from tbl_customer_master as A
                                                    inner join tblcallingdata as B
                                                    On A.callingdata_id = B.id order by B.Company_Name ASC");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['customerId']; ?>"><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>             <?php } ?>
                    </select>
                </div><!-- end custom_field -->
                <div class="col-md-6 col-sm-6 custom_field"> <!-- custom_field -->
                    <span><strong>Quick Book Ref. No.</strong><i>*</i></span>
                    <input type="text" name="quickBookRefNo" id="quickBookRefNo" class="form-control">
                </div> <!-- end custom_field -->
                <div class="clearfix"></div>
                <div class="col-md-12 field-option"><!-- field-option -->
                    <strong>Cash</strong> <input type="checkbox" name="cash" id="cash">
                </div><!-- end field-option -->
                <div class="col-md-6 col-sm-6 custom_field"> <!-- custom_field -->
                    <span><strong>Amount</strong><i>*</i></span>
                    <input type="text" name="cashAmount" id="cashAmount" class="form-control" disabled>
                </div> <!-- custom_field -->
                <div class="clearfix"></div>
                <div class="col-md-12 field-option"><!-- field-option -->
                    <strong>Cheque</strong> <input type="checkbox" name="cheque" id="cheque">
                </div><!-- end field-option -->
                <div class="col-md-6 col-sm-6 custom_field"> <!-- custom_field -->
                    <span><strong>Cheque No.</strong><i>*</i></span>
                    <input type="text" name="chequeNo" id="chequeNo" class="form-control" disabled>
                </div> <!-- end custom_field -->
                <div class="col-md-6 col-sm-6 custom_field"> <!-- custom_field -->
                    <span><strong>Cheque Date</strong><i>*</i></span>
                    <input type="text" name="chequeDate" id="chequeDate" class="date form-control" disabled>
                </div> <!-- end custom_field -->
                <div class="col-md-6 col-sm-6 custom_field"> <!-- custom_field -->
                    <span><strong>Bank</strong><i>*</i></span>
                    <select name="bank" id="bank" class="form-control ddlCountry" disabled>
                        <option value="">Select Plan Category</option>
                        <?php $Country=mysql_query("select * from tblBank");
                                       while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['bankId']; ?>" <?php if(isset($result['bankId']) && $resultCountry['bankId']==$result['bankId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['bankName'])); ?></option>
                        <?php } ?>
                    </select>
                </div> <!-- end custom_field -->
                <div class="col-md-6 col-sm-6 custom_field"> <!-- custom_field -->
                    <span><strong>Amount</strong><i>*</i></span>
                    <input type="text" name="amountCheque" id="amountCheque" class="form-control" disabled>
                </div> <!-- end custom_field -->
                <div class="clearfix"></div>
                <div class="col-md-12 field-option"><!-- field-option -->
                    <strong>Online Transfer</strong> <input type="checkbox" name="onlineTransfer" id="onlineTransfer">
                </div><!-- end field-option -->
                <div class="col-md-6 col-sm-6 custom_field">
                    <span><strong>Amount</strong> <i>*</i></span>
                    <input type="text" name="onlineTransferAmount" id="onlineTransferAmount" class="form-control" disabled>
                </div>
                <div class="col-md-6 col-sm-6 custom_field">
                    <span><strong>Reference No.</strong> <i>*</i></span>
                    <input type="text" name="refNo" id="refNo" class="form-control" disabled>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 field-option"><!-- field-option -->
                    <strong>Other Details</strong>
                </div><!-- end field-option -->
                <div class="col-md-6 col-sm-6 custom_field">
                    <span><strong>Date of Recieving</strong> <i>*</i></span>
                    <input type="text" name="revievingDate" id="revievingDate" class="date form-control" >
                </div>
                <div class="col-md-6 col-sm-6 custom_field">
                    <span><strong>Remarks</strong> <i>*</i></span>
                    <input type="text" name="remarks" id="remarks" class="form-control" >
                </div>
                <div class="col-md-6 col-sm-6 custom_field">
                    <span><strong>Payment Revieved by</strong> <i>*</i></span>
                    <input type="text" name="recievedby" id="recievedby" class="form-control" >
                </div>
                <div class="col-md-6 col-sm-6 custom_field">
                    <span><strong>Payment Confirm by</strong> <i>*</i></span>
                    <input type="text" name="confirmby" id="confirmby" class="form-control" >
                </div>
                <div class="col-md-6 col-sm-6 custom_field">
                    <input type="submit" name="submit" id="submit" class="btn btn-primary btn-sm" value="Submit"> 
                    <input type="reset" name="reset" id="reset" class="btn btn-primary btn-sm" value="Reset">
                </div>
            </div><!-- End row -->
        </div> <!-- end form_custom -->
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
<!--Javascript-->
<script src="js/bootstrap.min.js"></script>
</body>
</html>