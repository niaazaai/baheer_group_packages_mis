<?php 
ob_start();
require_once '../App/partials/Header.inc'; ?>
<?php 
    if(isset($_POST) && !empty($_POST))   
    {
 
        if( isset($_POST['design']) && !empty($_POST['design'])  )  {

            if(isset($_POST['CustId']) && !empty($_POST['CustId'])){
                
                    $CustomerData ="SELECT DISTINCT  carton.CustId1,carton.CTNOrderDate,carton.CTNFinishDate,ppcustomer.CustName,ppcustomer.CustMobile,ppcustomer.CustAddress,carton.CTNUnit
                    FROM carton INNER JOIN  ppcustomer ON carton.CustId1=ppcustomer.CustId  WHERE  CustId1=? ";
                    $DataRows  = $Controller->QueryData($CustomerData, [ $_POST['CustId']  ]);
                    $Rows= $DataRows ->fetch_assoc();
                    // var_dump($_POST['CustId']);
            }
            else {
                header("Location:IndividualQuotation.php?msg='No Customer Id' ");
            }      

        } # end of view and design isset 
        else {
            header("Location:IndividualQuotation.php");
        }
    }
    else   header("Location:IndividualQuotation.php");
?>

<?php require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  

 
<div class="card  m-3">
    <div class="card-body d-flex justify-content-between">
        <?php  $PageAddress = (isset($_POST['Address']) && !empty($_POST['Address'])) ? $_POST['Address']  : 'index' ;   ?>
        <a class= "btn btn-outline-primary  " href="<?=$PageAddress ?>.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
            </svg>
        </a>  

        <div> 
            <a  onclick = "Print()" class="btn btn-outline-primary  my-1"  title = "Click to Print Customer List ">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                 </svg>
            Print
           </a> 
           <a class="btn btn-outline-success  my-1"  title = "Click to Send it via what's up to Customer ">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                </svg> 
                Share
           </a>
    
            <a class="btn btn-outline-info  my-1"  title = "Click to Send it via what's up to Customer ">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-envelope " viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                </svg>
                Email
           </a>

           <a   class="btn btn-outline-danger   " id = "agrement-button"  onclick = "RemoveAgreement();alert('Agreement Removed From Print');"  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" id = "ag-logo-red" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" style = "display:none;" width="20" height="20" fill="currentColor"  id = "ag-logo-green" class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                    Agreement 
            </a>

            <a   class="btn btn-outline-danger   " id = "design-button"  onclick = "Removeimage();alert('Agreement Removed From Print');"  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" id = "design-logo-red" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" style = "display:none;" width="20" height="20" fill="currentColor"  id = "design-logo-green" class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                    Design 
            </a>

 
        </div>

        




           
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
                <span class="fs-2 mb-5">Quotation</span>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <hr class="fs-1 border border-4  border-info ">
            </div>
        </div> <!-- end of row div -->   

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <span class = "fw-bold"  >Quotation To: </span><?php echo $Rows['CustName']; ?> <br>
                <span class = "fw-bold">Phone : </span><?php echo $Rows['CustMobile']; ?> <br>
                <span class = "fw-bold">Address : </span><?php echo $Rows['CustAddress'] ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 d-flex justify-content-end ">
                <div class = "text-start" >
                    <span class = "fw-bold">Order Date: </span> <?php echo $Rows['CTNOrderDate'];?><br>
                    <span class = "fw-bold">DeadLine: </span><?php echo $Rows['CTNFinishDate']; ?><br>
                    <span class = "fw-bold">Customer ID: </span><?php echo $Rows['CustId1']; ?><br>
                </div>
            </div>
        </div>


        <div class="table-responsive  mt-5"><!-- table start div -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Quot No </th>
                        <th scope='col'>Description (L x W x H) cm </th> 
                        <th scope="col">Paper</th>
                        <th scope="col">Color</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Order QTY</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">ploymar</th>
                        <th scope="col">Die</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
            <?php
                $total=0; $i=1;
                    foreach ($_POST['design'] as $check) {
                        $Query='SELECT CTNId,ProductName, CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size  ,CTNUnit,CTNColor,CTNPaper,CTNQTY,CTNPrice,
                                CTNTotalPrice,MarketingNote,CTNOrderDate,CTNFinishDate, CFluteType,CTNType,CTNPolimarPrice,FinalTotal,CTNDiePrice,CtnCurrency,employeet.Ename , `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`,
                                `Ctnp5`, `Ctnp6`, `Ctnp7` FROM carton INNER JOIN employeet ON carton.EmpId = employeet.EId WHERE CTNId = ?';
                        $DataRows  = $Controller->QueryData($Query, [$check]);

                            if ($DataRows->num_rows > 0) 
                            {
                                $Rows= $DataRows ->fetch_assoc();
                                echo "<tr>";
                                echo "<td>".$i."</td>";
                                echo "<td>".$Rows['CTNId']."</td>";
                                echo "<td>" . $Rows['ProductName'] .' ( ' .   $Rows['Size']    . ' )' ."</td>";
    
                        ?>  
                        <td>  
                            <?php
        
                                $arr = []; 
                                for ($index=1; $index <= 7 ; $index++) 
                                { 
                                  if(empty($Rows['Ctnp'.$index])) continue; 
                                  $arr[] = $Rows['Ctnp'.$index];   
                                } 
                                $arr = array_count_values($arr);
                                foreach ($arr as $key => $value) {
                                    if(trim($key) === 'Flute') echo $value . " " . $key ;
                                    else  echo $key ; 
                                    if ($key === array_key_last($arr)) continue ; 
                                    echo " x ";
                                  
                                }  
 
                            ?>
                        </td>
                        <?php
                                echo "<td>".$Rows['CTNColor']."</td>";
                                echo "<td>".$Rows['CTNUnit']."</td>";
                                echo "<td>".number_format($Rows['CTNQTY'])."</td>";
                                echo "<td>".number_format($Rows['CTNPrice'] , 2 )."</td>";
                                echo "<td>".number_format($Rows['CTNPolimarPrice'])."</td>";
                                echo "<td>".number_format($Rows['CTNDiePrice'])."</td>";
                                echo "<td>".number_format($Rows['FinalTotal'])."</td>";
                           
                                echo "</tr>";
                                $total=$total+$Rows['FinalTotal'];
                                $i++;
                            }
                            else {
                                echo "<tr ><td colspan = '11' style = 'font-weight:bold; text-align:center ; font-size:18px; color:red;'> No Record Found or Data is Malformed</td><tr>";
                            }
                    }   
            ?>
                    <tr>
                        <td colspan='8' class="text-center">
                            <p class="fs-5 " style = "margin:0px; padding:0px; " ><bdi>در هنگام تولید امکان ۱۰ فیصد کاهش و افزایش در تعداد سفارش خواهد بود.</bdi></p>
                        </td>
                        <td   class = "fw-bold" >Total</td>
                        <td colspan='5' class="text-center fw-bold"> 
                            <?php  if(isset($Rows['CtnCurrency'])) 
                                    {
                                        echo number_format( $total)." <span class='badge bg-warning'> ". $Rows['CtnCurrency'];
                                    }?> </span> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><!-- table end div -->
    </div> <!-- card body end div -->
</div> <!-- card end div -->


<div class="card m-3"> <!-- card start div -->
    <div class="card-body fs-4 pe-5"  style="direction: rtl; unicode-bidi: bidi-override; "> <!-- card body start div -->
        <p style = "margin:0px; padding:0px; " ><bdi>مشتری گرامی !</bdi></p>
		<p style = "margin:0px; padding:0px; "  ><bdi>لطفاً یاداشت نمایید که انتقال کارتن به گونه قسط وار به هیچ عنوان پذیرفته نمیشود. </bdi></p>
		<p style = "margin:0px; padding:0px; "  > <bdi>همچنان ۵۰ فیصد پیش پرداخت باید تادیه شود و بدون پیش پرداخت کار شما شروع نمی شود.  </bdi></p>        
    </div> <!-- card body end div -->
</div> <!-- card end div -->

<div class="card m-3"> <!-- card start div -->
    <div class="card-body fs-4 pe-5"  style="direction: rtl; unicode-bidi: bidi-override; "> <!-- card body start div -->
        <p style = "margin:0px; padding:0px; " ><?php echo $Rows['MarketingNote']; ?></p>
    </div> <!-- card body end div -->
</div> <!-- card end div -->

<div class="card m-3"> <!-- card start div -->
    <div class="card-body"> <!-- card body start div -->


        <div class="row"> <!-- start of row div -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center mb-5 mt-3">
                <span class = "fw-bold">Prepared By: </span><?php echo $Rows['Ename']; ?> 
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12  text-center pt-2 mb-5 mt-3">
                <span class = "fw-bold" >Customer Signature</span>
            </div>
        </div> <!-- end of row div -->   
        <div class="row"> <!-- start of row div -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                The given price is valid only for 24 hours.
                <hr class="fs-1 border border-4  border-info">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-3">
                <span class="mb-5 fs-2">Thanks For Your Business</span>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-4">
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

<div class="card m-3"><!-- card start div -->
    <div class="card-body"> <!-- card-body start div -->       
        <?php
                foreach ($_POST['design'] as $check1)
                {
                    $Query1="SELECT carton.CTNId,designinfo.CaId,designinfo.DesignImage FROM carton LEFT OUTER JOIN designinfo ON designinfo.CaId=?";
                    $DataRows  = $Controller->QueryData($Query1, [$check1]);
                    $Rows= $DataRows ->fetch_assoc();
                    if (!empty($Rows['DesignImage'])) {   ?>	
                    
                    <div class = "p-3 mb-3" style = "border:3px solid black; border-radius:5px;  " >
                        <img class = "img-fluid" src="../Assets/<?=$Rows['DesignImage']?>"> 
                    </div>
                    
                    <?php
                    }
                }
        ?>	
    </div> <!-- card body end div -->
</div><!-- card end div -->


<div class="card m-3"><!-- card start div -->


    <div class="card-body"> <!-- card-body start div -->       
    <div class = "d-flex justify-content-end">
         <!-- EDIT  -->
        <button type="button" class="btn btn-outline-primary  my-1 " data-bs-toggle="modal" data-bs-target="#staticBackdrop" title = "Click to setup Columns  ">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>
            Edit Agreement 
        </button>

       
    </div> 
    <div class="">
        <?php 
         if(isset($_POST['agreement']) && !empty($_POST['agreement'])){
            $DataRows  = $Controller->QueryData("UPDATE ppcustomer SET  agreement=?  WHERE CustId = ?", [ $_POST['agreement'] , $_POST['CustId'] ]);
            if($DataRows) {
                echo '<div class="alert alert-success"> <strong>Agreement Updated Successfully</strong></div>'; 
            }
            else { 
                echo '<div class="alert alert-success"> <strong>Somthing went wrong , Please try again </strong></div>'; 
            }
        } 
        ?>
    </div>
    <hr>
    <?php
	
			$Query2="SELECT  agreement FROM  ppcustomer WHERE CustId=?";
            $DataRows = $Controller->QueryData($Query2, [$_POST['CustId']]);
            $Agreement= $DataRows ->fetch_assoc();
            echo "<h2 style='text-align:center;color:#148d8d;font-size:50px;'>  تعهد نامه مشتری       </h2>";
            echo "<p style='font-size:25px; text-align:right;color:#148d8d; margin:0px; padding:0px;'> " .  $Agreement['agreement']   ." </p>";
    		 

            echo "<p style='font-size:25px; text-align:right;color:#148d8d; margin:0px; padding:0px;'>    
            <mark>
نوت:    
</mark>
در صورت بروز کدام عوارض تخنیکی یا مشکلات دور از انتظار که باعث سکتگی یا تاخیر در تولید میگردد طرفین باید در نظر داشته باشند.
     </p>";
     echo "<p style='font-size:50px; text-align:center; padding-top:30px;color:#148d8d;'>  امضاء مشتری   </p>";

    		?>


</div> <!-- card body end div -->
</div><!-- card end div -->



<!-- Modal -->
<div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Agreement Content Here </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >

        <div class="modal-body "> 
            <?php  foreach ($_POST['design'] as $check) {?>
                <input type="hidden" name="design[]"  value = "<?=$check ?>" >
            <?php } ?>
            <input type="hidden" name="CustId" value = "<?=$_POST['CustId']?>" >
            <textarea class = "form-control " name="agreement" id="" cols="30" rows="10">
                <?=$Agreement['agreement'] ?>
            </textarea>
        </div><!-- END OF MODAL BODY  -->
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger " data-bs-dismiss="modal">Close</button>
            <button   class="btn btn-primary"  type="submit" >Save</button>
        </div>
      </form>

    </div>
  </div>
</div>
 
<script>
     function RemoveAgreement(){
        
           if(document.getElementById('Print_Area_Agreement').style.display == 'none') {
                document.getElementById('Print_Area_Agreement').style.display = ''; 
                document.getElementById('ag-logo-red').style.display = ''
                document.getElementById('ag-logo-green').style.display = 'none'    
                document.getElementById('agrement-button').classList  = 'btn btn-outline-danger';
                document.getElementById('agrement-button').title  = 'Click to remove agreement';
            }
            else {
                document.getElementById('Print_Area_Agreement').style.display = 'none'; 
                document.getElementById('ag-logo-red').style.display = 'none'
                document.getElementById('ag-logo-green').style.display = ''    
                document.getElementById('agrement-button').classList  = 'btn btn-outline-success';
                document.getElementById('agrement-button').title  = 'Click to add agreement';
            }
        
    }


    function Removeimage(){
             if(document.getElementById('remove_image_print').style.display == 'none') {
                document.getElementById('remove_image_print').style.display = ''; 
                document.getElementById('design-logo-red').style.display = ''
                document.getElementById('design-logo-green').style.display = 'none'    
                document.getElementById('design-button').classList  = 'btn btn-outline-danger';
                document.getElementById('design-button').title  = 'Click to remove Design Images';
            }
            else {
                document.getElementById('remove_image_print').style.display = 'none'; 
                document.getElementById('design-logo-red').style.display = 'none'
                document.getElementById('design-logo-green').style.display = ''    
                document.getElementById('design-button').classList  = 'btn btn-outline-success';
                document.getElementById('design-button').title  = 'Click to add Design Images';
            }

    }

</script>
 
<!-- width:21cm -->
<div id="print_area" class = "m-5" style = "display:none;width:21cm;" >
    
<?php 
    $CustomerData ="SELECT DISTINCT carton.CustId1,carton.CTNOrderDate,carton.CTNFinishDate,ppcustomer.CustName,ppcustomer.CustMobile,ppcustomer.CustAddress ,CTNUnit
    FROM carton INNER JOIN  ppcustomer WHERE  CustId=? AND carton.CustId1=ppcustomer.CustId";
    $DataRows  = $Controller->QueryData($CustomerData, [$_POST['CustId'] ]);
    $Rows= $DataRows ->fetch_assoc();
?>
<div class="m-1" style = "width:21cm; padding:1cm ; " > <!-- card start div -->
 
    <div class = "custom-image width:100%;  " style = "  display: flex; justify-content: center; align-items: center;"  >
        <img src="../Public/Img/Brand.svg" width = '180px' height = '90px' alt="Bahher Logo" style = "margin-left:-150px;" > 
        <span style = "font-size:24px; font-weight:bold; margin-left:100px; " > Baheer Printing & Packaging co.Ltd </span>  
    </div>
 
    <div  style = "margin-top:1cm; "  >
        <h4 style = "width: 100%;   border-bottom: 8px solid #1b4fd1!important;  line-height: 0.1em; " >
        <span style = " font-size:28px;  font-weight:bold;  padding:10px 20px;   background-color:white; margin-left:60%;" >Quotation</span></h4>
    </div>
    
    <div style = "  margin-top:1cm;">
        <div style="float:left;" >
            <span style = "font-weight:bold;"  >Quotation To: </span><?php echo $Rows['CustName']; ?> <br>
            <span style = "font-weight:bold;">Phone : </span><?php echo $Rows['CustMobile']; ?> <br>
            <span style = "font-weight:bold;">Address : </span><?php echo $Rows['CustAddress'] ?>
        </div>
        <div style=" text-align:right;">
                <span style = "font-weight:bold;">Order Date: </span> <?php echo $Rows['CTNOrderDate'];?><br>
                <span style = "font-weight:bold;">DeadLine: </span><?php echo $Rows['CTNFinishDate']; ?><br>
                <span style = "font-weight:bold;">Customer ID: </span><?php echo $Rows['CustId1']; ?><br>
        </div>
    </div>

     <div style = "  margin-top:1cm; " ><!-- table start div -->
        <table  style = "border:1px solid ; width: 100%;   border-collapse: collapse;  min-height:180px; " >
            <thead>
                <tr style = "border:1px solid; font-size:12px; font-weight:bold;  height:25px;">
                    <th style = "border:1px solid;" >#</th>
                    <th style = "border:1px solid; text-align:center;" >Quot No </th>
                    <th style = 'border:1px solid;'>Description (L x W x H) cm </th> 
                    <th style = "border:1px solid;" >Paper</th>
                    <th style = "border:1px solid;text-align:center;" >Color</th>
                    <th style = "border:1px solid;text-align:center;" >Unit</th>
                    <th style = "border:1px solid;" >Order QTY</th>
                    <th style = "border:1px solid;" >Unit Price</th>
                    <th style = "border:1px solid;" >ploymar</th>
                    <th style = "border:1px solid;" >Die</th>
                    <th style = "border:1px solid;" >Amount</th>
                </tr>
            </thead>
            <tbody>
        <?php
            $total=0; $i=1;
                foreach ($_POST['design'] as $check) 
                {
                    $Query='SELECT CTNId,ProductName, CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size  ,CTNUnit,CTNColor,CTNPaper,CTNQTY,CTNPrice,
                    CTNTotalPrice,MarketingNote,CTNOrderDate,CTNFinishDate, CFluteType,CTNType,CTNPolimarPrice,FinalTotal,CTNDiePrice,CtnCurrency,employeet.Ename , `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`,
                    `Ctnp5`, `Ctnp6`, `Ctnp7` FROM carton INNER JOIN employeet ON carton.EmpId = employeet.EId WHERE CTNId = ?';



                    $DataRows  = $Controller->QueryData($Query, [$check]);
                    $Rows= $DataRows ->fetch_assoc();
                            echo "<tr style = 'border:1px solid ;font-size:12px;  height:25px;'>";
                            echo "<td style = 'border:1px solid ;padding:3px; ' >".$i."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:center; ' >".$Rows['CTNId']."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; '>".$Rows['ProductName'] .' ( ' . $Rows['Size'] . " ) </td>"; 
 
                            ?>  
                            <td style = 'border:1px solid ;padding:3px; ' > 
                            <?php
                                $arr = []; 
                                for ($index=1; $index <= 7 ; $index++) 
                                { 
                                if(empty($Rows['Ctnp'.$index])) continue; 
                                $arr[] = $Rows['Ctnp'.$index];   
                                } 
                                $arr = array_count_values($arr);
                                foreach ($arr as $key => $value) {
                                    if(trim($key) === 'Flute') echo $value . " " . $key ;
                                    else  echo $key ; 
                                    if ($key === array_key_last($arr)) continue ; 
                                    echo " x ";
                                
                                }  
                            
                        
                            ?>
                            </td>
                            <?php  
                            echo "<td style = 'border:1px solid ;padding:3px;text-align:center;' >".$Rows['CTNColor']."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px;text-align:center;' >".  $Rows['CTNUnit']."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:right;' >".number_format(  $Rows['CTNQTY'] ) ."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:right;' >".number_format($Rows['CTNPrice'] , 2 ) ."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:right;' >".number_format($Rows['CTNPolimarPrice'])."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:right;' >".number_format($Rows['CTNDiePrice']) ."</td>";
                            echo "<td style = 'border:1px solid ;padding:3px; text-align:right;' >".number_format($Rows['FinalTotal']) ."</td>";
                            echo "</tr>";
                            $total=$total+$Rows['FinalTotal'];
                            $i++;                    
                } ?>
                <tr style = "height:200px;">
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                    <td style = "border:1px solid ; " ></td>
                </tr>
                <tr style = "height:25px;" >
                    <td colspan='7' style = "border:1px solid ; text-align:right;">
                        <p   style = " padding:3px; font-weight:bold; text-align:right; " ><bdi>در هنگام تولید امکان ۱۰ فیصد کاهش و افزایش در تعداد سفارش خواهد بود.</bdi></p>
                    </td>
                    <td style = 'border:1px solid; font-weight:bold; padding:3px; text-align:center;' >Total</td>
                    <td colspan='5' style = 'border:1px solid; text-align:right; padding:3px; font-weight:bold;' > <?php echo number_format($total)  ." - <span style = 'font-weight:bold; font-size:10px; ' >". $Rows['CtnCurrency']  . '</span>'; ?>   </td>
                </tr>

                <tr style = "border:1px solid; height:25px;" >
                    <td colspan='7' style = ' text-align:right;' >
                            <div class=" "  style="direction: rtl; unicode-bidi: bidi-override; padding:5px;"> <!-- card body start div -->
                                <p style = "margin:0px; padding:0px; font-weight:bold;" ><bdi>مشتری گرامی !</bdi></p>
                                <p style = "margin:0px; padding:0px; "  ><bdi>لطفاً یاداشت نمایید که انتقال کارتن به گونه قسط وار به هیچ عنوان پذیرفته نمیشود. </bdi></p>
                                <p style = "margin:0px; padding:0px; "  > <bdi>همچنان ۵۰ فیصد پیش پرداخت باید تادیه شود و بدون پیش پرداخت کار شما شروع نمی شود.  </bdi></p>        
                            </div> <!-- card body end div -->
                    </td>
                    <td colspan='6' style = 'border-right:1px solid ;' >    </td>
                </tr>
            </tbody>
        </table>
    </div><!-- table end div -->
    
    <div style = "border:1px solid; padding:5px; margin-top:5px;  "> <!-- card start div -->
        <div  style="direction: rtl; unicode-bidi: bidi-override; "> <!-- card body start div -->
            <p style = "margin:0px; padding:0px; " ><?php echo $Rows['MarketingNote']; ?></p>
        </div> <!-- card body end div -->
    </div> <!-- card end div -->

    <div style="display: flex;  justify-content: space-between; padding-left:20px; padding-right:20px; margin-top:3cm;"> <!-- start of row div -->
            <div> <span style = "font-weight:bold;" >Prepared By: </span> <?php echo $Rows['Ename']; ?>  <br>
            <span style = "font-weight:bold;" >Issued Date: </span> <?php echo date('H:i:s d-m-Y') ?>
            </div>
            
            <div style = "font-weight:bold;">Customer Signature</div>
    </div> <!-- end of row div -->   

    <div  style = "margin-top:2cm;"   >
        <span style = "padding:15px; margin-left:20px; font-weight:bold;" >The given price is valid only for 24 hours  </span>
        <h4 style = "width: 100%;   border-bottom: 8px solid #1b4fd1!important;  line-height: 0.1em;  margin-top:0px;   " >
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

    <div style="margin-top:2cm; " id="remove_image_print"> 
        <?php
                foreach ($_POST['design'] as $check1)
                {
                    $Query1="SELECT carton.CTNId,designinfo.CaId,designinfo.DesignImage FROM carton LEFT OUTER JOIN designinfo ON designinfo.CaId=?";
                    $DataRows  = $Controller->QueryData($Query1, [$check1]);
                    $Rows= $DataRows ->fetch_assoc();
                    if (!empty($Rows['DesignImage'])) {   ?>	
                        <div style = "padding:10px; margin-bottom:1cm;  border:2px solid black; border-radius:5px;  " >
                            <img style = "width:100%; " src="../Assets/DesignImages/<?=$Rows['DesignImage']?>"> 
                        </div>
                    <?php
                    }
                }
        ?>	
    </div> <!-- card body end div -->
 
    <div style="margin-top:2cm; display:none;" id = "Print_Area_Agreement"   > 
    <?php
	
        $Query2="SELECT  agreement FROM  ppcustomer WHERE CustId=?";
        $DataRows = $Controller->QueryData($Query2, [$_POST['CustId']]);
        $Agreement= $DataRows ->fetch_assoc();
        echo "<h2 style='text-align:center;color:#148d8d;font-size:50px;'>  تعهد نامه مشتری  </h2>";
        echo "<p style='font-size:25px; text-align:right;color:#148d8d; margin:0px; padding:0px;'> " .  $Agreement['agreement']   ." </p>";
        

        echo "<p style='font-size:25px; text-align:right;color:#148d8d; margin:0px; padding:0px;'>    
            <mark>
        نوت:    
        </mark>
        در صورت بروز کدام عوارض تخنیکی یا مشکلات دور از انتظار که باعث سکتگی یا تاخیر در تولید میگردد طرفین باید در نظر داشته باشند.
        </p>";
        echo "<p style='font-size:50px; text-align:center; padding-top:30px;color:#148d8d;'>  امضاء مشتری   </p>";

        ?>
   </div> <!-- card body end div -->

</div>
</div>
<!-- width:21cm -->




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


   

  </script>



<?php  require_once '../App/partials/Footer.inc'; ?>