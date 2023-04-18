<?php
  $ROOT_DIR = 'C:/xampp/htdocs/BGIS/';
  require_once  $ROOT_DIR . 'App/Controller.php'; 

  if(isset($_POST['user']) && !empty($_POST['user']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
    $UserName=$_POST['user']; $UserPassword=$_POST['pass'];
    
    # SANITIZES THE TWO INPUTS 
    $UserName = $Controller->CleanInput($UserName);
    $UserPassword = $Controller->CleanInput($UserPassword);
    $LoginedUser = $Controller->QueryData("SELECT EPassword FROM employeet WHERE EUserName= ?", [$UserName]  );
 
    if ($LoginedUser->num_rows > 0) {
        $DBPassword = $LoginedUser->fetch_assoc();
        if ($DBPassword['EPassword'] == $UserPassword) {
            session_start();
            $Empl = $Controller->QueryData("SELECT EDepartment , EId , role_id, Eimage  FROM employeet WHERE EUserName = ?  AND EPassword = ?", [$UserName , $UserPassword]);
            $Employeet = $Empl->fetch_assoc();
        
       
            $EDepartment = $Employeet['EDepartment'];
            $_SESSION['user'] = $UserName;
            $_SESSION['EId'] = $Employeet['EId'];
            $_SESSION['last_login_timestamp'] = time();
            $_SESSION['user_image'] = $Employeet['Eimage'];
            

            // Authorization block 
            // gets access list of the role which is predefined for the authenticated user 
            $_SESSION['role_id'] = $Employeet['role_id'];
          
            // check if the user has role id or not 
            if(empty($Employeet['role_id']) && $Employeet['role_id'] == 0  ){

                // var_dump($Employeet['role_id']);
                // echo "-----------";  
                die('<h1 style = "text-align:center; margin-top:200px; background-color:red; padding:10px; color:white; ">YOU ARE NOT [ AUTHORIZED ] TO ACCESS THE SYSTEM </h1>
                <div style = "text-align:center; font-weight:bold" > <p>Please Contact System Admin For Help</p> </div>
                <div style = "text-align:center; padding:10px;"> <a href="Login.php" style = "text-decoration:none;font-weight:bold; font-size:24px; color:red; border-bottom:2px dotted black; " >BACK TO SAFETY </h1>'); 
                // header("Location: Login.php?msg=");

            }   
            
            $_SESSION['ACCESS_LIST'] = []; 
            $UAC = $Controller->QueryData("SELECT permission.slug FROM role 
            INNER JOIN role_permission ON role.id=role_permission.role_id 
            INNER JOIN permission ON role_permission.permission_id =permission.id 
            WHERE role_permission.role_id = ?", [ $Employeet['role_id'] ]);
            
            while($ACCESS_CONTROL = $UAC->fetch_assoc()){
                array_push($_SESSION['ACCESS_LIST'] , $ACCESS_CONTROL['slug']); 
            }
            // var_dump( $_SESSION['ACCESS_LIST']); echo  $Employeet['role_id'];   die(); // <- remove this line in deployment
          
            // this block is used to redirect specific users to specific pages 
            $redirect_to = "../index.php?msg=$UserName"; 
            $user_login_router = $Controller->QueryData("SELECT * FROM user_login_router WHERE EId = ?  ", [$Employeet['EId']]);
            if($user_login_router->num_rows > 0 ) {
                $route_to = $user_login_router->fetch_assoc()['route_to'];
                $redirect_to = $route_to; 
            }
            header("Location: $redirect_to ");
        } # END OF PASSWORD COMPARE BLOCK
        else header("Location:Login.php?msg= Wrong username or password!");
    } else header("Location:Login.php?msg=Wrong User Name!");
     
}# END OF ISSET ISSUE 
else header("Location:Login.php?msg=Username Password is Required");
?>