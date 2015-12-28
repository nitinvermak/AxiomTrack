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
		$delete_single_row = "DELETE FROM tblsim WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		echo "<script> alert('Record Delted Successfully'); </script>";
	}
//End
//Delete  multiple records
if(count($_POST['linkID'])>0 && (isset($_POST['delete_selected'])) )
   {			   
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
		       	$sql = "DELETE FROM tblsim WHERE id='$chckvalue'";
				$result = mysql_query($sql);
			  }
			  if($result)
			  {
			    echo "<script> alert('Records Deleted Successfully'); </script>";
			  }
			}    
  }
//end
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
<script>
// send ajax when select branch
$(document).ready(function(){
	$("#branch").change(function(){
		$.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#showExecutive").html(data);
				});
	});
});
// End

// send ajax 
$(document).ready(function(){
	$("#deviceStatusReport").click(function(){
		$.post("ajaxrequest/device_activation_status_details.php?token=<?php echo $token;?>",
				{
					company : $('#company').val(),
					branch : $('#branch').val(),
					executive : $('#executive').val(),
					serviceAreaMgr : $('#serviceAreaMgr').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
				});
	});
});
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
    	<h3>Device Status</h3>
        <hr>
    </div>
   
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
    <div class="col-md-12 table-responsive">
     <table class="form-field" width="100%">
     <tr>
     <td width="13%">Company Name</td>
     <td width="19%">
     <select name="company" id="company" class="form-control drop_down-sm">
       <option value="0">All Company</option>
       <?php $Country=mysql_query("SELECT B.id as id, B.Company_Name as Company_Name
			 							 FROM tbl_customer_master as A 
										 INNER JOIN tblcallingdata as B
										 ON A.callingdata_id =  B.id Order by Company_Name ASC");								
                   while($resultCountry=mysql_fetch_assoc($Country))
                    {
             ?>
       <option value="<?php echo $resultCountry['id']; ?>"> 
	   <?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?>
       </option>
       <?php } ?>
     </select>
     </td>
     <td width="13%">Branch</td>
     <td width="18%"><select name="branch" id="branch" class="form-control drop_down-sm">
       <option label="" value="" selected="selected">Select Branch</option>
       <option value="0">All Branch</option>
       <?php 
			  		$branch_sql= "select * from tblbranch ";
					
					$Country = mysql_query($branch_sql);								  
					while($resultCountry=mysql_fetch_assoc($Country)){
			  ?>
       <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
       <?php } ?>
     </select></td>
     <td width="13%">&nbsp;</td>
     <td width="20%">&nbsp;</td>
     <td width="2%">&nbsp;</td>
     <td width="2%"></td>
     </tr>
      <tr>
     <td>Service Area Mgr.</td>
     <td>
     	<select name="serviceAreaMgr" id="serviceAreaMgr"  class="form-control drop_down-sm">
                 <option value="">Select Area Mgr.</option>
                 <?php $Country=mysql_query("select * from tbluser where User_Category='9'");
					   while($resultCountry=mysql_fetch_assoc($Country)){
				 ?>
                 <option value="<?php echo $resultCountry['id']; ?>" 
				 <?php if(isset($result['service_area_manager']) && $resultCountry['id']==$result['service_area_manager']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?>
                 </option>
                 <?php } ?>
          </select>
     </td>
     <td>Service Executive</td>
     <td><div id="showExecutive">
       <select name="executive" id="executive" class="form-control drop_down drop_down-sm">
         <option value="" selected>Select Executive</option>
       </select>
     </div></td>
     <td><input type="button" name="deviceStatusReport" value="Submit" id="deviceStatusReport" class="btn btn-primary btn-sm"/></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Vehicle No.</td>
        <td><input type="text" name="vehicleNo" id="vehicleNo" class="form-control text_box"></td>
        <td><input type="button" name="submit" value="Submit" id="submit2" class="btn btn-primary btn-sm"  onclick="ShowReport()" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     </table>
    </div>
	
      <div class="col-md-12" style="margin-top:10px;"></div> 
      
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
		
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
<script src="js/bootstrap.min.js"></script>
</body>
</html>