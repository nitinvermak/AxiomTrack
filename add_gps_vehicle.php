<?php

include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
include("includes/simpleimage.php");
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) 
	{
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
if(isset($_REQUEST['organization']))
	{
	$organization = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['organization'])));
	$customer_branch = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['customer_branch'])));
	$vehicle_no = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['vehicle_no'])));
	$vehicle_odo_meter = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['vehicle_odo_meter'])));
	$technician = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['technician'])));
	$mobile_no = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['mobile_no'])));
	$device = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['device'])));
	$imei = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['imei'])));
	$model = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['model'])));
	$server_details = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['server_details'])));
	$insatallation_date = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['insatallation_date'])));
	$ticketId = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['ticketId'])));
	}

	if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes')
	{
		if(isset($_REQUEST['cid']) && $_REQUEST['cid']!='')
		{
		$sql="update tbl_gps_vehicle_master set customer_Id='$organization', customer_branch='$customer_branch', vehicle_no='$vehicle_no', vehicle_odometer='$vehicle_odo_meter', techinician_name='$technician', mobile_no='$mobile_no', device_id='$device', imei_no='$imei', model_name='$model', server_details='$server_details', installation_date='$insatallation_date', ticketId = '$ticketId'  where id=" .$_REQUEST['id'];
		mysql_query($sql);
		echo $sql;
		$_SESSION['sess_msg']='Vehicle updated successfully';
		header("location:manage_vehicle.php?token=".$token);
		exit();
		}
	else 
		{
		$query = "insert into tbl_gps_vehicle_master set customer_Id='$organization', customer_branch='$customer_branch', vehicle_no='$vehicle_no', vehicle_odometer='$vehicle_odo_meter', techinician_name='$technician', mobile_no='$mobile_no', device_id='$device', imei_no='$imei', model_name='$model', server_details='$server_details', installation_date='$insatallation_date', paymentActiveFlag='N', ticketId = '$ticketId'";
		$sql = mysql_query($query);
		/*echo $query; */		
		$update_sim = "update tblsim set status_id='1' where id='$mobile_no'";
		/*echo $update_sim;*/
		$querysim = mysql_query($update_sim);		
		$update_Device = "update tbl_device_master set status = '1' where id='$device'";
		/*echo $update_Device;*/
		$queryex = mysql_query($update_Device);
		$_SESSION['sess_msg']='Vehicle added successfully';
		header("location:manage_vehicle.php?token=".$token);
		exit();
		}

}
if(isset($_REQUEST['id']) && $_REQUEST['id'])
	{
	$queryArr=mysql_query("SELECT * FROM tbl_gps_vehicle_master WHERE id =".$_REQUEST['id']);
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
<link rel="stylesheet" href="css/custom.css">
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/add_gps_vehicle.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<!--Ajax request Call-->
<script  src="js/ajax.js"></script>
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
<script type="text/javascript">
$(document).ready(function(){
    $("select.ticket").change(function(){
      $.post("ajaxrequest/show_ticket_organization.php?token=<?php echo $token;?>",
				{
					ticket : $(".ticket option:selected").val()
				},
					function( data ){
						$("#divOrgranization").html(data);
				});
		
    });
});
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
    	<h1>Add New Vehicle</h1>
        <hr>
    </div>
    <div class="col-md-12">  
    <div class="col-md-12" id="contactform"> <!--open of the single form-->
    <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="radio-inline">
        	<label><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?></label>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="col-md-12">
         	<div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Ticket Id*</label>
                <div class="col-sm-10">
                	<select name="ticketId" id="ticketId" class="form-control drop_down ticket">
                    	 <option value="">Select Ticket Id</option>
						 <?php $Country=mysql_query("select ticket_id from tblticket where organization_type='Existing Client'  and ticket_status <> 1 order by ticket_id ASC");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                                 ?>
                        <option value="<?php echo $resultCountry['ticket_id']; ?>" <?php if(isset($result['ticket_id']) && $resultCountry['ticket_id']==$result['ticket_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['ticket_id'])); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div id="divOrgranization" >
            <!--<div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Organization*</label>
                <div class="col-sm-10" id="divOrgranization">
           		  <select name="organization" id="organization" class="form-control drop_down">
                  	<option value="">Select Organization</option>
                  </select>
                </div>
            </div>-->
            </div>
           
            
            <div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Vehicle No*</label>
                <div class="col-sm-10">
                <input name="vehicle_no" id="vehicle_no" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['vehicle_no']; ?>"/>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Techician&nbsp;Name*</label>
                <div class="col-sm-10" id="statediv">
                 <select name="technician" id="technician" onChange="return ShowMobile();" class="form-control drop_down">
                 <option value="">Select Techician</option>
                 <?php $Country=mysql_query("select * from tbluser where User_Category=5 or User_Category=8");
					   while($resultCountry=mysql_fetch_assoc($Country)){
				 ?>
                 <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['techinician_name']) && $resultCountry['id']==$result['techinician_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ".$resultCountry['Last_Name'])); ?></option>
                 <?php } ?>
                 </select>
                </div>
            </div>
            <div id="service_provider" style="display:none">
             <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Model*</label>
                <div class="col-sm-10">
                  	<select name="model" id="model" class="form-control drop_down">
                    <option value="">Select Model</option>
                    <?php $Country=mysql_query("select * from tbldevicemodel");			  
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($datasource) && $resultCountry['device_id']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">No&nbsp;of&nbsp;Installation*</label>
                <div class="col-sm-10">
                  <input type="text" name="no_of_installation" id="no_of_installation"  class="form-control text_box"/>
                </div>
            </div>
            </div>
        	
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Mobile*</label>
              <div class="col-sm-10" id="divMobile">
                <select name="mobile_no" id="mobile_no" class="form-control drop_down">
                    <option value="">Select Mobile</option>
                    <option value="<?php echo $result['mobile_no']; ?>" <?php if(isset($result['id']) && $result['mobile_no']==$result['mobile_no']){ ?>selected<?php } ?>><?php echo getMobile(stripslashes(ucfirst($result['mobile_no']))); ?></option>
                </select> 
              </div>
            </div>
            
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Device&nbsp;Id *</label>
              <div class="col-sm-10" id="divDevice">
                   <select name="device" id="device" class="form-control drop_down" onChange="return ShowIMEIandDeviceName();">
                   <option value="">Select Device</option>
                    <option value="<?php echo $result['device_id']; ?>" <?php if(isset($result['id']) && $result['device_id']==$result['device_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['device_id'])); ?></option>
                   </select>
              </div>
            </div>
            
             <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">IMEI No. *</label>
                <div class="col-sm-10" id="divIMEI">
                   <select name="imei" id="imei" class="form-control drop_down">
                   <option value="">Select IMEI</option>
                   <option value="<?php echo $result['imei_no']; ?>" <?php if(isset($result['id']) && $result['imei_no']==$result['imei_no']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['imei_no'])); ?></option>
                   </select>
                </div>
            </div>
            
             <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Model&nbsp;Name*</label>
                <div class="col-sm-10" id="getModel">
                   <select name="model" id="model" class="form-control drop_down">
                   <option value="">Select Model</option>
                   <option value="<?php echo $result['model_name']; ?>" <?php if(isset($result['id']) && $result['model_name']==$result['model_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['model_name'])); ?></option>
                   </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Server&nbsp;Details*</label>
                <div class="col-sm-10">
                  <select name="server_details" id="server_details" class="form-control drop_down" onChange="return divshow(this.value)">
                  <option value="">Select Server</option>
                  <option value="vehicletrack.biz">vehicletrack.biz</option>
                  <option value="vts24.com">vts24.com</option>
                  <option value="<?php echo $result['server_details']; ?>" <?php if(isset($result['id']) && $result['server_details']==$result['server_details']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['server_details'])); ?></option>
                  </select>
                </div>
            </div>
            
             <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Installation&nbsp;Date*</label>
                <div class="col-sm-10">
                  <input name="insatallation_date" id="insatallation_date" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['installation_date']; ?>"/>
                </div>
            </div>
             <div class="clearfix"></div>
             <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="margin:10px 0px 10px 170px;">
                <input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
                              <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
                              <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back" 
							  onclick="window.location='manage_vehicle.php?token=<?php echo $token ?>'"/>
                </div>  
                 
  			</div> 
          </div>
             </form>
        </div>
        
        
       
    </div> 
    <!--end single sim  form--> 
    
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
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.datetimepicker.js"></script>
<script>
$('#insatallation_date').datetimepicker({
	/*mask:'9999/19/39 29:59'*/
});
</script>
</html>