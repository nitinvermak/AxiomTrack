<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$newClient = mysql_real_escape_string($_POST['newClient']);

error_reporting(0);
?>
<select name="orgranization" id="orgranization" class="form-control drop_down select2" style="width: 100%">
	<option value="">Select Orgranization</option>                         
    <?php $Country=mysql_query("SELECT * FROM tblcallingdata where status='0' ORDER BY Company_Name ASC");								
          while($resultCountry=mysql_fetch_assoc($Country))
               {
    ?>
    <option value="<?php echo $resultCountry['id']; ?>" 
    <?php if(isset( $_SESSION['organization']) && $resultCountry['id']== $_SESSION['organization']){ ?>selected			    <?php } ?>>
    <?php echo getOraganization(stripslashes(ucfirst($resultCountry['id']))); ?></option>
    <?php } ?>
</select>
