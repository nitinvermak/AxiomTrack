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

$ticket_id = $_GET['ticket_id'];
/*echo "ticket id".$ticket_id;*/
$queryArr=mysql_query("select * from tblticket where ticket_id = '$ticket_id'");
$result=mysql_fetch_assoc($queryArr);
if(isset($_POST['submit']))
	{
		$ticket_status = mysql_real_escape_string($_POST['status']);
		$remark = mysql_real_escape_string($_POST['des']);
		$apDate = mysql_real_escape_string($_POST['apDate']);
		$Update_ticket = "UPDATE tblticket SET ticket_status ='$ticket_status', ticket_remark = '$remark', scheduleDate = '$apDate' where ticket_id =".$ticket_id;
		$query = mysql_query($Update_ticket);
		/*echo $Update_ticket;*/
		echo "<script> alert('Ticket Reshedule');</script>";
		header("location: update_ticket_status.php?token=".$token);
	}

if(isset($_POST['close']))
	{
		$ticket_status = mysql_real_escape_string($_POST['status']);
		$remark = mysql_real_escape_string($_POST['des']);
		$close_date = mysql_real_escape_string($_POST['close_date']);
		
		$Update_ticket = "UPDATE tblticket SET ticket_status ='$ticket_status', ticket_remark = '$remark', close_date = '$close_date' where ticket_id =".$ticket_id;
		$query = mysql_query($Update_ticket);
		/*echo $Update_ticket;*/
		echo "<script> alert('Ticket Closed');</script>";
		header("location: update_ticket_status.php?token=".$token);
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
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/close_ticket.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
 $(function() {
    $( "#search_date" ).datepicker({dateFormat: 'yy-mm-dd'});
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
    	<h1>Close  Ticket</h1>
        <hr>
    </div>
    <div class="col-md-12">  
    <div class="col-md-12" id="contactform"> <!--open of the single form-->
    <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['ticket_id']) and $_GET['ticket_id']>0){ echo $_GET['ticket_id']; }?>"/>
        <div class="col-md-12">
        
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Organization*</label>
                <div class="col-sm-10" id="divOrgranization">
                   <input type="text" name="organization" id="organization" value="<?php if(isset($result['ticket_id'])) echo getOraganization($result['organization_id']);?>" class="form-control text_box" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Product*</label>
                <div class="col-sm-10">
                <input type="text" name="products" id="products" value="<?php if(isset($result['ticket_id'])) echo getproducts(stripslashes($result["product"]));?>" class="form-control text_box" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Request&nbsp;Type*</label>
                <div class="col-sm-10" id="statediv">
                  <input type="text" name="products" id="products" value="<?php if(isset($result['ticket_id'])) echo 			getRequesttype(stripslashes($result["rqst_type"]));?>" class="form-control text_box" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Status*</label>
                <div class="col-sm-10" id="statediv">
                  <select name="status" id="status" class="form-control drop_down" onChange="ShowHideDiv()">
                  <option value="">Select Status</option>
                  <option value="1">Close</option>
                  <option value="2">Reschedule</option>
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
                <label for="dateofpurchase" class="col-sm-2 control-label">Remarks/Reason <br>(If Any)*</label>
                <div class="col-sm-10">
                  <textarea name="des" id="des" class="form-control txt_area"><?php if(isset($result['ticket_id'])) echo $result['description'];?></textarea>
                </div>
            </div>
            
            <div class="form-group" id="divclose" style="display: none">
               <label for="date_time" class="col-sm-2 control-label">Close&nbsp;Date*</label>
                <div class="col-sm-10" >
                  <input name="date_time" id="date_time"  value="<?php if(isset($result['ticket_id'])) echo 			stripslashes($result["close_date"]);?>" class="form-control text_box"  type="text" />
				</div>
            </div>
            
            <div class="form-group" id="divpp" style="display: none">
              <label for="date_time" class="col-sm-2 control-label">Schedule&nbsp;Date*</label>
                <div class="col-sm-10">
                  <input name="apDate" id="apDate" class="form-control text_box" value="<?php if(isset($result['ticket_id'])) echo 			stripslashes($result["scheduleDate"]);?>" type="text"/>
        		</div>
            </div>
            
             <div class="clearfix"></div>
             <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="margin:0px 0px 10px 158px;">
                  <input type="submit" value="Resudule" name="submit" id="submit" class="btn btn-primary" />
                  <input type="submit" value="Close Ticket" name="close" id="close" class="btn btn-primary" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary" onClick="window.location='update_ticket_status.php?token=<?php echo $token ?>'" />
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
	/*mask:'9999/19/39 29:59'*/
});
$('#apDate').datetimepicker({
	/*mask:'9999/19/39 29:59'*/
});
</script>
</html>