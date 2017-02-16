<?php
// Post Form Data 
if (isset($_POST['generatePDF'])) {
  $company_name = $_POST['company_name'];
  $address = $_POST['address'];
  $address1 = $_POST['address1'];
  $mobileno = $_POST['mobileno'];
  $email = $_POST['email'];
  $invoice_No = $_POST['invoice_No'];
  $invoice_date = $_POST['invoice_date'];
  $due_date = $_POST['due_date'];
  $total_vehicle = $_POST['total_vehicle'];
  $from_period = $_POST['from_period'];
  $to_period = $_POST['to_period'];
  $summ_amt = $_POST['summ_amt'];
  $summ_tax = $_POST['summ_tax'];
  $summ_grand_total = $_POST['summ_grand_total'];
  $vehicle_No = $_POST['vehicle_No'];
  $rent_period = $_POST['rent_period'];
  $rent_per_vehicle = $_POST['rent_per_vehicle'];
  $vehicle_total_amt = $_POST['vehicle_total_amt'];
  $vehicle_tax = $_POST['vehicle_tax'];
  $vehicle_grand_total = $_POST['vehicle_grand_total'];
  $vehicle_sum_total = $_POST['vehicle_sum_total'];
  $s_nos = $_POST['s_nos'];

  $array = array(
                        array('s_nos' => $s_nos),
                        array('vehicleNo' => $vehicle_No),
                        array('rent_period' => $rent_period),
                        array('rent_per_vehicle' => $rent_per_vehicle),
                        array('vehicle_total_amt' => $vehicle_total_amt),
                        array('vehicle_tax' => $vehicle_tax),
                        array('vehicle_grand_total' => $vehicle_grand_total)
                    ); 
  echo "<pre>";
  print_r($array);
}
?>