<script>
/*file created 11:00 AM 1/16/2009 :Rajani*/
// This function is used for server side action
//file used in survillence audit to select all circle related to slected region
function ajaxCircle_Region(id)
{
var dv_circle = document.getElementById("dv_circle")
var dv_circle_default = document.getElementById("dv_circle_default")
//alert(document.getElementById("hdn_site").value)
var xmlHttp;
var url="ajax_circle_rgn.php?rgn_circle_id="+id;
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
			  document.getElementById("dv_circle").innerHTML = text+"<span class='rightnavtxt'>* </span>";
		  }
	  //alert(document.getElementById("site_id").option)
      }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
  }

  </script>