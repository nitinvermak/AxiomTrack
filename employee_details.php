<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) 
{
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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
function getEmployeeDetails(){
	$('.loader').show();
		$.post("ajaxrequest/employee_details.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
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
    	<h3>Employee Details</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this);">
      <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Branch*</label>
                <div class="col-sm-10">
                  <select name="branch" id="branch" class="form-control drop_down" onchange="getEmployeeDetails();">
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
<script src="js/bootstrap.min.js"></script>
</body>

</html>