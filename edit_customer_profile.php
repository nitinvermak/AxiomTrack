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
<script language="javascript" src="js/manage_contacts.js"></script>
<!--Ajax request Call-->
<script  src="js/ajax.js"></script>
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
<script>
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
    //Initialize Select2 Elements
});
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
<body class="hold-transition skin-blue sidebar-mini" onLoad="checkDefault()">
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once("includes/header.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Contact
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Contact</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info">
          <div class="box-header">
            <!-- <h3 class="box-title">Import</h3> -->
          </div>
          
          <div class="box-body">
          <?php if(isset($msgdanger)){
          ?>
            <div class="alert alert-danger alert-dismissible small-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msgdanger; ?>
            </div>
          <?php  
          }
          ?>
            <div class="col-md-12" id="contactform">
              <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
                <input type="hidden" name="submitForm" value="yes" />
                <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                <div class="form-group form_custom col-md-12"><!-- form_custom -->
                  <div class="row"> <!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>First Name <i>*</i></span>
                      <input name="first_name" id="first_name" placeholder="First Name*" class="form-control" type="text" value="<?php if(isset($result['id'])) echo $result['First_Name']; ?>" />
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Last Name <i>*</i></span>
                      <input name="last_name" id="last_name" class="form-control" value="<?php if(isset($result['id'])) echo $result['Last_Name']; ?>" Placeholder = "Last Name*" type="text" />
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Company <i>*</i></span>
                      <input name="company" id="company" class="form-control" value="<?php if(isset($result['id'])) echo $result['Company_Name']; ?>" Placeholder="Company Name*" type="text" />
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Phone <i>*</i></span>
                      <input name="phone" id="phone" class="form-control" value="<?php if(isset($result['id'])) echo $result['Phone']; ?>" Placeholder="Phone*" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Mobile <i>*</i></span>
                      <input name="mobile" id="mobile" class="form-control" value="<?php if(isset($result['id'])) echo $result['Mobile']; ?>" Placeholder="Mobile*" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Email <i>*</i></span>
                      <input name="email" id="email" class="form-control" value="<?php if(isset($result['id'])) echo $result['email']; ?>" placeholder="Email*" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Address <i>*</i></span>
                      <textarea name="address" id="address" cols="6" class="form-control"><?php if(isset($result['id'])) echo $result['Address']; ?></textarea>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Country <i>*</i></span>
                      <select name="country" id="country" class="form-control drop_down select2" style="width: 100%" onChange="return CallState(this.value)">
                        <option value="">Select Country</option>
                        <?php $Country=mysql_query("select * from tblcountry");             
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['id']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="clearfix"></div>
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>State <i>*</i></span>
                      <span id="Divstate">
                        <select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control drop_down select2" style="width: 100%">
                          <option value="">Select State</option>
                          <option value="<?php echo $result['State']; ?>" <?php if(isset($result['id']) && $result['State']==$result['State']){ ?>selected<?php } ?>><?php echo getcity(stripslashes(ucfirst($result['State']))); ?></option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>District <i>*</i></span>
                      <span id="divdistrict">
                        <select name="district" id="district"  class="form-control drop_down select2" style="width: 100%" onChange="return CallCity(this.value)">
                          <option value="">Select District</option>
                          <option value="<?php echo $result['District_id']; ?>" <?php if(isset($result['id']) && $result['District_id']==$result['District_id']){ ?>selected<?php } ?>><?php echo getdistrict(stripslashes(ucfirst($result['District_id']))); ?></option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>City <i>*</i></span>
                      <span id="divcity">
                        <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control drop_down select2" style="width: 100%" >
                          <option value="">Select City</option>
                          <option value="<?php echo $result['City']; ?>" <?php if(isset($result['id']) && $result['City']==$result['City']){ ?>selected<?php } ?>><?php echo getcityname(stripslashes(ucfirst($result['City']))); ?></option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Area <i>*</i></span>
                      <span id="divarea">
                        <select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control drop_down select2" style="width: 100%">
                          <option value="">Select Area</option>
                          <option value="<?php echo $result['Area']; ?>" <?php if(isset($result['id']) && $result['Area']==$result['Area']){ ?>selected<?php } ?>><?php echo getarea(stripslashes(ucfirst($result['Area']))); ?></option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Pincode <i>*</i></span>
                      <span id="divpincode">
                        <select name="pin_code" id="pin_code" class="form-control drop_down select2" style="width: 100%">
                          <option value="">Select Pincode</option>
                          <option value="<?php echo $result['Pin_code']; ?>" <?php if(isset($result['id']) && $result['Pin_code']==$result['Pin_code']){ ?>selected<?php } ?>><?php echo getpincode(stripslashes(ucfirst($result['Pin_code']))); ?></option>
                        </select>                        
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Datasource <i>*</i></span>
                      <input name="datasource" id="datasource" class="form-control" value="<?php if(isset($result['id'])) echo $result['data_source']; ?>" placeholder="Datasource*" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="clearfix"></div>
                    <div class="col-lg-6 col-sm-6 custom_field">
                      <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm" id="submit"  />
                      <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='customer_profile.php?token=<?php echo $token ?>'" />
                    </div>
                  </div> <!-- end row -->
                </div> <!-- end form_custom -->
              </form>
            </div> <!-- end contacform -->
          </div><!-- /.box-body -->
      </div>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<!-- Loader -->
<div class="loader">
    <img src="images/loader.gif" alt="loader">
</div>
<!-- End Loader -->
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