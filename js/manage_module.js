// JavaScript Document
function validate(obj){
	if(obj.moduleName.value == "")
	{
	alert ("Please provide Module Name");
	obj.moduleName.focus();
	return false;
	}
}