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
/*-------------- Remove Device From Branch Instock -------------------------- */
if(count($_POST['linkID'])>0 && (isset($_POST['remove'])) ){               
    $dsl="";
    if(isset($_POST['linkID'])){ 
        //echo 'nitin';
        foreach($_POST['linkID'] as $chckvalue){
            /*  $device_id=$_POST['linkID'][$dsl];*/
            $branch_id=$_POST['branch'];
            $status_id="0";
            $device_model = $_POST['devic_model_id'];
            $createdby=$_SESSION['user_id'];
            $sql = "delete from tbl_device_assign_branch where device_id='$chckvalue'";
            /*echo $sql;*/
            $results = mysql_query($sql);   
            $assign = "Update tbl_device_master set assignstatus='$status_id' where id='$chckvalue'";
            /*echo $sql;*/
            // Call User Activity Log function
            UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
            $sql. "<br>" .$assign);
            $query = mysql_query($assign);
            /* echo $query;*/
            $msgDanger = "Device Remove Successfully";
        }
    }  
    $id="";
}
// end
/*----------------- Assign Device Branch  ----------------*/
if(count($_POST['linkID'])>0 && (isset($_POST['submit'])) ){               
    $dsl="";
    // echo 'nitin-submit';
    if(isset($_POST['linkID'])){
        foreach($_POST['linkID'] as $chckvalue){
            /*  $device_id=$_POST['linkID'][$dsl];*/
            $branch_id=$_POST['branch'];
            $status_id="1";
            /*$device_model = $_POST['devic_model_id'];*/
            $createdby=$_SESSION['user_id']; 
            $check_deviceId = mysql_query("SELECT * FROM tbl_device_assign_branch WHERE device_id='$chckvalue'"); 
            if(mysql_num_rows($check_deviceId) <= 0){
                $sql = "update tbl_device_master set assignstatus='$status_id' where id='$chckvalue'";
                //echo $sql;
                $results = mysql_query($sql);   
                $assign = "insert into tbl_device_assign_branch set device_id='$chckvalue', 
                           assign_by = '$createdby', branch_id='$branch_id', assigned_date=Now()";
                        // Call User Activity Log function
                UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
                $sql. "<br>" .$assign);
                $query = mysql_query($assign);
                //echo $query; 
                $msg = "Device Branch Assign Successfully";
            }
            else{
                $msg = "Device already Assign";
            }
        }
    }  
    $id="";
}
// end
/*---------------- Assign Device Technician ------------------- */
if(count($_POST['linkID'])>0){             
    $dsl="";
    if(isset($_POST['linkID']) && (isset($_POST['submit_technician']))){
        foreach($_POST['linkID'] as $chckvalue){
            $technician_id = $_POST['technician_id'];
            $status_id = "1";
            $createdby = $_SESSION['user_id'];
            $check_deviceId = mysql_query("SELECT * FROM tbl_device_assign_technician 
                                           WHERE device_id='$chckvalue'"); 
            if(mysql_num_rows($check_deviceId) <= 0){
                $sql = "insert into tbl_device_assign_technician 
                        set device_id='$chckvalue', technician_id ='$technician_id', 
                        assigned_by = '$createdby',  assigned_date=Now()";
                $results = mysql_query($sql);
                $assign_technician = "update tbl_device_assign_branch 
                                      set technician_assign_status='$status_id' 
                                      where device_id='$chckvalue'";
                // Call User Activity Log function
                UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
                $sql."<br>".$assign_technician);
                $confirm = mysql_query($assign_technician);
                $msg = "Device Branch Assign Successfully";
            }
            else{
                $msgDanger = "Device already Assign";
            }
        }
    }  
    $id="";
}
/*---------------- end ------------------------*/
/*-------------------- Remove Device From Technician ------------------------- */
if(count($_POST['linkID'])>0){             
    $dsl="";
    if(isset($_POST['linkID']) && (isset($_POST['remove_technician']))){
        foreach($_POST['linkID'] as $chckvalue){
            $status_id="0";
            $sql = "DELETE FROM tbl_device_assign_technician where device_id='$chckvalue'";
            /*echo $sql;*/
            $results = mysql_query($sql);
            $assign_technician = "update tbl_device_assign_branch 
                                  set technician_assign_status='$status_id' 
                                  where device_id='$chckvalue'";
            // Call User Activity Log function
            UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
            $sql."<br>".$assign_technician);
            /*echo $assign_technician;*/
            $confirm = mysql_query($assign_technician);
            $msgDanger = "Device Remove Successfully";
        }
    }  
    $id="";
}
/*--------------- end ---------------*/
/*---------------Device Branch Confirmation ----------------*/
if(count($_POST['linkID'])>0){               
    $dsl="";
    if(isset($_POST['linkID']) &&(isset($_POST['deviceConfirm']))){
        foreach($_POST['linkID'] as $chckvalue){
            /*  $device_id=$_POST['linkID'][$dsl];*/
            $branch_id = $_POST['branch'];
            $confirmation_status = "1";
            $confirmBy = $_SESSION['user_id'];
            $sql = "update tbl_device_assign_branch set branch_confirmation_status='$confirmation_status', 
                    confirmBy = '$confirmBy' where device_id='$chckvalue'";
            $results = mysql_query($sql);
            $msg ="Branch Confirmation Successfully";
            // Call User Activity Log function
            UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
                            $sql);
        }
    }  
    $id="";
}
/*-------------- End --------------------------*/

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
function chequeReport() {
    document.getElementById("chequeReport").style.display = "";
    document.getElementById("cashReport").style.display = "none";
    document.getElementById("neftReport").style.display = "none";
    
}

function cashReport() {
/*alert("test");*/
   document.getElementById("cashReport").style.display = "";
   document.getElementById("chequeReport").style.display = "none";
   document.getElementById("neftReport").style.display = "none";  
}
function neftReport() {
/*alert("test");*/
   document.getElementById("neftReport").style.display = "";
   document.getElementById("cashReport").style.display = "none";
   document.getElementById("chequeReport").style.display = "none"; 
}
// End
// pass ajax request when search cheque report
function getCheckReport(){
    $('.loader').show();
        $.post("ajaxrequest/quick_book_invoice_details.php?token=<?php echo $token;?>",
                {
                    date : $('#date').val(),
                    dateto : $('#dateto').val(),
                    confirmationStatus : $('#confirmationStatus').val(),
                    depositStatus : $('#depositStatus').val(),
                    clearanceStatus : $('#clearanceStatus').val()
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
            Quick Book Invoice Report
            <!--<small>Control panel</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Quick Book Invoice Report</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
                <div class="row search_grid">
                    <div class="col-md-12">
                        <input type="radio" name="rdopt"  value="Single Contact"  checked="checked" id="single" onClick="chequeReport()" /> <strong>Cheque Report</strong>&nbsp;
                        <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="cashReport()"/> <strong>Cash Report</strong>&nbsp;
                        <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="neftReport()"/> <strong>NEFT Report</strong>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row" id="chequeReport">
                        <div class="col-md-12">
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Date (From)</strong> <i>*</i></span>
                                <input type="text" name="date" id="date" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Date (To) </strong><i>*</i></span>
                                <input type="text" name="dateto" id="dateto" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Clearance Status</strong> <i>*</i></span>
                                <select name="clearanceStatus" id="clearanceStatus" class="form-control select2" style="width: 100%">
                                    <option value="" selected>All</option>                         
                                    <option value="N">Pending</option>
                                    <option value="Y">Cleared</option>
                                    <option value="B">Bounced</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                 <span><strong>Deposit Status</strong> <i>*</i></span>
                                 <select name="depositStatus" id="depositStatus" class="form-control select2" style="width: 100%">
                                   <option value="">All</option>
                                   <option value="Y">Yes</option>
                                   <option value="N">No</option>        
                                 </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                 <span><strong>Confirmation Status</strong> <i>*</i></span>
                                 <select name="confirmationStatus" id="confirmationStatus" class="form-control select2" style="width: 100%">
                                    <option value="">All</option>                         
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                  </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span>&nbsp;</span><br>
                                <input type="button" name="assign" value="Submit" onclick="getCheckReport()" id="submit" class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                    </div> <!-- end chequeReport -->
                    <div class="row" id="cashReport" style="display:none">
                        <div class="col-md-12">
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Date (From)</strong> <i>*</i></span>
                                <input type="text" name="reciveDateForm" id="reciveDateForm" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Date (To)</strong> <i>*</i></span>
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
                                <input type="button" name="cashReportSubmit" onclick="getCashReport()" value="Submit" id="cashReportSubmit" class="btn btn-primary btn-sm" />
                            </div>
                        </div><!--  end col-md-12 -->
                    </div> <!-- end cashReport -->
                    <div class="row" id="neftReport" style="display:none">
                        <div class="col-md-12">
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Date (From)</strong> <i>*</i></span>
                                <input type="text" name="neftDateForm" id="neftDateForm" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Date (To)</strong> <i>*</i></span>
                                <input type="text" name="neftDateForm" id="neftDateForm" class="form-control date" style="width: 100%">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span><strong>Confirmation Status</strong> <i>*</i></span>
                                <select name="neftConfirmationStatus" id="neftConfirmationStatus" class="form-control select2" style="width: 100%">
                                    <option value="">All</option>                         
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <span>&nbsp;</span><br>
                                <input type="button" name="neftReportDetails" onclick="getNeftReport()" value="Submit" id="neftReportDetails" class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                    </div> <!-- end neftReport -->
                </div> <!-- end row -->
                <div class="box box-info">
                    <div class="box-header">
                      <!-- <h3 class="box-title">Details</h3> -->
                    </div>
                    <div class="box-body">
                        <!-- Show alert  message-->
                        <?php if(isset($msg)) {?>
                        <div class="alert alert-success alert-dismissible small-alert" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong><i class="fa fa-check-circle-o" aria-hidden="true"></i></strong> 
                            <?= $msg; ?>
                        </div>
                        <?php } ?>
                        <?php if(isset($msgDanger)) {?>
                        <div class="alert alert-danger alert-dismissible small-alert" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong><i class="fa fa-check-circle-o" aria-hidden="true"></i></strong> 
                            <?= $msgDanger; ?>
                        </div>
                        <?php } ?>
                        <!-- end alert message -->
                        <form name='fullform' method='post' onSubmit="return confirmdelete()">
                           <input type="hidden" name="token" value="<?php echo $token; ?>" />
                           <input type='hidden' name='pagename' value='users'> 
                           <div id="divassign" class="table-responsive">
                            <!-- Show data from ajax request -->
                           </div>
                        </form>
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