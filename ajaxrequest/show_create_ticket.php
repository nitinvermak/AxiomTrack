<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$searchText = $_REQUEST['searchText'];
error_reporting(0);
if ($searchText == "")
	{
	$linkSQL = "SELECT A.ticket_id as TId, B.Company_Name as Cname, A.organization_type as O_type, A.product as product, A.rqst_type as rqst_type, A.createddate as Cdate, A.appointment_date as meeting_date  
				FROM tblticket as A
				INNER JOIN tblcallingdata as B 
				ON A.organization_id = B.id";
	}
else
	{
	$linkSQL = "SELECT A.ticket_id as TId, B.Company_Name as Cname, A.organization_type as O_type, A.product as product, A.rqst_type as rqst_type, A.createddate as Cdate, A.appointment_date as meeting_date  
				FROM tblticket as A
				INNER JOIN tblcallingdata as B 
				ON A.organization_id = B.id where A.ticket_id like '{$searchText}%' or B.Company_Name like '{$searchText}%' ";
 	}
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table class="table table-bordered table-hover">';
?>		               
    	<tr>
        <th><small>S. No.</small></th>   
        <th><small>Ticket Id</small></th>
        <th><small>Organization Name</small></th>  
        <th><small>Organization Type</small></th>
        <th><small>Product</small></th>
        <th><small>Request Type</small></th> 
        <th><small>Created</small></th>
        <th><small>Appointment Date Time</small></th>
        <th><small>Actions</small></th> 
        </tr>    
	  	<?php
		$kolor=1;
		if(isset($_GET['page']) and is_null($_GET['page']))
		{ 
		$kolor = 1;
		}
		elseif(isset($_GET['page']) and $_GET['page']==1)
		{ 
		$kolor = 1;
		}
		elseif(isset($_GET['page']) and $_GET['page']>1)
		{
		$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
		}
		
			if(mysql_num_rows($stockArr)>0)
			{
		  while ($row = mysql_fetch_array($stockArr))
		  {
		  
		  if($kolor%2==0)
			$class="bgcolor='#ffffff'";
			else
			$class="bgcolor='#fff'";
		?>
         <tr <?php print $class?>>
        <td><small><?php print $kolor++;?>.</small></td>
        <td><small><?php echo stripslashes($row["TId"]);?></small></td>
		<td><small><?php echo stripslashes($row["Cname"]);?></small></td>
        <td><small><?php echo stripslashes($row["O_type"]);?></small></td>
		<td><small><?php echo getproducts(stripslashes($row["product"]));?></small></td>
        <td><small><?php echo getRequesttype(stripslashes($row["rqst_type"]));?></small></td>
		<td><small><?php echo stripslashes(date('l jS \of F Y h:i:s A',strtotime($row["Cdate"])));?></small></td>
        <td><small><?php echo stripslashes(date('l jS \of F Y h:i:s A',strtotime($row["meeting_date"])));?></small></td>
        <td><a href="edit_ticket.php?id=<?php echo $row["TId"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> &nbsp;&nbsp; </td>
        </tr>
 
	<?php 
	      }

 

	}
    else
   		 echo "<tr><td colspan=9 align=center><h3 style='color:red'>No records found!</h3><br><br></td><tr/></table>";
}
?>          