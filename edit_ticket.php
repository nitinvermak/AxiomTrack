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
$Ticket_id = $_GET['id'];
if (isset($_POST['submit'])) 
{
	  $orgranization = mysql_real_escape_string($_POST['orgranization']);
	  $product = mysql_real_escape_string($_POST['product']);
	  $request = mysql_real_escape_string($_POST['request']);
	  $model = mysql_real_escape_string($_POST['model']);
	  $no_of_installation = mysql_real_escape_string($_POST['no_of_installation']);
	  $des = mysql_real_escape_string($_POST['des']);
	  $date_time = mysql_real_escape_string($_POST['date_time']);
	  $update_record = "UPDATE tblticket SET  organization_id = '$orgranization', 
						product = '$product', rqst_type = '$request', 
						device_model_id = '$model', no_of_installation = '$no_of_installation', 
						description = '$des', appointment_date = '$date_time' 
						WHERE ticket_id = '$Ticket_id'";
	  // Call User Activity Log function
	  UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $update_record);
	  // End Activity Log Function
	  $query = mysql_query($update_record);
	  $_SESSION['sess_msg']='Ticket updated successfully';
	  header("location:view_ticket.php?token=".$token);
}


$Select_row = "Select * from tblticket where ticket_id='$Ticket_id'";
$result =mysql_query($Select_row);
$rows = mysql_fetch_array($result);
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
<script type="text/javascript" src="js/create_ticket.js"></script>
<!--Ajax request Call-->
<script  src="js/ajax.js"></script>
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
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
    	<h1>Update Ticket</h1>
        <hr>
    </div>
    <div class="col-md-12">  
    <div class="col-md-12" id="contactform"> <!--open of the single form-->
    <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        
         <div class="clearfix">&nbsp;</div>
        <div class="col-md-12">
        
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Organization*</label>
                <div class="col-sm-10" id="divOrgranization">
               	<select name="orgranization" id="orgranization" class="form-control drop_down">
                <option value="">Select Orgranization</option>                         
                    <?php $Country=mysql_query("select * from tblcallingdata");						  
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($rows['organization_id']) && $resultCountry['id']==$rows['organization_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Product*</label>
                <div class="col-sm-10">
                <select name="product" onChange="getState(this.value)" class="form-control drop_down">
                <option value="">Select Products</option>                         
                    <?php $Country=mysql_query("select * from tblcallingcategory");						  
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($rows['product']) && $resultCountry['id']==$rows['product']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['category'])); ?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Request&nbsp;Type*</label>
                <div class="col-sm-10" id="statediv">
                 <select name="request"  onchange="return divshow(this.value)" class="form-control drop_down">
                 	<option value="">Request Type</option>                         
                    <?php $Country=mysql_query("select * from tblrqsttype");						  
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($rows['rqst_type']) && $resultCountry['id']==$rows['rqst_type']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['rqsttype'])); ?></option>
                	<?php } ?>                             
                 </select>
                </div>
            </div>
            <div id="service_provider">
             <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Model*</label>
                <div class="col-sm-10">
                  	<select name="model" id="model" class="form-control drop_down">
                   		<option value="">Request Type</option>                         
						<?php $Country=mysql_query("select * from tbldevicemodel");						  
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($rows['device_model_id']) && $resultCountry['device_id']==$rows['device_model_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">No&nbsp;of&nbsp;Installation*</label>
                <div class="col-sm-10">
                  <input type="text" name="no_of_installation" id="no_of_installation"  value="<?php if(isset($rows['ticket_id'])) echo $rows['no_of_installation']; ?>" class="form-control text_box"/>
                </div>
            </div>
            </div>
        	
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Description*</label>
                <div class="col-sm-10">
                  <textarea name="des" id="des" class="form-control txt_area"><?php if(isset($rows['ticket_id'])) echo $rows['description']; ?></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Appointment&nbsp;DateTime*</label>
                <div class="col-sm-10">
                  <input name="date_time" id="date_time" class="form-control text_box" value="<?php if(isset($rows['ticket_id'])) echo $rows['appointment_date']; ?>" type="text"  />
                </div>
            </div>
             <div class="clearfix"></div>
             <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="margin:10px 0px 10px 170px;">
                
                  <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary" onClick="window.location='view_ticket.php?token=<?php echo $token ?>'" />
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
</script>
</html>