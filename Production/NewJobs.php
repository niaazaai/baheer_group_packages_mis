<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
    if(!in_array( $Gate['VIEW_NEW_JOBS_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
        header("Location:index.php?msg=You are not authorized to access this page!" );
    }


    require_once '../App/partials/Menu/MarketingMenu.inc';
    $Query="SELECT carton.CTNId,ppcustomer.CustName, JobNo,CTNOrderDate,CTNStatus,ProductQTY,JobType,CTNFinishDate,CTNQTY,
        carton.Ctnp1,carton.Ctnp2,carton.Ctnp3,carton.Ctnp4,carton.Ctnp5,carton.Ctnp6,carton.Ctnp7  ,carton.CTNType, 
        CTNUnit,CTNColor, ProductName ,CTNStatus,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,ProductQTY,
        designinfo.DesignImage, CFluteType ,  used_paper.reel, designinfo.DesignCode1 ,designinfo.DesignImage
        FROM carton 
        INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
        LEFT JOIN used_paper ON designinfo.CaId= used_paper.carton_id 
        WHERE JobNo != 'NULL' AND CTNStatus='Production'   
    ORDER BY JobNo DESC";
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
                <svg width="50" height="50" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M34.11 14.49L30.19 7.87L34.07 1.52C34.1621 1.36868 34.2124 1.1956 34.2157 1.01848C34.2189 0.841351 34.1751 0.666534 34.0886 0.511912C34.0022 0.35729 33.8762 0.228414 33.7236 0.138469C33.5709 0.0485231 33.3972 0.000737145 33.22 0H2C1.46957 0 0.960859 0.210714 0.585786 0.585787C0.210714 0.96086 0 1.46957 0 2L0 14C0 14.5304 0.210714 15.0391 0.585786 15.4142C0.960859 15.7893 1.46957 16 2 16H33.25C33.4265 16 33.5999 15.9532 33.7524 15.8645C33.905 15.7758 34.0314 15.6483 34.1188 15.4949C34.2061 15.3415 34.2513 15.1678 34.2498 14.9913C34.2482 14.8148 34.2 14.6418 34.11 14.49V14.49ZM10.51 11.18H9.39L6.13 6.84V11.19H5V5H6.13L9.4 9.35V5H10.52L10.51 11.18ZM16.84 6H13.31V7.49H16.51V8.49H13.31V10.1H16.84V11.1H12.18V5H16.83L16.84 6ZM25.13 11.16H24L22.45 6.57L20.9 11.18H19.78L17.78 5H19L20.32 9.43L21.84 5H23.06L24.52 9.43L25.85 5H27.08L25.13 11.16Z" fill="#00FFC6"/>
                </svg> <span style = "color:#00FFC6"> New Jobs </span>
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

        <table class= "table " id = "JobTable" >
            <thead>
                <tr class="table-info">
                    <th title="Job No">J.No</th>
                    <th> Product Name</th>
                    <th> Size (L x W x H) CM</th>
                    <th title="Reel Size">Reel</th>
                    <th title="Flute type"> Flute</th>
                    <th title="Paper Type">Paper</th>
                    <th title="Order QTY">Order QTY</th>
                    <th title="Job Status" >Status</th>   
                    <th title="Opreations">OPS</th>
                </tr>
            </thead>
            <tbody>
                <?php $Total_OQ = 0 ;  
                    while($Rows=$DataRows->fetch_assoc())  {
                        $ReminingQTY=$Rows['CTNQTY']-$Rows['ProductQTY'];  ?>
                        <tr class ="p-0 m-0" >
                            <td ><?=$Rows['JobNo']?> 
                            <td><?=$Rows['ProductName']?></td>
                            <td><?=$Rows['Size']?></td>
                            <th><?=$Rows['reel']?></th>
                            <th><?=$Rows['CFluteType']?></th>
                            <th> 
                                <span class ="badge _selected_paper_" style = "background-color:#6D67E4; font-size:12px;">
                                    <?php
                                        $arr = []; 
                                        for ($index=1; $index <= 7 ; $index++) { 
                                            if(empty($Rows['Ctnp'.$index])) continue; 
                                            $arr[] = $Rows['Ctnp'.$index];   
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
                            </th>
                            <td><?=number_format($Rows['CTNQTY']); $Total_OQ += $Rows['CTNQTY']; ?></td>
                          
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
                    <td colspan = 6  class = "text-center" > <strong> Total Quantity </strong></td>
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


