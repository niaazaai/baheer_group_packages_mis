<?php require_once 'Controller.php';  

// var_dump($_POST); 
// die(); 
if( 
isset($_POST['CTNID']) && !empty($_POST['CTNID']) && 
isset($_POST['minus']) && !empty($_POST['minus'])
   ) {
    $ListType=$_POST['ListType'];
    $CTNId=$_POST['CTNID'];
    $minus=$_POST['minus'];
    $PROID=$Controller->CleanInput($_POST['PROID']); 

    $Checking=$Controller->QueryData("SELECT  FAQTY, ProductQTY FROM carton WHERE CTNId= ?",[$CTNId]);
    $Check=$Checking->fetch_assoc();
    $ProducedQTY=$Check['ProductQTY'];
    $FAQTY=$Check['FAQTY'];

    if( (int)$minus > (int)$ProducedQTY)
    {
        header("Location:StockOut.php?CTNId=".$CTNId."&ListType=".$ListType."&MSG=Finance Approval QTY is greater than Produced QTY of Machine..&State=0");
    }
    else
    {
        $UpdateCartonProduction=$Controller->QueryData("UPDATE cartonproduction SET financeApproval='FinanceApproved', financeAllowquantity=? WHERE ProId=?",[$minus,$PROID]);
        if($UpdateCartonProduction)
        {
            $CheckFAQ=$Controller->QueryData("SELECT FAQTY FROM carton WHERE CTNId = ?",[$CTNId]);
            $FQTY=$CheckFAQ->fetch_assoc();
            $Data=(int)$minus + (int)$FQTY['FAQTY'];
            $Update=$Controller->QueryData("UPDATE carton SET FAQTY=? WHERE CTNId=?",[$Data,$CTNId]);
            header("Location:StockOut.php?CTNId=".$CTNId."&ListType=".$ListType."&MSG=Record Successfully saved..&State=1"); 
        }  
    }
 
}
else  header("Location:StockOut.php?CTNId=".$_POST['CTNID'] ."&ListType=". $_POST['ListType'] ."&MSG=Something Went Wrong&State=0"); 
?>
 