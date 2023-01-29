<?php
$ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 
// require_once 'Controller.php';

if(isset($_REQUEST['ProId']))
{
    $ProId=$_REQUEST['ProId'];
    $Status=1;
    $Update=$Controller->QueryData("UPDATE cartonproduction SET ManagerApproval='ManagerApproved' WHERE ProId = ?",[$ProId]);
    if($Update)
    {
        header("Location:JobCenter.php?MSG=produced QTY Successfully Approved by warehouse Manager&State=".$Status);
    }

}

if(isset($_GET['PROID']))
{
    $PROID=$_GET['PROID'];
    $UpdateCartonProduction=$Controller->QueryData("UPDATE cartonproduction SET  financeAllowquantity=?, ProOutQty=? WHERE ProId=?",[$minus,$minus,$PROID]);
    if($UpdateCartonProduction)
    {
        header("Location:JobCenter.php?MSG=produced QTY Successfully Approved by warehouse Manager&State=".$Status);
    }

}


?>