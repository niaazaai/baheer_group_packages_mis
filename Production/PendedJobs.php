 <?php 
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc';
    require '../Assets/Carbon/autoload.php';
    use Carbon\Carbon;
    

    $Query="SELECT carton.CTNId,ppcustomer.CustName, JobNo,CTNOrderDate,CTNStatus,ProductQTY,JobType,CTNFinishDate,CTNQTY,
    carton.Ctnp1,carton.Ctnp2,carton.Ctnp3,carton.Ctnp4,carton.Ctnp5,carton.Ctnp6,carton.Ctnp7  ,carton.CTNType, 
    CTNUnit,CTNColor, ProductName ,CTNStatus,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,ProductQTY,
    designinfo.DesignImage, CFluteType ,  used_paper.reel, designinfo.DesignCode1 ,designinfo.DesignImage , ProductionPostponedDate , ProductionPostpondComment
    FROM carton 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
    INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
    LEFT JOIN used_paper ON designinfo.CaId= used_paper.carton_id 
    WHERE CTNStatus='Production Pending' AND JobNo != 'NULL' ORDER BY JobNo DESC";

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
                <svg width="50" height="50" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M502.625 121.375L390.625 9.375C384.625 3.375 376.484 0 368 0H144C135.516 0 127.375 3.375 121.375 9.375L9.375 121.375C3.375 127.375 0 135.516 0 144V368C0 376.484 3.375 384.625 9.375 390.625L121.375 502.625C127.375 508.625 135.516 512 144 512H368C376.484 512 384.625 508.625 390.625 502.625L502.625 390.625C508.625 384.625 512 376.484 512 368V144C512 135.516 508.625 127.375 502.625 121.375ZM368 239.996V351.996C368 387.344 333.738 416 298.391 416H251.836C221.531 416 193.832 398.879 180.281 371.775L170.39 351.997L129.566 256.739C125.539 247.337 129.535 236.426 138.679 231.852C147.589 227.399 161.226 230.446 166.503 238.891L192 275.195V239.996V111.996C192 103.16 199.164 95.996 208 95.996C216.836 95.996 224 103.16 224 111.996V231.996C224 236.414 227.582 239.996 232 239.996C236.418 239.996 240 236.414 240 231.996V79.996C240 71.16 247.164 63.996 256 63.996C264.836 63.996 272 71.16 272 79.996V231.996C272 236.414 275.582 239.996 280 239.996C284.418 239.996 288 236.414 288 231.996V111.996C288 103.16 295.164 95.996 304 95.996C312.836 95.996 320 103.16 320 111.996V239.996V247.996C320 252.414 323.582 255.996 328 255.996C332.418 255.996 336 252.414 336 247.996V239.996V159.996C336 151.16 343.164 143.996 352 143.996C360.836 143.996 368 151.16 368 159.996V239.996V239.996Z" fill="#FFCA03"/>
                </svg> Pended Jobs 
            </h3>
            <div class= "mt-1">
                <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                    </svg>
                </a>
                <a class="btn btn-outline-warning text-dark" data-bs-toggle="collapse" href="#colapse1" role="button" aria-expanded="false"  > 
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
                    <th title="Postpond Date" >P.Date</th> 
                    <th title="Postpond Comment" >Reason</th>
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
                            <td><?php if($Rows['CTNStatus'] == 'Production Pending' ) echo "<span class = 'badge bg-warning'>Pended</span>"; ?></td>
                            <td><?="<span class = 'badge' style = 'background-color:#121212;'>" . Carbon::createFromTimeStamp(strtotime( $Rows['ProductionPostponedDate'] ) , 'Asia/Kabul')->diffForHumans() . "</span>";?></td>
                            <td><?=$Rows['ProductionPostpondComment']?></td>
                            <td> 
                                <a href="ChangeCartonStatusProduction.php?CTNId=<?=$Rows['CTNId']?>&Production=Continue&Redirect=NewJobs" class= "btn btn-outline-success btn-sm" onclick = "alert('Are You Sure To Un Postpond The This Job')" > 
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.5 14.584V7.41601C8.50015 7.32632 8.52442 7.23833 8.57026 7.16125C8.61611 7.08417 8.68184 7.02084 8.76057 6.97789C8.83931 6.93495 8.92814 6.91397 9.01777 6.91716C9.1074 6.92034 9.19452 6.94758 9.27 6.99601L14.846 10.579C14.9166 10.6242 14.9747 10.6865 15.0149 10.7601C15.0552 10.8336 15.0763 10.9162 15.0763 11C15.0763 11.0839 15.0552 11.1664 15.0149 11.2399C14.9747 11.3135 14.9166 11.3758 14.846 11.421L9.27 15.005C9.19452 15.0534 9.1074 15.0807 9.01777 15.0839C8.92814 15.087 8.83931 15.0661 8.76057 15.0231C8.68184 14.9802 8.61611 14.9168 8.57026 14.8398C8.52442 14.7627 8.50015 14.6747 8.5 14.585V14.584Z" fill="#1FE087"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 1.5C8.48044 1.5 6.06408 2.50089 4.28249 4.28249C2.50089 6.06408 1.5 8.48044 1.5 11C1.5 13.5196 2.50089 15.9359 4.28249 17.7175C6.06408 19.4991 8.48044 20.5 11 20.5C13.5196 20.5 15.9359 19.4991 17.7175 17.7175C19.4991 15.9359 20.5 13.5196 20.5 11C20.5 8.48044 19.4991 6.06408 17.7175 4.28249C15.9359 2.50089 13.5196 1.5 11 1.5V1.5ZM0 11C0 4.925 4.925 0 11 0C17.075 0 22 4.925 22 11C22 17.075 17.075 22 11 22C4.925 22 0 17.075 0 11Z" fill="#1FE087"/>
                                </svg> Continue Job</a>
                            </td>

                        </tr>
                    <?php 
                    }
                ?>
                <tr>
                    <td colspan = 6  class = "text-center" > <strong> Total Quantity </strong></td>
                    <td> <strong><?=number_format($Total_OQ)?></strong> </td>
                    <td colspan = 5 ></td>
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




