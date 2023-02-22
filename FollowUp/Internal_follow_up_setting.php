<?php require_once '../App/partials/Header.inc';  ?>
<?php require_once '../App/partials/Menu/MarketingMenu.inc';


 




$DataRows = $Controller->QueryData('SELECT * FROM internal_followup_setting', []); 
?>  
 



<?php if(isset($_GET['msg']) && !empty($_GET['msg']))  {
          echo' <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                  <strong>Attention: </strong>'. $_GET['msg'] .' 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'; 
      }  
?>
  <div class="m-3">
    <div class="card " style = "background-color:# ;" >
      <div class="card-body d-flex justify-content-between shadow">
          <h3 class="m-0 p-0">Internal Follow Up Center</h3>
        </div>
    </div>
    </div>


  <div class="m-3 d-flex justify-content-center">
    <div class="card " style = "width:700px; " >
      <div class="card-body  shadow">

        <table class="table table-bordered border-dark m-0 " >
            <thead>
                <tr class = "fw-bold" >
                    <td style = "width:5%; ">#</td>
                    <td style = "width:45%; ">Department</td>
                    <td style = "width:50%; " >Setting (DAY - HOUR - MINUTE)</td>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1 ;  while ($Data = $DataRows->fetch_assoc()) {  ?>
                <tr>
                    <td><?= $counter++; ?></td>
                    <td><?=$Data['department']?></td>
                    <td>
                        <div class="input-group">
                            <input type="text" value = "<?=$Data['day']?>" class="form-control form-control-sm" >
                            <input type="text" value = "<?=$Data['hour']?>" class="form-control form-control-sm" >
                            <input type="text" value = "<?=$Data['minute']?>" class="form-control form-control-sm" >
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>

<?php  require_once '../App/partials/Footer.inc'; ?>
