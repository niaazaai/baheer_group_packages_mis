<?php 
ob_start(); 
require_once '../App/partials/Header.inc'; 
$Gate = require_once  $ROOT_DIR . '/Auth/Gates/DESIGN_DEPT';
if(!in_array( $Gate['VIEW_DOWNLOAD_FILE_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized access reports page!" );
}

require_once '../App/partials/Menu/MarketingMenu.inc'; 
require '../Assets/Carbon/autoload.php'; ?>
<?php
if(isset($_REQUEST['ListType']))
{
    $ListType=$_REQUEST['ListType'];
   if($ListType=='Download Files')  $SQL="SELECT CTNId,JobNo,ProductName,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size ,designinfo.DesignCode1,designinfo.DesignImage,designinfo.DesignStatus,Designinfo.CaId,
              designinfo.OriginalFile FROM carton INNER JOIN designinfo ON designinfo.CaId=carton.CTNId  WHERE OriginalFile != '' OR OriginalFile IS NOT NULL";
   elseif($ListType=='Upload Files')   $SQL="SELECT CTNId,JobNo,ProductName,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size ,designinfo.DesignCode1,designinfo.DesignImage,designinfo.DesignStatus,Designinfo.CaId,
        designinfo.OriginalFile FROM carton INNER JOIN designinfo ON designinfo.CaId=carton.CTNId WHERE OriginalFile='' OR OriginalFile IS NULL";
    $DataRows=$Controller->QueryData($SQL,[]);
}
else
{
    $ListType="Download Files";
    $SQL="SELECT CTNId,JobNo,ProductName,CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size ,
    designinfo.DesignCode1,designinfo.DesignImage,designinfo.DesignStatus,Designinfo.CaId,
    designinfo.OriginalFile FROM carton INNER JOIN designinfo ON designinfo.CaId=carton.CTNId WHERE OriginalFile!='' OR OriginalFile IS NOT NULL";
    $DataRows=$Controller->QueryData($SQL,[]);
}
?>
 
 
<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <a class="btn btn-outline-primary   " href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                </svg>
                </a>  
                <svg width="40" height="40" viewBox="0 0 40 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M39.7952 34.2115L37.657 31.818C37.5266 31.672 37.3496 31.5898 37.1651 31.5898C36.9805 31.5898 36.8037 31.672 36.6731 31.818L36.3927 32.1319L34.4183 29.9217V25.5996C34.4183 25.2592 34.2208 24.9583 33.9308 24.8565L21.7261 20.5732C21.4788 20.4866 21.2091 20.5606 21.0261 20.7657C20.8429 20.9707 20.7766 21.2727 20.8542 21.5494L24.6804 35.2115C24.7713 35.5362 25.0403 35.7572 25.3442 35.7572H29.2054L31.1798 37.9674L30.8993 38.2813C30.7688 38.4274 30.6955 38.6255 30.6955 38.832C30.6955 39.0386 30.7688 39.2366 30.8993 39.3826L33.0375 41.7761C33.1732 41.9282 33.3513 42.0042 33.5294 42.0042C33.7075 42.0042 33.8855 41.9282 34.0214 41.7761L39.7952 35.3129C40.067 35.0086 40.067 34.5156 39.7952 34.2115ZM29.4935 34.1997H25.8551L23.0293 24.1096L27.0575 28.6189C26.8901 28.98 26.8003 29.3828 26.8003 29.8014C26.8003 30.4884 27.0393 31.1342 27.4732 31.6199C27.9211 32.1212 28.5094 32.372 29.0978 32.372C29.686 32.372 30.2745 32.1212 30.7224 31.6199C31.6182 30.6171 31.6182 28.9856 30.7224 27.9827C29.9981 27.1718 28.9067 27.0175 28.0418 27.5179L24.013 23.008L33.027 26.1713V30.2441C33.027 30.4506 33.1003 30.6488 33.2308 30.7948L35.409 33.2329L32.1636 36.8658L29.9854 34.4275C29.8549 34.2817 29.6781 34.1997 29.4935 34.1997ZM29.0977 28.7876C29.3298 28.7876 29.5618 28.8864 29.7385 29.0842C30.0917 29.4797 30.0917 30.1231 29.7385 30.5185C29.3851 30.9139 28.8106 30.914 28.4569 30.5185C28.1037 30.1231 28.1037 29.4797 28.4569 29.0842C28.6337 28.8864 28.8657 28.7876 29.0977 28.7876ZM33.5294 40.124L32.3751 38.832L37.1651 33.4699L38.3194 34.7621L33.5294 40.124Z" fill="black"/>
                    <path d="M27.1398 53.4959C25.8271 53.4959 24.7155 54.4757 24.3566 55.8162C19.1566 55.1971 14.2664 52.6058 10.5267 48.4704C6.78902 44.3374 4.41428 38.9002 3.79549 33.094C4.96325 32.6722 5.81062 31.4443 5.81062 29.9986C5.81062 28.5529 4.96325 27.325 3.79549 26.9031C4.41416 21.0968 6.78902 15.6596 10.5267 11.5266C14.2663 7.3915 19.156 4.80019 24.3558 4.181C24.7138 5.52303 25.826 6.50442 27.1398 6.50442C28.7418 6.50442 30.0452 5.04543 30.0452 3.25214C30.0452 1.45885 28.7418 0 27.1398 0C25.7775 0 24.6317 1.0553 24.3192 2.47379H10.4683V1.84044C10.4683 1.41028 10.1568 1.06167 9.77257 1.06167H7.25034C6.86606 1.06167 6.55464 1.41028 6.55464 1.84044V4.66383C6.55464 5.094 6.86606 5.4426 7.25034 5.4426H9.77257C10.1568 5.4426 10.4683 5.094 10.4683 4.66383V4.03119H18.6783C15.2777 5.3701 12.1505 7.54159 9.5488 10.4185C6.8085 13.4486 4.75986 17.1408 3.53947 21.1664V15.2573H4.10451C4.48879 15.2573 4.80021 14.9087 4.80021 14.4786V11.6552C4.80021 11.225 4.48879 10.8764 4.10451 10.8764H1.58228C1.198 10.8764 0.886575 11.225 0.886575 11.6552V14.4786C0.886575 14.9087 1.198 15.2573 1.58228 15.2573H2.14807V26.859C0.912127 27.233 0 28.4984 0 29.9984C0 31.4985 0.912253 32.7639 2.14807 33.1379V44.7395H1.58228C1.198 44.7395 0.886575 45.0881 0.886575 45.5183V48.3417C0.886575 48.7719 1.198 49.1205 1.58228 49.1205H4.10451C4.48879 49.1205 4.80021 48.7719 4.80021 48.3417V45.5183C4.80021 45.0881 4.48879 44.7395 4.10451 44.7395H3.53947V38.8304C4.75998 42.8559 6.8085 46.5481 9.5488 49.5782C12.153 52.458 15.284 54.6309 18.6885 55.9695H10.4683V55.3362C10.4683 54.906 10.1568 54.5574 9.77257 54.5574H7.25034C6.86606 54.5574 6.55464 54.906 6.55464 55.3362V58.1596C6.55464 58.5897 6.86606 58.9383 7.25034 58.9383H9.77257C10.1568 58.9383 10.4683 58.5897 10.4683 58.1596V57.5269H24.3193C24.632 58.9451 25.7776 60 27.1398 60C28.7418 60 30.0452 58.541 30.0452 56.7477C30.0452 54.9544 28.7418 53.4959 27.1398 53.4959ZM27.1398 1.55754C27.9746 1.55754 28.6538 2.31776 28.6538 3.25228C28.6538 4.1868 27.9746 4.94702 27.1398 4.94702C26.3049 4.94702 25.6258 4.1868 25.6258 3.25228C25.6258 2.31776 26.3049 1.55754 27.1398 1.55754ZM1.39127 29.9986C1.39127 29.0641 2.0704 28.3038 2.90525 28.3038C3.74009 28.3038 4.41921 29.0641 4.41921 29.9986C4.41921 30.9331 3.74009 31.6933 2.90525 31.6933C2.0704 31.6933 1.39127 30.933 1.39127 29.9986ZM27.1398 58.4427C26.3049 58.4427 25.6258 57.6825 25.6258 56.748C25.6258 55.8135 26.3049 55.0533 27.1398 55.0533C27.9746 55.0533 28.6538 55.8135 28.6538 56.748C28.6538 57.6825 27.9745 58.4427 27.1398 58.4427Z" fill="black"/>
                </svg>
                <?= $ListType;  ?>
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
            
	    </div><!-- Button trigger modal div end -->

    </div>
</div> 



<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <?php if( isset($_GET['msg']) && !empty($_GET['msg']) ) {    ?>
            
            <div class="alert alert-dismissible fade show shadow <?php if($_GET['class'] == 'danger') echo 'alert-danger'; else 'alert-success';  ?>" id = "page_alert" role="alert">
                <strong>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>  
                
                Information</strong> <?= $_GET['msg'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
</div>




<div class="card m-3">
    <div class="card-body">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <div class="row"> 
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 "> 
                        <div class="input-group" >
                            <select class="form-select d-block " style = " max-width: 30%;"   name="FieldType"   >
                                <option disabled >Select a Field </option>
                                <option value="DesignCode1">Design Code</option> 
                                <option value="ProductName "> Product Name </option>
                                <option value="CTNId"> Quot Number</option>
                                <option value="JobNo"> Job Number </option>
                            </select>
                            <input type="text" name = "SearchTerm"  aria-label="Write Search Term" class= "form-control" required  >  
                            <button type="submit" class="btn btn-outline-primary">Find</button>
                        </div>
                </div> <!-- END OF COL  -->
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  "></div>  
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12   ">
                    <select class = "form-select fw-bold" name="ListType" id="ListType" style = "border:3px solid black; " onchange = "this.form.submit();" > 
                        <option value="<?=$ListType;?>"> <?=$ListType;?> </option>
                         <?php  if(in_array( $Gate['VIEW_DOWNLAOD_FILE_OPTION'] , $_SESSION['ACCESS_LIST']  )) { ?><option value="Download Files">Download Files</option>  <?php } ?> 
                        <?php  if(in_array( $Gate['VIEW_UPLOAD_FILE_OPTION'] , $_SESSION['ACCESS_LIST']  )) { ?><option value="Upload Files">Upload Files</option>  <?php } ?> 
                    </select>
                </div>  
            </div>
        </form>
    </div>
</div>

<div class="card m-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-responsive">
                <thead class="table-info">
                    <tr>
                        <th>#</th>
                        <th>Quotation No</th>
                        <th>JobNo</th>
                        <th>Product Name</th>
                        <th>Size (L x W x H) cm</th>
                        <th>Design Code</th>
                        <th>OPS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $Count=1;
                        while($Rows=$DataRows->fetch_assoc())
                        {?>
                            <tr>
                                <td><?=$Count?></td>
                                <td><?=$Rows['CTNId']?></td>
                                <td><?=$Rows['JobNo']?></td>
                                <td><?=$Rows['ProductName']?></td>
                                <td><?=$Rows['Size']?></td>
                                <td><?=$Rows['DesignCode1']?></td>
                                <td>
                                <?php  if($ListType=='Download Files')  {
                                            // check if the file exist in the server 
                                            $class = 'primary'; 
                                            $file_to_download = '../Storage/Design/'. $Rows['OriginalFile'];
                                         
                                            if (!file_exists($file_to_download)) $class = 'danger'; 
                                ?>
                                    <a href="OriginalFileDownload.php?OriginalFile=<?=$Rows['OriginalFile']?>&CTNId=<?=$Rows['CTNId']?>" class="btn btn-outline-<?=$class;?> btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                        </svg>
                                    </a>
                                                <?php
                                                if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1'])) {?>
                                                    <a  class="btn btn-outline-warning btn-sm fw-bold"   style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                                    href="ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" > view  </a>
                                                <?php  
                                                }
                                        }
                                        elseif($ListType=='Upload Files') {?>
                                                <a href="OriginalFileUpload.php?CTNId=<?=$Rows['CTNId']?>&ProductName=<?=$Rows['ProductName']?>&DesignCode=<?=$Rows['DesignCode1']?>&ListType=<?=$ListType?>" 
                                                    class="btn btn-outline-primary fw-bold btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                                    </svg>
                                                </a>
                                            
                                        <?php } ?>  
                                </td>   
                            </tr>
                        <?php
                        $Count++;
                        } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    var fruits = document.getElementById("ListType");
    [].slice.call(fruits.options)
    .map(function(a){
        if(this[a.value]){ 
        fruits.removeChild(a); 
        } else { 
        this[a.value]=1; 
        } 
    },{});

    setTimeout(() => {
        document.getElementById('page_alert').style.display = 'none';
    }, 4000);
</script>




<?php  require_once '../App/partials/Footer.inc'; ?>