// JavaScript Document
function ShowByBranch()
	{
		branch = document.getElementById("branch").value;	
		url="ajaxrequest/show_ticket_branch_confirmation.php?branch="+branch+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,branch,"getResponseByBranch");
	}
 
	function getResponseByBranch(str){
	document.getElementById('divassign').innerHTML=str;
	}