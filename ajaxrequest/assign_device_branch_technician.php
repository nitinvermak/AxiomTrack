<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$branch_id=$_REQUEST['branch']; 
error_reporting(0);
	/*echo $branch_id;*/
if ($branch_id == 0)
{
	$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_branch as B 
				where A.id = B.device_id and B.branch_confirmation_status ='1' and B.technician_assign_status='0' order by device_id desc";
}
else
	$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_branch as B 
				where A.id = B.device_id and B.branch_confirmation_status ='1' and B.technician_assign_status='0' and B.branch_id='{$branch_id}'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
                 
    	        <tr>
	            <th>S. No.</th>                        
	            <th>Device Model</th>  
	            <th>Device Id</th>
	            <th>IMEI No.</th>  
	            <th>Branch</th>
	            <th>Actions
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                       	&nbsp;&nbsp;
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>
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
                <td><?php print $kolor++;?>.</td>
				<td><?php echo getdevicename(stripslashes($row["device_name"]));?></td>
                <td><?php echo stripslashes($row["device_id"]);?></td>	
				<td><?php echo getdeviceimei(stripslashes($row["device_id"]));?></td>	
				<td><?php echo getBranch(stripslashes($row["branch_id"]));?></td>			  
                <td><input type='checkbox' name='linkID[]' id="linkID" value='<?php echo $row["device_id"]; ?>'></td>
                </tr>
				<?php }
				}
    		else
   		 		echo "<tr><td colspan=6 align=center><h3 class='color:red'>No records found!</h3></td><tr/></table><br>";
				?> 
                <form method="post">
                <table border="0">
                <tr>
                <td></td>
                <td colspan="3"><input type="submit" name="submit" value="Assign" id="submit" class="btn btn-primary" onClick="return val();" /> </td>
                <td></td>
                </tr>
                </table><br />
                </form>   
            