<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$search_box = mysql_real_escape_string($_POST['search_box']);
/*echo "Sim Report"; */
$branchname = $_SESSION['branch'];
error_reporting(0);
	$linkSQL = "SELECT A.sim_no as simNo, A.company_id as provider, A.mobile_no as mobileNo, 
				A.status_id as statusId, A.branch_assign_status as branchAssignStatus,
				B.branch_id  as branchId, D.CompanyName as branchname, 
				B.technician_assign_status as technicianStatus, 
				C.technician_id as technicianId, G.callingdata_id as callingDataId, 
				E.First_Name as fName, E.Last_Name as lName
				FROM tblsim as A 
				LEFT OUTER JOIN tbl_sim_branch_assign as B
				ON A.id = B.sim_id
				LEFT OUTER JOIN tbl_sim_technician_assign as C
				ON B.sim_id = C.sim_id
				LEFT OUTER JOIN tblbranch as D 
				ON B.branch_id = D.id
				LEFT OUTER JOIN tbluser as E 
				ON C.technician_id = E.id 
				LEFT OUTER JOIN tbl_gps_vehicle_master as F 
				ON A.id = F.mobile_no
				LEFT OUTER JOIN tbl_customer_master as G 
				ON F.customer_Id = G.cust_id
				WHERE (A.sim_no LIKE '%$search_box%' OR A.mobile_no LIKE '%$search_box%')";
	$authorized_branches = BranchLogin($_SESSION['user_id']);
	if ( $authorized_branches != '0'){
		$linkSQL = $linkSQL.' and B.branch_id in  '.$authorized_branches;		
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
              	<th><small>Allocated/Unallocated</small></th>   
              	<th><small>Branch</small></th>   
              	<th><small>Branch Status</small></th>
              	<th><small>Technician</small></th>
              	<th><small>Installed Company</small></th>                          
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
	 			<td><small><?php echo stripslashes($row["simNo"]);?></small></td>
	 			<td><small><?php echo stripslashes($row["mobileNo"]);?></small></td>
	 			<td><small><?php echo getserviceprovider(stripslashes($row["provider"]));?></small></td>
	 			<td>
				<small>
					<?php 
					if($row["statusId"] == 0)
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
                    if($row["branchAssignStatus"] == 0)
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
                <td><small><?php echo stripslashes($row["branchname"]);?></small></td>
                <td>
                <small>
				<?php  
                if($row["technicianStatus"] == 0)
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
                if($row["technicianId"] == "")
                    {
                    echo "<span class='no'>N/A</span>";
                    }
                else
                    {
                    echo stripslashes($row["fName"]." ".$row["lName"] );
                    }
                ?>
                </small>
                </td>
                <td>
                <small>
                <?php 
                if($row["callingDataId"] == 0)
                    {  
                    echo "N/A";
                    }
                else
                    {
                    echo getOraganization($row['callingDataId']);
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
              