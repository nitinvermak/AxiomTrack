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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#submit').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/device_report_details.php?token=<?php echo $token;?>",
				{
					assignedStatus : $('#assignedStatus').val(),
					branch	:	$('#branch').val(),
					finalStatus	:	$('#finalStatus').val(),
					executive	:	$('#executive').val()
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
    	<h3>Device Report</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<table>
        <tr>
        <td width="116"><strong>Assigned Status</strong></td>
        <td width="144">
        <select name="assignedStatus" id="assignedStatus" class="form-control drop_down">
        <option value="">All</option>
        <option value="1">Assign</option>
        <option value="0">Instock</option>
        </select>
        </td>
        <td width="68"><strong>Branch</strong></td>
        <td width="166">
        <select name="branch" id="branch" class="form-control drop_down">
            <option label="" value="" selected="selected">Select Branch</option>
            
              <?php 
			  		$branch_sql= "select * from tblbranch ";
					$Country = mysql_query($branch_sql);					
					while($resultCountry=mysql_fetch_assoc($Country)){
			  ?>
            <option value="0">All Branch</option>
            <option value="<?php echo $resultCountry['id']; ?>" >
			<?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?>
            </option>
            <?php } ?>
        </select>
        </td>
        <td width="417"></td>
        </tr>
        <tr>
        <td><strong>Final Status</strong></td>
        <td>
        <select name="finalStatus" id="finalStatus" class="form-control drop_down">
        	<option value="0">All</option>
            <option value="0">Instock</option>
            <option value="1">Installed</option>
        </select>
        </td>
        <td><strong>Executive</strong></td>
        <td>
         <select name="executive" id="executive" class="form-control drop_down">
            <option label="" value="" selected="selected">Select Executive</option>
            
              <?php 
			  		$sqlUsers = "select * from tbluser";
					$result = mysql_query($sqlUsers);					
					while($resultArr = mysql_fetch_assoc($result)){
			  ?>
            <option value="0">All Executive</option>
            <option value="<?php echo $resultArr['id']; ?>" >
			<?php echo $resultArr['First_Name']." ".$resultArr['Last_Name'];  ?>
            </option>
            <?php } ?>
        </select>
        </td>
        <td><input type="button" name="assign" value="Search" id="submit" class="btn btn-primary btn-sm" /></td>
        </tr>
        </table>
      </div> 
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