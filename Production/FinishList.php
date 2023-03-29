<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
    if(!in_array( $Gate['VIEW_FINISHED_JOBS_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
        header("Location:index.php?msg=You are not authorized to access this page!" );
    }
    require_once '../App/partials/Menu/MarketingMenu.inc';

    $DataRows=$Controller->QueryData("SELECT   carton.JobNo , carton.CTNId , carton.CTNQTY ,  CONCAT( FORMAT(CTNLength / 10 ,1 ) , 'x' , FORMAT ( CTNWidth / 10 , 1 ), 'x', FORMAT(CTNHeight/ 10,1) ) AS Size , 
    carton.ProductName , ppcustomer.CustName , 	carton.ProductQTY , designinfo.DesignImage , CTNUnit , CTNType , production_cycle.cycle_id , 
    cycle_status , cycle_plan_qty , carton.CustId1  
      FROM carton  
      INNER JOIN  ppcustomer on carton.CustId1 = ppcustomer.CustId 
      INNER JOIN  designinfo on designinfo.CaId = carton.CTNId 
      INNER JOIN  production_cycle on carton.CTNId = production_cycle.CTNId   
      WHERE cycle_status = 'Finish List' ",[]) ;

    $DataRow=$Controller->QueryData("SELECT COUNT(ProId ) AS Id FROM cartonproduction WHERE ProStatus='Pending'  ",[]) ;
    $Out=$DataRow->fetch_assoc();

?>

<?php  if(isset($_GET['msg'])) {  ?>
    <div class="alert  alert-dismissible fade show m-3 alert-<?php if(isset($_GET['class'])) echo $_GET['class'];  ?>" role="alert">
        <strong>Message: </strong> <?=$_GET['msg']?>! 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between    ">
    <div class = "mt-2" > 
        <a class="btn btn-outline-primary   me-1" href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
            </svg>
        </a>
        <svg width="45" height="45" viewBox="0 0 56 57" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M55.188 41.863L53.744 41.586C53.067 41.456 52.534 41.013 52.282 40.37C52.029 39.728 52.119 39.041 52.527 38.485L53.434 37.249C53.726 36.851 53.684 36.299 53.334 35.95L51.375 33.992C51.036 33.653 50.503 33.603 50.107 33.871L48.89 34.695C48.32 35.083 47.628 35.146 46.995 34.87C46.363 34.595 45.94 34.045 45.835 33.362L45.602 31.847C45.528 31.36 45.108 31 44.615 31H41.845C41.366 31 40.953 31.341 40.863 31.812L40.505 33.677C40.378 34.339 39.947 34.867 39.324 35.125C38.699 35.386 38.023 35.314 37.464 34.936L35.892 33.872C35.495 33.604 34.963 33.654 34.624 33.993L32.665 35.951C32.315 36.3 32.273 36.851 32.565 37.25L33.472 38.486C33.88 39.042 33.97 39.729 33.717 40.371C33.465 41.014 32.932 41.457 32.255 41.587L30.811 41.864C30.34 41.955 29.999 42.367 29.999 42.846V45.616C29.999 46.109 30.359 46.529 30.847 46.604L32.362 46.837C33.045 46.942 33.594 47.365 33.87 47.997C34.146 48.63 34.082 49.32 33.695 49.892L32.871 51.109C32.602 51.505 32.653 52.038 32.992 52.377L34.95 54.336C35.298 54.685 35.849 54.726 36.249 54.436L37.485 53.529C38.04 53.122 38.729 53.031 39.37 53.284C40.013 53.536 40.456 54.069 40.586 54.746L40.863 56.19C40.954 56.659 41.366 57 41.846 57H44.616C45.109 57 45.529 56.64 45.604 56.152L45.768 55.087C45.873 54.399 46.32 53.831 46.961 53.565C47.605 53.299 48.322 53.386 48.882 53.797L49.751 54.435C50.151 54.728 50.702 54.685 51.05 54.335L53.008 52.376C53.347 52.037 53.398 51.505 53.129 51.108L52.305 49.891C51.918 49.32 51.854 48.629 52.13 47.996C52.405 47.364 52.955 46.941 53.638 46.836L55.153 46.603C55.64 46.528 56.001 46.108 56.001 45.615V42.845C56 42.366 55.659 41.954 55.188 41.863ZM54 44.758L53.333 44.861C51.979 45.069 50.844 45.943 50.297 47.198C49.749 48.454 49.881 49.88 50.649 51.013L51.01 51.546L50.242 52.314L50.065 52.184C48.935 51.357 47.49 51.182 46.196 51.717C44.902 52.253 44.004 53.399 43.791 54.782L43.758 55H42.672L42.551 54.367C42.292 53.021 41.376 51.92 40.102 51.42C38.827 50.921 37.407 51.106 36.302 51.914L35.758 52.313L34.99 51.545L35.351 51.012C36.119 49.878 36.25 48.452 35.703 47.197C35.156 45.942 34.02 45.068 32.667 44.86L32 44.758V43.672L32.633 43.551C33.979 43.292 35.08 42.376 35.58 41.102C36.08 39.827 35.895 38.407 35.086 37.302L34.687 36.758L35.455 35.99L36.344 36.592C37.451 37.344 38.854 37.485 40.091 36.973C41.328 36.46 42.218 35.369 42.471 34.054L42.672 33H43.758L43.861 33.667C44.069 35.021 44.943 36.156 46.198 36.703C47.454 37.25 48.88 37.119 50.013 36.351L50.546 35.99L51.314 36.758L50.915 37.302C50.105 38.406 49.921 39.826 50.421 41.102C50.921 42.376 52.023 43.292 53.368 43.551L54.001 43.672V44.758H54Z" fill="#AE00FB"/>
            <path d="M43 39C40.243 39 38 41.243 38 44C38 46.757 40.243 49 43 49C45.757 49 48 46.757 48 44C48 41.243 45.757 39 43 39ZM43 47C41.346 47 40 45.654 40 44C40 42.346 41.346 41 43 41C44.654 41 46 42.346 46 44C46 45.654 44.654 47 43 47Z" fill="#AE00FB"/>
            <path d="M27 12C26.447 12 26 12.447 26 13C26 13.553 26.447 14 27 14H45C45.553 14 46 13.553 46 13C46 12.447 45.553 12 45 12H27Z" fill="#AE00FB"/>
            <path d="M46 27C46 26.447 45.553 26 45 26H27C26.447 26 26 26.447 26 27C26 27.553 26.447 28 27 28H45C45.553 28 46 27.553 46 27Z" fill="#AE00FB"/>
            <path d="M20.579 7.24101C20.161 6.88201 19.529 6.92901 19.17 7.34901L12.922 14.637L9.09999 11.771C8.65899 11.441 8.03199 11.528 7.70099 11.971C7.36899 12.412 7.45899 13.039 7.90099 13.37L12.472 16.799C12.651 16.934 12.862 16.999 13.071 16.999C13.354 16.999 13.634 16.88 13.831 16.649L20.688 8.64901C21.048 8.23101 20.999 7.60101 20.579 7.24101Z" fill="#AE00FB"/>
            <path d="M20.579 21.241C20.161 20.882 19.529 20.929 19.17 21.349L12.922 28.637L9.09999 25.771C8.65899 25.441 8.03199 25.528 7.70099 25.971C7.36899 26.412 7.45899 27.039 7.90099 27.37L12.472 30.799C12.651 30.934 12.862 30.999 13.071 30.999C13.354 30.999 13.634 30.88 13.831 30.649L20.688 22.649C21.048 22.231 20.999 21.601 20.579 21.241Z" fill="#AE00FB"/>
            <path d="M19.17 36.35L12.922 43.637L9.09999 40.771C8.65899 40.44 8.03199 40.528 7.70099 40.971C7.36899 41.412 7.45899 42.039 7.90099 42.37L12.472 45.799C12.651 45.934 12.862 45.999 13.071 45.999C13.354 45.999 13.634 45.88 13.831 45.649L20.688 37.65C21.048 37.231 21 36.6 20.58 36.241C20.161 35.882 19.529 35.93 19.17 36.35Z" fill="#AE00FB"/>
            <path d="M23 52H12.176C6.564 52 2 47.436 2 41.824V12.176C2 6.564 6.564 2 12.176 2H41.824C47.436 2 52 6.564 52 12.176V33C52 33.553 52.447 34 53 34C53.553 34 54 33.553 54 33V12.176C54 5.462 48.538 0 41.824 0H12.176C5.462 0 0 5.462 0 12.176V41.824C0 48.538 5.462 54 12.176 54H23C23.553 54 24 53.553 24 53C24 52.447 23.553 52 23 52Z" fill="#AE00FB"/>
        </svg>
        <span class = "fs-bold fs-4 ps-2" > Finished Jobs List   </span> 
    </div>    
    <div class = "d-flex justify-content-between align-middle ">
        <div class = "text-end me-3 mt-3" > 
            <div >
                <a class = "btn btn-sm btn-outline-info  position-relative" style = "text-decoration:none;" href="WareHouseRejectList.php">
                    Rejected Jobs
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> <?=$Out['Id']?>+  </span>
                </a>
            </div>
            <!-- <div ><a class = "btn btn-sm btn-outline-danger " style = "text-decoration:none;" href="ManualCycle.php">Rejected Jobs</a></div> -->
        </div>
        <div class = "text-end me-2 mt-3" >
            <div ><a class = "btn btn-sm btn-outline-warning " style = "text-decoration:none;" href="ManualCycle.php">Manual</a></div>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control"  id = "Search_input"  style = "width:500px;" placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
            <label for="Reel">Search Anything</label>
        </div>
    </div>
    </div>
</div>

            

<div class="card shadow m-3   mt-0 " >
    <div class="card-body">
        <table class = "table" id = "JobTable">
            <tr class = "table-info" >
                <th>#</th>
                <th>JobNo</th>
                <th>Description</th>
                <th>Customer</th>
                <th>Order Qty</th>
                <th>Produced Qty</th>
                <th>Plan Qty</th>
                <th class="text-center">OPS</th>
            </tr>

            <tr>
                <?php $counter = 1;  while($Rows=$DataRows->fetch_assoc())  { ?>

                        <?php 
                            $used_machine  = $Controller->QueryData('SELECT * FROM used_machine 
                            INNER JOIN machine ON used_machine.machine_id = machine.machine_id WHERE cycle_id = ? ',[ $Rows['cycle_id']]);
                            $last_machine_produced_qty = 0 ; 
                            $flag=0;
                            while($um = $used_machine->fetch_assoc()){ 
                                if(!empty($um['produced_qty'])) {
                                    $last_machine_produced_qty = $um['produced_qty']; 
                                } 
                            }
                        ?>

                        <tr class ="p-0" >
                        <td><?=$counter++; ?></td>
                            <td><?=$Rows['JobNo']?></td>
                            <td><?=$Rows['ProductName'] . ' ( '. $Rows['Size'] .' ) ' . $Rows['CTNType'] .'Ply - ' . $Rows['CTNUnit'] ?></td>
                            <td><?=$Rows['CustName']?></td>
                            <td><?=$Rows['CTNQTY']?></td>
                            <td><?=$Rows['ProductQTY']?></td>
                            <td><?=$Rows['cycle_plan_qty']?></td>
                           
                            <td> 
                                <!-- cycle_id , cycle_status , cycle_plan_qty -->
                            <?php if($Rows['cycle_status'] == 'Finish List') {?>
                                <a type="button"  onclick = "AddCycleForCProduction(<?=$Rows['CustId1']?>,<?=$Rows['cycle_id']?>,<?=$Rows['CTNId']?>,`<?=$Rows['JobNo']?>`,`<?=$Rows['ProductName']?>`,<?=$Rows['CTNQTY']?> , `<?=$last_machine_produced_qty?>`)" data-bs-toggle="modal" data-bs-target="#exampleModal1" class="btn btn-outline-success btn-sm ">   
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                    </svg> Register
                                </a> 
                            <?php  } // END OF COMPLETED IF BLOCK  ?>

                            <?php if(isset($Rows['DesignImage']) && !empty($Rows['DesignImage']) )  {    ?>
                                <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                    href="../Design/ShowDesignImage.php?Url=<?=$Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                                        <svg width = "35px" height = "35px"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier"> <path d="M18 4.25H6C5.27065 4.25 4.57118 4.53973 4.05546 5.05546C3.53973 5.57118 3.25 6.27065 3.25 7V17C3.25 17.7293 3.53973 18.4288 4.05546 18.9445C4.57118 19.4603 5.27065 19.75 6 19.75H18C18.7293 19.75 19.4288 19.4603 19.9445 18.9445C20.4603 18.4288 20.75 17.7293 20.75 17V7C20.75 6.27065 20.4603 5.57118 19.9445 5.05546C19.4288 4.53973 18.7293 4.25 18 4.25ZM6 5.75H18C18.3315 5.75 18.6495 5.8817 18.8839 6.11612C19.1183 6.35054 19.25 6.66848 19.25 7V15.19L16.53 12.47C16.4589 12.394 16.3717 12.3348 16.2748 12.2968C16.178 12.2587 16.0738 12.2427 15.97 12.25C15.865 12.2561 15.7622 12.2831 15.6678 12.3295C15.5733 12.3759 15.4891 12.4406 15.42 12.52L14.13 14.07L9.53 9.47C9.46222 9.39797 9.37993 9.34111 9.28858 9.30319C9.19723 9.26527 9.09887 9.24714 9 9.25C8.89496 9.25611 8.79221 9.28314 8.69776 9.32951C8.60331 9.37587 8.51908 9.44064 8.45 9.52L4.75 13.93V7C4.75 6.66848 4.8817 6.35054 5.11612 6.11612C5.35054 5.8817 5.66848 5.75 6 5.75ZM4.75 17V16.27L9.05 11.11L13.17 15.23L10.65 18.23H6C5.67192 18.23 5.35697 18.1011 5.12311 17.871C4.88926 17.6409 4.75525 17.328 4.75 17ZM18 18.25H12.6L16.05 14.11L19.2 17.26C19.1447 17.538 18.9951 17.7884 18.7764 17.9688C18.5577 18.1492 18.2835 18.2485 18 18.25Z" fill="#000000"></path> </g></svg>
                                </a>
                            <?php } else {  echo '<span class = "text-danger p-1" style = "border:2px solid red; border-radius:3px; "   >N/A</span>'; }  ?>  
                            

                            </td>
                        <tr class ="p-0" > 
                <?php } ?>
            </tr>
             
    
        </table>
    </div>
</div>

<!-- Modal : for registering cycle production -->
<div class="modal fade " id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="modal-title text-end" id="exampleModalLabel"> Cycle Finish Goods Form</strong>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="RegisterCycleToCartonProduction.php" method = "post" >
        <input type="hidden" name="CustId" id = "FJL_cust_id"  >
        <input type="hidden" name="CYCLE_ID" id = "FJL_cycle_id" >
        <input type="hidden" name="CTNId" id = "FJL_ctn_id"  >

        <div class="modal-body">
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-4">
                    <div class="form-floating ">
                        <input type="text" name = "JobNo" class="form-control "  id = "FJL_job_no"  placeholder  = "Job No" readonly>
                        <label for="floatingInput">Job No </label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-floating ">
                        <input type="text" name = "OrderQTY"   id = "FJL_order_qty" class="form-control " readonly  placeholder  = "Order QTY"   >
                        <label for="floatingInput">Order QTY</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-floating ">
                        <input type="text"    id = "last_machine_produced_qty" class="form-control " style = "border:2px solid #F7C04A" readonly  placeholder  = "آخرین تولید ماشین"   >
                        <label for="floatingInput">آخرین تولید ماشین</label>
                    </div>
                </div>


                

            </div>
            
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="form-floating ">
                        <input type="text"  class="form-control " readonly placeholder  = "Product Name" id = "FJL_product_name"     >
                        <label for="floatingInput">Product Name </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-3">
                    <div class="form-floating ">
                        <input type="text" name = "Plate" class="form-control " onchange = "InputValue(this.name , this.value)" placeholder  = "Plate" >
                        <label for="floatingInput">Plate </label>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-floating ">
                        <input type="text" name = "Line" class="form-control"   onchange = "InputValue(this.name , this.value)"placeholder  = "Line" >
                        <label for="floatingInput">Line</label>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-floating ">
                        <input type="text" name = "Pack" class="form-control "  onchange = "InputValue(this.name , this.value)" placeholder  = "Pack" >
                        <label for="floatingInput">Pack</label>
                    </div>
                </div>
                <div class="col-lg-3">

                <div class="form-floating ">
                        <input type="text" name = "ExtraPack" class="form-control" placeholder  = "Ex Packs" id = "ExtraPack"   onchange = "InputValue(this.name , this.value)"  >
                        <label for="floatingInput">Ex Packs</label>
                    </div>

                   
                </div>
            </div>

            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-4">
                    <div class="form-floating ">
                        <input type="text" name = "TotalPacks" id = "TotalPacks"  class="form-control " disabled placeholder  = "Carton" >
                        <label for="TotalPacks">Total Packs</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-floating ">
                        <input type="text" name = "Carton" class="form-control " id = "Carton" placeholder  = "Per Packs" onchange = "InputValue(this.name , this.value)" >
                        <label for="floatingInput">Per Packs</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-floating ">
                        <input type="text" name = "ExtraCarton" class="form-control " id = "ExtraCarton"   placeholder  = "Extra Carton" onchange = "InputValue(this.name , this.value)"  >
                        <label for="floatingInput">Extra Carton  </label>
                    </div>
                </div>
            </div>

            
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="form-floating ">
                        <input type="text" name = "Total" class="form-control " id = "Total" readonly  placeholder  = "Total QTY" >
                        <label for="floatingInput">Total </label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-floating">
                        <select class="form-select" name = "Unit" id="Unit" aria-label="Select Unit">
                            <option selected>Select Unit</option>
                            <option selected value="Production">Production</option>
                            <option value="Manual">Manual</option>
                        </select>
                        <label for="Unit">Unit</label>
                    </div>
                </div>
            </div>
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-primary">Save Cycle</button>
        </div>
      </form>
    </div>
  </div>
</div>




<script>
    function search(InputId ,tableId )  {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(InputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 1; i < tr.length; i++) {
            td = tr[i];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                } else {
                tr[i].style.display = "none";
                }
            }
        }
    }

    function AddCycleForCProduction(CustId, cycle_id , CTNId , JobNo , ProductName , CTNQTY , last_machine_produced_qty ){
       
        document.getElementById('FJL_cust_id').value = CustId; 
        document.getElementById('FJL_cycle_id').value = cycle_id; 
        document.getElementById('FJL_ctn_id').value = CTNId; 
        document.getElementById('FJL_job_no').value = JobNo; 
        document.getElementById('FJL_product_name').value = ProductName; 
        document.getElementById('FJL_order_qty').value = CTNQTY; 
        document.getElementById('last_machine_produced_qty').value = last_machine_produced_qty; 
        


    }

    let total = {}; 
    function InputValue(name , value)   {
        total[name] = value; 
        CalculatePlates(); 
    }
    
    function CalculatePlates(){
        let TotalPacks = 0 ; 
        let FinalTotal = 0 ; 
        TotalPacks = ( Number(total.Plate) * Number(total.Line) * Number(total.Pack) ) + Number(total.ExtraPack)  ;
        FinalTotal = (Number(total['Carton']) * Number(TotalPacks) ) + Number(total.ExtraCarton)
        document.getElementById('TotalPacks').value =  TotalPacks; 
        document.getElementById('Total').value =  FinalTotal; 
    }

</script>
<?php  require_once '../App/partials/Footer.inc'; ?>