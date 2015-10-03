// JavaScript Document
function validate(obj){
	if(obj.serviceprovider.value == "")
	{
	alert ("Please provide Service Provider Name");
	obj.serviceprovider.focus();
	return false;
	}
}