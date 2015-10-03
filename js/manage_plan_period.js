// JavaScript Document
function validate(obj){
	if(obj.plan_period.value == "")
	{
	alert ("Please provide Plan Period");
	obj.plan_period.focus();
	return false;
	}
}