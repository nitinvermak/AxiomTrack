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
		if(isset($_POST['linkID']) &&(isset($_POST['depositBank'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
	            $sql = "UPDATE quickbookpaymentcheque SET DepositStatus = 'Y', bankDepositDate = Now() WHERE Id = '$chckvalue'";
				/*echo $sql;*/
				$results = mysql_query($sql);
		  		$_SESSION['sess_msg']="Payment Confirm Successfully!";
   			   }
			 }  
  		$id="";
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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox_validation_assign_pages.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/checkbox_validation_assign_pages.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript">
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
$(document).ready(function(){
	$('#search').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/daily_installation_details.php?token=<?php echo $token;?>",
				{
					depositDateFrom : $('#depositDateFrom').val(),
					depositDateTo : $('#depositDateTo').val(),
					branch : $('#branch').val(),
					executive : $('#executive').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
// send ajax when select branch
$(document).ready(function(){
	$("#branch").change(function(){
		$.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#showTechnician").html(data);
				});
	});
});
// End
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
    	<h3>New Installation</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      <table width="715">
      <tr>
      <td width="95"><strong>Date (From)* </strong></td>
      <td width="173"><input type="text" name="depositDateFrom" id="depositDateFrom" class="form-control text_box date"></td>
      <td width="114"><strong>Branch</strong></td>
      <td width="230">
      	<select name="branch" id="branch" class="form-control drop_down">
        	<option label="" value="" selected="selected">All Branch</option>
            <?php 
            $branch_sql= "select * from tblbranch ";
            //echo $branch_sql;
            $Country = mysql_query($branch_sql);					
            	while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
      	</select>
      </td>
      <td width="79">&nbsp;</td>
      </tr>
      <tr>
      <td><strong>Date (To)*</strong></td>
      <td><input type="text" name="depositDateTo" id="depositDateTo" class="form-control text_box date"></td>
      <td><strong>Executive</strong></td>
      <td>
      		<span id="showTechnician">
            <select name="executive" id="executive" class="form-control drop_down-sm">
            <option value="">Select Executive</option>                         
            </select>
           	</span>
      </td>
      <td><input type="button" name="search" id="search" value="Search" class="btn btn-primary btn-sm"></td>
      </tr>
      </table>
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
<!-- hidden loader division -->
<div class="loader">
	<img src="images/loader.gif" alt="loader">
</div>
<!-- end hidden loader division-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/bootstrap.min.js"></script>
</body>
</html>