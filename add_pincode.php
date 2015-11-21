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
if(isset($_REQUEST['area']))
{
	$area = mysql_real_escape_string($_POST['area']);
	$pincode = mysql_real_escape_string($_POST['pincode']);
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
	$sql="update tbl_pincode set Area_id = '$area', Pincode='$pincode' where pincode_id=" .$_REQUEST['id'];
	// Call User Activity Log function
	UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
	// End Activity Log Function
	mysql_query($sql);
	$_SESSION['sess_msg']='Pincode updated successfully';
	header("location:manage_pincode.php?token=".$token);
	exit();
}
else{
	$query=mysql_query("insert into tbl_pincode set Area_id = '$area', Pincode='$pincode'");
	// Call User Activity Log function
	UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $query);
	// End Activity Log Function
	$_SESSION['sess_msg']='Pincode added successfully';
	header("location:manage_pincode.php?token=".$token);
	exit();
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tbl_pincode where pincode_id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/add_pincode.js"></script>
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
    	<h1>Pincode</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	<div class="col-md-3">
        </div>
        <div class="col-md-6">
        <form name='myform' action="" method="post" onSubmit="return validate(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="table table-responsive">
    	<table border="0">
        <tr>
        <td colspan="2"><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?></td>
        </tr>
        
        <tr>
          <td>Country*</td>
          <td><select name="country" id="country" class="form-control drop_down" onChange="return CallState(this.value)">
                    <option value="">Select Country</option>
                    <?php $Country=mysql_query("select * from tblcountry");						  
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['id']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?>            </option>
                    <?php } ?>
                  </select></td>
        </tr>
        <tr>
          <td>State*</td>
          <td><div id="Divstate">
          		<select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control drop_down">
                      <option value="">Select State</option>
                   </select>
          </div></td>
        </tr>
        <tr>
          <td>District*</td>
          <td>
          <div id="divdistrict">
          <select name="district" id="district"  class="form-control drop_down" onChange="return CallCity(this.value)">
                <option value="">Select District</option>
          </select>
          </div>
         </td>
        </tr>
        <tr>
          <td>City*</td>
          <td>
          <div id="divcity">
          	 <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control drop_down" >
                        <option value="">Select City</option>
              </select>
          </div>
          </td>
        </tr>
        <tr>
        <td>Area*</td>
        <td>
        <div id="divarea">
        	<select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control drop_down">
                        <option value="">Select Area</option>
                         <option value="<?php echo $result['Area_id']; ?>" <?php if(isset($result['Area_id']) && $result['Area_id']==$result['Area_id']){ ?>selected<?php } ?>><?php echo getarea(stripslashes(ucfirst($result['Area_id']))); ?></option>
            </select>
        </div>
        </td>
        </tr>
        
        <tr>
        <td>Pincode*</td>
        <td><input name="pincode" id="pincode" type="text" class="form-control text_box" value="<?php if(isset($result['pincode_id'])) echo $result['Pincode']; ?>"/></td>
        </tr>
        
        <tr>
        <td>&nbsp;</td>
        <td><input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
        <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
        <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_pincode.php?token=<?php echo $token ?>'"/></td>
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