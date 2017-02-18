<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$custId = mysql_real_escape_string($_POST['custId']);
error_reporting(0);
	$linkSQL = "SELECT A.PaymentID as paymentId, A.RecivedDate as rcdDate,
				A.CashAmount as cashamt, B.chequeAmount as chequeAmt, 
				C.onlineAmount as onlineAmt
				FROM quickbookpaymentmethoddetailsmaster as A 
				LEFT OUTER JOIN quickbookpaymentcheque as B 
				ON A.ChequeID = B.Id
				LEFT OUTER JOIN quickbookpaymentonlinetransfer as C 
				ON A.OnlineTransferId = C.Id  
				WHERE A.customerId = '$custId'";
	// echo $linkSQL;
	
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
?>                
				<table border="0" width="100%" class="table table-hover table-bordered">
				<tr>
                  <th><small>S. No.</small></th>     
                  <th><small>PaymentId</small></th>
                  <th><small>Received Date</small></th>
                  <th><small>Payment Type</small></th> 
                  <th><small>Received Amt.</small></th>
              	</tr>   
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
			$cashAmt = $row["cashamt"];
			$chequeAmt = $row["chequeAmt"];
			$NeftAmt = $row["onlineAmt"];
			$amount = $cashAmt + $chequeAmt + $NeftAmt;
    ?>
       		   <tr>
                <td><small><?php print $kolor++;?>.</small></td>
                <td><small><?php echo $row["paymentId"]; ?></small></td>
                <td><small><?php echo date("d-m-Y", strtotime($row["rcdDate"])); ?></small></td>
                <td><small><?php if($cashAmt != 0) { echo 'Cash'; } else if($chequeAmt != 0) { echo 'Cheque'; } else if($NeftAmt != 0) { echo 'NEFT'; } ?></small></td>
                <td><button type="button" onclick="getPaymentAdjustmentDetails(<?php echo $row["paymentId"]; ?>);" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $amount; ?></button></td>
              </tr>
 
	<?php 
	      }
	echo "</table>";
	}
    else
   		 echo "<h3 class='red'>No records found!</h3>";
?> 

                         