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
if(isset($_POST['submit']))
	{
		$first_name = mysql_real_escape_string($_POST['first_name']);
		$last_name = mysql_real_escape_string($_POST['last_name']);
		$company = mysql_real_escape_string($_POST['company']);
		$phone = mysql_real_escape_string($_POST['phone']);
		$mobile = mysql_real_escape_string($_POST['mobile']);
		$email = mysql_real_escape_string($_POST['email']);
		$address = mysql_real_escape_string($_POST['address']);
		$country = mysql_real_escape_string($_POST['country']);
		$state = mysql_real_escape_string($_POST['state']);
		$district = mysql_real_escape_string($_POST['district']);
		$city = mysql_real_escape_string($_POST['city']);
		$area = mysql_real_escape_string($_POST['area']);
		$pin_code = mysql_real_escape_string($_POST['pin_code']);
		$datasource = mysql_real_escape_string($_POST['datasource']);
		$Update = "UPDATE tblcallingdata SET First_Name = '$first_name', 
				   Last_Name = '$last_name', Company_Name = '$company', 
				   Phone = '$phone', Mobile = '$mobile', email = '$email', 
				   Address = '$address', Country = '$country', State = '$state', 
				   District_id = '$district', City = '$city', Area = '$area', 
				   Pin_code = '$pin_code', data_source = '$datasource' 
				   WHERE id =".$_REQUEST['id'];
		$result = mysql_query($Update);
		$_SESSION['sess_msg']='Contacts updated successfully';
		header("location:customer_profile.php?token=".$token);
		exit();
	}
	if(isset($_REQUEST['id']) && $_REQUEST['id'])
	{
		$queryArr=mysql_query("select * from tblcallingdata where id =".$_REQUEST['id']);
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
<script language="javascript" src="js/manage_contacts.js"></script>
<!--Ajax request Call-->
<script  src="js/ajax.js"></script>
<script>
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
    	<h1>Update Contact</h1>
        <hr>
    </div>
    <div class="col-md-12">
   
    <div class="col-md-12" id="contactform"> <!--open of the single form-->
    <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">First&nbsp;Name</label>
                <div class="col-sm-10">
                  <input name="first_name" id="first_name" placeholder="First Name*" class="form-control text_box" type="text" value="<?php if(isset($result['id'])) echo $result['First_Name']; ?>" />
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Last&nbsp;Name</label>
                <div class="col-sm-10">
                  <input name="last_name" id="last_name" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['Last_Name']; ?>" Placeholder = "Last Name*" type="text" />
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Company*</label>
                <div class="col-sm-10">
                  <input name="company" id="company" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['Company_Name']; ?>" Placeholder="Company Name*" type="text" />
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Phone*</label>
                <div class="col-sm-10">
                  <input name="phone" id="phone" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['Phone']; ?>" Placeholder="Phone*" type="text" />
                </div>
            </div>              
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Mobile*</label>
                <div class="col-sm-10">
                  <input name="mobile" id="mobile" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['Mobile']; ?>" Placeholder="Mobile*" type="text" />
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Email*</label>
                <div class="col-sm-10">
                 	<input name="email" id="email" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['email']; ?>" placeholder="Email*" type="text" />
                </div>
            </div>              
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Address*</label>
                <div class="col-sm-10">
                  <textarea name="address" id="address" cols="6" class="form-control txt_area"><?php if(isset($result['id'])) echo $result['Address']; ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Country*</label>
                <div class="col-sm-10">
                 	<select name="country" id="country" class="form-control drop_down" onChange="return CallState(this.value)">
                    <option value="">Select Country</option>
                    <?php $Country=mysql_query("select * from tblcountry");						  
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['id']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?>            </option>
                    <?php } ?>
                  </select>
                </div>
            </div>              
        </div>
        <div class="clearfix"></div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">State*</label>
                <div class="col-sm-10" id="Divstate">
                    <select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control drop_down">
                      <option value="">Select State</option>
                        <option value="<?php echo $result['State']; ?>" <?php if(isset($result['id']) && $result['State']==$result['State']){ ?>selected<?php } ?>><?php echo getcity(stripslashes(ucfirst($result['State']))); ?></option>
                    </select>
                </div>
            </div>
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">District*</label>
                <div class="col-sm-10" id="divdistrict">
                  <select name="district" id="district"  class="form-control drop_down" onChange="return CallCity(this.value)">
                    <option value="">Select District</option>
                    <option value="<?php echo $result['District_id']; ?>" <?php if(isset($result['id']) && $result['District_id']==$result['District_id']){ ?>selected<?php } ?>><?php echo getdistrict(stripslashes(ucfirst($result['District_id']))); ?></option>
                  </select>
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">City*</label>
                <div class="col-sm-10" id="divcity">
                 	<select name="city" id="city" onChange="return CallArea(this.value)" class="form-control drop_down" >
                        <option value="">Select City</option>
                        <option value="<?php echo $result['City']; ?>" <?php if(isset($result['id']) && $result['City']==$result['City']){ ?>selected<?php } ?>><?php echo getcityname(stripslashes(ucfirst($result['City']))); ?></option>
                    </select>
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Area*</label>
                <div class="col-sm-10" id="divarea">
                 	<select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control drop_down">
                        <option value="">Select Area</option>
                         <option value="<?php echo $result['Area']; ?>" <?php if(isset($result['id']) && $result['Area']==$result['Area']){ ?>selected<?php } ?>><?php echo getarea(stripslashes(ucfirst($result['Area']))); ?></option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Pincode*</label>
                <div class="col-sm-10" id="divpincode">                    
                    <select name="pin_code" id="pin_code" class="form-control drop_down">
                        <option value="">Select Pincode</option>
                         <option value="<?php echo $result['Pin_code']; ?>" <?php if(isset($result['id']) && $result['Pin_code']==$result['Pin_code']){ ?>selected<?php } ?>><?php echo getpincode(stripslashes(ucfirst($result['Pin_code']))); ?></option>
                    </select>
                </div>
            </div>              
        </div>
        
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Datasource*</label>
                <div class="col-sm-10">
                  <input name="datasource" id="datasource" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['data_source']; ?>" placeholder="Email*" type="text" />
                </div>
            </div>
            
        </div>
        <div class="col-md-6 form">
          <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm" id="submit"  />
                  <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='customer_profile.php?token=<?php echo $token ?>'" />
                </div>
  			</div> 
        </div>
      
        
        </form>
    </div> 
    <!--end single sim  form--> 
    
    <div id="contactUpload"  style="display:none;" class="col-md-12"> <!--open of the multiple sim form-->
    <form name="contact1" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return chkupload(this)">
    	<div class="col-md-6">
         	<div class="form-group">
                <label for="Datasource" class="col-sm-2 control-label">Datasource</label>
                <div class="col-sm-10">
                  <select name="datasource1" id="datasource1" class="form-control drop_down">
            	  <option label="" value="" selected="selected">Data Source</option>
                  <?php $Country1=mysql_query("select * from tbldatasource");				  
						while($resultCountry1=mysql_fetch_assoc($Country1)){
				  ?>
                  <option value="<?php echo $resultCountry1['datasource']; ?>" <?php if(isset($datasource) && $resultCountry1['datasource']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry1['datasource'])); ?></option>
                  <?php } ?>
          		 </select>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
         <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Upload</label>
                <div class="col-sm-10">
                  <input type="file" id="contactfile" name="contactfile"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" value="Submit" id="submit" class="btn btn-primary" />
                  <input type="button" value="Download Format" name="download" class="btn btn-primary" onClick="window.location='Samples/Contacts_Import_format.xls'" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary" onClick="window.location='managecontacts.php?token=<?php echo $token ?>'" />
                </div>
  			</div> 
        </div>	
       </form>
    </div> <!--end multiple sim-->
	
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