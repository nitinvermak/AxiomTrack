<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$technician_id = mysql_real_escape_string($_POST['technician_id']); 
/*echo $technician_id;*/
error_reporting(0);
if ($technician_id == 0)
{
	$linkSQL = "SELECT * FROM tbl_device_master as A
				INNER JOIN tbl_device_assign_branch as B
				ON A.id = B.device_id
				INNER JOIN tbl_device_assign_technician as C
				ON B.device_id = C.device_id where A.status='0' order by C.device_id";
}
else
	$linkSQL = "SELECT * FROM tbl_device_master as A
				INNER JOIN tbl_device_assign_branch as B
				ON A.id = B.device_id
				INNER JOIN tbl_device_assign_technician as C
				ON B.device_id = C.device_id WHERE C.technician_id='{$technician_id}' and A.status='0' order by C.device_id";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
	            <th><small>S. No.</small></td>                        
	            <th><small>Device Model</small></th>  
	            <th><small>Device Id</small></th>
	            <th><small>IMEI No.</small></th>  
	            <th><small>Branch</small></th>
	            <th><small>Actions 
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                &nbsp;&nbsp;
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>
                </th>   
                </tr>   
				<?php
	  			$kolor =1;
	  				while ($row = mysql_fetch_array($stockArr))
  						{
 		   					if($row["assignstatus"]==0)
								{
									$stock ='In Stock';
								}
		   					if($row["assignstatus"]==1)
								{
									$stock = 'Assigned';
								}
 		   					if($kolor%2==0)
								$class="bgcolor='#ffffff'";
		   					else
								$class="bgcolor='#fff'";	
 				?>
       			<tr <?php print $class?>>
                <td><small><?php print $kolor++;?>.</small></td>
				<td><small><?php echo getdevicename(stripslashes($row["device_name"]));?></small></td>
                <td><small><?php echo stripslashes($row["device_id"]);?></small></td>	
				<td><small><?php echo getdeviceimei(stripslashes($row["device_id"]));?></small></td>	
				<td><small><?php echo getBranch(stripslashes($row["branch_id"]));?></small></td>			  
                <td><input type='checkbox' name='linkID[]' id="linkID" value='<?php echo $row["device_id"]; ?>'></td>
                </tr>	
				<?php }
				}
    			else
   		 			echo "<h3 style='color:red;'>No records found!</h3><br>";
				?> 
                <form method="post">
                <table border="0">
                <tr>
                <td></td>
                <td colspan="3"><input type="submit" name="remove" value="Remove" class="btn btn-primary btn-sm" id="remove" onClick="return val();" /> </td>
                <td></td>
                </tr>
                </table>
                </form>   
                