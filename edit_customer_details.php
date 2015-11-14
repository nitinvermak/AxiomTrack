<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
include("includes/simpleimage.php");
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
		$datasource = mysql_real_escape_string($_POST['datasource']);
		$branch = mysql_real_escape_string($_POST['branch']);
		$telecaller = mysql_real_escape_string($_POST['telecaller']);
		$callingdate = mysql_real_escape_string($_POST['callingdate']);
		$customerType = mysql_real_escape_string($_POST['customerType']);
		$deviceAmt = mysql_real_escape_string($_POST['deviceAmt']);
		$deviceRent = mysql_real_escape_string($_POST['deviceRent']);
		$installationChrg = mysql_real_escape_string($_POST['installationChrg']);
		$rentFrq = mysql_real_escape_string($_POST['rentFrq']);

		$UpdateCallingData = "UPDATE tblcallingdata SET First_Name = '$first_name', Last_Name = '$last_name', 
							  Company_Name = '$company', Phone = '$phone', Mobile = '$mobile', email = '$email', 
							  Country = '$country', State = '$state', District_id = '$district', City = '$city', 
							  Area = '$area', Pin_code = '$pin_code', Address = '$Address', 
							  data_source = '$datasource' where id =".$_REQUEST['id'];
		/*echo $UpdateCallingData;*/
		$result = mysql_query($UpdateCallingData);
		$UpdateCustomerMaster = "UPDATE tbl_customer_master SET LeadGenBranchId = '$branch', 
								 customer_type = '$customerType', telecaller_id = '$telecaller', 
								 confirmation_date = '$callingdate', np_device_amt = '$deviceAmt',  
								 np_device_rent = '$deviceRent', r_installation_charge = '$installationChrg',
								 rent_payment_mode = '$rentFrq'
								 Where callingdata_id =".$_REQUEST['id'];
		/*echo $UpdateCustomerMaster;*/
		$result = mysql_query($UpdateCustomerMaster);
		$_SESSION['sess_msg']='Customer updated successfully';
		header("location:confirm_customer_details.php?token=".$token);
		exit();
	}

//Select table from database
if(isset($_REQUEST['id']) && $_REQUEST['id'])
	{
	$queryArr=mysql_query("SELECT * FROM tblcallingdata as A 
						   Inner Join tbl_customer_master as B On A.id = B.callingdata_id 
						   WHERE A.id =".$_REQUEST['id']);
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
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script  src="js/ajax.js"></script>
<script src="js/combo_box.js"></script>
<script type="text/javascript">
function CallState()
	{ 
		country = document.getElementById("country").value;
		url="ajaxrequest/getstate.php?country="+country+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,country,"GetState");
	}
	function GetState(str)
	{
		/*alert(str);*/
		document.getElementById('Divstate').innerHTML=str;
	}
function CallDistrict()
	{
		state = document.getElementById("state").value;
		url="ajaxrequest/get_district.php?state="+state+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,state,"GetDistrict");
	}	
	function GetDistrict(str)
	{
		/*alert(str);*/
		document.getElementById('divdistrict').innerHTML=str;
	}
function CallCity()
	{
		district = document.getElementById("district").value;
		url="ajaxrequest/get_city.php?district="+district+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,state,"GetCity");
	}
	function GetCity(str)
	{
		/*alert(str);*/
		document.getElementById('divcity').innerHTML=str;
	}
	
function CallArea()
	{
		city = document.getElementById("city").value;
		url="ajaxrequest/get_area.php?city="+city+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,city,"GetArea");
	}
	function GetArea(str)
	{
		/*alert(str);*/
		document.getElementById('divarea').innerHTML=str;
	}	

function CallPincode()
	{
		area = document.getElementById("area").value;
		url="ajaxrequest/get_pincode.php?area="+area+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,city,"GetPincode");
	}
	function GetPincode(str)
	{
		/*alert(str);*/
		document.getElementById('divpincode').innerHTML=str;
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
    	<h1>Telecalling Form</h1><br>
        <hr>
    </div>  
    <div class="clearfix"></div>      
    <div class="col-md-12 table table-responsive" id="contactform"> <!--open of the single form-->
   	  <form name="contact" method="post" onSubmit="return chkcontactform(this)">
         <input type="hidden" name="submitForm" value="yes" />
         <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <table class="table">
         <tr>
         <td>First Name*</td>
         <td><input name="first_name" id="first_name" value="<?php if(isset($result['id'])) echo $result['First_Name']; ?>" class="form-control text_box" type="text" /></td>
         <td>Last Name*</td>
         <td><input name="last_name" id="last_name" value="<?php if(isset($result['id'])) echo $result['Last_Name']; ?>" class="form-control text_box" type="text" />            </td>
        </tr>
        <tr>
        <td>Company Name*</td>
        <td colspan="4"><input name="company" id="company" value="<?php if(isset($result['id'])) {echo $result['Company_Name'];$_SESSION['organization'] = $result['id'];} ?>"  class="form-control text_box" type="text" />          </td>
        </tr>
        <tr>
        <td>Phone*</td>
        <td><input name="phone" id="phone" value="<?php if(isset($result['id'])) echo $result['Phone']; ?>" class="form-control text_box" type="text" /></td>
        <td>Mobile* </td>
        <td><input name="mobile" id="mobile" value="<?php if(isset($result['id'])) echo $result['Mobile']; ?>" class="form-control text_box" type="text" />          </td>
        </tr>
        <tr>
        <td>Email*</td>
        <td><input name="email" id="email" value="<?php if(isset($result['id'])) echo $result['email']; ?>" class="form-control text_box" type="text" />          </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td>Country</td>
        <td><select name="country" id="country" class="form-control drop_down" onChange="return CallState(this.value)">
            	<option value="">Select Country</option>
				<?php $Country=mysql_query("select * from tblcountry");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['Country']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?></option>
                <?php } ?>
          	</select>        </td>
        <td valign="top">State*</td>
        <td valign="top">
        	<div id="Divstate">
            	<select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control drop_down">
                  <option value="">Select State</option>
                 	<option value="<?php echo $result['State']; ?>" <?php if(isset($result['id']) && $result['State']==$result['State']){ ?>selected<?php } ?>><?php echo getcity(stripslashes(ucfirst($result['State']))); ?></option>
                </select>
            </div>        </td>
        </tr>
        <tr>
        <td>District*</td>
        <td valign="top"><div id="divdistrict">
          <select name="district" id="district"  class="form-control drop_down" onChange="return CallCity(this.value)">
            <option value="">Select District</option>
            <option value="<?php echo $result['District_id']; ?>" <?php if(isset($result['id']) && $result['District_id']==$result['District_id']){ ?>selected<?php } ?>><?php echo getdistrict(stripslashes(ucfirst($result['District_id']))); ?></option>
          </select>
        </div></td>
        <td>City*</td>
        <td><div id="divcity">
          <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control drop_down" >
            <option value="">Select City</option>
            <option value="<?php echo $result['City']; ?>" <?php if(isset($result['id']) && $result['City']==$result['City']){ ?>selected<?php } ?>><?php echo getcityname(stripslashes(ucfirst($result['City']))); ?></option>
          </select>
        </div></td>
        </tr>
        <tr>
          <td>Area*</td>
        <td><div id="divarea">
          <select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control drop_down">
            <option value="">Select Area</option>
           	 <option value="<?php echo $result['Area']; ?>" <?php if(isset($result['id']) && $result['Area']==$result['Area']){ ?>selected<?php } ?>><?php echo getarea(stripslashes(ucfirst($result['Area']))); ?></option>
          </select>
        </div></td>
          <td>Pin Code</td>
          <td><div id="divpincode">
          <select name="pin_code" id="pin_code" class="form-control drop_down">
          <option value="<?php if(isset($result['id'])) echo $result['Pin_code']; ?>" ><?php if(isset($result['id'])) echo getpincode($result['Pin_code']); ?></option>
          </select>
            <!--<input name="pin_code" id="pin_code" class="form-control text_box"  value="<?php if(isset($result['id'])) echo getpincode($result['Pin_code']); ?>" type="text"  readonly/>-->
          </div></td>
        </tr>
        <tr>
        <td>Address*</td>
        <td rowspan="2" valign="top"><textarea id="Address" class="form-control txt_area" name="Address" rows="2" style="width:200px" ><?php if(isset($result['id'])) echo $result['Address']; ?></textarea></td>
        <td>Branch</td>
        <td><select name="branch" id="branch" class="form-control text_box" >
        	<option value="">Select Branch</option>
        	<?php $Country=mysql_query("select * from tblbranch");
                  while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['LeadGenBranchId']){ ?>selected<?php } ?>><?php echo getBranch(stripslashes(ucfirst($resultCountry['id']))); ?></option>
            <?php } ?>    
        </select></td>
        </tr>
        
        <tr>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr>
        <td>Telecaller Name*</td>
        <td  valign="top" width="37%">
        <select name="telecaller" id="telecaller" class="form-control text_box" >
        	<?php $Country=mysql_query("select * from tbluser");
                  while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['telecaller_id']){ ?>selected<?php } ?>><?php echo gettelecallername(stripslashes(ucfirst($resultCountry['id']))); ?></option>
            <?php } ?>    
        </select>
           <!-- <input type="text" name="datasource" id="datasource" class="form-control text_box"  value="<?php if(isset($result['id'])) echo $result['telecaller_id']; ?>" />-->        </td>
        <td>Data Source*</td>
        <td><input type="text" name="datasource" id="datasource" class="form-control text_box"  value="<?php if(isset($result['id'])) echo $result['data_source']; ?>" />        </td>
        </tr>
        <tr>
          <td>Device Amt.*</td>
          <td  valign="top">
          	<select name="deviceAmt" id="deviceAmt" class="form-control drop_down">
                    <option value="">Device Amount</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 1 order by plan_rate");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                  	  <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_amt']) && $resultCountry['id']==$result['np_device_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                <?php } ?>
         	</select>
          </td>
          <td>Rent Amt.</td>
          <td>
          		<select name="deviceRent" id="deviceRent" class="form-control drop_down" >
                    <option value="">Device Rent</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 2 order by plan_rate");						
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_rent']) && $resultCountry['id']==$result['np_device_rent']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
    			</select>
        </td>
        </tr>
        <tr>
          <td>Installation Charges</td>
          <td  valign="top">
          	<select name="installationChrg" id="installationChrg" class="form-control drop_down" >
                   <option value="">Installation Charges</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 3 order by plan_rate");
					
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['r_installation_charge']) && $resultCountry['id']==$result['r_installation_charge']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
        	</select>
          </td>
          <td>Rent Frq.</td>
          <td>
          	<select name="rentFrq" id="rentFrq" class="form-control drop_down" >
                    <option value="">Rent Frequency</option>
                    <?php $Country=mysql_query("select * from tbl_frequency");						
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($result['rent_payment_mode']) && $resultCountry['FrqId']==$result['rent_payment_mode']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
                    <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
        <td>Customer Type</td>
        <td  valign="top">
          <select name="customerType" id="customerType" class="form-control drop_down" onChange="customerType()">
          <option value="">Select</option>
          <?php $Country=mysql_query("select * from tbl_customer_type");
                      while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
          <option value="<?php echo $resultCountry['customer_type_id']; ?>" <?php if(isset($result['customer_type']) && $resultCountry['customer_type_id']==$result['customer_type']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['customer_type'])); ?></option>
          <?php } ?>
    	  </select>        </td>
        <td>Calling Date*</td>
        <td><input name="callingdate" id="callingdate" class="form-control text_box" type="text" value="<?php if(isset($result['id'])) echo $result['confirmation_date']; ?>" /></td>
        </tr>
    </table>
   
    <table class="table">
    <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="middle" align="center">
    <input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
    <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>                        
    <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
	 onclick="window.location='confirm_customer_details.php?token=<?php echo $token ?>'"/></td>
    <td valign="top">&nbsp;</td>
    </tr>
    </table>
     </form>
    </div> 
    <!--end single sim  form--> 
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
<script src="js/bootstrap.min.js"></script>
</body>
<script src="js/jquery.datetimepicker.js"></script>
<script>
$('#callingdate').datetimepicker({
	/*mask:'9999/19/39 29:59'*/
});
$('#follow_date').datetimepicker({
	/*mask:'9999/19/39 29:59'*/
});
</script>
</html>