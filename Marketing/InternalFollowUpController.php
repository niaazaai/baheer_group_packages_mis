<?php
 
 if(isset($_POST['SaveFollowUp'])) { 
    require_once 'Controller.php'; 
 } 

 
class InternalFollowUpController
{
   
    public function InsertFollowUp($Request , $Controller ){
        $follow_result = $Request['follow_result'];
        $deadline  = str_replace("T"," ", $Request['deadline'] );
        $comment = $Request['comment'];
        $customer_id = $Request['customer_id'];

        $query = "INSERT INTO follow_up(  follow_result , deadline , comment , customer_id)  VALUES ( ?,?,?,? )";
        $results = $Controller->QueryData($query , [  $follow_result  ,  $deadline ,$comment, $customer_id]);
        
        if ($results ) {
            header('Location:FollowUp.php?msg=100&CustId='.$customer_id); 
        } else {
            header('Location:FollowUp.php?msg=101'.$customer_id); 
        }
    }

    public function FindCurrentStatus( $StartTime , $EndTime , $label ){
        $Start = new DateTime($StartTime); 
        $End = new DateTime($EndTime); 
        $dteDiff  = $Start ->diff($End );
        $Status = "<div style = 'text-align:center;'> <Strong > $label </Strong> <span style = ' font-size:12px;'>  [ " .  $dteDiff->format('%a D, %h H, %i M') . " ] </span> </div>";
        return $Status;
    }

}// end of class account clearence


$IFC = new InternalFollowUpController($Controller);
if (isset($_POST) && !empty($_POST)) { 
    if(isset($_POST['SaveFollowUp'])) {
        $IFC->InsertFollowUp($_POST , $Controller);
    } 
} 
?>

