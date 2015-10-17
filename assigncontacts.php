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
     	for($dsl=0;$dsl<count($_POST['linkID']);$dsl++)
		  {
		  $callingdata_id=$_POST['linkID'][$dsl];
		  $callingcategory_id=$_POST['callingcat'];
		  $status_id="1";
		  $branch_id=$_POST['branch'];
		  $createdby=$_SESSION['user_id'];
		  $sql="insert into tblassign set callingdata_id='$callingdata_id',callingcategory_id='$callingcategory_id',status_id='$status_id',branch_id='$branch_id',createdby='$createdby',created=CURDATE()";
		  $results = mysql_query($sql); 
		  $_SESSION['sess_msg']="State deleted successfully";
		  }
		  $id="";  
  }
//Remove Assign Contact
if(isset($_POST['remove']))
   {			   
  		$dsl="";
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
				$sql = "delete from tblassign where id=".$chckvalue;
				/*echo $sql;*/
				$results = mysql_query($sql) or die(mysql_error()); 	
   			   }
			 }  
  		$id="";
  }
//End
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
function callCity(state_id){ 
	url="ajaxrequest/getCity1.php?state_id="+state_id+"&City=<?php echo $result['City'];?>&token=<?php echo $token;?>";
	//alert(url);
	xmlhttpPost(url,state_id,"getresponsecity");
	callcat=document.getElementById('callingcat').value;
	st=document.getElementById('state').value;
	ct=document.getElementById('city').value;
	url="ajaxrequest/getgrid.php?state_id="+st+"&city="+ct+"&callcat="+callcat+"&token=<?php echo $token;?>";
//	alert(url);
	xmlhttpPost(url,st,"getresponsegrid");
	}
	
	function getresponsecity(str){
	//alert(str);
	document.getElementById('divcity').innerHTML=str;
	//document.getElementById('area1').
	//document.getElementById("area1").innerHTML = "";
	//document.getElementById("divpincode").innerHTML = "";
	}
	function callGrid()
	{
	callcat=document.getElementById('callingcat').value;
	st=document.getElementById('state').value;
	ct=document.getElementById('city').value;
	url="ajaxrequest/getgrid.php?state_id="+st+"&city="+ct+"&callcat="+callcat+"&token=<?php echo $token;?>";
//	alert(url);
	xmlhttpPost(url,st,"getresponsegrid");
	}
	
function getresponsegrid(str){
	//alert(str);
	document.getElementById('divassign').innerHTML=str;
	//document.getElementById('area1').
	//document.getElementById("area1").innerHTML = "";
	//document.getElementById("divpincode").innerHTML = "";
	}
	//show assign contacts
	function ShowContact()
	{
		branch = document.getElementById("branch").value;	 
		url="ajaxrequest/show_assigned_contact.php?branch="+branch+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,branch,"getResponseAssignContact");
	}
 
	function getResponseAssignContact(str){
		/*alert(str);*/
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
    	<h3>Lead Assign</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
     	<div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Category*</label>
                <div class="col-sm-10">
                  <select name="callingcat" id="callingcat" onChange="return callGrid();" class="form-control drop_down">
                  <option label="" value="" selected="selected">Select Category</option>
                  <?php $Country=mysql_query("select * from tblcallingcategory");
						while($resultCountry=mysql_fetch_assoc($Country)){
				  ?>
                  <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['category'])); ?></option>
                  <?php } ?>
                  </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
           <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Branch*</label>
                <div class="col-sm-10">
                  <select name="branch" id="branch" class="form-control drop_down">
                  <option label="" value="" selected="selected">Select Branch</option>
                  <?php $Country=mysql_query("select * from tblbranch");
				  		while($resultCountry=mysql_fetch_assoc($Country)){
				  ?>
                  <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
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
        <div class="col-md-6">
           <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">City*</label>
                <div class="col-sm-10">
                  <select name="city" id="city" onChange="return callGrid();" class="form-control drop_down">
                  <option label="" value="" selected="selected">Select City</option>
                  <?php $Country=mysql_query("select distinct city_name from tblcity order by city_name");					  
						while($resultCountry=mysql_fetch_assoc($Country)){
				  ?>
                  <option value="<?php echo $resultCountry['city_name']; ?>" <?php if(isset($city_name) && $resultCountry['city_name']==$City){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['city_name'])); ?></option>
                  <?php } ?>
                 </select>
                </div>
            </div>	
        </div>
        <div class="clearfix"></div>
        
           <div class="col-md-6">
            <input type="button" name="view" id="view" class="btn btn-primary btn-sm" value="View Assigned Contact" onClick="ShowContact()"/>	
           </div>
        
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <table class="table table-bordered table-hover">
          <?php
		  $where='';
		  $linkSQL="";	
          if(!isset($linkSQL) or $linkSQL =='')		
          $linkSQL = "select * from tblcallingdata where 1=1 $where order by id desc";
          $oRS = mysql_query($linkSQL);	
  		  ?>
          <tr>
          <th><small>S. No.</small></th>     
          <th><small>Name</small></th> 
          <th><small>Company Name</small></th>
          <th><small>Phone</small></th>
          <th><small>Mobile</small></th>
          <th><small>State</small></th>
          <th><small>City</small></th>
          <th><small>Area</small></th>
          <th><small>Actions
          <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
          &nbsp;&nbsp;
          <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>          </small>
          </th>   
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
				{
			  while ($row = mysql_fetch_array($oRS))
			  {
			  
			  if($kolor%2==0)
				$class="bgcolor='#ffffff'";
				else
				$class="bgcolor='#fff'";
 			?>
            <tr <?php print $class?>>
            <td><small><?php print $kolor++;?>.</small></td>
			<td><small><?php echo stripslashes($row["First_Name"]." ".$row["Last_Name"]);?></small></td>
			<td><small><?php echo stripslashes($row["Company_Name"]);?></small></td>
			<td><small><?php echo stripslashes($row["Phone"]);?></small></td>
			<td><small><?php echo stripslashes($row["Mobile"]);?></small></td>
            <td><small><?php echo getstate(stripslashes($row["State"]));?></small></td>
            <td><small><?php echo getcities(stripslashes($row["City"]));?></small></td>
            <td><small><?php echo getarea(stripslashes($row["Area"]));?></small></td>
            <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
            </tr> 
           <?php 
			}
				/*echo $pagerstring;*/
			}
    		else
    			echo "<tr><td colspan=6 align=center><h3>No records found!</h3></td><tr/></table>";
			?> 
	 
          </table>
          <table>
          <tr>
         
          <td height="50"><input type="submit" class="btn btn-primary btn-sm" onClick="return confirm('Do you really to want to assign this records');" value="Submit" id="submit" /></td>
          </tr>
          </table>
          <br>
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