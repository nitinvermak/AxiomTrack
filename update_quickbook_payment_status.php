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
	echo 'sadfsafas';
	$ticketId = mysql_real_escape_string($_POST['ticketId']);
	$organizationName = mysql_real_escape_string($_POST['organizationName']);
	$quickBookRefNo = mysql_real_escape_string($_POST['quickBookRefNo']);
	$chequeNo = mysql_real_escape_string($_POST['chequeNo']);
	$chequeDate = mysql_real_escape_string($_POST['chequeDate']);
	$bank = mysql_real_escape_string($_POST['bank']);
	$amountCheque = mysql_real_escape_string($_POST['amountCheque']);
	$depositDate = mysql_real_escape_string($_POST['depositDate']);
	$bankDepositDate = mysql_real_escape_string($_POST['bankDepositDate']);
	$depositStatus = mysql_real_escape_string($_POST['depositStatus']);
	$clearStatus = mysql_real_escape_string($_POST['clearStatus']);
	
	$sql = "UPDATE quickbookpaymentcheque SET ChequeNo ='$chequeNo', ChequeDate ='$chequeDate', Bank = '$bank', 
			DepositDate ='$depositDate', chequeAmount = '$amountCheque', DepositStatus = '$depositStatus', 
			bankDepositDate = '$bankDepositDate', ClearStatus = '$clearStatus' Where Id =".$_GET['chequeId'];
	/*echo $sql;*/
	$result = mysql_query($sql);
	
	$sqlMaster = "UPDATE quickbookpaymentmethoddetailsmaster SET ticketId = '', customerId = '', 
				  quickBookRefNo = '' where ChequeID =".$_GET['chequeId'];
	/*echo $sqlMaster;*/
	$resultMaster = mysql_query($sqlMaster);
	$_SESSION['sess_msg']='Payment Updated Successfully';
	header("location:edit_payment.php?token=".$token);
	exit();
}

$sql = "SELECT * FROM quickbookpaymentcheque as A 
		LEFT OUTER JOIN quickbookpaymentmethoddetailsmaster as B 
		ON A.Id = B.ChequeID 
		LEFT OUTER JOIN quickbookpaymentonlinetransfer as C 
		ON B.OnlineTransferId = C.Id WHERE B.ChequeID  = ".$_GET['chequeId'];
/*echo $sql;*/
$queryArr = mysql_query($sql);
$result=mysql_fetch_assoc($queryArr);

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
    	<h3> Update Payment</h3>
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
            </select>          </td>
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
        </div>        </td>
        <td width="20%">Quick Book Ref. No.</td>
        <td width="31%"><input type="text" name="quickBookRefNo" id="quickBookRefNo" Value="<?php echo $result['quickBookRefNo']; ?>" class="form-control text_box"> </td>
        </tr>
        
        <tr>
        <td width="16%">Cheque No.</td>
        <td width="33%"><input type="text" name="chequeNo" id="chequeNo"  Value="<?php echo $result['ChequeNo']; ?>" class="form-control text_box"></td>
        <td width="20%">Cheque Date</td>
        <td width="31%"><input type="text" name="chequeDate" id="chequeDate" Value="<?php echo $result['ChequeDate']; ?>" class="date form-control text_box"></td>
        </tr>
        <tr>
        <td width="16%">Bank</td>
        <td width="33%">
        <select name="bank" id="bank" class="form-control drop_down ddlCountry" >
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
        <td width="31%"><input type="text" name="amountCheque" id="amountCheque" Value="<?php echo $result['chequeAmount']; ?>" class="form-control text_box" ></td>
        </tr>
        
        <tr>
        <td width="16%">Deposit Date</td>
        <td width="33%"><input type="text" name="depositDate" id="depositDate" Value="<?php echo $result['DepositDate']; ?>" class="date form-control text_box" ></td>
        <td width="20%">Bank Deposit Date</td>
        <td width="31%"><input type="text" name="bankDepositDate" id="bankDepositDate" Value="<?php echo $result['bankDepositDate']; ?>" class="form-control text_box" ></td>
        </tr>
        
        <tr>
          <td>Deposit Status</td>
          <td>
          <select name="depositStatus" id="depositStatus" class="form-control drop_down ticket">
          		<option value="">Select </option>
                 <option value="<?php echo $result['DepositStatus']; ?>" 
				 <?php if(isset($result['DepositStatus'])){ ?>selected
				 <?php } ?>><?php if($result['DepositStatus'] == 'N') { echo 'No';} else if($result['DepositStatus'] == 'Y') { echo 'Yes';}?>
                 </option>
                 <option value="Y">Yes</option>
                 <option value="N">No</option>
          </select>          </td>
          <td>Clear Status</td>
          <td><select name="clearStatus" id="clearStatus" class="form-control drop_down">
                    	<option value="">Select Status</option>
                        <option value="<?php echo $result['ClearStatus']; ?>" 
						 <?php if(isset($result['ClearStatus'])){ ?>selected
                         <?php } ?>><?php if($result['ClearStatus'] == 'Y') { echo 'Cleared';} 
						 else if($result['ClearStatus'] == 'B') { echo 'Bounced';}?>
                    	<option value="Y">Cleared</option>
                        <option value="B">Bounced</option>
              </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
        <td width="16%">&nbsp;</td>
        <td width="33%">
        <input type="submit" name="submit" id="submit" class="btn btn-primary btn-sm" value="Submit"> 
        <input type="reset" name="reset" id="reset" class="btn btn-primary btn-sm" value="Reset">
        <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='edit_payment.php?token=<?php echo $token ?>'"/>        </td>
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