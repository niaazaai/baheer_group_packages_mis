<?php ob_start(); require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';   ?>
<?php


    // SELECT ALL MACHINES FOR USER TO SELECT FOR EACH JOB CYCLE  
    $machine_db_list = $Controller->QueryData('SELECT * FROM machine WHERE machine_type=? ',['Manual']);

    $QueryInput = []; 
    $Query = "
    SELECT
        carton.CTNId,
        machine.machine_id,
        production_cycle.cycle_id,
        carton.JobNo,
        carton.ProductName,
        CONCAT( FORMAT(carton.CTNLength / 10 ,1 ) ,' x ',FORMAT(carton.CTNWidth / 10 , 1 ),' x ',FORMAT(carton.CTNHeight/ 10,1)) AS Size , 
        carton.CTNUnit,
        carton.CTNLength,
        carton.CTNWidth,
        carton.CTNHeight,
        carton.CTNType, 
        carton.CTNColor, 
        production_cycle.cycle_plan_qty,
        designinfo.DesignImage,
        
        machine.machine_name , used_machine.status
    FROM carton
        INNER JOIN production_cycle ON production_cycle.CTNId = carton.CTNId
        INNER JOIN used_machine ON production_cycle.cycle_id = used_machine.cycle_id
        INNER JOIN machine ON used_machine.machine_id = machine.machine_id
        LEFT JOIN designinfo ON carton.CTNId = designinfo.CaId
    WHERE  (cycle_status = 'Incomplete' OR cycle_status = 'Task List') AND has_manual = 'Yes' AND machine.machine_type = 'Manual' AND JobNo != 'NULL'  AND used_machine.status = 'Incomplete' "; 
  
        
    if(isset($_REQUEST['machine_id']) && !empty(trim($_REQUEST['machine_id']))){
        $condition = "AND machine.machine_id = ". $_REQUEST['machine_id']; 
        if($_REQUEST['machine_id'] == "ALL") $condition = ''; 
        $Query = "
        SELECT
            carton.CTNId,
            machine.machine_id,
            production_cycle.cycle_id,
            carton.JobNo,
            carton.ProductName,
            CONCAT( FORMAT(carton.CTNLength / 10 ,1 ) ,' x ',FORMAT(carton.CTNWidth / 10 , 1 ),' x ',FORMAT(carton.CTNHeight/ 10,1)) AS Size , 
            carton.CTNUnit,
            carton.CTNQTY, 
            carton.CTNType, 
            carton.CTNColor , 
            carton.ProductQTY, 
            designinfo.DesignImage,
            machine.machine_name,  used_machine.status
        FROM carton
            INNER JOIN production_cycle ON production_cycle.CTNId = carton.CTNId
            INNER JOIN used_machine ON production_cycle.cycle_id = used_machine.cycle_id
            INNER JOIN machine ON used_machine.machine_id = machine.machine_id
            LEFT JOIN designinfo ON carton.CTNId = designinfo.CaId
        WHERE  (cycle_status = 'Incomplete' OR cycle_status = 'Task List') AND has_manual = 'Yes' ".$condition." AND machine.machine_type = 'Manual' AND JobNo != 'NULL'   AND used_machine.status = 'Incomplete' "; 
       
    }

    // echo $Query; 
    
    $production_cycle  = $Controller->QueryData($Query  , $QueryInput ); 

    
    if(isset($_POST['SaveModalData']) && !empty($_POST['SaveModalData']))
    {

      
        $CycleId=$_POST['CycleId'];
        $CTNID=$_POST['CTNID'];
        $machine_id = $_POST['machine_id1']; 
        
        $MachineName=$_POST['MachineName'];

        $OperatorName=$_POST['OperatorName'];
        $NoOflabor=$_POST['NoOflabor'];
        $ProducedQTY=$_POST['ProducedQTY'];
        $Waste=$_POST['Waste'];
        $Date=$_POST['Date'];
        $StartTime=$_POST['StartTime'];
        $EndTime=$_POST['EndTime'];
      
        // foreach ($_POST as $key => $value) {
        //     $_POST[$key] = $Controller->CleanInput($_POST[$key]); 
            
        // }
        
        // echo "<pre>"; 
        // var_dump($_POST); 
        // echo "<pre>"; 
 
        $InsertQuery=$Controller->QueryData("INSERT INTO machineproduction (Ctnid2,UserId2,MachineName,PrBranch,ProductQty1,WorkStartTime,WorkEndTime,PrDate,MachineOperatorName,LaborNumber,PrStatus,Waste,cycle_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)",
        [ $CTNID,$_SESSION['EId'], $MachineName,'Manual' ,$ProducedQTY,$StartTime,$EndTime,$Date,$OperatorName,$NoOflabor,'New',$Waste,$CycleId]);

        if($InsertQuery)
        {
            $Controller->QueryData('UPDATE used_machine SET status = "Complete" WHERE cycle_id = ? AND machine_id = ? '  , [$CycleId ,$machine_id ] ); 

            ?>
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <strong>Well done!</strong>Produced QTY is Saved.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
        else {
            echo '<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <strong> Alert! </strong> Somthing Went Wrong!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'; 
        }

    }
 
?>
 
 <style>
    .wrap {
        text-align: center;
        margin: 0px;
        position: relative;
    }
    .links {
        padding: 0 0px;
        display: flex;
        justify-content: space-between;
        position: relative;
    }
    .wrap:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        border-top: 2px solid black;
        background: black;
        width: 100%;
        transform: translateY(-50%);
    }
    .dot {
        width: 50px;
        height: 25px;
        background: #dc3545;;
        color:white; 
        font-weight:bold; 
        border-radius:3px; 
    }
 </style>

 
<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between">
        <h4 class = "p-0 m-0" >
            <svg   
                width="45" height="35" viewBox="0 0 122.709 122.709" style="enable-background:new 0 0 122.709 122.709;"
                xml:space="preserve">
                    <circle cx="92.693" cy="12.698" r="12.698"/>
                    <path d="M119.508,63.918c-2.947-20.103-7.412-28.714-18.37-35.433c-0.212-0.129-0.435-0.223-0.657-0.319
                        c-1.415-0.942-3.002-1.636-4.622-2.034l-3.165,3.184l-3.066-3.219c-0.01,0.001-0.021,0.003-0.031,0.007
                        c-1.547,0.369-3.064,1.013-4.434,1.886c-0.006,0.001-0.01,0.003-0.014,0.003c-2.061,0.961-20.434,12.671-17.929,22.964
                        c1.381,5.683,7.411,7.329,12.477,7.744v6.498c0,1.326,0.259,2.562,0.712,3.699c-0.035,0.258-0.06,0.518-0.06,0.781l0.003,47.205
                        c0,3.217,2.609,5.824,5.826,5.824c3.218,0,5.824-2.609,5.824-5.827v-40.51c0.229,0.012,0.461,0.028,0.691,0.028
                        c0.046,0,0.092-0.004,0.137-0.006l-0.002,40.486c0,3.219,2.608,5.827,5.826,5.827c3.219,0,5.826-2.608,5.826-5.827l0.001-46.912
                        c0.763-1.414,1.207-3.017,1.207-4.771V48.218c1.578,3.938,2.924,9.347,4.063,17.129c0.36,2.453,2.465,4.217,4.873,4.217
                        c0.237,0,0.478-0.018,0.72-0.055C118.039,69.117,119.903,66.611,119.508,63.918z M79.696,48.776
                        c-1.35-0.147-2.188-0.372-2.677-0.548c0.4-0.982,1.4-2.288,2.677-3.667V48.776z M107.039,40.953l-9.414,20.443
                        c-0.439,0.959-1.433,1.58-2.528,1.58c-0.435,0-0.854-0.094-1.252-0.277l-8.527-3.926c0.181-0.005,0.356-0.013,0.517-0.021
                        c0.764-0.031,1.472-0.251,2.104-0.591c0.023,0.328,0.207,0.635,0.525,0.782l5.449,2.509c0.327,0.149,0.676,0.228,1.025,0.228
                        c0.245,0,0.488-0.039,0.727-0.115c0.6-0.191,1.07-0.605,1.328-1.164l8.684-18.86c0.256-0.558,0.265-1.185,0.021-1.767
                        c-0.231-0.553-0.667-0.999-1.226-1.256l-12.436-5.727c-1.182-0.539-2.562-0.069-3.078,1.054l-6.324,13.736
                        c-0.215,0.469-0.01,1.02,0.457,1.234c0.466,0.216,1.019,0.011,1.232-0.455l6.324-13.738c0.087-0.188,0.368-0.254,0.611-0.141
                        l12.435,5.725c0.134,0.062,0.237,0.165,0.289,0.287c0.026,0.067,0.052,0.166,0.005,0.268l-8.684,18.862
                        c-0.047,0.101-0.141,0.149-0.209,0.171c-0.127,0.043-0.27,0.03-0.403-0.031l-5.448-2.51c-0.022-0.009-0.047-0.008-0.07-0.017
                        c0.899-0.936,1.438-2.218,1.379-3.617c-0.114-2.72-2.436-4.845-5.133-4.718c-1.955,0.083-3.5,0.054-4.726-0.034l7.615-16.538
                        c0.442-0.96,1.435-1.58,2.53-1.58c0.433,0,0.854,0.092,1.254,0.276l0.363,0.168l0.209-1.407h0.06l0.247,1.643l12.598,5.801
                        C107.017,37.899,107.676,39.566,107.039,40.953z"/>
                    <path d="M77.107,63.281l-2.074-1.775c-4.703-1.889-7.334-4.802-8.793-7.522l-8.248-7.059v15.241L40.182,46.924v19.01H28.253
                        l-2.421-42.8H7.326l-4.177,81.957h15.481V85.666h10.321v19.426h1.518h47.28l-0.004-37.586
                        C77.353,66.131,77.146,64.716,77.107,63.281z"/>
                    <path d="M17.222,17.19c0.642-0.28,1.325-0.578,2.032-0.85c0.705-0.267,1.432-0.523,2.123-0.668
                        c0.674-0.166,1.328-0.181,1.623-0.08c0.295,0.137,0.205,0.12,0.417,0.412c0.024,0.032,0.048,0.075,0.073,0.122l0.188,0.32
                        l0.147,0.231l0.188,0.275c0.122,0.159,0.233,0.313,0.37,0.464c0.534,0.6,1.245,1.146,2.042,1.5
                        c0.796,0.357,1.642,0.483,2.386,0.486c0.751,0.011,1.415-0.142,2.007-0.309c1.178-0.362,2.09-0.9,2.863-1.463
                        c0.772-0.561,1.402-1.16,1.935-1.743c1.06-1.171,1.743-2.273,2.144-3.106c0.42-0.812,0.566-1.342,0.566-1.342
                        S37.8,11.594,36.972,11.9c-0.42,0.146-0.922,0.322-1.474,0.531c-0.54,0.2-1.148,0.427-1.812,0.674
                        c-0.647,0.233-1.333,0.471-2.018,0.673c-0.684,0.198-1.378,0.354-1.952,0.392c-0.586,0.037-0.941-0.075-1.029-0.169
                        c-0.061-0.041-0.117-0.087-0.212-0.204c-0.026-0.021-0.053-0.063-0.083-0.089l-0.016-0.02c-0.006-0.004-0.009,0.003-0.051-0.066
                        l-0.186-0.293c-0.096-0.159-0.201-0.318-0.32-0.478c-0.448-0.64-1.115-1.245-1.895-1.685c-0.785-0.44-1.668-0.665-2.457-0.689
                        c-1.593-0.062-2.783,0.42-3.773,0.896c-0.979,0.515-1.78,1.096-2.471,1.694c-0.69,0.6-1.277,1.204-1.775,1.793
                        c-0.501,0.586-0.918,1.149-1.263,1.667c-0.352,0.51-0.61,0.995-0.832,1.379c-0.425,0.788-0.603,1.28-0.603,1.28
                        s0.483-0.2,1.281-0.557C14.798,18.286,15.899,17.788,17.222,17.19z"/>
            </svg>
            Assigned Job List
        </h4>
    </div>
</div>
 


<div class="card m-3 shadow">
    <div class="card-body">
        <div class="row">

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <form action="" method = "post"  >
                    <div class="form-floating">
                        <select class="form-select form-sm" id="SelectFluteType" aria-label="Fluting Type" name = "machine_id" onchange="this.form.submit();" >
                                <option selected>Machines</option>
                                <option value="ALL">ALL</option>
                                <?php if ($machine_db_list->num_rows > 0) {  while($MACHINE = $machine_db_list->fetch_assoc()){    ?> 
                                    <option value="<?= $MACHINE['machine_id'] ?> "><?= $MACHINE['machine_name'] ?> </option>
                                <?php  } } else echo "Machine query has errors!"; ?>
                        </select>
                        <label for="SelectFluteType">Select Machines </label>
                    </div>
                </form>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                     <div class="form-floating">
                        <input type="text" class="form-control"  id = "Search_input" placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
                        <label for="Reel">Search Anything</label>
                    </div>
            </div>
         
                <?php if(isset($_REQUEST['machine_id']) && !empty(trim($_REQUEST['machine_id']))){?>
            <?php if( $_REQUEST['machine_id'] != 'ALL' ) { ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 d-flex justify-content-end">
                <form action="PrintManualMachineJobs.php" method = "post" >
                    <input type="hidden" name="Query" value = "<?=$Query?>">
                    <input type="hidden" name="machine_id" value = "<?=(isset($_REQUEST['machine_id'])) ? $_REQUEST['machine_id']: 'ALL' ?>">
                    <button type = "submit"  class="btn btn-outline-primary  my-2"  title = "Click to Print Customer List ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                        </svg>
                        Print
                    </button>
            
                </form>
            </div>
            <?php } }?>                     

        </div>
    </div>
</div>

<div class="card m-3 shadow ">
    <div class="card-body">
        <table class="table " id="JobTable">
            <thead>
                <tr class="table-info">
                    <th>#</th>
                    <th title="Job No">Job No</th>
                    <th>Product Name</th>
                    <th>Size(cm)</th>    
                    <th>Total W & L</th> 
                    <th>Color</th>
                    <th>Type</th>
                    <th>Plan Qty</th>
                    <th>Machines</th>
                    <th>OPS</th>
                </tr>
            </thead>
            <tbody>
                <?php  $counter = 1 ; if($production_cycle->num_rows > 0 ){    ?>
                    <?php while ($cycle = $production_cycle->fetch_assoc()) { ?>

                        <tr>
                            <td><?=$counter++?></td>
                            <td><?= $cycle['JobNo'] ?></td>
                            <td><?= $cycle['ProductName'] ?></td>
                            <td><?= '(' . $cycle['Size'].') <span class = "badge bg-info" >'. $cycle['CTNType'] . 'Ply </span>'  ?></td>
                            <td>
                                <?php 
                                    $total_width = $cycle['CTNWidth'] + $cycle['CTNHeight'] ; 
                                    $total_length = ($cycle['CTNLength'] + $cycle['CTNWidth']) * 2 +3 ; 
                                    echo $total_width . ' & ' . $total_length; 
                                ?>
                            </td>
                            <td><?=$cycle['CTNColor'];?></td>
                            <td><?= $cycle['CTNUnit'];  ?></td>
                            <td><?= $cycle['cycle_plan_qty']; ?></td>
                            <td> <?=$cycle['machine_name']?></td>
                            <td> 
                                <a type="button" class= "btn btn-outline-success m-0 btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick = "AddCycleId(<?=$cycle['cycle_id'];?>,'<?=$cycle['machine_name']?>',<?=$cycle['CTNId']?> , <?=$cycle['machine_id'];?>)" > 
                                    <svg width="20px" height="20px" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="48" height="48" fill="white" fill-opacity="0.01"></rect>
                                        <path d="M14 24L15.25 25.25M44 14L24 34L22.75 32.75" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M4 24L14 34L34 14" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    Finish
                                </a>
                                <a class = "btn btn-outline-dark btn-sm" style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                    href="../Design/ShowDesignImage.php?Url=<?= $cycle['DesignImage']?>&ProductName=<?= $cycle['ProductName']?>" >  View Image
                                </a>
                            </td>
                        </tr>

                    <?php } // END OF NUMROWS FIRST LOOP  ?>
                <?php } // END OF NUMROWS FIRST LOOP  ?>

            </tbody>
        </table>
    </div>
</div>

 
<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg ">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="modal-title text-end" id="exampleModalLabel">لطف نموده ماشین مورد نظر خود را انتخاب نمایید</strong>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" id = "machine_form" method="post">
        <input type="hidden" name="CycleId" id="CycleId"  >
        <input type="hidden" name="CTNID" id="CTNID" > 
        <input type="hidden" name="machine_id1" id="machine_id1" > 
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="MachineName" name="MachineName" readonly>
                        <label for="">Machine Name</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="OperatorName" name="OperatorName" >
                        <label for="">Operator Name</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="NoOflabor" name="NoOflabor" >
                        <label for="">No Of Labor</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="ProducedQTY" name="ProducedQTY">
                        <label for="">Produced QTY</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="Waste" name="Waste">
                        <label for="">Waste</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="Date" name="Date" >
                        <label for=""> Date</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="datetime-local" class="form-control" id="StartTime" name="StartTime" >
                        <label for="">Start Time</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="datetime-local" class="form-control" id="EndTime" name="EndTime" >
                        <label for="">End Time</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="SaveModalData" value = '1' >Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>




<script>

    function AddCycleId(cycle_id  ){
        document.getElementById('CYCLE_ID_').value = cycle_id; 
    }

    function AddCycleForCProduction(cycle_id){
        document.getElementById('CYCLE_ID_Pro').value = cycle_id; 
    }
     
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

    function AddCycleId(CycleId,MachineName,CTNId ,maid)
    {
        document.getElementById("CycleId").value=CycleId;
        document.getElementById("CTNID").value=CTNId;
        document.getElementById("MachineName").value=MachineName;
        document.getElementById("machine_id1").value=maid;

        

        
    }

</script>
    

<?php  require_once '../App/partials/Footer.inc'; ?>