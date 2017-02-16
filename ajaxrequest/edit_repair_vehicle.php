<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$customerId = mysql_real_escape_string($_POST['customerId']);

$linkSQL = "SELECT A.id, A.mobile_no, A.device_id, A.imei_no, A.techinician_name, 
			B.callingdata_id, C.Company_Name as C_name, A.vehicle_no as V_no, 
			A.vehicle_odometer as v_odometer 
			FROM tbl_gps_vehicle_master as A 
			INNER JOIN tbl_customer_master as B 
			ON A.customer_Id = B.cust_id 
			INNER JOIN tblcallingdata as C 
			ON B.callingdata_id = C.id 
			WHERE B.cust_id = '$customerId'";
$oRS = mysql_query($linkSQL); 
?>
<div class="col-md-12" id="dvSuccess"></div>
<table class="table table-hover table-bordered " >
         <tr>
         <th><small>S. No.</small></th>     
         <th><small>Organization Name</small></th>
         <th><small>Vehicle No</small></th>
         <th><small>Mobile</small></th>
         <th><small>Device Id</small></th>
         <th><small>IMEI</small></th> 
         <th><small>Technician</small></th>    
         <th><small>Action</small></th>   
         </tr>   
         <?php
		 $kolor=1;
		 if(mysql_num_rows($oRS)>0)
		 	{
				while ($row = mysql_fetch_array($oRS))
					{

		?> 
        <tr>
      	<td><small><?php print $kolor++;?>.</small></td>
	  	<td><small><?php echo stripslashes($row["C_name"]);?></small></td>
      	<td><small><?php echo stripslashes($row["V_no"]);?></small></td>
        <td><small><a href="#" data-toggle="modal" data-target="#myModal" 
        			onclick="ChangeMobileNo(<?= $row["mobile_no"]; ?>)">
        			<?php echo getMobile(stripslashes($row["mobile_no"]));?>
        	</a></small></td>
        <td><small>
        	<a href="#" data-toggle="modal" data-target="#myModal" 
        			onclick="ChangeDevice(<?= $row["device_id"]; ?>)">
        	<?php echo stripslashes($row["device_id"]);?>
        	</a></small></td>
        <td><small><?php echo stripslashes($row["imei_no"]);?></small></td>
      	<td><small><?php echo gettelecallername(stripslashes($row["techinician_name"]));?></small></td>
	  	<td><small><a href="#" data-toggle="modal" data-target="#myModal" 
        			onclick="editVehicleForm(<?= $row["id"]; ?>)">
        				<img src='images/edit.png' title='Edit' border='0' />
        			</a>
        	</small></td>
      	</tr>
        <?php }
		}
    else
    	echo "<tr><td colspan=8 align=center><h3 style='color:red'>No records found!</h3><br></td><tr/></table>";
		?> 
         </form>
</table>
