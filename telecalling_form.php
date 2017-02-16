<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
include("includes/simpleimage.php");
session_set_cookie_params(3600,"/");
session_start();
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ){
    session_destroy();
    header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']==''){
    session_destroy();
    header("location: index.php?token=".$token);
}
$error =0;
if(isset($_POST['submit'])){
        /*Update Calling Data*/
        $update_id = mysql_real_escape_string($_POST['cid']);
        $first_name = mysql_real_escape_string($_POST['first_name']);
        $last_name = mysql_real_escape_string($_POST['last_name']);
        $company = mysql_real_escape_string($_POST['company']);
        $phone = mysql_real_escape_string($_POST['phone']);
        $mobile = mysql_real_escape_string($_POST['mobile']);
        $email = mysql_real_escape_string($_POST['email']);
        $Address = mysql_real_escape_string($_POST['Address']);
        $area = mysql_real_escape_string($_POST['area']);
        $city = mysql_real_escape_string($_POST['city']);
        $state = mysql_real_escape_string($_POST['state']);
        $district = mysql_real_escape_string($_POST['district']);
        $country = mysql_real_escape_string($_POST['country']);
        $pincode = mysql_real_escape_string($_POST['pin_code']);
        $calling_status = '1';
        $update_records = "Update tblcallingdata set First_Name='$first_name', Last_Name='$last_name', Company_Name='$company', Phone='$phone', Mobile='$mobile', email='$email', Address='$Address', Area='$area', City='$city', State='$state', District_id='$district', Country='$country', Pin_code='$pincode', calling_status='$calling_status' where id='$update_id'";
        /*echo $update_records;*/
        $query = mysql_query($update_records);
        /*End Calling Data Update*/
        
        /*Insert Calling Status */
        $calling_status = $_POST['rdopt'];
        $update_id = mysql_real_escape_string($_POST['cid']);
        $callingdate = mysql_real_escape_string($_POST['callingdate']);
        $model = mysql_real_escape_string($_POST['model']);
        $no_of_vehicles = mysql_real_escape_string($_POST['no_of_vehicles']);
        $p_device_amt = mysql_real_escape_string($_POST['p_device_amt']);
        $p_device_rent = mysql_real_escape_string($_POST['p_device_rent']);
        $payment_type = mysql_real_escape_string($_POST['payment_type']);
        $installation_charges = mysql_real_escape_string($_POST['installation_charges']);
        $follow_date = mysql_real_escape_string($_POST['follow_date']);
        $reason = mysql_real_escape_string($_POST['reason']);
        $remarks = mysql_real_escape_string($_POST['remarks']);
        $customer_type = mysql_real_escape_string($_POST['customer_type']);
        $downpayment = mysql_real_escape_string($_POST['downpayment']);
        $telecaller = mysql_real_escape_string($_POST['telecaller']);
        if($calling_status == "1")
        {
        $insert_calling_status = "insert into tbl_telecalling_status set callingdata_id='$update_id', calling_date='$callingdate', device_model_id='$model', calling_status='$calling_status', no_of_vehicles='$no_of_vehicles', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', follow_up_date='$follow_date', not_interested_resason='$reason', remark_not_interested='$remarks', customer_type = '$customer_type', downpaymentAmount = '$downpayment', telecaller_id = '$telecaller'";
        header("location:telecalling.php?token=".$token);
        $query = mysql_query($insert_calling_status);
        }
        else if($calling_status == "0")
        {
        $insert_calling_status = "insert into tbl_telecalling_status set callingdata_id='$update_id', device_model_id='$model', calling_status='$calling_status', no_of_vehicles='$no_of_vehicles', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', follow_up_date='$follow_date', not_interested_resason='$reason', remark_not_interested='$remarks' customer_type = '$customer_type', downpaymentAmount = '$downpayment', telecaller_id = '$telecaller'";
        header("location:telecalling.php?token=".$token);
        $query = mysql_query($insert_calling_status);
        }
        
        /* end */
    }
if(isset($_REQUEST['id']) && $_REQUEST['id'])
    {
    $queryArr=mysql_query("SELECT * FROM tblcallingdata WHERE id =".$_REQUEST['id']);
    $result=mysql_fetch_assoc($queryArr);
    
    }
    
    //Confirm Client record store
    if(isset($_POST['submit1']))
        {
            $update_id = mysql_real_escape_string($_POST['cid']);
            $first_name = mysql_real_escape_string($_POST['first_name']);
            $last_name = mysql_real_escape_string($_POST['last_name']);
            $company = mysql_real_escape_string($_POST['company']);
            $phone = mysql_real_escape_string($_POST['phone']);
            $mobile = mysql_real_escape_string($_POST['mobile']);
            $email = mysql_real_escape_string($_POST['email']);
            $Address = mysql_real_escape_string($_POST['Address']);
            $area = mysql_real_escape_string($_POST['area']);
            $city = mysql_real_escape_string($_POST['city']);
            $state = mysql_real_escape_string($_POST['state']);
            $country = mysql_real_escape_string($_POST['country']);
            $pincode = mysql_real_escape_string($_POST['pin_code']);
            $district = mysql_real_escape_string($_POST['district']);
            $telecaller = mysql_real_escape_string($_POST['telecaller']);
            $calling_products = mysql_real_escape_string($_POST['calling_products']);
            $model = mysql_real_escape_string($_POST['model']);
            $p_device_amt = mysql_real_escape_string($_POST['p_device_amt']);
            $p_device_rent = mysql_real_escape_string($_POST['p_device_rent']);
            $payment_type = mysql_real_escape_string($_POST['payment_type']);
            $customer_type = mysql_real_escape_string($_POST['customer_type']);
            $downpayment = mysql_real_escape_string($_POST['downpayment']);
            $installation_charges = mysql_real_escape_string($_POST['installation_charges']);
            $confirm_client = "insert into tbl_customer_master set  callingdata_id='$update_id',  calling_product='$calling_products', device_model_id='$model', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', customer_type='$customer_type', telecaller_id='$telecaller',  confirmation_date=Now() ";
            $result = mysql_query($confirm_client);
            echo "cnfrm".$confirm_client;
            $change_status = "UPDATE tblcallingdata SET First_Name='$first_name', Last_Name='$last_name', Company_Name='$company', Address='$Address', Area='$area', City='$city', District_id='$district', State='$state', Pin_code='$pincode', Country='$country', Phone='$phone', Mobile='$mobile', email='$email', status ='1', calling_status='1' where id = '$update_id'";
            $query = mysql_query($change_status);
            //Save calling status
            $insert_calling_status = "insert into tbl_telecalling_status set callingdata_id='$update_id', calling_date='$callingdate', device_model_id='$model', calling_status='$calling_status', no_of_vehicles='$no_of_vehicles', np_device_amt='$p_device_amt', np_device_rent='$p_device_rent', rent_payment_mode='$payment_type', r_installation_charge='$installation_charges', follow_up_date='$follow_date', not_interested_resason='$reason', remark_not_interested='$remarks', customer_type = '$customer_type', downpaymentAmount = '$downpayment', telecaller_id = '$telecaller'";
            header("location:telecalling.php?token=".$token);
            $query = mysql_query($insert_calling_status);
            //end Save
            /*echo $change_status;*/
            echo "<script>alert('Client Confirm Successfully !');</script>";
            header("location:telecalling.php?token=".$token);
        }
    //End Confirm Client 
    
if(isset($_GET['id']))
{
 $id = $_GET['id'];
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
<script type="text/javascript" src="js/telecallingFormValidate.js"></script>
<script  src="js/ajax.js"></script>
<script src="js/combo_box.js"></script>
<script>
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});  
});
function IfInterested() {
    document.getElementById("ifinterested").style.display = "";
    document.getElementById("nointerested").style.display = "none";
    
}

function NotInterested() {
    //alert("test");
    document.getElementById("ifinterested").style.display = "none";
    document.getElementById("nointerested").style.display = "";
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
        Telecalling Form
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Telecalling Form</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Details</h3>
            </div>
            <div class="box-body">
                <?php if(isset($msg)){?>
                <div class="alert alert-success alert-dismissible small-alert" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $msg; ?>
                </div>
                <?php 
                }
                ?>
                <form name="contact" method="post" onSubmit="return chkcontactform(this)">
                    <input type="hidden" name="submitForm" value="yes" />
                    <input type='hidden' name='cid' id='cid'   value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                    <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                        <div class="row"><!-- row -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>First Name <i class="red">*</i></span>
                                <input name="first_name" id="first_name" value="<?php if(isset($result['id'])) 
                                echo $result['First_Name']; ?>" class="form-control" type="text" />
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Last Name <i class="red">*</i></span>
                                <input name="last_name" id="last_name" value="<?php if(isset($result['id'])) echo $result['Last_Name']; ?>" class="form-control" type="text" />
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Company Name <i class="red">*</i></span>
                                <input name="company" id="company" value="<?php if(isset($result['id'])) {echo $result['Company_Name'];$_SESSION['organization'] = $result['id'];} ?>"  class="form-control" type="text" />
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Phone <i class="red">*</i></span>
                                <input name="phone" id="phone" value="<?php if(isset($result['id'])) echo $result['Phone']; ?>" class="form-control" type="text" />
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Mobile <i class="red">*</i></span>
                                <input name="mobile" id="mobile" value="<?php if(isset($result['id'])) echo $result['Mobile']; ?>" class="form-control" type="text" />
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Email <i class="red">*</i></span>
                                <input name="email" id="email" value="<?php if(isset($result['id'])) echo $result['email']; ?>" class="form-control" type="text" />
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Other Contact Details <i class="red">*</i></span>
                                <input name="area2" id="area2" value="" class="form-control" type="text" />
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Country <i class="red">*</i></span>
                                <select name="country" id="country" class="form-control select2" onChange="return CallState(this.value)" style="width: 100%">
                                    <option value="">Select Country</option>
                                    <?php $Country=mysql_query("select * from tblcountry");
                                                   while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['Country']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?></option>
                                    <?php } ?>
                                </select>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>State <i class="red">*</i></span>
                                <span id="Divstate">
                                    <select name="state" class="form-control select2" onChange="return CallDistrict(this.value)" style="width: 100%">
                                      <option value="<?php echo $result['State']; ?>" <?php if(isset($result['id']) && $result['State']==$result['State']){ ?>selected<?php } ?>><?php echo getcity(stripslashes(ucfirst($result['State']))); ?></option>
                                    </select>
                                </span>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>District <i class="red">*</i></span>
                                <span id="divdistrict">
                                    <select name="district" class="form-control select2" style="width: 100%" onChange="return CallCity(this.value)">
                                        <option value="">Select District</option>
                                        <option value="<?php echo $result['District_id']; ?>" <?php if(isset($result['id']) && $result['District_id']==$result['District_id']){ ?>selected<?php } ?>><?php echo getdistrict(stripslashes(ucfirst($result['District_id']))); ?></option>
                                    </select>
                                </span>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>City <i class="red">*</i></span>
                                <span id="divcity">
                                    <select name="city" onChange="return CallArea(this.value)" class="form-control select2" style="width: 100%" >
                                        <option value="">Select City</option>
                                        <option value="<?php echo $result['City']; ?>" <?php if(isset($result['id']) && $result['City']==$result['City']){ ?>selected<?php } ?>><?php echo getcityname(stripslashes(ucfirst($result['City']))); ?></option>
                                    </select>
                                </span>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Area <i class="red">*</i></span>
                                <span id="divarea">
                                    <select name="area" onChange="return CallPincode(this.value)" class="form-control select2" style="width: 100%">
                                        <option value="">Select Area</option>
                                        <option value="<?php echo $result['Area']; ?>" <?php if(isset($result['id']) && $result['Area']==$result['Area']){ ?>selected<?php } ?>><?php echo getarea(stripslashes(ucfirst($result['Area']))); ?></option>
                                    </select>
                                </span>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Pincode <i class="red">*</i></span>
                                <span id="divpincode">
                                <input name="pin_code" id="pin_code" class="form-control"  value="<?php if(isset($result['id'])) echo getpincode($result['Pin_code']); ?>" type="text" />
                                </span>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Address <i class="red">*</i></span>
                                <textarea id="Address" class="form-control" name="Address" rows="2" ><?php if(isset($result['id'])) echo $result['Address']; ?></textarea>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Telecaller Name <i class="red">*</i></span>
                                <select name="telecaller" id="telecaller" class="form-control select2" style="width: 100%" >
                                    <?php $Country=mysql_query("SELECT * FROM tblcallingdata as A, tblassign as B 
                                                                WHERE A.id = B.callingdata_id 
                                                                and B.callingdata_id ='$id'");
                                          while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['telecaller_id']; ?>" <?php if(isset($datasource) && $resultCountry['telecaller_id']==$datasource){ ?>selected<?php } ?>><?php echo gettelecallername(stripslashes(ucfirst($resultCountry['telecaller_id']))); ?></option>
                                    <?php } ?>
                                </select> 
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Data Source <i class="red">*</i></span>
                                <input type="text" name="datasource" id="datasource" class="form-control"  value="<?php if(isset($result['id'])) echo $result['data_source']; ?>" /> 
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Calling Product <i class="red">*</i></span>
                                <select name="calling_products" id="calling_products" class="form-control select2" style="width: 100%">
                                    <?php $Country=mysql_query("select distinct(callingcategory_id) from tblassign 
                                                                where callingdata_id='$id'");
                                          $_SESSION['product'] = $_GET['cat'];
                                          while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['callingcategory_id'];  ?>" 
                                    <?php if($resultCountry['callingcategory_id']== $_GET['cat'] ){ ?>selected<?php } ?>> <?php echo getproducts(stripslashes(ucfirst($resultCountry['callingcategory_id']))); ?></option>
                                    <?php } ?>
                                </select> 
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Calling Date <i class="red">*</i></span>
                                <input name="callingdate" id="callingdate" class="form-control date" type="text" value="<?php if(isset($result['id'])) echo $result['calling_date']; ?>" />
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Model <i class="red">*</i></span>
                                <select name="model" id="model" class="form-control select2" style="width: 100%">
                                    <option value="">Select</option>
                                    <?php $Country=mysql_query("select * from tbldevicemodel");
                                          while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($result['device_model_id']) && $resultCountry['device_id']==$result['device_model_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                                    <?php } ?>
                                </select>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Customer Type <i class="red">*</i></span><br>
                                <select name="customer_type" id="customer_type" class="form-control select2" onChange="customerType()" style="width: 100%">
                                  <option value="">Select</option>
                                  <?php $Country=mysql_query("select * from tbl_customer_type");
                                              while($resultCountry=mysql_fetch_assoc($Country)){
                                        ?>
                                  <option value="<?php echo $resultCountry['customer_type_id']; ?>" <?php if(isset($result['customer_type_id']) && $resultCountry['customer_type_id']==$result['customer_type_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['customer_type'])); ?></option>
                                  <?php } ?>
                                </select>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Device Amt <i class="red">*</i></span><br>
                                <select name="p_device_amt" id="p_device_amt" class="form-control select2" style="width: 100%">
                                  <option value="">Select</option>
                                  <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 1");
                                          while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                  <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_amt']) && $resultCountry['id']==$result['np_device_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                                  <?php } ?>
                                </select>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Rental <i class="red">*</i></span><br>
                                <select name="p_device_rent" id="p_device_rent" class="form-control select2" style="width: 100%">
                                    <option value="">Select</option>
                                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4   
                                                                and plan_description='Rental'");
                                          while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_rent']) && $resultCountry['id']==$result['np_device_rent']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                                    <?php } ?>
                                </select>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Installation Charges <i class="red">*</i></span><br>
                                <select name="installation_charges" id="installation_charges" class="form-control select2" style="width: 100%">
                                    <option value="">Select</option>
                                    <?php $Country=mysql_query("select * from tblplan 
                                                                where productCategoryId = 4 
                                                                and plan_description='Installtion_Charges'");
                                          while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['r_installation_charge']) && $resultCountry['id']==$result['r_installation_charge']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                                    <?php } ?>
                                </select>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Rent Payment Type <i class="red">*</i></span><br>
                                <select name="payment_type" id="payment_type" class="form-control select2" style="width: 100%">
                                    <option value="">Payment Type</option>
                                    <?php $Country=mysql_query("select * from tbl_frequency");                      
                                                   while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($result['FrqId']) && $resultCountry['FrqId']==$result['FrqId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
                                    <?php } ?>
                                </select>
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Installment Amt. <i class="red">*</i></span><br>
                                <input type="text" name="downpayment" value="<?php if(isset($result['id'])) echo $result['downpaymentAmount']; ?>" id="downpayment" class="form-control">
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Follow Up Date (If Any)<i class="red">*</i></span><br>
                                <input type="text" name="follow_date" class="form-control date" id="follow_date" value="<?php if(isset($result['id'])) echo $result['follow_up_date']; ?>" />
                            </div> <!-- end custom_field -->
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <span>Reason<i class="red">*</i></span><br>
                                <select name="reason" id="reason" class="form-control select2" style="width: 100%">
                                    <option value="">Select </option>
                                    <option value="Already Using Some Another Company GPS">Already Using Some Another Company GPS</option>
                                    <option value="Rate Issue">Rate Issue</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div> <!-- end custom_field -->
                            <div class="clearfix"></div>
                            <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                                <input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
                                <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>    
                                <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
                                onclick="window.location='telecalling.php?token=<?php echo $token ?>'"/>
                                <input type='submit' name='submit1' id="submit1" class="btn btn-primary btn-sm" value="Confirm Client" />
                                <input type='button' name='gen_ticket' class="btn btn-primary btn-sm" value="Generate Ticket" onClick="showModalPopUp()"/>
                            </div><!-- end custom_field -->
                        </div>
                    </div> <!-- end custom form -->
                </form>
            </div>
            <!-- /.box-body -->
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