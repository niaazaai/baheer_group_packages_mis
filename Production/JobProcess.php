<?php  
    ob_start(); 
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc'; 
    require '../Assets/Carbon/autoload.php'; 
    use Carbon\Carbon;

    function GenerateDate($date){
        $a =  Carbon::createFromTimeStamp(strtotime($date),'Asia/Kabul')->diffForHumans();
        return  "<span class = 'badge bg-dark' style = 'font-size:11px;' >{$a}</span>";
    }

    if(isset($_REQUEST['machine_id']) && !empty(trim($_REQUEST['machine_id'])) && isset($_REQUEST['CYCLE_ID']) && !empty(trim($_REQUEST['CYCLE_ID']))){
 
        $CTN_DATA = []; 
        $UsedPaper = [];  
        $Cut_Qty = [];  
        $CYCLE_ID = $Controller->CleanInput($_REQUEST['CYCLE_ID']); 
        $machine_id = $Controller->CleanInput($_REQUEST['machine_id']); 
        
        $CTNId = '-1'; 
        if(isset($_REQUEST['CTNId']) && !empty($_REQUEST['CTNId'])) {
            $CTNId = $Controller->CleanInput($_REQUEST['CTNId']);
        }

        $double_job = '-1'; 
        if(isset($_REQUEST['double_job']) && !empty($_REQUEST['double_job'])) {
            $double_job = $Controller->CleanInput($_REQUEST['double_job']);
        }
         
        // $CTNId = 4818;
        // echo $CTNId; 
        // echo "<<<<>>>>>"; 
        // echo $double_job; 

        /*
        |------------------------------------------------------------------------
        |  if( $double_job !== 0 ) { 
        |------------------------------------------------------------------------
        | this block is used to get the carton information for printing job-card
        | in the page first we get the used_machine table information inorder to
        | extract the double_job_carton_id and pushes the extract carton records 
        | to an array called CTN_DATA so we can used it later 
        */

        if( $double_job == '-1' && $CTNId != '-1' ) {
            $Row = $Controller->QueryData('SELECT CTNId,ppcustomer.CustName, CTNType,  JobNo,CTNOrderDate,CTNStatus,ProductQTY,JobType,CTNFinishDate,CTNQTY,CTNUnit,CTNColor, ProductName ,CTNStatus,  	PolyId   , DieId , 
            CTNLength , CTNWidth ,CTNHeight,ProductQTY,designinfo.DesignImage,designinfo.DesignCode1,  CFluteType ,Ctnp1,Ctnp2,Ctnp3,Ctnp4,Ctnp5,Ctnp6,Ctnp7
            ,CSlotted,CDieCut,CPasting,CStitching,flexop,offesetp,Note,MachineName ,carton.production_job_type ,MarketingNote
            FROM carton 
            INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
            LEFT OUTER JOIN machineproduction ON machineproduction.Ctnid2=carton.CTNId  WHERE CTNId=? ORDER BY JobNo DESC',[$CTNId])->fetch_assoc();

            array_push($CTN_DATA,$Row);
            array_push($UsedPaper,$Controller->QueryData('SELECT * FROM used_paper WHERE carton_id = ?', [$CTNId])->fetch_assoc());
            array_push($Cut_Qty,$Controller->QueryData('SELECT cut_qty,cycle_id,cycle_flute_type,cycle_produce_qty,cycle_plan_qty  FROM production_cycle WHERE cycle_id = ?', [$CYCLE_ID])->fetch_assoc());
           
        }
        else {
            $used_machine  = $Controller->QueryData('SELECT double_job_carton_id,cycle_id FROM used_machine  WHERE double_job = ?',[$double_job]);
            while($um = $used_machine->fetch_assoc()){

                $Row = $Controller->QueryData('SELECT CTNId,ppcustomer.CustName, CTNType,  JobNo,CTNOrderDate,CTNStatus,ProductQTY,JobType,CTNFinishDate,CTNQTY,CTNUnit,CTNColor, ProductName ,CTNStatus,  	PolyId   , DieId , 
                CTNLength , CTNWidth ,CTNHeight,ProductQTY,designinfo.DesignImage,designinfo.DesignCode1,  CFluteType ,Ctnp1,Ctnp2,Ctnp3,Ctnp4,Ctnp5,Ctnp6,Ctnp7
                ,CSlotted,CDieCut,CPasting,CStitching,flexop,offesetp,Note,MachineName ,carton.production_job_type,MarketingNote
                FROM carton 
                INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
                INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
                LEFT OUTER JOIN machineproduction ON machineproduction.Ctnid2=carton.CTNId  WHERE CTNId=? ORDER BY JobNo DESC',[$um['double_job_carton_id']])->fetch_assoc();
                
                array_push($CTN_DATA,$Row);
                array_push($UsedPaper,$Controller->QueryData('SELECT * FROM used_paper WHERE carton_id = ?', [$um['double_job_carton_id']])->fetch_assoc());
                array_push($Cut_Qty,$Controller->QueryData('SELECT cut_qty,cycle_id,cycle_flute_type,cycle_produce_qty,cycle_plan_qty FROM production_cycle WHERE cycle_id = ?', [$um['cycle_id']])->fetch_assoc());
            }// end of while 


            
        }

        /*
        |--------------------------------------------------------------------------
        |  if($mp_history->num_rows > 0){
        |--------------------------------------------------------------------------
        | this block is used to get the latest status of machine the the job is  
        | is running on. 
        */

        $selected_machine  = $Controller->QueryData('SELECT * FROM machine WHERE machine_id = ? ' , [$machine_id]); 
        
        $machine_ = '';  
        if($selected_machine->num_rows > 0) {
            $machine_ = $selected_machine->fetch_assoc(); 
        }
        else header("Location:MachineOpreatorList.php?msg=Incorrect machine selecte&class=success"); 

        $machine_state = ''; 
        $machine = ''; 
        $status = ''; 
        $button = ''; 
        $production_start_date = null ; 


        // var_dump($CTNId , $CYCLE_ID , $_REQUEST['machine_id']); 

        $mp_history = $Controller->QueryData('SELECT * FROM machine_production_history WHERE CTNId = ? AND cycle_id = ? AND machine_id = ?', [$CTNId , $CYCLE_ID , $_REQUEST['machine_id']]);

        // 
        if($mp_history->num_rows > 0){
            while ( $mph = $mp_history->fetch_assoc() ) {
                // echo $mph['start_time'] .' - '. $mph['end_time'] . ' - '; 
                // echo $mph['machine_id'] . ' - ';
                // echo $mph['status'];
                // echo "<br>";
                $machine_state =  trim($mph['status']);
                if( $machine_state == 'Start Configuration') {
                   $production_start_date =  $mph['start_time']; 
                }
            }
        }
        else {
            $machine_state = 'first time'; 
            // var_dump(gettype($production_start_date));
            // date_default_timezone_set('Asia/Kabul');
            // echo date("Y-m-d H:i:s" ); 
            // echo "<br>";
        }
    
        switch ($machine_state) {

            case 'first time':
                $button = '<button type="submit"  class = "btn btn-warning  " > اماده نمودن ماشین  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z"/>
              </svg> </button>'; 
                $status = 'Start Configuration'; 
                break;
                
            case 'Start Configuration':
                $button = '<button type="submit"  class = "btn btn-success  " onclick = "return confirm(`😕 آیا مطمین استید برای شروع تولید؟ 😕`);" > شروع تولید 
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-play-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"/>
                </svg> </button> '; 
                $status = 'Start Production'; 
                break;
                
            case 'Job Completed':
                // $button = '<button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class = "btn btn-outline-success mt-3"  > مرحله تکمیل شد </button>';
                $button = '<span class = "btn btn-outline-success " style = "border-radius:0px;"> تولید در ماشین تکمیل شد</span>';
                $status = 'Job Completed'; 
            break;

            default:
                $button = 
                '<div class="dropdown">
                    <button class="btn btn-outline-danger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        تغیر حالت ماشین
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#" onclick = "SetStatus(`Continue Job`)" style = "color:#38E54D; " >Continue Job - ادامه دادن جاب</a></li>
                        <li><a class="dropdown-item" href="#" onclick = "SetStatus(`Job Completed`)" style = "color:cyan; "   > Job Complete - جاب تکمیل شد </a></li>
                        <li><a class="dropdown-item" href="#" onclick = "SetStatus(`No Raw Material`)">No Raw Material - نبود مواد خام</a></li>
                        <li><a class="dropdown-item" href="#" onclick = "SetStatus(`Power Failure`)">Power Failure - قطع برق</a></li>
                        <li><a class="dropdown-item" href="#" onclick = "SetStatus(`Quality Issue`)">Quality Issue - مشکل کیفیت</a></li>
                        <li><a class="dropdown-item" href="#" onclick = "SetStatus(`Lunch Break`)">Lunch Break - وقفه غذا</a></li>
                        <li><a class="dropdown-item" href="#" onclick = "SetStatus(`Cleaning`)">Cleaning - صفا کاری</a></li>
                        <li><a class="dropdown-item" href="#" onclick = "SetStatus(`Maintaining`)">Maintaining - حفظ و مراقبت</a></li>
                        <li><a class="dropdown-item" href="#" onclick = "SetStatus(`Polymer & Die Issue`)">Polymer Or Die Issue - بسته کردن دایی یا پولیمیر</a></li>
                    </ul>
                </div>'; 
            break;
        }
        // <li><a class="dropdown-item" href="#" onclick = "SetStatus(`Shift Change`)">Shift Change - تبدیل شفت</a></li>
    }
    else {
        header('Location:MachineOpreatorList.php');
    }
?> 

<style>
    #clock {
        font-size: 40px;
        color:#38E54D;
    }
    .custom-font {
        font-size:12px;
    }

    @font-face {
        font-family: 'seven-segment'; /*a name to be used later*/
        src: url('../Public/Font/Seven Segment.ttf'); /*URL to font*/
    }
</style>

<?php 
    /*
    |--------------------------------------------------------------------------
    |  if($mp_history->num_rows > 0){
    |--------------------------------------------------------------------------
    | this block of code determines the color of text status and bottom border  
    | machine input  according to machine status 
    | red - #FF0032  green - #38E54D   yellow - #ffc107 
    */

    $class = '#FF0032'; 
    if($machine_state == 'first time') $class = '#FF0032';  
    else if(trim($machine_state) == 'Continue Job' || $machine_state == 'Start Production') $class = '#38E54D';
    else  if($machine_state == 'Start Configuration') $class = '#ffc107'; 
    else  if($machine_state == 'Job Completed') {$class = '#333333'; $stop_counter = 'yes'; }  
    else $class = '#FF0032'; 
?> 


<div class="card m-3 shadow" >
    <div class="card-body d-flex justify-content-between">
        <div>
            <h4 class = "p-0 m-0" >
                <a class="btn btn-outline-primary   me-1" href="MachineOpreatorList.php?CTNId=<?=$CTNId;?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                    </svg>
                </a>
                <svg width="45" height="45" x="0px" y="0px" viewBox="0 0 297 297" style="enable-background:new 0 0 297 297;" xml:space="preserve">
                    <path d="M253.782,249.761c5.542,0,10.051-4.509,10.051-10.051s-4.509-10.051-10.051-10.051c-5.542,0-10.051,4.509-10.051,10.051
                        S248.24,249.761,253.782,249.761z"></path>
                    <path d="M225.808,249.761c5.542,0,10.051-4.509,10.051-10.051s-4.509-10.051-10.051-10.051c-5.542,0-10.051,4.509-10.051,10.051
                        S220.267,249.761,225.808,249.761z"></path>
                    <path d="M166.585,99.611c-3.431,3.438-3.429,9.03,0.005,12.465c1.72,1.719,3.977,2.578,6.236,2.578c2.258,0,4.516-0.86,6.236-2.578
                        c3.434-3.435,3.436-9.027,0-12.471C175.621,96.168,170.028,96.166,166.585,99.611z"></path>
                    <path d="M164.438,144.465c0,4.861,3.956,8.817,8.818,8.817c4.861,0,8.817-3.956,8.817-8.817c0-4.862-3.956-8.818-8.817-8.818
                        C168.393,135.647,164.438,139.603,164.438,144.465z"></path>
                    <path d="M39.499,117.945c9.311,0,16.885-7.574,16.885-16.885S48.81,84.175,39.499,84.175S22.614,91.75,22.614,101.06
                        S30.189,117.945,39.499,117.945z M39.499,94.226c3.768,0,6.834,3.066,6.834,6.834c0,3.768-3.066,6.834-6.834,6.834
                        c-3.768,0-6.834-3.066-6.834-6.834C32.665,97.292,35.731,94.226,39.499,94.226z"></path>
                    <path d="M56.384,136.64c0-9.311-7.574-16.885-16.885-16.885s-16.885,7.574-16.885,16.885c0,9.311,7.574,16.885,16.885,16.885
                        S56.384,145.951,56.384,136.64z M32.665,136.64c0-3.768,3.066-6.834,6.834-6.834c3.768,0,6.834,3.066,6.834,6.834
                        c0,3.768-3.066,6.834-6.834,6.834C35.731,143.475,32.665,140.408,32.665,136.64z"></path>
                    <path d="M75.079,84.175c-9.311,0-16.885,7.574-16.885,16.885s7.574,16.885,16.885,16.885s16.885-7.574,16.885-16.885
                        S84.39,84.175,75.079,84.175z M75.079,107.895c-3.768,0-6.834-3.066-6.834-6.834c0-3.768,3.066-6.834,6.834-6.834
                        s6.834,3.066,6.834,6.834C81.914,104.828,78.847,107.895,75.079,107.895z"></path>
                    <path d="M75.079,119.755c-9.311,0-16.885,7.574-16.885,16.885c0,9.311,7.574,16.885,16.885,16.885s16.885-7.574,16.885-16.885
                        C91.964,127.33,84.39,119.755,75.079,119.755z M75.079,143.475c-3.768,0-6.834-3.066-6.834-6.834c0-3.768,3.066-6.834,6.834-6.834
                        s6.834,3.066,6.834,6.834C81.914,140.408,78.847,143.475,75.079,143.475z"></path>
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
                        v134.68H15.076V72.617z M281.924,257.048H15.076v-34.675h266.848V257.048z"></path>
                    <path d="M73.873,174.129H40.706c-4.164,0-7.538,3.374-7.538,7.538s3.374,7.538,7.538,7.538h33.168c4.164,0,7.538-3.374,7.538-7.538
                        S78.037,174.129,73.873,174.129z"></path>
                </svg>
                Job Processing Dashboard <?= isset($stop_counter) ? '<span class = "text-white bg-success fs-5" > Job Processed In Machine': '' ; ?>
            </h4>
        </div>
      
     

        <span>
            <span class=  "p-1 pb-2 me-3 fs-4" style = "border-bottom:3px dotted <?=$class?>;">
                <?php 
                    $ms = ''; 
                    if($machine_state == 'first time')  $ms = 'ماشین به اماده سازی ضرورت دارد';  
                    else if(trim($machine_state) == 'Continue Job' || $machine_state == 'Start Production') $ms = 'ماشین در حال تولید است';
                    else  if($machine_state == 'Start Configuration') $ms = 'ماشین در حال اماده سازی'; 
                    else $ms = 'ماشین توقف نموده است'; 
                    echo $ms; 
                ?> 
            </span>
            <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2" style = "margin-top:10px;"  title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a>
        </span>

    </div>
</div>
<?php  if(isset($_GET['msg'])) {  ?>
            <div class="alert  alert-dismissible fade show m-3 alert-<?php if(isset($_GET['class'])) echo $_GET['class'];  ?>" role="alert">
                <strong>Message: </strong> <?=$_GET['msg']?>! 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

<div class="card m-3 shadow">
    <div class="card-body">
        <div class="row">

            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 ">
                <div class="form-floating ">
                    <input type="text" placeholder="Opreator" name="OperaterName" id="OperaterName" class="form-control" disabled value="<?=$_SESSION['user']?>" >
                    <label for="floatingInput">Opreator</label>
                </div>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 ">
                <div class="form-floating ">
                    <input type="text" placeholder="Machine" id="machine_name" class="form-control " disabled value="<?=$machine_['machine_name'] ?>" 
                    style = "border-bottom:5px solid <?=$class?>; box-shadow: 0 30px 30px -15px <?=$class?>; " >
                    <label for="machine_name">Machine</label>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 d-flex justify-content-between  ">

                <div class = "bg-dark text-center" style = "width:230px;border-radius:5px;font-family: 'seven-segment';" >
                    <span id = "clock" class="countup-timer m-0  pt-1 px-1" ></span>
                </div>
                <form action="MachineProductionHistory.php"  method="post"  >
                    <input type="hidden" name="status" id = "status"  value = "<?=(isset($status) && !empty($status)) ? $status : 'configure machine';?>" >
                    <input type="hidden" name="machine_id" value = "<?=$machine_id?>" >
                    <input type="hidden" name="CTNId[]" value = "<?=$CTN_DATA[0]['CTNId']?>">
                    <input type="hidden" name="cycle_id[]" value = "<?=$Cut_Qty[0]['cycle_id']?>">
                    <input type="hidden" name="double_job" value = "<?=$double_job?>">
                    <?php if(isset($CTN_DATA[1])): ?>
                        <input type="hidden" name="CTNId[]" value = "<?=$CTN_DATA[1]['CTNId']?>">
                        <input type="hidden" name="cycle_id[]" value = "<?=$Cut_Qty[1]['cycle_id']?>">
                    <?php endif;  ?>
                    <?=$button?>
                </form> 
               
            </div>

        </div>

        

    </div>
</div>

<div class = "card m-3 shadow">
    <div class="card-body d-flex justify-content-end  ">
        <div>
            <a class="btn mx-3" style = "background-color:#6610f2; color:white; " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                نمایش تولید گذشته ماشین ها
            </a>
        </div>

        <div   >
            <a class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">ثبت تعداد تولید</a>
        </div>

    </div>
</div>


<div class="collapse shadow m-3" id="collapseExample">
  <div class="card card-body">
                        
    <?php 
      $used_machine  = $Controller->QueryData('SELECT * FROM used_machine INNER JOIN machine ON used_machine.machine_id = machine.machine_id   WHERE cycle_id = ? ',[$CYCLE_ID]);
      while($um = $used_machine->fetch_assoc()){
        // var_dump($um['machine_name'] , $um['produced_qty'] ); 

        echo $um['machine_name']  . ' - '.   $um['produced_qty']  . ' - '.   $um['wast_qty'] ; 
        echo "<br>"; 
      }// end of while 

    ?>
  

  </div>
</div>



<?php if(trim($machine_['machine_name']) == 'Carrogation 5 Ply'  || trim($machine_['machine_name']) == 'Carrogation 3 Ply') { ?>
 
<div class="card m-3 shadow">
    <div class="card-body">
    
    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                    </svg>
                Customer Info   </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col"  >
                    <div class ="text-secondary" >Job No: </div>
                    <div class =""><?=$CTN_DATA[0]['JobNo'];?></div>
                    <div><?=isset($CTN_DATA[1]['JobNo']) ? $CTN_DATA[1]['JobNo'] : '';?></div>
                </th>
                <th scope="col" >
                    <div  class ="text-secondary">Company Name:</div>
                    <div><?=$CTN_DATA[0]['CustName'];?></div>
                    <div><?=isset($CTN_DATA[1]['CustName']) ? $CTN_DATA[1]['CustName'] : '';?></div>
                </th>
                <th scope="col">
                    <div  class ="text-secondary">Product Name:</div>
                    <div><?=$CTN_DATA[0]['ProductName'];?></div>
                    <div><?=isset($CTN_DATA[1]['ProductName']) ? $CTN_DATA[1]['ProductName'] : '';?></div>
                </th>

                <th scope="col">
                    <div  class ="text-secondary">Order Qty:</div>
                    <div><?=$CTN_DATA[0]['CTNQTY'];?></div>
                    <div><?=isset($CTN_DATA[1]['CTNQTY']) ? $CTN_DATA[1]['CTNQTY'] : '';?></div>
                </th>
                
                <th scope="col"  >
                    <div class ="text-black" >Plan Qty (تعداد کاري) <span class = "text-danger fw-bold p-0 mt-2" style = "font-size:16px; "  >*</span></div>
                    <div class=""><?=(isset($Cut_Qty[0]['cycle_plan_qty'])) ? $Cut_Qty[0]['cycle_plan_qty'] : '' ?></div>
                    <div class=""><?=(isset($Cut_Qty[1]['cycle_plan_qty']) ) ? $Cut_Qty[1]['cycle_plan_qty'] : '';?></div>
                </th>

                <th scope="col">
                    <div  class ="text-secondary">Order Date:</div>
                    <div><?= GenerateDate($CTN_DATA[0]['CTNOrderDate']) ;?></div>
                    <div><?=isset($CTN_DATA[1]['CTNOrderDate']) ? GenerateDate($CTN_DATA[1]['CTNOrderDate']): '';?></div>
                </th>

                <th scope="col">
                    <div  class ="text-secondary">Deadline:</div>
                    <div><?= GenerateDate($CTN_DATA[0]['CTNFinishDate']);?></div>
                    <div><?=isset($CTN_DATA[1]['CTNFinishDate']) ? GenerateDate($CTN_DATA[1]['CTNFinishDate']) : '';?></div>
                </th>
            </tr>
        </tbody>
    </table>



    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" >  
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-rulers" viewBox="0 0 16 16" style = "transform:rotate(180deg)">
                        <path d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V2h1v4h1V4h1v2h1V2h1v4h1V4h1v2h1V2h1v4h1V1a1 1 0 0 0-1-1H1z"/>
                    </svg>
                   Machine Info (mm)
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col">
                    <div class ="text-secondary" >L: </div>
                    <div><?=$CTN_DATA[0]['CTNLength'];?></div>
                    <div><?=isset($CTN_DATA[1]['CTNLength']) ? $CTN_DATA[1]['CTNLength'] : '';?></div>
                </th>
                <th scope="col" >
                    <div class ="text-secondary" >W:</div>
                    <div><?=$CTN_DATA[0]['CTNWidth'];?></div>
                    <div><?=isset($CTN_DATA[1]['CTNWidth']) ? $CTN_DATA[1]['CTNWidth'] : '';?></div>
                </th>
                <th scope="col">
                    <div class ="text-secondary" >H:</div>
                    <div><?=$CTN_DATA[0]['CTNHeight'];?></div>
                    <div><?=isset($CTN_DATA[1]['CTNHeight']) ? $CTN_DATA[1]['CTNHeight'] : '';?></div>
                </th>

                <?php 

                    $total_width = 0 ; 
                    $total_length = 0 ; 
                    $total_width1 = 0 ; 
                    $total_length1 = 0 ; 
                    // TOTAL WIDTH BETWEEN  flexo_1p - flexo_2p - AND Default which is normal is the same 
                    $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] ; 
                    switch ($CTN_DATA[0]['production_job_type']) {
                        case 'Offset 1 Piece':
                            $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] + 2.5; 
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2  + 3; 
                            break;
                        case 'Offset 2 Piece':
                            $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] + 2.5; 
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) + 3; 
                            break;
                        case 'Flexo 1 Piece':
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2 + 3; 
                            break;
                        case 'Flexo 2 Piece':
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) + 3; 
                            break;
                        default:
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2 +3 ; 
                            break;
                    }

                    if(isset($CTN_DATA[1])) {  
                        // TOTAL WIDTH BETWEEN  flexo_1p - flexo_2p - AND Default which is normal is the same 
                        $total_width1 = $CTN_DATA[1]['CTNWidth'] + $CTN_DATA[1]['CTNHeight'] ; 
                        switch ($CTN_DATA[1]['production_job_type']) {
                            case 'Offset 1 Piece':
                                $total_width1 = $CTN_DATA[1]['CTNWidth'] + $CTN_DATA[1]['CTNHeight'] + 2.5; 
                                $total_length1 = ($CTN_DATA[1]['CTNLength'] + $CTN_DATA[1]['CTNWidth']) * 2  + 3; 
                                break;
                            case 'Offset 2 Piece':
                                $total_width1 = $CTN_DATA[1]['CTNWidth'] + $CTN_DATA[1]['CTNHeight'] + 2.5; 
                                $total_length1 = ($CTN_DATA[1]['CTNLength'] + $CTN_DATA[1]['CTNWidth']) + 3; 
                                break;
                            case 'Flexo 1 Piece':
                                $total_length1 = ($CTN_DATA[1]['CTNLength'] + $CTN_DATA[1]['CTNWidth']) * 2 + 3; 
                                break;
                            case 'Flexo 2 Piece':
                                $total_length1 = ($CTN_DATA[1]['CTNLength'] + $CTN_DATA[1]['CTNWidth']) + 3; 
                                break;
                            default:
                                $total_length1 = ($CTN_DATA[1]['CTNLength'] + $CTN_DATA[1]['CTNWidth']) * 2 +3 ; 
                                break;
                        }// end of switch 
                    }// end of second ctn if block 

                ?>

                <th scope="col">
                    <div class ="text-secondary"  >Total Length:</div>
                    <div id = "1212" ><?=$total_length?> </div>
                    <div id = "1212" >
                        <?php if(isset($CTN_DATA[1]['CTNLength']) && isset($CTN_DATA[1]['CTNWidth']) ) { 
                            echo $total_length1; 
                            } ?>
                    </div>
                </th>

                <th scope="col">
                    <div class ="text-secondary"  >Total Width:</div>
                    <div id = "" ><?=$total_width;?></div>
                    <div id = "" >
                        <?php if(isset($CTN_DATA[1]['CTNHeight']) && isset($CTN_DATA[1]['CTNWidth']) ) { 
                                echo $total_width1;
                            } 
                        ?>
                    </div>
                </th>
       
                <th scope="col">
                    <div class ="text-secondary">Paper Type:</div>
                    <div>   <?php
                                $arr = []; 
                                for ($index=1; $index <= 7 ; $index++) { 
                                    if(empty($CTN_DATA[0]['Ctnp'.$index])) continue; 
                                    $arr[] = $CTN_DATA[0]['Ctnp'.$index];   
                                } 
                                $arr = array_count_values($arr);
                                foreach ($arr as $key => $value) {
                                    if(trim($key) === 'Flute') echo $value . " " . $key ;
                                    else  echo $key ; 
                                    if ($key === array_key_last($arr)) continue ; 
                                    echo " x ";
                                }  
                            ?>  
                    </div>

                    <div>   <?php
                                if(isset($CTN_DATA[1])) { 
                                    $arr = []; 
                                    for ($index=1; $index <= 7 ; $index++) { 
                                        if(empty($CTN_DATA[1]['Ctnp'.$index])) continue; 
                                        $arr[] = $CTN_DATA[1]['Ctnp'.$index];   
                                    } 
                                    $arr = array_count_values($arr);
                                    foreach ($arr as $key => $value) {
                                        if(trim($key) === 'Flute') echo $value . " " . $key ;
                                        else  echo $key ; 
                                        if ($key === array_key_last($arr)) continue ; 
                                        echo " x ";
                                    }  
                                }  
                            ?>  
                    </div>
                </th>

                <th scope="col">
                    <div class ="text-secondary" >Ply Type</div>
                    <div><span class = "bg-danger  text-white" style = "padding:2px;"> <?=$CTN_DATA[0]['CTNType'];?> Ply  </span></div>
                    <?php if(isset($CTN_DATA[1])) { ?>
                        <div><span class = "bg-danger  text-white" style = "padding:2px;"> <?=isset($CTN_DATA[1]['CTNType']) ? $CTN_DATA[1]['CTNType'] : '';?> Ply</span></div>
                    <?php } ?>  
                </th>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-paint-bucket" viewBox="0 0 16 16">
                        <path d="M6.192 2.78c-.458-.677-.927-1.248-1.35-1.643a2.972 2.972 0 0 0-.71-.515c-.217-.104-.56-.205-.882-.02-.367.213-.427.63-.43.896-.003.304.064.664.173 1.044.196.687.556 1.528 1.035 2.402L.752 8.22c-.277.277-.269.656-.218.918.055.283.187.593.36.903.348.627.92 1.361 1.626 2.068.707.707 1.441 1.278 2.068 1.626.31.173.62.305.903.36.262.05.64.059.918-.218l5.615-5.615c.118.257.092.512.05.939-.03.292-.068.665-.073 1.176v.123h.003a1 1 0 0 0 1.993 0H14v-.057a1.01 1.01 0 0 0-.004-.117c-.055-1.25-.7-2.738-1.86-3.494a4.322 4.322 0 0 0-.211-.434c-.349-.626-.92-1.36-1.627-2.067-.707-.707-1.441-1.279-2.068-1.627-.31-.172-.62-.304-.903-.36-.262-.05-.64-.058-.918.219l-.217.216zM4.16 1.867c.381.356.844.922 1.311 1.632l-.704.705c-.382-.727-.66-1.402-.813-1.938a3.283 3.283 0 0 1-.131-.673c.091.061.204.15.337.274zm.394 3.965c.54.852 1.107 1.567 1.607 2.033a.5.5 0 1 0 .682-.732c-.453-.422-1.017-1.136-1.564-2.027l1.088-1.088c.054.12.115.243.183.365.349.627.92 1.361 1.627 2.068.706.707 1.44 1.278 2.068 1.626.122.068.244.13.365.183l-4.861 4.862a.571.571 0 0 1-.068-.01c-.137-.027-.342-.104-.608-.252-.524-.292-1.186-.8-1.846-1.46-.66-.66-1.168-1.32-1.46-1.846-.147-.265-.225-.47-.251-.607a.573.573 0 0 1-.01-.068l3.048-3.047zm2.87-1.935a2.44 2.44 0 0 1-.241-.561c.135.033.324.11.562.241.524.292 1.186.8 1.846 1.46.45.45.83.901 1.118 1.31a3.497 3.497 0 0 0-1.066.091 11.27 11.27 0 0 1-.76-.694c-.66-.66-1.167-1.322-1.458-1.847z"/>
                    </svg>
                    Printing Info  
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >

                <th scope="col"  >
                    <div class ="text-secondary" >Die Cut </div>
                    <div class=""><?=($CTN_DATA[0]['CTNType'] == 'Yes') ? $CTN_DATA[0]['CTNType'] : '';?></div>
                    <div class=""><?=(isset($CTN_DATA[1]['CTNType']) && $CTN_DATA[1]['CTNType'] == 'Yes') ? $CTN_DATA[1]['CTNType'] : '';?></div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Slotted </div>
                    <div class=""><?=($CTN_DATA[0]['CSlotted'] == 'Yes') ? $CTN_DATA[0]['CSlotted'] : '';?></div>
                    <div class=""><?=(isset($CTN_DATA[1]['CSlotted']) && $CTN_DATA[1]['CSlotted'] == 'Yes') ? $CTN_DATA[1]['CSlotted'] : '';?></div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Pasting </div>
                    <div class=""><?=($CTN_DATA[0]['CPasting'] == 'Yes') ? $CTN_DATA[0]['CPasting'] : '';?></div>
                    <div class=""><?=(isset($CTN_DATA[1]['CPasting']) && $CTN_DATA[1]['CPasting'] == 'Yes') ? $CTN_DATA[1]['CPasting'] : '';?></div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Stitching </div>
                    <div class=""><?=($CTN_DATA[0]['CStitching'] == 'Yes') ? $CTN_DATA[0]['CStitching'] : '';?></div>
                    <div class=""><?=(isset($CTN_DATA[1]['CStitching']) && $CTN_DATA[1]['CStitching'] == 'Yes') ? $CTN_DATA[1]['CStitching'] : '';?></div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Flexo Print</div>
                    <div class=""><?=($CTN_DATA[0]['flexop'] == 'Yes') ? $CTN_DATA[0]['flexop'] : '';?></div>
                    <div class=""><?=(isset($CTN_DATA[1]['flexop']) && $CTN_DATA[1]['flexop'] == 'Yes') ? $CTN_DATA[1]['flexop'] : '';?></div>
                </th>
 
                <th scope="col"  >
                    <div class ="text-secondary" >Offset Print</div>
                    <div class=""><?=($CTN_DATA[0]['offesetp'] == 'Yes') ? $CTN_DATA[0]['offesetp'] : '';?></div>
                    <div class=""><?=(isset($CTN_DATA[1]['offesetp']) && $CTN_DATA[1]['offesetp'] == 'Yes') ? $CTN_DATA[1]['offesetp'] : '';?></div>
                </th>
 
                <th scope="col"  >
                    <div class ="text-secondary" >Color</div>
                    <div class=""><?=$CTN_DATA[0]['CTNColor']?></div>
                    <div class=""><?=(isset($CTN_DATA[1]['CTNColor']) ) ? $CTN_DATA[1]['CTNColor'] : '';?></div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Flute Type</div>
                    <div class=""><?=$Cut_Qty[0]['cycle_flute_type']?></div>
                    <div class=""><?=(isset($Cut_Qty[1]['cycle_flute_type']) ) ? $CTN_DATA[1]['cycle_flute_type'] : '';?></div>
                </th>

            </tr>
        </tbody>
    </table>

    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-wrench-adjustable-circle-fill" viewBox="0 0 16 16">
                        <path d="M6.705 8.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16Zm-6.202-4.751 1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2a7.031 7.031 0 0 1-2.949-2.951ZM12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z"/>
                    </svg>
                    Plan Info
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col"  >
                    <div class ="text-secondary" >APPs</div>
                    <div class=""><?=$UsedPaper[0]['ups']?></div>
                    <div class=""><?=(isset($UsedPaper[1]['ups']) ) ? $UsedPaper[1]['ups'] : '';?></div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Wast (cm)</div>
                    <div class=""><?=$UsedPaper[0]['wast']?></div>
                    <div class=""><?=(isset($UsedPaper[1]['wast']) ) ? $UsedPaper[1]['wast'] : '';?></div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Reel</div>
                    <div class=""><?=$UsedPaper[0]['reel']?></div>
                    <div class=""><?=(isset($UsedPaper[1]['reel']) ) ? $UsedPaper[1]['reel'] : '';?></div>
                </th>
               
                <th scope="col"  >
                    <div class ="text-secondary" >Creasing (mm)</div>
                    <div class=""><?=$UsedPaper[0]['creesing']?></div>
                    <div class=""><?=(isset($UsedPaper[1]['creesing']) ) ? $UsedPaper[1]['creesing'] : '';?></div>
                </th>
                <th scope="col"  >
                    <div class ="text-black" >Cut Qty (cm) <span class = "text-danger fw-bold p-0 mt-2" style = "font-size:16px; "  >*</span> </div>
                    <div class=""><?=(isset($Cut_Qty[0]['cut_qty'])) ? $Cut_Qty[0]['cut_qty'] : '' ?></div>
                    <div class=""><?=(isset($Cut_Qty[1]['cut_qty']) ) ? $Cut_Qty[1]['cut_qty'] : '';?></div>
                </th>
            </tr>
        </tbody>
    </table>


    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr> <th scope="col" colspan=6 class ="py-1" >
            <svg fill="#000000" height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 360 360" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="XMLID_16_" d="M205,25C119.533,25,50,94.533,50,180c0,40.473,15.599,77.365,41.092,105H0v50h210v-0.089 c83.162-2.65,150-71.117,150-154.911C360,94.533,290.467,25,205,25z M116.731,217.83c-20.893,0-37.83-16.937-37.83-37.83 s16.937-37.83,37.83-37.83s37.83,16.937,37.83,37.83S137.624,217.83,116.731,217.83z M205,306.099 c-20.893,0-37.83-16.937-37.83-37.83s16.937-37.83,37.83-37.83s37.83,16.937,37.83,37.83S225.893,306.099,205,306.099z M205,129.56 c-20.893,0-37.83-16.937-37.83-37.83c0-20.893,16.937-37.83,37.83-37.83s37.83,16.937,37.83,37.83 C242.83,112.623,225.893,129.56,205,129.56z M293.269,217.83c-20.893,0-37.83-16.937-37.83-37.83s16.937-37.83,37.83-37.83 s37.83,16.937,37.83,37.83S314.162,217.83,293.269,217.83z"></path> </g></svg>
            Paper Info (First Job) [<?= $CTN_DATA[0]['JobNo']; ?>] </th> </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <?php for ($index=1; $index <= $CTN_DATA[0]['CTNType']; $index++):   ?>
                    <th scope="col"  >
                        <div class ="text-secondary" >L<?=$index?>- <?=$UsedPaper[0]['PSPN_'.$index]; ?></div>
                        <div class=""><?=(isset($UsedPaper[0]['RSC_'.$index])) ? $UsedPaper[0]['RSC_'.$index]  : '';  ?></div>
                    </th>
                <?php endfor; ?>
            </tr>
        </tbody>
    </table>

    <?php if(isset($CTN_DATA[1])) { ?>
        <table class="table table-bordered custom-font " >
            <thead style = "border-bottom:2px solid black;">
                <tr> <th scope="col" colspan=6 class ="py-1" >
                <svg fill="#000000" height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 360 360" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="XMLID_16_" d="M205,25C119.533,25,50,94.533,50,180c0,40.473,15.599,77.365,41.092,105H0v50h210v-0.089 c83.162-2.65,150-71.117,150-154.911C360,94.533,290.467,25,205,25z M116.731,217.83c-20.893,0-37.83-16.937-37.83-37.83 s16.937-37.83,37.83-37.83s37.83,16.937,37.83,37.83S137.624,217.83,116.731,217.83z M205,306.099 c-20.893,0-37.83-16.937-37.83-37.83s16.937-37.83,37.83-37.83s37.83,16.937,37.83,37.83S225.893,306.099,205,306.099z M205,129.56 c-20.893,0-37.83-16.937-37.83-37.83c0-20.893,16.937-37.83,37.83-37.83s37.83,16.937,37.83,37.83 C242.83,112.623,225.893,129.56,205,129.56z M293.269,217.83c-20.893,0-37.83-16.937-37.83-37.83s16.937-37.83,37.83-37.83 s37.83,16.937,37.83,37.83S314.162,217.83,293.269,217.83z"></path> </g></svg>
                    Paper Info (Second Job ) [<?= $CTN_DATA[1]['JobNo']; ?>] </th> </tr>
            </thead>
            <tbody>
                <tr class ="text-center" >
                    <?php for ($index=1; $index <= $CTN_DATA[1]['CTNType']; $index++):   ?>
                        <th scope="col"  >
                            <div class ="text-secondary" >L<?=$index?>- <?=$UsedPaper[1]['PSPN_'.$index]; ?></div>
                            <div class=""><?=(isset($UsedPaper[1]['RSC_'.$index])) ? $UsedPaper[1]['RSC_'.$index]  : '';  ?></div>
                        </th>
                    <?php endfor; ?>
                </tr>
            </tbody>
        </table>
    <?php } ?>

    <div class="form-floating mb-3">
        <textarea class="form-control"  readonly="readonly" placeholder="Leave a comment here" id="floatingTextarea">
            <?=(isset($Cut_Qty[0]['MarketingNote'])) ? $Cut_Qty[0]['MarketingNote'] : '' ?>
        </textarea>
        <label for="floatingTextarea">Comments for first Job</label>
    </div>

    <?php if(isset($Cut_Qty[1]['MarketingNote']) && !empty($Cut_Qty[1]['MarketingNote']) ): ?>
    <div class="form-floating">
        <textarea class="form-control"  readonly="readonly" placeholder="Leave a comment here" id="floatingTextarea">
            <?=(isset($Cut_Qty[1]['MarketingNote'])) ? $Cut_Qty[1]['MarketingNote'] : '' ?>
        </textarea>
        <label for="floatingTextarea">Comments for second Job</label>
    </div>
    <?php endif; ?>

    </div>
</div>
<?php } //  end of CARROGATION 5 PLY AND CARROGATION 3 PLY  ?>


<?php if(trim($machine_['machine_name']) == 'Flexo #1'  || trim($machine_['machine_name']) == 'Flexo #2') { ?>

<div class="card m-3 shadow">
    <div class="card-body">
    
    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                    </svg>
                Customer Info   </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col"  >
                    <div class ="text-secondary" >Job No: </div>
                    <div class =""><?=$CTN_DATA[0]['JobNo'];?></div>
                    <div><?=isset($CTN_DATA[1]['JobNo']) ? $CTN_DATA[1]['JobNo'] : '';?></div>
                </th>
                <th scope="col" >
                    <div  class ="text-secondary">Company Name:</div>
                    <div><?=$CTN_DATA[0]['CustName'];?></div>
                    <div><?=isset($CTN_DATA[1]['CustName']) ? $CTN_DATA[1]['CustName'] : '';?></div>
                </th>
                <th scope="col">
                    <div  class ="text-secondary">Product Name:</div>
                    <div><?=$CTN_DATA[0]['ProductName'];?></div>
                    <div><?=isset($CTN_DATA[1]['ProductName']) ? $CTN_DATA[1]['ProductName'] : '';?></div>
                </th>

                <th scope="col">
                    <div  class ="text-secondary">Order Qty:</div>
                    <div><?=$CTN_DATA[0]['CTNQTY'];?></div>
                    <div><?=isset($CTN_DATA[1]['CTNQTY']) ? $CTN_DATA[1]['CTNQTY'] : '';?></div>
                </th>

                <th scope="col"  >
                    <div class ="text-black" >Plan Qty (تعداد کاري) <span class = "text-danger fw-bold p-0 mt-2" style = "font-size:16px; "  >*</span></div>
                    <div class=""><?=(isset($Cut_Qty[0]['cycle_plan_qty'])) ? $Cut_Qty[0]['cycle_plan_qty'] : '' ?></div>
                </th>
            </tr>
        </tbody>
    </table>


    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" >  
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-rulers" viewBox="0 0 16 16" style = "transform:rotate(180deg)">
                        <path d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V2h1v4h1V4h1v2h1V2h1v4h1V4h1v2h1V2h1v4h1V1a1 1 0 0 0-1-1H1z"/>
                    </svg>
                    Product Info (mm)
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col">
                    <div class ="text-secondary" >L: </div>
                    <div><?=$CTN_DATA[0]['CTNLength'];?></div>
                </th>
                <th scope="col" >
                    <div class ="text-secondary" >W:</div>
                    <div><?=$CTN_DATA[0]['CTNWidth'];?></div>
                </th>
                <th scope="col">
                    <div class ="text-secondary" >H:</div>
                    <div><?=$CTN_DATA[0]['CTNHeight'];?></div>
                </th>

                <?php 

                    $total_width = 0 ; 
                    $total_length = 0 ; 
                    // TOTAL WIDTH BETWEEN  flexo_1p - flexo_2p - AND Default which is normal is the same 
                    $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] ; 
                    switch ($CTN_DATA[0]['production_job_type']) {
                        case 'Offset 1 Piece':
                            $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] + 2.5; 
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2  + 3; 
                            break;
                        case 'Offset 2 Piece':
                            $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] + 2.5; 
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) + 3; 
                            break;
                        case 'Flexo 1 Piece':
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2 + 3; 
                            break;
                        case 'Flexo 2 Piece':
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) + 3; 
                            break;
                        default:
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2 +3 ; 
                            break;
                    }

                ?>
 
                <th scope="col">
                    <div class ="text-secondary"  >Total Length:</div>
                    <div id = "1212" ><?=$total_length?> </div>
                </th>

                <th scope="col">
                    <div class ="text-secondary"  >Total Width:</div>
                    <div id = "" ><?=$total_width;?></div>
                </th>
            
                <th scope="col">
                    <div class ="text-secondary">Paper Type:</div>
                    <div>   <?php
                                $arr = []; 
                                for ($index=1; $index <= 7 ; $index++) { 
                                    if(empty($CTN_DATA[0]['Ctnp'.$index])) continue; 
                                    $arr[] = $CTN_DATA[0]['Ctnp'.$index];   
                                } 
                                $arr = array_count_values($arr);
                                foreach ($arr as $key => $value) {
                                    if(trim($key) === 'Flute') echo $value . " " . $key ;
                                    else  echo $key ; 
                                    if ($key === array_key_last($arr)) continue ; 
                                    echo " x ";
                                }  
                            ?>  
                    </div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Flute Type</div>
                    <div class=""><?=$Cut_Qty[0]['cycle_flute_type']?></div>
                </th>

            </tr>
        </tbody>
    </table>

    <?php 
        // this block is used to get polymer and die information for Flexo Job Card 
        $CPolymer = $Controller->QueryData('SELECT CPNumber , CartSample FROM cpolymer WHERE CPid  = ?',[$CTN_DATA[0]['PolyId']]);
        $CDie = $Controller->QueryData('SELECT DieCode , DieType FROM cdie WHERE CDieId = ?',[$CTN_DATA[0]['DieId']]);
        $Polymer = $CPolymer->fetch_assoc(); 
        $Die = $CDie->fetch_assoc(); 
    ?>

    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=5 class ="py-1" > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-paint-bucket" viewBox="0 0 16 16">
                        <path d="M6.192 2.78c-.458-.677-.927-1.248-1.35-1.643a2.972 2.972 0 0 0-.71-.515c-.217-.104-.56-.205-.882-.02-.367.213-.427.63-.43.896-.003.304.064.664.173 1.044.196.687.556 1.528 1.035 2.402L.752 8.22c-.277.277-.269.656-.218.918.055.283.187.593.36.903.348.627.92 1.361 1.626 2.068.707.707 1.441 1.278 2.068 1.626.31.173.62.305.903.36.262.05.64.059.918-.218l5.615-5.615c.118.257.092.512.05.939-.03.292-.068.665-.073 1.176v.123h.003a1 1 0 0 0 1.993 0H14v-.057a1.01 1.01 0 0 0-.004-.117c-.055-1.25-.7-2.738-1.86-3.494a4.322 4.322 0 0 0-.211-.434c-.349-.626-.92-1.36-1.627-2.067-.707-.707-1.441-1.279-2.068-1.627-.31-.172-.62-.304-.903-.36-.262-.05-.64-.058-.918.219l-.217.216zM4.16 1.867c.381.356.844.922 1.311 1.632l-.704.705c-.382-.727-.66-1.402-.813-1.938a3.283 3.283 0 0 1-.131-.673c.091.061.204.15.337.274zm.394 3.965c.54.852 1.107 1.567 1.607 2.033a.5.5 0 1 0 .682-.732c-.453-.422-1.017-1.136-1.564-2.027l1.088-1.088c.054.12.115.243.183.365.349.627.92 1.361 1.627 2.068.706.707 1.44 1.278 2.068 1.626.122.068.244.13.365.183l-4.861 4.862a.571.571 0 0 1-.068-.01c-.137-.027-.342-.104-.608-.252-.524-.292-1.186-.8-1.846-1.46-.66-.66-1.168-1.32-1.46-1.846-.147-.265-.225-.47-.251-.607a.573.573 0 0 1-.01-.068l3.048-3.047zm2.87-1.935a2.44 2.44 0 0 1-.241-.561c.135.033.324.11.562.241.524.292 1.186.8 1.846 1.46.45.45.83.901 1.118 1.31a3.497 3.497 0 0 0-1.066.091 11.27 11.27 0 0 1-.76-.694c-.66-.66-1.167-1.322-1.458-1.847z"/>
                    </svg>
                    Printing Info
                </th>
                <th class ="py-1" > 
                    Note
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col"  >
                    <div class ="text-secondary" > Plymer No   </div>
                    <div class=""><?=isset($Polymer['CPNumber']) ? $Polymer['CPNumber'] : '' ;?></div>
                </th>
                <th scope="col"  >
                    <div class ="text-secondary" >Die No</div>
                    <div class=""><?=isset($Die['DieCode']) ? $Die['DieCode'] : '' ;?></div>
                </th>
                <th scope="col"  >
                    <div class ="text-secondary" >Sample No</div>
                    <div class=""><?=isset($Polymer['CartSample']) ? $Polymer['CartSample'] : '' ;?></div>
                </th>
                <th scope="col"  >
                    <div class ="text-secondary" >Color </div>
                    <div class=""><?=isset($CTN_DATA[0]['CTNColor']) ? $CTN_DATA[0]['CTNColor'] : '' ;?></div>
                </th>
                <th scope="col"  >
                    <div class ="text-secondary" >Die Type</div>
                    <div class=""><?=isset($Die['DieType']) ? $Die['DieType'] : '' ;?></div>
                </th>
                <th scope="col"  >
                    <div class=""><?=isset($CTN_DATA[0]['MarketingNote']) ? $CTN_DATA[0]['MarketingNote'] : '' ;?></div>
                </th>
            </tr>
        </tbody>
    </table>


    <div class="form-floating mb-3">
        <textarea class="form-control"  readonly="readonly" placeholder="Leave a comment here" id="floatingTextarea">
            <?=(isset($Cut_Qty[0]['MarketingNote'])) ? $Cut_Qty[0]['MarketingNote'] : '' ?>
        </textarea>
        <label for="floatingTextarea">Comments for first Job</label>
    </div>

    <div >
        <img src="../Assets/DesignImages/<?=$CTN_DATA[0]['DesignImage']?>" class="img-fluid img-thumbnail  mx-auto  shadow" width="100%" alt="Design Image">
    </div> 

    </div><!-- end of card-body -->
</div><!-- end of card  -->

<?php } //  end of New Flexo AND Old Flexo  ?>

<?php if(trim($machine_['machine_name']) == 'Glue Folder') { ?>
<div class="card m-3 shadow">
    <div class="card-body">
    
    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                    </svg>
                Customer Info </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col"  >
                    <div class ="text-secondary" >Job No: </div>
                    <div class =""><?=$CTN_DATA[0]['JobNo'];?></div>
                </th>
                <th scope="col" >
                    <div  class ="text-secondary">Company Name:</div>
                    <div><?=$CTN_DATA[0]['CustName'];?></div>
                </th>
                <th scope="col">
                    <div  class ="text-secondary">Product Name:</div>
                    <div><?=$CTN_DATA[0]['ProductName'];?></div>
                </th>

                <th scope="col">
                    <div  class ="text-secondary">Order Qty:</div>
                    <div><?=$CTN_DATA[0]['CTNQTY'];?></div>
                </th>
                <th scope="col"  >
                    <div class ="text-black" >Plan Qty (تعداد کاري) <span class = "text-danger fw-bold p-0 mt-2" style = "font-size:16px; "  >*</span></div>
                    <div class=""><?=(isset($Cut_Qty[0]['cycle_plan_qty'])) ? $Cut_Qty[0]['cycle_plan_qty'] : '' ?></div>
                </th>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" >  
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-rulers" viewBox="0 0 16 16" style = "transform:rotate(180deg)">
                        <path d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V2h1v4h1V4h1v2h1V2h1v4h1V4h1v2h1V2h1v4h1V1a1 1 0 0 0-1-1H1z"/>
                    </svg>
                    Product Info (mm)
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col">
                    <div class ="text-secondary" >L: </div>
                    <div><?=$CTN_DATA[0]['CTNLength'];?></div>
                </th>
                <th scope="col" >
                    <div class ="text-secondary" >W:</div>
                    <div><?=$CTN_DATA[0]['CTNWidth'];?></div>
                </th>
                <th scope="col">
                    <div class ="text-secondary" >H:</div>
                    <div><?=$CTN_DATA[0]['CTNHeight'];?></div>
                </th>

                <?php 
                    $total_width = 0 ; 
                    $total_length = 0 ; 
                    // TOTAL WIDTH BETWEEN  flexo_1p - flexo_2p - AND Default which is normal is the same 
                    $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] ; 
                    switch ( $CTN_DATA[0]['production_job_type']) {
                        case 'Offset 1 Piece':
                            $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] + 2.5; 
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2  + 3; 
                            break;
                        case 'Offset 2 Piece':
                            $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] + 2.5; 
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) + 3; 
                            break;
                        case 'Flexo 1 Piece':
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2 + 3; 
                            break;
                        case 'Flexo 2 Piece':
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) + 3; 
                            break;
                        default:
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2 +3 ; 
                            break;
                    }
                ?>

                <th scope="col">
                    <div class ="text-secondary"  >Total Length:</div>
                    <div id = "1212" ><?=$total_length?> </div>
                </th>

                <th scope="col">
                    <div class ="text-secondary"  >Total Width:</div>
                    <div id = "" ><?=$total_width;?></div>
                </th>
                                
                <th scope="col">
                    <div class ="text-secondary">Paper Type:</div>
                    <div>   <?php
                                $arr = []; 
                                for ($index=1; $index <= 7 ; $index++) { 
                                    if(empty($CTN_DATA[0]['Ctnp'.$index])) continue; 
                                    $arr[] = $CTN_DATA[0]['Ctnp'.$index];   
                                } 
                                $arr = array_count_values($arr);
                                foreach ($arr as $key => $value) {
                                    if(trim($key) === 'Flute') echo $value . " " . $key ;
                                    else  echo $key ; 
                                    if ($key === array_key_last($arr)) continue ; 
                                    echo " x ";
                                }  
                            ?>  
                    </div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Flute Type</div>
                    <div class=""><?=$Cut_Qty[0]['cycle_flute_type']?></div>
                    <div class=""><?=(isset($Cut_Qty[1]['cycle_flute_type']) ) ? $CTN_DATA[1]['cycle_flute_type'] : '';?></div>
                </th>

            </tr>
        </tbody>
    </table>

    <div class="form-floating mb-3 ">
        <textarea class="form-control" readonly="readonly" placeholder="Leave a comment here" id="floatingTextarea">
            <?=(isset($Cut_Qty[0]['MarketingNote'])) ? $Cut_Qty[0]['MarketingNote'] : '' ?>
        </textarea>
        <label for="floatingTextarea">Comments for first Job</label>
    </div>

    <div >
        <img src="../Assets/DesignImages/<?=$CTN_DATA[0]['DesignImage']?>" class="img-fluid img-thumbnail  mx-auto  shadow" width="100%" alt="Design Image">
    </div> 

    </div><!-- end of card-body -->
</div><!-- end of card  -->
<?php } //  end of Glue Folder ?>



<?php if(trim($machine_['machine_name']) == '4 Khat') { ?>
<div class="card m-3 shadow">
    <div class="card-body">
    
    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                    </svg>
                Customer Info  </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col"  >
                    <div class ="text-secondary" >Job No: </div>
                    <div class =""><?=$CTN_DATA[0]['JobNo'];?></div>
                </th>
                <th scope="col" >
                    <div  class ="text-secondary">Company Name:</div>
                    <div><?=$CTN_DATA[0]['CustName'];?></div>
                </th>
                <th scope="col">
                    <div  class ="text-secondary">Product Name:</div>
                    <div><?=$CTN_DATA[0]['ProductName'];?></div>
                </th>

                <th scope="col">
                    <div  class ="text-secondary">Order Qty:</div>
                    <div><?=$CTN_DATA[0]['CTNQTY'];?></div>
                </th>
                <th scope="col"  >
                    <div class ="text-black" >Plan Qty (تعداد کاري) <span class = "text-danger fw-bold p-0 mt-2" style = "font-size:16px; "  >*</span></div>
                    <div class=""><?=(isset($Cut_Qty[0]['cycle_plan_qty'])) ? $Cut_Qty[0]['cycle_plan_qty'] : '' ?></div>
                </th>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" >  
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-rulers" viewBox="0 0 16 16" style = "transform:rotate(180deg)">
                        <path d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V2h1v4h1V4h1v2h1V2h1v4h1V4h1v2h1V2h1v4h1V1a1 1 0 0 0-1-1H1z"/>
                    </svg>
                    Product Info (mm)
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col">
                    <div class ="text-secondary" >L: </div>
                    <div><?=$CTN_DATA[0]['CTNLength'];?></div>
                </th>
                <th scope="col" >
                    <div class ="text-secondary" >W:</div>
                    <div><?=$CTN_DATA[0]['CTNWidth'];?></div>
                </th>
                <th scope="col">
                    <div class ="text-secondary" >H:</div>
                    <div><?=$CTN_DATA[0]['CTNHeight'];?></div>
                </th>

                <?php 
                    $total_width = 0 ; 
                    $total_length = 0 ; 
                    // TOTAL WIDTH BETWEEN  flexo_1p - flexo_2p - AND Default which is normal is the same 
                    $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] ; 
                    switch ( $CTN_DATA[0]['production_job_type']) {
                        case 'Offset 1 Piece':
                            $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] + 2.5; 
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2  + 3; 
                            break;
                        case 'Offset 2 Piece':
                            $total_width = $CTN_DATA[0]['CTNWidth'] + $CTN_DATA[0]['CTNHeight'] + 2.5; 
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) + 3; 
                            break;
                        case 'Flexo 1 Piece':
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2 + 3; 
                            break;
                        case 'Flexo 2 Piece':
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) + 3; 
                            break;
                        default:
                            $total_length = ($CTN_DATA[0]['CTNLength'] + $CTN_DATA[0]['CTNWidth']) * 2 +3 ; 
                            break;
                    }
                ?>

                <th scope="col">
                    <div class ="text-secondary"  >Total Length:</div>
                    <div id = "1212" ><?=$total_length?> </div>
                </th>

                <th scope="col">
                    <div class ="text-secondary"  >Total Width:</div>
                    <div id = "" ><?=$total_width;?></div>
                </th>
                                
                <th scope="col">
                    <div class ="text-secondary">Paper Type:</div>
                    <div>   <?php
                                $arr = []; 
                                for ($index=1; $index <= 7 ; $index++) { 
                                    if(empty($CTN_DATA[0]['Ctnp'.$index])) continue; 
                                    $arr[] = $CTN_DATA[0]['Ctnp'.$index];   
                                } 
                                $arr = array_count_values($arr);
                                foreach ($arr as $key => $value) {
                                    if(trim($key) === 'Flute') echo $value . " " . $key ;
                                    else  echo $key ; 
                                    if ($key === array_key_last($arr)) continue ; 
                                    echo " x ";
                                }  
                            ?>  
                    </div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Flute Type</div>
                    <div class=""><?=$Cut_Qty[0]['cycle_flute_type']?></div>
                    <div class=""><?=(isset($Cut_Qty[1]['cycle_flute_type']) ) ? $CTN_DATA[1]['cycle_flute_type'] : '';?></div>
                </th>

            </tr>
        </tbody>
    </table>

    <div class="form-floating mb-3">
        <textarea class="form-control"  readonly="readonly" placeholder="Leave a comment here" id="floatingTextarea">
            <?=(isset($Cut_Qty[0]['MarketingNote'])) ? $Cut_Qty[0]['MarketingNote'] : '' ?>
        </textarea>
        <label for="floatingTextarea">Comments for first Job</label>
    </div>

    <div >
        <img src="../Assets/DesignImages/<?=$CTN_DATA[0]['DesignImage']?>" class="img-fluid img-thumbnail  mx-auto  shadow" width="100%" alt="Design Image">
    </div> 

    </div><!-- end of card-body -->
</div><!-- end of card  -->
<?php } //  end of Glue Folder ?>


<?php $show_double_input = false ; if(isset($CTN_DATA[1]))  $show_double_input = true;   ?>



























<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog <?=($show_double_input) ? 'modal-lg': '' ; ?>">
    <div class="modal-content <?=($show_double_input) ? 'modal-lg': '' ; ?>  ">
      <div class="modal-header">
        <strong class="modal-title text-end" id="exampleModalLabel">  فورم تولید کارتن و ضایعات  </strong>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="ChangeUsedMachineStatus.php" id = "machine_form" method = "post" >
        <div class="modal-body">
            <input type="hidden" name="double_job" value = "<?=$double_job?>">
            
            <input type="hidden" name="machine_id" value = "<?=$machine_id?>" >
            <input type="hidden" name="CTNId[]" value = "<?=$CTN_DATA[0]['CTNId']?>">
            <input type="hidden" name="cycle_id[]" value = "<?=$Cut_Qty[0]['cycle_id']?>">

            <input type="hidden" name="last_shift" id = "last_shift">
            <input type="hidden" name="shift_wast_qty" id = "shift_wast_qty1">
            <input type="hidden" name="shift_produced_qty" id = "shift_produced_qty1">
            <input type="hidden" name="shift_labor" id = "shift_labor1">
            <input type="hidden" name="shift_eid" value = "<?=$_SESSION['EId']?>" >

            <?php if(isset($CTN_DATA[1])): ?>
                <input type="hidden" name="CTNId[]" value = "<?=$CTN_DATA[1]['CTNId']?>">
                <input type="hidden" name="cycle_id[]" value = "<?=$Cut_Qty[1]['cycle_id']?>">
            <?php endif;  ?>
                    
            <div class="row mb-3">
                <div class = "<?=($show_double_input) ? 'col-lg-6': 'col-lg-12' ; ?> col-sm-12 text-center ">
                    <div><?=$CTN_DATA[0]['ProductName'];?></div>
                </div>
                <div class="col-lg-6 col-sm-12 text-center">
                    <div><?=isset($CTN_DATA[1]['ProductName']) ? $CTN_DATA[1]['ProductName'] : '';?></div>
                </div>
            </div>

            <div class="row">
                <div class="<?=($show_double_input) ? 'col-lg-6': 'col-lg-12' ; ?> col-sm-12">
                    <div class="form-floating ">
                        <input type="number" name = "produced_qty[]" readonly id = "final_produced_qty" class="form-control mb-3" value = "" placeholder="تعداد تولید" aria-label="produced_qty">
                        <label for="floatingInput">تعداد تولید</label>
                    </div>
                </div>
                <?php if(isset($CTN_DATA[1])): ?>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-floating ">
                        <input type="number" name = "produced_qty[]" readonly class="form-control mb-3" value = "" placeholder="تعداد تولید" aria-label="produced_qty">
                        <label for="floatingInput">تعداد تولید</label>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="<?=($show_double_input) ? 'col-lg-6': 'col-lg-12' ; ?> col-sm-12">
                    <div class="form-floating ">
                        <input type="number" name = "wast_qty[]"  readonly id = "final_wast_qty" class="form-control mb-3" placeholder="تعداد ضایعات" aria-label="produced_qty">
                        <label for="floatingInput"> تعداد ضایعات </label>
                    </div>
                </div>
                <?php if(isset($CTN_DATA[1])): ?>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-floating ">
                        <input type="number" name = "wast_qty[]" readonly class="form-control mb-3" value = ""  placeholder="تعداد ضایعات" aria-label="produced_qty">
                        <label for="floatingInput"> تعداد ضایعات </label>
                    </div>
                </div>
                <?php endif;  ?>
            </div>
          
            <div class="form-floating ">
                <input type="number" name = "number_labor" readonly class="form-control mb-3" value = "18" placeholder="تعداد کارگر" aria-label="produced_qty">
                <label for="floatingInput">تعداد کارگر</label>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">تکمیل نمودن جاب</button>
        </div>

      </form>
    </div>
  </div>
</div>













<!-- SHIFT OFFCANVAS  -->
<div class="offcanvas offcanvas-end " style = "width:40%;"  tabindex="-1" id="offcanvasRight"  aria-labelledby="offcanvasRightLabel" >
  <div class="offcanvas-header" >
    <h5 id="offcanvasRightLabel">برای تبدیل نموند شتف خویش از این فور و گزینه استفاده نمایید</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body"  >
    <form action="ShiftRegister.php" method = "post">
        <input type="hidden" name = "machine_id" value = "<?=$machine_id?>" >
        <input type="hidden" name = "CTNId" value = "<?=$CTN_DATA[0]['CTNId']?>">
        <input type="hidden" name = "cycle_id" value = "<?=$Cut_Qty[0]['cycle_id']?>"> 
        <input type="hidden" name = "double_job" value = "<?=$double_job?>">
        <input type="hidden" name = "EId" value = "<?=$_SESSION['EId']?>">
        <input type="hidden" name = "start_date"  value = "<?=$_SESSION['last_login_timestamp']?>">
        
        <?php if(trim($machine_['machine_name']) == 'Carrogation 5 Ply'  || trim($machine_['machine_name']) == 'Carrogation 3 Ply') { ?>
            <div class="alert alert-danger" role="alert">
                <strong class = "text-danger " style = "font-size:13px;" >لطف نموده مقدار کت را ذخیره نمایید</strong>
            </div>
        <?php } ?>
               
        <div class="row">
            <div class="col-lg-4 col-sm-12 col-md-4 ">
                <div class="form-floating ">
                    <input type="number" name = "produced_qty" id = "shift_produced_qty"class="form-control mb-3"   placeholder="تعداد تولید" aria-label="produced_qty">
                    <?php if(trim($machine_['machine_name']) == 'Carrogation 5 Ply'  || trim($machine_['machine_name']) == 'Carrogation 3 Ply') { ?>
                        <label for="floatingInput">مقدار کت</label>
                    <?php } else { ?>
                        <label for="floatingInput">تعداد تولید</label>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-md-4">
                <div class="form-floating ">
                    <input type="number" name = "wast"  id = "shift_wast_qty" class="form-control mb-3"   placeholder="تعداد ضایعات" aria-label="produced_qty">
                    <label for="floatingInput"> تعداد ضایعات </label>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-md-4 ">
                <div class="form-floating ">
                    <input type="number" name = "labor" id = "shift_labor" class="form-control mb-3" value = "18" placeholder="تعداد کارگر" aria-label="produced_qty">
                    <label for="floatingInput">تعداد کارگر</label>
                </div>
            </div>
        </div>
      

        <div class="modal-footer" class= "d-flex justify-content-start" >
            <div> <button type="submit" class="btn btn-primary">ثبت و تبدیل شفت</button></div>
            <div> <button type="button" onclick = "GetProductionAmount()" data-bs-toggle="modal" data-bs-target="#exampleModal" class = "btn btn-outline-success">تکمیل نمودن جاب</button></div>
        </div>
    </form>

    <?php 
        $Row = $Controller->QueryData('SELECT produced_qty,wast,labor,start_date,end_date,Ename FROM machine_shift_history INNER JOIN employeet ON machine_shift_history.EId = employeet.EId  WHERE CTNId = ? AND cycle_id = ? AND machine_id = ? ',
        [$CTN_DATA[0]['CTNId'],$Cut_Qty[0]['cycle_id'],$machine_id]);
    ?>
    <div class = "h5">  لست شفت های گذشته  </div>
    <hr>
    <table class = "table table-bordered">
        <tr>
            <th>Opreator</th>
            <th>Produced </th>
            <th>Wast</th>
            <th>Labor</th>
            <th>Start</th>
            <th>End</th>
        </tr>
       <?php $total_produced = 0 ; $total_wast = 0;  while($Shift = $Row->fetch_assoc()){ ?>
        <tr>
            <td><?= $Shift['Ename'];?></td>
            <td><?= $Shift['produced_qty'];?></td>
            <td><?= $Shift['wast'];?></td>
            <td><?= $Shift['labor'];?></td>
            <td><?= $Shift['start_date'];?></td>
            <td><?= $Shift['end_date'];?></td>
        </tr>  
       <?php    $total_produced +=  $Shift['produced_qty'] ;
                $total_wast +=  $Shift['wast'] ; } 
        ?>      

       <tr>
        <td>Total</td>
        <td id = "total_produced"><?=$total_produced?></td>
        <td id = "total_wast"><?=$total_wast?></td>
       </tr>
    </table>
    

  </div>
</div>



<meta id = "production_start_date"  name="production_start_date" content="<?=(isset($production_start_date)) ? $production_start_date : 'NULL';?>">
<input type="hidden" id="stop_counter" value = "<?= isset($stop_counter) ? $stop_counter : '' ; ?>" >

<script>
    
    let psd = document.getElementById('production_start_date').content; 

    if(psd != 'NULL'){

        let startingDate = new Date(psd).getTime();
        let counter = document.querySelector('.countup-timer');
        const zeroPad = (num, places) => String(num).padStart(places, '0')

        let timer = setInterval(function() {

            let newDate = new Date().getTime();
            let finalDate = newDate - startingDate;

            let days = Math.floor(finalDate / (1000 * 60 * 60 * 24));
            let hours = Math.floor((finalDate % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((finalDate % (1000 * 60 *60)) / (1000 * 60));
            let seconds = Math.floor((finalDate % (1000 * 60)) / 1000);

            counter.innerHTML =  zeroPad(days,2) + "-" + zeroPad(hours,2) +":"+ zeroPad(minutes,2) +":"+ zeroPad(seconds,2);
            if( document.getElementById('stop_counter').value == 'yes') clearInterval(timer); 

        }, 1000) 
    }

    function SetStatus(status){
        let stat = document.getElementById('status');
        stat.value = status; 
        if(confirm('ایا مطمین استید برای متوقف نمودن تولید؟')) stat.form.submit(); 
        else return ; 
    }
</script>
<script>
    function GetProductionAmount() {
        let shift_pro_qty   = Number(document.getElementById('shift_produced_qty').value); 
        let shift_wast_qty  = Number(document.getElementById('shift_wast_qty').value); 
        let shift_labor     = Number(document.getElementById('shift_labor').value); 
        let total_pro_qty   = Number(document.getElementById('total_produced').innerHTML) ; 
        let total_wast_qty  = Number(document.getElementById('total_wast').innerHTML) ; 

        document.getElementById('final_produced_qty').value  = shift_pro_qty + total_pro_qty ; 
        document.getElementById('final_wast_qty').value = shift_wast_qty + total_wast_qty ; 
        
        document.getElementById('last_shift').value = 'LAST_SHIFT'; 
        document.getElementById('shift_wast_qty1').value = Number(document.getElementById('shift_wast_qty').value);
        document.getElementById('shift_produced_qty1').value = Number(document.getElementById('shift_produced_qty').value);
        document.getElementById('shift_labor1').value = Number(shift_labor);

    }
</script>

<script src = "../Public/Js/popper.min.js" ></script>
<?php  require_once '../App/partials/Footer.inc'; ?>