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
if(isset($_POST['updateStatus']))
{
	$chequeId = mysql_real_escape_string($_POST['chequeId']);
	$chequeStatus = mysql_real_escape_string($_POST['chequeStatus']);
	$date = mysql_real_escape_string($_POST['date']);
	/*echo $chequeId;*/
	$sql = "UPDATE `quickbookpaymentcheque` SET `ClearStatus` = '$chequeStatus', 
			`bankDepositDate` = '$date' WHERE `Id` = '$chequeId'";
	$result = mysql_query($sql);
	if($result)
	{
		$msg = "Status Updated";
	}
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
$(document).ready(function(){
	$('#search').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/cheque_deposit_status_details.php?token=<?php echo $token;?>",
				{
					depositDate : $('#depositDateFrom').val(),
					depositDateTo : $('#depositDateTo').val(),
					branch : $('#branch').val(),
					executive : $('#executive').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".select2").select2();
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
	});
});
// send ajax when select branch
$(document).ready(function(){
	$("#branch").change(function(){
		$.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#showTechnician").html(data);
						$(".select2").select2();
				});
	});
});
// End
// open modal
function getModal(a)
	{
		/*alert(a);*/
		$.post("ajaxrequest/update_cheque_status.php?token=<?php echo $token;?>",
		{
			chequeId : a
		},
		function( data){
			$(".modal-content").html(data);
			$(".select2").select2();
			$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
		});	 
	}
//End
function formValidation(obj){
	if(obj.chequeStatus.value == ""){
		alert("Please Select Cheque Status");
		obj.chequeStatus.focus();
		return false;
	}
	if(obj.date.value == ""){
		alert("Please Provide Date");
		obj.date.focus();
		return false;
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
	        Update Cheque Status
	        <!--<small>Control panel</small>-->
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Update Cheque Status</li>
	      </ol>
	    </section>
	    <!-- Main content -->
	    <section class="content">
	    	<form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
		    	<div class="row search_grid">
			    	<div class="col-lg-12">
			    		<div class="col-lg-6 col-md-6 col-sm-6">
			    			<span><strong>Date (From)</strong> <i class="red">*</i></span>
			    			<input type="text" name="depositDateFrom" id="depositDateFrom" class="form-control date" style="width: 100%">
			    		</div> <!-- end col-md-6 -->
			    		<div class="col-lg-6 col-md-6 col-sm-6">
			    			<span><strong>Date (To)</strong> <i class="red">*</i></span>
			    			<input type="text" name="depositDateTo" id="depositDateTo" class="form-control date" style="width: 100%">
			    		</div> <!-- end col-md-6 -->
			    		<div class="col-lg-6 col-md-6 col-sm-6">
			    			<span><strong>Branch</strong> <i class="red">*</i></span>
			    			<select name="branch" id="branch" class="form-control select2" style="width: 100%">
        						<option label="" value="" selected="selected">All Branch</option>
					            <?php 
					            $branch_sql= "select * from tblbranch ";
					            //echo $branch_sql;
					            $Country = mysql_query($branch_sql);					
					            	while($resultCountry=mysql_fetch_assoc($Country)){
					            ?>
            					<option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            					<?php } ?>
      						</select>
			    		</div> <!-- end col-md-6 -->
			    		<div class="col-lg-6 col-md-6 col-sm-6">
			    			<span><strong>Executive</strong> <i class="red">*</i></span>
			    			<span id="showTechnician">
					       		<select name="executive" id="executive" class="form-control select2" style="width:100%">
					            	<option value="">Select Executive</option>                         
					            </select>
					        </span>
			    		</div> <!-- end col-md-6 -->
			    		<div class="col-lg-6 col-md-6 col-sm-6">
			    			<span><strong>&nbsp;</strong></span><br>
			    			<input type="button" name="search" id="search" value="Search" class="btn btn-primary btn-sm">
			    		</div> <!-- end col-md-6 -->
			    	</div> <!-- end col-md-12 -->
		    	</div> <!-- end row -->
		    	<div class="box box-info">
		            <div class="box-header">
		              <!-- <h3 class="box-title">Details</h3> -->
		            </div>
		            <div class="box-body">
					    <div id="divassign" class="table-responsive">
					    	<?php if(isset($msg)){
					    	?>
					    	<div class="alert alert-success small-alert alert-dismissible" role="alert">
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							  <strong>Success!</strong> <?= $msg ?>
							</div>
					    	<?php 
					    	}
					    	?>
					       	<!-- Show data from ajax request -->
					    </div>
		            </div><!-- /.box-body -->
		        </div> <!-- end box-info -->
		    </form>
	    </section><!-- End Main content -->
	</div> <!-- end content Wrapper-->
	<?php include_once("includes/footer.php") ?>
	<!-- Show Modal Form -->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
  			<!-- Show Content From Ajax Request page -->
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