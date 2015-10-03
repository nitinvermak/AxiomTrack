// JavaScript Document
function validate(obj){
	if(obj.status.value == "")
	{
	alert ("Please provide Status");
	obj.status.focus();
	return false;
	}
}