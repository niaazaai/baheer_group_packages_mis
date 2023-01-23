<?php 
session_start();
require_once '../Assets/DomPDF/vendor/autoload.php';
use Dompdf\Dompdf;
   

    if( isset($_SESSION['CUSTOMER_LIST_QUERY'])){
        if(isset($_SESSION['CUSTOMER_LIST_QUERY']['HTML']) && !empty($_SESSION['CUSTOMER_LIST_QUERY']['HTML'])) 
            $HTML = $_SESSION['CUSTOMER_LIST_QUERY']['HTML'];
        else  $HTML = "<h1> An Issue Happend: Please Contact System Admin! </h1> ";
    } 
    else {
        $HTML = "<h1> An Issue Happend: Please Contact System Admin </h1> ";
    }
   
    $dompdf = new Dompdf();  
    $dompdf->loadHtml($HTML);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream( "Customer List .pdf", ["Attachment" => 1]);

?>