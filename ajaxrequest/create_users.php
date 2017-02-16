<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
?>
<div class="col-md-12" id="dvMsg"></div>
<div class="col-md-12">
  <form name='myform' action="" method="post" class="form-inline">
    <input type="hidden" name="submitForm" value="yes" />
    <div class="form-group">
      <label for="Username">Username</label>
      <input name="user_name" id="user_name" class="form-control text_box" type="text" />
    </div>
    <div class="form-group">
      <label for="Password">Password</label>
      <input name="password" id="password" class="form-control text_box" type="password" />
    </div>
    <input type="button" value="Submit" name="submit" id="submit"  class="btn btn-primary btn-sm" onclick="createUser();" />
  </form>
</div>