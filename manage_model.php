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
//Delete single record
if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$delete_single_row = "DELETE FROM tbl_device_master WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		$msg = "Device Deleted Successfully";
	}
//End
//Delete multiple records
if(isset($_POST['delete_selected']))
	{
		foreach($_POST['linkID'] as $chckvalue)
        	{
		    	$sql = "DELETE FROM tbl_device_master WHERE id='$chckvalue'";
				$result = mysql_query($sql);
   			}
			if($result)
				{
			   		$msg = "Device Deleted Successfully";
			   	}
	}
//end
if(isset($_POST['instock']))
	{
		echo 'jafhsda';
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
<!-- Validation Js -->
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
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
	        Edit Device Details
	        <!--<small>Control panel</small>-->
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Edit Device Details</li>
	      </ol>
	    </section>
	    <!-- Main content -->
	    <section class="content">
	    	<div class="row search_grid">
	    		<div class="col-md-12">
	    			<form class="form-inline">
					  <div class="form-group">
					    <label for="exampleInputName2">Id or IMEI No.</label>
					    <input type="text" name="search" id="search" class="form-control" placeholder = "Id or IMEI">
					  </div>
					  <input type="button" name="searchBtn" id="searchBtn" onclick="getDeviceDetails()" class="btn btn-primary btn-sm" value="Search">
					</form>
	    		</div> <!-- end col-md-12 -->
	    	</div> <!-- end row -->
	    	<div class="box box-info">
	            <div class="box-header">
	              <!-- <h3 class="box-title">Details</h3> -->
	            </div>
	            <div class="box-body">
	            	<!-- Show alert  message-->
	            	<?php if($_SESSION['sess_msg'] != '') {?>
	            	<div class="alert alert-success alert-dismissible small-alert" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong><i class="fa fa-check-circle-o" aria-hidden="true"></i></strong> 
					  	<?= $_SESSION['sess_msg']; $_SESSION['sess_msg']=''; ?>
					</div>
					<?php } ?>
					<?php if($msg !="") {?>
	            	<div class="alert alert-danger alert-dismissible small-alert" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong><i class="fa fa-check-circle-o" aria-hidden="true"></i></strong> 
					  	<?= $msg; $msg=""; ?>
					</div>
					<?php } ?>
					<!-- end alert message -->
	            	<form name='fullform' method='post' onSubmit="return confirmdelete()">
				       <input type="hidden" name="token" value="<?php echo $token; ?>" />
				       <input type='hidden' name='pagename' value='users'> 
				       <div id="responseText">
				       	<!-- Show data from ajax request -->
				       </div>
				    </form>
	            </div><!-- /.box-body -->
	        </div> <!-- end box-info -->
	    </section><!-- End Main content -->
	</div> <!-- end content Wrapper-->
	<?php include_once("includes/footer.php") ?>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <!-- Show Modal Content From Ajax request-->
	    </div>
	  </div>
	</div>
	<!-- End Modal -->
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
function getDeviceDetails(){
		$('.loader').show();
		$.post("ajaxrequest/show_import_devices.php?token=<?php echo $token;?>",
		{
			searchText : $('#search').val()
		},
		function( data ){
			$("#responseText").html(data);
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
function getForm(obj){
	$('.loader').show();
	$.post("ajaxrequest/change_device_status_form.php?token=<?php echo $token;?>",
	{
		deviceId : obj
	},
	function( data ){
		$(".modal-content").html(data);
		$(".loader").removeAttr("disabled");
	    $('.loader').fadeOut(1000);
	});	
}
function updateDeviceStatus(){
	var status = document.getElementById("status").value;
	if(status == ""){
		alert("Please Select Device Status");
	}
	else{
		$('.loader').show();
		$.post("ajaxrequest/update_device_status.php?token=<?php echo $token;?>",
		{
			deviceId : $('#deviceId').val(),
			devicestatus : $('#status').val()
		},
		function( data ){
			$("#dvAlert").html(data);
			$(".loader").removeAttr("disabled");
		    $('.loader').fadeOut(1000);
		    getDeviceDetails();
		});	
	}
}
</script>
</body>
</html>