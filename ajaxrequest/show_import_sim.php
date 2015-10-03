<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$search_box = $_REQUEST['search_box'];
echo "Ajax Request Call Success <br>"; 
error_reporting(0);
$linkSQL = "select * from tblsim where sim_no like '%$search_box%' or mobile_no like '%$search_box%'";
echo $linkSQL;
$stockArr = mysql_query($linkSQL);
/*$total_num_rows = mysql_num_rows($stockArr);*/
if(mysql_num_rows($stockArr)>0)
	{
		/*echo "Total Found Record" .$total_num_rows. "!";*/
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
      			<th>S. No.</th>  
      			<th>Service Provider Name</th>  
      			<th>Sim  No.</th>
      			<th>Mobile No.</th> 
      			<th>Action              
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>&nbsp;&nbsp;
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>           </th>   
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
      			<td><?php print $kolor++;?>.</td>
	  			<td><?php echo getserviceprovider(stripslashes($row["company_id"]));?></td>
      			<td><?php echo stripslashes($row["sim_no"]);?></td>
      			<td><?php echo stripslashes($row["mobile_no"]);?></td>
	  			<td> <?php if($row["id"]!=1){?><a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_sim.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " ><img src="images/drop.png" title="Delete" border="0" /></a> <?php } ?>    <?php if($row["id"]!=1){?> <a href="edit_sim.php?id=<?php echo $row["id"] ?>&amp;token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><?php } else {?>  <?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?></td>
      			</tr>	
				<?php 
                }
                echo $pagerstring;
                
                        }
                    else
                    echo "<tr><td colspan=10 align=center><h3 style='color:red;'><font color=red>No records found !</h3><br></font></td><tr/></table>";
				}
                ?>
              