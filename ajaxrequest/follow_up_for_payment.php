<?php
include("../includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
$estimate_id = mysql_real_escape_string($_POST['estimate_id']);

$sql = "SELECT * FROM `paymentfollowup` 
        WHERE `estimateId`='$estimate_id' 
        ORDER BY `created_at`";
$result = mysql_query($sql);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Follow-Up</h4>
</div>
<div class="modal-body">
    <div class="col-md-12" id="dv_msg">
        
    </div>
    <div class="col-md-12"> <!-- form -->
        <form>
          <input type="hidden" name="estimate_id" id="estimate_id" value="<?= $estimate_id ?>">
          <div class="form-group">
            <label for="exampleInputEmail1">Payment Status</label>
            <select class="form-control" name="payment_status" id="payment_status">
                <option value="">--Select--</option>
                <option value="Pending">Pending</option>
                <option value="Received">Received</option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Follow-Up Status</label>
            <select class="form-control" name="followup_status" id="followup_status" onchange="getField();">
                <option value="">--Select--</option>
                <option value="Pending">Pending</option>
                <option value="Done">Done</option>
            </select>
          </div>
          <div class="form-group" id="dv_ptp" style="display: none;">
            <label for="exampleInputPassword1">PTP Date</label>
            <input type="text" name="ptp_date" id="ptp_date" class="form-control date">
          </div>
          <div class="form-group" id="dv_reason" style="display: none;">
            <label for="exampleInputPassword1">Reason</label>
            <textarea name="reason" id="reason" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Remarks</label>
            <textarea name="remarks" id="remarks" class="form-control"></textarea>
          </div>
        </form>
    </div> <!-- end form -->
    <div class="col-md-12"> <!-- follow-up history -->
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">        
            <thead>
                <tr>
                    <th><small>S. No.</small></th>     
                    <th><small>Estimate</small></th> 
                    <th><small>Payment Status</small></th>  
                    <th><small>Follow-Up Status</small></th> 
                    <th><small>PTP Date</small></th>  
                    <th><small>Reason</small></th>   
                    <th><small>Remarks</small></th>    
                    <th><small>Follow-Up By</small></th>                      
                </tr> 
            </thead>
            <tbody>
            <?php 
            $sno = 1;
            if(mysql_num_rows($result)>0){
                while ($row = mysql_fetch_array($result)){
                    echo "<tr>";
                    echo "<td><small>".$sno++."</small></td>";
                    echo "<td><small>".$row['estimateId']."</small></td>";
                    echo "<td><small>".$row['payment_status']."</small></td>";
                    echo "<td><small>".$row['follow_up_status']."</small></td>";
                    echo "<td><small>".$row['ptp_date ']."</small></td>";
                    echo "<td><small>".$row['reason']."</small></td>";
                    echo "<td><small>".$row['remarks']."</small></td>";
                    echo "<td><small>".gettelecallername($row['follow_up_by'])."</small></td>";
                    echo "</tr>";
                }
            }
            else{
                echo "<tr>";
                echo "<td colspan='8'><center><small><h4 style='color:red'>No Follow-Up</h4></small></center></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div> <!-- end follow-up history -->
</div>
<div class="clearfix"></div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary btn-sm" onclick="history_save();">Submit</button>
</div>