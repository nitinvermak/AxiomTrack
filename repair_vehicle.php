<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php");

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
$error =0;
if(isset($_REQUEST['organization']))
	{
		$technician = mysql_real_escape_string($_POST['technician']);
		$ticketId = mysql_real_escape_string($_POST['ticketId']);
		$organization = mysql_real_escape_string($_POST['organization']);
		$vehicleNo = mysql_real_escape_string($_POST['vehicleNo']);
		$oldmobileNo = mysql_real_escape_string($_POST['oldmobileNo']);
		$olddeviceId = mysql_real_escape_string($_POST['olddeviceId']);
		$repairType = mysql_real_escape_string($_POST['repairType']);
		$mobileNo = mysql_real_escape_string($_POST['mobileNo']);
		$deviceId = mysql_real_escape_string($_POST['deviceId']);
    $oldModal = mysql_real_escape_string($_POST['oldModal']);
    $newModal = mysql_real_escape_string($_POST['newModal']);
	}

	if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes')
	{
		if(isset($_REQUEST['cid']) && $_REQUEST['cid']!='')
		{
			$sql = "update tempvehicledatarepair set customerId='$organization', 
					    techinicianId	='$technician', oldMobileId='$oldmobileNo', 
					    oldDeviceId='$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
					    repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo' 
					    where id=" .$_REQUEST['id'];
			
			mysql_query($sql);
			echo $sql;
			$_SESSION['sess_msg']='Vehicle updated successfully';
			/*sendConfigSms($model, $mobile_no, '');*/
			/*header("location:manage_vehicle.php?token=".$token);
			exit();*/
		}
	else 
		{
        if($mobileNo != NULL && $deviceId == NULL){
          $returnCode = 1;
        }
        elseif ($mobileNo == NULL && $deviceId != NULL) {
          $returnCode = 2;
        }
        elseif ($mobileNo != NULL && $deviceId != NULL) {
          $returnCode = 3;
        }
        else{
          $returnCode = 4;
        }
          
        switch($returnCode) {
            // if change mobile Number
            case 1:
            $query = "insert into tempvehicledatarepair set customerId='$organization', 
                      techinicianId ='$technician', oldMobileId='$oldmobileNo', 
                      oldDeviceId='$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
                      repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo'";
            /*echo $query;*/
            $sql = mysql_query($query);
            $_SESSION['sess_msg']='Vehicle added successfully';
            sendConfigSms($oldModal, $mobileNo, '');
            header("location:daily_installation.php?token=".$token);
            break;

            // if change device
            case 2:
              $query = "insert into tempvehicledatarepair set customerId='$organization', 
                        techinicianId ='$technician', oldMobileId='$oldmobileNo', 
                        oldDeviceId='$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
                        repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo'";
              /*echo $query;*/
              $sql = mysql_query($query);
              $_SESSION['sess_msg']='Vehicle added successfully';
              sendConfigSms($newModal, $oldmobileNo, '');
              header("location:daily_installation.php?token=".$token);
              break;
             
            // if change mobile number and device
            case 3:
              $query = "insert into tempvehicledatarepair set customerId='$organization', 
                        techinicianId ='$technician', oldMobileId='$oldmobileNo', 
                        oldDeviceId='$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
                        repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo'";
              /*echo $query;*/
              $sql = mysql_query($query);
              $_SESSION['sess_msg']='Vehicle added successfully';
              sendConfigSms($newModal, $mobileNo, '');
              header("location:daily_installation.php?token=".$token);
              break;

            // if old mobile number
            case 4:
              $query = "insert into tempvehicledatarepair set customerId='$organization', 
                        techinicianId ='$technician', oldMobileId='$oldmobileNo', 
                        oldDeviceId='$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
                        repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo'";
              /*echo $query;*/
              $sql = mysql_query($query);
              /*echo "<script> alert('Vehicle added successfully'); </script>";*/
              $_SESSION['sess_msg']='Vehicle add successfully';
              sendConfigSms($oldModal, $oldmobileNo, '');
              header("location:daily_installation.php?token=".$token);
              break;
        }
      
		}

}
if(isset($_REQUEST['id']) && $_REQUEST['id'])
	{
		$queryArr=mysql_query("SELECT * FROM tempvehicledatarepair WHERE id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/repair_vehicle.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<!--Ajax request Call-->
<script  src="js/ajax.js"></script>
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
<script type="text/javascript">
$(document).ready(function(){
    $("#technician").change(function(){
      $.post("ajaxrequest/show_ticket_id.php?token=<?php echo $token;?>",
				{
					technician : $("#technician").val()
				},
					function( data ){
						$("#divTicketId").html(data);
				});
		
    });
});

function getOrg()
{
      $.post("ajaxrequest/show_repair_vehicle_details.php?token=<?php echo $token;?>",
				{
					ticket : $("#ticketId").val()
				},
					function( data ){
						$("#divOrgranization").html(data);
				});
		
}
// send ajax request when select vehicle no
function getValue()
{
	 $.post("ajaxrequest/show_old_mobile_device_id.php?token=<?php echo $token;?>",
				{
					vehicleNo : $("#vehicleNo").val()
				},
					function( data ){
						$("#divOldmobile").html(data);
				});
}
//end
// Select Old Modal
function getOldDeviceModal()
{
  $.post("ajaxrequest/device_old_modal_details.php?token=<?php echo $token;?>",
        {
          olddeviceId : $("#olddeviceId").val()
        },
          function( data ){
            $("#oldModal").html(data);
        });
}
// End
// send ajax request when select repair type
$(document).ready(function(){
    $("#repairType").change(function(){
      $.post("ajaxrequest/show_repair_type.php?token=<?php echo $token;?>",
				{
					technician : $("#technician option:selected").val(),
					repairType : $("#repairType").val()
				},
					function( data ){
						$("#divShowRepair").html(data);
				});
		
    });
});
//End
// send ajax request when select device id
function getNewModal()
{
  $.post("ajaxrequest/device_modal_details.php?token=<?php echo $token;?>",
        {
          deviceId : $("#deviceId").val()
        },
          function( data ){
            $("#newModal").html(data);
        });
}
// End
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
    	<h1>Repair Vehicle</h1>
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
                <label for="Mobile" class="col-sm-2 control-label">Techician&nbsp;Name <span class="red">*</span></label>
                <div class="col-sm-10" id="statediv">
                 <select name="technician" id="technician" class="form-control drop_down">
                 <option value="">Select Techician</option>
                 <?php 
				 	$userId = $_SESSION['user_id'];
					if($userId == 1 || 12)
					{
				 		$technician = mysql_query("select * from tbluser where (User_Category=5 or User_Category=8) 
													Order By First_Name");	
					}
					else
					{
						$technician = mysql_query("select * from tbluser where (User_Category=5 or User_Category=8) 
													Where id ='$userId' ");
					}
                    while($resulttechnician=mysql_fetch_assoc($technician)){
				 ?>
                 <option value="<?php echo $resulttechnician['id']; ?>">
				 <?php echo $resulttechnician['First_Name']." ".$resulttechnician['Last_Name'];?>
                 </option>
                 <?php } ?>
                 </select>
                </div>
            </div>
         	<div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Ticket Id <span class="red">*</span></label>
                <div class="col-sm-10" id="divTicketId">
                	<select name="ticketId" id="ticketId" class="form-control drop_down ticket">
                    	 <option value="">Select Ticket Id</option>
						 
                    </select>
                </div>
            </div>
            <div id="divOrgranization" >
                <div class="form-group">
                    <label for="provider" class="col-sm-2 control-label">Organization*</label>
                    <div class="col-sm-10" id="divOrgranization">
                      <select name="organization" id="organization" class="form-control drop_down">
                        <option value="">Select Organization</option>
                      </select>
                    </div>
                </div>
              	 <div class="form-group">
                    <label for="vehicleNo" class="col-sm-2 control-label">Vehicle No.</label>
                    <div class="col-sm-10" id="divOrgranization">
                      <select name="vehicleNo" id="vehicleNo" class="form-control drop_down">
                        <option value="">Select Vehicle No.</option>
                      </select>
                    </div>
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
        	<div id="divOldmobile">
                <div class="form-group">
                    <label for="dateofpurchase" class="col-sm-2 control-label">Old Mobile <span class="red">*</span></label>
                  <div class="col-sm-10" id="divMobile">
                    <select name="oldmobileNo" id="oldmobileNo" class="form-control drop_down">
                        <option value="">Select Mobile</option>
                    </select> 
                  </div>
                </div>
                
                <div class="form-group">
                    <label for="dateofpurchase" class="col-sm-2 control-label">Old Device&nbsp;Id <span class="red">*</span></label>
                  <div class="col-sm-10" id="divDevice">
                       <select name="olddeviceId" id="olddeviceId" class="form-control drop_down">
                       <option value="">Select Device</option>
                       </select>
                  </div>
                </div>  
                             
              </div>
              <div id="oldModal">
                    <!-- Show Old Device Modal from ajax page --> 
              </div> 
              <div class="form-group">
                    <label for="repairType" class="col-sm-2 control-label">Repair&nbsp;Type <span class="red">*</span></label>
                  <div class="col-sm-10">
                       <select name="repairType" id="repairType" class="form-control drop_down">
                       		<option value="">Select Repair Type</option>
                       		<option value="1">Sim</option>
                            <option value="2">Device</option>
                            <option value="3">Both</option>
                       </select>
                  </div>
                </div>
            <div id="divShowRepair">
            	
            </div>
            <div id="newModal"> 
            <!-- Show Device modal from ajax page -->
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