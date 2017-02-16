<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$technician_id = mysql_real_escape_string($_POST['technician_id']);
$branch = mysql_real_escape_string($_POST['branch']);
error_reporting(0);
$linkSQL = "SELECT A.id as sim_id, A.company_id as provider, A.sim_no as simNo, A.mobile_no as mobile_no, 
			C.assigned_by as assignby, C.technician_id as technicianId, B.branch_id as branchId,
			C.assigned_date as assignDate
			FROM tblsim as A 
			INNER JOIN tbl_sim_branch_assign as B 
			ON A.id = B.sim_id 
			INNER JOIN tbl_sim_technician_assign as C 
			ON B.sim_id = C.sim_id
			INNER JOIN tblserviceprovider as D
			ON A.company_id = D.id
			where A.status_id='0'";
	
if ( ($technician_id != 0) or ( $branch != 0) )
{
	$linkSQL  = $linkSQL." And ";	
	
}
$counter = 0;
if ( $technician_id != 0 ) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." C.technician_id = '$technician_id' ";
	$counter+=1;

}
if ( $branch != 0 ) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." B.branch_id = '$branch' ";
	$counter+=1;

}
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">  ';
?>
				<thead>
                <tr>
	            <th><small>S. No.</small></th>                   
	            <th><small>Provider</small></th>  
	            <th><small>Sim No.</small></th>
                <th><small>Mobile No.</small></th>
	            <th><small>Branch</small></th>
                <th><small>Assign Technician</small></th>
				<th><small>Technician Assign By </small></th>
	            <th><small>Assigned Date</small></th>
	            <th><small>Actions 
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                      &nbsp;&nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>
                </th> 
                </tr>
                </thead>
				<?php
	  			$kolor =1;
	  			while ($row = mysql_fetch_array($stockArr))
  					{
				   if($row["technician_assign_status"]==1)
						{
							$stock ='Assigned';
						}  
				   if($kolor%2==0)
						$class="bgcolor='#ffffff'";
				   else
						$class="bgcolor='#fff'";  	
 				?>
   			    <tr <?php print $class?>>
                <td><small><?php print $kolor++;?>.</td>
				<td><small><?php echo getserviceprovider(stripslashes($row["provider"]));?></small></td>	
                <td><small><?php echo stripslashes($row["simNo"]);?></small></td>	
				<td><small><?php echo stripslashes($row["mobile_no"]);?></small></td>
				<td><small><?php echo getBranch(stripslashes($row["branchId"]));?></small></td> 
				<td><small><?php echo gettelecallername(stripslashes($row["technicianId"]));?></small></td>
                <td><small><?php echo gettelecallername(stripslashes($row["assignby"]));?></small></td>
                <td><small><?php echo stripslashes($row["assignDate"]);?></small></td>
            <!--    <td><small><?php echo stripslashes($stock);?></small></td>	-->		  
                <td><input type='checkbox' name='linkID[]' value='<?php echo $row["sim_id"]; ?>'></td>
                </tr>
				<?php
				}
			}
		else
			 echo "<h3 style='color:red'>No records found!</h3><br>";
				?> 
               <!--  <form method="post"> -->
                <table>
                <tr>
                <td colspan="3">
                <!-- <input type="submit" name="remove" value="Remove" id="remove" class="btn btn-primary btn-sm" onClick="return val();" /> -->
                <button type="submit" name="remove_technician" id="remove" class="btn btn-danger btn-sm" onClick="return val();" ><i class="fa fa-trash-o" aria-hidden="true"></i> Remove</button>
                </td>
                <td></td>
                </tr>
                </table><br />
               <!--  </form>  -->  
               