<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$branch_id=$_REQUEST['branch'];
$sim_provider=$_REQUEST['sim_provider'];
error_reporting(0);
if ($branch_id == 0 && $sim_provider==0)
	{
	$linkSQL = "select * from tblsim as A, tbl_sim_branch_assign as B where A.id = B.sim_id and A.branch_assign_status='1' and A.status_id='0'";
	}
	else
	{
		if ($branch_id == 0 && $sim_provider != 0 )
		{
		  $linkSQL = "select * from tblsim as A, tbl_sim_branch_assign as B where A.id = B.sim_id and A.company_id='{$sim_provider}'
		   and A.branch_assign_status='1' and A.status_id='0'";
 		}
		if ($branch_id != 0 && $sim_provider == 0 )
		{
		  $linkSQL = "select * from tblsim as A, tbl_sim_branch_assign as B where A.id = B.sim_id and B.branch_id='{$branch_id}' 
		   and A.branch_assign_status='1' and A.status_id='0'";
 		}
	}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table class="table table-hover table-bordered"> ';
		?>		
                 
    	              <tr>
	                  <th><small>S. No.</small></th>                        
	                  <th><small>Provider</small></th>
	                  <th><small>Sim No.</small></th>
	                  <th><small>Mobile No.</small></th>
	                  <th><small>Date of Purchase</small></th>
                      <th><small>Status</small></th>
	                  <th><small>Actions
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                      &nbsp;&nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>
                     </th> 
                     </tr>   
					<?php
	  	  			$kolor = 1;
	  				while ($row = mysql_fetch_array($stockArr))
  						{
 		   					if($row["branch_assign_status"]==0)
								{
									$stock ='In Stock';
								}
							if($row["branch_assign_status"]==1)
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
				   <td><small><?php echo getsimprovider(stripslashes($row["company_id"]));?></small></td>	
                   <td><small><?php echo stripslashes($row["sim_no"]);?>
                   <input type="hidden" name="sim_no" value="<?php echo stripslashes($row["sim_no"]);?>" /></small></td>	
				   <td><small><?php echo stripslashes($row["mobile_no"]);?>
                   <input type="hidden" name="mob_no" value="<?php echo stripslashes($row["mobile_no"]);?>" /></small></td>				   					 				   <td><small><?php echo stripslashes($row["date_of_purchase"]);?></td>
                   <td><small><?php echo stripslashes($stock);?></small></td>			  
                   <td>
                   <input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                   </tr>
 				   <?php 
	      			}
				}
    			else
   		 			echo "<tr><td colspan=6 align=center><h3 style='color:red'>No records found!</h3><br><br></td><tr/></table>";
					?> 
                    	<form method="post">
                          <table>
                          <tr>
                          
                          <td colspan="3"><input type="submit" name="remove" class="btn btn-primary" value="Remove" onClick="return val();" id="submit" /> </td>
                          <td></td>
                          </tr>
                          </table><br />
                   	    </form>   
             