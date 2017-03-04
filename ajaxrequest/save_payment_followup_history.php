<?php
include("../includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
$estimate_id = mysql_real_escape_string($_POST['estimate_id']);
$payment_status = mysql_real_escape_string($_POST['payment_status']);
$followup_status = mysql_real_escape_string($_POST['followup_status']);
$ptp_date = mysql_real_escape_string($_POST['ptp_date']);
$reason = mysql_real_escape_string($_POST['reason']);
$remarks = mysql_real_escape_string($_POST['remarks']);
$follow_up_by = $_SESSION['user_id'];

$sql = "INSERT INTO `paymentfollowup` SET `estimateId`='$estimate_id',`payment_status`='$payment_status',
        `follow_up_status`='$followup_status',`ptp_date`='$ptp_date',`reason`='$reason',`remarks`='$remarks',
        `follow_up_by`='$follow_up_by'";
$result = mysql_query($sql);
if ($result) {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button>
            <strong>Success!</strong> 
          </div>";
}
?>
