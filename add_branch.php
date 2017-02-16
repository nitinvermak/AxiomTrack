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
if(isset($_REQUEST['company_name'])){
  $company_name = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['company_name'])));
  $country = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['country'])));
  $state = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['state'])));
  $district = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['district'])));
  $city = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['city'])));
  $area = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['area'])));
  $pin_code = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['pin_code'])));
  $company_address=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['address'])));
  $company_person=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['contact_person'])));
  $company_contact=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['contact_no'])));
  $company_type=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['company_type'])));
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
  if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
  $sql="update tblbranch set CompanyName='$company_name', Country = '$country', State = '$state', District_ID = '$district', city = '$city', Area = '$area', pincode = '$pin_code', Address='$company_address', contact_Person='$company_person', contact_no='$company_contact', branchtype='$company_type' where id=" .$_REQUEST['id'];
  mysql_query($sql);
  $_SESSION['sess_msg'] = 'Branch updated successfully';
  header("location:manage_branch.php?token=".$token);
  exit();
}
else{
  $queryArr = mysql_query("select * from tblbranch where CompanyName ='$company_name'");
  if(mysql_num_rows($queryArr)<=0){
  $query=mysql_query("insert into tblbranch set CompanyName='$company_name', Country = '$country', 
                      State = '$state', District_ID = '$district', city = '$city', Area = '$area', 
                      pincode = '$pin_code', Address='$company_address', contact_Person='$company_person', 
                      contact_no='$company_contact', branchtype='$company_type'");
  $_SESSION['sess_msg']='Branch added successfully';
  header("location:manage_branch.php?token=".$token);
  exit();
  }
  else{
    $msgDanger ="Branch already exists";
  }
}
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
$queryArr=mysql_query("select * from tblbranch where id =".$_REQUEST['id']);
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
<script src="assets/bootstrap/js/jquery.cookie.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/manage_branch.js"></script>
<script type="text/javascript" src="js/call_state_city_area.js"></script>
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
        Branch
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Branch</li>
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
            <div class="alert alert-danger alert-dismissible small-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msgDanger;?>
            </div>
            <?php 
            }
            ?>
            <div class="small-form"> <!-- small-form -->
              <form name='myform' action="" method="post" onSubmit="return validate(this)">
                <input type="hidden" name="submitForm" value="yes" />
                <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                <div class="form-group">
                  <label>Branch Name<i>*</i></label>
                  <input name="company_name" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['CompanyName']; ?>"/>
                </div>
                <!-- /.form group -->
                <div class="form-group">
                  <label>Country<i>*</i></label>
                    <select name="country" id="country" class="form-control select2" style="width: 100%" 
                      onChange="return CallState(this.value)">
                      <option value="">Select Country</option>
                      <?php $Country=mysql_query("select * from tblcountry");
                            while($resultCountry=mysql_fetch_assoc($Country)){
                      ?>
                      <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['Country']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?></option>
                      <?php } ?>
                    </select>
                </div>
                <!-- /.form group -->
                <div class="form-group">
                  <label>State<i>*</i></label>
                    <span id="Divstate">
                      <select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control select2" style="width: 100%">
                        <option value="">Select State</option>
                        <option value="<?php echo $result['State']; ?>" <?php if(isset($result['id']) && $result['State']==$result['State']){ ?>selected<?php } ?>><?php echo getcity(stripslashes(ucfirst($result['State']))); ?></option>
                      </select>
                    </span>
                </div><!-- /.form group -->
                <div class="form-group">
                  <label>District<i>*</i></label>
                  <span id="divdistrict">
                    <select name="district" id="district"  class="form-control select2" style="width: 100%" 
                    onChange="return CallCity(this.value)">
                      <option value="">Select District</option>
                      <option value="<?php echo $result['District_ID']; ?>" <?php if(isset($result['id']) && $result['District_ID']==$result['District_ID']){ ?>selected<?php } ?>><?php echo getdistrict(stripslashes(ucfirst($result['District_ID']))); ?></option>
                    </select>
                  </span>
                </div><!-- /.form group -->
                <div class="form-group">
                  <label>City<i>*</i></label>
                  <span id="divcity">
                    <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control select2" style="width: 100%" >
                      <option value="">Select City</option>
                      <option value="<?php echo $result['city']; ?>" <?php if(isset($result['id']) && $result['city']==$result['city']){ ?>selected<?php } ?>><?php echo getcityname(stripslashes(ucfirst($result['city']))); ?></option>
                    </select>
                  </span>
                </div><!-- /.form group -->
                <div class="form-group">
                  <label>Area<i>*</i></label>
                  <span id="divarea">
                    <select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control select2" style="width: 100%">
                      <option value="">Select Area</option>
                      <option value="<?php echo $result['Area']; ?>" <?php if(isset($result['id']) && $result['Area']==$result['Area']){ ?>selected<?php } ?>><?php echo getarea(stripslashes(ucfirst($result['Area']))); ?></option>
                    </select>
                  </span>
                </div><!-- /.form group -->
                <div class="form-group">
                  <label>Pincode<i>*</i></label>
                  <span id="divpincode">
                    <input name="pin_code" id="pin_code" class="form-control"  value="<?php if(isset($result['id'])) echo $result['pincode']; ?>" type="text" />
                  </span>
                </div><!-- /.form group -->
                <div class="form-group">
                  <label>Address<i>*</i></label>
                  <textarea name="address" id="address" class="form-control" rows="3" cols="16"><?php if(isset($result['id'])) echo stripslashes($result['Address']); ?></textarea>
                </div><!-- /.form group -->
                <div class="form-group">
                  <label>Contact Person<i>*</i></label>
                  <input name="contact_person" type="text" class="form-control" value="<?php if(isset($result['id'])) echo $result['contact_Person']; ?>"/>
                </div><!-- /.form group -->
                <div class="form-group">
                  <label>Contact No.<i>*</i></label>
                  <input name="contact_no" type="text" class="form-control" value="<?php if(isset($result['id'])) echo $result['contact_no']; ?>"/>
                </div><!-- /.form group -->
                <div class="form-group">
                  <label>Type<i>*</i></label>
                  <select name="company_type" class="form-control select2" style="width: 100%">
                    <option value="">Select Type</option>
                    <?php $company=mysql_query("select * from tblbranchtype");
                          while($resultcompany=mysql_fetch_assoc($company)){
                    ?>
                    <option value="<?php echo $resultcompany['id']; ?>" <?php if(isset($result['id']) && $resultcompany['id']==$result['branchtype']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultcompany['Branchtype'])); ?></option>
                    <?php } ?>
                  </select>
                </div><!-- /.form group -->
                <div class="form-group">
                  <input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
                  <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
                  <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back"onclick="window.location='manage_branch.php?token=<?php echo $token ?>'"/>
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