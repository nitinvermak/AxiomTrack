<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
//echo count($_POST['linkID']);
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
	session_destroy();
	header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}
/*-------------- Remove Device From Branch Instock -------------------------- */
if(count($_POST['linkID'])>0 && (isset($_POST['remove'])) ){			   
	$dsl="";
	if(isset($_POST['linkID'])){ 
		//echo 'nitin';
		foreach($_POST['linkID'] as $chckvalue){
			/*  $device_id=$_POST['linkID'][$dsl];*/
	   	  	$branch_id=$_POST['branch'];
		  	$status_id="0";
			$device_model = $_POST['devic_model_id'];
		  	$createdby=$_SESSION['user_id'];
			$sql = "delete from tbl_device_assign_branch where device_id='$chckvalue'";
			/*echo $sql;*/
			$results = mysql_query($sql); 	
			$assign = "Update tbl_device_master set assignstatus='$status_id' where id='$chckvalue'";
			/*echo $sql;*/
			// Call User Activity Log function
			UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
			$sql. "<br>" .$assign);
			$query = mysql_query($assign);
			/* echo $query;*/
	  		$msgDanger = "Device Remove Successfully";
   		}
	}  
	$id="";
}
// end
/*----------------- Assign Device Branch  ----------------*/
if(count($_POST['linkID'])>0 && (isset($_POST['submit'])) ){			   
  	$dsl="";
	// echo 'nitin-submit';
	if(isset($_POST['linkID'])){
		foreach($_POST['linkID'] as $chckvalue){
      		/*  $device_id=$_POST['linkID'][$dsl];*/
      	   	$branch_id=$_POST['branch'];
      		$status_id="1";
      		/*$device_model = $_POST['devic_model_id'];*/
      		$createdby=$_SESSION['user_id']; 
			$check_deviceId = mysql_query("SELECT * FROM tbl_device_assign_branch WHERE device_id='$chckvalue'"); 
            if(mysql_num_rows($check_deviceId) <= 0){
        		$sql = "update tbl_device_master set assignstatus='$status_id' where id='$chckvalue'";
        		//echo $sql;
        		$results = mysql_query($sql); 	
        		$assign = "insert into tbl_device_assign_branch set device_id='$chckvalue', 
        				   assign_by = '$createdby', branch_id='$branch_id', assigned_date=Now()";
        				// Call User Activity Log function
			  	UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
				$sql. "<br>" .$assign);
        		$query = mysql_query($assign);
        		//echo $query; 
        		$msg = "Device Branch Assign Successfully";
			}
			else{
				$msg = "Device already Assign";
			}
   		}
	}  
  	$id="";
}
// end
/*---------------- Assign Device Technician ------------------- */
if(count($_POST['linkID'])>0){			   
  	$dsl="";
	if(isset($_POST['linkID']) && (isset($_POST['submit_technician']))){
		foreach($_POST['linkID'] as $chckvalue){
			$technician_id = $_POST['technician_id'];
			$status_id = "1";
			$createdby = $_SESSION['user_id'];
			$check_deviceId = mysql_query("SELECT * FROM tbl_device_assign_technician 
										   WHERE device_id='$chckvalue'"); 
			if(mysql_num_rows($check_deviceId) <= 0){
				$sql = "insert into tbl_device_assign_technician 
						set device_id='$chckvalue', technician_id ='$technician_id', 
						assigned_by = '$createdby',  assigned_date=Now()";
				$results = mysql_query($sql);
				$assign_technician = "update tbl_device_assign_branch 
									  set technician_assign_status='$status_id' 
									  where device_id='$chckvalue'";
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
				$sql."<br>".$assign_technician);
				$confirm = mysql_query($assign_technician);
				$msg = "Device Branch Assign Successfully";
			}
			else{
				$msgDanger = "Device already Assign";
			}
   		}
	}  
  	$id="";
}
/*---------------- end ------------------------*/
/*-------------------- Remove Device From Technician ------------------------- */
if(count($_POST['linkID'])>0){			   
  	$dsl="";
	if(isset($_POST['linkID']) && (isset($_POST['remove_technician']))){
		foreach($_POST['linkID'] as $chckvalue){
		  	$status_id="0";
			$sql = "DELETE FROM tbl_device_assign_technician where device_id='$chckvalue'";
			/*echo $sql;*/
			$results = mysql_query($sql);
	  		$assign_technician = "update tbl_device_assign_branch 
	  							  set technician_assign_status='$status_id' 
								  where device_id='$chckvalue'";
		 	// Call User Activity Log function
			UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
			$sql."<br>".$assign_technician);
			/*echo $assign_technician;*/
			$confirm = mysql_query($assign_technician);
			$msgDanger = "Device Remove Successfully";
   		}
	}  
  	$id="";
}
/*--------------- end ---------------*/
/*---------------Device Branch Confirmation ----------------*/
if(count($_POST['linkID'])>0){               
    $dsl="";
    if(isset($_POST['linkID']) &&(isset($_POST['deviceConfirm']))){
        foreach($_POST['linkID'] as $chckvalue){
            /*  $device_id=$_POST['linkID'][$dsl];*/
            $branch_id = $_POST['branch'];
            $confirmation_status = "1";
            $confirmBy = $_SESSION['user_id'];
            $sql = "update tbl_device_assign_branch set branch_confirmation_status='$confirmation_status', 
                    confirmBy = '$confirmBy' where device_id='$chckvalue'";
            $results = mysql_query($sql);
            $msg ="Branch Confirmation Successfully";
            // Call User Activity Log function
            UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
                            $sql);
        }
    }  
    $id="";
}
/*-------------- End --------------------------*/

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
	        Assign Device
	        <!--<small>Control panel</small>-->
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Assign Device</li>
	      </ol>
	    </section>
	    <!-- Main content -->
	    <section class="content">
	    	<form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
		    	<div class="row search_grid">
			    	<div class="col-md-12">
			    		<input type="radio" name="rdopt" checked="checked" id="single" onClick="getBranch();" /> <strong>Assign Branch</strong>&nbsp;
			    		<input type="radio" name="rdopt" onClick="getBranchConfirmation();"/> <strong>Branch Confirmation</strong>&nbsp;
			    		<input type="radio" name="rdopt" onClick="getTechnician();"/> <strong>Assign Technician</strong>
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
// Pass Ajax request when view Assigned Devices
function getAssignDevice(){
	$('.loader').show();
	$.post("ajaxrequest/show_assigned_stock.php?token=<?php echo $token;?>",
	{
		branch : $('#branch').val(),
		modelname : $('#modelname').val()
	},
	function( data){
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
// Pass Ajax request when new Device Assign
function getDeviceStock()
{
	$('.loader').show();
	$.post("ajaxrequest/showUnassignedStock.php?token=<?php echo $token;?>",
		{
			modelname : $('#modelname').val()
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
function getBranch(){
	$('.loader').show();
	$.post("ajaxrequest/assign_device_branch_option.php?token=<?php echo $token;?>",
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
	$.post("ajaxrequest/assign_device_techician_option.php?token=<?php echo $token;?>",
		function(data){
			/*alert(data);*/
			$("#dvOption").html(data);
			$(".loader").removeAttr("disabled");
			$('.loader').fadeOut(1000);
		});	
}
// get branch technician
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
// end branch technician
// Get Device Branch Instock
function getDeviceBranch(){
	$('.loader').show();
	$.post("ajaxrequest/assign_device_branch_technician.php?token=<?php echo $token;?>",
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
// get device technician stock
function getDeviceTechnician(){
	$('.loader').show();
	$.post("ajaxrequest/view_assign_device_technician.php?token=<?php echo $token;?>",
		{
			technician_id : $('#technician_id').val(),
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
// Branch Confirmation 
function getBranchConfirmation(){
	$('.loader').show();
	$.post("ajaxrequest/device_branch_confirmation_option.php?token=<?php echo $token;?>",
		function(data){
			/*alert(data);*/
			$("#dvOption").html(data);
			$(".loader").removeAttr("disabled");
			$('.loader').fadeOut(1000);
		});
}
function getPendingConfirmation(){
	$('.loader').show();
    $.post("ajaxrequest/show_branch_device_confirmation.php?token=<?php echo $token;?>",
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