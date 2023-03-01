<?php require_once '../App/partials/Header.inc';    require_once '../App/partials/Menu/MarketingMenu.inc';

  if(isset($_POST['Day']))
  {
    $Id=$_POST['Id'];
    $Day=$_POST['Day'];
    $Update=$Controller->QueryData("UPDATE internal_followup_setting SET `day`= ? WHERE id = ?",[$Day,$Id]); 
  }

  if(isset($_POST['Hour']) )
  {
    $Id=$_POST['Id'];
    $Hour=$_POST['Hour'];
    $Update=$Controller->QueryData("UPDATE internal_followup_setting SET `hour`= ? WHERE id = ?",[$Hour,$Id]); 
  }

  if(isset($_POST['Minute']) )
  {
    $Id=$_POST['Id'];
    $Minute=$_POST['Minute'];
    $Update=$Controller->QueryData("UPDATE internal_followup_setting SET `minute`= ? WHERE id = ?",[$Minute,$Id]); 
  }

  $DataRows = $Controller->QueryData('SELECT * FROM internal_followup_setting', []); 
?>  
 



<?php if(isset($_GET['msg']) && !empty($_GET['msg']))  {
          echo' <div class="alert alert-'. $_GET['class'] .' alert-dismissible fade show m-3" role="alert">
                  <strong>Attention: </strong>'. $_GET['msg'] .' 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'; 
      }  
?>

  <div class="m-3">
    <div class="card " style = "background-color:# ;" >
      <div class="card-body d-flex justify-content-between shadow">
          <h3 class="m-0 p-0">
              <a class="btn btn-outline-primary btn-sm P-1 " href="index.php">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                  </svg>
              </a>
              Internal Follow Up Center</h3>
      </div>
    </div>
  </div>


  <div class="m-3 d-flex justify-content-center">
    <div class="card " style = "width:900px; " >
      <div class="card-body  shadow">

        <table class="table table-bordered border-dark m-0 " >
            <thead>
                <tr class = "fw-bold" >
                    <td style = "width:5%; ">#</td>
                    <td style = "width:25%; ">Department</td>
                    <td style = "width:70%; " >
                        <div class="input-group" style = "width:326px; " >
                              <input type="text"  readonly disabled value = "DAY" class="form-control form-control-sm me-2"  style = "width:100px;">
                              <input type="text"  readonly disabled value = "HOUR" class="form-control form-control-sm me-2" style = "width:100px;" >
                              <input type="text"  readonly disabled value = "MINUTE" class="form-control form-control-sm me-2" style = "width:100px;">
                        </div>

                    </td>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1 ;  while ($Data = $DataRows->fetch_assoc()) {  ?>
                <tr>
                    <td><?= $counter++; ?></td>
                    <td><?=$Data['department']?></td>
                    <td>
                        <div class="input-group">
                          <form action="" method="POST">
                              <input type="text" name="Day" id="Day" value = "<?=$Data['day']?>" class="form-control form-control-sm me-2"  style = "width:100px; "  onchange="this.form.submit()">
                              <input type="hidden" name="Id" value="<?=$Data['id']?>" >
                          </form>
                          <form action="" method="POST">
                              <input type="text" name="Hour" id="Hour" value = "<?=$Data['hour']?>" class="form-control form-control-sm me-2" style = "width:100px; " onchange="this.form.submit()">
                              <input type="hidden" name="Id" value="<?=$Data['id']?>">
                          </form>
                          <form action="" method="POST">
                              <input type="text" name="Minute" id="Minute" value = "<?=$Data['minute']?>" class="form-control form-control-sm me-2" style = "width:100px; " onchange="this.form.submit()">
                              <input type="hidden" name="Id" value="<?=$Data['id']?>">
                          </form>  
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
