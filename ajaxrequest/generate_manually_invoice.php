<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['customerId']);
/*echo $cust_id;*/
error_reporting(0);

$sql_query = "SELECT MAX( `intervalId` ) as max_intervalId
					FROM `tbl_invoice_master`
					WHERE `customerId` = '$cust_id'
					AND `invoiceFlag` = 'm'";
//echo $sql_query;					
$sql = mysql_query($sql_query);

				
while($row = mysql_fetch_array($sql)){
	$max_intervalId = $row['max_intervalId'];
}

$linkSQL =  "SELECT * FROM tblesitmateperiod WHERE intervalId > '$max_intervalId' limit 1";

if ($max_intervalId == NULL){
	
	$period_SQL =  "SELECT MAX( `intervalId` ) as max_intervalId FROM tblesitmateperiod WHERE GeneratedStatus = 'Y' ";
	$period_result = mysql_query($period_SQL);
	while($row = mysql_fetch_array($period_result)){
		//echo $row;
		$max_intervalId = $row['max_intervalId'];
		//echo $max_intervalId ;
    }	
	$max_intervalId = 45;
	//Hardcoding it for time being
	$linkSQL =  "SELECT * FROM tblesitmateperiod WHERE intervalId > '$max_intervalId' limit 10";	
	
	//echo 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk';	
}

///echo $max_intervalId;
//echo '<br>';	
//$linkSQL =  "SELECT * FROM tblesitmateperiod WHERE intervalId > '$max_intervalId' limit 1";
 
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0){
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   <!--  <h4 class="modal-title">Modal title</h4> -->
</div>
<div class="modal-body">
    Please generate the invoices one by one per month.Once this is done reload the page, next month invoice creation will be available.
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th><small>Intervel Id</small></th>
				<th><small>Intervel Month</small></th>
				<th><small>Month Name</small></th>
				<th><small>Intervel Year</small></th>
				<th><small>Action</small></th>
			</tr>
		</thead>
		<tbody>
		<?php while($row = mysql_fetch_array($stockArr)){ ?>
			<tr>
				<td><small><?php echo $row['intervalId']; ?> 
					<input type="hidden" name="interval_Id" id="interval_Id_<?php echo $row['intervalId']; ?>" 
					value="<?php echo $row['intervalId']; ?>"></small>
				</td>
				<td><small><?php echo $row['intervalMonth']; ?>
					<input type="hidden" name="customer_id_" id="customer_id_<?php echo $row['intervalId']; ?>" 
					value="<?php echo $cust_id; ?>">
					<input type="hidden" name="intervalMonth" id="intervalMonth_<?php echo $row['intervalId']; ?>" 
					value="<?php echo $row['intervalMonth']; ?>">
				</small></td>
				
				<td><small><?php echo $row['Intervalname']; ?>
 
				</small></td>
				
				
				<td><small><?php echo $row['IntervelYear']; ?>
					<input type="hidden" name="Intervel_Year" id="Intervel_Year_<?php echo $row['intervalId']; ?>" 
					value="<?php echo $row['IntervelYear']; ?>">
				</small></td>
				<td><button type="button" name="create" id="create" 
					class="btn btn-success btn-sm"
					onclick="reGenerateEstimate(<?php echo $row['intervalId']; ?>);">
						Create
					</button>
				</td>
			</tr>
		<?php 
			}
		}
		?>
		</tbody>
	</table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
</div>
