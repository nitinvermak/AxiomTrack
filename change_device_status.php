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

if(isset($_POST['submit']))
	{
		$deviceId = mysql_real_escape_string($_POST['deviceId']);
		$status = mysql_real_escape_string($_POST['status']);
		$sql = "Update tbl_device_master set status = '$status' Where id = '$deviceId'";
		$result = mysql_query($sql);
		mysql_query($sql);
		$_SESSION['sess_msg']='Status Updated successfully';
		header("location:manage_model.php?token=".$token);
		exit();
	}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tbl_device_master where id =".$_REQUEST['id']);
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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script type="text/javascript" src="js/manage_import_device.js"></script>

<script>
 $(function() {
    $( "#date_of_purchase" ).datepicker({dateFormat: 'yy-mm-dd'});
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
    	<h1>Import Device</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	<div class="col-md-3">
        </div>
        <div class="col-md-6">
        <form name='myform' action="" method="post" onSubmit="return validate(this)">
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <input type="hidden" name="device_id" id="device_id" value="<?php $query = mysql_query("select device_id from tbldeviceid")?>"/>
        <div class="table table-responsive">
    	<table border="0">
        
        <tr >
        <td><strong>Import Device</strong></td>
        <td><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?> 
            <?php if(isset($id) && $id !="") echo '<script type="text/javascript">alert("' . $id . '");</script>'; ?></td>
        </tr>
        <tr >
        <td>Device Id*</td>
        <td><input type="text" name="deviceId" id="deviceId" value="<?php if(isset($result['id'])) echo $result['id'];?>" class="form-control text_box" readonly></td>
		</tr>
        <tr >
        <td>Status*</td>
        <td><select name="status" id="status" class="form-control drop_down">
        		<option value="">Select Status</option>
        		<option value="0">Instock</option>
                <option value="2">Replacement</option>
                <option value="3">Damage</option>
        	</select>
        </td>
        </tr>
        
      <td></td>
      <td><input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit" onClick="check();"/>
        <input type='reset' name='reset' class="open btn btn-primary btn-sm" value="Reset"  onClick="deleteCok();"/>        
        <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
		  onclick="window.location='manage_model.php?token=<?php echo $token ?>'"/></td>
      </tr>
      </table>
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
<script src="js/bootstrap.min.js"></script>
</body>
</html>