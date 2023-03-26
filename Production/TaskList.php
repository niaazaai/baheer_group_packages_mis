<?php 
   ob_start();
   require_once '../App/partials/Header.inc'; 
   $Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
   if(!in_array( $Gate['VIEW_TASK_LIST_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
     header("Location:index.php?msg=You are not authorized to access this page!" );
   }

    require_once '../App/partials/Menu/MarketingMenu.inc';
    require_once '../Assets/Carbon/autoload.php'; 
    use Carbon\Carbon;

    $machine = []; 
    $machine['machine_name'] = 'ALL';
    $machine['machine_id'] = null;

    if(isset($_POST['selected_machine']) && !empty($_POST['selected_machine'])) {
        if($_POST['selected_machine'] != 'ALL') {
            $machine = $Controller->QueryData("SELECT * FROM machine WHERE machine_id = ?", [$_POST['selected_machine']]);
            if($machine->num_rows > 0 ) $machine = $machine->fetch_assoc(); 
        }
    }
     
    // var_dump($machine['machine_name']); 
    // var_dump(  $machine['machine_name']);
    // $machine['machine_name'] = 'Carrogation 3 Ply'; 
    // echo $machine['machine_opreator_id']; 

    // this block will enable each  machine opreator to show it's own machine records.  
    $table_query = ''; 
    $table_query_input = [$machine['machine_id']]; 
    $double_job = ''; 

    switch (trim($machine['machine_name'])) {

        case 'Carrogation 5 Ply':  
        case 'Carrogation 3 Ply':
        // jobs , product_name , size - ply, type, app , reel , creasing, cut_qty , order-qty , plan-qty , produce-qt , comment , paper  
            $table_heading = '
                <th>#</th>
                <th>JobNo</th>
                <th>Product Name</th>
                <th style = "" >Size (LxWxH) cm - ply </th>
                <th>Type</th>
                <th>App</th>
                <th>Reel</th>
                <th>Creasing</th>
                <th>Cut Qty</th>
                <th>Order Qty</th>
                <th>Plan Qty</th>
                <th>Produce Qty</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Paper</th>
                <th class="text-center">OPS</th>'; 
            
            $table_query = "SELECT carton.CTNId, machine.machine_id , 
                production_cycle.cycle_id ,carton.JobNo, carton.ProductName ,  CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) , ' - ', CTNType , ' Ply'  ) AS Size ,CTNUnit,   
                used_paper.ups , used_paper.reel , used_paper.creesing , production_cycle.cut_qty , carton.CTNQTY , production_cycle.cycle_plan_qty , carton.ProductQTY  ,
                 used_paper.comment , production_cycle.cycle_flute_type , 
                PSPN_1,PSPN_2,PSPN_3,PSPN_4,PSPN_5,PSPN_6, PSPN_7,used_machine.id as umid,used_machine.status as machine_status,  production_cycle.page_arrival_time
                FROM carton 
                INNER JOIN  production_cycle on production_cycle.CTNId = carton.CTNId 
                INNER JOIN  used_machine on production_cycle.cycle_id = used_machine.cycle_id 
                INNER JOIN  machine on used_machine.machine_id = machine.machine_id 
                INNER JOIN  used_paper on carton.CTNId = used_paper.carton_id 
                WHERE production_cycle.cycle_status = 'Task List' AND ( used_machine.status = 'Incomplete' OR used_machine.status = 'Proccessed' ) AND machine.machine_id = ?";
        break;

        case 'Flexo #1':  
        case 'Flexo #2':
            $table_heading = '
                <th>#</th>
                <th>JobNo</th>
                <th>Product Name</th>
                <th>Size (LxWxH)</th>
                <th>Type</th>
                <th>color</th>
                <th>Order Qty</th>
                <th>Plan Qty</th>
                <th>Produce Qty</th>
                <th>Comment</th>
                <th>Paper</th>
                <th>Status</th>
                <th class="text-center">OPS</th>'; 
            $table_query = "SELECT carton.CTNId, machine.machine_id , production_cycle.cycle_id , carton.JobNo,carton.ProductName ,   CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) , ' - ', CTNType , ' Ply'  ) AS Size,
                CTNUnit, CTNColor , carton.CTNQTY , production_cycle.cycle_plan_qty , carton.ProductQTY  ,  used_paper.comment, production_cycle.cycle_flute_type , 
                PSPN_1,PSPN_2,PSPN_3,PSPN_4,PSPN_5,PSPN_6, PSPN_7  ,used_machine.id as umid,used_machine.status as machine_status ,  production_cycle.page_arrival_time
                FROM carton
                INNER JOIN  production_cycle on production_cycle.CTNId = carton.CTNId 
                INNER JOIN  used_machine on production_cycle.cycle_id = used_machine.cycle_id 
                INNER JOIN  machine on used_machine.machine_id = machine.machine_id 
                INNER JOIN  used_paper on carton.CTNId = used_paper.carton_id 
                WHERE production_cycle.cycle_status = 'Task List' AND ( used_machine.status = 'Incomplete' OR used_machine.status = 'Proccessed' ) AND machine.machine_id = ?";
        break; 

        case 'Glue Folder':
            // : job , product_name , size , type ,   , color, paper, order-qty , plan qty , produce_qty ,comment 
            $table_heading = '
                <th>#</th>
                <th>JobNo</th>
                <th>Product Name</th> 
                <th>Size (LxWxH) cm</th>
                <th>Type</th> 
                <th>Color</th>
                <th>Paper</th>
                <th>Status</th>
                <th class="text-center">OPS</th>'; 
            $table_query = "SELECT 
            carton.CTNId, machine.machine_id , production_cycle.cycle_id , carton.JobNo, carton.ProductName ,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) , ' - ', CTNType , ' Ply'  ) AS Size,
            CTNUnit , CTNColor , production_cycle.cycle_flute_type, 
            PSPN_1,PSPN_2,PSPN_3,PSPN_4,PSPN_5,PSPN_6, PSPN_7,used_machine.id as umid ,used_machine.status as machine_status,  production_cycle.page_arrival_time
            FROM carton
            INNER JOIN  production_cycle on production_cycle.CTNId = carton.CTNId 
            INNER JOIN  used_machine on production_cycle.cycle_id = used_machine.cycle_id 
            INNER JOIN  machine on used_machine.machine_id = machine.machine_id 
            INNER JOIN  used_paper on carton.CTNId = used_paper.carton_id 
            WHERE production_cycle.cycle_status = 'Task List' AND ( used_machine.status = 'Incomplete' OR used_machine.status = 'Proccessed' ) AND machine.machine_id = ?";
        break; 

        default:
        $table_heading = '
            <th>#</th>
            <th>JobNo</th>
            <th>Product Name</th>
            <th>Size (LxWxH) cm</th>
            <th>Color</th> 
            <th>Order Qt</th>
            <th>Plan Qty</th>
            <th>Produced Qty</th>
            <th>Machine</th>
            <th>Paper</th>
            <th>Status</th>
            <th class="text-center">OPS</th>'; 
        $table_query = "SELECT carton.CTNId, machine.machine_id , production_cycle.cycle_id , 
            carton.JobNo ,  carton.ProductName , CONCAT( FORMAT(CTNLength / 10 ,1 ) , 'x' , FORMAT ( CTNWidth / 10 , 1 ), 'x', FORMAT(CTNHeight/ 10,1) ) AS Size ,  
            carton.CTNColor  ,  carton.CTNQTY ,  production_cycle.cycle_plan_qty , used_machine.produced_qty as produced_amount,  machine.machine_name ,
            production_cycle.cycle_flute_type ,PSPN_1,PSPN_2,PSPN_3,PSPN_4,PSPN_5,PSPN_6, PSPN_7, used_machine.id as umid, used_machine.status as machine_status, production_cycle.page_arrival_time
            FROM carton  
            INNER JOIN  production_cycle on production_cycle.CTNId = carton.CTNId 
            INNER JOIN  used_machine on production_cycle.cycle_id = used_machine.cycle_id 
            INNER JOIN  machine on used_machine.machine_id = machine.machine_id 
            INNER JOIN  used_paper on carton.CTNId = used_paper.carton_id 
            WHERE cycle_status = 'Task List' AND ( used_machine.status = 'Incomplete' OR used_machine.status = 'Proccessed')";
            $table_query_input= []; //AND used_machine.status = 'Incomplete'
        break;
    }
    $DataRows=$Controller->QueryData($table_query,$table_query_input);

    $arr = []; 
    $Double=$Controller->QueryData("SELECT carton.CTNId,carton.JobNo,PSPN_1,PSPN_2,PSPN_3,PSPN_4,PSPN_5,PSPN_6, PSPN_7,production_cycle.cycle_flute_type
    FROM carton 
    INNER JOIN used_paper ON carton.CTNId= used_paper.carton_id 
    INNER JOIN  production_cycle on production_cycle.CTNId = carton.CTNId
    WHERE JobNo != 'NULL' AND cycle_status = 'Task List'    
    ORDER BY JobNo DESC" ,[]);
    
    while($data = $Double->fetch_assoc()) {
        $paper =  "{$data['PSPN_1']},{$data['PSPN_2']},{$data['PSPN_3']},{$data['PSPN_4']},{$data['PSPN_5']},{$data['PSPN_6']},{$data['PSPN_7']} - {$data['cycle_flute_type']}"; 
        $arr[$data['JobNo']] = $paper; 
    }

    $temp =  []; 
    foreach (array_count_values($arr) as $key => $value) {
        $ddd = $value; 
        if($value > 1 ) {
            $str_arr = explode (",", $key); 
            $str_arr = array_filter($str_arr); 
            $xx = ''; 
            foreach (array_count_values($str_arr) as $key => $value) {
                if(trim($key) === 'Flute') $xx .=  ' x ' . $value   . " " . $key . ' x ';
                else  $xx .= $key; 
            }  
            array_push($temp , [$ddd => $xx]); 
        }
    }

?>

<style>
    td, th {
        vertical-align:middle;
    }
</style>
 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between    ">
    <div> 
        <a class="btn btn-outline-primary   me-1" href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
            </svg>
        </a>
        <svg width="45" height="45" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 57 57" xml:space="preserve" fill="#0d6efd" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#0250c4;">
            <path d="M52.699,45.02c-0.55-0.101-1.069,0.241-1.18,0.781C50.403,51.303,46.074,55,40.749,55c-5.028,0-9.446-3.3-10.948-8H34.5v-2
                h-8v8h2v-3.849C30.669,53.833,35.415,57,40.749,57c6.304,0,11.42-4.341,12.731-10.801C53.59,45.657,53.24,45.13,52.699,45.02z"></path>
            <path d="M52.5,37.309C50.25,32.854,45.796,30,40.749,30c-6.109,0-11.541,3.997-13.209,9.721c-0.154,0.53,0.15,1.085,0.681,1.239
                c0.529,0.158,1.085-0.15,1.239-0.681C30.858,35.482,35.605,32,40.749,32c4.565,0,8.562,2.766,10.33,7H46.5v2h8v-8h-2V37.309z"></path>
            <path d="M28.5,14h18c0.553,0,1-0.447,1-1s-0.447-1-1-1h-18c-0.553,0-1,0.447-1,1S27.947,14,28.5,14z"></path>
            <path d="M28.5,28h18c0.553,0,1-0.447,1-1s-0.447-1-1-1h-18c-0.553,0-1,0.447-1,1S27.947,28,28.5,28z"></path>
            <path d="M22.079,7.241c-0.418-0.358-1.05-0.313-1.409,0.108l-6.248,7.288L10.6,11.771c-0.441-0.331-1.068-0.243-1.399,0.2
                c-0.332,0.441-0.242,1.068,0.2,1.399l4.571,3.429c0.179,0.135,0.39,0.2,0.599,0.2c0.283,0,0.563-0.119,0.76-0.35l6.857-8
                C22.548,8.231,22.499,7.601,22.079,7.241z"></path>
            <path d="M22.079,21.241c-0.418-0.359-1.05-0.312-1.409,0.108l-6.248,7.288L10.6,25.771c-0.441-0.331-1.068-0.243-1.399,0.2
                c-0.332,0.441-0.242,1.068,0.2,1.399l4.571,3.429c0.179,0.135,0.39,0.2,0.599,0.2c0.283,0,0.563-0.119,0.76-0.35l6.857-8
                C22.548,22.231,22.499,21.601,22.079,21.241z"></path>
            <path d="M20.67,36.35l-6.248,7.287L10.6,40.771c-0.441-0.33-1.068-0.243-1.399,0.2c-0.332,0.441-0.242,1.068,0.2,1.399l4.571,3.429
                c0.179,0.135,0.39,0.2,0.599,0.2c0.283,0,0.563-0.119,0.76-0.35l6.857-7.999c0.36-0.419,0.312-1.05-0.108-1.409
                C21.661,35.883,21.029,35.929,20.67,36.35z"></path>
            <path d="M43.324,0H13.676C6.962,0,1.5,5.462,1.5,12.176v29.648C1.5,48.538,6.962,54,13.676,54H22.5c0.553,0,1-0.447,1-1
                s-0.447-1-1-1h-8.824C8.064,52,3.5,47.436,3.5,41.824V12.176C3.5,6.564,8.064,2,13.676,2h29.648C48.936,2,53.5,6.564,53.5,12.176
                V27c0,0.553,0.447,1,1,1s1-0.447,1-1V12.176C55.5,5.462,50.038,0,43.324,0z"></path>
        </svg>
        <span class = "fs-bold fs-4 ps-2" > Task List   </span> 
    </div>    
    <div>
        <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
            </svg>
        </a>
    </div>
    </div>
</div>

<div class="card m-3 mb-0 shadow">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <form action="" method = "post"  >
                    <div class="form-floating">
                        <select class="form-select form-sm" id="sss"   name = "selected_machine" onchange="this.form.submit();" >
                            <option selected > <?=$machine['machine_name']?> Jobs</option>
                            <option  value="ALL">ALL</option>
                            <option value="1">Carrogation 5 ply </option>
                            <option value="2">Carrogation 3 ply </option>
                            <option value="3">Flexo #1 </option>
                            <option value="4">Flexo #2 </option>
                            <option value="5">Glue Folder </option>
                            <option value="6">4 Khat </option>
                        </select>
                        <label for="sss">Select Machines</label>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-floating">
                    <input type="text" class="form-control"  id = "Search_input" placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
                    <label for="Reel">Search Anything</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class = " ms-3 my-2 p-0 "  >
    <a href='#'><span   onclick = 'PutSearchTermToInputBox(``)' class = 'badge py-2' style = 'background-color:#6D67E4; font-size:11px;' > ALL</span></a>
    <?php  
        foreach ($temp as $key => $value) {
            foreach ($value as $k => $v) {
                echo " <a href='#'><span onclick = 'PutSearchTermToInputBox(`". strtok($v, '-') . "`)' 
                class = 'badge me-1' style = 'background-color:#6D67E4; font-size:11px;' >
                <span class = 'badge rounded-pill me-1' style = 'font-size:12px;background-color:#FFBF00'   >" . $k. '</span> '.  $v ."</span></a> ";  
            }
        } 
    ?>
</div>

<div class="card shadow m-3   mt-0 " >
    <div class="card-body">
    <form action="DoubleJobProcess.php" method="post">
    <table class = "table" id = "JobTable">
        <tr class="table-info">
            <?=$table_heading; ?>
        </tr>
        <?php
          if($DataRows->num_rows){   $counter = 1 ; 
            while ($Rows = $DataRows->fetch_assoc() ) {     ?>
            <tr style = "background-color:<?=($Rows['machine_status'] == 'Proccessed') ?'#38E54D': ''?>; font-size:14px; ">
                <td><?=$counter++; ?></td>
                <?php foreach ($Rows  as $key => $value) { ?>
                    <?php  if($key == 'CTNId' || 
                    $key == 'cycle_id' || 
                    $key == 'machine_id' || 
                    $key == 'cycle_flute_type' || 
                    $key == 'PSPN_1' ||
                    $key == 'PSPN_2' ||
                    $key == 'PSPN_3' ||
                    $key == 'PSPN_4' ||
                    $key == 'PSPN_5' ||
                    $key == 'PSPN_6' ||
                    $key == 'PSPN_7' ||
                    $key == 'machine_status' ||
                    $key == 'page_arrival_time' ||
                    $key == 'umid' ) continue; ?>
                    <td>
                        <?php 
                            if($key == "CFluteType"){
                                if($machine['machine_name'] == 'Carrogation 5 Ply') $value = 'BC'; 
                                if($machine['machine_name'] == 'Carrogation 3 Ply') $value = 'C';  
                            }
                            echo $value;
                        ?>
                        <?=($key == 'CTNType') ? ' Ply' : '' ?>
                    </td>

                <?php } ?>  

                <td>
                    <span class ="badge _selected_paper_" style = "background-color:#6D67E4; font-size:12px;">
                        <?php
                            $arr = []; 
                            for ($index=1; $index <= 7 ; $index++) { 
                                if(empty($Rows['PSPN_'.$index])) continue; 
                                $arr[] = $Rows['PSPN_'.$index];   
                            } 

                            $arr = array_count_values($arr);
                            foreach ($arr as $key => $value) {
                                if(trim($key) === 'Flute') echo $value . " " . $key ;
                                else  echo $key ; 
                                if ($key === array_key_last($arr)) continue ; 
                                echo " x ";
                            }   
                        ?>
                    </span>

                    <span class ="badge _selected_paper_" style = "background-color:#6D67E4; font-size:12px;">
                        <?=$Rows['cycle_flute_type']?>
                    </span>
                </td>
                <td>
                    <span class ="badge bg-dark" style = "font-size:12px;"> <?=$Rows['machine_status'] ?> </span>
                    <?php 
                        if(isset($Rows['page_arrival_time']) && !empty($Rows['page_arrival_time'])) {
                            $a =  Carbon::createFromTimeStamp(strtotime($Rows['page_arrival_time']) , 'Asia/Kabul' )->diffForHumans();
                            echo "<span class = 'badge bg-dark'> Arrived {$a}</span>";
                        }
                    ?>
                </td>
                <td class = "text-center">
                    <?php if($Rows['machine_status'] == 'Incomplete') {  ?>
                        <a type="button" href="ChangeCycleStatus.php?umid=<?=$Rows['umid']?>&ccs=1qaz2wsx3edc4rfv5tgb6yhn&CTNId=<?=$Rows['CTNId']?>"  onclick = "return confirm('are you sure'); "  class="btn btn-outline-primary btn-sm ">   
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="p-0 m-0" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"></path>
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"></path>
                            </svg>
                            Send For Process 
                        </a>

                        <a href="JobManagement.php?CTNId=<?=$Rows['CTNId']?>" class = "btn btn-outline-primary btn-sm ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.004-.001.274-.11a.75.75 0 0 1 .558 0l.274.11.004.001 6.971 2.789Zm-1.374.527L8 5.962 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339Z"/>
                            </svg> Manage
                        </a>
                        <input  type="checkbox" name="umid[]" value = "DJ_<?=$Rows['CTNId']?>_<?=$Rows['umid']?>"  class= "form-check-input fs-4  mt-1 ms-2"  id="">

                     <?php  } else if($Rows['machine_status'] == 'Proccessed') { ?>
                       
                        <a href="MarkAsComplete.php?umid=<?=$Rows['umid']?>&CTNId=<?=$Rows['CTNId']?>" class = "btn btn-outline-dark btn-sm  ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                            </svg> Mark as Complete
                        </a>
                    
                    <?php } ?>

                    <!-- echo '<span class = "ms-1 bg-danger"  style = "padding:2px; color:white;">Sent to Process</span>'; -->
                        <!-- <a type="button" href="ChangeCycleStatus.php?umid=<?=$Rows['umid']?>&ccs=1qaz2wsx3edc4rfv5tgb6yhn"  onclick = "return confirm('are you sure'); "  class="btn btn-outline-primary btn-sm ">   
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="p-0 m-0" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"></path>
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"></path>
                            </svg>
                            Send For Process 
                        </a> 
                        -->
                  
                </td>
            </tr>
        <?php 
            }   
        } 
        ?>
    </table>
        <div class = "text-end" >
                <button type="submit" class = "btn btn-outline-info btn-sm">
                    Double Job
                </button>
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

    function PutSearchTermToInputBox(input) {
        document.getElementById('Search_input').value = input; 
        search('Search_input' ,'JobTable');  
    }
</script>
<?php  require_once '../App/partials/Footer.inc'; ?>