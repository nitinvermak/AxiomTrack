<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$searchText = mysql_real_escape_string($_POST['searchText']);
/*echo $searchText;*/
error_reporting(0);
if($searchText != "")
{
		$linkSQL = "select * from tblsim where (sim_no like '{$searchText}%' or mobile_no like '{$searchText}%') and status_id <> '1'";
		/*echo $linkSQL;*/
		$oRS = mysql_query($linkSQL);
		if(mysql_num_rows($oRS)>0)
			{
				echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
		<tr>
      	<th>S. No.</th>  
      	<th>Service Provider Name</th>  
      	<th>Sim  No.</th>
      	<th>Mobile No.</th> 
        <th>Status</th>
      	<th>Action              
      	<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
      	&nbsp;&nbsp;
      	<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>        </th>   
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
	 	if(mysql_num_rows($oRS)>0)
	  		{
  				while ($row = mysql_fetch_array($oRS))
  			{
  				if($kolor%2==0)
					$class="bgcolor='#ffffff'";
				else
					$class="bgcolor='#fff'";
 	  	?>
        <tr <?php print $class?>>
      	<td><?php print $kolor++;?>.</td>
	  	<td><?php echo getserviceprovider(stripslashes($row["company_id"]));?></td>
      	<td><?php echo stripslashes($row["sim_no"]);?></td>
      	<td><?php echo stripslashes($row["mobile_no"]);?></td>
         <td><?php
		 	if($row["status_id"] == "0")
				{
					echo "<p style='color:green; font-weight:bold;'>InStock</p>";
				}
			else if($row["status_id"] == "2")
				{
					echo "<p style='color:red; font-weight:bold;'>Replacement</p>";
				}
		    else if($row["status_id"] == "3")
				{
					echo "<p style='color:red; font-weight:bold;'>Damage</p>";
				}
			?>
        	
        </td>
	  	<td> <?php if($row["id"]!=1){?><a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_sim.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " ><img src="images/drop.png" title="Delete" border="0" /></a> <?php } ?>    <?php if($row["id"]!=1){?> <a href="edit_sim.php?id=<?php echo $row["id"] ?>&amp;token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><?php } else {?>  <?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?>
        <a href="change_sim_status.php?id=<?php echo $row["id"] ?>&amp;token=<?php echo $token ?>">Status</a>
        <input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?></td>
      	</tr>
        <?php 
           	}
             	echo $pagerstring;
          }
        }
	 else
       echo "<tr><td colspan=6 align=center><h3><font color=red>No records found !</h3></font></td><tr/></table>";
	}
else
{
	echo "<script> alert('Please Provide Search Criteria'); </script>";
}
 ?>
