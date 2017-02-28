<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$reciveDateForm = mysql_real_escape_string($_POST['reciveDateForm']);
$reciveDateto = mysql_real_escape_string($_POST['reciveDateto']);
$cashConfirmation = mysql_real_escape_string($_POST['cashConfirmation']);
/*echo $cashConfirmation.'<br>'.$reciveDateForm.'<br>'.$reciveDateto;*/
error_reporting(0);
$linkSQL = "SELECT A.PaymentID as paymentId, A.customerId as custId, 
			A.CashAmount as cashAmt, A.userId as create_by, 
			A.status as confirmationStatus, A.RecivedDate as recivedDate,
			B.callingdata_id as callingDataId, A.adjustmentAmt as adjustmentAmt,
			A.paymentConfirmBy as paymentConfirmBy, B.cust_id as custid
			FROM quickbookpaymentmethoddetailsmaster as A 
			INNER JOIN tbl_customer_master as B 
			ON A.customerId = B.cust_id WHERE A.CashAmount <> 0";
	/*echo $linkSQL;*/
if ( ($cashConfirmation != NULL) or ( $reciveDateForm !=NULL and $reciveDateto !=NULL) )
	{
		$linkSQL  = $linkSQL." AND ";	
	}
$counter = 0;
if($confirmationStatus != NULL)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.status = '$cashConfirmation'" ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
if ( $reciveDateForm !=NULL and $reciveDateto !=NULL) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL."  DATE(A.RecivedDate) BETWEEN '$reciveDateForm' AND '$reciveDateto' ";
	$counter+=1;
	/*echo $linkSQL;*/
}

$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<table border="0" id="example" class="table table-hover table-bordered">  ';
?>		
			<thead>
				<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Payment ID</small></th> 
	  			<th><small>Customer Id</small></th> 
              	<th><small>Organization Name</small></th>
              	<th><small>Cash Amt.</small></th>
                <th><small>Confirmation Status</small></th> 
                <th><small>Confirm By</small></th>
              	<th><small>Recive Date</small></th>
                <th><small>Adjustment Status</small></th>  
                <th><small>Punch By</small></th>                           
              	</tr>
            </thead>
            <tbody>
                <?php
				$kolor=1;
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
                <td><small><?php echo stripslashes($row["paymentId"]);?></small></td>
                <td><small><?= $row['custid']; ?></small></td>
                <td><small><?php echo getOraganization(stripslashes($row["callingDataId"]));?></small></td>
                <td><small><?php echo stripslashes($row["cashAmt"]); ?></small></td>
                <td><small><?php getConfirmation($row["confirmationStatus"]); ?></small></td>
                <td><small><?php echo gettelecallername(stripslashes($row["paymentConfirmBy"]));?></small></td>
                <td><small><?php echo stripcslashes($row["recivedDate"]);?></small></td>
                <td><small><?php echo getAdjustment($row['adjustmentAmt']); ?></small></td>
                <td><small><?php echo gettelecallername(stripslashes($row["create_by"]));?></small></td>
                </tr> 
                <?php 
                		}
                echo '</tbody></table>';
                
                  }
                   
			}
			else
                   echo "<h3><font color=red>No records found !</h3></font>";
                ?>
              