// JavaScript Document

function chkcontactform(obj)
{
	if(obj.first_name.value == "")
	{
		alert('Please provide First Name');
		obj.first_name.focus();
		return false;
	}
	if(obj.last_name.value == "")
	{
		alert('Please provide Last Name');
		obj.last_name.focus();
		return false;
	}
	if(obj.company.value == "")
	{
		alert('Please provide Company Name');
		obj.company.focus();
		return false;
	}
	if(obj.phone.value == "" && obj.mobile.value == "")
	{
		alert('Please provide Phone or Mobile');
		obj.phone.focus();
		obj.mobile.focus();
		return false;
	}
	if(obj.Address.value == "")
	{
		alert('Please provide Address');
		obj.Address.focus();
		return false;
	}
	if(obj.area.value == "")
	{
		alert('Please provide Area');
		obj.area.focus();
		return false;
	}
	if(obj.city.value == "")
	{
		alert('Please provide Area');
		obj.city.focus();
		return false;
	}
	if(obj.state.value == "")
	{
		alert('Please provide State');
		obj.state.focus();
		return false;
	}
	if(obj.country.value == "")
	{
		alert('Please provide Country');
		obj.country.focus();
		return false;
	}
	if(obj.pincode.value == "")
	{
		alert('Please provide Pin Code');
		obj.pincode.focus();
		return false;
	}
	if(obj.callingdate.value == "")
	{
		alert('Please provide Calling Date');
		obj.callingdate.focus();
		return false;
	}
	if(obj.model.value == "")
	{
		alert('Please provide Model');
		obj.model.focus();
		return false;
	}
	if(obj.no_of_vehicles.value == "")
	{
		alert('Please provide No. of Vehicles');
		obj.no_of_vehicles.focus();
		return false;
	}
	if(obj.p_device_amt.value == "")
	{
		alert('Please provide New Purchase Device Amount');
		obj.p_device_amt.focus();
		return false;
	}
	if(obj.p_device_rent.value == "")
	{
		alert('Please provide New Purchase Device Rent');
		obj.p_device_rent.focus();
		return false;
	}
	if(obj.payment_type.value == "")
	{
		alert('Please provide Payment Type');
		obj.payment_type.focus();
		return false;
	}
	if(obj.device_rent.value == "")
	{
		alert('Please provide Rented Device Rent');
		obj.device_rent.focus();
		return false;
	}
	if(obj.installation_charges.value == "")
	{
		alert('Please provide Installation Charge');
		obj.installation_charges.focus();
		return false;
	}
	if(obj.c_device_rent.value == "")
	{
		alert("Please provide Customer Device Rent");
		obj.c_device_rent.focus();
		return false;
	}
	if(obj.c_installation_charges.value == "")
	{
		alert('Please provide Custormer Device Installation Charge');
		obj.c_installation_charges.focus();
		return false;
	}
	if(obj.follow_date.value =="")
	{
		alert('Please provide Follow-up Date');
		obj.follow_date.focus();
		return false;
	}
}