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
                $result = mysql_query($sql);
                $OnlineTransferId = mysql_insert_id();
                break;
            case 2:
                $sql = "Insert into PaymentCheque Set ChequeNo = '$chequeNo', ChequeDate = '$chequeDate', 
                Bank = '$bankname', DepositDate = '$depositDate', Amount = '$amountCheque'";
				echo $sql;
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
                RecivedDate = STR_TO_DATE('$revievingDate','%m/%d/%Y'), Remarks = '$remarks' , RecievedBy = '$recievedby'";
				echo $sql;
                $result = mysql_query($sql);
                $paymentId = mysql_insert_id();

        $flagStatus ="Update tbl_invoice_master Set paymentStatusFlag = 'B', invoiceFlag = 'Y' 
                      Where invoiceId = '$invoiceId'";
		/*echo $flagStatus;*/
        $resultSql = mysql_query($flagStatus);

        $invoicePaymentMap = "Insert into tblpaymentinvoicemap Set invoiceId = '$invoiceId', 
                               paymentId = '$paymentId'";
		/*echo $invoicePaymentMap;*/
       	$resultMap = mysql_query($invoicePaymentMap);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="http:/resources/demos/style.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/sim_confirmation.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/textboxEnabled.js"></script>

<script type="text/javascript">
// Date 
/* $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });*/
   $(function() {
    $( ".date" ).datepicker();
  });
// End Date

/* Send ajax request*/
$(document).ready(function(){
		$("#company").change(function(){
			$.post("ajaxrequest/show_estimate_view.php?token=<?php echo $token;?>",
				{
					cust_id : $('#company').val(),
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
				});	 
		});
});
/* End */
// calculate percentage
 function showData1(inId){

   //alert('#discountAmt'+inId);
    varA='#discountAmt'+inId;
    varB='#Percentage'+inId;
    var1 = $(varA).val();
    //alert(varB);
    if ( var1 == 'Percentage'){
       // alert('aa');
        $(varB).show();                    
    }
    if (var1 == 'Rs'){
       // alert('bb');
        $(varB).hide();                    
    }

}
function calPercent(inId){
    v1="#total"+inId;
    v2='#Percentage'+inId;
    v3='#rupee'+inId;
    varA = $(v1).val();
    varB = $(v2).val();  
    if (varB > 100 || 0 > varB){

        alert('please provide correct discount');
        return;    
    }
    varC = (varA*varB)/100;
    $(v3).val(varC);


}
 
// End
// send discount data
function addPercent(invoiceId)
{       v3='#rupee'+invoiceId;
        $.post("ajaxrequest/percentage_amt.php?token=<?php echo $token;?>",
                {
                    invId: invoiceId,
                    rupeeAmt : $(v3).val(),

                },
                function( data){
                    $('.modal').modal('hide');
                    location.reload();
                });  
}
//End
function getValue(name, iName, iId, amount, iYear)
	{
		/*alert(name+iName+iId+amount+iYear);*/
		document.getElementById("name").innerHTML = name;
		document.getElementById("intervelName").innerHTML = iName+" "+iYear;
		document.getElementById("payableamt").innerHTML = amount;
	    $('#hiddenInvoiceID').val(iId);
    }
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
    	<h3>Estimate View</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail2">Company</label>
            <select name="company" id="company" class="form-control drop_down" >
                <option value="">Select Company</option>
                <?php $Country=mysql_query("SELECT DISTINCT A.cust_id, 
											C.Company_Name, A.callingdata_id, B.customerId  
											FROM tbl_customer_master as A
											inner join tbl_invoice_master as B
											on A.cust_id = B.customerId
											INNER JOIN tblcallingdata as C 
											ON A.callingdata_id = C.id ORDER BY C.Company_Name;");
				 	  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['cust_id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
                <?php } ?>
            </select>
        </div>
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request --->
       </div>
    </form>
    </div>
</div>
<!--end of the content-->
<!--open of the footer-->
<!-- Payment Modal Start -->
<div class="modal fade bs-example-modal-lg-payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Make Payment</h4>
      </div>
      <div class="modal-body">
      	<!--Start form -->
         <form name='fullform' class="form-horizontal"  method='post'>
         <input type="hidden" name="hiddenInvoiceID" id="hiddenInvoiceID" value="">
    	 <div class="table-responsive">         
    	 <table class="formStyle" border="0">
         <tr>
         <td colspan="4">
         <table class="table table-bordered">
         <tr>
         <td><strong>Company Name:</strong></td>
         <td><strong><span style="color:#FF0000;" id="name"></span></strong></td>
         <td><strong>Interval Name:</strong></td>
         <td><strong><span style="color:#FF0000;" id="intervelName"></span></strong></td>
         <td><strong>Payable Amount:</strong></td>
         <td><strong><span style="color:#FF0000;" id="payableamt"></span></strong></td>
         </tr>
         </table>
         </td>
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
         <td class="col-md-4"><input type="text" name="depositDate" id="depositDate" class="form-control text_box date" disabled></td>
         <td class="col-md-2">Confirm Date</td>
         <td class="col-md-4"><input type="text" name="confirmDate" id="confirmDate" class="form-control text_box" disabled="disabled" /></td>
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
        <!-- End Form -->
      </div>
    </div>
  </div>
</div>
<!-- End Payment Modal -->

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