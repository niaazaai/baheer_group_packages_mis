<?php 


$ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
// $ROOT_DIR = '/var/www/html/BGIS/';
require_once $ROOT_DIR. 'App/Controller.php'; 
 
require '../Assets/DomPDF/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);


if(isset($_GET['CTNId']) && !empty($_GET['CTNId'])) {

        $CTNId=$_GET['CTNId']; 
        $PROId=$_GET['PROId']; 
        $CtnoutId=$_GET['CtnoutId'];
    
        $SQL=$Controller->QueryData('SELECT carton.CTNId,carton.JobNo,carton.ProductName,carton.CTNType,CONCAT(FORMAT(CTNLength/10,1),"x",FORMAT(CTNWidth/10,1),"x",FORMAT(CTNHeight/ 10,1)) AS Size ,ppcustomer.CustName,
        cartonproduction.CtnId1,cartonproduction.ProQty,cartonproduction.ProOutQty,cartonproduction.ProId,CtnDriverMobileNo,CtnDriverName,CtnCarName,CoutComment,CtnOutQty 
        ,CtnCarNo, cartonstockout.OutDateTime,cartonstockout.CtnoutId FROM cartonproduction INNER JOIN cartonstockout ON cartonstockout.PrStockId=cartonproduction.ProId INNER JOIN carton 
        ON cartonproduction.CtnId1=carton.CTNId INNER JOIN ppcustomer ON carton.CustId1=ppcustomer.CustId  WHERE PrStockId=? AND CtnoutId=?',[$PROId,$CtnoutId]);
        $Rows=$SQL->fetch_assoc();
 

        // var_dump($Rows);
 
 

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
                        <h2 style = "margin:2px;margin-left:0px;   padding:0px;">Baheer Printing & Packaging Co. Ltd</h2>
                        <p  style = "margin:3px; margin-left:0px; padding:0px;">Goods Delivery Form </p>
                    </th>
                    <th style = "border: 0px; text-align:end; ">
                    </th>
                
                    <th  style = "border: 0px; text-align:right; ">
                        <img src="http://localhost:1000/BGIS/Public/Img/logo-brand.png" width="150" height="70" alt="">
                    </th>
                </tr>
            </table> 

            <div  style = "margin-top:0px;">
                <h4 style = "width: 100%; border-bottom: 4px solid #1b4fd1!important; line-height: 0.05em; padding:0px; margin:2px;margin-left:0px; "></h4>
            </div>' ;

            $Page .= ' <div style = "margin-top:5px;">
                            <div style="float:left;" >
                                <span style = "font-weight:bold; font-size:14px;  " class="fw-bold fs-5">Receipt No: </span> <span  style = "font-size:14px; " class="fw-bold fs-5">'. $Rows['CtnoutId'] .' </span><br>
                                <span style = "font-weight:bold; font-size:14px; " class="fw-bold fs-5">Job No : </span> <span  style = "font-size:14px; " class="fw-bold fs-5"> '.  $Rows['JobNo'].'</span><br> 
                            </div>
                            <div style=" text-align:right;">
                                <span style = "font-weight:bold; font-size:14px; " class="fw-bold fs-5">Out Date: </span><span  style = "font-size:14px; " class="fw-bold fs-5">'.  $Rows['OutDateTime'].'<span><br>
                                <span style = "font-weight:bold; font-size:14px; " class="fw-bold fs-5">Company Name:</span> <span  style = "font-size:14px; "  class="fw-bold fs-5">'.  $Rows['CustName'].'<br>
                            </div>
                        </div>';


    $Page .='  <table  style = "margin-top:15px;">
                <tr class="table-info">
                    <th style= "font-size:14px;" >Product Name</th>
                    <th style= "font-size:14px;" >Size(L x W x H) cm</th>
                    <th style= "font-size:14px;" >Quantity</th>
                    <th style= "font-size:14px;" >Comment</th> 
                </tr>
                <tr>
                    <td style= "font-size:14px;">'.$Rows['ProductName'].'</td>
                    <td style= "font-size:14px;">'.$Rows['Size'] . '- [ ' . $Rows['CTNType'] .'Ply ] </td> 
                    <td style= "font-size:14px;">'.number_format($Rows['CtnOutQty']).'</td>
                    <td style= "font-size:14px;">'.$Rows['CoutComment'].'</td>
                </tr>         

            </table>';
            

           
                
    $Page.='  <table style = "margin-top:25px;">
                <tr>
                    <th  style= "font-size:14px;">Driver Name</th>
                    <th  style= "font-size:14px;">Vehicle Type</th>
                    <th  style= "font-size:14px;">Plate No</th>
                    <th  style= "font-size:14px;">Mobile No</th>
                    <th  style= "font-size:14px;">Driver Signature</th>
                    <th  style= "font-size:14px;">Manager Signature</th>
                </tr>
                <tr>
                    <td style= "font-size:14px;"  >'.$Rows['CtnDriverName'].'</td>
                    <td style= "font-size:14px;"  >'.$Rows['CtnCarName'].'</td> 
                    <td style= "font-size:14px;"  >'.$Rows['CtnCarNo'].'</td>
                    <td style= "font-size:14px;"  >'.$Rows['CtnDriverMobileNo'] .'</td>
                    <td> </td> 
                    <td> </td>
                </tr>
            </table>';

            $Page.='  

                    <div class="mt-5  fw-bold fs-5">
                        <br>  
                        <p style= "margin:0px; padding:1px; padding-top:2px;"> <strong> Note:</strong><span style= "font-size:12px;" >Baheer Group is not responsible for the amount of dilivered cartons once the truck leaves Baheer Group (factory)  premises. </span> </p>
                        <br>  
                        <p style= "margin:0px; padding:1px;font-size:12px; "><strong>Address: </strong> Street No 3, Sarak Naw Bagram, Dispachari, Kabul-Afghanistan </p>
                        <p style= "margin:0px; padding:1px;font-size:12px;"><strong>Phone: </strong> +93(0)782226574 </p>
                        <p style= "margin:0px; padding:1px;font-size:12px;"><strong>Email: </strong> marketing.pkg@baheer.af</p>
                    </div>';
                     
                    
            $Page .= '<div style = "margin:0px; padding:0px;">----------------------------------------------------------------------------------------------------------------------------------- </div><br><br><br><br><br><br>'; 
            
            $Page .= $Page; 
        
    
 
//     echo $Page;
//    die(); 
 
                        


 

                            

 
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