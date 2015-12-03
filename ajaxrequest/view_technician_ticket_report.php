<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$date = mysql_real_escape_string($_POST['date']);
$dateto = mysql_real_escape_string($_POST['dateto']);
$status = mysql_real_escape_string($_POST['status']);
error_reporting(0);
			$linkSQL = "SELECT A.ticket_id as T_Id, A.organization_id as O_Id, 
						A.createddate as Create_date, A.close_date as C_date, 
						A.product as P_id, A.rqst_type as R_type, A.ticket_status as T_status, 
						A.appointment_date as ap_date, C.technician_id as T_name, B.branch_id as B_name
						FROM tblticket as A 
						LEFT OUTER JOIN tbl_ticket_assign_branch as B 
						ON A.ticket_id = B.ticket_id
						LEFT OUTER JOIN tbl_ticket_assign_technician as C 
						ON B.ticket_id = C.ticket_id
						LEFT OUTER JOIN tbluser as D 
						ON C.technician_id = D.id WHERE A.ticket_status <> 1 
						AND C.technician_id =".$_SESSION['user_id'] ;
		/*echo $linkSQL;*/
		
if ( ( $dateto !='' and $date !='') or ($status !='') )
{
	$linkSQL  = $linkSQL." AND ";	
}
$counter = 0;
if ( $dateto !='' and $date !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL."  DATE(A.appointment_date) BETWEEN '$date' AND '$dateto' ";
	$counter+=1;
	/*echo $linkSQL;*/
}	
if ( $status != '') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." A.ticket_status ='$status'" ;
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
	  			<th><small>Ticket Id.</small></th>  
              	<th><small>Organization</small></th> 
                <th><small>Products</small></th> 
                <th><small>Request Type</small></th> 
              	<th><small>Status</small></th> 
                <th><small>Assigned Branch</small></th>
                <th><small>Assigned Executive</small></th>
                <th><small>Appointment Date</small></th> 
                <th><small>Action</small></th>                       
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
                <td><small><?php echo stripslashes($row["T_Id"]);?></small></td>
                <td><small><?php echo getOraganization(stripslashes($row["O_Id"]));?></small></td>
                <td><small><?php echo getproducts(stripslashes($row["P_id"]));?></small></td>
                <td><small><?php echo getRequesttype(stripslashes($row["R_type"]));?></small></td>
                <td><small>
                <?php 
                if($row["T_status"] == 0)
                    {
                    echo "<span style='color:red; font-weight:bold;'>Pending</span>";
                    }
                else if($row["T_status"] == 1)
                    {
                    echo "<span style='color:green; font-weight:bold;'>Closed</span>";
                    }
				else if($row["T_status"] == 2)
					{
					echo "<span style='color:orange; font-weight:bold;'>Reschedule</span>";
					}
                ?></td> 
               	<td><small>
				<?php if($row["B_name"] == "") { echo "<span style ='color:orange; font-weight:bold;'>Not Allocated</span>";}
					  else { echo getBranch(stripcslashes($row["B_name"]));}
				?>
                </small></td>
                <td><small>
				<?php 
				if($row["T_name"] == "") { echo "<span style ='color:orange; font-weight:bold;'>Not Allocated</span>";}
				else { echo gettelecallername(stripcslashes($row["T_name"]));}
				?>
                </small></td>
                <td><small><?php echo stripslashes($row["ap_date"]);?></small></td>
                <td><small> 
                <a href="ticket_status_update.php?ticket_id=<?php echo $row["T_Id"];?>&token=<?php echo $token ?>" >Update Status</small></a>
                </small></td>            
                </tr> 
                <?php 
                }
                echo $pagerstring;
                }    
		}
		else
			{
				echo "<h3><font color=red>No records found !</h3></font>";
			}
?>
