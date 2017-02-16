<?php
error_reporting(-1);
include_once('headerUpper.php');
$permissionJoin= 'SELECT A.moduleName as modulePageName,
                  A.displayModuleName as displayModuleName,
                  A.parentId as moduleParentId,
                  D.displayname as modCatDisplayName ,
                  C.parentName as subParentName
                  FROM `tblmodulename` as A 
                  Inner join tblusercategorymodulemapping AS B 
                  ON A.moduleId = B.moduleId 
                  and B.usercategoryId ='.$_SESSION['user_category_id'].'  
                  inner join tblmoduleparentname as C 
                  on C.parentId = A.parentId 
                  INNER JOIN tblmodulecategory as D 
                  on D.moduleCatId = A.moduleCatId
                  order by  A.moduleCatId ,  A.parentId';

//echo $permissionJoin; 

$perSql= mysql_query($permissionJoin);
if($_SESSION['user_category_id'] == 9)
{
  echo '<aside class="main-sidebar">
          <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left info">
              <p>'.$_SESSION['name'].'</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
            <div class="pull-left image">
              <img src="assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
          </div>
        <ul class="sidebar-menu">
          <li class="header">MAIN NAVIGATION</li>
          <li><a href="executive_tickets.php?token='.$token.'"><i class="fa fa-book"></i> <span>Dashboard</span></a></li>
          ';
}
else if($_SESSION['user_category_id'] == 5)
{
  echo '<aside class="main-sidebar">
        <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <img src="assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>'.$_SESSION['name'].'</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="executive_tickets.php?token='.$token.'"><i class="fa fa-book"></i> <span>Dashboard</span></a></li>
        ';
}
else
{
  echo '<aside class="main-sidebar">
        <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <img src="assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>'.$_SESSION['name'].'</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="home.php?token='.$token.'"><i class="fa fa-book"></i> <span>Dashboard</span></a></li>
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
        echo '<li class="treeview">
              <a href="#"><i class="fa fa-edit"></i> <span>'.$resultPer['modCatDisplayName'].'</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>';
        echo '<ul class="treeview-menu">';        
        $firstChange =$firstChange+1;
        $modCatDisplayNameTemp =  $resultPer['modCatDisplayName']; 
      }



      if (($resultPer['modCatDisplayName'] != $modCatDisplayNameTemp)&& $firstChange !=0){
        echo '</ul>';
        echo '</li>';
       
        //echo 'Module category changed-----'; 
        echo '<li class="treeview">
                <a href="#"><i class="fa fa-edit"></i> <span>'.$resultPer['modCatDisplayName'].'</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>'; 
        echo '<ul class="treeview-menu">';    
        $modCatDisplayNameTemp =  $resultPer['modCatDisplayName'];     
      
      }
      
        


      if ($resultPer['moduleParentId'] == 0){  // print those elements which are not having any parents  
        
    echo '<li>
          <a href="'.$resultPer['modulePageName'].'?token='.$token.'">
            <i class="fa fa-circle-o"></i>'.
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
      echo '<li>
              <a href="#"><i class="fa fa-circle-o"></i> '.$resultPer['subParentName'].'
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
            <ul class="treeview-menu">';
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
      echo '<li><a href="#"><i class="fa fa-circle-o"></i> '.$resultPer['subParentName'].'</a>
            <ul class="treeview-menu">';
      $closeFlag = 1;
    }
    //This will print the elements in the parent
    echo '<li>
            <a href="'.$resultPer['modulePageName'].'?token='.$token.'"> <i class="fa fa-circle-o"></i> '.
          $resultPer['displayModuleName'].'</a>
          </li>';  
      
    }
   


      if($maxRows ==$firstChange ){
        echo '</ul>';
        echo '</li>';
      }  
  }
} 
echo '</ul> 
</section>
</aside>';          
?>