<?php
$ROOT_DIR = 'F:/BaheerApps/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 
if(isset($_GET['CTNId']))
{
    $ListType=$_GET['ListType'];
    $CartonId=$_GET['CTNId'];
    $JobNo=$_GET['JobNo'];
 
    
    if($JobNo=='NULL') { $UpdateStatus = "UPDATE carton SET CTNStatus='DConfirm' where CTNId=?";}
    else { $UpdateStatus = "UPDATE carton SET CTNStatus='Archive' where CTNId=?"; }
    $UpdateStatus1=$Controller->QueryData($UpdateStatus,[$CartonId]); 
 
    $CartonComment = $Controller->QueryData("INSERT INTO cartoncomment (EmpId1, CartonId1, ComDepartment) VALUES (?,?,'Design')",[$_SESSION['EId'],$CartonId]); 

    $productionreport = $Controller->QueryData("UPDATE productionreport SET DesignEnd=CURRENT_TIMESTAMP , PPStart=CURRENT_TIMESTAMP WHERE RepCartonId=? ",[$CartonId]);
    if($productionreport) 
    {
        header('Location:JobCenter.php?msg=Job Transfer to Archive Successfully&class=success&ListType='.$ListType);
    }
    else
    {
        header("Location:JobCenter.php?msg=Job Didnt Transfer to Archive Successfully&class=danger");   
    }
    
}
 
?>

 