<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$organization = $_REQUEST['organization']; 

error_reporting(0);
$linkSQL = "SELECT B.id, B.Company_Name, B.First_Name, B.Last_Name, B.Phone, B.Mobile, 
      			B.data_source, B.Address,A.telecaller_id, A.confirmation_date 
      			FROM tbl_customer_master as A 
      			INNER JOIN tblcallingdata as B 
      			ON A.callingdata_id = B.id 
      			WHERE A.callingdata_id='$organization'";
/*echo "cmd" . $linkSQL;*/
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{	
	 	echo '<table class="table table-hover table-bordered ">';
?>	
			 <tr>
             <th>S. No.</th>  
          	 <th>Name</th> 
          	 <th>Company Name</th>  
          	 <th>Phone</th>
          	 <th>Mobile</th>
          	 <th>Data Source</th>
          	 <th>Actions 
              <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
              &nbsp;&nbsp;
              <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a> 
          	</th>   
          	</tr>  
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 	?>
        	<tr <?php print $class?>>
      		<td><?php print $kolor++;?>.</td>
	  		<td><?php echo stripslashes($row["First_Name"]." ".$row["Last_Name"]);?></td>
	  		<td><?php echo stripslashes($row["Company_Name"]);?></td>
	  		<td><?php echo stripslashes($row["Phone"]);?></td>
	  		<td><?php echo stripslashes($row["Mobile"]);?></td>
      		<td><?php echo stripslashes($row["data_source"]);?></td>
	  		<td><?php if($row["id"]!=1){?>
          	<?php } ?>    
          	<?php if($row["id"]!=1){?>
          	<a href="branch_type.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>">
          	<a href="edit_customer_details.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>">
          	<img src='images/edit.png' title='Edit' border='0' /></a>
          	<?php } else {?> 
          	<a href="edit_contacts.php?cid=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> 
<?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?>
          	<?php } ?></td>
      		</tr>
	<?php 
	      }
	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br><br></td><tr/></table>";
	?> 
          			
                