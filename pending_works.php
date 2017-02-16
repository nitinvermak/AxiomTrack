<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
    session_destroy();
    header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
    session_destroy();
    header("location: index.php?token=".$token);
}
// InStock Sim
  $sqlSim = "SELECT * FROM tblsim as A 
        INNER JOIN tbl_sim_branch_assign as B 
        ON A.id = B.sim_id
        INNER JOIN tbl_sim_technician_assign as C 
        ON B.sim_id = C.sim_id 
        WHERE A.status_id = 0 
        And C.technician_id = ".$_SESSION['user_id'];
  /*echo $sql;*/
    $resultSim = mysql_query($sqlSim);
    $inStockSim = mysql_num_rows($resultSim);
    $totalInstock = $inStockSim;
// End
// InStock Device
  $sqlDevice = "SELECT * FROM tbl_device_master as A 
          INNER JOIN tbl_device_assign_branch as B 
          ON A.id = B.device_id
          INNER JOIN tbl_device_assign_technician as C 
          ON B.device_id = C.device_id 
          WHERE A.status = 0 
          and C.technician_id =".$_SESSION['user_id'];
  /*echo $sql;*/
    $resultDevice = mysql_query($sqlDevice);
    $inStockDevice = mysql_num_rows($resultDevice);
    $totalInstockDevice = $inStockDevice;
// End
// Instock Ticket
  $sqlNewInst = "SELECT * FROM tblticket as A 
           INNER JOIN tbl_ticket_assign_branch as B 
           ON A.ticket_id = B.ticket_id 
           INNER JOIN tbl_ticket_assign_technician as C 
           ON B.ticket_id = C.ticket_id
           WHERE A.rqst_type = '1' And A.ticket_status <> 1
           AND C.technician_id =".$_SESSION['user_id'];
  /*echo $sql;*/
    $resultNewInst = mysql_query($sqlNewInst);
    $inStockNewInst = mysql_num_rows($resultNewInst);
    $totalInstockNewInst = $inStockNewInst;
  
  $sqlRepair = "SELECT * FROM tblticket as A 
          INNER JOIN tbl_ticket_assign_branch as B 
          ON A.ticket_id = B.ticket_id 
          INNER JOIN tbl_ticket_assign_technician as C 
          ON B.ticket_id = C.ticket_id
          WHERE A.rqst_type = '2' And A.ticket_status <> 1
          AND C.technician_id =".$_SESSION['user_id'];
  /*echo $sql;*/
    $resultRepair = mysql_query($sqlRepair);
    $inStockRepair = mysql_num_rows($resultRepair);
    $totalInstockRepair = $inStockRepair;
  
  $sqlMeeting = "SELECT * FROM tblticket as A 
           INNER JOIN tbl_ticket_assign_branch as B 
           ON A.ticket_id = B.ticket_id 
           INNER JOIN tbl_ticket_assign_technician as C 
           ON B.ticket_id = C.ticket_id
           WHERE A.rqst_type = '3' And A.ticket_status <> 1
           AND C.technician_id =".$_SESSION['user_id'];
  /*echo $sql;*/
    $resultMeeting = mysql_query($sqlMeeting);
    $inStockMeeting = mysql_num_rows($resultMeeting);
    $totalInstockMeeting = $inStockMeeting;
  
  $sqlPayment = "SELECT * FROM tblticket as A 
           INNER JOIN tbl_ticket_assign_branch as B 
           ON A.ticket_id = B.ticket_id 
           INNER JOIN tbl_ticket_assign_technician as C 
           ON B.ticket_id = C.ticket_id
           WHERE A.rqst_type = '7' And A.ticket_status <> 1
           AND C.technician_id =".$_SESSION['user_id'];
  /*echo $sql;*/
    $resultPayment = mysql_query($sqlPayment);
    $inStockPayment = mysql_num_rows($resultPayment);
    $totalInstockPayment = $inStockPayment;
  
  $sqlReinstallation = "SELECT * FROM tblticket as A 
              INNER JOIN tbl_ticket_assign_branch as B 
              ON A.ticket_id = B.ticket_id 
              INNER JOIN tbl_ticket_assign_technician as C 
              ON B.ticket_id = C.ticket_id
              WHERE A.rqst_type = '10' And A.ticket_status <> 1
              AND C.technician_id =".$_SESSION['user_id'];
  /*echo $sql;*/
    $resultReinstallation = mysql_query($sqlReinstallation);
    $inStockReinstallation = mysql_num_rows($resultReinstallation);
    $totalInstockReinstallation = $inStockReinstallation;
// End
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
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
<script type="text/javascript">
// calender script
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
// End calender script
// send ajax request
$(document).ready(function(){
  $("#submit").click(function(){
    $('.loader').show();
    $.post("ajaxrequest/view_technician_ticket_report.php?token=<?php echo $token;?>",
        {
          date : $('#date').val(),
          dateto : $('#dateto').val(),
          executive : $('#executive').val(),
          branch : $('#branch').val(),
          status : $('#status').val()
        },
          function(data){
            /*alert(data);*/
            $("#divassign").html(data);
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        }); 
  });
});
//end
// get Instock Sim
function getSimTable()
{
  $.post("ajaxrequest/sim_stock_popup.php?token=<?php echo $token;?>",
          function(data){
            /*alert(data);*/
            $(".modal-content").html(data);
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        }); 
}
// End
// get Instock Device
function getDeviceTable()
{
  $.post("ajaxrequest/device_stock_popup.php?token=<?php echo $token;?>",
          function(data){
            /*alert(data);*/
            $(".modal-content").html(data);
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        }); 
}
// End
// get New Installation
function getNewInstallation()
{
  $.post("ajaxrequest/new_installation_popup.php?token=<?php echo $token;?>",
          function(data){
            /*alert(data);*/
            $(".modal-content").html(data);
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
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
        Dashboard
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <?php if($_SESSION['user_category_id'] == 9)
          {
            echo '<div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <h3>Ticket</h3>
                        <div class="dash-info">
                          <p>Payment Collection</p>
                            <span>'.$totalInstockPayment.'</span>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>';
                
          }
          else
          {
            echo '<div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                      <div class="inner">
                        <h3>Stock</h3>
                        <div class="dash-info">
                          <p>Sim</p>
                            <span><a data-toggle="modal" data-target=".bs-example-modal-lg" onClick="getSimTable();"">'.$totalInstock.'</a></span>
                        </div>
                        <div class="dash-info">
                          <p>Device</p>
                            <span><a data-toggle="modal" data-target=".bs-example-modal-lg" onClick="getDeviceTable();">'.$totalInstockDevice.'</a></span>
                        </div>
                      </div>
                    </div>
                  </div>';
          
            echo '<div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <h3>Ticket</h3>
                        <div class="dash-info">
                          <p>New Installation</p>
                            <span>'.$totalInstockNewInst.'</span>
                        </div>
                        <div class="dash-info">
                          <p>Repair</p>
                            <span>'.$totalInstockRepair.'</span>
                        </div>
                        <div class="dash-info">
                          <p>Payment Collection</p>
                            <span>'.$totalInstockPayment.'</span>
                        </div>
                      </div>
                    </div>
                  </div>';
          }
          ?>
        
      </div>
      <!-- end box row -->
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<!-- Modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Show Content From Ajax request -->
        </div>
    </div>
</div>
 <!-- End Modal -->
<?php include_once("includes/footer.php") ?>
</div><!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
</body>
</html>