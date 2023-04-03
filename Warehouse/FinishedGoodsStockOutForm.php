<!-- This page has line with the button of (Process) Finished Goods Check List -->
<?php
ob_start(); 
require_once '../App/partials/Header.inc'; 



//User Auth logic
// 
// if(!in_array( $Gate['VIEW_FINISH_GOODS_STOCK_OUT_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
//   header("Location:index.php?msg=You are not authorized to access this page!" );
// }

// $Gate = require_once  $ROOT_DIR . '/Auth/Gates/WAREHOUSE_DEPT';  
// echo $Gate['VIEW_FINISH_GOODS_STOCK_OUT_PAGE']; 

require_once '../App/partials/Menu/MarketingMenu.inc'; require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;

if(isset($_REQUEST['PROId']) && isset($_REQUEST['CTNId']))
{
    $CTNId=$_REQUEST['CTNId']; 
    $PROId=$_REQUEST['PROId'];
    $CustId=$_REQUEST['CustId'];
    $FAQ=$_REQUEST['FAQ']; 

    $SQL='SELECT CTNId,ppcustomer.CustName,CTNUnit,FAQTY,ExtraCarton,CTNStatus,CTNQTY,ProductName,JobNo,cartonproduction.CtnId1, cartonproduction.ManagerApproval, 
    cartonproduction.ProQty,cartonproduction.financeApproval,cartonproduction.financeAllowquantity,cartonproduction.ProOutQty,cartonproduction.ProStatus,Plate,Pack,Carton1,ExtraPack,`Line`,cartonproduction.ProId 
    FROM  carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 INNER JOIN designinfo ON designinfo.CaId=carton.CTNId INNER JOIN cartonproduction ON cartonproduction.CtnId1=carton.CTNId WHERE CTNId=?
    ORDER BY CTNOrderDate DESC'; 

    $DataRows=$Controller->QueryData($SQL,[$CTNId]); 
    $Rows=$DataRows->fetch_assoc();
   
}


if(isset($_POST['StockOut']))
{
    $FAQ=$_POST['financeAllowquantity']; 

    $ProOutQty= (int)$_POST['ProOutQty'];
    $CTNId=$_GET['CTNId'];
    $PROId=$_GET['PROId'];
    $CustId=$_GET['CustId'];
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
    // (int)$_POST['TotalQTY']; 
    $TotalPack=($TotalPlat * $LineQTY * $PackesInLine) + ($Extrapackes);
    $FAQReaminAmount = ($TotalPack * $PerPackes) + ($Pieces);
    $Total=$ProOutQty+$FAQReaminAmount;
    $FAQAmount=$FAQ - $FAQReaminAmount;
    $CTNId=$_REQUEST['CTNId'];   
  
  
    $Insert=$Controller->QueryData("INSERT INTO cartonstockout(PrStockId,CtnCustomerId,CtnJobNo,UserId1,CtnCarNo,CtnCarName,CtnDriverName,CtnDriverMobileNo,CoutComment,OutStatus,TotalPlat,LineQTY,PacksInLine,
                                    ExtraPackes,TotalPackes,PerPackes,Pieces,CtnOutQty) 
                                    VALUES(?,?,?,?,?,?,?,?,?,'Done',?,?,?,?,?,?,?,?) ",
                                    [$PROId,$CustId,$CTNId,$_SESSION['EId'],$VehiclePlateNO,$VehicleType,$DriverName,$DriverMobileNo,$Comment,$TotalPlat,$LineQTY,$PackesInLine,$Extrapackes,$TotalPackes,$PerPackes,
                                     $Pieces, $FAQReaminAmount]);
    $LastId=$DATABASE->last_id();
    $InsertGatePass=$Controller->QueryData("INSERT INTO gatepasspkg (IdStockOutPkg,EmpId,GatepassStatus) VALUES (?,?,?)",[$LastId,$_SESSION['EId'],'Apply by warehouse']);
    if($Insert)
    {  
        $Update=$Controller->QueryData("UPDATE cartonproduction SET ProOutQty=?, financeAllowquantity=? WHERE ProId=?",[$Total,0,$PROId]); 
        $Update=$Controller->QueryData("UPDATE carton SET FAQTY=?  WHERE CTNId=?",[$FAQAmount,$CTNId]);
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
                        <input type="text" class="form-control" name="JobNo" id="JobNo" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['JobNo']; }?>" readonly>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="">Company Name</label>
                        <input type="text" class="form-control" name="CompanyName" id="CompanyName" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['CustName']; } ?>" readonly>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 my-1">                                                                     
                        <label class="fw-bold" for="ProductName">Product Name</label>
                        <input type="text" class="form-control" name="ProductName" id="ProductName" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['ProductName']; } ?>" readonly>
                        <input type="hidden" name="ProOutQty" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['ProOutQty']; } ?>">
                    </div>
                
                    
                    <p class="fw-bold mt-4 fs-5">Entry Info:-</p>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalPlat">Total Plate</label>
                        <input type="text" class="form-control" name="TotalPlat"  onchange="TakeValue(this.name , this.value);"  id="TotalPlat" value="">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="LineQTY">Line QTY</label>
                        <input type="text" class="form-control" name="LineQTY" onchange="TakeValue(this.name , this.value);"  id="LineQTY" value=" ">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="PackesInLine">Packes In Line</label>
                        <input type="text" class="form-control" name="PackesInLine" onchange="TakeValue(this.name , this.value);"  id="PackesInLine" value="">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Extrapackes">Extra packes</label> 
                        <input type="text" class="form-control" name="Extrapackes" onchange="TakeValue(this.name , this.value);"  id="Extrapackes" value="">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalPackes">Total Packes</label>
                        <input type="text" class="form-control" name="TotalPackes" id="TotalPackes" readonly  >
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="PerPackes">Per Packes </label>
                        <input type="text" class="form-control" name="PerPackes" onchange="TakeValue(this.name , this.value);" id="PerPackes"  value="">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Pieces">Pieces </label>
                        <input type="text" class="form-control" name="Pieces" onchange="TakeValue(this.name , this.value);" id="Pieces" value="">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalQTY">Total QTY</label>
                        <input type="text" class="form-control" name="TotalQTY" id="TotalQTY" readonly>
                        <input type="hidden" name="financeAllowquantity" id="financeAllowquantity" value="<?php if(isset($_REQUEST['CTNId'])){ echo $_REQUEST['FAQ']; } ?>">
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
                        <input type="text" class="form-control" name="DriverMobileNo" id="DriverMobileNo"  >
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
        let total_packs = (Number(total.TotalPlat)  *  Number(total.LineQTY) * Number(total.PackesInLine)) + Number(total.Extrapackes); 
        document.getElementById("TotalPackes").value=total_packs;
        
        let TotalQTY = Number(total_packs) * Number(total.PerPackes) + Number(total.Pieces);

        console.log(total.PerPackes); 

        let FAQ = document.getElementById("financeAllowquantity").value;
        
        // if(Number(TotalQTY) > Number(FAQ))  {
        //     alert("Total QTY is Greater than Finance Allow QTY" + " "+FAQ);
        //     return;
        // }
         
        document.getElementById("TotalQTY").value = Number(TotalQTY);
       
        // console.log(total_packs);
        // console.log(Number(TotalQTY));
    }

    // console.log(total); 
<?php 
    $call = ""; 
    $call .= "TakeValue(`TotalPlat`," . $Rows['Plate']. "); "; 
    $call .= "TakeValue(`LineQTY`," . $Rows['Line']. "); "; 
    $call .= "TakeValue(`Extrapackes`," . $Rows['ExtraPack']. "); "; 
    $call .= "TakeValue(`PackesInLine`," . $Rows['Pack']. "); "; 
    $call .= "TakeValue(`PerPackes`," . $Rows['Carton1']. "); "; 
    $call .= "TakeValue(`Pieces`," . $Rows['ExtraCarton']. "); "; 
    // $call .= "console.log(total);" ; 
    echo ($call)  ; 

?>
</script>
<?php  require_once '../App/partials/Footer.inc'; ?>
 