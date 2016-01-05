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

$error =0;

//Select table from database
if(isset($_REQUEST['id']) && $_REQUEST['id'])
	{
	$queryArr=mysql_query("SELECT * FROM tblcallingdata as A 
						   Inner Join tbl_customer_master as B On A.id = B.callingdata_id 
						   WHERE A.Company_Name =".$_REQUEST['id']);
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
    	<h1>Customer Type</h1><br>
        <hr>
    </div>  
    <div class="clearfix"></div>      
    <div class="col-md-12 table table-responsive" id="contactform"> <!--open of the single form-->
   	  <form name="contact" method="post" onSubmit="return chkcontactform(this)">
         <input type="hidden" name="submitForm" value="yes" />
         <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <table class="table">
         
        
        
        
        
        
        
        
        
        <tr>
        <td>Telecaller Name*</td>
        <td  valign="top" width="37%">
        <select name="telecaller" id="telecaller" class="form-control text_box" disabled>
        	<?php $Country=mysql_query("select * from tbluser");
                  while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['telecaller_id']){ ?>selected<?php } ?>><?php echo gettelecallername(stripslashes(ucfirst($resultCountry['id']))); ?></option>
            <?php } ?>    
        </select>
           <!-- <input type="text" name="datasource" id="datasource" class="form-control text_box"  value="<?php if(isset($result['id'])) echo $result['telecaller_id']; ?>" />-->        </td>
        <td>Data Source*</td>
        <td><input type="text" name="datasource" id="datasource" class="form-control text_box"  value="<?php if(isset($result['id'])) echo $result['data_source']; ?>" disabled />        </td>
        </tr>
        <tr>
          <td>Device Amt.*</td>
          <td  valign="top">
          	<select name="deviceAmt" id="deviceAmt" class="form-control drop_down" disabled>
                    <option value="">Device Amount</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 1 order by plan_rate");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                  	  <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_amt']) && $resultCountry['id']==$result['np_device_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                <?php } ?>
         	</select>          </td>
          <td>Rent Amt.</td>
          <td>
          		<select name="deviceRent" id="deviceRent" class="form-control drop_down" disabled >
                    <option value="">Device Rent</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 2 order by plan_rate");						
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_rent']) && $resultCountry['id']==$result['np_device_rent']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
    			</select>        </td>
        </tr>
        <tr>
          <td>Installation Charges</td>
          <td  valign="top">
          	<select name="installationChrg" id="installationChrg" class="form-control drop_down" disabled >
                   <option value="">Installation Charges</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 3 order by plan_rate");
					
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['r_installation_charge']) && $resultCountry['id']==$result['r_installation_charge']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
        	</select>          </td>
          <td>Rent Frq.</td>
          <td>
          	<select name="rentFrq" id="rentFrq" class="form-control drop_down" disabled >
                    <option value="">Rent Frequency</option>
                    <?php $Country=mysql_query("select * from tbl_frequency");						
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($result['rent_payment_mode']) && $resultCountry['FrqId']==$result['rent_payment_mode']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
                    <?php } ?>
            </select>          </td>
        </tr>
        <tr>
        <td>Customer Type</td>
        <td  valign="top">
          <select name="customerType" id="customerType" class="form-control drop_down" onChange="customerType()" disabled>
          <option value="">Select</option>
          <?php $Country=mysql_query("select * from tbl_customer_type");
                      while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
          <option value="<?php echo $resultCountry['customer_type_id']; ?>" <?php if(isset($result['customer_type']) && $resultCountry['customer_type_id']==$result['customer_type']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['customer_type'])); ?></option>
          <?php } ?>
    	  </select>        </td>
        <td>Calling Date*</td>
        <td><input name="callingdate" id="callingdate" class="form-control text_box" type="text" value="<?php if(isset($result['id'])) echo $result['confirmation_date']; ?>" disabled /></td>
        </tr>
        <tr>
          <td><input type="button" class="btn btn-primary btn-sm" value="Back" onClick="window.location='customer_type.php?token=<?php echo $token ?>'" ></td>
          <td  valign="top"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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