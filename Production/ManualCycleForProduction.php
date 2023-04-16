<?php ob_start(); require_once '../App/partials/Header.inc';

$Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
if(!in_array( $Gate['VIEW_MANUAL_JOB_LIST_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
  header("Location:index.php?msg=You are not authorized to access Manual Page!" );
}
require_once '../App/partials/Menu/MarketingMenu.inc';  




if( isset($_GET['cycle_id']) && trim(!empty($_GET['cycle_id']))) {
    $cycle_id = $Controller->CleanInput($_GET['cycle_id']); 
    $Status  = $Controller->QueryData('UPDATE production_cycle SET manual_status = "Production Complete"  WHERE cycle_id = ? ', [$cycle_id]);
    if(!$Status) {
        echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>OOPS!</strong> Something Went Wrong!.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'; 
    }
}



?>
<?php
    $production_cycle  = $Controller->QueryData("SELECT 
    production_cycle.*, carton.JobNo,carton.CTNId,  carton.ProductName  , CTNLength,CTNWidth,CTNHeight,DesignImage,
    CONCAT( FORMAT(carton.CTNLength / 10 ,1 ) ,' x ',FORMAT(carton.CTNWidth / 10 , 1 ),' x ',FORMAT(carton.CTNHeight/ 10,1)) AS Size 
    , CTNUnit ,CTNType,  CTNQTY , CTNColor , ProductQTY 
    FROM production_cycle
    INNER JOIN carton ON production_cycle.CTNId = carton.CTNId
    LEFT JOIN designinfo ON carton.CTNId = designinfo.CaId
    WHERE (cycle_status = 'Incomplete' OR cycle_status = 'Task List') AND has_manual = 'Yes' AND manual_status = 'Complete' ",[]);

        // SELECT ALL MACHINES FOR USER TO SELECT FOR EACH JOB CYCLE  
    $machine_db_list = $Controller->QueryData('SELECT * FROM machine WHERE machine_type=? ',['Manual']);
?>
<div class="card m-3">
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
            Manual Section Job List ( Completed )
        </h4>
        <div>
            <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style="margin-top:4px;" title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a>
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
                    <th>Assigned</th>
                    <th>OPS</th>

                    <!-- , CTNUnit ,CTNType,  CTNQTY , CTNColor , ProductQTY  -->
                </tr>
            </thead>
            <tbody>
             <?php  $counter = 1 ;  if($production_cycle->num_rows > 0 ){   ?>
                <?php while ($cycle = $production_cycle->fetch_assoc()) { ?>

                    <tr>
                        <td><?=$counter++;?></td>
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

                        <td style = "max-width:300px;">
                            <div class="accordion accordion-flush " style = "max-width:300px;"  id="accordionFlushExample">
                                <div class="accordion-item" >
                                    <h6 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button btn-sm collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne<?=$cycle['cycle_id'];?>" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Mac- <?=$cycle['cycle_id'];?>
                                    </button>
                                    </h6>
                                    <div id="flush-collapseOne<?=$cycle['cycle_id'];?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body m-0 p-0"> 
                                        <ol class="list-group mt-2">
                                            <?php  
                                            $machines_cycle  = $Controller->QueryData('SELECT *  FROM  production_cycle 
                                            LEFT JOIN used_machine ON production_cycle.cycle_id = used_machine.cycle_id 
                                            LEFT JOIN machine ON used_machine.machine_id = machine.machine_id 
                                            WHERE production_cycle.cycle_id = ? && production_cycle.CTNId= ? && machine.machine_type = "Manual"',[$cycle['cycle_id'] , $cycle['CTNId']  ]);

                                            $complete_style = ''; 
                                            $show_complete_btn = true; 

                                            if($machines_cycle->num_rows > 0 ){
                                                while($job = $machines_cycle->fetch_assoc()  ) {  //echo $job['machine_name']; 
                                                if($job['status'] == 'Complete') $complete_style = 'background-color:#3EC70B;'; 
                                                else  $complete_style = '';    
                                            ?>
                                                <li class="list-group-item d-flex justify-content-between" style = "font-size:12px; <?=$complete_style?>">
                                                    <div style = "  font-size:medium;" ><?=$job['machine_name']?></div>
                                                    <div>
                                                        <?php if($job['status'] == 'Complete') { ?>
                                                            <span style = "font-size:medium;"> <?=$job['produced_qty']?> </span>
                                                        <?php } else { $show_complete_btn = false; ?>
                                                            <a href="RemoveUsedMachineManual.php?cycle_id=<?=$cycle['cycle_id']?>&machine_id=<?=$job['machine_id']?>"  class=  "text-danger">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                                </svg>
                                                            </a>
                                                        <?php }   ?>
                                                    </div>
                                                </li> 
                                            <?php  } // end of while loop 
                                                } // end of num rows if block 
                                                //else echo "No Machine Selected"; 
                                            ?>
                                        </ol>
                                    </div> 
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <td> 
                            <?php if(isset($cycle['DesignImage']) && !empty($cycle['DesignImage']) )  {    ?>
                                <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                    href="../Design/ShowDesignImage.php?Url=<?=$cycle['DesignImage']?>&ProductName=<?= $cycle['ProductName']?>" >
                                        <svg width = "35px" height = "35px"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier"> <path d="M18 4.25H6C5.27065 4.25 4.57118 4.53973 4.05546 5.05546C3.53973 5.57118 3.25 6.27065 3.25 7V17C3.25 17.7293 3.53973 18.4288 4.05546 18.9445C4.57118 19.4603 5.27065 19.75 6 19.75H18C18.7293 19.75 19.4288 19.4603 19.9445 18.9445C20.4603 18.4288 20.75 17.7293 20.75 17V7C20.75 6.27065 20.4603 5.57118 19.9445 5.05546C19.4288 4.53973 18.7293 4.25 18 4.25ZM6 5.75H18C18.3315 5.75 18.6495 5.8817 18.8839 6.11612C19.1183 6.35054 19.25 6.66848 19.25 7V15.19L16.53 12.47C16.4589 12.394 16.3717 12.3348 16.2748 12.2968C16.178 12.2587 16.0738 12.2427 15.97 12.25C15.865 12.2561 15.7622 12.2831 15.6678 12.3295C15.5733 12.3759 15.4891 12.4406 15.42 12.52L14.13 14.07L9.53 9.47C9.46222 9.39797 9.37993 9.34111 9.28858 9.30319C9.19723 9.26527 9.09887 9.24714 9 9.25C8.89496 9.25611 8.79221 9.28314 8.69776 9.32951C8.60331 9.37587 8.51908 9.44064 8.45 9.52L4.75 13.93V7C4.75 6.66848 4.8817 6.35054 5.11612 6.11612C5.35054 5.8817 5.66848 5.75 6 5.75ZM4.75 17V16.27L9.05 11.11L13.17 15.23L10.65 18.23H6C5.67192 18.23 5.35697 18.1011 5.12311 17.871C4.88926 17.6409 4.75525 17.328 4.75 17ZM18 18.25H12.6L16.05 14.11L19.2 17.26C19.1447 17.538 18.9951 17.7884 18.7764 17.9688C18.5577 18.1492 18.2835 18.2485 18 18.25Z" fill="#000000"></path> </g></svg>
                                </a>
                            <?php } else {  echo '<span class = "text-danger p-1" style = "border:2px solid red; border-radius:3px; "   >N/A</span>'; }  ?>  

                            <?php if($show_complete_btn) { ?>
                                <a href = "ManualCycleForProduction.php?cycle_id=<?=$cycle['cycle_id'];?>" class= "btn btn-outline-success btn-sm m-0"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                    </svg> Mark As Complete
                                </a>
                            <?php } ?>

                        </td>                                                                                                    
                    </tr>

                <?php } // END OF NUMROWS FIRST LOOP  ?>

                <!-- <tr>
                    <td colspan = 4 class = "fw-bold text-center " > Totals </td>
                    <td colspan = 3></td>
                </tr> -->
             <?php } // END OF NUMROWS FIRST LOOP  ?>

            </tbody>
        </table>
    </div>
</div>
<?php  require_once '../App/partials/Footer.inc'; ?>