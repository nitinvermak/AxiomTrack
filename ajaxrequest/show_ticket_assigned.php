<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch = mysql_real_escape_string($_POST['branch']);
$date = mysql_real_escape_string($_POST['date']);

error_reporting(0);
$linkSQL = "SELECT A.ticket_id tId, A.organization_id orgId, A.product as prduct, 
			A.rqst_type as rqsttype, A.repairReason as reason, A.vehicleId as vehicleId, 
			A.createddate as createddate, A.CreateBy as CreateBy, A.appointment_date as appointment_date
			FROM tblticket as A
			INNER JOIN tbl_ticket_assign_branch as B 
			ON A.ticket_id = B.ticket_id 
			WHERE B.technician_assign_status = '0'
			AND  A.ticket_status <> '1'";
/*echo $linkSQL;*/
	/*$authorized_branches = BranchLogin($_SESSION['user_id']);
	if ( $authorized_branches != '0'){
		$linkSQL = $linkSQL.' Where B.branch_id in  '.$authorized_branches;		
	}*/
	// echo $linkSQL;
	if( ($branch != 0) or ($date != "") )
	{
		$linkSQL  = $linkSQL." AND ";
		// echo $linkSQL;
	}
	$counter = 0;
	if($branch != 0)
		{
			if ($counter > 0 )
			$linkSQL = $linkSQL.' AND ';
			$linkSQL  = $linkSQL." B.branch_id = '$branch'" ;
			$counter+=1;
			// echo $linkSQL;
		}
	if($date != "")
		{
			if ($counter > 0 )
			$linkSQL = $linkSQL.' AND ';
			$linkSQL  = $linkSQL." B.assign_date = '$date'" ;
			$counter+=1;
			// echo $linkSQL;
		}
	$stockArr=mysql_query($linkSQL);
	if(mysql_num_rows($stockArr)>0){
	 	echo '  <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">  ';
?>                 
				<thead>
    	        <tr>
                <th><small>S. No.</small></th>     
                <th><small>Ticket Id</small></th> 
                <th><small>Organization Name</small></th>
                <th><small>Product</small></th>
                <th><small>Request Type</small></th>
                <th><small>Reason</small></th>
                <th><small>Vehicle No.</small></th> 
                <th><small>Created Date</small></th>
				<th><small>Created By</small></th>
                <th><small>Appointment Date Time</small></th>           
                <th><small>Actions</small><br>
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All 
                </a>
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All 				</a>                              
                </th>   
                </tr>  
                </thead> 
                <tbody> 
				<?php
				  $kolor =1;
				  while ($row = mysql_fetch_array($stockArr))
					{
						if($kolor%2==0)
							$class="bgcolor='#ffffff'";
						else
							$class="bgcolor='#fff'";
  	
 				?>
          		<tr <?php print $class?>>
                <td><small><?php print $kolor++;?>.</small></td>
                <td><small><?php echo stripslashes($row["tId"]);?></small></td>
				<td><small><?php echo getOraganization(stripslashes($row["orgId"]));?></small></td>
				<td><small><?php echo getproducts(stripslashes($row["prduct"]));?></small></td>
                <td><small><?php echo getRequesttype(stripslashes($row["rqsttype"]));?></small></td>
                <td><small>
				<?php 
				if($row["reason"] == NULL)
				{
					echo "N/A";
				}
				else
				{
					echo stripslashes($row["reason"]);
				}
				?>
                </small></td>
                <td><small>
				<?php 
				if($row["vehicleId"] == NULL)
				{
					echo "N/A";
				}
				else
				{
					echo getVehicleNumber(stripslashes($row["vehicleId"]));
				}
				?>
                </small></td>
				<td><small><?php echo stripslashes($row["createddate"]);?></small></td>
				<td><small><?php echo gettelecallername(stripslashes($row["CreateBy"]));?></small></td>
                <td><small><?php echo stripslashes($row["appointment_date"]);?></small></td>
                <td><input type='checkbox' name='linkID[]' value='<?php echo $row["tId"]; ?>'> </td>
                </tr>
 
	<?php 
	      }
	}
?> 
	</tbody>
	</table>
          		<form method="post">
                <table>
                <tr>
                <td colspan="3"><input type="submit" name="remove" value="Remove" class="btn btn-primary btn-sm" onClick="return val();" id="submit" /> </td>
                <td></td>
                </tr>
                </table><br />
                </form>   
             