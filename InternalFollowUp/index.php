<?php require_once '../App/partials/Header.inc';   require_once '../App/partials/Menu/MarketingMenu.inc';


date_default_timezone_set('Asia/Kabul');
 

// job arrived at finance department , track when the job arrived there if arrival time + deadline is greater then current time. 

    $Query = "SELECT  CTNId , CustName , JobNo , CustId , CTNFinishDate , ProductName  , CTNQTY   , CusProvince   , CTNStatus  , job_arrival_time , 
    CTNStatus , carton.followed_up , ProductQTY , UsedQty  
        FROM carton
        INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
        WHERE JobNo != 'NULL' && ProductQTY - UsedQty > 0   ";
    $DataRows = $Controller->QueryData($Query, []); 
// && CTNStatus != 'Postpond' 

    $Internal = []; 
    $IFS = $Controller->QueryData('SELECT * FROM internal_followup_setting', []); 

    
    while($fs = $IFS->fetch_assoc()) {
        array_push( $Internal , [ 'CTNStatus' =>  $fs['slug'] , 'day' => $fs['day'] , 'hour' => $fs['hour'] , 'minute' => $fs['minute']     ]); 
    }

    // $day = 0; 
    // $hr  = 0; 
    // $min = 48; 
    // $arrival_time = $DataRows->fetch_assoc()['job_arrival_time'] ; 

    // $arrival_time = '2023-02-22 15:00:00';
    // $hours = "+$day days $hr hours $min minutes";
    
    // $d0 = strtotime(date('Y-m-d 00:00:00'));
    // $d1 = strtotime(date('Y-m-d').$hours);

    // $sumTime = strtotime($arrival_time) + ($d1 - $d0);
    // $deadline = date("Y-m-d H:i:s", $sumTime);
    // echo $deadline; 
    // echo "<br>";
    // echo date("Y-m-d H:i:s"); 

    // if(date("Y-m-d H:i:s") > $deadline) {
    //     echo "<br>";
    //     echo "alert user"; 
    // }


    function CheckJobTimouts($arrival_time , $day , $hr , $min ) {
        $hours = "+$day days $hr hours $min minutes";
        $d0 = strtotime(date('Y-m-d 00:00:00'));
        $d1 = strtotime(date('Y-m-d').$hours);

        $sumTime = strtotime($arrival_time) + ($d1 - $d0);
        $deadline = date("Y-m-d H:i:s", $sumTime);
        
        if(date("Y-m-d H:i:s") > $deadline) return true; 
        else return false; 
    } // END OF check job timouts 
    
 
    function ApplySetting( $arrival_time , $status ,  $Internal) {
        // loop through follow team setting list 
        foreach ($Internal as $key => $value) {
            // check if the job belongs to a list item in setting list 
            if(trim($status) == $value['CTNStatus']) {
                // check if arrival time and etc... 
               return CheckJobTimouts($arrival_time , $value['day'] , $value['hour'] , $value['minute']); 
            }
        } // end of foreach 
    }


    function CustomApplySetting(   $custom_deadline) {
        // this part will take deadline and extract the day , hour , min for custom deadline follow up for example the user will specify 2 min later the job must appear to me back 
        // so to do that we haveto give it the custom day , hour , min
        // $day = date('d' , strtotime($custom_deadline)); 
        // $hour = date('H' , strtotime($custom_deadline)); 
        // $minute = date('i' , strtotime($custom_deadline));  
      

        if(date("Y-m-d H:i:s") > date("Y-m-d H:i:s",strtotime($custom_deadline))) return true; 
        else return false; 

        
    }
    



   ?>

<?php if(isset($_GET['msg']) && !empty($_GET['msg']))  {
          echo' <div class="alert alert-'. $_GET['class'] .' alert-dismissible fade show m-3" role="alert">
                  <strong>Attention: </strong>'. $_GET['msg'] .' 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'; 
      }  
?>

<meta http-equiv="refresh" content="180" >

    <div class="m-3">
        <div class="card"   >
            <div class="card-body d-flex justify-content-between shadow">
                <h3 class="m-0 p-0">Task List </h3>
                <div>
                    <a href="Internal_follow_up_setting.php" class = "btn btn-primary" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                        </svg>
                        Setup
                    </a>
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
       

    

    <div class  = "m-3">
      <div class="card">
        <div class="card-body">
            <div class = "mb-2" >
                <a href = "index.php"  ><span class = "badge bg-info position-relative">Task List 
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> 5+  </span>
                </span></a>
                <a href = "FinishedGoods.php" onclick = "PutSearchTermToInputBox('Urgent')"><span class = "badge bg-danger  ">Finish Goods</span></a>
                <a href = "InternalFollowUp.php" onclick = "PutSearchTermToInputBox('')"><span class = "badge bg-dark  ">Job Process</span></a>
            </div>

            <table class ="table">
                <thead class="table-info">
                    <tr>
                        <th>#</th>   
                        <th>Job No</th>
                        <th>Company</th>
                        <th>Product</th>
                        <th>Order Qty</th>
                        <th>Status</th>
                        <th title = "Follow Up Count" > FUC</th>
                        <th>OPS</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $counter = 1 ; 
                    // echo $DataRows->num_rows ; 
                    if($DataRows->num_rows > 0 ) {

                        while ($Data = $DataRows->fetch_assoc()) {  



                           // $comment = ""; 
                            $follow_up_counter= 0 ;
                            $deadline = -1 ;  
                            $fol = $Controller->QueryData( "SELECT comment , deadline FROM follow_up where CTNId = ? AND customer_id = ?", [$Data['CTNId'] , $Data['CustId']]); 
                            if($fol->num_rows > 0 ) {
                                while ($follow_up = $fol->fetch_assoc())  {
                                    //$comment = $follow_up['comment'];
                                    $deadline = $follow_up['deadline'];
                                    $follow_up_counter++;  
                                }  
                                
                            }


                            if($deadline != -1 ) {
                                // echo 'must use the custom deadline' ;
                                if(!CustomApplySetting(   $deadline  )) continue;   
                                // var_dump(CustomApplySetting( $Data['job_arrival_time'] , $deadline  )); 

                            }
                            else {
                                // echo 'use default deadline from setting'; 
                                if(!ApplySetting($Data['job_arrival_time'], $Data['CTNStatus'] ,  $Internal )) continue;   
                            }

                            // if($Data['followed_up'] == 'Yes') continue; 
                            


                            // if(date("Y-m-d H:i:s") > date("Y-m-d H:i:s",strtotime($Data['job_arrival_time'])))  {
                            //     echo "check!"; 
                            // }
                            

                            // if( $Data['CTNStatus']  == 'Complete' || $Data['CTNStatus']  == 'Production' ) {
                                
                            // }
                             
                        ?> 

                        <tr>
                            <td> <?= sprintf('%02d', $counter++);   ?></td>
                            <td><?=$Data['JobNo']?></td>
                            <td><?=$Data['CustName']?></td>
                            <td><?=$Data['ProductName']?></td>
                            <td><?=$Data['CTNQTY']?></td>
                            <td><?=$Data['CTNStatus']?></td>
                            <td>
                                <span class = "badge bg-success" > followed <?=$follow_up_counter?> time   </span > 
                            </td>
                            <td>
                                <a  style = "text-decoration:none; " href="../Finance/JobCard.php?CTNId=<?=$Data['CTNId']?>&ListType=JobList" title="View Job Card">  
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="#20c997" xmlns="http://www.w3.org/2000/svg" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;">
                                        <path d="M1.68878 18.5713L6.42858 23.3111V18.5713H1.68878Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                                        <path d="M15.3725 10.0308H14.3265V11.592H15.3725C15.9031 11.592 16.3367 11.2399 16.3367 10.8114C16.3367 10.3828 15.9031 10.0308 15.3725 10.0308Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                                        <path d="M9.99489 11.5919C10.5105 11.5919 10.9286 10.6553 10.9286 9.50004C10.9286 8.34475 10.5105 7.4082 9.99489 7.4082C9.47924 7.4082 9.06122 8.34475 9.06122 9.50004C9.06122 10.6553 9.47924 11.5919 9.99489 11.5919Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                                        <path d="M15.3725 7.41309H14.3265V8.97431H15.3725C15.9031 8.97431 16.3367 8.62227 16.3367 8.1937C16.3367 7.76002 15.9031 7.41309 15.3725 7.41309Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                                        <path d="M0 0V17.1633H7.14286C7.52041 17.1633 7.83674 17.4796 7.83674 17.8571V25H25V0H0ZM6.68367 10.801C6.68367 11.8163 5.66327 12.6429 4.40816 12.6429C3.15306 12.6429 2.13265 11.8163 2.13265 10.801V10.7041C2.13265 10.4133 2.42347 10.1786 2.78061 10.1786C3.13776 10.1786 3.42857 10.4133 3.42857 10.7041V10.801C3.42857 11.2347 3.86735 11.5918 4.40306 11.5918C4.93878 11.5918 5.37755 11.2347 5.37755 10.801V6.88776C5.37755 6.59694 5.66837 6.36224 6.02551 6.36224C6.38265 6.36224 6.67347 6.59694 6.67347 6.88776V10.801H6.68367ZM9.9949 12.6429C8.7602 12.6429 7.7602 11.2347 7.7602 9.5C7.7602 7.76531 8.7602 6.35714 9.9949 6.35714C11.2296 6.35714 12.2296 7.76531 12.2296 9.5C12.2296 11.2347 11.2296 12.6429 9.9949 12.6429ZM17.6378 10.8112C17.6378 11.8214 16.6224 12.6429 15.3724 12.6429H13.6786C13.3214 12.6429 13.0306 12.4082 13.0306 12.1173V9.5051C13.0306 9.5051 13.0306 9.5051 13.0306 9.5C13.0306 9.5 13.0306 9.5 13.0306 9.4949V6.88776C13.0306 6.59694 13.3214 6.36224 13.6786 6.36224H15.3724C16.6224 6.36224 17.6378 7.18367 17.6378 8.19388C17.6378 8.70408 17.3776 9.16837 16.9541 9.5051C17.3776 9.83674 17.6378 10.301 17.6378 10.8112ZM20.6071 12.6429C19.9847 12.6429 19.3827 12.4337 18.9592 12.0663C18.7143 11.8571 18.7245 11.5204 18.9847 11.3214C19.2449 11.1224 19.6582 11.1327 19.9031 11.3418C20.0867 11.5 20.3367 11.5867 20.6071 11.5867C21.1378 11.5867 21.5714 11.2347 21.5714 10.8061C21.5714 10.3776 21.1378 10.0255 20.6071 10.0255C19.3571 10.0255 18.3418 9.20408 18.3418 8.18878C18.3418 7.17857 19.3571 6.35204 20.6071 6.35204C21.2296 6.35204 21.8316 6.56122 22.2551 6.92857C22.5 7.13776 22.4898 7.47449 22.2296 7.67347C21.9694 7.87245 21.5561 7.86225 21.3112 7.65306C21.1276 7.4949 20.8776 7.40816 20.6071 7.40816C20.0765 7.40816 19.6429 7.7602 19.6429 8.18878C19.6429 8.61735 20.0765 8.96939 20.6071 8.96939C21.8571 8.96939 22.8724 9.79082 22.8724 10.8061C22.8724 11.8214 21.852 12.6429 20.6071 12.6429Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                                    </svg>
                                </a>
                                <a href="follow_up.php?Extend=Yes&CTNId=<?=$Data['CTNId']?>"    class = "btn btn-sm btn-success"> Extend </a>
                                <a href="FollowUp.php?CustId=<?=$Data['CustId']?>&CTNId=<?=$Data['CTNId']?>&Product=<?=$Data['ProductName']?>" class = "btn btn-sm btn-outline-warning" > Followed Up</a>
                            </td>
                        </tr>
                        
                    <?php } } ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
 

<?php  require_once '../App/partials/Footer.inc'; ?>
