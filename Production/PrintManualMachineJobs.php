

<?php 
 session_start();
require_once 'Controller.php'; 

 

require '../Assets/DomPDF/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);


if(  isset($_POST['Query']) && !empty(trim($_POST['Query'])) ) {
    $Data = $Controller->QueryData($_POST['Query'], []); 
 
    $MachineName = "ALL"; 
    if($_POST['machine_id'] != "ALL") {
        $M = $Controller->QueryData('SELECT machine_name FROM machine WHERE machine_id = ? ', [$_POST['machine_id'] ]); 
        $machine = $M->fetch_assoc(); 
        $MachineName = $machine['machine_name']; 
    } 
    

    $Page = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manual Machines Job List</title>
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
 
  
  

    $Page .= '
    <table style = "border: 0px;  ">
        <tr style = "border: 0px;">
            <th style = "border: 0px; text-align:center; ">
                <img src="http://localhost:4001/BGIS/Public/Img/only-logo-brand.png" width="100" height="100" alt="">
            </th>
            
            <th style = "text-align:center; border: 0px;">
                <h1 style = "margin:2px; padding:0px;">Baheer Group of Companies </h1>
                <h2 style = "margin:2px; padding:0px;">Production Department</h2>
                <h3 style = "margin:2px; padding:0px;">Manual Unit</h3>
                <p  style = "margin:2px; padding:0px; ">  '.$MachineName.' Job List</p>
            </th>

            <th  style = "border: 0px; text-align:center; ">
            <img src="http://localhost:4001/BGIS/Public/Img/bgis-logo.png" width="100" height="100" alt="">
            </th>
        </tr>
    </table>'; 



    $Page .= '
    <table style = "border: 0px;  ">
        <tr style = "border: 0px; margin:0px; padding:0px;">
            <th style = "border: 0px;  margin:0px; padding:0px; ">
                Date: '.date('d-m-Y').'
            </th>
            <th  style = "border: 0px; text-align:center;margin:0px; padding:0px; ">
            </th>
        </tr>
    </table>'; 


    $Page .= '<hr>'; 
    $Page .= '
    <table style = "margin-top:15px; font-size:12px;">
        <thead >
            <tr >
            <th>#</th>
            <th title="Job No">Job No</th>
            <th>Product Name</th>
            <th>Size (L x W x H)</th>    
            <th>Type</th>
            <th>Color</th>
            <th>Order QTY</th>
            <th>Produced QTY</th>
            <th>Wast</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Opreator</th>
            <th>Color</th>
            </tr>
        <thead>
        <tbody>'; 
        $counter=1; 
        while ($DataRows = $Data->fetch_assoc()) {  

            $Page .= '<tr>';
            $Page .= '<td>'.$counter++ .'</td>';
            $Page .= '<td>'.$DataRows['JobNo'].'</td>';
            $Page .= '<td>'.$DataRows['ProductName'].'</td>'; 
            $Page .= '<td>('.$DataRows['Size'].') - '. $DataRows['CTNType'].'Ply</td>';
            $Page .= '<td>'.$DataRows['CTNUnit'].'</td>';
            $Page .= '<td>'.$DataRows['CTNColor'].'</td>';
            $Page .= '<td>'.number_format($DataRows['CTNQTY']).'</td>';
            $Page .= '<td> </td>';
            $Page .= '<td> </td>';
            $Page .= '<td> </td>';
            $Page .= '<td> </td>';
            $Page .= '<td> </td>';
            $Page .= '<td> </td>';
            $Page .= '</tr>';
        }  

        $Page .= '
        </tbody>
    </table>';


    $Page .= '
    <table style = "border: 0px;  margin-top:15px; ">
        <tr style = "border: 0px; margin:0px; padding:0px;">
            <th style = "border: 0px;  margin:0px; padding:0px; ">
                Printed By: '. $_SESSION['user'] .'
            </th>
            <th  style = "border: 0px; text-align:right;margin:0px; padding:0px; ">
            Machine Opreator <br>
            ____________________ 
            </th>
        </tr>
    </table>'; 



    $Page .= ' </body></html>';

   
// echo $Page; 

// die();
    $dompdf->loadHtml($Page );

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream();

}

?>






 






 
  
   


