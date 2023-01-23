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
        
		<h1>Create Pdf From Form</h1>
        <p>Fill out the Below details to generate the form</p>
        <form action="submit.php"  method="post">
        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <textarea class="form-control" name="message" placeholder="Message"></textarea>
		
		
		<?php if(isset($_SESSION['array'])) { ?>
		
				<?php	
						foreach($_SESSION['array'] as $arr){ ?>
					
					<p style="color:red" >This is the paragraph <?= $arr ?></p>
					
					<?php 
				} ?>
		
		<?php } ?>
				
		
		</form>
    </div>
</body>
</html>