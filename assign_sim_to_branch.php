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
if(count($_POST['linkID'])>0){		
   	//Assign Sim to Branch	   
  	$dsl="";
	if(isset($_POST['sim_assign_branch'])){
		foreach($_POST['linkID'] as $chckvalue){
	   	  	$branch_id=$_POST['branch'];
		  	$status_id="1";
		  	$createdby=$_SESSION['user_id'];
			$check_deviceId = mysql_query("SELECT * FROM tbl_sim_branch_assign WHERE sim_id='$chckvalue'"); 
            if(mysql_num_rows($check_deviceId) <= 0){
				$sql = "update tblsim set branch_assign_status='$status_id' where id='$chckvalue'";
				/*echo $sql;*/
				$results = mysql_query($sql); 	
				$assign = "insert into tbl_sim_branch_assign set sim_id='$chckvalue', 
						   assign_by = '$createdby', branch_id='$branch_id', assigned_date=Now()";
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], 
								$_SERVER['PHP_SELF'], $sql."<br>".$assign);
				$query = mysql_query($assign);
				$msg = "Device Branch Assign Successfully";
			}
			else{
					$msgDanger = "Device already Assign";
			}
		}
	} 
	// end
	//Remove to Branch
	if(isset($_POST['remove_sim_branch'])){
		foreach($_POST['linkID'] as $chckvalue){
	   	  	$branch_id=$_POST['branch'];
		  	$status_id="0";
		  	$createdby=$_SESSION['user_id'];
			$sql = "update tblsim set branch_assign_status='$status_id' where id='$chckvalue'";
			/*echo $sql;*/
			$results = mysql_query($sql); 	
			$assign = "DELETE FROM `tbl_sim_branch_assign` WHERE sim_id='$chckvalue'";
			/*echo $assign;*/
			// Call User Activity Log function
			UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], 
							$_SERVER['PHP_SELF'], $sql."<br>".$assign);
			$query = mysql_query($assign);
			$msgDanger = "Sim Removed";
		}
	}   
  $id="";
}
if(count($_POST['linkID'])>0){			   
  	$dsl="";
	if(isset($_POST['linkID']) && (isset($_POST['assign_technician']))){
		foreach($_POST['linkID'] as $chckvalue){
			$technician_id = $_POST['technician_id'];
			$status = 1;
			$assignby = $_SESSION['user_id'];
			$check_deviceId = mysql_query("SELECT * FROM tbl_sim_technician_assign WHERE sim_id='$chckvalue'"); 
            if(mysql_num_rows($check_deviceId) <= 0){
				$sql = "insert into tbl_sim_technician_assign set sim_id='$chckvalue', assigned_by = '$assignby', 
						technician_id='$technician_id', assigned_date=Now()";
				/*echo $sql;*/
				$results = mysql_query($sql);	
				$assign_techician = "update tbl_sim_branch_assign set technician_assign_status= '$status' 
									 where sim_id='$chckvalue'";
				$query = mysql_query($assign_techician);
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
				$sql."<br>".$assign_techician);
				$msg = "Sim Assign Successfully";	
			}
			else{
					$msgDanger = "Sim already Assign</span>";
				}
		}  		
   	}
}  
$id="";
// Remove Assign Sim
if(isset($_POST['linkID']) && (isset($_POST['remove_technician']))){
	foreach($_POST['linkID'] as $chckvalue){
		$status = 0;
		$sql = "DELETE FROM tbl_sim_technician_assign WHERE sim_id = '$chckvalue'";
		/*echo $sql;*/
		$results = mysql_query($sql);	
		$assign_techician = "update tbl_sim_branch_assign set technician_assign_status= '$status' 
							 where sim_id='$chckvalue'";
		/*echo $assign_techician;*/
		// Call User Activity Log function
		UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
		$sql."<br>".$assign_techician);
		$query = mysql_query($assign_techician);
		$msgDanger = "Sim Removed";   		
   	}
}  
$id="";
/*------------------ Sim Branch Confirmation ------------------*/
if(count($_POST['linkID'])>0){               
    $dsl="";
    if(isset($_POST['linkID'])&&(isset($_POST['simBranchConfirm']))){
        foreach($_POST['linkID'] as $chckvalue){
            $branch_id=$_POST['branch'];
            $confirmation_status="1";
            $createdby = $_SESSION['user_id'];
            $sql = "update tbl_sim_branch_assign set branch_confirmation_status='$confirmation_status', 
                    confirmBy = '$createdby' where branch_id='$branch_id' and sim_id='$chckvalue'";
            // Call User Activity Log function
            UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
            $results = mysql_query($sql);   
            $msg = "Sim Branch Confirmation Successfully";
        }
    }  
    $id="";
}
/*---------------- End Sim Branch Confirmation----------------*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
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
<!-- DataTable CSS -->
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/buttons.dataTables.min.css">
<!-- Jquery -->
<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript" src="js/assign_device_to_branch.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
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
	        Assign Sim
	        <!--<small>Control panel</small>-->
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Assign Sim</li>
	      </ol>
	    </section>
	    <!-- Main content -->
	    <section class="content">
	    	<form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
		    	<div class="row search_grid">
			    	<div class="col-md-12">
			    		<input type="radio" name="rdopt" checked="checked" id="single" onClick="getBranch();" /> <strong>Assign Branch</strong>&nbsp;
			    		<input type="radio" name="rdopt" id="single" onClick="getSimBranchConfirmation();" /> <strong>Branch Confirmation</strong>&nbsp;
			    		<input type="radio" name="rdopt" id="multiple" onClick="getTechnician();"/> <strong>Assign Technician</strong>
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
					       <div id="divassign">
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
<!-- jQuery 2.2.3 -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- DataTable JS -->
<script type="text/javascript" src="assets/plugins/datatables/js/jquery-1.12.3.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.print.min.js"></script>
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
<script type="text/javascript">
function getBranch(){
	$('.loader').show();
	$.post("ajaxrequest/assign_sim_branch_option.php?token=<?php echo $token;?>",
		function(data){
			/*alert(data);*/
			$("#dvOption").html(data);
			$(".loader").removeAttr("disabled");
			$('.loader').fadeOut(1000);
		});	
}
function getTechnician(){
	// alert('asdfas');
	$('.loader').show();
	$.post("ajaxrequest/assign_sim_techician_option.php?token=<?php echo $token;?>",
		function(data){
			/*alert(data);*/
			$("#dvOption").html(data);
			$(".loader").removeAttr("disabled");
			$('.loader').fadeOut(1000);
		});	
}
$(document).on("click","#assignSim", function(){
 
	if($("#branch").val() == '' )
		{
		    $("#branch").focus();
		   	alert("Please Select Branch");
		    return false;
		}
})
// send ajax request when click assign Sim
function showUnassignedStock()
{
	$('.loader').show();
		$.post("ajaxrequest/show_sim_unassigned.php?token=<?php echo $token;?>",
				{
					sim_provider : $('#sim_provider').val(),
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
// send ajax request when click view assigned sim
function showAssignedStock()
{
	$('.loader').show();
		$.post("ajaxrequest/show_sim_assigned_stock.php?token=<?php echo $token;?>",
				{
					sim_provider : $('#sim_provider').val(),
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
// Get Technician list
function getTechnicianList(){
		$('.loader').show();
		$.post("ajaxrequest/get_branch_technician.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#showTechnician").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});
}
// End
// get branch instock
function getBranchInstock(){
	$('.loader').show();
	$.post("ajaxrequest/assign_sim_branch_technician.php?token=<?php echo $token;?>",
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
function getTechnicianInstock(){
	$('.loader').show();
	$.post("ajaxrequest/view_assign_sim_branch_technician.php?token=<?php echo $token;?>",
		{
			technician_id : $('#technician_id').val(),
			branch : $('#branch').val()
		},
		function(data){
			/*alert(data);*/
			$("#divassign").html(data);
			$('#example1').DataTable( {
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
/*------------- Sim Branch confirmation -------------------*/
function getSimBranchConfirmation(){
	$('.loader').show();
	$.post("ajaxrequest/sim_branch_confirmation_option.php?token=<?php echo $token;?>",
		function(data){
			/*alert(data);*/
			$("#dvOption").html(data);
			$(".loader").removeAttr("disabled");
			$('.loader').fadeOut(1000);
		});	
}
function getPendingBranchConfirm(){
	$('.loader').show();
    $.post("ajaxrequest/show_sim_branch_confirmation.php?token=<?php echo $token;?>",
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
</script>
</body>
</html>