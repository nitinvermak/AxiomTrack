<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch_id = $_REQUEST['branch']; 
error_reporting(0);
if($branch_id == 0)
{
	$linkSQL =  "select * from 
				 tbl_sim_branch_assign as A
				 INNER JOIN tblsim as B
				 ON A.sim_id = B.id
				 INNER JOIN tblserviceprovider as C
				 ON B.company_id = C.id
				 where A.technician_assign_status='0'";
}
else
{
	$linkSQL =  "select * from 
				 tbl_sim_branch_assign as A
				 INNER JOIN tblsim as B
				 ON A.sim_id = B.id
				 INNER JOIN tblserviceprovider as C
				 ON B.company_id = C.id
				 where A.branch_id = '$branch_id' and A.technician_assign_status='0'";
}
	$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table class="table table-hover table-bordered">  ';
?>		
                <tr>
                <th><small>S. No.</small></th>                     
                <th><small>Provider</small></th>  
                <th><small>Sim No.</small></th>
                <th><small>Mobile No.</small></th>  
				<th><small>Confirm By</small></th>
                <th><small>Branch Assigned Date</small></th>
                <th><small>Status</small></th>
                <th><small>Actions
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All
                </a>&nbsp;&nbsp;
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All 				</a></small>
                </th>   
                </tr>
				<?php
                 $kolor =1;
                 while ($row = mysql_fetch_array($stockArr))
                    {
                        if($row["technician_assign_status"]==0)
                            {
                                $stock ='Assigned';
                            }
                        if($kolor%2==0)
                            $class="bgcolor='#ffffff'";
                        else
                            $class="bgcolor='#fff'";
                 ?>
                    <tr <?php print $class?>>
                    <td><small><?php print $kolor++;?>.</td>
                    <td><small><?php echo stripslashes($row["serviceprovider"]);?></small></td>	
                    <td><small><?php echo getSimNO(stripslashes($row["sim_id"]));?></small></td>	
                    <td><small><?php echo getMobile(stripslashes($row["sim_id"]));?></small></td> 
					<td><small><?php echo gettelecallername(stripslashes($row["confirmBy"]));?></small></td> 
                    <td><small><?php echo stripslashes($row["assigned_date"]);?></small></td>
                    <td><small><?php echo stripslashes($stock);?></small></td>			  
                    <td><input type='checkbox' name='linkID[]' value='<?php echo $row["sim_id"]; ?>'></td>
                    </tr>
                <?php 
                    }
                }
            else
                echo "<h3 style='color:red'>No records found!</h3><br>";
                ?> 
                <form method="post">
                <table>
                <tr>
                <td colspan="3"><input type="submit" name="submit" value="Assign" id="submit" class="btn btn-primary btn-sm" onClick="return val();"  /> </td>
                <td></td>
                </tr>
                </table><br /><br />
                </form> 