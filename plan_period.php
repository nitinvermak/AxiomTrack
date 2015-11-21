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
if(isset($_REQUEST['plan_period']))
{
	$datasource=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan_period'])));
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
	$sql="update tblperiod set period='$datasource' where id=" .$_REQUEST['id'];
	// Call User Activity Log function
	UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
	// End Activity Log Function
	mysql_query($sql);
	$_SESSION['sess_msg']='Plan Period updated successfully';
	header("location:manage_plan_period.php?token=".$token);
	exit();
}
else{
	$queryArr=mysql_query("select * from tblperiod where period='$datasource'");
	//$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
	$query=mysql_query("insert into tblperiod set  period='$datasource' ");
	// Call User Activity Log function
	UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
	// End Activity Log Function
	$_SESSION['sess_msg']='Plan Period added successfully';
	header("location:manage_plan_period.php?token=".$token);
	exit();
}
else
{
	$msg="Plan Period already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
	$queryArr=mysql_query("select * from tblperiod where id =".$_REQUEST['id']);
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

<script type="text/javascript" src="js/manage_plan_period.js"></script>
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
    	<h1>Plan Period</h1>
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
        <tr>
        <td>Plan Period*</td>
        <td><input type="text" name="plan_period" id="plan_period" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['period'];?>" /></td>
        </tr>
        <tr>
        <td></td>
        <td><input type='submit' name='submit' class="btn btn-primary btn-sm" value="Save"/></td>
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