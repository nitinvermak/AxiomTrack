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
/*echo "ok11";*/
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
<script  src="js/ajax.js"></script>
<script>
function enable(){
	alert('akakaka');
	document.getElementById("device_type").disabled=false;
}
function ShowContacts()
	{
		cust_id = document.getElementById("cust_id").value;
		/*alert(cust_id);*/
		url="ajaxrequest/add_vehicle.php?cust_id="+cust_id+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,cust_id,"GetResponse");
	} 
function ShowEdit()
	{
		cust_id = document.getElementById("cust_id").value;
		/*alert(cust_id);*/
		url="ajaxrequest/edit_payment_details.php?cust_id="+cust_id+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,cust_id,"GetResponse");
	} 
function ShowHistory()
	{
		cust_id = document.getElementById("cust_id").value;
		/*alert(cust_id);*/
		url="ajaxrequest/show_plan_history.php?cust_id="+cust_id+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,cust_id,"GetResponse");
	}
function showDetails()
	{
		vehicle_id = document.getElementById("vehicle_id").value;
		/*alert(cust_id);*/
		url="ajaxrequest/show_details.php?vehicle_id="+vehicle_id+"&token=<?php echo $token;?>";
		alert(url);
		xmlhttpPost(url,vehicle_id,"GetDetails");
	} 
function GetDetails(str){
	document.getElementById('divHistory').innerHTML=str;
	}
function GetResponse(str){
	document.getElementById('divShow').innerHTML=str;
	}
</script>
<script type="text/javascript">
function checkCondition(){
	if(device_type.value == 1){
		instalment.disabled = true;
		NoOfInstallation.disabled = true;
		instalment_frq.disabled = true;
		instalment.value ="";
		NoOfInstallation.value = "";
		instalment_frq.value = "";
	}
	if(device_type.value == 2){
		instalment.disabled = true;
		NoOfInstallation.disabled = true;
		instalment_frq.disabled = true;
		device_amt.disabled = true;
		instalment.value ="";
		NoOfInstallation.value = "";
		instalment_frq.value = "";
		device_amt.value = "";
	}
	if(device_type.value == 3){
		downpayment.disabled = true;
		NoOfInstallation.disabled = true;
		instalment_frq.disabled = true;
		device_amt.disabled = true;
		downpayment.value ="";
		NoOfInstallation.value = "";
		instalment_frq.value = "";
		device_amt.value = "";
	}
	if(device_type.value == 4) {
		device_type.disabled = false;
		device_amt.disabled = false;
		device_rent.disabled = false;
		rent_frq.disabled = false;
		installation_charges.disabled = false;
		downpayment.disabled = false;
		NoOfInstallation.disabled = false;
		instalment_frq.disabled = false;
	}
	
	/*else{
		instalment.disabled = false;
		NoOfInstallation.disabled = false;
		instalment_frq.disabled = false;
		device_amt.disabled = false;
	}*/
}
</script>
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
	jsonArr= []
	jQuery(elements).map(function() {
           console.log( $(this).attr('id') + '=' + $(this).val());
		   jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
		   
      });
	 
	jQuery(elementsb).map(function() {
           console.log($(this).attr('id') + '=' + $(this).val());
		   jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
      }); 
	  
    /*alert(cust_id);*/
	 url="ajaxrequest/add_vehicle_Plan_Info.php?token=<?php echo $token;?>";	                 
		/*alert(url);*/
	 postData = {'PostData': jsonArr };
	 //postData = {'PostData': 1234 };
	 //alert(postData.PostData);
	 xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA");
 
 
	}	
function getValueHistoryPage(b){
    /*alert(b);
	alert('as');*/
	elements= '#'+b+'   input';
	elementsb= '#'+b+'   select'; 
	jsonArr= []
	jQuery(elements).map(function() {
           console.log( $(this).attr('id') + '=' + $(this).val());
		   jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
		   
      });
	 
	jQuery(elementsb).map(function() {
           console.log($(this).attr('id') + '=' + $(this).val());
		   jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
      }); 
	  
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
    	
        <form name='myform' action="" method="post" >
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
        </tr>
        <tr >
        <td>Activation Date</td>
        <td><input type="text" name="createdate" id="createdate" value="<?php if(isset($result['cust_id'])) echo $result['created'];?>" class="form-control text_box" readonly></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        
        <tr>
        <td height="34" colspan="4">
        <input type="button" name="add_vehicle" id="add_vehicle" value="Add Payment Details" class="btn btn-info btn-sm" onClick="ShowContacts()">            
        <input type="button" name="add_vehicle2" id="add_vehicle2" value="View Plan & History" class="btn btn-info btn-sm" onClick="ShowHistory()">            
        <input type="button" name="add_vehicle3" id="add_vehicle3" value="Edit Plan" class="btn btn-info btn-sm" onClick="ShowEdit()">
       <!-- <input type="button" name="estimateView" id="estimateView" value="Estimate View" class="btn btn-info btn-sm">-->
        </td>
        </tr>
      </table>
      <div id="divShow">
      </div>
      <div id="divHistory">
        	
      </div>
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
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>