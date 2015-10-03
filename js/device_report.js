// JavaScript Document
function SearchRecords()
	{   
	    search_box = document.getElementById("search_box").value;
		/*alert(search_box);*/
		url="ajaxrequest/device_report.php?search_box="+search_box+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,search_box,"GetRecords");
	}
	function GetRecords(str){
	document.getElementById('divassign').innerHTML=str;
	}