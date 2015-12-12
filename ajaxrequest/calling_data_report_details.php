<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$search_box = mysql_real_escape_string($_POST['search_box']);
/*echo $search_box; */
error_reporting(0);
	$linkSQL = "SELECT A.Company_Name as CompanyName, A.Address as address, 
				A.Area as area, A.State as state, A.City as city, 
				A.District_id as District, A.Pin_code as pincode, 
				A.Mobile as mobile, A.Phone as landline, B.status_id as statusId, 
				A.status as status, B.branch_id as branchId, B.telecaller_id as telecallerId, 
				A.calling_status as callingStatus 
				FROM tblcallingdata as A 
				INNER JOIN tblassign as B 
				ON A.id = B.callingdata_id 
				WHERE A.Company_Name LIKE '%$search_box%' or A.id LIKE '%$search_box%'";
	/*echo $linkSQL;*/
				
/*	$authorized_branches = BranchLogin($_SESSION['user_id']);
	if ( $authorized_branches != '0'){
		$linkSQL = $linkSQL.' and B.branch_id in  '.$authorized_branches;		
	}*/
	/*echo $linkSQL;*/
	$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<div class="col-md-12">
			  	<div class="download pull-right">
					<a href="#" id ="export" role="button" class="red"><span class="glyphicon glyphicon-save"></span></a>
				</div>
			  </div>
				<table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Company Name</small></th> 
                <th><small>Address</small></th>  
              	<th><small>Contact</small></th> 
              	<th><small>Status<br>(Confirm/ Not Confirmed)</small></th>  
              	<th><small>Allocated/ Unallocated</small></th>   
              	<th><small>Branch</small></th>    
              	<th><small>Branch Status</small></th> 
              	<th><small>Technician</small></th> 
              	<th><small>Telecalling Status</small></th>                         
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
                <td align="left" valign="middle" class="txt" ><small><?php echo stripslashes($row["CompanyName"]);?></small></td>
                <td align="left" valign="middle"><small><?php echo $row["address"];?></small></td>
                <td align="left" valign="middle" class="txt" ><small><?php echo $row["mobile"];?>
                </small></td>
                <td><small><?php echo getConfirm($row["statusId"]); ?></small></td>
                <td><small><?php echo getAllocated($row["status"]); ?></small></td>
                <td><small><?php echo getBranch($row["branchId"]); ?></small></td>
                <td><small><?php echo getBranchAssignStatus($row['status']); ?> </small></td>
                <td><small><?php echo gettelecallername($row['telecallerId']); ?></small></td>
                <td><small><?php echo getCallingStatus($row["callingStatus"]); ?></small></td>
                </tr> 
                <?php 
                }
                echo $pagerstring;
                
                        }
                    else
                    echo "<h3><font color=red>No records found !</h3></font>";
					}
                ?>
              