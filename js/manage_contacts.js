// JavaScript Document
function singlecontact() {
    document.getElementById("contactform").style.display = "";
	document.getElementById("contactUpload").style.display = "none";
	
}

function multiplecontact() {
//alert("test");
   document.getElementById("contactform").style.display = "none";
document.getElementById("contactUpload").style.display = "";
}
function chkcontactform(obj)
{
	if(obj.first_name.value == "")
	{
		alert("Please Provide First Name");
		obj.first_name.focus();
		return false;
	}
	if(obj.last_name.value == "")
	{
		alert("Please Provide Last Name");
		obj.last_name.focus();
		return false;
	}
	if(obj.company.value == "")
	{
		alert("Please Provide Company Name");
		obj.company.focus();
		return false;
	}
	if (obj.phone.value=="" && obj.mobile.value=="")
	{
		alert("Please Enter Phone or Mobile no");
		obj.phone.focus();
		return false;
	}
	var phoneno = /(^\d{10}$)|(^\d{10}-\d{4}$)/;
	if(phoneno.test(obj.phone.value)== false)
	{
	alert("Please provide valid Phone No.");
	obj.phone.focus();
	return false;
	}
	if(obj.mobile.value == "")
	{
		alert("Please provide Mobile No.");
		obj.mobile.focus();
		return false;
	}
	if(obj.email.value == "")
	{
		alert("Please Provide Email");
		obj.email.focus();
		return false;
	}
	if(obj.address.value == "")
	{
		alert("Please Provide Address");
		obj.address.focus();
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
		alert("Please Select city");
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
	if(obj.datasource.value == "")
	{
		alert("Please Select Data Source");
		obj.datasource.focus();
		return false;
	}
	document.getElementById("chekpage").value="1";

}
/*function chkupload(obj1)
{
	if(obj1.datasource1.value == "")
	{
		alert("Please provide datasource");
		obj1.datasource1.focus();
		return false;
	}
	if(obj1.contactfile.value=="")
	{
		alert("Please Select file");
		obj1.contactfile.focus();
		return false;
	}
	else if(obj1.contactfile.value.substring(obj1.contactfile.value.length-3,obj1.contactfile.value.length)!= "xls")
	{
		alert ("Invalid file");
		return false;
	}
}
*/
