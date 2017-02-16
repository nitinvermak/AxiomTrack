<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$custId = $_REQUEST['companyName'];
error_reporting(0);

$branchArr=mysql_query("SELECT `cust_id`,`callingdata_id` FROM tbl_customer_master WHERE `callingdata_id`=".$custId);
?>
	<select name="customerId" id="customerId" class="form-control drop_down"  onchange="return CallDistrict(this.value)">
    	<?php 
		// error_reporting(-1);
		if(mysql_num_rows($branchArr)>0){ 
		   while($resultBranch=mysql_fetch_assoc($branchArr)){
		?>
    <option value="<?php echo $resultBranch['cust_id']; ?>"><?php echo $resultBranch['cust_id']; ?></option>
<?php } 
}?>
	</select>
    
    
