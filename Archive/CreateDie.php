<?php
ob_start(); 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';
$ListType='';
if(isset($_POST['Save']))
{
    $CompanyId=$_POST['CustId'];
    $CTNId=$_POST['ProductName'];
    $DieSize=$_POST['DieSize'];
    $DesignCode=$_POST['DesignCode'];
    $DieNo=$_POST['DieNo'];
    $SampleNo=$_POST['SampleNo'];
    $Location=$_POST['Location'];
    $Mad=$_POST['Made'];
    $PropertyOf=$_POST['PropertyOf'];
    $Date=$_POST['Date'];
    $Status=$_POST['Status'];
    $App=$_POST['App'];
    $DieType=$_POST['DieType'];

    $target_dir = "../Assets/ArchiveSketch/";
    $target_file = $target_dir . basename($_FILES["Scatch"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $FileName =  basename( $_FILES["Scatch"]["name"]) ;


    $Upload = true; 
    $msg = []; 
 
    if (file_exists($target_file))
    {
        array_push($msg , "Sorry, file already exists."); 
        $Upload = false;
    }
        
    // Check file size
    if ($_FILES["Scatch"]["size"] > 3485760 )
    { // which is 2 million bytes ( 2MB)
        array_push($msg , "Sorry, your file is too large ( less than 3 MB) "); 
        $Upload = false;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "jpeg" ) 
    {
        array_push($msg , "Sorry, only JPG, JPEG  files are allowed."); 
        $Upload = false;
    }

    // Check if $uploadOk is set to 0 by an error/
    if (!$Upload) 
    {
        echo '<div class="alert alert-danger m-3 alert-dismissible fade show" role="alert"><strong>Somthing Went Wrong!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        
    // if everything is ok, try to upload file
    } 
    else 
    {

        if (move_uploaded_file($_FILES["Scatch"]["tmp_name"], $target_file))
        {
            $SELECT=$Controller->QueryData("SELECT  ProductName FROM carton WHERE CTNId=?",[$CTNId]);
            $Info=$SELECT->fetch_assoc();
            $ProductName=$Info['ProductName'];

            $SQL=$Controller->QueryData("INSERT INTO cdie(CDCompany,DieCode,CDProductName,CDSize,CDMade,CDSampleNo,CDOwner,CDMadeDate,CDStatus,CDLocation,APP,DieType,Scatch,CDDesignCode) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)",[$CompanyId,$DieNo,$ProductName,$DieSize,$Mad,$SampleNo,$PropertyOf,$Date,$Status,$Location,$App,$DieType,$FileName,$DesignCode]);
            $SELECTDIE=$Controller->QueryData("SELECT CDieId FROM cdie WHERE CDCompany=? order by CDieId desc",[$CompanyId]);
            $FIRE=$SELECTDIE->fetch_assoc();
            $DieId=$FIRE['CDieId'];    
            if($SQL)
            {
                $UPDATECARTON=$Controller->QueryData("UPDATE carton SET DieId=? WHERE CTNId=?",[$DieId,$CTNId]);
                header("Location:PolymerList.php?MSG=New Die Created...!&State=1");
            }
            else
            {
                header("Location:PolymerList.php?MSG=New Die Not Created...!&State=0");
            }
        }
    }
 
}

if(isset($_GET['Id']))
{
    $Id=$_GET['Id'];  $Data=$_GET['Die'];
    $SELECT=$Controller->QueryData("SELECT CDieId,CDCompany,CDProductName,CDSize,CDDesignCode,CDMade,CDSampleNo,CDOwner,CDMadeDate,CDStatus,DieCode,CDLocation,APP,DieType,Scatch,ppcustomer.CustName,ppcustomer.CustId 
    FROM cdie INNER JOIN ppcustomer ON ppcustomer.CustId=cdie.CDCompany WHERE CDieId = ?",[$Id]);
    $SHOW=$SELECT->fetch_assoc();
}

if(isset($_POST['Update']))
{


    $CUSTID=$_POST['CustId'];
    $Id=$_GET['Id'];
    $CTNId=$_POST['ProductName'];
    $DesignCode=$_POST['DesignCode'];
    $DieSize=$_POST['DieSize'];
    $DieNo=$_POST['DieNo'];
    $SampleNo=$_POST['SampleNo'];
    $Location=$_POST['Location'];
    $Mad=$_POST['Made'];
    $PropertyOf=$_POST['PropertyOf'];
    $Date=$_POST['Date'];
    $Status=$_POST['Status'];
    $App=$_POST['App'];
    $DieType=$_POST['DieType'];
  
    $target_dir = "../Assets/ArchiveSketch/";
    $target_file = $target_dir . basename($_FILES["Scatch"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $FileName =  basename( $_FILES["Scatch"]["name"]) ;

    $Upload = true; 
    $msg = []; 

    // Check file size
    if ($_FILES["Scatch"]["size"] > 10000000 )
    { // which is 10 million bytes ( 10MB)
        array_push($msg , "Sorry, your file is too large ( less than 10 MB) "); 
        $Upload = false;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "jpeg" ) 
    {
        array_push($msg , "Sorry, only JPG, JPEG  files are allowed."); 
        $Upload = false;
    }

    // Check if $uploadOk is set to 0 by an error/
    if (!$Upload) 
    {
        echo '<div class="alert alert-danger m-3 alert-dismissible fade show" role="alert"><strong>Something Went Wrong!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    // if everything is ok, try to upload file
    } 
    else 
    {

        if (move_uploaded_file($_FILES["Scatch"]["tmp_name"], $target_file))
        {
            $SELECT=$Controller->QueryData("SELECT  ProductName FROM carton WHERE CTNId=?",[$CTNId]);
            $Info=$SELECT->fetch_assoc();
            $ProductName=$Info['ProductName'];

            $UPDATE=$Controller->QueryData("UPDATE cdie SET CDCompany=?, CDProductName=?, CDSize=?, CDDesignCode=?, CDLocation=?, CDMade=?, CDOwner=?, 
            CDMadeDate=? ,CDStatus=?,APP=?,DieCode=?, DieType=?,Scatch=? WHERE CDieId = ? ",[$CUSTID,$ProductName,$DieSize,$DesignCode,$Location,$Mad,$PropertyOf,$Date,$Status,$App,$DieNo,$DieType,$FileName,$Id]);
            if($UPDATE)
            {
                header("Location:PolymerList.php?MSG=Die Data Sucessfully Updated...!&State=1&Data=$Data");
            }
            else
            {
                header("Location:PolymerList.php?MSG=Die Data Didn't Sucessfully Updated...!&State=0");
            }

        }
    }
    

}

if(isset($_GET['CustId']))
{
    $CustId=$_GET['CustId']; $CTNId=$_GET['CTNId'];
    // $DieQuery=$Controller->QueryData("SELECT * FROM cdie WHERE CDCompany = ?",[$CustId]);
    $DieQuery=$Controller->QueryData("SELECT ProductName,CONCAT(CTNLength,'x',CTNWidth,'x',CTNHeight) AS Size,CustId1,DesignCode1,ppcustomer.CustName FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 INNER JOIN designinfo ON designinfo.CaId=carton.CTNId WHERE CustId1=? AND CTNId=?",[$CustId,$CTNId]);
    $Excute=$DieQuery->fetch_assoc();
    
}

if(isset($_POST['SecondSave']))
{
    $CustId=$_GET['CustId']; $CTNId=$_GET['CTNId']; $ListType=$_REQUEST['ListType'];

    if($ListType=='ArchiveProductList')
    {
        $PageAddress='ArchiveProductList';
    }
    else
    {
        $PageAddress='ManageArchive';
    }

    $CTNId=$_GET['CTNId'];  
    $CustId=$_GET['CustId']; 
    $ListType=$_REQUEST['ListType'];
    
    // $CompanyId=$_POST['CompanyName'];
    // $CTNID=$_POST['ProductName'];
    $DieSize=$_POST['DieSize'];

    if(isset($_POST['DesignCode'])) $DesignCode=$_POST['DesignCode'];
    else $DesignCode = 0 ; 

    $DesignCode=$_POST['DesignCode'];
    $DieNo=$_POST['DieNo'];
    $SampleNo=$_POST['SampleNo'];
    $Location=$_POST['Location'];
    $Mad=$_POST['Made'];
    $PropertyOf=$_POST['PropertyOf'];
    $Date=$_POST['Date'];
    $Status=$_POST['Status'];
    $App=$_POST['App'];
    $DieType=$_POST['DieType'];

    $target_dir = "../Assets/ArchiveSketch/";
    $target_file = $target_dir . basename($_FILES["Scatch"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $FileName =  basename( $_FILES["Scatch"]["name"]);

    $Upload = true; 
    $msg = []; 
 
   
    // Check file size
    if ($_FILES["Scatch"]["size"] > 10000000 )
    { // which is 11 million bytes ( 10MB)
        array_push($msg , "Sorry, your file is too large ( less than 10 MB) "); 
        $Upload = false;
        echo '-----';
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "jpeg" &&   $imageFileType != "png" ) 
    {
        array_push($msg , "Sorry, only JPG, JPEG , PNG files are allowed."); 
        $Upload = false;
         
    }

    // Check if $uploadOk is set to 0 by an error/
    if (!$Upload) 
    {
        $counter = 1; 
        echo '<div class="alert alert-danger m-3 alert-dismissible fade show" role="alert"><strong>Something22 Went Wrong!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        foreach ($msg as $key => $value) {
           echo $counter . '-'.$value . '<br>'; 
           $counter++;
        }
        
    // if everything is ok, try to upload file
    } 
    else 
    {

        if (move_uploaded_file($_FILES["Scatch"]["tmp_name"], $target_file))
        {
            $SELECT=$Controller->QueryData("SELECT  ProductName FROM carton WHERE CTNId=?",[$CTNId]);
            $Info=$SELECT->fetch_assoc();
            $ProductName=$Info['ProductName'];

            $InsertInDie=$Controller->QueryData("INSERT INTO cdie(CDCompany,DieCode,CDProductName, CDSize, CDMade,CDSampleNo,CDOwner,CDMadeDate,CDStatus,CDLocation,APP,DieType,Scatch,CDDesignCode) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)",[$CustId,$DieNo,$ProductName,$DieSize,$Mad,$SampleNo,$PropertyOf,$Date,$Status,$Location,$App,$DieType,$FileName,$DesignCode]);
            $SELECTDIE=$Controller->QueryData("SELECT CDieId FROM cdie WHERE CDCompany=? order by CDieId desc",[$CustId]);
            $FIRE=$SELECTDIE->fetch_assoc();
            $DieId=$FIRE['CDieId'];
            if($InsertInDie)
            {
                $UPDATECARTON=$Controller->QueryData("UPDATE carton SET DieId=? WHERE CTNId=?",[$DieId,$CTNId]);
                header("Location:$PageAddress.php?MSG=New Die Created...!&State=1&CustId=$CustId&CTNId=$CTNId&ListType=".$ListType);
            }
            else
            {
                header("Location:$PageAddress.php?MSG=New Die Not Created...!&State=0&CTNId=$CTNId&ListType=".$ListType);
            }
        }
    }

}

?>

<div class="card m-3 shadow">
    <div class="card-body">
        <h3 class="fw-bold"><span><?php if(isset($_GET['Id'])){ echo "Edit The Existed Die "; }else{ echo "Create New Die "; } ?> - <span>Archive Dep</span></span></h3>
    </div>
</div>
<form action="" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
<div class="card m-3 shadow">
    <div class="card-body">
        <p class="fw-bold fs-5">Info</p>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="z-index: 11">
                <label for="CompanyName" class="fw-bold pb-1">Company Name</label>              
                    <input type="text" name = "CustomerName" id = "customer" class="form-control" 
                        onclick= "HideLiveSearch()" onkeyup="AJAXSearch(this.value)" value = "<?php if(isset($SHOW['CustName'])){echo $SHOW['CustName'];}elseif(isset($_GET['CustId'])){ echo $Excute['CustName']; }elseif(isset($_POST['CustomerName'])){echo $_POST['CustomerName'];} ?>" >
                    <div  id="livesearch" class="list-group shadow z-index-2  position-absolute mt-2  w-25 "  > </div>
                    <input type="hidden" name="CustId" id = "CustId"  value = "<?php if(isset( $SHOW['CustId'] )) echo $SHOW['CustId']; ?>">

                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    <span>required.</span>
                    <span>can only include alphabets, digits and whitespaces</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="ProductName" class="fw-bold pb-1">Product Name</label>
                <select name="ProductName" onchange = "PutSizeIntoDieSize()"  id="ProductName"  class = "form-select" >
                    <option value="<?php if(isset($_GET['CustId'])){ echo $Excute['ProductName']; }  ?>"><?php if(isset($_GET['CustId'])){ echo $Excute['ProductName']; } ?></option>
                    <option disabled> Select Product</option>
                </select>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    <span>required.</span>
                    <span>can only include alphabets, digits and whitespaces</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="DieSize" class="fw-bold pb-1">Die Size</label>
                <input class="form-control" type="DieSize" name="DieSize" id="DieSize"  required value="<?php if(isset($_GET['Id'])){echo $SHOW['CDSize'];}elseif(isset($_GET['CustId'])){echo $Excute['Size'];}elseif(isset($_POST['DieSize'])){echo $_POST['DieSize'];} ?>">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    <span>required.</span>
                    <span>can only include alphabets, digits and dashes</span>
                </div>
               
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label for="DieSize" class="fw-bold pb-1">Design Code</label>
                    <input class="form-control"  name="DesignCode" id="DesignCode"  required value="<?php if(isset($_GET['Id'])){echo $SHOW['CDDesignCode'];}elseif(isset($_GET['CustId'])){echo $Excute['DesignCode1'];}elseif(isset($_POST['DieSize'])){echo $_POST['DieSize'];} ?>">
            </div>
        </div>

    </div>
</div>


<div class="card m-3 shadow">
    <div class="card-body">
        <p class="fw-bold fs-5">Die Info</p>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="" class="fw-bold pb-1">Die Number</label>
                <input type="text" class="form-control" name="DieNo" id="DieNo" pattern="^[0-9\-]*$" required  value="<?php if(isset($_GET['Id'])){echo $SHOW['DieCode'];}elseif(isset($_POST['DieNo'])){echo $_POST['DieNo'];} ?>">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    <span>required.</span>
                    <span>can only include digits and dash</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="" class="fw-bold pb-1">Sample Number</label>
                <input type="text" class="form-control" name="SampleNo" id="SampleNo" pattern="^[0-9\-]*$" required  value="<?php if(isset($_GET['Id'])){echo $SHOW['CDSampleNo'];}elseif(isset($_POST['SampleNo'])){echo $_POST['SampleNo'];} ?>  ">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    <span>required.</span>
                    <span>can only include digits and dashes</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="" class="fw-bold pb-1">Location</label>
                <select name="Location" id="Location" class="form-select">
                    <?php  if(isset($_GET['Id'])) { ?> <option value="<?php echo $SHOW['CDLocation'];?>"><?php echo $SHOW['CDLocation'];?></option> <?php } 
                           elseif(isset($_POST['Location'])){?> <option value="<?php echo $_POST['Location']; ?>"> <?php echo $_POST['Location']; ?> </option> <?php }
                     ?> 
                    <option value="Archive" >Archive</option>
                    <option value="Customer">Customer</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="" class="fw-bold pb-1">Made</label>
                <select name="Made" id="Made" class="form-select">
                    <?php  if(isset($_GET['Id'])) { ?> <option value="<?php echo $SHOW['CDMade'];?>"><?php echo $SHOW['CDMade'];?></option> <?php } 
                           elseif(isset($_POST['Made'])){?> <option value="<?php echo $_POST['Made']; ?>"> <?php echo $_POST['Made']; ?> </option> <?php }
                    ?> 
                    <option value="Baheer Group" >Baheer Group</option>
                    <option value="Customer">Customer</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pt-1">
                <label for="" class="fw-bold pb-1">Property Of</label>
                <select name="PropertyOf" id="PropertyOf" class="form-select">
                    <?php  if(isset($_GET['Id'])) { ?> <option value="<?php echo $SHOW['CDOwner'];?>"><?php echo $SHOW['CDOwner'];?></option> <?php } 
                           elseif(isset($_POST['PropertyOf'])){?> <option value="<?php echo $_POST['PropertyOf']; ?>"> <?php echo $_POST['PropertyOf']; ?> </option> <?php }
                    ?> 
                    <option value="Baheer Group">Baheer Group</option>
                    <option value="Customer">Customer</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pt-1">
                <label for="" class="fw-bold pb-1">Date</label>
                <input type="Date" class="form-control"  name="Date"  required   value="<?php if(isset($_GET['Id'])){echo $SHOW['CDMadeDate'];}elseif(isset($_POST['Date'])){ echo $_POST['Date'];} ?>" id="datePicker">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pt-1">
                <label for="" class="fw-bold pb-1">Status</label>
                <select name="Status" id="Status" class="form-select">
                    <?php  if(isset($_GET['Id'])) { ?> <option value="<?php echo $SHOW['CDStatus'];?>"><?php echo $SHOW['CDStatus'];?></option> <?php } 
                           elseif(isset($_POST['Status'])){?> <option value="<?php echo $_POST['Status']; ?>"> <?php echo $_POST['Status']; ?> </option> <?php }
                    ?> 
                    <option value="Workable" >workable</option>
                    <option value="Damage">Damage</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pt-1">
                <label for="" class="fw-bold pb-1">App</label>
                <input type="text" class="form-control" name="App" id="App" pattern="^[a-zA-Z0-9\-]*$" required value="<?php if(isset($_GET['Id'])) {echo $SHOW['APP'];}elseif(isset($_POST['App'])){echo $_POST['App'];} ?>">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    <span>required.</span>
                    <span>can only include alphabet, digits and dashes</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pt-2">
                <label for="" class="fw-bold pb-1">Die Type</label>
                <select name="DieType" id="DieType" class="form-select">
                    <?php  if(isset($_GET['Id'])) { ?> <option value="<?php echo $SHOW['DieType'];?>"><?php echo $SHOW['DieType'];?></option> <?php } 
                           elseif(isset($_POST['DieType'])){?> <option value="<?php echo $_POST['DieType']; ?>"> <?php echo $_POST['DieType']; ?> </option> <?php }
                    ?> 
                    <option value="Manual">Manual</option>
                    <option value="Rotary">Rotary</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12   fw-bold pt-2">
                <label for="formFile" class="form-label pb-1"></label>
                <input class="form-control" type="file" id="formFile" name="Scatch" >
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 fw-bold pt-4 mt-2 text-start">
                <?php   if(isset($_GET['Id'])){ ?> <input type="submit" name="Update" value="Update" class="btn btn-outline-primary"> <?php }
                        elseif(isset($_GET['CustId']))
                        {?>
                            <input type="submit" class="btn btn-outline-primary" name="SecondSave" value="Create Die">
                        <?php
                        }
                        else
                        {?>
                            <input type="submit" class="btn btn-outline-primary" name="Save" value="Make Die">
                            <input type="reset" value="Clear" class="btn btn-outline-secondary">
                        <?php
                        }
                ?>
            </div>


        </div>
    </div>
</div>

</form>



<script>

function HideLiveSearch()
{
    document.getElementById('livesearch').style.display = 'none';
}

function PutTheValueInTheBox(inner , id) 
{
    document.getElementById('customer').value = inner;
    document.getElementById('CustId').value = id; 
    AJAXSearch(id , false); 
    document.getElementById('livesearch').style.display = 'none';
}


// the ajax search second paramether is used for altering to second file 
function AJAXSearch(str , alter=true) 
{

    document.getElementById('livesearch').style.display = '';
    if (str.length == 0)  return false;
    else 
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200)  
            {
                var response = JSON.parse(this.responseText);
                if(alter) {
                    var html = ''; 
                    if(response !=  '-1')
                    {
                        for(var count = 0; count < response.length; count++) 
                        {
                                    html += '<a href="#  " onclick = "PutTheValueInTheBox( `' + response[count].CustName + '`   , ' + response[count].CustId + ')"  class="list-group-item list-group-item-action" aria-current="true">' ; 
                                    html += response[count].CustName; 
                                    html += '   </a>';
                        }
                    }
                    else html += '<a href="#" class="list-group-item list-group-item-action " aria-current="true"> No Match Found</a> ';
                    document.getElementById('livesearch').innerHTML = html;  
                }
                else {
                    // alert(response);
                    // console.log(response);
                    var html = ''; 
                    if(response !=  '-1')  {
                        for(var count = 0; count < response.length; count++) html += '<option  data= "'+ response[count].Size +'" value="'+ response[count].CTNId +'"> '+ response[count].ProductName +'</option>';  
                    }
                    else html += '<option > No Match Found</option> ';
                    document.getElementById('ProductName').innerHTML = html;  
                }

          }
       }

       if(alter) {
           xmlhttp.open("GET", "AJAXSearch.php?query=" + str, true);
        }
        else {
            xmlhttp.open("GET", "FindCustomerProducts.php?query=" + str, true);
        }
        xmlhttp.send();
    }
}



function PutSizeIntoDieSize( ){
        let bt = document.getElementById('ProductName');
        let DieSize = bt.options[bt.selectedIndex].getAttribute('data');

        if(DieSize.trim().length === 0 || DieSize=='null') DieSize = 'Have No Size'; 
        document.getElementById('DieSize').value = DieSize; 
}
 




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


        // script for default value of datepicker (today)
        Date.prototype.toDateInputValue = (function () {
                var local = new Date(this);
                local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
                return local.toJSON().slice(0, 10);
        });
        document.getElementById('datePicker').value = new Date().toDateInputValue();
</script>

<?php  require_once '../App/partials/Footer.inc'; ?>