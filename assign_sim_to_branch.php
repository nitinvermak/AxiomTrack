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
   		//Assign Sim to Branch	   
  		$dsl="";
		if(isset($_POST['submit']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
	   	  		$branch_id=$_POST['branch'];
		  		$status_id="1";
		  		$createdby=$_SESSION['user_id'];
				$sql = "update tblsim set branch_assign_status='$status_id' where id='$chckvalue'";
				/*echo $sql;*/
				$results = mysql_query($sql); 	
				$assign = "insert into tbl_sim_branch_assign set sim_id='$chckvalue', branch_id='$branch_id', assigned_date=Now()";
				/*echo $assign;*/
				$query = mysql_query($assign);
			}
		  } 
		  //Remove to Branch
		  if(isset($_POST['remove']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
	   	  		$branch_id=$_POST['branch'];
		  		$status_id="0";
		  		$createdby=$_SESSION['user_id'];
				$sql = "update tblsim set branch_assign_status='$status_id' where id='$chckvalue'";
				/*echo $sql;*/
				$results = mysql_query($sql); 	
				$assign = "DELETE FROM `tbl_sim_branch_assign` WHERE sim_id='$chckvalue'";
				/*echo $assign;*/
				$query = mysql_query($assign);
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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/assign_sim_to_branch.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).on("click","#assignSim", function(){
 
	if($("#branch").val() == '' )
		{
		    $("#branch").focus();
		   	alert("Please Select Branch");
		    return false;
		}
})
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
    	<h3>Sim Assign</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post'>
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Provider</label>
   		  <select name="sim_provider" id="sim_provider" class="form-control drop_down" >
                <option label="" value="0" selected="selected">All Provider</option>
                <?php $Country=mysql_query("select * from tblserviceprovider order by serviceprovider");
						while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($State_name) && $resultCountry['id']==$State){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?></option>
                <?php } ?>
                </select>
  		</div>
        <div class="form-group">
            <label for="exampleInputEmail2">Branch</label>
            	<select name="branch" id="branch" class="form-control drop_down" >
                <option label="" value="" selected="selected">All Branch</option>
                <?php $Country=mysql_query("select * from tblbranch");
						while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
               <?php } ?>
               </select>
        </div>
  		<input type="button" name="assign" value="Assign Sim" id="submit" class="btn btn-primary btn-sm" onClick="showUnassignedStock()" />
        <input type="button" name="view" id="view" value="View Assigned Sim" class="btn btn-primary btn-sm" onClick="showAssignedStock()"/>
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
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>