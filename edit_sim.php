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
$error =0;
if(isset($_REQUEST['provider']))
{
$provider=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['provider'])));
$sim=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['sim'])));
$mobile=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['mobile'])));
$plan=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan'])));
$date_of_purchase=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['date'])));
$state_name=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['state_id'])));
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tblsim set company_id='$provider', sim_no='$sim', mobile_no='$mobile', plan_categoryid='$plan', date_of_purchase='$date_of_purchase', state_id='$state_name' where id=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='Sim updated successfully';
header("location:manage_sim.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tblsim where company_id='$provider' and sim_no='$sim' and mobile_no='$mobile' and plan_categoryid='$plan' and date_of_purchase='$date_of_purchase'");
//$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tblsim set company_id='$provider', sim_no='$sim', mobile_no='$mobile', plan_categoryid='$plan', date_of_purchase='$date_of_purchase'");
$_SESSION['sess_msg']='Sim added successfully';
header("location:manage_sim.php?token=".$token);
exit();
}
else
{
$msg="City already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblsim where id =".$_REQUEST['id']);
$result=mysql_fetch_assoc($queryArr);
$datasource=$result['City'];
$state_name=$result['City'];
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
<body class="hold-transition skin-blue sidebar-mini" onLoad="checkDefault()">
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once("includes/header.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Sim
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Sim</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <div class="box-header">
              <!-- <h3 class="box-title">Import Device</h3> -->
            </div>
            <div class="box-body">
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
            <div class="small-form"> <!-- small-form -->
              <form name='myform' action="" method="post" onSubmit="return validate(this)">
                <input type="hidden" name="submitForm" value="yes" />
                <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                <div class="form-group">
                  <label>Provider<i>*</i></label>
                  <select name="provider" id="provider" class="form-control drop_down select2" style="width: 100%">
                    <option value="">Select Provider</option>
                    <?php $Country=mysql_query("select * from tblserviceprovider");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['company_id']) && $resultCountry['id']==$result['company_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?></option>
                    <?php } ?>
                  </select>
                </div>
                <!-- /.form group -->
                <div class="form-group">
                  <label>Sim<i>*</i></label>
                  <input name="sim" id="sim" class="form-control" type="text" value="<?php if(isset($result['id'])) echo $result['sim_no'];?>" />
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <label>Mobile<i>*</i></label>
                  <input type="text" name="mobile" class="form-control" id="mobile" value="<?php if(isset($result['id'])) echo $result['mobile_no'];?>" />
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <label>Plan<i>*</i></label>
                  <select name="plan" id="plan" class="form-control drop_down select2" style="width: 100%">
                    <option value="">Select Plan</option>
                    <?php $Country=mysql_query("select * from tblplan");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['plan_categoryid']) && $resultCountry['id']==$result['plan_categoryid']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
                  </select>
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <label>Date of Purchase<i>*</i></label>
                  <input name="date" id="date_of_purchase" class="form-control drop_down" value="<?php if(isset($result['id'])) echo $result['date_of_purchase'];?>" type="text" />
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <label>State<i>*</i></label>
                  <select name="state_id" id="state_id" class="form-control drop_down select2" style="width: 100%">
                    <option value="">Select State</option>
                    <?php $Country=mysql_query("select * from tblstate");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['State_id']; ?>" <?php if(isset($result['state_id']) && $resultCountry['State_id']==$result['state_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
                    <?php } ?>
                  </select>
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
                  <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>                        
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