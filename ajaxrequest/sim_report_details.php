<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$search_box = mysql_real_escape_string($_POST['search_box']);
/*echo "Sim Report"; */
$branchname = $_SESSION['branch'];
error_reporting(0);
if($branchname == 14)
{
	$linkSQL = "SELECT * FROM tblsim as A 
				LEFT OUTER JOIN tbl_sim_branch_assign as B
				ON A.id = B.sim_id
				LEFT OUTER JOIN tbl_sim_technician_assign as C
				ON B.sim_id = C.sim_id
				LEFT OUTER JOIN tblbranch as D 
				ON B.branch_id = D.id
				LEFT OUTER JOIN tbluser as E 
				ON C.technician_id = E.id WHERE A.sim_no LIKE '%$search_box%' OR A.mobile_no LIKE '%$search_box%'";
}
else
{
	$linkSQL = "SELECT * FROM tblsim as A 
				LEFT OUTER JOIN tbl_sim_branch_assign as B
				ON A.id = B.sim_id
				LEFT OUTER JOIN tbl_sim_technician_assign as C
				ON B.sim_id = C.sim_id
				LEFT OUTER JOIN tblbranch as D 
				ON B.branch_id = D.id
				LEFT OUTER JOIN tbluser as E 
				ON C.technician_id = E.id WHERE (A.sim_no LIKE '%$search_box%' OR A.mobile_no LIKE '%$search_box%') And B.branch_id = '$branchname'";
}
/*echo $linkSQL;*/
$stockArr = mysql_query($linkSQL);
/*$total_num_rows = mysql_num_rows($stockArr);*/
if(mysql_num_rows($stockArr)>0)
	{
		/*echo "Total Found Record" .$total_num_rows. "!";*/
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
              	<th><small>S. No.</small></th>     
              	<th><small>Sim  No.</small></th>  
              	<th><small>Mobile No.</small></th>
              	<th><small>Company</small></th> 
              	<th><small>Status (Instock/Installed)</small></th>
              	<th><small>Allocated/ Unallocated</small></th>   
              	<th><small>Branch Id</small></th>   
              	<th><small>Branch Status</small></th>
              	<th><small>Technician Id</small></th>
              	<th><small>Technician Status</small></th>                          
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
	 			<td><small><?php echo stripslashes($row["sim_no"]);?></small></td>
	 			<td><small><?php echo stripslashes($row["mobile_no"]);?></small></td>
	 			<td><small><?php echo getserviceprovider(stripslashes($row["company_id"]));?></small></td>
	 			<td>
				<small>
					<?php 
					if($row["status_id"] == 0)
						{  
							echo "<span style='color:red; font-weight:bold;'>Instock</span>";
						}
					else
						{
							echo "<span style='color:green; font-weight:bold;'>Installed</span>";
						}
					?>
                </small>
                </td>
                <td>
                <small>
					<?php 
                    if($row["branch_assign_status"] == 0)
                        {
                        	echo "<span class='no'>Unallocated</span>";
                        }
                    else
                        {
                        	echo "<span class='yes'>Allocated</span>";
                        }
                    ?>
                </small>
                </td>
                <td><small><?php echo stripslashes($row["CompanyName"]);?></small></td>
                <td>
                <small>
				<?php  
                if($row["technician_assign_status"] == 0)
                    {
                    echo "<span class='no'>InStock</span>";
                    }
                else
                    {
                    echo "<span class='yes'>Assigned</span>";
                    }
                ?>
                </small>
                </td>
                <td>
                <small>
                <?php 
                if($row["technician_id"] == "")
                    {
                    echo "<span class='no'>N/A</span>";
                    }
                else
                    {
                    echo stripslashes($row["First_Name"]." ".$row["Last_Name"] );
                    }
                ?>
                </small>
                </td>
                <td>
                <small>
                <?php 
                if($row["status_id"] == 0)
                    {  
                    echo "<span style='color:red; font-weight:bold;'>Instock</span>";
                    }
                else
                    {
                    echo "<span style='color:green; font-weight:bold;'>Installed</span>";
                    }
                ?>
                </small>
                </td>
                </tr> 	
				<?php 
                }
                echo $pagerstring;
                
                        }
                    else
                    echo "<h3 style='color:red;'><font color=red>No records found !</h3><br></font>";
				}
                ?>
              