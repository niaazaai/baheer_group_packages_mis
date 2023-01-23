 
<?php 
ob_start();
require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc'; 
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE = 25;
?>

<?php 

if(isset($_POST['role_id']) && !empty($_POST['role_id']) && 
isset($_POST['emp_id']) && !empty($_POST['emp_id']) )
{
    $ID=$_POST['role_id'];
    $EmpEid=$_POST['emp_id'];

    $Update=$Controller->QueryData("UPDATE employeet SET role_id=? WHERE EId=?",[$ID,$EmpEid]);
    if($Update)
    {
        echo'<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <strong>!</strong> Test Case Passed.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    else echo '212';
    
}
 

$Emp="SELECT EId,Ename,EDepartment,branch,EUserName,id,title,`status` FROM employeet LEFT JOIN `role` ON  employeet.role_id=`role`.id ";
$Emp .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
$Employee=$Controller->QueryData($Emp,[]);

$PaginateQuery = "SELECT COUNT(EId) AS RowCount FROM employeet LEFT JOIN `role` ON  employeet.role_id=`role`.id "; 
 
$RowCount =  $Controller->QueryData($PaginateQuery ,[]);
$row = $RowCount->fetch_assoc(); 

$pagination->records($row['RowCount']);
$pagination->records_per_page($RECORD_PER_PAGE);




$Role=$Controller->QueryData("SELECT * FROM `role`  ",[]);

?>

<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between">
        <h5 class="fw-bold m-0 p-0">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width = "40" viewBox="0 0 459 459" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 459 459">
                <path d="m356.766,147.498l-12.217-114.188c-2.033-18.99-17.967-33.31-37.065-33.31h-155.968c-19.098,0-35.032,14.32-37.064,33.31l-12.217,114.188c-1.124,10.501 2.281,21.028 9.34,28.883 7.059,7.854 17.164,12.359 27.724,12.359h32.296v234.877c0,2.919 1.694,5.573 4.342,6.803l60.058,27.884c1.005,0.466 2.083,0.696 3.157,0.696 1.488,0 2.967-0.442 4.235-1.31l40.754-27.884c2.043-1.398 3.265-3.714 3.265-6.19v-234.877h32.295c10.561,0 20.666-4.505 27.725-12.359 7.059-7.855 10.463-18.382 9.34-28.882zm-122.266-11.002c0,2.757-2.243,5-5,5s-5-2.243-5-5 2.243-5 5-5 5,2.243 5,5zm-47.906,52.243h45.058v251.01l-45.058-20.92v-230.09zm60.058,152.29h25.754v30.043h-25.754v-30.043zm-0-15v-66.507h25.754v66.507h-25.754zm0-81.507v-23.609h25.754v23.609h-25.754zm0,192.759v-51.208h25.754v33.587l-25.754,17.621zm25.754-231.368h-25.754v-17.174h25.754v17.174zm63.864-39.559c-4.281,4.763-10.165,7.386-16.568,7.386h-180.404c-6.403,0-12.287-2.623-16.567-7.386-4.281-4.763-6.263-10.893-5.582-17.26l12.217-114.188c1.215-11.348 10.737-19.906 22.15-19.906h39.854v27.043l-18.856,18.855c-2.49-1.115-5.24-1.749-8.14-1.749-11.028,0-20,8.972-20,20s8.972,20 20,20 20-8.972 20-20c0-2.632-0.524-5.141-1.452-7.445l21.251-21.251c1.407-1.407 2.197-3.314 2.197-5.303v-30.15h15.63v102.969c-7.32,2.974-12.5,10.152-12.5,18.527 0,11.028 8.972,20 20,20s20-8.972 20-20c0-8.375-5.18-15.553-12.5-18.527v-102.969h15.63v56.5c0,1.989 0.79,3.897 2.197,5.303l21.25,21.25c-0.928,2.303-1.452,4.812-1.452,7.443 0,11.028 8.972,20 20,20s20-8.972 20-20-8.972-20-20-20c-2.901,0-5.652,0.635-8.142,1.75l-18.853-18.852v-53.394h39.854c11.413,0 20.935,8.558 22.149,19.906l12.217,114.188c0.682,6.367-1.3,12.497-5.58,17.26zm-166.896-87.205c0,2.757-2.243,5-5,5s-5-2.243-5-5 2.243-5 5-5 5,2.244 5,5zm125.252,21.348c2.757,0 5,2.243 5,5s-2.243,5-5,5-5-2.243-5-5 2.243-5 5-5z"/>
            </svg>
            Users Access Control Setting 
        </h5>
    </div>
</div> 
 
<div class="card m-3 shadow ">
  <div class="card-body ">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 ">
                        <input type="text" class="form-control border-3 mb-2" id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
                    </div>  
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mb-2 text-end">
                        <a href="ShowAccessList.php" class="btn btn-outline-primary">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" width = "20" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 496.158 496.158" style="enable-background:new 0 0 496.158 496.158;" xml:space="preserve">
                                <path style="fill:#E04F5F;" d="M496.158,248.085c0-137.021-111.07-248.082-248.076-248.082C111.07,0.003,0,111.063,0,248.085
                                    c0,137.002,111.07,248.07,248.083,248.07C385.088,496.155,496.158,385.087,496.158,248.085z"/>
                                    <path style="fill:#FFFFFF;" d="M392.579,226.079h-225.5c-5.523,0-10,4.479-10,10v24c0,5.523,4.477,10,10,10h225.5
                                        c5.523,0,10-4.477,10-10v-24C402.579,230.558,398.102,226.079,392.579,226.079z"/>
                                    <path style="fill:#FFFFFF;" d="M127.579,226.079h-24c-5.523,0-10,4.479-10,10v24c0,5.523,4.477,10,10,10h24c5.523,0,10-4.477,10-10
                                        v-24C137.579,230.558,133.102,226.079,127.579,226.079z"/>
                                    <path style="fill:#FFFFFF;" d="M392.579,157.079h-225.5c-5.523,0-10,4.479-10,10v24c0,5.523,4.477,10,10,10h225.5
                                        c5.523,0,10-4.477,10-10v-24C402.579,161.558,398.102,157.079,392.579,157.079z"/>
                                    <path style="fill:#FFFFFF;" d="M127.579,157.079h-24c-5.523,0-10,4.479-10,10v24c0,5.523,4.477,10,10,10h24c5.523,0,10-4.477,10-10
                                        v-24C137.579,161.558,133.102,157.079,127.579,157.079z"/>
                                    <path style="fill:#FFFFFF;" d="M392.579,295.079h-225.5c-5.523,0-10,4.479-10,10v24c0,5.523,4.477,10,10,10h225.5
                                        c5.523,0,10-4.477,10-10v-24C402.579,299.558,398.102,295.079,392.579,295.079z"/>
                                    <path style="fill:#FFFFFF;" d="M127.579,295.079h-24c-5.523,0-10,4.479-10,10v24c0,5.523,4.477,10,10,10h24c5.523,0,10-4.477,10-10
                                        v-24C137.579,299.558,133.102,295.079,127.579,295.079z"/>
                            </svg>  Role List
                        </a>
                    </div>  
                </div>
                
                
                <table class= "table " id = "JobTable" >
                    <thead>
                            <tr class="table-info">
                                <th >#</th>
                                <th >Name</th>
                                <th >Department</th>
                                <th >Branch</th> 
                                <th >User Name</th>
                                <th >Role</th>  
                                <th class="text-center">OPS</th>  
                            </tr>
                    </thead>
                    <tbody>
                        <?php
                            $Counter=1;
                            while($Rows=$Employee->fetch_assoc())
                            {?>
                                <tr>
                                    <td><?=$Counter?></td>
                                    <td> <a href="UserAccessList.php?Eid=<?=$Rows['EId'];?>&role_id=<?=(isset($Rows['id'])) ? $Rows['id'] : 0;?>&username=<?=$Rows['EUserName']?>" style = "border-bottom:2px dotted black; text-decoration:none; " ><?=$Rows['Ename']?></a></td>
                                    <td><?=$Rows['EDepartment']?></td>
                                    <td><?=$Rows['branch']?></td>
                                    <td><?=$Rows['EUserName']?></td> 
                                    <td> <span class= "badge" style = "background-color:#20c997; color:white;" ><?=$Rows['title']?></span></td> 
                                    <td class="text-center">  
                                       
                                        <form action="DisableUser.php" method = "post" >
                                            <input type="hidden" name="Eid" value = "<?=$Rows['EId'];?>" >
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title = "Disable User"  > 
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x-fill" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                                                </svg> 
                                            </button>

                                             <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"  onclick = "PutEIdToModal('<?=$Rows['EId']?>')" > Set Role </button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- <input type="hidden" name="id" id="EID" value="<?=$Rows['EId']?>"> -->
                            <?php   
                                $Counter++;
                            }
                        ?>  
                    </tbody>
                </table>
            </div>

            <div class="card  ms-3 me-3 mb-3 p-0">
            <div class="card-body d-flex justify-content-center  ">
                <span class="pt-4"><?php $pagination->render(); ?></span>
            </div>
            </div>
 
  </div>
</div>

<!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-0 p-0 " id="exampleModalLabel">Set Roles Console</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body"> 
                    <div class="list-group">
                        <?php  while($Row=$Role->fetch_assoc())  {?>

                                <button type="button" class="list-group-item list-group-item-action" onclick = "check_checkbox(<?=$Row['id']?>)" >
                                    <div class="form-check">
                                        <input class="form-check-input" onclick = "put_role_id_to_modal(<?=$Row['id']?>)" type="radio" name="role_id" id="role_id_<?=$Row['id']?>">
                                        <label class="form-check-label" for="role_id_<?=$Row['id']?>"><?=$Row['title']?></label> 
                                    </div>
                                </button>


                            <?php  }  ?> 
                    </div>
                </div>
                <form action="" method="POST">
                    <div class="modal-footer">
                        <input type="hidden" name="emp_id" id="EmpEid" value=""> 
                        <input type="hidden" name="role_id" id="role_id" value=""> 
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-outline-primary"   value="Save">
                        </div> 
                </form>
        </div>
    </div>
 
<script>

    function search(InputId ,tableId) 
    {
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
    
    function PutEIdToModal(EId) {  document.getElementById("EmpEid").value=EId;  }
    function put_role_id_to_modal (role)  {  document.getElementById("role_id").value=role; }
    function check_checkbox (role) { document.getElementById("role_id_"+role).setAttribute('checked' ,'checked');}
</script>

<?php  require_once '../App/partials/Footer.inc'; ?>





          