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
if(isset($_REQUEST['provider']))
{
$provider=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['provider'])));
$sim=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['sim'])));
$mobile=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['mobile'])));
$plan=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan'])));
$date_of_purchase=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['date'])));
$state_name=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['state_id'])));
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tblsim set company_id='$provider', sim_no='$sim', mobile_no='$mobile', plan_categoryid='$plan', date_of_purchase='$date_of_purchase', state_id='$state_name' where id=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='Sim updated successfully';
header("location:manage_sim.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tblsim where company_id='$provider' and sim_no='$sim' and mobile_no='$mobile' and plan_categoryid='$plan' and date_of_purchase='$date_of_purchase'");
//$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tblsim set company_id='$provider', sim_no='$sim', mobile_no='$mobile', plan_categoryid='$plan', date_of_purchase='$date_of_purchase'");
$_SESSION['sess_msg']='Sim added successfully';
header("location:manage_sim.php?token=".$token);
exit();
}
else
{
$msg="City already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblsim where id =".$_REQUEST['id']);
$result=mysql_fetch_assoc($queryArr);
$datasource=$result['City'];
$state_name=$result['City'];
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

<script type="text/javascript" src="js/manage_import_device.js"></script>
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
    	<h1>Uppdate Sim</h1>
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
        <tr >
        <td colspan="2"><?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?> </td>
        </tr>
        <tr >
        <td>Provider*</td>
        <td><select name="provider" id="provider" class="form-control drop_down">
            <option value="">Select Provider</option>
            	<?php $Country=mysql_query("select * from tblserviceprovider");
					  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['company_id']) && $resultCountry['id']==$result['company_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?></option>
              <?php } ?>
            </select></td>
		</tr>
        <tr >
        <td>Sim*</td>
        <td><input name="sim" id="sim" class="form-control text_box" type="text" value="<?php if(isset($result['id'])) echo $result['sim_no'];?>" /></td>
        </tr>
        <tr >
        <td>Mobile*</td>
        <td><input type="text" name="mobile" class="form-control text_box" id="mobile" value="<?php if(isset($result['id'])) echo $result['mobile_no'];?>" /></td>
       </tr>
       <tr >
       <td> Plan*</td>
       <td><select name="plan" id="plan" class="form-control drop_down">
           <option value="">Select Plan</option>
           <?php $Country=mysql_query("select * from tblplan");
				  while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['plan_categoryid']) && $resultCountry['id']==$result['plan_categoryid']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
            <?php } ?>
            </select>
       </td>
       </tr>
       <tr >
       <td>Date of Purchase*</td>
       <td><input name="date" id="date" class="form-control drop_down" value="<?php if(isset($result['id'])) echo $result['date_of_purchase'];?>" type="text" /></td>
       </tr>
      <tr >
      <td>State*</td>
      <td><select name="state_id" id="state_id" class="form-control drop_down">
          <option value="">Select State</option>
          <?php $Country=mysql_query("select * from tblstate");
		        while($resultCountry=mysql_fetch_assoc($Country)){
		  ?>
          <option value="<?php echo $resultCountry['State_id']; ?>" <?php if(isset($result['state_id']) && $resultCountry['State_id']==$result['state_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
          <?php } ?>
          </select>
      </td>
      </tr>
      <tr>
      <td></td>
      <td><input type='submit' name='submit' class="btn btn-primary" value="Submit"/>
          <input type='reset' name='reset' class="btn btn-primary" value="Reset"/>                        
          <input type='button' name='cancel' class="btn btn-primary" value="Back" onclick="window.location='manage_sim.php?token=<?php echo $token ?>'"/></td>
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