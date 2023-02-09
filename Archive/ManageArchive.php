<?php
ob_start(); 
require_once '../App/partials/Header.inc'; 
$Gate = require_once  $ROOT_DIR . '/Auth/Gates/WAREHOUSE_DEPT';
  
if(!in_array( $Gate['VIEW_JOB_PROCESSING_FORM_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
  header("Location:index.php?msg=You are not authorized to access this page!" );
}

require_once '../App/partials/Menu/MarketingMenu.inc';
$ListType=$_GET['ListType'];
if(isset($_GET['CTNId'] ))
{
    
    $CTNId=$_GET['CTNId']; $CustId=$_GET['CustId']; 
    $SQL=$Controller->QueryData("SELECT CTNId, ppcustomer.CustWorkPhone, ppcustomer.CustName, ppcustomer.CustEmail, CTNType, CustId1 , polymer_info,die_info, JobNo, EmpId, CONCAT(CTNLength,'x',CTNWidth,'x',CTNHeight) AS Size ,ppcustomer.CustContactPerson, 
    CTNOrderDate, CTNFinishDate, CTNStatus, CTNQTY, CTNUnit, CTNColor, CTNPaper, ppcustomer.CustCatagory, ppcustomer.CustWebsite, ppcustomer.CustAddress, ppcustomer.CustMobile,cpolymer.CPid,
    cpolymer.MakeDate, cpolymer.POwner, cpolymer.CPNumber,cpolymer.PLocation,DieId,DieCode ,PStatus, CTNDiePrice, carton.ProductName, Note, CTNPolimarPrice,cdie.CDieId,cdie.CDLocation,cdie.CDStatus,designinfo.DesignStatus FROM carton INNER JOIN ppcustomer ON carton.CustId1=ppcustomer.CustId INNER JOIN designinfo ON carton.CTNId=designinfo.CaId
    LEFT OUTER JOIN cpolymer ON cpolymer.CPid=carton.PolyId LEFT OUTER JOIN cdie ON cdie.CDieId=carton.DieId WHERE CTNId = ?",[$CTNId]);
    $Rows=$SQL->fetch_assoc();
    
}
elseif(isset($_GET['CustId']))
{

    $CustId=$_GET['CustId'];
    $SQL=$Controller->QueryData("SELECT CTNId, ppcustomer.CustWorkPhone, ppcustomer.CustName, ppcustomer.CustEmail, CTNType, CustId1,  polymer_info, die_info ,JobNo, EmpId, CONCAT(CTNLength,'x',CTNWidth,'x',CTNHeight) AS Size , ppcustomer.CustContactPerson, 
    CTNOrderDate, CTNFinishDate, CTNStatus, CTNQTY, CTNUnit, CTNColor, CTNPaper, ppcustomer.CustCatagory, ppcustomer.CustWebsite, ppcustomer.CustAddress, ppcustomer.CustMobile, cpolymer.CPid,
    DieId, PStatus, CTNDiePrice, cpolymer.CPNumber,cpolymer.PLocation,DieId,DieCode , carton.ProductName, Note, CTNPolimarPrice,cdie.CDieId ,cdie.CDStatus,cdie.CDLocation FROM carton INNER JOIN ppcustomer ON carton.CustId1=ppcustomer.CustId LEFT OUTER JOIN cpolymer 
    ON cpolymer.CPid=carton.PolyId LEFT OUTER JOIN cdie ON cdie.CDieId=carton.DieId WHERE CustId1 = ?",[$CustId]);
    $Rows=$SQL->fetch_assoc();
   
}

if(isset($_POST['SaveToArchive']))
{
    $CTNId=$_GET['CTNId']; $ListType=$_REQUEST['ListType'];
    $PDStatus=$_POST['PDStatus']; $FinishTime=$_POST['finishTime']; $ArchiveComment=$_POST['ArchiveComment'];

    $SELECT=$Controller->QueryData("SELECT DesignId,CaId FROM designinfo WHERE CaId = ? AND DesignDep = 'Design' ",[$CTNId]);
    $Check=$SELECT->fetch_assoc();
    if($Check['Alarmdatetime']=='NULL')
    {
        $UpdateDesign=$Controller->QueryData("UPDATE designinfo SET DesignStatus=?,Alarmdatetime=?,CompleteTime=CURRENT_TIMESTAMP,DesignDep='Archive' WHERE CaId = ?   ",[$PDStatus,$FinishTime,$CTNId]);
        if($UpdateDesign)
        {
            $UpdateCarton=$Controller->QueryData("UPDATE carton SET CTNStatus='ArchiveProcess' WHERE CTNId = ?",[$CTNId]);
            if($UpdateCarton)
            {
                header("Location:ArchiveJobCenter.php?MSG=Carton Polymer and Die Status Updated...!&State=1&ListType=".$ListType);   
            }
            else
            {
                header("Location:ArchiveJobCenter.php?MSG=Carton Polymer and Die Status are not Updated...!&State=0&ListType=".$ListType);   
            }
        }
    }
    else
    {
        $UpdateDesign=$Controller->QueryData("UPDATE designinfo SET DesignStatus=? ,CompleteTime=CURRENT_TIMESTAMP,DesignDep='Archive' WHERE CaId = ?   ",[$PDStatus,$CTNId]);
        if($UpdateDesign)
        {
            $UpdateCarton=$Controller->QueryData("UPDATE carton SET CTNStatus='ArchiveProcess' WHERE CTNId = ?",[$CTNId]);
            if($UpdateCarton)
            {
                header("Location:ArchiveJobCenter.php?MSG=Carton Polymer and Die Status Updated...!&State=1&ListType=".$ListType);   
            }
            else
            {
                header("Location:ArchiveJobCenter.php?MSG=Carton Polymer and Die Status are not Updated...!&State=0&ListType=".$ListType);   
            }
        }
    }
    // elsel
    // {
    //     $InsertInDesign=$Controller->QueryData("INSERT INTO designinfo ( DesignName1,DesignerName1,DesignStatus, CaId, Alarmdatetime, DesignStartTime, DesignDep) 
    //                                             VALUES ('Polymer name','Fawad',?,?,?,CURRENT_TIMESTAMP, 'Archive')",[$PDStatus,$CTNId,$FinishTime]);
    //     if($InsertInDesign)
    //     {
    //         $Update =$Controller->QueryData("UPDATE carton SET CTNStatus = 'ArchiveProcess' WHERE CTNId = ?",[$CTNId]);
    //         if($Update)
    //         {
    //             header("Location:ArchiveJobCenter.php?MSG=Polymer and Die Send For Creation!...!&State=1&ListType=".$ListType);
    //         }
    //         else
    //         {
    //             header("Location:ArchiveJobCenter.php?MSG=Polymer and Die are not Send For Creation!...!&State=0&ListType=".$ListType);
    //         }

    //     }
    // }
}

if(isset($_POST['Submit']))
{
    $CTNId=$_GET['CTNId']; $ListType=$_REQUEST['ListType'];
    $PDStatus=$_POST['PDStatus']; $FinishTime=$_POST['finishTime']; $ArchiveComment=$_POST['ArchiveComment']; $DieId=$_POST['die']; $PolyId=$_POST['polymerID'];

    $updateCarton =$Controller->QueryData("UPDATE carton SET CTNStatus='Production', PolyId=? , DieId=? where CTNId=?",[$PolyId,$DieId,$CTNId]);
    $updateDesign =$Controller->QueryData("UPDATE  designinfo SET DesignStatus = ? where CaId=? and DesignDep='Archive' ",[$PDStatus,$CTNId]);

    $UserQuery=$Controller->QueryData("SELECT EId,Ename FROM employeet WHERE EUserName = ? ",[$_SESSION['user']]);
    $EMPId=$UserQuery->fetch_assoc();
    $EmpId=$EMPId['EId'];

    $CartonComment=$Controller->QueryData("INSERT INTO cartoncomment(EmpId1,EmpComment,CartonId1,ComDepartment) VALUES ( ? ,?,?,'Archive')",[$EmpId,$ArchiveComment,$CTNId]); 
    if ($CartonComment)
    {
        $UpdateProductionReport=$Controller->QueryData("UPDATE productionreport SET ArchiveEnd=CURRENT_TIMESTAMP, ArchiveComment = ?, ProductionStart=CURRENT_TIMESTAMP WHERE RepCartonId = ?",[$ArchiveComment,$CTNId]);
        if($UpdateProductionReport)
        {
            header("Location:ArchiveJobCenter.php?MSG=Submited Successfully!...!&State=1&ListType=".$ListType);
        }
        else
        {
            header("Location:ArchiveJobCenter.php?MSG=Did not Submited Successfully!...!&State=0&ListType=".$ListType);
        }
    } 
}

?>

<?php
      if(isset($_GET['MSG']) && !empty($_GET['MSG'])) 
      {
          $MSG=$_GET['MSG'];
          if($_GET['State']==1)
          {
              echo' <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                      <strong>Well Done!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
          }
          elseif($_GET['State']==0)
          {
              echo' <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                      <strong>OPPS!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
          }
      }
?>


<!-- Page Header -->
 
    <div class="card m-3 shadow">
        <div class="card-body">
            <h1 class="">Jobs Processing Form
                <small class="text-muted ">- Archive Dep. </small>
            </h1>
        </div>
    </div>

    <div class="card m-3 shadow">
        <div class="card-body d-flex justify-content-between">
                <div class="d-flex justify-content-between ms-2">
                    <a class="btn btn-outline-primary " href="ArchiveJobCenter.php?ListType=<?=$ListType?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                        </svg>
                    </a>
                </div>   
              
                <div class="my-1 text-end">
                    <?php 
                        if(isset($_GET['ListType']))
                        {
                            $ListType=$_GET['ListType'];
                            if($ListType=='JobUnderProcess')
                            {
                                if(isset($_GET['CTNId']) || isset($_GET['CustId']))
                                {  
                                    if($Rows['CPid']=='')
                                    {?>
                                        
                                        <?php  if(in_array( $Gate['VIEW_CREATE_POLYMER_BUTTON_JP'] , $_SESSION['ACCESS_LIST']  )) {?>
                                            <a class="btn btn-outline-primary " href="CreatePolymer.php?CustId=<?=$CustId?>&CTNId=<?=$Rows['CTNId']?>&ListType=<?=$ListType?>">Create Polymer</a>
                                        <?php } ?>
                                    <?php     
                                    }
                                    if($Rows['DieId']=='')
                                    {?>
                                        <?php  if(in_array( $Gate['VIEW_CREATE_DIE_BUTTON_JP'] , $_SESSION['ACCESS_LIST']  )) {?>
                                            <a class="btn btn-outline-primary " href="CreateDie.php?CustId=<?=$CustId?>&CTNId=<?=$Rows['CTNId']?>&ListType=<?=$ListType?>">Create Die</a>
                                        <?php } ?>
                                    <?php
                                    } 
                                } 
                            }
                        }
                    ?>
                </div>
            
        </div>
    </div>
 




<form action="" method="POST" class="needs-validation" novalidate>

    <!-- Company Info Form Card -->
    <div class="card m-3 shadow">
        <div class="card-body">
            <h3 class="text-muted fs-4 mt-1">Info</h3>
    
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1 ">
                    <label for="jobNum" class="form-label">Job Number</label>
                    <input type="text" class="form-control" name="jobNum" id="jobNum" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ echo $Rows['JobNo'];} ?>">
              
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 my-1">
                    <label for="companyName" class="form-label">Company Name</label>
                    <input type="text" class="form-control" name="companyName" id="companyName"  dir="auto" readonly required value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){echo $Rows['CustName'];}?>">
           
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control" name="productName" id="productName"  readonly dir="auto" value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){echo $Rows['ProductName'];}?>">
                
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="productSize" class="form-label">Size</label>
                    <input class="form-control" type="PolymerSize" name="PolymerSize" id="productSize" readonly  required value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){echo $Rows['Size'];}?>">
               
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="productColor" class="form-label">Product Color</label>
                    <input type="text" class="form-control" name="productColor" id="productColor" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){echo $Rows['CTNColor'];}?>">
                
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1 ">
                    <label for="productType" class="form-label">Product Type</label>
                    <input type="text" class="form-control" name="productType" id="productType" readonly  value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){echo $Rows['CTNType'];}?>">
                
                </div> 

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="polymer" class="form-label">Polymer</label>
                        <?php $polymer=$Rows['polymer_info']; ?>
                    <input type="text" class="form-control" name="polymer" id="polymer" readonly value="<?php echo $polymer; ?>">

                </div>   
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1 ">
                    <label for="polymerID" class="form-label">Polymer ID</label>
                    <input type="text" class="form-control" name="polymerID" id="polymerID" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ if($Rows['CPid']==''){echo'N/A';}else{echo $Rows['CPNumber']; }}?>">
                  
                </div> 
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1 ">
                    <label for="polymerID" class="form-label">Polymer Status</label>
                    <input type="text" class="form-control" name="polymerID" id="polymerID" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ if($Rows['CPid']==''){echo'N/A';}else{echo $Rows['PStatus']; }}?>">
                  
                </div> 
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1 ">
                    <label for="polymerID" class="form-label">Polymer Location</label>
                    <input type="text" class="form-control" name="polymerID" id="polymerID" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ if($Rows['CPid']==''){echo'N/A';}else{echo $Rows['PLocation']; }}?>">
                  
                </div> 

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="die" class="form-label">Die</label>
                        <?php $Die=$Rows['die_info']; ?>
                    <input type="text" class="form-control" name="die" id="die" readonly value="<?php  echo $Die; ?>">
               
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="dieID" class="form-label">Die ID</label> 
                    <input type="text" class="form-control" name="dieID" id="dieID" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ if($Rows['DieId']==''){echo'N/A';}else{echo $Rows['DieCode']; }}?>">
 
                </div> 

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="dieID" class="form-label">Die Status</label> 
                    <input type="text" class="form-control" name="dieID" id="dieID" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ if($Rows['DieId']==''){echo'N/A';}else{echo $Rows['CDStatus']; }}?>">
 
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="dieID" class="form-label">Die Location</label> 
                    <input type="text" class="form-control" name="dieID" id="dieID" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ if($Rows['DieId']==''){echo'N/A';}else{echo $Rows['CDLocation']; }}?>">
 
                </div>
            
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="contactPerson" class="form-label">Contact Person</label>
                    <input type="text" class="form-control" name="contactPerson" id="contactPerson" readonly  dir="auto"  value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){echo $Rows['CustContactPerson'];}?>">
                 
                </div>
            
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="mobileNum" class="form-label">Mobile Number</label>
                    <input type="" class="form-control" name="mobileNum" id="mobileNum" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){echo $Rows['CustMobile'];}?>">
         
                </div>
            
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="workPhoneNum" class="form-label">Work Phone Number</label>
                    <input type="text" class="form-control" name="workPhoneNum" id="workPhoneNum" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){echo $Rows['CustWorkPhone'];}?>">
                  
                </div>
            
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="companyEmail" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="companyEmail" id="companyEmail" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){echo $Rows['CustEmail'];}?>">
               
                </div> 

             
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="orderDate" class="form-label">Order Date</label>
                    <input type="Date" class="form-control" name="orderDate" id="orderDate" readonly value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ echo $Rows['CTNOrderDate']; } ?>">
                </div>
 
                  
     
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <label for="orderQuantity" class="form-label">Order Quantity</label>
                    <input type="number"   class="form-control" name="orderQuantity" readonly id="orderQuantity" value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ echo $Rows['CTNQTY'];} ?>">
                </div>
         
                
 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 my-1">
                    <label for="orderComment" class="form-label">Order Comment</label>
                    <textarea type="text" class="form-control" name="orderComment" readonly id="orderComment" rows="1" dir="auto" value="<?php if(isset($_GET['CTNId']) || isset($_GET['CustId'])){ echo $Rows['Note'];} ?>"></textarea>
                </div>
            </div>
        </div>
    </div>
 
    <div class="card m-3 shadow">
        <div class="card-body">
            <h3 class="text-muted fs-4 ">Archive Info</h3>
            <div class="row form-group">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  ">
                    <label for="pdStatus" class="form-label">P/D Status</label>
                    <select name="PDStatus" id="pdStatus" class="form-select" required>
                        <?php if(isset($_GET['CTNId'])){?> <option value="<?=$Rows['DesignStatus']?>"><?=$Rows['DesignStatus']?></option> <?php } ?>
                        <option value="Submit for Making">Submit for Making</option>
                        <option value="Processing">Processing</option>
                        <option value="Pending">Pending</option>
                        <option value="Polymer Exist">Polymer Exist</option>
                        <option value="Edit Exist Polymer">Edit Exist Polymer</option>
                        <option value="Die Exist">Die Exist</option>
                        <option value="Polymer & Die Exist">Polymer & Die Exist</option>
                        <option value="Edit Exist Die">Edit Exist Die</option>
                        <option value="Reject">Reject</option>
                        <option value="Done">Done</option>
                    </select>
                </div>
                <?php   
                    if(isset($_GET['ListType']))
                    {
                        $ListType=$_GET['ListType'];
                        if($ListType=='NewJob')
                        {?>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                                <label for="finishTime" class="form-label">Finish Time</label>
                                <input type="datetime-local" class="form-control" name="finishTime" id="finishTime" required>
                            </div>
                        <?php
                        }
                    }
                ?>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12  ">
                    <label for="designComment" class="form-label">Archive Comment</label>
                    <textarea type="text" class="form-control " name="ArchiveComment" id="ArchiveComment" rows="1"  dir="auto">
                    </textarea>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 text-end">
                    <?php
                        if(isset($_GET['ListType']))
                        {
                            $ListType=$_GET['ListType'];    
                            if($ListType=='JobUnderProcess')
                            { 
                                if($Rows['CPid']!='' || $Rows['DieId']!='')
                                { ?> 
                                    <input class="btn btn-outline-danger" type="submit" name="Submit" value="Save & Submit" onclick=" return confirm(`ایا د دی جاب لپاره پولیمر/ډايي په بشپړه توګه سم دي؟`);"> 
                                <?php 
                                }
                            }
                        }
                    ?>
                    <input class="btn btn-outline-primary" type="submit" name="SaveToArchive" value="Save To Archive">
                </div>
            </div>
        </div>
    </div>
</form>



<script>
    // script for form validation
        (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
</script>

   
<?php  require_once '../App/partials/Footer.inc'; ?>