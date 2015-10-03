// JavaScript Document
function callCity(state_id){ 
	url="ajaxrequest/getCity1.php?state_id="+state_id+"&City=<?php echo $result['City'];?>&token=<?php echo $token;?>";
	//alert(url);
	xmlhttpPost(url,state_id,"getresponsecity");
	callcat=document.getElementById('callingcat').value;
	st=document.getElementById('state').value;
	ct=document.getElementById('city').value;
	url="ajaxrequest/getgrid.php?state_id="+st+"&city="+ct+"&callcat="+callcat+"&token=<?php echo $token;?>";
//	alert(url);
	xmlhttpPost(url,st,"getresponsegrid");
	}
	
	function getresponsecity(str){
	//alert(str);
	document.getElementById('divcity').innerHTML=str;
	//document.getElementById('area1').
	//document.getElementById("area1").innerHTML = "";
	//document.getElementById("divpincode").innerHTML = "";
	}
	function callGrid()
	{
	callcat=document.getElementById('callingcat').value;
	st=document.getElementById('state').value;
	ct=document.getElementById('city').value;
	url="ajaxrequest/getgrid.php?state_id="+st+"&city="+ct+"&callcat="+callcat+"&token=<?php echo $token;?>";
//	alert(url);
	xmlhttpPost(url,st,"getresponsegrid");
	}
	
function getresponsegrid(str){
	//alert(str);
	document.getElementById('divassign').innerHTML=str;
	//document.getElementById('area1').
	//document.getElementById("area1").innerHTML = "";
	//document.getElementById("divpincode").innerHTML = "";
	}
	//show assign contacts
	function ShowContact()
	{
		branch = document.getElementById("branch").value;	 
		url="ajaxrequest/show_assigned_contact.php?branch="+branch+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,branch,"getResponseAssignContact");
	}
 
	function getResponseAssignContact(str){
		/*alert(str);*/
		document.getElementById('divassign').innerHTML=str;
	}
