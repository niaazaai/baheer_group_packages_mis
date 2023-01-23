<?php 
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc';
    require '../Assets/Carbon/autoload.php';
    use Carbon\Carbon;
    

    $Query="SELECT carton.CTNId,ppcustomer.CustName, JobNo,CTNOrderDate,CTNStatus,ProductQTY,JobType,CTNFinishDate,CTNQTY,
    carton.Ctnp1,carton.Ctnp2,carton.Ctnp3,carton.Ctnp4,carton.Ctnp5,carton.Ctnp6,carton.Ctnp7  ,carton.CTNType, 
    CTNUnit,CTNColor, ProductName ,CTNStatus,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,ProductQTY,
    designinfo.DesignImage, CFluteType, designinfo.DesignCode1, designinfo.DesignImage
    FROM carton 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
    INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
    WHERE CTNStatus='Urgent' AND JobNo != 'NULL' ORDER BY JobNo DESC";
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
                <svg width="50" height="50" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M25.1813 21.9897L18.2172 17.1199V8.74999C18.2172 8.35552 17.8945 8.03278 17.5 8.03278C17.1055 8.03278 16.7828 8.35552 16.7828 8.74999V17.5C16.7828 17.7367 16.8975 17.9518 17.0912 18.0881L24.3637 23.1731C24.4856 23.2592 24.6291 23.3022 24.7725 23.3022C24.9949 23.3022 25.2172 23.1947 25.3606 22.9867C25.583 22.6639 25.5041 22.2193 25.1813 21.9897Z" fill="#FB2576"/>
                    <path d="M29.8648 5.13525C26.5512 1.82172 22.1619 0 17.5 0C12.8381 0 8.44877 1.82172 5.13525 5.13525C1.82172 8.44877 0 12.8381 0 17.5C0 22.1619 1.82172 26.5512 5.13525 29.8648C8.44877 33.1783 12.8381 35 17.5 35C22.1619 35 26.5512 33.1783 29.8648 29.8648C33.1783 26.5512 35 22.1619 35 17.5C35 12.8381 33.1783 8.44877 29.8648 5.13525ZM18.2172 33.5512V30.625C18.2172 30.2305 17.8945 29.9078 17.5 29.9078C17.1055 29.9078 16.7828 30.2305 16.7828 30.625V33.5512C8.4918 33.1854 1.81455 26.5082 1.44877 18.2172H4.375C4.76947 18.2172 5.09221 17.8945 5.09221 17.5C5.09221 17.1055 4.76947 16.7828 4.375 16.7828H1.44877C1.81455 8.4918 8.4918 1.81455 16.7828 1.44877V4.375C16.7828 4.76947 17.1055 5.09221 17.5 5.09221C17.8945 5.09221 18.2172 4.76947 18.2172 4.375V1.44877C26.5082 1.81455 33.1854 8.4918 33.5512 16.7828H30.625C30.2305 16.7828 29.9078 17.1055 29.9078 17.5C29.9078 17.8945 30.2305 18.2172 30.625 18.2172H33.5512C33.1854 26.5082 26.5082 33.1854 18.2172 33.5512Z" fill="#FB2576"/>
                </svg> <span style = "color:#FB2576"> Urgent Jobs </span>
            </h3>
            <div class= "mt-1">
                <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                    </svg>
                </a>
                <a class="btn btn-outline-danger " data-bs-toggle="collapse" href="#colapse1" role="button" aria-expanded="false"  > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg> Search   
                </a>
            </div>
        </div>
    </div>
</div>

<div class="collapse shadow" style="position: absolute; z-index: 1000; width: 60%; left: 39%; margin-top:-21px; " id="colapse1">
    <div class="card card-body border shadow">
        <div class="form-floating">
            <input type="text" class="form-control"  id = "Search_input" placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
            <label for="Reel">Search Anything</label>
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
                    <!-- <th title="Reel Size">Reel</th> -->
                    <th title="Flute type"> Flute</th>
                    <th title="Paper Type">Paper</th>
                    <th title="Order QTY">Order QTY</th>
                    <th title="Design Image" >Design</th>
                    <th title="Job Status" >Status</th>  
                    <th title = "Opreation" >OPS</th>
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
                            <!-- <th><?php //$Rows['reel']?></th> -->
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
                                <?php if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1']) )  { ?>
                                    <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                    href="ShowDesignImage.php?Url=<?=$Rows['DesignImage']?>&ProductName=<?=$Rows['ProductName']?>" >
                                        <?php   echo '<span class = "text-success" >'. $Rows['DesignCode1'] . '</span>';  ?>  
                                    </a>
                                    <?php }  else {
                                        echo '<span class = "text-danger p-1" style = "border:1px solid red; border-radius:3px; "   >N/A</span>';
                                    } 
                                ?>
                            </td>
                            <td><?= "<span class = 'badge bg-danger'>". $Rows['CTNStatus'] . "</span>"; ?></td>
                            <td> </td>
                            <!-- <td>  <?php //"<span class = 'badge' style = 'background-color:#121212;'>" .  Carbon::createFromTimeStamp(strtotime( $Rows['ProductionPostponedDate'] ) , 'Asia/Kabul')->diffForHumans() . "</span>";?>  </td>-->
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




