<?php 
    ob_start(); 
    require_once '../App/partials/Header.inc'; 
    
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/DESIGN_DEPT';
    if(!in_array( $Gate['VIEW_FILM_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
        header("Location:index.php?msg=You are not authorized this page!" );
    }


    require_once '../App/partials/Menu/MarketingMenu.inc';
    require '../Assets/Carbon/autoload.php'; 
    use Carbon\Carbon;

    

 
    $DataRows=$Controller->QueryData('SELECT   `CTNId`,ppcustomer.CustName, CTNUnit, CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,`CTNOrderDate`, `CTNStatus`, `CTNQTY`,`ProductName`,
    ppcustomer.CustMobile, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note, 
    offesetp, designinfo.Alarmdatetime,designinfo.DesignStatus, designinfo.DesignImage, film_status , film_deadline , film_assigned_to,film_start_date, 
    designinfo.DesignCode1 , designinfo.CaId , designinfo.DesignerName1 ,designinfo.DesignStartTime ,designinfo.DesignId  FROM `carton` 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
    LEFT JOIN designinfo ON designinfo.CaId=carton.CTNId  
    WHERE CTNStatus="Film" order by CTNOrderDate DESC',[]);
?>  
  
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <?php if(isset($_GET['msg']) && !empty($_GET['msg'])) { ?>
        <div class="alert alert-<?=$_GET['class']?>  alert-dismissible fade show shadow" role="alert">
            <strong>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>  Information</strong> <?= $_GET['msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
</div>

<div class="card m-3" >
  <div class="card-body d-flex justify-content-between shadow">
      <h3 class="m-0 p-0"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-film" viewBox="0 0 16 16">
                <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm4 0v6h8V1H4zm8 8H4v6h8V9zM1 1v2h2V1H1zm2 3H1v2h2V4zM1 7v2h2V7H1zm2 3H1v2h2v-2zm-2 3v2h2v-2H1zM15 1h-2v2h2V1zm-2 3v2h2V4h-2zm2 3h-2v2h2V7zm-2 3v2h2v-2h-2zm2 3h-2v2h2v-2z"/>
            </svg>   Film Center
      </h3>
    </div>
</div>




<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between ">
    <table class= "table " id = "JobTable" >
          <thead>
              <tr class="table-info">
                    <th>#</th>
                    <th>JobNo</th>
                    <th title="Company Name">C.Name</th> 
                    <th title="Product Name">P.Name</th>
                    <th>Size (LxWxH) cm</th>
                    <th>Color</th>
                    <th title="Product Type">Type</th>
                    <th>Status</th>
                    <th>Deadline</th>
                  <th>OPS</th>
              </tr>
          </thead>
          <tbody>
          <?php 
           function isPast( $date ){ 
            return  Carbon::now()->startOfDay()->gte($date);
          }
          $Count = 1; 
            while($Rows=$DataRows->fetch_assoc()) {    ?>
                <tr>
                  <td><?=$Count?> </td>
                  <td><?=$Rows['JobNo']?></td>
                  <td><?=$Rows['CustName']?></td>
                  <td><?=$Rows['ProductName']?></td>
                  <td><?=$Rows['Size']?></td>
                  <td><?=$Rows['CTNColor']?></td>
                  <td><?=$Rows['CTNUnit']?></td>
                  <td><?php 
                   if($Rows['film_status'] == 'Assigned'){ 
                    echo "<span class = 'badge' style = 'background-color:#20c997 '>" . $Rows['film_status'] .' To '. $Rows['film_assigned_to'] .  "</span>";
                   }
                   else if($Rows['film_status'] == 'Proccess'){ 
                    $start_date =  Carbon::create( Carbon::parse($Rows['film_start_date'])->format('Y-m-d H:i:s')  , 'Asia/Kabul')->diffForHumans(); 
                    echo "<span class = 'badge' style = 'background-color:#20c997 '>" . $Rows['film_assigned_to']  . " Started Working on it : ". $start_date . "</span>";
                   }

                // echo $Rows['film_start_date']; 
                  ?></td>
                  <td>
                    <?php
                        if(isset($Rows['film_deadline']) && !empty($Rows['film_deadline'])) {
                            $a =  Carbon::create( Carbon::parse($Rows['film_deadline'])->format('Y-m-d H:i:s')  , 'Asia/Kabul')->diffForHumans(); 
                            echo "<span class = 'badge' style = 'background-color:#20c997 '>" . $a . "</span>";
                        }
                    ?>  
                  </td>
                  <td>
                    <?php  if(in_array( $Gate['VIEW_FILM_OPS_BUTTONS'] , $_SESSION['ACCESS_LIST']  )) { ?>
                        <?php  if($Rows['film_status'] == 'Assigned'){ ?>
                            <form action="ProcessFilm.php" method="post">
                                <input type="hidden" name="DesignId" value = "<?=$Rows['DesignId']?>">
                                <button class="btn btn-warning btn-sm " type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                    </svg>
                                    Proccess
                                </button> 
                            </form>
                        <?php  } else if($Rows['film_status'] == 'Proccess'){ ?>
                            <form action="ManageFilmStatus.php" method="post">
                                <input type="hidden" name="DesignId" value = "<?=$Rows['DesignId']?>">
                                <input type="hidden" name="CTNId" value = "<?=$Rows['CTNId']?>">
                                <button class="btn btn-outline-success btn-sm " type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                    Mark as Complete
                                </button>
                            </form>
                        <?php } else { ?>
                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" 
                                onclick = "assign_data_to_offcanvas(`<?= $Rows['DesignId']?>`); " >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-film" viewBox="0 0 16 16">
                                    <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm4 0v6h8V1H4zm8 8H4v6h8V9zM1 1v2h2V1H1zm2 3H1v2h2V4zM1 7v2h2V7H1zm2 3H1v2h2v-2zm-2 3v2h2v-2H1zM15 1h-2v2h2V1zm-2 3v2h2V4h-2zm2 3h-2v2h2V7zm-2 3v2h2v-2h-2zm2 3h-2v2h2v-2z"/>
                                </svg> Assign
                            </button> 
                        <?php } ?>
                    <?php } ?> 

                  </td>
                </tr>
                  <?php
              $Count++;
            }        
          ?>
                  </tbody>
      </table>

  </div>
</div>
 
 

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasRightLabel">Polymer Film Form </h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
     <form action="AssignFilm.php" method="post">
        <input type="hidden" name="DesignId" id = "DesignId">

        <div class="form-floating mb-3">
            <select class="form-select" name="film_assigned_to" id="film_assigned_to" required >
                <option selected>Select Employee</option>
                <option value="Naweedullah">Naweedullah</option>
                <option value="Fawad">Fawad</option>
            </select>
            <label for="film_assigned_to">Assign To</label>
        </div>

        <div class="form-floating mb-3">
            <input  type="datetime-local" name="film_deadline"  class="form-control" id="film_deadline" placeholder="Deadline">
            <label for="film_deadline">Deadline</label>
        </div>
        <div class="d-grid gap-2   ">
            <button type="submit" class = "btn btn-outline-primary d-block " >Assign</button>
        </div>
     </form>
  </div>
</div>
<script>
    function assign_data_to_offcanvas(DesignId){
        document.getElementById('DesignId').value = DesignId; 
    }
</script>
<?php  require_once '../App/partials/Footer.inc'; ?>





          