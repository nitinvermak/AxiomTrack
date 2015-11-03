<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
include("includes/simpleimage.php");
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
	session_destroy();
	header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['user_category_id']!=1) 
{
		header("location: home.php?token=".$token);
}
$error =0;
if(isset($_REQUEST['cust_id']) && $_REQUEST['cust_id']){
$queryArr=mysql_query("SELECT A.cust_id, A.calling_product, B.Company_Name, B.created FROM tbl_customer_master as A 
					   INNER JOIN  tblcallingdata as B 
					   ON A.callingdata_id = B.id WHERE A.cust_id =".$_REQUEST['cust_id']);
$result=mysql_fetch_assoc($queryArr);
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript">
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
    
	  alert('a111111111111a');
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
</script>
<script>
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
						$("#divShow").html(data);				
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
						$("#divShow").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	 
})
// --------------------------- End -------------------------------//
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
		//alert(deviceType);
		$(parentId).find('.device_amt').prop("disabled", false);
		$(parentId).find('.device_rent').prop("disabled", false);
		$(parentId).find('.rent_frq').prop("disabled", false);
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
    	<h1>Update Payment Profile</h1>
      <hr>
    </div>
    <div class="col-md-12">
    	
        <form name='myform' id="myform" action="" method="post">
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['cust_id']) and $_GET['cust_id']>0){ echo $_GET['cust_id']; }?>"/>
        <input type="hidden" name="device_id" id="device_id" value="<?php $query = mysql_query("select device_id from tbldeviceid")?>"/>
        <div class="table table-responsive">
    	<table border="0">
        <tr >
        <td>Customer Id*</td>
        <td><input type="text" name="cust_id" id="cust_id" class="form-control text_box" value="<?php if(isset($result['cust_id'])) echo $result['cust_id'];?>" readonly></td>
        <td>Customer Name</td>
        <td><input type="text" name="customer_name" id="customer_name" value="<?php if(isset($result['cust_id'])) echo $result['Company_Name'];?>" class="form-control text_box" readonly></td>
        <td>&nbsp;</td>
        </tr>
        <tr >
        <td>Activation Date</td>
        <td><input type="text" name="createdate" id="createdate" value="<?php if(isset($result['cust_id'])) echo $result['created'];?>" class="form-control text_box" readonly></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        
        <tr>
        <td height="34" colspan="5">
        <input type="button" name="add_vehicle" id="add_vehicle" value="Add Payment Details" class="btn btn-info btn-sm">            
        <input type="button" name="showHistory" id="showHistory" value="View Plan & History" class="btn btn-info btn-sm">            
        <input type="button" name="showEdit" id="showEdit" value="Edit Plan" class="btn btn-info btn-sm">
        
        <input type="button" name="manageServiceBranch" id="manageServiceBranch" value="Add Service Branch" class="btn btn-info btn-sm">
         <input type="button" name="editServiceBranch" id="editServiceBranch" value="Edit Service Branch" class="btn btn-info btn-sm">
        <input type="button" name="back" id="back" value="Back" 
        onclick="window.location='manage_customer_payment_profile.php?token=<?php echo $token ?>'" class="btn btn-info btn-sm">        
        </td>
        </tr>
      </table>
  	  </div>
       <div id="divShow">
      <!-- Show payment history -->
      </div>
      </form>
      </div>
      <div class="col-md-3">
      </div>
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
<!-- hidden loader division -->
<div class="loader">
	<img src="images/loader.gif" alt="loader">
</div>
<!-- end hidden loader division-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>