<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
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
				where A.id = B.sim_id and B.branch_id='{$branch_id}' and B.branch_confirmation_status='0'";
	}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table class="table table-hover table-bordered">  ';
?>		
                  	  <tr>
	                  <th>S. No.</th>                       
	                  <th>Provider</th> 
	                  <th>Sim No.</th>
	                  <th>Mobile No.</th>
	                  <th>Branch</th>
                      <th>Status</th>
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
                   <td><?php print $kolor++;?>.</td>
				   <td><?php echo getsimprovider(stripslashes($row["company_id"]));?></td>	
                   <td><?php echo stripslashes($row["sim_no"]);?>
                   <input type="hidden" name="sim_no" value="<?php echo stripslashes($row["sim_no"]);?>" /></td>	
				   <td><?php echo stripslashes($row["mobile_no"]);?>
                   <input type="hidden" name="mob_no" value="<?php echo stripslashes($row["mobile_no"]);?>" /></td>     	
				   <td><?php echo getBranch(stripslashes($row["branch_id"]));?></td>
                   <td><?php echo stripslashes($stock);?></td>			  
                   <td>
                   <input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                   </tr>
 				   <?php 
	      			}
				}
    		else
   		 		echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br></td><tr/></table>";
				   ?> 
          		    <form method="post">
                    <table>
                    <tr>
                    <td></td>
                    <td colspan="3"><input type="submit" name="submit" value="Submit" class="btn btn-primary" onClick="return val();" id="submit" /> </td>
                    <td></td>
                    </tr>
                    </table><br /><br />
                   	</form>   
                  