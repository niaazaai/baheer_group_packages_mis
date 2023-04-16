<?php  ob_start(); 
require_once '../App/partials/Header.inc';  
require_once '../App/partials/Menu/MarketingMenu.inc';
require '../Assets/Carbon/autoload.php'; 
 





if(isset($_POST['Form']) && !empty($_POST['Form']) && isset($_POST['To']) && !empty($_POST['To']) )
{
    $From=$_POST['Form'];
    $To=$_POST['To'];

    $SQL="SELECT `RepId`, `RepCartonId`, `FinanceStart`, `FinanceEnd`, `FinanceComment`, `DesignStart`, `DesignEnd`, `DesignComment`, `ArchiveStart`, 
    `ArchiveEnd`, `ArchiveComment`, `ProductionStart`, `ProductionEnd`, `ProductionComment`, `PPStart`, `PPEnd`, `PPComment`, `WarehouseStart`, `WarehouseEnd`, 
    `WarehouseComment`, ppcustomer.CustName,CTNType,ProductQTY, CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), 'x', FORMAT(CTNHeight/ 10,1) ) AS Size, carton.ProductName, carton.CTNOrderDate, carton.CTNUnit, 
    carton.CTNColor, carton.CTNQTY, carton.JobNo FROM `productionreport` INNER JOIN carton ON carton.CTNId=productionreport.RepCartonId 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 where carton.JobNo !='NULL' AND CTNOrderDate BETWEEN ? AND ?";

    $DataRows=$Controller->QueryData($SQL,[$From,$To]);

}
else
{
    $SQL="SELECT `RepId`, `RepCartonId`, `FinanceStart`, `FinanceEnd`, `FinanceComment`, `DesignStart`, `DesignEnd`, `DesignComment`, `ArchiveStart`, 
    `ArchiveEnd`, `ArchiveComment`, `ProductionStart`, `ProductionEnd`, `ProductionComment`, `PPStart`, `PPEnd`, `PPComment`, `WarehouseStart`, `WarehouseEnd`, 
    `WarehouseComment`, ppcustomer.CustName,CTNType,ProductQTY, CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), 'x', FORMAT(CTNHeight/ 10,1) ) AS Size, carton.ProductName, carton.CTNOrderDate, carton.CTNUnit, 
    carton.CTNColor, carton.CTNQTY, carton.JobNo FROM `productionreport` INNER JOIN carton ON carton.CTNId=productionreport.RepCartonId 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 where carton.JobNo !='NULL' AND YEARWEEK(`CTNOrderDate`, 1) = YEARWEEK(CURDATE(), 1)";
     $DataRows=$Controller->QueryData($SQL,[]);
}




?>



<div class="card m-3">
    <div class="card-body ">
        <h3 class="p-0 m-0">General Report</h3>
    </div>
</div>


<form action="" method="POST">
    <div class="card m-3 shadow">
        <div class="card-body">
            <div class="row"> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    <input type="hidden" name="CustIdOne" id="CustIdOne" value="<?php if(isset($_POST['CustId'])){ echo $_POST['CustId'];}else {echo '';}?>">
                    <div class="row"> 
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="" class="fw-bold">From</label>
                            <input type="date" name="Form" id="From" class="form-control" >
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="" class="fw-bold">To</label>
                            <input type="date" name="To" id="To" class="form-control" onchange="this.form.submit()">
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex justify-content-end"> 
                            <input type="text" class="form-control"  id = "Search_input" placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
                        </div>
                    </div> 
                </div> 
            </div>
        </div>                
    </div>
</form>

 

<div class="card m-3 shadow">
    <div class="card-body">
        <table class= "table " id = "JobTable" >
            <thead>
                <tr class="table-info "  >
                    <th>#</th>
                    <!-- <th title="Company Name">C.Name</th>        -->
                    <th>Order Date</th> 
                    <th>Job No</th>
                    <th title="Product Name">Description</th>    
                    <th>Order QTY</th>
                    <th>Produced.QTY</th>
                    <th>Finance</th>
                    <th>Design</th>
                    <th>Archive</th>
                    <th>Production</th>
                    <th>Warehouse</th>
                    <th>printing Press</th>
                    <th>Total Time</th> 
                </tr>
            </thead>
            <tbody>
                <?php  $Count=1; 
                    if(isset($_POST['Form']) && !empty($_POST['Form']) && isset($_POST['To']) && !empty($_POST['To']) )
                    {
                        while($Rows=$DataRows->fetch_assoc())
                        {   
                            $idd=$Rows['RepId']; 
                            $dteStartf = strtotime($Rows['FinanceStart']);
                            $dteEndf = strtotime($Rows['FinanceEnd']);
                            $dteDiff =$dteEndf-$dteStartf;
                            $dteStartd=strtotime($Rows['DesignStart']);
                            $dteEndd=strtotime($Rows['DesignEnd']);
                            $dtedifd=$dteEndd-$dteStartd;
                            $dteStartP=strtotime($Rows['ProductionStart']);
                            $dteEndP=strtotime($Rows['ProductionEnd']);
                            $dtedifP=$dteEndP-$dteStartP;
                            $dteStartw=strtotime($Rows['WarehouseStart']);
                            $dteEndw=strtotime($Rows['WarehouseEnd']);
                            $dtedifw=$dteEndw-$dteStartw;
                            $dteStartprint=strtotime($Rows['PPStart']);
                            $dteEndprint=strtotime($Rows['PPEnd']);
                            $dtedifprint=$dteEndprint-$dteStartprint;
                            $dteStartarchive=strtotime($Rows['ArchiveStart']);
                            $dteEndarchive=strtotime($Rows['ArchiveEnd']);
                            $dtedifarchive=$dteEndarchive-$dteStartarchive; 
                            $dteStartAll=strtotime($Rows['FinanceStart']);
                            $dteEndAll=strtotime($Rows['ProductionEnd']);
                            $dtedifAll=$dteEndAll-$dteStartAll;
                        ?>
                        <tr>
                            <td><?=$Count?></td>
                            <!-- <td><?=$Rows['CustName']?></td> -->
                            <td><?=$Rows['CTNOrderDate']?></td>
                            <td><?=$Rows['JobNo']?></td>
                            <td> <?=$Rows['ProductName'].' ( '.$Rows['Size'].' cm) '.$Rows['CTNType'].' Ply'.' - '.$Rows['CTNUnit'].' '.$Rows['CTNColor'] ?> </td> 
                            <td><?=$Rows['CTNQTY']?></td> 
                            <td><?=$Rows['ProductQTY']?></td>
                            <td>
                                <?php   
                                    $days=floor($dteDiff/86400);
                                    $hour=floor($dteDiff/3600) % 24;
                                    $minutes=floor($dteDiff/60) % 60;
                                    $seconds=$dteDiff % 60;
                                    if ($days<1)  {  echo "$hour h $minutes m"; }
                                    else if ($hour<1) {  echo "$minutes m"; }
                                    else { echo"$days D $hour H $minutes m";  }

                                ?> 
                            </td>
                            <td>
                                <?php
                                    $days=floor($dtedifd/86400);
                                    $hour=floor($dtedifd/3600) % 24;
                                    $minutes=floor($dtedifd/60) % 60;
                                    $seconds=$dtedifd % 60;
                                    if ($days<1)  {  echo "$hour h $minutes m"; }
                                    else if ($hour<1)  { echo "$minutes m";  }
                                    else  { echo"$days D $hour H $minutes m";  }
                                ?>
                            </td>
                           
                            <td> 
                                <?php
                                    $days=floor($dtedifarchive/86400);
                                    $hour=floor($dtedifarchive/3600) % 24;
                                    $minutes=floor($dtedifarchive/60) % 60;
                                    $seconds=$dtedifw % 60;
                                    if ($days<1) {  echo "$hour h $minutes m"; }
                                    else if ($hour<1)  {  echo "$minutes m"; }
                                    else {  echo"$days D $hour H $minutes m";  }
                                ?>
                            </td>

                            <td> 
                                <?php
                                    $days=floor($dtedifw/86400);
                                    $hour=floor($dtedifw/3600) % 24;
                                    $minutes=floor($dtedifw/60) % 60;
                                    $seconds=$dtedifw % 60;
                                    if ($days<1) {  echo "$hour h $minutes m";  }
                                    else if ($hour<1)   { echo "$minutes m"; }
                                    else {  echo"$days D $hour H $minutes m"; }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $days=floor($dtedifprint/86400);
                                    $hour=floor($dtedifprint/3600) % 24;
                                    $minutes=floor($dtedifprint/60) % 60;
                                    $seconds=$dtedifprint % 60;
                                    if ($days<1) { echo "$hour h $minutes m"; }
                                    else if ($hour<1)  { echo "$minutes m"; }
                                    else {  echo"$days D $hour H $minutes m";  }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $days=floor($dtedifP/86400);
                                    $hour=floor($dtedifP/3600) % 24;
                                    $minutes=floor($dtedifP/60) % 60;
                                    $seconds=$dtedifP % 60;
                                    if ($days<1) {  echo "$hour h $minutes m";  }
                                    else if ($hour<1)  {  echo "$minutes m"; }
                                    else {  echo"$days D $hour H $minutes m";  }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $days=floor($dtedifAll/86400);
                                    $hour=floor($dtedifAll/3600) % 24;
                                    $minutes=floor($dtedifAll/60) % 60;
                                    $seconds=$dtedifw % 60;
                                    if ($days<1)  {  echo "$hour h $minutes m"; }
                                    else if ($hour<1)  {   echo "$minutes m"; }
                                    else {  echo"$days D $hour H $minutes m"; }
                                ?>
                            </td> 
                        </tr>   
                        <?php
                            $Count++;
                        } 
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>


<script>

function search(InputId ,tableId)
      {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById(InputId);
          filter = input.value.toUpperCase();
          table = document.getElementById(tableId);
          tr = table.getElementsByTagName("tr");

          // Loop through all table rows, and hide those who don't match the search query
            for (i = 1; i < tr.length; i++) 
            {
                td = tr[i];
                if (td) 
                {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) 
                    {
                        tr[i].style.display = "";
                    } 
                    else 
                    {
                        tr[i].style.display = "none";
                    }
                }
            }
      }
</script>































<?php  require_once '../App/partials/Footer.inc'; ?>