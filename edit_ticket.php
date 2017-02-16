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
$Ticket_id = $_GET['id'];
if (isset($_POST['submit'])) {
    $orgranization = mysql_real_escape_string($_POST['orgranization']);
    $product = mysql_real_escape_string($_POST['product']);
    $request = mysql_real_escape_string($_POST['request']);
    $model = mysql_real_escape_string($_POST['model']);
    $no_of_installation = mysql_real_escape_string($_POST['no_of_installation']);
    $des = mysql_real_escape_string($_POST['des']);
    $date_time = mysql_real_escape_string($_POST['date_time']);
    $status = mysql_real_escape_string($_POST['status']);
    $userId = $_SESSION['user_id']; 
    $update_record = "UPDATE tblticket SET  organization_id = '$orgranization', 
            product = '$product', rqst_type = '$request', 
            device_model_id = '$model', no_of_installation = '$no_of_installation', 
            description = '$des', appointment_date = '$date_time',  ticket_status = '$status', 
            ModifyDate = Now(), ModifyBy = '$userId' 
            WHERE ticket_id = '$Ticket_id'";
    // Call User Activity Log function
    UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $update_record);
    // End Activity Log Function
    $query = mysql_query($update_record);
    $_SESSION['sess_msg']='Ticket updated successfully';
    header("location:view_ticket.php?token=".$token);
}
$Select_row = "Select * from tblticket where ticket_id='$Ticket_id'";
$result =mysql_query($Select_row);
$rows = mysql_fetch_array($result);
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
function getRequestType(){
  $.post("ajaxrequest/findrquest.php?token=<?php echo $token;?>",
    {
      productValue : $('#product').val()
    },
    function(data){
      /*alert(data);*/
      $("#shwDiv").html(data);
    });
}
function divshow(strval)
{
  if(strval=="1")
  {
    document.getElementById("service_provider").style.display = "";
  }
  else
  {
    document.getElementById("service_provider").style.display = "none";
  }
  if(strval=="2")
  {
    document.getElementById("repair").style.display = "";
  }
  else
  {
    document.getElementById("repair").style.display = "none";
  }

}
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
        Update Ticket
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ticket</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <div class="box-header">
             <!--  <h3 class="box-title">Ticket</h3> -->
            </div>
            <div class="box-body">
            <div class="tkt-form">
            <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
            <input type="hidden" name="submitForm" value="yes" />
            <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        
         <div class="clearfix">&nbsp;</div>
        <div class="col-md-12">
        
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Organization*</label>
                <div class="col-sm-10" id="divOrgranization">
                <select name="orgranization" id="orgranization" class="form-control drop_down">
                <option value="">Select Orgranization</option>                         
                    <?php $Country=mysql_query("select * from tblcallingdata");             
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($rows['organization_id']) && $resultCountry['id']==$rows['organization_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Product" class="col-sm-2 control-label">Product*</label>
                <div class="col-sm-10">
                <select name="product" id = "product" onChange="getRequestType()" class="form-control drop_down">
                <option value="">Select Products</option>                         
                    <?php $Country=mysql_query("select * from tblcallingcategory");             
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($rows['product']) && $resultCountry['id']==$rows['product']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['category'])); ?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Request&nbsp;Type*</label>
                <div class="col-sm-10" id="shwDiv">
                 <select name="request"  onchange="return divshow(this.value)" class="form-control drop_down">
                  <option value="">Request Type</option>                         
                    <?php $Country=mysql_query("select * from tblrqsttype");              
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($rows['rqst_type']) && $resultCountry['id']==$rows['rqst_type']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['rqsttype'])); ?></option>
                  <?php } ?>                             
                 </select>
                </div>
            </div>
            <div id="service_provider">
             <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Model*</label>
                <div class="col-sm-10">
                    <select name="model" id="model" class="form-control drop_down">
                      <option value="">Request Type</option>                         
                      <?php $Country=mysql_query("select * from tbldevicemodel");             
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($rows['device_model_id']) && $resultCountry['device_id']==$rows['device_model_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">No&nbsp;of&nbsp;Installation*</label>
                <div class="col-sm-10">
                  <input type="text" name="no_of_installation" id="no_of_installation"  value="<?php if(isset($rows['ticket_id'])) echo $rows['no_of_installation']; ?>" class="form-control text_box"/>
                </div>
            </div>
            <div class="form-group">
                <label for="Mobile" class="col-sm-2 control-label">Status*</label>
                <div class="col-sm-10" id="statediv">
                  <select name="status" id="status" class="form-control drop_down">
                  <option value="">Select Status</option>                         
            <?php $sqlQry=mysql_query("SELECT DISTINCT `ticket_status` FROM `tblticket` ORDER BY `ticket_status`");             
                              while($resultQry = mysql_fetch_assoc($sqlQry)){
                        ?>
                        <option value="<?php echo $resultQry['ticket_status']; ?>" <?php if(isset($rows['ticket_status']) && $resultQry['ticket_status']==$rows['ticket_status']){ ?>selected<?php } ?>><?php echo getTicketStatusEdit($resultQry['ticket_status']); ?></option>
                        <?php } ?>
                  </select>
                </div>
            </div>
            </div>
          
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Description*</label>
                <div class="col-sm-10">
                  <textarea name="des" id="des" class="form-control txt_area"><?php if(isset($rows['ticket_id'])) echo $rows['description']; ?></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Apt.&nbsp;Date*</label>
                <div class="col-sm-10">
                  <input name="date_time" id="date_time" class="form-control text_box" value="<?php if(isset($rows['ticket_id'])) echo $rows['appointment_date']; ?>" type="text"  />
                </div>
            </div>
             <div class="clearfix"></div>
             <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="margin:10px 0px 10px 20px;">
                
                  <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary btn-sm" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='view_ticket.php?token=<?php echo $token ?>'" />
                </div>  
                 
        </div> 
            </div>
             </form>
             </div><!--  end tkt-form -->
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