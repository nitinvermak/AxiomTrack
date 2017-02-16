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
    $sql_chk_row = mysql_query("SELECT `callingdata_id` 
                                FROM `tbl_customer_master` 
                                WHERE `callingdata_id` = '$id'");
    $result = mysql_num_rows($sql_chk_row);
 
    if($result == 1){
        $msgDanger = 'Try again';
    }
    else{
        $delete_single_row = "DELETE FROM tblcallingdata WHERE id='$id'";
        $delete = mysql_query($delete_single_row);
        if($delete){
            $msgDanger = 'Record Delted Successfully';
        }
    }

    
}
//End
//Delete multiple records
if(count($_POST['delete_selected'])>0 && (isset($_POST['delete_selected'])) ){               
    if(isset($_POST['linkID'])){
        foreach($_POST['linkID'] as $chckvalue){
            $sql_chk_row = mysql_query("SELECT `callingdata_id` 
                                FROM `tbl_customer_master` 
                                WHERE `callingdata_id` = '$id'");
            $result = mysql_num_rows($sql_chk_row);
            if($result == 1){
                $msgDanger = 'Try again';
            }
            else{
                $sql = "DELETE FROM tblcallingdata WHERE id='$chckvalue'";
                $result = mysql_query($sql);
                if($result){
                   $msgDanger = 'Records Deleted Successfully';
                }
            }
        }
    }    
}
//End
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
<script type="text/javascript" src="js/checkbox.js"></script>
<script>
 $(function() {
    $( "#date_of_purchase" ).datepicker({dateFormat: 'yy-mm-dd'});
    //Initialize Select2 Elements
});
$(document).ready(function(){
        $("#Search").click(function(){
            $('.loader').show();
            $.post("ajaxrequest/show_contacts.php?token=<?php echo $token;?>",
                {
                    searchText : $('#searchText').val(),
                },
                    function( data){
                        /*alert(data);*/
                        $("#divshow").html(data);
                        // $('#example').DataTable();
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });  
        });
});
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
        Lead  Details
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lead  Details</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post">
            <div class="row">
                <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                    <div class="row"><!-- row -->
                        <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                            <span>Search <i class="red">*</i></span>
                            <input type="text" name="searchText" id="searchText" class="form-control" Placeholder="Name, Company Name or Mobile">
                        </div> <!-- end custom field -->
                        <div class="col-lg-6 col-sm-6 custom_field">
                            <span>&nbsp;</span><br>
                            <input type="button" name="Search" id="Search" value="Search" class="btn btn-primary btn-sm"/>
                        </div>
                    </div><!-- end row -->                
                </div><!-- End From Custom -->
            </div>
            <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Details</h3>
                </div>
                <div class="box-body">
                    <?php if(isset($msgDanger)){
                    ?>
                        <div class="alert alert-danger alert-dismissible small-alert" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $msgDanger; ?>
                        </div>
                    <?php 
                    }
                    ?>
                    <?php if(isset($_SESSION['sess_msg'])){
                    ?>
                        <div class="alert alert-success alert-dismissible small-alert" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> 
                            <?= $_SESSION['sess_msg']; ?>
                        </div>
                    <?php 
                    }
                    ?>
                    <div id="divshow" class="table-responsive">
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