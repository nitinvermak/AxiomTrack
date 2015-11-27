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
		$simId = mysql_real_escape_string($_POST['simId']);
		$status = mysql_real_escape_string($_POST['status']);
		$sql = "Update tblsim set status_id = '$status' Where id ='$simId '";
		$result = mysql_query($sql);
		$_SESSION['sess_msg']='Status Updated successfully';
		header("location:manage_sim.php?token=".$token);
		exit();
	}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblsim where id =".$_REQUEST['id']);
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

<script type="text/javascript" src="js/manage_import_device.js"></script>
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
    	<h1>Uppdate Sim</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	<div class="col-md-3">
        </div>
        <div class="col-md-6">
        <form name='myform' action="" method="post" onSubmit="return validate(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="table table-responsive">
    	<table border="0">
        <tr >
        <td colspan="2"><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?> </td>
        </tr>
        <tr >
        <td>Sim Id*</td>
        <td><input name="simId" id="simId" class="form-control text_box" type="text" value="<?php if(isset($result['id'])) echo $result['id'];?>" readonly /></td>
        </tr>
        
       <tr >
       <td>Status*</td>
       <td><select name="status" id="status" class="form-control drop_down">
         <option value="">Select Status</option>
         <option value="0">Instock</option>
         <option value="2">Replacement</option>
         <option value="3">Damage</option>
         <option value="4">Reissue</option>
       </select></td>
       </tr>
       
      <tr>
      <td></td>
      <td><input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
          <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>                        
          <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" onClick="window.location='manage_sim.php?token=<?php echo $token ?>'"/></td>
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
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>