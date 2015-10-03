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
if(isset($_REQUEST['customer_type']))
{
$customer_type = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['customer_type'])));
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tbl_customer_type set customer_type='$customer_type' where customer_type_id=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='Country updated successfully';
header("location:manage_customer_type.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tbl_customer_type where customer_type ='$customer_type'");
//$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tbl_customer_type set  customer_type='$customer_type' ");
$_SESSION['sess_msg']='Customer Type added successfully';
header("location:manage_customer_type.php?token=".$token);
exit();
}
else
{
$msg="Customer Type already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tbl_customer_type where customer_type_id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/customer_type.js"></script>
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
    	<h1>Customer Type</h1>
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
        <td>Customer Type*</td>
        <td><input type="text" name="customer_type" id="customer_type" class="form-control text_box" value="<?php if(isset($result['customer_type_id'])) echo $result['customer_type'];?>" /></td>
        </tr>
        <tr>
        <td></td>
        <td><input type='submit' name='submit' class="btn btn-primary" value="Save"/></td>
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