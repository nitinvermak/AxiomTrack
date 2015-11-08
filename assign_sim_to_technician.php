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
				$technician_id = $_POST['technician_id'];
				$status = 1;
				$sql = "insert into tbl_sim_technician_assign set sim_id='$chckvalue', technician_id='$technician_id', assigned_date=Now()";
				/*echo $sql;*/
				$results = mysql_query($sql);	
				$assign_techician = "update tbl_sim_branch_assign set technician_assign_status= '$status' where sim_id='$chckvalue'";
				$query = mysql_query($assign_techician);
				echo "<script> alert('Techinician Assign Successfully!'); </script>";	 
				}  		
   			  }
			}  
  		$id="";

// Remove Assign Sim

		if(isset($_POST['linkID']) && (isset($_POST['remove'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
				$status = 0;
		   		$sql = "DELETE FROM tbl_sim_technician_assign WHERE sim_id = '$chckvalue'";
				/*echo $sql;*/
				$results = mysql_query($sql);	
				$assign_techician = "update tbl_sim_branch_assign set technician_assign_status= '$status' where sim_id='$chckvalue'";
				/*echo $assign_techician;*/
				$query = mysql_query($assign_techician);
				echo "<script> alert('Sim Removed Successfully!'); </script>";	   		
   			   }
			 }  
  		$id="";

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
<script  src="js/ajax.js"></script>
<!--<script type="text/javascript" src="js/assign_sim_to_technician.js"></script>-->
<script type="text/javascript" src="js/checkbox_validation_assign_pages.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
// pass ajax request when click assign sime
$(document).ready(function(){
	$("#assign_sim").click(function(){
		$('.loader').show();
		$.post("ajaxrequest/assign_sim_branch_technician.php?token=<?php echo $token;?>",
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
// pass ajax request when click view assign
$(document).ready(function(){
	$('#view_assign').click(function(){
	$('.loader').show();
	$.post("ajaxrequest/view_assign_sim_branch_technician.php?token=<?php echo $token;?>",
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
    	<h3>Assign Technician</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post'>
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Branch</label>
            <?php 
			$branchname = $_SESSION['branch'];
			if($branchname == 14)
			{
			?>
    			<select name="branch" id="branch" class="form-control drop_down">
                <option label="" value="" selected="selected">Select Branch</option>
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
                <?php $Country=mysql_query("select * from tblbranch where id = '$branchname'");									  
					   while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                <?php } ?>
                </select>
             <?php }?>
  		</div>
        <div class="form-group">
            <label for="exampleInputEmail2">Technician</label>
            	<select name="technician_id" id="technician_id" class="form-control drop_down">
                <option label="" value="" selected="selected">Technician</option>
                <?php $Country=mysql_query("select * from tbluser where  User_Category=5 or User_Category=8");
						while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
                <?php } ?>
                </select>
        </div>
  		<input type="button" name="assign_sim" id="assign_sim" value="Assign Sim" class="btn btn-primary btn-sm"/>
        <input type="button" name="view_assign" id="view_assign" value="view Assign" class="btn btn-primary btn-sm"  />
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