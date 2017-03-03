<?php
include("includes/config.inc.php"); 
// include autoloader
require_once 'dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

// Post Form Data 
if (isset($_POST['generatePDF'])) {
    
  $planRateQuery= "Select id, planSubCategory, plan_rate 
                  from tblplan 
                  where productCategoryId = 4  
                  and (planSubCategory = 1 
                  or planSubCategory = 2 
                  or planSubCategory = 3)";
  $planRateQueryArr = mysql_query($planRateQuery);
  $deviceAmountDict = array();
  $deviceRentAmtDict = array();
  $installationChargesDict = array();
  $typeBAmountEntry =0;
  while ($rowA = mysql_fetch_array( $planRateQueryArr)){
    //echo $rowA["plan_category"].'='.$rowA["id"].'='.$rowA["plan_rate"].'</br>';
    if ($rowA["planSubCategory"] == 1){
      $deviceAmountDict[$rowA["id"] ] =$rowA["plan_rate"];
    }
    if ($rowA["planSubCategory"] == 2){
      $deviceRentAmtDict[$rowA["id"] ] =$rowA["plan_rate"];
    }
    if ($rowA["planSubCategory"] == 3){
      $installationChargesDict[$rowA["id"] ] =$rowA["plan_rate"];
    }              
  }

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
  //-------------- loop for printing vehicle details
  $vehicle_detail_string = '';
  while ($row = mysql_fetch_assoc($result_invoice_details)) {

	  $amt = $row['amt'];
	  $sum_amt += $amt;
    $total = $row['amt']/115 * 100;
    $total_amt = number_format($total,2, '.', '');

    $tax = $total/100 * 15;
    $tax_amt = number_format($tax,2, '.', '');

	 $vehicle_detail_string = $vehicle_detail_string."<tr>
                                <td width='2%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'>".$sno++.".</span></td>
                                <td width='14%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'>".$row['vehicleNo']." 
                                  </span></td>
                                <td width='22%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'>".
                                  date("d-m-Y", strtotime($row['startDate']))." To ". date("d-m-Y", strtotime($row['endDate']))."
                                  
                                </span></td>
                                <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'>". 
                                  $deviceRentAmtDict[$row['plan_rate_id']]."
                                </span></td>
                                <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'>
                                  ".$total_amt                              
                                  ."
                                </span></td>
                                <td width='10%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'>
                                  ".$tax_amt."
                                
                                </span></td>
                                <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'>". $amt."
                                
                                </span></td>
                              </tr>";

			   
  }
  // echo $vehicle_detail_string;
  // exit();
  //---------------
  $summ_total = $grand_total/115 * 100;
  $summ_total1 = number_format($summ_total,2, '.', '');
  $summ_tax = $summ_total/100 * 15;
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
                          <strong>Customer Id:</strong>$customer_Id<br>
                          <strong>Contact Person:</strong>". getCustomerName($customer_Id). "<br>                         
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

                   <table border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                      <td colspan='3' width='100%' style='padding: 5px;'>
                        <center><span style='font-size:10px; font-weight:bold; font-family: arial, sans-serif;'>ESTIMATE SUMMARY</span></center>
                      </td>
                    </tr>
                    <tr>
                      <td width='33%' style='padding: 5px;'>
                        <span style='font-size:10px; font-family: arial, sans-serif;'>
                          <strong>Estimate No.:</strong>  
                          $invoice_No
                        </span>
                      </td>
                      <td width='33%' style='padding: 5px;'>
                        <span style='font-size:10px; font-family: arial, sans-serif;'>
                          <strong>Estimate Date:</strong> ". date("d-m-Y", strtotime($generateDate))."
                        </span>
                      </td>
                      <td width='33%' style='padding: 5px;'>
                        <span style='font-size:10px; font-family: arial, sans-serif;'>
                          <strong>Due Date:</strong>". date("d-m-Y", strtotime($dueDate))."
                        </span>
                      </td>
                    </tr>
                   </table><br>
                   <table border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                      <td width='15%' style='padding: 5px;'>
                        <span style='font-size:10px; font-family: arial, sans-serif;'><strong>No. of Vehicles</strong></span>
                      </td>
                      <td width='30%' style='padding: 5px;'>
                        <span style='font-size:10px; font-family: arial, sans-serif;'><strong>Rent Period</strong></span></td>
                      <td width='15%' style='padding: 5px;'>
                        <span style='font-size:10px; font-family: arial, sans-serif;'><strong>Amount</strong></span></td>
                      <td width='20%' style='padding: 5px;'>
                        <span style='font-size:10px; font-family: arial, sans-serif;'><strong>Tax Amount</strong></span></td>
                      <td width='20%' style='padding: 5px;'>
                        <span style='font-size:10px; font-family: arial, sans-serif;'><strong>Payble Amount</strong></span></td>
                    </tr>
                    <tr>
                      <td width='15%' style='padding: 5px;'><span style='font-size:10px; font-family: arial, sans-serif;'>". $total_vehicle."</span></td>
                      <td  width='30%' style='padding: 5px;'><span style='font-size:10px; font-family: arial, sans-serif;'>". date("d-m-Y", strtotime($from))." To ". date("d-m-Y", strtotime($to)) ."</span></td>
                      
                      <td  width='15%' style='padding: 5px;'><span style='font-size:10px; font-family: arial, sans-serif;'>".$summ_total1."</span></td>
                      <td  width='20%' style='padding: 5px;'><span style='font-size:10px; font-family: arial, sans-serif;'>".$summ_tax1."</span></td>
                      <td  width='20%' style='padding: 5px;'><span style='font-size:10px; font-family: arial, sans-serif;'>".$grand_total."</span></td>
                    </tr>

                   </table><br>
                   <table border='1' style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                      <td colspan='7' width='100%' style='padding: 5px;'>
                        <center>
                          <span style='font-family: arial, sans-serif; font-size:10px; font-weight:bold;'>ESTIMATE DETAILS</span>
                        </center>
                      </td>
                    </tr>
                    <tr>
                      <td width='6%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'><strong>S.No.</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'><strong>Vehicle No.</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'><strong>Rent Period</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'><strong>Rent Per Vehicle</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'><strong>Total Amount</strong></span></td>
                      <td width='10%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'><strong>Tax</strong></span></td>
                      <td width='16%' style='padding: 5px;'><span style='font-family: arial, sans-serif; font-size:10px'><strong>Payble Amount</strong> </span></td>
                    </tr>".$vehicle_detail_string."       
                    
                       <tr>
                      <td colspan='6' style='padding: 5px;'>
                        <center>
                          <strong>
                          <span style='font-family: arial, sans-serif; font-size:10px'>
                            Total Due Amount
                          </span>
                          </strong>
                        </center>
                      </td>
                      <td  style='padding: 5px;'>
                        <span style='font-family: arial, sans-serif; font-size:10px'><strong>$sum_amt
                        </strong></span>
                      </td>
                    </tr>
                  </table><br>
                  <p style='font-family: arial, sans-serif; font-size:10px'><strong>* This is an electronically generated statements and does not require any signature</strong></p>
                  <hr>
                  <center>
                    <p style='font-family: arial, sans-serif; font-size:10px'><strong>Office Address:</strong> Plot No.- 610, Second Floor, Kakrola Housing Complex, Opp. Metro Pillor No.- 805, New Delhi - 110043<br>
                    <strong>Contact No.:</strong> 9015222422/7042198790 <br>
                    <strong>Email:</strong> <a href='mailto:accounts@srtms.in?Subject=Estimate' target='_top'>accounts@srtms.in</a>
                    </p>
                  </center>
                 </div>";
  // echo $dvTble;
  // exit();
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