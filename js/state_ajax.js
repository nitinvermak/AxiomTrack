<script>
/*file created 3:35 PM 12/10/2008 :Rajani*/
// This function is used for server side action 
function ajaxState(id,name)
{
var hdn_state = document.getElementById("hdn_state").value
var tbl_state = document.getElementById("tbl_state")

//alert(document.getElementById("hdn_state").value)
var xmlHttp;
var url="ajax_state.php";

if(hdn_state=='region-state')
	url += "?region_state_id="+id;
if(name!='undefined')
   url += "&pname="+name;
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
	  text = xmlHttp.responseText;
		  if(text.length>3)
		  {
			  tbl_state.style.display = 'block';
			  document.getElementById("dv_state").innerHTML = text+"<span class='rightnavtxt'>* </span>";
		  }
	  //alert(document.getElementById("state_id").option)
      }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
  }

  </script>