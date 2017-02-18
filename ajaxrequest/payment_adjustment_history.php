<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$paymentId = mysql_real_escape_string($_POST['paymentId']);
error_reporting(0);

?>	
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">Payment Adjustment Details</h4>
</div>
<div class="modal-body">
  <div class="col-md-12 table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th><small>S.No.</small></th>
          <th><small>Adjustment Type</small></th>
          <th><small>Details</small></th>
          <th><small>Amount</small></th>
        </tr>
      </thead>
      <tbody>
      <?php 
      $sno = 1;
      $sql = mysql_query("SELECT A.estimateId as estimateId, C.vehicle_no as vehicleNo, A.amount as rentAmount 
                          FROM paymentestimateadadjustment as  A 
                          INNER JOIN tbl_payment_breakage as B 
                          ON A.estimateId = B.invoiceId
                          INNER JOIN tbl_gps_vehicle_master as C 
                          ON B.vehicleId = C.id
                          WHERE A.paymentId = '$paymentId' AND B.status <> 'D'");
      while ($row = mysql_fetch_assoc($sql)) {
      ?>
        <tr>
          <td><small><?php echo $sno++; ?></small></td>
          <td><small>Rentel</small></td>
          <td><small><strong>Est. Id. </strong> <?php echo $row['estimateId']; ?><br>
              <strong>Vehicle No.</strong> <?php echo $row['vehicleNo']; ?>
          </small></td>
          <td><small><?php echo $row['rentAmount']; ?></small></td>
        </tr>
      <?php 
      }
      ?>
      <?php 
      $sno = 1;
      $sql = mysql_query("SELECT B.vehicle_no as vehicleNo, A.deviceamt as deviceAmt
                          FROM devicepayment as A 
                          INNER JOIN tbl_gps_vehicle_master as B 
                          ON A.vehicleId = B.id 
                          WHERE A.paymentId ='$paymentId'");
      while ($row = mysql_fetch_assoc($sql)) {
      ?>
        <tr>
            <td><small><?php echo $sno++; ?></small></td>
            <td><small>Device</small></td>
            <td><small><strong>Vehicle No.</strong> <?php echo $row['vehicleNo']; ?>
            </small></td>
            <td><small><?php echo $row['deviceAmt']; ?></small></td>
          </tr>
      <?php 
      }
      ?>
      </tbody>
    </table>

  </div>
   <div class="clearfix"></div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
</div>