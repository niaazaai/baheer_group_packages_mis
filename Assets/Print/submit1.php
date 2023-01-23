<?php 
	session_start();
	require_once __DIR__ . '/PrintController.php';
	


	if(isset($_POST['pdfform']))
	{
		$class = new PrintController('print_test_file_form');				
	}
	
?>