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
		$delete_single_row = "DELETE FROM tbl_gps_vehicle_master WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		echo "<script> alert('Record Delted Successfully'); </script>";
	}
//End
//Delete multiple records
if(isset($_POST['delete_selected']))
	{
		foreach($_POST['linkID'] as $chckvalue)
        	{
		    	$sql = "DELETE FROM tbl_gps_vehicle_master WHERE id='$chckvalue'";
				$result = mysql_query($sql);
   			}
			if($result)
				{
			   		echo "<script> alert('Records Deleted Successfully'); </script>";
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
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
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
    	<h3>Vehicle Details</h3>
        <hr>
    </div>
    <div class="col-md-12">
    	<div class="col-md-4 btn_grid">
        <form name='fullform1'  method='post'>       	
     	<input type='button' name='cancel' class="btn btn-primary" value="Add New" onClick="window.location.replace('add_gps_vehicle.php?token=<?php echo $token ?>')"/>
       &nbsp;&nbsp;&nbsp;
        	 <input type="submit" name="delete_selected" onClick="return val();" class="btn btn-primary" value="Delete Selected">
        </form>
        </div>
    </div>
    <div class="col-md-12">
        
    <div class="table-responsive">
      <table class="table table-hover table-bordered ">
      <?php
		$where='';
		$linkSQL="";			
  		if(!isset($linkSQL) or $linkSQL =='')		
     	$linkSQL = "SELECT A.id, C.Company_Name as C_name, A.vehicle_no as V_no, A.vehicle_odometer as v_odometer
					FROM tbl_gps_vehicle_master as A 
					INNER JOIN tbl_customer_master as B 
					ON A.customer_Id = B.cust_id
					INNER JOIN tblcallingdata as C 
					ON B.callingdata_id = C.id order by C.Company_Name";
   		$pagerstring = Pages($linkSQL,PER_PAGE_ROWS,'manage_vehicle.php?',$token);
 		if(isset($_SESSION['linkSQL']))
 		$mSQL=$_SESSION['linkSQL']." ".$_SESSION['limit'];
 		$oRS = mysql_query($mSQL); 
 		?>
       <form name='fullform' method='post' onSubmit="return confirmdelete()">
       <input type="hidden" name="token" value="<?php echo $token; ?>" />
       <input type='hidden' name='pagename' value='users'>            	        
       <?php if($_SESSION['sess_msg']!=''){?>
                <center>
                <div style="color:#009900; padding:0px 0px 10px 0px; font-weight:bold;"><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></div>
                </center>
       <?php } ?>
      <tr>
      <th>S. No.</th>     
      <th>Organization Name</th>
      <th>Vehicle No</th> 
      <th>Vehicle ODO Meter</th>    
      <th>Action              
      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
      &nbsp;&nbsp;
      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>           </th>   
      </tr>    
	  <?php
		$kolor=1;
		if(isset($_GET['page']) and is_null($_GET['page']))
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']==1)
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']>1)
			{
				$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
			}
	  if(mysql_num_rows($oRS)>0)
	  	{
  			while ($row = mysql_fetch_array($oRS))
  			{
  				if($kolor%2==0)
					$class="bgcolor='#ffffff'";
				else
					$class="bgcolor='#fff'";
 	  ?>
      <tr <?php print $class?>>
      <td><?php print $kolor++;?>.</td>
	  <td><?php echo stripslashes($row["C_name"]);?></td>
      <td><?php echo stripslashes($row["V_no"]);?></td>
      <td><?php echo stripslashes($row["v_odometer"]);?></td>
	  <td><?php if($row["id"]!=1){?><a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_city.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " ><img src="images/drop.png" title="Delete" border="0" /></a> <?php } ?>    <?php if($row["id"]!=1){?> <a href="add_gps_vehicle.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><?php } else {?> <a href="change_password.php?cid=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> <?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?></td>
      </tr>
<?php }
		echo $pagerstring;
	  }
    else
    echo "<tr><td colspan=6 align=center><h3 style='color:red'>No records found!</h3><br></td><tr/></table>";
?> 
	</form>
    </table>
    </div>
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