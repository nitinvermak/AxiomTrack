/*
Created on 4:36 PM 5/12/2009
this file has a common function to submit any form
using Ajax by POST Method

*/
var http_request = false; // this variable holds the obj to the server response
var add_type = "";
/*
** function makePOSTRequest is use as default function to
communicate with server, passed parameters are
url which has to b execute and parameters passsed to the URL
*/
function makePOSTRequest(url, parameters) 
{
  http_request = false;
  if (window.XMLHttpRequest) 
  { // Mozilla, Safari,...
	 http_request = new XMLHttpRequest();
	 if (http_request.overrideMimeType) 
	 {
		// set type accordingly to anticipated content type
		//http_request.overrideMimeType('text/xml');
		http_request.overrideMimeType('text/html');
	 }
  } 
  else if (window.ActiveXObject) 
  { // IE
	 try 
	 {
		http_request = new ActiveXObject("Msxml2.XMLHTTP");
	 } 
	 catch (e) 
	 {
		try 
		{
		   http_request = new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch (e) 
		{}
	 }
  }
  if (!http_request) 
  {
	 alert('Cannot create XMLHTTP instance');
	 return false;
  }
  //alert("at"+parameters.substr(parameters.indexOf("add_type")+parameters.strlen,3))
  var arr  = parameters.split("&");
  var arr1 = arr[1].split("=");
  if(arr1[1]=='to' || arr1[1]=='addIssue' || arr1[1]=='issue_response' || arr1[1]=='plan_edit' )
  {
	   http_request.onreadystatechange	=	handleResponseFinal;
  }
  else if(arr1[1]=='cc')
  {
	   http_request.onreadystatechange	=	handleResponseFinalCC;
  }
  else if(arr1[1]=='deliverable')
  {
	  http_request.onreadystatechange = handleResponse_DT;
  }
  else if(arr1[1]=='last_version')
  {
	  http_request.onreadystatechange = handleResponse_LV;
  }
  
  else
  {
	  http_request.onreadystatechange = handleResponse;
  }
  
  http_request.open('POST', url, true);
  http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http_request.setRequestHeader("Content-length", parameters.length);
  http_request.setRequestHeader("Connection", "close");
  http_request.send(parameters);
}