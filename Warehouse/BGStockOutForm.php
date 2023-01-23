 
<?php
ob_start(); 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;

if(isset($_GET['CartonId']) && isset($_GET['CustId']))
{
 
        $CTNId=$_REQUEST['CartonId'];  
        $CustId=$_REQUEST['CustId'];
        $SoldQTY=$_GET['SoldQTY'];
  
        $SQL='SELECT CTNId,ppcustomer.CustName,ppcustomer.CustId,CTNUnit,CTNStatus,ProductName,JobNo FROM  carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE  CTNId=? AND CustId=? '; 
 
        $DataRows=$Controller->QueryData($SQL,[$CTNId,$CustId]); 

        $Rows=$DataRows->fetch_assoc();       
}
 

if(isset($_POST['StockOut']))
{
     
   
    $CTNId=$_GET['CartonId']; 
    $CustId=$_GET['CustId'];
    $SaleId=$_GET['SaleId'];

    $VehiclePlateNO=$_POST['VehiclePlateNO'];
    $VehicleType=$_POST['VehicleType'];
    $DriverName=$_POST['DriverName'];
    $DriverMobileNo=$_POST['DriverMobileNo'];
    $Comment=$_POST['Comment'];
  
    $TotalPlat=$_POST['TotalPlat'];
    $LineQTY=$_POST['LineQTY'];
    $PackesInLine=$_POST['PackesInLine'];
    $Extrapackes=$_POST['Extrapackes'];

    $TotalPackes=$_POST['TotalPackes'];
    $PerPackes=$_POST['PerPackes'];
    $Pieces=$_POST['Pieces'];
    $TotalQTY=$_POST['TotalQTY'];

    $Total=$ProOutQty+$TotalQTY;
        
  
    $Insert=$Controller->QueryData("INSERT INTO cartonstockout(CtnCustomerId,CtnJobNo,UserId1,CtnCarNo,CtnCarName,CtnDriverName,CtnDriverMobileNo,CoutComment,OutStatus,TotalPlat,LineQTY,PacksInLine,
                                    ExtraPackes,TotalPackes,PerPackes,Pieces,CtnOutQty,financeAllowquantity) 
                                    VALUES(?,?,?,?,?,?,?,?,'Done',?,?,?,?,?,?,?,?,?) ",
                                    [$CustId,$CTNId,$_SESSION['EId'],$VehiclePlateNO,$VehicleType,$DriverName,$DriverMobileNo,$Comment,$TotalPlat,$LineQTY,$PackesInLine,$Extrapackes,$TotalPackes,$PerPackes,
                                     $Pieces,$TotalQTY,$FAQ]);
    $LastId=$DATABASE->last_id();
    $InsertGatePass=$Controller->QueryData("INSERT INTO gatepasspkg (IdStockOutPkg,EmpId,GatepassStatus) VALUES (?,?,?)",[$LastId,$_SESSION['EId'],'Apply by warehouse']);
    if($Insert)
    {  
        $Update=$Controller->QueryData("UPDATE cartonsales SET StockOutQTY=? WHERE SaleId =?",[$Total,$SaleId]); 
        header("Location:JobCenter.php?MSG=Data Driver Info Inserted Successfully&State=1");
    }
    
}

?>

<div class="card m-3">
    <div class="card-body">
        <h3>
            <a class="btn btn-outline-primary " href="JobCenter.php">
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
                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="JobNo">Job No</label>
                        <input type="text" class="form-control" name="JobNo" id="JobNo" value="<?php if(isset($_REQUEST['CartonId'])){ echo $Rows['JobNo']; }?>" readonly>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="">Company Name</label>
                        <input type="text" class="form-control" name="CompanyName" id="CompanyName" value="<?php if(isset($_GET['CartonId'])){ echo $Rows['CustName']; }?>" readonly>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 my-1">                                                                     
                        <label class="fw-bold" for="ProductName">Product Name</label>
                        <input type="text" class="form-control" name="ProductName" id="ProductName" value="<?php if(isset($_GET['CartonId'])){ echo $Rows['ProductName']; }?>" readonly> 
                    </div>
                
                   
                    <p class="fw-bold mt-4 fs-5">Entry Info:-</p>
                    <input type="hidden" name="SoldQTY" id="SoldQTY" value="<?=$_GET['SoldQTY']?>" onchange="TakeValue(this.name,this.value);">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalPlat">Total Plate</label>
                        <input type="text" class="form-control" name="TotalPlat"  onchange="TakeValue(this.name , this.value);"  id="TotalPlat">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="LineQTY">Line QTY</label>
                        <input type="text" class="form-control" name="LineQTY" onchange="TakeValue(this.name , this.value);"  id="LineQTY"  >
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="PackesInLine">Packes In Line</label>
                        <input type="text" class="form-control" name="PackesInLine" onchange="TakeValue(this.name , this.value);"  id="PackesInLine" >
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Extrapackes">Extra packes</label> 
                        <input type="text" class="form-control" name="Extrapackes" onchange="TakeValue(this.name , this.value);"  id="Extrapackes">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalPackes">Total Packes</label>
                        <input type="text" class="form-control" name="TotalPackes" id="TotalPackes"   >
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="PerPackes">Per Packes </label>
                        <input type="text" class="form-control" name="PerPackes" onchange="TakeValue(this.name , this.value);" id="PerPackes">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Pieces">Pieces </label>
                        <input type="text" class="form-control" name="Pieces" onchange="TakeValue(this.name , this.value);" id="Pieces">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalQTY">Total QTY</label>
                        <input type="text" class="form-control" name="TotalQTY" id="TotalQTY"  > 
                    </div>
 
                    <p class="fw-bold mt-4 fs-5">Driver Info:-</p>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalPlat">Vehicle Plate No</label>
                        <input type="text" class="form-control" name="VehiclePlateNO" id="VehiclePlateNO"  >
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="LineQTY">Vehicle Type</label>
                        <input type="text" class="form-control" name="VehicleType" id="VehicleType"  >
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="PackesInLine">Driver Name</label>
                        <input type="text" class="form-control" name="DriverName" id="DriverName"  >
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Extrapackes">Driver Mobile No</label>
                        <input type="text" class="form-control" name="DriverMobileNo" id="DriverMobileNo" >
                    </div>
                 
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Pieces">Comment</label>
                         <textarea name="Comment" id="" cols="10" rows="1" class="form-control"></textarea>
                    </div>
                    
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 my-1 d-flex justify-content-end"> 
                    <input type="submit" name="StockOut" class="btn btn-outline-primary" value="Stock Out">
                </div> 
        </div>
    </div>
</form>
<script>


    let total = {}; 
    function TakeValue(name , value) 
    {
        total[name] = value; 
         
        CalculatePlates(total); 
        
    }

    function CalculatePlates(total) 
    {
        let total_packs = (Number(total.TotalPlat) *  Number(total.LineQTY) * Number(total.PackesInLine)) + Number(total.Extrapackes); 
        document.getElementById("TotalPackes").value=total_packs;
        
        let TotalQTY = Number(total_packs) * Number(total.PerPackes) + Number(total.Pieces); 

        document.getElementById("TotalQTY").value = Number(TotalQTY);  

    }
 
 
</script>
 
<?php  require_once '../App/partials/Footer.inc'; ?>







 