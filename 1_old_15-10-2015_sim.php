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
//Save single sim Record
if(isset($_POST['singleSave']))
  {
    $providerCompany = mysql_real_escape_string($_POST['provider']);
    $plan1 = mysql_real_escape_string($_POST['plan1']);
    $state1 = mysql_real_escape_string($_POST['state1']);
    $date = mysql_real_escape_string($_POST['date']);
    $simNo = mysql_real_escape_string($_POST['sim']);
    $mobileNo = mysql_real_escape_string($_POST['mobile']);
    $checkDuplicate = "SELECT * FROM tblsim WHERE mobile_no = '$mobileNo' AND sim_no = '$simNo'";
    $result = mysql_query($checkDuplicate);
    if(mysql_num_rows($result) <= 0){
        $sql = "INSERT INTO tblsim set company_id = '$providerCompany', plan_categoryid = '$plan1', 
                state_id = '$state1', date_of_purchase = '$date', sim_no = '$simNo', mobile_no = '$mobileNo'";
        $resultSql = mysql_query($sql);
        $_SESSION['sess_msg'] = "Sim added Successfully ";
        header("location:manage_sim.php?token=".$token);
    }
    else{
         $msgdanger = "Record already Exist";
    }

  }
//End
// Import CSV file
if(isset($_POST['importFile']))
  {
     $provider2 = mysql_real_escape_string($_POST['provider2']);
     $date2 = mysql_real_escape_string($_POST['date2']);
     $plan2 = mysql_real_escape_string($_POST['plan2']);
     $state3 = mysql_real_escape_string($_POST['state3']);
     $contactfile = $_FILES['contactfile'] ['tmp_name'];
  /* echo $contactfile;*/
     $handle = fopen($contactfile, "r");
   while(($fileOp = fgetcsv($handle, 1000, ",")) !== false)
   {
      $simNo = $fileOp[0];
      $mobileNo = $fileOp[1];
      $sql = "INSERT INTO tblsim set company_id = '$provider2', plan_categoryid = '$plan2', 
              state_id = '$state3', date_of_purchase = '$date2', sim_no = '$simNo', mobile_no = '$mobileNo'";
      // echo $sql;
      $resultSql = mysql_query($sql);
      $_SESSION['sess_msg'] = "Sim Import Successfully ";
      header("location:manage_sim.php?token=".$token);
   }
  }
// End 
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
<script language="javascript" src="js/manage_import_sim.js"></script>
<script language="javascript" src="js/importsimvalidate.js"></script>
<!--Ajax request Call-->
<script  src="js/ajax.js"></script>
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
<script>
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
    //Initialize Select2 Elements
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
        Import Sim
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Import Sim</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row"><!-- row -->
        <div class="col-md-12">
          <label>
            <input type="radio" name="rdopt"  value="Single Contact"  checked="checked" id="single" onClick="singlecontact()" /> Single Sim
            <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="multiplecontact()"/>
                Multiple Sim
          </label>
        </div>
      </div><!-- end row -->
      <div class="box box-info">
          <div class="box-header">
            <!-- <h3 class="box-title">Import</h3> -->
          </div>
          
          <div class="box-body">
          <?php if(isset($msgdanger)){
          ?>
            <div class="alert alert-danger alert-dismissible small-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msgdanger; ?>
            </div>
          <?php  
          }
          ?>
            <div class="col-md-12" id="contactform">
              <form name='myform' action="" class="form-horizontal" method="post" enctype="multipart/form-data" onSubmit="return chkcontactform(this)">
                <input type="hidden" name="submitForm" value="yes" />
                <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                <div class="form-group form_custom col-md-12"><!-- form_custom -->
                  <div class="row"> <!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Provider <i>*</i></span>
                      <select name="provider" id="provider" class="form-control select2" style="width: 100%" onChange="ShowPlans()">
                        <option value="">Select Provider</option>
                        <?php $Country=mysql_query("select * from tblserviceprovider");
                         while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['State_id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?></option>
                        <?php } ?>
                      </select> 
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Plan <i>*</i></span>
                      <span id="showPlan">
                        <select name="plan1" id="plan1" class="form-control select2" style="width: 100%">
                          <option value="">Select Plan</option>
                        </select>
                      </span>
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>State <i>*</i></span>
                      <select name="state1" id="state1" class="form-control select2" style="width: 100%">
                        <option value="">Select State</option>
                        <?php $Country=mysql_query("select * from tblstate");
                           while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['State_id']; ?>" 
                        <?php if(isset($result['state_id']) && $resultCountry['State_id']==$result['state_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
                        <?php } ?>
                      </select>
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Purchase Date <i>*</i></span>
                      <input name="date" id="date" class="form-control date" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Sim No. <i>*</i></span>
                      <input type="text" name="sim" id="sim" class="form-control" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Mobile No. <i>*</i></span>
                      <input name="mobile" id="mobile" class="form-control text_box" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field">
                      <input type="submit" value="Submit" name="singleSave" id="singleSave" class="btn btn-primary btn-sm" />
                      <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='manage_sim.php?token=<?php echo $token ?>'" />
                    </div>
                  </div> <!-- end row -->
                </div> <!-- end form_custom -->
              </form>
            </div> <!-- end contacform -->
            <div id="contactUpload" style="display:none" class="col-md-12"> <!--open of the multiple sim form-->
              <form name="contact1" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return chkupload(this)">
                <div class="form-group form_custom col-md-12"><!-- form_custom -->
                  <div class="row"> <!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Provider <i>*</i></span>
                      <select name="provider2" id="provider2" class="form-control select2" 
                        style="width: 100%" onChange="ShowPlans2()">
                        <option value="">Select Provider</option>
                        <?php $Country=mysql_query("select * from tblserviceprovider");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" 
                        <?php if(isset($result['id']) && $resultCountry['State_id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?></option>
                        <?php } ?>
                      </select>
                    </div><!--  end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Plan <i>*</i></span>
                      <span id="showPlan2">
                        <select name="plan2" id="plan2" class="form-control select2" style="width: 100%">
                          <option value="">Select Plan</option>
                        </select>
                      </span>
                    </div><!--  end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Purchase Date <i>*</i></span>
                      <input name="date2" id="date2" class="form-control date" type="text" />
                    </div><!--  end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>State <i>*</i></span>
                      <select name="state3" id="state3" class="form-control select2" style="width: 100%">
                        <option value="">Select State</option>
                        <?php $Country=mysql_query("select * from tblstate");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['State_id']; ?>" 
                        <?php if(isset($result['state_id']) && $resultCountry['State_id']==$result['state_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?>
                        </option>
                        <?php } ?>
                     </select>
                    </div><!--  end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Upload <i>*</i></span>
                      <input type="file" id="contactfile" name="contactfile"/>
                      <span id="lblError" style="color: red;"></span>
                    </div> <!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <input type="submit" value="Submit" name="importFile" id="importFile" class="btn btn-primary btn-sm" />
                      <input type="button" value="Download Format" name="download" class="btn btn-primary btn-sm" onClick="window.location='Samples/sim_import_format.csv'" />
                      <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='manage_sim.php?token=<?php echo $token ?>'" />
                    </div> <!-- end custom_field -->
                  </div>  <!-- row -->
                </div> <!-- form_custom -->
              </form> 
            </div> <!-- end of the multiple sim form -->
          </div><!-- /.box-body -->
      </div>
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