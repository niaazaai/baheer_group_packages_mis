 
<?php
	require_once 'Controller.php';
	if(isset($_GET['Order'])) {
		$id=$_GET['Order'];
		$updateOrder=$Controller->QueryData("UPDATE carton SET CTNStatus='order' WHERE CTNId=?",[$id]);
		if($updateOrder) { header('Location:IndividualQuotation.php');}
		else { echo "Can't Access the Order Page"; }
	}
	else { 
		echo "Can't Catch the Carton ID that press button by order...!"; 
	}

	if(isset($_GET['Send'])) {

		$id1=$_GET['Send']; $updateSend=$Controller->QueryData("UPDATE carton SET CTNStatus='Design' WHERE CTNId=?",[$id1]);
		if($updateSend) { 
			$alert_comment = 'New Quotation with ID (' . $id1 . ') Arrived'; 
			$user = $Controller->QueryData("SELECT user_id FROM alert_access_list WHERE department = 'Design' AND notification_type = 'NEW-JOB'" , []); 
			if($user->num_rows > 0 ) {
				$user_id  =  $user->fetch_assoc()['user_id'];
				$Controller->QueryData("INSERT INTO alert (department,user_id,title,alert_comment, `type`) 
				VALUES ('Design',?,'New Job',?,'NEW-JOB')" , [$user_id,$alert_comment]);
			}
			header('Location:IndividualQuotation.php'); 
		}
		else { echo "Can't Access the Order Page"; }
	}
	
?>
