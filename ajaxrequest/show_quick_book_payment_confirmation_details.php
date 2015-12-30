<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch_id=$_REQUEST['branch']; 
error_reporting(0);
if ($branch_id == 0)
{
	$linkSQL = "SELECT A.PaymentID as PaymentID, A.customerId as customerId, 
				A.quickBookRefNo as quickBookRefNo, A.CashAmount as CashAmount, 
				A.status as status, B.chequeAmount as chequeamt, B.ChequeNo as cheqNo, 
				B.Bank as bankName, C.onlineAmount as onlineAmt, B.Id as chequeId, 
				C.Id as onlinepaymentId, D.callingdata_id as callingdataid 
				FROM quickbookpaymentmethoddetailsmaster as A 
				LEFT OUTER JOIN quickbookpaymentcheque as B 
				ON A.ChequeID = B.Id 
				LEFT OUTER JOIN quickbookpaymentonlinetransfer as C 
				ON A.OnlineTransferId = C.Id 
				LEFT OUTER JOIN tbl_customer_master as D 
				ON A.customerId = D.cust_id 
				LEFT OUTER JOIN tbl_assign_customer_branch as E 
				ON D.cust_id = E.cust_id 
				where A.status= '0' 
				and E.service_branchId = '0'";
				/*echo $linkSQL;*/
}
else
{
	$linkSQL = "SELECT A.PaymentID as PaymentID, A.customerId as customerId, 
				A.quickBookRefNo as quickBookRefNo, A.CashAmount as CashAmount, 
				A.status as status, B.chequeAmount as chequeamt, B.ChequeNo as cheqNo, 
				B.Bank as bankName, C.onlineAmount as onlineAmt, B.Id as chequeId, 
				C.Id as onlinepaymentId, D.callingdata_id as callingdataid 
				FROM quickbookpaymentmethoddetailsmaster as A 
				LEFT OUTER JOIN quickbookpaymentcheque as B 
				ON A.ChequeID = B.Id 
				LEFT OUTER JOIN quickbookpaymentonlinetransfer as C 
				ON A.OnlineTransferId = C.Id 
				LEFT OUTER JOIN tbl_customer_master as D 
				ON A.customerId = D.cust_id 
				LEFT OUTER JOIN tbl_assign_customer_branch as E 
				ON D.cust_id = E.cust_id 
				where A.status= '0' 
				and E.service_branchId = '$branch_id' ";
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
                 <th><small>Bank Name</small></th>
                 <th><small>Cheque No.</small></th>
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
				<td><small>
				<?php 
				if($row["quickBookRefNo"] == 0)
				{
					echo 'N/A';
				}
				else
				{
					echo stripslashes($row["quickBookRefNo"]);
				}
				?>
                </small></td>
                <td><small>
				<?php
				if($row["bankName"] == 0)
				{
					echo 'N/A';
				}
				else
				{
				 echo getBankName(stripslashes($row["bankName"]));
				}
				?>
                </small></td>
                <td><small>
				<?php 
				if($row["cheqNo"] == 0)
				{
					echo 'N/A';
				}
				else
				{
					echo stripslashes($row["cheqNo"]);
				}	
				?>
                </small></td>
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
               