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
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
// Date picket script
 $(function() {
    $( "#date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
// End Date picker Script
// Send ajax Request when click search button
// send ajax request when click assign devices
$(document).ready(function(){
	$('#searchLog').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/user_activity_details.php?token=<?php echo $token;?>",
				{
					date : $('#date').val(),
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
// end
// End
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
    	<h3>User Activity Log</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Date</label>
            	<input type="text" name="date" id="date" class="form-control text_box-sm">			
  		</div>
        <div class="form-group" id="showTechnician">
            <label for="exampleInputEmail2">Executive*</label>
            	 <select name="executive" id="executive" class="form-control drop_down">
            		 <option value="0">All Technician</option>
					   <?php $Country=mysql_query("SELECT * FROM `tbluser`");								
                                  while($resultCountry=mysql_fetch_assoc($Country))
                                   {
                       ?>
                     <option value="<?php echo $resultCountry['id']; ?>"> 
					 	<?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'])); ?>
                     </option>
					   <?php } ?>
            	 </select>
        </div>
  		<input type="button" name="searchLog" id="searchLog" class="btn btn-primary btn-sm" value="Search"/>
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request --->
      </div>
    </form>
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