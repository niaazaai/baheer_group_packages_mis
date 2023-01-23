<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="./bts/css/bootstrap.min.css"/>
<title>Create Pdf with HTML Form with Mpdf</title>
</head>
<body>
    <div class="container mt-5">        
		<h1>Print Preview</h1>		
		<form action="submit.php"  method="post">	
			<input type="hidden" name="back_page_value" value="<?php echo $_SESSION['back_url']?>" />		
			<button class="btn btn-success" name="back" type="submit">Back</button>
		</form>
		<br>		
		<iframe src="<?= $_SESSION['file_path']?>" width="80%" height="600px"></iframe>			
    </div>
</body>
</html>