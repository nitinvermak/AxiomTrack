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
if(isset($_REQUEST['district']))
{
	$district = mysql_real_escape_string($_POST['district']);
	$city = mysql_real_escape_string($_POST['city']);
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tbl_city_new set District_ID = '$district', City_Name='$city' where City_id=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='City updated successfully';
header("location:manage_city.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tbl_city_new where City_Name='$district'");
if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tbl_city_new set District_ID = '$district', City_Name='$city'");
$_SESSION['sess_msg']='City added successfully';
header("location:manage_city.php?token=".$token);
exit();

}
else
{
$msg="City already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tbl_city_new where City_id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/add_city.js"></script>
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
    	<h1>City</h1>
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
        <td>District*</td>
        <td>
        <select name="district" class="form-control input-sm drop_down" id="district" onChange="return callGrid();">
        <option label="" value="">Select District</option>
         		<?php $Country=mysql_query("select * from tbl_district");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $resultCountry['District_id']; ?>" <?php if(isset($result['District_ID']) && $resultCountry['District_id']==$result['District_ID']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['District_name'])); ?></option>
                <?php } ?> 
        </select>
        </td>
        </tr>
        
        <tr>
        <td>City*</td>
        <td><input name="city" id="city" type="text" class="form-control text_box" value="<?php if(isset($result['City_id'])) echo $result['City_Name']; ?>"/></td>
        </tr>
        
        <tr>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit2' class="btn btn-primary" value="Submit"/>
        <input type='reset' name='reset2' class="btn btn-primary " value="Reset"/>
        <input type='button' name='cancel2' class="btn btn-primary" value="Back"onclick="window.location='manage_city.php?token=<?php echo $token ?>'"/></td>
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