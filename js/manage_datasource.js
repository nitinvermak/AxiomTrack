// JavaScript Document
function validate(obj){
	if(obj.datasource.value == "")
	{
	alert ("Please Provide Data Source Value");
	obj.datasource.focus();
	return false;
	}
}