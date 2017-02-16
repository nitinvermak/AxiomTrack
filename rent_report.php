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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>

<script type="text/javascript">
// send ajax request when click submit
function getReport()
{
	$('.loader').show();
	$.post("ajaxrequest/rent_report_details.php?token=<?php echo $token;?>",
				{
					company : $('#company').val(),
					customerType : $('#customerType').val(),
					frq : $('#frq').val()
				},
					function(data){
						/*alert(data);*/
						$("#dvData").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});
}

function getReportmultiple()
{
	$('.loader').show();
	$.post("ajaxrequest/multiple_rent_report_details.php?token=<?php echo $token;?>",
				{
					company1 : $('#company1').val(),
					customerType1 : $('#customerType1').val(),
					frq1 : $('#frq1').val()
				},
					function(data){
						/*alert(data);*/
						$("#dvData").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});
}
// end
// export CSV
$(document).ready(function () {
	 console.log("HELLO")
            function exportTableToCSV($table, filename) {
				console.log("HELLO")
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')

                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character

                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';

                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';

                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                // For IE (tested 10+)
                if (window.navigator.msSaveOrOpenBlob) {
                    var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                        type: "text/csv;charset=utf-8;"
                    });
                    navigator.msSaveBlob(blob, filename);
                } else {
                    $(this)
                        .attr({
                            'download': filename
                            ,'href': csvData
                            //,'target' : '_blank' //if you want it to open in a new window
                    });
                }

                //------------------------------------------------------------
                // Helper Functions 
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){
                     
                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td'); 
                    if(!$cols.length) $cols = $row.find('th');  

                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table 
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();

                    return $text.replace('"', '""'); // escape double quotes

                }
            }


            // This must be a hyperlink
          $(document).on("click","#export", function(){
                // var outputFile = 'export'
                var outputFile = window.prompt("Please Enter the name your output file.") || 'report';
                outputFile = outputFile.replace('.csv','') + '.csv'
                 
                // CSV
                exportTableToCSV.apply(this, [$('#dvData > table'), outputFile]);
                
                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
         })
//end
// Div Hide and show
function individual() {
    document.getElementById("individual").style.display = "";
	document.getElementById("multiple").style.display = "none";
	
}

function multipleReprt() {
   document.getElementById("individual").style.display = "none";
   document.getElementById("multiple").style.display = "";
}
//End
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
    	<h3>Rent  Report</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <div class="col-md-12">
    	<div class="radio-inline">
        <label>
        <input type="radio" name="rdopt"  value="Individual"  checked="checked" id="single" onClick="individual()" /> 
                    Single </label>
        </div>
        <div class="radio-inline">
            <label>
            <input type="radio" name="rdopt"  value="multiple"   id="single" onClick="multipleReprt()" /> 
                    Multiple </label>
        </div>
    </div>
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12" id="individual">
      <h4>Individual</h4>
      	<table class="form-field" width="100%">
         <tr>
         <td width="10%"><strong>Company*</strong></td>
         <td width="13%">
             <select name="company" id="company" class="form-control drop_down-sm">
               <option value="0">All</option>
               <?php 
               $branch_sql= "SELECT B.cust_id as custId, A.Company_Name as company, A.Last_Name as lname 
							 from tblcallingdata as A 
							 INNER JOIN tbl_customer_master as B 
							 ON A.id = B.callingdata_id 
							 ORDER by A.Company_Name";
               $Country = mysql_query($branch_sql);					
               while($resultCountry=mysql_fetch_assoc($Country)){
               ?>
               <option value="<?php echo $resultCountry['custId']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['company'])); ?></option>
               <?php } ?>
             </select>         </td>
         <td width="12%"><strong>Customer Type*</strong></td>
         <td width="14%">
         	<select name="company" id="company" class="form-control drop_down-sm">
               <option value="0">All</option>
               <?php 
               $branch_sql= "SELECT * FROM `tbl_customer_type` ORDER BY `customer_type`";
               $Country = mysql_query($branch_sql);					
               while($resultCountry=mysql_fetch_assoc($Country)){
               ?>
               <option value="<?php echo $resultCountry['customer_type_id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['customer_type'])); ?></option>
               <?php } ?>
             </select>
         </td>
         <td width="14%" class="col-xs-1">&nbsp;</td>
         <td width="7%">&nbsp;</td>
         <td width="14%">&nbsp;</td>
         <td width="16%"></td>
         </tr>
      	 <tr>
         <td><strong>Frq.*</strong></td>
         <td>
         <select name="frq" id="frq" class="form-control drop_down">
            <option value="0">All</option>
      		<?php $Country=mysql_query("select * from tbl_frequency");						
		  				   while($resultCountry=mysql_fetch_assoc($Country)){
    		?>
      		<option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($result['FrqId']) && $resultCountry['FrqId']==$result['FrqId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
      		<?php } ?>
        </select>
         </td>
         <td><strong><!--Assign Status*--></strong></td>
         <td><input type="button" name="submit" value="Submit" onClick="getReport();" class="btn btn-primary btn-sm pull-left"/></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
      	 <td>&nbsp;</td>
      	 </tr>
      	 <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
      	 <tr>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
    	   </tr>
         </table>
      </div> 
      <div class="col-md-12" id="multiple" style="display:none">
      <h4>Mutiple</h4>
      	<table class="form-field" width="100%">
         <tr>
         <td width="10%"><strong>Company*</strong></td>
         <td width="13%">
             <select name="company" id="company1" class="form-control drop_down-sm">
               <option value="0">All</option>
               <?php 
               $branch_sql= "SELECT B.cust_id as custId, A.Company_Name as company, A.Last_Name as lname 
							 from tblcallingdata as A 
							 INNER JOIN tbl_customer_master as B 
							 ON A.id = B.callingdata_id 
							 ORDER by A.Company_Name";
               $Country = mysql_query($branch_sql);					
               while($resultCountry=mysql_fetch_assoc($Country)){
               ?>
               <option value="<?php echo $resultCountry['custId']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['company'])); ?></option>
               <?php } ?>
             </select>         </td>
         <td width="12%"><strong>Customer Type*</strong></td>
         <td width="14%">
         	<select name="customerType1" id="customerType1" class="form-control drop_down-sm">
               <option value="0">All</option>
               <?php 
               $branch_sql= "SELECT * FROM `tbl_customer_type` ORDER BY `customer_type`";
               $Country = mysql_query($branch_sql);					
               while($resultCountry=mysql_fetch_assoc($Country)){
               ?>
               <option value="<?php echo $resultCountry['customer_type_id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['customer_type'])); ?></option>
               <?php } ?>
             </select>
         </td>
         <td width="14%" class="col-xs-1">&nbsp;</td>
         <td width="7%">&nbsp;</td>
         <td width="14%">&nbsp;</td>
         <td width="16%"></td>
         </tr>
      	 <tr>
         <td><strong>Frq.*</strong></td>
         <td>
         <select name="frq1" id="frq1" class="form-control drop_down">
            <option value="0">All</option>
      		<?php $Country=mysql_query("select * from tbl_frequency");						
		  				   while($resultCountry=mysql_fetch_assoc($Country)){
    		?>
      		<option value="<?php echo $resultCountry['FrqId']; ?>" <?php if(isset($result['FrqId']) && $resultCountry['FrqId']==$result['FrqId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['FrqDescription'])); ?></option>
      		<?php } ?>
        </select>
         </td>
         <td><strong><!--Assign Status*--></strong></td>
         <td><input type="button" name="submit" value="Submit" onClick="getReportmultiple();" class="btn btn-primary btn-sm pull-left"/></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
      	 <td>&nbsp;</td>
      	 </tr>
      	 <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
      	 <tr>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
      	   <td>&nbsp;</td>
    	   </tr>
         </table>
      </div> 
      <div id="dvData" class="col-md-12 table-responsive assign_grid">
      	
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
<!--Javascript-->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>