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
if(isset($_POST["submit"]))
{
	echo 'afafas';
	$id = mysql_real_escape_string($_POST["id"]);
	$battery = mysql_real_escape_string($_POST["battery"]);
	$ignition = mysql_real_escape_string($_POST["ignition"]);
	$location = mysql_real_escape_string($_POST["location"]);
	$sql = "UPDATE tempVehicleData SET battery = '$battery', ignition = '$ignition', location = '$location', configStatus = 'Y' WHERE id = '$id'";
	$result = mysql_query($sql);
	if($result)
	{
		echo  "<script> alert('Vehicle Configuration Successfully '); </script>";
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
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/installed_vehicle_report-temp.js"></script>
<script>
// date picker
 $(function() {
    $( "#date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
  $(function() {
    $( "#dateto" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
 // end 
 // open modal
function getModal(a)
	{
		/*alert(a);*/
		$.post("ajaxrequest/configure_temp_vehicle.php?token=<?php echo $token;?>",
		{
			id : a
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
    	<h3>Vehicle  Report</h3>
        <hr>
    </div>
   
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
    <div class="col-md-12 table-responsive">
     <table class="form-field" width="100%">
     <tr>
     <td>Date (From)* </td>
     <td><input type="text" name="date" id="date" class="form-control text_box-sm"></td>
     <td>Company Name</td>
     <td><select name="company" id="company" class="form-control drop_down-sm">
             <option value="0">All Company</option>                         
             <?php $Country=mysql_query("SELECT B.id as id, B.Company_Name as Company_Name
			 							 FROM tbl_customer_master as A 
										 INNER JOIN tblcallingdata as B
										 ON A.callingdata_id =  B.id Order by Company_Name ASC");								
                   while($resultCountry=mysql_fetch_assoc($Country))
                    {
             ?>
             <option value="<?php echo $resultCountry['id']; ?>">
             <?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
             <?php } ?>
        </select>     </td>
     <td>Technician</td>
     <td><select name="technician" id="technician" class="form-control drop_down drop_down-sm">
       <option value="0">All Technician</option>
       <?php $Country=mysql_query("SELECT * FROM `tbluser` where User_Category=5");								
                  while($resultCountry=mysql_fetch_assoc($Country))
                   {
            ?>
       <option value="<?php echo $resultCountry['id']; ?>"> <?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'])); ?></option>
       <?php } ?>
     </select></td>
     <td>&nbsp;</td>
     <td><p class="ico"><a href="vehicle_report_csv.php?token=<?php echo $token;?>" title="Download CSV"> <span class="glyphicon glyphicon-download-alt"></span></a></p></td>
     </tr>
      <tr>
     <td>Date&nbsp;(To)*</td>
     <td><input type="text" name="dateto" id="dateto" class="form-control text_box-sm"></td>
     <td>Reffered by</td>
     <td><select name="reffered" id="reffered" class="form-control drop_down drop_down-sm">
            <option value="0" selected>All</option>                         
            <?php $Country=mysql_query("SELECT distinct telecaller_id FROM tbl_customer_master");								
                  while($resultCountry=mysql_fetch_assoc($Country))
                   {
            ?>
            <option value="<?php echo $resultCountry['telecaller_id']; ?>">
            <?php echo gettelecallername(stripslashes(ucfirst($resultCountry['telecaller_id']))); ?></option>
            <?php } ?>
            </select>     </td>
     <td>&nbsp;</td>
     <td><input type="button" name="assign" value="Submit" id="submit" class="btn btn-primary btn-sm"  onclick="ShowReport()" />
     	 <input type="button" name="assign" value="Summary" onClick="window.location.replace('installation_summary.php?token=<?php echo $token;?>')" id="submit" class="btn btn-primary btn-sm"  />
     </td>
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
     </table>
    </div>
	
      <div class="col-md-12" style="margin-top:10px;"></div> 
      <!-- Modal -->
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		  <div class="modal-dialog modal-sm">
			<div class="modal-content">
			 <!-- modal body section -->
			</div>
		  </div>
		</div>
	  <!-- end modal -->
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