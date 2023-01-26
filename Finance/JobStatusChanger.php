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
    // else header("Location:JobCenter.php?msg=Somthing Went Wrong 1 &class=danger");


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


        $SELECT_CARTON = $Controller->QueryData('SELECT offesetp FROM carton WHERE CTNId=?',  [ $CTNId ]);
        $CARTON = $SELECT_CARTON->fetch_assoc();

        // var_dump($CARTON); 

        if(trim($CARTON['offesetp']) == 'Yes' ) {
            $Controller->QueryData('UPDATE carton SET CTNStatus = "Printing"  WHERE CTNId=?' , [$CTNId]);
        }
        else {
            // put it back to recive amount 
            $Controller->QueryData('UPDATE carton SET CTNStatus = "Film" WHERE CTNId=?', [$CTNId]);
        }

        // OLD QUERY BEFORE FILE NEED TO DELETE AFTER A WHILE 
        // $Updata=$Controller->QueryData("UPDATE carton SET CTNStatus = 'Archive' WHERE CTNId = ?",[ $CTNId]);
        $message='You have Sucessfully Proccessed the Job Without Any Payment';
        // die();
    }
    header("Location:JobCenter.php?ListType=$ListType&msg=".$message.'&class=success' );
}
else header("Location:JobCenter.php?msg=Somthing Went Wrong &class=danger");
 
?>