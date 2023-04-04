 
<?php 
require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc'; 

function CheckPermission($permission_id , $role_id , $cont ){
    $Query = $cont->QueryData("SELECT role_permission.permission_id , role_permission.role_id FROM role_permission WHERE permission_id = ? AND role_id =?  ", [$permission_id , $role_id] ); 
    if($Query->num_rows > 0 ) return 'checked=checked'; 
    else return false; 
}

if(isset($_GET['role_id']) && !empty($_GET['role_id'])) {

    $role_id = $Controller->CleanInput($_GET['role_id']); 
    $AccessControl = $Controller->QueryData("SELECT id,title, page FROM permission WHERE module = 'AccessControl'" , []);
    $PermissionsList = $Controller->QueryData("SELECT id,title, page FROM permission WHERE module = 'Finance'" , []);
    $MarketingList = $Controller->QueryData("SELECT  id,title, page FROM permission WHERE module = 'Marketing'" , []);
    $DesignList = $Controller->QueryData("SELECT id,title, page FROM permission WHERE module = 'Design'" , []);
    $WarehouseList = $Controller->QueryData("SELECT id,title, page FROM permission WHERE module = 'Warehouse'" , []);
    $PressList = $Controller->QueryData("SELECT id,title, page FROM permission WHERE module = 'Press'" , []);
    $ArchieveList = $Controller->QueryData("SELECT id,title, page FROM permission WHERE module = 'Archieve'" , []);
    $ProductionList = $Controller->QueryData("SELECT id,title, page FROM permission WHERE module = 'Production'" , []);
    $HomeList = $Controller->QueryData("SELECT id,title, page FROM permission WHERE module = 'Home'" , []);
    

    if(isset($_REQUEST['title']))  {
        $title =  $_REQUEST['title']; 
    }  else $title= ''; 
}
else header('Location:ShowAccessList.php')
 
?>

<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between">
        <h5 class="fw-bold m-0 p-0">
            <a class="btn btn-outline-primary   me-1" href="ShowAccessList.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                </svg>
            </a> 
            <svg version="1.1" class = "text-warning"     width="40" height="40" viewBox="0 0 512 512"   >
                <path d="m224,128h64c8.836,0 16-7.164 16-16v-64c0-26.512-21.492-48-48-48s-48,21.488-48,48v64c0,8.836 7.164,16 16,16zm32-96c8.836,0 16,7.162 16,16 0,8.836-7.164,16-16,16s-16-7.164-16-16c0-8.838 7.164-16 16-16z"/>
                <path d="m416,32h-80v96c0,17.672-14.328,32-32,32h-96c-17.672,0-32-14.328-32-32v-96h-80c-17.672,0-32,14.326-32,32v416c0,17.672 14.328,32 32,32h320c17.672,0 32-14.328 32-32v-416c0-17.674-14.328-32-32-32zm-240,400c-8.836,0-16-7.164-16-16s7.164-16 16-16 16,7.164 16,16-7.164,16-16,16zm0-64c-8.836,0-16-7.164-16-16s7.164-16 16-16 16,7.164 16,16-7.164,16-16,16zm0-64c-8.836,0-16-7.164-16-16s7.164-16 16-16 16,7.164 16,16-7.164,16-16,16zm0-64c-8.836,0-16-7.164-16-16s7.164-16 16-16 16,7.164 16,16-7.164,16-16,16zm160,192h-96c-8.836,0-16-7.164-16-16s7.164-16 16-16h96c8.836,0 16,7.164 16,16s-7.164,16-16,16zm0-64h-96c-8.836,0-16-7.164-16-16s7.164-16 16-16h96c8.836,0 16,7.164 16,16s-7.164,16-16,16zm0-64h-96c-8.836,0-16-7.164-16-16s7.164-16 16-16h96c8.836,0 16,7.164 16,16s-7.164,16-16,16zm0-64h-96c-8.836,0-16-7.164-16-16s7.164-16 16-16h96c8.836,0 16,7.164 16,16s-7.164,16-16,16z"/>
            </svg>
            Permission List For ( <span class = "text-danger"><?=$title?></span> )
        </h5>
    </div>
</div> 

<div class="accordion accordion-flush m-3 shadow"   id="accordionFlushExample">


<div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false" aria-controls="flush-collapseOne">
        Access Control
      </button>
    </h2>
    <div id="flush-collapseZero" class="accordion-collapse collapse" aria-labelledby="flush-headingZero" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body d-flex justify-content-center">
            <div style = "width:70%" > 
                <input type="text" class="form-control border-3 mb-2" id = "Search_input" placeholder="Search Anything" onkeyup="search( this.id , 'AccessControlList' )">
                <table class= "table border"  id = "FinanceList"   >
                    <thead>
                            <tr class="table-info">
                                <th >#</th>
                                <th >Permissions</th>  
                                <th class="text-center" tile = "assign role ">OPS</th>  
                            </tr>
                    </thead>
                    <tbody>
                        <form action="AssignPermission.php" method="post">
                            <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                            <!-- <input type="hidden" id = "permission_id" name="permission_id" > -->
                            <input type="hidden" id = "title" name="title" value = "<?=$title?>" >
                            <input type="hidden" name = "module"  value = "AccessControl">

                            <?php $counter=1; while($Permissions = $AccessControl->fetch_assoc()) {?>
                                <tr>
                                    <td><?=$counter++;?></td>
                                    <td>
                                        <div class = "d-flex justify-content-between align-item-center">
                                            <div><?=$Permissions['title']?> </div>
                                            <div><span class = "badge bg-primary"> <?=$Permissions['page']?> </span>  </div> 
                                        </div>
                                    </td>  
                                    <td class="text-center">  
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            
                                            <input class="form-check-input" type="checkbox" value = "<?=$Permissions['id']?>"  
                                            <?=CheckPermission($Permissions['id'],$_GET['role_id'] , $Controller);?> 
                                            name = "permission_id[]">
                                        </div>
                                    </td>
                                </tr>
                            <?php }  ?>  
                            <tr>

                                <td colspan = 3 class="text-end" >  <button class ="btn btn-sm btn-outline-primary">Apply Permission </button></td>
                            </tr>
                    </tbody>
                </table>
                </form>
            </div>
      </div>
    </div>
  </div>



 
 


  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
      Finance Department Access List
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body d-flex justify-content-center">
            <div style = "width:70%" > 
                <input type="text" class="form-control border-3 mb-2" id = "Search_input" placeholder="Search Anything" onkeyup="search( this.id , 'FinanceList' )">
                <table class= "table border"  id = "FinanceList"   >
                    <thead>
                            <tr class="table-info">
                                <th >#</th>
                                <th >Permissions</th>  
                                <th class="text-center" tile = "assign role ">OPS</th>  
                            </tr>
                    </thead>
                    <tbody>
                        <form action="AssignPermission.php" method="post">
                            <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                            <!-- <input type="hidden" id = "permission_id" name="permission_id" > -->
                            <input type="hidden" id = "title" name="title" value = "<?=$title?>" >
                            <input type="hidden" name = "module"  value = "Finance">

                            <?php $counter=1; while($Permissions = $PermissionsList->fetch_assoc()) {?>
                                <tr>
                                    <td><?=$counter++;?></td>
                                    <td>
                                        <div class = "d-flex justify-content-between align-item-center">
                                            <div><?=$Permissions['title']?> </div>
                                            <div><span class = "badge bg-primary"> <?=$Permissions['page']?> </span>  </div> 
                                        </div>
                                    </td>  
                                    <td class="text-center">  
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            
                                            <input class="form-check-input" type="checkbox" value = "<?=$Permissions['id']?>"  
                                            <?=CheckPermission($Permissions['id'],$_GET['role_id'] , $Controller);?> 
                                            name = "permission_id[]">
                                        </div>
                                    </td>
                                </tr>
                            <?php }  ?>  
                            <tr>

                                <td colspan = 3 class="text-end" >  <button class ="btn btn-sm btn-outline-primary">Apply Permission </button></td>
                            </tr>
                    </tbody>
                </table>
                </form>
            </div>
      </div>
    </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        Marketing Department Access List 
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body d-flex justify-content-center"> 
            <div style = "width:70%" > 
                <input type="text"  class="form-control border-3 mb-2" id = "Search_input" placeholder="Search Anything" onkeyup="search( this.id , 'MarketingList' )">
                <table class= "table border"  id = "MarketingList" >
                    <thead>
                            <tr class="table-info">
                                <th >#</th>
                                <th >Permissions</th>  
                                <th class="text-center" tile = "assign role ">OPS</th>  
                            </tr>
                    </thead>
                    <tbody>
                        <form action="AssignPermission.php" method="post">
                            <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                            <input type="hidden" id = "title" name="title" value = "<?=$title?>" >
                            <input type="hidden" name = "module"  value = "Marketing">

                            <?php $counter=1; while($Permissions = $MarketingList->fetch_assoc()) {?>
                                <tr>
                                    <td ><?=$counter++;?></td>
                                    <td  >
                                        <div class = "d-flex justify-content-between align-item-center">
                                            <div><?=$Permissions['title']?> </div>
                                            <div><span class = "badge bg-primary"> <?=$Permissions['page']?> </span>  </div> 
                                        </div>
                                    </td>  
                                    <td  >  
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" value = "<?=$Permissions['id']?>"  
                                             <?=CheckPermission($Permissions['id'],$_GET['role_id'] , $Controller);?> 
                                              name = "permission_id[]">
                                        </div>
                                    </td>
                                </tr>
                            <?php }  ?>  
                            <tr><td colspan = 3 class="text-end" >  <button class ="btn btn-sm btn-outline-primary">Apply Permission </button></td></tr>
                    </tbody>
                </table>
                </form>
            </div>
      </div>
    </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        Design Department Access List
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body d-flex justify-content-center"> 
        <div style = "width:70%" >  
            <input type="text" class="form-control border-3 mb-2" id = "Search_input"  placeholder="Search Anything "  onkeyup="search( this.id , 'DesignList' )">
            <table class= "table border"  id = "DesignList" >
                <thead>
                    <tr class="table-info">
                        <th >#</th>
                        <th >Permissions</th>  
                        <th class="text-center" tile = "assign role ">OPS</th>  
                    </tr>
                </thead>
                <tbody>
                    <form action="AssignPermission.php" method="post">
                        <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                        <input type="hidden" id = "title" name="title" value = "<?=$title?>" >
                        <input type="hidden" name = "module"  value = "Design">
                        <?php $counter=1; while($Permissions = $DesignList->fetch_assoc()) {?>
                            <tr>
                                <td ><?=$counter++;?></td>
                                <td  >
                                    <div class = "d-flex justify-content-between align-item-center">
                                        <div><?=$Permissions['title']?> </div>
                                        <div><span class = "badge bg-primary"> <?=$Permissions['page']?> </span>  </div> 
                                    </div>
                                </td>  
                                <td  >  
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" value = "<?=$Permissions['id']?>"  
                                            <?=CheckPermission($Permissions['id'],$_GET['role_id'] , $Controller);?> 
                                            name = "permission_id[]">
                                    </div>
                                </td>
                            </tr>
                        <?php }  ?>  
                        <tr><td colspan = 3 class="text-end" >  <button class ="btn btn-sm btn-outline-primary">Apply Permission </button></td></tr>
                </tbody>
            </table>
            </form>
        </div>

      </div>
    </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingFour">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
        Printing Press Department Access List
      </button>
    </h2>
    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-collapseFour" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body d-flex justify-content-center"> 
        <div style = "width:70%" >  
            <input type="text" class="form-control border-3 mb-2" id = "Search_input"  placeholder="Search Anything "  onkeyup="search( this.id , 'PrintTable' )">
            <table class= "table border"  id = "PrintTable" >
                <thead>
                        <tr class="table-info">
                            <th >#</th>
                            <th >Permissions</th>  
                            <th class="text-center" tile = "assign role ">OPS</th>  
                        </tr>
                </thead>
                <tbody>
                    <form action="AssignPermission.php" method="post">
                        <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                        <input type="hidden" id = "title" name="title" value = "<?=$title?>" >
                        <input type="hidden" name = "module"  value = "Press">

                        <?php $counter=1; while($Permissions = $PressList->fetch_assoc()) {?>
                            <tr>
                                <td><?=$counter++;?></td>
                                <td>
                                    <div class = "d-flex justify-content-between align-item-center">
                                        <div><?=$Permissions['title']?> </div>
                                        <div><span class = "badge bg-primary"> <?=$Permissions['page']?> </span>  </div> 
                                    </div>
                                </td>  
                                <td class="text-center">  
                                    <div class="form-check form-switch d-flex justify-content-center">
                                            
                                        <input class="form-check-input" type="checkbox" value = "<?=$Permissions['id']?>"  
                                            <?=CheckPermission($Permissions['id'],$_GET['role_id'] , $Controller);?> 
                                            name = "permission_id[]">
                                    </div>
                                </td>
                            </tr>
                        <?php }  ?>  
                        <tr><td colspan = 3 class="text-end" >  <button class ="btn btn-sm btn-outline-primary">Apply Permission </button></td></tr>
                </tbody>
            </table>
            </form>
        </div>
      </div>
    </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingFive">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
      Archieve Department Access List
      </button>
    </h2>
    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-collapseFive" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body d-flex justify-content-center"> 
        <div style = "width:70%" >  
            <input type="text" class="form-control border-3 mb-2" id = "Search_input"  placeholder="Search Anything "  onkeyup="search( this.id , 'archtable' )">
            <table class= "table border"  id = "archtable" >
                <thead>
                    <tr class="table-info">
                        <th >#</th>
                        <th >Permissions</th>  
                        <th class="text-center" tile = "assign role ">OPS</th>  
                    </tr>
                </thead>
                <tbody>
                    <form action="AssignPermission.php" method="post">
                        <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                        <input type="hidden" id = "title" name="title" value = "<?=$title?>" >
                        <input type="hidden" name = "module"  value = "Archieve">

                        <?php $counter=1; while($Permissions = $ArchieveList->fetch_assoc()) {?>
                            <tr>
                                <td><?=$counter++;?></td>
                                <td>
                                    <div class = "d-flex justify-content-between align-item-center">
                                        <div><?=$Permissions['title']?> </div>
                                        <div><span class = "badge bg-primary"> <?=$Permissions['page']?> </span>  </div> 
                                    </div>
                                </td>  
                                <td class="text-center">  
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        
                                        <input class="form-check-input" type="checkbox" value = "<?=$Permissions['id']?>"  
                                        <?=CheckPermission($Permissions['id'],$_GET['role_id'] , $Controller);?> 
                                        name = "permission_id[]">
                                    </div>
                                </td>
                            </tr>
                        <?php }  ?>  
                        <tr><td colspan = 3 class="text-end" >  <button class ="btn btn-sm btn-outline-primary">Apply Permission </button></td></tr>
                </tbody>
            </table>
            </form>
        </div> <!-- END OF ARCHIEVE ACCESS LIST  -->
      </div>
    </div>
  </div>



  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingSix">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
        Production Department Access List
      </button>
    </h2>
    <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-collapseSix" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body d-flex justify-content-center"> 
        <div style = "width:70%" >  
            <input type="text" class="form-control border-3 mb-2" id = "Search_input"  placeholder="Search Anything "  onkeyup="search( this.id , 'ProductionTable' )">
                 <table class= "table border"  id = "ProductionTable" >
                    <thead>
                        <tr class="table-info">
                            <th >#</th>
                            <th >Permissions</th>  
                            <th class="text-center" tile = "assign role ">OPS</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <form action="AssignPermission.php" method="post">
                            <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                            <input type="hidden" id = "title" name="title" value = "<?=$title?>" >
                            <input type="hidden" name = "module"  value = "Production">

                            <?php $counter=1; while($Permissions = $ProductionList->fetch_assoc()) {?>
                                <tr>
                                    <td><?=$counter++;?></td>
                                    <td>
                                        <div class = "d-flex justify-content-between align-item-center">
                                            <div><?=$Permissions['title']?> </div>
                                            <div><span class = "badge bg-primary"> <?=$Permissions['page']?> </span>  </div> 
                                        </div>
                                    </td>  
                                    <td class="text-center">  
                                        <div class="form-check form-switch d-flex justify-content-center">
                                              
                                            <input class="form-check-input" type="checkbox" value = "<?=$Permissions['id']?>"  
                                             <?=CheckPermission($Permissions['id'],$_GET['role_id'] , $Controller);?> 
                                              name = "permission_id[]">
                                        </div>
                                    </td>
                                </tr>
                            <?php }  ?>  
                            <tr><td colspan = 3 class="text-end" >  <button class ="btn btn-sm btn-outline-primary">Apply Permission </button></td></tr>
                    </tbody>
                </table>
            </form>
        </div> <!-- END OF PRODUCTION ACCESS LIST  -->
        
      </div>
    </div>
  </div>


  <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingSeven">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                Home Option Access List
            </button>
        </h2>
        <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-collapseSeven" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body d-flex justify-content-center"> 
                <div style = "width:70%" >  
                    <input type="text" class="form-control border-3 mb-2" id = "Search_input"  placeholder="Search Anything "  onkeyup="search( this.id , 'home221' )">
                    <table class= "table border"  id = "home221" >
                        <thead>
                            <tr class="table-info">
                                <th >#</th>
                                <th >Permissions</th>  
                                <th class="text-center" tile = "assign role ">OPS</th>  
                            </tr>
                        </thead>
                        <tbody>
                        <form action="AssignPermission.php" method="post">
                            <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                            <input type="hidden" id = "title" name="title" value = "<?=$title?>" >
                            <input type="hidden" name = "module"  value = "Home">
                            <?php $counter=1; while($Permissions = $HomeList->fetch_assoc()) {?>
                                <tr>
                                    <td><?=$counter++;?></td>
                                    <td>
                                        <div class = "d-flex justify-content-between align-item-center">
                                            <div><?=$Permissions['title']?> </div>
                                            <div><span class = "badge bg-primary"> <?=$Permissions['page']?> </span>  </div> 
                                        </div>
                                    </td>  
                                    <td class="text-center">  
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            
                                            <input class="form-check-input" type="checkbox" value = "<?=$Permissions['id']?>"  
                                            <?=CheckPermission($Permissions['id'],$_GET['role_id'] , $Controller);?> 
                                            name = "permission_id[]">
                                        </div>
                                    </td>
                                </tr>
                            <?php }  ?>  
                            <tr><td colspan = 3 class="text-end" >  <button class ="btn btn-sm btn-outline-primary">Apply Permission </button></td></tr>
                        </tbody>
                    </table>
                    </form>
                </div> <!-- END OF HOMEPAGE ACCESS LIST  -->
            </div>
        </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingEight">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
        Warehouse Department Permissions List 
      </button>
    </h2>
    <div id="flush-collapseEight" class="accordion-collapse collapse" aria-labelledby="flush-collapseEight" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body d-flex justify-content-center"> 
        <div style = "width:70%" >  
            <input type="text" class="form-control border-3 mb-2" id = "Search_input"  placeholder="Search Anything "  onkeyup="search(this.id ,'ProductionTable')">
            <table class= "table border"  id = "JobTable" >
                <thead>
                    <tr class="table-info">
                        <th >#</th>
                        <th >Permissions</th>  
                        <th class="text-center" tile = "assign role ">OPS</th>  
                    </tr>
                </thead>
                <tbody>
                    <form action="AssignPermission.php" method="post">
                        <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                        <input type="hidden" id = "title" name="title" value = "<?=$title?>" >
                        <input type="hidden" name = "module"  value = "Warehouse">

                        <?php $counter=1; while($Permissions = $WarehouseList->fetch_assoc()) {?>
                            <tr>
                                <td><?=$counter++;?></td>
                                <td>
                                    <div class = "d-flex justify-content-between align-item-center">
                                        <div><?=$Permissions['title']?> </div>
                                        <div><span class = "badge bg-primary"> <?=$Permissions['page']?> </span>  </div> 
                                    </div>
                                </td>  
                                <td class="text-center">  
                                    <div class="form-check form-switch d-flex justify-content-center">
                                            
                                        <input class="form-check-input" type="checkbox" value = "<?=$Permissions['id']?>"  
                                            <?=CheckPermission($Permissions['id'],$_GET['role_id'] , $Controller);?> 
                                            name = "permission_id[]">
                                    </div>
                                </td>
                            </tr>
                        <?php }  ?>  
                        <tr><td colspan = 3 class="text-end" >  <button class ="btn btn-sm btn-outline-primary">Apply Permission </button></td></tr>
                </tbody>
            </table>
            </div>
            </form>
        </div>  <!-- END OF WHEREHOUSE ACCESS LIST  -->
          
      </div>
    </div>
  </div>
</div>

<script>
    function search(InputId ,tableId)   {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(InputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i];
            if (td) 
            {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) 
                {  tr[i].style.display = ""; } 
                else  {  tr[i].style.display = "none";  }
            }
        }
    }
</script>
<?php  require_once '../App/partials/Footer.inc'; ?>