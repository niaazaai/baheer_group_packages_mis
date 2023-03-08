
<?php
ob_start(); 
require_once '../App/partials/Header.inc'; 

$Gate = require_once  $ROOT_DIR . '/Auth/Gates/DESIGN_DEPT';
if(!in_array( $Gate['VIEW_MANAGE_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized to access job center of design department!" );
}



require_once '../App/partials/Menu/MarketingMenu.inc';

if(isset($_GET['CTNId'])) 
{
    
    $CartonId=$_GET['CTNId'];
    $SQL='SELECT `CTNId`, ppcustomer.CustWorkPhone,ppcustomer.CustName, ppcustomer.CustEmail,ppcustomer.CmpWhatsApp, `CTNType`,polymer_info, die_info ,`CustId1`, `JobNo`, `EmpId`, 
                  CONCAT (CTNLength ,"x",CTNWidth,"x",CTNHeight ) AS Size, ppcustomer.CustContactPerson, `CTNOrderDate`,offesetp, `CTNFinishDate`, 
                  CTNStatus, `CTNQTY`, `CTNUnit`, `CTNColor`, `CTNPaper`,ppcustomer.`CustCatagory`,ppcustomer.CustWebsite, ppcustomer.CustAddress, 
                  ppcustomer.CustMobile, cpolymer.CPid, cpolymer.MakeDate, cpolymer.POwner, DieId , Scatch ,DieCode, PStatus, CTNDiePrice, carton.ProductName,designinfo.DesignImage,designinfo.DesignCode1,designinfo.DesignStatus,
                  Note, CTNPolimarPrice, offesetp FROM `carton` INNER JOIN ppcustomer ON carton.CustId1=ppcustomer.CustId LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId 
                  LEFT OUTER JOIN cpolymer ON cpolymer.CPid=carton.PolyId LEFT OUTER JOIN cdie ON cdie.CDieId=carton.DieId  where `CTNId`= ?';

    $DataRows=$Controller->QueryData($SQL,[$CartonId]);
    $Rows=$DataRows->fetch_assoc();    
 
}
 
if(isset($_POST['SaveforDesign']))
{
    $id=$_GET['CTNId']; 
    $ListType=$_GET['ListType'];
    $DesignBy=$_POST['DesignBy'];        
    $DesignCode=$_POST['DesignCode'];    
    $DesignName=$_POST['DesignName'];
    $FinishTime=$_POST['FinishTime']; 
    $Comment=$_POST['Comment'];
    $DesignStatus= $Controller->CleanInput($_POST['DesignStatus']); 

    $target_dir = "../Assets/DesignImages/";
    $target_file = $target_dir . basename($_FILES["DesignImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $FileName =  basename( $_FILES["DesignImage"]["name"]) ;
    $Upload = true; 
    $msg = []; 

    
    $CheckId=$Controller->QueryData("SELECT `DesignId`, `CaId` FROM `designinfo` WHERE CaId=?",[$id]);
 
    if($CheckId->num_rows > 0)
    {
        if($_FILES["DesignImage"]["size"] == 0)
        {
            
            $update  = $Controller->QueryData("UPDATE designinfo SET  DesignerName1=?, DesignStatus=?   , DesignStartTime=CURRENT_TIMESTAMP WHERE CaId=? ",[$DesignBy,$DesignStatus,$id]);
            if($update)
            {      
                $UpdateCarton =$Controller->QueryData( "UPDATE `carton` SET `CTNStatus` = 'DesignProcess' where `CTNId` = ?",[$id]);
                header('Location:JobCenter.php?msg=Data Updated successfully, plus carton status is also changed&class=success&ListType='. $ListType); 
            }
            else
            {
                header('Location:JobCenter.php?msg=Didnt insert Data!&class=danger&ListType='.$ListType);
            }
        }
        elseif(isset($DesignCode) && !empty(trim($DesignCode)))
        {
            
            // Check file size
            if ($_FILES["DesignImage"]["size"] > 3485760  ) { // which is 2 million bytes ( 2MB)
                array_push($msg , "Sorry, your file is too large ( less than 3 MB) "); 
                $Upload = false;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "jpeg" ) {
                array_push($msg , "Sorry, only JPG, JPEG  files are allowed."); 
                $Upload = false;
            }
            // Check if $uploadOk is set to 0 by an error/
            if (!$Upload) 
            {         
                
                echo '<div class="alert alert-danger m-3 alert-dismissible fade show" role="alert"><strong>Something Went Wrong!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            // if everything is ok, try to upload file
            }
           
            if (move_uploaded_file($_FILES["DesignImage"]["tmp_name"], $target_file)) 
            {
                $UPDATE=$Controller->QueryData("UPDATE `designinfo` SET DesignStatus=?,  CompleteTime=CURRENT_TIMESTAMP, DesignImage=? ,DesignCode1=? where CaId=?",[$DesignStatus,$FileName,$DesignCode,$id]);
                $UpdateCarton =$Controller->QueryData( "UPDATE `carton` SET `CTNStatus`='DesignProcess' where `CTNId` = ?",[$id]);
                if($UPDATE)
                {
                    header('Location:JobCenter.php?msg=Design Id was already Exist! Only Design status and Carton Status are changed and image uploaded&class=success&ListType='. $ListType);
                }
            }
    
        }
        else
        {
            header('Location:DesignManage.php?msg=Design Code is empty you can not process without Design code&class=danger&ListType='.$ListType.'&CTNId='.$_GET['CTNId']);
        }   
        
      
    }
    else
    {
 
        $INSERT  = $Controller->QueryData("INSERT INTO designinfo ( DesignName1 , DesignerName1, DesignStatus ,  CaId , Alarmdatetime ,  DesignStartTime , DesignDep )
        VALUES (? , ? , ?  ,? ,? , CURRENT_TIMESTAMP, 'Design')",[$DesignName ,$DesignBy, $DesignStatus , $id , $FinishTime ]);
        if($INSERT)
        {
            $UpdateCarton =$Controller->QueryData( "UPDATE carton SET CTNStatus = 'DesignProcess' where CTNId = ? ",[$id]);
            if( $UpdateCarton)
            {
                header('Location:JobCenter.php?msg=Data Inserted successfully plus carton status is also changed&class=success&ListType='. $ListType);
            } 
        }
        else
        {
            header('Location:JobCenter.php?msg=Didnt insert Data!&class=danger&ListType='.$ListType);
        }

   
    }    
    $UpdateProductionReport=$Controller->QueryData("UPDATE `productionreport` SET `DesignEnd`= CURRENT_TIMESTAMP, `DesignComment`=?, ArchiveStart=CURRENT_TIMESTAMP, ProductionStart = CURRENT_TIMESTAMP WHERE RepCartonId = ?",[$Comment , $id]);

}


if(isset($_POST['Save&Submit']))
{
    $ListType=$_GET['ListType'];
    $CTNId=$_GET['CTNId'];      

    $DesignStatus=$_POST['DesignStatus']; 
    $DesignCode=trim($_POST['DesignCode']);    
    $DesignBy=$_POST['DesignBy'];    
    $DesignName=$_POST['DesignName'];
    $Comment=$_POST['Comment'];   
    $JobNo = $_POST['JobNo'];
    $offesetp=$_POST['offesetp'];
   

    $CheckId=$Controller->QueryData("SELECT `DesignId`, `CaId`,DesignCode1 FROM `designinfo` WHERE CaId=?",[$CTNId]);
    $Check=$CheckId->fetch_assoc();
    $target_dir = "../Assets/DesignImages/";
    $target_file = $target_dir . basename($_FILES["DesignImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $FileName =  basename( $_FILES["DesignImage"]["name"]) ;

    $Upload = true; 
    $msg = []; 
    if($CheckId->num_rows > 0)
    {
        if($offesetp == 'No')
        { 
            if( $FileName !='')
            {
                if ($_FILES["DesignImage"]["size"] > 3485760  ) { // which is 2 million bytes ( 2MB)
                    array_push($msg , "Sorry, your file is too large ( less than 3 MB) "); 
                    $Upload = false;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "jpeg" ) {
                    array_push($msg , "Sorry, only JPG, JPEG  files are allowed."); 
                    $Upload = false;
                }
                // Check if $uploadOk is set to 0 by an error/
                if (!$Upload) 
                {         
                    echo '<div class="alert alert-danger m-3 alert-dismissible fade show" role="alert"><strong>Something Went Wrong!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                    
                // if everything is ok, try to upload file
                } 
                elseif(isset($DesignCode) && !empty(trim($DesignCode)))
                { 
            
                    if (move_uploaded_file($_FILES["DesignImage"]["tmp_name"], $target_file)) 
                    {
        
                        if($JobNo=='NULL')  $UpdateStatus = "UPDATE carton SET CTNStatus='DConfirm' where CTNId=?";
                        else $UpdateStatus = "UPDATE carton SET CTNStatus='Archive' where CTNId=?";
                        $UpdateStatus1=$Controller->QueryData($UpdateStatus ,  [$CTNId] ); 
                        $UpdateDesignInfo=$Controller->QueryData("UPDATE  designinfo SET DesignStatus = ?, DesignImage = ?, DesignCode1 = ?,CompleteTime=CURRENT_TIMESTAMP  WHERE CaId = ? " ,   [$DesignStatus , $FileName , $DesignCode , $CTNId] ); 
        
                        $CartonComment = $Controller->QueryData("INSERT INTO cartoncomment (EmpId1,EmpComment,CartonId1, ComDepartment) VALUES ( ?, ?, ?, 'Design')" ,   [$_SESSION['EId'] , $Comment , $CTNId ] ); 
        
                        $productionreport12 = $Controller->QueryData("UPDATE productionreport SET DesignEnd=CURRENT_TIMESTAMP, DesignComment=? , PPStart=CURRENT_TIMESTAMP WHERE RepCartonId=?" ,   [ $Comment , $CTNId ] );
                        if($productionreport12) 
                        {
                            header('Location:JobCenter.php?msg=Data Uploaded successfully&class=success&ListType='.$ListType);
                        }
                    
                    }
                    else 
                    {
                        echo "Sorry, there was an error uploading your file.";
                    } 
                    
                }
                else
                {
                    header('Location:DesignManage.php?msg=Design Code is empty you can not process without Design code&class=danger&ListType='.$ListType.'&CTNId='.$_GET['CTNId']);
                } 

            }
            else
            { 
                    
        
                if($JobNo=='NULL')  $UpdateStatus = "UPDATE carton SET CTNStatus='DConfirm' where CTNId=?";
                else $UpdateStatus = "UPDATE carton SET CTNStatus='Archive' where CTNId=?";
                $UpdateStatus1=$Controller->QueryData($UpdateStatus ,  [$CTNId] ); 
                $UpdateDesignInfo=$Controller->QueryData("UPDATE  designinfo SET DesignStatus = ?,CompleteTime=CURRENT_TIMESTAMP  WHERE CaId = ? " ,   [$DesignStatus  , $CTNId] ); 

                $CartonComment = $Controller->QueryData("INSERT INTO cartoncomment (EmpId1,EmpComment,CartonId1, ComDepartment) VALUES ( ?, ?, ?, 'Design')" ,   [$_SESSION['EId'] , $Comment , $CTNId ] ); 

                $productionreport12 = $Controller->QueryData("UPDATE productionreport SET DesignEnd=CURRENT_TIMESTAMP, DesignComment=? , PPStart=CURRENT_TIMESTAMP WHERE RepCartonId=?" ,   [ $Comment , $CTNId ] );
                if($productionreport12) 
                {
                    header('Location:JobCenter.php?msg=Data Uploaded successfully&class=success&ListType='.$ListType);
                }
                       
                        
                        
                    
            } 
        }
        elseif($offesetp == 'Yes')
        {
            if( $FileName !='')
            {
                if ($_FILES["DesignImage"]["size"] > 3485760  ) { // which is 2 million bytes ( 2MB)
                    array_push($msg , "Sorry, your file is too large ( less than 3 MB) "); 
                    $Upload = false;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "jpeg" ) {
                    array_push($msg , "Sorry, only JPG, JPEG  files are allowed."); 
                    $Upload = false;
                }
                // Check if $uploadOk is set to 0 by an error/
                if (!$Upload) 
                {         
                    echo '<div class="alert alert-danger m-3 alert-dismissible fade show" role="alert"><strong>Something Went Wrong!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                    
                // if everything is ok, try to upload file
                } 
                elseif(isset($DesignCode) && !empty(trim($DesignCode)))
                { 
            
                    if (move_uploaded_file($_FILES["DesignImage"]["tmp_name"], $target_file)) 
                    {
        
                        if($JobNo=='NULL')  $UpdateStatus = "UPDATE carton SET CTNStatus='DConfirm' where CTNId=?";
                        else $UpdateStatus = "UPDATE carton SET CTNStatus='Printing' where CTNId=?";
                        $UpdateStatus1=$Controller->QueryData($UpdateStatus ,  [$CTNId] ); 
                        $UpdateDesignInfo=$Controller->QueryData("UPDATE  designinfo SET DesignStatus = ?, DesignImage = ?, DesignCode1 = ?,CompleteTime=CURRENT_TIMESTAMP  WHERE CaId = ? " ,   [$DesignStatus , $FileName , $DesignCode , $CTNId] ); 
        
                        $CartonComment = $Controller->QueryData("INSERT INTO cartoncomment (EmpId1,EmpComment,CartonId1, ComDepartment) VALUES ( ?, ?, ?, 'Design')" ,   [$_SESSION['EId'] , $Comment , $CTNId ] ); 
        
                        $productionreport12 = $Controller->QueryData("UPDATE productionreport SET DesignEnd=CURRENT_TIMESTAMP, DesignComment=? , PPStart=CURRENT_TIMESTAMP WHERE RepCartonId=?" ,   [ $Comment , $CTNId ] );
                        if($productionreport12)   header('Location:JobCenter.php?msg=Data Uploaded successfully&class=success&ListType='.$ListType);
                        
                    
                    }
                    else 
                    {
                        echo "Sorry, there was an error uploading your file.";
                    } 
                    
                }
                else
                {
                    header('Location:DesignManage.php?msg=Design Code is empty you can not process without Design code&class=danger&ListType='.$ListType.'&CTNId='.$_GET['CTNId']);
                } 

            }

            else
            { 
                 
                
                if($JobNo=='NULL')  $UpdateStatus = "UPDATE carton SET CTNStatus='DConfirm' where CTNId=?";
                else $UpdateStatus = "UPDATE carton SET CTNStatus='Printing' where CTNId=?";
                $UpdateStatus1=$Controller->QueryData($UpdateStatus ,  [$CTNId] ); 
                $UpdateDesignInfo=$Controller->QueryData("UPDATE designinfo SET DesignStatus = ?,CompleteTime=CURRENT_TIMESTAMP  WHERE CaId = ?" ,   [$DesignStatus , $FileName , $DesignCode , $CTNId] ); 

                $CartonComment = $Controller->QueryData("INSERT INTO cartoncomment (EmpId1,EmpComment,CartonId1, ComDepartment) VALUES ( ?, ?, ?, 'Design')" ,   [$_SESSION['EId'] , $Comment , $CTNId ] ); 

                $productionreport12 = $Controller->QueryData("UPDATE productionreport SET DesignEnd=CURRENT_TIMESTAMP, DesignComment=? , PPStart=CURRENT_TIMESTAMP WHERE RepCartonId=?" ,   [ $Comment , $CTNId ] );
                if($productionreport12) 
                {
                    header('Location:JobCenter.php?msg=Data Uploaded successfully&class=success&ListType='.$ListType);
                }
                         
            }  

        }

    }


}

if(isset($_POST['Update']))
{

    $ListType=$_GET['ListType'];
    $CTNID=$_GET['CTNId'];      

    $DesignStatus=$_POST['DesignStatus']; 
    $DesignCode=$_POST['DesignCode'];    
    $DesignBy=$_POST['DesignBy'];    
    $DesignName=$_POST['DesignName']; 

    echo $DesignStatus."<br>". $DesignCode;
 
   

    $CheckId=$Controller->QueryData("SELECT `DesignId`, `CaId` FROM `designinfo` WHERE CaId=?",[$CTNID]);
    $target_dir = "../Assets/DesignImages/";
    $target_file = $target_dir . basename($_FILES["DesignImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $FileName =  basename( $_FILES["DesignImage"]["name"]) ;

    $Upload = true; 
    $msg = []; 
    if($CheckId->num_rows > 0)
    {
         
        // Check file size
        if ($_FILES["DesignImage"]["size"] > 3485760  ) { // which is 2 million bytes ( 2MB)
            array_push($msg , "Sorry, your file is too large ( less than 3 MB) "); 
            $Upload = false;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "jpeg" ) {
            array_push($msg , "Sorry, only JPG, JPEG  files are allowed."); 
            $Upload = false;
        }
        // Check if $uploadOk is set to 0 by an error/
        if (!$Upload) 
        {         
            echo '<div class="alert alert-danger m-3 alert-dismissible fade show" role="alert"><strong>Something Went Wrong!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            
        // if everything is ok, try to upload file
        } 
        elseif(isset($DesignCode) && !empty(trim($DesignCode)))
        {
            if (move_uploaded_file($_FILES["DesignImage"]["tmp_name"], $target_file)) 
            {
 
                $UpdateDesignInfo=$Controller->QueryData("UPDATE  designinfo SET DesignStatus = ?, DesignImage = ?, DesignCode1 = ?,DesignStartTime=CURRENT_TIMESTAMP,CompleteTime=CURRENT_TIMESTAMP,	DesignerName1=?  WHERE CaId = ? " ,   [$DesignStatus , $FileName , $DesignCode ,$DesignBy, $CTNID] ); 
                if($UpdateDesignInfo) 
                {
                    header('Location:DesignProductList.php?msg=Data Uploaded successfully');
                }
            } 
            else 
            {
                echo "Sorry, there was an error uploading your file.";
            }
 
        }
        else
        {
            header('Location:DesignManage.php?msg=Design Code is empty you can not process without Design code&ListType='.$ListType.'&CTNId='.$_GET['CTNId']);
        }   

    }
    else
    {
        if ($_FILES["DesignImage"]["size"] > 3485760  ) { // which is 2 million bytes ( 2MB)
            array_push($msg , "Sorry, your file is too large ( less than 3 MB) "); 
            $Upload = false;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "jpeg" ) {
            array_push($msg , "Sorry, only JPG, JPEG  files are allowed."); 
            $Upload = false;
        }
        // Check if $uploadOk is set to 0 by an error/
        if (!$Upload) 
        {         
            echo '<div class="alert alert-danger m-3 alert-dismissible fade show" role="alert"><strong>Something Went Wrong!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            
        // if everything is ok, try to upload file
        } 
        elseif(isset($DesignCode) && !empty(trim($DesignCode)))
        { 
            if (move_uploaded_file($_FILES["DesignImage"]["tmp_name"], $target_file)) 
            {

                $INSERT  = $Controller->QueryData("INSERT INTO designinfo ( DesignName1 ,DesignImage,DesignerName1, DesignStatus,DesignCode1 ,CaId ,DesignStartTime ,CompleteTime, DesignDep )
                VALUES (?,?,?,?,?,?,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP, 'Design')",[$DesignName,$FileName ,$DesignBy, $DesignStatus,$DesignCode, $CTNID ]);
                if($INSERT) 
                {
                    header('Location:DesignProductList.php?msg=Data Uploaded successfully');
                }
            } 
            else 
            {
                echo "Sorry, there was an error uploading your file.";
            } 
        }
        else
        {
            header('Location:DesignManage.php?msg=Design Code is empty you can not process without Design code&ListType='.$ListType.'&CTNId='.$_GET['CTNId']);
        }   
    } 
    
}
     
?>




<style>
.stepper-wrapper {
  font-family: Arial;
  margin-top: 10px;
  display: flex;
  justify-content: space-between;
  margin-bottom: 0px;
}
.stepper-item {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 1;


  @media (max-width: 768px) {
    font-size: 12px;
  }
}

.stepper-item::before {
  position: absolute;
  content: "";
  border-bottom: 2px solid #ccc;
  width: 100%;
  top: 20px;
  left: -50%;
  z-index: 2;
}

.stepper-item::after {
  position: absolute;
  content: "";
  border-bottom: 2px solid #ccc;
  width: 100%;
  top: 20px;
  left: 50%;
  z-index: 2;

}

.stepper-item .step-counter {
  position: relative;
  z-index: 5;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #ccc;
  margin-bottom: 6px;
  /* background-color: yellow; */

}

.stepper-item.active {
  font-weight: bold;
  color:#0F3460
}

.stepper-item.completed .step-counter {
  background-color: #198754;
}

.stepper-item.completed::after {
  position: absolute;
  content: "";
  border-bottom: 2px solid #6BCB77;
  width: 100%;
  top: 20px;
  left: 50%;
  z-index: 3;
}

.stepper-item:first-child::before {
  content: none;
}
.stepper-item:last-child::after {
  content: none;
}

.blink {
    animation: blink 2s steps(1, end) infinite;
  }
  @keyframes blink{
      0%{     opacity:1;     }
      50%{    opacity:0;     }
      100%{   opacity: 1;    }
  }



</style>
 

  
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <?php if(isset($_GET['msg']) && !empty($_GET['msg'])) { ?>
        <div class="alert alert-<?=$_GET['class']?>  alert-dismissible fade show shadow" role="alert">
            <strong>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>  Information</strong> <?= $_GET['msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
</div>



<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between">
        <h5 class="my-1  ">  
            <?php $url = "JobCenter.php?ListType=". $_GET['ListType'];
                if($_GET['ListType'] == 'ProductList'){$url = "DesignProductList.php";}
            ?>
            <a class="btn btn-outline-primary   me-3" href="<?=$url?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
            </a>
        </h5>
    <div>
   
        
        <?php if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1'])) {?>
            <?php  if(in_array( $Gate['VIEW_DESIGN_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?>
            <a class="btn btn-outline-primary  "  style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                    href="ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                        
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    </svg> Design
                </a>
            <?php } ?> 

        <?php } else  echo '<span class = "text-danger mx-2 fw-bold ">No Design</span>';
            if(isset($Rows['DieCode']) && !empty($Rows['DieCode'])) {?>
                <?php  if(in_array( $Gate['VIEW_SKETCH_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?>
                    <a class="btn btn-outline-primary  "  style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image" href="ShowDesignImage.php?Url=<?=$Rows['Scatch']?>&ProductName=<?=$Rows['ProductName']?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                        </svg> Sketch
                    </a>
                <?php } ?>
        <?php } else   echo '<span class = "text-danger fw-bold  " >No Scatch</span>'; ?>

    </div>
  </div>
</div>

<div class="card m-3 shadow">
    <div class="card-body">
        <div class="stepper-wrapper">
<?php 
                              
    $id= $_GET['CTNId'];
    $ListType= $_GET['ListType'];

    $DesignQuery =$Controller->QueryData("SELECT DesignStatus, DesignName1, DesignerName1, DesignCode1 , DesignImage   FROM designinfo WHERE CaId = ?",[$id]);
    
    if($DesignQuery->num_rows == 0 ) {
        // $message  = 'Incorrect data Formed!'; 
        // echo " <script>window.location.replace('JobCenter.php?msg=" .$message   ."&class=danger');</script>";
        $show = 'NoDesignYet';

    } else {
        $show=$DesignQuery->fetch_assoc();
    }

    // var_dump($show); 
    $isYellow = true; 
    $stepper_item = '';  
    $class = ''; 
    $index = 1 ;

    $stages = [
        'New' => 'NULL', 
        'Assign' => 'Submit for design' , 
        'Process' => 'Processing' , 
        'Approval' => 'Sent For Approval' ,
        'Complete' => 'Done'
    ];


    if($show == 'NoDesignYet'){
        $show = ['DesignStatus' => "NULL" ]  ;
        // var_dump($show['DesignStatus']);
        // var_dump($stages);
    }
    
 
    // $show['DesignStatus'] = 'Pending';
    if($show['DesignStatus'] ==  'Design Exist') {
        echo '<h4 class= "text-center blink text-danger"> Design for this job already Exist </h4>';
        $stages = []; 
    }
    
    if($show['DesignStatus'] ==  'Edit Exist Design'  ) {
        $show['DesignStatus']  = 'NULL';
    }

    if($show['DesignStatus'] ==  'Reject') {
        echo '<h4 class= "text-center blink text-danger"> Design Rejected! </h4>';
        $stages = []; 
    }

    if($show['DesignStatus'] ==  'Pending') {
        echo '<h4 class= "text-center blink text-warning"> Design Pended! </h4>';
        $stages = []; 
    }

    if($show  ==  'Pending') {
        echo '<h4 class= "text-center blink text-warning"> Design Pended! </h4>';
        $stages = []; 
    }
    foreach ($stages as $key => $value) { 
        if ($isYellow) {
            if ($value ==  $show['DesignStatus'] ) {
                $class = 'bg-warning  ';
                $isYellow = false; 
                $stepper_item = 'active'; 
                if($show['DesignStatus'] == 'Done' || $show['DesignStatus'] == 'NULL') {
                    $class = 'bg-success ';
                }
            } else {
                $class = '';
                $stepper_item = 'completed';
            }
        }
        else {
            $class = '';
            $stepper_item = ''; 
        }
            
        ?>

        <div class="stepper-item <?php echo $stepper_item; ?> ">
            <div class="step-counter <?=$class?>" > <?=$index ?></div>
            <div class="step-name"> <?= $key ?></div>
        </div>
    <?php $index++;  }  ?>

        </div>
    </div>
</div>


<form class="form-validate"  enctype="multipart/form-data" id="feedback_form" method="post" action="DesignManage.php">
<div class="card m-3 shadow">
    <div class="card-body">
        <h3 class="mb-5">Jobs Processing From - Design Department</h3>
        <div class="row">
            
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 fw-bold">
                <label for="">Job No</label>
                <input type="text" name="JobNo" class="form-control" readonly value="<?php if(isset($Rows['JobNo'])) echo $Rows['JobNo']; ?>">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 fw-bold">
                <label for="">Company Name</label> 
                <input type="text" name="CompanyName" class="form-control" readonly value="<?php if(isset($Rows['CustName'])) echo $Rows['CustName']; ?>">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  fw-bold">
                <label for="">Product Name</label>
                <input type="text" name="ProductName" class="form-control" readonly value="<?php if(isset($Rows['ProductName'])) echo $Rows['ProductName']; ?>">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  fw-bold">
                <label for="">Size</label>
                <input type="text" name="Size" class="form-control" readonly value="<?php if(isset($Rows['Size'])) echo $Rows['Size']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">Order QTY</label>
                <input type="text" name="OrderQTY" class="form-control" readonly value="<?php if(isset($Rows['CTNQTY'])) echo $Rows['CTNQTY']; ?>">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">Color</label>
                <input type="text" name="Color" class="form-control" readonly value="<?php if(isset($Rows['CTNColor'])) echo $Rows['CTNColor']; ?>">
            </div>
            
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold"> 
                <label for="">Polymer</label>
                <input type="text" name="polymer" class="form-control" readonly value="<?php if(isset($Rows['polymer_info'])) echo $Rows['polymer_info'];?>">
                <!-- <input type="text" name="Polymer" class="form-control" readonly 
                value="<?php 
                            $Polymer=$Rows['CPid'];
                            $UsedPolymer=$Rows['PStatus'];
                            $PolymerPrice=$Rows['CTNPolimarPrice'];
                            $DiePrice=$Rows['PStatus'];
                            if($Polymer=='' && $PolymerPrice=''){ $Polymer='Personal Polymer'; } 
                            else if($Polymer==''){ $Polymer='Polymer Not Specified'; }
                            else{ $Polymer='Polymer Exist'; }  echo $Polymer; 
                        ?>"> -->
            </div>
          

 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">Die</label>
                <input type="text" name="Die" class="form-control" readonly value="<?php if(isset($Rows['die_info'])) echo $Rows['die_info'];?>">
                <!-- <input type="text" name="Die" class="form-control" readonly value="<?php if($DiePrice==''){ $DiePrice='No'; } else{ $DiePrice=$Rows['DieId']; } echo $DiePrice;  ?>"> -->
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">Contact Person</label>
                <input type="text" name="ContactPerson" class="form-control" readonly value="<?php if(isset($Rows['CustContactPerson'])) echo $Rows['CustContactPerson']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">Mobile</label>
                <input type="text" name="Mobile" class="form-control" readonly value="<?php if(isset($Rows['CustMobile'])) echo $Rows['CustMobile']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">Work Phone</label>
                <input type="text" name="WorkPhone" class="form-control" readonly value="<?php if(isset($Rows['CustWorkPhone'])) echo $Rows['CustWorkPhone']; ?>">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">What's up</label>
                <input type="text" name="WorkPhone" class="form-control" readonly value="<?php if(isset($Rows['CmpWhatsApp'])) echo $Rows['CmpWhatsApp']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">Email</label>
                <input type="text" name="Email" class="form-control" readonly value="<?php if(isset($Rows['CustEmail'])) echo $Rows['CustEmail']; ?>">
            </div>
 
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">Order Date</label>
                <input type="text" name="OrderDate" class="form-control" readonly value="<?php if(isset($Rows['CTNOrderDate'])) echo $Rows['CTNOrderDate']; ?>">
            </div>
 
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-1 fw-bold">
                <label for="">Comment</label>
                <input type="text" name="Comment" class="form-control" readonly value="<?php if(isset($Rows['Note'])) echo $Rows['Note']; ?>">
            </div>

        </div>
    </div>
</div>
</form>



<form action="" method="POST"  enctype="multipart/form-data" >
    <input type="hidden" name="JobNo" value = "<?php if(isset($Rows['JobNo'])) echo $Rows['JobNo']; ?>" >
    <input type="hidden" name="CTNId" value = "<?php if(isset($Rows['CTNId'])) echo $Rows['CTNId']; ?>" >
    <input type="hidden" name="offesetp" value="<?php if(isset($Rows['offesetp'])) echo $Rows['offesetp'];?>">

    <div class="card m-3">
        <div class="card-body">
            <h3 class="mb-4"> Design Information</h3>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 fw-bold">
                    <label for="DesignStatus">Design Status    </label>
                    <select name="DesignStatus" id="DesignStatus" class="form-select" <?php if($show['DesignStatus'] == 'Design Exist'){echo 'disabled';}?>>
                        <option > Select Status</option> 
                        <?php 
                            if(isset($_GET['ListType']))
                            {
                                $ListType=$_GET['ListType'];   if($ListType=='ProductList') {?>
                                    <option value="New Design">New Design</option>
                                    <option value="Design Exist">Design Exist</option>
                                    <option value="Edit Exist Design">Edit Exist Design</option>
                                <?php
                                }
                                else
                                {?>
                                    <option value="<?php if($show['DesignStatus'] == 'NULL') {echo "New";}else{echo $show['DesignStatus'];} ?>" selected >
                                        <?php if($show['DesignStatus'] == 'NULL') {echo "New";}else{echo $show['DesignStatus'];} ?>
                                    </option>
                                    <option value="Submit for design">Submit for design</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Sent For Approval">Sent For Approval</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Design Exist">Design Exist</option>
                                    <option value="Edit Exist Design">Edit Exist Design</option>
                                    <option value="No Print">No Print</option>
                                    <option value="Reject">Reject</option>
                                    <option value="Done">Done</option>
                                <?php
                                }
                            } 
                        ?>
                    </select>
                </div>
    
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 fw-bold">
                    <label for="DesignBy">Assign To</label>
                    <select name="DesignBy" id="DesignBy" class="form-select" <?php if($show['DesignStatus'] == 'Design Exist'){echo 'disabled';}?> required>
                        <option value="<?php if(isset($show['DesignerName1'])) echo $show['DesignerName1']; ?>" selected >   <?php if(isset($show['DesignerName1'])) echo $show['DesignerName1']; ?> </option>
                        <?php 
                            $EmpQuery=$Controller->QueryData("SELECT EmpName FROM employees WHERE EmpUnit='Design' and EmpJobStatus ='Active'",[]);
                            while($Row=$EmpQuery->fetch_assoc())  { ?>
                                <option value="<?=$Row['EmpName']?>"><?php echo $Row['EmpName'];?></option>
                        <?php } ?>
                    </select>
                                
                </div>
    
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 fw-bold">
                    <label for="">Design Name</label>
                    <input type="text" name="DesignName" class="form-control" readonly  value="<?php if(isset($Rows['ProductName'])) {echo $Rows['ProductName'];} elseif($ListType=='JobUnderProcess'){ echo $show['DesignName1']; } ?>">
                </div>
    
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 fw-bold">
                    <label for="">Design Code  </label>
                    <input type="text" name="DesignCode" class="form-control" onblur="this.value=removeSpaces(this.value);" value=" <?php if(isset($Rows['DesignCode1'])) {echo $Rows['DesignCode1'];}else{echo'';}?>"<?php if($Rows['DesignStatus'] == 'Design Exist'){echo 'disabled';}elseif($Rows['DesignCode1']!=''){echo 'readonly';}else{echo '';}?>>
                </div>
                <?php 
                    if(isset($_GET['ListType']))
                    {
                        $ListType=$_GET['ListType'];
                        if($ListType=='NewJob')
                        {?>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                                <label for="">Finish Time</label>
                                <input type="datetime-local" name="FinishTime" class="form-control"   value="" <?php if($Rows['DesignStatus'] == 'Design Exist'){ echo 'readonly'; }?> >
                            </div>
                        <?php
                        }
                    }              
                ?>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-1 fw-bold">
                    <label for="">Comment</label>
                    <input type="text" name="Comment" class="form-control" value="">
                </div>
            
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 fw-bold">
                    <label for="formFile" class="form-label"></label>
                    <input class="form-control" type="file" id="formFile" name="DesignImage" <?php if($Rows['DesignStatus'] == 'Design Exist'){ echo 'readonly'; } ?>>
                </div>

            
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-1 mb-5  fw-bold ">


            <div class = "text-end mt-3" >
                <?php 
                        if(isset($_REQUEST['ListType']))
                        {  
                            $ListType=$_GET['ListType']; 
                            if($ListType=='ProductList')  
                            { ?>
                                <button type="submit"  id="Update"  name="Update" class="btn btn-outline-primary fw-bold " style = "max-width:180px;">Update</button>
                            <?php 
                            }  
                            else
                            {?>

                            <?php  if(in_array( $Gate['SAVE_FOR_DESIGN_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?>
                                <button <?php if($Rows['DesignStatus'] == 'Design Exist'){echo 'readonly';}?>  type="submit"  id="SaveButton"  name="SaveforDesign" class="btn btn-outline-primary fw-bold" style = "max-width:180px;">Save for Design</button>
                            <?php } ?>
                                                    
                            <?php  if(in_array( $Gate['VIEW_SAVE_SUBMIT_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?>
                                <button type="submit"  id="SendToDesign"  name="Save&Submit" class="btn btn-outline-primary fw-bold" style = "max-width:180px;">Save & Submit</button>
                            <?php } ?>       
                            
                            <?php  
                            } 
                        }  
                ?>       
            </div>
        </div>

        </div>
    </div>
</form>

 
<script language="javascript" type="text/javascript">
    //The below removeSpace function is for triming the extra spaces from the fields of html input
    function removeSpaces(string) 
    {
        return string.split(' ').join('');
    }
</script>

<?php  require_once '../App/partials/Footer.inc'; ?>

