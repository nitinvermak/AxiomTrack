// JavaScript Document
function callCity(state_id){ 
	url="ajaxrequest/getCity.php?state_id="+state_id+"&City=<?php echo $result['City'];?>&token=<?php echo $token;?>";
	//alert(url);
	xmlhttpPost(url,state_id,"getresponsecity");
	}
	
	function getresponsecity(str){
	//alert(str);
	document.getElementById('divcity').innerHTML=str;
	//document.getElementById('area1').
	document.getElementById("area1").innerHTML = "";
	document.getElementById("divpincode").innerHTML = "";
	}

function callArea(city){ 
	url="ajaxrequest/getarea.php?city="+city+"&area=<?php echo $result['Area'];?>&token=<?php echo $token;?>";
	//alert(url);
	xmlhttpPost(url,city,"getresponsearea");
	}
	
	function getresponsearea(str){

	//alert(str);
	document.getElementById('divarea').innerHTML=str;
	document.getElementById("divpincode").innerHTML = "";

	}

function callPincode(area){ 
	url="ajaxrequest/getpincode.php?area="+area+"&city="+document.getElementById('city').value+"&pincode=<?php echo $result['Pin_code'];?>&token=<?php echo $token;?>";
	//alert(url);
	xmlhttpPost(url,area,"getresponsepincode");
	}
	
	function getresponsepincode(str){
	//alert(str);
	document.getElementById('divpincode').innerHTML=str;
	}
	
	function hidediv(usercat)
	{
	//alert(usercat);
	if(usercat=="1")
	{
	document.getElementById('notadmin').style.display="none";
	}
	else
	{
	document.getElementById('notadmin').style.display="";
	}
	}
function chkcontactform(obj)
{
	if(obj.first_name.value =="")
	{
		alert("Please provide First Name");
		obj.first_name.focus();
		return false;
	}
	if (obj.last_name.value=="")
	{
		alert("Please provide Last Name");
		obj.last_name.focus();
		return false;
	}
	if (obj.company.value=="")
	{
		alert("Please provide Company Name");
		obj.company.focus();
		return false;
	}
	if (obj.contact_no.value=="")
	{
		alert("Please Enter Phone or Mobile no");
		obj.contact_no.focus();
		return false;
	}
	var phoneno = /(^\d{10}$)|(^\d{10}-\d{4}$)/;
	if(phoneno.test(obj.contact_no.value)== false)
	{
	alert("Please provide valid Contact No.");
	obj.contact_no.focus();
	return false;
	}
	if (obj.email.value=="")
	{
		alert("Please provide Email");
		obj.email.focus();
		return false;
	}
	var reg = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
  	if (reg.test(obj.email.value)== false) 
     {
          alert("Please provide valid Email");
          obj.email.focus();
          return false;
     }
	if(obj.pan_no.value=="")
	{
		alert("Please provide Pan No");
		obj.pan_no.focus();
		return false;
	}
	if(obj.tin_no.value== "")
	{
		alert("Please provide Vat Tin No");
		obj.tin_no.focus();
		return false;
	}
	if(obj.service_tax.value == "")
	{
		alert("Please provide Service Tax No.");
		obj.service_tax.focus();
		return false;
	}
	if(obj.other.value == "")
	{
		alert("Please provide CST No.");
		obj.other.focus();
		return false;
	}
	if(obj.address.value == "")
	{
		alert("Please provide Address");
		obj.address.focus();
		return false;
	}
	if(obj.country.value=="")
	{
		alert("Please Select Country");
		obj.country.focus();
		return false;
	}
	if(obj.state.value=="")
	{
		alert("Please Select State");
		obj.state.focus();
		return false;
	}
	if(obj.city.value=="")
	{
		alert("Please Select City");
		obj.city.focus();
		return false;
	}
	if(obj.area.value =="")
	{
		alert ("Please Select Area");
		obj.area.focus();
		return false;
	}
	
}