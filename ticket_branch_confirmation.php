<?php
//echo("hi");
//die;
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
      		        /*  $device_id=$_POST['linkID'][$dsl];*/
      	   	  		$branch_id=$_POST['branch'];
      		  		$confirmation_status="1";
      		  		$createdby=$_SESSION['user_id'];
      	          	$sql = "update tbl_ticket_assign_branch set branch_confirmation_status = '$confirmation_status' 
      						where ticket_id='$chckvalue'";
					// Call User Activity Log function
					UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
					// End Activity Log Function
      				$results = mysql_query($sql);
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
		$("#branch").change(function(){
			$('.loader').show();
			$.post("ajaxrequest/show_ticket_branch_confirmation.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val(),
				},
					function( data){
						$("#divassign").html(data);
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
    	<h3>Confirm Received Ticket </h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
     	<div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Branch*</label>
                <div class="col-sm-10">
                 <select name="branch" id="branch" class="form-control drop_down">
                    <option label="" value="" selected="selected">Select Branch</option>
                    
                      <?php 
                            $branch_sql= "select * from tblbranch ";
                            $authorized_branches = BranchLogin($_SESSION['user_id']);
                            //echo $authorized_branches;
                            if ( $authorized_branches != '0'){
                                 
                                $branch_sql = $branch_sql.' where id in '.$authorized_branches;		
                            }
                            if($authorized_branches == '0'){
                                echo'<option value="0">All Branch</option>';	
                            }
                            //echo $branch_sql;
                            $Country = mysql_query($branch_sql);					
                                                          
                            while($resultCountry=mysql_fetch_assoc($Country)){
                      ?>
                    <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
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
 		//echo $pagerstring;		
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
<!-- hidden loader division -->
<div class="loader">
	<img src="images/loader.gif" alt="loader">
</div>
<!-- end hidden loader division-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>