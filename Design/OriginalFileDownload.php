<?php  

    require_once 'Controller.php';

    if(isset($_GET['OriginalFile']) && !empty(trim($_GET['OriginalFile'])) && isset($_GET['CTNId']) && !empty($_GET['CTNId'])   ) {
        $FileName = $Controller->CleanInput($_GET['OriginalFile']); 
        $id = $Controller->CleanInput($_GET['CTNId']); 
 
        // check if the original file exist in the design info 
        $DataRows=$Controller->QueryData("SELECT  CTNId, OriginalFile FROM carton 
        INNER JOIN designinfo ON designinfo.CaId=carton.CTNId WHERE CaId = ?", [ $id ] );

        if($DataRows->num_rows > 0  ) {
            $Data = $DataRows->fetch_assoc();
            if($Data['OriginalFile'] == $FileName) {
                $file_to_download = '../Storage/Design/'. $FileName;  
                $client_file = $FileName;
                $download_rate = 200; // 200Kb/s
                $f = null;

                try {
                    if (!file_exists($file_to_download)) {
                        echo "<script>window.location.replace('OrignalFile.php?msg=No such file exist in the server&class=danger'); </script>";
                        throw new Exception('File ' . $client_file . ' does not exist in the server');
                    }

                    header('Cache-control: private');
                    header('Content-Type: application/octet-stream');
                    header('Content-Length: ' . filesize($file_to_download));
                    header('Content-Disposition: filename=' . $client_file);
                    ob_clean();
                    // flush the content to the web browser
                    flush();
                    $f = fopen($file_to_download, 'r');
                    while (!feof($f)) {
                        // send the file part to the web browser
                        print fread($f, round($download_rate * 1024));
                        // flush the content to the web browser
                        flush();
                        // sleep one second
                        sleep(1);
                    }
                } catch (\Throwable $e) {
                    echo $e->getMessage();
                } finally {
                    if ($f) {
                        fclose($f);
                    }
                }



            } // end of == if 
            
        }// end of if has data in the database 
        else header('Location:OrignalFile.php?msg=No such file found in the system&class=danger');
    }
    else header('Location:OrignalFile.php?msg=No File name Provided&class=danger');

    
