<?php   require_once '../App/partials/Header.inc';  
    if (filter_has_var(INPUT_GET, 'id') ) 
    {
        $ID = $Controller->CleanInput($_GET['id']);
        if (filter_has_var(INPUT_GET, 'ProductName') ) 
        {
            $ProductName = $Controller->CleanInput($_GET['ProductName']);
        }

        // YOU SHOULD CHANGE IT TO INNER JOIN ON DEPLOYMENT 

        $Query="SELECT  carton.ProductName ,  carton.CTNOrderDate ,   carton.JobNo ,
         CONCAT(  carton.CTNLength, ' x ' ,carton.CTNWidth, ' x ', carton.CTNHeight ) AS Size , 
        carton.JobType, 
        carton.CTNUnit, carton.PexchangeUSD , carton.CtnCurrency,  carton.GrdPrice,  carton.CTNQTY,    carton.CTNPrice, carton.ReceivedAmount, 
         carton.CTNStatus , designinfo.DesignCode1 ,designinfo.DesignImage , carton.FinalTotal , `Ctnp1`, `Ctnp2`, `Ctnp3`, Ctnp4,Ctnp5,Ctnp6, Ctnp7,PaperP1,PaperP2,PaperP3,PaperP4,PaperP5,PaperP6, PaperP7 , CTNType 
        FROM carton 
        LEFT JOIN designinfo ON designinfo.CaId = carton.CTNId 
        WHERE carton.ProductName  = ? AND JobNo != 'NULL' ORDER BY CTNId DESC";

// SELECT carton.CTNId  , ppcustomer.CustName,JobNo,CTNOrderDate,CTNStatus,CTNStatusDate,CTNQTY,CTNUnit,ProductName,CONCAT( CTNLength , ' x ', CTNWidth , ' x ' , CTNHeight ) AS Size ,
//                       CTNUnit,CTNColor,ProductQTY,CTNPaper,CTNPrice, SUM(`CTNQTY`) AS MonthlyUsage, GrdPrice, 
// `Ctnp1`, `Ctnp2`, `Ctnp3`, Ctnp4,Ctnp5,Ctnp6, Ctnp7,PaperP1,PaperP2,PaperP3,PaperP4,PaperP5,PaperP6, PaperP7, 
//                       PexchangeUSD,CtnCurrency,DesignImage, DesignId ,DesignCode1 ,CTNType, MAX(CTNId),CTNFinishDate,PolyId , DieId  
//                       FROM `carton` inner JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 left JOIN designinfo ON designinfo.CaId = carton.CTNId 
        $ProductRows = $Controller->QueryData($Query , [$ProductName]);
    }  
    else die("ID Not Found, This incident will be reported! ");
?>
<style>
   .search{
       position: relative;
       box-shadow: 0 0 40px rgba(51, 51, 51, .1);
       }

       .search input{
        height: 50px;
        text-indent: 35px;
        border: 2px solid #d6d4d4;
       }
       .search input:focus{

        box-shadow: none;
        border: 2px solid #0d6efd;
       }    

       .search .fa-search{
        position: absolute;
        top: 11px;
        left: 16px;
        color:gray;
        -moz-transform: scale(-1, 1);
        -webkit-transform: scale(-1, 1);
        -o-transform: scale(-1, 1);
        -ms-transform: scale(-1, 1);
        transform: scale(-1, 1);
       }

</style>
<div class="m-3">
    <div class="card mb-3  ">
        <div class="card-body ">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-8 d-flex justify-content-start">
                        <div class = "me-3 my-2">
                            <a class= "btn btn-outline-primary  " href="CustomerProfile.php?id=<?=$ID?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                                </svg>
                            </a>  
                        </div>

                        <div >
                            <strong  class= "h2 " style = "color:#FA8b09;" > <?php echo isset($ProductName) ? $ProductName : '' ?>      </strong>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                    <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                    <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                Product History  
                            </div>
                        </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-8  my-2" >
                    <div class="search ">
                        <i class="fa-search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </i>
                        <input type="text" class="form-control" id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'OrderHistoryTable' )">
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <div class="card  ">
    <div class="card-body table-responsive ">
    <table class="table " id = "OrderHistoryTable" >
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Job No </th>
                <th> Size <span style = "font-size:10px"> (L x W x H) mm  </span>  </th>
                <th> Used Paper </th>
                <th> Type </th>
                <th class="text-start"> Design Code</th>
                <th class="text-end"> Ex-Rate</th>
                <th class="text-end"> Grade </th>
                <th class="text-end"> Order QTY</th>
                <th class="text-end"> Unit Price</th>
                <th class="text-end"> Total Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($ProductRows->num_rows > 0) { $count = 1 ;
            $OrderQTYTotal = 0 ; $ReceivedAmountTotal = 0 ; 
            while ($rows = $ProductRows->fetch_assoc())   : ?>  
                <tr>
                    <td><?=$count++ ?></td>
                    <td> <?= $rows['CTNOrderDate']; ?></td>
                    <td> <?= $rows['JobNo']; ?></td>
                    <td><?=$rows['Size']; ?></td>
                    <td> 
                    
                    <?php
                    $arr = []; 
                    for ($index=1; $index <= 7 ; $index++) { 
                      if(empty($rows['Ctnp'.$index])) continue; 
                      $arr[] = $rows['Ctnp'.$index] . ":" . $rows['PaperP'.$index];   
                    } 
                    $arr = array_count_values($arr);
                    foreach ($arr as $key => $value) echo $key . ' '; 
                    echo "<span style='font-size:13px; color:#ff6600;'> - ". $rows['CTNType'] ." Ply </span>  ";

                   
                ?>                    
             
                     
                </td>
                    <td><?= $rows['CTNUnit']; ?></td>
                    <td class = " align-item-center text-start" >
                    <?php
                        if(isset($rows['DesignCode1']) && !empty($rows['DesignCode1']) )  { ?>
                        <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                        href="../Design/ShowDesignImage.php?Url=<?= $rows['DesignImage']?>&ProductName=<?= $rows['ProductName']?>" >
                            <?php   echo '<span class = "text-success" >'. $rows['DesignCode1'] . '</span>';  ?>  
                        </a>
                        <?php }  else {
                            echo '<span class = "text-danger" >N/A</span>';
                        } ?>
                    </td>    
                    <td class = "text-end" ><?= $rows['PexchangeUSD']; ?></td>
                    <td class = "text-end" ><?php echo number_format($rows['GrdPrice'],2); ?></td>
                    <td class = "text-end"><?php echo number_format( $rows['CTNQTY']);  $OrderQTYTotal += $rows['CTNQTY']; ?></td>
                    <td class = "text-end"> <?php echo number_format($rows['CTNPrice'],2);?> <span class="badge bg-warning"><?= $rows['CtnCurrency']; ?></span></td>
                    <td class = "text-end" ><?php echo number_format($rows['FinalTotal']); $ReceivedAmountTotal += $rows['FinalTotal'];?></td>
                    <td>  <?=$rows['CTNStatus']; ?> </td>
                </tr>
            <?php endwhile;  # while loop ?>
        <tr>
            <td colspan = "8" class  = "text-center fw-bold" >Total </td>
            <td colspan = "3" class = "text-center ps-5" ><strong> <?php echo number_format($OrderQTYTotal);  ?> </strong></td>
            <td class = "fw-bold text-end" ><?=number_format($ReceivedAmountTotal); ?></td>
            <td></td>
        </tr>

        <?php } # END OF IF 
            else echo "<tr> <td colspan = '12' class = 'text-center'> NO RECORD FOUND <td></tr> "; 
        ?>
    </tbody>
    </table>
    </div><!-- END OF CARD-BODY  -->
    </div><!--  END of card  -->

    <script>
        function search(InputId ,tableId ) {
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
    </script>
</div>
<?php  require_once '../App/partials/Footer.inc'; ?>


 

