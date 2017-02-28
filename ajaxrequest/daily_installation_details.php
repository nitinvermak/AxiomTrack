<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$depositDate = mysql_real_escape_string($_POST['depositDateFrom']);
$depositDateTo = mysql_real_escape_string($_POST['depositDateTo']);
$branch = mysql_real_escape_string($_POST['branch']);
$executive = mysql_real_escape_string($_POST['executive']);
$configStatus1 = mysql_real_escape_string($_POST['configStatus1']);
error_reporting(0);
$linkSQL = "SELECT A.techinician_name as technician, A.id as id, A.ticketId as ticketId, A.mobile_no as mobile, 
			A.device_id as deviceId, A.imei_no as IMEI, A.model_name as model, A.vehicle_no as vehicle_no, 
			A.installation_date as installdate, C.Company_Name as CompanyName, A.create_by as create_by,
			A.customer_Id as custId
			FROM tempvehicledata as A 
			INNER JOIN tbl_customer_master as B 
			ON A.customer_Id = B.cust_id
			INNER JOIN tblcallingdata as C 
			ON B.callingdata_id = C.id
			INNER JOIN tbluser as D 
			ON A.techinician_name = D.id";

if (($executive != 0) or ( $depositDate != 0) or ( $depositDateTo != 0) or ($branch != 0) or ( $configStatus1 != ''))
{
	$linkSQL  = $linkSQL." Where ";		
}
$counter = 0;
if ( $executive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." A.techinician_name = '$executive'";
	$counter+=1;
}
if ( $depositDate !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." DATE(A.installation_date) BETWEEN '$depositDate' AND '$depositDateTo' ";
	$counter+=1;
}
if ( $branch != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." D.branch_id ='$branch'" ;
	$counter+=1;
}	
if ( $configStatus1 != '') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." A.configStatus ='$configStatus1'";
	$counter+=1;
}					 
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
?>	
	<table border="0" class="table table-hover table-bordered" width="100%" cellspacing="0" id="example">	
	<thead>
		<tr>
            <th><small>S. No.</small></th>     
            <th><small>Ticket Id</small></th>
            <th><small>Customer Id</small></th>
            <th><small>Company</small></th> 
            <th><small>Vehicle No</small></th> 
            <th><small>Mobile No</small></th> 
            <th><small>Device Id</small></th>   
            <th><small>Model</small></th> 
            <th><small>Tehnician</small></th>
            <th><small>Installation Date</small></th> 
            <th><small>Punch By</small></th>
            <th><small>Action <br />             
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">
                Check All</a>
      			&nbsp;&nbsp;
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">
                Uncheck All</a></small>
            </th>                 
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
            <td><small><?php echo stripslashes($row["ticketId"]);?></small></td>
            <td><small><?= $row['custId']; ?></small></td>
	 		<td><small><?php echo stripcslashes($row['CompanyName']);?></small></td>
            <td><small><?php echo stripcslashes($row['vehicle_no']);?></small></td>
            <td><small><?php echo stripcslashes($row['mobile']);?></small>
               	<input type="hidden" name="mobileNo<?php echo $row["id"]; ?>" id="mobileNo<?php echo $row["id"]; ?>" value="<?php echo stripcslashes($row['mobile']);?>" />
            </td>
            <td><small><?php echo stripcslashes($row['deviceId']); ?></small></td>
            <td><small><?php echo getdevicename(stripcslashes($row['model'])); ?></small>
                <input type="hidden" name="deviceModel<?php echo $row["id"]; ?>" id="deviceModel<?php echo $row["id"]; ?>" value="<?php echo stripcslashes($row['model']);?>" />
            </td>
            <td><small><?php echo gettelecallername(stripcslashes($row['technician'])); ?></small></td>
            <td><small><?php echo stripcslashes($row['installdate']); ?></small></td>
            <td><small><?php echo gettelecallername($row['create_by']); ?></small></td>
            <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'>
             	&nbsp;
              	<button type="button" name="sendCmd" id="sendCmd" onclick="getValue(<?php echo $row["id"]; ?>)" class="btn btn-primary btn-sm">Re-Send</button>
            </td>
       	</tr> 
		<?php 
        }
      }  
      echo "</tbody>";
      echo "</table>";
}
?>
<table>
<tr>
<td colspan="3"><input type="submit" name="submitNew" value="Configure" class="btn btn-primary btn-sm" id="submitNew" /> </td>
<td></td>
</tr>
</table>
<br />
</form>  