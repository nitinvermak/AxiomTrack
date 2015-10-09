

<?php
error_reporting(-1);
$permissionJoin= '
				  SELECT
          A.moduleName as modulePageName,
          A.displayModuleName as displayModuleName,
          A.parentId as moduleParentId,
          D.displayname as modCatDisplayName  
          FROM `tblmodulename` as A 
				  Inner join tblusercategorymodulemapping AS B 
				  ON A.moduleId = B.moduleId and B.usercategoryId ='.$_SESSION['user_category_id'].'  
				  inner join tblmoduleparentname as C 
				  on C.parentId = A.parentId 
				  INNER JOIN tblmodulecategory as D 
				  on D.moduleCatId = A.moduleCatId
				  order by  A.moduleCatId ,  A.parentId 
				  ';

//echo $permissionJoin; 

$perSql= mysql_query($permissionJoin);

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

$modCatDisplayNameTemp= ' ';
$firstChange=0;
$maxRows= mysql_num_rows($perSql);


if(mysql_num_rows($perSql)>0){ 
	while($resultPer=mysql_fetch_assoc($perSql)){

      
      if (($resultPer['modCatDisplayName'] != $modCatDisplayNameTemp)&& $firstChange ==0){
         
        echo '<li class="dropdown">
              <a tabindex="0" data-toggle="dropdown">'.$resultPer['modCatDisplayName'].'
              <span class="caret"></span></a>';
        echo '<ul class="dropdown-menu">';        
        $firstChange =$firstChange+1;
        $modCatDisplayNameTemp =  $resultPer['modCatDisplayName']; 
      }



      if (($resultPer['modCatDisplayName'] != $modCatDisplayNameTemp)&& $firstChange !=0){
        echo '</ul>';
        echo '</li>';
       
        
        echo '<li class="dropdown"><a tabindex="0" data-toggle="dropdown">'.$resultPer['modCatDisplayName'].'
           <span class="caret"></span></a>'; 
        echo '<ul class="dropdown-menu">';    
        $modCatDisplayNameTemp =  $resultPer['modCatDisplayName'];     
      
      }
      
        


      if ($resultPer['moduleParentId'] == 0){  // print those elements which are not having any parents  
         echo '<li><a tabindex="0" href="'.$resultPer['modulePageName'].'?token='.$token.'">'.
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
