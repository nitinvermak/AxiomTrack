// JavaScript Document
function validate(obj)
	{
		if(obj.product.value == "")
		{
			alert('Please Select Product');
			obj.product.focus();
			return false;
		}
		if(obj.request_type.value == "")
		{
			alert('Please Provide Request Type');
			obj.request_type.focus();
			return false;
		}

	}