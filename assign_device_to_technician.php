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


 if(count($_POST['linkID'])>0)
   {			   
  		$dsl="";
		if(isset($_POST['linkID']) && (isset($_POST['submit'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
				$technician_id=$_POST['technician_id'];
		  		$status_id="1";
		  		$createdby=$_SESSION['user_id'];
				$sql = "insert into tbl_device_assign_technician set device_id='$chckvalue', technician_id ='$technician_id', 		 						assigned_date=Now()";
				$results = mysql_query($sql);
				$assign_technician = "update tbl_device_assign_branch set technician_assign_status='$status_id' 
									  where device_id='$chckvalue'";
				/*echo $assign_technician;*/
				$confirm = mysql_query($assign_technician);
   			   }
			 }  
  		$id="";
  
  }
// Remove Assign Device
 if(count($_POST['linkID'])>0)
   {			   
  		$dsl="";
		if(isset($_POST['linkID']) && (isset($_POST['remove'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
		  		$status_id="0";
				$sql = "DELETE FROM tbl_device_assign_technician where device_id='$chckvalue'";
				/*echo $sql;*/
				$results = mysql_query($sql);
	  			$assign_technician = "update tbl_device_assign_branch set technician_assign_status='$status_id' 
									  where device_id='$chckvalue'";
				/*echo $assign_technician;*/
				$confirm = mysql_query($assign_technician);
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
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<script type="text/javascript" src="js/checkbox_validation_assign_pages.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="js/assign_device_to_technician.js"></script>
<script type="text/javascript">
// send ajax request when click assign devices
$(document).ready(function(){
	$('#assign_devices').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/assign_device_branch_technician.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
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
$(document).ready(function(){
	$('#view_assign').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/view_assign_device_technician.php?token=<?php echo $token;?>",
				{
					technician_id : $('#technician_id').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
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
    	<h3>Assign Technician</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Branch</label>
            	<select name="branch" id="branch" class="form-control drop_down">
                <option label="" selected="selected">Select Branch</option>
                <option value="0">All Branch</option>
                <?php $Country=mysql_query("select * from tblbranch");									  
					  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                <?php } ?>
                </select>			
  		</div>
        <div class="form-group">
            <label for="exampleInputEmail2">Technician</label>
            <select name="technician_id" id="technician_id" class="form-control drop_down" onChange="return ShowByTechnician();">
            <option label="" value="" selected="selected">Select Technician</option>
            <?php $Country=mysql_query("select * from tbluser where  User_Category=5 or User_Category=8");
			      while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
            <?php } ?>
            </select>
        </div>
  		<input type="button" name="assign_devices" id="assign_devices" class="btn btn-primary btn-sm" value="Assign Devices"/>
        <input type="button" name="view_assign" id="view_assign" class="btn btn-primary btn-sm" value="View Assigned Devices"/>
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
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>