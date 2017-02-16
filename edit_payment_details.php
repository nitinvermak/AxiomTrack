<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = $_REQUEST['cust_id']; 

/*echo $searchText;*/
error_reporting(0);
$linkSQL = "SELECT * FROM tbl_customer_master as A 
			INNER JOIN tbl_gps_vehicle_master as B 
			on A.cust_id = B.customer_Id
			INNER JOIN tbl_gps_vehicle_payment_master as C 
			ON B.id = C.Vehicle_id
			WHERE A.cust_id = '$cust_id'
			and C.PlanactiveFlag = 'Y'
			order by B.vehicle_no";
echo "cmd" . $linkSQL;

$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{	
	 	echo '<table width="500px" class="table table-hover table-bordered ">';
?>	
			 
             <tr>
             <th><small>S. No.</small></th> 
             <th><small>Vehicle No.</small></th> 
             <th><small>Dealer Name</small></th> 
             <th><small>Device Type</small></th>
             <th><small>Device Amt.</small></th>
             <th><small>Rent Amt.</small></th>
             <th><small>Rent Frq.</small></th>
             <th><small>Inst. Charges</small></th>
             <th><small>Down Payment Amt</small></th>
             <th><small>No of Installment</small></th> 
             <th><small>Start Date</small></th>
             <th><small>End Date</small></th>
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
            <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo stripslashes($row["Vehicle_id"]);?>">
            <input type="hidden" name="custid" id="custid" value="<?php echo stripslashes($row["cust_id"]);?>">
            </small>
            </td>
            <td><small><?php echo getDealer(stripslashes($row["device_id"]));?> </small></td>
	  		<td>
            <select name="device_type" id="device_type" class="device_type" style="width:50px;">
                    <option value="X_">Device Type</option>
                    <?php $Country=mysql_query("select * from tbl_device_type");
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['DeviceTypeId']; ?>" <?php if(isset($row['device_type']) && $resultCountry['DeviceTypeId']==$row['device_type']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['DeviceType'])); ?></option>
                    <?php } ?>
          	    </select>
           </td>
	  		<td>
            <select name="device_amt" id="device_amt" class="device_amt" >
                    <option value="X_">Select</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 1");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                  	  <option value="<?php echo $resultCountry['id']; ?>" <?php if( $resultCountry['id']==$row['device_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                <?php } ?>
        	</select>
            <small><input type="hidden" name="model_name" id="model_name" value="<?php echo stripslashes($row["model_name"]);?>"></small></td>
	  		<td>               
              <select name="device_rent" id="device_rent">
                    <option value="X_">Select</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 2");						
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if($resultCountry['id']==$row['device_rent_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
    			</select> 
                
            </td>
            <td>
            	<select name="rent_frq" id="rent_frq"  style="width:50px;">
                    <option value="X_">Payment Type</option>
                    <?php $Country=mysql_query("select * from tbl_frequency");						
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['FrqId']; ?>" <?php if( $resultCountry['FrqId']==$row['RentalFrequencyId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
                    <?php } ?>
                 </select>
            </td>
        	<td>
            	<select name="installation_charges" id="installation_charges">
                   <option value="X_">Select</option>
                    <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 3");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                <option value="<?php echo $resultCountry['id']; ?>" <?php if($resultCountry['id']==$row['installation_charges']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
        	  </select>                
    		</td>
            <td>
                  <input name="downpayment" id="downpayment" class="downpayment" style="width:50px;" 
                  value="<?php echo stripcslashes(ucfirst($row['downpaymentAmount']));?>"
                    
                   <?php if($row['customer_type'] !=4 ) { echo 'disabled="disabled"'; } ?>
                 / >
                       
        	 </td> 
            
            <td>
            <input type="text" name="NoOfInstallation" id="NoOfInstallation"
             value="<?php echo stripcslashes(ucfirst($row['NoOfInstallment']));?>"  style="width:50px;"
              <?php if($row['customer_type'] !=4 ) { echo 'disabled="disabled"'; } ?>
             />
        	 </td>
             
             
 
              <td><small><?php echo stripslashes($row["PlanStartDate"]);?> 
              	<input type="hidden" name="installation_date" id="installation_date" value="<?php echo stripslashes($row["installation_date"]);?>">
              </small></td>
              <td><small><?php echo stripslashes($row["PlanendDate"]);?> 
              <input type="hidden" name="plan_end" id="plan_end" value="<?php echo stripslashes($row["PlanendDate"]);?>">
              </small></td>
        <td><input type="button" name="Save" id="Save" value="Save" onclick="getValueHistoryPage(<?php echo stripslashes($row["id"]);?>);"></td>
      	</tr>
        
        </div>
	<?php 
	      }
	}
    else
	{
   		 echo "<h3 style='color:red;'>No Plan found!</h3>";
	}
	?> 
          			
                