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
				$linkSQL = "SELECT * FROM tbl_customer_master as A 
						    INNER JOIN tbl_gps_vehicle_master as B 
						    on A.cust_id = B.customer_Id
						    INNER JOIN tbl_gps_vehicle_payment_master as C 
						    ON B.id = C.Vehicle_id
						    WHERE A.cust_id = '$cust_id'";
				/*echo "cmd" . $linkSQL;*/
			}
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{	
	 	echo '<table width="500px" class="table table-hover table-bordered ">';
?>	
			 
             <tr>
             <th><small>S. No.</small></th> 
             <th><small>Vehicle No.</small></th>  
             <th><small>Device Type</small></th>
             <th><small>Device Amt.</small></th>
             <th><small>Rent Amt.</small></th>
             <th><small>Rent Frq.</small></th>
             <th><small>Inst. Charges</small></th>
             <th><small>Installment Amt</small></th>
             <th><small>No of Installment</small></th>
             <th><small>Inst. Frq.</small></th>
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
	  		<td>
            <select name="device_type" id="device_type" style="width:50px;">
                    <option value="">Device Type</option>
                    <?php $Country=mysql_query("select * from tbl_device_type");
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['DeviceTypeId']; ?>" <?php if(isset($row['device_type']) && $resultCountry['DeviceTypeId']==$row['device_type']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['DeviceType'])); ?></option>
                    <?php } ?>
          	    </select>
           </td>
	  		<td>
            <select name="device_amt" id="device_amt" >
                    <option value="">Select</option>
                    <?php $Country=mysql_query("select * from tblplan");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                  	  <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($row['device_amt']) && $resultCountry['id']==$row['device_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                <?php } ?>
        	</select>
            <small><input type="hidden" name="model_name" id="model_name" value="<?php echo stripslashes($row["model_name"]);?>"></small></td>
	  		<td>               
              <select name="device_rent" id="device_rent">
                    <option value="">Select</option>
                    <?php $Country=mysql_query("select * from tblplan where plan_category = 4 and plan_description='Rental'");						
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($row['device_rent_amt']) && $resultCountry['id']==$row['device_rent_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
    			</select> 
                
            </td>
            <td>
            	<select name="rent_frq" id="rent_frq"  style="width:50px;">
                    <option value="">Payment Type</option>
                    <?php $Country=mysql_query("select * from tbl_frequency");						
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($row['RentalFrequencyId']) && $resultCountry['FrqId']==$row['RentalFrequencyId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
                    <?php } ?>
                 </select>
            </td>
        	<td>
            	<select name="installation_charges" id="installation_charges">
                   <option value="">Select</option>
                    <?php $Country=mysql_query("select * from tblplan where plan_category = 4 and plan_description='Installtion_Charges'");
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($row['r_installation_charge']) && $resultCountry['id']==$row['r_installation_charge']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
        	  </select>                
    		</td>
            <td>
                <select name="instalment" id="instalment">
                       <option value="">Select</option>
                        <?php $Country=mysql_query("select * from tblplan where plan_category = 4 and plan_description='Installment'");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                    <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['InstallmentamountID']) && $resultCountry['id']==$result['InstallmentamountID']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                        <?php } ?>
                 </select>                 
            </td>
            <td>
            <input type="text" name="NoOfInstallation" id="NoOfInstallation" value="<?php echo stripcslashes(ucfirst($row['NoOfInstallment']));?>"  style="width:50px;"/>
        	 </td>
              <td>
                <select name="instalment_frq" id="instalment_frq"  style="width:50px;">
                    <option value="">Payment Type</option>
                    <?php $Country=mysql_query("select * from tbl_frequency");						
                                   while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($row['InstFrequencyID']) && $resultCountry['FrqId']==$row['InstFrequencyID']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
                    <?php } ?>
        		</select>  
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
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br><br></td><tr/></table>";
	?> 
          			
                