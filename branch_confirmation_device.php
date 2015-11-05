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
		if(isset($_POST['linkID']) &&(isset($_POST['submit'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
		        /*  $device_id=$_POST['linkID'][$dsl];*/
	   	  		$branch_id=$_POST['branch'];
		  		$confirmation_status="1";
		  		$createdby=$_SESSION['user_id'];
	            $sql = "update tbl_device_assign_branch set branch_confirmation_status='$confirmation_status' 
						where branch_id='$branch_id' and device_id='$chckvalue'";
				
				$results = mysql_query($sql);
		  		$_SESSION['sess_msg']="State deleted successfully";
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
<script type="text/javascript">
$(document).ready(function(){
	$('#branch').change(function(){
		$('.loader').show();
		$.post("ajaxrequest/show_branch_device_confirmation.php?token=<?php echo $token;?>",
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
    	<h3>Confirm Received Devices</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail2">Branch</label>
            <?php 
			$branchname = $_SESSION['branch'];
			if($branchname == 14)
			{	
			?>
            <select name="branch" id="branch" class="form-control drop_down">
            <option label="" value="" selected="selected">Select Branch</option>
            <option value="0">All Branch</option>
              <?php $Country=mysql_query("select * from tblbranch");									  
					while($resultCountry=mysql_fetch_assoc($Country)){
			  ?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
            </select>
            <?php
			}
			else
			{
			?>
            <select name="branch" id="branch" class="form-control drop_down">
            <option label="" value="" selected="selected">Select Branch</option>
              <?php $Country=mysql_query("SELECT * FROM tblbranch WHERE id = '$branchname'");									  
					while($resultCountry=mysql_fetch_assoc($Country)){
			  ?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
            </select>
            <?php
			} ?>
        </div>
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