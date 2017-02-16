<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ){
    session_destroy();
    header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']==''){
    session_destroy();
    header("location: index.php?token=".$token);
}
// Configure New Vehicle Status
if(count($_POST['linkID'])>0){        
  $dsl="";
  if(isset($_POST['linkID']) &&(isset($_POST['submitNew']))){
    foreach($_POST['linkID'] as $chckvalue){
      $sql = "UPDATE tempvehicledata SET configStatus = 'Y' WHERE id = '$chckvalue'";
      $results = mysql_query($sql);
      SendAlert($chckvalue); // Call SMS function
      $_SESSION['sess_msg']="Configuration Successfully!";
      }
    }  
  $id="";
  if(isset($_POST['linkID']) &&(isset($_POST['submitRepair']))){
    foreach($_POST['linkID'] as $chckvalue){
      $sql = "UPDATE tempvehicledatarepair SET configStatus = 'Y' WHERE id = '$chckvalue'";
      //echo $sql;
      $results = mysql_query($sql);
      SendAlertRepair($chckvalue); // Call SMS function 
      $_SESSION['sess_msg']="Configuration Successfully!";
    }
  }  
  $id="";
}
// End  
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
<!-- DataTable CSS -->
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/buttons.dataTables.min.css">
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<!-- Validation Js -->
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script>
// Divison Show and Hide
function newInstallation() {
  document.getElementById("newReport").style.display = "";
  document.getElementById("repariReport").style.display = "none";
}
function repairInstallation() {
//alert("test");
   document.getElementById("newReport").style.display = "none";
   document.getElementById("repariReport").style.display = "";
}
// End Divison Show and Hide
// Datepicker script
$(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
});
// End Datepicker
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
        Installation Report
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Installation Report</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <form name='fullform' method='post' onSubmit="return confirmdelete()">
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <div class="col-md-12 search_grid">
          <input type="radio" name="rdopt"  value="Single Contact"  checked="checked" id="single" onClick="newInstallation()" /> <strong>New Installation Report </strong>
          <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="repairInstallation()"/> <strong>Repair Installation Report</strong>     
        </div>
        <div class="row" id = "newReport">
         <!--  <div class="col-md-12">
            <h4 class="red">&nbsp;</h4>
          </div> -->
          <div class="form-group form_custom col-md-12"> <!-- form Custom -->
            <div class="row"><!-- row -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Date (From) <i class="red">*</i></span>
                <input type="text" name="depositDateFrom" id="depositDateFrom" class="form-control date">
              </div> <!-- end custom field -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Date (To) <i class="red">*</i></span>
                <input type="text" name="depositDateTo" id="depositDateTo" class="form-control date">
              </div> <!-- end custom field -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Branch <i class="red">*</i></span>
                <select name="branch" id="branchNew" class="form-control select2" style="width: 100%">
                  <option label="" value="" selected="selected">All Branch</option>
                    <?php 
                    $branch_sql= "select * from tblbranch ";
                    //echo $branch_sql;
                    $Country = mysql_query($branch_sql);          
                      while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                    <?php } ?>
                </select>
              </div> <!-- end custom field -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Executive <i class="red">*</i></span>
                <span id="showTechnicianNew">
                  <select name="executive1" id="executive1" class="form-control select2" style="width: 100%">
                    <option value="">Select Executive</option>                         
                  </select>
                </span>
              </div> <!-- end custom field -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Config Status <i class="red">*</i></span>
                <select name="configStatus1" id="configStatus1" class="form-control drop_down">
                  <option value="">All</option>
                  <option value="Y">Yes</option>
                  <option value="N">No</option>
                </select>
              </div> <!-- end custom field -->
              <div class="clearfix"></div>
              <div class="col-lg-6 col-sm-6 custom_field">
                <input type="button" name="searchNew" id="searchNew" value="Search" class="btn btn-primary btn-sm">
              </div>
            </div><!-- end row -->                
          </div><!-- End From Custom -->
        </div> <!-- end new report -->
        <div class="row" id = "repariReport" style=" display:none;">
         <!--  <div class="col-md-12">
            <h4 class="red">Repair Installation Details</h4>
          </div> -->
          <div class="form-group form_custom col-md-12"> <!-- form Custom -->
            <div class="row"><!-- row -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Date (From) <i class="red">*</i></span>
                <input type="text" name="repairDateFrom" id="repairDateFrom" class="form-control date">
              </div> <!-- end custom field -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Date (To) <i class="red">*</i></span>
                <input type="text" name="repairDateTo" id="repairDateTo" class="form-control date">
              </div> <!-- end custom field -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Branch<i class="red">*</i></span>
                <select name="branch" id="branchRepair" class="form-control select2" style="width: 100%">
                  <option label="" value="" selected="selected">All Branch</option>
                    <?php 
                    $branch_sql= "select * from tblbranch ";
                    //echo $branch_sql;
                    $Country = mysql_query($branch_sql);          
                      while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                    <?php } ?>
                </select>
              </div> <!-- end custom field -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Executive <i class="red">*</i></span>
                <span id="showTechnicianRepair">
                  <select name="executive1" id="executive1" class="form-control select2" style="width: 100%">
                    <option value="">Select Executive</option>                         
                  </select>
                </span> 
              </div> <!-- end custom field -->
              <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                <span>Config Status <i class="red">*</i></span>
                <select name="configStatus" id="configStatus" class="form-control select2" style="width: 100%">
                  <option value="">All</option>
                  <option value="Y">Yes</option>
                  <option value="N">No</option>
                </select>
              </div> <!-- end custom field -->
              <div class="clearfix"></div>
              <div class="col-lg-6 col-sm-6 custom_field">
                <input type="button" name="searchRepair" id="searchRepair" value="Search" class="btn btn-primary btn-sm">
              </div>
            </div><!-- end row -->                
          </div><!-- End From Custom -->
        </div> <!-- end new report -->
        <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Details</h3> -->
            </div>
            <div class="box-body">
                <div id="dvData" class="table-responsive">
                    <!-- Show Content from ajax page -->
                </div>
            </div>
            <!-- /.box-body -->
        </div>
      </form>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<!-- Loader -->
<div class="loader">
    <img src="images/loader.gif" alt="loader">
</div>
<!-- End Loader -->
<?php include_once("includes/footer.php") ?>
</div><!-- ./wrapper -->
<!-- DataTable JS -->
<!-- <script type="text/javascript" src="assets/plugins/datatables/js/jquery-1.12.3.js"></script> -->
<script type="text/javascript" src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.print.min.js"></script>
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
  // Send Ajax Request When Search New Installation Details
$(document).ready(function(){
  $('#searchNew').click(function(){
    $('.loader').show();
    $.post("ajaxrequest/daily_installation_details.php?token=<?php echo $token;?>",
        {
          depositDateFrom : $('#depositDateFrom').val(),
          depositDateTo : $('#depositDateTo').val(),
          branch : $('#branch').val(),
          executive : $('#executive').val(),
          configStatus1 : $('#configStatus1').val()
        },
          function(data){
            /*alert(data);*/
            $("#dvData").html(data);
            $('#example').DataTable( {
                  dom: 'Bfrtip',
                  "bPaginate": false,
                  buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                  ]
              });
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        }); 
  });
});
// End
// Send Ajax Request When Search Repair Installation Details
$(document).ready(function(){
  $('#searchRepair').click(function(){
    $('.loader').show();
    $.post("ajaxrequest/repair_installation_details.php?token=<?php echo $token;?>",
        {
          repairDateFrom : $('#repairDateFrom').val(),
          repairDateTo : $('#repairDateTo').val(),
          branch : $('#branchRepair').val(),
          executive : $('#executive').val(),
          configStatus : $("#configStatus").val()
        },
          function(data){
            /*alert(data);*/
            $("#dvData").html(data);
            $('#example').DataTable( {
                  dom: 'Bfrtip',
                  "bPaginate": false,
                  buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                  ]
              });
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        }); 
  });
});
// End
// send ajax when select branch
$(document).ready(function(){
  $("#branchNew").change(function(){
    $.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
        {
          branch : $('#branchNew').val()
        },
          function(data){
            /*alert(data);*/
            $("#showTechnicianNew").html(data);
        });
  });
});
// End
// send ajax when select branch
$(document).ready(function(){
  $("#branchRepair").change(function(){
    $.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
        {
          branch : $('#branchRepair').val()
        },
          function(data){
            /*alert(data);*/
            $("#showTechnicianRepair").html(data);
        });
  });
});
// End
// Send Ajax Request when Re-send Command
function getValue(obj)
{
  $('.loader').show();
  $.post("ajaxrequest/re_send_cmd.php?token=<?php echo $token;?>",
    {
      mobileNo : $('#mobileNo' + obj).val(),
      deviceModel : $('#deviceModel' + obj).val()
    },
  function(data){
    /*alert(data);*/
    $("#shwAlert").html(data);
    $(".loader").removeAttr("disabled");
    $('.loader').fadeOut(1000);
  });
}

function getValue1(a)
{
  alert(a)
  $('.loader').show();
  $.post("ajaxrequest/re_send_cmd_repair.php?token=<?php echo $token;?>",
    {
      repairType : $('#repairType' + a).val(),
      oldMobileNo : $('#oldMobileNo' + a).val(),
      model : $('#model' + a).val(),
      newMobile : $('#newMobile' + a).val()
    },
  function(data){
    alert(data);
    $("#shwAlert").html(data);
    $(".loader").removeAttr("disabled");
    $('.loader').fadeOut(1000);
  });
}
// End
</script>
</body>
</html>