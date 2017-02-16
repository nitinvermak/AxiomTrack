<?php
include("../includes/config.inc.php");
include("../includes/crosssite.inc.php");
//include("../includes/payment_master.php");
set_time_limit(0);
error_reporting(E_ALL);
$jsonData = $_POST['postData'];
// echo print_r($jsonData['PostData']) ;
// echo '<br/>';
// $generate_date = $jsonData['gen_date'] ;
// $due_date = $jsonData['due_date'] ;
$today_date = date("Y-m-d");
$due_date = date('Y-m-d',strtotime($today_date . "+15 days"));
// echo "due date".$due_date;
// exit();
$interval_Id = $jsonData['interval_Id'];


$decode_Json_Data = $jsonData['PostData'];
// echo "<pre>";
//print_r($decode_Json_Data);
 
foreach ($decode_Json_Data as $array) {
    foreach ($array as $key => $value) {
        $chunk = explode('=', $value);
        // echo "<pre>";
        // print_r($chunk);
        $vehicleId = $chunk[0];
        $end_date = $chunk[1];
        $start_date = $chunk[2];
        $next_generation_date = date('Y-m-d',strtotime($end_date . "+1 days"));
        

        // echo "next generation date: ".$next_generation_date;
        // exit();
        $rent_amt = $chunk[3];
        $customer_Id = $chunk[4];
        $next_due_date = $chunk[5];
        $plan_rate_id = $chunk[6];
        // echo "plan_rate_id".$plan_rate_id;
        // exit();
        // $date_from = $chunk[1];
        // $date_to =
        $total_sum_rent_amt += $rent_amt;

        $sql_invoice_id = mysql_query("SELECT MAX(`invoiceId`) AS invoiceId FROM `tbl_invoice_master` ");
        $row = mysql_fetch_assoc($sql_invoice_id);
        $invoice_id = $row['invoiceId']+1;


        $sql_breakage = "INSERT INTO `tbl_payment_breakage` SET `invoiceId`='$invoice_id',
                        `typeOfPaymentId` = 'A', `vehicleId`='$vehicleId', `amount`='$rent_amt', 
                        `start_date`='$start_date', `end_date`='$end_date',`status`='A',
                        `payment_rate_id`='$plan_rate_id'";
        $result = mysql_query($sql_breakage);
        // echo "cmd".$sql_breakage;
        // echo "<br>";

        $sql_add_due_date = "Insert into tblvehicleprevduedate set customer_id= '$customer_Id',
         vehicle_id= '$vehicleId', last_due_date= '$next_due_date', interval_id = '$interval_Id'" ;
        // echo  $sql_add_due_date ;
        // echo '</br>';
        $result_add_due_date = mysql_query($sql_add_due_date );  

        $sql_update_next_generation_date = "UPDATE `tbl_gps_vehicle_payment_master` 
                                            SET `next_due_date`='$next_generation_date' 
                                            WHERE `Vehicle_id`='$vehicleId'";
        // echo $sql_update_next_generation_date;
        $result = mysql_query($sql_update_next_generation_date);
        // echo "<br>";
    }
}
$sql_invoice_master = "INSERT INTO `tbl_invoice_master` SET `customerId`='$customer_Id', 
                            `generatedAmount`='$total_sum_rent_amt', `paymentStatusFlag`='A',
                            `invoiceFlag`='N', `invoiceType` ='A', `generateDate`=Now(),
                            `intervalId`='$interval_Id', `dueDate`='$due_date'";
    $result = mysql_query($sql_invoice_master);
echo "<div class='alert alert-warning alert-dismissible' role='alert' style='max-width:500px;'>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span></button>
      <strong>Estimate Generated Successfully !</strong> 
    </div>";
?>