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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="js/ajax.js"></script>
<script>
function ShowContacts()
	{
		searchText = document.getElementById("searchText").value;
		/*alert(searchText);*/
		url="ajaxrequest/show_create_ticket.php?searchText="+searchText+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,searchText,"GetResponse");
	} 
function GetResponse(str){
	document.getElementById('divshow').innerHTML=str;
	}
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
    	<h3>Ticket Summery</h3>
        <hr>
    </div>
  	<div class="col-md-12">
    <form method="post" class="form-inline" name="frm_delete">
    	<div class="col-md-4 btn_grid">
     		<input type='button' name='cancel' class="btn btn-primary" value="Add New" onClick="window.location.replace('ticket.php?token=<?php echo $token ?>')"/>
       &nbsp;&nbsp;&nbsp;
        	 
        </div>
        
    </form>
    <div class="col-md-6">
        <input type="text" name="searchText" id="searchText" class="form-control text_search" Placeholder="Ticket Id">
        <input type="submit" name="Search" id="Search" value="Search" onClick="ShowContacts()" class="btn btn-primary"/>
        </div>
    </div>
    <div class="col-md-12">
    <!--show message when ticket create-->
		 <?php if($_SESSION['sess_msg']!=''){?>
              <div class="alert alert-success" style="max-width:400px;" role="alert">
			  <?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?>
              </div>
         <?php } ?>
    </div>
    <div class="col-md-12">
    	<div class="table-responsive" id="divshow">
   
    	</div>
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