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
if (isset($_SESSION) && $_SESSION['user_category_id']!=1) 
{
    header("location: home.php?token=".$token);
}
$error =0;
if(isset($_REQUEST['plan_category']))
  {
    $datasource=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan_name'])));
    $plan_description=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan_description'])));
    $plan_category=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan_category'])));
    $service_provider=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['provider'])));
    $plan_price=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['plan_price'])));
    $taxId = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['exclusive'])));
  }
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes')
{
if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
$sql="update tblplan set planSubCategory ='$datasource', plan_description='$plan_description', productCategoryId='$plan_category', serviceprovider_id='$service_provider', plan_status='A', plan_rate='$plan_price', taxApplicationId = '$taxId' where id=" .$_REQUEST['id'];
mysql_query($sql);
$_SESSION['sess_msg']='Plan updated successfully';
header("location:manage_plan.php?token=".$token);
exit();
}
else{
$queryArr=mysql_query("select * from tblplan where productCategoryId = '$plan_category' and planSubCategory = '$datasource' and plan_rate = '$plan_price'");
$result=mysql_fetch_assoc($queryArr);
 if(mysql_num_rows($queryArr)<=0)
{
$query=mysql_query("insert into tblplan set planSubCategory='$datasource', plan_description='$plan_description', productCategoryId='$plan_category', serviceprovider_id='$service_provider', plan_status='A', plan_rate='$plan_price', taxApplicationId = '$taxId'");
$_SESSION['sess_msg']='Plan added successfully';
header("location:manage_plan.php?token=".$token);
exit();
}
else
{
$msgDanger="Plan already exists";
}
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblplan where id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/manage_plan.js"></script>
<script>
    $(function () {
      $('.ddlCountry').change(function () {
        var catId = ($(this).val());
  /*  alert(catId);*/
    $.post("ajaxrequest/show_plan_name.php?token=<?php echo $token;?>",
        {
          catId : (catId)
        },
          function( data ){
            $("#responseText").html(data);
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
        Plan
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Plan</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <div class="box-header">
              <h3 class="box-title">Add</h3>
            </div>
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
                <form name='myform' action="" method="post"  onsubmit="return validate(this)">
                  <input type="hidden" name="submitForm" value="yes" />
                  <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                  <div class="form-group">
                    <label>Plan Category<i>*</i></label>
                    <select name="plan_category" id="plan_category" class="form-control select2 ddlCountry" 
                    style="width: 100%">
                      <option value="">Select Plan Category</option>
                      <?php $Country=mysql_query("select * from tblplancategory");
                            while($resultCountry=mysql_fetch_assoc($Country)){
                      ?>
                      <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['productCategoryId']) && $resultCountry['id']==$result['productCategoryId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['category'])); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <!-- /.form group -->
                  <div class="form-group">
                    <label>Plan Name<i>*</i></label>
                    <span id="responseText">
                      <input type="text" name="plan_name" id="plan_name" class="form-control" >
                      <?php 
                      if($result['planSubCategory'] > 0){
                      ?>
                      <input type="text" name="plan_name" id="plan_name" class="form-control" value="<?php if(isset($result['id'])) echo $result['planSubCategory'];?>"/>
                      <?php 
                      } 
                      else if($result['serviceprovider_id'] > 0)
                      {
                      ?>
                      <input type="text" name="provider" id="provider" class="form-control" value="<?php if(isset($result['id'])) echo $result['serviceprovider_id'];?>"/>
                      <?php 
                      }
                      ?>
                    </span>
                  </div><!-- /.form group -->
                  <div class="form-group">
                    <label>Description<i>*</i></label>
                    <textarea name="plan_description" id="plan_description" class="form-control"/>
                    <?php if(isset($result['id'])) echo $result['plan_description'];?></textarea>
                  </div>
                  <!-- /.form group -->
                  <div class="form-group">
                    <label>Price<i>*</i></label>
                    <input type="text" name="plan_price" id="plan_price" class="form-control" value="<?php if(isset($result['id'])) echo $result['plan_rate'];?>" />
                  </div>
                  <!-- /.form group -->
                  <div class="form-group">
                    <label>Tax<i>*</i></label>
                    <select name="exclusive" id="exclusive" class="select2 form-control" style="width: 100%">
                      <option value="">Select</option>
                      <option Value="Y">Inclusive</option>
                      <option Value="N">Exclusive</option>
                    </select>
                  </div>
                  <!-- /.form group -->
                  <div class="form-group">
                    <label>Tax<i>*</i></label>
                    <select name="exclusive" id="exclusive" class="select2 form-control" style="width: 100%">
                      <option value="">Select</option>
                      <option Value="Y">Inclusive</option>
                      <option Value="N">Exclusive</option>
                    </select>
                  </div>
                  <!-- /.form group -->
                  <div class="form-group">
                    <input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit"/>
                    <input type='reset' name='reset' class="btn btn-primary btn-sm" value="Reset"/>
                    <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
                    onclick="window.location='manage_plan.php?token=<?php echo $token ?>'"/>
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