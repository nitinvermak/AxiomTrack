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
<script type="text/javascript">
// calender script
$(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
});
// End calender script
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
        Sales Analysis
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sales Analysis</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Date (From) <i class="red">*</i></span>
                        <input type="text" name="dateFrom" id="dateFrom" class="form-control text_box-sm date"/>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Date (To) <i class="red">*</i></span>
                        <input type="text" name="dateTo" id="dateTo" class="form-control text_box-sm date"/>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Branch <i class="red">*</i></span>
                        <select name="branch" id="branch" class="form-control select2" style="width: 100%">
                            <!--<option label="" value="" selected="selected">Select Branch</option>-->
                            <?php 
                            $branch_sql= "select * from tblbranch ";
                            $Country = mysql_query($branch_sql);                    
                            while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="0" selected="selected">All Branch</option>
                            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                            <?php } ?>
                        </select> 
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Customer Type <i class="red">*</i></span>
                        <select name="customerType" id="customerType" class="form-control select2" style="width: 100%">
                        <option value="">All</option> 
                             <?php $sqlQuery = mysql_query("select * from tbl_customer_type order by customer_type");
                                                  while($resultQuery=mysql_fetch_assoc($sqlQuery)){
                                    ?>
                                    <option value="<?php echo $resultQuery['customer_type_id']; ?>">
                                    <?php echo stripslashes(ucfirst($resultQuery['customer_type'])); ?>
                                    </option>
                            <?php } ?>                        
                        </select> 
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Lead gen. By <i class="red">*</i></span>
                        <select name="leadGenBy" id="leadGenBy" class="form-control drop_down-sm">
                            <option label="" value="0" selected="selected">All</option>
                            <?php $sqlLead = mysql_query("select * from tbluser order by First_Name");
                                    while($resultlead = mysql_fetch_assoc($sqlLead)){
                            ?>
                            <option value="<?php echo $resultlead['id']; ?>" ><?php echo stripslashes(ucfirst($resultlead['First_Name']." ". $resultlead["Last_Name"])); ?></option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Installed By <i class="red">*</i></span>
                        <select name="installedBy" id="installedBy" class="form-control drop_down-sm">
                            <option label="" value="0" selected="selected">All</option>
                            <?php $sqlTech = mysql_query("select * from tbluser where User_Category=5 or User_Category=8 Order by First_Name");
                               while($resultTech=mysql_fetch_assoc($sqlTech)){
                            ?>
                            <option value="<?php echo $resultTech['id']; ?>" ><?php echo stripslashes(ucfirst($resultTech['First_Name']." ". $resultTech["Last_Name"])); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field">
                        <span>&nbsp;</span><br>
                        <input type="button" name="submit" value="Submit" onClick="getDetails();" class="btn btn-primary btn-sm"/> 
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
// Pass ajax request 
function getDetails()
{
    /*alert('asfsafs');*/
    $('.loader').show();
        $.post("ajaxrequest/sales_analysis_details.php?token=<?php echo $token;?>",
                {
                    dateFrom : $('#dateFrom').val(),
                    dateTo : $('#dateTo').val(),
                    branch : $('#branch').val(),
                    customerType : $('#customerType').val(),
                    leadGenBy : $('#leadGenBy').val(),
                    installedBy : $('#installedBy').val()
                },
                    function(data){
                        // alert(data);
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
// End
</script>
</body>
</html>