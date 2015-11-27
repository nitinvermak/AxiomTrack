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
		echo "<script> alert('Status Updated'); </script>";
	}
}
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
<script type="text/javascript" src="js/installed_vehicle_report.js"></script>
<script type="text/javascript">
//date function
$(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
});
$(document).on("click","#date", function(){
	$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
});
// end date function
$(document).ready(function(){
	$('#search').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/cheque_deposit_status_details.php?token=<?php echo $token;?>",
				{
					depositDate : $('#depositDate').val(),
					branch : $('#branch').val(),
					executive : $('#executive').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
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
		});	 
	}
//End
</script>
</head>
<body>
<!--open of the wraper-->
<div id="wraper">
	<!--include header-->
    <?php include_once('includes/header.php');?>
    <!--end-->
    <!--open of the content-->
<div class="row" id="content">
	<div class="col-md-12">
    	<h3>Update Cheque Status</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail2">Deposit Date</label>
            <input type="text" name="depositDate" id="depositDate" class="form-control text_box date">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail2">Branch</label>
            <select name="branch" id="branch" class="form-control drop_down">
        	<option label="" value="" selected="selected">Select Branch</option>
            <?php 
            $branch_sql= "select * from tblbranch ";
            //echo $branch_sql;
            $Country = mysql_query($branch_sql);					
            	while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
           
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
      		</select>
        </div>
         <div class="form-group" >
            <label for="exampleInputEmail2">Executive</label>
            <span id="showTechnician">
            <select name="executive" id="executive" class="form-control drop_down-sm">
            <option value="">Select Executive</option>                         
            </select>
           	</span>
        </div>
        <div class="form-group" >
        <input type="button" name="search" id="search" value="Search" class="btn btn-primary btn-sm">
        </div>
  		</div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request --->
      </div>
    </form>
    <!----- Show Modal Form -------->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
  
    	</div>
    </div>
	</div>
    <!----- End Modal ------------>
  
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