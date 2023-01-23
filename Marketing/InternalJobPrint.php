 
<?php 
session_start();
$ROOT_DIR = 'F:/BaheerApps/htdocs/BGIS/'; 
// $ROOT_DIR = '/var/www/html/BGIS/';
require_once $ROOT_DIR. 'App/Controller.php'; 
 
require '../Assets/DomPDF/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);


if(isset($_GET['id']) && !empty($_GET['id'])) {

        $Id=$_GET['id']; 
        $SQL=$Controller->QueryData('SELECT `SaleId`, `SaleCustomerId`, `SaleCartonId`, `SaleQty`, `SaleCurrency`, `SalePrice`, `SaleTotalPrice`, `SaleComment`, `SaleUserId`, `SaleDate`, carton.JobNo, 
        ppcustomer.CustName, carton.ProductName, carton.CTNType, carton.CTNUnit, employeet.Ename ,CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size
        FROM `cartonsales` INNER JOIN carton ON carton.CTNId=cartonsales.SaleCartonId 
        INNER JOIN ppcustomer ON ppcustomer.CustId=cartonsales.SaleCustomerId 
        LEFT JOIN employeet ON employeet.EId=cartonsales.SaleUserId WHERE SaleId = ? ',[$Id]);
        $Rows=$SQL->fetch_assoc();
    
        $Page = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Finance Invoice Print Page</title>
                <style>
                    table, td, th {  
                        border: 1px solid black;
                        text-align: left;
                    }
                    
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }
                    
                    th, td {
                        padding: 5px;
                    }
                    body {  font-family: Roboto,sans-serif;  color:#25396f;}

                </style>
            </head>
            <body>';

            
            $Page .= ' <table style = "border: 0px; padding-top:0px; margin:0px; ">
                <tr style = "border: 0px;">
                    
                    <th style = "text-align:left; border: 0px;">
                        <h2 style = "margin:1px; padding:0px;">Baheer Group </h2>
                        <h3 style = "margin:1px; padding:0px;">Baheer Printing & packaging Co.LTD </h3>
                        <p  style = "margin:1px; padding:0px;">Marketing and Sales Department </p>
                    </th>
                    <th style = "border: 0px; text-align:end; ">
                    </th>
                
                    <th  style = "border: 0px; text-align:right; ">
                        <img src="http://localhost:4001/BGIS/Public/Img/logo-brand.png" width="150" height="100" alt="">
                    </th>
                </tr>
            </table> 

            <div  style = "margin-top:0px;">
                <h4 style = "width: 100%; border-bottom: 4px solid #1b4fd1!important; line-height: 0.05em; padding:0px; margin:2px;"></h4>
            </div>' ;

            $Page .= ' <div style = "margin-top:5px;">
                            <div style="float:left;" >
                                <span style = "font-weight:bold" class="fw-bold fs-5">Receipt No: </span> <span class="fw-bold fs-5">'.$Rows['JobNo'].'-'. $Rows['SaleId'] .' </span><br>
                                <span style = "font-weight:bold" class="fw-bold fs-5 mb-3">Customer Name : </span> <span class="fw-bold fs-5"> '.  $Rows['CustName'].'</span><br>  
                            </div>
                            <div style=" text-align:right;">
                                <span style = "font-weight:bold;" class="fw-bold fs-5">Date: </span><span class="fw-bold fs-5">'.$Rows['SaleDate'].'<span><br> 
                            </div>
                        </div>';
                        
    $Page .='  <table  style = "margin-top:35px; margin-bottom:15px;">
                <tr class="table-info">
                    <th>S/N</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Quantity</th> 
                    <th>U.Price</th>
                    <th>Total Amount</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>'.$Rows['ProductName'].' '.$Rows['Size'] . '- [ ' . $Rows['CTNType'] .'Ply ] </td> 
                     
                    <td>'.$Rows['CTNUnit'].'</td>
                    <td>'.$Rows['SaleQty'].'</td>
                    <td>'.$Rows['SalePrice'].'</td>
                    <td>'.$Rows['SaleTotalPrice'].'</td>
                </tr>         

            </table>';
            
            $Page.='  

            <div class="mt-5 mb-5 pt-5 fw-bold fs-5">
                <p style= "margin:0px; padding:1px; margin-top:5px; "><strong>Respected buyers!</strong>  </p> 
                <p style= "margin:0px; padding:1px; margin-top:0px; margin-bottom:10px; "><strong>
                We kindly ask you to check the purchased items carefully and count them. You have no right to complain after leaving the office. Thank you
                </strong>  </p> 
            </div>';
    
            $Page.='  
                    <div style = "margin-top:5px;">
                        <div class="mt-5 pt-5 fw-bold fs-5">
                            <p style= "margin:0px; padding:1px; margin-top:5px; "><strong>Prepared By: </strong> '.$_SESSION['user'].' </p> 
                        </div>
                        <div   style=" text-align:right; font-weight:bold;">
                            <span   >Customer Signature </span> <br> 
                        </div>
                    </div>';

            $Page.='  

                    <div class="mt-5 pt-5 fw-bold fs-5">
                        <p style= "margin:0px; padding:1px; margin-top:5px; "><strong>Note: </strong> '.$Rows['SaleComment'].' </p> 
                    </div>';
                     
                    
            $Page .= '<div style = "margin-top:0px; padding:0px; margin-bottom:90px;">----------------------------------------------------------------------------------------------------------------------------------- </div>'; 
            $Page .= $Page; 
        
    
 
//     echo $Page;
// //    die(); 
 
$dompdf->loadHtml($Page );

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'Portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();


}

// else {header('Location:'); }
    
?>