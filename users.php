<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

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
	$userid=$_SESSION['user_id'];
	if(isset($_REQUEST['empId']))
		{
			$emp_id=htmlspecialchars(mysql_real_escape_string($_REQUEST['empId']));
			$first_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['first_name']));
			$last_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['last_name']));
			$emp_dob=htmlspecialchars(mysql_real_escape_string($_REQUEST['dob']));
			$contact=htmlspecialchars(mysql_real_escape_string($_REQUEST['contact_no']));
			$email_id=htmlspecialchars(mysql_real_escape_string($_REQUEST['email']));
			$date_of_j=htmlspecialchars(mysql_real_escape_string($_REQUEST['doj']));
			$address=htmlspecialchars(mysql_real_escape_string($_REQUEST['address']));
			$country=htmlspecialchars(mysql_real_escape_string($_REQUEST['country']));
			$state=htmlspecialchars(mysql_real_escape_string($_REQUEST['state']));
			$city=htmlspecialchars(mysql_real_escape_string($_REQUEST['city']));
			$area=htmlspecialchars(mysql_real_escape_string($_REQUEST['area']));
			$pincode=htmlspecialchars(mysql_real_escape_string($_REQUEST['pin_code']));
			$user_type=htmlspecialchars(mysql_real_escape_string($_REQUEST['user_type']));
			$branch=htmlspecialchars(mysql_real_escape_string($_REQUEST['branch_id']));
			$user_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['user_name']));
			$password=htmlspecialchars(mysql_real_escape_string($_REQUEST['Password']));
		}
	if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes')
		{
			if(isset($_REQUEST['cid']) && $_REQUEST['cid']!='')
			{
				$update_record ="Update tbluser set emp_id='$emp_id',First_Name='$first_name',Last_Name='$last_name', DOB=STR_TO_DATE('$emp_dob', '%m/%d/%Y'), Contact_No='$contact',emailid='$email_id',DOJ=STR_TO_DATE('$date_of_j', '%m/%d/%Y'),Address='$address',country='$country',State='$state',City='$city', Area='$area',Pin_code='$pincode', User_Category='$user_type', branch_id='$branch', User_ID='$user_name', Password='$password',User_Status='A',Created_date=CURDATE(),CreatedBY='$userid' where id=".$_REQUEST['id'];
				$sqlquery=mysql_query($update_record);		
				echo "<script> alert('User Updated Successfully!'); </script>";
				header("location: manage_users.php?token=".$token);
			}
			else
			{
				$queryArr=mysql_query("select * from tbluser where User_ID='$user_name'");
				//$result=mysql_fetch_assoc($queryArr);
				if(mysql_num_rows($queryArr)<=0)
				{
					$sql="insert into tbluser set emp_id='$emp_id',First_Name='$first_name',Last_Name='$last_name', DOB=STR_TO_DATE('$emp_dob', '%m/%d/%Y'), Contact_No='$contact',emailid='$email_id',DOJ=STR_TO_DATE('$date_of_j', '%m/%d/%Y'),Address='$address',country='$country',State='$state',City='$city', Area='$area',Pin_code='$pincode', User_Category='$user_type', branch_id='$branch', User_ID='$user_name', Password='$password',User_Status='A',Created_date=CURDATE(),CreatedBY='$userid'";
					/*echo $sql;*/
					$query=mysql_query($sql);		
					echo "<script> alert('User Created Successfully!'); </script>";
					header("location: manage_users.php?token=".$token);
					exit();
				}
				else
				{
					$msg="User already exists";
				}
	
			}
		}

if(isset($_REQUEST['id']) && $_REQUEST['id'])
	{
		$queryArr=mysql_query("select * from tbluser where id =".$_REQUEST['id']);
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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/Nibbler.js"></script>
<script  src="js/ajax.js"></script>
<script src="js/manage_users.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" language="javascript">
// Date 
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
// End Date
// JavaScript Document
function callCity(state_id){ 
	url="ajaxrequest/getCity.php?state_id="+state_id+"&City=<?php echo $result['City'];?>&token=<?php echo $token;?>";
	//alert(url);
	xmlhttpPost(url,state_id,"getresponsecity");
	}
	function getresponsecity(str){
	/*alert(str);*/
	document.getElementById('divcity').innerHTML=str;
	//document.getElementById('area1').
	document.getElementById("area1").innerHTML = "";
	document.getElementById("divpincode").innerHTML = "";
	}

function callArea(city){ 
	url="ajaxrequest/getarea.php?city="+city+"&area=<?php echo $result['Area'];?>&token=<?php echo $token;?>";
	/*alert(url);*/
	xmlhttpPost(url,city,"getresponsearea");
	}
	
	function getresponsearea(str){
	//alert(str);
	document.getElementById('divarea').innerHTML=str;
	document.getElementById("divpincode").innerHTML = "";

	}

function callPincode(area){ 
	url="ajaxrequest/getpincode.php?area="+area+"&city="+document.getElementById('city').value+"&pincode=<?php echo $result['Pin_code'];?>&token=<?php echo $token;?>";
	//alert(url);
	xmlhttpPost(url,area,"getresponsepincode");
	}
	
	function getresponsepincode(str){
	//alert(str);
	document.getElementById('divpincode').innerHTML=str;
	}
	
	function hidediv(usercat)
	{
	//alert(usercat);
	if(usercat=="1")
	{
	document.getElementById('notadmin').style.display="none";
	}
	else
	{
	document.getElementById('notadmin').style.display="";
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
    	<h1>Users</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	<form name='myform' action="" method="post" onSubmit="return chkcontactform(this)">
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="table table-responsive">
    	<table border="0" cellpadding="0" cellspacing="1">
        <tr>
        <td>Employee ID*</td>
        <td><input name="empId" id="empId" class="form-control text_box" type="text" value="<?php if(isset($result['id'])) echo $result['emp_id'];?>" /></td>
        <td>Date Of Joining*</td>
        <td><input name="doj" id="doj" class="form-control text_box date" value="<?php if(isset($result['id'])) echo $result['DOJ'];?>" tabindex="0"  type="text" /></td>
        </tr>
        <tr>
        <td>First Name*</td>
        <td><input name="first_name" id="first_name" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['First_Name'];?>" type="text" /></td>
        <td>Last Name*</td>
        <td><input name="last_name" id="last_name" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['Last_Name'];?>" /></td>
        </tr>
        <tr>
        <td>Date of Birth*</td>
        <td><input name="dob" id="dob" size="25" class="form-control text_box date" value="<?php if(isset($result['id'])) echo $result['DOB'];?>" type="text" /></td>
        <td>Contact No</td>
        <td><input name="contact_no" id="contact_no" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['Contact_No'];?>" type="text" /></td>
        </tr>
        <tr>
        <td>Email*</td>
        <td><input name="email" id="email" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['emailid'];?>" type="text" />          </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Country*</td>
          <td><select name="country" id="country" class="form-control drop_down">
            <option value="">Select Country</option>
            <?php $Country=mysql_query("select * from tblcountry");
                                                  
                                                  while($resultCountry=mysql_fetch_assoc($Country)){
                                                  ?>
            <option value="<?php echo $resultCountry['Country_name']; ?>" <?php if(isset($Country_name) && $resultCountry['Country_name']==$country){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?> </option>
            <?php } ?>
          </select></td>
          <td>State*</td>
          <td><select name="state" id="state" class="form-control drop_down" onChange="return callCity(this.value)">
            <option label="" value="" selected="selected">Select State</option>
            <?php $Country=mysql_query("select * from tblstate order by State_name");
			 while($resultCountry=mysql_fetch_assoc($Country)){
									  ?>
            <option value="<?php echo $resultCountry['State_name']; ?>" <?php if(isset($State_name) && $resultCountry['State_name']==$State){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
        <td rowspan="3" valign="top">Address</td>
        <td rowspan="3" valign="top"><textarea id="address" name="address" class="txt_area form-control" ><?php if(isset($result['id'])) echo $result['Address'];?></textarea></td>
        <td>District*</td>
        <td valign="top"><div id="divcity">
            <select name="city" id="city" onChange="return callArea(this.value)" class="form-control drop_down" >
              <option label="" value="" selected="selected">Select City</option>
              <?php $Country=mysql_query("select distinct city_name from tblcity order by city_name");
									  while($resultCountry=mysql_fetch_assoc($Country)){
			  ?>
              <option value="<?php echo $resultCountry['city_name']; ?>" <?php if(isset($city_name) && $resultCountry['city_name']==$City){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['city_name'])); ?></option>
              <?php } ?>
            </select>
          </div>   </td>
        </tr>
        <tr>
        <td>Area</td>
        <td><div id="divarea">
          <select name="area" id="area" class="form-control drop_down" onChange="return callPincode(this.value)">
            <option label="" value="" selected="selected">Select Area</option>
            <?php $Country=mysql_query("select distinct Area from tblcity order by Area");
							  while($resultCountry=mysql_fetch_assoc($Country)){
									  ?>
            <option value="<?php echo $resultCountry['Area']; ?>" <?php if(isset($Area) && $resultCountry['Area']==$Area){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Area'])); ?></option>
            <?php } ?>
          </select>
        </div></td>
        </tr>
        <tr>
        <td>Pin Code</td>
        <td valign="top"><div id="divpincode">
          <input name="pin_code" id="pin_code"  value="<?php if(isset($result['id'])) echo $result['Pin_code'];?>" tabindex="0" class="form-control text_box" type="text" />
        </div>          </td>
        </tr>
       
       <tr>
       <td valign="top">User Type</td>
       <td valign="top"><select name="user_type" class="form-control drop_down" id="user_type" onChange="hidediv(this.value)">
            <option label="" value="" selected="selected">Select User </option>
            <?php $Country=mysql_query("select * from tblusercategory");
									  while($resultCountry=mysql_fetch_assoc($Country)){
									  ?>
                              <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($id) && $resultCountry['id']==$User_Category){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['User_Category'])); ?></option>
                              <?php } ?>
          </select></td>
          <td>Branch</span></td>
          <td>
          <div id="notadmin">
          <select name="branch_id" id="branch_id" class="form-control drop_down">
            <option label="" value="" selected="selected">Select Branch</option>
            <?php $Country=mysql_query("select * from tblbranch");
									  
									  while($resultCountry=mysql_fetch_assoc($Country)){
									  ?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($id) && $resultCountry['id']==$branch_id){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
          </select>
          </div>          </td>
          </tr>
          <tr height="40px">
          <td valign="top">User Name</td>
          <td valign="top"><input name="user_name" id="user_name" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['User_ID'];?>"type="text" /></td>
          <td>Password</td>
          <td><input name="Password" id="Password" value="<?php if(isset($result['id'])) echo $result['Password'];?>" tabindex="0" class="form-control text_box" type="password" /></td>
          </tr>
          <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="2"><input type="reset" id="reset" class="btn btn-primary"  value="Reset"/> <input type="submit" value="Submit" id="submit"  class="btn btn-primary" /> <input type='button' name='cancel' class="btn btn-primary" value="Back" onClick="window.location.replace('manage_users.php?token=<?php echo $token ?>')"/></td>
          <td valign="top">&nbsp;</td>
        </tr>
    </table>
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
<script src="js/bootstrap.min.js"></script>
</body>
</html>