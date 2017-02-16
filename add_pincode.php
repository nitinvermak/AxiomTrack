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
<script type="text/javascript" src="js/add_pincode.js"></script>
<script>
$(function() {
  $( "#date_of_purchase" ).datepicker({dateFormat: 'yy-mm-dd'});
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
        Pincode
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pincode</li>
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
              <div class="small-form">
                <form name='myform' action="" method="post" onSubmit="return validate(this)">
                  <input type="hidden" name="submitForm" value="yes" />
                  <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                  <!-- Color Picker -->
                  <div class="form-group">
                    <label>Country<i>*</i></label>
                    <select name="country" id="country" class="form-control select2" style="width: 100%" 
                    onChange="return CallState(this.value)">
                      <option value="">Select Country</option>
                      <?php $Country=mysql_query("select * from tblcountry");             
                            while($resultCountry=mysql_fetch_assoc($Country)){
                      ?>
                      <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['id']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?></option>
                      <?php } ?>
                    </select>
                  </div><!-- /.form group -->
                  <div class="form-group">
                    <label>State<i>*</i></label>
                    <span id="Divstate">
                      <select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control select2" style="width: 100%">
                        <option value="">Select State</option>
                      </select>
                    </span>
                  </div><!-- /.form group -->
                  <div class="form-group">
                    <label>District<i>*</i></label>
                    <span id="divdistrict">
                      <select name="district" id="district"  class="form-control select2" style="width: 100%"
                       onChange="return CallCity(this.value)">
                        <option value="">Select District</option>
                      </select>
                    </span>
                  </div><!-- /.form group -->
                  <div class="form-group">
                    <label>City<i>*</i></label>
                    <span id="divcity">
                      <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control select2" style="width: 100%" >
                        <option value="">Select City</option>
                      </select>
                    </span>
                  </div><!-- /.form group -->
                  <div class="form-group">
                    <label>Area<i>*</i></label>
                    <span id="divarea">
                      <select name="area" id="area" onChange="return CallPincode(this.value)" 
                      class="form-control select2" style="width: 100%">
                        <option value="">Select Area</option>
                        <option value="<?php echo $result['Area_id']; ?>" <?php if(isset($result['Area_id']) && $result['Area_id']==$result['Area_id']){ ?>selected<?php } ?>><?php echo getarea(stripslashes(ucfirst($result['Area_id']))); ?></option>
                      </select>
                    </span>
                  </div><!-- /.form group -->
                  <div class="form-group">
                    <label>Pincode<i>*</i></label>
                    <input name="pincode" id="pincode" type="text" class="form-control" value="<?php if(isset($result['pincode_id'])) echo $result['Pincode']; ?>"/>
                  </div><!-- /.form group -->
                  <div class="form-group">
                    <input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
                    <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
                    <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_pincode.php?token=<?php echo $token ?>'"/>
                  </div> <!-- form-group -->
                </form>
              </div>
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