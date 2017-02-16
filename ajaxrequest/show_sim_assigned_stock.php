<?php
include("../includes/config.inc.php"); 
/*include("../includes/crosssite.inc.php"); */
$branch_id=mysql_real_escape_string($_POST['branch']);
$sim_provider=mysql_real_escape_string($_POST['sim_provider']);
error_reporting(0);
if ($branch_id == 0 && $sim_provider==0)
	{
	$linkSQL = "select * from tblsim as A, 
				tbl_sim_branch_assign as B 
				where A.id = B.sim_id and A.branch_assign_status='1' and A.status_id='0' 
				and B.technician_assign_status = '0'";

	}
	else
	{
		if ($branch_id == 0 && $sim_provider != 0 )
		{
		  $linkSQL = "select * from tblsim as A, tbl_sim_branch_assign as B where A.id = B.sim_id 
		  			  and A.company_id='{$sim_provider}' and A.branch_assign_status='1' 
		  			  and A.status_id='0' and B.technician_assign_status = '0'";
 		}
		if ($branch_id != 0 && $sim_provider == 0 )
		{
		  $linkSQL = "select * from tblsim as A, tbl_sim_branch_assign as B where A.id = B.sim_id 
		  			  and B.branch_id='{$branch_id}' and A.branch_assign_status='1' and A.status_id='0'
					  and B.technician_assign_status = '0'";
		   /*echo $linkSQL;*/
 		}
	}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%"> ';
		?>		
                      <thead>
    	              <tr>
	                  <th><small>S. No.</small></th>                        
	                  <th><small>Provider</small></th>
	                  <th><small>Sim No.</small></th>
	                  <th><small>Mobile No.</small></th>
                      <th><small>Status</small></th>
                      <th><small>Assign Branch</small></th>
                      <th><small>Date of Assigned</small></th>
					  <th><small>Branch Assign by</small></th>
	                  <th><small>Actions&nbsp;&nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                      &nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>
                     </th> 
                     </tr> 
                     </thead>  
					<?php
	  	  			$kolor = 1;
	  				while ($row = mysql_fetch_array($stockArr))
  						{
 					?>
                   <tr <?php print $class?>>
                   <td><small><?php print $kolor++;?>.</small></td>
				   <td><small><?php echo getsimprovider(stripslashes($row["company_id"]));?></small></td>	
                   <td><small><?php echo stripslashes($row["sim_no"]);?>
                   <input type="hidden" name="sim_no" value="<?php echo stripslashes($row["sim_no"]);?>" /></small></td>	
				   <td><small><?php echo stripslashes($row["mobile_no"]);?>
                   <input type="hidden" name="mob_no" value="<?php echo stripslashes($row["mobile_no"]);?>" /></small></td>
                   <td><small><?php echo $stock;?></small></td>
                   <td><small><?php echo getBranch(stripslashes($row["branch_id"]));?></small></td>
                   <td><small><?php echo stripslashes($row["assigned_date"]);?></small></td>
				   <td><small><?php echo gettelecallername(stripslashes($row["assign_by"]));?></small></td>
                  		  
                   <td>
                   <input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                   </tr>
 				   <?php 
	      			}
				}
    			else
   		 			echo "<h3 style='color:red'>No records found!</h3><br><br>";
					?> 
                    	<!-- <form method="post"> -->
                          <table>
                          <tr>
                          
                          <td colspan="3">
                          <button style="submit" name="remove_sim_branch" class="btn btn-danger btn-sm" onclick="return val();" id="submit"><i class="fa fa-trash-o" aria-hidden="true"></i> Remove</button>
                          </td>
                          <td></td>
                          </tr>
                          </table><br />
                   	  <!--   </form> -->   
             