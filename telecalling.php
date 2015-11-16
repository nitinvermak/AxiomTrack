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
	    callingcat = document.getElementById("callingcat").value;
		//alert(branch);
		url="ajaxrequest/telecalling_by_category.php?callingcat="+callingcat+"&token=<?php echo $token;?>";
		//alert(url);
		xmlhttpPost(url,callingcat,"getResponseUnassignedStock");
	}
	function ShowbyTelecaller()
	{   
	    telecaller = document.getElementById("telecaller").value;
		//alert(branch);
		url="ajaxrequest/telecalling_by_telecaller.php?telecaller="+telecaller+"&token=<?php echo $token;?>";
		//alert(url);
		xmlhttpPost(url,telecaller,"getResponseUnassignedStock");
	}
 
	function getResponseUnassignedStock(str){
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
    	<h3> Telecalling</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Calling&nbsp;Category <span class="red">*</span></label>
    			<select name="callingcat" id="callingcat" onChange="return ShowbyCategory();" class="form-control drop_down">
                <option label="" value="" selected="selected">Select Category</option>
                <?php $Country=mysql_query("select DISTINCT callingcategory_id  from tblassign where status_id ='2'");
					  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['callingcategory_id']; ?>" ><?php echo getCallingCategory(stripslashes(ucfirst($resultCountry['callingcategory_id']))); ?></option>
                <?php } ?>
                </select>
  		</div>
        <div class="form-group">
            <label for="exampleInputEmail2">Executive <span class="red">*</span></label>
            	<select name="telecaller" id="telecaller" class="form-control drop_down">
                <option label="" value="" selected="selected">Select Telecaller</option>
               
                 <?php 
                        $branchUsers= "select * from tbluser";
                        $authorized_branches = BranchLogin($_SESSION['user_id']);
                        //echo $authorized_branches;
                        if ( $authorized_branches != '0'){
                             
                            $branchUsers = $branchUsers.' where branch_id in '.$authorized_branches;		
                        }
                        if($authorized_branches == '0'){
                            echo'<option value="0">All Branch</option>';	
                        }
                        //echo $branch_sql;
                        $branchUsersSql = mysql_query($branchUsers);					
                                                      
                        while($resultCountry=mysql_fetch_assoc($branchUsersSql)){
                  ?>
                <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
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