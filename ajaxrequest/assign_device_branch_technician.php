<?php
include("../includes/config.inc.php"); 
include("..includes/crosssite.inc.php"); 
$branch_id = mysql_real_escape_string($_POST['branch']);
/*echo $branch_id;*/
error_reporting(0);
	/*echo $branch_id;*/
if ($branch_id == 0)
{
	$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_branch as B 
				where A.id = B.device_id and B.branch_confirmation_status ='1' and B.technician_assign_status='0' order by device_id";
}
else
	$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_branch as B 
				where A.id = B.device_id and B.branch_confirmation_status ='1' and B.technician_assign_status='0' and B.branch_id='{$branch_id}' order by device_id";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
                 
    	        <tr>
	            <th><small>S. No.</small></th>                        
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
								$class="bgcolor='#DCDCDC'";
  				?>
       			<tr>
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
                <td colspan="3"><input type="submit" name="submit" value="Assign" id="submit" class="btn btn-primary btn-sm" onClick="return val();" /> </td>
                <td></td>
                </tr>
                </table><br />
                </form>   
            