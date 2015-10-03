// JavaScript Document
function validate(obj)
	{
		if(obj.country.value == "")
		{
			alert("Please Select country");
			obj.country.focus();
			return false;
		}
		if(obj.state_name.value == "")
		{
			alert("Please Provide State");
			obj.state_name.focus();
			return false;
		}
	}