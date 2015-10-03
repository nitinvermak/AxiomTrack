// JavaScript Document
function validate(obj){
	if(obj.user_category.value == "")
	{
	alert ("Please provide User Category");
	obj.user_category.focus();
	return false;
	}
	if(obj.description.value == "")
	{
	alert("Please provide Description");
	obj.description.focus();
	return false;
	}
}