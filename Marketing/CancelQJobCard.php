<?php  
    ob_start(); 
    require_once '../App/partials/Header.inc';  
    if(isset($_GET['CTNId']) && !empty($_GET['CTNId'])   ) {
        
    $SQL="SELECT `CTNId`,ppcustomer.CustName , `JobNo`, `CTNPrice`, `CTNTotalPrice`, `CTNOrderDate`, `CTNStatus`, `CTNQTY`, `CTNUnit`, `CTNPolimarPrice`, `CTNDiePrice`, 
    `ReceivedAmount`, CTNFinishDate, `CTNWidth`, `CTNHeight`, `CTNLength`,CTNPaper, ppcustomer.CustAddress, `CSlotted`, `CDieCut`, `CPasting`, `CStitching`, 
    `CFluteType`, CTNColor, ProductName, ProductQTY, Note, CtnCurrency, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`, `Ctnp5`, `Ctnp6`, `Ctnp7`, `offesetp`, `flexop`, CancelComment, Canceldate,   FinalTotal FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 where CTNId=?";
    $DataRow=$Controller->QueryData($SQL,[$_GET['CTNId'] ]);
    $Rows=$DataRow->fetch_assoc();

    }
    else {
        header('Location:JobCenter.php?msg=No Carton Id is set &class=danger');
    }

 
    require_once '../App/partials/Menu/MarketingMenu.inc'; 

 ?>

<style>


 

.package-item-header {
    margin-top: -4%;
    margin-left: 10px;
    width: 80%;
    border:2px solid red;
    text-align: center;
    font-size: 16px;
    border-radius:5px; 
    position: relative;
    padding: 5x;
      /* padding-bottom:40px; */
    overflow: visible ;
    float: left;
  }
  
  .package_stamp {
    height: 120px;
    width: 120px;
    background: url('../Assets/SystemImages/Cancel.svg')  no-repeat;
    background-position: center;
    position: absolute;
    top: -20px;
    right: -100px;
    background-size: cover;
    z-index: 1;
  }
  
    img.package_stamp {
    border: 1px solid white;
    }



</style>
<div class="card m-3">
    <div class="card-body">
        <a class="btn btn-outline-primary me-3" href="CancelQuotation.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
            </svg>
        </a>
    </div>
</div>
<div class="card m-3 shadow">
    <div class="card-body">
        <div class = "row">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <img src="../public/img/logo-brand.png"  width = "210px" height= "100px" alt="BGC Logo"> 
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                 <h3 class = " pt-2 fw-bold" style="padding-left:270px;" > Baheer Group Of Companies </h3>
                 <p style= "color:#FA8b09; padding-left:310px;font-size:20px;" > PKG - Cancel Job Card </p>
            </div> 
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-end my-3">
                <a  onclick = "Print()" class="btn btn-outline-primary  my-1 fs-5"  title = "Click to Print Customer List ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                    </svg>
                    Print
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card m-3 shadow ">
    <div class="card-body">
        <p class="fs-5 fw-bold pe-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
            </svg>
            Customer Info
        </p>
        <table class="table ">
            <tr class="table-info">
                <th>Quotation No</th>
                <th>Company</th>
                <th>Product Name</th>
                <th>Customer Address</th>
                <th>Order Date</th>
                <th>Deadline</th>
                <th>Job No</th>
            </tr>
            <tr>
                <td><?=$Rows['CTNId']?></td>
                <td><?=$Rows['CustName']."&nbsp;&nbsp;<span class='badge bg-warning'> ".$Rows['CtnCurrency']?></span></td> 
                <td><?=$Rows['ProductName']?></td>
                <td><?=$Rows['CustAddress']?></td>
                <td><?=$Rows['CTNOrderDate']?></td>
                <td><?=$Rows['CTNFinishDate']?></td>
                <td><?=$Rows['JobNo']?></td>
            </tr>
            <tr class="table-info">
                <th>Order QTY</th>
                <th>Unit Price ( <?=$Rows['CtnCurrency']?> )</th>
                <th>Total Amount</th>
                <th>Polymer Price</th>
                <th>Die Price</th>
                <th>Grand Total</th>
                <th>Box Type</th>
            </tr>
            <tr>
                <td><?=$Rows['CTNQTY']?></td>
                <td><?=$Rows['CTNPrice']?></td> 
                <td><?=$Rows['CTNTotalPrice']?></td>
                <td><?=$Rows['CTNPolimarPrice']?></td>
                <td><?=$Rows['CTNDiePrice']?></td>
                <td><?=$Rows['FinalTotal']?></td>
                <td><?=$Rows['CTNUnit']?></td>
            </tr>
        </table>
    </div>
</div>




<div class="card m-3 shadow">
    <div class="card-body">
        <p class="fs-5 fw-bold pe-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
            </svg>
            Product Info
        </p>
    
        <div class="row m-0 p-0">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-0 p-0">
                <table class="table m-0 p-0">
                        <tr class="table-info">
                            <th>Length</th>
                            <th>Width</th>
                            <th>Height</th>
                        </tr>

                        <tr>
                            <td><?=$Rows['CTNLength']?></td>
                            <td><?=$Rows['CTNWidth']?></td> 
                            <td><?=$Rows['CTNHeight']?></td>
                         
                        </tr>
                </table>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-0 p-0 "   >


            <div class="package-item-header"><div class="package_stamp"></div><?php 
                if(empty($Rows['CancelComment']) )   $Rows['CancelComment'] = 'No Comment'; 
                if(empty($Rows['Canceldate']) )   $Rows['Canceldate'] = 'No Date'; 
                echo  "<span style = 'font-size:18px; ' >" .  $Rows['CancelComment'] . '</span><br>' .  '[ ' . $Rows['Canceldate'] . ' ]';
            ?></div>


             
            </div>
        </div>


        <div class="row m-0 p-0 ">
            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6 m-0 p-0">
                <table class="table ">
                        <tr class="table-info">
                            <th>1st Page</th>
                            <th>2nd Page</th>
                            <th>3rd Page</th>
                            <th>4th Page</th>
                            <th>5th Page</th>
                            <th>6th Page</th>
                            <th>7th Page</th>
                        </tr>
                        <tr>
                            <td><?=$Rows['Ctnp1']?></td>
                            <td><?=$Rows['Ctnp2']?></td> 
                            <td><?=$Rows['Ctnp3']?></td>
                            <td><?=$Rows['Ctnp4']?></td>
                            <td><?=$Rows['Ctnp5']?></td>
                            <td><?=$Rows['Ctnp6']?></td>
                            <td><?=$Rows['Ctnp7']?></td>
                        </tr>
                </table>
            </div>
        </div>



        

    </div>
</div>
      


 


<div class="card m-3 shadow">
    <div class="card-body">
        <p class="fs-5 fw-bold  pe-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
            </svg>
           Printing Info
        </p>
        <table class="table ">
            <tr class="table-info">
                <th>Slotted</th>
                <th>Die Cut</th>
                <th>Pasting</th>
                <th>Stiteching</th>
                <th>Flute Type</th>
                <th>Color</th>
                <th>Flexo Print</th>
                <th>Offset Print</th>
            </tr>
            <tr>
                <td><?=$Rows['CSlotted']?></td>
                <td><?=$Rows['CDieCut']?></td> 
                <td><?=$Rows['CPasting']?></td>
                <td><?=$Rows['CStitching']?></td>
                <td><?=$Rows['CFluteType']?></td>
                <td><?=$Rows['CTNColor']?></td>
                <td><?=$Rows['flexop']?></td>
                <td><?=$Rows['offesetp']?></td>
            </tr>
        </table>
    </div>
</div>

<div class="card m-3 shadow">
    <div class="card-body">
        <p class="fs-5 fw-bold pe-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-journal-bookmark" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
            </svg>
           Marketing Note
        </p>
        <table class="table ">
            <tr class="table-info">
                <th>Note: <?=$Rows['Note']?> </th>
            </tr>
        </table>
    </div>
</div>










<script>
function Print()
{
    var printContent = document.getElementById("print_area");
    var WinPrint = window.open('', 'directories=no,fullscreen=yes,location=no', 'width=auto,height=auto');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
 
}
</script>


<div id="print_area" class = "m-5" style = "display:none; width:21cm ">
    <div class="padding-left:50px; padding-right:50px; padding-top:50px;">
<style>
    .border
    {
        border: 1px solid black;
        border-collapse: collapse;
        width:1250px;
        margin-left:20px;
        margin-right:20px;
        font-size:20px;
        text-align:center;
        padding:5px;
    }
    .th{
        background: lightblue;
        padding:10;
    }
    
	.remove_table , .top_th  
    {
			border: none;
			border-collapse: collapse;
	}



.td-width {
    width: 80%;
}
    
.package-item-header1 {
    margin-top: -3%;
    margin-left: 5px;
    width: 70%;
    border:2px solid red;
    text-align: center;
    font-size: 16px;
    border-radius:5px; 
    position: relative;
    padding: 5px;
    overflow: visible;
    float: left;
  }
  
  .package_stamp1 {
    height: 120px;
    width: 120px;
    background: url('../Assets/SystemImages/Cancel.svg')  no-repeat;
    background-position: center;
    position: absolute;
    top: -30px;
    right: -100px;
    background-size: cover;
    z-index: 1;
  }
  
    img.package_stamp1 {
    border: 1px solid white;
    }



</style>
        <table class=".remove_table">
            <tr>
                <th>
                    <img src="../public/img/Logo.png" width = "210px" height= "100px"   alt="BGC Logo"> 
                </th>
                <th> 
                    <h3 class = " pt-2 " style="padding-left:270px; font-size:30px;" > Baheer Group Of Companies </h3>
                    <p style= " padding-left:265px;font-size:20px; font-size:30px;" > PKG - Cancel Job Card </p>
                </th>
            </tr>   

        </table>

        <p style="padding-left:22px; font-size:30px;">
            Customer Info
        </p>
        <table class="border">
            <tr >
                <th class="border th">Quotation No</th>
                <th class="border th">Company</th>
                <th class="border th">Product Name</th>
                <th class="border th">Customer Address</th>
                <th class="border th">Order Date</th>
                <th class="border th">Deadline</th>
                <th class="border th">Job No</th>
            </tr>
            <tr>
                <td class="border"><?=$Rows['CTNId']?></td>
                <td class="border"><?=$Rows['CustName']."&nbsp;&nbsp;<span class='badge bg-warning'> ".$Rows['CtnCurrency']?></span></td> 
                <td class="border"><?=$Rows['ProductName']?></td>
                <td class="border"><?=$Rows['CustAddress']?></td>
                <td class="border"><?=$Rows['CTNOrderDate']?></td>
                <td class="border"><?=$Rows['CTNFinishDate']?></td>
                <td class="border"><?=$Rows['JobNo']?></td>
            </tr>
            <tr>
                <th class="border th">Order QTY</th>
                <th class="border th">Unit Price ( <?=$Rows['CtnCurrency']?> )</th>
                <th class="border th">Total Amount</th>
                <th class="border th">Polymer Price</th>
                <th class="border th">Die Price</th>
                <th class="border th">Grand Total</th>
                <th class="border th">Box Type</th>
            </tr>
            <tr>
                <td class="border"><?=$Rows['CTNQTY']?></td>
                <td class="border"><?=$Rows['CTNPrice']?></td> 
                <td class="border"><?=$Rows['CTNTotalPrice']?></td>
                <td class="border"><?=$Rows['CTNPolimarPrice']?></td>
                <td class="border"><?=$Rows['CTNDiePrice']?></td>
                <td class="border"><?=$Rows['FinalTotal']?></td>
                <td class="border"><?=$Rows['CTNUnit']?></td>
            </tr>
        </table>



        <p style="padding-left:22px; font-size:30px;">
            Product Info
        </p>

        <div>
            <table class="border " style = " float:left;  width:50%; margin-bottom:0; padding:0px;" >
                <tr style = "margin-bottom:0; padding:0px; ">
                    <th class="border th">Length</th>
                    <th class="border th">Width</th>
                    <th class="border th">Height</th>
                     
                </tr>
                <tr>
                    <td class="border" style = "border-bottom:0px solid red;" ><?=$Rows['CTNLength']?></td>
                    <td class="border" style = "border-bottom:0px solid;" ><?=$Rows['CTNWidth']?></td> 
                    <td class="border" style = "border-bottom:0px solid;" ><?=$Rows['CTNHeight']?></td>
                </tr>
            </table>

            <table>
                <tr>
                    <td>
                        <div class="package-item-header1">
                                <div class="package_stamp1"></div><?php 
                                    if(empty($Rows['CancelComment']) )   $Rows['CancelComment'] = 'No Comment'; 
                                    if(empty($Rows['Canceldate']) )   $Rows['Canceldate'] = 'No Date'; 
                                    echo  "<span style = 'font-size:18px; ' >" .  $Rows['CancelComment'] . '</span><br>' .  '[ ' . $Rows['Canceldate'] . ' ]';
                                ?>
                        </div>
                    </td>
                </tr>
            </table>
           
        </div>

        
            


<table class="border">
            <tr>
                <th class="border th">1st Page</th>
                <th class="border th">2nd Page</th>
                <th class="border th">3rd Page</th>
                <th class="border th">4th Page</th>
                <th class="border th">5th Page</th>
                <th class="border th">6th Page</th>
                <th class="border th">7th Page</th>
            </tr>
            <tr>
                <td class="border"><?=$Rows['Ctnp1']?></td>
                <td class="border"><?=$Rows['Ctnp2']?></td> 
                <td class="border"><?=$Rows['Ctnp3']?></td>
                <td class="border"><?=$Rows['Ctnp4']?></td>
                <td class="border"><?=$Rows['Ctnp5']?></td>
                <td class="border"><?=$Rows['Ctnp6']?></td>
                <td class="border"><?=$Rows['Ctnp7']?></td>
            </tr>
        </table>

        <p style="padding-left:22px; font-size:30px;">
           Printing Info
        </p>
        <table class="border">
            <tr>
                <th class="border th">Slotted</th>
                <th class="border th">Die Cut</th>
                <th class="border th">Pasting</th>
                <th class="border th">Stiteching</th>
                <th class="border th">Flute Type</th>
                <th class="border th">Color</th>
                <th class="border th">Flexo Print</th>
                <th class="border th">Offset Print</th>
            </tr>
            <tr>
                <td class="border"><?=$Rows['CSlotted']?></td>
                <td class="border"><?=$Rows['CDieCut']?></td> 
                <td class="border"><?=$Rows['CPasting']?></td>
                <td class="border"><?=$Rows['CStitching']?></td>
                <td class="border"><?=$Rows['CFluteType']?></td>
                <td class="border"><?=$Rows['CTNColor']?></td>
                <td class="border"><?=$Rows['flexop']?></td>
                <td class="border"><?=$Rows['offesetp']?></td>
            </tr>
        </table>

        <p style="padding-left:22px; font-size:30px;">
           Marketing Note
        </p>
        <table >
            <tr >
                <th style="padding-left:22px; font-size:25px;">Note: <?=$Rows['Note']?> </th>
            </tr>
        </table>

    </div>      
</div>

<?php  require_once '../App/partials/Footer.inc'; ?>
