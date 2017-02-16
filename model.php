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
if(isset($_REQUEST['device_company']))
{
  $device_company=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['device_company'])));
  $device_model=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['device_name'])));
  $dateofpurchase=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['date_of_purchase'])));
  $dealername=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['dealer_name'])));
  $imei_no=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['imei_no'])));
  $price=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['price'])));
  session_set_cookie_params(3600,"/");
  session_start();
  $_SESSION['dealer_name'] = $device_company;
  $_SESSION['devicecompany'] = $device_company;
  $_SESSION['devicemodel'] = $device_model;
  if(count($_POST['linkassc'])>0)
  {
    for($i=0; $i<count($_POST['linkassc']); $i++)
    {
      $accessories.=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['linkassc'][$i]))).",";
    }
      $accessories=substr($accessories,0,strlen($accessories)-1);
  }
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
    if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
    $sql="update tbl_device_master set company_id='$device_company', device_name='$device_model', imei_no='$imei_no', date_of_purchase='$dateofpurchase', dealer_id='$dealername', price='$price',accessories_id='$accessories' where id=".$_REQUEST['id'];
    // echo $sql;
    mysql_query($sql);
    $_SESSION['sess_msg']='Model updated successfully';
    header("location:manage_model.php?token=".$token);
    exit();
}
else{
    $queryArr=mysql_query("select * from tbl_device_master where imei_no='$imei_no'");
    if(mysql_num_rows($queryArr)<=0)
    {
      $query ="insert into tbl_device_master set company_id='$device_company', device_name='$device_model', imei_no='$imei_no', date_of_purchase='$dateofpurchase', dealer_id='$dealername', price='$price',accessories_id='$accessories'";
      // echo $query;
      $result =  mysql_query($query);
      $id = "<strong>Device Id :</strong>".mysql_insert_id();
    }
    else
    {
      $msg="IMEI No. already exists";
    }
  }
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
  $queryArr=mysql_query("select * from tbl_device_master where id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/manage_import_device.js"></script>
<script>
$(function() {
  $( "#date_of_purchase" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<script type="text/javascript">

function check()
{
  dealer_name = document.getElementById("dealer_name").value;
  device_company = document.getElementById("device_company").value;
  device_name = document.getElementById("device_name").value; 
  date_of_purchase = document.getElementById("date_of_purchase").value;
  price = document.getElementById("price").value;
  linkassc = document.getElementById("linkassc").value;

  jQuery.cookie("dealer_name",dealer_name);
  jQuery.cookie("device_company",device_company);
  jQuery.cookie("device_name",device_name);
  jQuery.cookie("date_of_purchase",date_of_purchase);
  jQuery.cookie("price",price);
  jQuery.cookie("linkassc",linkassc);
  
  
  //alert(jQuery.cookie("dealer_name"));
}

function checkDefault(){
  if ( !(typeof $.cookie('dealer_name') === 'undefined') ) {
  
    document.getElementById("dealer_name").value =jQuery.cookie("dealer_name") ;
    document.getElementById("device_company").value = jQuery.cookie("device_company");
    document.getElementById("device_name").value= jQuery.cookie("device_name"); 
    document.getElementById("date_of_purchase").value =jQuery.cookie("date_of_purchase") ;
    document.getElementById("price").value = jQuery.cookie("price");
    document.getElementById("linkassc").value= jQuery.cookie("linkassc"); 
  }
}

function deleteCok(){
  jQuery.removeCookie("dealer_name") ;
  jQuery.removeCookie("device_company");
  jQuery.removeCookie("device_name");
  jQuery.removeCookie("date_of_purchase") ;
  jQuery.removeCookie("price");
  jQuery.removeCookie("linkassc");
  alert("Values Removed");

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
        Import Device
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Import Device</li>
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
                <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                <input type="hidden" name="device_id" id="device_id" value="<?php $query = mysql_query("select device_id from tbldeviceid")?>"/>
                <!-- Color Picker -->
                <div class="form-group">
                  <label>Dealer Company Name<i>*</i></label>
                  <select name="dealer_name" id="dealer_name" class="form-control select2" style="width: 100%">
                    <option value="">Select Dealer</option>
                    <?php 
                    $Country=mysql_query("select * from tbldealer");
                    while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['dealer_id']) && $resultCountry['id']==$result['dealer_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Company_Name'] )); ?></option>
                    <?php 
                      } 
                    ?>
                  </select>
                </div>
                <!-- /.form group -->
                <div class="form-group">
                  <label>Device Company<i>*</i></label>
                    <select name="device_company" id="device_company" class="form-control select2" style="width: 100%">
                      <option value="">Select Company</option>
                      <?php 
                      $Country=mysql_query("select * from tbldevicecompany");
                      while($resultCountry=mysql_fetch_assoc($Country)){
                      ?>
                      <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['company_id']) && $resultCountry['id']==$result['company_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['name'])); ?></option>
                      <?php 
                        } 
                      ?>
                    </select>
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <label>Device Model<i>*</i></label>
                    <select name="device_name" id="device_name" class="form-control select2" style="width: 100%">
                      <option value="">Select Model</option>
                      <?php 
                      $Country=mysql_query("select * from tbldevicemodel");
                      while($resultCountry=mysql_fetch_assoc($Country)){
                      ?>
                      <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($result['device_name']) && $resultCountry['device_id']==$result['device_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                      <?php 
                        } 
                      ?>
                    </select>
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <label>Date of Purchase<i>*</i></label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="date_of_purchase" class="form-control pull-right datepicker" id="date_of_purchase" value="<?php if(isset($result['id'])) echo $result['date_of_purchase'];?>">
                  </div>
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <label>Price<i>*</i></label>
                  <input type="text" name="price" id="price" class="form-control" value="<?php if(isset($result['id'])) echo $result['price'];?>" />
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <label>Accessrories<i>*</i></label>
                  <div>
                  <?php $accessories=mysql_query("select * from tblaccessories");
                  while($aces=mysql_fetch_assoc($accessories)){
                  ?>
                  <input type="checkbox" name="linkassc[]" id="linkassc" value="<?php echo $aces['name']; ?>" <?php if(isset($result['id']) && strpos($result['accessories_id'],$aces['name'])) { ?>checked <?php } ?>/> <strong><?php echo $aces['name']; ?></strong> <br  />
                  <?php 
                    } 
                  ?>
                  </div>
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <label>IMEI No.<i>*</i></label>
                  <input type="text" name="imei_no" id="imei_no" class="form-control" value="<?php if(isset($result['id'])) echo $result['imei_no'];?>" />
                </div>
                <!-- /.form group -->
                <!-- /.form group -->
                <div class="form-group">
                  <input type='submit' name='submit' class="btn btn-primary btn-sm" value="Submit" onClick="check();"/>
                  <input type='reset' name='reset' class="open btn btn-primary btn-sm" value="Reset"  onClick="deleteCok();"/>        
                  <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" 
                  onclick="window.location='manage_model.php?token=<?php echo $token ?>'; deleteCok();"/>
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