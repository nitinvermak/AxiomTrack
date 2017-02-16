<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
?>
<div class="col-md-12" id="dvMSG"></div>
<div class="col-md-12">
  <form>
  <input type="hidden" name="submitForm" value="yes" />
    <div class="form-group">
      <label for="Mode of Payment">Mode of Payment</label>
      <select name="paymentModeB" id="paymentModeB" class="form-control drop_down">
        <option>--Select--</option>
        <option value="Cash">Cash</option>
        <option value="NEFT">NEFT</option>
        <option value="Cheque">Cheque</option>
      </select>
    </div>
    <div class="form-group">
      <label for="Bill Delivery Mode">Bill Delivery Mode</label>
      <select name="billDeliveryModeB" id="billDeliveryModeB" class="form-control drop_down">
        <option>--Select--</option>
        <option value="Courier">Courier</option>
        <option id="Email">Email</option>
        <option value="By Hand">By Hand</option>
      </select>
    </div>
    <div class="form-group">
      <label for="Payment Period">Payment Period</label>
      <select name="paymentPeriodB" id="paymentPeriodB" class="form-control drop_down">
        <option>--Select--</option>
        <option value="1 Week">1 Week</option>
        <option value="2 Week">2 Week</option>
        <option value="3 Week">3 Week</option>
        <option value="4 Week">4 Week</option>
        <option value="5 Week">5 Week</option>
      </select>
    </div>
    <div class="form-group">
      <label for="Payment Pick-Up Mode">Payment Pick-Up Mode</label>
      <select name="pickupModeB" id="pickupModeB" class="form-control drop_down">
        <option>--Select--</option>
        <option value="By Hand">By Hand</option>
        <option value="Self Mod">Self Mode</option>
      </select>
    </div>
    <div class="form-group">
      <label for="Customer Type">Customer Type</label>
      <select name="customerTypeB" id="customerTypeB" class="form-control drop_down">
        <option>--Select--</option>
        <option value="Silver">Silver</option>
        <option value="Gold">Gold</option>
        <option value="Diamond">Diamond</option>
      </select>
    </div>
    <input type="button" value="Submit" name="submit" id="submit"  class="btn btn-primary btn-sm" onclick="createBillingProfile();" />
  </form>
</div>