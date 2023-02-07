<?php  
  ob_start(); 
require_once '../App/partials/Header.inc';  
require_once '../App/partials/Menu/MarketingMenu.inc'; 

$Gate = require_once  $ROOT_DIR . '/Auth/Gates/FINANCE_DEPT';
if(!in_array( $Gate['VIEW_CUSTOMER_PAYMENT_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized to access customer page page!" );
}

$currency = ''; 
$CustId = 0; 
if((isset($_POST['Currency']) && !empty('Currency') ) && ( isset($_POST['CustId1']) && !empty('CustId1') ) ) {
    $currency=$_POST['Currency'];
    $CustId=$_POST['CustId1'];
    $CustomerName  = $_POST['CustomerName']; 
    $Query=$Controller->QueryData("SELECT CTNId, CTNOrderDate,JobNo,ProductName,CTNLength,CTNWidth,CTNHeight,FinalTotal,ReceivedAmount,CtnCurrency , PexchangeUSD 
    FROM carton WHERE CustId1 =  ? AND CtnCurrency = ? AND JobNo!='NULL' AND FinalTotal != ReceivedAmount ",[$CustId,$currency]);


}

if((isset($_GET['CTNId']) && !empty('CTNId') ) && ( isset($_GET['CustId']) && !empty('CustId') ) ) {
    $CTNId=$_GET['CTNId'];
    $CustId=$_GET['CustId'];
    $currency='USD';
    $Query=$Controller->QueryData("SELECT CTNId, CTNOrderDate,JobNo,ProductName,CTNLength,CTNWidth,CTNHeight,FinalTotal,ReceivedAmount,CtnCurrency , PexchangeUSD 
    FROM carton  WHERE CustId1 = ? AND CtnCurrency = ? AND JobNo!='NULL' AND FinalTotal != ReceivedAmount ",[$CustId,    $currency]);

    if($Query->num_rows ==  0 ) {
        $currency='AFN';
        $Query=$Controller->QueryData("SELECT CTNId, CTNOrderDate,JobNo,ProductName,CTNLength,CTNWidth,CTNHeight,FinalTotal,ReceivedAmount,CtnCurrency , PexchangeUSD 
        FROM carton  WHERE CustId1 = ? AND CtnCurrency = ? AND JobNo!='NULL' AND FinalTotal != ReceivedAmount ",[$CustId,    $currency]);
    }


    $ChechifPaid=$Controller->QueryData("SELECT CTNId , FinalTotal , ReceivedAmount   ,ProductName
    FROM carton  WHERE CTNId = ? AND CtnCurrency = ? AND JobNo!='NULL'  ",[$CTNId,    $currency]);
    $ChechifPaid1 = $ChechifPaid->fetch_assoc() ; 
    if($ChechifPaid1['FinalTotal'] == $ChechifPaid1['ReceivedAmount']  ) {
        echo '<div class="alert alert-danger m-3 alert-dismissible fade show" role="alert"><strong> The customer already paid completely for the job [ '. $ChechifPaid1['ProductName'] .' ]</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }

    // echo $_GET['CTNId'];
    // echo $_GET['CustomerName'];
    // echo $CustId; 

  
 
} 

 
if (isset($_REQUEST['ListType']) && !empty($_REQUEST['ListType'])) $ListType=$_REQUEST['ListType'];
else $ListType = 'New Job';



?>

 
<style>
    .effect:hover {
        background-color:#ffff66;
        opacity:0.8;
        color:black;
    }

    .highlight-tr {
        background-color:#ffff66;
        opacity:0.8;
        color:black;
        font-weight:bold;
    }
    .make-red {
        border:2px solid red ;
    }


    

</style>




<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <a class="btn btn-outline-primary me-1" href="JobCenter.php?ListType=<?=$ListType?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                </svg>
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-cash-stack " viewBox="0 0 16 16">
            <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
            <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
            </svg>  Customer Payment 
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
                <div class="strong-text fw-bold" style = "font-size:20px;" id = "TopTotalAmountDue"  > 0  </div> 
                <div class="text-primary"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-stack " viewBox="0 0 16 16">
                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
                    </svg>
                    <?php echo (isset($_REQUEST['CustomerName'])) ? '( '. $_REQUEST['CustomerName'] .' )' :   "Customer" ; ?> Balance  |  <span class= "badge bg-warning"><?php echo isset($currency) ? $currency : ''  ?></span>
                </div>
	    </div><!-- Button trigger modal div end -->

    </div>
</div> 
 


<!-- <div class="card m-3 ">
    <div class="card-body d-flex justify-content-between">
            <div class="">
                <div class="strong-text fw-bold" style = "font-size:20px;" id = "TopTotalAmountDue"  > 0  </div> 
                <div class="text-primary"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-stack " viewBox="0 0 16 16">
                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
                    </svg>
                    <?php echo (isset($_REQUEST['CustomerName'])) ? '( '. $_REQUEST['CustomerName'] .' )' :   "Customer" ; ?> Balance    |  <span class= "badge bg-warning"><?php echo isset($currency) ? $currency : ''  ?></span>
                </div>
            </div>
    </div>
</div> -->
 

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <?php if(isset($_GET['msg']) && !empty($_GET['msg'])) {    ?>
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


<div class="card m-3   " style="z-index: 11" >
    <div class="card-body">

            <form action="" method = "post"   autocomplete="off" >
            <input type="hidden" name="CustId1" id = "CustId1" value = "<?php if(isset( $CustId )) echo $CustId;  ?>"   >
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1">
                    <label for="CustomerName">Received From</label>
                </div>

                <div div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  ">
                   
                        <input type="text" name = "CustomerName" id = "customer" class="form-control "  onclick= "HideLiveSearch()" onkeyup="AJAXSearch(this.value)" 
                        value = "<?php if(isset($_REQUEST['CustomerName'])) echo $_REQUEST['CustomerName'];  ?>"  >
                        <div  id="livesearch" class="list-group shadow z-index-2  position-absolute mt-2  w-25 "  > </div>
                   
                </div> <!-- END OF COL  -->
            
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-2 ">
                    <label for="Currency">Currency</label>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-2">
          
                    <select class="form-select" name="Currency" id="Currency"  onchange="this.form.submit(); " >
                        <option selected='selected'  value=" <?php if(isset($_POST['Currency'])) echo $_POST['Currency']; elseif(isset($currency) ) echo $currency; ?>"  selected="selected" > <?php if(isset($_POST['Currency'])) echo $_POST['Currency']; elseif(isset($currency) ) echo $currency; ?> </option>
                        <option value="AFN">AFN</option>
                        <option value="USD">USD</option>
                        <option value="PKR">PKR</option>
                    </select>
            
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-2">
         
                    <select class="form-select" name="RExchangeCurrency" id="REC"  onchange= "SetValueToHiddenField(this.value); " >
                        <option disabled >  Exchange Currency</option>
                        <option value="AFN">AFN</option>
                        <option value="USD">USD</option>
                        <option value="PKR">PKR</option>
                    </select>
            
                </div>

            </div>
            </form>

            
        <form action="CustomerPaymentController.php" method="POST">
            <input type="hidden" name="OrignalCurrency" id = "OrignalCurrency"  value = "">
            <input type="hidden" name="RExchangeCurrency" id = "RExchangeCurrency" value = "">
            <input type="hidden" name="CustId" id = "CustId"  value = "<?php if(isset( $CustId )) echo $CustId;  ?>">
            <input type="hidden" name="ListType" id = "ListType"  value = "<?=$ListType  ?>">
            

            <div class="row  ">

            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="PaymentMethod">Payment Method</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <select class="form-select" name="PaymentMethod" id="PaymentMethod">
                    <option value="Cash">Cash</option>
                    <option value="Bank">Bank</option>
                    <option value="Sarafi">Sarafi</option>
                </select>
            </div>
   
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-2">
                <label for="Class">Class</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-2">
                <select class="form-select" name="SectionName" id="Class">
                    <option value="PKG">PKG</option>
                    <option value="PrintingPress">Printing Press</option>
                    <option value="TN">TN</option>
                    <option value="A4">A4</option>
                    <option value="Meksan">Meksan</option>
                    <option value="Marble">Marble</option>
                    <option value="Tussi Paper">Tussi Paper</option>
                    <option value="CharityFoundation">Charity Foundation</option>
                    <option value="Mines">Mines</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 ">
                <label for="">Payment Amount</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                <input type="text" name="PaymentAmount" id="PaymentAmount"   oninput= "ChangePaymentAmount(this.value); "  class="form-control">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-2">
                <label for="ARAccount">A/R Account</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-2">
                <select class="form-select" name="ARAccount" id="ARAccount">
             
                </select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 ">
                <label for="PaymentDate">Payment Date</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                <input type="date" name="PaymentDate" id="PaymentDate" class="form-control" required >
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-2">
                <label for="ExchangeRate">Exchange Rate</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-2">
                <input type="text" name="ExchangeRate" id="ExchangeRate" class="form-control">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 ">
                <label for="ReferenceNo">Reference No</label>   
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                <input type="text" name="ReferenceNo" id="ReferenceNo" class="form-control" required>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-2">
                <label for="DepositTo">Deposit To</label>
            </div>
            <div class="col-lg-4 col-md-4 col-ssm-12 col-xs-12 mt-2">
                <select class="form-select" name="DepositTo" id="DepositTo">
                    <option value="Cash-On-Hand">Cash-On-Hand</option>
                    <option value="Petty-Cash">Petty-Cash</option>
                    <option value="Bank">Bank</option>
                    <option value="Sarafi">Sarafi</option>
                </select>
            </div>
        </div>
    </div>
</div>


<div class="card m-3   ">
    <div class="card-body">
        <div class="table-responsive ">
            <table class="table table-bordered " id="myTable">
                <thead class="table-light fw-bold text-center">
                    <tr>
                        <th scope="col">OP</th>
                        <th scope="col">Date</th>
                        <th scope="col">Number</th>
                        <th scope="col">Description</th>
                        <th scope="col">Original Amount</th>
                        <th scope="col">Amount Due</th>
                        <th scope="col">Payment</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $TotalAmount=0; $TotalAmountDue=0; $TotalApplied=0; $AmountRecovered=0;
                    $ExchangeRateAverage = 0 ; 
                    $ExchangeRateCount = 1 ; 
                    if (isset($Query)) {
                        while ($Fire=$Query->fetch_assoc()) {
                            $AmountDue=$Fire['FinalTotal'] - $Fire['ReceivedAmount'];
                            $ExchangeRateAverage += $Fire['PexchangeUSD']  ;
                            $ExchangeRateCount++; ?>

                            <tr>
                            <input type="hidden" id="EX_<?=$Fire['CTNId']?>" name="EX_<?=$Fire['CTNId']?>" value = "<?=$Fire['PexchangeUSD']?>" >
                            <input type="hidden" name="CTNId_<?=$Fire['CTNId']?>" value = "<?=$Fire['CTNId']?>" >

                            <td class='text-center'>
                                <input 
                                    type='checkbox' <?php if(isset($_GET['CTNId'])) if( $_GET['CTNId'] == $Fire['CTNId'] ) echo 'checked'; ?> 
                                    id='Check_<?=$Fire['CTNId']?>' class='form-check-input fs-3' 
                                    onclick="Calculate('Payment_<?=$Fire['CTNId']?>' , 'Due_<?=$Fire['CTNId']?>' , true , 'Check_<?=$Fire['CTNId']?>' )"  > 
                              
                            </td> 
                            
                            <?php
                            
                                echo "<td>".$Fire['CTNOrderDate']."</td>";
                                echo "<td>".$Fire['CTNId'].   "</td>";
                                echo "<td> <a target='_blank' style = 'text-decoration:none;' title='Check Job Card' class = 'effect' href='JobCard.php?CTNId=".  $Fire['CTNId']  ."&ListType=New Job '> ".$Fire['ProductName']."(".$Fire['CTNLength']."X".$Fire['CTNWidth']."X".$Fire['CTNHeight'].")"."</a></td>";
                                echo "<td class='text-end'>".number_format($Fire['FinalTotal'],2)."</td>"; ?>
                                <td class='text-end' id='Due_<?=$Fire['CTNId']?>'> <?=$AmountDue;?> </td> 
                                <td class='text-end' id='payment' style = "width:150px;" > 
                                    <input type="float" name="Payment_<?=$Fire['CTNId']?>" id = "Payment_<?=$Fire['CTNId']?>"  class = "form-control"
                                        style = "border:3px solid black;" onchange = "Calculate( 'Payment_<?=$Fire['CTNId']?>' , 'Due_<?=$Fire['CTNId']?>' , false  );"   >
                                </td>

                            <?php
                            echo "</tr>";
                                $TotalAmount=$TotalAmount+$Fire['FinalTotal'];
                                $TotalAmountDue=$TotalAmountDue+$AmountDue;
                        }
                            
                    }
                    // else {
                    //     echo "<tr> <td colspan = '7' class ='text-center text-danger fw-bold'>NO RECORD FOUND</td></tr>";

                    // }
                    
                        echo "<tr>";
                        echo "<td class='fw-bold text-center' colspan='4'>Total</td>";
                        echo "<td class='fw-bold text-end'>". number_format($TotalAmount, 2 )." </td>";
                        echo "<td class='fw-bold text-end' id = 'TotalAmountDue'  >". number_format($TotalAmountDue, 2 ) ."</td>";
                    ?>
                        <td class='fw-bold text-end' id = "TOTAL_DUE_SHOW" >  </td>
                    <?php 
                          
                 
                ?>
                </tbody>

                <?php  $ERA = $ExchangeRateAverage / $ExchangeRateCount  ; ?>

                <input type="hidden" id = "ExchangeRateAverage" value = "<?=$ERA?>"  >
                <input type="hidden" name="TOTAL_DUE" id = "TOTAL_DUE" value = "" >

            </table>
        </div>
    </div>
</div>

<div class="card m-3">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 "> 
                <label for="Note">Note</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <textarea class="form-control" name="Note" id="Note" cols="30" rows="3"></textarea>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 d-flex justify-content-end text-end">
                
                    
                <table  >
                    <tr> <td class = "fw-bold "> Amount Due:</td> <td   class = "text-start " ><span class="  fw-bold ps-5"> <?php echo number_format($TotalAmountDue, 2 ) ;?></span></td></tr>
                    <tr><td  class = "fw-bold "> Applied:</td> <td class = "fw-bold " id = "AppliedAmount"> 0 </td></tr>
                    <tr> <td class = "fw-bold "> Amount Received:</td> <td class = "fw-bold " id = "AmountReceived"> 0 </td> </tr>
                </table>
             
                <!-- <span class="">Amount Due     :</span><span class="fw-bold  ps-5"> <--?php //echo number_format($TotalAmountDue, 2 ) ;?></span><br>
                <span class="pe-5">Applied        : </span><span class="fw-bold ps-4">  </span><br>
                <span class="">Amount Received:</span><span class="fw-bold ps-3"> 2333</span> -->
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 text-end">
                <!-- <input type="submit" name="SaveClose" disabled id="SaveClose" value="Save & Close" class="btn btn-outline-danger">  -->
                <input type="submit" name="SaveNext" id="SaveNext" value="Save & Next" class="btn btn-outline-primary"> 
            </div>
        </div>
    </div>
</div> 
</form>


<script>
 

function AddPrecision(x , y = 2 ) {
  return Number.parseFloat(x).toFixed(y);
}

function RemoveComma(x) {
    return  x.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "")
}

function AddComma(value1 , id ){
    let x = 0 ; 
    x = value1.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
    document.getElementById(id).value  = x ; 
}

document.getElementById('ExchangeRate').value = AddPrecision(document.getElementById('ExchangeRateAverage').value) ; 
document.getElementById('TopTotalAmountDue').innerHTML =  (document.getElementById('TotalAmountDue').innerHTML);


function removeDuplicateOptions(s, comparitor) {
        if(s.tagName.toUpperCase() !== 'SELECT') { return false; }
        var c, i, o=s.options, sorter={};
        if(!comparitor || typeof comparitor !== 'function') {
            comparitor = function(o) { return o.value; };//by default we comare option values.
        }
        for(i=0; i<o.length; i++) {
            c = comparitor(o[i]);
            if(sorter[c]) {
            s.removeChild(o[i]);
            i--;
            }
            else { sorter[c] = true; }
        }
      return true;
}

removeDuplicateOptions(document.getElementById('Currency') );
Update();

function Update(){
    var Currency = document.getElementById("Currency").value;

    var select = document.getElementById("ARAccount");
    var option = document.createElement("option");
    if(Currency.trim() == 'AFN') 
    {
            option.value = 'Account-Receiveble-AFN';
            option.text = 'Account-Receiveble-AFN';
            option.selected = 'selected';
            select.appendChild(option);
    }
    else if(Currency.trim() == 'USD') 
    {
            option.value = 'Account-Receiveble-USD';
            option.text = 'Account-Receiveble-USD';
            option.selected = 'selected';
            select.appendChild(option);
    } 
    else if(Currency.trim() == 'PKR') 
    {
            option.value = 'Account-Receiveble-PKR';
            option.text = 'Account-Receiveble-PKR';
            option.selected = 'selected';
            select.appendChild(option);
    }
}

function SetValueToHiddenField(valu1e){
    document.getElementById('OrignalCurrency').value =  document.getElementById("Currency").value;  
    document.getElementById('RExchangeCurrency').value = valu1e; 
}


var TOTAL_DUE =  {}; 
var EX_RATE =  {}; 


// this block is for sum each payment amount and if the currency was other than usd it exchange it to usd dollar and shows it in the page 
function SUM_TOTAL_DUE(){

    var total = 0 ; 
    var total_usd = 0 ; 
    let currency = document.getElementById('Currency').value;
    let currency1 = '' ;

    for (var key in TOTAL_DUE) {
        // console.log("key " + key + " has value " + TOTAL_DUE[key]);
        total += TOTAL_DUE[key]; 
        var key_number_part = key.replace(/\D/g,'');
        if(currency.trim() != 'USD') {
            let a  =  TOTAL_DUE[key] / EX_RATE['EX_'+key_number_part]  ;   
            total_usd += a; 
            currency1 = 'USD'; 
        }
        else { 
            total_usd += total
            currency = currency1; 
        }
    }
    // this block will swho exchanged amount in Amount Received td below the page 
    document.getElementById('AmountReceived').innerText =  AddPrecision(total_usd)  +' ' + currency1; 
    return Number(AddPrecision(total)); 
}



function Calculate(ManualPayment1 ,  DueId ,  CheckboxClicked = false , CheckBoxId=null ) {
    
    var TOTAL = 0 ; 
    var ManualPayment = document.getElementById(ManualPayment1); 
    var PaymentTotalAmount = document.getElementById('PaymentAmount'); 
    var num = DueId.replace(/\D/g,'');

    // console.log(num , DueId , CheckboxClicked  , CheckBoxId);

    var CheckBox; 
    if(CheckBoxId != null ) CheckBox = document.getElementById(CheckBoxId); 

    var DueAmount  =   document.getElementById(DueId).innerText ;

    if (CheckboxClicked) { 
        if(CheckBox.checked) {
            // DueAmount = Number(RemoveComma(DueAmount)); 
            TOTAL_DUE[DueId] = Number(AddPrecision(DueAmount, 2));
            EX_RATE['EX_'+num] = Number(document.getElementById('EX_'+num).value);
            ManualPayment.value = Number(AddPrecision(DueAmount, 2));
            ManualPayment.style =   "border:4px solid #3EC70B;font-weight:bold;";
        } 
        else {
            delete  TOTAL_DUE[DueId]; 
            delete EX_RATE['EX_'+num];
            ManualPayment.value = 0; 
            ManualPayment.style =   "border:4px solid black;font-weight:bold;";
        }
    }
    else {
        
        TOTAL_DUE[DueId] = Number(ManualPayment.value)  
        EX_RATE['EX_'+num] = Number(document.getElementById('EX_'+num).value);
    
        CheckBox = document.getElementById("Check_" + num); 
        if(CheckBox.checked) ManualPayment.style = "border:4px solid #FFCC1D;font-weight:bold;";
        else {
            CheckBox.checked = true; 
            ManualPayment.style = "border:4px solid #3EC70B;font-weight:bold;" ;
        }

    }

    let checkkk = CheckPaymentValue(ManualPayment1 , DueId ) ; 

    if(checkkk) {
        return ; 
    } 


    TOTAL = SUM_TOTAL_DUE();
    PaymentTotalAmount.value = Number(AddPrecision(TOTAL , 2 ))  ;
    document.getElementById('AppliedAmount').innerText = Number(AddPrecision(TOTAL , 2 )) ;

    
}

// this block is used to check if the input amount is bigger then due amount
function CheckPaymentValue(id , DueId){
    let ManualPayment = document.getElementById(id); 
    let Due = document.getElementById(DueId); 
    let MP = Number(AddPrecision(ManualPayment.value, 2)); 
    let DA = Number(AddPrecision(Due.innerText, 2)); 
    
    if( MP > DA  ) {
        alert('You may not apply more than the amount due !'); 
        ManualPayment.value = DA ;
        document.getElementById('PaymentAmount').value = DA;  
        document.getElementById('AppliedAmount').innerText = DA;  
        return true; 
    }

    return false; 
}






function PutTheValueInTheBox(inner , id) {
    console.log(id) ;   console.log(inner) ;
    document.getElementById('customer').value = inner;
    document.getElementById('livesearch').style.display = 'none';
    document.getElementById('CustId').value = id; 
    document.getElementById('CustId1').value = id; 
    document.getElementById('Currency').classList = 'form-select make-red';
    setTimeout(() => { document.getElementById('Currency').classList = 'form-select';  }, 3000);

}
  
function AJAXSearch(str) {
      document.getElementById('livesearch').style.display = '';
    if (str.length == 0) {
      return false;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200)  
          {
                var response = JSON.parse(this.responseText);
                var html = ''; 
                    if(response !=  '-1')
                    {
                      for(var count = 0; count < response.length; count++) 
                      {
                                  html += '<a href="#" onclick = "PutTheValueInTheBox( `' + response[count].CustName + '`   , ' + response[count].CustId + ')"  class="list-group-item list-group-item-action" aria-current="true">' ; 
                                  html += response[count].CustName; 
                                  html += '   </a>';
                      }
                    }

                    else html += '<a href="#" class="list-group-item list-group-item-action " aria-current="true"> No Match Found</a> ';
                    document.getElementById('livesearch').innerHTML = html;  
          }
       }
      xmlhttp.open("GET", "AJAXSearch.php?query=" + str, true);
      xmlhttp.send();
    }
}

function HideLiveSearch(){
    document.getElementById('livesearch').style.display = 'none';
}



</script>

 
<?php  require_once '../App/partials/Footer.inc'; ?>