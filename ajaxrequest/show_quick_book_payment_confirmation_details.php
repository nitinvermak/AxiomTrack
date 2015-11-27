<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch_id=$_REQUEST['branch']; 
error_reporting(0);
if ($branch_id == 0)
{
	$linkSQL = "SELECT B.PaymentID as PaymentID, B.customerId as customerId, 
			    B.quickBookRefNo as quickBookRefNo, B.CashAmount as CashAmount,
			    B.status as status, A.chequeAmount as chequeamt, C.onlineAmount as onlineAmt,
			    A.Id as chequeId, C.Id as onlinepaymentId, D.callingdata_id as callingdataid
				from quickbookpaymentcheque as A 
				Left Outer JOIN quickbookpaymentmethoddetailsmaster as B 
				ON A.Id = B.ChequeID
				Left Outer JOIN quickbookpaymentonlinetransfer as C 
				ON B.OnlineTransferId = C.Id 
				LEFT OUTER JOIN tbl_customer_master as D 
				ON B.customerId = D.cust_id WHERE B.status = '0'";
				/*echo $linkSQL;*/
}
else
{
	$linkSQL = "SELECT B.PaymentID as PaymentID, B.customerId as customerId, 
			    B.quickBookRefNo as quickBookRefNo, B.CashAmount as CashAmount,
			    B.status as status, A.chequeAmount as chequeamt, C.onlineAmount as onlineAmt,
			    A.Id as chequeId, C.Id as onlinepaymentId, D.callingdata_id as callingdataid
				from quickbookpaymentcheque as A 
				Left Outer JOIN quickbookpaymentmethoddetailsmaster as B 
				ON A.Id = B.ChequeID
				Left Outer JOIN quickbookpaymentonlinetransfer as C 
				ON B.OnlineTransferId = C.Id 
				LEFT OUTER JOIN tbl_customer_master as D 
				ON B.customerId = D.cust_id WHERE B.status = '0'";
	/*echo $linkSQL;*/
}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				 <tr>
                 <th><small>S. No.</small></th>
	             <th><small>Payment Id</small></th>                        
	             <th><small>Customer Id</small></th>  
	             <th><small>Quick Book Ref. No.</small></th>
	             <th><small>Cash Amount</small></th> 
                 <th><small>Cheque Amount</small></th>  
                 <th><small>Online Amount</small></th> 
	             <th><small>Actions</small>
                 <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                       	&nbsp;&nbsp;
                 <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>         </th>   
                 </tr>   
	
				<?php
	  		  		$kolor = 1;
	  				while ($row = mysql_fetch_array($stockArr))
  						{
 						if($kolor%2==0)
							$class="bgcolor='#ffffff'";
						else
							$class="bgcolor='#fff'";
  	
 				?>
                <tr <?php print $class?>>
                <td><small><?php print $kolor++;?>.</small></td>
				<td><small><?php echo stripslashes($row["PaymentID"]);?></small></td>
                <td><small><?php echo getOraganization(stripslashes($row["callingdataid"]));?></small></td>	
				<td><small><?php echo stripslashes($row["quickBookRefNo"]);?></small></td>
                <td><small>
				<?php 
				if($row["CashAmount"] == 0)
				{
					echo 'N/A';
				}
				else
				{
					echo stripslashes($row["CashAmount"]);
				}
				?>
                </small></td>	
                <td><small>
				<?php 
				if($row["chequeamt"] == 0)
				{
					echo 'N/A';
				}
				else
				{
					echo stripslashes($row["chequeamt"]);
				}
				?>
                </small></td>
                <td><small>
				<?php
				if($row["onlineAmt"] == "")
				{
					echo 'N/A';
				}
				else
				{
					echo stripslashes($row["onlineAmt"]);
				}
				?>
                </small></td>
               				  
                <td>
                <a href="edit_quickbook_invoice.php?paymentid=<?php echo $row["PaymentID"];?>&chequeId=<?php echo $row["chequeId"];?>&onlinepaymentId=<?php echo $row["onlinepaymentId"];?>&token=<?php echo $token ?>">
                <img src='images/edit.png'></a>&nbsp;
                <input type='checkbox' name='linkID[]' value='<?php echo $row["PaymentID"]; ?>'>
                </td>
                </tr>
 				<?php }
				}
    			else
   		 			echo "<h3 style='color:red'>No records found!</h3><br>";
				?> 
                <form method="post">
                <table>
                <tr>
                <td></td>
                <td colspan="3"><input type="submit" name="submit" value="Confirm" onClick="return val();" class="btn btn-primary btn-sm" id="submit" /> </td>
                <td></td>
                </tr>
                </table>
                </form> 
               