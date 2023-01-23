<?php
    require_once './../App/partials/Header.inc'; require_once './../App/partials/Menu/MarketingMenu.inc'; 

    if(isset($_REQUEST['CTNId']) && !empty($_REQUEST['CTNId']))  {
        $CartonId = $_GET['CTNId']; 
        $CustomerData ="SELECT carton.CustId1,carton.CTNOrderDate,carton.CTNFinishDate,carton.PexchangeUSD,carton.CtnCurrency,ppcustomer.CustName,ppcustomer.CustMobile,ppcustomer.CustAddress 
        FROM carton INNER JOIN  ppcustomer ON carton.CustId1=ppcustomer.CustId  WHERE  CTNId=? ";
        $DataRows  = $Controller->QueryData($CustomerData, [$CartonId]);
        $Rows= $DataRows->fetch_assoc();
        $CustomerId = $Rows['CustId1'];
    }
?>

<div class="card  m-3">
    <div class="card-body d-flex justify-content-between">
        <a class= "btn btn-outline-primary  " href="#" >
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
            </svg>
        </a>  
         
        <a  onclick = "Print()" class="btn btn-outline-primary  my-1"  title = "Click to Print Customer List ">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
              <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
              <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
            </svg>
            Print
        </a>
    </div>
</div>

<div class="card m-3"> <!-- card start div -->
    <div class="card-body"> <!-- card body start div -->

        <div class="row"> <!-- start of row div -->
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 ">
                <img src="../Public/Img/Brand.svg"  alt="Bahher Logo">
            </div>
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 fs-1 text-center pt-2">
                Baheer Printing & Packaging co.Ltd
            </div>
        </div> <!-- end of row div -->   
        
        <div class="row"> <!-- start of row div -->
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 ">
                <hr class="fs-1 border border-4  border-info ">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 ">
                <span class="fs-2 mb-5">Invoice</span>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <hr class="fs-1 border border-4  border-info ">
            </div>
        </div> <!-- end of row div -->   





            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <span class = "fw-bold">Invoice To: </span><?php echo $Rows['CustName']; ?> <br>
                            <span class = "fw-bold">Phone : </span><?php echo $Rows['CustMobile']; ?> <br>
                            <span class = "fw-bold">Class : </span>PKG <br>
                            <span class = "fw-bold">Address : </span><?php echo $Rows['CustAddress'] ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                        <?php 

                            echo $CartonId ; 
                            $Query='SELECT CTNId,ProductName,  CONCAT( CTNLength , " x ", CTNWidth , " x " ,  CTNHeight  ) AS Size,CTNQTY,CTNOrderDate,
                            CTNPrice,PexchangeUSD,CTNTotalPrice,CTNUnit,FinalTotal,CtnCurrency,Tax 
                            FROM carton WHERE CTNId = ? ';
                            $DataRows  = $Controller->QueryData($Query, [$CartonId]);
                            $Rows= $DataRows ->fetch_assoc();
                        ?>
                            <div class="table-responsive  mt-5"><!-- table start div -->
                                <table class="table">
                                    <thead class="table-light fw-bold text-center">
                                        <tr>
                                            <th scope="col">QTY</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Description (L x W x H)</th>
                                            <th scope="col">Rate</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Tax</th>
                                            <th scope="col">Total Amount</th>
                                            <?php if ($Rows['Tax'] != 0) { ?>
                                            <th scope="col">Tax %  </th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php
                                    $TotalAmount=$Rows['FinalTotal']+$Rows['Tax'];$Total=0;
                                    $Amount=0;$Tax=0;$TaxAmount=($Rows['FinalTotal']*$Rows['Tax'])/100;
                                    echo "<tr>";
                                    echo "<td class='text-center'>".$Rows['CTNQTY']."</td>";
                                    echo "<td class='text-center'>".$Rows['CTNUnit']."</td>";
                                    echo "<td class='text-center'>".$Rows['ProductName']."</td>";
                                    echo "<td class='text-center'>".$Rows['PexchangeUSD']."</td>";
                                    echo "<td class='text-center'>".$Rows['FinalTotal']."</td>";
                                    echo "<td class='text-center'>".$TaxAmount."</td>";
                                    echo "<td class='text-center'>".$TotalAmount."</td>";
                                    if ($Rows['Tax'] != 0) { echo "<td class='text-center'>".$Rows['Tax']."%</td>"; }
                                    echo "</tr>";
                                    $Amount+=$Rows['FinalTotal'];
                                    $Tax+=$Rows['Tax'];
                                    $Total+=$TotalAmount;
                            ?>
                                        <tr>
                                            <td colspan='4' class="text-center"> Total </td>
                                            <td  class="text-center"><?php echo $Amount; ?></td>
                                            <td  class="text-center"><?php echo $Tax; ?></td>
                                            <td  class="text-center"><?php echo $Total." - <span class='badge bg-warning'>".$Rows['CtnCurrency']; ?></span></td>
                                            <?php if($Rows['Tax']!=0) {  echo "<td class='text-center'></td>"; } ?>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <table class="d-flex justify-content-end">
                        <tr>
                            <th>Invoice No:</th>
                            <td>3443</td>
                        </tr>
                        <tr>
                            <th>PO NO:</th>
                            <td>NULL</td>
                        </tr>
                        <tr>
                            <th>Project No:</th>
                            <td>NULL</td>
                        </tr>
                        <tr>
                            <th>Invoice Date:</th>
                            <td><?php echo $Rows['CTNOrderDate'];?></td>
                        </tr><tr>
                            <th>Due Date:</th>
                            <td>2022-2-23</td>
                        </tr><tr>
                            <th>Currency:</th>
                            <td><?php echo "<span class='badge bg-warning'>".$Rows['CtnCurrency'];?></span></td>
                        </tr><tr>
                            <th>Exchange Rate: &nbsp;&nbsp;</th>
                            <td><?php echo $Rows['PexchangeUSD'];?></td>
                        </tr>
                    </table>
                </div>



            </div>

           
          
        </div><!-- table end div -->
        <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <p style="float:right;" class="pe-5 me-5">Sales Tax &nbsp;<?php echo $TaxAmount; ?></p>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <p style="float:right;" class="pe-5 me-5">USD &nbsp;<?php echo $TaxAmount/$Rows['PexchangeUSD']; ?></p>
                </div>

            </div>


<div class="card m-3"> <!--card start div-->
    <div class="card-body"><!-- card body start div-->


        <div class="row"> <!-- start of row div -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mb-5 mt-3">
                <span class = "fw-bold" style="padding-left:500px;">Sign/stamp</span> 
            </div>
        </div> <!-- end of row div -->   
        <div class="row mt-5"> <!-- start of row div -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                <b> بهیر گروپ د لوړ کیفیت او غوره تولید یواځیني مرجع </b>
                <p>Baheer Group Recognized the best quality</p>
                <hr class="fs-1 border border-4  border-info">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-5">
                <span class="mb-5 fs-2">Thanks For Your Business</span>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-5">
                <hr class="fs-1 border border-4  border-info ">
            </div>
        </div> <!-- end of row div -->   
        <div class="row"><!-- start of row div -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-telephone-inbound text-primary" viewBox="0 0 16 16">
                    <path d="M15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0zm-12.2 1.182a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                </svg> &nbsp; 
                <span> +93(0)782226558  &nbsp;  &nbsp; </span>
                <span> +93(0)782226558</span>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-envelope text-primary" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                </svg>
                 &nbsp; 
                <span>marketing.pkg@baheer.af  &nbsp;  &nbsp; </span>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-globe text-primary" viewBox="0 0 16 16">
                    <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/>
                </svg> &nbsp; 
                <span>www.baheer.af</span>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-geo-alt text-primary" viewBox="0 0 16 16">
                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg> &nbsp;
                <span>Street# 3, Sarak Naw Bagram, Dispachari, Kabul-Afghanistan</span>
            </div>
        </div><!-- end of row div --> 

    </div> <!-- card body end div -->
</div> <!-- card end div -->


</div> <!-- card body end div -->
</div> <!-- card end div -->





















<script type="text/javascript">
  
    function Print()   {
        Employee = window.open('', '', 'status=0,width=1350,height=1480,top= 10,left=100');
        let printarea = document.getElementById('print_area');
        Employee.document.write('<html><head>');
        Employee.document.write('</head>');
        Employee.document.write('<body>');
        Employee.document.write(printarea.innerHTML);
        Employee.document.write('</body></html>');
        Employee.document.close();
        Employee.focus();
        Employee.print();
    }

    function RemoveAgreement(){
        document.getElementById('Print_Area_Agreement').style.display = 'none'; 
    }

    function Removeimage(){
        document.getElementById('remove_image_print').style.display = 'none'; 
    }

</script>






 

<!-- width:21cm -->
<div id="print_area" class = "m-5" style = "display:none ; width:21cm " >
    
    <?php 
        $CustomerData ="SELECT carton.CustId1,carton.CTNOrderDate,carton.CTNFinishDate,carton.PexchangeUSD,carton.CtnCurrency,ppcustomer.CustName,ppcustomer.CustMobile,ppcustomer.CustAddress 
        FROM carton INNER JOIN  ppcustomer ON carton.CustId1=ppcustomer.CustId  WHERE  CTNId=? ";
        $DataRows  = $Controller->QueryData($CustomerData, [$CartonId]);
        $Rows= $DataRows->fetch_assoc();
    ?>
    <div class="m-1" style = "width:21cm; padding:1cm ; " > <!-- card start div -->
        <div class = "custom-image width:100%;  " style = "  display: flex; justify-content: center; align-items: center; "  >
            <img src="../Public/Img/Logo.png" width = '180px' height = '90px' alt="Bahher Logo" style = "margin-left:-150px;" > 
            <span style = "font-size:24px; font-weight:bold; margin-left:100px; color:blue; " > Baheer Printing & Packaging co.Ltd </span>  
        </div>
   

        <!-- #0dcaf0!important; -->
        <div  style = "margin-top:1cm; "  > 
            <h4 style = "width: 100%;   border-bottom: 8px solid blue;   line-height: 0.1em; " >
            <span style = " font-size:28px;  font-weight:bold;  padding:10px 20px;   background-color:white; margin-left:60%;" >Invoice</span></h4>
        </div>
  
 

        <div style = "  margin-top:1cm;">
            <div style="float:left;" >
                 <span class = "fw-bold">Invoice To: </span><?php echo $Rows['CustName']; ?> <br>
                <span class = "fw-bold">Phone : </span><?php echo $Rows['CustMobile']; ?> <br>
                <span class = "fw-bold">Class : </span>PKG <br>
                <span class = "fw-bold">Address : </span><?php echo $Rows['CustAddress'] ?>
        </div>
        <div style=" text-align:right;">
        <table class="table table-responsive">
                        <tr>
                            <th>Invoice No</th>
                            <td>3443</td>
                        </tr>
                        <tr>
                            <th>PO NO</th>
                            <td>NULL</td>
                        </tr>
                        <tr>
                            <th>Project No</th>
                            <td>NULL</td>
                        </tr>
                        <tr>
                            <th>Invoice Date</th>
                            <td><?php echo $Rows['CTNOrderDate'];?></td>
                        </tr><tr>
                            <th>Due Date</th>
                            <td>2022-2-23</td>
                        </tr><tr>
                            <th>Currency</th>
                            <td><?php echo "<span class='badge bg-warning'>".$Rows['CtnCurrency'];?></span></td>
                        </tr><tr>
                            <th>Exchange Rate</th>
                            <td><?php echo $Rows['PexchangeUSD'];?></td>
                        </tr>
                    </table>
        </div>
    </div>

    <?php 
         $total=0; $id=90;
         $Query='SELECT CTNId,ProductName,  CONCAT( CTNLength , " x ", CTNWidth , " x " ,  CTNHeight  ) AS Size,CTNQTY,CTNPrice,PexchangeUSD,CTNTotalPrice,CTNUnit,
         FinalTotal,CtnCurrency,Tax 
         FROM carton WHERE CTNId = ? ';
         $DataRows  = $Controller->QueryData($Query, [$CartonId]);
         $Rows= $DataRows ->fetch_assoc();
     ?>
     <div style = "  margin-top:1cm; " ><!-- table start div -->
        <table  style = "border:1px solid ; width: 100%;   border-collapse: collapse;  min-height:180px; " >
            <thead>
                <tr style = "border:1px solid; font-size:12px; font-weight:bold;  height:25px;">
                    <th style = "border:1px solid;" >QTY</th>
                    <th style = "border:1px solid; text-align:center;" >Item </th>
                    <th style = "border:1px solid;" >Description (L x W x H)</th>
                    <th style = "border:1px solid;" >Rate</th>
                    <th style = "border:1px solid;" >Amount</th>
                    <th style = "border:1px solid;" >Tax</th>
                    <th style = "border:1px solid;text-align:center;" >Total Amount</th>
                    <?php if ($Rows['Tax'] != 0) { ?>
                        <th scope="col" style = "border:1px solid;" 0>Tax %  </th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
        <?php
            $total=0; 
            $TaxAmount=($Rows['FinalTotal']*$Rows['Tax'])/100;
            $TotalAmount=$Rows['FinalTotal']+$TaxAmount;$Total=0;
            $Amount=0;$Tax=0;
                            echo "<tr style = 'border:1px solid ;font-size:12px;  height:25px;'>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:center; ' >".$Rows['CTNQTY']."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px;text-align:center;' >".$Rows['CTNUnit']."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; ' >".$Rows['ProductName'] .' ( ' . $Rows['Size'] . " )</td>";
                            echo "<td style = 'border:1px solid ;padding:3px;text-align:center;' >".$Rows['PexchangeUSD']."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:right;' >".$Rows['FinalTotal']."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:right;' >".$TaxAmount."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:right;' >". $TotalAmount."</td>";
                            if ($Rows['Tax'] != 0) { echo "<td style = 'border:1px solid ;padding:3px; text-align:right;' >".$Rows['Tax']." % </td>"; }
                            echo "</tr>";
                            $total=$total+$Rows['FinalTotal'];

                            $Amount+=$Rows['FinalTotal'];
                            $Tax+=$Rows['Tax'];
                            $Total+=$TotalAmount;
                    ?>
                            <tr>
                                <td colspan='4' class="text-center"> Total </td>
                                <td  class="text-center"><?php echo $Amount; ?></td>
                                <td  class="text-center"><?php echo $Tax; ?></td>
                                <td  class="text-center"><?php echo $Total." - <span class='badge bg-warning'>".$Rows['CtnCurrency']; ?></span></td>
                                <?php if($Rows['Tax']!=0) {  echo "<td class='text-center'></td>"; } ?>
                            </tr>

            </tbody>
        </table>
    </div><!-- table end div -->
    

    <div style="display: flex;  justify-content: space-between; padding-left:20px; padding-right:20px; margin-top:3cm;"> <!-- start of row div -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mb-5 mt-3">
                <span class = "fw-bold" style="padding-left:500px;">Sign/stamp</span> 
            </div>
    </div> <!-- end of row div -->   

<!-- /#0dcaf0!important;  -->
 

    <div  style = "  margin-top:2cm;"   >
        <span style = "padding:15px; margin-left:20px; font-weight:bold;" ><b> بهیر گروپ د لوړ کیفیت او غوره تولید یواځیني مرجع </b>
                <p>Baheer Group Recognized the best quality</p></span>
        <h4 style = "width: 100%;   border-bottom: 8px solid blue;  line-height: 0.1em;  margin-top:0px;   " >
            <span style = " font-size:18px;  font-weight:bold;  padding:10px 30px;   background-color:white; margin-left:50%;   " >Thank you for your Business</span>
        </h4>
    </div>

   
    <div> 
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-inbound text-primary" viewBox="0 0 16 16">
                <path d="M15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0zm-12.2 1.182a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
            </svg> &nbsp; 
            <span> +93(0)782226558  &nbsp;  &nbsp; </span> <span> +93(0)782226558</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope text-primary" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
            </svg>
                &nbsp; 
            <span>marketing.pkg@baheer.af  &nbsp;  &nbsp; </span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-globe text-primary" viewBox="0 0 16 16">
                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/>
            </svg> &nbsp; 
            <span>www.baheer.af</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt text-primary" viewBox="0 0 16 16">
                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
            </svg> &nbsp;
            <span>Street# 3, Sarak Naw Bagram, Dispachari, Kabul-Afghanistan</span>
        </div>

      
    </div><!-- end of row div --> 
 

 
   </div> <!-- card body end div -->

</div>
</div>
<!-- width:21cm -->






<?php  require_once './../App/partials/Footer.inc';    ?>


