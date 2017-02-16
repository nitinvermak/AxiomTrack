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
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="http:/resources/demos/style.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/sim_confirmation.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<!-- DataTable CDN-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
		$("#company").change(function(){
			$.post("ajaxrequest/manually_invoice.php?token=<?php echo $token;?>",
				{
					cust_id : $('#company').val(),
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
						$('#example').DataTable({ "bPaginate": false });
						$('body').on('focus',".next_due_date", function(){
							$( this ).datepicker({dateFormat: 'yy-mm-dd'});
						});
				});	 
		});
});
/* End */
// Send Data via ajax request
function getData(){
	$('.loader').show();
	jsonArr = []
	$(".next_due_date").each(function(){
		jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
	});
	console.log(jsonArr);
	url="ajaxrequest/manually_invoice_next_due_date.php?token=<?php echo $token;?>";
	postData = {'PostData': jsonArr };
	xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA");
}
function GetResponseA(str){
 		  document.getElementById('dvShow').innerHTML=str;
		  $(".loader").removeAttr("disabled");
		  $('.loader').fadeOut(1000);
} 
// end
// Copy textbox value 
function makeAllDateSame()
{
	//alert("Check box changed");
	var firstTextBoxValue="";
	var i=0;
	$('#example').find('input.next_due_date').each(function(){
		if(i==0)
		{
			firstTextBoxValue=$(this).val();
		}
		else
		{
			$(this).val(firstTextBoxValue);
		}
		$(this).id;
		i++;
		//console.log($(this).val()+"ID="+$(this).ID);
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
    	<h3>Generate Next Due Date</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail2">Company</label>
            <select name="company" id="company" class="form-control drop_down" >
                <option value="">Select Company</option>
                <?php $Country=mysql_query("SELECT DISTINCT A.cust_id as cust_id, 
											C.Company_Name as Company_Name, A.callingdata_id
											FROM tbl_customer_master as A
											INNER JOIN tblcallingdata as C 
											ON A.callingdata_id = C.id ORDER BY C.Company_Name");
				 	  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['cust_id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
                <?php } ?>
            </select>
        </div>
      </div> 
	  <div id="dvShow" class="col-md-12">
		<!-- this dvShow shows the Data of devices from Ajax request -->
	  </div>
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!-- this division shows the Data of devices from Ajax request -->
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
<!--Javascript-->
<script src="js/bootstrap.min.js"></script>
</body>
</html>