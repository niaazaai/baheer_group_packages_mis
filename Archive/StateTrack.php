<?php
$ROOT_DIR = 'F:/BaheerApps/htdocs/BGIS/'; 
require_once $ROOT_DIR.'App/Controller.php'; 
if(isset($_GET['CTNId']))
{
    $CTNId=$_GET['CTNId']; $ListType=$_GET['ListType'];
    $UpdateCarton=$Controller->QueryData("UPDATE carton SET Track='Uncheck' WHERE CTNId = ? ",[$CTNId]);
    if($UpdateCarton)
    {
        header("Location:ArchiveJobCenter.php?MSG=Successfully Polymer/Die hand over to Production&State=1&ListType=$ListType");
    }
    else
    {
        header("Location:ArchiveJobCenter.php?MSG=Sorry Polymer/Die Did not hand over to Production&State=0&ListType=$ListType");
    }
}
?>