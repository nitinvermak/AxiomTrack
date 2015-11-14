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
if (isset($_SESSION) && $_SESSION['user_category_id']!=1) 
{
		header("location: home.php?token=".$token);
}
$error =0;
if(isset($_REQUEST['plan_category']))
	{
		$datasource=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan_name'])));
		$plan_description=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan_description'])));
		$plan_category=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan_category'])));
		$service_provider=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['provider'])));
		$plan_price=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan_price'])));
		$taxId = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['taxType'])));
	}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes')
{
	if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
		$sql="update tblplan set planSubCategory ='$datasource', plan_description='$plan_description', 			   	         	              productCategoryId='$plan_category', serviceprovider_id='$service_provider', plan_status='A', 
		      plan_rate='$plan_price', taxId = '$taxId' where id=" .$_REQUEST['id'];
		mysql_query($sql);
		$_SESSION['sess_msg']='Plan updated successfully';
		header("location:manage_plan.php?token=".$token);
		exit();
	}
	else{
		$queryArr=mysql_query("select * from tblplan where productCategoryId = '$plan_category' and planSubCategory = '$datasource' 							   and plan_rate = '$plan_price'");
		$result=mysql_fetch_assoc($queryArr);
		 if(mysql_num_rows($queryArr)<=0)
		 {
			$query=mysql_query("insert into tblplan set planSubCategory='$datasource', plan_description='$plan_description', productCategoryId='$plan_category', serviceprovider_id='$service_provider', plan_status='A', plan_rate='$plan_price', taxId = '$taxId'");
			$_SESSION['sess_msg']='Plan added successfully';
			header("location:manage_plan.php?token=".$token);
			exit();
		}
		else
		{
		$msg="Plan already exists";
		}
	}
}


if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblplan where id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/manage_plan.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
<script type="text/javascript">
// send ajax request when select plan category
    $(function () {
      $('.ddlCountry').change(function () {
        var catId = ($(this).val());
		$.post("ajaxrequest/show_plan_name.php?token=<?php echo $token;?>",
				{
					catId : (catId)
				},
					function( data ){
						$("#responseText").html(data);
			});
		});
    });
// End 

//  send ajax request when select tax type
$(document).ready(function(){
	$('#taxType').change(function(){
	var catId = ($(this).val());
	$.post("ajaxrequest/show_tax_rate.php?token=<?php echo $token;?>",
			{
				taxType : $("#taxType").val()
			},
			function(data){
				$(".showTaxRate").html(data);
			});
	});
});
// end 
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
        <td>Plan Category*</td>
        <td>
        	<select name="plan_category" id="plan_category" class="form-control drop_down ddlCountry">
            <option value="">Select Plan Category</option>
            <?php $Country=mysql_query("select * from tblplancategory");
						   while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>"
			<?php if(isset($result['productCategoryId']) && $resultCountry['id']==$result['productCategoryId']){
			?>selected<?php } ?>>
			<?php echo stripslashes(ucfirst($resultCountry['category'])); ?></option>
            <?php } ?>
            </select>        
        </td>
        </tr>
        </div>
       <!-- <tr >
        <td colspan="2">
         <div id="responseText">
        
         </div>
         </td>
         </tr>-->
         <tr >
         <td>Plan Name*</td>
         <td><div id="responseText">
         <input type="text" name="plan_name" id="plan_name" class="form-control text_box" >
         <?php 
		 if($result['planSubCategory'] > 0)
		 {
		 ?>
         <input type="text" name="plan_name" id="plan_name" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['planSubCategory'];?>"/>
         <?php 
		 } 
		 else if($result['serviceprovider_id'] > 0)
		 {
		 ?>
         <input type="text" name="provider" id="provider" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['serviceprovider_id'];?>"/>
		 <?php 
		 }
		 ?>
         </div></td>
         </tr>
         <tr >
         <td>Description*</td>
         <td valign="top"><textarea name="plan_description" id="plan_description" class="form-control txt_area"/>
           <?php if(isset($result['id'])) echo $result['plan_description'];?></textarea></td>
         </tr>
         <tr >
         <td>Price*</td>
         <td><input type="text" name="plan_price" id="plan_price" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['plan_rate'];?>" />   </td>
         </tr>
		 <tr >
         <td>Tax Type*</td>
         <td>
         	<select name="taxType" id="taxType" class="form-control drop_down">
            <option value="">Select Tax Type</option>
            <?php $Country=mysql_query("select * from tbltaxtype order by taxType");
						   while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['taxTypeId']; ?>"
			<?php if(isset($result['productCategoryId']) && $resultCountry['id']==$result['productCategoryId']){
			?>selected<?php } ?>>
			<?php echo stripslashes(ucfirst($resultCountry['taxType'])); ?></option>
            <?php } ?>
            </select>
         </td>
         </tr>
		 <tr >
         <td>Tax Rate*</td>
         <td>
         	<div class="showTaxRate">
            	<select name="taxRate" id="taxRate" class="form-control drop_down">
                <option value="">Select Tax Rate</option>
                </select>
            </div>
         </td>
         </tr>
         <tr >
         <td>Tax*</td>
         <td><select name="exclusive" id="exclusive" class="drop_down form-control">
         	 	<option value="">Select</option>
                <option Value="Y">Inclusive</option>
                <option Value="N">Exclusive</option>
             </select>
         </td>
         </tr>
         <tr>
         <td> </td>
         <td><input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
             <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>                        
             <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
			 onclick="window.location='manage_plan.php?token=<?php echo $token ?>'"/></td>
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
<!--<script src="js/jquery.js"></script>-->
<script src="js/bootstrap.min.js"></script>
</body>
</html>