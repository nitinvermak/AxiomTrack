<?php

include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
include("includes/simpleimage.php");
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
  session_destroy();
  header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') 
{
  session_destroy();
  header("location: index.php?token=".$token);
}
/*if (isset($_SESSION) && $_SESSION['user_category_id']!=1) 
{
    header("location: home.php?token=".$token);
}*/
if(isset($_POST['submit']))
  {
    $simId = mysql_real_escape_string($_POST['simId']);
    $status = mysql_real_escape_string($_POST['status']);
    $sql = "Update tblsim set status_id = '$status' Where id ='$simId '";
    $result = mysql_query($sql);
    $_SESSION['sess_msg'] = 'Status Updated successfully';
    header("location:manage_sim.php?token=".$token);
    exit();
  }
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblsim where id =".$_REQUEST['id']);
$result=mysql_fetch_assoc($queryArr);
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
<script type="text/javascript" src="js/manage_import_device.js"></script>

<script>
 $(function() {
    $( "#date_of_purchase" ).datepicker({dateFormat: 'yy-mm-dd'});
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
        Change Sim Status
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Change Sim Status</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <div class="box-header">
              <!-- <h3 class="box-title">Update</h3> -->
            </div>
            <div class="box-body">
            <div class="small-form">
            <?php if(isset($id) && $id !="") {?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $id; ?>
            </div>
            <?php 
            }
            ?>
            <?php if(isset($msg) && $msg !="") {?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msg;?>
            </div>
            <?php 
            }
            ?>
            <form name='myform' action="" method="post" onSubmit="return validate(this)">
              <input type="hidden" name="submitForm" value="yes" />
              <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
              <!-- from-group -->
              <div class="form-group">
                <label>Sim Id<i>*</i></label>
                <input name="simId" id="simId" class="form-control" type="text" value="<?php if(isset($result['id'])) echo $result['id'];?>" readonly />
              </div>
              <!-- /.form group -->
              <div class="form-group">
                <label>Status<i>*</i></label>
                <select name="status" id="status" class="form-control drop_down">
                  <option value="">Select Status</option>
                  <option value="0">Instock</option>
                  <option value="2">Replacement</option>
                  <option value="3">Damage</option>
                  <option value="4">Reissue</option>
                 </select>
              </div> <!-- /.form group -->
              <div class="form-group"><!-- /.form group -->
                <input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
                <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset">                      
                <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" onClick="window.location='manage_sim.php?token=<?php echo $token ?>'"/>
              </div> <!-- form-group -->
              </form>
              </div> <!-- end small-form -->
            </div>
            <!-- /.box-body -->
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
</body>
</html>