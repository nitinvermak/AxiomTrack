<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$assignedStatus = mysql_real_escape_string($_POST['assignedStatus']);
$branch = mysql_real_escape_string($_POST['branch']);
$finalStatus = mysql_real_escape_string($_POST['finalStatus']);
$executive = mysql_real_escape_string($_POST['executive']);
echo $assignedStatus; 
$branchName = $_SESSION['branch'];
error_reporting(0);
	$linkSQL = "SELECT  A.id as DeviceId, A.device_name as modal, A.date_of_purchase as purchaseDate,
			 	A.imei_no as IMEI, A.company_id as CompId, B.branch_id as Branch_name, 
				A.status as status, A.assignstatus as branch_asgn_status, B.branch_id as Branch_name, 
				D.CompanyName as branch, B.technician_assign_status as technician_asgn_status, 
				C.technician_id as TechnicianId, E.First_Name as fname, E.Last_Name as lname, 
				G.callingdata_id as callingDataId, F.vehicle_no as vehicleNo
				FROM tbl_device_master as A 
				LEFT OUTER JOIN tbl_device_assign_branch as B
				ON A.id = B.device_id
				LEFT OUTER JOIN tbl_device_assign_technician as C
				ON B.device_id = C.device_id
				LEFT OUTER JOIN tblbranch as D 
				ON B.branch_id = D.id
				LEFT OUTER JOIN tbluser as E 
				ON C.technician_id = E.id 
				LEFT OUTER Join tbl_gps_vehicle_master as F 
				ON A.id = F.device_id
				LEFT OUTER JOIN tbl_customer_master as G 
				ON F.customer_Id = G.cust_id";
	/*$authorized_branches = BranchLogin($_SESSION['user_id']);
	if ( $authorized_branches != '0'){
		$linkSQL = $linkSQL.' and B.branch_id in  '.$authorized_branches;		
	}*/
	echo $linkSQL;
if ( ($assignedStatus != 0) or ($branch != 0) or ($finalStatus != 0) or ($executive != 0) )
	{
		$linkSQL  = $linkSQL." WHERE ";	
	}
$counter = 0;
if($assignedStatus != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.assignstatus = '$assignedStatus'" ;
		$counter+=1;
		echo $linkSQL;
	}
if($branch != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.branch_id = '$branch'" ;
		$counter+=1;
		echo $linkSQL;
	}
if($finalStatus != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.status = '$finalStatus'" ;
		$counter+=1;
		echo $linkSQL;
	}
if($executive != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." C.technician_id = '$executive'" ;
		$counter+=1;
		echo $linkSQL;
	}
	$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Device Id.</small></th> 
                <th><small>Modal</small></th>  
              	<th><small>IMEI No.</small></th> 
              	<th><small>Company</small></th>  
                <th><small>Date of Purchase</small></th>  
              	<th><small>Status (Instock/Installed)</small></th>
              	<th><small>Allocated/ Unallocated</small></th>   
              	<th><small>Branch Name</small></th>    
              	<th><small>Branch Status</small></th> 
              	<th><small>Technician</small></th> 
              	<th><small>Technician Status</small></th>
                <th><small>Installed Company</small></th> 
                <th><small>Vehicle No</small></th>                           
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
                <td align="left" class="txt" valign="middle" ><small><?php print $kolor++;?>.</small></td>
                <td align="left" valign="middle" class="txt" ><small><?php echo stripslashes($row["DeviceId"]);?></small></td>
                <td align="left" valign="middle"><small><?php echo getdevicename(stripcslashes($row["modal"]));?></small></td>
                <td align="left" valign="middle" class="txt" ><small><?php echo stripslashes($row["IMEI"]);?></small></td>
                <td align="left" valign="middle" class="txt" ><small><?php echo getdcompany(stripslashes($row["CompId"]));?></small></td>
                <td align="left" valign="middle"><small><?php echo stripcslashes($row["purchaseDate"]);?></small></td>
                <td align="left" valign="middle" class="txt" >
                <small>
                <?php 
                if($row["status"] == 0)
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
                <td align="left" valign="middle" class="txt" >
                <small>
                <?php 
                if($row["branch_asgn_status"] == 0)
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
                <td align="left" valign="middle" class="txt" >
                <small>
                <?php
                if($row['Branch_name']>0)
                    {
                         echo stripslashes($row["branch"]);
                    }
                    else
                    {
                        echo "<span class='no'>N/A</span>";
                    }
                ?>
                </small>
                </td>
                <td align="left" valign="middle" class="txt" >
                <small>
                <?php  
                if($row["technician_asgn_status"] ==0)
                    {
                    echo "<span class='no'>N/A</span>";
                    }
                else
                    {
                    echo "<span class='yes'>Assigned</span>";
                    }
                ?>
                </small>
                </td>
                <td align="left" valign="middle" class="txt" >
                <small>
                <?php 
                if($row["TechnicianId"] == "")
                    {
                    echo "<span class='no'>N/A</span>";
                    }
                else
                    {
                    echo stripslashes($row["fname"]." ".$row["lname"] );
                    }
                ?>
                </small>
                </td>
                <td align="left" valign="middle" class="txt" >
                <small>
                <?php 
                if($row["status"] == 0)
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
                <td><small>
                <?php 
				if($row['callingDataId']==0)
					{
						echo "N/A";
					}
				else
					{
						echo getOraganization($row['callingDataId']);
					}
				?>
                </small></td>
                <td>
                <small>
               	<?php
				if($row['vehicleNo']== NULL)
				{
					echo 'N/A';
				}
				else
				{
					echo $row['vehicleNo'];
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
                    echo "<h3><font color=red>No records found !</h3></font>";
					}
                ?>
              