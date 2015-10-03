<script language="javascript">
function plan_delete(plan_id)
{

 	if(confirm("Are you sure want to delete this plan"))
	{
		window.location.href='project_plan.php?plan_id='+plan_id+'&Action=del';
		return true;
	} 
	else
	{
		return false;
	} 
}



function plan_close(plan_id)
{

 	if(confirm("Are you sure want to close this plan"))
	{
		window.location.href='project_plan.php?plan_id='+plan_id+'&Action=close';
		return true;
	} 
	else
	{
		return false;
	}
}

function plan_submit()
{
    var obj=document.frm_plan_add;
	
	if(obj.plan_title.value=="")
	{
		alert("Please enter plan title");
		obj.plan_title.focus();
		return false;
	} else if(obj.plan_activity.value=="")
	{
		alert("Please enter plan title");
		obj.plan_activity.focus();
		return false;
	} else if(obj.plan_start_date.value=="")
	{
		alert("Please enter plan start date");
		obj.plan_start_date.focus();
		return false;
	} else if(obj.plan_end_date.value=="")
	{
		alert("Please enter plan end date");
		obj.plan_end_date.focus();
		return false;
	} else if(obj.plan_resources.value=="")
	{
		alert("Please enter Stakeholders/Resources");
		obj.plan_resources.focus();
		return false;
	} else if(obj.plan_dependencies.value=="")
	{
		alert("Please enter Dependencies");
		obj.plan_dependencies.focus();
		return false;
	} else if(obj.plan_milestones.value=="")
	{
		alert("Please enter Milestones");
		obj.plan_milestones.focus();
		return false;
	} else if(obj.plan_deliverables.value=="")
	{
		alert("Please enter Deliverables");
		obj.plan_deliverables.focus();
		return false;
	}  		  	  	  
}

function plan_reset()
{
var obj=document.frm_plan_add;
obj.plan_title.value='';
obj.plan_activity.value='';
obj.plan_start_date.value='';
obj.plan_end_date.value='';
obj.plan_resources.value='';
obj.plan_dependencies.value='';
obj.plan_milestones.value='';
obj.plan_deliverables.value='';
}

// This function is used for server side action in Manage Project Activity on user's Level

function ajaxFunction(plan_id,title,id,sid)
{
var xmlHttp;
var url="ajax_user_plan.php?plan_edit_id="+plan_id;
if(sid!="")
{
  url += "&sid="+sid;
}

try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    try
      {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    catch (e)
      {
      alert("Your browser does not support AJAX!");
      return false;
      }
    }
  }
  xmlHttp.onreadystatechange=function()
    {
    if(xmlHttp.readyState==4)
      {
	   if(id!='')
	   {
		   document.getElementById('prj_al_plan_plan_id').style.display="none"
		   document.getElementById('prj_al_plan_plan_id_txt').style.display="block"
		   document.getElementById('prj_al_plan_plan_id_txt').value = title
		   document.getElementById('hdn_edit_plan_id').value = id
		   document.getElementById('hdn_plan_id').value = plan_id
		   document.getElementById('plan_detail').style.display="block"
		   document.getElementById('plan_detail').innerHTML = xmlHttp.responseText;
		   var status = document.getElementById("hdn_change_status").value;
		   if(status=='Completed')
			{
				var enddate = document.getElementById("hdn_enddate").value; 
				document.getElementById('tbl_date').style.display="block"
			}
			
			if(status=='Re-open')
			{
			  document.getElementById('date_link2').style.display="block";
			  document.getElementById('tbl_date').style.display="none";
			  document.getElementById('tbl_reason').style.display="none";
			  document.getElementById('prj_al_plan_completion_date').value="";
			}
		}
		
		
      }
    }
    xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
  }
</script>