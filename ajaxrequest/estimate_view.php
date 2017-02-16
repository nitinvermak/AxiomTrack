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
<script type="text/javascript" src="js/validation.js"></script>
<script  src="js/ajax.js"></script>
<script>
// Date 
/* $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });*/
  //  $(function() {
  //   $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  // });
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
function getValue(name, iName, iId, amount,discount_amount, paidamount, iYear)
    {
        /*alert(name+iName+iId+amount+iYear);*/
        //document.getElementById("invoice_payment_form").reset();
        // document.getElementById("name").innerHTML = name;
        // document.getElementById("intervelName").innerHTML = iName+" "+iYear;
        // document.getElementById("payableamt").innerHTML = amount - paidamount;
         
        // $('#invoice_payable_amount').val(amount);
        // $('#invoice_partial_paid_amount').val(paidamount);
        
        // $('#hiddenInvoiceID').val(iId);
        $.post("ajaxrequest/make_payment_form.php?token=<?php echo $token;?>",
                {
                    orgName : name,
                    intervelName : iName+" "+iYear,
                    payableamt : amount,
					paid_amount: paidamount,
					discount_amount: discount_amount,
                    customer_id : $("#company").val(),
                    invoiceId : $("#invoiceId").val()
                },
                function(data){
                    $('.modal-content-payment').html(data);
                    // var pamt = document.getElementById("payableamt").value;
                    // alert(pamt);
                }); 
    }
function getPaymentEntryData(){
    if($("#paymentId").val() == ""){
        alert("Please Select Payment Id");
        $("#paymentId").focus();
    }
    else if($("#payble_amt").val() == ""){
        alert("Please Enter Payable Amount");
        $("#payble_amt").focus();
    }
    // else if(($("#adjestmentAmt").val()) > ($("#payble_amt").val()) ){
    //     alert("Please Provide Valid Amount");
    //     $("#payble_amt").focus();
    // }
    else{
        $.post("ajaxrequest/save_estimate_amt.php?token=<?php echo $token;?>",
                {
                    paymentId : $("#paymentId").val(),
                    payble_amt : $("#payble_amt").val(),
                    hiddenInvoiceID : $("#hiddenInvoiceID").val(),
                    adjestmentAmt : $("#adjestmentAmt").val(),
                    pending_payable_amt : $("#p_amt").val()
                    
                },
                function(data){
                    // alert(data);
                    $("#dv_success").html(data);
                    
                });
    }
}
// get Device Amt 
function getDeviceAmt()
{
    $('.loader').show();
    $.post("ajaxrequest/device_amount_details.php?token=<?php echo $token;?>",
            {
                paymentId : $('#paymentId').val()
            },
            function (data)
            {
                //alert(data);
                $("#divAmt1").html(data);
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
// End
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

/*Delete Estimate*/
function deleteEstimate(estimateId){
    $('.loader').show();
    $.post("ajaxrequest/delete_estimate.php?token=<?php echo $token;?>",
    {
        estimateId : estimateId
    },
    function( data){
        // alert(data);        
        restoreDueDate(estimateId); 
    }); 
}





/* End */
/* Restore Previous Due Date */
function restoreDueDate(estimateId){
     
    jsonArr = []
    // $(".vehicleId").each(function(){
    //     jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
    // });
 
	jsonArr.push({"id":"interval_Id="+$("#" + "interval_Id_"+estimateId).val()});
	jsonArr.push({"id":"estimate_id="+estimateId})
	jsonArr.push({"id":"intervalMonth="+$("#" + "intervalMonth_"+estimateId).val()});
	jsonArr.push({"id":"Intervel_Year="+$("#" + "Intervel_Year_"+estimateId).val()});
	jsonArr.push({"id":"customer_id="+$("#" + "customer_id_"+estimateId).val()});
	
 
    console.log(jsonArr);
    
/* 	url="ajaxrequest/restore_pre_due_date.php?token=<?php echo $token;?>";
    postData = {'PostData': jsonArr };
    xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA");
    reGenerateEstimate(); */
	
	$.post("ajaxrequest/restore_pre_due_date.php?token=<?php echo $token;?>",
    {

		interval_Id: $("#" + "interval_Id_"+estimateId).val(),
		customer_id: $("#" + "customer_id_"+estimateId).val()
		 
    },
    function( data){
        // alert(data); 
		console.log('regenerating estimates');
		$('.loader').hide();
		alert('Invoice deleted and due dates are restoed to previous month.');
		location.reload(); 
		
              
    }); 
	
}
function GetResponseA(str){
        document.getElementById('msgDV').innerHTML=str;
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
} 
// Re Generate Estimate
function reGenerateEstimate(intervalId){
    $('.loader').show();
    jsonArr = []
 	jsonArr.push({"id":"interval_Id="+$("#" + "interval_Id_"+intervalId).val()});
	// jsonArr.push({"id":"estimate_id="+intervalId})
	jsonArr.push({"id":"intervalMonth="+$("#" + "intervalMonth_"+intervalId).val()});
	jsonArr.push({"id":"Intervel_Year="+$("#" + "Intervel_Year_"+intervalId).val()});
	jsonArr.push({"id":"customer_id="+$("#" + "customer_id_"+intervalId).val()});
	
	
    console.log(jsonArr);
    console.log('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
	
	 url="ajaxrequest/generate_estimate_info.php?token=<?php echo $token;?>";	                 
     
	 postData = {'PostData': jsonArr };
	 console.log(jsonArr);
	  
 
	 xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA");
	
}

function generate_manually_invoice(obj){
    $('.loader').show();
    $.post("ajaxrequest/generate_manually_invoice.php?token=<?php echo $token;?>",
    {
        customerId : obj
    },
    function( data){
        $('.modal-content').html(data);
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    }); 
} 
// Re-generate Manually Estimate
  function re_generate_manually_estimate(custId){
    $('.loader').show();
    $.post("ajaxrequest/re_generate_manually_estimate.php?token=<?php echo $token;?>",
    {
        customerId : custId
    },
    function( data){
        $('#divassign').html(data);
        $('body').on('focus',".date", function(){
          $(this).datepicker({dateFormat: 'yy-mm-dd'});
        });
        //  $('.calculate_amt').on('click', function(){
        //         alert('adfas');
        //           var val1 = $(this).attr('name');
        //           var datefrom = $("#dd"+val1).val();
        //           console.log(datefrom);
                      
        // });
        getCurrentDate();
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    }); 
  }
// Make all start date same
function makeAllStartDateSame()
{
    //alert("Check box changed");
    var firstTextBoxValue="";
    var i=0;
    $('#example').find('input.start_date').each(function(){
        if(i==0)
        {
            firstTextBoxValue=$(this).val();
        }
        else
        {
            $(this).val(firstTextBoxValue);
        }
        $(this).id;
        i++;
        //console.log($(this).val()+"ID="+$(this).ID);
    });
}
// Make all end date same
function makeAllEndDateSame()
{
    //alert("Check box changed");
    var firstTextBoxValue="";
    var i=0;
    $('#example').find('input.end_date').each(function(){
        if(i==0)
        {
            firstTextBoxValue=$(this).val();
        }
        else
        {
            $(this).val(firstTextBoxValue);
        }
        $(this).id;
        i++;
        calculate_amt();
    });
}
// Make all rent amt same 
function makeAllRentAmtSame()
{
    //alert("Check box changed");
    var firstTextBoxValue="";
    var i=0;
    $('#example').find('input.rent_amt').each(function(){
        if(i==0)
        {
            firstTextBoxValue=$(this).val();
        }
        else
        {
            $(this).val(firstTextBoxValue);
        }
        $(this).id;
        i++;
        calculate_amt();
    });
}
function calculate_amt(){
    $('.row_val').each(function(){
		if($(".start_date",this).val()){
			var  start_date = $(".start_date",this).val();
			var end_date = $(".end_date",this).val();
            var rent_amt = $(".rent_ammt",this).val();
            console.log(rent_amt);
			var sdt = new Date(start_date);
			var sdt1 = new Date(end_date);
			var difdt = new Date(sdt1-sdt);
			var months = difdt.getMonth();
			var days = difdt.getDate();
            var years = difdt.toISOString().slice(0, 4) - 1970;
			console.log(months);
			// console.log(days);
            var total_rent_yearly = rent_amt * years * 12;
			var total_monthly_rent = rent_amt * months;
			var total_days_rent = rent_amt/30 * days;
			var total_rent_amt = total_rent_yearly + total_monthly_rent + total_days_rent;
			console.log(total_rent_amt);
			$(".rent_amt",this).val(total_rent_amt);
		}
		
        // document.getElementById("rent_amt").value = total_rent_amt;
    });
}
function get_intervalId(){
    $('.loader').show();
    $.post("ajaxrequest/get_interval_id.php?token=<?php echo $token;?>",
    {
        generated_date : $("#generated_date").val()
    },
    function( data){
        // alert(data);
        $('#dv_intervalId').html(data);
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    }); 
}
function save_rent_amount(){
  $('.loader').show();
  jsonArr = []
  $(".data").each(function(){
    //jsonArr.push({"name":$(this).attr('name')+'='+$(this).val()});
  });
   $('.row_val').each(function(){
        if($(".start_date",this).val()){
            var  start_date = $(".start_date",this).val();
            var  end_date = $(".end_date",this).val();
            var  rent_amt = $(".rent_amt",this).val();
            var  vehicle_id = $(".vehicle_id",this).val();
            var customer_Id = $(".customer_Id",this).val();
            var next_due_date = $(".next_due_date",this).val();
            if(start_date&&end_date){
                jsonArr.push({"data": vehicle_id+'='+end_date+'='+start_date+'='+rent_amt+'='+customer_Id+'='+next_due_date});
            }             
        }
    });
  console.log(jsonArr);
  url="ajaxrequest/save_rent_amount_manually.php?token=<?php echo $token;?>";
  postData = {'PostData': jsonArr,'due_date':$("#due_date1").val(),'interval_Id':$("#interval_Id").val()};
  //xmlhttpPost(url,JSON.stringify(postData),"GetResponseA");
  $.ajax({
        type: "POST",
        url: url,
        data:{postData:postData, },
        dataType: "json" ,
        success: function (data){
            alert('a');
            console.log(data);
            //GetResponseA(data);
        },
        complete:function(data){
          console.log(data.responseText);
          $('#divassign').html(data.responseText);
          $(".loader").removeAttr("disabled");
          $('.loader').fadeOut(1000);
        }
    });
}

function GetResponseA(str){
      document.getElementById('divassign').innerHTML=str;
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);
} 
function getCurrentDate() {
    // document.getElementById('generated_date').value= Date({dateFormat: 'yy-mm-dd'});
    var today = new Date();
    var dd = today.getDate();

    var mm = today.getMonth()+1; 
    var yyyy = today.getFullYear();
    if(dd<10) 
    {
        dd='0'+dd;
    } 

    if(mm<10) 
    {
        mm='0'+mm;
    } 
    // today = mm+'-'+dd+'-'+yyyy;
    today = yyyy+'-'+mm+'-'+dd;
    console.log(today);
    document.getElementById('generated_date').value= today;
    get_intervalId();
    // today = mm+'/'+dd+'/'+yyyy;
    // console.log(today);
    // today = dd+'-'+mm+'-'+yyyy;
    // console.log(today);
    // today = dd+'/'+mm+'/'+yyyy;
    // console.log(today);
}
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
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
                            <?php $Country=mysql_query("SELECT A.cust_id as custId, 
                                                        B.Company_Name as companyname
                                                        FROM tbl_customer_master as A 
                                                        INNER JOIN tblcallingdata as B 
                                                        ON A.callingdata_id = B.id
                                                        ORDER BY B.Company_Name");
                                    while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['custId']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['companyname'])); ?></option>
                            <?php } ?>
                        </select>
						
						       <!-- 	<button type="button" class="btn btn-danger btn-sm" onclick="nitin_function();">
        		                     do the thing
        	                        </button><br><br>  -->
						Deleting invoice instruction:<br/>
							1) Delete the latest invoice first.<br/>
							2) Due date will be restored to previous month invoice<br/>
							3) if multiple invoices need to be deleted do it one by one. Starting from latest invoice.<br/>
							
						
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
                <div id="msgDV"></div>
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
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    
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