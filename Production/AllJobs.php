<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
    if(!in_array( $Gate['VIEW_ALL_JOBS_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
      header("Location:index.php?msg=You are not authorized to access this page!" );
    }

    
    require_once '../App/partials/Menu/MarketingMenu.inc';

    $Query="SELECT carton.CTNId,ppcustomer.CustName, JobNo,CTNOrderDate,CTNStatus,ProductQTY,JobType,CTNFinishDate,CTNQTY,
    CTNUnit,CTNColor, ProductName ,CTNStatus,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,ProductQTY,
    designinfo.DesignImage, CFluteType ,  used_paper.reel, designinfo.DesignCode1 ,designinfo.DesignImage 
    FROM carton 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
    INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
    LEFT JOIN used_paper ON designinfo.CaId= used_paper.carton_id 
    WHERE CTNStatus='Production' OR CTNStatus='Production Pending' OR CTNStatus='Production Process' OR CTNStatus='Urgent'   
    ORDER BY JobNo DESC";

    if(isset($_REQUEST['CFluteType']) && !empty(trim($_REQUEST['CFluteType']))){
    
        if($_REQUEST['CFluteType'] == "ALL") $condition = "CTNStatus='Production'  OR CTNStatus='Production Pending' OR CTNStatus='Production Process'  OR CTNStatus='Urgent' AND JobNo != 'NULL'"; 
        else $condition = "CFluteType='". $_REQUEST['CFluteType'] ."' AND (CTNStatus='Production'  OR CTNStatus='Production Pending' OR CTNStatus='Production Process'  OR CTNStatus='Urgent' AND JobNo != 'NULL' )"; 
 
        $Query="SELECT carton.CTNId, JobNo,CTNOrderDate,CTNStatus,ProductQTY,JobType,CTNFinishDate,CTNQTY,
        CTNUnit,CTNColor, ProductName ,CTNStatus,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,ProductQTY,
        designinfo.DesignImage, CFluteType ,  used_paper.reel ,designinfo.DesignCode1 ,designinfo.DesignImage 
        FROM carton 
        INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
        LEFT JOIN used_paper  ON designinfo.CaId= used_paper.carton_id 
        WHERE  ".$condition." ORDER BY JobNo DESC";
    }

    if(isset($_REQUEST['CFluteType']) && !empty(trim($_REQUEST['CFluteType'])) &&  isset($_REQUEST['Reel']) && !empty(trim($_REQUEST['Reel']))  ){

        $condition = ''; 
        if($_REQUEST['CFluteType'] == "ALL") $condition = "reel='". $_REQUEST['Reel'] ."' AND (CTNStatus='Production'  OR CTNStatus='Production Pending' OR CTNStatus='Production Process'  OR CTNStatus='Urgent')"; 
        else $condition = "CFluteType='". $_REQUEST['CFluteType'] . "' AND reel='". $_REQUEST['Reel'] . "' AND (CTNStatus='Production'  OR CTNStatus='Production Pending' OR CTNStatus='Production Process'  OR CTNStatus='Urgent')"; 

        $Query="SELECT carton.CTNId,ppcustomer.CustName,carton.ProductName,  JobNo,CTNStatus,ProductQTY,JobType,CTNQTY,
        CTNUnit,CTNColor ,CTNStatus,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,ProductQTY,
        designinfo.DesignImage, CFluteType , used_paper.reel , designinfo.DesignCode1 ,designinfo.DesignImage 
        FROM carton 
        INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
        LEFT JOIN used_paper ON designinfo.CaId= used_paper.carton_id 
        WHERE  $condition ORDER BY JobNo DESC";
    }

    $DataRows=$Controller->QueryData($Query,[]);

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
                <svg width="50" height="50" viewBox="0 0 46 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 8H1V63H45V8H32" stroke="#332FD0" stroke-width="2" stroke-miterlimit="10"/>
                    <path d="M27 5V1H19V5H15L13 13H33L31 5H27Z" stroke="#332FD0" stroke-width="2" stroke-miterlimit="10"/>
                    <path d="M41 13H5V59H41V13Z" stroke="#332FD0" stroke-width="2" stroke-miterlimit="10"/>
                    <path d="M14.2628 40H12.2855L15.2983 31.2727H17.6761L20.6847 40H18.7074L16.5213 33.267H16.4531L14.2628 40ZM14.1392 36.5696H18.8097V38.0099H14.1392V36.5696ZM21.7351 40V31.2727H23.5803V38.4787H27.3217V40H21.7351ZM28.5437 40V31.2727H30.3888V38.4787H34.1303V40H28.5437Z" fill="#332FD0"/>
                </svg> All Available Jobs
            </h3>

            <div class= "mt-1">
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
</div>



<div class="card m-3 shadow">
    <div class="card-body">

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <form action="" method = "post"  >
                    <div class="form-floating">
                        <select class="form-select form-sm" id="SelectFluteType" aria-label="Fluting Type" name = "CFluteType" onchange="this.form.submit();" >
                            <option selected>Flute Type</option>
                            <option value="ALL">ALL</option>
                            <option value="C">C</option>
                            <option value="B">B</option>
                            <option value="E">E</option>
                            <option value="BC">BC</option>
                            <option value="CE">CE</option>
                            <option value="BCB">BCB</option>
                        </select>
                        <label for="SelectFluteType">Select Flute Type </label>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <form action="" method = "post"  >
                     <div class="form-floating">
                        <input type="text" class="form-control" id="Reel" placeholder="Reel" name = "Reel" value="<?=(isset($_REQUEST['Reel'])) ? $_REQUEST['Reel'] : ''; ?>" onfocusout='this.form.submit();'>
                        <label for="Reel">Reel</label>
                    </div>
                    <input type="hidden" value = "<?=(isset($_REQUEST['CFluteType'])) ? $_REQUEST['CFluteType'] : ''; ?>" name = "CFluteType"  >
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


<div class="card m-3 shadow">
    <div class="card-body pt-2">

        <div class = "mb-2 text-end" >
            <a href = "#" onclick = "PutSearchTermToInputBox('Under Process')"><span class = "badge bg-warning  ">Under Process Job</span></a>
            <a href = "#" onclick = "PutSearchTermToInputBox('New Job')"><span class = "badge bg-info  ">New Jobs</span></a>
            <a href = "#" onclick = "PutSearchTermToInputBox('Urgent')"><span class = "badge bg-danger  ">Urgent Jobs</span></a>
            <a href = "#" onclick = "PutSearchTermToInputBox('')"><span class = "badge bg-dark  ">All Jobs</span></a>
        </div>

        <table class= "table " id = "JobTable" >
            <thead>
                <tr class="table-info">
                    <th title="Job No">J.No</th>
                    <th> Product Name</th>
                    <th> Size (L x W x H) CM</th>
                    <th title="Reel Size">Reel</th>
                    <th title="Flute type"> Flute</th>
                    <th title="Order QTY">Order QTY</th>
                    <th title="Produced QTY">Pro.QTY</th>
                    <th title="Job Status" >Status</th>   
                    <th title="Opreations" >OPS</th>  
                </tr>
            </thead>
            <tbody>
                <?php $Total_OQ = 0 ; 
                    while($Rows=$DataRows->fetch_assoc())  {
                        $ReminingQTY=$Rows['CTNQTY']-$Rows['ProductQTY'];  ?>
                        <tr class ="p-0" >
                            <td><?=$Rows['JobNo']?></td>
                            <td><?=$Rows['ProductName']?></td>
                            <td><?=$Rows['Size']?></td>
                            <th><?=$Rows['reel']?></th>
                            <th><?=$Rows['CFluteType']?></th>
                            <td><?=number_format($Rows['CTNQTY']); $Total_OQ += $Rows['CTNQTY']; ?></td>
                            <td><?=number_format($Rows['ProductQTY']);?></td>
                          
                            <td>
                                <?php 
                                    if($Rows['CTNStatus'] == 'Production' ) echo "<span class = 'badge bg-info ' > New Job</span>"; 
                                    else if($Rows['CTNStatus'] == 'Production Process' ) echo "<span class = 'badge bg-warning ' > Under Process</span>"; 
                                    else if($Rows['CTNStatus'] == 'Completed' ) echo "<span class = 'badge bg-success ' > Complete</span>"; 
                                    else if($Rows['CTNStatus'] == 'Production Pending' ) echo "<span class = 'badge bg-danger'>PostPond</span>"; 
                                    else if($Rows['CTNStatus'] == 'Urgent' ) echo "<span class = 'badge bg-danger'> Urgent </span>"; 
                                ?>
                            </td>

                            <td>
                                <a href="JobManagement.php?CTNId=<?=$Rows['CTNId']?>" class = "btn btn-outline-primary btn-sm ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.004-.001.274-.11a.75.75 0 0 1 .558 0l.274.11.004.001 6.971 2.789Zm-1.374.527L8 5.962 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339Z"/>
                                    </svg> Manage
                                </a>
                                <?php if(isset($Rows['DesignImage']) && !empty($Rows['DesignImage']) )  {    ?>
                                    <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                        href="../Design/ShowDesignImage.php?Url=<?=$Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                                            <svg width = "35px" height = "35px"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier"> <path d="M18 4.25H6C5.27065 4.25 4.57118 4.53973 4.05546 5.05546C3.53973 5.57118 3.25 6.27065 3.25 7V17C3.25 17.7293 3.53973 18.4288 4.05546 18.9445C4.57118 19.4603 5.27065 19.75 6 19.75H18C18.7293 19.75 19.4288 19.4603 19.9445 18.9445C20.4603 18.4288 20.75 17.7293 20.75 17V7C20.75 6.27065 20.4603 5.57118 19.9445 5.05546C19.4288 4.53973 18.7293 4.25 18 4.25ZM6 5.75H18C18.3315 5.75 18.6495 5.8817 18.8839 6.11612C19.1183 6.35054 19.25 6.66848 19.25 7V15.19L16.53 12.47C16.4589 12.394 16.3717 12.3348 16.2748 12.2968C16.178 12.2587 16.0738 12.2427 15.97 12.25C15.865 12.2561 15.7622 12.2831 15.6678 12.3295C15.5733 12.3759 15.4891 12.4406 15.42 12.52L14.13 14.07L9.53 9.47C9.46222 9.39797 9.37993 9.34111 9.28858 9.30319C9.19723 9.26527 9.09887 9.24714 9 9.25C8.89496 9.25611 8.79221 9.28314 8.69776 9.32951C8.60331 9.37587 8.51908 9.44064 8.45 9.52L4.75 13.93V7C4.75 6.66848 4.8817 6.35054 5.11612 6.11612C5.35054 5.8817 5.66848 5.75 6 5.75ZM4.75 17V16.27L9.05 11.11L13.17 15.23L10.65 18.23H6C5.67192 18.23 5.35697 18.1011 5.12311 17.871C4.88926 17.6409 4.75525 17.328 4.75 17ZM18 18.25H12.6L16.05 14.11L19.2 17.26C19.1447 17.538 18.9951 17.7884 18.7764 17.9688C18.5577 18.1492 18.2835 18.2485 18 18.25Z" fill="#000000"></path> </g></svg>
                                    </a>
                                <?php } else {  echo '<span class = "text-danger p-1" style = "border:2px solid red; border-radius:3px; "   >N/A</span>'; }  ?>  

                            </td>
                        </tr>
                    <?php 
                    }
                ?>
                <tr>
                    <td colspan = 5  class = "text-center" > <strong> Total Quantity </strong></td>
                    <td> <strong><?=number_format($Total_OQ)?></strong> </td>
                    <td colspan = 4 ></td>
                </tr>
            </tbody>
        </table>  
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


