<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$product=$_REQUEST['branch'];
error_reporting(0);
	$linkSQL = "SELECT id,rqsttype FROM tblrqsttype WHERE product_id='$product'";
	echo $linkSQL;
 	$result=mysql_query($query);
?>	
<select name="request">
<option>Select Request Type</option>
<?php while ($row=mysql_fetch_array($result)) { ?>
<option value=<?php echo $row['id']?>><?php echo $row['rqsttype']?></option>
<?php } ?>
</select>
	
	