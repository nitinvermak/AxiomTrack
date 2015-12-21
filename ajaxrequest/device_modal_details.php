<?php 
include("../includes/config.inc.php"); 
$deviceId = mysql_real_escape_string($_POST['deviceId']);
?>	<div class='form-group'>
                    <label for='mobile' class='col-sm-2 control-label'>New Modal <span class='red'>*</span></label>
                  <div class='col-sm-10'>
                    <select name='newModal' id='newModal' class='form-control drop_down'>
                         <?php 
							$modal = mysql_query("SELECT B.device_id as modalId, 
													   B.model_name as ModalName 
													   FROM tbl_device_master as A 
													   INNER JOIN tbldevicemodel as B 
													   ON A.device_name = B.device_id 
													   WHERE A.id = '$deviceId'");

							while($resultModal=mysql_fetch_assoc($modal)){
						 ?>
						 <option value="<?php echo $resultModal['modalId']; ?>">
						 <?php echo stripslashes(ucfirst($resultModal['ModalName']));?>
						 </option>
						 <?php } ?>
                    </select> 
                  </div>
     </div>