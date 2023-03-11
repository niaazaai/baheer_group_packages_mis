 
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
    $PermissionsList = $Controller->QueryData("SELECT  * FROM permission " , []);
   
    $AssignedPermissions = $Controller->QueryData("SELECT role.title as role_name , permission.title as permission_name,  role_permission.permission_id as pid 
    , role_permission.role_id as rid  , role.description as role_description    
    FROM role 
    INNER JOIN role_permission ON role.id=role_permission.role_id 
    INNER JOIN permission ON role_permission.permission_id =permission.id WHERE role_permission.role_id = ? " , [$role_id]);

    if(isset($_REQUEST['title']))  {
        $title =  $_REQUEST['title']; 
    }  else $title= ''; 

    // echo "<pre>"; 
    // print_r($AssignedRights);
    // echo "</pre>";

    
    // $Update=$Controller->QueryData("UPDATE employeet SET role_id=? WHERE EId=?",[$ID,$EmpEid]);
    // if($Update)
    // {
    //     echo'<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
    //     <strong>!</strong> Test Case Passed.
    //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //   </div>';
    // }
    // else echo '212';
        
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

<div class="row">
    <div class="col-lg-6 col-sm-12 col-md-12 ">

    </div>
    <div class="col-lg-6  col-sm-12 col-md-12">

    </div>
</div>

<div class="row m-1 d-flex justify-content-center">
    <div class="col-lg-8 col-md-8 col-sm-12  ">

        <div class="card border-primary mb-3"  >
            <div class="card-header bg-transparent border-primary fw-bold">ALL Permissions List </div>
            <div class="card-body text-primary">
                <input type="text" class="form-control border-3 mb-2" id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
                
                <table class= "table border"  id = "JobTable" >
                    <thead>
                            <tr class="table-info">
                                <th >#</th>
                                <th >Permissions</th>  
                                <th >Page</th>
                                <th class="text-center" tile = "assign role ">OPS</th>  
                            </tr>
                    </thead>
                    <tbody>
                        <form action="AssignPermission.php" method="post">
                            <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
                            <input type="hidden" id = "permission_id" name="permission_id" >
                            <input type="hidden" id = "title" name="title">

                            <?php $counter=1; while($Permissions = $PermissionsList->fetch_assoc())  {?>
                                <tr>
                                    <td><?=$counter++;?></td>
                                    <td><?=$Permissions['title']?></td>  
                                    <td><?=$Permissions['page']?></td>
                                    <td class="text-center">  
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" <?=CheckPermission( $Permissions['id']  ,   $_GET['role_id'] , $Controller);?> 
                                             id="assign_switch_<?=$Permissions['id']?>" onclick="assign_permissions_to_roles(<?=$Permissions['id']?> , `<?=$title?>` , this.id );" >
                                        </div>
                                    </td>
                                </tr>
                            <?php }  ?>  
                        </form>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent border-primary text-end">
                <button class ="btn btn-sm btn-outline-primary">Apply Permission </button>  
            </div>
        </div>

    </div>
</div>

<form action="DeletePermission.php" method="post" class = "m-0 p-0"  >
    <input type="hidden" name="role_id" value = "<?=$role_id?>"  >
    <input type="hidden" id = "permission_id1" name="permission_id" >
    <input type="hidden" id = "title1" name="title"   >
</form> 
 
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



    function assign_permissions_to_roles(permission_id , title , id){
        var switch1 = document.getElementById(id);

        if(switch1.checked == true ) {
            document.getElementById('permission_id').value = permission_id; 
            document.getElementById('title').value = title; 
            document.getElementById('permission_id').form.submit(); 
        }
        else {
            document.getElementById('permission_id1').value = permission_id; 
            document.getElementById('title1').value = title; 
            document.getElementById('permission_id1').form.submit(); 
        }
    }
</script>




 
  
<?php  require_once '../App/partials/Footer.inc'; ?>





          