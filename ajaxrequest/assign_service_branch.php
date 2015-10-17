<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$searchText = mysql_real_escape_string($_POST['searchText']);
/*echo $searchText;*/
error_reporting(0);
if ($searchText == '')
	{
				$linkSQL = "SELECT A.cust_id as Cid, A.status as assignStatus, B.Company_Name as cname, B.Address as address, B.State as state, B.District_id as district, B.City as city, B.Area as area, A.calling_product as P_id, A.confirmation_date as Cdate 
							FROM tbl_customer_master as A 
							INNER JOIN tblcallingdata as B 
							ON A.callingdata_id = B.id where A.status =0";
				/* echo $linkSQL;*/
	}
		else if($searchText != '')
			{
				$linkSQL = "SELECT A.cust_id as Cid, A.status as assignStatus, B.Company_Name as cname, B.Address as address, B.State as state, B.District_id as district, B.City as city, B.Area as area, A.calling_product as P_id, A.confirmation_date as Cdate 
							FROM tbl_customer_master as A 
							INNER JOIN tblcallingdata as B 
							ON A.callingdata_id = B.id  WHERE A.status =0 and (A.cust_id like '$searchText%' or B.Company_Name like '$searchText%')";
				/*echo "cmd" . $linkSQL;*/
			}
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{	
	 	echo '<table class="table table-hover table-bordered ">';
?>	
			 <tr>
             <th><small>S. No.</small></th>  
          	 <th><small>Customer Id</small></th> 
          	 <th><small>Company Name</small></th>
             <th><small>Address</small></th>
             <th><small>State</small></th>
             <th><small>District</small></th>
             <th><small>City</small></th>
             <th><small>Area</small></th>  
          	 <th><small>Created Date</small></th>
             <th><small>Action</small></th>
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 	?>
        	<tr <?php print $class?>>
      		<td><small><?php print $kolor++;?>.</small></td>
	  		<td><small><?php echo stripslashes($row["Cid"]);?></small></td>
	  		<td><small><?php echo stripslashes($row["cname"]);?></small></td>
	  		<td><small><?php echo stripslashes($row["address"]);?></small></td>
            <td><small><?php echo getstate(stripslashes($row["state"]));?></small></td>
            <td><small><?php echo getdistrict(stripslashes($row["district"]));?></small></td>
            <td><small><?php echo getcity(stripslashes($row["city"]));?></small></td>
            <td><small><?php echo getarea(stripslashes($row["area"]));?></small></td>
	  		<td><small><?php echo stripslashes($row["Cdate"]);?></small></td>
            <td><a href="assign_service.php?cust_id=<?php echo $row["Cid"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a></td>
      		</tr>
	<?php 
	      }
	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br><br></td><tr/></table>";
	?> 
          			
                