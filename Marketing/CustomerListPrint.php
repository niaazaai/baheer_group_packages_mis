<?php 
session_start(); 
require_once 'Controller.php'; 
$HTML = '';
   
        if( isset($_SESSION['CUSTOMER_LIST_QUERY'])){
            if(isset($_SESSION['CUSTOMER_LIST_QUERY']['Query']) && !empty($_SESSION['CUSTOMER_LIST_QUERY']['Query']) && 
               isset($_SESSION['CUSTOMER_LIST_QUERY']['Param']) && !empty($_SESSION['CUSTOMER_LIST_QUERY']['Param'])   ){
              $Query = $_SESSION['CUSTOMER_LIST_QUERY']['Query'];
              $Param = $_SESSION['CUSTOMER_LIST_QUERY']['Param'];
            }
            else { 
                $Query = "SELECT CustName , CusProvince , CustCatagory ,CusSpecification , CusStatus , AgencyName  FROM ppcustomer LIMIT 15 "; 
                $Param = [];
            }
        } 
        else {
            $Query = "SELECT CustName , CusProvince , CustCatagory ,CusSpecification , CusStatus , AgencyName FROM ppcustomer LIMIT 15 "; 
            $Param = [];
        }

        $DataRows = $Controller->QueryData($Query , $Param); 

        $i = 1 ;   
        $HTML =  '<html lang="en"><head></head><body style = "margin:0px ; padding:0px; " > 
        <div style = "text-align:center;margin-top:10px ; margin-bottom:10px; " > <h2>Customer List</h2> </div>
        <hr>
        <div style = "margin-left:50px;margin-right:50px; margin-top:30px; " > 
        <table style = "margin:0 auto table-layout: auto;
        width: 100%;" border="1" cellspacing="0" cellpadding="5" >';

       
        $DEFAULT_TABLE_HEADING = "<th>#</th> <th>Customer Name</th> <th>Province</th> <th>Catagory</th> <th>Specification</th> <th>Status</th> <th>Agency Name</th>";
        if (isset($_SESSION['CL_DEFAULT_TABLE_HEADING'])) {
            $HTML .=  $_SESSION['CL_DEFAULT_TABLE_HEADING'];
        } else $HTML .=  $DEFAULT_TABLE_HEADING  ; 


        // width='' height=''
        foreach ($DataRows as $RowsKey => $Rows) {
                $HTML .= " <tr>";
                $HTML .= " <td>$i</td> ";
                foreach ($Rows as $key => $value) {
                    $HTML .= " <td  > $value </td>";  
                }
                $i++;   
            $HTML .= "</tr>";
        } 
        $HTML .= ' </table>   </div> </body> </html>'; //
    
        $_SESSION['CUSTOMER_LIST_QUERY']['HTML']  =   $HTML; 
        
        // echo $HTML ;
        header('Location:Print.php')
 
?>
