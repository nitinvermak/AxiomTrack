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
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!--<script type="text/javascript" src="js/ticket_report.js"></script>-->
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script>
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
<!--Datepicker-->

<!--end--
</head>
<body>
<!--open of the wraper--><div id="wraper">
	<!--include header-->
    <?php include_once('includes/header.php');?>
    <!--end-->
    <!--open of the content-->
<div class="row" id="content">
	<div class="col-md-12">
    	<h3>Dashboard</h3>
      <hr>
    </div>
    <div class="col-md-12">
      <div class="row">
    	<div class="col-md-12 table-responsive">
        	<?php if($_SESSION['user_category_id'] == 9)
			{
				echo "<table class='table table_light table-bordered' style='max-width:200px;'>
					  <tr>
						<th><center><strong>Ticket</strong></center></th>
					  </tr>           
					  <tr>
					  <td><center><strong>Payment Collection</strong></center></td>
					  </tr>
					  <tr>
						<td><center> $totalInstockPayment </center></td>
					  </tr> 
					  </table>";
			}
			else
			{
				echo "<table class='table table_light table-bordered'>
					  <tr>
						<th colspan='2'><center><strong>Stock</strong></center></th>
						<th colspan='3'><center><strong>Ticket</strong></center></th>
					  </tr>           
					  <tr>
						<td><center><strong>Sim</strong></center></td>
						<td><center><strong>Device</strong></center></td>
						<td><center><strong>New Installation</strong></center></td>
						<td><center><strong>Repair</strong></center></td>
						<td><center><strong>Payment Collection</strong></center></td>
					  </tr> 
					  <tr>
						<td><center><a data-toggle='modal' data-target='.bs-example-modal-lg' onClick='getSimTable();'>
									 $totalInstock</a></center></td>
						<td><center><a data-toggle='modal' data-target='.bs-example-modal-lg' onClick='getDeviceTable();'>
					  	$totalInstockDevice</a></center></td>
						<td><center>
					 	 $totalInstockNewInst</center></td>
						<td><center> $totalInstockRepair </center></td>
						<td><center> $totalInstockPayment </center></td>
					  </tr> 
					  </table>";
			}
			?>
         	<!-- Show Table in Modal --->
            	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      
                    </div><!-- End Modal Content -->
                  </div>
                </div>
            <!-- End -->
        </div>
    </div>
    </div>
       
    </div>
</div>
<!--end of the content-->
<!--open of the footer-->
<div class="row" id="footer">
	<div class="col-md-12">
    <p>Copyright &copy; 2015 INDIAN TRUCKERS, All rights reserved.</p>
    </div>
</div>
<!--end footer-->
<!-- hidden loader division -->
<div class="loader">
	<img src="images/loader.gif" alt="loader">
</div>
<!-- end hidden loader division-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/bootstrap.min.js"></script>
</body>

</html>