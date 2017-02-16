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


 if(count($_POST['linkID'])>0)
   {         
      $dsl="";
    if(isset($_POST['linkID']) &&(isset($_POST['submit'])))
        {
        foreach($_POST['linkID'] as $chckvalue)
              {
                  /*  $device_id=$_POST['linkID'][$dsl];*/
                  $branch_id=$_POST['branch'];
                $confirmation_status="1";
                $createdby=$_SESSION['user_id'];
                    $sql = "update tbl_ticket_assign_branch set branch_confirmation_status = '$confirmation_status' 
                  where ticket_id='$chckvalue'";
          // Call User Activity Log function
          UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
          // End Activity Log Function
              $results = mysql_query($sql);
          $_SESSION['sess_msg']="<span style='color:#006600;'>Ticket Confirmation Successfully</span>";
          }
        }  
      $id="";
  
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
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<script type="text/javascript" src="js/checkbox_validation_confirmation_pages.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script>
$(document).ready(function(){
    $("#branch").change(function(){
      $('.loader').show();
      $.post("ajaxrequest/show_ticket_branch_confirmation.php?token=<?php echo $token;?>",
        {
          branch : $('#branch').val(),
        },
          function( data){
            $("#divassign").html(data);
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
          });  
    });
});
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
        Confirm Received Ticket
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Confirm Received Ticket</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Branch <i class="red">*</i></span>
                        <select name="branch" id="branch" class="form-control select2" style="width: 100%">
                            <option label="" value="" selected="selected">Select Branch</option>
                            <?php 
                                    $branch_sql= "select * from tblbranch ";
                                    $authorized_branches = BranchLogin($_SESSION['user_id']);
                                    //echo $authorized_branches;
                                    if ( $authorized_branches != '0'){
                                         
                                        $branch_sql = $branch_sql.' where id in '.$authorized_branches;   
                                    }
                                    if($authorized_branches == '0'){
                                        echo'<option value="0">All Branch</option>';  
                                    }
                                    //echo $branch_sql;
                                    $Country = mysql_query($branch_sql);          
                                                                  
                                    while($resultCountry=mysql_fetch_assoc($Country)){
                              ?>
                            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Details</h3>
            </div>
            <div class="box-body">
                <?php if(isset($msg)){?>
                <div class="alert alert-success alert-dismissible small-alert" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $msg; ?>
                </div>
                <?php 
                }
                ?>
                <div id="divassign" class="table-responsive">
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