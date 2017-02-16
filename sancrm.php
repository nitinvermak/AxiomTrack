<?php 
include("includes/config.inc.php"); 

$firstName = $_GET['firstname'];
$lastName = $_GET['lastname'];
$companyName  = $_GET['companyName'];
$phone = $_GET['phone'];
$mobile = $_GET['mobile'];
$email = $_GET['email'];
$address = $_GET['address'];
$country = $_GET['country'];
$state = $_GET['state'];
$district = $_GET['district'];
$city = $_GET['city'];
$area = $_GET['area'];
$pincode = $_GET['pincode'];
$callingproduct = $_GET['callingproduct'];
$devicemodel = $_GET['devicemodel'];
$deviceamt = $_GET['deviceamt'];
$rentamt = $_GET['rentamt'];
$paymenttype = $_GET['paymenttype'];
$installationcharges = $_GET['installationcharges'];
$customertype = $_GET['customertype'];
$telecaller = $_GET['telecaller'];

$sql = "INSERT INTO tblcallingdata SET `First_Name` = '$firstName', `Last_Name`='$lastName', `Company_Name`='$companyName', `Address`='$address', `Area`='$area', `City`='$city', `District_id`='$district', `State`='$state', `Pin_code`='$pincode', `Country`='$country',`Phone`='$phone',`Mobile`='$mobile',`email`='$email',`data_source`='Directory', `createdby` ='$telecaller',`created`= Now()";
echo $sql."<br>";
$result = mysql_query($sql);
$callingId =  mysql_insert_id();

$sqlcust = "insert into tbl_customer_master set callingdata_id='$callingId', calling_product='$callingproduct', device_model_id='$devicemodel', np_device_amt='$deviceamt', np_device_rent='$rentamt', rent_payment_mode='$paymenttype', r_installation_charge='$installationcharges', customer_type='$customertype', telecaller_id='$telecaller',  confirmation_date=Now() ";
echo $sqlcust."<br>";
$resultcust = mysql_query($sqlcust);
echo "Client Confirm";

?>