<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$telecaller =$_REQUEST['telecaller']; 
error_reporting(0);
	/*echo $branch_id;*/
	$linkSQL = "select * FROM tblcallingdata as A, tblassign as B WHERE A.id = B.callingdata_id and A.calling_status='0' and B.status_id=2 and B.telecaller_id='{$telecaller}'";
	
 
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-hover table-bordered">  ';
?>		
				<tr>
                <th>S. No.</th>     
                <th>Name</th>  
                <th>Company Name</th>   
                <th>Phone</th> 
                <th>Mobile</th> 
                <th>State</th> 
                <th>City</th> 
                <th>Area</th> 
                <th>Actions</th>   
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
              <td>
              <a href="telecalling_form.php?id=<?php echo $row["callingdata_id"]; ?>&token=<?=$token?>">Status</a></td>
              </tr>
 			  <?php 
	      		}
			}
			else
				 echo "<tr><td colspan=6 align=center><h3 style='color:red'>No records found!</h3><br><br></td><tr/></table>";
			 ?> 
               