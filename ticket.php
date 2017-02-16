<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
include("includes/simpleimage.php");
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) 
{
  session_destroy();
  header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') 
{
  session_destroy();
  header("location: index.php?token=".$token);
}

$error =0;

if(isset($_REQUEST['product']))
{
  $product=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['product'])));
  $orgranization=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['orgranization'])));
  $orgranizationType=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['g'])));
  $request=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['request'])));
  $model_id=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['model'])));
  $no_of_installation=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['no_of_installation'])));
  $description=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['des'])));
  $ap_date_time=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['date_time'])));
  $time=htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['time'])));
  $vehicle = htmlspecialchars(mysql_real_escape_string(trim($_POST['vehicle'])));
  $reason = htmlspecialchars(mysql_real_escape_string(trim($_POST['reason'])));
  $create_date=htmlspecialchars(mysql_real_escape_string($_POST['create_date']));
  $userId = $_SESSION['user_id'];
}

if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes'){
  if(isset($_REQUEST['cid']) && $_REQUEST['cid']!=''){
    $sql = "update tblticket set product = '$product', organization_id = '$orgranization', 
            rqst_type='$request', device_model_id='$model_id', no_of_installation='$no_of_installation', 
            description='$description', vehicleId = '$vehicle', repairReason ='$reason', 
            appointment_date='$ap_date_time'), appointment_time='$time', 
            ModifyDate = Now(), ModifyBy = '$userId' 
            where id=" .$_REQUEST['id'];
    echo $sql;
    // Call User Activity Log function
    UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
    // End Activity Log Function
    mysql_query($sql);
    $_SESSION['sess_msg']='Ticket updated successfully';
    header("location:view_ticket.php?token=".$token);
}
else{
    $query = "insert into tblticket set product='$product', organization_id='$orgranization',
              organization_type='$orgranizationType', rqst_type='$request', device_model_id='$model_id', 
              no_of_installation='$no_of_installation', description='$description', 
              vehicleId = '$vehicle', repairReason ='$reason',
              appointment_date='$ap_date_time', createddate=Now(), CreateBy = '$userId'";
    // echo $query;
    // exit();
    mysql_query($query);
    $ticket = mysql_insert_id();
    // Call User Activity Log function
    UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $query);
    // End Activity Log Function
    $_SESSION['sess_msg'] = 'Generated Ticket Id: '.'<span style=font-weight:bold;>'.$ticket.'</span>'. ' Successfully';
    header("location:view_ticket.php?token=".$token);
    exit();
  }
}
if(isset($_REQUEST['id']) && $_REQUEST['id']){
  $queryArr=mysql_query("select * from tblticket where id =".$_REQUEST['id']);
  $result=mysql_fetch_assoc($queryArr);
}
  $query="SELECT * FROM tblcallingcategory";
  $result=mysql_query($query);
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
<script type="text/javascript" src="js/create_ticket.js"></script>
<script type="text/javascript">
// send ajax request for new client
$(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
});
$(document).ready(function(){
  $("#newclient").click(function(){
    $.post("ajaxrequest/ticket_new_customer.php?token=<?php echo $token;?>",
      {
        newClient : $('#newclient').val()
      },
        function( data ){
          $("#divOrgranization").html(data);
          $(".select2").select2();
      });    
  });
});
// end
// send ajax request for existing client
$(document).ready(function(){
  $("#existing").click(function(){
    $.post("ajaxrequest/ticket_existing_customer.php?token=<?php echo $token;?>",
      {
        existingClient : $('#existing').val()
      },
        function( data ){
          $("#divOrgranization").html(data);
          $(".select2").select2();
      });    
  });
});
//end
//send ajax request for product
$(document).ready(function(){
  $("#product").change(function(){
    $.post("ajaxrequest/findrquest.php?token=<?php echo $token;?>",
      {
        productValue : $('#product').val()
      },
        function( data ){
          $("#statediv").html(data);
          $(".select2").select2();
      });    
  });
});
//end
//send ajax request when select organization
function getVehicle()
{
  $.post("ajaxrequest/show_vehicle_no.php?token=<?php echo $token;?>",
      {
        orgranization : $('#orgranization').val()
      },
        function( data ){
          $("#showVehicle").html(data);
          $(".select2").select2();
      }); 
}
//end
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
        New Ticket
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">New Ticket</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <div class="box-header">
              <!-- <h3 class="box-title">New Ticket</h3> -->
            </div>
            <div class="box-body">
            <div class="tkt-form"> <!-- tkt-form  -->
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
          <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
            <input type="hidden" name="submitForm" value="yes" />
            <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
            <div class="radio-inline">
              <label>
                <input type="radio" name="g"  value="New Client"  id="newclient" /> New Client
              </label>
            </div>
            <div class="radio-inline">
              <label>
                <input type="radio" name="g"  value="Existing Client"  id="existing"/>
                  Existing Client
              </label>
            </div>
            <div class="clearfix">&nbsp;</div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="provider" class="col-sm-2 control-label">Organization*</label>
              <div class="col-sm-10" id="divOrgranization">
                <select name="orgranization" id="orgranization" class="form-control select2" style="width: 100%">
                  <option value="">Select Orgranization</option>
                </select>
              </div>
            </div>
            
            <div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Product*</label>
                <div class="col-sm-10">
                <select name="product" id="product" class="form-control select2" style="width: 100%">
                  <option value="">Select Product</option>
                  <?php while ($row=mysql_fetch_array($result)) { ?>
                  <option value=<?php echo $row['id']?>
                  <?php if(isset( $_SESSION['product']) && $row['id']== $_SESSION['product'])
                   { ?>selected<?php } ?>>
                  <?php echo $row['category']?></option>
                  <?php } ?>
                </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Request&nbsp;Type*</label>
                <div class="col-sm-10" id="statediv">
                 <select name="request" id="request"  onchange="return divshow(this.value)" class="form-control select2" style="width: 100%">
                  <option>Select Request Type</option>                              
                 </select>
                </div>
            </div>
            
            <div id="repair" style="display:none;">
                <div class="form-group">
                    <label for="Mobile" class="col-sm-2 control-label">Vehicle&nbsp;No.*</label>
                    <div class="col-sm-10" id="showVehicle">
                     <select name="vehicle" id="vehicle" class="form-control select2" style="width: 100%">
                      <option>Select Vehicle</option>                              
                     </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Reason" class="col-sm-2 control-label">Reason*</label>
                    <div class="col-sm-10" id="statediv">
                     <select name="reason" id="reason"  class="form-control select2" style="width: 100%">
                       <option>Select Reason</option>   
                       <option value="Battery Disconnected">Battery Disconnected</option>
                       <option value="No Reply">No Reply</option>
                       <option value="Re-Installation">Re-Installation</option>
                       <option value="Others">Others</option>
                     </select>
                    </div>
                </div>

            </div>
            
            <div id="service_provider" style="display:none">
             <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Model*</label>
                <div class="col-sm-10">
                    <select name="model" id="model" class="form-control select2" style="width: 100%">
                      <option value="">Select Model</option>
                      <?php $Country=mysql_query("select * from tbldevicemodel");       
                            while($resultCountry=mysql_fetch_assoc($Country)){
                      ?>
                      <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($datasource) && $resultCountry['device_id']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                      <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">No&nbsp;of&nbsp;Instl.*</label>
                <div class="col-sm-10">
                  <input type="text" name="no_of_installation" id="no_of_installation"  class="form-control text_box"/>
                </div>
            </div>
            </div>
          
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Description*</label>
                <div class="col-sm-10">
                  <textarea name="des" id="des" class="form-control txt_area"><?php if(isset($result['id'])) echo $result['description'];?></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Visit&nbsp;Date*</label>
                <div class="col-sm-10">
                  <input name="date_time" id="date_time" class="form-control date" value="<?php if(isset($result['id'])) echo $result['date_time'];?>" type="text"  />
                </div>
            </div>
            
          <!--  <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Appointment&nbsp;Time*</label>
                <div class="col-sm-10">
                 <input name="time" id="time" class="form-control text_box" value="<?php if(isset($result['appointment_time'])) echo $result['appointment_time'];?>" type="text" />
                </div>
            </div>-->
             <div class="clearfix"></div>
             <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="margin:10px 0px 10px 20px;">
                
                  <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary btn-sm" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='view_ticket.php?token=<?php echo $token ?>'" />
                </div>  
                 
        </div> 
            </div>
             </form>
             </div> <!-- end tkt-form -->
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