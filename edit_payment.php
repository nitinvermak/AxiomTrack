<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) 
{
  session_destroy();
  header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') 
{
  session_destroy();
  header("location: index.php?token=".$token);
}
if(isset($_GET['paymentId']))
  {
    $paymentId =  $_GET['paymentId'];
    $chequeId =  $_GET['chequeId'];
    $onlinetransferId =  $_GET['onlinetransferId'];

    // Delete row from quickbookpaymentmethoddetailsmaster table 
    $sqlPaymentMaster = "DELETE FROM `quickbookpaymentmethoddetailsmaster` WHERE `PaymentID` = ".$paymentId;
    $resultPaymentMaster = mysql_query($sqlPaymentMaster);
    
    // Delete row from quickbookpaymentcheque
    $sqlCheque = "DELETE FROM `quickbookpaymentcheque` WHERE `Id`=".$chequeId;
    $resultCheque = mysql_query($sqlCheque);
    
    // Delete row from quickbookpaymentonlinetransfer
    $sqlOnline = "DELETE FROM `quickbookpaymentonlinetransfer` WHERE `Id`=".$onlinetransferId;
    $resultOnline = mysql_query($sqlOnline);
    if($resultPaymentMaster){
      $_SESSION['del_msg'] = "Payment Delete Successfully !";
      header("location:edit_payment.php?token=".$token);
      exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
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
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript" src="js/manage_import_device.js"></script>
<!-- DataTable JS -->
<script type="text/javascript" src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.print.min.js"></script>
<script type="text/javascript">
$(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
}); 
// pass ajax request
$(document).ready(function(){
  $('#submit').click(function(){
  $('.loader').show();
    $.post("ajaxrequest/show_edit_payment_details.php?token=<?php echo $token;?>",
        {
          organization : $('#organization').val(),
          paymentId : $('#paymentId').val()
        },
          function( data){
            /*alert(data);*/
            $("#divassign").html(data);
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
// end

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
          Edit Payment
          <!--<small>Control panel</small>-->
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Edit Payment</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
          <div class="row search_grid">
            <div class="col-lg-12">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <span><strong>Company</strong> <i class="red">*</i></span>
                <select name="organization" id="organization" onChange="return ShowbyCategory();" class="form-control select2" style="width: 100%">
                  <option label="" value="" selected="selected">Select Company</option>
                    <?php $Country=mysql_query("SELECT A.cust_id as custId, B.Company_Name as company
                                                FROM tbl_customer_master as A 
                                                INNER JOIN tblcallingdata as B 
                                                ON A.callingdata_id = B.id ORDER BY B.Company_Name ASC");
                                    while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['custId']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['company'])); ?></option>
                    <?php } ?>
                  </select>
              </div> <!-- end col-md-6 -->
              <div class="col-lg-6 col-md-6 col-sm-6">
                <span><strong>Payment Id</strong> <i class="red">*</i></span>
                <input type="text" name="paymentId" id="paymentId" class="form-control" style="width: 100%">
              </div> <!-- end col-md-6 -->
              <div class="col-lg-6 col-md-6 col-sm-6">
                <span><strong>&nbsp;</strong></span><br>
                <input type="button" name="assign" value="Submit" id="submit" class="btn btn-primary btn-sm" />
              </div> <!-- end col-md-6 -->
            </div> <!-- end col-md-12 -->
          </div> <!-- end row -->
          <div class="box box-info">
                <div class="box-header">
                  <!-- <h3 class="box-title">Details</h3> -->
                </div>
                <div class="box-body">
              <div id="divassign" class="table-responsive">
                <?php if($_SESSION['del_msg'] != ""){
                ?>
                <div class="alert alert-danger small-alert alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Success!</strong> <?= $_SESSION['del_msg'] ?>
                </div>
                <?php 
                }
                ?>
                <?php if($_SESSION['sess_msg'] != ""){
                ?>
                <div class="alert alert-success small-alert alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Success!</strong> <?= $_SESSION['sess_msg'] ?>
                </div>
                <?php 
                }
                ?>
                  <!-- Show data from ajax request -->
              </div>
                </div><!-- /.box-body -->
            </div> <!-- end box-info -->
        </form>
      </section><!-- End Main content -->
  </div> <!-- end content Wrapper-->
  <?php include_once("includes/footer.php") ?>
  <!-- Show Modal Form -->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <!-- Show Content From Ajax Request page -->
      </div>
    </div>
  </div>
    <!-- End Modal -->
  <!-- Loader -->
  <div class="loader">
    <img src="images/loader.gif" alt="loader">
  </div>
  <!-- End Loader -->
</div> <!-- End site wrapper -->

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