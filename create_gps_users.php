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
if(isset($_POST['submit']))
	{
		$customerId = mysql_real_escape_string($_POST['customerId']);
		$user_name = mysql_real_escape_string($_POST['user_name']);
		$Password = mysql_real_escape_string($_POST['Password']);
		$sql = "Insert into tbl_userloginmaster set type = '10', userDetailId = '$customerId', username = '$user_name', passsword = '$Password'";
		$result = mysql_query($sql);
		if($result)
		{
			echo "<script> alert('Customer Created Successfull') </script>";
		}
	}
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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/sim_confirmation.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
/* Send ajax request*/
$(document).ready(function(){
		$("#company").change(function(){
			$.post("ajaxrequest/create_users.php?token=<?php echo $token;?>",
				{
					id : $('#company').val(),
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
				});	 
		});
});
</script>
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
    	<h3>Create GPS Users</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail2">Company</label>
            <select name="company" id="company" class="form-control drop_down" >
                <option value="">Select Company</option>
                <?php $Country=mysql_query("SELECT * FROM tbl_customer_master");
				 	  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['callingdata_id']; ?>" ><?php echo getOraganization(stripslashes(ucfirst($resultCountry['callingdata_id']))); ?></option>
                <?php } ?>
                </select>
        </div>
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request --->
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