<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
$customerId = mysql_real_escape_string($_POST['cust_id']);
$sql = "SELECT `billId`,`custId`,`paymentMode`,`billDeliveryMode`,`paymentPeriod`,`paymentPickupMode`,`customerType` FROM `billingprofile` WHERE `custId`=".$customerId;
$result = mysql_query($sql);
$qry = mysql_fetch_assoc($result);

?>
<div class="col-md-12" id="dv_Msg"></div>
 <div class="col-md-12">
  <form>
  <input type="hidden" name="billId" id="billId" value="<?php echo $qry['billId']; ?>" />
    <div class="form-group">
      <label for="Mode of Payment">Mode of Payment</label>
      <select name="paymentModeB" id="paymentModeB" class="form-control drop_down">
        <option value="<?php if(isset($qry['custId'])){ echo $qry['paymentMode']; } else { }  ?>">
        <?php if(isset($qry['custId'])){ echo $qry['paymentMode']; } else { echo '--Select--'; }  ?>
        </option>
        <option>Cash</option>
        <option>NEFT</option>
        <option>Cheque</option>
      </select>
    </div>
    <div class="form-group">
      <label for="Bill Delivery Mode">Bill Delivery Mode</label>
      <select name="billDeliveryModeB" id="billDeliveryModeB" class="form-control drop_down">
        <option value="<?php if(isset($qry['custId'])){ echo $qry['billDeliveryMode']; } else { }  ?>">
        <?php if(isset($qry['custId'])){ echo $qry['billDeliveryMode']; } else { echo '--Select--'; }  ?>
        </option>
        <option>Courier</option>
        <option>Maic</option>
        <option>By Hand</option>
      </select>
    </div>
    <div class="form-group">
      <label for="Payment Period">Payment Period</label>
      <select name="paymentPeriodB" id="paymentPeriodB" class="form-control drop_down">
        <option value="<?php if(isset($qry['custId'])){ echo $qry['paymentPeriod']; } else { }  ?>">
        <?php if(isset($qry['custId'])){ echo $qry['paymentPeriod']; } else { echo '--Select--'; }  ?>
        </option>
        <option>1 Week</option>
        <option>2 Days</option>
        <option>3 Days</option>
        <option>4 Days</option>
        <option>5 Days</option>
      </select>
    </div>
    <div class="form-group">
      <label for="Payment Pick-Up Mode">Payment Pick-Up Mode</label>
      <select name="pickupModeB" id="pickupModeB" class="form-control drop_down">
        <option value="<?php if(isset($qry['custId'])){ echo $qry['paymentPickupMode']; } else { }  ?>">
        <?php if(isset($qry['custId'])){ echo $qry['paymentPickupMode']; } else { echo '--Select--'; }  ?>
        </option>
        <option>By Hand</option>
        <option>Self Mode</option>
      </select>
    </div>
    <div class="form-group">
      <label for="Customer Type">Customer Type</label>
      <select name="customerTypeB" id="customerTypeB" class="form-control drop_down">
        <option value="<?php if(isset($qry['custId'])){ echo $qry['customerType']; } else { }  ?>">
        <?php if(isset($qry['custId'])){ echo $qry['customerType']; } else { echo '--Select--'; }  ?>
        </option>
        <option>Silver</option>
        <option>Gold</option>
        <option>Diamond</option>
      </select>
    </div>
    <input type="button" value="Submit" name="submit" id="submit"  class="btn btn-primary btn-sm" onClick="UpdateBillingProfile();" />
  </form>
</div>