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
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript" src="js/manage_sim.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#searchBtn").click(function(){
			/*alert('afj');*/
			$('.loader').show();
			$.post("ajaxrequest/showInstockSim.php?token=<?php echo $token;?>",
				{
					searchText : $('#search').val()
				},
					function( data ){
						$("#responseText").html(data);
						$(".loader").removeAttr("disabled");
            			$('.loader').fadeOut(1000);
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
    	<h3>Sim   Details</h3>
        <hr>
    </div>
    <form name='fullform' method='post' onSubmit="return confirmdelete()">
    <div class="col-md-12">
    
    	<div class="col-md-4 btn_grid">
       		<input type='button' name='cancel' class="btn btn-primary btn-sm" value="Add New" onClick="window.location.replace('sim.php?token=<?php echo $token ?>')"/>
       &nbsp;&nbsp;&nbsp;
        	<input type="submit" name="delete_selected" onClick="return val();" class="btn btn-primary btn-sm" value="Delete Selected">
        </div>
  
    </div>
    <div class="col-md-12">
       
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <input type='hidden' name='pagename' value='users'> 
        <div class="table-responsive">
           <table>
           <tr>
           <td><input type="text" name="search" id="search" class="form-control text_box"></td>
           <td><input type="button" name="searchBtn" id="searchBtn" class="btn btn-primary btn-sm" value="Search"></td>
           </tr>
           </table>
        </div> 
        <div class="table-responsive" id="responseText">
               <!--show Data from ajax request-->
        </div>
         <!--if device details is updated show alert message-->
        <div>
        	 <?php if($_SESSION['sess_msg']!=''){?>
                <center>
                    <div style="color:#009900; padding:0px 0px 10px 0px; font-weight:bold;">
                    <?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?>
                    </div>
                </center>
  	 		<?php } ?>
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
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>