<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$date = mysql_real_escape_string($_POST['date']);
$dateto = mysql_real_escape_string($_POST['dateto']);
$executive = mysql_real_escape_string($_POST['executive']);
$branch = mysql_real_escape_string($_POST['branch']);
$status = mysql_real_escape_string($_POST['status']);
error_reporting(0);
$linkSQL = "select A.Company_Name as company, A.Address as address, 
			A.Area as area, A.City as city, A.State as state, B.cust_id as customerId, 
			B.confirmation_date as activationDate, B.customer_type as customerType,
			B.telecaller_id as refferBy, C.service_branchId as serviceBranch,
			C.service_area_manager as areaManager, C.service_executive as serviceExecutive
			from tblcallingdata as A
			inner join tbl_customer_master as B
			On A.id = B.callingdata_id
			left outer join tbl_assign_customer_branch as C 
			on B.cust_id = C.cust_id";
/*echo $linkSQL;*/
if ( ($executive != 0) or ( $dateto !='' and $date !='') or ($branch != 0) or ($status !='') ){
	$linkSQL  = $linkSQL." WHERE ";	
}

$counter = 0;

if ( $executive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.telecaller_id = '$executive' order by B.cust_id";
	$counter+=1;
	/*echo $linkSQL;*/
}

if ( $dateto !='' and $date !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL."  DATE(B.confirmation_date) BETWEEN '$date' AND '$dateto' order by B.cust_id";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $branch != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." C.service_branchId ='$branch' order by B.cust_id" ;
	$counter+=1;
	/*echo $linkSQL;*/
}	
if ( $status != '') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.customer_type ='$status' order by B.cust_id";
	$counter+=1;
	/*echo $linkSQL;*/
}	 			
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Cust Id.</small></th> 
                <th><small>Customer Type.</small></th>   
              	<th><small>Customer Name</small></th> 
                <th><small>Address</small></th> 
                <th><small>Area</small></th> 
              	<th><small>City</small></th> 
                <th><small>State</small></th>
                <th><small>Activation Date</small></th>
                <th><small>Reffer By</small></th>
                <th><small>Service Branch</small></th> 
                <th><small>Area Manager</small></th> 
                <th><small>Service Executive</small></th>                        
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
                <td><small><?php echo $row["customerId"];?></small></td>
                <td><small>
				<?php if($row["customerType"] == 1)
					  {
						echo "Sale"; 
					  }
					  else if($row["customerType"] == 2)
					  {
					  	echo "Rent";
					  }
					  else if($row["customerType"] == 3)
					  {
					  	echo "Installment";
					  }
					  else
					  {
					  	echo "N/A";
					  }
				?>
                </small></td>
                <td><small><?php echo $row["company"]; ?></small></td>
                <td><small><?php echo $row["address"]; ?></small></td>
                <td><small><?php echo getarea($row["area"]); ?></small></td>
                <td><small><?php echo getcities($row["city"]); ?></small></td>
                <td><small><?php echo getstate($row["state"]); ?></small></td>
                <td><small><?php echo $row["activationDate"]; ?></small></td>
                <td><small><?php echo gettelecallername($row["refferBy"]); ?></small></td>
                <td><small>
				<?php 
				if($row["serviceBranch"] != NULL)
				{
					echo getBranch($row["serviceBranch"]);
				}
				else
				{
					echo "N/A";
				}	
				?>
                
                </small></td>
                <td><small>
                <?php 
				if($row["areaManager"] != NULL)
				{
					echo gettelecallername($row["areaManager"]);
				}
				else
				{
					echo "N/A";
				}	
				?>
                </small></td>    
                 <td><small>
                <?php 
				if($row["serviceExecutive"] != NULL)
				{
					echo gettelecallername($row["serviceExecutive"]);
				}
				else
				{
					echo "N/A";
				}	
				?>
                </small></td>      
                </tr> 
                <?php 
                }
                echo $pagerstring;
                }    
		}
		else
			{
				echo "<tr><td colspan=6 align=center><h3><font color=red>No records found !</h3></font></td><tr/></table>";
			}
?>
