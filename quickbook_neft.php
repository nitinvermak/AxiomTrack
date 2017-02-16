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
		$userId = $_SESSION['user_id'];
		$organizationName = mysql_real_escape_string($_POST['organizationName']);
		$quickBookRefNo = mysql_real_escape_string($_POST['quickBookRefNo']);
		$onlineTransferAmount = mysql_real_escape_string($_POST['onlineTransferAmount']);
		$refNo = mysql_real_escape_string($_POST['refNo']);
		$remarks = mysql_real_escape_string($_POST['remarks']);
		
		$sql = "INSERT INTO `quickbookpaymentonlinetransfer` SET `RefNo`= '$refNo', `onlineAmount`= '$onlineTransferAmount'";
		$result = mysql_query($sql);
		$OnlineTransferId = mysql_insert_id();
		
		$sqlPaymentMaster = "INSERT INTO `quickbookpaymentmethoddetailsmaster` SET `customerId` = '$organizationName', 
							`OnlineTransferId`= '$OnlineTransferId', `userId` = '$userId', `RecivedDate`= Now(), 
							`Remarks` = '$remarks', adjustmentAmt = '$onlineTransferAmount'";
		$resultPaymentMaster = mysql_query($sqlPaymentMaster);
		echo "<script> alert('Payment Added Successfully !')</script>";
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
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/neft.js"></script>
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
    	<h1>NEFT Payment Entry</h1>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return validate(this)">
    <div class="table-responsive">
		<table class="formStyle table" border="0" width="100%">
        <tr>
        <td width="16%">Organization</td>
        <td width="33%">
            <select name="organizationName" id="organizationName" class="form-control drop_down">
                 <option value="">Select Orgranization</option>                         
				 <?php $Country=mysql_query("SELECT A.Company_Name as companyName, B.cust_id as custId 
											 FROM tblcallingdata as A 
											 INNER JOIN tbl_customer_master as B 
											 ON A.id = B.callingdata_id
											 WHERE A.status = '1' 
											 ORDER BY A.Company_Name ASC");								
                      while($resultCountry=mysql_fetch_assoc($Country))
                            {
                 ?>
                 <option value="<?php echo $resultCountry['custId']; ?>">
                 <?php echo stripslashes(ucfirst($resultCountry['companyName'])); ?></option>
                 <?php } ?>
            </select>        
        </td>
        <td width="20%">Quick Book Ref. No.</td>
        <td width="31%"><input type="text" name="quickBookRefNo" id="quickBookRefNo" class="form-control text_box"> </td>
        </tr>
        
        <tr>
        <td width="16%">Amount </td>
        <td width="33%"><input type="text" name="onlineTransferAmount" id="onlineTransferAmount" class="form-control text_box"></td>
        <td width="20%">Reference No.</td>
        <td width="31%"><input type="text" name="refNo" id="refNo" class="form-control text_box" ></td>
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