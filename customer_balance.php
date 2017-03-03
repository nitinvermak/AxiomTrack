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
<!-- DataTable CSS -->
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/buttons.dataTables.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<!-- DataTable JS -->
<script type="text/javascript" src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.print.min.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script>
function cash(cash) {
        var cashAmount = document.getElementById("cashAmount");
        cashAmount.disabled = cash.checked ? false : true;
        if (!cashAmount.disabled) {
            cashAmount.focus();
        }
}
function cheque(cheque){
    var chequeNo = document.getElementById("chequeNo");
    var chequeDate = document.getElementById("chequeDate");
    var bank = document.getElementById("bank");
    var amountCheque = document.getElementById("amountCheque");
    var depositDate = document.getElementById("depositDate");
    chequeNo.disabled = cheque.checked ? false : true;
    chequeDate.disabled = cheque.checked ? false : true;
    bank.disabled = cheque.checked ? false : true;
    amountCheque.disabled = cheque.checked ? false : true;
    depositDate.disabled = cheque.checked ? false : true;
    if (!chequeNo.disabled) {
        chequeNo.focus();
    }
}
function onlineTransfer(onlineTransfer){
    var onlineTransferAmount = document.getElementById("onlineTransferAmount");
    var refNo = document.getElementById("refNo");
    onlineTransferAmount.disabled = onlineTransfer.checked ? false : true;
    refNo.disabled = onlineTransfer.checked ? false : true;
    if (!onlineTransferAmount.disabled) {
        onlineTransferAmount.focus();
    }
}
function getPendingReport(){
    $('.loader').show();
    $.post("ajaxrequest/pending_payment_details.php?token=<?php echo $token;?>",
            {
                custId : $('#cust_id').val()
            },
            function (data)
            {
                /*alert(data);*/
                $("#dvassign").html(data);
                // $('#example3').DataTable({ "bPaginate": false });
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
// get Estimate History
function get_estimate_history_details(cid){
    $('.loader').show();
    $.post("ajaxrequest/estimate_history.php?token=<?php echo $token;?>",
            {
                custId : cid
            },
            function (data)
            {
                // alert(data);
                $("#dvassign").html(data);
                // $('#example3').DataTable({ "bPaginate": false });
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
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
                // alert(data);
                $("#divAmt1").html(data);
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
// End
// get textbox amount field
function getField(obj)
{
    if(document.getElementById("linkID"+obj).checked == true)
    {
        /*alert("dvAmt"+obj);*/
        document.getElementById("dvAmt"+obj).style.display = "";
    }
    else
    {
        /*alert("dvAmt"+obj);*/
        document.getElementById("dvAmt"+obj).style.display = "none";
        /*document.getElementById("receivedAmt").value= "";*/
    }
}
// End
// send received amount via ajax
function getAmount(obj){
    $('.loader').show();
    $.post("ajaxrequest/device_received_amnt_details.php?token=<?php echo $token;?>",
            {
                receivedAmt : $("#receivedAmt"+obj).val(),
                paymentId : $("#paymentId").val(),
                adjustmentAmt : $("#adjestmentAmt").val(),
                PrereceivedAmt : $("#PrereceivedAmt"+obj).val(),
                pending_Amt : $("#pending_Amt"+obj).val(),
                vehicleId : obj,
                cust_id : $("#cust_id").val()
            },
            function (data)
            {
                $("#dv_Msg1").html(data);
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
                getPendingReport();
                // $("#receivedAmt"+obj).prop("disabled", true);
                // $("#linkID"+obj).prop("disabled", true);
                // $("#save"+obj).prop("disabled", true);
            });
}
// End
// send ajax request
function getClient(){
    $('.loader').show();
    $.post("ajaxrequest/customer_balance_details.php?token=<?php echo $token;?>",
    {
        cust_id : $('#cust_id').val()
    },
    function( data){
        /*alert(data);*/
        $("#divshow").html(data);
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    });  
}
//end
function getPaymentEntryForm(obj){
    $('.loader').show();
    $.post("ajaxrequest/payment_entry_without_tkt.php?token=<?php echo $token;?>",
    {
        cust_id : obj
    },
    function( data){
        /*alert(data);*/
        $(".modal-content").html(data);
        $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    });  
}
function getPaymentEntryData1(){  
    if($("#cash").prop('checked') == true){
        if($("#cashAmount").val() == "" ){
            $("#cashAmount").focus();
            alert("Please Enter Cash Amount");
        }
    }
    else if($('#cheque').prop('checked') == true){
        if($("#chequeNo").val() == "" ){
            $("#chequeNo").focus();
            alert("Please Enter Cheque No");
        }
        else if($("#chequeDate").val() == "" ){
            $("#chequeDate").focus();
            alert("Please Enter Cheque Date");
        }
        else if($("#bank").val() == "" ){
            $("#bank").focus();
            alert("Please Enter Bank");
        }
        else if($("#amountCheque").val() == "" ){
            $("#amountCheque").focus();
            alert("Please Enter Cheque Amount");
        }
        else if($("#depositDate").val() == "" ){
            $("#depositDate").focus();
            alert("Please Enter Bank Deposit Date");
        }
    }
    else if($('#onlineTransfer').prop('checked') == true){
        if($("#onlineTransferAmount").val() == "" ){
        $("#onlineTransferAmount").focus();
            alert("Please Enter Amount");
        }
        if($("#refNo").val() == "" ){
            $("#refNo").focus();
            alert("Please Enter Reference Number");
        }
    }
    else if($("#cash").prop('checked') == false && $('#cheque').prop('checked') == false && $('#onlineTransfer').prop('checked') == false){
        alert("Please Select at least One Payment Type");
        return false;
    }  
    // else{
        $('.loader').show();
        $.post("ajaxrequest/save_without_tkt_payment_data.php?token=<?php echo $token;?>",
        {
            customerId : $('#customerId').val(),
            quickBookRefNo : $('#quickBookRefNo').val(),
            cashAmount : $('#cashAmount').val(),
            chequeNo : $('#chequeNo').val(),
            chequeDate : $('#chequeDate').val(),
            bank : $('#bank').val(),
            amountCheque : $('#amountCheque').val(),
            depositDate : $('#depositDate').val(),
            onlineTransferAmount : $('#onlineTransferAmount').val(),
            refNo : $('#refNo').val(),
            remarks : $('#remarks').val()
        },
        function( data){
            // alert(data);
            $("#dv_Success1").html(data);
            $("#cashAmount").val() == ""; 
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        });
    // } 
}
// end payment entry
function getEstimateView(obj){
    $('.loader').show();
    $.post("ajaxrequest/show_estimate_view1.php?token=<?php echo $token;?>",
    {
        cust_id : obj
    },
    function( data){
        /*alert(data);*/
        $("#dvassign").html(data);
        $('#example').DataTable( {
            dom: 'Bfrtip',
            "bPaginate": false,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    });  
}
// Estimate View
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
function getValue1(name, iName, iId, amount, paidamount, iYear)
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
function get_Value(a){
    /*alert(a);
    alert('as');*/
    
    elements= '#'+a+'   input';
    elementsb= '#'+a+'   select'; 
    jsonArr= [];
    jQuery(elements).map(function() {
           console.log( $(this).attr('id') + '=' + $(this).val());
           jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
           
      });
    errors=0; 
    jQuery(elementsb).map(function() {
           console.log($(this).attr('id') + '=' + $(this).val());
           if ($(this).attr('id') == 'device_type'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Device Type');
                  errors=1; 
                  return false;
                }            
           }
           if ($(this).attr('id') == 'device_amt'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Device amount');
                  errors=1;
                  return false;
                }            
           }

           if ($(this).attr('id') == 'device_rent'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Device Rent');
                  errors=1;
                  return false;
                }            
           }
           if ($(this).attr('id') == 'rent_frq'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Rent Frequency');
                  errors=1;
                  return false;
                }            
           }
           if ($(this).attr('id') == 'installation_charges'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Installation Charges');
                  errors=1;
                  return false;
                }            
           }
           
           
           jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
      }); 
    if (errors==1){
        return; 
    }  
    /*alert(cust_id);*/
     url="ajaxrequest/add_vehicle_Plan_Info.php?token=<?php echo $token;?>";    
     /*url="ajaxrequest/test.php?token=31c766f7463150d93381cd176a838eea";  */               
        /*alert(url);*/
     
     postData = {'PostData': jsonArr };
     //postData = {'PostData': 1234 };
     //alert(postData.PostData);
     xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA1"); 
}
function GetResponseA1(str){
    document.getElementById('div_Show').innerHTML=str;
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
// End Estimate View
// Device Amount
function getDeviceAmount(obj){
    $('.loader').show();
    $.post("ajaxrequest/show_estimate_device_amt.php?token=<?php echo $token;?>",
    {
        customerId : obj
    },
    function( data){
        /*alert(data);*/
        $("#dvassign").html(data);
        $('.example').DataTable( {
                dom: 'Bfrtip',
                "bPaginate": false,
                buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                         ]
        });
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    });
}
// End Device Amount
// generate Device Estimate
function generate_device_estimate_details(obj){
    $('.loader').show();
    $.post("ajaxrequest/device_estimate_details.php?token=<?php echo $token;?>",
    {
        customerId : obj
    },
    function( data){
        /*alert(data);*/
        $("#dvassign").html(data);
        $('.example').DataTable( {
                dom: 'Bfrtip',
                "bPaginate": false,
                buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                         ]
        });
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    });
}
function generate_device_estimate(){
    jsonArr = []
    $('.row_val').each(function(){
        var  device_amt1 = $("#device_amt1",this).val();
        var customer_id1 = $("#customer_id1",this).val();
        var vehicleId = $("#v_id",this).val();
        jsonArr.push({"device_amt": device_amt1, 'customer_id': customer_id1, 'vehicleId': vehicleId });
    });
    // console.log(jsonArr);
    url="ajaxrequest/generate_device_estimate.php?token=<?php echo $token;?>";
    postData = {'PostData': jsonArr};
    $.ajax({
        type: "POST",
        url: url,
        data:{postData:postData},
        dataType: "json" ,
        success: function (data){
            alert('a');
            console.log(data);
            //GetResponseA(data);
        },
        complete:function(data){
          console.log(data.responseText);
          $('#show_content').html(data.responseText);
          $(".loader").removeAttr("disabled");
          $('.loader').fadeOut(1000);
        }
    });
}
// End Generate Device Estimate
// generate next due date
function generate_duedate1(obj){
    $.post("ajaxrequest/manually_invoice.php?token=<?php echo $token;?>",
        {
            cust_id : obj,
        },
        function( data){
            /*alert(data);*/
            $("#dvassign").html(data);
            $('#example').DataTable({ "bPaginate": false });
            $('body').on('focus',".next_due_date", function(){
            $( this ).datepicker({dateFormat: 'yy-mm-dd'});
            });
    }); 
}
// Copy textbox value 
function makeAllDateSame()
{
    //alert("Check box changed");
    var firstTextBoxValue="";
    var i=0;
    $('#example').find('input.next_due_date').each(function(){
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
function getDueDateData(){
   $('.loader').show();
    jsonArr = []
    $(".next_due_date").each(function(){
        jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
    });
    console.log(jsonArr);
    url="ajaxrequest/manually_invoice_next_due_date.php?token=<?php echo $token;?>";
    postData = {'PostData': jsonArr };
    xmlhttpPost(url,JSON.stringify(jsonArr),"GetStatus");
}
function GetStatus(str){
    // alert(str);
    // // console.log(str);
    // // document.getElementById('dvMSG').innerHTML=str;
    $("#dvMSG").html(str);
    $(".loader").removeAttr("disabled");
    $('.loader').fadeOut(1000);
} 
// end genereate next due date
function viewPlanHistory(){
    $('.loader').show();
    $.post("ajaxrequest/show_plan_history.php?token=<?php echo $token; ?>",
    {
        cust_id : $('#cust_id').val()
    },
    function( data){
        /*alert(data);*/
        $("#dvassign").html(data);
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    });  
}
function getDetails(obj)
{
    var vehicleId = obj;
    var id = "#divHistory"+vehicleId;
    var divId = '#dataDivHistory'+vehicleId;
    if($('#image').attr('src') === 'images/plus.gif'){ /* check source */
            $('#image').attr('src','images/minus.gif'); /* change source */
        }
        else{
            $('#image').attr('src','images/plus.gif'); /* change source */
        }
    //alert(id);
    $(id).toggle();
    $.post("ajaxrequest/show_details.php?token=<?php echo $token; ?>",
                {
                    vehicle_id : vehicleId
                },
                    function( data){
                        /*alert(data);*/
                        $(divId).html(data);
                });  
}
function editPlan(){
    $('.loader').show();
    $.post("ajaxrequest/edit_payment_details.php?token=<?php echo $token; ?>",
                {
                    cust_id : $('#cust_id').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#dvassign").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });
}
//---------------------- Case Check ---------------------------- //
$(document).on("change",".device_type", function(){
    parentId= '#'+$(this).closest('tr').attr('id');
    
    //alert(parentId); 
    
    var deviceType = $(parentId).find(".device_type").val();
    //alert(deviceType);
    if(deviceType == 1)
    {
        //alert(deviceType);
        $(parentId).find('.device_amt').prop("disabled", false);
        $(parentId).find('.device_rent').prop("disabled", false);
        $(parentId).find('.rent_frq').prop("disabled", false);
        $(parentId).find('.installation_charges').prop("disabled", false);
        $(parentId).find('.downpayment').prop("disabled", true);
        $(parentId).find('.NoOfInstallation').prop("disabled", true);
    }
    if(deviceType == 2)
    {
        //alert(deviceType);
        $(parentId).find('.device_amt').prop("disabled", false);
        $(parentId).find('.device_amt > option').each(function () {      
            if ($(this).text() == "0") {
                
                $(this).attr("selected", "selected");
                $(this).prop('selected', true);
                return;
            }
        });         
        $(parentId).find('.device_amt').prop("disabled", true);
        $(parentId).find('.device_rent').prop("disabled", false);
        $(parentId).find('.rent_frq').prop("disabled", false);
        $(parentId).find('.installation_charges').prop("disabled", false);
        $(parentId).find('.downpayment').prop("disabled", true);
        $(parentId).find('.NoOfInstallation').prop("disabled", true);
    }
    if(deviceType == 3)
    {
        //alert(deviceType);        
        $(parentId).find('.device_amt').prop("disabled", false);
        $(parentId).find('.device_amt > option').each(function () {
             
            if ($(this).text() == "0") {
               
                $(this).attr("selected", "selected");
                $(this).prop('selected', true);
                return;
            }
        });         
        $(parentId).find('.device_amt').prop("disabled", true);
        $(parentId).find('.rent_frq').prop("disabled", false);
        $(parentId).find('.installation_charges').prop("disabled", false);
        $(parentId).find('.downpayment').prop("disabled", true);
        $(parentId).find('.NoOfInstallation').prop("disabled", true);
    }
    if(deviceType == 4)
    {
        alert(deviceType);
        $(parentId).find('.device_amt').prop("disabled", false);
        $(parentId).find('.device_rent').prop("disabled", false);
        $(parentId).find('#rent_frq > option').each(function () {            
            if ($(this).val() == "1") {            
                $(this).attr("selected", "selected");
                $(this).prop('selected', true);
                return;
            }
        });
        $(parentId).find('#rent_frq').prop("disabled", true);
        $(parentId).find('.installation_charges').prop("disabled", false);
        $(parentId).find('.downpayment').prop("disabled", false);
        $(parentId).find('.NoOfInstallation').prop("disabled", false);
    }   
});
// -------------------------- End ------------------------- //
function getValueHistoryPage(b){
    //alert(b);
    /*alert('as');*/
     
    elements= '#'+b+'   input';
    elementsb= '#'+b+'   select'; 
    jsonArr= [];
    jQuery(elements).map(function() {
           console.log( $(this).attr('id') + '=' + $(this).val());
           jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
           
      });
     
    errors=0; 
    jQuery(elementsb).map(function() {
           console.log($(this).attr('id') + '=' + $(this).val());
           if ($(this).attr('id') == 'device_type'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Device Type');
                  errors=1; 
                  return false;
                }            
           }
           if ($(this).attr('id') == 'device_amt'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Device amount');
                  errors=1;
                  return false;
                }            
           }

           if ($(this).attr('id') == 'device_rent'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Device Rent');
                  errors=1;
                  return false;
                }            
           }
           if ($(this).attr('id') == 'rent_frq'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Rent Frequency');
                  errors=1;
                  return false;
                }            
           }
           if ($(this).attr('id') == 'installation_charges'){
                if($(this).val() == 'X_'){
                  alert('Please Enter Installation Charges');
                  errors=1;
                  return false;
                }            
           }
           jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
      }); 
    if (errors==1){
        alert('aa');
        return; 
    }  
    
      /*alert('a111111111111a');*/
/*    alert(cust_id);*/
     url="ajaxrequest/add_vehicle_plan_history_info.php?token=<?php echo $token;?>";                     
        /*alert(url);*/
     postData = {'PostData': jsonArr };
     //postData = {'PostData': 1234 };
     //alert(postData.PostData);
     xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA"); 
    }       
function GetResponseA(str){
    // alert(str);
    document.getElementById('dvMSG').innerHTML=str;
} 
function getPaymentHistory()
{
    $('.loader').show();
    $.post("ajaxrequest/payment_history.php?token=<?php echo $token;?>",
            {
                custId : $('#cust_id').val()
            },
            function (data)
            {
                /*alert(data);*/
                $("#dvassign").html(data);
                
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
function getEditBillingProfile()
{
    $('.loader').show();
    $.post("ajaxrequest/edit_billing_profile.php?token=<?php echo $token;?>",
            {
                cust_id : $("#cust_id").val()
            },
            function (data)
            {
                $("#dvassign").html(data);
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
function getBillingProfile(){
    $.post("ajaxrequest/billing_profile.php?token=<?php echo $token;?>",
            function (data)
            {
                $("#dvassign").html(data);
            });
}
function UpdateBillingProfile()
{
    $.post("ajaxrequest/update_billing_profile.php?token=<?php echo $token;?>",
            {
                billId : $("#billId").val(),
                cust_id : $("#cust_id").val(),
                paymentModeB : $("#paymentModeB").val(),
                billDeliveryModeB : $("#billDeliveryModeB").val(),
                paymentPeriodB : $("#paymentPeriodB").val(),
                pickupModeB : $("#pickupModeB").val(),
                customerTypeB : $("#customerTypeB").val()
            },
            function (data)
            {
                $("#dv_Msg").html(data);
            });
}
function createBillingProfile()
{
    $.post("ajaxrequest/create_billing_profile.php?token=<?php echo $token;?>",
            {
                cust_id : $("#cust_id").val(),
                paymentModeB : $("#paymentModeB").val(),
                billDeliveryModeB : $("#billDeliveryModeB").val(),
                paymentPeriodB : $("#paymentPeriodB").val(),
                pickupModeB : $("#pickupModeB").val(),
                customerTypeB : $("#customerTypeB").val()
            },
            function (data)
            {
                $("#dvMsg").html(data);
            });
}
// ---------------------------- Show History ------------------------//
$(document).on("click","#showHistory", function(){
    $('.loader').show();
    $.post("ajaxrequest/show_plan_history.php?token=<?php echo $token;?>",
                {
                    cust_id : $('#cust_id').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#dvassign").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });  
})
$(document).on("click","#showEdit", function(){
    $('.loader').show();
    $.post("ajaxrequest/edit_payment_details.php?token=<?php echo $token;?>",
                {
                    cust_id : $('#cust_id').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#dvassign").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });  
})
$(document).on("click","#add_vehicle", function(){
    $('.loader').show();
    $.post("ajaxrequest/add_vehicle.php?token=<?php echo $token;?>",
                {
                    cust_id : $('#cust_id').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#dvassign").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                        
                });  
})
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
                    customer_id : $("#cust_id").val(),
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
                    enter_payble_amt : $("#payble_amt").val(),
                    hiddenInvoiceID : $("#hiddenInvoiceID").val(),
                    total_amt : $("#total_amt").val(),
                    adjestmentAmt : $("#adjestmentAmt").val(),
                    pending_payable_amt : $("#payable_amt").val(),
                    rent_discount_amount : $("#rent_discount_amount").val()
                },
                function(data){
                    // alert(data);
                    $("#dv_success").html(data);
                    
                });
    }
}
// export CSV
$(document).ready(function () {
     console.log("HELLO")
            function exportTableToCSV($table, filename) {
                console.log("HELLO")
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')

                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character

                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';

                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';

                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                // For IE (tested 10+)
                if (window.navigator.msSaveOrOpenBlob) {
                    var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                        type: "text/csv;charset=utf-8;"
                    });
                    navigator.msSaveBlob(blob, filename);
                } else {
                    $(this)
                        .attr({
                            'download': filename
                            ,'href': csvData
                            //,'target' : '_blank' //if you want it to open in a new window
                    });
                }

                //------------------------------------------------------------
                // Helper Functions 
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){
                     
                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td'); 
                    if(!$cols.length) $cols = $row.find('th');  

                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table 
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();

                    return $text.replace('"', '""'); // escape double quotes

                }
            }


            // This must be a hyperlink
          $(document).on("click","#export", function(){
                // var outputFile = 'export'
                var outputFile = window.prompt("Please Enter the name your output file.") || 'DeviceAmtReport';
                outputFile = outputFile.replace('.csv','') + '.csv'
                 
                // CSV
                exportTableToCSV.apply(this, [$('#dvData > table'), outputFile]);
                
                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
         })
//end
function getPaymentAdjustmentDetails(obj){
    $.post("ajaxrequest/payment_adjustment_history.php?token=<?php echo $token;?>",
                {
                    paymentId : obj
                },
                function(data){
                    // alert(data);
                    $(".modal-content").html(data);
                    
                });
}
function get_device_amt_payment_details(obj){
    $.post("ajaxrequest/device_payment_details.php?token=<?php echo $token;?>",
    {
        estimateId : obj
    },
    function(data){
        // alert(data);
        $(".modal-content").html(data);            
    });
}
// add device discount amt
function add_discount_amt(obj){
    $.post("ajaxrequest/percentage_amt.php?token=<?php echo $token;?>",
    {
        invId : obj,
        rupeeAmt : $("#discount_amt").val()
    },
    function(data){
        // alert(data);
        $("#MsgDv").html(data);            
    });
}
// Device Payment Form
function get_form_device_payment(obj){
    $.post("ajaxrequest/make_device_payment_form.php?token=<?php echo $token;?>",
    {
        estimateId : obj,
        customer_name : $("#customer_name").val(),
        discount : $("#discount").val(),
        amt : $("#amt").val()
    },
    function(data){
        // alert(data);
        $(".modal-content").html(data);            
    });
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
        Customer Balance
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Customer Balance</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Orgranization <i class="red">*</i></span>
                        <select name="cust_id" id="cust_id" onchange="getClient()" class="form-control drop_down select2" style="width: 100%">
                            <option value="">Select Orgranization</option>                         
                            <?php $Country=mysql_query("SELECT B.cust_id as custId, A.Company_Name as companyName 
                                                        FROM tblcallingdata as A 
                                                        INNER JOIN tbl_customer_master as B 
                                                        ON A.id = B.callingdata_id
                                                        WHERE A.status = '1'
                                                        ORDER BY A.Company_Name");                              
                                  while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['custId']; ?>">
                            <?php echo stripslashes(ucfirst($resultCountry['companyName'])); ?></option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <!-- <div class="col-lg-6 col-sm-6 custom_field"> Custom field
                        <span>&nbsp;</span><br>
                        <input type="button" name="Search" onclick="getClient()" value="Search" class="btn btn-primary btn-sm"/>
                    </div> end custom field -->
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Details</h3> -->
            </div>
            <div class="box-body">
                <div id="divshow" class="col-lg-12"><!-- divshow -->
                    <!-- Show Content from ajax page -->
                </div> <!-- end divshow -->
                <div id="dvajax" class="col-lg-12 table-responsive"><!-- dvajax -->
                    
                </div><!-- end dvajax -->
            </div>
            <!-- /.box-body -->
        </div>
        </form>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<!--- Modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
    </div>
  </div>
</div>
<!-- End Modal -->
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
         <td class="col-md-4"><input type="button" name="submit" id="submit" onClick="getData();" class="btn btn-primary btn-sm" value="Submit"> <input type="reset" name="reset" id="reset" class="btn btn-primary btn-sm" value="Reset"></td>
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