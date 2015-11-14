// JavaScript Document
 function confirmdelete(obj)
 {
 	 if(obj.branch.value == "0" || obj.branch.value == "")
	 {
	 alert('Please Select Branch');
	 obj.branch.focus();
	 return false;
	 }
	 if(obj.technician_id.value == "")
	 {
	 alert('Please Select Technician');
	 obj.technician_id.focus();
	 return false;
	 }
 }
