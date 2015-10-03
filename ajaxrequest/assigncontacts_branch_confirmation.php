<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$callingcategory =$_REQUEST['callingcat']; 
error_reporting(0);
$linkSQL = "select * from tblcallingdata as A, tblassign as B where A.id = B.callingdata_id and B.status_id='1' and B.callingcategory_id='{$callingcategory}'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table class="table table-hover table-bordered">  ';
?>		
				
                  	   <tr bgcolor='#000000'>
                  	   <th>S. No.</th>   
                  	   <th>Name</th> 
                   	   <th>Company Name</th>
                  	   <th>Phone</th>
                   	   <th>Mobile</th>
                       <th>State</th>
                       <th>City</th>
                       <th>Area</th>
                  	   <th>Actions
                       <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                       &nbsp;&nbsp;
                       <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>                      
                       </div>                 
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
                           <td><?php print $kolor++;?>.</td>
						   <td><?php echo stripslashes($row["First_Name"]." ".$row["Last_Name"]);?></td>
						   <td><?php echo stripslashes($row["Company_Name"]);?></td>
						   <td><?php echo stripslashes($row["Phone"]);?></td>
						   <td><?php echo stripslashes($row["Mobile"]);?></td>
                           <td><?php echo stripslashes($row["State"]);?></td>
                           <td><?php echo stripslashes($row["City"]);?></td>
                           <td><?php echo stripslashes($row["Area"]);?></td>
                           <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                           </tr>
 
	<?php 
	      }

 

	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br><br></td><tr/></table>";
?> 
          				<form method="post">
                          <table>
                          <tr>
                          <td></td>
                          <td colspan="3"><input type="submit" name="submit" class="btn btn-primary" value="Confirm" onClick="return val();" id="submit" /> 						  </td>
                          <td></td>
                          </tr>
                          </table>
                   	    </form>   
                  