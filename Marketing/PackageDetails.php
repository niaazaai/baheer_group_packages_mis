<?php



require_once '../App/partials/Header.inc'; 
    require_once 'InternalFollowUpController.php';
    if (isset($_GET) && !empty($_GET)   ) {

        $JobNo = (int) $_GET['JobNo'];
        if( !is_int($JobNo) || $JobNo == 0) {
            header("Location:InternalFollowUp.php");
        }
    } 
    else die('No Job Number Selected, Please Try again '); 

    $Query = "SELECT CTNId , JobNo ,  ProductName , FinanceStart , FinanceEnd , FinanceComment ,DesignStart , DesignEnd , DesignComment , ArchiveStart , ArchiveEnd , ArchiveComment , 
        ProductionStart , 	ProductionEnd , ProductionComment , ProQty , PPStart ,PPEnd ,PPComment ,WarehouseStart ,WarehouseEnd ,WarehouseComment 
        FROM carton
        JOIN productionreport  ON carton.CTNId = productionreport.RepCartonId
        JOIN cartonproduction ON carton.CTNId = cartonproduction.CtnId1
        WHERE JobNo = ? ";
    $Data  = $Controller->QueryData( $Query, [$JobNo] );
    
    $total_hours = 0;
    $total_minutes = 0;
    $total_seconds = 0;
    
    
    require_once '../App/partials/Menu/MarketingMenu.inc';  


?>
<style>
.strong-text {
    font-weight:bold; 
    font-size:20px;
}
</style>
 
<div class="card  m-3">
    <div class="card-body d-flex justify-content-between ">
        <h3>  <a class= "btn btn-outline-primary  " href="InternalFollowUp.php">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a>  Job Process Details  - ( <small style= "font-size:18px; color:#FA8b09;" id = "title" ></small>)  </h3> 
        <div >
                <div class="strong-text "  > <?= $JobNo?> </div>
                <div  >Job Number</div>
        </div>
    </div>
</div>

 
 
                   
<div class="card  m-3">
    <div class="card-body table-responsive">
                <table class="table"  id = "main-table"  >
                    <thead>
                        <tr >
                            <th>Date</th> 
                            <th>Unit</th>
                            <th>Produced Quantity</th> 
                            <th>Start</th> 
                            <th>End</th> 
                            <th>Time</th> 
                            <th>Comment</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                         while ($IFCData = $Data->fetch_assoc()) : ?>   
                            <span id = "ProductName" style = "display:none;" ><?= $IFCData['ProductName']  ?></span>
                        <tr>
                            <td><?= date("Y-m-d", strtotime($IFCData['FinanceStart']));  ?></td> 
                            <td>Finance</td> 
                            <td><?=$IFCData['ProQty'];  ?></td>
                            <td><?=date("H:i:s ", strtotime($IFCData['FinanceStart'])); ?></td> 
                            <td><?=date("H:i:s ", strtotime($IFCData['FinanceEnd']));  ?></td> 
                            <td><?php
                                    $dteStart = new DateTime($IFCData['FinanceStart']); $dteEnd   = new DateTime($IFCData['FinanceEnd']); $dteDiff  = $dteStart->diff($dteEnd);
                                    $total_hours += $dteDiff->h;
                                    $total_minutes += $dteDiff->i;
                                    $total_seconds += $dteDiff->s;
                                    print $dteDiff->format("%H:%I:%S");
                                ?>
                            </td> 
                            <td><?= $IFCData['FinanceComment']?></td> 
                        </tr>
                        <tr>
                            <td><?= date("Y-m-d", strtotime($IFCData['DesignStart']));  ?></td> 
                            <td>Design</td> 
                            <td><?=$IFCData['ProQty'];  ?></td>
                            <td><?=date("H:i:s ", strtotime($IFCData['DesignStart'])); ?></td> 
                            <td><?=date("H:i:s ", strtotime($IFCData['DesignEnd']));  ?></td> 
                            <td><?php
                                    $dteStart = new DateTime($IFCData['DesignStart']); $dteEnd   = new DateTime($IFCData['DesignEnd']); $dteDiff  = $dteStart->diff($dteEnd);
                                    $total_hours += $dteDiff->h;
                                    $total_minutes += $dteDiff->i;
                                    $total_seconds += $dteDiff->s;
                                    print $dteDiff->format("%H:%I:%S");
                                ?>
                            </td> 
                            <td><?= $IFCData['DesignComment']?></td> 
                        </tr>
                        <tr> 
                            <td><?= date("Y-m-d", strtotime($IFCData['ArchiveStart']));  ?></td> 
                            <td>Archive</td> 
                            <td><?=$IFCData['ProQty'];  ?></td>
                            <td><?=date("H:i:s ", strtotime($IFCData['ArchiveStart'])); ?></td> 
                            <td><?=date("H:i:s ", strtotime($IFCData['ArchiveEnd']));  ?></td> 
                            <td><?php
                                    $dteStart = new DateTime($IFCData['ArchiveStart']); $dteEnd   = new DateTime($IFCData['ArchiveEnd']); $dteDiff  = $dteStart->diff($dteEnd);
                                    $total_hours += $dteDiff->h;
                                    $total_minutes += $dteDiff->i;
                                    $total_seconds += $dteDiff->s;
                                    print $dteDiff->format("%H:%I:%S");
                                ?>
                            </td> 
                            <td><?= $IFCData['ArchiveComment']?></td> 
                        </tr>
                        <tr> 
                            <td><?= date("Y-m-d", strtotime($IFCData['ProductionStart']));  ?></td> 
                            <td>Production</td> 
                            <td><?=$IFCData['ProQty'];  ?></td>
                            <td><?=date("H:i:s ", strtotime($IFCData['ProductionStart'])); ?></td> 
                            <td><?=date("H:i:s ", strtotime($IFCData['ProductionEnd']));  ?></td> 
                            <td><?php
                                    $dteStart = new DateTime($IFCData['ProductionStart']); $dteEnd   = new DateTime($IFCData['ProductionEnd']); $dteDiff  = $dteStart->diff($dteEnd);
                                    $total_hours += $dteDiff->h;
                                    $total_minutes += $dteDiff->i;
                                    $total_seconds += $dteDiff->s;
                                    print $dteDiff->format("%H:%I:%S");
                                ?>
                            </td> 
                            <td><?= $IFCData['ProductionComment']?></td> 
                        </tr>
                        <tr> 
                            <td><?= date("Y-m-d", strtotime($IFCData['PPStart']));  ?></td> 
                            <td>Printing Press </td> 
                            <td><?=$IFCData['ProQty'];  ?></td>
                            <td><?=date("H:i:s ", strtotime($IFCData['PPStart'])); ?></td> 
                            <td><?=date("H:i:s ", strtotime($IFCData['PPEnd']));  ?></td> 
                            <td><?php
                                    $dteStart = new DateTime($IFCData['PPStart']); $dteEnd   = new DateTime($IFCData['PPEnd']); $dteDiff  = $dteStart->diff($dteEnd);
                                    $total_hours += $dteDiff->h;
                                    $total_minutes += $dteDiff->i;
                                    $total_seconds += $dteDiff->s;
                                    print $dteDiff->format("%H:%I:%S");
                                ?>
                            </td> 
                            <td><?= $IFCData['PPComment']?></td> 
                        </tr>
                        <tr> 
                            <td><?= date("Y-m-d", strtotime($IFCData['WarehouseStart']));  ?></td> 
                            <td>Warehouse</td> 
                            <td><?=$IFCData['ProQty'];  ?></td>
                            <td><?=date("H:i:s ", strtotime($IFCData['WarehouseStart'])); ?></td> 
                            <td><?=date("H:i:s ", strtotime($IFCData['WarehouseEnd']));  ?></td> 
                            <td><?php
                                    $dteStart = new DateTime($IFCData['WarehouseStart']); $dteEnd   = new DateTime($IFCData['WarehouseEnd']); $dteDiff  = $dteStart->diff($dteEnd);
                                    $total_hours += $dteDiff->h;
                                    $total_minutes += $dteDiff->i;
                                    $total_seconds += $dteDiff->s;
                                    print $dteDiff->format("%H:%I:%S");
                                ?>
                            </td> 
                            <td><?= $IFCData['WarehouseComment']?></td> 
                        </tr>
                        <tr> 
                            <td colspan = "5" style = "text-align:center;font-weight:bold " > Total Taken Time (HR)</td> 
                            <td colspan = "2" style = "font-weight:bold "><?php echo  $total_hours.":".$total_minutes.":".$total_seconds; ?></td> 
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
    </div>
</div>
<script>
     document.getElementById('title').innerHTML = document.getElementById('ProductName').innerText; 
</script>

<?php  require_once '../App/partials/Footer.inc'; ?>

