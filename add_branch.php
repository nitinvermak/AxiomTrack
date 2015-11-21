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
if(isset($_REQUEST['company_name']))
{
	$company_name = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['company_name'])));
	$country = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['country'])));
	$state = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['state'])));
	$district = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['district'])));
	$city = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['city'])));
	$area = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['area'])));
	$pin_code = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['pin_code'])));
	$company_address=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['address'])));
	$company_person=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['contact_person'])));
	$company_contact=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['contact_no'])));
	$company_type=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['company_type'])));
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
		$sql="update tblbranch set CompanyName='$company_name', 
			  Country = '$country', State = '$state', District_ID = '$district', 
			  city = '$city', Area = '$area', pincode = '$pin_code', 
			  Address='$company_address', contact_Person='$company_person', 
			  contact_no='$company_contact', branchtype='$company_type' 
			  where id=" .$_REQUEST['id'];
		// Call User Activity Log function
		UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
		// End Activity Log Function
		mysql_query($sql);
		$_SESSION['sess_msg']='Branch updated successfully';
		header("location:manage_branch.php?token=".$token);
		exit();
}
else{
$queryArr=mysql_query("select * from tblbranch where CompanyName ='$company_name'");
if(mysql_num_rows($queryArr)<=0)
{
		$query=mysql_query("insert into tblbranch set CompanyName='$company_name', 
							Country = '$country', State = '$state', District_ID = '$district', 
							city = '$city', Area = '$area', pincode = '$pin_code', 
							Address='$company_address', contact_Person='$company_person', 
							contact_no='$company_contact', branchtype='$company_type'");
		// Call User Activity Log function
		UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $query);
		// End Activity Log Function
		$_SESSION['sess_msg']='Branch added successfully';
		header("location:manage_branch.php?token=".$token);
		exit();

}
else
{
$msg="Branch already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblbranch where id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/manage_branch.js"></script>
<script type="text/javascript" src="js/call_state_city_area.js"></script>
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
    	<h1>Branch</h1>
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
        <td>Branch Name*</td>
        <td><input name="company_name" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['CompanyName']; ?>"/></td>
        </tr>
        <tr>
          <td valign="top">Country*</td>
          <td><select name="country" id="country" class="form-control drop_down" onChange="return CallState(this.value)">
            	<option value="">Select Country</option>
				<?php $Country=mysql_query("select * from tblcountry");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['Country']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?></option>
                <?php } ?>
          	</select>           </td>
        </tr>
        <tr>
          <td valign="top">State*</td>
          <td>
          <div id="Divstate">
            	<select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control drop_down">
                  <option value="">Select State</option>
                 	<option value="<?php echo $result['State']; ?>" <?php if(isset($result['id']) && $result['State']==$result['State']){ ?>selected<?php } ?>><?php echo getcity(stripslashes(ucfirst($result['State']))); ?></option>
                </select>
          </div>          </td>
        </tr>
        <tr>
          <td valign="top">District*</td>
          <td>
          <div id="divdistrict">
          <select name="district" id="district"  class="form-control drop_down" onChange="return CallCity(this.value)">
            	<option value="">Select District</option>
				 
                 <option value="<?php echo $result['District_ID']; ?>" <?php if(isset($result['id']) && $result['District_ID']==$result['District_ID']){ ?>selected<?php } ?>><?php echo getdistrict(stripslashes(ucfirst($result['District_ID']))); ?></option>
          </select>
          </div>        </td>
        </tr>
        <tr>
          <td valign="top">City*</td>
          <td>
          <div id="divcity">
              <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control drop_down" >
                <option value="">Select City</option>
                <option value="<?php echo $result['city']; ?>" <?php if(isset($result['id']) && $result['city']==$result['city']){ ?>selected<?php } ?>><?php echo getcityname(stripslashes(ucfirst($result['city']))); ?></option>
              </select>
        </div>        </td>
        </tr>
        <tr>
          <td valign="top">Area*</td>
          <td>
          <div id="divarea">
          <select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control drop_down">
            <option value="">Select Area</option>
           	 <option value="<?php echo $result['Area']; ?>" <?php if(isset($result['id']) && $result['Area']==$result['Area']){ ?>selected<?php } ?>><?php echo getarea(stripslashes(ucfirst($result['Area']))); ?></option>
          </select>
        </div>        </td>
        </tr>
        <tr>
          <td valign="top">Pincode*</td>
          <td>
          <div id="divpincode">
            <input name="pin_code" id="pin_code" class="form-control text_box"  value="<?php if(isset($result['id'])) echo $result['pincode']; ?>" type="text" />
          </div>          </td>
        </tr>
        <tr>
        <td valign="top">Address*</td>
        <td><textarea name="address" id="address" class="form-control txt_area" rows="3" cols="16"><?php if(isset($result['id'])) echo stripslashes($result['Address']); ?></textarea></td>
        </tr>         
        
        <tr>
        <td>Contact Person*</td>
        <td><input name="contact_person" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['contact_Person']; ?>"/></td>
        </tr>
        <tr>
        <td>Contact No. *</td>
        <td><input name="contact_no" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['contact_no']; ?>"/></td>
        </tr>
        <tr>
        <td>Type*</td>
        <td><span class="paddBot11">
        <select name="company_type" class="form-control input-sm drop_down">
        <option value="">Select Type</option>
        <?php $company=mysql_query("select * from tblbranchtype");
			  while($resultcompany=mysql_fetch_assoc($company)){
		?>
        <option value="<?php echo $resultcompany['id']; ?>" <?php if(isset($result['id']) && $resultcompany['id']==$result['branchtype']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultcompany['Branchtype'])); ?></option>
        <?php } ?>
        </select>
        </span></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
        <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
        <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_branch.php?token=<?php echo $token ?>'"/></td>
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