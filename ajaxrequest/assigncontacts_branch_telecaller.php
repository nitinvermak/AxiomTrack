<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$callingcategory =$_REQUEST['callingcat']; 
error_reporting(0);
if($callingcategory == '0')
	{
	$linkSQL = "select * FROM tblcallingdata as A, tblassign as B WHERE A.id = B.callingdata_id and B.status_id=2 and B.telecaller_id=0";
	}
	else
	{
	$linkSQL = "select * FROM tblcallingdata as A, tblassign as B WHERE A.id = B.callingdata_id and B.status_id=2 and B.telecaller_id=0 and callingcategory_id='{$callingcategory}'";
	}
	
 
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-hover table-bordered">  ';
?>		
				       <tr>
                  	   <th><small>S. No.</small></th>     
                  	   <th><small>Name</small></th>
                   	   <th><small>Company Name</small></th>
                  	   <th><small>Phone</small></th>
                   	   <th><small>Mobile</small></th>
                       <th><small>State</small></th>
                       <th><small>City</small></th>
                       <th><small>Area</small></th>
                  	   <th><small>Actions</small></th>
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
				$class="bgcolor='#fff'";
  	
 	?>
    	 				   <tr <?php print $class?>>
                           <td><small><?php print $kolor++;?>.</small></td>
						   <td><small><?php echo stripslashes($row["First_Name"]." ".$row["Last_Name"]);?></small></td>
						   <td><small><?php echo stripslashes($row["Company_Name"]);?></small></td>
						   <td><small><?php echo stripslashes($row["Phone"]);?></small></td>
						   <td><small><?php echo stripslashes($row["Mobile"]);?></small></td>
                           <td><small><?php echo getstate(stripslashes($row["State"]));?></small></td>
                           <td><small><?php echo getcities(stripslashes($row["City"]));?></small></td>
                           <td><small><?php echo getarea(stripslashes($row["Area"]));?></small></td>
                           <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
  	                       </tr>
			<?php }
      echo "</table>";
		}
    else
   		echo "<h3 style='color:red'>No records found!</h3>";
?> 
          				<form method="post">
                        <table>
                        <tr>
                        <td></td>
                        <td colspan="3"><input type="submit" name="submit" value="Assign" class="btn btn-primary" onClick="return val();" id="submit" /> &nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td></td>
                        </tr>
                        </table>
                   	    </form>   
             
 