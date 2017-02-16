<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
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
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="assets/bootstrap/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="assets/bootstrap/css/ionicons.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="assets/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="assets/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<script type="text/javascript" src="js/validation.js"></script><script>
// Date 
/* $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });*/
   $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
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
function getValue(name, iName, iId, amount, paidamount, iYear)
    {
        /*alert(name+iName+iId+amount+iYear);*/
        //document.getElementById("invoice_payment_form").reset();
        document.getElementById("name").innerHTML = name;
        document.getElementById("intervelName").innerHTML = iName+" "+iYear;
        document.getElementById("payableamt").innerHTML = amount - paidamount;
         
        $('#invoice_payable_amount').val(amount);
        $('#invoice_partial_paid_amount').val(paidamount);
        
        $('#hiddenInvoiceID').val(iId);
    }
// send Data via ajaxrequest
function getData(){
     
    if($("#cash").prop('checked') == true){
        if($("#cashAmount").val() == "" ){
            $("#cashAmount").focus();
            alert("Please Enter Cash Amount");
            return false;
        }
    }
    else if($('#cheque').prop('checked') == true){
        if($("#chequeNo").val() == "" ){
            $("#chequeNo").focus();
            alert("Please Enter Cheque No");
            return false;
        }
        else if($("#chequeDate").val() == "" ){
            $("#chequeDate").focus();
            alert("Please Enter Cheque Date");
            return false;
        }
        else if($("#bank").val() == "" ){
            $("#bank").focus();
            alert("Please Enter Bank");
            return false;
        }
        else if($("#amountCheque").val() == "" ){
            $("#amountCheque").focus();
            alert("Please Enter Cheque Amount");
            return false;
        }
        else if($("#depositDate").val() == "" ){
            $("#depositDate").focus();
            alert("Please Enter Bank Deposit Date");
            return false;
        }
    }
    else if($('#onlineTransfer').prop('checked') == true){
        if($("#onlineTransferAmount").val() == "" ){
            $("#onlineTransferAmount").focus();
            alert("Please Enter Amount");
            return false;
        }
        if($("#refNo").val() == "" ){
            $("#refNo").focus();
            alert("Please Enter Reference Number");
            return false;
        }
    }
    else if($("#cash").prop('checked') == false && $('#cheque').prop('checked') == false && $('#onlineTransfer').prop('checked') == false){
        alert("Please Select at least One Payment Type");
        return false;
    }

    
     
    $.post("ajaxrequest/make_payment.php?token=<?php echo $token;?>",
            {
                invoice_payable_amount : $("#invoice_payable_amount").val(),
                invoice_partial_paid_amount : $("#invoice_partial_paid_amount").val(),              
                hiddenInvoiceID : $('#hiddenInvoiceID').val(),
                cashAmount : $('#cashAmount').val(),
                chequeNo : $('#chequeNo').val(),
                chequeDate : $('#chequeDate').val(),
                bank : $('#bank').val(),
                amountCheque : $('#amountCheque').val(),
                depositDate : $('#depositDate').val(),
                onlineTransferAmount : $('#onlineTransferAmount').val(),
                refNo : $('#refNo').val(),
                revievingDate : $('#revievingDate').val(),
                remarks : $('#remarks').val(),
                recievedby : $('#recievedby').val(),
                confirmby : $('#confirmby').val()
            },
                function( data){
                    /*alert(data);*/
                     $('.modal').modal('hide');
                    $("#divassign").html(data);
            });  
    
}
// end 
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini" onLoad="checkDefault()">
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once("includes/header.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Estimate View
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Estimate View</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Company <i class="red">*</i></span>
                        <select name="company" id="company" class="form-control drop_down select2" style="width: 100%" >
                            <option value="0">Select Company</option>
                            <option value="">All</option>
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
                    </div> <!-- end custom field -->
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Details</h3> -->
            </div>
            <div class="box-body">
                <?php if(isset($msg)){?>
                <div class="alert alert-success alert-dismissible small-alert" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $msg; ?>
                </div>
                <?php 
                }
                ?>
                <div id="divassign" class="table-responsive">
                    <!-- Show Content from ajax page -->
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        </form>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
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
         <form name='fullform' id="invoice_payment_form" class="form-horizontal"  method='post'>
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
         <td class="col-md-4"><input type="text" name="confirmby" id="confirmby" class="form-control text_box" >
                              <input type="hidden" name="confirmby" id="invoice_payable_amount" class="form-control text_box" >
                              <input type="hidden" name="confirmby" id="invoice_partial_paid_amount" class="form-control text_box" >
                              
         </td>
         </tr>
         <tr>
         <td class="col-md-2">&nbsp;</td>
         <td class="col-md-4">&nbsp;</td>
         <td class="col-md-2">&nbsp;</td>
         <td class="col-md-4">&nbsp;</td>
         </tr>
         <tr>
         <td class="col-md-2">&nbsp;</td>
         <td class="col-md-4"><input type="button" name="submit" id="submit" onclick="getData();" class="btn btn-primary btn-sm" value="Submit"> <input type="reset" name="reset" id="reset" class="btn btn-primary btn-sm" value="Reset"></td>
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
<!-- Loader -->
<div class="loader">
    <img src="images/loader.gif" alt="loader">
</div>
<!-- End Loader -->
<?php include_once("includes/footer.php") ?>
</div><!-- ./wrapper -->
<script src="js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>
</body>
</html>