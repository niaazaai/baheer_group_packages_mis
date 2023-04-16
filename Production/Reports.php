<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc';

    if( isset($_POST['from']) && !empty($_POST['from']) && isset($_POST['to']) && !empty($_POST['to']) && isset($_POST['machine']) && !empty($_POST['machine']) ) {
 
        $from_date = $Controller->CleanInput($_POST['from']);
        $to_date = $Controller->CleanInput($_POST['to']);
        $machine = $Controller->CleanInput($_POST['machine']);
         
        if($machine == 'ALL') $DataRows = $Controller->QueryData("SELECT * FROM machineproduction WHERE PrBranch = 'Manual' AND PrDate BETWEEN ? AND ?",   [ $from_date , $to_date]);  
        else $DataRows = $Controller->QueryData("SELECT * FROM machineproduction WHERE  TRIM(MachineName) = TRIM(?) AND  PrBranch = 'Manual' AND PrDate BETWEEN ? AND ?", [$machine,$from_date,$to_date]);
    }
    else {
        $DataRows = $Controller->QueryData("SELECT * FROM machineproduction WHERE YEARWEEK(PrDate, 1) = YEARWEEK(CURDATE(), 1) ",  []);
    }


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
               All Report  
            </h3>
            <div class= "mt-1">
                <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px; text-decoration:none;"  title="Click to Read the User Guide ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
 
<div class="card">
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><a style = "text-decoration:none;" href="WeeklyComparative.php">Weekly Comparative</a></li>
            <li class="list-group-item"><a style = "text-decoration:none;" href="ReportTimeTrackByDepartment.php"> Department Report</a></li>
            <li class="list-group-item"><a style = "text-decoration:none;" href="ReportMachineCapacityProduction.php">Capacity Report </a> </li>
            <li class="list-group-item"><a style = "text-decoration:none;" href="ReportTimeTrackReportByMachine.php">Time Track By Machine </a></li>
        </ul>
    </div>
</div>


<?php  require_once '../App/partials/Footer.inc'; ?>