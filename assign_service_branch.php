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
//Delete single record
if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $delete_single_row = "DELETE FROM tblcallingdata WHERE id='$id'";
        $delete = mysql_query($delete_single_row);
    }
    if($delete)
    {
        echo "<script> alert('Record Delted Successfully'); </script>";
    }
//End
//Delete multiple records
if(count($_POST['delete_selected'])>0 && (isset($_POST['delete_selected'])) )
   {               
        if(isset($_POST['linkID']))
            {
              foreach($_POST['linkID'] as $chckvalue)
              {
                $sql = "DELETE FROM tblcallingdata WHERE id='$chckvalue'";
                $result = mysql_query($sql);
               }
               if($result)
               {
               echo "<script> alert('Records Deleted Successfully'); </script>";
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).on("click","#Search", function(){
    $.post("ajaxrequest/assign_service_branch.php?token=<?php echo $token;?>",
                {
                    searchText : $('#searchText').val()
                },
                    function( data){
                        /*alert(data);*/
                        $("#divshow").html(data);
                });  
})
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini" >
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once("includes/header.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Assign Service Branch
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Assign Service Branch</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row search_grid"> <!-- search_grid -->
            <div class="col-md-12">
                <div class="form-inline">
                    <div class="form-group">
                        <input type="text" name="searchText" id="searchText" class="form-control text_search" Placeholder="Customer Id, Company Name or Mobile">
                    </div>
                    <input type="submit" name="Search" id="Search" value="Search"  class="btn btn-primary btn-sm"/>
                </div> 
            </div> <!-- end col-md-12 -->
        </div><!-- end search_grid -->
        <div class="box box-info ">
            <div class="box-header">
              <h3 class="box-title">Details</h3>
            </div>
            <div class="box-body">
                <?php if($_SESSION['sess_msg'] !="") {?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $_SESSION['sess_msg']; ?>
                </div>
                <?php 
                }
                ?>
                <div class="table-responsive" id="divshow">
                    
                </div>
            </div><!-- /.box-body -->
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