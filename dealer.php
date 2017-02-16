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
$sql="update tbldealer set First_Name='$first_name',Last_Name='$last_name',Company_Name='$company_name', Phone='$contact', Mobile='$mobile_no',email='$email',  pan_no='$pan_no',tin_no='$tin_no', servicestax='$service_tax',others='$other',Address='$address', Country='$country',State='$state', City='$city',  Area='$area', Pin_code='$pin_code' where id=" .$_REQUEST['id'];
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
$query=mysql_query("insert into tbldealer set First_Name='$first_name',Last_Name='$last_name',Company_Name='$company_name', Phone='$contact', Mobile='$mobile_no',email='$email', pan_no='$pan_no',tin_no='$tin_no', servicestax='$service_tax',others='$other',Address='$address', Country='$country',State='$state', City='$city', Area='$area', Pin_code='$pin_code'");
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
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="assets/bootstrap/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="assets/bootstrap/css/ionicons.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="assets/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="assets/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<script  src="js/ajax.js"></script>
<!-- <script type="text/javascript" src="js/manage_dealer.js"></script> -->
<script>
$(function() {
  $( "#date_of_purchase" ).datepicker({dateFormat: 'yy-mm-dd'});
});
function callCity(state_id){ 
  url="ajaxrequest/getCity.php?state_id="+state_id+"&City=<?php echo $result['City'];?>&token=<?php echo $token;?>";
  //alert(url);
  xmlhttpPost(url,state_id,"getresponsecity");
  }
  
  function getresponsecity(str){
  //alert(str);
  document.getElementById('divcity').innerHTML=str;
  //document.getElementById('area1').
  document.getElementById("area1").innerHTML = "";
  document.getElementById("divpincode").innerHTML = "";
  }

function callArea(city){ 
  url="ajaxrequest/getarea.php?city="+city+"&area=<?php echo $result['Area'];?>&token=<?php echo $token;?>";
  //alert(url);
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
function chkcontactform(obj)
{
  if(obj.first_name.value =="")
  {
    alert("Please provide First Name");
    obj.first_name.focus();
    return false;
  }
  if (obj.last_name.value=="")
  {
    alert("Please provide Last Name");
    obj.last_name.focus();
    return false;
  }
  if (obj.company.value=="")
  {
    alert("Please provide Company Name");
    obj.company.focus();
    return false;
  }
  if (obj.contact_no.value=="")
  {
    alert("Please Enter Phone or Mobile no");
    obj.contact_no.focus();
    return false;
  }
  var phoneno = /(^\d{10}$)|(^\d{10}-\d{4}$)/;
  if(phoneno.test(obj.contact_no.value)== false)
  {
  alert("Please provide valid Contact No.");
  obj.contact_no.focus();
  return false;
  }
  if (obj.email.value=="")
  {
    alert("Please provide Email");
    obj.email.focus();
    return false;
  }
  var reg = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    if (reg.test(obj.email.value)== false) 
     {
          alert("Please provide valid Email");
          obj.email.focus();
          return false;
     }
  if(obj.pan_no.value=="")
  {
    alert("Please provide Pan No");
    obj.pan_no.focus();
    return false;
  }
  if(obj.tin_no.value== "")
  {
    alert("Please provide Vat Tin No");
    obj.tin_no.focus();
    return false;
  }
  if(obj.service_tax.value == "")
  {
    alert("Please provide Service Tax No.");
    obj.service_tax.focus();
    return false;
  }
  if(obj.other.value == "")
  {
    alert("Please provide CST No.");
    obj.other.focus();
    return false;
  }
  if(obj.address.value == "")
  {
    alert("Please provide Address");
    obj.address.focus();
    return false;
  }
  if(obj.country.value=="")
  {
    alert("Please Select Country");
    obj.country.focus();
    return false;
  }
  if(obj.state.value=="")
  {
    alert("Please Select State");
    obj.state.focus();
    return false;
  }
  if(obj.city.value=="")
  {
    alert("Please Select City");
    obj.city.focus();
    return false;
  }
  if(obj.area.value =="")
  {
    alert ("Please Select Area");
    obj.area.focus();
    return false;
  }
  
}
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once("includes/header.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dealer
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dealer</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <div class="box-header">
              <h3 class="box-title">Add</h3>
            </div>
            <div class="box-body">
            <?php if(isset($msgDanger) && $msgDanger !="") {?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msgDanger;?>
            </div>
            <?php 
            }
            ?>
              <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
                <input type="hidden" name="submitForm" value="yes" />
                <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                <div class="form-group form_custom col-md-12"><!-- form_custom -->
                  <div class="row"> <!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>First Name <i>*</i></span>
                      <input name="first_name" id="first_name"  class="form-control" value="<?php if(isset($result['id'])) echo $result['First_Name'];?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Last Name <i>*</i></span>
                      <input name="last_name" class="form-control" value="<?php if(isset($result['id'])) echo $result['Last_Name'];?>" id="last_name" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Company <i>*</i></span>
                      <input name="company" id="company" class="form-control" value="<?php if(isset($result['id'])) echo $result['Company_Name'];?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Phone <i>*</i></span>
                      <input name="contact_no" class="form-control" id="contact_no" value="<?php if(isset($result['id'])) echo $result['Phone'];?>"  type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Mobile <i>*</i></span>
                      <input name="mobile" id="mobile" class="form-control" value="<?php if(isset($result['id'])) echo $result['Mobile'];?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Email <i>*</i></span>
                      <input name="email"  id="email" class="form-control" value="<?php if(isset($result['id'])) echo $result['email'];?>"type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Pan No. <i>*</i></span>
                      <input name="pan_no" id="pan_no" value="<?php if(isset($result['id'])) echo $result['pan_no'];?>" class="form-control" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Tin No. <i>*</i></span>
                      <input name="tin_no" id="tin_no" class="form-control" value="<?php if(isset($result['id'])) echo $result['tin_no'];?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Service Tax <i>*</i></span>
                      <input name="service_tax" id="service_tax" class="form-control" value="<?php if(isset($result['id'])) echo $result['servicestax'];?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Other <i>*</i></span>
                      <input name="other" id="other" value="<?php if(isset($result['id'])) echo $result['others'];?>" class="form-control" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Address <i>*</i></span>
                      <textarea id="address" name="address" rows="2" class="form-control"><?php if(isset($result['id'])) echo $result['Address'];?></textarea>
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Country <i>*</i></span>
                      <select name="country" class="form-control drop_down select2" style="width: 100%" 
                        id="country">
                        <option value="">Select Country</option>
                        <?php $Country=mysql_query("select * from tblcountry");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['Country_name']; ?>" <?php if(isset($result['id']) && $resultCountry['Country_name']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?>            </option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_field -->
                    <div class="clearfix"></div>
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>State <i>*</i></span>
                      <select name="state"  class="form-control drop_down select2" style="width: 100%" 
                        id="state" onChange="return callCity(this.value)">
                        <option label="" value="" selected="selected">Select State</option>
                        <?php $Country=mysql_query("select * from tblstate order by State_name");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['State_name']; ?>" <?php if(isset($result['id']) && $resultCountry['State_name']==$result['State']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>City <i>*</i></span>
                      <span id="divcity">
                        <select name="city" id="city" class="form-control select2" style="width: 100%" 
                          onChange="return callArea(this.value)" >
                          <option label="" value="" selected="selected">Select City</option>
                          <?php $Country=mysql_query("select distinct city_name from tblcity order by city_name");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['city_name']; ?>" <?php if(isset($result['id']) && $resultCountry['city_name']==$result['City']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['city_name'])); ?></option>
                          <?php } ?>
                        </select>
                      </span>
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Area <i>*</i></span>
                      <span id="divarea">
                        <select name="area" id="area" class="form-control select2" style="width: 100%"  onChange="return callPincode(this.value)">
                          <option label="" value="" selected="selected">Area</option>
                          <?php $Country=mysql_query("select distinct Area from tblcity order by Area");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['Area']; ?>" <?php if(isset($result['id']) && $resultCountry['Area']==$result['Area']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Area'])); ?></option>
                          <?php } ?>
                        </select>
                      </span>
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Pincode <i>*</i></span>
                      <span id="divpincode">
                        <input name="pin_code" id="pin_code"  value="<?php if(isset($result['id'])) echo $result['Pin_code'];?>" class="form-control" type="text" />
                      </span>
                    </div> <!-- end custom_field -->
                    <div class="clearfix"></div>
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <input type="submit" class="btn btn-primary btn-sm" value="Submit" id="submit"  />
                      <input type="reset" id="reset" class="btn btn-primary btn-sm" value="Reset"/> 
                    </div> <!-- end custom_field -->
                  </div> <!-- end row -->
                </div> <!-- end form_custom -->
              </form>
            </div>
            <!-- /.box-body -->
          </div>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<?php include_once("includes/footer.php") ?>
</div><!-- ./wrapper -->
<script src="js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>
</body>
</html>