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
if(isset($_REQUEST['device_company']))
{
$device_company=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['device_company'])));
$device_model=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['device_name'])));
$dateofpurchase=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['date_of_purchase'])));
$dealername=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['dealer_name'])));
$imei_no=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['imei_no'])));
$price=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['price'])));
session_start();
$_SESSION['dealer_name'] = $device_company;
$_SESSION['devicecompany'] = $device_company;
$_SESSION['devicemodel'] = $device_model;
if(count($_POST['linkassc'])>0)
{
for($i=0; $i<count($_POST['linkassc']); $i++)
{
$accessories.=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['linkassc'][$i]))).",";
}
$accessories=substr($accessories,0,strlen($accessories)-1);
}
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tbl_device_master set company_id='$device_company', device_name='$device_model', imei_no='$imei_no', date_of_purchase='$dateofpurchase', dealer_id='$dealername', price='$price',accessories_id='$accessories' where id=".$_REQUEST['id'];
/*echo $sql;*/
mysql_query($sql);
$_SESSION['sess_msg']='Model updated successfully';
header("location:manage_model.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tbl_device_master where imei_no='$imei_no'");
 if(mysql_num_rows($queryArr)<=0)
{
$query ="insert into tbl_device_master set company_id='$device_company', device_name='$device_model', imei_no='$imei_no', date_of_purchase='$dateofpurchase', dealer_id='$dealername', price='$price',accessories_id='$accessories'";
/*echo $query;*/
$result =  mysql_query($query);
$id = "Device Id :".mysql_insert_id();
}
else
{
$msg="IMEI No. already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tbl_device_master where id =".$_REQUEST['id']);
$result=mysql_fetch_assoc($queryArr);
echo 'afsa'.$result['dealer_id'];
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
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script type="text/javascript" src="js/manage_import_device.js"></script>

<script>
 $(function() {
    $( "#date_of_purchase" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
</script>
<script type="text/javascript">

function check()
{
	dealer_name = document.getElementById("dealer_name").value;
	device_company = document.getElementById("device_company").value;
	device_name = document.getElementById("device_name").value; 
 	date_of_purchase = document.getElementById("date_of_purchase").value;
	price = document.getElementById("price").value;
	linkassc = document.getElementById("linkassc").value;

	jQuery.cookie("dealer_name",dealer_name);
	jQuery.cookie("device_company",device_company);
	jQuery.cookie("device_name",device_name);
	jQuery.cookie("date_of_purchase",date_of_purchase);
	jQuery.cookie("price",price);
	jQuery.cookie("linkassc",linkassc);
	
	
	//alert(jQuery.cookie("dealer_name"));
}

function checkDefault(){
	if ( !(typeof $.cookie('dealer_name') === 'undefined') ) {
	
		document.getElementById("dealer_name").value =jQuery.cookie("dealer_name") ;
		document.getElementById("device_company").value = jQuery.cookie("device_company");
		document.getElementById("device_name").value= jQuery.cookie("device_name"); 
		document.getElementById("date_of_purchase").value =jQuery.cookie("date_of_purchase") ;
		document.getElementById("price").value = jQuery.cookie("price");
		document.getElementById("linkassc").value= jQuery.cookie("linkassc"); 
	}
}

function deleteCok(){
	jQuery.removeCookie("dealer_name") ;
	jQuery.removeCookie("device_company");
	jQuery.removeCookie("device_name");
	jQuery.removeCookie("date_of_purchase") ;
	jQuery.removeCookie("price");
	jQuery.removeCookie("linkassc");
	alert("Values Removed");

}

</script>
</head>
<body onLoad="checkDefault()">
<!--open of the wraper-->
<div id="wraper">
	<!--include header-->
    <?php include_once('includes/header.php');?>
    <!--end-->
    <!--open of the content-->
<div class="row" id="content">
	<div class="col-md-12">
    	<h1>Import Device</h1>
        <hr>
    </div>
    <div class="col-md-12">
    	<div class="col-md-3">
        </div>
        <div class="col-md-6">
        <form name='myform' action="" method="post" onSubmit="return validate(this)">
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <input type="hidden" name="device_id" id="device_id" value="<?php $query = mysql_query("select device_id from tbldeviceid")?>"/>
        <div class="table table-responsive">
    	<table border="0">
        
        <tr >
        <td><strong>Import Device</strong></td>
        <td><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?> 
            <?php if(isset($id) && $id !="") echo '<script type="text/javascript">alert("' . $id . '");</script>'; ?></td>
        </tr>
        <tr >
        <td>Dealer Company Name*</td>
        <td><select name="dealer_name" id="dealer_name" class="form-control drop_down">
            <option value="">Select Dealer</option>
            <?php $Country=mysql_query("select * from tbldealer");
					while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['dealer_id']) && $resultCountry['id']==$result['dealer_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Company_Name'] )); ?></option>
            <?php } ?>
          	</select></td>
		</tr>
        <tr >
        <td>Device Company*</td>
        <td><select name="device_company" id="device_company" class="form-control drop_down">
            <option value="">Select Company</option>
            
            <?php $Country=mysql_query("select * from tbldevicecompany");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
       <!--     <option value="<?php if(isset($_SESSION['devicecompany'])){ echo $resultCountry['id'];}?>" <?php if(isset($result['company_id']) && $resultCountry['id']==$result['company_id']){ ?>selected<?php } ?>><?php if (isset($_SESSION['devicecompany'])){echo stripslashes(ucfirst($resultCountry['name']));}?></option>-->
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['company_id']) && $resultCountry['id']==$result['company_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['name'])); ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr >
        <td>Device Model*</td>
        <td><select name="device_name" id="device_name" class="form-control drop_down">
            <option value="">Select Model</option>
            <?php $Country=mysql_query("select * from tbldevicemodel");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($result['device_name']) && $resultCountry['device_id']==$result['device_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
      <?php } ?>
      </select></td>
       </tr>
       <tr >
       <td> Date of Purchase*</td>
       <td><input type="text" name="date_of_purchase" id="date_of_purchase" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['date_of_purchase'];?>" /></td>
       </tr>
       <tr >
       <td> Price*</td>
       <td align="left"><input type="text" name="price" id="price" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['price'];?>" />     </td>
       </tr>
       <tr >
       <td valign="top">Accessrories*</td>
       <td align="left">
	   <?php $accessories=mysql_query("select * from tblaccessories");
		     while($aces=mysql_fetch_assoc($accessories)){
		?>
        <input type="checkbox" name="linkassc[]" id="linkassc" value="<?php echo $aces['name']; ?>" <?php if(isset($result['id']) && strpos($result['accessories_id'],$aces['name'])) { ?>checked <?php } ?>/> <?php echo $aces['name']; ?> <br  />
		<?php } ?></td>
      </tr>
      <tr >
      <td> IMEI No.*</td>
      <td><input type="text" name="imei_no" id="imei_no" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['imei_no'];?>" /></td>
      </tr>
      <tr>
      <td></td>
      <td><input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit" onClick="check();"/>
        <input type='reset' name='reset' class="open btn btn-primary btn-sm" value="Reset"  onClick="deleteCok();"/>        
        <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
		  onclick="window.location='manage_model.php?token=<?php echo $token ?>'; deleteCok();"/></td>
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
<script src="js/bootstrap.min.js"></script>
</body>
</html>