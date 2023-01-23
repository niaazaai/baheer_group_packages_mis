<?php 
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc';

    $machine = $Controller->QueryData("SELECT * FROM machine WHERE machine_opreator_id = ? ",[$_SESSION['EId']]);
   
    if($machine->num_rows > 0 ){
        $machine = $machine->fetch_assoc(); 
    }
    else {
        $machine = []; 
        $machine['machine_name'] = 'ALL';
        $machine['machine_opreator_id'] = null;
    } 
    
    $table_heading = ''; 
    $table_query = ''; 
    $table_query_input = [$machine['machine_opreator_id']]; 

    switch (trim($machine['machine_name'])) {
        case 'Carrogation 5 Ply':  
        case 'Carrogation 3 Ply':
            $table_heading = '
                <th>#</th>
                <th>JobNo</th>
                <th>Size (LxWxH) cm</th>
                <th>Type</th>
                <th>Ply</th>
                <th>Product Name</th>
                <th>Flute</th>
                <th>Order Qty</th>
                <th>Reel</th>
                <th>Creasing</th>
                <th>Cut Qty</th>
                <th>APP</th>
                <th>Comment</th>
                <th>D-Status</th>
                <th class="text-center">OPS</th>'; 
            $table_query = "SELECT carton.CTNId, machine.machine_id , production_cycle.cycle_id ,carton.JobNo, CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size ,CTNUnit,CTNType,carton.ProductName , carton.CFluteType ,  carton.CTNQTY , used_paper.reel ,
            used_paper.creesing , production_cycle.cut_qty , used_paper.ups , used_paper.comment, used_machine.double_job 
            FROM carton 
            INNER JOIN  production_cycle on production_cycle.CTNId = carton.CTNId 
            INNER JOIN  used_machine on production_cycle.cycle_id = used_machine.cycle_id 
            INNER JOIN  machine on used_machine.machine_id = machine.machine_id 
            INNER JOIN  used_paper on carton.CTNId = used_paper.carton_id 
            WHERE production_cycle.cycle_status = 'Task List' AND used_machine.status = 'My_Job' AND  machine.machine_opreator_id = ?";
        break;

        case 'Flexo #1':  
        case 'Flexo #2':
            $table_heading = '
                <th>#</th>
                <th>JobNo</th>
                <th>Size (LxWxH)</th>
                <th>Type</th>
                <th>Ply</th>
                <th>Product Name</th>
                <th>color</th>
                <th>Order Qty</th>
                <th>Comment</th>
                <th>D-Status</th>
                <th class="text-center">OPS</th>'; 
            $table_query = "SELECT carton.CTNId, machine.machine_id , production_cycle.cycle_id , carton.JobNo,  CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,
                CTNUnit,CTNType,carton.ProductName , CTNColor , carton.CTNQTY , used_paper.comment  , used_machine.double_job 
                FROM carton
                INNER JOIN  production_cycle on production_cycle.CTNId = carton.CTNId 
                INNER JOIN  used_machine on production_cycle.cycle_id = used_machine.cycle_id 
                INNER JOIN  machine on used_machine.machine_id = machine.machine_id 
                INNER JOIN  used_paper on carton.CTNId = used_paper.carton_id 
                WHERE cycle_status = 'Task List' AND used_machine.status = 'My_Job'  AND machine.machine_opreator_id = ?"; 
        break; 

        case 'Glue Folder':
            $table_heading = '
                <th>#</th>
                <th>JobNo</th>
                <th>Product Name</th> 
                <th>Size (LxWxH) cm</th>
                <th>Type</th> 
                <th>Ply</th>
                <th>Color</th>
                <th>D-Status</th>
                <th class="text-center">OPS</th>'; 
            $table_query = "SELECT carton.CTNId, machine.machine_id , production_cycle.cycle_id , carton.JobNo, carton.ProductName , CONCAT( FORMAT(carton.CTNLength / 10 ,1 ) , ' x ',FORMAT (carton.CTNWidth / 10 , 1 ), ' x ', FORMAT(carton.CTNHeight/ 10,1) ) AS Size  ,
                CTNUnit , CTNType , CTNColor, used_machine.double_job 
                FROM carton
                INNER JOIN  production_cycle on production_cycle.CTNId = carton.CTNId 
                INNER JOIN  used_machine on production_cycle.cycle_id = used_machine.cycle_id 
                INNER JOIN  machine on used_machine.machine_id = machine.machine_id 
                INNER JOIN  used_paper on carton.CTNId = used_paper.carton_id 
                WHERE cycle_status = 'Task List' AND used_machine.status = 'My_Job'  AND machine.machine_opreator_id = ?";
        break; 

        default:
        $table_heading = '
            <th>#</th>
            <th>JobNo</th>
            <th>Size (LxWxH) cm</th>
            <th>Type</th>
            <th>Product Name</th>
            <th>Color</th> 
            <th>Order Qt</th>
            <th>Cut Qt</th>
            <th>APP</th>
            <th>Machine</th>
            <th>D-Status</th>
            <th class="text-center">OPS</th>'; 
        $table_query = "SELECT carton.CTNId, machine.machine_id , production_cycle.cycle_id , 
            carton.JobNo ,  CONCAT( FORMAT(CTNLength / 10 ,1 ) , 'x' , FORMAT ( CTNWidth / 10 , 1 ), 'x', FORMAT(CTNHeight/ 10,1) ) AS Size ,  
            CTNUnit ,carton.ProductName , carton.CTNColor  ,  carton.CTNQTY , production_cycle.cut_qty , used_paper.ups , used_machine.double_job , machine.machine_name
            FROM carton  
            INNER JOIN  production_cycle on production_cycle.CTNId = carton.CTNId 
            INNER JOIN  used_machine on production_cycle.cycle_id = used_machine.cycle_id 
            INNER JOIN  machine on used_machine.machine_id = machine.machine_id 
            INNER JOIN  used_paper on carton.CTNId = used_paper.carton_id 
            WHERE cycle_status = 'Task List' AND used_machine.status = 'My_Job'  ";
            $table_query_input= []; 
        break;
    }
   
    $DataRows=$Controller->QueryData($table_query,$table_query_input);
?>

<div class=" m-3">
    <div class="card " >
      <div class="card-body d-flex justify-content-between align-item-center shadow">
            <h3 class="m-0 p-0"> 
                <a class="btn btn-outline-primary   me-1" href="index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                    </svg>
                </a>
                <svg width="50" height="50" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.38 23.3599H14.62C14.421 23.3599 14.26 23.1989 14.26 22.9999V21.4329L13.391 21.0699L12.28 22.1809C12.213 22.2479 12.121 22.2859 12.026 22.2859C11.93 22.2859 11.839 22.2479 11.772 22.1809L9.82001 20.2289C9.67901 20.0879 9.67901 19.8599 9.82001 19.7189L10.928 18.6119L10.571 17.7409H9.00001C8.80101 17.7409 8.64001 17.5799 8.64001 17.3809V14.6209C8.64001 14.4219 8.80101 14.2609 9.00001 14.2609H10.567L10.93 13.3919L9.82001 12.2799C9.68001 12.1389 9.68001 11.9119 9.82001 11.7709L11.771 9.81889C11.906 9.68289 12.145 9.68289 12.28 9.81889L13.388 10.9279L14.26 10.5709V8.99989C14.26 8.80089 14.421 8.63989 14.62 8.63989H17.38C17.579 8.63989 17.74 8.80089 17.74 8.99989V10.5669L18.608 10.9299L19.718 9.81889C19.853 9.68389 20.093 9.68289 20.228 9.81889L22.18 11.7709C22.247 11.8379 22.285 11.9299 22.285 12.0249C22.285 12.1209 22.247 12.2119 22.18 12.2789L21.071 13.3869L21.428 14.2589H23C23.199 14.2589 23.36 14.4199 23.36 14.6189V17.3789C23.36 17.5779 23.199 17.7389 23 17.7389H21.433L21.07 18.6069L22.181 19.7169C22.248 19.7839 22.286 19.8759 22.286 19.9719C22.286 20.0679 22.248 20.1599 22.181 20.2269L20.229 22.1789C20.162 22.2459 20.07 22.2839 19.974 22.2839C19.878 22.2839 19.786 22.2459 19.719 22.1789L18.612 21.0699L17.741 21.4269V22.9999C17.74 23.1989 17.579 23.3599 17.38 23.3599ZM14.98 22.6399H17.02V21.1879C17.02 21.0419 17.109 20.9109 17.244 20.8549L18.56 20.3149C18.694 20.2579 18.848 20.2909 18.952 20.3929L19.974 21.4169L21.417 19.9739L20.389 18.9479C20.286 18.8439 20.255 18.6889 20.312 18.5539L20.862 17.2419C20.918 17.1079 21.049 17.0199 21.194 17.0199H22.64V14.9799H21.188C21.042 14.9799 20.911 14.8919 20.855 14.7569L20.315 13.4409C20.26 13.3069 20.291 13.1519 20.393 13.0499L21.417 12.0269L19.974 10.5839L18.948 11.6109C18.844 11.7139 18.689 11.7459 18.554 11.6889L17.242 11.1399C17.108 11.0839 17.02 10.9529 17.02 10.8079V9.35989H14.98V10.8119C14.98 10.9579 14.892 11.0899 14.757 11.1449L13.441 11.6849C13.306 11.7389 13.153 11.7089 13.05 11.6059L12.027 10.5829L10.585 12.0259L11.612 13.0539C11.715 13.1569 11.746 13.3129 11.689 13.4479L11.14 14.7599C11.084 14.8939 10.953 14.9809 10.808 14.9809H9.36001V17.0209H10.812C10.958 17.0209 11.09 17.1099 11.145 17.2449L11.685 18.5609C11.74 18.6959 11.709 18.8499 11.606 18.9529L10.584 19.9749L12.026 21.4179L13.054 20.3899C13.158 20.2859 13.313 20.2569 13.448 20.3129L14.76 20.8629C14.894 20.9189 14.981 21.0499 14.981 21.1949L14.98 22.6399ZM16 19.3599C14.147 19.3599 12.64 17.8519 12.64 15.9999C12.64 14.1479 14.147 12.6399 16 12.6399C17.853 12.6399 19.36 14.1469 19.36 15.9999C19.36 17.8529 17.853 19.3599 16 19.3599ZM16 13.3599C14.544 13.3599 13.36 14.5449 13.36 15.9999C13.36 17.4559 14.545 18.6399 16 18.6399C17.456 18.6399 18.64 17.4559 18.64 15.9999C18.64 14.5439 17.456 13.3599 16 13.3599ZM16 31.3599C11.471 31.3599 7.28401 29.4269 4.36001 26.0219V29.9999H3.64001V24.6399H9.00001V25.3609H4.74301C7.53601 28.7249 11.598 30.6399 16 30.6399C24.072 30.6399 30.64 24.0729 30.64 15.9999H31.361C31.36 24.4699 24.47 31.3599 16 31.3599ZM1.36001 15.9999H0.640015C0.640015 7.52989 7.53001 0.639893 16 0.639893C20.529 0.639893 24.716 2.57289 27.64 5.97689V1.99989H28.361V7.35989H23V6.63989H27.257C24.464 3.27489 20.401 1.35989 16 1.35989C7.92701 1.35989 1.36001 7.92689 1.36001 15.9999Z" fill="#38E54D"/>
                </svg> <span style = "color:#38E54D">Under Process Jobs</span>  
            </h3>
            <div class= "mt-1">
                
                <span class = "me-2" style = "font-weight:bold; border:2px solid red; border-radius:3px; padding:3px; " > <?=$machine['machine_name']?> </span>
                <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                    </svg>
                </a>
                <a class="btn btn-outline-success " data-bs-toggle="collapse" href="#colapse1" role="button" aria-expanded="false"  > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg> Search   
                </a>
            </div>
        </div>
    </div>
</div>

<div class="collapse shadow" style="position: absolute; z-index: 1000; width: 60%; left: 39%; margin-top:-21px; " id="colapse1">
    <div class="card card-body border shadow">
        <div class="row">
            <div class="col-3">
                <div class="form-floating ">
                    <select class="form-select" id="machine_name" aria-label="Floating label select example" name="machine_name">
                        <option value="C5P">Carrogation 5 Ply</option>
                        <option value="C3P">Carrogation 3 Ply</option>
                        <option value="NF1">Flexo #1</option>
                        <option value="NF2">Flexo #2  </option>
                        <option value="GF">Glue Folder  </option>
                    </select>
                    <label for="machine_name">Select Machine</label>
                </div>
            </div>
            <div class="col-9">
                <div class="form-floating">
                    <input type="text" class="form-control"  id = "Search_input" placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
                    <label for="Reel">Search Anything</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow m-3 " >
    <div class="card-body">
        <table class = "table" id = "JobTable" >
            <tr class="table-info"><?=$table_heading; ?></tr>

            <?php
            if($DataRows->num_rows){   $counter = 1 ;   $Total_OQ = 0 ; 
                while ($Rows = $DataRows->fetch_assoc() ) {    $Total_OQ += $Rows['CTNQTY']; ?>
                <tr>
                    <td><?=$counter++; ?></td>
                    <?php foreach ($Rows  as $key => $value) { ?>
                        <?php  if($key == 'CTNId' || $key == 'cycle_id' || $key == 'machine_id') continue; ?>
                        <td><?php 
                                if($key == "CFluteType"){
                                    if($machine['machine_name'] == 'Carrogation 5 Ply') $value = 'BC'; 
                                    if($machine['machine_name'] == 'Carrogation 3 Ply') $value = 'C';  
                                }
                                echo $value;
                            ?>
                        <?=($key == 'CTNType') ? ' Ply' : '' ?></td>
                    <?php } // END OF FOREACH  ?>  

                    <td class = "text-center">
                        <a type="button" href="JobProcessingForm.php?CTNId=<?=$Rows['CTNId']?>&CYCLE_ID=<?=$Rows['cycle_id']?>&machine_id=<?=$Rows['machine_id']?>&Page=MachineOpreatorList" class="btn btn-outline-success btn-sm ">   
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="p-0 m-0" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"></path>
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"></path>
                            </svg>
                            Process  
                        </a>
                    </td>
                </tr>
            <?php 
                } // END OF WHILE LOOP 
                    echo '<tr> <td colspan = 10  class = "text-center" > <strong> Total Quantity </strong></td>
                        <td> <strong>' . number_format($Total_OQ) . '</strong> </td>
                        <td colspan = 2 ></td>  </tr>'; 
                } // END OF IF CONDITION 
            ?>
        </table>
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

    function PutSearchTermToInputBox(input) {
        document.getElementById('Search_input').value = input; 
        search('Search_input' ,'JobTable');  
    }

</script>
<?php  require_once '../App/partials/Footer.inc'; ?>




