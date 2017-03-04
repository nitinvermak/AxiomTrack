<?php
include("includes/config.inc.php"); 
// include autoloader
require_once 'dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
if (isset($_POST['generatePDF'])) {
  $estimate_id = mysql_real_escape_string($_POST['invoice_id']);
  // Select Customer Details
  $sql_info = "SELECT A.customerId as customerId 
                  FROM tbl_invoice_master as A 
                  INNER JOIN tbl_gps_vehicle_payment_master as B 
                  ON A.customerId = B.cust_id 
                  WHERE  A.invoiceId = $estimate_id";
  $result_info = mysql_query($sql_info);
  $row_info = mysql_fetch_assoc($result_info);
  $customer_id = $row_info['customerId'];

  // Customer details
  $sql = "SELECT A.cust_id as custId, CONCAT(B.First_Name,' ', B.Last_Name) as contactPerson, 
          B.Company_Name as companyName, B.Address as address, B.Area as area, B.City as city, 
          B.District_id as district, B.State as state, B.Pin_code as pincode, B.email as email, 
          B.Mobile as mobile
          FROM tbl_customer_master as A 
          INNER JOIN tblcallingdata as B 
          ON A.callingdata_id = B.id 
          WHERE A.cust_id = ".$customer_id;
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);
  $contactPersonName = $row['contactPerson'];
  $companyName = $row['companyName'];
  $address = $row['address'];
  $area = $row['area'];
  $city = $row['city'];
  $district = $row['district'];
  $state = $row['state'];
  $pincode = $row['pincode'];
  $email = $row['email'];
  $mobile = $row['mobile'];

  // Select Estimate Summary
  $sql1 = "SELECT * FROM `tbl_invoice_master` WHERE `invoiceId`=".$estimate_id;
  $result1 = mysql_query($sql1);
  $row1 = mysql_fetch_assoc($result1);
  $generate_date = $row1['generateDate'];
  $due_date = $row1['dueDate'];

  // select no of vehilces
  $sql2 = "SELECT count(*) as no_of_veh, B.generatedAmount as generatedAmount
           FROM tbl_gps_vehicle_payment_master as A 
           INNER JOIN tbl_invoice_master as B 
           ON A.cust_id = B.customerId 
           WHERE A.device_status_gen_status = 'Y' 
           AND B.invoiceType = 'B' 
           AND B.invoiceId =  ".$estimate_id;
  $result2 = mysql_query($sql2);
  $row2 = mysql_fetch_assoc($result2);
  $total_vehicle = $row2['no_of_veh'];
  $total_amount = $row2['generatedAmount'];

  // ESTIMATE DETAILS 
  $sql3 = "SELECT C.vehicle_no as vehicle_no, A.device_amt as device_amt,
          C.installation_date as activationdate
          FROM tbl_gps_vehicle_payment_master as A 
          INNER JOIN tbl_invoice_master as B 
          ON A.cust_id = B.customerId 
          INNER JOIN tbl_gps_vehicle_master as C 
          ON A.Vehicle_id = C.id
          WHERE A.device_status_gen_status = 'Y' 
          AND B.invoiceType = 'B' 
          AND B.invoiceId =".$estimate_id;
  $result3 = mysql_query($sql3);
  $sno = 1;
  $sum_amt =0;

  $tr_row ='';
  while ($row = mysql_fetch_assoc($result3)) {
    $amt = getPlanAmt($row['device_amt']);
    $sum_amt += $amt;
    $total = $amt/112.5 * 100;
    $total1 = number_format($total,2, '.', '');
    $tax = $total/100 * 12.5;
    $tax1 = number_format($tax,2, '.', '');

    $tr_row = $tr_row.'<tr>
                        <td width="6%" style="padding: 5px;">'.$sno++.'.<span></span></td>
                        <td width="16%" style="padding: 5px;"><span>'.$row['vehicle_no'].'</span></td>
                        <td width="16%" style="padding: 5px;"><span>'.date("d-m-Y", strtotime($row['activationdate'])).'</span></td>
                        <td width="16%" style="padding: 5px;"><span>'.$total1.'</span></td>
                        <td width="10%" style="padding: 5px;"><span>'.$tax1.'</span></td>
                        <td width="16%" style="padding: 5px;"><span>'.$amt.'</span></td>
                      </tr>';
  }

  $summ_total = $total_amount/112.5 * 100;
  $summ_total1 = number_format($summ_total,2, '.', '');
  $summ_tax = $summ_total/100 * 12.5;
  $summ_tax1 = number_format($summ_tax,2, '.', '');

  $dvTble = "<div id='invoice_content'>
              <center><img src='images/logo.jpg' alt='SRTMS'></center><br>
                <table border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                  <tr>
                    <td width='50%' style='padding:5px;'>
                        <center><strong><span style='font-family: arial, sans-serif; font-weight:bold; font-size:11px;'>Customer Information</span></strong></center>
                    </td>
                    <td width='50%' style='padding:5px;'>
                      <center><strong><span style='font-family: arial, sans-serif; font-weight:bold; font-size:11px;'>Company Information</span></strong></center>
                    </td>
                  </tr>
                  <tr>
                    <td width='50%' style='padding:5px;' valign='top'>
                      <p style='font-size:10px; font-family: arial, sans-serif; line-height:15px;'>
                        <span>    
                          <strong>Customer Id:</strong>$customer_id<br>
                          <strong>Contact Person:</strong>".$contactPersonName. "<br>                         
                          <strong>$companyName</strong>
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
                              <center><strong><span style='font-size:10px; font-weight:bold;'>SR Transport Management Services Pvt. Ltd.</span></strong></center>
                            </td>
                          </tr>
                          <tr>
                            <td><span style='font-size:10px; font-weight:bold;'>Pan Card No. </span></td>
                            <td><span style='font-size:10px;'>AAWCS1335F</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:10px; font-weight:bold;'>Service Tax No.</span></td>
                            <td><span style='font-size:10px;'>AAWCS1335FST001</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:10px; font-weight:bold;'>Vat/CST No.</span></td>
                            <td><span style='font-size:10px;'>Applied for</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:10px; font-weight:bold;'>Bank Name  </span></td>
                            <td><span style='font-size:10px;'>Kotak Mahindra</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:10px; font-weight:bold;'>Account Number  </span></td>
                            <td><span style='font-size:10px;'>0411640116</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:10px; font-weight:bold;'>IFSC Code  </span></td>
                            <td><span style='font-size:10px;'>KKBK0000193</span></td>
                          </tr>
                          <tr>
                            <td><span style='font-size:10px; font-weight:bold;'>Branch </span></td>
                            <td><span style='font-size:10px;'>Sec.- 5, Dwarka, New Delhi</span></td>
                          </tr>
                        </table>                          
                       </td>
                     </tr>
                   </table><br>

                   <table width='100%' border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%; font-size:10px;'>
                    <tr>
                      <td colspan='3' width='100%' style='padding: 5px; font-size: 13px; font-weight: bold; text-align: center;'>
                        ESTIMATE SUMMARY
                      </td>
                    </tr>
                    <tr>
                      <td width='33%' style='padding: 5px;'><span><strong>Estimate No.:</strong> 
                      ".$estimate_id."
                      </span></td>
                      <td width='33%' style='padding: 5px;'><span><strong>Estimate Date:</strong> 
                      ".date("d-m-Y", strtotime($generate_date))."
                      </span></td>
                      <td width='33%' style='padding: 5px;'><span><strong>Due Date:</strong> 
                      ".date("d-m-Y", strtotime($due_date))."
                      </span></td>
                    </tr>
                   </table><br>
                   <table width='100%' border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%; font-size:10px;'>
                    <tr>
                      <td width='15%' style='padding: 5px;'><span><strong>No. of Vehicles</strong></span></td>
                      <td width='15%' style='padding: 5px;'><span><strong>Amount</strong></span></td>
                      <td width='20%' style='padding: 5px;'><span><strong>Tax Amount</strong></span></td>
                      <td width='20%' style='padding: 5px;'><span><strong>Payble Amount</strong></span></td>
                    </tr>
                    <tr>
                      <td width='15%' style='padding: 5px;'>
                        <span> ".$total_vehicle."</span>
                      </td>
                      <td width='15%' style='padding: 5px;'>
                      <span>".$summ_total1."</span>
                      </td>
                      <td width='15%' style='padding: 5px;'>
                      <span>".$summ_tax1."</span>
                      </td>
                      <td width='15%' style='padding: 5px;'>
                        <span>".$total_amount."</span>
                      </td>
                    </tr>
                  </table><br>
                  <table width='100%' border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%; font-size:10px;'>
                    <tr>
                      <td colspan='6' width='100%' style='padding: 5px; font-size: 13px; font-weight: bold; text-align: center;'>
                        ESTIMATE DETAILS
                      </td>
                    </tr>
                    <tr>
                      <td width='4%' style='padding: 5px;'><span><strong>S.No.</strong></span></td>
                      <td width='14%' style='padding: 5px;'><span><strong>Vehicle No.</strong></span></td>
                      <td width='14%' style='padding: 5px;'><span><strong>Activation Date</strong></span></td>
                      <td width='14%' style='padding: 5px;'><span><strong>Device Amount</strong></span></td>
                      <td width='10%' style='padding: 5px;'><span><strong>Tax</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span><strong>Payble Amount</strong> </span></td>
                    </tr>".$tr_row."
                    <tr>
                      <td colspan='5' style='padding: 5px;'>
                        <center><strong>Total Due Amount</strong></center>
                      </td>
                      <td style='padding: 5px;'>
                        <strong>".$sum_amt."
                        </strong>
                      </td>
                    </tr>
                  </table>
                  <p style='font-family: arial, sans-serif; font-size:10px;'><strong>* This is an electronically generated statements and does not require any signature</strong></p>
                  <hr>
                  <center>
                    <p style='font-family: arial, sans-serif; font-size:10px;'><strong>Office Address:</strong> Plot No.- 610, Second Floor, Kakrola Housing Complex, Opp. Metro Pillor No.- 805, New Delhi - 110043<br>
                    <strong>Contact No.:</strong> 9015222422/7042198790 <br>
                    <strong>Email:</strong> <a href='mailto:accounts@srtms.in?Subject=Estimate' target='_top'>accounts@srtms.in</a>
                    </p>
                  </center>
             </div>";


  // echo $dvTble; 
  // exit();
  $dompdf = new Dompdf();
  $dompdf->load_html($dvTble);
  $dompdf->setPaper('A4', 'portrait');
  // Render the HTML as PDF
  $dompdf->render();
  // Output the generated PDF to Browser
  $dompdf->stream($companyName);
}
 
?>