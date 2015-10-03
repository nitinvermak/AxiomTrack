// JavaScript Document
function validate(obj)
	{
		if(obj.state.value == "")
		{
			alert("Please Select State");
			obj.state.focus();
			return false;
		}
		if(obj.district.value == "")
		{
			alert("Please Provide District");
			obj.district.focus();
			return false;
		}
	}