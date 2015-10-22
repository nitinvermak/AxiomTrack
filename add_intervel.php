<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

//echo count($_POST['linkID']);

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
	session_destroy();
	header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}
if(isset($_POST['submit']))
	{	
		$intervel = array("January" => [1,1], "February" =>[1,2], "March" => [1,3], "April" => [1,4], 
					"May" => [1,5], "June" => [1,6], "July" => [1,7], "August" => [1,8], "September" => [1,9], 
					"October" => [1,10], "November" => [1,11], "December" => [1,12], "Q1" => [1,01], "Q2" => [1,02], 
					"Q3" => [1,02], "Q4" => [1,02], "H1" =>[1,02], "H2" => [1,02], "Yearly" => [1,02]);
		foreach ($intervel as $period => $frequency)
		{  
			$year = mysql_real_escape_string($_POST['year']);
			$intervelname = $item;
			$generated_status = 'N';
			$check_rows = mysql_query("SELECT * FROM `tblesitmateperiod` WHERE IntervelYear='$year' and Intervalname='$period'");
			if(mysql_num_rows($check_rows)<=0)
				{
					$sql = "INSERT INTO tblesitmateperiod Set IntervelYear='$year', Intervalname='$period',  
					FrequnceyID='$frequency[0]', intervalMonth = '$frequency[1]', GeneratedStatus='$generated_status'";
					$result = mysql_query($sql);
					$msg="Intervel Added Sucessfully";
				}
			else
				{
					$msg="Year Already Exists";
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
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/assign_device_to_branch.js"></script>
<script type="text/javascript" src="js/checkbox_validation.js"></script>

<script type="text/javascript">
function confirmdelete(obj)
{
	if(obj.year.value == "")
	{
		alert("Please Select Year");
		obj.year.focus();
		return false;
	}
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
    	<h3> Add Intervel</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Select Year</label>
    		<select name="year" id="year"  class="form-control drop_down required">
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
        
  		<input type="submit" name="submit" value="Add Intervel" id="submit" class="btn btn-primary btn-sm" />
        
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <?php if(isset($msg) && $msg !="") echo "<font color=red>".$msg."</font>"; ?>
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