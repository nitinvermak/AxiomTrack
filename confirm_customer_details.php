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
$telecaller = $_POST['telecaller'];
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
<script type="text/javascript">
function ShowbyCategory()
	{   
	    organization = document.getElementById("organization").value;
		/*alert(organization);*/
		url="ajaxrequest/show_customer_details.php?organization="+organization+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,organization,"getResponse");
	} 
	function getResponse(str){
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
    	<h3> Customer Details</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Organization*</label>
    			<select name="organization" id="organization" onChange="return ShowbyCategory();" class="form-control drop_down">
                <option label="" value="" selected="selected">Select Organization</option>
                <?php $Country=mysql_query("SELECT A.callingdata_id, B.Company_Name 
											FROM tbl_customer_master as A 
											INNER JOIN tblcallingdata as B 
											ON A.callingdata_id = B.id ORDER BY B.Company_Name ASC");
					  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['callingdata_id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
                <?php } ?>
                </select>
  		</div>
        </div>
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request --->
      </div>
    </form>
    </div>
    <div class="col-md-12">
		 <?php if($_SESSION['sess_msg']!=''){?>
                    <div class="alert alert-success" role="alert"><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></div>
         <?php } ?>
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