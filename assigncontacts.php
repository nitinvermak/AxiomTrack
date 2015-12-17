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


if(count($_POST['linkID'])>0)
{
  $dsl="";
  for($dsl=0;$dsl<count($_POST['linkID']);$dsl++)
  {
  		$callingdata_id = $_POST['linkID'][$dsl];
		$callingcategory_id = $_POST['callingcat'];
		$status_id = "1";
		$branch_id = $_POST['branch'];
		$createdby = $_SESSION['user_id'];
		$checkDuplicate = mysql_query("SELECT * FROM tblassign WHERE callingdata_id='$chckvalue'"); 
                if(mysql_num_rows($checkDuplicate) <= 0)
				{
					$sql = "insert into tblassign set callingdata_id='$callingdata_id', assign_by = '$createdby',
							callingcategory_id='$callingcategory_id', status_id='$status_id',
							branch_id='$branch_id',createdby='$createdby',created=CURDATE()";
					$results = mysql_query($sql); 
					// Call User Activity Log function
					UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
					// End Activity Log Function
					$_SESSION['sess_msg'] = "<span style='color:#006600;'>Lead Assign Successfully</span>";
				}
				else{
					$_SESSION['sess_msg']="<span style='color:red;'>Lead already Assign</span>";
				}
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
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
				// End Activity Log Function
				$results = mysql_query($sql) or die(mysql_error()); 
				$_SESSION['sess_msg']="<span style='color:red;'>Lead Remove Successfully</span>";
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
//call ajax when select category
$(document).ready(function(){
	$('#callingcat').change(function(){
		$('.loader').show();
		$.post("ajaxrequest/getgrid.php?token=<?php echo $token;?>",
				{
					callingcat : $('#callingcat').val(),
					state : $('#state').val(),
					city : $('#city').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
//end
//call ajax when select State
$(document).ready(function(){
	$('#state').change(function(){
		$('.loader').show();
		$.post("ajaxrequest/getCity1.php?token=<?php echo $token;?>",
				{
					state : $('#state').val(),
					city : $('#city').val()
				},
					function(data){
						/*alert(data);*/
						$("#divcity").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
//end
//call ajax when click View Assigned Contacts
$(document).ready(function(){
	$('#view').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/show_assigned_contact.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
//end
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
                  <select name="callingcat" id="callingcat" class="form-control drop_down">
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
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">State*</label>
                <div class="col-sm-10">
                  <select name="state" id="state"  class="form-control drop_down" >
                  <option label="" value="" selected="selected">Select State</option>
                  <?php $Country=mysql_query("select * from tblstate order by State_name");
				        while($resultCountry=mysql_fetch_assoc($Country)){
				   ?>
                   <option value="<?php echo $resultCountry['State_id']; ?>" <?php if(isset($State_name) && $resultCountry['State_name']==$State){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
                   <?php } ?>
                   </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
           <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">City*</label>
                <div class="col-sm-10" id="divcity">
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
            <input type="button" name="view" id="view" class="btn btn-primary btn-sm" value="View Assigned Contact"/>	
           </div>
        
          </div> 
		   <div class="col-md-12"> 
		   <!--<div id="messages" class="hide" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>--->
				 <?php if($_SESSION['sess_msg']!='')
					{
						echo "<p class='success-msg'>".$_SESSION['sess_msg'];$_SESSION['sess_msg']=''."</p>";
					} 
				 ?>
		  <!-- </div>--->
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