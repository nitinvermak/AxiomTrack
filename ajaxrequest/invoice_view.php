<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
/*echo $cust_id;*/
error_reporting(0);
if($cust_id != "")
{
		$linkSQL = "Select A.invoiceId as invoiceId, B.paymentID as paymentId, 
					A.customerId as customerId, A.generatedAmount as Amount, 
					A.generateDate as generateDate, A.dueDate as dueDate, 
					A.discountedAmount as discount, F.callingdata_id as callingdateId
					from tbl_invoice_master as A
					inner Join tblpaymentinvoicemap as B 
					On A.invoiceId = B.invoiceId
					inner join paymentcheque as C 
					On B.paymentId = C.id
					inner join paymentonlinetransfer as D 
					On C.id = D.id
					inner Join paymentmethoddetailsmaster as E 
					on D.id = E.paymentId 
					inner join tbl_customer_master as F
					On A.customerId = F.cust_id
					where A.invoiceFlag ='Y' and A.customerId = '$cust_id'";
		/*echo $linkSQL;*/
		$oRS = mysql_query($linkSQL);
		if(mysql_num_rows($oRS)>0)
			{
				echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
		<tr>
       
      	<th><small>S.No.</small></th>  
        <th><small>Invoice Id</small></th>  
		<th><small>Payment Id</small></th>
      	<th><small>Customer Name</small></th>  
      	<th><small>Generated Amount</small></th>
        <th><small>Generated Date</small></th>
      	<th><small>Due Date</small></th> 
        <th><small>Discount Amount</small></th> 
        <th><small>Make Payment</small></th>
      	</tr>    
        <?php
		$kolor=1;
		if(isset($_GET['page']) and is_null($_GET['page']))
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']==1)
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']>1)
			{
				$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
			}
	 	if(mysql_num_rows($oRS)>0)
	  		{
  				while ($row = mysql_fetch_array($oRS))
  			{
  				if($kolor%2==0)
					$class="bgcolor='#ffffff'";
				else
					$class="bgcolor='#fff'";
 	  	?>
        <tr <?php print $class?>>
      	<td><small><?php print $kolor++;?>.</small></td>
	  	<td><small><?php echo stripslashes($row["invoiceId"]);?><input type="hidden" name="invoiceId" value="<?php echo stripslashes($row["invoiceId"]);?>" /></small></td>
      	<td><small><?php echo stripslashes($row["paymentId"]);?></small></td>
		<td><small><?php echo getOraganization(stripcslashes($row['callingdateId'])); ?></small></td>
      	<td><small><?php echo stripslashes($row["Amount"]);?> </small></td>
        <td><small><?php echo stripslashes($row["generateDate"]); ?></small></td>
        <td><small><?php echo stripslashes($row["dueDate"]);?></small></td>
        <td><small><?php echo stripcslashes($row["discount"]); ?></small></td>
        <td><button type="button" class="btn btn-info btn-sm" id="#edit<?php echo stripslashes($row["paymentId"]);?>"  data-toggle="modal" data-target=".bs-example-modal-lg-payment">
        View Invoice</button>
        </td>
      	</tr>
        <?php 
           	}
             	echo $pagerstring;
          }
        }
	 else
       echo "<tr><td colspan=6 align=center><h3><font color=red>No records found !</h3></font></td><tr/></table>";
	}
else
{
	echo "<script> alert('Please Provide Search Criteria'); </script>";
}
 ?>
