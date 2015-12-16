// JavaScript Document
 function confirmdelete(obj)
 {
	 if(obj.technician_id.value == "")
	 {
	 alert('Please Select Technician');
	 obj.technician_id.focus();
	 return false;
	 }
 }
