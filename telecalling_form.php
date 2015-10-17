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
		$downpayment = mysql_real_escape_string($_POST['downpayment']);
		$telecaller = mysql_real_escape_string($_POST['telecaller']);
		if($calling_status == "1")
		{
		$insert_calling_status = "insert into tbl_telecalling_status set callingdata_id='$update_id', calling_date='$callingdate', device_model_id='$model', calling_status='$calling_status', no_of_vehicles='$no_of_vehicles', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', follow_up_date='$follow_date', not_interested_resason='$reason', remark_not_interested='$remarks', customer_type = '$customer_type', downpaymentAmount = '$downpayment', telecaller_id = '$telecaller'";
		header("location:telecalling.php?token=".$token);
		$query = mysql_query($insert_calling_status);
		}
		else if($calling_status == "0")
		{
		$insert_calling_status = "insert into tbl_telecalling_status set callingdata_id='$update_id', device_model_id='$model', calling_status='$calling_status', no_of_vehicles='$no_of_vehicles', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', follow_up_date='$follow_date', not_interested_resason='$reason', remark_not_interested='$remarks' customer_type = '$customer_type', downpaymentAmount = '$downpayment', telecaller_id = '$telecaller'";
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
			$downpayment = mysql_real_escape_string($_POST['downpayment']);
			$installation_charges = mysql_real_escape_string($_POST['installation_charges']);
			$confirm_client = "insert into tbl_customer_master set 	callingdata_id='$update_id',  calling_product='$calling_products', device_model_id='$model', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', customer_type='$customer_type', telecaller_id='$telecaller',  confirmation_date=Now() ";
			$result = mysql_query($confirm_client);
			echo "cnfrm".$confirm_client;
			$change_status = "UPDATE tblcallingdata SET First_Name='$first_name', Last_Name='$last_name', Company_Name='$company', Address='$Address', Area='$area', City='$city', District_id='$district', State='$state', Pin_code='$pincode', Country='$country', Phone='$phone', Mobile='$mobile', email='$email', status ='1', calling_status='1' where id = '$update_id'";
			$query = mysql_query($change_status);
			//Save calling status
			$insert_calling_status = "insert into tbl_telecalling_status set callingdata_id='$update_id', calling_date='$callingdate', device_model_id='$model', calling_status='$calling_status', no_of_vehicles='$no_of_vehicles', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', follow_up_date='$follow_date', not_interested_resason='$reason', remark_not_interested='$remarks', customer_type = '$customer_type', downpaymentAmount = '$downpayment', telecaller_id = '$telecaller'";
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
<script type="text/javascript" src="js/telecallingFormValidate.js"></script>
<script  src="js/ajax.js"></script>
<script src="js/combo_box.js"></script>
<script type="text/javascript">
function IfInterested() {
    document.getElementById("ifinterested").style.display = "";
	document.getElementById("nointerested").style.display = "none";
	
}

function NotInterested() {
	//alert("test");
    document.getElementById("ifinterested").style.display = "none";
	document.getElementById("nointerested").style.display = "";
}
 
var popUpObj;
        function showModalPopUp() {
            popUpObj = window.open("generate_ticket.php?id=<?php echo $row["callingdata_id"]; ?>&token=<?php echo $token ?>",
    "ModalPopUp",
    "toolbar=no," +
    "scrollbars=no," +
    "location=no," +
    "statusbar=no," +
    "menubar=no," +
    "resizable=0," +
    "width=800," +
    "height=400," +
    "left = 90," +
    "top=300"
    );
	
            popUpObj.focus();
            LoadModalDiv();
  }

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
        <td>Other Contact Details</td>
        <td><input name="area2" id="area2" value="" class="form-control text_box" type="text" />        </td>
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
            <input name="pin_code" id="pin_code" class="form-control text_box"  value="<?php if(isset($result['id'])) echo getpincode($result['Pin_code']); ?>" type="text" />
          </div></td>
        </tr>
        <tr>
        <td>Address*</td>
        <td rowspan="2" valign="top"><textarea id="Address" class="form-control txt_area" name="Address" rows="2" style="width:200px" ><?php if(isset($result['id'])) echo $result['Address']; ?></textarea></td>
        <td>&nbsp;</td>
        <td></td>
        </tr>
        
        <tr>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr>
        <td>Telecaller Name*</td>
        <td  valign="top" width="37%">
            <select name="telecaller" id="telecaller" class="form-control text_box" >
            <?php $Country=mysql_query("SELECT * FROM tblcallingdata as A, tblassign as B 
WHERE A.id = B.callingdata_id and B.callingdata_id ='$id'");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['telecaller_id']; ?>" <?php if(isset($datasource) && $resultCountry['telecaller_id']==$datasource){ ?>selected<?php } ?>><?php echo gettelecallername(stripslashes(ucfirst($resultCountry['telecaller_id']))); ?></option>
              <?php } ?>
            </select>        </td>
        <td>Data Source*</td>
        <td><input type="text" name="datasource" id="datasource" class="form-control text_box"  value="<?php if(isset($result['id'])) echo $result['data_source']; ?>" />        </td>
        </tr>
        <tr>
        <td>Calling Product* </td>
        <td  valign="top"><select name="calling_products" id="calling_products" class="form-control drop_down">
              <?php $Country=mysql_query("select distinct(callingcategory_id) from tblassign where callingdata_id='$id'");
			  		$_SESSION['product'] = $_GET['cat'];
					while($resultCountry=mysql_fetch_assoc($Country)){
			  ?>
              <option value="<?php echo $resultCountry['callingcategory_id'];  ?>" 
			  <?php if($resultCountry['callingcategory_id']== $_GET['cat'] ){ ?>selected<?php } ?>> <?php echo getproducts(stripslashes(ucfirst($resultCountry['callingcategory_id']))); ?></option>
              <?php } ?>
            </select>        </td>
        <td>Calling Date*</td>
        <td><input name="callingdate" id="callingdate" class="form-control text_box" type="text" value="<?php if(isset($result['id'])) echo $result['calling_date']; ?>" /></td>
        </tr>
        <tr>
        <td>Model*</td>
        <td><select name="model" id="model" class="form-control drop_down">
            <option value="">Select</option>
            <?php $Country=mysql_query("select * from tbldevicemodel");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($result['device_model_id']) && $resultCountry['device_id']==$result['device_model_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
            <?php } ?>
          </select>        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td valign="top">Calling Status*</td>
        <td valign="top"><input type="radio" name="rdopt" id="interested" checked="checked" value="1" onClick="IfInterested()" />
            <strong> Interested</strong></label></td>
          <td><label>
            <input type="radio" name="rdopt" id="notinterested" value="0" onClick="NotInterested()" />
            <strong>Not Interested</strong></label></td>
          <td>&nbsp;</td>
        </tr>
    </table>
    <div id="ifinterested">
    <table class="table">
    <tr>
    <td class="col-sm-2"><strong>Customer Type</strong></td>
    <td valign="top"><select name="customer_type" id="customer_type" class="form-control drop_down" onChange="customerType()">
      <option value="">Select</option>
      <?php $Country=mysql_query("select * from tbl_customer_type");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
      <option value="<?php echo $resultCountry['customer_type_id']; ?>" <?php if(isset($result['customer_type_id']) && $resultCountry['customer_type_id']==$result['customer_type_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['customer_type'])); ?></option>
      <?php } ?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>Device Amt</td>
    <td valign="top"><select name="p_device_amt" id="p_device_amt" class="form-control drop_down">
      <option value="">Select</option>
      <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 1");
			  while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
      <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_amt']) && $resultCountry['id']==$result['np_device_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
      <?php } ?>
    </select></td>
    <td>Rental*</td>
    <td><select name="p_device_rent" id="p_device_rent" class="form-control drop_down">
      <option value="">Select</option>
      <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and plan_description='Rental'");						
		  while($resultCountry=mysql_fetch_assoc($Country)){
    ?>
      <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_rent']) && $resultCountry['id']==$result['np_device_rent']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
      <?php } ?>
    </select></td>
    </tr>
    <tr>
    <td>Installation Charges</td>
    <td valign="top"><select name="installation_charges" id="installation_charges" class="form-control drop_down">
      <option value="">Select</option>
      <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and plan_description='Installtion_Charges'");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
      <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['r_installation_charge']) && $resultCountry['id']==$result['r_installation_charge']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
      <?php } ?>
    </select></td>
    <td>Rent Payment Type*</td>
    <td><select name="payment_type" id="payment_type" class="form-control drop_down">
            <option value="">Payment Type</option>
      		<?php $Country=mysql_query("select * from tbl_frequency");						
		  				   while($resultCountry=mysql_fetch_assoc($Country)){
    		?>
      		<option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($result['FrqId']) && $resultCountry['FrqId']==$result['FrqId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
      		<?php } ?>
        </select></td>
    </tr>    
    <tr>
    <td><strong>Installment Amt.</strong></td>
    <td valign="top"><input type="text" name="downpayment" value="<?php if(isset($result['id'])) echo $result['downpaymentAmount']; ?>" id="downpayment" class="form-control text_box"></td>
    <td>No of Vehicles*</td>
    <td><input type="text" name="no_of_vehicles"  class="form-control text_box" id="no_of_vehicles" value="<?php if(isset($result['id'])) echo $result['no_of_vehicles']; ?>" /></td>
    </tr>
       
   <tr>
   <td valign="top">Follow Up Date (If Any)</td>
   <td valign="top"><input type="text" name="follow_date" class="form-control drop_down" id="follow_date" value="<?php if(isset($result['id'])) echo $result['follow_up_date']; ?>" /></td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   </tr>   
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <tr> </tr>
    </table>
    </div>
    <div id="nointerested" style="display:none">
    <table class="table">
    <tr>
    <td><strong>Reason*</strong></td>
    <td valign="top">
    	<select name="reason" id="reason" class="form-control drop_down">
            <option value="">Select </option>
           	<option value="Already Using Some Another Company GPS">Already Using Some Another Company GPS</option>
            <option value="Rate Issue">Rate Issue</option>
            <option value="Other">Other</option>
        </select>
    </td>
    <td><label>Remark*</label></td>
    <td>
    <input type="text" name="remarks" class="form-control text_box" id="remarks" value="<?php if(isset($result['id'])) echo $result['remark_not_interested']; ?>" /></td>
    </tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <tr></tr>  
    </table>
    </div>
    <table class="table">
    <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="middle" align="center">
    <input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
    <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>                        
    <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
	 onclick="window.location='telecalling.php?token=<?php echo $token ?>'"/>
   	<input type='submit' name='submit1' id="submit1" class="btn btn-primary btn-sm" value="Confirm Client" />
    <input type='button' name='gen_ticket' class="btn btn-primary btn-sm" value="Generate Ticket" onClick="showModalPopUp()"/>
    </td>
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