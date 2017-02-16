<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch = mysql_real_escape_string($_POST['branch']);
error_reporting(0);
if ($branch == 0)
	{
		$linkSQL = "SELECT First_Name, Last_Name, branch_id, Contact_No, emailid 
					FROM tbluser ORDER BY First_Name";
	}
else
	{
		$linkSQL = "SELECT First_Name, Last_Name, branch_id, Contact_No, emailid 
					FROM tbluser  WHERE branch_id = '$branch' 
					ORDER BY First_Name";
					/*echo $linkSQL;*/
	}
	$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table class="table table-hover table-bordered ">  ';
?>		
				 
                 
    	          <tr>
                  <th><small>S. No.</small></th>  
                  <th><small>Branch Name</small></th> 
                  <th><small>Name</small></th>
                  <th><small>Contact No.</small></th>
                  <th><small>Email Id</small></th> 
                  </tr>    
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 		  	if($kolor%2==0)
				$class="bgcolor='#ffffff'";
			else
				$class="bgcolor='#fff'";
  	
 	?>
          		 <tr <?php print $class?>>
                 <td><small><?php print $kolor++;?>.</small></td>
                 <td><small><?php echo getbranch(stripslashes($row["branch_id"]));?></small></td>
				 <td><small><?php echo $row["First_Name"].' '.$row["Last_Name"];?></small></td>
				 <td><small><?php echo stripslashes($row["Contact_No"]);?></small></td>
                 <td><small><?php echo stripslashes($row["emailid"]);?></small></td>
                 </tr>
 
	<?php 
	      }

 

	}
    else
   		 echo "<h3 style='color:red;'>No records found!</h3><br><br>";
?> 