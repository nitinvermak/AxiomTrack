// JavaScript Document
function validate(obj)
{
	if(obj.city.value == "")
	{
		alert("Please Select City");
		obj.city.focus();
		return false;
	}
	if(obj.area_name.value == "")
	{
		alert("Please provide Area");
		obj.area_name.focus();
		return false;
	}
}