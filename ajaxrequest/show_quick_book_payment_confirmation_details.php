<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$branch_id=$_REQUEST['branch']; 
error_reporting(0);
if ($branch_id == 0)
	$linkSQL = "SELECT B.PaymentID as PaymentID, B.customerId as customerId, 
				B.quickBookRefNo as quickBookRefNo, B.CashAmount as CashAmount,
				A.Amount as chequeamt, C.Amount as onlineAmt
				from quickbookpaymentcheque as A 
				Left Outer JOIN quickbookpaymentmethoddetailsmaster as B 
				ON A.Id = B.ChequeID
				Left Outer JOIN quickbookpaymentonlinetransfer as C 
				ON B.OnlineTransferId = C.Id WHERE B.status = '0'";
else
	$linkSQL = "SELECT B.PaymentID as B.PaymentID, B.customerId as customerId, 
				B.quickBookRefNo as quickBookRefNo, B.CashAmount as CashAmount,
				A.Amount as chequeamt, C.Amount as onlineAmt
				from quickbookpaymentcheque as A 
				Left Outer  JOIN quickbookpaymentmethoddetailsmaster as B 
				ON A.Id = B.ChequeID
				Left Outer JOIN quickbookpaymentonlinetransfer as C 
				ON B.OnlineTransferId = C.Id WHERE B.status = '0'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				 <tr>
	             <th><small>Payment Id</small></th>                        
	             <th><small>Customer Id</small></th>  
	             <th><small>Quick Book Ref. No.</small></th>
	             <th><small>Cash Amount</small></th> 
                 <th><small>Cheque Amount</small></th>  
                 <th><small>Online Amount</small></th> 
	             <th><small>Status</small></th>
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
                <td><small><?php echo stripslashes($row["customerId"]);?></small></td>	
				<td><small><?php echo stripslashes($row["quickBookRefNo"]);?></small></td>
                <td><small><?php echo stripslashes($row["CashAmount"]);?></small></td>	
                <td><small><?php echo stripslashes($row["chequeamt"]);?></small></td>
                <td><small><?php echo stripslashes($row["onlineAmt"]);?></small></td>				  
                <td><input type='checkbox' name='linkID[]' value='<?php echo $row["PaymentID"]; ?>'></td>
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
               