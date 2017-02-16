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
//Delete single record
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $delete_single_row = "DELETE FROM tbl_city_new WHERE city_id='$id'";
    $delete = mysql_query($delete_single_row);
    if($delete){
        $msgDanger = "Record Delted Successfully";
    }
}
//End
//Delete multiple records
if(isset($_POST['delete_selected'])){
    foreach($_POST['linkID'] as $chckvalue){
        $sql = "DELETE FROM tbl_city_new WHERE city_id='$chckvalue'";
        $result = mysql_query($sql);
    }
    if($result){
        $msgDanger = "Records Deleted Successfully";
    }
}
//end
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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
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
<script type="text/javascript">
    function getCityDetails(){
        if ($("#cityName").val() == "") {
            alert("Please Provide Search Criteria");
            $("#cityName").focus();
        }
        else{
            $('.loader').show();
            $.post("ajaxrequest/city_details.php?token=<?php echo $token ?>",
            {
                cityName : $("#cityName").val()
            },
            function(data){
                // alert(data);
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
        }
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
        City Details
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">City Details</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <form name='fullform' method='post' onSubmit="return confirmdelete()">
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                       <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Add New" onClick="window.location.replace('add_city.php?token=<?php echo $token ?>')"/>
                       &nbsp;&nbsp;&nbsp;
                       <input type="submit" name="delete_selected" onClick="return val();" class="btn btn-primary btn-sm" value="Delete Selected">
                    </div> <!-- end custom field -->
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Details</h3> -->
            </div>
            <div class="box-body">
                <div class="col-lg-12">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <span><strong>City</strong> <i class="red">*</i></span>
                        <input type="text" name="cityName" id="cityName" class="form-control">
                    </div>  
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <span>&nbsp;</span><br>
                        <input type="button" name="cityName" id="cityName" class="btn btn-primary btn-sm" onclick="getCityDetails()" value="Search"/>
                    </div>                 
                </div>
                <div class="col-lg-12">
                    <?php if(isset($msgDanger) && $msgDanger !="") {?>
                    <div class="alert alert-danger alert-dismissible small-alert" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <?= $msgDanger;?>
                    </div>
                    <?php 
                    }
                    ?>
                    <?php if(isset($_SESSION['sess_msg']) && $_SESSION['sess_msg'] !="") {?>
                    <div class="alert alert-success alert-dismissible small-alert" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <?= $_SESSION['sess_msg'];?>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
                <div class="col-lg-12 table-responsive" id="dvData" style="margin-top: 20px;"> 

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