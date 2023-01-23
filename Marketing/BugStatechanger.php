<?php
 require_once 'Controller.php'; 
if(isset($_GET['id']))
{
    $ID=$_GET['id'];
    $Update=$Controller->QueryData("UPDATE bugs SET  bug_status='fixed'  WHERE id=? ",[$ID]);
    if($Update)
    {
        echo"<script> alert('Data updated successfully'); </script>";
        header('Location:BugReportFormPage.php');
    }
    else
    {
        echo"<script> alert('Data didn't  updated successfully'); </script>";
    }
}

?>