// JavaScript Document
function ShowPlans()
	{   
	    provider = document.getElementById("provider").value;	 
		/*alert(provider);*/
		url="ajaxrequest/show_sim_plans.php?provider="+provider+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,provider,"getPlans");
	}
function getPlans(str){
	document.getElementById('showPlan').innerHTML=str;
	}


function ShowPlans2()
	{   
	    provider2 = document.getElementById("provider2").value;	 
		/*alert(provider2);*/
		url="ajaxrequest/show_sim_plans2.php?provider2="+provider2+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,provider2,"getPlans2");
	}
function getPlans2(str){
	document.getElementById('showPlan2').innerHTML=str;
	}
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
	if (obj.provider.value=="")
	{
		alert("Please Select Provider");
		obj.provider.focus();
		return false;
	}
	if(obj.plan1.value == "")
	{
		alert("Please Select Plan");
		obj.plan1.focus();
		return false;
	}
	if(obj.state1.value == "")
	{
		alert("Please Select State");
		obj.state1.focus();
		return false;
	}
	if(obj.date.value == "")
	{
		alert("Please Provde Date");
		obj.date.focus();
		return false;
	}
	
	if(obj.sim.value == "")
	{
		alert("Please provide Sim No.");
		obj.sim.focus();
		return false;
	}
	if(obj.mobile.value == "")
	{
		alert("Please provide Mobile No.");
		obj.mobile.focus();
		return false;
	}
	
	document.getElementById("chekpage").value="1";

}
function chkupload(obj1)
{
	if(obj1.provider2.value == "")
	{
		alert("Please Select Provider");
		obj1.provider2.focus();
		return false;
	}
	if(obj1.plan2.value=="")
	{
		alert("Please Select Plan");
		obj1.plan2.focus();
		return false;
	}
	if(obj.state3.value == "")
	{
		alert("Please Select State");
		obj.state3.focus();
		return false;
	}
	if(obj.date2.value == "")
	{
		alert("Please provide Purchase of Date");
		obj.date2.focus();
		return false;
	}
}
//Import file Validate
function chkupload(obj)
{
	if(obj.provider2.value == "")
	{
		alert("Please Select Provider");
		obj.provider2.focus();
		return false;
	}
	if(obj.plan2.value == "")
	{
		alert("Please Select Plan");
		obj.plan2.focus();
		return false;
	}
	if(obj.state3.value == "")
	{
		alert("Please Select State");
		obj.state3.focus();
		return false;
	}
	if(obj.date2.value == "")
	{
		alert("Please provide Date");
		obj.date2.focus();
		return false;
	}
	if(obj.contactfile.value == "")
	{
		alert("Please Select file");
		obj.contactfile.focus();
		return false;
	}
}