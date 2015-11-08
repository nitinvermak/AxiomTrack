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

if(isset($_POST['save']))
	{
		$Usercategory = mysql_real_escape_string($_POST['Usercategory']);
		foreach($_POST['list'] as $checkvalue)
		{
			$sql = "select * from tblusercategorymodulemapping  where moduleId = '$checkvalue' and usercategoryId =".$Usercategory;
			/*echo $sql;*/
			$resultSql = mysql_query($sql);
			if(mysql_num_rows($resultSql) <= 0)
				{
					$sql = "Insert into tblusercategorymodulemapping set moduleId = '$checkvalue', 
							usercategoryId = '$Usercategory', created = Now()";
					/*echo $sql.'<br>';*/
					$result = mysql_query($sql);
					if($result)
					{
						$msg = "Setting Saved !";
					}
				}
			else
				{
					$sql = "Update tblusercategorymodulemapping set moduleId = '$checkvalue'  			 								                  			Where moduleId = '$checkvalue' and usercategoryId = '$Usercategory'";
							/*echo $sql.'<br>';*/
					$result = mysql_query($sql);
					if($result)
					{
						$msg = "Setting Updated !";
					}
				}
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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/checkbox_validation.js"></script>
<script type="text/javascript">
/* Send ajax request*/
$(document).ready(function(){
		$("#Usercategory").change(function(){
			$.post("ajaxrequest/show_role_UserCategory.php?token=<?php echo $token;?>",
				{
					UserCat : $('#Usercategory').val(),
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
				});	 
		});
});



</script>
<script type="text/javascript">
$(document).on('click','#chkAll',function(){
	$(".perCheck1").prop("checked",$("#chkAll").prop("checked"))
     
});


function checkPermission(classA){
 
	ClassB= ".perCheck"+classA;

	//$(ClassB).prop("checked",true)
	
	if($(ClassB).is(':checked'))
    	$(ClassB).prop("checked",false)
	else
   		$(ClassB).prop("checked",true)
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
    	<h3>User Category</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail2">User Category</label>
            <select name="Usercategory" class="form-control input-sm drop_down" id="Usercategory">
                <option label="" value="">Select User Category</option>
                        <?php $Country=mysql_query("SELECT * FROM tblusercategory ORDER BY User_Category ASC ");
                                       while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['User_Category'])); ?></option>
                        <?php } ?> 
        	</select>
            
        </div>
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
      <?php if(isset($msg))
	  		{
				echo "<p style='color:green; font-weight:bold;'>".$msg ."</p>";
			}
	  ?>
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