<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
//echo count($_POST['linkID']);
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
    session_destroy();
    header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') 
{
    session_destroy();
    header("location: index.php?token=".$token);
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
<!-- jQUERY -->
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
});

// Divison Show and Hide
function deviceReport() {
    document.getElementById("dv_device").style.display = "";
    document.getElementById("dv_rent").style.display = "none";    
}

function rentReport() {
    document.getElementById("dv_device").style.display = "none";
    document.getElementById("dv_rent").style.display = "";    
}
// pass ajax request when search cheque report
function getDevice_report(){
    $('.loader').show();
        $.post("ajaxrequest/device_rent_report.php?token=<?php echo $token;?>",
                {
                    cust_id : $('#cust_id').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#dvContent").html(data);
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
}
// end

// pass ajax request when search cash report
function getCashReport(){
    $('.loader').show();
        $.post("ajaxrequest/quick_book_invoice_cash_details.php?token=<?php echo $token;?>",
                {
                    reciveDateForm : $('#reciveDateForm').val(),
                    reciveDateto : $('#reciveDatedateto').val(),
                    cashConfirmation : $('#cashConfirmation').val()
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
}
// end

// pass ajax request when search neft report
function getNeftReport(){
    $('.loader').show();
        $.post("ajaxrequest/quick_book_invoice_neft_details.php?token=<?php echo $token;?>",
                {
                    neftDateForm : $('#neftDateForm').val(),
                    neftDateTo : $('#neftDateTo').val(),
                    neftConfirmationStatus : $('#neftConfirmationStatus').val()
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
}
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
            Device Report
            <!--<small>Control panel</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Device Report</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
                <div class="row search_grid">
                    <div class="col-md-12">
                        <input type="radio" name="rdopt"  value="device_report"  checked="checked" id="single" onClick="deviceReport()" /> <strong>Device</strong>&nbsp;
                        <input type="radio" name="rdopt"  value="rent_report"  id="multiple" onClick="rentReport()"/> <strong>Rent</strong>&nbsp;
                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="row" id="dv_device">
                        <div class="col-md-12">
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Company</strong> <i>*</i></span>
                                <select name="cust_id" id="cust_id" class="form-control drop_down select2" style="width: 100%">
                                    <option value="">Select Orgranization</option>                         
                                    <?php $Country=mysql_query("SELECT B.cust_id as custId, A.Company_Name as companyName 
                                                                FROM tblcallingdata as A 
                                                                INNER JOIN tbl_customer_master as B 
                                                                ON A.id = B.callingdata_id
                                                                WHERE A.status = '1'
                                                                ORDER BY A.Company_Name");                              
                                          while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['custId']; ?>">
                                    <?php echo stripslashes(ucfirst($resultCountry['companyName'])); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Lead Generated By</strong><i>*</i></span>
                                <input type="text" name="dateto" id="dateto" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Service Executive</strong> <i>*</i></span>
                                <select name="clearanceStatus" id="clearanceStatus" class="form-control select2" style="width: 100%">
                                    <option value="" selected>All</option>                         
                                    <option value="N">Pending</option>
                                    <option value="Y">Cleared</option>
                                    <option value="B">Bounced</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                 <span><strong>Generated Date</strong> <i>*</i></span>
                                 <input type="text" name="dateto" id="dateto" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                 <span><strong>Date</strong> <i>*</i></span>
                                 <input type="text" name="dateto" id="dateto" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span>&nbsp;</span><br>
                                <input type="button" name="assign" value="Submit" onclick="getDevice_report()" id="submit" class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                    </div> <!-- end chequeReport -->
                    <div class="row" id="dv_rent" style="display:none">
                        <div class="col-md-12">
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Company</strong> <i>*</i></span>
                                <input type="text" name="reciveDateForm" id="reciveDateForm" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Lead Generated By</strong> <i>*</i></span>
                                <input type="text" name="reciveDateto" id="reciveDatedateto" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Confirmation Status</strong> <i>*</i></span>
                                <select name="cashConfirmation" id="cashConfirmation" class="form-control select2" style="width: 100%">
                                    <option value="">All</option>                         
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span>&nbsp;</span><br>
                                <input type="button" name="cashReportSubmit" onclick="getRent_report()" value="Submit" id="cashReportSubmit" class="btn btn-primary btn-sm" />
                            </div>
                        </div><!--  end col-md-12 -->
                    </div> <!-- end cashReport -->
                </div> <!-- end row -->
                <div class="box box-info">
                    <div class="box-header">
                      <!-- <h3 class="box-title">Details</h3> -->
                    </div>
                    <div class="box-body">
                        <div class="col-md-12" id="dvContent"></div>
                    </div><!-- /.box-body -->
                </div> <!-- end box-info -->
            </form>
        </section><!-- End Main content -->
    </div> <!-- end content Wrapper-->
    <?php include_once("includes/footer.php") ?>
    <!-- Loader -->
    <div class="loader">
        <img src="images/loader.gif" alt="loader">
    </div>
    <!-- End Loader -->
</div> <!-- End site wrapper -->
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
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
</body>
</html>