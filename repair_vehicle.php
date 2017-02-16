<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php");
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ){
  session_destroy();
  header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']==''){
  session_destroy();
  header("location: index.php?token=".$token);
}
$error =0;
if(isset($_REQUEST['organization'])){
    $technician = mysql_real_escape_string($_POST['technician']);
    $ticketId = mysql_real_escape_string($_POST['ticketId']);
    $organization = mysql_real_escape_string($_POST['organization']);
    $vehicleNo = mysql_real_escape_string($_POST['vehcileNo']);
    $oldmobileNo = mysql_real_escape_string($_POST['oldmobileNo']);
    $olddeviceId = mysql_real_escape_string($_POST['olddeviceId']);
    $repairType = mysql_real_escape_string($_POST['repairType']);
    $mobileNo = mysql_real_escape_string($_POST['mobileNo']);
    $deviceId = mysql_real_escape_string($_POST['deviceId']);
    $oldModal = mysql_real_escape_string($_POST['oldModal']);
    $newModal = mysql_real_escape_string($_POST['newModal']);
    $reason = mysql_real_escape_string($_POST['reason']);
    $repairCategory = mysql_real_escape_string($_POST['repairCategory']);
    $punchBy = $_SESSION['user_id'];
}
if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
  if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
    $sql = "update tempvehicledatarepair set customerId='$organization', 
            techinicianId = '$technician', oldMobileId='$oldmobileNo', 
            oldDeviceId = '$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
            repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo', 
            reason = '$reason', repairCategory = '$repairCategory', vehicleId = '$vehicleNo',
            modify_by = '$punchBy' 
            where id=" .$_REQUEST['id'];
    mysql_query($sql);
    $msg = 'Vehicle updated successfully';
    sendConfigSms($model, $mobile_no, '');
    // header("location:daily_installation.php?token=".$token);
    exit();
  }
  else{
    if($mobileNo != NULL && $deviceId == NULL){
      $returnCode = 1;
    }
    elseif ($mobileNo == NULL && $deviceId != NULL){
      $returnCode = 2;
    }
    elseif ($mobileNo != NULL && $deviceId != NULL) {
      $returnCode = 3;
    }
    else{
      $returnCode = 4;
    }
    switch($returnCode) {
            // if change mobile Number
            case 1:
            $query = "insert into tempvehicledatarepair set customerId='$organization', 
                      techinicianId ='$technician', oldMobileId='$oldmobileNo', 
                      oldDeviceId='$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
                      repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo', 
                      reason = '$reason', repairCategory = '$repairCategory', vehicleId = '$vehicleNo',
                      create_by = '$punchBy'";
           /* echo $query;*/
            $sql = mysql_query($query);
            $msg ='Repair Vehicle Successfully';
            sendConfigSms($oldModal, $mobileNo, '');
            // header("location:daily_installation.php?token=".$token);
            break;

            // if change device
            case 2:
              $query = "insert into tempvehicledatarepair set customerId='$organization', 
                        techinicianId ='$technician', oldMobileId='$oldmobileNo', 
                        oldDeviceId='$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
                        repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo',
                        reason = '$reason', repairCategory = '$repairCategory', vehicleId = '$vehicleNo',
                        create_by = '$punchBy'";
              /*echo $query;*/
              $sql = mysql_query($query);
              $msg = 'Repair Vehicle Successfully';
              sendConfigSms($newModal, $oldmobileNo, '');
              // header("location:daily_installation.php?token=".$token);
              break;
             
            // if change mobile number and device
            case 3:
              $query = "insert into tempvehicledatarepair set customerId='$organization', 
                        techinicianId ='$technician', oldMobileId='$oldmobileNo', 
                        oldDeviceId='$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
                        repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo', 
                        reason = '$reason', repairCategory = '$repairCategory', vehicleId = '$vehicleNo',
                        create_by = '$punchBy'";
             /* echo $query;*/
              $sql = mysql_query($query);
              $msg ='Repair Vehicle Successfully';
              sendConfigSms($newModal, $mobileNo, '');
              // header("location:daily_installation.php?token=".$token);
              break;

            // if old mobile number
            case 4:
              $query = "insert into tempvehicledatarepair set customerId='$organization', 
                        techinicianId ='$technician', oldMobileId='$oldmobileNo', 
                        oldDeviceId='$olddeviceId', repairDate=Now(), ticketId='$ticketId', 
                        repairType='$repairType', newDeviceId='$deviceId', newMobileId='$mobileNo', 
                        reason = '$reason', repairCategory = '$repairCategory', vehicleId = '$vehicleNo',
                        create_by = '$punchBy'";
              /*echo $query;*/
              $sql = mysql_query($query);
              /*echo "<script> alert('Vehicle added successfully'); </script>";*/
              $msg ='Repair Vehicle Successfully';
              sendConfigSms($oldModal, $oldmobileNo, '');
              // header("location:daily_installation.php?token=".$token);
              break;
        }
      
    }

}
if(isset($_REQUEST['id']) && $_REQUEST['id'])
  {
    $queryArr=mysql_query("SELECT * FROM tempvehicledatarepair WHERE id =".$_REQUEST['id']);
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
        Repair Vehicle
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Repair Vehicle</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <div class="box-header">
              <!-- <h3 class="box-title">Add</h3> -->
            </div>
            <div class="box-body">
            <div class="small-form">
            <?php if(isset($msg) && $msg !="") {?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?= $msg;?>
            </div>
            <?php 
            }
            ?>
            <div class="col-md-12">
              <form name='myform' action="" id = "myform" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
                <input type="hidden" name="submitForm" value="yes" />
                <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                <div class="form-group">
                  <label for="Mobile">Techician&nbsp;Name <span class="red">*</span></label>
                  <select name="technician" id="technician" class="form-control select2" style="width: 100%">
                    <option value="">Select Techician</option>
                    <?php 
                    $userId = $_SESSION['user_id'];
                    if($userId == 1 || 15 || 17){
                    $technician = mysql_query("select * from tbluser where (User_Category=5 or User_Category=8) 
                                  Order By First_Name");  
                    }
                    else{
                    $technician = mysql_query("select * from tbluser where (User_Category=5 or User_Category=8) 
                                  and id =".$userId);
                    
                    }
                    while($resulttechnician=mysql_fetch_assoc($technician)){
                    ?>
                    <option value="<?php echo $resulttechnician['id']; ?>">
                    <?php echo $resulttechnician['First_Name']." ".$resulttechnician['Last_Name'];?>
                    </option>
                    <?php } ?>
                 </select>
                </div> <!-- end form-group -->   
                <div class="form-group">
                  <label for="Product">Ticket Id <span class="red">*</span></label>
                    <span id="divTicketId">
                      <select name="ticketId" id="ticketId" class="form-control select2 ticket" style="width: 100%">
                        <option value="">Select Ticket Id</option>
                      </select>
                    </span>
                </div> <!-- end form-group --> 
                <div id="divOrgranization" >
                  <div class="form-group">
                      <label for="provider">Organization*</label>
                      <span id="divOrgranization">
                        <select name="organization" id="organization" class="form-control select2" style="width:100%">
                          <option value="">Select Organization</option>
                        </select>
                      </span>
                  </div>
                   <div class="form-group">
                      <label for="vehicleNo">Vehicle No.</label>
                      <span id="divOrgranization">
                        <select name="vehicle" id="vehicle" class="form-control select2" style="width: 100%">
                          <option value="">Select Vehicle No.</option>
                        </select>
                      </span>
                  </div>  
                </div> <!-- end divOrgranization  -->   
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
                  </div>
                </div>  <!-- end service_provider  -->  
                <div id="divOldmobile">
                  <div class="form-group">
                    <label for="dateofpurchase">Old Mobile <span class="red">*</span></label>
                    <span id="divMobile">
                      <select name="oldmobileNo" id="oldmobileNo" class="form-control select2" style="width: 100%">
                          <option value="">Select Mobile</option>
                      </select> 
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="dateofpurchase">Old Device&nbsp;Id <span class="red">*</span></label>
                    <span id="divDevice">
                      <select name="olddeviceId" id="olddeviceId" class="form-control select2" style="width: 100%">
                        <option value="">Select Device</option>
                      </select>
                    </span>
                  </div> 
                </div><!--  end divOldmobile -->
                <div id="oldModal">
                  <!-- Show Old Device Modal from ajax page --> 
                </div> <!-- end oldModal -->
                <div class="form-group">
                    <label for="repairType">Repair&nbsp;Type <span class="red">*</span></label>
                    <select name="repairType" id="repairType" class="form-control select2" style="width: 100%">
                      <option value="">Select Repair Type</option>
                      <option value="1">Sim</option>
                      <option value="2">Device</option>
                      <option value="3">Both</option>
                      <option value="4">Battery Disconect</option>
                    </select>
                </div>
                <div id="divShowRepair">
                </div><!-- end divShowRepair -->
                <div id="newModal"> 
                <!-- Show Device modal from ajax page -->
                </div> <!-- end newModal -->
                <div class="form-group">
                  <label for="reason">Reason<span class="red">*</span></label>
                  <select name="reason" id="reason" class="form-control select2" style="width: 100%">
                    <option value="">Select Reason</option>
                    <option value="Wire Cut">Wire Cut</option>
                    <option value="Feuj">Feuj</option>
                    <option value="Mobile Registration Fail">Mobile Registration Fail</option>
                    <option value="Data not Availble">Data not Availble</option>
                    <option value="Device Not Responding">Device Not Responding</option>
                    <option value="Device battery Dead">Device battery Dead</option>
                  </select>
              </div> <!-- end form-group -->
              <div class="form-group">
                <label for="reason">Repair Category<span class="red">*</span></label>
                <select name="repairCategory" id="repairCategory" class="form-control select2" style="width: 100%">
                  <option value="">Select Category</option>
                  <option value="Client Side">Client Side</option>
                  <option value="Our Side">Our Side</option>
                </select>
              </div><!-- end form-group -->
              <input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
              <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
              <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back" 
                onclick="window.location='manage_vehicle.php?token=<?php echo $token ?>'"/>
              </form>
              </div> <!-- end col-md-12 -->
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