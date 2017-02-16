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

$error =0;
if(isset($_POST['interested']))
{
	$firstName = mysql_real_escape_string($_POST['firstName']);
	$lastName = mysql_real_escape_string($_POST['lastName']);
	$companyName = mysql_real_escape_string($_POST['companyName']);
	$phone = mysql_real_escape_string($_POST['phone']);
	$email = mysql_real_escape_string($_POST['email']);
	$otherDetails = mysql_real_escape_string($_POST['otherDetails']);
	$country = mysql_real_escape_string($_POST['country']);
	$state = mysql_real_escape_string($_POST['state']);
	$district = mysql_real_escape_string($_POST['district']);
	$city = mysql_real_escape_string($_POST['city']);
	$area = mysql_real_escape_string($_POST['area']);
	$pin_code = mysql_real_escape_string($_POST['pin_code']);
	$address = mysql_real_escape_string($_POST['address']);
	$datasource = mysql_real_escape_string($_POST['datasource']);
	$callingProduct = mysql_real_escape_string($_POST['callingProduct']);
	$callingDate = mysql_real_escape_string($_POST['callingDate']);
	$model = mysql_real_escape_string($_POST['model']);
	$mobile = mysql_real_escape_string($_POST['mobile']);
	$contactedStatus = mysql_real_escape_string($_POST['contactedStatus']);
	$userId = $_SESSION['user_id'];
	$branchId = $_SESSION['branch'];
	
	// save Calling date
	$checkDuplicate = mysql_query("SELECT `First_Name`,`Last_Name`,`Mobile` FROM `tblcallingdata` WHERE `First_Name`='$firstName' AND `Last_Name` = '$lastName' AND `Mobile`= '$mobile'"); 
    if(mysql_num_rows($checkDuplicate) <= 0)
	{
		$sqlcallingData = "INSERT INTO `tblcallingdata` SET `First_Name` = '$firstName', `Last_Name` = '$lastName', `Company_Name` = '$companyName', `Address` = '$address', 
						  `Area` = '$area', `City` = '$city', `District_id` = '$district', `State` = '$state', `Pin_code` = '$pin_code', `Country` = '$country', `Phone` = '$phone', 
						  `Mobile` = '$mobile', `email` = '$email', `data_source` = '$datasource', `created`= Now(), `createdby` = '$userId',`status` ='1', `calling_status` = '1', 
						  `contactedStatus` = '$contactedStatus'";
		
		$callingDataResult = mysql_query($sqlcallingData);
		$callingDataId = mysql_insert_id();
		echo "<script> alert('Contact Added Successfully'); </script>";
	}
	else
	{
		echo "<script> alert('Contact already exits'); </script>";
	}
	// end save calling date
	
	// assign contact branch
	$checkDuplicate = mysql_query("SELECT * FROM tblassign WHERE callingdata_id='$chckvalue'"); 
    if(mysql_num_rows($checkDuplicate) <= 0)
	{
		$sqlAssignBranch = "insert into tblassign set callingdata_id='$callingDataId', assign_by = '$userId',
							callingcategory_id='$callingProduct', status_id='2', confirmBy = '$userId', 
							telecaller_id = '$userId', telecaller_assign_status = '1',							
							branch_id='$branchId',createdby='$userId',created=Now()";
		$results = mysql_query($sqlAssignBranch); 
					
	}
	else{
		/*$_SESSION['sess_msg']="<span style='color:red;'>Lead already Assign</span>";*/
	}
	// end assing contact
}

// not contacted data save
if(isset($_POST['notContactedForm']))
{
	$mobile = mysql_real_escape_string($_POST['mobile']);
	$contactedStatus = mysql_real_escape_string($_POST['contactedStatus']);
	$notcontactedRemark = mysql_real_escape_string($_POST['notcontactedRemark']);
	$userId = $_SESSION['user_id'];
	
	$sql = "INSERT INTO `tblcallingdata` SET `Mobile`= '$mobile', `contactedStatus`='$contactedStatus', `notContactedReason`='$notcontactedRemark',`created`=Now(), `createdby` = '$userId'";
	$result = mysql_query($sql);
	echo "<script> alert('Contact Added Successfully'); </script>";
}
// end not contacted 

// not interested
if(isset($_POST['notInterested']))
{
	$mobile = mysql_real_escape_string($_POST['mobile']);
	$contactedStatus = mysql_real_escape_string($_POST['contactedStatus']);
	$notInterestedReason = mysql_real_escape_string($_POST['notInterestedReason']);
	$notInterestedremarks = mysql_real_escape_string($_POST['notInterestedremarks']);
	$userId = $_SESSION['user_id'];
	
	$sql = "INSERT INTO `tblcallingdata` SET `Mobile` = '$mobile',`contactedStatus` ='$contactedStatus'";
	/*echo $sql;*/
	$result = mysql_query($sql);
	$id = mysql_insert_id();
	
	$sql1 = "INSERT INTO `tbl_telecalling_status` Set `callingdata_id` = '$id', `not_interested_resason` = '$notInterestedReason',`remark_not_interested` = '$notInterestedremarks'";
	/*echo $sql1;*/
	$result1= mysql_query($sql1);
	echo "<script> alert('Contact Added Successfully'); </script>";
}
// end not interested
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/direct_telecalling_form_validate.js"></script>
<script  src="js/ajax.js"></script>
<script src="js/combo_box.js"></script>
<script type="text/javascript">
function Contacted() {
/*	alert("test");*/
    document.getElementById("interest").style.display = "";
	document.getElementById("notcontactedReason").style.display = "none";
}
function notContacted(){
/*	alert("test");*/
	document.getElementById("notcontactedReason").style.display = "";
	document.getElementById("interest").style.display = "none";
	document.getElementById("notinterested").style.display = "none";
	document.getElementById("interested").style.display = "none";
}
function Interested(){
	document.getElementById("interested").style.display = "";
	document.getElementById("notinterested").style.display = "none";
}
function NotInterested(){
	document.getElementById("notinterested").style.display = "";
	document.getElementById("interested").style.display = "none";
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
		url="ajaxrequest/getstatelead.php?country="+country+"&token=<?php echo $token;?>";
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
		url="ajaxrequest/get_district_lead.php?state="+state+"&token=<?php echo $token;?>";
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
		url="ajaxrequest/get_city_lead.php?district="+district+"&token=<?php echo $token;?>";
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
		url="ajaxrequest/get_area_lead.php?city="+city+"&token=<?php echo $token;?>";
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
		url="ajaxrequest/getpincodelead.php?area="+area+"&token=<?php echo $token;?>";
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
    <div class="col-md-12" id="contactform"> <!--open of the single form-->
    	<div class="row">
              	<div class="col-md-12">
                <form action="" method="post">
              	<input type="hidden" name="submitForm" value="yes" />
        	  	<input type='hidden' name='uid' id='uid' 
              	value=""/>
          		<div class="form-group form_custom"><!-- form_custom -->
            		<div class="row"><!-- row -->
              			<div class="col-lg-6 col-sm-6 custom_field">
                			<span id="name" for="name"><strong>Mobile</strong> <i>*</i></span>
                            <input type="text" class="form-control" name="mobile" id="mobile">                          
           			  </div>
                      <div class="col-lg-6 col-sm-6 custom_field">
                        	<!--<span><strong>Contacted / Not Contacted</strong> <i>*</i></span>
                            <select name="contactedStatus" id="contactedStatus" class="form-control">
                            	<option value="">--Select--</option>
                                <option value="Mobile Siwtched Off">Mobile Siwtched Off</option>
                                <option value="Busy">Busy</option>
                                <option value="Not Answering">Not Answering</option>
                                <option value="Contact no does not exist">Contact no does not exist</option>
                            </select>    -->              
                        </div>
                        <div class="col-lg-12 col-sm-12 custom_field">
                        	<input type="radio" name="contactedStatus" value="Contacted" id="contactec" onClick="Contacted();"/> 
                			<strong> Contacted </strong>
                            &nbsp;
                            <input type="radio" name="contactedStatus" value="Not Contacted" id="notconected" onClick="notContacted();"/> 
                			<strong> Not Contacted </strong>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-6 col-sm-6 custom_field" id="interest" style="display:none;">
                        	<input type="radio" name="rdopt"  value="Interested" id="single" onClick="Interested();" /> 
                			<strong> Interested </strong>
                             <input type="radio" name="rdopt"  value="Not Interested" id="single" onClick="NotInterested();" /> 
                			<strong> Not Interested  </strong>                                                    
                        </div>
                        <span id="notcontactedReason" style="display:none;">
                         <div class="col-lg-6 col-sm-6 custom_field" >
                         <span><strong>Reason</strong> <i>*</i></span>
                        	<select name="notcontactedRemark" id="notcontactedRemark" class="form-control">
                            	<option value="">Select Reason</option>
                                <option value="Busy">Busy</option>
                                <option value="Mobile Siwtched Off">Mobile Siwtched Off</option>
                                <option value="Not Answering">Not Answering</option>
                                <option value="Contact no does not exist">Contact no does not exist</option>
                            </select>                                          
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group form_custom"><!-- form_custom -->
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 custom_field">
                                        <input type="submit" name="notContactedForm" id="notContactedForm" value="Submit"  onClick = "return ValidateNotInterested();" class="btn btn-primary btn-sm">
                                        <button type="reset" name="reset" id="reset" class="btn btn-primary btn-sm">Reset</button>
                                        <button type="button" name="back" id="back" class="btn btn-primary btn-sm" onClick="window.location.href='telecalling_lead.php'">Back</button>
                                    </div>
                                </div>
                         </div>   
                         </span> 
                        <div class="clearfix"></div>
                        <span id="interested" style="display:none;">
                        	<div class="col-lg-6 col-sm-6 custom_field">
                        	<span><strong>First Name</strong> <i>*</i></span>
                            <input type="text" name="firstName" id="firstName" value="" class="form-control">
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Last Name</strong> <i>*</i></span>
                                <input type="text" name="lastName" id="lastName" value="" class="form-control">
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                        	<span><strong>Company Name</strong> <i>*</i></span>
                            <input type="text" name="companyName" id="companyName" value="" class="form-control">
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Phone</strong> <i>*</i></span>
                                <input type="text" name="phone" id="phone" value="" class="form-control">
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Email</strong> <i>*</i></span>
                                <input type="email" name="email" id="email" value="" class="form-control">
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Other Contact Details</strong> <i>*</i></span>
                                <input type="text" name="otherDetails" id="otherDetails" value="" class="form-control">
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Country</strong> <i>*</i></span>
                                <select name="country" id="country" class="form-control" onChange="return CallState(this.value)">
                                    <option value="">Select Country</option>
                                    <?php $Country=mysql_query("select * from tblcountry");
                                                   while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['Country']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>State</strong> <i>*</i></span>
                                <span id="Divstate">
                                    <select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control">
                                      <option value="">Select State</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>District</strong> <i>*</i></span>
                                <span id="divdistrict">
                                  <select name="district" id="district"  class="form-control" onChange="return CallCity(this.value)">
                                    <option value="">Select District</option>
                                  </select>
                                </span>
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>City</strong> <i>*</i></span>
                                <span id="divcity">
                                  <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control" >
                                    <option value="">Select City</option>
                                  </select>
                                </span>
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Area</strong> <i>*</i></span>
                                <span id="divarea">
                                  <select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control">
                                    <option value="">Select Area</option>
                                  </select>
                                </span>
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Pincode</strong> <i>*</i></span>
                                <span id="divpincode">
                                	<input name="pin_code" id="pin_code" class="form-control"  value="" type="text" />
                              	</span>
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Address</strong> <i>*</i></span>
                                <span id="divpincode">
                                	<textarea class="form-control" name="address" id="address"></textarea>
                              	</span>
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Data Source</strong> <i>*</i></span>
                                <select name="datasource" id="datasource" class="form-control">
                                    <option label="" value="" selected="selected">Data Source</option>
                                    <?php $Country=mysql_query("select * from tbldatasource");
                                                          while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['datasource']; ?>" <?php if(isset($datasource) && $resultCountry['datasource']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['datasource'])); ?></option>
                                    <?php } ?>
                                 </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Calling Product</strong> <i>*</i></span>
                               	 <select name="callingProduct" id="callingProduct" class="form-control">
                                    <option value="">Select Calling Product</option>
                                    <?php $Country=mysql_query("SELECT * FROM `tblcallingcategory` ORDER BY `category`");
                                                   while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['id']; ?>"><?php echo stripslashes(ucfirst($resultCountry['category'])); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Calling Date</strong> <i>*</i></span>
                               	 <input type="text" name="callingDate" id="callingDate" class="form-control date">
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Model</strong> <i>*</i></span>
                               	 <select name="model" id="model" class="form-control">
                                    <option value="">Select</option>
                                    <?php $Country=mysql_query("select * from tbldevicemodel order by model_name");
                                          while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($result['device_model_id']) && $resultCountry['device_id']==$result['device_model_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                                    <?php } ?>
                                  </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group form_custom"><!-- form_custom -->
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 custom_field">
                                        <input type="submit" name="interested" id="interested" value="Submit" onClick="return InterestedFormValidate();" class="btn btn-primary btn-sm">
                                        <button type="reset" name="reset" id="reset" class="btn btn-primary btn-sm">Reset</button>
                                        <button type="button" name="back" id="back" class="btn btn-primary btn-sm" onClick="window.location.href='telecalling_lead.php'">Back</button>
                                    </div>
                                </div>
                            </div>
                        </span> <!--end interested section-->
                        <div class="clearfix"></div>
                         <span id="notinterested" style="display:none;">
                        	<div class="col-lg-6 col-sm-6 custom_field">
                        	<span><strong>Reason</strong> <i>*</i></span>
                            <select name="notInterestedReason" id="notInterestedReason" class="form-control">
                                <option value="">Select </option>
                                <option value="Already Using Some Another Company GPS">Already Using Some Another Company GPS</option>
                                <option value="Rate Issue">Rate Issue</option>
                                <option value="Other">Other</option>
                            </select>
                            </div>
                            <div class="col-lg-6 col-sm-6 custom_field">
                                <span><strong>Remarks</strong> <i>*</i></span>
                                <input type="text" name="notInterestedremarks" id="notInterestedremarks" value="" class="form-control">
                           </div>
                           <div class="form-group form_custom"><!-- form_custom -->
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 custom_field">
                                        <input type="submit" name="notInterested" id="notInterested" onClick="return FormNotInterestedValidate();" value="Submit" class="btn btn-primary btn-sm">
                                        <button type="reset" name="reset" id="reset" class="btn btn-primary btn-sm">Reset</button>
                                        <button type="button" name="back" id="back" class="btn btn-primary btn-sm" onClick="window.location.href='telecalling_lead.php'">Back</button>
                                    </div>
                                </div>
                             </div>
                        </span>
                       
                    </div><!-- End row --> 
                  </div><!--End form_custom -->
                  <div class="clearfix"></div>
                  
        </form>
                </div>
              </div><!-- /.row -->
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
$('.date').datetimepicker({
	/*mask:'9999/19/39 29:59'*/
});
$('#follow_date').datetimepicker({
	/*mask:'9999/19/39 29:59'*/
});
</script>
</html>