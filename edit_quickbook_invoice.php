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
	{
		$paymentid = $_GET['paymentid'];
		$chequeId = $_GET['paymentid'];
		$onlinepaymentId = $_GET['onlinepaymentId'];
		$userId = $_SESSION['user_id'];
		$ticketId = mysql_real_escape_string($_POST['ticketId']);
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
				//Update Data Online payement 
				$sql = "Update quickbookpaymentonlinetransfer Set customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo', RefNo = '$refNo', 
						onlineAmount = '$onlineTransferAmount' Where Id = '$onlinepaymentId'";
				/*echo $sql;*/
				$result = mysql_query($sql);
				
				//Update Data Cheque
				$sql = "Update quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
						ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
						chequeAmount = '$amountCheque' where Id = '$chequeId'";
				/*echo $sql;*/
				$result = mysql_query($sql);
								
				//Update Data Cash Payment
				$sql = "Update quickbookpaymentmethoddetailsmaster Set ticketId = '$ticketId',
						customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo', CashAmount = '$cashAmount', 
						userId = '$userId', RecivedDate = '$revievingDate', 
						Remarks = '$remarks' where PaymentID = '$paymentid'";
				/*echo $sql;*/
				$result = mysql_query($sql);
				
			}
		else if (isset($_POST['cash']))
			{
				$sql = "Update quickbookpaymentmethoddetailsmaster Set ticketId = '$ticketId', 
						customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo', 
						CashAmount = '$cashAmount', userId = '$userId', RecivedDate = '$revievingDate', 
						Remarks = '$remarks' where PaymentID = '$paymentid'";
				$result = mysql_query($sql);
				
				/*echo $sql;*/
			}
		else if(isset($_POST['cheque']))
			{
				$sql = "Update quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
						ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
						chequeAmount = '$amountCheque' where Id = '$chequeId'";
				$result = mysql_query($sql);
				/*echo $sql;*/
				
				$sqlmaster = "Update quickbookpaymentmethoddetailsmaster Set ticketId = '$ticketId', 
							  customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo', 
							  userId = '$userId', RecivedDate = '$revievingDate', Remarks = '$remarks' 
							  where PaymentID = '$paymentid'";
				$resultMaster = mysql_query($sqlmaster);
				
				/*echo $sqlmaster;*/
			}
		else if(isset($_POST['onlineTransfer']))
			{
				$sql = "Update quickbookpaymentonlinetransfer Set customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo',RefNo = '$refNo', onlineAmount = '$onlineTransferAmount'
						Where Id = '$onlinepaymentId'";
				$result = mysql_query($sql);
				/*echo $sql;*/
				
				$sql = "Update quickbookpaymentmethoddetailsmaster Set ticketId = '$ticketId', 
						customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo', 
						userId = '$userId', RecivedDate = '$revievingDate', Remarks = '$remarks',
						where PaymentID = '$paymentid'";
				$result = mysql_query($sql);
			
				/*echo $sql;*/
			}
		
	}
if(isset($_REQUEST['paymentid']) && $_REQUEST['paymentid']){
$queryArr=mysql_query("SELECT * FROM quickbookpaymentcheque as A 
					  LEFT OUTER JOIN quickbookpaymentmethoddetailsmaster as B 
					  ON A.Id = B.ChequeID 
					  LEFT OUTER JOIN quickbookpaymentonlinetransfer as C 
					  ON B.OnlineTransferId = C.Id WHERE B.PaymentID =".$_REQUEST['paymentid']);
$result=mysql_fetch_assoc($queryArr);
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
// Select Organization when select ticket Id
$(document).ready(function(){
    $("select.ticket").change(function(){
      $.post("ajaxrequest/show_ticket_organization_quick_book.php?token=<?php echo $token;?>",
				{
					ticket : $(".ticket option:selected").val()
				},
					function( data ){
						$("#divOrgranization").html(data);
				});
		
    });
});
// End 
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
		<table class="formStyle table" border="0" width="100%">
        <tr>
          <td>Ticket Id</td>
          <td>
          	<select name="ticketId" id="ticketId" class="form-control drop_down ticket">
                    	 <option value="">Select Ticket Id</option>
						 <?php $Country=mysql_query("select ticket_id from tblticket where organization_type='Existing Client'  and ticket_status <> 1 order by ticket_id ASC");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                                 ?>
                        <option value="<?php echo $resultCountry['ticket_id']; ?>" 
						<?php if(isset($result['ticketId']) && $resultCountry['ticket_id']==$result['ticketId']){ ?>selected
						<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['ticket_id'])); ?></option>
                        <?php } ?>
            </select>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
        <td width="16%">Organization</td>
        <td width="33%">
        <div id="divOrgranization">
            <select name="organizationName" id="organizationName" class="form-control drop_down">
                <option value="">Select Organization</option>
               
            </select>		
        </div>
        </td>
        <td width="20%">Quick Book Ref. No.</td>
        <td width="31%"><input type="text" name="quickBookRefNo" id="quickBookRefNo" Value="<?php echo $result['quickBookRefNo']; ?>" class="form-control text_box"> </td>
        </tr>
        <tr>
        <th colspan="4">Cash <input type="checkbox" name="cash" id="cash"></th>
        </tr>
        <tr>
        <td width="16%">Amount</td>
        <td width="33%"><input type="text" name="cashAmount" id="cashAmount" Value="<?php echo $result['CashAmount']; ?>" class="form-control text_box" disabled></td>
        <td width="20%"></td>
        <td width="31%"></td>
        </tr>
        <tr>
        <th colspan="4">Cheque <input type="checkbox" name="cheque" id="cheque"></th>
        </tr>
        <tr>
        <td width="16%">Cheque No.</td>
        <td width="33%"><input type="text" name="chequeNo" id="chequeNo"  Value="<?php echo $result['ChequeNo']; ?>" class="form-control text_box" disabled></td>
        <td width="20%">Cheque Date</td>
        <td width="31%"><input type="text" name="chequeDate" id="chequeDate" Value="<?php echo $result['ChequeDate']; ?>" class="date form-control text_box" disabled></td>
        </tr>
        <tr>
        <td width="16%">Bank</td>
        <td width="33%">
        <select name="bank" id="bank" class="form-control drop_down ddlCountry" disabled>
            <option value="">Select Plan Category</option>
            <?php $Country=mysql_query("select * from tblbank");
						   while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['bankId']; ?>" 
			<?php if(isset($result['Bank']) && $resultCountry['bankId']==$result['Bank']){ ?>selected<?php } ?>>
			<?php echo stripslashes(ucfirst($resultCountry['bankName'])); ?></option>
            <?php } ?>
        </select>        </td>
        <td width="20%">Amount</td>
        <td width="31%"><input type="text" name="amountCheque" id="amountCheque" Value="<?php echo $result['chequeAmount']; ?>" class="form-control text_box" disabled></td>
        </tr>
        
        <tr>
        <td width="16%">Bank Deposit Date</td>
        <td width="33%"><input type="text" name="depositDate" id="depositDate" Value="<?php echo $result['DepositDate']; ?>" class="date form-control text_box" disabled></td>
        <td width="20%"></td>
        <td width="31%"></td>
        </tr>
        <tr>
        <th colspan="4">Online Transfer <input type="checkbox" name="onlineTransfer" id="onlineTransfer"></th>
        </tr>
        <tr>
        <td width="16%">Amount </td>
        <td width="33%"><input type="text" name="onlineTransferAmount" id="onlineTransferAmount" Value="<?php echo $result['onlineAmount']; ?>" class="form-control text_box" disabled></td>
        <td width="20%">Reference No.</td>
        <td width="31%"><input type="text" name="refNo" id="refNo" Value="<?php echo $result['RefNo']; ?>" class="form-control text_box" disabled></td>
        </tr>
        <tr>
        <th colspan="4">Other Details</th>
        </tr>
        <tr>
        <td width="16%">Date of Recieving</td>
        <td width="33%"><input type="text" name="revievingDate" id="revievingDate" Value="<?php echo $result['RecivedDate']; ?>" class="date form-control text_box" ></td>
        <td width="20%">Remarks</td>
        <td width="31%"><input type="text" name="remarks" id="remarks" Value="<?php echo $result['Remarks']; ?>" class="form-control text_box" ></td>
        </tr>
        <tr>
        <td width="16%">&nbsp;</td>
        <td width="33%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="31%">&nbsp;</td>
        </tr>
        <tr>
        <td width="16%">&nbsp;</td>
        <td width="33%">
        <input type="submit" name="submit" id="submit" class="btn btn-primary btn-sm" value="Submit"> 
        <input type="reset" name="reset" id="reset" class="btn btn-primary btn-sm" value="Reset">        </td>
        <td width="20%">&nbsp;</td>
        <td width="31%">&nbsp;</td>
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