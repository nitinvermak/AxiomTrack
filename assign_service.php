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
if(isset($_POST['save']))
	{
		$cust_id = mysql_real_escape_string($_POST['cust_id']);
		$service_branch = mysql_real_escape_string($_POST['service_branch']);
		$service_area_mgr = mysql_real_escape_string($_POST['service_area_mgr']);
		$service_exe = mysql_real_escape_string($_POST['service_exe']);
		$sql = "Insert into tbl_assign_customer_branch set 	cust_id = '$cust_id', 
				service_branchId = '$service_branch', service_area_manager = '$service_area_mgr', 
				service_executive = '$service_exe'";
		$query = mysql_query($sql);
		$update = "UPDATE `tbl_customer_master` SET status = '1' Where cust_id=".$_REQUEST['cust_id'];
		// Call User Activity Log function
		UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $update);
		// End Activity Log Function
		/*echo $update;*/
		$change_status = mysql_query($update);
		if($query)
		{
			$_SESSION['sess_msg']='Branch assign successfully';
			header("location:assign_service_branch.php?token=".$token);
		}
	}

if(isset($_REQUEST['cust_id']) && $_REQUEST['cust_id']){
		$queryArr=mysql_query("SELECT A.cust_id, A.calling_product, B.Company_Name, B.Country, 
							   B.State, B.District_id, B.City, B.Area, B.Address, B.Pin_code, 
							   B.created, A.telecaller_id, C.branch_id
							   FROM tbl_customer_master as A 
							   INNER JOIN  tblcallingdata as B 
							   ON A.callingdata_id = B.id
							   INNER JOIN tblassign as C 
							   ON A.telecaller_id = C.telecaller_id 
							   WHERE A.cust_id =".$_REQUEST['cust_id']);
		$result=mysql_fetch_assoc($queryArr);
}
if(isset($_REQUEST['id']) && $_REQUEST['id'])
	{
		$queryArr=mysql_query("SELECT * FROM tbl_assign_customer_branch WHERE service_branchId =".$_REQUEST['id']);
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
<script>
function validate(obj)
{
	if(obj.service_branch.value == "")
	{
		alert('Please Select Serivce Branch');
		obj.service_branch.focus();
		return false;
	}
	if(obj.service_area_mgr.value == "")
	{
		alert("Please Select Service Area Manager");
		obj.service_area_mgr.focus();
		return false;
	}
	if(obj.service_exe.value == "")
	{
		alert('Please Select Service Executive');
		obj.service_exe.focus();
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
    	<h1>Assign Service Branch</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	
        <form name='myform' action="" method="post" onSubmit="return validate(this)">
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['cust_id']) and $_GET['cust_id']>0){ echo $_GET['cust_id']; }?>"/>
        <input type="hidden" name="device_id" id="device_id" value="<?php $query = mysql_query("select device_id from tbldeviceid")?>"/>
        <div class="table table-responsive">
    	<table border="0">
        <tr >
        <td>Customer Id*</td>
        <td><input type="text" name="cust_id" id="cust_id" class="form-control text_box" value="<?php if(isset($result['cust_id'])) echo $result['cust_id'];?>" readonly></td>
        <td>Customer Name</td>
        <td><input type="text" name="customer_name" id="customer_name" value="<?php if(isset($result['cust_id'])) echo $result['Company_Name'];?>" class="form-control text_box" readonly></td>
        </tr>
        <tr >
        <td>Country</td>
        <td><input type="text" name="country" id="country" value="<?php if(isset($result['cust_id'])) echo getcountry($result['Country']);?>" class="form-control text_box" readonly></td>
        <td>State</td>
        <td><input type="text" name="state" id="state" value="<?php if(isset($result['cust_id'])) echo getstate($result['State']);?>" class="form-control text_box" readonly></td>
        </tr>
        <tr >
          <td>District</td>
          <td><input type="text" name="district" id="district" value="<?php if(isset($result['cust_id'])) echo getdistrict($result['District_id']);?>" class="form-control text_box" readonly></td>
          <td>City</td>
          <td><input type="text" name="city" id="city" value="<?php if(isset($result['cust_id'])) echo getcities($result['City']);?>" class="form-control text_box" readonly></td>
        </tr>
        <tr >
          <td>Area</td>
          <td><input type="text" name="customer_name8" id="customer_name8" value="<?php if(isset($result['cust_id'])) echo getarea($result['Area']);?>" class="form-control text_box" readonly></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
        
        <tr>
          <td height="34">Address</td>
          <td rowspan="2"><textarea class="form-control txt_area" name="address" readonly><?php if(isset($result['cust_id'])) echo $result['Address'];?></textarea></td>
          <td>Pincode</td>
          <td><input type="text" name="Pin_code" id="Pin_code" value="<?php if(isset($result['cust_id'])) echo getpincode($result['Pin_code']);?>" class="form-control text_box" readonly></td>
        </tr>
        <tr>
          <td height="34">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="34">Activation Date</td>
          <td><input type="text" name="createdate" id="createdate" value="<?php if(isset($result['cust_id'])) echo $result['created'];?>" class="form-control text_box" readonly></td>
          <td>Lead Gen. Exe.</td>
          <td><input type="text" name="customer_name2" id="customer_name2" value="<?php if(isset($result['cust_id'])) echo gettelecallername($result['telecaller_id']);?>" class="form-control text_box" readonly></td>
        </tr>
        <tr>
          <td height="34">Lead Gen. Branch</td>
          <td><input type="text" name="branch_id" id="branch_id" value="<?php if(isset($result['cust_id'])) echo getBranch($result['branch_id']);?>" class="form-control text_box" readonly></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="34">Serivce Branch</td>
          <td>
           <select name="service_branch" id="service_branch" class="form-control drop_down">
                 <option value="">Select Techician</option>
                 <?php $Country=mysql_query("select * from tblbranch");
					   while($resultCountry=mysql_fetch_assoc($Country)){
				 ?>
                 <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['CompanyName']) && $resultCountry['id']==$result['CompanyName']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                 <?php } ?>
          </select>
          </td>
          <td>Service Area Mgr.</td>
          <td>
          <select name="service_area_mgr" id="service_area_mgr"  class="form-control drop_down">
                 <option value="">Select Techician</option>
                 <?php $Country=mysql_query("select * from tbluser where User_Category='9'");
					   while($resultCountry=mysql_fetch_assoc($Country)){
				 ?>
                 <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['service_area_manager']) && $resultCountry['id']==$result['service_area_manager']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?></option>
                 <?php } ?>
          </select>
          </td>
        </tr>
        <tr>
          <td height="34">Service Executive</td>
          <td>
          <select name="service_exe" id="service_exe"  class="form-control drop_down">
                 <option value="">Select Techician</option>
                 <?php $Country=mysql_query("select * from tbluser");
					   while($resultCountry=mysql_fetch_assoc($Country)){
				 ?>
                 <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['service_area_manager']) && $resultCountry['id']==$result['service_area_manager']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?></option>
                 <?php } ?>
          </select>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="34"><input type="submit" name="save" id="save" value="Submit" class="btn btn-primary btn-sm"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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