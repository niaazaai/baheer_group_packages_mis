<?php 
	session_start();
	require_once __DIR__ . '/PrintController.php';

	

	if(isset($_POST['pdfform']))
	{
		
		$class = new PrintController('print_test_file');				
	}
	elseif(isset($_POST['pdfhtml']))
	{
		$class = new PrintController('print_html_to_pdf');				
	}
	elseif(isset($_POST['pdfhtmld']))
	{
		$class = new PrintController('print_html_to_pdf_down');				
	}	
	elseif(isset($_POST['pdfhtmljs']))
	{
		return $class = new PrintController('print_html_to_pdf_downjs');				
	}
	elseif(isset($_POST['pdfhtmldjs']))
	{
		return $class = new PrintController('print_html_to_pdf_downjs');				
	}	
	elseif(isset($_POST['pdfhtmlPreview']))
	{
		$class = new PrintController('print_html_to_pdf_and_preview');				
	}
	elseif(isset($_POST['back_page_value']))
	{
		$class = new PrintController('back_page');				
	}

?>