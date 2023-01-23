<!-- 
	* Dear Developer This file is created for the purpose of the changing the status of the order in table, we have used two button in Individual quotation liat file named
	  (IndividualQuotation.php) page.

	* When the user click on first  buttons, It is send button which has the duty of changing the status to Fconfrim in table and the purpose of the button is to send 
	  to design department.

	* When the user click on second buttons, It is order button which has the duty of changing the status to order in table and the purpose of the button is to send 
	  to customer order list file named (CustomerOrderPage.php) department.
 -->
<?php
require_once 'Controller.php';
if(isset($_GET['Order']))
{
	$id=$_GET['Order'];
	
	$updateOrder=$Controller->QueryData("UPDATE carton SET CTNStatus='order' WHERE CTNId=?",[$id]);
	if($updateOrder) { header('Location:IndividualQuotation.php');}
	else { echo "Can't Access the Order Page"; }
}
else { echo "Can't Catch the Carton ID that press button by order...!"; }
if(isset($_GET['Send']))
{
	$id1=$_GET['Send']; $updateSend=$Controller->QueryData("UPDATE carton SET CTNStatus='Design' WHERE CTNId=?",[$id1]);
	if($updateSend) { header('Location:IndividualQuotation.php'); }
	else { echo "Can't Access the Order Page"; }
}
else { echo "Can't Catch the Carton ID...!"; }
?>
