<?php 
    require_once 'Controller.php' ; 
   

    if(  isset($_POST['Reel']) &&  !empty($_POST['Reel'])   && isset($_POST['Wast']) 
    && isset($_POST['Ups']) &&  !empty($_POST['Ups'])  && isset($_POST['Creesing']) &&  !empty($_POST['Creesing']) 
    && isset($_POST['CTNId']) &&  !empty($_POST['CTNId']) )  {

      
 
        // $UpdateCarton=$Controller->QueryData("UPDATE carton set CTNStatus = 'Selected' WHERE CTNId=?",[$_POST['CTNId']]);
        
        // check if the record exist in used paper or not 
        $CheckPSI  = $Controller->QueryData('SELECT carton_id FROM used_paper WHERE carton_id = ?', [$_POST['CTNId'] ]);

     

        if($CheckPSI->num_rows > 0 ) {
            $Update  = $Controller->QueryData('UPDATE used_paper  SET  reel = ? , wast= ? , ups = ? , creesing = ?    WHERE carton_id = ? ', 
            [ $_POST['Reel']   , $_POST['Wast'] , $_POST['Ups']  , $_POST['Creesing']  ,   $_POST['CTNId'] ] );
          
            header('Location:JobManagement.php?CTNId='. $_POST['CTNId'] .'&msg=Paper Setting completed &class=success') ;

        }
        else { 
            $InsertPSI  = $Controller->QueryData('INSERT INTO used_paper (carton_id , reel , wast , ups , creesing   ) VALUES (?,?,?,?,?)',   
            [ $_POST['CTNId'] ,  $_POST['Reel']   , $_POST['Wast'] , $_POST['Ups']  , $_POST['Creesing'] ] );

            if(!$InsertPSI) {
                header('Location:JobManagement.php?CTNId='.$_POST['CTNId'] . '&msg=something went wrong&class=danger') ;
            }
            header('Location:JobManagement.php?CTNId='. $_POST['CTNId']) ;
        }


    } // END IF BLOCK 
    else {
        // var_dump($_POST); 
        header('Location:JobManagement.php?CTNId='. $_POST['CTNId'] .'&msg=something went wrong&class=danger') ;

    }

?>