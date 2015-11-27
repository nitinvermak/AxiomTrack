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
if(isset($_REQUEST['taxType']))
{
	$taxType = mysql_real_escape_string($_POST['taxType']);
	$taxRate = mysql_real_escape_string($_POST['taxRate']);
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tbltax set taxTypeId = '$taxType', taxRate = '$taxRate' where taxId=" .$_REQUEST['id'];
// Call User Activity Log function
UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
// End Activity Log Function
mysql_query($sql);
$_SESSION['sess_msg']='Tax Rate updated successfully';
header("location:manage_tax_rate.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tbltax where taxRate = '$taxRate'");
if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tbltax set taxTypeId = '$taxType', taxRate = '$taxRate'");
// Call User Activity Log function
UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $query);
// End Activity Log Function
$_SESSION['sess_msg']='Tax Rate added successfully';
header("location:manage_tax_rate.php?token=".$token);
exit();

}
else
{
$msg="Tax Rate already exists";
}
}
}
if(isset($_REQUEST['taxId']) && $_REQUEST['taxId']){
$queryArr=mysql_query("select * from tbltax where taxId =".$_REQUEST['taxId']);
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
<script type="text/javascript" src="js/taxrate.js"></script>
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
    	<h1>Area</h1>
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
        <td colspan="2"><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?></td>
        </tr>
        
        <tr>
        <td>Tax Type*</td>
        <td>
        <select name="taxType"  id="taxType"  class="form-control input-sm drop_down">
        <option label="" value="">Select Tax Type</option>
         		<?php $Country=mysql_query("select * from tbltaxtype");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $resultCountry['taxTypeId']; ?>" <?php if(isset($result['taxTypeId']) && $resultCountry['City_id']==$result['city_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['taxType'])); ?></option>
                <?php } ?> 
        </select>
        </td>
        </tr>
        
        <tr>
        <td>Tax Rate*</td>
        <td><input name="taxRate" id="taxRate" type="text" class="form-control text_box" value="<?php if(isset($result['area_id'])) echo $result['Area_name']; ?>"/></td>
        </tr>
        
        <tr>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
        <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
        <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_area.php?token=<?php echo $token ?>'"/></td>
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