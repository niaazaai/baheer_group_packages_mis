<?php require_once '../App/partials/Header.inc';   require_once '../App/partials/Menu/MarketingMenu.inc';


date_default_timezone_set('Asia/Kabul');
 

// job arrived at finance department , track when the job arrived there if arrival time + deadline is greater then current time. 

    $Query = "SELECT CTNId , CustName , JobNo , CTNOrderDate , CTNFinishDate , ProductName  , CTNQTY   , CusProvince   , CTNStatus  , job_arrival_time , CTNStatus , followed_up 
        FROM carton
        INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
        WHERE JobNo != 'NULL' && CTNStatus != 'Completed' && CTNStatus != 'Postpond'   ";
    $DataRows = $Controller->QueryData($Query, []); 


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
    
    // var_dump(CheckJobTimouts($arrival_time , $day , $hr , $min)); 


 
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
        <div class="card " style = "background-color:# ;" >
            <div class="card-body d-flex justify-content-between shadow">
            <h3 class="m-0 p-0">Internal Follow Up Center</h3>
            <div><a href="" class = "btn btn-sm btn-primary" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                </svg>
                Refresh Rate</a>
            </div>
            </div>
        </div>
    </div>
 
    <?php $counter = 1 ; 

    echo $DataRows->num_rows ; 
    if($DataRows->num_rows > 0 ) {

    


    while ($Data = $DataRows->fetch_assoc()) {  
        if($Data['followed_up'] == 'Yes') continue; 
        if(!ApplySetting($Data['job_arrival_time'], $Data['CTNStatus'] ,  $Internal )) continue;   
    ?> 

    <div class="mb-1 mx-3">
        <div class="alert   d-flex justify-content-between align-items-center shadow" role="alert" style = "background-color:#333333;color:white;">
            <div class = "" >
                <div>
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-snow2" viewBox="0 0 16 16">
                        <path d="M8 16a.5.5 0 0 1-.5-.5v-1.293l-.646.647a.5.5 0 0 1-.707-.708L7.5 12.793v-1.086l-.646.647a.5.5 0 0 1-.707-.708L7.5 10.293V8.866l-1.236.713-.495 1.85a.5.5 0 1 1-.966-.26l.237-.882-.94.542-.496 1.85a.5.5 0 1 1-.966-.26l.237-.882-1.12.646a.5.5 0 0 1-.5-.866l1.12-.646-.884-.237a.5.5 0 1 1 .26-.966l1.848.495.94-.542-.882-.237a.5.5 0 1 1 .258-.966l1.85.495L7 8l-1.236-.713-1.849.495a.5.5 0 1 1-.258-.966l.883-.237-.94-.542-1.85.495a.5.5 0 0 1-.258-.966l.883-.237-1.12-.646a.5.5 0 1 1 .5-.866l1.12.646-.237-.883a.5.5 0 0 1 .966-.258l.495 1.849.94.542-.236-.883a.5.5 0 0 1 .966-.258l.495 1.849 1.236.713V5.707L6.147 4.354a.5.5 0 1 1 .707-.708l.646.647V3.207L6.147 1.854a.5.5 0 1 1 .707-.708l.646.647V.5a.5.5 0 0 1 1 0v1.293l.647-.647a.5.5 0 1 1 .707.708L8.5 3.207v1.086l.647-.647a.5.5 0 1 1 .707.708L8.5 5.707v1.427l1.236-.713.495-1.85a.5.5 0 1 1 .966.26l-.236.882.94-.542.495-1.85a.5.5 0 1 1 .966.26l-.236.882 1.12-.646a.5.5 0 0 1 .5.866l-1.12.646.883.237a.5.5 0 1 1-.26.966l-1.848-.495-.94.542.883.237a.5.5 0 1 1-.26.966l-1.848-.495L9 8l1.236.713 1.849-.495a.5.5 0 0 1 .259.966l-.883.237.94.542 1.849-.495a.5.5 0 0 1 .259.966l-.883.237 1.12.646a.5.5 0 0 1-.5.866l-1.12-.646.236.883a.5.5 0 1 1-.966.258l-.495-1.849-.94-.542.236.883a.5.5 0 0 1-.966.258L9.736 9.58 8.5 8.866v1.427l1.354 1.353a.5.5 0 0 1-.707.708l-.647-.647v1.086l1.354 1.353a.5.5 0 0 1-.707.708l-.647-.647V15.5a.5.5 0 0 1-.5.5z"/>
                    </svg>  -->
                    <span style = "font-size:20px;" class ="">
                        <?= sprintf('%02d', $counter++);   ?>
                    </span>
                    
                    <span  class= "ps-2" >
                        Job No <strong  >  <?=$Data['JobNo']?> </strong> with name of  <strong><?=$Data['ProductName']?> </strong>  
                        belongs to <strong><?=$Data['CustName']?> </strong>  Ordered at <strong>( <?=$Data['CTNOrderDate']?> ) </strong> Needs your follow up 
                    </span>
                </div>
            </div>
            <div>
                <a  style = "text-decoration:none; " href="../Finance/JobCard.php?CTNId=<?=$Data['CTNId']?>&ListType=JobList" title="View Job Card">  
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="#20c997" xmlns="http://www.w3.org/2000/svg" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;">
                        <path d="M1.68878 18.5713L6.42858 23.3111V18.5713H1.68878Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                        <path d="M15.3725 10.0308H14.3265V11.592H15.3725C15.9031 11.592 16.3367 11.2399 16.3367 10.8114C16.3367 10.3828 15.9031 10.0308 15.3725 10.0308Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                        <path d="M9.99489 11.5919C10.5105 11.5919 10.9286 10.6553 10.9286 9.50004C10.9286 8.34475 10.5105 7.4082 9.99489 7.4082C9.47924 7.4082 9.06122 8.34475 9.06122 9.50004C9.06122 10.6553 9.47924 11.5919 9.99489 11.5919Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                        <path d="M15.3725 7.41309H14.3265V8.97431H15.3725C15.9031 8.97431 16.3367 8.62227 16.3367 8.1937C16.3367 7.76002 15.9031 7.41309 15.3725 7.41309Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                        <path d="M0 0V17.1633H7.14286C7.52041 17.1633 7.83674 17.4796 7.83674 17.8571V25H25V0H0ZM6.68367 10.801C6.68367 11.8163 5.66327 12.6429 4.40816 12.6429C3.15306 12.6429 2.13265 11.8163 2.13265 10.801V10.7041C2.13265 10.4133 2.42347 10.1786 2.78061 10.1786C3.13776 10.1786 3.42857 10.4133 3.42857 10.7041V10.801C3.42857 11.2347 3.86735 11.5918 4.40306 11.5918C4.93878 11.5918 5.37755 11.2347 5.37755 10.801V6.88776C5.37755 6.59694 5.66837 6.36224 6.02551 6.36224C6.38265 6.36224 6.67347 6.59694 6.67347 6.88776V10.801H6.68367ZM9.9949 12.6429C8.7602 12.6429 7.7602 11.2347 7.7602 9.5C7.7602 7.76531 8.7602 6.35714 9.9949 6.35714C11.2296 6.35714 12.2296 7.76531 12.2296 9.5C12.2296 11.2347 11.2296 12.6429 9.9949 12.6429ZM17.6378 10.8112C17.6378 11.8214 16.6224 12.6429 15.3724 12.6429H13.6786C13.3214 12.6429 13.0306 12.4082 13.0306 12.1173V9.5051C13.0306 9.5051 13.0306 9.5051 13.0306 9.5C13.0306 9.5 13.0306 9.5 13.0306 9.4949V6.88776C13.0306 6.59694 13.3214 6.36224 13.6786 6.36224H15.3724C16.6224 6.36224 17.6378 7.18367 17.6378 8.19388C17.6378 8.70408 17.3776 9.16837 16.9541 9.5051C17.3776 9.83674 17.6378 10.301 17.6378 10.8112ZM20.6071 12.6429C19.9847 12.6429 19.3827 12.4337 18.9592 12.0663C18.7143 11.8571 18.7245 11.5204 18.9847 11.3214C19.2449 11.1224 19.6582 11.1327 19.9031 11.3418C20.0867 11.5 20.3367 11.5867 20.6071 11.5867C21.1378 11.5867 21.5714 11.2347 21.5714 10.8061C21.5714 10.3776 21.1378 10.0255 20.6071 10.0255C19.3571 10.0255 18.3418 9.20408 18.3418 8.18878C18.3418 7.17857 19.3571 6.35204 20.6071 6.35204C21.2296 6.35204 21.8316 6.56122 22.2551 6.92857C22.5 7.13776 22.4898 7.47449 22.2296 7.67347C21.9694 7.87245 21.5561 7.86225 21.3112 7.65306C21.1276 7.4949 20.8776 7.40816 20.6071 7.40816C20.0765 7.40816 19.6429 7.7602 19.6429 8.18878C19.6429 8.61735 20.0765 8.96939 20.6071 8.96939C21.8571 8.96939 22.8724 9.79082 22.8724 10.8061C22.8724 11.8214 21.852 12.6429 20.6071 12.6429Z" fill="#20c997" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#46e2b4;"></path>
                    </svg>
                </a>
                <a href="follow_up.php?Extend=Yes&CTNId=<?=$Data['CTNId']?>"  onclick = "return confirm('Are you sure you want extend follow up time')" class = "btn btn-sm btn-success"> Extend </a>
                <a href="follow_up.php?Follow=Yes&CTNId=<?=$Data['CTNId']?>" onclick = "return confirm('Are you sure')" class = "btn btn-sm btn-outline-warning" > Followed Up</a>
            </div>
        </div>
    </div>
    
    <?php } } ?>
<?php  require_once '../App/partials/Footer.inc'; ?>
