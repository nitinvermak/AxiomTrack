<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$custId = mysql_real_escape_string($_POST['custId']);
error_reporting(0);
	$linkSQL = "select * from tbl_customer_master as A
                inner join tbl_invoice_master as B
                on A.cust_id = B.customerId
                inner Join tblesitmateperiod as C
                on B.intervalId = C.intervalId
                where B.customerId ='$custId'
                and B.paymentStatusFlag = 'A'
                order by invoiceId";
    // echo $linkSQL;
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0){
?>		
<div class="paymentType">
    <p><strong>Payment Id</strong>
    <select name="paymentId" class="form-control input-sm drop_down" id="paymentId" onChange="getDeviceAmt();">
        <option label="" value="">--Select--</option>
        <?php $sql = mysql_query("SELECT `PaymentID` 
                                  FROM `quickbookpaymentmethoddetailsmaster` 
                                  WHERE `customerId` = '$custId' and adjustmentAmt <> 0");
              while($result=mysql_fetch_assoc($sql)){
        ?>
        <option value="<?php echo $result['PaymentID']; ?>"><?php echo $result['PaymentID']; ?></option>
        <?php }?>
    </select>
    <span id="divAmt"> </span></p>
</div>
<table border="0" width="100%" class="table table-hover table-bordered">
    <tr>
        <th><small>S. No.</small></th>     
        <th><small>Estimate Id</small></th>
        <th><small>Estimate Type</small></th>
        <th><small>Generated Date</small></th>
        <th><small>Due Date</small></th> 
        <th><small>Generated Amount</small></th>
        <th><small>Discount Amount</small></th>
        <th><small>Total Amount</small></th>
        <th><small>Recieved Amt</small></th>
        <th><small>Details/Discount</small></th>
        <th><small>Adjust Amt.</small></th>
        <th><small>Action</small></th>        
    </tr>   
<?php
$kolor =1;
while ($row = mysql_fetch_array($stockArr)){
?>
    <tr>
        <td><small><?php print $kolor++;?>.</small></td>
        <td><small><?php echo stripslashes($row["invoiceId"]);?>
                   <input type="hidden" name="invoiceId" id="invoiceId" value="<?php echo stripslashes($row["invoiceId"]);?>" />
        </small></td>
        <td><small><?php if ($row["invoiceType"] == "A"){ echo 'Rental';} elseif($row["invoiceType"] == "B") { echo 'Device';}  ?>
        </small></td>
        <td><small><?php echo stripslashes($row["generateDate"]);?></small></td>
        <td><small><?php echo stripslashes($row["dueDate"]); ?></small></td>
        <td><small><?php echo stripslashes($row["generatedAmount"]);?></small></td>
        <td><small>
            <?php if($row["discountedAmount"]==0){
                    echo "N/A";
                   }
                   else{
                    echo stripcslashes($row["discountedAmount"]);   
                   }
            ?>
            <input type="hidden" name="disAmt" id="disAmt" value="<?= $row["discountedAmount"]; ?>">
        </small></td>
        <td style="background-color: red; color: #fff; font-weight: bold; font-size: 14px"><small><?php echo $totalAmt = $row["generatedAmount"] - $row["discountedAmount"]?>
            <input type="hidden" name="total_amt" id="total_amt" value="<?= $totalAmt; ?>">
        </small></td>
        <td style="background-color: green; color: #fff; font-weight: bold; font-size: 14px"><small><?= $row["paidAmount"] ?></small>
        <input type="hidden" name="prev_rcd_amt" id="prev_rcd_amt" value="<?= $row["paidAmount"] ?>">
        </td>
        <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="getPaymentDetails(<?php echo stripslashes($row["invoiceId"]);?>);">Details</button></td>
        <td><input type="text" name="adjustmentAmt" id="adjustmentAmt" class="form-control" /></td>
        <td><input type="button" class="btn btn-primary btn-sm" name="save" id="save" value="Save" onclick="getDeviceRentAmount()" /></td>
    </tr>
<?php 
}
echo "</table>";
}
else{
    echo "<h3 class='red'>No records found!</h3><br><br>";
}
?> 

                         