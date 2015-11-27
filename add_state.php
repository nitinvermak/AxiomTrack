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
if(isset($_REQUEST['state_name']))
{
$datasource=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['state_name'])));
$country_name=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['country'])));
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tblstate set State_name='$datasource', Country_id='$country_name' where State_id=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='State updated successfully';
header("location:manage_state.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tblstate where State_name='$datasource', Country_id='$country_name'");
//$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tblstate set  State_name='$datasource', Country_id='$country_name'");
$_SESSION['sess_msg']='State added successfully';
header("location:manage_state.php?token=".$token);
exit();
}
else
{
$msg="State already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblstate where State_id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/state.js"></script>
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
    	<h1>State</h1>
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
        <td>Country</td>
        <td><select name="country" id="country" class="form-control drop_down" onChange="return CallState(this.value)">
            	<option value="">Select Country</option>
				<?php $Country=mysql_query("select * from tblcountry");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['Country_id']) && $resultCountry['Country_id']==$result['Country_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?></option>
                <?php } ?>
          	</select></td>
        </tr>
        
        
        <tr>
        <td>State *</td>
        <td><input type="text" name="state_name" id="state_name" class="form-control text_box" value="<?php if(isset($result['State_id'])) echo $result['State_name'];?>"/></td>
        </tr>
        
        <tr>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit2' class="btn btn-primary" value="Submit"/>
        <input type='reset' name='reset2' class="btn btn-primary " value="Reset"/>
        <input type='button' name='cancel2' class="btn btn-primary" value="Back"onclick="window.location='manage_state.php?token=<?php echo $token ?>'"/></td>
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