<?php 
ob_start();
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; 
 
$ListType='';
if(isset($_POST['Save']))
{
    $CompanyId=$_POST['CustId'];
    $CTNId=$_POST['ProductName'];
    $PolymerSize=$_POST['PolymerSize'];
    $Color=$_POST['Color'];
    $DesignCode=$_POST['DesignCode'];
    $PolymerNo=$_POST['PolymerNo'];
    $SampleNo=$_POST['SampleNo'];
    $Location=$_POST['Location'];
    $Mad=$_POST['Made'];
    $PropertyOf=$_POST['PropertyOf'];
    $Date=$_POST['Date'];
    $Status=$_POST['Status'];

    $SELECT=$Controller->QueryData("SELECT  ProductName FROM carton WHERE CTNId=?",[$CTNId]);
    $Info=$SELECT->fetch_assoc();
    $ProductName=$Info['ProductName'];

    $SQL=$Controller->QueryData("INSERT INTO cpolymer (CPNumber,CompId,ProductName,PColor,Psize,PMade, CartSample, POwner, MakeDate , `Type` , DesignCode, PStatus, PLocation)
    VALUES (?,?,?,?,?,?,?,?,? ,'Polymer',?,?,?) ",[$PolymerNo,$CompanyId,$ProductName,$Color,$PolymerSize,$Mad,$SampleNo,$PropertyOf,$Date,$DesignCode,$Status,$Location]);
    $SELECTPolymerId=$Controller->QueryData("SELECT CPid FROM cpolymer WHERE CompId = ? order by CPid desc",[$CompanyId]);
    $FIRE=$SELECTPolymerId->fetch_assoc();
    $PolymerId=$FIRE['CPid'];
    if($SQL)
    {
        $UPDATECARTON=$Controller->QueryData("UPDATE carton SET PolyId = ? WHERE CTNId = ?",[$PolymerId,$CTNId]);
        header("Location:PolymerList.php?MSG=New Polymer Created...!&State=1");
    }
    else
    {
        header("Location:PolymerList.php?MSG=New Polymer Not Created...!&State=0");
    }

    
     
}

//The Below if block is coming from the PolymerList.php file. It pass the carton Id from polymerlist page , fetch it through below code using select statement.
if(isset($_GET['Id']))
{
    $Id=$_GET['Id'];   $Data=$_GET['Polymer'];
    $SELECT=$Controller->QueryData("SELECT CPid,CPNumber,CompId,ProductName,PColor,Psize,PMade, CartSample, POwner, MakeDate , `Type`, DesignCode, PStatus, PLocation ,ppcustomer.CustName,ppcustomer.CustId
    FROM cpolymer INNER JOIN ppcustomer ON ppcustomer.CustId=cpolymer.CompId WHERE CPid = ?",[$Id]);
    
 
    $SHOW=$SELECT->fetch_assoc();
}

if(isset($_POST['Update']))
{
  
    $CUSTID=$_POST['CustId'];
    $CTNId=$_POST['ProductName'];
    $PolymerSize=$_POST['PolymerSize'];
    $Color=$_POST['Color'];
    $DesignCode=$_POST['DesignCode'];
    $PolymerNo=$_POST['PolymerNo'];
    $SampleNo=$_POST['SampleNo'];
    $Location=$_POST['Location'];
    $Mad=$_POST['Made'];
    $PropertyOf=$_POST['PropertyOf'];
    $Date=$_POST['Date'];
    $Status=$_POST['Status'];

    $SELECT=$Controller->QueryData("SELECT  ProductName FROM carton WHERE CTNId=?",[$CTNId]);
    $Info=$SELECT->fetch_assoc();
    $ProductName=$Info['ProductName'];


    $UPDATE=$Controller->QueryData("UPDATE cpolymer SET CompId=? ,ProductName=?,CartSample=?,Psize=?, PColor=?, DesignCode=?, CPNumber=?
    ,PLocation=?,PMade=?,POwner=?, MakeDate=? ,PStatus=? WHERE CPid = ? ",
    [$CUSTID ,$ProductName , $SampleNo , $PolymerSize , $Color , $DesignCode , $PolymerNo , $Location , $Mad , $PropertyOf , $Date , $Status , $Id]);
     if($UPDATE)
     {
        
         header("Location:PolymerList.php?MSG=Polymer Data Sucessfully Updated...!&State=1&Data=$Data");
     }
     else
     {
         header("Location:PolymerList.php?MSG=Polymer Data Didn't Sucessfully Updated...!&State=0");
     }

}

if(isset($_GET['CTNId']))
{
    $CustId=$_GET['CustId']; $CTNId=$_GET['CTNId'];
    $PolymerQuery=$Controller->QueryData("SELECT CTNId,ProductName,CONCAT(CTNLength,'x',CTNWidth,'x',CTNHeight) AS Size,CustId1,CTNColor,ppcustomer.CustName,designinfo.DesignCode1 FROM carton 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 INNER JOIN designinfo ON designinfo.CaId=carton.CTNId WHERE CTNId=? AND CustId1=?",[$CTNId,$CustId]);
    $Excute=$PolymerQuery->fetch_assoc();
    
}

if(isset($_POST['SavePolymer']))
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

    $CompanyId=$_POST['CompanyName'];
    // $CTNId=$_POST['ProductName'];
    $PolymerSize=$_POST['PolymerSize'];
    $Color=$_POST['Color'];
    $DesignCode=$_POST['DesignCode'];
    $PolymerNo=$_POST['PolymerNo'];
    $SampleNo=$_POST['SampleNo'];
    $Location=$_POST['Location'];
    $Mad=$_POST['Made'];
    $PropertyOf=$_POST['PropertyOf'];
    $Date=$_POST['Date'];
    $Status=$_POST['Status'];

    $SELECT=$Controller->QueryData("SELECT  ProductName FROM carton WHERE CTNId=?",[$CTNId]);
    $Info=$SELECT->fetch_assoc();
    $ProductName=$Info['ProductName'];

    $InsertInCpolymer=$Controller->QueryData("INSERT INTO cpolymer (CPNumber,CompId,ProductName,PColor,Psize,PMade, CartSample, POwner, MakeDate , `Type` , DesignCode, PStatus, PLocation)
    VALUES (?,?,?,?,?,?,?,?,?,'Polymer',?,?,?) ",[$PolymerNo,$CustId,$ProductName,$Color,$PolymerSize,$Mad,$SampleNo,$PropertyOf,$Date,$DesignCode,$Status,$Location]);
    

  
    $FIRE=$Controller->QueryData("SELECT CPid FROM cpolymer WHERE CompId = ? ORDER BY CPid desc",[$CustId])->fetch_assoc();
    $PolymerId=$FIRE['CPid'];

    if($InsertInCpolymer) {
        $UPDATECARTON=$Controller->QueryData("UPDATE carton SET PolyId = ? WHERE CTNId = ?",[$PolymerId,$CTNId]);
        header("Location:$PageAddress.php?MSG=New Polymer Created...!&State=1&CustId=".$CustId."&CTNId=".$CTNId."&ListType=".$ListType);
    }
    else {
        header("Location:$PageAddress.php?MSG=New Polymer Not Created...!&State=0&CustId=".$CustId."&CTNId=".$CTNId."&ListType=".$ListType);
    }

}



?>

    <form action="" class="needs-validation" method="POST" novalidate>        
        <div class="card m-3 shadow">
            <div class="card-body">
                <h3 class="fw-bold"><span><?php if(isset($_GET['Id'])){ echo "Edit The Existed Polymer "; }else{ echo "Create New polymer "; } ?> - <span>Archive Dep</span></span></h3>
            </div>
        </div>
        <div class="card m-3 shadow">
            <div class="card-body">
                <p class="fw-bold fs-5">Info</p>
                <div class="row"  >
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="z-index: 11">
                        <label for="CompanyName" class="fw-bold pb-1">Company Name</label>

                        <input type="text" name = "CustomerName" id = "customer" class="form-control " 
                         onclick= "HideLiveSearch()" onkeyup="AJAXSearch(this.value)" value = "<?php if(isset($SHOW['CustName'])) {echo $SHOW['CustName'];}elseif(isset($_GET['CTNId'])){ echo $Excute['CustName'];}elseif(isset($_POST['CustomerName'])){echo $_POST['CustomerName'];} ?>"  >
                        <div  id="livesearch" class="list-group shadow z-index-2  position-absolute mt-2  w-25 "  > </div>
                        <input type="hidden" name="CustId" id = "CustId"  value = "<?php if(isset( $SHOW['CustId'] )) echo $SHOW['CustId'];  ?>">

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
                        <select name="ProductName" onchange = "PutSizeIntoOtherFileds()"  id="ProductName"  class = "form-select" >
                            <option value="<?php if(isset($_GET['CustId']) && isset($_GET['Polymer'])){ echo $Excute['ProductName']; }  ?>"><?php if(isset($_GET['CustId'])){ echo $Excute['ProductName']; } ?></option>
                            <option disabled> Select Product</option>
                        </select>
                        <input type="hidden" id = "CTNId1"  name="CTNId" value= "" >
                        
                        <!-- <input class="form-control" type="text" name="ProductName" id="ProductName" dir="auto" pattern="^[a-zA-Z0-9\s]*$" required value="<?php if(isset($_GET['Id'])){echo $SHOW['ProductName'];}elseif(isset($_GET['CTNId'])){echo $Excute['ProductName'];}elseif(isset($_POST['ProductName'])){echo $_POST['ProductName'];}?>"> -->
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            <span>required.</span>
                            <span>can only include alphabets, digits and whitespaces</span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <label for="DieSize" class="fw-bold pb-1">Polymer Size</label>
                        <input class="form-control" type="PolymerSize" name="PolymerSize" id="PolymerSize"  required value="<?php if(isset($_GET['Id'])){ echo $SHOW['Psize'];}elseif(isset($_GET['CTNId'])){echo $Excute['Size'];}elseif(isset($_POST['PolymerSize'])){echo $_POST['PolymerSize'];} ?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            <span>required.</span>
                            <span>can only include alphabets, digits and dashes</span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <label for="Color" class="fw-bold pb-1">Color</label>
                        <input class="form-control" type="text" name="Color" id="Color" pattern="^[a-zA-Z0-9\-]*$" required value="<?php if(isset($_GET['Id'])){echo $SHOW['PColor'];}elseif(isset($_GET['CTNId'])){echo $Excute['CTNColor'];}elseif(isset($_POST['Color'])){echo $_POST['Color'];} ?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            <span>required.</span>
                            <span>can only include alphabets, digits and dashes</span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 ">
                        <label for="DesignCode" class="fw-bold pb-1">Design Code</label>
                        <input class="form-control" type="text" name="DesignCode" id="DesignCode" pattern="^[a-zA-Z0-9\-]*$" onblur="this.value=removeSpaces(this.value);" required value="<?php if(isset($_GET['Id'])){echo $SHOW['DesignCode'];}elseif(isset($_GET['CTNId'])){echo $Excute['DesignCode1'];}elseif(isset($_POST['DesignCode'])){echo $_POST['DesignCode'];} ?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            <span>required.</span>
                            <span>can only include alphabets, digits and dashes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="card m-3 shadow" style="z-index: 0" >
            <div class="card-body">
                <p class="fw-bold fs-5">Polymer Info</p>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="" class="fw-bold pb-1">Polymer Number</label>
                        <input type="text" class="form-control" name="PolymerNo" id="PolymerNo" pattern="^[0-9\-]*$" onblur="this.value=removeSpaces(this.value);" required value="<?php if(isset($_GET['Id'])){echo $SHOW['CPNumber'];}elseif(isset($_POST['PolymerNo'])){echo $_POST['PolymerNo'];} ?>">
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
                        <input type="text" class="form-control" name="SampleNo" id="SampleNo" pattern="^[0-9\-]*$" onblur="this.value=removeSpaces(this.value);" required value="<?php if(isset($_GET['Id'])){echo $SHOW['CartSample'];}elseif(isset($_POST['SampleNo'])){echo $_POST['SampleNo'];} ?>"> 
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
                            <?php  if(isset($_GET['Id'])) { ?> <option value="<?php echo $SHOW['PLocation'];?>"><?php echo $SHOW['PLocation'];?></option> <?php } 
                                   elseif(isset($_POST['Location'])){?> <option value="<?php echo $_POST['Location']; ?>"> <?php echo $_POST['Location']; ?> </option> <?php }
                            ?> 
                            <option value="Archive">Archive</option>
                            <option value="Customer">Customer</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label for="" class="fw-bold pb-1">Made</label>
                        <select name="Made" id="Made" class="form-select">
                            <?php  if(isset($_GET['Id'])) { ?> <option value="<?php echo $SHOW['PMade'];?>"><?php echo $SHOW['PMade'];?></option> <?php } 
                                   elseif(isset($_POST['Made'])){?> <option value="<?php echo $_POST['Made']; ?>"> <?php echo $_POST['Made']; ?> </option> <?php }
                            ?> 
                            <option value="Baheer Group">Baheer Group</option>
                            <option value="Customer">Customer</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pt-2">
                        <label for="" class="fw-bold pb-1">Property Of</label>
                        <select name="PropertyOf" id="PropertyOf" class="form-select">
                            <?php  if(isset($_GET['Id'])) { ?> <option  value="<?php echo $SHOW['POwner'];?>"><?php echo $SHOW['POwner'];?></option> <?php } 
                                   elseif(isset($_POST['PropertyOf'])){?> <option value="<?php echo $_POST['PropertyOf']; ?>"> <?php echo $_POST['PropertyOf']; ?> </option> <?php }
                            ?> 
                            <option value="Baheer Group">Baheer Group</option>
                            <option value="Customer">Customer</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pt-2">
                        <label for="" class="fw-bold pb-1">Date</label>
                        <input type="Date" class="form-control"  name="Date"  value="<?php if(isset($_GET['Id'])){echo $SHOW['MakeDate'];}elseif(isset($_POST['Date'])){ echo $_POST['Date'];} ?>" id="datePicker">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pt-2">
                        <label for="" class="fw-bold pb-1">Status</label>
                        <select name="Status" id="Status" class="form-select">
                            <?php  if(isset($_GET['Id'])) { ?> <option value="<?php echo $SHOW['PStatus'];?>"><?php echo $SHOW['PStatus'];?></option> <?php } 
                                   elseif(isset($_POST['Status'])){?> <option value="<?php echo $_POST['Status']; ?>"> <?php echo $_POST['Status']; ?> </option> <?php }
                            ?> 
                            <option value="Workable">workable</option>
                            <option value="Damage">Damage</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 fw-bold pt-4 mt-2 text-start">
                        <?php if(isset($_GET['Id'])){ ?> <input type="submit" name="Update" value="Update" class="btn btn-outline-primary"> <?php }
                              elseif(isset($_GET['CTNId'])){?> <input type="submit" name="SavePolymer" value="Save Polymer" class="btn btn-outline-primary"> <?php }
                              else{?><input type="submit" class="btn btn-outline-primary" name="Save" value="Create Polymer"> <?php } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script>


function HideLiveSearch(){
    document.getElementById('livesearch').style.display = 'none';
}

function PutTheValueInTheBox(inner , id) {
    document.getElementById('customer').value = inner;
    document.getElementById('CustId').value = id; 
    AJAXSearch(id , false )
    document.getElementById('livesearch').style.display = 'none';
}


function PutCTNIdToHidden(CTNId) {
 
    document.getElementById('CTNId1').value = CTNId; 
}


function AJAXSearch(str , alter = true ) {

    document.getElementById('livesearch').style.display = '';
    if (str.length == 0) { return false; } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200)  {
              
                var response = JSON.parse(this.responseText);
                if(alter) {
                     var html = ''; 
                    if(response !=  '-1'){
                      for(var count = 0; count < response.length; count++) {
                                  html += '<a href="#" onclick = "PutTheValueInTheBox( `' + response[count].CustName + '`   , ' + response[count].CustId + ')"  class="list-group-item list-group-item-action" aria-current="true">' ; 
                                  html += response[count].CustName; 
                                  html += '</a>';
                      }
                    }
                    else html += '<a href="#" class="list-group-item list-group-item-action " aria-current="true"> No Match Found</a> ';
                    document.getElementById('livesearch').innerHTML = html; 
                }
                else {
                    console.log(response);

                    var html = ''; 
                    if(response !=  '-1')  {
                        for(var count = 0; count < response.length; count++) 
                        html += '<option  size= "'+ response[count].Size +'"  color= "'+ response[count].CTNColor +'"  code = "'+ response[count].DesignCode1 +'"  value="'+ response[count].CTNId +'"> '+ response[count].ProductName +'</option>';  
                    }
                    else html += '<option > No Match Found</option> ';
                    document.getElementById('ProductName').innerHTML = html;  

                }
                
          }
       }
       if(alter)   xmlhttp.open("GET", "AJAXSearch.php?query=" + str, true);
       else  xmlhttp.open("GET", "FindCustomerProducts.php?query=" + str + "&polymer=true" , true); 
       xmlhttp.send();
    }
}



function PutSizeIntoOtherFileds( ){

        let bt = document.getElementById('ProductName');
        let Option = bt.options[bt.selectedIndex] ; 
        let size = Option.getAttribute('size');
        let color = Option.getAttribute('color');
        let code = Option.getAttribute('code');

        // if(size.trim().length === 0 || size == null   ) DieSize = 'No Size Found'; 
        // if(color.trim().length === 0 || color == null  ) DieSize = 'No Color Found'; 
        // if(code.trim().length === 0 || code == null   ) DieSize = 'No Design Code Found'; 

        document.getElementById('PolymerSize').value =  size; 
        document.getElementById('Color').value = color; 
        document.getElementById('DesignCode').value = code; 
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




function removeSpaces(string) 
{
    return string.split(' ').join('');
}


</script>
 

<?php  require_once '../App/partials/Footer.inc'; ?>