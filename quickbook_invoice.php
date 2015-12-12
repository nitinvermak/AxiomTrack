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
		$returnCode= 0;
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
		/*$revievingDate = mysql_real_escape_string($_POST['revievingDate']);*/
		$remarks = mysql_real_escape_string($_POST['remarks']);
		$confirmby = mysql_real_escape_string($_POST['confirmby']);
		
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
		
		switch($returnCode) {
		 case 1:	// if payment type online transfer when execute this query
                $sql = "Insert into quickbookpaymentonlinetransfer Set customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo', RefNo = '$refNo', onlineAmount = '$onlineTransferAmount'";
				/*echo $sql;*/
                $result = mysql_query($sql);
                $OnlineTransferId = mysql_insert_id();
                break;
		case 2:	// if payment type cheque when execute this query
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
						ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
						chequeAmount = '$amountCheque'";
				/*echo $sql;*/
                $result = mysql_query($sql);
                $ChequeID = mysql_insert_id(); 
                break;
		case 3:
                // if payment type cheque when execute this query
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
						ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
						chequeAmount = '$amountCheque'";
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
		
		 case 6:
                //Cash Payment
                // do nothing

                //Cheque Payment
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
						ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
						chequeAmount = '$amountCheque'";
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
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
						ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
						chequeAmount = '$amountCheque'";
				/*echo $sql;*/
                $result = mysql_query($sql);
                $ChequeID = mysql_insert_id();
                 // Online Payment
                $sql = "Insert into quickbookpaymentonlinetransfer Set customerId = '$organizationName', 
						quickBookRefNo = '$quickBookRefNo',RefNo = '$refNo', onlineAmount = '$onlineTransferAmount'";
				/*echo $sql;*/
                $result = mysql_query($sql);
                $OnlineTransferId = mysql_insert_id();
            default:
                # code...
                break;
		}
		$sql = "Insert into quickbookpaymentmethoddetailsmaster Set ticketId = '$ticketId', 
				customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo', 
				CashAmount = '$cashAmount', ChequeID = '$ChequeID', OnlineTransferId = '$OnlineTransferId', 
				userId = '$userId', RecivedDate = Now(), Remarks = '$remarks'";
				/*echo $sql;*/
                $result = mysql_query($sql);
				if($result)
				{
					echo "<script> alert('Payment Added Successfully !')</script>";
				}
                $paymentId = mysql_insert_id();
		
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
    <form name='fullform' class="form-horizontal"  method='post'>
    <div class="table-responsive">
		<table class="formStyle table" border="0" width="100%">
        <tr>
          <td>Ticket Id</td>
          <td>
          	<select name="ticketId" id="ticketId" class="form-control drop_down ticket">
            	<option value="">Select Ticket Id</option>
				<?php $Country=mysql_query("SELECT A.ticket_id as ticket_id FROM tblticket as A 
											INNER JOIN tbl_ticket_assign_branch as B 
											ON A.ticket_id = B.ticket_id 
											where A.organization_type = 'Existing Client'  
											and A.ticket_status <> 1 AND B.technician_assign_status = 1 
											order by ticket_id ASC");
                       while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $resultCountry['ticket_id']; ?>" 
				<?php if(isset($result['ticket_id']) && $resultCountry['ticket_id']==$result['ticket_id']){ ?>selected
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
        <td width="31%"><input type="text" name="quickBookRefNo" id="quickBookRefNo" class="form-control text_box"> </td>
        </tr>
        <tr>
        <th colspan="4">Cash <input type="checkbox" name="cash" id="cash"></th>
        </tr>
        <tr>
        <td width="16%">Amount</td>
        <td width="33%"><input type="text" name="cashAmount" id="cashAmount" class="form-control text_box" disabled></td>
        <td width="20%"></td>
        <td width="31%"></td>
        </tr>
        <tr>
        <th colspan="4">Cheque <input type="checkbox" name="cheque" id="cheque"></th>
        </tr>
        <tr>
        <td width="16%">Cheque No.</td>
        <td width="33%"><input type="text" name="chequeNo" id="chequeNo" class="form-control text_box" disabled></td>
        <td width="20%">Cheque Date</td>
        <td width="31%"><input type="text" name="chequeDate" id="chequeDate" class="date form-control text_box" disabled></td>
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
			<?php if(isset($result['bankId']) && $resultCountry['bankId']==$result['bankId']){ ?>selected<?php } ?>>
			<?php echo stripslashes(ucfirst($resultCountry['bankName'])); ?></option>
            <?php } ?>
        </select>        </td>
        <td width="20%">Amount</td>
        <td width="31%"><input type="text" name="amountCheque" id="amountCheque" class="form-control text_box" disabled></td>
        </tr>
        
        <tr>
        <td width="16%">Bank Deposit Date</td>
        <td width="33%"><input type="text" name="depositDate" id="depositDate" class="date form-control text_box" disabled></td>
        <td width="20%"></td>
        <td width="31%"></td>
        </tr>
        <tr>
        <th colspan="4">Online Transfer <input type="checkbox" name="onlineTransfer" id="onlineTransfer"></th>
        </tr>
        <tr>
        <td width="16%">Amount </td>
        <td width="33%"><input type="text" name="onlineTransferAmount" id="onlineTransferAmount" class="form-control text_box" disabled></td>
        <td width="20%">Reference No.</td>
        <td width="31%"><input type="text" name="refNo" id="refNo" class="form-control text_box" disabled></td>
        </tr>
        <tr>
        <th colspan="4">Other Details</th>
        </tr>
        <tr>
        <td width="16%">Remarks</td>
        <td width="33%"><input type="text" name="remarks" id="remarks" class="form-control text_box" ></td>
        <td width="20%">&nbsp;</td>
        <td width="31%">&nbsp;</td>
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