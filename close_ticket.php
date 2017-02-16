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

$ticket_id = $_GET['ticket_id'];
/*echo "ticket id".$ticket_id;*/
$queryArr=mysql_query("select * from tblticket where ticket_id = '$ticket_id'");
$result=mysql_fetch_assoc($queryArr);

if(isset($_POST['close']))
  {
    $userId = $_SESSION['user_id'];
    $ticket_status = mysql_real_escape_string($_POST['status']);
    $remark = mysql_real_escape_string($_POST['des']);
    $apDate = mysql_real_escape_string($_POST['apDate']);
    /*$close_date = mysql_real_escape_string($_POST['close_date']);*/
    $Update_ticket = "UPDATE tblticket SET ticket_status ='$ticket_status', 
                      ticket_remark = '$remark', close_date = Now(), appointment_date = '$apDate',
                      ModifyBy= '$userId'
                      where ticket_id =".$ticket_id;
                      
    $query = mysql_query($Update_ticket);
    /*echo $Update_ticket;*/
    $_SESSION['msgTkt'] = "Ticket Update Successfully !";
    header("location: update_ticket_status.php?token=".$token);
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
<script type="text/javascript" src="js/close_ticket.js"></script>
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
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once("includes/header.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Close  Ticket
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Close Ticket</li>
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
        <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['ticket_id']) and $_GET['ticket_id']>0){ echo $_GET['ticket_id']; }?>"/>
        <div class="col-md-12">
        
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Organization<i>*</i></label>
                <div class="col-sm-10" id="divOrgranization">
                   <input type="text" name="organization" id="organization" value="<?php if(isset($result['ticket_id'])) echo getOraganization($result['organization_id']);?>" class="form-control text_box" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Product<i>*</i></label>
                <div class="col-sm-10">
                <input type="text" name="products" id="products" value="<?php if(isset($result['ticket_id'])) echo getproducts(stripslashes($result["product"]));?>" class="form-control text_box" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Request&nbsp;Type<i>*</i></label>
                <div class="col-sm-10" id="statediv">
                  <input type="text" name="products" id="products" value="<?php if(isset($result['ticket_id'])) echo      getRequesttype(stripslashes($result["rqst_type"]));?>" class="form-control text_box" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Status<i>*</i></label>
                <div class="col-sm-10" id="statediv">
                  <select name="status" id="status" class="form-control drop_down select2" style="width: 100%" onChange="ShowHideDiv()">
                  <option value="">Select Status</option>
                  <option value="1">Close</option>
                  <option value="2">Reschedule</option>
                  </select>
                </div>
            </div>
            
            <div id="service_provider" style="display:none">
             <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Model<i>*</i></label>
                <div class="col-sm-10">
                    <select name="model" id="model" class="form-control drop_down select2" style="width: 100%">
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
                <label for="dateofpurchase" class="col-sm-2 control-label">No&nbsp;of&nbsp;Installation<i>*</i></label>
                <div class="col-sm-10">
                  <input type="text" name="no_of_installation" id="no_of_installation"  class="form-control text_box"/>
                </div>
            </div>
            </div>
          
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Remarks/Reason <br>(If Any)<i>*</i></label>
                <div class="col-sm-10">
                  <textarea name="des" id="des" class="form-control txt_area"><?php if(isset($result['ticket_id'])) echo $result['description'];?></textarea>
                </div>
            </div>
            
            <div class="form-group" id="divclose" style="display: none">
               <!--<label for="date_time" class="col-sm-2 control-label">Close&nbsp;Date*</label>
                <div class="col-sm-10" >
                  <input name="date_time" id="date_time"  value="<?php if(isset($result['ticket_id'])) echo       stripslashes($result["close_date"]);?>" class="form-control text_box"  type="text" />
        </div>-->
            </div>
            
            <div class="form-group" id="divpp" style="display: none">
              <label for="date_time" class="col-sm-2 control-label">Schedule&nbsp;Date<i>*</i></label>
                <div class="col-sm-10">
                  <input name="apDate" id="apDate" class="form-control text_box date" value="<?php if(isset($result['ticket_id'])) echo      stripslashes($result["appointment_date"]);?>" type="text"/>
            </div>
            </div>
            
             <div class="clearfix"></div>
             <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10" style="margin:0px 0px 10px 60px">
                <input type="submit" value="Submit" name="close" id="close" class="btn btn-primary btn-sm" />
                <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='update_ticket_status.php?token=<?php echo $token ?>'" />
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