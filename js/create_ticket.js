// JavaScript Document
function divshow(strval)
{
	if(strval=="1")
	{
		document.getElementById("service_provider").style.display = "";
	}
	else
	{
		document.getElementById("service_provider").style.display = "none";
	}

}

function getXMLHTTP() {
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function getState(product) {		
		
		var strURL="ajaxrequest/findrquest.php?product="+product;
		/*alert(product);*/
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('statediv').innerHTML=req.responseText;
						document.getElementById('citydiv').innerHTML='<select name="city">'+
						'<option>Select City</option>'+
				        '</select>';						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	function getCity(countryId,stateId) {		
		var strURL="ajaxrequest/findrquest.php?country="+countryId+"&state="+stateId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('citydiv').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}
// ticket form validate
function chkcontactform(obj)
{
	if(obj.orgranization.value == "")
	{
		alert("Please Select Organization");
		obj.orgranization.focus();
		return false;
	}
	if(obj.product.value == "")
	{
		alert("Please Select Product");
		obj.product.focus();
		return false;
	}
	if(obj.request.value == "")
	{
		alert("Please Select Request Type");
		obj.request.focus();
		return false;
	}
	if(obj.des.value == "")
	{
		alert("Please Provide Description");
		obj.des.focus();
		return false;
	}
	if(obj.date_time.value == "____/__/__ __:__")
	{
		alert("Please Provide Appointment DateTime ");
		obj.date_time.focus();
		return false;
	}
}
// end