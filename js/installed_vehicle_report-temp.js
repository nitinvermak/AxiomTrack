// JavaScript Document
function SearchRecords()
	{   
	    search_box = document.getElementById("search_box").value;
		/*alert(search_box);*/
		url="ajaxrequest/installed_vehicle_report.php?search_box="+search_box+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,search_box,"GetRecords");
	}
	function GetRecords(str){
	document.getElementById('divassign').innerHTML=str;
	}
function ShowReport()
	{   
	    date = document.getElementById("date").value;
		dateto = document.getElementById("dateto").value;
		company = document.getElementById("company").value;
		reffered = document.getElementById("reffered").value;
		technician = document.getElementById("technician").value;
		/*alert(date);*/
		url="ajaxrequest/temp_vehicle_report_by_date.php?date="+date+"&dateto="+dateto+"&company="+company+"&reffered="+reffered+"&technician="+technician+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,date,"getResponse");
	}
function getResponse(str){
	document.getElementById('divassign').innerHTML=str;
	}
