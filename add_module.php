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
if(isset($_REQUEST['moduleName']))
{
$moduleName=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['moduleName'])));
$moduleCategory = htmlspecialchars(mysql_real_escape_string(trim($_POST['moduleCategory'])));
$displayModuleName = htmlspecialchars(mysql_real_escape_string($_POST['displayModuleName']));
$parentModuleId = htmlspecialchars(mysql_real_escape_string($_REQUEST['parentModuleId']));
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tblmodulename set moduleName='$moduleName', moduleCatId = '$moduleCategory', displayModuleName = '$displayModuleName', parentId = '$parentModuleId' where moduleId=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='Module Name updated successfully';
header("location:manage_module.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tblmodulename where moduleName ='$moduleName'");
//$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tblmodulename set  moduleName='$moduleName', moduleCatId = '$moduleCategory', displayModuleName = '$displayModuleName', parentId = '$parentModuleId'");
$_SESSION['sess_msg']='Module Name added successfully';
header("location:manage_module.php?token=".$token);
exit();
}
else
{
$msg="Module Name already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblmodulename where moduleId =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/manage_module.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
		$("#moduleCategory").change(function(){
			$.post("ajaxrequest/parent_module_request.php?<?php echo $token; ?>",
				{
					moduleCategory : $('#moduleCategory').val()
				},
					function( data ){
						$("#showParent").html(data);
				});
				 
		});
});
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
    	<h1>Module</h1>
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
        
        <tr >
          <td>Module Category</td>
          <td><select name="moduleCategory" id="moduleCategory" class="form-control input-sm drop_down">
                <option label="" value="">Select Module Category</option>
                        <?php $Country=mysql_query("SELECT * FROM tblmodulecategory ORDER BY moduleCategory ASC ");
                                       while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['moduleCatId']; ?>" <?php if(isset($result['moduleCatId']) && $resultCountry['moduleCatId']==$result['moduleCatId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['moduleCategory'])); ?></option>
                        <?php } ?> 
        	</select></td>
        </tr>
        <tr >
          <td>Parent Module</td>
          <td>
          <div id="showParent">
          	<select name="parentModuleId" id="parentModuleId" class="form-control input-sm drop_down">
                <option label="" value="">Select Parent Module</option>
          	</select>
          </div>
        </td>
        </tr>
        <tr >
        <td>Module Name*</td>
        <td><input type="text" name="moduleName" id="moduleName" class="form-control text_box" value="<?php if(isset($result['moduleId'])) echo $result['moduleName'];?>" /></td>
        </tr>
        <tr >
        <td>Display Module Name*</td>
        <td><input type="text" name="displayModuleName" id="displayModuleName" class="form-control text_box" value="<?php if(isset($result['moduleId'])) echo $result['displayModuleName'];?>" /></td>
        </tr>
        <tr>
        <td></td>
        <td><input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
            <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>                        
            <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
			onclick="window.location='manage_module.php?token=<?php echo $token ?>'"/></td>
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