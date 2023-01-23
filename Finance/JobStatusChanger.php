 <?php 
 
require_once 'Controller.php'; 
$ListType = (isset($_GET['ListType'])) ? $_GET['ListType'] : 'New Job';

if(isset($_POST['CommentSave']))
{
    $CTNId=$_POST['CTNID'];
    $Comment=$_POST['Comment'];
    $UPDATE=$Controller->QueryData("UPDATE carton set PospondComment = ? WHERE CTNId = ? ",[$Comment,$CTNId]);
    if($UPDATE)
    {
        $Updata=$Controller->QueryData("UPDATE carton SET CTNStatus = 'Pospond' WHERE CTNId = ?",[ $CTNId]);
        $message='Job Sucessfully POSPONDED';
        header("Location:JobCenter.php?ListType=$ListType&msg=".$message.'&class=success' );
    }
    
}
else header("Location:JobCenter.php?msg=Somthing Went Wrong &class=danger");

if(isset($_GET['CTNId']) && !empty($_GET['CTNId']) && isset($_GET['ButtonType'] ) && !empty($_GET['ButtonType']) ) 
{
    $CTNId=$_GET['CTNId'];
    $ButtonType = $_GET['ButtonType'];
    $message;
    if($ButtonType == 'UNPOSPOND')
    {
        $Updata=$Controller->QueryData("UPDATE carton SET CTNStatus = 'FNew' WHERE CTNId = ?",[ $CTNId]);
        $message='You have Sucessfully Un pospond the job';
    }
    elseif($ButtonType == 'PROCESS')
    {
        $Updata=$Controller->QueryData("UPDATE carton SET CTNStatus = 'Archive' WHERE CTNId = ?",[ $CTNId]);
        $message='You have Sucessfully Proccessed the Job Without Any Payment';
    }
    header("Location:JobCenter.php?ListType=$ListType&msg=".$message.'&class=success' );
}
else header("Location:JobCenter.php?msg=Somthing Went Wrong &class=danger");
 
?>