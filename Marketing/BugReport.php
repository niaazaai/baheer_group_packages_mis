<?php require_once 'Controller.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="BGC MIS Department">
    <title>BGIS</title>
    <link rel="stylesheet" href="../Public/Css/bootstrap.min.css">
 </head>
 <body class="bg-light">

<?php
if(isset($_POST['save']))
{
    $Priority=$_POST['Priority']; $title=$_POST['title']; $details=$_POST['details']; $Page_URL=$_POST['URL']; $Suggestion=$_POST['Suggestion'];
    $target_dir = "BugReport/Images/"; $target_file = $target_dir . basename($_FILES["filename"]["name"]);  $uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	if (file_exists($target_file)) { /*echo "Sorry, file already exists.";*/ $uploadOk = 0; }
	// Check file size
	if ($_FILES["filename"]["size"] > 2200000) { echo "Sorry, your file size must be 2MB or lessthan 2MB."; $uploadOk = 0; }
    if ($uploadOk == 0) { /*echo "Sorry, your file was not uploaded.";  if everything is ok, try to upload file */}
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
	else
    {
	  if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {  /* echo "The file ". htmlspecialchars( basename( $_FILES["filename"]["name"])). " has been uploaded.";*/ }
	  else { /*echo "Sorry, there was an error uploading your file."*/; }
	}

    $Query=$Controller->QueryData("INSERT INTO bugs ( priority, screenshot, title, what_happend, page_url, suggestion ) VALUES (?,?,?,?,?,?)",[ $Priority, $target_file, $title, $details, $Page_URL, $Suggestion ]);   
    if($Query)    { 
        echo"<script> alert('Data Successfully stored...'); </script>";
    }
    else { echo"<script> alert('Data didn't Successfully stored...'); </script>";}
    header("location: index.php");
    exit ;
}
?>

<div class="container">
    <div class="card m-3 ">
        <div class="card-body d-flex justify-content-between ">
            <div class = "d-flex justify-content-start " >
                <a class= "btn btn-outline-primary  pe-2 me-1" href="index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </a>            
                <h5 class = "m-0  py-2 " > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-bug" viewBox="0 0 16 16">
                        <path d="M4.355.522a.5.5 0 0 1 .623.333l.291.956A4.979 4.979 0 0 1 8 1c1.007 0 1.946.298 2.731.811l.29-.956a.5.5 0 1 1 .957.29l-.41 1.352A4.985 4.985 0 0 1 13 6h.5a.5.5 0 0 0 .5-.5V5a.5.5 0 0 1 1 0v.5A1.5 1.5 0 0 1 13.5 7H13v1h1.5a.5.5 0 0 1 0 1H13v1h.5a1.5 1.5 0 0 1 1.5 1.5v.5a.5.5 0 1 1-1 0v-.5a.5.5 0 0 0-.5-.5H13a5 5 0 0 1-10 0h-.5a.5.5 0 0 0-.5.5v.5a.5.5 0 1 1-1 0v-.5A1.5 1.5 0 0 1 2.5 10H3V9H1.5a.5.5 0 0 1 0-1H3V7h-.5A1.5 1.5 0 0 1 1 5.5V5a.5.5 0 0 1 1 0v.5a.5.5 0 0 0 .5.5H3c0-1.364.547-2.601 1.432-3.503l-.41-1.352a.5.5 0 0 1 .333-.623zM4 7v4a4 4 0 0 0 3.5 3.97V7H4zm4.5 0v7.97A4 4 0 0 0 12 11V7H8.5zM12 6a3.989 3.989 0 0 0-1.334-2.982A3.983 3.983 0 0 0 8 2a3.983 3.983 0 0 0-2.667 1.018A3.989 3.989 0 0 0 4 6h8z"/>
                    </svg>
                    Bug Report
                </h5>
            </div>
            <div>
                <a class="btn btn-outline-primary" href="#">bug Report Guidlines</a>
            </div>
        </div>
    </div> 
    <div class="card mb-3  ms-3 me-3" style = "font-family: Roboto,sans-serif;"><!-- start of the card div -->
      <div class="card-body "> <!-- start of the card-body div -->
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12  mt-1">
                        <label class="form-label fs-5" for="Priority">Priority</label>
                            <select class="form-select" name="Priority" id="Priority">
                                <option>Select Priority</option>
                                <option value="critical">Critical</option>
                                <option value="urgent">Urgent</option>
                                <option value="important">Important</option>
                                <option value="normal">Normal</option>
                            </select>
                    </div> 
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-1">
                        <label class="form-label fs-5" for="myFile">Upload Screenshot</label>
                        <input class="form-control" type="file" id="myFile" name="filename">    
                    </div> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                        <label class="form-label fs-5" for="title"></label>
                        <input class="form-control fs-5" type="text" id="title" name="title" placeholder="Title">    
                    </div> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                        <label class="form-label fs-5" for="details">Explain What Happened</label>
                        <textarea class="form-control" cols="20" rows="4" name="details" id="details"></textarea>    
                    </div> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                        <label class="form-label fs-5" for="URl"></label>
                        <input class="form-control fs-5" type="text" id="URL" name="URL" placeholder="Bug page URL">    
                    </div> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                        <label class="form-label fs-5" for="Suggestion">Suggestion</label>
                        <textarea class="form-control" cols="20" rows="4" id="Suggestion" name="Suggestion"></textarea>    
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <input class="btn btn-outline-primary" type="submit" name="save" value="Sava">
                        &nbsp;&nbsp;
                        <input class="btn btn-outline-secondary" type="reset" value="Clear">
                    </div> 
                </div>
            </form>
        </div> <!-- End of the card-body div -->
    </div><!-- End of the card div -->
</div><!-- container  -->






<script   src="../Public/Js/bootstrap.min.js"></script>  
 </body>
 </html>