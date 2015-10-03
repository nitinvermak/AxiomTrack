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
	$create_date=htmlspecialchars(mysql_real_escape_string($_POST['create_date']));
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
	
	if(isset($_REQUEST['cid']) && $_REQUEST['cid']!='')
	{
	$sql="update tblticket set 	product='$product', organization_id	='$orgranization', rqst_type='$request', device_model_id='$model_id', 		
	no_of_installation='$no_of_installation', description='$description', appointment_date='$ap_date_time'), appointment_time='$time', createddate=Now() where id=" .$_REQUEST['id'];
	mysql_query($sql);
	$_SESSION['sess_msg']='Ticket updated successfully';
	header("location:view_ticket.php?token=".$token);
    }
	else{
 	$query = "insert into tblticket set product='$product', organization_id='$orgranization', organization_type='$orgranizationType', rqst_type='$request', device_model_id='$model_id', no_of_installation='$no_of_installation', description='$description', appointment_date='$ap_date_time', createddate=Now()";
	$_SESSION['sess_msg']='Ticket Generate successfully';
	mysql_query($query);
	header("location:view_ticket.php?token=".$token);
	exit();
	}

}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
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

<script type="text/javascript" language="javascript">
function NewCustomer()
	{   
	    newclient = document.getElementById("newclient").value
		/*alert(newclient);*/
		url="ajaxrequest/ticket_new_customer.php?newclient="+newclient+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,newclient,"getOrganization");
	}
	function ExistingCustomer()
	{
		existing = document.getElementById("existing").value;
		/*alert(existing);*/
		url="ajaxrequest/ticket_existing_customer.php?existing="+existing+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,existing,"getOrganization");
	}
	function getOrganization(str){
	document.getElementById('divOrgranization').innerHTML=str;
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
                <input type="radio" name="g"  value="New Client"  id="newclient"  onClick="NewCustomer()" /> New Client
              </label>
		</div>
         <div class="radio-inline">
        <label>
                <input type="radio" name="g"  value="Existing Client"  id="existing"  onClick="ExistingCustomer()"/>
                Existing Client
              </label>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="col-md-12">
        
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Organization*</label>
                <div class="col-sm-10" id="divOrgranization">
               	<select name="orgranization" id="orgranization" class="form-control drop_down">
                <option value="">Select Orgranization</option>
                </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Product*</label>
                <div class="col-sm-10">
                <select name="product" onChange="getState(this.value)" class="form-control drop_down">
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
                 <select name="request"  onchange="return divshow(this.value)" class="form-control drop_down">
                 <option>Select Request Type</option>                              
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
	mask:'9999/19/39 29:59'
});
</script>
</html>