function chkcontactform(obj){
	if(obj.first_name.value == ""){
		alert('Please Provide First Name');	
		obj.first_name.focus();
		return false;
	}
	if(obj.last_name.value = ""){
		alert('Please Provide Last Name');
		obj.last_name.focus();
		return false;
	}
	if(obj.company.value == ""){
		alert('Please Provide Company Name');
		obj.company.focus();
		return false;
	}
	if(obj.phone.value == ""){
		alert('Please Provide Phone No.');
		obj.phone.focus();
		return false;
	}
	if(obj.mobile.value == ""){
		alert('Please Provide Mobile No.');
		obj.mobile.focus();
		return false;
	}
	if(obj.email.value == ""){
		alert('Please Provide Email');
		obj.email.focus();
		return false;
	}
	if(obj.country.value == ""){
		alert('Please Select Country');
		obj.country.focus();
		return false;
	}
	if(obj.state.value == ""){
		alert('Please Select State');
		obj.state.focus();
		return false;
	}
	if(obj.district.value == ""){
		alert('Please Select District');
		obj.district.focus();
		return false;
	}
	if(obj.city.value == ""){
		alert('Please Select City');
		obj.city.focus();
		return false;
	}
	if(obj.pin_code.value == ""){
		alert('Please Provide Pincode');
		obj.pin_code.focus();
		return false;
	}
	if(obj.Address.value == ""){
		alert('Please Provide Address');
		obj.Address.focus();
		return false;
	}
	if(obj.telecaller.value == ""){
		alert('Please Select Telecaller');
		obj.telecaller.focus();
		return false;
	}
	if(obj.datasource.value == ""){
		alert('Please Select Data Source');
		obj.datasource.focus();
		return false;
	}
	if(obj.calling_products.value == ""){
		alert('Please Selct Calling Product');
		obj.calling_products.focus();
		return false;
	}
	if(obj.callingdate.value == ""){
		alert('Please Provide Calling Date');
		obj.callingdate.focus();
		return false;
	}
	if(obj.model.value == ""){
		alert('Please Select Model');
		obj.model.focus();
		return false;
	}
	if(obj.customer_type.value == ""){
		alert('Please Select Customer Type');
		obj.customer_type.focus();
		return false;
	}
	if(obj.p_device_rent.value == ""){
		alert('Please Select Device Rent');
		obj.p_device_rent.focus();
		return false;
	}
	if(obj.payment_type.value == ""){
		alert('Please Select Payment Type');
		obj.payment_type.focus();
		return false;
	}
	if(obj.no_of_vehicles.value == ""){
		alert('Please Provide No. of Vehicle');
		obj.no_of_vehicles.focus();
		return false;
	}
	/*if(obj.follow_date.value == ""){
		alert('Please Provide Follow-up Date');
		obj.follow_date.focus();
		return false;
	}*/
}
function customerType(){
	if(customer_type.value == 2){
		/*alert('Customer Type Rent');*/
		p_device_amt.disabled = true;
		installment_amt.disabled = true;
	}
	else if(customer_type.value == 1){
		installment_amt.disabled = true;
		p_device_amt.disabled = false;
	}
	else{
		p_device_amt.disabled = false;
		installment_amt.disabled = false;
	}
}
