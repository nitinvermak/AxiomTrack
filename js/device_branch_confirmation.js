// JavaScript Document
function ShowByBranch()
	{
		branch = document.getElementById("branch").value;	
		url="ajaxrequest/show_branch_device_confirmation.php?branch="+branch+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,branch,"getResponseUnassignedStock");
	}
 
	function getResponseUnassignedStock(str)
	{
	//alert(str);
	document.getElementById('divassign').innerHTML=str;
	}