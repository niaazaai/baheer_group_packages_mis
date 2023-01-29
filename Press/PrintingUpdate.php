<?php
$ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 

    if(isset($_GET['JobNoPP']) && !empty($_GET['JobNoPP']) && isset($_GET['JobNo']) && !empty($_GET['JobNo']) )
    {
        $JobNoPP=$_GET['JobNoPP']; $JobNo=$_GET['JobNo'];
        $ListType=$_GET['ListType'];
    
        $UpdateCarton = $Controller->QueryData("UPDATE `carton` SET `CTNStatus`='Printing', JobNoPP=? where JobNo = ?",[$JobNoPP,$JobNo]);
        if($UpdateCarton)
        {
            header("Location:PrintingJobCenter.php?msg=You have Updated Successfully Job No of Printing Press&ListType=".$ListType);
        }
        else
        {
            header("Location:PrintingJobCenter.php?msg=You didn't Updated Job No of Printing Press Successfully&ListType=".$ListType);
        }
    }


?>