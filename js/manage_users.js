function chkcontactform(obj)
{
	if(obj.empId.value =="")
	{
		alert("Please Enter Employee Id");
		obj.empId.focus();
		return false;
	}
	var emp_id= /^[0-9]*$/;
	if(emp_id.test(obj.empId.value) == false)
	{
	alert("Please provide valid Employee Id");
	obj.empId.focus();
	return false;
	}
	if (obj.first_name.value=="")
	{
		alert("Please Enter First Name");
		obj.first_name.focus();
		return false;
	}
	if (obj.last_name.value=="")
	{
		alert("Please Enter Last Name");
		obj.last_name.focus();
		return false;
	}
	if (obj.dob.value=="")
	{
		alert("Please Enter Date of Birth");
		obj.dob.focus();
		return false;
	}
	if (obj.contact_no.value=="")
	{
		alert("Please Enter Phone or Mobile no");
		obj.contact_no.focus();
		return false;
	}
	var phoneno = /(^\d{10}$)|(^\d{10}-\d{4}$)/;
	if(phoneno.test(obj.contact_no.value)== false)
	{
	alert("Please provide valid Contact No.");
	obj.contact_no.focus();
	return false;
	}
	if (obj.email.value=="")
	{
		alert("Please Enter Email");
		obj.email.focus();
		return false;
	}
	var reg = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
  	if (reg.test(obj.email.value)== false) 
     {
          alert("Please provide valid Email");
          obj.email.focus();
          return false;
     }
	if(obj.doj.value=="")
	{
		alert("Please Enter Date of Joining");
		obj.doj.focus();
		return false;
	}
	if(obj.address.value== "")
	{
		alert("Please Enter Address");
		obj.address.focus();
		return false;
	}
	if(obj.state.value=="")
	{
		alert("Please Select State");
		obj.state.focus();
		return false;
	}
	if(obj.city.value=="")
	{
		alert("Please Select City");
		obj.city.focus();
		return false;
	}
	if(obj.area.value=="")
	{
		alert("Please Select Area");
		obj.area.focus();
		return false;
	}
	if(obj.user_type.value=="")
	{
		alert("Please Select User Type");
		obj.user_type.focus();
		return false;
	}
	if(obj.user_type.value!="1")
	{
		if(obj.branch_id.value=="")
		{
			alert("Please Select Branch");
			obj.branch_id.focus();
			return false;
		}
	}
	if(obj.user_name.value=="")
	{
		alert("Please Enter User Name");
		obj.user_name.focus();
		return false;
	}
	var uname = /^[a-zA-Z0-9]{8,15}$/;
	if (uname.test(obj.user_name.value)== false) 
    {
          alert("Please provide Username  between 8 to 15 characters");
          obj.user_name.focus();
          return false;
    }
	if(obj.Password.value=="")
	{
		alert("Please Enter Password");
		obj.Password.focus();
		return false;
	}
	re = /[0-9]/;
	if(!re.test(obj.Password.value)) {
	alert("Error: Password must contain at least one number (0-9)");
	obj.Password.focus();
	return false;
	}
	re = /[a-z]/;
	if(!re.test(obj.Password.value)) {
	alert("Error: Password must contain at least one lowercase letter (a-z)");
	obj.Password.focus();
	return false;
	}
	re = /[A-Z]/;
	if(!re.test(obj.Password.value)) {
	alert("Error: Password must contain at least one uppercase letter (A-Z)");
	obj.Password.focus();
	return false;
	}
	obj.Password.value=base64.encode(obj.Password.value); 
}
