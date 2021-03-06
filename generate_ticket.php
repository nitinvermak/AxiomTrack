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

$error =0;

if(isset($_REQUEST['product']))
{
	$product=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['product'])));
	$orgranization=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['orgranization'])));
	$orgranizationType=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['g'])));
	$request=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['request'])));
	$model_id=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['model'])));
	$no_of_installation=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['no_of_installation'])));
	$description=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['des'])));
	$ap_date_time=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['date_time'])));
	$time=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['time'])));
	$vehicle = htmlspecialchars(mysql_real_escape_string(trim($_POST['vehicle'])));
	$reason = htmlspecialchars(mysql_real_escape_string(trim($_POST['reason'])));
	$create_date=htmlspecialchars(mysql_real_escape_string($_POST['create_date']));
	$userId = $_SESSION['user_id'];
  $branchId = $_SESSION['branch'];
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
	
	if(isset($_REQUEST['cid']) && $_REQUEST['cid']!='')
	{
		$sql = "update tblticket set product = '$product', organization_id = '$orgranization', 
			      rqst_type='$request', device_model_id='$model_id', no_of_installation='$no_of_installation', 
    				description='$description', vehicleId = '$vehicle', repairReason ='$reason', 
    				appointment_date='$ap_date_time'), appointment_time='$time', 
    				ModifyDate = Now(), ModifyBy = '$userId' 
    				where id=" .$_REQUEST['id'];
        		echo $sql;
        		// Call User Activity Log function
        		UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
        		// End Activity Log Function
        		mysql_query($sql);
        		$_SESSION['sess_msg']='Ticket updated successfully';
        		header("location:view_ticket.php?token=".$token);
    }
	else
	{
    // store data tblticket table
		$query = "insert into tblticket set product='$product', organization_id='$orgranization', 						             	  organization_type='$orgranizationType', rqst_type='$request', device_model_id='$model_id', 
    				  no_of_installation='$no_of_installation', description='$description', 
    				  vehicleId = '$vehicle', repairReason ='$reason', branch_assign_status ='1',
    				  appointment_date='$ap_date_time', createddate=Now(), CreateBy = '$userId'";
          		// Call User Activity Log function
          		UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $query);
          		// End Activity Log Function
          		mysql_query($query);
          		$ticket = mysql_insert_id();

    // store data tbl_ticket_assign_branch
    $queryBranch = "insert into tbl_ticket_assign_branch SET ticket_id = '$ticket', branch_id = '$branchId', 
                    assign_by = '$userId', branch_confirmation_status = '1', assign_date = Now()";
              
              $resultBranch = mysql_query($queryBranch);
          		$_SESSION['sess_msg']='Generated Ticket Id: '.'<span style=font-weight:bold;>'.$ticket.'</span>'. ' Successfully';
          		header("location:view_ticket.php?token=".$token);
          		exit();
	}

}
if(isset($_REQUEST['id']) && $_REQUEST['id'])
{
	$queryArr=mysql_query("select * from tblticket where id =".$_REQUEST['id']);
	$result=mysql_fetch_assoc($queryArr);
}
	$query="SELECT * FROM tblcallingcategory";
	$result=mysql_query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/create_ticket.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!--Ajax request Call-->
<script  src="js/ajax.js"></script>
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->

<script type="text/javascript" language="javascript">
// send ajax request for new client
$(document).ready(function(){
	$("#newclient").click(function(){
		$.post("ajaxrequest/ticket_new_customer.php?token=<?php echo $token;?>",
			{
				newClient : $('#newclient').val()
			},
				function( data ){
					$("#divOrgranization").html(data);
			});		 
	});
});
// end
// send ajax request for existing client
$(document).ready(function(){
	$("#existing").click(function(){
		$.post("ajaxrequest/ticket_existing_customer.php?token=<?php echo $token;?>",
			{
				existingClient : $('#existing').val()
			},
				function( data ){
					$("#divOrgranization").html(data);
			});		 
	});
});
//end
//send ajax request for product
$(document).ready(function(){
	$("#product").change(function(){
		$.post("ajaxrequest/findrquest.php?token=<?php echo $token;?>",
			{
				productValue : $('#product').val()
			},
				function( data ){
					$("#statediv").html(data);
			});		 
	});
});
//end
//send ajax request when select organization
function getVehicle()
{
	$.post("ajaxrequest/show_vehicle_no.php?token=<?php echo $token;?>",
			{
				orgranization : $('#orgranization').val()
			},
				function( data ){
					$("#showVehicle").html(data);
			});	
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
    	<h1>New Ticket</h1>
        <hr>
    </div>
    <div class="col-md-12">  
    <div class="col-md-12" id="contactform"> <!--open of the single form-->
    <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="radio-inline">
              <label>
                <input type="radio" name="g"  value="New Client"  id="newclient" /> New Client
              </label>
		</div>
         <div class="radio-inline">
        <label>
                <input type="radio" name="g"  value="Existing Client"  id="existing"/>
                Existing Client
              </label>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="col-md-12">
        
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Organization*</label>
                <div class="col-sm-10" id="divOrgranization">
               	<select name="orgranization" id="orgranization" class="form-control drop_down orgranization">
                <option value="">Select Orgranization</option>
                </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Product*</label>
                <div class="col-sm-10">
                <select name="product" id="product" class="form-control drop_down">
                <option value="">Select Product</option>
                <?php while ($row=mysql_fetch_array($result)) { ?>
                <option value=<?php echo $row['id']?>
                <?php if(isset( $_SESSION['product']) && $row['id']== $_SESSION['product'])
                 { ?>selected<?php } ?>>
                <?php echo $row['category']?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Request&nbsp;Type*</label>
                <div class="col-sm-10" id="statediv">
                 <select name="request" id="request"  onchange="return divshow(this.value)" class="form-control drop_down">
                 <option>Select Request Type</option>                              
                 </select>
                </div>
            </div>
            
            <div id="repair" style="display:none;">
                <div class="form-group">
                    <label for="Mobile" class="col-sm-2 control-label">Vehicle&nbsp;No.*</label>
                    <div class="col-sm-10" id="showVehicle">
                     <select name="vehicle" id="vehicle" class="form-control drop_down">
                     <option>Select Vehicle</option>                              
                     </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Reason" class="col-sm-2 control-label">Reason*</label>
                    <div class="col-sm-10" id="statediv">
                     <select name="reason" id="reason"  class="form-control drop_down">
                     <option>Select Reason</option>   
                     <option value="Battery Disconnected">Battery Disconnected</option>
                     <option value="No Reply">No Reply</option>
                     <option value="Re-Installation">Re-Installation</option>
                     <option value="Others">Others</option>
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
        	
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Description*</label>
                <div class="col-sm-10">
                  <textarea name="des" id="des" class="form-control txt_area"><?php if(isset($result['id'])) echo $result['description'];?></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Appointment&nbsp;DateTime*</label>
                <div class="col-sm-10">
                  <input name="date_time" id="date_time" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['date_time'];?>" type="text"  />
                </div>
            </div>
            
          <!--  <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Appointment&nbsp;Time*</label>
                <div class="col-sm-10">
                 <input name="time" id="time" class="form-control text_box" value="<?php if(isset($result['appointment_time'])) echo $result['appointment_time'];?>" type="text" />
                </div>
            </div>-->
             <div class="clearfix"></div>
             <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="margin:10px 0px 10px 170px;">
                
                  <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary btn-sm" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='view_ticket.php?token=<?php echo $token ?>'" />
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
<!-------Javascript------->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
<script src="js/jquery.js"></script>
<script src="js/jquery.datetimepicker.js"></script>
<script>
$('#date_time').datetimepicker({
	mask:'9999/19/39 29:59'
});
</script>
</html>