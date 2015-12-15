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
 if(count($_POST['linkID'])>0 && (isset($_POST['remove'])) )
   {			   
  		$dsl="";
		if(isset($_POST['linkID']))
     		{ //echo 'nitin';
			  foreach($_POST['linkID'] as $chckvalue)
              {
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
	  			     $_SESSION['sess_msg']="Device Remove Successfully";
   			      }
			   }  
  		$id="";
  
  }
  if(count($_POST['linkID'])>0 && (isset($_POST['submit'])) )
   {			   
  		$dsl="";
		// echo 'nitin-submit';
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
      		        /*  $device_id=$_POST['linkID'][$dsl];*/
      	   	  		$branch_id=$_POST['branch'];
      		  		$status_id="1";
      				/*$device_model = $_POST['devic_model_id'];*/
      		  		$createdby=$_SESSION['user_id']; 
      	          	$check_deviceId = mysql_query("SELECT * FROM tbl_device_assign_branch WHERE device_id='$chckvalue'") 
                  	or die(mysql_error());
					if(!$row = mysql_fetch_array($check_deviceId) or die(mysql_error()))
					{
        				$sql = "update tbl_device_master set assignstatus='$status_id' where id='$chckvalue'";
        				//echo $sql;
        				$results = mysql_query($sql); 	
        				$assign = "insert into tbl_device_assign_branch set device_id='$chckvalue', assign_by = '$createdby', 
                       			  branch_id='$branch_id', assigned_date=Now()";
        				// Call User Activity Log function
			  			UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
						$sql. "<br>" .$assign);
        				$query = mysql_query($assign);
        				//echo $query; 
        				$_SESSION['sess_msg']="Device Branch Assign Successfully";
					}
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
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript" src="js/assign_device_to_branch.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
// Pass Ajax request when view Assigned Devices
$(document).ready(function(){
	$('#viewAssignedDevices').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/show_assigned_stock.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val(),
					modelname : $('#modelname').val()
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	 
	});
});
// end
// Pass Ajax request when new Device Assign
$(document).ready(function(){
	$('#assignDevices').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/showUnassignedStock.php?token=<?php echo $token;?>",
				{
					modelname : $('#modelname').val()
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
    	<h3> Assign</h3>
      <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Device Name</label>
    			<select name="modelname" id="modelname"  class="form-control drop_down">
                <option label="" value="0" selected="selected">All Device</option>
                <?php $Model = mysql_query("select * from tbldevicemodel order by model_name");
							   while($resultModel = mysql_fetch_assoc($Model)){
                ?>
                <option value="<?php echo $resultModel['device_id']; ?>" 
							   <?php if(isset($State_name) && $resultModel['device_id']==$State){ ?>selected<?php } ?>>
							   <?php echo stripslashes(ucfirst($resultModel['model_name'])); ?></option>
                               <?php } ?>
                </select>
  		</div>
        <div class="form-group">
            <label for="exampleInputEmail2">Branch</label>
           	<select name="branch" id="branch" class="form-control drop_down">
            <option label="" value="" selected="selected">Select Branch</option>
            
              <?php 
			  		$branch_sql= "select * from tblbranch ";
					
					$Country = mysql_query($branch_sql);								  
					while($resultCountry=mysql_fetch_assoc($Country)){
			  ?>
              <option value="0">All Branch</option>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
            </select>
        </div>
  		<input type="button" name="assign" value="Assign Devices" id="assignDevices" class="btn btn-primary btn-sm" />
        <input type="button" name="view" id="viewAssignedDevices" value="View Assigned Devices" class="btn btn-primary btn-sm"/>
      </div> 
	  <!-- Show Assign Success message -->
	  <div class="col-md-12"> 
        <!--  <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>-->
             <?php if($_SESSION['sess_msg']!='')
                {
                    echo "<p class='success-msg'>".$_SESSION['sess_msg'];$_SESSION['sess_msg']=''."</p>";
                } 
             ?>
       <!--   </div>-->
	  </div>
	  <!----- End --->
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request -->
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