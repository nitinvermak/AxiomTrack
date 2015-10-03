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
if(isset($_REQUEST['productCategory']))
{
$productCategory=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['productCategory'])));
$planSubCategory=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['planSubCategory'])));
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tblplansubcategory set planCategoryId = '$productCategory', plansubCategory = '$planSubCategory' where planSubid=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='Plan Sub Category updated successfully';
header("location:manage_subcategory.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tblplansubcategory where plansubCategory = '$planSubCategory'");
$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tblplansubcategory set  planCategoryId = '$productCategory', plansubCategory = '$planSubCategory'");
$_SESSION['sess_msg']='Plan Sub Category added successfully';
header("location:manage_subcategory.php?token=".$token);
exit();
}
else
{
$msg="Plan Sub Category exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblplansubcategory where planSubid =".$_REQUEST['id']);
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
<script type="text/javascript">
function validate(obj)
{
	if(obj.productCategory.value == "")
	{
		alert("Please Select Product Category");
		obj.productCategory.focus();
		rerurn false;
	}
	if(obj.planSubCategory.value == "")
	{
		alert("Please Provide Plan Sub Category");
		obj.planSubCategory.focus();
		return false;
	}
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
    	<h1>Plan</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	<div class="col-md-3">
        </div>
        <div class="col-md-6">
        <form name='myform' action="" method="post"  onsubmit="return validate(this)">
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="table table-responsive">
        <table border="0">
        <tr >
        <td colspan="2"><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?></td>
        </tr>
        <div id="plan_category">
        <tr >
        <td>Product Category*</td>
        <td><select name="productCategory" id="productCategory" class="form-control drop_down" onChange="return divshow(this.value)">
            <option value="">Select Plan Category</option>
            <?php $Country=mysql_query("select * from tblplancategory");
						   while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['planCategoryId']) && $resultCountry['id']==$result['planCategoryId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['category'])); ?></option>
            <?php } ?>
            </select>        </td>
        </tr>
        </div>
        <tr >
        <td colspan="2">
        <div id="service_provider" style="display:none; ">
        <table border="0">
        <tr>
        <td>Provider*</td>
        <td align="left">
        <select name="provider" id="provider" class="form-control drop_down">
        <option value="">Select Service Provider</option>
        <?php $Country=mysql_query("select * from tblserviceprovider");
			  while($resultCountry=mysql_fetch_assoc($Country)){
		?>
        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?></option>
         <?php } ?>
         </select>         </td>
         </tr>
         </table>
         </div>         </td>
         </tr>
         <tr >
         <td>Plan Sub Category*</td>
         <td><input type="text" name="planSubCategory" id="planSubCategory" class="form-control text_box" value="<?php if(isset($result['planSubid'])) echo $result['plansubCategory'];?>"/>		 </td>
         </tr>
         
         <tr>
         <td> </td>
         <td><input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
             <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>                        
             <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
			 onclick="window.location='manage_subcategory.php?token=<?php echo $token ?>'"/></td>
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