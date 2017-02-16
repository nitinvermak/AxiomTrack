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
if(count($_POST['linkID'])>0 && (isset($_POST['submit'])) ){			   
  	$dsl="";
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
             	{
					$branch_id = $_POST['branch'];
					$status_id = "1";
					$createdby = $_SESSION['user_id'];
					$check_ticketId = mysql_query("SELECT * FROM tbl_ticket_assign_branch 
												   WHERE ticket_id='$chckvalue'");
					if(mysql_num_rows($check_ticketId) <= 0)
					{
						$sql = "update tblticket set branch_assign_status='$status_id' where ticket_id='$chckvalue'";
						/*echo $sql;*/
						// Call User Activity Log function
						UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
						// End Activity Log Function
						$results = mysql_query($sql); 	
						$assign = "insert into tbl_ticket_assign_branch set ticket_id= '$chckvalue', 
								   branch_id= '$branch_id', assign_by='$createdby', assign_date=Now()";
						/*echo $assign;*/
						// Call User Activity Log function
						UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $assign);
						// End Activity Log Function
						$query = mysql_query($assign);
						$msg = "Ticket Branch Assign Successfully";
					}
					else
					{
						$msgDanger = "Ticket already Assign";
					}
   			    }
			 }  
  		$id="";
}
if(count($_POST['linkID'])>0 && (isset($_POST['remove'])) )
   {			   
  		$dsl="";
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
	   	  		$branch_id=$_POST['branch'];
		  		$status_id="0";
		  		$createdby=$_SESSION['user_id'];
				$sql = "delete from tbl_ticket_assign_branch where 	ticket_id='$chckvalue'";
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
				// End Activity Log Function
				$results = mysql_query($sql); 	
				$assign = "update tblticket set branch_assign_status='$status_id' where ticket_id='$chckvalue'";
				//echo $sql;
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $assign);
				// End Activity Log Function
				$query = mysql_query($assign);
				/* echo $query;*/
				$msgDanger = "Ticket Removed";
   			   }
			 }  
  		$id="";
}
// Executive Operation
if(count($_POST['linkID'])>0)
   {			   
  		$dsl="";
		if(isset($_POST['linkID']) && (isset($_POST['submit_tech'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
				$technician_id = $_POST['executive'];
		  		$status_id = "1";
		  		$createdby = $_SESSION['user_id'];
		  		/*$ticketId = mysql_real_escape_string($_POST['ticketId']);*/
		  		$companyName = mysql_real_escape_string($_POST['companyName']);
		  		$callingDataId = mysql_real_escape_string($_POST['callingDataId']);
		  		$requestType = mysql_real_escape_string($_POST['requestType']);
		  		$organizationContact = mysql_real_escape_string($_POST['organizationContact']);
		  		$description = mysql_real_escape_string($_POST['description']);
				$vehicleNo = mysql_real_escape_string($_POST['vehicleNo']);
				// echo $callingDataId;
				// echo "<br>";
				 // Message Technician
		  		$mssg = 'T Id: '.$chckvalue.' '.'Cmpny: '.$companyName.' '.'Rqst.: '.$requestType.' '.' Veh.: '.$vehicleNo.' '.'Mob.: '.$organizationContact.' '.'Rmrk. '.$description;
		  		// Message Client
		  		$msgClnt = "Thanks for Contacting Indian Truckers Your Tkt. Id is ".$chckvalue."  and assign Person.";
		  		//echo $mssg.'<br>'.$technician_id;
				$check_ticketId = mysql_query("SELECT * FROM tbl_ticket_assign_technician 
											   WHERE ticket_id='$chckvalue'");
					if(mysql_num_rows($check_ticketId) <= 0)
					{ 
						$sql = "insert into tbl_ticket_assign_technician set ticket_id='$chckvalue', 
								technician_id = '$technician_id', assigned_by = '$createdby', 
								assigned_date	= Now()";
						// Call User Activity Log function
						UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
						// End Activity Log Function
						$results = mysql_query($sql);

						$assign_technician = "update tbl_ticket_assign_branch set technician_assign_status = '$status_id' 
											  where ticket_id='$chckvalue'";
						$confirm = mysql_query($assign_technician);
						$msg = "Ticket Assign Successfully";
						
						// Call User Activity Log function
						UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $assign_technician);
						// End Activity Log Function
						
						// Call sms send function
						sendTicketAlert($technician_id, $mssg);
						sendTicketConfirmation($callingDataId, $msgClnt);
						
					}
					else
					{
						$msgDanger = "Ticket already Assign";
					} 
   			   }
			 }  
  		$id="";
}
if(count($_POST['linkID'])>0 && (isset($_POST['remove_tech'])) )
   {			   
  		$dsl="";
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
	   	  		$technician_id=$_POST['technician_id'];
		  		$status_id="0";
		  		$createdby=$_SESSION['user_id'];
				$sql = "delete from tbl_ticket_assign_technician where ticket_id='$chckvalue'";
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
				// End Activity Log Function
				$results = mysql_query($sql); 	
				$assign = "update tbl_ticket_assign_branch set 	technician_assign_status='$status_id' 
						   where ticket_id='$chckvalue'";
				 				
				$query = mysql_query($assign);
				$msgDanger = "Ticket Removed";
   			   }
			 }  
  		$id="";
}
/*--------------- Ticket Branch Confirmation ------------------- */
if(count($_POST['linkID'])>0){         
    $dsl="";
    if(isset($_POST['linkID']) &&(isset($_POST['ticketConfirm']))){
        foreach($_POST['linkID'] as $chckvalue){
            /*  $device_id=$_POST['linkID'][$dsl];*/
            $branch_id=$_POST['branch'];
            $confirmation_status="1";
            $createdby=$_SESSION['user_id'];
            $sql = "update tbl_ticket_assign_branch set branch_confirmation_status = '$confirmation_status' 
                  where ticket_id='$chckvalue'";
          	// Call User Activity Log function
          	UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
          	// End Activity Log Function
            $results = mysql_query($sql);
          	$msg = "Ticket Confirmation Successfully!";
        }
    }  
    $id="";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
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
<!-- DataTable CSS -->
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/buttons.dataTables.min.css">
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript" src="js/manage_import_device.js"></script>
<!-- DataTable JS -->
<script type="text/javascript" src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.print.min.js"></script>
<script type="text/javascript">
$(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
}); 
function getBranch(){
	$('.loader').show();
	$.post("ajaxrequest/assign_ticket_branch_option.php?token=<?php echo $token;?>",
		function(data){
			/*alert(data);*/
			$("#dvOption").html(data);
			$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
			$(".select2").select2();
			$(".loader").removeAttr("disabled");
			$('.loader').fadeOut(1000);
	});	
}
function getTechnician(){
	// alert('asdfas');
	$('.loader').show();
	$.post("ajaxrequest/assign_ticket_techician_option.php?token=<?php echo $token;?>",
		function(data){
			/*alert(data);*/
			$("#dvOption").html(data);
			$(".select2").select2();
			$(".loader").removeAttr("disabled");
			$('.loader').fadeOut(1000);
		});	
}
// call ajax when click assign ticket
function getInstockBranch(){
	$('.loader').show();
	$.post("ajaxrequest/show_ticket_unassigned.php?token=<?php echo $token;?>",{
		date : $('#date').val()
	},
	function(data){
		/*alert(data);*/
		$("#divassign").html(data);
		$('#example').DataTable( {
				dom: 'Bfrtip',
				"bPaginate": false,
				buttons: [
					        'copy', 'csv', 'excel', 'pdf', 'print'
					     ]
		});
		$(".loader").removeAttr("disabled");
		$('.loader').fadeOut(1000);
	});	
}
// end
// call ajax when click assign ticket
function getAssignBranch(){
	$('.loader').show();
	$.post("ajaxrequest/show_ticket_assigned.php?token=<?php echo $token;?>",
		{
			date : $('#date').val(),
			branch	:	$('#branch').val()
		},
		function(data){
			/*alert(data);*/
			$("#divassign").html(data);
			$('#example').DataTable( {
				dom: 'Bfrtip',
				"bPaginate": false,
				buttons: [
					        'copy', 'csv', 'excel', 'pdf', 'print'
					     ]
			});
			$(".loader").removeAttr("disabled");
			$('.loader').fadeOut(1000);
		});	
}
// end

// send ajax request when click assign ticket button
function getTicketBranchInstk(){
	$('.loader').show();
	$.post("ajaxrequest/assign_ticket_branch_technician.php?token=<?php echo $token;?>",
	{
		branch : $('#branch').val()
	},
	function(data){
		/*alert(data);*/
		$("#divassign").html(data);
		$('#example').DataTable( {
				dom: 'Bfrtip',
				"bPaginate": false,
				buttons: [
					        'copy', 'csv', 'excel', 'pdf', 'print'
					     ]
			});
		$(".loader").removeAttr("disabled");
		$('.loader').fadeOut(1000);
	});	
}
// end
// send ajax request when click assigned ticket
function getTicketTech(){
	$('.loader').show();
	$.post("ajaxrequest/view_assign_ticket_branch_technician.php?token=<?php echo $token;?>",
	{
		branch : $('#branch').val(),
		executive : $('#executive').val()
	},
	function(data){
		/*alert(data);*/
		$("#divassign").html(data);
		$('#example').DataTable( {
				dom: 'Bfrtip',
				"bPaginate": false,
				buttons: [
					        'copy', 'csv', 'excel', 'pdf', 'print'
					     ]
			});
		$(".loader").removeAttr("disabled");
		$('.loader').fadeOut(1000);
	});	
}
// end
// send ajax when select branch
function getTechnicianList(){
	$.post("ajaxrequest/executive_ticket.php?token=<?php echo $token;?>",{
		branch : $('#branch').val()
	},
	function(data){
		/*alert(data);*/
		$("#showTechnician").html(data);
		$(".select2").select2();
	});
}
// End
// Branch Confirmation
function getBranchConfirmation(){
	$('.loader').show();
	$.post("ajaxrequest/ticket_branch_confirmation_option.php?token=<?php echo $token;?>",
		function(data){
			/*alert(data);*/
			$("#dvOption").html(data);
			$(".select2").select2();
			$(".loader").removeAttr("disabled");
			$('.loader').fadeOut(1000);
		});	
}
function getPendingBranchConfirmation(){
	$('.loader').show();
    $.post("ajaxrequest/show_ticket_branch_confirmation.php?token=<?php echo $token;?>",
    {
        branch : $('#branch').val(),
    },
    function( data){
        $("#divassign").html(data);
        $('#example').DataTable( {
				dom: 'Bfrtip',
				"bPaginate": false,
				buttons: [
					        'copy', 'csv', 'excel', 'pdf', 'print'
					     ]
		});
        $(".loader").removeAttr("disabled");
        $('.loader').fadeOut(1000);
    });
}
// End
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini" onload="getBranch()">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include_once("includes/header.php") ?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <section class="content-header">
	      <h1>
	        Assign Ticket
	        <!--<small>Control panel</small>-->
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Assign Ticket</li>
	      </ol>
	    </section>
	    <!-- Main content -->
	    <section class="content">
	    	<form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
		    	<div class="row search_grid">
			    	<div class="col-md-12">
			    		<input type="radio" name="rdopt"  value="Active Vehicle"  checked="checked" id="single" onClick="getBranch();" /> <strong>Assign Branch</strong>&nbsp;
			    		<input type="radio" name="rdopt" id="single" onClick="getBranchConfirmation();" /> <strong>Branch Confirmation</strong>&nbsp;
			    		<input type="radio" name="rdopt"  value="In-Active Vehicle"  id="multiple" onClick="getTechnician();"/> <strong>Assign Technician</strong>
			    	</div>
		    		<div class="col-md-12" id="dvOption">
		    			
		    		</div> <!-- end col-md-12 -->
		    	</div> <!-- end row -->
		    	<div class="box box-info">
		            <div class="box-header">
		              <!-- <h3 class="box-title">Details</h3> -->
		            </div>
		            <div class="box-body">
		            	<!-- Show alert  message-->
		            	<?php if(isset($msg)) {?>
		            	<div class="alert alert-success alert-dismissible small-alert" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong><i class="fa fa-check-circle-o" aria-hidden="true"></i></strong> 
						<?= $msg; ?>
						</div>
						<?php } ?>
						<?php if(isset($msgDanger)) {?>
		            	<div class="alert alert-danger alert-dismissible small-alert" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong><i class="fa fa-check-circle-o" aria-hidden="true"></i></strong> 
						  	<?= $msgDanger; ?>
						</div>
						<?php } ?>
						<!-- end alert message -->
		            	<form name='fullform' method='post' onSubmit="return confirmdelete()">
					       <input type="hidden" name="token" value="<?php echo $token; ?>" />
					       <input type='hidden' name='pagename' value='users'> 
					       <div id="divassign" class="table-responsive">
					       	<!-- Show data from ajax request -->
					       </div>
					    </form>
		            </div><!-- /.box-body -->
		        </div> <!-- end box-info -->
		    </form>
	    </section><!-- End Main content -->
	</div> <!-- end content Wrapper-->
	<?php include_once("includes/footer.php") ?>
	<!-- Loader -->
	<div class="loader">
		<img src="images/loader.gif" alt="loader">
	</div>
	<!-- End Loader -->
</div> <!-- End site wrapper -->

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