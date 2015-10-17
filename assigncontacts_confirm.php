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
		        $status_id="2";
		  		$createdby=$_SESSION['user_id'];
	            $sql="Update tblassign set status_id='$status_id' where id='{$chckvalue}'";			
				$results = mysql_query($sql);
		  		$_SESSION['sess_msg']="State deleted successfully";
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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/assigncontact_confirmation.js"></script>
<script type="text/javascript">
function ShowbyCategory()
	{   
	    callingcat = document.getElementById("callingcat").value;
		//alert(branch);
		url="ajaxrequest/assigncontacts_branch_confirmation.php?callingcat="+callingcat+"&token=<?php echo $token;?>";
		//alert(url);
		xmlhttpPost(url,callingcat,"getResponseUnassignedStock");
	}
	/*function ShowByBranch()
	{
		branch = document.getElementById("branch").value;	
		model = document.getElementById("modelname").value;	 
		url="ajaxrequest/show_branch_device_confirmation.php?branch="+branch+"&model="+model+"&token=<?php echo $token;?>"; 
		//alert(url);
		xmlhttpPost(url,branch,"getResponseUnassignedStock");
	}*/
 
	function getResponseUnassignedStock(str){
	//alert(str);
	document.getElementById('divassign').innerHTML=str;
	//document.getElementById('area1').
	//document.getElementById("area1").innerHTML = "";
	//document.getElementById("divpincode").innerHTML = "";
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
    	<h3>Confirm Received Lead </h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
     	<div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Category*</label>
                <div class="col-sm-10">
                  <select name="callingcat" id="callingcat" onChange="return ShowbyCategory();" class="form-control drop_down">
                  <option label="" value="" selected="selected">Select Category</option>
                  <?php $Country=mysql_query("select DISTINCT callingcategory_id from  tblassign where status_id ='1'");
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
                <label for="inputEmail3" class="col-sm-2 control-label">State*</label>
                <div class="col-sm-10">
                  <select name="state" id="state" onChange="return callCity(this.value);" class="form-control drop_down" >
                  <option label="" value="" selected="selected">Select State</option>
                  <?php $Country=mysql_query("select * from tblstate order by State_name");
				        while($resultCountry=mysql_fetch_assoc($Country)){
				   ?>
                   <option value="<?php echo $resultCountry['State_name']; ?>" <?php if(isset($State_name) && $resultCountry['State_name']==$State){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
                   <?php } ?>
                  </select>
                </div>
            </div>
        </div>
        </div>
        <?php
		$where='';
		$linkSQL="";	
   		$oRS = mysql_query($linkSQL); 
  		?>
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
    	<input type='hidden' name='pagename' value='assigncontacts'>            	
        <div id="divassign" class="col-md-12 table-responsive assign_grid">
       		<!-- Ajaxrequest-->
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