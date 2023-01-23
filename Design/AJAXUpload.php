<?php

$ROOT_DIR = 'F:/BaheerApps/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 


if (isset($_POST["CTNId"]) && !empty($_POST["CTNId"])  && isset($_FILES["file"]) && !empty($_FILES["file"])  ) {


 

if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
          
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}


  
  if(!isset($_POST["DesignCode"]) &&  empty($_POST["DesignCode"]) ) {
    // echo "ERROR: please check you have no Design Code"; 
    echo json_encode('-1');
    die(); 
  }


    // SELECT CTNId ,Designinfo.CaId, designinfo.OriginalFile FROM carton INNER JOIN designinfo ON designinfo.CaId=carton.CTNId WHERE CaId = 4806 AND (OriginalFile = 'NULL' OR OriginalFile IS NULL);

    $CTNId = $Controller->CleanInput($_POST['CTNId']);
    $DesignCode= $Controller->CleanInput($_POST['DesignCode']);
    $target_file =  '('. $DesignCode . ")_". basename($_FILES["file"]["name"]) ; 
    $target_dir = "../Storage/Design/" . $target_file;
    $file_type = mime_content_type($_FILES["file"]['tmp_name']); 


  if( $file_type == 'image/jepg' || $file_type  == 'application/pdf' || $file_type  == 'application/zip' || $file_type == 'application/x-rar-compressed' || $file_type  == 'image/vnd.adobe.photoshop' || $file_type  == 'application/postscript' ) {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir)) {
          $DataRows = $Controller->QueryData("UPDATE designinfo SET  OriginalFile = ? WHERE CaId = ? " , [ $target_file , $CTNId ]);
          if($DataRows){
            echo json_encode(['msg' => 'File has been uploaded successfully' , 'type' => 'success', 'redirect' => true]);
          }
          else {
            echo json_encode('-2'); // sorry the file was not uploaded 
            die(); 
          } 
      } else {
        // echo "Sorry, there was an error uploading your file.";
        echo json_encode('-3');
      }
  }
  else echo json_encode(['msg' => 'This file type is not allowed to upload' , 'type' => 'danger']);
} 
else echo json_encode(['msg' => 'No file to upload' , 'type' => 'danger']);




?>








