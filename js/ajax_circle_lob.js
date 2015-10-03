<script>
/*file created 12:12 PM 1/16/2009 :Rajani*/
// This function is used for server side action
//file used in survillence audit to select all lob related to slected circle
function ajaxCircle_Lob(id,combo_name)
{
var td_lob = document.getElementById("td_lob");
var xmlHttp;
var url="ajax_circle_lob.php?circle_id="+id+"&combo_lob="+combo_name;

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
	  td_lob.innerHTML = text;
      }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
  }

  </script>