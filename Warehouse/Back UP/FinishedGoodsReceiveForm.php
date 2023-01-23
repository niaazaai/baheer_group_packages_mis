<!-- This page has line with the button of (Process) Finished Goods Check List -->
<?php
ob_start(); 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;

if(isset($_REQUEST['CTNId']))
{
    $CTNId=$_REQUEST['CTNId']; $CustId=$_REQUEST['CustId'];
    $SQL="SELECT CTNId, ppcustomer.CustName, JobNo, CTNOrderDate , JobType,CTNStatus,ProductQTY,CTNFinishDate,CTNQTY,CTNUnit,CTNColor, ProductName , CTNStatus, ProductQTY FROM carton INNER JOIN ppcustomer 
          ON ppcustomer.CustId=carton.CustId1  WHERE  CTNId= ?";

    $DataRows=$Controller->QueryData($SQL,[$CTNId]);
    $Rows=$DataRows->fetch_assoc();
    $ReminingQTY=$Rows['CTNQTY']-$Rows['ProductQTY'];
}


if(isset($_POST['Save&submit']))
{
    $CTNId=$_REQUEST['CTNId'];
    $CustId=$_REQUEST['CustId'];
    $ProducedQTY=$_POST['ProducedQTY'];
    $SelectUnit=$_POST['SelectUnit'];
    $SelectStatus=$_POST['SelectStatus'];
    $TotalPlat=$_POST['TotalPlat'];
    $LineQTY=$_POST['LineQTY'];
    $PackesInLine=$_POST['PackesInLine'];
    $Extrapackes=$_POST['Extrapackes'];
    $TotalPackes=$_POST['TotalPackes'];
    $PerPackes=$_POST['PerPackes'];
    $Pieces=$_POST['Pieces'];
    $TotalQTY=$_POST['TotalQTY'];

 
    
}
?>

<div class="card m-3">
    <div class="card-body">
        <h3>
            <a class="btn btn-outline-primary " href="ProductionFinishedGoods.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
            </a>
            Finish Goods - Production Dep (Data Entry Form)
        </h3>
    </div>
</div>

<form action="" method="POST">
    <div class="card m-3">
        <div class="card-body">
                <div class="row">
                    <p class="fw-bold fs-5">Job Info:-</p>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="JobNo">Job No</label>
                        <input type="text" class="form-control" name="JobNo" id="JobNo" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['JobNo']; } ?>" readonly>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="">Company Name</label>
                        <input type="text" class="form-control" name="CompanyName" id="CompanyName" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['CustName']; } ?>" readonly>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="ProductName">Product Name</label>
                        <input type="text" class="form-control" name="ProductName" id="ProductName" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['ProductName']; } ?>" readonly>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Extrapackes">Order QTY</label>
                        <input type="text" class="form-control" name="OrderQTY" id="OrderQTY" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['CTNQTY']; } ?>" readonly>
                    </div>  
                    <p class="fw-bold fs-5 mt-4">Process Info:-</p>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="ProducedQTY">Produced QTY</label>
                        <input type="text" class="form-control" name="ProducedQTY" id="ProducedQTY" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['ProductQTY']; } ?>" readonly>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="RemainQTY">Remain QTY</label>
                        <input type="text" class="form-control" name="RemainQTY" id="RemainQTY" value="<?php if(isset($_REQUEST['CTNId'])){ echo $ReminingQTY; } ?>" readonly>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="ProducedQTY">Select Unit</label>
                        <select class="form-select" name="SelectUnit" id="SelectUnit"> 
                            <option value="Production">Production</option>
                            <option value="Manual">Manual</option>
                        </select> 
                    </div>  
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="ProducedQTY">Select Status</label>
                        <select class="form-select" name="SelectStatus" id="SelectStatus"> 
                            <option value="Completed">Completed</option>
                            <option value="NotCompleted">NotCompleted</option>
                        </select> 
                    </div>  
                    <p class="fw-bold mt-4 fs-5">Entry Info:-</p>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalPlat">Total Plate</label>
                        <input type="text" class="form-control" name="TotalPlat" id="TotalPlat" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="LineQTY">Line QTY</label>
                        <input type="text" class="form-control" name="LineQTY" id="LineQTY" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="PackesInLine">Packes In Line</label>
                        <input type="text" class="form-control" name="PackesInLine" id="PackesInLine" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Extrapackes">Extra packes</label>
                        <input type="text" class="form-control" name="Extrapackes" id="Extrapackes" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalPackes">Total Packes</label>
                        <input type="text" class="form-control" name="TotalPackes" id="TotalPackes" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="PerPackes">Per Packes</label>
                        <input type="text" class="form-control" name="PerPackes" id="PerPackes" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Pieces">Pieces</label>
                        <input type="text" class="form-control" name="Pieces" id="Pieces" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalQTY">Total QTY</label>
                        <input type="text" class="form-control" name="TotalQTY" id="TotalQTY" required>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 my-1 d-flex justify-content-end"> 
                    <input type="submit" name="Save&submit" class="btn btn-outline-primary" value="Save & submit">
                    <input type="submit" name="Reject" class="btn btn-outline-danger" value="Reject">
                </div> 
        </div>
    </div>
</form>

 

 
<?php  require_once '../App/partials/Footer.inc'; ?>