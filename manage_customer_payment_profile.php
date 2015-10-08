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
//Delete single record
if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$delete_single_row = "DELETE FROM tblcallingdata WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		echo "<script> alert('Record Delted Successfully'); </script>";
	}
//End
//Delete multiple records
if(count($_POST['delete_selected'])>0 && (isset($_POST['delete_selected'])) )
   {			   
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
		       	$sql = "DELETE FROM tblcallingdata WHERE id='$chckvalue'";
				$result = mysql_query($sql);
   			   }
			   if($result)
			   {
			   echo "<script> alert('Records Deleted Successfully'); </script>";
			   }
			 }    
   }
//End
// In Active 
if(isset($_POST['inactive']))
	{
		$custid = mysql_real_escape_string($_POST['custid']);
		$sql = "UPDATE tbl_customer_master SET activeStatus = 'N' Where cust_id = '$custid'";
		/*echo $sql;*/
		$result = mysql_query($sql);
		if($result)
		{
			echo "<script> alert('Customer In Active Successfully'); </script>";
		}
	}
//End
// Active 
if(isset($_POST['active']))
	{
		$custid = mysql_real_escape_string($_POST['custid']);
		$sql = "UPDATE tbl_customer_master SET activeStatus = 'Y' Where cust_id = '$custid'";
		/*echo $sql;*/
		$result = mysql_query($sql);
		if($result)
		{
			echo "<script> alert('Customer Active Successfully'); </script>";
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
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script>
function ShowContacts()
	{
		searchText = document.getElementById("searchText").value;
		/*alert(searchText);*/
		url="ajaxrequest/show_customer_for_payment.php?searchText="+searchText+"&token=<?php echo $token;?>";
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
    	<h3>Customer Profile</h3>
        <hr>
    </div>
    <div class="col-md-12">
      <div class="col-md-6">
        <input type="text" name="searchText" id="searchText" class="form-control text_search" Placeholder="Customer Id, Company Name or Mobile">
        <input type="submit" name="Search" id="Search" value="Search" onClick="ShowContacts()" class="btn btn-primary btn-sm"/>
        </div>
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
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>