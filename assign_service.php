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
if(isset($_POST['save']))
  {
    $cust_id = mysql_real_escape_string($_POST['cust_id']);
    $service_branch = mysql_real_escape_string($_POST['service_branch']);
    $service_area_mgr = mysql_real_escape_string($_POST['service_area_mgr']);
    $service_exe = mysql_real_escape_string($_POST['service_exe']);
    $sql = "Insert into tbl_assign_customer_branch set  cust_id = '$cust_id', 
        service_branchId = '$service_branch', service_area_manager = '$service_area_mgr', 
        service_executive = '$service_exe'";
    $query = mysql_query($sql);
    $update = "UPDATE `tbl_customer_master` SET status = '1' Where cust_id=".$_REQUEST['cust_id'];
    // Call User Activity Log function
    UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $update);
    // End Activity Log Function
    /*echo $update;*/
    $change_status = mysql_query($update);
    if($query)
    {
      $_SESSION['sess_msg']='Branch assign successfully';
      header("location:assign_service_branch.php?token=".$token);
    }
  }

if(isset($_REQUEST['cust_id']) && $_REQUEST['cust_id']){
    $queryArr=mysql_query("SELECT A.cust_id, A.calling_product, B.Company_Name, B.Country, 
                 B.State, B.District_id, B.City, B.Area, B.Address, B.Pin_code, 
                 B.created, A.telecaller_id, C.branch_id
                 FROM tbl_customer_master as A 
                 INNER JOIN  tblcallingdata as B 
                 ON A.callingdata_id = B.id
                 INNER JOIN tblassign as C 
                 ON A.telecaller_id = C.telecaller_id 
                 WHERE A.cust_id =".$_REQUEST['cust_id']);
    $result=mysql_fetch_assoc($queryArr);
}
/*if(isset($_REQUEST['id']) && $_REQUEST['id'])
  {
    $queryArr=mysql_query("SELECT * FROM tbl_assign_customer_branch WHERE service_branchId =".$_REQUEST['id']);
    $result=mysql_fetch_assoc($queryArr);
  }*/
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
<script>
function validate(obj)
{
  if(obj.service_branch.value == "")
  {
    alert('Please Select Serivce Branch');
    obj.service_branch.focus();
    return false;
  }
  if(obj.service_area_mgr.value == "")
  {
    alert("Please Select Service Area Manager");
    obj.service_area_mgr.focus();
    return false;
  }
  if(obj.service_exe.value == "")
  {
    alert('Please Select Service Executive');
    obj.service_exe.focus();
    return false;
  }
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
              <form name='myform' action="" method="post" onSubmit="return validate(this)">
                <input type="hidden" name="submitForm" value="yes" />
                <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['cust_id']) and $_GET['cust_id']>0){ echo $_GET['cust_id']; }?>"/>
                <input type="hidden" name="device_id" id="device_id" value="<?php $query = mysql_query("select device_id from tbldeviceid")?>"/>
                <div class="form-group form_custom col-md-12"><!-- form_custom -->
                  <div class="row"> <!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Customer Id <i>*</i></span>
                      <input type="text" name="cust_id" id="cust_id" class="form-control" value="<?php if(isset($result['cust_id'])) echo $result['cust_id'];?>" readonly>
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Customer Name <i>*</i></span>
                      <input type="text" name="customer_name" id="customer_name" value="<?php if(isset($result['cust_id'])) echo $result['Company_Name'];?>" class="form-control" readonly>
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Country <i>*</i></span>
                      <input type="text" name="country" id="country" value="<?php if(isset($result['cust_id'])) echo getcountry($result['Country']);?>" class="form-control" readonly>
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>State <i>*</i></span>
                      <input type="text" name="state" id="state" value="<?php if(isset($result['cust_id'])) echo getstate($result['State']);?>" class="form-control" readonly>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>District <i>*</i></span>
                      <input type="text" name="district" id="district" value="<?php if(isset($result['cust_id'])) echo getdistrict($result['District_id']);?>" class="form-control" readonly>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>City <i>*</i></span>
                      <input type="text" name="city" id="city" value="<?php if(isset($result['cust_id'])) echo getcities($result['City']);?>" class="form-control" readonly>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Area <i>*</i></span>
                      <input type="text" name="customer_name8" id="customer_name8" value="<?php if(isset($result['cust_id'])) echo getarea($result['Area']);?>" class="form-control" readonly>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Address <i>*</i></span>
                      <textarea class="form-control txt_area" name="address" readonly><?php if(isset($result['cust_id'])) echo $result['Address'];?></textarea>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Pincode <i>*</i></span>
                      <input type="text" name="Pin_code" id="Pin_code" value="<?php if(isset($result['cust_id'])) echo getpincode($result['Pin_code']);?>" class="form-control text_box" readonly>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Activation Date <i>*</i></span>
                      <input type="text" name="createdate" id="createdate" value="<?php if(isset($result['cust_id'])) echo $result['created'];?>" class="form-control" readonly>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Lead Gen. Exe. <i>*</i></span>
                      <input type="text" name="customer_name2" id="customer_name2" value="<?php if(isset($result['cust_id'])) echo gettelecallername($result['telecaller_id']);?>" class="form-control" readonly>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Lead Gen. Branch<i>*</i></span>
                      <input type="text" name="branch_id" id="branch_id" value="<?php if(isset($result['cust_id'])) echo getBranch($result['branch_id']);?>" class="form-control" readonly>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Serivce Branch<i>*</i></span>
                      <select name="service_branch" id="service_branch" class="form-control drop_down select2" 
                        style="width: 100%">
                          <option value="">Select Techician</option>
                          <?php $Country=mysql_query("select * from tblbranch");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['CompanyName']) && $resultCountry['id']==$result['CompanyName']){ ?>selected<?php } ?>>
                          <?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                          <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Service Area Mgr.<i>*</i></span>
                      <select name="service_area_mgr" id="service_area_mgr"  class="form-control drop_down select2" style="width: 100%">
                        <option value="">Select Techician</option>
                        <?php $Country=mysql_query("select * from tbluser where User_Category='9'");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['service_area_manager']) && $resultCountry['id']==$result['service_area_manager']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Service Executive<i>*</i></span>
                      <select name="service_exe" id="service_exe"  class="form-control drop_down select2" 
                      style="width: 100%">
                        <option value="">Select Techician</option>
                        <?php $Country=mysql_query("select * from tbluser");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['service_area_manager']) && $resultCountry['id']==$result['service_area_manager']){ ?>selected<?php } ?>>
                        <?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="clearfix"></div>
                    <div class="col-lg-6 col-sm-6 custom_field">
                      <input type="submit" name="save" id="save" value="Submit" class="btn btn-primary btn-sm">
                    </div>
                  </div> <!-- end row -->
                </div> <!-- end form_custom -->
              </form>
            </div> <!-- end contacform -->
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