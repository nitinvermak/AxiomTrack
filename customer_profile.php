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
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
// send ajax request
$(document).ready(function(){
	$('#searchText').change(function(){
		$('.loader').show();
		$.post("ajaxrequest/show_customers_details.php?token=<?php echo $token;?>",
				{
					searchText : $('#searchText').val()
				},
					function( data){
						/*alert(data);*/
						$("#divshow").html(data);
						$(".loader").removeAttr("disabled");
            			$('.loader').fadeOut(1000);
				});	 
	});
});
//end
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
    	<h3>Customer Profile</h3>
        <hr>
    </div>
    <div class="col-md-12 table-responsive">
      <table width="333">
      <tr>
      <td width="240">
      <select name="searchText" id="searchText" class="form-control drop_down">
            <option value="">Select Orgranization</option>                         
            <?php $sqlQuery = mysql_query("SELECT A.Company_Name as companyName 
                                        FROM tblcallingdata as A 
                                        INNER JOIN tbl_customer_master as B 
                                        ON A.id = B.callingdata_id 
                                        ORDER BY A.Company_Name");								
                  while($resultQuery = mysql_fetch_assoc($sqlQuery))
                        {
            ?>
            <option value = "<?php echo $resultQuery['companyName']; ?>">
            <?php echo stripslashes(ucfirst($resultQuery['companyName'])); ?></option>
            <?php } ?>
      </select>
      </td>
      <td width="81">
      <!--<input type="submit" name="Search" id="Search" value="Search" 
      class="btn btn-primary btn-sm"/>-->
      </td>
      </tr>
      </table>
    </div>
     <div class="col-md-12">
		 <?php if($_SESSION['sess_msg']!=''){?>
           <div class="alert alert-success" role="alert">
		   		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
           		<?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?>
           </div>
         <?php } ?>
    </div>
    <div class="clearfix"></div><br>
    <div class="col-md-12">
    <form method="post">
    	<div class="table-responsive" id="divshow">
   
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
<div class="loader">
	<img src="images/loader.gif" alt="loader">
</div>
</div>
<!--end wraper-->
<!--Javascript-->
<script src="js/bootstrap.min.js"></script>
</body>
</html>