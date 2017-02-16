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
if(isset($_REQUEST['companyName']))
{
	$companyName = mysql_real_escape_string($_POST['companyName']);
	$customerId = mysql_real_escape_string($_POST['customerId']);
	$name = mysql_real_escape_string($_POST['name']);
	$email = mysql_real_escape_string($_POST['email']);
	$mobile = mysql_real_escape_string($_POST['mobile']);
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$hashAndSalt = password_hash($password, PASSWORD_BCRYPT);
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
	$sql = "UPDATE users SET name = '$name', companyId = '$companyName',customerId='$customerId', email = '$email', username = '$username',
		   password = '$password', mobile ='$mobile', updated_at =Now() WHERE id =" .$_REQUEST['id'];
	mysql_query($sql);
	$_SESSION['sess_msg']='User updated successfully';
	header("location:manage_bank.php?token=".$token);
	exit();
}
else{
	$queryArr=mysql_query("select * from users where username='$username'");
if(mysql_num_rows($queryArr)<=0)
{
	$query = mysql_query("insert into users set name = '$name', companyId = '$companyName',customerId='$customerId', email = '$email', 
						username = '$username', password = '$hashAndSalt', mobile ='$mobile', created_at = Now()");		
	$_SESSION['sess_msg']='User added successfully';
	header("location:manage_bank.php?token=".$token);
	exit();
}
else
{
	$msg="User already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from users where id =".$_REQUEST['id']);
$result=mysql_fetch_assoc($queryArr);
}
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/create-customer-user.js"></script>
<script>
function getCustomerId()
{
	$('.loader').show();
	$.post("ajaxrequest/getCustomerId.php?token=<?php echo $token;?>",
			{
				companyName : $('#companyName').val()
			},
			function (data)
			{
				$("#dvcust").html(data);
				$(".loader").removeAttr("disabled");
				$('.loader').fadeOut(1000);
			});
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
    	<h1>Create Customer Id</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	<div class="col-md-1">
        </div>
        <div class="col-md-6">
        <form name='myform' action="" method="post" onSubmit="return validate(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="table table-responsive">
    	<table border="0">
        <tr>
        <td colspan="2"><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?></td>
        </tr>
        
        <tr>
        <td>Company Name*</td>
        <td>
        		<select name="companyName" id="companyName" class="form-control drop_down" onChange="getCustomerId();">
                    <option value="">Select Country</option>
                    <?php $Country=mysql_query("select * from tblcallingdata");						  
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['companyId']) && $resultCountry['id']==$result['companyId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?>            </option>
                    <?php } ?>
                  </select>        </td>
        </tr>
        <tr>
          <td>Customer Id</td>
          <td>
          	  <div id="dvcust">
              	<select name="customerId" id="customerId" class="form-control drop_down">
                    <option value="">Select CustomerId</option>
                </select>
              </div>
          </td>
        </tr>
        <tr>
          <td>Name</td>
          <td><div id="name"><input type="text" name="name" id="name"  value="<?php if(isset($result['name'])){ echo $result['name'];} ?>" class="form-control text_box"></div></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><span class="form-group">
            <input type="text" name="email" id="email" value="<?php if(isset($result['email'])){ echo $result['email']; } ?>" class="form-control text_box">
          </span></td>
        </tr>
        <tr>
          <td>Mobile</td>
          <td><span class="form-group">
            <input type="text" name="mobile" id="mobile" value="<?php if(isset($result['mobile'])) { echo $result['mobile']; } ?>" class="form-control text_box">
          </span></td>
        </tr>
        <tr>
          <td>Username</td>
          <td><span class="form-group">
            <input type="text" name="username" id="username" value="<?php if(isset($result['username'])) { echo $result['username']; } ?>" class="form-control text_box">
          </span></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><span class="form-group">
            <input type="password" name="password" id="password"  class="form-control text_box">
          </span></td>
        </tr>
        
        <tr>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit' id="submit" class="btn btn-primary btn-sm" value="Submit"/>
        <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
        <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_customers_user.php?token=<?php echo $token ?>'"/></td>
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