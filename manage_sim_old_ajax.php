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
		$delete_single_row = "DELETE FROM tblsim WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		echo "<script> alert('Record Delted Successfully'); </script>";
	}
//End
//Delete  multiple records
if(count($_POST['linkID'])>0 && (isset($_POST['delete_selected'])) )
   {			   
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
		       	$sql = "DELETE FROM tblsim WHERE id='$chckvalue'";
				$result = mysql_query($sql);
			  }
			  if($result)
			  {
			    echo "<script> alert('Records Deleted Successfully'); </script>";
			  }
			}    
  }
//end
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">

<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript" src="js/manage_sim.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" language="javascript">
function SearchRecords()
	{   
	    search_box = document.getElementById("search_box").value;
		alert(search_box);
		url="ajaxrequest/show_import_sim.php?search_box="+search_box+"&token=<?php echo $token;?>";
		alert(url);
		xmlhttpPost(url,search_box,"GetRecords");
	}
	function GetRecords(str){
	document.getElementById('divassign').innerHTML=str;
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
    	<h3>Sim   Details</h3>
        <hr>
    </div>
    <div class="col-md-12">
     <form method="post" name="frm_delete" class="form-inline" onSubmit="return chkfield(this)">
    	<div class="col-md-4 btn_grid">
       
     		<input type='button' name='cancel' class="btn btn-primary" value="Add New" onClick="window.location.replace('sim.php?token=<?php echo $token ?>')"/>
       &nbsp;&nbsp;&nbsp;
        	 <input type="submit" name="delete_selected" onClick="return confirm('Are You Sure You Want to Delete?')" class="btn btn-primary" value="Delete Selected">
        </div>
        <div class="col-md-6">
        <input type="text" name="search_box" class="form-control text_box" placeholder="Search by Sim or Mobile No." id="search_box" />
        <input type="submit" name="search" class="btn btn-primary" value="Search" onClick="return SearchRecords();"/>
        </div>
       
    </div>
     <div id="divassign" class="col-md-12 table-responsive assign_grid">
     	<!--Show Data from Ajax Request-->
     </div>
     </form> 
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