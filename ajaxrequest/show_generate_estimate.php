<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$year=$_REQUEST['year']; 
/*echo 'sadgsdhjk';*/
error_reporting(0);
$linkSQL =  "SELECT * FROM tblesitmateperiod WHERE IntervelYear ='$year'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table class="table table-hover table-bordered">  ';
?>		
			<tr>
	        <th>S. No.</th>                     
	        <th>Year</th>  
	        <th>Payment</th>
	        <th>Generation Status</th>  
	        <th>Generate Date</th>
	        <th>Actions</th>
            </tr>
		 <?php
	  	 $kolor =1;
	  	 while ($row = mysql_fetch_array($stockArr))
  			{
 		   		if($row["technician_assign_status"]==0)
					{
						$stock ='Assigned';
					}
 		   		if($kolor%2==0)
					$class="bgcolor='#ffffff'";
		   		else
					$class="bgcolor='#fff'";
 		 ?>
   			<tr <?php print $class?>   id='<?php echo stripslashes($row["intervalId"]);?>' >
            <td><?php print $kolor++;?>.<input type="hidden" name="interval_Id" id="interval_Id" value="<?php echo stripslashes($row['intervalId']); ?>"></td>
			<td><?php echo stripslashes($row["IntervelYear"]);?><input type="hidden" name="Intervel_Year" id="Intervel_Year" value="<?php echo stripslashes($row["IntervelYear"]);?>"></td>	
            <td><?php echo stripslashes($row["Intervalname"]);?><input type="hidden" name="Interval_name" id="Interval_name" value="<?php echo stripslashes($row["Intervalname"]);?>"></td>	
			<td><?php echo stripslashes($row["GeneratedStatus"]);?><input type="hidden" name="Generated_Status" id="Generated_Status"value="<?php echo stripslashes($row["GeneratedStatus"]);?>"></td>                           	
			<td><?php echo stripslashes($row["GeneratedDate"]);?><input type="hidden" name="gen_date" id="gen_date" value="<?php echo stripslashes($row["GeneratedDate"]);?>"></td>
          	  
            <td>
           	<?php if ($row["GeneratedStatus"] == "N") {?>
            <input type="button" name="submit" value="Go" onclick="this.disabled=true; getValue(<?php echo stripslashes($row['intervalId']); ?>);">
            <?php } 
			else
				{
				}
				?>  
            </td>
            </tr>
		<?php 
	      	}
		}
    else
   		echo "<tr><td colspan=6 align=center><h3 style='color:red'>No records found!</h3><br></td><tr/></table>";
		?> 
       