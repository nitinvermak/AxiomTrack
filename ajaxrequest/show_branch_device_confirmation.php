<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$branch_id=$_REQUEST['branch']; 
error_reporting(0);
if ($branch_id == 0)
	$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_branch as B 
				where A.id = B.device_id and B.branch_confirmation_status ='0'";
else
	$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_branch as B 
				where A.id = B.device_id and B.branch_confirmation_status ='0' and B.branch_id='{$branch_id}'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				 <tr>
	             <th>Sl. No.</th>                        
	             <th>Device Model</th>  
	             <th>Device Id</th>
	             <th>IMEI No.</th>  
	             <th>Status</th>
	             <th>Actions 
                 <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                       	&nbsp;&nbsp;
                 <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>         </th>   
                 </tr>   
	
				<?php
	  		  		$kolor = 1;
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
                <td><?php print $kolor++;?>.</td>
				<td><?php echo getdevicename(stripslashes($row["device_name"]));?></td>
                <td><?php echo stripslashes($row["id"]);?></td>	
				<td><?php echo stripslashes($row["imei_no"]);?></td>
                <td><?php echo stripslashes($row["date_of_purchase"]);?></td>			  
                <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                </tr>
 				<?php }
				}
    			else
   		 			echo "<tr><td colspan=6 align=center><h3 style='color:red'>No records found!</h3></td><tr/></table><br>";
				?> 
                <form method="post">
                <table>
                <tr>
                <td></td>
                <td colspan="3"><input type="submit" name="submit" value="Confirm" onClick="return val();" class="btn btn-primary" id="submit" /> </td>
                <td></td>
                </tr>
                </table>
                </form> 
               