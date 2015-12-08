

<?php
error_reporting(-1);
include_once('headerUpper.php');

$permissionJoin= 'SELECT
				  A.moduleName as modulePageName,
				  A.displayModuleName as displayModuleName,
				  A.parentId as moduleParentId,
				  D.displayname as modCatDisplayName ,
				  C.parentName as subParentName
				  FROM `tblmodulename` as A 
				  Inner join tblusercategorymodulemapping AS B 
				  ON A.moduleId = B.moduleId and B.usercategoryId ='.$_SESSION['user_category_id'].'  
				  inner join tblmoduleparentname as C 
				  on C.parentId = A.parentId 
				  INNER JOIN tblmodulecategory as D 
				  on D.moduleCatId = A.moduleCatId
				  order by  A.moduleCatId ,  A.parentId';

//echo $permissionJoin; 

$perSql= mysql_query($permissionJoin);
if($_SESSION['user_category_id'] == 9)
{
echo '<div class="row" id="nav_bar">
	<div class="col-md-12">
    	 <div class="nav navbar-default">
          <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse">
          <ul class="nav  navbar-nav">
          <li style="border:0px;"><a href="pending_works.php?token='.$token.'">Home</a></li>  
          ';
}
else if($_SESSION['user_category_id'] == 5)
{
echo '<div class="row" id="nav_bar">
	<div class="col-md-12">
    	 <div class="nav navbar-default">
          <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse">
          <ul class="nav  navbar-nav">
          <li style="border:0px;"><a href="pending_works.php?token='.$token.'">Home</a></li>  
          ';
}
else
{
echo '<div class="row" id="nav_bar">
	<div class="col-md-12">
    	 <div class="nav navbar-default">
          <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse">
          <ul class="nav  navbar-nav">
          <li style="border:0px;"><a href="home.php?token='.$token.'">Home</a></li>  
          ';
}
$modCatDisplayNameTemp= ' ';
$modParentCatTemp = ' ';

$firstChange=0;
$SecondChange = 0;
$closeFlag = 0;
$maxRows= mysql_num_rows($perSql);


if(mysql_num_rows($perSql)>0){ 
	while($resultPer=mysql_fetch_assoc($perSql)){
		
		if (  $closeFlag == 1 && $resultPer['moduleParentId'] == 0){ // closes the Sub parent if the module becomes elemnt with no parent
			echo '</ul>
            </li>';
			//echo 'Sub parent ENDS1';
			$closeFlag = 0;
			$SecondChange =  0;
		}		

      
      if (($resultPer['modCatDisplayName'] != $modCatDisplayNameTemp)&& $firstChange ==0){
        //echo 'Module category changed-----'; 
        echo '<li class="dropdown">
              <a tabindex="0" data-toggle="dropdown" style="color:#fff">'.$resultPer['modCatDisplayName'].'
              <span class="caret"></span></a>';
        echo '<ul class="dropdown-menu drop_menu" role="menu">';        
        $firstChange =$firstChange+1;
        $modCatDisplayNameTemp =  $resultPer['modCatDisplayName']; 
      }



      if (($resultPer['modCatDisplayName'] != $modCatDisplayNameTemp)&& $firstChange !=0){
        echo '</ul>';
        echo '</li>';
       
        //echo 'Module category changed-----'; 
        echo '<li class="dropdown"><a tabindex="0" data-toggle="dropdown" style="color:#fff">'.$resultPer['modCatDisplayName'].'
           <span class="caret"></span></a>'; 
        echo '<ul class="dropdown-menu drop_menu" role="menu">';    
        $modCatDisplayNameTemp =  $resultPer['modCatDisplayName'];     
      
      }
      
        


      if ($resultPer['moduleParentId'] == 0){  // print those elements which are not having any parents  
				
		echo '<li><a tabindex="0" style="color:#fff" href="'.$resultPer['modulePageName'].'?token='.$token.'">'.
        $resultPer['displayModuleName'].'</a></li>';
      }
	  else{ // If the module needs to be printed in a sub parent		
		
		
		 
		if (($resultPer['moduleParentId'] != $modParentCatTemp)&& $closeFlag == 1){
			echo '</ul>
            </li>';
			//echo 'Sub parent ENDS2';
			$closeFlag = 0;
			$SecondChange =0;
		}
		
		
		if (($resultPer['moduleParentId'] != $modParentCatTemp)&& $SecondChange ==0){
			//echo 'Sub parent starts'; 
			echo '<li class="dropdown-submenu">
			<a tabindex="0" data-toggle="dropdown" style="color:#fff">'.$resultPer['subParentName'].'</a>
            <ul class="dropdown-menu">';
			$SecondChange = $SecondChange +1;
			$modParentCatTemp = $resultPer['moduleParentId'];
			$closeFlag = 1;			
		}

		if (($resultPer['moduleParentId'] != $modParentCatTemp)&& $SecondChange !=0){
			echo '</ul>
            </li>';
			$SecondChange =  0;
			$modParentCatTemp = $resultPer['moduleParentId']; 
			//echo 'Sub parent ENDS3'; 
			//echo 'Sub parent starts'; 
			echo '<li class="dropdown-submenu"><a tabindex="0" data-toggle="dropdown" style="color:#fff">'.$resultPer['subParentName'].'</a>
            <ul class="dropdown-menu">';
			$closeFlag = 1;
		}
		
		//This will print the elements in the parent
		echo '<li><a tabindex="0" style="color:#fff" href="'.$resultPer['modulePageName'].'?token='.$token.'">'.
        $resultPer['displayModuleName'].'</a></li>';	
		  
	  }
	 


      if($maxRows ==$firstChange ){
        echo '</ul>';
        echo '</li>';
      }


    

	
	}
}	
echo ' </ul> 
</div>
</div>	
</div>
</div>';


	
		
				  
				  
 

?>







 


<!--end navbar-->
