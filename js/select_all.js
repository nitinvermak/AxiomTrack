<script>
/*
	function select_all_address:12:22 PM 1/8/2009:Rajani Gupta
	function select_all_address is used to select all addresses from address book at once
	passed parameter to the function checkboxes name to be select and the master check box name
	(check box on click of which all chec boxes should be check or uncheck), address type(required only in case of mail
	 where to and cc are two type of addresses)
	one out side function is use named as value_transaction which keeps track on the values to be added
	in the address field
*/
 function select_all_address(chk_name,master_chk_name,address_type)
 {
	// var master_chk_val holds the value(checked/uncheck) of master check box
	var master_chk_val = document.forms[0][master_chk_name].checked ;
	// var chk_len holds the total number of checkboxes
	var chk_len  = document.forms[0][chk_name].length;
	
	//alert(document.getElementById(chk_name).length)
	if(master_chk_val==true)
	{
		for(var i=0; i < chk_len; i++)
		{
			document.forms[0][chk_name][i].checked=true;
			chkbox_value = document.forms[0][chk_name][i].value;
			value_transaction(chkbox_value,true,address_type) ;
		}
	}
	else
	{
		for(var i=0; i < chk_len; i++)
		{
			document.forms[0][chk_name][i].checked=false; 
			chkbox_value = document.forms[0][chk_name][i].value;
			value_transaction(chkbox_value,false,address_type) ;
		}
	}
 }
</script>