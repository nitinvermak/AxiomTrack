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
if(isset($_REQUEST['product']))
{
$product=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['product'])));
$request_type=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['request_type'])));
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tblrqsttype set product_id='$product', rqsttype='$request_type' where id=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='Request Type updated successfully';
header("location:manage_request_type.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tblrqsttype");
//$result=mysql_fetch_assoc($queryArr);

$query=mysql_query("insert into tblrqsttype set product_id='$product', rqsttype='$request_type'");
$_SESSION['sess_msg']='Request Type added successfully';
header("location:manage_request_type.php?token=".$token);
exit();
}

}

if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblrqsttype where id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/add_request_type.js"></script>
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
    	<h1>Add Request Type</h1>
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
        <tr >
        <td colspan="2"><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?></td>
        </tr>
        <tr >
          <td>Products*</td>
          <td><select name="product" id="product" class="form-control drop_down">
              <option value="">Select Product</option>
              <?php $Country=mysql_query("select * from tblcallingcategory");
				    while($resultCountry=mysql_fetch_assoc($Country)){
			  ?>
               <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['product_id']) && $resultCountry['id']==$result['product_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['category'])); ?></option>
               <?php } ?>
               </select></td>
        </tr>
        <tr >
        <td>Request Type*</td>
        <td><input type="text" name="request_type" id="request_type" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['rqsttype'];?>" /></td>
        </tr>
        <tr>
        <td> </td>
        <td><input type='submit' name='submit' class="btn btn-primary" value="Submit"/>
			<input type='reset' name='reset' class="btn btn-primary" value="Reset"/>                        
            <input type='button' name='cancel' class="btn btn-primary" value="Back" 
							  onclick="window.location='manage_request_type.php?token=<?php echo $token ?>'"/></td>
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