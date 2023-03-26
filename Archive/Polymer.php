<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
    require_once '../App/partials/Menu/MarketingMenu.inc';

    $RequestRows = $Controller->QueryData("SELECT `CTNId`,ppcustomer.CustName, CTNUnit,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,`CTNOrderDate`, `CTNStatus`, `CTNQTY`, `CTNUnit`,
    carton.`ProductName`, ppcustomer.CustMobile, ppcustomer.CustEmail, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note, PolyId, DieId, cpolymer.CartSample, 
    CPNumber, cdie.DieCode,cdie.CDSampleNo,CompleteTime,designinfo.DesignImage,designinfo.DesignCode1,Track  FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN cpolymer ON cpolymer.CPid=carton.PolyId LEFT OUTER JOIN cdie ON cdie.CDieId=carton.DieId
    LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId  WHERE  Track = 'Request' ORDER BY CTNOrderDate DESC",[]);

    $SubmittedRows = $Controller->QueryData("SELECT `CTNId`,ppcustomer.CustName, CTNUnit,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,`CTNOrderDate`, `CTNStatus`, `CTNQTY`, `CTNUnit`,
    carton.`ProductName`, ppcustomer.CustMobile, ppcustomer.CustEmail, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note, PolyId, DieId, cpolymer.CartSample, 
    CPNumber,cdie.DieCode,cdie.CDSampleNo,designinfo.DesignImage,CompleteTime,designinfo.DesignCode1  FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN cpolymer ON cpolymer.CPid=carton.PolyId
    LEFT OUTER JOIN cdie ON cdie.CDieId=carton.DieId LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId  WHERE Track='Submitted' ORDER BY CTNOrderDate DESC",[]);

    $CompletedRows = $Controller->QueryData("SELECT `CTNId`,ppcustomer.CustName, CTNUnit,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,`CTNOrderDate`, `CTNStatus`, `CTNQTY`, `CTNUnit`,
    carton.`ProductName`, ppcustomer.CustMobile, ppcustomer.CustEmail, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note, PolyId, DieId, cpolymer.CartSample, 
    CPNumber,cdie.DieCode,cdie.CDSampleNo,designinfo.DesignImage,CompleteTime,designinfo.DesignCode1  FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN cpolymer ON cpolymer.CPid=carton.PolyId
    LEFT OUTER JOIN cdie ON cdie.CDieId=carton.DieId LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId  WHERE Track='Completed' ORDER BY CTNOrderDate DESC",[]);
?>



<div class=" m-3">
    <div class="card " >
      <div class="card-body d-flex justify-content-between align-item-center shadow">
            <h3 class="m-0 p-0"> 
                <a class="btn btn-outline-primary   me-1" href="ArchiveJobCenter.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                    </svg>
                </a>
                <svg viewBox="0 0 24 24"width= "50px" height = "50px"  data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#ed7707" stroke="#ed7707"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#ed7707;stroke-miterlimit:10;stroke-width:1.91px;}</style></defs><path class="cls-1" d="M20.59,6.27A1.92,1.92,0,0,0,22.5,8.18v1.91a1.91,1.91,0,0,0,0,3.82v1.91a1.91,1.91,0,0,0,0,3.82V22.5H19.64a1.91,1.91,0,0,0-3.82,0H13.91a1.91,1.91,0,0,0-3.82,0H8.18a1.91,1.91,0,0,0-3.82,0H1.5V19.64a1.91,1.91,0,0,0,0-3.82V13.91a1.91,1.91,0,0,0,0-3.82V8.18a1.91,1.91,0,0,0,0-3.82V1.5H4.36a1.91,1.91,0,1,0,3.82,0h1.91a1.91,1.91,0,0,0,3.82,0h1.91a1.91,1.91,0,0,0,3.82,0H22.5V4.36A1.92,1.92,0,0,0,20.59,6.27Z"></path><path class="cls-1" d="M13,11.05l1.59.95a3.12,3.12,0,0,0,3.19,0,3,3,0,0,1,1.58-.44,2.93,2.93,0,0,1,1.29.29"></path><path class="cls-1" d="M20.82,7.19a5.66,5.66,0,0,0-1.51-.4,3,3,0,0,0-1.58.44,3.12,3.12,0,0,1-3.19,0L13,6.27"></path><path class="cls-1" d="M13,15.82l1.59.95a3.1,3.1,0,0,0,3.19,0,3.06,3.06,0,0,1,3.13,0"></path></g></svg>
                <span style = "color:#ed7707">Polymer</span>  
            </h3>
            <div class= "mt-1">
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
                <!-- <a class="btn btn-outline-info" > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                    </svg> History   
                </a> -->
            </div>
        </div>
    </div>
</div>

<div class="collapse shadow" style="position: absolute; z-index: 1000; width: 30%; left: 69%; margin-top:-21px; " id="colapse1">
    <div class="card card-body border shadow">
        <div class="form-floating">
            <input type="text" class="form-control"  id = "Search_input" placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
            <label for="Reel">Search Anything</label>
        </div>
    </div>
</div>

<div class="card m-3 shadow">
    <div class="card-body pt-2">

        <ul class="nav nav-tabs" id="myTab" role="tablist"> 
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><strong>درخواست پولیمر </strong><span class="badge rounded-pill bg-danger"><?=$RequestRows->num_rows?></span> </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><strong>پولیمرهای تسلیم شده </strong><span class="badge rounded-pill bg-danger"><?=$SubmittedRows->num_rows?></span> </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false"><strong>پولیمر های تکمیل شده </strong><span class="badge rounded-pill bg-danger"><?=$CompletedRows->num_rows?></span> </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class= "table mt-3" >
                    <thead>
                        <tr class="table-info">
                            <th>#</th>
                            <th title="Job No">J.No</th>
                            <th> Product Name</th>
                            <th> Size (L x W x H) CM</th>
                            <th>Color</th>
                            <th title="Polymer No">Poly.No</th>
                            <th>DieNo</th>
                            <th>OPS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter =1; while($Rows=$RequestRows->fetch_assoc())  {   ?>
                                <tr class ="p-0 m-0" >
                                    <td><?=$counter++?></td>
                                    <td><?=$Rows['JobNo']?></td>
                                    <td><?=$Rows['ProductName']?></td>
                                    <td><?=$Rows['Size']?></td>
                                    <td><?=$Rows['CTNColor']?></td>
                                    <td><?=$Rows['CPNumber']?></td>
                                    <td><?=$Rows['DieCode']?></td>
                                    <td>
                                        <a href="StateTrack.php?CTNId=<?=$Rows['CTNId']?>" 
                                            class="btn btn-outline-primary btn-sm" 
                                            onclick='return confirm(`ایا د دی جاب لپاره مو پروډکشن ته غوښتل شوی پولیمر یا ډایي د سمپل سره تسلیم کړي؟`);'>
                                            Submit
                                        </a>
                                        <a style="text-decoration:none;" target="_blank" title="Click To Show Design Image" href="../Design/ShowDesignImage.php?Url=<?=$Rows['DesignImage']?>&ProductName=<?=$Rows['ProductName']?>">
                                            <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 4.25H6C5.27065 4.25 4.57118 4.53973 4.05546 5.05546C3.53973 5.57118 3.25 6.27065 3.25 7V17C3.25 17.7293 3.53973 18.4288 4.05546 18.9445C4.57118 19.4603 5.27065 19.75 6 19.75H18C18.7293 19.75 19.4288 19.4603 19.9445 18.9445C20.4603 18.4288 20.75 17.7293 20.75 17V7C20.75 6.27065 20.4603 5.57118 19.9445 5.05546C19.4288 4.53973 18.7293 4.25 18 4.25ZM6 5.75H18C18.3315 5.75 18.6495 5.8817 18.8839 6.11612C19.1183 6.35054 19.25 6.66848 19.25 7V15.19L16.53 12.47C16.4589 12.394 16.3717 12.3348 16.2748 12.2968C16.178 12.2587 16.0738 12.2427 15.97 12.25C15.865 12.2561 15.7622 12.2831 15.6678 12.3295C15.5733 12.3759 15.4891 12.4406 15.42 12.52L14.13 14.07L9.53 9.47C9.46222 9.39797 9.37993 9.34111 9.28858 9.30319C9.19723 9.26527 9.09887 9.24714 9 9.25C8.89496 9.25611 8.79221 9.28314 8.69776 9.32951C8.60331 9.37587 8.51908 9.44064 8.45 9.52L4.75 13.93V7C4.75 6.66848 4.8817 6.35054 5.11612 6.11612C5.35054 5.8817 5.66848 5.75 6 5.75ZM4.75 17V16.27L9.05 11.11L13.17 15.23L10.65 18.23H6C5.67192 18.23 5.35697 18.1011 5.12311 17.871C4.88926 17.6409 4.75525 17.328 4.75 17ZM18 18.25H12.6L16.05 14.11L19.2 17.26C19.1447 17.538 18.9951 17.7884 18.7764 17.9688C18.5577 18.1492 18.2835 18.2485 18 18.25Z" fill="#000000" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#e8e6e3;"></path> </g></svg>
                                        </a>
                                    </td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>  
            </div>


            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class= "table mt-3" >
                    <thead>
                        <tr class="table-info">
                            <th>#</th>
                            <th>J.No</th>
                            <th>Product Name</th>
                            <th>Size (L x W x H) CM</th>
                            <th>Color</th>
                            <th>Poly.No</th>
                            <th>DieNo</th>
                            <th>Design</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter =1; while($Rows=$SubmittedRows->fetch_assoc())  {   ?>
                                <tr class ="p-0 m-0" >
                                    <td><?=$counter++?></td>
                                    <td><?=$Rows['JobNo']?></td>
                                    <td><?=$Rows['ProductName']?></td>
                                    <td><?=$Rows['Size']?></td>
                                    <td><?=$Rows['CTNColor']?></td>
                                    <td><?=$Rows['CPNumber']?></td>
                                    <td><?=$Rows['DieCode']?></td>
                                    <td>
                                        <a style="text-decoration:none;" target="_blank" title="Click To Show Design Image" href="../Design/ShowDesignImage.php?Url=<?=$Rows['DesignImage']?>&ProductName=<?=$Rows['ProductName']?>">
                                            <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 4.25H6C5.27065 4.25 4.57118 4.53973 4.05546 5.05546C3.53973 5.57118 3.25 6.27065 3.25 7V17C3.25 17.7293 3.53973 18.4288 4.05546 18.9445C4.57118 19.4603 5.27065 19.75 6 19.75H18C18.7293 19.75 19.4288 19.4603 19.9445 18.9445C20.4603 18.4288 20.75 17.7293 20.75 17V7C20.75 6.27065 20.4603 5.57118 19.9445 5.05546C19.4288 4.53973 18.7293 4.25 18 4.25ZM6 5.75H18C18.3315 5.75 18.6495 5.8817 18.8839 6.11612C19.1183 6.35054 19.25 6.66848 19.25 7V15.19L16.53 12.47C16.4589 12.394 16.3717 12.3348 16.2748 12.2968C16.178 12.2587 16.0738 12.2427 15.97 12.25C15.865 12.2561 15.7622 12.2831 15.6678 12.3295C15.5733 12.3759 15.4891 12.4406 15.42 12.52L14.13 14.07L9.53 9.47C9.46222 9.39797 9.37993 9.34111 9.28858 9.30319C9.19723 9.26527 9.09887 9.24714 9 9.25C8.89496 9.25611 8.79221 9.28314 8.69776 9.32951C8.60331 9.37587 8.51908 9.44064 8.45 9.52L4.75 13.93V7C4.75 6.66848 4.8817 6.35054 5.11612 6.11612C5.35054 5.8817 5.66848 5.75 6 5.75ZM4.75 17V16.27L9.05 11.11L13.17 15.23L10.65 18.23H6C5.67192 18.23 5.35697 18.1011 5.12311 17.871C4.88926 17.6409 4.75525 17.328 4.75 17ZM18 18.25H12.6L16.05 14.11L19.2 17.26C19.1447 17.538 18.9951 17.7884 18.7764 17.9688C18.5577 18.1492 18.2835 18.2485 18 18.25Z" fill="#000000" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#e8e6e3;"></path> </g></svg>
                                        </a>
                                    </td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>    
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <table class= "table mt-3" >
                    <thead>
                        <tr class="table-info">
                            <th>#</th>
                            <th title="Job No">J.No</th>
                            <th> Product Name</th>
                            <th> Size (L x W x H) CM</th>
                            <th>Color</th>
                            <th title="Polymer No">Poly.No</th>
                            <th>DieNo</th>
                            <th>OPS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter =1; while($Rows=$CompletedRows->fetch_assoc())  {   ?>
                                <tr class ="p-0 m-0" >
                                    <td><?=$counter++?></td>
                                    <td><?=$Rows['JobNo']?></td>
                                    <td><?=$Rows['ProductName']?></td>
                                    <td><?=$Rows['Size']?></td>
                                    <td><?=$Rows['CTNColor']?></td>
                                    <td><?=$Rows['CPNumber']?></td>
                                    <td><?=$Rows['DieCode']?></td>
                                    <td>
                                        <a href="StateTrack.php?CTNId=<?=$Rows['CTNId']?>&Status=Archieve" 
                                            class="btn btn-success btn-sm" 
                                            onclick='return confirm(`Are you sure for returning polymer from production`);'>
                                            Return Polymer
                                        </a>
                                        <a style="text-decoration:none;" target="_blank" title="Click To Show Design Image" href="../Design/ShowDesignImage.php?Url=<?=$Rows['DesignImage']?>&ProductName=<?=$Rows['ProductName']?>">
                                            <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 4.25H6C5.27065 4.25 4.57118 4.53973 4.05546 5.05546C3.53973 5.57118 3.25 6.27065 3.25 7V17C3.25 17.7293 3.53973 18.4288 4.05546 18.9445C4.57118 19.4603 5.27065 19.75 6 19.75H18C18.7293 19.75 19.4288 19.4603 19.9445 18.9445C20.4603 18.4288 20.75 17.7293 20.75 17V7C20.75 6.27065 20.4603 5.57118 19.9445 5.05546C19.4288 4.53973 18.7293 4.25 18 4.25ZM6 5.75H18C18.3315 5.75 18.6495 5.8817 18.8839 6.11612C19.1183 6.35054 19.25 6.66848 19.25 7V15.19L16.53 12.47C16.4589 12.394 16.3717 12.3348 16.2748 12.2968C16.178 12.2587 16.0738 12.2427 15.97 12.25C15.865 12.2561 15.7622 12.2831 15.6678 12.3295C15.5733 12.3759 15.4891 12.4406 15.42 12.52L14.13 14.07L9.53 9.47C9.46222 9.39797 9.37993 9.34111 9.28858 9.30319C9.19723 9.26527 9.09887 9.24714 9 9.25C8.89496 9.25611 8.79221 9.28314 8.69776 9.32951C8.60331 9.37587 8.51908 9.44064 8.45 9.52L4.75 13.93V7C4.75 6.66848 4.8817 6.35054 5.11612 6.11612C5.35054 5.8817 5.66848 5.75 6 5.75ZM4.75 17V16.27L9.05 11.11L13.17 15.23L10.65 18.23H6C5.67192 18.23 5.35697 18.1011 5.12311 17.871C4.88926 17.6409 4.75525 17.328 4.75 17ZM18 18.25H12.6L16.05 14.11L19.2 17.26C19.1447 17.538 18.9951 17.7884 18.7764 17.9688C18.5577 18.1492 18.2835 18.2485 18 18.25Z" fill="#000000" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#e8e6e3;"></path> </g></svg>
                                        </a>
                                    </td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>  
            </div>
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