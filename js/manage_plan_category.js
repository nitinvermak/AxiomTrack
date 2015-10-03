// JavaScript Document
function validate(obj){
	if(obj.plan_category.value == "")
	{
	alert ("Please provide Plan Category");
	obj.plan_category.focus();
	return false;
	}
}