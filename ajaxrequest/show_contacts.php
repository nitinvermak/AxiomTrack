<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$searchText = $_REQUEST['searchText']; 
/*echo $searchText;*/
error_reporting(0);
if ($searchText == '')
	{
	$linkSQL = "Please Provide Search Criteria";
	}
		else if($searchText !== '')
			{
				$linkSQL = "SELECT * from tblcallingdata WHERE First_Name LIKE '$searchText%' OR Last_Name LIKE '$searchText%' OR Company_Name LIKE '$searchText%' OR Mobile  LIKE '$searchText%'";
				/*echo "cmd" . $linkSQL;*/
			}
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
         	<a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='managecontacts.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " >
          	<img src="images/drop.png" title="Delete" border="0" /></a> 
          	<?php } ?>    
          	<?php if($row["id"]!=1){?>
          	<a href="branch_type.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>">
          	<a href="edit_contacts.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>">
          	<img src='images/edit.png' title='Edit' border='0' /></a>
          	<?php } else {?> 
          	<a href="edit_contacts.php?cid=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> 
<?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?>
          	<input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?></td>
      		</tr>
	<?php 
	      }
	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br><br></td><tr/></table>";
	?> 
          			
                