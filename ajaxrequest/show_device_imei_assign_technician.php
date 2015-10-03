<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$device=$_REQUEST['device'];
error_reporting(0);
$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_technician as B
WHERE A.id = B.device_id AND B.device_id ='$device'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
?>		

           <select name="imei" id="imei" class="form-control drop_down">
         	<?php while ($row = mysql_fetch_array($stockArr)) { ?>
            <option value="<?php echo $row['imei_no']; ?>"><?php echo stripslashes(ucfirst($row['imei_no'])); ?></option>
            <?php 	} ?>
            </select>
            
            

<?php } ?> 
                         
 