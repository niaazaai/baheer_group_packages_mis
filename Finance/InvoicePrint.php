<?php 
session_start();
require_once 'Controller.php'; 

 
require '../Assets/DomPDF/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);



if(isset($_GET['CTNId']) && !empty($_GET['CTNId']))  
{
    
    $CartonId = $_GET['CTNId']; 
    $CustomerData ="SELECT carton.CustId1,carton.CTNOrderDate,CTNUnit,ProductName,CTNQTY,Tax,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,
    CTNType,carton.CTNFinishDate,FinalTotal,carton.PexchangeUSD,carton.CtnCurrency,ppcustomer.CustName,ppcustomer.CustMobile,ppcustomer.CustAddress 
                FROM carton INNER JOIN  ppcustomer ON carton.CustId1=ppcustomer.CustId  WHERE  CTNId = ? ";
    $DataRows  = $Controller->QueryData($CustomerData, [$CartonId]);
    $Rows= $DataRows->fetch_assoc();
    // $CustomerId = $Rows['CustId1'];
    

    

        $Page = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Finance Invoice Print Page</title>
                <style>
                    table, td, th {  
                        border: 1px solid #ddd;
                        text-align: left;
                    }
                    
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }
                    
                    th, td {
                        padding: 10px;
                    }
                    body {  font-family: Roboto,sans-serif;  color:#25396f;}

                </style>
            </head>
            <body>';


            $Page .= ' <table style = "border: 0px;  ">
                <tr style = "border: 0px;">
                    <th style = "border: 0px; text-align:center; ">
                        <img src="http://localhost:4001/BGIS/Public/Img/only-logo-brand.png" width="100" height="100" alt="">
                    </th>
                    
                    <th style = "text-align:center; border: 0px;">
                        <h2 style = "margin:2px; padding:0px;">Baheer Group of Companies </h2>
                        <h3 style = "margin:2px; padding:0px;">Finance Department</h3>
                        <p  style = "margin:3px; padding:0px; "> Customer Invoice</p>
                    </th>

                    <th  style = "border: 0px; text-align:center; ">
                    <img src="http://localhost:4001/BGIS/Public/Img/bgis-logo.png" width="100" height="100" alt="">
                    </th>
                </tr>
            </table>';
        

            $Page .= '<table style = "border: 0px; margin-top:30px;">
                <tr style = "border: 0px; margin:0px; padding:0px;">
                    <th style = "border: 0px; margin:0px; padding:0px; padding-left:5px; font-size:15px;">
                        Invoice To: <small style="font-weight:regular;">'.$Rows["CustName"].'</small><br>
                        Invoice No:<small style="font-weight:regular;">N/A</small><br>
                        Invoice Date:<small style="font-weight:regular;">N/A</small><br>
                        Purchase Order No:<small style="font-weight:regular;">N/A</small><br>
                        Project No:<small style="font-weight:regular;">N/A</small> 
                    </th>
                    <th style = "border: 0px; text-align:right;margin:0px; padding:0px; padding-right:5px; font-size:15px;">
                        Phone:<small style="font-weight:regular;">'. $Rows["CustMobile"].'</small><br>
                        Class:<small style="font-weight:regular;"> PKG</small><br>
                        Address:<small style="font-weight:regular;">'.$Rows["CustAddress"].'</small><br>
                        Currency:<small style="font-weight:regular;">'.$Rows["CtnCurrency"].'</small><br>
                        Exchange Rate:<small style="font-weight:regular;">'.$Rows["PexchangeUSD"].'</small> 
                        
                    </th>
                </tr>
            </table>';



            $Page .= ' <table style = " margin-top:30px; font-size:12px; ">
                <thead >
                    <tr> 
                        <th style="text-align:center">QTY</th>
                        <th style="text-align:center">Item</th>
                        <th style="text-align:center">Description</th>    
                        <th style="text-align:center">Rate</th>
                        <th style="text-align:center">Amount</th>
                        <th style="text-align:center">Tax</th>
                        <th style="text-align:center">Total Amount</th> 
                    </tr>
                <thead>
                <tbody>';
        
  

                    $TotalAmount=$Rows['FinalTotal']+$Rows['Tax'];$Total=0;
                    $Amount=0;
                    $Tax=0;
                    $TaxAmount=($Rows['FinalTotal']*$Rows['Tax'])/100;
                
 
                    $Page .= '<tr>';
                    $Page .= '<td style="text-align:center">'.$Rows['CTNQTY'].'</td>';
                    $Page .= '<td style="text-align:center">'.$Rows['CTNUnit'].'</td>'; 
                    $Page .= '<td style="text-align:center">'.$Rows['ProductName'].' ('.$Rows['Size'].') cm - '. $Rows['CTNType'].'Ply</td>';
                    $Page .= '<td style="text-align:center">'.$Rows['PexchangeUSD'].'</td>';
                    $Page .= '<td style="text-align:center">'.$Rows['FinalTotal'].'</td>';
                    $Page .= '<td style="text-align:center">'.$TaxAmount.'</td>';
                    $Page .= '<td style="text-align:center">'.$TotalAmount.'</td>';
                    
                    $Page .= '</tr>';
                    

                    $Amount+=$Rows['FinalTotal'];
                    $Tax+=$Rows['Tax'];
                    $Total+=$TotalAmount; 

                    $Page .= ' <tr>';
                    $Page .= ' <td colspan ="4" style="text-align:center"> Total </td>';
                    $Page .= ' <td style="text-align:center"><?php echo $Amount; ?> </td>';
                    $Page .= ' <td style="text-align:center">' . $Tax .'</td>';
                    $Page .= ' <td style="text-align:center">'. $Total.'</td>'; 
                    $Page .= ' </tr>';
              
            $Page .='
                </tbody>
            </table>';

            $Page .= '<table style = "border: 0px;  margin-top:55px; ">
                <tr style = "border: 0px; margin:0px; padding:0px;"> 
                    <th  style = "border: 0px; text-align:right;  padding:0px;  ">
                        Sales Tax:'. $TaxAmount.' <br>
                        USD:' .$TaxAmount/$Rows["PexchangeUSD"].'
                    </th>
                </tr>
            </table>';
            
            $Page .= '<table style = "border: 0px;  margin-top:55px; margin-bottom:55px; ">
                <tr style = "border: 0px; margin:0px; padding:0px;">
                    <th style = "border: 0px;  margin:0px; padding:0px; ">
                        Issued By: '.$_SESSION['user'].'
                    </th>
                    <th  style = "border: 0px; text-align:right;  padding:0px;  ">
                    Sign | Stamp 
                    </th>
                </tr>
            </table>';
    
            $Page.='<hr>';
    
            $Page .= '<table style = "border: 0px;  margin-top:30px; ">
            <tr style = "border: 0px; margin:0px; padding:0px;">
                <th style = "border: 0px;  margin:0px; padding:0px; "> 
                    <img src="http://localhost:4001/BGIS/Public/Img/phone.png" width="15" height="15" alt="" ><span> +93(0)782226558 </span> | <span> +93(0)782226558</span>
              
                </th>
            </tr>
         
            <tr>
                <th  style = "border: 0px; text-align:left;  padding:0px; padding-right:40px;"> 
                    <img src="http://localhost:4001/BGIS/Public/Img/Email.png" width="15" height="15" alt="" > <span>marketing.pkg@baheer.af  </span>
                   
                </th>
            </tr>
     
            <tr>
                <th style="border: 0px; text-align:left;  padding:0px; padding-right:40px;"> 
                    <img src="http://localhost:4001/BGIS/Public/Img/Web.png" width="15" height="15" alt="" >  <span>www.baheer.af</span>
                  
                </th>
            </tr>
      
            <tr>
                <th style="border: 0px; text-align:left;  padding:0px; padding-right:40px;">
                        <img src="http://localhost:4001/BGIS/Public/Img/Address.png" width="15" height="15" alt="" >     <span>Street# 3, Sarak Naw Bagram, Dispachari, Kabul-Afghanistan</span>
                     
                </th>
            </tr>
        </table>';
      

// echo $Page;
// die();
$dompdf->loadHtml($Page );

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
}


?>
