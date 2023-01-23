<?php
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';
$Data=1;

if(isset($_GET['CPid']))
{
    $CPid=$_GET['CPid'];
    $Data=$_GET['Polymer'];
 
    $Polymer=$Controller->QueryData("SELECT carton.CTNId, carton.CTNType, carton.JobNo, carton.CTNQTY, carton.CTNUnit
    ,carton.ProductName, carton.ProductQTY, carton.PolyId, carton.DieId, ppcustomer.CustName, designinfo.DesignImage, designinfo.DesignCode1, 
    cpolymer.Psize,cpolymer.PColor,cartonproduction.ProDate FROM carton INNER JOIN designinfo ON designinfo.CaId=carton.CTNId INNER JOIN cpolymer ON cpolymer.CPid=carton.PolyId INNER JOIN ppcustomer 
    ON ppcustomer.CustId=carton.CustId1 INNER JOIN cartonproduction ON cartonproduction.CtnId1=carton.CTNId WHERE PolyId = ? AND JobNo!='NULL' ",[$CPid]);
}

if(isset($_GET['CDieId']))
{
    $CDieId=$_GET['CDieId']; 
    $Data=$_GET['Die'];
    $Die=$Controller->QueryData("SELECT carton.CTNId, carton.CTNType, carton.JobNo, carton.CTNQTY, carton.CTNUnit,
    carton.CTNColor ,carton.ProductName, carton.ProductQTY, carton.DieId, ppcustomer.CustName,
    cdie.CDSize,cartonproduction.ProDate,cdie.Scatch,cdie.DieCode FROM carton  INNER JOIN cdie ON cdie.CDieId =carton.DieId INNER JOIN ppcustomer 
    ON ppcustomer.CustId=carton.CustId1 INNER JOIN cartonproduction ON cartonproduction.CtnId1=carton.CTNId WHERE DieId = ? AND JobNo!='NULL' ",[$CDieId]);

}

 
?>

 
<div class="card m-3 ">
  <div class="card-body d-flex justify-content-between">
        <h3 class="my-1"> 
            <a class="btn btn-outline-primary me-3" href="PolymerList.php?Data=<?=$Data?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                </svg>
            </a>
            <?php if(isset($_GET['CPid'])){ echo " Polymer Usage "; }
                  elseif(isset($_GET['CDieId'])){ echo " Die Usage ";  } 
            ?>
  
        </h3>  
        <span class="badge bg-info fw-bold fs-5  pt-3">
            <?php if(isset($_GET['CPid'])){ echo "Polymer No : ".$_GET['CPid']; }
                    elseif(isset($_GET['CDieId'])){ echo "Die No : ".$_GET['CDieId']; } 
            ?>
        </span>  
  </div>
</div>

<div class="card m-3 shadow">
    <div class="card-body">
        <table class="table table-responsive">
            <thead>
                <tr class="table-info">
                    <th>#</th>
                    <th>Production Date</th>
                    <th>JobNo</th>
                    <th title="Company Name">C.Name</th>
                    <th>Product Name</th>
                    <?php if(isset($_GET['CPid'])) {?> <th>Polymer Size</th> <?php }elseif(isset($_GET['CDieId'])) {?> <th>Die Size</th> <?php } ?>
                    <th>Type</th>
                    <th>Color</th>
                    <th>Image</th>
                    <th>Order QTY</th>
                    <th>Produced QTY</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $Count=1;$ProducedQTY=0;
                    if(isset($_GET['CPid']))
                    {
                        while($Rows=$Polymer->fetch_assoc())
                        {?>
                            <tr>
                                <td><?=$Count?></td>
                                <td><?=$Rows['ProDate']?></td>
                                <td><?=$Rows['JobNo']?></td>
                                <td><?=$Rows['CustName']?></td>
                                <td><?=$Rows['ProductName']?></td>
                                <td><?=$Rows['Psize']?></td>
                                <td><?=$Rows['CTNUnit']?></td>
                                <td><?=$Rows['PColor']?></td>
                                <td class = " align-item-center    " >
                                <?php if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1']) )  { ?>
                                    <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                    href="ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                                        <?php   echo '<span class = "text-success" >'. $Rows['DesignCode1'] . '</span>';  ?>  
                                    </a>
                                    <?php }  else {
                                        echo '<span class = "text-danger" >N/A</span>';
                                    } ?>
                                </td>
                                <td><?=$Rows['CTNQTY']?></td>
                                <td><?=$Rows['ProductQTY']?></td>
                            </tr>
                        <?php
                                $ProducedQTY=$ProducedQTY+$Rows['ProductQTY'];
                                $Count++; 
                        }
                ?>
                            <tr>
                                <td colspan='10' class="text-center fw-bold">Total</td>
                                <td><?=$ProducedQTY?></td>
                            </tr>
                <?php
                    }
                    elseif(isset($_GET['CDieId']))
                    {
                        while($Row=$Die->fetch_assoc())
                        {?>
                            <tr>
                                <td><?=$Count?></td>
                                <td><?=$Row['ProDate']?></td>
                                <td><?=$Row['JobNo']?></td>
                                <td><?=$Row['CustName']?></td>
                                <td><?=$Row['ProductName']?></td>
                                <td><?=$Row['CDSize']?></td>
                                <td><?=$Row['CTNUnit']?></td>
                                <td><?=$Row['CTNColor']?></td>
                                <td class = " align-item-center    " >
                                <?php if(isset($Rows['DieCode']) && !empty($Rows['DieCode']) )  { ?>
                                    <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                    href="ShowDesignImage.php?Scatch=<?= $Rows['Scatch']?>&ProductName=<?= $Rows['ProductName']?>" >
                                        <?php   echo '<span class = "text-success" >'. $Rows['DieCode'] . '</span>';  ?>  
                                    </a>
                                    <?php }  else {
                                        echo '<span class = "text-danger" >N/A</span>';
                                    } ?>
                                </td>
                                <td><?=$Row['CTNQTY']?></td>
                                <td><?=$Row['ProductQTY']?></td>
                               
                            </tr>
                        <?php
                                $ProducedQTY=$ProducedQTY+$Rows['ProductQTY'];
                                $Count++; 
                        }
                ?>
                            <tr>
                                <td colspan='10' class="text-center fw-bold">Total</td>
                                <td><?=$ProducedQTY?></td>
                            </tr>
                <?php

                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php  require_once '../App/partials/Footer.inc'; ?>