<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if (isset($_SESSION) && $_SESSION['login']=='') 
{
  session_destroy();
  header("location: index.php?token=".$token);
}
if(isset($_POST['submit']))
  {
    $company = mysql_real_escape_string($_POST['company']);
  }
//change mobile allocation
if(isset($_POST['save']))
  {
    $mobileNo = mysql_real_escape_string($_POST['mobileNo']);
    $branch = mysql_real_escape_string($_POST['branch']);
    $technician = mysql_real_escape_string($_POST['technician']);
    // echo $mobileNo.'<br>'.$branch ;
    $updateSimMaster = "Update tblsim set status_id='0' 
                        where id ='$mobileNo'";
    $result = mysql_query($updateSimMaster);
    // echo $updateSimMaster;
    $updateBranch = "Update tbl_sim_branch_assign set branch_id = '$branch'  
                     where sim_id ='$mobileNo'";
    $result = mysql_query($updateBranch);
    // echo $updateBranch;
    $updateAssignTechnician = "Update tbl_sim_technician_assign set technician_id = '$technician' 
                               where sim_id = '$mobileNo'";
    $result = mysql_query($updateAssignTechnician);
    // echo $updateAssignTechnician;
    $removeMobile = "UPDATE `tbl_gps_vehicle_master` SET mobile_no='0'  WHERE mobile_no='$mobileNo'";
    $result = mysql_query($removeMobile);
    $msg = "Mobile Number Changed";
  }
//end
//change device allocation
if(isset($_POST['savedevice']))
  {
    $deviceId = mysql_real_escape_string($_POST['deviceId']);
    $branch = mysql_real_escape_string($_POST['branch']);
    $technician = mysql_real_escape_string($_POST['technician']);
    $UpdateDevice = "Update tbl_device_master set status='0' where id ='$deviceId'";
    $result = mysql_query($UpdateDevice);
    /*echo $updateSimMaster;*/
    $updateBranch = "Update tbl_device_assign_branch set branch_id = '$branch'  where device_id ='$deviceId'";
    $result = mysql_query($updateBranch);
    /*echo $updateBranch;*/
    $updateAssignTechnician = "Update tbl_device_assign_technician set technician_id = '$technician' where device_id = '$deviceId'";
    $result = mysql_query($updateAssignTechnician);
    /*echo $updateAssignTechnician;*/
    $removeMobile = "UPDATE `tbl_gps_vehicle_master` SET device_id='0', imei_no = '0'  WHERE device_id='$deviceId'";
    $result = mysql_query($removeMobile);
    $msg = "Device Changed";
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
<script type="text/javascript" src="js/checkbox_validation_confirmation_pages.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
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
        Edit/Repair Vehicle Details
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit/Repair Vehicle Details</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Company Name <i class="red">*</i></span>
                        <select name="company" id="company" class="form-control select2" style="width: 100%">
                            <option value="0">Select Company</option>
                            <?php $Country=mysql_query("SELECT B.id as id, B.Company_Name as Company_Name
                                                        FROM tbl_customer_master as A 
                                                        INNER JOIN tblcallingdata as B
                                                        ON A.callingdata_id =  B.id 
                                                        Order by Company_Name ASC");               
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['id']; ?>"> <?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
                            <?php 
                            } 
                            ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 col-md-12 custom_field">
                        <span>&nbsp;</span><br>
                        <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-primary btn-sm"/>
                    </div>
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Details</h3>
            </div>
            <div class="box-body">
                <?php if(isset($msg)){?>
                <div class="alert alert-success alert-dismissible small-alert" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $msg; ?>
                </div>
                <?php 
                }
                ?>
                <div id="divassign" class="table-responsive">
                    <?php
                    $where='';
                    $linkSQL="";      
                    if(!isset($linkSQL) or $linkSQL =='')   
                    $linkSQL = "SELECT A.id, A.mobile_no, A.device_id, A.imei_no, A.techinician_name, 
                                B.callingdata_id, C.Company_Name as C_name, A.vehicle_no as V_no, 
                                A.vehicle_odometer as v_odometer 
                                FROM tbl_gps_vehicle_master as A 
                                INNER JOIN tbl_customer_master as B 
                                ON A.customer_Id = B.cust_id 
                                INNER JOIN tblcallingdata as C 
                                ON B.callingdata_id = C.id 
                                WHERE B.callingdata_id = '$company'";
                    $oRS = mysql_query($linkSQL); 
                    ?>
                    <table class="table table-hover table-bordered " >
                    <tr>
                        <th><small>S. No.</small></th>     
                        <th><small>Organization Name</small></th>
                        <th><small>Vehicle No</small></th>
                        <th><small>Mobile</small></th>
                        <th><small>Device Id</small></th>
                        <th><small>IMEI</small></th> 
                        <th><small>Technician</small></th>    
                        <th><small>Action              
                            <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
                            &nbsp;&nbsp;
                            <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>   </th>   
                    </tr>   
                    <?php
                    $kolor=1;
                    if(mysql_num_rows($oRS)>0){
                        while ($row = mysql_fetch_array($oRS)){
                    ?> 
                    <tr>
                        <td><small><?php print $kolor++;?>.</small></td>
                        <td><small><?php echo stripslashes($row["C_name"]);?></small></td>
                        <td><small><?php echo stripslashes($row["V_no"]);?></small></td>
                        <td><small>
                            <a class="open" id="mobile_no" data-toggle="modal" data-target="<?php echo '#a'.$row["mobile_no"];?>" >
                            <?php echo getMobile(stripslashes($row["mobile_no"]));?> 
                            <input type="hidden" name="mobile_no"  id="mobile_no" value="<?php echo getMobile(stripslashes($row["mobile_no"]));?>"></a>
                            </small> 
                            <!--Start modal popup-->
                            <div class="modal fade bs-example-modal-sm"  id="<?php echo 'a'.$row["mobile_no"];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                            <button type="button" id="modelhide" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          <h5 class="modal-title" id="myModalLabel">Re-Allocate Mobile Number</h5>
                                        </div>
                      <form method="post">
                      <div class="modal-body">
                        <p>Mobile*<br>
                          <select name="mobileNo" id="mobileNo" class="form-control select2" style="width: 100%">
                              <option value="<?php echo $row["mobile_no"];?>" readonly><?php echo getMobile($row["mobile_no"]);?></option>
                            </select>
                        </p>
                        <p>Branch<br>
                            <select name="branch" id="branch" class="form-control select2" style="width: 100%">
                                <option label="" value="" selected="selected">Select Branch</option>
                                <?php $Country=mysql_query("select * from tblbranch");
                                      while($resultCountry=mysql_fetch_assoc($Country)){
                                ?>
                                <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                                <?php } ?>
                            </select>
                        </p>
            <p>Technician<br>
                          <select name="technician" id="technician" class="form-control select2" style="width: 100%">
                                                     <option value="">Select Techician</option>
                                                     <?php $Country=mysql_query("select * from tbluser where User_Category=5 or User_Category=8");
                                                           while($resultCountry=mysql_fetch_assoc($Country)){
                                                     ?>
                                                     <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['techinician_name']) && $resultCountry['id']==$result['techinician_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ".$resultCountry['Last_Name'])); ?></option>
                                                     <?php } ?>
                          </select>
            </p>
                      </div>
                      <div class="modal-footer">
                        <input type="submit" name="save" id="save" value="Save" class="btn btn-danger btn-sm"/>
                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                      </div>
                      </form>
                    </div>
                  </div>
           </div>
              <!--end modal popup-->
              
        </td>
        <td><small>
          <a class="open"  id="deviceId" data-toggle="modal" data-target="<?php echo '#b'.$row["device_id"];?>">
      <?php echo stripslashes($row["device_id"]);?></a>
            <input type="hidden" name="deviceId"  id="deviceId" value="<?php echo stripslashes($row["device_id"]);?>"></small>
            <!--Start modal popup-->
            <div class="modal fade bs-example-modal-sm"  id="<?php echo 'b'.$row["device_id"];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                            <button type="button" id="modelhide" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h5 class="modal-title" id="myModalLabel">Re-Allocate Mobile Number</h5>
                        </div>
                      <form method="post">
                      <div class="modal-body">
                        <p>Device Id*<br>
                            <input type="text" name="deviceId" id="deviceId" class="form-control" style="width: 100%" value="<?php echo $row["device_id"];?>" readonly></p>
                        <p>Branch<br>
                          <select name="branch" id="branch" class="form-control select2" style="width: 100%">
                                  <option label="" value="" selected="selected">Select Branch</option>
                                  <?php $Country=mysql_query("select * from tblbranch");
                                        while($resultCountry=mysql_fetch_assoc($Country)){
                                  ?>
                                  <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                                  <?php } ?>
                        </select>
                        </p>
            <p>Technician<br>
                          <select name="technician" id="technician" class="form-control select2" style="width: 100%">
                            <option value="">Select Techician</option>
                            <?php $Country=mysql_query("select * from tbluser where User_Category=5 
                                                        or User_Category=8");
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['techinician_name']) && $resultCountry['id']==$result['techinician_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ".$resultCountry['Last_Name'])); ?></option>
                            <?php } ?>
                          </select>
            </p>
                      </div>
                          <div class="modal-footer">
                            <input type="submit" name="savedevice" id="savedevice" value="Save" class="btn btn-danger btn-sm"/>
                             <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                          </div>
                      </form>
                    </div>
                  </div>
           </div>
              <!--end modal popup-->
        </td>
        <td><small><?php echo stripslashes($row["imei_no"]);?></small></td>
        <td><small><?php echo stripslashes($row["techinician_name"]);?></small></td>
      <td><small><?php if($row["id"]!=1){?><a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_city.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " ><img src="images/drop.png" title="Delete" border="0" /></a> <?php } ?>    <?php if($row["id"]!=1){?> <a href="1_old_29_15_add_gps_vehicle.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><?php } else {?> <a href="change_password.php?cid=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> <?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?></small></td>
        </tr>
        <?php }
    }
    else
      echo "<tr><td colspan=8 align=center><h3 style='color:red'>No records found!</h3><br></td><tr/></table>";
    ?> 
         </form>
          </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        </form>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<!-- Loader -->
<div class="loader">
    <img src="images/loader.gif" alt="loader">
</div>
<!-- End Loader -->
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