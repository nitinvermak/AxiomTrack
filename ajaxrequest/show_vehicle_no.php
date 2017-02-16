<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$orgranization = mysql_real_escape_string($_POST['orgranization']);
 
$query="SELECT B.id as id, B.vehicle_no as vehicle_no 
		from tbl_customer_master as A 
		INNER JOIN  tbl_gps_vehicle_master as B 
		ON A.cust_id = B.customer_Id 
		where A.callingdata_id = '$orgranization'";
/*echo $query;*/
$result=mysql_query($query);

?>
<select name="vehicle" id="vehicle" class="form-control drop_down">
    <option>Select Vehicle No.</option>
    <?php while ($row=mysql_fetch_array($result)) { ?>
    <option value=<?php echo $row['id']?>><?php echo $row['vehicle_no']?></option>
    <?php } ?>
</select>
