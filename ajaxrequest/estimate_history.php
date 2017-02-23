<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['custId']);
/*echo $cust_id;*/
error_reporting(0);
	$linkSQL = "select * from tbl_customer_master as A
				inner join tbl_invoice_master as B
				on A.cust_id = B.customerId
				inner Join tblesitmateperiod as C
				on B.intervalId = C.intervalId
				where B.customerId ='$cust_id'
				order by invoiceId";
				// And B.paymentStatusFlag = 'A'
    //echo $linkSQL;				
$oRS = mysql_query($linkSQL);
?>
<table border="0" class="table table-hover table-bordered" id="example"> 
	<thead>
		<tr>
		    <th><small>S.No.</small></th>  
		    <th><small>Estimate Id</small></th>  
			<th><small>Estimate Type</small></th>
		    <th><small>Customer Name</small></th>  
		    <th><small>Generated Date</small></th>
		    <th><small>Due Date</small></th>
		    <th><small>Period</small></th>
		    <th><small>Generated Amount</small></th> 
		    <th><small>Discount Amount</small></th> 
		    <th><small>Payble Amount</small></th> 
		    <th><small>Status</small></th>
	    </tr>  
	</thead>  
 	<tbody>
 	<?php
	$kolor=1;
	if(mysql_num_rows($oRS)>0){
  		while ($row = mysql_fetch_array($oRS)){
 	?>
	    <tr>
	      	<td><small><?php print $kolor++;?>.</small></td>
		  	<td><small><?php echo stripslashes($row["invoiceId"]);?></small></td>
	      	<td><small>
			  <?php if ($row["invoiceType"] == "A"){ echo 'Rental';} elseif($row["invoiceType"] == "B") { echo 'Device';}  ?>
	        </small>
	        </td>
			<td><small><?php $orgName =  getOraganization(stripslashes($row["callingdata_id"])); echo $orgName;  ?></small></td>
	      	<td><small><?php echo date("d-m-Y", strtotime($row["generateDate"]));?> </small></td>
	        <td class="<?php if(strtotime($row["dueDate"]) < strtotime(date("Y-m-d"))) echo 'datecolor' ?>">
	        <small><?php echo date("d-m-Y", strtotime($row["dueDate"])); ?></small></td>
	        <td><small><strong>From:</strong> <?php echo date("d-m-Y", strtotime(payment_from($row["invoiceId"])));?> <strong>To:</strong> <?php echo date("d-m-Y", strtotime(payment_to($row["invoiceId"])));?></small></td>
	        <td><small><?php echo stripslashes($row["generatedAmount"]);?></small></td>
	        <td><small><?php if($row["discountedAmount"]==0)
						{
							echo "N/A";
						}
					  else
						{
							echo stripcslashes($row["discountedAmount"]);	
						}
				?>
				</small>
			</td>
			<td><small><?php echo $row["generatedAmount"] - $row["discountedAmount"]; ?></small></td>
			<td><small>
				<?php if($row["invoiceFlag"]=='N'){
					echo '<span class="label label-primary">Pending</span>';
				}
				else if($row["invoiceFlag"]=='Y'){
					echo '<span class="label label-success">Full Payment Receive</span>';	
				}
				else if($row["invoiceFlag"]=='P'){
					echo '<span class="label label-warning">Partial Payment Receive</span>';
				}
				else if($row["invoiceFlag"]=='D'){
					echo '<span class="label label-danger">Estimate Deleted</span>';
				}
				?>
				</small>
			</td>
		</tr>
<?php 
     	}
    }
else{
       echo "<tr><td colspan='8'><center><h3><font color=red>No records found !</h3></center></font></td></tr>";
}		
?>
	</tbody>
</table>
