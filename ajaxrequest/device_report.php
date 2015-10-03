<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$search_box = $_REQUEST['search_box'];
/*echo $search_box; */
error_reporting(0);
$linkSQL = "SELECT  A.id as DeviceId,A.imei_no as IMEI, A.company_id as CompId, B.branch_id as Branch_name, A.status as status, A.assignstatus as branch_asgn_status, B.branch_id as Branch_name , D.CompanyName as branch, B.technician_assign_status as technician_asgn_status, C.technician_id as TechnicianId, E.First_Name as fname, E.Last_Name as lname

	                    FROM tbl_device_master as A 
						LEFT OUTER JOIN tbl_device_assign_branch as B
						ON A.id = B.device_id
						LEFT OUTER JOIN tbl_device_assign_technician as C
						ON B.device_id = C.device_id
						LEFT OUTER JOIN tblbranch as D 
						ON B.branch_id = D.id
						LEFT OUTER JOIN tbluser as E 
						ON C.technician_id = E.id WHERE A.imei_no LIKE '$search_box%' or A.id LIKE '$search_box%'";
/*echo $linkSQL ;*/
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
	  			<th>S. No.</th>     
	  			<th>Device Id.</th>  
              	<th>IMEI No.</th> 
              	<th>Company</th>  
              	<th>Status <br />(Instock/Installed)</th>
              	<th>Allocated/ Unallocated</th>   
              	<th>Branch Name</th>    
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
                <td align="left" class="txt" valign="middle" ><?php print $kolor++;?>.</td>
                <td align="left" valign="middle" class="txt" ><?php echo stripslashes($row["DeviceId"]);?></td>
                <td align="left" valign="middle" class="txt" ><?php echo stripslashes($row["IMEI"]);?></td>
                <td align="left" valign="middle" class="txt" ><?php echo getdcompany(stripslashes($row["CompId"]));?></td>
                <td align="left" valign="middle" class="txt" >
                <?php 
                if($row["status"] == 0)
                    {  
                    echo "<span style='color:red; font-weight:bold;'>Instock</span>";
                    }
                    else
                    {
                    echo "<span style='color:green; font-weight:bold;'>Installed</span>";
                    }
                    ?></td>
                <td align="left" valign="middle" class="txt" >
                <?php 
                if($row["branch_asgn_status"] == 0)
                    {
                    echo "<span class='no'>Unallocated</span>";
                    }
                else
                    {
                    echo "<span class='yes'>Allocated</span>";
                    }
                ?></td>
                <td align="left" valign="middle" class="txt" >
                <?php
                if($row['Branch_name']>0)
                    {
                         echo stripslashes($row["branch"]);
                    }
                    else
                    {
                        echo "<span class='no'>N/A</span>";
                    }
                ?></td>
                <td align="left" valign="middle" class="txt" >
                <?php  
                if($row["technician_asgn_status"] ==0)
                    {
                    echo "<span class='no'>N/A</span>";
                    }
                else
                    {
                    echo "<span class='yes'>Assigned</span>";
                    }
                ?></td>
                <td align="left" valign="middle" class="txt" >
                <?php 
                if($row["TechnicianId"] == "")
                    {
                    echo "<span class='no'>N/A</span>";
                    }
                else
                    {
                    echo stripslashes($row["fname"]." ".$row["lname"] );
                    }
                ?></td>
                <td align="left" valign="middle" class="txt" >
                <?php 
                if($row["status"] == 0)
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
                    echo "<tr><td colspan=6 align=center><h3><font color=red>No records found !</h3></font></td><tr/></table>";
					}
                ?>
              