<?php
session_start(); 
require_once 'Controller.php';
if(isset($_POST['Save']) && !empty($_POST['Save']))
{
        $CustId=$_POST['CustId'];
        $CTNId=$_POST['CTNId'];
        $ProId=$_POST['ProId'];
        $Currency=$_POST['Currency'];
        $AVLQTY=$_POST['AVLQTY'];
        $SaleQTY=$_POST['SaleQTY'];
        $UnitePrice=$_POST['UnitePrice'];
        $TotalPrice=$_POST['TotalPrice'];
        $Comments=$_POST['Comments'];
        $ProOutQTY=$_POST['ProOutQTY'];
        
        $Select=$Controller->QueryData("SELECT * FROM cartonproduction WHERE ProId =? ",[$ProId]);
        $Fetch=$Select->fetch_assoc();
        $ProOut=$Fetch['ProOutQty'];
        
        $Sum_ProOutQTY=$ProOut+$SaleQTY;
    
        $INSERT=$Controller->QueryData("INSERT INTO `cartonsales`(`SaleCustomerId`, `SaleCartonId`, `SaleQty`, `SaleCurrency`, `SalePrice`, `SaleTotalPrice`, `SaleComment`, `SaleUserId` ) 
        VALUES (?,?,?,?,?,?,?,?)",[$CustId,$CTNId,$SaleQTY,$Currency,$UnitePrice,$TotalPrice,$Comments, $_SESSION['EId']]);
        if($INSERT)
        { 
            $Update=$Controller->QueryData("UPDATE `cartonproduction` SET ProOutQty =  ? where ProId=?",[$Sum_ProOutQTY,$ProId]);  
            header("Location:InternalJobs.php");
            // echo'<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            // <strong>!Data successfully inserted</strong>  
            // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            // </div>';
        }
        else
        {
          echo'<div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
          <strong>!Opps something went wrong</strong> .
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }

}

?>