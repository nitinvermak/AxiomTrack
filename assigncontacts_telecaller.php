<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ){
  session_destroy();
  header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') {
  session_destroy();
  header("location: index.php?token=".$token);
}
if(count($_POST['linkID'])>0){         
  $dsl="";
  if(isset($_POST['linkID']) &&(isset($_POST['submit']))){
    foreach($_POST['linkID'] as $chckvalue){
      $telecaller=$_POST['telecaller'];
      $createdby=$_SESSION['user_id'];
      $sql="Update tblassign set telecaller_id='$telecaller', telecaller_assign_status='1' where id='{$chckvalue}'";
      $results = mysql_query($sql);
      if($results){
        $msg = "Lead Assign Successfully !";
      }
    }
  }  
  $id="";
}
//Remove Assign Contact
if(isset($_POST['remove'])){         
  $dsl="";
  if(isset($_POST['linkID'])){
    foreach($_POST['linkID'] as $chckvalue){
      $sql = "delete from tblassign where callingdata_id='$chckvalue'";
      /*echo $sql;*/
      $results = mysql_query($sql) or die(mysql_error());   
      if($results){
        $msgDanger = "Lead Remove Successfully !";
      }
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
<!-- Jquery -->
<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/assign_contacts_telecaller.js"></script>
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
          Lead Assign Executive
          <!--<small>Control panel</small>-->
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Lead Assign Executive</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
          <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Category <i class="red">*</i></span>
                        <select name="callingcat" id="callingcat" class="form-control select2" style="width: 100%">
                          <option label="" value="" selected="selected">Select Category</option>
                          <option value="0">All Category</option>
                          <?php $Country=mysql_query("select DISTINCT callingcategory_id from  tblassign 
                                                      where status_id ='2'");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['callingcategory_id']; ?>" >
                            <?php echo getCallingCategory(stripslashes(ucfirst($resultCountry['callingcategory_id']))); ?>
                          </option>
                          <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Executive <i class="red">*</i></span>
                        <select name="telecaller" id="telecaller" class="form-control select2" style="width: 100%">
                          <option label="" value="" selected="selected">Select Executive</option>
                          <?php $Country=mysql_query("select * from tbluser order by First_Name ASC");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['id']; ?>" >
                            <?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?>
                          </option>
                          <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field">
                      <input type="button" name="assign_device" class="btn btn-primary btn-sm" onClick="return ShowbyCategory()" value="Assign Contact" />
                      <input type="button" name="view_device" value="View Assigned" class="btn btn-primary btn-sm" onClick="return ShowbyAssignContacts()" />
                    </div>
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
                <div id="divassign" class="table-responsive">
                  <!--Ajaxrequest-->
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
</script>
</body>
</html>