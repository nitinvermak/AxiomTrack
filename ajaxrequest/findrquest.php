<?php
include("../includes/config.inc.php"); 
//include("../includes/crosssite.inc.php"); 
$country=intval($_GET['product']);
 
$query="SELECT id,rqsttype FROM tblrqsttype WHERE product_id='$country'";
/*echo $query;*/
$result=mysql_query($query);

?>
<select name="request" onchange="return divshow(this.value)" class="form-control drop_down">
<option>Select Request Type</option>
<?php while ($row=mysql_fetch_array($result)) { ?>
<option value=<?php echo $row['id']?>><?php echo $row['rqsttype']?></option>
<?php } ?>
</select>
