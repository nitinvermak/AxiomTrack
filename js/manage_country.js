// JavaScript Document
function validate(obj){
	if(obj.country.value == "")
	{
	alert ("Please provide Country Name");
	obj.country.focus();
	return false;
	}
}