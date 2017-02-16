<?php

include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
include("includes/simpleimage.php");
session_set_cookie_params(3600,"/");
session_start();
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

	

if(isset($_POST['submit']))
	{
		/*Update Calling Data*/
		$update_id = mysql_real_escape_string($_POST['cid']);
		$first_name = mysql_real_escape_string($_POST['first_name']);
		$last_name = mysql_real_escape_string($_POST['last_name']);
		$company = mysql_real_escape_string($_POST['company']);
		$phone = mysql_real_escape_string($_POST['phone']);
		$mobile = mysql_real_escape_string($_POST['mobile']);
		$email = mysql_real_escape_string($_POST['email']);
		$Address = mysql_real_escape_string($_POST['Address']);
		$area = mysql_real_escape_string($_POST['area']);
		$city = mysql_real_escape_string($_POST['city']);
		$state = mysql_real_escape_string($_POST['state']);
		$district = mysql_real_escape_string($_POST['district']);
		$country = mysql_real_escape_string($_POST['country']);
		$pincode = mysql_real_escape_string($_POST['pin_code']);
		$calling_status = '1';
		$update_records = "Update tblcallingdata set First_Name='$first_name', Last_Name='$last_name', Company_Name='$company', Phone='$phone', Mobile='$mobile', email='$email', Address='$Address', Area='$area', City='$city', State='$state', District_id='$district', Country='$country', Pin_code='$pincode', calling_status='$calling_status' where id='$update_id'";
		/*echo $update_records;*/
		$query = mysql_query($update_records);
		/*End Calling Data Update*/
		
		/*Insert Calling Status */
		$calling_status = $_POST['rdopt'];
		$update_id = mysql_real_escape_string($_POST['cid']);
		$callingdate = mysql_real_escape_string($_POST['callingdate']);
		$model = mysql_real_escape_string($_POST['model']);
		$no_of_vehicles = mysql_real_escape_string($_POST['no_of_vehicles']);
		$p_device_amt = mysql_real_escape_string($_POST['p_device_amt']);
		$p_device_rent = mysql_real_escape_string($_POST['p_device_rent']);
		$payment_type = mysql_real_escape_string($_POST['payment_type']);
		$installation_charges = mysql_real_escape_string($_POST['installation_charges']);
		$follow_date = mysql_real_escape_string($_POST['follow_date']);
		$reason = mysql_real_escape_string($_POST['reason']);
		$remarks = mysql_real_escape_string($_POST['remarks']);
		$customer_type = mysql_real_escape_string($_POST['customer_type']);
		$installment_amt = mysql_real_escape_string($_POST['installment_amt']);
		$telecaller = mysql_real_escape_string($_POST['telecaller']);
		if($calling_status == "1")
		{
		$insert_calling_status = "insert into tbl_telecalling_status set callingdata_id='$update_id', calling_date='$callingdate', device_model_id='$model', calling_status='$calling_status', no_of_vehicles='$no_of_vehicles', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', follow_up_date='$follow_date', not_interested_resason='$reason', remark_not_interested='$remarks', customer_type = '$customer_type', installment_amt = '$installment_amt', telecaller_id = '$telecaller'";
		header("location:telecalling.php?token=".$token);
		$query = mysql_query($insert_calling_status);
		}
		else if($calling_status == "0")
		{
		$insert_calling_status = "insert into tbl_telecalling_status set callingdata_id='$update_id', device_model_id='$model', calling_status='$calling_status', no_of_vehicles='$no_of_vehicles', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', follow_up_date='$follow_date', not_interested_resason='$reason', remark_not_interested='$remarks' customer_type = '$customer_type', installment_amt = '$installment_amt', telecaller_id = '$telecaller'";
		header("location:telecalling.php?token=".$token);
		$query = mysql_query($insert_calling_status);
		}
		
		/* end */
	}
if(isset($_REQUEST['id']) && $_REQUEST['id'])
	{
	$queryArr=mysql_query("SELECT * FROM tblcallingdata WHERE id =".$_REQUEST['id']);
	$result=mysql_fetch_assoc($queryArr);
	
	}
	
	//Confirm Client record store
	if(isset($_POST['submit1']))
		{
			$update_id = mysql_real_escape_string($_POST['cid']);
			$first_name = mysql_real_escape_string($_POST['first_name']);
			$last_name = mysql_real_escape_string($_POST['last_name']);
			$company = mysql_real_escape_string($_POST['company']);
			$phone = mysql_real_escape_string($_POST['phone']);
			$mobile = mysql_real_escape_string($_POST['mobile']);
			$email = mysql_real_escape_string($_POST['email']);
			$Address = mysql_real_escape_string($_POST['Address']);
			$area = mysql_real_escape_string($_POST['area']);
			$city = mysql_real_escape_string($_POST['city']);
			$state = mysql_real_escape_string($_POST['state']);
			$country = mysql_real_escape_string($_POST['country']);
			$pincode = mysql_real_escape_string($_POST['pin_code']);
			$district = mysql_real_escape_string($_POST['district']);
			$telecaller = mysql_real_escape_string($_POST['telecaller']);
			$calling_products = mysql_real_escape_string($_POST['calling_products']);
			$model = mysql_real_escape_string($_POST['model']);
			$p_device_amt = mysql_real_escape_string($_POST['p_device_amt']);
			$p_device_rent = mysql_real_escape_string($_POST['p_device_rent']);
			$payment_type = mysql_real_escape_string($_POST['payment_type']);
			$customer_type = mysql_real_escape_string($_POST['customer_type']);
			$installment_amt = mysql_real_escape_string($_POST['installment_amt']);
			$installation_charges = mysql_real_escape_string($_POST['installation_charges']);
			$confirm_client = "insert into tbl_customer_master set 	callingdata_id='$update_id',  calling_product='$calling_products', device_model_id='$model', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', customer_type='$customer_type', installment_amt='$installment_amt', telecaller_id='$telecaller',  confirmation_date=Now() ";
			$result = mysql_query($confirm_client);
			/*echo "cnfrm".$confirm_client;*/
			$change_status = "UPDATE tblcallingdata SET First_Name='$first_name', Last_Name='$last_name', Company_Name='$company', Address='$Address', Area='$area', City='$city', District_id='$district', State='$state', Pin_code='$pincode', Country='$country', Phone='$phone', Mobile='$mobile', email='$email', status ='1', calling_status='1' where id = '$update_id'";
			$query = mysql_query($change_status);
			//Save calling status
			$insert_calling_status = "insert into tbl_telecalling_status set callingdata_id='$update_id', calling_date='$callingdate', device_model_id='$model', calling_status='$calling_status', no_of_vehicles='$no_of_vehicles', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', follow_up_date='$follow_date', not_interested_resason='$reason', remark_not_interested='$remarks', customer_type = '$customer_type', installment_amt = '$installment_amt', telecaller_id = '$telecaller'";
			header("location:telecalling.php?token=".$token);
			$query = mysql_query($insert_calling_status);
			//end Save
			/*echo $change_status;*/
			echo "<script>alert('Client Confirm Successfully !');</script>";
			header("location:telecalling.php?token=".$token);
		}
	//End Confirm Client 
	
if(isset($_GET['id']))
{
 $id = $_GET['id'];
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Autocomplete - Combobox</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<!--conbo box component-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script  src="js/ajax.js"></script>
<script src="js/combo_box.js"></script>
 
  <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
  </style>
  <script src="js/combo_box.js"></script>
</head>
<body>
 
<div class="ui-widget">
  <label>Your preferred programming language: </label>
  <select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control drop_down">
                  <option value="">Select State</option>
				  <?php $Country=mysql_query("select * from tblstate");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                  ?>
                  <option value="<?php echo $resultCountry['State_id']; ?>" <?php if(isset($result['State']) && $resultCountry['State_id']==$result['State']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
                <?php } ?>
 </select>
 <br>
 <select name="district" id="district"  class="form-control drop_down" onChange="return CallCity(this.value)">
            	<option value="">Select District</option>
				  <?php $Country=mysql_query("select * from tbl_district");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                  ?>
                  <option value="<?php echo $resultCountry['District_id']; ?>" <?php if(isset($result['District_id']) && $resultCountry['District_id']==$result['District_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['District_name'])); ?></option>
                <?php } ?>
          </select><br>
          <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control drop_down" >
            <option value="">Select City</option>
            <?php $Country=mysql_query("select * from  tbl_city_new order by City_Name");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['City_id']; ?>" <?php if(isset($result['City_id']) && $resultCountry['City_id']==$result['City']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['City_Name'])); ?></option>
            <?php } ?>
          </select><br>
          <select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control drop_down">
            <option value="">Select Area</option>
            <?php $Country=mysql_query("select * from tbl_area_new order by Area_name");
									  
									  while($resultCountry=mysql_fetch_assoc($Country)){
									  ?>
            <option value="<?php echo $resultCountry['area_id']; ?>" <?php if(isset($result['area_id']) && $resultCountry['area_id']==$result['Area']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Area_name'])); ?></option>
            <?php } ?>
          </select>

</div>
<button id="toggle">Show underlying select</button>
 
 
</body>
</html>