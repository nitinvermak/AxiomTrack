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
/*if(isset($_POST['submit']))
	{
		$interval_Id = mysql_real_escape_string($_POST['interval_Id']);
		$Generated_Status = mysql_real_escape_string($_POST['Generated_Status']);
		$gen_date = mysql_real_escape_string($_POST['gen_date']);
		echo $interval_Id;
	}*/
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
function Show()
	{   
	    year = document.getElementById("year").value;
		//alert(branch);
		url="ajaxrequest/show_generate_estimate.php?year="+year+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,year,"getResponse");
	}
	function getResponse(str){
	document.getElementById('divassign').innerHTML=str;
	}

function getValue(a){
     //console.log( $(this).attr('interval_Id') + '=' + $(this).val());
 	$('.loader').show();
	elements= '#'+a+'   input';
 	jsonArr= []
	jQuery(elements).map(function() {
           console.log( $(this).attr('id') + '=' + $(this).val());
		   jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
		   
      });
 	 
	 url="ajaxrequest/generate_estimate_info.php?token=<?php echo $token;?>";	                 
     
	 postData = {'PostData': jsonArr };
	 console.log(jsonArr);
	 alert('Invoice for selected month are getting generated');
 
	 xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA");
	}	
	function GetResponseA(str){
 		  document.getElementById('divShow').innerHTML=str;
		  $(".loader").removeAttr("disabled");
		  $('.loader').fadeOut(1000);
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
    	<h3> Generate Estimate</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' >
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Select&nbsp;Year*</label>
   			<select name="year" id="year"  class="form-control drop_down required" onChange="return Show();">
            	<option value="">--Select--</option> 
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
            </select>
  		</div>
        </div>
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request --->
      </div>
      <div id="divShow" class="col-md-12 table-responsive assign_grid">
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