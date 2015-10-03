<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$technician=$_REQUEST['technician'];
error_reporting(0);
$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_technician as B 
WHERE A.id = B.device_id and A.status='0'AND B.technician_id='$technician'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
?>		

            <select name="device" id="device" onchange="return ShowIMEIandDeviceName();" class="form-control drop_down">
            <option value="">Select Device</option>
            <?php while ($row = mysql_fetch_array($stockArr)) { ?>
            <option value="<?php echo $row['id']; ?>"><?php echo stripslashes(ucfirst($row['device_id'])); ?></option>
            <?php 	} ?>
            </select>
            
            

<?php } ?> 
                         
 