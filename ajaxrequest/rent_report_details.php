<?php
include("../includes/config.inc.php"); 
/*include("includes/crosssite.inc.php"); */
$company = mysql_real_escape_string($_POST['company']);
$customerType = mysql_real_escape_string($_POST['customerType']);
$frq = mysql_real_escape_string($_POST['frq']);
error_reporting(0);
$linkSQL = "SELECT A.cust_id as custId, A.callingdata_id as callingId, 
			A.r_installation_charge as instChrg, A.np_device_rent as rentAmt, 
			B.customer_type as customerType, C.vehicle_no as vehicleNo, 
			C.installation_date as activationDate, A.rent_payment_mode as frq, 
			C.activeStatus as activeStatus, C.mobile_no as mobileId, C.id as vId,
            D.next_due_date as dueDate, D.RentalFrequencyId as rentRrq
			FROM tbl_customer_master as A 
			inner join tbl_customer_type as B 
			On A.customer_type = B.customer_type_id
			inner join tbl_gps_vehicle_master as C 
			ON A.cust_id = C.customer_Id
            Inner JOIN tbl_gps_vehicle_payment_master as D 
            ON C.id = D.Vehicle_id
            WHERE D.PlanactiveFlag = 'Y'";
		//echo $linkSQ;
if ( ($company != 0) or ($customerType != 0) or ($frq != 0) ){
	$linkSQL  = $linkSQL." And ";	
}

$counter = 0;

if ( $company != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  = $linkSQL." A.cust_id = '$company' ";
	$counter+=1;
	echo $linkSQ;
}	
if ( $customerType != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  = $linkSQL." B.customer_type  = '$customerType' ";
	$counter+=1;
	echo $linkSQ;
}
if ( $frq != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  = $linkSQL." D.RentalFrequencyId  = '$frq' ";
	$counter+=1;
	echo $linkSQ;
}		
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
	  			<th><small>Cust Id.</small></th> 
	  			<th><small>Vehicle Id</small></th>
                <th><small>Customer Type.</small></th>   
              	<th><small>Company</small></th> 
                <th><small>Frq.</small></th>
                <th><small>Vehicle No.</small></th> 
                <th><small>Mobile No.</th>
                <th><small>Activation Date</small></th> 
                <th><small>Due Date</small></th>
              	<th><small>Status</small></th>
              	<th><small>Installation Chrg.</small></th> 
                <th><small>Rent Amt.</small></th>                      
              	</tr>   
              	<?php
				$kolor=1;			
				if(mysql_num_rows($stockArr)>0){
					while ($row = mysql_fetch_array($stockArr)){
				?>
                <tr>
                <td><small><?php print $kolor++;?>.</small></td>
                <td><small><?php echo $row["custId"];?></small></td>
                <td><small><?php echo $row["vId"]; ?></small></td>
                <td><small><?php echo getCustType($row["customerType"]); ?></small></td>
                <td><small><?php echo getOraganization($row["callingId"]); ?></small></td>
                <td><small><?php echo getFrequency($row["rentRrq"]); ?></small></td>
                <td><small><?php echo $row["vehicleNo"]; ?></small></td>
                <td><small><?php echo getMobile($row["mobileId"]); ?></small></td>
                <td><small><?php echo $row["activationDate"]; ?></small></td>
                <td><small><?php echo $row["dueDate"]; ?></small></td>
                <td><small><?php echo getVehicleStatus($row["activeStatus"]);?></small></td>
                <td><small><?php echo getPlanAmt($row["instChrg"]); ?></small></td>
                <td><small><?php echo getPlanAmt($row["rentAmt"]); ?></small></td>
                </tr> 
<?php 
                }
               
                }    
		}
		else
			{
				echo "<tr><td colspan=6 align=center><h3><font color=red>No records found !</h3></font></td><tr/></table>";
			}
?>
