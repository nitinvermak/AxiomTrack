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
if(isset($_REQUEST['userName']))
{
	$userName = mysql_real_escape_string($_POST['userName']);
	
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes')
{
	if(isset($_REQUEST['cid']) && $_REQUEST['cid']!='')
	{
		foreach($_POST['branch'] as $chckvalue)
		{
			$sql = "update userbranchmapping set userId = '$userName', branchId = '$chckvalue' where id = " .$_REQUEST['id'];
			echo $sql;
			mysql_query($sql);
			$_SESSION['sess_msg']='Branch Role updated successfully';
			header("location:manage_branch_role.php?token=".$token);
			exit();
		}
	}
else
{
	$queryArr=mysql_query("select * from userbranchmapping where userId = '$userName' and branchId = '$chckvalue'");
	if(mysql_num_rows($queryArr)<=0)
	{
		foreach($_POST['branch'] as $chckvalue)
		{
			$query=mysql_query("insert into userbranchmapping set  userId = '$userName', branchId = '$chckvalue'");
			$_SESSION['sess_msg']='Branch Role added Successfully';
			header("location:manage_branch_role.php?token=".$token);
			/*exit();*/
		}
	}
	else
	{
		$msg="Branch Role already exists";
	}
}
}
if($_REQUEST['id']){
$queryArr=mysql_query("select * from userbranchmapping where userId =".$_REQUEST['id']);
echo $queryArr;
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
<script type="text/javascript" src="js/addBranchRole.js"></script>
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
    	<h1>Add Branch Role</h1>
        <hr>
    </div>
    <div class="col-md-12">
        <div class="col-md-8">
        <form name='myform' action="" method="post" onSubmit="return validate(this)">        
        <div class="table table-responsive">
    	<table width="467" border="0">
        <tr>
        <td colspan="3"><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?>
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>  		</td>
        </tr> 
        <tr>
        <td width="99">Select User*</td>
        <td width="152">
           	<select name="userName" id="userName" class="form-control drop_down">
            <option value="">Select UserName</option>
            <?php $querySql = mysql_query("select * from tbluser");
					while($resultSql = mysql_fetch_assoc($querySql)){
			?>
            <option value="<?php echo $resultSql['id']; ?>"
             <?php if(isset($result['userId']) && $resultSql['id']==$result['userId']){ ?>selected<?php } ?>>
			 <?php echo $resultSql['First_Name']." ".$resultSql['Last_Name']; ?></option>
            <?php } ?>
          	</select>        </td>
        <td width="202" rowspan="3" valign="top">
			<?php $branch=mysql_query("select * from tblbranch");
				 $branchList = str_replace( ')','',str_replace('(','',BranchLogin($_REQUEST['id'])));
				 
 				 $authBranches= explode(',',$branchList);
				 echo $_SERVER["PHP_SELF"];
			 
				 	
                 while($branchName=mysql_fetch_assoc($branch)){
				 echo in_array($branchName['id'], $authBranches);
            ?>
            <input type="checkbox" name="branch[]" id="branch" value="<?php echo $branchName['id']; ?>" 
			 <?php if(in_array($branchName['id'], $authBranches)) { ?>checked <?php } ?>/>
            
             <?php echo $branchName['CompanyName']; ?> <br  />
             <?php } ?> 
             </td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
          <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_branch_role.php?token=<?php echo $token ?>'"/></td>
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