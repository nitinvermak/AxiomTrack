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
// This code Execute when Vehicle Inactive
if(isset($_POST['submit']))
{
	$inactiveBy = $_SESSION['user_id'];
	$reason = mysql_real_escape_string($_POST['reason']);
	$vehicleId = mysql_real_escape_string($_POST['vehicleId']);
	$sqlInsert = "Insert into tblinactivevehicledata SET vehicleId = '$vehicleId', 
				  inactiveReason = '$reason', inactiveDate = Now(), inactiveBy = '$inactiveBy'";
	$resultInsert = mysql_query($sqlInsert);
	if($sqlInsert)
		{
			$_SESSION['sess_msg'] = 'Vehicle Inactivated Successfully';
		}
	$sqlUpdate = "UPDATE tbl_gps_vehicle_master SET deviceActivationStatus = 'N' where id = ".$vehicleId;
	$resultUpdate = mysql_query($sqlUpdate);
}
// End
// This code Executive when Vehicle Active
if(isset($_GET['vid']))
{
	$vid = $_GET['vid'];
	$sqlActive = "UPDATE tbl_gps_vehicle_master SET deviceActivationStatus = 'Y'  WHERE id = ".$vid;
	$resultActive = mysql_query($sqlActive); 
	$sqlDel = "DELETE FROM tblinactivevehicledata WHERE vehicleId = ".$vid;
	$resultDel = mysql_query($sqlDel);
	$_SESSION['sess_msg']='Vehicle Activated Successfully';
	
}
// End
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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/installed_vehicle_report.js"></script>
<script>
// Divison Show and Hide
function activeVehicle() {
    document.getElementById("activeVehicle").style.display = "";
	document.getElementById("inactiveVehicle").style.display = "none";
	
}

function inactiveVehicle() {
//alert("test");
   document.getElementById("activeVehicle").style.display = "none";
   document.getElementById("inactiveVehicle").style.display = "";
}
// End Divison Show and Hide

// send ajax 
$(document).ready(function(){
	$("#deviceStatusReport").click(function(){
		$.post("ajaxrequest/device_activation_status_details.php?token=<?php echo $token;?>",
				{
					company : $('#company').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
				});
	});
});
// End
// send ajax 
$(document).ready(function(){
	$("#searchByVehicleNo").click(function(){
		$.post("ajaxrequest/device_activation_status_by_vehicle_no.php?token=<?php echo $token;?>",
				{
					vehicleNo : $('#vehicleNo').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
				});
	});
});
// End

// Open Modal from ajax request page
function getModal(a)
{
	$.post("ajaxrequest/change_device_status.php?token=<?php echo $token;?>",
	{
		vehicleId : a
	},
	function( data){
		$(".modal-content").html(data);
	});	 
}
// End
// Show technician When Select Branch
$(document).ready(function(){
	$("#branchInactive").change(function(){
		$.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
				{
					branch : $("#branchInactive").val()
				},
					function(data){
						/*alert(data);*/
						$("#showExecutive").html(data);
				});
	});
});
// End
//Show In-Active Vehicle Data
$(document).ready(function(){
	$("#InactiveVehicle").click(function(){
		$.post("ajaxrequest/device_activation_inactive_status_details.php?token=<?php echo $token;?>",
				{
					companyInactive : $("#companyInactive").val(),
					branchInactive : $("#branchInactive").val(),
					serviceAreaMgr : $("#serviceAreaMgr").val(),
					executive : $("#executive").val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
				});
	});
});
//End
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
    	<h3>Device Status</h3>
        <hr>
    </div>
    <div class="col-md-12 select_form">
    	<div class="radio-inline">
              <label>
                <input type="radio" name="rdopt"  value="Active Vehicle"  checked="checked" id="single" onClick="activeVehicle()" /> 
                Active Vehicle </label>
    	</div>
        <div class="radio-inline">
        <label>
              <input type="radio" name="rdopt"  value="In-Active Vehicle"  id="multiple" onClick="inactiveVehicle()"/>
              In-Active Vehicle</label>
         </div>
    </div>
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
    <!-- Active Vehicle Section -->
    <div class="col-md-12 table-responsive" id="activeVehicle">
    	<div class="col-md-12">
            <h5 class="small-title">Active Vehicle</h5>
    	</div>
     <table class="form-field" width="100%">
     <tr>
     <td width="13%">Company Name</td>
     <td width="19%">
     <select name="company" id="company" class="form-control drop_down-sm">
       <option value="0">All</option>
       <?php $Country=mysql_query("SELECT B.id as id, B.Company_Name as Company_Name
			 							 FROM tbl_customer_master as A 
										 INNER JOIN tblcallingdata as B
										 ON A.callingdata_id =  B.id Order by Company_Name ASC");								
                   while($resultCountry=mysql_fetch_assoc($Country))
                    {
             ?>
       <option value="<?php echo $resultCountry['id']; ?>"> 
	   <?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?>       </option>
       <?php } ?>
     </select>     </td>
     <td width="13%"><input type="button" name="deviceStatusReport" value="Submit" id="deviceStatusReport" class="btn btn-primary btn-sm"/></td>
     <td width="18%">&nbsp;</td>
     <td width="13%">&nbsp;</td>
     <td width="20%">&nbsp;</td>
     <td width="2%">&nbsp;</td>
     <td width="2%"></td>
     </tr>
      <tr>
     <td>Vehicle No.</td>
     <td><input type="text" name="vehicleNo" id="vehicleNo" class="form-control text_box"></td>
     <td><input type="button" name="searchByVehicleNo" value="Submit" id="searchByVehicleNo" class="btn btn-primary btn-sm"/></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
     </table>
     </div>
     <!-- End Active Vehicle Section -->
     
     <!-- Inactive Vehicle Section -->
     <div class="col-md-12 table-responsive" id="inactiveVehicle" style="display:none">
     	<div class="col-md-12">
            <h5 class="small-title">In-Active Vehicle</h5>
    	</div>
     <table class="form-field" width="100%">
     <tr>
     <td width="13%">Company Name</td>
     <td width="19%">
     <select name="companyInactive" id="companyInactive" class="form-control drop_down-sm">
       <option value="0">All</option>
       <?php $Country=mysql_query("SELECT B.id as id, B.Company_Name as Company_Name
			 							 FROM tbl_customer_master as A 
										 INNER JOIN tblcallingdata as B
										 ON A.callingdata_id =  B.id Order by Company_Name ASC");								
                   while($resultCountry=mysql_fetch_assoc($Country))
                    {
             ?>
       <option value="<?php echo $resultCountry['id']; ?>"> 
	   <?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?>
       </option>
       <?php } ?>
     </select>
     </td>
     <td width="13%">Branch</td>
     <td width="18%"><select name="branchInactive" id="branchInactive" class="form-control drop_down-sm">
       
       <option value="0">All</option>
       <?php 
			  		$branch_sql= "select * from tblbranch ";
					
					$Country = mysql_query($branch_sql);								  
					while($resultCountry=mysql_fetch_assoc($Country)){
			  ?>
       <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
       <?php } ?>
     </select></td>
     <td width="13%">&nbsp;</td>
     <td width="20%">&nbsp;</td>
     <td width="2%">&nbsp;</td>
     <td width="2%"></td>
     </tr>
      <tr>
     <td>Service Area Mgr.</td>
     <td>
     	<select name="serviceAreaMgr" id="serviceAreaMgr"  class="form-control drop_down-sm">
                 
                 <option value="0">All</option>
                 <?php $Country=mysql_query("select * from tbluser where User_Category='9'");
					   while($resultCountry=mysql_fetch_assoc($Country)){
				 ?>
                 <option value="<?php echo $resultCountry['id']; ?>" 
				 <?php if(isset($result['service_area_manager']) && $resultCountry['id']==$result['service_area_manager']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?>
                 </option>
                 <?php } ?>
          </select>
     </td>
     <td>Service Executive</td>
     <td><div id="showExecutive">
       <select name="executive" id="executive" class="form-control drop_down drop_down-sm">
         <option value="0" selected>All</option>
       </select>
     </div></td>
     <td><input type="button" name="InactiveVehicle" value="Submit" id="InactiveVehicle" class="btn btn-primary btn-sm"/></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Vehicle No.</td>
        <td><input type="text" name="vehicleNoInactive" id="vehicleNoInactive" class="form-control text_box"></td>
        <td><input type="button" name="inactiveVehicle" value="Submit" id="inactiveVehicle" class="btn btn-primary btn-sm" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     </table>
    </div>
     <!-- End Intactive Vehicle Section -->
	
      <div class="col-md-12" style="margin-top:10px;">
      	<?php if($_SESSION['sess_msg']!=''){?>
	 		<center>
            <div style="color:#009900; padding:0px 0px 10px 0px; font-weight:bold;">
				<?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?>
            </div>
            </center>
   		<?php } ?>
      </div> 
      
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
      	<!-- Show Active Vehicle this Section -->		
      </div>
     
    </form>
    <!----- Show Modal Form -------->
   	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  		<div class="modal-dialog modal-sm">
    		<div class="modal-content">
      
        	</div>
      	</div>
    </div>
    <!----- End Modal ------------>
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