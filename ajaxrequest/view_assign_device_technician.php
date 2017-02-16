<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$technician_id = mysql_real_escape_string($_POST['technician_id']); 
$branch = mysql_real_escape_string($_POST['branch']);
error_reporting(0);
	$linkSQL = "SELECT * FROM tbl_device_master as A
				INNER JOIN tbl_device_assign_branch as B
				ON A.id = B.device_id
				INNER JOIN tbl_device_assign_technician as C
				ON B.device_id = C.device_id where A.status='0'";
/*echo $linkSQL;*/	
if ( ($technician_id != 0) or ( $branch != 0) )
{
	$linkSQL  = $linkSQL." And ";	
	/*echo $linkSQL;	*/
}
$counter = 0;
if ( $technician_id != 0 ) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." C.technician_id = '$technician_id' ";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $branch != 0 ) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." B.branch_id = '$branch' ";
	$counter+=1;
	/*echo $linkSQL;*/
}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">  ';
?>			  <thead>
				<tr>
		            <th><small>S. No.</small></td>                        
		            <th><small>Device Model</small></th>  
		            <th><small>Device Id</small></th>
		            <th><small>IMEI No.</small></th>  
		            <th><small>Branch</small></th>
	                <th><small>Assign Technician</small></th>
	                <th><small>Assign Date</small></th>
					<th><small>Technician Assign by</small></th>
		            <th><small>Actions &nbsp;
		                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
		                &nbsp;
		                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>
	                </th>   
                </tr>
             </thead>
            <tbody>
			<?php
	  		$kolor =1;
	  		while ($row = mysql_fetch_array($stockArr)){
 		   	if($row["assignstatus"]==0){
				$stock ='In Stock';
			}
		   	if($row["assignstatus"]==1){
				$stock = 'Assigned';
			}
 			?>
       		<tr>
	            <td><small><?php print $kolor++;?>.</small></td>
				<td><small><?php echo getdevicename(stripslashes($row["device_name"]));?></small></td>
	            <td><small><?php echo stripslashes($row["device_id"]);?></small></td>	
				<td><small><?php echo getdeviceimei(stripslashes($row["device_id"]));?></small></td>	
				<td><small><?php echo getBranch(stripslashes($row["branch_id"]));?></small></td>
	            <td><small><?php echo gettelecallername(stripslashes($row["technician_id"]));?></small></td>
	            <td><small><?php echo stripslashes($row["assigned_date"]);?></small></td>
				<td><small><?php echo gettelecallername(stripslashes($row["assigned_by"]));?></small></td>				
	            <td><input type='checkbox' name='linkID[]' id="linkID" value='<?php echo $row["device_id"]; ?>'></td>
            </tr>	
			<?php }
			}
    		?> 
    		</tbody>
    		</table>
            <form method="post">
                <table border="0">
                <tr>
	                <td colspan="3"><input type="submit" name="remove_technician" value="Remove" class="btn btn-danger btn-sm" id="remove" onClick="return val();" /> </td>
	                <td></td>
                </tr>
                </table>
            </form>   
                