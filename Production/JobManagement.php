<?php 
ob_start(); 
require_once '../App/partials/Header.inc'; 
 
$Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
if(!in_array( $Gate['VIEW_JOB_MANAGEMENT_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
  header("Location:index.php?msg=You are not authorized to access this page!" );
}
require_once '../App/partials/Menu/MarketingMenu.inc'; 
require '../Assets/Carbon/autoload.php'; 
use Carbon\Carbon;


if(isset($_REQUEST['CTNId']) && !empty($_REQUEST['CTNId'])) {


    $CTNId=$_REQUEST['CTNId'];
    $DataRows=$Controller->QueryData("SELECT CTNId,CustId1,ppcustomer.CustName, CTNType,  JobNo,CTNOrderDate,CTNStatus,ProductQTY,
    JobType,CTNFinishDate,CTNQTY,CTNUnit,CTNColor, ProductName ,CTNStatus, carton.production_job_type, 
    CTNLength , CTNWidth ,CTNHeight,ProductQTY,designinfo.DesignImage, CFluteType 
    ,Ctnp1,Ctnp2,Ctnp3,Ctnp4,Ctnp5,Ctnp6,Ctnp7,CSlotted,CDieCut,CPasting ,CStitching,flexop ,offesetp, Note, ProductionPostpondComment
    FROM carton 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
    INNER JOIN designinfo ON designinfo.CaId=carton.CTNId  
    WHERE CTNId=?",[$CTNId]);

    if($DataRows->num_rows > 0) {  
        $Product=$DataRows->fetch_assoc();
    }
    else die('Somthing Went Wrong in Product:('); 

    $production_cycle = $Controller->QueryData('SELECT * FROM  production_cycle WHERE CTNId = ? ',[$CTNId]);
 
    $machine = [
        'C5P' => 'Carrogation 5 Ply', 
        'C3P' => 'Carrogation 3 Ply' , 
        'F1' => 'Flexo #1', 
        'F2' => 'Flexo #2', 
        'GF' => 'Glue Folder', 
        '4K' => '4 Khat',
    ]; 

    // SELECT ALL MACHINES FOR USER TO SELECT FOR EACH JOB CYCLE  
    $machine_db_list = $Controller->QueryData( 'SELECT * FROM machine  WHERE machine_type=? ',['Production']);

    // $machine_db_list = $Controller->QueryData('SELECT machine.* , used_machine.status as used_machine_status 
    // FROM `machine`  LEFT JOIN used_machine ON used_machine.machine_id = machine.machine_id  WHERE machine_type = "Production"',[]);

    
    # THIS BLOCK OF CODE IS FOR RETRIVING PAPER PRICE AND NAMES FOR PLYs TO SHOW  
    $PP =  $Controller->QueryData("SELECT DISTINCT Name,Price FROM paperprice" , [] );
    $PaperPrice = []; 
    while($PaperPriceDB = $PP->fetch_assoc()){
        $PaperPrice[$PaperPriceDB['Name']] = $PaperPriceDB['Price']  ;
    } // LOOP
    
    $SelectedPaperGSMArray = []; 
    $UP  = $Controller->QueryData('SELECT * FROM  used_paper WHERE carton_id = ?', [ $CTNId ] );
    if ($UP->num_rows > 0) {  
        $UsedPaper = $UP->fetch_assoc();

        for ($index=1; $index <= $Product['CTNType'] ; $index++) { 
            if(empty($UsedPaper['Ctnp'.$index])) {
                $SelectedPaperGSMArray['SPG_Layer_'.$index] = NULL; 
                continue; 
            }
            $SelectedPaperGSM  = $Controller->QueryData('SELECT PId, PGSM FROM `paperstock`  WHERE PId = ?', [ $UsedPaper['Ctnp'.$index] ] );
            $SPG = $SelectedPaperGSM->fetch_assoc();
            $SelectedPaperGSMArray['SPG_Layer_'.$index] = $SPG['PGSM'];
        }
    }
} else header('Location:index.php');
 
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
    
    .custom-font {
        font-size:12px;
    }
    .custom-font-lg  { 
        font-size:16px;
    }
</style>
 
<?php  if(isset($_GET['msg'])) {  ?>
    <div class="alert  alert-dismissible fade show m-3 alert-<?php if(isset($_GET['class'])) echo $_GET['class'];  ?>" role="alert">
        <strong>Message: </strong> <?=$_GET['msg']?>! 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<div class="card m-3 shadow">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 ">
                 <h5 class="m-1"> 
                    <a class="btn btn-outline-primary me-1" href="index.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16" data-darkreader-inline-fill="" style="--darkreader-inline-fill:currentColor;">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                        </svg>
                    </a>  Job Opreation Management</h5>
            </div> 
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 d-flex justify-content-end pt-2">
                <div class = "me-1 pt-1">
                    <?php 
                    if($Product['CTNStatus'] == 'Production' ) echo "<span class = 'badge bg-info'> The Job Is New</span>"; 
                        else if($Product['CTNStatus'] == 'Production Process' ) echo "<span class = 'badge bg-warning ' > Job Is Under Process </span>"; 
                        else if($Product['CTNStatus'] == 'Completed' ) echo "<span class = 'badge bg-success ' > The Job Has Been Completed</span>"; 
                        else if($Product['CTNStatus'] == 'Production Pending' ) echo "<span class = 'badge bg-danger'>The Job Has Been PostPonded </span>"; 
                        else if($Product['CTNStatus'] == 'Urgent' ) echo "<span class = 'badge bg-danger'>The Job is Urgent </span>"; 
                    ?>
                </div>

                <div class = "me-1">
                    <?php if( $Product['CTNStatus'] != 'Urgent') {   ?> 
                        <a class = "btn btn-outline-danger  btn-sm" title="Change Job to Urgent"  href="ChangeCartonStatusProduction.php?CTNId=<?=$CTNId?>&Production=Urgent&Redirect=UrgentJobs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                            </svg>
                        </a>
                    <?php }  ?> 
                </div>

                <div class = "me-1">
                    <?php if( $Product['CTNStatus'] != 'Completed') {   ?> 
                        <a href="ChangeCartonStatus.php?CTNId=<?=$CTNId?>" class="btn btn-outline-success btn-sm" onclick = "return confirm('آیا مطمین استید که جاب تکمیل شود؟'); ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi-clipboard2-check m-0 p-0" viewBox="0 0 16 16">
                                <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z"/>
                                <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z"/>
                                <path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3Z"/>
                            </svg>
                            Complete Job
                        </a> 
                    <?php }  ?> 
                </div>

                <!-- <div class = "me-1">
                    <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                        <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                        </svg>
                    </a>
                </div> -->

                <div class = "me-1">
                    <?php if($Product['CTNStatus'] != 'Urgent' ) {  ?>
                        <a  data-bs-toggle="modal" data-bs-target="#exampleModal-postpond" class="btn btn-outline-danger btn-sm" >
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24.6539 6.97687L18.0221 0.345298C17.801 0.124224 17.5014 0 17.1893 0H7.8103C7.49744 0 7.19782 0.124224 6.97675 0.345298L0.345292 6.97687C0.124222 7.19795 0 7.49757 0 7.81044V17.1896C0 17.5021 0.124222 17.8017 0.345292 18.0228L6.97709 24.6547C7.19777 24.8758 7.49778 25 7.81064 25H17.1897C17.5018 25 17.8014 24.8762 18.0225 24.6551L24.6547 18.0232C24.8754 17.8021 25 17.5025 25 17.1896V7.81044C24.9992 7.49757 24.875 7.19795 24.6539 6.97687Z" fill="#CC092E"></path>
                                <path d="M3.31124 4.01074L0.345292 6.97635C0.124222 7.19742 0 7.49705 0 7.80991V17.1891C0 17.5016 0.124222 17.8012 0.345292 18.0223L6.97709 24.6542C7.19777 24.8753 7.49778 24.9995 7.81064 24.9995H17.1897C17.5018 24.9995 17.8014 24.8756 18.0225 24.6546L20.9884 21.6886L3.31124 4.01074Z" fill="#E81542"></path>
                                <path d="M4.28229 12.2558C3.49481 11.9515 3.25539 11.7328 3.25539 11.3207C3.25539 11.0105 3.48975 10.648 4.15108 10.648C4.60264 10.648 4.94753 10.7848 5.15809 10.8992C5.20847 10.9265 5.26862 10.9308 5.32213 10.9098C5.37643 10.8887 5.41824 10.8449 5.43658 10.7903L5.64243 10.1801C5.67288 10.0914 5.63539 9.99379 5.55376 9.94767C5.35025 9.83242 4.90067 9.63867 4.17686 9.63867C2.95855 9.63867 2.10779 10.3656 2.10779 11.407C2.10779 12.2394 2.65114 12.8367 3.76244 13.2308C4.571 13.5413 4.72919 13.8214 4.72919 14.1999C4.72919 14.6964 4.34914 14.9929 3.7128 14.9929C3.29248 14.9929 2.82922 14.8624 2.47376 14.6437C2.42338 14.612 2.35931 14.6058 2.30228 14.6273C2.24565 14.6487 2.20231 14.6953 2.1847 14.7534L1.99567 15.3807C1.97147 15.4632 2.00271 15.5518 2.07417 15.5999C2.42963 15.8366 3.08272 16.0022 3.66083 16.0022C5.19751 16.0022 5.88458 15.0667 5.88458 14.1393C5.88497 13.2535 5.40529 12.6898 4.28229 12.2558Z" fill="#B2042E"></path>
                                <path d="M11.1981 9.7334H6.90915C6.80174 9.7334 6.71387 9.82088 6.71387 9.92868V10.5646C6.71387 10.6724 6.80174 10.7599 6.90915 10.7599H8.47628V15.7216C8.47628 15.8294 8.56341 15.9169 8.67156 15.9169H9.4278C9.53601 15.9169 9.62308 15.8294 9.62308 15.7216V10.76H11.1984C11.3066 10.76 11.3937 10.6725 11.3937 10.5647V9.92873C11.3934 9.82093 11.3063 9.7334 11.1981 9.7334Z" fill="#B2042E"></path>
                                <path d="M14.8159 9.63867C13.1168 9.63867 11.9305 10.9703 11.9305 12.8765C11.9305 14.7222 13.0816 16.0112 14.7296 16.0112C16.1663 16.0112 17.6151 15.0073 17.6151 12.7648C17.6151 10.8949 16.4905 9.63867 14.8159 9.63867ZM14.773 15.0105C13.6378 15.0105 13.1207 13.8956 13.1207 12.8593C13.1207 11.7542 13.6339 10.6394 14.7816 10.6394C15.9167 10.6394 16.4339 11.7589 16.4339 12.7992C16.4339 13.8995 15.9206 15.0105 14.773 15.0105Z" fill="#B2042E"></path>
                                <path d="M22.4395 10.2217C22.0481 9.86895 21.4575 9.69043 20.6849 9.69043C20.1592 9.69043 19.6795 9.72792 19.217 9.80449C19.1233 9.82011 19.0537 9.90173 19.0537 9.99705V15.7212C19.0537 15.829 19.1416 15.9165 19.249 15.9165H19.9974C20.1048 15.9165 20.1927 15.829 20.1927 15.7212V13.631C20.3263 13.6447 20.4641 13.6474 20.5985 13.6474C21.4102 13.6474 22.0891 13.3997 22.509 12.9525C22.8426 12.6095 23.0117 12.147 23.0117 11.5787C23.0117 11.0225 22.8075 10.5397 22.4395 10.2217ZM20.6161 12.6556C20.4482 12.6556 20.3079 12.6475 20.1927 12.631V10.7018C20.3118 10.6862 20.4825 10.6745 20.7017 10.6745C21.2364 10.6745 21.8735 10.8374 21.8735 11.6135C21.8735 12.5201 21.0852 12.6556 20.6161 12.6556Z" fill="#B2042E"></path>
                                <path d="M4.28229 11.9306C3.49481 11.6263 3.25539 11.4076 3.25539 10.9955C3.25539 10.6853 3.48975 10.3228 4.15108 10.3228C4.60264 10.3228 4.94753 10.4596 5.15809 10.574C5.20847 10.6013 5.26862 10.6057 5.32213 10.5846C5.37643 10.5635 5.41824 10.5197 5.43658 10.4651L5.64243 9.8549C5.67288 9.76624 5.63539 9.66859 5.55376 9.62247C5.35025 9.50723 4.90067 9.31348 4.17686 9.31348C2.95855 9.31348 2.10779 10.0404 2.10779 11.0818C2.10779 11.9142 2.65114 12.5115 3.76244 12.9056C4.571 13.2161 4.72919 13.4962 4.72919 13.8748C4.72919 14.3712 4.34914 14.6677 3.7128 14.6677C3.29248 14.6677 2.82922 14.5372 2.47376 14.3185C2.42338 14.2868 2.35931 14.2806 2.30228 14.3021C2.24604 14.3239 2.20265 14.3708 2.1851 14.4286L1.99606 15.0559C1.97186 15.1384 2.00311 15.227 2.07456 15.2751C2.43002 15.5118 3.08312 15.6774 3.66123 15.6774C5.19791 15.6774 5.88497 14.7419 5.88497 13.8145C5.88497 12.9282 5.40529 12.3646 4.28229 11.9306Z" fill="white"></path>
                                <path d="M11.1981 9.4082H6.90915C6.80174 9.4082 6.71387 9.49568 6.71387 9.60349V10.2394C6.71387 10.3472 6.80174 10.4347 6.90915 10.4347H8.47628V15.3964C8.47628 15.5042 8.56341 15.5917 8.67156 15.5917H9.4278C9.53601 15.5917 9.62308 15.5042 9.62308 15.3964V10.4347H11.1984C11.3066 10.4347 11.3937 10.3472 11.3937 10.2394V9.60349C11.3934 9.49568 11.3063 9.4082 11.1981 9.4082Z" fill="#E0E0E0"></path>
                                <path d="M8.70751 9.4082H6.90915C6.80174 9.4082 6.71387 9.49568 6.71387 9.60349V10.2394C6.71387 10.3472 6.80174 10.4347 6.90915 10.4347H8.47628V15.3964C8.47628 15.5042 8.56341 15.5917 8.67156 15.5917H9.4278C9.53601 15.5917 9.62308 15.5042 9.62308 15.3964V10.4347H9.73441L8.70751 9.4082Z" fill="white"></path>
                                <path d="M14.8159 9.31348C13.1168 9.31348 11.9305 10.6451 11.9305 12.5513C11.9305 14.397 13.0816 15.686 14.7296 15.686C16.1663 15.686 17.6151 14.6821 17.6151 12.4396C17.6151 10.5697 16.4905 9.31348 14.8159 9.31348ZM14.773 14.6853C13.6378 14.6853 13.1207 13.5705 13.1207 12.5342C13.1207 11.4291 13.6339 10.3143 14.7816 10.3143C15.9167 10.3143 16.4339 11.4338 16.4339 12.474C16.4339 13.5744 15.9206 14.6853 14.773 14.6853Z" fill="#E0E0E0"></path>
                                <path d="M11.9336 12.6338C11.968 14.4346 13.107 15.6857 14.7296 15.6857C14.8113 15.6857 14.8937 15.6814 14.9746 15.6751L11.9336 12.6338Z" fill="white"></path>
                                <path d="M22.4395 9.8965C22.0481 9.54376 21.4575 9.36523 20.6849 9.36523C20.1592 9.36523 19.6795 9.40272 19.217 9.47929C19.1233 9.49491 19.0537 9.57654 19.0537 9.67185V15.396C19.0537 15.5038 19.1416 15.5913 19.249 15.5913H19.9974C20.1048 15.5913 20.1927 15.5038 20.1927 15.396V13.3058C20.3263 13.3195 20.4641 13.3222 20.5985 13.3222C21.4102 13.3222 22.0891 13.0745 22.509 12.6273C22.8426 12.2843 23.0117 11.8218 23.0117 11.2535C23.0117 10.6973 22.8075 10.2145 22.4395 9.8965ZM20.6161 12.3304C20.4482 12.3304 20.3079 12.3223 20.1927 12.3058V10.3766C20.3118 10.361 20.4825 10.3493 20.7017 10.3493C21.2364 10.3493 21.8735 10.5122 21.8735 11.2883C21.8735 12.1949 21.0852 12.3304 20.6161 12.3304Z" fill="#E0E0E0"></path>
                            </svg> 
                        </a>
                    <?php }  ?> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card m-3 shadow">
    <div class="card-body">

    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" >   Customer Info  </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col"  >
                    <div class ="text-secondary" >Job No: </div>
                    <div class =""><?=$Product['JobNo'];?></div>
                </th>
                <th scope="col" >
                    <div  class ="text-secondary">Company:</div>
                    <div><?=$Product['CustName'];?></div>
                </th>
                <th scope="col">
                    <div  class ="text-secondary">Product:</div>
                    <div><?=$Product['ProductName'];?></div>
                </th>

                <th scope="col">
                    <div  class ="text-secondary">Order Qty:</div>
                    <div id = "OrderQty"><?=number_format($Product['CTNQTY'] );?></div>
                </th>
                <th scope="col">
                    <div  class ="text-secondary">Order Date:</div>
                    <div>
                        <?php 
                            $a =  Carbon::createFromTimeStamp(strtotime( $Product['CTNOrderDate']),'Asia/Kabul')->diffForHumans();
                            echo "<span class = 'badge bg-dark' style = 'font-size:11px;' >{$a}</span>";
                        ?>
                    </div>
                </th>
                <th scope="col">
                    <div  class ="text-secondary">Deadline:</div>
                    <div>
                        <?php  $a =  Carbon::createFromTimeStamp(strtotime($Product['CTNFinishDate']),'Asia/Kabul')->diffForHumans();
                            echo "<span class = 'badge bg-dark' style = 'font-size:11px;' >{$a}</span>";
                        ?>
                    </div>
                </th>
            </tr>
        </tbody>
    </table>
    
    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" >   Product Info  <span class = "bg-danger  text-white" style = "padding:2px; "> <?=$Product['CTNType'];?> Ply </span>   (mm) </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <th scope="col"  >
                    <div class ="text-secondary" >L: </div>
                    <div class =""><?=$Product['CTNLength'];?></div>
                </th>
                <th scope="col" >
                    <div class ="text-secondary" >W:</div>
                    <div id = "Width"  ><?=$Product['CTNWidth'];?></div>
                </th>
                <th scope="col">
                    <div class ="text-secondary" >H:</div>
                    <div id = "Height" ><?=$Product['CTNHeight'];?></div>
                </th>
                <th scope="col"  style = "width:170px;"  >
                    <form action="ChangeProductionJobType.php" method="post">
                        <input type="hidden" name="CTNId" value = "<?=$Product['CTNId']?>">
                        <div class="form-floating"  >
                            <select  class="form-select form-select-sm" name="production_job_type" id="production_job_type"  onchange = "this.form.submit()" style = "max-width:150px;" >
                                <option  value = "<?=(isset($Product['production_job_type'])) ? $Product['production_job_type'] : '';?> "   > 
                                    <?=(isset($Product['production_job_type'])) ? $Product['production_job_type'] : '';?>
                                </option>
                                <option value="Offset 1 Piece">Offset 1 Piece</option>
                                <option value="Offset 2 Piece">Offset 2 Piece</option>
                                <option value="Flexo 1 Piece">Flexo 1 Piece</option>
                                <option value="Flexo 2 Piece">Flexo 2 Piece</option>
                                <option value="Normal">Normal</option>
                            </select>
                            <label for="floatingSelect">Job Type</label>
                        </div>
                    </form>
                </th>

                <?php 
                    // if the job is offset 2 piece meaning that the total width must be calculated like this ; 
                    // offset 1 peice : 
                    // total width = ( CTNWidth +  CTNHeight  + 2.5)
                    // total Length  = (CTNLength + CTNWidth) * 2 + 3 

                    // offset 2 peice : 
                    // total width = ( CTNWidth +  CTNHeight  + 2.5)
                    // total Length  = (CTNLength + CTNWidth) + 3 

                    // FLEXO 1 PEICE : 
                    // total width = ( CTNWidth +  CTNHeight ) // just remove the 2.5 
                    // total Length  = (CTNLength + CTNWidth) * 2 + 3 

                    // FLEXO 2 PEICE : 
                    // total width = ( CTNWidth +  CTNHeight )
                    // total Length  = (CTNLength + CTNWidth) + 3

                    $total_width = 0 ; 
                    $total_length = 0 ; 

                    if( isset($Product['production_job_type']) ) {
                        // TOTAL WIDTH BETWEEN  flexo_1p - flexo_2p - AND Default which is normal is the same 
                        $total_width = $Product['CTNWidth'] + $Product['CTNHeight'] ; 
                        switch ($Product['production_job_type']) {
                            case 'Offset 1 Piece':
                                $total_width = $Product['CTNWidth'] + $Product['CTNHeight'] + 2.5; 
                                $total_length = ($Product['CTNLength'] + $Product['CTNWidth']) * 2  + 3; 
                                break;
                            case 'Offset 2 Piece':
                                $total_width = $Product['CTNWidth'] + $Product['CTNHeight'] + 2.5; 
                                $total_length = ($Product['CTNLength'] + $Product['CTNWidth']) + 3; 
                                break;
                            case 'Flexo 1 Piece':
                                $total_length = ($Product['CTNLength'] + $Product['CTNWidth']) * 2 + 3; 
                                break;
                            case 'Flexo 2 Piece':
                                $total_length = ($Product['CTNLength'] + $Product['CTNWidth']) + 3; 
                                break;
                            default:
                                $total_length = ($Product['CTNLength'] + $Product['CTNWidth']) * 2 +3 ; 
                                break;
                        }
                    } // END OF IF 
                ?>

                <th scope="col">
                    <div class ="text-secondary"  >Total Length:</div>
                    <div id = "TotalLength" ><?=$total_length?></div>
                </th>

                <th scope="col">
                    <div class ="text-secondary"  >Total Width:</div>
                    <div id = "TotalWidth"><?=$total_width;?></div>
                </th>

                <th scope="col">
                    <div class ="text-secondary">Paper Type:</div>
                    <div> ( <?php
                                $arr = []; 
                                for ($index=1; $index <= 7 ; $index++) { 
                                    if(empty($Product['Ctnp'.$index])) continue; 
                                    $arr[] = $Product['Ctnp'.$index];   
                                } 
                                $arr = array_count_values($arr);
                                foreach ($arr as $key => $value) {
                                    if(trim($key) === 'Flute') echo $value . " " . $key ;
                                    else  echo $key ; 
                                    if ($key === array_key_last($arr)) continue ; 
                                    echo " x ";
                                }  
                            ?> ) 
                    </div>
                </th>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered custom-font " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1" >   Printing Info  </th>
            </tr>
        </thead>
        <tbody>
            <tr class ="text-center" >
                <?php if($Product['CDieCut'] == 'Yes'):?>
                    <th scope="col"  >
                        <div class ="text-secondary" >Die Cut </div>
                        <div class =""><?=$Product['CDieCut'];?></div>
                    </th>
                <?php endif;?>

                <?php if($Product['CSlotted'] == 'Yes'):?>
                    <th scope="col"  >
                        <div class ="text-secondary" >Slotted </div>
                        <div class =""><?=$Product['CSlotted'];?></div>
                    </th>
                <?php endif;?>

                <?php if($Product['CPasting'] == 'Yes'):?>
                    <th scope="col"  >
                        <div class ="text-secondary" >Pasting </div>
                        <div class =""><?=$Product['CPasting'];?></div>
                    </th>
                <?php endif;?>

                <?php if($Product['CStitching'] == 'Yes'):?>
                    <th scope="col"  >
                        <div class ="text-secondary" >Stiteching </div>
                        <div class =""><?=$Product['CStitching'];?></div>
                    </th>
                <?php endif;?>

                <?php if($Product['flexop'] == 'Yes'):?>
                    <th scope="col"  >
                        <div class ="text-secondary" >Flexo Print</div>
                        <div class =""><?=$Product['flexop'];?></div>
                    </th>
                <?php endif;?>

                <?php if($Product['offesetp'] == 'Yes'):?>
                    <th scope="col"  >
                        <div class ="text-secondary" >Offset Print</div>
                        <div class =""><?=$Product['offesetp'];?></div>
                    </th>
                <?php endif;?>
                
                <th scope="col"  >
                    <div class ="text-secondary" >Color </div>
                    <div class =""><?=$Product['CTNColor'];?></div>
                </th>

                <th scope="col"  >
                    <div class ="text-secondary" >Flute Type </div>
                    <div class =""><?=$Product['CFluteType'];?></div>
                </th>
            </tr>
        </tbody>
    </table>


    <form action="StorePaperDetails.php" id = "" method = "post" >
    <input type="hidden" name="CTNId" value= "<?=$_REQUEST['CTNId'];?>" >

    <table class="table table-bordered" >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th scope="col" colspan=6 class ="py-1 custom-font" >Plan Info</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style = "width:180px;">
                    <div class="form-floating"  >
                        <select class="form-select form-select-sm" name="Ups" id="Ups" onchange = "ReelWastUps()" aria-label=""   >
                            <option selected value = "<?=(isset($UsedPaper['ups'])) ? $UsedPaper['ups'] : '';?> " selected > <?=(isset($UsedPaper['ups'])) ? $UsedPaper['ups'] : '';?></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <label for="floatingSelect">Machine Apps</label>
                    </div>
                </td>
               
                <td>
                    <div class="form-floating ">
                        <input type="number" class="form-control "  placeholder  = "Wast (cm)" onchange = "ReelWastUps()" value = "<?=(isset($UsedPaper['wast'])) ? $UsedPaper['wast'] : '';?>"   id="Wast" name="Wast"   required>
                        <label for="Wast">Wast (cm)</label>
                    </div>
                </td>
                
                <td>
                    <div class="form-floating ">
                        <input type="text" class="form-control "  placeholder  = "Reel" id="Reel" name="Reel"  value = "<?=(isset($UsedPaper['reel'])) ? $UsedPaper['reel'] : '';?>"  required>
                        <label for="Reel">Reel</label>
                    </div>
                </td>

                <td>
                    <div class="form-floating ">
                        <input type="text" class="form-control"  placeholder = "Creesing (mm)" id="Creesing" name="Creesing" value = "<?=(isset($UsedPaper['creesing'])) ? $UsedPaper['creesing'] : '';?>" required>
                        <label for="Creasing"> Creasing (mm) </label>
                    </div>
                </td>
              
                <td class ="d-flex justify-content-center " >
                    <button type = 'submit' class = "btn btn-outline-primary mt-2" > Apply </button>
                </td>
            </tr>
        </tbody>
    </table>
    </form>
    <table class="table table-bordered " >
        <thead style = "border-bottom:2px solid black;">
            <tr>
                <th>
                    <div class = "d-flex justify-content-between m-0 p-0">
                        <span class ="py-1">Paper Info </span>
                        <span class =" "> 
                            <!-- btn btn-outline-primary m-0  -->
                            <a type="button" class="" href="AvailablePaperStock.php?CTNId=<?=$CTNId;?>" >
                                <svg  width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.318 197.318"  xml:space="preserve">
                                    <path d="M106.802,197.318c-26.703,0-50.729-11.678-67.241-30.195c-3.053-1.714-31.036-18.512-37.839-61.192
                                        c-3.411-21.395-0.03-44.138,9.52-64.039C20.728,22.118,35.214,7.297,52.029,0.159c1.019-0.431,2.191,0.043,2.623,1.059
                                        c0.432,1.017-0.042,2.191-1.059,2.623C20.49,17.894-1.007,63.408,5.671,105.301c3.964,24.868,15.631,40.645,24.622,49.451
                                        c-8.606-13.804-13.582-30.094-13.582-47.524c0-49.676,40.414-90.09,90.09-90.09s90.09,40.414,90.09,90.09
                                        S156.477,197.318,106.802,197.318z M106.802,21.138c-47.47,0-86.09,38.62-86.09,86.09s38.62,86.09,86.09,86.09
                                        c47.47,0,86.09-38.62,86.09-86.09S154.271,21.138,106.802,21.138z M106.802,182.281c-7.631,0-14.449-3.548-18.891-9.08
                                        c-0.068-0.073-0.13-0.152-0.186-0.234c-3.22-4.112-5.141-9.288-5.141-14.903c0-13.354,10.864-24.218,24.218-24.218
                                        s24.218,10.864,24.218,24.218c0,5.606-1.915,10.774-5.125,14.882c-0.063,0.097-0.136,0.189-0.217,0.274
                                        C121.235,178.742,114.424,182.281,106.802,182.281z M96.163,175.25c3.092,1.922,6.739,3.032,10.639,3.032
                                        c3.086,0,6.012-0.695,8.631-1.936c-1.949,0.285-4.105,0.452-6.395,0.387C104.844,176.614,100.03,175.929,96.163,175.25z
                                        M90.533,170.054c2.56,0.567,11.666,2.484,18.619,2.681c6.701,0.175,12.249-1.878,13.798-2.518c0.822-1.09,1.538-2.267,2.129-3.512
                                        c-5.897,1.812-12.028,2.728-18.276,2.728s-12.379-0.917-18.276-2.728C89.087,167.888,89.761,169.01,90.533,170.054z M86.962,161.965
                                        c6.347,2.302,13.019,3.468,19.84,3.468c6.822,0,13.492-1.167,19.84-3.468c0.248-1.263,0.378-2.567,0.378-3.901
                                        c0-11.148-9.069-20.218-20.218-20.218c-11.148,0-20.218,9.07-20.218,20.218C86.584,159.398,86.714,160.702,86.962,161.965z
                                        M157.638,131.446c-13.354,0-24.219-10.864-24.219-24.218s10.864-24.218,24.219-24.218c13.354,0,24.218,10.864,24.218,24.218
                                        S170.991,131.446,157.638,131.446z M157.638,87.01c-11.148,0-20.219,9.07-20.219,20.218s9.07,20.218,20.219,20.218
                                        c1.334,0,2.639-0.13,3.901-0.378c2.302-6.348,3.468-13.018,3.468-19.84c0-6.821-1.167-13.492-3.468-19.84
                                        C160.276,87.14,158.972,87.01,157.638,87.01z M166.278,88.951c1.813,5.898,2.729,12.029,2.729,18.277s-0.916,12.379-2.728,18.277
                                        c6.837-3.246,11.576-10.219,11.576-18.277S173.116,92.197,166.278,88.951z M55.966,131.446c-13.354,0-24.218-10.864-24.218-24.218
                                        S42.613,83.01,55.966,83.01s24.218,10.864,24.218,24.218S69.32,131.446,55.966,131.446z M52.065,127.068
                                        c1.263,0.248,2.567,0.378,3.901,0.378c11.148,0,20.218-9.07,20.218-20.218S67.114,87.01,55.966,87.01
                                        c-1.334,0-2.639,0.13-3.901,0.378c-2.302,6.347-3.468,13.02-3.468,19.84C48.597,114.05,49.763,120.721,52.065,127.068z
                                        M47.325,88.952c-6.837,3.246-11.576,10.218-11.576,18.276s4.739,15.031,11.576,18.276c-1.812-5.897-2.728-12.028-2.728-18.276
                                        C44.597,100.981,45.513,94.85,47.325,88.952z M106.802,113.823c-3.637,0-6.595-2.958-6.595-6.595s2.958-6.595,6.595-6.595
                                        s6.595,2.958,6.595,6.595S110.438,113.823,106.802,113.823z M106.802,104.633c-1.431,0-2.595,1.164-2.595,2.595
                                        s1.164,2.595,2.595,2.595s2.595-1.164,2.595-2.595S108.232,104.633,106.802,104.633z M106.802,80.61
                                        c-13.354,0-24.218-10.864-24.218-24.218s10.864-24.218,24.218-24.218s24.218,10.864,24.218,24.218S120.155,80.61,106.802,80.61z
                                        M86.962,52.491c-0.248,1.263-0.378,2.567-0.378,3.902c0,11.148,9.07,20.218,20.218,20.218c11.148,0,20.218-9.07,20.218-20.218
                                        c0-1.334-0.13-2.639-0.378-3.902c-6.348-2.301-13.017-3.468-19.84-3.468C99.979,49.023,93.309,50.19,86.962,52.491z M106.802,36.175
                                        c-8.059,0-15.031,4.739-18.276,11.576c5.897-1.812,12.028-2.728,18.276-2.728c6.249,0,12.379,0.917,18.276,2.728
                                        C121.832,40.914,114.86,36.175,106.802,36.175z" fill= "#33D14D">
                                    </path>
                                </svg>
                            </a>
                        </span>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                <div class="row mb-3">
                    <!--   PaperLayerName with it is GSM  -->
                        <?php for ($index=1; $index <= $Product['CTNType']; $index++):   ?>
                            <div class=" col-xxl-1 col-xl-1 col-lg-1 col-md-3 col-sm-6 col-xs-4">
                                
                                <select class="form-select form-select-sm "  name="PaperLayerPrice_<?=$index?>" id="PaperLayerPrice_<?=$index?>" style="display: none ;" readonly    >
                                    <option selected value='<?=$Product['PaperP'.$index]?>'>L<?=$index?>- <?=$Product['Ctnp'.$index]; ?></option>
                                    <?php foreach ($PaperPrice as $key => $value)   echo "<option value='$value'>L$index- $key</option>";  ?>
                                </select>  
                                
                                <input type="text"  id="" readonly class = "form-control form-control-sm " value = "L<?=$index?>- <?=$Product['Ctnp'.$index]; ?>"  id="PaperLayerPrice_<?=$index?>"  >
                                
                                <!-- the filed means Paper Selection Paper Name PSPN -->
                                <input class="form-control form-control-sm mt-2" readonly type="text" value = "<?=(isset($UsedPaper['PSPN_'.$index])) ? "L" . $index . "- " . $UsedPaper['PSPN_'.$index]  : '';  ?>"  />
                                <input class="form-control form-control-sm mt-2" name="ReelSizeWithCountry_<?=$index?>"  id="ReelSizeWithCountry_<?=$index?>" readonly type="text" value = "<?=(isset($UsedPaper['RSC_'.$index])) ? $UsedPaper['RSC_'.$index]  : '';  ?>"  />
                                <input class="form-control form-control-sm mt-2"  name="PaperLayerWeight_<?=$index?>" id="PaperLayerWeight_<?=$index?>" readonly  type="text" />
                                <input class="form-control form-control-sm mt-2" name="Paper_GSM_Layer_<?=$index?>" id="Paper_GSM_Layer_<?=$index?>" readonly type="hidden" value = "<?= isset($SelectedPaperGSMArray['SPG_Layer_'.$index]) ? $SelectedPaperGSMArray['SPG_Layer_'.$index] : '';?>"  />

                            </div> 
                        <?php endfor; ?>

                        <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-6 col-xs-4" >
                            <input type="text" class="form-control form-control-sm" value = "👈  Marketing selection" readonly />
                            <input type="text" class="form-control form-control-sm mt-2" value = "👈 Production selection" readonly />  
                            <input class="form-control form-control-sm mt-2"  value = "Country - Reel Size" readonly type="text" />  
                            <input class="form-control  form-control-sm mt-2"  id = "paper_weight_total" readonly type="text" />
                             
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
 
    <table class="table table-bordered  "  >
        <thead style = "border-bottom:2px solid black;" >
            <tr> 
                <th  scope="col" colspan=8 class ="py-1 "  > 
                    <div class = "d-flex justify-content-between m-0 p-0">
                        <span class ="py-2">
                            
                        <a class="btn btn-outline-warning btn-sm p-1" data-bs-toggle="collapse" href="#multiCollapseExample1"  role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                            </a>  Machine Info</span>
                        <span class ="py-1">
                            <a href="CreateCycle.php?CTNId=<?=$CTNId?>" class="btn btn-outline-success btn-sm " onclick = "return confirm('آیا مطمین استید برای ایجاد  دوره جدید تولیدی برای جاب مربوطه ')" >
                                <svg style = "transform:rotate(30deg);"  xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="p-0 m-0" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg>
                                New Cycle
                            </a> 
                            <div class="collapse multi-collapse " style = "width:500px;" id="multiCollapseExample1">
                                <div class="card card-body">
                                    <ul class="list-group">
                                        <?php   foreach ($machine as $key => $value) { ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?=$value?>
                                                <span class="badge bg-primary rounded-pill"><?=$key?></span>
                                            </li>
                                        <?php  }?>
                                    </ul>
                                </div>
                            </div>

                        </span>
                    </div>
                </th> 
            </tr>
        </thead>
        <tbody class= "custom-font"   >
            <tr class ="" >
                <th scope="col" class ="text-secondary"> Cycle</th>
                <th scope="col" class ="text-secondary"> Machines</th>
                <th scope="col" class ="text-secondary"> Cycle Status</th>
                <th scope="col" class ="text-secondary"> Plan Qty</th>
                <th scope="col" class ="text-secondary"> Cut Qty (cm)</th>
                <th scope="col" class ="text-secondary"> Produced Qty</th>
                <th scope="col" class ="text-secondary"> Flute Type</th>
                <th scope="col" class ="text-secondary"> OPS</th>
            </tr>
 
        <?php 
            $i = 65;
            $isComplete = false; 

            if ($production_cycle->num_rows > 0) {  
                while($cycle = $production_cycle->fetch_assoc()) {

                    $machine_td = ''; 

                    // get all machines for each cycle 
                    $job_cycle  = $Controller->QueryData('SELECT *  FROM  production_cycle 
                    LEFT JOIN used_machine ON production_cycle.cycle_id = used_machine.cycle_id 
                    LEFT JOIN machine ON used_machine.machine_id = machine.machine_id 
                    WHERE production_cycle.cycle_id = ? && production_cycle.CTNId= ?',[$cycle['cycle_id'] , $CTNId ]);
                    
                    // THIS BLOCK WILL SHOW US SELECTED MACHINES  // if the cycle is not complete show machines 
                    if($cycle['cycle_status'] == 'Incomplete' || $cycle['cycle_status'] == 'Task List' )  {  
                        $machine_td .=  "<div class='wrap'><div class='links'>"; 
                        while($job = $job_cycle->fetch_assoc()  ) {

                            if($job['status'] == 'Complete') $complete_style = 'background-color:#1CD6CE'; 
                            else {$complete_style = '';  $isComplete = true;  } 
                            
            
                            if(empty( $job['machine_name'])) continue; 

                            // echo $job['machine_name'] . ' - ' . $job['status']; 

                            // echo $job['produced_qty']; '-'. $job['produced_qty'] .
                            if(!array_search( $job['machine_name'] , $machine )) continue; 
                            $machine_td .= "<div class='dot dot-hover selected_cycle_machine_". $cycle['cycle_id'] ." ' style = '". $complete_style ."'>" . array_search( $job['machine_name'] , $machine ) . "</div>"; 
                            
                        } // END OF WHILE 
                        $machine_td .= "</div></div>"; 
                    }  // end of if 
                    else $machine_td .= "
                    <span class = 'badge bg-success px-3 py-1 '> Cycle Completed </span> 
                    <a href = 'EditCartonProduction.php?CTNId=".$CTNId."&CYCLE_ID=".$cycle['cycle_id']."' > 
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' style = 'margin-left:5px; ' fill='currentColor'  viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                        </svg>
                    </a>"; 
        ?>

            <tr class ="" >
                <th scope="col">  <?php echo chr($i); $i++; ?> <?php // echo $cycle['cycle_id'] ?>  </th>
                <th scope="col" class = "custom-font-lg text-center">  <?=$machine_td ?>   </th>
                <th scope="col" class = "pt-3" > 
                    <?php 
                        echo ($cycle['cycle_status'] == 'Completed') ? '<span style = "background-color:#198754; padding:2px; color:white;">Completed</span>': '<span class ="  " style = "background-color:#d63384; padding:2px; color:white; ">Cycle is Incomplete</span>' ; 
                        $a =  Carbon::create($cycle['cycle_date'] , 'Asia/Kabul')->diffForHumans(); 
                        echo "<span class = '  ms-1' style = 'background-color:#6f42c1; padding:2px; color:white;'  > Created " . $a . "</span>";
                        
                        // show if the cycle has manual machines 
                        if($cycle['has_manual'] == 'Yes') 
                        echo '<span style = "background-color:#fd7e14; padding:2px; margin:4px;  color:white;"  class = "fw-bold" title = "has manual" >
                          Manual  </span>'; 

                        if($cycle['cycle_status'] == 'Task List') {
                            echo '<span class = "ms-1"  style = "background-color:#227C70; padding:2px; color:white;">In Task List</span>'; 
                        }

                        if($cycle['cycle_status'] == 'Finish List') {
                            echo '<span class = "ms-1"  style = "background-color:#227C70; padding:2px; color:white;">In Finish List</span>'; 
                        }

                    ?>  
                </th>
                <!-- class ="plan-qty" -->

                <th style = "max-width:100px;" > 
                    <input type="text" 
                        name="cycle_plan_qty" class = "form-control form-control-sm" 
                        id = "PlanQty" onchange=  "UpdateCyclePlanQTY(<?=  $cycle['cycle_id']?> , <?=$Product['CTNQTY'];?> , this.value , <?=$UsedPaper['ups']?>)" 
                        value = "<?=isset($cycle['cycle_plan_qty']) ? $cycle['cycle_plan_qty'] : 0; ?>" >
                </th>
                <th class = "" style = "max-width:100px;">
                   <input type="text" class="form-control form-control-sm m-0 "   placeholder = "Cut Qty (cm)" id="CutQty" 
                    name="CutQty" disabled value = "<?=isset($cycle['cut_qty']) ? $cycle['cut_qty'] : 0; ?>" >
                </th>

                <th scope="col"  > <?=$cycle['cycle_produce_qty']; ?>  </th>
                
                <th scope="col" style = "width:120px;"  > 
                    <form action="ChangeCycleFluteType.php" method="post">
                        <select class = "form-select form-select-sm" style = "max-width:100px;"  name="cycle_flute_type" id="" onchange= "this.form.submit()">
                            <option selected value="<?=$cycle['cycle_flute_type']?>"><?=$cycle['cycle_flute_type'];?></option>
                            <option value="C">C</option>
                            <option value="B">B</option>
                            <option value="E">E</option>
                            <option value="BC">BC</option>
                            <option value="CE">CE</option>
                            <option value="BCB">BCB</option>
                        </select>
                        <input type="hidden" name="CTNId" value = "<?=$_GET['CTNId']?>" >
                        <input type="hidden" name="cycle_id" value = " <?=$cycle['cycle_id'] ?>" >
                    </form>
                </th>
                <th scope="col">  
                    <?php if($cycle['cycle_status'] == 'Incomplete' || $cycle['cycle_status'] == 'Task List' ) {?>
                        
                        <a type="button"  onclick = "RemoveCycle(<?=$cycle['cycle_id']?>)" class="btn btn-outline-danger btn-sm ">   
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                            </svg>
                        </a>

                        <a type="button" data-bs-toggle="modal" style = "color:yellow; margin-left:2px;" data-bs-target="#exampleModal" onclick = "AddCycleId(<?=$cycle['cycle_id']?>)" > 
                            <svg width="30" height="30" x="0px" y="0px"   
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
                        <a href="ChangeCycleStatus.php?cycle_id=<?=$cycle['cycle_id']?>" 
                            onclick="return confirm('ایا مطمین استید در ارسال نمودن این جاب به تاسک لست')" 
                            class="btn btn-outline-primary btn-sm" title = "send to task list" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
                                <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
                                <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
                            </svg>  
                        </a>

                        <?php if(!$isComplete) { ?>
                            <a href="MarkAsComplete.php?cycle_id=<?=$cycle['cycle_id']?>&CTNId=<?=$CTNId?>" class = "btn btn-outline-dark btn-sm mx-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg> Mark as Complete
                            </a>
                        <?php } ?>

                    <?php  } // END OF COMPLETED IF BLOCK   
                    else if($cycle['cycle_status'] == 'Incomplete') { ?>
                    <?php  } // END OF COMPLETED IF BLOCK  ?>
                </th>
            </tr>

        <?php } // end of production cycle loop  ?>
        <?php } else echo '<span id = "PlanQty" style = "display:none;">0</span> ' ; //  else die('Somthing Went Wrong In Cycle:(');  ?>
        </tbody>
    </table>  

 
    <form action="ChangeCyclePlanQty.php" method="post">
        <input type="hidden" id = "cycle_plan_qty_input" name = "cycle_plan_qty_input"  >
        <input type="hidden" id = "cycle_id_for_plan_qty" name = "cycle_id_for_plan_qty"  >
        <input type="hidden" name="CTNId" value = "<?=$_GET['CTNId']?>" >
        <input type="hidden" name="apps" id = "cycle_apps_input">
    </form>
 
    <script>
        function UpdateCyclePlanQTY(cycle_id , CTNQTY , plan_qty , apps=1 ){
            if(plan_qty == null || plan_qty == 0 ) return ; 
            if(plan_qty > CTNQTY ) {
                alert('The Plan Quantity Must not be greater than Order QTY') ;
                return ; 
            } 
            let cycle_qty = document.getElementById('cycle_plan_qty_input'); 
            cycle_qty.value = plan_qty; 

            document.getElementById('cycle_id_for_plan_qty').value = cycle_id; 
            document.getElementById('cycle_apps_input').value = apps; 
            cycle_qty.form.submit(); 
        }
    </script>
    </div>
</div>
 
<!-- Modal -  for selecting registered machine for cycle  -->
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
                <input type="hidden" name="CTNId" value= "<?=$_REQUEST['CTNId'];?>" >
                
                <?php if ($machine_db_list->num_rows > 0) {  while($MACHINE = $machine_db_list->fetch_assoc()){    ?> 
                    <label class="list-group-item">
                        <input class="form-check-input me-1 _cycle_machine_ " 
                        name = "machine_<?=$MACHINE['machine_id'];?>"   
                        value = "<?=$MACHINE['machine_id']?>"  type="checkbox"
                        short = "<?php echo array_search( $MACHINE['machine_name'] , $machine )?>"
                        > <?= $MACHINE['machine_name'] ?> 
                    </label>  
                <?php  } } else echo "Machine query has errors!"; ?>
                <label class="list-group-item">
                    <input class="form-check-input me-1" name = "HasManual"   value = "Manual"  type="checkbox"  >
                    Use Manual Also 
                </label>  
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


<form action = "PostpondJob.php" method = "post">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal-postpond" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Please <strong class= "text-danger">  explain </strong> why your postponing  this product  </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class = "fw-bold ">120 / <span  class = "text-danger"id = "comment_length" >  </span></div>
                <textarea name="ProductionPostpondComment" class= "form-control" id="ProductionPostpondComment" cols="30" rows="10" onkeyup = 'CheckCancelCommentLength();'><?=$Product['ProductionPostpondComment']?></textarea>
            <input type="hidden" name="ProductionPostponedDate" value = "<?=date('Y-m-d H:i:s');?>" > 
            <input type="hidden" name="CTNId" value = "<?=$Product['CTNId']?>" > 
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary border-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-danger border-danger ">Save Comment</button>
            </div>
        </div>
        </div>
    </div>
</form>

<form action="RemoveUsedMachine.php" method = "post">
    <input type="hidden" name="cycle_id_main"  id = "cycle_id_main" >
    <input type="hidden" name="CTNId" value = "<?=$_REQUEST['CTNId']?>"    >
</form>

<script>

    function Precision(number , decimal=2) {
        return Number.parseFloat(number).toFixed(decimal);
    } 

    let PaperWeight = {}; 
    let indexxx = 1 ; 
    function AddPaperWeight(CTNTYPE){
        
        for (let index = 1; index <= CTNTYPE ; index++) {
            let PGL = document.getElementById('Paper_GSM_Layer_'+index).value ; 
            let element = document.getElementById('PaperLayerPrice_'+ indexxx);
            if(element.options[element.selectedIndex].text.slice(3).trim() == 'BB')   PaperWeight[element.options[element.selectedIndex].text.slice(3) + "_" + indexxx] = 250 ; 
            else PaperWeight[element.options[element.selectedIndex].text.slice(3).trim()  + "_" + indexxx] = PGL ; 
            indexxx++;
        }

        let value_length = 0 ;
        if( Object.keys(PaperWeight).length == 3 ) value_length = 1 ; 
        if( Object.keys(PaperWeight).length == 5 ) value_length = 2 ; 
        if( Object.keys(PaperWeight).length == 7 ) value_length = 3; 

        let value_counter = 1 ; 
        for (const property in PaperWeight) {  
            if( value_counter <= value_length )  {
                if(property.includes("Flute")){
                        PaperWeight[property] = PaperWeight[property]  * 1.38;  
                        value_counter++; 
                }
            }
        } // end of loop 
    }

    AddPaperWeight(<?=$Product['CTNType'];?>); 

    function CalculatePaperWeight(L , W , H , PaperWeight , CTNQTY ){

        let Length = (L+W) * 2 + 50 ; 
        let Dieckle = ( W+H ) * 0.1; 
        let SheetArea = Number(Precision( ((Length * 0.1 ) * Dieckle ) * 0.0001 , 4 ))   ;
        let RequiredPaperKG = 0 ; 
        let PaperTotalWeight = 0 ;
        let PaperTotalGSM = 0 ;  
        let SingleCartonWeight = 0 ; 
        let TrayArea = 0 ; 
        let counter = 1; 
        let PaperWeightListHTML = ''; 
        //  PaperWeightollectedListHTML 
        let PWTLH = ''; 

        let Flute = new RegExp("Flute");
        let BB = new RegExp("BB");
        let WTKL = new RegExp("WTKL");
        let TL = new RegExp("TL");
        let WTL = new RegExp("WTL");
        let KLB = new RegExp("KLB");
        let Liner = new RegExp("Liner");
        let BB1=0, Flute1=0, WTKL1=0, TL1=0, WTL1=0 , KLB1=0, Liner1=0; 

        let RG = /[a-z]+/i;
        for (const property in PaperWeight) {  
            RequiredPaperKG = SheetArea * PaperWeight[property] * CTNQTY * 0.001; 
            PaperTotalWeight += Number(Precision(RequiredPaperKG)) ; 
            PaperTotalGSM += Number(Precision(  PaperWeight[property])) ; 
            
            document.getElementById('PaperLayerWeight_'+counter).value =  Precision(RequiredPaperKG/1000 ,2 ) + " T"; 
            // PaperWeightListHTML += '<li class="list-group-item d-flex justify-content-between align-items-center"  >'; 
            // PaperWeightListHTML += ' <span style = "padding:0px;"> L' + counter + " - "  + RG.exec(property)   + '</span>  '; 
            // PaperWeightListHTML += '<span class = "shadow" style = "border:2px solid black; padding:4px; padding-left:6px; padding-right:6px;  border-radius:4.5px;  "  ><strong>' + Precision(RequiredPaperKG/1000 ,2 ) + ' TON </strong></span> </li>' ;
            counter++; 
        }// END OF LOOP 
            
        // PaperTotalWeight = Number(Precision( PaperTotalWeight )); 
        // PaperTotalGSM = Number(Precision( PaperTotalGSM ));  
        PaperTotalWeightTon = Number(Precision( PaperTotalWeight / 1000 )); 
        document.getElementById('paper_weight_total').value = 'Total = ' + PaperTotalWeightTon + ' TON';

        // PaperWeightListHTML += '<li class="list-group-item d-flex justify-content-between align-items-center "  > <span style = "font-weight:bold; padding:0px;">TOTAL</span> <span class = "shadow" style = "border:2px solid #6610f2; padding:4px; padding-left:6px; padding-right:6px;  border-radius:4.5px;  "  > '; 
        // PaperWeightListHTML += '<strong>' + PaperTotalWeightTon + ' TON </strong></span> </li>' ;
        // PaperWeightollectedList  
        // document.getElementById('PaperWeightList').innerHTML = PaperWeightListHTML ; 


        // SingleCartonWeight =  Number(Precision( PaperTotalGSM * SheetArea) ) ; 
        // TrayArea = Number(Precision(L * W * 0.000001 )); 
        // TrayWeight = Number(Precision(TrayArea * PaperTotalGSM )); 
        // OneCartonPaperUsage = Number(Precision( PaperTotalWeight * 1 / CTNQTY ))  ; 
        // document.getElementById('DieckleInput').value = Dieckle ; 


    }// END OF calculate paper weight 



    function ReelWastUps(){
    
        let Ups = Number(Precision( document.getElementById('Ups').value || 1)); 
        let TotalWidth = Number(Precision( document.getElementById('TotalWidth').innerHTML));  
        let Reel = Ups * ( TotalWidth / 10 ) ;
        let Wast = Number(Precision( document.getElementById('Wast').value || 0 )); 
        let Creesing =   document.getElementById('Creesing'); 
        let Width =   Number(Precision( document.getElementById('Width').innerHTML)); 
        let Height =   Number(Precision( document.getElementById('Height').innerHTML)); 
        
        
        let PlanQty =  Number(Precision(  document.getElementById('PlanQty').innerHTML) ); 
        
        if(Reel > 180 || Reel < 40 ) { 
            alert('The reel size must be between 40 and 180'); 
            document.getElementById('Reel').style.border = '2px solid red';  
        }
        // adding the reel and ups  value 
        document.getElementById('Reel').value = Reel ;
        
        // calclulate collectively the wast ups reel 
        if(Wast > 10 || Wast < 0 ) { alert('Please choose wast between 0 and 10'); document.getElementById('Wast').value = 0;  return ;  }
        document.getElementById('Reel').value = Precision(Reel + Wast ,2) ; 

        //  calculate creesing
        let c1 = (Width / 2 ) ;
        Creesing.value =   c1 + ' x ' + Height + ' x ' + c1  ; 
    }

    ReelWastUps();

    function removeDuplicateOptions(s, comparitor) {
        if(s.tagName.toUpperCase() !== 'SELECT') { return false; }
        var c, i, o=s.options, sorter={};
        if(!comparitor || typeof comparitor !== 'function') {
            comparitor = function(o) { return o.value; };//by default we comare option values.
        }
        for(i=0; i<o.length; i++) {
            c = comparitor(o[i]);
            if(sorter[c]) {
            s.removeChild(o[i]);
            i--;
            }
            else { sorter[c] = true; }
        }
        return true;
    }


    function AddCycleId(cycle_id ){
        document.getElementById('CYCLE_ID_').value = cycle_id; 
        var selected_cycle_machine =  document.getElementsByClassName('selected_cycle_machine_'+cycle_id); 
        var _cycle_machine_ =  document.getElementsByClassName('_cycle_machine_'); 

        for (var ii = 0; ii < _cycle_machine_.length; ii++) { // modal checkboxes 
            _cycle_machine_.item(ii).removeAttribute('checked');
        }

        // console.log(selected_machine);
        for (var j = 0; j < selected_cycle_machine.length; j++) { // selected machines 
            for (var i = 0; i < _cycle_machine_.length; i++) { // modal checkboxes 
                if(_cycle_machine_.item(i).getAttribute('short').trim() == selected_cycle_machine.item(j).innerHTML.trim()) {
                    _cycle_machine_.item(i).setAttribute('checked' , 'checked'); 
                }
            }
        }
    }
    function RemoveCycle(cycle_id){
        if(!confirm('ایا مطمین استید برای حذف نمودن این دوره' + ' ' +cycle_id )) return ; 
        document.getElementById('cycle_id_main').value = cycle_id; 
        document.getElementById('cycle_id_main').form.submit();
    }
</script>

<?php 
    $Exct = "<script>" ; 
    $Exct .= "CalculatePaperWeight(" . $Product['CTNLength'] ." , ". $Product['CTNWidth'] ." , ".  $Product['CTNHeight'] ." , PaperWeight ,".  $Product['CTNQTY']  ." );"; 
    $Exct .= "</script>" ;
    echo $Exct; 
?>
<?php  require_once '../App/partials/Footer.inc'; ?>