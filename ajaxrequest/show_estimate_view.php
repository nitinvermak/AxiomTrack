<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
/*echo $cust_id;*/
error_reporting(0);
if($cust_id != "")
{
		$linkSQL = "select * from tbl_customer_master as A
					inner join tbl_invoice_master as B
					on A.cust_id = B.customerId
					inner Join tblesitmateperiod as C
					on B.intervalId = C.intervalId
					
					 where B.customerId ='$cust_id'";
		/*echo $linkSQL;*/
		$oRS = mysql_query($linkSQL);
		if(mysql_num_rows($oRS)>0)
			{
				echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
		<tr>
       
      	<th>S.No.</th>  
        <th>Invoice/Estimate Id</th>  
      	<th>Customer Name</th>  
      	<th>Interval Name</th>
      	<th>Generated Amount</th> 
        <th>Discount Amount</th> 
        <th>Payment Details</th>
        <th>Make Payment</th>
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
      	<td><?php print $kolor++;?>.</td>
	  	<td><?php echo stripslashes($row["invoiceId"]);?><input type="hidden" name="invoiceId" value="<?php echo stripslashes($row["invoiceId"]);?>" /></td>
      	<td><?php $orgName =  getOraganization(stripslashes($row["callingdata_id"])); echo $orgName;  ?> </td>
      	<td><?php $intervalName=  getIntervelname(stripslashes($row["intervalId"])); echo $intervalName." ".$row["IntervelYear"]; ?> </td>
        <td><?php echo stripslashes($row["generatedAmount"]);?></td>
        <td><?php if($row["discountedAmount"]==0)
					{
						echo "N/A";
					}
				  else
					{
						echo stripcslashes($row["discountedAmount"]);	
					}
			?>
		</td>
        <td><strong>
         
        
        <a data-toggle="modal" data-target=".bs-example-modal-lg<?php echo stripslashes($row["invoiceId"]);?>">Payment Details</a></strong>
        <!--Modal-->
        <!--<a data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</a>-->
        <div class="modal fade bs-example-modal-lg<?php echo stripslashes($row["invoiceId"]);?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Payment Details</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-bordered ">
      <?php
		$where='';
		$linkSQL="";
		$invoiceId = $row["invoiceId"];
		/*echo $invoiceId;*/			
 		
     	$linkSQL1 = "select B.vehicle_no as vehicleNo, C.typeOfPaymentId as paymentType, C.amount as amt, 
					A.paymentStatusFlag as statusFlag
					from tbl_invoice_master as A
					inner join tbl_gps_vehicle_master as B
					On A.invoiceId = B.id
					inner join tbl_payment_breakage as C 
					on B.id = C.invoiceId Where C.invoiceId= '$invoiceId'";
		/*echo $linkSQL;*/
 		$oRS1 = mysql_query($linkSQL1); 
 		?>
      <thead>
      <tr>
      <th><small>S. No.</small></th>
      <th><small>Vehile Reg. No.</small></th>
      <th><small>Payment Type</small></th>    
      <th><small>Amount</small></th> 
      </tr>    
      </thead>
	  <?php
	  $kolor1=1;
	  if(mysql_num_rows($oRS1)>0)
	  	{
  			while ($row1 = mysql_fetch_array($oRS1))
  			{
  				if($kolor1%2==0)
					$class="bgcolor='#ffffff'";
				else
					$class="bgcolor='#fff'";
 	  ?>
      <tbody>
      <tr>
      <td><small><?php print $kolor1++;?>.</small></td>
	  <td><small><?php echo stripslashes($row1["vehicleNo"]);?></small></td>
      <td><small>
	  <?php 
	  if($row1["paymentType"] == "A")
	  {
	  echo "Rent";
	  }
	  if($row1["paymentType"] == "B")
	  {
	  echo "Device Amount";
	  }
	  if($row1["paymentType"] == "C")
	  {
	  	echo "Installation Charges";
	  }
	  if($row1["paymentType"] == "D")
	  {
	  	echo "Installment Amount";
	  }
	  ?>
      </small></td>
	  <td><small><?php echo stripcslashes($row1["amt"]); ?></small></td>
      </tr>
  	
      </tbody>
	<?php 
    	}
    }
    ?>
    <tr>
    <td></td>
    <td></td>
    <td><p class="pull-right"><strong>Total Amount</strong></p></td>
    <td>
    	<?php 
			$sql1 = "select sum(amount) from tbl_payment_breakage where invoiceId = '$invoiceId'";
			$query2 = mysql_query($sql1);
			$row2 = mysql_fetch_array($query2);
			echo $row2[0];
		?>
    </td>
   
    </tr>
    </table>
                
                
                
  
                </div>
            </div>
          </div>
        </div>
        <!-- End -->
        </td>
        <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg-payment"    
        onclick="getValue( <?php echo "'".$orgName."','".$intervalName."',".stripslashes($row["invoiceId"]).",".
		stripslashes($row["generatedAmount"]).",".$row["IntervelYear"]; ?> )">
        Make Payment</button></td>
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
