<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch_id = mysql_real_escape_string($_POST['branch']);
/*echo $branch_id;*/
error_reporting(0);
if ($branch_id == ""){
  $linkSQL = "SELECT * FROM tblcallingdata as A, tblassign as B
              WHERE A.id = B.callingdata_id AND A.status='0'";
  // echo $linkSQL;
}
else{
	$linkSQL = "SELECT * FROM tblcallingdata as A, tblassign as B
              WHERE A.id = B.callingdata_id and A.status='0' and B.branch_id='{$branch_id}'";
  // echo $linkSQL;
}
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table class="table table-bordered table-hover">';
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
                  <th><small>Actions <br>                 
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All 		                  </a>&nbsp;
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck                  All</a>
                  </small>
                  </th>  
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
  	
 	?>
    <tr <?php print $class?>>
      <td><small><?php print $kolor++;?>.</small></td>
			<td><small><?php echo stripslashes($row["First_Name"]." ".$row["Last_Name"]); ?></small></td>
			<td><small><?php echo stripslashes($row["Company_Name"]);?></small></td>
			<td><small><?php echo stripslashes($row["Phone"]);?></small></td>
			<td><small><?php echo stripslashes($row["Mobile"]);?></small></td>
      <td><small><?php echo getstate(stripslashes($row["State"]));?></small></td>
      <td><small><?php echo getcities(stripslashes($row["City"]));?></small></td>
      <td><small><?php echo getarea(stripslashes($row["Area"]));?></small></td>
      <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
    </tr>
	<?php 
	      }
      echo "</table>";
	}
    else
   		 echo "<h3 style='color:red'>No records found!</h3>";
?> 
<form method="post">
  <table>
    <tr>
      <td></td>
      <td colspan="3"><input type="submit" name="remove" value="Remove" class="btn btn-primary btn-sm" onClick="return val();" id="submit" /> </td>
      <td></td>
    </tr>
  </table>
</form>   
         