<?php
include("../includes/config.inc.php"); 

$first_name = mysql_real_escape_string($_POST['first_name']);
$last_name = mysql_real_escape_string($_POST['last_name']);
$company = mysql_real_escape_string($_POST['company']);
$phone = mysql_real_escape_string($_POST['phone']);
$mobile = mysql_real_escape_string($_POST['mobile']);
$email = mysql_real_escape_string($_POST['email']);
$country = mysql_real_escape_string($_POST['country']);
$state = mysql_real_escape_string($_POST['state']);
$district = mysql_real_escape_string($_POST['district']);
$city = mysql_real_escape_string($_POST['city']);
$area = mysql_real_escape_string($_POST['area']);
$pin_code = mysql_real_escape_string($_POST['pin_code']);
$Address = mysql_real_escape_string($_POST['Address']);
$branch = mysql_real_escape_string($_POST['branch']);
$telecaller = mysql_real_escape_string($_POST['telecaller']);
$datasource = mysql_real_escape_string($_POST['datasource']);
$deviceAmt = mysql_real_escape_string($_POST['deviceAmt']);
$deviceRent = mysql_real_escape_string($_POST['deviceRent']);
$installationChrg = mysql_real_escape_string($_POST['installationChrg']);
$rentFrq = mysql_real_escape_string($_POST['rentFrq']);
$installationChrg = mysql_real_escape_string($_POST['installationChrg']);
$rentFrq = mysql_real_escape_string($_POST['rentFrq']);
$customerType = mysql_real_escape_string($_POST['customerType']);
$callingdate = mysql_real_escape_string($_POST['callingdate']);
$cid = mysql_real_escape_string($_POST['cid']);

$UpdateCallingData = "UPDATE tblcallingdata SET First_Name = '$first_name', Last_Name = '$last_name', 
                Company_Name = '$company', Phone = '$phone', Mobile = '$mobile', email = '$email', 
                Country = '$country', State = '$state', District_id = '$district', City = '$city', 
                Area = '$area', Pin_code = '$pin_code', Address = '$Address', 
                data_source = '$datasource' where id =".$_REQUEST['id'];
echo $UpdateCallingData;
$result = mysql_query($UpdateCallingData);
echo "<br>";
$UpdateCustomerMaster = "UPDATE tbl_customer_master SET LeadGenBranchId = '$branch', 
                 customer_type = '$customerType', telecaller_id = '$telecaller', 
                 confirmation_date = '$callingdate', np_device_amt = '$deviceAmt',  
                 np_device_rent = '$deviceRent', r_installation_charge = '$installationChrg',
                 rent_payment_mode = '$rentFrq'
                 Where callingdata_id =".$_REQUEST['id'];
echo $UpdateCustomerMaster;
$result = mysql_query($UpdateCustomerMaster);
echo "<div class='alert alert-success alert-dismissible' style='max-width:500px' role='alert'>
	  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	  	<span aria-hidden='true'>&times;</span></button>
	  <strong>Customer Details Update Successfully !</strong> 
	</div>";
?>                
