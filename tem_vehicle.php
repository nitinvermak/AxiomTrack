<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php");

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
if(isset($_REQUEST['organization']))
  {
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
    $ticketId = htmlspecialchars(mysql_real_escape_string(trim($_REQUEST['ticketId'])));
    $punchBy = $_SESSION['user_id'];
  }

  if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes')
  {
    if(isset($_REQUEST['cid']) && $_REQUEST['cid']!='')
    {
      $sql = "update tempvehicledata set customer_Id='$organization', 
              customer_branch='$customer_branch', vehicle_no='$vehicle_no', 
              techinician_name='$technician', mobile_no='$mobile_no', 
              device_id='$device', imei_no='$imei', model_name='$model', 
              installation_date= Now(), ticketId = '$ticketId', 
              configStatus = 'N', modify_by = '$punchBy'
              where id=" .$_REQUEST['id'];
      /*echo $sql;*/
      mysql_query($sql);
      /*echo $sql;*/
      echo "<script> alert('Vehicle updated successfully');</script>";
      sendConfigSms($model, $mobile_no, '');
      /*header("location:manage_vehicle.php?token=".$token);
      exit();*/
    }
  else 
    {
      $query = "insert into tempvehicledata set customer_Id='$organization', 
                customer_branch='$customer_branch', vehicle_no='$vehicle_no', 
                techinician_name='$technician', mobile_no='$mobile_no', 
                device_id='$device', imei_no='$imei', model_name='$model', 
                installation_date=Now(), ticketId = '$ticketId', configStatus = 'N',
                create_by = '$punchBy'";
      /*echo $query;*/
      $sql = mysql_query($query);
      /*$_SESSION['sess_msg']='Vehicle added successfully';*/
      $msg = "Vehicle added successfully";
      sendConfigSms($model, $mobile_no, '');
      /*header("location:manage_vehicle.php?token=".$token);
      exit();*/
    }

}
if(isset($_REQUEST['id']) && $_REQUEST['id'])
  {
    $queryArr=mysql_query("SELECT * FROM tempvehicledata WHERE id =".$_REQUEST['id']);
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
<script type="text/javascript" src="js/tempVehicle.js"></script>
<!--end-->
<script type="text/javascript">
$(document).ready(function(){
    $("select.ticket").change(function(){
      $.post("ajaxrequest/show_ticket_organization.php?token=<?php echo $token;?>",
        {
          ticket : $(".ticket option:selected").val()
        },
          function( data ){
            $("#divOrgranization").html(data);
        });
    
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
        New Vehicle
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">New Vehicle</li>
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
                <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
              <input type="hidden" name="submitForm" value="yes" />
              <input type='hidden' name='cid' id='cid'  value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
            <div class="col-md-12">
              <div class="form-group">
                    <label for="Product" class="col-sm-2 control-label">Ticket Id <span class="red">*</span></label>
                    <div class="col-sm-10">
                          <select name="ticketId" id="ticketId" class="form-control select2 ticket" style="width:100%">
                           <option value="">Select Ticket Id</option>
                            <?php 
                            $userCat = $_SESSION['user_category_id'];
                            $userId = $_SESSION['user_id'];
                            if($userCat == 1 || $userCat == 12){
                            $Country=mysql_query("select A.ticket_id from tblticket as A
                                                   INNER JOIN tbl_ticket_assign_technician as B 
                                                   On A.ticket_id = B.ticket_id 
                                                   where A.organization_type='Existing Client' 
                                                   and A.ticket_status <> 1 and A.rqst_type = '1'
                                                   order by A.ticket_id ASC");
                            }
                            else{
                            $Country=mysql_query("select A.ticket_id from tblticket as A
                                                   INNER JOIN tbl_ticket_assign_technician as B 
                                                   On A.ticket_id = B.ticket_id 
                                                   where A.organization_type='Existing Client' 
                                                   and B.technician_id = '$userId' 
                                                   and A.ticket_status <> 1 and A.rqst_type = '1'
                                                   order by A.ticket_id ASC");
                            
                            }
                            while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['ticket_id']; ?>" <?php if(isset($result['ticket_id']) && $resultCountry['ticket_id']==$result['ticket_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['ticket_id'])); ?></option>
                            <?php } ?>
                          </select>
                    </div>
                </div>
                <div id="divOrgranization" >
                <!--<div class="form-group">
                    <label for="provider" class="col-sm-2 control-label">Organization*</label>
                    <div class="col-sm-10" id="divOrgranization">
                    <select name="organization" id="organization" class="form-control drop_down">
                        <option value="">Select Organization</option>
                      </select>
                    </div>
                </div>-->
                </div>
               
                
                <div class="form-group">
                    <label for="Product" class="col-sm-2 control-label">Vehicle No <span class="red">*</span></label>
                    <div class="col-sm-10">
                    <input name="vehicle_no" id="vehicle_no" type="text" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['vehicle_no']; ?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="Mobile" class="col-sm-2 control-label">Techician <span class="red">*</span></label>
                    <div class="col-sm-10" id="statediv">
                     <select name="technician" id="technician" onChange="return ShowMobile();" class="form-control select2" style="width: 100%">
                     <option value="">Select Techician</option>
                     <?php 
                      $userCategory = $_SESSION['user_category_id'];
                  echo $userCategory;
                      if($userCategory == 1 || $userCategory == 12)
                      {
                        $technician = mysql_query("select * from tbluser where (User_Category=5 or User_Category=8)");  
                    echo "select * from tbluser where (User_Category=5 or User_Category=8)";
                      }
                      else
                      {
                        $technician = mysql_query("select * from tbluser where (User_Category=5 or User_Category=8) 
                                       and id = '$userId'");
                    echo "select * from tbluser where (User_Category=5 or User_Category=8) 
                                       and id = '$userId'";
                      }
                                while($resulttechnician=mysql_fetch_assoc($technician)){
                     ?>
                     <option value="<?php echo $resulttechnician['id']; ?>" 
                     <?php if(isset($result['techinician_name']) && $resulttechnician['id']==$result['techinician_name']){ ?>selected
                     <?php } ?>><?php echo stripslashes(ucfirst($resulttechnician['First_Name']." ".$resulttechnician['Last_Name'])); ?>
                     </option>
                     <?php } ?>
                     </select>
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
                    <label for="dateofpurchase" class="col-sm-2 control-label">No&nbsp;of&nbsp;Installation*</label>
                    <div class="col-sm-10">
                      <input type="text" name="no_of_installation" id="no_of_installation"  class="form-control text_box"/>
                    </div>
                </div>
                </div>
              
                <div class="form-group">
                    <label for="dateofpurchase" class="col-sm-2 control-label">Mobile <span class="red">*</span></label>
                  <div class="col-sm-10" id="divMobile">
                    <select name="mobile_no" id="mobile_no" class="form-control drop_down select2" style="width: 100%">
                        <option value="">Select Mobile</option>
                        <option value="<?php echo $result['mobile_no']; ?>" <?php if(isset($result['id']) && $result['mobile_no']==$result['mobile_no']){ ?>selected<?php } ?>><?php echo getMobile(stripslashes(ucfirst($result['mobile_no']))); ?></option>
                    </select> 
                  </div>
                </div>
                
                <div class="form-group">
                    <label for="dateofpurchase" class="col-sm-2 control-label">Device&nbsp;Id <span class="red">*</span></label>
                  <div class="col-sm-10" id="divDevice">
                       <select name="device" id="device" class="form-control select2" style="width: 100%" onChange="return ShowIMEIandDeviceName();">
                       <option value="">Select Device</option>
                        <option value="<?php echo $result['device_id']; ?>" <?php if(isset($result['id']) && $result['device_id']==$result['device_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['device_id'])); ?></option>
                       </select>
                  </div>
                </div>
                
                 <div class="form-group">
                    <label for="dateofpurchase" class="col-sm-2 control-label">IMEI No. <span class="red">*</span></label>
                    <div class="col-sm-10" id="divIMEI">
                       <select name="imei" id="imei" class="form-control drop_down select2" style="width: 100%">
                       <option value="">Select IMEI</option>
                       <option value="<?php echo $result['imei_no']; ?>" <?php if(isset($result['id']) && $result['imei_no']==$result['imei_no']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['imei_no'])); ?></option>
                       </select>
                    </div>
                </div>
                
                  <div class="form-group">
                    <label for="dateofpurchase" class="col-sm-2 control-label">Model <span class="red">*</span></label>
                    <div class="col-sm-10" id="getModel">
                       <select name="model" id="model" class="form-control drop_down select2" style="width: 100%">
                       <option value="">Select Model</option>
                       <option value="<?php echo $result['model_name']; ?>" <?php if(isset($result['id']) && $result['model_name']==$result['model_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['model_name'])); ?></option>
                       </select>
                    </div>
                  </div>     
                <div class="clearfix"></div>
                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="margin:10px 0px 10px 10px;">
                  <input type='submit' name='submit2' class="btn btn-primary btn-sm" value="Submit"/>
                  <input type='reset' name='reset2' class="btn btn-primary btn-sm" value="Reset"/>
                  <input type='button' name='cancel2' class="btn btn-primary btn-sm" value="Back" 
                    onclick="window.location='manage_vehicle.php?token=<?php echo $token ?>'"/>
                </div>  
                </div>
                </div>
                </form>
              </div>
            </div><!-- /.box-body -->
      </div><!-- small-panel -->
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