function validate(obj)
	{
		if(obj.company_name.value == "")
		{
		alert("Please provide Branch Name");
		obj.company_name.focus();
		return false;
		}
		if(obj.country.value == "")
		{
		alert("Please Select Country");
		obj.country.focus();
		return false;
		}
		if(obj.state.value == "")
		{
		alert("Please Select State");
		obj.state.focus();
		return false;
		}
		if(obj.district.value == "")
		{
		alert("Please Select District");
		obj.district.focus();
		return false;
		}
		if(obj.city.value == "")
		{
		alert("Please Select City");
		obj.city.focus();
		return false;
		}
		if(obj.area.value == "")
		{
		alert("Please Select Area");
		obj.area.focus();
		return false;
		}
		if(obj.pin_code.value == "")
		{
		alert("Please Provide Pincode");
		obj.pin_code.focus();
		return false;
		}
		if(obj.address.value == "")
		{
		alert ("Please provide Address");
		obj.address.focus();
		return false;
		}
		if(obj.contact_person.value == "")
		{
		alert("Please provide Contact Person");
		obj.contact_person.focus();
		return false;
		}
		if(obj.contact_no.value == "")
		{
		alert("Please provide Contact No.");
		obj.contact_no.focus();
		return false;
		}
		if(obj.company_type.value == "")
		{
		alert("Please provide Branch Type");
		obj.company_type.focus();
		return false;
		}
	}
