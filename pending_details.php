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
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
// send ajax request
$(document).ready(function(){
	$('#Search').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/pending_details.php?token=<?php echo $token;?>",
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
    	<h3>Pending Details</h3>
        <hr>
    </div>
    <div class="col-md-12 table-responsive">
      <table width="333">
      <tr>
      <td width="240">
      <select name="searchText" id="searchText" class="form-control drop_down">
            <option value="">--Select--</option>                         
            <?php $sql=mysql_query("SELECT A.Company_Name as companyName, B.cust_id as custId 
									FROM tblcallingdata as A 
									INNER JOIN tbl_customer_master as B 
									ON A.id = B.callingdata_id ORDER BY A.Company_Name");								
                  while($result=mysql_fetch_assoc($sql))
                        {
            ?>
            <option value="<?php echo $result['custId']; ?>">
            <?php echo stripslashes(ucfirst($result['companyName'])); ?></option>
            <?php } ?>
      </select>
      </td>
      <td width="81">
      <input type="submit" name="Search" id="Search" value="Search" class="btn btn-primary btn-sm"/>
      </td>
      </tr>
      </table>
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
<!-------Javascript------->
<script src="js/bootstrap.min.js"></script>
</body>
</html>