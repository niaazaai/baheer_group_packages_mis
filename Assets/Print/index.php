<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"/>
<title>Create Pdf with HTML Form with Mpdf</title>


<script src="bts/js/jquery.min.js"></script>


</head>
<body>
    <div class="container mt-5">
        
		<h1>Create Pdf From Form</h1>
        <p>Fill out the Below details to generate the form</p>
        <form action="submit.php" id="submit_form"  method="post">
        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <textarea class="form-control" name="message" placeholder="Message"></textarea>       
		<button class="btn btn-primary" name="pdfform" type="submit">Create PDF</button>
        <button class="btn btn-primary" name="pdfhtml" type="submit">Create PDF from Html</button>
        <button class="btn btn-primary" name="pdfhtmld" type="submit">Create PDF from Html And Download</button>
        <button class="btn btn-primary" name="pdfhtmlPreview" type="submit">Create PDF from Html And Preview</button>
		<br>
		<br>		
		<input type="submit" onclick="return onc(event,'pdfhtmljs')" class="btn btn-primary" id="pdfhtml" name="pdfhtmljs" value="Create PDF from Html JS" />
        <input type="submit"  onclick="return onc(event,'pdfhtmldjs')" class="btn btn-primary" id="pdfhtml" name="pdfhtmldjs" value="Create PDF from Html And Download JS" />
		</form>			
		<br>
		<br>		
		
		
		<br>
		<br>		
		<form action="submit1.php" id="submit_form1"  method="post">
		   <input type="hidden" value="A4" name="page"  />
		   <input type="hidden" value="P" name="oreintation"  />
		   <input type="hidden" value="testHtml.php" name="filename"  />
		   <input type="hidden" value="./PrintFiles/" name="path"  />
		   <input type="hidden" value="download" name="type"  />		
		   <input type="hidden" value="download" name="type"  />		
		   <input type="hidden" value="download" name="type"  />		
			<button class="btn btn-primary" name="pdfform" type="submit">Create PDF</button>
		</form>
		
		
		
		
		
		
		
		<div id="iframe_pdf"></div>	
    </div>
</body>

<script>
	
	function onc(e,param){		
		var form = $("#submit_form");		
		$.ajax({
		  url: 'submit.php',
		  type: 'POST',
		  data: form.serialize()+ "&"+param+"=1",
		  success: function(response){	
			
			if(param === "pdfhtmldjs" )
			{				
				var link = document.createElement('a');
				link.setAttribute("download",response.data.name);
				link.href = "./PrintFiles/down.pdf";
				$("#iframe_pdf").append(link);
				link.click();
				link.remove();
			}
			else if(param === "pdfhtmljs" )
			{
				var pdf = response.data.file;
				var pdf = pdf.replace (/\\/g,"/");	
				var iframe = document.createElement('iframe');
				iframe.style.visibility = 'hidden';	
				iframe.src = "./PrintFiles/down.pdf";
				$("#iframe_pdf").append(iframe);	
				iframe.contentWindow.focus();
				iframe.contentWindow.print();
		
			}			  
			return true;
		  }
		});
		return false;
	}

</script>

</html>