<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$searchText = $_REQUEST['searchText']; 
/*echo $searchText;*/
error_reporting(0);
if ($searchText == '')
	{
	$linkSQL = "SELECT A.cust_id as Cid, A.status as assignStatus, B.Company_Name as cname, A.calling_product as P_id, A.confirmation_date as Cdate FROM tbl_customer_master as A INNER JOIN tblcallingdata as B ON A.callingdata_id = B.id where A.status =0";
	}
		else if($searchText !== '')
			{
				$linkSQL = "SELECT A.cust_id as Cid, A.status as assignStatus, B.Company_Name as cname, A.calling_product as P_id, A.confirmation_date as Cdate FROM tbl_customer_master as A INNER JOIN tblcallingdata as B ON A.callingdata_id = B.id  WHERE A.status =0 and (A.cust_id like '$searchText%' or B.Company_Name like '$searchText%')";
				/*echo "cmd" . $linkSQL;*/
			}
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{	
	 	echo '<table class="table table-hover table-bordered ">';
?>	
			 <tr>
             <th class="col-xs-1"><small>S. No.</small></th>  
          	 <th class="col-xs-1"><small>Customer Id</small></th> 
          	 <th class="col-xs-2"><small>Company Name</small></th>
             <th class="col-xs-2"><small>Product</small></th>  
          	 <th class="col-xs-2"><small>Created Date</small></th>
             <th class="col-xs-2"><small>Action</small></th>
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 	?>
        	<tr <?php print $class?>>
      		<td><small><?php print $kolor++;?>.</small></td>
	  		<td><small><?php echo stripslashes($row["Cid"]);?></small></td>
	  		<td><small><?php echo stripslashes($row["cname"]);?></small></td>
	  		<td><small><?php echo getproducts(stripslashes($row["P_id"]));?></small></td>
	  		<td><small><?php echo stripslashes($row["Cdate"]);?></small></td>
            <td><a href="assign_service.php?cust_id=<?php echo $row["Cid"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a></td>
      		</tr>
	<?php 
	      }
	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br><br></td><tr/></table>";
	?> 
          			
                