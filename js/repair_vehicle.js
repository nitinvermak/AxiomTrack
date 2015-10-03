function ShowReport()
	{   
		company = document.getElementById("company").value;
		url="ajaxrequest/show_repair_vehicle.php?company="+company+"&token=<?php echo $token;?>";
		alert(url);
		xmlhttpPost(url,company,"getResponse");
	}
function getResponse(str){
	document.getElementById('divassign').innerHTML=str;
	}