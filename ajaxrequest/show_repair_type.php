<?php 
include("../includes/config.inc.php"); 
$repairType = mysql_real_escape_string($_POST['repairType']);
$technician = mysql_real_escape_string($_POST['technician']);
/*echo $technician.'lasfsa';*/
if($repairType == 1)
{
?>	<div class='form-group'>
                    <label for='mobile' class='col-sm-2 control-label'>New Mobile <span class='red'>*</span></label>
                  <div class='col-sm-10'>
                    <select name='mobileNo' id='mobileNo' class='form-control drop_down'>
                        <option value=''>Select Mobile</option>
                         <?php 
							$technician = mysql_query("SELECT * FROM tblsim as A, 
													   tbl_sim_technician_assign as B
													   WHERE A.id = B.sim_id and A.status_id='0' 
													   and B.technician_id= '$technician'");	
							while($resulttechnician=mysql_fetch_assoc($technician)){
						 ?>
						 <option value="<?php echo $resulttechnician['id']; ?>">
						 <?php echo stripslashes(ucfirst($resulttechnician['mobile_no']));?>
						 </option>
						 <?php } ?>
                    </select> 
                  </div>
          </div>
<?php        
}
else if($repairType == 2)
{
?> 		
		<div class='form-group'>
                    <label for='deviceId' class='col-sm-2 control-label'>New DeviceId <span class='red'>*</span></label>
                  <div class='col-sm-10'>
                    <select name='deviceId' id='deviceId' class='form-control drop_down'>
                        <option value=''>Select DeviceId</option>
                        
                         <?php 
							$technician = mysql_query("select * from tbl_device_master as A, 
													   tbl_device_assign_technician as B 
 													   WHERE A.id = B.device_id and A.status='0'
													   AND B.technician_id='$technician'");	
							while($resulttechnician=mysql_fetch_assoc($technician)){
						 ?>
						 <option value="<?php echo $resulttechnician['id']; ?>">
						 <?php echo stripslashes(ucfirst($resulttechnician['device_id']));?>
						 </option>
						 <?php } ?>
                    </select> 
                  </div>
          </div>
<?php
}
else if($repairType == 3)
{
?>
		<div class='form-group'>
                    <label for='mobile' class='col-sm-2 control-label'>New Mobile <span class='red'>*</span></label>
                  <div class='col-sm-10'>
                    <select name='mobileNo' id='mobileNo' class='form-control drop_down'>
                        <option value=''>Select Mobile</option>
                         <?php 
							$technician = mysql_query("SELECT * FROM tblsim as A, 
													   tbl_sim_technician_assign as B
													   WHERE A.id = B.sim_id and A.status_id='0' 
													   and B.technician_id= '$technician'");	
							while($resulttechnician=mysql_fetch_assoc($technician)){
						 ?>
						 <option value="<?php echo $resulttechnician['id']; ?>">
						 <?php echo stripslashes(ucfirst($resulttechnician['mobile_no']));?>
						 </option>
						 <?php } ?>
                    </select> 
                  </div>
          </div>
		  
		  <div class='form-group'>
                    <label for='deviceId' class='col-sm-2 control-label'>New DeviceId <span class='red'>*</span></label>
                  <div class='col-sm-10'>
                    <select name='deviceId' id='deviceId' class='form-control drop_down'>
                        <option value=''>Select DeviceId</option>
                        
                         <?php 
							$technician = mysql_query("select * from tbl_device_master as A, 
													   tbl_device_assign_technician as B 
 													   WHERE A.id = B.device_id and A.status='0'
													   AND B.technician_id='$technician'");	
							while($resulttechnician=mysql_fetch_assoc($technician)){
						 ?>
						 <option value="<?php echo $resulttechnician['id']; ?>">
						 <?php echo stripslashes(ucfirst($resulttechnician['device_id']));?>
						 </option>
						 <?php } ?>
                    </select> 
                  </div>
          </div>
<?php
}
?>
