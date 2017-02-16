<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$sim_provider = mysql_real_escape_string($_POST['sim_provider']);
$branch = mysql_real_escape_string($_POST['branch']);
error_reporting(0);
if ($sim_provider == 0)
	{
	$linkSQL = "select * from tblsim where 	branch_assign_status= '0' order by id desc";
	}
		else
			{
				$linkSQL = "select * from tblsim where 	branch_assign_status= '0' and company_id = '{$sim_provider}' order by id desc";
			}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">';
?>		
                 	  <thead>
    	              <tr>
	                  <th><small>S. No.</small></th>                        
	                  <th><small>Provider</small></small></th>  
	                  <th><small>Sim No.</small></th>
	                  <th><small>Mobile No.</small></th>  
	                  <th><small>Date of Purchase</small></th>
                      <th><small>Status</small></th>
	                  <th><small>Actions &nbsp;&nbsp;                 
	                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                      &nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>  
                      </th>   
                  	  </tr>  
                      </thead> 
					  <?php
	  					$kolor =1;
	  					while ($row = mysql_fetch_array($stockArr))
  						{
 		   					if($row["assignstatus"]==0)
								{
									$stock ='<span class="label label-warning">InStock</span>';
								}
							if($row["assignstatus"]==1)
								{
									$stock = '<span class="label label-success">Assigned</span>';
								}
 			
  						?>
          		   <tr <?php print $class?>>
                   <td><small><?php print $kolor++;?>.</small></td>
				   <td><small><?php echo getsimprovider(stripslashes($row["company_id"]));?></small></td>	
                   <td><small><?php echo stripslashes($row["sim_no"]);?></small></td>	
				   <td><small><?php echo stripslashes($row["mobile_no"]);?></small></td>                           	
				   <td><small><?php echo stripslashes($row["date_of_purchase"]);?></small></td>
                   <td><small><?php echo stripslashes($stock);?></small></td>			  
                   <td>
                   <input type='checkbox' class="chk" name='linkID[]' value='<?php echo $row["id"]; ?>' ></td>
                   </tr>
 
	<?php 
	      }

 

	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br></td><tr/></table>";
?> 
<!-- <form method="post"> -->
    <table>
        <tr>            
            <td colspan="3"><input type="submit" name="sim_assign_branch" id="assignSim" class="btn btn-primary btn-sm"  value="Assign" onclick="return val();" /> </td>
            <td></td>
        </tr>
    </table><br /><br />
<!-- </form>   -->                         