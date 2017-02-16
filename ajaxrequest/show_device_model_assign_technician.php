<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$device=$_REQUEST['device'];
error_reporting(0);
$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_technician as B
WHERE A.id = B.device_id AND A.status='0' AND B.device_id='$device'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
?>		
<select name="dmodel" id="dmodel" class="form-control" style="width: 100%">
	<?php while ($row = mysql_fetch_array($stockArr)) { ?>
    <option value="<?php echo  getdevicename($row['device_name']); ?>">
    <?php echo getdevicename(stripslashes(ucfirst($row['device_name']))); ?>
    </option>
    <?php 	} ?>
</select>
<?php } ?> 
                         
 