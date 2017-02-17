<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$technician=$_REQUEST['technician'];
error_reporting(0);
$linkSQL = "SELECT * FROM tblsim as A, 
			tbl_sim_technician_assign as B
			WHERE A.id = B.sim_id and A.status_id='0' and B.technician_id='$technician'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
?>		

            <select name="mobile_no" id="mobile_no" class="form-control select2" style="width: 100%">
            <option value="">Select Mobile</option>
            <?php while ($row = mysql_fetch_array($stockArr)) { ?>
            <option value="<?php echo $row['id']; ?>"><?php echo stripslashes(ucfirst($row['mobile_no'])); ?></option>
            <?php 	} ?>
            </select>
            
            

<?php } ?> 