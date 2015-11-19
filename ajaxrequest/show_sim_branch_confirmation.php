<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch_id=$_REQUEST['branch']; 
error_reporting(0);
if($branch_id == 0)
	{
	$linkSQL = "select * from tblsim as A, tbl_sim_branch_assign as B 
				where A.id = B.sim_id and B.branch_confirmation_status='0'";
	}
else
	{
	$linkSQL = "select * from tblsim as A, tbl_sim_branch_assign as B 
				where A.id = B.sim_id and B.branch_id='{$branch_id}' 
				and B.branch_confirmation_status='0'";
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
	                  <th><small>Branch</small></th>
                      <th><small>Status</small></th>
	                  <th><small>Actions</small>
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">
                      Check All </a>
                      &nbsp;&nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">			   					  Uncheck All </a>
                      </th>  
                  	  </tr>
                 
 					  <?php
	  					$kolor =1;
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
                   <td><small><?php print $kolor++;?>.</td>
				   <td><small><?php echo getsimprovider(stripslashes($row["company_id"]));?></small></td>	
                   <td><small><?php echo stripslashes($row["sim_no"]);?>
                   <input type="hidden" name="sim_no" value="<?php echo stripslashes($row["sim_no"]);?>" /></small></td>	
				   <td><small><?php echo stripslashes($row["mobile_no"]);?>
                   <input type="hidden" name="mob_no" value="<?php echo stripslashes($row["mobile_no"]);?>" /></small></td>     	
				   <td><small><?php echo getBranch(stripslashes($row["branch_id"]));?></small></td>
                   <td><small><?php echo stripslashes($stock);?></small></td>			  
                   <td>
                   <input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                   </tr>
 				   <?php 
	      			}
				}
    		else
   		 		echo "<h3 style='color:red;'>No records found!</h3><br>";
				   ?> 
          		    <form method="post">
                    <table>
                    <tr>
                    <td colspan="3"><input type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm" onClick="return val();" id="submit" /> </td>
                    <td></td>
                    </tr>
                    </table><br /><br />
                   	</form>   
                  