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
    	<h3>Branch Role Details</h3>
        <hr>
	</div>
    <div class="col-md-12">
    	<div class="col-md-4 btn_grid">
   		  <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Add New" onClick="window.location.replace('add_branch_role.php?token=<?php echo $token ?>')"/>
       &nbsp;&nbsp;&nbsp;
       	  <input type="submit" name="delete_selected" onClick="return val();" class="btn btn-primary btn-sm" value="Delete Selected">
        </div>
    </div>
    <div class="col-md-12">
        
    <div class="table-responsive">
   <table class="table table-hover table-bordered ">
   <?php
		$where='';
		$linkSQL="";	
    	if(!isset($linkSQL) or $linkSQL =='')		
     	$linkSQL = "SELECT * FROM userBranchMapping order by userId";
  		$oRS = mysql_query($linkSQL); 
  	?>
   <form name='fullform' method='post' onSubmit="return confirmdelete()">
   <input type="hidden" name="token" value="<?php echo $token; ?>" />
   <input type='hidden' name='pagename' value='users'>            	        
   <?php if($_SESSION['sess_msg']!=''){?>
	 		<center>
            <div style="color:#009900; padding:0px 0px 10px 0px; font-weight:bold;"><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></div>
            </center>
   <?php } ?>
   	  
      <tr>
      <th><small>S. No.</small></th>     
      <th><small>UserName</small></th>    
      <th><small>Branch</small></th>
      <th><small>Action</small></th>   
      </tr>    
	  <?php
		$kolor=1;
		if(isset($_GET['page']) and is_null($_GET['page']))
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']==1)
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']>1)
			{
				$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
			}
	  if(mysql_num_rows($oRS)>0)
	  	{	$firstUser = ' ';
			$userBranches ='';
		
  			while ($row = mysql_fetch_array($oRS))
  			{
  				if($kolor%2==0)
					$class="bgcolor='#ffffff'";
				else
					$class="bgcolor='#fff'";
 	  			if ($firstUser == ' ' ){
					$firstUser = 	$row["userId"];
				}
				//echo '<br>$firstUser ='.$firstUser ;
				//echo '<br>$row["userId"]='.$row["userId"];
	  
      		    if ($firstUser != $row["userId"] ){
			 				          
					  echo '<tr '.$class.'>';
					  echo '<td><small>'.$kolor++.'</small></td>';
					  echo '<td><small>'.$userName.'</small></td>';
					  echo '<td><small>'.$userBranches.'</small></td>';
					  echo "<td>";

					  echo '<a href=add_branch_role.php?id='.$row["userId"].'&token='.$token.">";
					  echo "<img src='images/edit.png' title='Edit' border='0' />
						    </a>";					 
					  echo "<input type='checkbox' name='linkID[]' value='".$row["Id"]."'>";
					  echo  "</td></tr>";
					  $firstUser = 	$row["userId"];
					   
					  $userName=gettelecallername($row["userId"]);
					  $userBranches = getBranch($row["branchId"]);
					  
					  			  
  				}
				else{
					$userName=gettelecallername($row["userId"]);
					if ($userBranches){
						$userBranches = $userBranches."  ,  ".getBranch($row["branchId"]);
					}else{
						$userBranches = getBranch($row["branchId"]);
					}   
				}
				
			}
		 
		}	
		else{
   			 echo "<h3 style='color:red;'>No records found!</h3>";
		}
		?>	
	
    </table>
    </div>
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