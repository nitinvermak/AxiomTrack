// JavaScript Document
function showUnassignedStock()
	{   
	    date = document.getElementById("date").value;
		/*alert(date);*/
		url="ajaxrequest/show_ticket_unassigned.php?date="+date+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,date,"getResponseticket");
	}
function showAssignedStock()
	{
		date = document.getElementById("date").value;
		/*alert(date);*/
		url="ajaxrequest/show_ticket_assigned.php?date="+date+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,date,"getResponseticket");
	} 
function getResponseticket(str){
	document.getElementById('divassign').innerHTML=str;
	}