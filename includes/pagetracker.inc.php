<table  width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
   <td height="20" class="content" align="right">Total Pages : <?=$numPages?>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?
//print $page." ".$numPages." fhghdf ".$txt_search;
$add ="";
if(isset($flag)&&$flag!="")
{
	$add .= "&flag=$flag";
}

if(isset($_POST['txt_search'])&&$_POST['txt_search']!='')
{
	$add .="&txt_search=$txt_search";
}
else
{
	$add ='';
}
if(!isset($page))
{
	if($numPages==1)
	{
		echo "<a class=\"clshrefdactive\" href='#'>First</a>&nbsp;&nbsp;";
		echo "<a class=\"clshrefdactive\" href='#'>Previous</a>&nbsp;&nbsp;";
		echo "<a class=\"clshrefdactive\" href='#'>Next</a>&nbsp;&nbsp;";
		echo "<a class=\"clshrefdactive\" href='#'>Last</a>&nbsp;&nbsp;";
	}
	else
	{
		echo "<a class=\"clshrefdactive\" href='?".$par."page=1".$add."'>First</a>&nbsp;&nbsp;";
		echo "<a class=\"clshrefdactive\" href='?".$par."page=1".$add."'>Previous</a>&nbsp;&nbsp;";
		echo "<a class=\"clshref\" href='?".$par."page=2".$add."'>Next</a>&nbsp;&nbsp;";
		echo "<a class=\"clshref\" href='?".$par."page=".$numPages.$add."'>Last</a>&nbsp;&nbsp;";
	}
}

if ($page > 1)
{
	echo "<a class=\"clshref\" href='?".$par."page=1".$add."'>First</a>&nbsp;&nbsp;";
	echo "<a class=\"clshref\" href='?".$par."page=".($page - 1).$add."'>Previous</a>&nbsp;&nbsp;";
	if ($page == $numPages)
	{
		echo "<a class=\"clshrefdactive\" href='#'>Next</a>&nbsp;&nbsp;";
		echo "<a class=\"clshrefdactive\" href='#'>Last</a>&nbsp;&nbsp;";
	}
}
if ($page==$numPages&&$page == 1)
{
	echo "<a class=\"clshrefdactive\" href='#'>First</a>&nbsp;&nbsp;";
	echo "<a class=\"clshrefdactive\" href='#'>Previous</a>&nbsp;&nbsp;";
	echo "<a class=\"clshrefdactive\" href='#'>Next</a>&nbsp;&nbsp;";
	echo "<a class=\"clshrefdactive\" href='#'>Last</a>&nbsp;&nbsp;";

	
}
if (isset($page)&&$page < $numPages)
{
	if ($page == 1)
	{
	
		echo "<a class=\"clshrefdactive\" href='#'>First</a>&nbsp;&nbsp;";
		echo "<a class=\"clshrefdactive\" href='#'>Previous</a>&nbsp;&nbsp;";
	}
	echo "<a class=\"clshref\" href='?".$par."page=".($page + 1).$add."'>Next</a>&nbsp;&nbsp;";
	echo "<a class=\"clshref\" href='?".$par."page=".$numPages.$add."'>Last</a>&nbsp;&nbsp;";
}
if (isset($page)&&$page > $numPages)
{
	header("location:".SITE_WS_PATH."plan/error_page.php?urlval=1");
	exit;
}
 ?>
 </td>
</tr>
</table>

