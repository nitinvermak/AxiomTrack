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

$error =0;
if(isset($_REQUEST['modulename']))
{
	$modulId = mysql_real_escape_string($_POST['modulename']);
	$UsercategoryId = mysql_real_escape_string($_POST['Usercategory']);
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tblmoduls set moduleId = '$modulId', usercategoryId='$UsercategoryId' where moduleId=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='Role updated successfully';
header("location:manage_role.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tblmoduls where District_name ='$company_name'");
if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tblmoduls set moduleId = '$modulId', usercategoryId='$UsercategoryId', created=Now()");
$_SESSION['sess_msg']='Role added successfully';
header("location:manage_role.php?token=".$token);
exit();

}
else
{
$msg="Role already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblmoduls where moduleId =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/roleValidation.js"></script>
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
    	<h1>Add Role</h1>
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
          <td>Module Name*</td>
          <td><select name="modulename" class="form-control input-sm drop_down" id="modulename">
            <option label="" value="">Select Module Name</option>
            <?php $Country=mysql_query("SELECT * FROM tblmodulename");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['moduleId']) && $resultCountry['id']==$result['moduleId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['module_name'])); ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
        <td>User Category*</td>
        <td>
        <select name="Usercategory" class="form-control input-sm drop_down" id="Usercategory">
        <option label="" value="">Select User Category</option>
         		<?php $Country=mysql_query("SELECT * FROM tblusercategory ORDER BY User_Category ASC ");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['usercategoryId']) && $resultCountry['id']==$result['usercategoryId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['User_Category'])); ?></option>
                <?php } ?> 
        </select>        </td>
        </tr>
        

        <tr>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
        <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
        <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_role.php?token=<?php echo $token ?>'"/></td>
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