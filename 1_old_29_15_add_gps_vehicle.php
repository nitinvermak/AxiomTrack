<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
include("includes/simpleimage.php");
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
  session_destroy();
  header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') {
  session_destroy();
  header("location: index.php?token=".$token);
}
$error =0;
if(isset($_REQUEST['organization'])){
  $organization = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['organization'])));
  $customer_branch = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['customer_branch'])));
  $vehicle_no = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['vehicle_no'])));
  $vehicle_odo_meter = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['vehicle_odo_meter'])));
  $technician = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['technician'])));
  $mobile_no = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['mobile_no'])));
  $device = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['device'])));
  $imei = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['imei'])));
  $model = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['model'])));
  $server_details = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['server_details'])));
  $insatallation_date = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['insatallation_date'])));
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
  if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
    $sql="update tbl_gps_vehicle_master set customer_Id='$organization', 
          customer_branch='$customer_branch', vehicle_no='$vehicle_no', 
          vehicle_odometer='$vehicle_odo_meter', techinician_name='$technician', 
          mobile_no='$mobile_no', device_id='$device', imei_no='$imei', 
          model_name='$model', server_details='$server_details', 
          installation_date='$insatallation_date'  where id=" .$_REQUEST['id'];
    mysql_query($sql);
    /*echo $sql;*/
    $update_sim = "update tblsim set status_id='1' where id='$mobile_no'";
    /*echo $update_sim;*/
    $querysim = mysql_query($update_sim);   
    $update_Device = "update tbl_device_master set status = '1' where id='$device'";
    /*echo $update_Device;*/
    $queryex = mysql_query($update_Device);
    $msg = 'Vehicle updated successfully';
    // header("location:old_edi_gps_vehicle.php?token=".$token);
    exit();
  }
  else{
    $query=mysql_query("insert into tbl_gps_vehicle_master set customer_Id='$organization',
                        customer_branch='$customer_branch', vehicle_no='$vehicle_no', 
                        vehicle_odometer='$vehicle_odo_meter', techinician_name='$technician', 
                        mobile_no='$mobile_no', device_id='$device', imei_no='$imei', 
                        model_name='$model', server_details='$server_details', 
                        installation_date='$insatallation_date', 
                        paymentActiveFlag='N'");    
    $update_sim = "update tblsim set status_id='1' where id='$mobile_no'";
    echo $update_sim;
    $querysim = mysql_query($update_sim);   
    $update_Device = "update tbl_device_master set status = '1' where id='$device'";
    echo $update_Device;
    $queryex = mysql_query($update_Device);
    $msg = 'Vehicle added successfully';
    // header("location:old_edi_gps_vehicle.php?token=".$token);
      exit();
    }
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
  $queryArr=mysql_query("SELECT * FROM tbl_gps_vehicle_master WHERE id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/add_old_gps.js"></script>
<!--end-->
<script type="text/javascript">
$(document).ready(function(){
  $("#myform").submit(function(){
    if ($("#technician").val() == "")
    {
      alert("Please Select Technician");
      $("#technician").focus();
      return false;
    }
    else if ($("#ticketId").val() == "")
    {
      alert("Please Select Ticket Id");
      $("#ticketId").focus();
      return false;
    }
    else if ($("#organization").val() == "")
    {
      alert("Please Select Organization");
      $("#organization").focus();
      return false;
    }
    else if ($("#vehicleNo").val() == "")
    {
      alert("Please Select Vehicle No.");
      $("#vehicleNo").focus();
      return false;
    }
    else if ($("#oldmobileNo").val() == "")
    {
      alert("Please Select Old Mobile No.");
      $("#oldmobileNo").focus();
      return false;
    }
    else if ($("#olddeviceId").val() == "")
    {
      alert("Please Select Old Device Id");
      $("#olddeviceId").focus();
      return false;
    }
    else if ($("#repairType").val() == "")
    {
      alert("Please Select Repari Type");
      $("#repairType").focus();
      return false;
    }
    else if ($("#mobileNo").val() == "")
    {
      alert("Please Select Mobile No");
      $("#mobileNo").focus();
      return false;
    }
    else if ($("#deviceId").val() == "")
    {
      alert("Please Select Device Id");
      $("#deviceId").focus();
      return false;
    }
    else if ($("#reason").val() == "")
    {
      alert("Please Provide Reason");
      $("#reason").focus();
      return false;
    }
    else if ($("#repairCategory").val() == "")
    {
      alert("Please Provide Repair Category");
      $("#repairCategory").focus();
      return false;
    }
    else
    {
      $(".loader").show();
    }
  });
});
<!-- End processing Image -->

$(document).ready(function(){
    $("#technician").change(function(){
      $.post("ajaxrequest/show_ticket_id.php?token=<?php echo $token;?>",
        {
          technician : $("#technician").val()
        },
          function( data ){
            $("#divTicketId").html(data);
            $(".select2").select2();
        });
    
    });
});

function getOrg()
{
      $.post("ajaxrequest/show_repair_vehicle_details.php?token=<?php echo $token;?>",
        {
          ticket : $("#ticketId").val()
        },
          function( data ){
            $("#divOrgranization").html(data);
            $(".select2").select2();
        });
    
}
// send ajax request when select vehicle no
function getValue()
{
   $.post("ajaxrequest/show_old_mobile_device_id.php?token=<?php echo $token;?>",
        {
          vehicleNo : $("#vehicleNo").val()
        },
          function( data ){
            $("#divOldmobile").html(data);
            $(".select2").select2();
        });
}
//end
// Select Old Modal
function getOldDeviceModal()
{
  $.post("ajaxrequest/device_old_modal_details.php?token=<?php echo $token;?>",
        {
          olddeviceId : $("#olddeviceId").val()
        },
          function( data ){
            $("#oldModal").html(data);
            $(".select2").select2();
        });
}
// End
// send ajax request when select repair type
$(document).ready(function(){
    $("#repairType").change(function(){
      $.post("ajaxrequest/show_repair_type.php?token=<?php echo $token;?>",
        {
          technician : $("#technician option:selected").val(),
          repairType : $("#repairType").val()
        },
          function( data ){
            $("#divShowRepair").html(data);
            $(".select2").select2();
        });
    
    });
});
//End
// send ajax request when select device id
function getNewModal()
{
  $.post("ajaxrequest/device_modal_details.php?token=<?php echo $token;?>",
        {
          deviceId : $("#deviceId").val()
        },
          function( data ){
            $("#newModal").html(data);
            $(".select2").select2();
        });
}
// End
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
        Old Vehicle
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Old Vehicle</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <div class="box-header">
              <h3 class="box-title">Add</h3>
            </div>
            <div class="box-body">
            <?php if(isset($msg) && $msg !="") {?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?= $msg;?>
            </div>
            <?php 
            }
            ?>
              <div class="col-md-12 small-form">
                <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
                  <input type="hidden" name="submitForm" value="yes" />
                  <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                  <div class="form-group">
                    <label for="provider">Organization*</label>
                    <select name="organization" id="organization" class="form-control select2" style="width: 100%">
                      <option value="">Select Organization</option>
                      <?php $Country=mysql_query("SELECT tblcallingdata.Company_Name,tbl_customer_master.cust_id 
                                                  FROM tbl_customer_master 
                                                  INNER JOIN tblcallingdata
                                                  ON tbl_customer_master.callingdata_id = tblcallingdata.id 
                                                  ORDER BY tblcallingdata.Company_Name ASC");
                            while($resultCountry=mysql_fetch_assoc($Country)){
                      ?>
                      <option value="<?php echo $resultCountry['cust_id']; ?>" <?php if(isset($result['customer_Id']) && $resultCountry['cust_id']==$result['customer_Id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>             <?php } ?>
                    </select>
                  </div> <!-- end form-group -->
                  <div class="form-group">
                    <label for="Product">Vehicle No*</label>
                    <input name="vehicle_no" id="vehicle_no" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['vehicle_no']; ?>"/>
                  </div> <!-- end form-group -->
                  <div class="form-group">
                    <label for="Mobile">Techician&nbsp;Name*</label>
                    <span id="statediv">
                    <select name="technician" id="technician" onChange="return ShowMobile();" class="form-control select2" style="width: 100%">
                      <option value="">Select Techician</option>
                      <?php $Country=mysql_query("select * from tbluser where User_Category=5 or User_Category=8");
                            while($resultCountry=mysql_fetch_assoc($Country)){
                      ?>
                      <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['techinician_name']) && $resultCountry['id']==$result['techinician_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ".$resultCountry['Last_Name'])); ?></option>
                      <?php 
                      } 
                      ?>
                    </select>
                  </div><!-- end form-group -->
                  <div id="service_provider" style="display:none">
                    <div class="form-group">
                      <label for="dateofpurchase">Model*</label>
                      <select name="model" id="model" class="form-control select2" style="width: 100%">
                        <option value="">Select Model</option>
                        <?php $Country=mysql_query("select * from tbldevicemodel");       
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($datasource) && $resultCountry['device_id']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                          <?php } ?>
                      </select>
                    </div><!-- end form-group -->
                  </div> <!-- end service_provider -->
                  <div class="form-group">
                    <label for="dateofpurchase">No&nbsp;of&nbsp;Installation*</label>
                    <input type="text" name="no_of_installation" id="no_of_installation"  class="form-control text_box"/>
                  </div><!-- end form-group -->
                  <div class="form-group">
                    <label for="dateofpurchase">Mobile*</label>
                    <select name="mobile_no" id="mobile_no" class="form-control select2" style="width: 100%">
                      <option value="">Select Mobile</option>
                      <option value="<?php echo $result['mobile_no']; ?>" <?php if(isset($result['id']) && $result['mobile_no']==$result['mobile_no']){ ?>selected<?php } ?>><?php echo getMobile(stripslashes(ucfirst($result['mobile_no']))); ?></option>
                    </select> 
                  </div><!-- end form-group -->
                  <div class="form-group">
                    <label for="dateofpurchase">Device&nbsp;Id *</label>
                    <span id="divDevice">
                      <select name="device" id="device" class="form-control drop_down select2" style="width: 100%" onChange="return ShowIMEIandDeviceName();">
                        <option value="">Select Device</option>
                        <option value="<?php echo $result['device_id']; ?>" <?php if(isset($result['id']) && $result['device_id']==$result['device_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['device_id'])); ?></option>
                      </select>
                    </span>
                  </div><!-- end form-group -->
                  <div class="form-group">
                    <label for="dateofpurchase">IMEI No. *</label>
                    <span id="divIMEI">
                      <select name="imei" id="imei" class="form-control select2" style="width: 100%">
                        <option value="">Select IMEI</option>
                        <option value="<?php echo $result['imei_no']; ?>" <?php if(isset($result['id']) && $result['imei_no']==$result['imei_no']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['imei_no'])); ?></option>
                      </select>
                    </span>
                  </div><!-- end form-group -->
                  <div class="form-group">
                    <label for="dateofpurchase">Model&nbsp;Name*</label>
                    <span id="getModel">
                      <select name="model" id="model" class="form-control select2" style="width: 100%">
                        <option value="">Select Model</option>
                        <option value="<?php echo $result['model_name']; ?>" <?php if(isset($result['id']) && $result['model_name']==$result['model_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['model_name'])); ?></option>
                      </select>
                    </span>
                  </div><!-- end form-group -->
                  <div class="form-group">
                    <label for="dateofpurchase">Server&nbsp;Details*</label>
                      <select name="server_details" id="server_details" class="form-control select2" style="width: 100%" onChange="return divshow(this.value)">
                        <option value="">Select Server</option>
                        <option value="vehicletrack.biz">vehicletrack.biz</option>
                        <option value="vts24.com">vts24.com</option>
                        <option value="<?php echo $result['server_details']; ?>" <?php if(isset($result['id']) && $result['server_details']==$result['server_details']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['server_details'])); ?></option>
                      </select>
                  </div><!-- end form-group -->
                  <div class="form-group">
                    <label for="dateofpurchase">Installation&nbsp;Date*</label>
                    <input name="insatallation_date" id="insatallation_date" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['installation_date']; ?>"/>
                  </div><!-- end form-group -->
                  <div class="clearfix"></div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10" style="margin:10px 0px 10px 0px;">
                      <input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
                      <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
                      <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back" 
                      onclick="window.location='manage_old_vehicle.php?token=<?php echo $token ?>'"/>
                    </div>   
                  </div> <!-- end form-group -->
                </form> 
              </div> <!-- end col-md-12 -->
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