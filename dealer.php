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
if(isset($_REQUEST['first_name']))
{
$first_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['first_name']));
$last_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['last_name']));
$company_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['company']));
$contact=htmlspecialchars(mysql_real_escape_string($_REQUEST['contact_no']));
$mobile_no=htmlspecialchars(mysql_real_escape_string($_REQUEST['mobile']));
$email=htmlspecialchars(mysql_real_escape_string($_REQUEST['email']));
$pan_no=htmlspecialchars(mysql_real_escape_string($_REQUEST['pan_no']));
$tin_no=htmlspecialchars(mysql_real_escape_string($_REQUEST['tin_no']));
$service_tax=htmlspecialchars(mysql_real_escape_string($_REQUEST['service_tax']));
$other=htmlspecialchars(mysql_real_escape_string($_REQUEST['other']));
$address=htmlspecialchars(mysql_real_escape_string($_REQUEST['address']));
$country=htmlspecialchars(mysql_real_escape_string($_REQUEST['country']));
$state=htmlspecialchars(mysql_real_escape_string($_REQUEST['state']));
$city=htmlspecialchars(mysql_real_escape_string($_REQUEST['city']));
$area=htmlspecialchars(mysql_real_escape_string($_REQUEST['area']));
$pin_code=htmlspecialchars(mysql_real_escape_string($_REQUEST['pin_code']));
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tbldealer set First_Name='$first_name',Last_Name='$last_name',Company_Name='$company_name', Phone='$contact', Mobile='$mobile_no',email='$email',	pan_no='$pan_no',tin_no='$tin_no', servicestax='$service_tax',others='$other',Address='$address', Country='$country',State='$state', City='$city', 	Area='$area', Pin_code='$pin_code' where id=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='Dealer updated successfully';
header("location:manage_dealer.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tbldealer where  First_Name='$first_name'and Last_Name='$last_name' and Company_Name='$company_name' and Phone='$contact' and Mobile='$mobile_no' and email='$email' and pan_no='$pan_no' and tin_no='$tin_no' and servicestax='$service_tax' and others='$other' and Address='$address' and Country='$country' and State='$state' and City='$city' and Area='$area' and Pin_code='$pin_code'");
//$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tbldealer set First_Name='$first_name',Last_Name='$last_name',Company_Name='$company_name', Phone='$contact', Mobile='$mobile_no',email='$email',	pan_no='$pan_no',tin_no='$tin_no', servicestax='$service_tax',others='$other',Address='$address', Country='$country',State='$state', City='$city', Area='$area', Pin_code='$pin_code'");
$_SESSION['sess_msg']='Dealer added successfully';
header("location:manage_dealer.php?token=".$token);
exit();
}
else
{
$msg="Dealer already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tbldealer where id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/manage_dealer.js"></script>
    <script language="javascript">
function singlecontact() {
    document.getElementById("contactform").style.display = "";
	document.getElementById("contactUpload").style.display = "none";
	
}

function multiplecontact() {
//alert("test");
   document.getElementById("contactform").style.display = "none";
	document.getElementById("contactUpload").style.display = "";
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
    	<h1>Dealer</h1>
        <hr>
    </div>
    <div class="col-md-12">
        <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        	 <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">First&nbsp;Name</label>
                <div class="col-sm-10">
                 <input name="first_name" id="first_name"  class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['First_Name'];?>" type="text" />
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Last&nbsp;Name</label>
                <div class="col-sm-10">
                  <input name="last_name" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['Last_Name'];?>" id="last_name" type="text" />
                </div>
            </div>              
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Company*</label>
                <div class="col-sm-10">
                 <input name="company" id="company" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['Company_Name'];?>" type="text" />
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Phone*</label>
                <div class="col-sm-10">
                  <input name="contact_no" class="form-control text_box" id="contact_no" value="<?php if(isset($result['id'])) echo $result['Phone'];?>"  type="text" />
                </div>
            </div>              
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Mobile*</label>
                <div class="col-sm-10">
                 <input name="mobile" id="mobile" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['Mobile'];?>" type="text" />
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Email*</label>
                <div class="col-sm-10">
                 <input name="email"  id="email" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['email'];?>"type="text" />
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Pan&nbsp;No.*</label>
                <div class="col-sm-10">
                 <input name="pan_no" id="pan_no" value="<?php if(isset($result['id'])) echo $result['pan_no'];?>" class="form-control text_box" type="text" />
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Tin&nbsp;No.*</label>
                <div class="col-sm-10">
                <input name="tin_no" id="tin_no" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['tin_no'];?>" type="text" />
                </div>
            </div>              
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Service&nbsp;Tax*</label>
                <div class="col-sm-10">
               <input name="service_tax" id="service_tax" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['servicestax'];?>" type="text" />
                </div>
            </div>              
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Other</label>
                <div class="col-sm-10">
               <input name="other" id="other" value="<?php if(isset($result['id'])) echo $result['others'];?>" class="form-control text_box" type="text" />
                </div>
            </div>              
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Address*</label>
                <div class="col-sm-10">
               <textarea id="address" name="address" rows="3" class="form-control txt_area"><?php if(isset($result['id'])) echo $result['Address'];?></textarea>
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Country*</label>
                <div class="col-sm-10">
               		<select name="country" class="form-control drop_down" id="country">
            		<option value="">Select Country</option>
					<?php $Country=mysql_query("select * from tblcountry");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['Country_name']; ?>" <?php if(isset($result['id']) && $resultCountry['Country_name']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?>            </option>
                    <?php } ?>
                   </select>
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">State*</label>
                <div class="col-sm-10">
               		<select name="state"  class="form-control drop_down"  id="state" onChange="return callCity(this.value)">
                    <option label="" value="" selected="selected">Select State</option>
                    <?php $Country=mysql_query("select * from tblstate order by State_name");
                            while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['State_name']; ?>" <?php if(isset($result['id']) && $resultCountry['State_name']==$result['State']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>              
        </div>
        <div class="clearfix"></div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">City*</label>
                <div class="col-sm-10" id="divcity">
               		<select name="city" id="city" class="form-control drop_down"  onChange="return callArea(this.value)" >
                    <option label="" value="" selected="selected">Select City</option>
                    <?php $Country=mysql_query("select distinct city_name from tblcity order by city_name");
                                  while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['city_name']; ?>" <?php if(isset($result['id']) && $resultCountry['city_name']==$result['City']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['city_name'])); ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Area*</label>
                <div class="col-sm-10" id="divarea">
               		 <select name="area" id="area" class="form-control drop_down"  onChange="return callPincode(this.value)">
                    <option label="" value="" selected="selected">Area</option>
                    <?php $Country=mysql_query("select distinct Area from tblcity order by Area");
                                              
                                              while($resultCountry=mysql_fetch_assoc($Country)){
                                              ?>
                      <option value="<?php echo $resultCountry['Area']; ?>" <?php if(isset($result['id']) && $resultCountry['Area']==$result['Area']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Area'])); ?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Area*</label>
                <div class="col-sm-10" id="divpincode">
               		 <input name="pin_code" id="pin_code"  value="<?php if(isset($result['id'])) echo $result['Pin_code'];?>" class="form-control text_box" type="text" />
                </div>
            </div>              
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 form">
        <input type="submit" class="btn btn-primary" value="Submit" id="submit"  />
        <input type="reset" id="reset" class="btn btn-primary" value="Reset"/> 
		</div>
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