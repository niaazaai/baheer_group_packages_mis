<?php require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';?>
<?php

$EmpId=$_SESSION['EId'];
 
// EmpIdNo
 
$SELECT=$Controller->QueryData("SELECT * FROM employeet WHERE EId =?",[$EmpId]);
$Record=$SELECT->fetch_assoc();

// $SELECT=$Controller->QueryData("SELECT * FROM employeet WHERE EId =?",[$EmpId]);
// $Password=$SELECT->fetch_assoc();

if(isset($_POST['Update']) && !empty($_POST['Update']))
{
    $CurrentPassword=$_POST['CurrentPassword'];
    $NewPassword=$_POST['NewPassword'];
    $ConfirmPassword=$_POST['ConfirmPassword'];

    $EAccessId=$_POST['EAccessId'];

    $update=$Controller->QueryData("UPDATE employeet SET EPassword=? WHERE EId=?",[$NewPassword,$_SESSION['EId']]);
    if($update)
    {
        echo'<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <strong>!</strong> You Successfully change you are password.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}


?>


 


<div class="card m-3">
    <div class="card-body">
        <h3 class="p-0 m-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
            </svg>
            User Profile
        </h3>
    </div>
</div>

 

<div class="row ">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1"> 
        <div class="card shadow ms-3">
            <div class="card-body ">
                <div class="text-center " >
                    <img  src="../Assets/DesignImages/pic.jpg" class=" rounded-circle img-fluid" alt="..." style="width:200px;"  >
                    <!-- <img  src="../Assets/DesignImages/<?=$Record['Eimage']?>" class=" rounded-circle img-fluid" alt="..." style="width:200px;"  > -->
                </div>
                <h3 class="card-title text-center mt-4 "><?=$Record['Ename']?></h3>
                <p class="card-text text-center"><span class="badge bg-info"><?=$Record['EJob']?></span> <span class="badge bg-info">( <?=$Record['EUserName']?> )</span></p>
                <p class="card-text text-center"></p>
                
                <!-- Button trigger modal -->
                <div class="text-center" style="margin-bottom:90px ;">
                    <button type="button" class="btn btn-outline-primary btn sm  " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Change Password
                    </button>
                </div>
            </div>
        </div> 
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 my-1">
        <div class="card shadow"> <!-- Start of info card -->
            <div class="card-body">
                <table class="table ">
                     <tr>
                         <th>Employee Name</th><td><?=$Record['Ename']?></td> 
                     </tr>
                     <tr>
                        <th>F/Name</th><td><?=$Record['EFName']?></td> 
                     </tr>
                     <tr>
                        <th>Phone</th><td><?=$Record['EMobileNumber']?></td>
                     </tr>
                     <tr>
                        <th>Current Address</th><td><?=$Record['ECAddress']?></td>
                     </tr>
                     <tr>
                        <th>permanent</th><td><?=$Record['EPAddress']?></td>
                     </tr>
                     <tr>
                        <th>Email</th><td><?=$Record['Eemail']?></td>
                     </tr>
                     <tr>
                        <th>Status</th><td><?=$Record['EMStatus']?></td>
                     </tr>
                     <tr>
                        <th>tazikara No</th><td><?=$Record['EIdentityNumber']?></td>
                     </tr>
                     <tr>
                        <th>Qualification</th><td><?=$Record['EQualification']?></td>
                     </tr>
                     <tr>
                        <th>Blood Group</th><td><?=$Record['Eblood']?></td>
                     </tr>
                    
                </table>
            </div>
        </div><!-- End of info card -->
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
        <div class="card shadow"> <!-- Start of info card -->
            <div class="card-body">
                <table class="table ">
                    <tr>
                        <th>User ID</th><td><?=$Record['EAccessId']?></td> 
                    </tr>
                    <tr>
                        <th>Grade</th><td><?=$Record['EGrade']?></td> 
                    </tr>
                    <tr>
                        <th>Type</th><td><?=$Record['EType']?></td>
                    </tr>
                    <tr>
                        <th>Department</th><td><?=$Record['EDepartment']?></td>
                    </tr> 
                    <tr>
                        <th>Position</th><td><?=$Record['EJob']?></td>
                    </tr>
                    <tr>
                        <th>Join Date</th><td><?=$Record['EJoinDate']?></td>
                    </tr>
                  
                </table>
            </div>
        </div><!-- End of info card -->
    </div>
</div>

 



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-braces-asterisk" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C2.25 2 1.49 2.759 1.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6ZM14.886 7.9v.164c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456v-1.3c-1.114 0-1.49-.362-1.49-1.456V4.352C14.51 2.759 13.75 2 12.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6ZM7.5 11.5V9.207l-1.621 1.621-.707-.707L6.792 8.5H4.5v-1h2.293L5.172 5.879l.707-.707L7.5 6.792V4.5h1v2.293l1.621-1.621.707.707L9.208 7.5H11.5v1H9.207l1.621 1.621-.707.707L8.5 9.208V11.5h-1Z"/>
            </svg>
            Change password 
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST" onsubmit  = "return matchPassword(this)">
      <div class="modal-body"> 



            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="CurrentPassword" name="CurrentPassword" placeholder="Password">
                <label for="floatingInput">Current Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="NewPassword" name="NewPassword" placeholder="Password">
                <label for="floatingPassword">New Password</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder="Password">
                <label for="floatingPassword">Confirm Password</label>
    
            </div>
            <div id="massege"></div>

      </div>
      <input type="hidden" name="EAccessId" value="<?=$Record['EAccessId']?>">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" name="Update" value="update" id = "UpdatePassword"  class="btn btn-outline-primary"  >
      </div>
      </form>
    </div>
  </div>
</div>



<script>

document.getElementById("UpdatePassword").addEventListener("click", function(event){


        var NewPassword= document.getElementById("NewPassword").value;
        var ConfirmPassword= document.getElementById("ConfirmPassword").value;
        var CurrentPassword = document.getElementById("CurrentPassword").value; 
        

      

        if(CurrentPassword == NewPassword) {
            event.preventDefault(); 
            document.getElementById("massege").classList = "text-danger mt-2  ";
            document.getElementById("massege").innerHTML="You can not use your old password "; 
        
        } 

        if(NewPassword != ConfirmPassword)   {   

           
            // alert("Passwords did not match"); 
            event.preventDefault(); 
            document.getElementById("ConfirmPassword").classList = ' form-control is-invalid';
            document.getElementById("NewPassword").classList = ' form-control is-invalid';

            document.getElementById("massege").classList = "text-danger mt-2  ";
            document.getElementById("massege").innerHTML="New Password does not match"; 

        } 

        if(NewPassword.length < 8 ) {
            event.preventDefault(); 
            document.getElementById("massege").classList = "text-danger mt-2  ";
            document.getElementById("massege").innerHTML="Password must contain at lease 8 characters "; 
        }

        

});

 
</script>

<?php  require_once '../App/partials/Footer.inc'; ?>
