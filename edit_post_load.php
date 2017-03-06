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
$error =0;
if (isset($_POST['submit'])) {
  $load_from = mysql_real_escape_string($_POST['load_from']);
  $load_to = mysql_real_escape_string($_POST['load_to']);
  $load_available = mysql_real_escape_string($_POST['load_available']);
  $load_goods_weight = mysql_real_escape_string($_POST['load_goods_weight']);
  $load_exprate = mysql_real_escape_string($_POST['load_exprate']);
  $load_comments = mysql_real_escape_string($_POST['load_comments']);
  $load_req_truck_type = mysql_real_escape_string($_POST['load_req_truck_type']);
  $load_truck_capacity = mysql_real_escape_string($_POST['load_truck_capacity']);
  $load_payment_terms = mysql_real_escape_string($_POST['load_payment_terms']);
  $load_type = mysql_real_escape_string($_POST['load_type']);

  $sql_load = "Update `post_load` SET  `loadFrom`='$load_from', 
              `loadTo`='$load_to', `loadAvailable`='$load_available', `loadGoodsWeight`='$load_goods_weight', 
              `loadexprate`='$load_exprate', `loadcoments`='$load_comments', 
              `loadreqtrucktype`='$load_req_truck_type', `load_capacity`='$load_truck_capacity', 
              `loadpaymentterms`='$load_payment_terms', `loadtype`='$load_type' 
              WHERE `pl_id`=".$_GET['id'];
  // echo $sql_load;
  // exit();

  $result2= mysql_query($sql_load);

  if($result2){
    $msg = "Load Post Update Successfully";
  }
}
$sql = mysql_query("SELECT * FROM `post_load` WHERE `pl_id`=".$_GET['id']);
$row = mysql_fetch_assoc($sql);
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
  $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
});
function callYes(){
  document.getElementById('dv_user').style.display = 'none';
  document.getElementById('dvUserId').style.display = '';
}
function callNo(){
  document.getElementById('dv_user').style.display = '';
  document.getElementById('dvUserId').style.display = 'none';
}
function checkMobileNo(){
  // alert('sadfas');
  // $('.loader').show();
  $.post("ajaxrequest/check_mobile_no.php?token=<?php echo $token;?>",
  {
    mobile : $('#mobile').val()
  },
  function( data){
    /*alert(data);*/
    $("#dvShow").html(data);
    // $(".loader").removeAttr("disabled");
    // $('.loader').fadeOut(1000);
  });  
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
        Post Load
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Post Load</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <!-- <div class="box-header">
              <h3 class="box-title">Add</h3>
            </div> -->
            <div class="box-body">
            <?php if(isset($msg) && $msg !="") {?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msg;?>
            </div>
            <?php 
            }
            ?>
              <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
                <div class="form-group form_custom col-md-12"><!-- form_custom -->
                  <div class="row"> <!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Load From <i>*</i></span>
                      <input name="load_from" id="load_from"  class="form-control" 
                      value="<?= $row['loadFrom'] ?>" type="text" placeholder="From Location" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Load To <i>*</i></span>
                      <input name="load_to" class="form-control" id="load_to" 
                      value="<?= $row['loadTo'] ?>" type="text" placeholder="To Location" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Load Available <i>*</i></span>
                      <input name="load_available" id="load_available" class="form-control date" 
                      value="<?= $row['loadAvailable'] ?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Load Goods Weight <i>*</i></span>
                      <input name="load_goods_weight" class="form-control" 
                      value="<?= $row['loadGoodsWeight'] ?>" id="load_goods_weight">
                    </div>
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Load Exprate <i>*</i></span>
                      <input name="load_exprate" id="load_exprate" class="form-control" 
                      value="<?= $row['loadexprate'] ?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Load Coments <i>*</i></span>
                      <input name="load_comments"  id="load_comments" class="form-control" 
                      value="<?= $row['loadcoments'] ?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Load Req. Truck Type <i>*</i></span>
                      <select name="load_req_truck_type" class="form-control" id="load_req_truck_type">
                        <option value="">--Select--</option>
                        <option value="Tempo">Tempo</option>
                        <option value="Trucks (Taurus)">Trucks (Taurus)</option>
                        <option value="Fixed Container">Fixed Container</option>
                        <option value="Trailer">Trailer</option>
                        <option value="Refrigerated">Refrigerated</option>
                        <?php if($row['loadreqtrucktype'] != ""){
                          echo "<option value='".$row['loadreqtrucktype']."' selected='selected'>".$row['loadreqtrucktype']."</option>";
                        }
                        ?>
                      </select>
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Truck Capacity<i>*</i></span>
                      <select name="load_truck_capacity" class="form-control" id="load_truck_capacity">
                        <option value="">--Select--</option>
                        <option value="20 Feet 08 Ton 20X7.5X8">20 Feet 08 Ton 20X7.5X8</option>
                        <option value="20 Feet 14 Ton 20X7.5X8">20 Feet 14 Ton 20X7.5X8</option>
                        <option value="24 Feet 14 Ton 24X8X8">24 Feet 14 Ton 24X8X8</option>
                        <option value="32 Feet 13 Ton 32X8X8">32 Feet 13 Ton 32X8X8</option>
                        <option value="32 Feet 19 Ton 32X8X8">32 Feet 19 Ton 32X8X8</option>
                        <?php if($row['load_capacity'] != ""){
                          echo "<option value='".$row['load_capacity']."' selected='selected'>".$row['load_capacity']."</option>";
                        }
                        ?>
                      </select>
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Load Payment Terms <i>*</i></span>
                      <input name="load_payment_terms" id="load_payment_terms" class="form-control" 
                      value="<?= $row['loadpaymentterms'] ?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Load Type<i>*</i></span>
                      <input name="load_type" id="load_type" class="form-control" 
                      value="<?= $row['loadtype'] ?>" type="text" />
                    </div> <!-- end custom_field -->
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Submit" id="submit"  />
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
  function initAutocomplete() {
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
          });
        });


        // Create the search box and link it to the UI element.
        var input = document.getElementById('load_to');
        var searchBox = new google.maps.places.SearchBox(input);

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
          });
        });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyButXT1NTaHC_eqd2uwbNPuTcYCqQn-d1g&libraries=places&callback=initAutocomplete"
         async defer></script>
</body>
</html>