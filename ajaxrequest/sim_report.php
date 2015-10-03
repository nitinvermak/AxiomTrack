<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$search_box = $_REQUEST['search_box'];
/*echo "Sim Report"; */
error_reporting(0);
$linkSQL = "SELECT * FROM tblsim as A 
			LEFT OUTER JOIN tbl_sim_branch_assign as B
			ON A.id = B.sim_id
			LEFT OUTER JOIN tbl_sim_technician_assign as C
			ON B.sim_id = C.sim_id
			LEFT OUTER JOIN tblbranch as D 
			ON B.branch_id = D.id
			LEFT OUTER JOIN tbluser as E 
			ON C.technician_id = E.id WHERE A.sim_no LIKE '%$search_box%' OR A.mobile_no LIKE '%$search_box%'";
/*echo $linkSQL;*/
$stockArr = mysql_query($linkSQL);
/*$total_num_rows = mysql_num_rows($stockArr);*/
if(mysql_num_rows($stockArr)>0)
	{
		/*echo "Total Found Record" .$total_num_rows. "!";*/
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
              	<th>S. No.</th>     
              	<th>Sim  No.</th>  
              	<th>Mobile No.</th>
              	<th>Company</th> 
              	<th>Status <br />(Instock/Installed)</th>
              	<th>Allocated/ Unallocated</th>   
              	<th>Branch Id</th>   
              	<th>Branch Status</th>
              	<th>Technician Id</th>
              	<th>Technician Status</th>                          
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
	 			<td><?php echo stripslashes($row["sim_no"]);?></td>
	 			<td><?php echo stripslashes($row["mobile_no"]);?></td>
	 			<td><?php echo getserviceprovider(stripslashes($row["company_id"]));?></td>
	 			<td><?php 
					if($row["status_id"] == 0)
						{  
							echo "<span style='color:red; font-weight:bold;'>Instock</span>";
						}
					else
						{
							echo "<span style='color:green; font-weight:bold;'>Installed</span>";
						}
					?></td>
                <td><?php 
                    if($row["branch_assign_status"] == 0)
                        {
                        	echo "<span class='no'>Unallocated</span>";
                        }
                    else
                        {
                        	echo "<span class='yes'>Allocated</span>";
                        }
                    ?></td>
                <td><?php echo stripslashes($row["CompanyName"]);?></td>
                <td>
				<?php  
                if($row["technician_assign_status"] == 0)
                    {
                    echo "<span class='no'>InStock</span>";
                    }
                else
                    {
                    echo "<span class='yes'>Assigned</span>";
                    }
                ?></td>
                <td>
                <?php 
                if($row["technician_id"] == "")
                    {
                    echo "<span class='no'>N/A</span>";
                    }
                else
                    {
                    echo stripslashes($row["First_Name"]." ".$row["Last_Name"] );
                    }
                ?></td>
                <td>
                <?php 
                if($row["status_id"] == 0)
                    {  
                    echo "<span style='color:red; font-weight:bold;'>Instock</span>";
                    }
                else
                    {
                    echo "<span style='color:green; font-weight:bold;'>Installed</span>";
                    }
                ?></td>
                </tr> 	
				<?php 
                }
                echo $pagerstring;
                
                        }
                    else
                    echo "<tr><td colspan=10 align=center><h3 style='color:red;'><font color=red>No records found !</h3><br></font></td><tr/></table>";
				}
                ?>
              