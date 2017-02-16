<?php
include("../includes/config.inc.php"); 
// include("../includes/crosssite.inc.php");  
$orgName = mysql_real_escape_string($_POST['customerId']);

?>
<div class="modal-header">
  <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeForm();"><span aria-hidden="true">&times;</span></button> -->
  <h4 class="modal-title">Re-generate Manually Estimate</h4>
</div>
<div class="modal-body">
  <div class="col-md-12" id="dv_success">
    <p><strong>Generated Date:</strong> <input type="text" name="generated_date" id="generated_date" class="form-control" onchange="get_intervalId();" readonly="">
     <strong>Due Date:</strong> <input type="text" name="due_date1" id="due_date1" class="form-control date">
     <span id="dv_intervalId"></span>
    </p>
  </div>
  <div class="col-md-12 table-responsive">
      <table id="example" class="table table-striped">
          <tr>
              <th><small>S.No.</small></th>
              <th><small>Vehicle No.</small></th>
              <th><small>Installation Date
              </small></th>
              <!-- <th><small>Last Generate Date</small></th> -->
              <th><small>Rent Amt.</small></th>
			  <th><small>Date upto which bill is generated</small></th>
              <th><small>Start Date
                  <input type='checkbox' name='date_field' class='date_field' id='date_field' onchange='makeAllStartDateSame()' >
                  <span  style='color:#fff; font-size: 8px'>Make All Date Same</span></small>
                </small></th>
              <th><small>End Date
                  <input type='checkbox' name='date_field' class='date_field' id='date_field' onchange='makeAllEndDateSame()' >
                  <span  style='color:#fff; font-size: 8px'>Make All Date Same</span>
              </small></th>
              <th><small>Rent Amt.
                  <input type='checkbox' name='date_field' class='date_field' id='date_field' onchange='makeAllRentAmtSame()' >
                  <span  style='color:#fff; font-size: 8px'>Make All Rent Amt. Same</span>
                 </small></th>
              <!-- <th><small>Action</small></th> -->
          </tr>
          
            <?php 
            $sn = 1;
            $sql = mysql_query("SELECT A.vehicle_no as vno, B.device_rent_amt as rentamt, 
                                A.installation_date as installationDate, B.Vehicle_id as vId,
								B.next_due_date as next_due_date
                                FROM tbl_gps_vehicle_master as A 
                                INNER JOIN tbl_gps_vehicle_payment_master as B 
                                ON A.id = B.Vehicle_id
                                WHERE A.activeStatus = 'Y'
                                AND B.PlanactiveFlag = 'Y'
                                AND A.customer_Id = '$orgName'");
            while ($row = mysql_fetch_array($sql)) {
            ?>
            <tr class="row_val">
              <td><?php echo $sn++; ?></td>
              <td><?php echo $row['vno']; ?><input type="hidden" class="form-control" name="aa" id="aa<?php echo $row['vId']; ?>" value="asdfasfd"></td>
              <td><?php echo $row['installationDate']; ?>
                

              </td>
              <td><?php echo getPlanAmt($row['rentamt']); ?>
                  <input type="hidden" name="rent_ammt" id="rent_ammt_<?= $row['vId']; ?>" 
                  class="rent_ammt data" value="<?php echo getPlanAmt($row['rentamt']); ?>">
              </td>
			        <td><?php echo  $row['next_due_date'] ?>
                  <input type="hidden" name="next_due_date" id="next_due_date" class="next_due_date" 
                  value="<?php echo  $row['next_due_date'] ?>">
                  <input type="hidden" name="customer_Id" class="customer_Id" id="customer_Id" class="data" value="<?php echo $orgName; ?>">   
              </td>
			  
              <td><input type="text" class="form-control date data start_date" name="start_date" id="start_date_<?php echo $row['vId']; ?>"></td>
              <td><input type="text" name="enddate" id="end_date_<?php echo $row['vId']; ?>" class="form-control date end_date data" onchange="calculate_amt(<?php echo $row['vId']; ?>);">
                  <input type="hidden" name="vehicleId" class="data vehicle_id" value="<?php echo $row['vId']; ?>">
                  
              </td>
              <td><input type="text" name="rent_amt" id="rent_amt" class="form-control rent_amt data"></td>
              <!-- <td><input type="button" name="a<?php echo $row['vId']; ?>" id="getMonthDays" class="calculate_amt" value="Count" ></td> -->
            </tr>
            <?php  
            }
            ?>
            
      </table>
  </div>
  <!-- <div class="col-md-12 form">
      <div class="col-md-6 col-sm-6 custom_form">
          <span><strong>From Date</strong><i>*</i></span>
          <input type="text" name="datefrom" id="date_from" class="form-control datepik">
      </div>
      <div class="col-md-6 col-sm-6 custom_form">
          <span><strong>To Date</strong><i>*</i></span>
          <input type="text" name="dateto" id="date_to" class="form-control datepik">
      </div>
      <div class="col-md-6 col-sm-6 custom_form" id="dv_shw">
      dv_shw
      </div>
      <div class="col-md-6 col-sm-6 custom_form" id="">
          <span><strong>Calculation Amt.</strong><i>*</i></span>
          <input type="text" name="calculationAmt" id="calculationAmt" class="form-control">
          <input type="button" name="calculationAmt" id="calculationAmt" onclick="get_Months_days()" value="Calculate">
      </div>
      <div class="col-md-6 col-sm-6 custom_form">
          <span><strong>Amt.</strong><i>*</i></span>
          <input type="text" name="amt" id="amt" class="form-control">
      </div>
      
  </div> -->
  <div class="clearfix"></div>
</div> <!-- end body -->
<div class="modal-footer">
  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
  <button type="button" class="btn btn-primary btn-sm" onclick="save_rent_amount();">Submit</button>
</div>