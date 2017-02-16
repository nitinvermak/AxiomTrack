<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$telecaller =$_REQUEST['telecaller']; 
error_reporting(0);
	/*echo $branch_id;*/
	$linkSQL = "select * FROM tblcallingdata as A, tblassign as B WHERE A.id = B.callingdata_id and A.calling_status='0' and B.status_id=2 and B.telecaller_id='{$telecaller}'";
	// echo $linkSQL; 
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
              <td><small><?php print $kolor++;?>.</td>
			  <td><small><?php echo stripslashes($row["First_Name"]." ".$row["Last_Name"]);?></small></td>
			  <td><small><?php echo stripslashes($row["Company_Name"]);?></small></td>
			  <td><small><?php echo stripslashes($row["Phone"]);?></small></td>
			  <td><small><?php echo stripslashes($row["Mobile"]);?></small></td>
              <td><small><?php echo stripslashes($row["State"]);?></small></td>
              <td><small><?php echo stripslashes($row["City"]);?></small></td>
              <td><small><?php echo stripslashes($row["Area"]);?></small></td>
              <td><small>
              <a href="telecalling_form.php?id=<?php echo $row["callingdata_id"]; ?>&token=<?=$token?>">Status</a></small></td>
              </tr>
 			  <?php 
	      		}
			}
			else
				 echo "<h3 style='color:red'>No records found!</h3><br><br>";
			 ?> 
               