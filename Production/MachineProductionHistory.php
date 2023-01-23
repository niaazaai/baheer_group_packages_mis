<?php  require 'Controller.php'; 
    if( isset($_REQUEST['CTNId']) && !empty($_REQUEST['CTNId'])  && isset($_REQUEST['machine_id']) && !empty(trim($_REQUEST['machine_id'])) 
    &&  isset($_REQUEST['status']) && !empty(trim($_REQUEST['status'])) &&  isset($_REQUEST['cycle_id']) && !empty($_REQUEST['cycle_id'])  ) {

        date_default_timezone_set('Asia/Kabul');
 
        $double_job = '-1'  ; 
        if(isset($_REQUEST['double_job']) && !empty($_REQUEST['double_job'])) {
            $double_job = $_REQUEST['double_job'];
        }

        foreach ($_REQUEST['CTNId'] as $key => $CTNId) {

        $start_time = NULL ; 
        $end_time = NULL; 
        $machine_id = $_REQUEST['machine_id']; 

        if(trim($_REQUEST['status']) == 'configure machine') {
            $start_time = date("Y-m-d H:i:s"); 
        }
        else if(trim($_REQUEST['status']) == 'start production') {
            $start_time = date("Y-m-d H:i:s");  


            die($CTNId); 

            if($Controller->QueryData('UPDATE machine_production_history SET  end_time  = ? WHERE CTNId = ? AND cycle_id = ? AND status = ? ',
            [$start_time ,  $CTNId , $_REQUEST['cycle_id'][$key] , 'configure machine' ])){
                echo "updated!"; 
            }
        }
        else if(trim($_REQUEST['status']) == 'Job Completed') {
            $start_time = date("Y-m-d H:i:s");  
            $end_time = $start_time; 

            $UP = $Controller->QueryData('SELECT * FROM machine_production_history WHERE CTNId = ? && cycle_id = ? ', 
            [ $CTNId , (int) $_REQUEST['cycle_id'][$key]  ]);
        
            $sts = null; 
            if($UP->num_rows > 0){
            
                while ( $mph = $UP->fetch_assoc() ) {
                    $sts = $mph['status'];
                }
        
                if($Controller->QueryData('UPDATE machine_production_history SET  end_time  = ? WHERE CTNId = ? AND cycle_id = ? AND status = ? ',
                [$start_time ,  $CTNId ,$_REQUEST['cycle_id'][$key] , $sts  ])){
                }
            }
        }
        else {
            $start_time = date("Y-m-d H:i:s");  

            $UP = $Controller->QueryData('SELECT * FROM machine_production_history WHERE CTNId = ? && cycle_id = ? ', 
            [ $CTNId , (int) $_REQUEST['cycle_id'][$key]  ]);
        
            $sts = null; 
            if($UP->num_rows > 0){
            
                while ( $mph = $UP->fetch_assoc() ) {
                    $sts = $mph['status'];
                }
        
                if($Controller->QueryData('UPDATE machine_production_history SET  end_time  = ? WHERE CTNId = ? AND cycle_id = ? AND status = ? ',
                [$start_time ,  $CTNId , $_REQUEST['cycle_id'][$key] , $sts  ])){
                
                }

            }

            // echo "<pre>"; 
            // var_dump($_REQUEST); 
            // echo "</pre>";

        }

        $MPH = $Controller->QueryData('INSERT INTO machine_production_history (CTNId , cycle_id, machine_id , `status` , start_time , end_time  ) VALUES(?,?,?,?,?,?)',
        [ $CTNId ,$_REQUEST['cycle_id'][$key] , $_REQUEST['machine_id'] , $_REQUEST['status'] , $start_time , $end_time]);

    } // END OF LOOP 
    header('Location:JobProcess.php?CTNId='. $_REQUEST['CTNId'][0] .'&CYCLE_ID='.$_REQUEST['cycle_id'][0] . '&machine_id=' . $machine_id .'&double_job='.$double_job   );
    }
?>