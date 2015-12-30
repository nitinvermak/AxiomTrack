<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$searchText = $_REQUEST['searchText']; 
/*echo $searchText;*/
error_reporting(0);
if($searchText !== '')
{
	$linkSQL = "SELECT A.cust_id as cId, A.calling_product as product, 
				B.Company_Name as companyName, B.Country as Country, 
				B.State as state, B.District_id as district, 
				B.City as city, B.Area as area, B.Address as address, 
				B.Pin_code as pincode, B.created as created, 
				B.Phone as phone, B.Mobile as mobile, B.email as email,
				B.id as Id,
				A.telecaller_id as technician, C.branch_id as branch
				FROM tbl_customer_master as A 
				INNER JOIN  tblcallingdata as B 
				ON A.callingdata_id = B.id
				INNER JOIN  tblassign as C 
				ON A.callingdata_id = C.callingdata_id 
				WHERE B.Company_Name = '$searchText' ";
				echo "cmd" . $linkSQL;
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
    <th><small>Contact</small></th>
    <th><small>Lead Gen.</small></th>
    <th><small>Branch</small></th>
    <th><small>Action</small></th>
	<?php
	$kolor =1;
	while ($row = mysql_fetch_array($stockArr))
  	{
 	?>
    <tr <?php print $class?>>
    <td><small><?php print $kolor++;?>.</small></td>
	<td><small><?php echo stripslashes($row["cId"]);?></small></td>
	<td><small><?php echo stripslashes($row["companyName"]);?></small></td>
	<td><small>
	<?php echo $row["address"].", ";
		  echo getarea($row["area"].", ");
		  echo getcities($row["city"]).", ";
		  echo getdistrict($row["district"]).", ";
		  echo getstate($row["state"]).", ";
		  echo getpincode($row["pincode"]);
	?>
    
    </small></td>
	<td><small><?php echo $row["phone"]."<br>".$row["mobile"];?></small></td>
    <td><small><?php echo gettelecallername(stripslashes($row["technician"]));?></small></td>
    <td><small><?php echo getBranch(stripslashes($row["branch"]));?></small></td>
    <td><small><a href="edit_customer_profile.php?id=<?php echo $row["Id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><a href="edit_contacts.php?id=<?php echo $row["Id"] ?>&token=<?php echo $token ?>"></a></small></td>
	</tr>
	<?php 
	  }
	}
    else
	{
   		 echo "<h3 style='color:red;'>No records found!</h3><br><br>";
	}
 }
else
{
	echo "<h4 style='color:red;'>Please Provide Search Criteria</h4>";
}
	?> 
          			
                