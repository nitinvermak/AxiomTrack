<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
$id = mysql_real_escape_string($_POST['id']);
/*echo $id;*/
$sql = mysql_query("select * from tblcallingdata where id='$id'");
$result = mysql_fetch_array($sql);
$sql1 = mysql_query("select * from tbl_customer_master where callingdata_id='$id'");
$result1 = mysql_fetch_array($sql1);
?>
 <div class="col-md-12">
    	<form name='myform' action="" method="post" onSubmit="return chkcontactform(this)">
        <input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid' value="<?php echo $result['id'];?>"/>
        <div class="table table-responsive">
    	<table border="0" cellpadding="0" cellspacing="1">
        <tr>
        <td>Cust ID*</td>
        <td><input name="customerId" id="customerId" class="form-control text_box" type="text" value="<?php echo $result1['callingdata_id'];?>" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
       
          <tr height="40px">
          <td valign="top">User Name</td>
          <td valign="top"><input name="user_name" id="user_name" class="form-control text_box" value="<?php if(isset($result['id'])) echo $result['User_ID'];?>"type="text" /></td>
          <td>Password</td>
          <td><input name="Password" id="Password" value="<?php if(isset($result['id'])) echo $result['Password'];?>" tabindex="0" class="form-control text_box" type="password" /></td>
          </tr>
          <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="2"><input type="reset" id="reset" class="btn btn-primary btn-sm"  value="Reset"/> 
          <input type="submit" value="Submit" name="submit" id="submit"  class="btn btn-primary btn-sm" /> <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" onClick="window.location.replace('manage_users.php?token=<?php echo $token ?>')"/></td>
          <td valign="top">&nbsp;</td>
        </tr>
    </table>
  		</div>
        </form>