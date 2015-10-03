<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
	session_destroy();
	header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}

 if(count($_POST['linkID'])>0)
   {			   
  		$dsl="";
		if(isset($_POST['linkID']) &&(isset($_POST['submit'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
			  	$telecaller=$_POST['telecaller'];
		  		$createdby=$_SESSION['user_id'];
	            $sql="Update tblassign set telecaller_id='$telecaller', telecaller_assign_status='1' where id='{$chckvalue}'";			
				$results = mysql_query($sql);
   			   }
			 }  
  		$id="";
  }
//Remove Assign Contact
if(isset($_POST['remove']))
   {			   
  		$dsl="";
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
				$sql = "delete from tblassign where callingdata_id='$chckvalue'";
				/*echo $sql;*/
				$results = mysql_query($sql) or die(mysql_error()); 	
   			   }
			 }  
  		$id="";
  }
//End
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<script type="text/javascript" src="js/checkbox_validation_assign_pages.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/assign_contacts_telecaller.js"></script>
</head>
<body>
<!--open of the wraper-->
<div id="wraper">
	<!--include header-->
    <?php include_once('includes/header.php');?>
    <!--end-->
    <!--open of the content-->
<div class="row" id="content">
	<div class="col-md-12">
    	<h3>Assign Telecaller</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
     	<div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Category*</label>
                <div class="col-sm-10">
                  <select name="callingcat" id="callingcat" class="form-control drop_down">
                  <option label="" value="" selected="selected">Select Category</option>
                  <option value="0">All Category</option>
                  <?php $Country=mysql_query("select DISTINCT callingcategory_id from  tblassign where status_id ='2'");
						while($resultCountry=mysql_fetch_assoc($Country)){
				  ?>
                  <option value="<?php echo $resultCountry['callingcategory_id']; ?>" ><?php echo getCallingCategory(stripslashes(ucfirst($resultCountry['callingcategory_id']))); ?></option>
                  <?php } ?>
                  </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
           <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Telecaller*</label>
                <div class="col-sm-10">
                  <select name="telecaller" id="telecaller" class="form-control drop_down">
                  <option label="" value="" selected="selected">Select Telecaller</option>
                  <?php $Country=mysql_query("select * from tbluser where  User_Category='6' or User_Category='9' or User_Category='8'");
						while($resultCountry=mysql_fetch_assoc($Country)){
				  ?>
                  <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
                  <?php } ?>
                  </select>
                </div>
            </div>	
        </div>
        
        <div class="clearfix"></div>
        
           <div class="col-md-6">
            <input type="button" name="assign_device" class="btn btn-primary" onClick="return ShowbyCategory()" value="Assign Contact" />
            <input type="button" name="view_device" value="View Assigned" class="btn btn-primary" onClick="return ShowbyAssignContacts()" />
           </div>
        
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
        <!--Ajaxrequest-->
      </div>
    </form>
    </div>
</div>
<!--end of the content-->
<!--open of the footer-->
<div class="row" id="footer">
	<div class="col-md-12">
    <p>Copyright &copy; 2015 INDIAN TRUCKERS, All rights reserved.</p>
    </div>
</div>
<!--end footer-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>