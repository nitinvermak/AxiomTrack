<script>
/*file created 11:57 AM 12/18/2008 :Rajani*/
// This function is used for server side action
function ajaxCircle(id,name)
{
var hdn_circle = document.getElementById("hdn_circle").value
var tbl_circle = document.getElementById("tbl_circle")

//alert(document.getElementById("hdn_site").value)
var xmlHttp;
var url="ajax_circle.php";
if(hdn_circle=='site-circle')
	url += "?site_circle_id="+id;
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
			  tbl_circle.style.display = 'block';
			  document.getElementById("dv_circle").innerHTML = text+"<span class='rightnavtxt'>* </span>";
		  }
	  //alert(document.getElementById("state_id").option)
      }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
  }

  </script>