<?php 
include("../includes/config.inc.php"); 
$olddeviceId = mysql_real_escape_string($_POST['olddeviceId']);
/*echo $olddeviceId.'lasfsa';*/
?>	
<div class='form-group'>
	<label for='mobile'>Old Modal <span class='red'>*</span></label>
    <select name='oldModal' id='oldModal' class='form-control drop_down'>
    	<?php 
		$technician = mysql_query("SELECT B.device_id as modalId, 
								  B.model_name as ModalName 
								  FROM tbl_device_master as A 
								  INNER JOIN tbldevicemodel as B 
								  ON A.device_name = B.device_id 
								  WHERE A.id = '$olddeviceId'");	
		while($resulttechnician=mysql_fetch_assoc($technician)){
		?>
		<option value="<?php echo $resulttechnician['modalId']; ?>">
		<?php echo stripslashes(ucfirst($resulttechnician['ModalName']));?>
		</option>
		<?php } ?>
    </select> 
</div>