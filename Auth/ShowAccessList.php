 
<?php 
ob_start();
require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc'; 
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE = 25;
 
if(isset($_POST['save']) && !empty($_POST['save'])) {
    $Title=$_POST['Title'];
    $Description=$_POST['Description']; 
    $Slug=$Title .'_'. time();


    $Insert=$Controller->QueryData("INSERT INTO `role` (title,description,slug,status) VALUES (?,?,?,?) ",[$Title,$Description,$Slug,1]);
    if($Insert)
    {
        echo'<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <strong>!</strong> Data Inserted Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
 

$Emp="SELECT * FROM `role`";
$Emp .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
$Employee=$Controller->QueryData($Emp,[]);

$PaginateQuery = "SELECT COUNT(EId) AS RowCount FROM employeet LEFT JOIN `role` ON  employeet.role_id=`role`.id "; 
 
$RowCount =  $Controller->QueryData($PaginateQuery ,[]);
$row = $RowCount->fetch_assoc(); 

$pagination->records($row['RowCount']);
$pagination->records_per_page($RECORD_PER_PAGE);
?>
 

<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between">
        <h5 class="fw-bold m-0 p-0">
        <a class="btn btn-outline-primary   me-1" href="RoleList.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                </svg>
            </a> 
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width = "40" viewBox="0 0 459 459" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 459 459">
                <path d="m356.766,147.498l-12.217-114.188c-2.033-18.99-17.967-33.31-37.065-33.31h-155.968c-19.098,0-35.032,14.32-37.064,33.31l-12.217,114.188c-1.124,10.501 2.281,21.028 9.34,28.883 7.059,7.854 17.164,12.359 27.724,12.359h32.296v234.877c0,2.919 1.694,5.573 4.342,6.803l60.058,27.884c1.005,0.466 2.083,0.696 3.157,0.696 1.488,0 2.967-0.442 4.235-1.31l40.754-27.884c2.043-1.398 3.265-3.714 3.265-6.19v-234.877h32.295c10.561,0 20.666-4.505 27.725-12.359 7.059-7.855 10.463-18.382 9.34-28.882zm-122.266-11.002c0,2.757-2.243,5-5,5s-5-2.243-5-5 2.243-5 5-5 5,2.243 5,5zm-47.906,52.243h45.058v251.01l-45.058-20.92v-230.09zm60.058,152.29h25.754v30.043h-25.754v-30.043zm-0-15v-66.507h25.754v66.507h-25.754zm0-81.507v-23.609h25.754v23.609h-25.754zm0,192.759v-51.208h25.754v33.587l-25.754,17.621zm25.754-231.368h-25.754v-17.174h25.754v17.174zm63.864-39.559c-4.281,4.763-10.165,7.386-16.568,7.386h-180.404c-6.403,0-12.287-2.623-16.567-7.386-4.281-4.763-6.263-10.893-5.582-17.26l12.217-114.188c1.215-11.348 10.737-19.906 22.15-19.906h39.854v27.043l-18.856,18.855c-2.49-1.115-5.24-1.749-8.14-1.749-11.028,0-20,8.972-20,20s8.972,20 20,20 20-8.972 20-20c0-2.632-0.524-5.141-1.452-7.445l21.251-21.251c1.407-1.407 2.197-3.314 2.197-5.303v-30.15h15.63v102.969c-7.32,2.974-12.5,10.152-12.5,18.527 0,11.028 8.972,20 20,20s20-8.972 20-20c0-8.375-5.18-15.553-12.5-18.527v-102.969h15.63v56.5c0,1.989 0.79,3.897 2.197,5.303l21.25,21.25c-0.928,2.303-1.452,4.812-1.452,7.443 0,11.028 8.972,20 20,20s20-8.972 20-20-8.972-20-20-20c-2.901,0-5.652,0.635-8.142,1.75l-18.853-18.852v-53.394h39.854c11.413,0 20.935,8.558 22.149,19.906l12.217,114.188c0.682,6.367-1.3,12.497-5.58,17.26zm-166.896-87.205c0,2.757-2.243,5-5,5s-5-2.243-5-5 2.243-5 5-5 5,2.244 5,5zm125.252,21.348c2.757,0 5,2.243 5,5s-2.243,5-5,5-5-2.243-5-5 2.243-5 5-5z"/>
            </svg>
            All Available Roles List 
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
                        <!-- <a href="CreateRole.php" class="btn btn-outline-primary">Create Rule</a> -->
                        <button type="button" class="btn btn-outline-success " data-bs-toggle="modal" data-bs-target="#exampleModal" > 
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-signpost-split" viewBox="0 0 16 16">
                            <path d="M7 7V1.414a1 1 0 0 1 2 0V2h5a1 1 0 0 1 .8.4l.975 1.3a.5.5 0 0 1 0 .6L14.8 5.6a1 1 0 0 1-.8.4H9v10H7v-5H2a1 1 0 0 1-.8-.4L.225 9.3a.5.5 0 0 1 0-.6L1.2 7.4A1 1 0 0 1 2 7h5zm1 3V8H2l-.75 1L2 10h6zm0-5h6l.75-1L14 3H8v2z"/>
                            </svg>
                            New Role 
                        </button>  
                    </div>  
                </div>
                
                
                <table class= "table " id = "JobTable" >
                    <thead>
                            <tr class="table-info">
                                <th >#</th>
                                <th >Role</th>  
                                <th >Description</th>
                                <th >Status</th>
                                <th >Date</th> 
                                <th class="text-center">OPS</th>  
                            </tr>
                    </thead>
                    <tbody>
                        <?php $counter=1;
                            while($Rows=$Employee->fetch_assoc())
                            {?>
                                <tr>
                                    <td><?=$counter++;?></td>
                                    <td><?=$Rows['title']?></td>  
                                    <td><?=$Rows['description']?></td>
                                    <td><?php echo ($Rows['status'] == '1') ?  '<span class = "badge bg-success" >Active</span>': '<span class = "badge bg-danger" >Deactivated</span>' ?></td>
                                    <td><?=$Rows['created_at']?></td> 
                                    <td class="text-center">  
                                     
                                        <form action="DeleteRole.php" method="post" >
                                            
                                            <input type="hidden" name="Id" value = "<?=$Rows['id']?>">
                                            <button onclick = "return confirm('Are you sure you want to delete this role permanently '); " type="submit" class  = "btn p-0 m-0" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="text-danger" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </button>

                                            <a href="EditRole.php?Id=<?=$Rows['id']?>" class = "btn btn-sm p-0 ">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class=" text-warning p-0 m-0" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l  -2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                                                </svg> 
                                            </a>

                                            <a href="Permission.php?role_id=<?=$Rows['id']?>&title=<?=$Rows['title'];?>" class = "btn btn-sm p-0 ">
                                                <svg version="1.1" class = "text-warning"     width="25" height="25" viewBox="0 0 512 512"   >
                                                    <path d="m224,128h64c8.836,0 16-7.164 16-16v-64c0-26.512-21.492-48-48-48s-48,21.488-48,48v64c0,8.836 7.164,16 16,16zm32-96c8.836,0 16,7.162 16,16 0,8.836-7.164,16-16,16s-16-7.164-16-16c0-8.838 7.164-16 16-16z"/>
                                                    <path d="m416,32h-80v96c0,17.672-14.328,32-32,32h-96c-17.672,0-32-14.328-32-32v-96h-80c-17.672,0-32,14.326-32,32v416c0,17.672 14.328,32 32,32h320c17.672,0 32-14.328 32-32v-416c0-17.674-14.328-32-32-32zm-240,400c-8.836,0-16-7.164-16-16s7.164-16 16-16 16,7.164 16,16-7.164,16-16,16zm0-64c-8.836,0-16-7.164-16-16s7.164-16 16-16 16,7.164 16,16-7.164,16-16,16zm0-64c-8.836,0-16-7.164-16-16s7.164-16 16-16 16,7.164 16,16-7.164,16-16,16zm0-64c-8.836,0-16-7.164-16-16s7.164-16 16-16 16,7.164 16,16-7.164,16-16,16zm160,192h-96c-8.836,0-16-7.164-16-16s7.164-16 16-16h96c8.836,0 16,7.164 16,16s-7.164,16-16,16zm0-64h-96c-8.836,0-16-7.164-16-16s7.164-16 16-16h96c8.836,0 16,7.164 16,16s-7.164,16-16,16zm0-64h-96c-8.836,0-16-7.164-16-16s7.164-16 16-16h96c8.836,0 16,7.164 16,16s-7.164,16-16,16zm0-64h-96c-8.836,0-16-7.164-16-16s7.164-16 16-16h96c8.836,0 16,7.164 16,16s-7.164,16-16,16z"/>
                                                </svg>
                                            </a> 
                                        </form> 
                                        
                                    </td>
                                </tr>
                            <?php   
                                
                            }
                        ?>  
                    </tbody>
                </table>
            </div>
 
            <div class="card-body d-flex justify-content-center p-0 m-0  ">
                <span class=""><?php $pagination->render(); ?></span>
            </div>
             
 
  </div>
</div>



 
<!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-0 p-0" id="exampleModalLabel"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-signpost-split" viewBox="0 0 16 16">
                        <path d="M7 7V1.414a1 1 0 0 1 2 0V2h5a1 1 0 0 1 .8.4l.975 1.3a.5.5 0 0 1 0 .6L14.8 5.6a1 1 0 0 1-.8.4H9v10H7v-5H2a1 1 0 0 1-.8-.4L.225 9.3a.5.5 0 0 1 0-.6L1.2 7.4A1 1 0 0 1 2 7h5zm1 3V8H2l-.75 1L2 10h6zm0-5h6l.75-1L14 3H8v2z"/>
                    </svg> Create New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <form action="" method="POST">
            </div>
                <div class="modal-body"> 
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="Title"  id="floatingInput11" placeholder="Role Name">
                        <label for="floatingInput11">Role Name </label>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control"  name="Description"  placeholder="Description" id="floatingTextarea2"  cols="20" rows="10"  style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Description for the role </label>
                    </div>
                </div>
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-outline-primary"  name="save" value="Save">
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
    
    function PutEIdToModal(Id) {  document.getElementById("EmpEid").value=EId;  }
    
 
</script>

<?php  require_once '../App/partials/Footer.inc'; ?>





