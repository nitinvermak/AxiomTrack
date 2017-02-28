<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
    session_destroy();
    header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') {
    session_destroy();
    header("location: index.php?token=".$token);
}
//Delete single record
if(isset($_GET['id'])){
        $id = $_GET['id'];
        $delete_single_row = "DELETE FROM tblcallingdata WHERE id='$id'";
        $delete = mysql_query($delete_single_row);
    }
    if($delete)
    {
        echo "<script> alert('Record Delted Successfully'); </script>";
    }
//End
//Delete multiple records
if(count($_POST['delete_selected'])>0 && (isset($_POST['delete_selected'])) )
   {               
        if(isset($_POST['linkID']))
            {
              foreach($_POST['linkID'] as $chckvalue)
              {
                $sql = "DELETE FROM tblcallingdata WHERE id='$chckvalue'";
                $result = mysql_query($sql);
               }
               if($result)
               {
               echo "<script> alert('Records Deleted Successfully'); </script>";
               }
             }    
   }
//End
// In Active 
if(isset($_POST['inactive']))
    {
        $custid = mysql_real_escape_string($_POST['cust_id']);
        $sql = "UPDATE tbl_customer_master SET activeStatus = 'N', paymentActiveFlag='N' Where cust_id = '$custid'";
        // echo $sql;
        $result = mysql_query($sql);
        if($result)
        {
            echo "<script> alert('Customer In Active Successfully'); </script>";
        }
    }
//End
// Active 
if(isset($_POST['active']))
    {
        $custid = mysql_real_escape_string($_POST['cust_id']);
        $sql = "UPDATE tbl_customer_master SET activeStatus = 'Y', paymentActiveFlag='Y' Where cust_id = '$custid'";
        // echo $sql;
        $result = mysql_query($sql);
        if($result)
        {
            echo "<script> alert('Customer Active Successfully'); </script>";
        }
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
<script type="text/javascript" src="js/add_old_gps.js"></script>
<script  src="js/ajax.js"></script>
<script>
// send ajax request
function getClient(){
        $('.loader').show();
        $.post("ajaxrequest/customer_profile_details.php?token=<?php echo $token;?>",
                {
                    searchText : $('#searchText').val()
                    
                },
                    function( data){
                        /*alert(data);*/
                        $("#divshow").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });  
}
//end
// send ajax request
function getClient1(){
        $('.loader').show();
        $.post("ajaxrequest/customer_profile_details.php?token=<?php echo $token;?>",
                {
                    customer_Id : $('#customer_Id').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#divshow").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });  
}
//end
function getValue1()
{
    custid = document.getElementById("custid").value;
    vehicle_id = document.getElementById("vehicle_id").value;
    installation_date = document.getElementById("installation_date").value;
    device_type = document.getElementById("device_type").value;
    device_amt = document.getElementById("device_amt").value;
    device_rent = document.getElementById("device_rent").value;
    rent_frq = document.getElementById("rent_frq").value;
    installation_charges = document.getElementById("installation_charges").value;
    instalment = document.getElementById("instalment").value;
    NoOfInstallation = document.getElementById("NoOfInstallation").value;
    instalment_frq = document.getElementById("instalment_frq").value;
    /*plan_end = document.getElementById("plan_end").value;*/
    alert(vehicle_id);
}
function getValue(a){
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
     /*url="ajaxrequest/test.php?token=<?php echo $token;?>";  */               
        /*alert(url);*/
     
     postData = {'PostData': jsonArr };
     //postData = {'PostData': 1234 };
     //alert(postData.PostData);
     xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA"); 
    }

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
          document.getElementById('divShow').innerHTML=str;
    
         } 
// ------------- call ajax request when user assign branch services -------------- //
$(document).on("click","#save", function(){
    $.post("ajaxrequest/assign_service_data.php?token=<?php echo $token;?>",
                {
                    cust_id : $('#cust_id').val(),
                    service_branch : $('#service_branch').val(),
                    service_area_mgr : $('#service_area_mgr').val(),
                    service_exe : $('#service_exe').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#alert").html(data);
                });  
})
// --------------------------- End  -----------------------------------------------//
// ----------------------- call ajax request when user edit assign branch services --------------------//
$(document).on("click","#update", function(){
    $.post("ajaxrequest/update_assign_service_branch.php?token=<?php echo $token;?>",
                {
                    cust_id : $('#cust_id').val(),
                    service_branch : $('#service_branch').val(),
                    service_area_mgr : $('#service_area_mgr').val(),
                    service_exe : $('#service_exe').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#alert").html(data);
                });  
})
// --------------------------- End --------------------------------------------------//
// ---------------- Add Payments Details --------------------------------------- //
$(document).on("click","#add_vehicle", function(){
    $('.loader').show();
    $.post("ajaxrequest/add_vehicle.php?token=<?php echo $token;?>",
                {
                    cust_id : $('#cust_id').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#divShow").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                        
                });  
})
// --------------------------- End  -------------------------------------------//
// --------------------------- Show Edit ------------------------------///
$(document).on("click","#showEdit", function(){
    $('.loader').show();
    $.post("ajaxrequest/edit_payment_details.php?token=<?php echo $token;?>",
                {
                    cust_id : $('#cust_id').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#divShow").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });  
})
// ------------------------- End ---------------------//
// ---------------------------- Show History ------------------------//
$(document).on("click","#showHistory", function(){
    $('.loader').show();
    $.post("ajaxrequest/show_plan_history.php?token=<?php echo $token;?>",
                {
                    cust_id : $('#cust_id').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#divShow").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });  
})
// ------------------------------ End -----------------------------//
// -------------------------- Add Service Branch ---------------------------//
$(document).on("click","#manageServiceBranch", function(){
    $('.loader').show();
    $.post("ajaxrequest/assign_service.php?token=<?php echo $token;?>",
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
// ----------------------------- End -------------------------------------//
// --------------------------- Edit Service Branch -----------------------//
$(document).on("click","#editServiceBranch", function(){
    $('.loader').show();
    $.post("ajaxrequest/edit_service_branch.php?token=<?php echo $token;?>",
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
// --------------------------- End -------------------------------//
//------------------------- send ajax request when click button Inactive Vehicle-----------//
$(document).on("click","#inActive", function(){
    $('.loader').show();
    $.post("ajaxrequest/vehicle_status.php?token=<?php echo $token;?>",
            {
                cust_id : $('#cust_id').val()
            },
            function (data)
            {
                $("#dvassign").html(data);
                // $('#example').DataTable();
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
})
//-------------------------end------------------------------------------------------//
//----------------send ajax request when click inactive vehilce -------------------//
function getInactive(obj)
{
    /*alert(obj);*/
    $('.loader').show();
    $.post("ajaxrequest/vehicle_inactive.php?token=<?php echo $token;?>",
            {
                deviceId : obj
            },
            function (data)
            {
                $("#divShow").html(data);
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
//----------------------End----------------------------//
//----------------send ajax request when click inactive vehilce -------------------//
function getActive(obj)
{
    /*alert(obj);*/
    $('.loader').show();
    $.post("ajaxrequest/vehicle_active.php?token=<?php echo $token;?>",
            {
                deviceId : obj
            },
            function (data)
            {
                $("#divShow").html(data);
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
//----------------------End----------------------------//
// ----------------- get Pending Payment Report ---------------//
function getPendingReport()
{
    $('.loader').show();
    $.post("ajaxrequest/pending_payment_details.php?token=<?php echo $token;?>",
            {
                custId : $('#cust_id').val()
            },
            function (data)
            {
                /*alert(data);*/
                $("#divShow").html(data);
                // $('#example3').DataTable({ "bPaginate": false });
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
function getRentPending()
{
    $('.loader').show();
    $.post("ajaxrequest/rent_pending_payment_details.php?token=<?php echo $token;?>",
            {
                custId : $('#cust_id').val()
            },
            function (data)
            {
                /*alert(data);*/
                $("#divShow").html(data);
                $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
function getDueDate()
{
    $('.loader').show();
    $.post("ajaxrequest/create_due_date.php?token=<?php echo $token;?>",
            {
                custId : $('#cust_id').val()
            },
            function (data)
            {
                /*alert(data);*/
                $("#divShow").html(data);
                $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
function getDueDataValue()
{
    $('.loader').show();
    $.post("ajaxrequest/rent_payment_due_date_details.php?token=<?php echo $token;?>",
            {
                custId : $('#cust_id').val(),
                dueDate : $('#dueDate').val()
            },
            function (data)
            {
                /*alert(data);*/
                $("#divShow").html(data);
                
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
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
                $("#divShow").html(data);
                
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
            });
}
// ----------------- End Pending Payment Report ------//
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
                $("#divAmt").html(data);
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
                vehicleId : obj
            },
            function (data)
            {
                $("#dvMsg").html(data);
                $(".loader").removeAttr("disabled");
                $('.loader').fadeOut(1000);
                getPendingReport();
                // $("#receivedAmt"+obj).prop("disabled", true);
                // $("#linkID"+obj).prop("disabled", true);
                // $("#save"+obj).prop("disabled", true);
            });
}
// End
// Show Customer User Create form
function getUserform()
{
    /*alert('asfasd');*/
    $.post("ajaxrequest/create_users.php?token=<?php echo $token;?>",
            function (data)
            {
                $("#dvassign").html(data);
            });
}
// get Billing profile 
function getBillingProfile(){
    $.post("ajaxrequest/billing_profile.php?token=<?php echo $token;?>",
            function (data)
            {
                $("#divShow").html(data);
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
function getEditBillingProfile()
{
    $.post("ajaxrequest/edit_billing_profile.php?token=<?php echo $token;?>",
            {
                cust_id : $("#cust_id").val()
            },
            function (data)
            {
                $("#divShow").html(data);
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
                $("#dvMsg").html(data);
            });
}
// end billing profile
function createUser()
{
    $.post("ajaxrequest/create_customer_login.php?token=<?php echo $token;?>",
            {
                cust_id : $("#cust_id").val(),
                name : $("#name").val(),
                email : $("#email").val(),
                mobile : $("#mobile").val(),
                user_name : $("#user_name").val(),
                password  : $("#password").val(),
                id : $("#id").val()
            },
            function (data)
            {
                $("#dvMsg").html(data);
            });
}
// End

// --------------------- History View ------------------------------//
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
    $.post("ajaxrequest/show_details.php?token=<?php echo $token;?>",
                {
                    vehicle_id : vehicleId
                },
                    function( data){
                        /*alert(data);*/
                        $(divId).html(data);
                });  
}
// ------------------------ End ----------------------------------//

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
// calculate installment amt
function calTotal(obj)
{
    var deviceAmt = document.getElementById('device_amt'+obj); 
    var selectedText = deviceAmt.options[deviceAmt.selectedIndex].text;
    var NoOfInstallation = document.getElementById('NoOfInstallation'+obj).value; 
    document.getElementById('installationAmount'+obj).value = selectedText / NoOfInstallation;
}
//end
//Vehicle Entry
function getVehicleEntryForm(){
  $('.loader').show();
  $.post("ajaxrequest/new_vehicle_entry.php?token=<?php echo $token;?>",
  function (data){
    $("#dvassign").html(data);
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
    $(".loader").removeAttr("disabled");
    $('.loader').fadeOut(1000);         
  });
}
function getTkt(){
  $('.loader').show();
  $.post("ajaxrequest/show_ticket_id.php?token=<?php echo $token;?>",
  {
    technician : $("#technician").val()
  },
  function( data ){
    $("#divTicketId").html(data);
    $(".select2").select2();
    $(".loader").removeAttr("disabled");
    $('.loader').fadeOut(1000);  
  });  
}
function addNewVehicle(){
  var vehicleNo = document.getElementById("vehicle_no").value; 
  var technician = document.getElementById("technician").value;
  var mobile_no = document.getElementById("mobile_no").value;
  var device = document.getElementById("device").value;
  var imei = document.getElementById("imei").value;
  var server_details = document.getElementById("server_details").value;
  var insatallation_date = document.getElementById("insatallation_date").value;

  if(vehicleNo == "")
  {
    alert("Please Provide Vehicle No.");
  }
  else if(technician == ""){
    alert("Please Select Technician");
  }
  else if(mobile_no == ""){
    alert("Please Select Mobile No.");
  }
  else if(device == ""){
    alert("Please Select Device Id");
  }
  else if(imei == ""){
    alert("Please Select IMEI");
  }
  else if(server_details == ""){
    alert("Please Select Server");
  }
  else if(insatallation_date == ""){
    alert("Please Provide Installation Date");
  }
  else{
    $('.loader').show();
    $.post("ajaxrequest/save_new_vehicle.php?token=<?php echo $token;?>",
    {
      customerId : $("#cust_id").val(),
      vehicleNo : $("#vehicle_no").val(),
      technician : $("#technician").val(),
      mobileNo : $("#mobile_no").val(),
      imeiNo : $("#imei").val(),
      deviceId : $("#device").val(),
      model : $("#dmodel").val(),
      server : $("#server_details").val(),
      insatallationDate : $("#insatallation_date").val(),
    },
    function( data ){
      // alert(data);
      $("#dvMsg").html(data);
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);  
    }); 
  }
}
// End Vehicle Entry
// Edit Repair Vehicle 
function getRepairVehicleData(){
  $('.loader').show();
  $.post("ajaxrequest/edit_repair_vehicle.php?token=<?php echo $token;?>",
  {
      customerId : $("#cust_id").val()
  },
  function( data ){
      // alert(data);
      $("#dvassign").html(data);
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);  
  }); 
}
function ChangeMobileNo(obj){
  $('.loader').show();
  $.post("ajaxrequest/change_mobileno.php?token=<?php echo $token;?>",
  {
    mobileNo : obj
  },
  function( data ){
      // alert(data);
      $(".modal-content").html(data);
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);  
  }); 
}
function reAllocateMobile(){
  var mobileNo = document.getElementById("re_mobileNo").value;
  var branch = document.getElementById("re_branch").value;
  var technician = document.getElementById("re_technician").value;
  if(mobileNo == "")
  {
    alert("Please Provide Mobile No");
  }
  else if(branch == ""){
    alert("Please Select Branch");
  }
  else if(technician == ""){
    alert("Please Select Technician");
  }
  else{
    $('.loader').show();
    $.post("ajaxrequest/re_allocate_mobile.php?token=<?php echo $token;?>",
    {
      mobileNo : $("#re_mobileNo").val(),
      branch : $("#re_branch").val(),
      technician : $("#re_technician").val(),
    },
    function( data ){
      // alert(data);
      $("#dvSuccess").html(data);
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);  
    }); 
  }
}
function ChangeDevice(obj){
  $('.loader').show();
  $.post("ajaxrequest/change_device.php?token=<?php echo $token;?>",
  {
    deviceId : obj
  },
  function( data ){
      // alert(data);
      $(".modal-content").html(data);
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);  
  }); 
}
function reAllocateDevice(){
  var deviceId = document.getElementById("re_deviceId").value;
  var branch = document.getElementById("re_debranch").value;
  var technician = document.getElementById("re_detechnician").value;
  if(deviceId == "")
  {
    alert("Please Provide Mobile No");
  }
  else if(branch == ""){
    alert("Please Select Branch");
  }
  else if(technician == ""){
    alert("Please Select Technician");
  }
  else{
    $('.loader').show();
    $.post("ajaxrequest/re_allocate_device.php?token=<?php echo $token;?>",
    {
      deviceId : $("#re_deviceId").val(),
      branch : $("#re_debranch").val(),
      technician : $("#re_detechnician").val(),
    },
    function( data ){
      // alert(data);
      $("#dvSuccess").html(data);
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);  
    }); 
  }
}
function closeForm(){
  getRepairVehicleData();
}
function editVehicleForm(obj){
  $('.loader').show();
  $.post("ajaxrequest/edit_vehicle_form.php?token=<?php echo $token;?>",
  {
    vehicleId : obj
  },
  function( data ){
      // alert(data);
      $(".modal-content").html(data);
      $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000); 
  }); 
}
function UpdateOldVehicle(){
  var vehicle_no = document.getElementById("vehicle_no").value;
  var technician = document.getElementById("technician").value;
  var mobile_no = document.getElementById("mobile_no").value;
  var device = document.getElementById("device").value;
  var imei = document.getElementById("imei").value;
  var dmodel = document.getElementById("dmodel").value;
  var server_details = document.getElementById("server_details").value;
  var insatallation_date = document.getElementById("insatallation_date").value;

  if(vehicle_no == ""){
    alert("Please Provide Vehicle No.");
  }
  else if(technician == ""){
    alert("Please Select Technician");
  }
  else if(mobile_no == ""){
    alert("Please Select Mobile No.");
  }
  else if(device == ""){
    alert("Please Select Device Id");
  }
  else if(imei == ""){
    alert("Please Select IMEI No.");
  }
  else if(dmodel == ""){
    alert("Please Select Device Modal");
  }
  else if(server_details == ""){
    alert("Please Select Server");
  }
  else if(insatallation_date == ""){
    alert("Please Provide Installation Date");
  }
  else{
    $('.loader').show();
    $.post("ajaxrequest/save_old_vehicle.php?token=<?php echo $token;?>",
    {
      vehicleId : $("#vehicleId").val(),
      vehicle_no : $("#vehicle_no").val(),
      technician : $("#technician").val(),
      mobile_no : $("#mobile_no").val(),
      device : $("#device").val(),
      imei : $("#imei").val(),
      dmodel : $("#dmodel").val(),
      server_details : $("#server_details").val(),
      insatallation_date : $("#insatallation_date").val()
    },
    function( data ){
      // alert(data);
      $("#dvSuccess").html(data);
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);  
    }); 
  }
}
// End Edit Repair Vehicle
// Rent Amount Adjustment
function getPaymentDetails(obj){
  $('.loader').show();
  $.post("ajaxrequest/rent_amt_details.php?token=<?php echo $token;?>",
  {
    invoiceId : obj
  },
  function( data ){
    // alert(data);
    $("#modal_lg").html(data);
    $(".loader").removeAttr("disabled");
    $('.loader').fadeOut(1000);  
  }); 
}
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
function addPercent(invoiceId){    
  v3='#rupee'+invoiceId;
  if($("#discountAmt"+invoiceId).val() == "0"){
    alert("Please Select Type of Discount");
    $("#discountAmt"+invoiceId).focus();
  }
  else if($("#rupee"+invoiceId).val() == ""){
    alert("Please Provide Discount");
    $("#rupee"+invoiceId).focus();
  }
  else{
    $.post("ajaxrequest/percentage_amt.php?token=<?php echo $token;?>",
    {
      invId: invoiceId,
      rupeeAmt : $(v3).val(),
    },
    function(data){
      $('#dvMsg1').html(data);
      getRentPending();
    });  
  }
}
//End
function getDeviceRentAmount(){
  if($("#paymentId").val() == ""){
    alert("Please Select Payment Id");
    $("#paymentId").focus();
  }
  else if($("#adjustmentAmt").val() == ""){
    alert("Please Provide Adjustment Amt.");
    $("#adjustmentAmt").focus();
  }
  else{
    $('.loader').show();
    $.post("ajaxrequest/device_rent_amount_details.php?token=<?php echo $token;?>",
    {
      paymentId : $("#paymentId").val(),
      invoiceId : $('#invoiceId').val(),
      disAmt : $('#disAmt').val(),
      adjustmentAmt : $('#adjustmentAmt').val(),
      adjestmentAmt : $('#adjestmentAmt').val(),
      total_amt : $('#total_amt').val(),
      prev_rcd_amt : $('#prev_rcd_amt').val()
    },
    function (data)
    {
      /*alert(data);*/
      $("#dvMsg").html(data);
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);
      getRentPending();
    });
  }
}
// End Rent Amount Adjustment
// generate next due date
function generateNextDDate(custId){
  $('.loader').show();
  $.post("ajaxrequest/manually_invoice.php?token=<?php echo $token;?>",
  {
    cust_id : custId
  },
  function (data)
  {
    /*alert(data);*/
    $("#divShow").html(data);
    $( ".next_due_date" ).datepicker({dateFormat: 'yy-mm-dd'});
    $(".loader").removeAttr("disabled");
    $('.loader').fadeOut(1000);
  });
}
// make all due date same
function makeAllDateSame()
{
  //alert("Check box changed");
  var firstTextBoxValue="";
  var i=0;
  $('#example').find('input.next_due_date').each(function(){
  if(i==0){
    firstTextBoxValue=$(this).val();
  }
  else{
    $(this).val(firstTextBoxValue);
  }
  $(this).id;
  i++;
  //console.log($(this).val()+"ID="+$(this).ID);
  });
}
// end make all due date same
// Send Data via ajax request
function getDueDateData(){
  $('.loader').show();
  jsonArr = []
  $(".next_due_date").each(function(){
    jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
  });
  console.log(jsonArr);
  url="ajaxrequest/manually_invoice_next_due_date.php?token=<?php echo $token;?>";
  postData = {'PostData': jsonArr };
  xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA");
}
function GetResponseA(str){
      document.getElementById('dvMsg').innerHTML=str;
      $(".loader").removeAttr("disabled");
      $('.loader').fadeOut(1000);
} 
// end
// end generate next due date 
// Get GPS Username or password 
function getGPSUsernameOrPassword(){
  alert('obj');
}
// End 
// Edit Customer Details
function getEditCustomerDetails(){
  $('.loader').show();
  $.post("ajaxrequest/edit_customer_profile_form.php?token=<?php echo $token;?>",
  {
    organization : $("#cust_id").val(),
  },
  function (data)
  {
    /*alert(data);*/
    $("#dvassign").html(data);
    $(".loader").removeAttr("disabled");
    $('.loader').fadeOut(1000);
  });
}
function CallState()
  { 
    country = document.getElementById("country").value;
    url="ajaxrequest/getstate.php?country="+country+"&token=<?php echo $token;?>";
    /*alert(url);*/
    xmlhttpPost(url,country,"GetState");
  }
  function GetState(str)
  {
    /*alert(str);*/
    document.getElementById('Divstate').innerHTML=str;
  }
function CallDistrict()
  {
    state = document.getElementById("state").value;
    url="ajaxrequest/get_district.php?state="+state+"&token=<?php echo $token;?>";
    /*alert(url);*/
    xmlhttpPost(url,state,"GetDistrict");
  } 
  function GetDistrict(str)
  {
    /*alert(str);*/
    document.getElementById('divdistrict').innerHTML=str;
  }
function CallCity()
  {
    district = document.getElementById("district").value;
    url="ajaxrequest/get_city.php?district="+district+"&token=<?php echo $token;?>";
    /*alert(url);*/
    xmlhttpPost(url,state,"GetCity");
  }
  function GetCity(str)
  {
    /*alert(str);*/
    document.getElementById('divcity').innerHTML=str;
  }
  
function CallArea()
  {
    city = document.getElementById("city").value;
    url="ajaxrequest/get_area.php?city="+city+"&token=<?php echo $token;?>";
    /*alert(url);*/
    xmlhttpPost(url,city,"GetArea");
  }
  function GetArea(str)
  {
    /*alert(str);*/
    document.getElementById('divarea').innerHTML=str;
  } 

function CallPincode()
  {
    area = document.getElementById("area").value;
    url="ajaxrequest/get_pincode.php?area="+area+"&token=<?php echo $token;?>";
    /*alert(url);*/
    xmlhttpPost(url,city,"GetPincode");
  }
  function GetPincode(str)
  {
    /*alert(str);*/
    document.getElementById('divpincode').innerHTML=str;
  }
  // Update Customer Details
  function Update_CustomerDetails(){
    if ($("#first_name").val() == "") {
      alert("Please Provide First Name");
      $("#first_name").focus();
    }
    else if ($("#last_name").val() == "") {
      alert("Please Provide Last Name");
      $("#last_name").focus();
    }
    else if ($("#company").val() == "") {
      alert("Please Provide Company Name");
      $("#company").focus();
    }
    else if ($("#phone").val() == "") {
      alert("Please Provide Phone No.");
      $("#phone").focus();
    }
    else if ($("#mobile").val() == "") {
      alert("Please Provide Mobile No.");
      $("#mobile").focus();
    }
    else if ($("#email").val() == "") {
      alert("Please Provide Email Address");
      $("#email").focus();
    }
    else if ($("#country").val() == "") {
      alert("Please Select Country");
      $("#country").focus();
    }
    else if ($("#state").val() == "") {
      alert("Please Select State");
      $("#state").focus();
    }
    else if ($("#district").val() == "") {
      alert("Please Select District");
      $("#district").focus();
    }
    else if ($("#city").val() == "") {
      alert("Please Select City");
      $("#city").focus();
    }
    else if ($("#area").val() == "") {
      alert("Please Select Area");
      $("#area").focus();
    }
    else if ($("#pin_code").val() == "") {
      alert("Please Select Pincode");
      $("#pin_code").focus();
    }
    else if ($("#pin_code").val() == "") {
      alert("Please Select Pincode");
      $("#pin_code").focus();
    }
    else if ($("#Address").val() == "") {
      alert("Please Provide Address");
      $("#Address").focus();
    }
    else if ($("#branch").val() == "") {
      alert("Please Provide Branch");
      $("#branch").focus();
    }
    else if ($("#telecaller").val() == "") {
      alert("Please Provide Telecaller");
      $("#telecaller").focus();
    }
    else if ($("#datasource").val() == "") {
      alert("Please Provide Datasource");
      $("#datasource").focus();
    }
    else if ($("#deviceAmt").val() == "") {
      alert("Please Select Device Amt.");
      $("#deviceAmt").focus();
    }
    else if ($("#deviceRent").val() == "") {
      alert("Please Select Device Rent Amt.");
      $("#deviceRent").focus();
    }
    else if ($("#installationChrg").val() == "") {
      alert("Please Select Installation Charges");
      $("#installationChrg").focus();
    }
    else if ($("#rentFrq").val() == "") {
      alert("Please Select Rent Frq.");
      $("#rentFrq").focus();
    }
    else if ($("#customerType").val() == "") {
      alert("Please Select Customer Type");
      $("#customerType").focus();
    }
    else if ($("#callingdate").val() == "") {
      alert("Please Provide Calling Date");
      $("#callingdate").focus();
    }
    else{
      $('.loader').show();
      $.post("ajaxrequest/update_customer_details.php?token=<?php echo $token;?>",
      {
        callingdata_id : $("#callingdata_id").val(),
        organization : $("#cust_id").val(),
        first_name : $("#first_name").val(),
        last_name : $("#last_name").val(),
        company : $("#company").val(),
        phone : $("#phone").val(),
        mobile : $("#mobile").val(),
        email : $("#email").val(),
        country : $("#country").val(),
        state : $("#state").val(),
        district : $("#district").val(),
        city : $("#city").val(),
        area : $("#area").val(),
        pin_code : $("#pin_code").val(),
        Address : $("#Address").val(),
        branch : $("#branch").val(),
        telecaller : $("#telecaller").val(),
        datasource : $("#datasource").val(),
        deviceAmt : $("#deviceAmt").val(),
        deviceRent : $("#deviceRent").val(),
        installationChrg : $("#installationChrg").val(),
        rentFrq : $("#rentFrq").val(),
        installationChrg : $("#installationChrg").val(),
        rentFrq : $("#rentFrq").val(),
        customerType : $("#customerType").val(),
        callingdate : $("#callingdate").val()
      },
      function (data)
      {
        /*alert(data);*/
        $("#dvMsg").html(data);
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
      });
    }
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
        Customer Profile
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Customer Profile</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Client <i class="red">*</i></span>
                        <select name="searchText" id="searchText"
                        class="form-control drop_down select2" style="width: 100%">
                            <option value="">Select Orgranization</option>                         
                            <?php $Country=mysql_query("SELECT A.cust_id as custId, 
                                                        B.Company_Name as company 
                                                        FROM tbl_customer_master as A 
                                                        INNER JOIN tblcallingdata as B 
                                                        ON A.callingdata_id = B.id 
                                                        ORDER BY B.Company_Name");       
                                  while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['custId']; ?>">
                            <?php echo stripslashes(ucfirst($resultCountry['company'])); ?></option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>&nbsp;</span><br>
                        <input type="button" name="Search" onclick="getClient()" value="Search" class="btn btn-primary btn-sm"/>
                    </div> <!-- end custom field -->
                    <div class="clearfix"></div>
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Customer Id <i class="red">*</i></span>
                        <input type="text" name="customer_Id" id="customer_Id" class="form-control" style="width: 100%">
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>&nbsp;</span><br>
                        <input type="button" name="Search" onclick="getClient1()" value="Search" class="btn btn-primary btn-sm"/>
                    </div> <!-- end custom field -->
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Details</h3> -->
            </div>
            <div class="box-body">
                <div id="divshow" class="table-responsive">
                    <!-- Show Content from ajax page -->
                </div>
                <div class="col-md-12" id="dvassign">
                    <!-- Show Content From Ajax request page -->
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        </form>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<!-- Modal Form -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Modal -->
<!-- Modal Lg -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="modal_lg">
    </div>
  </div>
</div>
<!-- End Modal Lg -->
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