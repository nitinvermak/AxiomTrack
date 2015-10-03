// JavaScript Document
function ShowReport()
	{   
	    date = document.getElementById("date").value;
		dateto = document.getElementById("dateto").value;
		executive = document.getElementById("executive").value;
		branch = document.getElementById("branch").value;
		status = document.getElementById("status").value;
		/*alert(date);*/
		url="ajaxrequest/ticket_report.php?date="+date+"&dateto="+dateto+"&executive="+executive+"&branch="+branch+"&status="+status+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,date,"getResponse");
	}
function getResponse(str){
	document.getElementById('divassign').innerHTML=str;
	}