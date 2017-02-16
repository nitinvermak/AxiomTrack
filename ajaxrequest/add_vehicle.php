<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = $_REQUEST['cust_id']; 
/*echo $searchText;*/
error_reporting(0);
if ($cust_id == '')
	{
	$linkSQL = "Please Provide Search Criteria";
	}
		else if($cust_id !== '')
			{
				$linkSQL = "SELECT A.cust_id, A.customer_type, A.np_device_amt, A.np_device_rent, 
							      A.installment_amt, A.r_installation_charge, A.no_of_installment, 
							      A.rent_payment_mode, B.vehicle_no, B.id, B.installation_date, 
							      B.model_name, B.paymentActiveFlag, B.device_id as deviceId 
							      FROM tbl_customer_master as A
							      INNER JOIN tbl_gps_vehicle_master as B 
							      ON A.cust_id = B.Customer_id 
							      WHERE A.cust_id = '$cust_id' 
                    and B.paymentActiveFlag='N'
                    and B.activeStatus = 'Y'
							      order by B.vehicle_no";
				/*echo "cmd" . $linkSQL;*/
			}
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{	
    echo "<div class='col-md-12' id='div_Show'></div>";
	 	echo '<table width="500px" class="table table-hover table-bordered ">';
?>	
			 
             <tr>
             <th><small>S. No.</small></th>  
          	 <th><small>Vehicle No.</small></th> 
          	 <th><small>Date of Instl.</small></th>
             <th><small>Dealer Name</small></th>
             <th><small>Model</small></th>  
          	 <th><small>Device Type</small></th>
             <th><small>Device Amt.</small></th>
             <th><small>Rent Amt.</small></th>
             <th><small>Rent Frq.</small></th>
             <th><small>Inst. Charges</small></th>
             <th><small>Down Payment Amt</small></th>
             <th><small>No of Installment</small></th>
             <th><small>Installment Amount</small></th>
             <th><small>Action</small></th>
             </tr>
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 	?>
             
        	<tr <?php print $class?>  id='<?php echo stripslashes($row["id"]);?>'>
      		<td><small><?php print $kolor++;?>.</small></td>
	  		<td><small><?php echo stripslashes($row["vehicle_no"]);?> 
            <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo stripslashes($row["id"]);?>">
            <input type="hidden" name="custid" id="custid" value="<?php echo stripslashes($row["cust_id"]);?>">
            </small>
            </td>
	  		<td><small><?php echo stripslashes($row["installation_date"]);?> <input type="hidden" name="installation_date" id="installation_date" value="<?php echo stripslashes($row["installation_date"]);?>"></small></td>
            <td><small><?php echo getDealer1($row['deviceId']); ?></small></td>
	  		<td><small><?php echo stripslashes($row["model_name"]);?> <input type="hidden" name="model_name" id="model_name" value="<?php echo stripslashes($row["model_name"]);?>"></small></td>
	  		<td>               
                <select name="device_type" id="device_type" class="device_type" style="width:140px;">
                    <option value="X_"   >Device Type</option>
                    <?php $Country=mysql_query("select * from tbl_device_type order by DeviceType");
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['DeviceTypeId']; ?>" 
					<?php if(isset($row['customer_type']) && $resultCountry['DeviceTypeId']==$row['customer_type']){
					 ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['DeviceType'])); ?></option>
                    <?php } ?>
          	    </select>  
                <?php ?>
            </td>
            <td>
            	<select name="device_amt" id="device_amt" class="device_amt"  style="width:50px;" >
                    <option value="X_">Select</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 1 order by plan_rate");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                  	  <option value="<?php echo $resultCountry['id']."@".$resultCountry['plan_rate']; ?>" <?php if(isset($row['np_device_amt']) && $resultCountry['id']==$row['np_device_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                <?php } ?>
        		 </select>
                 
                
            </td>
        	<td>
            	<select name="device_rent" id="device_rent" class="device_rent" style="width:50px;" >
                    <option value="X_">Select</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 2 order by plan_rate");						
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($row['np_device_rent']) && $resultCountry['id']==$row['np_device_rent']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
    			</select>
                
    		</td>
            <td>
                 <select name="rent_frq" id="rent_frq" class="rent_frq"  style="width:100px;" >
                    <option value="X_">Payment Type</option>
                    <?php $Country=mysql_query("select * from tbl_frequency");						
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($row['rent_payment_mode']) && $resultCountry['FrqId']==$row['rent_payment_mode']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
                    <?php } ?>
                 </select>
                 
            </td>
            <td>
            	<select name="installation_charges" id="installation_charges" class="installation_charges" style="width:50px;" >
                   <option value="X_">Select</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 3 order by plan_rate");
					
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($row['r_installation_charge']) && $resultCountry['id']==$row['r_installation_charge']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
        	  </select>
              
        	 </td>
              <td>
                  <input name="downpayment" id="downpayment" class="downpayment" style="width:50px;" 
                  value="<?php echo stripcslashes(ucfirst($row['downpaymentAmount']));?>"
                    
                   <?php if($row['customer_type'] !=4 ) { echo 'disabled="disabled"'; } ?>
                  / >
 
         
                
        	 </td>
              <td><input type="text" name="NoOfInstallation" id="NoOfInstallation<?php echo stripslashes($row["id"]);?>" class="NoOfInstallation" onchange="calTotal(<?php echo stripslashes($row["id"]);?>);"
                   value="<?php echo stripcslashes(ucfirst($row['no_of_installment']));?>"  style="width:30px;" 
                   <?php if($row['customer_type'] !=4 ) { echo 'disabled="disabled"'; } ?>
                   />
              </td>
              <td><input type="text" name="installationAmount" id="installationAmount<?php echo stripslashes($row["id"]);?>" class="NoOfInstallation" 
                   value=""  readonly style="width:50px;" 
                  />
              </td>
          
          
        <td><input type="button" name="Save" id="Save" value="Save" onclick="get_Value(<?php echo stripslashes($row["id"]);?>);"></td>
      	</tr>
        
        
	<?php 
	      }
		  
 
	}
    else
   		 echo "<h3 style='color:red;'>No records found!</h3>";
	?> 
          			
                