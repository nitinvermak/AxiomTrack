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
if(isset($_POST['submit']))
  {
    $ticket_status = mysql_real_escape_string($_POST['status']);
    $remark = mysql_real_escape_string($_POST['des']);
    $apDate = mysql_real_escape_string($_POST['apDate']);
    
    $Update_ticket = "UPDATE tblticket SET ticket_status ='$ticket_status', ticket_remark = '$remark', 
              appointment_date = '$apDate' where ticket_id =".$ticket_id;
    echo $Update_ticket;
    $query = mysql_query($Update_ticket);
    echo "<script> alert('Ticket Reshedule');</script>";
    header("location: pending_works.php?token=".$token);
  }

if(isset($_POST['close']))
  {
    $ticket_status = mysql_real_escape_string($_POST['status']);
    $remark = mysql_real_escape_string($_POST['des']);
    /*$close_date = mysql_real_escape_string($_POST['close_date']);*/
    $Update_ticket = "UPDATE tblticket SET ticket_status = '$ticket_status', 
              ticket_remark = '$remark', close_date = Now() 
              where ticket_id =".$ticket_id;
    
    $query = mysql_query($Update_ticket);
    echo $Update_ticket;
    echo "<script> alert('Ticket Closed');</script>";
    header("location: pending_works.php?token=".$token);
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
 $(function() {
    $( "#apDate" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
$(document).ready(function(){
  $("#status").change(function(){
    if($("#status").val() == 1 )
      {
        $("#ticketReshudule").hide();
        $("#ticketClose").show();
      }
    if($("#status").val() == 2 )
      {
        $("#ticketClose").hide();
        $("#ticketReshudule").show();
      }
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
                <label for="provider" class="col-sm-2 control-label">Organization*</label>
                <div class="col-sm-10" id="divOrgranization">
                   <input type="text" name="organization" id="organization" value="<?php if(isset($result['ticket_id'])) echo getOraganization($result['organization_id']);?>" class="form-control text_box" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Product*</label>
                <div class="col-sm-10">
                <input type="text" name="products" id="products" value="<?php if(isset($result['ticket_id'])) echo getproducts(stripslashes($result["product"]));?>" class="form-control text_box" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Request&nbsp;Type*</label>
                <div class="col-sm-10" id="statediv">
                  <input type="text" name="products" id="products" value="<?php if(isset($result['ticket_id'])) echo      getRequesttype(stripslashes($result["rqst_type"]));?>" class="form-control text_box" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Status*</label>
                <div class="col-sm-10" id="statediv">
                  <select name="status" id="status" class="form-control drop_down" onChange="ShowHideDiv()">
                  <option value="">Select Status</option>
                  <option value="1">Close</option>
                  <option value="2">Reschedule</option>
                  </select>
                </div>
            </div>
            
            <div id="service_provider" style="display:none">
             <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Model*</label>
                <div class="col-sm-10">
                    <select name="model" id="model" class="form-control drop_down">
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
                <label for="dateofpurchase" class="col-sm-2 control-label">No&nbsp;of&nbsp;Installation*</label>
                <div class="col-sm-10">
                  <input type="text" name="no_of_installation" id="no_of_installation"  class="form-control text_box"/>
                </div>
            </div>
            </div>
          
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Remarks/Reason <br>(If Any)*</label>
                <div class="col-sm-10">
                  <textarea name="des" id="des" class="form-control txt_area">
                    <?php if(isset($result['ticket_id'])) echo stripslashes($result["ticket_remark"]);?>
                  </textarea>
                </div>
            </div>
            
            <div class="form-group" id="divclose" style="display: none">
               <!--<label for="date_time" class="col-sm-2 control-label">Close&nbsp;Date*</label>
                <div class="col-sm-10" >
                  <input name="date_time" id="date_time"  value="<?php if(isset($result['ticket_id'])) echo       stripslashes($result["close_date"]);?>" class="form-control text_box"  type="text" />
        </div>-->
            </div>
            
            <div class="form-group" id="divpp" style="display: none">
              <label for="date_time" class="col-sm-2 control-label">Schedule&nbsp;Date*</label>
                <div class="col-sm-10">
                  <input name="apDate" id="apDate" class="form-control text_box" value="<?php if(isset($result['ticket_id'])) echo      stripslashes($result["appointment_date"]);?>" type="text"/>
            </div>
            </div>
            
             <div class="clearfix"></div>
             <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="margin:0px 0px 10px 20px">
                  <!-- <input type="submit" value="Reshudule" name="submit" id="reshudule" class="btn btn-primary btn-sm" /> -->
                  <input type="submit" value="Submit" name="close" id="close" class="btn btn-primary btn-sm" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='pending_works.php?token=<?php echo $token ?>'" />
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