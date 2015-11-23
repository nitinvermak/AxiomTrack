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
if(isset($_REQUEST['serviceprovider']))
{
$serviceprovider=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['serviceprovider'])));
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
	$sql="update tblserviceprovider set serviceprovider='$serviceprovider' where id=" .$_REQUEST['id'];
	// Call User Activity Log function
	UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
	// End Activity Log Function
	mysql_query($sql);
	$_SESSION['sess_msg']='Service Provider Name Updated Successfully';
	header("location:manage_serviceprovider.php?token=".$token);
	exit();
}
else{
	$queryArr=mysql_query("select * from tblserviceprovider where serviceprovider ='$serviceprovider'");
	//$result=mysql_fetch_assoc($queryArr);
if(mysql_num_rows($queryArr)<=0)
{
	$query=mysql_query("insert into tblserviceprovider set  serviceprovider='$serviceprovider' ");
	// Call User Activity Log function
	UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $query);
	// End Activity Log Function
	$_SESSION['sess_msg']='Service Provider Name added successfully';
	header("location:manage_serviceprovider.php?token=".$token);
	exit();
}
else
{
	$msg="Service Provider Name already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
	$queryArr=mysql_query("select * from tblserviceprovider where id =".$_REQUEST['id']);
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

<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/manage_provider.js"></script>
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
    	<h1>Service Provider</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	<div class="col-md-3">
        </div>
        <div class="col-md-6">
        <form name='myform' action="" method="post" onSubmit="return validate(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="table table-responsive">
    	<table border="0">
        <tr>
        <td colspan="2"><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?></td>
        </tr>
        <tr>
        <td>Service Provider Name*</td>
        <td><input type="text" name="serviceprovider" id="serviceprovider" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['serviceprovider'];?>" /></td>
        </tr>
                 
        <tr>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
        <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
        <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
							  onclick="window.location='manage_serviceprovider.php?token=<?php echo $token ?>'"/></td>
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