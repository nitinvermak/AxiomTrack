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


if(count($_POST['linkID'])>0)
{
  $dsl="";
  for($dsl=0;$dsl<count($_POST['linkID']);$dsl++)
  {
      $callingdata_id = $_POST['linkID'][$dsl];
    $callingcategory_id = $_POST['callingcat'];
    $status_id = "1";
    $branch_id = $_POST['branch'];
    $createdby = $_SESSION['user_id'];
    $checkDuplicate = mysql_query("SELECT * FROM tblassign WHERE callingdata_id='$chckvalue'"); 
                if(mysql_num_rows($checkDuplicate) <= 0)
        {
          $sql = "insert into tblassign set callingdata_id='$callingdata_id', assign_by = '$createdby',
              callingcategory_id='$callingcategory_id', status_id='$status_id',
              branch_id='$branch_id',createdby='$createdby',created=CURDATE()";
          $results = mysql_query($sql); 
          // Call User Activity Log function
          UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
          // End Activity Log Function
          $msg = "Lead Assign Successfully";
        }
        else{
          $msgDanger = "Lead already Assign";
        }
  }
    $id="";  
  }

//Remove Assign Contact
if(isset($_POST['remove'])){         
    $dsl="";
    if(isset($_POST['linkID'])){
      foreach($_POST['linkID'] as $chckvalue){
        $sql = "delete from tblassign where id=".$chckvalue;
        // Call User Activity Log function
        UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
        // End Activity Log Function
        $results = mysql_query($sql) or die(mysql_error()); 
        $msgDanger = "Lead Remove Successfully";
      }
    }  
    $id="";
}
//End
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
<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<!-- DataTable CSS -->
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/buttons.dataTables.min.css">
<!-- Jquery -->
<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript" src="js/assign_device_to_branch.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
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
          Calling Data Report
          <!--<small>Control panel</small>-->
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Calling Data Report</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
          <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <input type="text" name="search_box" id="search_box" class="form-control" Placeholder="Ex. Device Id or IMEI No." style="width: 100%" />
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                       <input type="button" name="assign" value="Search" id="submit" class="btn btn-primary btn-sm" />
                       <input type="button" name="view" id="view" value="Summary" class="btn btn-primary btn-sm" onClick="window.location.replace('device_summary.php?token=<?php echo $token;?>')" />
                       <input type="button" name="advanceFilter" id="advanceFilter" value="Advance Filter" class="btn btn-primary btn-sm" onClick="window.location.replace('device_advance_filter.php?token=<?php echo $token;?>')" />
                    </div> <!-- end custom field -->
                </div><!-- end row -->                
            </div><!-- End From Custom -->
          </div>
          <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Details</h3>
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
                 <div id="divassign" class="col-md-12 table-responsive">
                  <!-- Ajax request -->
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
<!-- jQuery 2.2.3 -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- DataTable JS -->
<script type="text/javascript" src="assets/plugins/datatables/js/jquery-1.12.3.js"></script>
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
<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
  $(document).ready(function(){
  $('#submit').click(function(){
    $('.loader').show();
    $.post("ajaxrequest/calling_data_report_details.php?token=<?php echo $token;?>",
        {
          search_box : $('#search_box').val()
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
</script>
</body>
</html>