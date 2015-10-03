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
if(isset($_REQUEST['registration_no']))
{
$registration_no=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['registration_no'])));
$category=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['category'])));
$type_of_vehicle=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['type_of_vehicle'])));
$fuel_type=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['fuel_type'])));
$date_of_instal=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['date_of_instal'])));
$owner_type=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['owner_type'])));
$owner_name=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['owner_name'])));
$model=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['model'])));
$year_of_mfr=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['year_of_mfr'])));
$engine_cc=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['engine_cc'])));
$engine_no=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['engine_no'])));
$chassis_no=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['chassis_no'])));
$hp=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['hp'])));
$prvs_insurance_cpny=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['prvs_insurance_cpny'])));
$policy_no=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['policy_no'])));
$policy_issue_date=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['policy_issue_date'])));
$policy_ex_date=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['policy_ex_date'])));
$permit_regis_no=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['permit_regis_no'])));
$registration_date=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['registration_date'])));
$registration_expry_date=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['registration_expry_date'])));

}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tblvehile set reg_no ='$registration_no', category_id='$category', type_of_vechile='$type_of_vehicle', opt_fuel_type='$fuel_type', date_of_instal='$date_of_instal', Owner_type='$owner_type', Owner_name='$owner_name', model_id='$model', year_of_mfg='$year_of_mfr', engine_cc='$engine_cc', engine_no='$engine_no', chassis_no='$chassis_no', hp='$hp', prvs_insuranc_c_id='$prvs_insurance_cpny' policy_no='$policy_no', policy_issue_d='$policy_issue_date', policy_ex_d='$policy_ex_date', permit_regis_no='$permit_regis_no', 	reg_issue_date='$registration_date', reg_ex_date='$registration_expry_date' where id=" .$_REQUEST['id'];
mysql_query($sql);

$_SESSION['sess_msg']='Vehicle  updated successfully';
header("location:manage_vehicle.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tblvehile where reg_no ='$registration_no'");
//$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tblvehile set reg_no='$registration_no', category_id='$category', type_of_vechile='$type_of_vehicle', opt_fuel_type='$fuel_type', date_of_instal='$date_of_instal', Owner_type='$owner_type', Owner_name='$owner_name', model_id='$model', year_of_mfg='$year_of_mfr', engine_cc='$engine_cc', engine_no='$engine_no', chassis_no='$chassis_no', hp='$hp', prvs_insuranc_c_id	='$prvs_insurance_cpny', policy_no='$policy_no', policy_issue_d='$policy_issue_date', policy_ex_d='$policy_ex_date', permit_regis_no='$permit_regis_no', 	reg_issue_date='$registration_date', reg_ex_date='$registration_expry_date'");
$_SESSION['sess_msg']='Vehicle added successfully';
header("location:manage_vehicle.php?token=".$token);
exit();
}
else
{
$msg="Vehicle already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblvehile where Country_id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
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
    	<h3>Update Vehicle Details</h3>
        <hr>
    </div>
    <div class="col-md-12">
    	<form name='myform' action="" method="post"  onsubmit="return validate(this)">
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <table border="0" class="table">
        <tr>
        <td>Registration No: </td>
        <td><input name="registration_no" id="registration_no" class="form-control text_box" type="text" /></td>
        <td>Category*</td>
        <td><select name="category" id="category" class="form-control drop_down">
            		<option value="">Select Category</option>
            		<?php $Country=mysql_query("select * from tblvechilecategory");
						  while($resultCountry=mysql_fetch_assoc($Country)){
					?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['vechilecategory'] )); ?></option>
            <?php } ?>
          </select>
        </td>
        </tr>  
        <tr>
        <td>Type of Vehicle</td>
        <td><select name="type_of_vehicle" id="type_of_vehicle" class="form-control drop_down">
            		<option value="">Type of Vehicle</option>
            <?php $Country=mysql_query("select * from tbltypeofvechile");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['type_of_vechile'] )); ?></option>
            <?php } ?>
          </select>
        </td>
        <td>Operation Fuel Type*</td>
        <td><select name="fuel_type" id="fuel_type" class="form-control drop_down">
            <option value="">Fuel Type</option>
            <?php $Country=mysql_query("select * from tblopt_fuel");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['fuel_type'] )); ?></option>
            <?php } ?>
          </select>
        </td>
        </tr>
        <tr>
        <td>Date of Installation*</td>
        <td><input name="date_of_instal" id="date_of_instal" class="form-control text_box" type="text" /></td>
        <td>Owner Type*</td>
        <td><input name="owner_type" id="owner_type" class="form-control text_box" type="text" /></td>
        </tr>
        <tr>
        <td>Owner Name*</td>
        <td><input name="owner_name" id="owner_name"  class="form-control text_box" type="text" />
        </td>
        <td>Model Name*</td>
        <td><select name="model" id="model" class="form-control drop_down">
            <option value="">Select Model*</option>
            <?php $Country=mysql_query("select * from tblvechilemodel");
				   while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['vechile_model'] )); ?></option>
            <?php } ?>
            </select>
        </td>
        </tr>
        <tr>
        <td>Year of Manufacturing*</td>
        <td><input name="year_of_mfr" id="year_of_mfr" class="form-control text_box" type="text" /></td>
        <td>Engine CC*</td>
        <td><input name="engine_cc" id="engine_cc" class="form-control text_box" type="text" /></td>
        </tr>
        <tr>
        <td>Engine No*</td>
        <td><input name="engine_no" id="engine_no"  class="form-control text_box" type="text" /></td>
        <td>Chassis No.*</td>
        <td><input name="chassis_no" id="chassis_no" class="form-control text_box" type="text" /></td>
        </tr>
        <tr>
        <td>HP*</td>
        <td><input name="hp" id="hp" class="form-control text_box" type="text" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td colspan="2" valign="top">Insurance Details*</td>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr>
        <td valign="top" >Previous Insurance Company:</td>
        <td valign="top"><select name="prvs_insurance_cpny" id="prvs_insurance_cpny" class="form-control drop_down">
              			<option value="">Select Company</option>
            			<?php $Country=mysql_query("select * from tblinsurancecmpny");
							  while($resultCountry=mysql_fetch_assoc($Country)){
						?>
              			<option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['company_name'] )); ?></option>
              			<?php } ?>
            			</select>
       </td>
       <td>Policy No*</td>
       <td><input name="policy_no" id="policy_no" class="form-control text_box" type="text" /></td>
       </tr>
       <tr>
       <td valign="top">Policy Issue Date*</td>
       <td valign="top"><input name="policy_issue_date" id="policy_issue_date" class="form-control text_box" type="text" /></td>
       <td valign="top">Policy Expiry Date*</td>
       <td valign="top"><input name="policy_ex_date" id="policy_ex_date" class="form-control text_box" type="text" /></td>
       </tr>
       <tr>
       <td>&nbsp;</td>
       <td>Permit Details</td>
       <td>&nbsp;</td>
       </tr>
       <tr>
       <td valign="top">Permit Registration No*</td>
       <td valign="top"><input name="permit_regis_no" id="permit_regis_no" class="form-control text_box" type="text" /></td>
       <td>Registation Date</td>
       <td valign="top"><input name="registration_date" id="registration_date" class="form-control text_box" type="text" /></td>
       </tr>
       <tr>
       <td>Registration Expiry Date*</td>
       <td valign="top"><input name="registration_expry_date" id="registration_expry_date" class="form-control text_box" type="text" /></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       </tr>
       <tr height="40px">
       <td valign="top">&nbsp;</td>
       <td><input type="reset" id="reset" class="btn btn-primary btn-sm"  value="Reset"/> &nbsp;&nbsp;&nbsp;<input type="submit" value="Submit" id="submit" class="btn btn-primary btn-sm"  /></td>
       <td valign="top">&nbsp;</td>
       <td valign="top">&nbsp;</td>
       </tr>
    </table>
    </form>
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