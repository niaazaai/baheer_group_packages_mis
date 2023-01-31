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


        $SELECT_CARTON = $Controller->QueryData('SELECT offesetp,JobNo FROM carton WHERE CTNId=?',  [ $CTNId ]);
        $CARTON = $SELECT_CARTON->fetch_assoc();

        // var_dump($CARTON); 

        $Department = ''; 
        $alert_comment = '';
    
        if(trim($CARTON['offesetp']) == 'Yes' ) {
            $Controller->QueryData('UPDATE carton SET CTNStatus = "Printing"  WHERE CTNId=?' , [$CTNId]);
            $Department = 'Printing';
            $alert_comment = 'New Job with ID (' . $CARTON['JobNo'] . ') Arrived'; 
        }
        else {
            // put it back to recive amount 
            $Controller->QueryData('UPDATE carton SET CTNStatus = "Film" WHERE CTNId=?', [$CTNId]);
            $Department = 'Design'; 
            $alert_comment = 'New Film with JobNo (' . $CARTON['JobNo'] . ') Arrived'; 
            
        }

        $message='You have Sucessfully Proccessed the Job Without Any Payment';

        $user = $Controller->QueryData("SELECT user_id FROM alert_access_list WHERE department =  ? AND notification_type = 'NEW-JOB' ", [$Department  ]); 
        if($user->num_rows > 0 ) {
            $user_id  =  $user->fetch_assoc()['user_id'];
            $Controller->QueryData("INSERT INTO alert (department,user_id,title,alert_comment, `type`) 
            VALUES (?,?,'New Job',?,'NEW-JOB')" , [$Department , $user_id , $alert_comment]);
        }
    }
    header("Location:JobCenter.php?ListType=$ListType&msg=".$message.'&class=success' );
}
else header("Location:JobCenter.php?msg=Somthing Went Wrong &class=danger");
 
?>