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

$error =0;
if(isset($_REQUEST['model']))
{
  $model = mysql_real_escape_string($_POST['model']);
  $brandName = mysql_real_escape_string($_POST['brandName']);
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
    $sql="UPDATE `vehiclemodal` SET brandId = '$brandName', modelName = '$model'  
          WHERE `id`= " .$_REQUEST['id'];
    // Call User Activity Log function
    UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
    // End Activity Log Function
    mysql_query($sql);
    $_SESSION['sess_msg']='Vehicle Model Updated successfully';
    header("location:manage_vehicle_model.php?token=".$token);
    exit();
}
else{
$queryArr=mysql_query("Select * from vehiclemodal where modelName ='$model'");
if(mysql_num_rows($queryArr)<=0)
{
    $query=mysql_query("insert into vehiclemodal set brandId = '$brandName', modelName = '$model'");
    // Call User Activity Log function
    UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $query);
    // End Activity Log Function
    $_SESSION['sess_msg']='Vehicle Model added successfully';
    header("location:manage_vehicle_model.php?token=".$token);
    exit();
}
else
{
    $msgDanger = "Vehicle Model already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
    $queryArr=mysql_query("select * from vehiclemodal where id =".$_REQUEST['id']);
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
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/add_district.js"></script>
<script>
 function validate(){
  if($("#brandName").val() == ""){
    alert("Please Select Brand Name");
    $("#brandName").focus();
    return false;
  }
  if($("#model").val() == ""){
    alert("Please Provide Model Name");
    $("#model").focus();
    return false;
  }
  return true;
 }
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
        Vehicle Model
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">District/City</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <!-- <div class="box-header">
              <h3 class="box-title">Vehicle Brand</h3>
            </div> -->
            <div class="box-body">
            <?php if(isset($msgDanger) && $msgDanger !="") {?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msgDanger;?>
            </div>
            <?php 
            }
            ?>
              <div class="small-form">
                <form name='myform' action="" method="post" onSubmit="return validate(this)">
                    <input type="hidden" name="submitForm" value="yes" />
                    <input type='hidden' name='cid' id='cid'    value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                  
                  <!-- /.form group -->
                  <div class="form-group">
                    <label>Vehicle Brand<i>*</i></label>
                    <select name="brandName" class="form-control input-sm select2" style="width: 100%" id="brandName">
                        <option label="" value="">Select Model</option>
                        <?php $Country=mysql_query("SELECT `id`, `brandName` FROM `vehiclebrand` ORDER BY `brandName`");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['brandId']) && $resultCountry['id']==$result['brandId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['brandName'])); ?></option>
                        <?php } ?> 
                    </select>
                  </div>
                  <!-- /.form group -->

                  <!-- /.form group -->
                  <div class="form-group">
                    <label>Vehicle Model<i>*</i></label>
                    <input name="model" id="model" type="text" class="form-control" value="<?php if(isset($result['modelName'])) echo $result['modelName']; ?>"/>
                  </div>
                  <!-- /.form group -->
                  <div class="form-group">
                    <input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
                    <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
                    <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_vehicle_model.php?token=<?php echo $token ?>'"/>
                  </div> <!-- form-group -->
                </form>
              </div>
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