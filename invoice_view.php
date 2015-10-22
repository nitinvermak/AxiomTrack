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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/sim_confirmation.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="js/textboxEnabled.js"></script>
<script type="text/javascript">
// Date 
/* $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });*/
// End Date
/* Send ajax request*/
$(document).ready(function(){
		$("#company").change(function(){
			$.post("ajaxrequest/invoice_view.php?token=<?php echo $token;?>",
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
		document.getElementById("name").innerHTML = "Company Name: "+name+ ", Interval Name: "+iName+ " "+iYear+ ", Payable Amount: "+amount;
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
    	<h3>Invoice View</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail2">Company</label>
            <select name="company" id="company" class="form-control drop_down" >
                <option value="">Select Company</option>
                <?php $Country=mysql_query("SELECT DISTINCT A.cust_id, A.callingdata_id, B.customerId  
											FROM tbl_customer_master as A
											inner join tbl_invoice_master as B
											on A.cust_id = B.customerId;");
				 	  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['cust_id']; ?>" ><?php echo getOraganization(stripslashes(ucfirst($resultCountry['callingdata_id']))); ?></option>
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
         <td colspan="4"><p id="name" style="font-weight:bold; font-family:'Trebuchet MS';"></p></td>
         </tr>
         <tr>
         <th colspan="4">Cash <input type="checkbox" name="cash" id="cash"></th>
         </tr>
         <tr>
         <td class="col-md-2">Amount</td>
         <td class="col-md-4"><input type="text" name="cashAmount" id="cashAmount" class="form-control text_box"></td>
         <td class="col-md-2"></td>
         <td class="col-md-4"></td>
         </tr>
         <tr>
         <th colspan="4">Cheque <input type="checkbox" name="cheque" id="cheque"></th>
         </tr>
         <tr>
         <td class="col-md-2">Cheque No.</td>
         <td class="col-md-4"><input type="text" name="chequeNo" id="chequeNo" class="form-control text_box"></td>
         <td class="col-md-2">Cheque Date</td>
         <td class="col-md-4"><input type="text" name="chequeDate" id="chequeDate" class="date form-control text_box"></td>
         </tr>
         <tr>
         <td class="col-md-2">Bank</td>
         <td class="col-md-4">
         <select name="bank" id="bank" class="form-control drop_down ddlCountry">
            <option value="">Select Plan Category</option>
            <?php $Country=mysql_query("select * from tblBank");
						   while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['bankId']; ?>" <?php if(isset($result['bankId']) && $resultCountry['bankId']==$result['bankId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['bankName'])); ?></option>
            <?php } ?>
        </select>
         </td>
         <td class="col-md-2">Amount</td>
         <td class="col-md-4"><input type="text" name="amountCheque" id="amountCheque" class="form-control text_box"></td>
         </tr>
         <tr>
         <td class="col-md-2">Bank Deposit Date</td>
         <td class="col-md-4"><input type="text" name="depositDate" id="depositDate" class="form-control text_box"></td>
         <td class="col-md-2"></td>
         <td class="col-md-4"></td>
         </tr>
         <tr>
         <th colspan="4">Online Transfer <input type="checkbox" name="onlineTransfer" id="onlineTransfer"></th>
         </tr>
         <tr>
         <td class="col-md-2">Amount</td>
         <td class="col-md-4"><input type="text" name="onlineTransferAmount" id="onlineTransferAmount" class="form-control text_box"></td>
         <td class="col-md-2">Reference No.</td>
         <td class="col-md-4"><input type="text" name="refNo" id="refNo" class="form-control text_box"></td>
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
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>