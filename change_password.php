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
		$currentPassword = htmlspecialchars(mysql_real_escape_string($_REQUEST['currentPassword']));
		$newPassword = htmlspecialchars(mysql_real_escape_string($_REQUEST['newPassword']));
		$userId = $_SESSION['user_id'];
		$sql = "UPDATE tbluser SET Password ='$newPassword' Where id = '$userId' and Password = '$currentPassword'";
		/*echo $sql;*/
		$result = mysql_query($sql);
		if($result)
			{
				$msg = "Password Changed Successfully";
			}
		else
			{
				$msg = "Password do not Match";
			}
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
<script type="text/javascript" src="js/Nibbler.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
base64 = new Nibbler({
    dataBits: 8,
    codeBits: 6,
    keyString: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/',
    pad: '='
});
function formvalid()
{
    if (document.login.currentPassword.value=='')
    {
        alert("Please Enter Old Password");
        document.login.currentPassword.focus()
        return false;
    }
    if (document.login.newPassword.value=='')
    {
        alert("Please Enter New Password");
        document.login.newPassword.focus()
        return false;
    }  
	if (document.login.confirmPassword.value=='')
    {
        alert("Please Enter Confirm Password");
        document.login.confirmPassword.focus()
        return false;
    } 
	if (document.login.newPassword.value != document.login.confirmPassword.value)
    {
        alert("Password do not match");
        document.login.confirmPassword.focus()
        return false;
    } 
//  alert(base64.encode(document.login.txtpassword.value));
//alert(base64.encode(document.login.txtpassword.value));
    document.login.currentPassword.value=base64.encode(document.login.currentPassword.value);
	document.login.newPassword.value=base64.encode(document.login.newPassword.value);
    return true;
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
    	<h1>Change Password</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	
        <div class="col-md-10">
        <form name="login" method="post" action="" onSubmit="formvalid()">
        <div>
        <div class="message"><?php if(isset($msg)) { echo $msg; } ?></div>
        <table>
       
        <tr>
        <td><label>Current Password</label></td>
        <td><input type="password" name="currentPassword" id="currentPassword" class="text_box form-control"/></td>
        <td><span id="currentPassword"  class="required"></span></td>
        </tr>
        <tr>
        <td><label>New Password</label></td>
        <td><input type="password" name="newPassword" id="newPassword" class="text_box form-control"/></td>
        <td><span id="newPassword" class="required"></span></td>
        </tr>
        <td><label>Confirm Password</label></td>
        <td><input type="password" name="confirmPassword" id="confirmPassword" class="text_box form-control"/></td>
        <td><span id="confirmPassword" class="required"></span></td>
        </tr>
        <tr>
        <td></td>
        <td><input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary btn-sm"></td>
        </tr>
        </table>
        </div>
        </form>
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