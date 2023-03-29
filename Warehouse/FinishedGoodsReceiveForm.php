 
<?php
ob_start(); 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;

    if(isset($_REQUEST['CTNId']) && !empty($_REQUEST['CTNId']) )  {

        $CTNId=$_REQUEST['CTNId'];  
        $SQL='SELECT CTNId,ppcustomer.CustName,CTNUnit, CONCAT(FORMAT(CTNLength/10,1),"x",FORMAT(CTNWidth/10,1),"x",FORMAT(CTNHeight/ 10,1)) AS Size ,CTNStatus,CTNQTY,ProductQTY,
        ProductName,CTNPaper,CTNColor,JobNo,Note,offesetp ,cartonproduction.CtnId1, cartonproduction.ManagerApproval,ProBrach, 
        cartonproduction.ProQty,ProOutQty,Plate,`Line`,Pack,ExtraPack,Carton1,ExtraCarton FROM  carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        INNER JOIN cartonproduction ON cartonproduction.CtnId1=carton.CTNId WHERE  CTNId = ? ORDER BY CTNOrderDate DESC';
        $DataRows=$Controller->QueryData($SQL,[$CTNId]);
        $Rows=$DataRows->fetch_assoc();
        $ReminingQTY=$Rows['CTNQTY']-$Rows['ProductQTY'];
    }
    else header("Location:JobCenter.php?MSG=No CTN ID");


    if(isset($_POST['Save&submit'])) {
        $CTNId=$_REQUEST['CTNId'];
        $ProId=$_REQUEST['ProId'];
        $Status=1;  
        $Update=$Controller->QueryData("UPDATE cartonproduction SET ProStatus='Accept', StockInDate=CURRENT_TIMESTAMP,ReceivedBy=?  WHERE ProId = ?",[$_SESSION['EId'],$ProId]);
        if($Update)  header("Location:JobCenter.php?MSG=produced QTY Successfully hand over to warehouse&State=".$Status);
    }
    if(isset($_POST['Reject'])) {
        $CTNId=$_REQUEST['CTNId']; 
        $ProId=$_REQUEST['ProId'];
        $Status=1;  
        $Update=$Controller->QueryData("UPDATE cartonproduction SET ProStatus='Pending' , ReceivedBy=? WHERE  ProId = ?",[$_SESSION['EId'],$ProId]);
        if($Update)  header("Location:JobCenter.php?MSG=produced QTY Rejected from warehouse side&State=".$Status);
    }
?>

<div class="card m-3">
    <div class="card-body">
        <h3 class ="m-0 p-0" >
            <a class="btn btn-outline-primary " href="JobCenter.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
            </a>
            <span style = "border-bottom:3px dotted red; margin:3px; padding:3px;" >  Produced goods </span> from production department  
        </h3>
    </div>
</div>
 


<div class="card m-3">
    <div class="card-body">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 my-1">
                <table class="table table-bordered border-primary">
                    <tr>
                        <th>
                            <strong> 
                                <svg xmlns="http://www.w3.org/2000/svg"  width="25" height="25" fill="currentColor"   viewBox="0 0 16 16">
                                    <path d="M8.39 12.648a1.32 1.32 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1.06 1.06 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.512.512 0 0 0-.523-.516.539.539 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532 0 .312.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531 0 .313.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242l-.515 2.492zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"/>
                                </svg> Job No: 
                            </strong>
                        </th>
                        <td><?=$Rows['JobNo']; ?></td>
                    </tr>
                    <tr>
                        <th>

                            <strong>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"   viewBox="0 0 16 16">
                                    <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"/>
                                    <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z"/>
                                </svg>
                            Company Name : 
                            </strong> 
                        </th>
                        <td><?=$Rows['CustName']; ?></td>
                    </tr>
                    <tr>
                        <th>
                            <strong>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                </svg>
                                Product Name : 
                            </strong> 
                        </th>
                        <td><?=$Rows['ProductName']; ?></td>
                    </tr>
                    <tr>
                        <th><strong> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
                            </svg>
                            Unit : </strong> </th>
                        <td><?=$Rows['ProBrach']; ?></td>
                    </tr>
                </table>
            </div>  <!-- end of col -->

            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 my-1">
                <table class="table table-bordered border-primary">
                    <tr>
                        <th><strong>
                             <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"   viewBox="0 0 16 16">
                                <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z"/>
                                <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z"/>
                            </svg> Produced QTY :</strong>
                        </th>
                        <td><?=$Rows['ProductQTY']; ?></td>
                    </tr>
                    <tr>
                        <th>
                        <strong>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-layers-fill" viewBox="0 0 16 16">
                                <path d="M7.765 1.559a.5.5 0 0 1 .47 0l7.5 4a.5.5 0 0 1 0 .882l-7.5 4a.5.5 0 0 1-.47 0l-7.5-4a.5.5 0 0 1 0-.882l7.5-4z"/>
                                <path d="m2.125 8.567-1.86.992a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882l-1.86-.992-5.17 2.756a1.5 1.5 0 0 1-1.41 0l-5.17-2.756z"/>
                            </svg>
                            Remain QTY : 
                        </strong> </th>
                        <td><?=$ReminingQTY; ?></td>
                    </tr>
                    <tr>
                        <th>
                            <strong>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C2.25 2 1.49 2.759 1.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6ZM14.886 7.9v.164c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456v-1.3c-1.114 0-1.49-.362-1.49-1.456V4.352C14.51 2.759 13.75 2 12.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6ZM7.5 11.5V9.207l-1.621 1.621-.707-.707L6.792 8.5H4.5v-1h2.293L5.172 5.879l.707-.707L7.5 6.792V4.5h1v2.293l1.621-1.621.707.707L9.208 7.5H11.5v1H9.207l1.621 1.621-.707.707L8.5 9.208V11.5h-1Z"/>
                                </svg>
                                Order QTY :
                             </strong>
                        </th>
                        <td><?=$Rows['CTNQTY']; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Status : </strong> </th>
                        <td><?=$Rows['CTNStatus']; ?></td>
                    </tr>
                </table>
            </div>  <!-- end of col -->
            
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 my-1">
                <table class="table table-bordered border-primary">
                    <tr>
                        <th><strong>Total Plate : </strong></th>
                        <td><?=$Rows['Plate']; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Packed In Line :</strong> </th>
                        <td><?=$Rows['Line']; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Packs : </strong> </th>
                        <td><?=$Rows['Pack']; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Extra pack : </strong> </th>
                        <td><?=$Rows['ExtraPack']; ?></td>
                    </tr>

                </table>
            </div>  <!-- end of col -->

            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 my-1">
                <table class="table table-bordered border-primary">
                    <tr>
                        <th><strong>Total Packed : </strong></th>
                        <td><?=$Rows['ExtraPack']+$Rows['Pack']; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Per Packes :</strong> </th>
                        <td><?=$Rows['Carton1']; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Pieces : </strong> </th>
                        <td><?=$Rows['ExtraCarton']; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Total QTY :  </strong> </th>
                        <td><?=$Rows['ProQty']; ?></td>
                    </tr>

                </table>
            </div>  <!-- end of col -->


        </div> <!-- end of row  -->

        <form action="" method="POST" class = "m-0 p-0" >
            <div class = "d-flex justify-content-end" >
                <input type="submit" name="Save&submit" class="btn btn-outline-primary" value="Stock in">
                <input type="submit" name="Reject" class="btn btn-outline-danger ms-2" value="Reject">
            </div>
        </form>
    </div><!-- end of card-body  -->
</div><!-- end of card -->
 
<?php  require_once '../App/partials/Footer.inc'; ?>