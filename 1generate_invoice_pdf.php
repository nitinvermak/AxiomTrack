<?php
include("includes/config.inc.php"); 
// include autoloader
require_once 'dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

// Post Form Data 
if (isset($_POST['generatePDF'])) {
 $invoice_id = mysql_real_escape_string($_POST['invoice_id']);
 $sql_invoice_details = "Select B.vehicle_no as vehicleNo, C.typeOfPaymentId as paymentType, 
                        C.amount as amt, C.vehicleId  as vId, C.start_date as startDate, 
                        C.end_date as endDate, B.customer_Id as custId, 
                        C.payment_rate_id as plan_rate_id          
                        from tbl_payment_breakage as C left outer join
                        tbl_gps_vehicle_master as B  
                        On C.vehicleId = B.id         
                        where C.invoiceId= '$invoice_id'
                        order by   C.vehicleId, C.typeOfPaymentId";
  // echo "<br>";
  $result_invoice_details = mysql_query($sql_invoice_details);

  // Invoice Summary 
  $sql_invoice_summary = "Select COUNT(*) as totalVehicle, C.typeOfPaymentId as paymentType, 
                          SUM(C.amount)as amt, MIN(C.start_date) as startDate, MAX(C.end_date) as endDate,
                          B.customer_Id as custId 
                          from tbl_payment_breakage as C 
                          left outer join tbl_gps_vehicle_master as B 
                          On C.vehicleId = B.id where C.invoiceId= '$invoice_id' 
                          order by C.vehicleId, C.typeOfPaymentId ";
  // echo "<br>";

  $result_invoice_summary = mysql_query($sql_invoice_summary);
  $row = mysql_fetch_assoc($result_invoice_summary);
  $total_vehicle = $row['totalVehicle'];
  $grand_total = $row['amt'];
  $from = $row['startDate'];
  $to = $row['endDate'];
  $customer_Id = $row['custId'];


  // Select Company Details
  $sql_company_details = "SELECT B.Company_Name as Company_Name, B.Address as Address, B.Area as area, 
                          B.City as city, B.State as state, B.District_id as district, B.Country as country, 
                          B.Pin_code as pincode, B.Mobile as mobileno, B.email as email
                          FROM tbl_customer_master as A 
                          INNER JOIN tblcallingdata as B 
                          ON A.callingdata_id = B.id
                          Where A.cust_id = '$customer_Id'";
  // echo "<br>";

  $result_company_details = mysql_query($sql_company_details);
  $row = mysql_fetch_assoc($result_company_details);
  $Company = $row['Company_Name'];
  $address = $row['Address'];
  $area = $row['area'];
  $city = $row['city'];
  $state = $row['state'];
  $district = $row['district'];
  $pincode = $row['pincode'];
  $mobileno = $row['mobileno'];
  $email = $row['email'];

  $sql_invoice = "SELECT `invoiceId`, `generateDate`, `dueDate` FROM `tbl_invoice_master`  
                  WHERE `invoiceId` =".$invoice_id;
  // echo "<br>";
  $result_invoice = mysql_query($sql_invoice);
  $row1 = mysql_fetch_assoc($result_invoice);
  $invoice_No = $row1['invoiceId'];
  $generateDate = $row1['generateDate'];
  $dueDate = $row1['dueDate'];

  $sno = 1;
  $sum_amt =0;
  while ($row = mysql_fetch_assoc($result_invoice_details)) {
    
  }
  $amt = $row['amt'];
  $sum_amt += $amt
  $dvTble = "<div id='invoice_content'>
              <center><img src='images/logo.jpg' alt='SRTMS'></center><br>
                <table border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                  <tr>
                    <td width='50%' style='padding:5px;'>
                        <center><strong><span style='font-family: arial, sans-serif; font-weight:bold; font-size:9px;'>Customer Information</span></strong></center>
                    </td>
                    <td width='50%' style='padding:5px;'>
                      <center><strong><span style='font-family: arial, sans-serif; font-weight:bold; font-size:9px;'>Company Information</span></strong></center>
                    </td>
                  </tr>
                  <tr>
                    <td width='50%' style='padding:5px;' valign='top'>
                      <p style='font-size:8px; font-family: arial, sans-serif; line-height:15px;'>
                        <span>                            
                          <strong>$Company</strong>
                          </span><br> 
                          <span>
                            $address". getarea($area)."<br>". getcityname($city).",". 
                            getdistrict($district).",".getstate($state).",".  
                            getpincode($pincode).",".
                            getarea($area).",".
                            getdistrict($district).",".getstate($state).",".  
                             getpincode($pincode)."
                          </span><br>
                          <span>
                           $mobileno
                          </span><br>
                          <span>
                           $email
                          
                          </span><br>
                        </p>
                       </td>
                       <td width='50%' style='padding:5px; ' valign='top'>
                        <table width='100%' border='0'>
                          <tr>
                            <td colspan='2'>
                              <center><strong><span style='font-size:8px; font-weight:bold;'>SR Transport Management Services Pvt. Ltd.</span></strong></center>
                            </td>
                          </tr>
                          <tr>
                            <td><span style='font-size:8px; font-weight:bold;'>Pan Card No. </span></td>
                            <td><span style='font-size:8px;'>AAWCS1335F</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:8px; font-weight:bold;'>Service Tax No.</span></td>
                            <td><span style='font-size:8px;'>AAWCS1335FST001</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:8px; font-weight:bold;'>Vat/CST No.</span></td>
                            <td><span style='font-size:8px;'>Applied for</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:8px; font-weight:bold;'>Bank Name  </span></td>
                            <td><span style='font-size:8px;'>Kotak Mahindra</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:8px; font-weight:bold;'>Account Number  </span></td>
                            <td><span style='font-size:8px;'>0411640116</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:8px; font-weight:bold;'>IFSC Code  </span></td>
                            <td><span style='font-size:8px;'>KKBK0000193</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:8px; font-weight:bold;'>Branch </span></td>
                            <td><span style='font-size:8px;'>Sec.- 5, Dwarka, New Delhi</span></td>
                          </tr>
                        </table>                          
                       </td>
                     </tr>
                   </table><br>

                   <table border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                      <td colspan='3' width='100%' style='padding: 5px;'>
                        <center><span style='font-size:8px; font-weight:bold; font-family: arial, sans-serif;'>INVOICE SUMMARY</span></center>
                      </td>
                    </tr>
                    <tr>
                      <td width='33%' style='padding: 5px;'>
                        <span style='font-size:8px; font-family: arial, sans-serif;'>
                          <strong>Invoice No.:</strong>  
                          $invoice_No
                        </span>
                      </td>
                      <td width='33%' style='padding: 5px;'>
                        <span style='font-size:8px; font-family: arial, sans-serif;'>
                          <strong>Invoice Date:</strong> ". date("d-m-Y", strtotime($generateDate))."
                        </span>
                      </td>
                      <td width='33%' style='padding: 5px;'>
                        <span style='font-size:8px; font-family: arial, sans-serif;'>
                          <strong>Due Date:</strong>". date("d-m-Y", strtotime($dueDate))."
                        </span>
                      </td>
                    </tr>
                   </table><br>
                   <table border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                      <td width='15%' style='padding: 5px;'>
                        <span style='font-size:8px; font-family: arial, sans-serif;'><strong>No. of Vehicles:</strong> $total_vehicle</span>
                      </td>
                      <td width='30%' style='padding: 5px;'>
                        <span style='font-size:8px; font-family: arial, sans-serif;'><strong>Rent Period:</strong> ". 
                        date("d-m-Y", strtotime($from))." To ". date("d-m-Y", strtotime($to)) ."
                        </span></td>
                      <td width='15%' style='padding: 5px;'>
                        <span style='font-size:8px; font-family: arial, sans-serif;'><strong>Amount:</strong>
                        ". $summ_total = $grand_total/115 * 100;
                            number_format($summ_total,2, '.', '')."
                      </span></td>
                      <td width='20%' style='padding: 5px;'>
                        <span style='font-size:8px; font-family: arial, sans-serif;'><strong>Tax Amount:</strong> 
                      ".$summ_tax = $summ_total/100 * 15;
                        number_format($summ_tax,2, '.', '')."
                      </span></td>
                      <td width='20%' style='padding: 5px;'>
                        <span style='font-size:8px; font-family: arial, sans-serif;'><strong>Payble Amount: </strong>
                          $grand_total
                        </span></td>
                    </tr>
                   </table><br>

                   <table border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                      <td colspan='7' width='100%' style='padding: 5px;'>
                        <center>
                          <span style='font-family: arial, sans-serif; font-size:8px; font-weight:bold;'>INVOICE DETAILS</span>
                        </center>
                      </td>
                    </tr>
                    <tr>
                      <td width='6%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:8px'><strong>S.No.</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:8px'><strong>Vehicle No.</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:8px'><strong>Rent Period</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:8px'><strong>Rent Per Vehicle</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:8px'><strong>Total Amount</strong></span></td>
                      <td width='10%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:8px'><strong>Tax</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:8px'><strong>Payble Amount</strong> </span></td>
                    </tr>
                    
                      <tr>
                        <td width='6%' style='padding: 5px;'>".$sno++.".<span></span></td>
                        <td width='16%' style='padding: 5px;'><span>".$row['vehicleNo']." 
                          </span></td>
                        <td width='16%' style='padding: 5px;'><span>".
                          date("d-m-Y", strtotime($row['startDate']))." To ". date("d-m-Y", strtotime($row['endDate']))."
                          
                        </span></td>
                        <td width='16%' style='padding: 5px;'><span>". $deviceRentAmtDict[$row["plan_rate_id"] ]."
                        </span></td>
                        <td width='16%' style='padding: 5px;'><span>
                          ".
                          $total = $row['amt']/115 * 100;
                          number_format($total,2, '.', '')
                          ."
                        </span></td>
                        <td width='10%' style='padding: 5px;'><span>
                          ".
                            $tax = $total/100 * 15;
                            number_format($tax,2, '.', '')."
                        
                        </span></td>
                        <td width='16%' style='padding: 5px;'><span> $amt
                        
                        </span></td>
                      </tr>
                      <tr>
                      <td colspan='6' style='padding: 5px;'>
                        <center><strong>Total Due Amount</strong></center>
                      </td>
                      <td  style='padding: 5px;'>
                        <strong>$sum_amt
                        </strong>
                      </td>
                    </tr>
                  </table><br>
                 </div>";

  // instantiate and use the dompdf class
  $dompdf = new Dompdf();
  $dompdf->load_html($dvTble);
  $dompdf->setPaper('A4', 'portrait');
  // Render the HTML as PDF
  $dompdf->render();
  // Output the generated PDF to Browser
  $dompdf->stream($Company);
}
 
?>