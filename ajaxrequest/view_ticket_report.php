<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$date = mysql_real_escape_string($_POST['date']);
$dateto = mysql_real_escape_string($_POST['dateto']);
$executive = mysql_real_escape_string($_POST['executive']);
$branch = mysql_real_escape_string($_POST['branch']);
$status = mysql_real_escape_string($_POST['status']);
error_reporting(0);
			$linkSQL = "SELECT A.ticket_id as T_Id, A.organization_id as O_Id, 
						A.createddate as Create_date, A.close_date as C_date, 
						A.product as P_id, A.rqst_type as R_type, A.ticket_status as T_status, 
						A.appointment_date as ap_date, C.technician_id as T_name, B.branch_id as B_name, A.vehicleId as vehicleId
						FROM tblticket as A 
						LEFT OUTER JOIN tbl_ticket_assign_branch as B 
						ON A.ticket_id = B.ticket_id
						LEFT OUTER JOIN tbl_ticket_assign_technician as C 
						ON B.ticket_id = C.ticket_id
						LEFT OUTER JOIN tbluser as D 
						ON C.technician_id = D.id";
if ( ($executive != 0) or ( $dateto !='' and $date !='') or ($branch != 0) or ($status !='') )
{
	$linkSQL  = $linkSQL." WHERE ";	
}
$counter = 0;
if ( $executive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." C.technician_id = '$executive'" ;
	$counter+=1;
	//echo $linkSQL;
}
if ( $dateto !='' and $date !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL."  DATE(A.appointment_date) BETWEEN '$date' AND '$dateto' ";
	$counter+=1;
	//echo $linkSQL;
}
if ( $branch != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.branch_id ='$branch'" ;
	$counter+=1;
	//echo $linkSQL;
}	
if ( $status != '') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." A.ticket_status ='$status'" ;
	$counter+=1;
	//echo $linkSQL;
}	 			
			
			 

$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
?>	
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%"> 	
		<thead>
			<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Ticket Id.</small></th>  
              	<th><small>Organization</small></th> 
                <th><small>Products</small></th> 
                <th><small>Request Type</small></th> 
                <th><small>Vehicle No.</small></th>
              	<th><small>Status</small></th> 
                <th><small>Assigned Branch</small></th>
                <th><small>Assigned Executive</small></th>
                <th><small>Appointment Date</small></th> 
                <th><small>Close Date</small></th>                       
            </tr>   
		</thead>
		<tbody>
		<?php
		$kolor=1;
		if(isset($_GET['page']) and is_null($_GET['page'])){ 
			$kolor = 1;
		}
		elseif(isset($_GET['page']) and $_GET['page']==1){ 
			$kolor = 1;
		}
		elseif(isset($_GET['page']) and $_GET['page']>1){
			$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
		}
		if(mysql_num_rows($stockArr)>0){
			while ($row = mysql_fetch_array($stockArr)){						
		?>
        <tr>
            <td><small><?php print $kolor++;?>.</small></td>
            <td><small><?php echo stripslashes($row["T_Id"]);?></small></td>
            <td><small><?php echo getOraganization(stripslashes($row["O_Id"]));?></small></td>
            <td><small><?php echo getproducts(stripslashes($row["P_id"]));?></small></td>
            <td><small><?php echo getRequesttype(stripslashes($row["R_type"]));?></small></td>
            <td><small><?php echo getVehicleNumber(stripslashes($row["vehicleId"]));?></small></td>
            <td><?php echo getTicketStatus($row["T_status"]); ?></td> 
            <td><small><?php if($row["B_name"] == "") { echo "<span style ='color:orange; font-weight:bold;'>Not Allocated</span>";}else { echo getBranch(stripcslashes($row["B_name"]));}?></small></td>
                <td><small><?php if($row["T_name"] == "") { echo "<span style ='color:orange; font-weight:bold;'>Not Allocated</span>";}else { echo gettelecallername(stripcslashes($row["T_name"]));}?></small>
            </td>
            <td><small><?php echo stripslashes($row["ap_date"]);?></small></td>
            <td><small><?php echo stripslashes($row["C_date"]);?></small></td>            
        </tr> 
        <?php 
        	}
       	}  
       	echo "</tbody>";  
       	echo "</table>";
		}
		?>
