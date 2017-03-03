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
$due_date = $jsonData['due_date'] ;
$interval_Id = $jsonData['interval_Id'];


$decode_Json_Data = $jsonData['PostData'];
echo "<pre>";
//print_r($decode_Json_Data);
 
foreach ($decode_Json_Data as $array) {
    foreach ($array as $key => $value) {
        $chunk = explode('=', $value);
        // echo "<pre>";
        // print_r($chunk);
        $vehicleId = $chunk[0];
        $start_date = $chunk[1];
        $end_date = $chunk[2];
        $rent_amt = $chunk[3];
        $customer_Id = $chunk[4];
        $next_due_date = $chunk[5];
        // $date_from = $chunk[1];
        // $date_to =
        $total_sum_rent_amt += $rent_amt;

        $sql_invoice_id = mysql_query("SELECT MAX(`invoiceId`) AS invoiceId FROM `tbl_invoice_master` ");
        $row = mysql_fetch_assoc($sql_invoice_id);
        $invoice_id = $row['invoiceId']+1;


        $sql_breakage = "INSERT INTO `tbl_payment_breakage` SET `invoiceId`='$invoice_id',
                        `typeOfPaymentId` = 'A', `vehicleId`='$vehicleId', `amount`='$rent_amt', 
                        `start_date`='$start_date', `end_date`='$end_date',`status`='A'";
        $result = mysql_query($sql_breakage);
        echo "cmd".$sql_breakage;
        echo "<br>";

        $sql_add_due_date = "Insert into tblvehicleprevduedate set customer_id= '$customer_Id',
         vehicle_id= '$vehicleId', last_due_date= '$next_due_date', interval_id = '$interval_Id'" ;
        echo  $sql_add_due_date ;
        echo '</br>';
        $result_add_due_date = mysql_query($sql_add_due_date );  
    }
}
echo $sql_invoice_master = "INSERT INTO `tbl_invoice_master` SET `customerId`='$customer_Id', 
                            `generatedAmount`='$total_sum_rent_amt', `paymentStatusFlag`='A',
                            `invoiceFlag`='N', `invoiceType` ='A', `generateDate`='Now()',
                            `dueDate`='$due_date'";
    $result = mysql_query($sql_invoice_master);
?>