<?php ob_start(); require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';   ?>
<?php
    $production_cycle  = $Controller->QueryData("SELECT 
    production_cycle.*, carton.JobNo,carton.CTNId,  carton.ProductName  , 
    CONCAT( FORMAT(carton.CTNLength / 10 ,1 ) ,' x ',FORMAT(carton.CTNWidth / 10 , 1 ),' x ',FORMAT(carton.CTNHeight/ 10,1)) AS Size 
    , CTNUnit ,CTNType,  CTNQTY , CTNColor , ProductQTY 
    FROM production_cycle
    INNER JOIN carton ON production_cycle.CTNId = carton.CTNId
    WHERE cycle_status = 'Incomplete' AND has_manual = 'Yes'",[]);

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
            Manual Section Job List
        </h4>

        <div>
               <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style="margin-top:4px;" title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a>
            <a class = "btn btn-sm text-white" style = "  background-color:#6610f2; " href="FinishList.php">Production</a> 
            <a href="ManualJobList.php" class = "btn btn-sm btn-outline-primary" >Assigned Jobs</a>
        </div>

    </div>
</div>
 
<div class="card m-3 shadow">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="search">
            <i class="fa-search">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
            </i>
            <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
          </div>
        </div>
      </div>
    </div>                
 </div>
   


<div class="card m-3 shadow ">
    <div class="card-body">
        <table class="table " id="JobTable">
      
            <thead>
                <tr class="table-info">
                    <th title="Job No">Job No</th>
                    <th>Product Name</th>
                    <th>Size(cm)</th>    
                    <th>Type</th>
                    <th>Order QTY</th>
                    <th>Produced QTY</th>
                    <th>Color</th>
                    <th>Assigned</th>
                    <th>OPS</th>

                    <!-- , CTNUnit ,CTNType,  CTNQTY , CTNColor , ProductQTY  -->
                </tr>
            </thead>
            <tbody>
             <?php   if($production_cycle->num_rows > 0 ){ $TotalOrderQTY = 0 ;  $TotalProducedQTY = 0 ; ?>
                <?php while ($cycle = $production_cycle->fetch_assoc()) { ?>

                    <tr>
                        <!-- <td><?=$cycle['cycle_id'];?></td> -->
                        <td><?= $cycle['JobNo'] ?></td>
                        <td><?= $cycle['ProductName'] ?></td>
                        <td><?= '(' . $cycle['Size'].') <span class = "badge bg-info" >'. $cycle['CTNType'] . 'Ply </span>'  ?></td>
                        <td><?= $cycle['CTNUnit'];  ?></td>
                        <td><?php echo $cycle['CTNQTY']; $TotalOrderQTY += $cycle['CTNQTY'];?></td>
                        <td><?php echo $cycle['ProductQTY']; $TotalProducedQTY += $cycle['ProductQTY'];?></td>
                        <td><?= $cycle['CTNColor'] ?></td>
                        <td>
                            <div class="accordion accordion-flush " style = "max-width:200px;"  id="accordionFlushExample">
                                <div class="accordion-item" >
                                    <h6 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button btn-sm collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne<?=$cycle['cycle_id'];?>" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Mac- <?=$cycle['cycle_id'];?>
                                    </button>
                                    </h6>
                                    <div id="flush-collapseOne<?=$cycle['cycle_id'];?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body m-0 p-0"> 
                                        <ol class="list-group list-group-numbered mt-2">
                                            <?php  
                                            $machines_cycle  = $Controller->QueryData('SELECT *  FROM  production_cycle 
                                            LEFT JOIN used_machine ON production_cycle.cycle_id = used_machine.cycle_id 
                                            LEFT JOIN machine ON used_machine.machine_id = machine.machine_id 
                                            WHERE production_cycle.cycle_id = ? && production_cycle.CTNId= ? && machine.machine_type = "Manual"',[$cycle['cycle_id'] , $cycle['CTNId']  ]);
                                            $complete_style = ''; 
                                            if($machines_cycle->num_rows > 0 ){
                                                while($job = $machines_cycle->fetch_assoc()  ) {  //echo $job['machine_name']; 
                                                if($job['status'] == 'Complete') $complete_style = 'background-color:#1CD6CE;'; 
                                                else  $complete_style = '';    
                                            ?>
                                                <li class="list-group-item " style = "font-size:12px; <?=$complete_style?>"> <?=$job['machine_name']?> </li> 
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
                            <a type="button" class= "btn btn-sm m-0" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick = "AddCycleId(<?=$cycle['cycle_id'];?>)" > 
                                <svg width="30" height="30" x="0px" y="0px"  style = "color:yellow;" 
                                    viewBox="0 0 297 297" style="enable-background:new 0 0 297 297;" xml:space="preserve">
                                    <path d="M253.782,249.761c5.542,0,10.051-4.509,10.051-10.051s-4.509-10.051-10.051-10.051c-5.542,0-10.051,4.509-10.051,10.051
                                        S248.24,249.761,253.782,249.761z"/>
                                    <path d="M225.808,249.761c5.542,0,10.051-4.509,10.051-10.051s-4.509-10.051-10.051-10.051c-5.542,0-10.051,4.509-10.051,10.051
                                        S220.267,249.761,225.808,249.761z"/>
                                    <path d="M166.585,99.611c-3.431,3.438-3.429,9.03,0.005,12.465c1.72,1.719,3.977,2.578,6.236,2.578c2.258,0,4.516-0.86,6.236-2.578
                                        c3.434-3.435,3.436-9.027,0-12.471C175.621,96.168,170.028,96.166,166.585,99.611z"/>
                                    <path d="M164.438,144.465c0,4.861,3.956,8.817,8.818,8.817c4.861,0,8.817-3.956,8.817-8.817c0-4.862-3.956-8.818-8.817-8.818
                                        C168.393,135.647,164.438,139.603,164.438,144.465z"/>
                                    <path d="M39.499,117.945c9.311,0,16.885-7.574,16.885-16.885S48.81,84.175,39.499,84.175S22.614,91.75,22.614,101.06
                                        S30.189,117.945,39.499,117.945z M39.499,94.226c3.768,0,6.834,3.066,6.834,6.834c0,3.768-3.066,6.834-6.834,6.834
                                        c-3.768,0-6.834-3.066-6.834-6.834C32.665,97.292,35.731,94.226,39.499,94.226z"/>
                                    <path d="M56.384,136.64c0-9.311-7.574-16.885-16.885-16.885s-16.885,7.574-16.885,16.885c0,9.311,7.574,16.885,16.885,16.885
                                        S56.384,145.951,56.384,136.64z M32.665,136.64c0-3.768,3.066-6.834,6.834-6.834c3.768,0,6.834,3.066,6.834,6.834
                                        c0,3.768-3.066,6.834-6.834,6.834C35.731,143.475,32.665,140.408,32.665,136.64z"/>
                                    <path d="M75.079,84.175c-9.311,0-16.885,7.574-16.885,16.885s7.574,16.885,16.885,16.885s16.885-7.574,16.885-16.885
                                        S84.39,84.175,75.079,84.175z M75.079,107.895c-3.768,0-6.834-3.066-6.834-6.834c0-3.768,3.066-6.834,6.834-6.834
                                        s6.834,3.066,6.834,6.834C81.914,104.828,78.847,107.895,75.079,107.895z"/>
                                    <path d="M75.079,119.755c-9.311,0-16.885,7.574-16.885,16.885c0,9.311,7.574,16.885,16.885,16.885s16.885-7.574,16.885-16.885
                                        C91.964,127.33,84.39,119.755,75.079,119.755z M75.079,143.475c-3.768,0-6.834-3.066-6.834-6.834c0-3.768,3.066-6.834,6.834-6.834
                                        s6.834,3.066,6.834,6.834C81.914,140.408,78.847,143.475,75.079,143.475z"/>
                                    <path d="M297,98.749c0-1.631-0.529-3.218-1.508-4.523l-49.751-66.335c-1.423-1.898-3.658-3.015-6.03-3.015h-33.168
                                        c-4.164,0-7.538,3.374-7.538,7.538v7.805c-7.863-0.157-15.794,0.776-23.602,2.868c-21.779,5.836-39.982,19.804-51.256,39.33
                                        c-4.655,8.063-7.8,16.585-9.569,25.243V65.079c0-4.164-3.374-7.538-7.538-7.538H97.72c-2.202-18.373-17.873-32.665-36.83-32.665
                                        h-7.202c-18.957,0-34.628,14.292-36.83,32.665H7.538C3.374,57.541,0,60.915,0,65.079v199.508c0,4.164,3.374,7.538,7.538,7.538
                                        h281.924c4.164,0,7.538-3.374,7.538-7.538V98.749z M214.081,39.952h21.86l45.982,61.31v104.863h-67.843V39.952z M199.005,128.455
                                        c-0.534,0.248-1.125,0.395-1.753,0.395c-2.33,0-4.225-1.896-4.225-4.226c0-2.33,1.895-4.225,4.225-4.225
                                        c0.627,0,1.218,0.144,1.753,0.39V128.455z M199.005,105.41c-0.577-0.055-1.161-0.088-1.753-0.088
                                        c-10.643,0-19.302,8.659-19.302,19.302c0,10.644,8.659,19.303,19.302,19.303c0.592,0,1.176-0.029,1.753-0.084v28.114
                                        c-8.827,0.347-17.59-1.781-25.428-6.306c-10.954-6.324-18.789-16.535-22.063-28.752c-3.273-12.217-1.593-24.977,4.731-35.93
                                        c6.324-10.954,16.535-18.788,28.752-22.062c4.079-1.093,8.219-1.634,12.333-1.634c0.559,0,1.117,0.022,1.675,0.042V105.41z
                                        M137.204,89.955c9.261-16.039,24.212-27.513,42.102-32.306c5.974-1.601,12.035-2.393,18.059-2.393c0.548,0,1.093,0.031,1.64,0.044
                                        v6.944c-5.965-0.165-11.985,0.511-17.911,2.098c-16.107,4.316-29.568,14.645-37.905,29.086
                                        c-8.338,14.441-10.552,31.264-6.237,47.371c4.316,16.107,14.645,29.568,29.086,37.905c9.62,5.554,20.294,8.391,31.112,8.391
                                        c0.617,0,1.236-0.017,1.854-0.036v6.846c-12.359,0.338-24.952-2.612-36.422-9.234C129.473,165.556,118.088,123.066,137.204,89.955z
                                        M155.045,197.729c8.038,4.641,16.529,7.795,25.158,9.568h-65.624v-65.911C119.234,164.279,133.271,185.157,155.045,197.729z
                                        M53.688,39.952h7.202c10.626,0,19.519,7.563,21.579,17.589H67.252l3.019-5.683c1.301-2.451,0.37-5.494-2.081-6.796
                                        c-2.449-1.3-5.494-0.371-6.796,2.081L55.87,57.541H32.109C34.169,47.515,43.062,39.952,53.688,39.952z M15.076,72.617h84.426
                                        v134.68H15.076V72.617z M281.924,257.048H15.076v-34.675h266.848V257.048z"/>
                                    <path d="M73.873,174.129H40.706c-4.164,0-7.538,3.374-7.538,7.538s3.374,7.538,7.538,7.538h33.168c4.164,0,7.538-3.374,7.538-7.538
                                        S78.037,174.129,73.873,174.129z"/>
                                </svg>
                            </a>
                            <a href = "CreateRent.php?cycle_id=<?=$cycle['cycle_id'];?>&CTNId=<?=$cycle['CTNId'];?>" class= "btn btn-dark btn-sm m-0"> 
                                Rent
                            </a>
                        </td>
                    </tr>

                <?php } // END OF NUMROWS FIRST LOOP  ?>

                <tr>
                    <td colspan = 4 class = "fw-bold text-center " > Totals </td>
                    <td><?=$TotalOrderQTY?></td>
                    <td><?=$TotalProducedQTY?></td>
                    <td colspan=3></td>
                </tr>
             <?php } // END OF NUMROWS FIRST LOOP  ?>

            </tbody>
        </table>
    </div>
</div>

 

<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog model-xl ">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="modal-title text-end" id="exampleModalLabel">لطف نموده ماشین مورد نظر خود را انتخاب نمایید</strong>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="StoreUsedMachine.php" id = "machine_form" method = "post" >
            <div class="modal-body">
                <div class="list-group">
                    <input type="hidden" id = "CYCLE_ID_" name="CYCLE_ID"  >
                    <input type="hidden" name="Manual"  value = "Manual">
                    <?php if ($machine_db_list->num_rows > 0) {  while($MACHINE = $machine_db_list->fetch_assoc()){    ?> 
                        <label class="list-group-item">
                            <input class="form-check-input me-1" name = "machine_<?=$MACHINE['machine_id'];?>"   value = "<?=$MACHINE['machine_id'] ?>"  type="checkbox"  >
                            <?= $MACHINE['machine_name'] . " ( ". $MACHINE['machine_name_pashto'] ." )"; ?> 
                        </label>  
                    <?php  } } else echo "Machine query has errors!"; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
  </div>
</div>

<script>

function search(InputId ,tableId ) {
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
 


    function AddCycleId(cycle_id  ){
        document.getElementById('CYCLE_ID_').value = cycle_id; 
    }

    function AddCycleForCProduction(cycle_id){
        document.getElementById('CYCLE_ID_Pro').value = cycle_id; 
    }


    let total = {}; 
    function InputValue(name , value)   {
        total[name] = value; 
        CalculatePlates(); 
    }

    
    function CalculatePlates(){
    
        console.log(total) ;

        let TotalPacks = 0 ; 
        let FinalTotal = 0 ; 

        TotalPacks = ( Number(total.Plate) * Number(total.Line) * Number(total.Pack) ) + Number(total.ExtraPack)  ;
        FinalTotal = (Number(total['Carton']) * Number(TotalPacks) ) + Number(total.ExtraCarton)

        document.getElementById('TotalPacks').value =  TotalPacks; 
        document.getElementById('Total').value =  FinalTotal; 



    }
</script>

    

<?php  require_once '../App/partials/Footer.inc'; ?>