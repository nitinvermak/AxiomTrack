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
if(isset($_REQUEST['gpsModel']))
{
	$gpsModel = mysql_real_escape_string($_POST['gpsModel']);
	$ip = mysql_real_escape_string($_POST['ip']);
	$apn = mysql_real_escape_string($_POST['apn']);
	$timeZone = mysql_real_escape_string($_POST['timeZone']);
	$dataIntervel = mysql_real_escape_string($_POST['dataIntervel']);
	$deviceInfo = mysql_real_escape_string($_POST['deviceInfo']);
	$deviceStatus = mysql_real_escape_string($_POST['deviceStatus']);
	$config = mysql_real_escape_string($_POST['config']);
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
	$sql="update tbldevicecommand set modelId = '$gpsModel', ipCmd='$ip', apnCmd = '$apn', timeZoneCmd = '$timeZone',
		  dataIntervelCmd = '$dataIntervel', deviceInfoCmd = '$deviceInfo', deviceStatusCmd = '$deviceStatus', 
		  configCmd = '$config' where id=" .$_REQUEST['id'];
	echo $sql;
	// Call User Activity Log function
	/*UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);*/
	// End Activity Log Function
	mysql_query($sql);
	$_SESSION['sess_msg']='Device Command updated successfully';
	header("location:manage_gps_cmd.php?token=".$token);
	exit();
}
else{
	$queryArr=mysql_query("select * from tbldevicecommand where modelId = '$gpsModel'");
if(mysql_num_rows($queryArr)<=0)
{
	$query=mysql_query("insert into tbldevicecommand set modelId = '$gpsModel', ipCmd='$ip', 
						apnCmd = '$apn', timeZoneCmd = '$timeZone', dataIntervelCmd = '$dataIntervel', 
						deviceInfoCmd = '$deviceInfo', deviceStatusCmd = '$deviceStatus', 
		  				configCmd = '$config'");
	// Call User Activity Log function
	/*UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $query);*/
	// End Activity Log Function
	$_SESSION['sess_msg']='Device Command added successfully';
	header("location:manage_gps_cmd.php?token=".$token);
	exit();

}
else
{
	$msg="Device Command already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
	$queryArr=mysql_query("select * from tbldevicecommand where id =".$_REQUEST['id']);
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
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/adddevicecmd.js"></script>
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
    	<h1>Add GPS Command</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	
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
        <td>GPS Model</td>
        <td>
        <select name="gpsModel" id="gpsModel" class="form-control input-sm drop_down" onChange="return callGrid();">
        <option label="" value="">Select City</option>
         		<?php $Country=mysql_query("select * from tbldevicemodel");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $resultCountry['device_id']; ?>" 
				<?php if(isset($result['modelId']) && $resultCountry['device_id']==$result['modelId']){ ?>selected<?php } ?>>
				<?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                <?php } ?> 
        </select>        </td>
        </tr>
        
        <tr>
        <td>IP </td>
        <td><input name="ip" id="ip" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['ipCmd']; ?>"/></td>
        </tr>
        
        <tr>
          <td>APN </td>
          <td><input name="apn" id="apn" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['apnCmd']; ?>"/></td>
        </tr>
        <tr>
          <td>Time Zone</td>
          <td><input name="timeZone" id="timeZone" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['timeZoneCmd']; ?>"/></td>
        </tr>
        <tr>
          <td>Data Intervel</td>
          <td><input name="dataIntervel" id="dataIntervel" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['dataIntervelCmd']; ?>"/></td>
        </tr>
        <tr>
          <td>Device Info</td>
          <td><input name="deviceInfo" id="deviceInfo" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['deviceInfoCmd']; ?>"/></td>
        </tr>
        <tr>
          <td>Device Status</td>
          <td><input name="deviceStatus" id="deviceStatus" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['deviceStatusCmd']; ?>"/></td>
        </tr>
        <tr>
          <td>Config </td>
          <td><input name="config" id="config" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['configCmd']; ?>"/></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
        <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>
        <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_gps_cmd.php?token=<?php echo $token ?>'"/></td>
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