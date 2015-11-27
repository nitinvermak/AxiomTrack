<?php
include("../includes/config.inc.php"); 
include("..includes/crosssite.inc.php"); 
$date = mysql_real_escape_string($_POST['date']);
$executive = mysql_real_escape_string($_POST['executive']);
echo $date."<br>";
echo $executive;
error_reporting(0);
if ($date == "" || $executive =="")
{
	$linkSQL = "SELECT A.userId as userId, A.timeStamp as Date, A.ipAddress as Ip, 
				A.pageName as pageName, A.detailsString as operation, 
				B.First_Name as fName, B.Last_Name as lName 
				FROM tbluseractivitylog as A
				INNER JOIN tbluser as B 
				ON A.userId = B.id";
 	echo $linkSQL;
}
else
	$linkSQL = "SELECT A.userId as userId, A.timeStamp as Date, A.ipAddress as Ip, 
				A.pageName as pageName, A.detailsString as operation, 
				B.First_Name as fName, B.Last_Name as lName 
				FROM tbluseractivitylog as A
				INNER JOIN tbluser as B 
				ON A.userId = B.id WHERE A.userId = '$executive' or A.timeStamp like '%$date%'";
	echo $linkSQL;
	$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 			echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
                 
    	        <tr>
	            <th><small>S. No.</small></th>                        
	            <th><small>UserName</small></th>  
	            <th><small>IP Address</small></th>
	            <th><small>Page Name</small></th>  
	            <th><small>User Activity</small></th> 
                <th><small>Date Time</small></th>  
                </tr>   
				<?php
	  			$kolor =1;
	  			while ($row = mysql_fetch_array($stockArr))
  						{
 		   					if($kolor%2==0)
								$class="bgcolor='#ffffff'";
		   					else
								$class="bgcolor='#DCDCDC'";
  				?>
       			<tr>
                <td><small><?php print $kolor++;?>.</small></td>
				<td><small><?php echo stripslashes($row["fName"]." ".$row["lName"]);?></small></td>
                <td><small><?php echo stripslashes($row["Ip"]);?></small></td>	
				<td><small><?php echo stripslashes($row["pageName"]);?></small></td>	
				<td><small><?php echo stripslashes($row["operation"]);?></small></td>			  
                <td><small><?php echo stripslashes($row["Date"]);?></small></td>
                </tr>
				<?php }
				}
    			else
   		 		echo "<h3 style='color:red;'>No records found!</h3><br>";
				?> 
                   
            