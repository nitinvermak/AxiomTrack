<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ){
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
<!-- DataTable JS -->
<script type="text/javascript" src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.print.min.js"></script>
<script>
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
    //Initialize Select2 Elements
});
// send ajax request
$(document).ready(function(){
    $("#submit").click(function(){
        $('.loader').show();
        $.post("ajaxrequest/customer_details_report.php?token=<?php echo $token;?>",
                {
                    date : $('#date').val(),
                    dateto : $('#dateto').val(),
                    executive : $('#executive').val(),
                    branch : $('#branch').val(),
                    status : $('#status').val(),
                    customerStatus : $('#customerStatus').val()
                },
                    function(data){
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
//end
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
        Customer Report
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Customer Report</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Date (From) <i class="red">*</i></span>
                        <input type="text" name="date" id="date" class="form-control date"/>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Date (To) <i class="red">*</i></span>
                        <input type="text" name="dateto" id="dateto" class="form-control date"/> 
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Branch <i class="red">*</i></span>
                        <select name="branch" id="branch" class="form-control select2" style="width: 100%">
                            <option value="0">All Branch</option>                         
                            <?php $Country=mysql_query("SELECT * FROM `tblbranch` ORDER BY CompanyName ASC");      
                                  while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['id']; ?>" 
                            <?php if(isset( $_SESSION['CompanyName']) && $resultCountry['id']== $_SESSION['CompanyName']){ ?>selected                   <?php } ?>>
                            <?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Executive<i class="red">*</i></span>
                        <select name="executive" id="executive" class="form-control select2" style="width: 100%">
                            <option value="0">All Executive</option>                         
                            <?php $Country=mysql_query("SELECT * FROM `tbluser`");                              
                                  while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['id']; ?>">
                            <?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'])); ?></option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Customer Type <i class="red">*</i></span>
                        <select name="status" id="status" class="form-control select2" style="width: 100%" onChange="customerType()">
                            <option value="">Select</option>
                            <?php $Country=mysql_query("select * from tbl_customer_type");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['customer_type_id']; ?>" <?php if(isset($result['customer_type_id']) && $resultCountry['customer_type_id']==$result['customer_type_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['customer_type'])); ?></option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Customer Status <i class="red">*</i></span>
                        <select class="form-control select2" style="width: 100%" name="customerStatus" id="customerStatus">
                            <option value="">Select</option>
                            <option value="Ok">Ok</option>
                            <option value="Defaulter">Defaulter</option>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field">
                        <input type="button" name="submit" value="Submit" id="submit" class="btn btn-primary btn-sm pull-left"/>
                        &nbsp;
                        <!-- <input type="button" name="assign" value="Summary" onClick="window.location.replace('ticket_summary.php?token=<?php echo $token;?>')" id="submit" class="btn btn-primary btn-sm" /> -->
                    </div>
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Details</h3> -->
            </div>
            <div class="box-body">
                <div id="divassign" class="table-responsive">
                    <!-- Show Content from ajax page -->
                </div>
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