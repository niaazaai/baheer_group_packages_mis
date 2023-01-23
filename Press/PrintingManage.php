
<?php
ob_start(); 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';

if(isset($_GET['CTNId']))
{
    $CTNId=$_GET['CTNId'];
    $SQL='SELECT `CTNId`, ppcustomer.CustWorkPhone,ppcustomer.CustName, ppcustomer.CustEmail, `CTNType`, `CustId1`, `JobNo`, `EmpId`, 
                  CONCAT (CTNLength ,"x",CTNWidth,"x",CTNHeight ) AS Size, ppcustomer.CustContactPerson, `CTNOrderDate`, `CTNFinishDate`, 
                  CTNStatus, `CTNQTY`, `CTNUnit`, `CTNColor`, `CTNPaper`,ppcustomer.`CustCatagory`,ppcustomer.CustWebsite, ppcustomer.CustAddress, 
                  ppcustomer.CustMobile, cpolymer.CPid, cpolymer.MakeDate, cpolymer.POwner, DieId, PStatus,JobNoPP, CTNDiePrice, carton.ProductName, 
                  Note, CTNPolimarPrice, offesetp FROM `carton` INNER JOIN ppcustomer ON carton.CustId1=ppcustomer.CustId left outer JOIN cpolymer 
                  ON cpolymer.CPid=carton.PolyId where CTNId= ?';
    $DataRows=$Controller->QueryData($SQL,[$CTNId]);
    $Rows=$DataRows->fetch_assoc();
}

if(isset($_POST['Save&Submit']) && !empty($_POST['Save&Submit']))
{
    $CTNId=$_POST['CTNId'];
    $ListType=$_GET['ListType'];
    $Status=$_POST['Status']; $Comment=$_POST['Comment'];
    $Update=$Controller->QueryData("UPDATE carton SET CTNStatus='Production' where CTNId = ?",[$CTNId]);


    $dat = date("Y-m-d h:i:s");
    $Employee=$Controller->QueryData("SELECT EId,EUserName FROM employeet where EUserName = ?",[$_SESSION['user']]);
    $EMPID=$Employee->fetch_assoc(); $EmpId=$EMPID['EId'];

    $CartonComment=$Controller->QueryData("INSERT INTO cartoncomment (EmpId1, EmpComment, CartonId1, ComDepartment) VALUES ( $EmpId, '$Comment', $CTNId, 'Printing')",[]); 
    if($CartonComment)
    { }
    
    $ProductionReportUpdate=$Controller->QueryData("UPDATE productionreport SET PPEnd=CURRENT_TIMESTAMP, PPComment='$Comment', ProductionStart=CURRENT_TIMESTAMP WHERE RepCartonId=?",[$CTNId]);

    if($Update)
    {
        header("Location:PrintingJobCenter.php?msg=Data Successfully Updated&ListType=".$ListType);
    }
    else
    {
        header("Location:PrintingJobCenter.php?msg=Data Didn't Successfully Updated&ListType=".$ListType);
    }
 
}
 
?>

<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between">
        <h5 class="my-1  "> 
            <a class="btn btn-outline-primary me-3" href="PrintingJobCenter.php?ListType=<?=$_GET['ListType']?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
            </a>
        </h5>
    <div>
    <a href="Manual/ProductList_Manual.php" class="text-primary" title="Click to Read the User Guide ">
        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
            <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
        </svg>
    </a>

  
    </div>
  </div>
</div>


<form class="form-validate"  enctype="multipart/form-data" id="feedback_form" method="post" action="PrintingManage.php">
<div class="card m-3 shadow">
    <div class="card-body">
        <h3 class="mb-5">Printing Press Info - <span class="badge bg-info">Order Processing</span></h3>
        <div class="row">
            
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 fw-bold">
                <label for="" class="pb-1">Job No</label>
                <input type="text" name="JobNo" class="form-control" readonly value="<?php if(isset($Rows['JobNo'])) echo $Rows['JobNo']; ?>">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 fw-bold">
                <label for="" class="pb-1">Company Name</label>
                <input type="text" name="CompanyName" class="form-control" readonly value="<?php if(isset($Rows['CustName'])) echo $Rows['CustName']; ?>">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  fw-bold">
                <label for="" class="pb-1">Product Name</label>
                <input type="text" name="ProductName" class="form-control" readonly value="<?php if(isset($Rows['ProductName'])) echo $Rows['ProductName']; ?>">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  fw-bold">
                <label for="" class="pb-1">Size</label>
                <input type="text" name="Size" class="form-control" readonly value="<?php if(isset($Rows['Size'])) echo $Rows['Size']; ?>">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  fw-bold">
                <label for="" class="pb-1">Product Type</label>
                <input type="text" name="ProductType" class="form-control" readonly value="<?php if(isset($Rows['ProductName'])) echo $Rows['ProductName']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="" class="pb-1">Order QTY</label>
                <input type="text" name="OrderQTY" class="form-control" readonly value="<?php if(isset($Rows['CTNQTY'])) echo $Rows['CTNQTY']; ?>">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="" class="pb-1">Color</label>
                <input type="text" name="Color" class="form-control" readonly value="<?php if(isset($Rows['CTNColor'])) echo $Rows['CTNColor']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="" class="pb-1">Contact Person</label>
                <input type="text" name="ContactPerson" class="form-control" readonly value="<?php if(isset($Rows['CustContactPerson'])) echo $Rows['CustContactPerson']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="" class="pb-1">Mobile</label>
                <input type="text" name="Mobile" class="form-control" readonly value="<?php if(isset($Rows['CustMobile'])) echo $Rows['CustMobile']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="" class="pb-1">Work Phone</label>
                <input type="text" name="WorkPhone" class="form-control" readonly value="<?php if(isset($Rows['CustWorkPhone'])) echo $Rows['CustWorkPhone']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="" class="pb-1">Email</label>
                <input type="text" name="Email" class="form-control" readonly value="<?php if(isset($Rows['CustEmail'])) echo $Rows['CustEmail']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="" class="pb-1">Order Date</label>
                <input type="text" name="OrderDate" class="form-control" readonly value="<?php if(isset($Rows['CTNOrderDate'])) echo $Rows['CTNOrderDate']; ?>">
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="" class="pb-1">Website</label>
                <input type="text" name="website" class="form-control" readonly value="<?php if(isset($Rows['CustWebsite'])) echo $Rows['CustWebsite']; ?>">
            </div>

 
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="" class="pb-1">Comment</label>
                <input type="text" name="Comment" class="form-control" readonly value="<?php if(isset($Rows['Note'])) echo $Rows['Note']; ?>">
            </div>

        </div>
    </div>
</div>
</form>

<form action=""  method="POST">
<div class="card m-3">
    <div class="card-body">
        <h3 class="mb-4"> Printing Press-Info</h3>
        <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-1 fw-bold">
                    <label for="" class="pb-1">Printing Press Job No</label>
                    <input type="text" name="PPJobNo" class="form-control" readonly value="<?php if(isset($Rows['JobNoPP'])) echo $Rows['JobNoPP'];?>">
                </div>
                 
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-1 fw-bold">
                    <label for="" class="pb-1">Printing Press Comment</label>
                    <textarea name="Comment" id="Comment" cols="20" rows="1" class="form-control"></textarea>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-1 col-xs-1  mt-4 pt-2 fw-bold text-end">
                    <label for=""></label>
                    <input type="submit" name="Save&Submit" class="btn btn-outline-primary" value="Save & Submit">
                    <input type="reset"  class="btn btn-outline-secondary" value="clear">
                </div> 
                <input type="hidden" name="CTNId" value="<?php if(isset($_GET['CTNId'])){ echo $_GET['CTNId'];} ?>">
        </div>
    </div>
</div>
</form>
<?php  require_once '../App/partials/Footer.inc'; ?>

 