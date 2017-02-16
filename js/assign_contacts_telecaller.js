// JavaScript Document
function ShowbyCategory()
	{   
	    callingcat = document.getElementById("callingcat").value;
		//alert(branch);
		url="ajaxrequest/assigncontacts_branch_telecaller.php?callingcat="+callingcat+"&token=<?php echo $token;?>";
		//alert(url);
		xmlhttpPost(url,callingcat,"getResponseUnassignedStock");
	}
	function ShowbyAssignContacts()
	{   
	    callingcat = document.getElementById("callingcat").value;
		/*alert(callingcat);*/
		url="ajaxrequest/show_assign_contacts_branch_telecaller.php?callingcat="+callingcat+"&token=<?php echo $token;?>";
		//alert(url);
		xmlhttpPost(url,callingcat,"getResponseUnassignedStock");
	} 
	function getResponseUnassignedStock(str){

	document.getElementById('divassign').innerHTML=str;
	
	}