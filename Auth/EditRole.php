<?php  
ob_start();
require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc'; 
require_once '../Assets/Zebra/Zebra_Pagination.php';

if(isset($_GET['Id']) && !empty($_GET['Id']))
{
    $Id = $Controller->CleanInput($_GET['Id']);  
    $Select=$Controller->QueryData("SELECT * FROM `role` WHERE id=?",[$Id]);
    $Rows=$Select->fetch_assoc();

}
else
{
    header("Location:ShowAccessList.php");
}
if(isset($_POST['Update']) && !empty($_POST['Update']))
{
    $Id = $_POST['ID'];
    $Title=$_POST['Title'];
    $Description=$_POST['Description'];
 
    $Update=$Controller->QueryData("UPDATE `role` SET title=?,`description`=? WHERE id = ?" ,[$Title,$Description,$Id]);
    if($Update)
    {
        header("Location:ShowAccessList.php");
    }
}

?>

<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between">

        <h5 class="fw-bold">
            <a class="btn btn-outline-primary   me-1" href="ShowAccessList.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                </svg>
            </a> 
            Role Edit Page
        </h5> 
    </div>
</div> 

<form action="" method="POST">
    <div class="card m-3">
        <div class="card-body ">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <!-- <label for="">Title</label>
                    <input type="text" class="form-control" name="Title" id="Title" value="<?php if(isset($_GET['Id'])){ echo $Rows['title']; }?>"> -->

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="Title"  value="<?php if(isset($_GET['Id'])){ echo $Rows['title']; }?>"  id="floatingInput11" placeholder="Role Name">
                        <label for="floatingInput11">Role Name </label>
                    </div>
                  



                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                    <!-- <label for="" >Description</label>
                    <textarea name="Description" id="" cols="20" rows="10" class="form-control"><?php if(isset($_GET['Id'])){ echo $Rows['description']; }?></textarea>  -->

                    <div class="form-floating">
                        <textarea class="form-control"  name="Description"  placeholder="Description" id="floatingTextarea2"  cols="20" rows="10"  style="height: 100px"><?php if(isset($_GET['Id'])){ echo $Rows['description']; }?></textarea>
                        <label for="floatingTextarea2">Description for the role </label>
                    </div>

                    
                </div>
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-end">
                    <input type="submit" class="btn btn-outline-primary " name="Update" value="Update">
                    <input type="hidden" name="ID" value="<?php if(isset($_GET['Id'])){echo $Id=$_GET['Id']; }?>">
                </div>
                
            </div>
        </div>
    </div>
</form>



<?php  require_once '../App/partials/Footer.inc'; ?>