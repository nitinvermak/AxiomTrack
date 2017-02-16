<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$searchText = $_REQUEST['organization']; 
/*echo $searchText;*/
error_reporting(0);

	$linkSQL = "SELECT * FROM tblcallingdata as A 
				Inner Join tbl_customer_master as B On A.id = B.callingdata_id 
				WHERE A.Company_Name = '$searchText' ";
				/*echo "cmd" . $linkSQL;*/
	$stockArr = mysql_query($linkSQL);
	$result = mysql_fetch_assoc($stockArr);
?>	
<form name="contact" method="post" onSubmit="return chkcontactform(this)">
<input type="hidden" name="submitForm" value="yes" />
<input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
<table class="table">
<tr>
<td>Telecaller Name*</td>
<td  valign="top" width="37%">
	<select name="telecaller" id="telecaller" class="form-control text_box" disabled>
		<?php $Country=mysql_query("select * from tbluser");
              while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['telecaller_id']){ ?>selected<?php } ?>><?php echo gettelecallername(stripslashes(ucfirst($resultCountry['id']))); ?></option>
            <?php } ?>    
    </select>
</td>
<td>Data Source*</td>
<td><input type="text" name="datasource" id="datasource" class="form-control text_box"  value="<?php if(isset($result['id'])) echo $result['data_source']; ?>" disabled /></td>
</tr>
<tr>
<td>Device Amt.*</td>
<td  valign="top">
	<select name="deviceAmt" id="deviceAmt" class="form-control drop_down" disabled>
    	<option value="">Device Amount</option>
        <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 1 order by plan_rate");
                          while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_amt']) && $resultCountry['id']==$result['np_device_amt']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
        <?php } ?>
        </select>          
</td>
<td>Rent Amt.</td>
<td>
	<select name="deviceRent" id="deviceRent" class="form-control drop_down" disabled >
    	<option value="">Device Rent</option>
		<?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 2 order by plan_rate");						
              while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['np_device_rent']) && $resultCountry['id']==$result['np_device_rent']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?></option>
                    <?php } ?>
    </select>        
</td>
</tr>
<tr>
<td>Installation Charges</td>
<td  valign="top">
	<select name="installationChrg" id="installationChrg" class="form-control drop_down" disabled >
    	<option value="">Installation Charges</option>
        <?php $Country=mysql_query("select * from tblplan where productCategoryId = 4 and planSubCategory = 3 order by plan_rate");
              while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['r_installation_charge']) && $resultCountry['id']==$result['r_installation_charge']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plan_rate'])); ?>
        </option>
        <?php } ?>
     </select>          
</td>
<td>Rent Frq.</td>
<td>
	<select name="rentFrq" id="rentFrq" class="form-control drop_down" disabled >
    	<option value="">Rent Frequency</option>
        <?php $Country=mysql_query("select * from tbl_frequency");						
              while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
        <option value="<?php echo $resultCountry['FrqId']; ?>" 
		<?php if(isset($result['rent_payment_mode']) && $resultCountry['FrqId']==$result['rent_payment_mode']){ ?>
        selected<?php } ?>>
		<?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
        <?php } ?>
     </select>          
</td>
</tr>
<tr>
<td>Customer Type</td>
<td  valign="top">
<select name="customerType" id="customerType" class="form-control drop_down" onChange="customerType()" disabled>
	<option value="">Select</option>
    <?php $Country=mysql_query("select * from tbl_customer_type");
    	  while($resultCountry=mysql_fetch_assoc($Country)){
    ?>
    <option value="<?php echo $resultCountry['customer_type_id']; ?>" 
	<?php if(isset($result['customer_type']) && $resultCountry['customer_type_id']==$result['customer_type']){ ?>
    selected<?php } ?>>
	<?php echo stripslashes(ucfirst($resultCountry['customer_type'])); ?>
    </option>
    <?php } ?>
    </select>        
</td>
<td>Calling Date*</td>
<td><input name="callingdate" id="callingdate" class="form-control text_box" type="text" value="<?php if(isset($result['id'])) echo $result['confirmation_date']; ?>" disabled /></td>
</tr>
<tr>
<td><input type="button" class="btn btn-primary btn-sm" value="Back" onClick="window.location='customer_type.php?token=<?php echo $token ?>'" ></td>
<td  valign="top"></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</form>